<?php
namespace backend\models;

use common\models\base\Member;
use common\models\base\MemberDetails;
use common\models\base\MemberCard;
use yii\base\Model;
use common\models\Excel;


class ExcelPhone extends Model
{
    public function loadFile($file)
    {
        $model = new Excel();
        $data = $model->loadPhoneFile($file);           //excel表数据
        $num = 0;
        foreach ($data as $k => $v) {
            $memberCard = MemberCard::findOne(['card_number'=>$v[0]]);
            if($memberCard){
                $member = Member::findOne(['id'=>$memberCard->member_id]);
                if($member){
                    $member->mobile = $v[2];
                    $member->save();
                }
            }
            $num++;
            echo $num.'->';
        }
    }


}