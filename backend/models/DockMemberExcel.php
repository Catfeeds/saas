<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/6/12
 * Time: 11:37
 */

namespace backend\models;

use common\models\base\DockMember;
use common\models\Excel;
use backend\models\DockLogExcel;
use backend\models\DockMemberCardExcel;
use backend\models\DockEmployeeExcel;
use backend\models\DockCourseOrderExcel;
use backend\models\DockCabinetExcel;
use backend\models\DockLeaveRecordExcel;
use backend\models\DockClassLogExcel;
use backend\models\DockCardChangeLogExcel;
use yii\base\Model;
use common\models\base\MemberDetails;
use common\models\base\MemberAccount;
use common\models\Member;
use Yii;
use common\models\Func;
class DockMemberExcel extends DockMember
{


    /**
     * @desc:
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/8
     * @time: 18:58
     * @param $filePath  文件路径
     * @param $type         类型
     * @param $filename     文件名称
     * @param $repeat     是否重复  1  2
     * @return bool|string
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \yii\db\Exception
     */
    public function  loadFileContent($filePath, $type, $filename, $repeat, $companyId){
        $model = new Excel();

        $data = $model->loadExcelFile($filePath, $type);
        if($data == 'error'){
            return '导入的模板与选择的类型不符合！';
        }
//        var_dump($data);die;
//        一次性最多导入2000条数据
        if(count($data) > 5000){
            return '一次性最多导入5000条数据';
        }

        if($type == 1){
            $DockEmployeeExcel = new DockEmployeeExcel();
            $re = $DockEmployeeExcel->organizeEmployeeData($data, $filename, $repeat, $companyId);
        }else if($type == 2){
            $re = $this->organizeData($data, $filename, $repeat, $companyId);
        }else if($type == 3){
            $DockMemberCardExcel = new DockMemberCardExcel();
            $re = $DockMemberCardExcel->organizeDockMemberCardData($data,$filename, $repeat, $companyId);
        }else if($type == 4){
            $DockCourseOrderExcel = new DockCourseOrderExcel();
            $re = $DockCourseOrderExcel->organizeCourseOrderData($data,$filename, $repeat, $companyId);
        }else if($type == 5){
            $DockCabinetExcel = new DockCabinetExcel();
            $re = $DockCabinetExcel->organizeCabinetData($data,$filename, $repeat, $companyId);
        }else if($type == 6){
            $DockLeaveRecordExcel = new DockLeaveRecordExcel();
            $re = $DockLeaveRecordExcel->organizeLeaveRecordData($data,$filename, $repeat, $companyId);
        }else if($type == 7){
            $DockClassLogExcel = new DockClassLogExcel();
            $re = $DockClassLogExcel->organizeClassLogData($data,$filename, $repeat, $companyId);
        }else if($type == 8){
            $DockCardChangeLogExcel = new DockCardChangeLogExcel();
            $re = $DockCardChangeLogExcel->organizeCardChangeLogData($data,$filename, $repeat, $companyId);
        }

        return $re;

    }


