<?php
namespace backend\controllers;

use backend\components\alipay\aop\AopClient;
use backend\components\payment\example\CLogFileHandler;
use backend\components\payment\example\Log;
use backend\models\Notify;
use backend\modules\v1\models\PaymentCardForm;
use common\models\base\Order;
use yii\base\Controller;

class PaymentController extends \yii\web\Controller
{
    /*
  * 购卡页面
  */
    public $layout='buyCard';
    public function beforeAction($action)
    {
         $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionSuccess()
    {
        return $this->render('/purchase-card/buyCardSuccess');
    }
    public function actionJsApi()
    {
        $session = \Yii::$app->session;
        $data    = $session->get('data');
//        var_dump($order);die();
        return $this->render('jsapi',['price'=>$data['price'],'duration'=>$data['duration'],'times'=>$data['times'],'cardName'=>$data['cardName'],'number'=>$data['number'],'orderId'=>$data['orderId']]);
    }
    public function actionPay()
    {
        $session = \Yii::$app->session;
        $data    = $session->get('data');
//        var_dump($order);die();
        return $this->render('pay',['price'=>$data['price'],'duration'=>$data['duration'],'times'=>$data['times'],'cardName'=>$data['cardName'],'number'=>$data['number'],'orderId'=>$data['orderId']]);
    }
    public function actionNotify()
    {
        $logHandler = new CLogFileHandler("./payment/logs/".date('Y-m-d').'.txt');
        $log        = Log::Init($logHandler, 15);
        Log::DEBUG("begin notify2");
        $notify = new Notify();
        $notify->Handle(false);
        $res = $notify->GetValues();
//        \Yii::trace('res',$res);
        if($res['return_code'] === 'SUCCESS'){
            $rawXml = file_get_contents("php://input");
            libxml_disable_entity_loader(true);
            $ret = json_decode(json_encode(simplexml_load_string($rawXml,'SimpleXMLElement',LIBXML_NOCDATA)),true);
//            \Yii::trace('ret',$ret);
            $orderId = $ret['attach'];
            $payment = new PaymentCardForm();
            $pay     = $payment->setMemberCardInfo($orderId);
            $payment->sendMessage();
            if($pay === 'SUCCESS'){
                echo 'SUCCESS';
            }
        }
        echo 'FAIL';
    }

    /**
     * 云运动 - 售卡系统 - 售卡表单验证
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/13
     * @return string
     */
    public function actionSellCard()
    {
        $post      = \Yii::$app->request->post();
        $model     = new PaymentCardForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->setSellCard();
            if(isset($data['orderId'])){
                $session = \Yii::$app->session;
                $session->set('data',$data);
                return json_encode(['status' => 'success', 'data' => $data]);
            }else{
                return json_encode(['status' => 'error', 'data' => $model->errors]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }
    /**
     * 业务后台 - 支付宝 - 回调地址
     * @return string
     */
    public function actionNotifyPay()
    {
        $aop           = new AopClient();
        $flag          = $aop->rsaCheckV1(\Yii::$app->request->post(), NULL, "RSA");
        $success       = strtolower('SUCCESS');
        if($flag) {
            $out_trade_no = $_POST['out_trade_no'];   //商品单号
            $trade_status = $_POST['trade_status'];   //商品状态
            $body         = $_POST['body'];           //商品主体
            $order = Order::findOne(['merchant_order_number'=>$out_trade_no]);
            if(!empty($order)){
                return $success;
            }
            if($trade_status == 'TRADE_FINISHED') {
                $payment = new PaymentCardForm();
                $pay     = $payment->setMemberCardInfo($body,$out_trade_no);
                $payment->sendMessage();
                if($pay === 'SUCCESS'){
                    echo $success;
                }
            }
            else if ($trade_status == 'TRADE_SUCCESS') {
                $payment = new PaymentCardForm();
                $pay     = $payment->setMemberCardInfo($body,$out_trade_no);
                $payment->sendMessage();
                if($pay === 'SUCCESS'){
                    echo $success;
                }
            }
            echo $success;		//请不要修改或删除
        }
        else {
            //验证失败
            echo "FAIL";
        }
    }
    public function actionAliPay()
    {
        $session = \Yii::$app->session;
        $data    = $session->get('data');
//        var_dump($order);die();
        return $this->render('pay',['price'=>$data['price'],'duration'=>$data['duration'],'times'=>$data['times'],'cardName'=>$data['cardName'],'number'=>$data['number'],'orderId'=>$data['orderId'],'status'=>true]);
    }
}
