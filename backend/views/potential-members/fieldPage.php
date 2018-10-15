<div class="modal fade" id="fieldModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="overflow-y: auto;">
    <div class="modal-dialog " role="document" style="width: 840px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <div class="col-sm-5" style="display: flex;align-items: center;">
<!--                    <span style="font-size: 16px;">日期: &nbsp;</span>-->
<!--                    <div class="input-append date "  style="width: 120px;" id="dataLeave12" data-date-format="yyyy-mm-dd">-->
<!--                        <input readonly class=" form-control h30 venueDateStartInput"-->
<!--                               type="text"-->
<!--                               placeholder="请选择开始日期"-->
<!--                               ng-model="startDate"-->
<!--                               ng-change="fieldDateChange(startVenue)"-->
<!--                        />-->
<!--                        <span class="add-on"><i class="icon-th"></i></span>-->
<!--                    </div>-->
                </div>
                <div class="col-sm-2">
                    <h4 class="modal-title text-center" id="myModalLabel" >场地预约</h4>
                </div>
                <div class="col-sm-5 text-right">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

            </div>
            <div class="modal-body row pB0 pT0 pL15"style="padding: 15px;padding-bottom: 0;" >
                <div class="col-sm-12" style="display: flex;margin-bottom: 20px;">
                    <div  style="display: flex;align-items: center;width: 210px;">
                        <span style="font-size: 16px;">日期: &nbsp;</span>
                        <div class="input-append date "  style="width: 120px;" id="dataLeave12" data-date-format="yyyy-mm-dd">
                            <input readonly class=" form-control h30 venueDateStartInput"
                                   type="text"
                                   placeholder="请选择开始日期"
                                   ng-model="startDate"
                                   ng-change="fieldDateChange(startVenue)"
                            />
                            <span class="add-on"><i class="icon-th"></i></span>
                        </div>
                    </div>
                    <div style="width: 160px;">
                        <select class="form-control" ng-model="venue" ng-change="choseVenue(venue)" style="padding: 4px 12px;">
                            <option ng-repeat="venue in venueListInfo" value="{{venue.id}}">{{venue.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 pd0">
                    <div class="col-sm-12 pd0"style="height: 30px;border-bottom: solid 1px #E5E5E5;">
                        <div class="col-sm-3 pd0 text-center" >
                            <span>场地名称</span>
                        </div>
                        <div class="col-sm-9">
                            <div class="col-sm-4 text-center">时间段</div>
                            <div class="col-sm-4 text-center">预约人数</div>
                            <div class="col-sm-4 text-center">操作</div>
                        </div>
                    </div>
                    <div class="col-sm-3 pd0 switchCabinetArea" >
                        <ul class="checkUl">
                            <li class="SiteManagement cp" style="padding: 10px;border-bottom: solid 1px #E5E5E5;"   ng-repeat="space in listDataItems" ng-click="selectSiteManagement(space.id,$index,space)">
                                <div>
                                    <h3>{{space.yard_name}}</h3>
                                    <p class=" mT6">开放时间:{{space.business_time}}</p>
                                    <p class=" mT6">最多人数:{{space.people_limit}}</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-9 pd0 switchCabinetAreaCabinetNum" >
                        <div class="ibox float-e-margins boxShowNone borderNone" >
                            <div class="ibox-content borderNone pd10" >
                                <div  id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline pB0" role="grid" ng-if="listDataItems != ''">
                                    <table class="table table-bordered table-hover dataTables-example dataTable">
                                        <tbody>
                                        <tr ng-repeat="(key,value) in siteDetailsLeft.orderNumList" ng-class="{'colorE5':value.timeStatus == 1}">
                                            <td class="col-sm-4">{{key}}</td>
                                            <td class="col-sm-4">
                                                {{value.num}}/{{siteDetailsLeft.yardMessage.people_limit}}
                                            </td>
                                            <td class="tdBtn col-sm-4">
                                                <button type="button" class="btn btn-sm btn-success" ng-click="siteReservation(key,1)" ng-disabled="isAboutYardStatus" ng-if="value.timeStatus == 2 && value.isAbout == false">预约</button>
                                                <button type="button" class="btn btn-sm btn-success" ng-if="value.timeStatus == 2 && value.isAbout == true" ng-click="cancelReservation(value.id,1,key)">取消预约</button>
                                                <!--                                            ng-disabled="isAboutYardStatus"-->
                                                <button type="button"  class="btn btn-sm btn-default"  ng-click="siteManagementDetails(key,value.timeStatus)" >详情</button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" >
                <?= $this->render('@app/views/common/pagination.php', ['page' => 'fieldPages']); ?>
            </div>
        </div>
    </div>
</div>
<!--预约详情-->
<div class="modal fade" id="siteManagementDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" style="width: 840px;">
        <div class="modal-content clearfix" style="height: 500px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center myModalLabel1" id="myModalLabel">
                    场地详情
                </h3>
            </div>
            <div class="modal-body p0">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <td>姓名</td>
                        <th>场地名称</th>
                        <th>手机号</th>
                        <th>预约时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="h35px">
                        <td>序号</td>
                        <td>姓名</td>
                        <td>场地名称</td>
                        <td>手机号</td>
                        <td>预约时间</td>
                        <td>
                            <button ng-click="siteReservation(aboutIntervalSection,2)" ng-disabled="aboutTimeStatus == 1"  id="reservationMember"  type="button" class="btn-sm btn btn-success">
                                预约场地
                            </button>
                        </td>
                    </tr>
                    <tr ng-repeat="($index,w) in selectionTimeList" class="cursorPointer">
                        <td>{{nowPage*5 + $index+1}}</td>
                        <td>{{w.username | noData:''}}</td>
                        <td>{{w.yard_name | noData:''}}</td>
                        <td>{{w.mobile | noData:''}}</td>
                        <td>{{w.create_at *1000 |date:'yyyy-MM-dd HH:mm' }}</td>
                        <td>
                            <button ng-disabled="aboutTimeStatus == 1"  ng-click="cancelReservation(w.id,2,w.about_interval_section)" type="button" class="btn-sm btn btn-default">
                                取消预约
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="col-sm-12">
                    <?= $this->render('@app/views/common/nodata.php', ['name' => 'detailInfos']); ?>
                    <?= $this->render('@app/views/common/pagination.php', ['page' => 'detailPages']); ?>
                </div>
            </div>
        </div>
    </div>
</div>