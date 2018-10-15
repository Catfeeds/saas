<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\GoodsDetail;
use common\models\base\GoodsChange;
class BreakageForm extends Model
{
    public $goodsId;                      //商品id
    public $number;                       //入库数量
    public $note;                         //备注
    public $status;                       //3报损5报溢
    public $goodsChangeId;               //入库记录id
    public $unitPrice;                   //单价
    /**
     * @云运动 - 后台 - 商品入库验证规则
     * @create 2017/8/29
     * @return array
     */
    public function rules()
    {
        return [
            [['goodsId','number','note','goodsChangeId','unitPrice'],'required'],
            [['status'],'safe'],
        ];
    }

    /**
     * 云运动 - 仓库管理 - 商品报损变更数据
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/30
     * @return boolean/object
     */
    public function addBreakData()
    {
        $goods = GoodsDetail::findOne(['goods_id'=>$this->goodsId]);
        if(empty($goods->storage_num)||!isset($goods->storage_num)){
            return "报损或者报溢数量超出库存数量";
        }
        $num = intval($goods->storage_num) - intval($this->number);
        if($num<0){
            return "报损或者报溢数量超出库存数量";
        }
        $goods->storage_num = $num;
        $this->insertGoodsCharge();
        if($goods->save()){
            return true;
        }
        return $goods->errors;
    }

    /**
     * 云运动 - 仓库管理 - 商品报损报溢变更数据
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/30
     * @return boolean/object
     */
    public function insertGoodsCharge()
    {
        $goodsChange = GoodsChange::findOne(['id'=>$this->goodsChangeId]);
        if(empty($goodsChange->surplus_amount)||!isset($goodsChange->surplus_amount)){
            return "报损或者报溢数量超出库存数量";
        }
        $num = intval($goodsChange->surplus_amount) - intval($this->number);
        if($num<0){
            return "报损或者报溢数量超出库存数量";
        }
        $goodsChange->surplus_amount= $num;
        $goodsChange->save();
        $goodsDetail = new GoodsChange();
        $goodsDetail->goods_id      = $this->goodsId;
        if($this->status == 3){
            $goodsDetail->status        = 3;//报损
        }else{
            $goodsDetail->status        = 5;//报溢
        }
        $goodsDetail->unit_price    = $this->unitPrice;
        $goodsDetail->operation_num = $this->number;
        $goodsDetail->list_num      = (string)'0'.mt_rand(0,10).time();
        $goodsDetail->create_at     = time();
        $goodsDetail->describe      = $this->note;
        $goodsDetail->surplus_amount= $this->number;
        if($goodsDetail->save()){
            return true;
        }
        return $goodsDetail->errors;
    }

}