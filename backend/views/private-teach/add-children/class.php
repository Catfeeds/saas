<div class="row removeDiv">
    <div class="col-sm-4 clearfix">
        <span class="fl mT5"  ><strong class=" red">*</strong>选择课种&emsp;&emsp;</span>
        <select ng-if="classStatus == true" ng-change="selectClass(classKey<?=$num;?>)" ng-model="$parent.classKey<?=$num;?>" class="form-control cp fl" style="padding: 4px 12px;" >
            <option value="">请选择课种</option>
            <option
                value="{{venue.id}}"
                ng-repeat="venue in optionClass"
                ng-disabled="venue.id | attrVenue:classHttp">{{venue.name}}</option>
        </select>
        
        <select ng-if="classStatus == false" class="form-control" style="margin-left: 20px;padding-top: 4px; width: 180px;">
            <option value="">请选择课程</option>
            <option value="" disabled style="color:red;">{{optionClass}}</option>
        </select>
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5"><strong class="red">*</strong>课程时长&emsp;&emsp;</span>
        <input type="number" inputnum min="0" name="classTime" placeholder="0分钟" class="form-control cp fl">
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5"><strong class="red">*</strong>课程节数&emsp;&emsp;</span>
        <input type="number" inputnum min="0" ng-model="totalNums<?=$num;?>" ng-change="getPriceNum(prices<?=$num;?>,totalNums<?=$num;?>)" name="classNum" placeholder="0节" class="form-control cp fl">
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5"><strong class="red">*</strong>单节原价&emsp;&emsp;</span>
        <input type="number" ng-model="prices<?=$num;?>" ng-change="getPriceNum(prices<?=$num;?>,totalNums<?=$num;?>)" name="unitPrice" placeholder="0元" class="form-control cp fl">
    </div>
    <div class="col-sm-4 clearfix">
        <span class="fl mT5">移动端单节原价&emsp;&emsp;</span>
        <input type="number" ng-model="appPrice<?=$num;?>" ng-change="appPriceNum(appPrice<?=$num;?>,totalNums<?=$num;?>)" name="appUnitPrice" placeholder="0元" class="form-control cp fl" style="margin-left: -23px">
    </div>
    <div class="col-sm-4 ">
<!--        <span class="glyphicon glyphicon-yen"><strong style="font-size: 16px;" ng-bind="prices--><?//=$num;?><!-- * totalNums--><?//=$num;?><!-- | totalNum">0</strong>元/金额</span>-->
        <button type="button" ng-click="removeVenueId(venueId<?=$num;?>,'class',prices<?=$num;?>,totalNums<?=$num;?>,appPrice<?=$num;?>)" class="btn btn-white removeHtml" data-remove="removeDiv" style="position: absolute;top: -2px;margin-left: 250px;">删除</button>
    </div>
</div>