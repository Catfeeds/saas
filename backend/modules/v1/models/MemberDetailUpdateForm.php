<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/5/3
 * Time: 14:30
 */

namespace backend\modules\v1\models;


use common\models\base\Member;
use common\models\base\MemberDetails;
use yii\base\Model;

class MemberDetailUpdateForm extends Model
{
    public $name;           //会员姓名
    public $memberId;       //会员id  
    /**
     * 后台 - 登录 - 验证规则
     * @author  lihuien <lihuien@itsport.club>
     * @create 2017/3/30
     */
    public function rules()
    {
        return [
            ['memberId','required','message'=>'会员ID不能为空'],
            ['name','required','message'=>'昵称不能为空'],
            [['name','memberId'],'safe']
        ];
    }
    /**
     * 后台 - API - 修改会员姓名
     * @author  lihuien <lihuien@itsport.club>
     * @create 2017/3/30
     */
    public function updateMember()
    {
        $detailData   = MemberDetails::find()->where(['member_id'=>$this->memberId])->asArray()->one();
        $detail       = MemberDetails::findOne(['id'=>$detailData['id']]);
        $detail->nickname = $this->name;
        if($detail->save())
        {
            return true;
        }else{
            return $detail->errors;
        }
    }

}