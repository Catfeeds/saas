<div class="inputBox1 removeDiv">
    <div  class="venueSaleBox">
        <div class="inputBox1 col-sm-12 pd0"  style="margin-top: 20px;">
            <div class="form-group col-sm-4 pd0">
                <label for="exampleInputName2" class="oneChoicePrice col-sm-3 pd0"><span class="red">*</span>选择场馆</label>
                <div class="col-sm-8 pd0">
                    <select ng-if="venueStatus == true" ng-change="selectVenue(venueId<?=$num;?>)" ng-model="$parent.venueId<?=$num;?>" class="form-control" style="padding-top: 4px; width: 180px;">
                        <option value="">请选择售卖场馆</option>
                        <option value="{{venue.id}}"  ng-repeat="venue in optionVenue"  ng-disabled="venue.id | attrVenue:venueHttp">{{venue.name}}</option>
                    </select>
                    <select ng-if="venueStatus == false" class="form-control oneStepSell">
                        <option value="">请选择售卖场馆</option>
                        <option value="" disabled class="red">{{optionVenue}}</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-sm-4 pd0">
                <label for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;display: inline-block" class="col-sm-3 pd0"><span style="color: red;">*</span>售卖张数</label>
                <div class="col-sm-7 pd0 clearfix cp h32 inputUnlimited" style="border: solid 1px #cfdadd;border-radius: 3px;display: inline-block;">
                    <input style="width: 130px!important;border: none;margin-left: 0;" type="number" inputnum name="sheetsNum" min="0" value="" placeholder="0张" class="fl form-control">
                    <div class="checkbox i-checks checkbox-inline" style="top: 4px;width:58px;position: absolute;right: 4px;">
                        <label>
                            <input type="checkbox" value="" name="limit"> <i></i> 不限</label>
                    </div>
                </div>
            </div>
            <div class="form-group col-sm-4 pd0">
                <label for="exampleInputName3" class="oneStepPrice col-sm-3 pd0"><span class="red">*</span>售卖日期</label>
                <div class="input-daterange col-sm-8 pd0 input-group cp" id="container" style="display: inline-block;">
                    <div class="col-sm-6 pd0">
                        <input type="text"  id="datetimeStart" class="input-sm form-control datetimeStart oneStepTimeStar oneStepStar" name="sellStartTime" style="text-align:left;font-size: 13px;cursor: pointer;width: 100%!important;" placeholder="起始日期">

                    </div>
                    <div class="col-sm-6 pd0">
                        <input type="text" id="datetimeEnd" class="input-sm form-control datetimeEnd oneStepTime col-sm-6" name="sellEndTime" placeholder="结束日期" style="text-align: left;font-size: 13px;cursor: pointer;width: 100%!important;">
                    </div>
                </div>
            </div>
            <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'venue')" class="btn btn-white btn-sm removeHtml venueSaleDelete" data-remove="removeDiv">删除</button>
            <div class="col-sm-12 pd0 discountLists">
                <div class="col-sm-12 pd0  discountBox" style="width: 100%;">
                    <div class="form-group col-sm-4 pd0 mT10" >
                        <label for="exampleInputName3" class="numCardLabel col-sm-3 pd0" ><span style="opacity: 0;">*</span>折扣</label>
                        <div class="col-sm-8 pd0">
                            <input type="number" autocomplete="off" inputnum name="discount" min="0" placeholder="几折" value=""   class="form-control numCardInput" >
                        </div>
                    </div>
                    <div class="form-group col-sm-4 pd0 mT10">
                        <label for="exampleInputName3" style="font-size: 13px;font-weight: normal;color: #333;display: inline-block" class="col-sm-3 pd0">折扣售卖数</label>
                        <div class="col-sm-7 pd0 clearfix cp h32 inputUnlimited" style="border: solid 1px #cfdadd;border-radius: 3px;display: inline-block;">
                            <input style="width: 130px!important;border: none;margin-left: 0;" type="number" inputnum name="discountNum" min="0" value="" placeholder="0张" class="fl form-control">
                            <div class="checkbox i-checks checkbox-inline" style="top: 4px;width:58px;position: absolute;right: 4px;">
                                <label>
                                    <input type="checkbox" value="" name="discountNumLimit"> <i></i> 不限</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div  class="col-sm-12 pd0 discountBtnBox" style="margin-top: 10px;margin-left: 96px;">
                <div id="addDiscount123" class="cardAddBtn btn btn-default " ng-click="addDiscountHtml()" venuehtml="" >&nbsp;&nbsp;添加折扣&nbsp;&nbsp;</div>
            </div>
        </div>
    </div>

</div>