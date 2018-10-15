$(function(){
    $('#freeDate').daterangepicker(null, function(start, end, label) {

    });
    $('#classModalDate').daterangepicker(null, function(start, end, label) {

    });
    $('#classPrivateSelelct').select2({
        width:'100%'
    })
});
angular.module('App').controller('classStatCtrl',function($http,$scope,$timeout) {
    $('.topUl li').on('click', function () {
        var $index = $(this).index();
        $(this).addClass('topLiActive').siblings().removeClass('topLiActive');
    });
    //去除下拉框空白内容
    $scope.removeOption = function(){
        var $classSelect = $(".classSelect");
        $classSelect.each(function(i,item){
            var $option = $(this).find('option').eq(0).html();
            if($option == '' || $option == null ){
                $(this).find('option').eq(0).remove();
            }
        })
    };
    $timeout(function(){
        $scope.removeOption();
    },300);
    //获取场馆
    $scope.getVenueData = function(){
        //$.loading.show();
        $http.get('/site/get-auth-venue').success(function (data){
            //console.log(data);
            $scope.venueList = data;
            $scope.venueId = data[0].id;
            //$.loading.hide();
        });
    };
    $scope.getVenueData();
    //场馆切换事件
    $scope.venueChange = function(id){
        //今日分析
        $scope.todayInit();
        //四个统计
        $scope.firstBoxInit();
        $scope.twoBoxInit();
        $scope.threeBoxInit();
        $scope.fourBoxInit();
        //上课量折线图
        $scope.initChart1();
        //预约途径饼状图
        $scope.initChart4();
        //私教排行榜
        $scope.rankInit();
    };
    /************今日分析**********/
    //参数
    $scope.todayParam = function(){
        return{
            org_id :$scope.venueId != undefined && $scope.venueId  != '' ? $scope.venueId : null
        }
    };
    //初始化
    $scope.todayInit = function(){
        $scope.todayInitUrl1();
        $scope.todayInitUrl2();
        $scope.todayInitUrl3();
        $scope.getTodayData1();
        $scope.getTodayData2();
        $scope.getTodayData3();
    };
    $scope.todayInitUrl1 = function(){
        $scope.todayUrl1 = '/private-stat/today-survey-one?' + $.param($scope.todayParam());
    };
    $scope.todayInitUrl2 = function(){
        $scope.todayUrl2 = '/private-stat/today-survey-two?' + $.param($scope.todayParam());
    };
    $scope.todayInitUrl3 = function(){
        $scope.todayUrl3 = '/private-stat/today-survey-three?' + $.param($scope.todayParam());
    };
    //获取数据
    $scope.getTodayData1 = function(){
        $.loading.show();
        $http.get($scope.todayUrl1).success(function(result){
            //console.log(result);
            $scope.potential = result.potential;//新增潜在
            $scope.buy_class = result.buy_class;//新增购课
            $.loading.hide();
        })
    };
    $scope.getTodayData2 = function(){
        //$.loading.show();
        $http.get($scope.todayUrl2).success(function(result){
            //console.log(result);
            $scope.money = result.money;        //成交额
            $scope.order = result.order;        //订单数
            if(Number($scope.money.today) > Number($scope.money.yesterday)){
                $scope.showUp = true;
            }else{
                $scope.showUp = false;
            }
            if(Number($scope.money.today) < Number($scope.money.yesterday)){
                $scope.showDown = true;
            }else{
                $scope.showDown = false;
            }
            if(Number($scope.money.today) == Number($scope.money.yesterday)){
                $scope.showDeng = true;
            }else{
                $scope.showDeng = false;
            }
            //$.loading.hide();
        })
    };
    $scope.getTodayData3 = function(){
        //$.loading.show();
        $http.get($scope.todayUrl3).success(function(result){
            //console.log(result);
            $scope.t_num = result.t_num;        //体验课上课量
            $scope.f_num = result.f_num;        //付费课上课量
            //$.loading.hide();
        })
    };
    $timeout(function(){
        $scope.todayInit();
    },500);
    /*******体验课、付费课人数和节数统计*******/
    //初始化日期
    $scope.timeInit = function(){
        if($('#dateType').val() == 1){
            $scope.getNowDay();
            $scope.tiemSelectStart = $scope.nowDay + ' 00:00:00';
            $scope.timeSelectEnd = $scope.nowDay + ' 23:59:59';
        }
        if($('#dateType').val() == 2){
            $scope.getNowDay();
            $scope.tiemSelectStart = $scope.weekMonday + ' 00:00:00';
            $scope.timeSelectEnd = $scope.weekSunday + ' 23:59:59';
        }
        if($('#dateType').val() == 3){
            $scope.getMonthOneAndMonthLast();
        }
        // if($('#dateType').val() == 4 && $('#freeDate').val() != ''){
        //     $scope.freeDateInit();
        // }
    };
    //日期事件
    $scope.freeDateInit = function(){
        $scope.tiemSelectStart = '';
        $scope.timeSelectEnd = '';
        if($("#freeDate").val() != ''){
            var startTime = $("#freeDate").val().substr(0, 10);
            $scope.tiemSelectStart = startTime+' '+ "00:00:00";
            var endTime = $("#freeDate").val().substr(-10, 10);
            $scope.timeSelectEnd  = endTime+' '+"23:59:59";
        }
    };
    //今日、本周、本月、自定义切换事件
    $scope.dateTypeChange = function(id){
        if(id != 4){
            $scope.timeInit();
            $scope.firstBoxInit();
            $scope.twoBoxInit();
            $scope.threeBoxInit();
            $scope.fourBoxInit();
        }
    };
    $scope.lookBtn = function(){
        if( $('#freeDate').val() == ''){
            Message.warning('请选择日期');
            return
        }
        $scope.freeDateInit();
        $scope.firstBoxInit();
        $scope.twoBoxInit();
        $scope.threeBoxInit();
        $scope.fourBoxInit();
    };
    //1.体验课上课量参数
    $scope.classParam1 = function(){
        return{
            org_id : $('#venueSelect').val(),
            start_time : $scope.tiemSelectStart,
            end_time :  $scope.timeSelectEnd,
            course_type : 2
        }
    };
    $scope.firstBoxInit = function(){
        $scope.timeInit();
        $scope.firstInitPath();
        $scope.getFirstBox();
    };
    $scope.firstInitPath = function(){
        $scope.firstUrl = '/private-stat/attend-class-num?' + $.param($scope.classParam1());
    };
    $scope.getFirstBox = function(){
        $.loading.show();
        $http.get($scope.firstUrl).success(function(result){
            //console.log(result);
            $scope.firstBoxNum = result.data;
            $.loading.hide();
        })
    };
    $timeout(function () {
        $scope.firstBoxInit();
    },600);
    //2.付费课上课量参数
    $scope.classParam2 = function(){
        return{
            org_id : $('#venueSelect').val(),
            start_time : $scope.tiemSelectStart,
            end_time :  $scope.timeSelectEnd,
            course_type : 1
        }
    };
    $scope.twoBoxInit = function(){
        $scope.timeInit();
        $scope.twoInitPath();
        $scope.getTwoBox();
    };
    $scope.twoInitPath = function(){
        $scope.twoUrl = '/private-stat/attend-class-num?' + $.param($scope.classParam2());
    };
    $scope.getTwoBox = function(){
        $.loading.show();
        $http.get($scope.twoUrl).success(function(result){
            //console.log(result);
            $scope.twoBoxNum = result.data;
            $.loading.hide();
        })
    };
    $timeout(function () {
        $scope.twoBoxInit();
    },600);
    //3.体验课上课人数参数
    $scope.classParam3 = function(){
        return{
            org_id : $('#venueSelect').val(),
            start_time : $scope.tiemSelectStart,
            end_time :  $scope.timeSelectEnd,
            course_type : 2
        }
    };
    $scope.threeBoxInit = function(){
        $scope.timeInit();
        $scope.threeInitPath();
        $scope.getThreeBox();
    };
    $scope.threeInitPath = function(){
        $scope.threeUrl = '/private-stat/attend-member-num?' + $.param($scope.classParam3());
    };
    $scope.getThreeBox = function(){
        $.loading.show();
        $http.get($scope.threeUrl).success(function(result){
            //console.log(result);
            $scope.threeBoxNum = result.data;
            $.loading.hide();
        })
    };
    $timeout(function () {
        $scope.threeBoxInit();
    },600);
    //4.付费课上课人数参数
    $scope.classParam4 = function(){
        return{
            org_id : $('#venueSelect').val(),
            start_time : $scope.tiemSelectStart,
            end_time :  $scope.timeSelectEnd,
            course_type : 1
        }
    };
    $scope.fourBoxInit = function(){
        $scope.timeInit();
        $scope.fourInitPath();
        $scope.getFourBox();
    };
    $scope.fourInitPath = function(){
        $scope.fourUrl = '/private-stat/attend-member-num?' + $.param($scope.classParam4());
    };
    $scope.getFourBox = function(){
        $.loading.show();
        $http.get($scope.fourUrl).success(function(result){
            //console.log(result);
            $scope.fourBoxNum = result.data;
            $.loading.hide();
        })
    };
    $timeout(function () {
        $scope.fourBoxInit();
    },600);
    /****上课量折线图****/
    //最近30天、1年切换事件
    $scope.latelySelectChange = function(id){
        $scope.initChart1();
    };
    //体验课、付费课切换事件
    $scope.chart1Yname = '节';
    $scope.initType = 2;
    $scope.latelyNumChange = function(id){
        $scope.chart1Yname = $('#latelyNum option:selected').attr('name');
        if(id == 21 ||id == 22){
            $scope.initType = 2;
        }else{
            $scope.initType = 1;
        }
        $scope.initChart1();
    };
    //参数
    $scope.chartParam1 = function(){
        return{
            date_type : $('#latelySelect').val(),//最近30天、最近一年
            //course_type : $('#latelyNum').val(), //体验课、付费课
            course_type : $scope.initType, //体验课、付费课
            org_id : $('#venueSelect').val()     //场馆id
        }
    };
    //初始化
    $scope.initChart1 = function(){
        $scope.chartPath1();
        $scope.getChartData1();
    };
    //路径
    $scope.chartPath1 = function(){
        $scope.chartUrl1 = '/private-stat/private-attend-class-chart?' + $.param($scope.chartParam1())
    };
    $scope.getChartData1 = function(){
        $.loading.show();
        $http.get($scope.chartUrl1).success(function(result){
            //console.log(result);
            if(result.data.length != 0){
                $scope.xChart1Arr = [];
                $scope.chart1Data = [];
                var $chartData1 = result.data;
                $chartData1.map(function(item,i){
                    $scope.xChart1Arr.push(item.date);      //日期
                    //console.log($('#latelyNum option:selected').attr('name'));
                    if($('#latelyNum option:selected').attr('name') == '节'){
                        //$scope.chart1Data =  $scope.classChart1;
                        $scope.chart1Data.push(item.class_num);//课程节数数组
                        $scope.maxNum = Math.max.apply(null, $scope.chart1Data);  //课程最大值
                    }else{
                        $scope.chart1Data.push(item.member_num);//上课人数数组
                        $scope.maxNum = Math.max.apply(null, $scope.chart1Data);//人数最大值
                    }


                });
            }else{
                $scope.xChart1Arr = ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'];
                $scope.chart1Data = [];
                $scope.maxNum = 30;
            }
            $scope.getEchart1();
            $.loading.hide();
        })
    };
    $timeout(function () {
        $scope.initChart1();
    },600);

    $scope.getEchart1 = function(){
        if($scope.myDatumChart1 != null && $scope.myDatumChart1 != "" && $scope.myDatumChart1 != undefined) {
            $scope.myDatumChart1.dispose();
        }
        $scope.myDatumChart1 = echarts.init(document.getElementById('statChart1'));
        //用于使chart自适应高度和宽度,通过窗体高宽计算容器高宽
        // 指定图表的配置项和数据
        $scope.option1 = {
            title : {
                /*text:,*/
                /*left:'center',*/
            },
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:['上课量']
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    axisTick: {
                        alignWithLabel: true
                    },
                    //data : []
                    data : $scope.xChart1Arr
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    axisLabel : {
                        formatter: '{value}'
                    },
                    name :  $scope.chart1Yname,
                    min: 0,
                    max:$scope.maxNum,
                    splitNumber : 3
                }
            ],
            series : [
                {
                    name:'上课量',
                    type:'line',
                    data:$scope.chart1Data,
                    markPoint : {

                    },

                    itemStyle : {
                        normal : {
                            color:'#FF8000',
                            lineStyle:{
                                color:'#FF8000'
                            },
                            label : {show: true}
                        }
                    }
                }
            ]
        };
        $scope.myDatumChart1.setOption($scope.option1);
    };
    /****课程分析饼状图****/
    //参数
    $scope.chartParam3 = function(){
        return{
            org_id : $('#venueSelect').val(),   //场馆
            date_type : $('#timeSelect').val(), //今日 本月 本年
            type : $('#numSelect').val(),       //上课节数、人数
        }
    };
    //初始化
    $scope.initChart3 = function(){
        $scope.chartPath3();
        if( $('#numSelect').val() == 1){
            $scope.chart3DataOne();
        }
        if( $('#numSelect').val() == 2){
            $scope.chart3DataTwo();
        }

    };
    //路径
    $scope.chartPath3 = function(){
        $scope.chartUrl3 = '/private-stat/private-class-by-course?' + $.param($scope.chartParam3())
    };
    //上课节数数据
    $scope.chart3DataOne = function(){
        $.loading.show();
        $http.get($scope.chartUrl3).success(function(result){
            //console.log(result);
            if(result.data.length != 0){
                $scope.chart3NameArr = [];
                $scope.chart3DataArr = [];
                var $chartData3 = result.data;
                $chartData3.map(function(item,i){
                    var aa = item.name,bb = item.class_num;
                    var data1 = {
                        value :bb,
                        name : aa
                    };
                    $scope.chart3DataArr.push(data1);
                    $scope.chart3NameArr.push(aa);
                });
            }else{
                $scope.chart3DataArr = [{value : 0,name :'PT常规课'},{value : 0,name :'PT特色课'}];
                $scope.chart3NameArr = ['PT常规课','PT特色课'];
            }
            $scope.getEchart3();
            $.loading.hide();
        })
    };
    //上课人数数据
    $scope.chart3DataTwo = function(){
        $.loading.show();
        $http.get($scope.chartUrl3).success(function(result){
            console.log(result);
            if(result.data.length != 0){
                $scope.chart3NameArr = [];
                $scope.chart3DataArr = [];
                var $chartData3 = result.data;
                $chartData3.map(function(item,i){
                    var aa = item.name,bb = item.member_num;
                    var data1 = {
                        value :bb,
                        name : aa
                    };
                    $scope.chart3DataArr.push(data1);
                    $scope.chart3NameArr.push(aa);
                });
            }else{
                $scope.chart3DataArr = [{value : 0,name :'PT常规课'},{value : 0,name :'PT特色课'}];
                $scope.chart3NameArr = ['PT常规课','PT特色课'];
            }
            $scope.getEchart3();
            $.loading.hide();
        })
    };
    $timeout(function () {
        $scope.initChart3();
    },600);
    //上课节数、上课人数下拉框切换
    $scope.chart3TotalName = '上课节数';
    $scope.numSelectChange = function(id){
        if(id == 1){
            $scope.chart3TotalName = '上课节数';
        }
        if(id == 2){
            $scope.chart3TotalName = '上课人数';
        }
        $scope.initChart3();
    };
    //今日、本月、本年度下拉框切换
    $scope.timeSelectChange = function(id){
        $scope.initChart3();
    };
    $scope.getEchart3 = function(){
        if($scope.myDatumChart3 != null && $scope.myDatumChart3 != "" && $scope.myDatumChart3 != undefined) {
            $scope.myDatumChart3.dispose();
        }
        $scope.myDatumChart3 = echarts.init(document.getElementById('statChart3'));
        //用于使chart自适应高度和宽度,通过窗体高宽计算容器高宽
        // 指定图表的配置项和数据
        $scope.option3 = {
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            // legend: {
            //     x : 'center',
            //     y: 'bottom',
            //     data: $scope.chart3NameArr
            // },
            series : [
                {
                    name: $scope.chart3TotalName,
                    type: 'pie',
                    radius: '55%',
                    data : $scope.chart3DataArr,
                }
            ],
            color: ['#60C9F9','#9933FF','#51D76A','#FF6600','#FECB2F','#FFB6C1']
        };

        // 使用刚指定的配置项和数据显示图表。
        $scope.myDatumChart3.setOption($scope.option3);
    };
    /****预约途径饼状图****/
    //参数
    $scope.chartParam4 = function(){
        return{
            date_type : $('#waySelect').val(),
            org_id : $('#venueSelect').val()
        }
    };
    //初始化
    $scope.initChart4 = function(){
        $scope.chartPath4();
        $scope.getChartData4();
    };
    //路径
    $scope.chartPath4 = function(){
        $scope.chartUrl4 = '/private-stat/class-source?' + $.param($scope.chartParam4())
    };
    $scope.getChartData4 = function(){
        $.loading.show();
        $http.get($scope.chartUrl4).success(function(result){
            //console.log(result);
            if(result.data.length != 0){
                $scope.chartDataArr4 = [];
                $scope.chartNameArr4 = [];
                var $chartData4 = result.data;
                $chartData4.map(function(item,i){
                    var aa = item.type,bb = item.num;
                    var data1 = {
                        value :bb,
                        name : aa
                    };
                    $scope.chartDataArr4.push(data1);
                    $scope.chartNameArr4.push(aa);
                    //console.log('data',$scope.clientDataArr);
                });
            }else{
                $scope.chartDataArr4 = [{value : 0,name :'PC'},{value : 0,name :'APP'},{value : 0,name :'小程序'}];
                $scope.chartNameArr4 = ['PC','APP','小程序'];
            }
            $scope.getEchart4();
            $.loading.hide();
        })
    };
    $timeout(function () {
        $scope.initChart4();
    },600);
    //预约途径切换
    $scope.chartTypeName4 = $('#waySelect').children('option').eq(0).attr('name');
    $scope.waySelectChange = function(id){
        $scope.chartTypeName4 = $('#waySelect option:selected').attr('name');
        $scope.initChart4();
    };
    $scope.getEchart4 = function(){
        //防止出现“There is a chart instance already initialized on the dom.”的警告
        //在使用echarts发现需要及时对新建的myChart实例进行销毁,否则会出现上述警告
        if($scope.myDatumChart4 != null && $scope.myDatumChart4 != "" && $scope.myDatumChart4 != undefined) {
            $scope.myDatumChart4.dispose();
        }
        $scope.myDatumChart4 = echarts.init(document.getElementById('statChart4'));
        //用于使chart自适应高度和宽度,通过窗体高宽计算容器高宽
        // 指定图表的配置项和数据
        $scope.option4 = {
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            series : [
                {
                    name: $scope.chartTypeName4,
                    type: 'pie',
                    radius: '55%',
                    data : $scope.chartDataArr4,
                }
            ],
            color: ['#60C9F9','#9933FF','#51D76A','#FF6600','#FECB2F','#FFB6C1']
        };
        $scope.myDatumChart4.setOption($scope.option4);
    };
    //echarts自适应浏览器
    $scope.resetChart = function(){
        $scope.getEchart1();
        $scope.getEchart3();
        $scope.getEchart4();
        window.onresize = function () {
            //重置容器宽高
            $scope.myDatumChart1.resize();
            $scope.myDatumChart3.resize();
            $scope.myDatumChart4.resize();
        };
    };
    $timeout(function(){
        $scope.resetChart();
    },500);
    /******私教会员量排行榜*******/
    //参数
    $scope.rankParam = function(){
        return{
            org_id : $('#venueSelect').val(),   //场馆id
            course_type :$('#classTypeSelect').val(),//体验课、付费课
            start_time: $scope.rankDateStart,
            end_time:$scope.rankDatetEnd,
        }
    };
    $scope.rankInit = function(){
        $scope.rankTimeInit();
        $scope.rankPath();
        $scope.rankListData();
    };
    $scope.rankTimeInit = function(){
        if($('#rankSelect').val() == 1){
            $scope.getNowDay();
            $scope.rankDateStart = $scope.nowDay + ' 00:00:00';
            $scope.rankDatetEnd = $scope.nowDay + ' 23:59:59';
        }
        if($('#rankSelect').val() == 2){
            $scope.getNowDay();
            $scope.rankDateStart = $scope.weekMonday + ' 00:00:00';
            $scope.rankDatetEnd = $scope.weekSunday + ' 23:59:59';
        }
        if($('#rankSelect').val() == 3){
            $scope.getMonthOneAndMonthLast();
        }
    };
    $scope.rankPath = function(){
        $scope.rankUrl = '/private-stat/private-class-num?' + $.param($scope.rankParam())
    };
    $scope.rankListData = function(){
        $.loading.show();
        $http.get($scope.rankUrl).success(function(result){
            //console.log(result);
            if(result.data.length != 0){
                $scope.rankList = result.data;
                $scope.classRankNoData = false;
                $('.privateList li').css('marginBottom','0');
            }else{
                $scope.rankList = [];
                $scope.classRankNoData = true;
                $('.privateList li').css('marginBottom','50px');
            }
            $.loading.hide();
        })
    };
    $timeout(function () {
        $scope.rankInit();
    },600);
    //日排行、周排行、月排行下拉框切换事件
    $scope.rankSelectChange1 = function(id){
        $scope.rankInit();
    };
    //新单、续费下拉框切换事件
    $scope.classTypeChange = function(id){
        $scope.rankInit();
    };

    $scope.getNowDay = function(){
        var now = new Date();
        var year = now.getFullYear(); //得到年份
        var month = now.getMonth() + 1;//得到月份
        var date = now.getDate();//得到日期
        var day = now.getDay();//得到周几
        var nowTime = now.getTime();
        var oneDayLong = 24*60*60*1000 ;
        if (month < 10) month = "0" + month;
        if (date < 10) date = "0" + date;
        var MondayTime = nowTime - (day-1)*oneDayLong  ;
        $scope.weekMonday = $scope.getMyDate1(MondayTime);
        var SundayTime =  nowTime + (7-day)*oneDayLong ;
        $scope.weekSunday = $scope.getMyDate1(SundayTime);
        $scope.nowDay = year + "-" + month + "-" + date;
    };
    //时间戳转换为年月日
    $scope.getMyDate1 = function(str){
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

    //模态框详情
    $scope.classClick = function(type){
        $('#classModal').modal('show');
        switch(type){
            case 1 :
                $scope.classModalTitle = '体验课上课量';
                $scope.show1 = true;
                $('.classModalSelect3').val(2);
                break;
            case 2 :
                $scope.classModalTitle = '付费课上课量';
                $scope.show2 = true;
                $('.classModalSelect3').val(1);
                break;
            case 3 :
                $scope.classModalTitle = '体验课上课人数';
                $scope.show3 = true;
                $('.classModalSelect3').val(2);
                break;
            case 4 :
                $scope.classModalTitle = '付费课上课人数';
                $scope.show4 = true;
                $('.classModalSelect3').val(1);
                break;
        }
        $scope.getModalVenueData();
        $scope.getPrivate();
    };
    //获取场馆
    $scope.getModalVenueData = function(){
        $.loading.show();
        $http.get('/site/get-auth-venue').success(function (data){
            //console.log(data);
            $scope.modalVenueList = data;
            $.loading.hide();
        });
    };
    //获取私教人员信息
    $scope.getPrivate = function(){
        $http.get("/private-teach/private-coach").success(function (response) {
            $scope.praviteList = response;
        });
    };
    $('#classModal').on('shown.bs.modal', function () {
        $('.classModalSelect1').val($('#venueSelect').val());
        //console.log($('#dateType').val());
        if($('#dateType').val() == 1){
            $scope.getNowDay();
            $("#classModalDate").val($scope.nowDay + ' - ' + $scope.nowDay);
        }
        if($('#dateType').val() == 2){
            $scope.getNowDay();
            $("#classModalDate").val($scope.weekMonday + ' - ' + $scope.weekSunday);
        }
        if($('#dateType').val() == 3){
            $scope.getMonthOneAndMonthLast();
        }
        if($('#dateType').val() == 4 && $('#freeDate').val() != ''){
            $("#classModalDate").val($('#freeDate').val())
        }
        if($('#dateType').val() == 4 && $('#freeDate').val() == ''){
            $scope.getNowDay();
            $("#classModalDate").val($scope.nowDay + ' - ' + $scope.nowDay);
        }
        $scope.classModalDateInit();
        $scope.classModalPath();
        $scope.getClassModalData();

    });
    $('#classModal').on('hidden.bs.modal', function (e) {
        // do something...
        $('#classModalDate').val('');
        $scope.show1 = false;
        $scope.show2 = false;
        $scope.show3 = false;
        $scope.show4 = false;
    });
    //日期事件
    $scope.classModalDateInit = function(){
        $scope.classStartDate = '';
        $scope.classEndDate = '';
        if($("#classModalDate").val() != ''){
            var startTime = $("#classModalDate").val().substr(0, 10);
            $scope.classStartDate = startTime+' '+ "00:00:00";
            var endTime = $("#classModalDate").val().substr(-10, 10);
            $scope.classEndDate  = endTime+' '+"23:59:59";
        }
    };
    //初始化获取当月的第一天和最后一天
    $scope.getMonthOneAndMonthLast = function(){
        var date = new Date();
        $scope.classStartDate =$scope.getMyDate(date.setDate(1));
        $scope.tiemSelectStart = $scope.getMyDate(date.setDate(1)) + ' 00:00:00';
        $scope.rankDateStart =$scope.getMyDate(date.setDate(1)) + ' 00:00:00';
        var currentMonth=date.getMonth();
        var nextMonth=++currentMonth;
        var nextMonthFirstDay=new Date(date.getFullYear(),nextMonth,1);
        var oneDay=1000*60*60*24;
        $scope.classEndDate = $scope.getMyDate(nextMonthFirstDay-oneDay);
        $scope.timeSelectEnd = $scope.getMyDate(nextMonthFirstDay-oneDay) + ' 23:59:59';
        $scope.rankDatetEnd = $scope.getMyDate(nextMonthFirstDay-oneDay) + ' 23:59:59';
        $('#classModalDate').val($scope.classStartDate+' - '+ $scope.classEndDate);
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
    //参数
    $scope.classModalParam = function(){
        return{
            org_id: $('.classModalSelect1').val(),
            private_id : $('.classModalSelect2').val(),
            course_type : $('.classModalSelect3').val(),
            start_time : $scope.classStartDate != undefined && $scope.classStartDate != '' ? $scope.classStartDate : null,
            end_time:$scope.classEndDate != undefined && $scope.classEndDate != '' ? $scope.classEndDate : null,
            keyWord : $scope.searchKeyword
        }
    };
    //路径
    $scope.classModalPath = function(){
        $scope.classModalUrl ='/private-stat/private-attend-class?' + $.param($scope.classModalParam());
    };
    //获取列表
    $scope.getClassModalData = function(){
        $.loading.show();
        $http.get($scope.classModalUrl).success(function(result){
            //console.log(result);
            $scope.totalMember = result.$totalMember;
            $scope.totalCount = result.totalCount;
            if(result.data.length != 0){
                $scope.classModalList = result.data;
                $scope.classModalNowPage = result.now_page;
                $scope.classModalNoData = false;
                $scope.classModalPage = result.pages;
            }else{
                $scope.classModalList = result.data;
                $scope.classModalNowPage = result.now_page;
                $scope.classModalNoData = true;
                $scope.classModalPage = result.pages;
            }
            $.loading.hide();
        })
    };
    //分页
    $scope.privateAttendPages = function(url){
        $scope.classModalUrl = url;
        $scope.getClassModalData();
    };
    //确定按钮
    $scope.searchClassBtn = function(){
        $scope.classModalDateInit();
        $scope.classModalPath();
        $scope.getClassModalData();
        //console.log($scope.classModalParam());
    };
    //enter键搜索
    $scope.enterSearch = function(){
        var event = window.event || arguments.callee.caller.arguments[0];
        if (event.keyCode == 13) {
            $scope.searchClassBtn();
        }
    };
    //清空按钮
    $scope.clearClassBtn = function(){
        $('#select2-classPrivateSelelct-container').text('私教').attr('私教');
        if($scope.show1){
            $('.classModalSelect3').val(2);
        }
        if($scope.show2){
            $('.classModalSelect3').val(1);
        }
        if($scope.show3){
            $('.classModalSelect3').val(2);
        }
        if($scope.show4){
            $('.classModalSelect3').val(1);
        }
        $('.classModalSelect2').val('');
        $scope.searchKeyword = '';
        $scope.getMonthOneAndMonthLast();
        $scope.classModalPath();
        $scope.getClassModalData();
    };
    //查看详情
    $scope.getMemberDataCardBtn = function(id){
        //向子元素控制器传参
        $scope.$broadcast('to-child',id);
        $scope.$emit('to-parent', 'parent');
        $('#publicMemberInfoModal').modal('show');
    };
});