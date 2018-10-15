
<!--
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/11/30
 * Time: 15:51
 *content详情及页面操作
 -->
<!--详情页面-->
<div class="modal fade" id="myModals2"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true" style="overflow-y: scroll;">
    <div class="modal-dialog w900">
        <div class="modal-content clearfix">
            <div class="modal-header clearfix">
                <button type="button" class="close" ng-click="closeDetails()" data-dismiss="modal" aria-hidden="true">&times;</button>

                <h3 class="text-center" id="myModalLabel">员工详情 </h3>
                <div ng-if="organizationType != '私教部' && organizationType != '销售部'" style="margin-top: 20px;font-size: 18px;cursor: pointer">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 userBasic text-center active" ng-click="userBasic()">基本信息</div>
                        <div class="col-md-6 col-sm-6 messageRecord text-center" ng-click="messageRecord()">信息记录</div>
                    </div>
                </div>

                <div ng-if="organizationType == '销售部'" style="margin-top: 20px;font-size: 18px;cursor: pointer">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 userBasic text-center active" ng-click="userBasic()">基本信息</div>
                        <div class="col-md-4 col-sm-4 userMessage text-center" ng-click="userMessage()">会员信息</div>
                        <div class="col-md-4 col-sm-4 messageRecord text-center" ng-click="messageRecord()">信息记录</div>
                    </div>
                </div>
                <div ng-if="organizationType == '私教部'" style="margin-top: 20px;font-size: 18px;cursor: pointer">
                    <div class="row">
                        <div class="col-md-3 col-sm-3 userBasic text-center active" ng-click="userBasic()">基本信息</div>
                        <div class="col-md-3 col-sm-3  presentaShow text-center" ng-click="presentaShow()">个人展示</div>
                        <div class="col-md-3 col-sm-3 userMessage text-center" ng-click="userMessage()">会员信息</div>
                        <div class="col-md-3 col-sm-3 messageRecord text-center" ng-click="messageRecord()">信息记录</div>
                    </div>
                </div>
            </div>
            <div class="modal-body mb300">
                <!--基本信息选项卡-->
                <div class="col-sm-12 col-xs-12 userBasic1 mb50">
                    <div class="col-sm-5 text-right"
                         ng-if="employeeDetailsListData.pic != null && employeeDetailsListData.pic != ''">
                        <img ng-src="{{employeeDetailsListData.pic}}" class="imgStyle">
                    </div>
                    <div class="col-sm-5 text-right"
                         ng-if="employeeDetailsListData.pic == null || employeeDetailsListData.pic == ''">
                        <img ng-src="/plugins/checkCard/img/11.png" class="imgStyle1">
                    </div>
                    <div class="col-sm-7 text-left">
                        <h4 class="mb10">姓&emsp;名:{{employeeDetailsListData.name}}</h4>
                        <div class="mb10">性&emsp;别:{{employeeDetailsListData.sex == 1 ? "男": employeeDetailsListData.sex
                            == 2 ? "女":"暂无"}}
                        </div>
                        <div class="mb10">公&emsp;司:{{employeeDetailsListData.company | noData:''}}</div>
                        <div class="mb10">场&emsp;馆:{{employeeDetailsListData.venue | noData:''}}</div>
                        <!--                            <div class="mb10">职位:{{employeeDetailsListData.position | noData:''}}</div>-->

                        <div class="mb10">职&emsp;位:
                            <span>{{employeeDetailsListData.position}}</span>
                            <span ng-if="employeeDetailsListData.position == ''">暂无数据</span>
                            <span >{{data.position}}</span>
                        </div>

                        <div class="mb10">手机号:{{employeeDetailsListData.mobile | noData:''}}</div>
                        <div class="mb10">课&emsp;时:{{employeeDetailsListData.class_hour | noData:''}}</div>
                        <div class="mb10">课&emsp;量:{{employeeDetailsListData.params | stringToJson:'classAmount' |noData:''}}</div>
                        <div class="mb10" ng-if="employeeDetailsListData.status == 1">状&emsp;态:在职</div>
                        <div class="mb10" ng-if="employeeDetailsListData.status == 2">状&emsp;态:离职</div>
                        <div class="mb10" ng-if="employeeDetailsListData.status == 3">状&emsp;态:调岗</div>
                        <div class="mb10" ng-if="employeeDetailsListData.status == 4">状&emsp;态:全职</div>
                        <div class="mb10" ng-if="employeeDetailsListData.status == 5">状&emsp;态:兼职</div>
                    </div>
                </div>
                <div class=" col-sm-12 col-xs-12 presentaShow1 mb50">
                    <h1 style="text-align: center;margin-bottom: 15px">私教个人展示详情</h1>
                    <div style="min-height: 200px;min-width: 200px">
                        <div ng-if="!allUrl.length" style="text-align: center;">
                            <div class="item" style="margin-top: 20px;">
                                <img
                                    src="/plugins/noData/img/noDate.png"
                                    alt="">
                            </div>
                            <div class="item" style="margin-top: 30px">
                                <span style="font-size: 25px">暂无图片</span>
                            </div>
                        </div>
                        <div ng-if="allUrl.length" id="carousel-example-generic" class="carousel  slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="{{index}}" ng-class="{'active': index==0}" ng-repeat="(index, item) in allUrl"></li>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <div class="item" ng-class="{'active': index==0}" style="margin-top: 0" ng-repeat="(index, item) in allUrl">
                                    <img style="width: 808px;height: 454px" ng-src="{{item.url}}">
                                </div>
                            </div>
                            <!-- Controls -->
                            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!--会员信息选项卡-->
                <div class="col-sm-12 col-xs-12 userMessage1 pd0" style="display: none">
                    <div class="col-sm-12 col-xs-12 pd0">
                        <div class="col-sm-4 pd0 ">
                            <select ng-model="privateLessonPurchase" class=" form-control w150spx imgBoolFalse padding3px10px">
                                <option value="">收费私课购买</option>
                                <option value="1">已购买</option>
                                <option value="0">未购买</option>
                            </select>
                            <select class=" form-control w150spx imgBoolFalse padding3px12px" ng-model="allMember">
                                <option value="">所有会员</option>
                                <option value="1">正式会员</option>
                                <option value="2">潜在会员</option>
                            </select>
                        </div>
                        <div class="col-sm-4 pd0">
                            <div class="input-group">
                                <input type="text" style="height: 30px;" class="form-control search " id="keywordMember" ng-model="keywordMember" ng-keyup="enterSearchMember($event)" placeholder="输入姓名、手机号、卡号搜索...">
                                <span class="input-group-btn">
                                    <button style="height: 30px;padding: 2px 12px;" type="button" class="btn btn-primary" ng-click="searchEmployeeMember()">搜索</button>
                                </span>
                               </div>
                           </div>
                           <div class="col-sm-1">
                               <button type="button" class="btn btn-default" style="height: 30px;padding: 2px 12px;" ng-click="clearDataBtn()">清空</button>
                           </div>

                           <div class="col-sm-3 pd0 textAlignCenter">
                               <?php if (\backend\models\AuthRole::canRoleByAuth('employee', 'PILIANG')) { ?>
                                   <button type="button" style="height: 30px;padding: 2px 12px;" class="btn btn-info" ng-disabled="personnelNoDataShow"  data-toggle="modal" data-target="#myModals3" ng-click="massTransfer1()" style="width: 161px;margin-left: 75px;border: 0px">
                                       批量转移会员
                                   </button>
                               <?php } ?>
                           </div>
                       </div>
                       <div class="col-sm-12 pd0 overflowAutoh350" style="margin-top: 10px;">
                           <div class="ibox float-e-margins">
                               <div class="ibox-content pd0">
                                   <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper pd0 form-inline"
                                        role="grid">
                                       <div class="row" style="display: none;">
                                           <div class="col-sm-6">
                                               <div id="DataTables_Table_0_filter" class="dataTables_filter"></div>
                                           </div>
                                       </div>
                                       <table
                                               class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                               id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                           <thead>
                                           <tr role="row">
                                               <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0"
                                                   rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序">
                                                   <span aria-hidden="true"></span>&nbsp;姓名
                                               </th>
                                               <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0"
                                                   rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序">
                                                   <span aria-hidden="true"></span>&nbsp;性别
                                               </th>
                                               <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0"
                                                   rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序">
                                                   <span aria-hidden="true"></span>&nbsp;手机号
                                               </th>
                                               <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0"
                                                   rowspan="1" colspan="1" aria-label="平台：激活排序列升序">
                                                   <span aria-hidden="true"></span>&nbsp;会员类型
                                               </th>
                                               <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0"
                                                   rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">
                                                   <span aria-hidden="true"></span>&nbsp;注册时间
                                               </th>
                                           </tr>
                                           </thead>
                                           <tbody>
                                           <tr class="gradeA odd" ng-if="organizationType == '销售部'"
                                               ng-repeat="w in employeeMemberInformationList">
                                               <td>{{w.memberDetails.name}}</td>
                                               <td>{{w.memberDetails.sex == 1 ? "男":"女"}}</td>
                                               <td>{{w.mobile}}</td>
                                               <td>{{w.member_type == 1 ? "普通会员":"潜在会员"}}</td>
                                               <td>{{w.register_time * 1000 | date:"yyyy-MM-dd"}}</td>
                                           </tr>
                                           <tr class="gradeA odd" ng-repeat="w in employeeMemberInformationList"
                                               ng-if="organizationType == '私教部'">
                                               <td>{{w.member.memberDetails.name}}</td>
                                               <td>{{w.member.memberDetails.sex == 1 ? "男":"女"}}</td>
                                               <td>{{w.member.mobile}}</td>
                                               <td>{{w.member.member_type == 1 ? "普通会员":"潜在会员"}}</td>
                                               <td>{{w.member.register_time * 1000 | date:"yyyy-MM-dd"}}</td>
                                           </tr>
                                           </tbody>
                                       </table>
                                       <?= $this->render('@app/views/common/nodata.php', ['name' => 'personnelNoDataShow', 'text' => '暂无数据', 'href' => true]); ?>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                <!--信息记录选项卡-->
                <div class="col-sm-12 col-xs-12 recordCard">
                    <div class="panel panel-default overflowAutoh350" style="overflow-x: hidden;height: 360px;">
                        <!-- Default panel contents -->
                        <div class="panel-heading row">
                            <div class="col-md-6">
                                <select class="form-control w160" ng-model="selectEntryRecord"
                                        ng-change="SelectTypeMessage(selectEntryRecord)" style="padding-top: 4px;">
                                    <option value="">转移记录</option>
                                    <option value="1">约课记录</option>
                                </select>
                            </div>
                        </div>
                        <!-- Table -->
                        <div ng-if="selectEntryRecord == ''">
                            <table class="table"  >
                                <thead ">
                                <tr style="height: 40px">
                                    <th>转移方</th>
                                    <th>被转移方</th>
                                    <th>转移会员数</th>
                                    <th>转移时间</th>
                                    <th>操作人</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="i in recordListData">
                                    <td>{{i.fromName | noData:''}}</td>
                                    <td>{{i.toName | noData:''}}</td>
                                    <td>{{i.member_count | noData:''}}</td>
                                    <td>{{i.created_at * 1000 | date:'yyyy-MM-dd'}}</td>
                                    <td>{{i.createName |noData:''}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'recordCardNoData', 'text' => '暂无数据', 'href' => true]); ?>
                            <?=$this->render('@app/views/common/pagination.php',['page'=>'recordCardPage']);?>

                        </div>

                        <div ng-if="selectEntryRecord == 1">
                            <table class="table">
                                <thead>
                                <tr style="height: 40px">
                                    <th>场馆 </th>
                                    <th>课程</th>
                                    <th>座位</th>
                                    <th>开课时间</th>
                                    <th>预约时间</th>
                                    <th>打票</th>
                                    <th>状态</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="i in employeeAboutClassListData">
                                    <td>{{i.groupClass.organization.name | noData:''}}</td>
                                    <td>{{i.groupClass.course.name | noData:''}}</td>
                                    <td>{{i.seat.rows}}排{{i.seat.seat_number}}号</td>
                                    <td>{{i.groupClass.start * 1000 |  date:'yyyy-MM-dd HH:mm' }}</td>
                                    <td>{{i.create_at * 1000 | date:'yyyy-MM-dd  HH:mm'}}</td>
                                    <td><spn ng-if="i.is_print_receipt == 2">否</spn><spn ng-if="i.is_print_receipt == 1">是</spn></td>
                                    <td><spn ng-if="i.status == 2">取消</spn>
                                        <spn ng-if="i.status == 1">正常</spn>
                                        <spn ng-if="i.status != 1 && i.status != 2">其他</spn>
                                    </td>
                                    <td>

                                        <button ng-disabled ="i.is_print_receipt == 1 || i.status == 2" ng-click="employeeAboutPrints(i.item)" class="btn btn-success btn-sm class1">
                                            打票
                                        </button>

                                        <button ng-disabled ="i.status == 2 || i.groupClass.start <= newTime "  ng-click="emplyeeCancelAppointment(i.id, i.groupClass.start)" class="btn  btn-info btn-sm class1">
                                            取消
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button style="width: 100px;" type="button" class="btn btn-success " ng-click="personal()">关闭</button>
            </div>
        </div>
    </div>
