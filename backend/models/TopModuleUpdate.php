<?php
namespace backend\models;

use common\models\base\Employee;
use common\models\base\Module;
use yii\base\Model;
class TopModuleUpdate extends Model
{
    public $topNameUp;   //菜单名
    public $topENameUp;  //菜单英文名
    public $topIconUp;   //图标
    public $topId;       //顶级菜单ID

    public function rules()
    {
        return [
            [['topNameUp', 'topENameUp', 'topIconUp', 'topId'], 'safe']
        ];
    }

    public function getCreate()
    {
        $create = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $create = isset($create->id)?intval($create->id):0;
        return $create;
    }

    /**
     * @云运动 - 菜单管理 - 修改顶级菜单
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/16
     */
    public function updateModule()
    {
        $module = Module::findOne(['id' => $this->topId]);
        if(!empty($module)){
            $module->name       = $this->topNameUp;
            $module->e_name     = $this->topENameUp;
            $module->icon       = $this->topIconUp;
            $module->create_id = $this->getCreate();
            $module->update_at = time();
            $module = $module->save() ? $module : $module->errors;
            if ($module) {
                return true;
            }else{
                return $module->errors;
            }
        }
    }
}