<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\Role;
class RoleForm extends Model
{
    public $id;                         //角色id
    public $name;                       //角色名称
    public $companyId;                 //所属公司id


    /**
     * @云运动 - 后台 - 新增角色验证规则
     * @create 2017/6/16
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id', 'name','companyId', 'createId', 'createAt'], 'safe'],
        ];
    }

    /**
     * 云运动 - 后台- 新增角色信息录入
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/6/16
     * @return boolean/object
     */
    public function addMyData()
    {
        // 角色信息保存
        $model = new Role();
        $model->create_id = $this->getCreate();
        $model->create_at = time();
        $model->name = $this->name;
        $model->company_id = $this->companyId;

        if ($model->save()) {
            return true;
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

    /**
     * 云运动 - 角色管理 - 点击修改单条信息
     * @author Huanghua <Huanghua@itsports.club>
     * @create 2017/6/16
     * @param
     * @return boolean/object
     */
    public function updateData()
    {
        //角色数据信息修改
        $model = Role::findOne(['id' => $this->id]);
        $model->name = $this->name;
        $model->company_id = $this->companyId;
        $model->create_id = $this->getCreate();
        $model->update_at = time();

        if ($model->save()) {
            return true;
        } else {
            return $model->errors;
        }
    }

}