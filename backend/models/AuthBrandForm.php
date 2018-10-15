<?php
namespace backend\models;

use common\models\base\Auth;
use yii\base\Model;
use Yii;
class AuthBrandForm extends Model
{
    public $roleId;        //角色ID
    public $syncRoleId;   //同步角色ID
    public $authId;        //顶级模块ID
    public $moduleId;     //模块ID
    public $modFuncId;    //功能ID
    public $companyId;    //公司ID
    public $venueId;      //场馆ID

    public function rules()
    {
        return [
            [['roleId', 'syncRoleId', 'authId', 'moduleId', 'modFuncId', 'companyId', 'venueId'], 'safe'],
        ];
    }

    /**
     * @云运动 - 权限管理 - 保存权限设置
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/7/6
     */
    public function saveBrand()
    {
        $adminId               = Employee::findOne(['admin_user_id' => \Yii::$app->user->identity->id]);
        $authModel             = Auth::findOne(['role_id'=>$this->roleId]);
        $moduleId              = array_merge($this->authId,$this->moduleId);
        $moduleId              = array_unique($moduleId);
        $this->modFuncId      = array_filter($this->modFuncId);
//        $this->venueId        = array_filter($this->venueId);
        if(empty($authModel)){
            $auth                = new Auth();
            $auth->role_id      = $this->roleId;                                       //角色ID
            $auth->sync_role_id = $this->syncRoleId;                                  //同步角色ID
            $auth->module_id    = json_encode($moduleId);                              //模块ID
            $auth->function_id  = json_encode($this->modFuncId);                      //功能ID
            $auth->company_id   = json_encode($this->companyId);                      //公司ID
            $auth->venue_id     = json_encode($this->venueId);                        //场馆ID
            $auth->create_id    = isset($adminId->id) ? intval($adminId->id) : 0;     //创建人
            $auth->create_at    = time();                                              //创建时间
            $auth = $auth->save() ? $auth : $auth->errors;
            if ($auth) {
                return true;
            }else{
                return $auth->errors;
            }
        }else{
            $authModel->sync_role_id = $this->syncRoleId;                                 //同步角色ID
            $authModel->module_id    = json_encode($moduleId);                             //模块ID
            $authModel->function_id  = json_encode($this->modFuncId);                     //功能ID
            $authModel->company_id   = json_encode($this->companyId);                     //公司ID
            $authModel->venue_id     = json_encode($this->venueId);                       //场馆ID
            $authModel->create_id    = isset($adminId->id) ? intval($adminId->id) : 0;    //创建人
            $authModel->update_at    = time();                                             //更新时间
            $auth = $authModel->save() ? $authModel : $authModel->errors;
            if ($auth) {
                return true;
            }else{
                return $auth->errors;
            }
        }
    }
}