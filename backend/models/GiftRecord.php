<?php
namespace backend\models;
use common\models\base\MemberCard;
use common\models\relations\GiftRecordRelations;
use common\models\Func;

class GiftRecord extends \common\models\GiftRecord
{
    use GiftRecordRelations;

    /**
     *后台会员管理 - 会员详细信息 -  赠品信息查询
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/20
     * @param $id
     * @return bool|string
     */
    public function GiftRecordData($id)
    {
        $model = GiftRecord::find()
            ->alias('gr')
            ->joinWith(['member mm'])
            ->joinWith(['memberCard mc'])
            ->select(
                "     gr.id,
                      gr.member_id,
                      gr.member_card_id,
                      gr.num,
                      gr.status,
                      gr.name,
                      gr.create_at,
                      gr.get_day,
                      mm.id as mmId,
                      mc.id as mcId,
               "
            )
            ->where(['gr.member_id' => $id])
            ->andWhere(['gr.class_type'=>null])
            ->orderBy('gr.id desc')
            ->asArray()
            ->all();
//        $dataProvider = Func::getDataProvider($model, 8);
//        $dataProvider->models      =  $this->getEmployeeData($dataProvider->models);
//        return $dataProvider;
        return $model;
    }


    /**
     * 后台会员管理 - 会员信息查询 - 获取员工表数据
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/18
     * @return string
     */
    public function getEmployeeData($data)
    {

        foreach ($data as &$value){
            $value['employee'] =  Member::find()->alias('mm')
                ->select('cloud_employee.*,mm.counselor_id')
                ->joinWith(['employee'])
                ->where(['mm.id'=>$value['member_id']])->asArray()->one();
        }

        return $data;
    }
    /**
     * 后台会员管理 - 会员详情 - 赠品列表领取修改状态
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/5
     * @param $id
     * @return bool
     */
    public static function getUpdateGift($id)
    {
        $GiftRecord  =  \common\models\base\GiftRecord::findOne($id);
        if($GiftRecord->status == 2){
            $GiftRecord->status = 1;
            $GiftRecord->get_day = time();
        }else{
            $GiftRecord->status = 2;
            $GiftRecord->get_day = time();
        }
        if($GiftRecord->save()){
            return true;
        }else{
            return $GiftRecord->errors;
        }
    }

    /**
     *后台会员管理 - 会员详情 -  赠送天数
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/10/16
     * @param $id
     * @return bool|string
     */
    public function giftRecord($id)
    {
        $model = GiftRecord::find()
            ->alias('gr')
            ->joinWith(['giftDay gd'],false)
            ->joinWith(['memberCard memberCard'],false)
            ->select(
                "     gr.id,
                      gr.member_card_id,
                      gr.service_pay_id,
                      gr.num,
                      gr.create_at,
                      gr.note,
                      gr.type as giftType,
                      gd.id as gdId,
                      gd.type,
                      memberCard.card_name,
               "
            )
            ->where(['gr.class_type' => 'day'])
            ->andWhere(['gr.member_id' => $id])
            ->orderBy('gr.id desc')
            ->asArray()
            ->all();
        return $model;
    }

    /**
     * 云运动 - 会员管理 - 会员详情信息记录 撤销赠送天数
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/1/31
     * @return array
     */
    public function cancelGiftDay($giftId,$memberCardId)
    {
        $gift = GiftRecord::findOne(['id' => $giftId]);
        $card = MemberCard::findOne(['id' => $memberCardId]);
        if($gift['type'] == 1){
            $gift->type = 2;
            if($gift->save() == true){
                $card->invalid_time = $card['invalid_time'] - ($gift['num']*24*60*60);
                if($card->save() == true){
                    return true;
                }else{
                    return $card->errors;
                }
            }else{
                return $gift->errors;
            }
        }
    }
}