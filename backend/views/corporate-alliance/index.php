<?php
use backend\assets\CorporateAllianceAsset;
CorporateAllianceAsset::register($this);
$this->title = '公司联盟';
?>
<div class="container-fluid pd0" ng-controller="corporateAllianceCtrl" ng-cloak>
    <?=$this->render('@app/views/common/csrf.php')?>
    <div class="panel panel-default ">
        <div class="panel-heading">
            <span style="display: inline-block"><b class="spanSmall">公司联盟</b></span>
        </div>
        <div class="panel-body">
            <div class="col-sm-12">
                <div class="col-sm-4 col-sm-offset-4 pd0">
                    <form>
                        <div class="form-group col-sm-10 pd0 searchBox mrb0">
                            <input type="text" class="form-control" placeholder="请输入公司名称进行搜索" ng-model="keywords">
                        </div>
                        <div class="col-sm-2 pd0 searchBox">
                            <button type="submit" class="btn btn-success btn-block boR0"  ng-click="searchKeywords()"><i class="glyphicon glyphicon-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-sm-2 pull-right searchBox">
                    <button type="button" class="btn btn-success applyAddBtn"  data-toggle="modal" data-target="#applyShopAddModal">申请通店</button>
                </div>
            </div>
            <div class="col-sm-12 pd0">
                <div class="ibox float-e-margins borderNone">
                    <div class="ibox-content pd10">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline pdm0" role="grid">
                            <table class="table table-bordered table-hover dataTables-example dataTable">
                                <thead>
                                <tr role="row">
                                    <th class=" w120" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">品牌名称</th>
                                    <th class=" w120" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">联盟状态</th>
                                    <th class=" w120" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">申请方</th>
                                    <th class=" w120" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">被申请方</th>
                                    <th class=" w220" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">联盟日期</th>
                                    <th class=" w120" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="btnHoverOp1" ng-repeat="xx in ApplyShopInfoList track by $index">
                                    <td ng-click="applyShopDetailsClick(xx.id,xx.status,xx.name,xx.be_apply_id)">
                                        <i class="glyphicon glyphicon-exclamation-sign nameTishi" ng-if="xx.status == '2' && xx.end_apply > todayTime && contactNameddd == xx.orgName"></i>
                                        <span>{{contactNameddd}}</span>
                                        <span ng-if="dataNa == null">幸福里</span>
                                    </td>
                                    <td ng-click="applyShopDetailsClick(xx.id,xx.status,xx.name,x.be_apply_id)">
                                        <span ng-if="xx.status == '1' && xx.end_apply >= todayTime">已通过</span>
                                        <span ng-if="xx.status == '2' && xx.end_apply >= todayTime">等待通过</span>
                                        <span ng-if="xx.status == '3' && xx.end_apply >= todayTime">未通过</span>
                                        <span ng-if="xx.status == '4' && xx.end_apply >= todayTime">已取消</span>
                                        <span  ng-if="xx.end_apply < todayTime">已过期</span>
                                        <span ng-if="xx.status == null">暂无数据</span>
                                    </td>
                                    <td ng-click="applyShopDetailsClick(xx.id,xx.status,xx.name,xx.be_apply_id)">
                                        <span>{{xx.name}}</span>
                                        <span ng-if="xx.name == null">暂无数据</span>
                                    </td>
                                    <td ng-click="applyShopDetailsClick(xx.id,xx.status,xx.name,xx.be_apply_id)">
                                        <span>{{xx.orgName}}</span>
                                        <span ng-if="xx.orgName == null">暂无数据</span>
                                    </td>
                                    <td  ng-click="applyShopDetailsClick(xx.id,xx.status,xx.name,xx.be_apply_id)">
                                        <span ng-if="xx.start_apply != null">{{xx.start_apply*1000|date:'yyyy-MM-dd'}}-{{xx.end_apply*1000|date:'yyyy-MM-dd'}}</span>
                                        <span ng-if="xx.start_apply == null && xx.end_apply == null">暂无数据</span>
                                    </td>
                                    <td>
                                        <!--取消通店的触发按钮-->
                                        <button class="btn btn btn-white op0" ng-click="notApply(xx.id,xx.name)" ng-if="xx.status != '4' && xx.end_apply >= todayTime">取消通店</button>
                                        <button class="btn btn btn-link op0" ng-if="xx.status == '4' && xx.end_apply >= todayTime" disabled>已取消</button>
                                        <button class="btn btn btn-link op0" ng-if="xx.end_apply < todayTime" disabled>已过期</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <?= $this->render('@app/views/common/pagination.php'); ?>
                            <?=$this->render('@app/views/common/nodata.php',['name'=>'getApplyShopListNOdata','text'=>'暂无数据','href'=>true]);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--申请通店-->
    <?= $this->render('@app/views/corporate-alliance/applyShopAlliance.php'); ?>
    <!--等待申请-->
    <?= $this->render('@app/views/corporate-alliance/waitAllianceApply.php'); ?>
    <!--通店详情-->
    <?= $this->render('@app/views/corporate-alliance/allianceDetail.php'); ?>
    <!--取消通店-->
    <?= $this->render('@app/views/corporate-alliance/cancelShopAlliance.php'); ?>
    <!--申请状态-->
    <?= $this->render('@app/views/corporate-alliance/applyAllianceStatus.php'); ?>
</div>
