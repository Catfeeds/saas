<!--上课量模态框-->
<div style="overflow: auto;" class="modal fade" id="attendClassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wB90" role="document" >
        <div class="modal-content clearfix">
            <div class="modal-header" style="padding-bottom: 0;border: none;">
                <div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="text-center"  >
                        上课量统计
                    </h4>
                    <!--                        <div class="row mT10 mB10">-->
                    <!--                            <div class="col-sm-6 col-sm-offset-3">-->
                    <!--                                <div class="input-group">-->
                    <!--                                    <input type="text" class="form-control h34" ng-model="attendClassKeyword" ng-keyup="enterAttendClass($event)" placeholder="请输入姓名进行搜索...">-->
                    <!--                                <span class="input-group-btn">-->
                    <!--                                    <button type="button" class="btn btn-primary" ng-click="searchAttendClass()">搜索</button>-->
                    <!--                                </span>-->
                    <!--                                </div>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <div class="row ">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12" style="display: flex;flex-wrap: wrap;">
                            <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0 mT6">
                                <!--                                    <select class="form-control selectCssPd" ng-change="selectAttendClassVenue(attendClassVenue)" ng-model="attendClassVenue">-->
                                <!--                                        <option value="">请选择场馆</option>-->
                                <!--                                        <option value="{{venue.id}}" ng-repeat="venue in allVenueLists">{{venue.name}}</option>-->
                                <!--                                    </select>-->
                                <select id="attendClassVenueSelect123" class=" form-control"   style="width: 100%;padding: 6px 12px;"  ng-model="attendClassVenue">
                                    <option value="">请选择场馆</option>
                                    <option title="{{venue.name}}" value="{{venue.id}}" ng-repeat="venue in allVenueLists">{{venue.name | cut:true:8:'...'}}</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 pdL0 mT6">
                                <div class="input-daterange input-group cp userTimeRecord" id="container" >
                                        <span class="add-on input-group-addon">
                                        选择日期
                                        </span>
                                    <input type="text" readonly name="reservation" id="attendClassDate"
                                           class="form-control text-center userSelectTime " />
                                </div>
                            </div>
                            <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0 mT6">
                                <!--                                    <select class="form-control selectCssPd" ng-change="selectAttendClassCoach(attendClassCoach)" ng-model="attendClassCoach">-->
                                <!--                                        <option value="">请选择私教</option>-->
                                <!--                                        <option value="{{coach.id}}" ng-repeat="coach in allPrivateEducation">{{coach.name}}</option>-->
                                <!--                                    </select>-->
                                <select id="AttendClassSelect123" class=" form-control"   style="width: 100%;padding: 6px 12px;"  ng-model="attendClassCoach">
                                    <option value="">请选择私教</option>
                                    <option title="{{coach.name}}" value="{{coach.id}}" ng-repeat="coach in allPrivateEducation">{{coach.name | cut:true:8:'...'}}</option>
                                </select>
                            </div>
                            <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0 mT6">
                                <select class="form-control selectCssPd" ng-model="attendClassType">
                                    <option value="">课程分类</option>
                                    <option value="1">收费</option>
                                    <option value="2">免费</option>
                                </select>
                            </div>
                            <!--                                <div  class="col-lg-2 col-md-3 col-sm-4 col-xs-6 pdL0 mT6">-->
                            <!--                                    <select class="form-control selectCssPd">-->
                            <!--                                        <option value="">私教等级</option>-->
                            <!--                                    </select>-->
                            <!--                                </div>-->
                            <div class="mT6">
                                <button class="btn btn-sm btn-success w100" ng-click="classScreening()">确定</button>
                            </div>
                            <div class="mT6" style="margin-left: 10px;">
                                <button class="btn btn-sm btn-info w100" ng-click="classScreeningClear()">清空</button>
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
                                    <th class="bgWhite" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 100px;background-color: #FFF;" >序号
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeAttendClassSort('',sort)">场馆
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;background-color: #FFF;" ng-click="changeAttendClassSort('',sort)">私教
                                    </th>
                                    <!--                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeSaleMoneySort('goods_type',sort)">私教等级-->
                                    <!--                                        </th>-->
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" ng-click="changeAttendClassSort('',sort)">上课数量
                                    </th>
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 120px;background-color: #FFF;" ng-click="changeAttendClassSort('',sort)">课程金额合计
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr  ng-click="pTMessageClick(upClass.coach_id)" ng-repeat="upClass in attendClassLists">
                                    <td>{{8*(attendClassNowPage - 1)+$index+1}}</td>
                                    <td>{{upClass.venueName | noData:''}}</td>
                                    <td>
                                        <div>
                                                <span class="">
                                                    <img align="left" ng-if="upClass.pic != null && upClass.pic !=''" style="width: 30px;height: 30px; border-radius: 50%;" ng-src="{{upClass.pic}}" alt="私教头像">
                                                    <img align="left" ng-if="upClass.pic == null || upClass.pic ==''"  style="width: 30px;height: 30px; border-radius: 50%;" ng-src="/plugins/user/images/pt.png" alt="私教头像">
                                                </span>
                                            <span align="right">{{upClass.coachName}}</span>
                                        </div>
                                    </td>
                                    <!--                                        <td>1级</td>-->
                                    <td>{{upClass.num  != null && upClass.num  != ''? upClass.num : null  }}</td>
                                    <td>{{upClass.money != null && upClass.money != ''? (upClass.money | number:2) : 0}}</td>
                                </tr>
                                </tbody>
                            </table>
                            <?=$this->render('@app/views/common/nodata.php',['name'=>'attendClassFlag','text'=>'暂无数据','href'=>true]);?>
                            <?=$this->render('@app/views/common/pagination.php',['page'=>'attendClassPages']);?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border-top:none;">
                <div class="col-sm-12 pd0 text-right">
                    <div class=""><span class="f14">私课上课统计&emsp;&emsp;</span><b class="orangeP">总计：<span>{{attendClassAllNums }}节</span> {{attendClassAllMoney | number:2}}元</span></b></div>
                </div>
            </div>
        </div>
    </div>
</div>