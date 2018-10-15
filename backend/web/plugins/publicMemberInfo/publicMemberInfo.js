/**
 * Created by Administrator on 2018/5/4 0004.
 */
angular.module('App').controller('publicMemberInfoCtrl',function($http,$scope,$rootScope){
    //接受父级控制器传的参数
    $scope.$on('to-child', function(d,id) {
        console.log(id);         //子级能得到值
        $scope.memberId = id;
        $scope.selectState = '';
        $scope.memberPath();
        $scope.getMemberData(id);
    });
    $scope.memberPath = function () {
        $scope.MAIN = {
            'MEMBER_PATH': {
                'memberCardPath': '/user/member-card-info?' + "MemberId=" + $scope.memberId +'&type=1',
                'groupPath': '/user/group-class-info?' + "MemberId=" + $scope.memberId,
                'giftPAth': '/user/gift-record-info?' + "MemberId=" + $scope.memberId,
                'cabinetPath': '/cabinet/member-consum-list?cabinetId=&type=&memberId='+$scope.memberId,
                'leavePath': "/user/leave-record-info?MemberId=" + $scope.memberId,
                'consumptionPath': "/user/consumption-info?MemberId=" + $scope.memberId,
                'entryRecordPath': "/member/entry-record-info?MemberId=" + $scope.memberId,
                'memberPath': "/user/member-detail?MemberId=" + $scope.memberId,
                'chargePath': "/user/charge-class-info?MemberId=" + $scope.memberId
            }
        }
    };
    
    /**********会员详情开始*****************/
    // $scope.getMemberDataCard = function (id) {
    //     console.log(id)
    //     $scope.memberId = id;
    //     $scope.selectState = '';
    //     $scope.memberPath();
    //     $scope.getMemberData(id);
    // };
    //获取会员卡的请假信息
    $scope.getMemberCardLeaveMessage = function () {
        //var id = $('.dataId').attr('data-id');
        $.loading.show();
        $http.get('/check-card/get-check-card?id=' + $scope.memberId).then(function (response) {
            $scope.memberLeaveCardDetail = response.data.data.leaveStatus;
            $.loading.hide();
        });
    };
    //$scope.getMemberCardLeaveMessage();
    //会员卡详情模态框关闭事件
    $('#publicMemberInfoModal').on('hidden.bs.modal', function () {
        $('div.tab-content .tab-pane').removeClass('active');
        var $nav = $('.nav-tabs li');
        $nav.removeClass('active');
        $('#tab-1').addClass('active');
        $('.nav-tabs li:first').addClass('active');
        $scope.depositMoneyShow = false;
    });
    $scope.getMemberData = function (id) {
        $.loading.show();
        $http.get("/user/member-details-card?MemberId=" + id).then(function (result) {
            //console.log(result)
            $scope.MemberData = result.data;
            $.loading.hide();
        });
    };
    /******点击资料选项触发事件*******/
    $scope.getMemberDetail = function (id) {
        $scope.getDetailData(id);
    };
    
    /******获取会员详细信息*******/
    $scope.getDetailData = function () {
        $.loading.show();
        $http.get($scope.MAIN.MEMBER_PATH.memberPath).success(function (result) {
            $.loading.hide();
        });
    };
    /******获取会员卡信息*******/
    $scope.getMemCard = function () {
        $scope.getCardData();
    };
    $scope.getCardData = function () {
        $.loading.show();
        $http.get($scope.MAIN.MEMBER_PATH.memberCardPath).success(function (response) {
            if (response.item == "" || response.item == undefined || response.item.length <= 0) {
                $scope.items = response.item;
                $scope.memberCardPages = response.pages;
                $scope.memberCardNoDataShow = true;
            } else {
                $scope.items = response.item;
                $scope.memberCardPages = response.pages;
                $scope.memberCardNoDataShow = false;
            }
            $.loading.hide();
        });
    };
    $scope.replaceMemberCard = function (urlPages) {
        $scope.MAIN.MEMBER_PATH.memberCardPath = urlPages;
        $scope.getCardData();
    };
    $scope.delMemberCard = function (id) {
        Sweety.remove({
            url: "/user/member-card-del?memberId=" + id,
            http: $http,
            title: '确定要删除吗?',
            text: '删除后所有信息无法恢复',
            confirmButtonText: '确定',
            data: {
                action: 'unbind'
            }
        }, function () {
            $scope.getCardData();
        });
    };

    /******点击私课触发事件*******/
    $scope.getChargeClass = function (id) {
        $scope.getChargeClassData(id);
    };
    /******获取私课表信息*******/
    $scope.getChargeClassData = function () {
        $.loading.show();
        $http.get($scope.MAIN.MEMBER_PATH.chargePath).success(function (response) {
            if (response.charge == undefined || response.charge == '') {
                $scope.privateNoDataShow = true;
            } else {
                $scope.privateNoDataShow = false;
            }
            $scope.charges = response.charge;
            $scope.privatePages = response.pages;
            $.loading.hide();
        });
    };
    $scope.chargeClass = function (urlPages) {
        $scope.MAIN.MEMBER_PATH.chargePath = urlPages;
        $scope.getChargeClassData();
    };
    /******点击私课触发详细事件*******/
    $scope.getChargeClassDetail = function (id, charge_id, name) {
        // $scope.getChargeData(id, charge_id);
        // $scope.productName = name;
    };
    /******获取私课上课记录表数据*******/
    // $scope.getChargeData = function (id, charge_id) {
    //     $.loading.show();
    //     $http.get("/user/class-record-info?MemberId=" + $scope.memberId + '&charge_id=' + charge_id).success(function (response) {
    //         $scope.records = response.record;
    //         $.loading.hide();
    //     });
    // };

    /******点击请假选项触发事件*******/
    $scope.getLeaveRecord = function (id) {
        $http.get('/member/automatic-leave?memberId=' + $scope.memberId).then(function (res) {
            $scope.getLeaveData(id);
        });
    };
    /******获取请假表信息*******/
    $scope.getLeaveData = function () {
        $.loading.show();
        $http.get($scope.MAIN.MEMBER_PATH.leavePath).success(function (response) {
            if (response.vacate == undefined || response.vacate == '') {
                $scope.leaveNoDataShow = true;
            } else {
                $scope.leaveNoDataShow = false;
            }
            $scope.vacates = response.vacate;
            $scope.leavePages = response.pages;
            $.loading.hide();
        });
    };
    $scope.replaceLeavePage = function (urlPages) {
        $scope.MAIN.MEMBER_PATH.leavePath = urlPages;
        $scope.getLeaveData();
    };
    /*****点击消除请假*****/
    $scope.removeLeave = function (id, status) {
        if (status == 1) {
            Sweety.remove({
                url: "/check-card/del-leave-record?id=" + id,
                http: $http,
                title: '确定要销假吗?',
                text: '销假后信息无法恢复',
                confirmButtonText: '确定',
                confirmButton: '销假',
                data: {
                    action: 'unbind'
                }
            }, function () {
                $scope.getMemberCardLeaveMessage();
                $scope.getMembersData()
                $scope.getLeaveData();
            }, function () {

            }, true, true);
        } else {
            return;
        }

    };

    $scope.removeMemberLeave = function (id) {
        Sweety.remove({
            url: "/check-card/del-leave-record?id=" + id,
            http: $http,
            title: '确定要销假吗?',
            text: '销假后信息无法恢复',
            confirmButtonText: '确定',
            confirmButton: '销假',
            data: {
                action: 'unbind'
            }
        }, function () {
            $scope.getMemberCardLeaveMessage();
            $scope.getMembersData();
        }, function () {

        }, true, true);
    }
    
    /******点击团课选项触发事件*******/
    $scope.getGroupClass = function (id) {
        $scope.getGroupClassData(id);
    };
    /******获取团课表信息*******/
    $scope.getGroupClassData = function () {
        $.loading.show();
        $http.get($scope.MAIN.MEMBER_PATH.groupPath).success(function (response) {
            if (response.group == undefined || response.group == '') {
                $scope.groupNoDataShow = true;
            } else {
                $scope.groupNoDataShow = false;
            }
            $scope.groups = response.group;
            $scope.groupPages = response.pages;
            $.loading.hide();
        });
    };
    $scope.replaceGroupPage = function (urlPages) {
        $scope.MAIN.MEMBER_PATH.groupPath = urlPages;
        $scope.getGroupClassData();
    };

    /******点击消费选项触发事件*******/
    $scope.getHistory = function (id) {
        $scope.getHistoryData(id);
    };
    $scope.switchSort = function (sort) {
        if (!sort) {
            sort = 'DES';
        } else if (sort == 'DES') {
            sort = 'ASC';
        } else {
            sort = 'DES'
        }
        $scope.sort = sort;
    };
    //消费记录排序
    $scope.recordsOfConsumption = function (type, sort) {
        $scope.recordsOfConsumptionType = type;
        $scope.switchSort(sort);
        $scope.getHistoryData()
    }
    $scope.recordsOfConsumptionData = function () {
        return {
            memberId: $scope.memberId,
            sortType: $scope.recordsOfConsumptionType,
            sortName: $scope.sort
        }
    }
    /******获取消费记录表信息*******/
    $scope.getHistoryData = function () {
        var data = $scope.recordsOfConsumptionData();
        $.loading.show();
        $http.get('/user/consumption-info?' + $.param(data)).success(function (response) {
            if (response.expense == undefined || response.expense == '') {
                $scope.payNoDataShow = true;
            } else {
                $scope.payNoDataShow = false;
            }
            $scope.expenses = response.expense;
            $scope.payPages = response.pages;
            $.loading.hide();
        });
    };
    $scope.replacePayPage = function (urlPages) {
        $scope.MAIN.MEMBER_PATH.consumptionPath = urlPages;
        $scope.getHistoryData();
    };

    /******点击柜子选项触发事件*******/
    $scope.getCabinet = function (id) {
        $scope.getCabinetData(id);
    };
    /******获取柜子表信息*******/
    $scope.getCabinetData = function () {
        $.loading.show();
        $http.get($scope.MAIN.MEMBER_PATH.cabinetPath).then(function (response) {
            $scope.cabinets = response.data.data;
            $scope.cabinetPages = response.data.page;
            if ($scope.cabinets.length > 0) {
                $scope.cabinetNoDataShow = false;
            } else {
                $scope.cabinetNoDataShow = true;
            }
            $.loading.hide();
        });
    };
    $scope.replaceCabinetPages = function (urlPages) {
        $scope.MAIN.MEMBER_PATH.cabinetPath = urlPages;
        $scope.getCabinetData();
    };

    /******点击赠品选项触发事件*******/
    $scope.getGift = function (id) {

        //调用开始日期
        $("#datetimeStart").datetimepicker({
            format: 'yyyy-mm-dd',
            minView: 'month',
            language: 'zh-CN',
            autoclose: true,
            startDate: '2008-08-08'
        }).on("click", function () {
            $("#datetimeStart").datetimepicker("setEndDate", $("#datetimeEnd").val());
        });

        $scope.getGiftRecordData(id);
        $scope.searchParams = '';
        $scope.InitUrl = '&entryTime=';
        $scope.getEntryRecordData(id);
// 到场离场记录日期插件调用
        $("#datetimeStart").datetimepicker({
            format: 'yyyy-mm-dd',
            minView: 'month',
            language: 'zh-CN',
            autoclose: true,
            todayBtn: true
        }).on('changeDate', function(ev){
            $scope.backListTime = $("#datetimeStart").val();
            $scope.InitUrl      = '&entryTime=' + $scope.backListTime;
            $scope.getEntryRecordData();
        });
        // 清空到场离场记录
        $scope.initBackDateTimeInfo = function (){
            $("#datetimeStart").val("");
            $scope.backListTime = "";
            $scope.InitUrl      = '&entryTime=' + $scope.backListTime;
            $scope.getEntryRecordData();
        };
        var url = '/user/information-records?memberId=' + $scope.memberId;
        $.loading.show();
        $http.get(url).then(function (response) {
            if (response.data.data.length != 0) {
                $scope.behaviorRecordLists = response.data.data;
                $scope.behaviorRecordPages = response.data.page;
                $scope.behaviorRecordFlag = false;
            } else {
                $scope.behaviorRecordLists = response.data.data;
                $scope.behaviorRecordPages = response.data.page;
                $scope.behaviorRecordFlag = true;
            }
            $.loading.hide();
        });
    };

    //获取会籍变更记录
    $scope.getSellChangeRecords = function () {
        $.loading.show();
        $http.get('/member/consultant-change?memberId=' + $scope.memberId).then(function (response) {
            if(response.data.data.length === 0) {
                $scope.consultantChangeRecordNoData = true;
                $scope.consultantChangeRecord = response.data.data;
                $scope.consultantChangePage = response.data.page;
            }else {
                $scope.consultantChangeRecordNoData = false;
                $scope.consultantChangeRecord = response.data.data;
                $scope.consultantChangePage = response.data.page;
            }
            $.loading.hide();
        })
    };
    //会籍变更记录的分页
    $scope.consultantPages = function (url) {
        $.loading.show();
        $http.get(url).then(function (response) {
            if(response.data.data.length === 0) {
                $scope.consultantChangeRecordNoData = true;
                $scope.consultantChangeRecord = response.data.data;
                $scope.consultantChangePage = response.data.page;
            }else {
                $scope.consultantChangeRecordNoData = false;
                $scope.consultantChangeRecord = response.data.data;
                $scope.consultantChangePage = response.data.page;
            }
            $.loading.hide();
        })
    };
    $scope.depositMoneyShow = false;

    //转卡记录获取
    $scope.turnCardRecord = function () {
        $.loading.show();
        $http.get('/member/turn-card-info?memberId=' + $scope.memberId).then(function (response) {
            if(response.data.data =='' || response.data.data ==null || response.data.data ==undefined){
                $scope.noTransferData = true;
                $scope.turnCardRecordList = response.data.data;
            }else{
                $scope.noTransferData = false;
                $scope.turnCardRecordList = response.data.data;
            }
            $.loading.hide();
        })
    };

    //获取私教变更记录
    $scope.privateChangeRecord = function () {
        $.loading.show();
        $http.get('/member/personal-change?memberId=' + $scope.memberId).then(function (response) {
            if(response.data.data.length === 0) {
                $scope.privateChangeRecordNoData = true;
                $scope.privateTeachChangeRecord = response.data.data;
                $scope.privateChangePage = response.data.page;
            }else {
                $scope.privateChangeRecordNoData = false;
                $scope.privateTeachChangeRecord = response.data.data;
                $scope.privateChangePage = response.data.page;
            }
            $.loading.hide();
        })
    };
    //私教变更记录的分页
    $scope.personalPages = function (url) {
        $.loading.show();
        $http.get(url).then(function (response) {
            if(response.data.data.length === 0) {
                $scope.privateChangeRecordNoData = true;
                $scope.privateTeachChangeRecord = response.data.data;
                $scope.privateChangePage = response.data.page;
            }else {
                $scope.privateChangeRecordNoData = false;
                $scope.privateTeachChangeRecord = response.data.data;
                $scope.privateChangePage = response.data.page;
            }
            $.loading.hide();
        })
    };
    /*** 信息记录的改变事件 ***/
    $scope.SelectMessage = function (value){
        if(value == '3'){
            $scope.getMemberSendCardRecord();
        }
        if(value == '4'){
            $scope.getDelayPrivateRecord();
        }
        if(value == '5'){
            $scope.getGiftDaysInfoRecond();
        }
        if(value == '6') {
            $scope.depositSelect = '';
            $scope.depositAllMoney = '';
            $scope.depositSelectChange($scope.depositSelect);
            $scope.depositMoneyShow = true;
        }else {
            $scope.depositMoneyShow = false;
        }
        if(value == '7') {
            $scope.getSellChangeRecords();
        }
        if(value == '8') {
            $scope.turnCardRecord();
        }
        if(value == '9') {
            $scope.privateChangeRecord();
        }
    };

    $scope.depositNoDataShow = false;
    $scope.getDepositAllMoney = function() {
        if($scope.depositSelect == undefined || $scope.depositSelect == null) {
            $scope.depositSelect = '';
        }
        $.loading.show();
        $http.get('/member/member-deposit-list?memberId='+ $scope.memberId +'&type='+ $scope.depositSelect).then(function (data) {
            if(data != null && data !=undefined && data != '') {
                $scope.getDepositInfoData = data.data.deposit;
                if($scope.getDepositInfoData.length == 0) {
                    $scope.depositAllMoney = 0;
                    $scope.depositNoDataShow = true;
                }else {
                    $scope.depositAllMoney = data.data.allPrice;
                    $scope.depositNoDataShow = false;
                }
                $.loading.hide();
            }
        })
    };
    //订金的信息记录
    $scope.depositSelectChange = function (val) {
        $scope.depositSelect = val;
        $scope.getDepositAllMoney();

    };
    /******获取赠品表信息*******/
    $scope.getGiftRecordData = function () {
        $scope.getGiftUrl = '/user/gift-record-info?memberId=' + $scope.id;
        $.loading.show();
        $http.get($scope.getGiftUrl).success(function (response) {
            if (response.gift == undefined || response.gift == null || response.gift == "") {
                $scope.giftNoDataShow = true;
                $scope.giftList = response.gift;
                $scope.pages = response.pages;
            }
            else {
                $scope.giftNoDataShow = false;
                $scope.giftList = response.gift;
                $scope.pages = response.pages;
            }
            $.loading.hide();
        });
    };
    $scope.replaceGiftPage = function (urlPages) {
        $scope.getGiftUrl = urlPages;
        $scope.getGiftRecordData();
    };

    // 点击领取赠品
    $scope.receiveGift = function (id) {
        $scope.giftIdReceive = id;
        $.loading.show();
        $http.get("/user/update-gift-status?id=" + $scope.giftIdReceive).success(function (data) {
            if (data.status == "success") {
                Message.success(data.data);
                $scope.getGiftRecordData();
            } else {
                Message.warning(data.data);
            }
            $.loading.hide();

        })
    };
    /*** 获取送人记录 ***/
    // 获取潜在会员送人卡信息记录
    $scope.getMemberSendCardRecord = function () {
        $.loading.show();
        $http.get("/user/get-member-send-record?memberId=" + $scope.id).success(function (data) {
            $scope.memberSendCardList = data.data;
            if ($scope.memberSendCardList.length == 0) {
                $scope.payNoSendCardRecordDataShow = true; //暂无数据图像显示
            }
            else {
                $scope.payNoSendCardRecordDataShow = false; //暂无数据图像关闭
            }
            $.loading.hide();
        });
    };
    /*** 获取私课延期记录 ***/
    $scope.getDelayPrivateRecord = function (){
        $.loading.show();
        $http.get("/member/extension-record-info?memberId=" + $scope.id).success(function (data){
            $scope.delayPrivateRecordList = data.extension;
            if($scope.delayPrivateRecordList.length != 0){
                $scope.priDelayNoDataShow = false;
            }
            else{
                $scope.priDelayNoDataShow = true;
            }
            $.loading.hide();
        });
    };
    /*** 获取赠送天数记录 ***/
    // 获取赠送天数记录
    $scope.getGiftDaysInfoRecond = function (){
        $.loading.show();
        $http.get("/member/give-day-info?memberId=" + $scope.id).success(function (data){
            if(data.data != '' && data.data != null && data.data != [] && data.data != undefined){
                $scope.giftDaysInfoRecondData = data.data;
                $scope.giftNoDataInfoHaShow   = false;
            }
            else{
                $scope.giftDaysInfoRecondData = data.data;
                $scope.giftNoDataInfoHaShow   = true;
            }
            $.loading.hide();
        });
    };
    /******点击进场选项触发事件*******/
    // $scope.getEntryRecord = function(id){
    //     $scope.searchParams = '';
    //     $scope.InitUrl      = '&entryTime=';
    //     $scope.getEntryRecordData(id);
    // };
    /******获取进场表信息*******/
    $scope.getEntryRecordData = function () {
        $.loading.show();
        $http.get($scope.MAIN.MEMBER_PATH.entryRecordPath + $scope.InitUrl).success(function (response) {
            if (response.entry == undefined || response.entry == '') {
                $scope.entryNoDataShow = true;
            } else {
                $scope.entryNoDataShow = false;
            }
            $scope.entrys = response.entry;
            $scope.entryPages = response.pages;
            $scope.count = response.count;
            $.loading.hide();
        });
    };
    $scope.replaceEntryPages = function (urlPages) {
        $scope.MAIN.MEMBER_PATH.entryRecordPath = urlPages + $scope.InitUrl;
        $scope.getEntryRecordData();
    };
    /**处理搜索到场数据***/
    $scope.searchEntryData = function () {
        return {
            entryTime: $scope.entryTime != undefined ? $scope.entryTime : null
        }
    };
    $scope.initPaths = function () {

        $scope.searchParams = $scope.searchEntryData();
        if ($scope.searchParams != '' && $scope.searchParams != undefined) {
            $scope.InitUrl = '&entryTime=' + $scope.searchParams.entryTime;
        }
    };
    /**搜索到场方法***/
    $scope.searchEntry = function () {
        $scope.initPaths();
        $scope.getEntryRecordData();
    };

});
