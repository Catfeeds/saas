<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%deal_change_record}}".
 *
 * @property string $id 自增ID
 * @property string $deal_id 合同ID
 * @property string $name 合同名称
 * @property string $deal_type_id 合同类型ID
 * @property string $create_at 创建时间
 * @property string $create_id 操作人ID
 * @property string $deal_number 合同编号
 * @property string $company_id 公司ID
 * @property string $venue_id 场馆ID
 * @property string $intro 描述
 * @property int $type 类型: 1 卡种类; 2 私教类
 */
class DealChangeRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%deal_change_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deal_id', 'deal_type_id', 'create_at', 'create_id', 'company_id', 'venue_id', 'type'], 'integer'],
            [['intro'], 'string'],
            [['name', 'deal_number'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deal_id' => 'Deal ID',
            'name' => 'Name',
            'deal_type_id' => 'Deal Type ID',
            'create_at' => 'Create At',
            'create_id' => 'Create ID',
            'deal_number' => 'Deal Number',
            'company_id' => 'Company ID',
            'venue_id' => 'Venue ID',
            'intro' => 'Intro',
            'type' => 'Type',
        ];
    }
}
