<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/28 0028
 * Time: 13:41
 */
-->
<!--课程内容设置详情模态框-->
<div class="modal fade" tabindex="-1" role="dialog" id="classDetailModal">
    <div class="modal-dialog" role="document" style="width: 40%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">详情</h4>
            </div>
            <div class="modal-body">
                <div class="row mr0">
                    <div class="col-md-12 pd0">
                        <div class="col-md-2 text-right pd0 lH30">课种：</div>
                        <div class="col-md-6 lH30">{{detailName}}</div>
                        <div class="col-md-4 text-right pd0">
                            <button class="btn btn-info w100" ng-click="modalUpdateBtn()">修改</button>
                        </div>
                    </div>
                </div>
                <div class="row mr0">
                    <div class="col-md-12 pd0" ng-repeat="($index,i) in  detailQuestion">
                        <div class="col-md-2 text-right pd0 lH30">问题{{$index + 1}}：</div>
                        <div class="col-md-10 col-md-offset-2  pd0 lH30">类别：
                            <span ng-if="i.type == 3">单选</span>
                            <span ng-if="i.type == 2">多选</span>
                            <span ng-if="i.type == 1">自定义答案</span>
                        </div>
                        <div class="col-md-10 col-md-offset-2  pd0 lH30">问题： {{i.title}}</div>
                        <div class="col-md-10 col-md-offset-2  pd0 lH30" ng-repeat="($index,w) in i.option">
                            选项{{$index + 1}}：{{w}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>