<?php
namespace backend\models;

use common\models\GiftCardActivity;
use common\models\GiftCardList;

class GiftCardMakeForm extends GiftCardList
{
    public $gift_card_activity_id;              //新增赠送活动表id
    public $category_type_id;                   //卡种类型id
    public $card_category_id;                   //卡种id
    public $card_number;                        //卡号
    public $ID_code;                            //识别码
    public $member_id;                          //会员id
    public $mobile;                             //手机号
    public $nickname;                           //会员名称
    public $is_bind;                            //是否绑定(1.未绑定 2.绑定)
    public $venue_id;                           //场馆ID
    public $company_id;                         //公司ID
    public $operator_id;                        //操作人ID
    public $card_amount;                        //生成的会员卡数量
    /**
     * @desc: 表单提交验证规则
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/07
     * @return array
     */
    public function rules ()
    {
        return [
            [['gift_card_activity_id','card_category_id','ID_code','mobile','nickname','card_amount'],'safe']
        ];
    }

    /**
     * @desc: 卡种管理-赠卡管理-生成会员卡
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/08
     * @return array|bool
     */

    public function GiftCardMake()
    {
        $info = $this->getGiftCardActivityInfo();
        $this->getCategoryCardInfo();
        if (isset($this->card_amount)) {
            $tr = \Yii::$app->db->beginTransaction();
            try {
                for ($i=0;$i<(int)$this->card_amount;$i++) {
                    $model = new GiftCardList();
                    $model->gift_card_activity_id = $this->gift_card_activity_id;
                    $model->category_type_id = $this->category_type_id;
                    $model->card_category_id = $this->card_category_id;
                    $card_number = $this->makeCardNumber();
                    $model->card_number = $card_number;
                    $ID_code = (string)$this->makeIDCode();
                    $model->ID_code = $ID_code;
                    $model->create_time = time();
                    $model->update_time = time();
                    $model->is_bind = 1;
                    $model->venue_id = $this->venue_id;
                    $model->company_id = $this->company_id;
                    $model->operator_id = \Yii::$app->user->identity->id;
                    $re = $model->save();
                    if (!$re) {
                        return $model->errors;
                    }
                }
                $info->gift_card_num = (int)($info->gift_card_num) + (int)$this->card_amount;
                $re = $info->save();
                if (!$re) {
                    return $info->errors;
                }
                if ($tr->commit()) {
                    return '操作失败';
                }else{
                    return true;
                }
            }catch (Exception $e) {
                $tr->rollBack();
            }
        }
    }

    /**
     * @desc: 卡种管理-赠卡管理-获取一条赠送会员卡活动表信息
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/08
     */
    public function getGiftCardActivityInfo()
    {
        $info = GiftCardActivity::findOne($this->gift_card_activity_id);
        if ($info) {
            $this->venue_id = $info->venue_id;
            $this->company_id = $info->company_id;
            return $info;
        } else {
            return false;
        }
    }

    /**
     * @desc: 卡种管理-赠卡管理-获取卡种info
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/08
     */
    public function getCategoryCardInfo()
    {
        $info = CardCategory::findOne($this->card_category_id);
        if ($info) {
            $this->category_type_id = $info->category_type_id;
        } else {
            return false;
        }
    }

    /**
     * @desc: 卡种管理-赠卡管理-生成IDCode码
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/08
     * @return string
     */
    private function makeIDCode()
    {
        $str = 'abcdefghigklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ';
        $code = '';
        for ($i=0;$i<6;$i++) {
            $code .= $str[mt_rand(0,51)].substr($str,mt_rand(0,51),1);
        }
        $codes = strtoupper($code);
        $result = GiftCardList::findOne(['ID_code'=>$codes]);
        if (empty($result)) {
            return $codes;
        }
        return $this->makeIDCode();

    }

    /**
     * @desc: 生成唯一的会员卡卡号
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/09
     * @return string
     */
    private function makeCardNumber()
    {
        $card_number = (string)'01'.mt_rand(0,9).time();
        $result = GiftCardList::findOne(['card_number'=>$card_number]);
        if (empty($result)) {
            $result = MemberCard::findOne(['card_number']);
            if (empty($result)) {
                return $card_number;
            }
            return $this->makeCardNumber();
        }
        return $this->makeCardNumber();
    }
}