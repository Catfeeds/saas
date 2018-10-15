var app = angular.module('App').controller('CabinetTypeCtrl', function($scope, $http, $location, $rootScope, $interval) {
    $scope.str = window.location.href.split('?');
    $scope.str2 = $scope.str[1].split('&');
    $scope.str3 = $scope.str2[0].split('=');
    $scope.str4 = $scope.str2[1].split('=');
    $('.group-ul').height($(window).height()-145 + 'px');
    $('.detialS').height($(window).height()-173 + 'px');
    $('.pp').height($(window).height()-173 + 'px');
    $('.vv').height($(window).height()-173 + 'px');
    $('.nn').height($(window).height()-207 + 'px');
    $('.nn').css('overflow-y', 'auto');
    //柜子类型管理列表
    $scope.isShow = false;
    $scope.getCabinetTypeLister = function(){
        $http.get('/cabinet/get-all-cabinet-type?cabinetTypeId=' + $scope.str3[1]).success(function(data){
            var large  = data.large;
            var middle = data.middle;
            var small  = data.small;
            $scope.lf = large.form.length;
            $scope.lt = large.temp.length;
            $scope.mf = middle.form.length;
            $scope.mt = middle.temp.length;
            $scope.sf = small.form.length;
            $scope.st = small.temp.length;
            if($scope.lf != 0){
                $scope.largeFormCount   = $scope.lf;
                $scope.largeFormNumber  = large.form[0].cabinet_number + " - " + large.form[$scope.lf - 1].cabinet_number;
                $scope.largeFirstNumber = large.form[0].cabinet_number;
                $scope.largeFormMoney   = large.form[0].monthRentPrice;
                $scope.largeFormDeposit = large.form[0].deposit;
                $scope.largeFormId      = large.form[0].id;
                $.grep(large.form, function(v,k){
                    if(v.status == 2){
                        $scope.largeFormStatus = 2;
                    }
                });
            }
            if($scope.lt != 0){
                $scope.largeTempCount  = $scope.lt;
                $scope.largeTempNumber = large.temp[0].cabinet_number + " - " + large.temp[$scope.lt - 1].cabinet_number;
                $scope.largeScondNumber= large.temp[0].cabinet_number;
                $scope.largeTempId     = large.temp[0].id;
                $.grep(large.temp, function(v,k){
                    if(v.status == 2){
                        $scope.largeTempStatus = 2;
                    }
                });
            }
            if($scope.mf != 0){
                $scope.MidFormCount   = $scope.mf;
                $scope.MidFormNumber  = middle.form[0].cabinet_number + " - " + middle.form[$scope.mf - 1].cabinet_number;
                $scope.MidFirstNumber = middle.form[0].cabinet_number;
                $scope.MidFormMoney   = middle.form[0].monthRentPrice;
                $scope.MidFormDeposit = middle.form[0].deposit;
                $scope.MidFormId      = middle.form[0].id;
                $.grep(middle.form, function(v,k){
                    if(v.status == 2){
                        $scope.MidFormStatus = 2;
                    }
                });
            }
            if($scope.mt != 0){
                $scope.MidTempCount   = $scope.mt;
                $scope.MidTempNumber  = middle.temp[0].cabinet_number + " - " + middle.temp[$scope.mt - 1].cabinet_number;
                $scope.MidScondNumber = middle.temp[0].cabinet_number;
                $scope.MidTempId      = middle.temp[0].id;
                $.grep(middle.temp, function(v,k){
                    if(v.status == 2){
                        $scope.MidTempStatus = 2;
                    }
                });
            }
            if($scope.sf != 0){
                $scope.smallFormCount  = $scope.sf;
                $scope.smallFormNumber = small.form[0].cabinet_number + " - " + small.form[$scope.sf - 1].cabinet_number;
                $scope.smallFirstNumber= small.form[0].cabinet_number;
                $scope.smallFormMoney  = small.form[0].monthRentPrice;
                $scope.smallFormDeposit= small.form[0].deposit;
                $scope.smallFormId     = small.form[0].id;
                $.grep(small.form, function(v,k){
                    if(v.status == 2){
                        $scope.smallFormStatus = 2;
                    }
                });
            }
            if($scope.st != 0){
                $scope.smallTempCount  = $scope.st;
                $scope.smallTempNumber = small.temp[0].cabinet_number + " - " + small.temp[$scope.st - 1].cabinet_number;
                $scope.smallScondNumber= small.temp[0].cabinet_number;
                $scope.smallTempId     = small.temp[0].id;
                $.grep(middle.temp, function(v,k){
                    if(v.status == 2){
                        $scope.smallTempStatus = 2;
                    }
                });
            }
        });
    };
    //新增1229
    $scope.init2 =function () {
        $scope.num = 0;
        $scope.addMoresMothHtml = '';
        $scope.btnAddMoreMonth();
    }
    $scope.btnAddMoreMonth = function() {
        $scope.htmlAttr = 'addCabinetMonth';
        $scope.num  = $scope.num + 1;
        $http.get('/rechargeable-card-ctrl/add-venue?attr='+$scope.htmlAttr+'&num='+$scope.num).then(function (result) {
            $scope.addMoresMothHtml = result.data.html;
        });
    };
    //修改
    $scope.modifyGiveType = 'd';
    $scope.CabinetTypeModify = function(id, count, number, model, type){
        console.log(type);
        $scope.isShow = true;
        $.loading.show();
        $scope.modifyCabinetPrefix   = number.match(/\D+/)[0];
        $scope.modifyCabinetNumStart = number.match(/\d+/)[0];
        $scope.modifyCabinetNum      = count;
        $scope.modifyCabinetSize     = model;
        $scope.modifyCabinetType1     = type;
        console.log($scope.modifyCabinetType1)
        $scope.$id                   = id;
        $scope.oldCabinetType 		 = type;
        $http.get('/cabinet/get-cabinet-type-detail?cabinetId=' + id).success(function(data){
            if(data.status == 'ok'){
                $scope.modifyHalfMonthMoney = parseFloat(data.data.monthRentPrice);
                $scope.modifyCabinetDeposit = parseFloat(data.data.deposit);
                if(data.data.cabinet_type == 2 && data.data.cabinet_month !== null && data.data.cabinet_month !== undefined && data.data.cabinet_month !== ''){
                    var cm  = angular.fromJson(data.data.cabinet_month);
                    var cmy = angular.fromJson(data.data.cabinet_money);
                    var md  = angular.fromJson(data.data.cabinet_dis);
                    var gm  = angular.fromJson(data.data.give_month);
                    if(cm == null || cm == '' || cm == undefined || cmy == null || cmy == '' || cmy == undefined || md == null || md == '' || md == undefined || gm == null || gm == '' || gm == undefined) {
                        //
                    }else {
                        $scope.modifyMuchMonth      = parseInt(cm[0]) ? parseInt(cm[0]) : '';
                        $scope.modifyCabinetMoney   = parseFloat(cmy[cm[0]]) ? parseFloat(cmy[cm[0]]) : '';
                        if(gm[cm[0]].match(/^(\d+)(d|m)$/) !== null && gm[cm[0]].match(/^(\d+)(d|m)$/) !== undefined) {
                            $scope.modifyGiveType       = gm[cm[0]].match(/^(\d+)(d|m)$/)[2] ? gm[cm[0]].match(/^(\d+)(d|m)$/)[2] : 'd' ;
                            $scope.modifyGiveMonth      = gm[cm[0]].match(/^(\d+)(d|m)$/)[1] ? gm[cm[0]].match(/^(\d+)(d|m)$/)[1] : '' ;
                        }
                        $scope.modifyDis            = md[cm[0]] ? md[cm[0]] : '';
                        var $max = cm.length;
                        var i = 0;
                        for(var n = 1; n < $max; n++){
                            $scope.htmlAttr = 'addCabinetMonth';
                            $scope.num  = $scope.num + 1;
                            $http.get('/rechargeable-card-ctrl/add-venue?attr='+$scope.htmlAttr+'&num='+$scope.num).then(function (result) {
                                var $html = result.data.html;
                                var $dom = $($html).get(0);
                                i++;
                                $($dom).find('input[name="cabinet_month"]').val(parseInt(cm[i]));
                                $($dom).find('input[name="cabinet_money"]').val(parseFloat(cmy[cm[i]]));
                                $($dom).find('input[name="cabinet_dis"]').val(md[cm[i]]);
                                if(!gm[cm[i]].match(/^(\d+)(d|m)$/)) {
                                    $($dom).find('input[name="give_month"]').val(gm[cm[i]]);
                                    console.log(gm[cm[i]]);
                                    $($dom).find('select').val('m');
                                }else {
                                    $($dom).find('select').val(gm[cm[i]].match(/^(\d+)(d|m)$/)[2] ? gm[cm[i]].match(/^(\d+)(d|m)$/)[2] : '');
                                    $($dom).find('input[name="give_month"]').val(gm[cm[i]].match(/^(\d+)(d|m)$/)[1] ? gm[cm[i]].match(/^(\d+)(d|m)$/)[1] : '');
                                }
                                $('#modifyMuchPlugins').append($dom);
                            })
                        }
                    }
                }else{
                    return true;
                }
            }else{
                Message.error('系统开了会小差,请刷新重试。。。');
            }
        });
        window.setTimeout('$.loading.hide()',200);
        $scope.modifyCabinetType = '';
        $scope.modifyCabinetDeposit = '';

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
    // 柜子类型修改完成
    $scope.typeModifyComplete = function(id,count){
        //流程控制
        if(!$scope.modifyCabinetSize) {
            Message.warning("请选择柜子型号!");
            return;
        }
        if(!$scope.modifyCabinetType1) {
            Message.warning("请选择柜子类别!");
            return;
        }
        if(!$scope.modifyCabinetPrefix) {
            Message.warning("请输入柜号前缀!");
            return;
        }
        if($scope.modifyCabinetType1 == '2') {
            if(!$scope.modifyHalfMonthMoney) {
                Message.warning("请输入单月金额!");
                return;
            }
        }
        if($scope.modifyCabinetType1 == '2') {
            if(!$scope.modifyCabinetDeposit) {
                Message.warning("请输入押金金额!");
                return;
            }
        }
        //获取多月设置的值
        if($scope.modifyCabinetType1 == '2') {
            var $muchMoneyBox = $('#modifyMuchPlugins').children('div.clearfix');
            var jsonMonth = [];
            var jsonMoney = {};
            // var jsonGiveMonth = {};
            var jsonGiveTime = {};
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
                        jsonGiveTime[cabinet_month] = null;
                    }else {
                        jsonGiveTime[cabinet_month] = give_value + give_type;
                    }
                } else {
                    //如果有一条不符合就不能通过
                    notPass = true;
                    return false;
                }
            });
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
        $scope.CabinetDetailFlag = true;
        //通过柜子类别,柜子型号,柜子数量判断柜号是否和其他类别,类型的柜号重复
        $scope.getDifferent = function(){
            return {
                cabinetSize   : $scope.modifyCabinetSize,
                cabinetType   : $scope.modifyCabinetType1,
                cabinetNum    : $.trim($scope.modifyCabinetPrefix)+$.trim($scope.modifyCabinetNumStart),
                id            : id,
                cabinetTypeId : $scope.str3[1],
                _csrf_backend : yii.getCsrfToken(),
            };
        }
        //新增柜子提交的数据
        $scope.modifyCabinetData = function() {
            return {
                _csrf_backend  : yii.getCsrfToken(),
                cabinetId      : id,
                cabinetModel   : $scope.modifyCabinetSize ? $scope.modifyCabinetSize : null, //柜子型号
                cabinetType    : $scope.modifyCabinetType1 ? $scope.modifyCabinetType1 : null, //柜子类别
                cabinetNum     : count, //柜子数量
                cabinetPrefix  : $.trim($scope.modifyCabinetPrefix), //柜子前缀
                cabinetNumStart: $.trim($scope.modifyCabinetNumStart), //柜子起始号码
                cabinetTypeId  : $scope.str3[1] ? $scope.str3[1] : null, //柜子类型ID
                monthRentPrice : $scope.modifyHalfMonthMoney && $scope.modifyCabinetType1 == '2' ? $scope.modifyHalfMonthMoney : null, //单月金额
                deposit        : $scope.modifyCabinetDeposit && $scope.modifyCabinetType1 == '2' ? $scope.modifyCabinetDeposit : null, //柜子押金
                // giveMonth      : jsonGiveMonth != undefined && jsonGiveMonth != '' ? jsonGiveMonth : null,  //多月设置赠送月数
                giveMonth		   : jsonGiveTime != undefined && jsonGiveTime != '' ? jsonGiveTime :null,	//多月设置赠送类型及数量
                cabinetMonth   : jsonMonth ? jsonMonth : null,    //多月设置月份
                cabinetMoney   : jsonMoney ? jsonMoney : null,  //多月设置金额
                cabinetDis     : jsonDis ? jsonDis   : null,  // 多月设置折扣
                oldCabinetType : $scope.oldCabinetType,											//旧的柜子类型
            }
        };
        //判断柜号重复
        $http({
            method  :"POST",
            url     : "/cabinet/get-different-cabinet-number",
            data    : $.param($scope.getDifferent()),
            headers : {"Content-Type" : "application/x-www-form-urlencoded"}
        }).success(function (data){
            if(data.status == 'ok'){
                //提交
                $http({
                    method : "POST",
                    url    : "/cabinet/modify-cabinet",
                    data   : $.param($scope.modifyCabinetData()),
                    headers: {"Content-Type" : "application/x-www-form-urlencoded"}
                }).success(function(data){
                    if(data.status == 'success'){
                        Message.success(data.data);
                        $scope.CabinetDetailFlag = false;
                        $scope.getCabinetTypeLister();
                        $scope.isShow = false;
                    }else{
                        Message.error(data.data);
                    }
                });
            }else if(data.status == 'error'){
                Message.warning('柜号被占用');
                $scope.CabinetDetailFlag = false;
            }else{
                Message.error('系统开了会小差,请刷新重试。。。');
            }
        });
    };
    $scope.cancelTypeModify = function () {
        $scope.isShow = false;
    };
    //柜子类型管理详情
    $scope.showCabinetDetail = function(t,c,n,m,i,tn,cn,status){
        $.loading.show();
        $scope.cabinetXingHao        = t;
        $scope.cabinetLeiBie         = c;
        $scope.cabinetHaoMa          = n;
        $scope.cabinetShuLiang       = m;
        $scope.id                    = i;
        $scope.model                 = tn;
        $scope.type                  = cn;
        $scope.modifyStatus          = status;
        // $('#ManageDetailModal').modal('show');
        window.setTimeout('$.loading.hide()',200);
    }
    $scope.init2();
    $scope.getCabinetTypeLister();
    //类型管理批量删除
    $scope.deleteCabinetType = function(id,count) {
        console.log('-----')
        Sweety.remove({
            url              : '/cabinet/delete-cabinet-type?cabinetId=' + id + '&cabinetNum=' + count,
            http             : $http,
            title            : '确定要删除吗?',
            text             : '删除后所有信息无法恢复',
            confirmButtonText: '确定',
            data             : {
                action: 'unbind'
            }
        }, function () {
            $scope.getCabinetTypeLister();
        });
    }
})
