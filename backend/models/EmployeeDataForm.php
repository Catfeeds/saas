<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\Employee;

class EmployeeDataForm extends Model
{
    public $pic;          //图片
    public $id;           //员工id


    /**
     * @云运动 - 后台 - 修改图片验证规则
     * @create 2017/7/6
     * @return array
     */
    public function rules()
    {
        return [
            [['pic'], 'required'],
            [['id','pic'], 'safe'],
        ];
    }
    /**
     * 云运动 - 角色管理 - 点击头像修改头像
     * @author Huanghua <Huanghua@itsports.club>
     * @create 2017/6/16
     * @param
     * @return boolean/object
     */
    public function updateData()
    {
        //角色数据信息修改
        $model = Employee::findOne(['id' => $this->id]);
        $model->pic = $this->pic;
        $model->create_id = $this->getCreate();
        $model->updated_at = time();

        if ($model->save()) {
            return $model;
        } else {
            return $model->errors;
        }

    }
    public function getCreate()
    {
        $create = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $create = isset($create->id)?intval($create->id):0;
        return $create;
    }





}