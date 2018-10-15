<?php
namespace backend\models;

use common\models\base\ConsumptionHistory;
use common\models\base\Member;
use common\models\base\MemberCard;
use common\models\base\MemberCourseOrder;
use common\models\Excel;
use yii\base\Model;


class JingExcel extends Model
{
    const ANOTHER_PARAMETER = ['memberId', 'name'];
    const INFO = [0 => 'memberId', 1 => 'name'];

    public $memberId;
    public $name;

    public function autoLoadData($data)
    {
        $data = array_values($data);
        $dataS = self::ANOTHER_PARAMETER;
        foreach ($data as $keys => $value) {
            $key = $dataS[$keys];
            $this->$key = $value;
        }
    }

    public function LoadFile($file)
    {
        $model = new Excel();
        $data = $model->loadJingFile($file);
        $num = 0;
        foreach($data as $k=>$v){
            $member = Member::findOne(['id'=>$v[0]]);
            if($member){
                $member->status = 1;
                $member->venue_id = 2;
                $member->company_id = 1;
                $member->save();
            }
            $card = MemberCard::findOne(['card_number'=>10000252]);
            if($card){
                $card->member_id = 15787;
                $card->save();
            }
            MemberCourseOrder::updateAll(['member_id'=>$v[0],'seller_id'=>8],['member_card_id'=>2353]);
            $course = MemberCourseOrder::findOne(['id'=>1344]);
            if($course){
                $course->money_amount    = 6250;
                $course->overage_section = 13;
                $course->save();
            }
            $num++;
            echo $num;
        }
    }
    
}