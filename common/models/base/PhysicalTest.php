<?php

namespace common\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use common\behaviors\PositionBehavior;
use backend\behaviors\SideDataBehavior;

/**
 * This is the model class for table "{{%side_data}}".
 *
 * @property string $id
 * @property string $pid 父id
 * @property string $title 体侧项目
 * @property string $unit 单位 0 无 ，1次，2cm
 * @property string $normal_range 正常范围
 * @property int $level 级别
 * @property int $sort 排序
 * @property int $status 状态 0启用1禁用
 * @property string $create_at 创建时间
 * @property string $update_at 更新时间
 */
class PhysicalTest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%physical_test}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'unique','message'=>'名称已存在！'],
            [['pid', 'level', 'sort', 'status', 'create_at', 'update_at'], 'integer'],
            [['title', 'unit', 'normal_range'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => '父id',
            'title' => '体侧项目',
            'unit' => '单位 0 无 ，1次，2cm',
            'normal_range' => '正常范围',
            'level' => '级别',
            'sort' => '排序',
            'status' => '状态 0启用1禁用',
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
            SideDataBehavior::className(),
            'positionBehavior' => [
                'class' => PositionBehavior::className(),
                'positionAttribute' => 'sort',
                'groupAttributes' => [
                    'pid'
                ],
            ],

        ];
    }
}
