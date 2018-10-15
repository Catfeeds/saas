<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%dock_member_card}}".
 *
 * @property string $id 自增ID
 * @property string $company_id 公司ID
 * @property string $venue_id 场馆Id
 * @property string $username 用户名
 * @property string $mobile 手机号
 * @property string $sex 性别
 * @property string $company 公司
 * @property string $venue 场馆
 * @property string $card_number 卡号
 * @property string $open_card_time 开卡时间
 * @property string $money 卡金额
 * @property string $status 卡状态(正常、冻结、异常、未激活)
 * @property string $active_date 激活时间
 * @property string $failure_date 失效时间
 * @property string $nums 总次数
 * @property string $consume_nums 消费次数
 * @property string $content 卡描述
 * @property string $counselor_name 销售人员
 * @property string $card_name 卡名称
 * @property string $count_type 计次方式
 * @property string $card_attributes 卡属性
 * @property string $deal_name 合同名称
 * @property string $behavior 行为(升级、续费、办卡)
 * @property string $consume_type 消费方式(现金、银行卡、支付宝、微信)
 * @property string $casd_number 收银单号
 * @property string $note 备注
 * @property string $created_at 创建时间
 * @property int $check_status 数据审核状态 1 正常, 2 异常
 * @property int $is_delete 软删除标记
 */
class DockMemberCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dock_member_card}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'venue_id', 'nums', 'consume_nums', 'check_status', 'is_delete'], 'integer'],
            [['open_card_time', 'active_date', 'failure_date', 'created_at'], 'safe'],
            [['money'], 'number'],
            [['content', 'note'], 'string'],
            [['username', 'company', 'venue', 'card_number', 'deal_name', 'casd_number'], 'string', 'max' => 100],
            [['mobile', 'status', 'counselor_name', 'card_name', 'count_type', 'card_attributes', 'behavior', 'consume_type'], 'string', 'max' => 50],
            [['sex'], 'string', 'max' => 10],
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
            'mobile' => 'Mobile',
            'sex' => 'Sex',
            'company' => 'Company',
            'venue' => 'Venue',
            'card_number' => 'Card Number',
            'open_card_time' => 'Open Card Time',
            'money' => 'Money',
            'status' => 'Status',
            'active_date' => 'Active Date',
            'failure_date' => 'Failure Date',
            'nums' => 'Nums',
            'consume_nums' => 'Consume Nums',
            'content' => 'Content',
            'counselor_name' => 'Counselor Name',
            'card_name' => 'Card Name',
            'count_type' => 'Count Type',
            'card_attributes' => 'Card Attributes',
            'deal_name' => 'Deal Name',
            'behavior' => 'Behavior',
            'consume_type' => 'Consume Type',
            'casd_number' => 'Casd Number',
            'note' => 'Note',
            'created_at' => 'Created At',
            'check_status' => 'Check Status',
            'is_delete' => 'Is Delete',
        ];
    }
}
