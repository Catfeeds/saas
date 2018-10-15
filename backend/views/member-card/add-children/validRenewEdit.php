<!--
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2017/10/30
 * Time: 15:56
 content:卡种有效期修改动态添加模板
 */-->
<div class="col-sm-12 mT20 validityRenewBox removeDiv">
    <div class="col-sm-3  text-right ">
        <span >有效期续费</span>
    </div>
    <div class="col-sm-9 heightCenter ">
        <input  name="cardValidityNum"  inputnum type="number" min="0" placeholder="0" class="form-control cp w120" >
        <select  class="form-control cp cardValidityCompany w70 mL10 selectPd"  >
            <option value="d" ng-selected="unit" >天</option>
            <option value="m">月</option>
            <option value="q">季</option>
            <option value="y">年</option>
        </select>
        <input style="" name="cardValidityMoney"  inputnum type="number" min="0" placeholder="0元" class="form-control cp w120 mL10 " >
        <button  style="margin-left: 15px;" type="button" class="btn btn-sm btn-default  removeHtml" ng-click="removeVenueId(venueId<?=$num;?>,'addValid')" data-remove="removeDiv">删除</button>
    </div>
</div>