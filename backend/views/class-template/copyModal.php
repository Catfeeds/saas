<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/21 0021
 * Time: 19:33
 */
-->
<!--复制模态框-->
<div class="modal fade" tabindex="-1" role="dialog" id="copyModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">复制模板</h4>
            </div>
            <div class="modal-body">
               <div class="row" style="margin: 20px auto">
                   <div class="col-md-12">
                       <div class="col-md-4 text-right pd0">
                           <span class="red lH30">*</span>模板名称
                       </div>
                       <div class="col-md-6">
                           <input type="text" class="form-control copyName" placeholder="请输入名称，最多10位" ng-model="copyName">
                       </div>
                   </div>
               </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success w100" ng-click="copySuccessBtn()">完成</button>
            </div>
        </div>
    </div>
</div>
