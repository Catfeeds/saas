<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%member_account}}".
 *
 * @property string $id 自增ID
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $mobile 手机号
 * @property string $last_time 最后登录时间
 * @property string $company_id 公司ID
 * @property string $create_at 常见时间
 * @property int $count 非法登录次数最大三次
 * @property string $deviceNumber 设备识别号
 */
class MemberAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member_account}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['last_time', 'company_id', 'create_at', 'count'], 'integer'],
            [['username', 'mobile'], 'string', 'max' => 200],
            [['password', 'deviceNumber'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'mobile' => 'Mobile',
            'last_time' => 'Last Time',
            'company_id' => 'Company ID',
            'create_at' => 'Create At',
            'count' => 'Count',
            'deviceNumber' => 'Device Number',
        ];
    }
}
