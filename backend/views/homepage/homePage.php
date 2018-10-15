<?php
/* @var $this yii\web\View */
use backend\assets\HomePageAsset;
HomePageAsset::register($this);
$this->title = '系统主页';
?>
<style>
    body{
        overflow: hidden;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12 bgBox" style="padding: 0">
            <div class="col-sm-12 bgImg" style="padding: 0;background: url('/plugins/img/bg.png') no-repeat 0 0;height: 920px;text-align: center;">
                <img src="/plugins/img/bgtext.png" style="margin-top: 200px;">
            </div>
<!--            <img src="/plugins/img/bg.?png">-->
        </div>
    </div>
</div>

