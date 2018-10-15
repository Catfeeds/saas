<div class="clearfix removeDiv sellVenueLists123" >
    <div class="fl  w32" style="position: relative;">
        <span class=""><strong class=" red">*</strong>选择场馆&emsp;&emsp;</span>
        <select ng-change="selectVenue(venueId<?=$num;?>)" ng-model="venueId<?=$num;?>" class="form-control cp">
            <option value="" >请选择场馆</option>
            <option
                value="{{venue.id}}"
                ng-repeat="venue in optionVenue"
                ng-disabled="venue.id | attrVenue:venueHttp"
            >{{venue.name}}</option>
        </select>
    </div>
<!--    <div class="fl  w32">-->
<!--        <span class=""><strong class=" red">*</strong>售卖张数&emsp;&emsp;</span>-->
<!--        <input type="number" inputnum min="0" placeholder="0张" name="sheets" class="form-control">-->
<!--    </div>-->
    <div class="fl  w32" style="position: relative;">
        <span class=""><strong style="color: red;">*</strong>售卖张数&emsp;&emsp;</span>
        <div class="clearfix limitNum123 cp h32 inputUnlimited" style="border: solid 1px #cfdadd;margin-left: 15px;border-radius: 3px;">
            <input style="width: 130px;border: none;margin-left: 0;" type="number" inputnum name="sheets" min="0" value="" placeholder="0张" class="fl form-control pT0">
            <div class="checkbox i-checks checkbox-inline" style="margin-top: 4px;">
                <label style="margin: 0">
                    <input type="checkbox" value="" name="limit"> <i></i> 不限</label>
            </div>
        </div>
    </div>
    <div class="fl  w32 input-daterange cp" style="position: relative;">
        <span class=""><strong class=" red">*</strong>售卖日期&emsp;&emsp;</span>
        <b><input type="text"  class="input-sm form-control datetimeStart dateStart123" name="start" placeholder="起始日期"  style="width: 103px;text-align:left;font-size: 13px;cursor: pointer;margin-left: 0;"></b>
        <b><input type="text"  class="input-sm form-control datetimeEnd" name="end" placeholder="结束日期" style="width: 103px;text-align: left;font-size: 13px;cursor: pointer;"></b>
        <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'venue')" class="btn btn-white removeHtml" data-remove="removeDiv" style="position: absolute;top: -2px;right: -20px;">删除</button>
    </div>
    <div style="width: 100%;" class="fl discountLists">
        <div class=" clearfix discountBox" style="width: 100%;">
            <div class="fl  w32">
                <span class=""><strong class="red" style="opacity: 0;">*</strong>折扣&emsp;&emsp;&emsp;&emsp;</span>
                <div class=" cp h32 discountL15" style="margin-left: 15px;">
                    <input type="number"  name="discount" min="0" value="" placeholder="几折" class="mp0 fl form-control pT0 ">
                </div>
            </div>
            <div class="fl  w32">
                <span class=""><strong class="red" style="opacity: 0;">*</strong>折扣价售卖数</span>
                <div class=" cp h32 inputUnlimited unDivBorder" >
                    <input type="number" inputnum name="discountNum" min="0" value="" placeholder="0张" class="mp0 fl form-control pT0 unDivBorderInput">
                    <div class="checkbox i-checks checkbox-inline t4 mT00" >
                        <label>
                            <input type="checkbox" value="" name="discountNumLimit"> <i></i> 不限</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div  class="fl discountBtnBox" style="width: 100%;">
        <div id="addDiscount" class="cardAddBtn btn btn-default" ng-click="addDiscountHtml()" venuehtml="">添加折扣</div>
    </div>
</div>