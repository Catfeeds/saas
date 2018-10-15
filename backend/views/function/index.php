<?php
use backend\assets\FunctionCtrlAsset;
FunctionCtrlAsset::register($this);
$this->title='功能管理';
?>
<div  style="height: 100%" ng-controller='functionCtrl' ng-cloak>
    <input  id="_csrf" type="hidden"
            name="<?= \Yii::$app->request->csrfParam; ?>"
            value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <header  style="height: 100%">
<!--        <div class="wrapper wrapper-content  animated fadeIn">-->
<!--            <div class="row">-->
<!--                <div class="col-sm-12">-->
                    <div class="panel panel-default ">
                        <div class="panel-heading" class="col-sm-12">
                            <div class="col-sm-6 text-left">
                                <span style="display: inline-block"><b class="spanSmall">功能管理</b></span>
                            </div>
                            <div class="col-sm-4"></div>
                            <div calss="col-sm-2 text-right">
                                <a href="" class="btn btn-success btn addFunctionA" ng-click="addFunction()">新增功能</a>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-md-5 col-md-offset-3">
                            <div class="input-group">
                                 <input type="text" class="form-control" placeholder="请输入功能名或英文名..." ng-model="searchKeywords" ng-keyup="enterSearch($event)" style="height: 34px;">
                                 <span class="input-group-btn" >
                                      <button class="btn btn-success" type="button" style="width: 80px;" ng-click="searchBtn()">搜索</button>
                                 </span>
                            </div>
                        </div>
                        <div class="col-md-1 text-right">
                            <button class="btn btn-info" type="button" style="width: 80px;" ng-click="clearSearchBtn()">清空</button>
                        </div>
                    </div>

<!--                </div>-->
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>功能列表</h5>
                            <div class="ibox-tools">
                            </div>
                        </div>
                        <div class="ibox-content pd0">
                            <div id="DataTables_Table_0_wrapper"  class="dataTables_wrapper form-inline pd0" role="grid">
                                <div class="row displayNone">
                                    <div class="col-sm-6">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter"></div>
                                    </div>
                                </div>
                                <table
                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting w240" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('fun_name',sort)" rowspan="1" style="width: 16.5%;"
                                           colspan="1" aria-label="浏览器：激活排序列升序"><span aria-hidden="true" class="fa fa-th-large"></span>&nbsp;功能名
                                        </th>
                                        <th class="sorting w240" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('fun_eName',sort)" rowspan="1" style="width: 25%;"
                                            colspan="1" aria-label="浏览器：激活排序列升序"><span
                                                aria-hidden="true" class="fa fa-font"></span>&nbsp;英文名
                                        </th>
                                        <th class="sorting w240" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('fun_createAt',sort)" rowspan="1" style="width: 15%;"
                                             colspan="1" aria-label="浏览器：激活排序列升序"><span
                                                aria-hidden="true" class="fa fa-clock-o"></span>&nbsp;创建时间
                                        </th>
                                        <th class="sorting w240 bgcW" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('fun_note',sort)" rowspan="1" style="width: 20%;"
                                              colspan="1" aria-label="平台：激活排序列升序"><span
                                                 aria-hidden="true"  class="fa fa-commenting"></span>&nbsp;功能描述
                                        </th>
                                        <th class="sorting w240 bgcW" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" style="width: 23.5%;"
                                              colspan="1" aria-label="引擎版本：激活排序列升序"><span
                                                class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;操作
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="gradeA  cp"  ng-repeat="function in  allFunction">
                                        <td>{{function.name | noData:''}}</td>
                                        <td>{{function.e_name | noData:''}}</td>
                                        <td>{{function.create_at*1000 | date:'yyyy-MM-dd' | noData:''}}</td>
                                        <td>{{function.note | noData:''}}</td>
                                        <td class="tdBtn" >
                                            <button class="btn btn-success btn-sm mrr10" type="button" ng-click="updateFunction(function)">
                                                修改功能
                                            </button>
                                            <button class="btn btn-danger btn-sm" type="button" ng-click="delMem(function.id,function.name)">删除功能
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?=$this->render('@app/views/common/nodata.php');?>
                                <?=$this->render('@app/views/common/pagination.php');?>
                            </div>
                        </div>
                    </div>
                </div>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </header>

    <!--新增功能、修改功能-->
    <?= $this->render('@app/views/function/addAndEdit.php'); ?>
</div>

