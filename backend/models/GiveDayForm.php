<?php
namespace backend\models;

use common\models\base\GiftRecord;
use common\models\base\GiftDay;
use common\models\base\MemberCard;
use yii\base\Model;
use Yii;
class GiveDayForm extends Model
{
    public $memberId;      //会员id
    public $memberCardId;  //会员卡id
    public $giveCardId;    //卡种赠送id
    public $days;           //赠送天数
    public $note;          //备注
    const NOTICE = '操作失败';
    public function rules()
    {
        return [
            [['memberId','memberCardId', 'giveCardId','courseId','days','note'], 'safe'],
        ];
    }


    /**
     * 云运动 - 赠送天数 - 存储赠品表
     * @author 黄华<huanghua@itsports.club>
     * @create 2017/10/16
     * @return array
     */
    public function giveDayData()
    {
        if(empty($this->days) || empty($this->giveCardId)) return '请选择赠送天数';
        $memberCard = MemberCard::findOne(['id' => $this->memberCardId]);
        $giftDayData = GiftDay::findOne(['id' => $this->giveCardId]);

        $transaction = Yii::$app->db->beginTransaction();
        try {

            if(!empty($memberCard['invalid_time'])){
                $memberCard->invalid_time = $memberCard['invalid_time'] + ($this->days*24*60*60);
            }
            $memberCard = $memberCard->save() ? $memberCard : $memberCard->errors;
            if(!isset($memberCard->id)){
                throw new \Exception(self::NOTICE);
            }

                if (!empty($giftDayData['surplus'])) {
                    $giftDayData->surplus = $giftDayData['surplus'] - 1;
                    $giftDayData = $giftDayData->save() ? $giftDayData : $giftDayData->errors;
                    if (!isset($giftDayData->id)) {
                        throw new \Exception(self::NOTICE);
                    }
                }

            $giftRecord = new GiftRecord();
            $giftRecord->member_id = $this->memberId;
            $giftRecord->member_card_id = $this->memberCardId;
            $giftRecord->service_pay_id = $this->giveCardId;
            $giftRecord->num = $this->days;
            $giftRecord->status = 2;
            $giftRecord->name = '赠送天数';
            $giftRecord->create_at = time();
            $giftRecord->get_day = time();
            $giftRecord->class_type = 'day';
            $giftRecord->note = $this->note;
            $giftRecord = $giftRecord->save() ? $giftRecord : $giftRecord->errors;
            if(!isset($giftRecord->id)){
                throw new \Exception(self::NOTICE);
            }

            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            return  $e->getMessage();
        }
    }
}