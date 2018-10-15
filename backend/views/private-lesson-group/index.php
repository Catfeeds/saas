<?php
/**
 * Created by 张亚鑫
 * Date: 2017/12/8
 * Time: 9:43
 * content:私教小团体课页面
 */
use backend\assets\PrivateLessonGroupAsset;
PrivateLessonGroupAsset::register($this);
$this->title = '私教小团体课程';
?>
<div ng-controller="privateLessonGroupCtrl" ng-cloak>
<!--<div ng-app="" ng-controller="" ng-cloak>-->
    <div class="container-fluid" >
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading titleBoxChoose" style="display: flex;justify-content: space-around;">
                        <h2 class="tabsTitle active" ng-click="tabsToggle(1)">私教排课</h2>
                        <h2 class="tabsTitle" ng-click="tabsToggle(2)">私教上课</h2>
                        <h2 class="tabsTitle" ng-click="tabsToggle(3)">小团体课产品</h2>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12" ng-show="tabsShow == 1">
                            <div class="col-lg-2 col-md-3 col-sm-5">
                                <select ng-model="chooseVenue" name="" id="" style="height: 35px;">
                                    <option value="">请选择场馆</option>
                                    <option value="{{w.id}}" ng-repeat="w in venueAll">{{w.name}}</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-5">
                                <select ng-model="chooseCourse" name="" id="" style="height: 35px;">
                                    <option value="">请选择课种</option>
                                    <option value="{{w.id}}" ng-repeat="w in choiceCourseNames">{{w.name}}</option>
                                </select>
                            </div>
                            <div class="col-lg-1 col-md-1 col-sm-1"></div>
                            <div class="input-group col-lg-4 col-md-4 col-sm-12">
                                <input type="text" class="form-control"
                                       ng-model="keywords" ng-keyup="enterSearchA($event)"
                                       style="height: 35px;" placeholder="请输入课程编号进行搜索...">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-sm" type="button" ng-click="buttonSearchA()" style="height: 35px;left: -1px;">搜索</button>
                                </span>
                                <span class="input-group-btn" >
                                    <button type="button" class="btn btn-info" ng-click="searchClearA()" style="margin-left: 10px;border-radius: 3px">清空</button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-12" ng-show="tabsShow == 2">
                            <div class="input-group col-lg-3 col-md-4 col-sm-5" style="float: left;height: 34px;">
                                <span class="input-group-addon"">选择日期</span>
                                <input type="text" readonly id="chooseDate" class="form-control text-center cp" style="width: 200px;height: 34px"/>
                            </div>
                            <div class="col-lg-2 col-md-3 col-sm-5">
                                <select ng-model="venueIds" id="" style="height: 34px;width: 100%">
                                    <option value="">请选择场馆</option>
                                    <option value="{{w.id}}" ng-repeat="w in venueAll">{{w.name}}</option>
                                </select>
                            </div>
                            <div class="input-group col-lg-4 col-md-4 col-sm-12">
                                <input type="text" class="form-control" ng-model="searchWords" ng-keyup="enterSearch($event)" style="height: 34px" placeholder="请输入课程编号进行搜索...">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-sm" type="button" ng-click="buttonSearch()" style="height: 34px">搜索</button>
                                </span>
                                <span class="input-group-btn" >
                                    <button type="button" class="btn btn-info" ng-click="searchClear()" style="margin-left: 10px;border-radius: 3px">清空</button>
                                </span>
                            </div>
                        </div>
                        <div class="row" ng-show="tabsShow == 3">
                            <div class="col-lg-2 col-md-3 col-sm-4">
                                <select ng-model="chooseVenue"  style="height: 35px;">
                                    <option value="">请选择场馆</option>
                                    <option value="{{w.id}}" ng-repeat="w in venueAll">{{w.name}}</option>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-4 col-sm-4">
                                <select ng-model="chooseCourse" name="" id="" style="height: 35px;">
                                    <option value="">请选择课种</option>
                                    <option value="{{w.id}}" ng-repeat="w in choiceCourseNames">{{w.name}}</option>
                                </select>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-1"></div>
                            <div class="input-group col-lg-4 col-md-6 col-sm-8" style="float: left">
                                <input type="text" ng-model="keywords" class="form-control" placeholder="请输入产品名称进行搜索..." style="height: 35px;">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-sm" ng-click="buttonSearchC()" type="button" style="height: 35px;">搜索</button>
                                </span>
                                <span class="input-group-btn" >
                                    <button type="button" class="btn btn-info" ng-click="searchClearC()" style="margin-left: 10px;border-radius: 3px">清空</button>
                                </span>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-3">
                                <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: 12px;height: 35px;">新增小团体课产品</button>
                                <ul class="dropdown-menu dropdown-menu-left">
                                    <li style="text-align: center;padding-top: 10px;">选择新增类型</li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="/private-lesson-group/add-many-class-server">新增多人多课种产品</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="/private-lesson-group/add-many-class-lesson">新增多人单课种产品</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="titleBoxTable" ng-show="tabsShow == 1" >
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>产品名称</th>
                                    <th>课种名称</th>
                                    <th>课程编号</th>
                                    <th>剩余/总节数</th>
                                    <th>课程人数</th>
                                    <th>课程有效期</th>
                                    <th>最后上课日期</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="(index,arrangeClass) in arrangeClassList">
                                    <td>{{arrangeClass.className | noData:''}}</td>
                                    <td>{{arrangeClass.courseName | noData:''}}</td>
                                    <td>{{arrangeClass.class_number | noData:''}}</td>
                                    <td>{{arrangeClass.attend_class_num | noData:''}}/{{arrangeClass.total_class_num | noData:''}}</td>
                                    <td>{{arrangeClass.sell_number | noData:''}}</td>
                                    <td>
                                        <span ng-if="arrangeClass.valid_start_time != null">
                                            {{arrangeClass.valid_start_time *1000 | date:'yyyy-MM-dd' | noData:''}} 至
                                            {{arrangeClass.validTime *1000 | date:'yyyy-MM-dd' | noData:''}}
                                        </span>
                                        <span ng-if="arrangeClass.valid_start_time == null">不限</span>
                                    </td>
                                    <td>{{arrangeClass.class_date | noData:''}}</td>
                                    <td>
                                        <button class="btn btn-success" data-toggle="modal"
                                                ng-click="weekClassData(arrangeClass.id,arrangeClass.valid_start_time,arrangeClass.validTime)"
                                                style="font-size: 12px;width: 80px;">排课</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?=$this->render('@app/views/common/nodata.php',['name'=>'arrangeDataInfo','href'=>true]);?>
                        <?=$this->render('@app/views/common/pagination.php',['page'=>'arrangeClassPage']);?>
                    </div>
                    <div id="titleBoxTable2" ng-show="tabsShow == 2" >
                        <table class="table" style="border-top: 1px solid #ddd;">
                            <thead>
                                <tr>
                                    <th>课程名称</th>
                                    <th>课程编号</th>
                                    <th>已预约/总人数</th>
                                    <th>教练</th>
                                    <th>状态</th>
                                    <th>日期</th>
                                    <th>上课时间</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="attendClass in attendClassList">
                                    <td>{{attendClass.className | noData:''}}</td>
                                    <td>{{attendClass.class_number | noData:''}}</td>
                                    <td>{{aboutNum[$index + 8*(pagesNow - 1)] | noData:''}}/{{attendClass.sell_number | noData:''}}</td>
                                    <td>{{attendClass.coachName | noData:''}}</td>
                                    <td>
                                        <span ng-if="attendClass.status == 1">正常</span>
                                        <span ng-if="attendClass.status == 2">已预约</span>
                                        <span ng-if="attendClass.status == 3">上课中</span>
                                        <span ng-if="attendClass.status == 4">已下课</span>
                                        <span ng-if="attendClass.status == 5">已取消</span>
                                    </td>
                                    <td>{{attendClass.class_date | noData:''}}</td>
                                    <td>{{attendClass.start *1000 | date:'HH:mm' | noData:''}} - {{attendClass.end *1000 | date:'HH:mm' | noData:''}}</td>
                                    <td>
                                        <button class="btn btn-success" data-toggle="modal"
                                                ng-disabled="attendClass.status == '5'"
                                                ng-click="aboutDetailsClick(attendClass.id)"
                                                style="font-size: 12px;width: 80px;">查看详情</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/nodata.php',['name'=>'classDataInfo','href'=>true])?>
                        <?=$this->render('@app/views/common/pagination.php',['page'=>'attendClassPage']);?>
                    </div>
                    <div id="titleBoxTable3" ng-show="tabsShow == 3">
                        <table class="table" style="border-top: 1px solid #ddd;">
                            <thead>
                            <tr>
                                <th>产品名称</th>
                                <th>所属场馆</th>
                                <th>课种名称</th>
                                <th>产品有效期</th>
                                <!--<th>总售价</th>-->
                                <th>售卖剩余数量</th>
                                <th>售卖日期</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>    
                            <tr ng-repeat="data in datas">  
                                <td>{{ data.name }}</td>
                                <td>{{ data.venueName }}</td>
                                <td>
                                    <span ng-repeat="courseName in data.coursePackageDetail" class="addFlash">
                                        {{courseName.course.name}}
                                    </span>
                                </td>
                                <td ng-if="data.valid_time != null">{{ data.valid_time }}天</td>
                                <td ng-if="data.valid_time == null">暂无数据</td>
                                <!--<td ng-if="data.total_amount != null">¥{{ data.total_amount }}</td>
                                <td ng-if="data.total_amount == null">暂无数据</td>-->
                                <td>{{ data.sale_num }}/{{ data.chargeClassNumber[0].surplus_sale_num  }}</td>
                                <td>{{ data.sale_start_time *1000 | date:'yyyy-MM-dd' }} 至 {{ data.sale_end_time *1000 | date:'yyyy-MM-dd' }}</td>
                                <td>
                                    <span class="label label-danger" ng-if="data.status == 2">冻结</span>
                                    <span class="label label-warning" ng-if="data.status == 3">过期</span>
                                    <span class="label label-success" ng-if="data.status == 1">正常</span>
                                </td>
                                <td>
                                    <button ng-disabled="data.chargeClassNumber[0].surplus_sale_num == '0' || data.status == '3'" class="btn btn-success" ng-click="getPriceLimitData(data.id,data.name,data.pic,data.type,data.original_price,data.chargeClassNumber[0].surplus_sale_num)" data-toggle="modal" data-target="#heiheiModal" style="font-size: 12px;height: 35px;">购买私课</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <?= $this->render('@app/views/common/nodata.php',['name'=>'chargeDataInfo','href'=>true])?>
                        <?=$this->render('@app/views/common/pagination.php',['page'=>'pageClass']);?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  私教小团体课排课课程表模态框  -->
    <div class="modal fade" id="weekClassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 75%;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="modal-title text-center">
                        <div class="titleDate-1" style="width: 300px;margin: 0 auto;">
                            <span class="glyphicon glyphicon-chevron-left" ng-click="dateBack()"></span>
                            <span class="nowWeek">&nbsp;&nbsp;&nbsp;{{listData.week1[0].class_date}}&nbsp;-&nbsp;{{listData.week7[0].class_date}}&nbsp;&nbsp;&nbsp;</span>
                            <span class="nextWeek" style="display: none;">&nbsp;&nbsp;&nbsp;{{dateSta1 | date:'yyyy-MM-dd'}}&nbsp;-&nbsp;{{dateSta2 | date:'yyyy-MM-dd'}}&nbsp;&nbsp;&nbsp;</span>
                            <span class="glyphicon glyphicon-chevron-right clickNext" ng-click="dateNext()" style="color: #b1b1b1;"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-body modelBox" style="padding: 0;height: 750px;background: #fff;">
                    <div class="pull-left" style="width: 14.28%;">
                        <div class="col-sm-12 pd0 contentBoxAdd">
                            <div class="text-center" style="line-height: 34px;height: 50px;background: #ccc;">
                                <p>星期一</p>
                                <p style="line-height: 0px;">{{listData.week1[0].class_date}}</p>
                            </div>
                            <div class="infoBox" ng-repeat="w in listData.week1" ng-if="w.data == true"
                                 ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro' : ''">
                                <p class="infoBoxp1">
                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                </p>
                                <p class="infoBoxp2">
                                    <span ng-if="w.start != null">第{{w.num}}节 / {{w.className}}</span>
                                </p>
                                <p class="infoBoxp3">
                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}</span>
                                </p>
                            </div>
                            <div class="addBox" ng-click="classClick(listData.week1[0].class_date)">
                                <p class="hoverP hoverPs" style="margin-top: 35px;">点击进行排课</p>
                            </div>
                        </div>
