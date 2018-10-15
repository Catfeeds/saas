<?php
namespace backend\models;
use yii\base\Model;
class PrivateLesson extends   Model
{
    public $weekStart;     //周的开始时间
    public $weekEnd;       //周结束时间
    public $coachId;       //教练id
    /**
     * 后台 - 私课管理 - 获取私课会员预约详情
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/27
     * @param  $data
     * @param  $check
     * @return object     //返回指定日期会员预约详情
     */
    public function getPrivateClassData($data,$check){
        //初始化数据
        $this->autoLoad($data);
        $query =AboutClass::find()
                ->joinWith(["memberCourseOrderDetails"=>function($query){
                    $query->select("cloud_member_course_order_details.product_name");
                }],false)
                ->joinWith(["member"=>function($query){
                    $query->select("cloud_member.username");
                }],false)
            ->joinWith([
                'member'=>function($query){
                    $query->joinWith(['memberDetails memberDetails']);
                }
            ])
                ->where(["and",["cloud_about_class.coach_id"=>$this->coachId],["cloud_about_class.type"=>1]])
                ->andWhere(["between","cloud_about_class.class_date",$this->weekStart,$this->weekEnd])
               ->select("
                cloud_about_class.id,
                cloud_about_class.class_id,
                cloud_about_class.status,
                cloud_about_class.class_date,
                cloud_about_class.class_id,
                cloud_about_class.member_id,
                cloud_about_class.start as class_start,
                cloud_about_class.end as class_end,
                cloud_member.username,
                cloud_member_course_order_details.product_name")
                ->asArray()->all();
          $model        = new GroupClass();
          $arrangeData  = $model->getArrange($query,$this->weekStart,'group');
          $groupLeague  = new NewLeague();
          $arrangeData  = $groupLeague->getDataStatus($arrangeData);
          return  $arrangeData;
    }

    /**
     * 后台 - 团课条件加载判断- 判断 时间 是否前台发送过来的数据
     * @create 2017/5/27
     * @param  $data //array   包括 周开始时间 周结束时间 场馆id
     * @return boolean
     */
    public function autoLoad($data){
        $this->weekStart        = isset($data["weekStart"])&&!empty($data["weekStart"])?$data["weekStart"]:null;
        $this->weekEnd          = isset($data["weekEnd"])&&!empty($data["weekEnd"])?$data["weekEnd"]:null;
        $this->coachId          = isset($data["coachId"])&&!empty($data["coachId"])?$data["coachId"]:null;
        //时间数据判断
        if(empty($this->weekStart)||empty($this->weekEnd)){
            $this->getTimeWeek();
        }
    }
    /**
     * 后台 - 私课程表数据遍历 - 获取当前周的  开始日期和结束日期 （周一 到 周日）
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/27
     * @param
     * @return boolean
     */
    public  function getTimeWeek(){
        $nowDate = date("Y-m-d");
        $first=1;
        $w=date('w',strtotime($nowDate));
        $week_start=date('Y-m-d',strtotime("$nowDate -".($w ? $w - $first : 6).' days'));
        $week_end=date('Y-m-d',strtotime("$week_start +6 days"));
        $this->weekStart = $week_start;
        $this->weekEnd   = $week_end;
    }









}