<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/13 0013
 * Time: 14:09
 */
-->
<!--私教统计-销售 详情模态框-->
<div class="modal fade"  role="dialog" id="sellModal">
    <div class="modal-dialog sellModalMain" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">{{sellModalTitle}}</h4>
            </div>
            <div class="modal-body">
                <div class="row mr0 mb10">
                    <div class="col-md-4 pd0">
                        <div class="input-daterange input-group cp">
                            <span class="add-on input-group-addon">选择日期</span>
                            <input type="text" readonly  id="sellModalDate" class="form-control text-center" style="width: 100%;" placeholder="成交时间">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control h34" placeholder="请输入姓名或手机号进行搜索..." ng-model="searchKeyword" ng-keydown="enterSearch()">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button" ng-click="searchSellBtn()">搜索</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row mr0 mb10">
                    <div class="col-md-2 pd0 mr10">
                        <select class="form-control  pd4 sellModalSelect1">
                            <option value="{{v.id}}" ng-repeat="v in venueList">{{v.name}}</option>
                        </select>
                    </div>
                    <div class="col-lg-2 pd0 mr10">
                        <select class="form-control  pd4 sellModalSelect2" id="sellPrivateSelect">
                            <option value="">私教</option>
                            <option value="{{p.id}}" ng-repeat="p in praviteList">{{p.name}}</option>
                        </select>
                    </div>
                    <div class="col-lg-2 pd0 mr10">
                        <select class="form-control  pd4 sellModalSelect3 pl4" id="sellClassType">
                            <option value="">课种</option>
                            <option value="{{c.id}}" ng-repeat="c in classTypeList">{{c.name}}</option>
                        </select>
                    </div>
                    <div class="col-lg-2 pd0 mr10">
                        <select class="form-control  pd4 sellModalSelect4">
                            <option value="">订单类别</option>
                            <option value="1">新单</option>
                            <option value="2">续费</option>
                        </select>
                    </div>
                    <div class="col-lg-2 pd0">
                        <button class="btn btn-info pd4" ng-click="searchSellBtn()">确定</button>
                        <button class="btn btn-default pd4" ng-click="clearSellBtn()">清空</button>
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
                            <th>课程</th>
                            <th>总节数</th>
                            <th>成交金额</th>
                            <th>成交时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="(index,s) in sellModalList">
                            <td>{{20 * (sellModalNowPage - 1) + index + 1}}</td>
                            <td>{{s.name | noData:''}}</td>
                            <td>
                                <span ng-if="s.sex == 1">男</span>
                                <span ng-if="s.sex == 2">女</span>
                                <span ng-if="s.sex != 1 && s.sex != 2">无</span>
                            </td>
                            <td>{{s.mobile | noData:''}}</td>
                            <td>{{s.p_name | noData:''}}</td>
                            <td>{{s.product_name}}</td>
                            <td>{{s.class_num}}节</td>
                            <td>{{s.money_amount}}元</td>
                            <td>{{s.create_at * 1000 |date:'yyyy-MM-dd'}}</td>
                            <td>
                                <button class="btn btn-default" ng-click="getMemberDataCardBtn(s.member_id)">查看详情</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'sellModalNoData','text'=>'暂无数据','href'=>true]);?>
                    <?=$this->render('@app/views/common/pagination.php',['page'=>'sellModalPage']);?>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row mr0 orange">
                    <div class="col-md-12">
                        <p>总金额：{{totalMoney}}元</p>
                        <p>成交节数：{{totalClass}}节</p>
                        <p>成交人数：{{totalMember}}人</p>
                        <button type="button" class="btn btn-default w100 fr" data-dismiss="modal">关闭</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>