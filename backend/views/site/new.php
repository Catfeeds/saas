<?php
use backend\assets\NewIndexAsset;
NewIndexAsset::register($this);

$this->title='主页';
//?>
    <div class="container-fluid pd0">
        <div class="row">
            <div style="margin-top: 10px;" class="col-sm-12">
                <div class="col-sm-4">
                    <div class="row row-sm text-center">
                        <div class="col-xs-6 animated pulse">
                            <div class="panel padder-v item">
                                <div class="h1 text-info font-thin h1 animated rotateIn">521</div>
                                <span class="text-muted text-xs">今日总约课人数</span>

                            </div>
                        </div>
                        <div class="col-xs-6 animated pulse">
                            <div class="panel padder-v item bg-info">
                                <div class="h1 text-fff font-thin h1 animated rotateIn">521</div>
                                <span style="color: #fff;" class="text-muted text-xs">今日新增会员</span>

                            </div>
                        </div>
                        <div class="col-xs-6 animated pulse">
                            <div class="panel padder-v item bg-primary">
                                <div class="h1 text-fff font-thin h1 animated rotateIn">521</div>
                                <span class="text-muted text-xs">销售卡数量</span>

                            </div>
                        </div>
                        <div class="col-xs-6 animated pulse">
                            <div class="panel padder-v item">
                                <div class="font-thin h1 animated rotateIn">1.29</div>
                                <span class="text-muted text-xs">今日收入/万元</span>
                                
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="col-sm-6" style="padding-right:0;">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title" style="border-bottom:none;background:#fff;">
                                <h5>收入数据&nbsp&nbsp&nbsp&nbsp&nbsp<span style="font-size: 12px;font-weight: normal;color: #999;">只显示最近10个月</span></h5>
                            </div>
                            <div class="ibox-content" style="border-top:none;">
                                <div id="yesterday" class="animated pulse" style="height:217px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2" style="padding-left:0;">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content" style="border-top:none;background-color:#e4eaec;">
                                <h5>本月转化会员：8550人</h5>
                                <div class="progress progress-striped active">
                                    <div style="width: 62%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" role="progressbar" class="progress-bar">62%</div>
                                </div>
                                <h5>本月续费会员卡人数：102人</h5>
                                <div class="progress progress-striped active">
                                    <div style="width: 75%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" role="progressbar" class="progress-bar progress-bar-warning">75%</div>
                                </div>
                                <h5>本月新会员购买私教：38人</h5>
                                <div class="progress progress-striped active">
                                    <div style="width: 25%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" role="progressbar" class="progress-bar .progress-bar-danger">25%</div>
                                </div>
                                <h5>本月私教续费人数：40人</h5>
                                <div class="progress progress-striped active">
                                    <div style="width: 75%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="75" role="progressbar" class="progress-bar progress-bar-info">75%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div style="background: #f5f5f5;" class="row">
                <div style="margin-bottom: 2%;" class="col-sm-12">
                    <div style="padding-left: 0;padding-right: 0;" class="col-sm-6">
                        <div class="col-xs-12">
                        <div style="background: #fff;border: 1px solid #dee5e7;border-radius: 4px;" class="col-xs-12">
                            <h4 style="margin-top: 20px;margin-bottom: 10px;">功能快速入口</h4>
                            <div style="margin-top: 20px;" class="col-sm-12">
                                <a href="/main/index?mid=21&c=20">
                                <div class="col-sm-3 iconDiv">
                                    <button class="btn btn-primary dim animated rotateIn"><i class="glyphicon glyphicon-plus"></i></button>
                                <p style="text-align: center;">新增组织架构</p>
                                </div>
                                    </a>
                                <a href="/personnel/index?mid=15&c=16">
                                    <div class="col-sm-3 iconDiv">
                                        <button class="btn btn-primary dim animated rotateIn">
                                            <i class="glyphicon glyphicon-user"></i>
                                        </button>
                                        <p style="text-align: center;">新增员工</p>
                                    </div>
                                 </a>
                                <a href="/member-card/index?mid=14&c=12">
                                <div class="col-sm-3 iconDiv2">
                                    <button class="btn btn-primary dim animated rotateIn">
                                            <i class="glyphicon glyphicon-credit-card"></i>
                                    </button>
                                    <p style="text-align: center;">新增会员卡</p>
                                </div>
                                    </a>
                                <a href="/serve-plan/serve?mid=8&c=9">
                                <div class="col-sm-3 iconDiv">
                                    <button class="btn btn-primary dim animated rotateIn">
                                            <i class="glyphicon glyphicon-align-justify"></i>
                                    </button>
                                    <p style="text-align: center;">新增服务套餐</p>
                                </div>
                                    </a>
                            </div>
                            <div style="margin-top: 20px;" class="col-sm-12">
                                <a href="/class/index?mid=18&c=19">
                                <div class="col-sm-3 iconDiv">
                                    <button class="btn btn-warning dim animated rotateIn">
                                            <i class="glyphicon glyphicon-tags"></i>
                                </button>
                                    <p style="text-align: center;">新增课种</p>
                                </div>
                                    </a>
                                <a href="/league/add?mid=6&c=3">
                                <div class="col-sm-3 iconDiv">
                                    <button class="btn btn-warning dim animated rotateIn">
                                            <i class="glyphicon glyphicon-tag"></i>
                                    </button>
                                    <p style="text-align: center;">新增课程</p>
                                </div>
                                    </a>
                                <a href="/private-teach/index?mid=4&c=2">
                                <div class="col-sm-3 iconDiv">
                                    <button class="btn btn-warning dim animated rotateIn">
                                            <i class="fa fa-user-secret"></i>
                                    </button>
                                    <p style="text-align: center;">新增私教</p>
                                </div>
                                    </a>
                                <a href="/authority/index?mid=17&q=4">
                                <div class="col-sm-3 iconDiv">
                                    <button class="btn btn-warning dim animated rotateIn">
                                            <i class="fa fa-group"></i>
                                    </button>
                                    <p style="text-align: center;">权限管理</p>
                                </div>
                                    </a>
                            </div>
                            <div style="margin-top: 20px;" class="col-sm-12">
                                <a href="/league/reservation?mid=6&c=3">
                                <div class="col-sm-3 iconDiv">
                                    <button class="btn btn-danger dim animated rotateIn">
                                            <i class="glyphicon glyphicon-heart"></i>
                                    </button>
                                    <p style="text-align: center;">团课预约设置</p>
                                </div>
                                    </a>
                                <a href="/league/edit-course?mid=6&c=3">
                                <div class="col-sm-3 iconDiv">
                                    <button class="btn btn-danger dim animated rotateIn">
                                            <i class="glyphicon glyphicon-th-list"></i>                                                                                                                                                                             
                                    </button>
                                    <p style="text-align: center;">修改团课课程</p>
                                </div>
                                    </a>
                                <a href="/league/search-history-add?mid=6&c=3">
                                <div class="col-sm-3 iconDiv">
                                    <button class="btn btn-danger dim animated rotateIn">
                                            <i class="glyphicon glyphicon-book"></i>
                                    </button>
                                    <p style="text-align: center;">历史课程新增</p>
                                </div>
                                    </a>
                                <a href="/member-card/venue-restrictions?mid=14&c=12">
                                <div class="col-sm-3 iconDiv">
                                    <button class="btn btn-danger dim animated rotateIn">
                                            <i class="glyphicon glyphicon-flag"></i>
                                    </button>
                                    <p style="text-align: center;">场馆限制</p>
                                </div>
                                    </a>
                            </div>
                            <div style="margin-top: 20px;margin-bottom: 20px;" class="col-sm-12">
                                <a href="/cabinet/index?mid=9&c=8">
                                <div class="col-sm-3 iconDiv">
                                    <button class="btn btn-info  dim btn-outline animated rotateIn"><i class="fa fa-archive skipBtn"></i></button>
                                    <p style="text-align: center;">柜子模块</p>
                                </div>
                                    </a>
                                <a href="/serve-plan/serve?mid=8&c=9">
                                <div class="col-sm-3 iconDiv">
                                    <button class="btn btn-info  dim btn-outline animated rotateIn"><i class="glyphicon glyphicon-gift skipBtn2"></i></button>
                                    <p style="text-align: center;">服务管理</p>
                                </div>
                                    </a>
                                <a href="/serve-plan/index?mid=8&c=9">
                                <div class="col-sm-3 iconDiv">
                                    <button class="btn btn-info  dim btn-outline animated rotateIn"><i class="glyphicon glyphicon-list-alt skipBtn3"></i></button>
                                    <p style="text-align: center;">套餐管理</p>
                                </div>
                                    </a>
                                <a href="/evaluate/index?mid=10&c=7">
                                <div class="col-sm-3 iconDiv">
                                    <button class="btn btn-info  dim btn-outline animated rotateIn"><i class="glyphicon glyphicon-thumbs-up skipBtn4"></i></button>
                                    <p style="text-align: center;">评价管理</p>
                                </div>
                                    </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div style="padding-left: 0;" class="col-xs-12">
                        <div class="ibox float-e-margins">
                            <div class="" id="ibox-content">

                                <div id="vertical-timeline" class="vertical-container light-timeline">
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon navy-bg animated pulse">
                                            <i class="fa fa-briefcase"></i>
                                        </div>

                                        <div class="vertical-timeline-content">
                                            <h2>公司早会</h2>
                                            <p>统计并分析这周所有场馆情况。
                                            </p>
                                        <span class="vertical-date">
                                    今天 <br>
                                    <small>2月3日</small>
                                </span>
                                        </div>
                                    </div>

                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon blue-bg animated pulse">
                                            <i class="fa fa-file-text"></i>
                                        </div>

                                        <div class="vertical-timeline-content">
                                            <h2>《公司年度总结报告》</h2>
                                            <p>给所有员工予以鼓励</p>
                                            <a href="#" class="btn btn-sm btn-success"> 下载文档 </a>
                                        <span class="vertical-date">
                                    昨天 <br>
                                    <small>2月2日</small>
                                </span>
                                        </div>
                                    </div>
                                    <div class="vertical-timeline-block">
                                        <div class="vertical-timeline-icon lazur-bg animated pulse">
                                            <i class="fa fa-user-md"></i>
                                        </div>

                                        <div class="vertical-timeline-content">
                                            <h2>公司年会</h2>
                                            <p>发年终奖啦，啦啦啦~~</p>
                                            <span class="vertical-date">前天 <br><small>2月1日</small></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
             </div>
        </div>
    </div>



