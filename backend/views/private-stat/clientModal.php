<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/12 0012
 * Time: 10:08
 */
-->
<!--私教统计-客户-模态框-->
<div class="modal fade"  role="dialog" id="clientModal">
    <div class="modal-dialog  clientModalMain" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">{{modalTitle}}</h4>
            </div>
            <div class="modal-body">
                <div class="row mr0 mb10">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="input-group">
                            <input type="text" class="form-control h34" placeholder="请输入姓名或手机号进行搜索..." ng-model="searchKeyword" ng-keydown="enterSearch()">
                                <span class="input-group-btn">
                                <button class="btn btn-success" type="button" ng-click="searchBtn()">搜索</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row mr0">
                    <div class="col-lg-2 col-md-3 pd0 mr10 mb10">
                        <select class="form-control  pd4 modalSelect0">
                            <option value="{{v.id}}" ng-repeat="v in venueList">{{v.name}}</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2 pd0 mr10 mb10" ng-if="show1">
                        <select class="form-control  pd4 pl4 modalSelect1">
                            <option value="">会员类别</option>
                            <option value="1">潜在客户</option>
                            <option value="2">正式客户</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2 pd0 mr10 mb10" ng-if="show1">
                        <select class="form-control  pd4 modalSelect3">
                            <option value="">性别</option>
                            <option value="1">男</option>
                            <option value="2">女</option>
                            <option value="3">其他</option>
                        </select>
                    </div>
                    <!--<div class="col-lg-1 col-md-2 pd0 mr10 mb10" ng-if="show1">
                        <select class="form-control  pd4 modalSelect4">
                            <option value="">来源</option>
                        </select>
                    </div>-->
                    <div class="col-lg-2 col-md-2 pd0 mr10 mb10" ng-if="!show1">
                        <select class="form-control  pd4 modalSelect5" id="privateSelect">
                            <option value="">私教</option>
                            <option value="{{p.id}}" ng-repeat="p in praviteList">{{p.name}}</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2 pd0 mr10 mb10" ng-if="show2">
                        <select class="form-control  pd4 modalSelect6">
                            <option value="3">最近3天</option>
                            <option value="7">最近7天</option>
                            <option value="14">最近14天</option>
                            <option value="30">最近30天</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2 pd0 mr10 mb10" ng-if="show3">
                        <select class="form-control  pd4 modalSelect7">
                            <option value="">最近未跟进</option>
                            <option value="3">最近3天</option>
                            <option value="7">最近7天</option>
                            <option value="14">最近14天</option>
                            <option value="30">最近30天</option>
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-2 pd0 mr10 mb10" ng-if="show4">
                        <select class="form-control  pd4 modalSelect8">
                            <option value="">剩余节数</option>
                            <option value="1">剩余1节</option>
                            <option value="3">剩余3节</option>
                            <option value="5">剩余5节</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 pd0 mr10 mb10" ng-show="show4">
                        <input type="text" readonly id="expireDate" class="form-control text-center" style="width: 100%;" placeholder="到期时间">
                    </div>
                    <div class="col-lg-3 col-md-3 pd0 mr10 mb10" ng-show="show6">
                        <input type="text" readonly id="donateDate" class="form-control text-center" style="width: 100%;" placeholder="赠送时间">
                    </div>
                    <div class="col-lg-2 col-md-3 pd0">
                        <button class="btn btn-info pd4" ng-click="searchBtn()">确定</button>
                        <button class="btn btn-default pd4" ng-click="clearSearchBtn()">清空</button>
                    </div>
                </div>
                <div class="row mr0" ng-if="show1">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>会员姓名</th>
                            <th>性别</th>
                            <th>电话</th>
                            <!--<th>私教来源</th>-->
                            <!--<th>最近跟进时间</th>-->
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="(index,t1) in tabList1">
                            <td>{{20 * (nowPage1 - 1) + index + 1}}</td>
                            <td>{{t1.name | noData:''}}</td>
                            <td>
                                <span ng-if="t1.sex == 1">男</span>
                                <span ng-if="t1.sex == 2">女</span>
                                <span ng-if="t1.sex != 1 && t1.sex != 2">无</span>
                            </td>
                            <td>{{t1.mobile | noData:''}}</td>
                            <!--<td>转介绍</td>-->
                            <!--<td>2018-06-01</td>-->
                            <td>
                                <button class="btn btn-default" ng-click="getMemberDataCardBtn(t1.id)">查看详情</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'tab1NoData','text'=>'暂无数据','href'=>true]);?>
                    <?=$this->render('@app/views/common/pagination.php',['page'=>'tab1Page']);?>
                </div>
                <div class="row mr0" ng-if="show2">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>会员姓名</th>
                            <th>性别</th>
                            <th>电话</th>
                            <th>私教</th>
                            <th>最近上课时间</th>
                            <th>课种</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="(index,t2) in tabList2">
                            <td>{{20 * (nowPage2 - 1) + index + 1}}</td>
                            <td>{{t2.name | noData:''}}</td>
                            <td>
                                <span ng-if="t2.sex == 1">男</span>
                                <span ng-if="t2.sex == 2">女</span>
                                <span ng-if="t2.sex != 1 && t2.sex != 2">无</span>
                            </td>
                            <td>{{t2.mobile | noData:''}}</td>
                            <td>{{t2.p_name | noData:''}}</td>
                            <td>
                                <span ng-if="t2.time == '' || t2.time == null">暂无数据</span>
                                <span ng-if="t2.time != '' && t2.time != null">
                                    {{t2.time *1000 | date:'yyyy-MM-dd'}}
                                </span>
                            </td>
                            <td>{{t2.c_name | noData:''}}</td>
                            <td>
                                <button class="btn btn-default" ng-click="getMemberDataCardBtn(t2.member_id)">查看详情</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'tab2NoData','text'=>'暂无数据','href'=>true]);?>
                    <?=$this->render('@app/views/common/pagination.php',['page'=>'tab2Page']);?>
                </div>
                <div class="row mr0" ng-if="show3">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>会员姓名</th>
                            <th>性别</th>
                            <th>电话</th>
                            <!--<th>私教来源</th>-->
                            <th>私教</th>
                            <th>最近跟进时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="(index,t3) in tabList3">
                            <td>{{20 * (nowPage3 - 1) + index + 1}}</td>
                            <td>{{t3.name | noData:''}}</td>
                            <td>
                                <span ng-if="t3.sex == 1">男</span>
                                <span ng-if="t3.sex == 2">女</span>
                                <span ng-if="t3.sex != 1 && t3.sex != 2">无</span>
                            </td>
                            <td>{{t3.mobile | noData:''}}</td>
                            <!--<td>转介绍</td>-->
                            <td>{{t3.p_name | noData:''}}</td>
                            <td>
                                <span ng-if="t3.actual_time == '' || t3.actual_time == null">暂无数据</span>
                                <span ng-if="t3.actual_time != '' && t3.actual_time != null">
                                    {{t3.actual_time *1000 | date:'yyyy-MM-dd'}}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-default" ng-click="getMemberDataCardBtn(t3.id)">查看详情</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'tab3NoData','text'=>'暂无数据','href'=>true]);?>
                    <?=$this->render('@app/views/common/pagination.php',['page'=>'tab3Page']);?>
                </div>
                <div class="row mr0" ng-if="show4">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>会员姓名</th>
                            <th>性别</th>
                            <th>电话</th>
                            <th>私教</th>
                            <th>课种</th>
                            <th>剩余/总节数</th>
                            <th>到期时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="(index,t4) in tabList4">
                            <td>{{20 * (nowPage4 - 1) + index + 1}}</td>
                            <td>{{t4.name}}</td>
                            <td>
                                <span ng-if="t4.sex == 1">男</span>
                                <span ng-if="t4.sex == 2">女</span>
                                <span ng-if="t4.sex != 1 && t4.sex != 2">无</span>
                            </td>
                            <td>{{t4.mobile}}</td>
                            <td>{{t4.p_name | noData:''}}</td>
                            <td>{{t4.c_name | noData:''}}</td>
                            <td>{{t4.overage_section}}/{{t4.course_amount}}</td>
                            <td>{{t4.deadline_time * 1000| date:'yyyy-MM-dd'}}</td>
                            <td>
                                <button class="btn btn-default" ng-click="getMemberDataCardBtn(t4.member_id)">查看详情</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'tab4NoData','text'=>'暂无数据','href'=>true]);?>
                    <?=$this->render('@app/views/common/pagination.php',['page'=>'tab4Page']);?>
                </div>
                <div class="row mr0" ng-if="show6">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>会员姓名</th>
                            <th>性别</th>
                            <th>电话</th>
                            <th>私教</th>
                            <th>课种</th>
                            <th>赠送时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="(index,t6) in tabList6">
                            <td>{{20 * (nowPage6 - 1) + index + 1}}</td>
                            <td>{{t6.name}}</td>
                            <td>
                                <span ng-if="t6.sex == 1">男</span>
                                <span ng-if="t6.sex == 2">女</span>
                                <span ng-if="t6.sex != 1 && t6.sex != 2">无</span>
                            </td>
                            <td>{{t6.mobile}}</td>
                            <td>{{t6.p_name | noData:''}}</td>
                            <td>{{t6.c_name | noData:''}}</td>
                            <td>{{t6.create_at * 1000 | date:'yyyy-MM-dd'}}</td>
                            <td>
                                <button class="btn btn-default" ng-click="getMemberDataCardBtn(t6.member_id)">查看详情</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'tab6NoData','text'=>'暂无数据','href'=>true]);?>
                    <?=$this->render('@app/views/common/pagination.php',['page'=>'tab6Page']);?>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row mr0">
                    <div class="col-md-12">
                        <span class="footerSpan" ng-if="show1">共计：{{total1}}人</span>
                        <span class="footerSpan" ng-if="show2">共计：{{total2}}人</span>
                        <span class="footerSpan" ng-if="show3">共计：{{total3}}人</span>
                        <span class="footerSpan" ng-if="show4">共计：{{total4}}人</span>
                        <span class="footerSpan" ng-if="show6">共计：{{total6}}人</span>
                        <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>