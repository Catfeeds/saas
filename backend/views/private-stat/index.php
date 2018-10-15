<?php
use backend\assets\PrivateStatAsset;
PrivateStatAsset::register($this);
$this->title = '私教统计-客户';
/**
 * 私教管理 - 私教统计 - 客户
 * @author zhujunzhe@itsports.club
 * @create 2018/6/9 am
 */
?>
<div class="privateStatContent" ng-controller="clientStatCtrl" ng-cloak>
    <div class="row mr0 mb10">
        <ul class="col-md-12 pd0 topUl">
            <li class="topLiActive">
                <a href="/private-stat/index">客户统计</a>
            </li>
           <!-- <li>
                <a href="/private-stat/sell-stat">销售统计</a>
            </li>
            <li>
                <a href="/private-stat/class-stat">上课统计</a>
            </li>-->
        </ul>
    </div>
    <div class="row mr0 mb10">
        <div class="col-md-12 pd0 mb10">
            <select class="form-control w200 pd4 daySelect" ng-model="venueId" id="venueSelect" ng-change="venueChange(venueId)">
                <option value="{{v.id}}" ng-repeat="v in venueList">{{v.name}}</option>
            </select>
        </div>
        <?=$this->render('@app/views/private-stat/today.php');?>
    </div>

    <div class="row mr0 mb10">
        <div class="col-lg-2 col-md-3 col-sm-4 mb10 pL0" ng-click="boxClick(1)">
            <div class="col-md-5 pd0 topBox box1">
                <p>
                    <img class="boxImg" src="/plugins/privateStat/img/stat-7.png">
                </p>
                <p class="white">客户量</p>
            </div>
            <div class="col-md-7 pd0 boxRight">
                <span class="num1">{{member_num}}</span>人
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 mb10 pL0" ng-click="boxClick(2)">
            <div class="col-md-5 pd0 topBox box2">
                <p>
                    <img class="boxImg" src="/plugins/privateStat/img/stat-12.png">
                </p>
                <p class="white">最近未上课</p>
            </div>
            <div class="col-md-7 pd0 boxRight">
                <span class="num2">{{notClass_num}}</span>人
            </div>
        </div>
        <!--<div class="col-lg-2 col-md-3 col-sm-4 mb10 pL0" ng-click="boxClick(3)">
            <div class="col-md-5 pd0 topBox box3">
                <p>
                    <img class="boxImg" src="/plugins/privateStat/img/stat-11.png">
                </p>
                <p class="white">最近未跟进</p>
            </div>
            <div class="col-md-7 pd0 boxRight">
                <span class="num3">{{notFollow_num}}</span>人
            </div>
        </div>-->
        <div class="col-lg-2 col-md-3 col-sm-4 mb10 pL0" ng-click="boxClick(4)">
            <div class="col-md-5 pd0 topBox box4">
                <p>
                    <img class="boxImg" src="/plugins/privateStat/img/stat-3.png">
                </p>
                <p class="white">即将到期</p>
            </div>
            <div class="col-md-7 pd0 boxRight">
                <span class="num4">{{expire_num}}</span>人
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 mb10 pL0" ng-click="birthClick()">
            <div class="col-md-5 pd0 topBox box5">
                <p>
                    <img class="boxImg" src="/plugins/privateStat/img/stat-8.png">
                </p>
                <p class="white">生日会员</p>
            </div>
            <div class="col-md-7 pd0 boxRight">
                <span class="num5">{{birth_num}}</span>人
            </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 mb10 pL0" ng-click="boxClick(6)">
            <div class="col-md-5 pd0 topBox box6">
                <p>
                    <img class="boxImg" src="/plugins/privateStat/img/stat-10.png">
                </p>
                <p class="white">体验课未执行</p>
            </div>
            <div class="col-md-7 pd0 boxRight">
                <span class="num6">{{notExecuted_num}}</span>人
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading text-center">新增客户数量</div>
        <div class="panel-body">
            <select class="form-control pd4 daySelect w150" id="latelySelect" ng-model="daySelect" ng-change="daySelectChange(daySelect)">
                <option value="1">最近30天</option>
                <option value="2">最近1年</option>
            </select>
            <div id="statChart1" style="height: 400px">

            </div>
        </div>
    </div>
    <div class="row mr0 col-lg-6 pL0">
        <div class="panel panel-default ">
            <div class="panel-heading text-center">客户分析</div>
            <div class="panel-body">
                <div class="row">
                    <select class="form-control pd4 daySelect w150 fl mLR15" id="clientSelect" ng-model="clientSelect" ng-change="clientSelectChange(clientSelect)">
                        <option value="1">正式客户</option>
                        <option value="2">潜在客户</option>
                    </select>
                    <select class="form-control pd4 daySelect w150 fl" id="clientType" ng-model="clientType" ng-change="clientTypeChange(clientType)">
                        <option value="1">性别</option>
                        <!--<option value="2">健身目标</option>
                        <option value="3">私教来源</option>-->
                    </select>
                </div>
                <div id="statChart3" style="height: 400px">

                </div>
            </div>
        </div>
    </div>
    <div class="row mr0 col-lg-6 pR0">
        <div class="panel panel-default">
            <div class="panel-heading row mr0">
                <span class="col-md-8 lh30">私教客户量排行榜</span>
                <!--<span class="col-md-4 text-right">
                    <select class="form-control pd4 daySelect" id="peopleSelect" ng-model="peopleSelect" ng-change="peopleSelectChange(peopleSelect)">
                        <option value="1">全部会员</option>
                        <option value="2">有效会员</option>
                    </select>
                </span>-->
            </div>
            <div class="panel-body">
                <ul class="peopleList">
                    <li class="">
                        <h4 class="fl titleH4">教练姓名</h4>
                        <h4 class="fr">客户量</h4>
                    </li>
                    <li class="" ng-repeat="($index,p) in peopleList">
                        <span class="fl">
                            <i>
                                <b class="iImg img1" ng-if="$index == 0"></b>
                                <b class="iImg img2" ng-if="$index == 1"></b>
                                <b class="iImg img3" ng-if="$index == 2"></b>
                                <b class="iB" ng-if="$index != 0 && $index != 1 && $index != 2">{{$index + 1}}</b>
                                <a href="" class="fl">{{p.name | noData:''}}</a>
                            </i>
                        </span>
                        <span class="fr pointer" ng-click="memberNumBtn(p)">
                            {{p.num}}人
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--详情模态框-->
    <?=$this->render('@app/views/private-stat/clientModal.php');?>
    <!--生日会员模态框-->
    <?=$this->render('@app/views/private-stat/birthdayModal.php');?>
    <!--会员量模态框-->
    <?= $this->render('@app/views/private-stat/memberNum.php'); ?>
    <!--会员信息模态框-->
    <?= $this->render('@app/views/publicMemberInfo/publicMemberInfo.php'); ?>
</div>

