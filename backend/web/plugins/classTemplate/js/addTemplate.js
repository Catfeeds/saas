/*
添加课程模板js
*/
$(function(){
   $('#chooseType').select2({
       width   : '100%'
   })
});
angular.module('App').controller('addTemplateCtrl',function($scope,$http){
    //获取动作
    $scope.getActionInfo = function(){
        $http.get('/class-template/get-actions').success(function(result){
            //console.log(result);
            $scope.actionListData = result;
        })
    };
    $scope.getActionInfo();
    //训练内容 添加按钮
    $scope.addNum = 0;
    $scope.addDrill = function(){
        $scope.addNum ++;
        $scope.htmlAttr = 'addDrill';
        $.loading.show();
        $http.get('/class-template/add-temp?attr='+$scope.htmlAttr + '&num=' + $scope.addNum).then(function (result) {
            $scope.setRoleHtml = result.data.html;
            $('.selectStyle').select2({
                width   : '180px'
            });
            $.loading.hide();
        });
    };
    $scope.addDrill();
    //添加阶段模板
    $scope.templateNum = 0;
    $scope.addTemplateDiv = function(){
        $scope.templateNum ++;
        $scope.htmlAttr = 'addTemplate';
        $.loading.show();
        $http.get('/class-template/add-temp?attr='+$scope.htmlAttr + '&num=' + $scope.templateNum).then(function (result) {
            $scope.templateHtml = result.data.html;
            $scope.addDrill();
            $.loading.hide();
        });
    };
    $scope.addTemplateDiv();
    //添加模板分类按钮
    $scope.addClassifyBtn = function(){
        $('#addClassifyModal').modal('show');
    };
    //模板分类模态框完成按钮
    $scope.successBtn = function(){
        if($scope.templateName == '' || $scope.templateName == null){
            Message.warning('请输入模板分类名称');
            return
        }
        var addClassifyParam = {
            title : $scope.templateName
        };
        $http({
            url : '/class-template/add-tem-tags',
            method :'POST',
            data : $.param(addClassifyParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.mes);
                $('#addClassifyModal').modal('hide');
                $scope.getClassify();
            }else{
                Message.warning(result.data.mes.title[0]);
            }
        })
    };
    //模板分类模态框关闭
    $('#addClassifyModal').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.templateName = '';
    });
    //获取模板分类
    $scope.getClassify = function(){
        $http.get('/class-template/get-template-tags').success(function(result){
            //console.log(result);
            $scope.classifyList = result;
        })
    };
    $scope.getClassify();
    //删除模板分类按钮
    $scope.deleteClassifyBtn = function(id){
        console.log(id);
        if(id == '' || id == undefined){
            Message.warning('请选择要删除的模板分类名称');
            return
        }else{
            swal({
                title: "确定删除么？",
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
                    $http.get('/class-template/delete-tags?id=' + id).success(function(result){
                        console.log(result);
                        if(result.status == 'success'){
                            Message.success(result.mes);
                            swal.close();
                            $scope.getClassify();
                            $scope.chooseType = '';
                        }else{
                            Message.warning(result.mes)
                        }
                    })
                } else {
                    swal.close();
                }
            });
        }

    };
    //获取模板数据
    $scope.getTemplateData = function(){
        //console.log($('.templateDiv'));
        var templateDiv = $('.templateBig').children('.templateDiv');
        //console.log(templateDiv);
        $scope.templateArr = [];   //训练计划数组
        $scope.stageNameArr = [];  //阶段名称数组
        // $scope.stageTimeArr = [];//训练时长数组
        $scope.allActionArr = [];  //动作数组

        //获取所有阶段的动作数组
        $scope.totalActionArr = [];
        templateDiv.each(function(i,item){
            //console.log(item);
            //获取阶段名称数组
            var stageName = $(this).children().find('.stageNameDiv').find('.stageName').val();
            $scope.stageNameArr.push(stageName);
            //获取训练时长数组
            var stageTime = $(this).children().find('.stageTimeDiv').find('.stageTime').val();
            //$scope.stageTimeArr.push(stageTime);
            //获取训练内容数组
            var drillDiv = $(this).children().find('.drillDiv').find('.oneDrill');
            //console.log(drillDiv);
            $scope.drillArr = []; //动作和组数 数组
            $scope.oneActionArr = []; //获取单个阶段的动作数组
            drillDiv.each(function(i,item){
                var chooseSelect = $(this).children().find('.chooseSelect').val();
                //console.log(chooseSelect);
                var setNum = $(this).children().find('.setNum').val();
                if(chooseSelect != ''){
                    var data1 = {
                        action_id  : chooseSelect,
                        number : setNum
                    }
                }
                $scope.drillArr.push(data1);
                //获取动作总数组
                $scope.allActionArr.push(chooseSelect);

                //获取单个阶段的动作数组
                $scope.oneActionArr.push(chooseSelect);

            });
            var oneParam = {
                s_tiltle : stageName,
                length_time : stageTime,
                main : $scope.drillArr,
            };
            $scope.templateArr.push(oneParam);
            //获取所有阶段的动作数组
            $scope.totalActionArr.push($scope.oneActionArr);
        })

    };
    //验证每个阶段动作不能重复
    $scope.aaa = [];
    $scope.checkRepeat = function(){
        $scope.totalActionArr.map(function(item,i){
            console.log(item);
            var ary = item;
            var nary=ary.sort();
            for(var i=0;i<ary.length;i++){
                if (nary[i]==nary[i+1]){
                    $scope.aaa.push(0);
                }else{
                    $scope.aaa.push(-1);
                }
            }
        })
    };

    //模板保存按钮
    $scope.submitBtn = function(){
        $scope.getTemplateData();
        //console.log($scope.allActionArr);  //动作数组
        //console.log($scope.stageNameArr);  //阶段名称数组
        //console.log($scope.stageTimeArr);  //阶段时长数组
        //console.log($scope.templateArr);   //阶段数组
        console.log($scope.allActionArr);
        if($scope.fileName == '' ||$scope.fileName == undefined ){
            Message.warning('请输入模板名称');
            return
        }
        if($scope.fileName.length > 10 ){
            Message.warning('模板名称最多10位');
            return
        }
        if($scope.describe != undefined && $scope.describe.length > 30 ){
            Message.warning('模板描述最多30位');
            return
        }
        if($scope.stageNameArr.indexOf('') != -1){
            Message.warning('请输入阶段名称');
            return
        }

        if($scope.allActionArr.indexOf('') != -1){
            Message.warning('请选择动作');
            return
        }
        $scope.checkRepeat();
        //console.log($scope.aaa);
        if($scope.aaa.indexOf(0) != -1){
            Message.warning('每个阶段的动作不能重复');
            $scope.aaa = [];
            return
        }
        var dataParam = {
            title : $scope.fileName,     //名称
            describe : $scope.describe,  //描述
            plan : $scope.templateArr, //阶段数组
            cid : $scope.chooseType //分类
        };
        console.log(dataParam);
        $http({
            url : '/class-template/create-template',
            method : 'POST',
            data : $.param(dataParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                window.location.href = "/class-template/index";
            }else{
                Message.warning(result.data.mes.title[0]);
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
