<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/8/29
 * Time: 17:31
 */

namespace backend\models;
use common\models\Func;
use yii\base\Model;

class LeagueStatistics extends Model
{
    public $startTime;
    public $endTime;
    public $keyword;
    public $type;
    public $sorts;
    public $venueId;
    public $searchDateStart;
    public $searchDateEnd;
    public $dateArr = array();
    const SEARCH   = 'keyword';
    const START    = 'start';
    const END      = 'end';
    const TYPE     = 'type';
    const VENUE    = 'venueId';
    /**
     * 验卡管理 - 根据查询爽约会员
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/6/23
     * @param  $params
     * @return string
     */
    public function loadParams($params)
    {
        $this->keyword   = (isset($params[self::SEARCH]) && !empty($params[self::SEARCH])) ? $params[self::SEARCH] : null;
        $this->startTime = (isset($params[self::START])  && !empty($params[self::START]))  ? strtotime($params[self::START]) : null;
        $this->endTime   = (isset($params[self::END])    && !empty($params[self::END]))     ? strtotime($params[self::END]) : null;
        $this->type      = (isset($params[self::TYPE]) && !empty($params[self::TYPE])) ? $params[self::TYPE] : null;
        $this->venueId   = (isset($params[self::VENUE]) && !empty($params[self::VENUE])) ? $params[self::VENUE] : null;
        if(isset($params['date']) && $params['date'] == 'date'){
            $this->getAboutDate();
        }
        if(isset($params['total']) && !empty($params['total']) && $params['total'] != 'date'){
            if(empty($this->startTime)){
                $this->getAboutTotalDate();
            }
        }
        if(isset($params['sort']) && !empty($params['sort'])){
            $this->sorts = [
                'total' => SORT_DESC
            ];
        }
    }
    /**
     * 验卡管理 - 根据查询团课统计
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/6/23
     * @param  $params
     * @return string
     */
     public function getLeagueList($params)
     {
       $this->loadParams($params);
       $query = Employee::find()->alias('ee')
             ->joinWith(['organizations ors'],false)
             ->joinWith(['aboutClassCoach acc'],false)
             ->joinWith(['organization oo'],false)
             ->where(['and',['oo.code'=>'tuanjiao']])
             ->select('
             ee.*,
             ors.name as orName,
             count(acc.coach_id) as classTotal,
             count(acc.class_id) as classNum,
             (count(acc.coach_id)/count(acc.class_id)) as average
             ')
             ->groupBy('acc.coach_id')
             ->asArray();
       $query = $this->leagueWhere($query);
       return $query;
     }
    /**
     * 验卡管理 - 根据处理条件
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/23
     * @param  $query
     * @return string
     */
    public function leagueWhere($query)
    {
        $query->andFilterWhere(['and',['>=','acc.start',$this->startTime],['<','acc.start',$this->endTime]]);
        $query->andFilterWhere(['acc.status'=>4]);
        $query->andFilterWhere(['like','ee.name',$this->keyword]);
        $query->andFilterWhere(['ee.venue_id'=>$this->venueId]);
        return $query;
    }
    /**
     * 验卡管理 - 根据处理条件
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/6/23
     * @param  $query
     * @return string
     */
    public function getLeaguePage($query)
    {
        return Func::getDataProvider($query,8);
    }
    /**
     * 验卡管理 - 根据处理条件
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/6/23
     * @param  $query
     * @return string
     */
    public function getLeagueAll($query)
    {
        $data = [];
        $leagueArr = $query->all();
        $data['totalClass']  = array_sum(array_column($leagueArr,'classNum'));
        $data['totalMember'] = count(array_column($leagueArr,'classTotal'));
        return $data;
    }
    /**
     * 验卡管理 - 根据处理条件
     * @author lihuien <lihuien@itsports.club>
     * @param  $params
     * @create 2017/6/23
     * @return string
     */
    public function getCoachClassByDate($params)
    {
       $this->loadParams($params);
       return AboutClass::find()
           ->alias('ac')
           ->where(['ac.coach_id'=>$params['coach_id']])
           ->andFilterWhere(['ac.status'=>4])
           ->andWhere(['and',['>=','ac.start',$this->startTime],['<','ac.start',$this->endTime]]);
    }
    /**
     * 验卡管理 - 根据处理条件
     * @author lihuien <lihuien@itsports.club>
     * @param  $params
     * @create 2017/6/23
     * @return string
     */
    public function getAboutClassPro($params)
    {
        $query = $this->getCoachClassByDate($params);
        $data  = $query->asArray()->all();
        $arr   = [];
        if(!empty($data)){
            foreach ($data as $key => $value){
                $date = date($this->type,$value['start']);
                $date = ltrim((string)$date,"0");  // 数据处理
                $arr["$date"] = isset($arr["$date"]) ?$arr["$date"]: 0;
                $arr["$date"] = $arr["$date"] + 1;
            }
           foreach ($arr as $k => &$v){
               $this->dateArr[$k] = $v;
           }
        }
        return  (array)$this->dateArr;
    }

    public function getAboutDate()
    {
        if($this->type == 'm'){
            $this->startTime = strtotime(date('Y').'-01-01 00:00:00');
            $this->endTime   = strtotime(date('Y-m-d').' 23:59:59');
            $num = 1;
            $key = 12;
        }else if($this->type == 'd'){
            $this->startTime = strtotime(date('Y-m').'-01 00:00:00');
            $this->endTime   = strtotime(date('Y-m-d').' 23:59:59');
            $num = 0;
            $key = 31;
        }else{
            $this->startTime = strtotime((date('Y')-6) .'-01-01 00:00:00');
            $this->endTime   = strtotime(date('Y-m-d').' 23:59:59');
            $num = (date('Y')-6);
            $key = date('Y');
        }
        for ($i = $num ; $i <= $key ;$i++ ){
            $this->dateArr[$i] = 0;
        }
    }
    /**
     * 验卡管理 - 根据处理条件
     * @author lihuien <lihuien@itsports.club>
     * @param  $params
     * @create 2017/6/23
     * @return string
     */
    public function getAboutClassTotal($params)
    {
        $query = $this->getCoachClassByDate($params);
        $query->joinWith(['member mm'=>function($query){
            $query->joinWith(['memberDetails md']);
        }])->joinWith(['groupClass gc'=>function($query){
            $query->joinWith(['course course']);
        }],false)
        ->select('ac.*,md.sex,course.name,count(ac.class_id) as classNum')
        ->groupBy('ac.id')
        ->asArray();
        $data  = $query->all();
        $arr   = [];
        if(!empty($data)){
            $arr['memberTotal'] = count($data);
            $sex     = array_column($data,'sex');
            foreach ($sex as $k=>$v){
                if($v == 1){
                    $arr['memberMen'] = isset($arr['memberMen']) ? $arr['memberMen'] : 0;
                    $arr['memberMen'] = $arr['memberMen'] + 1;
                }
            }
            $arr['memberMen']   = isset($arr['memberMen']) ? $arr['memberMen'] : 0;
            $arr['memberWoMen'] = $arr['memberTotal'] - $arr['memberMen'];
            $arr['class']       = $data;
        }
        return $arr;
    }
    /**
     * 验卡管理 - 根据处理条件
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/6/23
     * @return string
     */
    public function getAboutTotalDate()
    {
        if($this->type == 'm'){
            $this->startTime = strtotime(date('Y').'-01-01 00:00:00');
            $this->endTime   = strtotime(date('Y-m-d').' 23:59:59');
        }elseif($this->type == 'd'){
            $this->startTime = strtotime(Func::getGroupClassDate($this->type,true));
            $this->endTime   = strtotime(Func::getGroupClassDate($this->type,false));
        }else{
            $this->startTime = strtotime((date('Y')-6) .'-01-01 00:00:00');
            $this->endTime   = strtotime(date('Y-m-d').' 23:59:59');
        }
    }
    /**
     * 验卡管理 - 获取教练团课详情
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/6/23
     * @param $params
     * @return string
     */
    public function getGroupClassDetailByCoach($params)
    {
       $this->loadParams($params);
       return  GroupClass::find()
            ->alias('gc')
            ->joinWith(['course course'])
            ->joinWith(['aboutClass ac'],false)
            ->where(['gc.coach_id'=>$params['coach_id']])
            ->andFilterWhere(['ac.status'=>4])
            ->andWhere(['and',['>=','gc.start',$this->startTime],['<','gc.start',$this->endTime]])
            ->select('gc.*,course.name,count(ac.class_id) as classNum')
            ->groupBy('ac.class_id')
            ->asArray();
    }
    /**
     * 验卡管理 - 根据处理条件
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/6/23
     * @param  $query
     * @return string
     */
    public function getLeagueDetailAll($query)
    {
        $data = [];
        $leagueArr = $query->all();
        $data['totalClass']  = array_sum(array_column($leagueArr,'classNum'));
        $data['totalNum']    = count($leagueArr);
        $data['average']     = ($data['totalNum'] != 0) ? $data['totalClass']/$data['totalNum'] : 0;
        return $data;
    }
}