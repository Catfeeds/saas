<?php
namespace backend\models;

use common\models\base\Employee;
use common\models\base\Module;
use yii\base\Model;
class SubModuleUpdate extends Model
{
    public $subNameUp;   //菜单名
    public $subENameUp;  //菜单英文名
    public $subIconUp;   //图标
    public $subUrlUp;    //地址
    public $subId;       //子菜单ID

    public function rules()
    {
        return [
            [['subNameUp', 'subENameUp', 'subIconUp','subUrlUp','subId'], 'safe']
        ];
    }

    public function getCreate()
    {
        $create = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $create = isset($create->id)?intval($create->id):0;
        return $create;
    }

    /**
     * @云运动 - 菜单管理 - 修改子菜单
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/16
     */
    public function updateModule()
    {
        $module = Module::findOne(['id' => $this->subId]);
        if(!empty($module)){
            $module->name       = $this->subNameUp;
            $module->e_name     = $this->subENameUp;
            $module->icon       = $this->subIconUp;
            $module->url        = $this->subUrlUp;
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