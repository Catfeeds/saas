<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%change_venue_record}}".
 *
 * @property string $id
 * @property string $public_id
 * @property integer $type
 * @property string $old_venue_id
 * @property string $new_venue_id
 * @property string $create_at
 * @property string $create_id
 * @property string $note
 */
class ChangeVenueRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%change_venue_record}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['public_id', 'type', 'old_venue_id', 'new_venue_id', 'create_at', 'create_id'], 'integer'],
            [['note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'public_id' => 'Public ID',
            'type' => 'Type',
            'old_venue_id' => 'Old Venue ID',
            'new_venue_id' => 'New Venue ID',
            'create_at' => 'Create At',
            'create_id' => 'Create ID',
            'note' => 'Note',
        ];
    }
}
