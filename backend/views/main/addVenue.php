<?php
use backend\assets\MainCtrlAsset;
MainCtrlAsset::register($this);
$this->title = '场馆添加';
?>
<style>
    .select2-selection{
        height: 100px;
    }
    .select2-container .select2-selection--single{height: 45px;position: relative;top: 60px;}
    .select2-selection__rendered{margin-top: 10px;}
    .select2-container--open{margin-top: 10px;}
</style>
<header class="reservation_header clearfix fw">
    <div class="w20  fl">场馆添加</div>
    <div class="fl"></div>
</header>
<div class="yy_progress">
    <div class="progress"></div>
</div>
<section class="yy_search animated fadeIn" ng-controller='addVenue' ng-cloak>
    <div class="searchBox">
        <form action="">
            <input id="_csrf" type="hidden"
                   name="<?= \Yii::$app->request->csrfParam; ?>"
                   value="<?= \Yii::$app->request->getCsrfToken(); ?>">
            <div style="margin-bottom: 10px; ">
                <h2>1.基本信息</h2>
            </div>
            <p><strong style="color:red">*</strong>所属公司</p>
            <!--            <select class="form-control darkGrey" name="" ng-model="pid">-->
            <!--                <option value="">请选择所属公司</option>-->
            <!--                <option   value="{{item.id}}"  ng-repeat="item in items">{{item.name}}</option>-->
            <!--            </select>-->
            <div style="height: 60px;">
                <select class="js-example-basic-single js-states"  ng-model="pid"
                        style="width: 400px; height: 100px; padding-bottom: 3px;position: relative;top: 60px;left: 300px;" id="id_label_single">
                    <option value="">请选择所属公司</option>
                    <option value="{{item.id}}" ng-repeat="item in items">{{item.name}}</option>
                </select>
            </div>
            <p><strong style="color:red">*</strong>场馆名称</p>
            <input ng-model="name" class="form-control" type="text" placeholder="请输入场馆名称"
                   style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p><strong style="color:red">*</strong>场馆类型</p>
            <div class="form-group text-center">
                <center>
                    <select class="form-control" style="padding: 4px 12px;" ng-model="venueType">
                        <option value="">请选择场馆类型</option>
                        <option value="1">综合馆</option>
                        <option value="2">瑜伽馆</option>
                        <option value="3">舞蹈馆</option>
                        <option value="4">搏击馆</option>
                        <option value="5">游泳馆</option>
                        <option value="6">健身馆</option>
                    </select>
                </center>
            </div>
            <p ><strong style="color:red">*</strong>场馆属性</p>
            <div class="form-group text-center">
                <center>
                    <select class="form-control" style="padding: 4px 12px;" ng-model="addVenue123">
                        <option value="">请选择场馆属性</option>
                        <option value="1">普通</option>
                        <option value="2">尊爵汇</option>
                    </select>
                </center>
            </div>
            <p>场馆面积(m²)</p>
            <input ng-model="venueArea" class="form-control" type="text" placeholder="请输入正整数，例如300"
                   style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p><strong class="red">*</strong>成立时间</p>
            <div class="input-append date " id="establishDate" data-date-format="yyyy-mm-dd">
                <input class="form-control h30 ng-pristine ng-valid ng-empty ng-touched" type="text"  placeholder="请选择公司成立日期" ng-model="establishDate">
                <span class="add-on"><i class="icon-th"></i></span>
            </div>
            <div style="margin-bottom: 10px; ">
                <h2>2.地址和联系方式</h2>
            </div>
            <p>场馆地址</p>
            <input ng-model="venueAddress" class="form-control" type="text" placeholder="请输入场馆地址"
                   style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>场馆经度</p>
            <input ng-model="venueLongitude" class="form-control" type="number" placeholder="请输入场馆经度"
                   style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>场馆纬度</p>
            <input ng-model="venueLatitude" class="form-control" type="number" placeholder="请输入场馆纬度"
                   style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>场馆电话</p>
            <input ng-model="venuePhone" class="form-control" type="text" placeholder="请输入场馆电话"
                   style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <div style="margin-bottom: 10px; ">
                <h2>3.场馆描述</h2>
            </div>
            <p style="margin-bottom: 5px;">场馆描述</p>
            <textarea ng-model="venueDescribe" style="border: solid 1px darkgrey;resize: none;" name="" id="" cols="59" rows="10"
                      class="form-control"></textarea>
            <p style="margin-top: 10px;">请添加场馆照片</p>
            <div class="form-group">
                <img ng-src="{{pic}}" width="100px" height="100px" style="">
            </div>
            <div class="input-file ladda-button btn ng-empty uploader"
                 style="width: 100px;height: 100px;border: 1px dashed #ddd;position: relative;margin-left:162px;margin-top: -153px"
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
        <div class="fixedBox ">
            <button type="button" class="backBut btn btn-primary " style="width: 100px">返回</button>
            <button type="button" class="btn btn-success" style="width: 100px" ng-click="add()">完成</button>

        </div>
    </div>
</section>
