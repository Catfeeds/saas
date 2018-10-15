<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/28 0028
 * Time: 11:16
 */
-->
<!--添加内容-->
<div class="row mr0 modalMain mB10 removeMainDiv updateModalNew">
    <div class="col-md-12 mB10 pd0">
        <div class="col-lg-2 text-right pd0 lH30">
            <span class="red">*</span>类别
        </div>
        <div class="col-lg-8">
            <select class="form-control selectStyle chooseSelect" ng-model="$parent.chooseType<?=$num;?>">
                <option value="">请选择</option>
                <option value="3">单选</option>
                <option value="2">多选</option>
                <option value="1">自定义答案</option>
            </select>
        </div>
    </div>
    <div class="col-md-12 mB10 pd0">
        <div class="col-lg-2 text-right pd0 lH30">
            <span class="red">*</span>问题
        </div>
        <div class="col-lg-8">
            <input type="text" class="form-control question" placeholder="请输入问题">
        </div>
    </div>
    <div class="col-md-12 mB10 pd0 choiceDiv" ng-if="$parent.chooseType<?=$num;?> != 1">
        <div class="row mr0 mB10 choice">
            <div class="col-lg-2 text-right pd0 lH30">
                <span class="red">*</span>选项
            </div>
            <div class="col-lg-8">
                <input type="text" class="form-control choiceInput" placeholder="请输入选项">
            </div>
        </div>
        <div class="row mr0 mB10 choice">
            <div class="col-lg-2 text-right pd0 lH30">
                <span class="red">*</span>选项
            </div>
            <div class="col-lg-8">
                <input type="text" class="form-control choiceInput" placeholder="请输入选项">
            </div>
        </div>
    </div>
    <div class="col-lg-10 col-lg-offset-2 mB10 addChoiceDiv" ng-if="$parent.chooseType<?=$num;?> != 1">
        <button class="btn btn-default w100" ng-click="addChoice()" id="addChoiceBtn" venuehtml>添加</button>
    </div>
    <div class="col-lg-12 pd0 text-right">
        <button class="btn btn-default w100 removeHtml" data-remove="removeMainDiv">删除</button>
    </div>
</div>