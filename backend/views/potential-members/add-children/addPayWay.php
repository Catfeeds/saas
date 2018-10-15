<div class="col-sm-12 addSelectElement removeDiv newSelectDom" style="margin: 5px 0;">
    <label class="col-sm-1 pd0 formLabel" style="padding-top: 5px;">
        <span class="red">*</span>付款途径
    </label>
    <div class="col-sm-8 pd0">
        <select class="addPayMethodSelect" ng-change="addPayPriceChange321()" ng-model="addPayPriceSelect<?=$num?>">
            <option value="">请选择</option>
            <option value="1">现金</option>
            <option value="3">微信</option>
            <option value="2">支付宝</option>
            <!--                                        <option value="4" >pos机</option>-->
            <option value="5" >建设分期</option>
            <option value="6" >广发分期</option>
            <option value="7" >招行分期</option>
            <option value="8" >借记卡</option>
            <option value="9" >贷记卡</option>
        </select>
        <input type="text" class="addPayPrice" ng-change="addPayPriceChange(addPayPriceInput<?=$num?>)" ng-model="addPayPriceInput<?=$num?>" style="border-color: #0a0a0a;">
        <button type="button" ng-click="addPayPriceChange123()" class="btn btn-default removeHtml" style="font-size: 12px;" data-remove="removeDiv">删除</button>
    </div>
</div>