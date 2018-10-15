var app = angular.module('App').controller('CabinetBindCtrl', function($scope, $http, $location, $rootScope, $interval) {
    $scope.str = decodeURI(location.search);
    $scope.str1 = $scope.str.split('?');
    $scope.str3 = $scope.str1[1].split('=');
    $('.group-ul').height($(window).height()-145 + 'px');
    $('.detialS').height($(window).height()-173 + 'px');
    $('.pp').height($(window).height()-173 + 'px');
    $('.vv').height($(window).height()-173 + 'px');
    $('.nn').height($(window).height()-207 + 'px');
    $('.nn').css('overflow-y', 'auto');
    // 获取会员信息
    $scope.getMessage = function (id) {
        $http.get('/cabinet/cabinet-details?cabinet_id=' + id).then(function(response) {
            $scope.memberData = response.data;
            $scope.cabinetDetailOne = response.data;
            $scope.cabinetCashPledge = parseInt(response.data.deposit);
            $scope.cabinetInfoItem = response.data;
            $scope.$emit('xiaofei');
        });
    }
    // * 函数描述: 查找会员，搜索会员，避免被冻结的会员绑定更柜
    $scope.searchMember = function() {
        $scope.giveMonthBingCabinet = '';
        $scope.cabinetEnd = '';
        $scope.cabinetDays = '';
        $scope.startRentCabinet = '';
        if($scope.keywords != '') {
            $http.get('/cabinet/search-member?phone=' + $scope.keywords).then(function(result) {
                if(result.data != 'null') {
                    $scope.memberData1 = result.data;
                    $http.get('/user/member-card?memberId=' + $scope.memberData1.member_id).then(function(response) {
                        $scope.memberCardRentInvalidTime = response.data.invalid_time;
                    });
                    $scope.keywords = '';
                    $('#bindingCabinet').modal('show');
                    $('#bindingUser').modal('hide');
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
    };
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
    //消费记录
    $scope.getHistoryData = function () {
        $http.get($scope.pageHistoryUrl).success(function (response) {
            if (!response.data) {
                $scope.payNoDataShow = true;
            } else {
                $scope.payNoDataShow = false;
            }
            $scope.expenses = response.data;
            $scope.payPages = response.page;
        });
    };
    // 设置搜索分页
    $scope.memberConsumList = function (urlPages){
        $scope.pageHistoryUrl = urlPages;
        $scope.getHistoryData();
    };
    $scope.initHistory = function () {
        $scope.pageHistoryUrl = '/cabinet/member-consum-list?memberId=' + $scope.memberData.member_id + '&cabinetId=' + $scope.str3[1] + '&type=cabinet'
    };
    $scope.getMessage($scope.str3[1])
    $scope.$on('xiaofei', function () {
        $scope.initHistory();
        $scope.getHistoryData();
    });
    $scope.editUnBinding = function () {
        window.location.href = '/wcabinet/cabinet-edit?c=' + $scope.str3[1] + '&t=notBind';
    };
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
    $scope.isRenew = false;
    $scope.isSwitch = false;
    $scope.isQuit = false;
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
    //  分页数据信息
    $scope.getDate = function() {
        $.loading.show();
        $http.get($scope.pageInitUrl+'&pageSize=8').then(function(result) {
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
    //获取所有的柜子
    $scope.allCabinetTypeData = function() {
        $.loading.show();
        $http.get('/cabinet/get-cabinet-list?venueId=' + $scope.venueList).then(function(result) {
            $scope.allCabinet = result.data;
            $scope.$emit('isGetFinish');
            $.loading.hide();
        })
    };
    //时间戳转化为字符串
    $scope.fmtDate = function (obj) {
        var date =  new Date(obj);
        var y = 1900+date.getYear();
        var m = "0"+(date.getMonth()+1);
        var d = "0"+date.getDate();
        return y+"-"+m.substring(m.length-2,m.length)+"-"+d.substring(d.length-2,d.length);
    };
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
            console.log('----------');
            reMuchMoney = 0;
        }else if(reCabinetData.cabinet_money != null){
            console.log('----------22');
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
    };
    //调柜
    //获取所有未租的柜子
    $scope.allUnLeasedCabinet = function() {
        $.loading.show();
        $http.get($scope.unLeasedCabinetUrl).then(function(result) {
            $scope.unLeasedCabinetLists = result.data;
            angular.forEach($scope.unLeasedCabinetLists, function (item, index) {
                item.isSelect = false;
            })
            $.loading.hide();
        })
    }
    //点击调柜按钮调柜
    $scope.switchCabinet = function(cabinetDetail) {
        console.log(cabinetDetail);
        $scope.cabinetDetail = cabinetDetail;
        // $('#boundCabinet').modal('hide');
        $scope.isSwitch = true;
        $scope.completeSwitchCabinetBtnFlag = false;
        $('.listCabinetStyle').eq(0).addClass('bgGrey').siblings('.listCabinetStyle').removeClass('bgGrey');
        $scope.oldCabinetId = cabinetDetail.cabinet_id;
        $scope.memCabinetId = cabinetDetail.memberCabinetId;
        $scope.oldCabinetDetail = cabinetDetail;
        $scope.selectSwitchCabinetPrice = 0;
        $scope.allCabinetTypeData();
        // $('#checkCabinet').modal('show');
    };
    $scope.$on('isGetFinish', function () {
        var id = $scope.allCabinet[0].id;
        $scope.oldTypeName = $scope.allCabinet[0].type_name;
        $scope.unLeasedCabinetUrl = '/cabinet/get-all-cabinet?typeId=' + id;
        $scope.allUnLeasedCabinet();
    })
    //调柜类型选择
    $scope.cabinetStyleList = function(id, ind, object) {
        $scope.oldTypeName = object.type_name;
        $('.listCabinetStyle').eq(ind).addClass('bgGrey').siblings('.listCabinetStyle').removeClass('bgGrey');
        $scope.unLeasedCabinetUrl = '/cabinet/get-all-cabinet?typeId=' + id;

        $scope.allUnLeasedCabinet();
    }
    /**
     * 函数描述: 调柜选择时间，根据调整的选择，进行时间和金额的运算
     * */
    //调柜选择按钮
    $scope.selectSwitchCabinetBtn = function(selectCabinet, index) {
        angular.forEach($scope.unLeasedCabinetLists, function (item, ind) {
            if (index == ind) {
                $scope.unLeasedCabinetLists[index].isSelect = true;
            } else {
                $scope.unLeasedCabinetLists[ind].isSelect = false;
            }
        })
        var oldObjectCabinet = $scope.oldCabinetDetail;
        var oldCabinetEndTime = $scope.getMyDate(oldObjectCabinet.end_rent * 1000);
        $scope.selectCabinetDetail = selectCabinet;
        $scope.switchMonthNum = selectCabinet.give_month;
        var currentDate = new Date().getTime();
        var cabinetEndDate = (oldObjectCabinet.end_rent) * 1000;
        var $cabinetModel = oldObjectCabinet.cabinet_model; //当前柜子 3
        var $cabinet_model = selectCabinet.cabinet_model; //调换柜子型号 1
        //大柜型号 1  中柜型号 2     小柜型号3
        //同柜子调换
        if(parseInt($cabinetModel) == parseInt($cabinet_model)) {
            $scope.selectSwitchCabinetPrice = 0;
            $scope.switchCabinetEndDate = oldCabinetEndTime;
        }
        //大柜调小柜剩余钱变成小柜的日期
        /*if(parseInt($cabinetModel) < parseInt($cabinet_model)) {
         var yearCabinetMoney = parseInt($scope.selectCabinetDetail.yearRentPrice);
         var monthCabinetMoney = parseInt($scope.selectCabinetDetail.monthRentPrice);
         var priceSpread = Math.abs(oldObjectCabinet.monthRentPrice - selectCabinet.monthRentPrice) * Math.floor((cabinetEndDate - currentDate) / (1000 * 24 * 60 * 60));
         //大调小剩余的钱数够大于新柜一年的钱
         if(yearCabinetMoney != null && parseInt(priceSpread) >= parseInt(yearCabinetMoney)) {
         //先判断可以购买几年
         var numYear = Math.floor(priceSpread / yearCabinetMoney);
         //判断当前的钱可以购买多少个月
         var numMonth = Math.floor((priceSpread - numYear * yearCabinetMoney) / monthCabinetMoney);
         //判断剩余的钱还可以买多少天
         var daysMoney = (priceSpread - numYear * yearCabinetMoney - numMonth * monthCabinetMoney);
         var numDay = Math.ceil((daysMoney / monthCabinetMoney) * 30);
         var months = (numYear + $scope.switchMonthNum) * 12 + numMonth
         //获取调柜到期的日期
         $http.get('/cabinet/calculate-date?numberMonth=' + months + '&startRent=' + oldCabinetEndTime).then(function(result) {
         var endDate = (result.data).replace(/\"/g, "");
         $scope.switchCabinetEndDate = $scope.getMyDate(new Date(endDate + " " + "23:59:59").getTime() + numDay * 24 * 60 * 60 * 1000);
         });
         } else {
         //没有年租金时计算可以租多少好个月
         var MonthNumber = Math.floor(priceSpread / monthCabinetMoney);
         //减除月剩余多少天
         var dayNumber = Math.ceil((priceSpread - MonthNumber * monthCabinetMoney) / monthCabinetMoney * 30);
         $http.get('/cabinet/calculate-date?numberMonth=' + MonthNumber + '&startRent=' + oldCabinetEndTime).then(function(result) {
         var endDate = (result.data).replace(/\"/g, "");
         var endTime = endDate + " " + "23:59:59";
         $scope.switchCabinetEndDate = $scope.getMyDate(new Date(endDate + " " + "23:59:59").getTime() + dayNumber * 24 * 60 * 60 * 1000);
         });
         }
         // var switchCabinetEndDate = Math.floor(priceSpread/(oldObjectCabinet.monthRentPrice/30))*24*60*60*1000 + cabinetEndDate;
         //  $scope.switchCabinetEndDate = $scope.getMyDate(switchCabinetEndDate);
         $scope.selectSwitchCabinetPrice = 0;
         }*/
        //大柜调下一级柜子剩余钱变成柜子的日期
        if (parseInt($cabinetModel) < parseInt($cabinet_model)) {
            //计算原柜子剩余的钱
            var freeMoney = parseFloat(parseFloat(oldObjectCabinet.monthRentPrice) / 30 * parseInt(oldObjectCabinet.surplusDay));
            //计算现柜子的能够使用的天数
            var nowDay = parseInt(freeMoney / (parseFloat(selectCabinet.monthRentPrice) / 30));
            var timestamp = Math.round(new Date()) + nowDay *24*60*60*1000;
            $scope.selectSwitchCabinetPrice = 0;
            $scope.switchCabinetEndDate = $scope.getMyDate(timestamp);
        }
        //小柜调大柜补交金额
        if(parseInt($cabinetModel) > parseInt($cabinet_model)) {
            var currentNext = $scope.getMyDate(currentDate) + " " + "23:59:59";
            var currentNextTime = new Date(currentDate).getTime();
            $scope.selectSwitchCabinetPrice = (Math.abs(oldObjectCabinet.monthRentPrice - selectCabinet.monthRentPrice) / 30 * Math.floor((cabinetEndDate - currentDate) / (1000 * 24 * 60 * 60))).toFixed(2);
            $scope.switchCabinetEndDate = oldCabinetEndTime;
        }
    }
    /**
     * 函数描述: 调柜事件 完成数据运算后，向数据库传输数据
     * */
    //完成调柜
    $scope.completeSwitchCabinetBtn = function() {
        $scope.completeSwitchCabinetData = function() {
            return {
                _csrf_backend: $('#_csrf').val(), //csrf防止跨站
                memCabinetId: parseInt($scope.oldCabinetDetail.memberCabinetId), // 会员柜子id
                memberId: parseInt($scope.oldCabinetDetail.member_id),
                cabinetId: parseInt($scope.selectCabinetDetail.id), // 新柜子id
                originalCabinetId: parseInt($scope.oldCabinetId), //老柜子id
                price: $scope.selectSwitchCabinetPrice, //应补金额
                changeCabinetDate: $scope.switchCabinetEndDate //调柜的日期
            }
        }
        $scope.completeSwitchCabinetBtnFlag = true;
        $http({
            url: "/cabinet/change-cabinet",
            method: 'POST',
            data: $.param($scope.completeSwitchCabinetData()),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }).then(function(result) {
            if(result.data.status == 'success') {
                Message.success(result.data.data);
                $('#checkCabinetSuccess').modal('hide');
                $('#checkCabinet').modal('hide');
                $scope.getDate();
            } else {
                $scope.completeSwitchCabinetBtnFlag = false;
                Message.warning(result.data.data);
            }
        })
    };
    // 柜子的退租，退租的分析准备，时间上的处理
    $scope.quitCabinet = function(id, memCabinetId, cabinetDetail) {
        $scope.isQuit = true;
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
    var currentTime = new Date().getTime();
    $scope.currentDate = $scope.getMyDate(currentTime);
    //退柜完成
    $scope.quitCabinetComplete = function(endTime) {
        console.log(endTime)
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
                // $scope.searchClass();
                // $scope.allCabinetTypeData();
                // $scope.getMessage($scope.str3[1])
                Message.success(result.data.data);
                // $scope.isQuit = false;
                window.history.go(-1);
                // $('#backCabinet').modal('hide');
            } else {
                $scope.quitCabinetCompleteFlag = false;
                Message.warning(result.data.data);
            }
        });
    };
    //冻结柜子
    $scope.freezeCabinet = function(id){
        $http.get('/cabinet/frozen-cabinet?cabinetId='+ id).then(function(result){
            if(result.data.status == 'success'){
                Message.success(result.data.data);
                $scope.getMessage($scope.str3[1])
            }else if(result.data.status == 'error'){
                Message.warning(result.data.data);
            }
        })
    };
    //取消冻结
    $scope.cancelFreezeCabinet  = function(id){
        $http.get('/cabinet/frozen-cabinet?cabinetId='+ id +'&status='+2).then(function(result){
            if(result.data.status == 'success'){
                Message.success(result.data.data);
                $scope.getMessage($scope.str3[1])
            }else if(result.data.status == 'error'){
                Message.warning(result.data.data);
            }
        })
    };
    $scope.cancel = function () {
        $scope.isRenew = false;
        $scope.isSwitch = false;
        $scope.isQuit = false;
    }
})
