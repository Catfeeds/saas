<?php
use backend\assets\IndexUpgradeAsset;
IndexUpgradeAsset::register($this);

$this->title='管理主页';
?>
<div class="container-fluid pd0" ng-controller="indexUpgradeCtrl" ng-cloak>
    <div class="row">
        <div class="col-sm-12 pd0" style="margin-top: 20px;margin-bottom: 20px;padding-left: 10px;padding-right: 10px;">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="col-sm-12 pd0" style="background: #fff;height: 100px;border-radius: 6px;min-width: 250px;">
                    <div style="background: #00e09e;width: 100px;height: 100px;border-radius: 6px;text-align: center;line-height: 80px;display: inline-block;position: relative;"><img src="/plugins/indexUpgrade/images/1.png" style="width: 40px;height: 40px;">
                    <span style="color: #fff;position: absolute;bottom: 20px;right: 24px;line-height: 18px;font-size: 13px;">到店人数</span>
                    </div>
                    <div class="pull-right col-sm-7 pd0" style="height: 100px;min-width: 150px;" ng-cloak>
                        <p style="text-align: left;color: #00e09e;font-size: 32px;font-weight: bold;margin-top: 6px;margin-bottom: 0;margin-left: 10px;"><span>{{todayAdd}}</span><select name="mySelect" id="mySelectDate" style="font-size: 12px;color: #999;font-weight: normal;float: right;margin-right: 20px;border: none;">
                                <option id="comeToday" value="" ng-selected>今日</option>
                                <option id="comeYesterday" value="2">昨日</option>
                            </select></p>
                        <p style="text-align: left;color: #999;margin-left: 10px;"><span class="glyphicon glyphicon-triangle-top" style="color: #ff0000;"></span>环比:+2%<br><span class="glyphicon glyphicon-triangle-top" style="color: #ff0000;"></span>同比:+2%</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6" style="">
                <div class="col-sm-12 pd0" style="background: #fff;height: 100px;border-radius: 6px;min-width: 250px;">
                    <div style="background: #ff9900;width: 100px;height: 100px;border-radius: 6px;text-align: center;line-height: 80px;display: inline-block;position: relative;"><img src="/plugins/indexUpgrade/images/2.png" style="width: 40px;height: 40px;">
                        <span style="color: #fff;position: absolute;bottom: 20px;right: 18px;line-height: 18px;font-size: 13px;">会员卡售卖</span>
                    </div>
                    <div class="pull-right col-sm-7 pd0" style="height: 100px;min-width: 150px;">
                        <p style="text-align: left;color: #ff9900;font-size: 32px;font-weight: bold;margin-top: 6px;margin-bottom: 0;margin-left: 10px;">38K<select name="mySelect" id="mySelectDate2" style="font-size: 12px;color: #999;font-weight: normal;float: right;margin-right: 20px;border: none;">
                                <option value="6">今日</option>
                                <option value="12">昨日</option>
                            </select></p>
                        <p style="text-align: left;color: #999;margin-left: 10px;"><span class="glyphicon glyphicon-triangle-top" style="color: #ff0000;"></span>环比:+2%<br><span class="glyphicon glyphicon-triangle-bottom" style="color: #00cc00;"></span>同比:-2%</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 " style="">
                <div class="col-sm-12 pd0" style="background: #fff;height: 100px;border-radius: 6px;min-width: 250px;">
                    <div style="background: #ffcc00;width: 100px;height: 100px;border-radius: 6px;text-align: center;line-height: 80px;display: inline-block;position: relative;"><img src="/plugins/indexUpgrade/images/3.png" style="width: 40px;height: 40px;">
                        <span style="color: #fff;position: absolute;bottom: 20px;right: 24px;line-height: 18px;font-size: 13px;">新增会员</span>
                    </div>
                    <div class="pull-right col-sm-7 pd0" style="height: 100px;min-width: 150px;">
                        <p style="text-align: left;color: #ffcc00;font-size: 32px;font-weight: bold;margin-top: 6px;margin-bottom: 0;margin-left: 10px">100<select name="mySelect" id="mySelectDate3" style="font-size: 12px;color: #999;font-weight: normal;float: right;margin-right: 20px;border: none;">
                                <option value="">今日</option>
                                <option value="12">昨日</option>
                            </select></p>
                        <p style="text-align: left;color: #999;padding-left: 10px;"><span class="glyphicon glyphicon-triangle-top" style="color: #ff0000;"></span>环比:+2%<br><span class="glyphicon glyphicon-triangle-bottom" style="color: #00cc00;"></span>同比:-2%</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6" style="">
                <div class="col-sm-12 pd0" style="background: #fff;height: 100px;border-radius: 6px;min-width: 250px;">
                    <div style="background: #00CCFF;width: 100px;height: 100px;border-radius: 6px;text-align: center;line-height: 80px;display: inline-block;position: relative;"><img src="/plugins/indexUpgrade/images/4.png" style="width: 40px;height: 40px;">
                        <span style="color: #fff;position: absolute;bottom: 20px;right: 24px;line-height: 18px;font-size: 13px;">私课收入</span>
                    </div>
                    <div class="pull-right col-sm-7 pd0" style="height: 100px;min-width: 150px;">
                        <p style="text-align: left;color: #00CCFF;font-size: 32px;font-weight: bold;margin-top: 6px;margin-bottom: 0;margin-left: 10px;">10K<select name="mySelect" id="mySelectDate4" style="font-size: 12px;color: #999;font-weight: normal;float: right;margin-right: 20px;border: none;">
                                <option value="6">今日</option>
                                <option value="12">昨日</option>
                            </select></p>
                        <p style="text-align: left;color: #999;margin-left: 10px;"><span class="glyphicon glyphicon-triangle-top" style="color: #ff0000;"></span>环比:+2%<br><span class="glyphicon glyphicon-triangle-bottom" style="color: #00cc00;"></span>同比:-2%</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12" style="padding: 0 20px;">
            <div class="col-sm-8 pd0" style="background: #fff;height: 454px;">
                <p style="font-size: 16px;font-weight: bold;padding-left: 20px;padding-top: 10px;padding-bottom: 10px;border: 1px solid #eee;border-width: 0 0 2px 0;position: relative;">
                    <select name="changeSelect" id="changeSelect" ng-change="dateSelect()" ng-model="dateChange" style="border: none;">
                        <option value="">我爱运动大上海城总收入</option>
                        <option value="2">到店人数统计</option>
                    </select>
                    <select name="mySelect" id="mySelectChange" style="font-size: 14px;color: #999;font-weight: normal;float: right;margin-right: 20px;border: none;">
                        <option value="6">半年内收入</option>
                        <option value="12">1年内收入</option>
                    </select>
                    <span class="dataAllPeople">今日到店总人数:{{datePeopleNum}}人</span>
                    <button class="btn btn-primary pull-right btn-sm btnDetails" style="margin-right: 30px;margin-left: 10px; display: none;" data-toggle="modal" data-target="#myModal" ng-click="dateDetails()">详情&nbsp;&nbsp;<span class="glyphicon glyphicon-menu-right" ></span></button>
                <div class="input-append date dateBox" id="dateIndex" data-date="2017-06-09" data-date-format="yyyy-mm-dd" style="display: none;" ng-model="dateInput">
                    <input class="span2 btn btn-primary btn-sm" size="16" type="text" value="" id="dateSpan">
                    <span class="add-on"><i class="icon-th"></i></span>
                </div>
                </p>
                <div class="col-sm-12" style="padding: 20px;">
                    <div id="main" style="width: 840px;height:340px;margin-top: 20px;display: none;"></div>
                    <div id="main2" style="width: 840px;height:340px;margin-top: 20px;"></div>
                    <div id="main9" style="width: 840px;height:340px;margin-top: 20px;display: none;"></div>
                </div>
            </div>
            <div class="col-sm-4" style="padding-bottom: 0;padding-right: 0;padding-left: 20px;">
                <div class="col-sm-12 pd0" style="height: 454px;overflow-y: scroll;background: #fff;">
                    <p style="font-size: 16px;font-weight: bold;padding-left: 20px;padding-top: 10px;padding-bottom: 10px;border: 1px solid #eee;border-width: 0 0 2px 0;">最新公告</p>
                    <div class="col-sm-12" style="padding-left: 20px;padding-right: 20px;">
                        <p style="font-size: 14px;font-weight: bold;color: #333;">最新公告&nbsp;&nbsp; <span class="pull-right" style="font-weight: normal;color: #999;">暂无日期</span></p>
                        <p style="font-size: 14px;">最新公告</p>
                        <div class="lineG" style="height: 1px;background: #eee;"></div>
                    </div>
                    <div class="col-sm-12" style="padding-left: 20px;padding-right: 20px;margin-top: 10px;">
                        <p style="font-size: 14px;font-weight: bold;color: #333;">最新公告&nbsp;&nbsp; <span class="pull-right" style="font-weight: normal;color: #999;">暂无日期</span></p>
                        <p style="font-size: 14px;">最新公告</p>
                        <div class="lineG" style="height: 1px;background: #eee;"></div>
                    </div>
                    <div class="col-sm-12" style="padding-left: 20px;padding-right: 20px;margin-top: 10px;">
                        <p style="font-size: 14px;font-weight: bold;color: #333;">最新公告&nbsp;&nbsp; <span class="pull-right" style="font-weight: normal;color: #999;">暂无日期</span></p>
                        <p style="font-size: 14px;">最新公告</p>
                        <div class="lineG" style="height: 1px;background: #eee;"></div>
                    </div><div class="col-sm-12" style="padding-left: 20px;padding-right: 20px;margin-top: 10px;">
                        <p style="font-size: 14px;font-weight: bold;color: #333;">最新公告&nbsp;&nbsp; <span class="pull-right" style="font-weight: normal;color: #999;">暂无日期</span></p>
                        <p style="font-size: 14px;">最新公告</p>
                        <div class="lineG" style="height: 1px;background: #eee;"></div>
                    </div>
                </div>
                </div>
            </div>
        <div class="col-sm-12 pd0" style="padding: 20px 10px;background: #f5f5f5;">
            <div class="col-sm-4" style="padding-left: 10px;padding-right: 10px;">
                <div class="col-sm-12 pd0">
                    <div class="col-sm-12 pd0" style="background: #fff;">
                        <p style="font-size: 16px;font-weight: bold;padding-top: 10px;padding-left:20px;padding-bottom: 10px;border: 1px solid #eee;border-width: 0 0 2px 0;">总收入各项占比
                            <select name="mySelect" id="mySelectChange2" style="font-size: 14px;color: #999;font-weight: normal;float: right;margin-right: 20px;border: none;">
                                <option value="6">本月</option>
                                <option value="12">上个月</option>
                            </select></p>
                        <div id="main3" style="width: 380px;height:400px;margin-top: 20px;padding-left: 20px;"></div>
                        <div id="main4" style="width: 380px;height:400px;margin-top: 20px;padding-left: 20px;display: none;"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4" style="padding-left: 10px;padding-right: 3px;">
                <div class="col-sm-12 pd0">
                    <div class="col-sm-12 pd0" style="background: #fff;">
                        <p style="font-size: 16px;font-weight: bold;padding-top: 10px;padding-left:20px;padding-bottom: 10px;border: 1px solid #eee;border-width: 0 0 2px 0;">客户来源渠道
                            <select name="mySelect" id="mySelectChange4" style="font-size: 14px;color: #999;font-weight: normal;float: right;margin-right: 20px;border: none;">
                                <option value="6">本月</option>
                                <option value="12">上个月</option>
                            </select></p>
                        <div id="main5" style="width: 380px;height:400px;margin-top: 20px;padding-left: 20px;padding-bottom: 40px;"></div>
                        <div id="main8" style="width: 380px;height:400px;margin-top: 20px;padding-left: 20px;padding-bottom: 40px;display: none;"></div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4" style="padding-left: 17px;padding-right: 10px;">
                <div class="col-sm-12 pd0">
                    <div class="col-sm-12 pd0" style="background: #fff;">
                        <p style="font-size: 16px;font-weight: bold;padding-top: 10px;padding-left:20px;padding-bottom: 10px;border: 1px solid #eee;border-width: 0 0 2px 0;">店铺各项指标
                            <select name="mySelect" id="mySelectChange3" style="font-size: 14px;color: #999;font-weight: normal;float: right;margin-right: 20px;border: none;">
                                <option value="6">本月</option>
                                <option value="12">上个月</option>
                            </select></p>
                        <div id="main6" style="width: 380px;height:400px;margin-top: 20px;padding-left: 20px;"></div>
                        <div id="main7" style="width: 380px;height:400px;margin-top: 20px;padding-left: 20px;display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--进店人数详情模态框-->
    <?= $this->render('@app/views/site/shopDetails.php'); ?>
</div>
