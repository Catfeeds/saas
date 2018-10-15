<!--
/**
 * 团课统计- 团课统计 - 最受欢迎教练、最受欢迎时段、最受欢迎课程
 * @author zhujunzhe@itsports.club
 * @create 2018/1/26 pm
 */
-->
<!----------最受欢迎的时段详情模态框------------>
<div class="modal publicModal fade" id="timeDetailModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-md-4 col-sm-8 col-xs-12">
                    <span class="dateSpan">选择日期</span>
                    <input type="text" id="sellDate3" readonly class="form-control text-center pd0 dateInput">
                </div>
                <div class="col-md-2 col-sm-3 pd0 showSelect">
                    <select name="" id="" style="width: 80%" ng-model="timeCourseId" ng-change="timeCourseChange(timeCourseId)">
                        <option value="">全部课程</option>
                        <option value="{{i.id}}" ng-repeat="i in timeModalClassList">{{i.name}}</option>
                    </select>
                </div>
                <div class="col-md-1 col-sm-2">
                    <button class="btn btn-info modalBtn"  type="button" ng-click="clearModalData3()">清除</button>
                </div>
                <div class="col-md-4 col-sm-12 col-xs-12 pd0">
                    <h3 class="text-center">上课会员</h3>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mg0">
                    <!-- 左侧头像区域-->
                    <div class="col-md-4 modalLeft">
                        <h2>时段：{{timeColumn}}</h2>
                        <p>课种：{{timeCategory}}</p>
                    </div>
                    <!-- 右侧列表区域-->
                    <div class="col-md-8 pd0" >
                        <table class="table table-striped modalRight">
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>会员姓名</th>
                                <th>手机号</th>
                                <th>上课数量</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="(index,i) in timeModalMemberList">
                                <td>{{8 * (timeModalNowPage - 1) + index + 1}}</td>
                                <td>{{i.memberName | noData:''}}</td>
                                <td>{{i.memberMobile | noData:''}}</td>
                                <td>{{i.memberCount}}节</td>
                            </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/pagination.php', ['page' => 'timeModalPage']); ?>
                        <?= $this->render('@app/views/common/nodata.php',['name'=>'timeNoData','text'=>'暂无数据','href'=>true]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>