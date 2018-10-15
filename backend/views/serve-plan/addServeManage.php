<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center colorGreen" id="myModalLabel" >
                    添加服务
                </h3>
            </div>
            <div class="modal-body text-center" style="margin-top: 25px;">
                <div class="form-group mL120 color999" style="display: inline-block;margin-left: 0;">
                    服务名称<span class="red">*</span>：&nbsp;&nbsp;</div>
                <div class="form-group text-center mL120" style="display: inline-block;margin-left: 0;">
                    <input type="text" ng-model="name" value="" class="form-control actions w300" id=""
                           placeholder="服务名称">
                </div>
            </div>
            <div class="modal-footer">
                <!--                <button type="button" class="btn btn-success  btn-lg wB50"-->
                <button type="button" class="btn btn-success" style="width: 60px;"
                        ng-click="addServer()">完成
                </button>
            </div>
        </div>
    </div>
</div>