<?php

namespace backend\models;

use common\models\Func;
use common\models\relations\MobiliseRelations;

class Mobilise extends \common\models\base\Mobilise
{
    use MobiliseRelations;
    public $sorts;//排序
    public $keywords;//关键字仓库名和被调拨商品名
    public $startTime;//开始时间
    public $endTime;//结束时间
    public $type;//商品类别ID
    public $venueId;//商品类别ID

    const KEY = 'keywords';
    const START = 'startTime';
    const END = 'endTime';
    const TYPE = 'type';
    const VENUE_ID = 'venueId';


    /**
     * 后台仓库管理 - 调拨列表 - 调拨信息查询
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/1
     * @param $params //搜索参数
     * @param $venueId
     * @return \yii\db\ActiveQuery
     */
    public function search($params, $venueId)
    {
        $this->customLoad($params);
        $query = Mobilise::find()
            ->alias('mobilise')
            ->joinWith(['mobiliseType mobiliseType'], false)
            ->joinWith(['storeHouse storeHouse'], false)
            ->joinWith(['beStoreHouse beStoreHouse'], false)
            ->joinWith([
                'goods goods' => function ($query) {
                    $query->joinWith(['goodsDetail goodsDetail'], false);
                    $query->joinWith(['goodsType goodsType'], false);
                }
            ], false)
            ->where(['mobilise.venue_id' => $venueId])
            ->orWhere(['mobilise.be_venue_id' => $venueId])
            ->select(
                "
                mobilise.id,
                mobilise.store_id,
                mobilise.be_store_id,
                mobilise.goods_id,
                mobilise.num,
                mobilise.venue_id,
                mobilise.be_venue_id,
                storeHouse.name,
                beStoreHouse.name as beName,
                goods.id as goodsId,
                goods.goods_name,
                goods.goods_model,
                goods.unit,
                goods.goods_type_id,
                goods.goods_attribute,
                goodsDetail.storage_num,
                mobiliseType.id as mobiliseTypeId,
                mobiliseType.mobilise_id,
                mobiliseType.type,
                mobiliseType.update_at,
                goodsType.id as goodsTypeId,
                goodsType.goods_type,
                mobilise.created_at,
               
                "
            )
            ->orderBy($this->sorts)
            ->asArray();
        $query = $this->getSearchWhere($query);
        $dataProvider = Func::getDataProvider($query, 8);

        return $dataProvider;
    }

    /**
     * 后台仓库管理 - 调拨列表 - 仓库信息查询
     * @create 2017/9/1
     * @author huanghua<huanghua@itsports.club>
     * @param $data
     * @return bool
     */
    public function customLoad($data)
    {
        $this->keywords = (isset($data[self::KEY]) && !empty($data[self::KEY])) ? $data[self::KEY] : null;
        $this->type = (isset($data[self::TYPE]) && !empty($data[self::TYPE])) ? (int)$data[self::TYPE] : null;
        $this->startTime = (isset($data[self::START]) && !empty($data[self::START])) ? (int)strtotime($data[self::START]) : null;
        $this->venueId = (isset($data[self::VENUE_ID]) && !empty($data[self::VENUE_ID])) ? (int)$data[self::VENUE_ID] : null;
        $this->endTime = (isset($data[self::END]) && !empty($data[self::END])) ? (int)strtotime($data[self::END]) : null;
        $this->sorts = self::loadSort($data);

        return true;
    }

