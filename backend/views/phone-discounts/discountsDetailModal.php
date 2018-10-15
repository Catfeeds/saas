<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/24 0024
 * Time: 9:29
 */
 -->
<!-- 折扣详情模态框 -->
<div class="modal fade" id="discountsDetailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">移动端折扣详情</h4>
            </div>
            <div class="modal-body">
                <h2>{{detailVenueName}}</h2>
                <p>折扣：{{detailDiscount}}折</p>
                <p>折扣售卖期限：{{detailStartDate * 1000 | date:'yyyy-MM-dd'}} 到 {{detailEndDate * 1000 | date:'yyyy-MM-dd'}}</span></p>
                <p>
                    不打折卡种：
                    <span ng-repeat="i in detailNoDiscountList">{{i}},</span>
                </p>
            </div>
        </div>
    </div>
</div>