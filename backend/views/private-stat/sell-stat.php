<?php
use backend\assets\PrivateStatAsset;
PrivateStatAsset::register($this);
$this->title = '私教统计-销售';
/**
 * 私教管理 - 私教统计 - 销售
 * @author zhujunzhe@itsports.club
 * @create 2018/6/9 am
 */
?>
<div class="sellStatContent" ng-controller="sellStatCtrl" ng-cloak>
    <div class="row mr0 mb10">
        <ul class="col-md-12 pd0 topUl">
            <li>
                <a href="/private-stat/index">客户统计</a>
            </li>
            <li class="topLiActive">
                <a href="/private-stat/sell-stat">销售统计</a>
            </li>
            <li>
                <a href="/private-stat/class-stat">上课统计</a>
            </li>
        </ul>
    </div>
    <div class="row mr0 mb10">
        <div class="col-md-12 pd0 mb10">
            <select class="form-control w200 pd4 sellSelect" id="venueSelect" ng-model="venueId" ng-change="venueChange(venueId)">
                <option value="{{v.id}}" ng-repeat="v in venueList">{{v.name}}</option>
            </select>
        </div>
        <?=$this->render('@app/views/private-stat/today.php');?>
    </div>
    <div class="row mr0 mb10">
        <div class="col-md-12 pd0 mb10">
            <select class="form-control w200 pd4 fl mr10 sellSelect" id="dateType" ng-model="dateType" ng-change="dateTypeChange(dateType)">
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
    <div class="row  mb10 mr0">
        <div class="col-lg-2 col-md-3 col-sm-4 mb10 pL0" ng-click="sellClick(1)">
            <div class="col-md-5 pd0 topBox box1">
                <p>
                    <img class="boxImg" src="/plugins/privateStat/img/stat-1.png">
                </p>
                <p class="white">成交额</p>
            </div>
            <div class="col-md-7 pd0 boxRight">
                <span  class="num1" ng-if="topTotalMoney != null">{{topTotalMoney}}</span>
                <span  class="num1" ng-if="topTotalMoney == null">0</span>元
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 mb10 pL0" ng-click="sellClick(2)">
            <div class="col-md-5 pd0 topBox box2">
                <p>
                    <img class="boxImg" src="/plugins/privateStat/img/stat-2.png">
                </p>
                <p class="white">成交量</p>
            </div>
            <div class="col-md-7 pd0 boxRight">
                <span class="num2" ng-if="topTotalClass != null">{{topTotalClass}}</span>
                <span class="num2" ng-if="topTotalClass == null">0</span>节
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 mb10 pL0" ng-click="sellClick(3)">
            <div class="col-md-5 pd0 topBox box3">
                <p>
                    <img class="boxImg" src="/plugins/privateStat/img/stat-9.png">
                </p>
                <p class="white">体验课成交率</p>
            </div>
            <div class="col-md-7 pd0 boxRight">
                <span class="num3">{{dealRate}}</span>%
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 mb10 pL0" ng-click="sellClick(4)">
            <div class="col-md-5 pd0 topBox box4">
                <p>
                    <img class="boxImg" src="/plugins/privateStat/img/stat-5.png">
                </p>
                <p class="white">平均成交价</p>
            </div>
            <div class="col-md-7 pd0 boxRight">
                <span class="num4">{{fourBox}}</span>元
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 mb10 pL0" ng-click="sellClick(5)">
            <div class="col-md-5 pd0 topBox box5">
                <p>
                    <img class="boxImg" src="/plugins/privateStat/img/stat-6.png">
                </p>
                <p class="white">平均客单价</p>
            </div>
            <div class="col-md-7 pd0  boxRight">
                <span class="num5">{{fiveBox}}</span>元
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading text-center">成交趋势</div>
        <div class="panel-body">
            <div class="row">
                <select class="form-control pd4 sellSelect w150 mLR15 fl" id="latelySelect" ng-model="latelySelect" ng-change="latelySelectChange(latelySelect)">
                    <option value="1">最近30天</option>
                    <option value="2">最近1年</option>
                </select>
                <select class="form-control pd4 sellSelect w150  fl" id="latelyNum" ng-model="latelyNum" ng-change="latelyNumChange(latelyNum)">
                    <option value="1">成交额</option>
                    <option value="2">成交量</option>
                    <option value="3">购买人数</option>
                </select>
            </div>
            <div id="statChart1" style="height: 400px">

            </div>
        </div>
    </div>
    <!--<div class="row mr0 col-lg-6 pL0">
        <div class="panel panel-default ">
            <div class="panel-heading text-center">销售漏斗</div>
            <div class="panel-body">
                <div class="row">
                    <select class="form-control pd4 sellSelect w150 fl mLR15" id="sellSelect" ng-model="sellSelect" ng-change="sellSelectChange(sellSelect)">
                        <option value="1">今日</option>
                        <option value="2">本月</option>
                        <option value="3">本年度</option>
                    </select>
                </div>
                <div id="statChart2" style="height: 400px">

                </div>
            </div>
        </div>
    </div>-->
    <div class="row mr0 col-lg-6 pL0">
        <div class="panel panel-default ">
            <div class="panel-heading text-center">成交客户分析</div>
            <div class="panel-body">
                <div class="row">
                    <select class="form-control pd4 sellSelect w180 fl mLR15" id="percentSelect" ng-model="percentSelect" ng-change="percentSelectChange(percentSelect)">
                        <option value="1">新老客户占比</option>
                        <option value="2">办卡当日成交占比</option>
                    </select>
                    <select class="form-control pd4 sellSelect w150 fl" id="turnoverSelect" ng-model="turnoverSelect" ng-change="turnoverSelectChange(turnoverSelect)">
                        <option value="1">成交额</option>
                        <option value="2">成交量</option>
                        <option value="3">购买人数</option>
                    </select>
                </div>
                <div id="statChart3" style="height: 400px">

                </div>
            </div>
        </div>
    </div>
    <div class="row mr0 col-lg-6 pL0">
        <div class="panel panel-default ">
            <div class="panel-heading text-center">课程分析</div>
            <div class="panel-body">
                <div class="row">
                    <select class="form-control pd4 sellSelect w150 fl mLR15" id="analyzeSelect" ng-model="analyzeSelect" ng-change="analyzeSelectChange(analyzeSelect)">
                        <option value="3">今日</option>
                        <option value="1">本月</option>
                        <option value="2">本年度</option>
                    </select>
                    <select class="form-control pd4 sellSelect w150 fl" id="analyzeNum" ng-model="analyzeNum" ng-change="analyzeNumChange(analyzeNum)">
                        <option value="1">成交额</option>
                        <option value="2">成交量</option>
                        <option value="3">购买人数</option>
                    </select>
                </div>
                <div id="statChart4" style="height: 400px">

                </div>
            </div>
        </div>
    </div>
    <div class="row mr0 col-lg-6 pL0">
        <div class="panel panel-default ">
            <div class="panel-heading text-center">课程对比</div>
            <div class="panel-body">
                <div class="row">
                    <select class="form-control pd4 sellSelect w150 fl mLR15" id="contrastTime" ng-model="contrastTime" ng-change="contrastTimeChange(contrastTime)">
                        <option value="3">今日</option>
                        <option value="1">本月</option>
                        <option value="2">本年度</option>
                    </select>
                    <select class="form-control pd4 sellSelect w150 fl" id="contrastSelect" ng-model="contrastSelect" ng-change="contrastSelectChange(contrastSelect)">
                        <option value="1">平均成交价</option>
                        <option value="2">平均客单价</option>
                        <!--<option value="3">续约率</option>
                        <option value="4">流失率</option>-->
                    </select>
                </div>
                <div id="statChart5" style="height: 400px">

                </div>
            </div>
        </div>
    </div>
    <!--<div class="row mr0 col-lg-6 pL0">
        <div class="panel panel-default ">
            <div class="panel-heading text-center">部门业绩分析</div>
            <div class="panel-body">
                <div class="row">
                    <select class="form-control pd4 sellSelect w150 fl mLR15" id="goalSelect" ng-model="goalSelect" ng-change="goalSelectChange(goalSelect)">
                        <option value="1">月目标</option>
                        <option value="2">季度目标</option>
                        <option value="3">年度目标</option>
                    </select>
                </div>
                <div id="statChart6" style="height: 400px">

                </div>
            </div>
        </div>
    </div>-->
    <div class="row mr0 col-lg-6 pL0">
        <div class="panel panel-default">
            <div class="panel-heading row mr0">
                <span class="col-md-6 lh30">私教客户量排行榜</span>
                <span class="col-md-3">
                    <select class="form-control pd4 sellSelect" id="orderSelect" ng-model="orderSelect" ng-change="orderSelectChange(orderSelect)">
                        <option value="1">新单</option>
                        <option value="2">续费</option>
                    </select>
                </span>
                <span class="col-md-3">
                    <select class="form-control pd4 sellSelect" id="rankSelect" ng-model="rankSelect" ng-change="rankSelectChange(rankSelect)">
                        <option value="1">日排行</option>
                        <option value="2">周排行</option>
                        <option value="3">月排行</option>
                    </select>
                </span>
            </div>
            <div class="panel-body">
                <ul class="sellList">
                    <li class="">
                        <h4>教练姓名</h4>
                        <!--<h4>业绩</h4>
                        <h4>完成率</h4>-->
                        <h4>销售额</h4>
                    </li>
                    <li class="lh30" ng-repeat="($index,r) in rankList">
                        <span class="">
                            <b class="iImg img1" ng-if="$index == 0"></b>
                            <b class="iImg img2" ng-if="$index == 1"></b>
                            <b class="iImg img3" ng-if="$index == 2"></b>
                            <b class="iB red" ng-if="$index != 0 && $index != 1 && $index != 2">{{$index + 1}}</b>
                            <a href="" class="fl green" ng-if="$index == 0">{{r.name}}</a>
                            <a href="" class="fl green" ng-if="$index == 1">{{r.name}}</a>
                            <a href="" class="fl green" ng-if="$index == 2">{{r.name}}</a>
                            <a href="" class="fl red" ng-if="$index != 0 && $index != 1 && $index != 2">{{r.name}}</a>
                        </span>
                        <!--<span>1200万</span>
                        <span>120%</span>-->
                        <span class="green" ng-if="$index == 0">{{r.money}}元</span>
                        <span class="green" ng-if="$index == 1">{{r.money}}元</span>
                        <span class="green" ng-if="$index == 2">{{r.money}}元</span>
                        <span class="red" ng-if="$index != 0 && $index != 1 && $index != 2">{{r.money}}元</span>
                    </li>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'sellNoData','text'=>'暂无数据','href'=>true]);?>
                </ul>

            </div>
        </div>
    </div>
    <!--详情模态框-->
    <?=$this->render('@app/views/private-stat/sellModal.php');?>
    <!--会员信息模态框-->
    <?= $this->render('@app/views/publicMemberInfo/publicMemberInfo.php'); ?>
</div>
