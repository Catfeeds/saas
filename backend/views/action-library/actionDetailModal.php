<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/17 0017
 * Time: 19:33
 */
-->
<!--动作详情-->
<div class="modal fade" tabindex="-1" role="dialog" id="actionDetailModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">详情</h4>
            </div>
            <div class="modal-body">
               <div class="row">
                   <div class="col-md-12 text-right">
                       <button class="btn btn-info" style="width: 100px;" ng-click="updateOneBtn()">修改</button>
                   </div>
                   <div class="col-md-12 mB10">
                       <div class="col-md-3 text-right">
                           动作名称：
                       </div>
                       <span>{{detailTitle}}</span>
                   </div>
                   <div class="col-md-12 mB10">
                       <div class="col-md-3 text-right">
                           类型：
                       </div>
                       <span ng-if="detailType == 0">其他</span>
                       <span ng-if="detailType == 1">有氧训练</span>
                       <span ng-if="detailType == 2">重量训练</span>
                   </div>
                   <div class="col-md-12 mB10">
                       <div class="col-md-3 text-right">
                           单位：
                       </div>
                       <span ng-if="detailUnit == 1">次</span>
                       <span ng-if="detailUnit == 2">秒</span>
                       <span ng-if="detailUnit == 3">分</span>
                   </div>
                   <div class="col-md-12 mB10">
                       <div class="col-md-3 text-right">
                           热量消耗：
                       </div>
                       <span>{{detailEnergy}}Kcal</span>
                   </div>
                   <div class="col-md-12 mB10" ng-repeat="i in detailCategory">
                       <div class="col-md-3 text-right">
                           {{i.p_title}}：
                       </div>
                       <span>{{i.title}}</span>
                   </div>
                   <div class="col-md-12 mB10">
                       <div class="col-md-3 text-right">
                           动作要领：
                       </div>
                       <span>{{detailSsentials | noData:''}}</span>
                   </div>
                   <div class="col-md-12 mB10" >
                       <div class="col-md-3 text-right">
                           动作示范：
                       </div>
                       <div class="col-md-9 pd0">
                           <div class="col-md-12 mB10 pd0" ng-repeat="i in detailImages" ng-if="i.type == 2">
                               <img ng-src="{{i.url}}" class="w100 fl mR10" ng-if="i.url != ''">
                               <p class="fl">{{i.describe | noData:''}}</p>
                           </div>
                           <p ng-if="noDataText2">暂无数据</p>
                           <p ng-if="detailImages.length == 0">暂无数据</p>
                       </div>
                   </div>
                   <div class="col-md-12 mB10" >
                       <div class="col-md-3 text-right">
                           错误示范：
                       </div>
                       <div class="col-md-9 pd0" >
                           <div class="w100 fl mR10" ng-repeat="i in detailImages" ng-if="i.type == 1">
                               <img class="w100" ng-src="/plugins/actionLibrary/img/22.png" ng-if="i.url == '' || i.url == null">
                               <img class="w100" ng-src="{{i.url}}" ng-if="i.url != '' && i.url != null">
                           </div>
                           <p ng-if="noDataText">暂无数据</p>
                           <p ng-if="detailImages.length == 0">暂无数据</p>
                       </div>
                   </div>
                   <div class="col-md-12 mB10" >
                       <div class="col-md-3 text-right">
                           视频：
                       </div>
                       <div class="col-md-9 pd0">
                           <video ng-src="{{videoUrl(detailVideoUrl)}}"  width="320" height="240" controls="controls" ng-if="detailVideoUrl != ''">

                           </video>
                           <p ng-if="detailVideoUrl == '' || detailVideoUrl == null">暂无数据</p>
                       </div>
                   </div>
               </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px;">关闭</button>
            </div>
        </div>
    </div>
</div>