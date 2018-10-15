<?php
use backend\assets\MemberAsset;

MemberAsset::register($this);
$this->title = '会员管理';
?>
<!--<header>-->
<div ng-controller="indexCtrl" ng-cloak>
<!--    <div class="wrapper wrapper-content animated fadeIn">-->
<!--        <div class="row">-->
<!--             <div class="col-sm-12">-->
    <!--条件筛选-->
                <div class="panel panel-default ">
                    <div class="panel-heading">
                        <span style="display: inline-block"><b class="spanSmall">正式会员</b></span>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-6 userHeader" style="">
                            <div class="input-group">
                                <input type="text" class="form-control userHeaders" ng-model="keywords" ng-keyup="enterSearch($event)" placeholder=" 请输入会员名、手机号、卡号、IC卡号、身份证号或卡名进行搜索...">
                                <span class="input-group-btn">
                                    <button type="button" ng-click="searchCard()" class="btn btn-primary" memberlist>搜索</button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <h4 class="a3">条件筛选</h4>
                        </div>
                        <div class=" col-sm-12 pd0 clearfix userHeadeChoice " style="display: inline-flex;flex-wrap: wrap;">
                            <div class="input-daterange input-group fl cp mR10 mT10" id="container" style="width: 300px;margin-bottom: -2px;">
                                <div class="input-daterange input-group cp userTimeRecord" id="container" >
                                    <span class="add-on input-group-addon" >
                                        激活时间
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar userRecodeTimes"></i>
                                    </span>
                                    <input type="text" ng-model="dateTime" readonly name="reservation" id="reservation" style="width: 200px!important;"
                                           class="form-control text-center userSelectTime" value="" placeholder="选择时间"/>
                                </div>
                            </div>
                            <div class="input-daterange input-group fl cp mR10 mT10" id="container1" style="width: 300px;margin-bottom: -2px;">
                                <div class="input-daterange input-group cp userTimeRecord" id="container1" >
                                    <span class="add-on input-group-addon" >
                                        购卡时间
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar userRecodeTimes"></i>
                                    </span>
                                    <input type="text" ng-model="cardDateTime" readonly name="cardReservation" id="cardReservation" style="width: 200px!important;"
                                           class="form-control text-center userSelectTime" value="" placeholder="选择时间"/>
                                </div>
                            </div>
                            <div class="input-daterange input-group fl cp mR10 mT10" id="container" style="width: 300px;margin-bottom: -2px;">
                                <div class="input-daterange input-group cp" id="container">
                                    <span class="add-on input-group-addon">
                                        购课时间
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar userRecodeTimes"></i>
                                    </span>
                                    <input type="text" ng-model="buyClassTime" readonly id="buyClassLimit" style="width: 200px!important;"
                                           class="form-control text-center" value="" placeholder="选择时间"/>
                                </div>
                            </div>
                            <div class="input-daterange input-group fl cp mR10 mT10" id="container" style="width: 300px;margin-bottom: -2px;">
                                <div class="input-daterange input-group cp" id="container">
                                    <span class="add-on input-group-addon">
                                        生日会员
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar userRecodeTimes"></i>
                                    </span>
                                    <input type="text" ng-model="dateTime" readonly id="birthUserLimit" style="width: 200px!important;"
                                           class="form-control text-center" value="" placeholder="选择时间"/>
                                </div>
                            </div>
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
                                <select class="form-control fl selectCss" ng-model="privatesData" style="padding: 4px 6px">
                                    <option value="">私教课购买</option>
                                    <option value="1">已购买</option>
                                    <option value="2">未购买</option>
                                </select>
                            </div>
