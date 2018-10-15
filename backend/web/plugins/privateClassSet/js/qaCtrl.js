/*
健康问答Js*/
angular.module('App').controller('qaCtrl',function($scope,$http,$timeout){
    //添加病史按钮
    $scope.addHistory = function(){
        $('#addHistoryModal').modal('show');
    };
    //添加病史模态框完成按钮
    $scope.historySuccess = function(){
        if($scope.historyName == '' || $scope.historyName == undefined){
            Message.warning('请输入名称');
            return
        }
        if($scope.historyName.length >6){
            Message.warning('最多输入6位');
            return
        }
        var addHistoryParam = {
            title : $scope.historyName
        };
        $http({
            url : '/health-question/create?type=1',
            method : 'POST',
            data : $.param(addHistoryParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#addHistoryModal').modal('hide');
                $scope.getHistoryData();
            }else{
                Message.warning(result.data.mes.title[0]);
            }
        })
    };
    //模态框关闭事件
    $('#addHistoryModal').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.historyName = '';
    });
    //获取病史列表
    $scope.getHistoryData = function(){
        $http.get('/health-question/list?type=1').success(function(result){
            //console.log(result);
            if(result.length != 0){
                $scope.historyList = result;
                $scope.historyNoData = false;
            }else{
                $scope.historyList = result;
                $scope.historyNoData = true;
            }
        })
    };
    $scope.getHistoryData();
    //修改病史
    $scope.updateHistory = function(id,title){
        $('#updateHistoryModal').modal('show');
        $scope.updateHistoryId = id;
        $scope.updateHistoryName = title;
    };
    //修改病史完成按钮
    $scope.updateHistorySuccess = function(){
        if($scope.updateHistoryName == '' || $scope.updateHistoryName == undefined){
            Message.warning('请输入名称');
            return
        }
        if($scope.updateHistoryName.length >6){
            Message.warning('最多输入6位');
            return
        }
        var updateHistoryParam = {
            title : $scope.updateHistoryName
        };
        $http({
            url : '/health-question/update?id=' + $scope.updateHistoryId,
            method : 'POST',
            data : $.param(updateHistoryParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#updateHistoryModal').modal('hide');
                $scope.getHistoryData();
            }else{
                Message.warning(result.data.mes.title[0]);
            }
        })
    };
    //删除病史按钮
    $scope.deleteHistory = function(id){
        swal({
            title: "确定删除吗？",
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
                $http.get('/health-question/delete?id=' + id).success(function(result){
                    console.log(result);
                    if(result.status == 'success'){
                        swal(result.mes,'','success');
                        $timeout(function(){
                            swal.close();
                        },300);
                        $scope.getHistoryData();
                    }else{
                        swal(result.mes,'','error');
                    }
                })
            } else {
                swal.close();
            }
        });
    };
    //添加其他问题按钮
    $scope.addOther = function(){
        $('#addOtherModal').modal('show');
    };
    //添加其他问题模态框完成按钮
    $scope.otherSuccess = function(){
        if($scope.otherName == '' || $scope.otherName == undefined){
            Message.warning('请输入名称');
            return
        }
        if($scope.otherName.length >30){
            Message.warning('最多输入30位');
            return
        }
        var addOtherParam = {
            title : $scope.otherName
        };
        $http({
            url : '/health-question/create?type=2',
            method : 'POST',
            data : $.param(addOtherParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#addOtherModal').modal('hide');
                $scope.getOtherData();
            }else{
                Message.warning(result.data.mes.title[0]);
            }
        })

    };
    //模态框关闭事件
    $('#addOtherModal').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.otherName = '';
    });
    //获取其他问题列表
    $scope.getOtherData = function(){
        $http.get('/health-question/list?type=2').success(function(result){
            //console.log(result);
            if(result.length != 0){
                $scope.otherList = result;
                $scope.otherNoData = false;
            }else{
                $scope.otherList = result;
                $scope.otherNoData = true;
            }
        })
    };
    $scope.getOtherData();
    //修改其他问题
    $scope.updateOther = function(id,title){
        $('#updateOtherModal').modal('show');
        $scope.updateOtherId = id;
        $scope.updateOtherName = title;
    };
    //修改其他问题完成按钮
    $scope.updateOtherSuccess = function(){
        if($scope.updateOtherName == '' || $scope.updateOtherName == undefined){
            Message.warning('请输入名称');
            return
        }
        if($scope.updateOtherName.length >30){
            Message.warning('最多输入30位');
            return
        }
        var updateOtherParam = {
            title : $scope.updateOtherName
        };
        $http({
            url : '/health-question/update?id=' + $scope.updateOtherId,
            method : 'POST',
            data : $.param(updateOtherParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#updateOtherModal').modal('hide');
                $scope.getOtherData();
            }else{
                Message.warning(result.data.mes.title[0]);
            }
        })
    };
    //删除其他问题按钮
    $scope.deleteOther = function(id){
        swal({
            title: "确定删除吗？",
            text: "",
            timer: 2000,
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
                $http.get('/health-question/delete?id=' + id).success(function(result){
                    //console.log(result);
                    if(result.status == 'success'){
                        swal(result.mes,'','success');
                        $timeout(function(){
                            swal.close();
                        },300);
                        $scope.getOtherData();
                    }else{
                        swal(result.mes,'','error');
                    }
                })
            } else {
                swal.close();
            }
        });
    };
});
