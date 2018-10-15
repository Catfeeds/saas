<?php
use backend\assets\PrivateLessonAsset;

PrivateLessonAsset::register($this);
$this->title = '私教排课';
?>
<div class="col-sm-12" id="PrivateTimetable" ng-cloak >
    <div class="panel panel-default ">
        <div class="panel-heading">
                <span style="display: inline-block"><span style="display: inline-block" class="spanSmall"><b>私教排课</b></span>
        </div>
    </div>
    <div class="panel panel-default ">
        <div class="panel-body col-sm-12 panelBody">
            <div class="tab-tb-1" ng-controller="privateTimetableCtrl" ng-cloak>
                <div class="col-sm-12 panelBodyDiv1">
                    <label for="id_label_single">
                        <select class="js-example-basic-single js-states form-control" ng-change="venueChange(myenue)"
                                ng-model="myValue" id="venueChange">
                            <option value="" ng-selected>请选择场馆</option>
                            <option value="{{venue.id}}" ng-repeat="venue in venuesLists">{{venue.name}}</option>
                        </select>
                    </label>
                </div>
                <div class="col-sm-12 ">
                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 text-center cp" ng-repeat="coach in datas"
                         ng-click="skipDetail(coach.id)">
                        <div class="col-sm-3  col-md-3 col-lg-3 col-xs-4">
                            <img class="panelBodyDiv1Img" ng-if="coach.pic != null && coach.pic != ''"
                                 ng-src="{{coach.pic}}" alt="">
                            <img class="panelBodyDiv1Img" ng-if="coach.pic == null || coach.pic == ''"
                                 ng-src="/plugins/user/images/pt.png" alt="">
                        </div>
                        <div class="col-sm-9 col-md-9 col-lg-9 col-xs-8 text-left contentBoxText"
                             style="margin-top: 24px">
                            <b>{{coach.name}}</b>
                            <div style="min-height: 14px;">
                                <span ng-if="coach.age != null">{{coach.age}}岁</span>
                                <span ng-if="coach.work_date != null">从业时间 {{coach.work_time}} 年</span>
                            </div>
                            <img ng-src="/plugins/evaluate/imgs/u49.png" alt="" class="panelBodyDiv1ImgSamll">
                            <img ng-src="/plugins/evaluate/imgs/u49.png" alt="" class="panelBodyDiv1ImgSamll">
                            <img ng-src="/plugins/evaluate/imgs/u49.png" alt="" class="panelBodyDiv1ImgSamll">
                            <img ng-src="/plugins/evaluate/imgs/u49.png" alt="" class="panelBodyDiv1ImgSamll">
                            <img ng-src="/plugins/evaluate/imgs/u57.png" alt="" class="panelBodyDiv1ImgSamll">
                        </div>
                    </div>
                    <?= $this->render('@app/views/common/nodata.php'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
