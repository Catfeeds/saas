<?php
namespace backend\models;

use common\models\base\Employee;
use common\models\base\ModuleFunctional;
use yii\base\Model;
class ModuleFunctionalForm extends Model
{
    public $subId;      //子菜单ID
    public $funcId;     //功能ID

    public function rules()
    {
        return [
            [['subId', 'funcId'], 'safe']
        ];
    }

    /**
     * @云运动 - 菜单管理 - 子菜单保存功能
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/18
     */
    public function saveFunc()
    {
        $func = ModuleFunctional::findOne(['modular_id' => $this->subId]);
        if(!empty($func)){
            $func->functional_id = json_encode($this->funcId);
            $func->update_at = time();
            $func = $func->save() ? $func : $func->errors;
            if ($func) {
                return true;
            }else{
                return $func->errors;
            }
        }else{
            $create                 = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
            $module                 = new ModuleFunctional();
            $module->modular_id    = $this->subId;
            $module->create_id     = isset($create->id)?intval($create->id):0;
            $module->create_at     = time();
            $module->functional_id = json_encode($this->funcId);
            $module = $module->save() ? $module : $module->errors;
            if ($module) {
                return true;
            }else{
                return $module->errors;
            }
        }
    }
}