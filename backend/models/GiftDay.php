<?php
namespace backend\models;
use common\models\base\CardCategory;
use common\models\relations\GiftDayRelations;

class GiftDay extends \common\models\base\GiftDay
{
    use GiftDayRelations;
    public $discounts; //折扣数组
    public $roleId;    //角色id数组
    /**
     * @云运动 - 潜在会员购卡 - 遍历赠送天数
     * @author huanghua <huanghua@itsports.club>
     * @param $roleId
     * @create 2017/10/13
     * @return array
     */
    public function giftDayData($roleId,$categoryId)
    {
        return self::find()
            ->joinWith(['role role'],false)
            ->where(['role_id'=>$roleId])
            ->andWhere(['like','category_id','"'.$categoryId.'"'])
            ->andWhere(['type'=>1])
            ->asArray()
            ->all();
    }
    /**
     * @云运动 - 潜在会员购卡 - 遍历赠送天数
     * @author huanghua <huanghua@itsports.club>
     * @param $roleId
     * @create 2017/10/16
     * @return array
     */
    public function giftMemberDayData($roleId)
    {
        return self::find()
            ->joinWith(['role role'],false)
            ->where(['role_id'=>$roleId])
            ->andWhere(['type'=>2])
            ->asArray()
            ->all();
    }

    /**
     * 云运动 - 卡种管理 - 设置 - 获取赠送天数
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/21
     * @return string
     */
    public function getGiftData($type,$venueId)
    {
        $data = GiftDay::find()
            ->alias('gd')
            ->joinWith(['role role'],false)
            ->where(['and',['gd.type' => $type],['gd.venue_id' => $venueId]])
            ->select('gd.id,gd.days,gd.gift_amount,gd.category_id,gd.role_id,role.name')
            ->asArray()
            ->all();
        if($type == '1'){
            $data['card'] = [];
            foreach ($data as $key=>$value) {
                if(!empty($value['category_id'])){
                    $categoryId = json_decode($value['category_id'],true);
                    $value['card'] = CardCategory::find()->where(['id' => $categoryId])->select('id,card_name')->asArray()->all();
                    array_push($data['card'],$value);
                }else{
                    $value['card'] = null;
                    array_push($data['card'],$value);
                }
            }
            array_pop($data['card']);      //删除数组的最后一个值
            return $data['card'];
        }
        return $data;
    }

    /**
     * 云运动 - 卡种管理 - 设置 - 删除赠送天数
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/21
     * @return boolean
     */
    public function delGiftData($giftId)
    {
        $gift = \common\models\base\GiftDay::findOne(['id' => $giftId]);
        if($gift->delete()){
            return true;
        }else{
            return $gift->errors;
        }
    }

    /**
     * @私教产品 - 设置 - 设置折扣
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/03/09
     * @return bool|string
     */
    public function setChargeDiscounts($data,$companyId,$venueId)
    {
        $this->discounts = $data['discounts'];  //折扣数组
        $this->roleId    = $data['roleId'];     //角色数组
        if($this->discounts){
            foreach($this->roleId as $k=>$v){
                foreach($v as $key=>$value){
//                    if(is_array($this->discounts[$k])){
//                        $reGift = GiftDay::find()->where(['and',['role_id' => intval($value)],['venue_id' => $venueId],['like','category_id',json_encode($this->discounts[$k])],['type' => 3]])->asArray()->one();
//                    }else{
//                        $reGift = GiftDay::find()->where(['and',['role_id' => intval($value)],['venue_id' => $venueId],['like','category_id',json_encode([$this->discounts[$k]])],['type' => 3]])->asArray()->one();
//                    }
                    $reGift = GiftDay::find()->where(['and',['role_id' => intval($value)],['venue_id' => $venueId],['type' => 3]])->asArray()->one();
                    $reGift = GiftDay::findOne(['id' => $reGift['id']]);
                    if(isset($reGift)){
                        if(is_array($this->discounts[$k])){
                            $reGift->category_id = json_encode($this->discounts[$k]);
                        }else{
                            $reGift->category_id = json_encode([$this->discounts[$k]]);
                        }
                        if(!$reGift->save()){
                            return $reGift->errors;
                        }
                    }else{
                        $gift = new GiftDay();
                        $gift->type        = 3;
                        $gift->company_id  = $companyId;
                        $gift->venue_id    = $venueId;
                        $gift->create_at   = time();
                        $gift->update_at   = time();
                        $gift->role_id     = $value;
                        if(is_array($this->discounts[$k])){
                            $gift->category_id = json_encode($this->discounts[$k]);
                        }else{
                            $gift->category_id = json_encode([$this->discounts[$k]]);
                        }
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

    /**
     * @私教产品 - 设置 - 获取折扣
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/03/15
     * @return bool|string
     */
    public function getSetDiscounts($venueId)
    {
        $query = GiftDay::find()
            ->alias('gd')
            ->joinWith(['role role'],false)
            ->where(['type' => 3,'venue_id' => $venueId])
            ->select('gd.id,gd.type,gd.venue_id,gd.role_id,gd.category_id,role.name')
            ->asArray()->all();
//        $query['discounts'] = [];
//        foreach ($query as $key => $value) {
//            if(!empty($value['category_id'])){
//                $discounts = json_decode($value['category_id'],true);
//                array_push($query['discounts'],$discounts);
//            }
//        }
        return $query;
    }

    /**
     * @会员管理 - 私课购买 - 获取私课折扣
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/03/09
     * @return bool|string
     */
    public function getChargeDiscounts()
    {
        $roleId = \Yii::$app->user->identity->role;
        $query  = \common\models\base\GiftDay::find()
            ->where(['type' => 3,'role_id' => $roleId['id']])
            ->select('id,category_id')
            ->asArray()->all();
        if(isset($query)){
            $discountsArr = [];
            foreach ($query as $key => $value) {
                $discounts = json_decode($value['category_id'],true);
                array_push($discountsArr,$discounts);
            }
            if(!empty($discountsArr)){
                $discountsArr = call_user_func_array('array_merge',$discountsArr);   //把二维数组转化为一维数组
                return array_unique($discountsArr);   //返回过滤掉重复值的数据
            }
        }
        return null;
    }
}