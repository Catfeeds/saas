<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%advertising}}".
 *
 * @property string $id
 * @property string $setting_id
 * @property integer $status
 * @property string $name
 * @property string $photo
 * @property string $url
 * @property integer $is_over
 * @property integer $show_time
 * @property string $venue_ids
 * @property string $start
 * @property string $end
 * @property string $create_at
 * @property string $create_id
 * @property string $update_time
 * @property string $note
 */
class Advertising extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%advertising}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['setting_id', 'status', 'is_over', 'show_time', 'start', 'end', 'create_at', 'create_id', 'update_time'], 'integer'],
            [['venue_ids'], 'string'],
            [['name'], 'string', 'max' => 200],
            [['photo', 'url', 'note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'setting_id' => 'Setting ID',
            'status' => 'Status',
            'name' => 'Name',
            'photo' => 'Photo',
            'url' => 'Url',
            'is_over' => 'Is Over',
            'show_time' => 'Show Time',
            'venue_ids' => 'Venue Ids',
            'start' => 'Start',
            'end' => 'End',
            'create_at' => 'Create At',
            'create_id' => 'Create ID',
            'update_time' => 'Update Time',
            'note' => 'Note',
        ];
    }
}
