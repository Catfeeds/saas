<?php
use backend\assets\ClassCtrlAsset;
ClassCtrlAsset::register($this);
$this->title = '课种管理';
?>
<div ng-controller='classCtrl' ng-cloak>
    <header>
<!--<div class="wrapper wrapper-content  animated fadeIn">-->
<!--<div class="row">-->
<!--<div class="col-sm-12">-->
                <div class="panel panel-default ">
                        <div class="panel-heading"><span class="displayInlineBlock"><b class="spanSmall">课种管理</b></span>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12 col-xs-12 pdLR0">
                                <div class="col-sm-3 col-xs-3 pdLR0 mT10">
                                    <select name="" id="" class="form-control colorGrey chooseCourseType"  ng-change="classChangeType()" ng-model="classTypeSelect" style="width: 143px">
                                        <option value="">选择课程类型</option>
                                        <option value="2">团教课</option>
                                        <option value="1">私教课</option>
                                    </select>
                                </div>
                                <div class="col-sm-6 col-xs-6 pdLR0  text-center" >
                                    <div class="col-sm-12 col-xs-12 pdLR0">
                                        <div class="input-group col-xs-12 col-sm-12 pdLR0 mT10">
                                            <input type="text" ng-model="className" id="inputSearch" class="form-control " ng-keydown="enterSearch()" placeholder="请输入分类，名称，创建人">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary" ng-click="searchClass()">搜索</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 col-xs-3 pdLR0 text-right">
                                <li class="nav_add">
                                    <ul>
                                        <?php if(\backend\models\AuthRole::canRoleByAuth('course','ADD')){ ?>
                                        <li class="new_add" id="tmk">
                                            <span class="btn btn-success btn f14 mT10" data-toggle="modal" data-target="#myModal" ng-click="myInit()" >新增课程</span>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            </div>
                            </div>
                        </div>
                    </div>
                <div class="col-sm-12 pdLR0">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>课种列表</h5>
                            <div class="ibox-tools"></div>
                        </div>
                        <div class="ibox-content pd0" >
                            <div id="DataTables_Table_0_wrapper"  class="dataTables_wrapper form-inline pd0" role="grid">
                                <div class="row disNone" >
                                    <div class="col-sm-6">
                                        <div id="DataTables_Table_0_filter" class="dataTables_filter"></div>
                                    </div>
                                </div>
                                <table
                                    class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('pic',sort)"    colspan="1" aria-label="浏览器：激活排序列升序" ><span
                                                class="glyphicon glyphicon-camera" aria-hidden="true"></span>&nbsp;课种图片
                                        </th>
                                        <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('class_type',sort)"     colspan="1" aria-label="浏览器：激活排序列升序" ><span
                                                class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;课程类型
                                        </th>
                                        <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('category',sort)"     colspan="1" aria-label="浏览器：激活排序列升序" ><span
                                        class="glyphicon glyphicon-list-alt" aria-hidden="true" ></span>&nbsp;分类
                                        </th>
                                        <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('name',sort)"    colspan="1" aria-label="平台：激活排序列升序" ><span
                                                class="glyphicon glyphicon-file" aria-hidden="true"></span>&nbsp;名称
                                        </th>
                                        <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('create_id',sort)"    colspan="1" aria-label="引擎版本：激活排序列升序" ><span
                                                class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;创建人
                                        </th>
                                        <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        ng-click="changeSort('created_at',sort)"    colspan="1" aria-label="引擎版本：激活排序列升序" ><span
                                                class="glyphicon glyphicon-sound-stereo" aria-hidden="true"></span>&nbsp;创建时间
                                        </th>
                                        <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            ng-click="changeSort('update_at',sort)"    colspan="1" aria-label="引擎版本：激活排序列升序" ><span
                                                class="glyphicon glyphicon-sound-stereo" aria-hidden="true"></span>&nbsp;修改时间
                                        </th>
                                        <th class="sorting w242" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                            colspan="1" aria-label="CSS等级：激活排序列升序"><span
                                                class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;编辑
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="gradeA odd" ng-repeat="item in items">
                                        <td><img class="imgBr8" ng-src="{{item.pic}}" ng-if="item.pic!=null&&item.pic!=''"  ><span ng-if="item.pic===null||item.pic===''"><img ng-src="/plugins/class/img/22.png" class="imgBr8"></span></td>
                                        <td><span ng-if="item.class_type==1">私教课</span><span ng-if="item.class_type==2">团教课</span></td>
                                        <td>{{item.category}}</td>
                                        <td>{{item.name}}</td>
                                        <td>{{item.employeeName | noData:''}}</td>
                                        <td>{{item.created_at*1000 | date:'yyyy-MM-dd HH:mm' }}</td>
                                        <td ng-if="item.update_at != null">{{item.update_at*1000 | date:'yyyy-MM-dd HH:mm' }}</td>
                                        <td ng-if="item.update_at == null">暂无数据</td>
                                        <td class="tdBtn">
                                        <?php if(\backend\models\AuthRole::canRoleByAuth('course','UPDATE')){ ?>
                                            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModals" type="submit"  ng-click="courseType(item.id)">
<!--                                               <a class="colorW mT5" href="" >-->
                                                 修改
<!--                                                </a>-->
                                           </button>&nbsp;&nbsp;
                                        <?php } ?>
                                        <?php if(\backend\models\AuthRole::canRoleByAuth('course','DELETE')){ ?>
                                            <button class="btn btn-danger btn-sm" type="submit"
                                                    ng-click="courseDel(item.id,item.name)">删除
                                            </button>
                                        <?php } ?>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?= $this->render('@app/views/common/nodata.php'); ?>
                                <?=$this->render('@app/views/common/page.php');?>
                            </div>
                        </div>
                    </div>
                </div>
<!--</div>-->
<!--</div>-->
<!--</div>-->
    </header>
    
    <!--新增课程和修改课种-->
    <?= $this->render('@app/views/class/editAndAddClass.php'); ?>
</div>