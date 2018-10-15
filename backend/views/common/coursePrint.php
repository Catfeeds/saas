<div id="coursePrints">
    <div id="courseUiPrints">
        <ul>
            <li style="text-align: center;font-size: 16px;font-weight: 400;" ng-if="printers.venue == null">大上海店</li>
            <li style="text-align: center" ng-if="printers.venue != null">{{printers.venue.name}}</li>
            <li ng-if="printers.about_type == 1">类型：电脑预约</li>
            <li ng-if="printers.about_type == 2">类型：APP预约</li>
            <li ng-if="printers.about_type == 3">类型：小程序预约</li>
            <li>场馆：{{printers.classroom.name}}</li>
            <li>号码：{{printers.seat.seat_number}}</li>
            <li>课程：{{printers.course.name}}</li>
            <li>日期：{{printers.class_date}}</li>
            <li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{(printers.start)*1000 | date:'HH:mm'}} -- {{(printers.end)*1000 | date:'HH:mm'}}</li>
            <li ng-if="printers.memberNumber != undefined">卡号：{{printers.memberNumber.card_number}}</li>
            <li>姓名：{{printers.employee.name}}</li>
            <li>登记：<?php date_default_timezone_set('PRC'); echo date("Y.m.d H:i:s")?></li>
        </ul>
    </div>
</div>