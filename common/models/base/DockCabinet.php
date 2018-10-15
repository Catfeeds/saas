<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%dock_cabinet}}".
 *
 * @property string $id 自增ID
 * @property string $company_id 公司ID
 * @property string $venue_id 场馆Id
 * @property string $cabinet_name 柜子名称
 * @property string $cabinet_number 柜子编号
 * @property string $status 状态(未租, 已租, 维修中)
 * @property string $start_time 开始时间
 * @property string $end_time 结束时间
 * @property string $consume_time 消费时期
 * @property string $price 金额
 * @property string $behavior 行为
 * @property string $counselor_name 销售人名称
 * @property string $company 公司
 * @property string $venue 场馆
 * @property string $cabinet_model 柜子类型(大柜, 中柜, 小柜)
 * @property string $cabinet_type 柜子类型
 * @property string $cabinet_cate 柜子类别(临时, 正式)
 * @property string $day_rent_price 日租价
 * @property string $month_rent_price 月租价
 * @property string $year_rent_price 年租价
 * @property string $half_year_rent_price 半年租价
 * @property string $deposit 押金
 * @property string $give_month 赠送月数
 * @property string $created_at 创建时间
 * @property int $check_status 数据审核状态 1 正常, 2 异常
 * @property int $is_delete 软删除标记
 */
class DockCabinet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dock_cabinet}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'venue_id', 'check_status', 'is_delete'], 'integer'],
            [['start_time', 'end_time', 'created_at'], 'safe'],
            [['price', 'day_rent_price', 'month_rent_price', 'year_rent_price', 'half_year_rent_price', 'deposit'], 'number'],
            [['cabinet_name', 'status', 'consume_time', 'behavior', 'counselor_name', 'cabinet_model', 'cabinet_type', 'cabinet_cate', 'give_month'], 'string', 'max' => 50],
            [['cabinet_number', 'company', 'venue'], 'string', 'max' => 100],
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
            'cabinet_name' => 'Cabinet Name',
            'cabinet_number' => 'Cabinet Number',
            'status' => 'Status',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'consume_time' => 'Consume Time',
            'price' => 'Price',
            'behavior' => 'Behavior',
            'counselor_name' => 'Counselor Name',
            'company' => 'Company',
            'venue' => 'Venue',
            'cabinet_model' => 'Cabinet Model',
            'cabinet_type' => 'Cabinet Type',
            'cabinet_cate' => 'Cabinet Cate',
            'day_rent_price' => 'Day Rent Price',
            'month_rent_price' => 'Month Rent Price',
            'year_rent_price' => 'Year Rent Price',
            'half_year_rent_price' => 'Half Year Rent Price',
            'deposit' => 'Deposit',
            'give_month' => 'Give Month',
            'created_at' => 'Created At',
            'check_status' => 'Check Status',
            'is_delete' => 'Is Delete',
        ];
    }
}
