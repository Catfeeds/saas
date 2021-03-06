<?php
/* @var $this yii\web\View */
use backend\assets\AccessRegisterCtrlAsset;
AccessRegisterCtrlAsset::register($this);
$this->title = '进馆登记';
?>
<main ng-controller="registerSuccessPage" style="background-color: #FFF;height: 100%;">
    <div  class="header">
        <div class="backBtn ">
            <span class="glyphicon glyphicon-menu-left f24 "  style="font-size: 24px;color: #e5e5e5;"></span>
        </div>
        <div>进馆登记</div>
        <div></div>
    </div>
    <div class="weui_msg">
        <div class="weui_icon_area"><i  class="weui_icon_success weui_icon_msg colorAqua"></i></div>
        <div class="weui_text_area">
            <p class="weui_msg_desc fw " style="color: #2FBF79;font-size: 16px;">进馆登记成功</p>
        </div>
        <div class="weui_opr_area" ng-click="backPrePage()">
            <p class="weui_btn_area">
                <a class="weui_btn weui_btn_primary colorAquaBg">返回</a>
            </p>
        </div>
    </div>
</main>