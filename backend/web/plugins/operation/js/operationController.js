/**
 * Created by suyu on 2017/7/19.
 */
$(function(){
    $('#memberDate').daterangepicker(null, function(start, end, label) {
    });
    $('#cardCountDate').daterangepicker(null, function(start, end, label) {
    });
    $('#classCountDate').daterangepicker(null, function(start, end, label) {
    });
    $('.cardSelectCss').select2({
        width   : '100%'
    })
});
var app = angular.module('App').controller('operationCtrl',function ($scope,$http,$timeout){

    // 载入动画的js
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('main').className += 'loaded';
    });

    // 载入动画显示1
    $scope.loderAnimateShow = function (){
        $(".loader-animate1").show();
    };

    // 载入动画显示2
    $scope.loderAnimateShow2 = function (){
        $(".loader-animate2").show();
    };

    // 载入动画显示3
    $scope.loderAnimateShow3 = function (){
        $(".loader-animate3").show();
    };

    // 载入动画显示4
    $scope.loderAnimateShow4 = function (){
        $(".loader-animate4").show();
    };

    // 载入动画关闭1
    $scope.loderAnimateHide = function (){
        $(".loader-animate1").hide();
    };

    // 载入动画关闭2
    $scope.loderAnimateHide2 = function (){
        $(".loader-animate2").hide();
    };

    // 载入动画关闭3
    $scope.loderAnimateHide3 = function (){
        $(".loader-animate3").hide();
    };

    // 载入动画关闭4
    $scope.loderAnimateHide4 = function (){
        $(".loader-animate4").hide();
    };

    // 页面加载完成后加载
    $(document).ready(function (){
        $scope.getMemberClass();
        $scope.getTotalCard();
    });
    $scope.orderStartDate = '';
    $scope.orderEndDate  = '';
    // 获取今日到店详情筛选项全部信息并遍历
    $scope.getSelectInfoList = function (){

        $scope.venueChangeId = "";

        // 获取场馆信息
        $http.get('/site/get-auth-venue').success(function (data){
            $scope.venueList = data;
        });

        // 获取销售
        $http.get('/user/get-adviser').success(function (data){
            $scope.adviserSelectList = data;
        });

        // 获取私教
        $http.get('/private-teach/employee-info').success(function (data){
            $scope.coachSelectList = data;
        });

        // 获取卡种
        $http.get('/member-card/get-type').success(function (data){
            $scope.cardSelectList = data.type;
        });

    };
    $scope.getSelectInfoList();

    // 获取今日日期
    $scope.getToday = function (){
        var today = new Date();
        var y = today.getFullYear();
        var m = today.getMonth() + 1;//获取当前月份的日期
        var d = today.getDate();
        $scope.dateInput = y+"-"+m+"-"+d;
    };
    $scope.getToday();

    // 日期插件的调用
    $("#dateIndex").datetimepicker({
        minView: "month",//设置只显示到月份
        format: 'yyyy-mm-dd',
        language: 'zh-CN',
        autoclose: true,
        todayBtn: true //今日按钮
    }).on('changeDate', function (ev) {
        $scope.venueTimeInputTop = $('#dateSpan').val();
        $scope.dateInput = $scope.venueTimeInputTop;
        $scope.orderStartDate = $scope.venueTimeInputTop;
        $scope.orderEndDate  = $scope.venueTimeInputTop;
        $("#memberDate").val($scope.venueTimeInputTop+' '+$scope.venueTimeInputTop);
        $scope.getTotalCard();//卡种统计
        $scope.getTotalEntry();//到店人数
        $scope.getMemberClass();//会员上课
    });
    // 场馆切换的触发
    $scope.venueChange = function (id){
        $('.venueSelect1').val('');
        $scope.VenueAllSelect = '';
        $scope.venueChangeId = id;
        $scope.venueTimeInputTop = $('#dateSpan').val();
        $scope.orderStartDate = $scope.venueTimeInputTop;
        $scope.orderEndDate  = $scope.venueTimeInputTop;
        $("#memberDate").val($scope.venueTimeInputTop+' '+$scope.venueTimeInputTop);
        $scope.getList();
        $scope.getTotalCard();//卡种统计
        $scope.getTotalEntry();//到店人数
        $scope.getMemberClass();//会员上课
    };
    //获取所有的场馆信息
    $scope.getAllVenueSelect = function() {
        $http.get('/rechargeable-card-ctrl/get-venue?status=card').then(function(result) {
            $scope.VenueAllSelectList = result.data.venue;
        })
    }
    $scope.getAllVenueSelect();
    //获取账号所在场馆的信息 用于右边下拉框过滤场馆
    $scope.getEmployeeVenueId = function() {
        $http.get('/personnel/employee-center').then(function(data) {
            $scope.employeeVenueId = data.data.venue_id;
        })
    }
    $scope.getEmployeeVenueId();
    //第二个下拉框选择触发
    $scope.venueChange2 = function(newid) {
        $('.venueSelect').val('');
        $scope.venueSelect = '';
        $scope.venueAllId = newid;
        $scope.venueTimeInputTop = $('#dateSpan').val();
        $scope.orderStartDate = $scope.venueTimeInputTop;
        $scope.orderEndDate  = $scope.venueTimeInputTop;
        $("#memberDate").val($scope.venueTimeInputTop+' '+$scope.venueTimeInputTop);
        $scope.getList();
        $scope.getTotalEntry();
        $scope.getTotalCard();
        $scope.getMemberClass();
    }
    //console.log($("#memberDate").val());
    //点击‘查看’，获取会员卡种与会员上课统计数据
    $scope.getList = function (){
        if($("#memberDate").val() != ''){
            var startTime = $("#memberDate").val().substr(0, 10);
            $scope.orderStartDate = startTime;
            var endTime = $("#memberDate").val().substr(-10, 10);
            $scope.orderEndDate  = endTime;
        }
        $scope.getTotalCard();
        $scope.getMemberClass();

        //console.log( $scope.orderStartDate,$scope.orderEndDate)
    };
    //日期选中事件 同步到模态框日期
    $('#memberDate').on('apply.daterangepicker', function(ev, picker){
        if($("#memberDate").val() != ''){
            var startTime = $("#memberDate").val().substr(0, 10);
            $scope.orderStartDate = startTime
            var endTime = $("#memberDate").val().substr(-10, 10);
            $scope.orderEndDate  = endTime
        }
        //卡种统计模态框日期
        $('#cardCountDate').val( $scope.orderStartDate + ' - ' + $scope.orderEndDate) ;
        //上课统计模态框日期
        $('#classCountDate').val( $scope.orderStartDate + ' - ' + $scope.orderEndDate) ;
    });
    //console.log($scope.dateInput)
    // 获取今日到店人数
    $scope.getTotalEntry = function (){
        $scope.loderAnimateShow();
        $scope.venueSelectValue1 = $('.venueSelect1').val();
        if($scope.venueSelectValue1 == null || $scope.venueSelectValue1 == ''|| $scope.venueSelectValue1 == undefined) {
            $http.get("/site/entry-num?date=" + $scope.dateInput  + "&venueId=" + $scope.venueChangeId+ '&anotherVenue=').success(function (data){
                $scope.allPeopleNum = data.all;
                $scope.todayPeopleNum = data.allNum;
                $scope.todayManNum = data.menNum;
                $scope.todayWomanNum = data.womenNum;
                // 应用方法
                chartShop();
                $scope.loderAnimateHide();
            })
        }else {
            $http.get("/site/entry-num?date=" + $scope.dateInput  + "&venueId=" + '&anotherVenue=' + $scope.venueAllId).success(function (data){
                $scope.allPeopleNum = data.all;
                $scope.todayPeopleNum = data.allNum;
                $scope.todayManNum = data.menNum;
                $scope.todayWomanNum = data.womenNum;
                // 应用方法
                chartShop();
                $scope.loderAnimateHide();
            })
        }

    };
    $scope.getTotalEntry();
    $scope.applyUrl = '/site/entry-record?date=';
    // 获取到店人数详情
    $scope.getMemberDetail = function (){
        $scope.venueSelectValue1 = $('.venueSelect1').val();
        if($scope.venueSelectValue1 == null || $scope.venueSelectValue1 == ''|| $scope.venueSelectValue1 == undefined) {
            $scope.loderAnimateShow4();
            $http.get($scope.applyUrl + $scope.dateInput + "&venueId=" + $scope.venueChangeId+ '&anotherVenue=').success(function (data){
                $scope.sortData = data;
                $scope.allPNum = data.total;
                if (data.length == 0||data.data == ""||data.data == null||data.data == undefined){
                    $scope.memberDetailList = data.data;
                    $scope.groupNoDataShow = true;
                    $scope.pages    = data.pages;
                    $scope.loderAnimateHide4();
                }
                else {
                    $scope.memberDetailList = data.data;
                    $scope.groupNoDataShow = false;
                    $scope.pages    = data.pages;
                    $scope.nowPage    = data.now;
                    $scope.loderAnimateHide4();
                }
            })
        }else {
            $scope.loderAnimateShow4();
            $http.get($scope.applyUrl + $scope.dateInput + "&venueId=" + '&anotherVenue=' +  $scope.venueAllId).success(function (data){
                $scope.sortData = data;
                $scope.allPNum = data.total;
                if (data.length == 0||data.data == ""||data.data == null||data.data == undefined){
                    $scope.memberDetailList = data.data;
                    $scope.groupNoDataShow = true;
                    $scope.pages    = data.pages;
                    $scope.loderAnimateHide4();
                }
                else {
                    $scope.memberDetailList = data.data;
                    $scope.groupNoDataShow = false;
                    $scope.pages    = data.pages;
                    $scope.nowPage    = data.now;
                    $scope.loderAnimateHide4();
                }
            })
        }

    };
    // 排序
    $scope.changeSort = function (attr,sort){
        $scope.sortType = attr;
        $scope.switchSort(sort);
        $scope.searchDataPath();
    };
    $scope.switchSort = function (sort){
        if(!sort){
            sort = 'DES';
        }else if(sort == 'DES'){
            sort = 'ASC';
        }else{
            sort = 'DES'
        }
        $scope.sort = sort;
    };
    // 排序到店人数详情
    $scope.getMemberDetailData = function (){
        $.loading.show();
        $http.get($scope.applySUrl).success(function (data){
            $scope.sortData = data;
            $scope.allPNum = data.total;
            if (data.length == 0||data.data == ""||data.data == null||data.data == undefined){
                $scope.memberDetailList = data.data;
                $scope.groupNoDataShow = true;
                $scope.pages    = data.pages;
            }
            else {
                $scope.memberDetailList = data.data;
                $scope.groupNoDataShow = false;
                $scope.pages    = data.pages;
                $scope.nowPage    = data.now;
            }
            $.loading.hide();
        })
    };
    $scope.searchSortData = function (){
        return {
            sortType       : $scope.sortType  != undefined  ? $scope.sortType  : null,
            sortName       : $scope.sort      != undefined  ? $scope.sort      : null,
            date           : $scope.dateInput != undefined  ? $scope.dateInput : null
        }
    };
    $scope.initSortPath = function (){
        $scope.searchParams = $scope.searchSortData();
        $scope.applySUrl =  '/site/entry-record?' + $.param($scope.searchParams) + "&venueId=" + $scope.venueChangeId + '&anotherVenue=' + $scope.venueAllId;
    };
    $scope.searchDataPath = function () {
        // $scope.searchCarding = true;
        $scope.initSortPath();
        $scope.getMemberDetailData();
    };

    // 分页
    $scope.replacementPages = function (urlPages) {
        $scope.applySUrl = urlPages;
        $scope.getMemberDetailData();
    };

    $scope.totalCardList1 = [];
    $scope.totalCardList2 = [];

    /**筛选事件**/

    // 回车事件
    $scope.enterSearchPeopleNumber = function (e){
        var keycode = window.event?e.keyCode:e.which;
        if(keycode==13){
            $scope.searchBtn();
        }
    };

    // 设置默认时间
    $("#memberDate").val($scope.dateInput);
    $("#addUserReservation").val($scope.dateInput);
    $('#peopleNumModal').on('shown.bs.modal', function () {
        $("#addUserReservation").val($scope.dateInput);
    });
    $scope.searchBtn = function (){
        if($scope.keywordPeopleDel == undefined){$scope.keywordPeopleDel = ''}
        var  startTime = $("#addUserReservation").val().substr(0, 10);
        startTime = startTime
        var  endTime   = $("#addUserReservation").val().substr(-10, 10);
        endTime   = endTime
        if($scope.sexSelect == undefined){
            $scope.sexSelect = "";
        }
        if($scope.adviserSelect == undefined){
            $scope.adviserSelect = "";
        }
        if($scope.coachSelect == undefined){
            $scope.coachSelect = "";
        }
        if($scope.cardSelect == undefined){
            $scope.cardSelect = "";
        }
        if($scope.viceMember == undefined){
            $scope.viceMember = "";
        }
        if($scope.venueAllId == undefined){
            $scope.venueAllId = "";
        }
        if(
            $("#addUserReservation").val() == ""||
            $("#addUserReservation").val() == undefined||
            $("#addUserReservation").val() == null
        ){
            $.loading.show();
            $http.get($scope.applyUrl + $scope.dateInput + "&sex=" + $scope.sexSelect + "&sellId=" + $scope.adviserSelect + "&coachId=" + $scope.coachSelect + "&cardId=" + $scope.cardSelect + "&viceMember=" + $scope.viceMember + "&keywords=" + $scope.keywordPeopleDel + "&venueId=" + $scope.venueChangeId + '&anotherVenue=' + $scope.venueAllId).success(function (data){
                $scope.allPNum = data.total;
                $scope.sortData = data;
                if (data.length == 0||data.data == ""||data.data == null||data.data == undefined){
                    $scope.memberDetailList = data.data;
                    $scope.groupNoDataShow = true;
                    $scope.pages    = data.pages;
                    $scope.loderAnimateHide4();
                }
                else {
                    $scope.memberDetailList = data.data;
                    $scope.groupNoDataShow = false;
                    $scope.pages    = data.pages;
                    $scope.nowPage    = data.now;
                    $scope.loderAnimateHide4();
                }
                $.loading.hide();
            })
        }
        else {
            $.loading.show();
            $http.get("/site/entry-record?sex=" + $scope.sexSelect
                + "&sellId=" + $scope.adviserSelect
                + "&coachId=" + $scope.coachSelect
                + "&cardId=" + $scope.cardSelect
                + "&viceMember=" + $scope.viceMember
                + "&keywords=" + $scope.keywordPeopleDel
                + "&startTime=" + startTime
                + "&endTime=" + endTime
                + "&venueId=" + $scope.venueChangeId
                + '&anotherVenue=' + $scope.venueAllId).success(function (data){
                $scope.sortData = data;
                $scope.allPNum = data.total;
                if (data.length == 0||data.data == ""||data.data == null||data.data == undefined){
                    $scope.memberDetailList = data.data;
                    $scope.groupNoDataShow = true;
                    $scope.pages    = data.pages;
                    $scope.loderAnimateHide4();
                }
                else {
                    $scope.memberDetailList = data.data;
                    $scope.groupNoDataShow = false;
                    $scope.pages    = data.pages;
                    $scope.nowPage    = data.now;
                    $scope.loderAnimateHide4();
                }
                $.loading.hide();
            })
        }
    };

    // 清空筛选条件
    $scope.searchClearBtn = function (){
        $("#addUserReservation").val("");
        $scope.search333     = "";       //清空搜索
        $scope.sexSelect     = "";       //清空性别
        $scope.adviserSelect = "";       //清空顾问
        $scope.coachSelect   = "";       //清空教练
        $scope.cardSelect    = "";       //清空卡种
        $scope.viceMember    = '';       //清空被带会员
        $scope.keywordPeopleDel = "";   //清空搜索框
        $scope.searchBtn();
    };

    // 获取今日会员卡种统计
    $scope.getTotalCard = function (){
        $scope.loderAnimateShow2();
        $scope.venueSelectValue1 = $('.venueSelect1').val();
        if($scope.venueSelectValue1 == null || $scope.venueSelectValue1 == ''|| $scope.venueSelectValue1 == undefined) {
            $http.get("/operation-statistics/member-card-count?startTime=" + $scope.orderStartDate+"&endTime="+ $scope.orderEndDate+ "&venueId=" + $scope.venueChangeId+ '&anotherVenue=').success(function (data){
                $scope.cardNameListArr = [];
                $scope.cardNumListArr  = [];
                if(data.length == 0){
                    $scope.cardNameListArr = [];
                    $scope.cardNumListArr  = [];
                }
                else{
                    for(var i=0;i<data.length;i++){
                        $scope.cardNameListArr[i] = data[i].cardName;
                        $scope.cardNumListArr[i]  = data[i].number;
                    }
                }
                chartCard();
                $scope.loderAnimateHide2();
            })
        }else {
            $http.get("/operation-statistics/member-card-count?startTime=" + $scope.orderStartDate+"&endTime="+ $scope.orderEndDate+ "&venueId=" + '&anotherVenue=' + $scope.venueAllId).success(function (data){
                $scope.cardNameListArr = [];
                $scope.cardNumListArr  = [];
                if(data.length == 0){
                    $scope.cardNameListArr = [];
                    $scope.cardNumListArr  = [];
                }
                else{
                    for(var i=0;i<data.length;i++){
                        $scope.cardNameListArr[i] = data[i].cardName;
                        $scope.cardNumListArr[i]  = data[i].number;
                    }
                }
                chartCard();
                $scope.loderAnimateHide2();
            })
        }

    };

    // 日期插件点击确定时
    $('#addUserReservation').on('apply.daterangepicker', function(ev, picker) {
        $scope.addUserReservationVal = $("#addUserReservation").val();
        $scope.searchBtn();
    });

    // 获取会员上课统计
    $scope.getMemberClass = function (){
        $scope.loderAnimateShow3();
        $scope.venueSelectValue1 = $('.venueSelect1').val();
        if($scope.venueSelectValue1 == undefined || $scope.venueSelectValue1 == null || $scope.venueSelectValue1 == '') {
            $scope.venueSelectValue1 = '';
            $http.get("/operation-statistics/class-count?startTime=" + $scope.orderStartDate+"&endTime="+ $scope.orderEndDate + "&venueId=" + $scope.venueChangeId + '&anotherVenue=').success(function(data){
                $scope.classChartNameList = [];
                $scope.classChartNumList  = [];
                if(data.length == 0){
                    $scope.classChartNameList = [];
                    $scope.classChartNumList  = [];
                }
                else {
                    var classList = data;
                    for(var item in classList){
                        var itemList = classList[item];
                        for(var list in itemList){
                            $scope.classChartNameList.push(list);
                            $scope.classChartNumList.push({name:list,value:parseInt(itemList[list])});
                        }
                    }
                    // 应用方法
                    chartClass();
                }
                $scope.loderAnimateHide3();
            })
        }else {
            $http.get("/operation-statistics/class-count?startTime=" + $scope.orderStartDate+"&endTime="+ $scope.orderEndDate + "&venueId=" + '&anotherVenue=' + $scope.venueAllId).success(function(data){
                $scope.classChartNameList = [];
                $scope.classChartNumList  = [];
                if(data.length == 0){
                    $scope.classChartNameList = [];
                    $scope.classChartNumList  = [];
                }
                else {
                    var classList = data;
                    for(var item in classList){
                        var itemList = classList[item];
                        for(var list in itemList){
                            $scope.classChartNameList.push(list);
                            $scope.classChartNumList.push({name:list,value:parseInt(itemList[list])});
                        }
                    }
                    // 应用方法
                    chartClass();
                }
                $scope.loderAnimateHide3();
            })
        }

    };

    // 到店人数折线统计图
    var chartShop = function (){
        var myChart = echarts.init(document.getElementById('main'));
        option = {
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data:['到店人数']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                right: 10,
                feature: {
                    saveAsImage: {
                        title: '下载图片'
                    }
                }
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                data: ['6:00','7:00','8:00','9:00','10:00','11:00','12:00','13:00','14:00','15:00','16:00','17:00','18:00','19:00','20:00','21:00']
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name: '到店人数',
                    type: 'line',
                    stack: '总量',
                    data: [
                        $scope.allPeopleNum.time6,
                        $scope.allPeopleNum.time7,
                        $scope.allPeopleNum.time8,
                        $scope.allPeopleNum.time9,
                        $scope.allPeopleNum.time10,
                        $scope.allPeopleNum.time11,
                        $scope.allPeopleNum.time12,
                        $scope.allPeopleNum.time13,
                        $scope.allPeopleNum.time14,
                        $scope.allPeopleNum.time15,
                        $scope.allPeopleNum.time16,
                        $scope.allPeopleNum.time17,
                        $scope.allPeopleNum.time18,
                        $scope.allPeopleNum.time19,
                        $scope.allPeopleNum.time20,
                        $scope.allPeopleNum.time21
                    ],
                    itemStyle: {
                        normal: {
                            lineStyle: {
                                color: '#FD9527'
                            }
                        }
                    }
                }
            ]
        };
        myChart.setOption(option);
    };

    // 卡种柱状统计图
    var chartCard = function (){
        var myChart = echarts.init(document.getElementById('mainCard'));
        option = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            legend: {
                data: ['数量统计']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'value',
                boundaryGap: [0, 0.01]
            },
            yAxis: {
                type: 'category',
                data: $scope.cardNameListArr
            },
            toolbox: {

                show: true,
                right: 10,
                feature: {

                    saveAsImage: {
                        title: '下载图片',
                        show:true,

                        excludeComponents :['toolbox'],

                        pixelRatio: 2

                    }

                }

            },
            series: [
                {
                    name: '数量统计',
                    type: 'bar',
                    data: $scope.cardNumListArr,
                    itemStyle: {
                        normal:{
                            color: function (params){
                                var colorList = ['#66ccff','#FFCC00','#51D76A','#FFCC66','#66CCFF','#FF6600','#FFCC00','#51D76A','#ff6600'];
                                return colorList[params.dataIndex];
                            }
                        },
                        //鼠标悬停时：
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        };
        myChart.setOption(option);
    };

    // 会员上课饼状统计图
    var chartClass = function (){
        var myChart = echarts.init(document.getElementById('mainClass'));
        option = {
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                x : 'center',
                y : 'bottom',
                data: $scope.classChartNameList
            },
            toolbox: {
                right: 10,
                show: true,

                feature: {

                    saveAsImage: {

                        show:true,
                        title: '下载图片',
                        excludeComponents :['toolbox'],

                        pixelRatio: 2

                    }

                }

            },
            series : [
                {
                    name: '上课统计',
                    type: 'pie',
                    radius : '55%',
                    center: ['50%', '50%'],
                    data: $scope.classChartNumList,
                    itemStyle: {
                        normal: {
                            label: {
                                show: false,
                                formatter: '{c}({d}%)'
                            },
                            labelLine: {
                                show: false
                            }
                        },
                        emphasis: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ],
            color: ['#60C9F9','#9933FF','#51D76A','#FF6600','#FECB2F','#FF3366','#99CCFF']
        };
        myChart.setOption(option);
    };

    // 模态框关闭触发事件
    $(function () {
        $('#peopleNumModal').on('hide.bs.modal', function (){
            $("#addUserReservation").val("");//清空日期插件
            $scope.search333     = "";       //清空搜索
            $scope.sexSelect     = "";       //清空性别
            $scope.adviserSelect = "";       //清空顾问
            $scope.coachSelect   = "";       //清空教练
            $scope.cardSelect    = "";       //清空卡种
            $scope.viceMember    = '';       //清空被带会员
        });
    });
    /****************卡种统计模态框*********************/
    //卡种统计查看详情事件
    $scope.cardCountBtn = function(){
        $('#cardCountModal').modal('show');
        //console.log($('#memberDate').val())
        $scope.cardDate();
        $scope.initCardPath();
        $scope.getCardCountDetail();
    };

    //卡种统计模态框日期事件
    $scope.cardDate = function(){
        $scope.getToday();
        if($('#cardCountDate').val() == ''){
            $('#cardCountDate').val($scope.dateInput);
        }else{
            $('#cardCountDate').val($('#memberDate').val());
        }
        //$scope.cardCountStartDate = '';
        //$scope.cardCountEndDate = '';
        var startTime = $("#cardCountDate").val().substr(0, 10);
        $scope.cardCountStartDate = startTime;
        var endTime = $("#cardCountDate").val().substr(-10, 10);
        $scope.cardCountEndDate  = endTime;

    };
    //日期更换事件
    $('#cardCountDate').on('apply.daterangepicker', function(ev, picker){
        //$scope.cardDate();
        var startTime = $("#cardCountDate").val().substr(0, 10);
        $scope.cardCountStartDate = startTime;
        var endTime = $("#cardCountDate").val().substr(-10, 10);
        $scope.cardCountEndDate  = endTime;
    });

    //搜索参数
    $scope.cardCountParam = function(){
        return{
            venueId       : $scope.venueSelect != undefined  ? $scope.venueSelect  : null,            //场馆id
            anotherVenue  : $scope.VenueAllSelect != undefined  ? $scope.VenueAllSelect  : null,        //异店场馆id
            categoryType  : $scope.cardCountKind  != undefined  ? $scope.cardCountKind  : null,         //卡种
            cardType      : $scope.cardCountType != undefined  ? $scope.cardCountType  : null,          //卡类型
            startTime     : $scope.cardCountStartDate != undefined  ? $scope.cardCountStartDate  : null,//开始时间
            endTime       : $scope.cardCountEndDate != undefined  ? $scope.cardCountEndDate  : null,    //结束时间
            keywords      : $scope.cardCountKeywords != undefined  ? $scope.cardCountKeywords  : null,    //关键字
        };
    };
    //初始化路径
    $scope.initCardPath = function(){
        //$scope.cardDate();
        $scope.cardCountUrl = '/operation-statistics/card-count-details?='  + $.param($scope.cardCountParam());
    };

    //获取卡种统计详情列表
    $scope.getCardCountDetail = function(){
        $.loading.show();
        $http.get($scope.cardCountUrl).success(function(result){
            if(result.data.length != 0){
                $scope.cardCountDetailList = result.data;
                $scope.cardCountNoData = false;
                $scope.cardCountPage = result.pages;
            }else{
                $scope.cardCountDetailList = result.data;
                $scope.cardCountNoData = true;
                $scope.cardCountPage = result.pages;
            }
            $.loading.hide();
        })
    };
    //搜索按钮事件
    $scope.searchOneCardBtn = function(){
        //$scope.cardDate();
        $scope.initCardPath();
        $scope.getCardCountDetail();
    };
    //分页
    $scope.cardPages = function(url){
        $scope.cardCountUrl = url;
        $scope.getCardCountDetail();
    };
    //清除按钮事件
    $scope.clearCardCount = function(){
        $scope.cardCountKind = '';
        $scope.cardCountType = '';
        $scope.cardCountKeywords = '';
        $('#select2-cardCountKind-container').text('卡种').attr('title','卡种');
        $('#select2-cardCountType-container').text('卡种类型').attr('title','卡种类型');
        $("#cardCountDate").val('');
        $scope.cardDate();
        $scope.initCardPath();
        $scope.getCardCountDetail();
    };
    //模态框关闭事件
    $('#cardCountModal').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.cardCountKind = '';
        $scope.cardCountType = '';
        $scope.cardCountKeywords = '';
        $('#select2-cardCountKind-container').text('卡种').attr('title','卡种');
        $('#select2-cardCountType-container').text('卡种类型').attr('title','卡种类型');
    });

    /****************会员上课统计模态框*********************/
    //会员上课统计查看详情事件
    $scope.classCountBtn = function(){
        $('#classCountModal').modal('show');
        $scope.classDate();
        $scope.initClassPath();
        $scope.getClassCountDetail();
    };
    //上课统计模态框日期事件
    $scope.classDate = function(){
        $scope.getToday();
        if($('#classCountDate').val() == ''){
            $('#classCountDate').val($scope.dateInput);
        }else{
            $('#classCountDate').val($('#memberDate').val());
        }
        var startTime = $("#classCountDate").val().substr(0, 10);
        $scope.classCountStartDate = startTime+' '+ "00:00:00";
        var endTime = $("#classCountDate").val().substr(-10, 10);
        $scope.classCountEndDate  = endTime+' '+"23:59:59";

    };
    //日期更换事件
    $('#classCountDate').on('apply.daterangepicker', function(ev, picker){
        var startTime = $("#classCountDate").val().substr(0, 10);
        $scope.classCountStartDate = startTime+' '+ "00:00:00";
        var endTime = $("#classCountDate").val().substr(-10, 10);
        $scope.classCountEndDate  = endTime+' '+"23:59:59";
    });
    //搜索参数
    $scope.classCountParam = function(){
        return{
            venueId       : $scope.venueSelect != undefined  ? $scope.venueSelect  : null,            //场馆id
            anotherVenue  : $scope.VenueAllSelect != undefined  ? $scope.VenueAllSelect  : null,        //异店场馆id
            courseId      : $scope.classCountType  != undefined  ? $scope.classCountType  : null,         //卡种
            //cardType      : $scope.classCountName != undefined  ? $scope.classCountName  : null,          //卡类型
            startTime     : $scope.classCountStartDate != undefined  ? $scope.classCountStartDate  : null,//开始时间
            endTime       : $scope.classCountEndDate != undefined  ? $scope.classCountEndDate  : null,    //结束时间
            keywords      : $scope.classCountKeywords != undefined  ? $scope.classCountKeywords  : null,    //关键字
        };
    };
    //初始化路径
    $scope.initClassPath = function(){
        //$scope.cardDate();
        $scope.classCountUrl = '/operation-statistics/class-count-details?='  + $.param($scope.classCountParam());
    };
    //获取上课统计列表
    $scope.getClassCountDetail = function(){
        $.loading.show();
        $http.get($scope.classCountUrl).success(function(result){
            if(result.data.length != 0){
                $scope.classCountDetailList = result.data;
                $scope.classCountNoData = false;
                $scope.classCountPage = result.pages;
            }else{
                $scope.classCountDetailList = result.data;
                $scope.classCountNoData = true;
                $scope.classCountPage = result.pages;
            }
            $.loading.hide();
        })
    };
    //上课统计搜索按钮
    $scope.searchOneClassBtn = function(){
        //$scope.classDate();
        $scope.initClassPath();
        $scope.getClassCountDetail();
        //console.log($scope.classCountParam())

    };
    //清除按钮事件
    $scope.clearClassCount = function(){
        $scope.classCountType = '';
        $scope.classCountName = '';
        $('#select2-classCountType-container').text('课程分类').attr('title','课程分类');
        //$('#select2-classCountName-container').text('课程名称').attr('title','课程名称');
        $('#classCountDate').val('');
        $scope.classDate();
        $scope.initClassPath();
        $scope.getClassCountDetail();
    };
    //模态框关闭事件
    $('#classCountModal').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.classCountType = '';
        $scope.classCountName = '';
        $('#select2-classCountType-container').text('课程分类').attr('title','课程分类');
        $scope.classCountKeywords = '';
    });

    //查看会员详情
    $scope.getMemberDataCardBtn = function(id){
        //向子元素控制器传参
        $scope.$broadcast('to-child',id);
        $scope.$emit('to-parent', 'parent');
        $('#publicMemberInfoModal').modal('show');
    };
});