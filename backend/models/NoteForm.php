<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\InformationRecords;
class NoteForm extends Model
{
    public $behaviorId;                 //行为id
    public $note;                       //备注
    public $memberId;                 //会员id
    public $memberCardId;                 //会员卡id


    /**
     * @云运动 - 后台 - 新增角色验证规则
     * @create 2017/6/16
     * @return array
     */
    public function rules()
    {
        return [
            [['memberId','behaviorId'], 'required'],
            [[ 'memberId','note','behaviorId','memberCardId'], 'safe'],
        ];
    }

    /**
     * 云运动 - 后台- 新增信息录入
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/5
     * @return boolean/object
     */
    public function addNote()
    {
        // 行为记录信息保存
        $model = new InformationRecords();
        $model->create_id = $this->getCreate();
        $model->create_at = time();
        $model->member_id = $this->memberId;
        $model->member_card_id = $this->memberCardId;
        $model->note = $this->note;
        $model->behavior = $this->behaviorId;

        if ($model->save()) {
            return true;
        } else {
            return $model->errors;
        }
    }

    public function getCreate()
    {
        $create = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $create = isset($create->id)?intval($create->id):0;
        return $create;
    }



}