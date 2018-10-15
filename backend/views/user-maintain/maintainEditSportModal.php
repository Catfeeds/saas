<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/4 0004
 * Time: 10:19
 */
 -->
<!--新增和修改健身目标模态框-->
<div class="modal fade" id="maintainEditSport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-center"  ng-model="strs">{{strs}}</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 myModal2DivBox">
                        <div class="col-sm-12">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"><span class="formInlineAddSpan">*</span>健身目标&nbsp;</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control"  placeholder="请输入健身目标" ng-model="fitnessGoal" id="fitnessGoal">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label"><span class="formInlineAddSpan">*</span>发送内容&nbsp;</label>
                                    <div class="col-sm-8">
                                       <!-- <input type="text" class="form-control" >-->
                                        <textarea class="form-control" rows="3" ng-model="fitnessContent" id="fitnessContent"></textarea>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px;">关闭</button>
                <button class="btn btn-success pull-right" ladda="potentialMemberButtonFlag"  style="width: 100px;" ng-click="sendMessage(scenarios,fitnessGoal,content)">
                    完成
                </button>
            </div>
        </div>
    </div>
</div>