<?php
use backend\assets\DataImportAsset;
DataImportAsset::register($this);
$this->title = '数据导入';
?>
<div ng-controller='dataImportCtrl' ng-cloak>
    <div class="panel panel-default ">
        <div class="panel-body">
            <div class="col-sm-12 col-xs-12">
                <div class="row">
                    <p ng-click="thing()"><span  style="color: #a5dc86">注意事项：(*^▽^*)</span></p>
                   <div ng-if="isThing">
                       <p>1.0 导入数据之前，下载EXCEl数据模板;</p>
                       <p>2.0 表头带星号的，为必填项;</p>
                       <p>3.0 按照表头的数据样式，填写数据：例如，员工状态为：在职/离职（这类选项很多，看表头提供的选项，就可以了！不一一列举了）</p>
                       <p>4.0 导入数据之前，需要在系统进行基本的数据添加：例如，员工数据导入之前，需要设置公司基本组织框架，公司职务等信息。</p>
                       <p>5.0 同步数据之前，请先校对数据的正确性！数据导入请按照以下顺序，否则会降低数据校验的准确率</p>
                       <p>6.0 导入、数据同步：导入数据之前请先设置基本信息！然后导入员工-->会员-->会员卡-->订单......</p>
                       <p>7.0 数据校验：主要校验手机号、身份证等信息格式的正确性;公司，场馆，员工，会员卡等数据的正确性和不可缺失性;</p>
                   </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default ">
        <div class="panel-body">
            <div class="col-sm-12 col-xs-12">
                <div class="row">
                    <div class="col-sm-7 col-xs-9" >
                        <label for="id_label_single" style="white-space: nowrap;vertical-align: top;">
                            <span>数据内容</span>
                            <select ng-model="contentId" ng-change="getDataContent(contentId)"
                                    class="form-control disB seMix"
                                    id="id_label_single">
                                <option value="1">员工数据导入</option>
                                <option value="2">会员数据导入</option>
                                <option value="3">会员卡数据导入</option>
                                <option value="4">课程订单数据导入</option>
                                <option value="5">柜子数据导入</option>
                                <option value="6">会员请假数据导入</option>
                                <option value="7">私教课程上课数据导入</option>
                                <option value="8">会员卡行为数据导入</option>
                            </select>
                        </label>
                        <ul class="disB" style="padding: 0;">
                            <li class="new_add" id="tmk">
                                <span class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal" ng-click="dataImport()" >导入</span>
                            </li>
                        </ul>
                    </div>

                    <div class="col-sm-5 col-xs-3 text-right">
                        <ul>
                            <li class="new_add disB" id="tmk">
                                <span class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" ng-click="dataModify()" >数据校验</span>
                            </li>
                            <li class="new_add disB" id="tmk">
                                <span class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" ng-click="professionModify()" >业务校验</span>
                            </li>
                            <li class="new_add disB" id="tmk">
                                <span class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal" ng-click="dataDock()" >确认同步</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="panel panel-default ">
        <div class="panel-body">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-7 text-center">
                        <input type="text" ng-model="className" id="inputSearch" class="form-control disB input-group" style="width: 50%;vertical-align: top;" ng-keydown="enterSearch()" placeholder="请输入数据内容进行搜索">
                        <span class="input-group-btn" style="display: inline-block;left: -3px;">
                            <button type="button" class="btn btn-sm btn-success" ng-click="searchClass()">搜索</button>
                        </span>
                    </div>
                    <div class="col-sm-3">
                        <label for="id_label_single" style="white-space: nowrap;vertical-align: top;">
                            <select ng-model="selectStatus"
                                    class="form-control seMix disB"
                                    id="id_label_single">
                                <option value="">选择状态</option>
                                <option value="1">正常</option>
                                <option value="2">异常</option>
                            </select>
                        </label>
                        <ul class="disB" style="padding: 0;">
                            <li class="new_add" id="tmk">
                                <span class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal" ng-click="chooseStatus()" >筛选</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-2 col-xs-2 text-right">
                        <li class="nav_add">
                            <ul>
                                <li class="new_add" id="tmk">
                                    <span class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal" ng-click="dataClear()" >清除数据</span>
                                </li>
                            </ul>
                        </li>
                    </div>
                </div>
            </div>


            <div class="col-sm-12">
                <div class="row">
                    <table
                        class="table table-striped table-bordered table-hover dataTables-example dataTable"
                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <tr role="row">
                            <th ng-repeat="item in tableHead" ng-if="item.requier"  ng-bind-html="item.name|to_trusted"></th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
