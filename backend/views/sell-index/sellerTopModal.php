<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/4 0004
 * Time: 18:00
 */
 -->
<!--销售排行榜详情模态框-->
<div class="modal fade" tabindex="-1" role="dialog" id="sellerTopModal">
    <div class="modal-dialog" role="document" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">销售排行榜</h4>
            </div>
            <div class="modal-body">
            <!--筛选框和搜索框-->
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-6" style="padding-left: 0;padding-right: 0">
                        <div class="input-daterange input-group cp">
                            <span class="add-on input-group-addon">选择日期</span>
                            <input type="text" readonly name="reservation" id="sellerTopDate" class="form-control text-center userSelectTime " style="width: 100%">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 pdL0">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="请输入员工姓名..." style="width: 100%;" ng-model="sellerTopKeywords">
                            <span class="input-group-btn">
                                <button class="btn btn-success" type="button" style="padding-top: 4px;padding-bottom: 4px" ng-click="searchSellerTop()">搜索</button>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 pdL0">
                        <button class="btn btn-small btn-default" style="padding-top: 4px;padding-bottom: 4px" ng-click="clearSellerTop()">清空</button>
                    </div>
                </div>
            <!--列表开始-->
                <div class="row" style="margin-top: 20px">
                    <!--<table class="table table-striped  table-bordered" >
                        <!--<thead>
                        <tr>
                            <th style="width: 80px;">序号</th>
                            <th style="width: 100px;">员工姓名</th>
                            <th>业绩</th>
                            <th style="width: 100px;">会员姓名</th>
                            <th style="width: 120px;">手机号</th>
                            <th>业务行为</th>
                            <th>业务名称</th>
                            <th>金额</th>
                            <th>缴费时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>张三</td>
                            <td>102000</td>
                            <td>李四</td>
                            <td>15239160888</td>
                            <td>购卡</td>
                            <td>FT12MD</td>
                            <td>3800元</td>
                            <td>2018/05/02 15:00</td>
                            <td>
                                <button class="btn btn-default">查看详情</button>
                            </td>
                        </tr>
                        </tbody>-->
                       <!-- <thead>
                        <tr>
                            <th style="width: 100px;">员工姓名</th>
                            <th>职位</th>
                            <th style="width: 100px;">会员姓名</th>
                            <th style="width: 120px;">手机号</th>
                            <th>业务行为</th>
                            <th>业务名称</th>
                            <th>金额</th>
                            <th>缴费时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="i in sellerTopDetailList">
                            <td>{{i.eName | noData:''}}</td>
                            <td>{{i.position | noData:''}}</td>
                            <td>{{i.memberName | noData:''}}</td>
                            <td>{{i.mobile | noData:''}}</td>
                            <td>{{i.note | noData:''}}</td>
                            <td>{{i.card_name | noData:''}}</td>
                            <td>{{i.total_price | noData:''}}元</td>
                            <td>{{i.pay_money_time * 1000 | date:'yyyy-MM-dd HH:mm'}}</td>
                            <td>
                                <button class="btn btn-default" ng-click="getMemberDataCardBtn(i.member_id)">查看详情</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>-->
                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                        <thead>
                        <tr role="row">
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序"
                                style="background-color: transparent;">员工姓名
                            </th>
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="浏览器：激活排序列升序" style="background-color: transparent;">职位
                            </th>
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="浏览器：激活排序列升序" style="background-color: transparent;">会员姓名
                            </th>
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="平台：激活排序列升序" style="background-color: transparent;">手机号
                            </th>
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="background-color: transparent;"
                                colspan="1" aria-label="引擎版本：激活排序列升序">业务行为
                            </th>
                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="background-color: transparent;"
                                colspan="1" aria-label="引擎版本：激活排序列升序">业务名称
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="background-color: transparent;"
                                colspan="1" aria-label="引擎版本：激活排序列升序" ng-click="sellerTopChangeSort('sell_money',sort)">金额
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" style="background-color: transparent;"
                                colspan="1" aria-label="引擎版本：激活排序列升序" ng-click="sellerTopChangeSort('create_at',sort)">缴费时间
                            </th>
                            <th class="" tabindex="0" rowspan="1" colspan="1"  style="background-color: transparent;">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr ng-repeat="i in sellerTopDetailList">
                            <td>{{i.eName | noData:''}}</td>
                            <td>{{i.position | noData:''}}</td>
                            <td>{{i.memberName | noData:''}}</td>
                            <td>{{i.mobile | noData:''}}</td>
                            <td>{{i.note | noData:''}}</td>
                            <td>{{i.card_name | noData:''}}</td>
                            <td>{{i.total_price | noData:''}}元</td>
                            <td>{{i.pay_money_time * 1000 | date:'yyyy-MM-dd HH:mm'}}</td>
                            <td>
                                <button class="btn btn-default" ng-click="getMemberDataCardBtn(i.member_id)">查看详情</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <?=$this->render('@app/views/common/pagination.php',['page'=>'sellerTopPage']);?>
                    <?=$this->render('@app/views/common/nodata.php',['name'=>'sellerTopNoData','text'=>'暂无信息','href'=>true]);?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>