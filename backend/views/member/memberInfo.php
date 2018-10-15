<!--会员信息模态框-->
<div style="overflow: auto" class="modal fade" id="myModals2" tabindex="0" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog a24" style="min-width: 840px;;">
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
                                    <a data-toggle="tab" href="tabs_panels.html#tab-6"
                                       ng-click="getYardRecord(data.id)">
                                        <span>场地记录</span>
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
                                        <span>私教课信息</span>
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
                            <!--会员信息-->
                            <div id="tab-1" class="col-sm-12 tab-pane active a3">
                                <div class="col-sm-12 col-xs-12" style="display: flex;align-items: center;">
                                    <div class="col-sm-6 col-xs-12" style="text-align: center;height: 190px;">
                                        <h4 style="width:150px;font-size: 18px;" class="col-sm-offset-6">{{MemberData.name |noData:''}}</h4>
                                        <!--<h4 style="margin-top: 10px;"
                                            class="img-circle col-sm-6 col-sm-offset-6 text-center">
                                            <img ng-src="{{MemberData.pic}}"
                                                 ng-if="MemberData.pic!=null && MemberData.pic != ''"
                                                 style="width: 150px;height: 150px;border-radius: 50%">
                                        </h4>
                                        <h4 class="img-circle col-sm-6 col-sm-offset-6 text-center a20">
                                           <img ng-src="{{MemberData.pic}}"
                                                 ng-if="MemberData.pic!=null && MemberData.pic != ''"
                                                 style="width: 150px;height: 150px;border-radius: 50%">
                                        </h4>-->
                                        <div class="col-sm-offset-6" style="width: 150px;height: 150px;position: relative;right: 0;top:20px;" ng-if="MemberData.pic == null || MemberData.pic == ''" ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'" ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'">
                                            <img ng-src="{{MemberData.pic}}" class="imgClass" ng-if="MemberData.pic != null && MemberData.pic != ''" style="position:absolute;top:0;right:0;width: 150px;height: 150px;border-radius: 50%;cursor:pointer;">
                                            <img ng-src="/plugins/checkCard/img/11.png" ng-if="MemberData.pic == null || MemberData.pic == ''" style="position:absolute;top:0;right:0;width: 150px;height: 150px;border-radius: 50%;cursor:pointer;">
                                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'UPLOAD')) { ?>
                                                <input type="file" class="form-control upLoadInput" ngf-drop="setCover5($file,'update')" ngf-select="setCover5($file)" uploader="uploader"
                                                       style="width: 100%;height: 100%;position: absolute;top:0;right:0;opacity: 0;cursor:pointer;">
                                            <?php } ?>
                                        </div>

                                        <div class="col-sm-offset-6" style="width: 150px;height: 150px;position: relative;right: 0;top:20px;" ng-if="MemberData.pic != null && MemberData.pic != ''" ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'" ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'">
                                            <img ng-src="{{MemberData.pic}}" class="imgClass" ng-if="MemberData.pic != null && MemberData.pic != ''" style="position:absolute;top:0;right:0;width: 150px;height: 150px;border-radius: 50%;cursor:pointer;">
                                            <img ng-src="/plugins/checkCard/img/11.png" ng-if="MemberData.pic == null || MemberData.pic == ''" style="position:absolute;top:0;right:0;width: 150px;height: 150px;border-radius: 50%;cursor:pointer;">
                                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'UPDATEUPLOAD')) { ?>
                                                <input type="file" class="form-control upLoadInput" ngf-drop="setCover5($file,'update')" ngf-select="setCover5($file)" uploader="uploader"
                                                       style="width: 100%;height: 100%;position: absolute;top:0;right:0;opacity: 0;cursor:pointer;">
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <h4 style="font-size: 18px;">个人信息</h4>
                                        <p class="a20">会员编号：{{MemberData.id}}</p>
                                        <p class="a20">会员性别：
                                            <span ng-if="MemberData.sex== 1">男</span>
                                            <span ng-if="MemberData.sex== 2">女</span>
                                            <span ng-if="MemberData.sex != 1 && MemberData.sex != 2">暂无数据</span>
                                        </p>
                                        <p class="a20">手机号码：
                                            <span
                                                ng-if="MemberData.mobile == null || MemberData.mobile == undefined || MemberData.mobile == ''">暂无数据</span>
                                            <span>{{MemberData.mobile| noData:''}}</span>
                                        </p>
                                        <p class="a20">出生日期：{{MemberData.birth_date| noData:''}}</p>
                                        <!--                                        <p class="a20">工作：{{MemberData.profession| noData:''}}</p>-->
                                        <p class="a20">会籍顾问：<span>{{MemberData.employee.name| noData:''}}</span>
                                        </p>
                                        <p class="a20">私教名称：<span>{{MemberData.personalName| noData:''}}</span>
                                        </p>
                                        <p class="a20">证件类型：
                                            <span ng-if="MemberData.document_type ==null">暂无数据</span>
                                            <span ng-if="MemberData.document_type =='1'">身份证</span>
                                            <span ng-if="MemberData.document_type =='2'">居住证</span>
                                            <span ng-if="MemberData.document_type =='3'">签证</span>
                                            <span ng-if="MemberData.document_type =='4'">护照</span>
                                            <span ng-if="MemberData.document_type =='5'">户口本</span>
                                            <span ng-if="MemberData.document_type =='6'">军人证</span>
                                        </p>
                                        <p class="a20">证件号码：{{MemberData.id_card| noData:''}}</p>
                                        <p class="a20">IC卡号码：
                                            <span ng-if="MemberData.status == '1'">{{MemberData.custom_ic_number| noData:''}}</span>
                                            <span ng-if="MemberData.status == '2'">暂无数据</span>
                                        </p>
                                        <p class="a20">家庭住址：{{MemberData.family_address| noData:''}}</p>
                                        <p class="a20">会员备注：{{MemberData.memberDetails.note| noData:''}}</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12 a3 text-center mT20">
                                    <!--                                    <button class="btn btn-info" data-toggle="modal" data-target="#myModals5" ng-click="getMemberUpdate(data.id)">&nbsp;&nbsp;&nbsp;&nbsp;修改&nbsp;&nbsp;&nbsp;&nbsp;</button>-->
                                    <button style="width: 100px;" class="btn btn-success" data-dismiss="modal"
                                            aria-hidden="true">关闭
                                    </button>
                                </div>
                            </div>
                            <!--会员卡信息-->
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
                            <!--团课-->
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
                                                        style="width: 100px;">场馆
                                                    </th>
                                                    <th class="sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                        style="width: 100px;">卡名称
                                                    </th>
                                                    <th class="sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                        style="width: 100px;">课程
                                                    </th>
                                                    <th class="sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                        style="width: 80px;">场地
                                                    </th>
                                                    <th class="sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                        style="width: 100px;">日期时间
                                                    </th>
                                                    <th class="sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                        style="width: 100px;">小票状态
                                                    </th>
                                                    <th class="sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                        style="width: 100px;">刷手环时间
                                                    </th>
                                                    <th class="sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                        style="width: 100px;">上课情况
                                                    </th>
                                                    <th class="sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                        style="width: 100px;">约课途径
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
                                                    <td>{{group.groupClass.organization.name | noData:''}}</td>
                                                    <td>{{group.memberCard.card_name}}</td>
                                                    <td>{{group.groupClass.course.name | noData:''}}</td>
                                                    <td>{{group.groupClass.classroom.name | noData:''}}</td>
                                                    <td>{{group.class_date |
                                                        noData:''}}&nbsp{{group.start*1000 | date:'HH:mm' }}
                                                    </td>
                                                    <td ng-if="group.is_print_receipt == 1">已打印</td>
                                                    <td ng-if="group.is_print_receipt == 2">未打印</td>
                                                    <td>{{  group.in_time*1000 | noData: '' | date:'yyyy/MM/dd HH:mm'  }}</td>
                                                    <td><span ng-if=group.status==1>已预约</span>
                                                        <span ng-if=group.status==2>已取消</span>
                                                        <span ng-if=group.status==3>上课中</span>
                                                        <span ng-if=group.status==4>已下课</span>
                                                        <span ng-if=group.status==5>已下课</span>
                                                        <span ng-if=group.status==6>已爽约</span>
                                                        <span ng-if=group.status==7>已爽约</span>
                                                    </td>
                                                    <td>
                                                        <span ng-if="group.about_type == 1">电脑预约</span>
                                                        <span ng-if="group.about_type == 2">APP预约</span>
                                                        <span ng-if="group.about_type == 3">小程序预约</span>
                                                    </td>
                                                    <td>{{group.employee.name | noData:''}}</td>
                                                </tr>

                                                </tbody>
                                            </table>
                                            <?= $this->render('@app/views/common/pagination.php', ['page' => 'groupPages']); ?>
                                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'groupNoDataShow', 'text' => '无团课记录', 'href' => true]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--柜子-->
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
                                                        colspan="1" aria-label="浏览器：激活排序列升序">租用日期
                                                    </th>
                                                    <th class="sorting a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">消费日期
                                                    </th>
                                                    <th class="sorting a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">金额
                                                    </th>
                                                    <th class="sorting a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">行为
                                                    </th>
                                                    <th class="sorting a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">经办人
                                                    </th>
                                                    <!--<th class="sorting" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序"
                                                        style="width: 140px;">操作
                                                    </th>-->
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat='cabinet in cabinets'>
                                                    <td>{{cabinet.type_name |
                                                        noData:''}}
                                                    </td>
                                                    <td>{{cabinet.cabinet_number | noData:''}}</td>
                                                    <td>{{cabinet.start_rent *1000 | noData:''|
                                                        date:'yyyy/MM/dd'}} - {{cabinet.end_rent *1000 |
                                                        noData:''| date:'yyyy/MM/dd'}}
                                                    </td>
                                                    <td ng-if="cabinet.rent_type == '退租金'">{{cabinet.back_rent *1000 | noData:''|
                                                        date:'yyyy/MM/dd'}}</td>
                                                    <td ng-if="cabinet.rent_type != '退租金'">{{cabinet.create_at *1000 | noData:''|
                                                        date:'yyyy/MM/dd'}}
                                                    </td>
                                                    <td>{{cabinet.price | noData:'元'}}</td>
                                                    <td>{{cabinet.rent_type}}</td>
                                                    <td ng-if="cabinet.name != null && cabinet.name != ''">
                                                        {{cabinet.name}}
                                                    </td>
                                                    <td ng-if="cabinet.name == null || cabinet.name == ''">
                                                        暂无数据
                                                    </td>
                                                    <!--<td>
                                                        &nbsp;
                                                        <button ng-disabled="MemberStatusFlag == '2'"
                                                                class="btn btn-sm btn-danger"
                                                                ng-click="delMemberCabinet(cabinet.memberCabinetId,cabinet.id)">
                                                            删除
                                                        </button>
                                                    </td>-->
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?= $this->render('@app/views/common/pagination.php', ['page' => 'cabinetPages']); ?>
                                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'cabinetNoDataShow', 'text' => '无柜子记录', 'href' => true]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--预约场地记录-->
                            <div id="tab-6" class="tab-pane">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>场地记录列表</h5>
                                    </div>
                                    <div class="ibox-content" style="padding: 0">
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
                                                        卡名称
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
                                                <tr ng-repeat="info in yardRecordData">
                                                    <td title="{{info.name}} - {{info.vName}}">{{info.name}} - {{info.vName}}</td>
                                                    <td>{{info.card_name}}</td>
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
                                </div>
                            </div>
                            <!--请假-->
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
                                                        colspan="1" aria-label="浏览器：激活排序列升序">卡名称
                                                    </th>
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
                                                        colspan="1" aria-label="浏览器：激活排序列升序">销假时间
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
                                                        colspan="1" aria-label="浏览器：激活排序列升序">请假类型
                                                    </th>
                                                    <th class="sorting a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">经办人
                                                    </th>
                                                    <th class="sorting a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">请假途径
                                                    </th>
                                                    <th class="sorting a28" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">销假
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat='vacate in vacates'>
                                                    <td>
                                                        {{vacate.card_name | noData:''}}
                                                    </td>
                                                    <td>{{vacate.create_at *1000 | noData:''|
                                                        date:'yyyy/MM/dd'}}
                                                    </td>
                                                    <td>{{vacate.leave_start_time *1000 | noData:''|
                                                        date:'yyyy/MM/dd'}}
                                                    </td>
                                                    <td>{{vacate.terminate_time *1000 | noData:''|
                                                        date:'yyyy/MM/dd'}}
                                                    </td>
                                                    <td>{{vacate.leave_length | noData:'天'}}</td>
                                                    <td title="{{ vacate.note }}">{{vacate.note | cut:true:4:'...' | noData:''}}</td>
                                                    <td>
                                                        <span ng-if="vacate.leave_type == '1'">正常请假</span>
                                                        <span ng-if="vacate.leave_type == '2'">特殊请假</span>
                                                        <span ng-if="vacate.leave_type == '3'">学生请假</span>
                                                        <span ng-if="vacate.leave_type != '1' && vacate.leave_type != '2' && vacate.leave_type != '3'">暂无数据</span>
                                                    </td>
                                                    <td>
                                                        <span ng-show="vacate.source == 0 || vacate.source == 1">{{ vacate.employeeName == null ? '暂无数据' : vacate.employeeName }}</span>
                                                        <span ng-show="vacate.source == 2 || vacate.source == 3 || vacate.source == 4 ">{{ MemberData.name }}</span>
                                                    </td>
                                                    <td>
                                                        <span ng-if="vacate.source == 1 || vacate.source == 0">电脑</span>
                                                        <span ng-if="vacate.source == 2">小程序</span>
                                                        <span ng-if="vacate.source == 3">公众号</span>
                                                        <span ng-if="vacate.source == 4">APP</span>
                                                    </td>
                                                    <td>
                                                        <div ng-if="vacate.status == 1" class="btn btn-sm btn-default"
                                                             ng-disabled="MemberStatusFlag == '2'"
                                                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'XIAOJIA')) { ?>
                                                                ng-click="removeLeave(vacate.id,vacate.status)"
                                                            <?php } ?>
                                                        >
                                                            销假
                                                        </div>
                                                        <div ng-if="vacate.status == 2 && vacate.type == 2" class="btn btn-sm btn-default"
                                                             ng-disabled="MemberStatusFlag == '2'">
                                                            已销假
                                                        </div>
                                                        <div ng-if="vacate.status == 2 && vacate.type == 3" class="btn btn-sm btn-default"
                                                             ng-disabled="MemberStatusFlag == '2'">
                                                            已拒绝
                                                        </div>
                                                        <div ng-if="vacate.status == 3" class="btn btn-sm btn-default"
                                                             ng-disabled="MemberStatusFlag == '2'">
                                                            审核中
                                                        </div>
                                                        <div ng-if="vacate.status == 4" class="btn btn-sm btn-default"
                                                             ng-disabled="MemberStatusFlag == '2'">
                                                            已登记
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
                            <!--信息记录-->
                            <div id="tab-8" class="tab-pane">
                                <div class="ibox float-e-margins">
                                    <div class="row ">
                                        <div class="col-md-6">
                                            <select class="form-control w160" ng-model="selectEntryRecord"
                                                    ng-change="SelectMessage(selectEntryRecord)" style="padding-top: 4px;">
                                                <option value="">到场离场</option>
                                                <option value="1">赠品记录</option>
                                                <option value="2">行为记录</option>
                                                <option value="3">送人记录</option>
                                                <option value="4">私教课延期</option>
                                                <option value="5">赠送天数</option>
                                                <option value="6" class="Deposits">定金信息</option>
                                                <option value="7">会籍记录</option>
                                                <option value="8">转卡记录</option>
                                                <option value="9">私教变更</option>
                                                <option value="10">IC卡绑定</option>
                                                <option value="11">场馆变更记录</option>
