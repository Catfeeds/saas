<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/8 0008
 * Time: 10:46
 */
-->
<div class="modal fade" id="peopleNumModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 85%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel" style="text-align: center;font-size: 18px;margin-bottom: 20px;">到店详情</h4>
                <p class="lineB"></p>
                <div class="col-sm-12 pdtb15">
                    <div class="input-daterange input-group col-sm-3 float" id="container" >
                        <span class="add-on input-group-addon smallFont">选择日期</span>
                        <input type="text" readonly name="dateClick" id="addUserReservation" class="form-control text-center userSelectTime">

                    </div>
                    <div class="col-sm-1">
                        <div class="from-group">
                            <select class="form-control fontStyleSelect" ng-model="sexSelect">
                                <option value="">性别</option>
                                <option value="1">男</option>
                                <option value="2">女</option>
                                <option value="3">其他</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="from-group" style="margin-left: -20px;">
                            <select class="form-control fontStyleSelect adviserSelect" ng-model="adviserSelect">
                                <option value="" >顾问</option>
                                <option ng-repeat="n in adviserSelectList" value="{{n.id}}" title="{{n.name}}">{{n.name|cut:true:3:'...'}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="from-group" style="margin-left: -40px;">
                            <select class="form-control fontStyleSelect coachSelect" ng-model="coachSelect">
                                <option value="">教练</option>
                                <option ng-repeat="n in coachSelectList" value="{{n.id}}" title="{{n.name}}">{{n.name|cut:true:3:'...'}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="from-group" style="margin-left: -60px;">
                            <select class="form-control fontStyleSelect cardSelect" ng-model="cardSelect">
                                <option value="">卡种类型</option>
                                <option value="1">瑜伽</option>
                                <option value="2">健身</option>
                                <option value="3">舞蹈</option>
                                <option value="4">综合</option>
                                <!--                                    <option ng-repeat="n in cardSelectList" value="{{n.id}}" title="{{n.type_name}}">{{n.type_name|cut:true:3:'...'}}</option>-->
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="from-group" style="margin-left: -80px;">
                            <select class="form-control fontStyleSelect" ng-model="viceMember">
                                <option value="">全部会员</option>
                                <option value="1">被带会员</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3 pdr0">
                        <div class="from-group" style="margin-left: -200px;width: 85%">
                            <input type="text" class="form-control smallFont" placeholder="输入姓名、卡号、手机号、顾问、教练、卡种名称" ng-model="keywordPeopleDel" ng-keyup="enterSearchPeopleNumber($event)">
                        </div>
                    </div>
                    <div class="col-sm-1 pdl0" style="margin-left: -256px;">
                        <button type="button" class="btn btn-success  btnSm" ng-click="searchBtn()">搜索</button>
                    </div>
                    <div class="col-sm-1 text-center numBox" style="margin-left: -120px;">
                        <button type="button" class="btn-block btn btn-sm btn-info" ng-click="searchClearBtn()">清空</button>
                    </div>
                </div>
                <p class="lineB"></p>
                <div class="ibox float-e-margins">
                    <div class="ibox-content" style="height: 580px;overflow-y: auto;">
                        <div style="padding-bottom: 0;" id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th class="boxWhite" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 80px;">序号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 180px;" ng-click="changeSort('entryTime',sort)">进场时间
                                    </th>
                                    <th class="boxWhite" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">姓名
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeSort('sex',sort)">性别
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeSort('cardNumber',sort)">会员卡号
                                    </th>
                                    <th class="boxWhite" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">手机号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeSort('cardType',sort)">刷卡种类
                                    </th>
                                    <th class="boxWhite" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">会籍顾问
                                    </th>
                                    <th class="boxWhite" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">教练
                                    </th>
                                    <th class="boxWhite" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;">操作
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr style="hoverTr" ng-repeat="(key,item) in memberDetailList">
                                    <td>{{8*(nowPage-1)+key+1}}</td>
                                    <td>{{(item.entry_time*1000) | date:"yyyy-MM-dd HH:mm:ss"}}</td>
                                    <td style="text-align: left">
                                            <span style="margin-right: 6px;">
                                                <img class="peopleImg" ng-if="item.pic == null || item.pic == undefined"  ng-src="../plugins/operation/img/111.png">
                                                <img class="peopleImg img-rounded" ng-if="item.pic != null && item.pic != undefined"  ng-src="{{item.pic}}">
                                            </span>
                                        <span  ng-if="item.memberName != null">{{item.memberName}}</span>
                                        <span  ng-if="item.memberName == null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="item.memberSex == 2">女</span>
                                        <span ng-if="item.memberSex == 1">男</span>
                                        <span ng-if="item.memberSex == null || item.memberSex == 0">不详</span>
                                    </td>
                                    <td>
                                        <span ng-if="item.card_number != null">{{item.card_number}}</span>
                                        <span ng-if="item.card_number == null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="item.mobile != 0">{{item.mobile}}</span>
                                        <span ng-if="item.mobile == 0">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="item.card_name != null">{{item.card_name}}</span>
                                        <span ng-if="item.card_name == null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="item.counselorName != null">{{item.counselorName}}</span>
                                        <span ng-if="item.counselorName == null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="item.privateName != null">{{item.privateName}}</span>
                                        <span ng-if="item.privateName == null">暂无数据</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-default" ng-click="getMemberDataCardBtn(item.member_id)">查看详情</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <?= $this->render('@app/views/common/pagination.php'); ?>
                            <?=$this->render('@app/views/common/nodata.php',['name'=>'groupNoDataShow','text'=>'暂无信息','href'=>true]);?>
                        </div>
                    </div>
                    <div class="loader loaderDiv loader-animate4">
                        <div class="loader-inner square-spin loderModel">
                            <div class="center-block"></div>
                            <p class="text-center loadP">加载中</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>