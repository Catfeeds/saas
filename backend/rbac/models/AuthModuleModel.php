<?php

namespace backend\rbac\models;

use backend\rbac\Config;
use backend\rbac\models\base\AuthModule;
use backend\rbac\Relation;

class AuthModuleModel extends AuthModule
{
    use Relation;

    /**
     * @describe 模块列表
     * @author <yanghuilei@itsport.club>
     * @param $isOption
     * @createAt 2018-06-26
     * @return array
     */
    public function getAuthModuleRecursive($isOption)
    {
        $select = [
            'id',
            'pid',
            'name',
            'route',
            'icon',
            'desc',
            'response_type',
            'status'
        ];
        $prefix_type = false;

        if ($isOption == true) {
            $select = ['id', 'pid', 'name'];
            $prefix_type = true;
        }

        $modules = $this->getAllModules($select);
        return Config::recursive($modules, 0, 0, 'pid', $prefix_type);
    }

    /**
     * @describe 模块列表
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-27
     * @param $select
     * @param null $status
     * @return array|\yii\db\ActiveRecord[]
     */
    private function getAllModules($select, $status = null)
    {
        $auth = AuthModuleModel::find()->select((array)$select); /* 临时转换数据类型 */
        $auth->andFilterWhere(['status' => $status]);

        return $auth->asArray()->all();
    }

    /**
     * @describe 修改模块
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-04
     * @param $module_id
     * @param $option 0|1
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getOneModule($module_id, $option = 0)
    {
        if($option){
            $data = AuthModuleModel::find()
                ->select([
                    'id',
                    'name',
                    'route',
                    'icon',
                    'desc',
                    'response_type'
                ])
                ->where(['id' => $module_id])
                ->asArray()
                ->one();
        }else{
            $data = AuthModuleModel::find()
                ->select([
                    'id',
                    'pid',
                    'name',
                    'route',
                    'icon',
                    'desc',
                    'response_type'
                ])
                ->where(['id' => $module_id])
                ->asArray()
                ->one();
            if (AuthModuleModel::findOne(['pid' => $module_id])) {
                $data['if_type'] = true;
            } else {
                $data['if_type'] = false;
            }
        }

        return $data;
    }

    /**
     * @describe 新增权限 - 选择菜单 - (true: 获取所有一级菜单, false: 获取所有已添加权限的一级菜单)
     * @author <yanghuilei@itsport.club>
     * @param $all
     * @createAt 2018-07-09
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getTopMenu($all = false)
    {
        $where = ['pid' => 0];
        if ($all === false) {
            $where = ['pid' => 0, 'status' => 1];
        }

        $data = AuthModuleModel::find()
            ->select(['id', 'name'])
            ->where($where)
            ->asArray()
            ->all();

        return $data;
    }

    /**
     * @describe 获取所有二级菜单
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-28
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getTwoLevelMenus()
    {
        $top_menus = $this->getTopMenu(1);
        $top_ids = array_filter(array_unique(array_column($top_menus, 'id')));
        $two_menus = AuthModuleModel::find()
            ->select(['id', 'name'])
            ->where(['pid' => $top_ids, 'status' => 1])
            ->asArray()
            ->all();

        return $two_menus;
    }

    /**
     * @describe 开发者配置 - 调换菜单 - 判断是否是二级菜单
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-28
     * @param $data
     * @return mixed
     */
    public function isTwoLevelMenus($data)
    {
        $copy_data = $data;
        foreach ($data as $a => $b) {
            foreach ($copy_data as $c => $d) {
                if ($b['pid'] == $d['id'] && $d['pid'] == 0) {
                    $data[$a]['is_two'] = true;
                }
            }

            if (!isset($data[$a]['is_two'])) {
                $data[$a]['is_two'] = false;
            }
        }

        return $data;
    }
}