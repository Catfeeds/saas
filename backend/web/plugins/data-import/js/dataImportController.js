angular.module('App').controller('dataImportCtrl',function($scope, $http, Upload){

    //修改
    $scope.dataUpdate = function (headTitle, item) {
        $scope.detialData = item;
        $scope.detialTitle = headTitle;
        $('#dataUpdateModal').modal('show');
    };

    //删除
    $scope.dataDel = function(headTitle, item){
        // console.log(headTitle);
        console.log(item);
        Sweety.remove({
            url: "/data-import/data-delete?type=" + $scope.typeChange + "&id=" + item.id,
            http: $http,
            title: '确定要删除吗?',
            text: '数据删除后不可恢复',
            confirmButtonText: '确定',
        }, function () {
            $scope.initPath();
            $scope.getList();
        });

    }

    //确认修改
    $scope.sureUpdate = function (data) {
        var sj = /^[1][3,4,5,7,8][0-9]{9}$/;
        var yx = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z0-9]{2,6}$/;
        var sfz = /^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[Xx])$)$/;
        if (data['mobile']) {
            if (data.hasOwnProperty('mobile') && !sj.test(data['mobile'])) {
                Message.warning('手机号输入有误');
                return;
            }
        }
        if (data['email']) {
            if (data.hasOwnProperty('email') && !yx.test(data['email'])) {
                Message.warning('邮箱输入有误');
                return;
            }
        }
        if (data['id_card']) {
            if (data.hasOwnProperty('id_card') && !sfz.test(data['id_card'])) {
                Message.warning('身份证号输入有误');
                return;
            }
        }
        $scope.isJump = false;
        angular.forEach($scope.detialTitle, function (item, index) {
            if (item.requier == 'yes') {
                if (!data[item.key]) {
                    Message.warning(item.name + '不能为空');
                    $scope.isJump = true;
                }
            }
        });
        if (!$scope.isJump) {
            data.type = $scope.typeChange;
            $http.post('/data-import/data-edit', data).then(function (result) {
                if(result.data.status == 'success'){
                    Message.success(result.data.data);
                    $scope.getList();
                    $('#dataUpdateModal').modal('hide');
                }else{
                    Message.warning(result.data.data);
                }
            })
        }
    }
    $scope.dataDetial = function (headTitle, item) {
        $('#dataDetialModal').modal('show');
        $scope.detialData = item;
        $scope.detialTitle = headTitle;
        // console.log($scope.detialData)
    }
    $scope.dataImport = function () {
        var file = document.getElementById('file');
        file.outerHTML = file.outerHTML;
        $('#dataImportModal').modal('show');
    }
    $scope.contentId = '1';
    //员工
    $scope.employeeArr = [
        {name: '<span style="color: red">*</span>姓名', key: 'name', requier: 'yes'},
        {name: '<span style="color: red">*</span>性别', key: 'sex', requier: 'yes'},
        {name: '<span style="color: red">*</span>手机号', key: 'mobile', requier: 'yes'},
        {name: '邮箱', key: 'email'},
        {name: '<span style="color: red">*</span>身份证号', key: 'id_card', requier: 'yes'},
        {name: '生日', key: 'birth_time', isDate: 'one'},
        {name: '<span style="color: red">*</span>公司名称', key: 'company', requier: 'yes'},
        {name: '<span style="color: red">*</span>场馆名称', key: 'venue', requier: 'yes'},
        {name: '<span style="color: red">*</span>部门名称', key: 'department', requier: 'yes'},
        {name: '职务', key: 'position'},
        {name: '<span style="color: red">*</span>状态', key: 'status', requier: 'yes'},
        {name: '任职日期', key: 'entry_date', requier: 'yes', isDate: 'two'},
        {name: '离职日期', key: 'leave_date', requier: 'no', isDate: 'tree'},
        {name: '薪资', key: 'salary', requier: 'yes'},
        {name: '个人简介', key: 'intro', textArea: 'summernote'},
        {name: '从业时间', key: 'work_date', requier: 'yes', isDate: 'work_date'},
        {name: '数据状态', key: 'check_status', requier: 'yes'},
    ];
    // 会员
    $scope.memberArr = [
        {name: '<span style="color: red">*</span>姓名', key: 'username', requier: 'yes'},
        {name: '<span style="color: red">*</span>手机号', key: 'mobile', requier: 'yes'},
        {name: '首次到馆时间', key: 'first_in_time', isDate: 'one'},
        {name: '<span style="color: red">*</span>公司', key: 'company', requier: 'yes'},
        {name: '<span style="color: red">*</span>场馆', key: 'venue', requier: 'yes'},
        {name: '证件号', key: 'id_card', requier: 'yes'},
        {name: '证件类型', key: 'card_type', requier: 'yes'},
        {name: '<span style="color: red">*</span>性别', key: 'sex', requier: 'yes'},
        {name: '出生日期', key: 'birth_date', isDate: 'two'},
        {name: '邮箱', key: 'email'},
        {name: '职业', key: 'profession'},
        {name: '住址', key: 'address'},
        {name: '来店途径', key: 'source'},
        {name: '数据状态', key: 'check_status', requier: 'yes'},
    ];
    // 会员卡
    $scope.memberCardArr = [
        {name: '<span style="color: red">*</span>会员姓名', key: 'username', requier: 'yes'},
        {name: '<span style="color: red">*</span>手机号', key: 'mobile', requier: 'yes'},
        {name: '<span style="color: red">*</span>性别', key: 'sex', requier: 'yes'},
        {name: '<span style="color: red">*</span>公司', key: 'company', requier: 'yes'},
        {name: '<span style="color: red">*</span>场馆', key: 'venue', requier: 'yes'},
        {name: '<span style="color: red">*</span>会员卡号', key: 'card_number', requier: 'yes'},
        {name: '<span style="color: red">*</span>开卡时间', key: 'open_card_time', requier: 'yes', isDate: 'one'},
        {name: '<span style="color: red">*</span>卡金额', key: 'money', requier: 'yes'},
        {name: '<span style="color: red">*</span>会员卡状态', key: 'status', requier: 'yes'},
        {name: '<span style="color: red">*</span>激活时间', key: 'active_date', requier: 'yes', isDate: 'two'},
        {name: '<span style="color: red">*</span>失效时间', key: 'failure_date', requier: 'yes', isDate: 'tree'},
        // {name: '总次数'},
        // {name: '消费次数'},
        // {name: '卡描述'},
        {name: '<span style="color: red">*</span>销售人员', key: 'counselor_name', requier: 'yes'},
        {name: '<span style="color: red">*</span>卡名称', key: 'card_name', requier: 'yes'},
        // {name: '计次方式'},
        {name: '<span style="color: red">*</span>卡属性', key: 'card_attributes', requier: 'yes'},
        {name: '<span style="color: red">*</span>合同名称', key: 'deal_name', requier: 'yes'},
        {name: '<span style="color: red">*</span>行为', key: 'behavior', requier: 'yes'},
        {name: '数据状态', key: 'check_status', requier: 'yes'},
        // {name: '消费方式'},
        // {name: '收银单号'},
        // {name: '备注'},
    ];
    // 课程订单
    $scope.classOrderArr = [
        {name: '<span style="color: red">*</span>总节数', key: 'course_nums', requier: 'yes'},
        {name: '<span style="color: red">*</span>下单时间', key: 'order_time', requier: 'yes', isDate: 'one'},
        {name: '<span style="color: red">*</span>总金额', key: 'total_money', requier: 'yes'},
        {name: '<span style="color: red">*</span>剩余节数', key: 'reamain_nums', requier: 'yes'},
        {name: '截止时间', key: 'over_time', requier: 'yes', isDate: 'over_time'},
        {name: '<span style="color: red">*</span>课程名称', key: 'course_name', requier: 'yes'},
        {name: '计费方式', key: 'bill_type', requier: 'yes'},
        {name: '课程类型', key: 'course_type', requier: 'yes'},
        {name: '上课方式', key: 'class_type'},
        {name: '教练名称', key: 'coach_name', requier: 'yes'},
        {name: '同时上课', key: 'class_share'},
        {name: '赠课总次数', key: 'send_nums'},
        {name: '<span style="color: red">*</span>会员卡号', key: 'card_number', requier: 'yes'},
        {name: '<span style="color: red">*</span>产品名称', key: 'product_name', requier: 'yes'},
        {name: '收银类型', key: 'casd_type'},
        {name: '<span style="color: red">*</span>销售人名称', key: 'counselor_name', requier: 'yes'},
        {name: '收银单号', key: 'casd_number', requier: 'yes'},
        // {name: '*课程类型', key: 'course_type'},
        {name: '生效时间', key: 'start_time', isDate: 'two'},
        {name: '收费人名称', key: 'payee_name'},
        {name: '备注', key: 'note'},
        {name: '订单状态', key: 'order_status'},
        {name: '数据审核状态', key: 'limit_days'},
        {name: '有效天数', key: 'limit_days'},
        {name: '<span style="color: red">*</span>单节原价', key: 'single_original_price', requier: 'yes'},
        {name: '单节售价', key: 'single_sell_price'},
        {name: '单节POS售价', key: 'single_pos_price'},
        {name: '<span style="color: red">*</span>单节时长', key: 'single_long', requier: 'yes'},
        {name: '转让次数', key: 'transfer_limit'},
        {name: '转让金额', key: 'transfer_money'},
        {name: '<span style="color: red">*</span>合同名称', key: 'deal_name', requier: 'yes'},
        {name: '数据状态', key: 'check_status', requier: 'yes'},
    ];
    // 柜子
    $scope.memberCabinet = [
        {name: '<span style="color: red">*</span>柜子名称', key: 'cabinet_name', requier: 'yes'},
        {name: '<span style="color: red">*</span>柜子编号', key: 'cabinet_number', requier: 'yes'},
        {name: '<span style="color: red">*</span>柜子状态', key: 'status', requier: 'yes'},
        {name: '<span style="color: red">*</span>租用开始日期', key: 'start_time', requier: 'yes', isDate: 'one'},
        {name: '<span style="color: red">*</span>租用结束日期', key: 'end_time', requier: 'yes', isDate: 'two'},
        {name: '<span style="color: red">*</span>消费时期', key: 'consume_time', requier: 'yes'},
        {name: '<span style="color: red">*</span>金额', key: 'price', requier: 'yes'},
        {name: '行为', key: 'behavior'},
        {name: '<span style="color: red">*</span>销售', key: 'counselor_name', requier: 'yes'},
        {name: '<span style="color: red">*</span>柜子类型', key: 'cabinet_type', requier: 'yes'},
        {name: '<span style="color: red">*</span>公司名称', key: 'company', requier: 'yes'},
        {name: '<span style="color: red">*</span>场馆名称', key: 'venue', requier: 'yes'},
        {name: '柜子大小', key: 'cabinet_model'},
        {name: '是否正式', key: 'cabinet_cate'},
        {name: '日租价', key: 'day_rent_price'},
        {name: '月租价', key: 'month_rent_price'},
        {name: '半年租价', key: 'half_year_rent_price'},
        {name: '年租价', key: 'year_rent_price'},
        {name: '押金', key: 'deposit'},
        {name: '赠送月数', key: 'give_month'},
        {name: '数据状态', key: 'check_status', requier: 'yes'},
    ];
    // 请假
    $scope.memberLeave = [
        {name: '<span style="color: red">*</span>卡名称', key: 'card_name', requier: 'yes'},
        {name: '<span style="color: red">*</span>卡号', key: 'card_number', requier: 'yes'},
        {name: '<span style="color: red">*</span>登记时间', key: 'check_time', requier: 'yes', isDate: 'one'},
        {name: '<span style="color: red">*</span>请假时间', key: 'start_time', requier: 'yes', isDate: 'two'},
        {name: '<span style="color: red">*</span>消假时间', key: 'end_time', requier: 'yes', isDate: 'tree'},
        {name: '请假时长', key: 'leave_length'},
        {name: '请假事由', key: 'note', textArea: 'summernote'},
        {name: '<span style="color: red">*</span>请假类型', key: 'leave_property', requier: 'yes'},
        {name: '<span style="color: red">*</span>经办人', key: 'oper_name', requier: 'yes'},
        {name: '<span style="color: red">*</span>假期状态', key: 'status', requier: 'yes'},
    {name: '数据状态', key: 'check_status', requier: 'yes'},
    ];
    // 上课记录
    $scope.classRecord = [
        {name: '<span style="color: red">*</span>会员', key: 'username', requier: 'yes'},
        {name: '<span style="color: red">*</span>卡号', key: 'card_number', requier: 'yes'},
        {name: '私教课', key: 'class_name'},
        {name: '<span style="color: red">*</span>教练', key: 'coach_name', requier: 'yes'},
        {name: '<span style="color: red">*</span>时长', key: 'time_long', requier: 'yes'},
        {name: '<span style="color: red">*</span>预约时间', key: 'reserver_date', requier: 'yes', isDate: 'one'},
        {name: '<span style="color: red">*</span>课程开始时间', key: 'start_date', requier: 'yes', isDate: 'two'},
        {name: '<span style="color: red">*</span>课程结束时间', key: 'start_date', requier: 'yes', isDate: 'tree'},
        {name: '数据状态', key: 'check_status', requier: 'yes'},
        {name: '课程类型', key: 'class_type'},
        {name: '课程状态', key: 'status'}
    ];
    // 行为记录
    $scope.behaviorRecord = [
        {name: '<span style="color: red">*</span>旧卡号', key: 'old_card_number', requier: 'yes'},
        {name: '<span style="color: red">*</span>行为', key: 'behavior', requier: 'yes'},
        {name: '<span style="color: red">*</span>新卡号', key: 'new_card_number', requier: 'yes'},
        {name: '金额', key: 'behavior_money', requier: 'yes'},
        {name: '消费时间', key: 'consume_date', isDate: 'one', requier: 'yes'},
        {name: '消费单号', key: 'casd_number', requier: 'yes'},
        {name: '<span style="color: red">*</span>销售', key: 'counselor_name', requier: 'yes'},
        {name: '数据状态', key: 'check_status', requier: 'yes'},
        {name: '备注', key: 'note', textArea: 'summernote'}
    ];
    $scope.tableHead = $scope.employeeArr;
    // 选择数据内容默认员工为:'1'
    $scope.typeChange = '1';
    //初始化路径
    $scope.params = function () {
        return {
            type: $scope.typeChange,
            keyword: $scope.className,
            check_status: $scope.selectStatus
        }
    }
    $scope.initPath = function(){
        $scope.initPathUrl = '/data-import/data-list?' + $.param($scope.params());
    };
    //导入数据获取
    $scope.getList = function () {
        $.loading.show();
        $http.get($scope.initPathUrl).then(function (result) {
            // console.log(result);
            $scope.importData = result.data.data;
            if (result.data.data && $scope.importData.length) {
                // console.log($scope.importData);
                $scope.importNoData = false;
            } else {
                $scope.importNoData = true;
            }
            $.loading.hide();
            $scope.importPage = result.data.pages;
        })
    };
    // 分页
    $scope.replacementPages = function (urlPages) {
        $scope.initPathUrl = urlPages;
        $scope.getList();
    };
    //切换数据内容
    $scope.getDataContent = function (content) {
        $scope.typeChange = content;
        if (content == '1') {
            $scope.tableHead = $scope.employeeArr;
        } else if (content == '2') {
            $scope.tableHead = $scope.memberArr;
        } else if (content == '3') {
            $scope.tableHead = $scope.memberCardArr;
        } else if (content == '4') {
            $scope.tableHead = $scope.classOrderArr;
        } else if (content == '5') {
            $scope.tableHead = $scope.memberCabinet;
        } else if (content == '6') {
            $scope.tableHead = $scope.memberLeave;
        } else if (content == '7') {
            $scope.tableHead = $scope.classRecord;
        } else if (content == '8') {
            $scope.tableHead = $scope.behaviorRecord;
        }
        $scope.params();
        $scope.initPath();
        $scope.getList();
    };
    $scope.params();
    $scope.initPath();
    $scope.getList();
    //搜索
    $scope.searchClass = function () {
        $scope.initPath();
        $scope.getList();
    };
    // 筛选状态
    $scope.chooseStatus = function () {
        $scope.searchClass();
    }
    //导入文件
    $scope.fileChanged = function(ele){
        $scope.files = ele.files[0];
        if($scope.files.size > 10485760){
            Message.warning("上传文件过大");
            return false;
        }
        Upload.upload({
            url    : '/data-import/upload',
            method : 'POST',
            data   : {UploadForm:{imageFile:$scope.files}, _csrf_backend: $('#_csrf').val()}
        }).then(function (result){
            if(result.data.status == 'success'){
                $scope.excel  = result.data.imgLink;
            }else{
                Message.warning(result.data.data);
            }
        })
        $scope.$apply();
    }
    //开始导入
    $scope.startImport = function () {
        // console.log($scope.excel);
        if (!$scope.excel) {
            Message.warning('请上传正确数据表格');
            return false;
        }
        if (!$scope.importType) {
            Message.warning('请选择数据处理方式');
            return false;
        }

        $scope.importParams = {
            filePath:$scope.excel,
            type: $scope.typeChange,
            filename: $scope.files.name,
            repeat: $scope.importType
        };
        $http.post('/data-import/member-export', $scope.importParams ,{"timeout": 0}).then(function (result) {
            // console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.data);
                $('#dataImportModal').modal('hide');
                $scope.getList();
            }else if(result.data.status == 'error'){
                var str = result.data.data;
                if(str.search("SQLSTATE") != -1){
                    Message.warning("请核对数据表或者数据格式是否正确！");
                }else{
                    Message.warning(result.data.data);
                }
            }
        })
    };
    $scope.importHistory = function () {
        $('#dataHistoryModal').modal('show');
        $http.get('/data-import/dock-log-list').then(function (result) {
            $scope.importHistoryData = result.data.data;
            console.log(result.data)
        })
    }
    //数据的删除
    $scope.dataClear = function(){
        Sweety.remove({
            url: "/data-import/data-del?type=" + $scope.typeChange,
            http: $http,
            title: '确定要删除吗?',
            text: '数据删除后不可恢复',
            confirmButtonText: '确定',
        }, function () {
            $scope.initPath();
            $scope.getList();
        });
    }

    //数据校对
    $scope.dataModify = function(){
        $.loading.show();
        $http.post('/data-import/modify', {type:$scope.typeChange},{timeout: 0},{async: false}).then(function (result) {
            // console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.data);
                $.loading.hide();
                $scope.initPath();
                $scope.getList();
            }else{
                $.loading.hide();
                Message.error(result.data.data);
            }

        })
    }

    //业务校对
    $scope.professionModify = function(){
        $.loading.show();
        $http.post('/data-import/profession-modify', {type:$scope.typeChange},{timeout: 0},{async: false}).then(function (result) {
            // console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.data);
                $.loading.hide();
                $scope.initPath();
                $scope.getList();
            }else{
                $.loading.hide();
                Message.error(result.data.data);
            }

        })
    }

    $scope.dataDock = function(){
        // $.loading.show();
        swal(
            {title:"您确定要同步数据么？",
                text:"数据同步后将无法恢复，请先校对数据",
                type:"warning",
                showCancelButton:true,
                confirmButtonColor:"#DD6B55",
                confirmButtonText:"是的，我要同步！",
                cancelButtonText:"让我再考虑一下…",
                closeOnConfirm:true,
                closeOnCancel:true
            },
            function(isConfirm)
            {
                if(isConfirm)
                {
                    $.loading.show();
                    $http.get("/data-import/data-dock?type=" + $scope.typeChange,{timeout: 0}).then(function (result) {
                        if (result.data.status == 'success') {
                            Message.success(result.data.data);
                            $scope.initPath();
                            $scope.getList();
                        }else{
                            $.loading.hide();
                            Message.error(result.data.data);
                        }

                    })
                }
                else{
                    swal({title:"已取消",
                        text:"您取消了同步操作！",
                        type:"error"})
                }
            }
        )

    }

    //加载完成
    $scope.$on('ngRepeatFinished', function (ngRepeatFinishedEvent) {
        // 日期插件的调用
        $("#one").datetimepicker({
            minView: "month",//设置只显示到月份
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
            autoclose: true,
            todayBtn: true //今日按钮
        }).on('changeDate', function (ev) {});
        $("#two").datetimepicker({
            minView: "month",//设置只显示到月份
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
            autoclose: true,
            todayBtn: true //今日按钮
        }).on('changeDate', function (ev) {});
        $("#tree").datetimepicker({
            minView: "month",//设置只显示到月份
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
            autoclose: true,
            todayBtn: true //今日按钮
        }).on('changeDate', function (ev) {});
        $('.summernote').summernote({
            lang: 'zh-CN'
        });
    });
    $scope.isThing = false;
    $scope.thing = function () {
        $scope.isThing = !$scope.isThing;
    }
}).directive('onFinishRenderFilters', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function () {
                    scope.$emit('ngRepeatFinished');
                });
            }
        }
    }
}).filter(
    'to_trusted', ['$sce', function ($sce) {
        return function (text) {
            return $sce.trustAsHtml(text);
        }
    }]
)