<!--                     员工-->
                        <tr ng-class="{'red': item.check_status == '2'}" ng-if="typeChange == '1'" class="gradeA odd" ng-repeat="item in importData">
                            <td>{{item.name}}</td>
                            <td>{{item.sex}}</td>
                            <td>{{item.mobile}}</td>
<!--                            <td>{{item.email}}</td>-->
                            <td>{{item.id_card}}</td>
<!--                            <td>{{item.birth_time}}</td>-->
                            <td>{{item.company}}</td>
                            <td>{{item.venue|noData:''}}</td>
                            <td>{{item.department|noData:''}}</td>
<!--                            <td>{{item.position}}</td>-->
                            <td>{{item.status}}</td>
                            <td>{{item.entry_date}}</td>
                            <td>{{item.leave_date|noData:''}}</td>
                            <td>{{item.salary}}</td>
<!--                            <td>{{item.intro}}</td>-->
                            <td>{{item.work_date}}</td>
<!--                            <td>{{item.check_status}}</td>-->
<!--                            <td>{{item.created_at}}</td>-->
<!--                            <td>{{item.is_delete}}</td>-->
                            <td>{{item.check_status == '1' ? '正常' : '异常'}}</td>
                            <td ng-class="{'white': item.check_status == '2'}">
                                <button class="btn btn-sm btn-success" ng-click="dataDetial(tableHead, item)">详情</button>
                                <button class="btn btn-sm btn-warning" ng-click="dataUpdate(tableHead, item)">修改</button>
                                <button class="btn btn-sm btn-danger" ng-click="dataDel(tableHead, item)">删除</button>
                            </td>
                        </tr>
<!--                        会员-->
                        <tr ng-class="{'red': item.check_status == '2'}" ng-if="typeChange == '2'" class="gradeA odd" ng-repeat="item in importData">
                            <td>{{item.username}}</td>
                            <td>{{item.mobile}}</td>
<!--                            <td>{{item.first_in_time}}</td>-->
                            <td>{{item.company}}</td>
                            <td>{{item.venue}}</td>
                            <td>{{item.id_card}}</td>
<!--                            <td>{{item.mobile}}</td>-->
<!--                            <td>{{item.mobile}}</td>-->
<!--                            <td>{{item.mobile}}</td>-->
<!--                            <td>{{item.mobile}}</td>-->
                            <td>{{item.card_type}}</td>
<!--                            <td>{{item.mobile}}</td>-->
                            <td>{{item.sex}}</td>
                            <td>{{item.check_status == '1' ? '正常' : '异常'}}</td>
                            <td ng-class="{'white': item.check_status == '2'}">
                                <button class="btn btn-sm btn-success" ng-click="dataDetial(tableHead, item)">详情</button>
                                <button class="btn btn-sm btn-warning" ng-click="dataUpdate(tableHead, item)">修改</button>
                                <button class="btn btn-sm btn-danger" ng-click="dataDel(tableHead, item)">删除</button>
                            </td>
                        </tr>
<!--                        会员卡-->
                        <tr ng-class="{'red': item.check_status == '2'}" ng-if="typeChange == '3'" class="gradeA odd" ng-repeat="item in importData">
                            <td>{{item.username}}</td>
                            <td>{{item.mobile}}</td>
                            <td>{{item.sex}}</td>
                            <td>{{item.company}}</td>
                            <td>{{item.venue}}</td>
                            <td>{{item.card_number}}</td>
                            <td>{{item.open_card_time}}</td>
                            <td>{{item.money}}</td>
                            <td>{{item.status}}</td>
                            <td>{{item.active_date}}</td>
                            <td>{{item.failure_date}}</td>
                            <td>{{item.counselor_name}}</td>
                            <td>{{item.card_name}}</td>
                            <td>{{item.card_attributes}}</td>
                            <td>{{item.deal_name}}</td>
                            <td>{{item.behavior}}</td>
                            <td>{{item.check_status == '1' ? '正常' : '异常'}}</td>
                            <td ng-class="{'white': item.check_status == '2'}">
                                <button class="btn btn-sm btn-success" ng-click="dataDetial(tableHead, item)">详情</button>
                                <button class="btn btn-sm btn-warning" ng-click="dataUpdate(tableHead, item)">修改</button>
                                <button class="btn btn-sm btn-danger" ng-click="dataDel(tableHead, item)">删除</button>
                            </td>
                        </tr>
