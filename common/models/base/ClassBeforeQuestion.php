<?php

namespace common\models\base;

use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "{{%class_before_question}}".
 *
 * @property string $id
 * @property string $title 问题标题
 * @property string $class_id 课程id
 * @property string $course_id 课种id
 * @property int $type 0单选，1自定义答案，2多选
 * @property string $option 选项
 * @property int $status 状态0启用1禁用
 * @property string $create_at 创建时间
 * @property string $update_at 更新时间
 */
class ClassBeforeQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%class_before_question}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['course_id'], 'required'],
            [['class_id', 'course_id', 'type', 'status', 'create_at', 'update_at'], 'integer'],
            [['option'], 'string'],
            [['course_id'], 'unique','message'=>'该课种已经设置过问题，请前去修改'],
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
            'title' => '问题标题',
            'class_id' => '课程id',
            'course_id' => '课种id',
            'type' => '0单选，1自定义答案，2多选',
            'option' => '选项',
            'status' => '状态0启用1禁用',
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
