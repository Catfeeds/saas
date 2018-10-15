/*
私教来源js*/
angular.module('App').controller('sourceCtrl',function($scope,$http,$timeout){
    //添加私教来源
    $scope.addSourceBtn = function(){
        $('#addSourceModal').modal('show');
    };
    //添加完成按钮
    $scope.sourceSuccess = function(){
        if($scope.sourceName == '' || $scope.sourceName == undefined){
            Message.warning('请输入名称');
            return
        }
        if($scope.sourceName.length > 6){
            Message.warning('最多输入6位');
            return
        }
        var addSourceParam = {
            title : $scope.sourceName
        };
        $http({
            url : '/follow/from-add',
            method :'POST',
            data : $.param(addSourceParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#addSourceModal').modal('hide');
                $scope.getSource();
            }else{
                Message.warning(result.data.mes.title[0])
            }
        })
    };
    //模态框关闭
    $('#addSourceModal').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.sourceName = '';
    });
    //获取私教来源列表
    $scope.getSource = function(){
        $http.get('/follow/from-list') .success(function(result){
            if(result.length != 0){
                $scope.sourceList = result;
                $scope.sourceNoData = false;
            }else{
                $scope.sourceList = result;
                $scope.sourceNoData = true;
            }
        })
    };
    $scope.getSource();
    //修改私教来源
    $scope.updateSourceBtn = function(id,title){
        $('#updateSourceModal').modal('show');
        $scope.updateSourceId = id;
        $scope.updateSourceName = title;
    };
    //修改完成按钮
    $scope.updateSourceSuccess = function(){
        if($scope.updateSourceName == '' || $scope.updateSourceName == undefined){
            Message.warning('请输入名称');
            return
        }
        if($scope.updateSourceName.length > 6){
            Message.warning('最多输入6位');
            return
        }
        var updateSourceParam = {
            title : $scope.updateSourceName
        };
        $http({
            url : '/follow/from-update?id=' + $scope.updateSourceId,
            method :'POST',
            data : $.param(updateSourceParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#updateSourceModal').modal('hide');
                $scope.getSource();
            }else{
                Message.warning(result.data.mes.title[0])
            }
        })
    };
    //删除按钮
    $scope.deleteSource = function(id){
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
                $http.get('/follow/from-delete?id=' + id).success(function(result){
                    //console.log(result);
                    if(result.status == 'success'){
                        swal(result.mes,'','success');
                        $timeout(function(){
                            swal.close();
                        },300);
                        $scope.getSource();
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