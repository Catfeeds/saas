<!--/**
 * Created by PhpStorm.
 * User: 程丽明 chengliming@itsports.club
 * Date: 2017/12/1
 * Time: 10:09
 * Content:子菜单功能
 */ -->
<!--查看子菜单的模态框-->
<div class="modal fade" id="lookSecondMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog w80b" role="document" style="margin-top:10px;margin-bottom:10px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title topTitleM" id="myModalLabel">查看子菜单</h4>
            </div>
            <div class="modal-body subBody">
                <div class="row">
                    <div class="col-sm-12 pd0 subBtnBox">
                        <button type="button" class="btn btn-default btnAddSubs  " data-toggle="modal" data-target="#submenuSorting" ng-click="submenuSorting()">排序</button>
                        <button class="btn btn-success btnAddSub " data-toggle="modal" data-target="#addSecondMenu" ng-click="addSecondMenuBtn()">新增子菜单</button>
                        <!--新增子菜单的列表-->
                        <div class="ibox float-e-margins borderNone subShowList">
                            <div class="ibox-content borderNone pd0">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline pdb0" role="grid">
                                    <table class="table table-bordered table-hover dataTables-example dataTable">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting w120" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('cabinetNum',sort)" rowspan="1" colspan="1" style="width: 15%;">子菜单名称</th>
                                            <th class="sorting w120" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('cabinetModel',sort)" rowspan="1" colspan="1">英文名</th>
                                            <th class="sorting w240" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('cabinetType',sort)" rowspan="1" colspan="1">功能</th>
                                            <th class="sorting w120" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('customerName',sort)" rowspan="1" colspan="1">创建时间</th>
                                            <th class="sorting w120" tabindex="0" aria-controls="DataTables_Table_0" ng-click="changeSort('customerName',sort)" rowspan="1" colspan="1">菜单地址</th>
                                            <th class="sorting w240" tabindex="0" aria-controls="DataTables_Table_0"  rowspan="1" colspan="1" style="width: 20%;">操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr ng-repeat="son in sencondMenuList">
                                            <td>
                                                <span ng-if="son.name != null">{{son.name}}</span>
                                                <span ng-if="son.name == null">暂无数据</span>
                                            </td>
                                            <td>
                                                <span ng-if="son.e_name != null">{{son.e_name}}</span>
                                                <span ng-if="son.e_name == null">暂无数据</span>
                                            </td>
                                            <td class="pd30pr30"><span ng-repeat="xx in son.moduleFunctional"><span>{{xx.name}}/</span></span></td>
                                            <td><span ng-if="son.create_at != ''&&son.create_at != null&&son.create_at !=undefined">{{son.create_at*1000|date:'yyyy-MM-dd'}}</span><span ng-if="son.create_at == ''||son.create_at == null||son.create_at ==undefined">暂无数据</span></td>
                                            <td>
                                                <span ng-if="son.url != null">{{son.url}}</span>
                                                <span ng-if="son.url == null">暂无数据</span>
                                            </td>
                                            <td>
                                                <!--                                        子菜单显示的出发按钮-->
                                                <button class="btn btn-sm btn-primary w60" ng-if="son.is_show != 2 && son.is_show != '2'" ng-click="showMenuButton(son.id)">显示</button>
                                                <button class="btn btn-sm btn-primary w60" ng-if="son.is_show == 2 || son.is_show == '2'" ng-click="showMenuButton(son.id)">不显示</button>
                                                <!--                                        子菜单功能的触发按钮-->
                                                <button class="btn btn-sm btn-warning w60" data-toggle="modal" data-target="#functionSecondMenu" ng-click="functionSecondMenu(son.id)" >功能</button>
                                                <!--                                        子菜单修改的触发按钮-->
                                                <button class="btn btn-sm btn-success w60" data-toggle="modal" data-target="#amendSecondMenu" ng-click="amendSecondMenu(son.id)">修改</button>
                                                <!--                                                    移动-->
                                                <button type="button" class="btn btn-sm btn-info w60" data-toggle="modal" data-target="#moveModal" ng-click="moveModal(son.id)">移动</button>
                                                <!--                                            子菜单删除的触发按钮-->
                                                <button class="btn btn-sm btn-danger w60" ng-click="deleteSencondMenu(son.id,son.name)">删除</button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="col-sm-12 pd0 text-center transitionBox">
                                        <div class="ball-scale-multiple">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                        <p>加载中</p>
                                    </div>
                                    <?=$this->render('@app/views/common/nodata.php',['name'=>'noSubMenuShow','text'=>'暂无数据','href'=>true]);?>
                                    <span class="pull-right spanTable">共{{allNumSubMenu}}条</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w100" data-dismiss="modal">取消</button>
                <!--                    <button type="button" class="btn btn-success" style="width: 100px" ng-click="lookSecondMenuSuccess()">完成</button>-->
            </div>
        </div>
    </div>
</div>

