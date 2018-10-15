<?php
use backend\assets\UserAsset;

UserAsset::register($this);
$this->title = '会员管理';
?>
<!--<header>-->
<div ng-controller="indexCtrl" ng-cloak>
<!--    <div class="wrapper wrapper-content animated fadeIn">-->
<!--        <div class="row">-->
<!--            <div class="col-sm-12">-->

                <div class="panel panel-default ">
                    <div class="panel-heading">
                        <span style="display: inline-block"><b class="spanSmall">会员管理</b></span>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-6 userHeader" style="">
                            <div class="input-group">
                                <input type="text" class="form-control userHeaders" ng-model="keywords" ng-keyup="enterSearch($event)" placeholder=" 请输入会员名或手机号或卡号进行搜索...">
                                <span class="input-group-btn">
                                    <button type="button" ng-click="searchCard()" class="btn btn-primary">搜索</button>
                                </span>
                            </div>
                        </div>
                        <!--                        导出表单暂时不用 不删除-->
                        <!--                        <div class="col-sm-2 col-sm-offset-2 text-right">-->
                        <!--                            <li class="nav_add">-->
                        <!--                                <ul>-->
                        <!--                                    <li id="tmk">-->
                        <!--                                        <a href="" class="glyphicon glyphicon-download-alt" style="font-size: 14px;margin-top: 5px;">&nbsp导出表单</a>-->
                        <!--                                    </li>-->
                        <!--                                </ul>-->
                        <!--                            </li>-->
                        <!--                        </div>-->
                        <div class="col-sm-12">
                            <h4 class="a3">条件筛选</h4>
                        </div>
                        <div class=" col-sm-12 pd0 clearfix userHeadeChoice ">
                            <div class="input-daterange input-group fl cp mR10 mT10" id="container" style="width: 340px;margin-bottom: -2px;">
                                <div class="input-daterange input-group cp userTimeRecord" id="container" >
                                    <span class="add-on input-group-addon" >
                                        激活时间
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar userRecodeTimes"></i>
                                    </span>
                                    <input type="text" ng-model="dateTime" readonly name="reservation" id="reservation"
                                           class="form-control text-center userSelectTime" value="" placeholder="选择时间"/>
                                </div>
                            </div>
<!--                            <div class=" col-sm-2 pdLr0" style="width: 100px;margin-left: 10px;">-->
<!--                                <select class="form-control fl cardStatus userHeader1" ng-model="cardStatus" multiple="multiple" style="width: 101px">-->
<!--                                    <option value="2">已冻结</option>-->
<!--                                    <option value="1">已请假</option>-->
<!--                                </select>-->
<!--                            </div>-->
                            <div class=" fl pdLr0 mR10 mT10" style="width: 120px;">
                                    <select  ng-model="venueId" class="selectCss js-example-basic-single1 js-states form-control memberHeaderVenue" id="id_label_single">
                                        <option value="">请选择场馆</option>
                                        <option ng-if="VenueStauts" value="{{w.id}}" ng-repeat="w in optionVenue" >{{w.name}}</option>
                                        <option ng-if="VenueStautsLength" value="" ><span style="color:red;">暂无数据</span></option>
                                    </select>
                            </div>
                            <div class=" fl pdLr0 mR10 mT10" style="width: 110px;">
                                <select class="form-control fl selectCss" ng-model="sex" >
                                    <option value="">性别不限</option>
                                    <option value="1">男</option>
                                    <option value="2">女</option>
                                </select>
                            </div>
                            <div class=" fl pdLr0 mR10  mT10" style="width: 110px;">
                                <select class="form-control fl selectCss" ng-model="privatesData" >
                                    <option value="">私课购买</option>
                                    <option value="1">已购买</option>
                                    <option value="2">未购买</option>
                                </select>
                            </div>
                            <div class=" fl pdLr0 mR10 mT10" style="width: 150px;">
                                <select ng-model="type" class="form-control fl selectCss" >
                                    <option value="">选择卡类别</option>
                                    <option value="1">时间卡</option>
                                    <option value="2">次卡</option>
                                    <option value="3">充值卡</option>
                                    <option value="4">混合卡</option>
                                </select>
                            </div>
                            <div class="fl pdLr0 mR10 mT10" style="width: 120px;position: relative;">
                                <lable for="id_label_single form-control" class="fontNormal" >
                                    <select ng-change="chooseSelectSale()" ng-model="selectSale " class="selectCss js-example-basic-single form-control " style="padding: 4px 12px;width: 120px;height: 30px;" id="idLabelSingle">
                                        <option value="" >选择销售</option>
                                        <option value="{{types.id}}" ng-repeat="types in optionSale">{{types.name}}
                                        </option>
                                    </select>
                                </lable>
                            </div>
                            <div class="fl pdLr0 mR10 mT10" style="width: 120px;">
                                <select class="form-control selectCss fl " style='height: 30px;' ng-model="allStates"  ng-change="cardStatusPost()">
                                    <option value="">全部状态</option>
                                    <option value="1">即将到期</option>
                                    <option value="2">沉睡会员</option>
                                    <option value="3">到期会员</option>
                                    <option value="vacate">已请假</option>
                                    <option value="freeze">已冻结</option>
                                </select>
                            </div>
                            <div class="fl mR10 mT10"  style="width: 120px;">
                                <select class="form-control selectCss" style="padding: 4px 12px;height: 30px;" ng-model="trialClass">
                                    <option value="">剩余体验课</option>
                                    <option value="2">2节体验课</option>
                                    <option value="1">1节体验课</option>
                                    <option value="0">0节体验课</option>
                                </select>
                            </div>
                            <div class="fl mR10 clearfix mT10">
                                <button type="button" ladda="searchCarding" ng-click="searchCard()"
                                        class="btn btn-sm btn-success ladda-button fl mR10" >确定
                                </button>
                                <button type="button" ladda="searchCarding" ng-click="searchClear()"
                                        class="btn btn-sm btn-info fl mR10">清空
                                </button>
                                <button type="button" ladda="searchCarding" ng-click="birthdayRemind()"
                                        class="btn btn-sm btn-warning ">生日提醒
                                </button>
                            </div>

                            <?= $this->render('@app/views/common/commonButton.php', ['attr' => true]); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 userListDetail">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>会员基本信息列表&nbsp<span class="a16">点击列表查看详情</span></h5>
                        </div>
                        <div class="ibox-content" style="padding: 0">
                            <div style="padding-bottom: 0;" id="DataTables_Table_0_wrapper"
                                 class="dataTables_wrapper form-inline" role="grid">
                                <table class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                    id="DataTables_Table_0"
                                    aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting" 
                                            tabindex="0" 
                                            aria-controls="DataTables_Table_0" 
                                            rowspan="1"
                                            colspan="1" 
                                            aria-label="浏览器：激活排序列升序"
                                            ng-click="changeSort('member_name',sort)" 
                                            style="width: 222px;"><span
                                                class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;姓名
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                            ng-click="changeSort('organization_name',sort)" style="width: 200px;"><span
                                                class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;场馆
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" style="width: 120px;" ng-click="changeSort('member_sex',sort)">
                                            <span class="fa fa-venus" aria-hidden="true"></span>&nbsp;性别
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                            ng-click="changeSort('member_age',sort)"
                                            style="width: 180px;"><span class="fa fa-tree" aria-hidden="true"></span>&nbsp;会员类型
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" style="width: 222px;"
                                            ng-click="changeSort('member_mobile',sort)"><span
                                                class="glyphicon glyphicon-earphone" aria-hidden="true"></span>&nbsp;电话
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 222px;">
                                            <span class="glyphicon glyphicon-time" aria-hidden="true" ng-click="changeSort('member_active_time',sort)"></span>&nbsp;有效期
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" style="width: 180px;"><span
                                                class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span>&nbsp;顾问
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" style="width: 120px;"><span
                                                class="glyphicon glyphicon-jpy" aria-hidden="true"></span>&nbsp;押金
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" style="width: 260px;"><span class="glyphicon glyphicon-edit"
                                                                                    aria-hidden="true"></span>&nbsp;操作
                                        </th>
<!--                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"-->
<!--                                            colspan="1" style="width: 350px;"><span class="glyphicon glyphicon-pencil"-->
<!--                                                                                    aria-hidden="true"></span>&nbsp;编辑-->
<!--                                        </th>-->
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr ng-repeat='data in datas' ng-click="getMemberDataCard(data.id,data.status,data.memberCard[0].id)">
                                        <td data-toggle="modal" data-target="#myModals2">
                                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'NAMESHOW')) { ?>
                                                {{data.name| noData:''}}
                                            <?php } else { ?>
                                                {{data.name| cut:true:1:'**'}}
                                            <?php } ?>
                                            &nbsp;
                                            <small class="label label-danger" ng-if="data.status == 2" ng-cloak>已冻结</small>
                                            <small class="label label-danger" ng-if="data.leaveRecord.status == 1">已请假</small>
                                            <small class="label label-primary" ng-if="data.leaveRecord.leave_property == 1">审核中</small>
<!--                                            <small class="label label-danger" ng-if="data.leaveRecord.status == 3 && data.leaveRecord.leave_property == 2">已请假</small>-->
                                        </td>
                                        <td data-toggle="modal" data-target="#myModals2">
                                            <span class="center-block" style="display: block;width: 100px;text-align: center;">{{data.organization_name}}</span>
                                        </td>
                                        <td data-toggle="modal" data-target="#myModals2">
                                            <span ng-if=data.sex==1>男</span>
                                            <span ng-if=data.sex==2>女</span>
                                        </td>
                                        <td data-toggle="modal" data-target="#myModals2">
                                            <span class="center-block" style="display: block;width: 60px;text-align: left;">{{data.member_type == 1 ?"正常会员":"潜在会员"}}</span>
                                        </td>
                                        <td data-toggle="modal" data-target="#myModals2" ng-if="data.mobile != 0">
                                            <span class="center-block" style="display: block;width: 80px;text-align: left;">
                                                 <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'MOBILESHOW')) { ?>
                                                     {{data.mobile| noData:''}}
                                                 <?php } else { ?>
                                                     {{data.mobile| cut:true:3:'********'}}
                                                 <?php } ?>
                                            </span>
                                        </td>
                                        <td data-toggle="modal" data-target="#myModals2" ng-if="data.mobile == 0">
                                            <span class="center-block" style="display: block;width: 80px;text-align: left;">
                                               暂无数据
                                            </span>
                                        </td>
                                        <td data-toggle="modal" data-target="#myModals2">
                                            <span class="center-block" style="display: block;width: 160px;text-align: left;" ng-if="data.active_time != null && data.invalid_time != null">
                                                {{data.active_time *1000 | noData:''| date:'yyyy/MM/dd'}} - {{data.invalid_time *1000 | noData:''| date:'yyyy/MM/dd'}}
                                            </span>
                                            <span ng-if="data.active_time == null">未激活 - 未激活</span>
                                        </td>
                                        <td data-toggle="modal" data-target="#myModals2">
                                            <span class="center-block" style="display: block;width: 54px;text-align: left;">{{data.employee_name| noData:''}}</span>
                                        </td>
                                        <td data-toggle="modal" data-target="#myModals2">
                                                <span >{{data.price != null ? data.price :'无押金'}}</span>
                                        </td>
