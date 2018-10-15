<?php
namespace backend\controllers;

use backend\models\GoodsUpdateForm;
use backend\models\Goods;
use backend\models\GoodsChange;
use backend\models\GoodsForm;
use backend\models\GoodsType;
use backend\models\Mobilise;
use common\models\Func;
class ShopController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * @api {get} /shop/shop-list  商品列表分页显示
     * @apiVersion 1.0.0
     * @apiName 商品列表分页显示
     * @apiGroup shop
     * @apiPermission 管理员
     * @apiParam {string} topSearch 顶部搜索栏搜索
     * @apiParam {string} sortType 排序的字段
     * @apiParam {string} sortName 排序的方式
     * @apiParamExample {json} Request Example
     * GET   /shop/shop-list
     * {
     *       topSearch: "加多宝",      //搜索栏搜索内容
     *       sortType :"goodsName",   //柜子排序字段 1:goodsName（商品名称）2：goodsType（商品类别）3：goodsBrand（商品品牌）4：unitPrice（商品单价）5:intoNum(入库数量)6:storeNum结库余存
     *       sortName："ASC",         // 排序方式（1 ASC(升序)DES（降序））
     * }
     * @apiDescription  商品列表分页显示
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/6
     *
     * @apiSampleRequest  http://qa.uniwlan.com/shop/shop-list
     * @apiSuccess (返回值) data  返回数据
     * * @apiSuccessExample {json} 成功示例:
     *{
     *   'id' => string '1' ,                    //商品id
     *   "goodsName"=>"加多宝冰红茶"            //商品名称
     *   'goods_type_id' => string '1' ,       //商品类型id
     *   'goodsBrand' => string '中国好声音（来）  //商品品牌
     *   "goodsModel"=> string "商品型号"          //商品型号
     *   'unitPrice' => string '4'                 // 商品单价
     *   'goodsSupplier’ => string '加多宝公司'   // 商品供应商
     *   'goodsProducer' => string '加多宝公司'  //商品生产商
     *   'storage_num'    => 100              // 结库余存
     *  'goods_type' => string '47' (length=2)    // 商品类别
     *  'intoNum' => 100                       //商品入库数量
     * 'unitPrice' => 150                     //商品单价
     * 'storage_num' => 150                   // 库存数量 150件
     *
     * };
     */
    public function  actionShopList(){
        $name                = \Yii::$app->request->queryParams;
        $model               = new Goods();
        $shopDataObj         = $model->getData($name,$this->nowBelongId,$this->nowBelongType);
        $pagination          = $shopDataObj->pagination;
        $pages               = Func::getPagesFormat($pagination);
        return json_encode(["data"=>$shopDataObj->models,'pages'=>$pages]);
    }
    /**
     * @api {get} /shop/get-goods-type-data  获取商品所有类别
     * @apiVersion 1.0.0
     * @apiName 获取商品所有类别
     * @apiGroup  goods
     * @apiPermission 管理员
     * @apiDescription 获取商品所有类别
     * <br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/6
     *
     * @apiSampleRequest  http://qa.uniwlan.com/shop/get-goods-type-data
     * @apiSuccess (返回值) data  返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *   id	:1	自增ID
     *   venueId	:1	场馆id
     *   companyId	:1	公司id
     *   goods_type	:'食品类'		商品类别
     *   create_at	:'215665527772'	创建时间
     * };
     */
    public function  actionGetGoodsTypeData(){
        $model               = new GoodsType();
        $shopDataObj         = $model->getGoodsTypeData($this->venueIds);

        return json_encode(["data"=>$shopDataObj]);
    }
    /**
     * @api {post} /shop/set-goods-type  设置商品类别
     * @apiVersion 1.0.0
     * @apiName 设置商品类别
     * @apiGroup  goods
     * @apiPermission 管理员
     * @apiParam {string} typeName 类型名称
     * @apiParam {string} _csrf_backend 验证
     * @apiParamExample {json} Request Example
     * GET   /shop/shop-list
     * {
     *       typeName: "食品类",      //搜索栏搜索内容
     *       _csrf_backend :"__asjdgsajdgasjdgasgduiasdgasidhaosd==",
     * }
     * @apiDescription 设置商品类别
     * <br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/6
     *
     * @apiSampleRequest  http://qa.uniwlan.com/shop/set-goods-type
     * @apiSuccess (返回值) data  返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *   'status':'success',
     *   'data'  :'添加成功'
     * };
     */
    public function  actionSetGoodsType(){
        $post = \Yii::$app->request->post();
        $model               = new GoodsForm([],'type',$this->companyId,$this->venueId);
        if($model->load($post,'') && $model->validate()){
            $save = $model->saveType();
            if($save['status'] === "success"){
                return json_encode(["status"=>'success','data'=>'添加成功',"id"=>$save["id"]]);
            }
            return json_encode(["status"=>'error','data'=>$save["message"]]);
        }
        return json_encode(["status"=>'error','data'=>$model->errors]);
    }
    /**
     * @api {get} /shop/set-goods-data  设置商品
     * @apiVersion 1.0.0
     * @apiName 设置商品
     * @apiGroup  goods
     * @apiPermission 管理员
     * @apiParam {int} goodsTypeId 类型ID
     * @apiParam {int} [goodsId]   商品ID 修改商品时必传
     * @apiParam {string} goodsName 商品名称
     * @apiParam {string} goodsBrand 商品品牌
     * @apiParam {int}    unitPrice 商品单价
     * @apiParam {string} goodsModel 商品型号
     * @apiParam {string} goodsProducer 生产商
     * @apiParam {string} goodsSupplier 供应商
     * @apiParam {string} scenario  场景 添加:'insert' 修改：'update'
     * @apiParam {string} _csrf_backend 验证
     * @apiParamExample {json} Request Example
     * GET   /shop/shop-list
     * {
     *       goodsTypeId: "1",
     *       goodsId: "1",
     *       goodsName: '脉动',
     *       goodsBrand: "百事",
     *       unitPrice: "100",
     *       goodsModel: "1",
     *       goodsProducer: "我爱运动",
     *       goodsSupplier: "我爱运动",
     *       scenario     :'insert'
     *       _csrf_backend :"__asjdgsajdgasjdgasgduiasdgasidhaosd==",
     * }
     * @apiDescription 设置商品
     * <br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/6
     *
     * @apiSampleRequest  http://qa.uniwlan.com/shop/set-goods-data
     * @apiSuccess (返回值) data  返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *   'status':'success',
     *   'data'  :'添加成功'
     * };
     */
    public function  actionSetGoodsData(){
        $post = \Yii::$app->request->post();
        $scenario = isset($post['scenario'])?$post['scenario']:'insert';
        $model               = new GoodsForm([],$scenario,$this->companyId,$this->venueId);
        if($model->load($post,'') && $model->validate()){
            if($scenario == 'insert'){
                $save = $model->insertGoods();
            }else{
                $save = $model->updateGoods();
            }
            if($save === true){
                return json_encode(["status"=>'success','data'=>'添加成功']);
            }
            return json_encode(["status"=>'error','data'=>$save]);
        }
        return json_encode(["status"=>'error','data'=>$model->errors]);
    }
    /**
     * @api {get} /shop/get-goods-detail  获取商品详情
     * @apiVersion 1.0.0
     * @apiName  获取商品详情
     * @apiGroup  goods
     * @apiParam {string} id 商品Id
     *
     * @apiDescription 获取商品详情
     * <br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/6
     *
     * @apiSampleRequest  http://qa.uniwlan.com/shop/get-goods-details
     * @apiSuccess (返回值) data  返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *        id	:1	自增ID
     *       goods_type_id: "1", //类型ID
     *       goods_name: '脉动', //商品名称
     *       goods_brand: "百事", //商品品牌
     *       unit_price: "100",   //商品单价
     *       goods_model: "1",    //商品型号
     *       goods_producer: "我爱运动",// 商品生产商
     *       goods_supplier: "我爱运动", //商品供应商
     * };
     */
    public function  actionGetGoodsDetail($id)
    {
        $model               = new Goods();
        $shopDataObj         = $model->getGoodsDetailData($id);
        return json_encode(["data"=>$shopDataObj]);
    }
    /**
     * @api {post} /shop/out-in-storage  *商品 出入库 退货
     * @apiVersion 1.0.0
     * @apiName 商品 出入库 退货
     * @apiGroup  theGoods
     * @apiPermission 管理员
     * @apiParam {string} scenario  场景 入库:'storage' 出库：'library' 退货："quiteGoods"
     * @apiParam {int} goodsId  "商品id",
     * @apiParam {int} number  "商品数量",
     * @apiParam {int} unit   "商品单位,
     * @apiParam {int} listNum "商品入库单号,
     * @apiParam {string} _csrf_backend 验证
     * @apiParamExample {json} Request Example
     * GET    /shop/out-in-storage  商品入库
     * {
     *       goodsId: "1",        //商品id
     *       number: 16,          //商品数量
     *       unit: 个,            //商品单位
     *       listNum : 1111111,   //商品入库单号
     *       scenario     :'storage'
     *       _csrf_backend :"__asjdgsajdgasjdgasgduiasdgasidhaosd==",
     * }
     * post    /shop/out-in-storage  商品出库
     * {
     *       goodsId: "1",        //商品id
     *       number: 16,          //商品数量，
     *       describe:"好好好"，  // 商品描述
     *       listNum：11111       // 商品编号      （增加发送的参数）
     *       scenario: 'library'，// 商品出库
     *       _csrf_backend :"__asjdgsajdgasjdgasgduiasdgasidhaosd==",
     * }
     * post  /shop/out-in-storage  商品退货
     * {
     *       goodsId: "1",        //商品id
     *       number: 16,          //商品数量，
     *       describe:"好好好"，  // 商品描述
     *       scenario: "quiteGoods"，// 商品退货
     *       _csrf_backend :"__asjdgsajdgasjdgasgduiasdgasidhaosd==",
     * }
     * @apiDescription  商品 出入库 退货
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/6
     *
     * @apiSampleRequest  http://qa.uniwlan.com/shop/out-in-storage
     * @apiSuccess (返回值) data  返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *   'status':'success',
     *   'data'  :'操作成功'
     * };
     */
    public function actionOutInStorage(){
        $post = \Yii::$app->request->post();
        $scenario = isset($post['scenario'])?$post['scenario']:'insert';
        $model               = new GoodsForm([],$scenario,$this->companyId,$this->venueId);
        if($model->load($post,'') && $model->validate()){
            if($scenario == 'storage'){
                $save = $model->insertGoodsStorage();
            }else{
                $save = $model->insertGoodsLibrary();
            }
            if($save === true){
                return json_encode(["status"=>'success','data'=>'操作成功']);
            }
            return json_encode(["status"=>'error','data'=>$save]);
        }
        return json_encode(["status"=>'error','data'=>$model->errors]);
    }
    /**
     * @api {get} /shop/damage-over-flow  商品损坏 外溢
     * @apiVersion 1.0.0
     * @apiName 商品损坏 外溢
     * @apiGroup  goods
     * @apiPermission 管理员
     * @apiParam {string} scenario  场景 入库:'damage' 出库：'overflow'
     * @apiParam {int} goodsId  "商品id",
     * @apiParam {int} number  "商品数量",
     * @apiParam {int} unit   "商品单位,
     * @apiParam {int} unit   "商品单位,
     * @apiParam {string} _csrf_backend 验证
     * @apiParamExample {json} Request Example
     * GET    /shop/damage-over-flow  商品报损
     * {
     *       goodsId: "1",        //商品id
     *       number: 16,          //损坏数量
     *       unit: 个,            //损坏单位
     *       describe:"好好好"，  // 描述
     *       scenario:'damage'，
     *       _csrf_backend :"__asjdgsajdgasjdgasgduiasdgasidhaosd==",
     * }
     * GET    /shop/damage-over-flow  商品外溢
     * {
     *       goodsId: "1",        //商品id
     *       number: 16,          //商品数量
     *       unit: 个,            //报溢单位
     *       describe:"好好好"，  // 描述
     *       scenario :'overflow'   // 场景
     *       _csrf_backend :"__asjdgsajdgasjdgasgduiasdgasidhaosd==",
     * }
     * @apiDescription  商品 出入库
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/7
     * @apiSampleRequest  http://qa.uniwlan.com/shop/damage-over-flow
     * @apiSuccess (返回值) data  返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *   'status':'success',
     *   'data'  :'操作成功'
     * };
     */
    public function actionDamageOverflow(){
        $post     = \Yii::$app->request->post();
        $scenario = isset($post['scenario'])?$post['scenario']:'insert';
        $model    = new GoodsForm([],$scenario,$this->companyId,$this->venueId);
        if($model->load($post,'') && $model->validate()){
                $save = $model->insertGoodsCharge();
            if($save === true){
                return json_encode(["status"=>'success','data'=>'操作成功']);
            }
            return json_encode(["status"=>'error','data'=>$save]);
        }
        return json_encode(["status"=>'error','data'=>$model->errors]);
    }
    /**
     * @api {get} /shop/get-goods-history  商品历史出入库记录
     * @apiVersion 1.0.0
     * @apiName 商品历史出入库记录
     * @apiGroup  goods
     * @apiPermission 管理员
     * @apiParam {int} goodsId  "商品id",
     * @apiParamExample {json} Request Example
     * GET     /shop/get-goods-history  商品历史出入库记录
     * {
     *       goodsId: "1",        //商品id
     * }
     * @apiDescription  商品历史出入库记录
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/7
     * @apiSampleRequest  http://qa.uniwlan.com/shop/damage-over-flow
     * @apiSuccess (返回值) data  返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *    id:27,
     *   goods_id :12,   //商品id
     *   status  : 1，   //商品状态（1:入库 2：出库 3：报损 4:退库 5:报溢）
     *  operation_num:12 //商品操作数量
     *  list_num:111111  //商品单号
     *  unit:个          //单位
     *  create_at:12123131 //创建时间
     *  describe: "哈好好" // 描述
     * };
     */
    public function actionGetGoodsHistory($goodsId){
         $model  = new GoodsChange();
         $result = $model->getGoodsHistory($goodsId);
         return json_encode($result);
    }


    public function actionGetGoodsTheDetail($goodsId){
         $model  = new Goods();
         $result = $model->getTheData($goodsId);
         if($result){
             $mobilise = Mobilise::find()->where(['be_store_id'=>$result['store_id']])->count();
             $result['mobilise'] = $mobilise;
         }
         return json_encode($result);
    }

    /**
     * @api{post} /shop/goods-update 商品管理 - 修改商品
     * @apiVersion  1.0.0
     * @apiName 商品管理 - 修改商品
     * @apiGroup Shop
     * @apiPermission 管理员
     *
     * @apiParam {int} goodsId 商品id
     * @apiParam {int} typeId 商品类别
     * @apiParam {string} name 商品名称
     * @apiParam {string} brand 商品品牌
     * @apiParam {string} model 商品型号
     * @apiParam {decimal} unit 商品单价
     * @apiParam {string} producer 生产商
     * @apiParam {string} supplier 供应商
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     * {
     *      "goodsId": "3",
     *      "typeId": "1",
     *      "name": "欧菲光",
     *      "brand": "酷狗",
     *      "model": "米开功",
     *      "unit": "2222",
     *      "producer": "开工融入",
     *      "supplier": "美国",
     *      "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     * }
     * @apiDescription 商品管理-修改商品<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/21<br/>
     * <span><strong>调用方法：</strong></span>/shop/goods-update
     * @apiSampleRequest  http://qa.uniwlan.com/shop/goods-update
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"修改成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':""}
     */
    public function actionGoodsUpdate()
    {
        $companyId = isset($this->companyId) ? $this->companyId : 0;
        $venueId   = isset($this->venueId) ? $this->venueId : 0;
        $post      = \Yii::$app->request->post();
        $model     = new GoodsUpdateForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->goodsUpdate($companyId,$venueId);
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api{get} /shop/del-goods 商品管理-删除商品
     * @apiVersion  1.0.0
     * @apiName 商品管理-删除商品
     * @apiGroup Shop
     * @apiPermission 管理员
     *
     * @apiParam {int} goodsId 商品ID
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "goodsId": "3",
     *   }
     * @apiDescription 商品管理-删除商品<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/21<br/>
     * <span><strong>调用方法：</strong></span>/shop/del-goods
     * @apiSampleRequest  http://qa.uniwlan.com/shop/del-goods
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"删除成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':"删除失败"}
     */
    public function actionDelGoods()
    {
        $id    = \Yii::$app->request->get('goodsId');
        $model = new GoodsUpdateForm();
        $data  = $model->delGoods($id);
        if ($data === true) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $data]);
        }
    }

    public function actionGetVenueGoods(){
        $model = new Goods();
        $data  = $model->getVenueGoods($this->nowBelongType,$this->nowBelongId);
        return json_encode($data);
    }

}
