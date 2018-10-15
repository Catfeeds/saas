<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/9/2
 * Time: 15:16
 */
use backend\assets\mobilePurchaseAsset;
mobilePurchaseAsset::register($this);
$this->title = '订单支付';
?>
<main  style="background-color: #FFF;height: 100%;" ng-controller="orderCompleteCtrl" ng-cloak>
    <div  class="header">
        <div class="backHomePageClick" ng-click="backHomePageClick()">
            <span class="glyphicon glyphicon-menu-left f24 "  style="font-size: 24px;color: #e5e5e5;"></span>
        </div>
        <div>进馆登记</div>
        <div></div>
    </div>
    <div class="weui_msg">
        <div class="weui_icon_area"><i  class="weui_icon_success weui_icon_msg colorAqua"></i></div>
        <div class="weui_text_area">
<!--            <p class="weui_msg_desc  " style="color: #2FBF79;font-size: 20px;">会员卡:精品瑜伽卡</p>-->
<!--            <p class="weui_msg_desc  " style="color: #2FBF79;font-size: 20px;">卡号:999999</p>-->
            <p class="weui_msg_desc  " style="color: #2FBF79;font-size: 20px;">会员卡购卡成功</p>
        </div>
        <div class="weui_opr_area  " ng-click="backHomePageClick()">
            <p class="weui_btn_area">
                <a href="javascript:;"   class="weui_btn weui_btn_primary colorAquaBg">返回首页</a>
            </p>
        </div>
    </div>
</main>
