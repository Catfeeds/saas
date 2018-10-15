<?php

namespace common\models\base;

use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "{{%train_template_tags}}".
 *
 * @property string $id
 * @property string $title 标签名称
 * @property int $status 状态
 * @property string $created_at 创建时间
 * @property string $updated_at 更新时间
 * @property int $sorts 排序
 */
class TrainTemplateTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%train_template_tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at', 'sorts'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique','message'=>'该名已被占用！'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标签名称',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
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
