
<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: DELL-->
<!-- * Date: 2017/12/28-->
<!-- * Time: 12:45-->
<!-- */-->
<div class="col-sm-12 col-xs-12 mT20 pdLr0 ptServeSellVenue removeDiv" >
    <div class="col-sm-5 col-xs-5 ">
        <div class="col-sm-4 col-xs-5 pd0"><span class="red">*</span>售卖场馆:</div>
        <div class="col-sm-8 col-xs-7 pd0" >
            <select name="sellVenue"  class="form-control selectPadding"  ng-click="selectSellVenue123()" >
                <option value="">请选择</option>
                <option title="{{sellVenue.name}}" ng-disabled="sellVenue.id | attrVenue:sellVenueArr123" value="{{sellVenue.id}}" ng-repeat="sellVenue in optionVenue">{{sellVenue.name |cut:true:8:'...'}}</option>
            </select>
        </div>
    </div>
    <div class="col-sm-5 col-xs-5 ">
        <div class="col-sm-5 col-xs-5 pd0"><span class="red">*</span>单馆售卖数量:</div>
        <div class="col-sm-7 col-xs-7 pd0">
            <input type="number" min="1" name="num" placeholder="0" class="form-control">
        </div>
    </div>
    <div  class="col-sm-2 col-xs-2 ">
            <button class="btn btn-default btn-sm removeHtml" data-remove="removeDiv">删除</button>
    </div>
</div>
