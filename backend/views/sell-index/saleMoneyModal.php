<!--销售额详情模态框-->
<div class="modal fade" id="saleMoneyModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wB80" role="document" style="min-width: 1000px;">
        <div class="modal-content clearfix">
            <div class="modal-header clearfix">
                <div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="row">
                        <h4 class="modal-title modalTitle" id="myModalLabel" >
                            销售额
                        </h4>
                    </div>
                    <div class="row h55">
                        <div class="col-sm-12 pd0" style="display: flex;">
                            <div style="width: 300px;">
                                <div class="input-daterange input-group cp userTimeRecord" id="container" >
                                    <span class="add-on input-group-addon"">
                                    选择日期
                                    </span>
                                    <input type="text" readonly name="reservation" id="saleMoneyReservation"
                                           class="form-control text-center userSelectTime " style="width: 205px;"/>
                                </div>
                            </div>
                            <div >
                                <select class="modalSelect borderRadius3" ng-change="shopTypeSelect(shopTypeId)" ng-model="shopTypeId">
                                    <option ng-selected value="">商品类型</option>
                                    <option value="card">会员卡</option>
                                    <option value="charge">私教产品</option>
                                    <option value="cabinet">柜子</option>
                                    <option value="other">其它</option>
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <div class="input-group">
                                    <input type="text" class="form-control " ng-model="keywordSaleMoney" ng-keyup="enterSearchSaleMoney($event)" placeholder="请输入姓名、订单编号进行搜索...">
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-primary" ng-click="searchCardSaleMoney()">搜索</button>
                                        </span>
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-info " ng-click="searchCardSaleMoneyClear()">&emsp;清空&emsp;</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="padding-bottom: 0">
                <div class="row">
                    <div class="ibox float-e-margins" style="margin-bottom:10px;">
                        <div class="ibox-content" style="padding-bottom: 0">
                            <div  id="DataTables_Table_0_wrapper" class=" pdB0 dataTables_wrapper form-inline" role="grid">
                                <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 100px;" ng-click="changeSaleMoneySort('',sort)">序号
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeSaleMoneySort('order_number',sort)">订单编号
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;" ng-click="changeSaleMoneySort('member_name',sort)">购买人
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeSaleMoneySort('goods_type',sort)">商品类型
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 200px;" ng-click="changeSaleMoneySort('goods_name',sort)">商品名称
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;" ng-click="changeSaleMoneySort('total_price',sort)">价格
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 240px;" ng-click="changeSaleMoneySort('pay_moneyTime',sort)">时间
                                        </th>
                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 240px;background: #ffffff" >操作
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr  ng-repeat="sale in saleMoneyLists">
                                        <td>{{8*(saleMoneyNow - 1)+$index+1}}</td>
                                        <td>{{sale.order_number}}</td>
                                        <td>{{sale.member_name | noData:''}}</td>
                                        <td>{{sale.note}}</td>
                                        <td>{{sale.card_name}}</td>
                                        <td>
                                            <span ng-if="sale.net_price != null">{{sale.net_price | number:2 | noData:''}}</span>
                                            <span ng-if="sale.net_price == null">{{sale.total_price | number:2 | noData:''}}</span>
                                        </td>
                                        <td ng-if="sale.pay_money_time != null">{{sale.pay_money_time*1000 | date:'yyyy-MM-dd HH:mm:ss'}}</td>
                                        <td ng-if="sale.pay_money_time == null">暂无数据</td>
                                        <td>
                                            <button class="btn btn-default" ng-click="getMemberDataCardBtn(sale.member_id)">查看详情</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <?=$this->render('@app/views/common/nodata.php',['name'=>'saleMoneyInfo','text'=>'暂无数据','href'=>true]);?>
                                <?=$this->render('@app/views/common/pagination.php',['page'=>'saleMoneyPages']);?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-12">
                        <p class="orangeP " style="text-align: right">总计：<span>{{modalAllMoney}}元</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>