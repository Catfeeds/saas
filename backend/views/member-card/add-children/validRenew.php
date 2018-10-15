<div style="width: 100%;" class="cardValidityBox removeDiv">
    <div style="width: 100%; display: flex;margin-top: 15px;">
        <span class="validW80" style="width: 95px;margin-top: 5px;">有效期续费&emsp;</span>
        <input  style="width: 115px;" name="cardValidityNum"  inputnum type="number" min="0" placeholder="0" class="form-control cp " >
        <select  class="form-control cp cardValidityCompany" style="width: 70px;margin-left: 15px;"   >
            <option value="d" ng-selected="unit" >天</option>
            <option value="m">月</option>
            <option value="q">季</option>
            <option value="y">年</option>
        </select>
        <input style="width: 115px;margin-left: 15px;" name="cardValidityMoney"  inputnum type="number" min="0" placeholder="0元" class="form-control cp " >
        <button  style="margin-left: 15px;" type="button" class="btn btn-sm btn-default  removeHtml" ng-click="removeVenueId(venueId<?=$num;?>,'addValid')" data-remove="removeDiv">删除</button>
    </div>
    <div style="width: 100%; display: flex;margin-top: 10px;">
        <div class="mL80" style="margin-left: 95px;color: #999;"><i class="glyphicon glyphicon-info-sign"></i>此卡到期时增加此卡有效期的续费</div>
    </div>
</div>