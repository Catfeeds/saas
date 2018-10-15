<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/24 0024
 * Time: 14:59
 */
-->
<!--自定义模板-->
<div class="col-md-12 templateDiv fl mB10 pd0 pd20 removeCustom">
    <div class="col-lg-2 col-md-2">
        <span class="red lH30">*</span>训练阶段
    </div>
    <div class="col-lg-8 col-md-10 pd0">
        <div class="col-md-12 pd0 mB10 stageNameDiv">
            <div class="col-md-1 pd0 w60">
                <span class="red lH30">*</span>阶段名称
            </div>
            <div class="col-md-5">
                <input type="text" class="form-control stageName" placeholder="请输入阶段名称">
            </div>
        </div>
        <div class="col-md-12 pd0 stageTimeDiv">
            <div class="col-md-1 pd0 lH30 w60">
                <span class="white lH30">*</span>建议时长
            </div>
            <div class="col-md-5">
                <input type="number" inputnum min="1" class="form-control stageTime" placeholder="分钟">
            </div>
        </div>
    </div>
    <div class="col-lg-12 text-right">
        <button class="btn btn-default w100 removeHtml" data-remove="removeCustom">删除</button>
    </div>
</div>
