<?php
use backend\assets\MainCtrlAsset;
MainCtrlAsset::register($this);
$this->title = '场地添加';
?>
<header class="reservation_header clearfix fw">
    <div class="w20  fl">场地添加</div>
    <div class="fl"></div>
</header>
<div class="yy_progress">
    <div class="progress"></div>
</div>
<section class="yy_search animated fadeIn" ng-controller="addSiteCtrl" ng-cloak>
    <div class="searchBox">
        <form action="">
            <input  id="_csrf" type="hidden"
                    name="<?= \Yii::$app->request->csrfParam; ?>"
                    value="<?= \Yii::$app->request->getCsrfToken(); ?>">
            <div>
                <h2>场地添加</h2>
            </div>
            <p style="margin-top: 10px;"><strong style="color:red">*</strong>所属公司</p>
            <select class="form-control darkGrey" name="" id="company" ng-model="companyId"  ng-change="searchVenue(companyId)">
                <option value="">请选择所属公司</option>
                <option value="{{company.id}}"   ng-repeat=" (key,company) in companyS">{{company.name}}</option>
            </select>
            <p><strong style="color:red">*</strong>所属场馆</p>
            <select class="form-control" name=""   id="venue">
                <option value="">请选择所属场馆</option>
                <option value="{{venue.id}}"  ng-repeat="venue in venueS" >{{venue.name}}</option>
            </select>
            <p><strong style="color:red">*</strong>场地名称</p>
            <input class="form-control" type="text" ng-model="venueName"   placeholder="请输入场地名称" style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>场地面积(㎡)</p>
            <input class="form-control" type="text" ng-model="classroom_area"  placeholder="请输入正整数，例如300" style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>场地座位数</p>
            <input class="form-control" type="text" ng-model="total_seat"   placeholder="请输入人数" style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p style="margin-bottom: 5px;" >场地描述</p>
            <textarea   ng-model="classroom_desrc"   style="border: solid 1px darkgrey;resize: none;" name="" id="" cols="59" rows="10" class="form-control"></textarea>
            <p style="margin-top: 10px">请添加场地照片</p>
            <div class="form-group">
                <img ng-src="{{pic}}" width="100px" height="100px" style="" >
            </div>
            <div class="input-file ladda-button btn ng-empty uploader"
                 style="width: 100px;height: 100px;border: 1px dashed #ddd;position: relative;margin-left:151px;margin-top: -157px"
                 ngf-drop="uploadCover($file,'update')"
                 ladda="uploading"
                 ngf-select="uploadCover($file,'update')"
                 ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                 ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
            >
                <p style="width: 100%;height: 100%;line-height: 80px;font-size: 50px;" class="text-center">+</p>
            </div>
        </form>
    </div>
    <div id="lastBox">
        <div class="fixedBox " >
            <button type="button" class="backBut btn btn-primary " style="width: 100px">返回</button>
                <button type="button" class="btn btn-success" style="width: 100px"   ng-click="add()">完成</button>
        </div>
    </div>
</section>
