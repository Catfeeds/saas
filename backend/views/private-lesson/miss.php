<?php
use backend\assets\PrivateLessonAsset;

PrivateLessonAsset::register($this);
$this->title = '私课爽约';
?>
<div class="col-sm-12" id="PrivateTimetable" ng-cloak >
    <div class="panel panel-default ">
        <div class="panel-heading">
                <span style="display: inline-block"><span style="display: inline-block" class="spanSmall"><b>私课爽约</b></span>
        </div>
    </div>
    <div class="panel panel-default ">
        <div class="panel-body col-sm-12 panelBody">
            <div class="tab-tb-4 PrivateTimetable2" ng-controller="privateRecordCtrl" ng-cloak>
                <div class="col-sm-12">
                    <div class="col-sm-12" style="margin-top: 10px;">
                        <div class="col-sm-6 col-sm-offset-3">
                            <div class="input-group">
                                <input type="text" class="form-control" ng-model="keyWords" ng-keyup="keyWordsEnter($event)"
                                       placeholder="请输入会员姓名，手机号，会员编号..."  style="height: 34px;">
                                             <span class="input-group-btn">
                                                   <button type="button" class="btn btn-primary" ng-click="keyWordsSearch()">搜索</button>
                                             </span>
                            </div>
                        </div>
                    </div>
                    <div class="ibox float-e-margins">
                        <div class="clearfix clearfix1 row col-sm-12" style="height: auto;padding: 5px 20px;">
                            <div class="col-sm-12 " style="display: flex;margin-top: 10px;justify-content: baseline;flex-wrap: wrap;">
                                <div class=" venueSelect2Miss mR15">
                                    <select class="js-states form-control" ng-change="venueChange(myenue)"
                                            ng-model="myValue" id="missVenueChange">
                                        <option value="" ng-selected>请选择场馆</option>
                                        <option value="{{venue.id}}" ng-repeat="venue in venuesLists">{{venue.name}}</option>
                                    </select>
                                </div>
                                <div class="input-daterange input-group dataInputInput fl cp userTime mR15" id="container" style="width: 300px;">
                                    <div class="input-daterange input-group cp userTimeRecord" id="container" >
                                    <span class="add-on input-group-addon" style="margin-left: 53px">
                                        激活时间
                                        <i class="glyphicon glyphicon-calendar fa fa-calendar userRecodeTimes"></i>
                                    </span>
                                        <input type="text" ng-model="dateTime" readonly name="reservation" id="unAppointmentDate"
                                               class="form-control text-center userSelectTime" value="" placeholder="选择时间"/>
                                    </div>
                                </div>
                                <div class="mR15">
                                    <label for="id_label_single">
                                        <select class=" form-control" ng-model="classListType132" style="padding: 4px 12px;">
                                            <option value="">课种分类</option>
                                            <option value="1">PT</option>
                                            <option value="2">HS</option>
                                            <option value="3">生日课</option>
                                        </select>
                                    </label>
                                </div>
                                <div  class="mR15">
                                    <label >
                                        <select class=" form-control" ng-model="unAppointmentType" style="padding: 4px 12px;">
                                            <option value="">爽约次数排列</option>
                                            <option value="total" >总次数从高到低</option>
                                            <option value="cont" >连续次数从高到低</option>
                                        </select>
                                    </label>
                                </div>
                                <div class="btn btn-sm btn-success w100 mR15" ng-click="searchUnAppointmentSubmit()" >确定</div>
                                <button class="btn btn-sm btn-info w100" ng-click="searchUnAppointmentSubmitClear()">清空</button>
                            </div>
                        </div>
                        <!--                        私教课程管理列表-->
                        <div class="ibox-content  privateCourseManagementList ">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                <div class="row privateCourseManagementListDiv">
                                    <div class="col-sm-6">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter"></div>
                                    </div>
                                </div>
                                <table
                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序" style="width: 150px;background-color: #FFF;"
                                        >序号
                                        </th>
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序" style="width: 150px;background-color: #FFF;"
                                        >会员
                                        </th>
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="浏览器：激活排序列升序" style="width: 150px;background-color: #FFF;"
                                        >性别
                                        </th>
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="平台：激活排序列升序" style="width: 150px;background-color: #FFF;"
                                        >手机号
                                        </th>
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 150px;background-color: #FFF;"
                                        >会员编号
                                        </th>
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 160px;background-color: #FFF;"
                                        >爽约总次数
                                        </th>
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 150px;background-color: #FFF;"
                                        >连续爽约次数
                                        </th>

                                    </tr>
                                    </thead>
                                    <tbody id="tbody">
                                    <tr  ng-click="record(unAppointment.id,unAppointment)" class="gradeA odd" ng-repeat="unAppointment in  unAppointmentLists">
                                        <td>{{8*(unAppointmentNow-1)+$index+1}}
                                        </td>
                                        <td>{{unAppointment.name}}</td>
                                        <td >{{unAppointment.sex =='1'?'男':unAppointment.sex =='2'?'女':'暂无'}}</td>
                                        <td >{{unAppointment.mobile}}</td>
                                        <td>{{unAppointment.id}}</td>
                                        <td>{{unAppointment.total}}</td>
                                        <td>{{unAppointment.total}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?=$this->render('@app/views/common/nodata.php',['name'=>'unAppointmentFlag','text'=>'暂无数据','href'=>true]);?>
                                <?=$this->render('@app/views/common/pagination.php',['page'=>'unAppointmentPages']);?>
                            </div>
                        </div>
                    </div>
                    <!--                        爽约详情-->
                    <div class="modal fade" id="boundCabinet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog wB50" role="document"  style="width: 80%;">
<!--                            <div class="modal-content" style="width: 1000px;margin-left: -100px">-->
                            <div class="modal-content clearfix">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title text-center" id="myModalLabel" >爽约记录</h4>
                                </div>
                                <div class="modal-body row">
                                    <div class="col-sm-12 pd0">
                                        <div class="col-sm-3 iconBox" style="text-align: center">
                                            <!--                                            <img class="imgHeaderW100" ng-src="{{cabinetDetail.memCabinet.member.memberDetails.pic}}" ng-if="cabinetDetail.memCabinet.member.memberDetails.pic != null">-->
                                            <img class="imgHeaderW100" ng-src="/plugins/checkCard/img/11.png" style="width: 100px;height: 100px">
                                            <div class="col-sm-12 pd0 mT10" style="margin-top: 20px">
                                                <b><div class="col-sm-6 text-right pd0" style="padding-right: 0">会员姓名: </div>
                                                <div class="col-sm-6 text-left pd0"  style="padding-left: 0">{{memberDetail.name}}</div></b>
                                            </div>
                                            <div class="col-sm-12 pd0 mT10">
                                                <div class="col-sm-6 text-right pd0" style="padding-right: 0">会员性别: </div>
                                                <div class="col-sm-6 text-left pd0"  style="padding-left: 0">{{memberDetail.sex =='1'?'男':memberDetail.sex =='2'?'女':'暂无'}}</div>
                                            </div>
                                            <div class="col-sm-12 pd0 mT10">
                                                <div class="col-sm-6 text-right pd0" style="padding-right: 0">手机号&nbsp;&nbsp;&nbsp;: </div>
                                                <div class="col-sm-6 text-left pd0"  style="padding-left: 0">{{memberDetail.mobile | noData:''}}</div>
                                            </div>
                                            <div class="col-sm-12 pd0 mT10">
                                                <div class="col-sm-6 text-right pd0" style="padding-right: 0">会员编号: </div>
                                                <div class="col-sm-6 text-left pd0"  style="padding-left: 0">{{memberDetail.id}}</div>
                                            </div>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="" >
                                                <div class="" >
                                                    <div  id="DataTables_Table_0_wrapper" class="pB0 form-inline" role="grid">
                                                        <table class="table table-bordered table-hover dataTables-example dataTable">
                                                            <thead>
                                                            <tr role="row">
                                                                <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 100px;background-color: #FFF;">序号</th>
                                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 240px;background-color: #FFF;">私课</th>
                                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;background-color: #FFF;">类型</th>
                                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;background-color: #FFF;">课程进度</th>
                                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;">上课教练</th>
                                                                <th tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 240px;background-color: #FFF;">时间</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr ng-repeat="memberUnAppointment in memberUnAppointmentLists">
                                                                <td>{{8*(memberUnAppointmentNow-1)+$index+1}}</td>
                                                                <td>{{memberUnAppointment.product_name}}</td>
                                                                <td>
<!--                                                                    {{memberUnAppointment.type == '1'?'PT':memberUnAppointment.type == '2'?'HS':'暂无'}}-->
                                                                    <span ng-if="memberUnAppointment.course_type == '1'">PT</span>
                                                                    <span ng-if="memberUnAppointment.course_type == '2'">HS</span>
                                                                    <span ng-if="memberUnAppointment.course_type == '3'">生日课</span>
                                                                    <span ng-if="memberUnAppointment.course_type == null && memberUnAppointment.type == '1' ">PT</span>
                                                                    <span ng-if="memberUnAppointment.course_type == null && memberUnAppointment.type == '2' ">HS</span>
                                                                    <span ng-if="memberUnAppointment.course_type == null && memberUnAppointment.type == '3' ">生日课</span>
                                                                    <span ng-if="memberUnAppointment.course_type == null && memberUnAppointment.type == null ">PT</span>
                                                                </td>
                                                                <td>{{memberUnAppointment.overage_section}}/{{memberUnAppointment.course_amount}}</td>
                                                                <td>{{memberUnAppointment.name | noData:''}}</td>
                                                                <td>{{memberUnAppointment.start*1000 | date:'yyyy-MM-dd'}}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                        <?=$this->render('@app/views/common/nodata.php',['name'=>'memberUnAppointmentFlag','text'=>'暂无数据','href'=>true]);?>
                                                        <?=$this->render('@app/views/common/pagination.php',['page'=>'memberUnAppointmentPages']);?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <span class="iconName">爽约总次数:<span style="color: rgb(255,203,125)">{{totalNum}}次</span></span>
                                    <span class="iconName">连续爽约次数:<span style="color: rgb(255,203,125)">{{totalNum}}次</span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 私课详情模态框 -->
                    <div class="modal fade" id="privateModal" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content clearfix">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title myModalLabel1" id="myModalLabel">
                                        私课详情
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12 privateModalBody">
                                            <!--                            基本属性-->
                                            <p class="titleP">1.基本属性</p>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-3">产品名称:<span class="contentSpan">{{privateClassDetails.name}}</span>
                                                </div>
                                                <div class="col-sm-3">区间有效期限:<span class="contentSpan">{{privateClassDetails.valid_time}}天</span>
                                                </div>
                                                <div class="col-sm-3">产品激活期限:<span class="contentSpan">{{privateClassDetails.activated_time}}天</span>
                                                </div>
                                                <div class="col-sm-3">售卖总数量:<span class="contentSpan">{{privateClassDetails.sale_num}}</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-6">售卖日期:<span class="contentSpan">{{privateClassDetails.sale_start_time*1000|date:'yyyy-MM-dd'}}至{{privateClassDetails.sale_end_time*1000|date:'yyyy-MM-dd'}}</span>
                                                </div>
                                                <div class="col-sm-6">产品类型:
                                                    <span class="contentSpan" ng-if="privateClassDetails.product_type == 1 || privateClassDetails.product_type =='1'">常规PT</span>
                                                    <span class="contentSpan" ng-if="privateClassDetails.product_type == 2 || privateClassDetails.product_type =='2'">特色课</span>
                                                    <span class="contentSpan" ng-if="privateClassDetails.product_type == 3 || privateClassDetails.product_type =='3'">游泳课</span>
                                                    <span class="contentSpan" ng-if="privateClassDetails.product_type == '' || privateClassDetails.product_type == null || privateClassDetails.product_type == undefined">暂无数据</span>
                                                </div>
                                            </div>
                                            <!--                            课种选择-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">2.课种选择</p>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv"
                                                 style="padding-left: 5px;padding-right: 5px;margin-top: 10px;">
                                                <div class="col-sm-3">课种:<span class="contentSpan">{{privateClassDetails.cname}}</span>
                                                </div>
                                                <div class="col-sm-3">课程时长:<span class="contentSpan">{{privateClassDetails.coursePackageDetail[0].course_length}}分钟</span>
                                                </div>
                                                <div class="col-sm-3">单节原价:<span class="contentSpan">{{privateClassDetails.coursePackageDetail[0].original_price}}</span>
                                                </div>
                                            </div>
                                            <!--                            产品价格-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">3.产品价格</p>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv"  ng-repeat="xx in privateClassDetailsListMoney">
                                                <div class="col-sm-3">课程区间节数:<span class="contentSpan">{{xx.intervalStart}}-{{xx.intervalEnd}}节</span>
                                                </div>
                                                <div class="col-sm-3">优惠单价:<span class="contentSpan">{{xx.unitPrice}}元</span>
                                                </div>
                                                <div class="col-sm-3">总POS价:<span class="contentSpan">{{xx.posPrice}}元</span>
                                                </div>
                                            </div>
                                            <!--                            售卖场馆-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">4.售卖场馆</p>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-3">售卖场馆:<span class="contentSpan">{{privateClassDetails.oname}}/{{privateClassDetails.sale_num}}张</span>
                                                </div>
                                            </div>
                                            <!--                            预约设置-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">5.预约设置</p>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-3"><span class="contentSpan">开课前60分钟不可预约</span></div>
                                                <div class="col-sm-3"><span class="contentSpan">开课前60分钟不可取消</span></div>
                                                <div class="col-sm-3"><span class="contentSpan">可预约7天内的课</span></div>
                                            </div>
                                            <!--                            课程详情-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">6.课程详情</p>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-8">课程介绍:<span class="contentSpan">{{privateClassDetails.describe}}</span>
                                                </div>
                                            </div>
                                            <!--                            图片上传-->
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-8">照片:<span class="contentSpan">
                                        <div class="form-group" style="margin-left: 120px">
                                            <img ng-src="{{privateClassDetails.pic}}" width="150px" height="150px"
                                                 ng-if="privateClassDetails.pic != ''">
                                        </div>
                                    </span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"
                                            style="width: 100px">关闭
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 私课服务详情模态框 -->
                    <div class="modal fade" id="privateServiceModal" tabindex="-1" role="dialog"
                         aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document" style="width: 80%;">
                            <div class="modal-content clearfix">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel"
                                        style="text-align: center;font-size: 18px;">
                                        私课服务详情
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12" style="padding-left: 140px;padding-right: 100px;">
                                            <!--                            基本属性-->
                                            <p class="titleP">1.基本属性</p>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-3">产品名称:<span class="contentSpan">{{privateClassDetails.name}}</span>
                                                </div>
                                                <div class="col-sm-3">区间有效期限:<span class="contentSpan">{{privateClassDetails.valid_time}}天</span>
                                                </div>
                                                <div class="col-sm-3">产品激活期限:<span class="contentSpan">{{privateClassDetails.activated_time}}天</span>
                                                </div>
                                                <div class="col-sm-3">售卖总数量:<span class="contentSpan">{{privateClassDetails.sale_num}}</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-3">售卖日期:<span class="contentSpan">{{privateClassDetails.sale_start_time*1000|date:'yyyy-MM-dd'}}至{{privateClassDetails.sale_end_time*1000|date:'yyyy-MM-dd'}}</span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <span class="contentSpan" ng-if="privateClassDetails.product_type == 1 || privateClassDetails.product_type =='1'">常规PT</span>
                                                    <span class="contentSpan" ng-if="privateClassDetails.product_type == 2 || privateClassDetails.product_type =='2'">特色课</span>
                                                    <span class="contentSpan" ng-if="privateClassDetails.product_type == 3 || privateClassDetails.product_type =='3'">游泳课</span>
                                                    <span class="contentSpan" ng-if="privateClassDetails.product_type == '' || privateClassDetails.product_type == null || privateClassDetails.product_type == undefined">暂无数据</span>
                                                </div>
                                            </div>
                                            <!--                            课种选择-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">2.课种选择</p>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-3">课种:<span class="contentSpan">{{privateClassDetails.cname}}</span>
                                                </div>
                                                <div class="col-sm-3">课程时长:<span class="contentSpan">{{privateClassDetails.coursePackageDetail[0].course_length}}分钟</span>
                                                </div>
                                                <div class="col-sm-3">课程节数:<span class="contentSpan">{{privateClassDetails.coursePackageDetail[0].course_num}}节</span>
                                                </div>
                                                <div class="col-sm-3">单节原价:<span class="contentSpan">{{privateClassDetails.coursePackageDetail[0].original_price}}</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-3">总原价:<span class="contentSpan">{{privateClassDetails.coursePackageDetail[0].sale_price}}</span>
                                                </div>
                                            </div>
                                            <!--                            产品价格-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">3.产品价格</p>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-3">总售价:<span class="contentSpan">{{privateClassDetails.total_amount}}</span>
                                                </div>
                                                <div class="col-sm-3">总POS价:<span class="contentSpan">{{privateClassDetails.total_pos_price}}</span>
                                                </div>
                                            </div>
                                            <!--                            售卖场馆-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">4.售卖场馆</p>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-3">售卖场馆:<span class="contentSpan">{{privateClassDetails.oname}}/{{privateClassDetails.sale_num}}张</span>
                                                </div>
                                            </div>
                                            <!--                            预约设置-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">5.预约设置</p>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-3"><span class="contentSpan">开课前60分钟不可预约</span></div>
                                                <div class="col-sm-3"><span class="contentSpan">开课前60分钟不可取消</span></div>
                                                <div class="col-sm-3"><span class="contentSpan">可预约7天内的课</span></div>
                                            </div>
                                            <!--                            课程详情-->
                                            <div class="col-sm-12 pd0 mT20">
                                                <p class="titleP">6.课程详情</p>
                                            </div>
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-8">课程介绍:<span class="contentSpan">{{privateClassDetails.describe}}</span>
                                                </div>
                                            </div>
                                            <!--                            图片上传-->
                                            <div class="col-sm-12 privateModalBodyDiv">
                                                <div class="col-sm-8">照片:<span class="contentSpan">
                                        <div class="form-group" style="margin-left: 120px">
                                            <img ng-src="{{privateClassDetails.pic}}" width="150px" height="150px"
                                                 ng-if="privateClassDetails.pic!=''">
                                        </div>
                                    </span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"
                                            style="width: 100px">关闭
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
