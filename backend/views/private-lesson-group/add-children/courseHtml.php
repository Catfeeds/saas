<!-- 添加课程选择模版 -->
<div class="row removeDiv">
    <hr>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5"><strong class=" red">*</strong>选择课种&emsp;&emsp;</span>
        <select ng-if="classStatus == true" class="form-control fl" style="padding: 4px 12px;" >
            <option value="">请选择课种</option>
            <option value="{{venue.id}}"  ng-repeat="venue in optionClass">{{venue.name}}</option>
        </select>
        <select ng-if="classStatus == false" class="form-control fl" style="padding: 4px 12px;">
            <option value="">请选择课种</option>
            <option value="" disabled style="color:red;">{{optionClass}}</option>
        </select>
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5"><strong class="red">*</strong>课程时长&emsp;&emsp;</span>
        <input type="text" inputnum  name="classTime" inputnum min="0" placeholder="0分钟" class="form-control fl">
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5"><strong class="red">*</strong>课程节数&emsp;&emsp;</span>
        <input type="text" inputnum ng-model="classNum<?=$num;?>" ng-change="countOnePrice()"  inputnum name="classNum" min="0" placeholder="0节" class="form-control fl">
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5"><strong class="red">*</strong>单节原价&emsp;&emsp;</span>
        <input type="text" inputnum  ng-model="onePrice<?=$num;?>" ng-change="countOnePrice()"  name="onePrice"  placeholder="0元" class="form-control fl" style="margin-left: 10px">
        <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'courseSelect123')" class="btn btn-white removeHtml" data-remove="removeDiv" style="position: absolute;top: -2px;right: 43px;">删除</button>
    </div>
</div>