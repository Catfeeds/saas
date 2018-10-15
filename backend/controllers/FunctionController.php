<?php

namespace backend\controllers;

use backend\models\FunctionalForm;
use common\models\base\Functional;
use common\models\Func;
use Yii;
class FunctionController extends \backend\controllers\BaseController
{
    /**
     * @return string
     * auther liangkk
     * 描述权限功能管理
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * @api{get} /function/function-info 功能管理 - 功能列表数据遍历
     * @apiVersion  1.0.0
     * @apiName 功能管理 - 功能列表数据遍历
     * @apiGroup function
     * @apiPermission 管理员
     *
     * @apiDescription 功能管理 - 功能列表数据遍历<br/>
     * <span><strong>作   者：</strong></span>黄华<br/>
     * <span><strong>邮   箱：</strong></span>huanghua@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/17<br/>
     * <span><strong>调用方法：</strong></span>/function/function-info
     * @apiSampleRequest  http://qa.uniwlan.com/function/function-info
     *
     * @apiSuccess(返回值) {object}  data  功能列表数据
     * @apiSuccess(返回值) {string}  pages 分页数据数据
     *
     */
    public function actionFunctionInfo()
    {
        $params = \Yii::$app->request->queryParams;
        $model = new FunctionalForm();
        $memberInfo = $model->search($params);
        $pagination = $memberInfo->pagination;
        $pages = Func::getPagesFormat($pagination);
        return json_encode(['data' => $memberInfo->models, 'pages' => $pages]);

    }

    /**
     * @api{post} /function/top-module 功能管理 - 新增功能
     * @apiVersion  1.0.0
     * @apiName 功能管理 - 新增功能
     * @apiGroup function
     * @apiPermission 管理员
     *
     * @apiParam {string} name 功能名称
     * @apiParam {string} eName 英文名称
     * @apiParam {string} note 功能描述
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "name": "添加功能",
     *        "eName": "add",
     *        "note": "水吧管理员",
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 功能管理 - 新增功能<br/>
     * <span><strong>作   者：</strong></span>黄华<br/>
     * <span><strong>邮   箱：</strong></span>huanghua@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/17<br/>
     * <span><strong>调用方法：</strong></span>/function/add-function
     * @apiSampleRequest  http://qa.uniwlan.com/function/add-function
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
     *     'name':'新增功能名不能为空'
     *   }}
     */
    public function actionAddFunction()
    {
        $post  = \Yii::$app->request->post();
        $model = new FunctionalForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->addMyData();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '新增成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api{post} /function/update-function 功能管理 - 修改功能
     * @apiVersion  1.0.0
     * @apiName 功能管理 - 修改功能
     * @apiGroup function
     * @apiPermission 管理员
     *
     * @apiParam {string} id   修改的id
     * @apiParam {string} name 功能名称
     * @apiParam {string} eName 英文名称
     * @apiParam {string} note 功能描述
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "id":"1"
     *        "name": "添加功能",
     *        "eName": "add",
     *        "note": "水吧管理员",
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 功能管理 - 修改功能<br/>
     * <span><strong>作   者：</strong></span>黄华<br/>
     * <span><strong>邮   箱：</strong></span>huanghua@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/17<br/>
     * <span><strong>调用方法：</strong></span>/function/update-function
     * @apiSampleRequest  http://qa.uniwlan.com/function/update-function
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
    public function actionUpdateFunction()
    {
        $post  = \Yii::$app->request->post();
        $model = new FunctionalForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->updateData();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api {get} /function/delete-function 功能管理 - 删除功能
     * @apiVersion  1.0.0
     * @apiName 功能管理 - 删除功能
     * @apiGroup function
     * @apiPermission 管理员
     *
     * @apiParam {int}  functionId  功能ID.
     *
     * @apiDescription 功能管理 - 删除功能<br/>
     * <span><strong>作   者：</strong></span>黄华<br/>
     * <span><strong>邮   箱：</strong></span>huanghua@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/17<br/>
     * <span><strong>调用方法：</strong></span>/function/delete-function
     * @apiSampleRequest  http://qa.uniwlan.com/function/delete-function
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"删除成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *   'data':{
     *     'name':'删除失败'
     *   }}
     */
    public function actionDeleteFunction($functionId)
    {
        $model = new FunctionalForm();
        $delete = $model->getRoleDelete($functionId);
        if ($delete) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }


}
