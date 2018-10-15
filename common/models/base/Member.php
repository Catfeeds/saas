<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%member}}".
 *
 * @property string $id 自增ID
 * @property string $username 用户名
 * @property string $password 密码
 * @property string $mobile 手机号
 * @property string $register_time 注册时间
 * @property string $password_token
 * @property string $hash
 * @property string $update_at 修改时间
 * @property string $last_time 最近一次登录时间
 * @property string $last_fail_login_time 上次登录失败时间
 * @property string $times 登录失败次数
 * @property int $status 状态：0待审核，1正常，2禁用
 * @property string $lock_time 锁定时长
 * @property string $params 扩展(json) 
 * @property string $counselor_id 顾问ID
 * @property int $member_type 会员类型(1:正式会员2:潜在会员3:失效会员)
 * @property string $venue_id 场馆ID
 * @property int $is_employee 是不是员工：1 是
 * @property string $company_id 公司id
 * @property string $fixPhone 固定电话
 * @property int $private_id 用于会员购卡未购课时分配私教以促进销售
 * @property string $member_account_id 账户表
 */
class Member extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%member}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password', 'mobile', 'register_time'], 'required'],
            [['register_time', 'update_at', 'last_time', 'last_fail_login_time', 'times', 'status', 'lock_time', 'counselor_id', 'member_type', 'venue_id', 'is_employee', 'company_id', 'private_id', 'member_account_id'], 'integer'],
            [['params'], 'string'],
            [['username', 'password', 'mobile', 'password_token', 'hash', 'fixPhone'], 'string', 'max' => 200],
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
            'register_time' => 'Register Time',
            'password_token' => 'Password Token',
            'hash' => 'Hash',
            'update_at' => 'Update At',
            'last_time' => 'Last Time',
            'last_fail_login_time' => 'Last Fail Login Time',
            'times' => 'Times',
            'status' => 'Status',
            'lock_time' => 'Lock Time',
            'params' => 'Params',
            'counselor_id' => 'Counselor ID',
            'member_type' => 'Member Type',
            'venue_id' => 'Venue ID',
            'is_employee' => 'Is Employee',
            'company_id' => 'Company ID',
            'fixPhone' => 'Fix Phone',
            'private_id' => 'Private ID',
            'member_account_id' => 'Member Account ID',
        ];
    }
}
