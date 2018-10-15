<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%classroom}}".
 *
 * @property string $id 自增ID
 * @property string $name 名称 
 * @property string $venue_id 场馆id
 * @property string $total_seat 总座位数
 * @property string $classroom_area 教室面积
 * @property string $classroom_describe 教室描述
 * @property string $classroom_pic 教室图片
 * @property string $company_id 公司id
 * @property string $seat_columns 教室座位列数
 * @property string $seat_rows 教室座位行数
 * @property string $sn 设备ID
 * @property string $readno 读卡器ID
 * @property string $room_id 房间ID
 */
class Classroom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%classroom}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'venue_id'], 'required'],
            [['venue_id', 'total_seat', 'company_id', 'seat_columns', 'seat_rows', 'room_id'], 'integer'],
            [['classroom_describe'], 'string'],
            [['name', 'classroom_area', 'sn', 'readno'], 'string', 'max' => 200],
            [['classroom_pic'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'venue_id' => 'Venue ID',
            'total_seat' => 'Total Seat',
            'classroom_area' => 'Classroom Area',
            'classroom_describe' => 'Classroom Describe',
            'classroom_pic' => 'Classroom Pic',
            'company_id' => 'Company ID',
            'seat_columns' => 'Seat Columns',
            'seat_rows' => 'Seat Rows',
            'sn' => 'Sn',
            'readno' => 'Readno',
            'room_id' => 'Room ID',
        ];
    }
}