</div>
<!--    批量转移-->
<div class="modal fade" id="myModals3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true" style="overflow-y: scroll;">
    <div class="modal-dialog w900">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center colorRgb" id="myModalLabel">
                    会员
                </h3>
            </div>
            <div class="modal-body mb400">
                <div class="col-sm-12 userMessage1 userMessagea">
                    <div class="col-sm-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content pd0">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper pd0 form-inline"
                                     role="grid">
                                    <div class="row" style="display: none;">
                                        <div class="col-sm-6">
                                            <div id="DataTables_Table_0_filter" class="dataTables_filter"></div>
                                        </div>
                                    </div>
                                    <table class="table table-striped " id="DataTables_Table_0"
                                           aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="w242 "  ng-click="CheckAll(employeeMemberInformationList.id)"
                                                tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                aria-label="浏览器：激活排序列升序" style="cursor: pointer">
                                                <span aria-hidden="true" ></span>&nbsp;全选
                                                <div class="mt_9">{{checkboxLength}}人</div>
                                            </th>
                                            <th class="w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序">
                                                <span aria-hidden="true"></span>&nbsp;姓名
                                            </th>
                                            <th class="w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序">
                                                <span aria-hidden="true"></span>&nbsp;性别
                                            </th>
                                            <th class="w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="浏览器：激活排序列升序">
                                                <span aria-hidden="true"></span>&nbsp;手机号
                                            </th>
                                            <th class="w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="平台：激活排序列升序">
                                                <span aria-hidden="true"></span>&nbsp;会员状态
                                            </th>
                                            <th class="w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                                colspan="1" aria-label="引擎版本：激活排序列升序">
                                                <span aria-hidden="true"></span>&nbsp;注册时间
                                            </th>
                                            <th class="w242" ng-click="UnCheck()" tabindex="0"
                                                aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                aria-label="引擎版本：激活排序列升序">
                                                <span aria-hidden="true"></span>&nbsp;
                                                <span class="btn btn-white">取消</span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr class="gradeA odd" ng-if="organizationType == '销售部'"
                                            ng-repeat="w in employeeMemberInformationList">
                                            <td class="checkList" data-value="{{w.memberDetails.member_id}}">
                                                <input type="checkbox" value="{{w.memberDetails.member_id}}"
                                                       class="checkboxs check{{w.memberDetails.member_id}}"
                                                       ng-click="otherCheck(w.memberDetails.member_id)">
                                            </td>
                                            <td>{{w.memberDetails.name}}</td>
                                            <td>{{w.memberDetails.sex == 1 ? "男":"女"}}</td>
                                            <td>{{w.mobile}}</td>
                                            <td>{{w.member_type == 1 ? "普通会员":"潜在会员"}}</td>
                                            <td>{{w.register_time * 1000 | date:"yyyy-MM-dd"}}</td>
                                            <td></td>
                                        </tr>
                                        <tr class="gradeA odd" ng-repeat="w in employeeMemberInformationList"
                                            ng-if="organizationType == '私教部'">
                                            <td class="checkList" data-value="{{w.member.memberDetails.member_id}}">
                                                <input type="checkbox" value="{{w.member.memberDetails.member_id}}"
                                                       class="checkboxs check{{w.member.memberDetails.member_id}}"
                                                       ng-click="otherCheck(w.member.memberDetails.member_id)">
                                            </td>
                                            <td>{{w.member.memberDetails.name}}</td>
                                            <td>{{w.member.memberDetails.sex == 1 ? "男":"女"}}</td>
                                            <td>{{w.member.mobile}}</td>
                                            <td>{{w.member.member_type == 1 ? "普通会员":"潜在会员"}}</td>
                                            <td>{{w.member.register_time * 1000 | date:"yyyy-MM-dd"}}</td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?= $this->render('@app/views/common/nodata.php', ['name' => 'personnelNoDataShows', 'text' => '暂无数据', 'href' => true]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <center>
                    <button ng-if="employeeMemberInformationName == '私教部'" ng-click="privateEducation()" type="button"
                            class="btn btn-success  ">选择私教并转移
                    </button>
                    <button ng-if="employeeMemberInformationName == '销售部'" ng-click="privateEducation()" type="button"
                            class="btn btn-success ">选择销售并转移
                    </button>
                </center>
            </div>
        </div>
    </div>
</div>
<!--    选择私教并转移-->
<div class="modal" id="myModals4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     style="display: none;overflow: auto;">
    <div class="modal-dialog " role="document" style="">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <!--                    <button type="button" ng-click="closeBtnModalPrivate()" class="close closeBtnModal4" data-dismiss="modal" aria-label="Close">-->
                <!--                        <span aria-hidden="true">&times;</span>-->
                <!--                    </button>-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title tcfs20" id="myModalLabel" ng-if="employeeMemberInformationName == '私教部'">
                    选择教练</h4>
                <h4 class="modal-title tcfs20" id="myModalLabel" ng-if="employeeMemberInformationName == '销售部'">
                    选择销售</h4>
            </div>
            <div class="modal-body overflowAutoh500">
                <table style="width: 100%">
                    <tr class="aa" ng-if="employeeMemberInformationName == '私教部'"
                        ng-repeat="w in employeeMemberPrivateDducation">
                        <td ng-click="privateEducationOk(w.id,w.name)">
                            <div class="col-sm-12 pd0 mb_10">
                                <div class="col-sm-3 pd0 tcmb22">
                                    <img class="w100h100br" ng-if="w.pic != '' && w.pic != null " ng-src="{{w.pic}}">
                                    <img class="w100h100br" ng-if="w.pic == null || w.pic == '' "
                                         src="/plugins/user/images/noPic.png">
                                </div>
                                <div class="col-sm-7">
                                    <p class="mb_10 fs16">{{w.name}}</p>
                                    <p class="mb_10"><span ng-if="w.age != null">{{w.age}}岁</span> &nbsp;&nbsp;从业时间{{w.work_time}}年
                                    </p>
                                    <p><i class="glyphicon glyphicon-star"></i>
                                        <i class="glyphicon glyphicon-star"></i>
                                        <i class="glyphicon glyphicon-star"></i>
                                        <i class="glyphicon glyphicon-star"></i>
                                        <i class="glyphicon glyphicon-star"></i>
                                    </p>
                                </div>
                                <div class="col-sm-2 ">
                                    <span data-toggle="modal" data-target="#myModals5" class="btn btn-success"
                                          ng-click="privateEducationOk(w.id)"
                                          style="width: 80px;height: 30px;margin-top: 25px">选择</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="aa" ng-if="employeeMemberInformationName == '销售部'"
                        ng-repeat="w in employeeMemberPrivateDducation">
                        <td ng-click="privateEducationOk(w.id,w.name)">
                            <div class="col-sm-12 pd0 mb_10">
                                <div class="col-sm-3 pd0 textAlignCenter mb22">
                                    <img ng-if="w.pic != '' && w.pic != null " ng-src="{{w.pic}}" class="w100h100br">
                                    <img ng-if="w.pic == null || w.pic == ''" src="/plugins/user/images/noPic.png"class="w100h100br">
                                </div>
                                <div class="col-sm-7">
                                    <p class="mb_10 fs16">{{w.name}}</p>
                                    <p class="mb_10" ng-if="w.age != null">{{w.age}}岁</p>
                                </div>
                                <div class="col-sm-2 ">
                                        <span data-toggle="modal" data-target="#myModals5" class="btn btn-success"
                                              ng-click="privateEducationOk(w.id)" style="width: 80px;height: 30px;margin-top: 25px">选择
                                        </span>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<!--选择成功页面提示-->
<div class="modal fade" id="myModals5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
            </div>
            <div class="modal-body mb200">
                <div class="col-sm-12 text-center">
                    <img src="/plugins/checkCard/img/11.png" alt="" class="wh100">
                </div>
                <div class="col-sm-12 text-center shaixuan">
                    <h4>确认把{{organizationName}}教练的{{checkboxLength}}名会员</h4>
                </div>
                <div class="col-sm-12 text-center shaixuan">
                    <h4>转入到{{privateEducationOkName}}教练名下</h4>
                </div>
            </div>
            <div class="modal-footer">
                <center>
                    <button style="width: 100px;" type="button" class="btn btn-success " ng-click="confirmationTransfer()">
                        确认
                    </button>
                </center>
            </div>
        </div>
    </div>
</div>
<!--    分配账号-->
<div class="modal fade" id="myAllotModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center colorRgb" id="myModalLabel">
                    员工账号分配
                </h3>
            </div>
            <div class="modal-body">
              <!--  <div class="form-group rgbMl125">部门</div>
                <div class="form-group text-center">
                    <center>
                        <select class="form-control actions rgb153" name="venueId">
                            <option value="allotVenueId">{{allotBranch}}</option>
                            <option ng-repeat="item in allSection" value="{{item.id}}">{{item.name}}</option>
                        </select>
                    </center>
                </div>-->
                <div class="form-group rgbMl125">手机号</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" id="allotPhone" ng-model="mobiles"
                               ng-disabled=" mobile != null ? 'disabled':''">
                    </center>
                </div>
                <div class="form-group rgbMl125">账号</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" ng-disabled='isAllot != null' class="form-control actions"
                               ng-model="allotNumber">
                    </center>
                </div>
                <div class="form-group rgbMl125">密码</div>
                <div class="form-group text-center">
                    <center>
                        <input id="setPassword"  type="password" autocomplete="off" ng-change="passwordChange(allotPassword)" ng-focus="passwordFocus(allotPassword)" ng-disabled='isAllot != null' class="form-control actions"
                               ng-model="allotPassword">
                    </center>
                </div>
            </div>
            <div class="modal-footer">
                <center>
                    <button type="button" class="btn btn-success " style="width: 100px;"
                            ng-disabled="
                                              myForm.name.$dirty && myForm.name.$invalid ||
                                              myForm.position.$dirty && myForm.position.$invalid ||
                                              myForm.name.$invalid"
                            ng-click="allotComplete()">完成
                    </button>
                </center>
            </div>
        </div>
    </div>
</div>
<!--    审核-->
<div class="modal fade" id="auditModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-center">审核注册员工</h4>
            </div>
            <div class="modal-body">
                <div class="form-group rgbMl125">权限</div>
                <div class="form-group text-center">
                    <center>
                        <select class="form-control actions rgb153" id="selectAudit" name="jurisdiction">
                            <option value="">请选择权限</option>
                            <option ng-repeat="(index,list) in  jurisdictionLists" value="{{index}}">{{list}}</option>
                        </select>
                    </center>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" ng-click="submitUpdateEmployee()">确定</button>
            </div>
        </div>
    </div>
</div>
<!--自定义员工职位-->
<div class="modal fade" id="sellSource1"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">自定义员工职位</h4>
            </div>
            <div class="modal-body" style="display: flex;justify-content: center;margin-top: 20px;">
                <input type="text" class="form-control" id="recipient-name" placeholder="请输入自定义员工职位" ng-model="customSalesChannels" ng-keydown="enterSearch($event)" style="width: 60%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-success" ng-click="customAddOk(customSalesChannels)">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
