<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\GoodsDetail;
use common\models\base\GoodsChange;
class AccessForm extends Model
{
    public $goodsId;                      //商品id
    public $number;                       //入库数量
    public $note;                         //备注
    public $unitPrice;                    //单价
    public $type;                         //1进货2调拨

    /**
     * @云运动 - 后台 - 商品入库验证规则
     * @create 2017/8/29
     * @return array
     */
    public function rules()
    {
        return [
            [['goodsId','number','type'],'required'],
            [['note'],'safe'],
        ];
    }




    /**
     * 云运动 - 仓库管理 - 商品入库
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/30
     * @return boolean/object
     */
    public function addShopData($post)
    {
        $goods = GoodsDetail::findOne(['goods_id'=>$this->goodsId]);
        if(empty($goods)){
            $goodsDetail = new GoodsDetail();
            $goodsDetail->goods_id    = $this->goodsId;
            $goodsDetail->storage_num = $this->number;
            $goodsDetail->create_at   = time();
            $goodsDetail->note        = $this->note;
            $goodsDetail->unit_price  = $this->unitPrice;
            $this->insertGoodsCharge($post);
            if($goodsDetail->save()){
                return true;
            }
            return $goodsDetail->errors;
        }else{
            $goods->storage_num = intval($goods->storage_num) + intval($this->number);
            $this->insertGoodsChargeS($post);
            if($goods->save()){
                return true;
            }
            return $goods->errors;
        }
    }
    /**
     * 云运动 - 仓库管理 - 商品入库变更数据
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/30
     * @return boolean/object
     */
    public function insertGoodsCharge($post)
    {
        $goodsDetails = new GoodsChange();
        $goodsDetails->goods_id      = $this->goodsId;
        if($this->type == 1){
            $goodsDetails->status        = 1;
        }else{
            $goodsDetails->status        = 6;
        }
        $goodsDetails->operation_num = $this->number;
        $goodsDetails->create_at     = time();
        $goodsDetails->describe      = $this->note;
        $goodsDetails->list_num      = (string)'0'.mt_rand(0,10).time();
        $goodsDetails->unit_price    = $post['unitPrice'];
        $goodsDetails->surplus_amount= $post['number'];
        $goodsDetails->type          = $post['type'];//1进货2调拨
        if($goodsDetails->save()){
            return true;
        }
        return $goodsDetails->errors;
    }

    /**
     * 云运动 - 仓库管理 - 商品入库变更数据
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/30
     * @return boolean/object
     */
    public function insertGoodsChargeS($post)
    {
        $goodsDetail = new GoodsChange();
        $goodsDetail->goods_id      = $this->goodsId;
        if($this->type == 1){
            $goodsDetail->status        = 1;
        }else{
            $goodsDetail->status        = 6;
        }
        $goodsDetail->operation_num = $this->number;
        $goodsDetail->create_at     = time();
        $goodsDetail->describe      = $this->note;
        $goodsDetail->list_num      = (string)'0'.mt_rand(0,10).time();
        $goodsDetail->unit_price    = $post['unitPrice'];
        $goodsDetail->surplus_amount= $post['number'];
        $goodsDetail->type          = $post['type'];//1进货2调拨
        if($goodsDetail->save()){
            return true;
        }
        return $goodsDetail->errors;
    }


}