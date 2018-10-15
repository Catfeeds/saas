<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\Goods;
use common\models\base\StoreHouse;
class ShopForm extends Model
{
    public $storeId;                      //仓库id
    public $goodsAttribute;               //商品类型
    public $goodsTypeId;                   //商品品类
    public $unit;                            //商品单位
    public $goodsName;                       //商品名称
    public $department_id;                  //部门id

    public $goodsBrand;//商品品牌
    public $goodsModel;//商品型号
    public $goodsProducer;//生产商
    public $goodsSupplier;//供应商

    /**
     * @云运动 - 后台 - 新增商品验证规则
     * @create 2017/8/29
     * @return array
     */
    public function rules()
    {
        return [
            [['storeId','goodsAttribute','goodsTypeId','unit','goodsName'],'required'],
            [['goodsBrand', 'goodsModel','goodsProducer','goodsSupplier','department_id'],'safe'],
        ];
    }




    /**
     * 云运动 - 仓库管理 - 新增商品
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/29
     * @param $companyId
     * @param $venueId
     * @return boolean/object
     */
    public function addShopData($companyId,$venueId)
    {
            $goods = new Goods();
            $goods->goods_type_id   = $this->goodsTypeId;
            $goods->company_id      = $companyId;
            $goods->venue_id        = $venueId;
            $goods->unit            = $this->unit;
            $goods->goods_name      = $this->goodsName;
            $goods->goods_brand     = $this->goodsBrand;
            $goods->goods_model     = $this->goodsModel;
            $goods->create_time     = time();
            $goods->goods_producer  = $this->goodsProducer;
            $goods->goods_supplier  = $this->goodsSupplier;
            $goods->goods_attribute = $this->goodsAttribute;
            $goods->store_id        = $this->storeId;
            $goods->department_id   = $this->department_id;
            if ($goods->save()) {
               return true;
            } else {
                return $goods->errors;
            }
    }
    

}