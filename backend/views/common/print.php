<div id="prints">
    <div id="uiPrints">
    <ul>
        <li style="text-align: center" ng-if="printer.venue == null">大上海店</li>
        <li style="text-align: center" ng-if="printer.venue != null">{{printer.venue.name}}</li>
        <li ng-if="printer.about_type == 1">类型：电脑预约</li>
        <li ng-if="printer.about_type == 2">类型：APP预约</li>
        <li ng-if="printer.about_type == 3">类型：小程序预约</li>
        <li>场馆：{{printer.classroom.name}}</li>
        <li>编号：{{printer.seat.seat_number}}</li>
        <li>课程：{{printer.course.name}}</li>
        <li>日期：{{printer.class_date}}</li>
        <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{(printer.start)*1000 | date:'HH:mm'}} -- {{(printer.end)*1000 | date:'HH:mm'}}</li>
        <li>卡号：{{memberData.card_number}}</li>
        <li>姓名：{{memberData.name}}</li>
        <li>登记：<?php date_default_timezone_set('PRC'); echo date("Y.m.d H:i:s")?></li>
    </ul>
    </div>
</div>