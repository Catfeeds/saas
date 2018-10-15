<?php

namespace backend\rbac\models;

use backend\rbac\Config;
use backend\rbac\models\base\AuthRole;
use backend\rbac\Relation;

class AuthRoleModel extends AuthRole
{

    use Relation;

    /**
     * @describe 高级角色列表
     * @author <yanghuilei@itsport.club>
     * @param $isOption
     * @createAt 2018-07-02
     * @return array
     */
    public function getAllSeniorRole($isOption)
    {
        $company = Config::companies();
        if (empty($company)) {
            return [];
        }

        $company_ids = array_filter(array_unique(array_column($company, 'id')));
        $model = AuthRoleModel::find()
            ->alias('a')
            ->joinWith(['company c'], false)
            ->select([
                'a.id',
                'a.name',
                'a.company_id',
                'a.derive_id',
                'a.status',
                'c.name company_name'
            ])
            ->where(['a.company_id' => $company_ids])
            ->asArray()
            ->all();

        $prefix = false;
        if ($isOption == true) {
            $prefix = true;
        }

        return Config::recursive($model, 0, 0, 'derive_id', $prefix);
    }

    /**
     * @describe 分配权限 - 获取权限列表
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-02
     * @param $highRole
     * @param $deriveId
     * @return array|bool
     */
    public function getIsAllotBasicRoles($highRole, $deriveId)
    {
        if ($deriveId == 0) {
            $isAllots = AuthModuleModel::find()->where(['status' => 1])->asArray()->all();
            return Config::recursive($isAllots, 0, 0, 'pid');

        } else {
            $roleId = AuthRoleModel::findOne($highRole)->derive_id;
            $status = AuthRoleModel::findOne($roleId)->status;
            if ($status === 2) {
                return false;

            } else {
                $data = AuthRoleItemModel::find()->alias('a')
                    ->joinWith(['module m'], false)
                    ->select(['m.id', 'm.name', 'm.pid'])
                    ->where(['a.role_id' => $roleId])
                    ->orderBy('m.id ASC')
                    ->asArray()
                    ->all();
                if (empty($data)) {
                    return false;

                }

                return Config::recursive($data, 0, 0, 'pid');
            }
        }
    }

    /**
     * @describe 角色列表 - 场馆详情
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-24
     * @param $role_id
     * @return array
     */
    public function getVenuesDetailOfRole($role_id)
    {
        $model = AuthRoleModel::findOne($role_id);
        if (empty($model)) {
            return [];
        }

        $venues = json_decode($model->venue_id, true);

        return $this->getVenueIdByOrganization(['id' => $venues], ['name', 'id']);
    }

    /**
     * @describe 角色列表 - 场馆详情 - 删除场馆 | 新增场馆
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-24
     * @param $role_id
     * @param $venue_id
     * @param $is_add
     * @return bool
     */
    public function delAndAddVenueOfRole($role_id, $venue_id, $is_add = false)
    {
        $model = AuthRoleModel::findOne($role_id);
        if (empty($model)) {
            return false;
        }

        $venues = json_decode($model->venue_id, true);
        if ($is_add === false && !in_array($venue_id, $venues)) {
            return false;
        }

        if ($is_add === false) {
            if (count($venues) === 1) {
                return null;
            }

            $new_venues = array_diff($venues, [$venue_id]);
            $model->venue_id = json_encode($new_venues);
        }

        if ($is_add === true && array_intersect($venues, $venue_id)) {
            return false;
        }

        if ($is_add === true) {
            $new_venues = array_merge($venues, $venue_id);
            $model->venue_id = json_encode($new_venues);
        }

        if ($model->save()) {
            return true;
        }

        return false;
    }

    /**
     * @describe 角色列表 - 场馆详情 - 新增场馆 - 获取场馆
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-24
     * @param $role_id
     * @return array
     */
    public function getVenuesOfRole($role_id)
    {
        $model = AuthRoleModel::findOne($role_id);
        if (empty($model)) {
            return [];
        }

        $company = $model->company_id;
        $venue = json_decode($model->venue_id, true);
        if (empty($company)) {
            return [];
        }

        if (empty($venue)) {
            $venue = [];
        }

        $data = $this->getVenueIdByOrganization(['pid' => $company], ['id']);
        $all_venue_ids = array_filter(array_unique(array_column($data, 'id')));
        $new_venue_ids = array_diff($all_venue_ids, $venue);
        if (empty($new_venue_ids)) {
            return [];
        }

        return $this->getVenueIdByOrganization(['id' => $new_venue_ids], ['name', 'id']);
    }

    /**
     * @describe 中间件 - 获取组织机构
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-24
     * @param $where
     * @param $select
     * @return mixed
     */
    public function getVenueIdByOrganization($where, $select)
    {
        $organization = Config::$organization;
        $data = $organization::find()->select($select)->where($where)->asArray()->all();

        return $data;
    }

    /**
     * @describe 通过角色ID获取角色详情
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-25
     * @param $role_id
     * @return array
     */
    public function getRoleDetailById($role_id)
    {
        $model = AuthRole::findOne($role_id);
        $role = AuthRole::findOne(['derive_id' => $role_id]);

        $is_derive_disabled = true;
        if (empty($role)) {
            $is_derive_disabled = false;
        }

        $attributes = $model->attributes;
        $attributes['is_derive_disabled'] = $is_derive_disabled;

        return $attributes;
    }
}