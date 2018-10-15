<?php
namespace backend\models;
use common\models\Func;
use Yii;
use common\models\relations\PictureRelations;
class ImageManagementType extends \common\models\base\ImageManagementType
{
    /**
     *  后台 - 图片管理 - 获取类型
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/16
     * @param $id
     * @param $type
     * @return array|\yii\db\ActiveRecord[]
     */
    public function search($id,$type)
    {
        $query = ImageManagementType::find()->alias('imt')->asArray();
        $query = $this->getSearchWhere($query,$id,$type);
        $query = $query->all();
        return $query;
    }
    /**
     * 后台 - 图片管理 - 执行搜索数据过滤
     * @create 2017/8/16
     * @author huanghua<huanghua@itsports.club>
     * @param  $query  //后台的sql语句
     * @param $id
     * @param $type
     * @return  mixed
     */
    public function getSearchWhere($query,$id,$type)
    {
        if($type && $type == 'company'){
            $query->andFilterWhere(['imt.company_id'=>$id]);
        }
        if($type && ($type == 'venue' || $type == 'department')){
            $query->andFilterWhere(['imt.venue_id'=>$id]);
        }
        return $query;
    }
    /**
     * 后台 - 图片管理 - 获取修改的数据
     * @create 2017/8/16
     * @author huanghua<huanghua@itsports.club>
     * @param $id
     * @return  mixed
     */
    public static function getPicTypeOne($id)
    {
        return ImageManagementType::find()->where(['id'=>$id])->asArray()->one();
    }
    /**
     * 后台 - 图片管理 - 删除指定数据
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/16
     * @param $id
     * @return boolean   //返回删除数据的结果
     */
    public function getDel($id){
        $deal = ImageManagement::findAll(['type'=>$id]);
        if($deal && !empty($deal)){
            return  false;
        }
        $result = ImageManagementType::findOne($id);
        $delResult = $result->delete();
        if ($delResult) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 云运动 - 图片管理 - 获取图片类别名
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/17
     * @param $id
     * @param $type
     * @return boolean
     */
    public function getPicType($id,$type)
    {
        $query = ImageManagementType::find()->alias('imt')->select("imt.id,imt.type_name")->asArray();
        $query = $this->getSearchWhere($query,$id,$type);
        $query = $query->all();
        return $query;
    }
}