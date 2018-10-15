<?php
use backend\assets\TeamClassAsset;
TeamClassAsset::register($this);
$this->title = '团课统计';
/**
 * 团课统计- 团课统计 - 最受欢迎教练、最受欢迎时段、最受欢迎课程
 * @author zhujunzhe@itsports.club
 * @create 2018/1/26 am
 */
?>
<div class="teamClassContent" ng-controller="teamClassCtrl" ng-cloak>
    <div class="row">
        <ul id="myTab" class="nav nav-tabs" style="border-bottom: none">
            <li class="active" style="margin-right: 100px;">
                <a href="#statistics" data-toggle="tab" ng-click="clearData1(false)">团课统计</a>
            </li>
            <li>
                <a href="#contrast" data-toggle="tab" ng-click="clearData2()">课程环比</a>
            </li>
        </ul>
    </div>
    <div class="row rowContent">
        <div class="col-md-12">
            <div id="myTabContent" class="tab-content">
                <!--团课统计选项卡-->
                <div class="tab-pane fade in active" id="statistics">
                    <!--顶部搜索框-->
                    <div class="row" style="margin-top: 6px;">
                        <div class="col-md-2 col-sm-2"></div>
                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <input type="text" ng-model="keywords1" class="form-control" style="height: 34px;" placeholder="请输入教练、课程、课种进行搜索">
                                <span class="input-group-btn">
                                    <button class="btn btn-success" ng-click="search()" type="button">搜索</button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-2">
                            <button class="btn btn-info" ng-click="clearData1(true)" type="button">清除</button>
                        </div>
                    </div>
                    <!--主要内容区-->
                    <div class="row" style="margin-top: 6px;padding-left: 10px;">
                        <div class="col-md-1 col-sm-1 pd0">
                            <select id="venueId1" ng-model="venueId1" ng-change="venueChange(venueId1)">
                                <option value="">全部场馆</option>
                                <option value="{{item.id}}" ng-repeat="item in allVenueLists">{{item.name}}</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-md-4 col-xs-6">
                            <span class="dateSpan">选择日期</span>
                            <input type="text" id="sellDate" readonly class="form-control text-center pd0 dateInput">
                        </div>
                        <!--选择最受欢迎的教练显示下拉框-->
                        <div class="col-md-2 col-sm-3 pd0 showSelect coachSelect" ng-if = "bestChose == 1">
                            <select ng-model="$parent.coachId1" ng-change="coachChange(coachId1)">
                                <option value="">全部教练</option>
                                <option value="{{item.id}}" ng-repeat="item in coachLists">{{item.name}}</option>
                            </select>
                            <select ng-model = "$parent.allClassType1" ng-change="classTypeChange(allClassType1)">
                                <option value="">全部课种</option>
                                <option value="{{x.id}}" ng-repeat="x in courseList">{{x.name}}</option>
                            </select>
                        </div>
                        <!--选择最受欢迎的课程显示下拉框-->
                        <div class="col-md-2 col-sm-3 pd0 showSelect classSelect" ng-if="bestChose == 2">
                            <select ng-model="$parent.allClassType2" ng-change="allClassChangeEvent(allClassType2)">
                                <option value="">全部课种</option>
                                <option value="{{atl.id}}" ng-repeat="atl in allClassTypeList">{{atl.name}}</option>
                            </select>
                            <select ng-model="$parent.allClass1" ng-change="allClassChange(allClass1)">
                                <option value="">全部课程</option>
                                <option value="{{acd.id}}" ng-repeat="acd in allCourseDataList">{{acd.name}}</option>
                            </select>
                        </div>
                        <!--选择最受欢迎的时段显示下拉框-->
                        <div class="col-md-3 col-sm-4 pd0 timeSelect" ng-if="bestChose == 3">
                            <select  ng-model="$parent.allTimes1" ng-change="welcomeTimeChange($parent.allTimes1)">
                                <option value="">全部时段</option>
                                <option value="06:00">06:00</option>
                                <option value="07:00">07:00</option>
                                <option value="08:00">08:00</option>
                                <option value="09:00">09:00</option>
                                <option value="10:00">10:00</option>
                                <option value="11:00">11:00</option>
                                <option value="12:00">12:00</option>
                                <option value="13:00">13:00</option>
                                <option value="14:00">14:00</option>
                                <option value="15:00">15:00</option>
                                <option value="16:00">16:00</option>
                                <option value="17:00">17:00</option>
                                <option value="18:00">18:00</option>
                                <option value="19:00">19:00</option>
                                <option value="20:00">20:00</option>
                                <option value="21:00">21:00</option>
                                <option value="22:00">22:00</option>
                                <option value="23:00">23:00</option>
                                <option value="24:00">24:00</option>
                            </select>
                            <select  ng-model="$parent.allClassType3" ng-change="timeClassTypeChange(allClassType3)">
                                <option value="">全部课种</option>
                                <option value="{{atl.id}}" ng-repeat="atl in timeClassTypeList">{{atl.name}}</option>
                            </select>
                            <select  ng-model="$parent.timeClassId" ng-change="timeClassChange(timeClassId)">
                                <option value="">全部课程</option>
                                <option value="{{i.id}}" ng-repeat="i in timeClassList">{{i.name}}</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-1"></div>
                        <div class="col-md-1 col-sm-2 pd0">
                            <select id="bestChose" ng-model="bestChose" ng-change="bestChoseChange(bestChose)">
                                <option value="1" ng-selected='bestChose == "1"'>受欢迎的教练</option>
                                <option value="2" ng-selected='bestChose == "2"'>受欢迎的课程</option>
                                <option value="3" ng-selected='bestChose == "3"'>受欢迎的时段</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" ng-if="bestChose == 1">
                        <!-----------------选择最受欢迎的教练显示的table---------------->
                        <table class="table table-bordered table-hover table-striped coachTable" >
                            <thead>
                                <tr>
                                    <th>序号</th>
                                   <!-- <th>场馆</th>-->
                                    <th width="20%">教练</th>
                                    <th width="15%">课种</th>
                                    <th ng-click="sortChange('classCount', sort)" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">上课总节数
                                        <i>
                                            <span  class="glyphicon glyphicon-triangle-top"></span>
                                            <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                        </i>
                                    </th>
                                    <th  ng-click="sortChange('memberCount', sort)" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">上课总人数
                                        <i>
                                            <span  class="glyphicon glyphicon-triangle-top"></span>
                                            <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                        </i>
                                    </th>
                                    <th  ng-click="sortChange('averageCount', sort)" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">平均上课人数
                                        <i>
                                            <span  class="glyphicon glyphicon-triangle-top"></span>
                                            <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                        </i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-toggle="modal" ng-click="coachDetail(rr.coachId,rr)" ng-repeat="(index,rr) in dataList">
                                    <td>{{8 *(nowPeoplePage - 1) + index + 1}}</td>
                                   <!-- <td>{{rr.venueName|noData:''}}</td>-->
                                    <td>{{rr.coachName|noData:''}}</td>
                                    <td>{{rr.courseType|noData:''}}</td>
                                    <td>{{rr.classCount|noData:'节'}}</td>
                                    <td>{{rr.memberCount|noData:'人'}}</td>
                                    <td>{{rr.averageCount|noData:'人':true}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/pagination.php', ['page' => 'coachGroupPage']); ?>
                        <?= $this->render('@app/views/common/nodata.php',['name'=>'coachListNoData','text'=>'暂无数据','href'=>true]); ?>
                    </div>
                        <!-------------------------------选择最受欢迎的课程显示的table-------------------->
                    <div class="row" ng-if="bestChose == 2">
                        <table class="table table-bordered table-hover table-striped classTable" >
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th width="20%">课种</th>
                                <th width="15%">课程</th>
                                <th ng-click="sortChange('classCount', sort)" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">排课总节数
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                                <th  ng-click="sortChange('memberCount', sort)" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">上课总人数
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                                <th ng-click="sortChange('averageCount', sort)" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">平均上课人数
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr data-toggle="modal" ng-repeat="(index,wcl) in welcomeCourseList" ng-click="classDetail(wcl)">
                                <td>{{8 *(nowCoursePage - 1) + index + 1}}</td>
                                <td>{{wcl.courseType | noData:''}}</td>
                                <td>{{wcl.courseName | noData:''}}</td>
                                <td>{{wcl.classCount|noData:'节'}}</td>
                                <td>{{wcl.memberCount|noData:'人'}}</td>
                                <td>{{wcl.averageCount|noData:'人':true}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/pagination.php', ['page' => 'classGroupPage']); ?>
                        <?= $this->render('@app/views/common/nodata.php',['name'=>'classListNoData','text'=>'暂无数据','href'=>true]); ?>
                    </div>
                    <!-------------------------选择最受欢迎的时段显示的table-------------------------->
                    <div class="row" ng-if="bestChose == 3">
                        <table class="table table-bordered table-hover table-striped timeTable" >
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>场馆</th>
                                <th>时段</th>
                                <th>课种</th>
                                <th>课程</th>
                                <th ng-click="sortChange('classCount', sort)" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">排课总节数
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                                <th ng-click="sortChange('memberCount', sort)" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">上课总人数
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                                <th ng-click="sortChange('averageCount', sort)" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">平均上课人数
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr data-toggle="modal" ng-click="timeDetail(i,i.courseTypeId)" ng-repeat="(index,i) in timeList">
                                <td>{{8 *(nowTimePage - 1) + index + 1}}</td>
                                <td>{{i.venueName | noData:''}}</td>
                                <td>{{i.timeColumn | noData:''}}</td>
                                <td>{{i.courseType | noData:''}}</td>
                                <td>{{i.courseName | noData:''}}</td>
                                <td>{{i.classCount | noData:'节'}}</td>
                                <td>{{i.memberCount | noData:'人'}}</td>
                                <td>{{i.averageCount|noData:'人':true}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/pagination.php', ['page' => 'timeGroupPage']); ?>
                        <?= $this->render('@app/views/common/nodata.php',['name'=>'timeListNoData','text'=>'暂无数据','href'=>true]); ?>
                    </div>
                </div>
                <!--课程环比选项卡-->
                <div class="tab-pane fade" id="contrast">
                    <!--顶部搜索框-->
                    <div class="row" style="margin-top: 6px;">
                        <div class="col-md-2 col-sm-2"></div>
                        <div class="col-md-6 col-sm-6">
                            <div class="input-group">
                                <input type="text" ng-model="keywords2" class="form-control" style="height: 34px;" placeholder="请输入教练、课程、课种进行搜索">
                                <span class="input-group-btn">
                                    <button class="btn btn-success" ng-click="search2()" type="button">搜索</button>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-1 col-sm-2">
                            <button class="btn btn-info" ng-click="clearData2(true)" type="button">清除</button>
                        </div>
                    </div>
                    <!--主要内容区-->
                    <div class="row" style="margin-top: 6px;padding-left: 10px;">
                        <div class="col-md-1 col-sm-2 pd0">
                            <select id="venueId2" ng-model="venueId2" ng-change="venueChange2(venueId2)">
                                <option value="">全部场馆</option>
                                <option value="{{item.id}}" ng-repeat="item in allVenueLists">{{item.name}}</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-5 col-xs-6">
                            <span class="dateSpan">选择上期日期</span>
                            <input type="text" id="prevDate" readonly class="form-control text-center pd0 dateInput">
                        </div>
                        <div class="col-md-3 col-sm-5 col-xs-6">
                            <span class="dateSpan">选择本期日期</span>
                            <input type="text" id="nowDate" readonly class="form-control text-center pd0 dateInput">
                        </div>
                        <!--选择最受欢迎的教练显示下拉框-->
                        <div class="col-md-2 col-sm-4 pd0 showSelect coachSelect" ng-if="bestChoseState == 1">
                            <select ng-model="$parent.coachId2" ng-change="contrastCoachChange(coachId2)">
                                <option value="">全部教练</option>
                                <option value="{{i.id}}" ng-repeat="i in contrastCoachLists">{{i.name}}</option>
                            </select>
                            <select ng-model="$parent.allClassType4" ng-change="contrastClassChange(allClassType4)">
                                <option value="">全部课种</option>
                                <option value="{{i.id}}" ng-repeat="i in contrastCourseList">{{i.name}}</option>
                            </select>
                        </div>
                        <!--选择最受欢迎的课程显示下拉框-->
                        <div class="col-md-2 col-sm-4 pd0 showSelect classSelect" ng-if="bestChoseState == 2">
                            <select ng-model="$parent.allClassType5" ng-change="getContrastAllClass(allClassType5)">
                                <option value="">全部课种</option>
                                <option value="{{i.id}}" ng-repeat="i in contrastAllClassType">{{i.name}}</option>
                            </select>
                            <select ng-model="$parent.allClass5" ng-change="getContrastClassChange(allClass5)">
                                <option value="">全部课程</option>
                                <option value="{{i.id}}" ng-repeat="i in contrastAllCourseList">{{i.name}}</option>
                            </select>
                        </div>
                        <!--选择最受欢迎的时段显示下拉框-->
                        <div class="col-md-3 col-sm-5 pd0 timeSelect contrastTimeSelect" ng-if="bestChoseState == 3">
                            <select ng-model="$parent.allTimes2" ng-change="timeColumnChange(allTimes2)">
                                <option value="">全部时段</option>
                                <option value="06:00">06:00</option>
                                <option value="07:00">07:00</option>
                                <option value="08:00">08:00</option>
                                <option value="09:00">09:00</option>
                                <option value="10:00">10:00</option>
                                <option value="11:00">11:00</option>
                                <option value="12:00">12:00</option>
                                <option value="13:00">13:00</option>
                                <option value="14:00">14:00</option>
                                <option value="15:00">15:00</option>
                                <option value="16:00">16:00</option>
                                <option value="17:00">17:00</option>
                                <option value="18:00">18:00</option>
                                <option value="19:00">19:00</option>
                                <option value="20:00">20:00</option>
                                <option value="21:00">21:00</option>
                                <option value="22:00">22:00</option>
                                <option value="23:00">23:00</option>
                                <option value="24:00">24:00</option>
                            </select>
                            <select ng-model="$parent.allClassType6" ng-change="getContrastTimeAllClass(allClassType6)">
                                <option value="">全部课种</option>
                                <option value="{{i.id}}" ng-repeat="i in contrastAllTimeClassType">{{i.name}}</option>
                            </select>
                            <select ng-model="$parent.allClass6" ng-change="getContrastTimeClassChange(allClass6)">
                                <option value="">全部课程</option>
                                <option value="{{i.id}}" ng-repeat="i in contrastAllTimeCourseList">{{i.name}}</option>
                            </select>
                        </div>
                        <div class="col-md-1 col-sm-1" ng-if="bestChoseState != 3"></div>
                        <div class="col-md-1 col-sm-2">
                            <select name="" id="" ng-model="bestChoseState" ng-change="bestChoseStateChange(bestChoseState)">
                                <option value="1" ng-selected='bestChoseState == "1"'>受欢迎的教练</option>
                                <option value="2" ng-selected='bestChoseState == "2"'>受欢迎的课程</option>
                                <option value="3" ng-selected='bestChoseState == "3"'>受欢迎的时段</option>
                            </select>
                        </div>
                        <div class="col-md-1 col-sm-2">
                            <!--选择最受欢迎的教练显示下拉框-->
                            <select ng-model="$parent.coachContrast" ng-change="coachContrastChange(coachContrast)" ng-if="bestChoseState == 1">
                                <option value="1">上课总节数</option>
                                <option value="2">上课总人数</option>
                                <option value="3">平均人数</option>
                            </select>
                            <!--选择最受欢迎的课程显示下拉框-->
                            <select ng-model="$parent.classContrast" ng-change="classContrastChange(classContrast)" ng-if="bestChoseState == 2">
                                <option value="1">排课总节数</option>
                                <option value="2">上课总人数</option>
                                <option value="3">平均人数</option>
                            </select>
                            <!--选择最受欢迎的时段显示下拉框-->
                           <select ng-model ="$parent.timeContrast" ng-change="timeContrastChange(timeContrast)" ng-if="bestChoseState == 3">
                                <option value="1">排课总节数</option>
                                <option value="2">上课总人数</option>
                                <option value="3">平均人数</option>
                            </select>
                        </div>
                    </div>
                    <!--列表内容-->
                    <!---------------------选择最受欢迎的教练显示的table---------------------->
                    <div class="row" ng-if="bestChoseState == 1">
                        <table class="table table-bordered table-hover table-striped coachContrastTable" >
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th width="20%">教练</th>
                                <th width="15%">课种</th>
                                <th ng-click="sortContrastChange('last', coachContrast, sort)"  tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">
                                    <b ng-if="coachContrast == 1">上期总节数</b>
                                    <b ng-if="coachContrast == 2">上期总人数</b>
                                    <b ng-if="coachContrast == 3">上期平均人数</b>
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                                <th ng-click="sortContrastChange('now', coachContrast, sort)"  tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">
                                    <b ng-if="coachContrast == 1">本期总节数</b>
                                    <b ng-if="coachContrast == 2">本期总人数</b>
                                    <b ng-if="coachContrast == 3">本期平均人数</b>
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                                <th ng-click="sortContrastChange('rise', coachContrast, sort)"  tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">增长量
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                                <th  ng-click="sortContrastChange('per', coachContrast, sort)"  tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">增长比
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="(index,i) in contrastCoachData">
                                <td>{{8 *(contrastPage - 1) + index + 1}}</td>
                                <td>{{i.coachName ? i.coachName : i.lastCoachName}}</td>
                                <td>{{i.courseType ? i.courseType : i.lastCourseType}}</td>
                                <td ng-if="coachContrast == 1">{{i.lastClassCount | noData:'节':true}}</td>
                                <td ng-if="coachContrast == 2">{{i.lastMemberCount | noData: '人':true}}</td>
                                <td ng-if="coachContrast == 3">{{i.lastAverageCount | noData: '人':true}}</td>
                                <td ng-if="coachContrast == 1">{{i.classCount | noData:'节':true}}</td>
                                <td ng-if="coachContrast == 2">{{i.memberCount | noData: '人':true}}</td>
                                <td ng-if="coachContrast == 3">{{i.averageCount | noData: '人':true}}</td>
                                <td ng-if="coachContrast == 1">{{i.classCount - i.lastClassCount | noData:'节':true}}</td>
                                <td ng-if="coachContrast == 2">{{i.memberCount - i.lastMemberCount | noData:'人':true}}</td>
                                <td ng-if="coachContrast == 3">{{(i.memberCount | trunc : i.classCount : '')-(i.lastMemberCount | trunc : i.lastClassCount : '')}}</td>
                                <td ng-if="coachContrast == 1 && i.lastClassCount != 0 && i.lastClassCount != null">{{(((i.classCount -i.lastClassCount) | trunc : i.lastClassCount : '' : '') * 100) | number : 2}}%</td>
                                <td ng-if="coachContrast == 1 && (i.lastClassCount == 0 || i.lastClassCount == null)">{{i.classCount  * 100}}%</td>
                                <td ng-if="coachContrast == 2 && i.lastMemberCount != 0 && i.lastMemberCount != null">{{(((i.memberCount - i.lastMemberCount) | trunc : i.lastMemberCount : '' : '') * 100) | number : 2}}%</td>
                                <td ng-if="coachContrast == 2 && (i.lastMemberCount == 0 || i.lastMemberCount == null)">{{i.memberCount  * 100}}%</td>
                                <td ng-if="coachContrast == 3 && (i.lastMemberCount | trunc : i.lastClassCount : '') != 0 && (i.lastMemberCount | trunc : i.lastClassCount : '') != null">{{((((i.memberCount| trunc : i.classCount : '') - (i.lastMemberCount| trunc : i.lastClassCount : '')) | trunc : (i.lastMemberCount | trunc : i.lastClassCount : '') : '' : '') * 100) | number : 2}}%</td>
                                <td ng-if="coachContrast == 3 && ((i.lastMemberCount | trunc : i.lastClassCount : '') == 0 || (i.lastMemberCount | trunc : i.lastClassCount : '') == null)">{{(i.memberCount| trunc : i.classCount : '')  * 100}}%</td>
                            </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/pagination.php', ['page' => 'coachContrastPage']); ?>
                        <?= $this->render('@app/views/common/nodata.php',['name'=>'contrastCoachNoData','text'=>'暂无数据','href'=>true]); ?>
                    </div>
                    <!----------------------选择最受欢迎的课程显示的table------------------------>
                    <div class="row" ng-if="bestChoseState == 2">
                        <table class="table table-bordered table-hover table-striped classContrastTable" >
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th width="20%">课种</th>
                                <th width="15%">课程</th>
                                <th ng-click="sortContrastChange('last', classContrast, sort)"  tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">
                                    <b ng-if="classContrast == 1">上期排课总节数</b>
                                    <b ng-if="classContrast == 2">上期上课总人数</b>
                                    <b ng-if="classContrast == 3">上期平均人数</b>
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                                <th ng-click="sortContrastChange('now', classContrast, sort)"  tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">
                                    <b ng-if="classContrast == 1">本期排课总节数</b>
                                    <b ng-if="classContrast == 2">本期上课总人数</b>
                                    <b ng-if="classContrast == 3">本期平均人数</b>
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                                <th ng-click="sortContrastChange('rise', classContrast, sort)"  tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">增长量
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                                <th ng-click="sortContrastChange('per', classContrast, sort)"  tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">增长比
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="(index,i) in contrastClassData">
                                <td>{{8 *(contractClassNow - 1) + index + 1}}</td>
                                <td>{{i.courseType ? i.courseType : i.lastCourseType}}</td>
                                <td>{{i.courseName ? i.courseName : i.lastCourseName}}</td>
                                <td ng-if="classContrast == 1">{{i.lastClassCount | noData:'节':true}}</td>
                                <td ng-if="classContrast == 2">{{i.lastMemberCount | noData: '人':true}}</td>
                                <td ng-if="classContrast == 3">{{i.lastMemberCount | trunc : i.lastClassCount}}</td>
                                <td ng-if="classContrast == 1">{{i.classCount | noData:'节':true}}</td>
                                <td ng-if="classContrast == 2">{{i.memberCount | noData: '人':true}}</td>
                                <td ng-if="classContrast == 3">{{i.memberCount | trunc : i.classCount}}</td>
                                <td ng-if="classContrast == 1">{{i.classCount - i.lastClassCount | noData:'节':true}}</td>
                                <td ng-if="classContrast == 2">{{i.memberCount - i.lastMemberCount | noData:'人':true}}</td>
                                <td ng-if="classContrast == 3">{{(i.memberCount | trunc : i.classCount : '')-(i.lastMemberCount | trunc : i.lastClassCount : '')}}</td>
                                <td ng-if="classContrast == 1 && i.lastClassCount != 0 && i.lastClassCount != null">{{(((i.classCount -i.lastClassCount) | trunc : i.lastClassCount : '' : '') * 100) | number : 2}}%</td>
                                <td ng-if="classContrast == 1 && (i.lastClassCount == 0 || i.lastClassCount == null)">{{i.classCount  * 100}}%</td>
                                <td ng-if="classContrast == 2 && i.lastMemberCount != 0 && i.lastMemberCount != null">{{(((i.memberCount - i.lastMemberCount) | trunc : i.lastMemberCount : '' : '') * 100) | number : 2}}%</td>
                                <td ng-if="classContrast == 2 && (i.lastMemberCount == 0 || i.lastMemberCount == null)">{{i.memberCount  * 100}}%</td>
                                <td ng-if="classContrast == 3 && (i.lastMemberCount | trunc : i.lastClassCount : '') != 0 && (i.lastMemberCount | trunc : i.lastClassCount : '') != null">{{((((i.memberCount| trunc : i.classCount : '') - (i.lastMemberCount| trunc : i.lastClassCount : '')) | trunc : (i.lastMemberCount | trunc : i.lastClassCount : '') : '' : '') * 100) | number : 2}}%</td>
                                <td ng-if="classContrast == 3 && ((i.lastMemberCount | trunc : i.lastClassCount : '') == 0 || (i.lastMemberCount | trunc : i.lastClassCount : '') == null)">{{(i.memberCount| trunc : i.classCount : '')  * 100}}%</td>
                            </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/pagination.php', ['page' => 'classContrastPage']); ?>
                        <?= $this->render('@app/views/common/nodata.php',['name'=>'contrastClassNoData','text'=>'暂无数据','href'=>true]); ?>
                    </div>
                    <!------------------------------选择最受欢迎的时段显示的table----------------------------->
                    <div class="row" ng-if="bestChoseState == 3">
                        <table class="table table-bordered table-striped table-hover timeContrastTable" >
                            <thead>
                            <tr>
                                <th>序号</th>
                                <th>场馆</th>
                                <th>时段</th>
                                <th>课种</th>
                                <th>课程</th>
                                <th ng-click="sortContrastChange('last', timeContrast, sort)"  tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">
                                    <b ng-if="timeContrast == 1">上期排课总节数</b>
                                    <b ng-if="timeContrast == 2">上期上课总人数</b>
                                    <b ng-if="timeContrast == 3">上期平均人数</b>
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                                <th ng-click="sortContrastChange('now', timeContrast, sort)"  tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">
                                    <b ng-if="timeContrast == 1">本期排课总节数</b>
                                    <b ng-if="timeContrast == 2">本期上课总人数</b>
                                    <b ng-if="timeContrast == 3">本期平均人数</b>
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                                <th ng-click="sortContrastChange('rise', timeContrast, sort)"  tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">增长量
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                                <th ng-click="sortContrastChange('per', timeContrast, sort)"  tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序">增长比
                                    <i>
                                        <span  class="glyphicon glyphicon-triangle-top"></span>
                                        <span  class="glyphicon glyphicon-triangle-bottom"></span>
                                    </i>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="(index,i) in contrastTimeData">
                                <td>{{8 *(contractTimeNow - 1) + index + 1}}</td>
                                <td>{{i.venueName ? i.venueName : i.lastVenueName}}</td>
                                <td>{{i.timeColumn ? i.timeColumn : i.lastTimeColumn}}</td>
                                <td>{{i.courseType ? i.courseType : i.lastCourseType}}</td>
                                <td>{{i.courseName ? i.courseName : i.lastCourseName}}</td>
                                <td ng-if="timeContrast == 1">{{i.lastClassCount | noData:'节':true}}</td>
                                <td ng-if="timeContrast == 2">{{i.lastMemberCount | noData: '人':true}}</td>
                                <td ng-if="timeContrast == 3">{{i.lastMemberCount | trunc : i.lastClassCount}}</td>
                                <td ng-if="timeContrast == 1">{{i.classCount | noData:'节':true}}</td>
                                <td ng-if="timeContrast == 2">{{i.memberCount | noData: '人':true}}</td>
                                <td ng-if="timeContrast == 3">{{i.memberCount | trunc : i.classCount}}</td>
                                <td ng-if="timeContrast == 1">{{i.classCount - i.lastClassCount | noData:'节':true}}</td>
                                <td ng-if="timeContrast == 2">{{i.memberCount - i.lastMemberCount | noData:'人':true}}</td>
                                <td ng-if="timeContrast == 3">{{(i.memberCount | trunc : i.classCount : '')-(i.lastMemberCount | trunc : i.lastClassCount : '')}}</td>
                                <td ng-if="timeContrast == 1 && i.lastClassCount != 0 && i.lastClassCount != null">{{(((i.classCount -i.lastClassCount) | trunc : i.lastClassCount : '' : '') * 100) | number : 2}}%</td>
                                <td ng-if="timeContrast == 1 && (i.lastClassCount == 0 || i.lastClassCount == null)">{{i.classCount  * 100}}%</td>
                                <td ng-if="timeContrast == 2 && i.lastMemberCount != 0 && i.lastMemberCount != null">{{(((i.memberCount - i.lastMemberCount) | trunc : i.lastMemberCount : '' : '') * 100) | number : 2}}%</td>
                                <td ng-if="timeContrast == 2 && (i.lastMemberCount == 0 || i.lastMemberCount == null)">{{i.memberCount  * 100}}%</td>
                                <td ng-if="timeContrast == 3 && (i.lastMemberCount | trunc : i.lastClassCount : '') != 0 && (i.lastMemberCount | trunc : i.lastClassCount : '') != null">{{((((i.memberCount| trunc : i.classCount : '') - (i.lastMemberCount| trunc : i.lastClassCount : '')) | trunc : (i.lastMemberCount | trunc : i.lastClassCount : '') : '' : '') * 100) | number : 2}}%</td>
                                <td ng-if="timeContrast == 3 && ((i.lastMemberCount | trunc : i.lastClassCount : '') == 0 || (i.lastMemberCount | trunc : i.lastClassCount : '') == null)">{{(i.memberCount| trunc : i.classCount : '')  * 100}}%</td>
                            </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/pagination.php', ['page' => 'timeContrastPage']); ?>
                        <?= $this->render('@app/views/common/nodata.php',['name'=>'contrastTimeNoData','text'=>'暂无数据','href'=>true]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--最受欢迎的教练详情模态框-->
    <?= $this->render('@app/views/team-class/coachDetailModal.php'); ?>
    <!--最受欢迎的课程详情模态框-->
    <?= $this->render('@app/views/team-class/classDetailModal.php'); ?>
    <!--最受欢迎的时段详情模态框-->
    <?= $this->render('@app/views/team-class/timeDetailModal.php'); ?>
</div>

