<div class="col-sm-12 pd0 setRoleContent removeDiv" style="border-bottom: solid 1px #F5F5F5;padding-bottom: 10px;">
    <div class="col-sm-12  heightCenter mT20">
        <div class="col-sm-3 pd0"><span class="red">*</span>使用角色</div>
        <div class="col-sm-9 pd0">
            <select class="form-control selectCss selectRole123 " multiple="multiple">
<!--                <option value="">请选择角色</option>-->
                <option title="{{role.name}}" value="{{role.id}}" ng-repeat="role in setRoleLists123">{{role.name| cut:true:8:'...'}}</option>
            </select>
        </div>
    </div>
    <div class="col-sm-12  heightCenter mT40"  ng-if="selectGiveType == 1">
        <div class="col-sm-3 pd0"><span class="red">*</span>会员卡选择</div>
        <div class="col-sm-9 pd0 cardBox" style="display: flex">
            <select id="allMemberCard" class="form-control  selectCss selectMemberCard123" multiple="multiple"  style="overflow-x: scroll;">
                <option  title="{{card.card_name}}" value="{{card.id}}" ng-repeat="card in cardItems">{{card.card_name | cut:true:12:'...'}}</option>
            </select>
            <div class="checkbox i-checks checkbox-inline " style="width: 120px;padding-right: 0;">
                <label>
                    <input name="allCard" type="checkbox" value="-1"> <i></i> 全选</label>
            </div>
        </div>
    </div>
    <div class="col-sm-6 heightCenter mT30">
        <div class="col-sm-6 pd0"><span class="red">*</span>赠送天数</div>
        <div class="col-sm-6 pd0">
            <input type="text" inputnum name="giveDays" class="form-control" placeholder="0天">
        </div>
    </div>
    <div class="col-sm-6 heightCenter mT30">
        <div class="col-sm-6 pd0">每月赠送量</div>
        <div class="col-sm-6 pd0">
            <input type="text" inputnum name="giveNum" class="form-control" placeholder="0张">
        </div>
    </div>
    <div class="col-sm-12">
        <button  style="margin-left: 6px;" type="button" class="btn btn-sm btn-default  removeHtml" ng-click="removeVenueId(venueId<?=$num;?>,'role')" data-remove="removeDiv">&emsp;删除&emsp;</button>
    </div>
</div>