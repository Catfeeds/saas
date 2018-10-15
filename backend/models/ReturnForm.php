<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\GoodsDetail;
use common\models\base\GoodsChange;
class ReturnForm extends Model
{
    public $goodsId;                      //商品id
    public $number;                       //退货数量
    public $note;
    public $goodsChangeId;               //入库记录id
    public $unitPrice;                   //单价
    /**
     * @云运动 - 后台 - 商品退库验证规则
     * @create 2017/8/29
     * @return array
     */
    public function rules()
    {
        return [
            [['goodsId','number','note','goodsChangeId','unitPrice'],'required'],
        ];
    }




    /**
     * 云运动 - 仓库管理 - 商品退库
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/30
     * @return boolean/object
     */
    public function returnData()
    {
        $goods = GoodsDetail::findOne(['goods_id'=>$this->goodsId]);
        if(empty($goods->storage_num)||!isset($goods->storage_num)){
            return "退库数量超出库存数量";
        }
        $num = intval($goods->storage_num) - intval($this->number);
        if($num<0){
            return "退库数量超出库存数量";
        }
        $goods->storage_num = $num;
        $this->insertGoodsCharge();
        if($goods->save()){
            return true;
        }
        return $goods->errors;
    }
    /**
     * 云运动 - 仓库管理 - 商品退库变更数据
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/30
     * @return boolean/object
     */
    public function insertGoodsCharge()
    {
        $goodsChange = GoodsChange::findOne(['id'=>$this->goodsChangeId]);
        if(empty($goodsChange->surplus_amount)||!isset($goodsChange->surplus_amount)){
            return "退库数量超出库存数量";
        }
        $num = intval($goodsChange->surplus_amount) - intval($this->number);
        if($num<0){
            return "退库数量超出库存数量";
        }
        $goodsChange->surplus_amount= $num;
        $goodsChange->save();
        $goodsDetail = new GoodsChange();
        $goodsDetail->goods_id      = $this->goodsId;
        $goodsDetail->status        = 4;
        $goodsDetail->operation_num = $this->number;
        $goodsDetail->create_at     = time();
        $goodsDetail->list_num      = (string)'0'.mt_rand(0,10).time();
        $goodsDetail->describe      = $this->note;
        $goodsDetail->surplus_amount= $this->number;
        $goodsDetail->unit_price    = $this->unitPrice;
        if($goodsDetail->save()){
            return true;
        }
        return $goodsDetail->errors;
    }


}