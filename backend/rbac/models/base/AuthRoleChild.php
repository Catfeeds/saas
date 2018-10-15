<?php

namespace backend\rbac\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%auth_role_child}}".
 *
 * @property string $id 自增ID
 * @property string $user_id 用户ID
 * @property string $role_id 高级角色ID
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class AuthRoleChild extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_role_child}}';
    }

    /**
     * @describe 行为
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-27
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_at',
                'updatedAtAttribute' => 'update_at',
                'value' => time(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'role_id', 'create_at', 'update_at'], 'integer'],
            [['role_id'], 'required'],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'role_id' => 'Role ID',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
