<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\MobiliseType;
use common\models\base\Goods;
use common\models\base\GoodsDetail;
use common\models\base\GoodsChange;
class MobiliseCompleteForm extends Model
{
    public $oldGoodsId;                      //老商品id (申请方)
    public $newGoodsId;                      //新商品id(被申请方)
    public $number;                       //操作数量
    public $oldStoreId;                   //原仓库id
    public $newStoreId;                   //新仓库id
    public $mobiliseId;                   //调拨id
    public $num ;                           //自定义参数
    const NOTICE = '操作失败';
    /**
     * @云运动 - 后台 - 调拨验证规则
     * @create 2017/9/1
     * @return array
     */
    public function rules()
    {
        return [
            [['oldGoodsId','newGoodsId','number','oldStoreId','newStoreId','mobiliseId'],'required'],
        ];
    }




    /**
     * 云运动 - 仓库管理 - 调拨确定
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/9/1
     * @return boolean/object
     */
    public function updateData()
    {
        $newGoods        = Goods::find()->where(['id'=>$this->newGoodsId])->andWhere(['store_id'=>$this->newStoreId])->one();
        $newGoodsDetail  = GoodsDetail::findOne(['goods_id'=>$newGoods['id']]);
        $oldGoods        = Goods::find()->where(['id'=>$this->oldGoodsId])->andWhere(['store_id'=>$this->oldStoreId])->one();
        $oldGoodsDetail  = GoodsDetail::findOne(['goods_id'=>$oldGoods['id']]);
        $mobiliseType    = MobiliseType::findOne(['mobilise_id'=>$this->mobiliseId]);
        $transaction     = Yii::$app->db->beginTransaction();
        try {

        if(empty($newGoodsDetail->storage_num)||!isset($newGoodsDetail->storage_num)){
            return "调拨数量超出库存数量";
        }
        if($newGoods['goods_attribute']!==$oldGoods['goods_attribute'] ||$newGoods['unit']!==$oldGoods['unit']||$newGoods['goods_name']!==$oldGoods['goods_name'])
        {
            return "被调拨商品类型或者品类或者单位或者名称与原商品不符";
        }
        $num = intval($newGoodsDetail->storage_num) - intval($this->number);
        if($num<0){
               return "调拨数量超出库存数量";
        }
        $newGoodsDetail->storage_num = $num;
        $this->outGoodsCharge();
        $newGoodsDetail             = $newGoodsDetail->save() ? $newGoodsDetail : $newGoodsDetail->errors;

//        $oldGoodsDetail->storage_num = intval($oldGoodsDetail->storage_num) + intval($this->number);
//        $this->insertGoodsCharge();
//        $oldGoodsDetail             = $oldGoodsDetail->save() ? $oldGoodsDetail : $oldGoodsDetail->errors;

        $mobiliseType->type = 3;
        $mobiliseType             = $mobiliseType->save() ? $mobiliseType : $mobiliseType->errors;

            if (!isset($newGoodsDetail->id) && !isset($oldGoodsDetail->id)&& !isset($mobiliseType->id)) {
                throw new \Exception(self::NOTICE);
            }


            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            return $e->getMessage();
        }
    }
    /**
     * 云运动 - 仓库管理 - 商品出库变更数据
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/9/2
     * @return boolean/object
     */
    public function outGoodsCharge()
    {
//        $goodsDetail = new GoodsChange();
//        $goodsDetail->goods_id      = $this->newGoodsId;
//        $goodsDetail->status        = 7;
//        $goodsDetail->operation_num = $this->number;
//        $goodsDetail->create_at     = time();
//        $goodsDetail->describe      = '调拨出库方';
//        $goodsDetail->list_num      = (string)'0'.mt_rand(0,10).time();
//        if($goodsDetail->save()){
//            return true;
//        }
//        return $goodsDetail->errors;

        $goodsChange      = GoodsChange::find()->where(['goods_id'=>$this->newGoodsId])->andWhere(['or','status=1','status=6'])->andWhere(['<>','surplus_amount',0])->orderBy(['create_at'=>SORT_ASC])->asArray()->all();
        $this->num = intval($this->number);
        foreach ($goodsChange as $k=>$v )
        {
            if(intval($v['surplus_amount']) >= intval($this->num)){

                $goodsObj    = GoodsChange::findOne(['id'=>$v['id']]);
                $goodsObj->surplus_amount    = $v['surplus_amount'] - intval($this->num);
                $goodsObj->save();
                $goodsDetail = new GoodsChange();
                $goodsDetail->goods_id       = $this->newGoodsId;
                $goodsDetail->status         = 7;
                $goodsDetail->operation_num  = intval($this->num);
                $goodsDetail->create_at      = time();
                $goodsDetail->list_num       = (string)'0'.mt_rand(0,10).time();
                $goodsDetail->unit_price     = $v['unit_price'];
                $goodsDetail->surplus_amount = intval($this->num);
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
                $goodsDetail->goods_id       = $this->newGoodsId;
                $goodsDetail->status         = 7;
                $goodsDetail->operation_num  = $goodsObj['operation_num'];
                $goodsDetail->create_at      = time();
                $goodsDetail->list_num       = (string)'0'.mt_rand(0,10).time();
                $goodsDetail->unit_price     = $v['unit_price'];
                $goodsDetail->surplus_amount = $goodsObj['operation_num'];
                if($goodsDetail->save()){

                }else{
                    return $goodsDetail->errors;
                }
            }
        }
    }

//    /**
//     * 云运动 - 仓库管理 - 商品入库变更数据
//     * @author huanghua <huanghua@itsports.club>
//     * @create 2017/9/2
//     * @return boolean/object
//     */
//    public function insertGoodsCharge()
//    {
//        $goodsChange = GoodsChange::find()->where(['goods_id'=>$this->newGoodsId])->andWhere(['or','status=1','status=6'])->andWhere(['<>','surplus_amount',0])->orderBy(['create_at'=>SORT_ASC])->asArray()->one();
//        $goodsDetail = new GoodsChange();
//        $goodsDetail->goods_id       = $this->oldGoodsId;
//        $goodsDetail->status         = 6;
//        $goodsDetail->operation_num  = $this->number;
//        $goodsDetail->create_at      = time();
//        $goodsDetail->list_num       = (string)'0'.mt_rand(0,10).time();
//        $goodsDetail->unit_price     = $goodsChange['unit_price'];
//        $goodsDetail->surplus_amount = $goodsChange['surplus_amount'];
//        $goodsDetail->describe       = '调拨入库方';
//        if($goodsDetail->save()){
//            return true;
//        }
//        return $goodsDetail->errors;
//    }


}