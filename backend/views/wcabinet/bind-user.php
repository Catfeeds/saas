<?php
use backend\assets\BindUserAsset;
BindUserAsset::register($this);
$this->title = '更柜管理';
?>
<div ng-controller="CabinetBindCtrl" class="group" ng-cloak>
    <input  id="_csrf" type="hidden"
            name="<?= \Yii::$app->request->csrfParam; ?>"
            value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <div class="row">
<!--        <div class="col-sm-1 col-xs-1 panel panel-default pd0" style="height: 100%">-->
<!--            <div class="panel-body pd0">-->
<!--                <ul class="group-ul">-->
<!--                    <li><a href="/correcting/index">进馆验卡</a></li>-->
<!--                    <li class="orderMenu"><a href="/wcabinet/index">更衣柜管理</a></li>-->
<!--                    <li>场地管理</li>-->
<!--                    <li>请假记录</li>-->
<!--                </ul>-->
<!--            </div>-->
<!--        </div>-->
        <div class="col-sm-12 col-xs-12 panel panel-default pd0" style="margin-bottom: 0">
            <div class="panel-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li style="padding-left: 0;" role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">更衣柜管理</a></li>
                    <li role="presentation"><a href="/wcabinet/index#profile">到期提醒</a></li>
                    <li role="presentation"><a href="/wcabinet/index#profile1">退柜设置</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 content-center panel panel-default pd0">
            <div class="panel-body detialS" style="overflow-y: auto;min-height: 600px;">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div ng-show="!isRenew && !isSwitch && !isQuit" class="row">
