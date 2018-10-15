$(function(){
    $('#sellTopDate').daterangepicker(null, function(start, end, label) {

    });
    $('#sellModalDate').daterangepicker(null, function(start, end, label) {

    });
    $('.modal').on('hidden.bs.modal', function () {
        if ($('.modal.in').size() >= 1) {
            $('body').addClass('modal-open')
        }
    });
    $('#sellPrivateSelect').select2({
        width:'100%'
    });
    $('#sellClassType').select2({
        width:'100%'
    })
});
angular.module('App').controller('sellStatCtrl',function($http,$scope,$timeout) {
    $('.topUl li').on('click', function () {
        var $index = $(this).index();
        $(this).addClass('topLiActive').siblings().removeClass('topLiActive');
    });
    //去除下拉框空白内容
    $scope.removeOption = function(){
        var $sellSelectt = $(".sellSelect");
        $sellSelectt.each(function(i,item){
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
        //5个统计
        $scope.topBoxInit();
        //成交额折线图
        $scope.initChart1();
        //新老客户成交占比
        $scope.chart3Init();
        //课程分析饼状图
        $scope.initChart4();
        //课程对比柱状图
        $scope.initChart5();
        //私教会员量排行榜
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
    },300);
    /**********成交额、成交量、体验课成交率、平均成交价、平均客单价统计***********/
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
    $scope.lookBtn = function(){
        if( $('#freeDate').val() == ''){
            Message.warning('请选择日期');
            return
        }
        $scope.freeDateInit();
        $scope.topBoxPath();
        $scope.topBoxData();
    };
    //参数
    $scope.topBoxParam = function(){
        return{
            org_id : $('#venueSelect').val(),//场馆id
            start_time : $scope.tiemSelectStart,
            end_time :  $scope.timeSelectEnd,
        }
    };
    //初始化
    $scope.topBoxInit = function(){
        $scope.timeInit();
        $scope.topBoxPath();
        $scope.topBoxData();
    };
    //路径
    $scope.topBoxPath = function(){
        $scope.topBoxUrl = '/private-stat/sale-num?' + $.param($scope.topBoxParam())
    };
    //数据
    $scope.topBoxData = function(){
        $.loading.show();
        $http.get($scope.topBoxUrl).success(function(result){
            //console.log(result);
            if(result.totalMoney != null && result.totalClass != null){
                $scope.fourBox = (result.totalMoney / result.totalClass).toFixed(2);
            }else{
                $scope.fourBox = 0;
            }
            if(result.totalMoney != null && result.totalMember != 0 && result.totalMember != null){
                $scope.fiveBox = (result.totalMoney / result.totalMember).toFixed(2);
            }else{
                $scope.fiveBox = 0;
            }
            $scope.topTotalClass = result.totalClass; //总节数
            $scope.topTotalMember = result.totalMember; //总人数
            $scope.topTotalMoney = result.totalMoney; //总价格
            $scope.dealRate = (result.dealRate * 100).toFixed(2);//成交率

            $.loading.hide();
        })
    };
    $timeout(function () {
        $scope.topBoxInit();
    },600);
    //今日、本周、本月、自定义日期切换事件
    $scope.dateTypeChange = function(id){
        if(id != 4){
            $scope.timeInit();
            $scope.topBoxPath();
            $scope.topBoxData();
        }
    };
    /****成交趋势折线图****/
    $scope.chartParam1 = function(){
        return{
            org_id : $('#venueSelect').val(),//场馆id
            date_type : $('#latelySelect').val() //最近30天、一年
        }
    };
    $scope.initChart1 = function(){
        $scope.chartPath1();
        if($('#latelyNum').val() == 1){
            $scope.chart1DataOne();
        }
        if($('#latelyNum').val() == 2){
            $scope.chart1DataTwo();
        }
        if($('#latelyNum').val() == 3){
            $scope.chart1DataThree();
        }
    };
    $scope.chartPath1 = function(){
        if($('#latelyNum').val() == 1){
            $scope.chart1Url = '/private-stat/sale-deal-chart?' + $.param($scope.chartParam1());
        }
        if($('#latelyNum').val() == 2){
            $scope.chart1Url = '/private-stat/sale-deal-num-chart?' + $.param($scope.chartParam1());
        }
        if($('#latelyNum').val() == 3){
            $scope.chart1Url = '/private-stat/sale-deal-member-chart?' + $.param($scope.chartParam1());
        }
    };
    $scope.chart1DataOne = function(){
        $.loading.show();
        $http.get($scope.chart1Url).success(function(result){
            //console.log(result);
            if(result.data.length != 0){
                $scope.chart1DateArr = [];
                $scope.chart1NumArr = [];
                var $chartData1 = result.data;
                $chartData1.map(function (item,i) {
                    $scope.chart1DateArr.push(item.date);
                    $scope.chart1NumArr.push(item.money);
                    $scope.maxNum = Math.max.apply(null, $scope.chart1NumArr);  //最大值
                })
            }
            $scope.getEchart1();
            $.loading.hide();
        })
    };
    $scope.chart1DataTwo = function(){
        $.loading.show();
        $http.get($scope.chart1Url).success(function(result){
            //console.log(result);
            if(result.data.length != 0){
                $scope.chart1DateArr = [];
                $scope.chart1NumArr = [];
                var $chartData1 = result.data;
                $chartData1.map(function (item,i) {
                    $scope.chart1DateArr.push(item.date);
                    $scope.chart1NumArr.push(item.num);
                    $scope.maxNum = Math.max.apply(null, $scope.chart1NumArr);  //最大值
                })
            }
            $scope.getEchart1();
            $.loading.hide();
        })
    };
    $scope.chart1DataThree = function(){
        $.loading.show();
        $http.get($scope.chart1Url).success(function(result){
            //console.log(result);
            if(result.data.length != 0){
                $scope.chart1DateArr = [];
                $scope.chart1NumArr = [];
                var $chartData1 = result.data;
                $chartData1.map(function (item,i) {
                    $scope.chart1DateArr.push(item.date);
                    $scope.chart1NumArr.push(item.member_num);
                    $scope.maxNum = Math.max.apply(null, $scope.chart1NumArr);  //最大值
                })
            }
            $scope.getEchart1();
            $.loading.hide();
        })
    };
    $timeout(function(){
        $scope.initChart1();
    },600);
    //成交额、成交量、购买人数下拉框切换事件
    $scope.yName = '元';
    $scope.latelyName = '成交额';
    $scope.latelyName1 = ['成交额'];
    $scope.latelyNumChange = function(id){
        if(id == 1){
            $scope.latelyName = '成交额';
            $scope.latelyName1 = ['成交额'];
            $scope.yName = '元';
        }
        if(id == 2){
            $scope.latelyName = '成交量';
            $scope.latelyName1 = ['成交量'];
            $scope.yName = '节';
        }
        if(id == 3){
            $scope.latelyName = '购买人数';
            $scope.latelyName1 = ['购买人数'];
            $scope.yName = '人';
        }
        $scope.initChart1();
    };
    //最近30天、最近1年下拉框切换事件
    $scope.latelySelectChange = function(id){
        $scope.initChart1();
    };
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
                data:$scope.latelyName1Arr
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    axisTick: {
                        alignWithLabel: true
                    },
                    data : $scope.chart1DateArr
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    axisLabel : {
                        formatter: '{value}'
                    },
                    name : $scope.yName,
                    min: 0,
                    max:$scope.maxNum,
                    splitNumber : 3
                }
            ],
            series : [
                {
                    name:$scope.latelyName,
                    type:'line',
                    data: $scope.chart1NumArr,
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
    /****销售漏斗图****/
    // $scope.getEchart2 = function(){
    //     if($scope.myDatumChart2 != null && $scope.myDatumChart2 != "" && $scope.myDatumChart2 != undefined) {
    //         $scope.myDatumChart2.dispose();
    //     }
    //     $scope.myDatumChart2 = echarts.init(document.getElementById('statChart2'));
    //     //用于使chart自适应高度和宽度,通过窗体高宽计算容器高宽
    //     // 指定图表的配置项和数据
    //     $scope.option2 = {
    //         "tooltip": {
    //             "trigger": "axis",
    //             "axisPointer": {
    //                 "type": "cross",
    //                 "label": {
    //                     "backgroundColor": "#6a7985"
    //                 },
    //                 "lineStyle": {
    //                     "color": "#9eb2cb"
    //                 }
    //             }
    //         },
    //
    //         "legend": {
    //             x : 'center',
    //             y: 'bottom',
    //             "textStyle": {
    //                 "color": "#000"
    //             },
    //             "itemHeight": 10,
    //             "data":  [/*'展现',*/'点击','访问','咨询','订单']
    //         },
    //         "grid": {
    //             "top": 24,
    //             "left": "2%",
    //             "right": 20,
    //             "bottom": 30,
    //             "containLabel": true,
    //             "borderWidth": 0.5
    //         },
    //         series: [
    //             {
    //                 top:0,
    //
    //                 name: '',
    //                 type: 'funnel',
    //                 left: '10%',
    //                 width: '80%',
    //                 gap: 10,
    //                 minSize: 114,
    //                 maxSize: 390,
    //                 label: {
    //                     normal: {
    //                         color: '#353535',
    //                         position: 'right',
    //
    //                     },
    //                     emphasis: {
    //                         position:'left',
    //                         formatter: '{c}%'
    //                     }
    //                 },
    //                 labelLine: {
    //                     normal: {
    //                         length: 40,
    //                         position: 'left',
    //
    //                         lineStyle: {
    //                             width: 2
    //
    //                         }
    //                     }
    //                 },
    //                 itemStyle: {
    //                     normal: {
    //
    //                     }
    //                 },
    //                 data: [
    //                     {value: 60, name: '访问',
    //                         itemStyle: {
    //                             normal: {
    //                                 color: '#4e99de'
    //                             }
    //                         },
    //                         labelLine:{
    //                             normal: {
    //                                 lineStyle: {
    //                                     shadowColor: '#4e99de',
    //                                     shadowOffsetX: 1
    //                                 }
    //                             }
    //                         }
    //                     },
    //                     {value: 40, name: '咨询',
    //                         itemStyle: {
    //                             normal: {
    //                                 color: '#4da7db'
    //                             }
    //                         },
    //                         labelLine:{
    //                             normal: {
    //                                 lineStyle: {
    //                                     shadowColor: '#4da7db',
    //                                     shadowOffsetX: 1
    //                                 }
    //                             }
    //                         }
    //                     },
    //                     {value: 20, name: '订单',
    //                         itemStyle: {
    //                             normal: {
    //                                 color: '#53b8e2'
    //                             }
    //                         },
    //                         labelLine:{
    //                             normal: {
    //                                 lineStyle: {
    //                                     shadowColor: '#53b8e2',
    //                                     shadowOffsetX: 1
    //                                 }
    //                             }
    //                         }
    //                     },
    //                     {value: 80, name: '点击',
    //                         itemStyle: {
    //                             normal: {
    //                                 color: '#398bd8'
    //                             }
    //                         },
    //                         labelLine:{
    //                             normal: {
    //                                 lineStyle: {
    //                                     shadowColor: '#398bd8',
    //                                     shadowOffsetX: 1
    //                                 }
    //                             }
    //                         }
    //                     }/*,
    //                     {value: 100, name: '展现',
    //                         itemStyle: {
    //                             normal: {
    //                                 color: '#0083c7'
    //                             }
    //                         },
    //                         labelLine:{
    //                             normal: {
    //                                 lineStyle: {
    //                                     shadowColor: '#0083c7',
    //                                     shadowOffsetX: 1
    //                                 }
    //                             }
    //                         }
    //                     }*/
    //                 ]
    //             },
    //             {
    //                 name: '',
    //                 type: 'funnel',
    //                 top:0,
    //                 gap: 10,
    //                 label: {
    //                     normal: {
    //                         position: 'inside',
    //                         formatter: '转化率：({c}%)',
    //                         textStyle: {
    //                             color: '#fff'
    //                         }
    //                     }
    //
    //                 },
    //                 labelLine: {
    //                     normal: {
    //
    //
    //                     }
    //                 },
    //                 itemStyle: {
    //                     normal: {
    //                         color: 'transparent',
    //                         borderWidth:0,
    //                         opacity: 0
    //                     }
    //                 },
    //                 data: [
    //                     {value: 60, name: '访问'},
    //                     {value: 40, name: '咨询'},
    //                     {value: 20, name: '订单'},
    //                     {value: 80, name: '点击'},
    //                     /*{value: 100, name: '展现'}*/
    //                 ]
    //             }
    //         ]
    //     };
    //     $scope.myDatumChart2.setOption($scope.option2);
    // };
    /****成交客户分析饼状图****/
    //参数
    $scope.chartParam3 = function(){
        return{
            org_id : $('#venueSelect').val(),//场馆id
            s_type : $('#turnoverSelect').val(), //成交额、成交量、购买人数
        }
    };
    $scope.chart3Init = function(){
        if($('#percentSelect').val() == 1){
            $scope.chartPath3One();
            $scope.chart3DataOne();
        }
        if($('#percentSelect').val() == 2){
            $scope.chartPath3Two();
            $scope.chart3DataTwo();
        }

    };
    //新老客户占比路径
    $scope.chartPath3One = function(){
        $scope.chartUrl3One = '/private-stat/deal-member?' + $.param($scope.chartParam3())
    };
    //数据
    $scope.chart3DataOne = function(){
        $.loading.show();
        $scope.chart3DataArr = [];
        $http.get($scope.chartUrl3One).success(function(result){
            //console.log(result);
            if(result.data != ''){
                var aa = result.data.first;
                var bb = result.data.all;
                if(aa != 0){
                    var data1 = {
                        name : '新客户',
                        value : aa
                    };
                }
                if(bb != 0){
                    var data2 = {
                        name : '老客户',
                        value : bb
                    };
                }
                $scope.chart3DataArr.push(data1,data2);
            }else{
                $scope.chart3DataArr = [{name :'新客户',value : 0},{name :'老客户',value : 0}];
            };
            $scope.getEchart3();
            $.loading.hide();
        })
    };
    //当日成交占比路径
    $scope.chartPath3Two = function(){
        $scope.chartUrl3Two = '/private-stat/same-day-deal?' + $.param($scope.chartParam3())
    };
    //数据
    $scope.chart3DataTwo = function(){
        $.loading.show();
        $scope.chart3DataArr = [];
        $http.get($scope.chartUrl3Two).success(function(result){
            //console.log(result);
            if(result.data != ''){
                var aa = result.data.first;
                var bb = result.data.all;
                if(aa != 0){
                    var data1 = {
                        name : '当日成交',
                        value : aa
                    };
                }
                if(bb != 0){
                    var data2 = {
                        name : '非当日成交',
                        value : bb
                    };
                }
                $scope.chart3DataArr.push(data1,data2);
            }else{
                $scope.chart3DataArr = [{name :'新客户',value : 0},{name :'老客户',value : 0}];
            };
            $scope.getEchart3();
            $.loading.hide();
        })
    };
    $timeout(function () {
        $scope.chart3Init();
    },600);
    //成交额、成交量、购买人数下拉框切换事件
    $scope.chart3Name = '成交额';
    $scope.chart3Unit = '元';
    $scope.turnoverSelectChange = function(id){
        if(id == 1){
            $scope.chart3Name = '成交额';
            $scope.chart3Unit = '元';
        }
        if(id == 2){
            $scope.chart3Name = '成交量';
            $scope.chart3Unit = '节';
        }
        if(id == 3){
            $scope.chart3Name = '购买人数';
            $scope.chart3Unit = '人';
        }

        $scope.chart3Init();
    };
    //当日成交占比、新老客户成交占比下拉框切换时间
    $scope.percentSelectChange = function(id){
        $scope.chart3Init();
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
                formatter: "{a} <br/>{b} : {c} ({d}%)" + $scope.chart3Unit
            },
            series : [
                {
                    name: $scope.chart3Name,
                    type: 'pie',
                    radius: '55%',
                    data :  $scope.chart3DataArr,
                }
            ],
            color: ['#60C9F9','#9933FF','#51D76A','#FF6600','#FECB2F','#FFB6C1']
        };

        // 使用刚指定的配置项和数据显示图表。
        $scope.myDatumChart3.setOption($scope.option3);
    };
    /****课程分析饼状图****/
    $scope.chartParam4 = function(){
        return{
            org_id : $('#venueSelect').val(),//场馆id
            date_type : $('#analyzeSelect').val(), //最近30天、一年
            s_type : $('#analyzeNum').val(), //成交额、成交量、购买人数
        }
    };
    $scope.initChart4 = function(){
        $scope.chartPath4();
        if($('#analyzeNum').val() == 1){
            $scope.chart4DataOne();
        }
        if($('#analyzeNum').val() == 2){
            $scope.chart4DataTwo();
        }
        if($('#analyzeNum').val() == 3){
            $scope.chart4DataThree();
        }
    };
    $scope.chartPath4 = function(){
        $scope.chart4Url = '/private-stat/sale-class?' + $.param($scope.chartParam4());
    };
    $scope.chart4DataOne = function(){
        $.loading.show();
        $http.get($scope.chart4Url).success(function(result){
            //console.log(result);
            if(result.data.length != 0){
                $scope.chartDataArr4 = [];
                $scope.chartNameArr4 = [];
                var $chartData4 = result.data;
                $chartData4.map(function(item,i){
                    var aa = item.name,bb = item.money;
                    var data1 = {
                        value :bb,
                        name : aa
                    };
                    $scope.chartDataArr4.push(data1);
                    $scope.chartNameArr4.push(aa);
                    //console.log('data',$scope.clientDataArr);
                });
            }else{
                $scope.chartDataArr4 = [{name:'PT课程',value:0}]
            }
            $scope.getEchart4();
            $.loading.hide();
        })
    };
    $scope.chart4DataTwo = function(){
        $.loading.show();
        $http.get($scope.chart4Url).success(function(result){
            //console.log(result);
            if(result.data.length != 0){
                $scope.chartDataArr4 = [];
                $scope.chartNameArr4 = [];
                var $chartData4 = result.data;
                $chartData4.map(function(item,i){
                    var aa = item.name,bb = item.num;
                    var data1 = {
                        value :bb,
                        name : aa
                    };
                    $scope.chartDataArr4.push(data1);
                    $scope.chartNameArr4.push(aa);
                    //console.log('data',$scope.clientDataArr);
                });
            }else{
                $scope.chartDataArr4 = [{name:'PT课程',value:0}]
            }
            $scope.getEchart4();
            $.loading.hide();
        })
    };
    $scope.chart4DataThree = function(){
        $.loading.show();
        $http.get($scope.chart4Url).success(function(result){
            //console.log(result);
            if(result.data.length != 0){
                $scope.chartDataArr4 = [];
                $scope.chartNameArr4 = [];
                var $chartData4 = result.data;
                $chartData4.map(function(item,i){
                    var aa = item.name,bb = item.member_num;
                    var data1 = {
                        value :bb,
                        name : aa
                    };
                    $scope.chartDataArr4.push(data1);
                    $scope.chartNameArr4.push(aa);
                    //console.log('data',$scope.clientDataArr);
                });
            }else{
                $scope.chartDataArr4 = [{name:'PT课程',value:0}]
            }
            $scope.getEchart4();
            $.loading.hide();
        })
    };
    $timeout(function () {
        $scope.initChart4();
    },600);
    //成交额、成交量、购买人数下拉框切换事件
    $scope.chartTypeName4 = '成交额';
    $scope.chart4Unit = '元';
    $scope.analyzeNumChange = function(id){
        if(id == 1){
            $scope.chartTypeName4 = '成交额';
            $scope.chart4Unit = '元';
        }
        if(id == 2){
            $scope.chartTypeName4 = '成交量';
            $scope.chart4Unit = '节';
        }
        if(id == 3){
            $scope.chartTypeName4 = '购买人数';
            $scope.chart4Unit = '人';
        }
        $scope.initChart4();
    };
    //今日、本月、本年度下拉框切换事件
    $scope.analyzeSelectChange = function(id){
        $scope.initChart4();
    };
    $scope.getEchart4 = function(){
        if($scope.myDatumChart4 != null && $scope.myDatumChart4 != "" && $scope.myDatumChart4 != undefined) {
            $scope.myDatumChart4.dispose();
        }
        $scope.myDatumChart4 = echarts.init(document.getElementById('statChart4'));
        //用于使chart自适应高度和宽度,通过窗体高宽计算容器高宽
        // 指定图表的配置项和数据
        $scope.option4 = {
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)" + $scope.chart4Unit
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

        // 使用刚指定的配置项和数据显示图表。
        $scope.myDatumChart4.setOption($scope.option4);
    };
    /****课程对比柱状图****/
    $scope.chartParam5 = function(){
        return{
            org_id : $('#venueSelect').val(),//场馆id
            date_type : $('#contrastTime').val(), //今日、本月、本年
            s_type : $('#contrastSelect').val(), //平均成交价、平均客单价、续约率、流失率
        }
    };
    $scope.initChart5 = function(){
        $scope.chartPath5();
        if($('#contrastSelect').val() == 1){
            $scope.chart5DataOne();
        }
        if($('#contrastSelect').val() == 2){
            $scope.chart5DataTwo();
        }

    };
    $scope.chartPath5 = function(){
        $scope.chartUrl5 = '/private-stat/sale-class-compare?' + $.param($scope.chartParam5())
    };
    $scope.chart5DataOne = function(){
        $.loading.show();
        $http.get($scope.chartUrl5).success(function(result){
            //console.log(result);
            if(result.data.length != 0){
                $scope.chart5XArr = [];
                $scope.chart5YArr = [];
                var $chartData5 = result.data;
                $chartData5.map(function(item,i){
                    $scope.chart5XArr.push(item.name);
                    $scope.chart5YArr.push((item.money / item.num).toFixed(2));
                    $scope.maxNum5 = Math.max.apply(null, $scope.chart5YArr);  //最大值
                    //console.log('data',$scope.clientDataArr);
                });
            }else{
                $scope.chart5XArr = ['PT课程','PT特色课程'];
                $scope.chart5YArr = [0,0];
            }
            $scope.getEchart5();
            $.loading.hide();
        })
    };
    $scope.chart5DataTwo = function(){
        $.loading.show();
        $http.get($scope.chartUrl5).success(function(result){
            //console.log(result);
            if(result.data.length != 0){
                $scope.chart5XArr = [];
                $scope.chart5YArr = [];
                var $chartData5 = result.data;
                $chartData5.map(function(item,i){
                    $scope.chart5XArr.push(item.name);
                    $scope.chart5YArr.push((item.money / item.member_num).toFixed(2));
                    $scope.maxNum5 = Math.max.apply(null, $scope.chart5YArr);  //最大值
                    //console.log('data',$scope.clientDataArr);
                });
            }else{
                $scope.chart5XArr = ['PT课程','PT特色课程'];
                $scope.chart5YArr = [0,0];
            }
            $scope.getEchart5();
            $.loading.hide();
        })
    };
    $timeout(function(){
        $scope.initChart5();
    },500);
    //平均成交价下拉框事件
    $scope.chartTypeName5 = '平均成交价';
    $scope.chart5Legend = ['平均成交价'];
    $scope.chart5YName = '元';
    $scope.contrastSelectChange = function(id){
        if(id == 1){
            $scope.chart5Legend = ['平均成交价'];
            $scope.chartTypeName5 = '平均成交价';
            $scope.chart5YName = '元';
        }
        if(id == 2){
            $scope.chart5Legend = ['平均客单价'];
            $scope.chartTypeName5 = '平均客单价';
            $scope.chart5YName = '元';
        }
        if(id == 3){
            $scope.chart5Legend = ['续约率'];
            $scope.chartTypeName5 = '续约率';
            $scope.chart5YName = '%';
        }
        if(id == 4){
            $scope.chart5Legend = ['流失率'];
            $scope.chartTypeName5 = '流失率';
            $scope.chart5YName = '%';
        }
        $scope.initChart5();
    };
    //今日、本月、本年度下拉框切换事件
    $scope.contrastTimeChange = function(id){
        $scope.initChart5();
    };
    $scope.getEchart5 = function(){
        if($scope.myDatumChart5 != null && $scope.myDatumChart5 != "" && $scope.myDatumChart5 != undefined) {
            $scope.myDatumChart5.dispose();
        }
        $scope.myDatumChart5 = echarts.init(document.getElementById('statChart5'));
        //用于使chart自适应高度和宽度,通过窗体高宽计算容器高宽
        // 指定图表的配置项和数据
        $scope.option5 = {
            title: {

            },
            tooltip: {},
            legend: {
                data:$scope.chart5Legend
            },
            xAxis: {
                data: $scope.chart5XArr,
            },
            yAxis: {
                type: 'value',
                name : $scope.chart5YName
            },
            series: [{
                name: $scope.chartTypeName5,
                type: 'bar',
                data: $scope.chart5YArr
            }],
            color: ['#60C9F9','#9933FF','#51D76A','#FF6600','#FECB2F','#FFB6C1']
        };

        // 使用刚指定的配置项和数据显示图表。
        $scope.myDatumChart5.setOption($scope.option5);
    };
    /****部门业绩环形图****/
    // $scope.getEchart6 = function(){
    //     if($scope.myDatumChart6 != null && $scope.myDatumChart6 != "" && $scope.myDatumChart6 != undefined) {
    //         $scope.myDatumChart6.dispose();
    //     }
    //     $scope.myDatumChart6 = echarts.init(document.getElementById('statChart6'));
    //     //用于使chart自适应高度和宽度,通过窗体高宽计算容器高宽
    //     // 指定图表的配置项和数据
    //     $scope.option6 = {
    //         tooltip: {
    //             trigger: 'item',
    //             formatter: "{a} <br/>{b}: {c} ({d}%)"
    //         },
    //         legend: {
    //             orient: 'vertical',
    //             x: 'left',
    //             data:['直接访问','邮件营销','联盟广告','视频广告','搜索引擎']
    //         },
    //         series: [
    //             {
    //                 name:'访问来源',
    //                 type:'pie',
    //                 radius: ['50%', '70%'],
    //                 avoidLabelOverlap: false,
    //                 label: {
    //                     normal: {
    //                         show: false,
    //                         position: 'center'
    //                     },
    //                     emphasis: {
    //                         show: true,
    //                         textStyle: {
    //                             fontSize: '30',
    //                             fontWeight: 'bold'
    //                         }
    //                     }
    //                 },
    //                 labelLine: {
    //                     normal: {
    //                         show: false
    //                     }
    //                 },
    //                 data:[
    //                     {value:335, name:'直接访问'},
    //                     {value:310, name:'邮件营销'},
    //                     {value:234, name:'联盟广告'},
    //                     {value:135, name:'视频广告'},
    //                     {value:1548, name:'搜索引擎'}
    //                 ]
    //             }
    //         ],
    //         color: ['#60C9F9','#9933FF','#51D76A','#FF6600','#FECB2F','#FFB6C1']
    //     };
    //
    //     // 使用刚指定的配置项和数据显示图表。
    //     $scope.myDatumChart6.setOption($scope.option6);
    // };
    //echarts自适应浏览器
    $scope.resetChart = function(){
        //
        $scope.getEchart1();
        //$scope.getEchart2();
        $scope.getEchart3();
        $scope.getEchart4();
        $scope.getEchart5();
        //$scope.getEchart6();
        window.onresize = function () {
            //重置容器宽高
            //
            $scope.myDatumChart1.resize();
            //$scope.myDatumChart2.resize();
            $scope.myDatumChart3.resize();
            $scope.myDatumChart4.resize();
            $scope.myDatumChart5.resize();
            //$scope.myDatumChart6.resize();
        };
    };
    $timeout(function(){
        $scope.resetChart();
    },500);
    /*********私教会员量排行榜***********/
    //参数
    $scope.rankParam = function(){
        return{
            org_id : $('#venueSelect').val(),   //场馆id
            order_type :$('#orderSelect').val(),//新单、续费
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
        $scope.rankUrl = '/private-stat/sale-rank?' + $.param($scope.rankParam())
    };
    $scope.rankListData = function(){
        $.loading.show();
        $http.get($scope.rankUrl).success(function(result){
            //console.log(result);
            if(result.data.length != 0){
                $scope.rankList = result.data;
                $scope.sellNoData = false;
                $('.sellList li').css('marginBottom','0');
            }else{
                $scope.rankList = [];
                $scope.sellNoData = true;
                $('.sellList li').css('marginBottom','50px');
            }
            $.loading.hide();
        })
    };
    $timeout(function () {
        $scope.rankInit();
    },600);
    //日排行、周排行、月排行下拉框切换事件
    $scope.rankSelectChange = function(id){
        $scope.rankInit();
    };
    //新单、续费下拉框切换事件
    $scope.orderSelectChange = function(id){
        $scope.rankInit();
    };
    //获取今日、本周日期
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
    //详情模态框
    $scope.sellClick = function(type){
        $('#sellModal').modal('show');
        switch(type){
            case 1 :
                $scope.sellModalTitle = '成交额';
                $scope.show1 = true;
                break;
            case 2 :
                $scope.sellModalTitle = '成交量';
                $scope.show2 = true;
                break;
            case 3 :
                $scope.sellModalTitle = '体验课成交率';
                $scope.show3 = true;
                break;
            case 4 :
                $scope.sellModalTitle = '平均成交价';
                $scope.show4 = true;
                break;
            case 5 :
                $scope.sellModalTitle = '平均客单价';
                $scope.show5 = true;
                break;
        }
        $scope.getPrivate();
        $scope.getClassType();
    };
    //获取私教人员信息
    $scope.getPrivate = function(){
        $http.get("/private-teach/private-coach").success(function (response) {
            $scope.praviteList = response;
        });
    };
    //获取课种
    $scope.getClassType = function(){
        $http.get('/rechargeable-card-ctrl/get-private-data').success(function(result){
            //console.log(result);
            $scope.classTypeList = result.venue;
        })
    };
    $('#sellModal').on('shown.bs.modal', function () {
        $('.sellModalSelect1').val($('#venueSelect').val());
        if($('#dateType').val() == 1){
            $scope.getNowDay();
            $("#sellModalDate").val($scope.nowDay + ' - ' + $scope.nowDay);
        }
        if($('#dateType').val() == 2){
            $scope.getNowDay();
            $("#sellModalDate").val($scope.weekMonday + ' - ' + $scope.weekSunday);
        }
        if($('#dateType').val() == 3){
            $scope.getMonthOneAndMonthLast();
        }
        if($('#dateType').val() == 4 && $('#freeDate').val() != ''){
            $("#sellModalDate").val($('#freeDate').val())
        }
        if($('#dateType').val() == 4 && $('#freeDate').val() == ''){
            $scope.getNowDay();
            $("#sellModalDate").val($scope.nowDay + ' - ' + $scope.nowDay);
        }
        $scope.sellModalDateInit();
        $scope.initBox();
    });

    //日期事件
    $scope.sellModalDateInit = function(){
        $scope.sellStartDate = '';
        $scope.sellEndDate = '';
        if($("#sellModalDate").val() != ''){
            var startTime = $("#sellModalDate").val().substr(0, 10);
            $scope.sellStartDate = startTime+' '+ "00:00:00";
            var endTime = $("#sellModalDate").val().substr(-10, 10);
            $scope.sellEndDate  = endTime+' '+"23:59:59";
        }
    };
    //初始化获取当月的第一天和最后一天
    $scope.getMonthOneAndMonthLast = function(){
        var date = new Date();
        $scope.sellStartDate =$scope.getMyDate(date.setDate(1));
        $scope.tiemSelectStart = $scope.getMyDate(date.setDate(1)) + ' 00:00:00';
        $scope.rankDateStart =$scope.getMyDate(date.setDate(1)) + ' 00:00:00';
        var currentMonth=date.getMonth();
        var nextMonth=++currentMonth;
        var nextMonthFirstDay=new Date(date.getFullYear(),nextMonth,1);
        var oneDay=1000*60*60*24;
        $scope.sellEndDate = $scope.getMyDate(nextMonthFirstDay-oneDay);
        $scope.timeSelectEnd = $scope.getMyDate(nextMonthFirstDay-oneDay) + ' 23:59:59';
        $scope.rankDatetEnd = $scope.getMyDate(nextMonthFirstDay-oneDay) + ' 23:59:59';
        $('#sellModalDate').val($scope.sellStartDate+' - '+ $scope.sellEndDate);
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
    $scope.sellModalParam = function(){
        return{
            org_id: $('.sellModalSelect1').val(),
            private_id : $('.sellModalSelect2').val(),
            class_type : $('.sellModalSelect3').val(),
            order_type : $('.sellModalSelect4').val(),
            start_time : $scope.sellStartDate != undefined && $scope.sellStartDate != '' ? $scope.sellStartDate : null,
            end_time:$scope.sellEndDate != undefined && $scope.sellEndDate != '' ? $scope.sellEndDate : null,
            keyWord : $scope.searchKeyword
        }
    };
    //初始化
    $scope.initBox = function(){
        $scope.boxPath();
        $scope.getTabList();
    };
    //模态框路径
    $scope.boxPath = function(){
        $scope.boxUrl = '/private-stat/sale-deal?' + $.param($scope.sellModalParam())
    };
    //模态框列表
    $scope.getTabList = function(){
        $.loading.show();
        $http.get($scope.boxUrl).success(function(result){
            //console.log(result);
            $scope.totalMember = result.totalMember;
            $scope.totalClass = result.totalClass;
            $scope.totalMoney = result.totalMoney;
            if(result.data.length != 0){
                $scope.sellModalList = result.data;
                $scope.sellModalNowPage = result.now_page;
                $scope.sellModalPage = result.pages;
                $scope.sellModalNoData = false;
            }else{
                $scope.sellModalList = result.data;
                $scope.sellModalNowPage = result.now_page;
                $scope.sellModalPage = result.pages;
                $scope.sellModalNoData = true;
            }
            $.loading.hide();
        })
    };
    //分页
    $scope.saleDealPages = function(url){
        $scope.boxUrl = url;
        $scope.getTabList();
    };
    //确定按钮
    $scope.searchSellBtn = function(){
        $scope.sellModalDateInit();
        $scope.initBox();
    };
    //enter键搜索
    $scope.enterSearch = function(){
        var event = window.event || arguments.callee.caller.arguments[0];
        if (event.keyCode == 13) {
            $scope.searchSellBtn();
        }
    };
    //模态框清空按钮
    $scope.clearSellBtn = function(){
        $('#select2-sellPrivateSelect-container').text('私教').attr('私教');
        $('#select2-sellClassType-container').text('课种').attr('课种');
        $('.sellModalSelect2').val('');
        $('.sellModalSelect3').val('');
        $('.sellModalSelect4').val('');
        $('#sellModalDate').val('');
        $scope.searchKeyword = '';
        $scope.sellModalDateInit();
        $scope.initBox();
    };
    $('#sellModal').on('hidden.bs.modal', function (e) {
        // do something...
        $('.sellModalSelect2').val('');
        $('.sellModalSelect3').val('');
        $('.sellModalSelect4').val('');
        $('#sellModalDate').val('');
        $scope.searchKeyword = '';
    });
    //查看详情
    $scope.getMemberDataCardBtn = function(id){
        //向子元素控制器传参
        $scope.$broadcast('to-child',id);
        $scope.$emit('to-parent', 'parent');
        $('#publicMemberInfoModal').modal('show');
    }
});