<?php
namespace backend\models;
use common\models\Func;
use common\models\relations\GoodsChangeRelations;
class GoodsChange extends \common\models\base\GoodsChange
{
    use GoodsChangeRelations;
    public $keywords;
    public $type;
    const KEY = 'keywords';
    const TYPE = 'type';
    public $num;                         //自定义参数
    /**
     * 后台 - 新商品管理- 获取商品 历史出入库历史记录
     * @create 2017/6/6
     * @author houkaixin<houkaixin@itsports.club>
     * @param $goodsId int  商品ID
     * @return array
     */
    public function getGoodsHistory($goodsId){
        $data = GoodsChange::find()->where(["goods_id"=>$goodsId])->orderBy(["create_at"=>SORT_DESC])->asArray()->all();
        return $data;
    }

    /**
     * 后台 - 仓库管理- 获取商品历史出入库历史记录
     * @create 2017/8/30
     * @author huanghua<huanghua@itsports.club>
     * @param $params int  商品ID
     * @return array
     */

    public function getGoodsData($params)
    {
        $this->customLoad($params);
        $model = GoodsChange::find()
            ->alias('gc')
            ->joinWith([
                'goods goods'=>function($query){
                    $query->joinWith(['goodsDetail goodsDetail']);
                }
            ])
            ->where(["gc.goods_id"=>$params['goodsId']])
            ->select(
                "
                gc.id,
                gc.status,
                gc.goods_id,
                gc.operation_num,
                goodsDetail.storage_num,
                gc.create_at,
                gc.list_num,
                goods.goods_name,
                gc.unit_price as gcUnitPrice,
                gc.describe,
                sum(gc.operation_num) as sum,
                sum(gc.unit_price * gc.operation_num) as money,
                "
                )
            ->orderBy(['gc.create_at' =>SORT_DESC])
            ->groupBy('gc.id')
            ->asArray();
        return $model  = $this->getSearchWhere($model);

    }

    /**
     * 后台 - 仓库管理- 获取商品历史出入库历史记录
     * @create 2017/8/30
     * @author huanghua<huanghua@itsports.club>
     * @param $params int  商品ID
     * @return array
     */

    public function getGoodsDataS($params)
    {
        $this->customLoad($params);
        $model = GoodsChange::find()
            ->alias('gc')
            ->joinWith([
                'goods goods'=>function($query){
                    $query->joinWith(['goodsDetail goodsDetail']);
                }
            ])
            ->where(["gc.goods_id"=>$params['goodsId']])
            ->andWhere(["or","gc.status = 1","gc.status = 6"])
            ->andWhere([">","gc.surplus_amount",0])
            ->select(
                "
                gc.id,
                gc.status,
                gc.goods_id,
                gc.operation_num,
                goodsDetail.unit_price,
                goodsDetail.note,
                goodsDetail.storage_num,
                gc.create_at,
                gc.list_num,
                goods.goods_name,
                goods.unit,
                gc.unit_price as gcUnitPrice,
                gc.surplus_amount,
                sum(gc.surplus_amount) as sum,
                sum(gc.unit_price * gc.surplus_amount) as money,
                "
            )
            ->orderBy(['gc.create_at' =>SORT_DESC])
            ->groupBy('gc.id')
            ->asArray();
        return $model  = $this->getSearchWhere($model);

    }
    /**
     * 后台仓库管理 - 商品详情列表 - 商品详情查询
     * @create 2017/8/28
     * @author huanghua<huanghua@itsports.club>
     * @param $data
     * @return bool
     */
    public function customLoad($data)
    {
        $this->keywords     = (isset($data[self::KEY]) && !empty($data[self::KEY])) ? $data[self::KEY] : null;
        $this->type         = (isset($data[self::TYPE]) && !empty($data[self::TYPE])) ? (int)$data[self::TYPE] : null;
        return true;
    }

    /**
     * 仓库管理 - 商品详情列表 - 增加搜索条件
     * @create 2017/8/28
     * @author huanghua<huanghua@itsports.club>
     * @param $query
     * @return mixed
     */
    public function getSearchWhere($query)
    {
        $query->andFilterWhere([
            'and',
            ['like','gc.list_num', $this->keywords]

        ]);
        $query->andFilterWhere([
            'and',
            [
                'gc.status' => $this->type,
            ]
        ]);
        return $query;
    }

    /**
     * 仓库管理 - 所有商品详情分页
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/31
     * @param  $query
     * @return array
     */
    public function getSumData($query)
    {
        return Func::getDataProvider($query,8);
    }

    /**
     * 仓库管理 - 所有库存和总金额 - 总计
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/31
     * @param  $query
     * @return array
     */
    public function getSumDataMoney($query)
    {
        $store = $query->all();
        $store['unit'] = array_column($store,'unit');
        $store['totalMoney'] = array_sum(array_column($store,'money'));
        $store['totalSum'] = array_sum(array_column($store,'sum'));
        return $store;
    }
    /**
     * 仓库管理 - 列表详情总和 - 总计
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/31
     * @param  $query
     * @return array
     */
    public function getDataMoney($query)
    {
        $store = $query->all();
        $store['totalMoney'] = array_sum(array_column($store,'money'));
        $store['totalSum'] = array_sum(array_column($store,'sum'));
        return $store;
    }


    /**
     * 云运动 - 仓库管理 - 商品出库变更数据计算
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/9/7
     * @param $goodsId
     * @param $number
     * @return boolean/object
     */
    public function goodsCharge($goodsId,$number)
    {
        $goodsChange  = GoodsChange::find()
            ->where(['goods_id'=>$goodsId])
            ->select("cloud_goods_change.id,cloud_goods_change.surplus_amount,cloud_goods_change.unit_price")
            ->andWhere(['or','status=1','status=6'])
            ->andWhere(['<>','surplus_amount',0])
            ->orderBy(['create_at'=>SORT_ASC])
            ->asArray()
            ->all();

        $this->num = $number;

        $num       = 0;
        foreach ($goodsChange as $k=>$v )
        {
            if(intval($v['surplus_amount']) >= intval($this->num)){
                $goodsObj    = GoodsChange::findOne(['id'=>$v['id']]);
                $goodsObj['surplus_amount']    = $v['surplus_amount'] - intval($this->num);
                $allMoney = $goodsObj['unit_price']  *  $this->num;
                $num      += $allMoney;
                return $num;
            }else{
                $this->num                   = intval($this->num) - intval($v['surplus_amount']);
                $goodsObj                    = GoodsChange::findOne(['id'=>$v['id']]);
                $allMoney = $goodsObj['unit_price']  *  $goodsObj['surplus_amount'];
                $num += $allMoney;
            }

        }
        return $num;
    }

}