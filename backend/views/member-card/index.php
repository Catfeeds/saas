<?php
use backend\assets\MemberCardCtrlAsset;
MemberCardCtrlAsset::register($this);
$this->title = '卡种管理';
?>
<div ng-controller="indexController" ng-cloak>
    <main>
        <header>
            <div class="wrapper wrapper-content  animated fadeIn">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                 <span style="display: inline-block" class="spanSmall"><b>卡种管理</b></span>
                            </div>
                            <div class="panel-body">
                                <div class="col-sm-12 col-md-12">
                                    <div class="col-sm-6 col-md-6 col-sm-offset-1 col-md-offset-2" >
                                        <div class="input-group">
                                            <input type="text" ng-model="cardName"
                                                   class="form-control h34"
                                                   placeholder="请输入卡名称和合同名称进行搜索..."
                                                   ng-keyup="enterSearch($event)">
                                            <span class="input-group-btn">
                                                <button type="button ladda-button" ladda="searchCarding" ng-click="searchCard()" class="btn btn-primary">搜索</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-5 col-md-4" style="display: flex;justify-content: space-between;">
                                        <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'SETTING')) { ?>
                                            <button class="btn btn-white"   ng-click="setClick123()">
                                                <span class="fa fa-gear"></span>
                                                &nbsp;&nbsp;
                                                设置
                                            </button>
                                        <?php } ?>
                                        <div class="btn-group" role="group">
                                            <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'ADD')) { ?>
                                                <section type="button "  class="btn btn-success btn w160 " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                                    新增卡种类型
                                                </section>
                                                <ul  class="dropdown-menu selectCards" style="margin-left: 0;">
                                                    <li ><a href="/member-card/new-time-card?&c=12">时间卡</a></li>
                                                    <li><a href="/member-card/number-card?&c=12">次卡</a></li>
                                                    <li><a href="/rechargeable-card-ctrl/index?&c=12">充值卡</a></li>
                                                    <li><a href="/member-card/blend-card?&c=12">混合卡</a></li>
                                                </ul>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-12 pd0">
                                    <div id="search">
                                        <ul class="nav nav-pills pT30" role="tablist" >
                                            <li style="height: 30px;margin-left: 16px;">
                                                <div  class="fl pRelative mT0 mLF14 w200 input-daterange input-group cp" id="container" style="width: 298px;">
                                                    <span class="add-on input-group-addon">选择时间:<i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                                    <input type="text"  readonly name="reservation" id="reservationDate" class="w200 bGwhite form-control text-center" value="" placeholder="选择时间"/>
                                                </div>
                                                <!--                                        <div style="float: left;position: relative;margin-left: 0" class="input-daterange input-group cp" id="container">-->
                                                <!--                                            <i style="position: absolute;top: 8px;left: 100px;;z-index: 999;" class="fa fa-calendar leftDate"></i>-->
                                                <!--                                            <i style="position: absolute;top: 8px;right: 8px;;z-index: 999;" class="fa fa-calendar rightDate"></i>-->
                                                <!--                                            <input type="text" id = 'datetimeStart' ng-model="startTime" class="input-sm form-control" name="start" placeholder="售卖开始日期"  style="width: 120px;text-align:left;font-size: 13px;cursor: pointer;">-->
                                                <!--                                            <input type="text" id="datetimeEnd" ng-model="endTime" class="input-sm form-control" name="end" placeholder="售卖结束日期" style="width: 120px;text-align: left;font-size: 13px;cursor: pointer;">-->
                                                <!--                                        </div>-->
                                            </li>
                                            <li >
                                                <span>公司</span>
                                                <label for="id_label_single">
                                                    <select class="form-control w110 pT3" ng-change="getCardVenueOptions(company_id)"  ng-model="company_id" id="memberCardCompanyId">
                                                        <option value="">全部</option>
                                                        <option value="{{company.id}}" ng-repeat="company in optionCompany" >{{company.name}}</option>
                                                    </select>
                                                </label>
                                            </li>
                                            <li style="margin-left: -16px; margin-right: 1px;">
                                                <span>场馆</span>
                                                <label for="id_label_single">
                                                    <select class="form-control w110 pT3"  ng-model="venue_id" id="memberCardVenueId">
                                                        <option value="">全部</option>
                                                        <option value="{{w.id}}" ng-repeat="w in optionVenue" >{{w.name}}</option>
                                                    </select>
                                                </label>
                                            </li>
                                            <li class="mL3Rem">
                                                <span>卡类别</span>
                                                <label for="id_label_single">
                                                    <select class="form-control w110 pT3" ng-model="cardType"    id="memberCardType">
                                                        <option value="">不限</option>
                                                        <option value="{{w.id}}" ng-repeat="w in optionType" >{{w.type_name}}</option>
                                                        </select>
                                                </label>
                                                <span>卡状态</span>
                                                <label for="id_label_single">
                                                    <select class="form-control w110 pT3" ng-model="status"    id="memberCardStatus">
                                                        <option value="">不限</option>
                                                        <option value="1">正常</option>
                                                        <option value="2">冻结</option>
                                                        <option value="3">过期</option>
                                                        <option value="4">审核中</option>
                                                        <option value="5">拒绝</option>
                                                        <option value="6">撤销</option>
                                                    </select>
                                                </label>
                                                <span>卡类型</span>
                                                <label for="id_label_single">
                                                    <select class="form-control w110 pT3" ng-model="type123" id="type123">
                                                        <option value="">请选择类型</option>
                                                        <option value="1">瑜伽</option>
                                                        <option value="2">健身</option>
                                                        <option value="3">舞蹈</option>
                                                        <option value="4">综合</option>
                                                    </select>
                                                </label>
                                                <span>合同绑定</span>
                                                <label for="id_label_single">
                                                    <select class="form-control w110 pT3" ng-model="deal123" id="deal123">
                                                        <option value="">合同绑定</option>
                                                        <option value="1">已绑定</option>
                                                        <option value="2">未绑定</option>
                                                    </select>
                                                </label>
                                            </li>
                                            <li class="mR6" style="margin-left: -15px;">
                                                <div class=" input-group colorEEE w100 mB5" id="datepicker" >
                                                    <input class="form-control w57" name="start" min="0"  ng-model="minPrice" placeholder="元" ng-blur="minPriceChange(minPrice)"  type="number">
                                                    <span class="goTo fl">到</span>
                                                    <input class="form-control w57 fr bRadius2" min="0"  name="end" ng-blur="maxPriceChange(maxPrice)"  ng-model="maxPrice"  placeholder="元"  type="number">
                                                </div>
                                            </li>
                                            <div style="width: 190px;display: flex;">
                                                <li class="mR6"><input type="checkbox" value="1" ng-model="isCheck" style="width: 20px;height: 20px"><span style="width: 20px;height: 20px;position: relative;top:-5px">全部卡种</span></li>
                                                <li class="mR6">
                                                    <button type="button" ladda="searchCarding" ng-click="searchCard()" class="btn btn-sm btn-success">确定</button>
                                                </li>
                                                <li>
                                                    <button type="button" ladda="searchCarding" ng-click="searchClear()" class="btn btn-sm btn-info mL6">清空</button>
                                                </li>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title h37" >卡种管理</div>
                            <div class="ibox-content pd0" >
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                    <div class="row">
                                        <div class="col-sm-6 disNone" ><div id="DataTables_Table_0_filter" class="dataTables_filter"></div></div></div><table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting"
                                                tabindex="0"
                                                aria-controls="DataTables_Table_0"
                                                rowspan="1"
                                                colspan="1"
                                                aria-label="浏览器：激活排序列升序"
                                                ng-click="changeSort('card_type',sort)"
                                            >
                                                <i class="glyphicon glyphicon-credit-card"></i>&nbsp;卡类型
                                            </th>
                                            <!-- ng-class="{'ASC': 'sorting_asc','DES': 'sorting_desc'}[sort]"-->
                                            <th class="sorting"
                                                tabindex="0"
                                                aria-controls="DataTables_Table_0"
                                                rowspan="1"
                                                colspan="1"
                                                aria-label="浏览器：激活排序列升序"
                                                aria-sort="descending"
                                                ng-click="changeSort('card_name',sort)"
                                            >
                                                <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;卡名称
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                ng-click="changeSort('card_price',sort)"
                                                colspan="1" aria-label="引擎版本：激活排序列升序" style="">
                                                <span class="glyphicon glyphicon-usd" aria-hidden="true"></span>&nbsp;售价
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="引擎版本：激活排序列升序" style=""
                                                ng-click="changeSort('card_term',sort)">
                                                <span class="glyphicon glyphicon-sound-stereo" aria-hidden="true"></span></span>&nbsp;有效天数
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="平台：激活排序列升序" style=""
                                                ng-click="changeSort('card_times',sort)">
                                                <span class="glyphicon glyphicon-file" aria-hidden="true"></span></span>&nbsp;次数
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="引擎版本：激活排序列升序" style=""
                                                ng-click="changeSort('card_active',sort)">
                                                <span class="fa fa-server" aria-hidden="true"></span></span>&nbsp;激活期限
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="引擎版本：激活排序列升序" style=""
                                                ng-click="changeSort('card_status',sort)">
                                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>&nbsp;状态
                                            </th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="引擎版本：激活排序列升序" style="">编辑
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbody">
    <!--                                    data-toggle="modal" data-target="#myModals2"-->
                                        <tr class="gradeA odd cp"  ng-mouseover="elementTr(event)" ng-repeat="(index,item) in items" >
                                            <td data-toggle="modal" data-target="#myModals2" ng-click="getCardDetail(item.id)" style="display: flex;justify-content: space-between;align-items: center;">
                                                <div>{{item.cardCategoryType.type_name}}</div>
                                                <div>
                                                    <small class="label label-danger " ng-if="item.is_app_show == 2">手机端不显示</small>
                                                </div>
                                            </td>
                                            <td data-toggle="modal" data-target="#myModals2" ng-click="getCardDetail(item.id)">{{item.card_name}}</td>
                                            <td data-toggle="modal" data-target="#myModals2" ng-click="getCardDetail(item.id)">{{item | cardPrice}}</td>
                                            <td data-toggle="modal" data-target="#myModals2" ng-click="getCardDetail(item.id)">{{item.duration | stringToArr}}</td>
                                            <td data-toggle="modal" data-target="#myModals2" ng-click="getCardDetail(item.id)">{{item.times | noData:'次':'num'}}</td>
                                            <td data-toggle="modal" data-target="#myModals2" ng-click="getCardDetail(item.id)">{{item.active_time | noData:'天'}}</td>
                                            <td data-toggle="modal" data-target="#myModals2" ng-click="getCardDetail(item.id)">
                                                <span class="label label-danger"  ng-if="item.status == 2">冻结</span>
                                                <span class="label label-warning" ng-if="item.status == 3">过期</span>
                                                <span class="label label-info"    ng-if="item.status == 4">审核中</span>
                                                <span class="label label-success" ng-if="item.status == 1">正常</span>
                                                <span class="label label-danger"    ng-if="item.status == 5">已拒绝</span>
                                                <span class="label label-default"    ng-if="item.status == 6">已撤销</span>
                                            </td>

                                            <td class="pd0">
                                                <div class="displayBlock">
                                                    <div class="checkbox editstatus123" ng-if="item.status != 4">
                                                        <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'OVERDUE')) { ?>
                                                        <input class="inputCheckBox" type="checkbox" value="" ng-checked="item.status == 3" ng-click="editStatus(item.id,index,'time')" >
                                                        <span class="f13">过期</span>
                                                        <?php }?>
                                                    </div>
                                                    <div class="checkbox " ng-if="item.status != 4">
                                                        <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'OPERATE')) { ?>
                                                        <input  class="inputCheckBox editstatus123" type="checkbox" ng-checked="item.status == 2" ng-click="editStatus(item.id,index,'ban')" value="" >
                                                        <span class="f13">冻结</span>
                                                        <?php }?>
                                                    </div>
