<?php
/**
 * Created by PhpStorm.
 * User: 付钟超 <fuzhongchao@itsports.club>
 * Date: 2018/5/6 0006
 * Time: 10:12
 */

namespace backend\models;

use common\models\AdvertisingStatistics;
use common\models\Func;
use common\models\AdvertisingSetting;

class Advertising extends \common\models\Advertising
{
    public $companyId;
    public $start;
    public $end;
    public $keywords;
    public $sortName;           //排序规则
    public $sortType;           //排序字段
    public $sort;


    const SORTNAME = 'sortName';
    const KEYWORDS = 'keywords';
    const START = 'start';
    const END = 'end';
    const COMPANY_ID = 'companyId';
    public function search($params)
    {
        $setId = $this->loadParams($params);
        $query = Advertising::find()
            ->alias('adv')
            ->andFilterWhere(['adv.setting_id'=>$setId])
            ->orderBy($this->sort)
            ->asArray();
        $query = $this->searchWhere($query);
        $data  = Func::getDataProvider($query,8);

        return  $data;
    }

    /**
     * @desc: 业务后台 - 获取广告列表 - 参数
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @param $params
     * @return int|mixed
     */
    public function loadParams($params)
    {
        $this->keywords = (isset($params[self::KEYWORDS]) && !empty($params[self::KEYWORDS])) ? $params[self::KEYWORDS] : null;
        $this->start    = (isset($params[self::START]) && !empty($params[self::START])) ? strtotime($params[self::START]) : null;
        $this->end      = (isset($params[self::END]) && !empty($params[self::END])) ? strtotime($params[self::END]) : null;
        $this->companyId= (isset($params[self::COMPANY_ID]) && !empty($params[self::COMPANY_ID])) ? $params[self::COMPANY_ID] : null;
        $this->sort     = self::loadSort($params);
        if (empty($this->companyId)) {
            return null;
        }else{
            $set  = AdvertisingSetting::find()->where(['and',['company_id'=>$this->companyId],['type'=>1]])->one();
            if(!empty($set)){
                return $set['id'];
            }

            return null;
        }
    }

    /**
     * @desc: 业务后台 - 获取排序规则
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/07
     * @param $params
     * @return array|int
     */
    static public function loadSort($params)
    {
        $sort = ['`adv`.status' => SORT_DESC];
        if (!isset($params['sortType'])) { return $sort; }
        switch ($params['sortType']) {
            case 'name' :
                $attr = '`adv`.name';
                break;
            case 'creat_date' :
                $attr = '`adv`.create_at';
                break;
            case 'use_time' :
                $attr = '`adv`.start';
                break;
            case 'status' :
                $attr = '`adv`.status';
                break;
            default :
                $attr = '`adv`.status';
        }
        if ($attr) $sort = [$attr => self::nameSort($params['sortName'])];
        return $sort;
    }

    /**
     * @desc: 业务后台 - 列表筛选 - 升降序
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/07
     * @param $name
     * @return int
     */
    static public function nameSort($name)
    {
        if ($name == 'ASC') {
            return SORT_ASC;
        }elseif ($name == 'DES') {
            return SORT_DESC;
        }else {
            return SORT_DESC;
        }
    }

    /**
     * @desc: 业务后台 - 获取广告列表 - 搜索参数
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @param $query
     * @return mixed
     */
    public function searchWhere($query)
    {
        $query->andFilterWhere(['like','name',$this->keywords]);
        if (!is_null($this->start) && !is_null($this->end)) {
            $query->andFilterWhere(['between','create_at',$this->start,$this->end]);
        }
        return $query;
    }

    /**
     * @desc: 业务后台 - 获取广告启动页配置
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @param $companyId
     * @return array|null|\yii\db\ActiveRecord
     */
    static public function setting($companyId)
    {
        $data = AdvertisingSetting::find()->where(['type'=>1])->andFilterWhere(['company_id'=>$companyId])->asArray()->one();

        return $data ?: [];
    }

    /**
     * @desc: 业务后台 - 获取广告详情
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @param $id
     * @return array
     */
    static public function detail($id)
    {
        $data = \common\models\Advertising::findOne($id)->toArray();
        if (!empty($data)) {
            $venue = array_column(json_decode($data['venue_ids']),'venue');
            $data['venue_ids'] = $venue;
        }
        return $data;
    }

    /**
     * @desc: 业务后台 - 删除 - 删除广告和记录
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @param $id
     * @return string
     * @throws \yii\db\StaleObjectException
     */
    static public function deleteAdv($id)
    {
        $data = \common\models\Advertising::findOne($id);
        if (empty($data)) {
            return 'noData';
        } else {
            if ($data->status == 0) {
                $data->delete();
                AdvertisingStatistics::deleteAll(['ad_id'=>$id]);
            }elseif ($data->status == 1) {
                return 'error';
            }
        }
    }

