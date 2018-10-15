<?php
use backend\assets\MainCtrlAsset;
MainCtrlAsset::register($this);
$this->title = '部门名称添加';
?>
<!--添加公司品牌页面-->
<header class="reservation_header clearfix fw">
    <div class="w20  fl">部门添加</div>
    <div class="fl"></div>
</header>
<div class="yy_progress">
    <div class="progress"></div>
</div>
<section class="yy_search animated fadeIn" ng-controller = 'addDepartmentCtrl' ng-cloak>
    <div class="searchBox">
        <form action="">
            <input  id="_csrf" type="hidden"
                    name="<?= \Yii::$app->request->csrfParam; ?>"
                    value="<?= \Yii::$app->request->getCsrfToken(); ?>">
            <div style="margin-bottom: 10px;">
                <h2>部门名称添加</h2>
            </div>
            <p style="margin-top: 10px;"><strong style="color:red">*</strong>所属公司</p>
            <select class="form-control darkGrey" name="" id="company" ng-model="companyId"  ng-change="searchVenue(companyId)">
                <option value="">请选择所属公司</option>
                <option value="{{company.id}}"   ng-repeat=" (key,company) in companyS">{{company.name}}</option>
            </select>
            <div  style="margin-top: 40px">
            <p><strong style="color:red">*</strong>所属场馆</p>
            <select class="form-control" name=""   id="venue">
                <option value="">请选择所属场馆</option>
                <option value="{{venue.id}}"  ng-repeat="venue in venueS" >{{venue.name}}</option>
            </select>
             </div>
            <p style="margin-top: 50px"><strong style="color:red">*</strong>部门名称</p>
            <input class="form-control" type="text" ng-model="depName"   placeholder="请输入部门名称" style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p style="margin-top: 50px"><strong style="color:red">*</strong>识别码</p>
            <input class="form-control" type="text" ng-model="code"     placeholder="请输入识别码" style="border-radius: 3px;border: solid 1px darkgrey;"/>
        </form>
    </div>
    <div id="lastBox" style="margin-top: 101px">
        <div class="fixedBox " >
            <button type="button" class="backBut btn btn-primary " style="width: 100px">返回</button>
            <button type="button" class="btn btn-success"  ng-click="add()"   style="width: 100px">完成</button>

        </div>
    </div>
</section>
