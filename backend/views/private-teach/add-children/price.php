<div class="row removeDiv xxxx">
    <div class="col-sm-4 clearfix">
        <span class="fl mT5">课程节数区间&emsp;&emsp;&emsp;</span>
        <input type="number"  inputnum min="0" name="intervalStart" placeholder="多少节" class="form-control cp f1 intervalStart sectionInput" style="position: relative;left: -24px;width: 75px"  value="{{}}">
        <div style="position: relative;left: 195px;top: -35px">至</div>
        <input type="number" inputnum min="0" ng-blur="numChangeBlur($event,numClass<?=$num;?>)" ng-keyup="numChange($event,numClass<?=$num;?>)" ng-model="numClass<?=$num;?>"  name="intervalEnd" placeholder="多少节" class="form-control cp fl intervalEnd sectionInput2" style="position: relative;left: 221px;width: 75px;top: -58px">
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5"><strong class="red"></strong>优惠单价&emsp;&emsp;</span>
        <input type="number" checknum  name="unitPrice" placeholder="0元" class="form-control cp fl unitPrice">
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5">POS价&emsp;&emsp;</span>
        <input type="number" checknum  name="posPrice" placeholder="0元" class="form-control cp fl">
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5">移动端折扣&emsp;</span>
        <input type="number" inputnum name="appDiscount" ng-model="appDiscount<?=$num;?>" placeholder="请输入折扣" class="form-control cp fl">
        <span class="glyphicon glyphicon-info-sign" style="margin-top: 8px;font-weight: 100;font-size: 12px;color: darkgrey;">折扣价格：{{(appUnitPrice == undefined || appDiscount<?=$num;?> == undefined) ? 0 : appUnitPrice*appDiscount<?=$num;?>/10}}元</span>
        <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'server')" class="btn btn-white removeHtml" data-remove="removeDiv" style="position: absolute;top: -2px;right: 43px;">删除</button>
    </div>
</div>