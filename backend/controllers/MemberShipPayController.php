<?php

namespace backend\controllers;
use backend\models\MemberShipLogic;
use backend\modules\v1\models\PaymentCardForm;
use backend\modules\v1\models\PaymentForm;
use common\models\base\Order;
//微信扫码支付
require "../components/mbpayment/lib/WxPay.Api.php";
require "../components/mbpayment/lib/WxPay.Data.php";
require "../components/mbpayment/example/WxPay.NativePay.php";
//require "../components/mbpayment/example/log.php";

 //支付宝网站支付
require  "../components/mbscanpay/config.php";
require "../components/mbscanpay/pagepay/service/AlipayTradeService.php";
require "../components/mbscanpay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php";
require "../components/mbscanpay/aop/AopClient.php";

class MemberShipPayController extends \yii\web\Controller
{
    // 关掉csrf请求
    public $enableCsrfValidation = false;
    /**
     * @api {post} /member-ship-pay/sell-card   微信二维码支付
     * @apiVersion  1.0.0
     * @apiName            微信二维码支付
     * @apiGroup           oregister
     * @apiPermission     管理员
     * @apiParam  {string}   paymentType   付款类型：wx
     * @apiParam  {int}      typeId    卡种id
     * @apiParam  {int}      memberId  会员id
     * @apiParam  {string}     type     购买物品标志
     * @apiParam  {string}   csrf_    防止跨站伪造请求
     * @apiParamExample {json} 请求参数
     *   POST /member-ship-pay/sell-card
     *   {
     *         "paymentType":wx      //微信扫码支付
     *         "typeId":45781         // 卡种id
     *         "memberId":78278       // 会员id
     *         "type": machineCard    //购买类型 卡
     *   }
     * @apiDescription   迈步微信二维码扫码支付
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br/>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/10/26
     * @apiSampleRequest  http://qa.aixingfu.net/member-ship-pay/sell-card
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情
     *{
     *  "status":"success"   // 请求成功 返回success  请求失败返回error
     *  "data" : "weixin://wxpay/bizpayurl?pr=iGfCe4K"   // 请求的二维码链接 请求失败返回报错信息
     * },
     */
    public function actionSellCard(){
     $post   = \Yii::$app->request->post();
     $model  = new PaymentForm();
     $model->isNotMachinePay = "right";
     if ($model->load($post, '') && $model->validate()) {
         $data = $model->paymentCard();
         if(isset($data->id)){
             $input = new \backend\components\mbpayment\lib\WxPayUnifiedOrder();
             $notify = new \backend\components\mbpayment\example\NativePay();
             $input->SetBody("迈步一体机购卡");
             $input->SetAttach($data->id);
             $input->SetOut_trade_no($data->order_number);
             $input->SetTotal_fee($data->total_price*100);
             $input->SetTime_start(date("YmdHis"));
             $input->SetTime_expire(date("YmdHis", time() + 600));
             $input->SetGoods_tag("迈步一体机购卡");
             $input->SetNotify_url("http://qa.aixingfu.net/member-ship-pay/notify");
             $input->SetTrade_type("NATIVE");
             $input->SetProduct_id($data->id);
             $result = $notify->GetPayUrl($input);
             $url2   = $result["code_url"];
             return json_encode(['status' => 'success','data' =>$url2,"orderId"=>$data->id]);
         }else {
             return json_encode(['status' => 'error','data' =>$data,"orderId"=>null]);
         }
     }else{
         return json_encode(['status' => 'error','data' =>$model->errors,"orderId"=>null]);
     }
    }
    /**
     * @api {post} /member-ship-pay/notify   微信扫码支付回调（测试专用）
     * @apiVersion  1.0.0
     * @apiName            微信扫码支付回调(测试专用)
     * @apiGroup           register
     * @apiPermission     管理员
     * @apiParam  {string}   requestData   请求参数
     * @apiParamExample {json} 请求参数
     *   POST  /member-ship-pay/notify
     *   {
     *         "requestData":xml请求数据      //微信请求参数
     *   }
     * @apiDescription   迈步微信二维码扫码支付回调
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br/>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/10/27
     * @apiSampleRequest  http://qa.aixingfu.net/member-ship-pay/notify
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情
     *{
     *  "data" : "请求很多数据"   // 请求的二维码链接 请求失败返回报错信息
     * },
     */
    public function actionNotify(){
        $rawXml = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
        libxml_disable_entity_loader(true);
        $ret = json_decode(json_encode(simplexml_load_string($rawXml,'SimpleXMLElement',LIBXML_NOCDATA)),true);
        $payErrorResult = "<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>";
        $paySuccessResult = "<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>";
        if($ret["return_code"]==="FAIL"){
           echo $payErrorResult;
           exit;
        }
        if($ret["return_code"]==="SUCCESS"){
            $payment = new PaymentCardForm();
            $pay     = $payment->setMemberCardInfo($ret["attach"]);
            $payment->sendMessage();
            if($pay === 'SUCCESS'){
                echo $paySuccessResult;
                exit;
            }
        }
        echo $payErrorResult;
    }
    /**
     * @api {post} /member-ship-pay/ali-sell-card   支付宝网站支付
     * @apiVersion  1.0.0
     * @apiName            支付宝网站支付
     * @apiGroup           register
     * @apiPermission     管理员
     * @apiParam  {string}   paymentType   付款类型：zfbScanCode
     * @apiParam  {int}      typeId       卡种id
     * @apiParam  {int}      memberId     会员id
     * @apiParam  {string}     type       购买物品标志 （固定值：card）
     * @apiParam  {string}     csrf_        防止跨站伪造请求
     * @apiParamExample {json} 请求参数
     *   POST   /member-ship-pay/ali-sell-card
     *   {
     *         "paymentType":zfbScanCode    //微信扫码支付(固定值)
     *         "typeId":45781              // 卡种id
     *         "memberId":78278           // 会员id
     *         "type": card              //购买类型 卡
     *   }
     * @apiDescription   支付宝二维码支付
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br/>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/10/26
     * @apiSampleRequest  http://qa.aixingfu.net/member-ship-pay/ali-sell-card
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情
     *{
     *  "status":"success"   // 请求成功 返回success  请求失败返回error
     *  "data" :  （好像是一个网页）
     * },
     */
    public function actionAliSellCard(){
            $post   = \Yii::$app->request->post();
            $model  = new PaymentForm();
            $model->isNotMachinePay = "right";
            if ($model->load($post, '') && $model->validate()) {
                $data = $model->paymentCard();
            if(isset($data->id)){
                // 获取config指定文件中配置数据
                $config = $model->getMbScanConfig();      // 获取迈步的config文件
                $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
                $payRequestBuilder->setBody($data->id);                      // 订单id
                $payRequestBuilder->setSubject("迈步一体机购卡");          // 订单标题
                $payRequestBuilder->setTotalAmount($data->total_price);     //订单总金额
                $payRequestBuilder->setOutTradeNo($data->order_number);      // 原订单编号
                $aop = new \AlipayTradeService($config);
                $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);
                return $response;
            }else{
                return json_encode(["status"=>"error","message"=>$data]);
            }
        }
        return json_encode(["status"=>"error","message"=>$model->errors]);
    }
    /**
     * 会员入会 -  检查订单状态
     * @create 2017/10/26
     * @author houkaixin<houkaixin@itsports.club>
     * @param  $orderId    // 订单id
     * @return  json
     */
    public function actionCheckOrderStatus($orderId = null){
          $model = new MemberShipLogic();
          $status = $model->checkOrderStatus($orderId);
          return json_encode(["orderStatus"=>$status]);
    }
    /**
     * 会员入会 - 迈步支付宝回调
     * @create 2017/10/28
     * @author houkaixin<houkaixin@itsports.club>
     * @return  json
     */
    public function actionAliNotify(){
          $aop           = new \AopClient();
          $model         = new PaymentForm();
      //    $publicKey     = $model->getPublicKey();
          $flag          = $aop->rsaCheckV1(\Yii::$app->request->post(), NULL, "RSA");
          $success       = strtolower('SUCCESS');
            if($flag&&($_POST["subject"]=="迈步一体机购卡")) {
                $out_trade_no = $_POST['out_trade_no'];
                $trade_status = $_POST['trade_status'];
                $body         = $_POST['body'];
                $order = Order::findOne(['order_number'=>$out_trade_no]);
                if(empty($order)){
                    echo "FAIL";
                    exit;
                }
                if($trade_status == 'TRADE_FINISHED') {
                    $payment = new PaymentCardForm();
                    $pay     = $payment->setMemberCardInfo($body,$out_trade_no);
                    $payment->sendMessage();
                    if($pay === 'SUCCESS'){
                        echo $success;
                        exit;
                    }
                }
                else if ($trade_status == 'TRADE_SUCCESS') {
                    $payment = new PaymentCardForm();
                    $pay     = $payment->setMemberCardInfo($body,$out_trade_no);
                    $payment->sendMessage();
                    if($pay === 'SUCCESS'){
                        echo $success;
                        exit;
                    }
                }
                echo $success;		//请不要修改或删除
            }
            else {
                //验证失败
                echo "FAIL";
            }
    }
}
?>