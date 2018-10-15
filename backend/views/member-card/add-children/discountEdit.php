<div class=" col-sm-12 pdLR0 discountBox mT20 removeDiv">
    <div class="col-sm-4 heightCenter ">
        <span  class="width100 text-right">折扣</span>
        <input type="number" inputnum name="discount"  min="0" value="" placeholder="几折" class="fl form-control pT0 mL10 w240">
    </div>
    <div class="col-sm-4 heightCenter ">
        <div  class="width100 text-right">折扣价售卖数</div>
        <div class=" cp h32 inputUnlimited unDivBorder mL10 w240" >
            <input type="number" inputnum name="discountNum" min="1" value="" placeholder="0张" class="mp0 fl form-control pT0 unDivBorderInput">
            <div class="checkbox i-checks checkbox-inline t4" >
                <label>
                    <input type="checkbox" value="" name="discountNumLimit"> <i></i> 不限</label>
            </div>
        </div>
    </div>
    <div class="col-sm-4  heightCenter ">
        <button  style="margin-left: 15px;" type="button" class="btn btn-sm btn-default  removeHtml" ng-click="removeVenueId(venueId<?=$num;?>,'addValid')" data-remove="removeDiv">删除</button>
    </div>
</div>