<div class="col-sm-12 removeChildDiv " style="margin-top: 10px;">
    <div class="col-sm-5 ">
        <ul class="col-sm-12 heightCenter">
            <li class="col-sm-6 text-right">折扣</li>
            <li class="col-sm-6"><input  type="number"  inputnum name="addNewDiscount" min="0" value="" placeholder="0折" class="fl form-control"></li>
        </ul>
    </div>
    <div class="col-sm-6 pd0">
        <ul class="col-sm-12 pd0 heightCenter">
            <li class="col-sm-4 pd0  text-left">折扣售卖数</li>
            <li class="col-sm-6 pd0" style="margin-left: -16px;">
                <div class="col-sm-12 pd0  cp h32 inputUnlimited" style="border: solid 1px #cfdadd;border-radius: 3px;display: inline-block;">
                    <input
                        onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"
                        style="border: none;margin-left: 0;" type="number"  name="addNewDiscountNum" inputnum  value="" placeholder="0张" class="fl form-control">
                    <div class="checkbox i-checks checkbox-inline" style="width:58px;position: absolute;margin-right: 0px;">
                        <label style="padding-left: 0px;">
                            <input type="checkbox" value="" name="discountNumLimit"> <i></i> 不限</label>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="col-sm-1 pd0 mT10">
        <button  style="margin-left: 15px;" type="button" class="btn btn-sm btn-default  removeHtml" ng-click="removeVenueId(venueId<?=$num;?>,'discount')" data-remove="removeChildDiv">删除</button>
    </div>
</div>