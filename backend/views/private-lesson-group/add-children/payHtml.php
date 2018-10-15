<div  class="removeDiv">
<ul style="display: inline-block">
    <li class="col-sm-4">
        <span>*</span>
        <span>付款途径</span>
    </li>
    <li class="col-sm-8">
        <select class="col-sm-5 pd0 form-control" ng-change="waysRepeat(payMethod<?=$num?>)" ng-model="payMethod<?=$num?>" style="padding: 4px 5px;width: 48%;">
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
        <input type="text" inputnum class="col-sm-7 form-control" id="changePrice" ng-change="getTotalPrice(price<?=$num ?>)"  ng-model="price<?=$num?>" style="width: 48%;margin-left: 4%;">
        <button type="button" class="btn btn-default removeHtml" style="font-size: 12px;margin-top: 5px;" data-remove="removeDiv">删除</button>
    </li>
</ul>
</div>