<?php
use backend\assets\PictureManagementAsset;

PictureManagementAsset::register($this);

$this->title = '中心管理 - 图片管理';
?>

<div class="container-fluid pd0" ng-controller="pictureManagementCtrl" ng-cloak>
    <div class="panel panel-default ">
        <div class="panel-heading">
            <span style="display: inline-block;"><b class="spanBig">中心管理</b></span>
            >
            <span  style="display: inline-block;"><b class="spanSmall">图片管理</b></span>
        </div>
        <div class="panel-body">
            <div class="col-sm-12 mainBox">
                <div class="col-sm-12">
                    <div class="col-sm-3 pd0">
                        <div class="input-daterange input-group dataInputInput fl cp userTime ml_12" id="container" >
                            <div class="input-daterange input-group cp userTimeRecord" id="container" >
                                <span class="add-on input-group-addon ml53">选择时间</span>
                                <input type="text"  readonly name="reservation" id="reservation" class="form-control text-center userSelectTime" value="" placeholder="选择时间"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 pd0">
                        <label for="id_label_single">
                            <select id="id_label_single" ng-model="venueId" class="js-example-basic-single form-control fl form-control w110pt4" >
                                <option value="">选择场馆</option>
                                <option value="{{w.id}}" ng-repeat="w in venueAll">{{w.name}}</option>
                            </select>
                        </label>
                        <label for="id_label_single1">
                            <select ng-model="selectType"  class="js-example-basic-single form-control fl form-control w110pt4" id="id_label_single1">
                                <option value="">选择类别</option>
                                <option value="{{w.id}}" ng-repeat="w in initTypeData">{{w.type_name}}</option>
                            </select>
                        </label>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <input type="text" ng-model="searchValue" ng-keydown="enterSearch($event)" class="form-control searchInput" placeholder="请输入图片名进行搜索..." >
                            <span class="input-group-btn">
                                <button type="button" ng-click="searchClick()" class="btn btn-success">搜索</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-2 pd0">
                        <div class="col-sm-12" >
                            <div class="col-sm-6 ">
                                <button type="button" data-toggle="modal" data-target="#myModal3" class="btn btn-default mr10px" ng-click="pictureCategory()" style="margin-left: -31px">图片类别</button>
                            </div>
                            <div class="col-sm-6">
                                <button class="btn btn-success pull-right" data-toggle="modal" data-target="#myModal">上传图片</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default ">
        <div class="panel-heading">
            列表
        </div>
        <div class="col-sm-12 pd0 ">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div id="DataTables_Table_0_wrapper"
                         class="dataTables_wrapper form-inline" role="grid">
                        <table class="table table-striped table-bordered table-hover dataTables-example dataTable"
                               id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting"
                                    aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">
                                    <span ng-click="CheckAll()" id="Cancel" >全选</span>
                                    <span ng-click="UnCheck()"  id="selectCancel" >取消全选</span>
                                    已选{{checkboxLength}}张
                                </th>
                                <th ng-click="changeSort('hh_id',sort)" class="sorting"
                                    aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;">
                                    <span class="glyphicon glyphicon-signal" aria-hidden="true"></span>&nbsp;序号
                                </th>
                                <th ng-click="changeSort('hh_venue',sort)" class="sorting"
                                    aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 80px;">
                                    <span class="glyphicon glyphicon-home" aria-hidden="true"></span> 场馆
                                </th>
                                <th ng-click="changeSort('hh_name',sort)" class="sorting"
                                    aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;">
                                    <span class="glyphicon glyphicon-knight" aria-hidden="true"></span>&nbsp;名称
                                </th>
                                <th ng-click="changeSort('hh_type',sort)" class="sorting"
                                    aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">
                                    <span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span>&nbsp;类别
                                </th>
                                <th ng-click="changeSort('hh_size',sort)" class="sorting"
                                    aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">
                                    <span class="glyphicon glyphicon-resize-full" aria-hidden="true"></span>&nbsp;图片大小
                                </th>
                                <th ng-click="changeSort('hh_dimension',sort)" class="sorting"
                                    aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;">
                                    <span class="glyphicon glyphicon-resize-small" aria-hidden="true"></span>&nbsp;图片尺寸
                                </th>
                                <th ng-click="changeSort('hh_createdTime',sort)" class="sorting"
                                    aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;">
                                    <span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp;上传时间
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr class="gradeA " ng-repeat="w in listDataItem">
                                    <td class="checkList " data-value="{{w.id}}" >
                                        <input type="checkbox"  class="checkboxs check{{w.id}}" ng-click="otherCheck(w.id)">
                                    </td>
                                    <td class="" data-toggle="modal" data-target="#myModal1" ng-click="viewPictureDetails(w.id)">
                                        {{w.id}}
                                    </td>
                                    <td class="" data-toggle="modal" data-target="#myModal1" ng-click="viewPictureDetails(w.id)">
                                        {{w.organization.name}}
                                    </td>
                                    <td class=""  data-toggle="modal" data-target="#myModal1" ng-click="viewPictureDetails(w.id)">
                                        {{w.name}}
                                    </td>
                                    <td class="" data-toggle="modal" data-target="#myModal1" ng-click="viewPictureDetails(w.id)">