<!--                                                <option value="7">卡种匹配记录</option>-->
                                            </select>
                                        </div>
                                        <div class="col-md-3 Deposit pd0 depositSelect DN">
                                            <select class="form-control w160 pull-right depositGetSelect" ng-change="depositSelectChange(depositSelect)" ng-model="depositSelect" style="padding-top: 4px;">
                                                <option value="">请选择缴费定金</option>
                                                <option value="1">购卡定金</option>
                                                <option value="2">购课定金</option>
                                                <option value="3">续费定金</option>
                                                <option value="4">卡升级定金</option>
                                                <option value="5">课升级定金</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 Deposit depositSelect DN">
                                            <span style="color: orange;font-size: 16px;font-weight: 700;line-height: 30px;">
                                                定金:{{depositAllMoney}} 元
                                            </span>
<!--                                            <span style="color: orange;font-size: 16px;font-weight: 700;line-height: 30px;">-->
<!--                                                抵券:{{depositAllVoucher}} 元-->
<!--                                            </span>-->
                                        </div>
                                    </div>
                                    <div ng-show="selectEntryRecord == ''">
                                        <div class="ibox-title" style="position: relative;">
                                            <h5>到场、离场记录列表
                                                <span class="a26" ng-if="entryTime == ''">共进场次数{{count}}次</span>
                                                <span class="a29"
                                                      ng-if="entryTime != ''">{{entryTime}}共进场次数{{count}}次</span>
                                                <input type="text" id='backDateTimeInfo' class="input-sm form-control" name="start" placeholder="选择日期查看" readonly style="position:absolute;top: 6px;right: 80px;width: 160px;text-align:left;font-size: 13px;font-weight:normal;cursor: pointer;">
                                                <button class="btn btn-info btn-sm"
                                                        style="position: absolute;top: 6px;right: 20px;"
                                                        ng-click="initBackDateTimeInfo()">清空
                                                </button>
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
                                                        <th class="bgw a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">场馆
                                                        </th>
                                                        <th class="bgw a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">卡名称
                                                        </th>
                                                        <th class="bgw a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">进场时间
                                                        </th>
                                                        <th class="bgw a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">离场时间
                                                        </th>
                                                        <th class="bgw a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">总时长
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr ng-repeat='entry in entrys'>
                                                        <td>{{entry.name | noData:''}}
                                                        <td>{{entry.card_name | noData:''}}
                                                        </td>
                                                        <td ng-if="entry.entry_time != 'et' ">{{entry.entry_time *1000 | date:'yyyy/MM/dd HH:mm'}}</td>
                                                        <td ng-if="entry.entry_time == 'et' ">暂无数据</td>
                                                        <td ng-if="entry.leaving_time != 'lt' ">{{entry.leaving_time *1000 | date:'yyyy/MM/dd HH:mm'}}</td>
                                                        <td ng-if="entry.leaving_time == 'lt' ">暂无数据</td>
                                                        <td ng-if="entry.entry_time !='et' && entry.leaving_time !='lt'">{{entry.abc}}小时</td>
                                                        <td ng-if="entry.entry_time =='et' || entry.leaving_time =='lt'">暂无数据</td>
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
                                                            <span
                                                                ng-if="x.create_at == null && x.create_at == ''">暂无数据</span>
                                                        </td>
                                                        <td>
                                                            <span ng-if="x.get_day != null && x.get_day != ''">{{x.get_day*1000|date:'yyyy-MM-dd HH:mm:ss'}}</span>
                                                            <span
                                                                ng-if="x.get_day == null && x.get_day == ''">暂无数据</span>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-success w100 btn-sm"
                                                                    ng-click="receiveGift(x.id)" ng-if="x.status == 1">
                                                                领取
                                                            </button>
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
                                                            colspan="1" aria-label="浏览器：激活排序列升序">创建时间
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
                                                            <span ng-if="behaviorRecord.behavior =='4'">激活时间</span>
                                                            <span ng-if="behaviorRecord.behavior =='5'">到期时间</span>
                                                        </td>
                                                        <td>{{behaviorRecord.create_at*1000 |date:'yyyy-MM-dd
                                                            HH:mm:ss'}}
                                                        </td>
                                                        <td>{{behaviorRecord.note |noData:''}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <?= $this->render('@app/views/common/nodata.php', ['name' => 'behaviorRecordFlag', 'text' => '暂无数据', 'href' => true]); ?>
                                                <?= $this->render('@app/views/common/pagination.php', ['page' => 'behaviorRecordPages']); ?>
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
                                                <?= $this->render('@app/views/common/nodata.php', ['name' => 'payNoSendCardRecordDataShow', 'text' => '暂无送人记录', 'href' => true]); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div ng-if="selectEntryRecord == 4">
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
                                                            colspan="1" aria-label="浏览器：激活排序列升序">课程名称
                                                        </th>
                                                        <th class="a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">剩余节数
                                                        </th>
                                                        <th class="a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">延期天数
                                                        </th>
                                                        <th class="a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">到期日期
                                                        </th>
                                                        <th class="a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">备注
                                                        </th>
                                                        <th class="a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">操作人
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr ng-repeat="d in delayPrivateRecordList">
                                                        <td>{{d.course_name|noData:''}}</td>
                                                        <td>{{d.course_num|noData:''}}</td>
                                                        <td>{{d.postpone_day|noData:''}}</td>
                                                        <td>
                                                            <span ng-if="d.due_day == null">暂无数据</span>
                                                            <span ng-if="d.due_day != null">{{d.due_day*1000|date:'yyyy-MM-dd'}}</span>
                                                        </td>
                                                        <td>{{d.remark|noData:''}}</td>
                                                        <td>{{d.employee.name|noData:''}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <?= $this->render('@app/views/common/nodata.php', ['name' => 'priDelayNoDataShow', 'text' => '无延期记录', 'href' => true]); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div ng-if="selectEntryRecord == 5">
                                        <div class="ibox-content" style="padding: 0;height: 400px;overflow-y: auto;">
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
                                                            colspan="1" aria-label="浏览器：激活排序列升序">卡名
                                                        </th>
                                                        <th class="a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">赠送类型
                                                        </th>
                                                        <th class="a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">赠送天数
                                                        </th>
                                                        <th class="a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">赠送时间
                                                        </th>
                                                        <th class="a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">备注
                                                        </th>
                                                        <th class="a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">操作
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr ng-repeat="gifts in giftDaysInfoRecondData">
                                                        <td>{{gifts.card_name | noData:''}}</td>
                                                        <td>
                                                            <span ng-if="gifts.type == '1'">新办卡的赠送</span>
                                                            <span ng-if="gifts.type == '2'">其他赠送</span>
                                                        </td>
                                                        <td>{{gifts.num | noData:''}}</td>
                                                        <td>
                                                            <span ng-if="gifts.create_at != null">{{gifts.create_at*1000 | date:'yyyy-MM-dd'}}</span>
                                                            <span ng-if="gifts.create_at == null">暂无数据</span>
                                                        </td>
                                                        <td>{{gifts.note | noData:''}}</td>
                                                        <td>
                                                            <span ng-if="gifts.giftType == 1">
                                                                <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'REVOKE')) { ?>
                                                                    <button type="button" class="btn btn-danger" ng-click="cancelGiftDay(gifts.id,gifts.member_card_id)">撤销</button>
                                                                <?php } ?>
                                                            </span>
                                                            <span ng-if="gifts.giftType == 2">已撤销</span>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <?= $this->render('@app/views/common/nodata.php', ['name' => 'giftNoDataInfoHaShow', 'text' => '无赠送记录', 'href' => true]); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div ng-if="selectEntryRecord == 6">
<!--                                        <div class="deposit_user row">-->
<!--                                            <div class="col-md-7"></div>-->
<!--                                            <div class="deposit_user-div col-xs-12 col-md-5">-->
<!--                                                 <span class="deposit_user_span">-->
<!--                                                购卡总定金：500元-->
<!--                                            </span>-->
<!--                                            <span class="deposit_user_span">-->
<!--                                                购课总定金：300元-->
<!--                                            </span>-->
<!--                                            <span class="deposit_user_span">-->
<!--                                                缴费总定金：200元-->
<!--                                            </span>-->
<!--                                            <span class="deposit_user_span">-->
<!--                                                升级总定金：400元-->
<!--                                            </span class="deposit_user_span">-->
<!--                                            </div>-->
<!--                                        </div>-->
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
<!--                                                            <th class="a28" tabindex="0"-->
<!--                                                                aria-controls="DataTables_Table_0" rowspan="1"-->
<!--                                                                colspan="1" aria-label="浏览器：激活排序列升序">抵券-->
<!--                                                            </th>-->
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
                                                            <td ng-if="zzz.type == '3' || zzz.type == 3">续费定金</td>
                                                            <td ng-if="zzz.type == '4' || zzz.type == 4">卡升级定金</td>
                                                            <td ng-if="zzz.type == '5' || zzz.type == 5">课升级定金</td>
                                                            <td ng-if="zzz.type == undefined || zzz.type == null || zzz.type == ''">暂无数据</td>
                                                            <td>{{zzz.price | number:'2' | noData:''}}</td>
<!--                                                            <td>{{zzz.voucher | number:'2' | noData:''}}</td>-->
                                                            <td>{{zzz.start_time*1000 | date:'yyyy-MM-dd'}}&nbsp;-&nbsp;{{zzz.end_time*1000 | date:'yyyy-MM-dd'}}</td>
                                                            <td ng-if="zzz.pay_mode == '1' || zzz.pay_mode == 1">现金</td>
                                                            <td ng-if="zzz.pay_mode == '2' || zzz.pay_mode == 2">支付宝</td>
                                                            <td ng-if="zzz.pay_mode == '3' || zzz.pay_mode == 3">微信</td>
                                                            <!--<td ng-if="zzz.pay_mode == '4' || zzz.pay_mode == 4">pos刷卡</td>-->
                                                            <td ng-if="zzz.pay_mode == '5' || zzz.pay_mode == 5">建设分期</td>
                                                            <td ng-if="zzz.pay_mode == '6' || zzz.pay_mode == 6">广发分期</td>
                                                            <td ng-if="zzz.pay_mode == '7' || zzz.pay_mode == 7">招行分期</td>
                                                            <td ng-if="zzz.pay_mode == '8' || zzz.pay_mode == 8">借记卡</td>
                                                            <td ng-if="zzz.pay_mode == '9' || zzz.pay_mode == 9">贷记卡</td>
                                                            <td>{{zzz.pay_money_time*1000 | date:'yyyy-MM-dd'}}</td>
                                                            <td>
                                                                <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DELETEDEPOSIT')) { ?>
                                                                    <button type="button" class="btn btn-danger" ng-click="depositInfoDelete(zzz.id)">删除</button>
                                                                <?php } ?>
                                                                <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'UPDATEDEPOSIT')) { ?>
                                                                    <button type="button" class="btn btn-info" ng-click="depositInfoUpdate(zzz)">修改</button>
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <?= $this->render('@app/views/common/nodata.php', ['name' => 'priDelayNoDataShow', 'text' => '无定金信息记录', 'href' => true]); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div ng-if="selectEntryRecord == 7">
                                        <div class="ibox-content" style="padding: 0;">
                                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline a26" role="grid">
                                                <table class="table table-striped table-bordered table-hover dataTable">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="a28" rowspan="1" colspan="1">会籍姓名</th>
                                                            <th class="a28" rowspan="1" colspan="1">创建时间</th>
                                                            <th class="a28" rowspan="1" colspan="1">行为</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="CCRecord in consultantChangeRecord">
                                                            <td>{{ CCRecord.name }}</td>
                                                            <td>{{ CCRecord.created_at*1000 | date:'yyyy-MM-dd' }}</td>
                                                            <td ng-if="CCRecord.behavior == 1">入馆</td>
                                                            <td ng-if="CCRecord.behavior == 2">办卡</td>
                                                            <td ng-if="CCRecord.behavior == 3">修改</td>
                                                            <td ng-if="CCRecord.behavior == 4">续费</td>
                                                            <td ng-if="CCRecord.behavior == 5">升级</td>
                                                            <td ng-if="CCRecord.behavior == null || CCRecord.behavior == undefined || CCRecord.behavior == ''">暂无数据</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <?= $this->render('@app/views/common/pagination.php',['page'=>'consultantChangePage']); ?>
                                                <?= $this->render('@app/views/common/nodata.php', ['name' => 'consultantChangeRecordNoData', 'text' => '无会籍变更记录', 'href' => true]); ?>
                                            </div>
                                        </div>
                                    </div>
<!--                                    <div ng-if="selectEntryRecord == 7">-->
<!--                                        <div class="ibox-content" style="padding: 0;">-->
<!--                                            <div id="DataTables_Table_0_wrapper"-->
<!--                                                 class="dataTables_wrapper form-inline a26" role="grid">-->
<!--                                                <table class="table table-striped table-bordered table-hover dataTables-example dataTable"-->
<!--                                                    id="DataTables_Table_0"-->
<!--                                                    aria-describedby="DataTables_Table_0_info"-->
<!--                                                    style="position: relative;">-->
<!--                                                    <thead>-->
<!--                                                        <tr role="row">-->
<!--                                                            <th class="a28" tabindex="0"-->
<!--                                                                aria-controls="DataTables_Table_0" rowspan="1"-->
<!--                                                                colspan="1" aria-label="浏览器：激活排序列升序">操作人-->
<!--                                                            </th>-->
<!--                                                            <th class="a28" tabindex="0"-->
<!--                                                                aria-controls="DataTables_Table_0" rowspan="1"-->
<!--                                                                colspan="1" aria-label="浏览器：激活排序列升序">操作时间-->
<!--                                                            </th>-->
<!--                                                            <th class="a28" tabindex="0"-->
<!--                                                                aria-controls="DataTables_Table_0" rowspan="1"-->
<!--                                                                colspan="1" aria-label="浏览器：激活排序列升序">老卡名称-->
<!--                                                            </th>-->
<!--                                                            <th class="a28" tabindex="0"-->
<!--                                                                aria-controls="DataTables_Table_0" rowspan="1"-->
<!--                                                                colspan="1" aria-label="浏览器：激活排序列升序">新卡名称-->
<!--                                                            </th>-->
<!--                                                            <th class="a28" tabindex="0"-->
<!--                                                                aria-controls="DataTables_Table_0" rowspan="1"-->
<!--                                                                colspan="1" aria-label="浏览器：激活排序列升序">匹配属性-->
<!--                                                            </th>-->
<!--                                                            <th class="a28" tabindex="0"-->
<!--                                                                aria-controls="DataTables_Table_0" rowspan="1"-->
<!--                                                                colspan="1" aria-label="浏览器：激活排序列升序">备注-->
<!--                                                            </th>-->
<!--                                                        </tr>-->
<!--                                                    </thead>-->
<!--                                                    <tbody>-->
<!--                                                        <tr ng-repeat="record in recordList">-->
<!--                                                            <td>{{record.name | noData:''}}</td>-->
<!--                                                            <td>{{record.create_at*1000 | date:'yyyy-MM-dd'}}</td>-->
<!--                                                            <td>{{record.memberCardName | noData:''}}</td>-->
<!--                                                            <td>{{record.card_name | noData:''}}</td>-->
<!--                                                            <td class="slashAdd">-->
<!--                                                                <span ng-repeat="mateType in  record.attribute_matching | jsonParse">-->
<!--                                                                    <span ng-if="mateType == 1 || mateType == '1'">卡的属性</span>-->
<!--                                                                    <span ng-if="mateType == 2 || mateType == '2'">卡的类型</span>-->
<!--                                                                    <span ng-if="mateType == 3 || mateType == '3'">是否带人</span>-->
<!--                                                                    <span ng-if="mateType == 4 || mateType == '4'">通用场馆限制</span>-->
<!--                                                                    <span ng-if="mateType == 5 || mateType == '5'">进馆时间限制</span>-->
<!--                                                                    <span ng-if="mateType == 6 || mateType == '6'">团课套餐</span>-->
<!--                                                                    <span ng-if="mateType == 7 || mateType == '7'">请假</span>-->
<!--                                                                    <span ng-if="mateType == 8 || mateType == '8'">赠品</span>-->
<!--                                                                    <span ng-if="mateType == 9 || mateType == '9'">转让</span>-->
<!--                                                                    <span ng-if="mateType == 10 || mateType == '10'">合同</span>-->
<!--                                                                </span>-->
<!--                                                            </td>-->
<!--                                                            <td>{{record.note | noData:''}}</td>-->
<!--                                                        </tr>-->
<!--                                                    </tbody>-->
<!--                                                </table>-->                                     
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                    <div ng-if="selectEntryRecord == 8">
                                        <div class="ibox-content" style="padding: 0;">
                                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline a26" role="grid">
                                                <table class="table table-striped table-bordered table-hover dataTable">
                                                    <thead>
                                                    <tr role="row">
                                                        <th class="a28" rowspan="1" colspan="1">转出方</th>
                                                        <th class="a28" rowspan="1" colspan="1">转入方</th>
                                                        <th class="a28" rowspan="1" colspan="1">转卡卡号</th>
                                                        <th class="a28" rowspan="1" colspan="1">转卡费用</th>
                                                        <th class="a28" rowspan="1" colspan="1">操作时间</th>
                                                        <th class="a28" rowspan="1" colspan="1">操作人</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="turnCardRecord in turnCardRecordList">
                                                            <td>{{turnCardRecord.fromName + ' ' + turnCardRecord.fromMobile}}</td>
                                                            <td>{{turnCardRecord.toName + ' ' + turnCardRecord.toMobile}}</td>
                                                            <td>{{turnCardRecord.card_number}}</td>
                                                            <td>{{turnCardRecord.transfer_price + '元'}}</td>
                                                            <td>{{turnCardRecord.transfer_time*1000 | date:'yyyy-MM-dd'}}</td>
                                                            <td ng-if="turnCardRecord.name == undefined || turnCardRecord.name == '' || turnCardRecord.name == null">暂无数据</td>
                                                            <td ng-if="turnCardRecord.name !='' && turnCardRecord.name != undefined && turnCardRecord.name != null">{{turnCardRecord.name}}</td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <?= $this->render('@app/views/common/nodata.php', ['name' => 'noTransferData', 'text' => '无转卡记录', 'href' => true]); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div ng-if="selectEntryRecord == 9">
                                        <div class="ibox-content" style="padding: 0;">
                                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline a26" role="grid">
                                                <table class="table table-striped table-bordered table-hover dataTable">
                                                    <thead>
                                                        <tr role="row">
                                                            <th class="a28" rowspan="1" colspan="1">私教姓名</th>
                                                            <th class="a28" rowspan="1" colspan="1">创建时间</th>
                                                            <th class="a28" rowspan="1" colspan="1">行为</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr ng-repeat="PTCRecord in privateTeachChangeRecord">
                                                            <td>{{ PTCRecord.name }}</td>
                                                            <td>{{ PTCRecord.created_at*1000 | date:'yyyy-MM-dd' }}</td>
                                                            <td ng-if="PTCRecord.behavior == 1">入馆</td>
                                                            <td ng-if="PTCRecord.behavior == 2">办卡</td>
                                                            <td ng-if="PTCRecord.behavior == 3">修改</td>
                                                            <td ng-if="PTCRecord.behavior == 4">续费</td>
                                                            <td ng-if="PTCRecord.behavior == 5">升级</td>
                                                            <td ng-if="PTCRecord.behavior == null || PTCRecord.behavior == undefined || PTCRecord.behavior == ''">暂无数据</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <?= $this->render('@app/views/common/pagination.php',['page'=>'privateChangePage']); ?>
                                                <?= $this->render('@app/views/common/nodata.php', ['name' => 'privateChangeRecordNoData', 'text' => '无私教变更记录', 'href' => true]); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div ng-if="selectEntryRecord == 11">
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
                                                            colspan="1" aria-label="浏览器：激活排序列升序">旧所属场馆
                                                        </th>
                                                        <th class=" a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">新所属场馆
                                                        </th>
                                                        <th class=" a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">创建时间
                                                        </th>
                                                        <th class=" a28" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1"
                                                            colspan="1" aria-label="浏览器：激活排序列升序">创建人
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr ng-repeat="changeVenue in  memberChangeVenueList">
                                                        <td>{{ changeVenue.oldVenue | noData:'' }}</td>
                                                        <td>{{ changeVenue.newVenue | noData:'' }}</td>
                                                        <td>{{ changeVenue.create_date | noData:'' }}</td>
                                                        <td>{{ changeVenue.employeeName | noData:'' }}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <?= $this->render('@app/views/common/nodata.php', ['name' => 'memberChangeVenueShow', 'text' => '暂无数据', 'href' => true]); ?>
                                        </div>
                                        </div>
                                    </div>
                                    <div ng-if="selectEntryRecord == 10">
                                        <div class="ibox-content" style="padding: 0;">
                                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline a26" role="grid">
                                                <table class="table table-striped table-bordered table-hover dataTable">
                                                    <thead>
                                                    <tr role="row">
                                                        <th class="a28" rowspan="1" colspan="1">IC卡号</th>
                                                        <th class="a28" rowspan="1" colspan="1">绑定时间</th>
                                                        <th class="a28" rowspan="1" colspan="1">解绑时间</th>
                                                        <th class="a28" rowspan="1" colspan="1">状态</th>
                                                        <th class="a28" rowspan="1" colspan="1">操作人</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr ng-repeat="i in icCardListInfo">
                                                        <td>{{i.custom_ic_number | noData:''}}</td>
                                                        <td>
                                                            <span ng-if="i.create_at != null && i.create_at != ''">{{i.create_at * 1000 | date:'yyyy-MM-dd'}}</span>
                                                            <span ng-if="i.create_at == null || i.create_at == ''">暂无数据</span>
                                                        </td>
                                                        <td>
                                                            <span ng-if="i.unbundling != null && i.unbundling != '' && i.unbundling != '0'">{{i.unbundling * 1000 | date:'yyyy-MM-dd'}}</span>
                                                            <span ng-if="i.unbundling == null || i.unbundling == '' || i.unbundling == '0'">暂无数据</span>
                                                        </td>
                                                        <td>
                                                            <span ng-if="i.status == '1'">已绑定</span>
                                                            <span ng-if="i.status == '2'">已解绑</span>
                                                        </td>
                                                        <td>{{i.name | noData:''}}</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <?= $this->render('@app/views/common/pagination.php',['page'=>'icCardPage']); ?>
                                                <?= $this->render('@app/views/common/nodata.php', ['name' => 'icCardNoData', 'text' => '无IC卡绑定记录', 'href' => true]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--消费记录-->
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
                                                    <th class="sorting a28" tabindex="0"
                                                        ng-click="recordsOfConsumption('member_consumptionDate',sort)"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1" aria-label="浏览器：激活排序列升序">消费时间
                                                    </th>
                                                    <th class="sorting a28" tabindex="0"
                                                        ng-click="recordsOfConsumption('member_consumptionAmount',sort)"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1">消费金额/次数
                                                    </th>
                                                    <th class="sorting a28" tabindex="0"
                                                        ng-click="recordsOfConsumption('member_consumptionType',sort)"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        colspan="1">业务行为
                                                    </th>
                                                    <th class="bgWhite" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1"
                                                        colspan="1">备注
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr ng-repeat='expense in expenses'>
                                                    <td>{{expense.consumption_date *1000 | noData:''|
                                                        date:'yyyy/MM/dd'}}
                                                    </td>
                                                    <!--                                                    <td>-->
                                                    <!--                                                        <span ng-if=expense.type==1>现金</span>-->
                                                    <!--                                                        <span ng-if=expense.type==2>支付宝</span>-->
                                                    <!--                                                        <span ng-if=expense.type==3>微信</span>-->
                                                    <!--                                                        <span ng-if=expense.type==4>POS机</span>-->
                                                    <!--                                                        <span ng-if=expense.type==5>建设分期</span>-->
                                                    <!--                                                        <span ng-if=expense.type==6>广发分期</span>-->
                                                    <!--                                                        <span ng-if=expense.type==7>招行分期</span>-->
                                                    <!--                                                        <span ng-if=expense.type==8>借记卡</span>-->
                                                    <!--                                                        <span ng-if=expense.type==9>贷记卡</span>-->
                                                    <!--                                                    </td>-->
                                                    <td><span ng-if=expense.type==1>{{expense.consumption_amount | noData:'元'}}</span>
                                                        <span ng-if=expense.type==2>{{expense.consumption_times | noData:'次'}}</span>
                                                        <span ng-if=expense.type==3>{{expense.consumption_amount | noData:'元'}}</span>
                                                    </td>
                                                    <td>{{expense.category | noData:''}}</td>
                                                    <td title="{{expense.remarks|noData:''}}">
                                                        <span ng-if="expense.remarks != null && expense.remarks != ''">{{expense.remarks | cut:true:15:'...'}}</span>
                                                        <span
                                                            ng-if="expense.remarks == null || expense.remarks == ''">无</span>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <!--                                                <? //= $this->render('@app/views/common/pagination.php', ['page' => 'payPages']); ?> -->
                                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'payNoDataShow', 'text' => '无消费记录', 'href' => true]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--私课-->
                            <div id="tab-14" class="tab-pane">
                                <div class="ibox-content" style="padding: 0;border: none;">
                                    <div class="col-sm-12 pd0">
                                        <div class="col-sm-5 text-right">
                                            <img src="/plugins/user/images/default.png" width="300px"
                                                 height="190px">
                                        </div>
                                        <div class="col-sm-7" style="padding-right: 0;">
                                            <p class="a30">{{privateLessonTemplet.name}}
                                                <span class="label label-success" ng-if="privateLessonTemplet.status == 1">正常</span>
                                                <span class="label label-danger" ng-if="privateLessonTemplet.status == 2">冻结</span>
                                                <select class="btn btn-white wSelectAddHiH pull-right"
                                                        ng-change="privateLessonSelectClick(privateLessonSelect)"
                                                        ng-model="privateLessonSelect">
                                                    <option ng-if="privateLessonInformations == 0" value="">
                                                        暂无数据
                                                    </option>
                                                    <option ng-if="privateLessonInformations.length != 0"
                                                            value="{{w.orderId}}"
                                                            ng-repeat="w in privateLessonInformations">
                                                        {{w.name}}
                                                    </option>
                                                </select>
                                            </p>
                                            <p class="mT10"
                                               ng-if="privateLessonTemplet.money_amount != null">
                                                课程金额:{{privateLessonTemplet.money_amount | number:2}}</p>
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
                                            <p class="mT10" ng-if="privateLessonTemplet.delayTimes != null && privateLessonTemplet.delayTimes != ''">已延期次数:{{privateLessonTemplet.delayTimes}}</p>
                                            <p class="mT10" ng-if="privateLessonTemplet.delayTimes == null || privateLessonTemplet.delayTimes == ''">已延期次数:暂无数据</p>
                                            <p class="mT10" ng-if="privateLessonTemplet.note != null && privateLessonTemplet.note != ''">备注:{{privateLessonTemplet.note}}</p>
                                            <p class="mT10" ng-if="privateLessonTemplet.note == null || privateLessonTemplet.note == ''">备注:暂无数据</p>
                                            <div class="col-sm-12 pd0 mT10" ng-if="privateLessonTemplet != null">
                                                <div ng-if="privateLessonTemplet.cloudOrderId == undefined">
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'CHANGECLASS')) { ?>
                                                        <button style="padding: 4px 12px;" class="btn text-center a33 "
                                                                ng-disabled="privateLessonTemplet.status == 2 || privateLessonTemplet.money_amount == null"
                                                                ng-click="transfer()">转课
                                                        </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DELAY')) { ?>
                                                        <button style="background-color: #999;"
                                                                class="a33 btn text-center btn-sm "
                                                                ng-disabled="privateLessonTemplet.status == 2 || privateLessonTemplet.money_amount == null"
                                                                ng-click="postpone()">延期
                                                        </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'MODIFYCLASSNUM')) { ?>
                                                        <button class="btn btn-success text-center"
                                                                style="margin-top: 10px;font-size: 12px;"
                                                                ng-disabled="privateLessonTemplet.id == null || privateLessonTemplet.status == 2"
                                                                data-toggle="modal" data-target="#ModifyClassNumModal">
                                                            修改剩余节数
                                                        </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'CHARGECLASSUPDATE')) { ?>
                                                        <button class="btn btn-info text-center"
                                                                style="margin-top: 10px;font-size: 12px;"
                                                                ng-disabled="privateLessonTemplet.id == null || privateLessonTemplet.status == 2"
                                                                ng-click="chargeEdit()">
                                                            私教课修改
                                                        </button>
                                                    <?php } ?>
                                                    <button class="btn btn-default"  style="margin-top: 10px;font-size: 12px;"
                                                            ng-disabled="privateLessonTemplet.id == null || privateLessonTemplet.status == 2"
                                                            ng-click="contractInfoBtn(privateLessonTemplet.deal_id)">
                                                        查看会员协议
                                                    </button>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'PRIVATECLASSUPGRADE')) { ?>
                                                        <button class="btn btn-success text-center"
                                                                style="margin-top: 10px;font-size: 12px;"
                                                                ng-disabled="privateLessonTemplet.id == null || privateLessonTemplet.status == 2"
                                                                ng-click="upgradePrivateLesson(privateLessonTemplet.product_id)">
                                                            私教课升级
                                                        </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'UPLOADCONTRACT')) { ?>
                                                    <button class="btn btn-default"  style="margin-top: 10px;font-size: 12px;" ng-disabled="privateLessonTemplet.id == null || privateLessonTemplet.status == 2" ng-click="uploadContract(privateLessonTemplet.member_id,privateLessonTemplet.orderDetailsId,2)">
                                                        私教合同
                                                    </button>
                                                    <?php } ?>
                                                </div>

                                                <div ng-if="privateLessonTemplet.cloudOrderId != undefined">
                                                    <span>私教课程已退费</span>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-sm-12 a3 mrt10">
                                            <div class="ibox float-e-margins">
                                                <div class="col-sm-12 pdLR0"
                                                     style="display: flex;justify-content: space-between;padding-top: 6px;padding-left: 0;padding-right: 0px;">
                                                    <select class="form-control"
                                                            style="width: 140px;padding-top: 4px;"
                                                            ng-change="selectPTRecord(iboxCcontentModel)"
                                                            ng-model="iboxCcontentModel">
                                                        <option value="">约课记录</option>
                                                        <option value="1">续费记录</option>
                                                        <option value="2">私教</option>
                                                        <option value="3">延期记录</option>
                                                    </select>
                                                    <div style="display: flex;">
                                                        <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'PRIVATECLASSADD')) { ?>
                                                            <button class="btn btn-info btn-sm" ng-model="personalList"
                                                                    ng-click="addPersonalList()"
                                                                    style="width: 60px;font-size: 12px;">新增
                                                            </button>
                                                        <?php } ?>
                                                        <div ng-if="iboxCcontentModel == '2'">
                                                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DELPRIVATE')) { ?>
                                                                <button class="btn btn-danger btn-sm"
                                                                        ng-click="batchDeletingCourseMess()"
                                                                        style="margin-left: 10px;"> 批量删除
                                                                </button>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div ng-if="iboxCcontentModel == ''" class="ibox-content "
                                                     style="padding: 0;">
                                                    <div id="DataTables_Table_0_wrapper"
                                                         class="dataTables_wrapper form-inline a26"
                                                         role="grid"
                                                         style="height: 280px;overflow-y: auto;">
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
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1"
                                                                    style="width: 120px;">总节数/剩余节数
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1"
                                                                    style="width: 120px;">课程类型
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1"
                                                                    style="width: 120px;">上课时长
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1"
                                                                    style="width: 100px;">上课教练
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1"
                                                                    style="width: 100px;">课时费
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1"
                                                                    style="width: 120px;">状态
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr ng-repeat='w in appointmentRecord'>
                                                                <td>{{w.start *1000 | date:'yyyy-MM-dd HH:mm'}}</td>
                                                                <td><span>{{w.course_amount}}</span>/<span>{{w.overage_section}}</span></td>
                                                                <td>
                                                                    <span ng-if="w.type == '1' && w.category == 1">多课程 </span>
                                                                    <span ng-if="w.type == '1' && w.category == 2">单课程</span>
                                                                    <span ng-if="w.type == '3'">私教多人课</span>
                                                                </td>
                                                                <td>{{(w.end-w.start)/60}}</td>
                                                                <td>{{w.name}}</td>
                                                                <td ng-if="privateLessonTemplet.money_amount != null && privateLessonTemplet.course_amount != null">
                                                                    {{privateLessonTemplet.money_amount / privateLessonTemplet.course_amount | number:2}}
                                                                </td>
                                                                <td ng-if="privateLessonTemplet.money_amount == null || privateLessonTemplet.course_amount == null">暂无数据</td>
                                                                <td>
                                                                    <span ng-if="w.status == 1">待审核</span>
                                                                    <span ng-if="w.status == 2">已取消</span>
                                                                    <span ng-if="w.status == 3">上课中</span>
                                                                    <span ng-if="w.status == 4">已下课</span>
                                                                    <span ng-if="w.status == 5">未下课打卡</span>
                                                                    <span ng-if="w.status == 6">已爽约</span>
                                                                    <span ng-if="w.status == 8">待预约</span>
                                                                    <span ng-if="w.status == 9">预约失败</span>
