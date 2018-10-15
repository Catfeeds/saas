<?php

namespace backend\controllers;
use backend\modules\v1\models\PaymentForm;
//require "../components/mbpayment/example/log.php";
// 支付宝扫码支付(扫码)
require_once '../components/mbscanpay1/dangmianfu_demo_php/f2fpay/model/builder/AlipayTradePrecreateContentBuilder.php';
require_once '../components/mbscanpay1/dangmianfu_demo_php/f2fpay/service/AlipayTradeService.php';
require_once '../components/mbscanpay1/dangmianfu_demo_php/aop/AopClient.php';
class MemberShipPayTwoController extends \yii\web\Controller
{
    // 关掉csrf请求
    public $enableCsrfValidation = false;
    /**
     * @api {post}   /member-ship-pay-two/ali-scan-pay  支付宝二维码支付
     * @apiVersion  1.0.0
     * @apiName            支付宝二维码支付
     * @apiGroup           Register
     * @apiPermission     管理员
     * @apiParam  {string}   paymentType   付款类型：zfbScanCode
     * @apiParam  {int}      typeId       卡种id
     * @apiParam  {int}      memberId     会员id
     * @apiParam  {string}     type       购买物品标志 （固定值：card）
     * @apiParam  {string}     csrf_        防止跨站伪造请求
     * @apiParamExample {json} 请求参数
     *   POST   /member-ship-pay-two/ali-scan-pay
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
     * @apiSampleRequest  http://qa.aixingfu.net/member-ship-pay-two/ali-scan-pay
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情
     *{
     *  "status":"success"   // 请求成功 返回success  请求失败返回error
     *  "data" :  （好像是一个网页）
     * },
     */
    public function actionAliScanPay(){
        $post   = \Yii::$app->request->post();
        $model  = new PaymentForm();
        $model->isNotMachinePay = "right";
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->paymentCard();
            if(isset($data->id)){
                // 获取config指定文件中配置数据
                $config = $model->getMb1ScanConfig();      // 获取迈步的config文件
                $qrPayRequestBuilder = new \AlipayTradePrecreateContentBuilder();
                $qrPayRequestBuilder->setBody($data->id);                      // 订单id
                $qrPayRequestBuilder->setSubject("迈步一体机购卡");          // 订单标题
                $qrPayRequestBuilder->setTotalAmount($data->total_price);     //订单总金额
                $qrPayRequestBuilder->setOutTradeNo($data->order_number);      // 原订单编号
                $qrPayRequestBuilder->setTimeExpress("5m");                   // 订单超时时间
                $qrPay = new \AlipayTradeService($config);
                $qrPayResult = $qrPay->qrPay($qrPayRequestBuilder);
                // 初始化赋值
                $qrcode  = "";
                $response="";
                // 根据状态值 进行业务处理
                switch ($qrPayResult->getTradeStatus()){
                    case "SUCCESS":
                        $response = $qrPayResult->getResponse();
                        $qrcode = $qrPay->create_erweima($response->qr_code);
                        break;
                    case "FAILED":
                        echo "支付宝创建订单二维码失败!!!"."<br>--------------------------<br>";
                        if(!empty($qrPayResult->getResponse())){
                            print_r($qrPayResult->getResponse());
                        }
                        break;
                    case "UNKNOWN":
                        echo "系统异常，状态未知!!!"."<br>--------------------------<br>";
                        if(!empty($qrPayResult->getResponse())){
                            print_r($qrPayResult->getResponse());
                        }
                        break;
                    default:
                        echo "不支持的返回状态，创建订单二维码返回异常!!!";
                        break;
                }
                if($qrPayResult->getTradeStatus()=="SUCCESS"){
                    return json_encode(['status' => 'success','data' =>$response->qr_code,"orderId"=>$data->id]);
                }else{
                    return json_encode(["status"=>"error","data"=>$qrPayResult->getResponse(),"orderId"=>$data->id]);
                }
            }else{
                return json_encode(["status"=>"error","data"=>$data,"orderId"=>null]);
            }
        }
        return json_encode(["status"=>"error","data"=>$model->errors,"orderId"=>null]);
    }
}
?>