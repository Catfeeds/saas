<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%dock_course_order}}".
 *
 * @property string $id 自增ID
 * @property string $company_id 公司ID
 * @property string $venue_id 场馆Id
 * @property string $course_nums 总节数
 * @property string $order_time 下单时间
 * @property string $total_money 总金额
 * @property string $reamain_nums 剩余节数
 * @property string $over_time 截止时间
 * @property string $course_name 课程名称
 * @property string $course_type 课程类型
 * @property string $bill_type 计费方式(计次/其他)
 * @property string $class_type 上课方式(单个教练/多个教练)
 * @property string $class_share 同时上课(是/否)
 * @property string $coach_name 教练名称
 * @property string $send_nums 赠送总次数
 * @property string $product_name 产品名称
 * @property string $card_number 卡号
 * @property string $casd_type 收银类型(全款、转让、回款)
 * @property string $casd_number 收银单号
 * @property string $counselor_name 销售人名称
 * @property string $start_time 生效时间
 * @property string $sell_people_name 售卖人姓名
 * @property string $payee_name 收款人姓名
 * @property string $order_status 订单状态(已付款、已退款)
 * @property string $note 备注
 * @property int $limit_days 有效天数
 * @property string $single_original_price 单节原价
 * @property string $single_sell_price 单节售价
 * @property string $single_pos_price 单节pos售价
 * @property string $single_long 单节时长
 * @property int $transfer_limit 转让次数
 * @property string $transfer_money 转让金额
 * @property string $deal_name 合同名称
 * @property string $created_at 创建时间
 * @property int $check_status 数据审核状态 1 正常, 2 异常
 * @property int $is_delete 软删除标记
 */
class DockCourseOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dock_course_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'venue_id', 'course_nums', 'reamain_nums', 'send_nums', 'limit_days', 'transfer_limit', 'check_status', 'is_delete'], 'integer'],
            [['order_time', 'over_time', 'start_time', 'created_at'], 'safe'],
            [['total_money', 'single_original_price', 'single_sell_price', 'single_pos_price', 'transfer_money'], 'number'],
            [['note'], 'string'],
            [['course_name', 'card_number', 'casd_number'], 'string', 'max' => 100],
            [['course_type', 'bill_type', 'class_type', 'class_share', 'coach_name', 'product_name', 'casd_type', 'counselor_name', 'sell_people_name', 'payee_name', 'order_status', 'single_long'], 'string', 'max' => 50],
            [['deal_name'], 'string', 'max' => 200],
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
            'course_nums' => 'Course Nums',
            'order_time' => 'Order Time',
            'total_money' => 'Total Money',
            'reamain_nums' => 'Reamain Nums',
            'over_time' => 'Over Time',
            'course_name' => 'Course Name',
            'course_type' => 'Course Type',
            'bill_type' => 'Bill Type',
            'class_type' => 'Class Type',
            'class_share' => 'Class Share',
            'coach_name' => 'Coach Name',
            'send_nums' => 'Send Nums',
            'product_name' => 'Product Name',
            'card_number' => 'Card Number',
            'casd_type' => 'Casd Type',
            'casd_number' => 'Casd Number',
            'counselor_name' => 'Counselor Name',
            'start_time' => 'Start Time',
            'sell_people_name' => 'Sell People Name',
            'payee_name' => 'Payee Name',
            'order_status' => 'Order Status',
            'note' => 'Note',
            'limit_days' => 'Limit Days',
            'single_original_price' => 'Single Original Price',
            'single_sell_price' => 'Single Sell Price',
            'single_pos_price' => 'Single Pos Price',
            'single_long' => 'Single Long',
            'transfer_limit' => 'Transfer Limit',
            'transfer_money' => 'Transfer Money',
            'deal_name' => 'Deal Name',
            'created_at' => 'Created At',
            'check_status' => 'Check Status',
            'is_delete' => 'Is Delete',
        ];
    }
}
