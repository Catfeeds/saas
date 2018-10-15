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

class ExcelDelMember extends Model
{
    public function loadFile($file)
    {
        $model = new Excel();
        $data = $model->loadDelMemberFile($file);
        $num = 0;
        foreach ($data as $k => $v) {
            //1、删除：通店信息、消费历史 、会员、会员详情、会员卡
            $memberCard = MemberCard::findOne(['card_number'=>$v[2]]);
            if($memberCard){
                $memberCardId = $memberCard->id;
                $memberId     = $memberCard->member_id;
                //1、删除通店信息
                VenueLimitTimes::deleteAll(['member_card_id'=>$memberCardId]);
                //2、删除消费记录
                ConsumptionHistory::deleteAll(['consumption_type_id'=>$memberCardId]);
                //3、删除会员
                Member::deleteAll(['id'=>$memberId]);
                //4、删除会员详情
                MemberDetails::deleteAll(['member_id'=>$memberId]);
                //5、删除会员卡
                MemberCard::deleteAll(['card_number'=>$v[2]]);
            }
            $num++;
            echo $num.'->';
        }
    }
}