<?php
use backend\assets\JurisdictionCtrlAsset;

JurisdictionCtrlAsset::register($this);
$this->title = $name;
?>
<div class="site-error">
    <h1></h1>
    <p style="font-size: 24px;text-align: center;color: #666;margin-bottom: 20px;">对不起,您没有权限执行此操作</p>
    <p style="text-align: center;margin-left: 52px;"><img src="<?='http://'.$_SERVER ['HTTP_HOST']?>/plugins/img/404.png"></p>
    <p style="text-align: center;font-size: 18px;color: #7266ba;margin-top: 20px">您可以</p>
    <p style="text-align: center;font-size: 18px;margin-top: 10px"><a class="btn btn-primary center-block" href="/site/index" style="color: #fff;width: 140px;"><i style="color: #fff;" class="glyphicon glyphicon-home">&nbsp;</i>返回主页</a></p>
    <p style="text-align: center;font-size: 18px;color: #7266ba;margin-top: 20px">或者联系系统管理员</p>

</div>
