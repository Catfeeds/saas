<?php
namespace backend\models;

class DealType extends \common\models\base\DealType
{
    /**
     *  后台 - 合同管理 - 获取类型
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/28
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
     public function search($id)
     {
         $query = DealType::find()->alias('dt')->asArray();
         $query = $this->getSearchWhere($query,$id);
         $query = $query->all();

         return $query;
     }
    /**
     * 后台 - 组织架构管理 - 执行搜索数据过滤
     * @create 2017/4/24
     * @author houkaixin<houkaixin@itsports.club>
     * @param $id
     * @param  $query  //后台的sql语句
     * @return  mixed
     */
    public function getSearchWhere($query, $id)
    {
       $query->andFilterWhere(['dt.company_id'=>$id]);

        return $query;
    }
    /**
     * 后台 - 合同管理 - 删除指定数据
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/25
     * @param $id
     * @return boolean   //返回删除数据的结果
     */
    public function getDel($id){
        $deal = Deal::findAll(['deal_type_id'=>$id]);
        if($deal && !empty($deal)){
            return  false;
        }
        $result = DealType::findOne($id);
        $delResult = $result->delete();
        if ($delResult) {
            return true;
        } else {
            return false;
        }
    }
    public static function getDealTypeOne($id)
    {
        return DealType::find()->where(['id'=>$id])->asArray()->one();
    }
}