<!--                            <div class=" fl pdLr0 mR10 mT10" style="width: 150px;">-->
<!--                                <select ng-model="type" class="form-control fl selectCss" >-->
<!--                                    <option value="">选择卡类别</option>-->
<!--                                    <option value="1">时间卡</option>-->
<!--                                    <option value="2">次卡</option>-->
<!--                                    <option value="3">充值卡</option>-->
<!--                                    <option value="4">混合卡</option>-->
<!--                                </select>-->
<!--                            </div>-->
<!--                            <div class="fl pdLr0 mR10 mT10" style="width: 120px;position: relative;">-->
<!--                                <lable for="id_label_single form-control" class="fontNormal" >-->
<!--                                    <select ng-change="chooseSelectSale()" ng-model="selectSale " class="selectCss js-example-basic-single form-control " style="padding: 4px 12px;width: 120px;height: 30px;" id="idLabelSingle">-->
<!--                                        <option value="" >选择销售</option>-->
<!--                                        <option value="{{types.id}}" ng-repeat="types in optionSale">{{types.name}}-->
<!--                                        </option>-->
<!--                                    </select>-->
<!--                                </lable>-->
<!--                            </div>-->
                            <div class="fl pdLr0 mR10 mT10" style="width: 120px;">
                                <select class="form-control selectCss fl " style='height: 30px;' ng-model="allStates"  ng-change="cardStatusPost()">
                                    <option value="">全部状态</option>
                                    <option value="1">即将到期</option>
                                    <option value="2">沉睡会员</option>
                                    <option value="3">到期会员</option>
                                    <option value="4">通店会员</option>
                                    <option value="5">失效会员</option>
                                    <option value="8">有效会员</option>
                                    <option value="vacate">已请假</option>
                                    <option value="freeze">已冻结</option>
<!--                                    <option value="6">有卡会员</option>-->
<!--                                    <option value="7">无卡会员</option>-->
                                </select>
                            </div>
                            <div class="fl pdLr0 mR10 mT10" style="width: 120px;position: relative;">
                                <lable for="id_label_single form-control" class="fontNormal" >
                                    <select ng-change="chooseSelectSale()" ng-model="selectSale " class="selectCss js-example-basic-single form-control " style="padding: 4px 12px;width: 120px;height: 30px;" id="idLabelSingle">
                                        <option value="" >选择会籍顾问</option>
                                        <option value="{{types.id}}" ng-repeat="types in optionSale">{{types.name}}
                                        </option>
                                    </select>
                                </lable>
                            </div>
                            <div class="fl pdLr0 mR10 mT10" style="width: 135px;">
                                <label for="" style="font-weight: unset;">
                                    <select class="form-control selectCss" ng-model="isDistributionCoach" ng-change="isCoachChange(isDistributionCoach)">
                                        <option value="">是否分配私教</option>
                                        <option value="1">已分配私教</option>
                                        <option value="2">未分配私教</option>
                                    </select>
                                </label>
                            </div>
                            <div class="fl pdLr0 mR10 mT10" style="width: 135px;">
                                <label for="" style="font-weight: unset;">
                                    <select class="form-control selectCss" ng-model="choosePrivateTeach">
                                        <option value="">选择私教教练</option>
                                        <option ng-repeat="allCoach in allPrivateCoachList" value="{{allCoach.id}}">{{allCoach.name}}</option>
                                    </select>
                                </label>
                            </div>
