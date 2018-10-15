<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12 0012
 * Time: 09:29
 */
-->
<div class="col-md-12 pd0">
    <div class="panel panel-default mb10">
        <div class="panel-heading">今日概况</div>
        <div class="panel-body">
            <div class="col-lg-2 col-md-3 col-sm-4 mb10">
                <p class="mb10">新增潜在客户</p>
                <p class="mb10 h18">
                    <span class="fl">{{potential.today}}人</span>
                    <img class="fl wh18" src="/plugins/privateStat/img/up1.png" ng-if="potential.today > potential.yesterday">
                    <img class="fl wh18" src="/plugins/privateStat/img/down1.png" ng-if="potential.today < potential.yesterday">
                    <img class="fl wh18" src="/plugins/privateStat/img/deng.png" ng-if="potential.today == potential.yesterday">
                </p>
                <p>昨日数据：<span>{{potential.yesterday}}人</span></p>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 mb10">
                <p class="mb10">新增购课客户</p>
                <p class="mb10 h18">
                    <span class="fl">{{buy_class.today}}人</span>
                    <img class="fl wh18" src="/plugins/privateStat/img/up1.png" ng-if="buy_class.today > buy_class.yesterday">
                    <img class="fl wh18" src="/plugins/privateStat/img/down1.png" ng-if="buy_class.today < buy_class.yesterday">
                    <img class="fl wh18" src="/plugins/privateStat/img/deng.png" ng-if="buy_class.today == buy_class.yesterday">
                </p>
                <p>昨日数据：<span>{{buy_class.yesterday}}人</span></p>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 mb10">
                <p class="mb10">新增成交金额</p>
                <p class="mb10 h18">
                    <span class="fl">{{money.today}}元</span>
                    <img class="fl wh18" src="/plugins/privateStat/img/up1.png" ng-if="showUp">
                    <img class="fl wh18" src="/plugins/privateStat/img/down1.png" ng-if="showDown">
                    <img class="fl wh18" src="/plugins/privateStat/img/deng.png" ng-if="showDeng">
                </p>
                <p>昨日数据：<span>{{money.yesterday}}元</span></p>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 mb10">
                <p class="mb10">新增订单数</p>
                <p class="mb10 h18">
                    <span class="fl">{{order.today}}笔</span>
                    <img class="fl wh18" src="/plugins/privateStat/img/up1.png" ng-if="order.today > order.yesterday">
                    <img class="fl wh18" src="/plugins/privateStat/img/down1.png" ng-if="order.today < order.yesterday">
                    <img class="fl wh18" src="/plugins/privateStat/img/deng.png" ng-if="order.today == order.yesterday">
                </p>
                <p>昨日数据：<span>{{order.yesterday}}笔</span></p>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 mb10">
                <p class="mb10">体验课上课量</p>
                <p class="mb10 h18">
                    <span class="fl">{{t_num.today}}节</span>
                    <img class="fl wh18" src="/plugins/privateStat/img/up1.png" ng-if="t_num.today > t_num.yesterday">
                    <img class="fl wh18" src="/plugins/privateStat/img/down1.png" ng-if="t_num.today < t_num.yesterday">
                    <img class="fl wh18" src="/plugins/privateStat/img/deng.png" ng-if="t_num.today == t_num.yesterday">
                </p>
                <p>昨日数据：<span>{{t_num.yesterday}}节</span></p>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 mb10">
                <p class="mb10">付费课上课量</p>
                <p class="mb10 h18">
                    <span class="fl">{{f_num.today}}节</span>
                    <img class="fl wh18" src="/plugins/privateStat/img/up1.png" ng-if="f_num.today > f_num.yesterday">
                    <img class="fl wh18" src="/plugins/privateStat/img/down1.png" ng-if="f_num.today < f_num.yesterday">
                    <img class="fl wh18" src="/plugins/privateStat/img/deng.png" ng-if="f_num.today == f_num.yesterday">
                </p>
                <p>昨日数据：<span>{{f_num.yesterday}}节</span></p>
            </div>
        </div>
    </div>
</div>