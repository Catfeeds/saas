<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%approval_details}}".
 *
 * @property string $id 自增Id
 * @property string $approval_id 审核表ID
 * @property int $status 状态：1.审批中,2.已同意，3已拒绝，4已撤销
 * @property string $approver_id 审批人
 * @property string $describe 审批描述
 * @property string $approval_process_id 审批流程ID
 * @property string $create_at 创建时间
 * @property string $update_at 修改时间
 * @property int $type 类型:1审批2抄送
 */
class ApprovalDetails extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%approval_details}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['approval_id', 'status', 'approver_id', 'approval_process_id', 'create_at', 'update_at', 'type'], 'integer'],
            [['describe'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'approval_id' => 'Approval ID',
            'status' => 'Status',
            'approver_id' => 'Approver ID',
            'describe' => 'Describe',
            'approval_process_id' => 'Approval Process ID',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'type' => 'Type',
        ];
    }
}
