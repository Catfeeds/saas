<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/6/12
 * Time: 11:37
 */

namespace backend\models;

use common\models\base\DockCardChangeLog;
use common\models\Excel;
use backend\models\DockLogExcel;
use yii\base\Model;
use common\models\Func;
use Yii;


class DockCardChangeLogExcel extends DockCardChangeLog
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
    public function organizeCardChangeLogData($data,$filename, $repeat, $companyId){
        //数据去重复值
        if($repeat == 2){
            $temp = Func::arrDropRepeat($data);
        }else{
            $temp = $data;//不去重复
        }
        $arr = [];
        foreach ($temp as $key => $value){
            $arr[$key]['old_card_number'] = (string)$value[0];
            $arr[$key]['behavior'] = $value[1];
            $arr[$key]['new_card_number'] = (string)$value[2];
            $arr[$key]['behavior_money'] = (float)$value[3];
            $arr[$key]['consume_date'] = $value[4] ? : null;
            $arr[$key]['casd_number'] = (string)$value[5];
            $arr[$key]['counselor_name'] = $value[6];
            $arr[$key]['note'] = $value[7];
            $arr[$key]['company_id'] = $companyId;

            //判断数据的有效性
            if(empty($arr[$key]['old_card_number']) || empty($arr[$key]['behavior']) || empty($arr[$key]['new_card_number']) || empty($arr[$key]['counselor_name']) ){
                $arr[$key]['check_status'] = 2;
            }else{
                $arr[$key]['check_status'] = 1;
            }
        }

        //过滤空数据
        foreach ($arr as $k => $v){
            if(empty($v['old_card_number']) && empty($v['behavior']) && empty($v['new_card_number'])){
                unset($arr[$k]);
            }
        }

//        var_dump($arr);die;
        $transaction = \Yii::$app->db->beginTransaction();
        try{

            //数据的批量插入
            $fields = ['old_card_number', 'behavior', 'new_card_number', 'behavior_money', 'consume_date', 'casd_number', 'counselor_name', 'note', 'company_id' , 'check_status'];
            if($arr && $fields){
                Yii::$app->db->createCommand() ->batchInsert(DockCardChangeLog::tableName(),$fields,$arr)->execute();
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
    public function cardChangeLogList($params, $companyId){
        $keyword = !empty($params['keyword']) ? $params['keyword'] : '';
        $check_status = !empty($params['check_status']) ? $params['check_status'] : '';

        $query = DockCardChangeLog::find()
            ->where(['company_id' => $companyId, 'is_delete' => 0])
            ->orderBy('id')
            ->asArray();
        //筛选条件
        if($keyword){
            $query->andFilterWhere([
                'or',
                ['like','old_card_number',$keyword],
                ['like','new_card_number',$keyword],
                ['like','counselor_name',$keyword],
                ['like','casd_number',$keyword],
            ]);
        }
        $query->andFilterWhere(['check_status'=>$check_status]);
        $data  = Func::getDataProvider($query,12);

        return $data;
    }


    public function cardChangeLogEdit($post){
        $info = DockCardChangeLog::findOne($post['id']);

        $info->old_card_number = $post['old_card_number'];
        $info->behavior = $post['behavior'];
        $info->new_card_number = $post['new_card_number'];
        $info->behavior_money = (float)$post['behavior_money'];
        $info->consume_date = $post['consume_date'];
        $info->casd_number = $post['casd_number'];
        $info->counselor_name = $post['counselor_name'];
        $info->note = $post['note'];
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
    public function cardChangeLogModify($companyId){

        $query = DockCardChangeLog::find()->where(['company_id' => $companyId, 'is_delete' => 0])->asArray()->all();
        if(empty($query)){
            return false;
        }
        $correct = [];
        $error = [];
        foreach ($query as $key => $value){
            $is_require = false;

            //验证必填项
            if($value['old_card_number'] && $value['behavior'] && $value['new_card_number'] && $value['counselor_name'] ){
                $is_require = true;
            }

            if($is_require  && $value['check_status'] != 1){
                $correct[$key] = $value['id'];
            }else if($value['check_status'] != 2){
                $error[$key] = $value['id'];
            }
        }

        if(!empty($correct)){
            DockCardChangeLog::updateAll(['check_status' => 1],['in', 'id', array_values($correct)]);
        }

        if(!empty($error)){
            DockCardChangeLog::updateAll(['check_status' => 2],['in', 'id', array_values($error)]);
        }
        return true;
    }


    public function cardChangeLogDock($companyId)
    {
        //查询正常数据
        $DockLogExcel = new DockLogExcel();

        if($DockLogExcel::courseOrderModify($companyId) != true){
            return "基本设置不完全！";
        }
        return false;
    }
}