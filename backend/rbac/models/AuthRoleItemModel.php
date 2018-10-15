<?php
/**
 * Created by PhpStorm.
 * User: 杨慧磊
 * Date: 2018/7/2 0002
 * Time: 下午 3:54
 */

namespace backend\rbac\models;

use backend\rbac\Config;
use backend\rbac\models\base\AuthRoleItem;
use backend\rbac\Relation;

class AuthRoleItemModel extends AuthRoleItem
{

    use Relation;

    /**
     * @describe 查看权限
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-03
     * @param $roleId
     * @return array
     */
    public function checkPermissions($roleId)
    {
        $data = AuthRoleItemModel::find()->alias('a')
            ->joinWith(['module m'], false)
            ->select(['m.id', 'm.name', 'm.pid'])
            ->where(['a.role_id' => $roleId])
            ->orderBy('m.id ASC')
            ->asArray()
            ->all();

        return $data;
    }

    /**
     * @describe 获取分配此权限的高级角色
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-05
     * @param $basic_role_name
     * @return mixed
     */
    public function getHighRoleOfBasicRole($basic_role_name)
    {
        $model = AuthRoleItemModel::find()->alias('a')
            ->joinWith(['role r' => function ($query) {
                $query->joinWith(['company c']);
            }], false)
            ->where([
                'a.auth_item' => $basic_role_name,
            ])
            ->select(['r.name role_name', 'c.name company_name']);

        return self::middleware($model, 'c.id');
    }

    /**
     * @describe 获取分配此权限的所有用户
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-05
     * @param $module_name
     * @return mixed
     */
    public function getUserOfBasicRole($module_name)
    {
        $authItem = AuthRoleItemModel::find()
            ->alias('a')
            ->joinWith(['role r' => function ($query) {
                $query->joinWith(['company c']);
                $query->joinWith(['roleChild rc' => function ($query) {
                    $query->joinWith(['user u']);
                }]);
            }], false)
            ->select(['u.username', 'c.name company_name'])
            ->where(['a.auth_item' => $module_name])
            ->andWhere(['not', ['u.username' => null]]);

        return self::middleware($authItem, 'r.company_id');
    }

    /**
     * @describe 中间方法 - 过滤公司组织
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-05
     * @param $model
     * @param $relation
     * @return mixed
     */
    private static function middleware($model, $relation)
    {
        $company = Config::c();
        if ($company instanceof \Exception) {

            return [];
        } else {

            $data = $model->andFilterWhere([$relation => $company])->asArray()->all();
            return $data;
        }
    }

    /**
     * @describe 查看权限 - 删除时, 判断是否有子权限
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-13
     * @param $item_name
     * @param $role_id
     * @return bool
     */
    public function isParentPermission($item_name, $role_id)
    {
        $model = AuthRoleItemModel::find()
            ->alias('r')
            //临时数据类型转换 string => array
            ->joinWith('module m', false);
        $all_data = $model->select('m.*')
            ->where(['r.role_id' => $role_id])
            ->asArray()
            ->all();

        $one_data = $model->select('m.*')
            ->where(['r.role_id' => $role_id, 'r.auth_item' => $item_name])
            ->asArray()
            ->all();

        if (empty($one_data) || empty($all_data)) {
            return false;
        }

        $one = array_column($one_data, 'id');
        $all = array_column($all_data, 'pid');
        $intersect = array_intersect($one, $all);

        return empty($intersect) ? true : false;
    }
}