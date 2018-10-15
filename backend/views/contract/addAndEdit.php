<!--
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/11/30
 * Time: 17:56
 *content:新增合同修改合同
    -->
<!--模态2 新增合同-->
<div class="modal fade addContract" id="myModals4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 72%;">
        <div class="modal-content clearfix updateContract">
            <div style="border: none;" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="button-success text-center addSearch">新增合同</h3>
                <div class="col-sm-12 pd0 updateHeader"></div>
                <form class="form-inline formBox1 contractFcuntion">
                    <p class="titleP">1.基本属性</p>
                    <div class="col-sm-12 pd0">
                        <div class="form-group contractTypeHeader">
                            <label for="exampleInputName2" class="contractTypeBody font14"><span style="color: red;">*</span>合同名称</label>
                            <input type="text" class="form-control"
                                   ng-model="name"
                                   id="exampleInputName2"
                                   ng-change="setDealName(name)"
                                   style="margin-left: 10px;padding-top: 4px; width: 160px;display: inline-block;"
                                   placeholder="请输入合同名称">
                        </div>
                        <div class="form-group contractTypeHeader">
                            <label class="font14 fontNormal" for="exampleInputName2 contractTypeBody"><span style="color: red;">*</span>合同类型</label>
                            <!--                                <select class="form-control" style="padding-top: 4px; width: 200px;" ng-model="dealType">-->
                            <!--                                    <option value="">请选择合同类型</option>-->
                            <!--                                    <option value="1">游泳</option>-->
                            <!--                                    <option value="2">瑜伽</option>-->
                            <!--                                    <option value="3">舞蹈</option>-->
                            <!--                                </select>-->
                            <select class="form-control contractBody" ng-model="dealType" style="width: 160px;margin-left: 10px;">
                                <option value="">请选择合同类型</option>
                                <option value="{{deal.id}}" ng-repeat="deal in dealData">{{deal.type_name}}</option>
                            </select>
                            <!--                                <select ng-if="dealStauts == false" class="form-control contractBody">-->
                            <!--                                    <option value="">请选择合同类型</option>-->
                            <!--                                    <option value="" disabled style="color:red">{{dealData}}</option>-->
                            <!--                                </select>-->
                        </div>
                        <div class="form-group contractTypeHeader">
                            <label for="" class="font14 fontNormal"><span style="color: red;">*</span>合同分类</label>
                            <select class="form-control contractBody" ng-model="dealClassType" style="width: 160px;margin-left: 10px;">
                                <option value="">请选择合同分类</option>
                                <option value="1">卡种类合同</option>
                                <option value="2">私课类合同</option>
                            </select>
                        </div>
                        <p class="titleP" style="margin-top: 40px;">2.合同内容</p>
                    </div>
                </form>
                <div class="col-sm-12 addContractList" >
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5 class="contractName"><span style="color: red;">*</span>合同内容</h5>
                            <div class="ibox-tools">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="form_editors.html#">
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="form_editors.html#">选项1</a>
                                    </li>
                                    <li><a href="form_editors.html#">选项2</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                              <textarea config="summernoteConfigs" style="resize: none;" summernote class="summernote" required ng-model="intro" id="textarea">
                              </textarea>
                    </div>
                </div>
                <div class="col-sm-12 text-center">
                    <button class="btn btn-success btnClose width100" ng-click="dealSave()">完成</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--模态3 编辑合同类型-->
