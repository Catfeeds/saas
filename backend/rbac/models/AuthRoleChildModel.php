<?php
/**
 * Created by PhpStorm.
 * User: 杨慧磊
 * Date: 2018/7/3 0003
 * Time: 上午 10:50
 */

namespace backend\rbac\models;

use backend\rbac\Config;
use backend\rbac\models\base\AuthRoleChild;
use backend\rbac\Relation;

class AuthRoleChildModel extends AuthRoleChild
{
    use Relation;

    /**
     * @describe 已分配角色的用户
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-04
     * @param $role_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function checkAssignedHighRoleUsers($role_id)
    {
        return AuthRoleChildModel::find()
            ->alias('a')
            ->joinWith(['user u'], false)
            ->select(['a.id child_id', 'a.user_id', 'u.username'])
            ->where(['a.role_id' => $role_id])
            ->asArray()
            ->all();
    }

    /**
     * @describe 获取用户可访问的菜单
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-17
     * @param $user_id
     * @return array
     */
    public function getTopMenuByUserIdentify($user_id)
    {
        $admin = Config::$admin;
        $admin_model = $admin::findOne($user_id);
        if (!is_object($admin_model) || (int)$admin_model->status !== Config::$status) {
            return [];
        }

        $child_model = AuthRoleChildModel::findOne(['user_id' => $user_id]);
        if (!is_object($child_model)) {
            $username = $admin_model->username;
            if (in_array($username, Config::$USA)) {
                $top = $this->getPermissionsOfAdmin(['name' => Config::$rbacModuleName]);
                if (empty($top)) {
                    return [];
                }

                $top_id = array_column($top, 'id');
                $bottom = $this->getPermissionsOfAdmin(['pid' => $top_id]);

                return $this->middlewareHandler($top, $bottom);
            }

            return [];
        }

        $role_id = $child_model->role_id;
        if (empty($role_id)) {
            return [];
        }

        $top_menu = $this->getAssignModuleByWhere(['i.role_id' => $role_id, 'm.pid' => 0]);
        if (empty($top_menu)) {
            return [];
        }

        $top_menu_id = array_column($top_menu, 'id');
        $junior = $this->getAssignModuleByWhere(['i.role_id' => $role_id, 'm.pid' => $top_menu_id]);

        return $this->middlewareHandler($top_menu, $junior);
    }

    /**
     * @describe 获取admin用户下的访问权限
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-23
     * @param $where
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getPermissionsOfAdmin($where)
    {
        $top = AuthModuleModel::find()->select(['id', 'pid', 'name', 'route', 'icon'])->where($where)->asArray()->all();

        return $top;
    }

    /**
     * @describe 获取用户可访问的菜单, 中间处理程序
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-23
     * @param $top_menu
     * @param $junior
     * @return mixed
     */
    public function middlewareHandler($top_menu, $junior)
    {
        foreach ($top_menu as $a => $b) {
            foreach ($junior as $c => $d) {
                if ($d['pid'] == $b['id']) {
                    unset(
                        $top_menu[$a]['id'],
                        $top_menu[$a]['pid'],
                        $d['id'],
                        $d['pid']
                    );

                    $top_menu[$a]['module'][] = $d;
                }
            }

            if (!isset($top_menu[$a]['module'])) {
                $top_menu[$a]['module'] = [];
            }
        }

        return $top_menu;
    }

    /**
     * @describe 关联角色权限表, 通过搜索条件获取模块数据
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-17
     * @param $where
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAssignModuleByWhere($where)
    {
        $module = AuthRoleItemModel::find()
            ->alias('i')
            ->joinWith('module m', false)
            ->select(['m.id', 'm.pid', 'm.name', 'm.route', 'm.icon'])
            ->where($where)
            ->asArray()
            ->all();

        return $module;
    }
}