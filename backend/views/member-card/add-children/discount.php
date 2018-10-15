<div class=" clearfix discountBox  removeChildDiv" style="width: 100%;">
    <div class="fl  w32">
        <span class=""><strong class="red" style="opacity: 0;">*</strong>折扣&emsp;&emsp;&emsp;&emsp;</span>
        <div class=" cp h32" style="margin-left: 15px;">
            <input type="number" inputnum name="discount" min="0" value="" placeholder="几折" class="mp0 fl form-control pT0 ">
        </div>
    </div>
    <div class="fl  w32">
        <span class="">折扣售卖数</span>
        <div class=" cp h32 inputUnlimited unDivBorder" >
            <input
                onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"
                type="number" inputnum name="discountNum"  value="" placeholder="0张" class="mp0 fl form-control pT0 unDivBorderInput">
            <div class="checkbox i-checks checkbox-inline t4" >
                <label>
                    <input type="checkbox" value="" name="discountNumLimit"> <i></i> 不限</label>
            </div>
        </div>
    </div>
    <div class="fl w32">
        <button  style="margin-left: 15px;" type="button" class="btn btn-sm btn-default  removeHtml" ng-click="removeVenueId(venueId<?=$num;?>,'discount')" data-remove="removeChildDiv">删除</button>
    </div>
</div>