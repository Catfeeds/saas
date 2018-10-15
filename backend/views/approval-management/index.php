<?php
use backend\assets\ApprovalManagementAsset;
ApprovalManagementAsset::register($this);
$this->title = '审核管理';
?>
<main ng-controller="approvalManagementCtrl" ng-cloak>
    <?=$this->render('@app/views/common/csrf.php')?>
    <section class="tab-content bgWhite"  style="min-width: 720px;">
        <!--列表,筛选渲染-->
        <?= $this->render('@app/views/approval-management/approvalLists.php'); ?>
    </section>
    <!--详情-->
    <div id="pendingAuditDetailModal" class="modal fade"  role="dialog" style="overflow: auto;">
        <div class="modal-dialog" role="document" style="width: 430px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">待审批详情</h4>
                </div>
                <!--详情内容重用-->
                <?= $this->render('@app/views/approval-management/approvalDetailModal.php'); ?>
                <div class="modal-footer">
                    <div class="row">
                        <ul class="col-sm-12 cp" style="display: flex;justify-content: space-around;align-items: center;">
                            <li ng-click="approvalDetailClick123()"  class="text-center col-sm-3 borderR detailBtnCss">详情</li>
                            <li ng-click="approvalDetailAgreeClick()" ng-if="itemOne.status == 1 " class="text-center col-sm-3 borderR detailBtnCss">同意</li>
                            <li ng-click="approvalDetailRefuseClick()" ng-if="itemOne.status == 1" class="text-center col-sm-3 borderR detailBtnCss">拒绝</li>
                            <li ng-click="approvalDetailCommentClick()" class="text-center col-sm-3 detailBtnCss">评论</li>
                        </ul>
<!--                        <ul ng-if="!approvalTypeFlag" class="col-sm-12 cp" style="display: flex;justify-content: space-around;align-items: center;">-->
<!--                            <li ng-click="approvalDetailClick123()"  class="text-center col-sm-6 borderR detailBtnCss">详情</li>-->
<!--                            <li ng-click="approvalDetailCommentClick()" class="text-center col-sm-6 detailBtnCss">评论</li>-->
<!--                        </ul>-->
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
                            <textarea id="contentBox123" style="width: 100%; resize: none;text-indent: 1em;" rows="6" ng-model="content">

                            </textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer contentCenter">
                    <button ng-if="approvalDetailAgreeFlag123" type="button" class="btn  w100 btn-success" ladda="approvalDetailAgreeButtonFlag"  ng-click="approvalDetailAgreeButton()">同意</button>
                    <button ng-if="approvalDetailRefuseFlag123" type="button" class="btn  w100 btn-success" ladda="approvalDetailRefuseButtonFlag"  ng-click="approvalDetailRefuseButton()">拒绝</button>
                    <button ng-if="approvalDetailCommentFlag123" type="button" class="btn  w100 btn-success" ladda="approvalDetailCommentButtonFlag"  ng-click="approvalDetailCommentButton()">评论</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</main>
