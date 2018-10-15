var app = angular.module('App').controller('CabinetData2Ctrl', function($scope, $http, $location, $rootScope, $interval) {
    $scope.str = decodeURI(location.search);
    $scope.str1 = $scope.str.split('?');
    $scope.str2 = $scope.str1[1].split('&');
    $scope.str3 = $scope.str2[0].split('=');
    $scope.str4 = $scope.str2[1].split('=');
    $('.group-ul').height($(window).height()-145 + 'px');
    $('.detialS').height($(window).height()-173 + 'px');
    $('.pp').height($(window).height()-173 + 'px');
    $('.vv').height($(window).height()-173 + 'px');
    $('.nn').height($(window).height()-207 + 'px');
    $('.nn').css('overflow-y', 'auto');
    $scope.initPath = function() {
        $scope.searchParams = $scope.search();
        $scope.pageInitUrl = '/cabinet/home-data?' + $.param($scope.searchParams);
    };
    /**点击区域，出现柜子列表***/
    $scope.searchClass = function(status) {
        if(!status){
            window.location.href = '/wcabinet/cabinet-data?i=' + $scope.str3[1] + '&n='+ $scope.str4[1];
        }
        // $scope.initPath();
        $scope.pageInitUrl = '/cabinet/home-data?' + $.param($scope.searchParams) + '&page=1&per-page=8';
        $scope.getDate(status);
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
        $http.get($scope.pageInitUrl+'&pageSize=60').then(function(result) {
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
    $scope.isAdd = false;
    $scope.addCabinetModal = function () {
        $scope.isAdd = true;
    }
    //新增柜子
    $scope.addComplete = function() {
        //流程控制
        if(!$scope.cabinetSize) {
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
                cabinetTypeId  : $scope.str3[1] ? $scope.str3[1] : null, //柜子类型ID
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
                $('#addCabinet').modal('hide');
            } else {
                $scope.addCabinetButtonFlag = false;
            }
        });
    };
    $scope.cancelTypeModify = function () {
        $scope.isAdd = false;
    }
    $scope.searchCabinet();
    $scope.getCabinetTypeLister = function () {
        window.location.href = '/wcabinet/cabinet-type?i=' + $scope.str3[1] + '&n='+ $scope.str4[1];
    }
})
