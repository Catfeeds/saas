<!--/**
 * Created by PhpStorm.
 * User: 付钟超
 * Date: 2018/1/30 0030
 * Time: 09:03
 * Content: 退柜设置模态框
 */-->
<div class="modal fade" id="quitCabinetSetting" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="">
        <div class="modal-content clearfix">
            <div class="modal-header text-center modal-title-words">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">退柜设置</h4>
            </div>
            <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 pdWidth40">
                        <form class="form-horizontal" style="text-align: center;margin-top: 30px;">
                            <div class="form-group">
                                    到期退款
                                    <input ng-model="setDays" type="text" inputnum placeholder="请输入天数" style="height: 28px;width: 200px;margin-left: 20px">
                                <div style="margin-left: 55px;margin-top: 5px;color: rgb(153,153,153);">
                                    <span class="fa fa-info-circle">到期多少天内可进行全额退款</span>
                                </div>
                            </div>
                            <div class="form-group">
                                超期扣费
                                <div style="display: inline-block">
                                <select id="getDateType"  style="height: 28px;width: 50px;position: relative;left: 20px;">
                                    <option value="everyDay">每日</option>
                                    <option value="everyWeek">每周</option>
                                    <option value="everyMonth">每月</option>
                                </select>
                                </div>
                                <input ng-model="setCost" type="text" inputnum placeholder="请输入扣除费用" style="height: 28px;width: 150px;margin-left: 20px">
                                <div style="margin-left: 28px;margin-top: 5px;color: rgb(153,153,153);">
                                    <span class="fa fa-info-circle">超过全额退款天数的扣费</span>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-success" ng-click="setQuitCabinetHttp()">完成</button>
            </div>
        </div>
    </div>
</div>