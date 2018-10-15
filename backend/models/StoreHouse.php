<?php
namespace backend\models;
use backend\models\Goods;
use common\models\Func;
use common\models\relations\StoreHouseRelations;
class StoreHouse extends \common\models\base\StoreHouse
{
    use StoreHouseRelations;
    public $sorts;//排序
    public $keywords;//关键字仓库名和商品名
    public $venueId;//场馆id
    public $startTime;//开始时间
    public $endTime;//结束时间
    public $type;//类型
    public $category;//品类
//    public $goodsBrands;//商品品牌
//    public $goodsModel;//商品型号
    const KEY = 'keywords';
    const VENUE_ID = 'venueId';
    const START = 'startTime';
    const END = 'endTime';
    const TYPE = 'type';
    const CATEGORY = 'category';
//    const GOODS_BRANDS = 'goodsBrands';
//    const GOODS_MODEL = 'goodsModel';

    public $nowBelongId;
    public $nowBelongType;
    const NOW_BELONG_ID = 'nowBelongId';
    const NOW_BELONG_TYPE = 'nowBelongType';


    /**
     * 后台仓库管理 - 仓库列表 - 仓库信息查询
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/28
     * @param $params //搜索参数
     * @return \yii\db\ActiveQuery
     */
    public function search($params)
    {
        $this->customLoad($params);
        $query = StoreHouse::find()
            ->alias('sh')
            ->joinWith(['organization organization'], false)
            ->joinWith([
                'goods goods' => function ($query) {
                    $query->joinWith(['goodsDetail goodsDetail'], false);
                    $query->joinWith(['goodsType goodsType'], false);
                }
            ], false)
            ->select(
                "
                sh.id,
                sh.name,
                sh.venue_id,
                organization.id as venueId,
                organization.name as venueName,
                goods.id as goodsId,
                goods.goods_name,
                goods.goods_attribute,
                goods.store_id,
                goods.goods_type_id,
                goods.create_time,
                goodsType.goods_type,
                goods.goods_model,
                goodsDetail.storage_num,
                goodsDetail.unit_price,
                "
            )
            ->groupBy(["sh.id"])
            ->orderBy($this->sorts)
            ->asArray();
        $query = $this->getSearchWhere($query);
        $dataProvider = Func::getDataProvider($query, 8);
        return $dataProvider;
    }

    /**
     * 后台仓库管理 - 仓库列表 - 仓库信息查询
     * @create 2017/8/28
     * @author huanghua<huanghua@itsports.club>
     * @param $data
     * @return bool
     */
    public function customLoad($data)
    {
        $this->keywords = (isset($data[self::KEY]) && !empty($data[self::KEY])) ? $data[self::KEY] : null;
        $this->type = (isset($data[self::TYPE]) && !empty($data[self::TYPE])) ? (int)$data[self::TYPE] : null;
        $this->startTime = (isset($data[self::START]) && !empty($data[self::START])) ? (int)strtotime($data[self::START]) : null;
        $this->endTime = (isset($data[self::END]) && !empty($data[self::END])) ? (int)strtotime($data[self::END]) : null;
        $this->venueId = (isset($data[self::VENUE_ID]) && !empty($data[self::VENUE_ID])) ? (int)$data[self::VENUE_ID] : null;
        $this->category = (isset($data[self::CATEGORY]) && !empty($data[self::CATEGORY])) ? $data[self::CATEGORY] : NULL;
//        $this->goodsBrands  = (isset($data[self::GOODS_BRANDS]) && !empty($data[self::GOODS_BRANDS]))?$data[self::GOODS_BRANDS]: NULL;
//        $this->goodsModel   = (isset($data[self::GOODS_MODEL]) && !empty($data[self::GOODS_MODEL]))?$data[self::GOODS_MODEL]: NULL;
        $this->nowBelongId = (isset($data[self::NOW_BELONG_ID]) && !empty($data[self::NOW_BELONG_ID])) ? $data[self::NOW_BELONG_ID] : NULL;
        $this->nowBelongType = (isset($data[self::NOW_BELONG_TYPE]) && !empty($data[self::NOW_BELONG_TYPE])) ? $data[self::NOW_BELONG_TYPE] : NULL;
        $this->sorts = self::loadSort($data);

        return true;
    }

