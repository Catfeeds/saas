<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/22 0022
 * Time: 20:00
 */
-->
<!--私教会员量详情-->
<div class="modal fade" tabindex="-1" role="dialog" id="memberNum">
    <div class="modal-dialog memberNumMain" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">私教会员量</h4>
            </div>
            <div class="modal-body">
                <div class="row mr0 mb10">
                    <div class="col-md-12 pd0">
                        <p style="font-size:18px;color: orange">教练姓名：{{privateName}}</p>
                    </div>
                </div>
                <div class="row mr0 mb10">
                    <div class="col-lg-1 col-md-2 col-sm-2 pd0 mr10 mb10">
                        <select class="form-control  pd4 pl4 memberNumSelect2" ng-model="modalMemberType">
                            <option value="">会员类别</option>
                            <option value="1">潜在客户</option>
                            <option value="2">正式客户</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-2 col-sm-2 pd0 mr10 mb10" ng-if="modalMemberType == 2">
                        <select class="form-control  pd4 pl4 memberNumSelect3">
                            <option value="">会员状态</option>
                            <option value="1">有效客户</option>
                            <option value="2">到期客户</option>
                        </select>
                    </div>
                    <div class="col-lg-1 col-md-2 col-sm-2 pd0 mr10 mb10">
                        <select class="form-control  pd4 pl4 memberNumSelect4">
                            <option value="">性别</option>
                            <option value="1">男</option>
                            <option value="2">女</option>
                            <option value="3">其他</option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 pd0 mr10 mb10">
                        <div class="input-group">
                            <input type="text" class="form-control h30" placeholder="请输入姓名或手机号进行搜索..." ng-model="searchKeyword1" ng-keydown="enterSearch1()">
                            <span class="input-group-btn">
                                <button class="btn btn-success pd4" type="button" ng-click="memberSearchBtn()">搜索</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 pd0 mb10">
                        <button class="btn btn-default pd4" ng-click="clearMemberSearch()">清空</button>
                    </div>
                </div>
                <div class="row mr0">
                    <table class="table table-hover table-bordered">
                        <thead>
                        <tr>
                            <th>序号</th>
                            <th>会员姓名</th>
                            <th>性别</th>
                            <th>电话</th>
                            <th>课种</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="(index,m) in memberNumList">
                            <td>{{20 * (memberNumNowPage - 1) + index + 1}}</td>
                            <td>{{m.name | noData:''}}</td>
                            <td>
                                <span ng-if="m.sex == 1">男</span>
                                <span ng-if="m.sex == 2">女</span>
                                <span ng-if="m.sex != 1 && m.sex != 2">无</span>
                            </td>
                            <td>{{m.mobile | noData:''}}</td>
                            <td>{{m.c_name | noData:''}}</td>
                            <td>
                                <button class="btn btn-default" ng-click="getMemberDataCardBtn(m.member_id)">查看详情</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'memberNumNoData','text'=>'暂无数据','href'=>true]);?>
                    <?=$this->render('@app/views/common/pagination.php',['page'=>'memberNumPage']);?>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row mr0">
                    <div class="col-md-12">
                        <span class="footerSpan">共计：{{memberNumTotal}}人</span>
                        <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>