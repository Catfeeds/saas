<?php
use backend\assets\AuthCtrlAsset;
AuthCtrlAsset::register($this);
$this->title = '添加角色';
?>
<!--头部-->
<header>
    <div>
        <ul class="h_nav">
            <li class="nav_name">
                <ul class="nav_nameList">
                    <li>添加角色</li>
                    <li class="EN">Add Employee</li>
                </ul>
            </li>
        </ul>
    </div>
</header>
<!--结束-->
<div class="container animated fadeIn" style="background: #f5f5f5;padding-bottom: 4%;margin-top: 40px;">
    <div style="background: #fff;" class="col-md-4 col-sm-4 col-xs-4 col-md-offset-4 col-sm-offset-4 col-xs-offset-4 labelBox">
        <h2 class="h2Title">添加角色</h2>
        <form>
            <div class="form-group">
                <label for="exampleInputNam">名称</label>
                <input type="text" class="form-control" id="exampleInputName2" placeholder="叫什么">
                <label style="margin-top: 20px"  for="textarea2">说明</label>
                <textarea class="form-control" style="resize: none;" id="textarea2" rows="6" placeholder="写入说明如：普通员工&nbsp&nbsp&nbsp&nbsp一般权限"></textarea>
            </div>
        </form>
        <div style="margin-top: 20px;margin-bottom: 20px; margin-left: 0;margin-right: 0;padding-left: 0; padding-right: 0;" class="col-sm-12">
            <a href="/authority/index?&c=40"><span type="button" class="btn btn-primary pull-left">&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp</span></a>
            <button type="button" class="btn btn-success pull-right">&nbsp&nbsp&nbsp添加&nbsp&nbsp&nbsp</button>
        </div>
</div>