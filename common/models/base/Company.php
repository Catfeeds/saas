<?php
/**
 * Created by PhpStorm.
 * User: Xin Wei
 * Date: 2018/8/7
 * Time: 19:53
 * Desc:公众号注册公司信息表
 */
namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%company}}".
 *
 * @property string $id 主键ID
 * @property string $company_name 公司名称
 * @property string $username 负责人姓名
 * @property string $mobile 手机号
 * @property string $store_num 店面数量
 * @property string $area 地区
 * @property string $address 详细地址
 * @property int $status 审核状态（0-审核中，1-已通过，2-未通过）
 * @property string $create_at 创建时间
 * @property string $update_at 更新时间
 * @property int $is_delete 软删字段(0-未删除，1-已删除)
 */
class Company extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_num', 'status', 'is_delete'], 'integer'],
            [['create_at', 'update_at'], 'safe'],
            [['company_name', 'address'], 'string', 'max' => 100],
            [['username', 'mobile'], 'string', 'max' => 32],
            [['area'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键ID',
            'company_name' => '公司名称',
            'username' => '负责人姓名',
            'mobile' => '手机号',
            'store_num' => '店面数量',
            'area' => '地区',
            'address' => '详细地址',
            'status' => '审核状态（0-审核中，1-已通过，2-未通过）',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
            'is_delete' => '软删字段(0-未删除，1-已删除)',
        ];
    }
}