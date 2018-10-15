<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%venue_yard}}".
 *
 * @property string $id 自增ID
 * @property string $venue_id 场馆id
 * @property string $yard_name 场地名称
 * @property string $people_limit 人数限制
 * @property string $business_time 每天营业时间段
 * @property string $active_duration 单次活动时长(分钟)
 * @property string $create_at 场地创建时间
 * @property string $room_id 房间ID
 */
class VenueYard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%venue_yard}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['venue_id', 'people_limit', 'active_duration', 'create_at', 'room_id'], 'integer'],
            [['yard_name', 'business_time'], 'string', 'max' => 255],
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
            'yard_name' => 'Yard Name',
            'people_limit' => 'People Limit',
            'business_time' => 'Business Time',
            'active_duration' => 'Active Duration',
            'create_at' => 'Create At',
            'room_id' => 'Room ID',
        ];
    }
}
