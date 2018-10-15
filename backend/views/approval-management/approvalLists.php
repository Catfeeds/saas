<!--页面列表重用-->
<!--筛选共用-->
<div class="row">
    <div class="col-sm-12 col-xs-12 mT20">
        <div class=" col-md-offset-2 col-sm-8 col-xs-8 col-md-8" style="display: flex;justify-content: center;">
            <div class="input-group" style="width: 55%;">
                <input type="text" class="form-control userHeaders" ng-model="stayApprovalKeywords" ng-keyup="stayApprovalSearch($event)" placeholder=" 请输入卡名称进行搜索...">
                <span class="input-group-btn">
                    <button type="button" ng-click="initPathSearch()" class="btn btn-primary btn-sm">搜索</button>
                </span>
            </div>
        </div>
        <div class="col-sm-4 col-xs-4 col-md-2 text-center">
            <button type="button" class="btn btn-success btn-sm" ng-click="setApprovalButton()">设置审批流程</button>
        </div>
    </div>
    <div class="col-sm-12  col-xs-12" style="display: flex;justify-content: center;">
        <div class="pdR10 mR10 mT10 selectVenueHomeCss" style="width: 130px;">
            <select id="allVenues" class=" form-control selectPd"   style="width: 100%;"  ng-model="homePageWarehouseVenue">
                <option value="">请选择场馆</option>
                <option title="{{venue.name}}" value="{{venue.id}}" ng-repeat="venue in allVenueLists">{{venue.name | cut:true:6:'...'}}</option>
            </select>
        </div>
        <div class="pdR10 mR10 mT10" style="width: 286px;">
            <div class="input-daterange input-group cp userTimeRecord col-sm-4">
                <span class="add-on input-group-addon">选择日期</span>
                <input type="text" readonly  name="reservation" id="storeDate" class="form-control text-center  " placeholder="选择日期" style="width: 195px;"/>
            </div>
        </div>
        <div class="pdR10 mR10 mT10"style="min-width: 100px;">
            <select class=" form-control selectPd" ng-model="approvalType">
                <option value="">审批类型</option>
                <option value="新增会员卡">新增会员卡</option>
                <option value="移动端会员卡折扣价">移动端会员卡折扣价</option>
<!--                <option ng-repeat="type in itemTypes" value="{{type.id}}">{{type.type}}</option>-->
            </select>
        </div>
        <div ng-if="approvalHomepage123 != 1" class="pdR10 mR10 mT10"style="min-width: 100px;">
            <select id="approvalStatusId" class=" form-control selectPd" ng-model="approvalStatus">
                <option value="">状态</option>
                <option value="1">审批中</option>
                <option value="2">已完成</option>
                <option value="3">已拒绝</option>
                <option value="4">已撤销</option>
            </select>
        </div>
        <div class=" mT10 mR10">
            <button class="btn btn-success btn-sm " ng-click="approvalKeywordsSearch()">确定</button>
        </div>
        <div class=" mT10 ">
            <button class="btn btn-info btn-sm " ng-click="ClearApprovalSearchSelect()">清空</button>
        </div>
    </div>
</div>
<div class="row mT20">
    <div class="col-sm-12 ">
        <div class="ibox float-e-margins">
            <div class="ibox-content" style="padding: 0">
                <div style="padding-bottom: 0;" id="DataTables_Table_0_wrapper"
                     class="dataTables_wrapper form-inline" role="grid">
                    <table
                        class="table table-striped table-bordered table-hover dataTables-example dataTable"
                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <tr role="row">
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="浏览器：激活排序列升序"
                                style="width: 100px;background-color: #FFF;">序号
                            </th>
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="浏览器：激活排序列升序"
                                style="width: 200px;background-color: #FFF;">审批类型
                            </th>
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" style="width: 180px;background-color: #FFF;" >操作人
                            </th>
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="浏览器：激活排序列升序"
                                style="width: 240px;background-color: #FFF;">审批摘要
                            </th>
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" style="width: 140px;background-color: #FFF;">发起时间
                            </th>
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width:120px;background-color: #FFF;">
                                状态
                            </th>
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1"  style="width: 120px;background-color: #FFF;">审批进度
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="cp" ng-repeat="item in items"  ng-click="approvalDetailClick(item)">
<!--                        <tr ng-if="原来的显示会员卡还是原来的格式" class="cp" ng-repeat="item in items"  ng-click="approvalDetailClick(item)">-->
                            <td>{{8*(homePageNow - 1) +$index +1}}</td>
                            <td>{{item.type}}</td>
                            <td>{{item.eName}}</td>
                            <td>{{item.name}}</td>
                            <td>
                                {{(item.create_at*1000) | date:'yyyy-MM-dd'}}
                            </td>
                            <td>
                                <span class="label label-info" ng-if="item.status == 1">审核中</span>
                                <span class="label label-success" ng-if="item.status == 2">已完成</span>
                                <span class="label label-danger" ng-if="item.status == 3">已拒绝</span>
                                <span class="label label-default" ng-if="item.status == 4">已撤销</span>
                            </td>
                            <td>{{item.progress}}/{{item.total_progress}}</td>
                        </tr>
 <!--                       <tr class="cp" data-target="#approvalPhoneDiscountsModal" data-toggle="modal">-->
<!--                        <tr ng-if="如果是移动端折扣数据，显示这种格式" class="cp" ng-repeat="item in items"  data-target="#" data->-->
                           <!-- <td></td>
                            <td>移动端会员卡折扣价</td>
                            <td>操作人</td>
                            <td>
                                <span>场馆：</span><span>我爱运动大上海馆</span>
                                <span>折扣：</span><span>9.0折</span>
                                <span>折扣售卖期限：</span><span>2018-01-01到2018-01-29</span>
                            </td>
                            <td>发起时间</td>
                            <td>
                                <span class="label label-info">审核中</span>
                                <span class="label label-success">已完成</span>
                                <span class="label label-danger">已拒绝</span>
                                <span class="label label-default">已撤销</span>
                            </td>
                            <td>1/4</td>
                        </tr>-->
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/nodata.php',['href'=>true]);?>
                    <?=$this->render('@app/views/common/pagination.php');?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 折扣详情模态框 -->
<div class="modal fade" id="discountsDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="z-index: 3000!important;">
    <div class="modal-dialog" role="document" style="z-index: 1300!important;top:10%">
        <div class="modal-content clearfix">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">移动端折扣详情</h4>
            </div>
            <div class="modal-body">
                <h2>{{noDiscountVenueName}}</h2>
                <p class="MT20">折扣：{{noDiscountDiscount}}折</p>
                <p class="MT20">折扣售卖期限：{{noDiscountStart * 1000 | date:'yyyy-MM-dd'}} 到 {{noDiscountEnd * 1000 | date:'yyyy-MM-dd'}}</span></p>
                <p class="MT20">
                    不打折卡种：
                    <span ng-repeat="i in noDiscountCards">{{i}}，</span>
                </p>
            </div>
        </div>
    </div>
</div>