<!--                            <div class="fl mR10 mT10"  style="width: 120px;">-->
<!--                                <select class="form-control selectCss" style="padding: 4px 12px;height: 30px;" ng-model="trialClass">-->
<!--                                    <option value="">剩余体验课</option>-->
<!--                                    <option value="2">2节体验课</option>-->
<!--                                    <option value="1">1节体验课</option>-->
<!--                                    <option value="0">0节体验课</option>-->
<!--                                </select>-->
<!--                            </div>-->
                            <div class="fl mR10 clearfix mT10">
                                <button type="button" ladda="searchCarding" ng-click="searchCard()"
                                        class="btn btn-sm btn-success ladda-button fl mR10" memberlist>确定
                                </button>
                                <button type="button" ladda="searchCarding" ng-click="searchClear()"
                                        class="btn btn-sm btn-info fl mR10">清空
                                </button>
                                <button type="button" ladda="searchCarding" ng-click="birthdayRemind()"
                                        class="btn btn-sm btn-warning ">生日提醒
                                </button>
                            </div>
                            
                        </div>
                    </div>
                </div>
    <!--列表渲染-->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DISTRIBUTIONCOACH')) { ?>
                            <button class="btn btn-info" ng-click="distributionCoach()" ng-if="distributionCoachBtn && isDistributionCoach == '2'">分配私教</button>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-sm-12 userListDetail">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title clearfix">
                            <h5>会员基本信息列表&nbsp;<span class="a16">点击列表查看详情</span></h5>
                        </div>
                        <div class="ibox-content" style="padding: 0">
                            <div style="padding-bottom: 0;" id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <table class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                    id="DataTables_Table_0"
                                    aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th style="width: 120px;background: #fff;" ng-if="distributionCoachBtn && isDistributionCoach == '2'">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="chooseOnePage" style="vertical-align: text-bottom;">
                                                    <span>选择本页</span>
                                                </label>
                                            </div>
                                        </th>
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
<!--                                        有效期注释-->
<!--                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 260px;">-->
<!--                                            <span class="glyphicon glyphicon-time" aria-hidden="true" ng-click="changeSort('member_active_time',sort)"></span>&nbsp;有效期-->
<!--                                        </th>-->
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" style="width: 180px;"><span
                                                class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span>&nbsp;会籍顾问
                                        </th>
<!--                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"-->
<!--                                            colspan="1" style="width: 120px;"><span-->
<!--                                                class="glyphicon glyphicon-jpy" aria-hidden="true"></span>&nbsp;押金-->
<!--                                        </th>-->
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" style="width: 260px;"><span class="glyphicon glyphicon-edit"
                                                                                    aria-hidden="true"></span>&nbsp;操作
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody id="memberTbody" memberlist>
                                        <?=$data;?>
                                    </tbody>
                                </table>
                                <!--分页-->
                                <div class="row" style="margin-left: 0;margin-right: 0; display: flex;align-items: center;">
                                    <div class="col-sm-12" style="padding-left: 0;padding-right: 0;text-center;position: relative;">
