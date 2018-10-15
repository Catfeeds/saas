<div class="col-sm-12 pd0 removeChildDiv  discountBox" style="width: 100%;">
    <div class="form-group col-sm-4 pd0 mT10" >
        <label for="exampleInputName3" class="numCardLabel col-sm-3 pd0" ><span style="opacity: 0;">*</span>折扣</label>
        <div class="col-sm-8 pd0">
            <input type="number" autocomplete="off"  name="discount" min="0" placeholder="几折" value=""   class="form-control numCardInput" >
        </div>
    </div>
    <div class="form-group col-sm-4 pd0 mT10">
        <label for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;display: inline-block" class="col-sm-3 pd0"><span style="opacity: 0;">*</span>折扣售卖数</label>
        <div class="col-sm-7 pd0 clearfix cp h32 inputUnlimited" style="border: solid 1px #cfdadd;border-radius: 3px;display: inline-block;">
            <input
                onkeyup="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}" onafterpaste="if(this.value.length==1){this.value=this.value.replace(/[^1-9]/g,'')}else{this.value=this.value.replace(/\D/g,'')}"
                style="width: 130px!important;border: none;margin-left: 0;" type="number"  name="discountNum" inputnum  value="" placeholder="0张" class="fl form-control">
            <div class="checkbox i-checks checkbox-inline" style="top: 4px;width:58px;position: absolute;right: 4px;">
                <label>
                    <input type="checkbox" value="" name="discountNumLimit"> <i></i> 不限</label>
            </div>
        </div>
    </div>
    <div class="form-group col-sm-4 pd0 mT10">
        <button  style="margin-left: 15px;" type="button" class="btn btn-sm btn-default  removeHtml" ng-click="removeVenueId(venueId<?=$num;?>,'discount')" data-remove="removeChildDiv">删除</button>
    </div>
</div>