<?php
namespace backend\modules\v1\models;

use common\models\Func;

class MyAboutClass extends \common\models\AboutClass
{
    public function fields()
    {
        $fields = [
            'id',

            'status' => function ($model) {
                return $model->getStatus();
            },

            'type',

            'coach' => function ($model) {
                return Func::getRelationVal($model, 'employee', 'name');
            },

            'start',

            'end',

            'is_read',

            'create_at',

            'cancel_time',

            'class_info',

        ];

        if($this->type == '2'){
            $fields['class_room'] = function($model){
                return Func::getRelationVal($model, 'seat', 'classroom', 'name');
            };

            $fields['seat_number'] = function($model){
                return Func::getRelationVal($model, 'seat', 'seat_number');
            };
        }

        if(in_array($this->type, [3,4])){
            $fields[] = 'had_about_num';
            $fields['times'] = function($model){
                return Func::getRelationVal($model, 'chargeGroupClass', 'times');
            };
        }

        return $fields;
    }

    /**
     * 已预约人数
     */
    public function getHad_about_num()
    {
        return \common\models\AboutClass::find()->where(['class_id'=>$this->class_id, 'type'=>$this->type, 'status'=>[1,3,4]])->count();
    }

    /**
     * ChargeClassNumber课程信息
     */
    public function getClass_info()
    {
//        return MemberCourseOrderDetails::findOne($this->class_id);
        $about = new AboutClass();
        if($this->type == '1') return $about->getNewAboutOne($this->class_id,$this->start,$this->coach_id,$this->member_card_id,$this->member_id,'');
        if(in_array($this->type, [3,4]) && isset($this->chargeGroupClass->class_number_id))
            return ChargeClassNumber::findOne($this->chargeGroupClass->class_number_id);
        if($this->type == '2') return MyGroupClass::findOne($this->class_id);
        return (object)[];
    }

    public function getStatus()
    {
        if($this->status==1 && time()>$this->start+15*60){
            if(in_array($this->type, [3,4])){//小团体课
                if(isset($this->class_info->least_number)){
                    if($this->had_about_num < $this->class_info->least_number){
                        \common\models\AboutClass::updateAll(['status'=>9, 'is_read'=>0], ['class_id'=>$this->class_id, 'type'=>$this->type]);
                        $this->status = 9;
                    }else{
                        \common\models\AboutClass::updateAll(['status'=>3, 'is_read'=>0], ['class_id'=>$this->class_id, 'type'=>$this->type]);
                        $this->status = 3;
                    }
                }
            }elseif($this->type == 2){//团课
                \common\models\AboutClass::updateAll(['status'=>3, 'is_read'=>0], ['class_id'=>$this->class_id, 'type'=>$this->type]);
                $this->status = 3;
            }
        }
        if(($this->status == 1) && ($this->type == 1) && (time() > $this->end)){//私课爽约
            \common\models\AboutClass::updateAll(['status'=>6], ['class_id'=>$this->class_id, 'type'=>$this->type]);
            $this->status = 6;
        }

        if($this->status == 3 && ($this->type != 1) && (time() > $this->end+15*60)){//到点课程自动改为下课状态，私教课不自动更改
            \common\models\AboutClass::updateAll(['status'=>4], ['class_id'=>$this->class_id, 'type'=>$this->type]);
            $this->status = 4;
        }

        return $this->status;
    }


}