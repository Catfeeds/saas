$(function(){

});
angular.module('App').controller('actionCategoryCtrl',function($scope,$http){


/**********
     获取列表
*******/
    $scope.getMenuList = function(){
        $http.get('/action-category/get-cate-list').then(function(result){
            //console.log(result);
            if(result.data.data.length != 0){
                $scope.parentMenuList = result.data.data;
                $scope.actionNoData = false;
            }else{
                $scope.parentMenuList = result.data.data;
                $scope.actionNoData = true;
            }
        })
    };
    $scope.getMenuList();

    $scope.parentClickNum = 1;
    $scope.firstMenu = function(id){
        $scope.childMenuList = [];
        //获取子级列表
        $http.get('/action-category/get-cate-list?id=' + id).then(function(result){
            //console.log(result);
            if(result.data.data.length != 0){
                $.n=
                $scope.childMenuList  = result.data.data;
            }else{
                $scope.childMenuList = result.data.data;
            }
        });
        $('.secondMenu'+ id).toggle();
        $('.firstMenu' + id).parent().siblings().children('ul').css('display','none');
        $('.firstMenu' + id).parent().siblings().children('.aaa').find('.bbb').removeClass('downImg').addClass('upImg');
        if($('.secondMenu' + id).css('display') == 'none'){
            $('.fold' + id).removeClass('downImg').addClass('upImg');
        }else{
            $('.fold' + id).removeClass('upImg').addClass('downImg');
        }
    };
    //二级菜单点击事件
    $scope.childClickNum = 1;
    $scope.secondMenu = function(id){
        $scope.childClickNum ++;
        $scope.thirdMenuList = [];
        //获取子级列表
        $http.get('/action-category/get-cate-list?id=' + id ).then(function(result){
            //console.log(result);
            if(result.data.data.length != 0){
                $scope.thirdMenuList = result.data.data;
            }else{
                $scope.thirdMenuList = result.data.data;
            }
        });
        if( $scope.childClickNum % 2 == 0){
            $('.thirdMenu' + id).show();
        }else{
            $('.thirdMenu' + id).hide();
        }

        console.log($('.thirdMenu' + id).css('display'));
        //箭头方向
        if($('.thirdMenu' + id).css('display') == 'none'){
            $('.fold' + id).removeClass('downImg').addClass('upImg');
        }else{
            $('.fold' + id).removeClass('upImg').addClass('downImg');
        }
        $scope.third = id;

    };

/**********
     1.新增顶级分类
*******/
    //新增顶级分类
    $scope.addParentBtn = function(){
        $('#addParentModal').modal('show');
    };
    //参数
    $scope.addParentParam = function(){
        return{
             title: $scope.parentClassifyName,
            _csrf_backend : $('#_csrf').val()
        }
    };
    //完成按钮
    $scope.addParentSuccess = function(){
        if($scope.parentClassifyName == '' || $scope.parentClassifyName == null || $scope.parentClassifyName == undefined){
            Message.warning('请输入分类名称');
            return
        }
        if($scope.parentClassifyName == '类型'){
            Message.warning('不能用"类型"作为分类名称');
            return
        }
        $http({
            url:'/action-category/create',
            method:'POST',
            data : $.param($scope.addParentParam()),
            headers : { 'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(result){
            console.log(result);
            if(result.status == 'success'){
                Message.success('新增成功');
                $('#addParentModal').modal('hide');
                $scope.getMenuList();
                setTimeout(function(){  //使用  setTimeout（）方法设定定时2000毫秒
                    window.location.reload();//页面刷新
                },1000);
            }else{
                if(result.mes.title){
                    Message.warning('名称已存在');
                }

                $('#addParentModal').modal('hide');
            }
        })
    };
    //新增顶级分类模态框关闭
    $('#addParentModal').on('hidden.bs.modal', function (e) {
        // do something...
        $('#parentClassifyName').val('');
    });
/**********
    2.新增子级分类
*******/
    //新增子级分类
     $(".addChildBtn").click(function(){
        $('#addChildModal').modal('show');
        id = $(this).attr('value');
        console.log(id);
    });
    //参数
    $scope.addChildParam = function(){
        return{
            pid : id,
            title : $scope.childClassifyName,
            _csrf_backend : $('#_csrf').val()
        }
    };
    //子级分类完成按钮
    $scope.addChildSuccess = function(){
        if($scope.childClassifyName == '' || $scope.childClassifyName == null || $scope.childClassifyName == undefined){
            Message.warning('请输入分类名称');
            return
        }
        if($scope.childClassifyName == '类型'){
            Message.warning('不能用"类型"作为分类名称');
            return
        }
        if($scope.childClassifyName.length > 4){
            Message.warning('分类名称不要超过4个字');
            return
        }
        $http({
            url:'/action-category/create',
            method:'POST',
            data : $.param($scope.addChildParam()),
            headers : { 'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(result){
            console.log(result);
            if(result.status == 'success'){
                Message.success('新增成功');
                $('#addChildModal').modal('hide');
                $scope.getMenuList();
                setTimeout(function(){  //使用  setTimeout（）方法设定定时2000毫秒
                    window.location.reload();//页面刷新
                },1000);
            }else{
                //Message.warning(result.mes.title[0]);
                if(result.mes.title){
                    Message.warning('名称已存在');
                }

                $('#addChildModal').modal('hide');
            }
        })
    };
    //新增子级分类模态框关闭
    $('#addChildModal').on('hidden.bs.modal', function (e) {
        // do something...
        $('#childClassifyName').val('');
    });

    //修改事件
    $scope.update = function(id,title){
        $('#updateMenuModal').modal('show');
        $scope.updateClassifyName = title;
        $scope.updateId = id;
      /*   $('#updateClassifyName').val(title);*/
    }
    //参数
    $scope.updateParam = function(){
        return{
            id : $scope.updateId,
            title: $scope.updateClassifyName,
            _csrf_backend : $('#_csrf').val()
        }
    };
    //完成按钮
    $scope.updateMenuBtn = function(){
        if($scope.updateClassifyName == '' || $scope.updateClassifyName == null || $scope.updateClassifyName == undefined){
            Message.warning('请输入分类名称');
            return
        }
        if($scope.updateClassifyName == '类型'){
            Message.warning('不能用"类型"作为分类名称');
            return
        }
        if($scope.updateClassifyName.length > 4){
            Message.warning('分类名称不要超过4个字');
            return
        }
        $http({
            url:'/action-category/update?id=' + $scope.updateId,
            method:'POST',
            data : $.param($scope.updateParam()),
            headers : { 'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function(result){
            console.log(result);
            if(result.status == 'success'){
                Message.success('修改成功');
                $('#updateMenuModal').modal('hide');
                $scope.getMenuList();
                setTimeout(function(){  //使用  setTimeout（）方法设定定时2000毫秒
                    window.location.reload();//页面刷新
                },1000);
            }else{
                //Message.warning(result.mes.title[0]);
                if(result.mes.title){
                    Message.warning('名称已存在');
                }
                $('#updateMenuModal').modal('hide');
            }
        })
    };
    //模态框关闭
    $('#addParentModal').on('hidden.bs.modal', function (e) {
        // do something...
        $('#parentClassifyName').val('');
    });

    //删除事件
    $scope.delete = function(Id){
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
        }, function(isConfirm){
            if (isConfirm) {
                $http.get('/action-category/delete?id=' + Id).success(function(result){
                    console.log(result)
                    if(result.status == 'success'){
                        swal(result.mes, "", "success");
                        $scope.getMenuList();
                        setTimeout(function(){  //使用  setTimeout（）方法设定定时2000毫秒
                            window.location.reload();//页面刷新
                        },1000);
                    }else{
                        swal(result.mes, "", "error") ;
                    }
                })

            } else {
                swal.close();
            }
        });
    }
});


