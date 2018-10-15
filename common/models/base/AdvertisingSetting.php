<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%advertising_setting}}".
 *
 * @property string $id
 * @property integer $type
 * @property integer $status
 * @property string $company_id
 * @property string $create_at
 * @property string $create_id
 */
class AdvertisingSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%advertising_setting}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status', 'company_id', 'create_at', 'create_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'status' => 'Status',
            'company_id' => 'Company ID',
            'create_at' => 'Create At',
            'create_id' => 'Create ID',
        ];
    }
}
