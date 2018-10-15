<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/6/12
 * Time: 11:37
 */

namespace backend\models;


use common\models\base\Member;
use common\models\base\MemberDetails;
use common\models\Excel;
use yii\base\Model;
use Yii;
class ExcelMemberNumber extends Model
{
    const LOAD_DATA = ['oldNumber','newNumber'];
    public $date;               //日期
    public $oddNumbers;         //订单号
    public $cardNumber;         //卡号
    public $name;              //卡种名称
    public $sex;                //性别
    public $consultant;         //会籍顾问
    public $mobile;             //手机号
    public $oldCard;            //旧卡名称
    public $oldCardStartDate;   //旧卡起始时间
    public $oldCardEndDate;     //旧卡起始时间
    public $newCard;             //新卡名称
    public $newCardStartDate;   //新卡起始时间
    public $newCardEndDate;      //新卡起始时间
    public $price;             //金额
    public $cash;              //现金
    public $bankCard;          //银行卡
    public $memberCard;        //会员卡
    public $coupon;            //优惠券
    public $transferAccounts;  //转账
    public $otherPayment;      //其他
    public $discountPayment;   //折扣折让
    public $networkPayment;    //网络支付
    public $integrationPayment; //积分
    public $describe;           //备用

    public $venueType;
    public $venueNameTwo;
    public $paramType;
    public $adminId;
    public $venueName;
    public $organId;
    public $venueId;
    public $venuePid;
    public $venueStyle;
    public $venueCode;
    public $departId;

    public $oldNumber;
    public $newNumber;
    public $username;
    public function loadFile($path,$venue = '大上海',$name,$type='one'){
        $model = new Excel();
        $this->venueType    = $venue;
        $this->venueNameTwo = $name;
        $this->paramType    = $type;
        if($type == 'two'){
            $data = $model->loadFileTwo($path);
        }elseif($type == 'three'){
            $data = $model->loadFileThree($path);
        }else{
            $data = $model->loadFile($path);
        }
        $this->getAdminIdOne();
        $this->getVenueId();
        $this->setVenueData();
        //插入到数据库
        foreach($data as $key=>$val){
            $this->loadData($val);
            if((strstr($this->oddNumbers, '共') && strstr($this->oddNumbers, '条')) ||(strstr($this->oddNumbers, '第') && strstr($this->oddNumbers, '页'))){
                continue;
            }
            if(!$this->departId){
                echo "venue>>".'场馆不存在'."<br /><br />";
            }

            $member        = new Member();
            $cardCategory  = new CardCategory();
            $memberCard    = new MemberCard();
            $memberDetail  = new MemberDetails();
            $organization  = new Organization();
            $transaction  = Yii::$app->db->beginTransaction();     //事务开始
            try{
                //判断会员是否存在
                $member = Member::findOne();
                //插入会员表
                if($transaction->commit() !== null){
                    return false;
                }
            }catch(\Exception $ex){
                $transaction->rollBack();
                return  $ex->getMessage();
            }
        }
        if(empty($this->error)){
            return true;
        }else{
            return $this->error;
        }

    }

