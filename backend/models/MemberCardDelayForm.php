<?php
namespace backend\models;

use common\models\Excel;
use Faker\Provider\DateTime;
use yii\base\Model;

class MemberCardDelayForm extends Model
{
    public $number;   //会员卡号
    public $num = 3;      // 延期日期 月为单位
    public $memberId;
    public $memberCardId;
    public $oldInvalid;
    public $oldStart;
    public $oldEnd;
    public $invalid;
    public $employeeId;
    public $start;
    public $end;
    public $price;
    public $note;
    public $bugDate;
    public function setPath($path)
    {
        $model = new Excel();
        $data  = $model->loadMemberCardFile($path);
//        $data  = array_column($data,'0');
////        var_dump($data);die();
//        $arr = array_unique($data);
        foreach ($data as $value){
            $this->note   = $value[0];
            $this->number = $value[1];
            $this->bugDate = $value[7];
            $this->start  = $value[8];
            $this->end    = $value[9];
            $this->price  = $value[10];
//            var_dump($value[8]);die();
//            echo $this->number.'-'.$this->start.'-'.$this->end."---\n";
            $return  = $this->setCardTime();
            if($return !== true){
                echo $this->number. 'error'.$return."\n";
            }
        }
    }

    /**
     * 会员卡批量延期
     * @author lihuien<lihuien@itsports.club>
     * @create 2018-2-9
     * @return array|bool|string
     */
    public function delayCard()
    {
        $memberCard = MemberCard::findOne(['card_number'=>$this->number]);
        if(empty($memberCard)){
            return '此卡号不存在';
        }
        $this->memberId = $memberCard->member_id;
        $this->memberCardId = $memberCard->id;
        $this->oldInvalid   = $memberCard->invalid_time;
        $this->employeeId   = $memberCard->employee_id;
        if(empty($this->employeeId)){
            $member = Member::findOne(['id'=>$memberCard->member_id]);
            $this->employeeId = $member->counselor_id;
        }
        $invalid      = $memberCard->invalid_time;
        echo $invalid."\n";
        if(intval($invalid) >= 2145891661){
            $d = new \DateTime("@$invalid");
            $year         = $d->format('Y');
            $month        = $d->format('m');
            $day          = $d->format('d');
        }else{
            $year         = date('Y',$invalid);
            $month        = date('m',$invalid);
            $day          = date('d',$invalid);
        }
        $total        = $month + $this->num;
        if($total > 12){
            $totalMonth = $total%12;
            $month      = floor(($total)/12);
            $time = strtotime(($year+$month).'-'.$totalMonth.'-'.$day.' 23:59:59');
        }else{
            $time = strtotime($year.'-'.($total).'-'.$day .' 23:59:59');
        }
        $memberCard->invalid_time = $time;
        $this->invalid            = $time;
        if(!$memberCard->save()){
            return $memberCard->errors;
        }
        $this->saveHistory();
        return true;
    }

    public function saveHistory()
    {
        $model = new ConsumptionHistory();
        $model->member_id             = $this->memberId;     ;        //?从对方获取插入的会员id
        $model->consumption_type      = "card";
        $model->consumption_type_id   = $this->memberCardId;        //?从对方拿取  （对方插入会员卡表时的id）
        $model->type                  = 1;        //消费方式暂定1（现金）；
        $model->consumption_date      = abs((int)$this->bugDate);   //消费日期
        $model->consumption_amount    = intval($this->price);            //?消费金额 遍历数据拿出来
        $model->consumption_times     = 1;                        //消费次数
        $model->cashier_order         = $this->oldInvalid;    //收银单号
        $model->cash_payment          = intval($this->price);             //现金付款
        $model->bank_card_payment     = 0;        //银行卡付款
        $model->mem_card_payment      = 0;        //会员卡付款
        $model->coupon_payment        = 0;            //优惠券付款
        $model->transfer_accounts     = 0;  //转账付款
        $model->other_payment         = 0;       //其它转账
        $model->network_payment       = 0;     //网络支付
        $model->integration_payment   = 0; //积分支付
        $model->discount_payment      = 0;  //折扣支付
        $model->seller_id             = $this->employeeId;          //销售人员id
        $model->venue_id              = 2;
        $model->company_id            = 1;
        $model->describe              = json_encode([]);  //备注
        $model->category              = !empty($this->memberCardStatus)?$this->memberCardStatus:'统一开卡';
        $model->due_date              = abs((int)$this->invalid);
        if($this->note == '会员卡(定金)'){
            $model->remarks               = '2017大上海预售会员统一开卡'.$this->note;
        }else{
            $model->remarks               = '2017大上海预售会员统一开卡';
        }

       //，由'.date('Y-m-d',$this->oldStart).'-'.date('Y-m-d',$this->oldEnd).'更改为：'.date('Y-m-d',$this->start).'-'.date('Y-m-d',$this->end)

        return $model->save() ? true :false ;

    }

    public function setCardTime()
    {
        $memberCard = MemberCard::findOne(['card_number'=>$this->number]);
        if(empty($memberCard)){
            return '此卡号不存在';
        }
        $this->memberId     = $memberCard->member_id;
        $this->memberCardId = $memberCard->id;
        $this->oldInvalid   = $memberCard->create_at;
        $this->employeeId   = $memberCard->employee_id;
        $this->oldStart     = $memberCard->active_time;
        $this->oldEnd       = $memberCard->invalid_time;
        if(empty($this->employeeId)){
            $member = Member::findOne(['id'=>$memberCard->member_id]);
            $this->employeeId = $member->counselor_id;
        }
        if($memberCard->status == 4){
            $memberCard->status = 1;
        }
        $memberCard->active_time  = strtotime(date('Y-m-d',$this->start)." 00:00:00");
        $memberCard->invalid_time = strtotime(date('Y-m-d',$this->end)." 23:59:59");
        $this->invalid            = $memberCard->invalid_time;
        $this->start              = $memberCard->active_time;
        $this->end                = $memberCard->invalid_time;
        if(!$memberCard->save()){
            return $memberCard->errors;
        }
        if($this->note == '会员卡(回款)'){
            echo $memberCard->card_number;
            $ch = \common\models\base\ConsumptionHistory::findOne(['category'=>'统一开卡','consumption_type_id'=>$memberCard->id,'consumption_type'=>'card','remarks' => '2017大上海预售会员统一开卡会员卡(定金)']);
            if(!empty($ch)){
                $this->price = $this->price + $ch->consumption_amount;
            }
        }
        \common\models\base\ConsumptionHistory::deleteAll(['category'=>'统一开卡','consumption_type_id'=>$memberCard->id,'consumption_type'=>'card']);
        $this->saveHistory();
        return true;
    }

}