<!--                        课程订单-->
                        <tr ng-class="{'red': item.check_status == '2'}" ng-if="typeChange == '4'" class="gradeA odd" ng-repeat="item in importData">
                            <td>{{item.course_nums}}</td>
                            <td>{{item.order_time}}</td>
                            <td>{{item.total_money}}</td>
                            <td>{{item.reamain_nums}}</td>
                            <td>{{item.over_time}}</td>
                            <td>{{item.course_name}}</td>
                            <td>{{item.bill_type}}</td>
                            <td>{{item.course_type}}</td>
<!--                            <td>{{item.class_type}}</td>-->
                            <td>{{item.coach_name}}</td>
<!--                            <td>{{item.class_share}}</td>-->
<!--                            <td>{{item.send_nums}}</td>-->
                            <td>{{item.card_number}}</td>
                            <td>{{item.product_name}}</td>
<!--                            <td>{{item.casd_type}}</td>-->
                            <td>{{item.casd_number}}</td>
                            <td>{{item.counselor_name}}</td>
<!--                            <td>{{item.start_time}}</td>-->
<!--                            <td>{{item.payee_name}}</td>-->
<!--                            <td>{{item.order_status}}</td>-->
<!--                            <td>{{item.note}}</td>-->
<!--                            <td>{{item.check_status}}</td>-->
<!--                            <td>{{item.limit_days}}</td>-->
                            <td>{{item.single_original_price}}</td>
<!--                            <td>{{item.single_sell_price}}</td>-->
<!--                            <td>{{item.single_pos_price}}</td>-->
                            <td>{{item.single_long}}</td>
<!--                            <td>{{item.transfer_limit}}</td>-->
<!--                            <td>{{item.transfer_money}}</td>-->
                            <td>{{item.deal_name}}</td>
                            <td>{{item.check_status == '1' ? '正常' : '异常'}}</td>
                            <td ng-class="{'white': item.check_status == '2'}">
                                <button class="btn btn-sm btn-success" ng-click="dataDetial(tableHead, item)">详情</button>
                                <button class="btn btn-sm btn-warning" ng-click="dataUpdate(tableHead, item)">修改</button>
                                <button class="btn btn-sm btn-danger" ng-click="dataDel(tableHead, item)">删除</button>
                            </td>
                        </tr>
<!--                        私教课程-->
                        <tr ng-class="{'red': item.check_status == '2'}" ng-if="typeChange == '5'" class="gradeA odd" ng-repeat="item in importData">
                            <td>{{item.cabinet_name}}</td>
                            <td>{{item.cabinet_number}}</td>
                            <td>{{item.status}}</td>
                            <td>{{item.start_time}}</td>
                            <td>{{item.end_time}}</td>
                            <td>{{item.consume_time}}</td>
                            <td>{{item.price}}</td>
                            <td>{{item.counselor_name}}</td>
                            <td>{{item.cabinet_type}}</td>
                            <td>{{item.company}}</td>
                            <td>{{item.venue}}</td>
                            <td>{{item.check_status == '1' ? '正常' : '异常'}}</td>
                            <td ng-class="{'white': item.check_status == '2'}">
                                <button class="btn btn-sm btn-success" ng-click="dataDetial(tableHead, item)">详情</button>
                                <button class="btn btn-sm btn-warning" ng-click="dataUpdate(tableHead, item)">修改</button>
                                <button class="btn btn-sm btn-danger" ng-click="dataDel(tableHead, item)">删除</button>
                            </td>
                        </tr>
<!--                        请假-->
                        <tr ng-class="{'red': item.check_status == '2'}" ng-if="typeChange == '6'" class="gradeA odd" ng-repeat="item in importData">
                            <td>{{item.card_name}}</td>
                            <td>{{item.card_number}}</td>
                            <td>{{item.check_time}}</td>
                            <td>{{item.start_time}}</td>
                            <td>{{item.end_time}}</td>