<!--                                        <td>-->
<!---->
<!--                                        </td>-->
                                        <td>


                                            <div class="btn-group" role="group">
                                                <section type="button "  class="btn btn-default btn-sm  mL60" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                                    更多...
                                                </section>
                                                <ul  class="dropdown-menu selectCards"  >
                                                    <li>
                                                        <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'COACH')) { ?>
                                                        <button style="margin-bottom: 0;" ng-disabled="data.status == 2" class="wB100 btn btn-default borderNone btn-sm" type="submit" data-toggle="modal" data-target="#distribution" ng-click="distriButionClick(data.id)">
                                                            <span>分配私教</span>
                                                        </button>
                                                        <?php }?>
                                                    </li>
                                                    <li>
                                                        <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'LESSON')) { ?>
                                                        <button style="margin-bottom: 0;" class="wB100 btn btn-default borderNone btn-sm"
                                                                ng-disabled="data.status == 2 ? 'disabled':''"
                                                                ng-click="privateLessonBuy(data.id,data)">
                                                            私课购买
                                                        </button>
                                                        <?php }?>
                                                    </li>
                                                    <li>
                                                        <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'UPDATE')) { ?>
                                                            <button style="margin-bottom: 0;" ng-disabled="data.status == 2 ? 'disabled':''" ng-click="getMemberIdUpdate(data.id)" class="borderNone kick wB100  btn btn-default btn-sm">
                                                                修改
                                                            </button>
                                                        <?php } ?>
                                                    </li>
                                                    <li>
                                                        <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DELETE')) { ?>
                                                            <button style="margin-bottom: 0;" ng-disabled="data.status == 2 ? 'disabled':''"
                                                                    class="wB100 btn btn-default borderNone btn-sm" tape="
                                                        submit" ng-click="delMem(data.id,data.name)">删除</button>
                                                        <?php } ?>
                                                    </li>
                                                    <li>
                                                        <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'OPERATE')) { ?>
                                                            <button style="margin-bottom: 0;" class="wB100 borderNone btn-default btn btn-sm" ng-click="updateMember(data.id,data.status)" type="submit" ng-if="data.status == 2">
                                                                <span>取消冻结</span>
                                                            </button>
                                                            <button style="margin-bottom: 0;" ng-disabled="data.leaveRecordS[0].status ==  1?'disabled':''" class="wB100 borderNone  btn-default btn btn-sm" ng-click="updateMember(data.id,data.status)" type="submit" ng-if="data.status != 2">
                                                                <span>冻结</span>
                                                            </button>
                                                        <?php } ?>
                                                    </li>
                                                    <li>
                                                        <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DAYOFF')) { ?>
                                                        <button style="margin-bottom: 0;" class="wB100 borderNone btn btn-default btn-sm"
                                                                ng-disabled="data.leaveRecordS[0].status ==  1 || data.status == 2 ||data.leaveRecordS[0].leave_property == 1 ? 'disabled':''"
                                                                ng-click="leaveBut(data.id)">
                                                            请假
                                                        </button>
                                                        <?php } ?>
                                                    </li>
                                                    <li>
                                                        <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DEPOSIT')) { ?>
                                                        <button style="margin-bottom: 0;" ng-disabled="data.status == 2"  type="button" class="wB100 borderNone btn btn-default btn-sm" ng-if="data.price == null" ng-click="deposit(data.id)">定金</button>
                                                        <?php } ?>
                                                    </li>
                                                    <li  style="text-align: center;">
                                                        <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'GIVE')) { ?>
                                                        <button style="margin-bottom: 0;" ng-disabled="data.status == 2" ng-click='presenterClick(data.id)' class="wB100 borderNone btn btn-sm btn-default">赠送</button>
                                                        <?php } ?>
                                                    </li>
                                                    <li>
                                                        <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'SELL')) { ?>
                                                        <button style="margin-bottom: 0;" ng-disabled="data.status == 2"
                                                            class="wB100 btn btn-white btn-sm borderNone"
                                                            ng-click="userBuyCard(data.id)">
                                                            购卡
                                                        </button>
                                                        <?php } ?>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?= $this->render('@app/views/common/nodata.php'); ?>
                                <div class="row" style="margin-left: 0;margin-right: 0; display: flex;align-items: center;" ng-if="pages != ''&& pages != undefined " >
                                    <section  style=" font-size: 14px;padding-left: 6px;padding-right: 0;" class="col-sm-2">
                                        第<input style="width: 50px;padding: 4px 4px;height: 24px;border-radius: 3px;border:solid 1px #E5E5E5;" type="number" class="" checknum placeholder="几" ng-model="pageNum">页
                                        <button class="btn btn-primary btn-sm" ng-click="skipPage(pageNum)">跳转</button>
                                    </section>
                                    <div class="col-sm-10" style="padding-left: 0;padding-right: 0;">
                                        <?= $this->render('@app/views/common/pagination.php'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <!--  modal  -->
    <div ng-if="MemberDetailsUpdate != '暂无数据'">
        <div class="modal show-hide a3" id="myModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content clearfix a17">
                    <div style="border: none;" class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>

                        <h3 class="text-center a18" id="myModalLabel">
                            修改会员信息
                        </h3>
                        <div>
                        </div>
                        <form name="myForm">
                            <input ng-model="MemberData._csrf" id="_csrf" type="hidden"
                                   name="<?= \Yii::$app->request->csrfParam; ?>"
                                   value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                            <input ng-model="MemberDetailsUpdate.id" type="hidden">
                            <div class="form-group a3">
                                <label style="font-size: 14px;" for="exampleInputName2">姓名</label>
                                <input ng-model="MemberDetailsUpdate.name" name="name" required ng-minlength="2"
                                       ng-maxlength="10" ng-pattern="/^[\u3400-\u9FFF]+|([a-zA-Z]+)+$/"
                                       style="font-size: 12px;" type="text" class="form-control"
                                       id="exampleInputName2" placeholder="" disabled>
                                    <span class="text-danger help-block m-b-none" ng-show="myForm.name.$error.required">
                                        <i class="fa fa-info-circle"></i>
                                        请输入姓名（2-10个中文或英文字符）
                                    </span>
                                    <span class="text-danger help-block m-b-none"
                                          ng-show="myForm.name.$error.minlength || myForm.name.$error.maxlength || myForm.name.$error.pattern ">
                                         <i class="fa fa-info-circle"></i>
                                        姓名由2-10个中文或英文字符组成
                                    </span>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputName3" class="a19">性别</label>
                                <select ng-model="MemberDetailsUpdate.sex" required style="font-size: 12px;"
                                        class="form-control actions" disabled>
                                    <option value="" selected disabled>请选择性别</option>
                                    <option value="1">男</option>
                                    <option value="2">女</option>
                                </select>
                                    <span ng-if="!MemberDetailsUpdate.sex" class="text-danger help-block m-b-none">
                                        <i class="fa fa-info-circle"></i>
                                        请选择性别
                                    </span>
                            </div>
                            <div class="form-group">
                                <label class="a19" for="exampleInputName2">出生年月</label>
                                <div class="input-append date form-group" id="" data-date="12-02-2012"
                                     data-date-format="dd-mm-yyyy" start-date="12-02-1900">
                                    <input class="form-control" id="bothDate" style="font-size: 12px;"
                                           type="text" placeholder="请选择出生日期"
                                           ng-model="MemberDetailsUpdate.birth_date" disabled>
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                                <!--                                    <span class="text-danger help-block m-b-none" ng-show="myForm.birth_date.$error.required ">-->
                                <!--                                        <i class="fa fa-info-circle"></i>-->
                                <!--                                       请输入年龄  范围：10岁~150岁-->
                                <!--                                    </span>-->
                                <!--                                    <span class="text-danger help-block m-b-none" ng-show=" myForm.birth_date.$error.pattern || myForm.birth_date.$error.maxlength ">-->
                                <!--                                        <i class="fa fa-info-circle"></i>-->
                                <!--                                        年龄 仅支持数字 范围：10~150-->
                                <!--                                    </span>-->
                            </div>
                            <div class="form-group">
                                <label class="a19" for="exampleInputName2">电话</label>
                                <input ng-model="MemberDetailsUpdate.mobile" autocomplete="off" name="mobile"
                                       required ng-pattern="/^1[34578]\d{9}$/" style="font-size: 12px;"
                                       type="text" class="form-control" id="exampleInputName2" placeholder="" disabled>
                                   <span class="text-danger help-block m-b-none"
                                         ng-show="myForm.mobile.$error.required">
                                        <i class="fa fa-info-circle"></i>
                                        请输入手机号 只支持11位数字手机号
                                    </span>
                                    <span class="text-danger help-block m-b-none"
                                          ng-show="myForm.mobile.$error.pattern ">
                                        <i class="fa fa-info-circle"></i>
                                        手机号 格式不正确
                                    </span>
                            </div>
                            <div style="position: relative;padding-top: 20px;">
                                <div class="form-group" style="height: 100px;">
                                    <img id="imgBoolBlock" ng-if="MemberDetailsUpdate.memberDetails.fingerprint != null && MemberDetailsUpdate.memberDetails.fingerprint != ''" ng-src="/plugins/personal/img/u2063.png" class='photo mL120W100H100 ' style="width: 80px;height: 80px">
                                    <img id="imgBoolFalse" ng-if="MemberDetailsUpdate.memberDetails.fingerprint == null || MemberDetailsUpdate.memberDetails.fingerprint == ''"  class='photo mL120W100H100 imgBoolTrue imgBoolFalse' style="width: 100px;height: 100px">
                                    <img id="imgBoolUndefined"  ng-src="/plugins/personal/img/u2063.png" class='photo mL120W100H100 imgBoolTrue' style="width: 80px;height: 80px">

                                </div>
                                <div class="input-file"
                                     style="margin:  0 auto;width: 100px;height: 100px;position: relative; cursor: pointer;border: 1px dashed #ddd;margin-top: -115px;margin-left: 282px">
                                    <p style="margin-left: 0px;width: 100%;height: 100%;line-height: 72px;font-size: 50px;"
                                       class="text-center">+</p>
                                </div>
                                <div id="fpRegisterDiv"   style="display: inline; height: 80px;width:80px;position: absolute;top: 20px;left: 295px;">
                                    <a id="fpRegister"
                                       onclick='submitRegister("指纹", "指纹数:", "确认保存当前修改吗？", "驱动下载", false)'
                                       title="请安装指纹驱动或启动该服务" class="showGray"
                                       onmouseover="this.className='showGray'">请安装指纹驱动</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="a19" for="exampleInputName2">身份证号</label>
                                <input ng-model="MemberDetailsUpdate.id_card"
                                       ng-change="getMemberIdCard(MemberDetailsUpdate.id,MemberDetailsUpdate.id_card)"
                                       autocomplete="off" name="id_card" ng-pattern="/^\d{17}(\d|x|X)$/"
                                       style="font-size: 12px;" type="text" class="form-control"
                                       id="exampleInputName2" placeholder="" disabled>
                                <!--                                    <span class="text-danger help-block m-b-none" ng-show="myForm.id_card.$error.required">-->
                                <!--                                        <i class="fa fa-info-circle"></i>-->
                                <!--                                        请输入身份证号 只支持18位数字-->
                                <!--                                    </span>-->
                                    <span class="text-danger help-block m-b-none"
                                          ng-show=" myForm.id_card.$error.pattern ">
                                        <i class="fa fa-info-circle"></i>
                                        身份证号 格式不正确
                                    </span>
                                    <span ng-if="IdCard != true" class="text-danger help-block m-b-none"
                                          ng-show="IdCardStatus">
                                        <i class="fa fa-info-circle"></i>
                                        {{IdCard}}
                                    </span>
<!--                                <div class="form-group a20">-->
<!--                                    <label class="a19" for="exampleInputName9">家庭住址</label>-->
<!--                                    <input type="text" class="form-control" id="exampleInputName9"-->
<!--                                           placeholder="" ng-model="MemberDetailsUpdate.family_address">-->
<!--                                </div>-->
<!--                                <div class="form-group a20">-->
<!--                                    <label class="a19" for="exampleInputName6">工作</label>-->
<!--                                    <input type="text" class="form-control" id="exampleInputName6"-->
<!--                                           placeholder="" ng-model="MemberDetailsUpdate.profession">-->
<!--                                </div>-->
                                <div class="form-group a20">
                                    <label class="a19" for="exampleInputName7">销售顾问</label>
                                    <select class="form-control fl a21"
                                            ng-model="MemberDetailsUpdate.counselor_id" disabled>
                                        <option value="">--请选择顾问--</option>
                                        <option value="{{theAdviser.id}}" ng-repeat="theAdviser in allAdviser">
                                            {{theAdviser.name}}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group a20" style="margin-top: 50px;">
                                    <label class="a19" for="exampleInputName7">上传头像</label>
                                    <div class="form-group a20">
                                        <img ng-if="MemberDetailsUpdate.pic == null" ng-src="" width="100px"
                                             height="100px" style="border-radius: 50%;border: 1px solid #000">
                                        <img ng-if="MemberDetailsUpdate.pic != null"
                                             ng-src="{{MemberDetailsUpdate.pic}}" width="100px" height="100px"
                                             style="border-radius: 50%">
                                    </div>
                                    <div class="input-file ladda-button btn ng-empty uploader" id="imgFlagClass"
                                         ngf-drop="uploadCover($file,'update')"
                                         ladda="uploading"
                                         ngf-select="uploadCover($file,'update')"
                                    >
                                        <p class="text-center addCss">+</p>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary backBtn a3" data-dismiss="modal"
                                    aria-hidden="true">&nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp
                            </button>
                            <button ng-click="MemberInfo()"
                                    type="submit" class="btn btn-success pull-right successBtn a3">
                                &nbsp&nbsp&nbsp&nbsp确定&nbsp&nbsp&nbsp&nbsp
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--    验证指纹-->
    <div id="box" class="box" style="display: none;">
        <h2>指纹登记</h2>
        <div class="list">
            <canvas id="canvas" width="430" height="450"
                    style="background: rgb(243, 245, 240)"></canvas>
            <input type="hidden" id="whetherModify" name="whetherModify" alt=""
                   value="111" />

            <div
                style="position: absolute; left: 310px; top: 325px; width: 70px; height: 28px;">
                <button type="button" class="btn btn-success btn-sm button-form" id="submitButtonId" name="makeSureName"
                        onclick="submitEvent()">确定</button>
                <!-- ${common_edit_ok}:确定 -->
            </div>
            <div
                style="position: absolute; left: 310px; top: 365px; width: 70px; height: 28px;">
                <button type="button" class="btn btn-info  btn-sm button-form" type="button" id="closeButton"
                        name="closeButton" onclick='cancelEvent("确认保存当前修改吗?", "指纹数:");'>
                    取消</button>
                <!-- ${common_edit_cancel}:取消 -->
            </div>
        </div>
    </div>
    <div ng-if="MemberDetailsUpdate == '暂无数据'">
        <div class="modal fade a3" id="myModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content clearfix a22">
                    <div style="border: none;" class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>

                        <h3 class="text-center a23" id="myModalLabel">
                            修改会员信息
                        </h3>
                        <div>
                            操作错误（未获取修改用户id）
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--        模态2-->
    <div style="margin-left: 220px;overflow: auto" class="modal fade" id="myModals2" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog a24">
            <div style="border: none;" class="modal-content clearfix">
                <div style="border: none;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                            ng-click="closeAndBreak()">
                        &times;
                    </button>
                    <div class="panel blank-panel col-sm-12">
                        <div class="panel-heading">
                            <div class="panel-title m-b-md">
                                <h3 class="a25">会员详情信息</h3>
                            </div>
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="tabs_panels.html#tab-1"
                                           ng-click="getMemberDetail(data.id)">
                                            <span>资料</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="tabs_panels.html#tab-4"
                                           ng-click="getGroupClass(data.id)">
                                            <span>团课</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="tabs_panels.html#tab-5"
                                           ng-click="getCabinet(data.id)">
                                            <span>柜子</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="tabs_panels.html#tab-7"
                                           ng-click="getLeaveRecord(data.id)">
                                            <span>请假</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="tabs_panels.html#tab-8"
                                           ng-click="getEntryRecord(data.id)">
                                            <span>信息记录</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="tabs_panels.html#tab-13"
                                           ng-click="getHistory(data.id)">
                                            <span>消费</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="tabs_panels.html#tab-14"
                                           ng-click="privateEducationPurchaseInit(data.id)">
                                            <span>私课信息</span>
                                        </a>
                                    </li>

                                    <!--                                    1.1版本 暂时隐藏-->
                                    <li>
                                        <a data-toggle="tab" href="tabs_panels.html#tab-15"
                                           ng-click="getMemberInfo(data.id)">
                                            <span>会员卡详情</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div id="tab-1" class="col-sm-12 tab-pane active a3">
                                    <div class="col-sm-6" style="text-align: center;">
                                        <h4 style="font-size: 18px;"
                                            class=" col-sm-6 col-sm-offset-6 text-center">{{MemberData.name |
                                            noData:''}}</h4>
                                        <h4 style="margin-top: 10px;"
                                            class="img-circle col-sm-6 col-sm-offset-6 text-center">
                                            <img ng-src="{{MemberData.pic}}" ng-if="MemberData.pic!=null"
                                                 style="width: 150px;height: 150px;border-radius: 50%">
                                        </h4>
                                        <h4 class="img-circle col-sm-6 col-sm-offset-6 text-center a20">
                                            <img ng-src="/plugins/checkCard/img/11.png"
                                                 ng-if="MemberData.pic==null"
                                                 style="width: 100px;height: 100px">
                                        </h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <h4 style="font-size: 18px;">个人信息</h4>
                                        <p class="a20">会员编号：{{MemberData.id}}</p>
                                        <p class="a20">会员性别：
                                            <span ng-if="MemberData.sex== 1">男</span>
                                            <span ng-if="MemberData.sex== 2">女</span>
                                            <span ng-if="MemberData.sex== null">暂无数据</span>
                                        </p>
                                        <p class="a20">手机号码：<span ng-if="MemberData.mobile == 0">暂无数据</span><span
                                                ng-if="MemberData.mobile != 0">{{MemberData.mobile| noData:''}}</span>
                                        </p>
                                        <p class="a20">出生日期：{{MemberData.birth_date| noData:''}}</p>
<!--                                        <p class="a20">工作：{{MemberData.profession| noData:''}}</p>-->
                                        <p class="a20">会籍顾问：<span>{{MemberData.employee.name| noData:''}}</span>
                                        </p>
                                        <p class="a20">身份证号：{{MemberData.id_card| noData:''}}</p>
<!--                                        <p class="a20">家庭住址：{{MemberData.family_address| noData:''}}</p>-->
                                    </div>
                                    <div class="col-sm-12 a3">
                                        <!--                                    <button class="btn btn-info" data-toggle="modal" data-target="#myModals5" ng-click="getMemberUpdate(data.id)">&nbsp;&nbsp;&nbsp;&nbsp;修改&nbsp;&nbsp;&nbsp;&nbsp;</button>-->
                                        <button class="btn btn-success pull-right" data-dismiss="modal"
                                                aria-hidden="true">&nbsp;&nbsp;&nbsp;&nbsp;关闭&nbsp;&nbsp;&nbsp;&nbsp;</button>
                                    </div>
                                </div>
                                <div id="tab-2" class="tab-pane">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title">
                                            <h5>会员卡信息列表</h5>
                                        </div>
                                        <div class="ibox-content" style="padding: 0">
                                            <div style="" id="DataTables_Table_0_wrapper"
                                                 class="dataTables_wrapper form-inline a26" role="grid">
                                                <table
                                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                    id="DataTables_Table_0"
                                                    aria-describedby="DataTables_Table_0_info">
                                                    <thead>
                                                    <tr role="row">
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                                            style="width: 100px;">卡名称
                                                        </th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                                            style="width: 120px;">卡号
                                                        </th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                                            style="width: 120px;">办理日期
                                                        </th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                                            style="width: 100px;">有效期
                                                        </th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                                            style="width: 120px;">剩余/总次数
                                                        </th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                                            style="width: 140px;">剩余/总金额
                                                        </th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                                            style="width: 100px;">销售顾问
                                                        </th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                                            style="width: 140px;">操作
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr ng-repeat='item in items'>
                                                        <td>{{item.card_name| noData:''}}</td>
                                                        <td>{{item.card_number| noData:''}}</td>
                                                        <td>{{item.create_at *1000 | noData:''|
                                                            date:'yyyy/MM/dd'}}
                                                        </td>
                                                        <td>{{item.active_time *1000 | noData:''|
                                                            date:'yyyy/MM/dd'}} - {{item.invalid_time *1000 |
                                                            noData:''| date:'yyyy/MM/dd'}}
                                                        </td>
                                                        <td>{{item.total_times - item.consumption_times|
                                                            noData:'次'}}/{{item.total_times | noData:'次'}}
                                                        </td>
                                                        <td>{{item.balance| noData:'元'}}/{{item.amount_money|
                                                            noData:'元'}}
                                                        </td>
                                                        <td>{{item.employee.name| noData:''}}</td>
                                                        <td class="tdBtn2">
                                                            <button class="btn-sm btn btn-success"
                                                                    data-toggle="modal"
                                                                    ng-click="updateMemCard(item.employee.id,item.invalid_time,item.id,item.member_id)"
                                                                    data-target="#myModals6">修改
                                                            </button>
                                                            &nbsp;
                                                            <button class="btn btn-sm btn-danger"
                                                                    ng-click="delMemberCard(item.id)">删除
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <?= $this->render('@app/views/common/pagination.php', ['page' => 'memberCardPages']); ?>
                                                <?= $this->render('@app/views/common/nodata.php', ['name' => 'memberCardNoDataShow', 'text' => '无会员卡记录', 'href' => true]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-4" class="tab-pane">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title">
                                            <h5>团课信息列表</h5>
                                        </div>
                                        <div class="ibox-content" style="padding: 0">
                                            <div id="DataTables_Table_0_wrapper"
                                                 class="dataTables_wrapper form-inline a26" role="grid">
                                                <table
                                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                    id="DataTables_Table_0"
                                                    aria-describedby="DataTables_Table_0_info"
                                                    style="position: relative;">
                                                    <thead>
                                                    <tr role="row">
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                                            style="width: 100px;">卡名称
                                                        </th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                                            style="width: 100px;">课程
                                                        </th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                                            style="width: 100px;">场地
                                                        </th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                                            style="width: 140px;">日期时间
                                                        </th>
                                                        <!--                                                            <th class="sorting"tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序" style="width: 100px;">上课总次数</th>-->
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                                            style="width: 100px;">上课情况
                                                        </th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                                            style="width: 100px;">教练
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr ng-repeat='group in groups'>
                                                        <td>{{group.card_name}}</td>
                                                        <td>{{group.name | noData:''}}</td>
                                                        <td>{{group.className | noData:''}}</td>
                                                        <td>{{group.class_date |
                                                            noData:''}}&nbsp{{group.start*1000 | date:'HH:mm' }}
                                                        </td>
                                                        <!--                                                            <td>{{group.classRecord.length  | noData:''}}</td>-->
                                                        <td><span  ng-if=group.status==1>未上课</span>
                                                            <span  ng-if=group.status==2>已取消</span>
                                                            <span  ng-if=group.status==3>已上课</span>
                                                            <span  ng-if=group.status==4>已下课</span>
                                                            <span  ng-if=group.status==5>已过期</span>
                                                            <span  ng-if=group.status==6>已缺课</span>
                                                        </td>
                                                        <td>{{group.employeeName | noData:''}}</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                                <?= $this->render('@app/views/common/pagination.php', ['page' => 'groupPages']); ?>
                                                <?= $this->render('@app/views/common/nodata.php', ['name' => 'groupNoDataShow', 'text' => '无团课记录', 'href' => true]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-5" class="tab-pane">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title">
                                            <h5>柜子信息列表</h5>
                                        </div>
                                        <div class="ibox-content" style="padding: 0;">
                                            <div id="DataTables_Table_0_wrapper"
                                                 class="dataTables_wrapper form-inline a26" role="grid">
                                                <table
                                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                    id="DataTables_Table_0"
                                                    aria-describedby="DataTables_Table_0_info"
                                                    style="position: relative;">
                                                    <thead>
                                                    <tr role="row">
                                                        <th class="sorting a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">柜子名称
                                                        </th>
                                                        <th class="sorting a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">柜号
                                                        </th>
                                                        <th class="sorting a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">租用天数
                                                        </th>
                                                        <th class="sorting a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">到期日期
                                                        </th>
                                                        <th class="sorting a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">金额
                                                        </th>
                                                        <th class="sorting a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">经办人
                                                        </th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序"
                                                            style="width: 140px;">操作
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr ng-repeat='cabinet in cabinets'>
                                                        <td>{{cabinet.cabinet.cabinetType.type_name |
                                                            noData:''}}
                                                        </td>
                                                        <td>{{cabinet.cabinet.cabinet_number | noData:''}}</td>
                                                        <td>{{cabinet.start_rent *1000 | noData:''|
                                                            date:'yyyy/MM/dd'}} - {{cabinet.end_rent *1000 |
                                                            noData:''| date:'yyyy/MM/dd'}}
                                                        </td>
                                                        <td>{{cabinet.end_rent *1000 | noData:''|
                                                            date:'yyyy/MM/dd'}}
                                                        </td>
                                                        <td>{{cabinet.price | noData:'元'}}</td>
                                                        <td>
                                                            {{cabinet.employee.name}}
                                                        </td>
                                                        <td>
                                                            <!--                                                                <button class="btn-sm btn btn-success" data-toggle="modal" data-target="#myModals8">修改</button>-->
                                                            &nbsp;
                                                            <button ng-disabled="MemberStatusFlag == '2'" class="btn btn-sm btn-danger"
                                                                    ng-click="delMemberCabinet(cabinet.memberCabinetId)">
                                                                删除
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <?= $this->render('@app/views/common/pagination.php', ['page' => 'cabinetPages']); ?>
                                                <?= $this->render('@app/views/common/nodata.php', ['name' => 'cabinetNoDataShow', 'text' => '无柜子记录', 'href' => true]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-7" class="tab-pane">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title">
                                            <h5>请假列表</h5>
                                        </div>
                                        <div class="ibox-content" style="padding: 0">
                                            <div id="DataTables_Table_0_wrapper"
                                                 class="dataTables_wrapper form-inline a26" role="grid">
                                                <table
                                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                    id="DataTables_Table_0"
                                                    aria-describedby="DataTables_Table_0_info"
                                                    style="position: relative;">
                                                    <thead>
                                                    <tr role="row">
                                                        <th class="sorting a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">登记时间
                                                        </th>
                                                        <th class="sorting a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">请假时间
                                                        </th>
                                                        <th class="sorting a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">请假时长
                                                        </th>
                                                        <th class="sorting a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">请假事由
                                                        </th>
                                                        <th class="sorting a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">经办人
                                                        </th>
                                                        <th class="sorting a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">销假
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr ng-repeat='vacate in vacates'>
                                                        <td>{{vacate.create_at *1000 | noData:''|
                                                            date:'yyyy/MM/dd'}}
                                                        </td>
                                                        <td>{{vacate.leave_start_time *1000 | noData:''|
                                                            date:'yyyy/MM/dd'}}
                                                        </td>
                                                        <td>{{vacate.leave_length | noData:'天'}}</td>
                                                        <td>{{vacate.note | noData:''}}</td>
                                                        <!--                                                            <td>{{vacate.employee.name | noData:''}}</td>-->
                                                        <td>
                                                            {{vacate.employee.name | noData:''}}
                                                        </td>
                                                        <td>
                                                            <div class="btn btn-sm btn-default" ng-disabled="MemberStatusFlag == '2'"
                                                                 ng-click="removeLeave(vacate.id,vacate.status)">
                                                                {{vacate.status == 1 ?"销假":"已销假"}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <?= $this->render('@app/views/common/pagination.php', ['page' => 'leavePages']); ?>
                                                <?= $this->render('@app/views/common/nodata.php', ['name' => 'leaveNoDataShow', 'text' => '无请假记录', 'href' => true]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-8" class="tab-pane">
                                    <div class="ibox float-e-margins">
                                        <select class="form-control w160" ng-model="selectEntryRecord" ng-change="SelectMessage(selectEntryRecord)"  style="padding-top: 4px;">
                                            <option value="">到场、离场</option>
                                            <option value="1">赠品</option>
                                            <option value="2">行为记录</option>
                                            <option value="3">送人记录</option>
                                        </select>
                                        <div ng-if="selectEntryRecord == ''" >
                                            <div class="ibox-title" style="position: relative;">
                                                <h5>到场、离场记录列表
                                                    <span class="a26" ng-if="entryTime == ''">共进场次数{{count}}次</span>
                                                    <span class="a29" ng-if="entryTime != ''">{{entryTime}}共进场次数{{count}}次</span>
                                                    <input type="text" id='datetimeStart'
                                                           class="input-sm form-control" name="start"
                                                           placeholder="选择日期查看"
                                                           readonly
                                                           style="position:absolute;top: 6px;right: 20px;width: 160px;text-align:left;font-size: 13px;font-weight:normal;cursor: pointer;"
                                                           ng-model="entryTime" ng-change="searchEntry()">
                                                </h5>
                                            </div>
                                            <div class="ibox-content" style="padding: 0">
                                                <div id="DataTables_Table_0_wrapper"
                                                     class="dataTables_wrapper form-inline a26" role="grid">
                                                    <table
                                                        class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                        id="DataTables_Table_0"
                                                        aria-describedby="DataTables_Table_0_info"
                                                        style="position: relative;">
                                                        <thead>
                                                        <tr role="row">
                                                            <th class="sorting a28" tabindex="0"
                                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序">进场时间
                                                            </th>
                                                            <th class="sorting a28" tabindex="0"
                                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序">离场时间
                                                            </th>
                                                            <th class="sorting a28" tabindex="0"
                                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序">总时长
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr ng-repeat='entry in entrys'>
                                                            <td>{{entry.entry_time *1000 | noData:''|
                                                                date:'yyyy/MM/dd HH:mm'}}
                                                            </td>
                                                            <td>{{entry.leaving_time *1000 | noData:''|
                                                                date:'yyyy/MM/dd HH:mm'}}
                                                            </td>
                                                            <td>{{(entry.entry_time*1000) | totalLength:'小时'}}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <?= $this->render('@app/views/common/pagination.php', ['page' => 'entryPages']); ?>
                                                    <?= $this->render('@app/views/common/nodata.php', ['name' => 'entryNoDataShow', 'text' => '无进场记录', 'href' => true]); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div ng-if="selectEntryRecord == 1">
                                            <div class="ibox-content" style="padding: 0;">
                                                <div id="DataTables_Table_0_wrapper"
                                                     class="dataTables_wrapper form-inline a26" role="grid">
                                                    <table
                                                        class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                        id="DataTables_Table_0"
                                                        aria-describedby="DataTables_Table_0_info"
                                                        style="position: relative;">
                                                        <thead>
                                                        <tr role="row">
                                                            <th class="a28" tabindex="0"
                                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序">物品名称
                                                            </th>
                                                            <th class="a28" tabindex="0"
                                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序">数量
                                                            </th>
                                                            <th class="a28" tabindex="0"
                                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序">赠送日期
                                                            </th>
                                                            <th class="a28" tabindex="0"
                                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序">领取日期
                                                            </th>
                                                            <th class="a28" tabindex="0"
                                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序">操作
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr ng-repeat="x in giftList">
                                                            <td>{{x.name|noData:''}}</td>
                                                            <td>
                                                                <span ng-if="x.num != '-1' && x.num != -1">{{x.num}}</span>
                                                                <span ng-if="x.num == '-1' || x.num == -1">不限</span>
                                                            </td>
                                                            <td>
                                                                <span ng-if="x.create_at != null && x.create_at != ''">{{x.create_at*1000|date:'yyyy-MM-dd HH:mm:ss'}}</span>
                                                                <span ng-if="x.create_at == null && x.create_at == ''">暂无数据</span>
                                                            </td>
                                                            <td>
                                                                <span ng-if="x.get_day != null && x.get_day != ''">{{x.get_day*1000|date:'yyyy-MM-dd HH:mm:ss'}}</span>
                                                                <span ng-if="x.get_day == null && x.get_day == ''">暂无数据</span>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-success w100 btn-sm" ng-click="receiveGift(x.id)" ng-if="x.status == 1">领取</button>
                                                                <span ng-if="x.status ==2">已领取</span>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <?= $this->render('@app/views/common/pagination.php', ['page' => 'giftPages']); ?>
                                                    <?= $this->render('@app/views/common/nodata.php', ['name' => 'giftNoDataShow', 'text' => '无赠品记录', 'href' => true]); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div ng-if="selectEntryRecord == 2">
                                            <div class="ibox-content" style="padding: 0;">
                                                <div id="DataTables_Table_0_wrapper"
                                                     class="dataTables_wrapper form-inline a26" role="grid">
                                                    <table
                                                        class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                        id="DataTables_Table_0"
                                                        aria-describedby="DataTables_Table_0_info"
                                                        style="position: relative;">
                                                        <thead>
                                                        <tr role="row">
                                                            <th class=" a28" tabindex="0"
                                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序">行为
                                                            </th>
                                                            <th class=" a28" tabindex="0"
                                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序">时间
                                                            </th>
                                                            <th class=" a28" tabindex="0"
                                                                aria-controls="DataTables_Table_0" rowspan="1"
                                                                colspan="1" aria-label="浏览器：激活排序列升序">备注
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr ng-repeat="behaviorRecord in  behaviorRecordLists">
                                                            <td>
                                                                <span ng-if="behaviorRecord.behavior =='1'">冻结</span>
                                                                <span ng-if="behaviorRecord.behavior =='2'">解冻</span>
                                                                <span ng-if="behaviorRecord.behavior =='3'">延期</span>
                                                            </td>
                                                            <td>{{behaviorRecord.create_at*1000 |date:'yyyy-MM-dd HH:mm:ss'}}</td>
                                                            <td>{{behaviorRecord.note |noData:''}}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <?=$this->render('@app/views/common/nodata.php',['name'=>'behaviorRecordFlag','text'=>'暂无数据','href'=>true]);?>
                                                    <?=$this->render('@app/views/common/pagination.php',['page'=>'behaviorRecordPages']);?>
                                                </div>
                                            </div>
                                        </div>
                                        <div ng-if="selectEntryRecord == 3">
                                            <div class="ibox-content"
                                                 style="padding: 0;">
                                                <div id="DataTables_Table_0_wrapper"
                                                     class="dataTables_wrapper form-inline a26"
                                                     role="grid">
                                                    <table
                                                        class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                        id="DataTables_Table_0"
                                                        aria-describedby="DataTables_Table_0_info"
                                                        style="position: relative;">
                                                        <thead>
                                                        <tr role="row">
                                                            <th class=" a28"
                                                                tabindex="0"
                                                                aria-controls="DataTables_Table_0"
                                                                rowspan="1"
                                                                colspan="1" a
                                                                ria-label="浏览器：激活排序列升序">卡名称
                                                            </th>
                                                            <th class=" a28"
                                                                tabindex="0"
                                                                aria-controls="DataTables_Table_0"
                                                                rowspan="1"
                                                                colspan="1"
                                                                aria-label="浏览器：激活排序列升序">卡号
                                                            </th>
                                                            <th class=" a28"
                                                                tabindex="0"
                                                                aria-controls="DataTables_Table_0"
                                                                rowspan="1"
                                                                colspan="1"
                                                                aria-label="浏览器：激活排序列升序">被赠送人
                                                            </th>
                                                            <th class=" a28"
                                                                tabindex="0"
                                                                aria-controls="DataTables_Table_0"
                                                                rowspan="1"
                                                                colspan="1"
                                                                aria-label="浏览器：激活排序列升序">赠送时间
                                                            </th>

                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr ng-repeat="xx in  memberSendCardList">
                                                            <td>{{xx.card_name}}</td>
                                                            <td>{{xx.card_number}}</td>
                                                            <td>{{xx.name}}</td>
                                                            <td>{{xx.send_time*1000 |date:'yyyy-MM-dd'}}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <?=$this->render('@app/views/common/nodata.php',['name'=>'payNoSendCardRecordDataShow','text'=>'暂无送人记录','href'=>true]);?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-13" class="tab-pane">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title">
                                            <h5>消费记录列表</h5>
                                        </div>
                                        <div class="ibox-content" style="padding: 0">
                                            <div id="DataTables_Table_0_wrapper"
                                                 class="dataTables_wrapper form-inline a26" role="grid">
                                                <table
                                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                    id="DataTables_Table_0"
                                                    aria-describedby="DataTables_Table_0_info"
                                                    style="position: relative;">
                                                    <thead>
                                                    <tr role="row">
                                                        <th class="sorting a28" tabindex="0" ng-click="recordsOfConsumption('member_consumptionDate',sort)"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">消费时间
                                                        </th>
                                                        <th class="sorting a28" tabindex="0" ng-click="recordsOfConsumption('member_memberType',sort)"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">消费方式
                                                        </th>
                                                        <th class="sorting a28" tabindex="0" ng-click="recordsOfConsumption('member_consumptionAmount',sort)"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">消费金额/次数
                                                        </th>
                                                        <th class="sorting a28" tabindex="0" ng-click="recordsOfConsumption('member_consumptionType',sort)"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">项目
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr ng-repeat='expense in expenses'>
                                                        <td>{{expense.consumption_date *1000 | noData:''|
                                                            date:'yyyy/MM/dd'}}
                                                        </td>
                                                        <td><span ng-if=expense.type==1>现金</span>
                                                            <span ng-if=expense.type==2>次卡</span>
                                                            <span ng-if=expense.type==3>充值卡</span></td>
                                                        <td><span ng-if=expense.type==1>{{expense.consumption_amount | noData:'元'}}</span>
                                                            <span ng-if=expense.type==2>{{expense.consumption_times | noData:'次'}}</span>
                                                            <span ng-if=expense.type==3>{{expense.consumption_amount | noData:'元'}}</span>
                                                        </td>
                                                        <td>{{expense.category | noData:''}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
<!--                                                <?//= $this->render('@app/views/common/pagination.php', ['page' => 'payPages']); ?> -->
                                                <?= $this->render('@app/views/common/nodata.php', ['name' => 'payNoDataShow', 'text' => '无消费记录', 'href' => true]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-14" class="tab-pane">
                                    <div class="ibox-content" style="padding: 0;border: none;">
                                        <div class="col-sm-12 pd0">
                                            <div class="col-sm-5">
                                                <img src="/plugins/user/images/default.png" width="300px"
                                                     height="190px">
                                            </div>
                                            <div class="col-sm-7" style="padding-left: 0;">
                                                <p class="a30">{{privateLessonTemplet.name}}
                                                    <!--                                                        <span class="label label-info" style="margin-left: 10px;">正常</span>-->
                                                    <select class="btn btn-white wSelectAddHiH pull-right"
                                                            ng-change="privateLessonSelectClick(privateLessonSelect)"
                                                            ng-model="privateLessonSelect">
                                                        <option ng-if="w.name == null||w.name == ''" class="optionNoDataClassXixi" value="xixi">
                                                            暂无数据
                                                        </option>
                                                        <option ng-if="w.name != null" value="{{w.orderId}}"
                                                                ng-repeat="w in privateLessonInformations">
                                                            {{w.name}}
                                                        </option>
                                                    </select>
                                                </p>
                                                <p class="mT10"
                                                   ng-if="privateLessonTemplet.money_amount != null">
                                                    课程金额:{{privateLessonTemplet.money_amount}}</p>
                                                <p class="mT10"
                                                   ng-if="privateLessonTemplet.money_amount == null">课程金额:暂无数据</p>
                                                <p class="mT10"
                                                   ng-if="privateLessonTemplet.course_amount != null">
                                                    总计节数:{{privateLessonTemplet.course_amount}}</p>
                                                <p class="mT10"
                                                   ng-if="privateLessonTemplet.course_amount == null">
                                                    总计节数:暂无数据</p>
                                                <p class="mT10"
                                                   ng-if="privateLessonTemplet.overage_section != null">
                                                    剩余节数:{{privateLessonTemplet.overage_section}}</p>
                                                <p class="mT10"
                                                   ng-if="privateLessonTemplet.overage_section == null">
                                                    剩余节数:暂无数据</p>
                                                <p class="mT10"
                                                   ng-if="privateLessonTemplet.deadline_time !=null">
                                                    到期时间:{{privateLessonTemplet.deadline_time * 1000|
                                                    date:'yyyy-MM-dd'}}</p>
                                                <p class="mT10"
                                                   ng-if="privateLessonTemplet.deadline_time ==null">
                                                    到期时间:暂无数据</p>
                                                <div class="col-sm-12 pd0 mT10" ng-if="privateLessonTemplet != null">
                                                    <div ng-if="privateLessonTemplet.cloudOrderId == undefined">
<!--                                                        <button class="btn btn-success text-center a32" ng-disabled="MemberStatusFlag == '2' || privateLessonTemplet.money_amount == null"-->
<!--                                                                ng-click="privateBuy()" >续费-->
<!--                                                        </button>-->
                                                        <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'CHANGECLASS')) { ?>
                                                        <button class="btn text-center a33" ng-disabled="MemberStatusFlag == '2' || privateLessonTemplet.money_amount == null"
                                                                ng-click="transfer()">转课</button>
                                                        <?php } ?>
                                                        <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DELAY')) { ?>
                                                        <button style="background-color: #999;" class="a33 btn text-center btn-sm "  ng-disabled="MemberStatusFlag == '2' || privateLessonTemplet.money_amount == null"
                                                                ng-click="postpone()">延期</button>
                                                        <?php } ?>
                                                    </div>

                                                    <div ng-if="privateLessonTemplet.cloudOrderId != undefined">
                                                        <span>私教课程已退费</span>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-sm-12 a3 mrt10">
                                                <div class="ibox float-e-margins">
<!--                                                    <div class="ibox-title" style="position: relative;">-->
<!--                                                        <p style="font-size: 17px;"><span id="renew" class="" ng-click="addColor1()">续费记录</span><span id="privateEducation" class="ml25 addColor" ng-click="addColor2()">私教</span></p>-->
<!--                                                    </div>-->

                                                    <select class="form-control" style="width: 140px;padding-top: 4px;" ng-model="iboxCcontentModel">
                                                        <option value="">约课记录</option>
                                                        <option value="1">续费记录</option>
                                                        <option value="2">私教</option>
                                                    </select>
                                                    <div ng-if="iboxCcontentModel == ''" class="ibox-content " style="padding: 0;">
                                                        <div id="DataTables_Table_0_wrapper"
                                                             class="dataTables_wrapper form-inline a26"
                                                             role="grid">
                                                            <table
                                                                class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                                id="DataTables_Table_0"
                                                                aria-describedby="DataTables_Table_0_info">
                                                                <thead>
                                                                <tr role="row">
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                                        style="width: 100px;">上课时间
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                                        style="width: 120px;">总节数/剩余节数
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                                        style="width: 120px;">课程类型
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                                        style="width: 120px;">上课时长
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                                        style="width: 100px;">上课教练
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                                        style="width: 120px;">状态
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr ng-repeat='w in appointmentRecord'>
                                                                    <td>
                                                                        {{w.start *1000  | date:'yyyy-MM-dd HH:mm'}}
                                                                    </td>
                                                                    <td>
                                                                        <span>{{w.memberCourseOrderDetails.memberCourseOrder.course_amount}}</span>/<span>{{w.memberCourseOrderDetails.memberCourseOrder.overage_section}}</span>
                                                                    </td>
                                                                    <td >
                                                                        <span ng-if="w.memberCourseOrderDetails.category == 1">多课程 </span>
                                                                        <span ng-if="w.memberCourseOrderDetails.category == 2">单课程</span>
                                                                    </td>
                                                                    <td >
                                                                        {{w.memberCourseOrderDetails.class_length}}
                                                                    </td>
                                                                    <td>
                                                                        {{w.employee.name}}
                                                                    </td>
                                                                    <td >
                                                                        <span ng-if="w.status ==2"> 已取消</span>
                                                                        <span ng-if="w.status ==3"> 上课中</span>
                                                                        <span ng-if="w.status ==4">已下课 </span>
                                                                        <span ng-if="w.status ==6"> 旷课</span>
                                                                        <span ng-if="w.status == 1 && appointmentRecordDate < w.start*1000">待审核 </span>
                                                                        <span ng-if="w.status == 1 && appointmentRecordDate > w.end*1000">已过期</span>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            <?= $this->render('@app/views/common/pagination.php', ['page' => 'appointmentRecordPages']); ?>
                                                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'appointmentRecordShow', 'text' => '无约课记录', 'href' => true]); ?>
                                                        </div>
                                                    </div>
                                                    <div ng-if="iboxCcontentModel == 1" class="ibox-content " style="padding: 0;">
                                                        <div id="DataTables_Table_0_wrapper"
                                                             class="dataTables_wrapper form-inline aa26"
                                                             role="grid">
                                                            <table
                                                                class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                                id="DataTables_Table_0"
                                                                aria-describedby="DataTables_Table_0_info"
                                                                style="position: relative;">
                                                                <thead>
                                                                <tr role="row">
                                                                    <th class="sorting a28" tabindex="0"
                                                                        aria-controls="DataTables_Table_0"
                                                                        rowspan="1" colspan="1"
                                                                        aria-label="浏览器：激活排序列升序">缴费时间
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0"
                                                                        rowspan="1" colspan="1"
                                                                        aria-label="浏览器：激活排序列升序"
                                                                        style="width: 80px;">缴费名称
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0"
                                                                        rowspan="1" colspan="1"
                                                                        aria-label="浏览器：激活排序列升序"
                                                                        style="width: 60px;">缴费金额
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0"
                                                                        rowspan="1" colspan="1"
                                                                        aria-label="浏览器：激活排序列升序"
                                                                        style="width: 60px;">客服
                                                                    </th>
                                                                    <!--                                                                        <th class="sorting"tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序" style="width: 160px;">有效期</th>-->
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0"
                                                                        rowspan="1" colspan="1"
                                                                        aria-label="浏览器：激活排序列升序"
                                                                        style="width: 60px;">状态
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr ng-repeat="w in renewTheRecordDate">
                                                                    <td>{{w.consumption_date *1000 |
                                                                        date:'yyyy-MM-dd'}}
                                                                    </td>
                                                                    <td>{{w.memberOrderDetails.product_name}}
                                                                    </td>
                                                                    <td>{{w.consumption_amount}}</td>
                                                                    <td>{{w.employee.name}}</td>
                                                                    <!--                                                                        <td>{{w.memberCourseOrder.create_at *1000 | date:'yyyy-MM-dd'}}至{{w.memberCourseOrder.deadline_time *1000 | date:'yyyy-MM-dd'}}</td>-->
                                                                    <td>{{w.category}}</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'payNoMoneyDataShow', 'text' => '无续费记录', 'href' => true]); ?>
                                                        </div>
                                                    </div>
                                                    <div ng-if="iboxCcontentModel == 2" class="ibox-content " style="padding: 0;">
                                                        <div id="DataTables_Table_0_wrapper"
                                                             class="dataTables_wrapper form-inline aa26"
                                                             role="grid">
                                                            <table
                                                                class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                                id="DataTables_Table_0"
                                                                aria-describedby="DataTables_Table_0_info">
                                                                <thead>
                                                                <tr role="row">
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                                        style="width: 100px;">课程
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                                        style="width: 120px;">剩余/总节数
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                                        style="width: 120px;">课程类型
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                                        style="width: 120px;">办理日期
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                                        style="width: 100px;">到期日期
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                                        style="width: 120px;">办理金额
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                                        style="width: 140px;">办理私教
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                                        style="width: 140px;">操作
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr ng-repeat='charge in charges'
                                                                    ng-click="getChargeClassDetail(data.id,charge.id,charge.product_name)">
                                                                    <td data-toggle="modal" data-target="#myModals9">
                                                                        {{charge.product_name | noData:''}}
                                                                    </td>
                                                                    <td data-toggle="modal" data-target="#myModals9">
                                                                        {{charge.overage_section |
                                                                        noData:''}}/{{charge.course_amount | noData:''}}
                                                                    </td>
                                                                    <td data-toggle="modal" data-target="#myModals9" ng-if="charge.course_type == 1">
                                                                        购买
                                                                    </td>
                                                                    <td data-toggle="modal" data-target="#myModals9" ng-if="charge.course_type == 2">
                                                                        赠送
                                                                    </td>
                                                                    <td data-toggle="modal" data-target="#myModals9" ng-if="charge.course_type == null">
                                                                        暂无数据
                                                                    </td>
                                                                    <td data-toggle="modal" data-target="#myModals9">
                                                                        {{charge.create_at *1000 | noData:''|
                                                                        date:'yyyy/MM/dd'}}
                                                                    </td>
                                                                    <td data-toggle="modal" data-target="#myModals9">
                                                                        {{charge.deadline_time *1000 | noData:''|
                                                                        date:'yyyy/MM/dd'}}
                                                                    </td>
                                                                    <td data-toggle="modal" data-target="#myModals9">
                                                                        {{charge.money_amount | noData:'元'}}
                                                                    </td>
                                                                    <td data-toggle="modal" data-target="#myModals9">
                                                                        {{charge.employee.name | noData:''}}
                                                                    </td>
                                                                    <td class="tdBtn2">
                                                                        <!--                                                                <button class="btn-sm btn btn-success" data-toggle="modal" data-target="#myModals7">修改</button>-->
                                                                        &nbsp;
                                                                        <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DELPRIVATE')) { ?>
                                                                        <button class="btn btn-sm btn-danger"
                                                                                ng-click="delChargeClass(charge.id)">删除
                                                                        </button>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            <?= $this->render('@app/views/common/pagination.php', ['page' => 'privatePages']); ?>
                                                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'privateNoDataShow', 'text' => '无私教记录', 'href' => true]); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-10" class="tab-pane">
                                    <div class="ibox chat-view">
                                        <div class="ibox-title">
                                            <h5>跟进维护消息记录</h5>
                                        </div>
                                        <div class="ibox-content" style="padding: 0">
                                            <div class="chat-discussion a26">
                                                <div class="chat-message">
                                                    <img class="message-avatar"
                                                         src="/plugins/user/images/dong.jpg">
                                                    <div class="message">
                                                        销售部:
                                                        <a href="#" class="message-author" style="color: #69e">董成鹏</a>
                                                        <span class="message-date"> 2015-02-02 18:39:23 </span>
                                                        <span class="message-content">用户下次来时成交</span>
                                                    </div>
                                                </div>
                                                <div class="chat-message">
                                                    <img class="message-avatar"
                                                         src="/plugins/user/images/dong.jpg">
                                                    <div class="message">
                                                        销售部:
                                                        <a href="#" class="message-author" style="color: #69e">董成鹏</a>
                                                        <span class="message-date"> 2015-02-02 18:39:23 </span>
                                                        <span class="message-content">用户又不想办这个卡了！！！</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="chat-message-from col-sm-12 pd0 a3">
                                                <div class="form-group col-sm-10 pd0">
                                                                    <textarea name="message"
                                                                              class="form-control"
                                                                              style="resize: none;"
                                                                              placeholder="请输入消息内容"></textarea>
                                                </div>
                                                <div class="col-sm-2 pd0">
                                                    <button class="btn btn-success pull-right"
                                                            style="margin-top: 6px;height: 40px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;发送&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab-11" class="tab-pane">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title">
                                            <h5>消费记录列表</h5>
                                        </div>
                                        <div class="ibox-content" style="padding: 0">
                                            <div id="DataTables_Table_0_wrapper"
                                                 class="dataTables_wrapper form-inline a26" role="grid">
                                                <table
                                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                    id="DataTables_Table_0"
                                                    aria-describedby="DataTables_Table_0_info"
                                                    style="position: relative;">
                                                    <thead>
                                                    <tr role="row">
                                                        <th class="sorting a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">客户名称
                                                        </th>
                                                        <th class="sorting a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">项目
                                                        </th>
                                                        <th class="sorting a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">金额
                                                        </th>
                                                        <th class="sorting a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">时间
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>董成鹏</td>
                                                        <td>办卡</td>
                                                        <td>20000元</td>
                                                        <td>2016-1-1&nbsp;19:00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>董成鹏</td>
                                                        <td>进馆</td>
                                                        <td>无</td>
                                                        <td>2016-1-1&nbsp;19:00</td>
                                                    </tr>
                                                    <tr>
                                                        <td>董成鹏</td>
                                                        <td>私教课办理</td>
                                                        <td>500元</td>
                                                        <td>2016-1-1&nbsp;19:00</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--                                    会员卡详情-->
                                <div id="tab-15" class="tab-pane">
                                    <div class="ibox-content" style="padding: 0;border: none;">
                                        <div class="col-sm-12 pd0">
                                            <div class="col-sm-5" style="position: relative;" ng-mouseleave="noneDetails()">
                                                <img src="../plugins/img/card111.png" width="300px"
                                                     height="190px" ng-mouseover="showDetails()" >
                                                <div class="a34" id="showDetails" data-toggle="modal" data-target="#membershipCardDetails" ng-click="membershipCardDetails(infoId)">点击查看会员卡详情</div>
                                            </div>
                                            <div class="col-sm-7" style="padding-left: 0;">
                                                <p class="a35">{{cardInfo.card_name}}
                                                    <select class="btn-deflut pull-right a36" id="selcetValue"
                                                            ng-change="infoChange(infoId)" ng-model="infoId">
                                                        <option id="noDataOptions"
                                                                value="xixi"
                                                                ng-if="cardInfoItems.length == 0||cardInfoItems[0].card_name == ''||cardInfoItems[0].card_name == undefined">
                                                            暂无数据
                                                        </option>
                                                        <option ng-repeat="card in cardInfoItems"
                                                                value="{{card.id}}"
                                                                ng-if="card.card_name != null">
                                                            {{card.card_name}}
                                                        </option>
                                                    </select>
                                                </p>
                                                <!--                                                        <p style="margin-bottom: 10px" ng-if="cardInfo.card_number != null"  ng-model="clearBina">编号:{{cardInfo.member_id}}</p>-->
                                                <!--                                                        <p style="margin-bottom: 10px" ng-model="clearBina" ng-if="cardInfo.card_number == null">编号:暂无数据</p>-->
                                                <p class="a37" ng-if="cardInfo.card_number != null"
                                                   ng-model="clearBina">会员卡号:{{cardInfo.card_number}}</p>
                                                <p class="a37" ng-if="cardInfo.card_number == null"
                                                   ng-model="clearBina">会员卡号:暂无数据</p>
                                                <p class="a37" ng-if="cardInfo.amount_money != null"
                                                   ng-model="clearMoney">卡种金额:{{cardInfo.amount_money}}</p>
                                                <!--                                                        <p style="margin-bottom: 10px" ng-if="cardInfo.amount_money == null" ng-model="clearMoney">金额:暂无数据</p>-->
                                                <p class="a37" ng-if="cardInfo.amount_money == null"
                                                   ng-model="clearMoney">卡种金额:暂无数据</p>
                                                <p class="a37" ng-model="clearDays"
                                                   ng-if="cardInfo.duration != null">
                                                    总计天数:{{cardInfo.duration}}</p>
                                                <p class="a37" ng-model="clearDays"
                                                   ng-if="cardInfo.duration == null">总计天数:暂无数据</p>
                                                <!--                                                        <p class="a37" ng-if="cardActiveTime == null" ng-model="clearDays">总天数:此卡未激活啊啊</p>-->
                                                <p class="a38" ng-if="cardInfo.active_time != null"
                                                   ng-model="clearTime">到期时间:{{cardInfo.invalid_time*1000|date:'yyyy-MM-dd'}}</p>
                                                <p class="a38" ng-if="cardInfo.active_time == null"
                                                   ng-model="clearTime">到期时间:此卡未激活</p>

                                                <div class="col-sm-12 pd0" ng-if="cardInfo.orderId == undefined">
                                                    <button class="btn btn-primary a39"
                                                            ng-click="bindingUser(cardInfo.id,cardInfo.card_category_id)"
                                                            ng-if="cardInfo.usage_mode == '2' && cardInfo.status != '2'"
                                                    >绑定会员</button>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'MEMBERCARDUPDATE')) { ?>
                                                        <button class="btn btn-primary a39"
                                                                ng-disabled="MemberStatusFlag == '2'"
                                                                ng-click="updateCardNumber(cardInfo.id,cardInfo.card_number,cardInfo.invalid_time)"
                                                                ng-if="cardInfo.usage_mode != '2'"
                                                                data-toggle="modal"
                                                                data-target="#myModals18">修改
                                                        </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'RENEW')) { ?>
                                                    <button class="btn btn-success a39" data-toggle="modal"
                                                            data-target="#myModals15"
                                                            ng-click="renrewCard(cardInfo.id)"
                                                            ng-if="cardNameNot != ''&& cardNameNot !=undefined && cardNameNot != null && allTimesRenewCard >= timestamp && cardInfo.status != '2'">
                                                        续费
                                                    </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'UPGRADE')) { ?>
                                                    <button class="btn btn-warning a39" data-toggle="modal"
                                                            data-target="#memberCardUpgradeModal"
                                                            ng-click="updateCard(cardInfo.id,cardInfo.card_category_id,cardInfo.create_at)"
                                                            ng-if="cardNameNot != ''&& cardNameNot !=undefined && cardNameNot != null && cardInfo.status != '2' && cardInfo.cardCategory.cardCategoryType.id == '1'">
                                                        升级
                                                    </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'CHANGECARD')) { ?>
                                                    <button class="btn btn-default a39" ng-disabled="MemberStatusFlag == '2'"
                                                            ng-click="zhuanCard(cardInfo.id)"
                                                            data-toggle="modal" data-target="#myModals17"
                                                            ng-if="cardNameNot != ''&& cardNameNot !=undefined && cardNameNot != null && cardInfo.usage_mode != '2' && cardInfo.status != '2'">
                                                        转卡
                                                    </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'FREEZECARD')) { ?>
                                                        <button class="btn btn-danger a39 freezeButton"
                                                                ng-click="freezeMemberCardBtn(cardInfo.id,cardInfo.status)"
                                                                ng-if="cardInfo.status != 2">
                                                            冻结
                                                        </button>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-sm-12 pd0" ng-if="cardInfo.orderId != undefined">
                                                    <span>此卡已经退费</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 a3 mrt20">
                                                <div class="ibox float-e-margins">
                                                    <div class="ibox-title" style="position: relative;">
                                                        <h5>缴费记录</h5>
                                                    </div>
                                                    <div class="ibox-content" style="padding: 0;">
                                                        <div id="DataTables_Table_0_wrapper"
                                                             class="dataTables_wrapper form-inline aa26"
                                                             role="grid">
                                                            <table
                                                                class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                                id="DataTables_Table_0"
                                                                aria-describedby="DataTables_Table_0_info"
                                                                style="position: relative;">
                                                                <thead>
                                                                <tr role="row">
                                                                    <th class="sorting a28" tabindex="0"
                                                                        aria-controls="DataTables_Table_0"
                                                                        rowspan="1" colspan="1"
                                                                        aria-label="浏览器：激活排序列升序">缴费时间
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0"
                                                                        rowspan="1" colspan="1"
                                                                        aria-label="浏览器：激活排序列升序"
                                                                        style="width: 80px;">缴费名称
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0"
                                                                        rowspan="1" colspan="1"
                                                                        aria-label="浏览器：激活排序列升序"
                                                                        style="width: 60px;">缴费金额
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0"
                                                                        rowspan="1" colspan="1"
                                                                        aria-label="浏览器：激活排序列升序"
                                                                        style="width: 60px;">客服
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0"
                                                                        rowspan="1" colspan="1"
                                                                        aria-label="浏览器：激活排序列升序"
                                                                        style="width: 160px;">到期日期
                                                                    </th>
                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="DataTables_Table_0"
                                                                        rowspan="1" colspan="1"
                                                                        aria-label="浏览器：激活排序列升序"
                                                                        style="width: 60px;">行为
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr ng-repeat="info in paymentItems">
                                                                    <td>{{(info.consumption_date)*1000 |
                                                                        date:"yyyy/MM/dd"}}
                                                                    </td>
                                                                    <td>{{info.card_name}}</td>
                                                                    <td>{{info.consumption_amount}}</td>
                                                                    <td>{{info.name}}</td>
                                                                    <td>
                                                                        <span ng-if="cardActiveTime != null">{{(info.invalid_time*1000) | date:"yyyy/MM/dd"}}</span>
                                                                                <span
                                                                                    ng-if="cardActiveTime == null">未激活</span>
                                                                    </td>
                                                                    <td>{{info.category}}</td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'payNoMoneyDataShow', 'text' => '无消费记录', 'href' => true]); ?>
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
        </div>
    </div>

