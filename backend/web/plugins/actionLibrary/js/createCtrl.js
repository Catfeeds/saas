$(function(){
   // $('.selectStyle').select2()
});
angular.module('App').controller('createCtrl',function($scope,$http,Upload,$sce){

    //初始化
    $scope.init = function(){

    };
    $scope.init();
    //单位change事件
    $scope.unitChange = function(id){
        if(id == 2){
            $scope.chooseMin = true;
        }else{
            $scope.chooseMin = false;
        }
    };
    $scope.getSelectMenu = function(){
        $http.get('/action-category/get-all-category').success(function(result){
            //console.log(result);
            $scope.selectMenuList = result;
        })
    };
    $scope.getSelectMenu();

    //刷新按钮
    $scope.refreshBtn = function(){
        $scope.getSelectMenu();
    };

    //上传动作示范照片
    $scope.imgArr1 = [];
    $scope.setCover5 = function (file) {
        if(file) {
            if(file.size >=2000000){
                swal('上传图片不能大于2M，请重试！', '', 'error');
            }else{
                $scope.setPic5(file);
            }
        }
    };
    //发送图片
    $scope.setPic5 = function (file) {
        $.loading.show();
        Upload.upload({
            url    : '/class/upload',
            method :'POST',
            data   : {UploadForm: {imageFile: file}, _csrf_backend: $('#_csrf').val()},
            headers     : { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function (results) {
            //console.log(results);
            if(results.data.status == 'success'){
                $scope.imgArr1.push(results.data.imgLink);
                if($scope.imgArr1.length > 5){
                    Message.warning('照片不能超过5张');
                    $scope.imgArr1.pop();
                    return $scope.imgArr1;
                }
            }
            $.loading.hide();
        });
    };
    //删除动作示范照片
    $scope.deleteBtn = function(index){
        $scope.imgArr1.splice(index,1);
    };
    //上传错误示范照片
    $scope.setCover6 = function (file) {
        if(file) {
            if(file.size >=2000000){
                swal('上传图片不能大于2M，请重试！', '', 'error');
            }else{
                $scope.setPic6(file);
            }
        }
    };
    $scope.imgArr = [];
    //发送图片
    $scope.setPic6 = function (file) {
        $.loading.show();
        Upload.upload({
            url    : '/class/upload',
            method :'POST',
            data   : {UploadForm: {imageFile: file}, _csrf_backend: $('#_csrf').val()},
            headers     : { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function (results) {
            //console.log(results);
            if(results.data.status == 'success'){
                $scope.imgArr.push( results.data.imgLink);
                if($scope.imgArr.length > 3){
                    Message.warning('照片不能超过3张');
                    $scope.imgArr.pop();
                    return $scope.imgArr;
                }
            }
            $.loading.hide();
        });
    };
    //删除错误示范照片
    $scope.delImgBtn = function(index){
        $scope.imgArr.splice(index,1);
    };
    //上传视频
    $scope.setCover7 = function (file) {
        if(file) {
            if(file.size >=20000000){
                swal('上传视频不能大于20M，请重试！', '', 'error');
            }else{
                $scope.setPic7(file);
            }
        }
    };
    //初始化
    $scope.videoSrc = '';
    //发送视频
    $scope.setPic7 = function (file) {
        $.loading.show();
        Upload.upload({
            url    : '/class/upload',
            method :'POST',
            data   : {UploadForm: {imageFile: file}, _csrf_backend: $('#_csrf').val()},
            headers     : { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function (results) {
            //console.log(results);
            if(results.data.status == 'error'){
                Message.warning('视频格式错误');
            }else{
                $scope.videoSrc = results.data.imgLink;
            }
            $.loading.hide();
        });
    };
    //删除视频
    $scope.deleteVideoBtn = function(){
        $scope.videoSrc = '';
    };
    //转换为可信任的video链接
    $scope.videoUrl = function(url){
        return $sce.trustAsResourceUrl(url);
    };
    //获取分类管理的id 和动作示范的照片及说明
    $scope.getCatId = function(){
        var selectAll =  $('.selectNum');
        $scope.catId = []; //遍历的分类数组
        selectAll.each(function(i,item){
            //console.log(item)
            var choose = $(this).find('.selectStyle').val();
            //console.log(choose)
            $scope.catId.push(choose);
        });
        var uploadAll = $('.exampleDiv').children('.uploadDiv');
        $scope.exampleArr = []; //动作示范数组
        uploadAll.each(function(i,item){
            //console.log(item)
            var uploadImg = $(this).find('.imgDiv').children('img').prop('src');
            var note = $(this).find('.detail').val();
            //console.log(uploadImg);
            //console.log(note);
            var host = window.location.host;    //域名
            $scope.protocol = location.protocol;//协议
            //console.log($scope.protocol)
            //console.log(host + '/plugins/actionLibrary/img/22.png');
            //console.log(uploadImg)
            // if(uploadImg ==  $scope.protocol + '//' + host + '/plugins/actionLibrary/img/22.png'){
            //     //console.log(uploadImg)
            //     uploadImg = '';
            // }
            var exampleData = {
                img : uploadImg,
                note : note
            };

            $scope.exampleArr.push(exampleData);
        })

    };
    //保存按钮
    $scope.submitBtn = function(){
        $scope.getCatId();
        if($scope.typeName == '' || $scope.typeName == undefined){
            Message.warning('请输入动作名称');
            return
        }
        if($scope.typeName.length > 10){
            Message.warning('动作名称不能大于10个字');
            return
        }
        if($scope.drillType == '' || $scope.drillType == undefined){
            Message.warning('请选择类型');
            return
        }
        if($('#unit').val() == '' || $('#unit').val() == undefined){
            Message.warning('请选择单位');
            return
        }
        if($('#expend').val() == '' || $('#expend').val() == undefined){
            Message.warning('请输入热量消耗');
            return
        }
        if($('#gist').val() == '' || $('#gist').val() == undefined){
            Message.warning('请输入动作要领');
            return
        }
        // if($scope.exampleArr.indexOf(undefined) != -1){
        //     Message.warning('请上传动作示范照片');
        //     return
        // }
        //console.log($scope.catId);
        //参数
        var actionParam = {
            title : $scope.typeName,       //动作名称
            cat_id :$scope.catId,          //分类ID
            type : $scope.drillType,       //类型
            unit : $('#unit').val(),            //单位
            energy : $('#expend').val(),   //热量消耗
            ssentials : $('#gist').val(),  //动作要领
            r_example : $scope.exampleArr, //正确示范
            w_example : $scope.imgArr,     //错误示范
            video : $scope.videoSrc        //视频
        };
        //console.log(actionParam);
        $http({
            url :'/action-library/add',
            method : 'POST',
            data : $.param(actionParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                window.location.href = "/action-library/index";
            }else{
                if(result.data.mes.title){
                    Message.warning(result.data.mes.title[0]);
                }
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
                //swal("删除！", "你的虚拟文件已经被删除。", "success");
                window.location.href = "/action-library/index";
            } else {
                swal.close();
            }
        });
    };
});