<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%gift_day}}".
 *
 * @property string $id 自增Id
 * @property int $days 赠送天数
 * @property int $gift_amount 赠送量
 * @property int $surplus 剩余量
 * @property int $type 1购卡赠送2其它赠送3私课折扣
 * @property string $note 备注
 * @property string $venue_id 场馆id
 * @property string $company_id 公司id
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 * @property string $role_id 角色id
 * @property string $category_id 卡种id/折扣
 */
class GiftDay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%gift_day}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['days', 'gift_amount', 'surplus', 'type', 'venue_id', 'company_id', 'create_at', 'update_at', 'role_id'], 'integer'],
            [['category_id'], 'string'],
            [['note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'days' => 'Days',
            'gift_amount' => 'Gift Amount',
            'surplus' => 'Surplus',
            'type' => 'Type',
            'note' => 'Note',
            'venue_id' => 'Venue ID',
            'company_id' => 'Company ID',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'role_id' => 'Role ID',
            'category_id' => 'Category ID',
        ];
    }
}
