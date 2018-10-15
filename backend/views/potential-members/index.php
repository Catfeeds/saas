<?php
use backend\assets\PotentialMembersAsset;
PotentialMembersAsset::register($this);
$this->title = '潜在会员';
?>
<div class="container-fluid pd0" ng-controller="potentialCtrl" ng-cloak>
    <?= $this->render('@app/views/common/csrf.php') ?>
    <div class="panel panel-default ">
        <div class="panel-heading">
            <span  style="display: inline-block;"><b class="spanSmall">潜在会员</b></span></div>
        <div class="panel-body">
            <div class="col-sm-12 mainBox">
                <div class="col-sm-12 pd0">
<!--                    <div class="col-sm-2 pd0 mrr5">-->
<!--                        <label for="id_label_single">-->
<!--                            <select  ng-change="companyChange(companyId)" ng-model="companyId" class="form-control" style="width: 110px;padding-top: 4px;" id="id_label_single" ng-if="identifyCompany == 'admin'">-->
<!--                                <option value="">选择公司</option>-->
<!--                                <option ng-repeat="xx in companyList" value="{{xx.id}}">{{xx.name}}</option>-->
<!--                            </select>-->
<!--                        </label>-->
<!--                    </div>-->
                    <div class="col-sm-2 pd0 venueChangeBigBox">
