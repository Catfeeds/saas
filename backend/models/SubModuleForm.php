<?php
namespace backend\models;

use common\models\base\Employee;
use common\models\base\Module;
use yii\base\Model;
class SubModuleForm extends Model
{
    public $subName;      //菜单名
    public $subEName;     //菜单英文名
    public $subIcon;      //图标
    public $subUrl;       //路由
    public $topId;       //顶级ID

    public function rules()
    {
        return [
            [['subName', 'subEName', 'subIcon', 'subUrl', 'topId',], 'safe']
        ];
    }

    public function getCreate()
    {
        $create = Employee::findOne(['admin_user_id' => \Yii::$app->user->identity->id]);
        $create = isset($create->id) ? intval($create->id) : 0;
        return $create;
    }

    /**
     * @云运动 - 菜单管理 - 新增子菜单
     * @author 朱梦珂 <zhumengke@itsports.club>
     *type  1为pc端子菜单，2为手机端子菜单
     * @create 2017/6/16
     */
    public function saveSubModule($type)
    {
        $module            = new Module();
        $module->name      = $this->subName;
        $module->e_name    = $this->subEName;
        $module->icon      = $this->subIcon;
        $module->url       = $this->subUrl;
        $module->level     = 2;
        $module->type     = $type;
        $module->pid       = $this->topId;
        $module->note      = '子菜单';
        $module->create_id = $this->getCreate();
        $module->create_at = time();
        $module = $module->save() ? $module : $module->errors;
        if ($module) {
            return true;
        } else {
            return $module->errors;
        }
    }
}