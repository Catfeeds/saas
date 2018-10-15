<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%employee_turn_member_record}}".
 *
 * @property int $id 自增ID
 * @property int $from_employee_id 转让员工ID
 * @property int $to_employee_id 被转让员工ID
 * @property int $member_count 转让会员总数
 * @property int $type 类型:1.私教2.销售
 * @property int $create_id 操作人ID
 * @property string $created_at 转移时间
 * @property int $company_id 公司ID
 * @property int $venue_id 场馆ID
 * @property string $member_ids 批量转移会员id
 */
class EmployeeTurnMemberRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%employee_turn_member_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_employee_id', 'to_employee_id', 'member_count', 'type', 'create_id', 'created_at', 'company_id', 'venue_id'], 'integer'],
            [['member_ids'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_employee_id' => 'From Employee ID',
            'to_employee_id' => 'To Employee ID',
            'member_count' => 'Member Count',
            'type' => 'Type',
            'create_id' => 'Create ID',
            'created_at' => 'Created At',
            'company_id' => 'Company ID',
            'venue_id' => 'Venue ID',
            'member_ids' => 'Member Ids',
        ];
    }
}
