<?php

namespace backend\models;

use common\models\base\Organization;
use common\models\base\Role;
use common\models\Func;
use common\models\base\Module;
use common\models\relations\AuthRelations;
class Auth extends \common\models\base\Auth
{
     use AuthRelations;
     public $sorts;
     public $companyId;
     public $status;
     public $keywords;
     public $searchContent;
     public $nowBelongId;
     public $nowBelongType;
     const KEY              = 'keywords';
     const SEARCH_CONTENT  = 'searchContent';
     const NOW_BELONG_ID   = 'nowBelongId';
     const NOW_BELONG_TYPE = 'nowBelongType';
     public function getModuleByFunctional()
     {

     }

     /**
      * @云运动 - 权限管理 - 列表
      * @author 朱梦珂 <zhumengke@itsports.club>
      * @param  array $params
      * @create 2017/6/16
      * @return  array
      */
     public function getAuth($params)
     {
          $this->customLoad($params);
          $query = \backend\models\Role::find()
              ->alias('role')
              ->joinWith(['auth auth'])
              ->joinWith(['admin admin'])
              ->joinWith(['organization or'])
              ->groupBy('role.id')
              ->orderBy($this->sorts)
              ->asArray();
          $query  = $this->setAuthArWhere($query);
          $module = Func::getDataProvider($query,8);
          return $module;
     }

     public function customLoad($data)
     {
          $this->companyId = !empty($data['companyId']) ? $data['companyId'] : null;
          $this->status    = !empty($data['status']) ? $data['status'] : null;
          $this->sorts = self::sorts($data);
          return true;
     }
     public function setAuthArWhere($query)
     {
          $query->andFilterWhere(['role.company_id'=>$this->companyId]);
          if($this->status == 1){
               $query->andWhere(['is not','auth.id',null]);
          }
          if($this->status == 2){
               $query->andWhere(['auth.id'=>null]);
          }
          return $query;
     }
     public static function sorts($data)
     {
          $sorts = ['role.id' => SORT_DESC];
          if (!isset($data['sortType'])) {
               return $sorts;
          }
          switch($data['sortType'])
          {
               case 'name' :
                    $attr = '`role`.name';
                    break;
               case 'oName' :
                    $attr = '`or`.oname';
                    break;
               default;
                    return $sorts;
          }
          return $sorts = [ $attr  => self::convertSortValue($data['sortName']) ];
     }
     public static function convertSortValue($sort)
     {
          if ($sort == 'ASC') {
               return SORT_ASC;
          } elseif ($sort == 'DES') {
               return SORT_DESC;
          }
     }
     
     /**
      * @云运动 - 权限管理 - 获取公司信息
      * @author 朱梦珂 <zhumengke@itsports.club>
      * @create 2017/7/6
      * @return array
      */
     public function getOrganizationCompany($params,$companyId)
     {
          if ($companyId == null){
               $this->custom($params);
               $query = Organization::find()
                   ->alias('or')
                   ->where(['style' => 1])
                   ->select('or.id,or.name,or.status')
                   ->asArray();
               $query = $this->getSearchWhere($query);
               return Func::getDataProvider($query,8);
          }else{
               $this->custom($params);
               $query = Organization::find()
                   ->alias('or')
                   ->where(['style' => 1])
                   ->andWhere(['id'=>$companyId])
                   ->select('or.id,or.name,or.status')
                   ->asArray();
               $query = $this->getSearchWhere($query);
               return Func::getDataProvider($query,8);
          }

     }

     /**
      * @云运动 - 权限管理 - 增加搜索条件
      * @author 朱梦珂 <zhumengke@itsports.club>
      * @create 2017/7/6
      * @param $query
      */
     public function getSearchWhere($query)
     {
          $query->andFilterWhere(['like','or.name',$this->keywords]);
//          if($this->nowBelongType && $this->nowBelongType == 'company'){
//               $query->andFilterWhere(['or',['ar.be_apply_id'=>$this->nowBelongId],['ar.apply_id'=>$this->nowBelongId]]);
//          }
          return $query;
     }

