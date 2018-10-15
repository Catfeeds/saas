<div class="clearfix myDiv">
    <div class="col-sm-4 pd0 form-group formSmbox mB40">
        <label for="muchMonth<?=$num?>">多月设置</label>
        <div class="input-group">
            <input type="text" id="muchMonth<?=$num?>" name="cabinet_month" class="form-control" checknum style="width: 100px;" placeholder="月数" autocomplete="off"/>
            <input type="number" name="cabinet_money" ng-model="cabinetMoney<?=$num?>" class="form-control moneyInput" style="width: 100px;" placeholder="金额" autocomplete="off"/>
        </div>
        <span class="label label-info" ng-bind = "cabinetMoney<?=$num?>|currency:'￥':0"></span>
    </div>
    <div class="col-sm-4 pd0 form-group formSmbox mB40" >
        <label for="giveMonth<?=$num?>"><span style="visibility: hidden">*</span>&emsp;&emsp;赠送</label>
        <select class="form-control" style="width: 25%;padding: 0 0 0 5px;">
            <option value="d">天数</option>
            <option value="m">月数</option>
        </select>
        <input type="text" id="giveMonth<?=$num?>" name="give_month" checknum class="form-control" autocomplete="off" placeholder="请输入赠送数" style="width: 35%;"/>
    </div>
    <div class="col-sm-4 pd0 form-group formSmbox mB40">
        <label for="dis<?=$num?>"><span style="visibility: hidden">*</span>&emsp;&emsp;折扣</label>
        <input type="text" id="dis<?=$num?>" name="cabinet_dis" class="form-control w200" placeholder="请输入折扣" autocomplete="off"/>
            <button type="button" class="btn btn-default btn-sm removeHtml" data-remove="myDiv">删除</button>
        <p class="help-block">
            <i class="glyphicon glyphicon-info-sign"></i>多个折扣用<span class="text-info">"/"</span>分开,例如<span class="text-info"> (八折,七折,六折)</span>: <span class="text-success">0.8/0.7/0.6</span>
        </p>
    </div>
</div>