<!-- 添加多人阶梯价格模版 -->
<div class="row removeDiv">
    <hr>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5"><strong class="red">*</strong>人数设置&emsp;&emsp;&nbsp;</span>
        <input type="text" inputnum name="classPersonRight"  placeholder="0" class="form-control cp fl" style="width: 95px;">
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5"><strong class="red">*</strong>优惠单价&emsp;&emsp;&nbsp;</span>
        <input type="text" inputnum name="unitPrice" placeholder="0元" class="form-control cp fl">
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5"><strong class="red">*</strong>POS价&emsp;&emsp;&emsp;&nbsp;</span>
        <input type="text" inputnum min="0" name="posPrice" placeholder="0元" class="form-control cp fl">
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5"><strong class="red">*</strong>最低开课人数&nbsp;</span>
        <input type="text" inputnum name="lowNum" placeholder="0人" class="form-control cp fl">
        <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'limitHtml123')" class="btn btn-white removeHtml" data-remove="removeDiv" style="position: absolute;top: -2px;right: 43px;">删除</button>

    </div>
</div>