<!--                        <div class="col-sm-12 pd0">-->
<!--                            <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">-->
<!--                                <p class="hoverBoxsp">点击添加排课列表</p>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <div class="pull-left" style="width: 14.28%;">
                        <div class="col-sm-12 pd0 contentBoxAdd">
                            <div class="text-center" style="line-height: 34px;height: 50px;background: #ccc;">
                                <p>星期二</p>
                                <p style="line-height: 0px;">{{listData.week2[0].class_date}}</p>
                            </div>
                            <div class="infoBox" ng-repeat="w in listData.week2" ng-if="w.data == true"
                                 ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro' : ''">
                                <p class="infoBoxp1">
                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                </p>
                                <p class="infoBoxp2">
                                    <span ng-if="w.start != null">第{{w.num}}节 / {{w.className}}</span>
                                </p>
                                <p class="infoBoxp3">
                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}</span>
                                </p>
                            </div>
                            <div class="addBox" ng-click="classClick(listData.week2[0].class_date)">
                                <p class="hoverP hoverPs" style="margin-top: 35px;">点击进行排课</p>
                            </div>
                        </div>
<!--                        <div class="col-sm-12 pd0">-->
<!--                            <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">-->
<!--                                <p class="hoverBoxsp">点击添加排课列表</p>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <div class="pull-left" style="width: 14.28%;">
                        <div class="col-sm-12 pd0 contentBoxAdd">
                            <div class="text-center" style="line-height: 34px;height: 50px;background: #ccc;">
                                <p>星期三</p>
                                <p style="line-height: 0px;">{{listData.week3[0].class_date}}</p>
                            </div>
                            <div class="infoBox" ng-repeat="w in listData.week3" ng-if="w.data == true"
                                 ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro' : ''">
                                <p class="infoBoxp1">
                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                </p>
                                <p class="infoBoxp2">
                                    <span ng-if="w.start != null">第{{w.num}}节 / {{w.className}}</span>
                                </p>
                                <p class="infoBoxp3">
                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}</span>
                                </p>
                            </div>
                            <div class="addBox" ng-click="classClick(listData.week3[0].class_date)">
                                <p class="hoverP hoverPs" style="margin-top: 35px;">点击进行排课</p>
                            </div>
                        </div>
