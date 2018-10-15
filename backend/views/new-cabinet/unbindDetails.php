<!--    未绑定详情模态框-->
<div class="modal fade" id="noBoundCabinet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document wB50" >
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel " >未绑定详情</h4>
            </div>
            <div class="modal-body row">
                <div class="col-sm-12 pd0">
                    <div class="col-sm-5 iconBox noNameBox" ng-click="clickBinding(cabinetDetailOne, cabinetDetailOne.cabinet_id)">
                        <img class="imgHeaderW100" ng-src="/plugins/checkCard/img/11.png" >
                        <p ng-if="cabinetDetailOne.cabinetType == 2" class="iconNoName">点击绑定会员</p>
                    </div>
                    <div class="col-sm-7">
                        <div class="col-sm-8 col-sm-offset-3 infoBox pT10 f14" >
                            <p class="cabinetName">{{cabinetDetailOne.cabinet_number | noData:''}}</p>
                            <p>单月金额: <span>{{cabinetDetailOne.monthRentPrice |number:2 | noData:''}}<span ng-if="cabinetDetailOne.monthRentPrice != null">元</span></span></p>
                            <p>押&emsp;&emsp;金: <span>{{cabinetDetailOne.deposit |number:2  | noData:''}}<span ng-if="cabinetDetailOne.deposit != null">元</span></span></p>
                            <p>多月金额: <span ng-if="muchMonthDetails.length == 0">暂无数据</span></p>
                            <p ng-if="muchMonthDetails.length > 0" ng-repeat="m in muchMonthDetails">{{ m }}<p/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <?php if (\backend\models\AuthRole::canRoleByAuth('cabinet', 'CABINETBINDUSER')) { ?>
                    <button type="button"  class="btn btn-sm btn-success" ng-disabled="bindCabinetType == 1" ng-click="clickBinding(cabinetDetailOne, cabinetDetailOne.cabinet_id)" >绑定用户</button>
                <?php } ?>
                <?php if (\backend\models\AuthRole::canRoleByAuth('cabinet', 'UPDATE')) { ?>
                    <button type="button" class="btn btn-info"  ng-click="editUnBinding(cabinetDetailOne.cabinet_id,'notBind')" data-toggle="modal" data-target="#revise">修改</button>
                <?php } ?>
                <?php if (\backend\models\AuthRole::canRoleByAuth('cabinet', 'DELETECABINET')) { ?>
                    <button type="button"  class="btn btn-sm btn-danger" ng-click="CabinetDelete(cabinetDetailOne.cabinet_id)">删除</button>
                <?php } ?>
                <button type="button" class="btn btn-default btn-md" data-toggle="modal" data-target="#noBoundCabinet">关闭</button>
            </div>
        </div>
    </div>
</div>