/**
 * author:成立名
 * create:2018-07-25
 * 函数描述:预约场地中场地接口
 * param: venueId:场馆id
 * */
angular.module('App').controller('FieldCtrl', function ($scope, $http, Upload, $timeout,$rootScope) {
    $scope.str = decodeURI(location.search);
    $scope.str1 = $scope.str.split('?');
    $scope.str2 = $scope.str1[1].split('&');
    $scope.str3 = $scope.str2[0].split('=');
    $scope.str4 = $scope.str2[1].split('=');
    $scope.cardId = $scope.str4[1];
    $('.checkUl').height(document.documentElement.clientHeight-265 + 'px')
    $('.qq').height(document.documentElement.clientHeight-265 + 'px')
    $('.cc').height(document.documentElement.clientHeight-295 + 'px');
    $('.group-ul').height($(window).height()-145 + 'px');
    var oDate = new Date();
    var oYear = oDate.getFullYear();
    var oMonth = oDate.getMonth() + 1;
    oMonth = oMonth >= 10 ? oMonth : '0' + oMonth;
    var oDay = oDate.getDate();
    oDay = oDay >= 10 ? oDay : '0' + oDay;
    $scope.startVenue = oYear + "-" + oMonth + "-" + oDay;
    $("#venueDateStartInput").datetimepicker({
        minView: "month",//设置只显示到月份
        format: 'yyyy-mm-dd',
        language: 'zh-CN',
        autoclose: true,
        todayBtn: true //今日按钮
    }).on('changeDate', function (ev) {
        $scope.startVenue = $('#venueDateStartInput').val();
    });
    $('#venueDateStartInput').val($scope.startVenue);
    // 获取场地数据
    $scope.getMembersData = function () {
        $http.get('/check-card/get-check-card-data?id=' + $scope.cardId).then(function (result) {
            $scope.memberData = result.data.data;
            console.log($scope.memberData)

})
};
$scope.listDataItems = [];
    // 打印
    $scope.fieldModals = function () {
        if($scope.listDataItems != ''){
            $scope.listDataItems.splice(0,$scope.listDataItems.length)
        }
        if ($scope.memberData.mc_status == 1 && $scope.memberData.nowLeaveStatus.status != 1 && $scope.memberData.status != 2) {
            $http({method: 'get', url: '/site-management/get-venue-yard-page'}).then(function (data) {
                if (data.data.data.length > 0) {
                    $scope.initYardPageId = data.data.data[0].id;
                    $scope.page = data.data.nowPage + 1;
                    $scope.totalPage = data.data.totalPage;
                    for (var key in data.data.data) {
                        $scope.listDataItems.push(data.data.data[key])
                    }
                    console.log($scope.listDataItems)
                    $scope.selectSiteManagement($scope.initYardPageId, 0)
                }
            }, function (error) {
                console.log(error);
                Message.error("系统开了会小差,请刷新重试。。。");
            });
        } else {
            Message.warning('您的卡处于非正常状态，无法预约团课!');
            return;
        }
    };
    $scope.getMembersData();
    //选择场地
    $scope.selectSiteManagement = function (id, value) {
        $scope.yesSel = false;
        $scope.disBtn = false;
        $scope.isCancel = true;
        if($('#venueDateStartInput').val() == ''){
            $scope.venueTime =  $scope.getNowFormatDate();
        }else{
            $scope.venueTime = $scope.startVenue;
        }
        if (!id) {
            Message.warning('暂无场地');
            return
        }
        $scope.initYardPageId = id;
        $scope.initYardPageNumber = value;
        angular.forEach($scope.listDataItems, function (item, index) {
            if (item.id == id) {
                item.choose = true;
            } else {
                item.choose = false;
            }
        })
        $http({
            method: 'get',
            url: '/site-management/yard-detail?yardId='+ $scope.initYardPageId + "&memberAboutDate=" + $scope.venueTime + "&cardNumber=" + $scope.memberData.card_number
        }).then(function (data) {
            if (data.data.data.params != '') {
                $scope.siteDetailsLeft = data.data.data;
                $scope.dataParams = false;
            }
        }, function (error) {
            Message.error("系统开了会小差,请刷新重试。。。");
        });
        if($('#venueDateStartInput').val() == ''){
            $scope.venueTime =  $scope.getNowFormatDate();
        }else{
            $scope.venueTime = $scope.startVenue;
        }
        //判断次卡能不能预约此场地
        $http({
            method: 'get',
            url: '/site-management/is-about-yard?yardId=' + id + "&cardNum=" + $scope.memberData.card_number +"&memberAboutDate=" + $scope.venueTime
        }).then(function (data) {
            if(data.data.status == true){
                $scope.isAboutYardStatus = false;
            }else {
                $scope.isAboutYardStatus = true;
            }
        }, function (error) {
            console.log(error);
            Message.error("系统开了会小差,请刷新重试。。。");
        });
    };
    //详情数据
    $scope.siteManagementDetails = function (key, value) {
        $scope.yesSel = true;
        console.log($scope.yesSel)
        $scope.aboutIntervalSection = key;
        $scope.value = value;
        angular.forEach($scope.siteDetailsLeft.orderNumList,function (item, index) {
            if (index == key) {
                item.isClick = true;
            } else {
                item.isClick = false;
            }
        });
        if (value.timeStatus == 1) {
            $scope.disBtn = false;
            $scope.isCancel = false;
        } else {
            $scope.disBtn = true;
            $scope.isCancel = true;
        }
        if(!$('#venueDateStartInput').val()){
            $scope.venueTime =  $scope.getNowFormatDate();
        }else{
            $scope.venueTime = $scope.startVenue;
        }
        $http({
            method: 'get',
            url: '/site-management/get-about-data-detail?memberAboutDate=' + $scope.venueTime + "&aboutIntervalSection=" + key + "&yardId=" + $scope.initYardPageId
        }).then(function (data) {
            $scope.selectionTimeList = data.data.data;
            console.log($scope.selectionTimeList.length)
            if ($scope.selectionTimeList.length) {
                $scope.noDetail = false;
            } else {
                $scope.noDetail = true;
            }
            $scope.detailPages = data.data.pages;
            $scope.nowPage = data.data.nowPage;
        }, function (error) {
            Message.error("系统开了会小差,请刷新重试。。。");
        });
    };
    //预约场地
    $scope.siteReservation = function (key,num) {
        if(!$('#venueDateStartInput').val()){
            $scope.venueTime =  $scope.getNowFormatDate();
        }else{
            $scope.venueTime = $scope.startVenue;
        }
        //判断预约时间是否在7天内
        var choose = new Date($scope.venueTime);
        var chooseTime = choose.getTime();
        var now = new Date($scope.getNowFormatDate());
        var nowTime = now.getTime();
        if(chooseTime > nowTime + (7*24*60*60*1000)){
            Message.warning('请预约7天之内的');
            return;
        }
        $scope.aboutIntervalSection = key;
        var data = {
            yardId: $scope.initYardPageId,
            memberId: $scope.memberData.id,
            memberCardId: $scope.cardId,
            aboutIntervalSection: $scope.aboutIntervalSection,
            aboutDate: $scope.venueTime
        };
        $http({
            method: 'post',
            url: '/site-management/member-yard-about',
            data: $.param(data),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (success) {
            if (success.data.status == "success") {
                Message.success(success.data.data);
            }
            if (success.data.status == "error") {
                Message.warning(success.data.data);
                return;
            }
            if(num == 2){
                if(!$('#venueDateStartInput').val()){
                    $scope.venueTime =  $scope.getNowFormatDate();
                }else{
                    $scope.venueTime = $scope.startVenue;
                }
                $http({
                    method: 'get',
                    url: '/site-management/get-about-data-detail?memberAboutDate=' + $scope.venueTime + "&aboutIntervalSection=" + $scope.aboutIntervalSection + "&yardId=" + $scope.initYardPageId
                }).then(function (data) {
                    $scope.selectionTimeList = data.data.data;
                    if ($scope.selectionTimeList.length) {
                        $scope.detailInfos = false;
                        $scope.nowPage = data.data.nowPage;
                    } else {
                        $scope.detailInfos = true;
                    }
                    $scope.detailPages = data.data.pages;
                })
            }
            $scope.siteReservationList();
            $scope.siteManagementDetails(key, $scope.value);
            $scope.selectSiteManagement($scope.initYardPageId, $scope.initYardPageNumber);
        }, function (error) {
            console.log(error);
            Message.error("系统开了会小差,请刷新重试。。。");
        });
    };
    //场地预约
    $scope.siteReservationList = function () {
        $http({
            method: 'get',
            url: '/site-management/get-yard-about-record?cardNum=' + $scope.memberData.card_number
        }).then(function (data) {
            if(data.data.data != ''){
                $scope.siteReservationListDataBool = false
            }
            if(data.data.data == ''){
                $scope.siteReservationListDataBool = true;
            }
            $scope.siteReservationListData = data.data.data;
            $scope.siteReservationListDataCardId = data.data.cardId;

        }, function (error) {
            Message.error("系统开了会小差,请刷新重试。。。");
        })
    };
    $scope.cancelReservation = function (item, num, key) {
        console.log(item);
        $scope.aboutIntervalSection = key;
        if($('#venueDateStartInput').val() == ''){
            $scope.venueTime =  $scope.getNowFormatDate();
        }else{
            $scope.venueTime = $scope.startVenue;
        }
        var d = $scope.venueTime + ' ' + $scope.aboutIntervalSection.substr(0, 5)
        if (d < $scope.venueTime) {
            Message.warning("当前时间已经过期，不能取消预约!");
            return;
        } else {
            Sweety.remove({
                url: "/site-management/deal-yard-about-class?yardId="+$scope.initYardPageId+ '&memberIdB=' + item.member_id+ '&memberIdT=' + $scope.str3[1] +"&memberAboutDate="+$scope.venueTime+"&cardId="+$scope.cardId+"&intervalSection="+key,
                http: $http,
                title: '确定要取消预约吗?',
                text: '取消后所有信息无法恢复',
                closeOnConfirm: false,
                confirmButtonText: '确定',
                // data: {
                //     action: 'unbind'
                // }
            }, function (isConfirm) {
                console.log(isConfirm.data.status)
                if (isConfirm.data.status == 'error') {
                    swal({type: "warning",title: "提示",text: "取消失败" ,timer: 1000,
                        showConfirmButton: false });
                } else {
                    if (num == 1) {
                        if($('#venueDateStartInput').val() == ''){
                            $scope.venueTime =  $scope.getNowFormatDate();
                        }else{
                            $scope.venueTime = $scope.startVenue;
                        }
                        $http({
                            method: 'get',
                            url: '/site-management/yard-detail?yardId=' + $scope.initYardPageId + "&memberAboutDate=" + $scope.venueTime + "&cardNumber=" + $scope.memberData.card_number
                        }).then(function (data) {
                            if (data.data.data.params != '') {
                                $scope.siteDetailsLeft = data.data.data;
                                $scope.dataParams = false;
                            }
                        }, function (error) {
                            console.log(error);
                            Message.error("系统开了会小差,请刷新重试。。。");
                        });
                    }
                    if (num == 2) {
                        if($('#venueDateStartInput').val() == ''){
                            $scope.venueTime =  $scope.getNowFormatDate();
                        }else{
                            $scope.venueTime = $scope.startVenue;
                        }
                        $http({
                            method: 'get',
                            url: '/site-management/get-about-data-detail?memberAboutDate=' + $scope.venueTime + "&aboutIntervalSection=" + $scope.aboutIntervalSection + "&yardId=" + $scope.initYardPageId
                        }).then(function (data) {
                            if (data.data.data != "" || data.data.data != undefined) {
                                $scope.selectionTimeList = data.data.data;
                                $scope.detailPages = data.data.pages;
                                $scope.detailInfos = false;
                                $scope.nowPage = data.data.nowPage;
                            }
                            if (data.data.data == "") {
                                $scope.selectionTimeList = data.data.data;
                                $scope.detailPages = data.data.pages;
                                $scope.detailInfos = true;
                            }
                            $scope.siteReservationList();
                            $scope.selectSiteManagement($scope.initYardPageId, $scope.initYardPageNumber);
                        }, function (error) {
                            console.log(error);
                            Message.error("系统开了会小差,请刷新重试。。。");
                        })
                    }
                    $scope.siteReservationList();
                }
            },true,true)
        }
    }
    //监听滚动条加载,
    $("#contain").scroll(function () {
        var $this = $(this),
            viewH = $(this).height(),
            contentH = $(this).get(0).scrollHeight,
            scrollTop = $(this).scrollTop();
        console.log('--');
        console.log(viewH);
        if (scrollTop / (contentH - viewH) >= 0.95) {
            $scope.page = $scope.page + 1;
            if ($scope.page > $scope.totalPage) {
                $scope.page = $scope.totalPage;
                return;
            }
            if ($scope.page <= $scope.totalPage) {
                $http({
                    method: 'get',
                    url: '/site-management/get-venue-yard-page?page=' + $scope.page
                }).then(function (data) {
                    $scope.page = data.data.nowPage + 1;
                    $scope.totalPage = data.data.totalPage;
                    for (var key in data.data.data) {
                        $scope.listDataItems.push(data.data.data[key])
                    }
                }, function (error) {
                    Message.error("系统开了会小差,请刷新重试。。。");
                })
            }
        }
    });
    $scope.getNowFormatDate = function () {
        var date = new Date();
        var seperator1 = "-";
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var strDate = date.getDate();
        var hour = date.getHours();
        var minute = date.getMinutes();
        var second = date.getSeconds();
        if (month >= 1 && month <= 9) {
            month = "0" + month;
        }
        if (strDate >= 0 && strDate <= 9) {
            strDate = "0" + strDate;
        }
        var currentdate = year + seperator1 + month + seperator1 + strDate
        return currentdate;
    }
});