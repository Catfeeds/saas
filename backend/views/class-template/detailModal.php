<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/24 0024
 * Time: 18:51
 */
-->
<!--模板详情模态框-->
<div class="modal fade" tabindex="-1" role="dialog" id="detailModal">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">详情</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-info w100" ng-click="updateOneBtn()">修改</button>
                    </div>
                    <div class="col-md-12 mB10">
                        <div class="col-md-2 pd0 text-right">模板名称：</div>
                        <div class="col-md-9">{{detailTitle}}</div>
                    </div>
                    <div class="col-md-12 mB10">
                        <div class="col-md-2 pd0 text-right">模板描述：</div>
                        <div class="col-md-9">{{detailDescribe | noData:''}}</div>
                    </div>
                    <div class="col-md-12 mB10">
                        <div class="col-md-2 pd0 text-right lH28">模板分类：</div>
                        <div class="col-md-9">
                            <span class="lH28">{{detailC_title | noData:''}}</span>
                        </div>
                    </div>
                    <div class="col-md-12 mB10">
                        <div class="col-md-2 pd0 text-right">训练内容：</div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-default"  ng-repeat="($index,i) in detailStage">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-md-2">第{{$index + 1}}阶段</div>
                                        <div class="col-md-2">{{i.title}}</div>
                                        <div class="col-md-2" ng-if="i.length_time != '' && i.length_time != null">{{i.length_time}}分钟</div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row mB10" ng-repeat="($index,w) in i.main">
                                        <div class="col-md-2">第{{$index + 1}}项</div>
                                        <div class="col-md-3 pd0">动作名称：<span>{{w.title}}</span></div>
                                        <div class="col-md-3">数量：<span>{{w.number}}（组或分钟）</span></div>
                                    </div>
                                </div>
                            </div>
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