<?php
namespace backend\models;

use yii\base\Model;
use common\models\Excel;
use common\models\base\Member;
use common\models\base\MemberDetails;
use common\models\base\MemberCard;
use common\models\base\MemberCourseOrder;
use common\models\base\MemberCourseOrderDetails;
use common\models\base\ConsumptionHistory;

class UnitDataExcel extends Model
{
    const  ANOTHER_PARAMETER = ['memberId','memberName'];
    const               INFO = [0=>'memberId',1=>'memberName'];

    public $memberId;
    public $memberName;

    public function autoLoadData($data){
        $data = array_values($data);
        $dataS = self::ANOTHER_PARAMETER;
        foreach($data as $keys=>$value){
            $key        = $dataS[$keys];
            $this->$key = $value;
        }
    }
    
    public function loadFile($file,$type = 'private',$name = '艾搏')
    {
        $model = new Excel();
        $data  = $model->loadUnitDataFile($file, $type);           //excel表数据
        $num = 0;
        foreach($data as $k=>$v){
            $xia               = Member::findOne(['id'=>$v[0]]);
            $xiaDetail         = MemberDetails::findOne(['member_id'=>$v[0]]);
            if($xia){
                //1、把旧的会员卡转到新的会员编号上
                $xiaCard = MemberCard::findOne(['member_id'=>$v[0]]);
                $xiaCard->member_id = 48437;
                $xiaCard->save();
                //2、把旧的会员私课转到新的会员编号上
                $xiaCourseOrder = MemberCourseOrder::findOne(['member_id'=>$v[0]]);
                if($xiaCourseOrder){
                    $xiaCourseOrder->member_id = 48437;
                    $xiaCourseOrder->save();
                }
                //3、把旧的消费信息转到新会员编号上
                $xiaConsumptionHistory = ConsumptionHistory::findOne(['member_id'=>$v[0]]);
                if($xiaConsumptionHistory){
                    $xiaConsumptionHistory->member_id = 48437;
                    $xiaCourseOrder->save();
                }
                //删除member、memberDetails旧的会员记录
                $xia->delete();
                $xiaDetail->delete();
            }else{
                //4、生成新的私课订单详情
                $courseOrderDetails = new MemberCourseOrderDetails();
                $courseOrderDetails->course_order_id = 24804;
                $courseOrderDetails->course_id        = 145;
                $courseOrderDetails->course_num       = 8;
                $courseOrderDetails->original_price   = 50;
                $courseOrderDetails->sale_price       = 50;
                $courseOrderDetails->type              = 1;
                $courseOrderDetails->category          = 2;
                $courseOrderDetails->product_name      = '0元WD240私教课程B';
                $courseOrderDetails->course_name       = '艾搏遗留课程';
                $courseOrderDetails->class_length      = 60;
                $courseOrderDetails->save();
                if(!$courseOrderDetails->save()){
                    return $courseOrderDetails->errors;
                }
            }
            $num++;
            echo $num;
        }




        
    }
    
    
    
    
    
    
    
    
    
    


}
