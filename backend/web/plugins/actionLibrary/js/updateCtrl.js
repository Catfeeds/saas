/*
动作库编辑页面js
*/
angular.module('App').controller('updateCtrl',function($scope,$http,Upload,$sce,$timeout){
    //获取传递修改的ID值
    var getQueryValue = function(key, href) {
        href = href || window.location.search;
        var match = href.match(new RegExp('[?&]' + key + '=([^&]*)'));
        return match && match[1] && decodeURIComponent(match[1]) || '';
    };
    $scope.updateId= getQueryValue('updateId');
    //console.log($scope.updateId);
    $scope.init = function(){
        $scope.imgArr1 = [];
        $scope.unit = '';
        $scope.getSelectMenu();
        $scope.videoSrc = '';
        $scope.getUpdateAction();
    };

    $scope.getSelectMenu = function(){
        $http.get('/action-category/get-all-category').success(function(result){
            //console.log(result);
            $scope.selectMenuList = result;
        })
    };

    //获取编辑的内容
    $scope.getUpdateAction = function(){
        $http.get('/action-library/get-one-detail?id=' + $scope.updateId).success(function(result){
            console.log(result);
            $scope.typeName = result.data.title;        //名字
            $scope.drillType = result.data.type;        //类型
            $scope.unit = result.data.unit;             //单位
            $scope.expend = result.data.energy;         //热量消耗
            $scope.gist = result.data.ssentials;        //动作要领
            $scope.updateImage = result.data.images;    //正确照片和错误照片
            $scope.videoSrc = result.data.video;
            var updateTypeData = result.data.categorys;
            var selectAll =  $('.selectNum');
            $scope.typeIdArr = [];
            updateTypeData.map(function(item,i){
                $scope.typeIdArr.push(item.id);
            });
            selectAll.each(function(i,item){
                //console.log(item)
                //console.log($scope.typeIdArr);
                $(this).children('.selectStyle').val($scope.typeIdArr);
            });
            var selectAll1 =  $('.selectNum');
            selectAll1.each(function(i,item){
                if($(this).children('.selectStyle').val() == null){
                    $(this).children('.selectStyle').val('');
                };
            });
            // //判断正确示范的照片路径是否为空
            // $scope.updateImage.map(function(item,i){
            //     //console.log(item);
            //     if(item.type == '2' && item.url == ''){
            //         $scope.showStatus = true;
            //         $scope.showImg = false;
            //     }
            // })
        })
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
    //刷新按钮
    $scope.refreshBtn = function(){
        $scope.getSelectMenu();
    };
    // $scope.showImg = false;

    //获取正确照片
    $scope.rightImgArr = [];
    $scope.getRightImgNum = function(){
        var rightImg = $('.imgDiv').children('img');
        rightImg.each(function(i,item){
            $scope.rightImgArr.push(item.src);
        })
    };
    $timeout(function(){
        $scope.getRightImgNum();
    },500);
    $scope.checkRightImg = function(){
        var host = window.location.host;    //域名
        $scope.protocol2 = location.protocol;//协议
        if($scope.rightImgArr.length == 1 && $scope.rightImgArr[0] == $scope.protocol2 + '//' + host + '/plugins/actionLibrary/img/22.png'){
            $scope.rightImgArr = [];
        }
    };
    //删除之前添加的动作示范照片
    $scope.updateDeleteBtn = function(index){
        $scope.getCatId();
        //console.log( $scope.exampleArr);
        $scope.updateImage.splice(index,1);
        $scope.rightImgArr.splice(index,1);
        // if($scope.exampleArr.length <= 1){
        //     //$scope.updateImage.splice(index,1);
        //     $scope.showImg = true;
        // }
        //console.log( $scope.rightImgArr)
    };


    //上传新添加的照片
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
        $scope.checkRightImg();
        $scope.getCatId();
        $.loading.show();
        Upload.upload({
            url    : '/class/upload',
            method :'POST',
            data   : {UploadForm: {imageFile: file}, _csrf_backend: $('#_csrf').val()},
            headers     : { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function (results) {
            //console.log(results);
            if(results.data.status == 'success'){
                //console.log($scope.rightImgArr);
                $scope.showStatus = false;
                $scope.showImg = false;
                $scope.imgArr1.push(results.data.imgLink);
                if(Number($scope.imgArr1.length) + Number($scope.rightImgArr.length)> 5){
                    Message.warning('照片不能超过5张');
                    $scope.imgArr1.pop();
                    //return $scope.imgArr1;
                }
            }
            $.loading.hide();

        });
    };
    //删除动作示范照片
    $scope.deleteBtn = function(index){
        $scope.imgArr1.splice(index,1);
        if($scope.imgArr1.length == 0 && $scope.rightImgArr.length == 0){
            $scope.showImg = true;
        }
    };
    $scope.warningImgArr = [];
    //获取错误照片
    $scope.getImgNum = function(){
        var waringImg = $('.waringImgDiv').children('img');
        waringImg.each(function(i,item){
            $scope.warningImgArr.push(item.src);
        })
    };
    $timeout(function(){
        $scope.getImgNum();
    },300);
    //删除之前添加的错误示范照片
    $scope.updateDelImgBtn = function(index){
        console.log('111');
        var $index = index -1;
        $('.waringImgDiv').eq($index).css('display','none');
        $scope.warningImgArr.splice($index,1);
    };
    //上传新添加的错误示范照片
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
        //console.log($scope.warningImgArr);
        $.loading.show();
        Upload.upload({
            url    : '/class/upload',
            method :'POST',
            data   : {UploadForm: {imageFile: file}, _csrf_backend: $('#_csrf').val()},
            headers     : { 'Content-Type': 'application/x-www-form-urlencoded' }
        }).then(function (results) {
            //console.log(results);
            if(results.data.status == 'success'){
                //$scope.warningImgArr.push( results.data.imgLink);
                $scope.imgArr.push( results.data.imgLink);
                if(Number($scope.imgArr.length) + Number($scope.warningImgArr.length) > 3){
                    Message.warning('照片不能超过3张');
                    $scope.imgArr.pop();
                }
            }
            $.loading.hide();
        });
    };
    //删除错误示范照片
    $scope.delImgBtn = function(index){
        $scope.imgArr.splice(index,1);
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
            // if(uploadImg == $scope.protocol + '//' + host + '/plugins/actionLibrary/img/22.png'){
            //     uploadImg = '';
            // }
            var exampleData = {
                img : uploadImg,
                note : note
            };

            $scope.exampleArr.push(exampleData);
        });

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
    //保存按钮
    $scope.imgArr2 = [];
    $scope.updateSubmitBtn = function(){
        $scope.getCatId();
        //console.log($scope.warningImgArr);
        //console.log($scope.imgArr);
        // if($scope.imgArr.length != 0 && $scope.warningImgArr.length != 0){
        //     $scope.imgArr2 = $scope.imgArr.concat($scope.warningImgArr);
        // }else{
        //     $scope.imgArr2 = [];
        // }
        $scope.imgArr2 = $scope.imgArr.concat($scope.warningImgArr);

        //console.log($scope.imgArr2);
        //console.log( $scope.exampleArr);
        //console.log($('#unit').val());
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
        if($scope.exampleArr.length > 5){
            Message.warning('上传照片不能超过5张');
            $scope.imgArr1.pop();
            return
        }

        //参数
        var updateActionParam = {
            id :  $scope.updateId,         //修改动作的ID
            title : $scope.typeName,       //动作名称
            cat_id :$scope.catId,          //分类ID
            type : $scope.drillType,       //类型
            unit : $('#unit').val(),            //单位
            energy : $('#expend').val(),   //热量消耗
            ssentials : $('#gist').val(),  //动作要领
            r_example : $scope.exampleArr, //正确示范
            w_example : $scope.imgArr2,//错误示范
            video : $scope.videoSrc        //视频
        };
        console.log(updateActionParam);
        $http({
            url :'/action-library/update',
            method : 'POST',
            data : $.param(updateActionParam),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function(result){
            console.log(result);
            if(result.data.status == 'success'){
                Message.success(result.data.mes);
                window.location.href = "/action-library/index";
            }else{
                Message.warning(result.data.mes);
            }
        })
    };
    //取消按钮
    $scope.updateCancelBtn = function(){
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