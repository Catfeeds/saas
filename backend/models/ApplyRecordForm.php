<?php
namespace backend\models;

use common\models\base\ApplyRecord;
use common\models\base\Organization;
use yii\base\Model;
use Yii;
class ApplyRecordForm extends Model
{
    public $beApply;       //被申请公司
    public $startApply;    //通店开始日期
    public $endApply;      //通店结束日期

    public $recordId;         //申请记录id
    public $notApplyLength;  //不可申请时长
    public $note;             //备注

    public function rules()
    {
        return [
            [['beApply','startApply','endApply'], 'safe'],
            [['recordId','notApplyLength','note'], 'safe'],
        ];
    }

    /**
     * @云运动 - 公司联盟 - 查询操作人id
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/27
     */
    public function createId()
    {
        $adminId  = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $createId = isset($adminId->id) ? intval($adminId->id) : 0;
        return $createId;
    }

    /**
     * @云运动 - 公司联盟 - 保存申请记录数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/27
     */
    public function saveApply($companyId)
    {
        $beApplyId = Organization::find()->where(['name' => $this->beApply])->andWhere(['pid' => 0])->select('id')->asArray()->one();
        if($beApplyId == null){
            return '申请公司不存在或公司名称填写错误';
        }

        $applying = ApplyRecord::find()->where(['apply_id' =>$companyId ,'be_apply_id' => $beApplyId,'status' => 2])->andWhere(['>','end_apply',time()])->asArray()->one();
        if($applying && !empty($applying)){
            return '申请正在等待通过，请耐心等候';
        }

        $passApply = ApplyRecord::find()->where(['apply_id' =>$companyId ,'be_apply_id' => $beApplyId,'status' => 1])->andWhere(['>','end_apply',time()])->asArray()->one();
        if($passApply && !empty($passApply)){
            return '申请已通过，在通店结束日期之内不可再次申请';
        }

        $cancelApply = ApplyRecord::find()->where(['apply_id' =>$companyId ,'be_apply_id' => $beApplyId,'status' => 3])->andWhere(['>','end_apply',time()])->asArray()->one();
        if($cancelApply && !empty($cancelApply)){
            $length = $cancelApply['update_at'] + ($cancelApply['not_apply_length']*24*60*60);
            if(time() < $length){
                return '对方已拒绝申请，在不可再次申请时长内，不可再次申请';
            }
        }

        $beApplyId = Organization::find()->where(['like','name',$this->beApply])->andWhere(['pid' => 0])->select('id')->asArray()->one();
        if($companyId == $beApplyId['id']){
            return '不可申请本公司';
        }else{
            $apply               = new ApplyRecord();
            $apply->apply_id    = $companyId;                                    //申请公司id
            $apply->be_apply_id = intval($beApplyId['id']);                     //被申请公司id
            $apply->start_apply = strtotime($this->startApply);                 //通店开始时间
            $apply->end_apply   = strtotime($this->endApply);                   //通店结束时间
            $apply->status      = 2;                                             //状态：等待通过
            $apply->note         = '申请通店';                                   //备注
            $apply->create_id   = $this->createId();                             //操作人id
            $apply->create_at   = time();                                        //创建时间
            $apply = $apply->save() ? $apply : $apply->errors;
            if(isset($apply->id)){
                return true;
            }else{
                return $apply->errors;
            }
        }
    }


    /**
     * @云运动 - 公司联盟 - 取消申请
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/27
     */
    public function cancelApply($id)
    {
        $apply              = ApplyRecord::findOne($id);
        $apply->status     = 4;
        $apply->note       = '取消申请';
        $apply->create_id = $this->createId();
        $apply->update_at = time();
        $apply = $apply->save() ? $apply : $apply->errors;
        if(isset($apply->id)){
            return true;
        }else{
            return $apply->errors;
        }
    }

    /**
     * @云运动 - 公司联盟 - 申请过期
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/30
     */
    public function overdueApply($id)
    {
        $apply              = ApplyRecord::findOne($id);
        $apply->status     = 5;
        $apply->note       = '申请已过期';
        $apply->create_id = $this->createId();
        $apply->update_at = time();
        $apply = $apply->save() ? $apply : $apply->errors;
        if(isset($apply->id)){
            return true;
        }else{
            return $apply->errors;
        }
    }

    /**
     * @云运动 - 公司联盟 - 通过申请
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/27
     */
    public function passApply($id)
    {
        $apply              = ApplyRecord::findOne($id);
        $apply->status     = 1;
        $apply->note       = '通过申请';
        $apply->create_id = $this->createId();
        $apply->update_at = time();
        $apply = $apply->save() ? $apply : $apply->errors;
        if(isset($apply->id)){
            return true;
        }else{
            return $apply->errors;
        }
    }

    /**
     * @云运动 - 公司联盟 - 拒绝申请
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/27
     */
    public function notPassApply()
    {
        $apply                     = ApplyRecord::findOne(['id' => $this->recordId]);
        $apply->status            = 3;
        $apply->not_apply_length = $this->notApplyLength;
        $apply->note              = $this->note;
        $apply->create_id        = $this->createId();
        $apply->update_at        = time();
        $apply = $apply->save() ? $apply : $apply->errors;
        if(isset($apply->id)){
            return true;
        }else{
            return $apply->errors;
        }
    }
}