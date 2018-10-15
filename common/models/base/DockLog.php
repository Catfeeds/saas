<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%dock_log}}".
 *
 * @property string $id 自增ID
 * @property string $company_id 公司ID
 * @property string $venue_id 场馆Id
 * @property string $admin_id 操作人ID
 * @property string $filename 文件名称
 * @property string $created_at 创建时间
 * @property int $is_delete 软删除标记
 */
class DockLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%dock_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'venue_id', 'admin_id', 'is_delete'], 'integer'],
            [['created_at'], 'safe'],
            [['filename'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'venue_id' => 'Venue ID',
            'admin_id' => 'Admin ID',
            'filename' => 'Filename',
            'created_at' => 'Created At',
            'is_delete' => 'Is Delete',
        ];
    }

    /**
     * @desc:关联后台登陆表， 只有这个关联 就写这里了
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/9
     * @time: 10:10
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(\backend\models\Admin::className(), ['id'=>'admin_id']);
    }

}
