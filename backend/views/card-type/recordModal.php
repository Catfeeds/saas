<!--
/**
 * 公共管理 - 属性匹配 - 会员卡属性匹配
 * @author zhujunzhe@itsports.club
 * @create 2018/1/31 am
 */
 -->
<!--匹配记录模态框-->
<div class="modal fade" id="recordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog modal-lg recordModalMain" role="document">
       <div class="modal-content clearfix">
           <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h3 class="modal-title text-center">匹配记录</h3>
           </div>
           <div class="modal-body">
               <table class="table table-striped table-bordered">
                   <thead>
                       <tr>
                           <th>操作人</th>
                           <th>操作时间</th>
                           <th>老卡名称</th>
                           <th>新卡名称</th>
                           <th>匹配属性</th>
                           <th>备注</th>
                       </tr>
                   </thead>
                   <tbody>
                       <tr ng-repeat="record in recordList">
                           <td>{{record.name | noData:''}}</td>
                           <td>{{record.create_at*1000 | date:'yyyy-MM-dd'}}</td>
                           <td>{{record.memberCardName | noData:''}}</td>
                           <td>{{record.card_name | noData:''}}</td>
                           <td class="slashAdd">
                               <span ng-repeat="mateType in  record.attribute_matching | jsonParse">
                                   <span ng-if="mateType === null || mateType === undefined || mateType === ''">暂无数据</span>
                                   <span ng-if="mateType == 1 || mateType == '1'">卡的属性</span>
                                   <span ng-if="mateType == 2 || mateType == '2'">卡的类型</span>
                                   <span ng-if="mateType == 3 || mateType == '3'">是否带人</span>
                                   <span ng-if="mateType == 4 || mateType == '4'">通用场馆限制</span>
                                   <span ng-if="mateType == 5 || mateType == '5'">进馆时间限制</span>
                                   <span ng-if="mateType == 6 || mateType == '6'">团课套餐</span>
                                   <span ng-if="mateType == 7 || mateType == '7'">请假</span>
                                   <span ng-if="mateType == 8 || mateType == '8'">赠品</span>
                                   <span ng-if="mateType == 9 || mateType == '9'">转让</span>
                                   <span ng-if="mateType == 10 || mateType == '10'">合同</span>
                                   <span ng-if="mateType == 11 || mateType == '11'">有效期续费</span>
                               </span>
                           </td>
                           <td>{{record.note | noData:''}}</td>
                       </tr>
                   </tbody>
               </table>
               <?= $this->render('@app/views/common/pagination.php', ['page' => 'replaceMatchingPage']); ?>
               <?= $this->render('@app/views/common/nodata.php', ['name' => 'mateRecordNoData']); ?>
           </div>
       </div>
   </div>
</div>