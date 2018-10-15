!function ($, w) {
    "use strict";
    angular.module('App').controller('vipRoleCtrl', ['$scope', '$http', function ($scope, $http) {
        //声明window对象
        w.detail_object = $('#detail, #save_per');
        w.check_per_object = $('#check_per, #add_per');
        //select2 初始化
        angular.element(document).ready(function () {
            $('#venue_label,' +
                ' #roles_label,' +
                ' #company_label,' +
                ' #user_label,' +
                ' #option_menu,' +
                ' #stadium_label,' +
                ' #modify_company_label,' +
                ' #modify_roles_label,' +
                ' #user_company_label').select2({
                width: "100%"

            });
            //公司、场馆二级联动
            $('#company_label').on('change', function () {
                let company = $('#company_label').val();
                if (company === null || company === undefined || company === '') {
                    return;
                }

                $http.get('/rbac/auth/venue?company=' + company).success(function (result) {
                    if (parseInt(result.code) === 1) {
                        $scope.venues = result.data;
                    } else {
                        Tip.warning('数据拉取失败');
                    }
                }).error(function (errors) {
                    Tip.error('服务器错误');
                });
            });
        });
        //列表
        $scope.init_list = function (bool, is_load) {
            if (is_load === true) {
                load.show();
            }

            $('#venue_label, #roles_label, #company_label').val('').trigger('change');
            $scope.role_name = "";
            $http.get('/rbac/auth/view?isOption=' + bool).success(function (result) {
                if (parseInt(result.code) === 1) {
                    if (bool === 1) {
                        $scope.optionItems = result.data;
                    } else {
                        $scope.items = result.data;
                    }
                } else {
                    Tip.warning('数据拉取失败');
                }

                if (is_load === true) {
                    load.hide();
                }
            }).error(function (errors) {
                Tip.error('服务器错误');

                if (is_load === true) {
                    load.hide();
                }
            });
        };
        //公司
        $scope.initCompany = function () {
            $http.get('/rbac/auth/company').success(function (result) {
                if (parseInt(result.code) === 1) {
                    $scope.companies = result.data;
                } else {
                    Tip.warning('组织机构数据拉取失败');
                }
            }).error(function (errors) {
                Tip.error('服务器错误,错误方法: $scope.initCompany');
            });
        };
        //初始化列表
        $scope.init_list(0, true);
        $scope.init_list(1, false);
        //初始化公司
        $scope.initCompany();
        //模态框
        $scope.insert_roles = function () {
            $scope.role_name = '';
            $scope.venues = [];
            $('#company_label').val('').trigger('change');
            $('#roles_label').val('').trigger('change');
            $('#venue_label').val([]).trigger('change');
            $('#rolesModal').modal('show');
        };
        //新增角色
        $scope.submit = function () {
            let c = $('#company_label'),
                r = $('#roles_label'),
                v = $('#venue_label');

            if ($scope.role_name === '') {
                Tip.warning('请填写角色名!');

                return;
            }

            if (c.val() === '' || c.val() === undefined || c.val() === null) {
                Tip.warning('请选择公司!');

                return;
            }

            if (r.val() === '' || r.val() === undefined || r.val() === null) {
                Tip.warning('请选择派生角色!');

                return;
            }

            if (v.val() === '' || v.val().length === 0 || v.val() === null) {
                Tip.warning('请选择场馆!');

                return;
            }

            load.show();
            $http({
                url: '/rbac/auth/insert',
                data: $.param({
                    scenario: 'insert',
                    role_name: $scope.role_name,
                    company_id: c.val(),
                    derive_id: r.val(),
                    venue_id: v.val(),
                    _csrf_backend: yii.getCsrfToken()
                }),
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (result) {
                if (parseInt(result.code) === 1) {
                    Tip.success(result.message);
                    $scope.init_list(0, false);
                    $scope.init_list(1, false);
                } else {
                    Tip.warning(result.message);
                }

                $('#rolesModal').modal('hide').on('hidden.bs.modal', function (e) {
                    load.hide();
                });

            }).error(function (errors) {
                Tip.error('服务器错误');
                $('#rolesModal').modal('hide');
                load.hide();
            });
        };
        //初始化$scope对象
        $scope.global_init = function () {
            $scope.permissions = [];
            $scope.check_per_data = [];
            $scope.check_per_role = '';
            $scope.check_role_name = '';
            $scope.users = [];
            $scope.high_role_name = '';
            $scope.high_role_id = '';
            $scope.role_id = '';
            $scope.add_role_id = '';
            $scope.assign_users = [];
            $scope.user_no_data = false;
            $scope.add_role_name = '';
            $scope.add_per_data = [];
            $scope.select_pers = [];
            $scope.select_per_role = '';
            $scope.is_disabled_role = true;
            $scope.is_show_save = false;
            $scope.is_show_modify = true;
            $scope.modify_role_name = '';
            $scope.modify_role_id = '';
            $scope.is_derive_disabled = true;
            $('#modify_company_label').val("").trigger('change');
            $('#modify_roles_label').val("").trigger('change');
            $('#user_company_label').val("").trigger('change');
            $('#user_label').val("").trigger('change');
        };
        //初始化
        $scope.global_init();
        //分配权限
        $scope.allot_per = function (id, derive) {
            w.high_role = id;
            load.show();
            if (!check_per_object.hasClass('detail')) {
                check_per_object.addClass('detail');
            }

            if (detail_object.hasClass('detail')) {
                detail_object.removeClass('detail');
            }

            $scope.permissions = [];
            $http.get('/rbac/auth/basic-role?highRole=' + id + '&deriveId=' + derive).success(function (result) {
                if (parseInt(result.code) === 1) {
                    angular.forEach(result.data, function (item) {
                        item.is_checked = false;
                    });

                    $scope.permissions = result.data;
                } else {
                    $scope.permissions = [];
                    Tip.warning('请先分配父级角色!');
                    if (!detail_object.hasClass('detail')) {
                        detail_object.addClass('detail');
                    }
                }
                load.hide();
            }).error(function (errors) {
                $scope.permissions = [];
                Tip.error('服务器错误');
                if (!detail_object.hasClass('detail')) {
                    detail_object.addClass('detail');
                }

                load.hide();
            });
        };
        //查看权限
        $scope.look_per = function (role_id, role_name) {
            $scope.check_per_data = [];
            load.show();
            let is_class = detail_object.hasClass('detail');
            if (!is_class) {
                detail_object.addClass('detail');
            }

            if (check_per_object.hasClass('detail')) {
                check_per_object.removeClass('detail');
            }

            $http.get('/rbac/auth/check?roleId=' + role_id).success(function (result) {
                if (parseInt(result.code) === 1) {
                    $scope.check_per_data = result.data;
                    $scope.check_per_role = role_id;
                    $scope.check_role_name = role_name;
                } else {
                    $scope.check_per_data = [];
                    $scope.check_per_role = role_id;
                    $scope.check_role_name = role_name;
                    Tip.warning('拉去数据失败');
                }
                load.hide();
            }).error(function (errors) {
                $scope.check_per_data = [];
                $scope.check_per_role = role_id;
                $scope.check_role_name = role_name;
                Tip.error('服务器错误');
                load.hide();
            });
        };
        //全选、全不选
        $scope.is_check = function (bool) {
            angular.forEach($scope.permissions, function (item) {
                item.is_checked = !bool;
                $scope.is_bool = !bool;
            });
        };
        //点击列表
        $scope.check_one = function (per_id, bool) {
            angular.forEach($scope.permissions, function (item) {
                if (parseInt(item.id) === parseInt(per_id)) {
                    item.is_checked = !bool;
                    if (parseInt(item.pid) === 0) {
                        /*向下全选*/
                        $scope.down_recursive(item.id, bool);
                    } else {
                        if (bool === false) {
                            /*向上全选*/
                            $scope.up_recursive(item.pid, bool);
                        } else {
                            /*向下全选*/
                            $scope.down_recursive(item.id, bool);
                        }
                    }
                }
            });
        };
        //倒序递归
        $scope.down_recursive = function (id, bool) {
            angular.forEach($scope.permissions, function (item) {
                if (parseInt(item.pid) === parseInt(id)) {
                    item.is_checked = !bool;
                    $scope.down_recursive(item.id, bool);
                }
            });

            return true;
        };
        //升序递归
        $scope.up_recursive = function (pid, bool) {
            angular.forEach($scope.permissions, function (item) {
                if (parseInt(item.id) === parseInt(pid)) {
                    item.is_checked = !bool;
                    $scope.up_recursive(item.pid, bool);
                }
            });

            return true;
        };
        //保存高级权限
        $scope.save_permission = function () {
            $scope.tempAllotPers = [];
            angular.forEach($scope.permissions, function (item) {
                if (item.is_checked === true) {
                    $scope.tempAllotPers.push(item.name);
                }
            });

            if (w.high_role === '' ||
                w.high_role === null ||
                w.high_role === undefined) {
                Tip.error('高级角色未定义, 权限分配失败!');

                return;
            }

            if ($scope.tempAllotPers.length === 0) {
                Tip.warning('请选择您要分配的权限!');

                return;
            }

            load.show();
            $http({
                url: '/rbac/auth/create',
                data: $.param({
                    scenario: 'allot',
                    auth_role_id: w.high_role,
                    auth_item: $scope.tempAllotPers,
                    _csrf_backend: yii.getCsrfToken()
                }),
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (result) {
                if (parseInt(result.code) === 1) {
                    Tip.success(result.message);
                    $scope.init_list(0, false);
                } else {
                    Tip.warning(result.message);
                }
                detail_object.addClass('detail');
                load.hide();
            }).error(function (errors) {
                Tip.error('服务器错误');
                detail_object.addClass('detail');
                load.hide();
            });
        };
        //分配用户模态框
        $scope.allot_user = function (role_id, role_name, is_call) {
            $scope.high_role_id = role_id;
            $scope.high_role_name = role_name;
            $scope.is_disabled_role = true;
            $scope.is_show_save = false;
            $scope.is_show_modify = true;

            if (is_call === false) {
                $scope.users = [];
                $('#user_company_label').val('').trigger('change');
                $('#user_label').val("").trigger('change');
                $('#user_modal').modal('show');
            }
        };
        //获取用户帐号
        angular.element(document).ready(function () {
            $('#user_company_label').on('change', function () {
                let company = $(this).val();
                if (company === '' || company === null || company === undefined) {
                    $scope.users = [];

                    return;
                }

                load.show();
                $http.get('/rbac/auth/users?company_id=' + company).success(function (result) {
                    if (parseInt(result.code) === 1) {
                        $scope.users = result.data;
                    } else {
                        Tip.warning('请求失败');
                    }
                    load.hide();
                }).error(function (errors) {
                    Tip.error('服务器错误');
                    load.hide();
                });
            });
        });
        //分配用户
        $scope.assign_user = function () {
            let u = $('#user_label');

            if ($scope.high_role_id === '' ||
                $scope.high_role_id === null ||
                $scope.high_role_id === undefined) {
                Tip.warning('请填写高级角色名!');

                return;
            }

            if (u.val().length === 0) {
                Tip.warning('请选择用户!');

                return;
            }

            load.show();
            $http({
                url: '/rbac/auth/assign-user',
                method: 'post',
                data: $.param({
                    scenario: 'insert',
                    roleId: $scope.high_role_id,
                    userId: u.val(),
                    _csrf_backend: yii.getCsrfToken()
                }),
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (result) {
                if (parseInt(result.code) === 1) {
                    Tip.success(result.message);
                } else {
                    Tip.warning(result.message);
                }

                $('#user_modal').modal('hide').on('hidden.bs.modal', function (e) {
                    load.hide();
                });
            }).error(function (errors) {
                Tip.error('服务器错误');
                $('#user_modal').modal('hide');
                load.hide();
            });
        };
        //查看用户
        $scope.look_assign = function (role_id) {
            load.show();
            $('#check_user_modal').modal('show');
            $http.get('/rbac/auth/check-assign?role_id=' + role_id).success(function (result) {
                if (parseInt(result.code) === 1) {
                    if (result.data === '' || result.data == null || result.data.length === 0) {
                        $scope.assign_users = [];
                        $scope.role_id = role_id;
                        $scope.user_no_data = true;
                    } else {
                        $scope.assign_users = result.data;
                        $scope.role_id = role_id;
                        $scope.user_no_data = false;
                    }
                } else {
                    $scope.role_id = role_id;
                    $scope.assign_users = [];
                    $scope.user_no_data = true;
                    Tip.warning('拉去数据失败');
                }
                load.hide();
            }).error(function (errors) {
                $scope.assign_users = [];
                $scope.role_id = role_id;
                $scope.user_no_data = true;
                Tip.error('服务器错误');
                load.hide();
            });
        };
        //查看用户 - 删除用户
        $scope.del_user = function (child_id, user_id, role_id) {
            load.show();
            $http.get('/rbac/auth/del?child_id=' + child_id + '&user_id=' + user_id).success(function (result) {
                if (parseInt(result.code) === 1) {
                    Tip.success(result.message);
                    $scope.look_assign(role_id);
                } else {
                    Tip.warning(result.message);
                }
                load.hide();
            }).error(function (errors) {
                Tip.error('服务器错误');
                load.hide();
            });
        };
        //查看权限 - 删除权限
        $scope.del_role_per = function (module_name, role_id, role_name) {
            load.show();
            $http.get(encodeURI('/rbac/auth/del-item?item_name=' + module_name + '&role_id=' + role_id)).success(function (result) {
                if (parseInt(result.code) === 1) {
                    Tip.success(result.message);
                    $scope.look_per(role_id, role_name);
                } else {
                    Tip.warning(result.message);
                }
                load.hide();
            }).error(function (errors) {
                Tip.error('服务器错误');
                load.hide();
            });
        };
        //增加权限
        $scope.add_per = function (role_id, role_name) {
            load.show();
            $('#option_menu').val('').trigger('change');
            $scope.add_role_name = role_name;
            $http.get('/rbac/auth/menu').success(function (result) {
                if (parseInt(result.code) === 1) {
                    $scope.add_per_data = result.data;
                    $scope.add_role_id = role_id;
                } else {
                    $scope.add_per_data = [];
                    $scope.add_role_id = role_id;
                    Tip.warning('数据拉去失败');
                }
                load.hide();
            }).error(function (errors) {
                $scope.add_per_data = [];
                $scope.add_role_id = role_id;
                Tip.error('服务器错误');
                load.hide();
            });
        };
        //增加权限 - 选择权限
        $scope.new_add_per = function (role_id) {
            let tmi = $('#option_menu');
            $scope.select_pers = [];
            if (role_id === '') {
                Tip.warning('角色不能为空!');

                return;
            }

            if (tmi.val() === null || tmi.val() === '') {
                Tip.warning('请选择菜单!');

                return;
            }

            $('#add_permission').modal('hide');
            $('#new_permission').modal('show');
            load.show();
            $http.get('/rbac/auth/per?module_id=' + tmi.val() + '&role_id=' + role_id).success(function (result) {
                if (parseInt(result.code) === 1) {
                    angular.forEach(result.data, function (item) {
                        item.isSelect = false;
                    });
                    $scope.select_pers = result.data;
                    $scope.select_per_role = role_id;
                } else {
                    Tip.warning('数据拉去失败');
                    $scope.select_pers = [];
                    $scope.select_per_role = role_id;
                }
                load.hide();
            }).error(function (errors) {
                $scope.select_pers = [];
                $scope.select_per_role = role_id;
                Tip.error('服务器错误');
                load.hide();
            });
        };
        //增加权限 - 选择权限 - 全选、全不选
        $scope.is_select = function (bool) {
            angular.forEach($scope.select_pers, function (item) {
                if (parseInt(item.is_disabled) !== 1) {
                    item.isSelect = !bool;
                }
                $scope.is_new_bool = !bool;
            });
        };
        //增加权限 - 选择权限 - 点击列表
        $scope.select_one = function (per_id, bool) {
            angular.forEach($scope.select_pers, function (item) {
                if (parseInt(item.id) === parseInt(per_id) && parseInt(item.is_disabled) !== 1) {
                    item.isSelect = !bool;
                    if (parseInt(item.pid) === 0) {
                        /*向下全选*/
                        $scope.bottom_recursive(item.id, bool);
                    } else {
                        if (bool === false) {
                            /*向上全选*/
                            $scope.top_recursive(item.pid, bool);
                        } else {
                            /*向下全选*/
                            $scope.bottom_recursive(item.id, bool);
                        }
                    }
                }
            });
        };
        //倒序递归
        $scope.bottom_recursive = function (id, bool) {
            angular.forEach($scope.select_pers, function (item) {
                if (parseInt(item.pid) === parseInt(id) && parseInt(item.is_disabled) !== 1) {
                    item.isSelect = !bool;
                    $scope.bottom_recursive(item.id, bool);
                }
            });

            return true;
        };
        //升序递归
        $scope.top_recursive = function (pid, bool) {
            angular.forEach($scope.select_pers, function (item) {
                if (parseInt(item.id) === parseInt(pid) && parseInt(item.is_disabled) !== 1) {
                    item.isSelect = !bool;
                    $scope.top_recursive(item.pid, bool);
                }
            });

            return true;
        };
        //增加权限 - 保存权限
        $scope.save_pers = function (role_id) {
            $scope.tempNewPers = [];
            angular.forEach($scope.select_pers, function ($item) {
                if ($item.isSelect === true) {
                    $scope.tempNewPers.push($item.name);
                }
            });

            if (role_id === '' || role_id === null || role_id === undefined) {
                Tip.error('角色未定义, 权限无法分配!');

                return;
            }

            if ($scope.tempNewPers.length === 0) {
                Tip.warning('请点击选择您要分配的权限!');

                return;
            }

            load.show();
            $http({
                url: '/rbac/auth/create',
                data: $.param({
                    scenario: 'allot',
                    auth_role_id: role_id,
                    auth_item: $scope.tempNewPers,
                    _csrf_backend: yii.getCsrfToken()
                }),
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}
            }).success(function (result) {
                if (parseInt(result.code) === 1) {
                    Tip.success(result.message);
                    $scope.look_per(role_id, $scope.add_role_name);
                } else {
                    Tip.warning(result.message);
                }

                $('#new_permission').modal('hide').on('hidden.bs.modal', function (e) {
                    load.hide();
                });

            }).error(function (errors) {
                Tip.error('服务器错误');
                $('#new_permission').modal('hide');
                load.hide();
            });
        };
        //查看场馆
        $scope.view_venue = function (role_id, is_init) {
            load.show();
            if (is_init) {
                $scope.venue_details = [];
                $scope.venue_role_id = '';
            }

            $http.get('/rbac/auth/venues?role_id=' + role_id).success(function (result) {
                if (parseInt(result.code) === 1) {
                    $scope.venue_details = result.data;
                    $scope.venue_role_id = role_id;
                } else {
                    Tip.warning('请求失败');
                    $scope.venue_details = [];
                    $scope.venue_role_id = '';
                }
                load.hide();
            }).error(function (errors) {
                Tip.error('服务器错误');
                $scope.venue_details = [];
                $scope.venue_role_id = '';
                load.hide();
            });
        };
        //删除场馆
        $scope.del_venue = function (role_id, venue_id) {
            load.show();
            $http.get('/rbac/auth/del-venue?role_id=' + role_id + '&venue_id=' + venue_id).success(function (result) {
                if (parseInt(result.code) === 1) {
                    Tip.success(result.message);
                } else {
                    Tip.warning(result.message);
                }
                load.hide();
                $scope.view_venue(role_id, false);
            }).error(function (errors) {
                Tip.error('服务器错误');
                load.hide();
                $scope.view_venue(role_id, false);
            });
        };
        //选择场馆
        $scope.get_venue = function (role_id) {
            $scope.get_venue_data = [];
            $('#stadium_label').val("").trigger('change');
            load.show();
            $http.get('/rbac/auth/get-venue?role_id=' + role_id).success(function (result) {
                if (parseInt(result.code) === 1) {
                    $scope.get_venue_data = result.data;
                } else {
                    Tip.warning(result.message);
                    $scope.get_venue_data = [];
                }
                load.hide();
            }).error(function (errors) {
                Tip.error('服务器错误');
                $scope.get_venue_data = [];
                load.hide();
            });
        };
        //新增场馆
        $scope.add_venue = function (role_id) {
            $scope.role_venue_ids = $('#stadium_label').val();
            if (role_id === '' || role_id === null) {
                Tip.warning('角色ID不存在');
                return;

            }

            if ($scope.role_venue_ids === null ||
                $scope.role_venue_ids.length === 0 ||
                $scope.role_venue_ids === undefined) {
                Tip.warning('场馆不能为空');
                return;

            }

            load.show();
            $http({
                url: '/rbac/auth/add-venue',
                method: 'POST',
                data: $.param({
                    role_id: role_id,
                    venue_ids: $scope.role_venue_ids,
                    _csrf_backend: yii.getCsrfToken()
                }),
                headers: {"Content-Type": "application/x-www-form-urlencoded"}
            }).success(function (result) {
                if (parseInt(result.code) === 1) {
                    Tip.success(result.message);
                } else {
                    Tip.warning(result.message);
                }

                $scope.view_venue(role_id, false);
                $('#check-venue').modal('hide').on('hidden.bs.modal', function (e) {
                    load.hide();
                });
            }).error(function (errors) {
                Tip.error('服务器错误');
                load.hide();
                $scope.view_venue(role_id, false);
                $('#check-venue').modal('hide');
            });
        };
        //修改角色名
        $scope.modifyRoleName = function () {
            $scope.is_show_modify = false;
            $scope.is_show_save = true;
            $scope.is_disabled_role = false;
        };
        //保存角色名
        $scope.saveRoleName = function (role_id, role_name) {
            if (role_name === '' || role_name === undefined) {
                Tip.warning('请填写角色名!');

                return;
            }

            if (role_id === '' || role_id === undefined) {
                Tip.warning('角色ID不能为空!');

                return;
            }

            load.show();
            $http({
                url: '/rbac/auth/modify-role',
                data: $.param({
                    scenario: 'modify',
                    role_id: role_id,
                    role_name: role_name,
                    _csrf_backend: yii.getCsrfToken(),
                }),
                method: 'POST',
                headers: {"Content-Type": "application/x-www-form-urlencoded"}
            }).success(function (result) {
                if (parseInt(result.code) === 1) {
                    $scope.allot_user(role_id, role_name, true);
                    $scope.init_list(0, false);
                    $scope.init_list(1, false);
                    Tip.success(result.message);
                } else {
                    Tip.warning(result.message);
                }
                load.hide();
            }).error(function (errors) {
                Tip.error('服务器错误');
                load.hide();
            });
        };
        //修改未分配权限的角色
        $scope.unModifyRole = function (role_id) {
            let ele_modify_company = $('#modify_company_label'),
                ele_modify_roles = $('#modify_roles_label');
            $scope.modify_role_name = '';
            $scope.modify_role_id = '';
            $scope.is_derive_disabled = true;
            ele_modify_company.val("").trigger('change');
            ele_modify_roles.val("").trigger('change');
            load.show();
            $http.get('/rbac/auth/role-detail?role_id=' + role_id).success(function (result) {
                if (parseInt(result.code) === 1) {
                    $scope.modify_role_name = result.data.name;
                    $scope.modify_role_id = result.data.id;
                    $scope.is_derive_disabled = result.data.is_derive_disabled;
                    ele_modify_company.val(result.data.company_id).trigger('change');
                    ele_modify_roles.val(result.data.derive_id).trigger('change');
                } else {
                    Tip.warning(result.message);
                }
                load.hide();
            }).error(function (errors) {
                Tip.error('服务器错误');
                load.hide();
            });
        };
        //保存修改
        $scope.saveModifyRole = function (role_id) {
            let ele_modify_company = $('#modify_company_label'),
                ele_modify_roles = $('#modify_roles_label');
            if ($scope.modify_role_name === '' || $scope.modify_role_name === null) {
                Tip.warning('请填写角色!');

                return;
            }

            if (ele_modify_company.val() === null || ele_modify_company.val() === '') {
                Tip.warning('请选择公司!');

                return;
            }

            if (ele_modify_roles.val() === null || ele_modify_roles.val() === '') {
                Tip.warning('请选择派生角色!');

                return;
            }

            if (role_id === null || role_id === '' || role_id === undefined) {
                Tip.warning('角色ID不能为空!');

                return;
            }

            load.show();
            $http({
                url: '/rbac/auth/saver',
                data: $.param({
                    scenario: 'un_modify',
                    role_id: role_id,
                    role_name: $scope.modify_role_name,
                    company_id: ele_modify_company.val(),
                    derive_id: ele_modify_roles.val(),
                    _csrf_backend: yii.getCsrfToken(),
                }),
                method: 'POST',
                headers: {"Content-Type": "application/x-www-form-urlencoded"},
            }).success(function (result) {
                if (parseInt(result.code) === 1) {
                    Tip.success(result.message);
                    $scope.init_list(0, false);
                    $scope.init_list(1, false);
                } else {
                    Tip.warning(result.message);
                }

                $('#modify-role').modal('hide').on('hidden.bs.modal', function (e) {
                    load.hide();
                });

            }).error(function (errors) {
                Tip.error('服务器错误');
                load.hide();
                $('#modify-role').modal('hide');
            });
        };
    }]).filter('html_filter', ['$sce', function ($sce) {
        return function (val) {
            return $sce.trustAsHtml(val);
        }
    }]);
}(jQuery, window);