/********
客户档案设置js
********/
angular.module('App').controller('fileSetCtrl',function($scope,$http,$timeout){
    $('.fileSelect').select2({
        width:'200px'
    });

    //体侧数据添加分类按钮
    $scope.addDatumBtn = function(){
        $('#addDatumModal').modal('show');
    };

    $scope.addDatumSuccess = function(){
        if($scope.datumName == '' || $scope.datumName == null){
            Message.warning('请输入名称');
            return
        }
        if($scope.datumName.length >6){
            Message.warning('最多输入6位');
            return
        }
        //添加分类参数
        var addDatumData = {
            title : $scope.datumName
        };
        $http({
            url : '/side-data/create',
            method : 'POST',
            data : $.param(addDatumData),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#addDatumModal').modal('hide');
                $scope.getDatumType();
                $timeout(function(){
                    $scope.datumInit();
                    $scope.getDatumList($('#datumSelect').val());
                },500);
            }else{
                Message.warning(result.data.mes.title[0]);
            }
        })
    };
    //添加分类模态框关闭
    $('#addDatumModal').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.datumName = '';
    });
    $scope.datumInit = function(){
        $('#datumSelect').val($scope.firstId);
        $scope.firstId = $scope.datumSelect;
        $('#select2-datumSelect-container').text($scope.firstTitle).attr('title',$scope.firstTitle)
    };
    //获取分类下拉框
    $scope.getDatumType = function(){
        $http.get('/side-data/top-list').success(function(result){
            //console.log(result);
            $scope.datumTypeList = result;
            if(result.length != 0){
                $scope.firstTitle = result[0].title;
                $scope.firstId = result[0].id;
            }else{
                $scope.firstTitle = '暂无数据';
            }

        })
    };
    $scope.getDatumType();
    //下拉框change事件
    $scope.datumSelectChange = function(id){
        //console.log(id);
        if(id != undefined){
            $scope.getDatumList(id);
        }
        $scope.datumId = id;
    };

    //修改分类名称
    $scope.updateDatumBtn = function(id,title){
        $('#updateDatumModal').modal('show');
        //console.log(id,title);
        $scope.updateDatumParentId = id;
        $scope.updateDatumName = title;
    };
    //修改分类模态框完成按钮
    $scope.updateParentBtn = function(){
        if($scope.updateDatumName == '' || $scope.updateDatumName == undefined){
            Message.warning('请输入名称');
            return
        }
        if($scope.updateDatumName.length >6){
            Message.warning('最多输入6位');
            return
        }
        var updateDatumParam = {
            title : $scope.updateDatumName
        };
        $http({
            url :'/side-data/update?id=' + $scope.updateDatumParentId,
            method :'POST',
            data : $.param(updateDatumParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#updateDatumModal').modal('hide');
                $scope.getDatumType();
                $timeout(function(){
                    $scope.datumInit();
                    $scope.getDatumList($('#datumSelect').val());
                },300)
            }else{
                Message.warning(result.data.mes.title[0]);
            }
        })
    };
    //获取体侧数据列表
    $scope.getDatumList = function(id){
        //$.loading.show();
        $http.get('/side-data/list?id=' + id).success(function(result){
            //console.log(result);
            $scope.datumParentList = result.father;
            if(result.child.length != 0){
                $scope.datumChildList = result.child;
                $scope.datumNoData = false;
            }else{
                $scope.datumChildList = result.child;
                $scope.datumNoData = true;
            }
            //$.loading.hide();
        });
    };
    $timeout(function(){
        $scope.datumInit();
        $scope.getDatumList($('#datumSelect').val());
    },500);

    //添加体侧数据子级分类按钮
    $scope.addDatumChildBtn = function(){
        $('#addDatumChildModal').modal('show');
    };
    //添加子类完成按钮
    $scope.addDatumChildSuccess = function(){
        if($scope.datumPro == '' || $scope.datumPro == undefined){
            Message.warning('请输入项目名称');
            return
        }
        if($scope.datumPro.length >6){
            Message.warning('最多输入6位');
            return
        }
        if(Number($scope.startInput) > Number($scope.endInput)){
            Message.warning('开始范围不能大于结束范围');
            return
        }
        if($scope.startInput != '' && $scope.startInput != undefined && ($scope.endInput == '' || $scope.endInput == undefined)){
            Message.warning('请输入完整的范围');
            return
        }
        if(($scope.startInput == '' || $scope.startInput == undefined) && $scope.endInput != '' && $scope.endInput != undefined){
            Message.warning('请输入完整的范围');
            return
        }
        if($scope.startInput != '' && $scope.startInput !=  undefined && $scope.endInput != '' && $scope.endInput != undefined){
            var datumRange = $scope.startInput + '-' + $scope.endInput;
        }else{
            var datumRange = ''
        }

        var addDatumChildData = {
            pid : $scope.datumParentList.id,
            title : $scope.datumPro,
            unit : $scope.datumUnit,
            normal_range : datumRange
        };
        $http({
            url : '/side-data/create',
            method : 'POST',
            data : $.param(addDatumChildData),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#addDatumChildModal').modal('hide');
                $scope.getDatumList($('#datumSelect').val());
            }else{
                Message.warning(result.data.mes.title[0]);
            }
        })
    };
    //添加子类模态框关闭事件
    $('#addDatumChildModal').on('hidden.bs.modal', function (e) {
        // do something...
        $scope.datumPro = '';
        $scope.datumUnit = '';
        $scope.startInput = '';
        $scope.endInput = '';
    });
    //修改子类事件
    $scope.updateDatumChild = function(id){
        $('#updateDatumChildModal').modal('show');
        $scope.datumChildId = id;
        $http.get('/side-data/detail?id=' + id).success(function(result){
            //console.log(result);
            $scope.updateDatumPro = result.title;
            $scope.updateDatumUnit = result.unit;
            if(result.normal_range == ''){
                $scope.updateStartInput = '';
                $scope.updateEndInput = '';
            }else{
                var str = result.normal_range.split("-");
                $scope.updateStartInput = str[0];
                $scope.updateEndInput = str[1];
            }

        })
    };
    //修改子类完成按钮
    $scope.updateDatumChildSuccess = function(){
        //console.log($scope.datumParentList.id);
        if($scope.updateDatumPro == '' || $scope.updateDatumPro == undefined){
            Message.warning('请输入项目名称');
            return
        }
        if($scope.updateDatumPro.length >6){
            Message.warning('最多输入6位');
            return
        }
        if(Number($scope.updateStartInput) > Number($scope.updateEndInput)){
            Message.warning('开始范围不能大于结束范围');
            return
        }
        if($scope.updateStartInput != '' && $scope.updateStartInput != undefined && ($scope.updateEndInput == '' || $scope.updateEndInput == undefined)){
            Message.warning('请输入完整的范围');
            return
        }
        if(($scope.updateStartInput == '' || $scope.updateStartInput == undefined) && $scope.updateEndInput != '' && $scope.updateEndInput != undefined){
            Message.warning('请输入完整的范围');
            return
        }
        if($scope.updateStartInput != '' && $scope.updateStartInput != undefined && $scope.updateEndInput != '' && $scope.updateEndInput != undefined){
            var updateDatumRange = $scope.updateStartInput + '-' + $scope.updateEndInput;
        }else{
            var updateDatumRange = ''
        }

        var updateDatumChildData = {
            pid : $scope.datumParentList.id,
            title : $scope.updateDatumPro,
            unit : $scope.updateDatumUnit,
            normal_range : updateDatumRange
        };
        $http({
            url : '/side-data/update?id=' + $scope.datumChildId,
            method : 'POST',
            data : $.param(updateDatumChildData),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#updateDatumChildModal').modal('hide');
                $scope.getDatumList($('#datumSelect').val());
            }else{
                Message.warning(result.data.mes.title[0]);
            }
        })

    };
    //子类详情按钮
    $scope.datumChildDetail = function(id){
        $('#datumChildDetailModal').modal('show');
        $http.get('/side-data/detail?id=' + id).success(function(result){
            //console.log(result);
            $scope.detailDatumPro = result.title;
            $scope.detailDatumUnit = result.unit;
            $scope.detailDatumRange = result.normal_range;
        })
    };
    //体侧数据 修改排序按钮
    $scope.showSortEnd = false;
    $scope.fileSortStart = function(){
        $("#fileSort" + $scope.datumParentList.id).sortable();
        $("#fileSort" + $scope.datumParentList.id).disableSelection();
        $('#fileSort' + $scope.datumParentList.id).bind('sortstop', function(event, ui) {
            // 数据有变化
            var oLi = $('#fileSort' + $scope.datumParentList.id).children('li');
            $scope.datumSortArr = [];
            oLi.each(function(i,item){
                //$scope.arr.push($(this).attr('name'));
                var sortIndex = $(this).attr('name');
                var sortId = $(this).attr('value');
                var sortData = {
                    id : sortId,
                    sort : sortIndex
                };
                $scope.datumSortArr.push(sortData);
            });
        });
        $scope.showSortEnd = true;
    };
    //取消排序
    $scope.cancelFileSort = function(){
        $scope.getDatumList($('#datumSelect').val());
        $scope.showSortEnd = false;
        $("#fileSort" + $scope.datumParentList.id).sortable('destroy');
    };

    //体侧数据 排序保存按钮
    $scope.fileSortEnd = function(){
        if($scope.datumSortArr == undefined){
            Message.warning('请先进行排序');
            return
        }else{
            //console.log($scope.datumSortArr);
            var datumSortParam = {
                sort :   $scope.datumSortArr
            };
            $http({
                url : '/side-data/sort',
                method : 'POST',
                data : $.param(datumSortParam),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).then(function(result){
                //console.log(result);
                if(result.data.status == 'success'){
                    Message.success(result.data.mes);
                    $scope.getDatumList($('#datumSelect').val());
                }else{
                    Message.warning(result.data.mes.title[0]);
                }
            });
            $scope.showSortEnd = false;
            $("#fileSort" + $scope.datumParentList.id).sortable('destroy');
        }


    };
    //删除项目组按钮
    $scope.deleteDatumBtn = function(id){
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
                $http.get('/side-data/delete?id=' + id).success(function(result){
                    //console.log(result);
                    if(result.status == 'success'){
                        swal(result.mes,'','success');
                        $scope.getDatumType();
                        $timeout(function(){
                            swal.close();
                            $scope.datumInit();
                            $scope.getDatumList($('#datumSelect').val());
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
    $scope.deleteDatumChild = function(id){
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
                $http.get('/side-data/delete?id=' + id).success(function(result){
                    console.log(result);
                    if(result.status == 'success'){
                        swal(result.mes,'','success');
                        $timeout(function(){
                            swal.close();
                        },300);
                        $scope.getDatumList($('#datumSelect').val());
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