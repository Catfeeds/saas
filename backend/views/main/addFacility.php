<?php
use backend\assets\MainCtrlAsset;
MainCtrlAsset::register($this);
$this->title = '设备管理添加';
?>
<!---->
<header class="reservation_header clearfix fw">
    <div class="w20  fl">云.运动</div>
    <div class="fl">1.设备管理添加</div>
</header>
<div class="yy_progress">
    <div class="progress"></div>
</div>
<section class="yy_search animated fadeIn">
    <div class="searchBox">
        <form action="">
            <div style="margin-bottom: 10px;">
                <h2>设备管理添加</h2>
            </div>
            <p >资产编号</p>
            <input class="form-control" type="text" placeholder="请输入资产编号" style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>设备型号</p>
            <input class="form-control" type="text" placeholder="请输入设备型号" style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>设备名称</p>
            <input class="form-control" type="text" placeholder="请输入设备名称" style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>规格</p>
            <input class="form-control" type="text" placeholder="请输入规格" style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>数量</p>
            <input class="form-control" type="text" placeholder="请输入数量" style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>制造厂</p>
            <input class="form-control" type="text" placeholder="请输入制造厂" style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>出厂日期</p>
            <input class="form-control" type="text" placeholder="请输入出厂日期" style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>到场日期</p>
            <input class="form-control" type="text" placeholder="请输入到场日期" style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>重量</p>
            <input class="form-control" type="text" placeholder="请输入重量" style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>所属锻炼项目</p>
            <input class="form-control" type="text" placeholder="请输入锻炼项目" style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>购置日期</p>
            <input class="form-control" type="text" placeholder="请输入购置日期" style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>原值</p>
            <input class="form-control" type="text" placeholder="请输入原值" style="border-radius: 3px;border: solid 1px darkgrey;"/>
            <p>状态</p>
            <input class="form-control" type="text" placeholder="请输入状态" style="border-radius: 3px;border: solid 1px darkgrey;"/>


            <p style="margin-bottom: 5px;">设备描述</p>
            <textarea style="border: solid 1px darkgrey;resize: none;" name="" id="" cols="59" rows="10" class="form-control"></textarea>
            <p style="margin-top: 10px;">请添加设备照片</p>
            <div class="input-file " style="margin: 5px 0px 20px 0;width: 100px;height: 100px;border: 1px dashed #ddd;position: relative">
                <p style="width: 100%;height: 100%;line-height: 94px;font-size: 50px;" class="text-center">+</p >
                <input type="file" class="cp" style="width: 100%;height: 100%;opacity: 0;position: absolute;top: 0;left: 0;">
            </div>

            <p style="margin-top: 10px;">安装使用公司</p>
            <select class="form-control darkGrey" name="">
                <option value="请选择所属公司">请选择所属公司</option>
                <option value="我爱运动">我爱运动</option>
                <option value="黄金时代">黄金时代</option>
            </select>
            <p style="margin-top: 10px;">安装使用场馆</p>
            <select class="form-control darkGrey" name="">
                <option value="请选择所属公司">请选择所属场馆</option>
                <option value="我爱运动">大卫城</option>
                <option value="黄金时代">大上海</option>
            </select>
            <p style="margin-top: 10px;">安装使用场地</p>
            <select class="form-control darkGrey" name="">
                <option value="请选择所属公司">请选择所属场地</option>
                <option value="我爱运动">A瑜伽教室</option>
                <option value="黄金时代">B瑜伽教室</option>
            </select>

        </form>
    </div>
    <div id="lastBox">
        <div class="fixedBox " >
            <button type="button" class="backBut btn btn-primary " style="width: 100px">返回</button>
            <a href="/main/facility"style="color: #FFFFFF;">
                <button type="button" class="btn btn-success" style="width: 100px">完成</button>
            </a>

        </div>
    </div>
</section>
