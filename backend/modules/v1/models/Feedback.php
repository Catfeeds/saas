<?php
namespace backend\modules\v1\models;

use common\models\FeedbackType;

class Feedback extends \common\models\Feedback
{
    public function rules()
    {
        return [
            [['type_id','from','venue_id','user_id','content'], 'required'],
            [['type_id', 'company_id', 'venue_id', 'user_id', 'occurred_at'], 'integer'],
            [['content'], 'string'],
            ['from', 'in', 'range' =>['android_customer', 'ios_customer']],
            ['company_id', 'default', 'value'=>1],
            ['pics', 'file', 'extensions'=>'jpg,jpeg,png,gif', 'maxFiles'=>4, 'maxSize'=>2048*1024],
            ['type_id', 'validateTypeId'],
        ];
    }

    public function beforeSave($insert)
    {
        if($insert && $this->validate() && isset($this->pics)){
            $pics = [];
            foreach ($this->pics as $pic){
                $imgName = uniqid(md5(microtime(true))) . '.' . $pic->extension;
                $err = Func::uploadFile($pic->tempName, $imgName);
                if(!empty($err)){
                    $this->addErrors(['pics'=>'上传失败']);
                    return FALSE;
                }
                $pics[] = Func::getImgUrl($imgName);
            }
            $this->pics = json_encode($pics);
        }
        return parent::beforeSave($insert);
    }

    public function validateTypeId($attribute)
    {
        if(!$this->hasErrors()){
            $type = FeedbackType::findOne(['id'=>$this->type_id, 'do'=>1]);
            if(empty($type)) $this->addError($attribute, '类型ID不符');
        }
    }


}