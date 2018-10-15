<!--    修改更衣柜模态框-->
<div class="modal fade" id="typeClass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="overflow-y: scroll">
    <div class="modal-dialog wB80" role="document" style="min-width: 960px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel" >修改普通衣柜</h4>
            </div>
            <div class="modal-body row mB60">
                <div class="col-sm-12 pd0">
                    <form class="form-inline">
                        <div class="formBox row pLR20" style="padding: 0px 120px; height: 200px;" >
                            <p class="addTitle">1.基本属性</p>
                            <div class="col-sm-4 pd0 form-group formSmbox ">
                                <label for="exampleInput1"><span class="red">*</span>柜子型号</label>
                                <select disabled style="cursor: not-allowed;" ng-model="modifyCabinetSize" class="cp">
                                    <option value="">请选择柜子尺寸</option>
                                    <option value="1">大柜</option>
                                    <option value="2">中柜</option>
                                    <option value="3">小柜</option>
                                </select>
                            </div>
                            <div class="col-sm-4 pd0 form-group formSmbox ">
                                <label for="exampleInput1"><span class="red">*</span>柜子类别</label>
                                <select ng-model="modifyCabinetType" class="cp">
                                    <option value="">请选择类别</option>
                                    <option  value="1">临时</option>
                                    <option  value="2">正式</option>
                                </select>
                            </div>
                            <div class="col-sm-4 pd0 form-group formSmbox ">
                                <label >柜号&emsp; &emsp;</label>
                                <div class="input-group">
                                    <input type="text" ng-model="modifyCabinetPrefix" class="form-control" onkeyup="this.value = this.value.replace(/\d/,'')"  placeholder="编号" style="width: 100px;">
                                    <input type="text" ng-model="modifyCabinetNumStart" checknum class="form-control" style="width: 100px;" placeholder="柜号">
                                </div>
                            </div>
                            <div class="col-sm-4 pd0 formSmbox" style="position: absolute; left: 105px; top: 135px;">
                                <label for="exampleInput1"><span class="red">*</span>柜子数量</label>
                                <input tyle="number" ng-disabled="true" class="form-control w200" ng-model="modifyCabinetNum" placeholder="请输入数量"/>
                            </div>
                        </div>
                        <!--选择正式柜子触发显示的模块-->
                        <div class="formBox row pLR120" ng-show="modifyCabinetType == 2">
                            <p class="addTitle">
                                2.价格设置
                            </p>
                            <div class="col-sm-6 pd0 form-group formSmbox mB40">
                                <label for="exampleInput3"><span class="red">*</span>单月金额</label>
                                <input type="number" id="exampleInput3" ng-model="modifyHalfMonthMoney" class="form-control moneyInput" placeholder="请输入单月金额" autocomplete="off" checknum/>
                                <span class="label label-info" ng-bind="modifyHalfMonthMoney|currency:'￥':0"></span>
                            </div>
                            <div class="col-sm-6 pd0 form-group formSmbox mB40">
                                <label for="exampleInput111"><span class="red">*</span>柜子押金</label>
                                <input  type="number" id="exampleInput111" ng-model="modifyCabinetDeposit" class="form-control w200 moneyInput" placeholder="0元" autocomplete="off" checknum/>
                                <span class="label label-info" ng-bind="modifyCabinetDeposit|currency:'￥':0"></span>
                            </div>
                            <hr style="background: #eee;margin-top: 80px;">
                            <!--填充begin-->
<!--                            <div class="col-sm-4 pd0 form-group formSmbox mB40" style="visibility: hidden;">-->
<!--                                <input type="text" class="form-control" />-->
<!--                            </div>-->
                            <!--填充end-->
                            <!--新增多月设置容器--start-->
                            <div id="modifyMuchPlugins" class="addCabinetMonth">
                                <div class="clearfix">
                                    <div class="col-sm-4 pd0 form-group formSmbox mB40">
                                        <label for="exampleInput112">多月设置</label>
                                        <div class="input-group">
                                            <input type="text" name="cabinet_month"  id="exampleInput112" ng-model="modifyMuchMonth" class="form-control" checknum style="width: 100px;" placeholder="月数" autocomplete="off"/>
                                            <input type="number" name="cabinet_money" ng-model="modifyCabinetMoney" class="form-control moneyInput" style="width: 100px;" placeholder="金额" autocomplete="off" checknum/>
                                        </div>
                                        <span class="label label-info" ng-bind="modifyCabinetMoney|currency:'￥':0"></span>
                                    </div>
                                    <div class="col-sm-4 pd0 form-group formSmbox mB40" >
                                        <label for="exampleInput113"><span style="visibility: hidden">*</span>&emsp;&emsp;赠送</label>
                                        <select class="form-control" style="width: 25%;padding: 0 0 0 5px;" ng-model="modifyGiveType">
                                            <option value="d">天数</option>
                                            <option value="m">月数</option>
                                        </select>
                                        <input type="text" name="give_month" id="exampleInput113" ng-model="modifyGiveMonth" class="form-control" checknum autocomplete="off" placeholder="请输入赠送数" style="width: 35%;"/>
                                    </div>
                                    <div class="col-sm-4 pd0 form-group formSmbox mB40">
                                        <label for="exampleInput114"><span style="visibility: hidden">*</span>&emsp;&emsp;折扣</label>
                                        <input  type="text" name="cabinet_dis" id="exampleInput114" ng-model="modifyDis" class="form-control w200" placeholder="请输入折扣" autocomplete="off"/>
                                        <p class="help-block">
                                            <i class="glyphicon glyphicon-info-sign"></i>多个折扣用<span class="text-info">"/"</span>分开,例如<span class="text-info"> (八折,七折,六折)</span>: <span class="text-success">0.8/0.7/0.6</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!--新增多月设置容器 --end-->
							<span class="help-blocks">
								<button id="addCabMonth" class="btn btn-default btn-sm" venuehtml ng-click="btnAddMoreMonth()">
									<span class="glyphicon glyphicon-arrow-up"></span>
								  新增多月设置
								</button>
							</span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button ng-click="typeModifyComplete($id, modifyCabinetNum)" ladda="CabinetDetailFlag" type="button" class="btn btn-success w100" >完成</button>
            </div>
        </div>
    </div>
</div>