/*Mr.yang*/
angular.module('App').controller('teamClassCtrl',['$scope', '$http',function($scope,$http,$interval){
    //文档加载准备插件
    $(function () {
        $('#myTab li:eq(0) a').tab('show');
        //初始化团课统计
        $scope.bestChose = "1";
        //初始化课程环比
        $scope.bestChoseState = "1";
        //序号
        $scope.num = '1';
        //daterangepicker
        $('#sellDate,#sellDate1,#sellDate2,#sellDate3,#nowDate,#prevDate').daterangepicker(null, function(start, end, label) { });
        //bootstrap select2
        $('select#venueId1,select#venueId2, select#bestChose').select2();
    });
    // 日期插件设置默认值
    $scope.dateInit = function () {
            var dd = new Date();
            var y = dd.getFullYear();
            var m = dd.getMonth()+1;//获取当前月份的日期
            var M = dd.getMonth();
            if(M == 0){
                M = 12;
                y = y-1;
            }
            var d = dd.getDate();
            if(m.toString().length == 1){
                m = '0' + m.toString();
            }
            if(d.toString().length == 1){
                d = '0' + d.toString();
            }
            if(M.toString().length == 1){
                M = '0' + M.toString();
            }
            var dateRe  = y+"-"+m+"-"+d;
            var dateRe1 = y+"-"+m+'-'+'01';
            var dateRe2 = y+"-"+M+'-'+'01';
            var differ  = new Date(dateRe).getTime()-new Date(dateRe1).getTime();

             $("#sellDate").val(dateRe + ' - ' + dateRe);
             $("#nowDate").val(dateRe1 + ' - ' + dateRe);
             $("#prevDate").val(dateRe2 + ' - ' + new Date(new Date(dateRe2).getTime()+differ).toLocaleDateString().replace(/\//g, '-'));
    };

    //初始化所有插件日期
    $scope.dateInit();

    //公共函数***排序
    $scope.switchSort = function (sort){
        switch (sort)
        {
            case 'DES':
                sort = 'ASC';
                break;
            case 'ASC':
                sort = 'DES';
                break;
            default:
                sort = 'DES';
        }
        $scope.sort = sort;
    };

               /*团课统计部分开始*/
              /*团课统计-受欢迎的教练事件开始*/
    //参数
    $scope.param1 = function () {
        return {
            venueId       : $scope.venueId1      != '' && $scope.venueId1      != undefined ? $scope.venueId1 : null,                             //场馆Id
            startTime     : $('#sellDate').val() != '' && $('#sellDate').val() != undefined ? $.trim($('#sellDate').val().split(' - ')[0]) : null,//开始日期
            endTime       : $('#sellDate').val() != '' && $('#sellDate').val() != undefined ? $.trim($('#sellDate').val().split(' - ')[1]) : null,//结束日期
            coachId       : $scope.coachId1      != '' && $scope.coachId1      != undefined ? $scope.coachId1 : null,                             //教练Id
            courseTypeId  : $scope.allClassType1 != '' && $scope.allClassType1 != undefined ? $scope.allClassType1 : null,                        //课种Id
            keywords      : $scope.keywords1     != '' && $scope.keywords1     != undefined ? $scope.keywords1 : null,    //关键字
            sortType      : $scope.paramType,
            sort          : $scope.sort,
        }
    };
    //数据准备(公司联盟下所有场馆)
     $http.get('/site/get-auth-venue').then(function(response){
        $scope.allVenueLists = response.data;
     });
    //数据准备(公司联盟下所有团课教练)
    $http.get('/new-league/get-all-company-coach').then(function (response) {
        $scope.coachLists = response.data;
    });
    //数据准备(公司联盟下所有课种)
    $http.get('/team-class/course-all-type').then(function (response) {
        $scope.courseList = response.data.data;
    });
    //初始化URL(1)
    $scope.initUrl = function (param) {
        var houUrl = '?' + $.param(param);
        if(param == undefined || param == null || param == ''){
            houUrl = '';
        }
        return '/team-class/group-class-list' + houUrl;
    };

    //团操记录列表
    $scope.getGroupClassList = function (url) {
        $.loading.show();
        $http.get(url).then(function (result) {
            if(result != undefined){
                if(result.data.data.length != 0){
                    $scope.dataList       = result.data.data;
                    $scope.coachGroupPage = result.data.page;
                    $scope.nowPeoplePage = result.data.nowPage;
                    $scope.coachListNoData = false;
                }else{
                    $scope.dataList       = result.data.data;
                    $scope.coachGroupPage = result.data.page;
                    $scope.nowPeoplePage = result.data.nowPage;
                    $scope.coachListNoData = true;
                }
            }
            $.loading.hide();
        },function () {
            $scope.coachListNoData = true;
            $.loading.hide();
        });
    };

    //初始化列表
    $scope.getGroupClassList($scope.initUrl($scope.param1()));
    //分页
    $scope.classGroupPages = function ($url) {
        $scope.getGroupClassList($url);
    };
    //教练事件
    $scope.coachChange = function (coachId) {
        $scope.getGroupClassList($scope.initUrl($scope.param1()));
    };
    //课种事件
    $scope.classTypeChange = function (ctid) {
        $scope.getGroupClassList($scope.initUrl($scope.param1()));
    };
                /*团课统计-受欢迎的教练事件结束*/



               /*团课统计-受欢迎的课程事件开始*/
    //参数
    $scope.param2 = function () {
        return {
            venueId         : $scope.venueId1      != '' && $scope.venueId1      != undefined ? $scope.venueId1 : null,                             //场馆Id
            startTime       : $('#sellDate').val() != '' && $('#sellDate').val() != undefined ? $.trim($('#sellDate').val().split(' - ')[0]) : null,//开始日期
            endTime         : $('#sellDate').val() != '' && $('#sellDate').val() != undefined ? $.trim($('#sellDate').val().split(' - ')[1]) : null,//结束日期
            courseTypeId    : $scope.allClassType2 != '' && $scope.allClassType2 != undefined ? $scope.allClassType2 : null,                        //课种Id
            courseId        : $scope.allClass1     != '' && $scope.allClass1     != undefined ? $scope.allClass1 : null,                            //课程Id
            keywords        : $scope.keywords1     != '' && $scope.keywords1     != undefined ? $scope.keywords1 : null,                            //关键字
            sortType        : $scope.paramType,
            sort            : $scope.sort,
        }
    };
    //获取所有课种
    $scope.getAllCourseType = function () {
        $http.get('/team-class/course-all-type').success(function (result) {
            $scope.allClassTypeList = result.data;
        })
    };
    //课种下拉框事件
    $scope.allClassChangeEvent = function (t) {
        $scope.allClass1 = '';
        $http.get('/team-class/all-course-lister?courseTypeId=' + t).success(function (result) {
            $scope.allCourseDataList = result.data; //获取课种下面的所有课程
        });
        //选择课种显示对应的列表
        $scope.welcomeCourse($scope.initUrl2($scope.param2()));
    };

    //初始化URL(2)
    $scope.initUrl2 = function (param) {
        var houUrl2 = '?' + $.param(param);
        if(param == undefined || param == null || param == ''){
            houUrl2 = '';
        }
        return '/team-class/welcome-course-list' + houUrl2;
    };
    //受欢迎的课程列表
    $scope.welcomeCourse = function (url) {

        $.loading.show();
        $http.get(url).success(function (result) {
            //console.log(result);
            if(result != undefined){
                if(result.data.length != 0){
                    $scope.welcomeCourseList  = result.data; //列表
                    $scope.classGroupPage = result.page;     //分页
                    $scope.nowCoursePage = result.nowPage;         //当前页
                    $scope.classListNoData = false;
                }else{
                    $scope.welcomeCourseList  = result.data;
                    $scope.classGroupPage = result.page;
                    $scope.nowCoursePage = result.nowPage;
                    $scope.classListNoData = true;
                }
            }
            $.loading.hide();
        });
    };
    //分页
    $scope.welcomeCoursePages = function ($url) {
        $scope.welcomeCourse($url);
    };
    //课程下拉框事件
    $scope.allClassChange = function (classId) {
        $scope.welcomeCourse($scope.initUrl2($scope.param2()));
    };

    /*团课统计-受欢迎的课程事件结束*/

    /*团课统计-受欢迎的时段事件开始*/
    //参数
    $scope.param3 = function () {
        return {
            venueId         : $scope.venueId1      != '' && $scope.venueId1      != undefined ? $scope.venueId1 : null,                             //场馆Id
            startTime       : $('#sellDate').val() != '' && $('#sellDate').val() != undefined ? $.trim($('#sellDate').val().split(' - ')[0]) : null,//开始日期
            endTime         : $('#sellDate').val() != '' && $('#sellDate').val() != undefined ? $.trim($('#sellDate').val().split(' - ')[1]) : null,//结束日期
            beginClassTime  : $scope.allTimes1     != '' && $scope.allTimes1     != undefined ? $scope.allTimes1 : null,                            //时段                                                                                         //时段
            courseTypeId    : $scope.allClassType3 != '' && $scope.allClassType3 != undefined ? $scope.allClassType3 : null,                        //课种Id
            courseId        : $scope.timeClassId   != '' && $scope.timeClassId   != undefined ? $scope.timeClassId : null,                          //课程Id
            keywords        : $scope.keywords1     != '' && $scope.keywords1     != undefined ? $scope.keywords1 : null,                            //关键字
            sortType        : $scope.paramType,
            sort            : $scope.sort,
        }
    };
    //初始化URL(3)
    $scope.initUrl3 = function (param) {
        var houUrl3 = '?' + $.param(param);
        if(param == undefined || param == null || param == ''){
            houUrl3 = '';
        }
        return '/team-class/welcome-time-list' + houUrl3;
    };
    //列表
    $scope.welcomeTimeList = function (url) {
        $.loading.show();
        $http.get(url).success(function (result) {
            if(result != undefined){
                if(result.data.length != 0){
                    $scope.timeList = result.data;          //列表
                    $scope.timeGroupPage = result.page;     //分页
                    $scope.nowTimePage = result.nowPage;    //当前页
                    $scope.timeListNoData = false;
                }else{
                    $scope.timeList = result.data;          //列表
                    $scope.timeGroupPage = result.page;     //分页
                    $scope.nowTimePage = result.nowPage;    //当前页
                    $scope.timeListNoData = true;
                }
            }
            $.loading.hide();
        });
    };
    //分页
    $scope.welcomeTimePages = function ($url) {
        $scope.welcomeTimeList($url);
    };
    //获取所有课种
    $scope.getTimeCourseType = function () {
        $http.get('/team-class/course-all-type').success(function (result) {
            $scope.timeClassTypeList = result.data;
        })
    };
    //课种下拉框事件
    $scope.timeClassTypeChange = function (t) {
        $scope.timeClassId = '';
        $http.get('/team-class/all-course-lister?courseTypeId=' + t).success(function (result) {
            $scope.timeClassList = result.data; //获取课种下面的所有课程
        });
        //选择课种显示对应的列表
        $scope.welcomeTimeList($scope.initUrl3($scope.param3()));
    };
    //受欢迎时段课程下拉框事件
    $scope.timeClassChange = function(classId){
        $scope.welcomeTimeList($scope.initUrl3($scope.param3()));
    };
    //时段事件
    $scope.welcomeTimeChange = function () {
        $scope.welcomeTimeList($scope.initUrl3($scope.param3()));
    };
    /*团课统计-受欢迎的时段事件结束*/

/***********************团课统计-公共事件开始************************/
    //排序事件
    $scope.sortChange = function (attr, sort) {
    $scope.paramType = attr;
    $scope.switchSort(sort);
    $scope.search();
    };
    //拉取1
    $scope.pullList = function () {
        switch(parseInt($scope.bestChose))
        {
            case 1:
                $scope.getGroupClassList($scope.initUrl($scope.param1()));//初始化列表
                break;
            case 2:
                $scope.getAllCourseType();                              //获取所有所有课种
                $scope.welcomeCourse($scope.initUrl2($scope.param2())); //初始化列表
                break;
            default:
                //受欢迎的时段
                $scope.getTimeCourseType();                              //获取所有所有课种
                $scope.welcomeTimeList($scope.initUrl3($scope.param3()));//初始化列表
        }
    };
    //拉取2
    $scope.pullElseEvent = function () {
        switch(parseInt($scope.bestChose))
        {
            case 1:
                $scope.getGroupClassList($scope.initUrl($scope.param1()));
                break;
            case 2:
                $scope.welcomeCourse($scope.initUrl2($scope.param2()));
                break;
            default:
                $scope.welcomeTimeList($scope.initUrl3($scope.param3()));
        }
    };
    //选择受欢迎系列下拉控件事件
    //拉取1
    $scope.bestChoseChange = function (v) {
        $scope.pullList();
    };
    //搜索事件
    //拉取2
    $scope.search = function () {
        $scope.pullElseEvent();
    };
    //清除数据事件
    $scope.clearData1 = function (isClearDate) {
        $scope.venueId1      = '';
        $scope.coachId1      = '';
        $scope.allClassType1 = '';
        $scope.allClassType2 = '';
        $scope.allClass1     = '';
        $scope.allClass2     = '';
        $scope.allTimes1     = '';
        $scope.allClassType3 = '';
        $scope.timeClassId   = '';
        $scope.keywords1     = '';
        if(isClearDate == true){
            $('#sellDate').val('');
        }else{
            $scope.dateInit();
        }
        $('#select2-venueId1-container').text('全部场馆');
        $('#select2-venueId1-container').attr('title', '全部场馆');
        //拉取1
        $scope.pullList();
    };
    //场馆事件
    //拉取2
    $scope.venueChange = function (veid) {
        $scope.pullElseEvent();
    };
    //日期事件
    //拉取2
    $('#sellDate').on('apply.daterangepicker', function(ev, picker){
        $scope.pullElseEvent();
    });
/**************************团课统计-公共事件结束********************************/

            /*受欢迎的教练模态框事件开始*/
    //参数
    $scope.coachModalInfo = function(){
        return{
            startTime    : $('#sellDate2').val() != '' && $('#sellDate2').val()  != undefined ? $.trim($('#sellDate2').val().split(' - ')[0]) : null,//开始日期
            endTime      : $('#sellDate2').val() != '' && $('#sellDate2').val()  != undefined ? $.trim($('#sellDate2').val().split(' - ')[1]) : null,//结束日期
            courseId     :$scope.oneCoachCourse != '' && $scope.oneCoachCourse != undefined ? $scope.oneCoachCourse : null,  //课程Id
            coachId      : window.coachId != '' && window.coachId != undefined && window.coachId != null ? window.coachId : null,
            courseTypeId : window.courseTypeId != '' && window.courseTypeId != undefined && window.courseTypeId != null ? window.courseTypeId : null,
            venueId      : window.venueId != '' && window.courseTypeId != undefined  && window.venueId != null ? window.venueId : null,
        }
    };
    //初始化url
    $scope.initUrl1 = function (param) {
        var houUrl1 = $.param(param);
        if(param == undefined || param == null || param == ''){
            houUrl1 = '';
        }
        return '/team-class/group-class-detail?' + houUrl1;
    };
    //获取教练和上课会员信息
    $scope.getCoachModal = function(detailUrl){
        $.loading.show();
        //教练和上课会员信息
        $http.get(detailUrl).success(function(result){
            if(result != undefined){
                if(result.data.length !=0){
                    $scope.memberInfo = result.data;   //上课会员信息
                    $scope.coachModalPage = result.page;//分页
                    $scope.nowModalPage = result.nowPage;//当前页
                    $scope.coachNoData = false;
                    $.loading.hide();
                }else{
                    $scope.memberInfo = result.data;   //上课会员信息
                    $scope.coachModalPage = result.page;//分页
                    $scope.nowModalPage = result.nowPage;//当前页
                    $scope.coachNoData = true;
                    $.loading.hide();
                }
            }
        });
    };
    //受欢迎的教练详情事件
    $scope.coachDetail = function(coachId,object1){
        $('#coachDetailModal').modal('show');
        $('#sellDate2').val($('#sellDate').val());  //模态框日期等于列表选中日期
        $scope.coachModalName   = object1.coachName;    //教练姓名
        $scope.coachModalJob    = object1.coachPos;     //教练职位
        $scope.coachModalPhone  = object1.coachMobile;  //教练电话
        //模态框全部课程下拉列表
        $http.get('/team-class/all-course').then(function (result) {
            if(result != undefined){
                if(result.data.status == 'success'){
                    $scope.oneCoachCourseList = result.data.data;
                }
            }
        });
        window.courseTypeId  = object1.courseTypeId;
        window.coachId       = coachId;
        window.venueId       = object1.venueId;
        $scope.getCoachModal($scope.initUrl1($scope.coachModalInfo()));
    };
    //教练模态日期事件
    $('#sellDate2').on('apply.daterangepicker', function(ev, picker){
        $scope.getCoachModal($scope.initUrl1($scope.coachModalInfo()));
    });
    //受欢迎的教练模态框分页事件
    $scope.groupClassDetailPages = function (urlPages) {
        $scope.getCoachModal(urlPages);
    };
    //受欢迎教练模态框课程下拉事件
    $scope.oneCoachCourseChange = function(c){
        $scope.getCoachModal($scope.initUrl1($scope.coachModalInfo()));
    };
    //模态框清除按钮事件
    $scope.clearModalData1 = function(){
        $('#sellDate2').val('');
        $scope.oneCoachCourse = '';
        $scope.getCoachModal($scope.initUrl1($scope.coachModalInfo()));
    };
            /*受欢迎的教练模态框事件结束*/

/**************受欢迎的课程模态框事件开始******************/
    //受欢迎的课程详情事件
    $scope.classDetail = function(object2){
        $('#classDetailModal').modal('show');
        $('#sellDate1').val($('#sellDate').val());   //模态框日期等于列表选中日期
        $scope.classCategory   = object2.courseType;    //课种名称
        $scope.classCourseName = object2.courseName;         //课程名称
        $scope.courseId        = object2.courseId;           //课种ID
        window.venueId         = object2.venueId;
        //初始化列表
        $scope.getClassModalDetail( $scope.initUrl22($scope.classModalInfo()));
    };
    //参数
    $scope.classModalInfo = function(){
        return{
            startTime : $('#sellDate1').val() != '' && $('#sellDate1').val()  != undefined ? $.trim($('#sellDate1').val().split(' - ')[0]) : null,//开始日期
            endTime   : $('#sellDate1').val() != '' && $('#sellDate1').val()  != undefined ? $.trim($('#sellDate1').val().split(' - ')[1]) : null,//结束日期
            venueId   : window.venueId != '' && window.venueId != undefined && window.venueId != null ? window.venueId : null,
        }
    };
    //初始化url
    $scope.initUrl22 = function (param) {
        var houUrl22 = '&' + $.param(param);
        if(param == undefined || param == null || param == ''){
            houUrl22 = '';
        }
        return '/team-class/welcome-course-detail?courseId=' + $scope.courseId + houUrl22;
    };
    //获取模态框列表数据
    $scope.getClassModalDetail = function(url){
        $.loading.show();
        $http.get(url).success(function(res){
            if(res != undefined){
                if(res.data.length != 0){
                    $scope.classModalMemberList = res.data; //会员列表
                    $scope.classModalNowPage = res.nowPage; //当前页
                    $scope.classModalPage = res.page;       //分页
                    $scope.classNoData = false;
                    $.loading.hide();
                }else{
                    $scope.classModalMemberList = res.data; //会员列表
                    $scope.classModalNowPage = res.nowPage; //当前页
                    $scope.classModalPage = res.page;       //分页
                    $scope.classNoData = true;
                    $.loading.hide();
                }
            }
        })
    };
    //模态框分页事件
    $scope.welcomeDetailPages = function (urlPages) {
        $scope.getClassModalDetail(urlPages);
    };
    //模态框日期事件
    $('#sellDate1').on('apply.daterangepicker', function(ev, picker){
        $scope.getClassModalDetail($scope.initUrl22($scope.classModalInfo()));
    });
    //模态框清除按钮事件
    $scope.clearModalData2 = function(){
        $('#sellDate1').val('');
        $scope.getClassModalDetail($scope.initUrl22($scope.classModalInfo()));
    };
/***************受欢迎的课程模态框事件结束*****************/

/*受欢迎的时段模态框事件开始*/
    //受欢迎的时段详情事件
    $scope.timeDetail = function(object3,classId){
        $('#timeDetailModal').modal('show');
        $('#sellDate3').val($('#sellDate').val());  //模态框日期等于列表选中日期
        $scope.timeCategory   = object3.courseType;    //课种名称
        $scope.timeCourseName = object3.courseName;         //课程名称
        $scope.timeColumn     = object3.timeColumn;         //时段
        //获取课种下面的所有课程
        $http.get('/team-class/all-course-lister?courseTypeId=' +  classId).success(function (result) {
            $scope.timeModalClassList = result.data;
        });
        window.classId    = classId;
        window.venueId    = object3.venueId;
        //初始化列表
        $scope.getTimeModalData($scope.initUrl33($scope.timeModalInfo()));
    };
    //参数
    $scope.timeModalInfo = function(){
        return{
            startTime : $('#sellDate3').val() != '' && $('#sellDate3').val()  != undefined ? $.trim($('#sellDate3').val().split(' - ')[0]) : null,//开始日期
            endTime   : $('#sellDate3').val() != '' && $('#sellDate3').val()  != undefined ? $.trim($('#sellDate3').val().split(' - ')[1]) : null,//结束日期
            courseId  : $scope.timeCourseId   != '' && $scope.timeCourseId    != undefined ? $scope.timeCourseId : null,  //课程Id
            venueId   : window.venueId != '' && window.venueId != undefined && window.venueId != null ? window.venueId : null,
        }
    };
    //初始化url
    $scope.initUrl33 = function (param) {
        var houUrl33 = '&' + $.param(param);
        if(param == undefined || param == null || param == ''){
            houUrl33 = '';
        }
        return '/team-class/welcome-time-detail?courseTypeId=' + classId + '&beginClassTime=' + $scope.timeColumn + houUrl33;
    };
    //获取模态框列表数据
    $scope.getTimeModalData = function(url){
        $.loading.show();
        $http.get(url).success(function(res){
            if(res != undefined){
                if(res.data.length != 0){
                    $scope.timeModalMemberList = res.data; //会员列表
                    $scope.timeModalNowPage = res.nowPage; //当前页
                    $scope.timeModalPage = res.page;       //分页
                    $scope.timeNoData = false;
                    $.loading.hide();
                }else{
                    $scope.timeModalMemberList = res.data; //会员列表
                    $scope.timeModalNowPage = res.nowPage; //当前页
                    $scope.timeModalPage = res.page;       //分页
                    $scope.timeNoData = true;
                    $.loading.hide();
                }
            }
        })
    };
    //模态框分页事件
    $scope.timeModalPages = function (urlPages) {
        $scope.getTimeModalData(urlPages);
    };
    //模态框课程下拉框事件
    $scope.timeCourseChange = function(id){
        $scope.getTimeModalData($scope.initUrl33( $scope.timeModalInfo()));
    };
    //教练模态日期事件
    $('#sellDate3').on('apply.daterangepicker', function(ev, picker){
        $scope.getTimeModalData($scope.initUrl33( $scope.timeModalInfo()));
    });
    //模态框清除按钮事件
    $scope.clearModalData3 = function(){
        $('#sellDate3').val('');
        $scope.timeCourseId = '';
        $scope.getTimeModalData($scope.initUrl33( $scope.timeModalInfo()));
    };
/*受欢迎的时段模态框事件结束*/

        /*详情模态框关闭事件集合开始*/
    //受欢迎的教练详情事件模态框关闭初始化数据
    $('#coachDetailModal').on('hidden.bs.modal', function () {
        $('#sellDate2').val('');
        $scope.oneCoachCourse = '';
    });
    //受欢迎的课程详情事件模态框关闭初始化数据
    $('#classDetailModal').on('hidden.bs.modal', function () {
        $('#sellDate1').val('');
    });
    //受欢迎的时段详情事件模态框关闭初始化数据
    $('#timeDetailModal').on('hidden.bs.modal', function () {
        $('#sellDate3').val('');
        $scope.timeCourseId = '';
    });
           /*详情模态框关闭事件集合结束*/

            /*团课统计部分结束*/

            /*课程环比部分开始*/

    /*课程环比-公用参数开始*/
    //日期处理函数
    //调用 : eleVal 1 nowDate 2 prevDate  dateSwitch 1 startTime 2 endTime
    $scope.dateFunc = function (eleVal, dateSwitch) {
        switch (eleVal)
        {
            case 1:
                eleVal = $('#nowDate').val();
                break;
            case 2:
                eleVal = $('#prevDate').val();
                break;
            default:
                eleVal = '';

        }
        switch (dateSwitch)
        {
            case 1:
                dateSwitch = 0;
                break;
            case 2:
                dateSwitch = 1;
                break;
            default:
                dateSwitch = '';
                break;
        }
        if(dateSwitch === ''){
            return null;
        }
       return (eleVal  != '' && eleVal  != undefined) ? $.trim(eleVal.split(' - ')[dateSwitch]) : null;
    }
    //URl
    /*vid 1 教练   2 课程   3  时段*/
    $scope.initPublicUrl = function (vid, param) {
        if(vid == undefined || vid == null || vid == '') {
            vid = 1;
        }
        var qianUrl = '&' + $.param(param);
        if(param == undefined || param == null || param == ''){
            qianUrl = '';
        }
        return '/team-class/course-contrast?vid=' + vid + qianUrl;
    }
    /*课程环比-公用参数结束*/

    /*课程环比-受欢迎的教练事件开始*/
    //参数
    // @time1 startTime  @time2 endTime
    $scope.param4 = function (time1, time2, time3, time4) {
        return {
            nowStartTime  : time1,
            nowEndTime    : time2,
            lastStartTime : time3,
            lastEndTime   : time4,
            venueId       : $scope.venueId2      != '' && $scope.venueId2      != undefined ? $scope.venueId2 : null,                              //场馆Id
            coachId       : $scope.coachId2      != '' && $scope.coachId2      != undefined ? $scope.coachId2 : null,                              //教练Id
            courseTypeId  : $scope.allClassType4 != '' && $scope.allClassType4 != undefined ? $scope.allClassType4 : null,                         //课种Id
            keywords      : $scope.keywords2     != '' && $scope.keywords2     != undefined ? $scope.keywords2 : null,  //关键字
            sortType      : $scope.contrastParamType,
            sort          : $scope.sort,
        }
    };
    //数据准备(公司联盟下所有团课教练)
    $http.get('/new-league/get-all-company-coach').then(function (response) {
        $scope.contrastCoachLists = response.data;
    });
    //数据准备(公司联盟下所有课种)
    $http.get('/team-class/course-all-type').then(function (response) {
        $scope.contrastCourseList = response.data.data;
    });
    //受欢迎的教练数据列表
    $scope.getContrastCoachList = function (url) {
        $.loading.show();
        $http.get(url).then(function (result) {
            if(result != undefined){
                if(result.data.data != null){
                    if(result.data.data.length != 0){
                        $scope.contrastCoachData   = result.data.data;   //列表数据
                        $scope.coachContrastPage   = result.data.page;   //分页
                        $scope.contrastPage        = result.data.nowPage;//当前页
                        $scope.contrastCoachNoData = false;              //暂无数据
                    }else {
                        $scope.contrastCoachData = result.data.data;    //列表数据
                        $scope.coachContrastPage = result.data.page;    //分页
                        $scope.contrastPage = result.data.nowPage;      //当前页
                        $scope.contrastCoachNoData = true;              //暂无数据
                    }

                }else{
                    $scope.contrastCoachData = result.data.data;    //列表数据
                    $scope.coachContrastPage = result.data.page;    //分页
                    $scope.contrastPage      = result.data.nowPage; //当前页
                    $scope.contrastCoachNoData = true;              //暂无数据
                }
            }
            $.loading.hide();
        },function () {
            $scope.contrastCoachNoData = true;
            $.loading.hide();
        });
    };
    //分页事件
    $scope.contrastCoachPage = function (urlPages) {
        $scope.getContrastCoachList(urlPages);
    };
    //受欢迎的教练下拉框事件
    $scope.contrastCoachChange = function(v){
        $scope.getContrastCoachList($scope.initPublicUrl(1, $scope.param4($scope.dateFunc(1, 1), $scope.dateFunc(1, 2), $scope.dateFunc(2, 1), $scope.dateFunc(2, 2))));
    };
    //课种下拉框事件
    $scope.contrastClassChange = function(v){
        $scope.getContrastCoachList($scope.initPublicUrl(1, $scope.param4($scope.dateFunc(1, 1), $scope.dateFunc(1, 2), $scope.dateFunc(2, 1), $scope.dateFunc(2, 2))));
    };
    /***********课程环比-受欢迎的教练事件结束**********/


    /*课程环比-受欢迎的课程事件开始*/
    $scope.param5 = function (time1, time2, time3, time4) {
        return {
            nowStartTime  : time1,
            nowEndTime    : time2,
            lastStartTime : time3,
            lastEndTime   : time4,
            venueId       : $scope.venueId2      != '' && $scope.venueId2      != undefined ? $scope.venueId2 : null,                              //场馆Id
            courseTypeId  : $scope.allClassType5 != '' && $scope.allClassType5 != undefined ? $scope.allClassType5 : null,                         //课种Id
            courseId      : $scope.allClass5     != '' && $scope.allClass5     != undefined ? $scope.allClass5 : null,                             //课程Id
            keywords      : $scope.keywords2     != '' && $scope.keywords2     != undefined ? $scope.keywords2 : null,                             //关键字
            sortType      : $scope.contrastParamType,
            sort          : $scope.sort,
        }
    };
    //获取所有课种
    $scope.getContrastAllClassType = function () {
        $http.get('/team-class/course-all-type').success(function (result) {
            $scope.contrastAllClassType = result.data;
        })
    };
    //课种下拉框事件
    $scope.getContrastAllClass = function (t) {
        $scope.allClass5 = '';
        $http.get('/team-class/all-course-lister?courseTypeId=' + t).success(function (result) {
            $scope.contrastAllCourseList = result.data; //获取课种下面的所有课程
        });
        //选择课种显示对应的列表
        $scope.getContrastClassList($scope.initPublicUrl(2, $scope.param5($scope.dateFunc(1, 1), $scope.dateFunc(1, 2), $scope.dateFunc(2, 1), $scope.dateFunc(2, 2))));
    };
    //受欢迎的课程数据列表
    $scope.getContrastClassList = function (url) {
        $.loading.show();
        $http.get(url).then(function (result) {
            if(result != undefined){
                if(result.data.data != null){
                    if(result.data.data.length != 0){
                        $scope.contrastClassData   = result.data.data;   //列表数据
                        $scope.classContrastPage   = result.data.page;   //分页
                        $scope.contractClassNow    = result.data.nowPage;//当前页
                        $scope.contrastClassNoData = false;              //暂无数据
                    }else{
                        $scope.contrastClassData   = result.data.data;   //列表数据
                        $scope.classContrastPage   = result.data.page;   //分页
                        $scope.contractClassNow    = result.data.nowPage;//当前页
                        $scope.contrastClassNoData = true;               //暂无数据
                    }

                }else{
                    $scope.contrastClassData   = result.data.data;   //列表数据
                    $scope.classContrastPage   = result.data.page;   //分页
                    $scope.contractClassNow    = result.data.nowPage;//当前页
                    $scope.contrastClassNoData = true;               //暂无数据
                }
            }
            $.loading.hide();
        },function () {
            $scope.contrastClassNoData = true;
            $.loading.hide();
        });
    };
    //分页事件
    $scope.contrastCoursePage = function(urlPages){
        $scope.getContrastClassList(urlPages);
    };
    //课程下拉框事件
    $scope.getContrastClassChange = function(v){
        $scope.getContrastClassList($scope.initPublicUrl(2, $scope.param5($scope.dateFunc(1, 1), $scope.dateFunc(1, 2), $scope.dateFunc(2, 1), $scope.dateFunc(2, 2))));
    };

    /*课程环比-受欢迎的课程事件结束*/


    /*课程环比-受欢迎的时段事件开始*/
    $scope.param6 = function (time1, time2, time3, time4) {
        return {
            nowStartTime   : time1,
            nowEndTime     : time2,
            lastStartTime  : time3,
            lastEndTime    : time4,
            venueId        : $scope.venueId2      != '' && $scope.venueId2      != undefined ? $scope.venueId2 : null,                              //场馆Id
            beginClassTime : $scope.allTimes2     != '' && $scope.allTimes2     != undefined ? $scope.allTimes2 : null,                             //时段
            courseTypeId   : $scope.allClassType6 != '' && $scope.allClassType6 != undefined ? $scope.allClassType6 : null,                         //课种Id
            courseId       : $scope.allClass6     != '' && $scope.allClass6     != undefined ? $scope.allClass6 : null,                             //课程Id
            keywords       : $scope.keywords2     != '' && $scope.keywords2     != undefined ? $scope.keywords2 : null, //关键字
            sortType      : $scope.contrastParamType,
            sort          : $scope.sort,
        }
    };
    //获取所有课种
    $scope.getContrastTimeClassType = function () {
        $http.get('/team-class/course-all-type').success(function (result) {
            $scope.contrastAllTimeClassType = result.data;
        })
    };
    //课种下拉框事件
    $scope.getContrastTimeAllClass = function (t) {
        $scope.allClass6 = '';
        $http.get('/team-class/all-course-lister?courseTypeId=' + t).success(function (result) {
            $scope.contrastAllTimeCourseList = result.data; //获取课种下面的所有课程
        });
        //选择课种显示对应的列表
        $scope.getContrastTimeList( $scope.initPublicUrl(3, $scope.param6($scope.dateFunc(1, 1), $scope.dateFunc(1, 2), $scope.dateFunc(2, 1), $scope.dateFunc(2, 2))));
    };
    //受欢迎的时段数据列表
    $scope.getContrastTimeList = function (url) {
        $.loading.show();
        $http.get(url).then(function (result) {
            if(result != undefined){
                if(result.data.data != null){
                    if( result.data.data.length != 0){
                        $scope.contrastTimeData   = result.data.data;   //列表数据
                        $scope.timeContrastPage   = result.data.page;   //分页
                        $scope.contractTimeNow    = result.data.nowPage;//当前页
                        $scope.contrastTimeNoData = false;              //暂无数据
                    }else{
                        $scope.contrastTimeData   = result.data.data;   //列表数据
                        $scope.timeContrastPage   = result.data.page;   //分页
                        $scope.contractTimeNow    = result.data.nowPage;//当前页
                        $scope.contrastTimeNoData = true;               //暂无数据
                    }

                }else{
                    $scope.contrastTimeData   = result.data.data;   //列表数据
                    $scope.timeContrastPage   = result.data.page;   //分页
                    $scope.contractTimeNow    = result.data.nowPage;//当前页
                    $scope.contrastTimeNoData = true;               //暂无数据
                }
            }
            $.loading.hide();
        },function () {
            $scope.contrastTimeNoData = true;
            $.loading.hide();
        });
    };
    //分页事件
    $scope.contrastTimePage = function(urlPages){
        $scope.getContrastTimeList(urlPages);
    };
    //时间事件
    $scope.timeColumnChange = function (timeColumn) {
        $scope.getContrastTimeList( $scope.initPublicUrl(3, $scope.param6($scope.dateFunc(1, 1), $scope.dateFunc(1, 2), $scope.dateFunc(2, 1), $scope.dateFunc(2, 2))));
    };
    //课程下拉框事件
    $scope.getContrastTimeClassChange = function(v){
        $scope.getContrastTimeList( $scope.initPublicUrl(3, $scope.param6($scope.dateFunc(1, 1), $scope.dateFunc(1, 2), $scope.dateFunc(2, 1), $scope.dateFunc(2, 2))));
    };


    /*课程环比-受欢迎的时段事件结束*/
    
    /***********************课程环比-公共事件开始************************/
    //课程环比拉去事件1
    $scope.pullContrastEvent = function () {
        switch (parseInt($scope.bestChoseState))
        {
            case 1:
                $scope.getContrastCoachList($scope.initPublicUrl(1, $scope.param4($scope.dateFunc(1, 1), $scope.dateFunc(1, 2), $scope.dateFunc(2, 1), $scope.dateFunc(2, 2))));
                break;
            case 2:
                $scope.getContrastClassList($scope.initPublicUrl(2, $scope.param5($scope.dateFunc(1, 1), $scope.dateFunc(1, 2), $scope.dateFunc(2, 1), $scope.dateFunc(2, 2))));
                break;
            default:
                $scope.getContrastTimeList( $scope.initPublicUrl(3, $scope.param6($scope.dateFunc(1, 1), $scope.dateFunc(1, 2), $scope.dateFunc(2, 1), $scope.dateFunc(2, 2))));
        }
    };
    //课程环比拉取事件2
    $scope.pullDrawEvent = function () {
        switch (parseInt($scope.bestChoseState))
        {
            case 1:
                $scope.coachContrast = "1";
                $scope.coachContrastChange = function(v){
                };
                $scope.getContrastCoachList($scope.initPublicUrl(1, $scope.param4($scope.dateFunc(1, 1), $scope.dateFunc(1, 2), $scope.dateFunc(2, 1), $scope.dateFunc(2, 2))));
                break;
            case 2:
                $scope.classContrast = "1";
                $scope.classContrastChange = function(v){
                };
                $scope.getContrastAllClassType();
                $scope.getContrastClassList($scope.initPublicUrl(2, $scope.param5($scope.dateFunc(1, 1), $scope.dateFunc(1, 2), $scope.dateFunc(2, 1), $scope.dateFunc(2, 2))));
                break;
            default:
                $scope.timeContrast = "1";
                $scope.timeContrastChange = function(v){
                };
                $scope.getContrastTimeClassType();
                $scope.getContrastTimeList( $scope.initPublicUrl(3, $scope.param6($scope.dateFunc(1, 1), $scope.dateFunc(1, 2), $scope.dateFunc(2, 1), $scope.dateFunc(2, 2))));
        }
    };
    //课程环比排序事件
    $scope.sortContrastChange = function (argument, tcl, sort) {
        switch (argument)
        {
            case "now":
                switch (parseInt(tcl))
                {
                    case 1:
                        $scope.contrastParamType = 'nowClassCount';
                        $scope.switchSort(sort);
                        break;
                    case 2:
                        $scope.contrastParamType = 'nowMemberCount';
                        $scope.switchSort(sort);
                        break;
                    default:
                        $scope.contrastParamType = 'nowAverageCount';
                        $scope.switchSort(sort);
                }
                break;
            case "last":
                switch (parseInt(tcl))
                {
                    case 1:
                        $scope.contrastParamType = 'lastClassCount';
                        $scope.switchSort(sort);
                        break;
                    case 2:
                        $scope.contrastParamType = 'lastMemberCount';
                        $scope.switchSort(sort);
                        break;
                    default:
                        $scope.contrastParamType = 'lastAverageCount';
                        $scope.switchSort(sort);
                }
                break;
            case "rise":
                switch (parseInt(tcl))
                {
                    case 1:
                        $scope.contrastParamType = 'riseClass';
                        $scope.switchSort(sort);
                        break;
                    case 2:
                        $scope.contrastParamType = 'riseMember';
                        $scope.switchSort(sort);
                        break;
                    default:
                        $scope.contrastParamType = 'riseAverage';
                        $scope.switchSort(sort);
                }
                break;
            default :
                switch (parseInt(tcl))
                {
                    case 1:
                        $scope.contrastParamType = 'perClass';
                        $scope.switchSort(sort);
                        break;
                    case 2:
                        $scope.contrastParamType = 'perMember';
                        $scope.switchSort(sort);
                        break;
                    default:
                        $scope.contrastParamType = 'perAverage';
                        $scope.switchSort(sort);
                        break;
                }
        }
        $scope.pullContrastEvent();
    };
    //选择受欢迎系列下拉控件事件
    $scope.bestChoseStateChange = function (v) {
        $scope.pullDrawEvent();
    };
    //最右侧上课总节数,排课总节数,平均人数下拉控件事件
    //搜索事件
    $scope.search2 = function () {
        $scope.pullContrastEvent();
    };
    //清除数据事件
    $scope.clearData2 = function (isClearDate) {
        $scope.venueId2      = '';
        $scope.coachId2      = '';
        $scope.allClassType4 = '';
        $scope.allClass5    = '';
        $scope.allClassType5 = '';
        $scope.allTimes2     = '';
        $scope.allClassType6 = '';
        $scope.allClass6     = '';
        $scope.keywords2     = '';
        $('#select2-venueId2-container').text('全部场馆');
        $('#select2-venueId2-container').attr('title', '全部场馆');
        if(isClearDate == true){
            $('#nowDate').val('');
            $('#prevDate').val('');
        }else{
            $scope.dateInit();
        }
        $scope.pullDrawEvent();
    };
    //场馆事件
    $scope.venueChange2 = function (veid) {
        $scope.pullContrastEvent();
    };
    //日期事件1
    $('#nowDate').on('apply.daterangepicker', function(ev, picker){
        $scope.pullContrastEvent();
    });
    //日期事件2
    $('#prevDate').on('apply.daterangepicker', function(ev, picker){
        $scope.pullContrastEvent();
    });
    /**************************课程环比-公共事件结束********************************/
//过滤器:  上课人数 & 上课数量 ---- 运算处理
}]).filter('trunc',function () {
    return function (val, attr, extra, percent) {
        var unit,result;
        if(extra == undefined || extra == null){
            unit = '人';
        }else if(extra == ''){
            unit = null;
        }else{
            unit = extra;
        }
        if(attr == 0 || attr == null || attr == undefined || attr == ''){
            return 0 + unit;
        }
        if(val == null || val == undefined || val == ''){
            val = 0;
        }
        result = parseInt(val)/parseInt(attr);
        if(percent != undefined){
            return result + unit;
        }
        if(/^\-\d+(\.\d+)?$/.test(result)){
            return Math.floor(result, 0) + unit;
        }else if(/^\+?\d+(\.\d+)?$/.test(result)){
            return Math.ceil(result, 0) + unit;
        }else{
            return 0 + unit;
        }
    };
});