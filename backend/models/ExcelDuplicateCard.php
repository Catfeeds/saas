<?php
namespace backend\models;
use common\models\base\ConsumptionHistory;
use common\models\base\Employee;
use common\models\base\Member;
use common\models\base\Organization;
use yii\base\Model;
use common\models\Excel;
use common\models\base\MemberCard;
use Yii;

class ExcelDuplicateCard extends Model
{
    public $companyId;
    public $venueId;
    public $cardCategoryId;
    public $counselorId;

    public function loadFile($file,$company,$venue)
    {
        $model = new Excel();
        $data  = $model->loadDuplicateCardFile($file);
        $num   = 0;
        foreach ($data as $k => $v) {
            $this->companyId = $this->getCompanyId($company);
            $this->venueId = $this->getVenueId($venue);
            $this->counselorId = $this->getCounselorId($v[10],$venue);
            $cardMember = MemberCard::findOne(['card_number'=>$v[1]]);
            if($cardMember){
                $cardMemberId = $cardMember->member_id;
                $mobileMember = Member::findOne(['mobile'=>$v[12]]);
                if($mobileMember){
                    $mobileMemberId = $mobileMember->id;
                    if($cardMemberId !== $mobileMemberId){
                        //按照手机号码把会员卡转给对应的会员
                        $cardMember->member_id = $mobileMemberId;
                        $cardMember->venue_id = $this->venueId;
                        $cardMember->company_id = $this->companyId;
                        $cardMember->save();
                        $mobileMember->venue_id = $this->venueId;
                        $mobileMember->company_id = $this->companyId;
                        $mobileMember->counselor_id = $this->counselorId;
                        $mobileMember->save();
                        //按照手机号码把消费记录转给对应的会员
                        $consumptionHistory = ConsumptionHistory::findOne(['consumption_type_id'=>$cardMember->id]);
                        $consumptionHistory->member_id = $mobileMember->id;
                        $consumptionHistory->seller_id = $this->counselorId;
                        $consumptionHistory->consumption_date = $v[4];
                        $consumptionHistory->cash_payment = $v[8];
                        $consumptionHistory->consumption_amount = $v[8];
                        $consumptionHistory->due_date = $v[7];
                        $consumptionHistory->save();
                    }
                }
            }
            $num++;
            echo $num.'->';
        }
    }

    public function getCounselorId($counselor,$venue)
    {
        $venue = Organization::findOne(['name'=>$venue]);
        if($venue){
            $venueId = $venue->id;
        }
        $dept = Organization::find()->where(['pid'=>$venueId])->select(['id'])->asArray()->all();
        $deptIds = array_column($dept, 'id');
        $counselor = Employee::findOne(['name'=>$counselor]);
        if($counselor){
            return $counselor->id;
        }
    }

    public function getVenueId($venue)
    {
        $venue = Organization::findOne(['name'=>$venue]);
        if($venue){
            return $venue->id;
        }
    }

    public function getCompanyId($company)
    {
        $company = Organization::findOne(['name'=>$company,'pid'=>0]);
        if($company){
            return $company->id;
        }
    }
    
}