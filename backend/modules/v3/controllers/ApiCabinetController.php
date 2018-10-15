<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/26 0026
 * Time: 下午 17:20
 */

namespace backend\modules\v3\controllers;

use backend\modules\v3\models\CabinetModel;
use yii\web\response;
use yii\rest\ActiveController;

class ApiCabinetController extends ActiveController
{
    public $modelClass = 'backend\modules\v3\models\Cabinet';

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
     * @api {get}      /v3/api-cabinet/get-cabinet-types  展示柜子类型列表
     * @apiVersion      1.0.0
     * @apiName         展示柜子类型列表
     * @apiGroup        cabinet
     * @apiPermission  管理员
     * @apiParam  {string}  venueId    场馆id
     * @apiParamExample {json} 请求参数
     * get   /v3/api-cabinet/get-cabinet-types  展示柜子类型列表
     *   {
     *      "venueId"   :  "1"               公司id
     *   }
     * @apiDescription  微信已购私课列表
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/9
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-cabinet/get-cabinet-types  展示柜子类型列表
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     * {
     *  "code"   : 1,              //成功标识
     *  "status" : "success",      //成功标识
     *  "message":"请求成功"        //成功提示信息
     *  "data"   : [
     *  {
     *     "id": "1",
     *     "type_name": "男士大柜",
     *     "sex": "3",
     *     "created_at": "1497608469",
     *     "venue_id": "2",
     *     "company_id": "1",
     *     "cabinet_model": null,
     *     "cabinet_type": null
     *  },
     *  {
     *     "id": "6",
     *     "type_name": "女士大柜",
     *     "sex": "3",
     *     "created_at": "1498913525",
     *     "venue_id": "2",
     *     "company_id": "1",
     *     "cabinet_model": null,
     *     "cabinet_type": null
     *  },
     *  ]
     * }
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-cabinet/get-cabinet-types  展示柜子类型列表
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *"code"   : 0,               //参数传入是否合法
     *"status" : "error",         //错误状态
     *"message": "",
     *"data"   : []
     *}
     */
    public function actionGetCabinetTypes($venueId)
    {
        $model = new CabinetModel();
        $data  = $model->getAllCabinetTypes($venueId);
        if ($data) {
            return ['code' => 1, 'status' => 'success', 'message' => '请求成功', 'data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据', 'data' => []];
        }
    }

    /**
     * @api {get}      /v3/api-cabinet/get-cabinet-list  柜子列表
     * @apiVersion      1.0.0
     * @apiName         柜子列表
     * @apiGroup        cabinet
     * @apiPermission  管理员
     * @apiParam  {string}  typeId    柜子类型id
     * @apiParamExample {json} 请求参数
     * get   /v3/api-cabinet/get-cabinet-list  柜子列表
     *   {
     *      "typeId"   :  "1"               柜子类型id
     *   }
     * @apiDescription  微信已购私课列表
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/9
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-cabinet/get-cabinet-list  柜子列表
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     * {
     *  "code"   : 1,              //成功标识
     *  "status" : "success",      //成功标识
     *  "message":"请求成功"        //成功提示信息
     *  "data"   : [
     * {
     *    "id": "2",
     *    "cabinet_type_id": "1",
     *    "cabinet_number": "大上海瑜伽健身馆-0002",   //柜子编号
     *    "status": "1",                            //柜子状态
     *    "creater_id": "12",
     *    "created_at": "1497611490",
     *    "update_at": "1497611490",
     *    "dayRentPrice": null,
     *    "monthRentPrice": "50.00",                 //月租费用
     *    "yearRentPrice": "50.00",                  //年租费用
     *    "company_id": "1",
     *    "venue_id": "2",
     *    "cabinet_model": "2",                      //柜子类型：1、大柜  2、中柜  3、小柜
     *    "cabinet_type": "1",                       //柜子类别：1、临时  2、正式
     *    "halfYearRentPrice": null,
     *    "deposit": null,
     *    "give_month": null,
     *    "cabinet_month": null,
     *    "cabinet_money": null,
     *    "cabinet_dis": null
     * },
     *  ]
     * }
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-cabinet/get-cabinet-types  展示柜子类型列表
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *"code"   : 0,               //参数传入是否合法
     *"status" : "error",         //错误状态
     *"message": "",
     *"data"   : []
     *}
     */
    public function actionGetCabinetList($typeId)
    {
        return ['code' => 0, 'status' => 'error', 'message' => '没有数据', 'data' => []];
        $model = new CabinetModel();
        $data  = $model->getCabinetList($typeId);
        if ($data) {
            return ['code' => 1, 'status' => 'success', 'message' => '请求成功', 'data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据', 'data' => []];
        }
    }


}