<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%dock_employee}}".
 *
 * @property string $id 自增ID
 * @property string $company_id 公司ID
 * @property string $venue_id 场馆Id
 * @property string $name 姓名
 * @property string $sex 性别
 * @property string $mobile 手机号
 * @property string $email 邮箱
 * @property string $id_card 身份证号
 * @property string $birth_time 生日
 * @property string $company 公司
 * @property string $venue 场馆
 * @property string $department 部门
 * @property string $position 职业
 * @property string $status 状态(在职, 离职)
 * @property string $entry_date 任职日期
 * @property string $leave_date 离职日期
 * @property string $salary 薪资
 * @property string $intro 个人简介
 * @property string $work_date 从业日期
 * @property string $created_at 创建时间
 * @property int $check_status 数据审核状态 1 正常, 2 异常
 * @property int $is_delete 软删除标记
 */
class DockEmployee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dock_employee}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'venue_id', 'check_status', 'is_delete'], 'integer'],
            [['birth_time', 'entry_date', 'leave_date', 'work_date', 'created_at'], 'safe'],
            [['salary'], 'number'],
            [['intro'], 'string'],
            [['name', 'mobile', 'status'], 'string', 'max' => 50],
            [['sex'], 'string', 'max' => 10],
            [['email', 'id_card', 'company', 'venue', 'department', 'position'], 'string', 'max' => 100],
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
            'name' => 'Name',
            'sex' => 'Sex',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'id_card' => 'Id Card',
            'birth_time' => 'Birth Time',
            'company' => 'Company',
            'venue' => 'Venue',
            'department' => 'Department',
            'position' => 'Position',
            'status' => 'Status',
            'entry_date' => 'Entry Date',
            'leave_date' => 'Leave Date',
            'salary' => 'Salary',
            'intro' => 'Intro',
            'work_date' => 'Work Date',
            'created_at' => 'Created At',
            'check_status' => 'Check Status',
            'is_delete' => 'Is Delete',
        ];
    }
}
