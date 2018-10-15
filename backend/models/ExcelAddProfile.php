<?php
namespace backend\models;

use common\models\base\CardCategory;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\MemberDetails;
use common\models\Excel;
use yii\base\Model;


class ExcelAddProfile extends Model
{

    public function LoadFile($file)
    {
        $model = new Excel();
        $data = $model->loadAddProfileFile($file);
        $num = 0;
        foreach ($data as $k => $v) {
            $memberCard = MemberCard::findOne(['card_number'=>$v[0]]);
            if($memberCard){
                $memberCard->active_time = $v[6];
                $memberCard->invalid_time = $v[7];
                if(!$memberCard->save()){
                    return $memberCard->errors;
                }
                $memberId = $memberCard->member_id;
                if($memberId){
                    $member = Member::findOne(['id'=>$memberId]);
                    if($member){
                        $member->username = $v[1];
                        $member->mobile = $v[3];
                        if(!$member->save()){
                            return $member->errors;
                        }
                    }
                    $memberDetails = MemberDetails::findOne(['member_id'=>$memberId]);
                    if($memberDetails){
                        $memberDetails->name = $v[1];
                        $memberDetails->id_card = $v[2];
                        if(!$memberDetails->save()){
                            return $memberDetails->errors;
                        }
                    }
                }
            }
            $num++;
            echo $num.'->';
        }
    }
}