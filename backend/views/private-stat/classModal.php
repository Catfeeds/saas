<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12 0012
 * Time: 18:56
 */
-->
<!--私教统计-上课-模态框-->
<div class="modal fade" role="dialog" id="classModal">
    <div class="modal-dialog classModalMain" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">{{classModalTitle}}</h4>
            </div>
            <div class="modal-body">
                <div class="row mr0 mb10">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="input-group">
                            <input type="text" class="form-control h34" placeholder="请输入姓名或手机号进行搜索..." ng-model="searchKeyword" ng-keydown="enterSearch()">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button" ng-click="searchClassBtn()">搜索</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row mr0 mb10">
                    <div class="col-md-2 pd0 mr10">
                        <select class="form-control  pd4 classModalSelect1">
                            <option value="{{v.id}}" ng-repeat="v in venueList">{{v.name}}</option>
                        </select>
                    </div>
                    <div class="col-lg-2 pd0 mr10">
                        <select class="form-control  pd4 classModalSelect2" id="classPrivateSelelct">
                            <option value="">私教</option>
                            <option value="{{p.id}}" ng-repeat="p in praviteList">{{p.name}}</option>
                        </select>
                    </div>
                    <div class="col-lg-2 pd0 mr10">
                        <select class="form-control  pd4 classModalSelect3" >
                            <option value="1">正式课</option>
                            <option value="2">体验课</option>
                        </select>
                    </div>
                    <div class="col-lg-3 pd0 mr10">
                        <input type="text" readonly name="reservation" id="classModalDate" class="form-control text-center" style="width: 100%;" placeholder="上课时间">
                    </div>
                    <div class="col-lg-2 pd0">
                        <button class="btn btn-info pd4" ng-click="searchClassBtn()">确定</button>
                        <button class="btn btn-default pd4" ng-click="clearClassBtn()">清空</button>
                    </div>
                </div>
                <div class="row mr0">
                    <table class="table table-hover" style="border-left:1px solid #ddd;border-right: 1px solid #ddd ">
                        <thead style="border-top:1px solid #ddd">
                        <tr>
                            <th>序号</th>
                            <th>会员姓名</th>
                            <th>性别</th>
                            <th>电话</th>
                            <th>私教</th>
                            <th>课程类别</th>
                            <th>课程</th>
                            <th>上课时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="(index,c) in classModalList">
                            <td>{{20 * (classModalNowPage - 1) + index + 1}}</td>
                            <td>{{c.name}}</td>
                            <td>
                                <span ng-if="c.sex == 1">男</span>
                                <span ng-if="c.sex == 2">女</span>
                                <span ng-if="c.sex != 1 && c.sex != 2">无</span>
                            </td>
                            <td>{{c.mobile}}</td>
                            <td>{{c.p_name | noData:''}}</td>
                            <td>
                                <span ng-if="c.course_type ==1">正式课</span>
                                <span ng-if="c.course_type ==2">体验课</span>
                            </td>
                            <td>{{c.c_name | noData:''}}</td>
                            <td>{{c.start * 1000 | date:'yyyy-MM-dd HH:mm'}} ~ {{c.end * 1000 | date:'HH:mm'}}</td>
                            <td>
                                <button class="btn btn-default" ng-click="getMemberDataCardBtn(c.member_id)">查看详情</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'classModalNoData','text'=>'暂无数据','href'=>true]);?>
                    <?=$this->render('@app/views/common/pagination.php',['page'=>'classModalPage']);?>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row mr0 orange">
                    <div class="col-md-12">
                        <p>上课节数：{{totalCount}}节</p>
                        <p>上课人数：{{totalMember}}人</p>
                        <button type="button" class="btn btn-default w100 fr" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>