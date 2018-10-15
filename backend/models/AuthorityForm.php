<?php
namespace backend\models;

use common\models\base\Auth;
use yii\base\Model;
use Yii;
class AuthorityForm extends Model
{
    public $roleId;       //角色ID
    public $authId;       //顶级模块ID
    public $moduleId;     //模块ID
    public $functionalId;   //功能ID
    public $modFuncId;

    public function rules()
    {
        return [
            [['roleId','authId','moduleId','modFuncId','functionalId'], 'safe'],
        ];
    }

    /**
     * @云运动 - 权限管理 - 保存权限
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/16
     */
    public function saveAuthority()
    {
        $authModel             = Auth::findOne(['role_id'=>$this->roleId]);
        $moduleId              = array_merge($this->authId,$this->moduleId);
        $moduleId              = array_unique($moduleId);
        $this->modFuncId       = array_filter($this->modFuncId);
        if(empty($authModel)){
            $auth               = new Auth();
            $auth->role_id     = $this->roleId;                                //角色ID
            $auth->module_id   = json_encode($moduleId);                       //模块ID
            $auth->function_id = json_encode($this->modFuncId);              //功能ID
//        $auth->create_id   = isset($create->id)?intval($create->id):0;       //创建人
            $auth->create_id   = 0;
            $auth->create_at   = time();                                      //创建时间
            $auth = $auth->save() ? $auth : $auth->errors;
            if ($auth) {
                return true;
            }else{
                return $auth->errors;
            }
        }else{
            $authModel->module_id   = json_encode($moduleId);              //模块ID
            $authModel->function_id = json_encode($this->modFuncId);           //功能ID
            $authModel->create_id   = Yii::$app->user->identity->id;
            $auth = $authModel->save() ? $authModel : $authModel->errors;
            if ($auth) {
                return true;
            }else{
                return $auth->errors;
            }
        }
    }
}