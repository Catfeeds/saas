<?php
use backend\assets\LeagueCtrlAsset;
LeagueCtrlAsset::register($this);
$this->title = '课程详情';
?>
<div class="wrapper wrapper-content"  ng-controller='leagueDetailController' ng-cloak>
    <div class="row">
    <div class="col-sm-12">
    <div class="panel panel-default ">
        <div class="panel-heading"> <h2><b>团课详情</b></h2></div>
        <div class="panel-body">

            <div class="col-sm-10  text-right f14">
                <li class="new_add" id="tmk">
<!--                    <a href="" class="glyphicon glyphicon-plus" data-toggle="modal" data-target=".bs-example-modal-sm">新增课程</a>-->
                    <a href="/league/add?&c=5" class="glyphicon glyphicon-plus" style="float: right">新增课程</a>
                </li>
            </div>

        </div>
    </div>
    </div>
    <div class="col-sm-12">
    <div class="ibox-content" style="">
        <section class="w50">
            <div class="">
                <ul>
                    <li class="courseContent">
                        <div class="coursoeNum h86">
                            <div >
                                <h4>{{detailObj.course.name|noData:''}} <span>4.0分</span></h4>
                                <span>{{detailObj.class_date | noData:'日'}}{{detailObj.start*1000 | noData:'' | date:'HH:mm' }}  </span>

                            </div>
                            <div >
                                <span>{{detailObj.aboutClass.length|noData:''}}/{{detailObj.classroom.total_seat|noData:''}}</span>
                                <span>已预约人数 </span>
                            </div>
                        </div>
                    </li>
                    <li class="courseAddress ">
                        <ul class="h86">
                            <li class="address">
                                <div>
                                    <h4>{{detailObj.venue_id.organization.name|noData:''}}</h4>
                                    <span>{{detailObj.venue_id.organization.address|noData:''}}</span>
                                </div>
                                <span class="glyphicon glyphicon-menu-right"></span>
                            </li>
                            <li >
                                <div style="border-left: solid 1px grey;height: 50px;width: 1px; margin-right: 15px;"></div>
                                <div class="map">
                                    <span class="glyphicon glyphicon-map-marker"></span>
                                    <span>地图</span>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="courseDetail">
                <div class="coachMess clearfix">
                    <div class="fl headImg"><span class="glyphicon glyphicon-user"></span></div>
                    <ul class="fl nameMess ">
                        <li>
                            {{detailObj.employee.name|noData:''}}
                        </li>
                        <li>{{detailObj.employee.age |noData:'岁'}} 从业时间  {{detailObj.employee.entry_date |noData:''}}</li>
                        <li style="display: flex;">
                            <ul style="display: flex;">
                                <li><img src="/plugins/league/imgs/u13.png"/></li>
                                <li><img src="/plugins/league/imgs/u13.png"/></li>
                                <li><img src="/plugins/league/imgs/u13.png"/></li>
                                <li><img src="/plugins/league/imgs/u13.png"/></li>
                                <li><img src="/plugins/league/imgs/u21.png"/></li>
                            </ul>
                            <span>
                                4.0 分
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="courseDescribe">
                    <h6>
                        {{detailObj.course.name|noData:''}}
                    </h6>
                    <p>{{detailObj.course.course_desrc | noData:''}}</p>

                </div>
            </div>

            <div class="dueDate">
                <div class="selectShow">
                    <ul>
                        <li><div class=""></div><span > &emsp;未预约</span></li>
                        <li><div class="selectYes"><span class="glyphicon glyphicon-ok"></span></div><span >&emsp;已预约</span></li>
                    </ul>
                </div>

                <div class="subscribeSelect cp row">

                    <div class="col-lg-1" ng-repeat="(index,seat) in detailObj.seats">

                            <div class="">
                                <div class="yesSel"><span class=" yesSel" ng-if="seat.aboutClass == null">无人</span></div>
                            </div>
<!--                                <span style="width:39px;position: absolute;top:33px;left: 0px;" ng-if="seat.aboutClass != null">{{seat.member.name}}</span>-->
                        <div>
                                <div class="selectYes" style="height: 40px;line-height: 40px;text-align: center;" ng-if="seat.aboutClass != null"><span class="glyphicon glyphicon-ok" style="color: #fff;"></span></div>
                        </div>
                        <h6><span  class="selectName" ng-if="seat.aboutClass != null">{{seat.member.name}}</span></h6>



<!--                        <li>-->
<!--                            <div class="">-->
<!--                                <span class=" yesSel"></span>-->
<!--                            </div>-->
<!---->
<!--                            <h6 ><span  class="selectName">张薇薇</span></h6>-->
<!--                        </li>-->

                    </div>
                </div>
                <div class="clearfix" >
                <div class="btn btn-primary backBut fl" style="width: 100px;">返回</div>
<!--                   <div class="btn btn-success nextStep fr" style="width: 100px">编辑</div>-->
                </div>

        </section>
    </div>
    </div>
        <!--模态框-->
<!--        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">-->
<!--            <div class="modal-dialog modal-sm" role="document" id="mutaikuang">-->
<!--                <div class="modal-content" id="mtk_but">-->
<!--                    <p ><span class="glyphicon glyphicon-remove" data-toggle="modal" data-target=".bs-example-modal-sm"></span></p>-->
<!--                    <div><a href="/league/search-history-add?mid=6&c=3"><span>选择历史课程并新增</span></a></div>-->
<!--                    <div><a class="tkxz" href="/league/add?mid=6&c=3"><span class="btn-success">新增新的课程</span></a></div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </main>
    </div>
</div>


