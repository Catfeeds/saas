<?php
use backend\assets\ApprovalManagementAsset;
ApprovalManagementAsset::register($this);
$this->title = '我发起的';
?>
<main ng-controller="myLaunchApprovalCtrl" ng-cloak>
    <section class="tab-content bgWhite" style="min-width: 720px;">
        <!--列表渲染-->
        <?= $this->render('@app/views/approval-management/approvalLists.php'); ?>
    </section>
    <!--详情-->
    <div id="pendingAuditDetailModal" class="modal fade"  role="dialog" style="overflow: auto;">
        <div class="modal-dialog" role="document" style="width: 430px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">发起详情</h4>
                </div>
                <!--详情内容重用-->
                <?= $this->render('@app/views/approval-management/approvalDetailModal.php'); ?>
                <div class="modal-footer">
                    <div class="row">
                        <ul class="col-sm-12 cp" style="display: flex;justify-content: space-around;align-items: center;" ng-if="approvalStatus132 == 1">
                            <li class="text-center col-sm-4 borderR detailBtnCss" ng-click="approvalDetailClick123()">详情</li>
                            <li  ng-click="approvalDetailRevokeClick()" class="text-center col-sm-4 detailBtnCss borderR">撤销</li>
                            <li ng-click="approvalDetailCommentClick()" class="text-center col-sm-4 detailBtnCss">评论</li>
                        </ul>
                        <ul class="col-sm-12 cp" style="display: flex;justify-content: space-around;align-items: center;" ng-if="approvalStatus132 != 1">
                            <li class="text-center col-sm-6 borderR detailBtnCss" ng-click="approvalDetailClick123()">详情</li>
                            <li ng-click="approvalDetailCommentClick()" class="text-center col-sm-6 detailBtnCss">评论</li>
                        </ul>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--    审批详情里面详情-->
    <?= $this->render('@app/views/approval-management/approvalCardDetailModal.php'); ?>

    <!--各种操作模态框（同意、拒绝、评论）-->
    <div id="operationModal" class="modal fade"  role="dialog" style="margin-top: 160px;">
        <div class="modal-dialog" role="document" style="width: 430px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">{{operationTitleName}}</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <textarea style="width: 100%; resize: none;text-indent: 1em;" rows="6" ng-model="content">

                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer contentCenter">
                    <button ng-if="approvalDetailCommentFlag123" type="button" class="btn btn-sm w100 btn-success" ladda="approvalDetailCommentButtonFlag"  ng-click="approvalDetailCommentButton()">评论</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!--撤销模态框（同意、拒绝、评论）-->
    <div id="RevokeModal" class="modal fade"  role="dialog" >
        <div class="modal-dialog" role="document" style="width: 430px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">撤回</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text-center">
                            <h2>你确定撤销申请吗？</h2>
                        </div>
                    </div>
                </div>
                <div class="modal-footer contentCenter">
                    <button  type="button" class="btn w100 btn-success" ladda="approvalDetailRevokeButtonFlag"  ng-click="approvalDetailRevokeButton()">确定</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


</main>
