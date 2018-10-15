<?php
use backend\assets\LeagueCtrlAsset;
LeagueCtrlAsset::register($this);
$this->title = '选择历史课程并新增';
?>
<section class="w60Auto animated fadeIn">
    <div class="ha_title"><h4>选择历史课程并新增</h4></div>
    <!--ha_xz 选择-->
    <div class="ha_xz">
        <div class="ha_xznr clearfix">
            <div class="ha_year list_rq" id="lists_date">
                <ul>
                    <li>2017年1月</li>
                    <ul class="list_mon">
                        <li>第一周</li>
                        <li>第二周</li>
                        <li>第三周</li>
                        <li>第四周</li>
                    </ul>
                    <li>2017年2月</li>
                    <ul class="list_mon">
                        <li>第一周</li>
                        <li>第二周</li>
                        <li>第三周</li>
                        <li>第四周</li>
                    </ul>
                    <li>2017年3月</li>
                    <ul class="list_mon">
                        <li>第一周</li>
                        <li>第二周</li>
                        <li>第三周</li>
                        <li>第四周</li>
                    </ul>
                    <li>2017年4月</li>
                    <ul class="list_mon">
                        <li>第一周</li>
                        <li>第二周</li>
                        <li>第三周</li>
                        <li>第四周</li>
                    </ul>
                    <li>2017年5月</li>
                    <ul class="list_mon">
                        <li>第一周</li>
                        <li>第二周</li>
                        <li>第三周</li>
                        <li>第四周</li>
                    </ul>
                    <li>2017年6月</li>
                    <ul class="list_mon">
                        <li>第一周</li>
                        <li>第二周</li>
                        <li>第三周</li>
                        <li>第四周</li>
                    </ul>
                    <li>2017年7月</li>
                    <ul class="list_mon">
                        <li>第一周</li>
                        <li>第二周</li>
                        <li>第三周</li>
                        <li>第四周</li>
                    </ul>
                    <li>2017年8月</li>
                    <ul class="list_mon">
                        <li>第一周</li>
                        <li>第二周</li>
                        <li>第三周</li>
                        <li>第四周</li>
                    </ul>
                    <li>2017年9月</li>
                    <ul class="list_mon">
                        <li>第一周</li>
                        <li>第二周</li>
                        <li>第三周</li>
                        <li>第四周</li>
                    </ul>
                    <li>2017年10月</li>
                    <ul class="list_mon">
                        <li>第一周</li>
                        <li>第二周</li>
                        <li>第三周</li>
                        <li>第四周</li>
                    </ul>
                    <li>2017年11月</li>
                    <ul class="list_mon">
                        <li>第一周</li>
                        <li>第二周</li>
                        <li>第三周</li>
                        <li>第四周</li>
                    </ul>
                    <li>2017年12月</li>
                    <ul class="list_mon">
                        <li>第一周</li>
                        <li>第二周</li>
                        <li>第三周</li>
                        <li>第四周</li>
                    </ul>
                </ul>
                <div class="list_hove">选择月课程并添加</div>
            </div>
            <div class="ha_week list_rq">
                <ul>
                    <li>周一3月6日</li>
                    <li>周一3月6日</li>
                    <li>周一3月6日</li>
                    <li>周一3月6日</li>
                    <li>周一3月6日</li>
                    <li>周一3月6日</li>
                    <li>周一3月6日</li>
                </ul>
                <div class="list_hove">选择周课程并添加</div>
            </div>
            <div class="ha_day list_rq">
                <form >
                    <select name="" class="form-control">
                        <option value="">请选择课种</option>
                        <option value="A.课种" selected="">瑜伽</option>
                        <option value="B.课种">2</option>
                        <option value="C.课种">3</option>
                    </select>
                    <input style="text-indent: 10px;" class="form-control" type="text" placeholder="瑜伽"/>
                    <select name="" class="form-control">
                        <option value="">请选择课种</option>
                        <option value="瑜伽" selected="">瑜伽</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                    <select name=""class="form-control">
                        <option value="">请选择课种</option>
                        <option value="Kool" selected="">瑜伽</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                    <select name=""class="form-control">
                        <option value="">请选择课种</option>
                        <option value="瑜伽" selected="">瑜伽</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                    </select>
                    <div class="form-group clearfix" style="width: 100%;">
                        <div class="input-group clockpicker fl" data-autoclose="true"  style="width: 50%;">
                            <input type="text" class="input-sm form-control"  placeholder="开始时间" style="border-radius: 3px 0 0 3px;">
                        </div>
                        <div class="input-group clockpicker fl" data-autoclose="true"  style="width: 50%;">
                            <input type="text" class="input-sm form-control" placeholder="结束时间" style="border-radius: 0 3px 3px 0;">
                        </div>
                    </div>
                    <textarea class="form-control" name="" style="resize: none;" rows="" cols="10" placeholder="精选瑜伽课程"></textarea>
                </form>
                <div class="list_hove">选择日课程并添加</div>
            </div>
        </div>
    </div>
    <div class="h50">
        <h6><button class="btn btn-primary" style="width: 100px">返回</button></h6>
    </div>
</section>

