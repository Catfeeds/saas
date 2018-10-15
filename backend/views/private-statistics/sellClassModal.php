<!--卖课量模态框-->
<div style="overflow: auto;" class="modal fade" id="sellClassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wB90" role="document" >
        <div class="modal-content clearfix">
            <div class="modal-header" style="padding-bottom: 0;border: none;">
                <div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="text-center"  >
                        卖课量统计
                    </h4>
                    <!--                        <div class="row mT10 mB10">-->
                    <!--                            <div class="col-sm-6 col-sm-offset-3">-->
                    <!--                                <div class="input-group">-->
                    <!--                                    <input type="text" class="form-control h34" ng-model="sellClassKeywords" ng-keyup="enterSearchSaleMoney1($event)" placeholder="请输入姓名进行搜索...">-->
                    <!--                                <span class="input-group-btn">-->
                    <!--                                    <button type="button" class="btn btn-primary" ng-click="sellClassSearch()">搜索</button>-->
                    <!--                                </span>-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <div class="row ">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12" style="display: flex;flex-wrap: wrap;">
                            <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0 mT6">
                                <!--                                    <select class="form-control selectCssPd" ng-change="selectSellClassVenue(sellClassVenue)" ng-model="sellClassVenue">-->
                                <!--                                        <option value="">请选择场馆</option>-->
                                <!--                                        <option value="{{venue.id}}" ng-repeat="venue in allVenueLists">{{venue.name}}</option>-->
                                <!--                                    </select>-->
                                <select id="sellClassVenueSelect123" class=" form-control"   style="width: 100%;padding: 6px 12px;"  ng-model="sellClassVenue">
                                    <option value="">请选择场馆</option>
                                    <option title="{{venue.name}}" value="{{venue.id}}" ng-repeat="venue in allVenueLists">{{venue.name | cut:true:8:'...'}}</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 pdL0 mT6">
                                <div class="input-daterange input-group cp userTimeRecord" >
                                        <span class="add-on input-group-addon">
                                        选择日期
                                        </span>
                                    <input type="text" readonly name="reservation" id="sellClassDate"
                                           class="form-control text-center userSelectTime " />
                                </div>
                            </div>
                            <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0 mT6">
                                <!--                                    <select class="form-control selectCssPd" ng-change="selectSellClassCoach(sellClassCoach)" ng-model="sellClassCoach">-->
                                <!--                                        <option value="">请选择私教</option>-->
                                <!--                                        <option value="{{coach.id}}" ng-repeat="coach in allPrivateEducation">{{coach.name}}</option>-->
                                <!--                                    </select>-->
                                <select id="sellClassSelect123" class=" form-control"   style="width: 100%;padding: 6px 12px;"  ng-model="sellClassCoach">
                                    <option value="">请选择私教</option>
                                    <option title="{{coach.name}}" value="{{coach.id}}" ng-repeat="coach in allPrivateEducation">{{coach.name | cut:true:8:'...'}}</option>
                                </select>
                            </div>
                            <!--                                <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0 mT6">-->
                            <!--                                    <select class="form-control selectCssPd">-->
                            <!--                                        <option value="">私教等级</option>-->
                            <!--                                    </select>-->
                            <!--                                </div>-->
                            <div class="mT6">
                                <button class="btn btn-sm btn-success w100" ng-click="allSellClassSubmit()">确定</button>
                                <button style="margin-left: 10px;" class="btn btn-sm btn-info w100" ng-click="allSellClassSubmitClear()">清空</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- header-->

            <div class="modal-body" style="padding:0 15px 15px;"><!--body  -->
                <div class="ibox float-e-margins mT20">
                    <div class="ibox-content h580" >
                        <div  id="DataTables_Table_0_wrapper" class=" pdB0 dataTables_wrapper form-inline" role="grid">
                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th class="bgWhite" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 100px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">序号
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">场馆
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">私教
                                    </th>
                                    <!--                                        <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">私教等级-->
                                    <!--                                        </th>-->
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">会员量
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">未成交
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">成交
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">成交率
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">节数(节)
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;background-color: #FFF;" ng-click="changeSaleMoneySort('',sort)">售卖私课合计(元)
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr  ng-click="pTSellMessageClick(sellClass.private_id)" ng-repeat="sellClass in allSellClassLists">
                                    <td>{{8*(allSellClassNow - 1)+$index+1}}</td>
                                    <td>{{sellClass.venueName | noData:''}}</td>
                                    <td>
                                        <div>
                                                <span class="">
                                                    <img align="left" style="width: 30px;height: 30px; border-radius: 50%;" ng-src="{{sellClass.pic != null && sellClass.pic != ''? sellClass.pic:'/plugins/user/images/pt.png' }}" alt="">
                                                </span>
                                            <span align="right">{{sellClass.coachName}}</span>
                                        </div>
                                    </td>
                                    <!--                                        <td>1级</td>-->
                                    <!--                                        <td>{{allSellClassSum.memberNum[$index+8*(allSellClassNow - 1)]}}</td>-->
                                    <td>{{sellClass.memberNum | noData:''}}</td>
                                    <td>{{allSellClassSum.unfinished[$index+8*(allSellClassNow - 1)]}}</td>
                                    <td>{{allSellClassSum.finished[$index+8*(allSellClassNow - 1)]}}</td>
                                    <td>{{allSellClassSum.ratio[$index+8*(allSellClassNow - 1)] | number:2}}%</td>
                                    <td>{{sellClass.num}}</td>
                                    <td>{{sellClass.money | number:2}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <?=$this->render('@app/views/common/nodata.php',['name'=>'allSellClassFlag','text'=>'暂无数据','href'=>true]);?>
                            <?=$this->render('@app/views/common/pagination.php',['page'=>'allSellClassPages']);?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-sm-12 pd0 text-right">
                    <div class="sellClassColor"><span>会员量:{{allSellClassSum.memberNumTotal}}人</span>&emsp;&emsp;<span>未成交:{{allSellClassSum.unfinishedTotal}}人</span>&emsp;&emsp;<span>成交:{{allSellClassSum.finishedTotal}}人</span>&emsp;&emsp;<span>成交率:{{allSellClassSum.ratioTotal | number:2}}%</span>&emsp;&emsp;<span class="f14">节数:{{allSellClassSum.totalNum}}节</span>&emsp;&emsp;<b class="orangeP">合计：{{allSellClassSum.totalMoney | number:2}}元</span></b></div>
                </div>
            </div>
        </div>
    </div>
</div>