<?php
/**
 * 审核评论模型
 * User: lihuien
 * Date: 2017/9/28
 * Time: 15:24
 */

namespace backend\models;


use common\models\relations\ApprovalCommentRelations;

class ApprovalComment extends \common\models\base\ApprovalComment
{
       use ApprovalCommentRelations;
}