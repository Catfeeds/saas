<?php
use backend\assets\MainCtrlAsset;
MainCtrlAsset::register($this);
$this->title = '公司品牌添加';
?>
<!--添加公司品牌页面-->
<header class="reservation_header clearfix fw">
    <div class="w20  fl">公司名称添加</div>
    <div class="fl"></div>
</header>
<div class="yy_progress">
    <div class="progress"></div>
</div>
<section class="yy_search animated fadeIn" ng-controller = 'addCompanyCtrl' ng-cloak>
    <div class="searchBox">
        <form action="">
            <div style="margin-bottom: 10px;padding-top: 10px;">
                <h2>公司名称添加</h2>
            </div>
            <input  id="_csrf" type="hidden"
                    name="<?= \Yii::$app->request->csrfParam; ?>"
                    value="<?= \Yii::$app->request->getCsrfToken(); ?>">
            <p style="margin-top: 50px"><strong style="color:red">*</strong>公司名称</p>
            <input ng-model="name"  class="form-control" type="text" placeholder="请输入公司名称" style="border-radius: 3px;border: solid 1px darkgrey;"/>
        </form>
    </div>
    <div id="lastBox" style="margin-top: 101px">
        <div class="fixedBox " >
            <button type="button" class="backBut btn btn-primary " style="width: 100px">返回</button>
                <button type="button" class="btn btn-success"  ng-click="add()"   style="width: 100px">完成</button>

        </div>
    </div>
</section>
