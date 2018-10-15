<?php
/* @var $this yii\web\View */
use backend\assets\PurchaseCardCtrlAsset;
PurchaseCardCtrlAsset::register($this);
$this->title = '新会员入会协议';
?>
<main ng-controller="newContractCtrl" ng-cloak>
    <div  class="header">
        <div>
            <span class="glyphicon glyphicon-menu-left f20 backBtn" style="text-shadow: 0 0 2px #FFF;" ></span>
        </div>
        <div style="color: #000;font-size: 15px"><b>新会员入会协议</b></div>
        <div ><a href="javascript:;" class="close-popup  " style="background-color: transparent;border: none;opacity: 0;" id="p1">关闭</a></div>
    </div>
    <section style="margin-top: 20px;padding: 0 5%;">
        <h2 style="text-align: center;font-size: 16px;font-weight: bold;">{{newContractName}}</h2>
        <p style="letter-spacing: 2px;font-size: 14px;" ng-bind-html="getNewContractData | to_Html" ></p>
    </section>
</main>