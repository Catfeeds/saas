<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/04/02 0015
 * Time: 14:27
 * 修改定金信息模态框
 */
 -->
<!--会员信息记录-修改定金信息模态框-->
<div class="modal" id="updateDepositModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">修改定金信息</h4>
            </div>
            <div class="modal-body">
                <div class="row ">
                    <?=$this->render('@app/views/common/csrf.php')?>
                    <div class="form-group  col-sm-12  mT20 centerHeight">
                        <div class="col-sm-4  text-right">
                            <div for="recipient-name" class="control-label"><span class="red">*</span>定金类型:</div>
                        </div>
                        <div class="col-sm-6 pd0" >
                            <select  class="form-control" ng-model="updateDepositType"  ng-change="updateDepositTypeChange(updateDepositType)" style="padding: 4px 12px;">
                                <option value="1" ng-if="updateCardTypeStatus">购卡定金</option>
                                <option value="2" ng-if="!updateCardTypeStatus">购课定金</option>
                                <option value="3" ng-if="updateCardTypeStatus">续费定金</option>
                                <option value="4" ng-if="updateCardTypeStatus">卡升级定金</option>
                                <option value="5" ng-if="!updateCardTypeStatus">课升级定金</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group  col-sm-12   mT20 centerHeight">
                        <div class="col-sm-4   text-right">
                            <div for="recipient-name" class="control-label"><span class="red">*</span>金额:</div>
                        </div>
                        <div class="col-sm-6 pd0">
                            <input type="number" inputnum  ng-model="updatePrice" id="updatePrice" autocomplete="off"  class="form-control"  placeholder="请输入金额">
                        </div>
                    </div>
                    <div class="form-group  col-sm-12  mT20 centerHeight">
                        <div class="col-sm-4  text-right">
                            <div for="recipient-name" class="control-label"><span class="red">*</span>有效期:</div>
                        </div>
                        <div class="col-sm-6 pd0" >
                            <div  class=" input-daterange input-group"  style="width: 100%;">
                                <input type="text"  readonly name="reservation" id="updateDepositDate" class=" form-control " value="" placeholder="选择时间" style="background-color: #ffffff"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group  col-sm-12  mT20 centerHeight">
                        <div class="col-sm-4  text-right">
                            <div for="recipient-name" class="control-label"><span class="red">*</span>付款方式:</div>
                        </div>
                        <div class="col-sm-6 pd0" >
                            <select  class="form-control"  style="padding: 4px 12px;" ng-model="updatePayType">
                                <option value="">请选择</option>
                                <option value="1">现金</option>
                                <option value="3">微信</option>
                                <option value="2">支付宝</option>
                                <option value="5">建设分期</option>
                                <option value="6">广发分期</option>
                                <option value="7">招行分期</option>
                                <option value="8" >借记卡</option>
                                <option value="9" >贷记卡</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group  col-sm-12  mT20 centerHeight">
                        <div class="col-sm-4  text-right">
                            <div for="recipient-name" class="control-label"><span class="red">*</span>
                                <span ng-if="updateDepositType == 2 || updateDepositType == 5">选择私教:</span>
                                <span ng-if="updateDepositType != 2 && updateDepositType != 5">选择销售:</span>
                            </div>
                        </div>
                        <div class="col-sm-6 pd0" >
                            <select ng-model="updateSellName" disabled="disabled" class="form-control" style="padding: 4px 12px;">
                                <option value="" ng-if="updateDepositType == 2 || updateDepositType == 5 ">请选择私教</option>
                                <option value="" ng-if="updateDepositType != 2 && updateDepositType != 5 ">请选择销售</option>
                                <option value="{{sale.id}}" ng-repeat="sale in saleInfo">{{sale.name}}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success w100" ng-click="updateDepositBtn()">确定</button>
            </div>
        </div>
    </div>
</div>