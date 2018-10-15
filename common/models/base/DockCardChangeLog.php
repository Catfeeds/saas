<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%dock_card_change_log}}".
 *
 * @property string $id 自增ID
 * @property string $company_id 公司ID
 * @property string $venue_id 场馆Id
 * @property string $old_card_number 旧卡号
 * @property string $behavior 行为(升级, 续费, 办卡)
 * @property string $new_card_number 新卡号
 * @property string $behavior_money 金额
 * @property string $consume_date 消费时间
 * @property string $casd_number 收银单号
 * @property string $counselor_name 销售人名称
 * @property string $note 备注
 * @property string $created_at 创建时间
 * @property int $check_status 数据审核状态 1 正常, 2 异常
 * @property int $is_delete 软删除标记
 */
class DockCardChangeLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dock_card_change_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'venue_id', 'check_status', 'is_delete'], 'integer'],
            [['behavior_money'], 'number'],
            [['consume_date', 'created_at'], 'safe'],
            [['note'], 'string'],
            [['old_card_number', 'new_card_number', 'casd_number'], 'string', 'max' => 100],
            [['behavior', 'counselor_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'venue_id' => 'Venue ID',
            'old_card_number' => 'Old Card Number',
            'behavior' => 'Behavior',
            'new_card_number' => 'New Card Number',
            'behavior_money' => 'Behavior Money',
            'consume_date' => 'Consume Date',
            'casd_number' => 'Casd Number',
            'counselor_name' => 'Counselor Name',
            'note' => 'Note',
            'created_at' => 'Created At',
            'check_status' => 'Check Status',
            'is_delete' => 'Is Delete',
        ];
    }
}
