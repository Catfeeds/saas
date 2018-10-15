<?php
namespace backend\models;

use yii\base\Model;
use common\models\Excel;
use common\models\base\Member;
use common\models\base\MemberDetails;
use common\models\base\MemberCard;
use common\models\base\MemberCourseOrder;
use common\models\base\ConsumptionHistory;

class ExcelTurnMembers extends Model
{
    const  ANOTHER_PARAMETER = ['memberId', 'memberName'];
    const               INFO = [0 => 'memberId', 1 => 'memberName'];

    public $memberId;
    public $memberName;

    public function autoLoadData($data)
    {
        $data = array_values($data);
        $dataS = self::ANOTHER_PARAMETER;
        foreach ($data as $keys => $value) {
            $key = $dataS[$keys];
            $this->$key = $value;
        }
    }

    public function loadFile($file)
    {
        $model = new Excel();
        $data = $model->loadTurnMembersFile($file);
        $num = 0;
        foreach($data as $k=>$v){
            $member = Member::findOne(['id'=>$v[0]]);
            if($member){
                $member->member_type = 1;
                $member->save();
            }
            $num++;
            echo $num;
        }
    }
}