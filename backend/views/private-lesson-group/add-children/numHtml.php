<!-- 添加节数区间表单框 -->
<div class="row removeDiv clearfix" style="margin-left: 0px">
<div class="row">
    <hr>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5"><strong class=" red">*</strong>课程节数设置&nbsp;</span>
        <input type="text" inputnum name="intervalEnd" placeholder="0" class="form-control cp fl" style="width: 95px;">
    </div>
</div>
<div class="row personLimit" id="">
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
            <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'numHtml')" class="btn btn-white removeHtml" data-remove="removeDiv" style="margin-left: 5px">删除</button>

        </div>
    </div>
</div>
</div>