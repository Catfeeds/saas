<?php

namespace backend\models;

use common\models\base\ApprovalComment;
use yii\base\Model;
class AddApprovalCommentForm extends Model
{
    public $detailId;          //详情ID
    public $content;           //评论内容
    public $approverId;        //评论人ID
    /**
     * @date:2017-09-28 10:34
     * @author :李慧恩
     * @content:增加审核评论属性规则
     * @return  array
     */
    public function rules()
    {
        return [
            [['detailId','content'],'safe']
        ];
    }
    /**
     * @date:2017-09-28 10:34
     * @author :李慧恩
     * @content:增加审核评论
     * @return  array
     */
    public function saveComment()
    {
        $this->getCreateId();
        $comment = new ApprovalComment();
        $comment->approval_detail_id = $this->detailId;
        $comment->content            = $this->content;
        $comment->create_at          = time();
        $comment->reviewer_id        = $this->approverId;
        if($comment->save()){
            return true;
        }
        return $comment->errors;
    }
    /**
     * @date:2017-09-28 10:34
     * @author :李慧恩
     * @content:获取评论人
     * @return  array
     */
    public function getCreateId()
    {
        $sms = new SmsRecordForm();
        $this->approverId = $sms->getCreate();
    }
}