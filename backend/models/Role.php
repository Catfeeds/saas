<?php
namespace backend\models;
use common\models\base\Organization;
use common\models\relations\RoleRelations;
use common\models\Func;

class Role extends \common\models\base\Role
{
    use RoleRelations;
    public $companyId;
    public $keywords;
    const COMPANY  = 'companyId';
    const KEYWORDS = 'keywords';
    
    /**
     * 云运动 - 角色管理 - 遍历列表信息
     * @author Huanghua <Huanghua@itsports.club>
     * @create 2017/6/16
     * @param $params //搜索参数
     * @return boolean/object
     */
    public function search($params)
    {
        $this->customLoad($params);
        $query = Role::find()
            ->alias('role')
            ->joinWith(['organization or'])
            ->andWhere(['or.style'=>1])
            ->asArray();
        $query                 = $this->getSearchWhere($query);
        $dataProvider          =  Func::getDataProvider($query,8);
        return  $dataProvider;
    }

    /**
     * 云运动 - 权限管理 - 选择角色 - 遍历列表
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/7/5
     * @return array
     */
    public function getRole($id,$name)
    {
        $role = Role::find()
            ->where(['company_id' => $id])
            ->andFilterWhere(['like','name',$name])
            ->select('id,name,status')
            ->asArray()->all();
        return $role;
    }

    public function customLoad($data)
    {
        $companyId = $this->getCompanyByAuth();                     //根据权限获取场馆
        $companyIds       =   (isset($adComId) && !empty($adComId)) ? $adComId : $companyId;
        $this->companyId  = (isset($data[self::COMPANY]) && !empty($data[self::COMPANY]))?$data[self::COMPANY]: $companyIds;
        $this->keywords   = (isset($data[self::KEYWORDS]) && !empty($data[self::KEYWORDS]))?$data[self::KEYWORDS] : null;
        return true;
    }

    public function getSearchWhere($query)
    {
        $query->andFilterWhere(['role.company_id'=>$this->companyId]);
        $query->andFilterWhere(['like','role.name',$this->keywords]);
        return $query;
    }
    /**
     * 后台 - 角色管理 - 角色详情移除角色
     * @author Huang Hua <huanghua@itsports.club>
     * @create 2017/6/17
     * @param $id
     * @return bool
     */
    public  static function getUpdateAdmin($id)
    {
        $admin  =  \common\models\base\Admin::findOne(['id'=>$id]);

        if($admin->level != null){
            $admin->level = null;
        }
        if($admin->save()){
            return true;
        }else{
            return $admin->errors;
        }
    }


    /**
     * 后台 - 角色管理 - 角色基本信息删除
     * @author Huang Hua <huanghua@itsports.club>
     * @create 2017/6/16
     * @param $id
     * @return bool
     */
    public  function  getRoleDelete($id)
    {
        $role             =   Role::findOne($id);
        $resultDelete     =   $role->delete();
        if($resultDelete)
        {
            return true;
        }else{
            return false;
        }
    }


 
    /**
     * 角色管理 - 分配员工 - 管理员等级修改
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/3/31
     * @param $roleId
     * @param $adminId
     * @return bool
     */
    public static function getUpdateEmployee($roleId,$adminId)
    {
        $about  =  \common\models\base\Admin::updateAll(['level'=>$roleId],['in','id',$adminId]);
        if($about){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 云运动 - 权限管理 - 选择角色 - 停用
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/7/6
     */
    public function updateStatus($id)
    {
        $role  = Role::findOne(['id' => $id]);
        $organ = Organization::findOne(['id' => $role['company_id']]);
        if($role && ($role->status == NULL || $role->status == 1)){
            $role->status = 2;
        }else{
            if($organ['status'] == 2){
                $role->status = 2;
            }else{
                $role->status = 1;
            }
        }
        if($role->save()){
            return $role->status == 1 ? 1 : 2;
        }else{
            return $role->errors;
        }
    }

    /**
     * @后台 - 卡种审核 - 获取公司下的角色
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/28
     * @param  $id  //公司id
     * @return array
     */
    public function getRoleData($id)
    {
        return Role::find()
            ->where(['company_id' => $id])
            ->andWhere(['or',['status'=>1],['status'=>null]])
            ->select('id,name,status')
            ->asArray()->all();
    }
    /**
     * @后台 - 卡种审核 - 获取权限公司
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/9/28
     * @return array
     */
    public function getCompanyByAuth()
    {
        $roleId         =  \Yii::$app->user->identity->level;
        if($roleId == 0){
            $comId      =   Organization::find()->select('id')->where(['style'=>1])->asArray()->all();
            $companyId    =   array_column($comId, 'id');
        }else{
            $ComId      =   Auth::findOne(['role_id' => $roleId])->company_id;
            $companyId  =   json_decode($ComId);
        }
        return $companyId;
    }
}