<div class="modal-body">
    <section class="row pdLr0">
        <div class="col-sm-12 heightCenter borderB pdB10">
            <div class="col-sm-3">
                <div class="detailHeadPortrait">
                    <img class="wB100" ng-if="itemOne.pic == ''" ng-src="/plugins/checkCard/img/11.png" alt="头像">
                    <img class="wB100" ng-if="itemOne.pic != ''" ng-src="{{itemOne.pic}}" alt="头像">
                </div>
            </div>
            <div class="col-sm-8">
                <ul>
                    <li><h3>{{itemOne.eName}}</h3></li>
                    <li style="margin-top: 4px;">
                        <span class="label label-info " ng-if="itemOne.status == 1">待审核</span>
                        <span class="label label-success" ng-if="itemOne.status == 2">已完成</span>
                        <span class="label label-danger" ng-if="itemOne.status == 3">已拒绝</span>
                        <span class="label label-default"  ng-if="itemOne.status == 4">已撤销</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-sm-12 mT20">
            <ul>
                <li>审批类型：{{itemOne.type | noData:''}}</li>
                <li class="mT6">审批编号：{{itemOne.number | noData:''}}</li>
                <li class="mT6">所在场馆：{{itemOne.vName | noData:''}}</li>
                <li class="mT6">所在部门：{{itemOne.cName | noData:''}}</li>
                <li class="mT6">所属职位：{{itemOne.position | noData:''}}</li>
                <li class="mT6">发起时间：{{itemOne.create_at*1000 | date:'yyyy-MM-dd' | noData:''}}</li>
                <li class="mT6" ng-if="itemOne.approvalDetailsM == null || itemOne.approvalDetailsM == ''">抄送人&emsp;：暂无数据</li>
                <li class="mT6" ng-if="itemOne.approvalDetailsM != null && itemOne.approvalDetailsM != ''">抄送人&emsp;：
                    <span ng-repeat="key in itemOne.approvalDetailsM">
                        <span title="{{key.name}}">{{key.name |cut:true:4:'...'}} <span ng-if="$index != itemOne.approvalDetailsM.length-1">,</span></span>
                    </span>
                </li>
            </ul>
        </div>
        <div class="col-sm-12 mT20 pdLr0" style="min-height: 200px;max-height: 300px;overflow-y: scroll;">
            <div id="vertical-timeline" class="vertical-container light-timeline">
                <div class="vertical-timeline-block">
                    <div class="vertical-timeline-icon navy-bg">
<!--                        <i class="fa fa-briefcase"></i>-->
                        <img class="wB100" ng-if="itemOne.pic == ''" ng-src="/plugins/checkCard/img/11.png" alt="头像">
                        <img class="wB100" ng-if="itemOne.pic != ''" ng-src="{{itemOne.pic}}" alt="头像">
                    </div>
                    <div class="vertical-timeline-content">
                        <h2 class="timeAxisNameCss"><span title="{{itemOne.eName}}" >发起人：{{itemOne.eName |cut:true:4:'...'}}</span> <small>{{itemOne.create_at*1000 | date:'yyyy-MM-dd'}}</small></h2>
                    </div>
                </div>
                <div class="vertical-timeline-block" ng-repeat="itemDetail in itemDetails">
                    <div class="vertical-timeline-icon lazur-bg">
                        <img class="wB100" ng-src="/plugins/checkCard/img/11.png" alt="头像" ng-if="itemDetail.pic == ''">
                        <img class="wB100" ng-src="{{itemDetail.pic}}" alt="头像" ng-if="itemDetail.pic != ''">
                    </div>
                    <div class="vertical-timeline-content">
                        <h2 class="timeAxisNameCss">
                            <span title="{{itemDetail.name}}" style="min-width: 110px;">{{itemDetail.name | cut:true:4:'...'}}</span>
                            <small class="label label-info " ng-if="itemDetail.status == 1">待审核</small>
                            <small style="background-color: #00cc00;color: #FFF;" class="label  " ng-if="itemDetail.status == 2">已同意</small>
                            <small class="label label-danger " ng-if="itemDetail.status == 3">已拒绝</small>
                            <small  class="label label-default" ng-if="itemDetail.status == 4">已撤销</small>
                            <small>{{(itemDetail.create_at*1000) |date:'yyyy-MM-dd'}}</small>
                        </h2>
<!--                        <p ng-if="itemDetail.describe != ''&& itemDetail.describe != null"><span>评论</span>:{{itemDetail.describe}}</p>-->
                        <p ng-repeat="data in itemDetail.approvalComment"><span>{{data.name}}</span>：{{data.content}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>