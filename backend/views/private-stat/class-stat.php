<?php
use backend\assets\PrivateStatAsset;
PrivateStatAsset::register($this);
$this->title = '私教统计-上课';
/**
 * 私教管理 - 私教统计 - 上课
 * @author zhujunzhe@itsports.club
 * @create 2018/6/9 am
 */
?>
<div class="classStatContent" ng-controller="classStatCtrl" ng-cloak>
    <div class="row mr0 mb10">
        <ul class="col-md-12 pd0 topUl">
            <li>
                <a href="/private-stat/index">客户统计</a>
            </li>
            <li>
                <a href="/private-stat/sell-stat">销售统计</a>
            </li>
            <li class="topLiActive">
                <a href="/private-stat/class-stat">上课统计</a>
            </li>
        </ul>
    </div>
    <div class="row mr0 mb10">
        <div class="col-md-12 pd0 mb10">
            <select class="form-control w200 pd4 classSelect" id="venueSelect" ng-model="venueId" ng-change="venueChange(venueId)">
                <option value="{{v.id}}" ng-repeat="v in venueList">{{v.name}}</option>
            </select>
        </div>
        <?=$this->render('@app/views/private-stat/today.php');?>
    </div>
    <div class="row mr0 mb10">
        <div class="col-md-12 pd0 mb10">
            <select class="form-control w200 pd4 fl mr10 classSelect" id="dateType" ng-model="dateType" ng-change="dateTypeChange(dateType)">
                <option value="1">今日</option>
                <option value="2">本周</option>
                <option value="3">本月</option>
                <option value="4">自定义日期</option>
            </select>
            <div class="fl" style="width: 320px;" ng-show="dateType == 4">
                <div class="input-daterange input-group cp">
                    <span class="add-on input-group-addon">选择日期</span>
                    <input type="text" readonly  id="freeDate" class="form-control text-center" style="width: 100%;">
                </div>
            </div>
            <button class="btn btn-info fl pd4 " ng-show="dateType == 4" ng-click="lookBtn()">查看</button>
        </div>
    </div>
    <div class="row mr0 mb10">
        <div class="col-lg-2 col-md-3 col-sm-4 mb10 pL0" ng-click="classClick(1)">
            <div class="col-md-5 pd0 topBox box1">
                <p>
                    <img class="boxImg" src="/plugins/privateStat/img/stat-10.png">
                </p>
                <p class="white">体验课上课量</p>
            </div>
            <div class="col-md-7 pd0 boxRight">
                <span class="num1">{{firstBoxNum}}</span>节
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 mb10 pL0" ng-click="classClick(2)">
            <div class="col-md-5 pd0 topBox box2">
                <p>
                    <img class="boxImg" src="/plugins/privateStat/img/stat-10.png">
                </p>
                <p class="white">付费课上课量</p>
            </div>
            <div class="col-md-7 pd0 boxRight">
                <span class="num2">{{twoBoxNum}}</span>节
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 mb10 pL0" ng-click="classClick(3)">
            <div class="col-md-5 pd0 topBox box3">
                <p>
                    <img class="boxImg" src="/plugins/privateStat/img/stat-7.png">
                </p>
                <p class="white">体验课上课人数</p>
            </div>
            <div class="col-md-7 pd0 boxRight">
                <span class="num3">{{threeBoxNum}}</span>人
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 mb10 pL0" ng-click="classClick(4)">
            <div class="col-md-5 pd0 topBox box4">
                <p>
                    <img class="boxImg" src="/plugins/privateStat/img/stat-7.png">
                </p>
                <p class="white">付费课上课人数</p>
            </div>
            <div class="col-md-7 pd0 boxRight">
                <span class="num4">{{fourBoxNum}}</span>人
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading text-center">上课量</div>
        <div class="panel-body">
            <div class="row">
                <select class="form-control pd4 classSelect w150 mLR15 fl" id="latelySelect" ng-model="latelySelect" ng-change="latelySelectChange(latelySelect)">
                    <option value="1">最近30天</option>
                    <option value="2">最近1年</option>
                </select>
                <select class="form-control pd4 classSelect w150  fl" id="latelyNum" ng-model="latelyNum" ng-change="latelyNumChange(latelyNum)">
                    <option value="21" name="节">体验课节数</option>
                    <option value="11" name="节">付费课节数</option>
                    <option value="22" name="人">体验课人数</option>
                    <option value="12" name="人">付费课人数</option>
                </select>
            </div>

            <div id="statChart1" style="height: 400px">

            </div>
        </div>
    </div>
    <div class="row mr0 col-lg-6 pL0">
        <div class="panel panel-default ">
            <div class="panel-heading text-center">课程分析</div>
            <div class="panel-body">
                <div class="row">
                    <select class="form-control pd4 classSelect w150 fl mLR15" id="timeSelect" ng-model="timeSelect" ng-change="timeSelectChange(timeSelect)">
                        <option value="3">今日</option>
                        <option value="1">本月</option>
                        <option value="2">本年度</option>
                    </select>
                    <select class="form-control pd4 classSelect w150 fl" id="numSelect" ng-model="numSelect" ng-change="numSelectChange(numSelect)">
                        <option value="1">上课节数</option>
                        <option value="2">上课人数</option>
                    </select>
                </div>
                <div id="statChart3" style="height: 400px">

                </div>
            </div>
        </div>
    </div>
    <div class="row mr0 col-lg-6 pL0">
        <div class="panel panel-default ">
            <div class="panel-heading text-center">预约途径</div>
            <div class="panel-body">
                <div class="row">
                    <select class="form-control pd4 classSelect w150 fl mLR15" id="waySelect" ng-model="waySelect" ng-change="waySelectChange(waySelect)">
                        <option value="3" name="今日">今日</option>
                        <option value="1" name="本月">本月</option>
                        <option value="2" name="本年度">本年度</option>
                    </select>
                </div>
                <div id="statChart4" style="height: 400px">

                </div>
            </div>
        </div>
    </div>
    <div class="row mr0 col-lg-6 pL0">
        <div class="panel panel-default">
            <div class="panel-heading row mr0">
                <span class="col-md-6 lh30">私教上课量排行榜</span>
                <span class="col-md-3">
                    <select class="form-control pd4 classSelect" id="rankSelect" ng-model="rankSelect" ng-change="rankSelectChange1(rankSelect)">
                        <option value="1">日排行</option>
                        <option value="2">周排行</option>
                        <option value="3">月排行</option>
                    </select>
                </span>
                <span class="col-md-3">
                    <select class="form-control pd4 classSelect" id="classTypeSelect" ng-model="classTypeSelect" ng-change="classTypeChange(classTypeSelect)">
                        <option value="1">付费课</option>
                        <option value="2">体验课</option>
                    </select>
                </span>
            </div>
            <div class="panel-body">
                <ul class="privateList">
                    <li class="">
                        <h4>教练姓名</h4>
                        <!--<h4>完成率</h4>-->
                        <h4>上课量</h4>
                    </li>
                    <li class="lh30" ng-repeat="($index,c) in rankList">
                        <span class="">
                            <b class="iImg img1" ng-if="$index == 0"></b>
                            <b class="iImg img2" ng-if="$index == 1"></b>
                            <b class="iImg img3" ng-if="$index == 2"></b>
                            <b class="iB red" ng-if="$index != 0 && $index != 1 && $index != 2">{{$index + 1}}</b>
                            <a href="" class="fl green" ng-if="$index == 0">{{c.p_name}}</a>
                            <a href="" class="fl green" ng-if="$index == 1">{{c.p_name}}</a>
                            <a href="" class="fl green" ng-if="$index == 2">{{c.p_name}}</a>
                            <a href="" class="fl red" ng-if="$index != 0 && $index != 1 && $index != 2">{{c.p_name}}</a>
                        </span>
                        <!--<span>120%</span>-->
                        <span class="green" ng-if="$index == 0">{{c.num}}节</span>
                        <span class="green" ng-if="$index == 1">{{c.num}}节</span>
                        <span class="green" ng-if="$index == 2">{{c.num}}节</span>
                        <span class="red" ng-if="$index != 0 && $index != 1 && $index != 2">{{c.num}}节</span>
                    </li>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'classRankNoData','text'=>'暂无数据','href'=>true]);?>
                </ul>
            </div>
        </div>
    </div>
    <!--详情模态框-->
    <?=$this->render('@app/views/private-stat/classModal.php');?>
    <!--会员信息模态框-->
    <?= $this->render('@app/views/publicMemberInfo/publicMemberInfo.php'); ?>
</div>