<!--                            <div class="col-sm-8 col-xs-8" style="margin-bottom: 20px">-->
<!--                                <div class="input-group" style="width: 400px">-->
<!--                                    <input type="text" class="form-control" ng-keyup="enterSearch($event)" ng-model="keywords" placeholder="请输入卡号,手机号,身份证号..." style="height: 30px;line-height: 7px;">-->
<!--                                <span class="input-group-btn">-->
<!--                                    <button type="button" class="btn btn-sm btn-success" ng-click="searchMember()">搜索</button>-->
<!--                                </span>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3" style="padding-top: 10px">
                                        <div class="input-file ladda-button btn uploader pd0"
                                             id="imgFlagClass"
                                             ngf-drop="uploadCover($file,'update')"
                                             ladda="uploading"
                                             ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                                             ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                                             ngf-select="uploadCover($file,'update')"
                                             style="padding: 0;width: 100%;">
                                            <img ng-src="{{memberData.pic}}" style="width: 100%;height: 100%" ng-if="memberData.pic">
                                            <img ng-src="/plugins/user/images/noPic.png" ng-if="!memberData.pic" style="float: left;margin:0;width: 100%;">
                                        </div>
                                        <div class="form-group size20" style="margin-top: 30px;">姓名:{{memberData.username | noData:''}}</div>
                                        <div class="form-group size13" ng-if="memberData.sex == 1">会员性别:男</div>
                                        <div class="form-group size13" ng-if="memberData.sex == 2">会员性别:女</div>
                                        <div class="form-group size13" ng-if='memberData.mobile !=0'>手机号码:{{memberData.mobile|noData:''}}</div>
                                        <div class="form-group size13">会员类型:{{memberData.member_type=='1' ? '正式会员': memberData.member_type=='2'?'潜在会员' : '失效会员'|noData:''}}</div>
                                    </div>
                                     <div class="col-sm-9">
                                         <div class="form-group size20" style="margin-top: 10px;"><b>{{memberData.type_name}}</b></div>
                                         <div class="form-group size13">总金额:{{memberData.price}}元</div>
                                         <div class="form-group size13">总天数:{{memberData.totalDay}}天</div>
                                         <div class="form-group size13">剩余天数:{{memberData.surplusDay}}天</div>
                                         <div class="form-group size13">有效期至:{{memberData.start_rent*1000 | date:'yyyy-MM-dd' | noData:''}}至{{memberData.end_rent*1000 | date:'yyyy-MM-dd' | noData:''}}</div>
                                         <div class="form-group size13">备注:{{memberData.remark?memberData.remark:'暂无'}}</div>
                                         <div>
                                             <?php if (\backend\models\AuthRole::canRoleByAuth('cabinet', 'UPDATE')) { ?>
                                                 <button type="button" class="btn btn-info w100" ng-click="editUnBinding(cabinetDetailOne.cabinet_id,'isBind')" data-toggle="modal" data-target="#revise">修改</button>
                                             <?php } ?>
                                             <button type="button" class="btn btn-warning w100"  ng-click="renewCabinet(cabinetDetailOne)" data-toggle="modal" data-target="#renewCabinet">续柜</button>
                                             <button type="button" class="btn btn-success w100"  ng-click="switchCabinet(cabinetDetailOne)">调柜</button>
                                             <button type="button" class="btn btn-white w100"  ng-click="quitCabinet(cabinetDetailOne.cabinet_id,cabinetDetailOne.memberCabinetId, cabinetDetailOne)" data-toggle="modal" data-target="#backCabinet">退柜</button>
                                             <!--                                            冻结的触发按钮-->
                                             <button type="button"  class="btn btn-danger w100" ng-if="cabinetDetailOne.status==2"   ng-click="freezeCabinet(cabinetDetailOne.cabinet_id)">冻结</button>
                                             <button type="button"  class="btn btn-danger w100" ng-if="cabinetDetailOne.status==4" ng-click="cancelFreezeCabinet(cabinetDetailOne.cabinet_id)" >取消冻结</button>
                                         </div>
                                        <!-- 消费记录-->
                                        <div class="col-sm-12" style="margin-top: 30px;padding: 0">
                                            <div class="panel panel-default mm">
                                                <div class="panel panel-default" style="overflow-y: auto;">
                                                    <div class="panel-heading">
                                                        <span style="display: inline-block"><b class="spanSmall">消费记录</b></span>
                                                    </div>
                                                    <div class="panel-body" style="padding: 0;">
                                                        <table class="table table-striped table-bordered table-hover">
                                                            <thead>
                                                            <tr role="row">
                                                                <th>消费行为</th>
                                                                <th>消费金额</th>
                                                                <th>租用日期</th>
                                                                <th>消费日期</th>
                                                                <th>赠送时间</th>
                                                                <th>经办人</th>
                                                                <th>备注</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr ng-repeat="w in expenses">
                                                                <td>{{w.rent_type}}</td>
                                                                <td>{{w.price}}</td>
                                                                <td>{{w.start_rent *1000 | noData:''| date:'yyyy/MM/dd'}} - {{w.end_rent *1000 | noData:''| date:'yyyy/MM/dd'}}</td>
                                                                <td ng-if="w.rent_type == '退租金'">{{w.back_rent *1000 | noData:''|
                                                                    date:'yyyy/MM/dd'}}</td>
                                                                <td ng-if="w.rent_type != '退租金'">{{w.create_at *1000 | noData:''|
                                                                    date:'yyyy/MM/dd'}}
                                                                </td>
                                                                <td ng-if="w.give_month != null && w.give_month != 0 && w.give_month != ''">{{w.give_month}}
                                                                    <span ng-if="w.give_type != null">
                                                                        <span ng-if="w.give_month != null && w.give_month !='' && w.give_type == 1">天</span>
                                                                        <span ng-if="w.give_month != null && w.give_month !='' && w.give_type == 2">月</span>
                                                                    </span><span ng-if="w.give_type == null">月</span></td>
                                                                <td ng-if="w.give_month == null || w.give_month == 0 || w.give_month == ''">0</td>
                                                                <td ng-if="w.name != null && w.name != undefined && w.name != ''">{{w.name}}</td>
                                                                <td ng-if="w.name == null || w.name == undefined || w.name == ''">暂无数据</td>
                                                                <td ng-if="w.remark != null && w.remark != undefined && w.remark != ''">{{w.remark }}</td>
                                                                <td ng-if="w.remark == null || w.remark == undefined || w.remark == ''">暂无数据</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <?=$this->render('@app/views/common/pagination.php',['page'=>'payPages']);?>
                                                        <?=$this->render('@app/views/common/nodata.php',['name'=>'payNoDataShow','text'=>'无消费记录','href'=>true]);?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div style>
                                    </div>
                                </div>
                            </div>
                        </div>
