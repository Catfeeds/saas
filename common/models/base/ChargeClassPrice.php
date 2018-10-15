<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%charge_class_price}}".
 *
 * @property string $id
 * @property string $charge_class_id
 * @property string $course_package_detail_id
 * @property string $intervalStart
 * @property string $intervalEnd
 * @property string $unitPrice
 * @property string $posPrice
 * @property string $create_time
 * @property string $app_discount
 */
class ChargeClassPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%charge_class_price}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['charge_class_id', 'course_package_detail_id'], 'required'],
            [['charge_class_id', 'course_package_detail_id', 'intervalStart', 'intervalEnd', 'create_time'], 'integer'],
            [['unitPrice', 'posPrice', 'app_discount'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'charge_class_id' => '私课ID',
            'course_package_detail_id' => '课程ID',
            'intervalStart' => '开始节数',
            'intervalEnd' => '结束节数',
            'unitPrice' => '优惠单价',
            'posPrice' => 'pos价',
            'create_time' => '创建时间',
            'app_discount' => 'APP端私教折扣',
        ];
    }
}
