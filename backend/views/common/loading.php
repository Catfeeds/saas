<style>
    .activityindicator{
        display: none;
    }
    .activityindicator .loading{
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.5);
        z-index: 99999999 !important;
    }
    .activityindicator .loading .spinner{
        position: relative;
        top: 50%;
        left: 50%;
        width: 160px;
        height: 100px;
        margin-top: -50px;
        margin-left: -80px;
        text-align: center;
        font-size: 16px;
        color: #ffffff;
    }
    .activityindicator .loading .spinner .text{
        margin-top: 5px;
    }
</style>
<div class="activityindicator" id="cloud_loader">
    <div class="loading">
        <div class="spinner">
<!--            fa fa-sun-o-->
            <i class="fa fa-sun-o fa-spin fa-3x fa-fw"></i>
            <div class="text"><?=['玩命','拼命','疯狂','使劲'][array_rand(['玩命','拼命','疯狂','使劲'],1)]?>加载中...</div>
        </div>
    </div>
</div>