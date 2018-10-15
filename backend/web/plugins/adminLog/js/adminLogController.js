$(function(){
    $('#adminLogDate').daterangepicker(null, function(start, end, label) {});
});
angular.module('App').controller('adminLogCtrl', function($scope,$http){


    // 清空搜索
    $scope.searchClear = function () {
        $scope.clearData();
        $scope.init();
    };
    $scope.clearData = function () {
        $scope.keywords = null;
        $scope.adminLogStartDate   = '';
        $scope.adminLogEndDate     = '';
        $('#adminLogDate').val("");
    }
    //初始化方法
    $scope.init  = function () {

        $scope.initPaths();                 //获取路径
        $scope.getLogAllInfo();              //查询所有订单
    };
    //连接后台查询日志信息
    $scope.getLogAllInfo = function () {
        $.loading.show();
        $http.get($scope.pageInitUrl).then(function (result) {
            if(result.data.data != undefined && result.data.data != ""){
                $scope.itemsLength = result.data.data.length;
                $scope.items = result.data.data;                    //数据
                //console.log($scope.items);
                $scope.pages = result.data.pages;                   //分页
                $scope.dataInfo = false;                           //没有数据时的样式
                $scope.itemsAllMoney = result.data.sum;
            }else{
                $scope.itemsLength = result.data.data.length;
                $scope.items = result.data.data;
                $scope.pages = result.data.pages;
                $scope.dataInfo = true;
                $scope.itemsAllMoney = result.data.sum;
            }
            $.loading.hide();
        });
    };

    //定义公共路径方法
    $scope.initPaths = function () {
        $scope.params =  $scope.searchLogData();                               //接收数据
        $scope.pageInitUrl = '/admin-log/get-admin-log-list?'+$.param($scope.params);   //后台路径
    };

    //添加搜索页数
    $scope.skipPage = function(value){
        if(value != undefined){
            // $scope.pageInitUrl = '/user/member-info?page='+value;
            $scope.params =  $scope.searchLogData();
            $scope.pageInitUrl = '/admin-log/get-admin-log-list?'+$.param($scope.params) + '&page=' + value;
            $scope.getLogAllInfo();
        }
    };

    //日志信息分页
    $scope.replacementPages = function (urlPages) {
        $scope.pageInitUrl = urlPages;
        $scope.getLogAllInfo();          //再次调用后台查询
    };
    //点击搜索触发
    $scope.searchAbout = function () {
        $scope.adminLogStartDate = '';
        $scope.adminLogEndDate = '';
        if($("#adminLogDate").val() != ''){
            var startTime = $("#adminLogDate").val().substr(0, 10);
            $scope.adminLogStartDate = startTime+' '+ "00:00:00";
            var endTime = $("#adminLogDate").val().substr(-10, 10);
            $scope.adminLogEndDate  = endTime+' '+"23:59:59";
        }
        $scope.initPaths();
        $scope.getLogAllInfo();       //向后台发送数据
    };
    //回车搜索触发
    $scope.enterSearch = function (){
        var event = window.event || arguments.callee.caller.arguments[0];
        if (event.keyCode == 13)
        {
            $scope.searchAbout();
        }

    };
    //列表排序
    $scope.changeSort = function (attr,sort) {
        $scope.sortType = attr;             //排序字段
        $scope.switchSort(sort);
        $scope.searchAbout();
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
    //接收搜索条件
    $scope.searchLogData = function () {
        return {
            keywords            : $scope.keywords != undefined ? $scope.keywords : null,      //搜索框数据
            startTime           : $scope.adminLogStartDate != undefined && $scope.adminLogStartDate != '' ? $scope.adminLogStartDate : null,//开始时间
            endTime             : $scope.adminLogEndDate != undefined&& $scope.adminLogEndDate != '' ? $scope.adminLogEndDate : null,//结束时间
        }
    };
    //调用初始化方法
    $scope.init();
    //查询单条日志的信息
    $scope.getLogInfo = function (id) {
        $scope.payMoneyMode = '';
        $scope.orderId = id;
        $http.get('/admin-log/find-model?id='+id).then(function (result) {
            if(result.data != 'null' && result.data != ""){
                $scope.logInfo = result.data.data;
                console.log($scope.logInfo);
            }
        });
    };
    $scope.cancelOrder = function (id) {
        $http.get('/order/set-order-status?id='+id).then(function (result) {
            if(result.data.status == "success"){
                $scope.init();
            }
        });
    };

















});