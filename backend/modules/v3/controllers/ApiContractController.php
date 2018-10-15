<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/6 0006
 * Time: 上午 9:27
 */

namespace backend\modules\v3\controllers;

use backend\modules\v3\models\ContractModel;
use yii\rest\ActiveController;
use yii\web\Response;

class ApiContractController extends ActiveController
{
    public $modelClass = 'backend\modules\v3\models\ContractModel';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                // restrict access to
                'Access-Control-Request-Method' => ['*'],
                // Allow only POST and PUT methods
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @api {get}       /v3/api-contract/get-contract-list  合同列表
     * @apiVersion      1.0.0
     * @apiName         合同列表
     * @apiGroup        contract
     * @apiPermission  管理员
     * @apiParam  {string}  memberId    会员id
     * @apiParamExample {json} 请求参数
     *   get /v3/api-contract/get-contract-list  合同列表
     *   {
     *      "mobile"  :  "1321313545"   会员手机号
     *   }
     * @apiDescription  微信已购私课列表
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/9
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-contract/get-contract-list  合同列表
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     * {
     *  "code"   : 1,              //成功标识
     *  "status" : "success",      //成功标识
     *  "message":"请求成功"        //成功提示信息
     *  "data"   : [
     *  ]
     * }
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-contract/get-contract-list  合同列表
     * @apiSuccessExample {json}返回值详情(失败时)
     * {
     *  "code"   : 0,               //参数传入是否合法
     *  "status" : "error",         //错误状态
     *  "message": "",
     *  "data"   : []
     * }
     */
    public function actionGetContractList()
    {
        $param = \Yii::$app->request->get();
        $model = new ContractModel();
        $data  = $model->getContractList($param);
        if ($data) {
            return ['code' => 1, 'status' => 'success', 'message' => '请求成功', 'data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据', 'data' => []];
        }    
    }

    /**
     * @api {get}       /v3/api-contract/get-contract-detail  合同详情
     * @apiVersion      1.0.0
     * @apiName         合同列表
     * @apiGroup        contract
     * @apiPermission  管理员
     * @apiParam  {string}  id    合同id
     * @apiParamExample {json}    请求参数
     *   get /v3/api-contract/get-contract-detail  合同详情
     *   {
     *      "id"   :  "1"   合同id
     *      "type" :  "1"   请求来源：1、微信小程序 2、公众号
     *   }
     * @apiDescription  微信已购私课列表
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/3/7
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-contract/get-contract-detail  合同详情
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     * {
     *  "code"   : 1,              //成功标识
     *  "status" : "success",      //成功标识
     *  "message":"请求成功"        //成功提示信息
     *  "data"   : [
     *  ]
     * }
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-contract/get-contract-detail  合同详情
     * @apiSuccessExample {json}返回值详情(失败时)
     * {
     *  "code"   : 0,               //错误标识
     *  "status" : "error",         //错误状态
     *  "message": "没有数据",
     *  "data"   : []
     * }
     */
    public function actionGetContractDetail()
    {
        $param = \Yii::$app->request->get();
        $model = new ContractModel();
        $data  = $model->getContractDetail($param);
        if ($data) {
            return ['code' => 1, 'status' => 'success', 'message' => '请求成功', 'data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据', 'data' => []];
        }
    }

}