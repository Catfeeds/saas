<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/30 0030
 * Time: 10:28
 */
-->
<div class="modal fade" tabindex="-1" role="dialog" id="assessChildDetailModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">详情</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 mB10">
                        <div class="col-md-4">项目名称：</div>
                        <div class="col-md-8">{{detailAssessPro}}</div>
                    </div>
                    <div class="col-md-8 col-md-offset-2 mB10">
                        <div class="col-md-4">单位：</div>
                        <div class="col-md-8">{{detailAssessUnit | noData : ''}}</div>
                    </div>
                    <div class="col-md-8 col-md-offset-2 mB10">
                        <div class="col-md-4">正常范围：</div>
                        <div class="col-md-8">{{detailAssessRange | noData : ''}}</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>