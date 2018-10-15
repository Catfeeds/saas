<?php


namespace backend\models;

use common\models\base\DockLog;
use yii\base\Model;
use common\models\base\Organization;
use common\models\base\Employee;
use common\models\base\Deal;
use common\models\Member;
use common\models\MemberCard;
use common\models\Course;
use common\models\base\CabinetType;
use common\models\CardCategory;
use common\models\ChargeClass;
use backend\models\MemberCourseOrder;
use backend\models\MemberCourseOrderDetails;
use common\models\relations\ChargeClassRelations;
use Yii;
class DockLogExcel extends DockLog
{


    /**私教课ID
     * @param $companyId
     * @param $member_id
     * @param $card_id
     * @param $class_name
     * @return int
     */
    static function memberCourseOrderId($companyId, $member_id, $card_id, $class_name){
        $ids = MemberCourseOrder::find()
            ->select('id')
            ->where(['product_name' => $class_name, 'company_id' => $companyId, 'member_card_id' => $card_id, 'member_id' => $member_id])
            ->column();
        return !empty($ids) ? $ids[0] : 0;
    }

    /**获取私教课程信息
     * @param $companyId
     * @param $name
     * @return array|null|\yii\db\ActiveRecord
     */
    static function chargeClassInfo($companyId,$name){
        $info = ChargeClass::find()
            ->alias('cc')
            ->select('cc.id, cpd.course_length, cc.pic, cc.describe, cc.product_type')
            ->joinWith(['coursePackageDetail cpd'], false)
            ->where(['cc.name' => $name, 'cc.company_id' => $companyId])
            ->asArray()
            ->one();

        return !empty($info) ? $info : [];
    }



    /**获取私教课程ID
     * @param $companyId
     * @param $name
     * @return bool
     */
    static function chargeClassId($companyId,$name){
        $ids = ChargeClass::find()
            ->select('id')
            ->where(['name' => $name, 'company_id' => $companyId])
            ->column();
        return !empty($ids) ? $ids[0] : false;
    }
    /**
     * @desc:假期状态
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/29
     * @time: 15:45
     * @param $name
     * @return false|int|string
     */
    static function leaveRecordStatus($name){
        $arr = ['1' => '假期中', '2' => '已销假'];
        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }

    /**
     * @desc:请假类型
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/29
     * @time: 15:43
     * @param $name
     * @return false|int|string
     */
    static function leaveRecordType($name){
        $arr = ['1' => '特殊请假', '2' => '正常请假', '3' => '学生请假'];
        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }

    /**
     * @desc:获取卡中类别
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/28
     * @time: 15:28
     * @param $companyId
     * @param $name
     * @return bool
     */
    static function cardCategoryInfo($companyId,$name ){

        $info = CardCategory::find()
            ->where(['card_name' => $name, 'company_id' => $companyId])
            ->one();
        return !empty($info) ?  $info : [];
    }

    /**
     * @desc:课程状态
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 15:25
     * @param $name
     * @return false|int|string
     */
    static function classStatus($name){
        $arr = ['1' => '未上课', '2' => '取消预约', '3' => '上课中', '4' => '下课', '5' => '过期', '6' => '旷课'];

        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }

    /**
     * @desc:获取柜子类型ID
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 14:48
     * @param $companyId
     * @param $name
     * @return bool
     */
    static function cabinetTypeId($companyId,$name){
        $ids = CabinetType::find()
            ->select('id')
            ->where(['type_name' => $name, 'company_id' => $companyId])
            ->column();

        return !empty($ids) ? $ids[0] : false;
    }


    /**
     * @desc:柜子状态
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 14:46
     * @param $name
     * @return false|int|string
     */
    static function cabinetStatus($name){
        $arr = ['1' => '未租', '2' => '已租', '3' => '维修中'];
        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }

