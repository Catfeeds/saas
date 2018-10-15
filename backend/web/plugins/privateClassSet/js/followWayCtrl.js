/*
跟进方式js*/
angular.module('App').controller('followWayCtrl',function($scope,$http,$timeout){
    //添加跟进方式
    $scope.addFollowWayBtn = function(){
        $('#addFollowWay').modal('show');
    };
    //添加完成按钮
    $scope.followWaySuccess = function(){
        if($scope.followWayName == '' || $scope.followWayName == undefined){
            Message.warning('请输入名称');
            return
        }
        if($scope.followWayName.length > 6){
            Message.warning('最多输入6位');
            return
        }
        var addWayParam = {
            title : $scope.followWayName
        };
        $http({
            url : '/follow/way-add',
            method :'POST',
            data : $.param(addWayParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#addFollowWay').modal('hide');
                $scope.getFollowWay();
            }else{
                Message.warning(result.data.mes.title[0])
            }
        })
    };
    //模态框关闭
    $('#addFollowWay').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.followWayName = '';
    });
    //获取跟进方式列表
    $scope.getFollowWay = function(){
        $http.get('/follow/way-list') .success(function(result){
            if(result.length != 0){
                $scope.followWayList = result;
                $scope.followWayNoData = false;
            }else{
                $scope.followWayList = result;
                $scope.followWayNoData = true;
            }
        })
    };
    $scope.getFollowWay();
    //修改跟进方式
    $scope.updateFollowWayBtn = function(id,title){
        $('#updateFollowWay').modal('show');
        $scope.updateWayId = id;
        $scope.updateFollowWayName = title;
    };
    //修改完成按钮
    $scope.updateFollowWaySuccess = function(){
        if($scope.updateFollowWayName == '' || $scope.updateFollowWayName == undefined){
            Message.warning('请输入名称');
            return
        }
        if($scope.updateFollowWayName.length > 6){
            Message.warning('最多输入6位');
            return
        }
        var updateWayParam = {
            title : $scope.updateFollowWayName
        };
        $http({
            url : '/follow/way-update?id=' + $scope.updateWayId,
            method :'POST',
            data : $.param(updateWayParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#updateFollowWay').modal('hide');
                $scope.getFollowWay();
            }else{
                Message.warning(result.data.mes.title[0])
            }
        })
    };
    //删除按钮
    $scope.deleteWay = function(id){
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
                $http.get('/follow/way-delete?id=' + id).success(function(result){
                    //console.log(result);
                    if(result.status == 'success'){
                        swal(result.mes,'','success');
                        $timeout(function(){
                            swal.close();
                        },300);
                        $scope.getFollowWay();

                    }else{
                        swal(result.mes,'','error');
                    }
                })
            } else {
                swal.close();
            }
        });
    }
});