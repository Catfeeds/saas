<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%dock_member}}".
 *
 * @property string $id 自增ID
 * @property string $company_id 公司ID
 * @property string $venue_id 场馆Id
 * @property string $username 用户名
 * @property string $mobile 手机号
 * @property string $first_in_time 入场时间
 * @property string $company 公司
 * @property string $venue 场馆
 * @property string $id_card 身份证号
 * @property string $card_type 证件类型
 * @property string $sex 性别
 * @property string $birth_date 生日
 * @property string $email 邮箱
 * @property string $profession 职业
 * @property string $address 住地址
 * @property string $source 来源
 * @property string $created_at 创建时间
 * @property int $check_status 数据审核状态 1 正常, 2 异常
 * @property int $is_delete 软删除标记 0 未删除, 1 删除
 */
class DockMember extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dock_member}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'venue_id', 'check_status', 'is_delete'], 'integer'],
            [['first_in_time', 'birth_date', 'created_at'], 'safe'],
            [['username', 'company', 'venue', 'id_card', 'profession', 'address'], 'string', 'max' => 100],
            [['mobile', 'email', 'source'], 'string', 'max' => 50],
            [['card_type', 'sex'], 'string', 'max' => 10],
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
            'first_in_time' => 'First In Time',
            'company' => 'Company',
            'venue' => 'Venue',
            'id_card' => 'Id Card',
            'card_type' => 'Card Type',
            'sex' => 'Sex',
            'birth_date' => 'Birth Date',
            'email' => 'Email',
            'profession' => 'Profession',
            'address' => 'Address',
            'source' => 'Source',
            'created_at' => 'Created At',
            'check_status' => 'Check Status',
            'is_delete' => 'Is Delete',
        ];
    }
}
