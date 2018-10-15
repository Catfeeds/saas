<?php
namespace common\models\relations;

use backend\models\GoodsChange;
use backend\models\GoodsDetail;
use backend\models\GoodsType;
use backend\models\StoreHouse;
use common\models\base\Organization;

trait  GoodsRelations
{
    /**
     * 后台 - 商品管理- 关联商品库存详情表
     * @return string
     * @auther 侯凯新
     * @create 2017-6-6
     * @param
     */
    public function getGoodsDetail(){
        return $this->hasOne(GoodsDetail::className(), ['goods_id'=>'id']);
    }
    /**
     * 后台 - 商品管理 - 关联商品进入库记录表
     * @return string
     * @auther 侯凯新
     * @create 2017-6-6
     * @param
     */
    public  function getGoodsChange(){
        return $this->hasMany(GoodsChange::className(), ['goods_id'=>'id'])->onCondition(["status"=>1]);
    }
    public  function getGoodsChangeS(){
        return $this->hasMany(GoodsChange::className(), ['goods_id'=>'id']);
    }
    /**
     * 后台 - 商品管理 - 关联商品进入库记录表
     * @return string
     * @auther 侯凯新
     * @create 2017-6-6
     * @param
     */
    public  function getGoodsType(){
        return $this->hasOne(GoodsType::className(), ['id'=>'goods_type_id']);
    }

    /**
     * 后台 - 仓库管理 - 关联仓库
     * @return string
     * @author huanghua
     * @create 2017-8-31
     * @param
     */
    public  function getStoreHouse(){
        return $this->hasOne(StoreHouse::className(), ['id'=>'store_id']);
    }

    /**
     * 后台 - 仓库管理 - 关联组织架构表
     * @return string
     * @author huanghua
     * @create 2017-8-31
     * @param
     */
    public  function getOrganization(){
        return $this->hasOne(Organization::className(), ['id'=>'venue_id']);
    }

    /**
     * @desc: 业务后台 - 仓库管理 - 关联部门
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/03/27
     * @return mixed
     */
    public  function getDepartment(){
        return $this->hasOne(Organization::className(), ['id'=>'department_id']);
    }
}