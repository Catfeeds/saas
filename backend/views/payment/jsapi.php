<?php
use backend\assets\TestPaymentCtrlAsset;
TestPaymentCtrlAsset::register($this);
$this->title = '会员登记';
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
use backend\components\payment\lib\WxPayApi;
use backend\components\payment\lib\Config;
use backend\components\payment\example\CLogFileHandler;
use backend\components\payment\example\Log;
include ('../components/payment/lib/WxPay.Data.php');
include ('../components/payment/lib/WxPay.Api.php');
//初始化日志
$logHandler = new CLogFileHandler("../web/payment/logs/".date('Y-m-d').'.txt');
$log        = Log::Init($logHandler, 15);
//①、获取用户openid
$tools   = new \backend\components\payment\example\JsApiPay();
$openId  = $tools->GetOpenid();
$card    = isset($cardName) ? "{$cardName}" : '卡';
$orderId = isset($orderId) ? "{$orderId}" : '1';
$price   = isset($price) ? $price * 100 : '1';
//$price   = 1;
//②、统一下单
$input = new backend\components\payment\lib\WxPayUnifiedOrder();
$input->SetBody($card);
$input->SetAttach($orderId);
$input->SetOut_trade_no(Config::MCHID.date("YmdHis"));
$input->SetTotal_fee($price);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("http://".$_SERVER['SERVER_NAME']."/payment/notify");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
//printf_info($order);
$jsApiParameters = $tools->GetJsApiParameters($order);
//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
$session = \Yii::$app->session;
$data    = $session->get('data');
?>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				if(res.err_msg == "get_brand_wcpay_request:ok"){
//                    alert('成功');
					location.replace('/payment/success');
				}
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
	<script type="text/javascript">
	//获取共享地址
	function editAddress()
	{
		WeixinJSBridge.invoke(
			'editAddress',
			<?php echo $editAddress; ?>,
			function(res){
				var value1 = res.proviceFirstStageName;
				var value2 = res.addressCitySecondStageName;
				var value3 = res.addressCountiesThirdStageName;
				var value4 = res.addressDetailInfo;
				var tel = res.telNumber;
				
//				alert(value1 + value2 + value3 + value4 + ":" + tel);
			}
		);
	}
	
	window.onload = function(){
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', editAddress, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', editAddress); 
		        document.attachEvent('onWeixinJSBridgeReady', editAddress);
		    }
		}else{
			editAddress();
		}
	};
	</script>
<main  style="background-color: #FFF;position: relative;height: 100%;">
<!--	<div  class="header">-->
<!--		<div>-->
<!--			<span class="glyphicon glyphicon-menu-left f24 "  style="opacity: 0;font-size: 24px;color: #e5e5e5;"></span>-->
<!--		</div>-->
<!--		<div style="color: #000;font-size: 15px"><b>会员支付</b></div>-->
<!--		<div style="opacity: 0;">12</div>-->
<!--	</div>-->
<!--	<div style="position: relative;">-->
<!--		<form>-->
<!--			<div>-->
<!--				<ul class="listForm ">-->
<!--					<li style="width: 40px;"><span class=""><img src="/plugins/purchaseCard/imgages/user.png" alt=""></span></li>-->
<!--					<li class="f16Name">会员姓名：</li>-->
<!--					<li style="width: 100%;border-style:none">-->
<!--						<span style="border-style:none"  class="form-control">--><?//=isset($data['name'])?$data['name']:''?><!--</span>-->
<!--					</li>-->
<!--				</ul>-->
<!--			</div>-->
<!--			<div>-->
<!--				<ul class="listForm ">-->
<!--					<li style="width: 40px;"><span class=""><img src="/plugins/purchaseCard/imgages/user.png" alt=""></span></li>-->
<!--					<li class="f16Name">身份证号：</li>-->
<!--					<li style="width: 100%;border-style:none">-->
<!--						<span style="border-style:none"  class="form-control">--><?//=isset($data['idCard'])?$data['idCard']:'';?><!--</span>-->
<!--					</li>-->
<!--				</ul>-->
<!--			</div>-->
<!--			<div>-->
<!--				<ul class="listForm ">-->
<!--					<li style="width: 40px;"><span class=""><img src="/plugins/purchaseCard/imgages/user.png" alt=""></span></li>-->
<!--					<li class="f16Name">卡种名称：</li>-->
<!--					<li style="width: 100%;border-style:none">-->
<!--						<span style="border-style:none"  class="form-control">--><?//=isset($data['cardName'])?$data['cardName']:''?><!--</span>-->
<!--					</li>-->
<!--				</ul>-->
<!--			</div>-->
<!--			<div >-->
<!--				<ul class="listForm ">-->
<!--					<li style="width: 40px;"><span class=""><img  ng-src="/plugins/purchaseCard/imgages/idCard.png" alt=""></span></li>-->
<!--					<li  class="f16Name">卡种类型：</li>-->
<!--					<li style="width: 100%;border-style:none">-->
<!--						<span style="border-style:none" class="form-control">时间卡</span>-->
<!--					</li>-->
<!--				</ul>-->
<!--			</div>-->
<!--			<div >-->
<!--				<ul class="listForm ">-->
<!--					<li style="width: 40px;"><span class=""><img  ng-src="/plugins/purchaseCard/imgages/idCard.png" alt=""></span></li>-->
<!--					<li  class="f16Name">卡种金额：</li>-->
<!--					<li style="width: 100% ;border-style:none" >-->
<!--						<span style="border-style:none " class="form-control">--><?//=isset($data['price'])?$data['price']:'0'?><!--</span>-->
<!--					</li>-->
<!--				</ul>-->
<!--			</div>-->
<!--		</form>-->
<!--	</div>-->

	<?= $this->render('@app/views/purchase-card/paymentOrder.php'); ?>
	<div style=" position: absolute;bottom: 0; width: 100%;">
<!--		<span style="color:#c0c0c0; "><b>该笔订单支付金额为<span style="color:#f00;font-size:25px">--><?//=isset($data)?$data['price']:'1'?><!--元</span>钱</b></span><br/><br/>-->
		<div align="center">
			<button class="btn btn-success" style="width:100%; height:38px; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;margin-bottom: 5px;" type="button" onclick="callpay()" >立即支付</button>
		</div>
	</div>
</main>