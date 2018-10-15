<?php
use backend\assets\ActionLibraryAsset;
ActionLibraryAsset::register($this);
$this->title = '动作库';
/**
 * 私教管理 - 动作库 -编辑动作
 * @author zhujunzhe@itsports.club
 * @create 2018/5/5 pm
 */
?>
<div class="createContent" ng-controller="updateCtrl" ng-cloak style="height: 100%;background: #ffffff;">
    <div class="panel panel-default">
        <div class="panel-body">
            <a href="/action-library/index" class="mR10"><span style="font-size: 18px"><</span>返回</a>
            <span>修改动作</span>
        </div>
    </div>
    <div class="row mr0">
        <div class="col-md-12 mB10">
            <div class="col-lg-1 col-md-2 text-right  pL0">
                <span class="red LH30">*</span>动作名称
            </div>
            <div class="col-md-2 pd0">
                <input type="text" style="width: 100%" class="form-control w252" placeholder="请输入名称，最多10位" id="typeName" ng-model="typeName">
            </div>
        </div>
        <div class="col-md-12 mB10">
            <div class="col-lg-1 col-md-2 text-right pL0">
                <span class="red LH30">*</span>类型
            </div>
            <div class="col-md-2 pd0">
                <select class="form-control selectStyle" ng-model="drillType">
                    <option value="">请选择类型</option>
                    <option value="1">有氧训练</option>
                    <option value="2">重量训练</option>
                    <option value="0">其他</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 mB10">
            <div class="col-lg-1 col-md-2 text-right pL0">
                <span class="red LH30">*</span>单位
            </div>
            <div class="col-md-2 pd0" ng-if="drillType == 1">
                <select class="form-control selectStyle"  id="unit" ng-model="unit">
                    <option value="">请选择单位</option>
                    <option value="3">分</option>
                </select>
            </div>
            <div class="col-md-2 pd0" ng-if="drillType != 1">
                <select class="form-control selectStyle" ng-model="unit" ng-change="unitChange(unit)" id="unit">
                    <option value="">请选择单位</option>
                    <option value="1">次</option>
                    <option value="2">秒</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 mB10">
            <div class="col-lg-1 col-md-2 text-right pL0">
                <span class="red LH30">*</span>热量消耗
            </div>
            <div class="col-md-2 pd0 mR10" ng-if="drillType == 1">
                <input type="text"  class="form-control"  placeholder="Kcal/分" id="expend" ng-model="expend">
            </div>
            <div class="col-md-2 pd0 mR10" ng-if="drillType != 1">
                <input type="text"  class="form-control"  placeholder="Kcal/次" ng-if="!chooseMin" id="expend" ng-model="expend">
                <input type="text"  class="form-control"  placeholder="Kcal/分钟" ng-if="chooseMin" id="expend" ng-model="expend">
            </div>
            <span class="LH30" style="width: 32px;">Kcal</span>
        </div>
        <div class="col-md-12 mB10" ng-repeat="w in selectMenuList">

            <div class="col-lg-1 col-md-2  text-right pL0">
                <span class="LH30" >{{w.title}}</span>
            </div>
            <div class="col-md-2 pd0 selectNum mR10">
                <select class="form-control selectStyle chooseSelect">
                    <option value="">请选择类型</option>
                    <option value="{{c.id}}" ng-repeat="c in w.children">{{c.title}}</option>
                </select>
            </div>

            <div class="col-sm-2 pd0 LH30">
                <a href="" class="blue mR10" ng-click="refreshBtn()">刷新</a>
                <a href="/action-category/index" target="_blank" class="blue">管理分类</a>
            </div>
        </div>
        <div class="col-md-12 mB10">
            <div class="col-lg-1 col-md-2 text-right pL0"><span class="red">*</span>动作要领</div>
            <div class="col-lg-6 col-md-9 pd0">
                <textarea class="form-control" rows="4" id="gist" ng-model="gist"></textarea>
            </div>
        </div>
        <div class="col-md-12 mB10">
            <div class="col-lg-1 col-md-2 text-right pL0">
                动作示范
            </div>
            <!--<div class="col-lg-6 col-md-9 pd0 exampleDiv ">-->

                <!--遍历之前的照片 当路径为空时-->
                <!--<div class="w100 uploadDiv mB10" ng-if="updateImage != '' && i.type == 2 &&  i.url == '' && showStatus" ng-repeat="i in updateImage">
                    <div class="w100 imgDiv">
                        <img ng-src="/plugins/actionLibrary/img/22.png" ng-if="imgLink == '' || imgLink == null">
                    </div>
                    <textarea class="form-control detail" placeholder="文字说明:"></textarea>
                </div>-->
                <!--遍历之前的照片 路径不为空时-->
                <!--<div class="w100 uploadDiv mB10" ng-repeat="i in updateImage" ng-if="updateImage != '' && i.type == 2 && !showImg && i.url != ''">
                    <div class="w100 imgDiv">
                        <img ng-src="/plugins/actionLibrary/img/22.png" ng-if="i.url == '' || i.url == null">
                        <img ng-src="{{i.url}}" ng-if="i.url != '' && i.url != null" class="w100">
                        <span class="delImg"  ng-click="updateDeleteBtn($index)" ng-if="i.url != '' && i.url != null">&times;</span>
                    </div>
                    <textarea class="form-control detail" placeholder="文字说明:">{{i.describe}}</textarea>
                </div>-->
                <!--遍历新添加的照片-->
                <!--<div class="w100 uploadDiv mB10" ng-repeat="i in imgArr1" ng-if="imgArr1 != ''">
                    <div class="w100 imgDiv">
                        <img ng-src="/plugins/actionLibrary/img/22.png" ng-if="i == '' || i == null">
                        <img ng-src="{{i}}" ng-if="i != '' && i != null" class="w100">
                        <span class="delImg"  ng-click="deleteBtn($index)">&times;</span>
                    </div>
                    <textarea class="form-control detail" placeholder="文字说明:"></textarea>
                </div>-->
                <!--遍历新添加的照片 新添加的照片没有值时-->
                <!--<div class="w100 uploadDiv mB10" ng-if="showImg">
                    <div class="w100 imgDiv">
                        <img ng-src="/plugins/actionLibrary/img/22.png" ng-if="imgLink == '' || imgLink == null">
                    </div>
                    <textarea class="form-control detail" placeholder="文字说明:"></textarea>
                </div>-->
           <!-- </div>-->
            <!--<div class="col-md-12 pd0 mT10 addDiv">
                <div class="col-lg-1 col-md-2 pL0"></div>
                <div class="col-md-10 pd0">
                    <div class="upload fl">
                        <button class="btn btn-default">添加照片</button>
                        <input type="file" class="form-control uploadImg" ngf-drop="setCover5($file)" ngf-select="setCover5($file)" uploader="uploader">
                    </div>
                    <span class="fl mF20 LH30">说明：最多添加5条,支持bmp、gif、png等格式,大小不超过2M，建议尺寸768*1024</span>
                </div>
            </div>-->
            <div class="col-lg-6 col-md-9 pd0 exampleDiv">
                <!--遍历之前的照片 路径不为空时-->
                <div class="col-md-12 pd0 mB10 uploadDiv" ng-if="updateImage != '' && i.type == 2" ng-repeat="i in updateImage">
                    <div class="w100 fl imgDiv">
                        <img ng-src="{{i.url}}" ng-if="i.url != '' && i.url != null" class="w100">
                    </div>
                    <textarea class="form-control detail fl" placeholder="文字说明:">{{i.describe}}</textarea>
                    <button class="btn btn-default fr" ng-click="updateDeleteBtn($index)">删除</button>
                </div>
                <!--遍历新添加的照片-->
                <div class="col-md-12 pd0 mB10 uploadDiv" ng-repeat="i in imgArr1">
                    <div class="w100 fl imgDiv">
                        <img ng-src="{{i}}" ng-if="i != '' && i != null" class="w100">
                    </div>
                    <textarea class="form-control detail fl" placeholder="文字说明:"></textarea>
                    <button class="btn btn-default fr" ng-click="deleteBtn($index)">删除</button>
                </div>
                <div class="col-md-12 pd0">
                    <div class="upload fl">
                        <button class="btn btn-default">添加照片</button>
                        <input type="file" class="form-control uploadImg" ngf-drop="setCover5($file)" ngf-select="setCover5($file)" uploader="uploader">
                    </div>
                    <span class="fl LH30">说明：最多添加5条,支持bmp、gif、png等格式,大小不超过2M，建议尺寸768*1024</span>
                </div>
            </div>
        </div>
        <div class="col-md-12 mB10">
            <div class="col-lg-1 col-md-2 text-right pL0">
                错误示范
            </div>
            <div class="col-lg-6 col-md-9 pd0" style="height: 160px;border:1px solid #cfdadd;padding: 10px;">
                <div class="w100 waringUploadBtn fl">
                    <span>+</span>
                    <input type="file" class="form-control upLoadInput w100" ngf-drop="setCover6($file)" ngf-select="setCover6($file)" uploader="uploader">
                </div>
                <div class="waringUploadDiv fl">
                    <div class="w100 waringImgDiv fl mR10"   ng-repeat="i in updateImage" ng-if="updateImage != '' && i.type == 1">
                        <!--<img ng-src="/plugins/actionLibrary/img/22.png" ng-if="i.url == '' || i.url == null" >-->
                        <img ng-src="{{i.url}}" ng-if="i.url != '' && i.url != null" class="w100">
                        <span class="delImg"  ng-click="updateDelImgBtn($index)">&times;</span>
                    </div>
                </div>
                <div class="waringUploadDiv fl">
                    <div class="w100 waringImgDiv fl mR10"  ng-repeat="($index,img) in imgArr">
                        <!--<img ng-src="/plugins/actionLibrary/img/22.png" ng-if="imgArr == '' || imgArr == null" >-->
                        <img ng-src="{{img}}" ng-if="imgArr != '' && imgArr != null" class="w100">
                        <span class="delImg delImg{{$index}}"  ng-click="delImgBtn($index)">&times;</span>
                    </div>
                </div>
                <p class="mT20 col-md-12 pd0">
                    说明：最多添加3条,支持bmp、gif、png等格式,大小不超过2M，建议尺寸768*1024
                </p>
            </div>
        </div>
        <div class="col-md-12 mB10">
            <div class="col-lg-1 col-md-2 text-right pL0">
                上传视频
            </div>
            <div class="col-lg-6 col-md-9 pd0" style="border:1px solid #cfdadd;padding: 10px;">
                <div class="uploadVideo mB10" style="position: relative">
                    <button class="btn btn-default">上传视频</button>
                    <input type="file" class="form-control uploadVideoInput" ngf-drop="setCover7($file)" ngf-select="setCover7($file)" uploader="uploader">
                    <span>说明：大小不超过20M，建议格式为mp4、avi,尺寸3:4</span>
                </div>
                <div class="waringUploadDiv">
                    <div class="w100" style="position: relative" ng-if="videoSrc == ''">
                        <img ng-src="/plugins/actionLibrary/img/22.png">
                    </div>
                    <div class="" style="position: relative;width: 320px;height: 240px;"  ng-if="videoSrc != ''">
                        <video style="position: absolute;top:0;left: 0;width: 100% !important;height: 240px !important;" controls="controls">
                            <source  ng-src="{{videoUrl(videoSrc)}}" type="video/mp4">
                            <source  ng-src="{{videoUrl(videoSrc)}}" type="video/ogg">
                        </video>
                        <span class="delImg" ng-click="deleteVideoBtn()">&times;</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-lg-1 col-md-2 text-right pL0"></div>
            <div class="col-md-10 pd0">
                <button class="btn btn-info" style="width: 100px;" ng-click="updateSubmitBtn()">保存</button>
                <button class="btn btn-default" style="width: 100px;" ng-click="updateCancelBtn()">取消</button>
            </div>
        </div>
    </div>
</div>
