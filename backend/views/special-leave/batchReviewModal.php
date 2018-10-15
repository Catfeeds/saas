<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/11 0011
 * Time: 09:45
 */
-->
<!--批量审核请假模态框-->
<div class="modal fade" tabindex="-1" role="dialog" id="batchReviewModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">批量同意</h4>
            </div>
            <div class="modal-body">
               <div class="row">
                   <div class="col-md-12 text-center">
                       <img src="../plugins/user/images/info.png" style="width: 60px;height: 60px;">
                   </div>
                   <div class="col-md-6 col-md-offset-3">
                       <p style="font-size: 18px;text-align: center">本操作会把选中的&nbsp;<span style="color: orange">{{leaveMemberNum}}位</span>&nbsp;会员的请假申请全部通过</p>
                   </div>
               </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success w100" ng-click="agreeBtn()">确定</button>
            </div>
        </div>
    </div>
</div>