<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22 0022
 * Time: 09:24
 */
-->
<!--添加训练内容模板-->
<div class="row mr0 removeDrill oneDrill">
    <div class="col-md-12 mB10 mT10">
        <div class="fl lH30 w60 text-right"><span class="red lH30">*</span>动作</div>
        <div class="fl mL15">
            <select class="form-control selectStyle chooseSelect w178">
                <option value="">请选择动作</option>
                <option value="{{i.id}}" ng-repeat="i in actionListData">{{i.title}}</option>
            </select>
        </div>
    </div>
    <div class="col-md-12 mB10">
        <div class="fl lH30 w60 text-right">数量</div>
        <div class="fl mL15">
            <input type="number" inputnum min="1" class="form-control setNum" placeholder="组数或分钟">
        </div>
    </div>
    <div class="col-md-12 mB10">
        <div class="fl w60" style="height: 30px;"></div>
        <div class="fl mL15">
            <button class="btn btn-default w100 removeHtml" ng-click="deleteDrill()" data-remove="removeDrill">删除</button>
        </div>
    </div>
</div>