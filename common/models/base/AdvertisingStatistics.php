<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%advertising_statistics}}".
 *
 * @property string $id
 * @property string $ad_id
 * @property string $venue_id
 * @property string $show_num
 * @property string $click_num
 */
class AdvertisingStatistics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%advertising_statistics}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ad_id', 'venue_id', 'show_num', 'click_num'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ad_id' => 'Ad ID',
            'venue_id' => 'Venue ID',
            'show_num' => 'Show Num',
            'click_num' => 'Click Num',
        ];
    }
}
