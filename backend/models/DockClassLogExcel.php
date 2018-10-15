<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/6/12
 * Time: 11:37
 */

namespace backend\models;

use common\models\base\DockClassLog;
use common\models\Excel;
use backend\models\DockLogExcel;
use yii\base\Model;
use common\models\Func;
use common\models\base\AboutClass;
use Yii;


class DockClassLogExcel extends DockClassLog
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
    public function organizeClassLogData($data,$filename, $repeat, $companyId){
        //数据去重复值
        if($repeat == 2){
            $temp = Func::arrDropRepeat($data);
        }else{
            $temp = $data;//不去重复
        }
        $arr = [];
        foreach ($temp as $key => $value){
            $arr[$key]['username'] = $value[0];
            $arr[$key]['card_number'] = (string)$value[1];
            $arr[$key]['class_name'] = (string)$value[2];
            $arr[$key]['coach_name'] = $value[3];
            $arr[$key]['time_long'] = $value[4];
            $arr[$key]['reserver_date'] = $value[5] ? : null;
            $arr[$key]['start_date'] = $value[6] ? : null;
            $arr[$key]['end_date'] = $value[7] ? : null;
            $arr[$key]['class_type'] = $value[8];
            $arr[$key]['status'] = $value[9];
            $arr[$key]['company_id'] = $companyId;

            //判断数据的有效性
            if(empty($arr[$key]['username']) || empty($arr[$key]['card_number']) || empty($arr[$key]['coach_name']) || empty($arr[$key]['time_long']) || empty($arr[$key]['reserver_date']) || empty($arr[$key]['start_date']) || empty($arr[$key]['end_date']) ){
                $arr[$key]['check_status'] = 2;
            }else{
                $arr[$key]['check_status'] = 1;
            }
        }

        //过滤空数据
        foreach ($arr as $k => $v){
            if(empty($v['username']) && empty($v['card_number']) && empty($v['coach_name'])){
                unset($arr[$k]);
            }
        }

//        var_dump($arr);die;
        $transaction = \Yii::$app->db->beginTransaction();
        try{

            //数据的批量插入
            $fields = ['username', 'card_number', 'class_name', 'coach_name', 'time_long', 'reserver_date', 'start_date', 'end_date', 'class_type', 'status', 'company_id' ,  'check_status'];
            if($arr && $fields){
                Yii::$app->db->createCommand() ->batchInsert(DockClassLog::tableName(),$fields,$arr)->execute();
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
    public function classLogList($params, $companyId){
        $keyword = !empty($params['keyword']) ? $params['keyword'] : '';
        $check_status = !empty($params['check_status']) ? $params['check_status'] : '';

        $query = DockClassLog::find()
            ->where(['company_id' => $companyId, 'is_delete' => 0])
            ->orderBy('id DESC')
            ->asArray();
        //筛选条件
        if($keyword){
            $query->andFilterWhere([
                'or',
                ['like','username',$keyword],
                ['like','card_number',$keyword],
                ['like','class_name',$keyword],
                ['like','coach_name',$keyword],
            ]);
        }
        $query->andFilterWhere(['check_status'=>$check_status]);
        $data  = Func::getDataProvider($query,12);

        return $data;
    }


    public function classLogEdit($post){
        $info = DockClassLog::findOne($post['id']);

        $info->username = $post['username'];
        $info->card_number = $post['card_number'];
        $info->class_name = $post['class_name'];
        $info->coach_name = $post['coach_name'];
        $info->time_long = $post['time_long'];
        $info->reserver_date = $post['reserver_date'];
        $info->start_date = $post['start_date'];
        $info->end_date = $post['end_date'];
        $info->status = $post['status'];
        $info->class_type = $post['class_type'];
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
    public function classLogModify($companyId){
        $query = DockClassLog::find()->where(['company_id' => $companyId, 'is_delete' => 0])->asArray()->all();

        if(empty($query)){
            return false;
        }
        $correct = [];
        $error = [];
        foreach ($query as $key => $value){
            $is_require = false;

            //验证必填项
            if($value['username'] && $value['card_number'] && $value['coach_name'] && $value['time_long'] && $value['reserver_date'] && $value['start_date'] && $value['end_date'] ){
                $is_require = true;
            }

            if($is_require && $value['check_status'] != 1){
                $correct[$key] = $value['id'];
            }else if(($is_require == false) && $value['check_status'] != 2){
                $error[$key] = $value['id'];
            }
        }

        if(!empty($correct)){
            DockClassLog::updateAll(['check_status' => 1],['in', 'id', array_values($correct)]);
        }

        if(!empty($error)){
            DockClassLog::updateAll(['check_status' => 2],['in', 'id', array_values($error)]);
        }

        return true;
    }

    /**
     * @desc:数据同步
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 15:32
     * @param $companyId
     * @return bool
     * @throws \yii\db\Exception
     */
    public function classLogDock($companyId){
        $DockLogExcel = new DockLogExcel();

        if($DockLogExcel::courseOrderModify($companyId) != true){
            return "基本设置不完全！";
        }

        //查询正常数据
        $id = 0;
        $limit = 10;
        while (true) {
            $query = new \yii\db\Query();
            $result = $query->from(DockClassLog::tableName())
                ->where(['company_id' => $companyId, 'is_delete' => 0, 'check_status' => 1])
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
                $card_id = $DockLogExcel::memberCardId($companyId,$value['card_number']);
                $employee_id = $DockLogExcel::employeeModify($companyId, $value['coach_name']);

                $arr[$key]['member_card_id'] = $card_id != false ? $card_id : 0;
                $arr[$key]['class_id'] = $DockLogExcel::memberCourseOrderId($companyId,$member_id,$card_id,$value['class_name']);
                $arr[$key]['status'] = $DockLogExcel::classStatus($value['status']);
                $arr[$key]['type'] = $DockLogExcel::courseType($value['class_type']);
                $arr[$key]['coach_id'] = $employee_id != false ? $employee_id : 0;
                $arr[$key]['start'] = strtotime($value['start_date']) ?: 0;
                $arr[$key]['end'] = strtotime($value['end_date']) ?: 0;
                $arr[$key]['member_id'] = $member_id != false ? $member_id : 0;
                $arr[$key]['is_read'] = 1;

            }

            unset($DockLogExcel);

            $fields = ['member_card_id', 'class_id', 'status', 'type', 'coach_id', 'start', 'end', 'member_id', 'is_read'];

            if ($fields && $arr) {
                Yii::$app->db->createCommand()->batchInsert(AboutClass::tableName(), $fields, $arr)->execute();
            }

            DockClassLog::updateAll(['is_delete' => 1], ['in', 'id', array_column($result, 'id')]);
        }

        return true;
    }
}