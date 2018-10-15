<?php
use backend\assets\FieldAsset;

FieldAsset::register($this);
$this->title = '场地预约';
?>
<div ng-controller="FieldCtrl" class="group" ng-cloak>
    <div class="row">
<!--        <div class="col-sm-1 col-xs-1 panel panel-default pd0" style="height: 100%">-->
<!--            <div class="panel-body pd0">-->
<!--                <ul class="group-ul">-->
<!--                    <li class="orderMenu"><a href="/correcting/index">进馆验卡</a></li>-->
<!--                    <li><a href="/wcabinet/index">更衣柜管理</a></li>-->
<!--                    <li>场地管理</li>-->
<!--                    <li>请假记录</li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
        <div class="col-sm-12 col-xs-12 panel panel-default" style="margin-bottom: 0">
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li style="padding-left: 0;" role="presentation" class="active"><a href="/wcheck-card/index#home">进馆验卡</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile">会员详情</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile1">会员卡</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile2">私教</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile3">团教</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile4">场地</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile5">更衣柜</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile6">信息记录</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile7">请假</a></li>
                    <li role="presentation"><a href="/wcheck-card/index#profile8">消费</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 content-center panel panel-default pd0" style="height: 100%;">
            <div class="panel-body">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="row">
                            <div class="col-sm-12" style="padding: 0 0 10px 10px;color: #676a6cd6">< 进馆验卡 < 预约场地</div>
                            <div class="col-sm-12 pd0" style="border-bottom: 1px solid #dddddd;">
                                <div class="col-sm-2 pd0 switchCabinetArea" >
                                    <input type="text" class="form-control" id="venueDateStartInput"
                                           data-date-format="yyyy-mm-dd" placeholder="请选择日期" style="padding: 24px;">
                                    <ul class="checkUl" id="contain" style="overflow-y: auto;border-right: 1px solid #dddddd;border-bottom: 1px solid #dddddd"">
                                        <li class="SiteManagement cp" style="padding-left: 15px;border-bottom: solid 1px #E5E5E5;" ng-repeat="(index, item) in listDataItems" ng-click="selectSiteManagement(item.id,index,item)">
                                            <div style="margin: 10px 0">
                                                <h3 ng-class="{blue: (item.choose),disAbled: time.status}">{{item.yard_name}}</h3>
                                                <p style="color: #867f7f; margin: 10px 0;"><span>开放时间:{{item.business_time}}</span></p>
                                                <p style="color: #867f7f;"><span>人数上限:{{item.people_limit}}</span> </p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-3 pd0 switchCabinetAreaCabinetNum" >
                                    <div class="ibox float-e-margins boxShowNone borderNone" style="overflow-y: auto;overflow-x: hidden;margin: 0">
                                        <div class="ibox-content borderNone">
                                            <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
                                            <div class="col-sm-12 borderBottom" style="padding: 15px 0;">
                                                <div class="col-sm-6 textAlignCenter"><strong>时间段</strong></div>
                                                <div class="col-sm-6 textAlignCenter "><strong>预约人数</strong></div>
                                            </div>
                                            <div class="col-sm-12 qq">
                                              <div class="row">
                                                  <div class="col-sm-12 borderBottom ths cursorPointer" style="padding: 10px 0;" ng-class="{selTime:value.isClick}" ng-repeat="(key,value) in siteDetailsLeft.orderNumList" ng-click="siteManagementDetails(key,value,index)">
                                                      <div class="col-sm-6 textAlignCenter lineHeight30 color254" ng-if="value.timeStatus == 1">{{key}}</div>
                                                      <div class="col-sm-6 textAlignCenter lineHeight30 color254" ng-if="value.timeStatus == 1">{{value.num}}/{{siteDetailsLeft.yardMessage.people_limit}}</div>
                                                      <div class="col-sm-6 textAlignCenter lineHeight30" ng-if="value.timeStatus == 2">{{key}}</div>
                                                      <div class="col-sm-6 textAlignCenter lineHeight30" ng-if="value.timeStatus == 2">{{value.num}}/{{siteDetailsLeft.yardMessage.people_limit}}</div>
                                                  </div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-7 pd0 switchCabinetAreaCabinetNum" >
                                    <div class="ibox float-e-margins boxShowNone borderNone">
                                        <div class="ibox-content borderNone cc">
                                            <table class="table table-bordered">
                                                <tr class="h35px">
                                                    <td>会员姓名</td>
                                                    <td>手机号</td>
                                                    <td>预约时间</td>
                                                    <td>操作</td>
                                                </tr>
                                                <tbody>
                                                <tr ng-repeat="($index,w) in selectionTimeList" class="cursorPointer">
                                                    <td>{{w.username}}</td>
                                                    <td>{{w.mobile}}</td>
                                                    <td>{{w.create_at *1000 |date:'yyyy-MM-dd HH:mm' }}</td>
                                                    <td>
                                                        <button ng-if="isCancel" ng-click="cancelReservation(w,2,w.about_interval_section)" type="button" class="btn-sm btn btn-default">
                                                            取消预约
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'noDetail']); ?>
                                            <?= $this->render('@app/views/common/pagination.php', ['page' => 'detailPages']); ?>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="button" ng-disabled="!disBtn || !yesSel" class="btn btn-sm btn-success" ng-click="siteReservation(aboutIntervalSection,1)" style="padding: 5px 35px;" ng-disabled="aboutTimeStatus == 1">预约</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
