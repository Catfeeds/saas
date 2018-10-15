<?php
use backend\assets\NewLeagueAsset;

NewLeagueAsset::register($this);
$this->title = '团课排课';
?>
<style>
    #page-wrapper {
        padding: 0;
    }
</style>
<div class="container-fliud container-fliud1" ng-controller="leagueCtrl" ng-cloak>
    <div class="col-sm-12">
        <div class="panel panel-default ">
<!--            <div class="panel-heading">-->
<!--                <span class="displayInlineBlock"><b class="spanSmall">团课排课</b></span>-->
<!--            </div>-->
            <div class="panel-body pd0">
                <div>
                    <div class="col-sm-12" style="background: #ECF1F2;">
                        <div class="col-sm-3 titleBox active">课程表</div>
                        <div class="col-sm-3 titleBox2">团课课程</div>
                        <div class="col-sm-3 titleBox3">预约设置</div>
                        <!--<div class="col-sm-3 titleBox4">爽约记录</div>-->
                    </div>
                    <div class="col-sm-12 pd0" id="titleBox">
                        <div class="col-sm-12 pd16 contentTitle">
                            <div class="col-sm-12"ng-if="sortClassType !='1'">
                                <div class="titleDate-1" style="width: 300px;margin: 0 auto;">
                                    <span class="glyphicon glyphicon-chevron-left" ng-click="dateBack()"></span>
                                    <span class="nowWeek">&nbsp;&nbsp;&nbsp;{{listData.week1[0].class_date}}&nbsp;-&nbsp;{{listData.week7[0].class_date}}&nbsp;&nbsp;&nbsp;</span>
                                    <span class="nextWeek" style="display: none;">&nbsp;&nbsp;&nbsp;{{dateSta1 | date:'yyyy-MM-dd'}}&nbsp;-&nbsp;{{dateSta2 | date:'yyyy-MM-dd'}}&nbsp;&nbsp;&nbsp;</span>
                                    <span class="glyphicon glyphicon-chevron-right clickNext" ng-click="dateNext()"
                                          style="color: #b1b1b1;"></span>
                                </div>
                            </div>
                            <div class="col-sm-12 addClassMonthStatus1" ng-if="sortClassType =='1'">
                                <div class="titleDate-1" style="width: 300px;margin: 0 auto;">
                                    <span class="glyphicon glyphicon-chevron-left" ng-click="topTable('left')"></span>
                                    <span class="nowMonth">{{mySearchTemplateChinaMonth}}</span>
                                    <span class="nextMonth" style="display: none;">{{}}-{{}}</span>
                                    <span class="glyphicon glyphicon-chevron-right clickNext" ng-click="topTable('right')"
                                          style="color: #b1b1b1;"></span>
                                </div>
                            </div>
                            <div class="col-sm-2 pd06">
                                <label for="id_label_single" class="" style="width: 118px;">
                                    <select class="form-control selectPd" ng-change="chooseSortClassType(sortClassType)" ng-model="sortClassType">
                                        <option value="">按周进行排课</option>
                                        <option value="1">按月进行排课</option>
                                    </select>
                                </label>
                            </div>
                            <div class="col-sm-2 pd06">
                                <label for="id_label_single" class="" style="width: 118px;">
                                    <select class="js-example-basic-single js-states form-control"
                                            ng-change="chooseVenues(venueId)" ng-model="venueId" id="id_label_single">
                                        <option value="{{w.id}}" ng-repeat="w in venueAll">{{w.name}}</option>
                                    </select>
                                </label>
                            </div>
                            <div class="col-sm-2 pd06">
                                <label for="id_label_single" class="">
                                    <select class="js-example-basic-single js-states form-control id_label_single"
                                            ng-change="courseClassification(classificationName1)"
                                            ng-model="classificationName1" id="id_label_single">
                                        <option value="">请选择课程</option>
                                        <option value="{{w.id}}" ng-repeat="w in choiceCourseNames">{{w.name}}</option>
                                    </select>
                                </label>
                            </div>
                            <div class="col-sm-2 pd06">
                                <label for="id_label_single" class="">
                                    <select class="js-example-basic-single js-states form-control id_label_single"
                                            ng-change="newClassroom(classificationId)" ng-model="classificationId"
                                            id="id_label_single">
                                        <option value="">请选择教室</option>
                                        <option value="{{w.id}}" ng-repeat="w in venueCourseCoachSearch">{{w.name}}
                                        </option>
                                    </select>
                                </label>
                            </div>
                            <div class="col-sm-2 pd06">
                                <label for="id_label_single" class="">
                                    <select class="js-example-basic-single js-states form-control id_label_single"
                                            ng-change="newChangeCoach(newChangeCoachIds)" ng-model="newChangeCoachIds"
                                            id="id_label_single">
                                        <option value="">请选择教练</option>
                                        <option value="{{w.id}}" ng-repeat="w in ChangeCoach">{{w.name}}</option>
                                    </select>
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group clockpicker fl cp" data-autoclose="true">
                                    <input name="dayStart" ng-model="timeLostFocusStart" type="text" ng-blur="timeLostFocusBegin()"
                                           class="input-sm form-control text-center" placeholder="起始时间"
                                           style="width: 100px;border-radius: 3px;">
                                </div>
                                <div class="input-group clockpicker fl cp" data-autoclose="true"
                                     style="width: 100px;margin-left: 14px">
                                    <input name="dayEnd" ng-model="timeLostFocusEnd" ng-blur="timeLostFocus()"
                                           type="text" class="input-sm form-control text-center" placeholder="结束时间"
                                           style="width: 100%;border-radius: 3px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 pd0 modelBox">
                            <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                                <div class="col-sm-12 pd0 contentBoxAdd">
                                    <div class="contentBoxAll">
                                        <p class="contentBoxAllp1">星期一</p>
                                        <p class="contentBoxAllp2">{{listData.week1[0].class_date}}</p>
                                    </div>
                                    <div class="infoBox"
                                         ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro':''"
                                         ng-if="w.data == true" ng-repeat="w in listData.week1"
                                         ng-click="courseDetails(w.id,w.start)">
                                        <p class="infoBoxp1" ng-if="w.courseName != null">
                                        <div ng-if="courseTimeStamp > w.start *1000  && courseTimeStamp  < w.end *1000 "
                                             class="borderRadius"></div>
                                        {{w.courseName}}   </p>
                                        <p class="infoBoxp2">
                                            <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                            <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                        </p>
                                        <p class="infoBoxp3">
                                            <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                            <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                        </p>
                                    </div>
                                    <div class="addBox"
                                         ng-click="classClick(listData.week1[0].class_date)">
                                        <p class="hoverP hoverPs">点击添加课程</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 pd0">
                                    <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">
                                        <p class="hoverBoxsp">点击添加课程表列</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                                <div class="col-sm-12 pd0 contentBoxAdd">
                                    <div class="contentBoxAll">
                                        <p class="contentBoxAllp1">星期二</p>
                                        <p class="contentBoxAllp2">{{listData.week2[0].class_date}}</p>
                                    </div>
                                    <div class="infoBox" ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro':''"
                                         ng-if="w.data == true" ng-repeat="w in listData.week2"
                                         ng-click="courseDetails(w.id,w.start)">
                                        <p class="infoBoxp1" ng-if="w.courseName != null">
                                        <div ng-if="courseTimeStamp > w.start *1000  && courseTimeStamp  < w.end *1000 "
                                             class="borderRadius"></div>
                                        {{w.courseName}}</p>
                                        <p class="infoBoxp2">
                                            <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                            <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                        </p>
                                        <p class="infoBoxp3">
                                            <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                            <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                        </p>
                                    </div>
                                    <div class="addBox"
                                         ng-click="classClick(listData.week2[0].class_date)">
                                        <p class="hoverP hoverPs">点击添加课程</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 pd0">
                                    <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">
                                        <p class="hoverBoxsp">点击添加课程表列</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                                <div class="col-sm-12 pd0 contentBoxAdd">
                                    <div class="contentBoxAll">
                                        <p class="contentBoxAllp1">星期三</p>
                                        <p class="contentBoxAllp2">{{listData.week3[0].class_date}}</p>
                                    </div>
                                    <div class="infoBox" ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro':''"
                                         ng-if="w.data == true" ng-repeat="w in listData.week3"
                                         ng-click="courseDetails(w.id,w.start)">
                                        <p class="infoBoxp1" ng-if="w.courseName != null">
                                        <div ng-if="courseTimeStamp > w.start *1000  && courseTimeStamp  < w.end *1000 "
                                             class="borderRadius"></div>
                                        {{w.courseName}} </p>
                                        <p class="infoBoxp2">
                                            <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                            <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                        </p>
                                        <p class="infoBoxp3">
                                            <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                            <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                        </p>
                                    </div>
                                    <div class="addBox"
                                         ng-click="classClick(listData.week3[0].class_date)">
                                        <p class="hoverP hoverPs">点击添加课程</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 pd0">
                                    <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">
                                        <p class="hoverBoxsp">点击添加课程表列</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                                <div class="col-sm-12 pd0 contentBoxAdd">
                                    <div class="contentBoxAll">
                                        <p class="contentBoxAllp1">星期四</p>
                                        <p class="contentBoxAllp2">{{listData.week4[0].class_date}}</p>
                                    </div>
                                    <div class="infoBox" ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro':''"
                                         ng-if="w.data == true" ng-repeat="w in listData.week4"
                                         ng-click="courseDetails(w.id,w.start)">
                                        <p class="infoBoxp1" ng-if="w.courseName != null">
                                        <div ng-if="courseTimeStamp > w.start *1000  && courseTimeStamp  < w.end *1000 "
                                             class="borderRadius"></div>
                                        {{w.courseName}}</p>
                                        <p class="infoBoxp2">
                                            <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                            <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                        </p>
                                        <p class="infoBoxp3">
                                            <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                            <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                        </p>
                                    </div>
                                    <div class="addBox"
                                         ng-click="classClick(listData.week4[0].class_date)">
                                        <p class="hoverP hoverPs">点击添加课程</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 pd0">
                                    <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">
                                        <p class="hoverBoxsp">点击添加课程表列</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                                <div class="col-sm-12 pd0 contentBoxAdd">
                                    <div class="contentBoxAll">
                                        <p class="contentBoxAllp1">星期五</p>
                                        <p class="contentBoxAllp2">{{listData.week5[0].class_date}}</p>
                                    </div>
                                    <div class="infoBox" ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro':''"
                                         ng-if="w.data == true" ng-repeat="w in listData.week5"
                                         ng-click="courseDetails(w.id,w.start)">
                                        <p class="infoBoxp1" ng-if="w.courseName != null">
                                        <div ng-if="courseTimeStamp > w.start *1000  && courseTimeStamp  < w.end *1000 "
                                             class="borderRadius"></div>
                                        {{w.courseName}}</p>
                                        <p class="infoBoxp2">
                                            <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                            <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                        </p>
                                        <p class="infoBoxp3">
                                            <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                            <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                        </p>
                                    </div>
                                    <div class="addBox"
                                         ng-click="classClick(listData.week5[0].class_date)">
                                        <p class="hoverP hoverPs">点击添加课程</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 pd0">
                                    <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">
                                        <p class="hoverBoxsp">点击添加课程表列</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                                <div class="col-sm-12 pd0 contentBoxAdd">
                                    <div class="contentBoxAll">
                                        <p class="contentBoxAllp1">星期六</p>
                                        <p class="contentBoxAllp2">{{listData.week6[0].class_date}}</p>
                                    </div>
                                    <div class="infoBox" ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro':''"
                                         ng-if="w.data == true" ng-repeat="w in listData.week6"
                                         ng-click="courseDetails(w.id,w.start)">
                                        <p class="infoBoxp1" ng-if="w.courseName != null">
                                        <div ng-if="courseTimeStamp > w.start *1000  && courseTimeStamp  < w.end *1000 "
                                             class="borderRadius"></div>
                                        {{w.courseName}}</p>
                                        <p class="infoBoxp2">
                                            <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                            <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                        </p>
                                        <p class="infoBoxp3">
                                            <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                            <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                        </p>
                                    </div>
                                    <div class="addBox"
                                         ng-click="classClick(listData.week6[0].class_date)">
                                        <p class="hoverP hoverPs">点击添加课程</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 pd0">
                                    <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">
                                        <p class="hoverBoxsp">点击添加课程表列</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                                <div class="col-sm-12 pd0 contentBoxAdd">
                                    <div class="contentBoxAll">
                                        <p class="contentBoxAllp1">星期日</p>
                                        <p class="contentBoxAllp2">{{listData.week7[0].class_date}}</p>
                                    </div>
                                    <div class="infoBox" ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro':''"
                                         ng-if="w.data == true" ng-repeat="w in listData.week7"
                                         ng-click="courseDetails(w.id,w.start)">
                                        <p class="infoBoxp1" ng-if="w.courseName != null">
                                        <div ng-if="courseTimeStamp > w.start *1000  && courseTimeStamp  < w.end *1000 "
                                             class="borderRadius"></div>
                                        {{w.courseName}}</p>
                                        <p class="infoBoxp2">
                                            <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                            <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                        </p>
                                        <p class="infoBoxp3">
                                            <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                            <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                        </p>
                                    </div>
                                    <div class="addBox"
                                         ng-click="classClick(listData.week7[0].class_date)">
                                        <p class="hoverP hoverPs">点击添加课程</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 pd0">
                                    <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">
                                        <p class="hoverBoxsp">点击添加课程表列</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 pd0 modelNext" style="display: none;">
                            <div class="col-sm-12 pd0">
                                <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                                    <div class="col-sm-12 pd0 contentBoxAdd" `>
                                        <div class="contentBoxAll">
                                            <p class="contentBoxAllp1">星期一</p>
                                            <p class="contentBoxAllp2">{{listDataw.week1[0].class_date}}</p>
                                        </div>
                                        <div class="infoBox" ng-if="w.data == true" ng-repeat="w in listDataw.week1"
                                             ng-click="courseDetails(w.id)">
                                            <p class="infoBoxp1" ng-if="w.courseName != null"> {{w.courseName}}</p>
                                            <p class="infoBoxp2">
                                                <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                                <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                            </p>
                                            <p class="infoBoxp3">
                                                <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                                <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                            </p>
                                        </div>
                                        <div class="addBox"
                                             ng-click="classClick(listDataw.week1[0].class_date)">
                                            <p class="hoverP hoverPs">点击添加课程</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 pd0">
                                        <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">
                                            <p class="hoverBoxsp">点击添加课程表列</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                                    <div class="col-sm-12 pd0 contentBoxAdd">
                                        <div class="contentBoxAll">
                                            <p class="contentBoxAllp1">星期二</p>
                                            <p class="contentBoxAllp2">{{listDataw.week2[0].class_date}}</p>
                                        </div>
                                        <div class="infoBox" ng-if="w.data == true" ng-repeat="w in listDataw.week2"
                                             ng-click="courseDetails(w.id)">
                                            <p class="infoBoxp1" ng-if="w.courseName != null">{{w.courseName}}</p>
                                            <p class="infoBoxp2">
                                                <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                                <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                            </p>
                                            <p class="infoBoxp3">
                                                <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                                <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                            </p>
                                        </div>
                                        <div class="addBox"
                                             ng-click="classClick(listDataw.week2[0].class_date)">
                                            <p class="hoverP hoverPs">点击添加课程</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 pd0">
                                        <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">
                                            <p class="hoverBoxsp">点击添加课程表列</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                                    <div class="col-sm-12 pd0 contentBoxAdd">
                                        <div class="contentBoxAll">
                                            <p class="contentBoxAllp1">星期三</p>
                                            <p class="contentBoxAllp2">{{listDataw.week3[0].class_date}}</p>
                                        </div>
                                        <div class="infoBox" ng-if="w.data == true" ng-repeat="w in listDataw.week3"
                                             ng-click="courseDetails(w.id)">
                                            <p class="infoBoxp1" ng-if="w.courseName != null">{{w.courseName}}</p>
                                            <p class="infoBoxp2">
                                                <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                                <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                            </p>
                                            <p class="infoBoxp3">
                                                <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                                <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                            </p>
                                        </div>
                                        <div class="addBox"
                                             ng-click="classClick(listDataw.week3[0].class_date)">
                                            <p class="hoverP hoverPs">点击添加课程</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 pd0">
                                        <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">
                                            <p class="hoverBoxsp">点击添加课程表列</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                                    <div class="col-sm-12 pd0 contentBoxAdd">
                                        <div class="contentBoxAll">
                                            <p class="contentBoxAllp1">星期四</p>
                                            <p class="contentBoxAllp2">{{listDataw.week4[0].class_date}}</p>
                                        </div>
                                        <div class="infoBox" ng-if="w.data == true" ng-repeat="w in listDataw.week4"
                                             ng-click="courseDetails(w.id)">
                                            <p class="infoBoxp1" ng-if="w.courseName != null"> {{w.courseName}}</p>
                                            <p class="infoBoxp2">
                                                <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                                <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                            </p>
                                            <p class="infoBoxp3">
                                                <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                                <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                            </p>
                                        </div>
                                        <div class="addBox"
                                             ng-click="classClick(listDataw.week4[0].class_date)">
                                            <p class="hoverP hoverPs">点击添加课程</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 pd0">
                                        <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">
                                            <p class="hoverBoxsp">点击添加课程表列</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                                    <div class="col-sm-12 pd0 contentBoxAdd">
                                        <div class="contentBoxAll">
                                            <p class="contentBoxAllp1">星期五</p>
                                            <p class="contentBoxAllp2">{{listDataw.week5[0].class_date}}</p>
                                        </div>
                                        <div class="infoBox" ng-if="w.data == true" ng-repeat="w in listDataw.week5"
                                             ng-click="courseDetails(w.id)">
                                            <p class="infoBoxp1" ng-if="w.courseName != null">{{w.courseName}}</p>
                                            <p class="infoBoxp2">
                                                <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                                <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                            </p>
                                            <p class="infoBoxp3">
                                                <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                                <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                            </p>
                                        </div>
                                        <div class="addBox"
                                             ng-click="classClick(listDataw.week5[0].class_date)">
                                            <p class="hoverP hoverPs">点击添加课程</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 pd0">
                                        <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">
                                            <p class="hoverBoxsp">点击添加课程表列</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                                    <div class="col-sm-12 pd0 contentBoxAdd">
                                        <div class="contentBoxAll">
                                            <p class="contentBoxAllp1">星期六</p>
                                            <p class="contentBoxAllp2">{{listDataw.week6[0].class_date}}</p>
                                        </div>
                                        <div class="infoBox" ng-if="w.data == true" ng-repeat="w in listDataw.week6"
                                             ng-click="courseDetails(w.id)">
                                            <p class="infoBoxp1" ng-if="w.courseName != null">{{w.courseName}}</p>
                                            <p class="infoBoxp2">
                                                <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                                <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                            </p>
                                            <p class="infoBoxp3">
                                                <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                                <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                            </p>
                                        </div>
                                        <div class="addBox"
                                             ng-click="classClick(listDataw.week6[0].class_date)">
                                            <p class="hoverP hoverPs">点击添加课程</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 pd0">
                                        <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">
                                            <p class="hoverBoxsp">点击添加课程表列</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                                    <div class="col-sm-12 pd0 contentBoxAdd">
                                        <div class="contentBoxAll">
                                            <p class="contentBoxAllp1">星期日</p>
                                            <p class="contentBoxAllp2">{{listDataw.week7[0].class_date}}</p>
                                        </div>
                                        <div class="infoBox" ng-if="w.data == true" ng-repeat="w in listDataw.week7"
                                             ng-click="courseDetails(w.id)">
                                            <p class="infoBoxp1" ng-if="w.courseName != null">{{w.courseName}}</p>
                                            <p class="infoBoxp2">
                                                <span ng-if="w.start != null">{{w.start*1000 | date:'HH:mm' }}-</span>
                                                <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                            </p>
                                            <p class="infoBoxp3">
                                                <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                                <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                            </p>
                                        </div>
                                        <div class="addBox"
                                             ng-click="classClick(listDataw.week7[0].class_date)">
                                            <p class="hoverP hoverPs">点击添加课程</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 pd0">
                                        <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">
                                            <p class="hoverBoxsp">点击添加课程表列</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 pd0 marginBottom"
                                     ng-if="listDataw.week1[0].data == false && listDataw.week2[0].data == false && listDataw.week3[0].data == false && listDataw.week4[0].data == false && listDataw.week5[0].data == false && listDataw.week6[0].data == false && listDataw.week7[0].data == false">
                                    <button class="btn btn-success center-block wmt" data-toggle="modal"
                                            data-target="#myModal5">课程模板
                                    </button>
                                </div>
                                <div class="col-sm-12 pd0 marginBottom"
                                     ng-if="listDataw.week1[0].data == true || listDataw.week2[0].data == true || listDataw.week3[0].data == true || listDataw.week4[0].data == true || listDataw.week5[0].data == true || listDataw.week6[0].data == true || listDataw.week7[0].data == true">
                                    <button class="btn btn-success center-block wmt" ng-click="changeCourseTemplate()">
                                        删除课程
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 pd0 clearfix addClassMonthStatus2" style="display: none;">
                            <div class="col-sm-12 pd0 clearfix">
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
                                    <div class="pull-left zClassWeekDayWidth monthDayActive" ng-class="{'noNowMonth':templateData.sign == false}" ng-repeat="($moneyDayKey,templateData)  in  monthTemplate" ng-click="searchDateCourse(templateData.class_date,templateData.classDate,$moneyDayKey)">
                                        <div class="text-center zClassDayInfo">
                                            <p style="color: #8a8a8a;">
                                                <span ng-if="">今日</span>{{templateData.classDate}}<br><span class="zClassDayInfoSpan">共<span class="greenOne">{{templateData.courseNum}}</span>节课</span></p>
                                        </div>
                                    </div>
<!--                                    <div class="pull-left zClassWeekDayWidth" ng-repeat=" xx in xxx ">-->
<!--                                        <div class="text-center zClassDayInfo" ng-click="">-->
<!--                                            <p ng-style="" style="color: #97ed58;">-->
<!--                                                <span ng-if="">今日</span>{{xx.month}}12月{{xx.day}}01日<br><span class="zClassDayInfoSpan">共{{xx.class}}8节课</span></p>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                </div>
                                <div class="pull-left zClassDetailWidth">
                                    <div class="pull-left">
                                        <div class="text-center zClassWeekDayStyle">
                                            <h4 class="zClassWeekDayCenter">{{chinaDate}}·课程列表</h4>
                                        </div>
                                        <div class="text-center zClassWeekDayClassStyle">
                                            <div class="col-sm-12 pd0 zClassWeekDayClassDetail" ng-if="weekType == 'week1' && w.data" ng-repeat = "w in searchTheCourse.week1" ng-click="courseDetails(w.id,w.start)">
                                                <p class="infoBoxp1" ng-if="w.courseName != null">
                                                <div ng-if="courseTimeStamp > w.start *1000  && courseTimeStamp  < w.end *1000 "
                                                     class="borderRadius"></div>
                                                {{w.courseName}}   </p>
                                                <p class="infoBoxp2">
                                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                                </p>
                                                <p class="infoBoxp3">
                                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                                    <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                                </p>
                                            </div>
                                            <div class="col-sm-12 pd0 zClassWeekDayClassDetail" ng-if="weekType == 'week2' && w.data" ng-repeat = "w in searchTheCourse.week2" ng-click="courseDetails(w.id,w.start)">
                                                <p class="infoBoxp1" ng-if="w.courseName != null">
                                                <div ng-if="courseTimeStamp > w.start *1000  && courseTimeStamp  < w.end *1000 "
                                                     class="borderRadius"></div>
                                                {{w.courseName}}   </p>
                                                <p class="infoBoxp2">
                                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                                </p>
                                                <p class="infoBoxp3">
                                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                                    <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                                </p>
                                            </div>
                                            <div class="col-sm-12 pd0 zClassWeekDayClassDetail" ng-if="weekType == 'week3' && w.data" ng-repeat = "w in searchTheCourse.week3" ng-click="courseDetails(w.id,w.start)">
                                                <p class="infoBoxp1" ng-if="w.courseName != null">
                                                <div ng-if="courseTimeStamp > w.start *1000  && courseTimeStamp  < w.end *1000 "
                                                     class="borderRadius"></div>
                                                {{w.courseName}}   </p>
                                                <p class="infoBoxp2">
                                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                                </p>
                                                <p class="infoBoxp3">
                                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                                    <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                                </p>
                                            </div>
                                            <div class="col-sm-12 pd0 zClassWeekDayClassDetail" ng-if="weekType == 'week4' && w.data" ng-repeat = "w in searchTheCourse.week4" ng-click="courseDetails(w.id,w.start)">
                                                <!--<h3>{{course.course}}</h3>
                                                <p>{{course.start *1000 | date:'HH:mm' }}- {{course.end *1000 | date:'HH:mm' }}</p>
                                                <p>
                                                    <span>教练：</span><span>{{course.coach}}</span>/<span>教室：</span><span>{{course.classroom}}</span>
                                                </p>-->
                                                <p class="infoBoxp1" ng-if="w.courseName != null">
                                                <div ng-if="courseTimeStamp > w.start *1000  && courseTimeStamp  < w.end *1000 "
                                                     class="borderRadius"></div>
                                                {{w.courseName}}   </p>
                                                <p class="infoBoxp2">
                                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                                </p>
                                                <p class="infoBoxp3">
                                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                                    <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                                </p>
                                            </div>
                                            <div class="col-sm-12 pd0 zClassWeekDayClassDetail" ng-if="weekType == 'week5' && w.data" ng-repeat = "w in searchTheCourse.week5" ng-click="courseDetails(w.id,w.start)">
                                                <p class="infoBoxp1" ng-if="w.courseName != null">
                                                <div ng-if="courseTimeStamp > w.start *1000  && courseTimeStamp  < w.end *1000 "
                                                     class="borderRadius"></div>
                                                {{w.courseName}}   </p>
                                                <p class="infoBoxp2">
                                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                                </p>
                                                <p class="infoBoxp3">
                                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                                    <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                                </p>
                                            </div>
                                            <div class="col-sm-12 pd0 zClassWeekDayClassDetail" ng-if="weekType == 'week6' && w.data" ng-repeat = "w in searchTheCourse.week6" ng-click="courseDetails(w.id,w.start)">
                                                <p class="infoBoxp1" ng-if="w.courseName != null">
                                                <div ng-if="courseTimeStamp > w.start *1000  && courseTimeStamp  < w.end *1000 "
                                                     class="borderRadius"></div>
                                                {{w.courseName}}   </p>
                                                <p class="infoBoxp2">
                                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                                </p>
                                                <p class="infoBoxp3">
                                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                                    <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                                </p>
                                            </div>
                                            <div class="col-sm-12 pd0 zClassWeekDayClassDetail" ng-if="weekType == 'week7' && w.data" ng-repeat = "w in searchTheCourse.week7" ng-click="courseDetails(w.id,w.start)">
                                                <p class="infoBoxp1" ng-if="w.courseName != null">
                                                <div ng-if="courseTimeStamp > w.start *1000  && courseTimeStamp  < w.end *1000 "
                                                     class="borderRadius"></div>
                                                {{w.courseName}}   </p>
                                                <p class="infoBoxp2">
                                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                                </p>
                                                <p class="infoBoxp3">
                                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}/</span>
                                                    <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                                </p>
                                            </div>
<!--                                            <div class="col-sm-12 pd0" ng-repeat=" yy in yyy " style="height: 125px;border: 1px solid #ccc;margin-top: -1px;">-->
<!--                                                <h3 style="margin-top: 20px;">{{y...}}</h3>-->
<!--                                                <p>{{ | 'HH:mm' }} - {{ | 'HH:mm' }}</p>-->
<!--                                                <p>-->
<!--                                                    <span>教练：</span><span>{{ y... }}</span>/<span>教室：</span><span>{{ y... }}</span>-->
<!--                                                </p>-->
<!--                                            </div>-->
<!--                                            <div class="col-sm-12 pd0 text-center" ng-click="" style="height: 125px;position: absolute;right: 0;bottom: 1px;cursor: pointer;">-->
<!--                                            点击这个块，可以打开class为addClassMonthModal的模态框-->
                                            <div class="col-sm-12 pd0 text-center addClassModelClick"   ng-click="addMonthCourse123()">
                                                <h4>点击添加课程</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 text-center mt20 mB20" ng-if="sortClassType == '1'&&(isHaveData===false)">
                                <button class="btn btn-success" ng-click='addMonthTemplate()'>添加月模板</button>
                            </div>
                        </div>
                        <!--按月添加课程模板-->
                        <?= $this->render('@app/views/new-league/addClassMonth.php'); ?>
                    </div>
                    <div class='col-sm-12' id='titleBox2' style="display: none">
                        <div class="row">
                            <div class="col-sm-12" style="padding: 0px">
                                <div class="panel panel-default ">
                                    <div class="panel-heading col-sm-12" style="position:relative;"><h2><b style="font-size: 15px;">团课课程</b></h2>
<!--                                        <div class="col-sm-6 marginLeft1">-->
                                        <div class="col-sm-6 col-sm-offset-3">
                                            <div class="input-group">
                                                <input type="text" class="form-control lineHeight" ng-model="keywords"
                                                       ng-keyup="enterSearch($event)" placeholder=" 请输入课程名称课种名称进行搜索...">
                                                <span class="input-group-btn">
                                                    <button type="button" ng-click="searchButton(keywords)"
                                                            class="btn btn-primary">搜索</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-sm-offset-1">
                                            <?php if (\backend\models\AuthRole::canRoleByAuth('classTimetable', 'ADD')) { ?>
                                                <button type="button"
                                                        class="btn margin0Auto btn-success btn posBtnClass btn-block w80px"
                                                        ng-click="theNewCurriculumCurriculum()"
                                                       >新增课程
                                                </button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12" style="padding: 0px">
                                <div class="ibox float-e-margins" style="margin-bottom: 0px">
                                    <div class="ibox-title">
                                        <h5>课程列表</h5>
                                    </div>
                                    <div class="ibox-content iboxContentPadding">
                                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline pd0"
                                             role="grid">
                                            <div class="row" style="display: none;">
                                                <div class="col-sm-6">
                                                    <div id="DataTables_Table_0_filter" class="dataTables_filter"></div>
                                                </div>
                                            </div>
                                            <table
                                                class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                <thead>
                                                <tr role="row">
                                                    <th class="sorting w240" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        ng-click="changeSort('name',sort)" colspan="1"
                                                        aria-label="浏览器：激活排序列升序">
                                                        <span class="glyphicon glyphicon-camera"
                                                              aria-hidden="true"></span>&nbsp;课程名称
                                                    </th>
                                                    <th class="sorting w240" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        ng-click="changeSort('category',sort)" colspan="1"
                                                        aria-label="浏览器：激活排序列升序">
                                                        <span class="glyphicon glyphicon-list-alt"
                                                              aria-hidden="true"></span>&nbsp;课种
                                                    </th>
                                                    <th class="sorting w240" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        ng-click="changeSort('course_duration',sort)" colspan="1"
                                                        aria-label="浏览器：激活排序列升序">
                                                        <span class="glyphicon glyphicon-list-alt"
                                                              aria-hidden="true"></span>&nbsp;时长
                                                    </th>
                                                    <th class="sorting w240" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1"
                                                        ng-click="changeSort('course_difficulty',sort)" colspan="1"
                                                        aria-label="引擎版本：激活排序列升序">
                                                        <span class="glyphicon glyphicon-user"
                                                              aria-hidden="true"></span>&nbsp;课程难度
                                                    </th>
                                                    <th class="sorting w240" tabindex="0"
                                                        aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                        aria-label="CSS等级：激活排序列升序">
                                                        <span class="glyphicon glyphicon-edit"
                                                              aria-hidden="true"></span>&nbsp;编辑
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr class="gradeA odd" ng-repeat="w in classCurriculumData">
                                                    <td>{{w.name}}</td>
                                                    <td>{{w.category}}</td>
                                                    <td>{{w.course_duration}}分钟</td>
                                                    <td ng-if="w.course_difficulty == 1">初学</td>
                                                    <td ng-if="w.course_difficulty != 1 && w.course_difficulty != 2 && w.course_difficulty != 3">
                                                        暂无
                                                    </td>
                                                    <td ng-if="w.course_difficulty == 2">进阶</td>
                                                    <td ng-if="w.course_difficulty == 3">强化</td>
                                                    <td class="tdBtn">
                                                        <?php if (\backend\models\AuthRole::canRoleByAuth('classTimetable', 'UPDATE')) { ?>
                                                            <span class="btn btn-success btn-sm" ng-click="classCurriculumRevision(w.id,w.name,w.pid)">
                                                            <span class="amendModalButton"
                                                                  >修改</span>
                                                        </span>&nbsp;&nbsp;
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'classListShow']); ?>
                                            <?= $this->render('@app/views/common/page.php'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 pd0" id="titleBox3" style="display: none;margin-top: 35px;">
                        <div class="col-sm-12 pd0">
                            <div class="col-sm-4 pd010 titleBox3_div" style="margin-top: 0;">
                                <span>预约设置</span>
                                <input type="text"
                                       class="form-control actions actionsV displayInlineBlockMarginLeft"
                                       ng-model="appointmentSettingsNetData.appointmentSettings"
                                       placeholder="开课前0分钟内" inputnum>
                                <span class="marginLeft" style="margin-left: 0;">分钟</span>
                            </div>
                            <div class="col-sm-4 pd010 titleBox3_div" style="margin-top: 0;">
                                <span>取消设置</span>
                                <input type="text"
                                       class="form-control actions actionsV displayInlineBlockMarginLeft"
                                       ng-model="appointmentSettingsNetData.cancelSettings"
                                       placeholder="开课前0分钟内" inputnum>
                                <span class="marginLeft" style="margin-left: 0;">分钟</span>
                            </div>
                            <div class="col-sm-4 pd010 titleBox3_div" style="margin-top: 0;">
                                <span>人数下限</span>
                                <input type="text" class="form-control actions actionsV displayInlineBlockMarginLeft"
                                       ng-model="appointmentSettingsNetData.floorCeiling" placeholder="多少人" inputnum>
                            </div>
                            <div class="col-sm-4 pd010 titleBox3_div" style="margin-top: 50px;
                            ;">
                                <span>打印小票设置</span>
                                <input type="text"
                                       class="form-control actions actionsV displayInlineBlockMarginLeft"
                                       ng-model="appointmentSettingsNetData.printSettings"
                                       placeholder="开课后0分钟内" inputnum>
                                <span class="marginLeft" style="margin-left: 0;">分钟</span>
                            </div>
                            <div class="col-sm-12" style="margin-top: 5px;">
                                <div class="col-sm-4">
                                    <span class="fa fa-info-circle">课程开始后多久不能打印小票</span>
                                </div>
                            </div>
<!--                            <div class="col-sm-4 titleBox3_div">-->
<!--                                <div style="display: block;">-->
<!--                                    预约设置-->
<!--                                    <input type="text"-->
<!--                                           class="form-control actions actionsV displayInlineBlockMarginLeft"-->
<!--                                           ng-model="appointmentSettingsNetData.appointmentSettings"-->
<!--                                           placeholder="开课前0分钟内" inputnum>-->
<!--                                    <span class="marginLeft">分钟</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-sm-4 titleBox3_div">-->
<!--                                <div>取消设置-->
<!--                                    <input type="text"-->
<!--                                           class="form-control actions actionsV displayInlineBlockMarginLeft"-->
<!--                                           ng-model="appointmentSettingsNetData.cancelSettings" placeholder="开课前0分钟内" inputnum>-->
<!--                                    <span class="marginLeft">分钟</span>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="col-sm-4 titleBox3_div">-->
<!--                                <span>人数下限</span>-->
<!--                                <input type="text" class="form-control actions actionsV"-->
<!--                                       ng-model="appointmentSettingsNetData.floorCeiling" placeholder="多少人" inputnum>-->
<!--                            </div>-->
                        </div>
                        <div class="col-sm-12" style="margin-top: -95px;">
                            <div class="col-sm-4">
                                <span class="fa fa-info-circle">课程开始前多长时间不可约课</span>
                            </div>
                            <div class="col-sm-4">
                                <span class="fa fa-info-circle">课程开始前多长时间不可取消</span>
                            </div>
                            <div class="col-sm-4">
                                <span class="fa fa-info-circle">开课人数最少不得低于人数</span>
                            </div>
                        </div>
<!--                        不要删除-->
<!--                        <div class="col-sm-12">-->
<!--                            <div class="col-sm-4 titleBox3_div">-->
<!--                                <span>缺课设置</span>-->
<!--                                <input type="text" class="form-control actions actionsV" placeholder="0次"-->
<!--                                       ng-model="absent">-->
<!--                            </div>-->
<!--                            <div class="col-sm-4 titleBox3_div">-->
<!--                                <span>冻结天数</span>-->
<!--                                <input type="text" class="form-control actions actionsV" placeholder="0天"-->
<!--                                       ng-model="thaw">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-sm-12">-->
<!--                            <div class="col-sm-4">-->
<!--                                <span class="fa fa-info-circle">连续缺课多少节后不可预约</span>-->
<!--                            </div>-->
<!--                            <div class="col-sm-4">-->
<!--                                <span class="fa fa-info-circle">不可预约冻结几天后解冻</span>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="col-sm-12 text-right">
                            <span class="btn btn-primary btn textRightButton" ng-click="appointmentSettingsNetClickReset()">重置</span>
                            <span class="btn btn-success btn textRightButton" ng-click="appointmentSettingsNetClick()">保存</span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--  //////////////////////////*********课程表*******//////////////////////////////////  -->
    <!--model 3 添加课程-->
    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close closeBtnModal3" ng-click="close3()" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title textAlignCenterFontSize" id="myModalLabel">添加课程</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>"
                               value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class="form-group formGroupInput">
                            <label class="col-sm-4 control-label">
                                <span class="formGroupColor">*</span>课种分类
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control pt2"
                                        ng-change="selectionClassification(selectionClassificationId)"
                                        ng-model="selectionClassificationId">
                                    <option value="">请选择课种</option>
                                    <option value="{{w.id}}" ng-repeat="w in classification">{{w.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group formGroupInput">
                            <label class="col-sm-4 control-label formGroupSpan">
                                <span class="formGroupColor">*</span>课程名称
                            </label>
                            <div class="col-sm-8">
                                <select ng-change="choiceCourseNameChange(choiceCourseNameChangeId)"
                                        ng-model="choiceCourseNameChangeId" class="form-control pt2">
                                    <option value="">请选择课程</option>
                                    <option value="{{w}}" ng-repeat="w in choiceCourseName">{{w.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group formGroupInput">
                            <label class="col-sm-4 control-label formGroupSpan">
                                <span class="formGroupColor">*</span>课程时间
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group clockpicker fl cp w90" data-autoclose="true">
                                    <input ng-disabled="choiceCourseNameBOOL" name="dayStart"
                                           ng-model="dayStart" ng-blur="dayStartModel(dayStart)"
                                           type="text" class="input-sm form-control text-center"
                                           autocomplete="off"
                                           placeholder="起始时间" style="width: 100px;border-radius: 3px;">
                                </div>
                                <div class="input-group clockpicker fl cp" data-autoclose="true"
                                     style="width: 100px;margin-left: 14px">
                                    <!--                                                        <span style="text-align: center;font-size: 18px;" ng-if="dayEnd != null">{{dayEnd | date:'HH:mm'}}</span>-->
                                    <input name="dayEnd" ng-disabled="choiceCourseNameBOOL" id="dayEnd1"
                                           ng-model="dayEnd" type="text" autocomplete="off"
                                           class="input-sm form-control text-center" placeholder="结束时间"
                                           style="width: 100%;border-radius: 3px;">

                                </div>
                            </div>
                        </div>
                        <div class="form-group formGroupInput ">
                            <label class="col-sm-4 control-label formGroupSpan">
                                <span class="formGroupColor">*</span>课程教练
                            </label>
                            <div class="col-sm-8">
                                <div class="col-sm-12 pd0">
                                    <div class="col-sm-4 iconTitleBox pd0">
                                        <img
                                            ng-src="{{changeCoachsBOOL == true ? '/plugins/user/images/pt.png':changeCoachsPic}}"
                                            style="width: 50px;height: 50px;border-radius: 50%">
                                    </div>
                                    <div class="col-sm-8 pd0 boxText boxText2" ng-click="boxText(courseNameID)">
                                        {{changeCoachsBOOL == true ? "请选择教练":changeCoachsName}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group formGroupInput">
                            <label class="col-sm-4 control-label formGroupSpan">
                                <span class="formGroupColor">*</span>选择教室
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control pt2" ng-change="chooseAClassroom(classroomID)"
                                        ng-model="classroomID">
                                    <option value="">请选择教室</option>
                                    <option value="{{w.id}}" ng-repeat="w in venueCourseCoach">{{w.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group formGroupInput">
                            <label class="col-sm-4 control-label formGroupSpan">
                                <span class="formGroupColor">*</span>选择座次
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control pt2" ng-model="theSeatingOrderAllId">
                                    <option value="">请选择座次</option>
                                    <option value="{{w.id}}" ng-repeat="w in theSeatingOrderAll">{{w.name}}</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer text-center">
                    <center>
                        <button type="button" class="btn btn-success w100" ng-click="classChange()">完成</button>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <!-- 课程表单个课程详情-->
    <div class="modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
        <div class="modal-dialog width80" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close closeBtnModal1" ng-click="close()" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title textAlignCenterFontSize" id="myModalLabel">预约详情</h4>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12 pd0">
                        <h3 class="fontSize20">{{reservationDetails.course.name}}
                            <span class="yellowPTitle"
                                  ng-if="classSutaus == 1 && timestampX < classSutausStart">待上课</span>
                            <span class="yellowPTitle"
                                  ng-if="classSutaus == 1 && timestampX >= classSutausStart && timestampX < classSutausEnd">已上课，未打卡</span>
                            <span class="yellowPTitle"
                                  ng-if="classSutaus == 2 && timestampX < classSutausStart">已打卡，待上课</span>
                            <span class="greenPTitle"
                                  ng-if="classSutaus == 2 && classSutausStart <= timestampX && timestampX < classSutausEnd">上课中</span>
                            <span class="greenPTitle"
                                  ng-if="classSutaus == 2 && timestampX > classSutausEnd">已下课，待打卡</span>
                            <span class="grayPTitle"
                                  ng-if="classSutaus == 3 && timestampX > classSutausEnd">已完成</span>
                            <span class="grayPTitle"
                                  ng-if="classSutaus == 4 && timestampX > classSutausEnd">未上课</span>
                        </h3>
                        <p>{{reservationDetails.class_date}}&nbsp;&nbsp;{{reservationDetails.start*1000 |
                            date:'HH:mm'}}-{{reservationDetails.end * 1000 |
                            date:'HH:mm'}}/教练：{{reservationDetails.employee.name}}/{{reservationDetails.classroom.name}}
                        </p>
                        <p class="numberOfAppointments">
                            <span>{{reservationDetails.aboutClass.length}}/{{reservationDetails.seat[0].seatNum}}已预约人数</span>
                        </p>
                        <div class="buttonBox">
<!--                            ng-if="reservationDetailsAboutClass == true && timestampX < classSutausEnd"-->
                            <?php if (\backend\models\AuthRole::canRoleByAuth('classTimetable', 'UPDATE')) { ?>
                                <button class="btn btn-info w100" data-toggle="modal" data-target="#myModals"
                                        ng-if ="displayContrally==true"
                                        ng-click="updateCourse(reservationDetails.class_date)">修改
                                </button>
                            <?php } ?>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('classTimetable', 'CANCLEGROUP')) { ?>
                                <button class="btn btn-default w100"
                                        ng-if="reservationDetailsAboutClass == true && timestampX < classSutausEnd"
                                        ng-click="cancelCourse()">取消课程
                                </button>
                            <?php } ?>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('classTimetable', 'SIGN')) { ?>
                                <button class="btn btn-success w100"
                                        ng-click="leagueClassStart(reservationDetails.id,reservationDetails.coach_id,reservationDetails.start,appointmentSettingsNetData.floorCeiling,reservationDetails.aboutClass.length )"
                                        ng-if="classSutaus == 1 && timestampX < classSutausStart" >上课打卡
                                </button>
                            <?php } ?>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('classTimetable', 'SIGN')) { ?>
                                <button class="btn btn-white btn-gray w100"
                                        ng-if="classSutaus == 2 && timestampX < classSutausEnd" disabled>
                                    下课打卡
                                </button>
                            <?php } ?>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('classTimetable', 'SIGN')) { ?>
                                <button class="btn btn-success w100"
                                        ng-if="classSutaus == 2 && timestampX > classSutausEnd"
                                        ng-click="leagueClassEnd(reservationDetails.id,reservationDetails.coach_id)">
                                    下课打卡
                                </button>
                            <?php } ?>
                        </div>
                        </p>
                    </div>
                    <div class="ibox-content pd0">
                        <div id="DataTables_Table_0_wrapper" class="borderRigthNone borderTopNone pb_h_overflow-y dataTables_wrapper form-inline"
                             role="grid">
                            <table class="table borderRigthNone borderTopNone table-striped table-bordered table-hover dataTables-example dataTable"
                                   id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序" style="width: 80px;">姓名
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序" style="width: 60px;">性别
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序" style="width: 60px;">年龄
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序" style="width: 120px;">手机号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序" style="width: 120px;">卡号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序" style="width: 80px;">座位标识
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序" style="width: 60px;">状态
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序" style="width: 80px;">预约方式
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序" style="width: 120px;">座位
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序" style="width: 140px;">预约时间
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                        colspan="1" aria-label="浏览器：激活排序列升序" style="width: 80px;">操作
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="borderRigthNone">
                                <tr class="tdb" ng-repeat="w in reservationDetails.aboutClass">
                                    <td ng-if="w.employee != null">{{w.employee.name}}</td>
                                    <td ng-if="w.employee == null">{{w.member.name}}</td>
                                    <td ng-if="w.employee != null">{{w.employee.sex == 1 ? "男":"女"}}</td>
                                    <td ng-if="w.employee == null">
                                        <span ng-if="w.member.sex == '1'">男</span>
                                        <span ng-if="w.member.sex == '2'">女</span>
                                        <span ng-if="w.member.sex != '1' && w.member.sex != '2'">暂无数据</span>
                                    </td>
                                    <td ng-if="w.employee != null">{{w.employee.birth_time | birth}}</td>
                                    <td ng-if="w.employee == null">
                                        <span ng-if="w.member.birth_date != null">{{w.member.birth_date | birth}}</span>
                                        <span ng-if="w.member.birth_time != null">{{w.member.birth_time | birth}}</span>
                                        <span ng-if="w.member.birth_date == null && w.member.birth_time == null">暂无数据</span>
                                    </td>
                                    <td ng-if="w.employee != null">{{w.employee.mobile | noData:''}}</td>
                                    <td ng-if="w.employee == null">{{w.member.mobile | noData:''}}</td>
                                    <td ng-if="w.employee != null">暂无数据</td>
                                    <td ng-if="w.employee == null">{{w.cardNumber | noData:''}}</td>
                                    <td>
                                        <span ng-if="w.seat_type == '1'">普通</span>
                                        <span ng-if="w.seat_type == '2'">VIP</span>
                                        <span ng-if="w.seat_type != '1' && w.seat_type != '2'">其他</span>
                                    </td>
                                    <td>正常</td>
                                    <td>
                                        <!--{{w.about_type == 1 ? '网上':'自主预约'}}-->
                                        <span ng-if="w.about_type == '1'">电脑预约</span>
                                        <span ng-if="w.about_type == '2'">app预约</span>
                                        <span ng-if="w.about_type == '3'">小程序预约</span>
                                        <span ng-if="w.about_type != '1' && w.about_type != '2' && w.about_type != '3'">其他</span>
                                    <td>
                                         <span ng-if="w.rows != '' && w.rows != null && w.seat_number != '' && w.seat_number != null">{{w.rows}}排{{w.seat_number}}号</span>
                                         <span ng-if="w.rows == '' || w.rows == null || w.seat_number == '' || w.seat_number == null">暂无数据</span>
                                    </td>
                                    <td>{{w.create_at *1000 | date:'yyyy/MM/dd HH:mm'}}</td>
                                    <td>
                                        <button class="btn btn-default orderBtn" ng-click="cancelReservation(w.id)" ng-disabled="timestampX > classSutausStart">
                                            取消预约
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <?= $this->render('@app/views/common/nodata.php', ['name' => 'aboutDetailShow']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--    课程表 课程详情 修改课程模态框-->
    <div class="modal" id="myModals5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close closeBtnModal3" ng-click="close3()"
                            data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title textAlignCenterFontSize" id="myModalLabel">修改课程</h4>
                </div>
                <div class="modal-body" style="padding-bottom: 10px;">
                    <form class="form-horizontal">
                        <input id="_csrf" type="hidden"
                               name="<?= \Yii::$app->request->csrfParam; ?>"
                               value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class="form-group formGroupInput">
                            <label class="col-sm-4 control-label formGroupSpan"><span class="formGroupColor">*</span>课种分类</label>
<!--                            <div class="col-sm-8 textAlignCenter" ng-if="isBOOLShow == 1">-->
<!--                                <input type="text" value="{{revisedCurriculumData.courseTypeName}}"-->
<!--                                       class="input-sm form-control text-center" readonly>-->
<!--                            </div>-->
                            <div class="col-sm-8 control-label textAlignCenter">
                                <select
                                    ng-change="selectionClassification2(revisedCurriculumData.courseTypeId,1)"
                                    ng-model="revisedCurriculumData.courseTypeId"
                                    class="form-control pt2">
                                    <option value="{{w.id}}" ng-repeat="w in classification2">
                                        {{w.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group formGroupInput">
                            <label class="col-sm-4 control-label formGroupSpan"><span class="formGroupColor">*</span>课程名称</label>
<!--                            <div class="col-sm-8 control-label textAlignCenter" ng-if="isBOOLShow == 1">-->
<!--                                <input type="text" value=" {{revisedCurriculumData.theCourseName}}"-->
<!--                                       class="input-sm form-control text-center" readonly>-->
<!--                            </div>-->
                            <div class="col-sm-8 control-label textAlignCenter">
                                <select
                                    ng-change="choiceCourseNameChange2(revisedCurriculumData.class_id)"
                                    ng-model="revisedCurriculumData.class_id" class="form-control pt2">
                                    <option value="">请选择课程</option>
                                    <option value="{{w.id}}" ng-repeat="w in choiceCourseName2">
                                        {{w.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group formGroupInput">
                            <label class="col-sm-4 control-label formGroupSpan"><span class="formGroupColor">*</span>课程时间</label>
                            <div class="col-sm-8">
                                <div class="input-group clockpicker fl cp w90" data-autoclose="true">
                                    <input name="dayStart" id="dayStartss"
                                           value="{{revisedCurriculumData.start *1000 | date:'HH:mm'}}"
                                           ng-blur="revisedCurriculumDataStartBlur()" type="text"
                                           class="input-sm form-control text-center" placeholder="起始时间"
                                           style="width: 100px;border-radius: 3px;" ng-disabled="!reservationDetailsAboutClass">
                                </div>
                                <div class="input-group clockpicker fl cp width100MarginLeft"
                                     data-autoclose="true">
                                    <!--                                                    <span style="font-size: 20px;" id="dayEnd">{{revisedCurriculumData.end  | date:'HH:mm'}}</span>-->
                                    <input name="dayEnd" id="dayEnd2"
                                           value="{{revisedCurriculumData.end  | date:'HH:mm'}}"
                                           type="text" class="input-sm form-control text-center"
                                           placeholder="结束时间" style="width: 100%;border-radius: 3px;" ng-disabled="!reservationDetailsAboutClass">
                                </div>
                            </div>
                        </div>
                        <div class="form-group formGroupInput">
                            <label class="col-sm-4 control-label formGroupSpan"><span class="formGroupColor">*</span>课程教练</label>
                            <div class="col-sm-8">
                                <div class="col-sm-12 pd0">
                                    <div class="col-sm-4 iconTitleBox pd0">
                                        <img class="w50h50"
                                             ng-src="{{changeCoachsBOOL == true ? revisedCurriculumData.changeCoachsPic : changeCoachsPic}}">
                                    </div>
                                    <div class="col-sm-8 pd0 boxText boxText1"
                                         ng-click="boxText(revisedCurriculumData.class_id)">
                                        {{changeCoachsBOOL == true ? revisedCurriculumData.changeCoachsName : changeCoachsName}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group formGroupInput">
                            <label class="col-sm-4 control-label formGroupSpan"><span class="formGroupColor">*</span>选择教室</label>
                            <div class="col-sm-8">
                                <select
                                    ng-change="chooseAClassroom2(revisedCurriculumData.classroom_id)"
                                    ng-model="revisedCurriculumData.classroom_id "
                                    class="form-control pt2"
                                    ng-disabled="!reservationDetailsAboutClass">
                                    <option value="{{w.id}}" ng-repeat="w in venueCourseCoach2">
                                        {{w.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group formGroupInput">
                            <label class="col-sm-4 control-label formGroupSpan">
                                <span class="formGroupColor">*</span>选择座次
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control pt2" ng-model='theSeatingOrderAllUpdateId' ng-disabled="!reservationDetailsAboutClass">
                                    <option value="">请选择座次</option>
                                    <option value="{{w.id}}" ng-repeat="w in theSeatingOrderAllUpdate">
                                        {{w.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <h4 class="text-right" ng-if="!reservationDetailsAboutClass" style="color: #ed8755;margin:55px 0 10px 0;">备注：修改课程或教练将以短信形式通知约课会员</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success w100" ng-click="revisedCurriculum()">
                        完成
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal 5 添加课程模板-->
    <div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         style="display: none;">
        <div class="modal-dialog myModal5" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close closeBtnModal4" data-dismiss="modal" aria-label="Close"
                            ng-click="close5()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title textAlignCenterFontSize" id="myModalLabel">添加模板</h4>
                </div>
                <div class="modal-body pd0 myModal5BoxBig">
                    <div class="myModal5BoxSmall">
                        <div class="panel-group" id="accordion" style="cursor: pointer;">
                            <div class="panel panel-default">
                                <div class="panel-heading" ng-click="getMonth(FullYear0)">
                                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapse1">
                                        <a class="panelTitleA">
                                            {{FullYear0}}月
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse">
                                    <div class="panel-body pd0">
                                        <ul class="iboxContentPadding">
                                            <li class="iboxContentPaddingLi" ng-repeat="w in Month"
                                                ng-click="initTemplates(w.monday,w.sunday)">
                                                第{{$index+1}}周
                                                {{w.monday |limitTo:-4}}~{{w.sunday | limitTo:-4}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" ng-click="getMonth(FullYear1)">
                                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapse2">
                                        <a class="panelTitleA">
                                            {{FullYear1}}月
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse">
                                    <div class="panel-body pd0">
                                        <ul class="iboxContentPadding">
                                            <li class="iboxContentPaddingLi" ng-repeat="w in Month"
                                                ng-click="initTemplates(w.monday,w.sunday)">
                                                第{{$index+1}}周
                                                {{w.monday |limitTo:-4}}~{{w.sunday | limitTo:-4}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading" ng-click="getMonth(FullYear2)">
                                    <h4 class="panel-title" data-toggle="collapse" data-parent="#accordion"
                                        href="#collapse3">
                                        <a class="panelTitleA">
                                            {{FullYear2}}月
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse">
                                    <div class="panel-body pd0">
                                        <ul class="iboxContentPadding">
                                            <li class="iboxContentPaddingLi" ng-repeat="w in Month"
                                                ng-click="initTemplates(w.monday,w.sunday)">
                                                第{{$index+1}}周
                                                {{w.monday |limitTo:-4}}~{{w.sunday | limitTo:-4}}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="addCourseTemplates">
                        <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                            <div class="col-sm-12 pd0 ">
                                <div class="contentBoxAll">
                                    <p class="contentBoxAllp1">星期一</p>
                                    <p class="contentBoxAllp2">{{listDatas.week1[0].class_date}}</p>
                                </div>
                                <div class="infoBox" ng-if="w.data == true" ng-repeat="w in listDatas.week1">
                                    <p class="infoBoxp1" ng-if="w.courseName != null">
                                        {{w.courseName}}
                                    </p>
                                    <p class="infoBoxp2">
                                        <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                        <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                    </p>
                                    <p class="infoBoxp3">
                                        <span ng-if="w.coachName != null">{{w.coachName}}/</span>
                                        <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                            <div class="col-sm-12 pd0 ">
                                <div class="contentBoxAll">
                                    <p class="contentBoxAllp1">星期二</p>
                                    <p class="contentBoxAllp2">{{listDatas.week2[0].class_date}}</p>
                                </div>
                                <div class="infoBox" ng-if="w.data == true" ng-repeat="w in listDatas.week2">
                                    <p class="infoBoxp1" ng-if="w.courseName != null">
                                        {{w.courseName}}
                                    </p>
                                    <p class="infoBoxp2">
                                        <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                        <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                    </p>
                                    <p class="infoBoxp3">
                                        <span ng-if="w.coachName != null">{{w.coachName}}/</span>
                                        <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                            <div class="col-sm-12 pd0 ">
                                <div class="contentBoxAll">
                                    <p class="contentBoxAllp1">星期三</p>
                                    <p class="contentBoxAllp2">{{listDatas.week3[0].class_date}}</p>
                                </div>
                                <div class="infoBox" ng-if="w.data == true" ng-repeat="w in listDatas.week3">
                                    <p class="infoBoxp1" ng-if="w.courseName != null">
                                        {{w.courseName}}
                                    </p>
                                    <p class="infoBoxp2">
                                        <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                        <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                    </p>
                                    <p class="infoBoxp3">
                                        <span ng-if="w.coachName != null">{{w.coachName}}/</span>
                                        <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                            <div class="col-sm-12 pd0 ">
                                <div class="contentBoxAll">
                                    <p class="contentBoxAllp1">星期四</p>
                                    <p class="contentBoxAllp2">{{listDatas.week4[0].class_date}}</p>
                                </div>
                                <div class="infoBox" ng-if="w.data == true" ng-repeat="w in listDatas.week4">
                                    <p class="infoBoxp1" ng-if="w.courseName != null">
                                        {{w.courseName}}
                                    </p>
                                    <p class="infoBoxp2">
                                        <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                        <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                    </p>
                                    <p class="infoBoxp3">
                                        <span ng-if="w.coachName != null">{{w.coachName}}/</span>
                                        <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                            <div class="col-sm-12 pd0 ">
                                <div class="contentBoxAll">
                                    <p class="contentBoxAllp1">星期五</p>
                                    <p class="contentBoxAllp2">{{listDatas.week5[0].class_date}}</p>
                                </div>
                                <div class="infoBox" ng-if="w.data == true" ng-repeat="w in listDatas.week5">
                                    <p class="infoBoxp1" ng-if="w.courseName != null">
                                        {{w.courseName}}
                                    </p>
                                    <p class="infoBoxp2">
                                        <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                        <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                    </p>
                                    <p class="infoBoxp3">
                                        <span ng-if="w.coachName != null">{{w.coachName}}/</span>
                                        <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                            <div class="col-sm-12 pd0 ">
                                <div class="contentBoxAll">
                                    <p class="contentBoxAllp1">星期六</p>
                                    <p class="contentBoxAllp2">{{listDatas.week6[0].class_date}}</p>
                                </div>
                                <div class="infoBox" ng-if="w.data == true" ng-repeat="w in listDatas.week6">
                                    <p class="infoBoxp1" ng-if="w.courseName != null">
                                        {{w.courseName}}
                                    </p>
                                    <p class="infoBoxp2">
                                        <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                        <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                    </p>
                                    <p class="infoBoxp3">
                                        <span ng-if="w.coachName != null">{{w.coachName}}/</span>
                                        <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1-7 col-lg-1-7 col-lg-1-7 col-xs-1-7">
                            <div class="col-sm-12 pd0 ">
                                <div class="contentBoxAll">
                                    <p class="contentBoxAllp1">星期日</p>
                                    <p class="contentBoxAllp2">{{listDatas.week7[0].class_date}}</p>
                                </div>
                                <div class="infoBox" ng-if="w.data == true" ng-repeat="w in listDatas.week7">
                                    <p class="infoBoxp1" ng-if="w.courseName != null">
                                        {{w.courseName}}
                                    </p>
                                    <p class="infoBoxp2">
                                        <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                        <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                    </p>
                                    <p class="infoBoxp3">
                                        <span ng-if="w.coachName != null">{{w.coachName}}/</span>
                                        <span ng-if="w.classRoomName != null">{{w.classRoomName}}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt10">
                        <button class="btn btn-success center-block w120" ng-click="addTemplates()">添加模板</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal 4 添加课程里的选择教练-->
    <div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         style="width: 80%;margin: 0 auto;display: none;">
        <div class="modal-dialog width80" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header clearfix">
                    <div class="row">
                        <div class="col-sm-4">
                            <span class="fs18">共{{ChangeCoachsBoxText.length}}人</span>
                        </div>
                        <div class="col-sm-4">
                            <h4 class="modal-title textAlignCenterFontSize" id="myModalLabel"
                                style="text-align: center;font-size: 20px;">选择教练</h4>
                        </div>
                        <div class="col-sm-4">
                            <button type="button" class="close closeBtnModal4" data-dismiss="modal"
                                    aria-label="Close" ng-click="close4()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-body heightOverflow-yScroll" style="width: 100%">
                    <div class="row">
                        <div class="col-sm-4 pd0 mb10 changeCoachsDiv"
                             ng-mouseover="changeCoachs($event,$index)" ng-mouseleave="changeCoachLeave($event,$index)"
                             ng-repeat="($index,w) in ChangeCoachsBoxText">
                            <div class="col-sm-3 pt20px textAlignCenter">
                                <img ng-if="w.pic != ''" ng-src="{{w.pic}}" class="w50h50"
                                     style="border-radius: 50%">
                                <img ng-if="w.pic == ''" ng-src="/plugins/user/images/pt.png"
                                     class="w50h50">
                            </div>
                            <div class="col-sm-4 pd0">
                                <p class="changeCoachsName">
                                    {{w.name}}
                                </p>
                                <p class="mb10">
                                    <span ng-if="w.age != null">{{w.age}}岁</span> &nbsp;&nbsp;从业时间{{w.work_time}}年
                                </p>
                                <p>
                                    <i class="glyphicon glyphicon-star"></i>
                                    <i class="glyphicon glyphicon-star"></i>
                                    <i class="glyphicon glyphicon-star"></i>
                                    <i class="glyphicon glyphicon-star"></i>
                                    <i class="glyphicon glyphicon-star"></i>
                                </p>
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-success mt30 btn-sm changeCoachs displayInlineBlocks"
                                        ng-click="changeCoachsClick(w.id,w.name,w.pic)">选择教练
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div style="width: 340px;margin: 0 auto;">
                                <span>此课教练为{{ChangeCoachsBoxText.length}}人</span> 此课程没有你想要的教练？
                                <?php if (\backend\models\AuthRole::canRoleByAuth('classTimetable', 'ADDCOACH')) { ?>
                                    <span class="colorGreen" data-toggle="modal" data-target="#addCoach"
                                          ng-click="addCoach()">新增教练</span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--    快捷添加教练-->
    <div class="modal fade" id="addCoach" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">快捷添加教练</h4>
                </div>
                <div class="modal-body">
                    <label for="id_label_singles">
                        <select  id="addCoachArray" style="width: 500px;margin: 0 auto;"
                                 class="js-example-basic-single js-states form-control  "
                                 multiple="multiple" ng-model="addCoachArray">
                            <option value="{{w.id}}" ng-repeat="w in addCoachData">{{w.name}}</option>
                        </select>
                    </label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" ng-click="addCoachOk()">确认添加</button>
                </div>
            </div>
        </div>
    </div>
    <!--打卡成功模态框-->
    <div class="modal fade" id="workModalSuccess" tabindex="-1" role="dialog">
        <div class="modal-dialog w-30" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header text-center pdl20">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="col-sm-12 text-center">
                        <img width="100" ng-src="/plugins/img/query.png" src="/plugins/img/query.png">
                        <p class="textGreenP mrt20">已打卡成功！</p>
                        <p>打卡时间：{{messageSuccessData.signTime*1000|date:'yyyy-MM-dd hh:mm:ss'}}</p>
                    </div>
                    <div class="col-sm-12 mrt20">
                        <button type="button" class="btn btn-success w100 center-block" data-dismiss="modal"
                                ng-click="closeSuccessModalWork()">完成
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>



<!--  //////////////////////////*********团课课程 新增课程*******//////////////////////////////////  -->

    <!--     新增课程-->
    <div class="modal fade" id="myModals1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
        <div class="modal-dialog width80" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close closeBtnModal1" ng-click="close()" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title textAlignCenterFontSize" id="myModalLabel">添加课程</h4>
                </div>
                <div class="modal-body">
                    <div class="col-sm-12 pd0">
                        <b>1.课程属性和详情</b>
                    </div>
                    <div class="col-sm-12 mt20">
                        <div class="col-sm-4">
                            <span class="formGroupColor">*</span>课种分类
                            <select name="" id="fenlei" class="form-control actions fenlei"
                                    ng-change="theNewCurriculumCurriculumID(addClassification)"
                                    ng-model="addClassification" style="display: inline-block">
                                <option value="">选择课种</option>
                                <option value="0" selected>顶级分类</option>
                                <option value="{{w.id}}" ng-repeat="w in theChgent">{{w.name}}</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <span class="formGroupColor">*</span>课程名称
                            <input type="text" id="name" class="form-control actions fenlei" ng-model="addClassName" style="display: inline-block">
                        </div>
                        <div class="col-sm-4">
                            <span class="formGroupColor">*</span>课程时长
                            <span class="glyphicon glyphicon-info-sign" ng-if="inputWarningTips" style="color:red;">必须输入大于零的分钟数！</span>
                            <input type="text" id="time" class="form-control actions fenlei" style="display: inline-block"
                                   ng-model="durationOfCurriculum" placeholder="请输入大于零的分钟数" inputnum>
                        </div>
                    </div>
                    <div class="col-sm-12 mt20">
                        <div class="col-sm-4">
                            <span class="formGroupColor">*</span>课程难度
                            <select ng-model="curriculumDifficulty" class="form-control actions fenlei" id="nandu" style="display: inline-block">
                                <option value="">请选择课程难度</option>
                                <option value="1">初学</option>
                                <option value="2">进阶</option>
                                <option value="3">强化</option>
                            </select>
                        </div>
                        <div class="col-sm-8 w1280select2w" style="position: relative;">
                            <span class="formGroupColor">*</span>选择教练
                            <select id="userHeader1" class="form-control fl cardStatus userHeader1"
                                    ng-model="cardStatus" multiple="multiple">
                                <option ng-repeat="w in ChangeCoachsmyModals1" value="{{w.id}}">{{w.name}}
                                </option>
                            </select>
<!--                            <div>-->
<!--                                <div class="col-sm-1" style="padding: 0;">-->
<!--                                </div>-->
<!--                                <div class="col-sm-11">-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                    </div>
                    <div class="col-sm-12 mt20" style="padding-left: 30px;">
                        课程介绍
                        <textarea style="resize: none;width: 57%;margin-top: 20px;margin-left: 0;" rows="4"
                            class="form-control courseIntroduction" ng-model="addCurriculum"></textarea>
<!--                        <div class="col-sm-6">-->
<!--                        </div>-->
                    </div>
                    <div class="col-sm-12 addImage">
                        添加照片
                        <div class="form-group">
                            <img ng-src="{{EmployeeDataPic?EmployeeDataPic:'/plugins/class/img/22.png'}}" width="70px" height="70px"
                                 style="width: 100px;height: 100px;border: 1px dashed #ddd;margin-left: 80px">
                            <div class="input-file"
                                 style="margin:  0 auto;width: 100px;height: 100px;position: relative; cursor: pointer;border: 1px dashed #ddd;margin-top: -100px;margin-left: 237px;"
                                 ngf-drop="uploadCover($file,'add')" ladda="uploading"
                                 ngf-select="upload($file,'add');"
                                 ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                                 ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'">
                                <p style="margin-left: 21px;width: 100%;height: 100%;line-height: 90px;font-size: 50px;"
                                   class="text-center">+</p>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content p0tf">
                        <span class="btn btn-success btn text-right mt20"
                              ng-click="theNewCurriculumCurriculums()">完成</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--定金信息记录修改定金模态框-->
    <?= $this->render('@app/views/new-league/updateClass.php'); ?>
</div>

