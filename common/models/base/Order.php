<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property string $id
 * @property string $venue_id
 * @property string $member_id
 * @property string $card_category_id
 * @property string $total_price
 * @property string $order_time
 * @property string $pay_money_time
 * @property integer $pay_money_mode
 * @property string $sell_people_id
 * @property string $payee_id
 * @property string $create_id
 * @property integer $status
 * @property string $note
 * @property string $order_number
 * @property string $card_name
 * @property string $sell_people_name
 * @property string $payee_name
 * @property string $member_name
 * @property string $pay_people_name
 * @property string $company_id
 * @property string $merchant_order_number
 * @property string $consumption_type_id
 * @property string $consumption_type
 * @property string $deposit
 * @property string $cash_coupon
 * @property string $net_price
 * @property string $all_price
 * @property string $refund_note
 * @property string $refuse_note
 * @property string $apply_time
 * @property string $review_time
 * @property integer $is_receipt
 * @property integer $purchase_num
 * @property string $new_note
 * @property string $many_pay_mode
 * @property string $other_note
 * @property string $sign
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['venue_id', 'member_id', 'card_category_id', 'order_number'], 'required'],
            [['venue_id', 'member_id', 'card_category_id', 'order_time', 'pay_money_time', 'pay_money_mode', 'sell_people_id', 'payee_id', 'create_id', 'status', 'company_id', 'consumption_type_id', 'apply_time', 'review_time', 'is_receipt', 'purchase_num'], 'integer'],
            [['total_price', 'deposit', 'cash_coupon', 'net_price', 'all_price'], 'number'],
            [['note', 'refund_note', 'refuse_note', 'many_pay_mode', 'other_note'], 'string'],
            [['order_number', 'merchant_order_number', 'sign'], 'string', 'max' => 255],
            [['card_name', 'sell_people_name', 'payee_name', 'member_name', 'pay_people_name', 'consumption_type', 'new_note'], 'string', 'max' => 200],
            [['order_number'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'venue_id' => 'Venue ID',
            'member_id' => 'Member ID',
            'card_category_id' => 'Card Category ID',
            'total_price' => 'Total Price',
            'order_time' => 'Order Time',
            'pay_money_time' => 'Pay Money Time',
            'pay_money_mode' => 'Pay Money Mode',
            'sell_people_id' => 'Sell People ID',
            'payee_id' => 'Payee ID',
            'create_id' => 'Create ID',
            'status' => 'Status',
            'note' => 'Note',
            'order_number' => 'Order Number',
            'card_name' => 'Card Name',
            'sell_people_name' => 'Sell People Name',
            'payee_name' => 'Payee Name',
            'member_name' => 'Member Name',
            'pay_people_name' => 'Pay People Name',
            'company_id' => 'Company ID',
            'merchant_order_number' => 'Merchant Order Number',
            'consumption_type_id' => 'Consumption Type ID',
            'consumption_type' => 'Consumption Type',
            'deposit' => 'Deposit',
            'cash_coupon' => 'Cash Coupon',
            'net_price' => 'Net Price',
            'all_price' => 'All Price',
            'refund_note' => 'Refund Note',
            'refuse_note' => 'Refuse Note',
            'apply_time' => 'Apply Time',
            'review_time' => 'Review Time',
            'is_receipt' => 'Is Receipt',
            'purchase_num' => 'Purchase Num',
            'new_note' => 'New Note',
            'many_pay_mode' => 'Many Pay Mode',
            'other_note' => 'Other Note',
            'sign' => 'Sign',
        ];
    }
}
