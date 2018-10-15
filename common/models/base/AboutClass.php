<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%about_class}}".
 *
 * @property string $id 自增ID
 * @property string $member_card_id 会员卡ID
 * @property string $class_id 课程Id
 * @property int $status 1:未上课 2:取消预约 3:上课中 4:下课 5:过期 6:旷课(卡未被冻结) 7:旷课(团课爽约)
 * @property string $cancel_reason 取消原因
 * @property string $type 类型:例如团课私课
 * @property string $create_at 创建时间
 * @property string $seat_id 座位号ID
 * @property int $limit_time 上课前多长时间不能取消预约
 * @property string $coach_id 教练id
 * @property string $class_date 上课日期
 * @property string $start 开始时间
 * @property string $end 结束时间
 * @property string $cancel_time 取消预约时间
 * @property string $member_id 会员ID
 * @property int $is_print_receipt 是否打印过小票（1有2没有）
 * @property int $about_type 预约类型（1电话预约 2自助预约）
 * @property string $employee_id 员工id
 * @property int $is_read 是否已读
 * @property string $in_time 手环上课打卡时间
 * @property string $out_time 手环出场时间
 * @property string $actual_start 实际开始时间
 * @property string $actual_end 实际结束时间
 */
class AboutClass extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%about_class}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_card_id', 'class_id', 'status', 'create_at', 'seat_id', 'limit_time', 'coach_id', 'start', 'end', 'cancel_time', 'member_id', 'is_print_receipt', 'about_type', 'employee_id', 'is_read', 'in_time', 'out_time', 'actual_start', 'actual_end'], 'integer'],
            [['class_id'], 'required'],
            [['class_date'], 'safe'],
            [['cancel_reason'], 'string', 'max' => 20],
            [['type'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_card_id' => 'Member Card ID',
            'class_id' => 'Class ID',
            'status' => 'Status',
            'cancel_reason' => 'Cancel Reason',
            'type' => 'Type',
            'create_at' => 'Create At',
            'seat_id' => 'Seat ID',
            'limit_time' => 'Limit Time',
            'coach_id' => 'Coach ID',
            'class_date' => 'Class Date',
            'start' => 'Start',
            'end' => 'End',
            'cancel_time' => 'Cancel Time',
            'member_id' => 'Member ID',
            'is_print_receipt' => 'Is Print Receipt',
            'about_type' => 'About Type',
            'employee_id' => 'Employee ID',
            'is_read' => 'Is Read',
            'in_time' => 'In Time',
            'out_time' => 'Out Time',
            'actual_start' => 'Actual Start',
            'actual_end' => 'Actual End',
        ];
    }
}