<!--                        <div class="col-sm-12 pd0">-->
<!--                            <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">-->
<!--                                <p class="hoverBoxsp">点击添加排课列表</p>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <div class="pull-left" style="width: 14.28%;">
                        <div class="col-sm-12 pd0 contentBoxAdd">
                            <div class="text-center" style="line-height: 34px;height: 50px;background: #ccc;">
                                <p>星期四</p>
                                <p style="line-height: 0px;">{{listData.week4[0].class_date}}</p>
                            </div>
                            <div class="infoBox" ng-repeat="w in listData.week4" ng-if="w.data == true"
                                 ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro' : ''">
                                <p class="infoBoxp1">
                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                </p>
                                <p class="infoBoxp2">
                                    <span ng-if="w.start != null">第{{w.num}}节 / {{w.className}}</span>
                                </p>
                                <p class="infoBoxp3">
                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}</span>
                                </p>
                            </div>
                            <div class="addBox" ng-click="classClick(listData.week4[0].class_date)">
                                <p class="hoverP hoverPs" style="margin-top: 35px;">点击进行排课</p>
                            </div>
                        </div>
<!--                        <div class="col-sm-12 pd0">-->
<!--                            <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">-->
<!--                                <p class="hoverBoxsp">点击添加排课列表</p>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <div class="pull-left" style="width: 14.28%;">
                        <div class="col-sm-12 pd0 contentBoxAdd">
                            <div class="text-center" style="line-height: 34px;height: 50px;background: #ccc;">
                                <p>星期五</p>
                                <p style="line-height: 0px;">{{listData.week5[0].class_date}}</p>
                            </div>
                            <div class="infoBox" ng-repeat="w in listData.week5" ng-if="w.data == true"
                                 ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro' : ''">
                                <p class="infoBoxp1">
                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                </p>
                                <p class="infoBoxp2">
                                    <span ng-if="w.start != null">第{{w.num}}节 / {{w.className}}</span>
                                </p>
                                <p class="infoBoxp3">
                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}</span>
                                </p>
                            </div>
                            <div class="addBox" ng-click="classClick(listData.week5[0].class_date)">
                                <p class="hoverP hoverPs" style="margin-top: 35px;">点击进行排课</p>
                            </div>
                        </div>
<!--                        <div class="col-sm-12 pd0">-->
<!--                            <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">-->
<!--                                <p class="hoverBoxsp">点击添加排课列表</p>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <div class="pull-left" style="width: 14.28%;">
                        <div class="col-sm-12 pd0 contentBoxAdd">
                            <div class="text-center" style="line-height: 34px;height: 50px;background: #ccc;">
                                <p>星期六</p>
                                <p style="line-height: 0px;">{{listData.week6[0].class_date}}</p>
                            </div>
                            <div class="infoBox" ng-repeat="w in listData.week6" ng-if="w.data == true"
                                 ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro' : ''">
                                <p class="infoBoxp1">
                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                </p>
                                <p class="infoBoxp2">
                                    <span ng-if="w.start != null">第{{w.num}}节 / {{w.className}}</span>
                                </p>
                                <p class="infoBoxp3">
                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}</span>
                                </p>
                            </div>
                            <div class="addBox" ng-click="classClick(listData.week6[0].class_date)">
                                <p class="hoverP hoverPs" style="margin-top: 35px;">点击进行排课</p>
                            </div>
                        </div>
<!--                        <div class="col-sm-12 pd0">-->
<!--                            <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">-->
<!--                                <p class="hoverBoxsp">点击添加排课列表</p>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <div class="pull-left" style="width: 14.28%;">
                        <div class="col-sm-12 pd0 contentBoxAdd">
                            <div class="text-center" style="line-height: 34px;height: 50px;background: #ccc;">
                                <p>星期日</p>
                                <p style="line-height: 0px;">{{listData.week7[0].class_date}}</p>
                            </div>
                            <div class="infoBox" ng-repeat="w in listData.week7" ng-if="w.data == true"
                                 ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro' : ''">
                                <p class="infoBoxp1">
                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                </p>
                                <p class="infoBoxp2">
                                    <span ng-if="w.start != null">第{{w.num}}节 / {{w.className}}</span>
                                </p>
                                <p class="infoBoxp3">
                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}</span>
                                </p>
                            </div>
                            <div class="addBox" ng-click="classClick(listData.week7[0].class_date)">
                                <p class="hoverP hoverPs" style="margin-top: 35px;">点击进行排课</p>
                            </div>
                        </div>
