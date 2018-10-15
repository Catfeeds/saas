<div class="col-sm-12 pdLR0 sellVenueBox removeDiv">
    <div class="col-sm-4  heightCenter mT20">
        <span class="width100 text-right"><strong class="red">*</strong>选择场馆</span>
        <select   class="form-control cp selectPd mL10 w240 sellVenueSelect" style="margin-left: 10px;" name="sellVenueSelect"  ng-change="selectVenue(venueId<?=$num;?>)" ng-model="$parent.venueId<?=$num;?>">
            <option value="" >请选择场馆</option>
            <option value="{{venue.id}}"
                    ng-repeat=" venue in optionVenue"
                    ng-disabled="venue.id | attrVenue:venueHttpIdArr"
            >{{venue.name}}</option>
        </select>
    </div>
    <div class="col-sm-4  heightCenter mT20">
        <span class="width100 text-right"><strong class="red">*</strong>售卖张数</span>
        <div class="clearfix cp h32 inputUnlimited unlimitedDivOne mL10 w240" >
            <input  type="number" inputnum name="sheets" min="0" value="" placeholder="0张" class="fl form-control pT0 unlimitedInputOne">
            <div class="checkbox i-checks checkbox-inline t4" >
                <label>
                    <input type="checkbox" value="" name="limit"> <i></i> 不限</label>
            </div>
        </div>
    </div>
    <div class="col-sm-4  heightCenter input-daterange mT20">
        <div class="width100 text-right"><strong class="red">*</strong>售卖日期</div>
        <div class="mL10 heightCenter">
            <b><input type="text" id = 'datetimeStart' class="input-sm form-control datetimeStart dateCss" name="start" placeholder="起始日期"  style="margin-left: 0;width: 110px;" ></b>
            <b><input type="text" id="datetimeEnd" class="input-sm form-control datetimeEnd dateCss" name="end" placeholder="结束日期" style="width: 110px;"></b>
        </div>
    </div>

<!--    <div class="col-sm-12 pdLR0  discountLists">-->
        <div class=" col-sm-12 pdLR0 discountList mT20">
            <div class=" col-sm-12 pdLR0 discountBox">
                <div class="col-sm-4 heightCenter ">
                    <span  class="width100 text-right">折扣</span>
                    <input type="number"  inputnum name="discount" min="0" value="" placeholder="几折" class=" fl form-control pT0 mL10 w240">
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
            </div>
        </div>
        <div  class="col-sm-12 pdLR0 mT20  discountBtnBox heightCenter" >
            <div  class="width100 text-right" ></div>
            <button id="addDiscountEdit" class="cardAddBtn btn btn-default mL10" ng-click="addDiscountEditHtml()" venuehtml="" >添加折扣</button>
            <button  type="button" class="btn  btn-default  removeHtml mL10"  data-remove="removeDiv">删除场馆</button>
        </div>
<!--    </div>-->
</div>