<!--                        续柜-->
                        <div ng-show="isRenew" class="row">
                            <div class="col-sm-12" style="border-bottom: 1px solid #ddd;">
                                <div style="padding: 0 0 10px 10px;color: #676a6cd6">< 更衣柜管理 < {{str4[1]}} < 续柜</div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-12 infoBox f14" >
                                    <div class="col-sm-12 infoBox f14" >
                                        <p class="cabinetName">{{cabinetDetail.cabinet_number}}
                                            <span ng-if="cabinetDetail.cabinetModel == 1">大柜</span>
                                            <span ng-if="cabinetDetail.cabinetModel == 2">中柜</span>
                                            <span ng-if="cabinetDetail.cabinetModel == 3">小柜</span>
                                        </p>
                                        <p>总共金额:<span>{{cabinetDetail.price | number:2 }}</span>元</p>
                                        <p>总共天数:<span>{{cabinetDetail.totalDay | noData:'' }}</span>天</p>
                                        <p>剩余天数:<span>{{cabinetDetail.surplusDay > 0 ? cabinetDetail.surplusDay+ '天':'已到期'}}</span></p>
                                        <p>到期时间:<span>{{cabinetDetail.start_rent*1000 | date:'yyyy-MM-dd' | noData:''}}至{{cabinetDetail.end_rent*1000 | date:'yyyy-MM-dd' | noData:''}}</span></p>
                                    </div>
                                    <div class="col-sm-12 infoBox f14"  style="border-top: 1px solid #eee;padding: 15px;">
                                        <label for="inputdate" style="display: inline-block" class="textLeft pd0 control-label fontNormal pR20"><span class="red">*</span>续柜月数:</label>
                                        <div style="display: inline-block">
                                            <input type="number" class="form-control" style="width: 200px" ng-model="reletMonth" inputnum ng-change="reletMonthChange(reletMonth)" placeholder="请输入月数如:12">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 infoBox f14" ng-if="giveReletMonthNum != null && giveReletMonthNum != undefined && giveReletMonthNum != ''">
                                        <label class="control-label fontNormal pR20" style="padding: 0">
                                            <span class="red" style="opacity: 0;">*</span>赠送<span>{{giveTimeType == 'd' ? '天' : '月'}}</span>数:
                                        </label>
                                        <div style="display: inline-block">
                                            <input type="number" checknum class="form-control giveReletMonthNum11" ng-model="giveReletMonthNum" ng-change="giveTimenNumChange(giveReletMonthNum)">
                                        </div>
                                        <span class="glyphicon glyphicon-info-sign" style="margin-top: 5px;margin-left: 6px;display: inline-block;color: #999;">赠送<span>{{giveTimeType == 'd' ? '天' : '月'}}</span>数不得大于{{giveReletMonthNum1}}<span>{{giveTimeType == 'd' ? '天' : '月'}}</span></span>
                                    </div>
                                    <div class="col-sm-12 infoBox f14" >
                                        <p>到期日期:<span >{{cabinetreletEndDate | noData:''}}</span>日</p>
                                    </div>
                                    <div class="col-sm-12 infoBox f14" ng-if="redisplay == 1">
                                        <label for="inputdate" class="textLeft pd0 control-label fontNormal pR20"><span>&nbsp; </span>折&emsp;&emsp;扣:</label>
                                        <div style="display: inline-block">
                                            <select class="form-control" ng-model="reDis" ng-change="getReDis(reDis)" style="font-size: 13px;">
                                                <option value="1" selected="selected">请选择折扣</option>
                                                <option value="{{d}}" ng-repeat="d in redises">{{ d }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 infoBox f14">
                                        <div class="row">
                                            <div class="col-sm-12" style="margin-bottom: 20px">
                                                <span class="mR20 f14" >应收金额：<span class="moneyCss">{{reletPrice| number:2}}<small class="f14">元</small></span></span>
                                            </div>
                                            <div class="col-sm-12">
                                                <button type="button" style="padding: 5px 50px" ladda="renewCabinetCompleteFlag" ng-click="renewCabinetComplete()" class="btn btn-sm btn-success" >完成</button>
                                                <button type="button" class="btn btn-sm btn-default" ng-click="cancel()">取消</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<!--                        调柜-->
                        <div ng-show="isSwitch" class="row">
                            <div class="col-sm-12" style="border-bottom: 1px solid #ddd;">
                                <div style="padding: 0 0 10px 10px;color: #676a6cd6">< 更衣柜管理 < {{str4[1]}} < 调柜</div>
                            </div>
                            <div class="col-sm-12">
                                <div style="width: 600px;padding-left: 85px;margin-top: 20px;">
                                    <div class="col-sm-3 pd0 switchCabinetArea" style="border: 1px solid #ddd !important;">
                                        <ul class="checkUl" style="padding: 0">
                                            <li>区域</li>
                                            <li class="listCabinetStyle"   ng-repeat="cabinet in allCabinet" ng-click="cabinetStyleList(cabinet.id,$index,cabinet)">{{cabinet.type_name}}</li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-9 pd0 switchCabinetAreaCabinetNum" style="border: 1px solid #ddd;">
                                        <div class="ibox float-e-margins boxShowNone borderNone" >
                                            <div class="ibox-content borderNone" style="padding: 0">
                                                <div  id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline pB0" role="grid">
                                                    <table class="table table-bordered table-hover dataTables-example dataTable">
                                                        <thead>
                                                        <tr role="row">
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 240px;">柜号</th>
                                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 240px;">型号</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr ng-repeat="(index, unLeasedCabinet) in  unLeasedCabinetLists" ng-class="{bgGrey: unLeasedCabinet.isSelect}" ng-click="selectSwitchCabinetBtn(unLeasedCabinet, index)">
                                                            <td>{{unLeasedCabinet.cabinet_number}}</td>
                                                            <td>
                                                                <span ng-if="unLeasedCabinet.cabinet_model == 1">大柜</span>
                                                                <span ng-if="unLeasedCabinet.cabinet_model == 2">中柜</span>
                                                                <span ng-if="unLeasedCabinet.cabinet_model == 3">小柜</span>
                                                                <span ng-if="unLeasedCabinet.cabinet_model == null">暂无数据</span>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div style="padding-left: 100px;" class="col-sm-12" >
                                <p class="mT10" >从 <span>{{cabinetDetail.type_name}}区&emsp;{{cabinetDetail.cabinet_number}}</span></p>
                                <p class="mT10 fw" >调到 <span>{{oldTypeName}}区&emsp;{{selectCabinetDetail.cabinet_number}}</span></p>
                                <p class="mT10" >到期时间 <span>{{switchCabinetEndDate | noData:''}}</span></p>
                            </div>
                            <div style="padding-left: 100px;" class="col-sm-12">
                                <span class="mR20 f14" >应补金额：<span class="moneyCss" >{{selectSwitchCabinetPrice | number:2}}<small class="f14">元</small></span></span>
                                <button type="button" ladda="completeSwitchCabinetBtnFlag" ng-click="completeSwitchCabinetBtn()" class="btn btn-success w100" >完成</button>
                            </div>
                        </div>
                        <!--                        续柜-->
                        <div ng-show="isQuit" class="row">
                            <div class="col-sm-12" style="border-bottom: 1px solid #ddd;">
                                <div style="padding: 0 0 10px 10px;color: #676a6cd6">< 更衣柜管理 < {{str4[1]}} < 续柜</div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-12 infoBox f14" >
                                    <div class="col-sm-12 infoBox f14" >
                                        <p class="cabinetName">{{cabinetDetail.cabinet_number}}
                                            <span ng-if="cabinetDetail.cabinetModel == 1">大柜</span>
                                            <span ng-if="cabinetDetail.cabinetModel == 2">中柜</span>
                                            <span ng-if="cabinetDetail.cabinetModel == 3">小柜</span>
                                        </p>
                                        <p>总共金额:<span>{{cabinetDetail.price | number:2 }}</span>元</p>
                                        <p>总共天数:<span>{{cabinetDetail.totalDay | noData:'' }}</span>天</p>
                                        <p>剩余天数:<span>{{cabinetDetail.surplusDay > 0 ? cabinetDetail.surplusDay+ '天':'已到期'}}</span></p>
                                        <p>到期时间:<span>{{cabinetDetail.start_rent*1000 | date:'yyyy-MM-dd' | noData:''}}至{{cabinetDetail.end_rent*1000 | date:'yyyy-MM-dd' | noData:''}}</span></p>
                                    </div>
                                    <div class="col-sm-12 infoBox f14" >
                                        <p>到期日期:<span >{{cabinetreletEndDate | noData:''}}</span>元</p>
                                    </div>
                                    <div class="col-sm-12 infoBox f14">
                                        <div class="row">
                                            <div class="col-sm-12" style="margin-bottom: 20px">
                                                <span class="mR20 f14" >退还押金：<span class="moneyCss">{{depositRefund | number:2}}<small class="f14">元</small></span></span>
                                            </div>
                                            <div class="col-sm-12">
                                                <button type="button" style="padding: 5px 50px" ladda="quitCabinetCompleteFlag" ng-click="quitCabinetComplete(cabinetDetail.end_rent*1000)" class="btn btn-sm btn-success" >完成</button>
                                                <button type="button" class="btn btn-sm btn-default" ng-click="cancel()">取消</button>
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
    </div>
</div>