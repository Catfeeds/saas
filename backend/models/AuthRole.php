<?php
namespace backend\models;

use common\models\base\Functional;
use yii\base\Model;

class AuthRole extends Model
{
    public $adminId;

    public function init()
    {
        if(!isset(\Yii::$app->user->identity) || empty(\Yii::$app->user->identity)){
            return false;
        }
    }
    /**
     * @云运动 - 菜单管理 - 获取角色权限
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/6/16
     * @return array
     */
    public function getAuthRoleOne()
    {
        $level         = \Yii::$app->user->identity->level;
        $auth          = new ModuleFunctional();
        $roleAuth      = $auth->getAuthModuleByRole($level);
        $authArr['module']      = json_decode($roleAuth['module_id'],true);
        $authArr['functional']  = json_decode($roleAuth['function_id'],true);
        if(!empty($authArr['functional'])){
            $authArr['moduleLower'] = array_keys($authArr['functional']);
        }else{
            $authArr['moduleLower'] = [];
        }
        return $authArr;
    }
    /**
     * @云运动 - 菜单管理 - 定义权限
     * @author 李慧恩 <lihuien@itsports.club>
     * @param  $menu;
     * @param  $attr
     * @create 2017/6/16
     * @return array
     */
    public static function canRoleByAuth($menu,$attr = '')
    {
        return true;
        if(!self::getUserIdentity()){
            return false;
        }
        self::setAdminLevel();
        $level         = \Yii::$app->user->identity->level;
        $name          = \Yii::$app->user->identity->username;
        if((!is_null($level) && $level == 0) || ($level == 1 && $name == 'admin')){
            return true;
        }
        $authArr = self::getAuthRoleOne();
        $module  = Module::find()->select('id')->where(['e_name'=>$menu])->asArray()->all();
        $module  = array_column($module,'id');
        if(!empty($module) && is_array($module)){
            $num = 0;
            foreach ($module as $k=>$v){
                if(in_array($v,!empty($authArr['module'])?$authArr['module']:[])){
                    $num += 1;
                }
            }
            if($num === 0){
                return false;
            }
        }
        $func    = Functional::find()->select('id')->where(['e_name'=>$attr])->asArray()->one();
        if(!empty($attr)){
            foreach ($module as $k=>$v){
                $funcArr = isset($authArr['functional'][$v])?$authArr['functional'][$v]:[];
                if(in_array(isset($func['id'])?$func['id']:-1,!empty($funcArr)?$funcArr:[])){
                    return true;
                }
            }
            return false;
        }
        return true;
    }
    /**
     * @云运动 - 菜单管理 - 定义权限
     * @author 李慧恩 lihuien@itsports.club
     * @create 2017/6/16
     * @return array
     */
    public static function getMenuDataByRole($companyId = null)
    {
        self::setAdminLevel();
        $org = Organization::findOne(['id' => $companyId]);
        if($org['status'] == 2){
            return null;
        }else{
            $role = \Yii::$app->user->identity->role;
            if($role['status'] == 2){
                return null;
            }
        }
        $level = \Yii::$app->user->identity->level;
        $name = \Yii::$app->user->identity->username;
        $authArr = self::getAuthRoleOne();
        $query = Module::find()
            ->alias('mod')
            ->select('mod.id,mod.name, mod.icon, mod.url')
            ->joinWith(['module module' => function($query){
                $query->orderBy('module.number ASC');  //子菜单 按照序号升序排列
                $query->select('module.id,module.name, module.icon, module.url,module.pid');
            }])
            ->where(['mod.pid'=>0])
            ->andWhere(['mod.type'=>1])//查询pc端菜单
            ->orderBy('mod.number ASC')      //顶级菜单 按照序号升序排列
            ->asArray();
        if((is_null($level) && $level != 0) || ($level != 1 && $name != 'admin')){
            if(empty($authArr['module'])){
                $authArr['module'] = [];
            }
            $query->andWhere(['in','mod.id',$authArr['module']]);
        }
        $data = self::setAdminCommonMenu($query->all(),$level,$name,$authArr['moduleLower']);
        return $data;
    }
    /**
     * 云运动  - 员工管理  - 设置公共菜单
     * @author lihuien <lihuien@itsports.club>
     * @update 2017-5-4
     * @param  $data
     * @param  $level
     * @param  $name
     * @return string
     */
    public function setAdminCommonMenu($data,$level,$name,$idArr)
    {
        if(!empty($data) && (is_null($level) && $level != 0) || ($level != 1 && $name != 'admin')){
            foreach ($data as $k=>&$v){
                foreach ($v['module'] as $key=>&$value){
                    if(!in_array($value['id'],$idArr)){
                        unset($v['module'][$key]);
                    }
                }
            }
        }
        return $data;
    }
    /**
     * 云运动  - 员工管理  - 设置权限级别
     * @author lihuien <lihuien@itsports.club>
     * @update 2017-5-4
     * @return string
     */
    public function setAdminLevel()
    {
        if(!self::getUserIdentity()){
               return false;
        }
        $level = \Yii::$app->user->identity->level;
        $name  = \Yii::$app->user->identity->username;
        if((is_null($level) && $name == 'admin') || ($level == 1 && $name == 'admin')){
            $id    = \Yii::$app->user->identity->id;
            $admin = Admin::findOne(['id'=>$id]);
            $admin->level = 0;
            $admin->save();
        }
    }
    /**
     * 云运动  - 员工管理  - 获取管理员身份
     * @author lihuien <lihuien@itsports.club>
     * @update 2017-5-4
     * @return string
     */
    public static function getAdminRolesName()
    {
        $level   = \Yii::$app->user->identity->level;
        $name    = \Yii::$app->user->identity->username;
        $roleArr = Role::find()->where(['id'=>$level])->asArray()->one();
        if(empty($roleArr)){
            if(($name == 'admin' || $level === 0)){
                return '超级管理员';
            }
            return isset($roleArr[$level])?$roleArr[$level]:'普通管理员';
        }else{
            return $roleArr['name'];
        }
    }
    public static function getUserIdentity()
    {
        if(!isset(\Yii::$app->user->identity) || empty(\Yii::$app->user->identity)){
            return false;
        }
        return true;
    }
    /**
     * 云运动  - 员工管理  - 获取公司名称
     * @author lihuien <lihuien@itsports.club>
     * @update 2017-5-4
     * @return string
     */
    public static function getAdminCompanyName()
    {
        if(!self::getUserIdentity()){
            return false;
        }
        $admin   = Admin::getAdminAndEmployeeOne();
        if(isset($admin['company_id']) && !empty($admin['company_id'])){
            $organ   = Organization::getOrganizationById($admin['company_id']);
            return isset($organ['name'])?$organ['name']:'我爱运动';
        }else{
            $organ   = Organization::getOrganizationById($admin['organization_id']);
            if(isset($organ['pid']) && $organ['style'] == 1){
                return isset($organ['name'])?$organ['name']:'我爱运动';
            }else if (isset($organ['pid']) && $organ['style'] == 2){
                $company    = Organization::getOrganizationById($organ['pid']);
                return isset($company['name'])?$company['name']:'我爱运动';
            }else if (isset($organ['pid']) && $organ['style'] == 3){
                $company    = Organization::getOrganizationById($organ['pid']);
                $companyTwo = Organization::getOrganizationById($company['pid']);
                return isset($companyTwo['name'])?$companyTwo['name']:'我爱运动';
            }
            return '幸福里郑州总部';
        }
    }
}