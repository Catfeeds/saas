/*
私教统计-客户*/
$(function(){
    $('#expireDate').daterangepicker(null, function(start, end, label) {

    });
    $('#donateDate').daterangepicker(null, function(start, end, label) {

    });

    $('#birthdayDate').daterangepicker({
        format: 'MM-DD',
    }, function(start, end, label) {
        $('#birthdayDate').val(start.format('MM-DD') + ' - ' + end.format('MM-DD'))
    });
    $('.input-mini').css('textAlign','center');
});
angular.module('App').controller('clientStatCtrl',function($http,$scope,$timeout){
    $('.topUl li').on('click',function(){
        var $index = $(this).index();
        $(this).addClass('topLiActive').siblings().removeClass('topLiActive');
    });
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
        $scope.boxInit();
        //今日分析
        $scope.todayInit();
        //6个统计
        $scope.boxInit();
        $scope.notClassInit();
        //最近人数
        $scope.latelyInit();
        //获取客户分析
        $scope.clientInit();
        //获取私教会员排行
        $scope.peopleInit();

    };
    /************今日分析**********/
    //初始化日期
    $scope.getDate = function(){
        var oDate = new Date();
        var oYear = oDate.getFullYear();
        var oMonth = oDate.getMonth()+1;
        var oDay = oDate.getDate();
    };
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
            //console.log(Number($scope.money.today),Number($scope.money.yesterday));
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

    /************最近天数折线图**********/
    //最近下拉事件
    $scope.daySelectChange = function(id){
        if(id == 1){
            $scope.latelyInit();
        }else{
            $scope.latelyInit();
        }
    };
    //参数
    $scope.latelyParam = function(){
        return{
            date_type : $('#latelySelect').val(),
            org_id :$scope.venueId != undefined && $scope.venueId  != '' ? $scope.venueId : null
        }
    };
    //初始化获取最近天数数据
    $scope.latelyInit = function(){
        $scope.latelyInitUrl();
        $scope.getLatelyData();
    };
    $scope.latelyInitUrl = function(){
        $scope.latelyUrl = '/private-stat/get-new-member-info?' + $.param($scope.latelyParam())
    };
    //获取数据
    $scope.getLatelyData = function(){
        $.loading.show();
        $http.get($scope.latelyUrl).success(function(result){
            //console.log(result);
            if(result.length == 0){
                $scope.lateDateArr = [];
                $scope.lateNumArr = [];
            }else{
                var $latelyData = result;
                $scope.lateDateArr = [];
                $scope.lateNumArr = [];
                $latelyData.map(function(item,i){
                    $scope.lateDateArr.push(item.date);
                    $scope.lateNumArr.push(item.num);
                    //console.log($scope.lateNumArr);
                    $scope.maxNum = Math.max.apply(null, $scope.lateNumArr);//最大值
                    $scope.minNum = Math.min.apply(null, $scope.lateNumArr);//最小值
                })
            }
            $scope.getEchart();
            $.loading.hide();
        })
    };
    $timeout(function(){
        $scope.latelyInit();
    },500);
    //表格
    $scope.getEchart = function(){
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
                data:['正式客户']
            },
            calculable : true,
            xAxis : [
                {
                    type : 'category',
                    axisTick: {
                        alignWithLabel: true
                    },
                    data : $scope.lateDateArr
                }
            ],
            yAxis : [
                {
                    type : 'value',
                    axisLabel : {
                        formatter: '{value}'
                    },
                    name : '人数',
                    min: 0,
                    max:$scope.maxNum,
                    splitNumber : 4
                }
            ],
            series : [
                {
                    name:'正式客户',
                    type:'line',
                    data:$scope.lateNumArr,
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
        // 使用刚指定的配置项和数据显示图表。
        $scope.myDatumChart1.setOption($scope.option1);
    };
    //去除下拉框空白内容
    $scope.removeOption = function(){
        var $daySelect = $(".daySelect");
        $daySelect.each(function(i,item){
            var $option = $(this).find('option').eq(0).html();
            if($option == '' || $option == null ){
                $(this).find('option').eq(0).remove();
            }
        })
    };
    $timeout(function(){
        $scope.removeOption();
    },300);
    /************客户分析饼状图数据**********/
    //参数
    $scope.clientParam = function(){
        return{
            member_type : $('#clientSelect').val(),
            type : $('#clientType').val(),
            org_id : $scope.venueId != undefined && $scope.venueId  != '' ? $scope.venueId : null
        }
    };
    //初始化获取客户分析数据
    $scope.clientInit = function(){
        $scope.clientInitUrl();
        $scope.getClientData();
    };
    $scope.clientInitUrl = function(){
        $scope.clientUrl = '/private-stat/get-member-info?' + $.param($scope.clientParam())
    };
    $scope.getClientData = function(id){
        $.loading.show();
        $http.get($scope.clientUrl).success(function(result){
            //console.log(result);
            $scope.clientDataArr = [];
            $scope.clientNameArr = [];
            var $clientData = result;
            $clientData.map(function(item,i){
                var aa = item.a_sex,bb = item.num;
                var data1 = {
                    value :bb,
                    name : aa
                };
                $scope.clientDataArr.push(data1);
                $scope.clientNameArr.push(aa);
                //console.log('data',$scope.clientDataArr);
            });
            $scope.getEchart3();
            $.loading.hide();
        })
    };
    $timeout(function(){
        $scope.clientInit();
    },500);
    //正式客户、潜在客户下拉框
    $scope.clientSelectChange = function(id){
        $scope.clientInit();
    };
    //性别下拉框
    $scope.clientTypeName = $('#clientType').children('option').eq(0).text();
    $scope.clientTypeChange = function(id){
        $scope.clientTypeName = $('#clientType').children('option').eq(id - 1).text();
        $scope.clientInit();
    };
    //客户分析图表
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
            //     data: $scope.clientNameArr
            // },
            series : [
                {
                    name: $scope.clientTypeName,
                    type: 'pie',
                    radius: '55%',
                    data : $scope.clientDataArr,
                }
            ],
            color: ['#60C9F9','#9933FF','#51D76A','#FF6600','#FECB2F','#FFB6C1']
        };
        // 使用刚指定的配置项和数据显示图表。
        $scope.myDatumChart3.setOption($scope.option3);

    };
    //echarts自适应浏览器
    $scope.resetChart = function(){
        $scope.getEchart();
        $scope.getEchart3();
        window.onresize = function () {
            //重置容器宽高
            $scope.myDatumChart1.resize();
            $scope.myDatumChart3.resize();
        };
    };
    $timeout(function(){
        $scope.resetChart();
    },500);

    /********私教会员量排行榜********/
    //参数
    $scope.peopleParam = function(){
        return{
            // member_type : $('#peopleSelect').val(),
            org_id : $('#venueSelect').val()
        }
    };
    //初始化
    $scope.peopleInit = function(){
        $scope.peopleInitUrl();
        $scope.getPeopleData();
    };
    $scope.peopleInitUrl = function(){
        $scope.peopleUrl = '/private-stat/get-member-by-privater?' + $.param($scope.peopleParam());
    };
    $scope.getPeopleData = function(){
        $.loading.show();
        $http.get($scope.peopleUrl).success(function(result){
            //console.log(result);
            $scope.peopleList = result;
            $.loading.hide();
        })
    };
    $timeout(function(){
        $scope.peopleInit();
    },300);
    //全部和有效会员下拉框
    // $scope.peopleSelectChange = function(id){
    //     $scope.peopleInit();
    // };
    //到期时间
    $scope.expireDateInit = function(){
        $scope.expireStartDate = '';
        $scope.expireEndDate = '';
        if($("#expireDate").val() != ''){
            var startTime = $("#expireDate").val().substr(0, 10);
            $scope.expireStartDate = startTime+' '+ "00:00:00";
            var endTime = $("#expireDate").val().substr(-10, 10);
            $scope.expireEndDate  = endTime+' '+"23:59:59";
        }
    };
    //赠送时间
    $scope.donateDateInit = function(){
        $scope.donateStartDate = '';
        $scope.donateEndDate = '';
        if($("#donateDate").val() != ''){
            var startTime = $("#donateDate").val().substr(0, 10);
            $scope.donateStartDate = startTime+' '+ "00:00:00";
            var endTime = $("#donateDate").val().substr(-10, 10);
            $scope.donateEndDate  = endTime+' '+"23:59:59";
        }
    };
    //生日时间
    $scope.birthDateInit = function(){
        $scope.birthStartDate = '';
        $scope.birthEndDate = '';
        if($("#birthdayDate").val() != ''){
            var startTime = $("#birthdayDate").val().substr(0, 5);
            $scope.birthStartDate = '2018' + '-' + startTime;
            var endTime = $("#birthdayDate").val().substr(-5, 5);
            $scope.birthEndDate  = '2018' + '-' + endTime;
        }else{
            $scope.birthStartDate = '';
            $scope.birthEndDate = '';
        }
    };
    //初始化获取当月的第一天和最后一天
    $scope.getMonthOneAndMonthLast = function(){
        var date = new Date();
        $scope.birthStartDate =$scope.getMyDate2(date.setDate(1));
        $scope.expireStartDate =$scope.getMyDate(date.setDate(1));
        $scope.donateStartDate =$scope.getMyDate(date.setDate(1));
        $scope.nowDayStart =$scope.getMyDate(date.setDate(1)) + ' 00:00:00';
        var currentMonth=date.getMonth();
        var nextMonth=++currentMonth;
        var nextMonthFirstDay=new Date(date.getFullYear(),nextMonth,1);
        var oneDay=1000*60*60*24;
        $scope.birthEndDate = $scope.getMyDate2(nextMonthFirstDay-oneDay);
        $scope.expireEndDate = $scope.getMyDate(nextMonthFirstDay-oneDay);
        $scope.donateEndDate = $scope.getMyDate(nextMonthFirstDay-oneDay);
        $scope.nowDayEnd = $scope.getMyDate(nextMonthFirstDay-oneDay) + ' 23:59:59';
        $('#birthdayDate').val($scope.birthStartDate+' - '+ $scope.birthEndDate);
        $('#expireDate').val($scope.expireStartDate+' - '+ $scope.expireEndDate);
        $('#donateDate').val($scope.donateStartDate+' - '+ $scope.donateEndDate);
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
        $scope.weekMonday = $scope.getMyDate(MondayTime);
        var SundayTime =  nowTime + (7-day)*oneDayLong ;
        $scope.weekSunday = $scope.getMyDate(SundayTime);
        $scope.nowDay = year + "-" + month + "-" + date;
        var threeDaysAgo = now.setDate(now.getDate()-3);
        $scope.formatDay = $scope.getMyDate(threeDaysAgo);//三天前
        console.log($scope.formatDay,$scope.nowDay)
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
    //时间戳转换为年月日
    $scope.getMyDate2 = function(str){
        str = parseInt(str);
        if(str!=""||str!=null){
            var oDate = new Date(str);
            var oYear = oDate.getFullYear();
            var oMonth = oDate.getMonth()+1;
            oMonth = oMonth>=10? oMonth:'0'+oMonth;
            var oDay = oDate.getDate();
            oDay = oDay>=10? oDay:'0'+oDay;
            var theDate = oMonth+"-"+oDay;
        }else{
            theDate = "";
        }
        return theDate
    };
    //即将到期、生日会员、体验课未执行、最近未跟进统计
    $scope.boxParam = function(){
        return{
            org_id : $('#venueSelect').val(),
            start_time : $scope.nowDayStart,
            end_time : $scope.nowDayEnd,
        }
    };
    $scope.boxInit = function(){
        $scope.getMonthOneAndMonthLast();
        $scope.boxPath();
        $scope.getBox();
    };
    $scope.boxPath = function(){
        $scope.boxUrl = '/private-stat/member-num?' + $.param($scope.boxParam())
    };
    $scope.getBox = function(){
        $.loading.show();
        $http.get($scope.boxUrl).success(function(result){
            //console.log(result);
            $scope.expire_num = result.data.expire_num; //即将到期
            $scope.birth_num = result.data.birth_num;   //生日会员
            $scope.notExecuted_num = result.data.notExecuted_num;//体验课未执行
            //$scope.notFollow_num = result.data.notFollow_num;//最近未跟进
            $.loading.hide();
        })
    };
    $timeout(function () {
        $scope.boxInit();
    },600);
    //客户量、最近未上课统计
    $scope.notClassParam = function(){
        return{
            org_id : $('#venueSelect').val(),
            start_time :$scope.formatDay + ' 00:00:00',
            end_time : $scope.nowDay + ' 23:59:59',
        }
    };
    $scope.notClassInit = function(){
        $scope.getNowDay();
        $scope.notClassPath();
        $scope.getNotClassData();
    };
    $scope.notClassPath = function(){
        $scope.notClassUrl  = '/private-stat/not-class-num?' + $.param($scope.notClassParam())
    };
    $scope.getNotClassData = function(){
        $.loading.show();
        $http.get($scope.notClassUrl).success(function(result){
            //console.log(result);
            $scope.member_num = result.data.member_num; //客户量
            $scope.notClass_num = result.data.notClass_num;//最近未上课
            $.loading.hide();
        })
    };
    $timeout(function () {
        $scope.notClassInit();
    },600);

    //点击事件
    $scope.boxClick = function(type){
        //console.log(type);
        $('#clientModal').modal('show');
        switch(type){
            case 1 :
                $scope.modalTitle = '客户量';
                $scope.show1 = true;
                break;
            case 2 :
                $scope.modalTitle = '最近未上课';
                $scope.show2 = true;
                break;
            case 3 :
                $scope.modalTitle = '最近未跟进';
                $scope.show3 = true;
                break;
            case 4 :
                $scope.modalTitle = '即将到期';
                $scope.show4 = true;
                break;
            case 6 :
                $scope.modalTitle = '体验课未执行';
                $scope.show6 = true;
                break;
        }
        $scope.getPrivate();

    };

    $scope.getPrivate = function(){
        //获取私教人员信息
        $http.get("/private-teach/private-coach").success(function (response) {
            $scope.praviteList = response;
        });
    };

    //模态框详情参数
    //客户量参数
    $scope.modalParam1 = function(){
        return{
            org_id : $('.modalSelect0').val(),      //场馆
            status : $('.modalSelect1').val(),      //会员类别 -- 正式会员、潜在会员
            sex : $('.modalSelect3').val(),         //性别
            type4 : $('.modalSelect4').val(),       //来源
            keyWord : $scope.searchKeyword          //关键字
        }
    };
    //最近未上课参数
    $scope.modalParam2 = function(){
        return{
            org_id : $('.modalSelect0').val(),     //场馆
            private_id : $('.modalSelect5').val(), //私教
            days : $('.modalSelect6').val(),       //最近几天未上课
            keyWord : $scope.searchKeyword         //关键字
        }
    };
    //最近未跟进参数
    $scope.modalParam3 = function(){
        return{
            org_id : $('.modalSelect0').val(),     //场馆
            private_id : $('.modalSelect5').val(), //私教
            days : $('.modalSelect7').val(),       //最近未跟进
            keyWord : $scope.searchKeyword         //关键字
        }
    };
    //即将到期参数
    $scope.modalParam4 = function(){
        return{
            org_id : $('.modalSelect0').val(),          //场馆
            private_id : $('.modalSelect5').val(),      //私教
            overage_section : $('.modalSelect8').val(), //剩余节数
            start_time : $scope.expireStartDate,        //开始时间
            end_time : $scope.expireEndDate,            //结束时间
            keyWord : $scope.searchKeyword              //关键字
        }
    };
    //体验课未执行参数
    $scope.modalParam6 = function(){
        return{
            org_id : $('.modalSelect0').val(),     //场馆
            private_id : $('.modalSelect5').val(), //私教
            start_time : $scope.donateStartDate,   //开始时间
            end_time : $scope.donateEndDate,       //结束时间
            keyWord : $scope.searchKeyword         //关键字
        }
    };
    //点击客户量
    $scope.modalInitPath = function(){
        if($scope.show1){
            $scope.modalUrl = '/private-stat/get-private-member?' + $.param($scope.modalParam1());
        }
        if($scope.show2){
            $scope.modalUrl = '/private-stat/not-go-class-member?' + $.param($scope.modalParam2());
        }
        if($scope.show3){
            $scope.modalUrl = '/private-stat/not-follow?' + $.param($scope.modalParam3());
        }
        if($scope.show4){
            $scope.modalUrl = '/private-stat/soon-to-expire?' + $.param($scope.modalParam4());
        }
        if($scope.show6){
            $scope.modalUrl = '/private-stat/class-not-executed?' + $.param($scope.modalParam6());
        }
    };
    $scope.getData1 = function(){
        $.loading.show();
        $http.get($scope.modalUrl).success(function(result){
            //console.log(result);
            $scope.total1 = result.totalCount;
            if(result.data.length != 0){
                $scope.tabList1 = result.data;
                $scope.tab1NoData = false;
                $scope.nowPage1 = result.now_page;
                $scope.tab1Page = result.pages;
            }else{
                $scope.tabList1 = result.data;
                $scope.tab1NoData = true;
                $scope.tab1Page = result.pages;
            }
            $.loading.hide();
        })
    };
    //分页
    $scope.clientPages = function(url){
        if($scope.show1){
            $scope.modalUrl = url;
            $scope.getData1();
        }
    };
    //最近未上课
    $scope.getData2 = function(){
        $.loading.show();
        $http.get($scope.modalUrl).success(function(result){
            //console.log(result);
            $scope.total2 = result.totalCount;
            if(result.data.length != 0){
                $scope.tabList2 = result.data;
                $scope.tab2NoData = false;
                $scope.nowPage2 = result.now_page;
                $scope.tab2Page = result.pages;
            }else{
                $scope.tabList2 = result.data;
                $scope.tab2NoData = true;
                $scope.tab2Page = result.pages;
            }
            $.loading.hide();
        })
    };
    //分页
    $scope.NotGoClassMemberPages = function(url){
        if($scope.show2){
            $scope.modalUrl = url;
            $scope.getData2();
        }
    };
    //最近未跟进
    $scope.getData3 = function(){
        $.loading.show();
        $http.get($scope.modalUrl).success(function(result){
            //console.log(result);
            $scope.total3 = result.totalCount;
            if(result.data.length != 0){
                $scope.tabList3 = result.data;
                $scope.tab3NoData = false;
                $scope.nowPage3 = result.now_page;
                $scope.tab3Page = result.pages;
            }else{
                $scope.tabList3 = result.data;
                $scope.tab3NoData = true;
                $scope.tab3Page = result.pages;
            }
            $.loading.hide();
        })
    };
    //分页
    $scope.NotFollowPages = function(url){
        if($scope.show3){
            $scope.modalUrl = url;
            $scope.getData3();
        }
    };
    //即将到期数据
    $scope.getData4 = function(){
        $.loading.show();
        $http.get($scope.modalUrl).success(function(result){
            //console.log(result);
            $scope.total4 = result.totalCount;
            if(result.data.length != 0){
                $scope.tabList4 = result.data;
                $scope.tab4NoData = false;
                $scope.nowPage4 = result.now_page;
                $scope.tab4Page = result.pages;
            }else{
                $scope.tabList4 = result.data;
                $scope.tab4NoData = true;
                $scope.tab4Page = result.pages;
            }
            $.loading.hide();
        })
    };
    //分页
    $scope.SoonToExpirePages = function(url){
        if($scope.show4){
            $scope.modalUrl = url;
            $scope.getData4();
        }
    };
    //体验课未执行
    $scope.getData6 = function(){
        $.loading.show();
        $http.get($scope.modalUrl).success(function(result){
            //console.log(result);
            $scope.total6 = result.totalCount;
            if(result.data.length != 0){
                $scope.tabList6 = result.data;
                $scope.tab6NoData = false;
                $scope.nowPage6 = result.now_page;
                $scope.tab6Page = result.pages;
            }else{
                $scope.tabList6 = result.data;
                $scope.tab6NoData = true;
                $scope.tab6Page = result.pages;
            }
            $.loading.hide();
        })
    };
    //分页
    $scope.NotExecutedPages = function(url){
        if($scope.show6){
            $scope.modalUrl = url;
            $scope.getData6();
        }
    };
    //模态框
    $('#clientModal').on('shown.bs.modal', function () {
        $('.modalSelect0').val($('#venueSelect').val());
        $('#privateSelect').select2({
            width:'100%'
        });
        $scope.getMonthOneAndMonthLast();
        if($scope.show1){
            $scope.modalInitPath();
            $scope.getData1();
        }
        if($scope.show2){
            $('.modalSelect6').val(3);
            $scope.modalInitPath();
            $scope.getData2();
        }
        if($scope.show3){
            $('.modalSelect7').val(30);
            $scope.modalInitPath();
            $scope.getData3();
        }
        if($scope.show4){
            $scope.expireDateInit();
            $scope.modalInitPath();
            $scope.getData4();
        }
        if($scope.show6){
            $scope.donateDateInit();
            $scope.modalInitPath();
            $scope.getData6();
        }
    });
    $('#clientModal').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.show1 = false;
        $scope.show2 = false;
        $scope.show3 = false;
        $scope.show4 = false;
        $scope.show6 = false;
        $('.modalSelect0').val('');
        $('.modalSelect1').val('');
        $('.modalSelect2').val('');
        $('.modalSelect3').val('');
        $('.modalSelect4').val('');
        $('.modalSelect5').val('');
        $('.modalSelect6').val('');
        $('.modalSelect7').val('');
        $('.modalSelect8').val('');
        $scope.searchKeyword = '';
    });
    //确定按钮
    $scope.searchBtn = function(){
        if($scope.show1){
            $scope.modalInitPath();
            $scope.getData1();
            //console.log($scope.modalParam1());
        }
        if($scope.show2){
            $scope.modalInitPath();
            $scope.getData2();
            //console.log($scope.modalParam2());
        }
        if($scope.show3){
            $scope.modalInitPath();
            $scope.getData3();
            //console.log($scope.modalParam3());
        }
        if($scope.show4){
            $scope.expireDateInit();
            $scope.modalInitPath();
            $scope.getData4();
            //console.log($scope.modalParam4());
        }
        if($scope.show6){
            $scope.donateDateInit();
            $scope.modalInitPath();
            $scope.getData6();
            //console.log($scope.modalParam6());
        }
    };
    //enter键搜索
    $scope.enterSearch = function(){
        var event = window.event || arguments.callee.caller.arguments[0];
        if (event.keyCode == 13) {
            $scope.searchBtn();
        }
    };
    //清空按钮
    $scope.clearSearchBtn = function(){
        //$('.modalSelect0').val('');
        $('#select2-privateSelect-container').text('私教').attr('title','私教');
        $('.modalSelect1').val('');
        $('.modalSelect2').val('');
        $('.modalSelect3').val('');
        $('.modalSelect4').val('');
        $('.modalSelect5').val('');
        $('.modalSelect6').val('');
        $('.modalSelect7').val('');
        $('.modalSelect8').val('');
        $('#donateDate').val('');
        $scope.searchKeyword = '';
        $scope.searchBtn();
    };

    //生日会员
    $scope.birthClick = function(){
        $('#birthdayModal').modal('show');
    };
    $('#birthdayModal').on('shown.bs.modal', function () {
        $('.birthVenueSelect').val($('#venueSelect').val());
        $scope.getMonthOneAndMonthLast();
        $scope.birthdayInit();
    });
    //筛选生日会员的数据
    $scope.getBirthdaySearchData = function(){
        return {
            status         :$scope.ptClassStatus     != undefined && $scope.ptClassStatus      != '' ? parseInt($scope.ptClassStatus) : null,
            keywords       :$scope.memberBirKeywords != undefined && $scope.memberBirKeywords  != '' ? $scope.memberBirKeywords : null,
            venueId        :$('.birthVenueSelect').val(),
            startTime      :$scope.birthStartDate    != undefined && $scope.birthStartDate     != '' ? $scope.birthStartDate: null,
            endTime        :$scope.birthEndDate      != undefined && $scope.birthEndDate       != '' ? $scope.birthEndDate: null,
        }
    };
    $scope.birthdayInit = function(){
        $scope.birthDateInit();
        $scope.birthdayPath();
        $scope.getBirthdayDate();
    };
    $scope.birthdayPath = function(){
        $scope.memberBirUrlInit = '/private-statistics/birthday-member?'+ $.param($scope.getBirthdaySearchData());
    };
    //获取所有的生日会员
    $scope.getBirthdayDate = function(){
        $.loading.show();
        $http.get($scope.memberBirUrlInit).then(function(response){
            $scope.total5 = response.data.totalNum;
            if(response.data.data.length != 0){
                $scope.allMemberBirthdayLists = response.data.data;
                $scope.allMemberNow = response.data.now;
                $scope.allMemberPages = response.data.pages;
                $scope.allMemberFlag   = false;
            }else{
                $scope.allMemberBirthdayLists = response.data.data;
                $scope.allMemberPages = response.data.pages;
                $scope.allMemberFlag  = true;
            }
            $.loading.hide();
        });
    };

    //清空生日筛选
    $scope.memberBirSubmitClear = function(){
        $scope.ptClassStatus = '';
        $scope.memberBirKeywords = '';
        //$('.birthVenueSelect').val('');
        $scope.getMonthOneAndMonthLast();
        $scope.birthdayInit();
    };
    //搜索生日会员
    $scope.searchMemberBir = function(){
        $scope.birthdayInit();
    };
    //keyup输入搜索
    $scope.enterSearchMemberBir123 = function(e){
        var keyCode = window.event ? e.keyCode : e.which;
        if(keyCode == 13){
            $scope.searchMemberBir();
        }
    };

    //生日会员分页
    $scope.birthdayPages = function(urlPages){
        $scope.memberBirUrlInit = urlPages;
        $scope.getBirthdayDate();
    };
    /**********私教会员排行榜  查看会员量************/
    $scope.memberNumBtn = function(object){
        $('#memberNum').modal('show');
        //console.log(object);
        $scope.privateName = object.name; //教练姓名
        $scope.modalPrivateId = object.private_id;//教练Id
    };
    $('#memberNum').on('shown.bs.modal', function () {
         $scope.memberNumPath();
         $scope.getMemberNumData();
    });
    //参数
    $scope.memberNumParam = function(){
        return{
            org_id:$('#venueSelect').val(),     //场馆
            sex : $('.memberNumSelect4').val(), //性别
            private_id :$scope.modalPrivateId,  //私教Id
            course_type : $('.memberNumSelect2').val(), //会员类别 -- 正式会员、潜在会员
            member_type : $('.memberNumSelect3').val() != undefined ? $('.memberNumSelect3').val() : '', //会员状态 -- 有效会员、到期会员
            keyWord : $scope.searchKeyword1 != undefined && $scope.searchKeyword1  != '' ? $scope.searchKeyword1 : null,//关键字
        }
    };
    //路径
    $scope.memberNumPath = function(){
        $scope.memberNumUrl = '/private-stat/get-member-list?' + $.param($scope.memberNumParam())
    };
    //列表
    $scope.getMemberNumData = function(){
        $.loading.show();
        $http.get($scope.memberNumUrl).success(function(result){
            //console.log(result);
            $scope.memberNumTotal = result.totalCount;
            if(result.data.length != 0){
                $scope.memberNumList = result.data;
                $scope.memberNumNowPage = result.now_page;
                $scope.memberNumNoData = false;
                $scope.memberNumPage = result.pages;
            }else{
                $scope.memberNumList = result.data;
                $scope.memberNumNowPage = result.now_page;
                $scope.memberNumNoData = true;
                $scope.memberNumPage = result.pages;
            }
            $.loading.hide();
        })
    };
    //分页
    $scope.listByPrivaterPages = function(url){
        $scope.memberNumUrl = url;
        $scope.getMemberNumData();
    };
    //确定按钮
    $scope.memberSearchBtn = function(){
        $scope.memberNumPath();
        $scope.getMemberNumData();
    };
    //enter键
    $scope.enterSearch1 = function(){
        var event = window.event || arguments.callee.caller.arguments[0];
        if (event.keyCode == 13) {
            $scope.memberSearchBtn();
        }
    };
    //清空按钮
    $scope.clearMemberSearch = function(){
        $('.memberNumSelect2').val('');
        $('.memberNumSelect3').val('');
        $('.memberNumSelect4').val('');
        $scope.searchKeyword1 = '';
        $scope.modalMemberType = '';
        $scope.memberNumPath();
        $scope.getMemberNumData();
    };
    //模态框关闭
    $('#memberNum').on('hidden.bs.modal', function (e) {
        // do something...
        $('.memberNumSelect2').val('');
        $('.memberNumSelect3').val('');
        $('.memberNumSelect4').val('');
        $scope.searchKeyword1 = '';
        $scope.modalMemberType = '';
    });
    //查看详情
    $scope.getMemberDataCardBtn = function(id){
        //向子元素控制器传参
        $scope.$broadcast('to-child',id);
        $scope.$emit('to-parent', 'parent');
        $('#publicMemberInfoModal').modal('show');
    };
    $('#publicMemberInfoModal').on('hidden.bs.modal', function () {
        $('body').addClass('modal-open')

    });
});