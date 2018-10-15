angular.module('App').controller('ReservationCtrl', function ($scope, $http, Upload, $timeout,$rootScope) {
    $scope.str = window.location.href.split('?');
    $scope.str2 = $scope.str[1].split('&');
    $scope.str3 = $scope.str2[0].split('=');
    $scope.str4 = $scope.str2[1].split('=');
    var oDate = new Date();
    var oYear = oDate.getFullYear();
    var oMonth = oDate.getMonth() + 1;
    oMonth = oMonth >= 10 ? oMonth : '0' + oMonth;
    var oDay = oDate.getDate();
    oDay = oDay >= 10 ? oDay : '0' + oDay;
    var theDate = oYear + "-" + oMonth + "-" + oDay;
    $('.checkUl').height(document.documentElement.clientHeight-240 + 'px')
    $('.textAlignCenter').height(document.documentElement.clientHeight-210 + 'px');
    $('.group-ul').height($(window).height()-145 + 'px');
    $("#dateIndex").datetimepicker({
        minView: "month",//设置只显示到月份
        format: 'yyyy-mm-dd',
        language: 'zh-CN',
        autoclose: true,
        todayBtn: true //今日按钮
    }).on('changeDate', function (ev) {
        $scope.getData();
        $scope.totalRows = [];
    });
    if (!$('#dateIndex').val()) {
        $('#dateIndex').val(theDate);
    }
    // 获取课程
    $scope.getData = function () {
        var rr = $('#dateIndex').val();
        console.log(rr)
        var date = new Date(rr.replace(/-/g, '/'));
        var time3 = Date.parse(date)/1000;
        if (!rr) {
            time3 = '';
        }
        var url = '/check-card/group-class-datalist?memberId=' + $scope.str3[1] + '&start_time=' + time3;
        $http({
            url: url,
            method: 'GET'
        }).then(function (data) {
            $scope.data = data.data;
            $timeout(function () {
                $('.checkUl').height(document.documentElement.clientHeight-240 + 'px')
                $('.boxShowNone').height(document.documentElement.clientHeight-280 + 'px');
            },200)
        },function (error) {
            console.log(error);
            Message.warning('系统开了会小差,请刷新重试。。。')
        })
    };
    $scope.getData();
    $scope.show = false;
    $scope.selectCourseSeat = function(id,time,index) {
        $scope.show = true;
        angular.forEach($scope.data,function (item, ind) {
            if (index == ind) {
                item.choose = true;
            } else {
                item.choose = false;
            }
        })
        $scope.seatID = '';
        $scope.appointmentButtonFlag = false;
        if (parseInt(time) > parseInt($scope.invalid_time)){
            Message.warning("您的卡"+$scope.getMyDate($scope.invalid_time)+"到期！！！暂时不能预约课程")
            return
        }
        $scope.classId = id
        $scope.getAboutSeatRule();
        $http({
            method: 'get',
            url: '/check-card/group-class-member-rule-data?memberId=' + $scope.str3[1] + '&classId=' + $scope.classId + '&memberCardId=' + $scope.str4[1],
        }).then(function (data) {
            $scope.isCanClass = data.data.isCanClass;
            $scope.isAboutClass = data.data.isAboutClass;
            $scope.isDance = data.data.isDance;
        },function (err) {
            Message.warning('系统开了会小差,请刷新重试。。。')
            console.log(err)
        });
    };
    $scope.totalRows = [];
    // 约课
    $scope.getAboutSeatRule = function () {
        $scope.items = '';
        $scope.totalRows = [];
        var url = '/check-card/get-seat-detail?id='+ $scope.classId +'&memberId=' +  $scope.str3[1];
        $http({
            url: url,
            method: 'GET'
        }).then(function (data) {
            if (data.data.status === 'success') {
                $scope.items = data.data.message;
                for(var i = 1;i<=$scope.items.total_rows;i++){
                    $scope.totalRows.push(i);
                }
            }
            $('.bb').height('auto');
        }, function (error) {
            console.log(error)
            Message.warning('系统开了会小差,请刷新重试。。。');
        })
    };
    /**
     * 选择座位
     */
    var seatNum;
    var notPass = false;
    $scope.seatSelect = function (id, num,type,i) {
        if ($scope.isCanClass === false){
            Message.warning('您还不能约这节课！')
            $('#myModal').modal('hide');
            return
        }
        if ($scope.isAboutClass === true){
            Message.warning('该时间段已约课，不可重复预约');
            $('#myModal').modal('hide');
            return
        }
        if ($scope.isDance === true) {

        }
        $scope.memberSeatType = type;
        if ($('.courseSeates').eq(i).hasClass('notSelect') || $('.selectedVip').eq(i).hasClass('notSelect')) {
            return;
        }
        else {
            seatNum = id;
            notPass = false;
            var number = parseInt(seatNum);
            $scope.seatID = number;
            var $vip = $('.vip');
            if($scope.memberSeatType == 1){
                $('.courseSeates').removeClass('selected');
                $('.courseSeates').eq(i).addClass('selected');
                if(!$vip.hasClass('selected')){
                    $vip.addClass('selectedVip');
                    $vip.removeClass('vip');
                }
            }
            if($scope.memberSeatType == 2){
                if ($scope.memberSeatType != $scope.identify){
                    Message.warning("不好意思请升级，您的卡");
                    $('.courseSeates').removeClass('selected');
                    notPass = true;
                    return
                }
                $('.courseSeates').removeClass('selected');
                $('.courseSeates').eq(i).removeClass('selectedVip');
                $('.courseSeates').eq(i).addClass('selected');
                $('.courseSeates').eq(i).addClass('vip');
                if(!$vip.hasClass('selected')){
                    $vip.addClass('selectedVip');
                    $vip.removeClass('vip');
                }
            }
        }
    }
    $scope.getAboutSeatRule();
    //跳转预约成功
    $scope.appointment = function(){
        var orderData = {
            classId: $scope.classId, //课程ID
            _csrf_backend:$('#_csrf').val(),
            seatId: $scope.seatID, //选择座位
            memberCardId: $scope.str4[1], // 会员卡ID
            memberId: $scope.str3[1],//会员ID
            classType: 'group', //课程类型
            aboutT:'mobile',
        }
        if (notPass) {
            Message.warning("不好意思请升级，您的卡");
            return
        }
        if (!orderData.seatId){
            Message.warning('请选择座位')
            return;
        }
        $scope.appointmentButtonFlag = true;
        $http({
            method: 'POST',
            url: '/check-card/set-about-class-record',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            data: $.param(orderData)
        }).then(function (success) {
            if(orderData.seatId != ''){
                if (success.data.message == '预约成功'){
                    var classsids = success.data.data;
                    $scope.totalRows.splice(0,$scope.totalRows.length);
                    var  urls = '/check-card/get-about-class-detail?id='+ classsids
                    $http({
                        method: 'GET',
                        url:urls,
                    }).then(function (data) {
                        $scope.printers = data.data.data;
                        $scope.datase = data.data.data;
                        $scope.getAboutSeatRule();
                        // $scope.printTicket();
                        $('#myModalComplete').modal('show');
                    })
                }
                //预约重复
                else if(success.data.status == 'repeat'){
                    Message.warning(success.data.message);
                    $scope.appointmentButtonFlag = false;
                    return
                }
                //该卡不能预约任何课程
                else if(success.data.status == 'noClass'){
                    Message.warning(success.data.message);
                    $scope.appointmentButtonFlag = false;
                    return
                }
                //该卡不能预约此课程
                else if(success.data.status == 'noBindClass'){
                    Message.warning(success.data.message);
                    $scope.appointmentButtonFlag = false;
                    return
                }
                //该课程今日预约次数已用完
                else if(success.data.status == 'classOver'){
                    Message.warning(success.data.message);
                    $scope.appointmentButtonFlag = false;
                    return
                }
                //该时间点已预约其它课程
                else if(success.data.status == 'hadClass'){
                    Message.warning(success.data.message);
                    $scope.appointmentButtonFlag = false;
                    return
                }
                //开课前多少分钟不能预约
                else if(success.data.data.status == "endAboutLimit"){
                    // Message.warning("开课"+ success.data.data.endClassLimit +"分钟前不能预约");
                    Message.warning("课程已开课不能预约");
                    $scope.appointmentButtonFlag = false;
                    return
                }
                else {
                    Message.warning(success.data.message);
                }
                $scope.appointmentButtonFlag = false;
                // $scope.printTicket();
            }
        }, function (error) {
            $scope.appointmentButtonFlag = false;
            console.log(error);
            Message.warning('系统开了会小差,请刷新重试。。。');
        })
    }
    /****** 打印机start *****/

    //end
    $scope.printTicket = function () {
        if(!$scope.printers){
            Message.warning('没有预约的课程无法打印');
            return false;
        }
        $scope.aboutId = $scope.printers.id;
        $scope.getPrintHtml();
    };

    $scope.getPrintHtml = function () {
        var open = 1;
        if (open < 10) {
            var $prints = $('#coursePrints');
            var bodyHtml  = $('body').html();
            if ($scope.printers.about_type==1) {
                $scope.yType = '电脑预约';
            } else if ($scope.printers.about_type==2) {
                $scope.yType = 'APP预约';
            } else if ($scope.printers.about_type==3) {
                $scope.yType = '小程序预约';
            }
            var date2 = new Date(Number($scope.printers.end*1000));
            var minute2 = date2.getMinutes();
            var hours2 = date2.getHours();
            minute2 = minute2 < 10 ? ('0' + minute2) : minute2;
            hours2 = hours2 < 10 ? ('0' + hours2) : hours2;
            var date1 = new Date(Number($scope.printers.start*1000));
            var minute1 = date1.getMinutes();
            var hours1 = date1.getHours();
            minute1 = minute1 < 10 ? ('0' + minute1) : minute1;
            hours1 = hours1 < 10 ? ('0' + hours1) : hours1;
            $scope.start1 = hours1 + ':' + minute1;
            $scope.end2 = hours2 + ':' + minute2;
            $scope.bdhtml = "<p>类型:" + $scope.yType + "</p><p>场馆:"+ $scope.printers.venue.name +"</p><p>座位号:"+ $scope.printers.seat.seat_number +"号</p><p>课程:"+ $scope.printers.course.name +"</p><p>日期:"+ $scope.printers.class_date + "<br>" + $scope.start1 + "-" + $scope.end2 +"</p><p>卡号:"+$scope.printers.memberNumber.card_number +"</p><p>姓名:"+ $scope.printers.member.name +"</p><p>登记:"+ theDate +"</p>";//获取当前页的html代码
            window.document.body.innerHTML= $scope.bdhtml;
            $scope.updateAboutStatus($scope.aboutId,'one');
            window.print();
            window.document.body.innerHTML= bodyHtml;
            location.replace(location.href);
        } else {
            window.print();
        }
    };
    $scope.updateAboutStatus = function (id,type) {
        $http.get('/check-card/update-about-print?id=' + id + '&type=' + type).then(function (result) {

        });
    };
});