    /**
     * @desc:柜子类别
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 14:31
     * @param $name
     * @return false|int|string
     */
    static function cabinetCate($name){
        $arr = ['1' => '临时', '2' => '正式'];
        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }

    /**
     * @desc:柜子类型
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 14:29
     * @param $name
     * @return false|int|string
     */
    static function cabinetModel($name){
        $arr = ['1' => '大柜', '2' => '中柜', '3' => '小柜'];
        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }


    /**
     * @desc:离职状态
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 13:58
     * @param $name
     * @return false|int|string
     */
    static function employeeStatus($name){
        $arr = ['1' => '在职', '2' => '离职'];
        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }

    /**
     * @desc:订单状态
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 11:04
     * @param $name
     * @return false|int|string
     */
    static function orderStatus($name){
        $arr = ['1' => '已付款', '2' => '已退款'];
        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }


    /**
     * @desc:收银类型
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 10:44
     * @param $name
     * @return false|int|string
     */
    static function cashierType($name){
        $arr = ['1' => '全款', '2' => '转让', '3' => '回款'];
        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }

    /**
     * @desc:课程是否共享
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 10:38
     * @param $name
     * @return false|int|string
     */
    static function isSameClass($name){
        $arr = ['1' => '同时上课', '2' => '不同时上课', '3' => '其它'];
        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }

    /**
     * @desc:课程上课方式
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 10:36
     * @param $name
     * @return false|int|string
     */
    static function classMode($name){
        $arr = ['1' => '单个教练', '2' => '多个教练', '3' => '其它'];
        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }

    /**
     * @desc:课程计费方式
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 10:34
     * @param $name
     * @return false|int|string
     */
    static function chargeMode($name){
        $arr = ['1' => '计次课程', '2' => '其它'];
        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }

    /**
     * @desc:课程类型
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 10:32
     * @param $name
     * @return false|int|string
     */
    static function courseType($name){
        $arr = ['1' => '私课', '2' => '团课'];
        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }

    /**
     * @desc:获取课程ID
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 10:27
     * @param $companyId
     * @param $name
     * @return bool
     */
    static function getCourseId($companyId,$name){
        $ids = Course::find()
            ->select('id')
            ->where(['name' => $name, 'company_id' => $companyId])
            ->column();

        return !empty($ids) ? $ids[0] : false;
    }

    /**
     * @desc:获取课程主要信息
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 11:23
     * @param $companyId
     * @param $name
     * @return array|bool|null|\yii\db\ActiveRecord
     */
    static function getCourseInfo($companyId,$name){

        $info = Course::find()
            ->select('id, pic, course_desrc, class_type')
            ->where(['name' => $name, 'company_id' => $companyId])
            ->asArray()
            ->one();

        return !empty($info) ? $info : false;
    }


    /**
     * @desc:获取卡ID
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 9:14
     * @param $companyId
     * @param $cardNumber
     * @return bool
     */
    static function memberCardId($companyId,$cardNumber){
        $ids = MemberCard::find()
            ->select('id')
            ->where(['card_number' => $cardNumber, 'company_id' => $companyId])
            ->column();
        return !empty($ids) ? $ids[0] : false;
    }

    /**
     * @desc:假期状态
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/16
     * @time: 11:52
     * @param $name
     * @return false|int|string
     */
    public function leaveStatus($name){
        $arr = ['1' => '待处理', '2' => '已同意', '3' => '已拒绝'];
        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }


    /**
     * @desc:卡属性
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/16
     * @time: 9:51
     * @param $name
     * @return false|int|string
     */
    static function cardAttributes($name){
        $arr = ['1' => '个人', '2' => '家庭', '3' => '公司'];
        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }

    /**
     * @desc:会员卡计次方式
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/16
     * @time: 9:45
     * @param $name
     * @return false|int|string
     */
    static function  countMethod($name){
        $arr = ['1' => '按时效', '2' => '按次数'];
        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }

