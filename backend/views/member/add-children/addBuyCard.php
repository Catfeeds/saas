<div class="col-sm-12 addBuyCardElement removeDiv newSelectDom2" style="padding: 10px 0;">
    <label class="col-sm-4 control-label label-words" style="padding-top: 5px;">
        <span class="red">*</span>付款途径
    </label>
    <div class="col-sm-8">
        <select class="buyCardMethodSelect" ng-change="buyCardInputChange321()" ng-model="buyCardSelect<?=$num?>">
            <option value="">请选择</option>
            <option  value="1">现金</option>
            <option value="3">微信</option>
            <option value="2">支付宝</option>
            <!--                                        <option value="4" >pos机</option> -->
            <option value="5" >建设分期</option>
            <option value="6" >广发分期</option>
            <option value="7" >招行分期</option>
            <option value="8" >借记卡</option>
            <option value="9" >贷记卡</option>
        </select>
        <input type="text" class="buyCardPrice" ng-change="buyCardInputChange(buyCardInput<?=$num?>)" ng-model="buyCardInput<?=$num?>" style="border-color: #0a0a0a;">
        <button type="button" ng-click="buyCardInputChange123()" class="btn btn-default removeHtml" style="font-size: 12px;margin-top: -4px;" data-remove="removeDiv">删除</button>
    </div>
</div>