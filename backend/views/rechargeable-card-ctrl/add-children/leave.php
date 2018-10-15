<div class="clearfix removeDiv">
    <div class="fl  w32">
        <span class="">请假次数&emsp;&emsp;</span>
        <input type="number" ng-disabled="leaveNumsFlag" ng-model="nums<?=$num;?>"  ng-change="seLeaveDaysDisabled()" inputnum min="0" name="times" placeholder="0次" class="form-control">
    </div>
    <div class="fl  w32" style="position: relative;">
        <span class="">每次请假天数</span>
        <input type="number" ng-disabled="leaveNumsFlag" ng-model="days<?=$num;?>"  ng-change="seLeaveDaysDisabled()" inputnum min="0" name="days" placeholder="0天" class="form-control">
        <button type="button" class="btn btn-white removeHtml" data-remove="removeDiv" style="position: absolute;top: -2px;right: 0px;">删除</button>
    </div>
</div>