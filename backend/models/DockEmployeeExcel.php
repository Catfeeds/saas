<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/6/12
 * Time: 11:37
 */

namespace backend\models;

use common\models\base\DockEmployee;
use common\models\Excel;
use backend\models\DockLogExcel;
use yii\base\Model;
use common\models\Func;
use common\models\base\Employee;
use Yii;


class DockEmployeeExcel extends DockEmployee
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
    public function organizeEmployeeData($data,$filename, $repeat, $companyId){

        //数据去重复值
        if($repeat == 2){
            $temp = Func::arrDropRepeat($data);
        }else{
            $temp = $data;//不去重复
        }
        $arr = [];
        foreach ($temp as $key => $value){
            $arr[$key]['name'] = $value[0];
            $arr[$key]['sex'] = $value[1];
            $arr[$key]['mobile'] = (string)$value[2];
            $arr[$key]['email'] = $value[3];
            $arr[$key]['id_card'] = $value[4];
            $arr[$key]['birth_time'] = $value[5] ? : null;
            $arr[$key]['company'] = $value[6];
            $arr[$key]['venue'] = $value[7];
            $arr[$key]['department'] = $value[8];
            $arr[$key]['position'] = $value[9];
            $arr[$key]['status'] = $value[10];
            $arr[$key]['entry_date'] = $value[11] ? : null;
            $arr[$key]['leave_date'] = $value[12] ? : null;
            $arr[$key]['salary'] = (float)$value[13];
            $arr[$key]['intro'] = $value[14];
            $arr[$key]['work_date'] = $value[15] ? : null;
            $arr[$key]['company_id'] = $companyId;

            //判断数据的有效性
            if(empty($arr[$key]['name']) || empty($arr[$key]['mobile']) || empty($arr[$key]['venue']) || empty($arr[$key]['company']) || empty($arr[$key]['department']) || empty($arr[$key]['status']) ){
                $arr[$key]['check_status'] = 2;
            }else{
                $arr[$key]['check_status'] = 1;
            }
        }

//        var_dump($arr);die;
        //过滤空数据
        foreach ($arr as $k => $v){
            if(empty($v['name']) && empty($v['mobile'])){
                unset($arr[$k]);
            }
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try{

            //数据的批量插入
            $fields = ['name', 'sex', 'mobile', 'email', 'id_card', 'birth_time', 'company', 'venue', 'department',
                'position', 'status', 'entry_date', 'leave_date', 'salary', 'intro', 'work_date','company_id', 'check_status' ];
            if($arr && $fields){
                Yii::$app->db->createCommand() ->batchInsert(DockEmployee::tableName(),$fields,$arr)->execute();
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
     * @date: 2018/6/8
     * @time: 19:23
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function employeeList($params, $companyId){

        $keyword = !empty($params['keyword']) ? $params['keyword'] : '';
        $check_status = !empty($params['check_status']) ? $params['check_status'] : '';

        $query = DockEmployee::find()
            ->orderBy('id DESC')
            ->where(['company_id' => $companyId, 'is_delete' => 0])
            ->asArray();
        //筛选条件
        if($keyword){
            $query->andFilterWhere([
                'or',
                ['like','name',$keyword],
                ['like','mobile',$keyword],
                ['like','company',$keyword],
                ['like','venue',$keyword],
            ]);
        }
        $query->andFilterWhere(['check_status'=>$check_status]);
        $data  = Func::getDataProvider($query,12);

        return $data;
    }

    /**
     * @desc:数据编辑
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/12
     * @time: 19:27
     * @param $post
     * @return bool
     */
    public function employeeEdit($post){
        $info = DockEmployee::findOne($post['id']);

        $info->name = $post['name'];
        $info->sex = $post['sex'];
        $info->mobile = $post['mobile'];
        $info->email = $post['email'];
        $info->id_card = $post['id_card'];
        $info->birth_time = $post['birth_time'];
        $info->company = $post['company'];
        $info->venue = $post['venue'];
        $info->department = $post['department'];
        $info->position = $post['position'];
        $info->status = $post['status'];
        $info->entry_date = $post['entry_date'];
        $info->leave_date = $post['leave_date'];
        $info->salary = $post['salary'];
        $info->intro = $post['intro'];
        $info->work_date = $post['work_date'];
        $info->check_status = 1;

        if($info->save()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @desc:校对数据
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/13
     * @time: 20:17
     * @param $companyId
     * @return bool
     */
    public function employeeModify($companyId){
        $id = 0;
        $limit = 10;
        while(true){
            $query = new \yii\db\Query();
            $result = $query->from(DockEmployee::tableName())
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
            $correct = [];
            $error = [];
            $DockLogExcel = new DockLogExcel();

            foreach ($result as $key => $value){
                $is_require = false;
                $is_mobile = false;
                $is_card = false;
                $is_company = false;
                $is_venue = false;
                $is_department = false;

                //验证必填项
                if($value['name'] && $value['mobile'] && $value['venue'] && $value['company'] && $value['department'] && $value['status'] ){
                    $is_require = true;
                }

                //验证手机号
                if(preg_match('/^1([0-9]{9})/',$value['mobile'])){
                    $is_mobile = true;
                }

                //验证身份证号、
                if(preg_match("/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/", $value['id_card'])) {
                    $is_card = true;
                }

                //校对公司名称
                $is_company = $DockLogExcel::companyModify($companyId, $value['company']);
                //校对场馆
                $is_venue = $DockLogExcel::venueModify($companyId, $value['venue']);
                //校对部门
                $is_department = $DockLogExcel::departmentModify($companyId, $value['venue'], $value['department']);

                if($is_require && $is_mobile && $is_card && $is_company && $is_venue && $is_department && $value['check_status'] != 1){
                    $correct[$key] = $value['id'];
                }else if(($is_require == false || $is_mobile == false || $is_card == false ||  $is_company == false || $is_venue == false || $is_department == false) && $value['check_status'] != 2){
                    $error[$key] = $value['id'];
                }
            }

            if(!empty($correct)){
                DockEmployee::updateAll(['check_status' => 1],['in', 'id', array_values($correct)]);
            }

            if(!empty($error)){
                DockEmployee::updateAll(['check_status' => 2],['in', 'id', array_values($error)]);
            }
        }

        return true;
    }

    /**
     * @desc:数据同步
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 14:06
     * @param $companyId
     * @return bool
     * @throws \yii\db\Exception
     */
    public function employeeDock($companyId){

        $DockLogExcel = new DockLogExcel();

        $re = $DockLogExcel::organizationModify($companyId);

        if($re != true){
            return "请先完善组织框架";
        }

        $id = 0;
        $limit = 10;
        while(true){

            $query = new \yii\db\Query();
            $result = $query->from(DockEmployee::tableName())
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
                $venue_id = $DockLogExcel::venueModify($companyId, $value['venue']);

                $organization_id = $DockLogExcel::departmentModify($companyId, $value['venue'], $value['department']);
                $arr[$key]['company_id'] = $companyId;
                $arr[$key]['venue_id'] = $venue_id != false ? $venue_id : 0;
                $arr[$key]['name'] = $value['name'];
                $arr[$key]['sex'] = $DockLogExcel::sexId($value['sex']);
                $arr[$key]['mobile'] = $value['mobile'];
                $arr[$key]['email'] = $value['email'];
                $arr[$key]['birth_time'] = $value['birth_time'];
                $arr[$key]['organization_id'] = $organization_id != false ? $organization_id : 0;
                $arr[$key]['position'] = $value['position'];
                $arr[$key]['status'] = $DockLogExcel::employeeStatus($value['status']);
                $arr[$key]['salary'] = $value['salary'];
                $arr[$key]['intro'] = $value['intro'];
                $arr[$key]['is_check'] = 1;
                $arr[$key]['is_pass'] = 1;
                $arr[$key]['work_time'] = strtotime($value['work_date']) ?: 0;
                $arr[$key]['identityCard'] = $value['id_card'];
                $arr[$key]['entry_date'] = $value['entry_date'];
                $arr[$key]['leave_date'] = $value['leave_date'];
                $arr[$key]['create_id'] = 0;
            }

            unset($DockLogExcel);
            $fields = ['company_id', 'venue_id', 'name', 'sex', 'mobile', 'email', 'birth_time', 'organization_id', 'position', 'status', 'salary', 'intro', 'is_check', 'is_pass', 'work_time', 'identityCard', 'entry_date','leave_date', 'create_id'];

            if($fields && $arr){
                Yii::$app->db->createCommand() ->batchInsert(Employee::tableName(),$fields,$arr)->execute();
            }

            DockEmployee::updateAll(['is_delete' => 1],['in', 'id', array_column($result, 'id')]);

        }

        return true;

    }

}