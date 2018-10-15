<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\LeaveRecord;
class SpecialForm extends Model
{
    public $id;                         //请假表id
    public $rejectNote;                 //拒绝原因


    /**
     * @云运动 - 后台 - 特殊请假验证规则
     * @create 2017/8/25
     * @return array
     */
    public function rules()
    {
        return [
            [['id','rejectNote'], 'required'],
        ];
    }

    /**
     * 云运动 - 请假管理 - 点击修改单条信息
     * @author Huanghua <Huanghua@itsports.club>
     * @create 2017/8/25
     * @param
     * @return boolean/object
     */
    public function updateData()
    {
        $model = LeaveRecord::findOne(['id' => $this->id]);
        $model->reject_note    = $this->rejectNote;
        $model->type = 3;
        $model->status = 2;

        if ($model->save()) {
            return true;
        } else {
            return $model->errors;
        }
    }

}