<!--    延期模态框-->
    <div class="modal fade bs-example-modal-lg" id="postponeModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">延期</h4>
                </div>
                <div class="modal-body">
                   <div class="row">
                       <div class="col-sm-12 ">
                           <ul>
                               <li class="col-sm-12 text-center"><img src="/plugins/img/exclamation.png " alt="" style="width: 100px;"></li>
                               <li class="col-sm-12 text-center mT10" style="font-size: 16px;color: #999;">本操作将会把会员 <span style="color: #000;font-size: 18px;">{{privateLessonTemplet.name}}</span>剩余<span style="color: #000;font-size: 18px;">{{privateLessonTemplet.overage_section}}</span>节进行延期</li>
                               <li class="col-sm-12 text-center mT10" style="display: flex;justify-content: center;color:#999;">
                                       <div style="display: flex;align-items: center"><span style="color:red;">*</span>延期天数&emsp;&emsp;</div>
                                       <div><input ng-change="postponeDaysBlur(postponeDays123)" ng-model="postponeDays123" style="width: 200px;" type="number" class="form-control" inputnum placeholder="几天"></div>
                               </li>
                               <li class="col-sm-12 text-center mT10">
                                   <span style="opacity: 0;">延期</span>
                                   <span style="color:#999;" >到期日期为 <span style="color:#ff9933;">{{postponeEndTime123}}</span></span>
                               </li>
                           </ul>
                       </div>
                   </div>
                </div>
                <div class="modal-footer">
                    <button ladda="postponeBtnFlag" style="width: 100px;" type="button" class="btn btn-success btn-sm" ng-click="postponeBtnSubmit()">确定</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="myModalsLeave" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content clearfix" style="width: 800px">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h3 class="text-center a40" id="myModalLabel">
                        请假
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12 dataId a41">
                        <div class="col-sm-3 text-left a42">
                            <div class="a43">
                                <img ng-src="{{MemberData.pic}}" ng-if="MemberData.pic!=null"
                                     style="width: 150px;height: 150px">
                            </div>
                            <div class="a44" style="margin-bottom: 20px">
                                <img src="/plugins/checkCard/img/11.png" ng-if="MemberData.pic==null"
                                     style="width: 150px;height: 150px;margin-bottom: 20px">
                            </div>
                            <h4 style="margin-left: 32px;margin-top: 10px;font-size: 16px">姓名:<span>{{MemberData.name}}</span>
