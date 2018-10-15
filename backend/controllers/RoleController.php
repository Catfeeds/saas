<?php

namespace backend\controllers;

use backend\models\Auth;
use backend\models\Order;
use backend\models\Organization;
use backend\models\RoleForm;
use backend\models\Role;
use backend\models\Employee;
use common\models\Func;
use Yii;

class RoleController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @api{get} /role/role-info 角色管理 - 角色列表数据遍历
     * @apiVersion  1.0.0
     * @apiName 角色管理 - 角色列表数据遍历
     * @apiGroup role
     * @apiPermission 管理员
     *
     * @apiDescription 角色管理 - 角色列表数据遍历<br/>
     * <span><strong>作   者：</strong></span>黄华<br/>
     * <span><strong>邮   箱：</strong></span>huanghua@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/17<br/>
     * <span><strong>调用方法：</strong></span>/role/role-info
     * @apiSampleRequest  http://qa.uniwlan.com/role/role-info
     *
     * @apiSuccess(返回值) {object}  data  角色列表数据
     * @apiSuccess(返回值) {string}  pages 分页数据数据
     *
     */
    public function actionRoleInfo()
    {
        $params = \Yii::$app->request->queryParams;
//        if(!empty($this->companyId)){
//            $params['companyId']  = $this->companyId;
//        }
        $model = new Role();
        $memberInfo = $model->search($params);
        $pagination = $memberInfo->pagination;
        $pages = Func::getPagesFormat($pagination);
        return json_encode(['data' => $memberInfo->models, 'pages' => $pages]);

    }

    /**
     * @api{post} /role/add-role 角色管理 - 新增角色
     * @apiVersion  1.0.0
     * @apiName 角色管理 - 新增角色
     * @apiGroup role
     * @apiPermission 管理员
     *
     * @apiParam {string} name 角色名称
     * @apiParam {string} companyId 公司id
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "name": "哈哈",
     *        "companyId": "1",
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 角色管理 - 新增角色<br/>
     * <span><strong>作   者：</strong></span>黄华<br/>
     * <span><strong>邮   箱：</strong></span>huanghua@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/17<br/>
     * <span><strong>调用方法：</strong></span>/role/add-role
     * @apiSampleRequest  http://qa.uniwlan.com/role/add-role
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"新增成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *   'data':{
     *     'name':'新增角色名不能为空'
     *   }}
     */
    public function actionAddRole()
    {
        $post = \Yii::$app->request->post();
        $model = new RoleForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->addMyData();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '新增成功']);
            } else {
                return json_encode(['status' => 'success', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api{post} /role/update-role 角色管理 - 修改角色
     * @apiVersion  1.0.0
     * @apiName 角色管理 - 修改角色
     * @apiGroup role
     * @apiPermission 管理员
     *
     * @apiParam {int} id   修改的id
     * @apiParam {string} name 角色名称
     * @apiParam {int} companyId 所属公司id
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "id": "添加功能",
     *        "name": "哈哈",
     *        "companyId": "2",
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 角色管理 - 修改角色<br/>
     * <span><strong>作   者：</strong></span>黄华<br/>
     * <span><strong>邮   箱：</strong></span>huanghua@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/17<br/>
     * <span><strong>调用方法：</strong></span>/role/update-role
     * @apiSampleRequest  http://qa.uniwlan.com/role/role-function
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"修改成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *   'data':{
     *     'name':'修改功能名不能为空'
     *   }}
     */
    public function actionUpdateRole()
    {
        $post = \Yii::$app->request->post();
        $model = new RoleForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->updateData();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'success', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 云运动  - 角色管理 - 查看详情下的所有角色员工详情
     * @author Huang hua <huanghua@itsports.club>
     * @update 2017-6-17
     * @return string
     */
    public function actionGetEmployeeMember()
    {
        $roleId = Yii::$app->request->get('roleId');
        $keywords = Yii::$app->request->get('keywords');
        if (!empty($roleId)) {
            $model = new Employee();
            $roleInfo = $model->getRoleModel($roleId, $keywords);
            $pagination = $roleInfo->pagination;
            $pages = Func::getPagesFormat($pagination);
            return json_encode(['data' => $roleInfo->models, 'pages' => $pages]);
        } else {
            return false;
        }

    }

    /**
     *后台角色管理 - 角色详情 - 移除角色
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/17
     * @return bool|string
     */
    public function actionUpdateAdmin()
    {
        $id = \Yii::$app->request->get('id');
        $status = Role::getUpdateAdmin($id);

        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }

    }

    /**
     *后台角色管理 - 角色列表- 删除角色
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/6/17
     * @return bool|string
     */
    public function actionDelete()
    {
        $roleId = Yii::$app->request->get('roleId');
        $model = new Role();
        $delRes = $model->getRoleDelete($roleId);
        if ($delRes) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     *角色管理 - 分配员工 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/17
     * @return bool|string
     */
    public function actionRoleDate()
    {
        $params = $this->get;
        $model = new Employee();
        $memberInfo = $model->roleSearch($params);

        $pagination = $memberInfo->pagination;
        $count = $memberInfo->pagination->totalCount;
        $pages = Func::getPagesFormat($pagination);

        return json_encode(['data' => $memberInfo->models, 'count' => $count, 'pages' => $pages]);
    }

    /**
     *后台角色管理 - 分配员工 - 点击完成
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/17
     * @return bool|string
     */
    public function actionUpdateEmployee()
    {
        $roleId = \Yii::$app->request->post('roleId');//角色id
        $adminId = \Yii::$app->request->post('adminId');//员工表管理员id
        $status = Role::getUpdateEmployee($roleId, $adminId);

        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }

    }

    /**
     * @api{get} /role/get-role 选择角色 - 列表
     * @apiVersion  1.0.0
     * @apiName 选择角色 - 列表
     * @apiGroup Role
     * @apiPermission 管理员
     *
     * @apiParam {int} companyId  公司id
     *
     * @apiParamExample {json} Request Example
     * {
     *     "companyId": "1",
     * }
     * @apiDescription 权限管理 - 选择角色 - 列表<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/5<br/>
     * <span><strong>调用方法：</strong></span>/role/get-role
     * @apiSampleRequest  http://qa.uniwlan.com/role/get-role
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {"data": [{"id":"1","name":"水吧","status":"1"(1正常，2停用)}]}
     * @apiErrorExample {json} 错误示例:
     * {"data": []}
     */
    public function actionGetRole()
    {
        $id = \Yii::$app->request->get('companyId');
        $name = \Yii::$app->request->get('name');
        if (empty($id) || !isset($id)) {
            $id = $this->companyId;
        }
        $model = new Role();
        $data = $model->getRole($id, $name);
        return json_encode(['data' => $data]);
    }

    /**
     * @api{get} /role/update-status 角色停用
     * @apiVersion  1.0.0
     * @apiName 角色停用
     * @apiGroup Role
     * @apiPermission 管理员
     *
     * @apiParam {int} roleId  角色id
     *
     * @apiParamExample {json} Request Example
     * {
     *     "roleId": "1",
     * }
     * @apiDescription 角色停用<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/6<br/>
     * <span><strong>调用方法：</strong></span>/role/update-status
     * @apiSampleRequest  http://qa.uniwlan.com/role/update-status
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
        $id = \Yii::$app->request->get('roleId');
        $model = new Role();
        $data = $model->updateStatus($id);
        if ($data === 1 || $data === 2) {
            return json_encode(['status' => 'success', 'data' => '修改成功', 'edit' => $data]);
        } else {
            return json_encode(['status' => 'error', 'data' => $data]);
        }
    }
}
