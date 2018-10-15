<?php
namespace backend\models;
use common\models\base\CardCategory;
use common\models\base\CardDiscount;
use common\models\base\LimitCardNumber;
use yii\base\Model;
class CardEdit extends Model
{
    public $cardCategoryId;        //卡种ID
    public $venueId;               //售卖场馆ID
    public $surplus;
    public $originalPrice;        //一口价原价
    public $sellPrice;            //一口价售价
    public $minPrice;             //区间价：最低价
    public $maxPrice;             //区间价：最高价
    public $sellStartTime;        //售卖开始时间
    public $sellEndTime;          //售卖结束时间
    public $discount;             //折扣数组
    public $discountNum;          //折扣价售卖数 数组
    public $limitId;

    /**
     * 云运动 - 会员卡 -  表单验证规则
     * @author 焦冰洋<jiaobingyang @itsports.club>
     * @create 2017/8/07
     * @return array
     */
    public function rules()
    {
        return [
            [['cardCategoryId',"venueId","originalPrice",'surplus',"sellPrice",'limitId','discount','discountNum',"minPrice","maxPrice","sellStartTime","sellEndTime"],'safe']
        ];
    }

    /**
     * 云运动 - 会员卡 -  会员卡编辑
     * @author 焦冰洋<jiaobingyang @itsports.club>
     * @create 2017/8/07
     * @return array
     */
    public function editCard()
    {
        $card = CardCategory::findOne(["id"=>$this->cardCategoryId]);
        $card->original_price = $this->originalPrice;
        $card->sell_price = $this->sellPrice;
        $card->min_price = $this->minPrice;
        $card->max_price = $this->maxPrice;

        if(!$card->save()){
            return $card->errors;
        }
        
        $limitCard = LimitCardNumber::findOne([
            "card_category_id"=>$this->cardCategoryId,
            "venue_id"=>$this->venueId,
        ]);
        $limitCard->sell_start_time = intval(strtotime($this->sellStartTime));
        $limitCard->sell_end_time   = intval(strtotime($this->sellEndTime.' 23:59:59'));
        $limitCard->surplus         = $this->surplus;
        if(!$limitCard->save()){
            return $limitCard->errors;
        }
        $limit = $this->updateCardDiscount();
        if($limit !== true){
            return $limit;
        }
        return true;
    }
    /**
     * 云运动 - 会员卡 -  会员卡编辑
     * @author 李慧恩<修改折扣 @itsports.club>
     * @create 2017/8/07
     * @return array
     */
    public function updateCardDiscount()
    {
        $cardDiscount = CardDiscount::find()->where(['limit_card_id' => $this->limitId])->asArray();
        if(!empty($cardDiscount->all())){
            $idArr  = array_column($cardDiscount->all(),'id');
            $data   = [];
            $data[] = [$this->discount,$this->discountNum,$idArr];
            $discountArr    = $data[0][0];
            $discountNumArr = $data[0][1];
            $idArr          = $data[0][2];
            if(count($this->discount) >= $cardDiscount->count()){
                foreach($discountArr as $key=>$value){
                    if(!empty($idArr[$key])){
                        $discount = CardDiscount::findOne(['id' => $idArr[$key]]);
                        $discount->discount  = $value;
                        $discount->surplus   = $discountNumArr[$key];
                        $discount->update_at = time();
                    }else{
                        $discount = new CardDiscount();
                        $discount->limit_card_id = $this->limitId;
                        $discount->discount      = $value;
                        $discount->surplus       = $discountNumArr[$key];
                        $discount->create_at     = time();
                        $discount->update_at     = time();
                    }
                    if ($discount->save() != true) {
                        return $discount->errors;
                    }
                }
                return true;
            }else{
                foreach($idArr as $key=>$value){
                    $discount = CardDiscount::findOne(['id' => $value]);
                    if(isset($discountArr[$key])){
                        $discount->discount  = $discountArr[$key];
                        $discount->surplus   = $discountNumArr[$key];
                        $discount->update_at = time();
                        if ($discount->save() != true) {
                            return $discount->errors;
                        }
                    }else{
                        $discount->delete();
                    }
                }
                return true;
            }
        }else{
            if(!empty($this->discount) && !empty($this->discountNum)){
                $data   = [];
                $data[] = [$this->discount,$this->discountNum];
                $discountArr    = $data[0][0];
                $discountNumArr = $data[0][1];
                foreach($discountArr as $key=>$value){
                    $discount = new CardDiscount();
                    $discount->limit_card_id = $this->limitId;
                    $discount->discount      = $value;
                    $discount->surplus       = $discountNumArr[$key];
                    $discount->create_at     = time();
                    $discount->update_at     = time();
                    if ($discount->save() != true) {
                        return $discount->errors;
                    }
                }
                return true;
            }
            return true;
        }
//        $discount = new \backend\models\CardDiscount();
//        $discountArr = $discount->getCardDiscount($this->limitId);
//        if(!empty($discountArr)){
//            foreach ($discountArr as $k=>$value){
//                $discountModel = CardDiscount::findOne(['id'=>$value['id']]);
//                $discountModel->surplus  = $this->oldDiscount[$k]['surplus'];
//                $discountModel->discount = $this->oldDiscount[$k]['discount'];
//                $discountModel->update_at = time();
//                if(!$discountModel->save()){
//                    return $discountModel->errors;
//                }
//            }
//        }
//        if (!empty($this->newDiscount)){
//            foreach ($this->newDiscount as $k=>$v){
//                $model = new CardDiscount();
//                $model->limit_card_id = $this->limitId;
//                $model->surplus  = $v['surplus'];
//                $model->discount = $v['discount'];
//                $model->create_at = time();
//                $model->update_at = time();
//                if(!$model->save()){
//                    return $model->errors;
//                }
//            }
//        }
//        return true;
    }
}