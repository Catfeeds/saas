<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/23 0023
 * Time: 上午 9:02
 */

namespace backend\modules\v1\models;
use common\models\base\Member;
use common\models\base\MemberDetails;
use yii\base\Model;


class MemberInfoForm extends Model
{
    public $imgLink;        //会员头像
    public $memberId;   //会员id
    /**
     * 后台 - 登录 - 验证规则
     * @author  huangpengju <huangpengju@itsport.club>
     * @create 2017/6/23
     */
    public function rules()
    {
        return [
            ['memberId','required','message'=>'会员ID不能为空'],
            ['imgLink','required','message'=>'图片不能为空'],
            [['imgLink','memberId'],'safe']
        ];
    }
    /**
     * 后台 - API - 修改会员详细信息
     * @author  huangpengju <huangpengju@itsport.club>
     * @create 2017/6/23
     */
    public function updateMember()
    {
        //1.先去查会员和详细信息表，有就存，没有就添加
        $member = Member::find()->where(['id'=>$this->memberId])->asArray()->one();
        $detail = MemberDetails::find()->where(['member_id'=>$this->memberId])->asArray()->one();
        if(!empty($member)) {                                 //判断会员是否存在
            if (empty($detail)) {                             //判断会员详细是否存在
                $model             = new MemberDetails();
                $model->member_id  = $this->memberId;           //会员id
                $model->name       = $member['name'];            //会员姓名
               // $model->pic      = $this->imgLink;              //会员头像（暂时 先注释掉）
                $model->motto      =  $this->imgLink;           // 座右铭（暂时存为个人头像）
                $model->sex        = 0;                          //会员性别0保密
                $model->created_at = time();                    //创建时间
                $model->updated_at = time();                    //修改时间
                if ($model->save()) {
                    return true;
                } else {
                    return $model->errors;
                }
            } else {
                $model = MemberDetails::findOne($detail['id']);
               // $model->pic = $this->imgLink;           //会员头像
                $model->motto      =  $this->imgLink;   // 座右铭（暂时存为个人头像）
                $model->updated_at = time();             //修改时间
                if ($model->save()) {
                    return true;
                } else {
                    return $model->errors;
                }
            }
        }else{
            return false;
        }
    }
}