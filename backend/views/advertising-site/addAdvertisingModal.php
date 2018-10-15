<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/5 0005
 * Time: 14:51
 */
 -->
<!--新建广告模态框-->
<div class="modal fade" tabindex="-1" role="dialog" id="addAdvertisingModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">新建广告</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <ul class="col-sm-12"  >
                        <li class="col-sm-12">
                            <div class="col-sm-4 text-right"><span class="red" style="line-height: 30px;">*</span>广告名称</div>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" placeholder="请输入广告名称" ng-model="advertisingName">
                            </div>
                        </li>
                        <li class="col-sm-12  mT20">
                            <div  class="col-sm-4  text-right">备注</div>
                            <div  class="col-sm-7">
                                <textarea class="form-control" rows="3" ng-model="advertisingNote"></textarea>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success w100" ng-click="addSuccessBtn()">完成</button>
            </div>
        </div>
    </div>
</div>
