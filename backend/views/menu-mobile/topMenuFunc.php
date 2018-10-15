<!-- /**
 * Created by PhpStorm.
 * User: 程丽明 chengliming@itsports.club
 * Date: 2017/12/1
 * Time: 9:59
 * Content:顶级菜单功能页面
 */ -->

<!--新增顶级菜单的模态框-->
<div class="modal fade" id="addTopMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="text-align: center;font-size: 16px;padding-left: 20px;">新增顶级菜单</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-horizontal">
                            <div class="col-sm-8 col-sm-offset-2 pd0">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><span class="red">*</span>菜单名称</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputEmail3" placeholder="请输入菜单名称" ng-model="topName">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-2 pd0">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><span class="red">*</span>英文名称</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" placeholder="请输入英文名称" ng-model="topEName"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-2 pd0">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><span class="red op0">*</span>菜单图标</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputEmail5" placeholder="请输入图标名称如：fa fa-work" ng-model="topIcon" onkeyup="this.value=this.value.replace(/[^\w+\s_-]*/g,'');">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w100" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-success" style="width: 100px" ng-click="addTopMenuSuccess()" ladda="addMenuButtonFlag">完成</button>
            </div>
        </div>
    </div>
</div>

<!--顶级菜单排序-->
<div class="modal fade" id="mainMenuSorting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header pb15none">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel" style="text-align: center;font-size: 16px;padding-left: 20px;">排序</h4>
                <div class="row borderPaddingLeftRigth">
                    <div class="col-sm-12 h40">
                        <div class="col-sm-8 col-sm-offset-2 pd0 h40 pb15none">
                            <div class=" textAlignCenter pb15none h35px ">
                                <div class="col-sm-6 ">排序</div>
                                <div class="col-sm-6 ">菜单名</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-horizontal">
                            <div class="col-sm-8 col-sm-offset-2 pd0 " ng-repeat="w in mainMenuSortingData">
                                <div class="form-group submenuSortingData textAlignCenter">
                                    <div class="col-sm-6 paddingLeft30px" >
                                        <input type="text"  class="form-control displayBlock textAlignCenter" ng-model="w.number" inputnum>
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
                <button type="button" class="btn btn-success" style="width: 100px" ng-click="mainMenuSortingOk()">完成</button>
            </div>
        </div>
    </div>
</div>

<!--修改顶级菜单的模态框-->
<div class="modal fade" id="amendTopMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title topTitleM" id="myModalLabel">修改顶级菜单</h4>
            </div>
            <div class="modal-body pdb20">
                <div class="row">
                    <div class="col-sm-12">
                        <form class="form-horizontal">
                            <div class="col-sm-8 col-sm-offset-2 pd0">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"><span class="red">*</span>菜单名称</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="" ng-model="topNameUp">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-2 pd0">
                                <div class="form-group">
                                    <label for="inputEmail4" class="col-sm-3 control-label"><span class="red">*</span>英文名称</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="" ng-model="topENameUp" onkeyup="this.value=this.value.replace(/[^\w]*/g,'');">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 col-sm-offset-2 pd0">
                                <div class="form-group">
                                    <label for="inputEmail5" class="col-sm-3 control-label"><span class="red op0">*</span>菜单图标</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="inputEmail5" ng-model="topIconUp" onkeyup="this.value=this.value.replace(/[^\w+\s_-]*/g,'');">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w100" data-dismiss="modal" >取消</button>
                <button type="button" class="btn btn-success" style="width: 100px" ng-click="amendTopMenuSuccess()">完成</button>
            </div>
        </div>
    </div>
</div>