<!--                        <label for="id_label_single">-->
<!--                            <select id="venueId"  ng-model="changeVenueId" ng-change="changeVenue(changeVenueId)" class=" form-control" style="width: 160px;padding-top: 4px;" >-->
<!--                                <option value="">选择场馆</option>-->
<!--                                <option ng-repeat="aa in venueListInfo" value="{{aa.id}}">{{aa.name}}</option>-->
<!--                            </select>-->
<!--                        </label>-->
                        <select id="venueId"  ng-model="changeVenueId" ng-change="changeVenue(changeVenueId)" class=" form-control" style="padding-top: 4px;" >
                            <option value="">选择场馆</option>
                            <option ng-repeat="aa in venueListInfo" value="{{aa.id}}">{{aa.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-2 pd0 sellChangeBigBox">
<!--                        <label for="id_label_single">-->
<!--                            <select  ng-model="changeSectleValue"  ng-change="changeSectle(changeSectleValue)" class=" form-control" style="width: 110px;padding-top: 4px;" id="id_label_single">-->
<!--                                <option value="">销售来源</option>-->
<!--                                <option value="{{w.id}}" ng-repeat="w in memberSearchData">{{w.value}}</option>-->
<!--                            </select>-->
<!--                        </label>-->
                        <select  ng-model="changeSectleValue"  ng-change="changeSectle(changeSectleValue)" class=" form-control" style="padding-top: 4px;" id="id_label_single">
                            <option value="">销售来源</option>
                            <option value="{{w.id}}" ng-repeat="w in memberSearchData">{{w.value}}</option>
                        </select>
                    </div>
                    <div class="col-sm-6 pull-left" style="padding-left: 0;">
                        <div class="input-group w1280W">
                            <input type="text" ng-keydown="enterSearch()" class="form-control searchInput" placeholder="  请输入姓名和手机号进行搜索..."
                                   ng-model="input.searchValue">
                            <span class="input-group-btn">
                                <button type="button" ng-click="searchClick()" class="btn btn-success" style="left: -2px;">搜索</button>
                            </span>
                            <span class="input-group-btn"><button type="button" ng-click="clearSearch()" class="btn btn-info" style="margin-left: 15px;border-radius: 3px">清空</button></span>
                        </div>
                    </div>
                    <div class="col-sm-2 pd0 bgf">
                        <?php if(\backend\models\AuthRole::canRoleByAuth('potentialMember','ADD')){ ?>
                            <div class="col-sm-12">
                                <button class="btn btn-success pull-right" ng-click="addUser()">新增潜在会员</button>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-sm-12 pd0 mainBoxWWW">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div id="DataTables_Table_0_wrapper"
                                 class="dataTables_wrapper form-inline" role="grid">
                                <table class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                       id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <?php if(\backend\models\AuthRole::canRoleByAuth('potentialMember','NAMESHOW')){ ?>
                                            <th ng-click="changeSort('userName',sort)" class="sorting"
                                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;">
                                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;姓名
                                            </th>
                                        <?php } ?>

                                        <th ng-click="changeSort('sex',sort)" class="sorting"
                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 80px;">性别
                                        </th>
                                        <?php if(\backend\models\AuthRole::canRoleByAuth('potentialMember','MOBILESHOW')){ ?>
                                            <th ng-click="changeSort('mobile',sort)" class="sorting"
                                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;">
                                                <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span>&nbsp;手机号
                                            </th>
                                        <?php } ?>

                                        <th ng-click="changeSort('counselorName',sort)" class="sorting"
                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">
                                            <span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span>&nbsp;公司
                                        </th>
                                        <th ng-click="changeSort('counselorName',sort)" class="sorting"
                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">
                                            <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>&nbsp;场馆
                                        </th>
                                        <th ng-click="changeSort('wayToShop',sort)" class="sorting"
                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;">
                                            <span class="glyphicon glyphicon-tree-conifer" aria-hidden="true"></span>&nbsp;来源
                                        </th>
                                        <th ng-click="changeSort('counselorName',sort)" class="sorting"
                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;">
                                            <span class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span>&nbsp;客服
                                        </th>
                                        <th ng-click="changeSort('entryTime',sort)" class="sorting"
                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">
                                            <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>&nbsp;最近入场
                                        </th>
                                        <th ng-click="changeSort('entryTime',sort)" class="sorting"
                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">
                                            <span class="glyphicon glyphicon-time" aria-hidden="true"></span>&nbsp;跟进时间
                                        </th>
                                        <th class="sorting" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" style="width: 200px;"><span class="glyphicon glyphicon-pencil"
                                                                                    aria-hidden="true"></span>&nbsp;操作
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr style="hoverTr" ng-repeat="w in listDate">
                                        <?php if(\backend\models\AuthRole::canRoleByAuth('potentialMember','NAMESHOW')){ ?>
                                            <td ng-click="potentialDetails(w.id)">{{w.username | noData:''}}</td>
                                        <?php } ?>
                                        <td ng-click="potentialDetails(w.id)" ng-if="w.sex != ''">{{w.sex == 1 ? "男":w.sex == 2 ? "女":"暂无"}}</td>
                                        <td ng-click="potentialDetails(w.id)" ng-if="w.sex == ''">不详</td>
                                        <?php if(\backend\models\AuthRole::canRoleByAuth('potentialMember','MOBILESHOW')){ ?>
                                            <td ng-click="potentialDetails(w.id)" ng-if="w.mobile != null">{{w.mobile}}</td>
                                        <?php } ?>
                                        <td ng-click="potentialDetails(w.id)" ng-if="w.mobile == null">暂无数据</td>
                                        <td ng-click="potentialDetails(w.id)" ng-if="w.companyName != null">{{w.companyName}}</td>
                                        <td ng-click="potentialDetails(w.id)" ng-if="w.companyName == null">暂无数据</td>
                                        <td ng-click="potentialDetails(w.id)" ng-if="w.venueName != null">{{w.venueName}}</td>
                                        <td ng-click="potentialDetails(w.id)" ng-if="w.venueName == null">暂无数据</td>
                                        <td ng-click="potentialDetails(w.id)" ng-if="w.source !=null">{{w.source}}</td>
                                        <td ng-click="potentialDetails(w.id)" ng-if="w.source == null">暂无数据</td>
                                        <td ng-click="potentialDetails(w.id)">{{w.counselorName | noData:''}}</td>
                                        <td ng-click="potentialDetails(w.id)">{{w.entryRecord.entry_time != null ? (w.entryRecord.entry_time *1000| date:'yyyy-MM-dd HH:mm'):'暂无数据'}}
                                        </td>
                                        <td ng-click="potentialDetails(w.id)">{{w.entryRecord.entry_time != null ? (w.entryRecord.entry_time *1000| date:'yyyy-MM-dd HH:mm'):'暂无数据'}}
                                        </td>
                                        <td>
                                            <div class="col-sm-12 pd0" style="display: flex;justify-content: space-around;flex-wrap: wrap;">

                                                <?php if(\backend\models\AuthRole::canRoleByAuth('potentialMember','VENUEBOOK')){ ?>
<!--                                                    ng-if="w.yardAboutStatus == 3"-->
                                                    <button class="btn btn-info btn-sm hoverBtn tdBtn"
                                                            ng-click="field(w.id,w.member_type)">场地
                                                    </button>
                                                <?php } ?>
<!--
<!--                                                <button class="btn btn-info btn-sm hoverBtn tdBtn" ng-if="w.yardAboutStatus == 1 || w.yardAboutStatus == 2" -->
<!--                                                        ng-disabled="w.yardAboutStatus == 2" -->
<!--                                                        ng-click="cancelReservationYard(w.aboutYardId)">取消场地预约-->
<!--                                                </button>-->
                                                <?php if(\backend\models\AuthRole::canRoleByAuth('potentialMember','ABOUT')){ ?>
<!--                                                    ng-if="w.aboutClass == null"-->
                                                    <button class="btn btn-primary btn-sm hoverBtn tdBtn"
                                                            ng-click="reservationCourse(w.id,w.member_type)">约课
                                                    </button>
<!--                                                    <button class="btn btn-default btn-sm hoverBtn tdBtn" ng-if="w.aboutClass != null"-->
<!--                                                            ng-click="potentialMemberCancelAppointment(w.aboutClass.id)">取消约课-->
<!--                                                    </button>-->
                                                <?php } ?>
                                                <?php if(\backend\models\AuthRole::canRoleByAuth('potentialMember','SEll')){ ?>
                                                    <button class="btn btn-success  btn-sm hoverBtn tdBtn"
                                                            ng-click="sellingData(w.username,w.mobile,w.sex,w,w.member_id)">购卡
                                                    </button>
                                                <?php } ?>
                                                <?php if(\backend\models\AuthRole::canRoleByAuth('potentialMember','DELETE')){ ?>
                                                    <button class="btn btn-danger btn-sm hoverBtn mL6 tdBtn"
                                                            ng-click="removeMember(w.member_id,w.username)" style="margin-left: 0px;">删除
                                                    </button>
                                                <?php } ?>
                                                <?php if(\backend\models\AuthRole::canRoleByAuth('potentialMember','DEPOSIT')){ ?>
<!--                                                    <button class="btn btn-success btn-sm tdBtn"  ng-click="deposit(w.member_id,w.username)" ng-if="w.price ==null">定金</button>-->
                                                    <button class="btn btn-success btn-sm tdBtn"  ng-click="deposit(w.member_id,w.username)">定金</button>
                                                <?php } ?>
                                                <?php if(\backend\models\AuthRole::canRoleByAuth('potentialMember','UPDATE')){ ?>
                                                    <button class="btn btn-warning btn-sm tdBtn"    ng-click="updateUser(w.member_id,w.username,w.mobile,w)">修改</button>
                                                <?php } ?>
                                                <button class="btn btn-primary  btn-sm hoverBtn tdBtn"
                                                        ng-click="followUp(w.member_id)">跟进
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?=$this->render('@app/views/common/nodata.php',['name'=>'payNoMoneyDataShow','text'=>'暂无潜在会员','href'=>true]);?>
                                <?=$this->render('@app/views/common/page.php');?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--    潜在会员详情模态框-->
    <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog myModalCon" role="document" style="width: 60%">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title myModalLabel1" >潜在会员详情</h4>
                    <div class="col-sm-12 text-center tabBig">
                        <div class="col-sm-4 pd0 tabBox tabT1 activeBox">基本信息</div>
                        <div class="col-sm-4 pd0 tabBox tabT2" ng-click="sendCardTal()">赠卡详情</div>
                        <div class="col-sm-4 pd0 tabBox tabT3" ng-click="SelectMessage('')">消息记录</div>
                    </div>
                    <div class="col-sm-12 myModalDiv1 heightCenter" >
                        <div class="col-sm-6 pd0">
                            <img class="imgHeader"  ng-if="potentialDetail.pic != null" ng-src="{{potentialDetail.pic}}">
                            <img class="imgHeader"  ng-if="potentialDetail.pic == null" ng-src="/plugins/checkCard/img/11.png">
                        </div>
                        <div class="col-sm-6 pd0">
                            <p style="font-size: 18px;margin-bottom: 10px">会员姓名：{{potentialDetail.name| noData:''}}</p>
                            <p class="myModalFontSize" style="margin-bottom: 10px">会员编号：{{potentialDetail.id}}</p>
                            <p class="myModalFontSize" style="margin-bottom: 10px">会员性别：<span ng-if="potentialDetail.sex !=0&& potentialDetail.sex != null">{{potentialDetail.sex == 1 ? "男":"女" }}</span><span ng-if="potentialDetail.sex == 0 || potentialDetail.sex == '' || potentialDetail.sex == null ">暂无数据</span></p>
<!--                            <p class="myModalFontSize">生日：{{potentialDetail.birth_date}}</p>-->
                            <p class="myModalFontSize" style="margin-bottom: 10px">会员生日：{{potentialDetail.birth_date| noData:''}}</p>
                            <p class="myModalFontSize" style="margin-bottom: 10px">证件类型：
                                <span ng-if="potentialDetail.document_type ==null">暂无数据</span>
                                <span ng-if="potentialDetail.document_type =='1'">身份证</span>
                                <span ng-if="potentialDetail.document_type =='2'">居住证</span>
                                <span ng-if="potentialDetail.document_type =='3'">签证</span>
                                <span ng-if="potentialDetail.document_type =='4'">护照</span>
                                <span ng-if="potentialDetail.document_type =='5'">户口本</span>
                                <span ng-if="potentialDetail.document_type =='6'">军人证</span>
                            </p>
                            <p class="myModalFontSize" style="margin-bottom: 10px">证件号码：{{potentialDetail.id_card| noData:''}}</p>
                            <p class="myModalFontSize" style="margin-bottom: 10px">手机号码：{{potentialDetail.mobile| noData:''}}</p>
<!--                            <p class="myModalFontSize" style="margin-bottom: 10px" ng-if="potentialDetail.aboutClass != 0">免费约课：剩余{{potentialDetail.aboutClass}}节</p>-->
<!--                            <p class="myModalFontSize" style="margin-bottom: 10px" ng-if="potentialDetail.aboutClass == 0">免费约课：剩余0节</p>-->
                            <p class="myModalFontSize" style="margin-bottom: 10px">备注内容：{{potentialDetail.params | stringToJson:'note' | noData:''}}</p>
                            <p class="myModalFontSize" style="margin-bottom: 10px" ng-if="potentialDetail.groundVenue !== null">场地名称：{{potentialDetail.groundVenue}} - {{potentialDetail.yard_name| noData:''}}</p>
                            <p class="myModalFontSize" style="margin-bottom: 10px" ng-if="potentialDetail.groundVenue  == null">场地名称：{{potentialDetail.yard_name| noData:''}}</p>
                            <p class="myModalFontSize" style="margin-bottom: 10px" ng-if="potentialDetail.yardAboutDate != null">预约时间：{{potentialDetail.yardAboutDate *1000| date:'yyyy-MM-dd HH:mm:ss' | noData:''}}</p>
                            <p class="myModalFontSize" style="margin-bottom: 10px" ng-if="potentialDetail.yardAboutDate == null">预约时间：暂无数据</p>
                            <p class="myModalFontSize" style="margin-bottom: 10px">预约区间：{{potentialDetail.aboutDate| noData:''}} {{potentialDetail.about_interval_section| noData:''}}</p>
                            <p class="myModalFontSize" style="margin-bottom: 10px" ng-if="potentialDetail.venueName == null">约课场馆：{{potentialDetail.classroomName| noData:''}}</p>
                            <p class="myModalFontSize" style="margin-bottom: 10px" ng-if="potentialDetail.venueName !== null">约课场馆：{{potentialDetail.venueName}} - {{potentialDetail.classroomName| noData:''}}</p>
                            <p class="myModalFontSize" style="margin-bottom: 10px">课程名称：{{potentialDetail.courseName| noData:''}}</p>
                            <p class="myModalFontSize" style="margin-bottom: 10px">约课位置：{{potentialDetail.seat_number| noData:''}}</p>
                            <p class="myModalFontSize" style="margin-bottom: 10px" ng-if="potentialDetail.start != null&&potentialDetail.start != ''&& potentialDetail.start != undefined">开始时间：{{potentialDetail.start*1000 | date:'yyyy-MM-dd HH:mm:ss'}}</p>
                            <p class="myModalFontSize" ng-if="potentialDetail.start == null || potentialDetail.start == '' || potentialDetail.start == undefined" >开始时间：暂无数据</p>
                            <p class="myModalFontSize" style="margin-bottom: 40px" ng-if="potentialDetail.end != null&&potentialDetail.end != ''&& potentialDetail.end != undefined">结束时间：{{potentialDetail.end*1000 | date:'yyyy-MM-dd HH:mm:ss'}}</p>
                            <p class="myModalFontSize" style="margin-top: 10px;margin-bottom: 40px" ng-if="potentialDetail.end == null || potentialDetail.end == '' || potentialDetail.end == undefined" >结束时间：暂无数据</p>
                            <div class="col-sm-12 pdLr0" style="margin-bottom: 20px;" >
                                <button class="btn btn-success btn-sm" ng-if="potentialDetail.aboutClassId != false" ng-click="aboutPrints(printers)">&emsp;课程打印&emsp;</button>
                                <button class="btn btn-info btn-sm" ng-if="potentialDetail.yardAboutDate != null && potentialDetail.yardAboutDate != ''" ng-click="aboutPrintsField(potentialDetail)">&emsp;场地打印&emsp;</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 myModalDiv2">
                        <div class="col-sm-12 pd mr20">
                            <div class="col-sm-5">
                                <img ng-src="/plugins/img/card111.png" width="300">
                            </div>
                            <div class="col-sm-7">
                                <p class="sendCardName">
                                    <span ng-if="cardInfo.card_name != null">{{cardInfo.card_name}}</span>
                                    <span ng-if="cardInfo.card_name == null">暂无数据</span>
                                    <select class="pull-right cardSelectName"
                                            ng-change="getPotentialUserCardInfo(cardId)"
                                            ng-model="cardId"
                                            ng-if="cardList.length != 0">
                                        <option value="{{x}}"
                                                ng-repeat="x in cardList">{{x.card_name}}</option>
                                    </select>
                                </p>
                                <p class="sendCardOther">会员卡号：
                                    <span ng-if="cardInfo.card_number != null">{{cardInfo.card_number}}</span>
                                    <span ng-if="cardInfo.card_number == null">暂无数据</span>
                                </p>
                                <p class="sendCardOther">卡种金额：
                                <span ng-if="cardInfo.amount_money != null">{{cardInfo.amount_money}}</span>
                                <span ng-if="cardInfo.amount_money == null">暂无数据</span>
                                </p>
                                <p class="sendCardOther">总计天数：
                                <span ng-if="cardInfo.duration != null">{{cardInfo.duration}}</span>
                                <span ng-if="cardInfo.duration == null">暂无数据</span>
                                </p>
                                <p class="sendCardOther lastOneP">到期时间：
                                    <span ng-if="cardInfo.invalid_time != null && cardInfo.invalid_time != ''">{{cardInfo.invalid_time*1000|date:'yyyy-MM-dd'}}</span>
                                    <span ng-if="cardInfo.invalid_time == null || cardInfo.invalid_time == ''">暂无数据</span>
                                </p>
<!--                                --><?php if (\backend\models\AuthRole::canRoleByAuth('potentialMember', 'UPDATEMEMBERTIME')) { ?>
                                    <button class="btn btn-info ft13" ng-if="cardInfo.usage_mode == '2' && cardInfo.status != '2'"
                                            ng-click="changeMemberCardTime(cardInfo.id)">
                                        修改
                                    </button>
<!--                                --><?php } ?>
                                <?php if (\backend\models\AuthRole::canRoleByAuth('potentialMember', 'RENEW')) { ?>
                                       <button class="btn btn-success ft13"
                                        ng-click="renewCard(cardInfo.id)"
                                        ng-if="cardInfo.usage_mode == '2' && cardInfo.status != '2'"
                                        data-toggle="modal"
                                        data-target="#renewCardModal">续费</button>
                                <?php  } ?>
                                <?php if (\backend\models\AuthRole::canRoleByAuth('potentialMember', 'UPGRADE')) { ?>
                                <button class="btn btn-warning ft13"
                                        ng-click="updateCard(cardInfo.id,cardInfo.card_category_id,cardInfo.create_at)"
                                        ng-if="cardInfo.usage_mode == '2' && cardInfo.status != '2' && cardInfo.cardCategory.cardCategoryType.id == '1'"
                                        data-toggle="modal"
                                        data-target="#memberCardUpgradeModal">升级</button>
                                <?php  } ?>
                                <?php if (\backend\models\AuthRole::canRoleByAuth('potentialMember', 'BINDCARD')) { ?>
                                <button class="btn btn-primary ft13"
                                        ng-click="bindingUser(cardInfo.id,cardInfo.card_category_id)"
                                        ng-if="cardInfo.usage_mode == '2' && cardInfo.status != '2'">绑定会员</button>
                                <?php  } ?>
                            </div>
                        </div>
                        <div class="col-sm-12 mt20">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title" style="position: relative;">
                                    <h5>缴费记录</h5>
                                </div>
                                <div class="ibox-content tbodySendCard" style="padding: 0;">
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
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                    缴费时间
                                                </th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                    缴费名称
                                                </th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                    缴费金额
                                                </th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                    客服
                                                </th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                    到期日期
                                                </th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">行为
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
                                                    <span ng-if="cardActiveTime == null">未激活</span>
                                                </td>
                                                <td>{{info.category}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <?= $this->render('@app/views/common/nodata.php', ['name' => 'payNoMoneyDataShowS', 'text' => '无消费记录', 'href' => true]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 myModalDiv3">
                        <div class="col-sm-12 mt20">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title" style="position: relative;padding-top: 5px;">
                                    <div class="col-sm-2 pd0">
                                        <select class="form-control w160" ng-model="selectEntryRecord" ng-change="SelectMessage(selectEntryRecord)" style="padding: 0;width: 130px;">
                                            <option value="">送人记录</option>
                                            <option value="1">约课记录</option>
                                            <option value="2">场地记录</option>
                                            <option value="3" class="Deposits">定金信息</option>
                                            <option value="4">最近入场记录</option>
                                            <option value="5">赠卡修改记录</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 Deposit depositSelect DN">
                                        <select class="form-control w160 pull-right depositGetSelect" ng-change="depositSelectChange(depositSelect)" ng-model="depositSelect" style="padding-top: 4px;">
                                            <option value="">请选择缴费定金</option>
                                            <option value="1">购卡定金</option>
                                            <option value="2">购课定金</option>
    <!--                                            <option value="3">续费定金</option>-->
    <!--                                            <option value="4">升级定金</option>-->
                                        </select>
                                    </div>
                                    <div class="col-md-3 Deposit depositSelect DN">
                                        <span style="color: orange;font-size: 16px;font-weight: 700;line-height: 30px;">
                                            定金:{{depositAllMoney}} 元
                                        </span>
                                    </div>
                                </div>
                                <div class="ibox-content tbodySendCardRecord" ng-if='selectEntryRecord == ""' style="padding: 0;">
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
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                    卡名称
                                                </th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                    卡号
                                                </th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                    被赠送人
                                                </th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                    赠送时间
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="info in memberSendCardList">
                                                <td>{{info.card_name}}</td>
                                                <td>{{info.card_number}}</td>
                                                <td>{{info.name}}</td>
                                                <td>
                                                    <span>{{(info.send_time*1000) | date:"yyyy-MM-dd"}}</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <?= $this->render('@app/views/common/nodata.php', ['name' => 'payNoSendCardRecordDataShow', 'text' => '暂无送人记录', 'href' => true]); ?>
                                    </div>
                                </div>
                                <div class="ibox-content tbodySendCardRecord" ng-if="selectEntryRecord == '1'"  style="padding: 0;">
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
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                    约课场馆
                                                </th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                   课程名称
                                                </th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                    教室 - 位置
                                                </th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                    开始时间
                                                </th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                    结束时间
                                                </th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                   操作
                                                </th>
                                            </tr>
                                            </thead>
                                            <tr ng-repeat="maList in memberAboutList">
                                                <td>{{maList.oName}}</td>
                                                <td>{{maList.courseName}}</td>
                                                <td>{{maList.className}} - {{maList.seat_number}}</td>
                                                <td>
                                                    <span>{{(maList.start*1000) | date:"yyyy-MM-dd HH:mm"}}</span>
                                                </td>
                                                <td>
                                                    <span>{{(maList.end*1000) | date:"yyyy-MM-dd HH:mm"}}</span>
                                                </td>
                                                <td>
                                                    <button class="btn btn-default btn-sm hoverBtn tdBtn" ng-if="maList.status == 1"
                                                            ng-click="potentialMemberCancelAppointment(maList.id)">取消约课
                                                    </button>
                                                    <button class="btn btn-default btn-sm hoverBtn tdBtn" ng-if="maList.status == 2" disabled>已取消
                                                    </button>
                                                    <span ng-if="maList.status == 3">上课中</span>
                                                    <span ng-if="maList.status == 4">已下课</span>
                                                    <span ng-if="maList.status == 6">已爽约</span>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <?= $this->render('@app/views/common/nodata.php', ['name' => 'memberAboutDataList', 'text' => '暂无约课记录', 'href' => true]); ?>
                                    </div>
                                </div>
                                <div class="ibox-content tbodySendCardRecord" ng-if="selectEntryRecord == '2'"  style="padding: 0;">
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
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                   场地名称
                                                </th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                    预约时间
                                                </th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                  预约区间
                                                </th>
                                                <th class="bgw"
                                                    tabindex="0"
                                                    rowspan="1"
                                                    colspan="1"
                                                    aria-label="浏览器：激活排序列升序"
                                                    style="width: 100px;">
                                                   操作
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="info in memberYardList">
                                                <td title="{{info.name}} - {{info.vName}}">{{info.name}} - {{info.vName}}</td>
                                                <td>
                                                    <span>{{info.create_at*1000 | date:"yyyy-MM-dd HH:mm"}}</span>
                                                </td>
                                                <td>{{(info.about_start*1000) | date:"yyyy-MM-dd HH:mm"}} - {{(info.about_end*1000) | date:"yyyy-MM-dd HH:mm"}}</td>
                                                <td>
                                                    <button class="btn btn-info btn-sm hoverBtn tdBtn ng-scope" ng-if="info.status == 1 || info.status == 2" ng-click="cancelReservationYard(info)">取消场地预约
                                                    </button>
                                                    <button class="btn btn-error btn-sm hoverBtn tdBtn ng-scope" ng-if="info.status == 5" ng-disabled="info.status == 5">已取消场地
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <?= $this->render('@app/views/common/nodata.php', ['name' => 'memberYardDataList', 'text' => '暂无场地记录', 'href' => true]); ?>
                                    </div>
                                </div>
                                <div ng-if="selectEntryRecord == 3" class="ibox-content tbodySendCardRecord" style="padding: 0;">
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
                                                        colspan="1" aria-label="浏览器：激活排序列升序">定金类型
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">金额
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">有效期
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">付款方式
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">缴定金日期
                                                    </th>
                                                    <th class="a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">操作
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat="zzz in getDepositInfoData">
                                                    <td ng-if="zzz.type == '1' || zzz.type == 1">购卡定金</td>
                                                    <td ng-if="zzz.type == '2' || zzz.type == 2">购课定金</td>
                                                    <!--<td ng-if="zzz.type == '3' || zzz.type == 3">续费定金</td>
                                                    <td ng-if="zzz.type == '4' || zzz.type == 4">升级定金</td>-->
                                                    <td ng-if="zzz.type == undefined || zzz.type == null || zzz.type == ''">暂无数据</td>
                                                    <td>{{zzz.price | number:'2' | noData:''}}</td>
                                                    <!--                                                            <td>{{zzz.voucher | number:'2' | noData:''}}</td>-->
                                                    <td>{{zzz.start_time*1000 | date:'yyyy-MM-dd'}}&nbsp;-&nbsp;{{zzz.end_time*1000 | date:'yyyy-MM-dd'}}</td>
                                                    <td ng-if="zzz.pay_mode == '1' || zzz.pay_mode == 1">现金</td>
                                                    <td ng-if="zzz.pay_mode == '3' || zzz.pay_mode == 3">微信</td>
                                                    <td ng-if="zzz.pay_mode == '2' || zzz.pay_mode == 2">支付宝</td>
                                                    <td ng-if="zzz.pay_mode == '5' || zzz.pay_mode == 5">建设分期</td>
                                                    <td ng-if="zzz.pay_mode == '6' || zzz.pay_mode == 6">广发分期</td>
                                                    <td ng-if="zzz.pay_mode == '7' || zzz.pay_mode == 7">招行分期</td>
                                                    <td ng-if="zzz.pay_mode == '8' || zzz.pay_mode == 8">借记卡</td>
                                                    <td ng-if="zzz.pay_mode == '9' || zzz.pay_mode == 9">贷记卡</td>
                                                    <td ng-if="zzz.pay_mode == undefined || zzz.pay_mode == null || zzz.pay_mode == ''">暂无数据</td>
                                                    <td>{{zzz.pay_money_time*1000 | date:'yyyy-MM-dd'}}</td>
                                                    <td>
                                                        <?php if(\backend\models\AuthRole::canRoleByAuth('potentialMember','DELETEDEPOSIT')){ ?>
                                                            <button type="button" class="btn btn-danger" ng-click="depositInfoDelete(zzz.id)">删除</button>
                                                        <?php } ?>
                                                        <?php if(\backend\models\AuthRole::canRoleByAuth('potentialMember','UPDATEDEPOSIT')){ ?>
                                                            <button type="button" class="btn btn-info" ng-click="depositInfoUpdate(zzz)">修改</button>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'priDelayNoDataShow', 'text' => '无定金记录', 'href' => true]); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="ibox-content tbodySendCardRecord" ng-if='selectEntryRecord =="4"' style="padding: 0;">
                                    <div id="DataTables_Table_0_wrapper"
                                         class="dataTables_wrapper form-inline a26"
                                         role="grid">
                                        <table class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                               id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="position: relative;">
                                            <thead>
                                            <tr role="row">
                                                <th class="bgw" tabindex="0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序" style="width: 100px;">最近入场</th>
                                                <th class="bgw" tabindex="0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序" style="width: 100px;">备注</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr ng-repeat="record in followRecord">
                                                <td>{{record.entry_time*1000 | date:"yyyy-MM-dd HH:mm"}}</td>
                                                <td>{{record.note}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <?= $this->render('@app/views/common/nodata.php',['name' => 'followRecordList','text' => '暂无数据','href' => true]);?>
                                        <?= $this->render('@app/views/common/pagination.php',['page' => 'followPages']);?>
                                    </div>
                                </div>
                                <div class="ibox-content tbodySendCardRecord" ng-if="selectEntryRecord =='5'" style="padding: 0;">
                                    <div id="DataTables_Table_0_wrapper"
                                         class="dataTables_wrapper form-inline a26"
                                         role="grid">
                                        <table class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                               id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info" style="position: relative;">
                                            <thead>
                                                <tr role="row">
                                                    <th class="bgw" tabindex="0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序" style="width: 100px;">卡号</th>
                                                    <th class="bgw" tabindex="0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序" style="width: 100px;">修改项</th>
                                                    <th class="bgw" tabindex="0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序" style="width: 100px;">修改内容</th>
                                                    <th class="bgw" tabindex="0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序" style="width: 100px;">操作人</th>
                                                    <th class="bgw" tabindex="0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序" style="width: 100px;">修改时间</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="timeList in changeTimeLists">
                                                    <td ng-if="timeList.card_number == '' || timeList.card_number == undefined || timeList.card_number == null">暂无数据</td>
                                                    <td ng-if="timeList.card_number != '' && timeList.card_number != undefined && timeList.card_number != null">{{timeList.card_number}}</td>
                                                    <td ng-if="timeList.behavior == 4">激活日期</td>
                                                    <td ng-if="timeList.behavior == 5">到期日期</td>
                                                    <td ng-if="timeList.behavior == '' || timeList.behavior == undefined || timeList.behavior == null">暂无数据</td>
                                                    <td>
                                                        <span ng-if="timeList.old_time == undefined || timeList.old_time == null || timeList.old_time == ''">&emsp;空&emsp;</span>
                                                        <span ng-if="timeList.old_time != undefined && timeList.old_time != null && timeList.old_time != ''">{{timeList.old_time*1000 | date:'yyyy-MM-dd'}}</span>
                                                        改为
                                                        <span>{{timeList.new_time*1000 | date:'yyyy-MM-dd'}}</span>
                                                    </td>
                                                    <td ng-if="timeList.name == '' || timeList.name == undefined || timeList.name == null">暂无数据</td>
                                                    <td ng-if="timeList.name != '' && timeList.name != undefined && timeList.name != null">{{timeList.name}}</td>
                                                    <td>{{timeList.create_at*1000 | date:'yyyy-MM-dd'}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <?= $this->render('@app/views/common/nodata.php',['name' => 'updateRecordList','text' => '暂无数据','href' => true]);?>
                                        <?= $this->render('@app/views/common/pagination.php',['page' => 'updateRecordPages']);?>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!--场地预约-->
    <?= $this->render('@app/views/potential-members/fieldPage.php'); ?>
    <!--送人卡 start-->

    <!--送人卡 升级模态框-->
    <?= $this->render('@app/views/potential-members/memberCardUpgradeModal.php'); ?>
    <!--送人卡 续费模态框-->
    <?= $this->render('@app/views/potential-members/renewCardModal.php'); ?>

    <!--送人卡修改模态框-->
    <div class="modal fade" id="changeCardTimeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title text-center" id="myModalLabel">修改时间</h3>
                </div>
                <div class="modal-body">
                    <div class="row pd15">
                        <div class="col-sm-12 m20">
                            <div class="col-sm-4 lh32 text-right">
                                <label for=""><span class="red">*</span>激活时间：</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="delayActiveCard lh32 inputStyle" ng-model="delayActiveCardChange">
                            </div>
                        </div>
                        <div class="col-sm-12 m20">
                            <div class="col-sm-4 lh32 text-right">
                                <label for=""><span class="red">*</span>到期时间：</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" class="expiryTime lh32 inputStyle" ng-model="expiryTimeChange">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success btn-padding" ng-click="changePresentCardTime()">修改</button>
                    <button type="button" class="btn btn-default btn-padding" data-dismiss="modal">取消</button>
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
                                        会员姓名
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
                                        证件号
                                    </label>
                                    <div class="col-sm-5">
                                        <input type="text"
                                               class="form-control"
                                               placeholder="请输入证件号"
                                               ng-model="newBindingIdCard"/>
                                    </div>
                                </div>
                                <div class="form-group mt20">
                                    <label class="col-sm-4 control-label label-words">
                                        <span class="text-danger">*</span>
                                        会员性别
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
                                        手机号码
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
                                        短信验证
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
                                <p class="bindingUserName nameU">会员姓名:
                                    <span>{{userInfoNews.name| noData:''}}</span>
                                </p>
                                <p class="bindingUserTel">会员性别:
                                    <span ng-if="userInfoNews.memberDetails.sex == 1">男</span>
                                    <span ng-if="userInfoNews.memberDetails.sex == 2">女</span>
                                    <span ng-if="userInfoNews.memberDetails.sex == null">暂无数据</span>
                                    <span ng-if="userInfoNews.memberDetails.sex == 0">暂无数据</span>
                                </p>
                                <p class="bindingUserTel">会员生日:
                                    <span>{{userInfoNews.memberDetails.birth_date| noData:''}}</span>
                                </p>
                                <p class="bindingUserTel">证件号:
                                    <span>{{userInfoNews.memberDetails.id_card| noData:''}}</span>
                                </p>
                                <p class="bindingUserTel">手机号码:
                                    <span>{{userInfoNews.mobile| noData:''}}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success center-block w100" ng-click="bindingOldUserSendCard()">绑定会员</button>
                </div>
            </div>
        </div>
    </div>
<!--end-->

    <!--    新增潜在会员模态框-->
    <div class="modal" id="myModal2" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" >
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close close2" data-dismiss="modal" aria-label="Close" ng-click="closeModalQZuser()"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" >新增潜在会员</h4>
                <div class="col-sm-12 myModal2DivBox" >
                    <div class="col-sm-12">
                        <p>1.基本信息</p>
                        <form class="form-inline formInlineAdd">
                            <div class="col-sm-4 pd0">
                                <div class="form-group">
                                    <label for="exampleInputName2" class="formInlineAddLabel"><span class="formInlineAddSpan">*</span>会员姓名</label>
                                    <input type="text" class="form-control width180"
                                           placeholder="请输入会员姓名" ng-model="memberName" >
                                </div>
                            </div>
                            <div class="col-sm-4 pd0">
                                <div class="form-group">
                                    <label class="formInlineAddLabel"
                                    ><span class="formInlineAddSpan">*</span>手机号</label>
                                    <input type="number" class="form-control" id="exampleInputName3" autocomplete="off"
                                           placeholder="请输入会员手机号" ng-model="memberMobile">
                                </div>
                            </div>
                            <div class="col-sm-4 pd0" >
                                <div class="form-group">
                                    <label class="formInlineAddLabel"><span></span>性别&nbsp;</label>
                                    <select name="" class="form-control"
                                            ng-model="memberSex">
                                        <option value="">请选择性别</option>
                                        <option value="1">男</option>
                                        <option value="2">女</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 pd0">
                                <div class="col-sm-4 pd0" >
                                    <div class="form-group">
                                        <label class="formInlineAddLabel"><span class="red"></span>证件选择&nbsp;</label>
                                        <select name="" class="form-control selectPd width180"
                                                ng-model="selectCredentials" ng-change="selectCredentialsChange(selectCredentials)">
                                            <option value="">请选择证件</option>
                                            <option value="1">身份证</option>
                                            <option value="2">居住证</option>
                                            <option value="3">签证</option>
                                            <option value="4">护照</option>
                                            <option value="5">户口本</option>
                                            <option value="6">军人证</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4 pd0">
                                    <div class="form-group">
                                        <label class="formInlineAddLabel">
<!--                                            <span class="formInlineAddSpan">*</span>-->
                                            &nbsp;&nbsp;证件号</label><input type="text" maxlength="18" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" class="form-control" id="exampleInputName3" autocomplete="off"
                                               placeholder="请输入证件号" ng-change="inputIdCard(idCard)" ng-model="idCard" >
                                    </div>
                                </div>
                                <div class="col-sm-4 pd0 pdl4" style="padding-left: 0;">
                                    <div class="form-group">
<!--                                        <label class="formInlineAddLabel" ><span style="opacity: 0">*</span>生日&nbsp;&nbsp;&nbsp;</label>-->
                                        <label class="formInlineAddLabel" ><span></span>生日&nbsp;</label>
                                        <input class="form-control width180" id="birthdays" type="text" placeholder="" ng-model="birthDate">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 pd0">
                                <div class="col-sm-4 pd0">
                                    <div class="form-group">
                                        <label for="ddlregtype" class="formInlineAddLabel"><span class="formInlineAddSpan">*</span>销售来源</label>
                                        <select id="ddlregtype" class="form-control" ng-change="selectSalesSources(wselectSalesSources)" ng-model="wselectSalesSources">
                                            <option value="">请选择来源渠道</option>
                                            <option value="{{w.id}}" ng-repeat="w in memberSearchData">{{w.value}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 w1280mt20" style="padding-left: 0;">
                                    <?php if(\backend\models\AuthRole::canRoleByAuth('potentialMember','ADDSOURCE')){ ?>
                                        <button type="button" class="btn btn-info"  ng-click="customAdd()">自定义添加</button>
                                    <?php } ?>
                                    <?php if(\backend\models\AuthRole::canRoleByAuth('potentialMember','DELSOURCE')){ ?>
                                        <button class="btn btn-danger" ng-click="deleteTheSource()">删除选中销售来源</button>
                                    <?php } ?>
                                </div>
                            </div>
                        </form>
                        <form class="form-inline formInlineAdd2">
                            <div class="col-sm-4 pd0" >
                                <p class="fontSizeFontWeight">2.会籍信息</p>
                                <div class="form-group" style="margin-top: 10px;">
                                    <label for="exampleInputName2"
                                           class="formInlineAddLabel"><span class="formInlineAddSpan">*</span>会籍顾问</label>
                                    <select ng-model="counselorId" class="selectSale">
                                        <option value="">&nbsp;&nbsp;&nbsp;请选择顾问</option>
                                        <option value="{{info.id}}" ng-repeat="info in counselorItems">
                                            {{info.name}}
                                        </option>
                                        
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 pd0">
                                    <textarea class="form-control" rows="4" style="resize: none;" placeholder="请填写备注"
                                              ng-model="note"></textarea>
                            </div>
                            <div class="col-sm-12 pd0 text-center">
                                <button class="btn btn-success pull-right" ladda="potentialMemberButtonFlag"  ng-click="potentialMemberAdd()" style="width: 100px;">
                                    完成
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!--    定金-->
    <div class="modal" id="deposit" role="dialog" aria-labelledby="deposit1qq" style="display: none;">
        <div class="modal-dialog" role="document" >
            <div class="modal-content clearfix" style="width: 680px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="text-align: center;"  >定金</h4>
                </div>
                <div class="modal-body" style="height: 200px;padding-top: 60px;">
                    <form>
                        <?=$this->render('@app/views/common/csrf.php')?>
                        <div class="form-group depositDiv col-sm-6">
                            <div class="paddingRigth paddingLeft pull-left">
                                <label for="recipient-name" class="control-label"><span class="formInlineAddSpan">*</span>金额:&emsp;&emsp;&nbsp;</label>
                            </div>
                            <div class="col-sm-3">
                                <input type="number" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" autocomplete="off" ng-model="depositMoney" class="form-control control-label depositInput" id="recipient-name" placeholder="请输入金额">
                            </div>
                        </div>
<!--                            <div class="form-group depositDiv col-sm-6">-->
<!--                                <div class="col-sm-3 paddingRigth">-->
<!--                                    <label for="recipient-name"   class="control-label">抵券:</label>-->
<!--                                </div>-->
<!--                                <div class="col-sm-3">-->
<!--                                    <input type="number" onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" autocomplete="off" ng-model="depositToRoll" class="form-control control-label depositInput" id="recipient-name" placeholder="请输入金额">-->
<!--                                </div>-->
<!--                            </div>-->
                        <div class="form-group depositDiv col-sm-6">
                            <div class="paddingRigth paddingLeft pull-left">
                                <label for="recipient-name" class="control-label"><span class="formInlineAddSpan">*</span>有效期:&emsp;&emsp;&emsp;</label>
                            </div>
                            <div class="col-sm-3" style="margin-left: -22px;">
                                <div  class=" input-daterange input-group depositInput" id="container">
<!--                                        <span class="add-on input-group-addon">选择时间:</span>-->
                                    <input type="text" readonly name="reservation" id="reservation" class=" form-control text-center" value="" placeholder="选择时间"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group depositDiv col-sm-6">
                            <div class="col-sm-3 paddingRigth paddingLeft">
                                <label for="recipient-name" class="control-label"><span class="formInlineAddSpan">*</span>付款方式:</label>
                            </div>
                            <div class="col-sm-3" style="padding-left: 15px;">
                                <select ng-model="depositPayMode" class="depositInput">
                                    <option value="">请选择</option>
                                    <option value="1">现金</option>
                                    <option value="3">微信</option>
                                    <option value="2">支付宝</option>
<!--                                        <option value="4" >pos机</option>-->
                                    <option value="5" >建设分期</option>
                                    <option value="6" >广发分期</option>
                                    <option value="7">招行分期</option>
                                    <option value="8" >借记卡</option>
                                    <option value="9" >贷记卡</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group depositDiv col-sm-6">
                            <div class="col-sm-3 paddingRigth paddingLeft">
                                <label for="recipient-name" class="control-label"><span class="formInlineAddSpan">*</span>定金类型:</label>
                            </div>
                            <div class="col-sm-9" style="padding-left: 15px;">
                                <select ng-model="depositPayType" class="depositInput" ng-change="depositChange(depositPayType)">
                                    <option value="">请选择定金类型</option>
                                    <option value="1">购卡定金</option>
                                    <option value="2">购课定金</option>
<!--                                    <option value="3">续费定金</option>-->
<!--                                    <option value="4">升级定金</option>-->
                                </select>
                            </div>
                        </div>
                        <div class="form-group depositDiv col-sm-6">
                            <div class="col-sm-3 paddingRigth paddingLeft">
                                <label for="recipient-name" class="control-label"><span class="formInlineAddSpan">*</span>选择销售:</label>
                            </div>
                            <div class="col-sm-9">
                                <select class="form-control"
                                        style="padding-top: 4px;width: 200px;"
                                        ng-model="sellName">
                                    <option value="">请选择</option>
                                    <option value="{{sale.id}}" ng-repeat="sale in saleInfo">{{sale.name}}</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
                    <span type="button"  class="btn btn-success" id="success" ng-click="depositOk()">完成</span>
                </div>
            </div>
        </div>
    </div>
    <!--    跟进-->
    <div class="modal" id="follow-up" role="dialog" aria-labelledby="deposit1qq" style="display: none;">
        <div class="modal-dialog" role="document" >
            <div class="modal-content clearfix" style="width: 680px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="text-align: center;">跟进</h4>
                </div>
                <div class="modal-body" style="height: 230px;padding-top: 40px;">
                    <div class="row contentCenter">
                        <ul class="col-sm-10 mTB20"  >
                            <li class="col-sm-12 heightCenter">
                                <div class="col-sm-4 text-right"><span class="red">*</span>最近入场</div>
                                <div class="col-sm-7">
<!--                                    <form name="reg_testdate">-->
<!--                                        <select name="YYYY" onChange="YYYYDD(this.value)">-->
<!--                                            <option value="">请选择 年</option>-->
<!--                                        </select>-->
<!--                                        <select name="MM" onChange="MMDD(this.value)">-->
<!--                                            <option value="">选择 月</option>-->
<!--                                        </select>-->
<!--                                        <select name="DD" onChange="DDD(this.value)">-->
<!--                                            <option value="">选择 日</option>-->
<!--                                        </select>-->
<!--                                    </form>-->
                                    <ul>
                                        <li class=" mL20" style="width: 228px;">
                                            <input type="text" class="form-control" id="registerDate"
                                                   data-date-format="yyyy-mm-dd hh:ii" placeholder="请选择入场日期"
                                                   ng-model="entryTime">
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li class="col-sm-12 mT20">
                                <div class="col-sm-4 text-right">备注</div>
                                <div class="col-sm-8">
                                    <textarea id="entryNote" rows="5" class="wB100 borderRadius3" ng-model="entryNote" placeholder="请填写备注" style="width: 230px;resize: none;text-indent: 1em;" data-style=""></textarea>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-success" ladda="followOkLoad" ng-click="followOk()">完成</button>
                </div>
            </div>
        </div>
    </div>
    <!--  添加自定义来源渠道  -->
    <div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">请输入自定义销售渠道</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">请输入:</label>
                            <input type="text" class="form-control" id="recipient-name" ng-model="customSalesChannels">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" ng-click="confirmAdd(customSalesChannels)">确定添加</button>
                </div>
            </div>
        </div>
    </div>
    <!-- 编辑潜在会员模态框 -->
    <div class="modal fade" id="updateUserModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog w-80" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title updateTitle" id="myModalLabel" >编辑潜在会员</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
<!--                        <form class="form-horizontal pdw80h40">-->
                        <div class="row">
                            <p class="col-sm-12 titleP">1.基本信息</p>
                            <div class="col-sm-12 pd0 mrt20">
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label class="col-sm-5 control-label formInlineAddLabel">会员姓名</label>
                                        <div class="col-sm-7">
                                            <input type="text"
                                                   class="col-sm-8 form-control"
                                                   value="{{updateUserName}}" readonly/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label class="col-sm-5 control-label formInlineAddLabel">手机号</label>
                                        <div class="col-sm-7">
                                            <input type="text"
                                                   class="col-sm-8 form-control"
                                                   value="{{updateUserMobile}}" readonly/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label class="col-sm-5 control-label formInlineAddLabel"><span class="formInlineAddSpan">*</span>性别</label>
                                        <div class="col-sm-7">
                                            <select class="form-control select-control" ng-model="updateSex">
                                                <option value="" ng-if="updateSex == null">请选择性别</option>
                                                <option value="1" >男</option>
                                                <option value="2">女</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 pd0 mrt20">
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label class="col-sm-5 control-label formInlineAddLabel"><span class="formInlineAddSpan">*</span>证件类型</label>
                                        <div class="col-sm-7">
                                            <select name="" class="form-control selectPd "
                                                    ng-model="EditSelectCredentials" ng-change="EditSelectCredentialsChange(EditSelectCredentials)">
                                                <option value="">请选择证件</option>
                                                <option value="1">身份证</option>
                                                <option value="2">居住证</option>
                                                <option value="3">签证</option>
                                                <option value="4">护照</option>
                                                <option value="5">户口本</option>
                                                <option value="6">军人证</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label class="col-sm-5 control-label formInlineAddLabel"><span class="formInlineAddSpan">*</span>证件号</label>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control idCardNewsInput" placeholder="请输入证件号" autocomplete="off" ng-model="updateIdCard"  onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" ng-change="idCardChangeBirth()"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label class="col-sm-5 control-label formInlineAddLabel" ><span class="red">*</span>生日</label>
                                        <div class="col-sm-7 input-append date" id="dateBirth" data-date-format="yyyy-mm-dd">
                                            <input type="text" class="span2 form-control" id="dateTimeBirthday" placeholder="请选择生日" ng-model="updateBirthDay"/>
                                            <span class="add-on"><i class="icon-th"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="col-sm-12 titleP mrt20">2.会籍信息</p>
                            <div class="col-sm-12 pd0 mrt20">
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label class="col-sm-5 control-label formInlineAddLabel">来源渠道</label>
                                        <div class="col-sm-7">
                                            <select class="form-control select-control" id="sellSelectUpdateWays" ng-model="updateWayToShop">
                                                <option value="">请选择</option>
                                                <option value="{{w.id}}" ng-repeat="w in memberSearchData">{{w.value}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 form-group">
                                        <label class="col-sm-5 control-label formInlineAddLabel">会籍顾问</label>
                                        <div class="col-sm-7">
                                            <select class="form-control select-control" id="sellSelectUpdateBi" ng-model="updateSell" style="font-size: 14px;">
                                                <option value="">请选择</option>
                                                <option ng-repeat="xx in counselorItems" value="{{xx.id}}">{{xx.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 pd0 mrt20">
                                <div class="row">
                                    <div class="col-sm-8 form-group">
                                        <label class="col-sm-2 control-label formInlineAddLabel pdr18">备注</label>
                                        <div class="col-sm-8 pdl10">
                                            <textarea class="form-control" rows="6" style="resize: none;" ng-model="updateNote"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer ">
                    <center>
                        <button type="button" class="btn btn-success w100" ng-click="updateUserSuccess()">完成</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!--购卡-->
    <?= $this->render('@app/views/potential-members/buyCard.php'); ?>
    <!-- 小票打印-->
    <?=$this->render('@app/views/common/coursePrint.php')?>
    <!-- 场地打印-->
    <?= $this->render('@app/views/potential-members/field.php') ?>

</div>
<!--定金信息记录修改定金模态框-->
<?= $this->render('@app/views/potential-members/updateDepositModal.php'); ?>