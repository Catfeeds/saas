<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/4 0004
 * Time: 18:00
 */
 -->
<!--客户来源渠道模态框-->
<div class="modal fade" tabindex="-1" role="dialog" id="trafficSourcesModal">
    <div class="modal-dialog" role="document" style="width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">客户各渠道来源</h4>
            </div>
            <div class="modal-body">
            <!--筛选框和搜索框-->
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 pdL0">
                        <div class="input-daterange input-group cp">
                            <span class="add-on input-group-addon">选择日期</span>
                            <input type="text" readonly name="reservation" id="trafficSourcesDate" class="form-control text-center userSelectTime " style="width: 100%">
                        </div>
                    </div>
                    <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0">
                        <select class="form-control selectCssPd" id="trafficSourcesSelect" ng-model="trafficSourcesSelect">
                            <option value="">来源渠道</option>
                            <option value="{{w.id}}" ng-repeat="w in trafficTypeList">{{w.value}}</option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-7 col-sm-6 col-xs-6 pdL0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="请输入姓名或手机号..." style="width: 100%;" ng-model="trafficSourcesKeywords">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button" style="padding-top: 4px;padding-bottom: 4px" ng-click="searchTrafficSources()">搜索</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-3 col-sm-4 col-xs-6 pdL0">
                        <button class="btn btn-small btn-default" style="padding-top: 4px;padding-bottom: 4px" ng-click="clearTrafficSources()">清空</button>
                    </div>
                </div>
            <!--列表开始-->
                <div class="row" style="margin-top: 20px;">
                    <table class="table table-striped  table-bordered" >
                        <thead>
                        <tr>
                            <th>姓名</th>
                            <th>性别</th>
                            <th>手机号</th>
                            <th>来源渠道</th>
                            <th>注册时间</th>
                            <!--<th>操作</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="i in trafficDetailList">
                            <td>{{i.name}}</td>
                            <td>
                                <span ng-if="i.sex == 1">男</span>
                                <span ng-if="i.sex == 2">女</span>
                                <span ng-if="i.sex != 1 && i.sex != 2">无</span>
                            </td>
                            <td>{{i.mobile | noData:''}}</td>
                            <td>{{i.value | noData:''}}</td>
                            <td>{{i.register_time *1000 | date:'yyyy-MM-dd HH:mm'}}</td>
                            <!--<td>
                                <button class="btn btn-default">查看详情</button>
                            </td>-->
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/pagination.php',['page'=>'trafficSourcesPage']);?>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'trafficSourcesNoData','text'=>'暂无信息','href'=>true]);?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>