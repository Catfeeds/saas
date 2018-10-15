<?php
/* @var $this yii\web\View */
use backend\assets\SendContactAsset;
SendContactAsset::register($this);
$this->title = '协议';
?>
<main ng-controller="sellingContactCtrl" ng-cloak>
    <section style="margin-top: 20px;padding: 0 5%;">
        <h2 style="text-align: center;font-size: 16px;font-weight: bold;">{{newContractName}}</h2>
        <p style="letter-spacing: 2px;font-size: 14px;" ng-bind-html="getNewContractData | to_Html" ></p>
    </section>
</main>
