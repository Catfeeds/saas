<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%about_yard}}".
 *
 * @property string $id 自增ID
 * @property string $yard_id 场地id
 * @property string $member_id 会员id
 * @property string $member_card_id 会员卡id
 * @property string $about_interval_section 预约区间段
 * @property string $aboutDate 预约日期
 * @property string $cancel_about_time 取消预约日期
 * @property int $status 1:未开始 2:已开始 3:已结束 4:旷课(没去)5:取消预约
 * @property string $create_at 创建时间(预约时间)
 * @property string $about_start 预约开始时间
 * @property string $about_end 预约结束时间
 * @property string $in_time 手环入场时间
 * @property string $out_time 手环出场时间
 * @property int $is_print_receipt 是否打印过小票(1 有, 2 没有)
 */
class AboutYard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%about_yard}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['yard_id', 'member_id', 'member_card_id', 'cancel_about_time', 'status', 'create_at', 'about_start', 'about_end', 'in_time', 'out_time', 'is_print_receipt'], 'integer'],
            [['about_interval_section', 'aboutDate'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'yard_id' => 'Yard ID',
            'member_id' => 'Member ID',
            'member_card_id' => 'Member Card ID',
            'about_interval_section' => 'About Interval Section',
            'aboutDate' => 'About Date',
            'cancel_about_time' => 'Cancel About Time',
            'status' => 'Status',
            'create_at' => 'Create At',
            'about_start' => 'About Start',
            'about_end' => 'About End',
            'in_time' => 'In Time',
            'out_time' => 'Out Time',
            'is_print_receipt' => 'Is Print Receipt',
        ];
    }
}