<!--                                <span-->
<!--                                    class="a45">{{memberFlag}}</span></h4>-->
                            <div class="a46">总计天数:{{allDays}}天</div>
                            <div class="a46">剩余天数: <span>{{limitedDays}}</span>天</div>
                        </div>
                        <div class="col-sm-1 a47"></div>
                        <div class="col-sm-8 a47">
                            <!--                                请假类型-->
                            <div class="col-sm-12 mT20 hCenter" >
                                <div class="col-sm-4" style="margin-left: -5px">
                                    <strong style="color: red">*</strong>请假类型
                                </div>
                                <div class="col-sm-8 " >
                                    <select  style="padding: 4px 12px;" id="selectLeaveType" ng-change="selectLeaveType(leaveTypeChecked)" ng-model="leaveTypeChecked"  class="form-control a48 ">
                                        <option value="">请选择请假类型</option>
                                        <option value="1">正常请假</option>
                                        <option value="2">特殊请假</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 mT20 hCenter">
                                <div class="col-sm-4" style="margin-left: -5px">
                                    <strong style="color: red">*</strong>选择卡种
                                </div>
                                <div class="col-sm-8">
                                    <select name="" id="selectCard" ng-change="selectOneMemberCard(card_id)"
                                            ng-model="card_id" class="form-control a48" style="padding: 4px 12px;">
                                        <option value="">请选择会员卡</option>
                                        <option ng-repeat="card in cards" value="{{card.id}}">{{card.card_name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!--                            新增-->
                            <div class="col-sm-12 mT20 hCenter" ng-if="leaveData1 && leaveTypeChecked =='1'">
                                <div class="col-sm-4" style="margin-left: -5px">
                                    <strong style="color: red">*</strong>请选择请假天数
                                </div>
                                <div class="col-sm-8">
                                    <select id="selectLeaveDays" ng-change="selectLeaveDaysOne(leave1)"
                                            ng-model="leave1" class="form-control a48">
                                        <option value="" ng-selected="morenFlag">请选择请假天数</option>
                                        <option ng-if="LeaveDays != '' && LeaveDays != null"
                                                ng-repeat="(key,leave) in LeaveDays" value={{key}}>
                                            请假{{leave[0]}}天，还剩{{leave[1]}}次
                                        </option>
                                        <option
                                            ng-if="leaveTotalDays != '' && leaveLeastDays != ''&& leaveTotalDays != null && leaveLeastDays != null"
                                            value="aaa">可以请假{{leaveTotalDays}}天，最少请假{{leaveLeastDays}}天
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!--                            新增请假开始日期-->
                            <div class="col-sm-12 hCenter" style="margin-top: 20px">
                                <div class="col-sm-4" style="margin-left: -5px">
                                    <strong style="color: red">*</strong>开始日期
                                </div>
                                <div class="col-sm-8 mLF26">
                                    <div class="input-append date " id="dataLeave1" data-date-format="yyyy-mm-dd">
                                        <input readonly class=" form-control h30" type="text"
                                               ng-change="startLeaveDate(startLeaveDay)" placeholder="请选择开始日期"
                                               ng-model="startLeaveDay"/>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 hCenter" style="margin-top: 20px">
                                <div class="col-sm-4" style="margin-left: -5px">
                                    <strong style="color: red">*</strong>结束日期
                                </div>
                                <div class="col-sm-8 mLF26">
                                    <div class="input-append date " id="dataLeaveEnd" data-date-format="yyyy-mm-dd">
                                        <input readonly class=" form-control h30" ng-disabled="endLeaveFlag" type="text"
                                               ng-change="endLeaveDate(endLeaveDay)" placeholder="请选择结束日期"
                                               ng-model="endLeaveDay"/>
                                        <span class="add-on"><i class="icon-th"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mT20 hCenter"  ng-if="leaveTypeChecked =='2'&& endLeaveDay !=''&& startLeaveDay !=''&& leaveDays123 >0  ">
                                <div class="col-sm-4" style="margin-left: -5px">
                                    <strong style="color: red;opacity: 0">*</strong>结束日期
                                </div>
                                <div class="col-sm-8 mLF26" >
                                    <span class="f16" style="color: #FF9900;">{{leaveDays123}} </span>天
                                </div>
                            </div>
                            <div class="col-sm-12 userNote">
                                <div class="col-sm-4" style="margin-left: -1px">
                                    备注内容
                                </div>
                                <div class="col-sm-8">
                                    <textarea id="leaveCause" class="a50" style="resize: none;"></textarea>
                                    <div style="margin-bottom: 10px;color: #999;margin-left: -26px">请假说明:</div>
                                    <div class="a51">1.系统会在请假开始时间到达时自动执行此次请假</div>
                                    <div class="a51">2.会员如果在请假时间内签到，会员可以手动结束请假</div>
                                    <div class='a51'>3.当请假天数结束时，会员的请假会自动结束</div>
                                    <!--                                        <div style="margin-bottom: 10px;color: #999;margin-left: -26px;"><p>4.例:<b>'2017-05-20'</b>日请假,选择日期为 <strong>2017-05-20 - 2017-05-21</strong></p> </div>-->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer" style="border-top: none;">
                    <center>
                        <button ng-click="submitLeave(memberData.id)"
                                type="button"
                                class="btn btn-success  btn-sm a52"
                                ladda="laddaButton">
                            <span ng-if="leaveTypeChecked != '2'">完成</span><span ng-if="leaveTypeChecked == '2'">提交申请</span>
                        </button>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!--私教购买-->
    <div class="modal fade" id="privateBuyModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="width: 720px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">私教课程购买</h4>
                </div>
                <div class="modal-body" style="padding-top: 50px;">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-5 text-left"
                                 style="border-right: solid 1px #e5e5e5;padding-bottom: 10px;">
                                <div class='a55'>
                                    <img ng-src="{{aboutClassData.pic}}" class="a53" ng-if="aboutClassData.pic!=null"
                                         style="border-radius: 50%">
                                </div>
                                <div class="a54">
                                    <img src="/plugins/checkCard/img/11.png" class="a53"
                                         ng-if="aboutClassData.pic==null">
                                </div>
                                <div style="margin-top: 20px;">
                                    <ul class="MemberMess">
                                        <li><h4>会员姓名:<span style="font-size: 14px;">{{aboutClassData.name}}</span></h4>
                                        </li>
                                        <li>会员性别:<span>{{aboutClassData.sex == 1 ? "男":"女"|noData:''}}</span></li>
                                        <li>会员年龄:<span>{{aboutClassData.birth_date | birth | noData:''}}</span></li>
                                        <li>会员生日:<span>{{aboutClassData.birth_date | noData:''}}</span></li>
                                        <li>身份证号:<span>{{aboutClassData.id_card | noData:''}}</span></li>
                                        <li>手机号码:<span>{{aboutClassData.mobile | noData:''}}</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-6 col-sm-offset-1" style="color: #999999;font-size: 12px;">
                                <div>
                                    <ul class="" style="display: flex;align-items: center;">
                                        <li class=""><span class="red">*</span>私教产品</li>
                                        <li class=" mL20">
                                            <div class="clearfix a56" style="">
                                                <div class="fl a57">
                                                    <img ng-src="{{blendPic}}" width="50px" height="100%" alt=""
                                                         ng-if="blendPic != null">
                                                </div>

                                                <div ng-click="buyPrivateCourse()" class="fl text-center cp"
                                                     style="width: 115px; height: 50px;line-height: 50px;text-align: center;">
                                                    {{trues == true ? blendName:"购买私教产品"}}
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div style="margin-top: 10px;">
                                    <ul class="" style="display: flex;align-items: center;">
                                        <li><span class="red">*</span>课程数量</li>
                                        <li class=" mL20" style="width: 170px;">
                                            <input type="number" class="form-control" placeholder="请输入课程数量"
                                                   ng-model="dataCompleteBuy.numberOfCourses"
                                                   ng-blur="courseQuantity(dataCompleteBuy.numberOfCourses)">
                                        </li>
                                    </ul>
                                </div>
                                <div class="mT10">
                                    <ul class="a58">
                                        <li><span class="red">*</span>缴费日期</li>
                                        <li class=" mL20" style="width: 170px;">
                                            <input type="text" class="form-control" id="registerDate"
                                                   data-date-format="yyyy-mm-dd hh:ii" placeholder="请选择登记日期"
                                                   ng-model="dataCompleteBuy.renewalDate">
                                        </li>
                                    </ul>
                                </div>
                                <div class="mT10">
                                    <ul class="a58">
                                        <li><span class="red">*</span>销售私教</li>
                                        <li class=" mL20" style="width: 170px;">
                                            <select id="selectColor" class="form-control cp "
                                                    ng-change="privateCoachs(dataCompleteBuy.sellingPrivateEducation)"
                                                    ng-model="dataCompleteBuy.sellingPrivateEducation"
                                                    style="padding: 4px 12px;">
                                                <option value="" ng-selected>请选择销售私教</option>
                                                <option value="{{w.id}}" ng-repeat="w in privateCoach">{{w.name}}
                                                </option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mT10">
                                    <ul class="a58">
                                        <li><span class="red">*</span>私教渠道</li>
                                        <li class=" mL20" style="width: 170px;">
                                            <select id="marketingChannel" class="form-control cp "
                                                    ng-model="dataCompleteBuy.distributionChannel"
                                                    style="padding: 4px 12px;" >
                                                <option value="">请选择私教渠道</option>
                                                <option ng-selected="addSellSourceId == w.id" data-module="{{w.id}}" value="{{w.value}}" ng-repeat="w in memberSearchData">{{w.value}}</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mT10">
                                    <ul class="a58 " style="display: flex;justify-content: center;">
                                        <button class="btn btn-primary btn-sm" ng-click="addSellSource()">自定义添加</button>
                                        <button class="btn btn-danger btn-sm" ng-click="deleteTheSource()" style="margin-left: 10px;">删除选中来源</button>
                                    </ul>
                                </div>
                                <div class="mT10">
                                    <ul class="a58">
                                        <li><span class="red">*</span>支付方式</li>
                                        <li class=" mL20" style="width: 170px;">
                                            <select id="selectColor" class="form-control cp "
                                                    ng-model="dataCompleteBuy.paymentMethod" style="padding: 4px 12px;">
                                                <option value="">请选择支付方式</option>
                                                <option>微信</option>
                                                <option>支付宝</option>
                                                <option>现金</option>
<!--                                                <option>pos机</option>-->
                                                <option>建设分期</option>
                                                <option>广发分期</option>
                                                <option>招行分期</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mT10">
                                    <ul class="a58">
                                        <li><span class="red">*</span>收款方式</li>
                                        <li class=" mL20" style="width: 170px;">
                                            <select id="selectColor" class="form-control cp " ng-change="gatheringWay(paymentTerm)" ng-model="paymentTerm" style="padding: 4px 12px;">
                                                <option  value="">选择付款方式</option>
                                                <option  value="1">全款</option>
                                                <option ng-if="buyMemberDetail.price != null" value="2">押金</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mT10">
                                    <ul class="a58">
                                        <li><span class="red">*</span>领取赠品</li>
                                        <li class=" mL20" style="width: 170px;">
                                            <select id="selectColor" class="form-control cp " style="padding: 4px 12px;" ng-model="giftStatus">
                                                <option value="">请选择</option>
                                                <option value="2">已领取</option>
                                                <option value="1">未领取</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mT10">
                                    <ul class="a58">
                                        <li><span class="red">*</span><span>应付金额</span></li>
                                        <li class=" mL20" style="width: 170px;text-align: center;margin-left: 20px;">
                                            <input type="number" min="1" class="form-control" id="allMoneyChange" ng-change="allMoneyChange(blendMoney)" placeholder="" ng-model="blendMoney">
                                        </li>
                                    </ul>
                                </div>
                                <div class="mT10" style="text-align: right;" >
                                    <ul >
                                        <li class=" mL20" style="margin-right: 60px;">
                                            <div>
                                                <span>有效期: <b ng-if="monthUpNums != ''"> {{monthUpNums}} 月</b>
                                                    <b ng-if="monthUpNums == ''"> 暂无数据</b>
                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mT10" style="text-align: right;" ng-if="paymentTerm == '2' && blendMoney != 0 && buyMemberDetail.price != null ">
                                    <ul >
                                        <li class=" mL20" style="margin-right: 60px;">
                                            <div>
                                                <span>定金: <b>{{subscription123 != null ?subscription123 : 0}}元</b></span>
                                                <span style="margin-left: 10px;" ng-if=" buyMemberDetail.start_time  <=currentTime && currentTime <= buyMemberDetail.end_time">抵劵: <b>{{voucher123 != null? voucher123:0 }}元</b></span>
                                            </div>
                                            <div style="color: #f9d21a;">
                                                <span style="font-size: 16px;">应补金额:{{PayMoney}}元</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="clearfix mT10">
                                    <button ladda="privateLessonBuyButtonFlag  " ng-click="completeBuy()" id="completeBuy" type="button"
                                            class="btn btn-success btn-sm a59">完成
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--定金-->
    <div class="modal" id="deposit" role="dialog" aria-labelledby="deposit1qq" >
        <div class="modal-dialog" role="document" style="width: 720px;" >
            <div class="modal-content clearfix" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="text-align: center;"  >定金</h4>
                </div>
                <div class="modal-body" style="padding: 60px auto;">
                    <form>
                        <div class="row ">
                            <?=$this->render('@app/views/common/csrf.php')?>
                            <div class="form-group  col-sm-6   mT20 centerHeight">
                                <div class="col-sm-4   text-right">
                                    <div for="recipient-name" class="control-label"><span class="red">*</span>金额:</div>
                                </div>
                                <div class="col-sm-8 pd0">
                                    <input type="number" inputnum  autocomplete="off" ng-model="depositMoney" class="form-control  " id="recipient-name" placeholder="请输入金额">
                                </div>
                            </div>
                            <div class="form-group  col-sm-6  mT20 centerHeight">
                                <div class="col-sm-4   text-right">
                                    <div for="recipient-name" checknum  class="control-label">抵券:</div>
                                </div>
                                <div class="col-sm-8 pd0">
                                    <input type="number"  autocomplete="off" ng-model="depositToRoll" class="form-control control-label depositInput" id="recipient-name" placeholder="请输入金额">
                                </div>
                            </div>
                            <div class="form-group  col-sm-6  mT20 centerHeight">
                                <div class="col-sm-4  text-right">
                                    <div for="recipient-name" class="control-label"><span class="red">*</span>有效期:</div>
                                </div>
                                <div class="col-sm-8 pd0" >
                                    <div  class=" input-daterange input-group"  style="width: 100%;">
                                       <input type="text"  readonly name="reservation" id="subscriptionDate" class=" form-control " value="" placeholder="选择时间"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group  col-sm-6  mT20 centerHeight">
                                <div class="col-sm-4  text-right">
                                    <div for="recipient-name" class="control-label">付款方式:</div>
                                </div>
                                <div class="col-sm-8 pd0" >
                                    <select ng-model="depositPayMode" class="form-control" style="padding: 4px 12px;">
                                        <option value="">请选择</option>
                                        <option value="1">现金</option>
                                        <option value="3">微信</option>
                                        <option value="2">支付宝</option>
<!--                                        <option value="4" >pos机</option>-->
                                        <option value="5" >建设分期</option>
                                        <option value="6" >广发分期</option>
                                        <option value="7" >招行分期</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                    <span type="button"  class="btn btn-success w100" ladda="depositButtonFlag" id="success" ng-click="depositSubmit()">完成</span>
                </div>
            </div>
        </div>
    </div>

    <!--冻结备注-->
    <div class="modal fade" tabindex="-1" role="dialog" id="freezeRemark">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">{{statusId == 2 ? '解冻':'冻结'}}</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="display: flex;justify-content: center;">
                        <div class="col-sm-10">
                            <div class="text-left f16"><span class="red">*</span><span>{{statusId == 2 ? '解冻':'冻结'}}</span>原因:</div>
                            <textarea class="f14" name="" id="freezeContent"  rows="6" maxlength="300" style="width: 100%;text-indent: 2em;margin-top: 10px;resize: none;" placeholder="请输入原因，字数不能超过300字"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default w100" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-success w100" ng-click="confirmFreeze()">确定</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--    分配私教模态框-->
    <div class="modal fade" id="distribution" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="width: 720px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="privateEducationClose()"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">分配私教</h4>
                </div>
                <div class="modal-body" style="padding-top: 50px;">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-12 col-sm-offset-1" style="color: #999999;font-size: 12px;">
                                <div style="margin-top: 10px;margin-left: 100px">
                                    <ul class="" style="display: flex;align-items: center;">
                                        <li><span class="red">*</span>会员卡</li>
                                        <li class=" mL20" style="width: 170px;">
                                            <select class="form-control cp a67" ng-change="privateEducationSelectCardChange(privateEducationSelectTypeId)" ng-model="privateEducationSelectTypeId">
                                                <option value="">选择卡种</option>
                                                <option value="{{w.id}}" ng-repeat="w in privateEducationSelectCardData">{{w.card_name}}</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div style="margin-top: 10px;">
                                    <ul class="" style="display: flex;align-items: center;margin-left: 100px">
                                        <li class=""><span class="red">*</span>上课教练</li>
                                        <li class=" mL20">
                                            <div class="clearfix a56" style="">
                                                <div class="fl a57">
                                                    <img ng-if="privateEducationSelectListPic != null && privateEducationSelectListPic != ''" ng-src="{{privateEducationSelectListPic}}" width="50px" height="100%" alt="">
                                                    <img ng-if="privateEducationSelectListPic == null || privateEducationSelectListPic== '' " src="/plugins/user/images/noPic.png" width="50px" height="100%" alt="">
                                                </div>

                                                <div ng-click="distributionTeacher()" class="fl text-center cp"
                                                     style="width: 115px; height: 50px;line-height: 50px;text-align: center;">
                                                    <b ng-if="privateEducationSelectListName != null">{{privateEducationSelectListName}}</b>
                                                    <b ng-if="privateEducationSelectListName == null">点击选择教练</b>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div style="margin-top: 10px;margin-left: 100px">
                                    <ul class="" style="display: flex;align-items: center;">
                                        <li><span class="red">*</span>课程节数</li>
                                        <li class=" mL20" style="width: 170px;">
                                            <input type="number" min="1" ng-model="courseNum" class="form-control" placeholder="请输入课程节数">
                                        </li>
                                    </ul>
                                </div>
                                <div style="margin-top: 10px;margin-left: 100px">
                                    <ul class="" style="display: flex;align-items: center;">
                                        <li><span class="red">*</span>课程类型</li>
                                        <li class=" mL20" style="width: 170px;">
                                            <select class="form-control" ng-change="courseTypeSelect(couresType)" ng-model="couresType">
                                                <option value="">选择类型</option>
<!--                                                <option value="1">购买</option>-->
                                                <option value="2">赠送</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div style="margin-top: 10px;margin-left: 100px">
                                    <ul class="" style="display: flex;align-items: center;">
                                        <li><span class="red">*</span>课程名称</li>
                                        <li class=" mL20" style="width: 170px;">
                                            <select class="form-control" ng-change="courseTypeSelectChange(couresName)" ng-model="couresName">
                                                <option value="">选择课程</option>
                                                <option value="{{w.id}}" ng-repeat="w in courseTypeSelectData">{{w.name}}</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div class="clearfix mT10">
                                    <button ladda="distributionPtButtonFlag"  id="completeBuy" ng-click="privateEducationSelectOk()" type="button"
                                             class="btn btn-success btn-sm a59" style="margin-top: 30px">完成
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--    赠送模态框-->
    <div class="modal fade" id="presenterModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="width: 720px;">
            <div class="modal-content clearfix" style="background-color: #FFF;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="privateEducationClose()"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">赠送</h4>
                </div>
                <div class="modal-body" style="padding-top: 50px;">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-offset-2 col-sm-8 " style="color: #999999;font-size: 12px;">
                                <div style="margin-top: 10px;margin-left: 100px">
                                    <ul class="" style="display: flex;align-items: center;">
                                        <li><span class="red">*</span>赠送类别</li>
                                        <li class=" mL20" style="width: 200px;">
                                            <select class="form-control cp a67 selectCss" style="margin-left: 0;" ng-change="giveTypeSelect(giveType123)" ng-model="giveType123">
                                                <option value="">选择赠送类别</option>
<!--                                                <option value="1" >收费课</option>-->
<!--                                                <option value="2" >免费课</option>-->
                                                <option value="3" >生日课</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div style="margin-top: 10px;margin-left: 100px">
                                    <ul class="" style="display: flex;align-items: center;">
                                        <li><span class="red">*</span>会员卡</li>
                                        <li class=" mL20" style="width: 200px;">
                                            <select class="form-control cp a67 selectCss"  ng-model="giveCard123">
                                                <option value="">请选择卡种</option>
                                                <option value="{{w.id}}" ng-repeat="w in privateEducationSelectCardData">{{w.card_name}}</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div style="margin-top: 10px;">
                                    <ul class="" style="display: flex;align-items: center;margin-left: 100px">
                                        <li class=""><span class="red">*</span>上课教练</li>
                                        <li class=" mL20">
                                            <div class="clearfix a56" style="width: 200px;">
                                                <div class="fl a57">
                                                    <img ng-if="privateEducationSelectListPic != null && privateEducationSelectListPic != ''" ng-src="{{privateEducationSelectListPic}}" width="50px" height="100%" alt="">
                                                    <img ng-if="privateEducationSelectListPic == null || privateEducationSelectListPic== '' " src="/plugins/user/images/noPic.png" width="50px" height="100%" alt="">
                                                </div>

                                                <div ng-click="distributionTeacher()" class="fl text-center cp"
                                                     style="width: 145px; height: 50px;line-height: 50px;text-align: center;">
                                                    <b ng-if="privateEducationSelectListName != null">{{privateEducationSelectListName}}</b>
                                                    <b ng-if="privateEducationSelectListName == null">点击选择教练</b>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div style="margin-top: 10px;margin-left: 100px">
                                    <ul class="" style="display: flex;align-items: center;">
                                        <li><span class="red">*</span>课程名称</li>
                                        <li class=" mL20" style="width: 200px;">
                                            <select class="form-control selectCss" ng-change="giveCourseTypeSelectChange(giveCourseName123)" ng-model="giveCourseName123">
                                                <option value="">选择课程</option>
                                                <option value="{{w.id}}" ng-repeat="w in giveCourseLists123">{{w.name}}</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div style="margin-top: 10px;margin-left: 100px">
                                    <ul class="" style="display: flex;align-items: center;">
                                        <li><span class="red">*</span>课程节数</li>
                                        <li class=" mL20" style="width: 200px;">
                                            <input type="number" min="1" ng-model="giveCourseNum123" class="form-control" placeholder="请输入课程节数">
                                        </li>
                                    </ul>
                                </div>
                                <div style="margin-top: 10px;margin-left: 100px">
                                    <ul class="" style="display: flex;align-items: center;">
                                        <li><span class="red">*</span>课程有效期</li>
                                        <li  style="width: 200px;margin-left: 8px;">
<!--                                            <input type="number" min="1"  class="form-control" ng-model="giveCourseValidity" placeholder="请输入课程有效期">-->
<!--                                            <div class="input-append date " id="giveCourseDate" data-date-format="yyyy-mm-dd">-->
<!--                                                <input class=" form-control h30" type="text" readonly-->
<!--                                                       placeholder="请选择课程有效期"-->
<!--                                                       ng-model="giveCourseValidity"/>-->
<!--                                                <span class="add-on"><i class="icon-th"></i></span>-->
<!--                                            </div>-->
                                            <div  class=" input-daterange input-group"  style="width: 100%;">
                                                <input type="text"  readonly name="reservation" id="validityDateTime123" class=" form-control " value="" placeholder="选择时间"/>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="clearfix mT10">
                                <button ladda="givePtButtonFlag"  id="completeBuy" ng-click="presenterSubmit()" type="button"
                                        class="btn btn-success btn-sm a59" style="margin-top: 30px">完成
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--自定义销售来源-->
    <div class="modal fade" tabindex="-1" id="sellSource1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">自定义销售渠道</h4>
                </div>
                <div class="modal-body" style="display: flex;justify-content: center;margin-top: 20px;">
                    <input type="text" class="form-control" id="recipient-name" placeholder="请输入自定义销售渠道名称" ng-model="customSalesChannels" style="width: 60%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-success" ng-click="confirmAdd(customSalesChannels)">确定</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!--    续费-->
    <div class="modal fade" id="privateBuy" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="width: 1075px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">续费</h4>
                </div>
                <div class="modal-body" style="padding-top: 50px;">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-6 text-left a60">
                                <div class="col-sm-5">
                                    <div class="a61">
                                        <img ng-src="{{privateBuyData.pic}}" class="image a62">
                                        <span class='wenzi a63'>点击更换课程</span>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div style="margin-left: 53px">{{privateBuyData.name}}
                                        <!--                                       <span class="label label-info" style="margin-left: 10px;">正常 </span>-->
                                    </div>
                                    <div style="margin-left: 53px;margin-top: 10px">
                                        金额:{{privateBuyData.money_amount}}元
                                    </div>
                                    <div style="margin-left: 53px;margin-top: 10px">
                                        总节数:{{privateBuyData.course_amount}}节
                                    </div>
                                    <div style="margin-left: 53px;margin-top: 10px">
                                        剩余节数:{{privateBuyData.overage_section}}节
                                    </div>
                                    <div style="margin-left: 53px;margin-top: 10px">
                                        到期时间:{{privateLessonTemplet.deadline_time * 1000| date:'yyyy-MM-dd'}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5 col-sm-offset-1 a65">
                                <div class="mT10">
                                    <ul class="a58">
                                        <li><span class="red">*</span>节数</li>
                                        <li class=" mL20 a66">
                                            <input type="text" class="form-control" ng-model="privateBuyDatas.total"
                                                   placeholder="多少节" ng-blur="nodeNumberBlur(privateBuyDatas.total)">
                                        </li>
                                    </ul>
                                </div>
                                <div class=mT10>
                                    <ul class="a58">
                                        <li><span class="op0">*</span>折扣</li>
                                        <li class=" mL20" style="width: 160px;">
                                            <select id="selectColor" ng-model="privateBuyDatas.discount"
                                                    class="form-control cp a67">
                                                <option value="">选择折扣</option>
                                                <option value="5">5折</option>
                                                <option value="7">7折</option>
                                                <option value="8">8折</option>
                                                <option value="9">9折</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mT10">
                                    <ul class="a58">
                                        <li><span class="red">*</span>延长时间:</li>
                                        <li style="margin-left: 5px;">
                                            <input type="number" min="1" class="form-control" ng-model="privateBuyDatas.data"
                                                   placeholder="多少天" style="width: 160px;">
                                        </li>
                                    </ul>
                                </div>
                                <div class="mT10">
                                    <ul class="a58">
                                        <li><span class="red">*</span>销售教练</li>
                                        <li class=" mL8" style="width: 160px;">
                                            <select id="selectColor"
                                                    ng-change="selectAboutClassData(privateBuyDatas.education)"
                                                    ng-model="privateBuyDatas.education" class="form-control cp "
                                                    style="padding: 4px 12px;">
                                                <option value="">请选择销售私教</option>
                                                <option value="{{w.id}}" ng-repeat="w in privateBuyDataSectle">
                                                    {{w.name}}
                                                </option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mT10">
                                    <ul class="a58">
                                        备注
                                        <li class=" mL20" style="width: 160px;">
                                            <textarea name="" id="" cols="30" rows="2"
                                                      ng-model="privateBuyDatas.remarks" style="margin-left: 18px;resize: none;">

                                            </textarea>
                                        </li>
                                    </ul>
                                </div>
                                <div class="mT10" style="margin-left: 197px" ng-if="privateBuyData != null "><b>总金额: <span ng-if="nodeNumberBlurData != undefined">{{nodeNumberBlurData}}</span> <span ng-if="nodeNumberBlurData == undefined">0.00</span>元</span></b></div>
                                 <div class="mT10" style="margin-left: 197px"><b>实收: <span ng-if="nodeNumberBlurData !=undefined">{{nodeNumberBlurData  * ((privateBuyDatas.discount ==''?10 :privateBuyDatas.discount) / 10) |  number:2}}</span> <span ng-if="nodeNumberBlurData == undefined">0.00</span> 元</b></div>
                                <div class="clearfix a3"><b style="margin-left: 113px;font-size: 14px"></b>
                                    <button ladda="RenewPTButtonFlag" type="button" class="btn btn-success btn-sm a59" ng-click="OkRenewal()">续费</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--    转课-->
    <div class="modal fade" id="transfer" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="width: 1075px;">
            <div class="modal-content clearfix">
                <div class="modal-header clearfix">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">转课</h4>
                </div>
                <div class="modal-body" style="padding-top: 50px;">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <img src="/plugins/img/exclamation.png" alt="">
                            <div style="font-size: 15px;color: rgb(153,153,153)">
                                本操作将会把会员购买的{{privateLessonTemplet.name}}产品转移给指定会员
                            </div>
                            <div style="margin-top: 20px;margin-left: -147px">
                                <span style="color: red;margin-left: -123px">*</span>会员编号
                                <input type="text" class="form-control a68" ng-model="turn.memberNumber"
                                       placeholder="请输入指定会员编号">
                            </div>
                            <div style="margin-top: 10px;margin-left: -147px">
                                <span style="color: red;margin-left: -123px">*</span>转让金额
                                <input type="text" class="form-control a68" ng-model="turn.transferAmount"
                                       placeholder="" style="">
                            </div>
                            <div style="margin-top: 10px;margin-left: -147px">
                                <span style="color: red;margin-left: -123px">*</span>转让节数
                                <input type="text" class="form-control a68" ng-model="turn.transferNode"
                                       placeholder="{{privateLessonTemplet.overage_section}}" style="">
                            </div>
                        </div>

                    </div>
                </div>
                <div class="clearfix a3">
                    <button type="button" ladda="transferButtonFlag" ng-click="transferOk()" class="btn btn-success btn-sm a69">完成</button>
                </div>
            </div>
        </div>
    </div>
    <!--选择课程-->
    <div class="modal fade" id="selectPrivateCourseModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="width: 720px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <div style="display: flex;justify-content: space-between;">
                        <span ng-click="backBuyPrivate()" class="glyphicon glyphicon-menu-left f16 cp"
                              class="a70"></span>
                        <h4 class=" f14">选择私课</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <div style="height:360px;overflow-y: scroll;">
                    <ul class="clearfix courseLists" ng-repeat="qq in aloneData"
                        style="margin-left: 20px;padding: 20px 36px 20px 0; border-bottom: solid 1px #e5e5e5;">
                        <li class="fl">
                            <img ng-if="qq.pic == ''" ng-src="/plugins/user/images/noPic.png" width="66px"
                                 style="border-radius:4px; " height="66px" alt="">
                            <img ng-if="qq.pic != ''" ng-src="{{qq.pic}}" width="66px" height="66px" alt=""
                                 style="border-radius:4px; ">
                        </li>
                        <li class="fl" style="margin-left: 16px;">
                            <ul style="margin-top: 4px;">
                                <li><h4 class="f16">{{qq.packName}}</h4></li>
                                <li class="f12" style="color: #999999;margin-top: 4px;">{{qq.name}}</li>
                                <li class="gradeImg" style="margin-top: 0px;">
                                    <img src="/plugins/img/x1.png" alt="">
                                    <img src="/plugins/img/x1.png" alt="">
                                    <img src="/plugins/img/x1.png" alt="">
                                    <img src="/plugins/img/x1.png" alt="">
                                    <img src="/plugins/img/x2.png" alt="">
                                </li>
                            </ul>
                        </li>
                        <li class="fr">
                            <span class="pull-right textMoney">单价原价：<span class="moneyText">{{qq.original_price}}</span></span>
                            <br/>
                            <button ng-click="selectPrivateCourseSingle(qq.id,qq.pic,qq.packName,'alone',qq.chargeClassPriceAll,qq.original_price,qq.newMember,qq.month_up_num)"
                                    style="margin-top: 4px;" class="btn btn-success btn-sm tdBtn pull-right">选择私课
                            </button>
                        </li>
                    </ul>
                    <ul class="clearfix courseLists" ng-repeat="ww in manyData"
                        style="margin-left: 20px;padding: 20px 36px 20px 0; border-bottom: solid 1px #e5e5e5;">
                        <li class="fl">
                            <img ng-if="ww.pic == ''" ng-src="/plugins/user/images/noPic.png"
                                 style="border-radius:4px; " width="66px" height="66px" alt="">
                            <img ng-if="ww.pic != ''" ng-src="{{ww.pic}}" width="66px" style="border-radius:4px; "
                                 height="66px" alt="">
                        </li>
                        <li class="fl" style="margin-left: 16px;">
                            <ul style="margin-top: 4px;">
                                <li><h4 class="f16">{{ww.packName}}</h4></li>
                                <li class="f12" style="color: #999999;margin-top: 4px;">
                                    <span>{{ww.courseStr}}</span></span></li>
                                <li class="gradeImg" style="margin-top: 0px;">
                                    <img src="/plugins/img/x1.png" alt="">
                                    <img src="/plugins/img/x1.png" alt="">
                                    <img src="/plugins/img/x1.png" alt="">
                                    <img src="/plugins/img/x1.png" alt="">
                                    <img src="/plugins/img/x2.png" alt="">
                                </li>
                            </ul>
                        </li>
                        <li class="fr" style="margin-top: 8px;">
                            <span class="pull-right textMoney">套餐原价：<span
                                    class="moneyText">{{ww.totalPrice}}</span></span>
                            <br/>
                            <button ng-class=" {{ww.memberOrder == true}} ? 'endMemberOrder' :'endMemberOrders' "
                                    ng-disabled="ww.memberOrder  != true"
                                    ng-click="selectPrivateCourseServe(ww.id,ww.pic,ww.packName,'many',ww.totalPrice)"
                                    style="margin-top: 4px;" class="btn btn-success btn-sm tdBtn">选择私课
                            </button>
                        </li>
                    </ul>
                    <?= $this->render('@app/views/common/nodata.php', ['name' => 'shopDetailShow']); ?>
                </div>
            </div>
        </div>
    </div>
    <!--        私教分配选择教练模态框-->
    <div class="modal fade" id="selectTeacherModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="width: 720px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <div style="display: flex;justify-content: space-between;">
                        <span ng-click="privateEducationModal()" class="glyphicon glyphicon-menu-left f16 cp"
                              class="a70"></span>
                        <h4 class=" f14">选择教练</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                </div>
                <div style="height:360px;overflow-y: scroll;">
                    <ul class="clearfix courseLists" ng-repeat="w in privateEducationDataList"
                        style="margin-left: 20px;padding: 20px 36px 20px 0; border-bottom: solid 1px #e5e5e5;">
                        <li class="fl">
                            <img  ng-src="{{w.pic}}" width="66px" style="border-radius:4px; " height="66px" alt="">
                        </li>
                        <li class="fl" style="margin-left: 16px;">
                            <ul style="margin-top: 4px;">
                                <li><h4 class="f16" > {{w.name}} <b style="margin-left: 50px;" ng-if="w.age != null">年龄:{{w.age}}</b>   </h4></li>
                                <li class="f12" style="color: #999999;margin-top: 4px;" ng-if="w.work_time != null">从业时间{{w.work_time}}年</li>
                                <li class="gradeImg" style="margin-top: 0px;">
                                    <img src="/plugins/img/x1.png" alt="">
                                    <img src="/plugins/img/x1.png" alt="">
                                    <img src="/plugins/img/x1.png" alt="">
                                    <img src="/plugins/img/x1.png" alt="">
                                    <img src="/plugins/img/x2.png" alt="">
                                </li>
                                <button style="margin-top: -40px;margin-left: 436px" ng-click="privateEducationSelectList(w.id,w.pic,w.name)" class="btn btn-success btn-sm tdBtn pull-right">选择教练</button>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!--        二级模态框 会员卡信息修改-->
    <div style="margin-top: 20px;" class="modal fade" id="myModals6" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div style="padding-bottom: 20px;margin-top: 200px;" class="modal-content clearfix">
                <div style="border: none;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>

                    <h5 style="margin-left:10px;text-align: center;font-size: 20px;">会员卡信息修改</h5>
                    <form>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName3">卡名称:</label>
                            <input id="_csrf" type="hidden"
                                   name="<?= \Yii::$app->request->csrfParam; ?>"
                                   value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                            <input type="hidden" value="{{cardDetail.id}}" id="memCardId">
                            <input type="hidden" value="{{cardDetail.member_id}}" id="memberId">
                            <span>{{cardDetail.card_name}}</span>
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <!--                                <input type="text" class="form-control"  id="exampleInputName6" ng-model="cardDetail.invalid_time" placeholder="请输入有效期">-->
                            <label style="font-size: 14px;position: relative;top: 13px;left: -196px"
                                   for="exampleInputName6">失效日期</label>
                            <div style="float: left;position: relative;" class="input-daterange input-group cp"
                                 id="container">
                                <b><input type="text" id="datetimeEnd" class="form-control" name="" placeholder="结束日期"
                                          style="left:112px;top: 7px;"></b>
                            </div>
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <!--                                ng-model="cardDetail.employeeName"-->
                            <label style="font-size: 14px;position: relative;left: -310px;top: 12px;"
                                   for="">销售顾问</label>
                            <select class=" fl"
                                    style="padding: 4px 12px;width: 201px;margin-left: 111px;margin-top: 9px; overflow: auto;border: solid 1px #cfdadd;"
                                    id="coachId" ng-model="adviser">
                                <option value="">请选择</option>
                                <option value="{{theAdviser.id}}" ng-repeat="theAdviser in allAdviser">
                                    {{theAdviser.name}}
                                </option>
                            </select>
                        </div>
                    </form>
                    <button style="margin-top: 20px;" type="submit" class="btn btn-primary backBtn">
                        &nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp
                    </button>
                    <button style="margin-top: 20px;" ng-click="refer()" type="submit"
                            class="btn btn-success pull-right successBtn">&nbsp&nbsp&nbsp&nbsp完成&nbsp&nbsp&nbsp&nbsp
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--        二级模态框 私教课修改-->
    <div style="margin-top: 20px;" class="modal fade" id="myModals7" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div style="padding-bottom: 20px;" class="modal-content clearfix">
                <div style="border: none;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>

                    <h5 style="margin-left:10px;text-align: center;font-size: 20px;">私教课程信息修改</h5>
                    <form>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName3">课程名称</label>
                            <input type="text" class="form-control" id="exampleInputName3" placeholder="请输入课程名称">
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName5">办理日期</label>
                            <input type="text" class="form-control" id="exampleInputName5" placeholder="请输入办理日期">
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName6">到期日期</label>
                            <input type="text" class="form-control" id="exampleInputName6" placeholder="请输入到期日期">
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName8">办理私教</label>
                            <input type="text" class="form-control" id="exampleInputName8" placeholder="请输入办理私教">
                        </div>
                    </form>
                    <button style="margin-top: 20px;" type="submit" class="btn btn-primary backBtn">
                        &nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp
                    </button>
                    <button style="margin-top: 20px;" type="submit" class="btn btn-success pull-right successBtn">
                        &nbsp&nbsp&nbsp&nbsp完成&nbsp&nbsp&nbsp&nbsp
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--        二级模态框 柜子信息修改-->
    <div style="margin-top: 20px;" class="modal fade" id="myModals8" tabindex="-1" role="dialog"
         aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div style="padding-bottom: 20px;margin-top: 200px;" class="modal-content clearfix">
                <div style="border: none;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>

                    <h5 style="margin-left:10px;text-align: center;font-size: 20px;">柜子信息修改</h5>
                    <form>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName3">柜子名称</label>
                            <input type="text" class="form-control" id="exampleInputName3" placeholder="请输入柜子名称">
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName5">租用天数</label>
                            <input type="text" class="form-control" id="exampleInputName5" placeholder="请输入租用天数">
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName6">到期日期</label>
                            <input type="text" class="form-control" id="exampleInputName6" placeholder="请输入到期日期">
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName7">金额</label>
                            <input type="text" class="form-control" id="exampleInputName7" placeholder="请输入金额">
                        </div>
                        <div style="margin-top: 10px;" class="form-group">
                            <label style="font-size: 14px;" for="exampleInputName8">经办人</label>
                            <input type="text" class="form-control" id="exampleInputName8" placeholder="请输入经办人">
                        </div>
                    </form>
                    <button style="margin-top: 20px;" type="submit" class="btn btn-primary backBtn">
                        &nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp
                    </button>
                    <button style="margin-top: 20px;" type="submit" class="btn btn-success pull-right successBtn">
                        &nbsp&nbsp&nbsp&nbsp完成&nbsp&nbsp&nbsp&nbsp
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--二级模态框 私教点击详情页面-->
<!--    <div style="margin-top: 20px;" class="modal fade" id="myModals9" tabindex="-1" role="dialog"-->
<!--         aria-labelledby="myModalLabel" aria-hidden="true">-->
<!--        <div class="modal-dialog" style="width: 60%;">-->
<!--            <div style="padding-bottom: 20px;margin-top: 200px;" class="modal-content">-->
<!--                <div style="border: none;" class="modal-header">-->
<!--                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">-->
<!--                        &times;-->
<!--                    </button>-->
<!--                    <h3 style="font-size: 24px;text-align: center;margin-top: 20px;">私教上课情况信息</h3>-->
<!--                    <div class="ibox float-e-margins" style="margin-top: 20px;">-->
<!--                        <div class="ibox-title">-->
<!--                            <h5>{{productName}}课程记录列表</h5>-->
<!--                        </div>-->
<!--                        <div class="ibox-content" style="padding: 0">-->
<!--                            <div style="padding-bottom: 0;height: 300px;overflow: scroll;"-->
<!--                                 id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">-->
<!--                                <table-->
<!--                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"-->
<!--                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info"-->
<!--                                    style="position: relative;">-->
<!--                                    <thead>-->
<!--                                    <tr role="row">-->
<!--                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"-->
<!--                                            colspan="1" aria-label="浏览器：激活排序列升序" style="width: 100px;">上课时间-->
<!--                                        </th>-->
<!--                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"-->
<!--                                            colspan="1" aria-label="浏览器：激活排序列升序" style="width: 100px;">总节数-->
<!--                                        </th>-->
<!--                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"-->
<!--                                            colspan="1" aria-label="浏览器：激活排序列升序" style="width: 100px;">上课时长-->
<!--                                        </th>-->
<!--                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"-->
<!--                                            colspan="1" aria-label="浏览器：激活排序列升序" style="width: 100px;">上课教练-->
<!--                                        </th>-->
<!--                                    </thead>-->
<!--                                    <tbody>-->
<!--                                    <tr ng-repeat = 'record in records'>-->
<!--                                        <td >{{record.start *1000 | noData:''| date:'yyyy/MM/dd  HH:mm'}}</td>-->
<!--                                        <td>{{record.memberCourseOrderDetails.course_num | noData:''}}</td>-->
<!--                                        <td>{{record.memberCourseOrderDetails.class_length | noData:'分钟'}}</td>-->
<!--                                        <td>{{record.employee.name | noData:''}}</td>-->
<!--                                    </tr>-->
<!--                                    </tbody>-->
<!--                                </table>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->

    <!--   会员卡续费  续费模态框-->
    <div style="margin-left: 220px;" class="modal fade" id="myModals15" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div style="margin-top: 40px;width: 85%;" class="modal-dialog">
            <div style="border: none;" class="modal-content clearfix">
                <div style="border: none;position: relative;" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center"
                    style="font-size: 18px;height: 40px;border: 1px solid #eee;border-width: 0 0 1px 0;">续费</h3>
                <div class="col-sm-6"
                     style="margin-top: 60px; border: 1px solid #eee;border-width: 0 1px 0 0;height: 466px;margin-bottom: 60px;">
                    <div class="col-sm-12 pd0">
                        <div class="col-sm-6 pd0">
                            <img style="width: 230px;height: 170px;" src="../plugins/img/card111.png">
                        </div>
                        <div class="col-sm-6" style="padding-left: 20px;min-width: 182px;;">
                            <p style="font-size: 18px;font-weight: bold;">{{cardInfo.card_name}}</p>
                            <p class="upsateInfoP">剩余金额:{{cardInfo.amount_money}}</p>
                            <p class="upsateInfoP">会员卡号:{{cardInfo.card_number}}</p>
                            <p class="upsateInfoP">剩余天数:<span id="daysSpan">{{remainingDate}}</span></p>
                            <p class="upsateInfoP">到期时间:{{cardInfo.invalid_time *1000 |date:'yyyy-MM-dd'}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" style="padding-left: 40px;margin-top: 60px;">
                    <form class="form-horizontal">
                        <input ng-model="MemberData._csrf" id="_csrf" type="hidden"
                               name="<?= \Yii::$app->request->csrfParam; ?>"
                               value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 5px"><span
                                    style="color: red;">*</span>卡种名称</label>
                            <div class="col-sm-6" style="margin-left: 16px;">
                                <select class="form-control typeSelect"
                                        ng-model="renewCardType"
                                        ng-change="getRenewCardInfo(renewCardType)">
                                    <option value="">请选择</option>
                                    <option value="{{type}}"
                                            ng-repeat="type in renrewCardTypeList">{{type.card_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 24px;">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                    style="color: red;"></span>续费卡号</label>
                            <div class="col-sm-6">
                                <input type="number"
                                       class="form-control cardNumInput"
                                       placeholder="请输入卡号"
                                       ng-model="cardNumber">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 20px;">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                    style="color: red;">*</span>续费价格</label>
                            <div class="col-sm-6">
                                <input type="text"
                                       class="form-control"
                                       ng-model="renewPrice"
                                       ng-change="priceChange()">
                            </div>
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 5px"><span
                                    style="color: red;">*</span>选择销售</label>
                            <div class="col-sm-6" style="margin-left: 16px;">
                                <select class="form-control sellerSelect"
                                        style="padding-top: 4px;"
                                        ng-model="seller">
                                    <option value="">请选择</option>
                                    <option value="{{sale.id}}" ng-repeat="sale in saleInfo">{{sale.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"
                                   style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 10px;"><span
                                    style="color: red;">*</span>使用期限</label>
                            <div class="col-sm-6" style="margin-top: 10px;">
                                <p class="renewTime cardTimeWords">{{renewStartDat*1000 |date:'yyyy-MM-dd'}}至{{renewTermEnd*1000|date:'yyyy-MM-dd'}}</p>
                            </div>
                        </div>
                    </form>
                    <div class="col-sm-12 renewMoneyInfoBox">
                        <p>总金额：{{renewCardAllMoney}}元</p>
                        <p>续费金额：{{renCardRecondMoney}}元</p>
                    </div>
                </div>
                <span class="btn btn-success" style="width: 120px;position: absolute;bottom: 25px;right: 40px;"
                      ng-click="renrewSuccess()"
                      ladda="checkButton">续 费</span>
            </div>
            </div>
        </div>
    </div>

<!--会员卡升级模态框-->
    <div class="modal fade" style="margin-left: 200px;min-width: 1200px;" tabindex="-1" id="memberCardUpgradeModal" role="dialog">
        <div style="margin-top: 40px;width: 85%;" class="modal-dialog">
            <div style="border: none;" class="modal-content clearfix">
                <div style="border: none;position: relative;" class="modal-header clearfix">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h3 class="text-center"
                        style="font-size: 18px;height: 40px;border: 1px solid #eee;border-width: 0 0 1px 0;">升级</h3>
                    <div class="col-sm-6"
                         style="margin-top: 60px; border: 1px solid #eee;border-width: 0 1px 0 0;height: 466px;margin-bottom: 60px;">
                        <div class="col-sm-12 pd0">
                            <div class="col-sm-6 pd0">
                                <img style="width: 230px;height: 170px;" src="../plugins/img/card111.png">
                            </div>
                            <div class="col-sm-6" style="padding-left: 20px;min-width: 182px;">
                                <p style="font-size: 18px;font-weight: bold;">
                                    {{cardInfo.card_name}}&nbsp;&nbsp;
                                    <span class="oldCardTitle">旧卡</span>
                                </p>
                                <p class="upsateInfoP">剩余金额:{{cardInfo.amount_money}}</p>
                                <p class="upsateInfoP">卡种卡号:{{cardInfo.card_number}}</p>
                                <p class="upsateInfoP">剩余天数:<span id="daysSpan">{{remainingDate}}</span></p>
                                <p class="upsateInfoP">到期时间:{{cardInfo.invalid_time *1000 |date:'yyyy-MM-dd'}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" style="padding-left: 40px;margin-top: 60px;">
                        <form class="form-horizontal">
                            <input ng-model="MemberData._csrf" id="_csrf" type="hidden"
                                   name="<?= \Yii::$app->request->csrfParam; ?>"
                                   value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                            <div class="form-group">
                                <label class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 5px"><span
                                        style="color: red;">*</span>卡种名称</label>
                                <div class="col-sm-6" style="margin-left: 16px;">
                                    <select class="form-control typeSelect"
                                            ng-model="upsateCardType"
                                            ng-change="getUpsateCardType(upsateCardType)">
                                        <option value="">请选择</option>
                                        <option value="{{up}}"
                                                ng-repeat="up in cardList">
                                            {{up.card_name}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 24px;">
                                <label class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                        style="color: red;">*</span>卡种价格</label>
                                <div class="col-sm-6">
                                    <input type="text"
                                           class="form-control upsateCardMoneySelect"
                                           ng-model="upsateCardMoney"
                                           readonly/>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 24px;">
                                <label class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                        style="color: red;"></span>卡种折扣</label>
                                <div class="col-sm-6">
                                    <select class="form-control discountSelect positionRelative"
                                            ng-model="getDiscountListValue"
                                            ng-change="discountMath(getDiscountListValue)">
                                        <option value="">请选择</option>
                                        <option value="{{g}}" ng-repeat="g in getDiscountList">{{g.discount}}</option>
                                    </select>
                                    <span class="discountSelectTitle"><i class="glyphicon glyphicon-info-sign"></i>{{residueCard}}张</span>
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 24px;">
                                <label class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                        style="color: red;"></span>升级卡号</label>
                                <div class="col-sm-6">
                                    <input type="text"
                                           checknum
                                           class="form-control cardNumInput"
                                           placeholder="请输入卡号"
                                           ng-model="upcardNumber">
                                </div>
                            </div>
                            <div class="form-group" style="margin-top: 10px;">
                                <label class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 5px">
                                    <span style="color: red;">*</span>
                                    选择销售
                                </label>
                                <div class="col-sm-6" style="margin-left: 16px;">
                                    <select class="form-control sellerSelect"
                                            style="padding-top: 4px;"
                                            ng-model="seller">
                                        <option value="">请选择</option>
                                        <option value="{{sale.id}}" ng-repeat="sale in saleInfoList">{{sale.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;margin-top: 10px;"><span
                                        style="color: red;">*</span>使用期限</label>
                                <div class="col-sm-6" style="margin-top: 10px;">
                                    <p class="renewTime cardTimeUpsateWords">{{upsateCardTimeStart*1000 |date:'yyyy-MM-dd'}}至{{upsateCardEnd*1000|date:'yyyy-MM-dd'}}</p>
                                </div>
                            </div>
                        </form>
                        <div class="col-sm-12 renewMoneyInfoBox">
                            <p>卡种金额：{{newCardSellPrice}}元</p>
                            <p>补交金额：<span class="newCardPricePay"></span>元</p>
                        </div>
                    </div>
                <span class="btn btn-success"
                      style="width: 120px;position: absolute;bottom: 40px;right: 40px;"
                      ng-click="successUpdate()"
                      ladda="updateCardButtonFlag">升 级</span>
                </div>
            </div>
        </div>
    </div>
<!--卡种修改-->
    <div class="modal fade" id="myModals18" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 20%;">
            <div style="padding-bottom: 20px;" class="modal-content clearfix">
                <div style="border: none;" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-info"
                    style="font-size: 24px;text-align: left;margin-top: 20px;margin-left: 10px;font-weight: normal;">
                    修改</h3>
                <div class="col-sm-12 pd0" style="margin-top: 10px;height: 2px;background: #e1e1e1;"></div>
                <form style="padding-left: 10px;padding-right: 10px;">
                    <div class="col-sm-12 pd0">
                        <div class="form-group" style="margin-top: 10px;">
                            <label for="exampleInputName2" style="font-size: 16px;font-weight: normal;color: #333;">卡
                                号:</label>
                            <input type="text"
                                   class="form-control"
                                   id="exampleInputName2"
                                   ng-model="number"
                                   placeholder="请输入卡号">
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label for="exampleInputName2" style="font-size: 16px;font-weight: normal;color: #333;">到期日期:</label>
                            <input
                                   class="form-control"
                                   id="expireDate"
                                   data-date-format="yyyy-mm-dd hh:ii"
                                   placeholder="请选择登记日期"
                                   ng-model="expireDate"
                            >
                        </div>

                        <div class="form-group" style="margin-top: 10px;">
                            <label for="exampleInputName2" style="font-size: 16px;font-weight: normal;color: #333;">延期开卡日期:</label>
                            <input
                                class="form-control"
                                id="postponeDate"
                                data-date-format="yyyy-mm-dd hh:ii"
                                placeholder="请选择延期开卡日期"
                                ng-model="postponeDate"
                            >
                        </div>
                        <div class="form-group" style="margin-top: 10px;">
                            <label for="exampleInputName2" style="font-size: 16px;font-weight: normal;color: #333;">延期开卡原因:</label>
                            <textarea
                                style="resize: none;"
                                class="form-control"
                                id="postponeCause1"
                                placeholder="请输入延期开卡原因"
                                ng-model="postponeCause1"
                            ></textarea>
                        </div>
                    </div>
                </form>
                <button class="btn btn-success center-block" style="margin-top: 20px;" ng-click="updateCardInfo()">
                    &nbsp;&nbsp;&nbsp;&nbsp;修改&nbsp;&nbsp;&nbsp;&nbsp;</button>
            </div>
            </div>
        </div>
    </div>
<!--转让模态框-->
    <div style="margin-left: 220px;" class="modal fade" id="myModals17" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div style="margin-top: 40px;width: 85%;" class="modal-dialog">
            <div style="border: none;" class="modal-content clearfix">
                <div style="border: none;position: relative;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="text-center"
                        style="font-size: 18px;height: 40px;border: 1px solid #eee;border-width: 0 0 1px 0;">转卡</h3>
                    <div class="col-sm-12 text-center" style="padding-top: 40px;height: 580px;">
                        <img src="../plugins/user/images/info.png">
                        <p style="font-size: 20px;color: #999;margin: 20px;">本操作将会把{{cardInfo.card_name}}转移给指定会员</p>
                        <form class="form-horizontal">
                    <input ng-model="MemberData._csrf" id="_csrf" type="hidden"
                           name="<?= \Yii::$app->request->csrfParam; ?>"
                           value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="col-sm-12 pd0" style="padding-left: 40px;">
                            <div class="form-group" style="margin-top: 10px;">
                                <label for="inputEmail6" class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                        style="color: red;">*</span>手机号码</label>
                                <div class="col-sm-6 positionRelative" style="min-width: 277px;">
                                    <input type="number" class="form-control" inputnum ng-model="mobile" ng-change="changeNameNumber()"/>
                                </div>
                                    <button class="btn btn-success mobileSearchBtn" ng-click="searchUserClick()">查询</button>
                                <p class="small mobileSearchInfoTitle"><span class="glyphicon glyphicon-info-sign"></span>请输入完整的手机号进行查询</p>
                            </div>
                        </div>
                        <div class="col-sm-12 pd0" style="padding-left: 40px;">
                            <div class="form-group" style="margin-top: 10px;">
                                <label for="inputEmail6" class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                        style="color: red;"></span>会员姓名</label>
                                <div class="col-sm-6" style="min-width: 277px;">
                                    <input type="text" class="form-control" id="nameInputCheck"
                                           ng-model="name" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 pd0" style="padding-left: 40px;">
                            <div class="form-group" style="margin-top: 10px;">
                                <label for="inputEmail6" class="col-sm-3 control-label"
                                       style="font-size: 14px;color: #999;font-weight: normal;min-width: 138px;"><span
                                        style="color: red;">*</span>转卡费用</label>
                                <div class="col-sm-6" style="min-width: 277px;">
                                    <input type="text" class="form-control" id="inputEmail3" ng-model="transferPrice">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                    </div>
                    <button class="btn btn-success" ladda="transferCardButtonFlag" style="width: 120px;position: absolute;bottom: 20px;right: 40px;" ng-click="giveCard()">转 卡</button>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-left: 100px;" class="modal fade" id="membershipCardDetails" tabindex="0" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div style="margin-top: 40px;width: 90%;" class="modal-dialog">
            <div style="border: none;" class="modal-content clearfix">
                <div class="membershipCardDetailsBox">
                    <div  class="modal-header border1none">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 class="text-center" style="font-size: 18px;height: 40px;border: 1px solid #eee;border-width: 0 0 1px 0;">会员卡详情</h3>
                    </div>
                    <div class="modal-body">
                       <div style="height: 500px;overflow: auto;">
                           <div>
                               <section class="margin0Auto w300 h180">
                                   <img src="../plugins/user/images/card.png"  style="width: 280px;height: 180px;background-size: 100% 100%;">
                               </section>
                           </div>
                           <div>
                               <section><strong>1.基本属性</strong></section>
                               <section class="col-sm-12 sectionMt">
                                   <section class="col-sm-3">
                                       卡的属性:
                                       <strong ng-if="membershipCardDetailsData.attributes == 1">个人</strong>
                                       <strong ng-if="membershipCardDetailsData.attributes == 2">家庭</strong>
                                       <strong ng-if="membershipCardDetailsData.attributes == 3">公司</strong>
                                   </section>
                                   <section class="col-sm-3">卡的名称:<strong>{{membershipCardDetailsData.card_name}}</strong></section>
                                   <section class="col-sm-3">激活期限:
                                       <strong>{{membershipCardDetailsData.active_limit_time | noData:'天'}}</strong>
                                   </section>
                                   <section class="col-sm-3">有效天数:<strong>{{membershipCardDetailsData.duration | noData:'天'}}</strong></section>
                               </section>
                           </div>
                           <div class="mt50">
                               <section><strong>2.定价和售卖</strong></section>
                               <section class="col-sm-12 sectionMt">
                                   <section class="col-sm-3">
                                       <strong ng-if="membershipCardDetailsData.sell_price == null">售价:{{membershipCardDetailsData.max_price - membershipCardDetailsData.min_price}}元</strong>
                                       <strong ng-if="membershipCardDetailsData.sell_price != null">售价:{{membershipCardDetailsData.sell_price}}元</strong>
                                   </section>
                                   <section class="col-sm-3">续费价:
                                       <strong>{{membershipCardDetailsData.renew_price | noData:'元'}}</strong>
                                   </section>
                                   <section class="col-sm-3">优惠价:
                                       <strong>{{membershipCardDetailsData.offer_price  | noData:'元'}}</strong>
                                   </section>
                                   <section class="col-sm-3"></section>
                               </section>
                           </div>
                           <div class="mt50">
                               <section><strong>3.售卖场馆</strong></section>
                             <section class="col-sm-12 sectionMt" ng-repeat="a in membershipCardDetailsData.cardCategory.limitCardNumberAll">
                               <section class="col-sm-3">售卖场馆:<strong>{{a.organization.name}}</strong> </section>
                                   <section class="col-sm-3">
                                       售卖张数:
                                       <strong ng-if="a.limit > 0">{{a.limit}}张</strong>
                                       <strong ng-if="a.limit < 0">不限</strong>
                                   </section>
                                   <section class="col-sm-3">售卖日期:<strong>{{a.sell_start_time *1000 | date:'yyyy-MM-hh '}}</strong>至<strong>{{a.sell_end_time *1000 | date:'yyyy-MM-hh '}}</strong></section>
                                   <section class="col-sm-3"></section>
                               </section>
                           </div>
                           <div class="mt50">
                               <section><strong>4.通用场馆限制:</strong></section>
                               <section class="col-sm-12 sectionMt"  ng-repeat="a in membershipCardDetailsData.cardCategory.limitCardNumberAll">
                                   <section class="col-sm-3">适用场馆:<strong>{{a.organization.name}}</strong></section>
                                   <section class="col-sm-3">每月通店限制:
                                       <strong ng-if="a.times < 0 || a.times == null">不限</strong>
                                       <strong ng-if="a.times > 0">{{a.times}}</strong>
                                   </section>
                                   <section class="col-sm-3"></section>
                               </section>
                           </div>
                           <div class="mt50">
                               <section><strong>5.进馆时间设置:</strong></section>
                               <div ng-if="cardTimeDay.day == null && cardTimeDay1.weeks == null">
                                    <strong>暂无数据</strong>
                               </div>
                               <div class="col-sm-12" ng-if="cardTimeDay.day != null">
                                   <div class="border1">
                                       <span>每月固定日</span>
                                      <div>
                                          <table id="table" class="cp">
                                              <tbody>
                                              <tr>
                                                  <td style="cursor: pointer;height: 33px;width: 33px;" ng-repeat="w in cardTimeDay.day">{{w}}号</td>
                                              </tr>
                                              </tbody>
                                          </table>
                                      </div>
                                       <section class="mt25"><span class="fontSize16">特定时间段</span><span class="fontSize20 ml30">{{cardTimeDay.start}} 至 {{cardTimeDay.end}}</span></section>
                                   </div>
                               </div>
                               <div class="col-sm-12"  ng-if="cardTimeDay1.weeks != null">
                                   <ul class="weekSelect">
                                       <li class="ml30" ng-repeat="(index,w) in cardTimeDay1.weeks">
                                           <div class="checkbox i-checks checkbox-inline week">
                                               <label id="weeksTime1">星期{{w | week}}</label>
                                           </div>
                                           <div class="weekTime">{{cardTimeDay1.startTime[index]}}    到    {{cardTimeDay1.endTime[index]}}</div>
                                       </li>
                                   </ul>
                               </div>
                           </div>
                           <div class="mt50">
                               <section><strong>6.团课套餐</strong></section>
                               <section class="col-sm-12 sectionMt">
                                   <div class="col-sm-6 mb30" ng-repeat='(index,w) in membershipCardDetailsData.cardCategory.class'>
                                       <section class="col-sm-6">课程名称:<strong>{{w.name}}</strong> </section>
                                       <section class="col-sm-6">每日节数:
                                           <strong ng-if="membershipCardDetailsData.cardCategory.bindPack[index].number > 0">{{membershipCardDetailsData.cardCategory.bindPack[index].number}}</strong>
                                           <strong ng-if="membershipCardDetailsData.cardCategory.bindPack[index].number < 0">不限</strong>
                                       </section>
                                   </div>
                               </section>
                           </div>
                           <div class="mt50">
                               <section><strong>7.服务套餐</strong></section>
                               <section class="col-sm-12 sectionMt">
                                   <div class="col-sm-6 mb30" ng-repeat='(index,w) in membershipCardDetailsData.cardCategory.sever'>
                                       <section class="col-sm-6">服务名称: <strong>{{w.name}}</strong></section>
                                       <section class="col-sm-6">每日数量:
                                           <strong ng-if="membershipCardDetailsData.cardCategory.bindPack[index].number > 0">{{membershipCardDetailsData.cardCategory.bindPack[index].number}}</strong>
                                           <strong ng-if="membershipCardDetailsData.cardCategory.bindPack[index].number < 0">不限</strong>
                                       </section>
                                   </div>
                               </section>
                           </div>
                           <div class="mt50">
                               <section><strong>8.转让:</strong></section>
                               <section class="col-sm-12 sectionMt">
                                   <section class="col-sm-3">转让次数: <strong>{{membershipCardDetailsData.transfer_number | noData:''}}</strong> </section>
                                   <section class="col-sm-3">转让金额: <strong>{{membershipCardDetailsData.transfer_price | noData:''}}</strong></section>
                               </section>
                           </div>
                           <div class="mt50">
                               <section><strong>9.请假:</strong></section>
                               <section ng-if="membershipCardDetailsData.leave_total_days == null &&  membershipCardDetailsData.leave_long_limit == 'null' && membershipCardDetailsData.leave_least_Days == null">
                                   <strong>暂无数据</strong>
                               </section>
                               <section>
                                   <section class="col-sm-12 sectionMt" ng-if="membershipCardDetailsData.leave_total_days != null  && membershipCardDetailsData.leave_least_Days != null">
                                       <section class="col-sm-3">请假总天数:<strong>{{membershipCardDetailsData.leave_total_days}}</strong></section>
                                       <section class="col-sm-3">每日最低天数:<strong>{{membershipCardDetailsData.leave_least_Days}}</strong></section>
                                   </section>
                                   <section class="col-sm-12 sectionMt" ng-if="membershipCardDetailsData.leave_total_days == null && membershipCardDetailsData.leave_least_Days == null">
                                       <section class="col-sm-6" ng-repeat="w in leaveLongIimit">
                                           <section class="col-sm-6">请假次数:<strong >{{w[0]}}</strong></section>
                                           <section class="col-sm-6">每次请假天数:<strong>{{w[1]}}</strong></section>
                                       </section>
                                   </section>
                               </section>
                           </div>
                           <div class="mt50">
                               <section><strong>10.合同:</strong></section>
                               <section class="col-sm-12 sectionMt">
                                   <section class="col-sm-3">合同:<strong>{{membershipCardDetailsData.cardCategory.deal.name | noData:''}}</strong> </section>
                               </section>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--    二次购卡及送人卡部分-->
    <div>
<!-- 购卡模态框 -->
    <div class="modal fade" id="buyCardModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 55%;">
            <div class="modal-content clearfix">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">购卡</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 pdt20Box">
                            <div class="col-sm-5 borderGray">
                                <img ng-if="MemberData.pic == null" ng-src="/plugins/checkCard/img/11.png" width="180" height="180" alt="">
                                <div ng-if="MemberData.pic != null" style="width:180px; height:180px;border-radius: 50%;overflow: hidden;">
                                    <img  ng-src="{{MemberData.pic}}" width="180" height="180"  alt="">
                                </div>
                                <p class="buyCardWords font-blod">会员姓名：{{MemberData.name}}</p>
                                <p class="buyCardWords">会员生日：{{MemberData.birth_date| noData:''}}</p>
                                <p class="buyCardWords">身份证号：{{MemberData.id_card}}</p>
                                <p class="buyCardWords">手机号码：{{MemberData.mobile}}</p>
                            </div>
                            <div class="col-sm-7">
                                <form class="form-horizontal pdl30Form">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label label-words">
                                            <span class="text-danger">*</span>
                                            卡种
                                        </label>
                                        <div class="col-sm-6">
                                            <select class="form-control pdt4" ng-model="cardType">
                                                <option value="">请选择</option>
                                                <option ng-repeat="x in getCardList"
                                                        value="{{x.id}}">{{x.card_name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mt20">
                                        <label class="col-sm-4 control-label label-words">
                                            <span class="text-danger">*</span>
                                            付款方式
                                        </label>
                                        <div class="col-sm-6">
                                            <select class="form-control pdt4"
                                                    ng-model="pay">
                                                <option value="">请选择</option>
                                                <option value="1">全款</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mt20">
                                        <label class="col-sm-4 control-label label-words">
                                            <span class="text-danger">*</span>
                                            选择销售
                                        </label>
                                        <div class="col-sm-6">
                                            <select class="form-control pdt4"
                                                    ng-model="saleMan">
                                                <option value="">请选择</option>
                                                <option ng-repeat="ss in saleInfo"
                                                    value="{{ss.id}}">
                                                    {{ss.name}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mt20">
                                        <label class="col-sm-4 control-label label-words">
                                            <span class="text-danger">*</span>
                                            总金额
                                        </label>
                                        <div class="col-sm-6">
                                            <input class="form-control"
                                                   placeholder="请输入总金额"
                                                   ng-model="buyMoney"/>
                                        </div>
                                    </div>
                                    <div class="form-group mt20">
                                        <label class="col-sm-4 control-label label-words">
                                            <span class="text-danger">*</span>
                                            收款方式
                                        </label>
                                        <div class="col-sm-6">
                                            <select class="form-control pdt4" ng-model="paymentMethod">
                                                <option value="">请选择</option>
                                                <option value="1">现金</option>
                                                <option value="3">微信</option>
                                                <option value="2">支付宝</option>
<!--                                                <option value="4" >pos机</option>-->
                                                <option value="5" >建设分期</option>
                                                <option value="6" >广发分期</option>
                                                <option value="7" >招行分期</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group mt20">
                                        <label class="col-sm-4 control-label label-words">
                                            使用方式
                                        </label>
                                        <div class="col-sm-6">
                                            <select class="form-control pdt4" ng-model="use">
                                                <option value="1">自用</option>
                                                <option value="2">送人</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-success w100"
                            ng-click="buyTwoCardSuccess()"
                            ladda="checkButton">完成</button>
                </div>
            </div>
        </div>
    </div>

<!--  绑定会员模态框 -->
    <div class="modal fade" id="bindingUserSelectModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 35%;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <h2 class="text-center h2BindingTitle" style="margin-top: 4px">绑定会员
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 btnBindingBox">
                            <div class="btnBoxBinding">
                                <button class="btn btn-success center-block btn-block"
                                        ng-click="newUserBinding()">新会员绑定</button>
                            </div>
                            <div class="btnBoxBinding2">
                                <button class="btn btn-default center-block btn-block"
                                        ng-click="oldUserBinding()">老会员绑定</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

<!-- 绑定老会员模态框 -->
    <div class="modal fade" id="bindingUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 40%;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <h2 class="text-center h2BindingTitle">搜索会员</h2>
                        <div class="col-sm-8 col-sm-offset-2 inputBindingBox">
                            <form>
                                <div class="form-group">
                                    <input type="text"
                                           class="form-control uglyInput"
                                           placeholder="&nbsp;输入手机号或会员卡号或会员名称进行搜索"
                                           ng-model="keywordsTel"/>
                                    <button type="submit"
                                            class="btn btn-success w40Btn"
                                            ng-click="searchBindingUser()"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

<!-- 新会员绑定模态框 -->
    <div class="modal fade" id="bindingNewUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 50%;">
            <div class="modal-content clearfix">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">绑定新会员</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <img ng-src="/plugins/checkCard/img/11.png" width="180" style="margin-bottom: 20px;">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label label-words">
                                        <span class="text-danger">*</span>
                                        姓名
                                    </label>
                                    <div class="col-sm-5">
                                        <input class="form-control"
                                               placeholder="请输入姓名"
                                               ng-model="newBindingName"/>
                                    </div>
                                </div>
                                <div class="form-group mt20">
                                    <label class="col-sm-4 control-label label-words">
                                        <span class="text-danger">*</span>
                                        身份证号
                                    </label>
                                    <div class="col-sm-5">
                                        <input type="text"
                                               class="form-control"
                                               placeholder="请输入身份证号"
                                               ng-model="newBindingIdCard"/>
                                    </div>
                                </div>
                                <div class="form-group mt20">
                                    <label class="col-sm-4 control-label label-words">
                                        <span class="text-danger">*</span>
                                        性别
                                    </label>
                                    <div class="col-sm-5">
                                        <select class="form-control pdt4" ng-model="newBindingSex">
                                            <option value="">请选择性别</option>
                                            <option value="1">男</option>
                                            <option value="2">女</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mt20">
                                    <label class="col-sm-4 control-label label-words">
                                        <span class="text-danger">*</span>
                                        手机号
                                    </label>
                                    <div class="col-sm-3 pdr0">
                                        <input type="number"
                                               inputnum
                                               class="form-control"
                                               placeholder="请输入手机号"
                                               ng-model="newBindingMobile"/>
                                    </div>
                                    <div class="col-sm-2 pdl0">
                                        <button class="btn btn-info btn-block codeBtn"
                                                ng-click="getCode()"
                                                ng-bind="paracont"
                                                ng-disabled="disabled"
                                               value="获取验证码"></button>
                                    </div>
                                </div>
                                <div class="form-group mt20">
                                    <label class="col-sm-4 control-label label-words">
                                        <span class="text-danger">*</span>
                                        验证码
                                    </label>
                                    <div class="col-sm-5">
                                        <input type="number"
                                               class="form-control"
                                               placeholder="请输入验证码"
                                               ng-model="newBindingCode"/>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success center-block w100"
                            ng-click="newBindingSuccess()"
                            ladda="checkButton">完成</button>
                </div>
            </div>
        </div>
    </div>

<!-- 绑定老会员详情的模态框 -->
    <div class="modal fade" id="bindingUserDetailsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 50%;">
            <div class="modal-content clearfix">
                <div class="modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">绑定会员</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-6 text-center">
                                <img class="" ng-src="/plugins/checkCard/img/11.png" width="180">
                            </div>
                            <div class="col-sm-6">
                                <p class="bindingUserName nameU">姓名:
                                    <span>{{userInfoNews.name| noData:''}}</span>
                                </p>
                                <p class="bindingUserTel">性别:
                                    <span ng-if="userInfoNews.memberDetails.sex == 1">男</span>
                                    <span ng-if="userInfoNews.memberDetails.sex == 2">女</span>
                                    <span ng-if="userInfoNews.memberDetails.sex == null">暂无数据</span>
                                    <span ng-if="userInfoNews.memberDetails.sex == 0">暂无数据</span>
                                </p>
                                <p class="bindingUserTel">生日:
                                    <span>{{userInfoNews.memberDetails.birth_date| noData:''}}</span>
                                </p>
                                <p class="bindingUserTel">身份证号:
                                    <span>{{userInfoNews.memberDetails.id_card| noData:''}}</span>
                                </p>
                                <p class="bindingUserTel">手机号:
                                    <span>{{userInfoNews.mobile| noData:''}}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success center-block w100"
                            ng-click="bindingOldUserSendCard()"
                            ladda="checkButton">绑定会员</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

</div>
