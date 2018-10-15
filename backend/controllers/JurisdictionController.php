<?php

namespace backend\controllers;

use backend\models\AuthRole;
use backend\models\ModuleFunctional;

class JurisdictionController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * @云运动 - 菜单管理 - 获取权限列表
     * @author 李慧恩 <lihuien@itsports.club>
     * @param  $id;
     * @create 2017/6/16
     * @return array
     */
   public function actionGetAuthByRoleId($id)
   {
       $modFunc = new ModuleFunctional();
       $data    = $modFunc->getAuthModuleByRole($id);
       return json_encode($data);
   }
    /**
     * @云运动 - 菜单管理 - 获取所有权限列表
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/6/16
     * @return array
     */

    /**
     * @api{get} /jurisdiction/get-module-functional-data-all 权限设置 - 获取所有权限
     * @apiVersion  1.0.0
     * @apiName 权限设置 - 获取所有权限
     * @apiGroup Jurisdiction
     * @apiPermission 管理员
     *
     * @apiDescription 权限设置 - 获取所有权限<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/6<br/>
     * <span><strong>调用方法：</strong></span>/jurisdiction/get-module-functional-data-all
     *
     * @apiSampleRequest  http://qa.uniwlan.com/jurisdiction/get-module-functional-data-all
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {id: "1", name: "系统首页", module: [,…]}, {id: "2", name: "前台管理",…}, {id: "3", name: "中心管理",…}
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionGetModuleFunctionalDataAll()
    {
        $id      = $this->companyId;
        $type    = $this->nowBelongType;
        $modFunc = new ModuleFunctional();
        $data    = $modFunc->getModuleFunctionalAll($id,$type);
        return json_encode($data);
    }
    /**
     * @云运动 - 菜单管理 - 获取角色权限菜单
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/6/16
     * @return array
     */
    public function actionGetAuthModuleAll()
    {
        //菜单查询增加缓存
//        $cache = \Yii::$app->cache;
//        $data = $cache->get('cache_menu_key');
//        if ($data === false) {
//            $data = AuthRole::getMenuDataByRole();
//            $cache->set('cache_menu_key', $data, 60 * 60);
//        }

        $session = \Yii::$app->session;
        if($session->has('AuthRole')){
            $session->remove('AuthRole');
        }
//        if($session->has('AuthRole')){
//            $data = $session->get('AuthRole');
//        }else{
        $data = AuthRole::getMenuDataByRole($this->companyId);
//            $session->set('AuthRole',$data);
//        }
//        $data = AuthRole::getMenuDataByRole($this->companyId);
//        $session->set('AuthRole',$data);
        return json_encode($data);
    }
}
