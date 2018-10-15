<!--    已绑定会员修改的模态框-->
<div class="modal fade" id="revise" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="overflow-y: scroll">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">修改</h4>
            </div>
            <div class="modal-body row">
                <div class="col-sm-12 pd0">
                    <form class="form-horizontal pd0 pR40">
                        <div class="form-group selectBox mT20 col-sm-12">
                            <label for="inputEmail1" class="control-label pull-left text-center" style="width: 115px;"><span class="red">*</span>柜子型号</label>
                            <div class="col-sm-8">
                                <select class="form-control pT4 colorGrey" ng-model="editCabinetSize" id="inputEmail1" ng-disabled="isCabinetBindMember">
                                    <option value="">请选择柜子尺寸</option>
                                    <option value="1">大柜</option>
                                    <option value="2">中柜</option>
                                    <option value="3">小柜</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group selectBox mT20 col-sm-12">
                            <label for="inputEmail2" class="control-label pull-left text-center" style="width: 115px;"><span class="red">*</span>柜子类别</label>
                            <div class="col-sm-8">
                                <select class="form-control colorGrey" style="padding: 4px 12px;" id="inputEmail2" ng-model="editCabinetType" ng-disabled="isCabinetBindMember">
                                    <option value="">请选择类别</option>
                                    <option value="1">临时</option>
                                    <option value="2">正式</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group selectBox mT20 col-sm-12" ng-show="editCabinetType == '2'">
                            <label for="editCabinetDeposit555" class="control-label pull-left text-center" style="width: 115px;"><span class="red">*</span>柜子押金</label>
                            <div class="col-sm-8">
                                <input type="number" checknum ng-model="editCabinetDeposit" id="editCabinetDeposit555" class="form-control"  placeholder="请输入柜子押金"/>
                            </div>
                        </div>
                        <div class="form-group selectBox mT20 col-sm-12">
                            <label for="inputEmail4" class="control-label pull-left text-center" style="width: 115px;"><span class="red">*</span>单月金额</label>
                            <div class="col-sm-8">
                                <input class="form-control" checknum ng-model="editOneMonthPrice" id="inputEmail4" type="text" placeholder="请输入价格：如10000"/>
                            </div>
                        </div>
                        <!--多月设置修改-->
                        <div id="modify" class="modify" style="margin-top: 20px;" ng-show="editCabinetType == '2'"></div>
                        <div class="form-group selectBox huiLeiAdd pull-right" >
                            <label for="inputEmail4" class="control-label">
                                <button id="modifyPlugins" ng-show="editCabinetType == '2'" class="btn btn-default" venuehtml ng-click="addPlugins()" style="margin-right: 55px;">新增多月设置</button>
                            </label>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" ladda="editCompleteFlag"  ng-click="editComplete()" class="btn btn-success center-block w100" >完成</button>
            </div>
        </div>
    </div>
</div>