    /**
     * 仓库管理 - 列表 - 获取排序条件
     * @create 2017/8/28
     * @author huanghua<huanghua@itsports.club>
     * @param $data
     * @return mixed
     */
    public static function loadSort($data)
    {
        $sorts = [
            'id' => SORT_DESC
        ];
        if (!isset($data['sortType'])) {
            return $sorts;
        }
        switch ($data['sortType']) {
            case 'ht_id'          :
                $attr = '`sh`.id';
                break;
            case 'ht_name'           :
                $attr = '`sh`.name';
                break;
            case 'ht_venue'           :
                $attr = '`organization`.name';
                break;
            case 'ht_goodsName'        :
                $attr = '`goods`.goods_name';
                break;
            case 'ht_type'        :
                $attr = '`goods`.goods_attribute';
                break;
            case 'ht_category'        :
                $attr = '`goodsType`.goods_type';
                break;
            case 'ht_goodsModel'        :
                $attr = '`goods`.goods_model';
                break;
            case 'ht_stockNum'        :
                $attr = '`goodsDetail`.storage_num';
                break;
            case 'ht_totalAmount'        :
                $attr = '`goodsDetail`.unit_price';
                break;
            case 'ht_createTime'        :
                $attr = '`goods`.create_time';
                break;
            default;
                return $sorts;
        }
        return $sorts = [$attr => self::convertSortValue($data['sortName'])];

    }

    /**
     * 仓库管理 - 仓库列表 - 获取搜索规格
     * @create 2017/8/28
     * @author huanghua<huanghua@itsports.club>
     * @param $sort
     * @return mixed
     */
    public static function convertSortValue($sort)
    {
        if ($sort == 'ASC') {
            return SORT_ASC;
        } elseif ($sort == 'DES') {
            return SORT_DESC;
        }
    }

    /**
     * 仓库管理 - 仓库列表 - 增加搜索条件
     * @create 2017/8/28
     * @author huanghua<huanghua@itsports.club>
     * @param $query
     * @return mixed
     */
    public function getSearchWhere($query)
    {
        $query->andFilterWhere([
            'or',
            ['like', 'sh.name', $this->keywords],
            ['like', 'goods.goods_name', $this->keywords],
            ['like', 'goods.goods_brand', $this->keywords],
            ['like', 'goods.goods_model', $this->keywords]

        ]);
        $query->andFilterWhere([
            'and',
            [
                'sh.venue_id' => $this->venueId,
            ],
        ]);
        $query->andFilterWhere([
            'and',
            ['>=', 'sh.created_at', $this->startTime],
            ['<', 'sh.created_at', $this->endTime]
        ]);

        $query->andFilterWhere([
            'and',
            [
                'goods.goods_attribute' => $this->type,
            ],
        ]);
        $query->andFilterWhere([
            'and',
            [
                'goods.goods_type_id' => $this->category,
            ],
        ]);
//        $query->andFilterWhere([
//            'and',
//            [
//                'goods.goods_model' => $this->goodsModel,
//            ],
//        ]);
//        $query->andFilterWhere([
//            'and',
//            [
//                'goods.goods_brand' => $this->goodsBrands,
//            ],
//        ]);
        if ($this->nowBelongType && $this->nowBelongType == 'company') {
            $query->andFilterWhere(['sh.company_id' => $this->nowBelongId]);
        }
        if ($this->nowBelongType && ($this->nowBelongType == 'venue' || $this->nowBelongType == 'department')) {
            $query->andFilterWhere(['sh.venue_id' => $this->nowBelongId]);
        }
        return $query;
    }

