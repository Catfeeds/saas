<?php
header("Content-type: text/html; charset=utf-8");

require_once '../components/wapApiPay/wappay/service/AlipayTradeService.php';
require_once '../components/wapApiPay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php';
require '../components/wapApiPay/config.php';
$card    = isset($cardName) ? "{$cardName}" : '卡';
$orderId = isset($orderId) ? "{$orderId}" : '1';
$number  = isset($number) ? "{$number}" : '1';
$price   = isset($price) ? $price : '0.01';
if (!empty($number) && trim($number)!="" && isset($status)){
    //商户订单号，商户网站订单系统中唯一订单号，必填
    $out_trade_no = $number;
    //订单名称，必填
    $subject      = $card;

    //付款金额，必填
    $total_amount = $price;

    //商品描述，可空
    $body          = isset($orderId) ? $orderId : 1;

    //超时时间
    $timeout_express = "5m";

    $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
    $payRequestBuilder->setBody($body);
    $payRequestBuilder->setSubject($subject);
    $payRequestBuilder->setOutTradeNo($out_trade_no);
    $payRequestBuilder->setTotalAmount($total_amount);
    $payRequestBuilder->setTimeExpress($timeout_express);

    $payResponse = new AlipayTradeService($config);
    $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);
}
$session = \Yii::$app->session;
$data    = $session->get('data');
?>
<div id="main">
    <?= $this->render('@app/views/purchase-card/paymentOrder.php'); ?>

    <div style=" position: absolute;bottom: 0; width: 100%;">
        <div align="center">
            <a class="btn btn-success" style="width:100%;background-color: #0099FF;padding: 10px 0; display: flex;align-items: center;justify-content: center; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;margin-bottom: 5px; font-size: 20px;" type="button" href="/payment/ali-pay" >立即支付<span > &emsp;<b>&yen;<?=isset($data['price'])?$data['price']:'0'?></a>
        </div>
    </div>
</div>
<script language="javascript">
	function GetDateNow() {
		var vNow = new Date();
		var sNow = "";
		sNow += String(vNow.getFullYear());
		sNow += String(vNow.getMonth() + 1);
		sNow += String(vNow.getDate());
		sNow += String(vNow.getHours());
		sNow += String(vNow.getMinutes());
		sNow += String(vNow.getSeconds());
		sNow += String(vNow.getMilliseconds());
		document.getElementById("WIDout_trade_no").value =  sNow;
		document.getElementById("WIDsubject").value = "测试";
		document.getElementById("WIDtotal_amount").value = "0.01";
        document.getElementById("WIDbody").value = "购买测试商品0.01元";
	}
//	GetDateNow();
</script>
</html>