<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%ic_binding_record}}".
 *
 * @property string $id 自增ID
 * @property string $member_id 会员ID
 * @property string $ic_number IC卡号
 * @property string $custom_ic_number 自定义IC卡号
 * @property string $create_at 绑定时间
 * @property string $unbundling 解绑时间
 * @property string $create_id 创建人ID
 * @property int $status 状态 1绑定 2解绑
 */
class IcBindingRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ic_binding_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'create_at', 'unbundling', 'create_id', 'status'], 'integer'],
            [['ic_number', 'custom_ic_number'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => 'Member ID',
            'ic_number' => 'Ic Number',
            'custom_ic_number' => 'Custom Ic Number',
            'create_at' => 'Create At',
            'unbundling' => 'Unbundling',
            'create_id' => 'Create ID',
            'status' => 'Status',
        ];
    }
}
