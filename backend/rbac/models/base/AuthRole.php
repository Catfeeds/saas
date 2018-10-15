<?php

namespace backend\rbac\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%auth_role}}".
 *
 * @property string $id 自增ID
 * @property string $name 高级角色
 * @property int $company_id 公司ID
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 * @property string $derive_id 派生高级角色ID
 * @property string $venue_id 可访问的场馆ID
 * @property int $status 是否分配权限; 1(已分配) 2(未分配)
 */
class AuthRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_role}}';
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
            [['name', 'company_id'], 'required'],
            [['company_id', 'create_at', 'update_at', 'derive_id', 'status'], 'integer'],
            [['venue_id'], 'string'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'company_id' => 'Company ID',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'derive_id' => 'Derive ID',
            'venue_id' => 'Venue ID',
            'status' => 'Status',
        ];
    }
}
