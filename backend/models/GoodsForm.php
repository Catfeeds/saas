<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/6/6
 * Time: 16:12
 */

namespace backend\models;


use common\models\base\Goods;
use common\models\base\GoodsChange;
use common\models\base\GoodsDetail;
use common\models\base\GoodsType;
use yii\base\Model;

class GoodsForm  extends Model
{
    public $typeName;    //类型名称
    public $companyId;   //公司ID
    public $venueId;     //场馆ID
    public $goodsTypeId; //类型ID
    public $goodsName;   //商品名称
    public $goodsBrand;  //商品品牌
    public $unitPrice;   //商品单价
    public $goodsModel;  //商品型号
    public $goodsProducer; //生产商
    public $goodsSupplier;//供应商
    public $goodsId;
    public $number;
    public $unit;
    public $listNum;
    public $status;
    public $describe;
    public $goodsAttribute;
    public function __construct(array $config,$scenario,$companyId,$venueId)
    {
        $this->scenario  = $scenario;
        $this->companyId = $companyId;
        $this->venueId   = $venueId;
        parent::__construct($config);
    }

    public function scenarios()
    {
        return [
            'type'   =>['typeName'],
            'insert' =>["goodsAttribute",'goodsTypeId','goodsName','goodsBrand','unitPrice','goodsModel','goodsProducer','goodsSupplier','unit'],
            'update' =>["goodsAttribute",'goodsId','goodsTypeId','goodsName','goodsBrand','unitPrice','goodsModel','goodsProducer','goodsSupplier','unit'],
            'storage'=>['goodsId','number','listNum','unit'],
            'library'=>['goodsId','number',"describe",'listNum','unit'],
            'quiteGoods'=>['goodsId','number',"	describe",'unit'],
            "damage" =>["goodsId","number","describe","unit","scenario"],
            "overflow" =>["goodsId","number","describe","unit","scenario"],
        ];
    }
    public function rules()
    {
        return [
          [['typeName','goodsId','goodsTypeId','goodsName','goodsBrand',
             'unitPrice','goodsModel','goodsProducer','goodsSupplier',"number",
              "unit","listNum","describe","goodsAttribute"],"safe",
             'on'=>["type","insert","update","storage","library","quiteGoods","damage","overflow"]]
        ];
    }
    //商品类型
    public function saveType()
    {
        $goods = GoodsType::findOne(["goods_type"=>$this->typeName,"venue_id"=>$this->venueId]);
        if(!empty($goods)){
            return ["status"=>"error","message"=>"商品已存在"];
        }
        $type = new GoodsType();
        $type->goods_type  =  $this->typeName;
        $type->company_id  = $this->companyId;
        $type->venue_id    = $this->venueId;
        $type->create_at   = time();
        if($type->save()){
             $id = $type->id;
             return ["status"=>"success",'id'=>$id];
        }
        return ["status"=>"error","id"=>""];
    }
    //添加商品
    public function insertGoods()
    {
        $goods = new Goods();
        $goods->goods_type_id  = $this->goodsTypeId;
        $goods->company_id     = $this->companyId;
        $goods->venue_id       = $this->venueId;
        $goods->unit            = $this->unit;
        $goods->unit_price     = $this->unitPrice;
        $goods->goods_name     = $this->goodsName;
        $goods->goods_brand    = $this->goodsBrand;
        $goods->goods_model    = $this->goodsModel;
        $goods->create_time     = time();
        $goods->goods_producer = $this->goodsProducer;
        $goods->goods_supplier  = $this->goodsSupplier;
        $goods->goods_attribute = $this->goodsAttribute;
        if($goods->save()){
            return true;
        }
        return $goods->errors;
    }
    //修改商品
    public function updateGoods()
    {
        $goods = Goods::findOne(['id'=>$this->goodsId]);
        $goods->goods_type_id = $this->goodsTypeId;
        $goods->goods_name    = $this->goodsName;
        $goods->unit_price    = $this->unitPrice;
//        $goods->goods_brand   = $this->goodsBrand;
//        $goods->goods_model   = $this->goodsModel;
//        $goods->goods_producer = $this->goodsProducer;
//        $goods->goods_supplier = $this->goodsSupplier;
//        $goods->goods_attribute = $this->goodsAttribute;
        if($goods->save()){
            return true;
        }
        return $goods->errors;
    }
    //商品入库
    public function insertGoodsStorage()
    {
        $goods = GoodsDetail::findOne(['goods_id'=>$this->goodsId]);
        $this->status = 1;
        if(empty($goods)){
            $goodsDetail = new GoodsDetail();
            $goodsDetail->goods_id    = $this->goodsId;
            $goodsDetail->storage_num = $this->number;
            $goodsDetail->unit        = $this->unit;
            $goodsDetail->create_at   = time();
            $this->insertGoodsCharge();
            if($goodsDetail->save()){
                return true;
            }
            return $goodsDetail->errors;
        }else{
            $goods->storage_num = intval($goods->storage_num) + intval($this->number);
            $this->insertGoodsCharge();
            if($goods->save()){
                return true;
            }
            return $goods->errors;
        }
    }
    //商品出库
    public function insertGoodsLibrary()
    {
        $goods = GoodsDetail::findOne(['goods_id'=>$this->goodsId]);
        if($this->scenario=="quiteGoods"){
            $this->status = 4;
        }else{
            $this->status = 2;
        }
        if(empty($goods->storage_num)||!isset($goods->storage_num)){
            return "出货数量超出库存数量";
        }
        $num = intval($goods->storage_num) - intval($this->number);
        if($num<0){
           return "出货数量超出库存数量";
        }
//        $goods->unit        = $this->unit;
        $goods->storage_num = $num;
        $this->insertGoodsCharge();
        if($goods->save()){
            return true;
        }
        return $goods->errors;
    }
    //商品记录
    public function insertGoodsCharge()
    {
        if($this->scenario==="damage"){
            $this->status = 3;
        }
        if($this->scenario==="overflow"){
            $this->status = 5;
        }
        $goodsDetail = new GoodsChange();
        $goodsDetail->goods_id      = $this->goodsId;
        $goodsDetail->status        = $this->status;
        $goodsDetail->operation_num = $this->number;
        $goodsDetail->list_num      = isset($this->listNum)&&!empty($this->listNum)?$this->listNum:null;
        $goodsDetail->unit          = $this->unit;
        $goodsDetail->create_at     = time();
        $goodsDetail->describe      = isset($this->describe)&&!empty($this->describe)?$this->describe:null;
        if($goodsDetail->save()){
            return true;
        }
        return $goodsDetail->errors;
    }
}