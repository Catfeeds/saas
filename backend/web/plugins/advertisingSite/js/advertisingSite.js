/**
 * Created by Administrator on 2018/5/5 0005.
 * 手机管理 - 广告设置 - 手机广告投放设置
 */

$(document).ready(function () {
    $('select#chooseVenueSelect').select2({
        width   : '100%'
    });
    $('#advertisingGreatDate').daterangepicker(null, function(start, end, label) {

    });
    $('#advertisingDate').daterangepicker(null, function(start, end, label) {

    });

});
angular.module('App').controller('advertisingSiteCtrl',function($http,$scope,Upload){
    $scope.useStatusBtn = true;
    //获取是否启动广告
    $scope.getUseStatus = function(){
        $http.get('/advertising-site/setting').success(function(result){
            //console.log(result);
            $scope.runTypeId = result.id; //启动类型
            $scope.runStatusId = result.status; //启动类型
            //0是不启用  1是启用
            if(result.status == 0){
                $('#isSynchronization').removeClass('checked');
                $scope.useStatusBtn = true;
            }else{
                $('#isSynchronization').addClass('checked');
                $scope.useStatusBtn = false;
            }
        })
    };
    $scope.getUseStatus();
    //启动页按钮
    $scope.isSynchronization = function(){
        $.loading.show();
        $http.get('/advertising-site/set?id=' +  $scope.runTypeId + '&status=' + $scope.runStatusId).success(function(result){
            //console.log(result);
            if(result.status == 'success'){
                Message.success(result.message);
                $scope.getUseStatus();
                $scope.initPath();                 //路径初始化
                $scope.getAdvertisingList();       //列表初始化
                $.loading.hide();
            }
        });
    };
    //日期事件
    $scope.dateInit = function(){
        $scope.greatStartDate = '';
        $scope.greatEndDate = '';
        if($("#advertisingGreatDate").val() != ''){
            var startTime = $("#advertisingGreatDate").val().substr(0, 10);
            $scope.greatStartDate = startTime+' '+ "00:00:00";
            var endTime = $("#advertisingGreatDate").val().substr(-10, 10);
            $scope.greatEndDate  = endTime+' '+"23:59:59";
        }
    };
    //初始化获取当月的第一天和最后一天
    $scope.getMonthOneAndMonthLast = function(){
        var date = new Date();
        $scope.greatStartDate =$scope.getMyDate(date.setDate(1));
        var currentMonth=date.getMonth();
        var nextMonth=++currentMonth;
        var nextMonthFirstDay=new Date(date.getFullYear(),nextMonth,1);
        var oneDay=1000*60*60*24;
        $scope.greatEndDate = $scope.getMyDate(nextMonthFirstDay-oneDay);
        $('#advertisingGreatDate').val($scope.greatStartDate+' - '+ $scope.greatEndDate);
    };
    //时间戳转换为年月日
    $scope.getMyDate = function(str){
        str = parseInt(str);
        if(str!=""||str!=null){
            var oDate = new Date(str);
            var oYear = oDate.getFullYear();
            var oMonth = oDate.getMonth()+1;
            oMonth = oMonth>=10? oMonth:'0'+oMonth;
            var oDay = oDate.getDate();
            oDay = oDay>=10? oDay:'0'+oDay;
            var theDate = oYear+"-"+oMonth+"-"+oDay;
        }else{
            theDate = "";
        }
        return theDate
    };
    //初始化数据
    $scope.init = function(){
        $scope.getMonthOneAndMonthLast();  //日期初始化
        $scope.initPath();                 //路径初始化
        $scope.getAdvertisingList();       //列表初始化
    };

    /***********首页搜索按钮事件********/
    //搜索准备参数
    $scope.searchAdvertisingData = function(){
        return{
            start    : $scope.greatStartDate != undefined && $scope.greatStartDate != '' ? $scope.greatStartDate : null,//开始时间
            end      : $scope.greatEndDate   != undefined && $scope.greatEndDate   != '' ? $scope.greatEndDate : null,//结束时间
            keywords : $scope.searchKeyword  != undefined && $scope.searchKeyword  != '' ? $scope.searchKeyword : null,//关键字
            sortType : $scope.sortType != undefined ? $scope.sortType : null,      //排序字段
            sortName : $scope.sort     != undefined ? $scope.sort : null,           //排序状态
        }
    };
    //初始化路径
    $scope.initPath = function(){
        $scope.initUrl = '/advertising-site/list?' + $.param($scope.searchAdvertisingData());
    };
    //获取列表
    $scope.getAdvertisingList = function(){
        $.loading.show();
        $http.get($scope.initUrl).success(function(result){
            //console.log(result);
            if(result.data != undefined && result.data != ''){
                $scope.advertisingList = result.data;
                $scope.advertisingNoData = false;
                $scope.advertisingPage = result.pages;
            }else{
                $scope.advertisingList = result.data;
                $scope.advertisingNoData = true;
                $scope.advertisingPage = result.pages;
            }
            $.loading.hide();
        })
    };
    $scope.init();
    //搜索按钮
    $scope.searchBtn = function(){
        $scope.dateInit();
        //console.log($scope.greatStartDate, $scope.greatEndDate);
        $scope.initPath();
        $scope.getAdvertisingList();
    };
    //回车搜索触发
    $scope.enterSearch = function (){
        var event = window.event || arguments.callee.caller.arguments[0];
        if (event.keyCode == 13) {
            $scope.searchBtn();
        }
    };
    //分页事件
    $scope.replacementPages = function(url){
        $scope.initUrl = url;
        $scope.getAdvertisingList();
    };
    //清空按钮
    $scope.clearBtn = function(){
        $scope.searchKeyword = '';
        $scope.init();
    };
    //列表排序
    $scope.changeSort = function (attr,sort) {
        $scope.sortType = attr;             //排序字段
        $scope.switchSort(sort);
        $scope.searchBtn();
    };
    //处理正序、倒序
    $scope.switchSort = function (sort) {
        if(!sort){
            sort = 'DES';
        }else if(sort == 'DES'){
            sort = 'ASC';
        }else{
            sort = 'DES'
        }
        $scope.sort = sort;             //排序状态
    };
    /*********1.新建广告开始********/
    //新建广告
    $scope.addAdvertisingBtn = function(){
        $('#addAdvertisingModal').modal('show');
    };
    //新建广告参数
    $scope.addAdvertisingData = function(){
        return{
            name :   $scope.advertisingName != undefined && $scope.advertisingName != '' ? $scope.advertisingName : null, //广告名称
            note :   $scope.advertisingNote != undefined && $scope.advertisingNote != '' ? $scope.advertisingNote : null, //广告备注
            _csrf_backend : $('#_csrf').val()
        }
    };
    $scope.addSuccessBtn = function(){
        if($scope.advertisingName == '' || $scope.advertisingName == undefined){
            Message.warning('请输入广告名称');
            return
        }
        $http({
            url:'/advertising-site/add',
            method:'POST',
            data:$.param($scope.addAdvertisingData()),
            headers    : { 'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.data);
                $('#addAdvertisingModal').modal('hide');
                $scope.initPath();
                $scope.getAdvertisingList();
            }else{
                Message.warning(result.data.data);
                $('#addAdvertisingModal').modal('hide');
            }
        })
    };
    //新建模态框关闭事件
    $('#addAdvertisingModal').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.advertisingName = '';
        $scope.advertisingNote = '';
    });
    /*********新建广告结束********/
   

    /*********2.编辑事件开始********/
    //编辑广告
    $scope.redactAdvertisingBtn = function(id,object){
        $('#redactAdvertisingModal').modal('show');
        $scope.advertisingId = id; //广告id
        $scope.getVenueList();     //获取场馆
        //console.log(object);
        //海报链接
        $scope.imgLink = object.photo;
        //是否跳过按钮状态  1为可跳过  0为不跳过
        if(object.is_over == 1){
            $('#jumpStatus').removeClass('checked');
            $scope.jump = 1;
        }else{
            $('#jumpStatus').addClass('checked');
            $scope.jump = 0;
        }
        //展示秒数
        $('#numSecond').val(object.show_time);
        //跳转链接
        $scope.crossLink = object.url;
        //有效期展示
        function timestampToTime(timestamp) {
            var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
            Y = date.getFullYear() + '-';
            M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
            D = date.getDate() < 10 ? '0' + date.getDate() : date.getDate() + '';
            return Y+M+D;
        }
        if(object.start != 0 && object.end != 0){
            $('#advertisingDate').val(timestampToTime(object.start) + ' - ' + timestampToTime(object.end));//有效期限
        }else{
            $('#advertisingDate').val();
        }
        //投放场馆
        if(object.venue_ids != null){
            var arr1 = [];
            angular.fromJson(object.venue_ids).map(function(item,i){
                //console.log(item);
                arr1.push(item.venue);
                $scope.venueArr = arr1;
                //console.log( $scope.venueArr)
            });
        }else{
            $scope.venueArr = [];
        }
    };
    //上传照片
    $scope.setCover5 = function (file) {
        if(file) {
            if(file.size >=2000000){
                swal('上传图片不能大于2M，请重试！', '', 'error');
            }else{
                $scope.setPic5(file);
            }
        }
    };
    //发送图片
    $scope.setPic5 = function (file) {
        Upload.upload({
            url    : '/class/upload',
            method :'POST',
            data   : {UploadForm: {imageFile: file}, _csrf_backend: $('#_csrf').val()},
            headers     : { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function (results) {
            if(results.data.status == 'success'){
                $scope.imgLink = results.data.imgLink;
            }
        });
    };
    //根据账号权限获取场馆列表
    $scope.getVenueList = function(){
        $http({
            url:"/advertising-site/venue",
            method:"GET"
        }).then(function(data){
            $scope.venueItems = data.data;
        })
    };
    //编辑模态框选择场馆事件
    $scope.venueArrChange = function(arr){
        $scope.venueArr = arr;
    };
    $scope.num = 1;
    //是否跳过按钮  1为可跳过  0为不跳过  初始化为1
    $scope.jump = 1;
    $scope.jumpStatus = function(){
        $scope.num ++;
        //console.log($scope.num % 2)
        if($scope.num % 2 == 0){
            $('#jumpStatus').addClass('checked');
            $scope.jump = 0;
        }else{
            $('#jumpStatus').removeClass('checked');
            $scope.jump = 1;
        }
    };
    //编辑模态框日期事件
    $scope.redactDate = function(){
        $scope.advertisingStartDate = '';
        $scope.advertisingEndDate = '';
        if($("#advertisingDate").val() != ''){
            var startTime = $("#advertisingDate").val().substr(0, 10);
            $scope.advertisingStartDate = startTime+' '+ "00:00:00";
            var endTime = $("#advertisingDate").val().substr(-10, 10);
            $scope.advertisingEndDate  = endTime+' '+"23:59:59";
        }
    };
    //编辑参数传递
    $scope.redactInfo = function () {
        return{
            advId     : $scope.advertisingId        != undefined && $scope.advertisingId        != '' ? $scope.advertisingId : null,//广告ID
            photo     : $scope.imgLink              != undefined && $scope.imgLink              != '' ? $scope.imgLink : null,//海报链接
            is_over   : $scope.jump,//是否跳过
            show_time : $('#numSecond').val()       != undefined && $('#numSecond').val()       != '' ? $('#numSecond').val() : null,//默认展示秒数
            start     : $scope.advertisingStartDate != undefined && $scope.advertisingStartDate != '' ? $scope.advertisingStartDate : null,//开始时间
            end       : $scope.advertisingEndDate   != undefined && $scope.advertisingEndDate   != '' ? $scope.advertisingEndDate : null,//结束时间
            url       : $scope.crossLink            != undefined && $scope.crossLink            != '' ? $scope.crossLink : '',//跳转链接
            venue_ids : $scope.venueArr             != undefined && $scope.venueArr             != '' ? $scope.venueArr : null,//场馆数组
            _csrf_backend : $('#_csrf').val()
        }
    };
    //编辑完成按钮
    $scope.redactSuccessBtn = function(){
        $scope.redactDate();
        //console.log( $scope.advertisingStartDate,$scope.advertisingEndDate);
        //console.log( $scope.jump);
        if($scope.imgLink == '' || $scope.imgLink == undefined || $scope.imgLink == null){
            Message.warning('请上传海报');
            return
        }
        if( $scope.jump == undefined || $scope.jump == null){
            Message.warning('请选择是否跳过');
            return
        }
        if( $('#numSecond').val() == '' ||  $('#numSecond').val() == undefined ||  $('#numSecond').val() == null || $('#numSecond').val() == 0){
            Message.warning('请输入展示秒数');
            return
        }
        if ($scope.crossLink != '' && $scope.crossLink != null && $scope.crossLink != undefined) {
            var match = /^((ht|f)tps?):\/\/[\w\-]+(\.[\w\-]+)+([\w\-\.,@?^=%&:\/~\+#]*[\w\-\@?^=%&\/~\+#])?$/;
            if(!match.test($scope.crossLink)){
                Message.warning('请输入以http或https开头的链接');
                return
            }
        }

        if($("#advertisingDate").val() == '' || $("#advertisingDate").val() == undefined || $("#advertisingDate").val() == null){
            Message.warning('请选择有效期');
            return
        }
        if($scope.venueArr == undefined || $scope.venueArr == null || $scope.venueArr == ''){
            Message.warning('请选择投放场馆');
            return
        }
        if($scope.venueArr.length > 1 && $scope.venueArr.indexOf('0') == 0){
            Message.warning('所有场馆已经包含全部场馆，请勿重复选择');
            return
        }
        //console.log($scope.redactInfo());
        $http({
            url:'/advertising-site/edit',
            method:'POST',
            data:$.param($scope.redactInfo()),
            headers    : { 'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.data);
                $('#redactAdvertisingModal').modal('hide');
                $scope.initPath();
                $scope.getAdvertisingList();
            }else{
                Message.warning(result.data.data);
                $('#redactAdvertisingModal').modal('hide');
            }
        })

    };

    //编辑模态框关闭事件
    $('#redactAdvertisingModal').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.imgLink = '';
        $('#jumpStatus').removeClass('checked');
        $('#numSecond').val('');
        $('#advertisingDate').val('');
        $scope.crossLink = '';
        //$scope.venueArr = '';
    });
    /************编辑事件结束************/

    /************3.广告详情事件开始************/
    //广告详情
    $scope.advertisingDetailBtn = function(id){
        $('#advertisingDetailModal').modal('show');
        $.loading.show();
        $http.get('/advertising-site/record?id=' + id).success(function(result){
            //console.log(result)
            if(result != undefined && result != ''){
                $scope.advertisingDetailList = result;
                $scope.advertisingDetailNoData = false;
            }else{
                $scope.advertisingDetailList = result.data;
                $scope.advertisingDetailNoData = true;
            }
            $.loading.hide();
        })
    };
    /************广告详情事件结束************/

    /*******启用停用功能********/
    $scope.startUse = function(id,object){
        //console.log(object)
        if(object.start == 0 || object.end == 0){
            Message.warning('请先编辑广告内容');
            return
        }
        swal({
            title: "确定启用吗？",
            text: "该广告将被投放使用！",
            timer: 3000,
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
                $http.get('/advertising-site/run?id=' + id).then(function (result) {
                    //console.log(result);
                    if(result.data.status == 'success'){
                        swal(result.data.message, "", "success");
                        $scope.initPath();
                        $scope.getAdvertisingList();
                    }else{
                        swal(result.data.message, "", "error");
                    }
                });
            } else {
                swal.close();
            }
        });
    };
    /*******停用停用功能********/
    $scope.stopUse = function(id){
        swal({
            title: "确定停用吗？",
            text: "该广告将被停用！",
            timer: 2000,
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
                $http.get('/advertising-site/stop?id=' + id).then(function (result) {
                    if(result.data.status == 'success'){
                        swal(result.data.message, "", "success");
                        $scope.initPath();
                        $scope.getAdvertisingList();
                    }else{
                        swal(result.data.message, "", "error");
                    }
                });
            } else {
                swal.close();
            }
        });
    };
    /*******删除功能********/
    $scope.deleteOne = function(id){
        swal({
            title: "确定删除吗？",
            text: "该广告将被删除！",
            timer: 2000,
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
                $http.get('/advertising-site/delete?id=' + id).then(function (result) {
                    //console.log(result);
                    if(result.data.status == 'success'){
                        swal(result.data.message, "", "success");
                        $scope.initPath();
                        $scope.getAdvertisingList();
                    }else{
                        swal(result.data.message, "", "error");
                    }
                });

            } else {
                swal.close();
            }
        });
    };

});

