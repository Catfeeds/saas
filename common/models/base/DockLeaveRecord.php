<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%dock_leave_record}}".
 *
 * @property string $id 自增ID
 * @property string $company_id 公司ID
 * @property string $venue_id 场馆Id
 * @property string $card_number 卡号
 * @property string $card_name 卡名称
 * @property string $check_time 登记时间
 * @property string $start_time 请假时间
 * @property string $end_time 结束时间
 * @property string $leave_length 请假时长
 * @property string $note 原因
 * @property string $leave_property 请假类型(特殊请假, 正常请假, 学生请假)
 * @property string $oper_name 经办人
 * @property string $status 状态(待处理, 已同意, 已拒绝)
 * @property string $created_at 创建时间
 * @property int $check_status 数据审核状态 1 正常, 2 异常
 * @property int $is_delete 软删除标记
 */
class DockLeaveRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dock_leave_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'venue_id', 'check_status', 'is_delete'], 'integer'],
            [['check_time', 'start_time', 'end_time', 'created_at'], 'safe'],
            [['card_number'], 'string', 'max' => 100],
            [['card_name', 'leave_property', 'oper_name', 'status'], 'string', 'max' => 50],
            [['leave_length'], 'string', 'max' => 10],
            [['note'], 'string', 'max' => 200],
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
            'card_number' => 'Card Number',
            'card_name' => 'Card Name',
            'check_time' => 'Check Time',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'leave_length' => 'Leave Length',
            'note' => 'Note',
            'leave_property' => 'Leave Property',
            'oper_name' => 'Oper Name',
            'status' => 'Status',
            'created_at' => 'Created At',
            'check_status' => 'Check Status',
            'is_delete' => 'Is Delete',
        ];
    }
}
