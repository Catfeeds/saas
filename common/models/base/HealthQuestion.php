<?php

namespace common\models\base;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "{{%health_question}}".
 *
 * @property string $id
 * @property string $pid 所属id
 * @property string $title 标题
 * @property string $create_at 创建时间
 * @property string $update_at 更新时间
 * @property int $status 状态0启用 1禁用
 * @property int $type 0病史，1其他问题
 */
class HealthQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%health_question}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'create_at', 'update_at', 'status', 'type'], 'integer'],
            [['title'], 'unique','message'=>'名称已存在！'],
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
            'pid' => '所属id',
            'title' => '标题',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
            'status' => '状态 0启用 1禁用',
            'type' => '1病史，2其他问题',
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
