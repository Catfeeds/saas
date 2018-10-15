<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\Mobilise;
use common\models\base\MobiliseType;
class MobiliseForm extends Model
{
    public $goodsId;                      //商品id
    public $number;                       //调拨数量
    public $note;                         //备注
    public $beStoreId;                    //被调拨仓库id
    public $storeId;                    //原调拨仓库id
    public $beVenueId;                   //被调拨场馆的id
    const NOTICE = '操作失败';
    /**
     * @云运动 - 后台 - 商品调拨验证规则
     * @create 2017/9/1
     * @return array
     */
    public function rules()
    {
        return [
            [['goodsId','number','beStoreId','storeId','beVenueId'],'required'],
            [['note'],'safe'],
        ];
    }




    /**
     * 云运动 - 仓库管理 - 商品调拨
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/9/1
     * @param $companyId
     * @param $venueId
     * @return boolean/object
     */
    public function addMobiliseData($companyId,$venueId)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model = new Mobilise();
            $model->goods_id = $this->goodsId;
            $model->num = $this->number;
            $model->note = $this->note;
            $model->create_id = $this->getCreate();
            $model->created_at = time();
            $model->update_at = time();
            $model->company_id = $companyId;
            $model->venue_id = $venueId;
            $model->store_id = $this->storeId;
            $model->be_store_id = $this->beStoreId;
            $model->be_venue_id = $this->beVenueId;
            $model = $model->save() ? $model : $model->errors;
            if(!isset($model->id)){
                throw new \Exception(self::NOTICE);
            }
            $mobiliseType = $this->insertMobiliseType($model);
            if(!isset($mobiliseType->id)){
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
            return  $e->getMessage();
        }

    }
    /**
     * 云运动 - 仓库管理 - 商品入库变更数据
     * @author huanghua <huanghua@itsports.club>
     * @param $model
     * @create 2017/8/30
     * @return boolean/object
     */
    public function insertMobiliseType($model)
    {
        $mobiliseType                = new MobiliseType();
        $mobiliseType->mobilise_id   = $model->id;
        $mobiliseType->type          = 1;
        $mobiliseType->note          = $this->note;
        $mobiliseType->create_id     = $this->getCreate();
        $mobiliseType->created_at    = time();
        $mobiliseType->update_at     = time();
        if($mobiliseType->save()){
            return $mobiliseType;
        }
            return $mobiliseType->errors;
    }
    /**
     * 云运动 - 仓库管理 - 获取创建人
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/9/1
     * @return boolean/object
     */
    public function getCreate()
    {
        $create = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $create = isset($create->id)?intval($create->id):0;
        return $create;
    }


}