<!--                                                    --><?php //if (\backend\models\AuthRole::canRoleByAuth('card', 'UPDATE')) { ?>
<!--                                                    <button class="btn btn-success btn-sm" type="submit" ng-click="updateCard(item.id)"><a style="color: #fff" href="#">修改</a></button>&nbsp;&nbsp;-->
<!--                                                    --><?php //}?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('card', 'CARDSHOW')) { ?>
                                                    <button class="btn btn-primary btn-sm mL6" ng-click="isShow(item.id)"   type="submit">{{item.is_app_show != 1? '显示':'不显示'}}</button>
                                                    <?php }?>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?=$this->render('@app/views/common/nodata.php');?>
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                                <?=$this->render('@app/views/common/page.php');?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </header>
    </main>
    <!-- 会员详情-->
    <?= $this->render('@app/views/member-card/publicCardEdit.php'); ?>
    
    <!--修改卡种模态框-->
    <div  class="modal fade" id="myModals12"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div  class="modal-dialog mT30 w760" >
            <div  class="modal-content borderNone">
                <div  class="modal-header borderNone">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">

                        &times;
                    </button>
                    <div class="panel-title m-b-md">
                        <h3 class="text-center">修改会员卡</h3>
                    </div>
                    <div class="panel blank-panel col-sm-12">
                        <div class="panel-heading">

                        </div>
                        <div class="panel-body" style="max-height: 500px;overflow-y: scroll;">
                            <div class="col-sm-12 text-right heightCenter" ng-if="originalPriceInit != null && originalPriceInit != '' && originalPriceInit != undefined">
                                <div class="col-sm-2 col-sm-offset-1"><span style="color: red">*</span>一口价</div>
                                <div class="col-sm-4">
                                    <input type="text"     ng-model="originalPrice123" class="form-control originalPrice123" placeholder="展示价格" >
                                </div>
                                <div class="col-sm-4">
                                    <input type="text"     ng-model="sellPrice123"  class="form-control sellPrice123" placeholder="售卖价格">
                                </div>
                            </div>
                            <div class="col-sm-12 text-right heightCenter" style="margin-top: 20px" ng-if="minPriceInit != null && minPriceInit != '' && minPriceInit != undefined">
                                <div class="col-sm-2 col-sm-offset-1"><span style="color: red">*</span>区域定价</div>
                                <div class="col-sm-4">
                                    <input type="text"    ng-model="minPrice123" class="form-control minPrice123" placeholder="最低价">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text"    ng-model="maxPrice123"  class="form-control maxPrice123" placeholder="最高价">
                                </div>
                            </div>
                            <div class="col-sm-12 text-right heightCenter" style="margin-top: 20px">
                                <div class="col-sm-2 col-sm-offset-1"><span style="color: red">*</span>售卖场馆</div>
                                <div class="col-sm-4">
                                    <select type="text" class="form-control" ng-change="selectedSellVenueId(sellVenueId123)" ng-model="sellVenueId123" id="sellVenueId123"  style="padding: 4px 12px;">
                                        <option value="">请选择售卖场馆</option>
                                        <option value="{{venue.id}}" data-valueId="{{venue}}" ng-repeat="venue in sellVenueLists">{{venue.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-sm-12 text-right heightCenter "style="margin-top: 20px">
                                <div class="col-sm-3 "><span style="color: red">*</span>正常价售卖数</div>
                                <div class="col-sm-4 ">
                                    <div class=" inputUnlimited  cp h32 " id="NormalSaleNum" style="border: solid 1px #cfdadd;border-radius: 3px;display: inline-block;">
                                        <input style="border: none;margin-left: 0;" type="number"  name="discountNum" min="0" value="" placeholder="0张" class="fl form-control">
                                        <div class="checkbox i-checks checkbox-inline" style="width:80px;position: absolute;right: 4px;">
                                            <label>
                                                <input type="checkbox" value="" name="discountNumLimit"> <i></i> 不限</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 fl heightCenter  w32 input-daterange cp pRelative" style="margin-bottom: 10px;">
                                <div class="col-sm-2 col-sm-offset-1 text-right"><strong style="color: red">*</strong>售卖日期</div>
                                <div class="col-sm-4"><input type="text" id ='datetimeStart123' ng-model="sellStartDate123" class="input-sm form-control datetimeStart dateCss" name="start" placeholder="起始日期"  ></div>
                                <div class="col-sm-4"><input type="text" id="datetimeEnd123" ng-model="sellEndDate123" class="input-sm form-control datetimeEnd dateCss" name="end" placeholder="结束日期" ></div>
                            </div>
<!--                            <div class="col-sm-12 pd0 oldDiscount" style="border-bottom: solid 1px #f5f5f5;">-->
<!--                                <div class="col-sm-12 heightCenter removeChildDiv" style="margin-top: 10px;" ng-repeat="oldDiscount in oldDiscountLists">-->
<!--                                    <div class="col-sm-5 ">-->
<!--                                        <ul class="col-sm-12 heightCenter">-->
<!--                                            <li class="col-sm-6 text-right">折扣</li>-->
<!--                                            <li class="col-sm-6"><input  type="number"   name="oldDiscount" min="0" value="{{oldDiscount.discount}}" placeholder="0折" class="fl form-control"></li>-->
<!--                                        </ul>-->
<!--                                    </div>-->
<!--                                    <div class="col-sm-6 pd0">-->
<!--                                        <ul class="col-sm-12 pd0 heightCenter">-->
<!--                                            <li class="col-sm-4 pd0  text-left">折扣价售卖数</li>-->
<!--                                            <li class="col-sm-6 pd0" style="margin-left: -16px;">-->
<!--                                                <div class="inputUnlimited   cp h32 " style="border: solid 1px #cfdadd;border-radius: 3px;display: inline-block;">-->
<!--                                                    <input  data-num="{{oldDiscount.surplus}}" style="border: none;margin-left: 0;" type="text" checknum name="addOldDiscountNum" min="0" value="" placeholder="0张" class="fl form-control">-->
<!--                                                    <div  class="checkbox i-checks checkbox-inline" style="position: absolute;right: -10px;">-->
<!--                                                        <label>-->
<!--                                                            <input  type="checkbox" value="" name=""> <i></i> 不限</label>-->
<!--                                                    </div>-->
<!--                                                </div>-->
<!--                                            </li>-->
<!--                                        </ul>-->
<!--                                    </div>-->
<!--                                    <div class="col-sm-1 pd0 mT10">-->
<!--                                        <button  style="margin-left: 15px;" type="button" class="btn btn-sm btn-default  removeHtml"  data-remove="removeChildDiv">删除</button>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div  class="col-sm-12 pd0 addNewDiscount" style="margin-top: 10px;">
                                <div class="col-sm-12 heightCenter removePageDiv" style="margin-top: 10px;" ng-repeat="oldDiscount in oldDiscountLists">
                                    <div class="col-sm-5 ">
                                        <ul class="col-sm-12 heightCenter">
                                            <li class="col-sm-6 text-right">折扣</li>
                                            <li class="col-sm-6"><input  type="number"   name="addNewDiscount" min="0" value="{{oldDiscount.discount}}" placeholder="0折" class="fl form-control"></li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6 pd0">
                                        <ul class="col-sm-12 pd0 heightCenter">
                                            <li class="col-sm-4 pd0  text-left">折扣价售卖数</li>
                                            <li class="col-sm-6 pd0" style="margin-left: -16px;">
                                                <div class="inputUnlimited   cp h32 " style="border: solid 1px #cfdadd;border-radius: 3px;display: inline-block;">
                                                    <input  data-num="{{oldDiscount.surplus}}" style="border: none;margin-left: 0;" type="text" checknum name="addNewDiscountNum" min="0" value="" placeholder="0张" class="fl form-control">
                                                    <div  class="checkbox i-checks checkbox-inline" style="position: absolute;right: -10px;">
                                                        <label>
                                                            <input  type="checkbox" value="" name=""> <i></i> 不限</label>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-1 pd0 mT10" ng-if="$index != 0">
                                        <button  style="margin-left: 15px;" type="button" class="btn btn-sm btn-default  removeHtml"  data-remove="removePageDiv">删除</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 addNewDiscountBtn" >
                                <div class="col-sm-offset-3 col-sm-8"><button id="addNewDiscount" class="btn btn-sm btn-default" ng-click="addNewDiscountHtml()" venuehtml="" >&emsp;添加折扣&emsp;</button></div>
                            </div>

                        </div>
                        <div class="col-sm-12 text-center" style="margin-top: 30px;">
                            <button class="btn btn-success btn-sm" style="width: 100px;" type="button" ng-click="editSubmit()">提交</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 设置时间模态框 -->
    <div class="modal fade" id="siteModal"  role="dialog" aria-labelledby="myModalLabel">
        <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
        <div class="modal-dialog" role="document" style="width: 720px;">
            <div class="modal-content clearfix" style="min-height: 500px;">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">设置</h4>
                </div>
                <div class="modal-body pd0" >
                    <section class="row pd0" >
                        <div class="col-sm-12">
                            <div class="tabs-container">
                                <div class="tabs-left">
                                    <ul class="nav nav-tabs ">
                                        <li class="active text-center"><a data-toggle="tab" ng-click="selectRenewClick()" href="#tab-8">续费</a>
                                        </li>
                                        <li class=" text-center"><a data-toggle="tab" ng-click="selectDiveClick()" href="#tab-9">赠送</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="tab-8" class="tab-pane active">
                                            <div class="panel-body" style="border-bottom: none;padding-top: 30px;">
                                                <form class="form-horizontal ">
                                                    <div class="form-group" >
                                                        <label  class="col-sm-4 control-label freeLabel" for="siteInput"><span class="red">*</span>选择场馆</label>
                                                        <div class="col-sm-7">
                                                            <select class="form-control cp selectPd" id="selectedVenueSetRe123"
                                                                    ng-change="getDefaultSet123(venueId)"
                                                                    ng-model="venueId">
                                                                <option value="">请选择场馆</option>
                                                                <option value="{{venue.id}}" class="optionsCards" ng-repeat="venue in VenueItems">{{venue.name}}</option>
                                                            </select>
                                                            <p class="messageG">
                                                                <i class="glyphicon glyphicon-info-sign"></i>
                                                                给哪个场馆设置续费
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" >
                                                        <label  class="col-sm-4 control-label freeLabel" for="siteInput"><span class="red">*</span>续费设置</label>
                                                        <div class="col-sm-7">
                                                            <input type="number" checknum class="form-control" id="siteInput" placeholder="几天" ng-model="noOrderDay"/>
                                                            <p class="messageG">
                                                                <i class="glyphicon glyphicon-info-sign"></i>
                                                                会员卡到期多少天后不可续费
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label freeLabel" for="EarlyRenewals"><span class="red">*</span>提前续费</label>
                                                        <div class="col-sm-7">
                                                            <input type="number" checknum class="form-control" id="EarlyRenewals" placeholder="几天" ng-model="EarlyRenewals"/>
                                                            <p class="messageG">
                                                                <i class="glyphicon glyphicon-info-sign"></i>
                                                                会员卡即将到期提前多少天可以续费
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-4 control-label freeLabel" for="siteInput">充值卡设置</label>
                                                        <div class="col-sm-7">
                                                            <input type="number"  id="rechargeCardSet123" class="form-control"  placeholder="0元" ng-model="rechargeCardSet123"/>
                                                            <p class="messageG">
                                                                <i class="glyphicon glyphicon-info-sign"></i>
                                                                充值卡每次进馆消费金额
                                                            </p>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="col-sm-12">
                                                    <button type="button" class="btn btn-success center-block successBtn" ladda="renewMoneySuccessFlag" ng-click="renewMoneySuccess()">完成</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="tab-9" class="tab-pane">
                                            <div class="panel-body" style="border-bottom: none;padding-top: 10px;">
                                                <section class="row" style="overflow-y: scroll;height: 360px;">
                                                    <div class="col-sm-12 setRoleBox">
                                                        <div class="col-sm-12 heightCenter">
                                                            <label class="col-sm-3 pd0 formLabel" ><span class="red">*</span>选择场馆</label>
                                                            <div class="col-sm-9 pd0">
                                                                <select class="form-control "
                                                                        id="selectedVenueSet"
                                                                        ng-change="selectedVenueChange(venueSet)"
                                                                        ng-model="venueSet"
                                                                >
                                                                    <option value="">请选择场馆</option>
                                                                    <option value="{{venue.id}}"
                                                                            data-company="{{venue.pid}}"
                                                                            class="optionsCards"
                                                                            ng-repeat="venue in VenueItems">{{venue.name}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 heightCenter mT20">
                                                            <div class="col-sm-3 pd0"><span class="red">*</span>赠送类型</div>
                                                            <div class="col-sm-9 pd0">
                                                                <select class="form-control selectCss" ng-model="selectGiveType" ng-change="selectGiveTypeChange(selectGiveType)">
                                                                    <option value="">请选择赠送类型</option>
                                                                    <option value="1">新购卡的赠送</option>
                                                                    <option value="2">其它赠送</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 pd0 setRoleContent " ng-if="defaultGiveSetLists.length == 0 "  style="border-bottom: solid 1px #F5F5F5;padding-bottom: 10px;">
                                                            <div class="col-sm-12  heightCenter mT20">
                                                                <div class="col-sm-3 pd0"><span class="red">*</span>使用角色</div>
                                                                <div class="col-sm-9 pd0">
                                                                    <select id="setRole123" class="form-control  selectCss selectRole123" multiple="multiple"  style="overflow-x: scroll;">
                                                                        <!--                                                                        <option value="">请选择角色</option>-->
                                                                        <option title="{{role.name}}" value="{{role.id}}" ng-repeat="role in setRoleLists123">{{role.name | cut:true:8:'...'}}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12  heightCenter mT40" ng-if="selectGiveType == 1">
                                                                <div class="col-sm-3 pd0"><span class="red">*</span>会员卡选择</div>
                                                                <div class="col-sm-9 pd0 cardBox" style="display: flex">
                                                                    <select id="allMemberCard"  class="form-control  selectCss selectMemberCard123" multiple="multiple"  style="overflow-x: scroll;">
                                                                        <option  title="{{card.card_name}}" value="{{card.id}}" ng-repeat="card in cardItems">{{card.card_name | cut:true:12:'...'}}</option>
                                                                    </select>
                                                                    <div class="checkbox i-checks checkbox-inline " style="width: 120px;padding-right: 0;">
                                                                        <label>
                                                                            <input name="allCard" type="checkbox" value="-1"> <i></i> 全选</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 heightCenter mT30">
                                                                <div class="col-sm-6 pd0"><span class="red">*</span>赠送天数</div>
                                                                <div class="col-sm-6 pd0">
                                                                    <input type="text" inputnum name="giveDays" class="form-control"  placeholder="0天">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 heightCenter mT30">
                                                                <div class="col-sm-6 pd0">每月赠送量</div>
                                                                <div class="col-sm-6 pd0">
                                                                    <input type="text" inputnum name="giveNum" class="form-control"  placeholder="0张">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 pd0 setRoleContent removeDefaultDiv" ng-if="defaultGive.id != undefined && defaultGive.id != null && defaultGiveSetLists.length !=0" ng-repeat="defaultGive in defaultGiveSetLists" style="border-bottom: solid 1px #F5F5F5;padding-bottom: 10px;">
                                                            <div class="col-sm-12  heightCenter mT20">
                                                                <div class="col-sm-3 pd0"><span class="red">*</span>使用角色</div>
                                                                <div class="col-sm-9 pd0">
                                                                    <select id="setRole123" class="form-control  selectCss selectRole123" multiple="multiple"  style="overflow-x: scroll;">
<!--                                                                        <option value="">请选择角色</option>-->
                                                                        <option title="{{role.name}}" value="{{role.id}}" ng-repeat="role in setRoleLists123">{{role.name | cut:true:8:'...'}}</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12  heightCenter mT40" ng-if="selectGiveType == 1">
                                                                <div class="col-sm-3 pd0"><span class="red">*</span>会员卡选择</div>
                                                                <div class="col-sm-9 pd0 cardBox" style="display: flex">
                                                                    <select id="allMemberCard" data-num="{{cardLength}}" class="form-control  selectCss selectMemberCard123" multiple="multiple"  style="overflow-x: scroll;">
                                                                        <option  title="{{card.card_name}}" value="{{card.id}}" ng-repeat="card in cardItems">{{card.card_name | cut:true:12:'...'}}</option>
                                                                    </select>
                                                                    <div class="checkbox i-checks checkbox-inline " style="width: 120px;padding-right: 0;">
                                                                        <label>
                                                                            <input name="allCard" type="checkbox" value="-1"> <i></i> 全选</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 heightCenter mT30">
                                                                <div class="col-sm-6 pd0"><span class="red">*</span>赠送天数</div>
                                                                <div class="col-sm-6 pd0">
                                                                    <input type="text" inputnum name="giveDays" class="form-control" value="{{defaultGive.days}}" placeholder="0天">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 heightCenter mT30">
                                                                <div class="col-sm-6 pd0">每月赠送量</div>
                                                                <div class="col-sm-6 pd0">
                                                                    <input type="text" inputnum name="giveNum" class="form-control" value="{{defaultGive.gift_amount == -1 ?'': defaultGive.gift_amount}}" placeholder="0张">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12" >
<!--                                                                <button ng-if="defaultGive.id == ''"  style="margin-left: 6px;" type="button" class="btn btn-sm btn-default  removeHtml"   data-remove="removeDefaultDiv">&emsp;删除&emsp;</button>-->
                                                                <button ng-if="defaultGive.id != ''"  style="margin-left: 6px;" type="button" class="btn btn-sm btn-default "    ng-click="deleteRoleAndCard(defaultGive.id)">&emsp;删除&emsp;</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12 addSetRoleDiv" >
                                                        <div class="col-sm-12" style="margin-top: 10px;"><button id="addSetRole" class="btn btn-sm btn-default" ng-click="addRoleGiveHtml()" venuehtml="" >&emsp;新增赠送&emsp;</button></div>
                                                    </div>
                                                </section>
                                                <div class="col-sm-12 text-center" ng-if="submitIsFlag">
                                                    <button class="btn btn-success" ladda="setRoleCompleteFlag" ng-click="setRoleComplete()">&emsp;提交&emsp;</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

</div>