<!--                                        <span ng-if="w.type == 1">团课课程图片</span>-->
<!--                                        <span ng-if="w.type == 2">私课课程图片</span>-->
<!--                                        <span ng-if="w.type == 3">场馆图片</span>-->
<!--                                        <span ng-if="w.type == 4">会员头像</span>-->
<!--                                        <span ng-if="w.type == 5">会员卡图片</span>-->
<!--                                        <span ng-if="w.type == 6">占位图</span>-->
                                        <span>{{w.type_name}}</span>
                                    </td>
                                    <td class="" data-toggle="modal" data-target="#myModal1" ng-click="viewPictureDetails(w.id)">
                                        {{w.image_size}}
                                    </td>
                                    <td class="" data-toggle="modal" data-target="#myModal1" ng-click="viewPictureDetails(w.id)">
                                        {{w.image_wide}} * {{w.image_height}}
                                    </td>
                                    <td class="" data-toggle="modal" data-target="#myModal1" ng-click="viewPictureDetails(w.id)">
                                        {{w.created_at * 1000| date:"yyyy-MM-dd HH:mm"}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/nodata.php',['name'=>'shopShow']); ?>
                        <?= $this->render('@app/views/common/nodata.php'); ?>
                        <div class="row" style="margin-left: 0;margin-right: 0; display: flex;align-items: center;" >
                            <div class="col-sm-1" ng-if="listDataItem != ''" >
                                <button type="button" class="btn btn-default mr10px" ng-click="removeImage()" >删除</button>
                            </div>
                            <section ng-if="pages != ''&& pages != undefined "   style=" font-size: 14px;padding-left: 6px;padding-right: 0;" class="col-sm-2">
                                第<input style="width: 50px;padding: 4px 4px;height: 24px;border-radius: 3px;border:solid 1px #E5E5E5;" type="number" class="" checknum placeholder="几" ng-model="pageNum">页
                                <button class="btn btn-primary btn-sm" ng-click="skipPage(pageNum)">跳转</button>
                            </section>
                            <div class="col-sm-9" ng-if="pages != ''&& pages != undefined "   style="padding-left: 0;padding-right: 0;">
                                <?= $this->render('@app/views/common/pagination.php'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- 新增 -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="closeModel()"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">上传图片</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <form id="formT" ngf-select="upload($file,'add')"
                              ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                              ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'">
                            <div class="w600h300" >
                                <img id="imagePic"  ng-src="{{img.imagePic}}" alt="" width="540px" height="350px">
                            </div>
                        </form>
                        <div class="mt40 w600h200">
                            <section class="w200mgAuto">
                                <div class="mT10">
                                    <ul class="a58">
                                        <li><span class="red">*</span>图片名称</li>
                                        <li class=" mL20 w170">
                                            <form>
                                                <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                                                <input type="text" ng-model="addImageName" class="padding2px8px" placeholder="请输入名字">
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mT10">
                                    <ul class="a58 pl50px" >
                                        <li><span class="red">*</span>类别</li>
                                        <li class=" mL20 w170">
                                            <select ng-model="addType" class="padding4px12px w160">
                                                <option value="">请选择类别</option>
                                                <option value="{{w.id}}" ng-repeat="w in initTypeData">{{w.type_name}}</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary buttonMg0" ladda="potentialMemberButtonFlag1"  ng-click="addImages()">完成</button>
                </div>
            </div>
        </div>
    </div>
    
<!--    图片详情-->
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">图片详情</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="w600h300">
                            <img ng-src="{{viewPictureDetailsData.url}}" width="550px" height="350px" alt="">
                        </div>
                        <div class="mt40">
                            <section class="w200mgAuto">
                                    <div class="fs18mb20">{{viewPictureDetailsData.name}}</div>
                                    <ul>
                                        <li>图片大小: &nbsp;{{viewPictureDetailsData.image_size}}</li>
                                        <br>
                                        <li>上传时间: &nbsp;{{viewPictureDetailsData.created_at *1000 | date:"yyyy-MM-dd HH:mm"}}</li>
                                        <br>
                                        <li>图片尺寸: &nbsp;<span>{{viewPictureDetailsData.image_wide}}</span> *  <span>{{viewPictureDetailsData.image_height}}</span></li>
                                        <br>
                                        <li>公司名称: &nbsp;<span>{{viewPictureDetailsData.companyName}}</span></li>
                                        <br>
                                        <li>场馆名称: &nbsp;<span>{{viewPictureDetailsData.venueName}}</span></li>
                                        <br>
                                        <li>图片链接:
                                            <div style="width: 300px;word-wrap:break-word ;">
                                                <p>{{viewPictureDetailsData.url}}</p>
                                            </div>
                                        </li>
                                    </ul>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"  data-toggle="modal" data-target="#myModal2" class="btn btn-primary buttonMg0">修改</button>
                </div>
            </div>
        </div>
    </div>
<!--    图片详情更改-->
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">图片详情</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="w600h300">
                            <img ng-src="{{viewPictureDetailsData.url}}" width="550px" height="350px" alt="">
                        </div>
                        <div class="mt40">
                            <section class="w200mgAuto">
                                <div class="fs18mb20">
                                    <input type="text" class="padding4px12px h30" ng-model="viewPictureDetailsData.name" placeholder="请输入图片名字">
                                </div>
                                <ul>
                                    <li>图片大小:&nbsp;&nbsp;{{viewPictureDetailsData.image_size}}</li>
                                    <br>
                                    <li>上传时间:&nbsp;&nbsp;{{viewPictureDetailsData.created_at *1000 | date:"yyyy-MM-dd HH:mm"}}</li>
                                    <br>
                                    <li>图片尺寸:&nbsp;&nbsp;<span>{{viewPictureDetailsData.image_wide}}</span> * <span>{{viewPictureDetailsData.image_height}}</span></li>
                                    <br>
                                    <li>公司名称: &nbsp;<span>{{viewPictureDetailsData.companyName}}</span></li>
                                    <br>
                                    <li>场馆名称: &nbsp;<span>{{viewPictureDetailsData.venueName}}</span></li>
                                    <br>
                                    <li>图片链接:
                                        <div style="width: 340px; word-wrap:break-word ;">
                                            {{viewPictureDetailsData.url}}
                                        </div>
                                    </li>
                                </ul>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-right btnw80px" ng-click="modifySave(viewPictureDetailsData.id,viewPictureDetailsData.name,viewPictureDetailsData.url)">保存</button>
                    <button type="button" class="btn btn-default pull-right btnw80px" ng-click="deleteOne(viewPictureDetailsData.id)">删除</button>
                </div>
            </div>
        </div>
    </div>
<!--新增类别-->
    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">新增类别</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="w600h300s">
                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                   id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">

                                    <th  class="sorting"
                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1" >
                                        <span class="glyphicon glyphicon-signal" aria-hidden="true"></span>&nbsp;序号
                                    </th>
                                    <th  class="sorting"
                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1">
                                        <span class="glyphicon glyphicon-home" aria-hidden="true"></span> 名称
                                    </th>
                                    <th class="sorting"
                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1">
                                        <span class="glyphicon glyphicon-knight" aria-hidden="true"></span>&nbsp;操作
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="gradeA " ng-repeat="w in pictureCategoryListData">
                                    <td class="col-sm-3" >
                                        {{w.id}}
                                    </td>
                                    <td class="col-sm-4"  >
                                        {{w.type_name}}
                                    </td>
                                    <td class="col-sm-4" >
                                        <div class="col-sm-6">
                                            <button type="button" data-toggle="modal" data-target="#myModal5"  class="btn btn-default mr10px" ng-click="deletePictureCategory(w.id)" >修改</button>
                                        </div>
                                        <div class="col-sm-6">
                                            <button class="btn btn-primary pull-right" ng-click="pictureCategoryModification(w.id)">删除</button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"  data-toggle="modal" data-target="#myModal4" class="btn btn-success buttonMg0">新增图片类型</button>
                </div>
            </div>
        </div>
    </div>

<!--    新增类别-->
    <div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" ng-click="okTypeClose()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">新增类别</h4>
                </div>
                <div class="modal-body">
                    <div class="w300MA">
                        <form>
                            <input ng-model="MemberData._csrf" id="_csrf" type="hidden"
                                   name="<?= \Yii::$app->request->csrfParam; ?>"
                                   value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                            <input type="text" ng-model="newType"  ng-blur="blurGet(newType)" class="form-control w230" placeholder="请输入图片类别">
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success buttonMg0" ladda="potentialMemberButtonFlag" ng-click="okType(newType)">完成</button>
                </div>
            </div>
        </div>
    </div>

<!--    类型修改-->
    <div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">修改类型</h4>
                </div>
                <div class="modal-body">
                    <div class="w300MA">
                        <form>
                            <input ng-model="MemberData._csrf" id="_csrf" type="hidden"
                                   name="<?= \Yii::$app->request->csrfParam; ?>"
                                   value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                            <input type="text" ng-model="deletePictureCategoryData.type_name"   class="form-control w230" placeholder="请输入图片类别">
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success buttonMg0"  ng-click="okTypeUpdata()">完成</button>
                </div>
            </div>
        </div>
    </div>

</div>
