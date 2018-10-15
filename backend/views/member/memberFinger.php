<!-- 验证指纹-->
<div id="box" class="box" style="display: none;">
    <h2>指纹登记</h2>
    <div class="list">
        <canvas id="canvas" width="430" height="450"
                style="background: rgb(243, 245, 240)"></canvas>
        <input type="hidden" id="whetherModify" name="whetherModify" alt=""
               value="111" />

        <div
            style="position: absolute; left: 310px; top: 325px; width: 70px; height: 28px;">
            <button type="button" class="btn btn-success btn-sm button-form" id="submitButtonId" name="makeSureName"
                    onclick="submitEvent()">确定</button>
            <!-- ${common_edit_ok}:确定 -->
        </div>
        <div
            style="position: absolute; left: 310px; top: 365px; width: 70px; height: 28px;">
            <button type="button" class="btn btn-info  btn-sm button-form" type="button" id="closeButton"
                    name="closeButton" onclick='cancelEvent("确认保存当前修改吗?", "指纹数:");'>
                取消</button>
            <!-- ${common_edit_cancel}:取消 -->
        </div>
    </div>
</div>
<div ng-if="MemberDetailsUpdate == '暂无数据'">
    <div class="modal fade a3" id="myModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content a22">
                <div style="border: none;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>

                    <h3 class="text-center a23" id="myModalLabel">
                        修改会员信息
                    </h3>
                    <div>
                        操作错误（未获取修改用户id）
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>