    /**
     * @desc:获取会员ID
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/16
     * @time: 11:43
     * @param $companyId
     * @param $cardNumber
     * @return bool
     */
    static function memberCardNumModify($companyId,$cardNumber){
        $memberIds = MemberCard::find()
            ->select('member_id')
            ->where(['card_number' => $cardNumber, 'company_id' => $companyId])
            ->column();
        return !empty($memberIds) ? $memberIds[0] : false;
    }

    /**
     * @desc:卡状态
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/16
     * @time: 9:30
     * @param $name
     * @return false|int|string
     */
    static function memberCardStatus($name){
        $arr = ['1' => '正常', '2' => '异常', '3' => '冻结', '4' => '未激活', '5' => '挂起', '6' => '过期'];

        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }

    /**
     * @desc:证件类型
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/14
     * @time: 20:31
     * @param $name
     * @return false|int|string
     */
    static function  idCardTypeId($name){
        $arr = ['1' => '身份证', '2' => '居住证', '3' => '签证', '4' => '护照', '5' => '户口本', '6' => '军人证'];

        $re = array_search($name,$arr,true);
        return $re != false ? $re : 0;
    }

    /**
     * @desc:性别
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/14
     * @time: 20:27
     * @param $name
     * @return bool|false|int|string
     */
    static function sexId($name){
        $arr = ['1' => '男', '2' => '女', '3' => '保密'];
        $re = array_search($name,$arr,true);

        return $re != false ? $re : 0;
    }

    /**
     * @desc:会员卡状态验证
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/14
     * @time: 10:41
     * @param $memberStatus
     * @return bool
     */
    static function memberCardStatusModify($memberStatus){

        $arr = ['正常','冻结','异常','未激活', '挂起', '已过期'];
        return in_array($memberStatus, $arr) == true ? true : false;
    }

    /**
     * @desc:校对该会员是否存在
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/14
     * @time: 10:34
     * @param $companyId
     * @param $venueName
     * @param $memberName
     * @return bool
     */
    static function memberNameModify($companyId, $venueName, $memberName){

        $venueIds = self::getVenueId($companyId, $venueName);

        $memberIds = Member::find()
            ->select('id')
            ->where(['in', 'venue_id', $venueIds])
            ->where(['company_id' => $companyId, 'username' => $memberName])
            ->column();

        return !empty($memberIds) ? $memberIds[0] : false;
    }

    /**
     * @desc:校对会员卡合同
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/14
     * @time: 10:02
     * @param $companyId
     * @param $venueName
     * @param $dealName
     * @return bool
     */
    static function dealModify($companyId, $venueName, $dealName){
        //场馆ID

        if(empty($venueName)){
            $id = Deal::find()
                ->select('id')
                ->where(['company_id' => $companyId, 'name' => $dealName])
                ->column();
        }else{
            $venueIds = self::getVenueId($companyId, $venueName);
            $id = Deal::find()
                ->select('id')
                ->where(['in', 'venue_id', $venueIds])
                ->where(['company_id' => $companyId, 'name' => $dealName])
                ->column();
        }

        return !empty($id) ? $id[0] : false;
    }

    /**
     * @desc:校对销售人员
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/13
     * @time: 20:30
     * @param $companyId
     * @param $name
     * @return bool 或者职工的ID
     */
    static function employeeModify($companyId, $name){
        $id = Employee::find()
            ->select('id')
            ->where(['company_id' => $companyId, 'name' => $name])
            ->column();

        return !empty($id) ? $id[0] : false;
    }

    /**
     * @desc:校对员工部门
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/14
     * @time: 9:42
     * @param $companyId
     * @param $venueName
     * @param $departmentName
     * @return bool
     */
    static function departmentModify($companyId, $venueName, $departmentName){

        $venueIds = self::getVenueId($companyId, $venueName);
        $departmentIds = Organization::find()
            ->select('id')
            ->where(['in', 'pid', $venueIds])
            ->andWhere(['name' => $departmentName])
            ->column();
        return !empty($departmentIds) ? $departmentIds[0] : false;
    }

