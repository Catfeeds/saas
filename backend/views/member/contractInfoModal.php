<!--
/**
 * Created by zhujunzhe@itsport.club
 * User: Administrator
 * Date: 2018/3/31 0031
 * Time: 11:05
 */
 -->
<!--会员协议模态框-->
<div class="modal fade" id="contractInfoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 60%">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center" id="myModalLabel">会员协议</h4>
            </div>
            <div class="modal-body">
                <span ng-if="contentTeach == ''">暂无数据</span>
                <span ng-if="contentTeach != ''" ng-bind-html="contentTeach | to_Html"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px;">关闭</button>
            </div>
        </div>
    </div>
</div>