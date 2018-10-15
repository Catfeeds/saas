<?php
namespace backend\models;

class GoodsType extends \common\models\base\GoodsType
{
    /**
     * 后台 - 组织架构管理 - 获取商品所有类别
     * @create 2017/4/24
     * @author lihuien<lihuien@itsports.club>
     * @update huangpengju
     * @update 2017/06/11
     * @param $id   //公司或者场馆id
     * @return array
     */
    public function getGoodsTypeData($id)
    {
        $data =  self::find()
            ->alias('goodsType')
            ->asArray();
        $data = $data->andFilterWhere(['goodsType.venue_id'=>$id]);
        $data = $data->all();

        return $data;
    }
}