<!--                        <div class="col-sm-12 pd0">-->
<!--                            <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">-->
<!--                                <p class="hoverBoxsp">点击添加排课列表</p>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>
                <div class="modal-body modelNext" style="padding: 0;height: 500px;background: #fff;display: none;">
                    <div class="pull-left" style="width: 14.28%;">
                        <div class="col-sm-12 pd0 contentBoxAdd">
                            <div class="text-center" style="line-height: 34px;height: 50px;background: #ccc;">
                                <p>星期一</p>
                                <p style="line-height: 0px;">{{listDataN.week1[0].class_date}}</p>
                            </div>
                            <div class="infoBox" ng-repeat="w in listDataN.week1" ng-if="w.data == true"
                                 ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro' : ''">
                                <p class="infoBoxp1">
                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                </p>
                                <p class="infoBoxp2">
                                    <span ng-if="w.start != null">第{{w.num}}节 / {{w.className}}</span>
                                </p>
                                <p class="infoBoxp3">
                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}</span>
                                </p>
                            </div>
                            <div class="addBox" ng-click="classClick(listDataN.week1[0].class_date)">
                                <p class="hoverP hoverPs" style="margin-top: 35px;">点击进行排课</p>
                            </div>
                        </div>
<!--                        <div class="col-sm-12 pd0">-->
<!--                            <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">-->
<!--                                <p class="hoverBoxsp">点击添加排课列表</p>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <div class="pull-left" style="width: 14.28%;">
                        <div class="col-sm-12 pd0 contentBoxAdd">
                            <div class="text-center" style="line-height: 34px;height: 50px;background: #ccc;">
                                <p>星期二</p>
                                <p style="line-height: 0px;">{{listDataN.week2[0].class_date}}</p>
                            </div>
                            <div class="infoBox" ng-repeat="w in listDataN.week2" ng-if="w.data == true"
                                 ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro' : ''">
                                <p class="infoBoxp1">
                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                </p>
                                <p class="infoBoxp2">
                                    <span ng-if="w.start != null">第{{w.num}}节 / {{w.className}}</span>
                                </p>
                                <p class="infoBoxp3">
                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}</span>
                                </p>
                            </div>
                            <div class="addBox" ng-click="classClick(listDataN.week2[0].class_date)">
                                <p class="hoverP hoverPs" style="margin-top: 35px;">点击进行排课</p>
                            </div>
                        </div>
<!--                        <div class="col-sm-12 pd0">-->
<!--                            <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">-->
<!--                                <p class="hoverBoxsp">点击添加排课列表</p>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <div class="pull-left" style="width: 14.28%;">
                        <div class="col-sm-12 pd0 contentBoxAdd">
                            <div class="text-center" style="line-height: 34px;height: 50px;background: #ccc;">
                                <p>星期三</p>
                                <p style="line-height: 0px;">{{listDataN.week3[0].class_date}}</p>
                            </div>
                            <div class="infoBox" ng-repeat="w in listDataN.week3" ng-if="w.data == true"
                                 ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro' : ''">
                                <p class="infoBoxp1">
                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                </p>
                                <p class="infoBoxp2">
                                    <span ng-if="w.start != null">第{{w.num}}节 / {{w.className}}</span>
                                </p>
                                <p class="infoBoxp3">
                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}</span>
                                </p>
                            </div>
                            <div class="addBox" ng-click="classClick(listDataN.week3[0].class_date)">
                                <p class="hoverP hoverPs" style="margin-top: 35px;">点击进行排课</p>
                            </div>
                        </div>
<!--                        <div class="col-sm-12 pd0">-->
<!--                            <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">-->
<!--                                <p class="hoverBoxsp">点击添加排课列表</p>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <div class="pull-left" style="width: 14.28%;">
                        <div class="col-sm-12 pd0 contentBoxAdd">
                            <div class="text-center" style="line-height: 34px;height: 50px;background: #ccc;">
                                <p>星期四</p>
                                <p style="line-height: 0px;">{{listDataN.week4[0].class_date}}</p>
                            </div>
                            <div class="infoBox" ng-repeat="w in listDataN.week4" ng-if="w.data == true"
                                 ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro' : ''">
                                <p class="infoBoxp1">
                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                </p>
                                <p class="infoBoxp2">
                                    <span ng-if="w.start != null">第{{w.num}}节 / {{w.className}}</span>
                                </p>
                                <p class="infoBoxp3">
                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}</span>
                                </p>
                            </div>
                            <div class="addBox" ng-click="classClick(listDataN.week4[0].class_date)">
                                <p class="hoverP hoverPs" style="margin-top: 35px;">点击进行排课</p>
                            </div>
                        </div>
<!--                        <div class="col-sm-12 pd0">-->
<!--                            <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">-->
<!--                                <p class="hoverBoxsp">点击添加排课列表</p>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <div class="pull-left" style="width: 14.28%;">
                        <div class="col-sm-12 pd0 contentBoxAdd">
                            <div class="text-center" style="line-height: 34px;height: 50px;background: #ccc;">
                                <p>星期五</p>
                                <p style="line-height: 0px;">{{listDataN.week5[0].class_date}}</p>
                            </div>
                            <div class="infoBox" ng-repeat="w in listDataN.week5" ng-if="w.data == true"
                                 ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro' : ''">
                                <p class="infoBoxp1">
                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                </p>
                                <p class="infoBoxp2">
                                    <span ng-if="w.start != null">第{{w.num}}节 / {{w.className}}</span>
                                </p>
                                <p class="infoBoxp3">
                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}</span>
                                </p>
                            </div>
                            <div class="addBox" ng-click="classClick(listDataN.week5[0].class_date)">
                                <p class="hoverP hoverPs" style="margin-top: 35px;">点击进行排课</p>
                            </div>
                        </div>
<!--                        <div class="col-sm-12 pd0">-->
<!--                            <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">-->
<!--                                <p class="hoverBoxsp">点击添加排课列表</p>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <div class="pull-left" style="width: 14.28%;">
                        <div class="col-sm-12 pd0 contentBoxAdd">
                            <div class="text-center" style="line-height: 34px;height: 50px;background: #ccc;">
                                <p>星期六</p>
                                <p style="line-height: 0px;">{{listDataN.week6[0].class_date}}</p>
                            </div>
                            <div class="infoBox" ng-repeat="w in listDataN.week6" ng-if="w.data == true"
                                 ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro' : ''">
                                <p class="infoBoxp1">
                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                </p>
                                <p class="infoBoxp2">
                                    <span ng-if="w.start != null">第{{w.num}}节 / {{w.className}}</span>
                                </p>
                                <p class="infoBoxp3">
                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}</span>
                                </p>
                            </div>
                            <div class="addBox" ng-click="classClick(listDataN.week6[0].class_date)">
                                <p class="hoverP hoverPs" style="margin-top: 35px;">点击进行排课</p>
                            </div>
                        </div>
