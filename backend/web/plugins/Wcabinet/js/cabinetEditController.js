var app = angular.module('App').controller('CabinetEditCtrl', function($scope, $http, $location, $rootScope, $interval) {
    console.log(decodeURI(location.search))
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
    // $scope.editUnBinding = function () {
    //     window.location.href = '/wcabinet/cabinet-edit';
    // };
    //新增2018/1/6
    $scope.init3 =function () {
        $scope.num = 0;
        $scope.modifyPluginsHtml = '';
        $scope.addPlugins();
    }
    $scope.addPlugins = function() {
        $scope.htmlAttr = 'modifyPlugins';
        $scope.num  = $scope.num + 1;
        $http.get('/rechargeable-card-ctrl/add-venue?attr='+$scope.htmlAttr+'&num='+$scope.num).then(function (result) {
            $scope.modifyPluginsHtml = result.data.html;
        });
    }
    //点击未绑定页面中的修改按钮
    $scope.editUnBinding = function(id,type) {
        $scope.editCompleteFlag = false;
        $scope.editCabinetId = id;
        if(type == 'isBind') {
            $scope.isCabinetBindMember = true;
        }else if(type == 'notBind') {
            $scope.isCabinetBindMember = false;
        }
        if($scope.cabinetInfoItem.deposit == undefined || $scope.cabinetInfoItem.deposit == '') {
            $scope.editCabinetDeposit = '';
        } else {
            $scope.editCabinetDeposit = parseFloat($scope.cabinetInfoItem.deposit);
        }
        if($scope.cabinetInfoItem.monthRentPrice == undefined || $scope.cabinetInfoItem.monthRentPrice == '') {
            $scope.editOneMonthPrice = '';
        } else {
            $scope.editOneMonthPrice = $scope.cabinetInfoItem.monthRentPrice;
        }
        // if($scope.cabinetInfoItem.yearRentPrice == undefined || $scope.cabinetInfoItem.yearRentPrice == '') {
        // 	$scope.editOneYearPrice = '';
        // } else {
        // 	$scope.editOneYearPrice = parseFloat($scope.cabinetInfoItem.yearRentPrice);
        // }
        if($scope.cabinetInfoItem.cabinet_model == undefined || $scope.cabinetInfoItem.cabinet_model == '') {
            $scope.editCabinetSize = '';
        } else {
            $scope.editCabinetSize = $scope.cabinetInfoItem.cabinet_model;
        }
        if($scope.cabinetInfoItem.cabinet_type == undefined || $scope.cabinetInfoItem.cabinet_type == '') {
            $scope.editCabinetType = '';
        } else {
            $scope.editCabinetType = $scope.cabinetInfoItem.cabinet_type;
        }
        $http.get('/cabinet/modify-one-cabinet?cabinetId=' + $scope.str3[1]).success(function(data){
            var cm  = angular.fromJson(data.data.cabinet_month);
            var cmy = angular.fromJson(data.data.cabinet_money);
            var md  = angular.fromJson(data.data.cabinet_dis);
            var gm  = angular.fromJson(data.data.give_month);
            if(cm != '' && cm != null && cm != undefined && cmy != '' && cmy != null && cmy != undefined && gm != '' && gm != null && gm != undefined && md != '' && md != null && md != undefined){
                var $max = cm.length;
                var i = -1;
                for(var n = 0; n < $max; n++){
                    $scope.htmlAttr = 'modifyPlugins';
                    $scope.num  = $scope.num + 1;
                    $http.get('/rechargeable-card-ctrl/add-venue?attr='+$scope.htmlAttr+'&num='+$scope.num).then(function (result) {
                        var $html = result.data.html;
                        var $dom = $($html).get(0);
                        i++;
                        $($dom).find('input[name="cabinet_month"]').val(parseInt(cm[i]));
                        $($dom).find('input[name="cabinet_money"]').val(parseFloat(cmy[cm[i]]));
                        if(!gm[cm[i]].match(/^(\d+)(d|m)$/)) {
                            $($dom).find('input[name="give_month"]').val(gm[cm[i]]);
                            $($dom).find('select').val('m');
                        }else {
                            $($dom).find('select').val(gm[cm[i]].match(/^(\d+)(d|m)$/)[2] ? gm[cm[i]].match(/^(\d+)(d|m)$/)[2] : '');
                            $($dom).find('input[name="give_month"]').val(gm[cm[i]].match(/^(\d+)(d|m)$/)[1] ? gm[cm[i]].match(/^(\d+)(d|m)$/)[1] : '');
                        }
                        $($dom).find('input[name="cabinet_dis"]').val(md[cm[i]]);
                        $('#modify').append($dom);
                    })
                }
                $('#boundCabinet').modal('hide');
            }else{
                return true;
            }
        });
        $('#noBoundCabinet').modal('hide');
        $('#isBind').attr('data-type',type);
    };
    //点击显示更衣柜详情
    // ng-click="tdClick(oneCabinet.status,oneCabinet.id,oneCabinet.member_id,'list')"
    // status:状态     id:柜子id    member_id:会员id(如果有会员绑定柜子的话)
    $scope.tdClick = function() {
        //获取柜子&会员详情
        $http.get('/cabinet/cabinet-details?cabinet_id=' + $scope.str3[1]).then(function (response) {
            $scope.cabinetDetailOne = response.data;
            $scope.cabinetCashPledge = parseInt(response.data.deposit);
            $scope.cabinetInfoItem = response.data;
            $scope.$emit('isRun');
        });
    };
    $scope.tdClick();
    $scope.$on('isRun', function () {
        $scope.editUnBinding($scope.str3[1],$scope.str4[1]);
    });
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
    $scope.editCompleteData = function() {
        var $muchMoneyBox = $('#modify').children('div.leiGe');
        var jsonMonth = [];
        var jsonMoney = {};
        // var jsonGiveMonth = {};
        $scope.jsonGiveTime = {};
        var jsonDis = {};
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
                    $scope.jsonGiveTime[cabinet_month] = null;
                }else {
                    $scope.jsonGiveTime[cabinet_month] = give_value + give_type;
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
        return {
            cabinetModel   : $scope.editCabinetSize,
            cabinetType    : $scope.editCabinetType,
            deposit        : $('#editCabinetDeposit555').val(),
            cabinetId      : $scope.editCabinetId,
            monthRentPrice : $scope.editOneMonthPrice,
            yearRentPrice  : $scope.editOneYearPrice,
            // giveMonth      : jsonGiveMonth != undefined && jsonGiveMonth != '' ? jsonGiveMonth : null,  //多月设置赠送月数
            giveMonth      : $scope.jsonGiveTime ? $scope.jsonGiveTime : null,  //多月设置赠送月数
            cabinetMonth   : jsonMonth != undefined && jsonMonth != '' ? jsonMonth : null,    //多月设置月份
            cabinetMoney   : jsonMoney != undefined && jsonMoney != '' ? jsonMoney : null,  //多月设置金额
            cabinetDis     : jsonDis   != undefined && jsonDis   != '' ? jsonDis   : null,  // 多月设置折扣
            _csrf_backend  : $('#_csrf').val() //csrf防止跨站
        }
    };
    $scope.isClick = false;
    angular.element(document).ready(function () {
        $scope.isClick = true;
        //未绑定用户时显示
        $scope.editComplete = function() {
            /**
             * @获取多月设置的值
             **/
            if($scope.editCabinetSize == null || $scope.editCabinetSize == '' || $scope.editCabinetSize == undefined) {
                Message.warning("请选择柜子型号!");
                return;
            }
            if($scope.editCabinetType == null || $scope.editCabinetType == '' || $scope.editCabinetType == undefined) {
                Message.warning("请选择柜子类型!");
                return;
            }
            if($scope.editCabinetType == '2') {
                if($('#editCabinetDeposit555').val() == '') {
                    Message.warning("请输入柜子押金!");
                    return;
                }
            }
            if($scope.editOneMonthPrice == null || $scope.editOneMonthPrice == '' || $scope.editOneMonthPrice == undefined) {
                Message.warning("请输入单月金额!");
                return;
            }
            $scope.editCompleteData();
            console.log($scope.editCompleteData())
            $scope.editCompleteFlag = true;
            var type = $('#isBind').attr('data-type');
            var page = $('#isBind').attr('data-page');
            $http({
                url: "/cabinet/cabinet-update",
                method: 'POST',
                data: $.param($scope.editCompleteData()),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            }).then(function(result) {
                if(result.data.status == "success") {
                    $scope.editCompleteFlag = false;
                    Message.success(result.data.data);
                    window.history.go(-1);
                    // $scope.editCabinetInit();
                    // $scope.searchClass();
                    // $('#revise').modal('hide'); //执行关闭模态框
                    // $('#boundCabinet').modal('hide');
                    if(type == 'isBind'){
                        // $('#boundCabinet').modal('show');
                    }else{
                        // $('#noBoundCabinet').modal('show');
                    }
                    // console.log('page',page);
                    if(page == 'matrix'){
                        $scope.searchClass(60);
                    }else{
                        // $scope.searchClass();
                    }
                    // $scope.getDate($scope.statusList);
                } else {
                    Message.warning(result.data.data);
                    $scope.editCompleteFlag = false;
                }
            });

        };
    });
    $scope.init3();
})