<!--                            <td>{{item.leave_length}}</td>-->
<!--                            <td>{{item.note}}</td>-->
                            <td>{{item.leave_property}}</td>
                            <td>{{item.oper_name}}</td>
                            <td>{{item.status}}</td>
                            <td>{{item.check_status == '1' ? '正常' : '异常'}}</td>
<!--                            <td>{{item.created_at}}</td>-->
<!--                            <td>{{item.check_status}}</td>-->
                            <td ng-class="{'white': item.check_status == '2'}">
                                <button class="btn btn-sm btn-success" ng-click="dataDetial(tableHead, item)">详情</button>
                                <button class="btn btn-sm btn-warning" ng-click="dataUpdate(tableHead, item)">修改</button>
                                <button class="btn btn-sm btn-danger" ng-click="dataDel(tableHead, item)">删除</button>
                            </td>
</tr>
<!--                        私教上课记录-->
                        <tr ng-class="{'red': item.check_status == '2'}" ng-if="typeChange == '7'" class="gradeA odd" ng-repeat="item in importData">
                            <td>{{item.username}}</td>
                            <td>{{item.card_number}}</td>
<!--                            <td>{{item.class_name}}</td>-->
                            <td>{{item.coach_name}}</td>
                            <td>{{item.time_long}}</td>
                            <td>{{item.reserver_date}}</td>
                            <td>{{item.start_date}}</td>
                            <td>{{item.end_date}}</td>
<!--                            <td>{{item.status}}</td>-->
<!--                            <td>{{item.class_type}}</td>-->

                            <td>{{item.check_status == '1' ? '正常' : '异常'}}</td>
                            <td ng-class="{'white': item.check_status == '2'}">
                                <button class="btn btn-sm btn-success" ng-click="dataDetial(tableHead, item)">详情</button>
                                <button class="btn btn-sm btn-warning" ng-click="dataUpdate(tableHead, item)">修改</button>
                                <button class="btn btn-sm btn-danger" ng-click="dataDel(tableHead, item)">删除</button>
                            </td>
                        </tr>
<!--                        会员行为记录-->
                        <tr ng-class="{'red': item.check_status == '2'}" ng-if="typeChange == '8'" class="gradeA odd" ng-repeat="item in importData">
                            <td>{{item.old_card_number}}</td>
                            <td>{{item.behavior}}</td>
                            <td>{{item.new_card_number}}</td>
                            <td>{{item.behavior_money}}</td>
                            <td>{{item.consume_date}}</td>
                            <td>{{item.casd_number}}</td>
                            <td>{{item.counselor_name}}</td>
