angular.module('App').controller('adminCtrl', function ($scope, $http) {

    $scope.signOut = function () {
        location.href = "/login/index";
        localStorage.clear();
        /*
         $http({method:'get',url:'/cache/cache-flush'}).then(function (data) {
         },function (error) {
         console.log(error);
         Message.error("系统开了会小差,请刷新重试。。。")
         })
         */
        return false;
    };
    // 公司联盟侧边栏的信息提醒js
    // $scope.getCorprateAllianceInfo = function () {
    //     $http.get('/corporate-alliance/pending').success(function (data) {
    //         $scope.infoNumber = data.data;
    //     });
    // };
    // $scope.getCorprateAllianceInfo();

    //右边覆盖头像
    $http({method: 'get', url: "/personnel/employee-center"}).then(function (data) {
        $scope.listData = data.data;
    }, function (error) {
        console.log(error);
        Message.error("系统开了会小差,请刷新重试。。。")
    });
    //自动修改会员卡请假状态
    $http({method: 'get', url: "/member/login-automatic-leave"}).then(function (data) {
        $scope.leaveData = data.data;
    }, function (error) {
        console.log(error);
        Message.error("自动修改会员请假状态出错,请刷新重试。。。")
    });
    var $data = '';
    //获取标题菜单
    $scope.isSmall = false;
    $scope.isBtn = false;
    $scope.listItemsTitle = function () {
        $http({method: 'get', url: '/rbac/auth/top'}).then(function (data) {
            // $http({method: 'get', url: '/jurisdiction/get-auth-module-all'}).then(function (data) {
            if (data.data.data instanceof Array && data.data.data.length) {
                $scope.listItemsTitleData = data.data.data;
                $scope.isBtn = true;
                $scope.loadFunction();
                //遍历导航列表，选中某项
                function getNavTarget() {
                    //获取链接url中对应的模块名
                    var urlPage1 = String(window.location.href.split('/')[3]);
                    var urlPage2 = String(window.location.href.split('/')[4]);
                    //大小模块组合
                    var urlPageHref = urlPage1 + '/' + urlPage2;
                    //获取导航列表的dom，遍历查找对应选项并选中
                    //找到所有子列表
                    $scope.navLi = $('.sideMenuAll').children().find('.nav-second-level').children('li').children('a');
                    for (var i = 0; i < $scope.navLi.length; i++) {
                        //拿到子列表a标签的href值，大小模块一起进行匹配
                        $scope.navLiHref = $scope.navLi.eq(i).attr('href').split('/')[1] + '/' + $scope.navLi.eq(i).attr('href').split('/')[2];
                        if ($scope.navLiHref == urlPageHref) {
                            //设置样式
                            $scope.navLi.eq(i)
                                .css('color', '#fff')
                                .parent().css('background', '#131e26')
                                .parent().css('display', 'block');
                        }
                    }
                }

                getNavTarget();
            }
        }, function (error) {
            console.log(error)
            Message.error("系统开了会小差,请刷新重试。。。")
        })
    };
    $scope.listItemsTitle();

    $scope.loadFunction = function () {
        angular.element(document).ready(function () {
            $scope.isBtn = true;
            $(".slimScrollDiv .title").hide();
            var BOOL = true;
            $scope.isErUl = false
            $scope.bigLi = function (index) {
                // $('body').removeClass('mini-navbar');
                angular.forEach($scope.listItemsTitleData, function (item, ind) {
                    $scope.listItemsTitleData[ind].isErUl = false;
                    if (ind == index) {
                        $scope.listItemsTitleData[index].isErUl = true;
                    } else {
                        $scope.listItemsTitleData[ind].isErUl = false;
                    }
                })
                $scope.listItemsTitleData[index].isErUl = true;
            };
            $scope.show = function (index) {
                if (!$scope.isSmall) {
                    return;
                } else {
                    $scope.listItemsTitleData[index].isErUl = true;
                }
            }
            $scope.hide = function () {
                if (!$scope.isSmall) {
                    return;
                } else {
                    $(".slimScrollDiv .title").hide();
                }
            };
            if (!$scope.isSmall) {
                $(".marginLeft0").mouseover(function () {
                    $(this).children('ul').css('display', 'block')
                }).mouseout(function () {
                    $(".slimScrollDiv .title").hide();
                });
            } else {
                $scope.bigLi();
            }
            // 菜单切换
            //鼠标的移入移出
            $(".marginLeft0 ").children("ul").css("display", "none");
            // angular.element(document).ready(function () {
            //     console.log('0')
            //     if ($('body').hasClass('fixed-sidebar')) {
            //         $scope.isBtn = true;
            //     }
            // })
            $scope.bigSmall = function () {
                angular.forEach($scope.listItemsTitleData, function (item, ind) {
                    $scope.listItemsTitleData[ind].isErUl = false;
                })
                if ($('body').hasClass('mini-navbar')) {
                    $scope.isSmall = false;
                    setTimeout(
                        function () {
                            $('#side-menu').fadeIn(500);
                        }, 100);
                } else {
                    $scope.isSmall = true;
                }
            }
            $(window).resize(function () {
                var $width = document.body.clientWidth;
                // console.log($width)
                if ($width >= 769) {
                    $('body').removeClass('mini-navbar');
                    $('.navbar-static-side').fadeIn(500);
                } else {
                    $('.arrow').removeClass("down");
                    $(".marginLeft0 ").children("ul").css("display", "none");
                }
            });
        });
    }
});