    /**
     * @desc: 业务后台 - 启用广告
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @param $id
     * @return string
     */
    public function run($id,$companyId)
    {
        $data = self::detail($id);
        if (empty($data)) {
            return 'noData';            //无此信息
        }
        if ($data['status'] == 1) {
            return 'run';               //已启用,请勿重复启用
        }
        $set = AdvertisingSetting::findOne($data['setting_id']);          //查找配置信息
        if (empty($set)) {
            return 'noSet';             //没有设置广告配置
        }
        if ($set->status == 0) {
            return 'noGo';              //没有启用广告页
        }
        /*if (count($data) == 1 && $data[0] == 0) {
            return 'repeat';            //有场馆重复启用,请重试
        }*/
        //判断所有的场馆是否启用
        $sql1 = "JSON_CONTAINS(venue_ids->'$[*].venue' ,  '\"0\"', '$')";
        $data1 = \common\models\Advertising::find()->where($sql1)->andWhere(['and',['status'=>1],['setting_id'=>$set->id]])->asArray()->all();
        if ($data1) {
            foreach ($data1 as $value) {
                $result = self::is_time_cross($data['start'],$data['end'],$value['start'],$value['end']);
                if ($result) {
                    return 'repeat';
                }
            }
        }
        $sql = self::queryVenueIds($data['venue_ids'],$companyId);
        $data2 = \common\models\Advertising::find()->where($sql)->andWhere(['and',['status'=>1],['setting_id'=>$set->id]])->asArray()->all();
        if ($data2) {
            foreach ($data2 as $value) {
                $result = self::is_time_cross($data['start'],$data['end'],$value['start'],$value['end']);
                if ($result) {
                    return 'repeat';
                }
            }
        }
        \common\models\Advertising::updateAll(['status'=>1],['id'=>$id]);
        return 'success';
    }

    /**
     * @desc: 业务后台 - 启用时的sql语句重组
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @param $ids
     * @return string
     */
    public function queryVenueIds($ids,$companyId)
    {
        if (count($ids) == 1 && $ids[0] == 0) {
            $ids = \common\models\Organization::find()->where(['and',['style'=>2],['is_allowed_join'=>1]])->andFilterWhere(['pid'=>$companyId])->asArray()->column();
        }
        $sql = '';
        foreach ($ids as $id) {
            //拼装sql语句
            $str = "JSON_CONTAINS(venue_ids->'$[*].venue' ,  '\"$id\"', '$')";
            $sql = $sql.' or '.$str;
        }
        return trim($sql,' or ');
    }

    /**
     * @desc: 业务后台 - 停用
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @param $id
     * @return bool
     */
    static public function stop($id)
    {
        $data = \common\models\Advertising::findOne($id);
        $data->status = 0;
        $result = $data->save();
        return $result;
    }

    /**
     * @desc: 业务后台 - 总开关 - 开启/关闭启动页广告
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @param $id
     * @param $status
     * @return bool
     */
    static public function set($id, $status)
    {
        $data = AdvertisingSetting::findOne($id);
        if ($status == 0) {
            $data->status = 1;
        }elseif ($status == 1) {
            $data->status = 0;
        }
        $result = $data->save();
        if ($result) {
            \common\models\Advertising::updateAll(['status'=>0],['setting_id'=>$id]);
            return true;
        }
        return false;
    }

    /**
     * @desc: 业务后台 - 获取单条广告的详情记录
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    static public function record($id)
    {
        $data = AdvertisingStatistics::find()
            ->alias('ads')
            ->joinWith(['organization org'],false)
            ->where(['ad_id'=>$id])
            ->select('ads.*,org.name')
            ->orderBy('ads.show_num desc')
            ->asArray()
            ->all();
        return $data;
    }

    /**
     * @desc: 业务后台 - 判断时间是否重叠
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/07
     * @param string $beginTime1
     * @param string $endTime1
     * @param string $beginTime2
     * @param string $endTime2
     * @return bool
     */
    public function is_time_cross($beginTime1 = '', $endTime1 = '', $beginTime2 = '', $endTime2 = '') {
        $status = $beginTime2 - $beginTime1;
        if ($status > 0) {
            $status2 = $beginTime2 - $endTime1;
            if ($status2 >= 0) {
                return false;
            } else {
                return true;
            }
        } else {
            $status2 = $endTime2 - $beginTime1;
            if ($status2 > 0) {
                return true;
            } else {
                return false;
            }
        }
    }

}