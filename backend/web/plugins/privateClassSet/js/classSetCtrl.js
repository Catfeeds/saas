/********
 课程内容设置js
 ********/
angular.module('App').controller('classSetCtrl',function ($scope,$http,$timeout) {
    $('#chooseClass').select2({
        width:'200px'
    });
    $('#updateChooseClass').select2({
        width:'200px'
    });
    $('.selectStyle').select2({
        width:'180px'
    });
    //搜索参数
    $scope.searchParam = function(){
        return {
            keyword : $scope.classKeywords && $scope.classKeywords  != '' ? $scope.classKeywords : null,
        }
    };
    //初始化路径
    $scope.initPath = function(){
        $scope.initUrl = '/private-class-set/list?' + $.param($scope.searchParam())
    };
    $scope.initPath();
    //获取课程询问列表
    $scope.getClassSet = function(){
        $.loading.show();
        $http.get($scope.initUrl).success(function(result){
            //console.log(result);
            if(result.data.length != 0){
                $scope.classSetList = result.data;
                $scope.classSetNoData = false;
                $scope.classSetPage = result.pages;
            }else{
                $scope.classSetList = result.data;
                $scope.classSetNoData = true;
                $scope.classSetPage = result.pages;
            }
            $.loading.hide();
        })
    };
    $scope.getClassSet();
    //搜索按钮事件
    $scope.classSearchBtn = function(){
        $scope.initPath();
        $scope.getClassSet();
    };
    //键盘搜索
    $scope.classEnterSearch = function(){
        var event = window.event || arguments.callee.caller.arguments[0];
        if (event.keyCode == 13) {
            $scope.classSearchBtn();
        }
    };
    //清除按钮
    $scope.classClearBtn = function(){
        $scope.classKeywords = '';
        $scope.initPath();
        $scope.getClassSet();
    };

    //添加内容事件
    $scope.addClassSet = function(){
        $('#addClassSetModal').modal('show');
    };
    //模态框显示执行的事件
    $('#addClassSetModal').on('shown.bs.modal', function () {
        //获取课种
        $scope.getCourse();
        //$scope.addChoice();
        $scope.addMain();
    });
    //添加选项按钮
    $scope.choiceNum = 0;
    $scope.addChoice = function(){
        $scope.choiceNum ++;
        $scope.htmlAttr = 'addChoice';
        $.loading.show();
        $http.get('/private-class-set/add-template?attr='+$scope.htmlAttr + '&num=' + $scope.choiceNum).then(function (result) {
            $scope.choiceHtml = result.data.html;
            $.loading.hide();
        });
    };

    //添加内容按钮
    $scope.mainNum = 0;
    $scope.addMain = function(){
        $scope.mainNum ++;
        $scope.htmlAttr = 'addMain';
        $.loading.show();
        $http.get('/private-class-set/add-template?attr='+$scope.htmlAttr + '&num=' + $scope.mainNum).then(function (result) {
            $scope.mainHtml = result.data.html;
            $scope.addChoice();
            $('.selectStyle').select2({
                width:'180px'
            });
            $.loading.hide();
        });
    };

    //获取课种
    $scope.getCourse = function(){
        $http.get('/rechargeable-card-ctrl/get-private-data').success(function(result){
            //console.log(result);
            $scope.courseList = result.venue;
        })
    };
    //获取选项数据
    $scope.getChoice = function(){
        var modalMain = $('#addModalMain').children('.modalMainDiv').children('.modalMain');
        //console.log(modalMain);
        $scope.mainArr = []; //内容数组
        $scope.typeArr = []; //类别数组
        $scope.questionArr = [];//问题数组
        modalMain.each(function(i,item){
            //console.log(item);
            var chooseSelect = $(this).children().find('.chooseSelect').val(); //类别
            $scope.typeArr.push(chooseSelect);
            var question = $(this).children().find('.question').val();         //问题
            $scope.questionArr.push(question);
            var choice = $(this).children('.choiceDiv').find('.choice');
            $scope.choiceArr = [];
            choice.each(function(i,item){
                var choiceInput = $(this).children().find('.choiceInput').val();
                $scope.choiceArr.push(choiceInput);
                //console.log($scope.choiceArr);
            });
            var addData = {
                type : chooseSelect,      //选项类别
                title :question,          //问题
                option : $scope.choiceArr //选项
            };
            //console.log(data);
            $scope.mainArr.push(addData);
        })
    };
    //获取所有问题和选项
    $scope.checkChoice = [];
    $scope.checkChoiceL = [];
    $scope.checkQuestion = [];
    $scope.checkQuestionL = [];
    $scope.getAllChoice = function(){
        var allChoice = $('#addModalMain').find('.choiceInput');
        allChoice.each(function(i,item){
            $scope.checkChoice.push($(this).val().length);
            if($(this).val().length > 6){
                $scope.checkChoiceL.push(-1);
            }else{
                $scope.checkChoiceL.push(1);
            }
        });
        var allQuestion = $('#addModalMain').find('.question');
        allQuestion.each(function(i,item){
            //$scope.checkQuestion.push($(this).val().length);
            if($(this).val().length > 30){
                $scope.checkQuestionL.push(-1);
            }else{
                $scope.checkQuestionL.push(1);
            }
        });

    };
    //添加模态框完成按钮
    $scope.addSuccessBtn = function(){
        $scope.getChoice();
        $scope.getAllChoice();
        //console.log($scope.checkChoice);
        //console.log($scope.checkChoiceL);
        //console.log($scope.mainArr);
        //console.log($scope.checkQuestion);
        //console.log($scope.checkQuestionL)
        if($scope.chooseClass == '' || $scope.chooseClass == undefined){
            Message.warning('请选择课种');
            return
        }
        if($scope.typeArr.indexOf('') != -1){
            Message.warning('请选择类别');
            return
        }
        if($scope.questionArr.indexOf('') != -1){
            Message.warning('请输入问题');
            return
        }
        // if($scope.choiceArr.indexOf('') != -1){
        //     Message.warning('请输入选项');
        //     return
        // }
        // if($scope.checkQuestion.indexOf(0) != -1){
        //     Message.warning('请输入问题');
        //     $scope.checkQuestion = [];
        //     return
        // }
        if($scope.checkQuestionL.indexOf(-1) != -1){
            Message.warning('问题不能超过30个字');
            $scope.checkQuestionL = [];
            return
        }
        if($scope.checkChoice.indexOf(0) != -1){
            Message.warning('请输入选项');
            $scope.checkChoice = [];
            return
        }
        if($scope.checkChoiceL.indexOf(-1) != -1){
            Message.warning('选项不能超过6个字');
            $scope.checkChoiceL = [];
            return
        }

        var addClassParam = {
            course_id : $scope.chooseClass, //课种id
            main : $scope.mainArr          //内容数组
        };
        //console.log(addClassParam);
        $http({
            url : '/private-class-set/create',
            method :'POST',
            data : $.param(addClassParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#addClassSetModal').modal('hide');
                $scope.getClassSet();
            }else{
                Message.warning(result.data.mes);
            }
        })
    };
    //添加内容模态框关闭事件
    $('#addClassSetModal').on('hidden.bs.modal', function () {
        $scope.chooseClass = '';
        $scope.chooseType = '';
        $('#addClassSetModal').find('.select2-selection__rendered').text('请选择').attr('title','请选择');
        $('.question').val('');
        $('.choiceInput').val('');
        $('.removeMainDiv').hide();
    });
    /*************修改事件**************/
    //修改按钮
    $scope.updateBtn = function(id){
        $('#updateClassSetModal').modal('show');
        $scope.getOneUpdate(id);
        $scope.updateClassId = id;
    };
    //获取课种
    $scope.getUpdateCourse = function(){
        $http.get('/rechargeable-card-ctrl/get-private-data').success(function(result){
            //console.log(result);
            $scope.updateCourseList = result.venue;
        })
    };
    $scope.getUpdateCourse();
    //获取修改前的数据
    $scope.getOneUpdate = function(id) {
        $.loading.show();
        $http.get('/private-class-set/detail?id=' + id).success(function(result){
            //console.log(result);
            $scope.updateChooseClass = result.id;
            $('#select2-updateChooseClass-container').text(result.name).attr('title',result.name);
            $scope.updateQuestion = result.questions;
            $scope.updateBeforeTypeArr = [];    //类别数组
            $scope.updateQuestion.map(function(item,i){
                //console.log(item);
                $scope.updateBeforeTypeArr.push(item.type);
            });
            $timeout(function(){
                $scope.showBeforeType();
            },300);
            $.loading.hide();
        })
    };
    $('#updateClassSetModal').on('shown.bs.modal', function () {
        $('.updateSelect').select2({

        })
    });
    //修改前的类别展示
    $scope.showBeforeType = function(){
        $scope.updateBeforeTypeArr.map(function(item,i){
            //$('.chooseSelect').val(item);
            $scope.oneType = item;
            $('.updateSelect').eq(i).val($scope.oneType).trigger("change");
        });
    };
    //获取修改完成后的数据
    $scope.getUpdateData = function(){
        var modalMain = $('#updateModalMain').children('.modalMainDiv').children('.modalMain');
        //console.log(modalMain);
        $scope.updateMainArr = []; //内容数组
        $scope.updateTypeArr = []; //类别数组
        $scope.updateQuestionArr = [];//问题数组
        modalMain.each(function(i,item){
            //console.log(item);
            var chooseSelect = $(this).children().find('.chooseSelect').val(); //类别
            $scope.updateTypeArr.push(chooseSelect);
            var question = $(this).children().find('.question').val();         //问题
            $scope.updateQuestionArr.push(question);
            var choice = $(this).children('.choiceDiv').find('.choice');
            $scope.updateChoiceArr = [];
            choice.each(function(i,item){
                var choiceInput = $(this).children().find('.choiceInput').val();
                $scope.updateChoiceArr.push(choiceInput);
                //console.log($scope.choiceArr);
            });
            var data = {
                type : chooseSelect,
                title :question,
                option : $scope.updateChoiceArr
            };
            //console.log(data);
            $scope.updateMainArr.push(data);
        })
    };
    //获取所有问题和选项
    $scope.checkUpdateChoice = [];
    $scope.checkUpdateChoiceL = [];
    $scope.checkUpdateQuestion = [];
    $scope.checkUpdateQuestionL = [];
    $scope.getUpdateAll = function(){
        var allChoice1 = $('#updateModalMain').find('.choiceInput');
        allChoice1.each(function(i,item){
            $scope.checkUpdateChoice.push($(this).val().length);
            if($(this).val().length > 6){
                $scope.checkUpdateChoiceL.push(-1);
            }else{
                $scope.checkUpdateChoiceL.push(1);
            }
        });
        var allQuestion1 = $('#updateModalMain').find('.question');
        allQuestion1.each(function(i,item){
            //$scope.checkUpdateQuestion.push($(this).val().length);
            if($(this).val().length > 30){
                $scope.checkUpdateQuestionL.push(-1);
            }else{
                $scope.checkUpdateQuestionL.push(1);
            }
        });

    };
    //修改模态框完成按钮
    $scope.updateSuccessBtn = function(){
        $scope.getUpdateData();
        $scope.getUpdateAll();
        //console.log($scope.checkUpdateQuestion)
        if($scope.updateChooseClass == '' || $scope.updateChooseClass == undefined){
            Message.warning('请选择课种');
            return
        }
        if($scope.updateTypeArr.indexOf('') != -1){
            Message.warning('请选择类别');
            return
        }
        if($scope.updateQuestionArr.indexOf('') != -1){
            Message.warning('请输入问题');
            return
        }
        // if($scope.updateChoiceArr.indexOf('') != -1){
        //     Message.warning('请输入选项');
        //     return
        // }
        // if($scope.checkUpdateQuestion.indexOf(0) != -1){
        //     Message.warning('请输入问题');
        //     $scope.checkUpdateQuestion = [];
        //     return
        // }
        if($scope.checkUpdateQuestionL.indexOf(-1) != -1){
            Message.warning('问题不能超过30个字');
            $scope.checkUpdateQuestionL = [];
            return
        }
        if($scope.checkUpdateChoice.indexOf(0) != -1){
            Message.warning('请输入选项');
            $scope.checkUpdateChoice = [];
            return
        }
        if($scope.checkUpdateChoiceL.indexOf(-1) != -1){
            Message.warning('选项不能超过6个字');
            $scope.checkUpdateChoiceL = [];
            return
        }

        var updateClassParam = {
            course_id : $scope.updateChooseClass,
            main : $scope.updateMainArr
        };
        //console.log(updateClassParam);
        $http({
            url : '/private-class-set/update?id=' + $scope.updateClassId,
            method :'POST',
            data : $.param(updateClassParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#updateClassSetModal').modal('hide');
                $scope.getClassSet();
            }else{
                Message.warning(result.data.mes);
            }
        })

    };
    $('#updateClassSetModal').on('hidden.bs.modal', function () {
        $('.updateModalNew').hide();
    });
    /*************详情事件**************/
    //详情按钮
    $scope.detailBtn = function(id){
        $('#classDetailModal').modal('show');
        $scope.classDetailId = id;
        $scope.getOneDetail($scope.classDetailId);
    };
    //获取详情数据
    $scope.getOneDetail = function(id) {
        $.loading.show();
        $http.get('/private-class-set/detail?id=' + id).success(function(result){
            //console.log(result);
            $scope.detailName = result.name;
            $scope.detailQuestion = result.questions;
            $.loading.hide();
        })
    };
    //详情模态框修改按钮
    $scope.modalUpdateBtn = function(){
        $('#classDetailModal').modal('hide');
        //$('#updateClassSetModal').modal('show');
        //$scope.getOneUpdate($scope.classDetailId);
        $scope.updateBtn($scope.classDetailId);
    };

    /*************删除事件**************/
    //删除按钮
    $scope.deleteOneBtn = function(id){
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
                $http.get('/private-class-set/delete?id=' + id).success(function(result){
                    //console.log(result);
                    if(result.status == 'success'){
                        swal(result.mes,'','success');
                        $timeout(function(){
                            swal.close();
                        },300);
                        $scope.getClassSet();
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