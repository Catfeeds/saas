<?php
namespace backend\models;

use common\models\base\Goods;
use yii\base\Model;
class GoodsUpdateForm  extends Model
{
    public $goodsId;      //商品id
    public $typeId;       //商品类别
    public $name;         //商品名称
    public $brand;        //商品品牌
    public $model;        //商品型号
    public $unit;         //商品单价
    public $producer;    //生产商
    public $supplier;    //供应商

    public function rules()
    {
        return [
            [['goodsId', 'typeId', 'name', 'brand','model','unit','producer','supplier'], 'safe']
        ];
    }

    /**
     * @云运动 - 商品管理 - 修改商品
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/21
     */
    public function goodsUpdate($companyId,$venueId)
    {
        $goods = Goods::findOne(['id' => $this->goodsId]);
        if(!empty($goods)){
            $goods->goods_type_id  = $this->typeId;
            $goods->goods_name     = $this->name;
            $goods->goods_brand    = $this->brand;
            $goods->goods_model    = $this->model;
            $goods->unit_price     = $this->unit;
            $goods->goods_producer = $this->producer;
            $goods->goods_supplier = $this->supplier;
            $goods->venue_id        = $venueId;
            $goods->company_id      = $companyId;
            $goods = $goods->save() ? $goods : $goods->errors;
            if ($goods) {
                return true;
            }else{
                return $goods->errors;
            }
        }
    }

    /**
     * @云运动 - 商品管理 - 删除商品
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/21
     */
    public function delGoods($id)
    {
        // 查询该商品类型下面 是否有 有商品 1：有的话禁止删除
        $check = Goods::find()->where(["goods_type_id"=>$id])->asArray()->all();
        if(!empty($check)){
             return "请先删除类别下的商品";
        }
        $goods    = GoodsType::findOne($id);
        $delGoods = $goods->delete();
        if($delGoods) {
            return true;
        }else{
            return false;
        }
    }
}