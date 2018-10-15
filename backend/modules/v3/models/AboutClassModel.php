<?php
namespace backend\modules\v3\models;

use common\models\Func;
use common\models\AboutClass;

class AboutClassModel extends AboutClass
{
    public function fields()
    {
        return [
            'id',
            'type',
            'status',
            'start',
            'end',
            'coach_id',
            'create_at',
            'cancel_time',
            'is_print_receipt',
            'venue_name' => function ($model) {
                if($model->type == 2){
                    return Func::getRelationVal($model,'groupClass','organization','name');
                }else{
                    return Func::getRelationVal($model,'memberCourseOrderDetails','memberCourseOrder','chargeClass','organization','name');
                }
            },
            'class_name' => function ($model) {
                if($model->type == 1){
                    return Func::getRelationVal($model,'memberCourseOrderDetails','product_name');
                }else{
                    return Func::getRelationVal($model,'groupClass','course','name');
                }
            },
            'coach_name'  => function ($model) {
                return Func::getRelationVal($model,'employee','name');
            },
            'pic'         => function ($model) {
                if($model->type == 1){
                    return Func::getRelationVal($model,'memberCourseOrderDetails','memberCourseOrder','chargeClass', 'pic');
                }else{
                    return Func::getRelationVal($model,'groupClasses','course','pic');
                }
            },
            'member_type' => function ($model) {
                return Func::getRelationVal($model,'member','member_type');
            },
            'start_time'  => function ($model) {
                return date('Y-m-d H:i',$model->start);
            },
            'end_time'    => function ($model) {
                return date('Y-m-d H:i',$model->end);
            },
            'cancel_time' => function ($model) {
                return $model->cancel_time ? date('Y-m-d H:i',$model->cancel_time) : '';
            },
            'class_room' => function ($model) {
                if($model->type == 1){
                    return NULL;
                }else{
                    return Func::getRelationVal($model,'groupClass','classroom','name');
                }
            }
        ];
    }

}
