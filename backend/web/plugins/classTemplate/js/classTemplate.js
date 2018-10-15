/*
课程模板js
*/
$(function(){
    $('#searchType').select2({

    })
});
angular.module('App').controller('classTemplateCtrl',function($scope,$http,$timeout){
    //获取模板分类
    //获取模板分类
    $scope.getClassify = function(){
        $http.get('/class-template/get-template-tags').success(function(result){
            //console.log(result);
            $scope.classifyList = result;
        })
    };
    $scope.getClassify();
    //参数
    $scope.getListParam = function(){
        return{
            keyword : $scope.searchKeywords && $scope.searchKeywords  != '' ? $scope.searchKeywords : null,
            cid     : $scope.searchType && $scope.searchType  != '' ? $scope.searchType : null,
        }
    };
    $scope.initPath = function(){
        $scope.initUrl = '/class-template/list?' + $.param($scope.getListParam())
    };
    $scope.initPath();
    //获取列表
    $scope.getAllTemplate = function(){
        $.loading.show();
        $http.get($scope.initUrl).success(function(result){
            //console.log(result.data);
            if(result.data.length != 0){
                $scope.templateList = result.data;
                $scope.templateNoData = false;
                $scope.templatePage = result.pages;
            }else{
                $scope.templateList = result.data;
                $scope.templateNoData = true;
                $scope.templatePage = result.pages;
            }
            $.loading.hide();
        })
    };
    $scope.getAllTemplate();
    //搜索按钮
    $scope.searchBtn = function(){
        $scope.initPath();
        $scope.getAllTemplate();
    };
    //回车搜索触发
    $scope.enterSearch = function (){
        var event = window.event || arguments.callee.caller.arguments[0];
        if (event.keyCode == 13) {
            $scope.searchBtn();
        }
    };
    //清空按钮
    $scope.clearBtn = function(){
        $scope.searchKeywords = '';
        $scope.searchType = '';
        $('#select2-searchType-container').text('请选择模板分类').attr('title','请选择模板分类');
        $scope.initPath();
        $scope.getAllTemplate();
    };
    //分页事件
    $scope.replacementPages = function(url){
        $scope.initUrl = url;
        $scope.getAllTemplate();
    };
    //复制模板
    $scope.copyBtn = function(id,title){
        $('#copyModal').modal('show');
        $scope.copyId = id;
        $scope.copyName = title + '副本';
    };
    //复制模态框完成按钮
    $scope.copySuccessBtn = function(){
        if($scope.copyName == '' || $scope.copyName == null){
            Message.warning('请输入模板名称');
            return
        }
        if($scope.copyName.length > 10){
            Message.warning('模板名称不能大于10位');
            return
        }
        var copyParam = {
            id : $scope.copyId,
            title : $scope.copyName
        };
        $.loading.show();
        $http({
            url : '/class-template/template-copy',
            method :'POST',
            data : $.param(copyParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#copyModal').modal('hide');
                $scope.getAllTemplate();
            }else{
                Message.warning(result.data.mes.title[0])
            }
            $.loading.hide();
        })
    };
    //复制模态框关闭
    $('#copyModal').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.copyName = '';
    });
    //删除模板
    $scope.deleteOne = function(id){
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
                $http.get('/class-template/delete?id=' + id).success(function(result){
                    console.log(result);
                    if(result.status == 'success'){
                        swal(result.mes,'','success');
                        $timeout(function(){
                            swal.close();
                        },300);
                        $scope.getAllTemplate();
                    }else{
                        swal(result.mes,'','error');
                    }
                })
            } else {
                swal.close();
            }
        });
    };
    //编辑模板
    $scope.updateTemplate = function(id){
        window.location.href = "/class-template/update-template?updateId=" + id;
    };
    /**********模板详情事件*************/
    //获取模板分类
    $scope.getClassify = function(){
        $http.get('/class-template/get-template-tags').success(function(result){
            //console.log(result);
            $scope.classifyList = result;
        })
    };
    //获取动作
    $scope.getActionInfo = function(){
        $http.get('/class-template/get-actions').success(function(result){
            //console.log(result);
            $scope.actionListData = result;
        })
    };
    //详情按钮
    $scope.detailBtn = function(id){
        $('#detailModal').modal('show');
        $scope.getActionInfo();
        $scope.getClassify();
        $scope.updateOneId = id;
        $.loading.show();
        $http.get('/class-template/get-one-detail?id=' + id).success(function(result){
            //console.log(result);
            $scope.detailTitle = result.title;
            $scope.detailDescribe = result.describe;
            $scope.detailStage =  result.stages;
            $scope.detailC_title  = result.c_title;
            //遍历动作
            $scope.modalActionIdArr = []; //动作数组
            $scope.detailStage.map(function(item,i){
                //console.log(item);
                item.main.map(function(item,i){
                    $scope.modalActionIdArr.push(item.action_id)
                });
            });

        });
    };
    $('#detailModal').on('shown.bs.modal', function () {
        $('#modalSelect').select2({
            width:'150px'
        });
        $('.modalSelect').select2({
            width:'150px'
        });
        //console.log($('.modalSelect'));
        $scope.modalActionIdArr.map(function(item,i){
            //$('.chooseSelect').val(item);
            $scope.oneId = item;
            $('.modalSelect').eq(i).val($scope.oneId).trigger("change");
        });
        $.loading.hide();
    });
    //模态框修改按钮
    $scope.updateOneBtn = function(){
        console.log($scope.updateOneId);
        window.location.href = "/class-template/update-template?updateId=" + $scope.updateOneId;
    }
});