    public function getMemberType()
    {
        $arr = explode('(',$this->memberCardStatus);
        if($arr && isset($arr[1])){
            $this->memberCardStatus = rtrim($arr[1],')');
        }
    }
    public function getVenueId()
    {
        $organ      =  Organization::find()->where(['like','name','我爱运动'])->andWhere(['style'=>1])->asArray()->one();
        if(empty($organ)){
            $this->venueName = '我爱运动';
            $this->venueCode = NULL;
            $this->venuePid  = 0;
            $this->venueStyle = 1;
            $venues = $this->addVenue();
            if(isset($venues->id)){
                $this->organId = $venues->id;
            }
        }else{
            $this->organId = $organ['id'];
        }

        if($this->organId){
            $venue      =  Organization::find()->where(['pid'=>$this->organId])->andWhere(['like','name',$this->venueType])->asArray()->one();
            if(empty($venue)){
                $this->venueName  = $this->venueNameTwo;
                $this->venueCode  = NULL;
                $this->venuePid   = $this->organId;
                $this->venueStyle = 2;
                $venues = $this->addVenue();
                if(isset($venues->id)){
                    $this->venueId = $venues->id;
                }
            }else{
                $this->venueId = $venue['id'];
            }
            if(isset($this->venueId)){
                $department =  Organization::find()->where(['like','code','xiaoshou'])->andWhere(['pid'=>$this->venueId])->andWhere(['style'=>3])->asArray()->one();
                if(empty($department)){
                    $this->venueName  = '销售部';
                    $this->venueCode  = 'xiaoshou';
                    $this->venuePid   = $this->venueId;
                    $this->venueStyle = 3;
                    $venues = $this->addVenue();
                    if(isset($venues->id)){
                        $this->departId = $venues->id;
                    }
                }else{
                    $this->departId = $department['id'];
                }

            }
        }

    }
    public function setVenueData()
    {
        $venueArr = ['大上海瑜伽健身馆','大学路舞蹈健身馆','帝湖瑜伽健身馆','丰庆路游泳健身馆','大学路瑜伽馆','尊爵汇','亚星游泳健身馆'];
        $arr      = ['大上海','大学路舞蹈','帝湖','丰庆路','大学路瑜伽','尊爵汇','亚星'];
        foreach ($venueArr as $k=>$value){
            $one = Organization::find()->where(['pid'=>$this->organId])->andWhere(['like','name',$arr[$k]])->asArray()->one();
            if(empty($one)){
                $venue = new Organization();
                $venue->name = $value;
                $venue->pid = $this->organId;
                $venue->created_at = time();
                $venue->create_id  = $this->adminId;
                $venue->style      = 2;
                $venue->code       = null;
                if (!$venue->save()) {
                    return $venue->errors;
                }
            }
        }
    }
    public function addVenue()
    {
        $venue = new Organization();
        $venue->name = $this->venueName;
        $venue->pid = $this->venuePid;
        $venue->created_at = time();
        $venue->create_id  = $this->adminId;
        $venue->style = $this->venueStyle;
        $venue->code = $this->venueCode;
        if ($venue->save()) {
            return $venue;
        }else{
            return $venue->errors;
        }
    }
    public function getAdminIdOne()
    {
        $admin = Admin::find()->where(['username'=>'admin'])->asArray()->one();
        $this->adminId =  isset($admin['id'])?$admin['id']:0;
    }
    public function loadFileMemberNumber($path,$type='number'){
        $model = new Excel();
        $data = $model->loadFileNumber($path);
        $error = [];
        //插入到数据库
        $num = 0;
        foreach($data as $key=>$val){
            $this->oldNumber = "$val[1]";
            $this->newNumber = "$val[5]";
            $this->username  = "$val[9]";
            $this->sex       = "$val[10]";
            if($type == 'shengji'){
                $note = $val[13];
                $arr = explode('升级',$note);
                if(count($arr)>1){
                    $mc = MemberCard::findOne(['card_number'=>$this->oldNumber]);
                    if(!empty($mc)) {
                        $mc->status = 2;
                        if (empty($mc->venue_id)) {
                            $mc->venue_id = 11;
                        }
                        if (!$mc->save()) {
                            return $mc->errors;
                        }
                    }
                    echo $num.',';
                    $num++;
                }
                continue;
            }
            $cardOld = MemberCard::findOne(['card_number'=>$this->oldNumber]);//20000006
            $cardNew = MemberCard::findOne(['card_number'=>$this->newNumber]);//09010215
            $transaction  = Yii::$app->db->beginTransaction();     //事务开始
            try{
                //判断会员是否存在
                if(!empty($cardOld) && !empty($cardNew)){
                    if(intval($cardOld->invalid_time) > intval($cardNew->invalid_time)){
                        $id = $cardOld->id;
                        $time = time();
                        $cardOld->card_number = "{$time}";
                        if(!$cardOld->save()){
                            $error[$key] =  $cardOld->errors;
                        }
                        $cardOneId = MemberCard::findOne(['id'=>$id]);
                        $cardOneId->card_number = $this->newNumber;
                        $cardNew->card_number   = $this->oldNumber;
                        if(!$cardNew->save()){
                            $error[$key] =  $cardNew->errors;
                        }
                        if(!$cardOneId->save()){
                            $error[$key] =  $cardOneId->errors;
                        }
                    }else{
                        if(!empty($this->username)){
                            $member = Member::findOne(['id'=>$cardNew->member_id]);
                            $member->username = $this->username;
                            $member->save();
                            $memberDetail = MemberDetails::findOne(['member_id'=>$cardNew->member_id]);
                            if(empty($memberDetail)){
                                $memberModel = new MemberDetails();
                                $memberModel->name = $this->username;
                                $memberModel->sex  = $this->sex == '男'?1:2;
                                $memberModel->save();
                            }else{
                                $memberDetail->name = $this->username;
                                $memberDetail->sex  = $this->sex == '男'?1:2;
                                $memberDetail->save();
                            }
                        }
                    }
                }elseif (!empty($cardOld)){
                     $cardOld->card_number = $this->newNumber;
                     if(!$cardOld->save()){
                         $error[$key] = $cardOld->errors;
                     }
                }
                //插入会员表
                if($transaction->commit() !== null){
                    return $error;
                }
            }catch(\Exception $ex){
                $transaction->rollBack();
                return  $ex->getMessage();
            }
            $num++;
            echo $num;
        }
        if(!empty($error)){
            return $error;
        }else{
            return true;
        }
    }
    public function loadFileSendMemberNumber($path){
        $model = new Excel();
        $data = $model->loadFileNumber($path);
        $error = [];
        //插入到数据库
        $num = 0;
        foreach($data as $key=>$val){
            $this->oldNumber = "$val[0]";
            $mc = MemberCard::find()->where(['card_number'=>$this->oldNumber])->one();
            if(!empty($mc)){
                $mc->usage_mode = 2;
                if(!$mc->save()){
                    echo "$this->oldNumber".$mc->errors.'>>>><br>';
                }
            }
            $num++;
            echo $num;
        }
    }
}