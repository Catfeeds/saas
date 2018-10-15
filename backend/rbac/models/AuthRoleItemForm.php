<?php
/**
 * Created by PhpStorm.
 * User: 杨慧磊
 * Date: 2018/7/2 0002
 * Time: 下午 7:44
 */

namespace backend\rbac\models;

use backend\rbac\models\base\AuthRoleItem;
use yii\base\Model;
use Yii;

class AuthRoleItemForm extends Model
{
    public $auth_item;
    public $auth_role_id;

    const SCENARIO_ALLOT = 'allot';

    /**
     * @describe 设置场景验证
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-02
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_ALLOT => ['auth_item', 'auth_role_id'],
        ];
    }

    /**
     * @describe 设置验证规则
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-02
     * @return array
     */
    public function rules()
    {
        return [
            [['auth_item', 'auth_role_id'], 'required'],
            [['auth_item', 'auth_role_id'], 'safe'],
        ];
    }

    /**
     * @describe 角色分配权限 - 保存权限
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-02
     * @return bool
     * @throws \yii\db\Exception
     */
    public function save()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($this->auth_item as $key => $item) {
                $model = new AuthRoleItem();
                $model->auth_item = $item;
                $model->role_id = $this->auth_role_id;
                $bool = $model->save();
                if (!$bool) {
                    throw new \Exception($model->errors);
                }
            }
            if ($transaction->commit() === null) {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            $transaction->rollBack();

            return false;
        }
    }

    /**
     * @describe 增加权限 - 保存用户yii2底层RBAC权限表
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-09
     * @param $user_ids
     * @return bool
     * @throws \yii\db\Exception
     */
    public function bindNewPermissions($user_ids)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($user_ids as $key1 => $user_id) {
                foreach ($this->auth_item as $key2 => $item) {
                    $role = Yii::$app->getAuthManager()->getRole($item);
                    $result = Yii::$app->getAuthManager()->assign($role, $user_id);
                    if (!$result) {
                        throw new \Exception('error');
                    }
                }
            }
            if ($transaction->commit() === null) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;
        }
    }
}