<div class="modal fade addContract" id="myModals10" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 720px;">
        <div class="modal-content clearfix updateContract">
            <div style="border: none;" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="button-success text-center" style="font-size: 24px;">合同类型</h3>
                <div class="col-sm-12 pd0" style="margin-top: 10px;height: 2px;background: #e1e1e1;"></div>
                <div class="ibox float-e-margins editContract">
                    <div class="ibox-title">
                        <h5>合同列表</h5>
                    </div>
                    <div class="ibox-content editHeader">
                        <div style="padding-bottom: 0;" id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" style="width: 140px;"><span class="glyphicon glyphicon-file" aria-hidden="true"></span>&nbsp;合同类型
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" style="width: 140px;"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;编辑
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="dt in dealTypeData">
                                    <td class="showBtn"><span class="center-block editContractName">{{dt.type_name}}</span></td>
                                    <td class="showBtn">
                                        <button class="tdBtn btn btn-success btn-sm btnClose" data-toggle="modal" ng-click="updateDealType(dt.id)" data-target="#myModals11">修改</button>
                                        <button class="tdBtn btn btn-danger btn-sm" ng-click="delDealType(dt.id,dt.type_name)">删除</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <?= $this->render('@app/views/common/nodata.php',['name'=>'dealTypeNoData','href'=>true]); ?>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary btnClose" data-toggle="modal" data-target="#myModals12" style="margin-left: 80px;margin-top: 20px;">&nbsp;&nbsp;&nbsp;&nbsp;新增&nbsp;&nbsp;&nbsp;&nbsp;</button>
                <button class="btn btn-success pull-right btnClose editWanCheng" data-dismiss="modal">&nbsp;&nbsp;&nbsp;&nbsp;完成&nbsp;&nbsp;&nbsp;&nbsp;</button>
            </div>
        </div>
    </div>
</div>
<!--模态4 修改合同类型-->
<div class="modal fade addContract" id="myModals11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="min-width: 520px;">
        <div class="modal-content clearfix updateContract">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">修改合同类型名称</h4>
            </div>
            <div style="border: none;" >
                <!--                    <div class="col-sm-12 pd0 updateHeader"></div>-->
                <form class="editContractHeader1">
                    <div class="col-sm-12 col-xs-12">
                        <div class="col-sm-8 col-xs-10 col-sm-offset-2 col-xs-offset-1 ">
                            <div class="form-group" style="margin-top: 10px;">
                                <input type="hidden" value="{{dataTypeOne.id}}" id="dealTypeId">
                                <label for="exampleInputName2" style="font-size: 14px; font-weight: normal;" class="contractName">合同类型名称:</label>
                                <input type="text" class="form-control" ng-change="setDealTypeName(dataTypeOne.type_name)"  ng-model="dataTypeOne.type_name" id="exampleInputName2" placeholder="请输入合同类型新名称">
                            </div>
                        </div>
                    </div>
                </form>
                <button style="margin-top: 40px;" class="btn btn-success center-block btnClose addContract " ng-click="updateDealTypeOne()">&nbsp;&nbsp;&nbsp;&nbsp;完成&nbsp;&nbsp;&nbsp;&nbsp;</button>
            </div>
        </div>
    </div>
</div>
<!--模态5 新增合同类型-->
<div  class="modal fade addContract" id="myModals12" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content clearfix updateContract">
            <div style="border: none;" class="modal-header row">
                <button style="margin-right: 6px;font-size: 24px;" type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-info editContractDetail" style="text-align: center;">新增合同类型名称</h3>
                <div class="col-sm-12 pd0 updateHeader"></div>
                <form class="addContractDetailType">
                    <div class="col-sm-10 col-sm-offset-1 ">
                        <div class="form-group contractTypeHeader">
                            <label for="exampleInputName2" class="contractTypeBody">合同类型名称</label>
                            <input type="text"
                                   class="form-control"
                                   id="exampleInputName2"
                                   ng-model="dealTypeName"
                                   ng-change="setDealTypeName(dealTypeName)"
                                   placeholder="请输入合同类型名称">
                        </div>
                    </div>
                </form>
                <div class="col-sm-12 text-center">
                    <button class="btn btn-success center-block btnClose addContract" ng-click="insertDealType()">&nbsp;&nbsp;&nbsp;&nbsp;完成&nbsp;&nbsp;&nbsp;&nbsp;</button>
                </div>
            </div>
        </div>
    </div>
</div>