<!--                        <div class="col-sm-12 pd0">-->
<!--                            <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">-->
<!--                                <p class="hoverBoxsp">点击添加排课列表</p>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                    <div class="pull-left" style="width: 14.28%;">
                        <div class="col-sm-12 pd0 contentBoxAdd">
                            <div class="text-center" style="line-height: 34px;height: 50px;background: #ccc;">
                                <p>星期日</p>
                                <p style="line-height: 0px;">{{listDataN.week7[0].class_date}}</p>
                            </div>
                            <div class="infoBox" ng-repeat="w in listDataN.week7" ng-if="w.data == true"
                                 ng-class="{{courseTimeStamp > w.end * 1000}} ? 'gainsboro' : ''">
                                <p class="infoBoxp1">
                                    <span ng-if="w.start != null">{{w.start *1000 | date:'HH:mm' }}-</span>
                                    <span ng-if="w.end != null">{{w.end *1000 | date:'HH:mm'}}</span>
                                </p>
                                <p class="infoBoxp2">
                                    <span ng-if="w.start != null">第{{w.num}}节 / {{w.className}}</span>
                                </p>
                                <p class="infoBoxp3">
                                    <span ng-if="w.coachName != null">教练：{{w.coachName}}</span>
                                </p>
                            </div>
                            <div class="addBox" ng-click="classClick(listDataN.week7[0].class_date)">
                                <p class="hoverP hoverPs" style="margin-top: 35px;">点击进行排课</p>
                            </div>
                        </div>
