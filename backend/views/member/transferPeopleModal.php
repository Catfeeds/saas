<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/15 0015
 * Time: 14:27
 * 转移模态框
 */
 -->
<!--会员卡转移模态框-->
<div class="modal" id="transferPeopleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">转移</h4>
            </div>
            <div class="modal-body">
                <div style="text-align: center">
                    <img src="../plugins/user/images/info.png">
                </div>
                <p style="font-size: 20px;color: #999;margin: 20px;text-align: center">本操作将会把&nbsp;{{transferCardName}}&nbsp;转移给指定会员</p>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        <label for="serialNumInput">
                            <span style="color: red;line-height: 26px">*</span>会员编号
                        </label>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control"  id="serialNumInput" ng-model="serialNumInput" ng-change="serialNumChange()" placeholder="请输入会员编号">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"  style="font-size: 12px;box-shadow: none;padding: 5.6px 16px;" ng-click="searchTransferBtn()">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 10px;margin-bottom: 10px;">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        <label for="transferMemberName" style="line-height: 26px;">
                            <span style="color: #ffffff;line-height: 26px">*</span>会员姓名
                        </label>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group" style="width: 100%">
                            <input type="text" id="transferMemberName" class="form-control" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-2">
                        <label for="transferVenueName" style="line-height: 26px;text-align: right">
                            <span style="color: #ffffff;line-height: 26px">*</span>所属场馆
                        </label>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group" style="width: 100%">
                            <input type="text" id="transferVenueName" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success" ng-disabled="!successBtnStatus" ng-click="transferSuccessBtn()">确定</button>
            </div>
        </div>
    </div>
</div>