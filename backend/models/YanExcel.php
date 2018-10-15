<?php
namespace backend\models;

use common\models\Excel;
use yii\base\Model;
use common\models\base\Member;
use common\models\base\MemberDetails;
use common\models\base\MemberCard;
use common\models\base\MemberCourseOrder;
use common\models\base\ConsumptionHistory;


class YanExcel extends Model
{
    const ANOTHER_PARAMETER = ['memberId','name'];
    const INFO              = [0=>'memberId',1=>'name']; 
    
    public $memberId;
    public $name;

    public function autoLoadData($data){
        $data  = array_values($data);
        $dataS = self::ANOTHER_PARAMETER;
        foreach($data as $keys=>$value){
            $key        = $dataS[$keys];
            $this->$key = $value;
        }
    }
    
    public function loadFile($file,$type = 'private',$name = '艾搏')
    {
        $model = new Excel();
        $data  = $model->loadYanFile($file, $type);           //excel表数据
        $num = 0;
        foreach($data as $k=>$v){
            if($v[0] == 50363){
                Member::findOne(['id'=>$v[0]])->delete();
                MemberDetails::findOne(['member_id'=>$v[0]])->delete();
            }else{
                $yan = Member::findOne(['id'=>$v[0]]);
                if($yan){
                    //1、会员卡转给id = 50215的会员
                    MemberCard::updateAll(['member_id'=>50215],['member_id'=>$v[0]]);
                    //2、私教课转给id = 50215的会员
                    MemberCourseOrder::updateAll(['member_id'=>50215],['member_id'=>$v[0]]);
                    //3、消费记录转给id = 50215的会员
                    ConsumptionHistory::updateAll(['member_id'=>50215],['member_id'=>$v[0]]);
                    //4、删除id = 50362的会员记录
                    Member::findOne(['id'=>$v[0]])->delete();
                    MemberDetails::findOne(['member_id'=>$v[0]])->delete();
                    //5、更新id = 50215的会员的手机号码为17739768507
                    Member::updateAll(['mobile'=>17739768507],['id'=>50215]);
                }
            }
            $num++;
            echo $num;
        }
    }
    
    
    
    
    
    
}