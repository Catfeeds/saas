<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%consultant_change_record}}".
 *
 * @property string $id 自增Id
 * @property string $member_id 会员Id
 * @property string $create_id 操作人Id
 * @property string $created_at 创建时间
 * @property string $consultant_id 会籍顾问Id
 * @property int $venue_id 场馆Id
 * @property int $company_id 公司Id
 * @property int $behavior 行为:1入馆2办卡3修改4续费5升级
 * @property int $type 1.会籍变更2.私教变更
 */
class ConsultantChangeRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%consultant_change_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'create_id', 'created_at', 'consultant_id', 'venue_id', 'company_id', 'behavior', 'type'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => 'Member ID',
            'create_id' => 'Create ID',
            'created_at' => 'Created At',
            'consultant_id' => 'Consultant ID',
            'venue_id' => 'Venue ID',
            'company_id' => 'Company ID',
            'behavior' => 'Behavior',
            'type' => 'Type',
        ];
    }
}
