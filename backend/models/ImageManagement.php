<?php
namespace backend\models;
use common\models\Func;
use Yii;
use common\models\relations\PictureRelations;
class ImageManagement extends \common\models\base\ImageManagement
{
    use PictureRelations;
    public $keywords;
    public $startTime;
    public $endTime;
    public $type;
    public $sorts;
    public $venueId;   // 场馆id

    const KEY   = 'keywords';
    const START = 'startTime';
    const END   = 'endTime';
    const TYPE  = 'type';
    const VENUE = 'venueId';

    public $nowBelongId;
    public $nowBelongType;
    const NOW_BELONG_ID = 'nowBelongId';
    const NOW_BELONG_TYPE = 'nowBelongType';


    /**
     * 图片管理 - 列表 - 获取排序条件
     * @create 2017/8/11
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
        switch($data['sortType'])
        {
            case 'hh_id'          :
                $attr = '`hh`.id';
                break;
            case 'hh_venue'           :
                $attr = '`hh`.venue_id';
                break;
            case 'hh_name'           :
                $attr = '`hh`.name';
                break;
            case 'hh_type'        :
                $attr = '`hh`.type';
                break;
            case 'hh_size'        :
                $attr = '`hh`.image_size';
                break;
            case 'hh_dimension'        :
                $attr = '`hh`.image_wide';
                break;
            case 'hh_createdTime'        :
                $attr = '`hh`.created_at ';
                break;
            case 'hh_url'        :
                $attr = '`hh`.url';
                break;
            default;
                return $sorts;
        }
        return $sorts = [ $attr  => self::convertSortValue($data['sortName']) ];

    }
    /**
     * 图片管理 - 列表 - 获取搜索规格
     * @create 2017/8/11
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
     * 后台图片管理 - 图片列表 - 图片信息查询
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/11
     * @param $params //搜索参数
     * @return \yii\db\ActiveQuery
     */
    public function search($params)
    {
        $this->customLoad($params);
        $query = ImageManagement::find()
            ->alias('hh')
            ->joinWith(['organization organization'])
            ->joinWith(['organizations organizations'])
            ->joinWith(['imageManagementType imageManagementType'],false)
            ->select(
                "   
                hh.id,
                hh.name,
                hh.type,
                hh.image_size,
                hh.image_wide,
                hh.image_height, 
                hh.created_at, 
                hh.url,
                hh.company_id,
                hh.venue_id,
                organization.name as venueName,
                organizations.name as companyName,
                imageManagementType.type_name,
                "
            )
            ->groupBy(["hh.id"])
            ->orderBy($this->sorts)
            ->asArray();
        $query                 = $this->getSearchWhere($query);
        $dataProvider          =  Func::getDataProvider($query,8);
        return  $dataProvider;
    }

    /**
     * 图片管理 - 图片列表 - 搜索数据处理数据
     * @create 2017/8/11
     * @author huanghua<huanghua@itsports.club>
     * @param $data
     * @return bool
     */
    public function customLoad($data)
    {
        $this->keywords     = (isset($data[self::KEY]) && !empty($data[self::KEY])) ? $data[self::KEY] : null;
        $this->type         = (isset($data[self::TYPE]) && !empty($data[self::TYPE])) ? (int)$data[self::TYPE] : null;
        $this->startTime    = (isset($data[self::START])&& !empty($data[self::START]))? (int)strtotime($data[self::START]) : null;
        $this->endTime      = (isset($data[self::END]) && !empty($data[self::END])) ? (int)strtotime($data[self::END]) : null;
        $this->venueId      = (isset($data[self::VENUE]) && !empty($data[self::VENUE])) ? (int)$data[self::VENUE] : null;
        $this->nowBelongId  = (isset($data[self::NOW_BELONG_ID]) && !empty($data[self::NOW_BELONG_ID]))?$data[self::NOW_BELONG_ID]: NULL;
        $this->nowBelongType= (isset($data[self::NOW_BELONG_TYPE]) && !empty($data[self::NOW_BELONG_TYPE]))?$data[self::NOW_BELONG_TYPE]: NULL;
        $this->sorts = self::loadSort($data);

        return true;
    }

    /**
     * 图片管理 - 列表 - 增加搜索条件
     * @create 2017/8/11
     * @author huanghua<huanghua@itsports.club>
     * @param $query
     * @return mixed
     */
    public function getSearchWhere($query)
    {
        $query->andFilterWhere([
            'and',
            ['like','hh.name', $this->keywords]
        ]);

        $query->andFilterWhere([
            'and',
            ['>=','hh.created_at',$this->startTime],
            ['<','hh.created_at',$this->endTime]
        ]);
        $query->andFilterWhere([
            'and',
            [
                'hh.venue_id' => $this->venueId,
            ],
        ]);
        $query->andFilterWhere([
            'and',
            [
                'hh.type' => $this->type,
            ],
        ]);

        if($this->nowBelongType && $this->nowBelongType == 'company'){
            $query->andFilterWhere(['hh.company_id'=>$this->nowBelongId]);
        }
        if($this->nowBelongType && ($this->nowBelongType == 'venue' || $this->nowBelongType == 'department')){
            $query->andFilterWhere(['hh.venue_id'=>$this->nowBelongId]);
        }
        return $query;
    }

    /**
     * 后台图片管理 - 图片详情 - 多表查询
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/11
     * @param $picId
     * @create 2017/8/11
     * @return \yii\db\ActiveQuery
     */
    public function  getPicModel($picId)
    {
        $model = ImageManagement::find()
            ->alias('hh')
            ->joinWith(['organization organization'],false)
            ->joinWith(['organizations organizations'],false)
            ->select(
                " 
                hh.id,
                hh.name,
                hh.type,
                hh.image_size,
                hh.image_wide,
                hh.image_height, 
                hh.created_at, 
                hh.url,
                hh.company_id,
                hh.venue_id,
                organization.name as venueName,
                organizations.name as companyName,
              "
            )
            ->where(['hh.id' => $picId])
            ->asArray()->one();
        return $model;

    }
    /**
     * 后台 - 图片管理 - 图片信息删除
     * @author huang hua <huanghua@itsports.club>
     * @create 2017/8/11
     * @param $id
     * @return bool
     */
    public  function  getPictureDel($id)
    {
        $pic                =   ImageManagement::findOne($id);
        $resultDel          =   $pic->delete();
        if($resultDel)
        {
            return true;
        }else{
            return false;
        }
    }
    /**
     * 后台 - 图片管理 - 图片信息删除
     * @author huang hua <huanghua@itsports.club>
     * @create 2017/8/11
     * @param $picId
     * @return bool
     */
    public static function getDelPic($picId)
    {
        $resultDel          =   ImageManagement::deleteAll(['id'=>$picId]);
        if($resultDel){
            return true;
        }else{
            return false;
        }
    }
}