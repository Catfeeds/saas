<?php

namespace backend\rbac\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%auth_module}}".
 *
 * @property string $id 自增ID
 * @property string $name 模块,功能名称
 * @property string $route 路由
 * @property string $desc 描述
 * @property int $pid 父ID
 * @property string $icon 图标
 * @property int $response_type 响应数据类型,1: HTML 2: JSON
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 * @property int $status 是否已添加角色,权限. 1:已添加; 2:未添加
 */
class AuthModule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_module}}';
    }

    /**
     * @describe 行为
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-27
     * @return array
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_at',
                'updatedAtAttribute' => 'update_at',
                'value' => time(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['pid', 'create_at', 'update_at', 'status', 'response_type'], 'integer'],
            [['name', 'route', 'desc'], 'string', 'max' => 200],
            [['icon'], 'string', 'max' => 50],
            [['name'], 'unique'],
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
            'route' => 'Route',
            'pid' => 'Pid',
            'desc' => 'Desc',
            'icon' => 'Icon',
            'response_type' => 'Response Type',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'status' => 'Status',
        ];
    }
}
