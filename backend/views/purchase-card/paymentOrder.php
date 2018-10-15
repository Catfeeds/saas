<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/9/2
 * Time: 14:29
 * content:订单页面
 */
use backend\assets\mobilePurchaseAsset;
mobilePurchaseAsset::register($this);
$this->title = '订单支付';
$session = \Yii::$app->session;
$data    = $session->get('data');
?>
<main ng-controller="paymentOrderCtrl" ng-cloak style="background-color: #F5f5f5;height: 100%;">
    <div  class="header" style="background-color: #FFF;">
        <div class="backBtn" ng-click="backPrePage()">
            <span class="glyphicon glyphicon-menu-left f24  color999"></span>
        </div>
        <div class="f15 color000" ><b>支付方式</b></div>
        <div class="op0">00</div>
    </div>

    <section class="contentBox" style="background-color: #FFF;margin-top: 20px;padding-bottom: 10px;">
        <div  class="wB100" style="padding: 0 10px;">
            <div class="wB100" >
                <ul class="wB100" style="display: flex;justify-content: space-between;height: 70px;align-items: center;border-bottom: solid 2px #E5E5E5;">
                    <li class="f20">付款金额</li>
                    <li class="f24"><b>&yen;<?=isset($data['price'])?$data['price']:'0'?></b></li>
                </ul>
            </div>
            <div  class="wB100">
                <ul class="wB100 f16" style="display: flex;justify-content: space-between;height: 40px;align-items: center;">
                    <li class="">会员卡</li>
                    <li class=""><?=isset($data['cardName'])?$data['cardName']:''?></li>
                </ul>
                <ul class="wB100 f16" style="display: flex;justify-content: space-between;height: 40px;align-items: center;">
                    <li class="">有效天数</li>
                    <li class=""><?php $arr = (json_decode($data['duration'],true)); echo $arr['day'];?>天</li>
                </ul>
                <ul class="wB100 f16" style="display: flex;justify-content: space-between;height: 40px;align-items: center;">
                    <li class="">次数</li>
                    <li class=""><?=isset($data['$data'])?$data['times']:''?>次</li>
                </ul>
                <ul class="wB100 f16" style="display: flex;justify-content: space-between;height: 40px;align-items: center;">
                    <li class="">激活期限</li>
                    <li class=""><?=isset($data['activeTime'])?$data['activeTime']:''?>天</li>
                </ul>
                <ul class="wB100 f16" style="display: flex;justify-content: space-between;height: 40px;align-items: center;">
                    <li class="">支付方式</li>
                    <li class=""><?=isset($data['payMoneyMode'])?$data['payMoneyMode']:''?></li>
                </ul>
            </div>
            <div>

            </div>
        </div>
    </section>
</main>