<!--                        <div class="col-sm-12 pd0">-->
<!--                            <div class="hoverBox hoverBoxs" ng-click="hoverAdd()">-->
<!--                                <p class="hoverBoxsp">点击添加排课列表</p>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  点击排课模态框  -->
    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close closeBtnModal3" ng-click="close3()" data-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title textAlignCenterFontSize" id="myModalLabel">排课</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>"
                               value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <div class="form-group formGroupInput ">
                            <label class="col-sm-4 control-label formGroupSpan">
                                <span class="formGroupColor">*</span>上课教练
                            </label>
                            <div class="col-sm-8">
                                <div class="col-sm-12 pd0">
                                    <div class="col-sm-4 iconTitleBox pd0">
                                        <img ng-src="{{changeCoachsBOOL == true ? '/plugins/user/images/pt.png':changeCoachsPic}}"
                                            style="width: 50px;height: 50px;border-radius: 50%">
                                    </div>
                                    <div class="col-sm-8 pd0 boxText2" ng-click="boxText()">
                                        {{changeCoachsBOOL == true ? "请选择教练":changeCoachsName}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group formGroupInput">
                            <label class="col-sm-4 control-label formGroupSpan">
                                <span class="formGroupColor">*</span>上课时间
                            </label>
                            <div class="col-sm-8">
                                <div class="input-group clockpicker fl cp w90" data-autoclose="true">
                                    <input name="dayStart" ng-model="dayStart" ng-blur="dayStartModel(dayStart)"
                                           type="text" class="input-sm form-control text-center"
                                           placeholder="开始时间" style="width: 100px;border-radius: 3px;">
                                </div>
                                <div class="input-group clockpicker fl cp" data-autoclose="true"
                                     style="width: 100px;margin-left: 14px">
                                    <input name="dayEnd" ng-model="dayEnd" type="text"
                                           class="input-sm form-control text-center" placeholder="结束时间"
                                           style="width: 100%;border-radius: 3px;">
                                </div>
                            </div>
                        </div>
                        <div style="margin-left: 224px;">
                            <ul>
                                <li class="mL20">
                                    <span ng-if="numAndLength.totalNum != null">共{{numAndLength.totalNum}}节</span>
                                    <span ng-if="numAndLength.num != null"> / 第{{numAndLength.num }}节</span>
                                    <span ng-if="numAndLength.length != null && numAndLength.length != 0"> / {{numAndLength.length}}分钟</span>
                                </li>
                            </ul>
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
    <!--  排课里的选择教练-->
    <div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         style="width: 80%;margin: 0 auto;display: none;">
        <div class="modal-dialog width80" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
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
                    <div class="col-sm-4 pd0 mb10 changeCoachsDiv"
                         ng-mouseover="changeCoachs($event,$index)" ng-mouseleave="changeCoachLeave($event,$index)"
                         ng-repeat="($index,w) in ChangeCoachsBoxText">
                        <div class="col-sm-3 pt20px textAlignCenter">
                            <img ng-if="w.pic != ''" ng-src="{{w.pic}}" class="w50h50"
                                 style="border-radius: 50%">
                            <img ng-if="w.pic == ''" ng-src="/plugins/user/images/pt.png" class="w50h50">
                        </div>
                        <div class="col-sm-4 pd0">
                            <p class="changeCoachsName">
                                {{w.name}}
                            </p>
<!--                            <p class="mb10">-->
<!--                                <span ng-if="w.age != null">{{w.age}}岁</span>从业时间{{w.work_time}}年-->
<!--                            </p>-->
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
                </div>
            </div>
        </div>
    </div>
    <!--  预约详情模态框  -->
    <div class="modal fade" id="aboutDetailsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width: 75%;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">预约详情</h4>
                </div>
                <div class="modal-body" style="padding: 20px;height: 650px;background: #fff;">
                    <div class="row">
                        <div class="col-sm-12" ng-if="classDetails.status == '1'" style="color: #ffa999;">
                            <h4>已排课，待预约...</h4>
                            <h3 style="margin: 20px 0;">开课时间：{{classDetails.start *1000 | date:'yyyy-MM-dd HH:mm'}}</h3>
                        </div>
                        <div class="col-sm-12" ng-if="classDetails.status == '2'" style="color: #ffa500;">
                            <h4>已预约，待上课...</h4>
                            <h3 style="margin: 20px 0;">开课时间：{{classDetails.start *1000 | date:'yyyy-MM-dd HH:mm'}}</h3>
                        </div>
                        <div class="col-sm-12" ng-if="classDetails.status == '3'" style="color: #008000;">
                            <h4>上课中，待下课...</h4>
                            <h3 style="margin: 20px 0;">下课时间：{{classDetails.end *1000 | date:'yyyy-MM-dd HH:mm'}}</h3>
                        </div>
                        <div class="col-sm-12" ng-if="classDetails.status == '4'" style="color: #999999;">
                            <h4>已下课</h4>
                            <h3 style="margin: 20px 0;">最终下课时间：{{classDetails.end *1000 | date:'yyyy-MM-dd HH:mm'}}</h3>
                        </div>
                        <div class="col-sm-12">
                            <p style="display: inline-block;">
                                课程名称：<span>{{classDetails.name | noData:''}}</span> /
                                课程编号：<span>{{classDetails.class_number | noData:''}}</span> /
                                进度：第<span>{{classDetails.num | noData:''}}</span>节 /
                                <span>{{classDetails.courseName | noData:''}}</span> /
                                <span>{{classDetails.length | noData:''}}</span>分钟
                            </p>
                            <button class="btn btn-success pull-right"
                                    ng-if="classDetails.status == '1'"
                                    ng-click="registerClass()"
                                    style="font-size: 12px;">登记上课</button>
<!--                            <button class="btn btn-default pull-right"-->
<!--                                    ng-if="classDetails.status == '1'"-->
<!--                                    ng-click="cancelClass()"-->
<!--                                    style="font-size: 12px;margin-right: 1%;">取消课程</button>-->
                            <button class="btn btn-default pull-right"
                                    ng-if="classDetails.status == '3'"
                                    ng-click="advanceClass()"
                                    style="font-size: 12px;">提前下课</button>
                        </div>
                        <div class="col-sm-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>姓名</th>
                                        <th>性别</th>
                                        <th>手机号</th>
                                        <th>状态</th>
                                        <th>预约时间</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="aboutDetails in aboutDetails">
                                        <td>{{aboutDetails.name}}</td>
                                        <td>
                                            <span ng-if="aboutDetails.sex == '1'">男</span>
                                            <span ng-if="aboutDetails.sex == '2'">女</span>
                                            <span ng-if="aboutDetails.sex == null">暂无数据</span>
                                        </td>
                                        <td>{{aboutDetails.mobile | noData:''}}</td>
                                        <td>
                                            <span ng-if="aboutDetails.status == '1'">已预约</span>
                                            <span ng-if="aboutDetails.status == '2'">已取消</span>
                                            <span ng-if="aboutDetails.status == '3'">上课中</span>
                                            <span ng-if="aboutDetails.status == '4'">已下课</span>
                                            <span ng-if="aboutDetails.status == '8'">待预约</span>
                                            <span ng-if="aboutDetails.status == '9'">已作废</span>
                                        </td>
                                        <td>
                                            <span>{{aboutDetails.create_at *1000 | date:'yyyy-MM-dd HH:mm'}}</span>
                                        </td>
                                        <td>
                                            <span ng-if="aboutDetails.status == 4">已打卡</span>
                                            <button ng-if="aboutDetails.status == 3"
                                                    ng-click="overClassModal(aboutDetails.id,aboutDetails.member_id,aboutDetails.end)"
                                                    class="btn btn-success"
                                                    style="font-size: 12px;width: 100px;" data-toggle="modal">下课打卡</button>
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
    <!--  会员下课打卡模态框  -->
<!--    <div class="modal fade" id="overClassModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
<!--        <div class="modal-dialog modal-sm" role="document">-->
<!--            <div class="modal-content">-->
<!--                <div class="modal-body text-center">-->
<!--                    <img src="/plugins/privateLessonGroup/image/noPic.png" alt="" style="margin: 45px auto 20px;width: 55px;height: 55px;">-->
<!--                    <input type="hidden" id="whetherModify" />-->
<!--                    <h4 style="margin: 10px auto;">请通过指纹打卡来进行下课...</h4>-->
<!--                    <button class="btn btn-default" class="close" ng-click="overClass()" data-dismiss="modal" aria-label="Close" style="font-size: 12px;width: 100px;margin-top: 30px;">确定</button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <!--  会员下课打卡成功模态框  -->
<!--    <div class="modal fade" id="xixiModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">-->
<!--        <div class="modal-dialog modal-sm" role="document">-->
<!--            <div class="modal-content">-->
<!--                <div class="modal-body text-center">-->
<!--                    <img src="/plugins/privateLessonGroup/image/noPic.png" alt="" style="margin: 45px auto 20px;width: 55px;height: 55px;">-->
<!--                    <h4 style="margin: 10px auto;">已打卡成功！</h4>-->
<!--                    <button class="btn btn-default" data-dismiss="modal" aria-label="Close" style="font-size: 12px;width: 100px;margin-top: 30px;">关闭</button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <!--  指纹登记 -->
    <div class="modal fade" id="fingerprintInput" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">
                        指纹登记</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group ">
                            <div class="col-sm-6" style="width: 100%;height: 450px;">
                                <!--    验证指纹-->
                                <div id="box" class="box">
                                    <h2>指纹登记</h2>
                                    <div class="list">
                                        <canvas id="canvas" width="430" height="450" style="background: rgb(243, 245, 240)"></canvas>
                                        <input type="hidden" id="whetherModify" name="whetherModify" alt="" value="111" />
                                        <div style="position: absolute; left: 310px; top: 325px; width: 70px; height: 28px;">
                                            <button type="button" class="btn btn-success btn-sm button-form" id="submitButtonId" name="makeSureName"
                                                    onclick="submitEvent()" ng-disabled="true"
                                                    style="display: block; margin: 0 auto;text-align: center;">确定</button>
                                        </div>
<!--                                        <div style="position: absolute; left: 322px; top: 365px; width: 70px; height: 28px;">-->
<!--                                            <button type="button" class="btn btn-info  btn-sm button-form" id="closeButton" name="closeButton"-->
<!--                                                    onclick="cancelEvent(&quot;确认保存当前修改吗?&quot;, &quot;指纹数:&quot;);">取消</button>-->
<!--                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <div style="width: 100%;height: 50px;">
                        <button type="button" ng-disabled="true" id="clickFingerprint" style="display: block; margin: 0 auto;text-align: center;"
                                class="btn btn-success w100" ng-click="clickFingerprint()">验证指纹
                        </button>
                    </div>
                    <div id="fpRegisterDiv" class="btn btn-info">
                        <a id="fpRegister"
                           onclick='submitRegister("指纹", "指纹数:", "确认保存当前修改吗？", "驱动下载", false)'
                           title="请安装指纹驱动或启动该服务" class="showGray mt20"
                           onmouseover="this.className='showGray'" style="color: ghostwhite;">点击登记指纹</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  指纹下课 验证 -->
    <div class="modal fade" id="fingerprintVerification" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">指纹下课验证</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group mt20">
                            <div class="col-sm-6" style="width: 100%;height: 400px;">
                                <div id="comparisonDiv" class="box">
                                    <h2>指纹比对</h2>
                                    <div class="list">
                                        <canvas id="canvasComp" width="430" height="320"
                                                style="background: url('/plugins/privateLessonGroup/image/base_fpVerify.jpg') rgb(243, 245, 240);"></canvas>
                                        <input type="button" class="btn btn-success btn-sm" value="验证" ng-click='overClass()' style="margin-left: 190px;;"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
<!--                <div class="modal-footer">-->
<!--                    <div style="width: 100%;height: 50px;">-->
<!--                        <button type="button" style="display: block; margin: 0 auto;text-align: center;"-->
<!--                                class="btn btn-success w100" ng-click="fingerprintVerification()">关闭-->
<!--                        </button>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    </div>
    <!--  购买私课模态框1  -->
    <div class="modal fade" id="heiheiModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">购买私课</h4>
                </div>
                <div class="modal-body" style="padding: 0;">
                    <ul class="list-group">
                        <li class="list-group-item clearfix" ng-repeat="l in limitDatas" style="border-radius: 0;">
                            <img class="pull-left" style="display: inline-block;width: 100px;height: 100px;" ng-src="{{ limitDatas.pic }}" alt="">
                            <div class="pull-left" style="padding: 0 20px;line-height: 27px;color: #888;">
                                <h3 style="display: inline-block;color: #666">{{ limitDatas.name }}</h3><br>
                                <span ng-if="type == 1">{{ l.people_most }}人服务套餐</span><span ng-if="type == 2">{{ l.chargeClassPeople.people_most }}人课程套餐</span>&nbsp;<span>{{ l.total_class_num }}节</span><br>
                                <span>私课编号：<span>{{ l.class_number }}</span></span><br>
                                <span>售卖场馆：<span>{{ l.venueName }}</span></span>
                            </div>
                            <div class="pull-right" style="padding: 6px;font-family: 'Tahoma';font-weight: 500;color: #ffa500;">
                                <p>售卖总数: <span>{{ l.sell_number }}/{{ l.surplus }}</span></p>
                                <p>优惠价格: <span ng-if="limitDatas.type == 2">￥{{ l.total_class_num * l.unit_price }}</span><span ng-if="limitDatas.type == 1">￥{{ l.unit_price }}元</span></p>
                                <p>POS价格: <span ng-if="limitDatas.type == 2">￥{{ l.total_class_num * l.pos_price }}</span><span ng-if="limitDatas.type == 1">￥{{ l.pos_price }}元</span></p>
                            </div>
                            <div style="clear: both;"></div>
                            <button ng-if="type == 1" class="btn btn-success pull-right" ng-click="clickSelector(l,type)" data-toggle="modal" data-target="#huhuModal" style="margin: -20px 8px 0 0;font-size: 12px;">选择会员</button>
                            <button ng-if="type == 2" class="btn btn-success pull-right" ng-click="clickSelector(l,type)" data-toggle="modal" data-target="#huhuModal" style="margin: -20px 8px 0 0;font-size: 12px;">选择会员</button>

                        </li>
                        <?=$this->render('@app/views/common/nodata.php',['name'=>'nolimitDatas']);?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--  购买私课模态框2  -->
    <!--<div class="modal fade" id="heiheiModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">购买私课</h4>
                </div>
                <div class="modal-body" style="padding: 0;">
                    <ul class="list-group">
                        <li class="list-group-item clearfix" style="border-radius: 0;">
                            <img class="pull-left" style="display: inline-block;" src="/plugins/privateLessonGroup/image/noPic.png" alt="">
                            <div class="pull-left" style="padding: 10px 20px;line-height: 27px;color: #888;">
                                <h3 style="display: inline-block;color: #666">哈他瑜伽减脂套餐</h3><br>
                                <span>3-5人套餐</span><br>
                                <span>私课编号：<span>108851101001</span></span>
                            </div>
                            <div class="pull-right" style="width: 33%;height: 100px;border-left: 1px solid #eee;">
                                <p class="pull-right" style="padding: 6px;font-family: 'Tahoma';font-weight: 500;color: #ffa500;">
                                    <span>12节</span>&nbsp;/&nbsp;<span>￥2000</span>
                                </p>
                                <div style="clear: both;"></div>
                                <button class="btn btn-success pull-right" data-toggle="modal" data-target="#huhuModal" style="margin: 30px 8px 0 0;font-size: 12px;">选择私课</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>-->
    <!--  输入会员手机号或卡号搜索模态框  -->
    <div class="modal fade" id="huhuModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel">购买私课</h4>
                </div>
                <div class="modal-body text-center">
                    <div class="row">
                        <div class="col-sm-12" style="margin: 50px auto 10px">
                            <h3>搜索会员</h3>
                            <div class="input-group" style="width: 75%;margin: 50px auto;">
                                <input type="text" ng-model="cardNumber" class="form-control" style="height: 35px;" placeholder="请输入会员卡卡号进行搜索...">
                                <span class="input-group-btn" ng-click="searchCardMember()">
                                    <button class="btn btn-primary btn-sm"  data-toggle="modal"  type="button" style="height: 35px;width: 60px;">搜索</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--私教购买-->
    <div class="modal fade" id="henghengModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="min-width: 720px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center">私课购买</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-5 text-left"
                                 style="padding-bottom: 10px;">
                                <div class="text-center">
                                </div>
                                <div class="text-center">
                                    <img ng-if="userInfo.pic  == null" src="/plugins/checkCard/img/11.png" style="width: 140px;">
                                    <img ng-if="userInfo.pic  != null" ng-src="{{ userInfo.pic }}" style="width: 140px;">
                                </div>
                                <div style="margin-top: 20px;">
                                    <ul class="memberDetailPanel">
                                        <li ng-if="userInfo.name != null">姓名:<span>{{ userInfo.name }}</span></li>
                                        <li ng-if="userInfo.name == null">姓名:<span>暂无数据</span></li>
                                        <li ng-if="userInfo.sex == 1">性别:<span>男</span></li>
                                        <li ng-if="userInfo.sex == 2">性别:<span>女</span></li>
                                        <li ng-if="userInfo.sex != 1 && userInfo.sex != 2">性别:<span>暂无数据</span></li>
                                        <li>年龄:<span>{{ userInfo.birth_date | birth }}</span></li>
                                        <li>生日:<span>{{ userInfo.birth_date }}</span></li>
                                        <li ng-if="userInfo.id_card !=null">证件号:<span>{{ userInfo.id_card }}</span></li>
                                        <li ng-if="userInfo.id_card ==null">证件号:<span>暂无数据</span></li>
                                        <li>手机号:
                                            <span ng-if="userInfo.mobile != null">{{ userInfo.mobile }}</span>
                                            <span ng-if="userInfo.mobile == null">暂无数据</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-7 buyPrivateClassPanel" style="color: #999999;font-size: 12px;border-left: solid 1px #e5e5e5;padding-left: 8.33333333%">
                                <div class="col-sm-12 pd0">
                                    <ul>
                                        <li class="col-sm-4">
                                            <span class="red">*</span>
                                            <span>缴费日期</span>
                                        </li>
                                        <li class="col-sm-8">
                                            <input type="text" ng-model="create_at" id="registerDate" class="form-control" placeholder="请选择登记日期">
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-12 pd0">
                                    <ul>
                                        <li class="col-sm-4">
                                            <span class="red">*</span>
                                            <span>应付金额</span>
                                        </li>
                                        <li class="col-sm-8" style="text-align: center;">
                                            <input type="text" ng-model="primePrice" min="0" class="form-control" placeholder="应付金额">
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-12 pd0">
                                    <ul>
                                        <li class="col-sm-4">
                                            <span class="red">*</span>
                                            <span>销售私教</span>
                                        </li>
                                        <li class="col-sm-8">
                                            <select class="form-control" style="padding: 4px 6px;" ng-model="coachId">
                                                <option value="" ng-selected>请选择销售私教</option>
                                                <option value="{{w.id}}" ng-repeat="w in privateCoach">{{w.name}}</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-12 pd0">
                                    <ul>
                                        <li class="col-sm-4">
                                            <span class="red">*</span>
                                            <span>销售渠道</span>
                                        </li>
                                        <li class="col-sm-8">
                                            <select ng-model="saleType" class="form-control" style="padding: 4px 6px;">
                                                <option value="" ng-selected>请选择</option>
                                                <option value="{{w.id}}" ng-repeat="w in memberSearchData">{{w.value}}</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div id="payWays" class="col-sm-12 pd0 addPayWaysDiv">
                                    <div class="removeDiv">
                                    <ul style="display: inline-block">
                                        <li class="col-sm-4">
                                            <span class="red">*</span>
                                            <span>付款途径</span>
                                        </li>
                                        <li class="col-sm-8">
                                            <select ng-model="payMethod" class="col-sm-5 pd0 form-control" style="padding: 4px 5px;width: 48%;">
                                                <option value="">请选择</option>
                                                <option value="1">现金</option>
                                                <option value="3">微信</option>
                                                <option value="2">支付宝</option>
                                                <option value="5" >建设分期</option>
                                                <option value="6" >广发分期</option>
                                                <option value="7" >招行分期</option>
                                                <option value="8" >借记卡</option>
                                                <option value="9" >贷记卡</option>
                                            </select>
                                            <input type="text" inputnum ng-model="price" ng-change="getTotalPrice(price)"  class="col-sm-7 form-control" style="width: 48%;margin-left: 4%;">
                                        </li>
                                    </ul>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-right addPayWaysBox" style="padding-right: 13%;">
                                    <button id="addPayWays" ng-click="addPayWaysHtml()" venuehtml class="btn btn-default" style="font-size: 13px;">新增付款途径</button>
                                    总金额：<span>{{ totalPayPrice }}</span>元
                                </div>
                                <div class="col-sm-12 pd0">
                                    <ul>
                                        <li class="col-sm-4">
                                            <span class="red">*</span>
                                            <span>收款方式</span>
                                        </li>
                                        <li class="col-sm-8">
                                            <select ng-model="payType" disabledSelect class="form-control" style="padding: 4px 6px;">
                                                <option  value="" >选择付款方式</option>
                                                <option  value="1" selected>全款</option>
                                                <option ng-if="subscription123 != null" value="2">押金</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-12 pd0">
                                    <ul>
                                        <li class="col-sm-4">
                                            <span class="red">*</span>
                                            <span>赠品</span>
                                        </li>
                                        <li class="col-sm-8">
                                            <select ng-model="giftType" class="form-control" style="padding: 4px 6px;">
                                                <option value="" selected>请选择</option>
                                                <option value="2">已领取</option>
                                                <option value="1">未领取</option>
                                            </select>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-12 pd0">
                                    <!--<ul>
                                        <li class="col-sm-4">
                                            <span>*</span>
                                            <span>指纹</span>
                                        </li>-->
                                        <!--<li class="col-sm-8 text-left">
                                            <img src="/plugins/checkCard/img/11.png" style="height: 80px;width: 80px;border: 1px solid #eee;">
                                        </li>-->
                                        <!-- <div id="fpRegisterDiv"   style="display: inline; height: 80px;width:80px;position: absolute;left: 220px;border: 1px solid #eee;">
                                            <a id="fpRegister"
                                               onclick='submitRegister("指纹", "指纹数:", "确认保存当前修改吗？", "驱动下载", false)'
                                               title="请安装指纹驱动或启动该服务" class="showGray"
                                               onmouseover="this.className='showGray'">请安装指纹驱动</a>
                                        </div> -->
                                    </ul>
                                </div>
                                <div class="col-sm-12 pd0">
                                    <ul>
                                        <li class="col-sm-4">
                                            <span>&nbsp</span>
                                            <span>私课备注</span>
                                        </li>
                                        <li class="col-sm-8">
                                            <textarea ng-model="buyNote" class="form-control" style="resize: none;"></textarea>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-sm-12 pd0" style="text-align: right;">
                                    <ul>
                                        <li>
                                            <!--<div style="display: inline-flex;flex-direction: column;justify-content: center;line-height: 16px;;">-->
                                                <!--<span>有效期:-->
                                                    <!--<b>{{}}月</b>-->
                                                   <!-- <b>暂无数据</b>-->
                                                <!--</span>-->
                                                <!--<span>定金: <b>{{}}元</b></span>
                                                <span>抵劵: <b>{{}}</b>元</span>-->
                                           <!-- </div>-->
                                            <div style="color: #f9d21a;">
                                                <span style="font-size: 16px;">应付金额:<span>{{ primePrice }}</span>元</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div  class="text-center">
                                    <button style="width: 100px;" ng-click="postHttp()" type="button" class="btn btn-success">
                                        完成
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>