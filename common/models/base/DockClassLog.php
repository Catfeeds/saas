<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%dock_class_log}}".
 *
 * @property string $id 自增ID
 * @property string $company_id 公司ID
 * @property string $venue_id 场馆Id
 * @property string $username 会员
 * @property string $card_number 卡号
 * @property string $class_name 私教课名称
 * @property string $coach_name 教练名称
 * @property string $time_long 时长
 * @property string $reserver_date 预约时间
 * @property string $start_date 开始日期
 * @property string $end_date 结束日期
 * @property string $status 状态
 * @property string $class_type 课程类型
 * @property string $created_at 创建时间
 * @property int $check_status 数据审核状态 1 正常, 2 异常
 * @property int $is_delete 软删除标记
 */
class DockClassLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dock_class_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'venue_id', 'check_status', 'is_delete'], 'integer'],
            [['reserver_date', 'start_date', 'end_date', 'created_at'], 'safe'],
            [['username', 'card_number', 'class_name', 'coach_name', 'time_long'], 'string', 'max' => 100],
            [['status', 'class_type'], 'string', 'max' => 50],
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
            'username' => 'Username',
            'card_number' => 'Card Number',
            'class_name' => 'Class Name',
            'coach_name' => 'Coach Name',
            'time_long' => 'Time Long',
            'reserver_date' => 'Reserver Date',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'status' => 'Status',
            'class_type' => 'Class Type',
            'created_at' => 'Created At',
            'check_status' => 'Check Status',
            'is_delete' => 'Is Delete',
        ];
    }
}
