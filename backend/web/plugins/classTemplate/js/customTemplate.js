/*
自定义模板
*/
angular.module('App').controller('customTemplateCtrl',function($scope,$http,$timeout){
    $scope.init = function(){
        $scope.getCustomDetail();
    };
    //获取自定义模板详情
    $scope.getCustomDetail = function(){
        $.loading.show();
        $http.get('/class-template/get-custom-template').success(function(result){
            console.log(result);
            $scope.customList = result;
            $.loading.hide();
        })
    };
    $scope.init();
    //添加模板
    $scope.customNum = 0;
    $scope.addCustomDiv = function(){
        $scope.customNum ++ ;
        $scope.htmlAttr = 'addSelfTemplate';
        $.loading.show();
        $http.get('/class-template/add-temp?attr='+$scope.htmlAttr + '&num=' + $scope.customNum).then(function (result) {
            $scope.customHtml = result.data.html;
            $.loading.hide();
        });
    };
    $scope.addCustomDiv();
    //获取数据
    $scope.getCustomData = function(){
        var templateDiv = $('.templateBig').children('.templateDiv');
        $scope.templateArr = [];   //训练计划数组
        $scope.stageNameArr = [];  //阶段名称数组
        templateDiv.each(function(i,item){
            //console.log(item);
            //获取阶段名称数组
            var stageName = $(this).children().find('.stageNameDiv').find('.stageName').val();
            //获取训练时长数组
            var stageTime = $(this).children().find('.stageTimeDiv').find('.stageTime').val();
            var oneParam = {
                title : stageName,
                length_time : stageTime,
            };
            $scope.templateArr.push(oneParam);    //阶段数组
            $scope.stageNameArr.push(stageName);  //阶段名称数组
        })
    };
    //保存按钮
    $scope.submitBtn = function(){
        $scope.getCustomData();
        console.log($scope.stageNameArr);
        console.log($scope.templateArr);
        if($scope.stageNameArr.indexOf('') != -1){
            Message.warning('请输入阶段名称');
            return
        }
        var customParam = {
            plan : $scope.templateArr
        };
        $http({
            url : '/class-template/add-custom-template',
            method : 'POST',
            data : $.param(customParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (result) {
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                window.location.href = '/class-template/custom-template'
            }else{
                Message.warning('保存失败');
                console.log(result.data);
            }
        })
    };
    //取消按钮
    $scope.cancelBtn = function(){
        swal({
            title: "确定取消当前编辑内容吗？",
            text: "",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm){
            if (isConfirm) {
                window.location.href = "/class-template/index";
            } else {
                swal.close();
            }
        });
    };
});