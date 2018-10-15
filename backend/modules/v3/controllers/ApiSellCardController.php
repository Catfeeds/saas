<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 10:33
 */
namespace backend\modules\v3\controllers;

use backend\modules\v3\models\CardModel;
use yii\web\Response;
use yii\rest\ActiveController;

class ApiSellCardController extends ActiveController
{

    public $modelClass = 'backend\modules\v3\models\CardCategory';

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
     * @api {get} /v3/api-sell-card/get-card-list   销售的会员卡列表
     * @apiVersion  1.0.0
     * @apiName        销售的会员卡列表.销售的会员卡列表
     * @apiGroup       memberCard
     * @apiPermission  管理员
     * @apiParam  {int}     venueId       场馆id
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-sell-card/get-card-list  销售的会员卡列表
     *   {
     *      "venueId"  : 2      //场馆id
     *   }
     * @apiDescription   销售的会员卡列表
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/2/5
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-sell-card/get-card-list
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "成功",
     *  "data": [
     *  {
     *  ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "没有数据"
     *  "data" : []
     *}
     */
    public function actionGetCardList($venueId)
    {
        $model = new CardModel();
        $data  = $model->getCardList($venueId);
        if($data){
            return ['code' => 1, 'status' => 'success', 'message' => "成功", 'data' => $data];
        }else{
            return ['code' => 0, 'status' => 'error', 'message' => "没有数据", 'data' => []];
        }
    }

    /**
     * @api {get} /v3/api-sell-card/get-card-info   销售的会员卡详情
     * @apiVersion  1.0.0
     * @apiName        销售的会员卡详情.销售的会员卡详情
     * @apiGroup       memberCard
     * @apiPermission  管理员
     * @apiParam  {int}     venueId       场馆id
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-sell-card/get-card-info  销售的会员卡详情
     *   {
     *      "id"  : 2      //卡种id
     *   }
     * @apiDescription   销售的会员卡列表
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/2/5
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-sell-card/get-card-info
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "成功",
     *  "data": [
     *  {
     *  ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "没有数据"
     *  "data" : []
     *}
     */
    public function actionGetCardInfo($id)
    {
        $model = new CardModel();
        $data  = $model->getCardInfo($id);
        if($data){
            return ['code' => 1, 'status' => 'success', 'message' => "成功", 'data' => $data];
        }else{
            return ['code' => 0, 'status' => 'error', 'message' => "没有数据", 'data' => []];
        }
    }



}