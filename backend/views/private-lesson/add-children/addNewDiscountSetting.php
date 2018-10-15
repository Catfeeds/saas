<div class="setDiscountSmallBox removeDiv">
    <div class="col-sm-12 mt20">
        <div class="col-sm-4 text-right">
            <span class="red">*</span>设置折扣：
        </div>
        <div class="col-sm-8">
            <input type="text" class="form-control" style="border: 1px solid #aaa;border-radius: 4px;height: 32px;">
            <span class="glyphicon glyphicon-info-sign" style="line-height: 30px;">多个折扣用"/"分开,例如: 8.5/7.0</span>
        </div>
    </div>
    <div class="col-sm-12 mt20" style="margin-bottom: 30px;">
        <div class="col-sm-4 text-right">
            <span class="red">*</span>使用角色：
        </div>
        <div class="col-sm-8">
            <select class="chooseRoleSelect" multiple>
                <option ng-repeat="roles in roleListChoose" value="{{roles.id}}">{{roles.name}}</option>
            </select>
            <button class="btn btn-default mt20 removeHtml" data-remove="removeDiv" ng-click="removeDiscountHtml()">删除</button>
        </div>
    </div>
</div>