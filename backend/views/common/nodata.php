<!--暂无数据-->
<div style="margin: 4% auto 0 auto;text-align: center;font-size: 22px;color: #888;" ng-show="<?=isset($name) ? $name:'dataInfo'?>">
    <img src="/plugins/noData/img/noDate.png">
    <p style="margin-top:3%;"><?=isset($text) ? $text : '暂无数据'?></p>
    <?php if(!isset($href)):?>
    <a href="/site/index?mid=25&c=24"><button class="btn btn-primary">&nbsp&nbsp返回主页&nbsp&nbsp</button></a>
    <?php endif;?>
</div>
<!--搜索没有结果-->
<div style="margin: 4% auto 0 auto;text-align: center;font-size: 22px;color: #888;" ng-show="searchData">
    <img src="/plugins/noData/img/noSearch.png">
    <p style="margin-top:3%;">暂无数据</p>
    <a href="/site/index?mid=25&c=24"><button class="btn btn-primary">&nbsp&nbsp返回主页&nbsp&nbsp</button></a>
</div>
<!--网络未连接-->
<div style="margin: 4% auto 0 auto;text-align: center;font-size: 22px;color: #888;" ng-show="noNetWork">
    <img src="/plugins/noData/img/noNetwork.png">
    <p style="margin-top:3%;">检查不到网络了</p>
    <a href="/site/index?mid=25&c=24"><button class="btn btn-primary">&nbsp&nbsp返回主页&nbsp&nbsp</button></a>
</div>