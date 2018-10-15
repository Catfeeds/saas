<?php

namespace common\models\base;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "{{%follow_state}}".
 *
 * @property string $id
 * @property string $title 状态名称
 * @property int $state 0启用 1禁用
 * @property int $is_remind 是否提醒私教 0 是 1 否
 * @property string $create_at 创建时间
 * @property string $update_at 更新时间
 */
class FollowState extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%follow_state}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['state', 'is_remind', 'create_at', 'update_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique','message'=>'名称已存在！'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '状态名称',
            'state' => '0启用 1禁用',
            'is_remind' => '是否提醒私教 0 是 1 否',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
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
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['create_at', 'update_at'],
                    # 修改之前
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['update_at']
                ],
                #设置默认值
                'value' => time()
            ],
        ];
    }
}
