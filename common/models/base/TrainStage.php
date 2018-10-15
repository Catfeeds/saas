<?php

namespace common\models\base;

use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "{{%train_stage}}".
 *  训练阶段
 * @property string $id
 * @property string $title 阶段名称
 * @property string $length_time 时长  单位分钟
 * @property string $created_at 创建时间
 * @property string $updated_at 修改时间
 * @property int $status 状态
 * @property int $sorts 排序
 */
class TrainStage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%train_stage}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['length_time', 'created_at', 'updated_at', 'status', 'sorts','template_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template_id' => '模板Id',
            'title' => '阶段名称',
            'length_time' => '时长  单位分钟',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'status' => '状态',
            'main' => '训练内容',
            'sorts' => '排序',
        ];
    }

    /**
     * @定义行为
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    # 创建之前
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    # 修改之前
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at']
                ],
                #设置默认值
                'value' => time()
            ],
        ];
    }
}
