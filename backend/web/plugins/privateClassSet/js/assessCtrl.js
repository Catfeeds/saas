/********
客户档案设置js
********/
angular.module('App').controller('assessCtrl',function($scope,$http,$timeout){
    $('.fileSelect').select2({
        width:'200px'
    });

    //体侧数据添加分类按钮
    $scope.addAssessBtn = function(){
        $('#addAssessModal').modal('show');
    };

    $scope.addAssessSuccess = function(){
        if($scope.assessName == '' || $scope.assessName == null){
            Message.warning('请输入名称');
            return
        }
        if($scope.assessName.length > 6){
            Message.warning('最多输入6位');
            return
        }
        //添加分类参数
        var addAssessData = {
            title : $scope.assessName
        };
        $http({
            url : '/fitness-assessment/create',
            method : 'POST',
            data : $.param(addAssessData),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#addAssessModal').modal('hide');
                $scope.getAssessType();
                $timeout(function(){
                    $scope.assessInit();
                    $scope.getAssessList($('#assessSelect').val());
                },500);
            }else{
                Message.warning(result.data.mes.title[0]);
            }
        })
    };
    //添加分类模态框关闭
    $('#addAssessModal').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.assessName = '';
    });
    $scope.assessInit = function(){
        $('#assessSelect').val($scope.assessFirstId);
        $scope.assessFirstId = $scope.assessSelect;
        $('#select2-assessSelect-container').text($scope.assessFirstTitle).attr('title',$scope.assessFirstTitle)
    };
    //获取分类下拉框
    $scope.getAssessType = function(){
        $http.get('/fitness-assessment/top-list').success(function(result){
            //console.log(result);
            $scope.assessTypeList = result;
            if(result.length != 0){
                $scope.assessFirstTitle = result[0].title;
                $scope.assessFirstId = result[0].id;
            }else{
                $scope.assessFirstTitle = '暂无数据';
            }

        })
    };
    $scope.getAssessType();
    //下拉框change事件
    $scope.assessSelectChange = function(id){
        //console.log(id);
        if(id != undefined){
            $scope.getAssessList(id);
        }
        $scope.assessId = id;
    };

    //修改分类名称
    $scope.updateAssessBtn = function(id,title){
        $('#updateAssessModal').modal('show');
        //console.log(id,title);
        $scope.updateAssessParentId = id;
        $scope.updateAssessName = title;
    };
    //修改分类模态框完成按钮
    $scope.updateAssessParentBtn = function(){
        if($scope.updateAssessName == '' || $scope.updateAssessName == undefined){
            Message.warning('请输入名称');
            return
        }
        if($scope.updateAssessName.length > 6){
            Message.warning('最多输入6位');
            return
        }
        var updateAssessParam = {
            title : $scope.updateAssessName
        };
        $http({
            url :'/fitness-assessment/update?id=' + $scope.updateAssessParentId,
            method :'POST',
            data : $.param(updateAssessParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#updateAssessModal').modal('hide');
                $scope.getAssessType();
                $timeout(function(){
                    $scope.assessInit();
                    $scope.getAssessList($('#assessSelect').val());
                },300)
            }else{
                Message.warning(result.data.mes.title[0]);
            }
        })
    };
    //获取体侧数据列表
    $scope.getAssessList = function(id){
        //$.loading.show();
        $http.get('/fitness-assessment/list?id=' + id).success(function(result){
            //console.log(result);
            $scope.assessParentList = result.father;
            if(result.child.length != 0){
                $scope.assessChildList = result.child;
                $scope.assessNoData = false;
            }else{
                $scope.assessChildList = result.child;
                $scope.assessNoData = true;
            }
            //$.loading.hide();
        });
    };
    $timeout(function(){
        $scope.assessInit();
        $scope.getAssessList($('#assessSelect').val());
    },500);

    //添加体侧数据子级分类按钮
    $scope.addAssessChildBtn = function(){
        $('#addAssessChildModal').modal('show');
    };
    //添加子类完成按钮
    $scope.addAssessChildSuccess = function(){
        if($scope.assessPro == '' || $scope.assessPro == undefined){
            Message.warning('请输入项目名称');
            return
        }
        if($scope.assessPro.length > 6){
            Message.warning('最多输入6位');
            return
        }
        if(Number($scope.startAssessInput) > Number($scope.endAssessInput)){
            Message.warning('开始范围不能大于结束范围');
            return
        }
        if($scope.startAssessInput != '' && $scope.startAssessInput != undefined && ($scope.endAssessInput == '' || $scope.endAssessInput == undefined)){
            Message.warning('请输入完整的范围');
            return
        }
        if(($scope.startAssessInput == '' || $scope.startAssessInput == undefined) && $scope.endAssessInput != '' && $scope.endAssessInput != undefined){
            Message.warning('请输入完整的范围');
            return
        }
        if($scope.startAssessInput != '' && $scope.assessPro != undefined && $scope.endAssessInput != '' && $scope.endAssessInput != undefined){
            var assessRange = $scope.startAssessInput + '-' + $scope.endAssessInput;
        }else{
            var assessRange = ''
        }

        var addAssessChildData = {
            pid : $scope.assessParentList.id,
            title : $scope.assessPro,
            unit : $scope.assessUnit,
            normal_range : assessRange
        };
        //console.log(addAssessChildData);
        $http({
            url : '/fitness-assessment/create',
            method : 'POST',
            data : $.param(addAssessChildData),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#addAssessChildModal').modal('hide');
                $scope.getAssessList($('#assessSelect').val());
            }else{
                Message.warning(result.data.mes.title[0]);
            }
        })
    };
    //添加子类模态框关闭事件
    $('#addAssessChildModal').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.assessPro = '';
        $scope.assessUnit = '';
        $scope.startAssessInput = '';
        $scope.endAssessInput = '';
    });
    //修改子类事件
    $scope.updateAssessChild = function(id){
        $('#updateAssessChildModal').modal('show');
        $scope.assessChildId = id;
        $http.get('/fitness-assessment/detail?id=' + id).success(function(result){
            //console.log(result);
            $scope.updateAssessPro = result.title;
            $scope.updateAssessUnit = result.unit;
            if(result.normal_range == ''){
                $scope.updateAssessStart = '';
                $scope.updateAssessEnd = '';
            }else{
                var str = result.normal_range.split("-");
                $scope.updateAssessStart = str[0];
                $scope.updateAssessEnd = str[1];
            }
        })
    };
    //修改子类完成按钮
    $scope.updateAssessChildSuccess = function(){
        //console.log($scope.assessParentList.id);
        if($scope.updateAssessPro == '' || $scope.updateAssessPro == undefined){
            Message.warning('请输入项目名称');
            return
        }
        if($scope.updateAssessPro.length > 6){
            Message.warning('最多输入6位');
            return
        }
        if(Number($scope.updateAssessStart) > Number($scope.updateAssessEnd)){
            Message.warning('开始范围不能大于结束范围');
            return
        }
        if($scope.updateAssessStart != '' && $scope.updateAssessStart != undefined && ($scope.updateAssessEnd == '' || $scope.updateAssessEnd == undefined)){
            Message.warning('请输入完整的范围');
            return
        }
        if(($scope.updateAssessStart == '' || $scope.updateAssessStart == undefined) && $scope.updateAssessEnd != '' && $scope.updateAssessEnd != undefined){
            Message.warning('请输入完整的范围');
            return
        }
        if($scope.updateAssessStart != '' && $scope.updateAssessStart != undefined && $scope.updateAssessEnd != '' && $scope.updateAssessEnd != undefined){
            var upadteAssessRange = $scope.updateAssessStart + '-' + $scope.updateAssessEnd;
        }else{
            var upadteAssessRange = ''
        }

        var updateAssessChildData = {
            pid : $scope.assessParentList.id,
            title : $scope.updateAssessPro,
            unit : $scope.updateAssessUnit,
            normal_range : upadteAssessRange
        };
        $http({
            url : '/fitness-assessment/update?id=' + $scope.assessChildId,
            method : 'POST',
            data : $.param(updateAssessChildData),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#updateAssessChildModal').modal('hide');
                $scope.getAssessList($('#assessSelect').val());
            }else{
                Message.warning(result.data.mes.title[0]);
            }
        })

    };
    //子类详情按钮
    $scope.assessChildDetail = function(id){
        $('#assessChildDetailModal').modal('show');
        $http.get('/fitness-assessment/detail?id=' + id).success(function(result){
            //console.log(result);
            $scope.detailAssessPro = result.title;
            $scope.detailAssessUnit = result.unit;
            $scope.detailAssessRange = result.normal_range;
        })
    };
    //体侧数据 修改排序按钮
    $scope.showAssessSort = false;
    $scope.assessSortStart = function(){
        $("#sortable" + $scope.assessParentList.id).sortable();
        $("#sortable" + $scope.assessParentList.id).disableSelection();
        $('#sortable' + $scope.assessParentList.id).bind('sortstop', function(event, ui) {
            // 数据有变化
            var oLi = $('#sortable' + $scope.assessParentList.id).children('li');
            $scope.assessSortArr = [];
            oLi.each(function(i,item){
                //$scope.arr.push($(this).attr('name'));
                var sortIndex = $(this).attr('name');
                var sortId = $(this).attr('value');
                var sortData = {
                    id : sortId,
                    sort : sortIndex
                };
                $scope.assessSortArr.push(sortData);
            });
        });
        $scope.showAssessSort = true;
    };
    //取消排序
    $scope.cancelAssessSort = function(){
        $scope.getAssessList($('#assessSelect').val());
        $scope.showAssessSort = false;
        $("#sortable" + $scope.assessParentList.id).sortable('destroy');
    };

    //体侧数据 排序保存按钮
    $scope.assessSortEnd = function(){
        if($scope.assessSortArr == undefined){
            Message.warning('请先进行排序');
            return
        }else{
            //console.log($scope.assessSortArr);
            var assessSortParam = {
                sort :   $scope.assessSortArr
            };
            $http({
                url : '/fitness-assessment/sort',
                method : 'POST',
                data : $.param(assessSortParam),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function(result){
                //console.log(result);
                if(result.data.status == 'success'){
                    Message.success(result.data.mes);
                    $scope.getAssessList($('#assessSelect').val());
                }else{
                    Message.warning(result.data.mes.title[0]);
                }
            });
            $scope.showAssessSort = false;
            $("#sortable" + $scope.assessParentList.id).sortable('destroy');
        }

    };
    //删除项目组按钮
    $scope.deleteAssessBtn = function(id){
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
                $http.get('/fitness-assessment/delete?id=' + id).success(function(result){
                    //console.log(result);
                    if(result.status == 'success'){
                        swal(result.mes,'','success');
                        $scope.getAssessType();
                        $timeout(function(){
                            swal.close();
                            $scope.assessInit();
                            $scope.getAssessList($('#assessSelect').val());
                        },500);
                    }else{
                        swal(result.mes,'','error');
                    }
                })
            } else {
                swal.close();
            }
        });
    };
    //删除单个项目
    $scope.deleteAssessChild = function(id){
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
                $http.get('/fitness-assessment/delete?id=' + id).success(function(result){
                    //console.log(result);
                    if(result.status == 'success'){
                        swal(result.mes,'','success');
                        $timeout(function(){
                            swal.close();
                        },300);
                        $scope.getAssessList($('#assessSelect').val());
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