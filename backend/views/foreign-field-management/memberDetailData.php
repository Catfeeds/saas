<!-- 会员详情-->
<div class="modal fade in" id="membershipDetails" aria-hidden="true" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true" ng-click="cancelClose(3)">&times;</span></button>
                <h4 class="modal-title modalTitleCente" id="myModalLabel">预约场地</h4>
            </div>
            <div class="modal-body boxModal-body">
                <div class="row">
                    <form class="form-horizontal w500">
                        <input id="_csrf" type="hidden"
                               name="<?= \Yii::$app->request->csrfParam; ?>"
                               value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class=" col-sm-12">
                            <div class="imgBlock">
                                <div>
                                    <img
                                            ng-if="memberDetails.memberMessage.pic != null && memberDetails.memberMessage.pic !=undefined"
                                            ng-src="{{memberDetails.memberMessage.pic}}" class="headImg w50h50px">
                                    <img ng-src="/plugins/checkCard/img/11.png" class="w50h50px "
                                         ng-if="memberDetails.memberMessage.pic == null || memberDetails.memberMessage.pic ==undefined"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 modalTitleCente pt15px">
                            <div class="col-sm-6 textRigth">
                                <strong>姓名:</strong>
                            </div>
                            <div class="col-sm-6 textLeft">
                                <strong>{{memberDetails.memberMessage.username}}</strong>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 modalTitleCente ">
                            <div class="col-sm-6 textRigth">
                                <strong>会员编号:</strong>
                            </div>
                            <div class="col-sm-6 textLeft">
                                <strong>{{memberDetails.memberMessage.id}}</strong>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 modalTitleCente">
                            <div class="col-sm-6 textRigth">
                                <strong>手机号:</strong>
                            </div>
                            <div class="col-sm-6 textLeft">
                                <strong>{{memberDetails.memberMessage.mobile}}</strong>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                                <select ng-if="memberBool == false" class="form-control w160 cardIdYuyue"
                                        ng-model="memberCardId" style="padding: 4px;">
                                    <option value="{{w.memberCardId}}" ng-if="w.status != 3"
                                            ng-repeat="w in memberDetails.memberCard">
                                        {{w.card_name}}
                                    </option>
                                </select>
                                <select ng-if="memberBool == true" class="form-control w160 h31px">
                                    <option value="">暂无卡种</option>
                                </select>
                            </div>
                            <div class="col-sm-4"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" ng-disabled="memberBool"
                        class="btn btn-success w80 margin0auto displayBlock"
                        ng-click="memberReservationIsSuccessful()">完成
                </button>
            </div>
        </div>
    </div>
</div>