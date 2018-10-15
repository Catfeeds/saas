<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/4 0004
 * Time: 18:00
 */
 -->
<div class="modal fade" tabindex="-1" role="dialog" id="classCountModal" >
    <div class="modal-dialog" role="document" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">会员上课统计</h4>
            </div>
            <div class="modal-body">
            <!--筛选框和搜索框-->
                <div class="row" style="padding-bottom: 20px;">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6 pdL0">
                        <div class="input-daterange input-group cp">
                            <span class="add-on input-group-addon">选择日期</span>
                            <input type="text" readonly name="reservation" id="classCountDate" class="form-control text-center userSelectTime " style="width: 100%">
                        </div>
                    </div>
                   <!-- <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0">
                        <select class="form-control cardSelectCss" id="classCountType" ng-model="classCountType">
                            <option value="">课程分类</option>
                            <option value="1">瑜伽</option>
                            <option value="2">舞蹈</option>
                            <option value="3">健身</option>
                            <option value="4">其他</option>
                        </select>
                    </div>-->
                   <!-- <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0">
                        <select class="form-control cardSelectCss" id="classCountName" ng-model="classCountName">
                            <option value="">课程名称</option>
                            <option value="1">有效会员</option>
                            <option value="2">到期会员</option>
                        </select>
                    </div>-->
                    <div class="col-lg-6 col-md-5 col-sm-5 col-xs-5">
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="classCountKeywords" placeholder="请输入会员姓名或手机号或课程名称进行搜索..." style="width: 100%;height: 30px;">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button" ng-click="searchOneClassBtn()" style="padding-bottom: 4px;padding-top: 4px">搜索</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-1 col-sm-1 col-xs-1">
                        <!--<button class="btn btn-small btn-info" style="padding-top: 4px;padding-bottom: 4px">确定</button>-->
                        <button class="btn btn-small btn-default" style="padding-top: 4px;padding-bottom: 4px" ng-click="clearClassCount()">清空</button>
                    </div>
                </div>
               <!-- <div class="row" style="padding-top: 20px;padding-bottom: 20px;border-bottom: 1px solid #e5e5e5">
                    <div class="col-lg-6 col-lg-offset-3">
                        <div class="input-group">
                            <input type="text" class="form-control" ng-model="classCountKeywords" placeholder="请输入会员姓名或手机号或课程名称进行搜索..." style="width: 100%;height: 34px;">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button" ng-click="searchOneClassBtn()">搜索</button>
                            </span>
                        </div>
                    </div>
                </div>-->
            <!--列表开始-->
                <div class="row" style="overflow-y: scroll;height: 400px;">
                    <table class="table table-striped  table-bordered" >
                        <thead>
                        <tr>
                            <th>姓名</th>
                            <th>性别</th>
                            <th>手机号</th>
                            <th>卡号</th>
                            <th>课程分类</th>
                            <th>课程名称</th>
                            <th>上课时间</th>
                            <th>教练</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="i in classCountDetailList">
                            <td>{{i.member_name | noData:''}}</td>
                            <td>
                                <span ng-if="i.sex == 1">男</span>
                                <span ng-if="i.sex == 2">女</span>
                                <span ng-if="i.sex != 1 && i.sex != 2">无</span>
                            </td>
                            <td>{{i.mobile | noData:''}}</td>
                            <td>{{i.card_number | noData:''}}</td>
                            <td>{{i.course_name | noData:''}}</td>
                            <td>{{i.class_name | noData:''}}</td>
                            <td>{{i.start * 1000 | date:'yyyy-MM-dd HH:mm'}}</td>
                            <td>{{i.pName | noData:''}}</td>
                            <td>
                                <button class="btn btn-default" ng-click="getMemberDataCardBtn(i.member_id)">查看详情</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/pagination.php',['page'=>'classCountPage']);?>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'classCountNoData','text'=>'暂无信息','href'=>true]);?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
