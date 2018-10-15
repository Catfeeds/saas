<?php

namespace backend\models;

use common\models\base\Auth;
use common\models\Func;
use yii\base\Model;

class HomePage extends Model
{
    public $theDateStart;
    public $theDateEnd;
    public $classDate;

    public $companyId;
    public $venueId;
    public $nowBelongId;
    public $nowBelongType;
    const NOW_BELONG_ID = 'nowBelongId';
    const NOW_BELONG_TYPE = 'nowBelongType';
    const VENUE = 'venueId';

    public $keywords;
    public $sorts;
    public $searchContent;
    const KEY = 'keywords';
    const SEARCH_CONTENT = 'searchContent';
    public $sellId;//销售id
    const SELL_ID = 'sellId';
    public $startTime;
    public $endTime;
    const START = 'startTime';
    const END = 'endTime';
    public $sex;
    const SEX = 'sex';
    public $coachId;
    const COACH_ID = 'coachId';
    public $cardId;
    const CARD_ID = 'cardId';
    public $anotherVenue;
    const ANOTHER_VENUE = 'anotherVenue';
    public $viceMember;
    const VICE_MEMBER = 'viceMember';

    /**
     * 后台 - 主页-  统计不同时间段到店人数记录
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param  $param
     * @param  $exist
     * @return object     //返回指定场馆的所有教室信息
     */
    public function arrivalNumPeople($param, $exist)
    {
        $this->autoLoad($param);
        $query = \backend\models\EntryRecord::find()
            ->alias('er')
            ->joinWith(["member member" => function ($query) {
                $query->joinWith(["memberCourseOrder mco" => function ($value) {
                    $value->joinWith(["employee employees"], false);
                }]);
                $query->joinWith(["memberDetails md"], false);
                $query->joinWith(["employee ee"], false);
            }], false)
            ->joinWith(["memberCard mc" => function ($query) {
            }], false)
            ->select(
                "er.id,
                er.member_card_id,
                er.venue_id,
                er.entry_time,
                er.leaving_time,
                er.member_id,
                member.username,
                member.mobile,
                md.sex as memberSex,
                md.name as memberName,
                mc.card_name,
                mc.card_number,
                md.pic,
                mc.type,
                ee.name as counselorName,
                employees.name as privateName
               ")
            ->orderBy($this->sorts)
            ->groupBy('er.id')
            ->asArray();
        $query = $this->setWhere($query);         //场馆和公司判断
        if (!empty($exist)) {
            $data = $this->combineData($query);
            return Func::getDataProvider($data, 8);
        } else {
            return Func::getDataProvider($query, 8);
        }
    }

    /**
     * 后台 - 主页-  初始化日期数据
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/25
     */
    public function autoLoad($param)
    {
        if (isset($param['month']) && $param['month'] == 'month') {
            $dateStart = $param["date"] . '-01' . " " . "00:00:00";
            $dateEnd = $param["date"] . '-30' . " " . "23:59:59";
        } elseif (isset($param["date"])) {
            $dateStart = $param["date"] . " " . "00:00:00";
            $dateEnd = $param["date"] . " " . "23:59:59";
            $this->classDate = $param["date"];
        } elseif (isset($param["startTime"]) && isset($param["endTime"])) {
            $dateStart = $param["startTime"] . " " . "00:00:00";
            $dateEnd = $param["endTime"] . " " . "23:59:59";
        }
        if (isset($dateStart) && isset($dateEnd)) {
            $this->startTime = strtotime($dateStart);
            $this->endTime = strtotime($dateEnd);
        }

        $this->venueId = (isset($param['venueId']) && !empty($param['venueId'])) ? $param['venueId'] : \backend\rbac\Config::accessVenues();
        $this->nowBelongId = (isset($param[self::NOW_BELONG_ID]) && !empty($param[self::NOW_BELONG_ID])) ? $param[self::NOW_BELONG_ID] : null;
        $this->keywords = (isset($param[self::KEY]) && !empty($param[self::KEY])) ? $param[self::KEY] : null;
        $this->searchContent = (isset($param[self::SEARCH_CONTENT]) && !empty($param[self::SEARCH_CONTENT])) ? $param[self::SEARCH_CONTENT] : null;
        $this->sellId = (isset($param[self::SELL_ID]) && !empty($param[self::SELL_ID])) ? $param[self::SELL_ID] : null;
        $this->sex = (isset($param[self::SEX]) && !empty($param[self::SEX])) ? $param[self::SEX] : null;
        $this->coachId = (isset($param[self::COACH_ID]) && !empty($param[self::COACH_ID])) ? $param[self::COACH_ID] : null;
        $this->cardId = (isset($param[self::CARD_ID]) && !empty($param[self::CARD_ID])) ? $param[self::CARD_ID] : null;
        $this->anotherVenue = (isset($param[self::ANOTHER_VENUE]) && !empty($param[self::ANOTHER_VENUE])) ? $param[self::ANOTHER_VENUE] : null;
        $this->viceMember = (isset($param[self::VICE_MEMBER]) && !empty($param[self::VICE_MEMBER])) ? $param[self::VICE_MEMBER] : null;
        $this->sorts = self::loadSort($param);

        return true;
    }

    /**
     * 后台 - 营运统计 - 今日到店详情处理搜索条件
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/3
     * @param $query
     * @return string
     */
    public function setWhere($query)
    {
        if (empty($this->anotherVenue)) {
            $query->andFilterWhere(['er.venue_id' => $this->venueId]);
        } else {
            $query->andFilterWhere(['and',
                ['er.venue_id' => $this->nowBelongId],
                ['mc.venue_id' => $this->anotherVenue]
            ]);
        }
        $query->andFilterWhere([
            'or',
            ['like', 'md.name', $this->keywords],
            ['like', 'mc.card_number', $this->keywords],
            ['like', 'mc.card_name', $this->keywords],
            ['like', 'member.mobile', $this->keywords],
            ['like', 'ee.name', $this->keywords],
            ['like', 'employees.name', $this->keywords]
        ]);
        $query->andFilterWhere([
            'and',
            ['>=', 'er.entry_time', $this->startTime],
            ['<=', 'er.entry_time', $this->endTime]
        ]);
        if ($this->sex == '3') {
            $query->andFilterWhere(['and', ['!=', 'md.sex', '1'], ['!=', 'md.sex', '2']]);
        } else {
            $query->andFilterWhere(['md.sex' => $this->sex]);
        }
        $query->andFilterWhere(['member.counselor_id' => $this->sellId]);
        $query->andFilterWhere(['mco.private_id' => $this->coachId]);
        $query->andFilterWhere(['mc.type' => $this->cardId]);
        if ($this->viceMember == '1') {
            $query->andWhere(['IS NOT', 'mc.pid', NULL]);
        }

        return $query;
    }

    /**
     * @云运动 - 营运统计 - 获取排序条件
     * @create 2017/7/20
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @param $data
     * @return bool
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
            case 'entryTime'  :
                $attr = '`er`.entry_time';
                break;
            case 'sex'        :
                $attr = '`md`.sex';
                break;
            case 'cardType'   :
                $attr = '`mc`.card_name';
                break;
            case 'cardNumber' :
                $attr = '`mc`.card_number';
                break;
            default;
                return $sorts;
        }
        return $sorts = [$attr => self::convertSortValue($data['sortName'])];
    }

    /**
     * @云运动 - 营运统计 - 获取搜索规格
     * @create 2017/7/20
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @param $sort
     * @return bool
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
     * 后台 - 主页-  统计一天之内不同时间的到场人数
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param   $param // 初始化参数
     * @return  object     //返回不同时间点到场人数统计
     */
    public function combineData($param)
    {
        $this->autoLoad($param);
        $query = \backend\models\EntryRecord::find()
            ->alias('er')
            ->joinWith(["member member" => function ($query) {
                $query->joinWith(["memberDetails md"], false);
            }], false)
            ->joinWith(['memberCard mc'], false)
            ->select(
                "er.member_id,
                 er.member_card_id,
                 er.venue_id,
                 er.entry_time,
                 md.sex as memberSex,
                 member.venue_id,
                 mc.card_name,
                ")
            ->groupBy('er.id')
            ->asArray();
        $query = $this->setWhere($query);
        $query = $query->all();
        $data = [];
        $menDateData = $this->combineDataAgain();
        $womenDateData = $this->combineDataAgain();
        $allDateData = $this->combineDataAgain();
        if (isset($query) && !empty($query)) {
            foreach ($query as $keys => $values) {
                $memDate = (int)date("H", $values["entry_time"]);
                $allDateData["time" . $memDate] = $allDateData["time" . $memDate] + 1;
                if ($values["memberSex"] == 1) {
                    $menDateData["time" . $memDate] = $menDateData["time" . $memDate] + 1;
                } elseif ($values["memberSex"] == 2) {
                    $womenDateData["time" . $memDate] = $womenDateData["time" . $memDate] + 1;
                }
            }
        }
        $data["men"] = $menDateData;
        $data["women"] = $womenDateData;
        $data["all"] = $allDateData;
        $data['menNum'] = array_sum($menDateData);
        $data['womenNum'] = array_sum($womenDateData);
        $data["allNum"] = array_sum($allDateData);

        return $data;
    }

    /**
     * 后台 - 主页-  统计一天之内不同时间的到场人数(组装初始数据)
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/25
     * @param
     * @return array     //返回场馆初始人数
     */
    public function combineDataAgain()
    {
        $dateData = [];
        for ($i = 0; $i <= 23; $i++) {
            $key = "time" . $i;
            $dateData[$key] = 0;
        }
        return $dateData;
    }

    /**
     * @describe 销售主页 - 销售额统计
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-08-01
     * @param $param
     * @return array
     */
    public function TotalMoney($param)
    {
        $this->autoLoads($param);
        $query = Order::find()
            ->select('cloud_order.total_price,cloud_order.pay_money_time')
            ->where(["between", "cloud_order.pay_money_time", $this->theDateStart, $this->theDateEnd])
            ->andWhere(["cloud_order.status" => 2])
            ->asArray();
        $query->andFilterWhere(['cloud_order.venue_id' => $this->venueId]);
        $query = $query->all();

        $salesDateData = $this->salesDataAgain();
        if (isset($query) && !empty($query)) {
            foreach ($query as $keys => $values) {
                $saleDate = intval(date("d", $values['pay_money_time']));
                $salesDateData['sales' . $saleDate] = $salesDateData['sales' . $saleDate] + intval($values['total_price']);
            }
        }

        return $salesDateData;
    }

    /**
     * 后台 - 主页-  初始化日期数据
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/25
     * @param
     */
    public function autoLoads($param)
    {
        if (isset($param['month']) && $param['month'] == 'month') {
            $dateStart = $param["date"] . '-01' . " " . "00:00:00";
            $dateEnd = $param["date"] . '-31' . " " . "23:59:59";
        } else {
            $dateStart = $param["date"] . " " . "00:00:00";
            $dateEnd = $param["date"] . " " . "23:59:59";
            $this->classDate = $param["date"];
        }
        $this->theDateStart = strtotime($dateStart);
        $this->theDateEnd = strtotime($dateEnd);

        $this->venueId = (isset($param['venueId']) && !empty($param['venueId'])) ? $param['venueId'] : \backend\rbac\Config::accessVenues();

        return true;
    }

    /**
     * 后台 - 主页-  统计一个月之内的销售额(组装初始数据)
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/25
     * @param
     * @return array     //返回场馆初始人数
     */
    public function salesDataAgain()
    {
        $dateData = [];
        for ($i = 1; $i <= 31; $i++) {
            $key = "sales" . $i;
            $dateData[$key] = 0;
        }
        return $dateData;
    }

    /**
     * @describe 销售主页 - 销售额统计 - 周
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-08-01
     * @param $param
     * @return array
     */
    public function TotalMoneyWeek($param)
    {
        $this->autoLoadWeek($param);
        $query = Order::find()
            ->select('cloud_order.total_price,cloud_order.pay_money_time')
            ->where(["between", "cloud_order.pay_money_time", $this->theDateStart, $this->theDateEnd])
            ->andWhere(['cloud_order.venue_id' => $this->venueId])
            ->andWhere(["cloud_order.status" => 2])
            ->asArray()
            ->all();

        $salesDateData = $this->salesDataAgainWeek();
        if (isset($query) && !empty($query)) {
            foreach ($query as $keys => $values) {
                $saleDate = intval(date('N', $values['pay_money_time'])) - 1;
                $salesDateData['salesWeek' . $saleDate] = $salesDateData['salesWeek' . $saleDate] + intval($values['total_price']);
            }
        }

        return $salesDateData;
    }

    /**
     * 后台 - 主页-  初始化日期数据
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/25
     * @param
     */
    public function autoLoadWeek($param)
    {
        if (isset($param['week']) && $param['week'] == 'week') {
            $dateStart = $param["start"] . " " . "00:00:00";
            $dateEnd = $param["end"] . " " . "00:00:00";
        } else {
            $dateStart = $param["start"] . " " . "00:00:00";
            $dateEnd = $param["end"] . " " . "23:59:59";
        }
        $this->theDateStart = strtotime($dateStart);
        $this->theDateEnd = strtotime($dateEnd);

        $this->venueId = (isset($param['venueId']) && !empty($param['venueId'])) ? $param['venueId'] : \backend\rbac\Config::accessVenues();
    }

    /**
     * 后台 - 主页-  统计一周之内的销售额(组装初始数据)
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/25
     * @param
     * @return array     //返回场馆初始人数
     */
    public function salesDataAgainWeek()
    {
        $dateData = [];
        for ($i = 0; $i <= 6; $i++) {
            $key = "salesWeek" . $i;
            $dateData[$key] = 0;
        }
        return $dateData;
    }

    /**
     * 销售主页 - 销售额统计 - 日
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/7/22
     * @param
     * @return array
     */
    public function TotalMoneyDay($param)
    {
        $this->autoLoadDay($param);
        $query = Order::find()
            ->select('cloud_order.total_price,cloud_order.pay_money_time')
            ->where(["between", "cloud_order.pay_money_time", $this->theDateStart, $this->theDateEnd])
            ->andWhere(['cloud_order.venue_id' => $this->venueId])
            ->andWhere(["cloud_order.status" => 2])
            ->asArray()
            ->all();

        $salesDateData = $this->salesDataAgainDay();
        if (isset($query) && !empty($query)) {
            foreach ($query as $keys => $values) {
                $saleDate = intval(date("H", $values['pay_money_time']));
                $salesDateData['salesTime' . $saleDate] = $salesDateData['salesTime' . $saleDate] + intval($values['total_price']);
            }
        }

        return $salesDateData;
    }

    /**
     * 后台 - 主页-  初始化日期数据
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/25
     * @param
     */
    public function autoLoadDay($param)
    {
        if (isset($param['day']) && $param['day'] == 'day') {
            $dateStart = $param["date"] . " " . "00:00:00";
            $dateEnd = $param["date"] . " " . "23:59:59";
        } else {
            $dateStart = $param["date"] . " " . "00:00:00";
            $dateEnd = $param["date"] . " " . "23:59:59";
        }
        $this->theDateStart = strtotime($dateStart);
        $this->theDateEnd = strtotime($dateEnd);

        $this->venueId = (isset($param['venueId']) && !empty($param['venueId'])) ? $param['venueId'] : \backend\rbac\Config::accessVenues();
    }

    /**
     * 后台 - 主页-  统计一周之内的销售额(组装初始数据)
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/25
     * @param
     * @return array     //返回场馆初始人数
     */
    public function salesDataAgainDay()
    {
        $dateData = [];
        for ($i = 0; $i <= 23; $i++) {
            $key = "salesTime" . $i;
            $dateData[$key] = 0;
        }
        return $dateData;
    }
}