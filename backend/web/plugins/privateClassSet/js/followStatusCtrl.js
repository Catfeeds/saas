/*
跟进状态js*/
angular.module('App').controller('followStatusCtrl',function($scope,$http,$timeout){
    //获取列表
    $scope.getStatusData = function(){
        $http.get('/follow/state-list').success(function(result){
            //console.log(result);
            $scope.statusList = result;
        })
    };
    $scope.getStatusData();
    //初始化不让点击
    $scope.initClick = true;
    $scope.changeInit = function(){
        $scope.initClick = false;
    };
    //初始化获取选中数组
    $scope.getInitStatus = function(){
        //选中天数
        var chooseDay = $('.chooseDay');
        $scope.initDayArr = [];
        chooseDay.each(function(i,item){
            $scope.initDayArr.push($(this).attr('value'));
        });
        //选中提醒
        var chooseRemind = $('.chooseRemind');
        $scope.initRemindArr = [];
        chooseRemind.each(function(i,item){
            $scope.initRemindArr.push($(this).attr('value'));
        });
    };
    //保存按钮
    $scope.keepBtn = function(){
        //选中天数
        var chooseDay = $('.chooseDay');
        $scope.chooseDayArr = [];
        chooseDay.each(function(i,item){
            if($(this).prop('checked')){
                $scope.chooseDayArr.push($(this).attr('value'));
            }else{
                $scope.chooseDayArr.splice(i,1);
            }
            //console.log($scope.chooseDayArr);
        });
        //选中提醒
        var chooseRemind = $('.chooseRemind');
        $scope.chooseRemindArr = [];
        chooseRemind.each(function(i,item){
            if($(this).prop('checked')){
                $scope.chooseRemindArr.push($(this).attr('value'));
            }else{
                $scope.chooseRemindArr.splice(i,1);
            }
            //console.log($scope.chooseRemindArr);
        });
        var dataParam = {
            state : $scope.chooseDayArr,
            is_remind : $scope.chooseRemindArr
        };
        //console.log(dataParam);
        $.loading.show();
        $http({
            url : '/follow/state-update-all',
            method : 'POST',
            data : $.param(dataParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $scope.getStatusData();
                $scope.initClick = true;
            }else{
                Message.warning(result.data.mes);
            }
            $.loading.hide();
        })
    };

    $scope.resetBtn = function(){
        $scope.getInitStatus();
        //选中天数
        var chooseDay1 = $('.chooseDay');
        $scope.newDayArr = [];
        chooseDay1.each(function(i,item){
            if($(this).prop('checked')){
                $scope.newDayArr.push($(this).attr('value'));
            }else{
                $scope.newDayArr.splice(i,1);
            }
            //console.log($scope.chooseDayArr);
        });
        //选中提醒
        var chooseRemind1 = $('.chooseRemind');
        $scope.newRemindArr = [];
        chooseRemind1.each(function(i,item){
            if($(this).prop('checked')){
                $scope.newRemindArr.push($(this).attr('value'));
            }else{
                $scope.newRemindArr.splice(i,1);
            }
            //console.log($scope.chooseRemindArr);
        });
        //console.log($scope.initDayArr,$scope.initRemindArr);
        //console.log($scope.newDayArr,$scope.newRemindArr);
        //console.log($scope.initDayArr.length == $scope.newDayArr.length);
        //console.log($scope.initRemindArr.length == $scope.newRemindArr.length)
        if($scope.initDayArr.length == $scope.newDayArr.length && $scope.initRemindArr.length == $scope.newRemindArr.length){
            Message.warning('已经为默认状态');
            return
        }
        swal({
            title: "确定重置吗？",
            text: "",
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
                swal.close();
                $.loading.show();
                $http.get('/follow/state-reset').success(function(result){
                    //console.log(result);
                    if(result.status == 'success'){
                        Message.success(result.mes);
                        $scope.getStatusData();
                        $scope.initClick = true;
                    }else{
                        //Message.warning(result.mes);
                        Message.warning('已经为全部选中状态，请保存修改后再重置')
                    }
                    $.loading.hide();
                });
            } else {
                swal.close();
            }
        });
    }
});