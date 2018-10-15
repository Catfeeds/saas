<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%member_course_order}}".
 *
 * @property string $id 自增ID
 * @property int $course_amount 总节数
 * @property string $create_at 买课时间
 * @property string $money_amount 总金额
 * @property string $overage_section 剩余节数
 * @property string $deadline_time 课程截止时间
 * @property string $product_id 产品id
 * @property int $product_type 产品类型:1私课2团课
 * @property string $private_type 私教类别
 * @property int $charge_mode 计费方式（1.计次课程 2.其它）
 * @property int $class_mode 上课方式（1.单个教练 2. 多个教练 3.其它）
 * @property int $is_same_class 是否同时上课（1:同时上课 2.不同时上课3.其它）
 * @property string $private_id 私教id
 * @property string $present_course_number 赠课总次数
 * @property string $surplus_course_number 剩余总课数
 * @property int $cashier_type 收银类型（1.全款 2.转让 3.回款）
 * @property string $service_pay_id 收费项目id
 * @property string $member_card_id 会员卡ID
 * @property string $seller_id 员工表销售人id
 * @property string $cashierOrder 订单收银单号
 * @property string $member_id 会员id
 * @property string $business_remarks 业务备注
 * @property string $product_name 产品名称
 * @property int $type 类型：(1：PT，2:HS)
 * @property string $activeTime 生效时间
 * @property string $chargePersonId 收费人员id
 * @property int $set_number 存“服务套餐”的总套数或者“单节课程”的总数量
 * @property int $month_up_num 每月上课数量
 * @property int $course_type 课程类型:1收费课,2免费课,3生日课
 * @property string $note 备注
 * @property int $pay_status 1:已付款，2:已退款
 * @property string $class_number_id 私课编号id
 * @property int $status 1.正常2.冻结
 */
class MemberCourseOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member_course_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_amount', 'create_at', 'overage_section', 'deadline_time', 'product_id', 'product_type', 'charge_mode', 'class_mode', 'is_same_class', 'private_id', 'present_course_number', 'surplus_course_number', 'cashier_type', 'service_pay_id', 'member_card_id', 'seller_id', 'member_id', 'type', 'activeTime', 'chargePersonId', 'set_number', 'month_up_num', 'course_type', 'pay_status', 'class_number_id', 'status'], 'integer'],
            [['money_amount'], 'number'],
            [['business_remarks'], 'string'],
            [['private_type', 'cashierOrder'], 'string', 'max' => 255],
            [['product_name', 'note'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_amount' => 'Course Amount',
            'create_at' => 'Create At',
            'money_amount' => 'Money Amount',
            'overage_section' => 'Overage Section',
            'deadline_time' => 'Deadline Time',
            'product_id' => 'Product ID',
            'product_type' => 'Product Type',
            'private_type' => 'Private Type',
            'charge_mode' => 'Charge Mode',
            'class_mode' => 'Class Mode',
            'is_same_class' => 'Is Same Class',
            'private_id' => 'Private ID',
            'present_course_number' => 'Present Course Number',
            'surplus_course_number' => 'Surplus Course Number',
            'cashier_type' => 'Cashier Type',
            'service_pay_id' => 'Service Pay ID',
            'member_card_id' => 'Member Card ID',
            'seller_id' => 'Seller ID',
            'cashierOrder' => 'Cashier Order',
            'member_id' => 'Member ID',
            'business_remarks' => 'Business Remarks',
            'product_name' => 'Product Name',
            'type' => 'Type',
            'activeTime' => 'Active Time',
            'chargePersonId' => 'Charge Person ID',
            'set_number' => 'Set Number',
            'month_up_num' => 'Month Up Num',
            'course_type' => 'Course Type',
            'note' => 'Note',
            'pay_status' => 'Pay Status',
            'class_number_id' => 'Class Number ID',
            'status' => 'Status',
        ];
    }
}
