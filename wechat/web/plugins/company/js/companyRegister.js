/**
 * Created by DELL on 2017/6/7.
 * 手机端购卡页面控制器
 */
$(function() {
    FastClick.attach(document.body);

});

var app = angular.module('App',['starter.services']).controller('companyRegisterCtrl',function($timeout,$http,$scope,$rootScope,$interval,$location,dialogsManager){
    //扇叶窗
    var oHeight = $(document).height(); //浏览器当前的高度

    $(window).resize(function(){

        if($(document).height() < oHeight){

            $("#submitBtn").css("position","static");
        }else{

            $("#submitBtn").css("position","fixed");
        }
    });

    $("#cityPicker111").cityPicker({
        title: "选择所在地区",
        onChange: function (picker, values, displayValues) {
            console.log(values, displayValues);
            var strName = '';
            displayValues.forEach(function(item,index){
                console.log(item)
                strName = strName + item
            })
            $scope.regionName = strName;
        }
    });
    StorefrontTypes:
    $('#storeType').select({
        title: "请选择店面类型",
        items: [
            {title:'综合馆',value:'1'},
            {title:'瑜伽',value:'2'},
            {title:'舞蹈',value:'3'},
            {title:'私教工作室',value:'4'},
        ],
        onChange:function(e){
            console.log('e',e)
            console.log(!e.values)
            if(e.values){
                $scope.storeType = e.values
            }else{
                $scope.storeType = '';
            }
        }

    })

    localStorage.setItem('defaultUrl',JSON.stringify({
        url:window.location.href
    }));

    $scope.initData = function(){
        $scope.companyName   = '';//公司名称
        $scope.userName      = '';//负责人名称
        $scope.mobile        = '';//手机号
        $scope.newCode       = '';//输入的验证码
        $scope.code          = '';//获取的验证码
        $scope.storefrontNum = '';//店面数量
        $scope.regionName    = '';//地区名称
        $scope.address       = '';//详细地址
        $scope.storeType     = '';//店面类型
    }

    $scope.initData();

    $scope.storeNumberChange = function(num){
        console.log('店面数量',num)
        if(!num){
            $scope.showMessage = function () {
                dialogsManager.showMessage("地面数量不能为空");
            }
            $scope.showMessage();
            return;
        }else if(0  < num && num< 100000000){
            var storeNum = Math.floor(num)
            console.log('storeNum',storeNum)
            $scope.storefrontNum = storeNum;
        }else if(num >= 100000000){
            $scope.showMessage = function () {
                dialogsManager.showMessage("地面数量不能大于100000000");
            }
            $scope.showMessage();
            $scope.storefrontNum = '';
            return;
        }
    }

    //初始提交状态
    $scope.submitButtonFlag = false;
    //点击确定提交数据
    $scope.confirmRes  = function(){
        console.log($('#cityPicker111').val())
        $scope.submitData = function(){
            return{
                companyName   :$scope.companyName    != undefined && $scope.companyName   != "" ? $scope.companyName      : null,
                username      :$scope.userName       != undefined && $scope.userName      != "" ? $scope.userName         : null,
                mobile        :$scope.mobile         != undefined && $scope.mobile        != "" ? parseInt($scope.mobile) : null,
                address       :$scope.address        != undefined && $scope.address       != "" ? $scope.address          : null,
                storeNum      :$scope.storefrontNum  != undefined && $scope.storefrontNum != "" ? $scope.storefrontNum    : null,
                type          :$scope.storeType      != undefined && $scope.storeType     != "" ? $scope.storeType        : null,
                code          :$scope.newCode        != undefined && $scope.newCode       != "" ? parseInt($scope.newCode): null,
                area          :$scope.regionName     != undefined && $scope.regionName    != "" ? $scope.regionName       : null,
                _csrf_backend :$('#_csrf').val()
            }
        }
        console.log('data',$scope.submitData());
        var buyCardName = /^([a-zA-Z0-9\u4e00-\u9fa5 ]+)$/;
        if($scope.companyName == '' || $scope.companyName == null || $scope.companyName == undefined || !(buyCardName.test($scope.companyName))){
            $scope.showMessage = function () {
                dialogsManager.showMessage("请输入合法的公司名称");
            }
            $scope.showMessage();
            return;
        }

        if($scope.userName == '' || $scope.userName == null || $scope.userName == undefined || !(buyCardName.test($scope.userName))){
            $scope.showMessage = function () {
                dialogsManager.showMessage("请输入正确的姓名!");
            }
            $scope.showMessage();
            return false;
        }



        //手机号验证
        var $pattern = /^1[1234567890]\d{9}$/;
        if ($scope.mobile == null || $scope.mobile == undefined || !($pattern.test($scope.mobile))) {
            $scope.showMessage = function () {
                dialogsManager.showMessage("请填写正确的手机号!");
            }
            $scope.showMessage();
            return false;
        }
        if($scope.newCode == null || $scope.newCode == undefined || $scope.newCode == ''){
            $scope.showMessage = function () {
                dialogsManager.showMessage("请输入验证码!");
            }
            $scope.showMessage();
            return false;
        }

        //验证验证码
        if (parseInt($scope.newCode) != parseInt($scope.code)) {
            $scope.showMessage = function () {
                dialogsManager.showMessage("验证码输入错误");
            }
            $scope.showMessage();
            return ;
        }

        if(parseInt($scope.mobile) != parseInt($scope.oldMobile)){
            $scope.showMessage = function () {
                dialogsManager.showMessage("您的验证码和手机号不匹配！");
            }
            $scope.showMessage();
            return;
        }

        if ($scope.storefrontNum == null || $scope.storefrontNum == "" || $scope.storefrontNum == undefined || $scope.storefrontNum < 1) {
            $scope.showMessage = function () {
                dialogsManager.showMessage("请输入门面数量");
            }
            $scope.showMessage();
            return ;
        }
        if ($scope.storeType == null || $scope.storeType == "" || $scope.storeType == undefined ) {
            $scope.showMessage = function () {
                dialogsManager.showMessage("请选择店面类型");
            }
            $scope.showMessage();
            return ;
        }

        if($scope.regionName == undefined || $scope.regionName == null || $scope.regionName == ''){
            $scope.showMessage = function () {
                dialogsManager.showMessage("请选择地区");
            }
            $scope.showMessage();
            return ;
        }


        if($scope.address == '' || $scope.address == null || $scope.address == undefined || !(buyCardName.test($scope.address))){
            $scope.showMessage = function () {
                dialogsManager.showMessage("请输入合法的详情地址!");
            }
            $scope.showMessage();
            return false;
        }
        if(!$scope.submitButtonFlag){
            $scope.postSubmit();
        }


    }

    $scope.postSubmit = function () {
        $http({
            url: '/company/sign-up',
            method: 'POST',
            data: $.param($scope.submitData()),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (result) {
            if (result.data.status == 'success') {
                $scope.showMessage = function () {
                    dialogsManager.showMessage('提交成功');
                }
                $scope.showMessage();
                location.href = '/company/complete' + '?time=' + ((new Date()).getTime());
            } else if(result.data.status == 'error') {
                $scope.submitButtonFlag = false;
                $scope.showMessage = function () {
                    dialogsManager.showMessage(result.data.message);
                }
                $scope.showMessage();
            }
        });
    };
    //注册验证码
    $scope.paracont  = "获取验证码";
    $scope.disabled  = false;

    $scope.getCode = function(){
        var $pattern = /^1[1234567890]\d{9}$/;
        if(!($pattern.test($scope.mobile))){
            $scope.showMessage = function () {
                dialogsManager.showMessage("请填写正确的手机号!");
            }
            $scope.showMessage();
            return ;
        }else{
            $scope.oldMobile = $scope.mobile;
            $http({
                url     : '/company/create-code',
                method  : 'POST',
                data    : $.param({'mobile' : $scope.mobile}),
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
            }).then(function (result){
                if(result.data.status == 'success'){
                    $scope.code = result.data.data;
                }else{
                    $scope.showMessage = function () {
                        dialogsManager.showMessage(result.data.data);
                    }
                    $scope.showMessage();
                }
            });

            /**
             * @云运动 - 后台 - 注册页面
             * @author Zhu Mengke <zhumengke@itsports.club>
             * @create 2017/4/5
             * @inheritdoc
             */

            $scope.codeSecond = 60;
            $scope.timePromiseCode = undefined;

            $scope.timePromiseCode = $interval(function(){
                if($scope.codeSecond<=0){
                    $interval.cancel($scope.timePromiseCode);
                    $scope.timePromiseCode = undefined;
                    $scope.codeSecond = 60;
                    $scope.paracont  = "获取验证码";
                    $scope.disabled  = false;
                }else{
                    $scope.paracont = $scope.codeSecond + "秒";
                    $scope.disabled =true;
                    $scope.codeSecond--;
                }
            },1000,100);
        }
    };
}).controller('completeCtrl',function($scope,$http,$rootScope,$location){
    //会员登记成功页面
    var contractData = localStorage.getItem('defaultUrl');
    var $memberIdArr = angular.fromJson(contractData);
    console.log($memberIdArr)
    $scope.preUrl = $memberIdArr.url;
    $scope.backPrePage = function(){
        window.location.href = $scope.preUrl;
    }
}).filter('to_Html', ['$sce', function ($sce) {
        return function (text) {
            return $sce.trustAsHtml(text);
        }
    }]
);
