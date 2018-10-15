<?php
namespace backend\models;
use Yii;

class MemberDealRecord extends \common\models\MemberDealRecord
{
    public static function getDealOne($id)
    {
        return MemberDealRecord::find()->where(['and',['cloud_member_deal_record.id'=>$id],['>=','cloud_member_deal_record.create_at',1527782400],['<>','cloud_member_deal_record.company_id',1]])->asArray()->one();
    }

    /**
     * 正式会员 - 上传私教、会员卡合同照片
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/06/14
     * @return bool|array
     */
    public function uploadDealPic($post,$companyId,$venueId)
    {
        if($post['type'] == 1){    //1卡，2课
            $data = MemberDealRecord::find()
                ->where(['type' => 1,'type_id' => $post['typeId'],'member_id' => $post['memberId']])
                ->select('id,pic')->asArray()->one();
        }else{
            $data = MemberDealRecord::find()
                ->where(['type' => 2,'type_id' => $post['typeId'],'member_id' => $post['memberId']])
                ->select('id,pic')->asArray()->one();
        }
        if(empty($data)){
            if(!isset($post['pic'])){
                return '请先上传照片';
            }
            $data             = new MemberDealRecord();
            $data->type       = $post['type'];
            $data->type_id    = $post['typeId'];
            $data->member_id  = $post['memberId'];
            $data->company_id = $companyId;
            $data->venue_id   = $venueId;
            $data->create_at  = time();
            $data->pic        = isset($post['pic']) ? json_encode($post['pic']) : NULL;
        }else{
            if(empty($data['pic']) && !isset($post['pic'])){
                return '请先上传照片';
            }
            $data = MemberDealRecord::findOne(['id' => $data['id']]);
            $data->pic = isset($post['pic']) ? json_encode($post['pic']) : NULL;
        }
        if($data->save() === true){
            return true;
        }else{
            return $data->errors;
        }
    }

    /**
     * 正式会员 - 获取私教、会员卡合同照片
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/06/14
     * @return bool|string
     */
    public function getDealPic($params)
    {
        if($params['type'] == 1){
            $data = \common\models\base\MemberDealRecord::find()
                ->where(['type' => 1,'type_id' => $params['typeId'],'member_id' => $params['memberId']])
                ->select('id,pic')->asArray()->one();
        }else{
            $data = \common\models\base\MemberDealRecord::find()
                ->where(['type' => 2,'type_id' => $params['typeId'],'member_id' => $params['memberId']])
                ->select('id,pic')->asArray()->one();
        }
        $pic  = json_decode($data['pic'],true);
        $data = ['id' => $data['id'],'pic' => $pic];
        return $data;
    }
}