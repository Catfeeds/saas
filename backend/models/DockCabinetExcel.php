<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/6/12
 * Time: 11:37
 */

namespace backend\models;

use common\models\base\DockCabinet;
use common\models\Excel;
use backend\models\DockLogExcel;
use yii\base\Model;
use common\models\Func;
use backend\models\Cabinet;
use backend\models\CabinetType;
use Yii;


class DockCabinetExcel extends DockCabinet
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
    public function organizeCabinetData($data,$filename, $repeat, $companyId){
        //数据去重复值
        if($repeat == 2){
            $temp = Func::arrDropRepeat($data);
        }else{
            $temp = $data;//不去重复
        }
        $arr = [];
        foreach ($temp as $key => $value){
            $arr[$key]['cabinet_name'] = $value[0];
            $arr[$key]['cabinet_number'] = (int)$value[1];
            $arr[$key]['status'] = (string)$value[2];
            $arr[$key]['start_time'] = $value[3] ? : null;
            $arr[$key]['end_time'] = $value[4] ? : null;
            $arr[$key]['consume_time'] = $value[5];
            $arr[$key]['price'] = (float)$value[6];
            $arr[$key]['behavior'] = $value[7];
            $arr[$key]['counselor_name'] = $value[8];
            $arr[$key]['cabinet_type'] = $value[9];
            $arr[$key]['company'] = $value[10];
            $arr[$key]['venue'] = $value[11];
            $arr[$key]['cabinet_model'] = $value[12];
            $arr[$key]['cabinet_cate'] = $value[13];
            $arr[$key]['day_rent_price'] = (float)$value[14];
            $arr[$key]['month_rent_price'] = (float)$value[15];
            $arr[$key]['year_rent_price'] = (float)$value[16];
            $arr[$key]['half_year_rent_price'] = (float)$value[17];
            $arr[$key]['deposit'] = (float)$value[18];
            $arr[$key]['give_month'] = $value[19];
            $arr[$key]['company_id'] = $companyId;

            //判断数据的有效性
            if(empty($arr[$key]['cabinet_name']) || empty($arr[$key]['cabinet_number']) || empty($arr[$key]['status']) || empty($arr[$key]['start_time']) || empty($arr[$key]['end_time']) || empty($arr[$key]['consume_time']) || empty($arr[$key]['price'])  || empty($arr[$key]['counselor_name']) || empty($arr[$key]['company']) || empty($arr[$key]['venue'])){
                $arr[$key]['check_status'] = 2;
            }else{
                $arr[$key]['check_status'] = 1;
            }
        }

        //过滤空数据
        foreach ($arr as $k => $v){
            if(empty($v['cabinet_name']) && empty($v['cabinet_number'])){
                unset($arr[$k]);
            }
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try{

            //数据的批量插入
            $fields = ['cabinet_name', 'cabinet_number', 'status', 'start_time', 'end_time', 'consume_time', 'price', 'behavior', 'counselor_name',
                'cabinet_type', 'company', 'venue', 'cabinet_model', 'cabinet_cate', 'day_rent_price', 'month_rent_price','year_rent_price','half_year_rent_price','deposit','give_month', 'company_id', 'check_status' ];
            if($arr && $fields){
                Yii::$app->db->createCommand() ->batchInsert(DockCabinet::tableName(),$fields,$arr)->execute();
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
     * @time: 17:33
     * @param $params
     * @param $companyId
     * @return \yii\data\ActiveDataProvider
     */
    public function cabinetList($params, $companyId){
        $keyword = !empty($params['keyword']) ? $params['keyword'] : '';
        $check_status = !empty($params['check_status']) ? $params['check_status'] : '';

        $query = DockCabinet::find()
            ->where(['company_id' => $companyId, 'is_delete' => 0])
            ->orderBy('id')
            ->asArray();
        //筛选条件
        if($keyword){
            $query->andFilterWhere([
                'or',
                ['like','cabinet_name',$keyword],
                ['like','cabinet_number',$keyword],
                ['like','company',$keyword],
                ['like','venue',$keyword],
            ]);
        }
        $query->andFilterWhere(['check_status'=>$check_status]);
        $data  = Func::getDataProvider($query,12);

        return $data;
    }

    /**柜子编辑
     * @param $post
     * @return bool
     */
    public function cabinetEdit($post){
        $info = DockCabinet::findOne($post['id']);

        $info->cabinet_name = $post['cabinet_name'];
        $info->cabinet_number = $post['cabinet_number'];
        $info->status = $post['status'];
        $info->start_time = $post['start_time'];
        $info->end_time = $post['end_time'];
        $info->consume_time = $post['consume_time'];
        $info->price = $post['price'];
        $info->behavior = $post['behavior'];
        $info->counselor_name = $post['counselor_name'];
        $info->cabinet_type = $post['cabinet_type'];
        $info->company = $post['company'];
        $info->venue = $post['venue'];
        $info->cabinet_model = $post['cabinet_model'];
        $info->cabinet_cate = $post['cabinet_cate'];
        $info->day_rent_price = $post['day_rent_price'];
        $info->month_rent_price = $post['month_rent_price'];
        $info->year_rent_price = $post['year_rent_price'];
        $info->half_year_rent_price = $post['half_year_rent_price'];
        $info->deposit = $post['deposit'];
        $info->give_month = $post['give_month'];
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
    public function cabinetModify($companyId){
        $query = DockCabinet::find()->where(['company_id' => $companyId, 'is_delete' => 0])->asArray()->all();
        $DockLogExcel = new DockLogExcel();
        if(empty($query)){
            return false;
        }
        $correct = [];
        $error = [];

        foreach ($query as $key => $value){
            $is_require = false;
            $is_company = false;
            $is_venue = false;
            $is_employee = false;

            //验证必填项
            if($value['cabinet_name'] && $value['cabinet_number'] && $value['status'] && $value['start_time'] && $value['end_time'] && $value['consume_time'] && $value['price'] && $value['counselor_name'] && $value['company'] && $value['venue'] ){
                $is_require = true;
            }

//            /校对公司名称
            $is_company = $DockLogExcel::companyModify($companyId, $value['company']);
            //校对场馆
            $is_venue = $DockLogExcel::venueModify($companyId, $value['venue']);
            //校对销售
            $is_employee = $DockLogExcel::employeeModify($companyId, $value['counselor_name']);

            if($is_require && $is_company && $is_venue && $is_employee && $value['check_status'] != 1){

                $correct[$key] = $value['id'];
            }else if(($is_require == false || $is_company == false || $is_venue == false || $is_employee == false )&&$value['check_status'] != 2){

                $error[$key] = $value['id'];
            }
        }

        if(!empty($correct)){
            DockCabinet::updateAll(['check_status' => 1],['in', 'id', array_values($correct)]);
        }

        if(!empty($error)){
            DockCabinet::updateAll(['check_status' => 2],['in', 'id', array_values($error)]);
        }

        return true;
    }

    /**数据同步
     * @param $companyId
     * @return bool|string
     * @throws \yii\db\Exception
     */
    public function cabinetDock($companyId){
        $DockLogExcel = new DockLogExcel();
        $admin_id = Yii::$app->user->identity->id;

        if($DockLogExcel::cabinetModify($companyId) != true){
            return "基本设置不完全！";
        }

        //查询正常数据
        $id = 0;
        $limit = 10;
        while (true) {
            $query = new \yii\db\Query();
            $result = $query->from(DockCabinet::tableName())
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
                $venue_id = $DockLogExcel::venueModify($companyId, $value['venue']);
                $cabinet_type_id = $DockLogExcel::cabinetTypeId($companyId, $value['cabinet_type']);
                $arr[$key]['cabinet_type_id'] = $cabinet_type_id != false ? $cabinet_type_id : 0;
                $arr[$key]['cabinet_number'] = $value['cabinet_number'];
                $arr[$key]['status'] = $DockLogExcel::cabinetStatus($value['status']);
                $arr[$key]['creater_id'] = $admin_id;//导入人ID
                $arr[$key]['dayRentPrice'] = $value['day_rent_price'];
                $arr[$key]['monthRentPrice'] = $value['month_rent_price'];
                $arr[$key]['yearRentPrice'] = $value['year_rent_price'];
                $arr[$key]['company_id'] = $value['company_id'];
                $arr[$key]['venue_id'] = $venue_id != false ? $venue_id : 0;
                $arr[$key]['cabinet_model'] = $DockLogExcel::cabinetModel($value['cabinet_model']);
                $arr[$key]['cabinet_type'] = $DockLogExcel::cabinetCate($value['cabinet_cate']);
                $arr[$key]['deposit'] = $value['deposit'];
                $arr[$key]['give_month'] = json_encode($value['give_month']);
                $arr[$key]['halfYearRentPrice'] = $value['half_year_rent_price'];
                $arr[$key]['created_at'] = time();
            }

            unset($DockLogExcel);

            $fields = ['cabinet_type_id', 'cabinet_number', 'status', 'creater_id', 'dayRentPrice', 'monthRentPrice', 'yearRentPrice', 'company_id', 'venue_id', 'cabinet_model', 'cabinet_type', 'deposit', 'give_month', 'halfYearRentPrice', 'created_at'];

            if ($fields && $arr) {
                Yii::$app->db->createCommand()->batchInsert(Cabinet::tableName(), $fields, $arr)->execute();
            }

            DockCabinet::updateAll(['is_delete' => 1], ['in', 'id', array_column($result, 'id')]);
        }

        return true;
    }


}