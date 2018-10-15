<?php
/**
 * 赠送天数表
 * User: lihuien
 * Date: 2017/9/20
 * Time: 11:07
 */

namespace backend\models;
use common\models\base\GiftDay;
use yii\base\Model;

class CardGiftDayForm extends Model
{
    public $giftDay;        //赠送天数
    public $roleId;         //角色ID  json数组
    public $giftTotal;      //赠送量
    public $type;            //类型
    public $categoryId;     //卡种数组
    public $venueId;        //场馆id
    /**
     * 业务数据 - 赠送规则
     * @return array
     */
    public function rules()
    {
        return [
            [['giftDay','roleId','giftTotal','type','categoryId','venueId'],'safe']
        ];
    }
    /**
     * 业务数据 - 添加赠送天数
     * @param  $companyId
     * @param  $venueId
     * @return array
     */
    public function saveGift($companyId)
    {

        if($this->giftDay && $this->type==1){
            foreach($this->roleId as $k=>$v){
                foreach($v as $key=>$value){
                    $reGift = GiftDay::find()->where(['and',['role_id' => intval($value)],['days' => intval($this->giftDay[$k])],['venue_id' => $this->venueId],['type' => $this->type]])
                        ->andWhere(['like','category_id',$this->categoryId[$k]])
                        ->asArray()
                        ->one();
                    if(empty($reGift)){
                        $gift = new GiftDay();
                        $gift->role_id     = $value;
                        $gift->days        = $this->giftDay[$k];
                        $gift->type        = $this->type;
                        $gift->gift_amount = $this->giftTotal[$k];
                        $gift->surplus     = $this->giftTotal[$k];
                        $gift->create_at   = time();
                        $gift->update_at   = time();
                        $gift->company_id  = $companyId;
                        $gift->venue_id    = $this->venueId;
                        $gift->category_id = json_encode($this->categoryId[$k]);
                        if(!$gift->save()){
                            return $gift->errors;
                        }
                    }
                }
            }

            return true;

        }else if($this->giftDay && $this->type==2){
            foreach($this->roleId as $k=>$v){
                foreach($v as $key=>$value){
                    $reGift = GiftDay::findOne(['role_id' => intval($value),'days' => intval($this->giftDay[$k]),'venue_id' => $this->venueId,'type' => $this->type]);
                    if(empty($reGift) || empty($reGift['category_id'])){
                        $gift = new GiftDay();
                        $gift->role_id     = $value;
                        $gift->days        = $this->giftDay[$k];
                        $gift->type        = $this->type;
                        $gift->gift_amount = $this->giftTotal[$k];
                        $gift->surplus     = $this->giftTotal[$k];
                        $gift->create_at   = time();
                        $gift->update_at   = time();
                        $gift->company_id  = $companyId;
                        $gift->venue_id    = $this->venueId;
                        $gift->category_id = json_encode($this->categoryId[$k]);
                        if(!$gift->save()){
                            return $gift->errors;
                        }
                    }
                }
            }
            return true;
        }
        return false;
    }
}