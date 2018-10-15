/*
健身目的js
*/

angular.module('App').controller('goalCtrl',function($scope,$http,$timeout){
    //添加按钮
    $scope.addGoalBtn = function(){
        $('#addGoalModal').modal('show');
    };
    //添加模态框完成按钮
    $scope.goalSuccess = function(){
        if($scope.goalName == '' || $scope.goalName == undefined){
            Message.warning('请输入健身目的');
            return
        }
        if($scope.goalName.length > 6){
            Message.warning('最多输入6位');
            return
        }
        var addGoalParam = {
            title : $scope.goalName
        };
        $http({
            url : '/body-build-goal/create',
            method :'POST',
            data : $.param(addGoalParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#addGoalModal').modal('hide');
                $scope.getGoalData();
            }else{
                Message.warning(result.data.mes.title[0])
            }
        })
    };
    //添加模态框关闭事件
    $('#addGoalModal').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.goalName = '';
    });

    //获取列表
    $scope.getGoalData = function(){
        //$.loading.show();
        $http.get('/body-build-goal/list').success(function(result){
            //console.log(result);
            if(result.length != 0){
                $scope.goalList = result;
                $scope.goalNoData = false;
            }else{
                $scope.goalList = result;
                $scope.goalNoData = true;
            }
            //$.loading.hide();
        });
    };
    $scope.getGoalData();
    //修改
    $scope.updateGoal = function(id,title){
        $('#updateGoalModal').modal('show');
        $scope.updateGoalName = title;
        $scope.updateGoalId = id;
    };
    //修改模态框完成按钮
    $scope.updateGoalSuccess = function(id){
        if($scope.updateGoalName == '' || $scope.updateGoalName == undefined){
            Message.warning('请输入健身目的');
            return
        }
        if($scope.updateGoalName.length > 6){
            Message.warning('最多输入6位');
            return
        }
        var updateGoalParam = {
            title : $scope.updateGoalName
        };
        $http({
            url : '/body-build-goal/update?id=' + $scope.updateGoalId,
            method :'POST',
            data : $.param(updateGoalParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#updateGoalModal').modal('hide');
                $scope.getGoalData();
            }else{
                Message.warning(result.data.mes.title[0])
            }
        })
    };
    //删除按钮
    $scope.deleteGoal = function(id){
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
                //swal("删除！", "", "success");
                $http.get('/body-build-goal/delete?id=' + id).success(function(result){
                    //console.log(result);
                    if(result.status == 'success'){
                        swal(result.mes,'','success');
                        $timeout(function(){
                            swal.close();
                        },300);
                        $scope.getGoalData();
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