<?php
use backend\assets\PhoneTotalAsset;
PhoneTotalAsset::register($this);
$this->title = '手机数据统计';
/**
 * 财务管理 - 手机统计 - 手机数据统计
 * @author zhujunzhe@itsports.club
 * @create 2018/1/6 pm
 */
?>
<div class="phoneTotal" ng-controller="phoneTotalCtrl" ng-cloak>
    <button type="button" class="btn btn-default active" id="show-matrix-id" ng-click="clickA(2)">矩阵</button>
    <button type="button" class="btn btn-default " id="show-list-id" ng-click="clickA(1)">列表</button>

    <!-- 矩阵显示 -->
    <div ng-show="a == 2" class="phoneContent" style="width:100%">
        <!--头部-->
        <header>
            <!--日期插件-->
            <div style="width: 28%;float: left;margin-top: 15px;">
                <div class="input-daterange input-group cp" id="container1">
                    <span class="add-on input-group-addon"">
                    选择日期
                    </span>
                    <input type="text" readonly name="reservation" id="sellDate1"
                           class="form-control text-center userSelectTime reservationExpire"
                           style="width: 195px;"/>
                    <button class="btn btn-info btn-sm rem" ng-click="emptyDate()">
                        清除
                    </button>
                </div>
            </div>
            <!--标题-->
            <div class="panel-heading" style="width: 50%;float: left;text-align: center">
                <b class="spanSmall" style="font-size: 20px;">手机数据统计</b>
            </div>
        </header>
        <hr>
        <!--主要内容区-->
        <div class="phoneMain">
            <!--第一行卡片-->
            <!--<div class="mainCard">
                <!--每个卡片-->
               <!-- <div class="cardList" ng-repeat="item in activeNum">
                    <p>{{item.name}}</p>
                    <div class="peopleNum" style="border-bottom: 1px solid #cccccc;">
                        <span style="color: #66cc00">{{ item == null ? 0 : item.activeNum }}</span>
                        <em>访问累计人数</em>
                    </div>
                </div>
            </div>-->
            <div class="row">
                <div class="col-md-2" ng-repeat="item in activeNum" style="background: #ffffff;margin-bottom: 20px;height: 200px;padding-right: 0;margin-right: 15px;border-radius: 10px;">
                    <h4 class="text-center">{{item.name}}</h4>
                    <div class="peopleNum" style="border-bottom: 1px solid #cccccc;border-top: 1px solid #cccccc;">
                        <span style="color: #66cc00">{{ item == null ? 0 : item.activeNum }}</span>
                        <em>访问累计人数</em>
                    </div>
                </div>
            </div>
            <div class="mainCard">
                <div class="cardList" ng-repeat="item in downNum">
                    <p style="text-align: center">{{item.name}}</p>
                    <div class="peopleNum" style="border-bottom: 1px solid #cccccc;">
                        <span style="color: #ffcc00">{{ item.activityUsers[0].downLoadNum == null ? 0 : item.activityUsers[0].downLoadNum }}</span>
                        <em>下载累计人数</em>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 列表显示-->
    <div ng-show="a == 1" class="phoneContent" style="margin-top: 15px;">
        <section class="col-sm-12" style="display: flex;flex-wrap: wrap;">
            <div style="width: 28%;float: left;margin-top: 15px;">
                <div class="input-daterange input-group cp" id="container2">
                    <span class="add-on input-group-addon"">
                    选择日期
                    </span>
                    <input type="text" readonly name="reservation" id="sellDate2"
                           class="form-control text-center userSelectTime reservationExpire"
                           style="width: 195px;"/>
                    <button class="btn btn-info btn-sm rem" ng-click="emptyDate2()">
                        清除
                    </button>
                </div>
            </div>
            <div class="mR10 mT10" style="margin-left: 0px;margin-top: 15px">
                <!-- 1未付款2已付款3其他4已退款-->
                <select ng-change="searchCompany()" ng-model="companyId" class="form-control selectCss " style="font-size: 13px">
                    <option value="">请选择公司</option>
                    <option value="{{ c.id }}" ng-repeat="c in optionCompany">{{c.name}}</option>
                </select>
            </div>

            <div class="mR10 mT10" style="margin-top: 15px;margin-left: 15px">
                <select ng-change="searchClient()" ng-model="client" class="form-control selectCss " style="font-size: 13px">
                    <option value="">所有客户端</option>
                    <option value="1">安卓</option>
                    <option value="2">IOS</option>
                </select>
            </div>
        </section>
        <div style="margin-top: -20px">
            <table class="table" style="width: 900px;">
                <tr>
                    <th>场馆</th>
                    <th>访问量</th>
                    <th>点击量</th>
                </tr>
                <tr ng-repeat="t in tableData">
                    <td>{{ t.name }}</td>
                    <td>{{ t == null ? 0 : t.visitNum }}</td>
                    <td>{{ t == null ? 0 : t.activeNum }}</td>
                </tr>
            </table>
            <div style="margin: 0 auto;text-align: center">
                <span>总访问量: </span><b style="color: orange;font-size: 18px">{{ totalVisitNum }}人</b>
                <span>总点击量: </span><b style="color: orange;font-size: 18px">{{ totalActiveNum }}人</b>
            </div>
            <?= $this->render('@app/views/common/nodata.php',['text'=>'该公司未使用手机端','href'=>true]); ?>
        </div>
    </div>
</div>
