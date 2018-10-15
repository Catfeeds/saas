<!--私教卖课详情模态框-->
<div class="modal fade" id="pTSellClassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="overflow: auto;">
    <div class="modal-dialog wB90" role="document" >
        <div class="modal-content clearfix">
            <div class="modal-header clearfix" style="padding-bottom: 0;border: none;">
                <section style="display: flex;justify-content: space-between;">
                    <span class="text-left cp glyphicon glyphicon-menu-left f20 color999" ng-click="backSellPTClassModal()"></span>
                    <h4 class="text-center"  >
                        私教卖课详情
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </section>
                <section class="mT6">
                    <div class="pull-left mR10" style="width: 300px;">
                        <div class="input-daterange input-group cp userTimeRecord" id="container" >
                                <span class="add-on input-group-addon">
                                选择日期
                                </span>
                            <input type="text" readonly name="reservation" id="pTSellClassDate"
                                   class="form-control text-center userSelectTime "/>
                        </div>
                    </div>
                    <div class="pull-left mR10">
                        <select class="form-control selectCssPd" ng-model="onePtSellClassType">
                            <option value="">请选择私课类型</option>
                            <option value="1">PT</option>
                            <option value="2">HS</option>
                            <option value="3">生日课</option>
                            <option value="4">购课赠课</option>
                        </select>
                    </div>
                    <div class="pull-left mR10">
                        <select class="form-control selectCssPd" ng-model="DealStatus">
                            <option value="">请选择成交状态</option>
                            <option value="1">成交</option>
                            <option value="2">未成交</option>
                        </select>
                    </div>
                    <div class="mT6">
                        <button class="btn btn-sm btn-success w100" ng-click="onePtSellClassSubmit()">确定</button>
                        <button style="margin-left: 10px;" class="btn btn-sm btn-info w100" ng-click="onePtSellClassSubmitClear()">清空</button>
                    </div>
                </section>
            </div>
            <div class="modal-body" style="padding:0 15px 15px;">
                <div class="row" style="display: flex;align-items: center;">
                    <div class="col-sm-3 pdRL0" style="display: flex;align-items: center;height: 100%;">
                        <div class="col-sm-12 col-sm-offset-1 pdRL0" style="padding-top: 15px;">
                            <div class="col-sm-12 pdRL0 text-center">
                                <img style="width: 120px;height: 120px;border-radius: 50%;" ng-src="{{OnePtSellCoachMessage.pic != null && OnePtSellCoachMessage.pic !=''?OnePtSellCoachMessage.pic:'/plugins/user/images/pt.png'}}" alt="" >
                            </div>
                            <div class="col-sm-12 pdRL0" style="display: flex;justify-content: center;">
                                <ul style="min-width: 160px;">
                                    <li class="col-sm-12"><span class="col-sm-6 color999 text-right">私教:</span><span class="col-sm-6" style="margin-left: -20px"><b class="color999">{{OnePtSellCoachMessage.name}} </b></span></li>
                                    <li class="color999 mT10 col-sm-12"><span class="col-sm-6 text-right">职位:</span><span class="col-sm-6" style="margin-left: -20px">私教</span></li>
                                    <!--                                        <li class="color999 mT10">级别:1级教练</li>-->
                                    <li class="color999 mT10 col-sm-12"><span class="col-sm-6 text-right">手机号:</span><span class="col-sm-6" style="margin-left: -20px">{{OnePtSellCoachMessage.mobile | noData:''}}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-9 ">
                        <div class="ibox float-e-margins mT20">
                            <div class="ibox-content " >
                                <div  id="DataTables_Table_0_wrapper" class=" pdB0 dataTables_wrapper form-inline" role="grid">
                                    <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="bgWhite" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 80px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">序号
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">会员姓名
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 80px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">状态
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">卡号
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 180px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">课程名称
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 80px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">类型
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 80px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">节数
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">课时费
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 180px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">日期
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">合计
                                            </th>
                                            <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;background-color: #FFF;" >操作
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr   ng-repeat="onePt in onePtSellClassLists">
                                            <td>{{8*(onePtSellClassNow - 1)+$index+1}}</td>
                                            <td>{{onePt.name | noData:''}}</td>
                                            <td>{{onePtSellClassSum.finished[$index+8*(onePtSellClassNow - 1)] == 1?'成交':'未成交'}}</td>
                                            <td>
                                                <span>{{onePt.card_number | noData:''}}</span>
                                            </td>
                                            <td>{{onePt.product_name}}</td>
                                            <td>
                                                <span ng-if="onePt.course_type == '1'">PT</span>
                                                <span ng-if="onePt.course_type == '2'">HS</span>
                                                <span ng-if="onePt.course_type == '3'">生日课</span>
                                                <span ng-if="onePt.course_type == '4'">购课赠课</span>
                                                <span ng-if="onePt.course_type == null && onePt.type == '1' ">PT</span>
                                                <span ng-if="onePt.course_type == null && onePt.type == '2' ">HS</span>
                                                <span ng-if="onePt.course_type == null && onePt.type == '3' ">生日课</span>
                                                <span ng-if="onePt.course_type == null && onePt.type == '4' ">购课赠课</span>
                                                <span ng-if="onePt.course_type == null && onePt.type == null ">PT</span>
                                                <!--                                                    {{onePt.type == '1'?'PT':onePt.type == '2'?'HS':'暂无'}}-->
                                            </td>
                                            <td>{{onePt.courseNum}}节</td>
                                            <td>{{(onePt.courseMoney)/(onePt.courseNum) |number:2}}元</td>
                                            <td>{{onePt.create_at *1000 | date:'yyyy-MM-dd'}}</td>
                                            <td>{{onePt.orderMoney |number:2}}元</td>
                                            <td>
                                                <button class="btn btn-default" ng-click="getMemberDataCardBtn(onePt.member_id)">查看详情</button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?=$this->render('@app/views/common/nodata.php',['name'=>'onePtSellClassFlag','text'=>'暂无数据','href'=>true]);?>
                                    <?=$this->render('@app/views/common/pagination.php',['page'=>'onePtSellClassPages']);?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-sm-12 pd0 text-right">
                    <div class="sellClassColor"><span>会员量:{{onePtSellClassNum}}人</span>&emsp;&emsp;<span>未成交:{{onePtSellClassSum.unfinishedTotal}}人</span>&emsp;&emsp;<span>成交:{{onePtSellClassSum.finishedTotal}}人</span>&emsp;&emsp;<span>成交率:{{onePtSellClassSum.ratioTotal | number:2}}%</span>&emsp;&emsp;<span class="f14">节数:{{onePtSellClassSum.totalNum}}节</span>&emsp;&emsp;<b class="orangeP">合计：{{onePtSellClassSum.totalMoney | number:2}}元</span></b></div>
                </div>
            </div>
        </div>
    </div>
</div>