<!--                                                                    <span ng-if="w.status == 1 && appointmentRecordDate < w.start*1000">待审核 </span>-->
<!--                                                                    <span ng-if="w.status == 1 && appointmentRecordDate > w.end*1000">已过期</span>-->
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <?= $this->render('@app/views/common/nodata.php', ['name' => 'appointmentRecordShow', 'text' => '无约课记录', 'href' => true]); ?>
                                                    </div>
                                                </div>
                                                <div ng-if="iboxCcontentModel == 1" class="ibox-content "
                                                     style="padding: 0;">
                                                    <div id="DataTables_Table_0_wrapper"
                                                         class="dataTables_wrapper form-inline aa26"
                                                         role="grid"
                                                         style="height: 280px;overflow-y: auto;">
                                                        <table
                                                            class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                            id="DataTables_Table_0"
                                                            aria-describedby="DataTables_Table_0_info"
                                                            style="position: relative;">
                                                            <thead>
                                                            <tr role="row">
                                                                <th class="sorting a28" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1">缴费时间
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1"
                                                                    style="width: 80px;">缴费名称
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1"
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
                                                                    rowspan="1"
                                                                    colspan="1"
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
                                                                <td>{{w.category}}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <?= $this->render('@app/views/common/nodata.php', ['name' => 'payNoMoneyCouClassShow', 'text' => '无续费记录', 'href' => true]); ?>
                                                    </div>
                                                </div>
                                                <div ng-if="iboxCcontentModel == 2" class="ibox-content "
                                                     style="padding: 0;">
                                                    <div id="DataTables_Table_0_wrapper"
                                                         class="dataTables_wrapper form-inline aa26"
                                                         role="grid"
                                                         style="height: 280px;overflow-y: auto;">
                                                        <table
                                                            class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                            id="DataTables_Table_0"
                                                            aria-describedby="DataTables_Table_0_info">
                                                            <thead>
                                                            <tr role="row">
                                                                <th class="" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1"
                                                                    style="width: 100px;background-color: #FFF;">选择删除项
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1"
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
                                                                    style="width: 120px;">开课时间
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
                                                                <th rowspan="1" colspan="1" style="width: 140px;background: #fff;">状态</th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0" rowspan="1"
                                                                    colspan="1" aria-label="浏览器：激活排序列升序"
                                                                    style="width: 140px;">操作
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="allchargeBox123">
                                                            <tr ng-repeat='charge in charges'>
                                                                <td>
                                                                    <div
                                                                        class="checkbox i-checks checkbox-inline chargeList123">
                                                                        <label>
                                                                            <input name="selectCourse123"
                                                                                   type="checkbox"
                                                                                   value="{{charge.id}}"></label>
                                                                    </div>
                                                                </td>
                                                                <td data-toggle="modal" data-target="#myModals9">
                                                                    {{charge.product_name | noData:''}}
                                                                </td>
                                                                <td data-toggle="modal" data-target="#myModals9">
                                                                    {{charge.overage_section |
                                                                    noData:''}}/{{charge.course_amount | noData:''}}
                                                                </td>
                                                                <td data-toggle="modal" data-target="#myModals9">
                                                                    <span ng-if="charge.course_type == '1'">PT</span>
                                                                    <span ng-if="charge.course_type == '2'">HS</span>
                                                                    <span ng-if="charge.course_type == '3'">生日课</span>
                                                                    <span ng-if="charge.course_type == '4'">购课赠送</span>
                                                                    <span ng-if="charge.course_type == null && charge.type == '1' ">PT</span>
                                                                    <span ng-if="charge.course_type == null && charge.type == '2' ">HS</span>
                                                                    <span ng-if="charge.course_type == null && charge.type == '3' ">生日课</span>
                                                                    <span ng-if="charge.course_type == null && charge.type == '4'">购课赠送</span>
                                                                    <span ng-if="charge.course_type == null && charge.type == null ">PT</span>
                                                                </td>
                                                                <td data-toggle="modal" data-target="#myModals9">
                                                                    {{charge.create_at *1000 | noData:''|
                                                                    date:'yyyy/MM/dd'}}
                                                                </td>
                                                                <td data-toggle="modal" data-target="#myModals9">
                                                                    {{charge.activeTime *1000 | noData:''|
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
                                                                    {{charge.employeeS.name | noData:''}}
                                                                </td>
                                                                <td ng-if="charge.status == 1">正常</td>
                                                                <td ng-if="charge.status == 2">冻结</td>
                                                                <td class="tdBtn2">
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
                                                <div ng-if="iboxCcontentModel == 3" class="ibox-content "
                                                     style="padding: 0;">
                                                    <div id="DataTables_Table_0_wrapper"
                                                         class="dataTables_wrapper form-inline aa26"
                                                         role="grid"
                                                         style="height: 280px;overflow-y: auto;">
                                                        <table
                                                                class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                                id="DataTables_Table_0"
                                                                aria-describedby="DataTables_Table_0_info">
                                                            <thead>
                                                            <tr role="row">
                                                                <th class="" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1"
                                                                    style="width: 50px;background-color: #FFF;">序号
                                                                </th>
                                                                <th class="" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1"
                                                                    style="width: 110px;background-color: #FFF;">课程
                                                                </th>
                                                                <th class="" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1"
                                                                    style="width: 110px;background-color: #FFF;">到期日期
                                                                </th>
                                                                <th class="" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1"
                                                                    style="width: 110px;background-color: #FFF;">创建日期
                                                                </th>
                                                                <th class="" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1"
                                                                    style="width: 110px;background-color: #FFF;">延期备注
                                                                </th>
                                                                <th class="" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1"
                                                                    colspan="1"
                                                                    style="width: 100px;background-color: #FFF;">操作人
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="allchargeBox123">
                                                            <tr ng-repeat="(item,x) in courseDelayRecordData">
                                                                <td>{{item+1}}</td>
                                                                <td>{{x.course_name}}</td>
                                                                <td>{{x.due_day*1000 | date:"yyyy-MM-dd"}}</td>
                                                                <td>{{x.create_at*1000 | date: "yyyy-MM-dd"}}</td>
                                                                <td>{{x.remark}}</td>
                                                                <td>{{x.name}}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <?= $this->render('@app/views/common/nodata.php', ['name' => 'courseDelayRecordFlag', 'text' => '无延期记录', 'href' => true]); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--跟进维护-->
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
                                                                              placeholder="请输入消息内容"
                                                                              style="resize: none;"></textarea>
                                            </div>
                                            <div class="col-sm-2 pd0">
                                                <button class="btn btn-success pull-right"
                                                        style="margin-top: 6px;height: 40px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;发送&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--会员卡详情-->
                            <div id="tab-15" class="tab-pane">
                                <div class="ibox-content" style="padding: 0;border: none;">
                                    <div class="col-sm-12 pd0">
                                        <div class="col-sm-12 pd0" style="display: flex;align-items: center;">
                                            <div class="col-md-4 col-sm-5" style="border-right: 1px solid #cecece;height: 258px;">
                                                <div  style="padding-top: 10%;width: 30%;float: left">
                                                    <img  ng-if="MemberData.pic != null && MemberData.pic != ''" ng-src="{{MemberData.pic}}" style="width:140px;height: 140px;border-radius: 50%;width: 100%">
                                                    <img  ng-if="MemberData.pic == null || MemberData.pic == ''" ng-src="/plugins/checkCard/img/11.png" style="width: 120px;height: 120px;border-radius: 50%;width: 100%">
                                                </div>
                                                <div style="padding-top: 10%;width: 70%;float: left;padding-left: 20px;">
                                                    <h3>{{MemberData.name |noData:''}}</h3>
                                                    <p style="margin-top: 8px ;margin-bottom:8px;">会员编号：{{MemberData.memberId |noData:''}}</p>
                                                    <p>会员性别：
                                                        <span ng-if="MemberData.sex == 1">男</span>
                                                        <span ng-if="MemberData.sex == 2">女</span>
                                                        <span ng-if="MemberData.sex == '' ||MemberData.sex == null">暂无数据</span>
                                                    </p>
                                                    <p style="margin-top: 8px ;margin-bottom:8px;">手机号码：{{MemberData.mobile |noData:''}}</p>
                                                    <p>证件号码：{{MemberData.id_card |noData:''}}</p>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-7" style="padding-right: 0;padding-left: 30px;">
                                                <div class="col-sm-4" style="position: relative;padding-left: 0;" ng-mouseleave="noneDetails()">
                                                    <img class="cardImg" ng-if="cardInfo.pic == null || cardInfo.pic == ''" ng-src="../plugins/img/card111.png"  style="width:300px;height:190px;width: 100% "ng-mouseover="showDetails()">
                                                    <img class="cardImg img-rounded" ng-if="cardInfo.pic != null && cardInfo.pic != ''" ng-src="{{cardInfo.cardCategory.pic}}"  style="width:300px;height:190px;width: 100%" ng-mouseover="showDetails()">
                                                    <div class="a34" id="showDetails" data-toggle="modal" style="width: 300px;height: 190px;width: 100%;position: absolute;top:0;left:0;text-align: center;line-height: 190px;"
                                                         data-target="#membershipCardDetails"
                                                         ng-click="membershipCardDetails(infoId)">点击查看会员卡详情
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">
                                                    <p class="a35">{{cardInfo.card_name}}
                                                        <span ng-if="!leaveStatus && cardInfo.status == 1" class="cardStatus" style="background:#3CB371;">正常</span>
                                                        <span ng-if="cardInfo.status == 2" class="cardStatus" style="background:#FFA500;">异常</span>
                                                        <span ng-if="leaveStatus" class="cardStatus" style="background:#FFD700;">请假</span>
                                                        <span ng-if="cardInfo.status == 3" class="cardStatus" style="background:#FF4500;">冻结</span>
                                                        <span ng-if="!leaveStatus && cardInfo.status == 4" class="cardStatus" style="background:#DDA0DD;">未激活</span>
                                                        <span ng-if="cardInfo.status == 5" class="cardStatus" style="background:#999999;">挂起</span>
                                                        <span ng-if="cardInfo.status == 6" class="cardStatus" style="background:#999999;">已到期</span>
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
                                                    <p class="a37" ng-if="cardInfo.card_number != null"
                                                       ng-model="clearBina">会员卡号:{{cardInfo.card_number}}</p>
                                                    <p class="a37" ng-if="cardInfo.card_number == null"
                                                       ng-model="clearBina">会员卡号:暂无数据</p>
                                                    <p class="a37" ng-if="cardInfo.amount_money != null"
                                                       ng-model="clearMoney">卡种金额:{{cardInfo.amount_money}}</p>
                                                    <p class="a37" ng-if="cardInfo.amount_money == null"
                                                       ng-model="clearMoney">卡种金额:暂无数据</p>
                                                    <p class="a37" ng-if="cardInfo.create_at != null">
                                                        办卡时间:{{cardInfo.create_at*1000|date:'yyyy-MM-dd'}}</p>
                                                    <p class="a37" ng-if="cardInfo.create_at == null">办卡时间:暂无数据</p>
                                                    <p class="a37" ng-if="cardInfo.active_time != null">
                                                        激活时间:{{cardInfo.active_time*1000|date:'yyyy-MM-dd'}}</p>
                                                    <p class="a37" ng-if="cardInfo.active_time == null">激活时间:暂无数据</p>
                                                    <p class="a38" style="margin-bottom: 10px;"
                                                       ng-if="cardInfo.cardCategory.status != 4 && cardInfo.invalid_time != null"
                                                       ng-model="clearTime">
                                                        到期时间:{{cardInfo.invalid_time*1000|date:'yyyy-MM-dd'}}</p>
                                                    <p class="a38" style="margin-bottom: 10px;"
                                                       ng-if="cardInfo.cardCategory.status == 4 && cardInfo.invalid_time == null"
                                                       ng-model="clearTime">到期时间:此卡未激活</p>
                                                    <p class="a37" style="margin-bottom: 10px;"
                                                       ng-if="cardInfo.cardCategory.status == 4 && cardInfo.invalid_time != null"
                                                       ng-model="clearTime">
                                                        到期时间:{{cardInfo.invalid_time*1000|date:'yyyy-MM-dd'}}</p>
                                                    <p class="a38" ng-if="cardInfo.note != null && cardInfo.note != ''">备注:{{cardInfo.note}}</p>
                                                    <p class="a38" ng-if="cardInfo.note == null || cardInfo.note == ''">备注:暂无数据</p>
                                                </div>

                                                <div class="col-sm-12 pd0" ng-if="cardInfo.orderId == undefined">
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'BINDCARD')) { ?>
                                                    <button class="btn btn-primary a39 mT10"
                                                            ng-disabled=" MemberStatusFlag == '2' || memberStatus == '2' || cardInfo.status == '3' || cardInfo.status == '2'"
                                                            ng-click="bindingUser(cardInfo.id,cardInfo.card_category_id)"
                                                            ng-if="cardInfo.usage_mode == '2' && cardInfo.status != '2'"
                                                    >绑定会员
                                                    </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'CHANGEMEMBERTIME')) { ?>
                                                        <button class="btn btn-info a39 mT10" ng-disabled="  MemberStatusFlag == '2' || memberStatus == '2' || cardInfo.status == '3' || cardInfo.status == '2'" ng-click="changeMemberTime(cardInfo.id)"
                                                                ng-if="cardInfo.usage_mode == '2' && cardInfo.status != '2'">修改时间
                                                        </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'MEMBERCARDUPDATE')) { ?>
                                                        <button class="btn btn-primary a39 mT10"
                                                                ng-disabled="  MemberStatusFlag == '2' || memberStatus == '2' || cardInfo.status == '3' || cardInfo.status == '2'"
                                                                ng-click="updateCardNumber(cardInfo.id,cardInfo.card_number,cardInfo.amount_money,cardInfo.invalid_time,cardInfo.create_at,cardInfo.active_time,cardInfo.card_name,cardInfo.transfer_num,cardInfo.attributes,cardInfo.status,cardInfo.leave_type,cardInfo.card_category_id)"
                                                                ng-if="cardInfo.usage_mode != '2' && cardInfo.pid == null">修改会员卡
                                                        </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'RENEW')) { ?>
                                                        <button class="btn btn-success a39 mT10"
                                                                ng-disabled="memberStatus == '2' || cardInfo.status == 2 || cardInfo.status == 3"
                                                                ng-click="renrewCard(cardInfo.id,cardInfo.card_category_id,cardInfo)"
                                                                ng-if="cardNameNot != ''&& cardNameNot !=undefined && cardNameNot != null && allEndTimesRenewCard > timestamp && cardInfo.status != '2' && allStartTimesRenewCard < timestamp">
                                                            续费
                                                        </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'UPGRADE')) { ?>
                                                        <button class="btn btn-warning a39 mT10"
                                                                ng-disabled="pastDue || memberStatus == '2' || cardInfo.status == '3'"
                                                                ng-click="updateCard(cardInfo.id,cardInfo.card_category_id,cardInfo.create_at,cardInfo)"
                                                                ng-if="cardNameNot != ''&& cardNameNot !=undefined && cardNameNot != null && cardInfo.status != '2' && cardInfo.pid == null">
                                                            升级
                                                        </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'CHANGECARD')) { ?>
                                                        <button class="btn btn-default a39 mT10"
                                                                ng-disabled=" MemberStatusFlag == '2'|| memberStatus == '2' || cardInfo.status == '3'"
                                                                ng-click="zhuanCard(cardInfo.id)"
                                                                data-toggle="modal" data-target="#myModals17"
                                                                ng-if="cardNameNot != ''&& cardNameNot !=undefined && cardNameNot != null && cardInfo.usage_mode != '2' && cardInfo.status != '2' && cardInfo.pid == null">
                                                            转卡
                                                        </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'FREEZECARD')) { ?>
                                                        <button class="btn btn-danger a39 mT10 freezeButton"
                                                                ng-click="freezeMemberCardBtn(cardInfo.id,cardInfo.status)"
                                                                ng-disabled="cardInfo.recent_freeze_reason != '2' || cardInfo.status == '2'">
                                                            冻结
                                                        </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'GIFTDAYSBUTTON')) { ?>
                                                        <button class="btn btn-info a39 mT10"
                                                                ng-disabled="memberStatus == '2' || cardInfo.status != 1"
                                                                ng-click="giftDaysClick(cardInfo.card_category_id)"
                                                                ng-if="cardInfo.status != 2">
                                                            赠送天数
                                                        </button>
                                                    <?php } ?>

                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'MEMBERCARDDELET')) { ?>
                                                        <button class="btn btn-warning a39 mT10" ng-click="memberCardClick(cardInfo.id)">
                                                            删除
                                                        </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'MEMBERCARDTRANSFER')) { ?>
                                                        <button class="btn btn-danger a39 mT10"  data-toggle="modal"
                                                                ng-disabled=" MemberStatusFlag == '2' || memberStatus == '2' || cardInfo.status == '3' || cardInfo.status == '2'"
                                                                ng-click="transferPeople(cardInfo)">
                                                            转移
                                                        </button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'MATCHING')) { ?>
                                                    <button class="btn btn-info a39 mT10" ng-click="memberCardMatch()"
                                                            ng-disabled=" MemberStatusFlag == '2' || memberStatus == '2' || cardInfo.status == '3' || cardInfo.status == '2'"
                                                    >会员卡匹配</button>
                                                    <?php } ?>
                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'UPLOADCONTRACT')) { ?>
                                                    <button class="btn btn-default"  style="margin-top: 10px;" ng-click="uploadContract(cardInfo.member_id,cardInfo.id,1)">
                                                        会员卡合同
                                                    </button>
                                                    <?php } ?>
                                                </div>
                                                <div class="col-sm-12 pd0" ng-if="cardInfo.orderId != undefined">
                                                    <span>此卡已经退费</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 a3 mrt20">
                                            <div class="ibox float-e-margins">
                                                <select class="form-control"
                                                        style="width: 140px;padding-top: 4px;display: inline-block;"
                                                        ng-change="BatchDeletingRenewSelect(bindModel)"
                                                        ng-model="bindModel" ng-init="bindModel='1'">
                                                    <option value="1">续费记录</option>
                                                    <option ng-if="infoBring" value="2">带人卡绑定记录</option>
                                                    <option value="3">变更记录</option>
                                                </select>
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'ADDRENEWRECORD')) { ?>
                                                    <button class="btn btn-info btn-sm" ng-model="moneyList"
                                                            ng-if="bindModel == '1'"
                                                            ng-click="addNewRenewRecordMoneyList()"
                                                            style="float: right;display: inline-block;width: 60px;font-size: 12px;">
                                                        新增
                                                    </button>
                                                <?php } ?>
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DELMONEYLIST')) { ?>
                                                    <button ng-if="bindModel == '1'" class="btn btn-danger btn-sm"
                                                            ng-click="BatchDeletingRenewTheRecord()"
                                                            style="float: right;display: inline-block;">批量删除
                                                    </button>
                                                <?php } ?>
                                                <div ng-if="bindModel == 1" class="ibox-content" style="padding: 0;">
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
                                                                <th class="" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    style="background-color: #FFF;width: 80px;"
                                                                    aria-label="浏览器：激活排序列升序">选择删除项
                                                                </th>
                                                                <th class="sorting a28" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序">缴费时间
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 80px;">激活时间
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
                                                                    style="width: 60px;">会籍顾问
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 90px;">到期日期
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 60px;">行为
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 60px;">备注
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 90px;">操作
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody id="allRenewBox123">
                                                            <tr ng-repeat="info in paymentItems">
                                                                <td>
                                                                    <div
                                                                        class="checkbox i-checks checkbox-inline RenewTheRecordList123">
                                                                        <label>
                                                                            <input name="RenewTheRecord123"
                                                                                   type="checkbox" value="{{info.id}}"></label>
                                                                    </div>
                                                                </td>
                                                                <td ng-if="info.consumption_date == null">暂无数据</td>
                                                                <td ng-if="info.consumption_date != null">{{(info.consumption_date)*1000 |
                                                                    date:"yyyy/MM/dd"}}
                                                                </td>
                                                                <td ng-if="info.activate_date != null">
                                                                    {{info.activate_date*1000 | date:"yyyy/MM/dd"}}
                                                                </td>
                                                                <td ng-if="info.activate_date == null && info.active_time != null">
                                                                    {{info.active_time*1000 | date:"yyyy/MM/dd"}}
                                                                </td>
                                                                <td ng-if="info.activate_date == null && info.active_time == null">
                                                                    暂无数据
                                                                </td>
                                                                <td ng-if="info.payment_name != null && info.payment_name != undefined && info.payment_name != ''">
                                                                    {{info.payment_name}}
                                                                </td>
                                                                <td ng-if="info.payment_name == null || info.payment_name == undefined || info.payment_name == ''">
                                                                    {{info.card_name}}
                                                                </td>
                                                                <td>{{info.consumption_amount}}</td>
                                                                <td>{{info.name}}</td>
                                                                <td>
                                                                    <span
                                                                        ng-if="info.due_date != null && cardInfo.active_time != null">{{info.due_date*1000 | date:"yyyy-MM-dd"}}</span>
                                                                    <!--                                                                    <span ng-if="cardActiveTime != null">{{(info.invalid_time*1000) | date:"yyyy/MM/dd"}}</span>-->
                                                                    <span
                                                                        ng-if="info.due_date == null && cardInfo.active_time == null">暂无数据</span>
                                                                    <span
                                                                        ng-if="cardInfo.active_time == null && info.due_date != null">此卡未激活</span>
                                                                    <span
                                                                        ng-if="cardInfo.active_time != null && info.due_date == null">{{info.invalid_time*1000 | date:"yyyy-MM-dd"}}</span>
                                                                </td>
                                                                <td>{{info.category}}</td>
                                                                <td title="{{info.remarks}}">{{info.remarks | cut:true:15:'...'}}</td>
                                                                <td>
                                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'UPSATEMONEYLIST')) { ?>
                                                                        <button type="button"
                                                                                class="btn btn-sm btn-info"
                                                                                style="width: 60px;"
                                                                                ng-disabled="  MemberStatusFlag == '2' || memberStatus == '2' || cardInfo.status == '3' || cardInfo.status == '2'"
                                                                                ng-click="upsateMoneyList(info.id,info.seller_id,info.consumption_amount,info.activate_date,info.active_time,info.due_date,info.consumption_date,info.category,info.payment_name,info.card_name)">
                                                                            修改
                                                                        </button>
                                                                    <?php } ?>
                                                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DELMONEYLIST')) { ?>
                                                                        <button type="button"
                                                                                class="btn btn-sm btn-warning"
                                                                                style="width: 60px;"
                                                                                ng-click="delMoneyList(info.id)">删除
                                                                        </button>
                                                                    <?php } ?>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <?= $this->render('@app/views/common/nodata.php', ['name' => 'payNoMoneyDataShow', 'text' => '无消费记录', 'href' => true]); ?>
                                                    </div>
                                                </div>
                                                <div ng-if="bindModel == 2" class="ibox-content" style="padding: 0;">
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
                                                                    aria-label="浏览器：激活排序列升序">副卡卡号
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 80px;">状态
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 60px;">绑定会员
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 60px;">手机号
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 160px;">绑定日期
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr ng-repeat="vice in viceCards">
                                                                <td>{{vice.card_number}}
                                                                </td>
                                                                <td>已绑定</td>
                                                                <td>{{vice.member.memberDetails.name}}</td>
                                                                <td ng-if="vice.member.mobile != 0">
                                                                    {{vice.member.mobile}}
                                                                </td>
                                                                <td ng-if="vice.member.mobile == 0 || vice.member.mobile == null || vice.member.mobile == undefined || vice.member.mobile == ''">
                                                                    暂无数据
                                                                </td>
                                                                <td>{{(vice.create_at)*1000 | date:"yyyy/MM/dd"}}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <?= $this->render('@app/views/common/nodata.php', ['name' => 'NoViceCradInfo', 'text' => '无带人绑定记录', 'href' => true]); ?>
                                                    </div>
                                                </div>
                                                <div ng-if="bindModel == 3" class="ibox-content" style="padding: 0;">
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
                                                                    aria-label="浏览器：激活排序列升序">序号
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 120px;">缴费人
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 120px;">缴费时间
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 120px;">到期时间
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 120px;">缴费名称
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 120px;">缴费金额
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 120px;">卡号
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 120px;">会籍顾问
                                                                </th>
                                                                <th class="sorting" tabindex="0"
                                                                    aria-controls="DataTables_Table_0"
                                                                    rowspan="1" colspan="1"
                                                                    aria-label="浏览器：激活排序列升序"
                                                                    style="width: 120px;">行为
                                                                </th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr ng-repeat="(index,re) in changeRecords">
                                                                <td>{{index+1}}</td>
                                                                <td>{{ re.memberName }}</td>
                                                                <td>{{(re.consumption_date)*1000 | date:"yyyy/MM/dd"}}</td>
                                                                <td ng-if="re.due_date || cardInfo.invalid_time">{{ (re.due_date ? re.due_date : cardInfo.invalid_time)*1000 | date:"yyyy/MM/dd" }}</td>
                                                                <td ng-if="!re.due_date && !cardInfo.invalid_time">暂无数据</td>
                                                                <td ng-if="re.payment_name != null && re.payment_name != '' && re.payment_name != undefined">{{re.payment_name}}</td>
                                                                <td ng-if="re.payment_name == null || re.payment_name == '' || re.payment_name == undefined">{{re.card_name}}</td>
                                                                <td>{{re.consumption_amount}}</td>
                                                                <td>{{re.card_number}}</td>
                                                                <td>{{re.employeeName}}</td>
                                                                <td>{{re.category}}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <?= $this->render('@app/views/common/nodata.php', ['name' => 'NoChangeRecords', 'text' => '无变更记录', 'href' => true]); ?>
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