<!--                            <td>{{item.note}}</td>-->
                            <td>{{item.check_status == '1' ? '正常' : '异常'}}</td>
                            <td ng-class="{'white': item.check_status == '2'}">
                                <button class="btn btn-sm btn-success" ng-click="dataDetial(tableHead, item)">详情</button>
                                <button class="btn btn-sm btn-warning" ng-click="dataUpdate(tableHead, item)">修改</button>
                                <button class="btn btn-sm btn-danger" ng-click="dataDel(tableHead, item)">删除</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?= $this->render('@app/views/common/pagination.php', ['page' => 'importPage']); ?>
                    <?= $this->render('@app/views/common/nodata.php',['name'=>'importNoData','text'=>'暂无数据','href'=>true]); ?>
                </div>
            </div>
        </div>
    </div>
    <!--导入-->
    <div class="modal fade" id="dataImportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 600px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h3 class="text-center colorGreen" id="myModalLabel" >数据导入</h3>
                </div>
                <div class="modal-body" style="padding: 20px 0px 20px 100px">
                    <div class="form-group">
                        <div class="disB">1、模板下载：</div>
                        <div class="disB" >
                            <span class="disSpan">
                                <a href="/data-import/file-down">点击模板下载</a>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="margin-bottom: 15px">注意事项：</div>
                        <div style="padding-left: 20px;">1、模板中表头不可更改、不可删除</div>
                    </div>
                    <div class="form-group" style="padding-left: 20px;">
                        <div class="disB">2、除必填项外，其他列可以不填，但不能删除</div>
                    </div>
                    <div class="form-group" style="padding-left: 20px;">
                        <div class="disB">3、单次导入数据不超过5000条</div>
                    </div>
                    <div class="form-group">
                        <div style="margin-bottom: 10px;">2、数据重复时的处理方式：</div>
                        <label for="id_label_single">
                            <select ng-model="importType"
                                    class="form-control seMix"
                                    id="id_label_single">
                                <option value="">选择方式</option>
                                <option value="1">导入</option>
                                <option value="2">不导入</option>
                            </select>
                        </label>
                    </div>
                    <div class="form-group">
                        <div style="margin-bottom: 10px;">3、选择需要导入文件</div>
                        <label for="id_label_single">
                            <input type="file" id="file" onchange='angular.element(this).scope().fileChanged(this)'>
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button style="float: left" type="button" class="btn btn-sm btn-success" ng-click="importHistory()">导入历史记录</button>
                    <button type="button" class="btn btn-sm btn-success" ng-click="startImport()">开始导入</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
    <!--数据修改-->
    <div class="modal fade" id="dataUpdateModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 500px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h3 class="text-center colorGreen" id="myModalLabel" >数据修改</h3>
                </div>
                <div class="modal-body text-center">
                    <div class="row">
                        <div class="form-group" ng-repeat="(index, item) in detialTitle"  on-finish-render-filters>
                            <div ng-if="item.key != 'check_status'" class="col-sm-4 text-right" style="margin-bottom: 10px">
                                <span ng-bind-html="item.name|to_trusted"></span>
                            </div>
                            <div ng-if="item.key != 'check_status'" class="col-sm-8 disB text-left" style="margin-bottom: 10px">
                                <input ng-if="!item.isDate && !item.textArea" type="text" class="form-control" ng-model="detialData[item.key]">
                                <div ng-if="item.isDate &&  !item.textArea" class="text-center date dateBox" id="{{item.isDate}}" data-date-format="yyyy-mm-dd" style="position: relative;">
                                    <input type="text" class="form-control actions" placeholder="请输入从业时间" ng-model="detialData[item.key]">
                                    <span class="add-on"><i class="icon-th"></i></span>
                                </div>
                                <textarea ng-if="item.textArea" config="summernoteConfigs" style="resize: none;" summernote class="summernote" required ng-model="detialData[item.key]">
                                </textarea>
<!--                                <select ng-model="companyId"-->
<!--                                        class="form-control seMix disB"-->
<!--                                        id="id_label_single">-->
<!--                                    <option value="">选择公司</option>-->
<!--                                    <option value="item.id" ng-repeat="item in optionCompany">{{item.name}}</option>-->
<!--                                </select>-->
<!--                                <select ng-model="venueId"-->
<!--                                        class="form-control seMix disB"-->
<!--                                        id="id_label_single">-->
<!--                                    <option value="">选择场馆</option>-->
<!--                                    <option value="1">正常</option>-->
<!--                                    <option value="2">异常</option>-->
<!--                                </select>-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-success" ng-click="sureUpdate(detialData)">确认修改</button>
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
                </div>
            </div>
        </div>
    </div>
    <!--详情-->
    <div class="modal fade" id="dataDetialModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 800px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h3 class="text-center colorGreen" id="myModalLabel" >
                        数据内容详情
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div style="width: 45%;margin: 0 auto;padding-left: 55px;" ng-repeat="(index, item) in detialTitle">
                                <p ng-if="item.key != 'check_status'"><span ng-bind-html="item.name | to_trusted"></span>：{{detialData[item.key] ? detialData[item.key] : '暂无数据'}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-success" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
    <!--导入历史记录-->
    <div class="modal fade" id="dataHistoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 500px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h3 class="text-center colorGreen" id="myModalLabel" >
                        导入历史记录
                    </h3>
                </div>
                <div class="modal-body" style="max-height: 300px;overflow-y: auto;overflow-x: hidden">
                    <div class="row">
                        <div class="col-sm-12" style="margin-left: 35px;">
                            <div>
                                <div ng-repeat="(index, item) in importHistoryData">
                                    <p title="{{item.username}}于{{item.created_at}}导入{{item.filename}}" style="white-space: nowrap"><strong>{{item.username}}</strong> 于 <strong>{{item.created_at}}</strong> 导入 <strong>{{item.filename}}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-success" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
</div>