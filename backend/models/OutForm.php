<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\GoodsDetail;
use common\models\base\GoodsChange;
class OutForm extends Model
{
    public $goodsId;                      //商品id
    public $number;                       //出库数量
    public $num;                         //自定义参数
    public $note;                         //备注

    /**
     * @云运动 - 后台 - 商品出库验证规则
     * @create 2017/8/29
     * @return array
     */
    public function rules()
    {
        return [
            [['goodsId','number'],'required'],
            [['note'],'safe'],
        ];
    }




    /**
     * 云运动 - 仓库管理 - 商品出库
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/30
     * @return boolean/object
     */
    public function outData()
    {
        $goods = GoodsDetail::findOne(['goods_id'=>$this->goodsId]);
        if(empty($goods->storage_num)||!isset($goods->storage_num)){
            return "出货数量超出库存数量";
        }
        $num = intval($goods->storage_num) - intval($this->number);
        if($num<0){
            return "出货数量超出库存数量";
        }
        $goods->storage_num = $num;
        $this->insertGoodsCharge();
        if($goods->save()){
            return true;
        }
        return $goods->errors;
    }
    /**
     * 云运动 - 仓库管理 - 商品出库变更数据
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/30
     * @return boolean/object
     */
    public function insertGoodsCharge()
    {
        $goodsChange      = GoodsChange::find()->where(['goods_id'=>$this->goodsId])->andWhere(['or','status=1','status=6'])->andWhere(['<>','surplus_amount',0])->orderBy(['create_at'=>SORT_ASC])->asArray()->all();
        $this->num = intval($this->number);
        foreach ($goodsChange as $k=>$v )
        {
            if(intval($v['surplus_amount']) >= intval($this->num)){

                $goodsObj    = GoodsChange::findOne(['id'=>$v['id']]);
                $goodsObj->surplus_amount    = $v['surplus_amount'] - intval($this->num);
                $goodsObj->save();
                $goodsDetail = new GoodsChange();
                $goodsDetail->goods_id       = $this->goodsId;
                $goodsDetail->status         = 2;
                $goodsDetail->operation_num  = intval($this->num);
                $goodsDetail->create_at      = time();
                $goodsDetail->list_num       = (string)'0'.mt_rand(0,10).time();
                $goodsDetail->unit_price     = $v['unit_price'];
                $goodsDetail->surplus_amount = intval($this->num);
                $goodsDetail->describe       = $this->note;
                if($goodsDetail->save()){
                    break;
                }else{
                    return $goodsDetail->errors;
                }
            }else{
                $this->num                   = intval($this->num) - intval($v['surplus_amount']);
                $goodsObj                    = GoodsChange::findOne(['id'=>$v['id']]);
                $goodsObj->surplus_amount    = 0;
                $goodsObj->save();

                $goodsDetail = new GoodsChange();
                $goodsDetail->goods_id       = $this->goodsId;
                $goodsDetail->status         = 2;
                $goodsDetail->operation_num  = $goodsObj['operation_num'];
                $goodsDetail->create_at      = time();
                $goodsDetail->list_num       = (string)'0'.mt_rand(0,10).time();
                $goodsDetail->unit_price     = $v['unit_price'];
//                $goodsDetail->surplus_amount = intval($this->number);
                $goodsDetail->surplus_amount = $goodsObj['operation_num'];
                $goodsDetail->describe       = $this->note;
                if($goodsDetail->save()){

                }else{
                    return $goodsDetail->errors;
                }
            }
        }


    }


}