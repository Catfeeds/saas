!function ($, w) {
    "use strict";
    angular.module('App').controller('developMainCtrl', ['$scope', '$http', function ($scope, $http) {
        //select2插件初始化
        angular.element(document).ready(function () {
            $('#select-menu,' +
                ' #modify_type_label,' +
                ' #response-label,' +
                ' #modify_response_label,' +
                ' #move_one_module,' +
                ' #modify_per_response').select2({
                width: "100%"

            });
        });
        //模版初始化
        $scope.init = function (bool, is_cache, if_load) {
            //模块列表
            if (if_load === true) {
                load.show();
            }

            $http.get('/rbac/main/view?isOption=' + bool + '&isCache=' + is_cache).success(function (result) {
                if (bool === 1) {
                    $scope.option_modules = result.data;
                } else {
                    $scope.all_modules = result.data;
                }

                if (if_load === true) {
                    load.hide();
                }
            }).error(function (errors) {
                Tip.warning('服务器错误');

                if (if_load === true) {
                    load.hide();
                }
            });
        };
        //模版初始化
        $scope.init(0, 1, true); //服务器缓存
        $scope.init(1, 1, false); //服务器缓存
        //模态框初始化
        $scope.initModal = function () {
            $scope.module_name = "";
            $scope.route_name = "";
            $scope.module_icon = "";
            $scope.desc = "";
            $('#select-menu').val("").trigger("change");
            $('#response-label').val("").trigger("change");
        };
        //新增模块
        $scope.submit = function () {
            var mu = $('#select-menu'), rs = $('#response-label');
            if ($scope.module_name === '') {
                Tip.warning('请添写模块名!');

                return;
            }

            if ($scope.route_name === '') {
                Tip.warning('请填写路由!');

                return;
            }

            if ($scope.desc === '') {
                Tip.warning('请填写描述!');

                return;
            }

            if (rs.val() === '' || rs.val() === undefined || rs.val() === null) {
                Tip.warning('请选择数据响应格式!');

                return;
            }

            if (mu.val() === '' || mu.val() === undefined || mu.val() === null) {
                Tip.warning('请选择菜单分类!');

                return;
            }

            load.show();
            $http({
                url: '/rbac/main/insert',
                data: $.param({
                    scenario: 'x_add',
                    module_name: $scope.module_name,
                    module_route: $scope.route_name,
                    module_icon: $scope.module_icon,
                    module_pid: mu.val(),
                    response_type: rs.val(),
                    desc: $scope.desc,
                    _csrf_backend: yii.getCsrfToken()
                }),
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (result) {
                if (parseInt(result.code) === 1) {
                    Tip.success(result.message);
                    $scope.init(0, 0, false); //不缓存
                    $scope.init(1, 0, false); //不缓存
                } else {
                    Tip.warning(result.message);
                }

                $('#developModal').modal('hide').on('hidden.bs.modal', function (e) {
                    load.hide();
                });

            }).error(function (errors) {
                Tip.error('服务器错误');
                load.hide();
                $('#developModal').modal('hide');
            });
        };
        //添加基础角色
        $scope.basicRole = function (name) {
            load.show();
            $http({
                url: '/rbac/main/create',
                data: $.param({
                    module_name: name,
                    _csrf_backend: yii.getCsrfToken()
                }),
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (result) {
                if (parseInt(result.code) === 1) {
                    Tip.success(result.message);
                    $scope.init(0, 0, false); //不缓存
                    $scope.init(1, 0, false); //不缓存
                } else if (parseInt(result.code) === 2) {
                    Tip.warning(result.message);
                } else {
                    Tip.warning(result.message);
                }
                load.hide();
            }).error(function (errors) {
                Tip.error('服务器错误');
                load.hide();
            });
        };
        //修改模块 - 详情
        $scope.modifyModule = function (module_id) {
            load.show();
            $scope.modify_module = '';
            $scope.modify_route = '';
            $scope.modify_desc = '';
            $scope.modify_id = '';
            $scope.modify_icon = '';
            $scope.if_type = false;
            $('#modify_type_label').val("").trigger("change");
            $('#modify_response_label').val("").trigger("change");
            $('#modifyMenuModal').modal('show');
            $http.get('/rbac/main/detail?module_id=' + module_id).success(function (result) {
                if (parseInt(result.code) === 1) {
                    $scope.modify_module = result.data.name;
                    $scope.modify_route = result.data.route;
                    $scope.modify_desc = result.data.desc;
                    $scope.modify_icon = result.data.icon;
                    $scope.modify_id = module_id;
                    $scope.if_type = result.data.if_type;
                    $('#modify_type_label').val(result.data.pid).trigger("change");
                    $('#modify_response_label').val(result.data.response_type).trigger("change");
                } else {
                    Tip.success('数据拉去失败');
                }
                load.hide();
            }).error(function (errors) {
                Tip.error('服务器错误');
                load.hide();
            });
        };
        //修改模块 - 提交
        $scope.modify_submit = function (module_id) {
            var mmu = $('#modify_type_label'), mrs = $('#modify_response_label');
            if ($scope.modify_module === '') {
                Tip.warning('请添写模块名!');

                return;
            }

            if ($scope.modify_route === '') {
                Tip.warning('请填写路由!');

                return;
            }

            if ($scope.modify_desc === '') {
                Tip.warning('请填写描述!');

                return;
            }

            if (mrs.val() === '' || mrs.val() === undefined || mrs.val() === null) {
                Tip.warning('请选择数据响应格式!');

                return;
            }

            if (mmu.val() === '' || mmu.val() === undefined || mmu.val() === null) {
                Tip.warning('请选择菜单分类!');

                return;
            }

            load.show();
            $http({
                url: '/rbac/main/update',
                data: $.param({
                    scenario: 'x_modify',
                    module_name: $scope.modify_module,
                    module_route: $scope.modify_route,
                    module_icon: $scope.modify_icon,
                    desc: $scope.modify_desc,
                    module_pid: mmu.val(),
                    response_type: mrs.val(),
                    module_id: module_id,
                    _csrf_backend: yii.getCsrfToken()
                }),
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (result) {
                if (parseInt(result.code) === 1) {
                    $scope.init(0, 0, false); //不缓存
                    $scope.init(1, 0, false); //不缓存
                    Tip.success(result.message);
                } else {
                    Tip.warning(result.message);
                }

                $('#modifyMenuModal').modal('hide').on('hidden.bs.modal', function (e) {
                    load.hide();
                });

            }).error(function (errors) {
                Tip.error('服务器错误');
                load.hide();
                $('#modifyMenuModal').modal('hide');
            });
        };
        //查看基础角色
        $scope.check_basic_role = function (module) {
            $scope.role_data = [];
            $scope.user_data = [];
            load.show();
            $http.get(encodeURI('/rbac/main/examine?module_name=' + module)).success(function (result) {
                if (parseInt(result.code) === 1) {
                    $scope.role_data = result.data.role_data;
                    $scope.user_data = result.data.user_data;
                    if ($scope.role_data === null || $scope.role_data === undefined || $scope.role_data === []) {
                        $scope.role_no_data = true;
                        $scope.role_data = [];
                    } else {
                        $scope.role_no_data = false;
                    }

                    if ($scope.user_data === null || $scope.user_data === undefined || $scope.user_data === []) {
                        $scope.user_no_data = true;
                        $scope.user_data = [];
                    } else {
                        $scope.user_no_data = false;
                    }
                } else {
                    $scope.role_no_data = true;
                    $scope.user_no_data = true;
                }
                load.hide();
            }).error(function (errors) {
                $scope.role_no_data = true;
                $scope.user_no_data = true;
                Tip.error('服务器错误');
                load.hide();
            });
        };
        //调换菜单
        $scope.remove_menu = function (module_name, module_id) {
            load.show();
            $scope.move_module = module_name;
            $scope.move_module_id = module_id;
            $scope.top_menus = [];
            $('#move_one_module').val('').trigger('change');
            $http.get('/rbac/auth/menu?is_all=1').success(function (result) {
                if (parseInt(result.code) === 1) {
                    $scope.top_menus = result.data;
                } else {
                    $scope.top_menus = [];
                    Tip.warning(result.message);
                }
                load.hide();
            }).error(function (errors) {
                $scope.top_menus = [];
                Tip.error('服务器错误');
                load.hide();
            });
        };
        //确认调换菜单
        $scope.submit_change = function () {
            var mm = $('#move_one_module').val();
            if ($scope.move_module === '' ||
                $scope.move_module === undefined ||
                $scope.move_module_id === '' ||
                $scope.move_module_id === undefined) {
                Tip.warning('请选择二级菜单!');
                return;

            }

            if (mm === '' || mm === null) {
                Tip.warning('请选择一级菜单!');
                return;
            }

            load.show();
            $http({
                url: '/rbac/main/move',
                method: 'POST',
                data: $.param({
                    one_id: mm,
                    two_id: $scope.move_module_id,
                    _csrf_backend: yii.getCsrfToken(),
                }),
                headers: {"Content-Type": "application/x-www-form-urlencoded"}
            }).success(function (result) {
                if (parseInt(result.code) === 1) {
                    $scope.init(0, 0, false); //不缓存
                    $scope.init(1, 0, false); //不缓存
                    Tip.success(result.message);
                } else {
                    Tip.warning(result.message);
                }

                $('#move_menu').modal('hide').on('hidden.bs.modal', function (e) {
                    load.hide();
                });

            }).error(function (errors) {
                Tip.error('服务器错误');
                load.hide();
                $('#move_menu').modal('hide');
            });
        };
        //修改已添加权限的模块
        $scope.modify_per_module_click = function (module_id) {
            load.show();
            $scope.modify_per_module = '';
            $scope.modify_per_route = '';
            $scope.modify_per_desc = '';
            $scope.modify_per_icon = '';
            $scope.modify_per_module_id = '';
            $('#modify_per_response').val("").trigger("change");

            $http.get('/rbac/main/detail?module_id=' + module_id + '&option=1').success(function (result) {
                if (parseInt(result.code) === 1) {
                    $scope.modify_per_module = result.data.name;
                    $scope.modify_per_route = result.data.route;
                    $scope.modify_per_desc = result.data.desc;
                    $scope.modify_per_icon = result.data.icon;
                    $scope.modify_per_module_id = result.data.id;
                    $('#modify_per_response').val(result.data.response_type).trigger("change");
                } else {
                    Tip.success('数据拉去失败');
                }
                load.hide();
            }).error(function (errors) {
                Tip.error('服务器错误');
                load.hide();
            });
        };
        //修改已添加权限模块 - 提交
        $scope.modify_per_module_submit = function () {
            var mprs = $('#modify_per_response');
            if ($scope.modify_per_module === '') {
                Tip.warning('请添写模块名!');

                return;
            }

            if ($scope.modify_per_route === '') {
                Tip.warning('请填写路由!');

                return;
            }

            if ($scope.modify_per_desc === '') {
                Tip.warning('请填写描述!');

                return;
            }

            if (mprs.val() === '' || mprs.val() === undefined || mprs.val() === null) {
                Tip.warning('请选择数据响应格式!');

                return;
            }

            load.show();
            $http({
                url: '/rbac/main/modify',
                data: $.param({
                    scenario: 'x_update',
                    module_name: $scope.modify_per_module,
                    module_route: $scope.modify_per_route,
                    module_icon: $scope.modify_per_icon,
                    desc: $scope.modify_per_desc,
                    response_type: mprs.val(),
                    module_id: $scope.modify_per_module_id,
                    _csrf_backend: yii.getCsrfToken()
                }),
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (result) {
                if (parseInt(result.code) === 1) {
                    $scope.init(0, 0, false); //不缓存
                    $scope.init(1, 0, false); //不缓存
                    Tip.success(result.message);
                } else {
                    Tip.warning(result.message);
                }

                $('#modify_per_module').modal('hide').on('hidden.bs.modal', function (e) {
                    load.hide();
                });

            }).error(function (errors) {
                Tip.error('服务器错误');
                load.hide();
                $('#modify_per_module').modal('hide');
            });
        };
    }]).filter('html_filter', ['$sce', function ($sce) {
        return function (val) {
            return $sce.trustAsHtml(val);
        }
    }]);
}(jQuery, window);
