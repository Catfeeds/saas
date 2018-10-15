<?php
/**
 * Created by PhpStorm.
 * User: 杨慧磊
 * Date: 2018/7/3 0003
 * Time: 下午 2:22
 */

namespace backend\rbac\models;

use backend\rbac\models\base\AuthRoleChild;
use yii\base\Model;
use Yii;

class AuthRoleChildForm extends Model
{
    public $roleId;
    public $userId;

    private static $_object; /* this is owner */

    const SCENARIO_INSERT = 'insert';

    /**
     * @describe 初始化实例AuthManager
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-03
     */
    public function init()
    {
        self::$_object = Yii::$app->getAuthManager();

        parent::init();
    }

    /**
     * @describe 设置场景验证
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-03
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_INSERT => ['roleId', 'userId'],
        ];
    }

    /**
     * @describe 设置验证规则
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-03
     * @return array
     */
    public function rules()
    {
        return [
            [['roleId', 'userId'], 'required', 'on' => [self::SCENARIO_INSERT]],
            [['roleId', 'userId'], 'safe', 'on' => [self::SCENARIO_INSERT]],
        ];
    }

    /**
     * @describe 分配用户 - 保存
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-03
     * @return bool
     * @throws \yii\db\Exception
     */
    public function save()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            foreach ($this->userId as $key => $item) {
                $model = new AuthRoleChild();
                $model->role_id = $this->roleId;
                $model->user_id = $item;
                $bool1 = $model->save();
                if (!$bool1) {
                    throw new \Exception($model->errors);
                }
            }

            $data = AuthRoleItemModel::find()->where(['role_id' => $this->roleId])->asArray()->all();
            $basic_per = array_column($data, 'auth_item');

            foreach ($this->userId as $a => $userId) {
                foreach ($basic_per as $b => $roleName) {
                    $role = self::$_object->createRole($roleName);
                    self::$_object->assign($role, $userId);
                }
            }

            $transaction->commit();
            return true;

        } catch (\Exception $e) {
            $transaction->rollBack();
            return false;

        }
    }
}