var app = angular.module('App').controller('CabinetDataCtrl', function($scope, $http, $timeout, $location, $rootScope, $interval) {
    $scope.str = decodeURI(location.search);
    $scope.str1 = $scope.str.split('?');
    $scope.str2 = $scope.str1[1].split('&');
    $scope.str3 = $scope.str2[0].split('=');
    $scope.str4 = $scope.str2[1].split('=');
    $timeout(function () {
        $('.group-ul').height($(window).height()-145 + 'px');
        $('.detialS').height($(window).height()-173 + 'px');
        $('.pp').height($(window).height()-173 + 'px');
        $('.vv').height($(window).height()-173 + 'px');
        $('.nn').height($(window).height()-207 + 'px');
        $('.nn').css('overflow-y', 'auto');
    },300)
    $scope.initPath = function() {
        $scope.searchParams = $scope.search();
        $scope.pageInitUrl = '/cabinet/home-data?' + $.param($scope.searchParams);
    };
    /**点击区域，出现柜子列表***/
    $scope.searchClass = function(status) {
        if(status){
            window.location.href = '/wcabinet/cabinet-datal?i=' + $scope.str3[1] + '&n='+ $scope.str4[1];
        } 
        $scope.initPath();
        $scope.getDate(status);
        if($scope.nowPages) {
            $scope.pageInitUrl = '/cabinet/home-data?' + $.param($scope.searchParams) + '&page=' + $scope.nowPages + '&per-page=8';
        }
    };
    /**搜索方法（搜索栏）***/
    $scope.searchCabinet = function() {
        $scope.initPath();
        $scope.getDate();
    };
    /******Enter键搜索*******/
    $scope.enterSearchs = function(e) {
        var keyCode = window.event ? e.keyCode : e.which;
        if(keyCode == 13) {
            $scope.searchCabinet();
        }
    };
    //  分页数据信息
    $scope.getDate = function() {
        $.loading.show();
        $http.get($scope.pageInitUrl + '&pageSize=8').then(function(result) {
            $scope.cabinetDetailPage = result.data.now.toString();
            if(result.data.data.length != 0) {
                $scope.allCabinetLists = result.data.data;
                $scope.pages = result.data.pages;
                $scope.nowPages = result.data.now;
                $scope.dataInfo = false;
                $scope.searchData = false;
            } else {
                $scope.allCabinetLists = result.data.data;
                $scope.pages = result.data.pages;
                if($scope.searchParams != null) {
                    $scope.searchData = true;
                    $scope.dataInfo = false;
                } else {
                    $scope.dataInfo = true;
                }
            }
            $scope.cabinetCurrentTime = new Date().getTime();
            $scope.statusList = status;
            $.loading.hide();
        })
    };
    /****分页***/
    $scope.replacementPages = function(urlPages) {
        $scope.pageInitUrl = urlPages;
        $scope.getDate();
    };
    /**主界面(字段)搜索**/
    $scope.changeSort = function(attr, sort) {
        $scope.sortType = attr;
        $scope.switchSort(sort);
        $scope.searchClass();
    };

    $scope.switchSort = function(sort) {
        if(!sort) {
            sort = 'DES';
        } else if(sort == 'DES') {
            sort = 'ASC';
        } else {
            sort = 'DES'
        }
        $scope.sort = sort;
    };
    /**页面搜索（搜索栏）***/
    $scope.search = function() {
        return {
            typeId: $scope.str3[1] ? $scope.str3[1] : null,
            cabinetNum: $scope.cabinetNum ? $scope.cabinetNum : null,
            cabinetModel: $scope.cabinetModel ? $scope.cabinetModel : null,
            cabinetType: $scope.cabinetType ? $scope.cabinetType : null,
            customerName: $scope.customerName ? $scope.customerName : null,
            cabinetEndRent: $scope.cabinetEndRent ? $scope.cabinetEndRent : null,
            sortType: $scope.sortType ? $scope.sortType : null,
            sortName: $scope.sort ? $scope.sort : null,
            keyword: $scope.keyword ? $scope.keyword : null
        }
    };
    function isRepeat(jsonMonth){
        var filter = {};
        for(var i in jsonMonth) {
            if (filter[jsonMonth[i]]) {
                return true;
            }
            filter[jsonMonth[i]] = true;
        }
        return false;
    }
    //获取所有的柜子
    $scope.allCabinetTypeData = function() {
        $.loading.show();
        $http.get('/cabinet/get-cabinet-list?venueId=' + $scope.venueList).then(function(result) {
            $scope.allCabinet = result.data;
            $.loading.hide();
        })
    }
    //新增柜子
    $scope.isAdd = false;
    $scope.isThrow = false;
    $scope.isRenew = false;
    $scope.isBindUser = false;
    $scope.addCabinetModal = function () {
        $scope.isAdd = true;
    }
    //计算买柜子自然月的公共方法
    //dtstr:选择或当前日期，n表示几个月后
    $scope.countRentMonth = function (timeString, monthNum) {
        var timeSplit = timeString.split("-");
        var yy = parseInt(timeSplit[0]);
        var mm = parseInt(timeSplit[1]) - 1;
        var dd = parseInt(timeSplit[2]);
        var dt = new Date(yy, mm, dd);
        dt.setMonth(dt.getMonth() + monthNum);
        if ((dt.getFullYear() * 12 + dt.getMonth()) > (yy * 12 + mm + monthNum)) {
            dt = new Date(dt.getFullYear(), dt.getMonth(), 0);
        }
        var year = dt.getFullYear();
        var month = dt.getMonth() + 1;
        month = month <= 9 ? '0' + month : month;
        var days = dt.getDate();
        days = days <= 9 ? '0' + days : days;
        return year + "-" + month + "-" + days;
    };
    //时间戳转化为字符串
    $scope.fmtDate = function (obj) {
        var date =  new Date(obj);
        var y = 1900+date.getYear();
        var m = "0"+(date.getMonth()+1);
        var d = "0"+date.getDate();
        return y+"-"+m.substring(m.length-2,m.length)+"-"+d.substring(d.length-2,d.length);
    };
    $scope.getEndDate = function (start, add, give, type) {
        if(!add) {
            add = 0;
            $scope.cabinetEnd = start;
        }
        if(!give) {
            give = 0;
            $scope.cabinetreletEndDate = start;
        }
        if (type === 'd') {
            var month1 = parseInt(add);
            var timeString1 = $scope.getMyDate(start);
            var day = parseInt(give)*24*3600*1000;
            var countTime = $scope.countRentMonth(timeString1,month1);
            var date = Date.parse(new Date(countTime)) + parseInt(day);
            $scope.cabinetreletEndDate = $scope.fmtDate(date);
            $scope.cabinetEnd = $scope.fmtDate(date);
        }else if(type === 'm') {
            var month2 = parseInt(add) + parseInt(give);
            var timeString2 = $scope.getMyDate(start);
            $scope.cabinetreletEndDate = $scope.countRentMonth(timeString2,month2);
            $scope.cabinetEnd = $scope.countRentMonth(timeString2,month2);
        }else {
            var month3 = parseInt(add) + parseInt(give);
            var timeString3 = $scope.getMyDate(start);
            $scope.cabinetreletEndDate = $scope.countRentMonth(timeString3,month3);
            $scope.cabinetEnd = $scope.countRentMonth(timeString3,month3);
        }
    };
    //声明全局变量柜子的数据
    var reCabinetData;
    //声明全局变量续柜赠送月数
    var reGiveMonth;
    //声明全局变量续柜金额
    var reMuchMoney;
    //声明全局变量防止折扣链式反应
    var disContainer;
    $scope.renewCabinet = function(cabinetDetail) {
        $scope.isRenew = true;
        $scope.renewCabinetCompleteFlag = false;
        $scope.reletPrice = 0;
        $scope.reletMonth = '';
        $scope.giveReletMonthNum = 0;
        $scope.giveReletMonthNum1 = 0;
        $scope.cabinetDetail = cabinetDetail;
        /*新增*/
        //初始化折扣
        $scope.redisplay = 0;
        $scope.reDis = '1';
        //获取续租柜子数据
        reCabinetData = cabinetDetail;
        //初始化折扣
        $scope.reDis = '';
        $scope.cabinetreletEndDate = $scope.getMyDate($scope.cabinetDetail.end_rent * 1000);
        $http.get('/user/member-card?memberId=' + $scope.cabinetDetail.member_id).then(function(response) {
            $scope.memberCardInvalidTime = response.data.invalid_time;
        });
        $('#boundCabinet').modal('hide');
    };
    //当月的输入框变化时获取柜子到期时间
    $scope.reletMonthChange = function(reletMonth) {
        //初始化折扣
        $scope.reDis = '1';
        if(reletMonth == null || reletMonth == '' || reletMonth == 0){
            //初始化赠送月数
            $scope.giveReletMonthNum = 0;
            //初始化续柜初始到期时间
            $scope.cabinetreletEndDate = $scope.getMyDate($scope.cabinetDetail.end_rent * 1000);
        }else{
            //实时计算获取续柜到期日期和赠送月数
            if($scope.reletMonth != undefined && $scope.reletMonth != '' && $scope.reletMonth != null && $scope.cabinetDetail.end_rent != undefined && $scope.cabinetDetail.end_rent != '' && $scope.cabinetDetail.end_rent != null && reCabinetData.give_month != null) {
                $scope.reGiveMonth = angular.fromJson(reCabinetData.give_month);
                if($scope.reGiveMonth == null || $scope.reGiveMonth == undefined || $scope.reGiveMonth == '') {
                    reGiveMonth = 0;
                    $scope.giveTimeType = '';
                    $scope.giveReletMonthNum = 0;
                    $scope.giveReletMonthNum1 = 0;
                }else {
                    var __pattern = new RegExp(/^(\d+)(d|m)$/);
                    if(!__pattern.test($scope.reGiveMonth[$scope.reletMonth])) {
                        //获取租赁月数(包含赠送月数)
                        var reRentreg = new RegExp('"'+$scope.reletMonth+'":\\s"\\d+"','g');
                        var reRentRe = reCabinetData.give_month.match(reRentreg);
                        if(reRentRe != null){
                            var reEndRe = reRentRe[0];
                            reGiveMonth = reEndRe.slice(reEndRe.indexOf(':')+3).replace('"','');
                            $scope.giveReletMonthNum = parseInt(reGiveMonth);
                            $scope.giveReletMonthNum1 = parseInt(reGiveMonth);
                        }else{
                            reGiveMonth = 0;
                            $scope.giveTimeType = '';
                            $scope.giveReletMonthNum = 0;
                            $scope.giveReletMonthNum1 = 0;
                        }
                    }else {
                        reGiveMonth = $scope.reGiveMonth[$scope.reletMonth].match(/^(\d+)(d|m)$/)[1];
                        $scope.giveTimeType = $scope.reGiveMonth[$scope.reletMonth].match(/^(\d+)(d|m)$/)[2];
                        $scope.giveReletMonthNum = parseInt(reGiveMonth);
                        $scope.giveReletMonthNum1 = parseInt(reGiveMonth);
                    }
                }
                //计算到期时间(自然月的形式)
                $scope.getEndDate($scope.cabinetDetail.end_rent * 1000, $scope.reletMonth, parseInt(reGiveMonth), $scope.giveTimeType)
            }else{
                reGiveMonth = 0;
                $scope.giveTimeType = '';
                $scope.giveReletMonthNum = 0;
                $scope.giveReletMonthNum1 = 0;
                $scope.cabinetreletEndDate = $scope.getMyDate($scope.cabinetDetail.end_rent * 1000);
            }
        }
        //租赁月数对应的金额
        if(reletMonth == null || reletMonth == ''){
            reMuchMoney = 0;
        }else if(reCabinetData.cabinet_money != null){
            var regReMoney = new RegExp('"'+reletMonth+'":\\s"\\d+"','g');
            var regReMoneyRe = reCabinetData.cabinet_money.match(regReMoney);
            if(regReMoneyRe != null){
                var endMoney = regReMoneyRe[0];
                reMuchMoney = endMoney.slice(endMoney.indexOf(':')+3).replace('"','');
            }else{
                reMuchMoney = $scope.reletMonth * $scope.cabinetDetail.monthRentPrice;
            }
        }else{
            reMuchMoney = $scope.reletMonth * $scope.cabinetDetail.monthRentPrice;
        }
        //实时计算续租金额
        if($scope.reletMonth != undefined && $scope.reletMonth != '' && $scope.reletMonth != null && $scope.cabinetDetail.monthRentPrice != undefined && $scope.cabinetDetail.monthRentPrice != '' && $scope.cabinetDetail.monthRentPrice != null) {
            if(reGiveMonth != undefined && reGiveMonth != null){
                $scope.reletPrice = reMuchMoney;
                disContainer = $scope.reletPrice;
            }else{
                $scope.reletPrice = reMuchMoney;
                disContainer = $scope.reletPrice;
            }
        }else{
            $scope.reletPrice = 0;
            disContainer = 0;
        }
        //定义数组容器
        var redisArr = [];
        //获取续租折扣
        if(reletMonth == null || reletMonth == ''){
            //如果不存在对应的折扣
            $scope.redises = redisArr;
            $scope.redisplay = 0;
        }else if(reCabinetData.cabinet_dis != null){
            var reRegdis = new RegExp('"'+reletMonth+'":\\s"\\d+(\\.\\d+)?(\\/\\d+(\\.\\d+)?)*"','g');
            var reRegdisRe = reCabinetData.cabinet_dis.match(reRegdis);
            if(reRegdisRe != null){
                var disRestr = reRegdisRe[0].slice(reRegdisRe[0].indexOf(':')+3).replace('"','');
                if(disRestr.indexOf('/') > -1){
                    //如果存在'/'
                    $scope.redises = disRestr.split('/');
                    $scope.redisplay = 1;
                }else{
                    //如果折扣数量是1
                    redisArr[0] = disRestr;
                    $scope.redises = redisArr;
                    $scope.redisplay = 1;
                }
            }else{
                //如果不存在对应的折扣
                $scope.redises   = redisArr;
                $scope.redisplay = 0;
            }
        }else{
            //如果不存在对应的折扣
            $scope.redises   = redisArr;
            $scope.redisplay = 0;
        }
    }
    //选择折扣获取续费最终金额
    $scope.getReDis = function(reDis){
        if($scope.reletPrice != 0 && $scope.reletPrice != undefined && $scope.reletPrice != null && $scope.reletPrice != ''){
            $scope.reletPrice = disContainer * parseFloat(reDis);
        }else{
            $scope.reletPrice = 0;
        }
    }

    $scope.reletEndDate = function(){
        if($scope.reletMonth != undefined && $scope.reletMonth !='' && $scope.reletMonth != null && $scope.cabinetDetail.end_rent != undefined && $scope.cabinetDetail.end_rent !='' && $scope.cabinetDetail.end_rent != null ){
            if($scope.reletMonth >= 12){
                var numYears = Math.floor($scope.reletMonth/12);
                if($scope.reletGiveMonthNum !== 0){
                    $scope.reletMonth = numYears*2 + $scope.reletMonth;
                }
            }
            $http.get('/cabinet/calculate-date?numberMonth='+ $scope.reletMonth +'&startRent='+ $scope.cabinetreletEndDate).then(function(result){
                $scope.cabinetreletEndDate = (result.data).replace(/\"/g, "");
            });
        }
    }
    //续租完成
    $scope.renewCabinetComplete = function(){
        $scope.renewCabinetData = function(){
            $scope.dayGive = $('.giveReletMonthNum11').val();
            if ($scope.dayGive === undefined || $scope.dayGive === '' || $scope.dayGive == null) {
                $scope.dayGive = '';
                $scope.giveTimeType = '';
            }
            return {
                _csrf_backend: $('#_csrf').val(),
                memCabinetId :parseInt($scope.cabinetDetail.memberCabinetId),      //会员柜子id
                memberId:parseInt($scope.cabinetDetail.member_id),
                renewDate   :$scope.cabinetreletEndDate, //续组日期
                renewNumDay:$scope.reletMonth,      //续组月数
                renewRentPrice:$scope.reletPrice,  //续组价格
                // give_month:$scope.giveReletMonthNum//续租的赠送的月数
                giveDay:    $scope.dayGive,//续租的赠送的月数
                giveType:   $scope.giveTimeType
            }
        }
        if($scope.reletMonth == null || $scope.reletMonth == ''|| $scope.reletMonth== undefined){
            Message.warning('请输入续租的月数!');
            return;
        }
        // if(parseInt($scope.memberCardRentInvalidTime) < $scope.endTime){
        //     Message.warning("您的租柜到期日期在会员卡到期日期之后!");
        // return;
        // }
        if(parseInt($('.giveReletMonthNum11').val()) > $scope.giveReletMonthNum1) {
            Message.warning('续柜赠送数不得大于' + $scope.giveReletMonthNum1);
            return false;
        }
        $scope.renewCabinetCompleteFlag = true;
        $http({
            url: "/cabinet/renew-cabinet",
            method: 'POST',
            data: $.param( $scope.renewCabinetData()),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            if(result.data.status == 'success'){
                Message.success(result.data.data);
                $scope.reletMonth = '';
                $scope.reletPrice= '';
                $scope.getDate();
                $scope.allCabinetTypeData();
                $scope.renewCabinetCompleteFlag = false;
                $scope.isRenew = false;
            }else{
                $scope.renewCabinetCompleteFlag = false;
                Message.warning(result.data.data);
            }
        })
    }
    $scope.addComplete = function() {
        //流程控制
        if($scope.cabinetSize == null || $scope.cabinetSize == undefined || $scope.cabinetSize == "") {
            Message.warning("请选择柜子型号!");
            return;
        }
        if($scope.cabinetPrefix == undefined || $scope.cabinetPrefix == '' || $scope.cabinetPrefix == null || $scope.cabinetNumStart == undefined || $scope.cabinetNumStart == '' || $scope.cabinetNumStart == null) {
            Message.warning("请输入完整的柜号!");
            return;
        }
        if($scope.cabinetType == null || $scope.cabinetType == undefined || $scope.cabinetType == "") {
            Message.warning("请选择柜子类别!");
            return;
        }
        if($scope.addCabinetNum == null || $scope.addCabinetNum == undefined || $scope.addCabinetNum == "") {
            Message.warning("请输入柜子数量!");
            return;
        }
        if($scope.cabinetType == 2) {
            if($('.halfMonthMoney').val() == null || $('.halfMonthMoney').val() == undefined || $('.halfMonthMoney').val() == "") {
                Message.warning("请输入单月金额!");
                return;
            }
        }
        if($scope.cabinetType == 2) {
            if($('.cabinetDeposit').val() == null || $('.cabinetDeposit').val() == undefined || $('.cabinetDeposit').val() == '') {
                Message.warning("请输入押金金额!");
                return;
            }
        }
        // 获取新增多月设置的值
        if($scope.cabinetType == 2) {
            var $muchMoneyBox = $('#addMuchPlugins').children('div.clearfix');
            var jsonMonth = [];
            var jsonMoney = {};
            var jsonDis = {};
            // var jsonGiveMonth = {};
            var jsonGiveTime = {};
            var notPass = false;
            var notFormat = false;
            $muchMoneyBox.each(function (index, item) {
                var cabinet_month = $(this).find('input[name="cabinet_month"]').val();
                var cabinet_money = $(this).find('input[name="cabinet_money"]').val();
                // var give_month = $(this).find('input[name="give_month"]').val();
                var cabinet_dis = $(this).find('input[name="cabinet_dis"]').val();
                //赠送可以自由选择日或月
                var give_type = $(this).find('select').val();
                var give_value = $(this).find('input[name="give_month"]').val();
                //判断折扣是否格式化
                if(cabinet_dis != '' && cabinet_dis != undefined && cabinet_dis != null){
                    if(/^0\.[123456789]+$/.test(cabinet_dis) || /^0\.[123456789]+(\/0\.[123456789]+)+$/.test(cabinet_dis)){
                        notFormat = false;
                    }else{
                        notFormat = true;
                    }
                }
                if (cabinet_month != '' && cabinet_month != null && cabinet_money != '' && cabinet_money != null) {
                    jsonMonth.push(cabinet_month);
                    jsonMoney[cabinet_month] = cabinet_money;
                    // jsonGiveMonth[cabinet_month] = give_month;
                    jsonDis[cabinet_month] = cabinet_dis;
                    if(give_value === null || give_value === undefined || give_value === '') {
                        jsonGiveTime[cabinet_month] = null;
                    }else {
                        jsonGiveTime[cabinet_month] = give_value + give_type;
                    }
                } else {
                    //如果有一条不符合就不能通过
                    notPass = true;
                    return;
                }
            });
            //如果多月设置为空
            // if (notPass == true) {
            // 	Message.warning('多月设置必填项不能为空');
            // 	return;
            // }
            //如果多月设置月数重复
            if (isRepeat(jsonMonth)) {
                Message.warning('多月设置月份不能"重复"');
                return;
            }
            //如果折扣没有格式化
            if(notFormat == true){
                Message.warning('折扣不符合格式');
                return;
            }
        }
        //新增柜子提交的数据
        $scope.addCabinetData = function() {
            return {
                _csrf_backend  : $('#_csrf').val(),
                cabinetPrefix  : $scope.cabinetPrefix ? $scope.cabinetPrefix : null, //编号
                cabinetNumStart: $scope.cabinetNumStart ? $scope.cabinetNumStart : null, //起始柜号
                cabinetModel   : $scope.cabinetSize ? $scope.cabinetSize : null, //柜子型号
                cabinetType    : $scope.cabinetType ? $scope.cabinetType : null, //柜子类别
                cabinetNum     : $scope.addCabinetNum ? $scope.addCabinetNum : null, //柜子数量
                monthRentPrice : $('.halfMonthMoney').val(), //单月金额
                cabinetTypeId  :  $scope.str3[1] ? $scope.str3[1] : null, //柜子类型ID
                deposit        : $('.cabinetDeposit').val(), //柜子押金
                // giveMonth      : jsonGiveMonth != undefined && jsonGiveMonth != '' ? jsonGiveMonth : null,  //多月设置赠送月数
                giveMonth		   : jsonGiveTime != undefined && jsonGiveTime != '' ? jsonGiveTime :null,	//多月设置赠送类型及数量
                cabinetMonth   : jsonMonth != undefined && jsonMonth != '' ? jsonMonth : null,    //多月设置月份
                cabinetMoney   : jsonMoney != undefined && jsonMoney != '' ? jsonMoney : null,  //多月设置金额
                cabinetDis     : jsonDis   != undefined && jsonDis   != '' ? jsonDis   : null,  // 多月设置折扣
            }
        };
        //显示提交按钮动画
        $scope.addCabinetButtonFlag = true;
        //发送客户端数据
        $http({
            url: "/cabinet/add-venue-cabinet",
            method: 'POST',
            data: $.param($scope.addCabinetData()),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(response) {
            if(response.data.status == 'success') {
                Message.success(response.data.data);
                //执行关闭模态框
                $scope.searchClass();
                $scope.allCabinetTypeData();
                $scope.isAdd = false;
            } else {
                $scope.addCabinetButtonFlag = false;
            }
        });
    };
    $scope.cancelTypeModify = function () {
        $scope.isAdd = false;
    }
    // 退柜
    //退租
    $scope.getMyDate = function(str) {
        str = parseInt(str);
        if(str != "" || str != null) {
            var oDate = new Date(str);
            var oYear = oDate.getFullYear();
            var oMonth = oDate.getMonth() + 1;
            oMonth = oMonth >= 10 ? oMonth : '0' + oMonth;
            var oDay = oDate.getDate();
            oDay = oDay >= 10 ? oDay : '0' + oDay;
            var theDate = oYear + "-" + oMonth + "-" + oDay;
        } else {
            theDate = "";
        }
        return theDate
    };
    var currentTime = new Date().getTime();
    $scope.currentDate = $scope.getMyDate(currentTime);
    $scope.quitCabinet = function(id, memCabinetId, cabinetDetail) {
        $scope.isThrow = true;
        $scope.quitCabinetCompleteFlag = false;
        $scope.containerId = id;
        $scope.memCabinetId = memCabinetId;
        $scope.cabinetDetail = cabinetDetail;
        $('#boundCabinet').modal('hide');
        $scope.cabinetCashPledge = parseInt(cabinetDetail.deposit != null && cabinetDetail.deposit != undefined ? cabinetDetail.deposit : 50);
        var currentTime = new Date().getTime();
        var endTime = new Date(($scope.getMyDate(cabinetDetail.end_rent * 1000) + " " + "23:59:59")).getTime();
        $scope.endNextWeek = endTime + 7 * 24 * 60 * 60 * 1000;
        /**
         * 退柜管理-退柜设置-获取退柜配置
         * 1.有设置配置,调用配置
         * 2.没有,则退全部押金
         */
        $http.get('/cabinet/get-quit-cabinet-value').then(function (result) {
            $scope.quitCabinetValue = result.data;
            var setDays = $scope.quitCabinetValue.setDays;
            var setCost = $scope.quitCabinetValue.setCost;
            var dateType = $scope.quitCabinetValue.dateType;
            if(currentTime < endTime) {
                $scope.depositRefund = $scope.cabinetCashPledge;return ;
            }
            if (setDays == null || setDays == '' || setDays == undefined) {
                //没有设置天数限制
                if (setCost == null || setCost == '' || setCost == undefined) {
                    $scope.depositRefund = $scope.cabinetCashPledge;
                } else {
                    var long = 1;
                    switch (dateType) {
                        case 'everyDay'     : long = 1;break;
                        case 'everyWeek'    : long = 7;break;
                        case 'everyMonth'   : long = 30;break;
                    }
                    //计算超出的日期
                    var overTime = Math.ceil(parseInt(parseInt(currentTime) - parseInt(endTime))/(24 * 60 * 60 * 1000));
                    var overDay = Math.ceil(overTime/long);
                    var deductMoney = parseInt(overDay*setCost);
                    $scope.depositRefund = parseInt(parseInt($scope.cabinetCashPledge) - parseInt(deductMoney));
                    if (parseInt($scope.depositRefund) < 0) {
                        $scope.depositRefund = 0;
                    }
                }
            } else {
                //设置了天数限制
                var overTime = Math.ceil(parseInt(parseInt(currentTime) - parseInt(endTime))/(24 * 60 * 60 * 1000));
                if (overTime <= parseInt(setDays)) {
                    $scope.depositRefund = $scope.cabinetCashPledge;
                } else {
                    if (setCost == null || setCost == '' || setCost == undefined) {
                        $scope.depositRefund = $scope.cabinetCashPledge;
                    } else {
                        var long = 1;
                        switch (dateType) {
                            case 'everyDay'     :
                                long = 1;
                                break;
                            case 'everyWeek'    :
                                long = 7;
                                break;
                            case 'everyMonth'   :
                                long = 30;
                                break;
                        }
                        var overDay = Math.ceil((parseInt(overTime) - parseInt(setDays)) / parseInt(long));
                        var deductMoney = parseInt(parseInt(overDay)*setCost);
                        $scope.depositRefund = parseInt(parseInt($scope.cabinetCashPledge) - parseInt(deductMoney));
                        if (parseInt($scope.depositRefund) < 0) {
                            $scope.depositRefund = 0;
                        }
                    }
                }
            }

        })
    };
    //点击显示更衣柜详情
    // ng-click="tdClick(oneCabinet.status,oneCabinet.id,oneCabinet.member_id,'list')"
    // status:状态     id:柜子id    member_id:会员id(如果有会员绑定柜子的话)
    $scope.tdClick = function(status, cabinetId, type, cabinetType) {
        //获取柜子&会员详情
        $http.get('/cabinet/cabinet-details?cabinet_id=' + cabinetId).then(function (response) {
            $scope.cabinetDetailOne = response.data;
            $scope.cabinetCashPledge = parseInt(response.data.deposit);
            $scope.cabinetInfoItem = response.data;
            $('#isBind').attr('data-page',type);
            //根据柜子的status判断柜子有没有租出去
            if(parseInt(status) === 1) {
                $scope.bindCabinetType = cabinetType;
                $('#noBoundCabinet').modal('show');
                //新增多月设置金额详情
                var muchMonthMoneyDetail = response.data.cabinet_money;
                var container = [];
                var tmp;
                var tmpArr = angular.fromJson(muchMonthMoneyDetail);
                $.each(tmpArr,function(key, item){
                    tmp = '月数: '+key+' 金额: '+item+'元';
                    container.push(tmp);
                });
                $scope.muchMonthDetails = container;
            } else if(parseInt(status) === 2) {
                // $scope.showBox = 1;
                // $scope.isShowBox = true;
                // $('#boundCabinet').modal('show');
                $scope.cabinetDetail = $scope.cabinetInfoItem;
                window.location.href = '/wcabinet/bind-user?c=' + $scope.cabinetDetail.cabinet_id;
                //获取会员消费记录
                $scope.cabinetRentUrl = "/cabinet/member-consum-list?memberId="+$scope.cabinetInfoItem.member_id+"&cabinetId="+cabinetId+"&type=cabinet";
                $scope.memberConsumList($scope.cabinetRentUrl);
            }
        });
    };
    //退柜完成
    $scope.quitCabinetComplete = function(endTime) {
        $scope.quitCabinetData = function() {
            return {
                _csrf_backend: $('#_csrf').val(),
                quiteDate: $scope.currentDate, //退租时间
                memCabinetId: parseInt($scope.memCabinetId), //会员柜子id
                price: $scope.depositRefund,
                memberId: parseInt($scope.cabinetDetail.member_id),
                cabinetId: parseInt($scope.containerId)
            }
        }
        $scope.quitCabinetCompleteFlag = true;
        $http({
            url: "/cabinet/quite-cabinet",
            method: 'POST',
            data: $.param($scope.quitCabinetData()),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(result) {
            if(result.data.status == 'success') {
                $scope.searchClass();
                $scope.allCabinetTypeData();
                Message.success(result.data.data);
                $scope.isThrow = false;
            } else {
                $scope.quitCabinetCompleteFlag = false;
                Message.warning(result.data.data);
            }
        });
    };
    // 冻结
    //冻结柜子
    $scope.freezeCabinet = function(id){
        $http.get('/cabinet/frozen-cabinet?cabinetId='+ id).then(function(result){
            if(result.data.status == 'success'){
                Message.success(result.data.data);
                $scope.getDate();
            }else if(result.data.status == 'error'){
                Message.warning(result.data.data);
            }
        })
    }
    //取消冻结
    $scope.cancelFreezeCabinet  = function(id){
        $http.get('/cabinet/frozen-cabinet?cabinetId='+ id +'&status='+2).then(function(result){
            if(result.data.status == 'success'){
                Message.success(result.data.data);
                $scope.getDate();
            }else if(result.data.status == 'error'){
                Message.warning(result.data.data);
            }
        })
    }
    $scope.searchCabinet();
    $scope.getCabinetTypeLister = function () {
        window.location.href = '/wcabinet/cabinet-type?i=' + $scope.str3[1] + '&n='+ $scope.str4[1];
    };
    // 租柜日期插件的js
    $("#dataCabinet").datetimepicker({
        minView: "month", //设置只显示到月份
        format: 'yyyy-mm-dd',
        language: 'zh-CN',
        autoclose: true,
        todayBtn: true, //今日按钮
    });
    //点击绑定用户柜子的数据
    var currentCabinetData;
    //点击绑定用户柜子实时赠送月数
    var giveCurMonth;
    //点击绑定用户柜子实时折扣
    var rootCurDis;
    //点击绑定用户柜子租赁月数对应的金额
    var muchMonthMoney;
    //获取柜子到期时间
    $scope.getCabinetEndDate = function() {
        if($scope.cabinetDays !== undefined && $scope.cabinetDays !== '' && $scope.cabinetDays !== null && $scope.startRentCabinet !== undefined && $scope.startRentCabinet !== '' && $scope.startRentCabinet !== null) {
            $scope.getEndDate(parseInt(Date.parse($scope.startRentCabinet)), $scope.cabinetDays, $scope.giveMonthBingCabinet, $scope.buyTimeType);
            // if(giveCurMonth != 0 || giveCurMonth != undefined || giveCurMonth != null){
            // 	var num = $scope.cabinetDays + parseInt(giveCurMonth);
            // 	$scope.getEndDate(num);
            // }else{
            // 	$scope.getEndDate($scope.cabinetDays);
            // }
        }else{
            $scope.cabinetEnd = $scope.startRentCabinet;
        }
    }
    //根据月数获取租赁柜子具体金额不算押金
    $scope.getTheAmountPayable = function() {
        if($scope.cabinetDays != undefined && $scope.cabinetDays != '' && $scope.cabinetDays != null && $scope.cabinetOneMonMoney != undefined && $scope.cabinetOneMonMoney != '' && $scope.cabinetOneMonMoney != null) {
            if(giveCurMonth != undefined && giveCurMonth != null){
                if(muchMonthMoney != 0){
                    return parseFloat(muchMonthMoney);
                }else{
                    return $scope.cabinetDays * $scope.cabinetOneMonMoney;
                }
            }else{
                return $scope.cabinetDays * $scope.cabinetOneMonMoney;
            }
        } else {
            return 0;
        }
    };
    //输入租赁月数实时计算赠送月数和租赁金额
    $scope.rentCabinetDays = function(start) {
        //初始化输入月数
        $scope.cabinetDays = parseInt(start);
        //初始化折扣
        $scope.selectedDis = '1';
        //根据输入月数获取赠送月数
        if(start === null || start === '' || start === undefined){
            giveCurMonth = 0;
        }else {
            $scope.reGiveTime = angular.fromJson(currentCabinetData.give_month);
            if($scope.reGiveTime != null && $scope.reGiveTime != '' && $scope.reGiveTime != undefined) {
                if(!$scope.reGiveTime[$scope.cabinetDays]) {
                    $scope.buyTimeType = '';
                    $scope.giveMonthBingCabinet = 0;
                    $scope.giveMonthBingCabinet1 = 0;
                }else {
                    if(!$scope.reGiveTime[$scope.cabinetDays].match(/^(\d+)(d|m)$/)) {
                        //获取租赁月数(包含赠送月数)
                        var regexp = new RegExp('"'+start+'":\\s"\\d+"','g');
                        var pregRe = currentCabinetData.give_month.match(regexp);
                        if(pregRe != null){
                            var endRe = pregRe[0];
                            $scope.giveMonthBingCabinet = endRe.slice(endRe.indexOf(':')+3).replace('"','');
                            giveCurMonth = $scope.giveMonthBingCabinet;
                            $scope.buyTimeType = 'm';
                            $scope.giveMonthBingCabinet = parseInt(giveCurMonth);
                            $scope.giveMonthBingCabinet1 = parseInt(giveCurMonth);
                        }else{
                            $scope.giveMonthBingCabinet = 0;
                            giveCurMonth = 0;
                        }
                    }else {
                        giveCurMonth = $scope.reGiveTime[$scope.cabinetDays].match(/^(\d+)(d|m)$/)[1];
                        $scope.buyTimeType = $scope.reGiveTime[$scope.cabinetDays].match(/^(\d+)(d|m)$/)[2];
                        $scope.giveMonthBingCabinet = parseInt(giveCurMonth);
                        $scope.giveMonthBingCabinet1 = parseInt(giveCurMonth);
                    }
                }
            }else {
                $scope.buyTimeType = '';
                $scope.giveMonthBingCabinet = 0;
                $scope.giveMonthBingCabinet1 = 0;
            }
        }
        //根据输入月数获取折扣
        //定义数组容器
        var disArr = [];
        if(start == null || start == ''){
            //如果不存在对应的折扣
            $scope.dises = disArr;
            $scope.display = 0;
        }else if(currentCabinetData.cabinet_dis != null){
            var regdis = new RegExp('"'+start+'":\\s"\\d+(\\.\\d+)?(\\/\\d+(\\.\\d+)?)*"','g');
            var regdisRe = currentCabinetData.cabinet_dis.match(regdis);
            if(regdisRe != null){
                var disstr = regdisRe[0].slice(regdisRe[0].indexOf(':')+3).replace('"','');
                if(disstr.indexOf('/') > -1){
                    //如果存在'/'
                    $scope.dises = disstr.split('/');
                    $scope.display = 1;
                }else{
                    //如果折扣数量是1
                    disArr[0] = disstr;
                    $scope.dises = disArr;
                    $scope.display = 1;
                }
            }else{
                //如果不存在对应的折扣
                $scope.dises   = disArr;
                $scope.display = 0;
            }
        }else{
            $scope.dises   = disArr;
            $scope.display = 0;
        }
        //实时计算租金
        if(start == null || start == ''){
            muchMonthMoney = 0;
        }else if(currentCabinetData.cabinet_money != null){
            var regMoney = new RegExp('"'+start+'":\\s"\\d+"','g');
            var regMoneyRe = currentCabinetData.cabinet_money.match(regMoney);
            if(regMoneyRe != null){
                var regMonneyEndRe = regMoneyRe[0];
                muchMonthMoney = regMonneyEndRe.slice(regMonneyEndRe.indexOf(':')+3).replace('"','');
            }else{
                muchMonthMoney = 0;
            }
        }else{
            muchMonthMoney = 0;
        }
        //实时计算金额加押金
        if(start == '' || start == null || start == 0){
            $scope.theAmountPayable = 0;
        }else if($scope.selectedDis != null && $scope.selectedDis != undefined && $scope.selectedDis != ''){
            $scope.theAmountPayable = $scope.getTheAmountPayable() * parseFloat($scope.selectedDis) + $scope.cabinetCashPledge;
            console.log($scope.theAmountPayable)
        }else{
            $scope.theAmountPayable = $scope.getTheAmountPayable() + $scope.cabinetCashPledge;
        }
        //实时计算到期日期
        $scope.getCabinetEndDate();
    }
    //删除柜子
    $scope.CabinetDelete = function(id) {
        $http.get('/cabinet/cabinet-delete?id=' + id).then(function(result) {
            if(result.data.status == 'success') {
                $scope.getDate();
                // $scope.replacementPages('/cabinet/home-data?typeId=' + $scope.str3[1] ? $scope.str3[1] : null + '&cabinetNum=&cabinetModel=&cabinetType=&customerName=&cabinetEndRent=&sortType=&sortName=&page=' + $scope.cabinetDetailPage + '&per-page=8');
                Message.success('删除柜子成功！')
            } else {
                Message.warning('删除失败，请重试！')
            }
        })
    };
    //绑定用户
    $scope.bindingMember = function(object, id) {
        $scope.isBindUser = true;
        $scope.keywords = '';
        $scope.memberDetail = ''
        currentCabinetData = object;
        $scope.bindingCabinetCompleteFlag = false;
        $scope.cabinetCashPledge = parseInt(object.deposit != null && object.deposit != undefined && object.deposit != '' ? object.deposit : 0);
        $scope.containerId = id;
        $scope.containerNumber = object.cabinet_number;
        $scope.cabinetIsType = object.cabinetModel;
        $scope.cabinetOneMonMoney = object.monthRentPrice;
        $scope.bindingMemberPreCabinetDetail = object;
        //重置模态框
        $scope.selectedDis = '1';
        $scope.theAmountPayable = 0;
        $scope.display = 0;
        $('#bindingUser').modal('show');
    };
    // * 函数描述: 查找会员，搜索会员，避免被冻结的会员绑定更柜
    $scope.searchMember = function() {
        $scope.giveMonthBingCabinet = '';
        $scope.cabinetEnd = '';
        $scope.cabinetDays = '';
        $scope.startRentCabinet = '';
        if($scope.keywords != '') {
            $http.get('/cabinet/search-member?phone=' + $scope.keywords).then(function(result) {
                if(result.data != 'null') {
                    $scope.memberDetail = result.data;
                    console.log($scope.memberDetail)
                    $http.get('/user/member-card?memberId=' + $scope.memberDetail.member_id).then(function(response) {
                        $scope.memberCardRentInvalidTime = response.data.invalid_time;
                    });
                    $scope.keywords = '';
                    // $('#bindingCabinet').modal('show');
                    // $('#bindingUser').modal('hide');
                    $scope.getTheAmountPayable();
                } else {
                    Message.warning("该用户不是会员或者该会员被冻结!");
                    return;
                }
            })
        } else {
            Message.warning("输入有误,请重新输入!");
            return;
        }
    }
    //绑定柜子
    $scope.bindingCabinetComplete = function(id) {
        if (!$scope.memberDetail) {
            Message.warning('请选择绑定会员');
            return;
        }
        $scope.bindingCabinetDataInit = function() {
            $scope.startRentCabinet = '';
            $scope.theAmountPayable = '';
            $scope.cabinetEnd = '';
            $scope.cabinetDays = '';
            $scope.bindCabinetNote = '';
        }
        $scope.rentalMoney = $scope.theAmountPayable - $scope.cabinetCashPledge;//租金
        $scope.bindingCabinetData = function() {
            if ($scope.giveMonthBingCabinet == 0 || $scope.giveMonthBingCabinet ===undefined || $scope.giveMonthBingCabinet === null || $scope.giveMonthBingCabinet ==='') {
                $scope.buyTimeType = '';
                $scope.giveMonthBingCabinet = '';
            }
            return {
                _csrf_backend: $('#_csrf').val(),
                memberId: $scope.memberDetail.id != undefined && $scope.memberDetail.id != "" ? $scope.memberDetail.id : null, //会员id
                cabinetRentStart: $scope.startRentCabinet != undefined && $scope.startRentCabinet != "" ? $scope.startRentCabinet : null, //时间
                cabinetRentEnd: $scope.cabinetEnd != undefined && $scope.cabinetEnd != "" ? $scope.cabinetEnd : null, //到期时间
                // price: $scope.theAmountPayable != undefined && $scope.theAmountPayable != "" ? $scope.theAmountPayable : null, //单日金额
                price: $scope.rentalMoney != undefined && $scope.rentalMoney != "" ? $scope.rentalMoney : null, //租金
                cabinetId: $scope.containerId != undefined && $scope.containerId != "" ? parseInt($scope.containerId) : null, //柜子ID
                deposit: $scope.cabinetCashPledge,
                giveDay:$scope.giveMonthBingCabinet,//赠送的月数
                giveType:$scope.buyTimeType,
                note: $scope.bindCabinetNote
            }
        }
        if($scope.startRentCabinet == null || $scope.startRentCabinet == undefined || $scope.startRentCabinet == '') {
            Message.warning("请输入租柜日期!");
            return;
        }
        if($scope.cabinetDays == null || $scope.cabinetDays == undefined || $scope.cabinetDays == '') {
            Message.warning("请输入租柜月数!");
            return;
        }
        if(parseInt($('.giveMonthBingCabinet11').val()) > $scope.giveMonthBingCabinet1) {
            Message.warning('租柜赠送数不得大于' + $scope.giveMonthBingCabinet1);
            return false;
        }
        $scope.bindingCabinetCompleteFlag = true;
        $http({
            url: "/cabinet/bind-member",
            method: 'POST',
            data: $.param($scope.bindingCabinetData()),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(result) {
            if(result.data.status == 'success') {
                Message.success(result.data.data);
                $scope.bindingCabinetDataInit();
                $scope.getDate();
                $scope.allCabinetTypeData();
                $scope.isBindUser = false;
                // $('#bindingCabinet').modal('hide');
            } else {
                $scope.bindingCabinetCompleteFlag = false;
                Message.warning(result.data.data);
            }
        });
    };
    // 取消
    $scope.cancel = function () {
        $scope.isAdd = false;
        $scope.isThrow = false;
        $scope.isRenew = false;
        $scope.isBindUser = false;
    }
})
