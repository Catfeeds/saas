<!--添加人数区间模版-->

<div class="row personLimit removeDiv">
    <hr>
    <div class="clearfix">
        <div class="col-sm-4 clearfix">
            <span class="fl mT5"><strong class=" red">*</strong>人数设置&emsp;&emsp;&nbsp;</span>
            <input type="text" inputnum name="classPersonRight" placeholder="0" class="form-control cp fl" style="width: 95px;">
        </div>
        <div class="col-sm-4 clearfix">
            <span class="fl mT5"><strong class=" red">*</strong>优惠单价&emsp;&emsp;&nbsp;</span>
            <input type="text" inputnum name="unitPrice" placeholder="0元" class="form-control cp fl">
        </div>
        <div class="col-sm-4 clearfix">
            <span class="fl mT5"><strong class=" red">*</strong>POS价&emsp;&emsp;&emsp;&nbsp;</span>
            <input type="text" inputnum name="posPrice" placeholder="0元" class="form-control cp fl">
        </div>
        <div class="col-sm-4 clearfix">
            <span class="fl mT5"><strong class=" red">*</strong>最低开课人数&nbsp;</span>
            <input type="text" inputnum name="lowNum" placeholder="0人" class="form-control cp fl">
            <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'personHtml123')" class="btn btn-white removeHtml" data-remove="removeDiv" style="margin-left: 5px">删除</button>

        </div>
    </div>
</div>