<?php
namespace backend\models;

use common\models\base\GiftCardActivity;

class GiftCardForm extends GiftCardActivity
{
    public $active_name;                    //赠送名称
    public $gift_card_num;                  //赠送卡总数量
    public $active_card_num;                //开卡数量
    public $start_time;                     //活动开始时间(开始开卡时间)
    public $end_time;                       //活动结束时间(开始结束时间)
    public $note;                           //备注
    public $venueId;                        //场馆id
    /**
     * @desc: 验证规则
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/07
     * @return array
     */
    public function rules ()
    {
        return [
            ['active_name','trim'],
            ['active_name','string'],
            [[
                'active_name','gift_card_num','active_card_num','start_time','end_time','note','company_id','venueId',
                ],'safe']
        ];
    }

    /**
     * @desc: 卡种管理-赠卡管理-新增赠送活动表单提交
     * @table: cloud_gift_card_activity
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/07
     * @param $venue_id
     * @param $company_id
     * @return array|bool
     */
    public function saveGiftCardActivity($company_id)
    {
        $model = new GiftCardActivity();
        $model->active_name     = $this->active_name;
        $model->create_time     = time();
        $model->start_time      = (isset($this->start_time) && !empty($this->start_time)) ? strtotime($this->start_time) : null;
        $model->end_time        = (isset($this->end_time) && !empty($this->end_time)) ? strtotime($this->end_time) : null;
        $model->note            = $this->note;
        $model->gift_card_num   = 0;
        $model->active_card_num = 0;
        $model->venue_id        = $this->venueId;
        $model->company_id      = $company_id;
        $model->operator_id     = \Yii::$app->user->identity->id;
        if (!$model->save()) {
            return $model->errors;
        }
        return true;
    }
}