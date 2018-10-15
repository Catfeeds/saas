<?php

namespace backend\controllers;

use backend\models\ApplyRecord;
use backend\models\ApplyRecordForm;
use common\models\Func;

class CorporateAllianceController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @api {post} /corporate-alliance/apply 公司联盟-申请通店
     * @apiVersion 1.0.0
     * @apiName 申请通店
     * @apiGroup CorporateAlliance
     * @apiPermission 管理员
     *
     * @apiParam {string} beApply 申请公司
     * @apiParam {string} startApply 通店开始日期
     * @apiParam {string} endApply 通店结束日期
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     * {
     *      "beApply": "我爱运动",
     *      "startApply": "2017-06-27",
     *      "endApply": "2017-08-27",
     *      "_csrf_backend":""
     * }
     * @apiDescription 公司联盟 - 申请通店<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/27<br>
     * <span><strong>调用方法：</strong></span>/corporate-alliance/apply
     *
     * @apiSampleRequest  http://qa.uniwlan.com/corporate-alliance/apply
     * @apiSuccess (返回值) {string} status 返回状态
     * @apiSuccess (返回值) {string} data   返回状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"申请成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':"申请失败"}
     */
    public function actionApply()
    {
        $post = \Yii::$app->request->post();
        $companyId = $this->companyId;
        $model = new ApplyRecordForm();
        if ($model->load($post, '') && $model->validate($post)) {
            $data = $model->saveApply($companyId);
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '申请成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api {get} /corporate-alliance/cancel-apply 公司联盟-取消申请
     * @apiVersion 1.0.0
     * @apiName 取消申请
     * @apiGroup Corporate-Alliance
     * @apiPermission 管理员
     *
     * @apiParam {string} applyRecordId 申请记录id
     *
     * @apiParamExample {json} Request Example
     * {
     *      "applyRecordId": "2",
     * }
     * @apiDescription 公司联盟-取消申请<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/27<br>
     * <span><strong>调用方法：</strong></span>/corporate-alliance/cancel-apply
     *
     * @apiSampleRequest  http://qa.uniwlan.com/corporate-alliance/cancel-apply
     * @apiSuccess (返回值) {string} status 返回状态
     * @apiSuccess (返回值) {string} data   返回状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"取消成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':"取消失败"}
     */
    public function actionCancelApply()
    {
        $id = \Yii::$app->request->get('applyRecordId');
        $model = new ApplyRecordForm();
        $data = $model->cancelApply($id);
        if ($data === true) {
            return json_encode(['status' => 'success', 'data' => '取消成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '取消失败']);
        }
    }

    /**
     * @api {get} /corporate-alliance/overdue-apply 公司联盟-过期
     * @apiVersion 1.0.0
     * @apiName 过期
     * @apiGroup Corporate-Alliance
     * @apiPermission 管理员
     *
     * @apiParam {string} applyRecordId 申请记录id
     *
     * @apiParamExample {json} Request Example
     * {
     *      "applyRecordId": "2",
     * }
     * @apiDescription 公司联盟-过期<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/30<br>
     * <span><strong>调用方法：</strong></span>/corporate-alliance/overdue-apply
     *
     * @apiSampleRequest  http://qa.uniwlan.com/corporate-alliance/overdue-apply
     * @apiSuccess (返回值) {string} status 返回状态
     * @apiSuccess (返回值) {string} data   返回状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"申请已过期"}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':"操作失败"}
     */
    public function actionOverdueApply()
    {
        $id = \Yii::$app->request->get('applyRecordId');
        $model = new ApplyRecordForm();
        $data = $model->overdueApply($id);
        if ($data === true) {
            return json_encode(['status' => 'success', 'data' => '申请已过期']);
        } else {
            return json_encode(['status' => 'error', 'data' => '操作失败']);
        }
    }

    /**
     * @api {get} /corporate-alliance/pass-apply 公司联盟-通过申请
     * @apiVersion 1.0.0
     * @apiName 公司联盟-通过申请
     * @apiGroup Corporate-Alliance
     * @apiPermission 管理员
     *
     * @apiParam {string} applyRecordId 申请记录id
     *
     * @apiParamExample {json} Request Example
     * {
     *      "applyRecordId": "2",
     * }
     * @apiDescription 通过申请<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/27<br>
     * <span><strong>调用方法：</strong></span>/corporate-alliance/pass-apply
     *
     * @apiSampleRequest  http://qa.uniwlan.com/corporate-alliance/pass-apply
     * @apiSuccess (返回值) {string} status 返回状态
     * @apiSuccess (返回值) {string} data   返回状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"通过成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':"通过失败"}
     */
    public function actionPassApply()
    {
        $id = \Yii::$app->request->get('applyRecordId');
        $model = new ApplyRecordForm();
        $data = $model->passApply($id);
        if ($data === true) {
            return json_encode(['status' => 'success', 'data' => '通过成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '通过失败']);
        }
    }

    /**
     * @api {post} /corporate-alliance/not-pass-apply 公司联盟-拒绝申请
     * @apiVersion 1.0.0
     * @apiName 公司联盟 - 拒绝申请
     * @apiGroup Corporate-Alliance
     * @apiPermission 管理员
     *
     * @apiParam {string} recordId 申请记录id
     * @apiParam {string} notApplyLength 不可申请时长
     * @apiParam {string} note 备注
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     * {
     *      "recordId": "2",
     *      "notApplyLength": "30",
     *      "note": "很抱歉",
     *      "_csrf_backend":""
     * }
     * @apiDescription 公司联盟 - 拒绝申请<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/27<br>
     * <span><strong>调用方法：</strong></span>/corporate-alliance/not-pass-apply
     *
     * @apiSampleRequest  http://qa.uniwlan.com/corporate-alliance/not-pass-apply
     * @apiSuccess (返回值) {string} status 返回状态
     * @apiSuccess (返回值) {string} data   返回状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"拒绝成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':"拒绝失败"}
     */
    public function actionNotPassApply()
    {
        $post = \Yii::$app->request->post();
        $model = new ApplyRecordForm();
        if ($model->load($post, '') && $model->validate($post)) {
            $data = $model->notPassApply();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '拒绝成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api{get} /corporate-alliance/get-apply 获取申请列表信息
     * @apiVersion  1.0.0
     * @apiName 获取申请列表信息
     * @apiGroup CorporateAlliance
     * @apiPermission 管理员
     *
     * @apiParam {string} keywords 搜索的字段
     *
     * @apiParamExample {json} Request Example
     * {
     *      "keywords": "我爱运动",
     * }
     * @apiDescription 获取申请列表信息<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/27<br/>
     * <span><strong>调用方法：</strong></span>/corporate-alliance/get-apply
     * @apiSampleRequest  http://qa.uniwlan.com/corporate-alliance/get-apply
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * Array
     * (
     *   'name' => '我爱运动'
     *   'status' => '2'
     *   'start_apply' => '1496472588'
     *   'end_apply' => '1496572588'
     * )
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionGetApply()
    {
        $params = $this->get;
        $model = new ApplyRecord();
        $data = $model->getApply($params, $this->companyIds);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination);

        return json_encode(['data' => $data->models, 'pages' => $pages]);
    }

    /**
     * @api{get} /corporate-alliance/pending 待处理数据条数
     * @apiVersion  1.0.0
     * @apiName 待处理数据条数
     * @apiGroup Corporate-Alliance
     * @apiPermission 管理员
     *
     * @apiDescription 待处理数据条数<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/03<br/>
     * <span><strong>调用方法：</strong></span>/corporate-alliance/pending
     * @apiSampleRequest  http://qa.uniwlan.com/corporate-alliance/pending
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {"data":"2"}
     * @apiErrorExample {json} 错误示例:
     * {"data":""}
     */
    public function actionPending()
    {
        $model = new ApplyRecord();
        $data = $model->getPending($this->companyId);
        return json_encode(['data' => $data]);
    }

    /**
     * @api{get} /corporate-alliance/get-company 获取查询品牌名称
     * @apiVersion  1.0.0
     * @apiName 获取查询品牌名称
     * @apiGroup Corporate-Alliance
     * @apiPermission 管理员
     *
     * @apiDescription 获取查询品牌名称<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/29<br/>
     * <span><strong>调用方法：</strong></span>/corporate-alliance/get-company
     * @apiSampleRequest  http://qa.uniwlan.com/corporate-alliance/get-company
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {
     *     "data":{
     *       'id' => '1'
     *       'name' => '我爱运动'
     *     }
     * }
     * @apiErrorExample {json} 错误示例:
     * {"data":{}"}}
     */
    public function actionGetCompany()
    {
        $model = new ApplyRecord();
        $data = $model->getCompany($this->companyId);
        return json_encode(['data' => $data]);
    }

    /**
     * @api{get} /corporate-alliance/apply-details 获取通店详情
     * @apiVersion  1.0.0
     * @apiName 获取通店详情
     * @apiGroup CorporateAlliance
     * @apiPermission 管理员
     *
     * @apiParam {int} applyRecordId 申请记录id
     *
     * @apiParamExample {json} Request Example
     * {
     *      "applyRecordId": "2",
     * }
     * @apiDescription 获取通店详情<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/28<br/>
     * <span><strong>调用方法：</strong></span>/corporate-alliance/apply-details
     * @apiSampleRequest  http://qa.uniwlan.com/corporate-alliance/apply-details
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * Array
     * (
     *   'name' => '我爱运动'
     *   'status' => '2'
     *   'start_apply' => '1496472588'
     *   'end_apply' => '1496572588'
     *    'note' => '申请通店'
     * )
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionApplyDetails()
    {
        $id = \Yii::$app->request->get('applyRecordId');
        if (!empty($id)) {
            $model = new ApplyRecord();
            $data = $model->getApplyData($id, $this->companyId);
            return json_encode($data);
        } else {
            return false;
        }
    }

    /**
     * @api{get} /corporate-alliance/apply-record 获取申请记录
     * @apiVersion  1.0.0
     * @apiName 获取申请记录
     * @apiGroup Corporate-Alliance
     * @apiPermission 管理员
     *
     * @apiParam {int} applyRecordId 申请记录id
     *
     * @apiParamExample {json} Request Example
     * {
     *      "applyRecordId": "2",
     * }
     * @apiDescription 公司联盟-获取申请记录<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/28<br/>
     * <span><strong>调用方法：</strong></span>/corporate-alliance/apply-record
     * @apiSampleRequest  http://qa.uniwlan.com/corporate-alliance/apply-record
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * Array
     * (
     *   'name' => '我爱运动'
     *   'status' => '2'
     *   'start_apply' => '1496472588'
     *   'end_apply' => '1496572588'
     *    'note' => '申请通店'
     * )
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionApplyRecord()
    {
        $id = \Yii::$app->request->get('applyRecordId');
        if (!empty($id)) {
            $model = new ApplyRecord();
            $data = $model->getRecordData($id, $this->companyIds);
            return json_encode($data);
        } else {
            return false;
        }
    }
}
