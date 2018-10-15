<!--    添加新的区域模态框-->
<div class="modal fade" id="addArea" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" >
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">添加新的区域</h4>
            </div>
            <div class="modal-body row">
                <form class="form-horizontal">
                    <div class="form-group addAreaModalContent" >
                        <label for="inputText" class="col-sm-4 control-label addAreaModalLabel" >
                            <span class="red">*</span>区域名称
                        </label>
                        <div class="col-sm-8">
                            <input type="text" ng-model="areaName"  class="form-control" id="inputText" placeholder="请输入区域名称">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button ng-click="addNewArea()" ladda="addAreaButtonFlag" type="button" class="btn btn-success w100" >完成</button>
            </div>
        </div>
    </div>
</div>