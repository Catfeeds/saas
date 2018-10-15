<?php
use backend\assets\PrivateLessonAsset;

PrivateLessonAsset::register($this);
$this->title = '私教课程';
?>
<div class="col-sm-12" id="PrivateTimetable" ng-cloak >
    <div class="panel panel-default ">
        <div class="panel-heading">
                <span style="display: inline-block"><span style="display: inline-block" class="spanSmall"><b>私教产品</b></span>
        </div>
    </div>
    <div class="panel panel-default ">
        <div class="panel-body col-sm-12 panelBody">
            <div class="tab-tb-1 PrivateTimetable2" ng-controller="privateLessonCtrl" ng-cloak>
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="clearfix clearfix1 row" style="height: 60px;padding-top: 12px">
                           
                            <div class="col-sm-9 w1280colsm10" style="padding-top: 15px;">
                                <div class="col-sm-3" style="padding-right: 0;">
                                    <label for="id_label_single" style="width: 100%;">
                                        <select class="js-example-basic-single js-states form-control" ng-model="courseId" id="classCourseId" style="padding-top: 4px">
                                            <option value="">请选择课种</option>
                                            <option value="{{venue.id}}" ng-repeat="venue in classAllVenue">{{venue.name}}</option>
                                        </select>
                                    </label>
                                </div>
                                <div class="col-sm-3 venueSelect2Course">
                                    <select class="js-states form-control" ng-change="venueChange(myenue)"
                                            ng-model="myValue" id="CourseVenueChange">
                                        <option value="" ng-selected>请选择场馆</option>
                                        <option value="{{venue.id}}" ng-repeat="venue in venuesLists">{{venue.name}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-6 w1280colsm6">
                                    <div class="input-group">
                                        <input type="text" class="form-control" ng-model="keywordsCurriculum" ng-keyup="enterSearchCurriculum($event)"
                                               placeholder="请输入产品名称进行搜索..."  style="height: 34px;">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-primary" ng-click="searchCurriculum()" style="left: -2px;">搜索</button>
                                        </span>
                                        <span class="input-group-btn" >
                                            <button type="button" class="btn btn-info" ng-click="searchClear()" style="margin-left: 10px;border-radius: 3px">清空</button>
                                        </span>
                                        <?php if (\backend\models\AuthRole::canRoleByAuth('privateCourseList', 'SETDISCOUNTS')) { ?>
                                        <span class="input-group-btn" >
                                            <button type="button" class="btn btn-default" ng-click="privateClassSetting()" style="margin-left: 10px;border-radius: 3px">设置</button>
                                        </span>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2" style="padding-top: 15px;padding-right: 50px;">
                                <div class="btn-group fr" >
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('privateCourseList', 'ADD')) { ?>
                                        <button type="button" class="clearfix1Button btn btn-success dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            新增私教产品<span class="caret"></span>
                                        </button>
                                    <?php }?>
                                    <ul class="dropdown-menu ">
                                        <li><a class="dropdownMenuADD">请选择新增类型</a></li>
                                        <li><a class="dropdownMenuA" href="/private-teach/add?&c=2">新增多课种产品</a></li>
                                        <li><a class="dropdownMenuA" href="/private-teach/add-serve?&c=2">新增单课种产品</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--                        私教课程管理列表-->
                        <div class="ibox-content  privateCourseManagementList ">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <div class="row privateCourseManagementListDiv">
                                    <div class="col-sm-6">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter"></div>
                                    </div>
                                </div>
                                <table
                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序" style="width: 12%;"
                                            ng-click="changeSort('name',sort)"><span class="glyphicon glyphicon-user"
                                                                                     aria-hidden="true"></span>&nbsp;产品名称
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序" style="width: 13%;"
                                            ng-click="changeSort('courseName',sort)"><span class="glyphicon glyphicon-list-alt"
                                                                                           aria-hidden="true"></span>&nbsp;课种名称
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序" style="width: 9.5%;"
                                            ng-click="changeSort('valid_time',sort)"><span
                                                class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;产品有效期
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="平台：激活排序列升序" style="width: 10%;"
                                            ng-click="changeSort('total_amount',sort)"><span
                                                class="glyphicon glyphicon-usd" aria-hidden="true"></span>&nbsp;总售价
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 9.5%;"
                                            ng-click="changeSort('total_sale_num',sort)"><span
                                                class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>&nbsp;售卖总数量
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 13%;"
                                            ng-click="changeSort('sale_start_time',sort)"><i
                                                class="fa fa-calendar-check-o"></i></span>&nbsp;售卖日期
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 10%;"
                                            ng-click="changeSort('status',sort)"><i
                                                class="fa fa-calendar-check-o"></i></span>&nbsp;状态
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" style="width: 23%;">编辑
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    <tr class="gradeA odd" ng-repeat='(index,data) in datas'
                                        ng-mouseenter="elementTd()">
                                        <td ng-click="privateModal(data.id,data.category)">{{data.name | noData:''}}
                                        </td>
                                        <td ng-click="privateModal(data.id,data.category)">{{data.courseName | noData:''}}</td>
                                        <td ng-click="privateModal(data.id,data.category)">{{data.valid_time |
                                            noData:''}}天
                                        </td>
                                        <td ng-click="privateModal(data.id,data.category)"
                                            ng-if="data.total_amount != NULL">￥{{data.total_amount}}
                                        </td>
                                        <td ng-click="privateModal(data.id,data.category)"
                                            ng-if="data.total_amount == NULL">0.00
                                        </td>
                                        <td ng-click="privateModal(data.id,data.category)"
                                            ng-if="data.total_sale_num != -1">{{data.total_sale_num | noData:''}}
                                        </td>
                                        <td ng-click="privateModal(data.id,data.category)"
                                            ng-if="data.total_sale_num == -1">不限
                                        </td>
                                        <td ng-click="privateModal(data.id,data.category)">{{data.sale_start_time *1000
                                            | noData:''| date:'yyyy-MM-dd'}} - {{data.sale_end_time *1000 | noData:''|
                                            date:'yyyy-MM-dd'}}
                                        </td>
                                        <td>
                                            <span class="label label-danger" ng-if="data.status == 2">冻结</span>
                                            <span class="label label-warning" ng-if="data.status == 3">过期</span>
                                            <span class="label label-success" ng-if="data.status == 1">正常</span>
                                            <span class="label label-info" ng-if="data.show == 1">不显示</span>
                                            <span class="label label-primary" ng-if="data.show == 2">显示</span>
                                        </td>
                                        <td>
                                            <div class=" ">
                                                <div class="checkbox i-checks">
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('privateCourseList', 'APPSHOW')) { ?>
                                                        <input class="checkboxButton" type="checkbox" value=""
                                                               ng-disabled="(data.type == 2 && (data.app_original == 0 || data.app_original == null)) ||
                                                                (data.type == 1 && (data.app_amount == 0 || data.app_amount == null) && (data.app_original == 0 || data.app_original == null))"
                                                               ng-checked="data.show == 2"
                                                               ng-click="editShow(data.id)">
                                                        <span class="checkboxSpan">移动端价格显示</span>
                                                    <?php }?>
                                                </div>
                                                <div class="checkbox i-checks">
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('privateCourseList', 'OVERDUE')) { ?>
                                                        <input class="checkboxButton" type="checkbox" value=""
                                                               ng-checked="data.status == 3"
                                                               ng-click="editStatus(data.id,index,'time')">
                                                        <span class="checkboxSpan">过期</span>
                                                    <?php }?>
                                                </div>
                                                <div class="checkbox i-checks">
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('privateCourseList', 'OPERATE')) { ?>
                                                        <input class="checkboxButton" type="checkbox" value=""
                                                               ng-checked="data.status == 2"
                                                               ng-click="editStatus(data.id,index,'ban')">
                                                        <span class="checkboxSpan">冻结</span>
                                                    <?php }?>
                                                </div>
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('privateCourseList', 'DELETE')) { ?>
                                                    <button class="btn btn-danger btn-sm ladda-button"  ng-disabled="data.privateOrder.length>0?'disabled':''" type="submit"
                                                            ng-click="delClass(data.id)">删除
                                                    </button>
                                                <?php }?>
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('privateCourseList', 'UPDATE')) { ?>
                                                    <button class="btn btn-default btn-sm ladda-button"  ng-disabled="data.privateOrder.length>0?'disabled':''" type="submit"
                                                            ng-click="updateClassPicBtn(data.id)">修改
                                                    </button>
                                                <?php }?>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?= $this->render('@app/views/common/nodata.php'); ?>
                                <?=$this->render('@app/views/common/page.php');?>
                            </div>
                        </div>
                    </div>


                    <!-- 私课课程图片修改-->
                    <div class="modal show-hide a3" id="classPicUpdateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content a17">
                                <div style="border: none;" class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                        &times;
                                    </button>

                                    <h3 class="text-center a18" id="myModalLabel">
                                        修改课程信息
                                    </h3>
                                </div>
                                <div class="row" style="margin-top: 20px;">
                                    <section class="col-sm-12">
                                        <input  id="_csrf" type="hidden"
                                                name="<?= \Yii::$app->request->csrfParam; ?>"
                                                value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                                        <div class="col-sm-10 col-sm-offset-1">
                                            <section class="col-sm-12">
                                                <div class="col-sm-4 text-right">
                                                    课程介绍
                                                </div>
                                                <div class="col-sm-8">
                                                    <textarea name="" ng-model="classEditContent" id="classEditContent" rows="6"style="width: 100%;resize: none;text-indent: 2em;border-radius: 3px;" placeholder="请输入课程介绍"></textarea>
                                                </div>
                                            </section>
                                            <section class="col-sm-12">
                                                <div class="form-group a20" style="margin-top: 20px;margin-left: 60px;">
                                                    <label class="a19" for="exampleInputName7">&emsp; 图片修改</label>
                                                    <div class="form-group a20">
                                                        <img ng-if="updateClassPic == null || updateClassPic ==''" ng-src="" width="100px"
                                                             height="100px" style="border-radius: 50%;border: 1px solid #000">
                                                        <img ng-if="updateClassPic != null && updateClassPic !=''"
                                                             ng-src="{{updateClassPic}}"
                                                             style="border-radius: 50%; width: 100px;height: 100px;">
                                                    </div>
                                                    <div class="input-file ladda-button btn ng-empty uploader" id="imgFlagClass"
                                                         ngf-drop="uploadCover($file,'update')"
                                                         ladda="uploading"
                                                         ngf-select="uploadCover($file,'update')"
                                                         ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                                                         ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'">
                                                        <p class="text-center addCss">+</p>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </section>
                                </div>
                                <div class="modal-footer">
                                    <button ng-click="submitUpdate()" style="width: 100px;" class="btn btn-success  successBtn a3">
                                        确定
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 私教课程详情模态框 -->
                    <div class="modal fade" style="overflow: auto;" id="privateModal" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content clearfix">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title myModalLabel1" id="myModalLabel">
                                        私教课程详情
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12 privateModalBody">
                                            <!--                            基本属性-->
                                            <p class="titleP">
                                                <span>1.基本属性</span>
                                                <?php if(\backend\models\AuthRole::canRoleByAuth('privateCourseList','CHBASICUPDATE')){ ?>
                                                    <button class="btn btn-default" data-toggle="modal" ng-click="basicTypeUpdate(privateClassDetails)" style="width: auto;">基本属性修改</button>
                                                <?php } ?>
                                            </p>
                                            <div class="col-sm-11 privateModalBodyDiv privateDivBorder">
                                                <div class="col-sm-4 mT10 contentBetween">
                                                    <div class="width100">产品名称:</div>
                                                    <span class="contentSpan">{{privateClassDetails.name | noData:''}}</span>
                                                </div>
                                                <div class="col-sm-4 mT10 contentBetween">
                                                    <div class="width100">产品类型:</div>
                                                    <span class="contentSpan" ng-if="privateClassDetails.product_type == 1 || privateClassDetails.product_type =='1'">常规PT</span>
                                                    <span class="contentSpan" ng-if="privateClassDetails.product_type == 2 || privateClassDetails.product_type =='2'">特色课</span>
                                                    <span class="contentSpan" ng-if="privateClassDetails.product_type == 3 || privateClassDetails.product_type =='3'">游泳课</span>
                                                    <span class="contentSpan" ng-if="privateClassDetails.product_type == '' || privateClassDetails.product_type == null || privateClassDetails.product_type == undefined">暂无数据</span>
                                                </div>
                                                <div class="col-sm-4 mT10 contentBetween">
                                                    <div class="width100">每月上课数量:</div>
                                                    <span class="contentSpan">{{privateClassDetails.month_up_num | noData:''}}</span>
                                                </div>
                                                <div class="col-sm-4 mT10 contentBetween">
                                                    <div class="width100">产品激活期限:</div>
                                                    <span class="contentSpan">{{privateClassDetails.activated_time | noData:''}}天</span>
                                                </div>
                                                <div class="col-sm-4 mT10 contentBetween">
                                                    <div class="width100">售卖总数量:</div>
                                                    <span class="contentSpan">{{privateClassDetails.total_sale_num == -1 ?'不限':privateClassDetails.total_sale_num | noData:''}}</span>
                                                </div>
                                                <div class="col-sm-4 mT10 contentBetween">
                                                    <div class="width100">售卖日期:</div>
                                                    <span class="contentSpan">{{privateClassDetails.sale_start_time*1000|date:'yyyy-MM-dd'}}至{{privateClassDetails.sale_end_time*1000|date:'yyyy-MM-dd'}}</span>
                                                </div>
                                                <div class="col-sm-4 mT10 contentBetween">
                                                    <div class="width100">课程类型:</div>
                                                    <span class="contentSpan" ng-if="privateClassDetails.course_type == 1">购买</span>
                                                    <span class="contentSpan" ng-if="privateClassDetails.course_type == 2">赠送</span>
                                                </div>
                                                <div class="col-sm-4 mT10 contentBetween">
                                                    <div class="width100">所属场馆:</div>
                                                    <span class="contentSpan" ng-if="privateClassDetails.venueName != '' && privateClassDetails.venueName != undefined">{{privateClassDetails.venueName}}</span>
                                                    <span class="contentSpan" ng-if="privateClassDetails.venueName == '' || privateClassDetails.venueName == undefined">暂无数据</span>
                                                </div>
                                            </div>
                                            <!--                            课种选择-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">
                                                    <span>2.课种选择</span>
                                                    <?php if(\backend\models\AuthRole::canRoleByAuth('privateCourseList','CHCOURSEUPDATE')){ ?>
                                                        <button class="btn btn-default" data-toggle="modal" ng-click="changeClassChoose()" style="width: auto;">课种选择修改</button>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-11 privateDivBorder" style="padding-left: 0px; padding-right: 0px;" ng-repeat="coursePackage in privateClassDetails.course">
                                                <div class="col-sm-12 privateModalBodyDiv">
                                                    <div class="col-sm-4 mT10 contentBetween">
                                                        <div class="width100">课种:</div>
                                                        <span class="contentSpan">{{coursePackage.name}}</span>
                                                    </div>
                                                    <div class="col-sm-4 mT10 contentBetween">
                                                        <div class="width100">课程时长:</div>
                                                        <span class="contentSpan">{{coursePackage.course_length}}分钟</span>
                                                    </div>
                                                    <div class="col-sm-4 mT10 contentBetween">
                                                        <div class="width100">单节原价:</div>
                                                        <span class="contentSpan">{{coursePackage.original_price}}元</span>
                                                    </div>
                                                    <div class="col-sm-4 mT10 contentBetween">
                                                        <div class="width100">移动端单节原价:</div>
                                                        <span class="contentSpan">{{coursePackage.app_original}}元</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--                            产品价格-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">
                                                    <span>3.产品价格</span>
                                                    <?php if(\backend\models\AuthRole::canRoleByAuth('privateCourseList','CHPRICEUPDATE')){ ?>
                                                        <button class="btn btn-default" data-toggle="modal" ng-click="productPriceUpdate()" style="width: auto;">产品价格修改</button>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-11 privateDivBorder">
                                            <div class="col-sm-11 privateModalBodyDiv "  ng-repeat="sectionPrice in privateClassDetails.price">
                                                <div class="col-sm-4 contentBetween">
                                                    <div class="width100">课程区间节数:</div>
                                                    <span class="contentSpan">{{sectionPrice.intervalStart}}-{{sectionPrice.intervalEnd}}节</span>
                                                </div>
                                                <div class="col-sm-4 contentBetween">
                                                    <div class="width100">优惠单价:</div>
                                                    <span class="contentSpan">{{sectionPrice.unitPrice}}元</span>
                                                </div>
                                                <div class="col-sm-4 contentBetween">
                                                    <div class="width100">总POS价:</div>
                                                    <span class="contentSpan">{{sectionPrice.posPrice}}元</span>
                                                </div>
                                                <div class="col-sm-4 contentBetween">
                                                    <div class="width100">移动端折扣:</div>
                                                    <span class="contentSpan">{{sectionPrice.app_discount}}折</span>
                                                </div>
                                            </div>
                                        </div>
                                            <!--                            售卖场馆-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">
                                                    <span>4.售卖场馆</span>
                                                    <?php if(\backend\models\AuthRole::canRoleByAuth('privateCourseList','CHVENUEUPDATE')){ ?>
                                                        <button class="btn btn-default" data-toggle="modal" ng-click="sellVenueUpdate()" style="width: auto;">售卖场馆修改</button>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-11 privateModalBodyDiv privateDivBorder">
                                                <div class="col-sm-12 contentBetween" >
                                                    <div class="width100">售卖场馆:</div>
                                                    <div></div>
                                                    <div ng-if="privateClassDetails.venue.length > 0" class="contentSpan" ng-repeat="saleVenue in  privateClassDetails.venue">
                                                        <span>{{saleVenue.venueName}}</span>/<span>{{saleVenue.sale_num}}</span>张 <span ng-if="$index != privateClassDetails.venue.length-1">,</span>
                                                    </div>
                                                    <div ng-if="privateClassDetails.venue.length == 0">不限</div>
                                                </div>
                                            </div>
                                            <!--                            售卖场馆-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">
                                                    <span>5.赠品</span>
                                                    <?php if(\backend\models\AuthRole::canRoleByAuth('privateCourseList','CHGIFTUPDATE')){ ?>
                                                        <button class="btn btn-default" data-toggle="modal" ng-click="changeFreeGifts()" style="width: auto;">赠品设置修改</button>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-11 privateModalBodyDiv privateDivBorder">
                                                <div class="col-sm-12 contentBetween">
                                                    <div class="width100">赠品:</div>
                                                    <div ng-if="privateClassDetails.gift.length > 0" class="contentSpan" ng-repeat="gift in  privateClassDetails.gift">
                                                        <span>{{gift.goods_name}}</span>/<span>{{gift.gift_num}}{{gift.unit}}</span> <span ng-if="$index != privateClassDetails.gift.length-1">,</span>
                                                    </div>
                                                    <div ng-if="privateClassDetails.gift.length == 0">暂无数据</div>
                                                </div>
                                            </div>
                                            <!--转让设置-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">
                                                    <span>6.转让设置</span>
                                                    <?php if(\backend\models\AuthRole::canRoleByAuth('privateCourseList','CHTRANSFERUPDATE')){ ?>
                                                        <button class="btn btn-default" data-toggle="modal" ng-click="changeTransferData()" style="width: auto;">转让设置修改</button>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-11 privateModalBodyDiv privateDivBorder">
                                                <div class="col-sm-4 contentBetween" >
                                                    <div class="width100">转让次数:</div>
                                                    <span>{{privateClassDetails.transfer_num | noData:''}}次</span>
                                                </div>
                                                <div class="col-sm-4 contentBetween" >
                                                    <div class="width100">转让金额:</div>
                                                    <span>{{privateClassDetails.transfer_price | noData:''}}元</span>
                                                </div>
                                            </div>
                                            <!--                            预约设置-->
<!--                                            <div class="col-sm-12 pd0 mT20">-->
<!--                                                <p class="titleP">-->
<!--                                                    <span>7.预约设置</span>-->
<!--                                                    原型里没有设计预约设置的修改，原来这个地方也是写死的，所以注释按钮。-->
<!--                                                        <button class="btn btn-default" data-toggle="modal" data-target="#changeTransferSettingModal">修改</button>-->
<!--                                                </p>-->
<!--                                            </div>-->
<!--                                            <div class="col-sm-11 privateModalBodyDiv privateDivBorder">-->
<!--                                                <div class="col-sm-4 pdLR0"><span class="contentSpan">开课前60分钟不可预约</span></div>-->
<!--                                                <div class="col-sm-4 pdLR0"><span class="contentSpan">开课前60分钟不可取消</span></div>-->
<!--                                                <div class="col-sm-4 pdLR0"><span class="contentSpan">可预约7天内的课</span></div>-->
<!--                                            </div>-->
                                            <!--                            课程详情-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">
                                                    <span>7.课程详情</span>
                                                    <?php if(\backend\models\AuthRole::canRoleByAuth('privateCourseList','CHNOTEUPDATE')){ ?>
                                                        <button class="btn btn-default" data-toggle="modal" ng-click="classDetailData()" style="width: auto;">课程详情修改</button>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-8 contentBetween">
                                                    <div class="width100">课程介绍:</div>
                                                    <span class="contentSpan">{{privateClassDetails.describe |noData:''}}</span>
                                                </div>
                                            </div>
                                            <!--                            图片上传-->
                                            <div class="col-sm-11 privateModalBodyDiv privateDivBorder">
                                                <div class="col-sm-8 pdLR0">照片:<span class="contentSpan">
                                                        <span ng-if="privateClassDetails.pic=='' ||privateClassDetails.pic==null ">暂无数据</span>
                                                        <div class="form-group" style="margin-left: 120px">
                                                            <img ng-src="{{privateClassDetails.pic}}" width="100px" height="100px" style="margin-left: -62px;margin-top: -16px;"
                                                                 ng-if="privateClassDetails.pic!=''&& privateClassDetails.pic!=null">
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--合同-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">
                                                   <span>8.合同</span>
                                                   <?php if(\backend\models\AuthRole::canRoleByAuth('privateCourseList','CHDEALUPDATE')){ ?>
                                                  <button class="btn btn-default" data-toggle="modal" ng-click="changeContractDetail()" style="width: auto;">合同设置修改</button>
                                                  <?php } ?>
                                                </p>
                                            </div>
                                            <div style="margin-top: 10px;">
                                                <div class="row">
                                                    <form class="form-horizontal">
                                                        <div class="col-sm-4 clearfix">
                                                            <span class="fl mT5">&nbsp;合同名称&emsp;</span>
                                                            <span ng-if="privateClassDetails.dealName != null && privateClassDetails.dealName !=''">《{{privateClassDetails.dealName | noData:''}}》</span>
                                                            <span ng-if="privateClassDetails.dealName == null || privateClassDetails.dealName ==''">暂无数据</span>
                                                        </div>
                                                        <div ng-if="privateClassDetails.intro" class="col-sm-11"  style="margin: 20px 0;">
                                                            <ul id="bargainContent wB100 mT30 mB30" style="border: 1px solid #999;border-radius: 4px;">
                                                                <li class="text-center" style="font-size: 24px;color:#000000">合同内容</li>
                                                                <li style="height: 300px;overflow-y: auto;padding: 0 10px;line-height: 2;">
                                                                    <span class="contractCss" ng-bind-html="privateClassDetails.intro | to_Html"></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"
                                            style="width: 100px">关闭
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 私课服务详情模态框 -->
                    <div class="modal fade" style="overflow-y: auto;" id="privateServiceModal" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document" style="min-width: 1000px;width: 80%;">
                            <div class="modal-content clearfix">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel"
                                        style="text-align: center;font-size: 18px;">
                                        私教服务详情
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12" style="margin: 10px 20px;">
                                            <!--                            基本属性-->
                                            <p class="titleP">
                                                <span>1.基本属性</span>
                                                <?php if(\backend\models\AuthRole::canRoleByAuth('privateCourseList','CHBASICUPDATE')){ ?>
                                                    <button class="btn btn-default" data-toggle="modal" ng-click="basicTypeUpdateS(privateClassDetails)" style="width: auto;">基本属性修改</button>
                                                <?php } ?>
                                            </p>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-4 mT10 contentBetween">
                                                    <div class="width100">产品名称:</div>
                                                    <span class="contentSpan">{{privateClassDetails.name | noData:''}}</span>
                                                </div>
                                                <div class="col-sm-4 mT10 contentBetween">
                                                    <div class="width100">产品类型:</div>
                                                    <span class="contentSpan" ng-if="privateClassDetails.product_type == 1 || privateClassDetails.product_type =='1'">常规PT</span>
                                                    <span class="contentSpan" ng-if="privateClassDetails.product_type == 2 || privateClassDetails.product_type =='2'">特色课</span>
                                                    <span class="contentSpan" ng-if="privateClassDetails.product_type == 3 || privateClassDetails.product_type =='3'">游泳课</span>
                                                    <span class="contentSpan" ng-if="privateClassDetails.product_type == '' || privateClassDetails.product_type == null || privateClassDetails.product_type == undefined">暂无数据</span>
                                                </div>
                                                <div class="col-sm-4 mT10 contentBetween">
                                                    <div class="width100">产品有效期限:</div>
                                                    <span class="contentSpan">{{privateClassDetails.valid_time | noData:''}}天</span>
                                                </div>
                                                <div class="col-sm-4 mT10 contentBetween">
                                                    <div class="width100">产品激活期限:</div>
                                                    <span class="contentSpan">{{privateClassDetails.activated_time | noData:''}}天</span>
                                                </div>
                                                <div class="col-sm-4 mT10 contentBetween">
                                                    <div class="width100">售卖总数量:</div>
                                                    <span class="contentSpan">{{privateClassDetails.total_sale_num == -1 ?'不限':privateClassDetails.total_sale_num | noData:''}}</span>
                                                </div>
                                                <div class="col-sm-4 mT10 contentBetween">
                                                    <div class="width100">售卖日期:</div>
                                                    <span class="contentSpan">{{privateClassDetails.sale_start_time*1000|date:'yyyy-MM-dd'}}至{{privateClassDetails.sale_end_time*1000|date:'yyyy-MM-dd'}}</span>
                                                </div>
                                                <div class="col-sm-4 mT10 contentBetween">
                                                    <div class="width100">课程类型:</div>
                                                    <span class="contentSpan" ng-if="privateClassDetails.course_type == 1">购买</span>
                                                    <span class="contentSpan" ng-if="privateClassDetails.course_type == 2">赠送</span>
                                                </div>
                                                <div class="col-sm-4 mT10 contentBetween">
                                                    <div class="width100">所属场馆:</div>
                                                    <span class="contentSpan">{{privateClassDetails.venueName | noData:''}}</span>
                                                </div>
                                            </div>
                                            <!--                            课种选择-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">
                                                    <span>2.课种选择</span>
                                                    <?php if(\backend\models\AuthRole::canRoleByAuth('privateCourseList','CHCOURSEUPDATE')){ ?>
                                                        <button class="btn btn-default" data-toggle="modal" ng-click="changeClassChooseS()" style="width: auto;">课种选择修改</button>
                                                    <?php } ?>
                                                </p>
                                            </div>
<!--                                            coursePackageDetail-->
                                            <div class="col-sm-12" style="padding-left: 0px; padding-right: 0px;" ng-repeat="coursePackage in privateClassDetails.course">
                                                <div class="col-sm-12 privateModalBodyDiv">
                                                    <div class="col-sm-4 mT10 contentBetween">
                                                        <div class="width100">课种:</div>
                                                        <span class="contentSpan">{{coursePackage.name}}</span>
                                                    </div>
                                                    <div class="col-sm-4 mT10 contentBetween">
                                                        <div class="width100">课程时长:</div>
                                                        <span class="contentSpan">{{coursePackage.course_length}}分钟</span>
                                                    </div>
                                                    <div class="col-sm-4 mT10 contentBetween">
                                                        <div class="width100">课程节数:</div>
                                                        <span class="contentSpan">{{coursePackage.course_num}}节</span>
                                                    </div>
                                                    <div class="col-sm-4 mT10 contentBetween">
                                                        <div class="width100">单节原价:</div>
                                                        <span class="contentSpan">{{coursePackage.original_price}}元</span>
                                                    </div>
                                                    <div class="col-sm-4 mT10 contentBetween">
                                                        <div class="width100">总原价:</div>
                                                        <span class="contentSpan">{{coursePackage.course_num * coursePackage.original_price}}元</span>
                                                    </div>
                                                    <div class="col-sm-4 mT10 contentBetween">
                                                        <div class="width100">移动端单节原价:</div>
                                                        <span class="contentSpan">{{coursePackage.app_original}}元</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--                            产品价格-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">
                                                    <span>3.产品价格</span>
                                                    <?php if(\backend\models\AuthRole::canRoleByAuth('privateCourseList','CHPRICEUPDATE')){ ?>
                                                        <button class="btn btn-default" data-toggle="modal" ng-click="productPriceUpdateS()" style="width: auto;">产品价格修改</button>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-4 contentBetween">
                                                    <div class="width100">总售价:</div>
                                                    <span class="contentSpan">{{privateClassDetails.total_amount | noData:''}}</span>
                                                </div>
                                                <div class="col-sm-4 contentBetween">
                                                    <div class="width100">总POS价:</div>
                                                    <span class="contentSpan">{{privateClassDetails.total_pos_price | noData:''}}</span>
                                                </div>
                                                <div class="col-sm-4 contentBetween">
                                                    <div class="width100">移动端总售价:</div>
                                                    <span class="contentSpan">{{privateClassDetails.app_amount | noData:''}}</span>
                                                </div>
                                            </div>
                                            <!--                            售卖场馆-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">
                                                    <span>4.售卖场馆</span>
                                                    <?php if(\backend\models\AuthRole::canRoleByAuth('privateCourseList','CHVENUEUPDATE')){ ?>
                                                        <button class="btn btn-default" data-toggle="modal" ng-click="sellVenueUpdate()" style="width: auto;">售卖场馆修改</button>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-12 contentBetween" >
                                                    <div class="width100">售卖场馆:</div>
                                                    <div ng-if="privateClassDetails.venue.length > 0" class="contentSpan" ng-repeat="saleVenue in  privateClassDetails.venue">
                                                        <span>{{saleVenue.venueName}}</span>/<span>{{saleVenue.sale_num}}</span>张 <span ng-if="$index != privateClassDetails.venue.length-1">,</span>
                                                    </div>
                                                    <div ng-if="privateClassDetails.venue.length == 0">不限</div>
                                                </div>
                                            </div>
                                            <!--                            售卖场馆-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">
                                                    <span>5.赠品</span>
                                                    <?php if(\backend\models\AuthRole::canRoleByAuth('privateCourseList','CHGIFTUPDATE')){ ?>
                                                        <button class="btn btn-default" data-toggle="modal" ng-click="changeFreeGifts()" style="width: auto;">赠品设置修改</button>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-12 contentBetween" >
                                                    <div class="width100">赠品:</div>
                                                    <div ng-if="privateClassDetails.gift.length > 0" class="contentSpan" ng-repeat="gift in  privateClassDetails.gift">
                                                        <span>{{gift.goods_name}}</span>/<span>{{gift.gift_num}}{{gift.unit}}</span> <span ng-if="$index != privateClassDetails.gift.length-1">,</span>
                                                    </div>
                                                    <div ng-if="privateClassDetails.gift.length == 0">暂无数据</div>
                                                </div>
                                            </div>
                                            <!--转让设置-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">
                                                    <span>6.转让设置</span>
                                                    <?php if(\backend\models\AuthRole::canRoleByAuth('privateCourseList','CHTRANSFERUPDATE')){ ?>
                                                        <button class="btn btn-default" data-toggle="modal" ng-click="changeTransferData()" style="width: auto;">转让设置修改</button>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-4 contentBetween" >
                                                    <div class="width100">转让次数:</div>
                                                    <span>{{privateClassDetails.transfer_num | noData:''}}次</span>
                                                </div>
                                                <div class="col-sm-4 contentBetween" >
                                                    <div class="width100">转让金额:</div>
                                                    <span>{{privateClassDetails.transfer_price | noData:''}}元</span>
                                                </div>
                                            </div>
                                            <!--                            预约设置-->
<!--                                            <div class="col-sm-12 pd0 mT20">-->
<!--                                                <p class="titleP">7.预约设置</p>-->
<!--                                            </div>-->
<!--                                            <div class="col-sm-12 privateModalBodyDiv">-->
<!--                                                <div class="col-sm-4 pdLR0"><span class="contentSpan">开课前60分钟不可预约</span></div>-->
<!--                                                <div class="col-sm-4  pdLR0"><span class="contentSpan">开课前60分钟不可取消</span></div>-->
<!--                                                <div class="col-sm-4 pdLR0"><span class="contentSpan">可预约7天内的课</span></div>-->
<!--                                            </div>-->
                                            <!--                            课程详情-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">
                                                    <span>7.课程详情</span>
                                                    <?php if(\backend\models\AuthRole::canRoleByAuth('privateCourseList','CHNOTEUPDATE')){ ?>
                                                        <button class="btn btn-default" data-toggle="modal" ng-click="classDetailData()" style="width: auto;">课程详情修改</button>
                                                    <?php } ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-8 contentBetween">
                                                    <div class="width100">课程介绍:</div>
                                                    <span class="contentSpan">{{privateClassDetails.describe | noData:''}}</span>
                                                </div>
                                            </div>
                                            <!--                            图片上传-->
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-8 pdLR0">照片:<span class="contentSpan">
                                                        <span ng-if="privateClassDetails.pic=='' ||privateClassDetails.pic==null ">暂无数据</span>
                                                        <div class="form-group" style="margin-left: 120px">
                                                            <img ng-src="{{privateClassDetails.pic}}" width="150px" height="150px"
                                                                 ng-if="privateClassDetails.pic!=''&& privateClassDetails.pic!=null">
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                            <!--合同-->
                                            <div class="col-sm-12 pd0 mT20">
                                            <p class="titleP">
                                                <span>8.合同</span>
                                                <?php if(\backend\models\AuthRole::canRoleByAuth('privateCourseList','CHDEALUPDATE')){ ?>
                                                    <button class="btn btn-default" data-toggle="modal" ng-click="changeContractDetail()" style="width: auto;">合同设置修改</button>
                                                <?php } ?>
                                            </p>
                                            </div>
                                            <div style="margin-top: 10px;">
                                                <div class="row">
                                                    <form class="form-horizontal">
                                                        <div class="col-sm-12 privateModalBodyDiv">
                                                            <div class="col-sm-12 contentBetween" style="padding: 0 15px;">
                                                                <div class="width100">合同名称:</div>
                                                                <span ng-if="privateClassDetails.dealName != null && privateClassDetails.dealName !=''">《{{privateClassDetails.dealName | noData:''}}》</span>
                                                                <span ng-if="privateClassDetails.dealName == null || privateClassDetails.dealName ==''">暂无数据</span>
                                                            </div>
                                                        </div>
                                                        <div ng-if="privateClassDetails.intro" class="col-sm-11"  style="margin: 20px 0;">
                                                            <ul id="bargainContent wB100 mT30 mB30" style="border: 1px solid #999;border-radius: 4px;">
                                                                <li class="text-center" style="font-size: 24px;color:#000000">合同内容</li>
                                                                <li style="height: 300px;overflow-y: auto;padding: 0 10px;line-height: 2;">
                                                                    <span class="contractCss" ng-bind-html="privateClassDetails.intro | to_Html"></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"
                                            style="width: 100px">关闭
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 修改私课详情的8个模态框 -->
                    <?= $this->render('@app/views/private-lesson/changePrivateLessonModal.php'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
