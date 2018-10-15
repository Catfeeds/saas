<?php
namespace backend\models;

use common\models\base\Functional;
use common\models\relations\ModuleFunctionalRelations;
class ModuleFunctional extends \common\models\base\ModuleFunctional
{
    use ModuleFunctionalRelations;

    /**
     * @云运动 - 菜单管理 - 查询子菜单以及功能
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/16
     */
    public function getFuncByModule($id)
    {
        $query  = Module::find()
            ->alias('mod')
            ->joinWith(['moduleFunctional mf'])
            ->select(
                'mod.id,
                 mod.name,
                 mod.e_name,
                 mod.create_at,
                 mod.url,
                 mod.number,
                 mf.functional_id,
                 mod.is_show,')
            ->where(['mod.pid' =>$id])
            ->orderBy('mod.number ASC')      //按照序号升序排列
            ->asArray()
            ->all();
        return $this->setFunctionalByModuleAll($query);
    }
    public function getFuncData($id)
    {
        $func = ModuleFunctional::find()->where(['modular_id' => $id])->asArray()->one();
        $func = json_decode($func['functional_id']);
        return $func;
    }
    /**
     * @云运动 - 菜单管理 - 获取所有功能
     * @author 李慧恩 <lihuien@itsports.club>
     * @param  $data
     * @create 2017/6/16
     */
    public function setFunctionalByModuleAll($data)
    {
        if(!empty($data) && is_array($data)){
            foreach ($data as &$value){
                $funcId = json_decode($value['functional_id']);
                if(!empty($funcId)){
                    $value['moduleFunctional'] = $this->getFunctionalModelAll($funcId);
                }
            }
        };
        return $data;
    }
    /**
     * @云运动 - 菜单管理 - 获取所有功能
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/18
     */
    public function getAllFunc()
    {
        $func = Functional::find()->select('id,name')->asArray()->all();
        return $func;
    }
    /**
     * @云运动 - 菜单管理 - 已有权限
     * @author 李慧恩 <lihuien@itsports.club>
     * @param  $id;
     * @create 2017/6/16
     * @return array
     */
    public function getAuthModuleByRole($id)
    {
        $auth   = Auth::find()->where(['role_id'=>$id])->asArray()->one();
        return $auth;
    }
    /**
     * @云运动 - 菜单管理 - 获取所有权限
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/6/16
     */
    public function getModuleFunctionalAll()
    {
        $query  = Module::find()
            ->alias('mod')
            ->joinWith(['module module'=>function($query){
                $query->joinWith(['moduleFunctional mf']);
                $query->andWhere(['or',['module.is_show'=>null],['module.is_show'=>1]]);
            }])
            ->select('mod.id,mod.name')
            ->where(['mod.pid' => 0])
            ->asArray()->all();
        return $this->setFunctionalByModule($query);
    }

    /**
     * 后台 - 权限管理 - 执行搜索数据过滤
     * @create 2017/6/19
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @param  $query  //后台的sql语句
     * @return  mixed
     */
    public function getSearchWhere($query,$id,$type)
    {
        if($type && $type == 'company'){
            $query->andFilterWhere(['mod.company_id'=>$id]);
        }
        if($type && ($type == 'venue' || $type == 'department')){
            $query->andFilterWhere(['mod.venue_id'=>$id]);
        }
        return $query;
    }
    /**
     * @云运动 - 菜单管理 - 获取所有权限
     * @author 李慧恩 <lihuien@itsports.club>
     * @param  $data
     * @create 2017/6/16
     */
    public function setFunctionalByModule($data)
    {
         if(!empty($data) && is_array($data)){
             foreach ($data as &$value){
                 foreach ($value['module'] as &$v){
                     $funcId = json_decode($v['moduleFunctional']['functional_id']);
                     if(!empty($funcId)){
                         $v['moduleFunctional'] = $this->getFunctionalModelAll($funcId);
                     }
                 }
             }
         };
        return $data;
    }
    /**
     * @云运动 - 菜单管理 - 获取所有权限
     * @author 李慧恩 <lihuien@itsports.club>
     * @param  $ids
     * @create 2017/6/16
     * @return array
     */
    public function getFunctionalModelAll($ids)
    {
        return Functional::find()->where(['in','id',$ids])->asArray()->all();
    }
}