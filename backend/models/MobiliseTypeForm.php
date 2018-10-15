<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\Mobilise;
use common\models\base\MobiliseType;
class MobiliseTypeForm extends Model
{
    public $mobiliseId;                      //调拨id
    public $mobiliseTypeId;                  //调拨类型id
    public $rejectNote;                      //拒绝原因
    const NOTICE = '操作失败';
    /**
     * @云运动 - 后台 - 商品调拨拒绝验证规则
     * @create 2017/9/1
     * @return array
     */
    public function rules()
    {
        return [
            [['mobiliseId','mobiliseTypeId','rejectNote'],'required'],
        ];
    }




    /**
     * 云运动 - 仓库管理 - 商品调拨拒绝
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/9/1
     * @return boolean/object
     */
    public function updateData()
    {
        $mobilise      = Mobilise::findOne(['id' => $this->mobiliseId]);
        $mobiliseType  = MobiliseType::findOne(['id' => $this->mobiliseTypeId]);
        $transaction   = Yii::$app->db->beginTransaction();
        if (isset($mobilise) && !empty($mobilise) && isset($mobiliseType) && !empty($mobiliseType)) {
            try {
                $mobilise->reject_note = $this->rejectNote;
                $mobiliseType->type    = 4;
                $model                 = $mobilise->save() ? $mobilise : $mobilise->errors;
                $modelType             = $mobiliseType->save() ? $mobiliseType : $mobiliseType->errors;
                if (!isset($model->id) && !isset($modelType->id)) {
                    throw new \Exception(self::NOTICE);
                }
                if ($transaction->commit() === null) {
                    return true;
                } else {
                    return false;
                }
            } catch (\Exception $e) {
                //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
                $transaction->rollBack();
                return $e->getMessage();
            }

        }
    }


}