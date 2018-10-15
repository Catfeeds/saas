<div class="col-sm-12 addUpgradePayChild removeDiv3" style="padding: 0;margin-bottom: 10px;">
    <label class="col-sm-3 pd0 control-label label-words" style="padding-top: 5px;">
        <span class="red">*</span>付款途径
    </label>
    <div class="col-sm-9 pd0">
        <select class="privateUpgradePayWay" ng-model="upgradeMoneyType<?=$num?>" ng-change="upgradeMoneyTypeChange()" style="height: 28px;margin-left: 10px;width: 80px;">
            <option value="">请选择</option>
            <option value="1">现金</option>
            <option value="3">微信</option>
            <option value="2">支付宝</option>
            <option value="5">建设分期</option>
            <option value="6">广发分期</option>
            <option value="7">招行分期</option>
            <option value="8">借记卡</option>
            <option value="9">贷记卡</option>
        </select>
        <input type="number" name="privateUpgradePayNum" class="privateUpgradePayNum" style="width: 87px;height: 28px;" inputnum
               ng-change="upgradeMoneyInputChange()"
               ng-model="upgradeMoneyInput<?=$num?>">
        <button class="btn btn-default pull-right removeHtml" ng-click="upgradeMoneyDelClick()" data-remove="removeDiv3" style="font-size: 12px;">删除</button>
    </div>
</div>