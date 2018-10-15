angular.module('App').controller('CheckCardCtrl', function ($scope, $http, Upload, $timeout,$rootScope) {
    //搜索验卡
    if (window.location.href.indexOf('/correcting/index') > 0) {
        localStorage.removeItem('ee');
    } else {
        if (localStorage.getItem('ee')) {
            $scope.rr = localStorage.getItem('ee');
            $scope.cardNumber = angular.fromJson($scope.rr).cardNumber;
            $scope.cardId = angular.fromJson($scope.rr).cardId;
        }
        console.log($scope.cardNumber);
        if (localStorage.getItem('member')) {
            $scope.ss = localStorage.getItem('member');
            $scope.memberId = angular.fromJson($scope.ss).member;
        }
    }
    $scope.enterCard = function () {
        $scope.getMembersData();
        $scope.siteReservationList($scope.cardNun);
        $scope.getStatisticsData($scope.statisticsDataId);
        $scope.init($scope.allCardId);
        $scope.getAllCardData();
        $scope.getEntryData($scope.entryDataId);
        // $scope.getAboutAllOneClassData($scope.getAboutId);
        $scope.getAboutClassData($scope.getAboutClassId);
    }
    $scope.checkCardNumberMember = function (type) {
        $scope.clickNumFlag = 1;
        $scope.cardNumber = $scope.cardNumber1 ? $scope.cardNumber1 : $scope.cardNumber;
        console.log($scope.cardNumber)
        if (!$scope.cardNumber) {
            Message.warning('请刷卡或输入会员卡号或手机号');
            return false;
        }
        if ($scope.cardNumber.indexOf(':') > 0) {
            $scope.cardNumber = $scope.cardNumber.substr(0, 0);
            $scope.checkCardNumber = $scope.cardNumber;
        }
        if ($scope.cardNumber.indexOf('?') > 0 || $scope.cardNumber.indexOf('？') > 0) {
            $scope.cardNumber = $scope.cardNumber.substr(0, $scope.cardNumber.length - 1);
            $scope.checkCardNumber = $scope.cardNumber;
        }
        var $pattern = /^1\d{10}$/;
        var $reg = /(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
        $scope.numType = 'num';
        if (($pattern.test($scope.cardNumber))) {
            $scope.numType = 'mobile';
            $http.get('/user/get-member-info?mobile=' + $scope.cardNumber).then(function (response) {
                if (response.data && response.data != 'null') {
                    $scope.memberId = response.data.id;
                    $scope.$emit('tt1');
                    localStorage.setItem('member',JSON.stringify({
                        member: $scope.memberId
                    }));
                    $http.get('/user/member-card-info?MemberId=' + response.data.id +'&type=2').then(function (response) {
                        if (response.data.item.length > 1) {
                            $scope.allMemberCard = response.data.item;
                            $('#selectCardModal').modal('show');
                        }
                        if (response.data.item instanceof Array && response.data.item.length == 1) {
                            if(response.data.item[0].goVenue != null  ){
                                $scope.checkCardNumber = response.data.item[0].id
                                $scope.checkCardSelect($scope.checkCardNumber);
                                localStorage.setItem('ee',JSON.stringify({
                                    cardNumber: $scope.cardNumber1,
                                    cardId: $scope.checkCardNumber
                                }));
                                $scope.isShowData = true;
                                if (window.location.href.indexOf('/correcting/index') > 0) {
                                    window.location.href = '/wcheck-card/index';
                                }
                                $scope.cardNumber = '';
                            }else{
                                Swal.error('该会员卡不能通店');
                            }

                        }
                        if (!(response.data.item instanceof Array) && response.data.item == 2) {
                            $http.get("/user/member-information?memberId=9222").then(function (response) {
                                $scope.memberData = response.data;
                                console.log($scope.cardNumber1)
                                console.log($scope.cardNumber)
                                localStorage.setItem('ee',JSON.stringify({
                                    cardNumber: $scope.cardNumber1 ? $scope.cardNumber1 : $scope.cardNumber,
                                    cardId: ''
                                }));
                            })
                            if (window.location.href.indexOf('/correcting/index') > 0) {
                                window.location.href = '/wcheck-card/index';
                            }
                            // $scope.cardNumber = '';
                        }
                        if (response.data.item.length == 0) {
                            Swal.error('该会员手机号不存在，请前去购卡!');
                            $scope.cardNumber = '';
                        }
                    })
                }else{
                    Swal.error('会员不存在或该会员卡不能通店');
                }
            })
        } else if(($reg.test($scope.cardNumber))){
            $scope.numType = 'card';
            $http.get('/user/get-member-info?mobile=' + $scope.cardNumber).then(function (response) {
                if (response.data) {
                    $scope.memberId = response.data.id;
                    $scope.$emit('tt1');
                    localStorage.setItem('member',JSON.stringify({
                        member: $scope.memberId
                    }));
                    $http.get('/user/member-card-info?MemberId=' + response.data.id +'&type=2').then(function (response) {
                        if (response.data.item.length > 1) {
                            $scope.allMemberCard = response.data.item;
                            $('#selectCardModal').modal('show');
                        }
                        if (response.data.item.length == 1 ) {
                            if(response.data.item[0].goVenue){
                                $scope.checkCardNumber = response.data.item[0].id
                                $scope.checkCardSelect($scope.checkCardNumber);
                                localStorage.setItem('ee',JSON.stringify({
                                    cardNumber: $scope.cardNumber1,
                                    cardId: $scope.checkCardNumber,
                                }));
                                $scope.isShowData = true;
                                window.location.href = '/wcheck-card/index';
                                $scope.cardNumber1 = '';
                            }else{
                                Swal.error('该会员卡不能通店');
                            }

                        }
                        if (response.data.item.length == 0) {
                            Swal.error('该会员手机号不存在，请前去购卡!');
                            $scope.cardNumber = '';
                        }
                    })
                }else{
                    Swal.error('会员不存在或该会员卡不能通店');
                }
            })
        }else{
            $scope.numType = 'num';
        }
        if ($scope.numType == 'num') {
            $scope.checkButton = true;
            $http.get('/check-card/check-card-number?num=' + $scope.cardNumber + '&type='+$scope.numType).then(function (result) {
                if (result.data.status == 'success') {
                    $scope.memberId1 = result.data.data;
                    if (angular.isObject($scope.memberId1)) {
                        localStorage.setItem('ee',JSON.stringify({
                            cardNumber: $scope.cardNumber1,
                            cardId: $scope.memberId1.id,
                        }));
                        if (type) {
                            window.location.href = '/wcheck-card/index';
                        }
                        $scope.checkCardSelect($scope.memberId1.id);
                        $scope.cardNumber1 = '';
                    } else {
                        localStorage.setItem('ee',JSON.stringify({
                            cardNumber: $scope.cardNumber1,
                            cardId: $scope.memberId1
                        }));
                        if (type) {
                            window.location.href = '/wcheck-card/index';
                        }
                        $scope.checkCardSelect($scope.memberId1);
                        $scope.cardNumber1 = '';
                    }
                } else {
                    Swal.error(result.data.message);
                    $scope.cardNumber = '';
                }
                $scope.checkButton = false;
            });
        }

        return false;
    };
    $scope.enterSearch = function (e) {
        var keyCode = window.event ? e.keyCode : e.which;
        if (keyCode == 13){
            $scope.checkCardNumberMember('search');
        }
    }
    //获取全天的预约课程
    $scope.getAboutAllOneClassData = function (id) {
        $scope.getAboutId = id;
        console.log($scope.getAboutId)
        $http.get('/check-card/get-about-class-data?id='+ id +'&type=day').then(function (result) {
            if(result && result.data.data.length){
                $scope.printerOneAllCourse = result.data.data;
                $scope.aboutNoOneData = false;
            }else{
                $scope.printerOneAllCourse = result.data.data;
                $scope.aboutNoOneData = true;
            }
        });
    };
    // 会员卡团课爽约自动解冻
    $scope.getLeagueAutoNoFreeze = function (id){
        $scope.getLeagueId = id;
        $http.get("/new-league/card-automatic-thaw?memberId=" + id + "&isRequestMember=isMember").success(function (data){
        });
    };
    //获取全天的预约课程
    $scope.getAboutClassData = function (id) {
        $scope.getAboutClassId = id;
        $http.get('/check-card/get-about-class-data?id='+ id +'&type=').then(function (result) {
            if(result.data.length){
                $scope.allCourse = result.data;
                $scope.aboutNoOneData = false;
            }else{
                $scope.allCourse = result.data;
                $scope.aboutNoOneData = true;
            }
        });
    };
    // 设置搜索分页
    $scope.replaceMemberCard = function (urlPages){
        $scope.pageInitUrl = urlPages;
        $scope.getAllCardData();
    };
    $scope.init = function (id) {
        $scope.allCardId = id;
        $scope.pageInitUrl = '/user/member-card-info?MemberId='+ id + '&type=1';
    }
    // $scope.init(id);
    //获取会员卡
    $scope.getAllCardData = function (id) {
        $http.get($scope.pageInitUrl).then(function (result) {
            if(result.data.item.length){
                $scope.allCardData = result.data.item;
                $scope.memberCardNoDataShow = false;
            }else{
                $scope.allCardData = result.data.item;
                $scope.memberCardNoDataShow = true;
            }
            $scope.memberCardPages = result.data.pages
            angular.forEach($scope.allCardData, function (item) {
                if (localStorage.getItem('ee')) {
                    $scope.rr = localStorage.getItem('ee');
                }
                if ($scope.cardNumber == item.card_number || angular.fromJson($scope.rr).cardId == item.id) {
                    item.isBorder = true;
                } else {
                    item.isBorder = false;
                }
                var time = new Date();
               $scope.s = time.getTime();
                if (item.active_time) {
                    var days  = (item.invalid_time*1000)-(time.getTime());
                    item.dd = Math.floor(days / 86400000);
                }
            })
        });
    };
    //统计
    $scope.getStatisticsData = function (id) {
        $scope.statisticsDataId = id;
        $http.get('/summing-sum/get-member-entry-record-sum?id=' + id).then(function (result) {
            if(result.data.data.length){
                $scope.statisticsData = result.data.data;
            }else{
                $scope.statisticsData = result.data.data;
            }
        });
    };
    //场地预约
    $scope.siteReservationList = function (value) {
        $scope.cardNun = value;
        $http({
            method: 'get',
            url: '/site-management/get-yard-about-record?cardNum=' + value
        }).then(function (data) {
            if(data.data.data.length){
                $scope.siteReservationListDataBool = false
            } else {
                $scope.siteReservationListDataBool = true;
            }
            $scope.siteReservationListData = data.data.data;
            $scope.siteReservationListDataCardId = data.data.cardId;

        }, function (error) {
            Message.error("系统开了会小差,请刷新重试。。。");
        })
    };
    // 将时间戳转化成固定时间
    $scope.getMyDate = function (str) {
        str = parseInt(str);
        if (str != "" || str != null) {
            var oDate = new Date(str);
            var oYear = oDate.getFullYear();
            var oMonth = oDate.getMonth() + 1;
            oMonth = oMonth >= 10 ? oMonth : '0' + oMonth;
            var oDay = oDate.getDate();
            oDay = oDay >= 10 ? oDay : '0' + oDay;
            var theDate = oYear + "-" + oMonth + "-" + oDay;
            $scope.dateT = theDate;
        } else {
            theDate = "";
        }
        return theDate
    };
    $scope.getMyDateCh = function (str) {
        str = parseInt(str);
        if (str != "" || str != null) {
            var oDate = new Date(str);
            var oYear = oDate.getFullYear();
            var oMonth = oDate.getMonth() + 1;
            oMonth = oMonth >= 10 ? oMonth : '0' + oMonth;
            var oDay = oDate.getDate();
            oDay = oDay >= 10 ? oDay : '0' + oDay;
            var theDate = oYear + "年" + oMonth + "月" + oDay + "日";
        } else {
            theDate = "";
        }
        return theDate
    };
    // 进馆记录
    $scope.getEntryData = function (id) {
        $scope.entryDataId = id;
        $http.get('/check-card/get-member-entry-record-data?id=' + id).then(function (result) {
            $scope.entryDatas = result.data.data;
            if ($scope.entryDatas == undefined || $scope.entryDatas == '') {
                $scope.dataInfo = true;
            } else {
                $scope.dataInfo = false;
            }
            $scope.pages = result.data.pages;
        });
    };
    //请假弹框
    $scope.getTodayTimesTamp = function (){
        var timetemps = new Date();
        timetemps.setHours(0);
        timetemps.setMinutes(0);
        timetemps.setSeconds(0);
        timetemps.setMilliseconds(0);
        $scope.todaytimetemps = Date.parse(timetemps)/1000; //获取当前时间戳
    };
    // 请假开始日期插件的js
    $("#dataLeave1").datetimepicker({
        minView: "month",//设置只显示到月份
        format: 'yyyy-mm-dd',
        language: 'zh-CN',
        autoclose: true,
        startDate:new Date(),
        todayBtn: true//今日按钮
    }).on('changeDate',function (ev){
        $scope.getTodayTimesTamp();
        if($scope.leaveTypeChecked){
            if($(".leaveDateStartInput").val()){
                var leaveStart = $(".leaveDateStartInput").val();
                $scope.leaveStartTimesTamp = Date.parse(leaveStart)/1000;
                var date = new Date();
                var seperator1 = "-";
                var year = date.getFullYear();
                var month = (date.getMonth() + 1) < 10 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1;
                var strDate = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
                var rr = year + '-' + month + '-' + strDate
                var todayTimes = new Date(rr).getTime();
                var startTimes = Date.parse(leaveStart);
                if (todayTimes > startTimes) {
                    Message.warning('请选择今天之后的日期');
                    $scope.startLeaveDay = '';
                    $(".leaveDateStartInput").val('');
                    $(".leaveDateEndInput").val('')
                    return;
                }
                if($(".leaveDateEndInput").val()){
                    var leaveEnd = $(".leaveDateEndInput").val() + " " + "23:59:59";
                    $scope.leaveEndTimesTamp = Date.parse(leaveEnd)/1000;
                    if($scope.leaveStartTimesTamp > $scope.leaveEndTimesTamp){
                        Message.warning("开始日期不能大于结束日期");
                        $scope.leaveStartTimesTamp = '';
                        $scope.leaveEndTimesTamp   = '';
                        $(".leaveDateStartInput").val("");
                        $(".leaveDateEndInput").val("");
                    }
                    else{
                        $scope.mathAroundLeaveDate();
                    }
                }
            }
            else{
                Message.warning("请选择开始日期");
                $scope.leaveStartTimesTamp = '';
                $(".leaveAllDaysSpans").text('');
            }
        }
        else{
            Message.warning("请先选择请假类型");
            $(".leaveDateStartInput").val("");
            $(".leaveDateEndInput").val("");
            $(".leaveAllDaysSpans").text('');
        }
    });
    // 请假结束日期插件的js
    $("#dataLeaveEnd").datetimepicker({
        minView: "month",//设置只显示到月份
        format: 'yyyy-mm-dd',
        language: 'zh-CN',
        autoclose: true,
        todayBtn: true//今日按钮
    }).on('changeDate',function (ev){
        if($scope.leaveTypeChecked !=  ''){
            if($(".leaveDateEndInput").val() && $(".leaveDateStartInput").val()){
                var leaveEnd = $(".leaveDateEndInput").val() + " " + "23:59:59";
                $scope.leaveEndTimesTamp = Date.parse(leaveEnd)/1000;
                if($scope.leaveStartTimesTamp > $scope.leaveEndTimesTamp){
                    Message.warning("开始日期不能大于结束日期");
                    $scope.leaveStartTimesTamp = '';
                    $scope.leaveEndTimesTamp   = '';
                    $(".leaveDateStartInput").val("");
                    $(".leaveDateEndInput").val("");
                }
                else{
                    $scope.mathAroundLeaveDate();
                }
            }
            else if(!$(".leaveDateStartInput").val()){
                Message.warning("请先选择开始日期");
                $scope.leaveStartTimesTamp = '';
                $scope.leaveEndTimesTamp   = '';
                $(".leaveDateEndInput").val("");
            }
            else{
                Message.warning("请选择结束日期");
                $scope.leaveEndTimesTamp = '';
            }
        }
        else{
            Message.warning("请先选择请假类型");
            $(".leaveDateStartInput").val("");
            $(".leaveDateEndInput").val("");
        }
    });
    //点击请假按钮，传送数据
    $scope.leaveWork = function () {
        $('#dataLeave1').datetimepicker('update', new Date());
        $scope.memberLeaveCardId = $scope.cardId;
        $scope.leaveTypeChecked  = '';
        $scope.card_id           = '';
        $scope.startLeaveDay     = '';
        $scope.endLeaveDay       = '';
        $scope.endLeaveFlag      = false;
        $scope.leaveData1        = false;
        $scope.leaveData2        = false;
        $scope.card_id           = '';
        $scope.leaveMemberId     = parseInt($scope.memberId);
        $('#leaveCause').val('');
        $http.get("/user/check-card-details?MemberId=" + $scope.leaveMemberId+'&memberCardId='+$scope.cardId).then(function (result) {
            $scope.MemberData = result.data;
            if (Number($scope.memberData.mc_status) == 1 && Number($scope.memberData.nowLeaveStatus.status) != 1 && Number($scope.memberData.status) != 2 ) {
                $('#leaveWorkModal').modal('show');
                //会员卡失效时间
                $scope.invalidTime = parseInt($scope.MemberData.memberCard[0].invalid_time);
                //会员卡生效时间
                $scope.activeTime = parseInt($scope.MemberData.memberCard[0].active_time);
                var now = Math.ceil(new Date().getTime() / 1000);
                $scope.mathAllDays = function (){
                    var mathDay = Math.ceil(($scope.invalidTime - $scope.activeTime) / (60 * 60 * 24));
                    if(!isNaN(mathDay)){
                        return mathDay.toFixed(0);
                    }
                    else {
                        return 0;
                    }
                };
                $scope.allDays = $scope.mathAllDays();
                $scope.limitedDays = Math.ceil(($scope.invalidTime - now) / (60 * 60 * 24));

                //根据返回的数字对应不同的状态
                var len = $scope.MemberData.memberCard.length;
                for (var i = 0; i < len; i++) {
                    var memberState = parseInt($scope.MemberData.memberCard[i].status);
                    switch (memberState) {
                        case 1:
                            $scope.memberFlag = '正常';
                            break;
                        case 2:
                            $scope.memberFlag = '禁用';
                            break;
                        case 3:
                            $scope.memberFlag = '冻结';
                            break;
                        case 4:
                            $scope.memberFlag = '未激活';
                            break;
                    }
                }
            } else {
                Message.warning('此卡处于异常状态或请假状态，不能请假！');
            }
        });
        $scope.selectOneMemberCard();
    };

    //根据不同的时间算出天数
    $scope.getDateDays = function (start, end) {
        if (start && end && $scope.leaveTypeChecked == '2') {
            var startTimes = new Date(start + ' ' + '00:00:00').getTime();
            var endTimes = new Date(end + ' ' + '23:59:59').getTime();
            var daysTime = parseInt(endTimes) - parseInt(startTimes);
            var days = Math.round((endTimes - startTimes) / (24 * 60 * 60 * 1000));
            $scope.leaveDays123 = days;
        }
    };

    //根据请假开始时间获取请假到期时间
    $scope.startLeaveDate = function (starDate) {
        $scope.startTimeDa = starDate;
        $scope.getTodayTimesTamp();
        $scope.getDateDays($scope.startLeaveDay, $scope.endLeaveDay);
        $scope.startTime11Date = starDate;
        if ($scope.endLeaveDate111) {
            var endTimes = new Date($scope.endLeaveDate111).getTime();
            var startTimes = new Date($scope.startTime11Date).getTime();
            if (startTimes > endTimes) {
                Message.warning('您选择的请假时间选择有误请重新选择！');
                $scope.endLeaveDay = '';
                $scope.endLeaveDate111 = '';
                return;
            }
        }
        var starLeaveTime = new Date(starDate + ' ' + '00:00:00').getTime();
        $scope.startLeaveDate11 = parseInt(starLeaveTime);
        $scope.startLeaveDateTime = starDate + ' ' + '00:00:00';
        if ($scope.selectLeaveDays) {
            var endTime = starLeaveTime + $scope.selectLeaveDays * 24 * 60 * 60 * 1000 - 1000;
            $scope.endLeaveDay = $scope.getMyDate(endTime);
            $scope.endLeaveFlag = true;
        }
    };
    $scope.endLeaveDate = function (endDate) {
        $scope.getDateDays($scope.startLeaveDay, $scope.endLeaveDay);
        $scope.endLeaveDate111 = endDate;
        var endTimes = new Date($scope.endLeaveDate111).getTime();
        var startTimes = new Date($scope.startTimeDa).getTime();
        if (startTimes > endTimes) {
            Message.warning('您选择的请假时间选择有误请重新选择！');
            $scope.endLeaveDay = '';
            return;
        }
    };

    $scope.selectLeaveDaysOne = function (ind) {
        $scope.leaveIndex = ind;
        $scope.leave1 = ind;
        if (ind == '') {
            $scope.startLeaveDay = "";
            $scope.endLeaveDay = "";
            return;
        }
    };

    //根据不同的时间算出天数
    $scope.getDateDays = function(start,end){
        if(start != '' &&  end !='' && $scope.leaveTypeChecked =='2'){
            var startTimes = new Date(start + ' '+'00:00:00').getTime();
            var endTimes   = new Date(end + ' '+'23:59:59').getTime();
            var daysTime = parseInt(endTimes) - parseInt(startTimes);
            var days = Math.ceil(daysTime/(24*60*60*1000));
            $scope.leaveDays123 = days;
        }
    };

    //选择请假类型
    $scope.selectLeaveType = function(val){
        if(val == '1'){
            $scope.endLeaveFlag = true;
            $scope.leaveTypeCheckedA = '1';
        }else if (val == '2'){
            $scope.endLeaveFlag = false;
            $scope.leaveTypeCheckedA = '2';
            $scope.getDateDays($scope.startLeaveDay,$scope.endLeaveDay);
        }else if(val == '3'){
            $scope.endLeaveFlag = true;
            $scope.leaveTypeCheckedA = '1';
        }
    };
    $scope.selectOneMemberCard = function () {
        $scope.leave1 = "";
        $scope.LeaveDays = '';
        $scope.leaveTotalDays = '';
        $scope.leaveLeastDays = '';
        $scope.endLeaveFlag = false;
        $scope.startLeaveDay = '';
        $scope.endLeaveDay = '';
        $scope.selectLeaveDays = '';
        $scope.endLeaveDateTime = '';
        $scope.leaveTotalDays = '';
        $scope.LeaveDays = '';
        $scope.leaveData1 = false;
        $scope.studentLeaveType='';
        $scope.leaveTypeChecked = '';
        if ($scope.memberLeaveCardId) {
            $scope.morenFlag = true;
            $http.get('/user/get-leave-limit?memberCardId=' + $scope.memberLeaveCardId).then(function (response) {
                $scope.leaveStyle = response.data;
                if (response.data.invalid_time) {
                    $scope.memberCardEndTime = response.data.invalid_time;
                }
                if (!response.data.leave_type || response.data.leave_type == 1) {
                    $scope.studentLeaveType = response.data.leave_type;
                }
                if ($scope.leaveStyle.leave_days_times && !$scope.studentLeaveType) {
                    $scope.LeaveDays = response.data.leave_days_times;
                    $scope.leaveLimitStatus = 2;
                    $scope.leaveData1 = true;
                    $scope.leaveData2 = false;

                }
                if ($scope.leaveStyle.leave_least_days && $scope.leaveStyle.leave_total_days && !$scope.studentLeaveType) {
                    $scope.leaveLeastDays = parseInt(response.data.leave_least_days);
                    $scope.leaveTotalDays = parseInt(response.data.leave_total_days);
                    $scope.leaveLimitStatus = 1;
                    $scope.leaveData1 = true;
                    $scope.leaveData2 = true;
                }
                if ($scope.studentLeaveType == 1 && $scope.leaveStyle.student_leave_limit) {
                    $scope.LeaveDays = response.data.student_leave_limit;
                    $scope.leaveLimitStatus = 3;
                    $scope.leaveData2 = true;
                    $scope.leaveData1 = false;
                }
                if ($scope.studentLeaveType == 1 && $scope.leaveStyle.cardStudentLeaveType) {
                    $scope.LeaveDays = response.data.cardStudentLeaveType;
                    $scope.leaveLimitStatus = 3;
                    $scope.leaveData2 = true;
                    $scope.leaveData1 = false;
                }
                if ($scope.studentLeaveType == 1 && !$scope.leaveStyle.student_leave_limit && !$scope.leaveStyle.cardStudentLeaveType) {
                    Message.warning('请设置学生请假天数!');
                    return;
                }
            })
        } else {
            $scope.leaveData1 = false;
            $scope.leaveData2 = false;
        }

    };

    //请假结束时间变化
    $scope.endLeaveDate = function (endLeaveDay) {
        $scope.getDateDays($scope.startLeaveDay,$scope.endLeaveDay);
    };

    //实现请假功能
    //    会员卡状态：1、正常 2、冻结 3、过期 4、未激活
    $scope.submitLeave = function () {
        var leaveData = {
            leaveType    :$scope.leaveTypeChecked != undefined && $scope.leaveTypeChecked != '' ? $scope.leaveTypeChecked : null,
            leavePersonId: parseInt($scope.leaveMemberId),
            leaveReason: $('#leaveCause').val(),
            _csrf_backend: yii.getCsrfToken(),
            leaveStartTime: $scope.leaveStartTimesTamp,
            leaveEndTime: $scope.leaveEndTimesTamp,
            leaveTotalDays: $scope.leaveAllDays,
            leaveArrayIndex: $scope.leaveIndex != undefined && $scope.leaveIndex != '' ? $scope.leaveIndex : null,
            leaveLimitStatus: $scope.leaveLimitStatus,
            memberCardId: $scope.memberLeaveCardId
        };
        if ($scope.leaveTypeChecked == '' || $scope.leaveTypeChecked == null || $scope.leaveTypeChecked == undefined) {
            Message.warning('请选择请假类型');
            return;
        }

        if (!$scope.leave1 && (($scope.leaveData1 && $scope.leaveTypeChecked =='1') || $scope.leaveTypeChecked =='3')) {
            Message.warning('请选择请假天数');
            return;
        }

        if (leaveData.memberCardId == '' || leaveData.memberCardId == null || leaveData.memberCardId == undefined) {
            Message.warning('请选择您的会员卡');
            return;
        }
        if ($scope.leaveStartTimesTamp == '' || $scope.leaveStartTimesTamp == undefined || $scope.leaveStartTimesTamp == '') {
            Message.warning('请选择请假开始时间');
            return;
        }
        if ($scope.leaveEndTimesTamp == '' || $scope.leaveEndTimesTamp == undefined || $scope.leaveEndTimesTamp == '') {
            Message.warning('请选择请假结束时间');
            return;
        }
        $scope.leavePost = function (){
            $scope.laddaButton = true;
            $http({
                url: '/check-card/leave-record',
                method: 'POST',
                data: $.param(leaveData),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function (result) {
                if (result.data.status == "success") {
                    $scope.getAllCardData();
                    $('#leaveWorkModal').modal('hide');
                    Message.success('请假成功');
                    $scope.laddaButton = false;
                } else {
                    Message.warning(result.data.message);
                    $scope.laddaButton = false;
                }
            });
        };
        $scope.leavePost();
    };

    // 计算正常请假时长
    $scope.mathAroundLeaveDate = function (){
        $scope.leaveAllDays = (($scope.leaveEndTimesTamp - $scope.leaveStartTimesTamp)/24/60/60).toFixed(0);
        if(!isNaN($scope.leaveAllDays)){
            $(".leaveAllDaysSpans").text($scope.leaveAllDays);
        }
        else{
            $scope.leaveAllDays = 0;
        }
    };
    //获取私课课程
    $scope.getAllPrivateCourse = function (id) {
        $http.get('/private-teach/expire-time?memberId=' + id).then(function (response) {
            $scope.AllExpirePrivateCourse = response.data;
        });
    };
    $scope.dd = function (id) {
        localStorage.setItem('ee',JSON.stringify({
            cardNumber: $scope.cardNumber1,
            cardId: id
        }));
        window.location.href = '/wcheck-card/index';
        $scope.cardNumber1 = '';
    };
    /****** 打印机start *****/
    //打印单条
    //打印单条
    $scope.aboutPrintsField = function (printer) {
        $scope.aboutYardId = printer.id
        $scope.printerField = printer;
        $scope.newDate =$scope.getNowFormatDates()
        if(printer == undefined || !printer){
            Message.warning('没有预约的场地无法打印');
            return false;
        }
        $timeout(function () {
            $.loading.hide();
            var open = 1;
            if (open < 10) {
                var $prints = $('#field');
                var bodyHtml = $('body').html();
                var bdhtml = $prints.html();//获取当前页的html代码
                window.document.body.innerHTML = bdhtml;
                $scope.updateYardStatus();
                window.print();
                window.document.body.innerHTML = bodyHtml;
                // location.replace(location.href);
                location.reload()
            } else {
                window.print();
            }
        }, 100);
        // }
    }
    $scope.updateYardStatus = function () {
        $http.get('/check-card/update-about-yard-print?id=' + $scope.aboutYardId).then(function (result) {
        });
    };
    $scope.getNowFormatDates = function () {
        var date = new Date();
        var seperator1 = "-";
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var strDate = date.getDate();
        var hour = date.getHours();
        var minute = date.getMinutes();
        var second = date.getSeconds();
        if (month >= 1 && month <= 9) {
            month = "0" + month;
        }
        if (strDate >= 0 && strDate <= 9) {
            strDate = "0" + strDate;
        }
        var hour = date.getHours();
        if (hour >= 1 && hour <= 9) {
            hour = "0" + hour;
        }
        var minute = date.getMinutes();
        if (minute >= 1 && minute <= 9) {
            minute = "0" + minute;
        }
        var second = date.getSeconds();
        if (second >= 1 && second <= 9) {
            second = "0" + second;
        }
        var currentdate = year + seperator1 + month + seperator1 + strDate + " " + hour + ":" + minute;
        return currentdate;
    }
    //打印单条
    $scope.aboutPrints = function (item) {
        $scope.printer = item;
        $scope.printTicket();
        $scope.allDayCourse = '';
    };
    $scope.printTicket = function (item) {
        $.loading.show();
        $scope.allDayCourse = item;
        if(item == 'day'){
            if($scope.printerOneAllCourse == undefined || !$scope.printerOneAllCourse ){
                Message.warning('没有预约的课程无法打印');
                return false;
            }
            $scope.getPrintHtml();
        }else{
            if ($scope.printer == undefined || !$scope.printer) {
                Message.warning('没有预约的课程无法打印');
                return false;
            }
            $scope.aboutId = $scope.printer.id;
            $scope.getPrintHtml();
        }
    };
    $scope.updateAboutStatus = function (id,type) {
        $http.get('/check-card/update-about-print?id=' + id + '&type=' + type).then(function (result) {

        });
    };
    $scope.getPrintHtml = function () {
        $timeout(function () {
            $.loading.hide();
            if($scope.allDayCourse == 'day'){
                var open = 1;
                if (open < 10) {
                    var $prints = $('#printsOneDay');
                    var bodyHtml = $('body').html();
                    $scope.bdhtml = $prints.html();//获取当前页的html代码
                    window.document.body.innerHTML = $scope.bdhtml;
                    //直接修改一天的课程打印小票
                    $scope.updateAboutStatus($scope.memberCardId1,'day');
                    window.print();
                    window.document.body.innerHTML = bodyHtml;
                    location.replace(location.href);
                } else {
                    window.print();
                }
            }else{
                var open = 1;
                if (open < 10) {
                    var $prints = $('#prints');
                    var bodyHtml = $('body').html();
                    $scope.bdhtml = $prints.html();//获取当前页的html代码
                    window.document.body.innerHTML = $scope.bdhtml;
                    $scope.updateAboutStatus($scope.aboutId,'one');
                    window.print();
                    window.document.body.innerHTML = bodyHtml;
                    location.replace(location.href);
                } else {
                    window.print();
                }
            }
        }, 100);
    };
    //取消预约课程
    $scope.removeAboutClass = function (item) {
        Sweety.remove({
            url: "/check-card/cancel-about-class?id=" + item.id,
            http: $http,
            title: '确定要取消约课?',
            text: '取消约课后无法恢复',
            confirmButtonText: '确定',
            confirmButton: '取消约课',
            data: {
                action: 'unbind'
            }
        }, function () {
            $scope.getAboutClassData(item.member_card_id);
            $scope.getAboutAllOneClassData(item.member_card_id);
        }, function () {

        }, true, true);
    };
    $scope.allFun = function (cardId, memberId, card_number,card_number1, card_number3,type) {
        $scope.getAboutClassData(cardId);
        $scope.getLeagueAutoNoFreeze(memberId);
        $scope.getEntryData(cardId);
        // $scope.getAboutAllOneClassData(cardId);
        if (!type) {
            $scope.init(memberId);
            $scope.getAllCardData(memberId);
        }
        $scope.siteReservationList(card_number3);
        $scope.getStatisticsData(cardId);
        localStorage.setItem('ee',JSON.stringify({
            cardNumber: card_number ? card_number:card_number1,
            cardId: cardId,
            member: memberId
        }));
    };
    $scope.cardClick = function (item, index) {
        $scope.clickNumFlag = 1;
        $scope.cardNumber = item.card_number;
        angular.forEach($scope.allCardData,function (item, ind) {
            if (index == ind) {
                item.isBorder = true;
            } else {
                item.isBorder = false;
            }
        });
        localStorage.setItem('ee',JSON.stringify({
            cardNumber: $scope.cardNumber ? $scope.cardNumber:$scope.cardNumber1,
            cardId: item.id
        }));
        $scope.checkCardSelect(item.id,'card');
    };
    // 选择卡
    $scope.checkCardSelect = function (cardId, type) {
        $.loading.show();
        if (cardId) {
            $http.get('/check-card/get-check-card-data?id=' + cardId).then(function (result) {
                // debugger;
                $scope.memberData = result.data.data;
                $scope.memberId    = result.data.data.id;
                $scope.$emit('tt1');
                $scope.memberCardId1    = result.data.data.memberCard_id;
                $scope.leaveType  = result.data.data.leave_type;
                localStorage.setItem('member',JSON.stringify({
                    member: $scope.memberId
                }));
                $scope.allFun($scope.memberCardId1, $scope.memberId,$scope.cardNumber1,$scope.cardNumber,$scope.memberData.card_number,type);
                angular.forEach($scope.allCardData, function (item) {
                    if (cardId == item.id) {
                        item.isBorder = true;
                    } else {
                        item.isBorder = false;
                    }
                })
                localStorage.setItem('ee',JSON.stringify({
                    cardNumber: $scope.cardNumber1,
                    cardId: cardId
                }));
                if(result.data.data.absent_times){
                    $scope.absentTimes = result.data.data.absent_times;
                }
                else{
                    $scope.absentTimes = 0;
                }
                $rootScope.backDetailId = $scope.memberData.memberCard_id;

                $scope.memberData.consumption_times = parseInt($scope.memberData.consumption_times);
                $scope.memberData.total_times = parseInt($scope.memberData.total_times);

                // $scope.getAllPrivateCourse($scope.memberData.id);
                //十五天的时间戳
                var fifteenTime = parseInt(15 * 24 * 60 * 60);
                //当前时间戳
                var now = new Date().getTime();
                $scope.currentTime = Math.ceil(now / 1000);
                //柜子到期时间
                if ($scope.memberData.cabinet != null) {
                    $scope.cabinetExpire = parseInt($scope.memberData.cabinet.memberCabinet.end_rent);
                    //柜子到期前第十五天
                    $scope.cabinetFifteenDate = $scope.cabinetExpire - fifteenTime;
                    //柜子距离到期时间
                    $scope.cabinetExpireDay = Math.ceil(($scope.cabinetExpire - $scope.currentTime) / 86400);
                    $scope.cabinetExpireDate = $scope.getMyDate($scope.cabinetExpire * 1000);
                    $scope.cabinetExpireDateCh = $scope.getMyDateCh($scope.cabinetExpire * 1000);
                }
                $scope.getMyDate($scope.memberData.invalid_time);
                localStorage.setItem('serverData', result.data.data.serverData);
                $scope.expireDate = $scope.getMyDate($scope.memberData.invalid_time * 1000);
                $scope.expireDateCh = $scope.getMyDateCh($scope.memberData.invalid_time * 1000);
                $scope.intervalDay = Math.round($scope.memberData.fewDays);

                //会员卡到期前的第十五天
                $scope.carFifteenDate = $scope.memberData.invalid_time - fifteenTime;
                //失效的时间
                $scope.disabledDate = parseInt($scope.memberData.invalid_time);
                //距离失效的天数
                var intervalExpire = ($scope.memberData.invalid_time - $scope.currentTime) / 86400;
                var b = (intervalExpire + '').split(".");
                var x = b[0];
                var y = b[1];

                $scope.intervalExpire = parseInt(x);
                $scope.intervalExpireHours = Math.round(('0.' + y) * 24);
                //取消预加载
                $scope.checkButton = false;
                $('#selectCardModal').modal('hide');
                $.loading.hide();
            })
        } else {
            Message.warning('请选择您的会员卡！');
            $.loading.hide();
            return;
        }
    };
    console.log(angular.fromJson($scope.rr))
    if (angular.fromJson($scope.rr)) {
        if (!angular.fromJson($scope.rr).cardId) {
            $scope.checkCardNumberMember();
            $scope.aboutNoOneData = true;
            $scope.siteReservationListDataBool = true;
            $scope.dataInfo = true;
            $scope.noClick = true;
        }
        $scope.checkCardSelect(angular.fromJson($scope.rr).cardId);
    }
    $scope.field = function () {
        window.location.href = '/wcheck-card/field?m='+ $scope.memberId + '&c=' + $scope.memberCardId1
    }
    $scope.class = function () {
        window.location.href = '/class-reservation/index?m='+ $scope.memberId + '&c=' + $scope.memberCardId1
    };
    // 进馆
    $scope.clickNumFlag = 1;
    $scope.makeSure = function (id) {
        if ($scope.clickNumFlag == 1) {
            $scope.clickNumFlag = $scope.clickNumFlag + 1;
            if ($scope.timeMethod) {
                var path = 'id=' + id + '&timeMethod=' + $scope.timeMethod;
            } else {
                path = 'id=' + id
            }
            $http.get('/check-card/make-sure-member-card?' + path).then(function (result) {
                if (result.data.status == 'success') {
                    Swal.success(result.data.message, '进馆成功');
                    $scope.getAllCardData();
                    $scope.checkCardSelect(id, 'card');
                } else {
                    Message.warning(result.data.message)
                    return;
                }
            });
        }
    };
    $scope.getMembersData = function (id) {
        $scope.cardId = angular.fromJson($scope.rr).cardId;
        $http.get('/check-card/get-check-card-data?id=' + $scope.cardId).then(function (result) {
            $scope.memberId    = result.data.data.id;
            $scope.memberCardId1    = result.data.data.memberCard_id;
            $scope.leaveType  = result.data.data.leave_type;
            $scope.getLeagueAutoNoFreeze($scope.getLeagueId);
            $scope.memberData  = result.data.data;
            $scope.siteReservationList($scope.cardNun);
            if(result.data.data.absent_times != null){
                $scope.absentTimes = result.data.data.absent_times;
            }
            else{
                $scope.absentTimes = 0;
            }
            $rootScope.backDetailId = $scope.memberData.memberCard_id;

            $scope.memberData.consumption_times = parseInt($scope.memberData.consumption_times);
            $scope.memberData.total_times = parseInt($scope.memberData.total_times);

            $scope.getAllPrivateCourse($scope.memberData.id);
            //十五天的时间戳
            var fifteenTime = parseInt(15 * 24 * 60 * 60);
            //当前时间戳
            var now = new Date().getTime();
            $scope.currentTime = Math.ceil(now / 1000);
            //柜子到期时间
            if ($scope.memberData.cabinet != null) {
                $scope.cabinetExpire = parseInt($scope.memberData.cabinet.memberCabinet.end_rent);
                //柜子到期前第十五天
                $scope.cabinetFifteenDate = $scope.cabinetExpire - fifteenTime;
                //柜子距离到期时间
                $scope.cabinetExpireDay = Math.ceil(($scope.cabinetExpire - $scope.currentTime) / 86400);
                $scope.cabinetExpireDate = $scope.getMyDate($scope.cabinetExpire * 1000);
                $scope.cabinetExpireDateCh = $scope.getMyDateCh($scope.cabinetExpire * 1000);
            }
            $scope.getMyDate($scope.memberData.invalid_time);
            localStorage.setItem('serverData', result.data.data.serverData);
            $scope.expireDate = $scope.getMyDate($scope.memberData.invalid_time * 1000);
            $scope.expireDateCh = $scope.getMyDateCh($scope.memberData.invalid_time * 1000);
            $scope.intervalDay = Math.round($scope.memberData.fewDays);

            //会员卡到期前的第十五天
            $scope.carFifteenDate = $scope.memberData.invalid_time - fifteenTime;
            //失效的时间
            $scope.disabledDate = parseInt($scope.memberData.invalid_time);
            //距离失效的天数
            var intervalExpire = ($scope.memberData.invalid_time - $scope.currentTime) / 86400;
            var b = (intervalExpire + '').split(".");
            var x = b[0];
            var y = b[1];

            $scope.intervalExpire = parseInt(x);
            $scope.intervalExpireHours = Math.round(('0.' + y) * 24);
            localStorage.setItem('member', JSON.stringify({
                memberDataid: $scope.memberData.id, memberCard_id: $scope.memberData.memberCard_id,
                identify: $scope.memberData.identify, venueId: $scope.memberData.venue_id,
                invalid_time: $scope.memberData.invalid_time
            }));
            //取消预加载
            $.loading.hide();
        });
    };
    //私教列表
    $scope.chargeClassinfo = function () {
        $http.get($scope.pageChargeUrl).then(function (result) {
            if(result.data.charge && result.data.charge.length) {
                $scope.chargeNotData = false;
            }else{
                $scope.chargeNotData = true;
            }
            $scope.privatePages = result.data.pages;
            $scope.chargeList = result.data.charge;
        });
    };
    // 设置搜索分页
    $scope.chargeClass = function (urlPages){
        $scope.pageChargeUrl = urlPages;
        $scope.chargeClassinfo();
    };
    $scope.initCharge = function () {
        $scope.pageChargeUrl = '/user/charge-class-info?MemberId='+ $scope.memberId
    }
    //删除私教课程
    $scope.delChargeClass = function (id) {
        Sweety.remove({
            url: "/user/course-package-del?memberId=" + id,
            http: $http,
            title: '确定要删除吗?',
            text: '会员删除后所有信息无法恢复',
            confirmButtonText: '确定',
            data: {
                action: 'unbind'
            }
        }, function () {
            $scope.chargeClassinfo();
        });
    };

    //激活请假
    $scope.automaticLeave = function () {
        $http.get('/member/automatic-leave?memberId='+ $scope.memberId).then(function (result) {
            $scope.$emit('updateLeave');
        });
    };
    //请假列表
    $scope.$on('updateLeave', function () {
        $http.get($scope.pageLeaveUrl).then(function (result) {
            if(result.data.vacate && result.data.vacate.length) {
                $scope.leaveNotData = false;
            }else{
                $scope.leaveNotData = true;
            }
            $scope.pageLearve = result.data.pages;
            $scope.leaveList = result.data.vacate;
        });
    });
    // 设置搜索分页
    $scope.replaceLeavePage = function (urlPages){
        $scope.pageLeaveUrl = urlPages;
        $scope.$emit('updateLeave');
    };
    $scope.initLeave = function () {
        $scope.pageLeaveUrl = '/user/leave-record-info?MemberId='+ $scope.memberId
    }
    /*****点击消除请假*****/
    $scope.removeLeave = function (id, status) {
        if (status == 1) {
            Sweety.remove({
                url: "/check-card/del-leave-record?id=" + id,
                http: $http,
                title: '确定要销假吗?',
                text: '销假后信息无法恢复',
                confirmButtonText: '确定',
                confirmButton: '销假',
                data: {
                    action: 'unbind'
                }
            }, function () {
                $scope.$emit('updateLeave');
            }, function () {

            }, true, true);
        } else {
            return;
        }

    };
    //团课
    $scope.groupClassInfo = function () {
        $http.get($scope.pageGroupUrl).then(function (result)
        {
            if(result.data.group && result.data.group.length) {
                $scope.groupNotData = false;
            } else {
                $scope.groupNotData = true;
            }
            $scope.pageGroup = result.data.pages;
            $scope.groupList = result.data.group;
        });
    };
    // 设置搜索分页
    $scope.replaceGroupPage = function (urlPages){
        $scope.pageGroupUrl = urlPages;
        $scope.groupClassInfo();
    };
    $scope.initGroup = function () {
        $scope.pageGroupUrl = '/user/group-class-info?MemberId='+ $scope.memberId
    }

    //场地/
    $scope.yardrecordClassinfo = function () {
        $http.get($scope.pageYardUrl).then(function (result) {
            if(result.data.data && result.data.data.length) {
                $scope.recordNotData = false;
            }else{
                $scope.recordNotData = true;
            }
            $scope.pageRecord = result.data.pages;
            $scope.recordList = result.data.data;
        });
    };
    //取消预约场地
    $scope.cancelReservationYard = function (info) {
        if (info.about_start * 1000 < Date.parse(new Date())) {
            Message.warning('场地预约时间已开始不能取消预约');
            return;
        }
        swal({
            title: "确定取消预约？",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm){
            if (isConfirm) {
                swal.close();
                $http.get('/site-management/cancel-yard-about-class?id=' + info.id).then(function (result) {
                    if(result.data.status == 'success') {
                        $scope.yardrecordClassinfo();
                        Message.success(result.data.message);
                        location.reload()
                    }else {
                        Message.warning(result.data.message);
                    }
                })
            } else {
                swal.close();
            }
        });

    }
    // 设置搜索分页
    $scope.replacementPages = function (urlPages){
        $scope.pageYardUrl = urlPages;
        $scope.yardrecordClassinfo();
    };
    $scope.initYard = function () {
        $scope.pageYardUrl = '/member/get-member-about-yard-record?memberId='+ $scope.memberId
    }
    /******获取柜子表信息*******/
    $scope.getCabinetData = function () {
        $http.get($scope.pageCabinetUrl).then(function (response) {
            if (response.data.data.length) {
                $scope.cabinetNoDataShow = false;
            } else {
                $scope.cabinetNoDataShow = true;
            }
            $scope.cabinets = response.data.data;
            $scope.cabinetPages = response.data.page;
        });
    };
    // 设置搜索分页
    $scope.memberConsumList = function (urlPages){
        $scope.pageCabinetUrl = urlPages;
        $scope.getCabinetData();
    };
    $scope.initCabinet = function () {
        $scope.pageCabinetUrl = '/cabinet/member-consum-list?cabinetId=&type=&memberId='+$scope.memberId
    }
    //消费记录
    $scope.getHistoryData = function () {
        $http.get($scope.pageHistoryUrl).success(function (response) {
            if (!response.expense) {
                $scope.payNoDataShow = true;
            } else {
                $scope.payNoDataShow = false;
            }
            $scope.expenses = response.expense;
            $scope.payPages = response.pages;
        });
    };
    // 设置搜索分页
    $scope.replacePayPage = function (urlPages){
        $scope.pageHistoryUrl = urlPages;
        $scope.getHistoryData();
    };
    $scope.initHistory = function () {
        $scope.pageHistoryUrl = '/user/consumption-info?memberId=' + $scope.memberId
    }

    /******获取进场表信息*******/
    // 清空到场离场记录
    $scope.selectState = '';
    $scope.initBackDateTimeInfo = function (){
        $("#backDateTimeInfo").val("");
        $scope.entryTime = '';
        $scope.pageEntrysUrl = "/member/entry-record-info?MemberId=" + $scope.memberId + '&entryTime=';
        $scope.selectState = '';
        $scope.getEntryRecordData();
    };
    $scope.getEntryRecordData = function () {
        $http.get($scope.pageEntrysUrl).success(function (response) {
            if (!response.entry.length) {
                $scope.entryNoDataShow = true;
            } else {
                $scope.entryNoDataShow = false;
            }
            $scope.entrys     = response.entry;
            $scope.count      = response.count;
            $scope.entryPages = response.pages;
        });
    };
    // 设置搜索分页
    $scope.replaceEntryPages = function (urlPages){
        if (!$scope.entryTime) {
            $scope.entryTime = '';
        }
        $scope.pageEntrysUrl = urlPages;
        $scope.getEntryRecordData();
    };
    $scope.initEntrys = function () {
        if (!$scope.entryTime) {
            $scope.entryTime = '';
        }
        $scope.pageEntrysUrl = "/member/entry-record-info?MemberId=" + $scope.memberId + '&entryTime=' + $scope.entryTime
    }
    $scope.searchEntry = function () {
        $scope.pageEntrysUrl = "/member/entry-record-info?MemberId=" + $scope.memberId + '&entryTime=' + $scope.entryTime;
        $scope.getEntryRecordData();
    }
    /******获取赠品表信息*******/
    $scope.getGiftRecordData = function () {
        $http.get($scope.pageGiftUrl).success(function (response) {
            if (!response.gift.length) {
                $scope.giftNoDataShow = true;
            } else {
                $scope.giftNoDataShow = false;
            }
            $scope.giftList = response.gift;
            $scope.giftPages = response.pages;
        });
    };
    // 设置搜索分页
    $scope.replaceGiftPage = function (urlPages){
        $scope.pageGiftUrl = urlPages;
        $scope.getGiftRecordData();
    };
    $scope.initGift = function () {
        $scope.pageGiftUrl = '/user/gift-record-info?memberId=' + $scope.memberId;
    }
    //获取行为记录
    $scope.initBehavior = function () {
        $scope.behaviorRecordUrl = '/user/information-records?memberId=' + $scope.memberId;
    }
    $scope.getBehaviorRecord = function () {
        $http.get($scope.behaviorRecordUrl).then(function (response) {
            if (response.data.data.length) {
                $scope.behaviorRecordFlag = false;
            } else {
                $scope.behaviorRecordFlag = true;
            }
            $scope.behaviorRecordLists = response.data.data;
            $scope.behaviorRecordPages = response.data.page;
        });
    };
    // 获取潜在会员送人卡信息记录
    $scope.initSendCard = function () {
        $scope.sendCardUrl = "/user/get-member-send-record?memberId=" +  $scope.memberId;
    }
    $scope.getMemberSendCardRecord = function () {
        $http.get($scope.sendCardUrl).success(function (data) {
            $scope.memberSendCardList = data.data;
            if (!$scope.memberSendCardList.length) {
                $scope.payNoSendCardRecordDataShow = true; //暂无数据图像显示
            }
            else {
                $scope.payNoSendCardRecordDataShow = false; //暂无数据图像关闭
            }
        });
    };
    // 获取私课延期记录的方法
    $scope.getDelayPrivateRecord = function (){
        $http.get("/member/extension-record-info?memberId=" + $scope.memberId).success(function (data){
            if(data.extension.length){
                $scope.delayPrivateRecordList = data.extension;
                $scope.priDelayNoDataShow = false;
            }else{
                $scope.delayPrivateRecordList = data.extension;
                $scope.priDelayNoDataShow = true;
            }

        });
    };
    // 获取赠送天数记录
    $scope.getGiftDaysInfoRecond = function (){
        $http.get("/member/give-day-info?memberId=" + $scope.id).success(function (data){
            if(data.data != '' && data.data != null && data.data != [] && data.data != undefined){
                $scope.giftDaysInfoRecondData = data.data;
                $scope.giftNoDataInfoHaShow   = false;
            }
            else{
                $scope.giftDaysInfoRecondData = data.data;
                $scope.giftNoDataInfoHaShow   = true;
            }
        });
    };
    // 获取定金信息
    $scope.getDepositAllMoney = function() {
        if(!$scope.depositSelect) {
            $scope.depositSelect = '';
        }
        $.loading.show();
        $http.get('/member/member-deposit-list?memberId=' + $scope.memberId + '&type='+$scope.depositSelect).then(function (data) {
            if(!data.data.deposit.length) {
                $scope.depositNoDataShow = true;
                $scope.getDepositInfoData = [];
            }else {
                $scope.depositAllMoney = data.data.allPrice;
                $scope.depositNoDataShow = false;
                $scope.getDepositInfoData = data.data.deposit;
            }
            $.loading.hide();
        })
    };
    //订金的信息记录
    $scope.depositSelectChange = function () {
        $scope.getDepositAllMoney();

    };
    //获取会籍变更记录
    $scope.initSellChangeCard = function () {
        $scope.sellChangeUrl = '/member/consultant-change?memberId=' + $scope.memberId;
    }
    $scope.getSellChangeRecords = function () {
        $.loading.show();
        $http.get($scope.sellChangeUrl).then(function (response) {
            if(!response.data.data.length) {
                $scope.consultantChangeRecordNoData = true;
            }else {
                $scope.consultantChangeRecordNoData = false;
            }
            $scope.consultantChangeRecord = response.data.data;
            $scope.consultantChangePage = response.data.page;
            $.loading.hide();
        })
    };
    //会籍变更记录的分页
    $scope.consultantPages = function (urlPage) {
        $scope.sellChangeUrl = urlPage;
        $scope.initSellChangeCard();
        $scope.getSellChangeRecords();
    };
    //转卡记录获取
    $scope.turnCardRecord = function () {
        $http.get('/member/turn-card-info?memberId=' + $scope.memberId).then(function (response) {
            if(!response.data.data.length){
                $scope.noTransferData = true;
                $scope.turnCardRecordList = response.data.data;
            }else{
                $scope.noTransferData = false;
                $scope.turnCardRecordList = response.data.data;
            }
        })
    };

    //获取私教变更记录
    $scope.initPrivateChange = function () {
        $scope.privateChangeUrl = '/member/personal-change?memberId=' + $scope.memberId;
    }
    $scope.privateChangeRecord = function () {
        $.loading.show();
        $http.get($scope.privateChangeUrl).then(function (response) {
            if(!response.data.data.length) {
                $scope.privateChangeRecordNoData = true;
            }else {
                $scope.privateChangeRecordNoData = false;
            }
            $scope.privateTeachChangeRecord = response.data.data;
            $scope.privateChangePage = response.data.page;
            $.loading.hide();
        })
    };
    //私教变更记录分页
    $scope.privateChangePages = function (urlPage) {
        $scope.privateChangeUrl = urlPage;
        $scope.initPrivateChange();
        $scope.privateChangeRecord();
    };
    //IC卡绑定记录
    $scope.getIcCardInfo = function(){
        $.loading.show();
        $http.get('/member/ic-bind-records?memberId=' + $scope.memberId).then(function (response) {
            if(!response.data.data.length) {
                $scope.icCardNoData = true;
            }else {
                $scope.icCardNoData = false;
            }
            $scope.icCardListInfo= response.data.data;
            $scope.icCardPage = response.data.page;
            $.loading.hide();
        })
    };
    $scope.SelectMessage = function (value) {
        // 私课延期的记录
        if(value == '1'){
            $scope.initGift();
            $scope.getGiftRecordData();
        } else if (value == '2') {
            $scope.initBehavior();
            $scope.getBehaviorRecord();
        } else if (value == '3') {
            $scope.initSendCard();
            $scope.getMemberSendCardRecord();
        } else if (value == '4') {
            $scope.getDelayPrivateRecord();
        } else if (value == '5') {
            $scope.getGiftDaysInfoRecond();
        } else if (value == '6') {
            $scope.getDepositAllMoney();
        } else if (value == '7') {
            $scope.initSellChangeCard();
            $scope.getSellChangeRecords();
        } else if (value == '8') {
            $scope.turnCardRecord();
        } else if (value == '9') {
            $scope.initPrivateChange();
            $scope.privateChangeRecord();
        } else if (value == '10') {
            $scope.getIcCardInfo();
        }
    };
    $scope.$on('tt1', function () {
        $scope.initEntrys();
        $scope.getEntryRecordData();
        $scope.initHistory();
        $scope.getHistoryData();
        $scope.initCabinet();
        $scope.getCabinetData();
        $scope.initYard();
        $scope.yardrecordClassinfo();
        $scope.initCharge();
        $scope.chargeClassinfo();
        $scope.automaticLeave();
        $scope.initLeave();
        $scope.initGroup();
        $scope.groupClassInfo();
    })
    $timeout(function () {
        $('.group-ul').height($(window).height()-145 + 'px');
        $('.detialS').height($(window).height()-173 + 'px');
        $('.pp').height($(window).height()-173 + 'px');
        $('.vv').height($(window).height()-173 + 'px');
        $('.nn').height($(window).height()-207 + 'px');
        $('.nn').css('overflow-y', 'auto');
    },300)
});
