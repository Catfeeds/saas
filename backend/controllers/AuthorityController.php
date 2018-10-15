<?php

namespace backend\controllers;

use backend\models\Auth;
use backend\models\AuthBrandForm;
use backend\models\AuthorityForm;
use backend\models\Role;
use common\models\Func;

class AuthorityController extends BaseController
{
    /**
     *  权限管理- 管理首页 - 列表
     * @return string
     * @author 苏雨
     * create 2017-3-31
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     *  权限管理- 会员信息 - 修改
     * @return string
     * @author 苏雨
     * create 2017-3-29
     * @update author Huang Pengju <huangpengju@itsport.club>
     * @update 2017/3/30
     */
    public function actionRevise()
    {
        return $this->render('revise');
    }

    /**
     * @return string
     * @author 程丽明
     * create 2017-3-31
     */
    public function actionSet()
    {
        return $this->render('authoritySet');
    }

    /**
     * 权限管理 - 分配用户 - 分配用户页面
     * @return string
     * @author 程丽明
     * create 2017-3-31
     */
    public function actionAssigningUsers()
    {
        return $this->render('assigningUsers');
    }
    /**
     * 权限管理 - 权限设置 - 修改页面
     * @return string
     * @author 梁可可
     * create 2017-3-31
     */
    public function actionEdit(){
        return $this->render('edit');
    }

