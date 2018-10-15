<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/4 0004
 * Time: 10:41
 */
 -->
<!--会员维护查看详情模态框-->
<div class="modal fade" id="maintainDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog maintainDetailsContent" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">详情</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form class="form-inline col-sm-12"">
                        <div class="form-group col-sm-12">
                            <label for="exampleInputName2" style="margin-right:22px;">目标体重</label>
                            <input type="text" ng-blur="checkNumber()" class="form-control" id="exampleInputName2" placeholder="请输入体重" ng-model="targetWeight" style="width:100px">kg
                        </div>
                        <div class="form-group col-sm-12" style="min-height:290px;margin-top:20px;">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="goals" style="margin-right:22px;">健身目标</label>
                                    <select class="form-control" id="goals" ng-model="fitnessGoalDataName" style="width: 180px;padding:0;text-indent: 8px;color:#999999;" ng-change="showData(fitnessGoalDataName)">
                                        <option value="">请选择健身目标</option>
                                        <option ng-repeat="i in fitnessGoalData1" value="{{i.id}}">{{ i.name }}</option>
                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="" style="margin-right:22px;color:#ffffff">健身目标</label>
                                    <textarea  class="form-control" rows="5" style="width:80%;margin-top:20px;" ng-model="fitnessGoalDataContent"></textarea>
                                </div>
                                <div class="col-lg-12">
                                    <button class="btn btn-success pull-right" ladda="potentialMemberButtonFlag" ng-disabled="notSentGoalBtn" ng-click="goalMessage()" style="width: 130px;margin:20px 0;margin-left: 10px">
                                        发送
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="plans" style="margin-right:22px;">饮食计划</label>
                                    <select class="form-control" id="plans" style="width: 180px;padding:0;text-indent: 8px;color:#999999;" ng-model="foodPlanDataName" ng-change="showData1(foodPlanDataName)">
                                        <option value="">请选择饮食计划</option>
                                        <option ng-repeat="x in fitnessGoalData2" value="{{x.id}}">{{ x.name }}</option>

                                    </select>
                                </div>
                                <div class="col-lg-12">
                                    <label for="plans" style="margin-right:22px;color:#ffffff">饮食计划</label>
                                    <textarea  rows="5" class="form-control" style="width:80%;margin-top:20px;" ng-model="foodPlanDataContent"></textarea>
                                </div>
                                <div class="col-lg-12"">
                                    <button class="btn btn-success pull-right" ladda="potentialMemberButtonFlag" ng-disabled="notSentFoodBtn" ng-click="planMessage()" style="width: 130px;margin:20px 0;margin-left: 10px">
                                        发送
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div style="height:300px;overflow-y: scroll;">
                        <!-- 会员维护详情列表-->
                        <table class="table table-hover  table-bordered" class="col-sm-12">
                            <thead >
                            <tr role="row" class="thDetails">
                                <th class="col-sm-2">发送类型</th>
                                <th class="col-sm-3">发送时间</th>
                                <th class="col-sm-7">发送内容</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat=" i in showMessages">
                                <td>{{i.name}}</td>
                                <td>{{i.send_time * 1000 | date:'yyyy-MM-dd'}}</td>
                                <td class="tdHh">{{i.content}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <?=$this->render('@app/views/common/nodata.php',['name'=>'detailNoData','text'=>'暂无数据','href'=>true]);?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px;margin:20px 0;">关闭</button>
                <button class="btn btn-info pull-right" ladda="potentialMemberButtonFlag" ng-click="storage()" style="width: 100px;margin:20px;">
                    保存
                </button>
            </div>
        </div>
    </div>
</div>