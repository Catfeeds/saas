<?php
namespace backend\models;

use common\models\base\CardCategory;
use common\models\base\LimitCardNumber;
use common\models\base\Organization;
use common\models\base\VenueLimitTimes;
use common\models\base\Member;
use yii\base\Model;
use common\models\Excel;
use common\models\base\MemberCard;

class ExcelCardCategory extends Model
{
    const  PARAMS = ['cardNumber', 'name', 'sex', 'chargeDate', 'cardCategory', 'NewCardCategory', 'startTime', 'invalidTime', 'money', 'oweMoney', 'seller','mobile', 'note'];
    const  INFO   = [0 => 'cardNumber', 1 => 'name', 2 => 'sex', 3 => 'chargeDate', 4 => 'cardCategory', 5 => 'NewCardCategory', 6 => 'startTime', 7 => 'invalidTime', 8 => 'money', 9 => 'oweMoney', 10 => 'seller', 11 => 'mobile', 12 => 'note'];

    public $memberId;
    public $memberName;

    public function autoLoadData($data)
    {
        $data = array_values($data);
        $dataS = self::PARAMS;
        foreach ($data as $keys => $value) {
            $key = $dataS[$keys];
            $this->$key = $value;
        }
    }

    public function loadFile($file)
    {
        $model = new Excel();
        $data  = $model->loadCardCategoryFile($file);
        $num   = 0;
        foreach ($data as $k => $v) {
            $memberCard = MemberCard::find()->where(['card_number' => $v[0]])->one();
            if ($memberCard) {
                //改变会员绑定的卡种
                $memberId     = $memberCard->member_id;
                $venueId      = Member::find()->where(['id'=>$memberId])->one()->venue_id;
//                if($venueId == 15){
//                    $venueId = 11;
//                }
                $cardName = str_replace(' ', '', $v[5]);
                $cardCategory = CardCategory::find()->where(['card_name' => $cardName, 'venue_id' => $venueId])->orderBy('id DESC')->one();
                if ($cardCategory) {
                    $cardCategoryId = $cardCategory->id;
                    $memberCard->card_category_id = $cardCategoryId;
                    $memberCard->leave_total_days = $cardCategory->leave_total_days;
                    $memberCard->leave_least_days = $cardCategory->leave_least_Days;
                    $memberCard->leave_days_times = $cardCategory->leave_long_limit;
                    $memberCard->transfer_num     = $cardCategory->transfer_number;
                    $memberCard->surplus           = $cardCategory->transfer_number;
                    $memberCard->transfer_price   = $cardCategory->transfer_price;
                    $memberCard->save();
                    //获取用户会员卡id
                    $memberCardId = $memberCard->id;
                    //1、删除老卡的通店参数：venue_limit_times里面这张卡的数据
                    VenueLimitTimes::deleteAll(['member_card_id'=>$memberCardId]);
                    //2、获取新卡种的通用场馆参数
                    $limitCardNumber = LimitCardNumber::find()->where(['card_category_id' => $cardCategoryId])->asArray()->all();
                    //3、添加新卡种的通店场馆参数
                    if($limitCardNumber){
                        foreach($limitCardNumber as $key=>$val){
                            if($val['status'] == 1 || $val['status'] == 3){
                                $venueLimitTimes = new VenueLimitTimes();
                                $venueLimitTimes->member_card_id = $memberCardId;
                                $venueLimitTimes->venue_id       = $val['venue_id'];
                                $venueLimitTimes->total_times    = $val['times'];
                                if(!empty($val['times'])){
                                    $venueLimitTimes->overplus_times = $val['times'];
                                }else{
                                    $venueLimitTimes->overplus_times = $val['week_times'];
                                }
                                $venueLimitTimes->week_times     = $val['week_times'];
                                $venueLimitTimes->level          = $val['level'];
                                $venueLimitTimes->save();
                            }
                        }
                    }
                }
            }
            $num++;
            echo $num.'->';
        }
    }

}