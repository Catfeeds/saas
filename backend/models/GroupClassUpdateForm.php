<?php
namespace backend\models;
use yii\base\Model;

/**
 * @云运动 - 后台 - 团课修改表单验证
 * @author Houkaixin <Houkaixin @itsports.club>
 * @create 2017/4/19
 */
class GroupClassUpdateForm extends Model
{
   public $pic;
   public $classDate;
   public $groupClassId;
   public $courseId;
   public $coachId;
   public $classroomId;
   public $difficulty;
   public $classDesc;
   public $courseStart;
   public $courseEnd;
   public $classLimitTime;
   public $cancelLimitTime;
   public $leastPeople;

    /**
     * @云运动 - 后台 - 团课表单修改验证(规则验证)
     * @create 2017/4/8
     * @return array
     */
    public function rules()
    {
        return [
            [["groupClassId",'courseId', 'coachId', 'classroomId',"courseStart","courseEnd"], 'required'],
            [["groupClassId",'courseId','coachId','classroomId','difficulty'], 'integer'],
            [["classDesc","classLimitTime","cancelLimitTime","classDate","pic"],"safe"]
        ];
    }
    /**
     * 云运动 - 团课管理 - 点击修改单条信息
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/4/20
     * @param
     * @return boolean/object
     */
     public function updateData(){
         $start = strtotime($this->classDate.$this->courseStart);
         $end   = strtotime($this->classDate.$this->courseEnd);
         //团课数据信息修改
         $model = GroupClass::findOne($this->groupClassId);
         $model->course_id           = $this->courseId;
         $model->coach_id            = $this->coachId;
         $model->classroom_id        = $this->classroomId;
         $model->difficulty          = $this->difficulty;
         $model->desc                = $this->classDesc;
         $model->start               = $start ;
         $model->end                 = $end;
         $model->class_limit_time   = $this->classLimitTime;
         $model->cancel_limit_time  = $this->cancelLimitTime;
         $model->least_people       = $this->leastPeople;
         if($this->pic!=""){
             $model->pic             = $this->pic;
         }
         if ($model->save()) {
             return true;
         }else{
             return  $model->errors;
         }
     }




}