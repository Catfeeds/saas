<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/4 0004
 * Time: 18:00
 */
 -->
<!--卡种统计详情模态框-->
<div class="modal fade" tabindex="-1" role="dialog" id="cardCountModal">
    <div class="modal-dialog" role="document" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">会员卡种统计</h4>
            </div>
            <div class="modal-body">
            <!--筛选框和搜索框-->
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-8 col-xs-6 pdL0">
                        <div class="input-daterange input-group cp">
                            <span class="add-on input-group-addon">选择日期</span>
                            <input type="text" readonly name="reservation" id="cardCountDate" class="form-control text-center userSelectTime " style="width: 100%">
                        </div>
                    </div>
                    <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0">
                        <select class="form-control cardSelectCss" ng-model="cardCountKind" id="cardCountKind">
                            <option value="">卡种</option>
                            <option value="1">时间卡</option>
                        </select>
                    </div>
                    <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0">
                        <select class="form-control cardSelectCss" ng-model="cardCountType" id="cardCountType">
                            <option value="">卡种类型</option>
                            <option value="1">瑜伽</option>
                            <option value="2">健身</option>
                            <option value="3">舞蹈</option>
                            <option value="4">综合</option>
                        </select>
                    </div>
                   <!-- <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0">
                        <select class="form-control cardSelectCss" ng-model="cardCountName" id="cardCountName">
                            <option value="">卡名称</option>
                            <option value="1">有效会员</option>
                            <option value="2">到期会员</option>
                        </select>
                    </div>-->
                    <div class="col-lg-2">
                      <!--  <button class="btn btn-small btn-info" style="padding-top: 4px;padding-bottom: 4px">确定</button>-->
                        <button class="btn btn-small btn-default" style="padding-top: 4px;padding-bottom: 4px" ng-click="clearCardCount()">清空</button>
                    </div>
                </div>
                <div class="row" style="padding-top: 20px;padding-bottom: 20px;border-bottom: 1px solid #e5e5e5">
                    <div class="col-lg-6 col-lg-offset-3">
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="cardCountKeywords" placeholder="请输入会员姓名或手机号进行搜索..." style="width: 100%;height: 34px;">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button" ng-click="searchOneCardBtn()">搜索</button>
                            </span>
                        </div>
                    </div>
                </div>
            <!--列表开始-->
                <div class="row">
                    <table class="table table-striped  table-bordered" >
                        <thead>
                        <tr>
                            <th>会员卡</th>
                            <th>卡种</th>
                            <th>卡种类型</th>
                            <th>进场时间</th>
                            <th>姓名</th>
                            <th>性别</th>
                            <th>手机号</th>
                            <th>卡号</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="i in cardCountDetailList">
                            <td>{{i.card_name | noData:''}}</td>
                            <td>{{i.type_name | noData:''}}</td>
                            <td>
                                <span ng-if="i.type == 1">瑜伽</span>
                                <span ng-if="i.type == 2">舞蹈</span>
                                <span ng-if="i.type == 3">健身</span>
                                <span ng-if="i.type == 4">综合</span>
                                <span ng-if="i.type == null">暂无数据</span>
                            </td>
                            <td>{{i.entry_time * 1000 | date:'yyyy-MM-dd HH:mm'}}</td>
                            <td>{{i.name | noData:''}}</td>
                            <td>
                                <span ng-if="i.sex == 1">男</span>
                                <span ng-if="i.sex == 2">女</span>
                                <span ng-if="i.sex != 1 && i.sex != 2">无</span>
                            </td>
                            <td>{{i.mobile | noData:''}}</td>
                            <td>{{i.card_number | noData:''}}</td>
                            <td>
                                <button class="btn btn-default" ng-click="getMemberDataCardBtn(i.member_id)">查看详情</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/pagination.php',['page'=>'cardCountPage']);?>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'cardCountNoData','text'=>'暂无信息','href'=>true]);?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
