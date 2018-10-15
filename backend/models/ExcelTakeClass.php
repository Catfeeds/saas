<?php
namespace backend\models;

use common\models\base\MemberCourseOrder;
use common\models\base\MemberCourseOrderDetails;
use yii\base\Model;
use common\models\Excel;
use common\models\base\MemberCard;

class ExcelTakeClass extends Model
{
    const  PARAMETER = ['number', 'style','cardNum', 'name', 'startDate', 'endDate', 'coachStyle', 'coach', 'type', 'courseNum', 'overageSection', 'freeNum', 'freeLeft', 'unitPrice', 'takeNum', 'takeMoney', 'leftMoney'];
    const       INFO = [0 => 'number', 2 => 'style', 3 => 'cardNum', 4 => 'name', 5 => 'startDate', 6 => 'endDate', 7 => 'coachStyle', 8 => 'coach', 9 => 'type', 10 => 'courseNum', 11 => 'overageSection', 12 => 'freeNum', 13 => 'freeLeft', 14 => 'unitPrice', 15 => 'takeNum', 16 => 'takeMoney', 17 => 'leftMoney'];

    public function autoLoadData($data)
    {
        $data = array_values($data);
        $dataS = self::PARAMETER;
        foreach ($data as $keys => $value) {
            $key = $dataS[$keys];
            $this->$key = $value;
        }
    }

    public function loadFile($file)
    {
        $model = new Excel();
        $data = $model->loadTakeClassFile($file);           //excel表数据
        $num = 0;
        foreach ($data as $k => $v) {
            $memberCard = MemberCard::findOne(['card_number'=>$v[4]]);
            if($memberCard){
                $memberId    = $memberCard->member_id;
                $courseOrder = MemberCourseOrder::findOne(['member_id'=>$memberId,'course_amount'=>$v[15]]);
                if($courseOrder){
                    $courseOrderId = $courseOrder->id;
                    $courseOrder->overage_section = $v[16];
                    $courseOrder->save();
                    $orderDetail = MemberCourseOrderDetails::findOne(['course_order_id'=>$courseOrderId]);
                    if($orderDetail){
                        $orderDetail->course_num = $v[16];
                        $orderDetail->save();
                    }
                }
            }
            $num++;
            echo $num.'->';
        }
    }
}