<!--子菜单排序-->
<div class="modal fade" id="submenuSorting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header pb15none">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="text-align: center;font-size: 16px;padding-left: 20px;">排序</h4>
                <div class="row borderPaddingLeftRigth">
                    <div class="col-sm-12 h40">
                        <div class="col-sm-8 col-sm-offset-2 pd0 h40 pb15none">
                            <div class="form-group textAlignCenter pb15none h35px ">
                                <div class="col-sm-6 control-label">排序</div>
                                <div class="col-sm-6 control-label">菜单名</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-horizontal">
                            <div class="col-sm-8 col-sm-offset-2 pd0 " ng-repeat="w in submenuSortingData">
                                <div class="form-group textAlignCenter">
                                    <div class="col-sm-6 paddingLeft30px  submenuSortingDatas">
                                        <input type="text" class="form-control" ng-model="w.number">
                                    </div>
                                    <div class="col-sm-6  textAlignCenter">{{w.name}}</div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w100" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-success" style="width: 100px" ng-click="submenuSortingOk()">完成</button>
            </div>
        </div>
    </div>
</div>

<!--子菜单移动-->
<div class="modal fade" id="moveModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="text-align: center;font-size: 16px;padding-left: 20px;">移动</h4>
            </div>
            <div class="modal-body pd20px">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-horizontal">
                            <div class="col-sm-8 col-sm-offset-2 pd0" ng-repeat="($index,w) in moveModalData">
                                <div class="form-group textAlignCenter moveModalArray">
                                    <div class="col-sm-6  textAlignCenter h35px name">{{w.name}}</div>
                                    <div class="col-sm-6 h35px textAlignCenter span"  ng-click="moveModalListItem($event,$index,w.id)">
                                        <span class="glyphicon glyphicon-ok spanName  colorBlue" ng-if="lookSecondMenuPostId == w.id"  aria-hidden="true"></span>
                                        <span class="glyphicon glyphicon-ok colorOpacity  " ng-if="lookSecondMenuPostId != w.id"  aria-hidden="true"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w100" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-success" style="width: 100px" ng-click="moveModalOk()">完成</button>
            </div>
        </div>
    </div>
</div>

<!--新增子菜单的模态框-->
<div class="modal fade" id="addSecondMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title topTitleM" id="myModalLabel">新增子菜单</h4>
            </div>
            <div class="modal-body pdb20">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-horizontal">
                            <div class="col-sm-8 col-sm-offset-2 pd0">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"><span class="red">*</span>菜单名称</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputEmail3" placeholder="请输入菜单名称" ng-model="subName">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-2 pd0">
                                <div class="form-group">
                                    <label for="inputEmail4" class="col-sm-3 control-label"><span class="red">*</span>英文名称</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputEmail4" placeholder="请输入英文名称" ng-model="subEName">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-2 pd0">
                                <div class="form-group">
                                    <label for="inputEmail5" class="col-sm-3 control-label"><span class="red op0">*</span>菜单图标</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputEmail5" placeholder="请输入图标名称如：fa fa-work" ng-model="subIcon">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-2 pd0">
                                <div class="form-group">
                                    <label for="inputEmail5" class="col-sm-3 control-label"><span class="red">*</span>菜单地址</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputEmail5" placeholder="请输入菜单地址" ng-model="subUrl">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w100" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-success w100" ng-click="addSecondMenuSuccess()" ladda="addChildMenuButton">完成</button>
            </div>
        </div>
    </div>
</div>

<!--子菜单功能的模态框-->
<div class="modal fade" id="functionSecondMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width:66%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title topTitleM" id="myModalLabel">菜单功能</h4>
            </div>
            <div class="modal-body pdb20">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-horizontal">
                            <div class="col-sm-12 pd0">
                                <div class="form-group">
                                    <label for="" class="col-sm-2 control-label"><span class="red">*</span>选择功能：</label>
                                    <div class="col-sm-10 menuCheck">
                                        <label class="checkbox-inline" ng-repeat="fun in functionSecondMenuGetName" style="margin-right:10px">
                                            <input type="checkbox" id="inlineCheckbox1" value="{{fun.id}}" ng-checked="fun.id | inArr:funIdArr">{{fun.name}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w100" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-success w100" ng-click="functionSecondMenuSuccess()">完成</button>
            </div>
        </div>
    </div>
</div>

<!--修改子菜单的模态框-->
<div class="modal fade" id="amendSecondMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title topTitleM" id="myModalLabel">修改子菜单</h4>
            </div>
            <div class="modal-body pdb20">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-horizontal">
                            <div class="col-sm-8 col-sm-offset-2 pd0">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><span class="red">*</span>菜单名称</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputEmail3" placeholder="请输入菜单名称" ng-model="subNameUp">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-2 pd0">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><span class="red">*</span>英文名称</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputEmail4" placeholder="请输入英文名称" ng-model="subENameUp"  onkeyup="this.value=this.value.replace(/[^a-zA-Z]+/g, '');">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-2 pd0">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><span class="red op0">*</span>菜单图标</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputEmail5" placeholder="请输入图标名称如：fa fa-work" ng-model="subIconUp">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-2 pd0">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><span class="red">*</span>菜单地址</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputEmail5" placeholder="请输入菜单地址" ng-model="subUrlUp">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w100" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-success w100" ng-click="amendSecondMenuSuccess()">完成</button>
            </div>
        </div>
    </div>
</div>
