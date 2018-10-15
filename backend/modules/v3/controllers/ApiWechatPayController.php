<?php
namespace backend\modules\v3\controllers;

use yii\web\Response;
use yii\rest\ActiveController;
use backend\components\appPay\WePay;
use backend\modules\v3\models\Payment;
use backend\modules\v3\models\PaymentForm;

class ApiWechatPayController extends ActiveController
{
    public $modelClass = 'backend\modules\v3\models\Payment';

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
     * @api {post} /v3/api-wechat-pay/mini-program-pay  小程序支付接口
     * @apiVersion  1.0.0
     * @apiName        小程序支付接口.小程序支付接口
     * @apiGroup       member
     * @apiPermission  管理员
     * @apiParam  {string}       type            销售类型：card 会员卡 、charge 私教课
     * @apiParam  {int}          typeId          卡种id 、私课id
     * @apiParam  {int}          openid          openid
     * @apiParam  {int}          memberId        会员id
     * @apiParam  {int}          amountMoney     总金额
     * @apiParam  {string}       paymentType     支付方式：wx
     * @apiParamExample {json} 请求参数
     *   POST /v3/api-wechat-pay/mini-program-pay  小程序支付接口
     *   {
     *      "type"        : card         //销售类型：card 会员卡 、charge 私教课 、cabinet 柜子
     *      "typeId"      : 1            //卡种id 、私课id、柜子id
     *      "openid"      : 123          //openid
     *      "memberId"    : 1            //会员id
     *      "amountMoney" : 1            //总金额
     *      "paymentType" : wx           //支付方式：wx
     *   }
     * @apiDescription   小程序支付接口
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/2/7
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-wechat-pay/mini-program-pay
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code"   : 1,
     *  "status" : "success",
     *  "message": "成功",
     *  "data"   : [
     *  {
     *  }
     *  ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code"   : 0,
     *  "status" : "error",
     *  "message": "失败"
     *}
     */
    public function actionMiniProgramPay()
    {
        $post = \Yii::$app->request->post();
        $model = new PaymentForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->paymentCard();
            if (isset($data->id)) {
                $post['attach']       = $data->id;
                $post['out_trade_no'] = $data->order_number;
                $post['price']        = $data->total_price * 100;
                $config  = Payment::getMiniConfig($post);
                $appPay  = new WePay();
                $appData = $appPay->getMiniContentSign($config);
                return ['code' => '1', 'status' => 'success', 'message' => '成功', 'data' => $appData, 'price' => $data->total_price];
            } else {
                return ['code' => '0', 'status' => 'error', 'message' => '失败', 'data' => $data];
            }
        } else {
            $result = ['code' => '0','status' => 'error', 'message' => '失败', 'data' => $model->errors];
        }
        return $result;
    }

    /**
     * @api {post} /v3/api-wechat-pay/official-account-pay  公众号支付接口
     * @apiVersion  1.0.0
     * @apiName        公众号支付接口.公众号支付接口
     * @apiGroup       member
     * @apiPermission  管理员
     * @apiParam  {string}       type            销售类型：card 会员卡 、charge 私教课 、cabinet 柜子
     * @apiParam  {int}          typeId          卡种id 、私课id、柜子id
     * @apiParam  {int}          openid          openid
     * @apiParam  {int}          memberId        会员id
     * @apiParam  {int}          amountMoney     总金额
     * @apiParam  {string}       paymentType     支付方式：wx
     * @apiParamExample {json} 请求参数
     *   POST /v3/api-wechat-pay/official-account-pay 公众号支付接口
     *   {
     *      "type"        : card         //销售类型：card 会员卡 、charge 私教课 、cabinet 柜子
     *      "typeId"      : 1            //卡种id 、私课id、柜子id
     *      "openid"      : 123          //openid
     *      "memberId"    : 1            //会员id
     *      "amountMoney" : 1            //总金额
     *      "paymentType" : wx           //支付方式：wx
     *   }
     * @apiDescription   公众号支付接口
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/2/7
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-wechat-pay/official-account-pay
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code"   : 1,
     *  "status" : "success",
     *  "message": "成功",
     *  "data"   : [
     *  {
     *  }
     *  ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code"   : 0,
     *  "status" : "error",
     *  "message": "失败"
     *}
     */
    public function actionOfficialAccountPay()
    {
        $post  = \Yii::$app->request->post();
        $model = new PaymentForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->paymentCard();
            if (isset($data->id)) {
                $post['attach']       = $data->id;
                $post['out_trade_no'] = $data->order_number;
                $post['price']        = $data->total_price * 100;   //单位是分
                $config  = Payment::getOfficialConfig($post);
                $appPay  = new WePay();
                $appData = $appPay->getOfficialContentSign($config);
                return ['code' => '1', 'status' => 'success', 'message' => '成功', 'data' => $appData, 'price' => $data->total_price];
            } else {
                return ['code' => '0', 'status' => 'error', 'message' => '失败', 'data' => $data];
            }
        } else {
            return ['code' => '0', 'status' => 'error', 'message' => '失败', 'data' => $model->errors];
        }
    }

    /**
     * @api {post} /v3/api-wechat-pay/save-the-order  支付成功保存订单
     * @apiVersion  1.0.0
     * @apiName        支付成功保存订单.支付成功保存订单
     * @apiGroup       member
     * @apiPermission  管理员
     * @apiParam  {string}     order_number      订单编号
     * @apiParamExample {json} 请求参数
     *   POST /v3/api-wechat-pay/save-the-order  支付成功保存订单
     *   {
     *      "order_number"           : '12345'         //订单编号
     *      "cabinet_id"             : '666'           //柜子id
     *      "start_rent"             : '1234567890'    //起租日
     *      "end_rent"               : '1234567890'    //到期日
     *      "give_month"             : '1'             //赠送月数
     *      "deposit"                : '50'            //押金
     *      "total_price"            : '360'           //总金额
     *      "charge_id"              : '556'           //私教课id
     *      "charge_num"             : '6'             //购买私教的节数、套数
     *      "charge_class_number_id" : '12'            //私课编号表id:购买小团体课用
     *   }
     * @apiDescription   支付成功保存订单
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/2/7
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-wechat-pay/save-the-order
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code"   : 1,
     *  "status" : "success",
     *  "message": "成功",
     *  "data"   : [
     *  {
     *  }
     *  ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code"   : 0,
     *  "status" : "error",
     *  "message": "没有数据"
     *  "data"   : []
     *}
     */
    public function actionSaveTheOrder()
    {
        $param = \Yii::$app->request->post();
        $model = new PaymentForm();
        $data  = $model->saveTheOrder($param);
        if ($data) {
            return ['code' => '1', 'status' => 'success', 'message' => '成功', 'data' => $data];
        }  else {
            return ['code' => '0', 'status' => 'error', 'message' => '失败', 'data' => []];
        }
    }
}
