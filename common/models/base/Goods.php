<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "{{%goods}}".
 *
 * @property string $id
 * @property string $goods_type_id
 * @property string $goods_brand
 * @property string $goods_name
 * @property string $unit_price
 * @property string $goods_model
 * @property string $goods_producer
 * @property string $goods_supplier
 * @property string $create_time
 * @property string $venue_id
 * @property string $company_id
 * @property integer $goods_attribute
 * @property string $unit
 * @property string $store_id
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goods}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_type_id', 'create_time', 'venue_id', 'company_id', 'goods_attribute', 'store_id','department_id'], 'integer'],
            [['goods_brand', 'goods_name', 'unit_price', 'goods_model', 'goods_producer', 'goods_supplier'], 'string', 'max' => 200],
            [['unit'], 'string', 'max' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'goods_type_id' => '商品类型id',
            'goods_brand' => '商品品牌',
            'goods_name' => '商品名称',
            'unit_price' => '商品单价',
            'goods_model' => '商品型号',
            'goods_producer' => '商品生产商',
            'goods_supplier' => '商品供应商',
            'create_time' => '创建时间',
            'venue_id' => '场馆id',
            'company_id' => '公司id',
            'goods_attribute' => '1:商品 2:赠品',
            'unit' => '商品单位',
            'store_id' => '仓库id',
            'department_id' => '部门id',
        ];
    }
}
