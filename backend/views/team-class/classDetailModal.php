<!--
/**
 * 团课统计- 团课统计 - 最受欢迎教练、最受欢迎时段、最受欢迎课程
 * @author zhujunzhe@itsports.club
 * @create 2018/1/26 pm
 */
-->
<!----------最受欢迎的课程详情模态框------------>
<div class="modal publicModal fade" id="classDetailModal" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <div class="col-md-5 col-sm-8 col-xs-12">
                    <span class="dateSpan">选择日期</span>
                    <input type="text" id="sellDate1" readonly class="form-control text-center pd0 dateInput">
                </div>
                <div class="col-md-1 col-sm-2">
                    <button class="btn btn-info modalBtn"  type="button" ng-click="clearModalData2()">清除</button>
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
                        <h2>课程：{{classCourseName}}</h2>
                        <p>课种：{{classCategory}}</p>
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
                            <tr ng-repeat="(index,i) in classModalMemberList">
                                <td>{{8 * (classModalNowPage - 1) + index + 1}}</td>
                                <td>{{i.memberName | noData:''}}</td>
                                <td>{{i.memberMobile | noData:''}}</td>
                                <td>{{i.memberCount}}节</td>
                            </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/pagination.php', ['page' => 'classModalPage']); ?>
                        <?= $this->render('@app/views/common/nodata.php',['name'=>'classNoData','text'=>'暂无数据','href'=>true]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>