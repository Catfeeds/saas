/*
客户分类js*/
angular.module('App').controller('clientCtrl',function($scope,$http){
    //添加客户分类
    $scope.addClientBtn = function(){
        $('#addClientModal').modal('show');
    };
    //添加完成按钮
    $scope.clientSuccess = function(){
        if($scope.clientName == '' || $scope.clientName == undefined){
            Message.warning('请输入名称');
            return
        }
        var addClientParam = {
            title : $scope.clientName
        };
        // $http({
        //     url : '/',
        //     method :'POST',
        //     data : $.param(addClientParam),
        //     headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        // }).then(function(result){
        //     console.log(result);
        //     if(result.data.status == 'success'){
        //         Message.success(result.data.mes);
        //         $('#addClientModal').modal('hide');
        //         //$scope.getClient();
        //     }else{
        //         Message.warning(result.data.mes.title[0])
        //     }
        // })
    };
    //模态框关闭
    $('#addClientModal').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.clientName = '';
    });
    //获取客户分类列表
    $scope.getClient = function(){
        $http.get('/') .success(function(result){
            if(result.length != 0){
                $scope.clientList = result;
                $scope.clientNoData = false;
            }else{
                $scope.clientList = result;
                $scope.clientNoData = true;
            }
        })
    };
    //$scope.getClient();
    //修改客户分类
    $scope.updateClientBtn = function(id,title){
        $('#updateClientModal').modal('show');
        $scope.updateClientId = id;
        $scope.updateClientName = title;
    };
    //修改完成按钮
    $scope.updateClientSuccess = function(){
        if($scope.updateClientName == '' || $scope.updateClientName == undefined){
            Message.warning('请输入名称');
            return
        }
        var updateClientParam = {
            title : $scope.updateClientName
        };
        // $http({
        //     url : '/' + $scope.updateClientId,
        //     method :'POST',
        //     data : $.param(updateClientParam),
        //     headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        // }).then(function(result){
        //     console.log(result);
        //     if(result.data.status == 'success'){
        //         Message.success(result.data.mes);
        //         $('#updateClientModal').modal('hide');
        //         //$scope.getClient();
        //     }else{
        //         Message.warning(result.data.mes.title[0])
        //     }
        // })
    };
    //删除按钮
    $scope.deleteClient = function(id){
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
                // $http.get('/?id=' + id).success(function(result){
                //     console.log(result);
                //     if(result.status == 'success'){
                //         swal(result.mes,'','success');
                //         $scope.getClient();
                //     }else{
                //         swal(result.mes,'','error');
                //     }
                // })
            } else {
                swal.close();
            }
        });
    }
});