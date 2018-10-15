<?php

namespace backend\rbac\cores;

use backend\rbac\Config;
use backend\rbac\models\AuthModuleModel;
use backend\rbac\models\AuthRoleChildModel;
use backend\rbac\models\AuthRoleModel;
use Yii;

abstract class PublicAbstraction implements ItemInterface
{
    protected static $_V = '┠';
    protected static $_A = '┈┈';

    /**
     * @describe 获取已分配高级角色的用户
     * @author <yanghuilei@itsport.club>
     * @param $company_id
     * @createAt 2018-07-03
     * @return array
     */
    public static function allotUsers($company_id)
    {
        $data = AuthRoleChildModel::find()
            ->alias('a')
            ->joinWith(['role r'], false)
            ->where(['r.company_id' => $company_id])
            ->asArray()
            ->all();

        return array_unique(array_column($data, 'user_id'));
    }

    /**
     * @describe 路由是否添加基础权限
     *       <<此方法可以被重载>>
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-03
     * @param $route
     * @return bool
     */
    public static function isIn($route)
    {
        return Yii::$app->getAuthManager()->getPermission($route) ? true : false;
    }

    /**
     * @describe 模版按钮是否显示
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-03
     * @param $route
     * @return bool
     */
    public static function isShow($route)
    {
        $user = Yii::$app->user;
        if (empty($user)) {
            return false;
        }

        $identify = $user->identity;
        if (empty($identify)) {
            return false;
        }

        $username = $identify->username;
        if (in_array($username, Config::$USA) &&
            (preg_match("/^rbac\/[a-z]+\/[a-z]+$/i", $route) ||
                in_array($route, Config::$rbacModuleRoute))) {
            return true;

        }

        $user_per = $user->can($route);
        $is_in = static::isIn($route);
        if ($user_per || !$is_in) {
            return true;
        }

        return false;
    }

    /**
     * @describe 递归序列化父子级(数组)
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-26
     * @param $modules
     * @param $pid
     * @param $step
     * @param $relation
     * @param array $menu
     * @param $isOption
     * @return array
     */
    public static function recursive($modules, $pid, $step, $relation, $isOption = false, &$menu = [])
    {
        foreach ($modules as $key => $item) {
            if ($item[$relation] == $pid) {
                if ($isOption === false) {
                    $repeat_str = str_repeat(static::$_A, $step);
                    if ($step == 0) {
                        $repeat_str = '';
                    } else {
                        $repeat_str .= static::$_V;
                    }
                } else {
                    $repeat_str = str_repeat(self::$_V . self::$_A, $step);
                }
                $item['prefix'] = $repeat_str;
                $menu[] = $item;
                static::recursive($modules, $item['id'], $step + 1, $relation, $isOption, $menu);
            }
        }

        return $menu;
    }

    /**
     * @describe 递归序列化父子级(Sql)
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-09
     * @param $id
     * @param $step
     * @param $isOption
     * @param $select
     * @param $where
     * @param array $menu
     * @return array
     */
    public static function recursiveBySql($id, $step, $where = ['status' => null], $select = ['id', 'name', 'pid'], $isOption = false, $menu = [])
    {
        global $menu;
        if ($step === 0) {
            $model = AuthModuleModel::find()->select($select)->where(['id' => $id]);
            $items = $model->andFilterWhere($where)->asArray()->all();
        } else {
            $model = AuthModuleModel::find()->select($select)->where(['pid' => $id]);
            $items = $model->andFilterWhere($where)->asArray()->all();
        }

        foreach ($items as $key => $item) {
            if ($isOption === false) {
                $repeat_str = str_repeat(static::$_A, $step);
                if ($step == 0) {
                    $repeat_str = '';
                } else {
                    $repeat_str .= static::$_V;
                }
            } else {
                $repeat_str = str_repeat(self::$_V . self::$_A, $step);
            }
            $item['prefix'] = $repeat_str;
            $menu[] = $item;
            static::recursiveBySql($item['id'], $step + 1, $where, $select, $isOption, $menu);
        }

        return $menu;
    }

    /**
     * @describe 前系统用户可访问的公司或场馆
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-27
     * @param bool $is_venue
     * @return \Exception|int|mixed
     */
    public static function c($is_venue = false)
    {
        try {
            $user_middleware = Yii::$app->getUser();
            if (!is_object($user_middleware)) {
                throw new \Exception("This is an unregistered user");

            }

            $user = $user_middleware->getIdentity();
            if (!is_object($user)) {
                throw new \Exception("User authentication expired");

            }

            $user_id = $user->getId();
            $user_name = $user->username;
            if (in_array($user_name, Config::$USA)) {
                /* 超管 - 公司 */
                if ($is_venue === false) {
                    return null;
                }

                /* 超管 - 场馆 */
                $companies = Config::companies();
                $company_ids = array_filter(array_unique(array_column($companies, 'id')));
                $organization = Config::$organization;
                $venues = $organization::find()->where(['pid' => $company_ids])->asArray()->all();

                return array_column($venues, 'id');
            }

            $model = AuthRoleChildModel::findOne(['user_id' => $user_id]);
            if (!is_object($model)) {
                throw new \Exception("The user does not assign roles");

            }

            $role_id = $model->role_id;
            $auth_role_model = AuthRoleModel::findOne($role_id);
            if ($is_venue === false) {
                $company = $auth_role_model->company_id;
                return $company;

            }

            $venues = $auth_role_model->venue_id;
            return json_decode($venues, true);

        } catch (\Exception $e) {
            return $e;

        }
    }

    /**
     * @describe 是否响应HTML
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-11
     * @param $route
     * @return bool
     */
    public static function isHtml($route)
    {
        $module = AuthModuleModel::findOne(['route' => $route]);
        if (empty($module)) {
            return true;
        }

        return $module->response_type == 1 ? true : ($module->response_type == 2 ? false : true);
    }
}