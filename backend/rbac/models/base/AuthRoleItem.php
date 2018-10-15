<?php

namespace backend\rbac\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%auth_role_item}}".
 *
 * @property string $auth_item 低级角色
 * @property string $role_id 高级角色ID
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 */
class AuthRoleItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_role_item}}';
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
            [['auth_item', 'role_id'], 'required'],
            [['role_id', 'create_at', 'update_at'], 'integer'],
            [['auth_item'], 'string', 'max' => 200],
            [['auth_item', 'role_id'], 'unique', 'targetAttribute' => ['auth_item', 'role_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auth_item' => 'Auth Item',
            'role_id' => 'Role ID',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
