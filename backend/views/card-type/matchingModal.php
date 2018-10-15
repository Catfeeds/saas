<!--
/**
 * 公共管理 - 属性匹配 - 会员卡属性匹配
 * @author zhujunzhe@itsports.club
 * @create 2018/1/31 am
 */
 -->
<!--属性匹配模态框-->
<div class="modal fade" id="matchingModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog matchingModal" role="document">
    <div class="modal-content clearfix">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title text-center">属性匹配</h3>
      </div>
      <div class="modal-body">
          <div class="row">
<!--               <div class="col-md-12">-->
<!--                   <label class="choseCard" for="cardSelect">选择卡种</label>-->
<!--                   <select name="" id="cardSelect" style="width: 50%">-->
<!--                       <option value="">请选择卡种</option>-->
<!--                   </select>-->
<!--               </div>-->
              <div class="col-md-12">
                  <select name="" class="form-control" ng-model="chooseVenue" ng-change="chooseVenueChange()" style="padding-top: 4px;margin: 15px 0;">
                      <option value="">请选择场馆</option>
                      <option ng-repeat="venues in optionVenue" value="{{venues.id}}">{{venues.name}}</option>
                  </select>
              </div>
              <div class="col-md-12">
                      <select class="form-control"
                              id="selectedCards"
                              ng-change="cardCateGoryArray(card)"
                              ng-model="card"
                              ng-click="isChooseVenue()"
                              style="padding-top: 4px;margin: 15px 0;">
                          <option value="">请选择卡种</option>
                          <option  value="{{card.id}}"
                                   class="optionsCards"
                                   ng-repeat="card in getVenueCardItems">{{card.card_name}}</option>
                      </select>
              </div>
              <div class="col-md-12 waring-tit">
                  <span class="glyphicon glyphicon-warning-sign" style="color: orange"></span>
                  <span>只能搜索在售卖期内卡种</span>
              </div>
              <div class="chooseCardType">
                  <div class="col-md-6">
                      <label class="checkbox-inline">
                          <input type="checkbox" ng-model="matchCardType1">卡的属性
                      </label>
                  </div>
                  <div class="col-md-6">
                      <label class="checkbox-inline">
                          <input type="checkbox" ng-model="matchCardType2">卡的类型
                      </label>
                  </div>
                  <div class="col-md-6">
                      <label class="checkbox-inline">
                          <input type="checkbox" ng-model="matchWithPeople">是否带人
                      </label>
                  </div>
                  <div class="col-md-6">
                      <label class="checkbox-inline">
                          <input type="checkbox" ng-model="matchVenueLimit">通用场馆限制
                      </label>
                  </div>
                  <div class="col-md-6">
                      <label class="checkbox-inline">
                          <input type="checkbox" ng-model="matchTimeLimit">进馆时间限制
                      </label>
                  </div>
                  <div class="col-md-6">
                      <label class="checkbox-inline">
                          <input type="checkbox" ng-model="matchGroupClass">团课套餐
                      </label>
                  </div>
                  <div class="col-md-6">
                      <label class="checkbox-inline">
                          <input type="checkbox" ng-model="matchLeave">请假
                      </label>
                  </div>
                  <div class="col-md-6">
                      <label class="checkbox-inline">
                          <input type="checkbox" ng-model="matchGift">赠品
                      </label>
                  </div>
                  <div class="col-md-6">
                      <label class="checkbox-inline">
                          <input type="checkbox" ng-model="matchTransfer">转让
                      </label>
                  </div>
<!--                  <div class="col-md-6">-->
<!--                      <label class="checkbox-inline">-->
<!--                          <input type="checkbox" ng-model="matchContract">合同-->
<!--                      </label>-->
<!--                  </div>-->
                  <div class="col-md-6">
                      <label class="checkbox-inline">
                          <input type="checkbox" ng-model="matchValidityRenew">有效期续费
                      </label>
                  </div>
              </div>
              <div class="col-md-12" style="margin-top: 20px;">
                  <div class="col-md-2 pd0">备注</div>
                  <div class="col-md-10 pd0">
                      <textarea class="form-control" rows="3" style="resize: none;" ng-model="note"></textarea>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="width: 100px">关闭</button>
        <button type="button" class="btn btn-success" ng-click="successBtn()" ladda="checkButton" style="width: 100px">完成</button>
      </div>
    </div>
  </div>
</div>