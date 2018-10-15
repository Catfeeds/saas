<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/22 0022
 * Time: 13:37
 */
-->
<!--添加阶段模板-->
<div class="col-md-12 templateDiv fl pd0 mB10 removeTemplate">
    <div class="col-lg-2 col-md-2 mT10">
        <span class="red lH30">*</span>训练阶段
    </div>
    <div class="col-lg-8 col-md-10 pd0">
        <div class="col-md-12 pd0 mB10 mT10 stageNameDiv">
            <div class="col-md-1 pd0 w60">
                <span class="red lH30">*</span>阶段名称
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control stageName" placeholder="请输入阶段名称">
            </div>
        </div>
        <div class="col-md-12 pd0 mB10 stageTimeDiv">
            <div class="col-md-1 pd0 lH30 w60">
                <span class="white lH30">*</span>训练时长
            </div>
            <div class="col-md-5">
                <input type="number" inputnum min="1" class="form-control stageTime" placeholder="分钟">
            </div>
        </div>
        <div class="col-md-12 pd0 mB10">
            <div class="col-md-1 pd0 w60">
                <span class="white">*</span>训练内容
            </div>
            <div class="col-lg-8 col-md-8 mL15 pd0 drillDiv" style="border:1px solid #c0bfc4">
                <div class="row mr0 oneDrill">
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
                </div>
            </div>
            <div class="col-md-12 mT10 btnDiv">
                <div class="col-md-1 pd0 w60"></div>
                <button class="btn btn-default w100" venuehtml ng-click="addDrill()" id="addDrillBtn">添加</button>
            </div>
        </div>
    </div>
    <div class="col-md-12 mB10 text-right">
        <button class="btn btn-default w100 removeHtml" ng-click="deleteTemplate()"  data-remove="removeTemplate">删除</button>
    </div>
</div>
