<?php

namespace backend\rbac;

use backend\rbac\cores\PublicAbstraction;

final class Config extends PublicAbstraction
{
    /**
     * backend/config/main.php文件配置
     *
     * //配置yii2 rbac
     * 'authManager' => [
     * 'class' => 'yii\rbac\DbManager',
     * ],
     *
     * //配置access control 访问控制
     * 'as permission' => 'backend\\rbac\\PermissionBehaviors',
     *
     * //注册模块
     * 'rbac' => [
     * 'class' => 'backend\\rbac\\Module',
     * ],
     * ---------------------------------------------------
     * //模块迁移配置
     * backend/console/config/main.php components模块中配置:
     * 'authManager' => [
     * 'class' => 'yii\rbac\DbManager',
     * ],
     *
     * //模块迁移命令
     * yii migrate --migrationPath=@backend/rbac/migrations;
     *
     * //页面元素是否隐藏
     * @return boolean
     * @method \backend\rbac\Config::isShow(控件路由)
     *
     * #example
     * <?php if(\backend\rbac\Config::isShow('check-card/check-card-number')): ?>
     * <div class="btn-group">
     * <button class="btn btn-sm btn-default">新增会员</button>
     * </div>
     * <?php endif; ?>
     *
     * //access control 访问控制
     * @file PermissionBehaviors.php
     * @desc <未添加基础角色的菜单或按钮> 不受访问控制 即: <公共路由和辅助路由>不添加权限限制!!
     *       <拥有此菜单或按钮权限的用户> 不受访问控制
     * @method accessControl
     * @return \redirect 302 | JSON(string)
     *
     * //获取项目用户可访问的菜单接口:
     * /rbac/auth/top  //@method GET
     *
     * //用户表模版
     * m180716_083904_create_user
     * //公司组织表模版
     * m180716_083841_create_organization
     *
     * //获取用户有权访问的公司(返回值: 一维数组 id)
     * \backend\rbac\Config::accessCompany();
     *
     * //获取用户有权访问的场馆(返回值: 一维数组 id)
     * \backend\rbac\Config::accessVenues();
     *
     * //获取用户有权访问的公司(返回值: 二维数组 name, id)
     * \backend\rbac\Config::companies();
     *
     * //二级联动 - 通过公司获取场馆 (返回值: 二维数组 name, id)
     * \backend\rbac\Config::venues();
     */

    //配置菜单制表符右
    protected static $_V = "└─";

    //配置菜单制表符左
    protected static $_A = "&emsp;&nbsp;&nbsp;";

    //配置公司组织数据模型
    public static $organization = '\common\models\Organization';

    //配置用户表
    public static $admin = '\common\models\Admin';

    //配置views主模版文件
    public static $layout = '@backend/views/layouts/admin.php';

    //配置项目依赖静态文件类
    //Rbac模块核心依赖(必引入) : angular.js 、bootstrap.js 、bootstrap.css 、bootstrapSelect2.js 、
    public static $assets = [
        'backend\\assets\\AdminAsset',
        'backend\\assets\\AngularAsset',
        'backend\\assets\\LaddaAsset',
        'backend\\assets\\BootstrapSelectAsset',
        'backend\\assets\\CommonAsset',
    ];
    //配置静态文件源路径
    public static $sourcePath = '@backend/rbac/plugins';

    //配置非注册用户登录302路由
    public static $loginUrl = '/site/login';

    //配置无权限404路由
    public static $noAccessRoute = '/site/error';

    //配置common.js (RBAC加载遮罩框、提示语(提供项目配置接口)等)
    public static $publicJs = 'public.js';

    //配置common.css (提示语、公共css样式等)
    public static $publicCss = 'public.css';

    //配置项目核心模块ID
    public static $mainModule = 'app-backend';

    //配置项目RBAC模块ID
    public static $rbacModule = 'rbac';

    //配置超级管理员 /*@desc 科技公司分配权限帐号*/
    public static $USA = [
        'admin',
    ];

    //配置用户正常状态
    public static $status = 20;

    //配置超级管理员可获取的一级菜单
    public static $rbacModuleName = [
        '系统管理',
    ];

    //配置超级管理员可访问路由(页面元素显示路由)
    public static $rbacModuleRoute = [
        //除rbac服务模块路由
        'main/index',
        'personnel/index',
    ];

    /**
     * @describe 获取用户有权访问的公司 (返回值: 二维数组 name, id)
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-02
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function companies()
    {
        $organization = self::$organization;
        $model = $organization::find()
            ->select(['id', 'name'])
            ->where(['pid' => 0]);

        $company = Config::c();
        if ($company instanceof \Exception) {
            return [];
        }

        $data = $model->andFilterWhere(['id' => $company])->asArray()->all();
        return $data;
    }

    /**
     * @describe 二级联动 - 通过公司获取场馆 (返回值: 二维数组 name, id)
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-02
     * @param $company
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function venues($company)
    {
        $organization = self::$organization;
        $model = $organization::find()->select(['id', 'name']);
        if (!isset($company) || empty($company)) {
            return [];
        }

        $data = $model->where(['pid' => $company])->asArray()->all();
        return $data;
    }

    /**
     * @describe 项目接口 - 获取用户有权访问的公司 (返回值: 一维数组 id)
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-27
     * @return array|mixed
     */
    public static function accessCompany()
    {
        // TODO: Implement accessCompany() method.
        $company = Config::c();
        if ($company instanceof \Exception) {
            /* 项目异常 */
            return [];

        } elseif ($company === null) {
            /* 超管 */
            $organization = Config::$organization;
            $ids_arr = $organization::find()->select('id')->where(['pid' => 0])->asArray()->all();
            return array_column($ids_arr, 'id');

        } else {
            return [$company];

        }
    }

    /**
     * @describe 项目接口 - 获取用户有权访问的场馆 (返回值: 一维数组 id)
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-27
     * @return array
     */
    public static function accessVenues()
    {
        // TODO: Implement accessVenues() method.
        $venues = Config::c(true);
        if ($venues instanceof \Exception) {
            /* 项目异常 */
            return [];
        }

        return $venues;
    }

    /**
     * @describe 获取未分配高级角色的用户
     * @author <yanghuilei@itsport.club>
     * @param $company_id
     * @createAt 2018-07-03
     * @return mixed|\yii\db\ActiveRecord
     */
    public static function allUsers($company_id)
    {
        $admin = self::$admin;
        $data = $admin::find()
            ->select(['id', 'username'])
            ->where([
                'status' => self::$status,
                'company_id' => $company_id
            ])
            ->asArray()
            ->all();
        $allot_users = self::allotUsers($company_id);
        $users = array_reduce($data, function ($result, $item) use ($allot_users) {
            if (!in_array($item['id'], $allot_users)) {
                array_push($result, $item);

                return $result;
            }

            return $result;
        }, []);

        return $users;
    }

    /**
     * @describe 获取关联关系中, 参数一:主表的类名
     * @author <yanghuilei@itsport.club>
     * @param $int
     * @desc  1 : organization (组织表)
     * @createAt 2018-07-04
     * @return string
     */
    public static function getRelations($int)
    {
        switch ($int) {
            case 1:
                $organization = self::$organization;
                return $organization::className();

            case 2:
                $user = self::$admin;
                return $user::className();

            default:
                return '';
        }
    }
}