    /**
     * 后台 - 仓库管理 - 获取仓库所有名称
     * @create 2017/8/31
     * @author huanghua<huanghua@itsports.club>
     * @return array
     */
    public function getStoreData()
    {
        $roleId = \Yii::$app->user->identity->level;
        if ($roleId == 0) {
            $vId = Organization::find()->select('id')->where(['style' => 2])->asArray()->all();
            $venueIds = array_column($vId, 'id');
        } else {
            $venuesId = Auth::findOne(['role_id' => $roleId])->venue_id;
            $authId = json_decode($venuesId);
            $venues = Organization::find()->where(['id' => $authId])->andWhere(['is_allowed_join' => 1])->select(['id', 'name'])->asArray()->all();
            $venueId = array_column($venues, 'id');

        }
        $venueId = (isset($venueIds) && !empty($venueIds)) ? $venueIds : $venueId;
        $venues = StoreHouse::find()->select(['id', 'name','venue_id'])->where(['venue_id' => $venueId])->asArray()->all();
        return $venues;
    }

    /**
     * 后台 - 仓库管理 - 获取仓库所有名称
     * @create 2017/10/17
     * @author huanghua<huanghua@itsports.club>
     * @param $venueId
     * @return array
     */
    public function getStoreDataAll($venueId)
    {
        $storeData = StoreHouse::find()
            ->select(['id', 'name','venue_id'])
            ->where(['venue_id' => $venueId])
            ->asArray()
            ->all();
        return $storeData;
    }

    /**
     *后台仓库管理 - 修改商品信息 - 获取单个商品的详情
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/3
     * @return bool|string
     */
    public function getGoodsInfo($id)
    {
        return $data = Goods::find()
            ->joinWith(['storeHouse sh'],false)
            ->alias('goods')
            ->where(['goods.id'=>$id])
            ->joinWith(['goodsDetail gd'],false)
            ->select(['goods.*','gd.storage_num','sh.name as store_name'])
            ->asArray()
            ->one();
    }

    /**
     *后台仓库管理 - 修改商品信息 - 获取当前场馆的所有仓库
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/3
     * @return bool|string
     */
    public function getAllStores($id)
    {
        return $data = StoreHouse::find()->where(['venue_id'=>$id])->select(['id','name'])->asArray()->all();
    }

    /**
     *后台仓库管理 - 修改商品信息 - 获取当前场馆的所有商品类别
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/3
     * @return bool|string
     */
    public function getAllTypes($id)
    {
        return $data = GoodsType::find()->where(['venue_id'=>$id])->select(['id','goods_type'])->asArray()->all();
    }

    /**
     *后台仓库管理 - 修改商品信息 - 点击完成
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/3
     * @return bool|string
     */
    public function updateGoodsInfo($goodsId,$param)
    {
        $goods = \common\models\base\Goods::findOne(['id'=>$goodsId]);
        $goods->goods_name      = $param['goodsName'];
        $goods->venue_id        = $param['venueId'];
        $goods->goods_attribute = $param['goodsAttribute'];
        $goods->goods_type_id   = $param['goodsTypeId'];
        $goods->goods_brand     = $param['brand'];
        $goods->goods_model     = $param['model'];
        $goods->goods_producer  = $param['producer'];
        $goods->goods_supplier  = $param['supplier'];
        $goods->department_id   = (int)$param['department_id'];
        if($goods->save()){
            return true;
        }else{
            return false;
        }
    }

    /**
     *后台仓库管理 - 修改商品信息 - 添加商品品类
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/3
     * @return bool|string
     */
    public function addGoodsType($param)
    {
        $goodsType = new GoodsType();
        $goodsType->goods_type = $param['goodsType'];
        $goodsType->venue_id = $param['venueId'];
        $goodsType->company_id = $param['companyId'];
        return $goodsType->save();
    }
}