     /**
      * @云运动 - 权限管理 - 搜索数据处理数据
      * @author 朱梦珂 <zhumengke@itsports.club>
      * @create 2017/7/6
      * @param $data
      * @return bool
      */
     public function custom($data)
     {
          $this->keywords      = (isset($data[self::KEY]) && !empty($data[self::KEY])) ? $data[self::KEY] : null;
          $this->searchContent = (isset($data[self::SEARCH_CONTENT]) && !empty($data[self::SEARCH_CONTENT])) ? $data[self::SEARCH_CONTENT] : null;
          $this->nowBelongId   = (isset($data[self::NOW_BELONG_ID]) && !empty($data[self::NOW_BELONG_ID])) ? $data[self::NOW_BELONG_ID] : null;
          $this->nowBelongType = (isset($data[self::NOW_BELONG_TYPE]) && !empty($data[self::NOW_BELONG_TYPE])) ? $data[self::NOW_BELONG_TYPE] : null;
          return true;
     }

     /**
      * @云运动 - 权限管理 - 权限设置 - 遍历权限模板
      * @author 朱梦珂 <zhumengke@itsports.club>
      * @create 2017/7/6
      * @return array
      */
     public function getAuthRole($companyId)
     {
          $authRole = Auth::find()
              ->alias('auth')
              ->joinWith(['role role' => function($query){
                   $query->joinWith(['organization org']);
              }])
              ->andFilterWhere(['role.company_id'=>$companyId])
              ->select('auth.id,auth.role_id,role.name,org.id as orgId,org.name as orgName')
              ->asArray()
              ->all();
          return $authRole;
     }

     /**
      * @云运动 - 关联其他品牌 - 获取公司
      * @author 朱梦珂 <zhumengke@itsports.club>
      * @create 2017/7/6
      * @param  $company
      * @return array
      */
     public function getCompany($company)
     {
          $query = Organization::find()
              ->alias('or')
              ->where(['style' => 1,'pid' => 0])
              ->andFilterWhere(['id'=>$company])
              ->select('or.id,or.name')
              ->asArray();
          return $query->all();
     }

     /**
      * @云运动 - 关联其他品牌 - 获取公司下的场馆
      * @author 朱梦珂 <zhumengke@itsports.club>
      * @create 2017/7/6
      * @return array
      */
     public function getVenue($id)
     {
          $query = Organization::find()
              ->alias('or')
              ->where(['pid' => $id,'style' => 2])
              ->select('or.id,or.name,or.pid')
              ->asArray()
              ->all();
          return $query;
     }

     /**
      * @云运动 - 权限管理 - 权限模板已有权限
      * @author 朱梦珂 <zhumengke@itsports.club>
      * @param  $id
      * @create 2017/7/6
      * @return array
      */
     public function getAuthByRole($id)
     {
          $auth = Auth::find()
              ->alias('auth')
              ->joinWith(['role role' => function($query){
                   $query->joinWith(['organization or']);
              }])
              ->joinWith(['roles roles' => function($query){
                   $query->joinWith(['organization org']);
              }])
              ->where(['role_id'=>$id])
              ->select(
                  'auth.id,
                  auth.role_id,role.name as roleName,or.name as orName,
                  auth.module_id,
                  auth.function_id,
                  auth.company_id,
                  auth.venue_id,
                  auth.sync_role_id,roles.name as syncName,org.name')
              ->asArray()
              ->one();
          return $auth;
     }
     /**
      * 云运动 - 权限管理 - 品牌名称 - 停用
      * @author 朱梦珂 <zhumengke@itsports.club>
      * @create 2017/7/6
      */
     public function updateStatus($id)
     {
          $organ = Organization::findOne(['id' => $id]);
          $role  = Role::find()->where(['company_id' => $id])->select('id,status')->asArray()->all();
          if($organ && ($organ->status == NULL || $organ->status == 1)){
               $organ->status = 2;
               foreach ($role as $k=>$v) {
                    $roleId = Role::findOne(['id' => $v['id']]);
                    $roleId->status = 2;
                    $roleId->save();
               }
          }else{
               $organ->status = 1;
               foreach ($role as $k=>$v) {
                    $roleId = Role::findOne(['id' => $v['id']]);
                    $roleId->status = 1;
                    $roleId->save();
               }
          }
          if($organ->save()){
               return $organ->status == 1 ? 1 : 2;
          }else{
               return $organ->errors;
          }
     }

     /**
      * 云运动 - 权限管理 - 获取权限同步的场馆
      * @author 朱梦珂 <zhumengke@itsports.club>
      * @create 2017/7/6
      */
     public function getVenueDataByCompany($roleId)
     {
          $auth       = new ModuleFunctional();
          $roleAuth   = $auth->getAuthModuleByRole($roleId);
          $companyArr = json_decode($roleAuth['venue_id'],true);
          if(!empty($companyArr)){
               return Organization::find()->where(['in','id',$companyArr])->asArray()->all();
          }
     }
}