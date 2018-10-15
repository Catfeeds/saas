<?php
namespace backend\models;

use common\models\base\CardCategory;
use common\models\base\ConsumptionHistory;
use common\models\base\Member;
use common\models\base\MemberDetails;
use common\models\base\MemberCard;
use common\models\base\VenueLimitTimes;
use yii\base\Model;
use common\models\Excel;

class ExcelCollege extends Model
{
    public function loadFile($file)
    {
        $model = new Excel();
        $data = $model->loadCollegeFile($file);         
        $num = 0;
        foreach ($data as $k => $v) {
            //1、绑定正确的卡种
            $memberCard = MemberCard::findOne(['card_number' => $v[1]]);
            if ($memberCard) {
                $memberId = $memberCard->member_id;
                $venueId = Member::findOne(['id' => $memberId])->venue_id;
                if ($v[5] == 'Fitness T12M') {
                    $cardName = 'FT12MD';
                    $cardCategory = CardCategory::findOne(['card_name' => $cardName, 'venue_id' => $venueId]);
                } elseif ($v[5] == 'Fitness T24M') {
                    $cardName = 'FT24MD';
                    $cardCategory = CardCategory::findOne(['card_name' => $cardName, 'venue_id' => $venueId]);
                } else {
                    $cardName = $v[5];
                    $cardCategory = CardCategory::findOne(['card_name' => $cardName]);
                }
                //2、改正到期时间
                if ($cardCategory) {
                    $memberCard->card_category_id = $cardCategory->id;
                    $memberCard->card_name = $cardCategory->card_name;
                    $memberCard->create_at = $v[7];
                    $memberCard->active_time = $v[7];
                    $memberCard->invalid_time = $v[8];
                    $memberCard->save();
                    //3、改正消费金额和消费日期
                    $consumption = ConsumptionHistory::findOne(['consumption_type_id' => $memberCard->id]);
                    if ($consumption) {
                        $consumption->consumption_date = $v[7];
                        $consumption->cash_payment = $v[6];
                        $consumption->consumption_amount = $v[6];
                        $consumption->due_date = $v[8];
                        $consumption->save();
                    }
                    //获取用户会员卡id
                    $memberCardId = $memberCard->id;
                    //1、删除老卡的通店参数：venue_limit_times里面这张卡的数据
                    VenueLimitTimes::deleteAll(['member_card_id' => $memberCardId]);
                    //2、获取新卡种的通用场馆参数
                    $limitCardNumber = LimitCardNumber::find()->where(['card_category_id' => $cardCategory->id])->asArray()->all();
                    //3、添加新卡种的通店场馆参数
                    if ($limitCardNumber) {
                        foreach ($limitCardNumber as $key => $val) {
                            $venueLimitTimes = new VenueLimitTimes();
                            $venueLimitTimes->member_card_id = $memberCardId;
                            $venueLimitTimes->venue_id = $val['venue_id'];
                            $venueLimitTimes->total_times = $val['times'];
                            $venueLimitTimes->overplus_times = $val['times'];
                            $venueLimitTimes->level = $val['level'];
                            $venueLimitTimes->save();
                        }
                    }
                }
            }
            $num++;
            echo $num . '->';
        }
    }

}