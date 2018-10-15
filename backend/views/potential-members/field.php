<div id="field">
    <div id="fieldDiv">
        <ul>
            <li style="text-align: center" ><h3>{{printerField.venueName}}</h3></li>
            <li class="mT20">场地:&nbsp;{{printerField.yard_name}}</li>
            <li class="mT10">姓名:&nbsp;{{printerField.name}}</li>
            <li class="mT10">时间段:&nbsp;{{printerField.aboutDate}} </li>
            <li class="mT10">&emsp;&emsp;&emsp;&nbsp;{{printerField.about_interval_section}}</li>
            <li class="mT10">预约时间:&nbsp;{{printerField.yardAboutDate*1000 | date:'yyyy-MM-dd HH:mm:ss'}}</li>
            <li class="mT10">手机号码:&nbsp;{{printerField.mobile}}</li>
            <li class="mT10">打印时间:&nbsp;<?php date_default_timezone_set('PRC'); echo date("Y-m-d H:i:s")?></li>
        </ul>
    </div>
</div>