    /**
     * 业务后台 - 权限管理
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/16
     * @return string
     */
    public function actionAuthority()
    {
        $post  = $this->post;
        $model = new AuthorityForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->saveAuthority();
            if($data == true){
                return json_encode(['status' => 'success', 'data' => '成功']);
            }else{
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api{get} /authority/get-auth 获取权限列表信息
     * @apiVersion  1.0.0
     * @apiName 获取权限列表信息
     * @apiGroup Authority
     * @apiPermission 管理员
     *
     * @apiDescription 权限管理 - 获取权限列表信息<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/17<br/>
     * <span><strong>调用方法：</strong></span>/authority/get-auth
     * @apiSampleRequest  http://qa.uniwlan.com/authority/get-auth
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * Array
     * (
     * 'name' => '业务水吧管理员'
     * 'company_id' => '2'
     * 'oname' => '我爱运动'
     * )
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionGetAuth()
    {
        $params     = $this->get;
        if(!empty($this->companyId)){
            $params['companyId']  = $this->companyId;
        }

        $model      = new Auth();
        $data       = $model->getAuth($params);
        $pagination = $data->pagination;
        $pages      = Func::getPagesFormat($pagination);

        return json_encode(['data' => $data->models, 'pages' => $pages]);
    }

    /**
     * @api{get} /authority/get-company 权限管理 - 列表
     * @apiVersion  1.0.0
     * @apiName 权限管理 - 列表
     * @apiGroup Authority
     * @apiPermission 管理员
     *
     * @apiDescription 权限管理 - 列表<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/5<br/>
     * <span><strong>调用方法：</strong></span>/authority/get-company
     * @apiSampleRequest  http://qa.uniwlan.com/authority/get-company
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {"data": [{"id":"1","name":"我爱运动"}]}
     * @apiErrorExample {json} 错误示例:
     * {"data": []}
     */
    public function actionGetCompany()
    {
        $params                   = \Yii::$app->request->queryParams;
        $params['nowBelongId']   = $this->nowBelongId;
        $params['nowBelongType'] = $this->nowBelongType;
        $role                    = new Role();
        $companyId = $role->getCompanyByAuth();
        $model                    = new Auth();
        $data                     = $model->getOrganizationCompany($params,$companyId);
        $pagination               = $data->pagination;
        $pages                    = Func::getPagesFormat($pagination);
        return json_encode(['data'=>$data->models,'pages'=>$pages]);
    }

    /**
     * @api{get} /authority/update-status 品牌名称 - 停用
     * @apiVersion  1.0.0
     * @apiName 品牌名称-停用
     * @apiGroup Authority
     * @apiPermission 管理员
     *
     * @apiParam {int} organId  品牌名称id
     *
     * @apiParamExample {json} Request Example
     * {
     *     "organId": "1",
     * }
     * @apiDescription 品牌名称-停用<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/6<br/>
     * <span><strong>调用方法：</strong></span>/authority/update-status
     * @apiSampleRequest  http://qa.uniwlan.com/authority/update-status
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"修改成功"}
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':"修改失败"}
     */
    public function actionUpdateStatus()
    {
        $id    = \Yii::$app->request->get('organId');
        $model = new Auth();
        $data  = $model->updateStatus($id);
        if($data === 1 || $data === 2){
            return json_encode(['status' => 'success', 'data' => '修改成功','edit' => $data]);
        }else{
            return json_encode(['status' => 'error', 'data' => $data]);
        }
    }

    /**
     * @api{get} /authority/auth-role 获取权限模板下拉列表
     * @apiVersion  1.0.0
     * @apiName 获取权限模板下拉列表
     * @apiGroup Authority
     * @apiPermission 管理员
     *
     * @apiDescription 权限设置 - 获取权限模板下拉列表<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/6<br/>
     * <span><strong>调用方法：</strong></span>/authority/auth-role
     * @apiSampleRequest  http://qa.uniwlan.com/authority/auth-role
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {"data": [{"id":"1","role_id":"2","name":"迈步会务权限","orgName": "我爱运动",}]}
     * @apiErrorExample {json} 错误示例:
     * {"data": []}
     */
    public function actionAuthRole()
    {
        $model = new Auth();
        $data  = $model->getAuthRole($this->companyId);
        return json_encode(['data' => $data]);
    }

    /**
     * @api{get} /authority/get-brand 关联其他品牌-获取公司
     * @apiVersion  1.0.0
     * @apiName 关联其他品牌-获取公司
     * @apiGroup Authority
     * @apiPermission 管理员
     *
     * @apiDescription 关联其他品牌-获取公司<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/6<br/>
     * <span><strong>调用方法：</strong></span>/authority/get-brand
     * @apiSampleRequest  http://qa.uniwlan.com/authority/get-brand
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {"data": [{"id":"1","name":"我爱运动"}]}
     * @apiErrorExample {json} 错误示例:
     * {"data": []}
     */
    public function actionGetBrand()
    {
        $model   = new Auth();
        $role    = new Role();
        $company = $role->getCompanyByAuth();
        $data    = $model->getCompany($company);
        return json_encode(['data' => $data]);
    }

    /**
     * @api{get} /authority/get-venue 关联其他品牌-获取公司下的场馆
     * @apiVersion  1.0.0
     * @apiName 关联其他品牌-获取公司下的场馆
     * @apiGroup Authority
     * @apiPermission 管理员
     *
     * @apiParam {int} companyId  公司id
     *
     * @apiParamExample {json} Request Example
     * {
     *     "companyId": "1",
     * }
     * @apiDescription 获取公司下的场馆<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/5<br/>
     * <span><strong>调用方法：</strong></span>/authority/get-venue
     * @apiSampleRequest  http://qa.uniwlan.com/authority/get-venue
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {"data": [{"id":"8","name":"大上海"}]}
     * @apiErrorExample {json} 错误示例:
     * {"data": []}
     */
    public function actionGetVenue()
    {
        $id    = \Yii::$app->request->get('companyId');
        $model = new Auth();
        $data  = $model->getVenue($id);
        return json_encode(['data' => $data]);
    }

    /**
     * @api{get} /authority/get-auth-by-role 权限设置-获取角色已有权限
     * @apiVersion  1.0.0
     * @apiName 权限设置-获取角色已有权限
     * @apiGroup Authority
     * @apiPermission 管理员
     *
     * @apiParam {int} roleId  角色id
     *
     * @apiParamExample {json} Request Example
     * {
     *     "roleId": "1",
     * }
     * @apiDescription 权限设置-获取角色已有权限<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/6<br/>
     * <span><strong>调用方法：</strong></span>/authority/get-auth-by-role
     *
     * @apiSampleRequest  http://qa.uniwlan.com/authority/get-auth-by-role
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {id: "2", role_id: "6", create_id: "1", create_at: "1498190778",…}
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionGetAuthByRole()
    {
        $id    = \Yii::$app->request->get('roleId');
        $model = new Auth();
        $data  = $model->getAuthByRole($id);
        return json_encode(['data' => $data]);
    }

    /**
     * @api {post} /authority/auth-brand 保存全局权限设置
     * @apiVersion 1.0.0
     * @apiName 权限设置-保存全局权限设置
     * @apiGroup Authority
     * @apiPermission 管理员
     *
     * @apiParam {int} roleId 角色ID
     * @apiParam {int} syncRoleId 同步角色ID
     * @apiParam {json} authId 顶级模块ID
     * @apiParam {json} moduleId 模块ID
     * @apiParam {json} modFuncId 功能ID
     * @apiParam {json} companyId 公司ID
     * @apiParam {json} venueId 场馆ID
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     * {
     *      "roleId": "2",
     *      "syncRoleId": "3",
     *      "authId": "["1","2","3"]",
     *      "moduleId": "["1","2","3"]",
     *      "modFuncId": "["1","2","3"]",
     *      "companyId": "["1","2","3"]",
     *      "venueId": "["1","2","3"]",
     *      "_csrf_backend":""
     * }
     * @apiDescription 权限设置 - 保存全局权限设置<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/7/6<br>
     * <span><strong>调用方法：</strong></span>/authority/auth-brand
     *
     * @apiSampleRequest  http://qa.uniwlan.com/authority/auth-brand
     * @apiSuccess (返回值) {string} status 返回状态
     * @apiSuccess (返回值) {string} data  返回状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"保存成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':"保存失败"}
     */
    public function actionAuthBrand()
    {
        $post  = \Yii::$app->request->post();
        $model = new AuthBrandForm();
        if($model->load($post,'') && $model->validate($post)){
            $data = $model->saveBrand();
            if($data == true){
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            }else{
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        }else{
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }
}
