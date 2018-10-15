<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/5/13
 * Time: 11:05
 */
namespace backend\models;
use common\models\base\MissAboutSet;
use yii\base\Model;
class MissAboutSetForm extends Model
{
    // 第一次冻结
    public $freezeWay;            //冻结方式
    public $missAboutTimes;      //爽约次数
    public $punishMoney;        // 处罚金额
    public $freezeNumDay;       // 冻结天数
    /**
     * 云运动 - 后台 - 爽约预约设置rule验证
     * @author houkaixin<houkaixin@itsports.club>
     * @create 2017/9/18
     * @return array
     */
    public function rules()
    {
        return [
             [[ "freezeWay"],"required",'message' => '冻结方式不能为空'],
             [[ "missAboutTimes"],"required",'message' => '每月爽约次数不能为空'],
             [[ "punishMoney","freezeNumDay"],'safe']
        ];
    }
    /**
     * 云运动 - 后台 - 爽约预约设置规则
     * @author Houkaixin<Houkaixin@itsports.club>
     * @param $venueId     // 场馆id
     * @param $companyId   // 公司id
     * @create 2017/9/18
     * @return boolean
     */
    public function addMissAboutSet($companyId,$venueId){
       // 查询该场馆是否 已有预约设置
       $result =  $this->checkFreezeMode($venueId);
//       if($result===false){
//          return "该场馆已经设置过了";
//       }
       // 第一次预约设
       $model = ($result===true)?new MissAboutSet():MissAboutSet::findOne(["venue_id"=>$venueId]);
       // 批量修改  会员卡状态
       $this->freezeMemberCard($model,$venueId);
       $model->course_type       = 1;
       $model->freeze_way        = $this->freezeWay;       // 冻结方式
       $model->miss_about_times = $this->missAboutTimes;  // 爽约次数
       $model->company_id        = $companyId;
       $model->venue_id          = $venueId;
       $model->create_at         = time();
       $model->punish_money      = empty($this->punishMoney)?null:$this->punishMoney;  //处罚金额
       $model->freeze_day        = empty($this->freezeNumDay)?null:$this->freezeNumDay;  //冻结天数
       if(!$model->save()){
           return  $model->errors;
       }
       return true;
    }
    /**
     * 云运动 - 后台 -  查询该场馆是否已有冻结设置
     * @author Houkaixin<Houkaixin@itsports.club>
     * @param $venueId     // 场馆id
     * @create 2017/9/18
     * @return boolean
     */
    public function checkFreezeMode($venueId){
         $data = MissAboutSet::findOne(["venue_id"=>$venueId]);
         if(empty($data)){
             return true;
         }
         return false;
    }
    /**
     * 云运动 - 后台 -  批量冻结会员卡逻辑
     * @author Houkaixin<Houkaixin@itsports.club>
     * @param $model     // 代码优化
     * @param $venueId  // 场馆id
     * @create 2017/9/18
     * @return boolean
     */
    public function freezeMemberCard($model,$venueId){
        /**
        if(isset($model->id)&&($this->missAboutTimes<$model->miss_about_times)){
            // 批量冻结会员卡
            MemberCard::updateAll(["status"=>3,"last_freeze_time"=>time(),"recent_freeze_reason"=>1],["and",["status"=>1],[">=","absentTimes",$this->missAboutTimes],["venue_id"=>$venueId]]);

        }*/
        //修改当前场馆所有会员卡爽约次数为0
        \common\models\MemberCard::updateAll(['absentTimes'=>0,'last_freeze_time'=>time()],["and",["venue_id"=>$venueId],['<>',"status",3],['<>',"recent_freeze_reason",1]]);
    }



}