    /**
     * @desc:过滤和导入原始数据
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/8
     * @time: 16:40
     * @param $data
     * @param $filename
     * @param $repeat
     * @return bool|string
     * @throws \yii\db\Exception
     */
    public function organizeData($data,$filename, $repeat, $companyId){

        //数据去重复值
        if($repeat == 2){
            $temp = Func::arrDropRepeat($data);
        }else{
            $temp = $data;//不去重复
        }

        $arr = [];
        foreach ($temp as $key => $value){
            $arr[$key]['username'] = $value[0];
            $arr[$key]['mobile'] = (string)$value[1];
            $arr[$key]['first_in_time'] = $value[2] ? : null;
            $arr[$key]['company'] = $value[3];
            $arr[$key]['venue'] = $value[4];
            $arr[$key]['id_card'] = $value[5];
            $arr[$key]['card_type'] = $value[6];
            $arr[$key]['sex'] = $value[7];
            $arr[$key]['birth_date'] = $value[8] ? : null;
            $arr[$key]['email'] = $value[9];
            $arr[$key]['profession'] = $value[10];
            $arr[$key]['address'] = $value[11];
            $arr[$key]['source'] = $value[12];
            $arr[$key]['company_id'] = $companyId;
            //判断数据的有效性
            if(empty($arr[$key]['username']) || empty($arr[$key]['mobile']) || empty($arr[$key]['company']) || empty($arr[$key]['venue'])){
                $arr[$key]['check_status'] = 2;
            }else{
                $arr[$key]['check_status'] = 1;
            }
        }

        //过滤空数据
        foreach ($arr as $k => $v){
            if(empty($v['username']) && empty($v['mobile'])){
                unset($arr[$k]);
            }
        }

//        var_dump($arr);die;

        $transaction = \Yii::$app->db->beginTransaction();
        try{

            //数据的批量插入
            $fields = ['username', 'mobile', 'first_in_time', 'company', 'venue', 'id_card', 'card_type', 'sex', 'birth_date',
                'email', 'profession', 'address', 'source', 'company_id', 'check_status'];
            if($arr && $fields){
                Yii::$app->db->createCommand() ->batchInsert(DockMember::tableName(),$fields,$arr)->execute();
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
     * @desc:导入会员数据列表
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/8
     * @time: 19:23
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function memberList($params, $companyId){
        $keyword = !empty($params['keyword']) ? $params['keyword'] : '';
        $check_status = !empty($params['check_status']) ? $params['check_status'] : '';

        $query = DockMember::find()
            ->orderBy('id  DESC')
            ->where(['company_id' => $companyId, 'is_delete' => 0])
            ->asArray();
        //筛选条件
        if($keyword){
            $query->andFilterWhere([
                'or',
                ['like','username',$keyword],
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
     * @desc:会员信息编辑
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/8
     * @time: 20:32
     * @param $post
     * @return bool
     */
    public function memberEdit($post){

        $info = DockMember::findOne($post['id']);

        $info->username = $post['username'];
        $info->mobile = $post['mobile'];
        $info->first_in_time = $post['first_in_time'];
        $info->company = $post['company'];
        $info->venue = $post['venue'];
        $info->id_card = $post['id_card'];
        $info->card_type = $post['card_type'];
        $info->sex = $post['sex'];
        $info->birth_date = $post['birth_date'];
        $info->email = $post['email'];
        $info->profession = $post['profession'];
        $info->address = $post['address'];
        $info->source = $post['source'];
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
    public function memberModify($companyId){
        $id = 0;
        $limit = 10;

        while(true){
            $query = new \yii\db\Query();
            $result = $query->from(DockMember::tableName())
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

            foreach ($result as $key => $value){
                $is_require = false;
                $is_mobile = false;
                $is_card = false;
                $is_company = true;
                $is_venue = true;
                $is_repead = false;

                //验证必填项
                if($value['username'] && $value['mobile'] && $value['company'] && $value['venue'] ){
                    $is_require = true;
                }

                //验证手机号
                if(preg_match('/^1([0-9]{9})/',$value['mobile'])){
                    $is_mobile = true;
                }

                //验证身份证号、
                if($value['id_card'] && preg_match("/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X)$/", $value['id_card'])) {
                    $is_card = true;
                }

                if(empty($value['id_card'])){
                    $is_card = true;
                }

                $is_repead =  self::memberRepeat($companyId, $value['username'], $value['mobile']);

//            //校对公司名称
//            $is_company = $DockLogExcel::companyModify($companyId, $value['company']);
//            //校对场馆
//            $is_venue = $DockLogExcel::venueModify($companyId, $value['venue']);

                if($is_require && $is_mobile && $is_card && $is_company && $is_venue && $is_repead){

                    $correct[$key] = $value['id'];
                }else{
                    $error[$key] = $value['id'];
                }
            }

            if(!empty($correct)){
                DockMember::updateAll(['check_status' => 1],['in', 'id', array_values($correct)]);
            }

            if(!empty($error)){
                DockMember::updateAll(['check_status' => 2],['in', 'id', array_values($error)]);
            }

        }

        return true;
    }

    /**
     * @desc:数据同步
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/15
     * @time: 11:22
     * @param $companyId
     * @return bool
     * @throws \yii\base\Exception
     */
    public function memberDock($companyId){
        //查询正常数据
        $id = 0;
        $limit = 10;
        $ids = [];

        while (true) {
            $query = new \yii\db\Query();
            $result = $query->from(DockMember::tableName())
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

            foreach ($result as $key => $value) {
                $DockLogExcel = new DockLogExcel();
                $Member = new Member();
                $MemberDetails = new MemberDetails();
                $venue_id = $DockLogExcel::venueModify($companyId, $value['venue']);
                $Member->username = $value['username'];
                $Member->password = Yii::$app->security->generatePasswordHash(123456);
                $Member->mobile = $value['mobile'];
                $Member->register_time = time();
                $Member->status = 1;
                $Member->member_type = 1;
                $Member->venue_id = $venue_id != false ? $venue_id : 0;
                $Member->company_id = $value['company_id'];

                if($Member->save() && $Member->id){
                    $MemberDetails->member_id = $Member->id;
                    $MemberDetails->name = $value['username'];
                    $MemberDetails->sex = $DockLogExcel::sexId($value['sex']);
                    $MemberDetails->id_card = $value['id_card'];
                    $MemberDetails->birth_date = $value['birth_date'];
                    $MemberDetails->email = $value['email'];
                    $MemberDetails->profession = $value['profession'];
                    $MemberDetails->family_address = $value['address'];
                    $MemberDetails->now_address = $value['address'];
                    $MemberDetails->document_type = $DockLogExcel::idCardTypeId($value['card_type']);
                    $MemberDetails->created_at = time();

                    $MemberAccount = new MemberAccount();
                    $MemberAccount->username = $value['username'];
                    $MemberAccount->password = Yii::$app->security->generatePasswordHash(123456);
                    $MemberAccount->mobile = $value['mobile'];
                    $MemberAccount->company_id = $companyId;
                    $MemberAccount->create_at = time();

                    if($MemberDetails->save() && $MemberAccount->save()){
                        unset($Member, $MemberDetails, $MemberAccount);
                        $ids[$key] = $value['id'];
                    }

//                    if($MemberDetails->save() && $MemberDetails->id){
//                        unset($Member, $MemberDetails);
//                        $ids[$key] = $value['id'];
//                    }
                }
            }

            if($ids){
                DockMember::updateAll(['is_delete' => 1],['in', 'id', array_values($ids)]);
            }
        }
        return true;

    }

    /**判断会员是否重复
     * @param $companyId
     * @param $username
     * @param $mobile
     * @return bool
     */
    static public function memberRepeat($companyId, $username, $mobile){

        $num = DockMember::find()
            ->select('id')
            ->where(['company_id' => $companyId, 'username' => $username,'mobile' => $mobile])
            ->asArray()
            ->count();

        return $num >= 2 ? false : true;
    }



}