<!--                                        <section  style=" font-size: 14px;padding-left: 6px;padding-right: 0;position: absolute;left: 40px;top: 20px;" class="col-sm-2">-->
<!--                                            第<input style="width: 50px;padding: 4px 4px;height: 24px;border-radius: 3px;border:solid 1px #E5E5E5;" type="number" class="" checknum placeholder="几" ng-model="pageNum">页-->
<!--                                            <button class="btn btn-primary btn-sm" ng-click="skipPage(pageNum)">跳转</button>-->
<!--                                        </section>-->
<!--                                        <div class="col-sm-12">-->
<!--                                            <nav class="text-center" huien="moduleHuien" compileval="--><?//=isset($page)?$page:'pages'?><!--" compileview="">-->
<!--                                                --><?//=$pages;?>
<!--                                            </nav>-->
<!--                                        </div>-->
                                        <?=$this->render('@app/views/common/page.php');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    <!--会员指纹验证-->
    <?= $this->render('@app/views/member/memberFinger.php'); ?>

    <!--会员详情信息模态框-->
    <?= $this->render('@app/views/member/memberInfo.php'); ?>

    <!--私课延期模态框、请假、冻结、定金-->
    <?= $this->render('@app/views/member/memberOther.php'); ?>
    
    <!--私教购买、分配私教模态框、赠送模态框、自定义销售来源、IC卡绑定、续费、转课、修改剩余节数、私课修改、选择课程、私教分配选择教练模态框-->
    <?= $this->render('@app/views/member/memberCouserInfo.php'); ?>

    <!--会员信息修改、会员卡信息修改、私教课修改、柜子信息修改-->
    <?= $this->render('@app/views/member/memberInfoRevise.php'); ?>

    <!--会员卡续费模态框、会员卡升级模态框、会员卡信息修改模态框、会员卡转让模态框、会员卡详情信息模态框、会员卡赠送天数模态框、会员卡金额修改-->
    <?= $this->render('@app/views/member/memberCardDetails.php'); ?>

    <!--二次购卡、绑定会员模态框、绑定老会员模态框、新会员绑定模态框、绑定老会员详情的模态框-->
    <?= $this->render('@app/views/member/memberBuyCard.php'); ?>

    <!--带人卡绑定-->
    <?= $this->render('@app/views/member/memberTogetherCard.php'); ?>
    <!--会员卡转移-->
    <?= $this->render('@app/views/member/transferPeopleModal.php'); ?>
    <!--私课会员协议信息-->
    <?= $this->render('@app/views/member/contractInfoModal.php'); ?>
    <!--上传私教合同-->
    <?= $this->render('@app/views/member/uploadContract.php'); ?>
    <!--定金信息记录修改定金模态框-->
    <?= $this->render('@app/views/member/updateDepositModal.php'); ?>
    <div class="modal fade" id="myModalsVenue" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="width: 720px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">修改归属场馆</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 heightCenter">
                            <div  class="col-sm-4 col-sm-offset-1 text-right "><span class="red f16">*</span>场馆</div>
                            <div class="col-sm-4 text-center">
                                <select class="form-control selectPd" ng-model="currentVenueId">
                                    <option value="">请选择场馆</option>
                                    <option value="{{currentArr.id}}" ng-repeat="currentArr in currentVenue" ng-selected="memberDefaultSexFlag ==1">{{currentArr.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer " style="text-align: center;">
                    <button id="submitMobile" style="width: 100px;" type="button" class="btn btn-success "
                            ng-click="updateCurrentVenue(memberIds)">
                        完成
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
        <!--            <div class="modal-dialog">-->
        <!--                <div class="modal-content">-->
        <!--                    <div class="modal-header">-->
        <!--                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">-->
        <!--                            &times;-->
        <!--                        </button>-->
        <!--                        <h3 class="text-center myModalLabel1" id="myModalLabel">-->
        <!--                            编辑手机号-->
        <!--                        </h3>-->
        <!--                    </div>-->
        <!--                    <div class="modal-body " style="margin-left: 0px;">-->
        <!--                        <div class="col-sm-12" style="margin-left: 0px;">-->
        <!--                            <div class="form-group col-sm-4 text-right">输入手机号</div>-->
        <!--                            <div class="form-group col-sm-6 text-center">-->
        <!--                                <input type="text" ng-if="memberData.mobile != 0" class="form-control" id="editMobile"-->
        <!--                                       maxlength="11" value="{{memberData.mobile}}" placeholder="请输入手机号">-->
        <!--                                <input type="text" ng-if="memberData.mobile == 0" class="form-control" id="editMobile"-->
        <!--                                       maxlength="11" placeholder="暂无数据">-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                        <div class="col-sm-12">-->
        <!--                            <div  class="col-sm-4 text-right">性别</div>-->
        <!--                            <div class="col-sm-6 text-center">-->
        <!--                                <select class="form-control" ng-model="memberDefaultSex">-->
        <!--                                    <option value="1" selected>男</option>-->
        <!--                                    <option value="2">女</option>-->
        <!--                                </select>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!---->
        <!--                    </div>-->
        <!--                    <div class="modal-footer">-->
        <!--                        <center>-->
        <!--                            <button id="submitMobile" type="button" class="btn btn-success  btn-lg"-->
        <!--                                    ng-click="updateMobile(memberData.id)">-->
        <!--                                完成-->
        <!--                            </button>-->
        <!--                        </center>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
    </div>
</div>