    /**
     * @desc:校验场馆
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/13
     * @time: 20:03
     * @param $companyId
     * @param $name
     * @return bool
     */
    static function venueModify($companyId, $name){

        $venueIds = self::getVenueId($companyId, $name);

        return !empty($venueIds) ? $venueIds[0] : false;
    }


    /**
     * @desc:校对公司
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/13
     * @time: 19:52
     * @param $companyId
     * @param $name
     * @return bool
     */
    static function companyModify($companyId, $name){

        $id = Organization::find()
            ->select('id')
            ->where(['id' => $companyId, 'name' => $name])
            ->column();
        return !empty($id) ? $id[0] : false;

    }

    /**
     * @desc:校对会员卡导入前设置
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/21
     * @time: 20:35
     * @param $companyId
     * @return bool
     */
    static function memberCardModify($companyId){

        $info = Organization::findOne($companyId);
        $list = Employee::find()->select('id')->where(['company_id' => $companyId])->asArray()->one();
        $lists = Member::find()->select('id')->where(['company_id' => $companyId])->asArray()->one();

        return (!empty($info) && !empty($list) && !empty($lists)) ? true : false;
    }

    /**
     * @desc:校对订单导入前设置
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/22
     * @time: 14:43
     * @param $companyId
     * @return bool
     */
    static function courseOrderModify($companyId){
        $re = self::memberCardModify($companyId);//
        $course = Course::find()->select('id')->where(['company_id' => $companyId])->asArray()->one();
        $deal = Deal::find()->select('id')->where(['company_id' => $companyId])->asArray()->one();
        $MemberCard = MemberCard::find()->select('id')->where(['company_id' => $companyId])->asArray()->one();

        return (!empty($re) && !empty($course) && !empty($deal) && !empty($MemberCard)) ? true : false;
    }

    /**
     * @desc:
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/22
     * @time: 14:47
     * @param $companyId
     * @return bool
     */
    static function cabinetModify($companyId){
        $info = CabinetType::find()->select('id')->where(['company_id' => $companyId])->asArray()->one();
        return !empty($info) ? true : false;
    }


    /**
     * @desc:校对组织框架是否存在
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/21
     * @time: 20:27
     * @param $companyId
     * @return bool
     */
    static function organizationModify($companyId){
        $info = Organization::findOne($companyId);

        return !empty($info) ? true : false;
    }


    /**
     * @desc:获取场馆id
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/14
     * @time: 10:19
     * @param $companyId
     * @param $venueName
     * @return bool
     */
    private function getVenueId($companyId, $venueName){
        $venueIds = Organization::find()
            ->select('id')
            ->where(['pid' => $companyId, 'name' => $venueName])
            ->column();

        return !empty($venueIds) ? $venueIds : [];
    }

    /**
     * @desc:EXCEl导入日志记录表
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/8
     * @time: 19:00
     * @param $filename
     * @return bool
     */
    public function dockLogAdd( $filename, $companyId){
        $admin_id                    = \Yii::$app->user->identity->id;
        $this->admin_id = $admin_id;
        $this->filename = $filename;//$companyId
        $this->company_id = $companyId;

        if($this->save()){
            return true;
        }else{
            return false;
        }

    }

    /**
     * @desc:导入日志列表
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/13
     * @time: 19:17
     * @param $companyId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function dockList($companyId){
        $list = DockLog::find()
            ->alias('d')
            ->joinWith(['admin  a'], false)
            ->select('d.admin_id, d.filename, d.created_at, a.username')
            ->where(['d.company_id' => $companyId, 'd.is_delete' => 0])
            ->orderBy('d.created_at  DESC')
            ->limit(10)
            ->asArray()
            ->all();

        return $list;
    }


}