    /**
     * 仓库管理 - 调拨列表 - 获取排序条件
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
                $attr = '`mobilise`.id';
                break;
            case 'ht_store'           :
                $attr = '`storeHouse`.name';
                break;
            case 'ht_beStore'           :
                $attr = '`beStoreHouse`.name';
                break;
            case 'ht_name'        :
                $attr = '`goods`.goods_name';
                break;
            case 'ht_model'        :
                $attr = '`goods`.goods_model';
                break;
            case 'ht_num'        :
                $attr = '`goodsDetail`.storage_num';
                break;
            case 'ht_type'        :
                $attr = '`mobiliseType`.type';
                break;
            case 'ht_time'        :
                $attr = '`mobilise`.created_at';
                break;
            default;
                return $sorts;
        }
        return $sorts = [$attr => self::convertSortValue($data['sortName'])];

    }

    /**
     * 仓库管理 - 调拨列表 - 获取搜索规格
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
     * 仓库管理 - 调拨列表 - 增加搜索条件
     * @create 2017/9/1
     * @author huanghua<huanghua@itsports.club>
     * @param $query
     * @return mixed
     */
    public function getSearchWhere($query)
    {
        $query->andFilterWhere([
            'or',
            ['like', 'storeHouse.name', $this->keywords],
            ['like', 'beStoreHouse.name', $this->keywords]

        ]);
        $query->andFilterWhere([
            'and',
            ['>=', 'mobilise.created_at', $this->startTime],
            ['<', 'mobilise.created_at', $this->endTime]
        ]);

        $query->andFilterWhere([
            'and',
            [
                'mobilise.venue_id' => $this->venueId,
            ],
        ]);
        $query->andFilterWhere([
            'and',
            [
                'goods.goods_type_id' => $this->type,
            ],
        ]);

        return $query;
    }

    /**
     * 后台 - 仓库管理 - 获取仓库所有名称
     * @create 2017/8/31
     * @author huanghua<huanghua@itsports.club>
     * @param $id //公司或者场馆id
     * @param $type //公司或者场馆类型
     * @return array
     */
    public function getStoreData($id, $type)
    {
        $data = StoreHouse::find()
            ->alias('sh')
            ->select("sh.id,sh.name")
            ->asArray();
        if (isset($type) && $type == 'company') {
            $data = $data->andFilterWhere(['sh.company_id' => $id]);
        }
        if (isset($type) && $type == 'venue') {
            $data = $data->andFilterWhere(['sh.venue_id' => $id]);
        }
        $data = $data->all();
        return $data;
    }

    /**
     * 后台 - 仓库管理- 获取调拨商品的详细数据
     * @create 2017/9/1
     * @author huanghua<huanghua@itsports.club>
     * @param $goodsId int  商品ID
     * @return array
     */
    public function getTheData($goodsId)
    {
        $query = Mobilise::find()
            ->alias('mobilise')
            ->joinWith(['storeHouse storeHouse'], false)
            ->joinWith(['beStoreHouse beStoreHouse'], false)
            ->joinWith(['goods goods'], false)
            ->select("
             mobilise.id,
             mobilise.goods_id,
             mobilise.num,
             mobilise.store_id,
             mobilise.be_store_id,
             goods.goods_name,
             goods.goods_model,
             storeHouse.id as storeHouseId,
             beStoreHouse.id as beStoreHouseId,
             storeHouse.name as storeName,
             beStoreHouse.name as beStoreName,
                        ")
            ->where(["mobilise.goods_id" => $goodsId])
            ->groupBy("mobilise.id")
            ->asArray()->one();
        return $query;
    }

    /**
     * 后台 - 仓库管理- 获取调拨商品列表的详细数据
     * @create 2017/9/1
     * @author huanghua<huanghua@itsports.club>
     * @param $mobiliseTypeId int  商品ID
     * @return array
     */
    public function getOneData($mobiliseTypeId)
    {
        $query = Mobilise::find()
            ->alias('mobilise')
            ->joinWith(['mobiliseType mobiliseType'], false)
            ->select("
             mobilise.id,
             mobiliseType.id as mobiliseTypeId,
             mobiliseType.mobilise_id,
             mobiliseType.type,
             mobiliseType.update_at,
             mobiliseType.note,
              ")
            ->where(["mobiliseType.id" => $mobiliseTypeId])
            ->groupBy("mobiliseType.id")
            ->asArray()->one();
        return $query;
    }

}
