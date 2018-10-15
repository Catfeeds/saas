<?php
/**
 * Created by PhpStorm.
 * User: yanghuilei
 * Date: 2018/1/6 0006
 * Time: 下午 12:51
 */
?>
<div class="form-group form-inline selectBox leiGe col-sm-12" style="margin-top: 20px;margin-bottom: 0;padding-right: 0;">
    <label for="inputEmail4" class="control-label pull-left text-center" style="width: 115px;">多月设置</label>
    <div class="col-sm-3" style="padding-right: 0;">
        <div class="input-group">
            <input class="form-control" name="cabinet_month" style="width: 50%;" id="inputEmail4" type="text" placeholder="月数"/>
            <input class="form-control" name="cabinet_money" style="width: 50%;" id="inputEmail4" type="text" placeholder="金额"/>
        </div>
    </div>
    <label for="inputEmail4" class="col-sm-2 control-label pd0" style="width: 90px;text-align: center;">赠送</label>
    <div class="col-sm-2 pd0">
        <select name="" id="" class="form-control"  style="width: 40%;padding: 0 0 0 5px;">
            <option value="d">天数</option>
            <option value="m">月数</option>
        </select>
        <input class="form-control" name="give_month" id="inputEmail4" placeholder="赠送数" type="text" style="width: 60%;margin-left: -5px;"/>
    </div>
    <label for="inputEmail4" class="col-sm-1 control-label" style="text-align: center;">折扣</label>
    <div class="col-sm-2 pd0">
        <input class="form-control" name="cabinet_dis" id="inputEmail4" type="text" placeholder="请输入折扣" style="width: 100px;"/>
        <p class="help-block">
            <i class="glyphicon glyphicon-info-sign"></i>多个折扣用<span class="text-info">"/"</span>分开
        </p>
    </div>
    <button id="modifyPlugins" class="btn btn-default btn-sm removeHtml" data-remove="leiGe">删除</button>
</div>

