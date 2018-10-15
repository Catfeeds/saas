<?php
use backend\assets\GiftCardCtrlAsset;
GiftCardCtrlAsset::register($this);
$this->title = '赠卡管理';
?>
<main ng-controller="giftCardCtrl" ng-cloak>
    <input id="_csrf" type="hidden"
           name="<?= \Yii::$app->request->csrfParam; ?>"
           value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <div class="wrapper wrapper-content animated fadeIn" >
        <div class="row pdLR0">
            <div class="col-sm-12 pdLR0">
                <section class="tabs-container">
                    <ul class="nav nav-tabs text-center bBNone">
                        <li class="active col-sm-4 col-sm-offset-4">
                            <a data-toggle="tab" href="#giftCardHomePage" aria-expanded="true" ng-click="giftCardClick()">赠卡管理</a>
                        </li>
                    </ul>
                    <section class="tab-content bgWhite" >
                        <div id="giftCardHomePage" class="tab-pane active">
                            <div class="panel-body ">
                                <div class="row">
                                    <div class="col-sm-12 pdLR0">
                                        <div class="col-sm-offset-3 col-md-offset-3 col-sm-5 col-md-5">
                                            <div class="input-group">
                                                <input type="text" class="form-control" ng-model="keywords" placeholder="请输入赠送名称进行搜索...">
                                                <span class="input-group-btn">
                                                    <button type="button" ng-click="searchGift()" class="btn btn-primary btn-sm">搜索</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-md-4">
                                            <div class="col-sm-6 text-right">
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('giftCard', 'ADDGIFT')) { ?>
                                                <button type="button" class="btn btn-success btn-sm" ng-click="addGiftButton()">新增赠送</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 pdLR0" style="display: flex;flex-wrap: wrap;">
                                        <div class="pdR10 mT10" style="width: 286px;">
                                            <div class="input-daterange input-group cp col-sm-4">
                                                <span class="add-on input-group-addon">
                                                选择日期
                                                </span>
                                                <input type="text" readonly  name="reservation"  id="giftDate" class="form-control text-center  " style="width: 195px;" placeholder="请选择日期"/>
                                            </div>
                                        </div>
                                        <div class="pdR10 mT10 mR10" style="width: 200px;">
                                            <select class="form-control selectPd venueSelect" style="width: 100%;" ng-model="venue">
                                                <option value="">请选择场馆</option>
                                                <option value="{{venues.id}}" ng-repeat="venues in allVenueLists">{{venues.name}}</option>
                                            </select>
                                        </div>
                                        <div class=" mT10 mR10">
                                            <button class="btn btn-info btn-sm " ng-click="clearSearch()">清空</button>
                                        </div>
                                        <div class=" mT10">
                                            <button class="btn btn-success btn-sm " ng-click="searchDateVenue()">确定</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mT20">
                                    <div class="col-sm-12 pdLR0">
                                        <div class="ibox float-e-margins">
                                            <div class="ibox-content" style="padding: 0">
                                                <div style="padding-bottom: 0;" id="DataTables_Table_0_wrapper"
                                                     class="dataTables_wrapper form-inline" role="grid">
                                                    <table
                                                        class="table table-striped table-bordered table-hover"
                                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                        <thead>
                                                            <tr role="row">
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">序号</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">场馆</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">赠送名称</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">开卡数量</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">生成日期</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">有效期限</th>
                                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">备注</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="cp" ng-repeat="giftCards in giftCardLists">
                                                                <td ng-click="giftDetailClick(giftCards.id, giftCards.venue_id)">{{$index + 1}}</td>
                                                                <td ng-click="giftDetailClick(giftCards.id, giftCards.venue_id)">{{giftCards.venueName | noData:''}}</td>
                                                                <td ng-click="giftDetailClick(giftCards.id, giftCards.venue_id)">{{giftCards.active_name | noData:''}}</td>
                                                                <td ng-click="giftDetailClick(giftCards.id, giftCards.venue_id)">{{giftCards.active_card_num | noData:''}} / {{giftCards.gift_card_num | noData:''}}</td>
                                                                <td ng-click="giftDetailClick(giftCards.id, giftCards.venue_id)">{{giftCards.create_time*1000 | date:'yyyy-MM-dd'}}</td>
                                                                <td ng-click="giftDetailClick(giftCards.id, giftCards.venue_id)">{{giftCards.start_time*1000 | date:'yyyy-MM-dd'}} 到 {{giftCards.end_time*1000 | date:'yyyy-MM-dd'}}</td>
                                                                <td ng-click="giftDetailClick(giftCards.id, giftCards.venue_id)">{{giftCards.note | noData:''}}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <?= $this->render('@app/views/common/nodata.php', ['name'=>'noGiftCardShow']); ?>
                                                    <?= $this->render('@app/views/common/pagination.php', ['page' => 'giftCardPages']); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </section>
            </div>
        </div>
    </div>
    <!--新增赠送-->
    <div class="modal fade" id="addGiftModal" style="overflow: auto;" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="width: 720px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">新增赠送</h4>
                </div>
                <div class="modal-body">
                    <div class="row contentCenter">
                        <ul class="col-sm-11 col-sm-offset-1  col-xs-12 mTB20"  >
                            <li class="col-sm-12 heightCenter mT20">
                                <div  class="col-sm-3  col-xs-3  text-right"><span class="red">*</span>选择场馆</div>
                                <div  class="col-sm-5 col-xs-5 ">
                                    <select class="form-control selectPd venueSelect" style="width: 100%;" ng-model="addNewGiftVenue">
                                        <option value="">请选择场馆</option>
                                        <option value="{{venues.id}}" ng-repeat="venues in allVenueLists">{{venues.name}}</option>
                                    </select>
                                </div>
                            </li>
                            <li class="col-sm-12 heightCenter mT20">
                                <div  class="col-sm-3  col-xs-3  text-right"><span class="red">*</span>赠送名称</div>
                                <div  class="col-sm-5 col-xs-5 ">
                                    <input type="text" class="form-control" ng-model="addGiftName"  placeholder="请输入赠送名称">
                                </div>
                            </li>
                            <li class="col-sm-12 heightCenter mT20">
                                <div  class="col-sm-3  col-xs-3  text-right"><span class="red">*</span>有效期限</div>
                                <div  class="col-sm-5 col-xs-5 ">
                                    <input type="text" readonly  name="giftCardEffective" id="addGiftTime" class="form-control text-center" placeholder="请选择有效期限"/>
                                </div>
                            </li>
                            <li class="col-sm-12  mT20">
                                <div  class="col-sm-3  col-xs-3  text-right">备注</div>
                                <div  class="col-sm-5 col-xs-5 ">
                                    <textarea name="" id="" rows="6" style="width: 100%;resize: vertical;" ng-model="addGiftNote"></textarea>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer bTNone " style="display: flex;justify-content: center;">
                    <button type="button" class="btn btn-success w100" ladda="CompleteAddGiftFlag" ng-click="addGift()">完成</button>
                </div>
            </div>
        </div>
    </div>

    <!--赠卡详情-->
    <div class="modal fade bs-example-modal-lg" style="overflow: auto;" id="giftDetailModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document" style="width: 1200px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">赠卡详情</h4>
                </div>
                <div class="modal-body" style="padding-bottom: 0;">
                    <div class="row">
                        <section class="col-sm-12 col-lg-12" style="margin-bottom: 10px;">
                            <div class="col-sm-6 col-sm-offset-3">
                                <div class="input-group">
                                    <input type="text" class="form-control userHeaders" ng-model="cardDetailKeywords" placeholder=" 请输入识别码、卡号、手机号或会员姓名进行搜索...">
                                    <span class="input-group-btn">
                                        <button type="button" ng-click="cardDetailSearch(cardDetailKeywords)" class="btn btn-primary btn-sm">搜索</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-3 text-right">
                                <div>
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('giftCard', 'ADDCARD')) { ?>
                                    <button class="btn btn-success btn-sm" ng-click="giftCardDetailAddCard()">添加会员卡</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </section>
                        <section class="col-sm-12 col-lg-12">
                            <div class="wB100 " style="display: flex;flex-wrap: wrap;">
                                <div class="pdR10 " style="width: 286px;">
                                    <div class="input-daterange input-group cp  col-sm-4" >
                                        <span class="add-on input-group-addon">
                                        选择日期
                                        </span>
                                        <input type="text" readonly name="reservation" class="form-control text-center giftDetailDate" placeholder="选择日期" style="width: 195px;"/>
                                    </div>
                                </div>
                                <div class="mR10">
                                    <select style="width: 160px;" class="form-control selectPd cp" ng-model="giftCardType">
                                        <option value="">卡类型选择</option>
                                        <option ng-repeat="cardTypes in cardTypeLists" value="{{cardTypes.id}}">{{cardTypes.type_name}}</option>
                                    </select>
                                </div>
                                <div class="mR10">
                                    <button class="btn btn-info btn-sm" ng-click="giftCardDetailClear()">清空</button>
                                </div>
                                <div class="mR10">
                                    <button class="btn btn-success btn-sm" ng-click="giftCardDetailSearch(cardDetailKeywords)">确定</button>
                                </div>
                            </div>
                            <div class="wB100 mT20">
                                <div class="col-sm-12 pdLR0">
                                    <div class="ibox float-e-margins" style="margin-bottom: 0;">
                                        <div class="ibox-content" style="padding: 0">
                                            <div style="padding-bottom: 0;" class="form-inline" role="grid">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1">序号</th>
                                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1">卡类型</th>
                                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1">卡名称</th>
                                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1">卡号</th>
                                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1">识别码</th>
                                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1">会员</th>
                                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1">手机号</th>
                                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1">开卡日期</th>
                                                            <th class="sorting" tabindex="0" rowspan="1" colspan="1">到期日期</th>
                                                            <th width="150px" class="sorting" tabindex="0" rowspan="1" colspan="1">操作</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="details in getGiftDetailLists">
                                                            <td>{{8*(nowPage-1)+$index+1}}</td>
                                                            <td>{{details.type_name | noData:''}}</td>
                                                            <td>{{details.card_name | noData:''}}</td>
                                                            <td>{{details.card_number | noData:''}}</td>
                                                            <td>{{details.ID_code | noData:''}}</td>
                                                            <td>{{details.nickname | noData:''}}</td>
                                                            <td>{{details.mobile | noData:''}}</td>
                                                            <td>{{details.active_card_time*1000 | noData:'' | date:'yyyy-MM-dd'}}</td>
                                                            <td>{{details.expire_card_time*1000 | noData:'' | date:'yyyy-MM-dd'}}</td>
                                                            <td>
                                                                <?php if (\backend\models\AuthRole::canRoleByAuth('giftCard', 'MEMBERINFO')) { ?>
                                                                <button class="btn btn-default btn-sm" ng-if="details.is_bind == '2'" ng-click="getMemberDetail(details.member_id, details.card_number)">会员详情</button>
                                                                <?php } ?>
                                                                <!--<button class="btn btn-default btn-sm" ng-click="getMemberDetail(details.member_id, details.card_number)">会员详情</button>-->
                                                                <?php if (\backend\models\AuthRole::canRoleByAuth('giftCard', 'BINDMEMBER')) { ?>
                                                                <button class="btn btn-success btn-sm" ng-if="details.is_bind == '1'" ng-click="getMemberBind(details.id)">绑定会员</button>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <?= $this->render('@app/views/common/nodata.php', ['name'=>'noGiftDetailShow']); ?>
                                                <?= $this->render('@app/views/common/pagination.php', ['page' => 'giftDetailPages']); ?>
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
    <!--添加会员卡-->
    <div class="modal fade" id="addMemberCardModal" style="overflow: auto;" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="width: 720px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">添加会员卡</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <ul class="col-sm-11 col-sm-offset-1 col-xs-12">
                            <li class="col-sm-12 heightCenter mT20">
                                <div class="col-sm-3 col-xs-3 text-right"><span class="red">*</span>卡种</div>
                                <div class="col-sm-5 col-xs-5">
                                    <select class="form-control giftCardList" style="width: 100%;padding: 6px 12px;" ng-change="chooseCardSelectChange(addCardType)" ng-model="addCardType">
                                        <option value="">请选择卡种</option>
                                        <option ng-repeat="allCard in allCardLists" value="{{allCard.id}}">{{allCard.card_name}}</option>
                                    </select>
                                </div>
                            </li>
                            <li class="col-sm-12 heightCenter mT20">
                                <div class="col-sm-3 col-xs-3 text-right"><span class="red">*</span>数量</div>
                                <div class="col-sm-5 col-xs-5 ">
                                     <input type="text" class="form-control" ng-model="addCardGoodNum" placeholder="请输入数量">
                                </div>
                            </li>
<!--                            更柜管理暂时不做，代码先注释 -->
<!--                            <li class="col-sm-12 heightCenter mT20">-->
<!--                                <div  class="col-sm-3  col-xs-3  text-right">更柜赠送</div>-->
<!--                                <div  class="col-sm-5 col-xs-5 ">-->
<!--                                    <select class=" form-control selectPd" ng-model="addCardCabinetType">-->
<!--                                        <option value="">请选择更柜类型</option>-->
<!--                                        <option value="1">男小柜</option>-->
<!--                                        <option value="2">男中柜</option>-->
<!--                                        <option value="3">男大柜</option>-->
<!--                                        <option value="4">女小柜</option>-->
<!--                                        <option value="5">女中柜</option>-->
<!--                                        <option value="6">女大柜</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                            </li>-->
<!--                            <li class="col-sm-12 heightCenter mT20">-->
<!--                                <div  class="col-sm-3  col-xs-3  text-right"><span class="red"></span>更柜有效期</div>-->
<!--                                <div  class="col-sm-5 col-xs-5 ">-->
<!--                                    <input type="text" readonly  name="moreCabinetDate" id="cabinetDate" class="form-control text-center"/>-->
<!--                                </div>-->
<!--                            </li>-->
                        </ul>
                    </div>
                </div>
                <div class="modal-footer" style="display: flex;justify-content: center;">
                    <button type="button" class="btn btn-success w100" ladda="CompleteAddMemberCardFlag" ng-click="addMemberCard()">完成</button>
                </div>
            </div>
        </div>
    </div>
    <!--绑定会员-->
    <div class="modal fade" id="BoundMemberModal" style="overflow: auto;" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="width: 720px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">绑定会员</h4>
                </div>
                <div class="modal-body">
                    <div class="row contentCenter">
                        <ul class="col-sm-11 col-sm-offset-1 col-xs-12">
<!--                            <li class="col-sm-12 heightCenter mT20">-->
<!--                                <div class="col-sm-3 col-xs-3 text-right"><span class="red">*</span>识别码</div>-->
<!--                                <div class="col-sm-6 col-xs-6">-->
<!--                                    <input type="text" class="form-control" ng-model="memberBindCode" placeholder="请输入识别码">-->
<!--                                </div>-->
<!--                            </li>-->
                            <li class="col-sm-12 heightCenter mT20">
                                <div class="col-sm-3 col-xs-3 text-right"><span class="red">*</span>姓名</div>
                                <div class="col-sm-6 col-xs-6">
                                    <input type="text" class="form-control" ng-model="memberBindName" placeholder="请输入姓名">
                                </div>
                            </li>
                            <li class="col-sm-12 heightCenter mT20">
                                <div class="col-sm-3 col-xs-3 text-right">身份证号</div>
                                <div class="col-sm-6 col-xs-6">
                                    <input type="text" class="form-control" ng-model="memberBindIdCard" placeholder="请输入18位身份证号">
                                </div>
                            </li>
                            <li class="col-sm-12 heightCenter mT20">
                                <div class="col-sm-3 col-xs-3 text-right">身份证住址</div>
                                <div class="col-sm-6 col-xs-6">
                                    <input type="text" class="form-control" ng-model="memberBindIdAddress" placeholder="请输入身份证住址">
                                </div>
                            </li>
                            <li class="col-sm-12 heightCenter mT20">
                                <div class="col-sm-3 col-xs-3 text-right">现居地</div>
                                <div class="col-sm-6 col-xs-6">
                                    <input type="text" class="form-control" ng-model="memberBindNowAddress" placeholder="请输入现居地">
                                </div>
                            </li>
                            <li class="col-sm-12 heightCenter mT20">
                                <div class="col-sm-3 col-xs-3 text-right"><span class="red">*</span>手机号</div>
                                <div class="col-sm-6 col-xs-6">
                                    <div class="col-sm-12 col-xs-12 pdLR0" style="border: solid 1px #cfdadd;border-radius:3px;display: flex;">
                                        <div class="col-xs-8 pdLR0">
                                            <input type="text" class="form-control borderNone" ng-model="memberBindPhone" placeholder="请输入手机号">
                                        </div>
                                        <div  class="col-xs-4 pdLR0 heightCenter" style="border-left: solid 1px #cfdadd;">
                                            <button class="borderNone"
                                                    style="background-color: transparent;width: 100%;height: 100%;"
                                                    type="button" ng-click="getCode()" ng-bind="codeText" ng-disabled="disabledFlag">验证码</button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="col-sm-12 heightCenter mT20">
                                <div  class="col-sm-3 col-xs-3 text-right"><span class="red">*</span>验证码</div>
                                <div  class="col-sm-6 col-xs-6">
                                    <input type="text" class="form-control" ng-model="memberBindCheckCode" placeholder="请输入验证码">
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer" style="display: flex;justify-content: center;">
                    <button type="button" class="btn btn-success w100" ladda="CompleteBoundMemberFlag" ng-click="memberBindCard()">完成</button>
                </div>
            </div>
        </div>
    </div>

    <!--  会员详情  -->
    <div class="modal fade" id="memberDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">会员详情</h4>
                </div>
                <div class="modal-body" style="padding: 30px 150px;">
                    <p class="M20"><span>会员编号：&emsp;</span><span>&emsp;&emsp;{{MemberData.id | noData:''}}</span></p>
                    <p class="M20"><span>会员姓名：&emsp;</span><span>&emsp;&emsp;{{MemberData.name | noData:''}}</span></p>
                    <p class="M20"><span>卡号：&emsp;</span><span>&emsp;&emsp;{{memberDetailCardNumber | noData:''}}</span></p>
                    <p class="M20"><span>会员性别：&emsp;</span>
                        <span ng-if="MemberData.sex == 1">&emsp;&emsp;男</span>
                        <span ng-if="MemberData.sex == 2">&emsp;&emsp;女</span>
                        <span ng-if="MemberData.sex != 1 && MemberData.sex != 2">&emsp;&emsp;暂无数据</span>
                    </p>
                    <p class="M20"><span>手机号码：&emsp;</span><span>&emsp;&emsp;{{MemberData.mobile | noData:''}}</span></p>
                    <p class="M20"><span>出生日期：&emsp;</span><span ng-if="MemberData.birth_date != null || MemberData.birth_date != undefined">&emsp;&emsp;{{MemberData.birth_date}}</span><span ng-if="MemberData.birth_date == null && MemberData.birth_date == undefined">&emsp;&emsp;暂无数据</span></p>
                    <p class="M20"><span>证件类型：&emsp;</span>
                        <span ng-if="MemberData.document_type == null">&emsp;&emsp;暂无数据</span>
                        <span ng-if="MemberData.document_type == '1'">&emsp;&emsp;身份证</span>
                        <span ng-if="MemberData.document_type == '2'">&emsp;&emsp;居住证</span>
                        <span ng-if="MemberData.document_type == '3'">&emsp;&emsp;签证</span>
                        <span ng-if="MemberData.document_type == '4'">&emsp;&emsp;护照</span>
                        <span ng-if="MemberData.document_type == '5'">&emsp;&emsp;户口本</span>
                        <span ng-if="MemberData.document_type == '6'">&emsp;&emsp;军人证</span>
                    </p>
                    <p class="M20"><span>证件号码：&emsp;</span><span>&emsp;&emsp;{{MemberData.id_card | noData:''}}</span></p>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-success" data-dismiss="modal" style="padding: 5px 30px;">确定</button>
                </div>
            </div>
        </div>
    </div>
</main>