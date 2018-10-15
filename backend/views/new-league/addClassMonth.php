<!--  添加课程模态框  -->
<div class="modal fade addClassMonthModal" id="addClassMonthModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="width: 80%;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title text-center">添加课程模板</h4>
            </div>
            <div class="modal-body pd0" style="height: 600px;">
                <div class="pull-left addClassMonthChoose">
                    <ul class="list-group">
                        <li class="list-group-item" ng-click="searchTemplateData(month.standard,$keyMonTem)" ng-repeat="($keyMonTem,month) in theAllMonth">{{month.chinaDate}}</li>
                    </ul>
                </div>
                <div class="pull-left addClassDayChoose">
                    <div class="pull-left zClassMonthWidth">
                        <div class="pull-left zClassWeekDayWidth">
                            <div class="text-center zClassWeekDayStyle">
                                <h4 class="zClassWeekDayCenter">星期日</h4>
                            </div>
                        </div>
                        <div class="pull-left zClassWeekDayWidth">
                            <div class="text-center zClassWeekDayStyle">
                                <h4 class="zClassWeekDayCenter">星期一</h4>
                            </div>
                        </div>
                        <div class="pull-left zClassWeekDayWidth">
                            <div class="text-center zClassWeekDayStyle">
                                <h4 class="zClassWeekDayCenter">星期二</h4>
                            </div>
                        </div>
                        <div class="pull-left zClassWeekDayWidth">
                            <div class="text-center zClassWeekDayStyle">
                                <h4 class="zClassWeekDayCenter">星期三</h4>
                            </div>
                        </div>
                        <div class="pull-left zClassWeekDayWidth">
                            <div class="text-center zClassWeekDayStyle">
                                <h4 class="zClassWeekDayCenter">星期四</h4>
                            </div>
                        </div>
                        <div class="pull-left zClassWeekDayWidth">
                            <div class="text-center zClassWeekDayStyle">
                                <h4 class="zClassWeekDayCenter">星期五</h4>
                            </div>
                        </div>
                        <div class="pull-left zClassWeekDayWidth">
                            <div class="text-center zClassWeekDayStyle">
                                <h4 class="zClassWeekDayCenter">星期六</h4>
                            </div>
                        </div>
                        <div class="pull-left zClassWeekDayWidth" ng-class="{'noNowMonth':month.sign == false}" ng-repeat ="($temDayKey,month) in accordMonth" ng-click="searchCourseAccordMonth(month.class_date,$temDayKey)">
                            <div class="text-center zClassDayInfo1 activeTem">
                                <p style="color: #999;">
                                    <span ng-if="">今日</span>{{month.classDate}}<br><span class="zClassDayInfoSpan">共<span class="greenOne">{{month.courseNum}}</span>节课</span></p>
                            </div>
                        </div>
                        <!--                                    <div class="pull-left zClassWeekDayWidth" ng-repeat=" xx in xxx ">-->
                        <!--                                        <div class="text-center zClassDayInfo1" ng-click="">-->
                        <!--                                            <p ng-style="" style="color: #97ed58;">-->
                        <!--                                                <span ng-if="">今日</span>{{xx.month}}12月{{xx.day}}01日<br>共{{xx.class}}<span class="zClassDayInfoSpan">8节课</span></p>-->
                        <!--                                        </div>-->
                        <!--                                    </div>-->
                    </div>
                    <div class="pull-left zClassDetailWidth">
                        <div class="pull-left">
                            <div class="text-center zClassWeekDayStyle">
                                <h4 class="zClassWeekDayCenter">{{templateSearchDate}}·课程列表</h4>
                            </div>
                            <div class="text-center zClassWeekDayClassStyle1">
                                <div class="col-sm-12 pd0 zClassWeekDayClassDetail1"  ng-repeat = "courseData in  templateCourseData">
                                    <h3>{{courseData.course}}</h3>
                                    <p>{{courseData.start *1000 | date:'HH:mm' }}- {{courseData.end *1000 | date:'HH:mm' }}</p>
                                    <p>
                                        <span>教练：</span><span>{{courseData.coach}}</span>/<span>教室：</span><span>{{courseData.classroom}}</span>
                                    </p>
                                </div>
<!--                            <div class="col-sm-12 pd0" ng-repeat=" yy in yyy " style="height: 125px;border: 1px solid #ccc;margin-top: -1px;">-->
<!--                                <h3 style="margin-top: 20px;">{{y...}}</h3>-->
<!--                                <p>{{ | 'HH:mm' }} - {{ | 'HH:mm' }}</p>-->
<!--                                <p>-->
<!--                                    <span>教练：</span><span>{{ y... }}</span>/<span>教室：</span><span>{{ y... }}</span>-->
<!--                                </p>-->
<!--                            </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center" style="border-top: none;">
                <center>
                    <button class="btn btn-info mt20" role="button" ng-click="templateDataInsert()">添加模板</button>
                </center>
            </div>
        </div>
    </div>
</div>