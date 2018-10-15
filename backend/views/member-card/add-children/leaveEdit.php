<!--/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/10/31
 * Time: 16:24
 *content:请假修改
 */-->
<div class="col-sm-12 pdLR0  leaveNumBox removeDiv">
    <div class="col-sm-5  heightCenter mT20">
        <span class="width100 text-right " style="margin-right: 10px;">请假次数</span>
        <input type="number" min="0" ng-disabled="leaveNumsFlag"ng-model="nums<?=$num;?>"  ng-change="seLeaveDaysDisabled()"  checknum name="times" placeholder="0次" class="form-control">
    </div>
    <div class="col-sm-5  heightCenter mT20">
        <span class="width140 text-right" style="margin-right: 10px;">每次最低天数</span>
        <input type="number" min="0" ng-disabled="leaveNumsFlag" ng-model="days<?=$num;?>"  ng-change="seLeaveDaysDisabled()" checknum name="days" placeholder="0天" class="form-control">
    </div>
    <div class="col-sm-2 heightCenter mT20">
        <button   type="button" class="btn btn-sm btn-default  removeHtml"  data-remove="removeDiv">删除</button>
    </div>
</div>
