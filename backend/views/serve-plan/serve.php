<?php
use backend\assets\ServePlanCtrlAsset;
ServePlanCtrlAsset::register($this);
$this->title = '服务管理';
?>
<div ng-controller = 'serveCtrl' ng-cloak>
    <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
<!--    <div class="wrapper wrapper-content  animated fadeIn" >-->
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default ">
                <div class="panel-heading">
                    <span style="display: inline-block"><b class="spanSmall">服务管理</b></span>
                </div>
                <div class="panel-body headerSearch" >
                    <div class="col-sm-3 col-xs-0">

                    </div>
                    <div class="col-sm-6 col-xs-8" >
                        <div class="input-group">
                            <input type="text" ng-model="keywords" ng-keydown="enterSearch()" class="form-control h34" placeholder="请输入名称进行搜索..."
                                   >
                            <span class="input-group-btn">
                                <button type="button" ng-click="searchAbout()" class="btn btn-primary">搜索</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3  text-center" >
                        <?php if(\backend\models\AuthRole::canRoleByAuth('service','ADD')){ ?>
                        <li class="new_add cp pT0" >
                            <span  ng-click="newAdd()" class="btn btn-success btn bgColorGreen" data-toggle="modal" data-target="#myModal2">新增服务</span>
                        </li>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12" >
            <!--tab切换按钮-->
            <div class="tabBox clearfix borderE5"  >
                <div class="list_tab fl " >
                    <img ng-src="/plugins/servePlan/imgs/u2.png" alt="" /><a href="/serve-plan/serve?c=9"><span class="yG" >服务管理</span></a>
                </div>
                <div class="list_tab fl zIndex" ng-show="false">
                    <img ng-src="/plugins/servePlan/imgs/u4.png" alt="" /><a href="/serve-plan/index?&c=9"><span >套餐管理</span></a>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>服务套餐信息管理</h5>
                    <div class="ibox-tools">

                    </div>
                </div>
                <div class="ibox-content" >
                    <div  id="DataTables_Table_0_wrapper" class="mBF32 dataTables_wrapper form-inline" role="grid">
                        <div class="row">
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter">

                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <tr role="row">
                            <th ng-click="changeSort('comboName',sort)" class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="浏览器：激活排序列升序" style="width: 282px;"><span class="fa fa-book" aria-hidden="true"></span>&nbsp;服务
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="引擎版本：激活排序列升序" style="width: 200px;"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;编辑
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="item in items" class="cp">
                            <td>{{item.name}}</td>
                            <td class="tdBtn">
                                <?php if(\backend\models\AuthRole::canRoleByAuth('service','UPDATE')){ ?>
                                <div id="myEdit" type="button" class="btn btn-success btn-sm mR3 colorW" data-toggle="modal" data-target="#myModals" >
                                    <!-- 修改-->
                                    <a href="#" ng-click="getServerOne(item.id,item.name)"  data-toggle="modal" data-target="#myModal" class="colorW">修改</a>
                                </div>
                                <?php } ?>
                                <?php if(\backend\models\AuthRole::canRoleByAuth('service','DELETE')){ ?>
<!--                                ng-click="delServerCombo(item.id)" 删除套餐-->
                                <div ng-click="delServer(item.id,item.name)"  class="btn btn-danger btn-sm delete">删除</div>
                                <?php } ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <?=$this->render('@app/views/common/nodata.php');?>

                        <div class="col-sm-6 text-right wB95">
                            <div class="dataTables_paginate paging_simple_numbers"
                                 id="DataTables_Table_0_paginate">

                                <?=$this->render('@app/views/common/pagination.php');?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--</div>-->
    <!--修改服务-->
    <?= $this->render('@app/views/serve-plan/changeServeManage.php'); ?>
    <!--添加服务-->
    <?= $this->render('@app/views/serve-plan/addServeManage.php'); ?>
<!-- Modal -->
    <div class="modal fade" id="addServeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <button  type="button" class="close mT5 mR10" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <section class="yy_search">
                    <div class="searchBox">
                        <form class="formMargin" >
                            <div>
                                <h2 class="text-center">添加服务套餐</h2>
                            </div>
                            <p><span class="red">*</span>套餐名称</p>
                            <input class="form-control" ng-model="serverComboName" type="text" placeholder="套餐名称" />
                            <h4><span class="red">*</span>服务种类</h4>
                            <div id="serveLists" class="isCard isCheck">
                                <div class="checkbox i-checks w120" >
                                    <label>
                                        <input type="checkbox" value=""> <i></i>拖鞋</label>
                                </div>
                                <div class="checkbox i-checks w200" >
                                    <label>
                                        <input type="checkbox" value=""> <i></i>茶水</label>
                                </div>
                                <div class="checkbox i-checks w200" >
                                    <label>
                                        <input type="checkbox" value=""> <i></i>点心</label>
                                </div>
                                <div class="checkbox i-checks w200" >
                                    <label>
                                        <input type="checkbox" value=""> <i></i>更衣柜</label>
                                </div>
                                <div class="checkbox i-checks w200" >
                                    <label>
                                        <input type="checkbox" value=""> <i></i>休息室</label>
                                </div>
                                <div class="checkbox i-checks w200" >
                                    <label>
                                        <input type="checkbox" value=""> <i></i>瑜伽垫</label>
                                </div>
                                <div class="checkbox i-checks w200" >
                                    <label>
                                        <input type="checkbox" value=""> <i></i>毛巾</label>
                                </div>
                            </div>
                            <div class="addSource">
                                <div id="addBtn"  class="btn btn-success btn-lg wAuto"  >添加服务种类</div>
                                <div id="addSelect" class="clearfix  dis_none mT10" >
                                    <input id="serveText" type="text"  class="form-control fl wB50 mG0"   placeholder="输入服务种类">
                                    <button id="courseTrue" type="button" class="btn btn-success btn-lg fr ">确定</button>
                                    &nbsp;
                                    <button  id="courseCancel" type="button" class="btn btn-warning btn-lg fr mR10">取消</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--    返回、完成按钮-->
                    <div id="lastBox">
                        <div class="fixedBox ">
                            <div class=" btn btn-primary cp w100"data-dismiss="modal" aria-label="Close" >返回</div>
                            <a href="#">
                                <div class="btn btn-success w100" ng-click="setServerComboData()" >完成</div>
                            </a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

</div>
