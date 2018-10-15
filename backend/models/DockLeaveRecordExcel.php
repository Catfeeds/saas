<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/6/12
 * Time: 11:37
 */

namespace backend\models;

use common\models\base\DockLeaveRecord;
use common\models\Excel;
use backend\models\DockLogExcel;
use backend\models\LeaveRecord;
use yii\base\Model;
use common\models\Func;
use Yii;
class DockLeaveRecordExcel extends DockLeaveRecord
{


    /**
     * @desc:过滤和导入原始数据
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/8
     * @time: 18:57
     * @param $data
     * @param $filename
     * @param $repeat
     * @return bool|string
     * @throws \yii\db\Exception
     */
    public function organizeLeaveRecordData($data,$filename, $repeat, $companyId){
        //数据去重复值
        if($repeat == 2){
            $temp = Func::arrDropRepeat($data);
        }else{
            $temp = $data;//不去重复
        }
        $arr = [];
        foreach ($temp as $key => $value){
            $arr[$key]['card_name'] = $value[0];
            $arr[$key]['card_number'] = (string)$value[1];
            $arr[$key]['check_time'] = $value[2] ? : null;
            $arr[$key]['start_time'] = $value[3] ? : null;
            $arr[$key]['end_time'] = $value[4] ? : null;
            $arr[$key]['leave_length'] = $value[5];
            $arr[$key]['note'] = $value[6];
            $arr[$key]['leave_property'] = $value[7];
            $arr[$key]['oper_name'] = $value[8];
            $arr[$key]['status'] = $value[9];
            $arr[$key]['company_id'] = $companyId;

            //判断数据的有效性
            if(empty($arr[$key]['card_number']) || empty($arr[$key]['card_name']) || empty($arr[$key]['check_time']) || empty($arr[$key]['start_time']) || empty($arr[$key]['end_time']) || empty($arr[$key]['leave_property']) || empty($arr[$key]['oper_name'])  || empty($arr[$key]['status']) ){
                $arr[$key]['check_status'] = 2;
            }else{
                $arr[$key]['check_status'] = 1;
            }
        }

        //过滤空数据
        foreach ($arr as $k => $v){
            if(empty($v['card_number']) && empty($v['card_name'])){
                unset($arr[$k]);
            }
        }


        $transaction = \Yii::$app->db->beginTransaction();
        try{

            //数据的批量插入
            $fields = ['card_name', 'card_number', 'check_time', 'start_time', 'end_time', 'leave_length', 'note', 'leave_property', 'oper_name', 'status', 'company_id' ,  'check_status'];
            if($arr && $fields){
                Yii::$app->db->createCommand() ->batchInsert(DockLeaveRecord::tableName(),$fields,$arr)->execute();
            }

            $DockLogExcel = new DockLogExcel();
            $DockLogExcel->dockLogAdd( $filename, $companyId);

            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }

        } catch (\Exception $e) {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            return  $e->getMessage();
        }

    }

    /**
     * @desc:导入y员工卡数据列表
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/13
     * @time: 17:32
     * @param $params
     * @param $companyId
     * @return \yii\data\ActiveDataProvider
     */
    public function leaveRecordList($params, $companyId){
        $keyword = !empty($params['keyword']) ? $params['keyword'] : '';
        $check_status = !empty($params['check_status']) ? $params['check_status'] : '';

        $query = DockLeaveRecord::find()
            ->where(['company_id' => $companyId, 'is_delete' => 0])
            ->orderBy('id DESC')
            ->asArray();
        //筛选条件
        if($keyword){
            $query->andFilterWhere([
                'or',
                ['like','card_number',$keyword],
                ['like','card_name',$keyword],
                ['like','oper_name',$keyword],
            ]);
        }
        $query->andFilterWhere(['check_status'=>$check_status]);
        $data  = Func::getDataProvider($query,12);

        return $data;
    }


    public function leaveRecordEdit($post){
        $info = DockLeaveRecord::findOne($post['id']);

        $info->card_number = $post['card_number'];
        $info->card_name = $post['card_name'];
        $info->check_time = $post['check_time'];
        $info->start_time = $post['start_time'];
        $info->end_time = $post['end_time'];
        $info->leave_length = $post['leave_length'];
        $info->note = $post['note'];
        $info->leave_property = $post['leave_property'];
        $info->oper_name = $post['oper_name'];
        $info->status = $post['status'];
        $info->check_status = 1;

        if($info->save()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @desc:数据校对
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/12
     * @time: 19:52
     * @return bool
     */
    public function leaveRecordModify($companyId){
        $query = DockLeaveRecord::find()->where(['company_id' => $companyId, 'is_delete' => 0])->asArray()->all();
        if(empty($query)){
            return false;
        }
        $correct = [];
        $error = [];

        foreach ($query as $key => $value){
            $DockLogExcel = new DockLogExcel();
            $is_require = false;
            $is_member = false;
            $is_card_id = false;

            //验证必填项
            if($value['card_number'] && $value['card_name'] && $value['check_time'] && $value['start_time'] && $value['end_time'] && $value['leave_length'] && $value['status'] ){
                $is_require = true;
            }

            //会员存在
            $is_member = $DockLogExcel::memberCardNumModify($companyId,$value['card_number']);

            //卡存在
            $is_card_id = $DockLogExcel::memberCardId($companyId,$value['card_number']);

            if($is_require && $is_member && $is_card_id && $value['check_status'] != 1){
                $correct[$key] = $value['id'];
            }else if(($is_require == false || $is_member == false || $is_card_id == false )&& $value['check_status'] != 2){
                $error[$key] = $value['id'];
            }
        }

        if(!empty($correct)){
            DockLeaveRecord::updateAll(['check_status' => 1],['in', 'id', array_values($correct)]);
        }

        if(!empty($error)){
            DockLeaveRecord::updateAll(['check_status' => 2],['in', 'id', array_values($error)]);
        }

        return true;
    }

    /**
     * @desc:数据同步
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 9:39
     * @param $companyId
     * @return bool
     * @throws \yii\db\Exception
     */
    public function leaveRecordDock($companyId){

        $DockLogExcel = new DockLogExcel();

        if($DockLogExcel::courseOrderModify($companyId) != true){
            return "基本设置不完全！";
        }

        $id = 0;
        $limit = 10;
        while(true){

            $query = new \yii\db\Query();
            $result = $query->from(DockLeaveRecord::tableName())
                ->where(['company_id' => $companyId, 'is_delete' => 0,'check_status' => 1])
                ->andWhere(['>', 'id', $id])
                ->orderBy('id asc')
                ->limit($limit)
                ->all();
            $resultCount = count($result);
            if ($resultCount == 0) {
                break;
            }
            $id = $result[$resultCount - 1]['id'];

            $arr = [];
            foreach ($result as $key => $value) {
                $DockLogExcel = new DockLogExcel();
                $member_id = $DockLogExcel::memberCardNumModify($companyId,$value['card_number']);
                $is_approval_id = $DockLogExcel::employeeModify($companyId, $value['oper_name']);
                $card_id = $DockLogExcel::memberCardId($companyId,$value['card_number']);

                $arr[$key]['leave_employee_id'] = $member_id != false ? $member_id : 0;
                $arr[$key]['note'] = $value['note'];
                $arr[$key]['type'] = $DockLogExcel::leaveStatus($value['status']);
                $arr[$key]['create_at'] = time();
                $arr[$key]['is_approval_id'] = $is_approval_id != false ? $is_approval_id : 0;
                $arr[$key]['leave_length'] = abs((int)$value['leave_length']);
                $arr[$key]['leave_start_time'] = strtotime($value['start_time']);
                $arr[$key]['leave_end_time'] = strtotime($value['end_time']);
                $arr[$key]['member_card_id'] = $card_id != false ? $card_id : 0;
                $arr[$key]['terminate_time'] = strtotime($value['end_time']);
                $arr[$key]['leave_type'] = $DockLogExcel::leaveRecordType($value['leave_property']);
                $arr[$key]['status'] = $DockLogExcel::leaveRecordStatus($value['status']);
            }

            unset($DockLogExcel);
            $fields = ['leave_employee_id', 'note', 'type', 'create_at', 'is_approval_id', 'leave_length', 'leave_start_time', 'leave_end_time', 'member_card_id', 'terminate_time', 'leave_type', 'status'];

            if($fields && $arr){
                Yii::$app->db->createCommand() ->batchInsert(LeaveRecord::tableName(),$fields,$arr)->execute();
            }

            DockLeaveRecord::updateAll(['is_delete' => 1],['in', 'id', array_column($result, 'id')]);

        }

        return true;

    }

    /**
     * @desc:艾博业务校对定制版
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/29
     * @time: 15:38
     * @param $companyId
     * @return bool
     */
    public function leaveRecordRevise($companyId){
        $id = 0;
        $limit = 10;

        while(true){
            $query = new \yii\db\Query();
            $result = $query->from(DockLeaveRecord::tableName())
                ->where(['company_id' => $companyId, 'is_delete' => 0])
                ->andWhere(['>', 'id', $id])
                ->orderBy('id asc')
                ->limit($limit)
                ->all();

            $resultCount = count($result);
            if ($resultCount == 0) {
                break;
            }
            $id = $result[$resultCount - 1]['id'];

            foreach ($result as $key => $item) {
                $info = DockLeaveRecord::findOne($item['id']);
                if($item['status'] == '已失效'){
                    $info->status = '已销假';
                }

                $info->leave_property = '正常请假';
                $info->save();
            }
        }
        return true;

    }


}