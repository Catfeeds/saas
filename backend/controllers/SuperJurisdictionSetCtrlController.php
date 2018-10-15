<?php

namespace backend\controllers;

use backend\models\Auth;

class SuperJurisdictionSetCtrlController extends BaseController
{
    /*
     * author 程丽明
     * content 权限管理-权限管理首页
     * date  2017/7/5 12:55
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /*
        * author 程丽明
        * content 权限管理-权限管理设置页面
        * date  2017/7/5 12:55
        */
    public function actionSet()
    {
        return $this->render('jurisdictionSet');
    }

    /**
     * @api{get} /super-jurisdiction-set-ctrl/get-venue 获取权限同步的场馆
     * @apiVersion  1.0.0
     * @apiName 获取权限同步的场馆
     * @apiGroup SuperJurisdictionSetCtrl
     * @apiPermission 管理员
     *
     * @apiParam {int} roleId  角色id
     *
     * @apiParamExample {json} Request Example
     * {
     *     "roleId": "1",
     * }
     * @apiDescription 获取权限同步的场馆<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/10<br/>
     * <span><strong>调用方法：</strong></span>/super-jurisdiction-set-ctrl/get-venue
     * @apiSampleRequest  http://qa.uniwlan.com/super-jurisdiction-set-ctrl/get-venue
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
        $id   = \Yii::$app->request->get('roleId');
        $auth = new Auth();
        return json_encode($auth->getVenueDataByCompany($id));
    }
}
