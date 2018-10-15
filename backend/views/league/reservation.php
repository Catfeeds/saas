<?php
use backend\assets\ReservationAsset;
use backend\assets\InputCheckAsset;
ReservationAsset::register($this);
InputCheckAsset::register($this);
$this->title = '预约';
?>

<header class="reservation_header clearfix fw">
    <div class="w20  fl">云.运动</div>
    <div class="fl">1.预约设置</div>
</header>
<div class="yy_progress">
    <div class="progress"></div>
</div>
<section class="yy_search animated fadeIn">
    <div ng-app="App" ng-controller='reservationCtrl' ng-cloak>
    <div class="searchBox">
        <form action="" name="info">
            <input ng-model="res._csrf" id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
            <div>
                <h2>预约设置</h2>
            </div>
            <p style="margin-top: 10px;">开课前多长时间不可预约</p>
            <select class="form-control darkGrey" ng-model="before_class" name="">
                <option value="">请选择开课前多长时间不可预约</option>
                <option value="15minutes">15分钟不可约课</option>
                <option value="20minutes">20分钟不可约课</option>
                <option value="1hours">1小时不可约课</option>
                <option value="2hours">2小时不可约课</option>
                <option value="-1">不限</option>
            </select>

            <p style="margin-top: 10px;">所属场馆</p>
            <select class="form-control darkGrey" ng-model="venue_id" name="">
                <option value="">请选择所属场馆</option>
                <option value="1">大卫城</option>
                <option value="2">大上海城</option>
            </select>

            <p>课程预约人数上限</p>
            <select class="form-control" ng-model="reservation_number" name="">
                <option value="">请选择课程预约人数上限</option>
                <option value="5">5人以内</option>
                <option value="10">10人以内</option>
                <option value="15">15人以内</option>
                <option value="20">20人以内</option>
                <option value="30">30人以内</option>
                <option value="40">40人以内</option>
                <option value="60">60人以内</option>
                <option value="80">80人以内</option>
                <option value="100">100人以内</option>
                <option value="-1">不限</option>
            </select>

            <p>开课人数</p>
            <select class="form-control" ng-model="class_number" name="">
                <option value="">请选择开课人数</option>
                <option value="5">5人以内</option>
                <option value="10">10人以内</option>
                <option value="15">15人以内</option>
                <option value="20">20人以内</option>
                <option value="30">30人以内</option>
                <option value="40">40人以内</option>
                <option value="60">60人以内</option>
                <option value="80">80人以内</option>
                <option value="100">100人以内</option>
                <option value="-1">不限</option>
            </select>

            <p>人数不足课程自动取消时间</p>
            <select class="form-control" ng-model="cancel_time" name="">
                <option value="">请选择人数不足课程自动取消时间</option>
                <option value="15minutes">15分钟</option>
                <option value="30minutes">30分钟</option>
                <option value="1hours">1小时</option>
                <option value="2hours">2小时</option>
            </select>

            <p>会员早于开课多少分钟可取消</p>
            <input class="form-control" style="border: solid 1px darkgrey;border-radius: 2px;" type="text" ng-model="how_minutes" placeholder="0分钟可取消" />
            <p>会员可预约多少天以内的课</p>
            <input class="form-control" style="border: solid 1px darkgrey;border-radius: 2px;" type="text" ng-model="how_days" placeholder="0天以内的课" />

            <p>对会员展示课程预约人数</p>
            <select name="" ng-model="allow_look" class="form-control">
                <option value="">请选择对会员展示课程预约人数</option>
                <option value="允许所有人查看">允许所有人查看</option>
                <option value="允许付费会员查看">允许付费会员查看</option>
                <option value="禁止所有人查看">禁止所有人查看</option>
            </select>

            <form class="formRadio">
                <p>是否预约扣次</p>
                <div class="radio i-checks f16">
                    <label>
                        <input  type="radio" ng-model="is_deduction_times" ng-checked="is_deduction_times == 1" value="1" name="is_deduction_times"> <i></i>是</label>
                </div>
                <div class="radio i-checks f16">
                    <label>
                        <input type="radio" ng-model="is_deduction_times" ng-checked="is_deduction_times == 1" value="0" name="is_deduction_times"> <i></i>否</label>
                </div>
            </form>

            <form class="formRadio">
                <p>教练请假是否需要审核</p>
                <div class="radio i-checks f16">
                    <label>
                        <input  type="radio" ng-model="is_check_leave" ng-checked="is_check_leave == 1" value="1" name="is_check_leave"> <i></i>需要</label>
                </div>
                <div class="radio i-checks f16">
                    <label>
                        <input type="radio" ng-model="is_check_leave" ng-checked="is_check_leave == 0" value="0" name="is_check_leave"> <i></i>不需要</label>
                </div>
            </form>

            <form class="formRadio">
                <p>替课教练是否需要审核</p>
                <div class="radio i-checks f16">
                    <label>
                        <input  type="radio" ng-model="is_check_replace" value="1" name="is_check_replace"> <i></i>需要</label>
                </div>
                <div class="radio i-checks f16">
                    <label>
                        <input type="radio" ng-model="is_check_replace" value="0" name="is_check_replace"> <i></i>不需要</label>
                </div>
            </form>

        </form>
    </div>
    <div id="lastBox">
        <div class="fixedBox " >

            <button type="button" class="backBut btn btn-primary " ng-click="Return()"  style="width: 80px">返回</button>
<!--            <a href="/league/index?mid=6&c=3" style="color: #FFFFFF;">-->
                <button type="submit" ng-click="present()" class="btn btn-success" style="width: 80px">完成</button>
<!--            </a>-->
        </div>
    </div>
    </div>
</section>
