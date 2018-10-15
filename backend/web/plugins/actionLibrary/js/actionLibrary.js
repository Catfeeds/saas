$(function(){
    function useDatePicker(dom) {
        dom.datetimepicker({
            minView: "month",//设置只显示到月份
            format: 'yyyy-mm-dd',
            language: 'zh-CN',
            autoclose: true,
            todayBtn: true//今日按钮
        });
    };
    useDatePicker($(".startTime"));
    useDatePicker($(".endTime"));
    $('#actionDate').daterangepicker(null, function(start, end, label) {

    });
});
angular.module('App').controller('actionLibraryCtrl',function($scope,$http,$sce){
    //类型
    $('.typeList li').click(function(e){
        if(!$(this).hasClass('activeLi')){
            $(this).addClass('activeLi').siblings().removeClass('activeLi');
            console.log(e.target.getAttribute('value'));
            $scope.typeValue = e.target.getAttribute('value');
        }else{
            $(this).removeClass('activeLi');
            $scope.typeValue = '';
        }
    });
    /*$scope.aaa = ['111','222','333','444','555'];*/

    // $scope.bbb = function(index,e){
    //     //console.log(e.target.getAttribute('name'))
    //     $scope.color = index;
    //     $scope.ccc = e.target.getAttribute('name');
    //     //console.log($scope.ccc)
    // };
    $scope.getLeftMenu = function(){
        $http.get('/action-category/get-all-category').success(function(result){
            //console.log(result);
            $scope.leftMenuList = result;
        })
    };
    $scope.getLeftMenu();
    $scope.ccc = function(index,e){
        //$scope.getClickId()
        //console.log(e.target.getAttribute('value'));
        //console.log($('.li' + index))
        //$(e.target).removeClass('activeLi')
        if(!$(e.target).hasClass('activeLi')){
            $(e.target).parent().children('li').removeClass('activeLi');
            $(e.target).addClass('activeLi');

        }else{
            $(e.target).removeClass('activeLi');
        }
        //console.log($('.li' + index).parent().eq(index))
        //console.log(this)
        //console.log(e.currentTarget)
        //e.target.classList.toggle('activeLi');
        // if (!$(e.target).hasClass('.activeLi')) {
        // }
        //console.log($scope.ccc)
    };

    $scope.getClickId = function(){
        var clickLi = $('.clickDiv').children('ul').find('.activeLi');
        //console.log(clickLi);
        $scope.clickIdArr = [];
        clickLi.each(function(i,item){
            $scope.clickIdArr.push(item.getAttribute('value'));
            //console.log($scope.clickIdArr);
        })
    };

    //清空筛选事件
    $scope.clearFilterBtn = function(){
        //清除日期
        $('#actionDate').val('');
        $scope.creatStartDate = '';
        $scope.creatEndDate = '';
        //清除选中状态
        $('.typeList').children('li').removeClass('activeLi');
        $scope.typeValue = '';
        $('.clickDiv').children('ul').find('.activeLi').removeClass('activeLi');
        $scope.getClickId();
        $scope.searchKeywords = '';
        $scope.initUrl = '/action-library/list?' + $.param( $scope.searchParam());
        $scope.getActionData();
    };
    //初始化获取当月的第一天和最后一天
    $scope.getMonthOneAndMonthLast = function(){
        var date = new Date();
        $scope.greatStartDate =$scope.getMyDate(date.setDate(1));
        var currentMonth=date.getMonth();
        var nextMonth=++currentMonth;
        var nextMonthFirstDay=new Date(date.getFullYear(),nextMonth,1);
        var oneDay=1000*60*60*24;
        $scope.greatEndDate = $scope.getMyDate(nextMonthFirstDay-oneDay);
        $('#actionDate').val($scope.greatStartDate+' - '+ $scope.greatEndDate);
    };
    //时间戳转换为年月日
    $scope.getMyDate = function(str){
        str = parseInt(str);
        if(str!=""||str!=null){
            var oDate = new Date(str);
            var oYear = oDate.getFullYear();
            var oMonth = oDate.getMonth()+1;
            oMonth = oMonth>=10? oMonth:'0'+oMonth;
            var oDay = oDate.getDate();
            oDay = oDay>=10? oDay:'0'+oDay;
            var theDate = oYear+"-"+oMonth+"-"+oDay;
        }else{
            theDate = "";
        }
        return theDate
    };
    $scope.getMonthOneAndMonthLast();
    //日期事件
    $scope.dateInit = function(){
        $scope.creatStartDate = '';
        $scope.creatEndDate = '';
        if($("#actionDate").val() != ''){
            var startTime = $("#actionDate").val().substr(0, 10);
            $scope.creatStartDate = startTime+' '+ "00:00:00";
            var endTime = $("#actionDate").val().substr(-10, 10);
            $scope.creatEndDate  = endTime+' '+"23:59:59";
        }
    };
    $('#actionDate').on('apply.daterangepicker', function(ev, picker){
        $scope.dateInit();
        //console.log($('#actionDate').val());
        console.log( $scope.creatStartDate,$scope.creatEndDate)
    });
    //搜索参数
    $scope.searchParam = function(){
        return {
            start_at : $scope.creatStartDate,
            end_at   : $scope.creatEndDate,
            type : $scope.typeValue,
            category_id : $scope.clickIdArr,
            title : $scope.searchKeywords != undefined && $scope.searchKeywords != '' ? $scope.searchKeywords : null,
        }
    };
    //获取列表
    $scope.initUrl = '/action-library/list';
    $scope.getActionData = function(){
        $.loading.show();
        $http.get($scope.initUrl).success(function(result){
            //console.log(result);
            if(result.data.length != 0){
                $scope.actionList = result.data;
                $scope.actionNoData = false;
                $scope.actionPage = result.pages;
            }else{
                $scope.actionList = result.data;
                $scope.actionNoData = true;
                $scope.actionPage = result.pages;
            }
            $.loading.hide();
            $('.memberChooseTransfer').children().prop('checked','');
            $('.chooseOnePage').prop('checked','');
            $('.chooseOnePage').siblings().text('选择本页');
        })
    };
    $scope.getActionData();
    //分页
    $scope.replacementPages = function(url){
        $scope.initUrl = url;
        $scope.getActionData();
    };
    //确认筛选
    $scope.sureFilterBtn = function(){
        $scope.getClickId();
        $scope.initUrl = '/action-library/list?' + $.param( $scope.searchParam());
        $scope.getActionData();
    };
    //搜索按钮事件
    $scope.searchBtn = function(){
        $scope.getClickId();
        $scope.initUrl = '/action-library/list?' + $.param( $scope.searchParam());
        $scope.getActionData();
    };
    //回车搜索触发
    $scope.enterSearch = function (){
        var event = window.event || arguments.callee.caller.arguments[0];
        if (event.keyCode == 13) {
            $scope.searchBtn();
        }
    };
    //清除按钮事件
    $scope.clearBtn = function(){
        $scope.clearFilterBtn();
        // $scope.searchKeywords = '';
        // $scope.initUrl = '/action-library/list?' + $.param( $scope.searchParam());
        // $scope.getActionData();
    };
    //转换为可信任的video链接
    $scope.videoUrl = function(url){
        return $sce.trustAsResourceUrl(url);
    };
    //详情
    $scope.detailBtn = function(id){
        $.loading.show();
        $('#actionDetailModal').modal('show');
        $scope.detailId = id;
        $http.get('/action-library/get-one-detail?id=' + id).success(function(result){
            //console.log(result);
            $scope.detailTitle = result.data.title; //名称
            $scope.detailType  = result.data.type;  //类型
            $scope.detailUnit  = result.data.unit;  //单位
            $scope.detailEnergy = result.data.energy;//热量消耗
            $scope.detailCategory = result.data.categorys;//分类
            $scope.detailSsentials = result.data.ssentials;//动作要领
            $scope.detailImages = result.data.images; //正确照片和错误照片
            $scope.detailVideoUrl    = result.data.video;
            //判断错误示范  暂无数据是否显示
            $scope.imgTypeArr = [];
            $scope.detailImages.map(function(item,i){
                $scope.imgTypeArr.push(item.type);
                if($scope.imgTypeArr.indexOf('2') == -1){
                    $scope.noDataText2 = true;
                }else{
                    $scope.noDataText2 = false;
                }
                if($scope.imgTypeArr.indexOf('1') == -1){
                    $scope.noDataText = true;
                }else{
                    $scope.noDataText = false;
                }
            });
            $.loading.hide();
        });
    };
    //模态框详情修改按钮
    $scope.updateOneBtn = function(){
        window.location.href = "/action-library/update-action?updateId=" +  $scope.detailId;
    };
    //修改分类
    //获取分类
    $scope.getModalMenu = function(){
        $http.get('/action-category/get-all-category').success(function(result){
            $scope.modalMenuList = result;
        })
    };
    $scope.updateTypeBtn = function(id,object){
        $.loading.show();
        $('#updateTypeModal').modal('show');
        //console.log(object);
        $scope.object = object;
        $scope.getModalMenu();
        $scope.updateOneTypeId = id;
    };
    $('#updateTypeModal').on('shown.bs.modal', function () {
        $.loading.hide();
        var updateTypeData = $scope.object.categorys;
        //console.log(updateTypeData);
        $scope.typeIdArr = [];
        updateTypeData.map(function(item,i){
            //console.log(item.id);
            $scope.typeIdArr.push(item.id);
        });
        var selectAll =  $('.selectModal');
        //console.log(selectAll)
        selectAll.each(function(i,item){
            //console.log(item)
            $(this).children('.chooseSelect').val($scope.typeIdArr);
        });
        $scope.bbb();
    });
    $scope.bbb = function(){
        var selectAll1 =  $('.selectModal');
        //console.log(selectAll1);
        selectAll1.each(function(i,item){
            //console.log($(this).children('.chooseSelect').val());
            if($(this).children('.chooseSelect').val() == null){
                //console.log($(this))
                //$(this).parent().css('display','none');
                $(this).children('.chooseSelect').val('')
            };
        });
    };

    //获取修改分类的id
    $scope.getUpdateTypeId = function(){
        var selectAll =  $('.selectModal');
        $scope.updateCatId = []; //遍历的分类数组
        selectAll.each(function(i,item){
            //console.log(item)
            var choose = $(this).find('.chooseSelect').val();
            //console.log(choose)
            $scope.updateCatId.push(choose);
        });
    };
    //修改分类完成按钮
    $scope.updateSuccessBtn = function(){
        $scope.getUpdateTypeId();
        console.log($scope.updateCatId)
        var updateOneTypeParam = {
            id :  $scope.updateOneTypeId,
            cat_id : $scope.updateCatId,
        };
        $http({
            url :'/action-library/edit-category',
            method : 'POST',
            data : $.param(updateOneTypeParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            //console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                $('#updateTypeModal').modal('hide');
                $scope.getActionData();
            }else{
                Message.warning(result.data.mes);
            }
        });

    };
    //列表编辑内容事件
    $scope.updateBtn = function (id) {
        window.location.href = "/action-library/update-action?updateId=" + id;
    };
    //批量操作
    $(document).on('click', '.chooseOnePage', function () {
        if($(this).is(':checked')) {
            $('.memberChooseTransfer').children().prop('checked','checked');
            $('.chooseOnePage').siblings().text('取消选择');
        }else {
            $('.memberChooseTransfer').children().prop('checked','');
            $('.chooseOnePage').siblings().text('选择本页')
        }
    });
    //批量删除按钮
    $scope.batchDeleteBtn = function(){
        //获取选中的id
        $scope.chooseDeleteArr = [];
        for(var i = 0; i < $('.memberChooseTransfer').children().length; i++) {
            if($('.memberChooseTransfer').children().eq(i).is(':checked')) {
                $scope.chooseDeleteArr.push($('.memberChooseTransfer').children().eq(i).data('choose'));
            }
        }
        if($scope.chooseDeleteArr.length === 0 || $scope.chooseDeleteArr == null) {
            Message.warning('请先批量选择要删除的动作！');
            $('.chooseOnePage').prop('checked','');
            $('.chooseOnePage').siblings().text('选择本页');
            return false;
        }
        console.log($scope.chooseDeleteArr);
        var deleteParam = {
           ids :  $scope.chooseDeleteArr,
        };
        swal({
            title: "确定批量删除么？",
            text: "",
            type: "warning",
            timer: 2000,
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm){
            if (isConfirm) {
                swal.close();
                $http({
                    url :'/action-library/delete-many',
                    method : 'POST',
                    data : $.param(deleteParam),
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
                }).then(function(result){
                    //console.log(result);
                    if(result.data.status == 'success'){
                        Message.success(result.data.mes);
                        $scope.getActionData();
                    }else{
                        Message.warning(result.data.mes);
                    }
                })
            } else {
                swal.close();
            }
        });

    };
    //删除一条
    $scope.deleteActionBtn = function(id){
        swal({
            title: "确定删除么？",
            text: "",
            type: "warning",
            timer: 2000,
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确定",
            cancelButtonText: "取消",
            closeOnConfirm: false,
            closeOnCancel: false
        }, function(isConfirm){
            if (isConfirm) {
                $http.get('/action-library/delete?id=' + id).success(function(result){
                    console.log(result);
                    if(result.status == 'success'){
                        swal(result.mes,'','success');
                        $scope.getActionData();
                    }else{
                        swal(result.mes,'','error');
                    }
                });
            } else {
                swal.close();
            }
        });
    };
});