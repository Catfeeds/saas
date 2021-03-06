<?php

namespace backend\models;

use common\models\base\CoachClassRecord;
use common\models\base\Employee;
use common\models\base\MissAboutSet;
use common\models\Func;
use common\models\GroupClass;
use common\models\relations\AboutClassRelations;

class AboutClass extends \common\models\base\AboutClass
{
    use AboutClassRelations;
    public $keywords;
    public $venueId;                        //场馆id
    public $searchCourseId;
    public $notStart;
    public $attendClass;
    public $finish;
    public $startTime;
    public $endTime;
    public $sortType;
    public $sortName;
    public $sorts;
    public $searchDate;
    public $searchDateStart;
    public $searchDateEnd;
    public $dateStart; //私教上课搜索日期
    public $dateEnd; //私教上课搜索日期
    public $coachId;
    public $memberId;
    public $theDateStart;
    public $theDateEnd;
    public $classType;
    public $type;
    public $memberStatus;
    public $highest;
    public $lowest;
    public $memberType;
    public $isCourse;
    public $status;
    public $courseId;
    const KEYWORDS = 'keywords';
    const CLASS_DATE = 'class_date';
    const DATE_START = 'dateStart';
    const DATE_END = 'dateEnd';
    const VENUE_ID = 'venueId';
    const COACH_ID = 'coachId';
    const MEMBER_ID = 'memberId';
    const CLASS_TYPE = 'classType';
    const TYPE = 'type';
    const STATUS = 'status';
    const COURSE_ID = 'courseId';

    /**
     *对外服务 - 营运管理 -  近30天团课私课
     * @author Zhang dong xu <zhangdongxu@itsports.club>
     * @create 2018/6/22
     * @param $params
     * @return bool|string
     */
    public function getAboutClassSum($id)
    {
        $obj = [];
        $start = date("Y-m-d", strtotime("-1 month", time()));
        $end = date("Y-m-d", time());
        $data = AboutClass::find()
            ->where(['member_card_id' => $id, 'status' => 4, 'type' => 2])
            ->andWhere(['between', 'class_date', $start, $end])
            ->count();
        $list = AboutClass::find()
            ->where(['member_card_id' => $id, 'status' => 7, 'type' => 2])
            ->andWhere(['between', 'class_date', $start, $end])
            ->count();
        $var = AboutClass::find()
            ->where(['member_card_id' => $id, 'status' => 4, 'type' => 1])
            ->andWhere(['between', 'class_date', $start, $end])
            ->count();
        $obj['type1'] = (!empty($data)) ? $data : 0;
        $obj['type2'] = (!empty($list)) ? $list : 0;
        $obj['type3'] = (!empty($var)) ? $var : 0;
        return (!empty($obj)) ? $obj : 0;
    }


    /**
     * 会员卡管理 - 会员卡 - 获取搜索规格
     * @create 2017/4/5
     * @author lihuien<lihuien@itsports.club>
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
     * 会员卡管理 - 会员卡 - 获取排序条件
     * @create 2017/4/14
     * @author lihuien<lihuien@itsports.club>
     * @param $data
     * @return mixed
     */
    public static function loadSort($data)
    {
        $sorts = ['`gc`.start' => SORT_DESC];
        if (!isset($data['sortType'])) {
            return $sorts;
        }
        switch ($data['sortType']) {
            case 'class_date'  :
                $attr = '`gc`.class_date';
                break;
            case 'course_name'  :
                $attr = '`course`.name';
                break;
            case 'classroom_name':
                $attr = '`classroom`.name';
                break;
            case 'class_start':
                $attr = '`gc`.start';
                break;
            case 'class_end' :
                $attr = '`gc`.end';
                break;
            case 'class_aboutClass' :
                $attr = '`aboutClass`.id';
                break;
            case  'class_seatNum' :
                $attr = '`classroom`.total_seat';
                break;
            case  'employee_name' :
                $attr = '`employee`.name';
                break;
            case 'class_time':
                $attr = '(`gc`.start - `gc`.end)';
                break;
            default:
                $attr = NULL;
        }
        if ($attr) {
            $sorts = [$attr => self::convertSortValue($data['sortName'])];
        }
        return $sorts;
    }

    /**
     * 私课排期 - 私教上下课 - 获取排序条件
     * @create 2017/6/13
     * @author huanghua<huanghua@itsports.club>
     * @param $data
     * @return mixed
     */
    public static function loadSorts($data)
    {
        $sorts = [
            'id' => SORT_DESC
        ];
        if (!isset($data['sortType'])) {
            return $sorts;
        }
        switch ($data['sortType']) {
            case 'employee_name'          :
                $attr = '`ee`.name';
                break;
            case 'about_status'           :
                $attr = '`ac`.status';
                break;
            case 'class_date'           :
                $attr = '`ac`.class_date';
                break;
            case 'order_type'        :
                $attr = '`memberCourseOrder`.type';
                break;
            case 'memberDetails_name'   :
                $attr = '`memberDetails`.name';
                break;
            case 'about_start'          :
                $attr = '`ac`.start';
                break;
            default;
                return $sorts;
        }
        return $sorts = [$attr => self::convertSortValue($data['sortName'])];

    }

    /**
     * 后台 - 约课管理 - 约课搜索数据处理
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/13
     * @param $params
     * @return string
     */
    public function customLoad($params)
    {
        $this->venueId = $params['venueId'] ?: \backend\rbac\Config::accessVenues();
        $this->keywords = $params['keywords'] ?: NULL;
        $this->searchCourseId = $params['course_id'] ?: NULL;
        $this->notStart = $params['notStart'] ? strtotime(date('Y-m-d H:i:s', time())) : NULL;        //处理未开始课程
        $this->attendClass = $params['attendClass'] ? strtotime(date('Y-m-d H:i:s', time())) : NULL;                           //处理正在上课课程
        $this->finish = $params['finish'] ? strtotime(date('Y-m-d H:i:s', time())) : NULL;           //处理已结束课程
        $this->startTime = $params['startTime'] ?: NULL;
        $this->endTime = $params['endTime'] ?: NULL;
        $this->searchDate = $params['date'] ?: NULL;
        $this->sorts = self::loadSort($params);
        $this->setSearchDate();

        return true;
    }

    /**
     * 后台 - 约课管理 - 约课数据遍历
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/13
     * @param $params
     * @return string
     */
    public function getAboutClassData($params)
    {
        $this->customLoad($params);
        $query = \backend\models\GroupClass::find()
            ->alias('gc')
            ->joinWith(['employee employee'], false)
            ->joinWith(['classroom classroom'], false)
            ->joinWith(['course course'], false)
            ->orderBy($this->sorts)
            ->select('
                        gc.id,
                        gc.start,
                        gc.end,
                        gc.class_date,
                        gc.course_id,
                        gc.coach_id,
                        gc.classroom_id,
                        gc.seat_type_id,
                        employee.name as employeeName,
                        classroom.name as classroomName,
                        course.name as courseName,
                        ')
            ->asArray();
        $query = $this->setWhereSearch($query);
        $data = Func::getDataProvider($query, 8);
        return $data;
    }

    /**
     * @desc: 业务后台 - 团课约课 - 对数据进行处理
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/06/06
     * @param $data
     * @return mixed
     */
    public function getClassAndSeatNum($data)
    {
        if ($data) {
            foreach ($data as $key => $value) {
                //对会员的课程状态修改
                $this->memberClassStatus('', 'class', $value['id']);
                //1.获取座位数
                if ($value['seat_type_id'] && isset($value['seat_type_id'])) {
                    $seatAmount = Seat::find()->where(['seat_type_id' => $value['seat_type_id']])->andWhere(['>', 'CAST(seat_number as SIGNED)', 0])->count();
                } else {
                    //之前数据,根据classroom_id获取座次
                    $seatAmount = Seat::find()->where(['classroom_id' => $value['classroom_id']])->andWhere(['>', 'CAST(seat_number as SIGNED)', 0])->count();
                }
                if ($seatAmount) {
                    $data[$key]['isDelete'] = 1; //座次未删除
                } else {
                    $data[$key]['isDelete'] = 2; //座次已删除
                }
                $data[$key]['seatAmount'] = $seatAmount; //座次数
                //2.获取课程人数
                $peopleAmount = AboutClass::find()->where(['type' => 2, 'status' => [1, 3, 4], 'class_id' => $value['id']])->count();
                $data[$key]['peopleAmount'] = $peopleAmount;
            }
        }
        return $data;
    }

    /**
     * 后台 - 约课管理 - 处理搜索条件
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/13
     * @param $query
     * @return string
     */
    public function setWhereSearch($query)
    {
        if (!$this->venueId) {
            $this->venueId = 0;
        }
        $query->andFilterWhere([
            'or',
            ['like', 'course.name', $this->keywords],
            ['like', 'employee.name', $this->keywords]
        ]);
        $query->andFilterWhere([
            'and',
            ['classroom.venue_id' => $this->venueId],
            ['>=', 'gc.' . self::CLASS_DATE, $this->startTime],
            ['<=', 'gc.' . self::CLASS_DATE, $this->endTime],
        ]);
        $query->andFilterWhere([
            'and',
            ['course.id' => $this->searchCourseId],
            ['>=', 'gc.' . self::CLASS_DATE, $this->startTime],
            ['<=', 'gc.' . self::CLASS_DATE, $this->endTime],
        ]);

        $query->andFilterWhere([
            'or',
            ['>', 'gc.start', $this->notStart],
            ['<', 'gc.end', $this->finish],
            ['and', ['<=', 'gc.start', $this->attendClass], ['>=', 'gc.end', $this->attendClass]],
        ]);
        $query->andFilterWhere(['between', 'gc.' . self::CLASS_DATE, $this->searchDateStart, $this->searchDateEnd]);

        $query->andFilterWhere(['gc.venue_id' => $this->venueId]);

        return $query;
    }

    /**
     * 后台 - 约课管理 - 处理日期搜索条件
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/13
     */
    public function setSearchDate()
    {
        if ($this->searchDate) {
            $this->searchDateStart = Func::getGroupClassDate($this->searchDate, true);
            $this->searchDateEnd = Func::getGroupClassDate($this->searchDate, false);
        }
    }

    /**
     * 后台 - 约课管理 - 详情数据处理 -- 原约课管理（详情）
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/13
     * @param $id
     * @return string
     */
    public function getAboutClassDetail($id)
    {
        $data = \backend\models\GroupClass::find()->alias('gc')
            ->with(['aboutClass' => function ($query) {
                $query->where(['type' => 2]);
                $query->andWhere(['status' => [1, 3, 4]]);
            }])
            ->joinWith(['employee employee'])
            ->joinWith(['seatTypeS seatType'])
            ->joinWith(['course course'])
            ->where(['gc.id' => $id])
            ->asArray()->one();
        return $this->getClassRoomData($data);
    }

    /**
     * 后台 - 约课管理 - 详情数据处理 -- 新约课管理（详情）
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/13
     * @param $id
     * @param  $sign
     * @param  $venueId // 场馆id
     * @return string
     */
    public function getNewAboutClassDetail($id, $sign = "", $venueId)
    {
        if ($sign == 'group') {
            $this->memberClassStatus('', 'class', $id);
        }
        $this->memberStatus = empty($sign) ? [1] : [1, 3, 4, 5, 6, 7];
        define("memberStatus", $this->memberStatus);
//        // 根据课程id 实行自动上下课
//        $model  = new \backend\models\GroupClass();
//        $model->venue = $venueId;                 // 批量修改会员状态
//        $result =  $model->censusClassSituation($id,$venueId);
        $data = \backend\models\GroupClass::find()->alias('gc')
            ->joinWith(['theAboutClass AboutClass' => function ($q) {
                $q->joinWith(["memberCard mc"]);
                $q->joinWith(['seats seats'], false);
//                $q->where(['AboutClass.status'=>$this->memberStatus]);
                $q->select("AboutClass.*,seats.rows,seats.seat_type,seats.seat_number,mc.card_number as cardNumber");
            }])
            ->joinWith(["coachClass"])
            ->joinWith(['employee employee'])
            ->joinWith(["seat seat" => function ($query) {
                $query->select("count(seat.id) as seatNum,seat.seat_type_id");
            }])
            ->joinWith(['classroom'])
            ->where(['gc.id' => $id])
            ->joinWith(['course course'])
            ->select("gc.*,mc.card_number")
            ->asArray()->one();
        // 教练上课判断
        $classStatus = $this->classJudge($data);
        $data = $this->getAboutClassMemberData($data);
        $data["classStatus"] = $classStatus;
        return $data;
    }

    /**
     * 后台 - 团课管理 - 教练上课状态判断
     * @author houkaixin<houkaixin@itsports.club>
     * @create 2017/7/11
     * @param $data //排课课程汇总信息（关联出来的 教练上课记录表信息）
     * @return string
     */
    public function classJudge($data)
    {
        if (empty($data["coachClass"])) {
            // 未打卡状态判断 (当前时间大于下课时间，缺课状态)
            $classStatus = time() > $data["end"] ? 4 : 1;
            // 教练未准时上课，教练上课记录表录入记录
            if ($classStatus == 4) {
                $this->insertCoachClassRecord($data);
            }
        } else {
            $classStatus = $data["coachClass"]["status"];  // 教练上课状态
        }
        return $classStatus;
    }

    /**
     * 后台 - 团课排课 - 教练没有上课，录入教练缺课信息
     * @author houkaixin<houkaixin@itsports.club>
     * @create 2017/7/11
     * @param $data // 团课排课 课程综合信息
     * @return string
     */
    public function insertCoachClassRecord($data)
    {
        $model = new CoachClassRecord();
        $model->class_id = $data["id"];
        $model->coach_id = $data["coach_id"];
        $model->status = 4;
        if (!$model->save()) {
            return $model->errors;
        }
        return true;
    }

    /**
     * 后台 - 约课管理 - 详情获取会员约课详情
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/13
     * @param $data
     * @return string
     */
    public function getAboutClassMemberData($data)
    {
        $data['aboutClass'] = $this->getSeatAbout($data['theAboutClass']);
        return $data;
    }

    /**
     * 后台 - 约课管理 - 详情获取教室数据
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/13
     * @param $data
     * @return string
     */
    public function getClassRoomData($data)
    {
        $num = [1, 2, 3];
        $data['seats'] = Seat::find()->where(['seat_type_id' => $data['seat_type_id']])
            ->asArray()
            ->all();
        $data['aboutClass'] = $this->getSeatAbout($data['aboutClass']);
        $data = $this->getSeatType($num, $data);
        return $data;
    }

    /**
     * 后台 - 约课管理 - 详情作为身份数据处理
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/13
     * @param $num
     * @param $data
     * @return string
     */
    public function getSeatType($num, $data)
    {
        foreach ($num as $k => $v) {
            $data['seat_type'][$k] = Seat::find()->where(['seat_type_id' => $data['seat_type_id'], 'seat_type' => $v])->asArray()->count();
        }
        return $data;
    }

    /**
     * 后台 - 约课管理 - 详情约课记录数据
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/13
     * @param $data
     * @return string
     */
    public function getSeatAbout($data)
    {
        if ($data) {
            foreach ($data as &$v) {
                if (isset($v['employee_id'])) {
                    $v['member'] = Employee::find()->where(['id' => $v['employee_id']])->asArray()->one();
                } else {
                    $v['member'] = Member::find()
                        ->alias('member')
                        ->joinWith(['memberDetails md'], false)
                        ->where(['member.id' => $v['member_id']])
                        ->select('member.id,member.mobile,member.member_type,md.name,md.birth_date,md.sex')
                        ->asArray()->one();
//                    $v['member'] = Member::find()
//                        ->alias('member')
//                        ->select(
//                            'member.id,
//                            member.mobile,
//                            member.member_type,
//                            memberDetails.name,
//                            memberDetails.birth_date
//                            ')
//                        ->joinWith(['memberDetails memberDetails'])
//                        ->joinWith(['memberCard memberCard'])
//                        ->filterWhere(['memberCard.id'=>$v['member_card_id']])
//                        ->andWhere(['member.id'=>$v['member_id']])
//                        ->asArray()->one();
                }
            }
        }
        return $data;
    }

    /**
     * 后台 - 约课管理 - 获取课程的约课人数
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/13
     * @param $id int //课程id
     * @return string  //该课程所有预约信息
     */
    public static function getAboutClassOneById($id)
    {
        $aboutClass = AboutClass::find()->where(['class_id' => $id])->andWhere(['status' => 1])->asArray()->all();
        return $aboutClass;
    }

    /**
     * 后台 - 约课管理 - 获取课程订单的信息
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/12
     * @param $id int //课程id
     * @param $memberId int //会员id
     * @param $type int //课程类型
     * @return string  //该课程所有预约信息
     */
    public static function getAboutClassOneBy($id, $memberId, $type)
    {
        return AboutClass::find()->where(['member_id' => $memberId])->andWhere(['class_id' => $id])->andWhere(['type' => $type])->asArray()->all();
    }

    /**
     * 后台 - 约课管理 - 获取会员预约课程详情
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/13
     * @param $id int //课程id
     * @return string  //该课程所有预约信息
     */
    public function getAboutDetail($id)
    {
        $about = AboutClass::find()->alias('ac')
            ->select('ac.*,gc.course_id as course_id,gc.classroom_id as classroom_id')
            ->joinWith(['groupClass gc'])
            ->where(['ac.id' => $id])
            ->andWhere(['type' => (string)2])
            ->asArray()->one();
        return $this->getMemberAboutRecordDetail($about);
    }

    /**
     * 后台 - 约课管理 - 获取课种 教室 教练
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/13
     * @param $about array //课程id
     * @return string  //该课程所有预约信息
     */
    public function getMemberAboutRecordDetail($about)
    {
        if (isset($about) && !empty($about) && is_array($about)) {
            $course = new \backend\models\Course();
            $classroom = new ClassRoom();
            $about['course'] = $course->courseDetail($about['course_id']);
            $about['coach'] = \backend\models\Employee::getCoachOneById($about['coach_id']);
            $about['classroom'] = $classroom->getClassroomOneById($about['classroom_id']);
            $about['venue'] = \backend\models\Organization::getOrganizationById($about['classroom']['venue_id']);
            $about['seat'] = Seat::find()->where(['id' => $about['seat_id']])->asArray()->one();
            if ($about['member_card_id']) {
                $about['memberNumber'] = MemberCard::find()->select('card_number')->where(['id' => $about['member_card_id']])->asArray()->one();
            }
            $about['member'] = Member::find()
                ->alias('mm')
                ->select('mm.id,mm.username,memberDetail.name')
                ->joinWith(['memberDetails memberDetail'])
                ->where(['mm.id' => $about['member_id']])
                ->asArray()->one();

            $about['employee'] = Employee::find()
                ->alias('em')
                ->select('em.id,em.name')
                ->where(['em.id' => $about['employee_id']])
                ->asArray()->one();
        }
        return $about;
    }

    /**
     * 后台 - 约课管理 - 获取课种 教室 教练
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/13
     * @param $id //预约id
     * @return string  //该课程所有预约信息
     */
    public function updateAboutPrintStatus($id, $type = '')
    {
        if ($type == 'one') {
            $about = \common\models\base\AboutClass::findOne(['id' => $id]);
            $about->is_print_receipt = 1;
            $about->in_time = time();
            if ($about->save()) {
                return true;
            } else {
                return $about->errors;
            }
        } elseif ($type == 'day') {
            //查找当天的课程
            $date = date('Y-m-d');
            \common\models\AboutClass::updateAll(['is_print_receipt' => 1, 'in_time' => time()], ['and', ['member_card_id' => $id], ['type' => 2], ['status' => 1], ['class_date' => $date], ['>=', 'end', time()]]);
            return true;
        }


    }

    /**
     * 后台 - 约课管理 - 查询会员是否重复预约课程(同样的时间点重复预约)
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/5/22
     * @param $memberId //会员id
     * @param $classId //课程id
     * @param $start //开始时间
     * @param $end //接收时间
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getClassExist($memberId, $classId, $start, $end)
    {
        return \common\models\base\AboutClass::find()
            ->where(['member_id' => $memberId])
            ->andWhere(['class_id' => $classId])
            ->andWhere(["!=", 'status', 2])
            ->andWhere(["and", ['end' => $end], ["start" => $start]])
            ->asArray()->one();
    }

    /**
     * 后台 - 约课管理 - 查询会员是否重复预约课程
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/5/22
     * @param $memberId //会员id
     * @param $start //开始时间
     * @param $end //接收时间
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getClassData($memberId, $start, $end)
    {
        return \common\models\base\AboutClass::find()
            ->where(['member_id' => $memberId])
            ->andWhere(['start' => $start])
            ->andWhere(['end' => $end])
            ->andWhere(['status' => 1])
            ->asArray()->one();
    }

    /**
     * @私课管理 - 私教上下课 - 获取教练信息
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/2
     * @return array
     */
    public function getFingerprint($id)
    {
        $data = MemberDetails::find()->where(['member_id' => $id])
            ->select('fingerprint,member_id')
            ->asArray()->one();
        return isset($data['fingerprint']) ? $data['fingerprint'] : null;
    }

    /**
     *私课管理 - 私课排期 - 预约状态修改
     * @author Huang hua <huanghua@itsports.club>
     * @param $id
     * @param $type
     * @param $course
     * @create 2017/5/31
     * @return bool
     */
    public function getUpdateClass($id, $type, $course)
    {
        $aboutClass = \common\models\base\AboutClass::findOne(['id' => $id]);
        if ($type == null && $course == null && $aboutClass['status'] == 1) {
            $aboutClass->status = 3;
            $aboutClass->actual_start = time();
            if ($aboutClass->save() == true) {
                return true;
            } else {
                return $aboutClass->errors;
            }
        } elseif ($type != null && $course != null && $aboutClass['status'] == 3) {
            $memberOrderDetails = MemberCourseOrderDetails::findOne(['id' => $aboutClass['class_id']]);
            $memberOrder = MemberCourseOrder::findOne(['id' => $memberOrderDetails['course_order_id']]);
            if (!empty($memberOrderDetails) && !empty($memberOrder)) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    $aboutClass->status = 4;
                    $aboutClass->actual_end = time();
                    if ($aboutClass->save() != true) {
                        return $aboutClass->errors;
                    }

                    $memberOrder->overage_section = $memberOrder['overage_section'] - 1;
                    if ($memberOrder->save() != true) {
                        return $memberOrder->errors;
                    }

                    if (!empty($type) && $type == '2') {
                        $sendMessage = new AboutClass();
                        $data = Member::find()->where(['id' => $aboutClass['member_id']])->asArray()->one();
                        $sendMessage->sendMessage($data, $course);
                    }

                    if ($transaction->commit() === null) {
                        return true;
                    } else {
                        return false;
                    }
                } catch (\Exception $e) {
                    //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
                    $transaction->rollBack();
                    return $e->getMessage();  //获取抛出的错误
                }
            }
        }

//        if(!empty($aboutClass) && !empty($memberOrderDetails) && !empty($memberOrder)){
//            if($aboutClass['status'] == 1){
//                $aboutClass->status = 3;
//                if($aboutClass->save() == true){
//                    return true;
//                }else{
//                    return $aboutClass->errors;
//                }
//            }elseif($aboutClass['status'] == 3){
//                if($aboutClass['end'] > time()){
//                    return '课程还没有结束,请继续上课';
//                }
//                $aboutClass->status = 4;
//                if($aboutClass->save() == true){
//                    if(!empty($type) && $type == '2'){
//                        $sendMessage = new AboutClass();
//                        $data = Member::find()->where(['id'=>$aboutClass['member_id']])->asArray()->one();
//                        $sendMessage->sendMessage($data,$course);
//                    }
////                if($memberOrder['overage_section'] == 0){
////                    return '课程剩余节数已用完';
////                }
//                    $memberOrder->overage_section = $memberOrder['overage_section'] - 1;
//                    if($memberOrder->save() == true){
//                        return true;
//                    }else{
//                        return $memberOrder->errors;
//                    }
//                }else{
//                    return $aboutClass->errors;
//                }
//            }
//        }else{
//            return false;
//        }
    }

    /**
     *私课管理 - 私课排期 - 预约状态修改
     * @author Huang hua <huanghua@itsports.club>
     * @param $id
     * @create 2017/5/31
     * @return bool
     */
    public function getUpdateClassDate($id)
    {
        $aboutClass = \common\models\base\AboutClass::findOne(['id' => $id]);
        if ($aboutClass->status == 1) {
            $aboutClass->status = 2;
            $aboutClass->cancel_time = time();
            if ($aboutClass->save() == true) {
                return true;
            } else {
                return $aboutClass->errors;
            }
        } else {
            return false;
        }
    }

    /**
     * 后台私教管理 - 私教上课查询 - 多表查询
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/5/24
     * @param $params
     * @return \yii\db\ActiveQuery
     */
    public function search($params)
    {
        //把前一天上课中的课程状态改成5（未下课打卡）
        $yesterday = date("Y-m-d", strtotime("-1 day"));
        AboutClass::updateAll(['status' => 5], ['and', ['type' => '1'], ['status' => 3], ['<>', 'status', 2], ['<=', 'class_date', $yesterday]]);
        //把已过期的课程状态改成6（6：已过期）
        AboutClass::updateAll(['status' => 6], ['and', ['type' => '1'], ['status' => 1], ['<>', 'status', 2], ['<=', 'end', time()]]);
        $this->customLoads($params);
        $query = AboutClass::find()
            ->alias('ac')
            ->joinWith(['employee ee'], false)
            ->joinWith(['member mm' => function ($query) {
                $query->joinWith(['memberDetails memberDetails'], false);
            }], false)
            ->joinWith(['memberCourseOrderDetails mcod' => function ($query) {
                $query->joinWith(['memberCourseOrder memberCourseOrder'], false);
            }], false)
            ->joinWith(['memberCard mc'], false)
            ->select(
                "ac.id,
                 ac.member_id,
                 ac.coach_id,
                 ac.start,
                 ac.end,
                 ac.status,
                 ac.create_at,
                 ac.class_date,
                 ac.class_id,
                 ac.actual_start,
                 ac.actual_end,
                 mm.id as memberId,
                 mm.mobile,
                 ee.id as employeeId,
                 ee.name,
                 ee.pic,
                 memberDetails.name as memberName,
                 memberCourseOrder.type,
                 memberCourseOrder.course_type,
                 mc.card_number,
                ")
            ->where(['ac.type' => 1])
            ->andWhere(['<>', 'ac.status', 2])
            ->groupBy("ac.id")
            ->orderBy($this->sorts)
            ->asArray();
        $query = $this->getSearchWhere($query);
        $data = Func::getDataProvider($query, 8);

        return $data;
    }

    /**
     * 私课管理 - 私教上课 - 搜索数据处理数据
     * @create 2017/5/24
     * @author huanghua<huanghua@itsports.club>
     * @param $data
     * @return bool
     */
    public function customLoads($data)
    {
        $this->venueId = (isset($data[self::VENUE_ID]) && !empty($data[self::VENUE_ID])) ? $data[self::VENUE_ID] : \backend\rbac\Config::accessVenues();
        $this->dateStart = (isset($data[self::DATE_START]) && !empty($data[self::DATE_START])) ? $data[self::DATE_START] : NULL;
        $this->dateEnd = (isset($data[self::DATE_END]) && !empty($data[self::DATE_END])) ? $data[self::DATE_END] : NULL;
        $this->keywords = (isset($data['keywords']) && !empty($data['keywords'])) ? $data['keywords'] : null;
        $this->coachId = (isset($data[self::COACH_ID]) && !empty($data[self::COACH_ID])) ? $data[self::COACH_ID] : NULL;
        $this->memberId = (isset($data[self::MEMBER_ID]) && !empty($data[self::MEMBER_ID])) ? $data[self::MEMBER_ID] : NULL;
        $this->classType = (isset($data[self::CLASS_TYPE]) && !empty($data[self::CLASS_TYPE])) ? $data[self::CLASS_TYPE] : NULL;
        $this->type = (isset($data[self::TYPE]) && !empty($data[self::TYPE])) ? $data[self::TYPE] : NULL;
        $this->status = (isset($data[self::STATUS]) && !empty($data[self::STATUS])) ? $data[self::STATUS] : NULL;
        $this->sorts = self::loadSorts($data);

        return true;
    }

    /**
     * 私课管理 - 私教上课 - 增加搜索条件
     * @create 2017/5/24
     * @author huanghua<huanghua@itsports.club>
     * @param $query
     * @return mixed
     */
    public function getSearchWhere($query)
    {
        $query->andFilterWhere(['like', 'ee.name', $this->keywords]);
        $query->andFilterWhere([
            'and',
            ['>=', 'ac.class_date', $this->dateStart],
            ['<', 'ac.class_date', $this->dateEnd]
        ]);
        $query->andFilterWhere(['ee.venue_id' => $this->venueId]);
        $query->andFilterWhere(['ac.status' => $this->status]);

        return $query;
    }

    /**
     * 后台私教管理 - 会员信息查询 - 多表查询
     * @author Huang hua <huangpengju@itsports.club>
     * @create 2017/5/25
     * @param $id
     * @param $aboutId
     * @return \yii\db\ActiveQuery
     */
    public function getMemberData($id, $aboutId)
    {
        $model = AboutClass::find()
            ->alias('ac')
            ->joinWith(['member m' => function ($query) {
                $query->joinWith(['memberDetails memberDetails']);
            }])
            ->joinWith(['memberCourseOrderDetails mcod' => function ($query) {
                $query->joinWith(['memberCourseOrder memberCourseOrder']);
            }])
            ->select(
                "ac.id,
                 ac.member_id,
                 ac.start,
                 ac.end,
                 ac.status,
                 ac.create_at,
                 ac.class_id,
                 ac.class_date,
                 ac.actual_start,
                 ac.actual_end,
                 m.id as memberId,
                 m.mobile,")
            ->where(['m.id' => $id])
            ->andWhere(['ac.id' => $aboutId])
            ->asArray()->one();
        $order = new CommonChange();
        $model['memberCourseOrderDetails'] = $order->handleChangeClass($aboutId);
        return $model;

    }

    /**
     * 私课管理 - 私教上课 - 上课记录表删除
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/5/25
     * @param $id
     * @return bool
     */
    public function getClassDataDel($id)
    {
        $classRecord = AboutClass::findOne($id);
        $resultDelMem = $classRecord->delete();

        if ($resultDelMem) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 云运动 - 私课上下课 - 获取会员单条数据
     * @author Huanghua <Huanghua@itsports.club>
     * @create 2017/6/5
     * @param $data
     * @param $course
     * @return array
     */
    public function sendMessage($data, $course)
    {
        if (!isset($data['mobile']) && empty($data['mobile'])) {
            return ['status' => 'error', 'data' => '该会员没有手机号'];
        } else {
            $info = '会员下课成功';
            Func::sendClassInfo($data['mobile'], $course, $info);
        }
        return ['status' => 'success', 'data' => $info];
    }

    /**
     * 员工管理 - 员工详情 - 私教下的所有会员
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/6
     * @param $params
     * @return \yii\db\ActiveQuery
     */
    public function employeeMember($params)
    {
        $this->memberLoad($params);
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['member member' => function ($query) {
                $query->joinWith(['memberDetails memberDetails']);
                $query->joinWith(['memberCard memberCard']);
                $query->andFilterWhere([
                    'or',
                    ['like', 'memberDetails.name', $this->keywords],
                    ['like', 'memberCard.card_number', $this->keywords],
                    ['=', 'member.mobile', $this->keywords]
                ]);
            }])
            ->where(['mco.private_id' => $params['employeeId']])
            ->groupBy('member.id')
            ->orderBy('member.register_time DESC')
            ->asArray();
        $query = $this->setMemberWhereSearch($query, $params['employeeId']);
        $dataProvider = Func::getDataProvider($query, 10000);
        return $dataProvider;
    }

    /**
     * 员工管理 - 员工详情 - 私教会员搜索处理
     * @author 焦冰洋 <jiaopbingyang@itsports.club>
     * @create 2017/10/10
     * @param $params
     * @return bool
     */
    public function memberLoad($params)
    {
        $this->memberType = isset($params['memberType']) ? $params['memberType'] : null;
        $this->keywords = isset($params['keywords']) ? $params['keywords'] : null;
        $this->isCourse = isset($params['isCourse']) ? $params['isCourse'] : null;
        return true;
    }

    /**
     * 员工管理 - 员工详情 - 私教会员列表
     * @author 焦冰洋 <jiaopbingyang@itsports.club>
     * @create 2017/10/10
     * @param $query
     * @return bool
     */
    public function setMemberWhereSearch($query, $private_id)
    {
        $query->andFilterWhere(['member.member_type' => $this->memberType]);
        if ($this->isCourse != null) {
            $memberIds = $this->getPayMember($private_id);
            if (intval($this->isCourse) === 0) {
                //获取未购课会员
                $query->andWhere(['not in', 'mco.member_id', $memberIds]);
            } else {
                //获取已购课会员
                $query->andWhere(['mco.member_id' => $memberIds]);
            }
        }
        return $query;
    }

    /**
     * @desc: 业务后台 - 通过私教,销售获取 - 当前会员的消费情况
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/04/28
     * @return array
     */
    public function getPayMember($id)
    {
        $data = Member::find()
            ->alias('mm')
            ->joinWith(['memberCourseOrder mco'], false)
            ->where(
                ['and',
                    ['or', ['mco.course_type' => 1], ['mco.course_type' => null]],
                    ['>', 'mco.money_amount', 0],
                    ['mco.private_id' => $id]
                ])
            ->andWhere(['>', 'mco.money_amount', 0])
            ->select('mm.id,mco.id')
            ->groupBy('mm.id')
            ->asArray()->column();
        return $data;
    }

    /**
     * 销售主页 - 课程预约 - 各项预约数量
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/10
     * @param
     * @return array
     */
//    public function getCount($type)
//    {
//        if($type == 2){                              //上个月
//            $lastStart = date('Y-m-01',strtotime('-1 month'));
//            $lastEnd = date("Y-m-d", strtotime(-date('d').'day'));
//            $yogaCount = AboutClass::find()
//                ->alias('about')
//                ->joinWith(['groupClass gc' => function ($query) {
//                    $query->joinWith(['course course']);
//                }])
//                ->where(['like', 'course.category', '瑜伽'])
//                ->andWhere(["between","about.create_at",strtotime($lastStart),strtotime($lastEnd)])
//                ->count();
//            $danceCount = AboutClass::find()
//                ->alias('about')
//                ->joinWith(['groupClass gc' => function ($query) {
//                    $query->joinWith(['course course']);
//                }])
//                ->where(['like', 'course.category', '舞蹈'])
//                ->andWhere(["between","about.create_at",strtotime($lastStart),strtotime($lastEnd)])
//                ->count();
//            $bicycleCount = AboutClass::find()
//                ->alias('about')
//                ->joinWith(['groupClass gc' => function ($query) {
//                    $query->joinWith(['course course']);
//                }])
//                ->where(['like', 'course.category', '单车'])
//                ->andWhere(["between","about.create_at",strtotime($lastStart),strtotime($lastEnd)])
//                ->count();
//            $privateCount = AboutClass::find()
//                ->alias('about')
//                ->joinWith(['memberCourseOrderDetails mcod' => function ($query) {
//                    $query->joinWith(['course course']);
//                }])
//                ->where(['like', 'course.category', '私教'])
//                ->andWhere(["between","about.create_at",strtotime($lastStart),strtotime($lastEnd)])
//                ->count();
//            $bodyBuildingCount = AboutClass::find()
//                ->alias('about')
//                ->joinWith(['memberCourseOrderDetails mcod' => function ($query) {
//                    $query->joinWith(['course course']);
//                }])
//                ->where(['like', 'course.category', '健身'])
//                ->andWhere(["between","about.create_at",strtotime($lastStart),strtotime($lastEnd)])
//                ->count();
//        }else{                                     //本月
//            $beginDate = date('Y-m-01', strtotime(date("Y-m-d")));
//            $endDate   = date('Y-m-d', strtotime("$beginDate + 1 month - 1 day"));
//            $yogaCount = AboutClass::find()
//                ->alias('about')
//                ->joinWith(['groupClass gc' => function ($query) {
//                    $query->joinWith(['course course']);
//                }])
//                ->where(['like', 'course.category', '瑜伽'])
//                ->andWhere(["between","about.create_at",strtotime($beginDate),strtotime($endDate)])
//                ->count();
//            $danceCount = AboutClass::find()
//                ->alias('about')
//                ->joinWith(['groupClass gc' => function ($query) {
//                    $query->joinWith(['course course']);
//                }])
//                ->where(['like', 'course.category', '舞蹈'])
//                ->andWhere(["between","about.create_at",strtotime($beginDate),strtotime($endDate)])
//                ->count();
//            $bicycleCount = AboutClass::find()
//                ->alias('about')
//                ->joinWith(['groupClass gc' => function ($query) {
//                    $query->joinWith(['course course']);
//                }])
//                ->where(['like', 'course.category', '单车'])
//                ->andWhere(["between","about.create_at",strtotime($beginDate),strtotime($endDate)])
//                ->count();
//            $privateCount = AboutClass::find()
//                ->alias('about')
//                ->joinWith(['memberCourseOrderDetails mcod' => function ($query) {
//                    $query->joinWith(['course course']);
//                }])
//                ->where(['like', 'course.category', '私教'])
//                ->andWhere(["between","about.create_at",strtotime($beginDate),strtotime($endDate)])
//                ->count();
//            $bodyBuildingCount = AboutClass::find()
//                ->alias('about')
//                ->joinWith(['memberCourseOrderDetails mcod' => function ($query) {
//                    $query->joinWith(['course course']);
//                }])
//                ->where(['like', 'course.category', '健身'])
//                ->andWhere(["between","about.create_at",strtotime($beginDate),strtotime($endDate)])
//                ->count();
//        }
//        $count = ['yoga' => $yogaCount, 'dance' => $danceCount, 'bicycle' => $bicycleCount, 'private' => $privateCount, 'bodyBuilding' => $bodyBuildingCount];
//        return $count;
//    }

    /**
     * @私教统计 - 所有私教的上课量统计
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/11
     * @param  $params
     * @return array
     */
    public function privateAttendClass($params)
    {
        $this->customLoads($params);
        $class = AboutClass::find()
            ->alias('ac')
            ->joinWith(['employee ee' => function ($query) {
                $query->joinWith(['organizations org'], false);
            }], false)
            ->joinWith(['memberCourseOrderDetails mcod' => function ($query) {
                $query->joinWith(['memberCourseOrder mco' => function ($query) {
                    $query->joinWith(['chargeClass cc'], false);
                }]);
            }], false)
            ->where(['ac.type' => 1])
            ->andWhere(['ac.status' => 4])
            ->select(
                'ac.id,
                 ac.class_id,
                 ac.coach_id,
                 ee.name as coachName,
                 ee.venue_id,
                 ee.pic,
                 org.name as venueName,
                 count(ac.id) as num,
                 sum(mco.money_amount/mco.course_amount) as money,
                 sum(mco.overage_section) as overageNum,
                 cc.course_type
                 ')
            ->groupBy('ac.coach_id')
            ->asArray();
        $class = $this->searchWhere($class);
        return $class;
    }

    /**
     * @私教统计 - 所有私教的上课量统计分页
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/15
     * @param  $query
     * @return array
     */
    public function getSumData($query)
    {
        return Func::getDataProvider($query, 8);
    }

    /**
     * @私教统计 - 所有私教的上课量统计 - 总计
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/15
     * @param  $query
     * @return array
     */
    public function getSumDataMoney($query)
    {
        $class = $query->all();
        $class['totalNum'] = array_sum(array_column($class, 'num'));
        $class['totalMoney'] = array_sum(array_column($class, 'money'));
        $class['overageNum'] = array_sum(array_column($class, 'overageNum'));
        return $class;
    }

    /**
     * @私教统计 - 某一个私教的上课量统计
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/11
     * @param  $params
     * @return array
     */
    public function onePrivateAttendClass($params)
    {
        $this->customLoads($params);
        $class = AboutClass::find()
            ->alias('ac')
            ->joinWith(['employee ee'], false)
            ->joinWith(['member member' => function ($query) {
                $query->joinWith(['memberDetails md'], false);
            }], false)
            ->joinWith(['memberCourseOrderDetails mcod' => function ($query) {
                $query->joinWith(['memberCourseOrder mco' => function ($query) {
                    $query->joinWith(['chargeClass cc'], false);
                }], false);
            }], false)
            ->where(['ac.type' => 1, 'ac.coach_id' => $this->coachId])
            ->andWhere(['ac.status' => 4])
            ->select(
                'ac.id,
                 ac.class_id,
                 ac.member_id,ac.coach_id,
                 ee.pic,
                 member.mobile,
                 md.name,
                 mco.type,
                 mco.course_type,
                 count(ac.id) as num,
                 sum(mco.money_amount/mco.course_amount) as money,
                 sum(mco.overage_section) as overageNum,
                ')
            ->groupBy('ac.member_id')
            ->asArray();
        $class = $this->searchWhere($class);
        return $class;
    }

    /**
     * @私教统计 - 上课量统计 - 获取收费课程
     * @create 2017/8/30
     * @author zhumengke <zhumengke@itsports.club>
     * @return array
     */
    public function getNotDealS()
    {
        $data = MemberCourseOrder::find()
            ->where(['or', ['course_type' => 1], ['course_type' => null]])
            ->andWhere(['>', 'money_amount', 0])
            ->asArray()->all();
        return array_column($data, 'id');
    }

    /**
     * @私教统计 - 上课量统计 - 获取课程类型（PT、HS、生日课）
     * @create 2017/10/18
     * @author zhumengke <zhumengke@itsports.club>
     * @return array
     */
    public function getCourseTypeTwo()
    {
        $data = MemberCourseOrder::find()
            ->where(['course_type' => 2])
            ->orWhere(['course_type' => null, 'type' => 2])
            ->asArray()->all();
        return array_column($data, 'id');
    }

    public function getCourseTypeThree()
    {
        $data = MemberCourseOrder::find()
            ->where(['course_type' => 3])
            ->orWhere(['course_type' => null, 'type' => 3])
            ->asArray()->all();
        return array_column($data, 'id');
    }

    public function getCourseTypeFour()
    {
        $data = MemberCourseOrder::find()
            ->where(['course_type' => 4])
            ->orWhere(['course_type' => null, 'type' => 4])
            ->asArray()->all();
        return array_column($data, 'id');
    }

    /**
     * @私教统计 - 私教搜索字段
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/11
     * @param  $query
     * @return array
     */
    public function searchWhere($query)
    {
        $query->andFilterWhere(['like', 'ee.name', $this->keywords]);
        $query->andFilterWhere(['ee.venue_id' => $this->venueId]);
        $query->andFilterWhere(['ac.coach_id' => $this->coachId]);
        if (!empty($this->classType)) {
            $arrIdS = $this->getNotDealS();
            if ($this->classType == 2) {
                $query->andWhere(['NOT IN', 'mco.id', $arrIdS]);
            } else {
                $query->andWhere(['mco.id' => $arrIdS]);
            }
        }
        if (!empty($this->type)) {
            $two = $this->getCourseTypeTwo();
            $three = $this->getCourseTypeThree();
            $four = $this->getCourseTypeFour();
            if ($this->type == 2) {
                $query->andWhere(['mco.id' => $two]);          //HS 2
            } elseif ($this->type == 3) {
                $query->andWhere(['mco.id' => $three]);        //生日课 3
            } elseif ($this->type == 4) {
                $query->andWhere(['mco.id' => $four]);        //购课赠课 4
            } else {
                $query->andWhere(['and', ['NOT IN', 'mco.id', $two], ['NOT IN', 'mco.id', $three], ['NOT IN', 'mco.id', $four]]);     //PT 1
            }
        }
        $query->andFilterWhere(['and', ['>=', 'ac.class_date', $this->dateStart], ['<=', 'ac.class_date', $this->dateEnd]]);

        return $query;
    }

    /**
     * @私教统计 - 某一个会员的上课量统计
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/12
     * @param  $params
     * @return array
     */
    public function memberAttendClass($params)
    {
        $this->customLoads($params);
        $query = AboutClass::find()
            ->alias('ac')
            ->joinWith(['employee ee'], false)
            ->joinWith(['memberCard mc'], false)
            ->joinWith(['memberCourseOrderDetails mcod' => function ($query) {
                $query->joinWith(['memberCourseOrder mco'], false);
            }], false)
            ->where(['ac.type' => 1, 'ac.coach_id' => $this->coachId, 'ac.member_id' => $this->memberId])
            ->andWhere(['ac.status' => 4])
            ->select(
                'ac.id,
                 ac.member_card_id,
                 ac.class_id,
                 ac.class_date,
                 ac.start,ac.end,
                 mc.card_number,
                 mco.course_amount,
                 (mco.money_amount/mco.course_amount) as money_amount,
                 mco.type,
                 mco.course_type,
                 mcod.product_name,
                 mcod.course_name,
                 sum(mco.money_amount/mco.course_amount) as money,
                 sum(mco.overage_section) as overageNum,
                 ')
            ->groupBy('ac.id')
            ->asArray();
        $query = $this->searchWhere($query);
        return $query;
    }

    /**
     * @私教统计 - 上课量统计图(日、周、月)
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/14
     * @param $param
     * @return int
     */
    public function attendClass($param)
    {
        $this->autoLoad($param);
        $query = AboutClass::find()
            ->alias('ac')
            ->joinWith(['employee ee'])
            ->where(['and', ['>=', 'ac.start', $this->searchDateStart], ['<=', 'ac.start', $this->searchDateEnd]])
            ->andWhere(['ac.status' => 4])
            ->andWhere(['ac.type' => 1])
            ->select('ac.start,ac.coach_id,ac.status')
            ->asArray();
        $this->searchWhere($query);
        $query = $query->all();
        if ($param['timeType'] == 'd') {
            $data = $this->attendClassDay($query);
        } elseif ($param['timeType'] == 'w') {
            $data = $this->attendClassWeek($query);
        } else {
            $data = $this->attendClassMonth($query);
        }
        return $data;
    }

    /**
     * @私教统计 - 上课量统计图(日)
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/14
     * @param $query
     * @return int
     */
    public function attendClassDay($query)
    {
        $attendData = $this->attendClassDayTime();
        if (isset($query) && !empty($query)) {
            foreach ($query as $keys => $values) {
                $attendDate = intval(date("H", $values['start']));
                $attendData['attendDay' . $attendDate] = $attendData['attendDay' . $attendDate] + 1;
            }
        }
        return $attendData;
    }

    /**
     * @私教统计 - 上课量统计图(周)
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/14
     * @param $query
     * @return int
     */
    public function attendClassWeek($query)
    {
        $attendData = $this->attendClassWeekTime();
        if (isset($query) && !empty($query)) {
            foreach ($query as $keys => $values) {
                $attendDate = intval(date("w", $values['start']));
                $attendData['attendWeek' . $attendDate] = $attendData['attendWeek' . $attendDate] + 1;
            }
        }
        return $attendData;
    }

    /**
     * @私教统计 - 上课量统计图(月)
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/14
     * @param $query
     * @return int
     */
    public function attendClassMonth($query)
    {
        $attendData = $this->attendClassMonthTime();
        if (isset($query) && !empty($query)) {
            foreach ($query as $keys => $values) {
                $attendDate = intval(date("d", $values['start']));
                $attendData['attendMonth' . $attendDate] = $attendData['attendMonth' . $attendDate] + 1;
            }
        }
        return $attendData;
    }

    /**
     * @私教统计 - 初始化日期数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/14
     * @param $param
     */
    public function autoLoad($param)
    {
        if (isset($param['timeType']) && $param['timeType'] == 'd') {
            $this->searchDateStart = strtotime(Func::getGroupClassDate($param['timeType'], true));
            $this->searchDateEnd = strtotime(Func::getGroupClassDate($param['timeType'], false));
        } elseif (isset($param['timeType']) && $param['timeType'] == 'w') {
            $this->searchDateStart = strtotime(Func::getGroupClassDate($param['timeType'], true));
            $this->searchDateEnd = strtotime(Func::getGroupClassDate($param['timeType'], false));
        } elseif (isset($param['timeType']) && $param['timeType'] == 'm') {
            $this->searchDateStart = strtotime(Func::getGroupClassDate($param['timeType'], true));
            $this->searchDateEnd = strtotime(Func::getGroupClassDate($param['timeType'], false));
        }

        $this->venueId = (isset($param[self::VENUE_ID]) && !empty($param[self::VENUE_ID])) ? $param[self::VENUE_ID] : \backend\rbac\Config::accessVenues();
    }

    /**
     * @私教统计 - 统计一天之内的上课量(组装初始数据)
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/13
     * @return array
     */
    public function attendClassDayTime()
    {
        $data = [];
        for ($i = 0; $i <= 23; $i++) {
            $key = "attendDay" . $i;
            $data[$key] = 0;
        }
        return $data;
    }

    /**
     * @私教统计 - 统计一周之内的上课量(组装初始数据)
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/14
     * @return array
     */
    public function attendClassWeekTime()
    {
        $dateData = [];
        for ($i = 1; $i <= 7; $i++) {
            $key = "attendWeek" . $i;
            $dateData[$key] = 0;
        }
        return $dateData;
    }

    /**
     * @私教统计 - 统计一月之内的上课量(组装初始数据)
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/14
     * @return array
     */
    public function attendClassMonthTime()
    {
        $dateData = [];
        for ($i = 1; $i <= 31; $i++) {
            $key = "attendMonth" . $i;
            $dateData[$key] = 0;
        }
        return $dateData;
    }

    /**
     * 后台 - 财务管理 - 上课收入 - 教练上课记录
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/8/31
     * @param $params
     * @return string
     */
    public function getCoach($params)
    {
        $this->Coach($params);
        $query = AboutClass::find()
            ->alias("ac")
            ->joinWith(["memberCourseOrderDetails mod" => function ($query) {
                $query->joinWith(["memberCourseOrder mco" => function ($query) {
                }], false);
            }], false)
            ->joinWith(["member mm"], false)
            ->joinWith(["memberDetails mmd"], false)
            ->joinWith(['memberCard mmc'], false)
            ->where(['ac.coach_id' => $params['id']])
            ->andWhere(['ac.status' => 4])
            ->select("mco.type as classType,ac.*,mmc.card_number,mod.course_name,mco.course_amount,mco.money_amount,mmd.name,mm.mobile,sum(mco.money_amount/mco.course_amount) as token_money,count(ac.member_id) as token_num,sum(mco.overage_section) as overageNum,")
            ->groupBy("ac.member_id")
            ->orderBy($this->sorts)
            ->asArray();
        $query = $this->setCoachWhereSearch($query);
        return $query;
    }

    /**
     * @云运动 - 财务管理 - 单个教练上课收入 - 搜索处理
     * @author 焦冰洋 <jiaopbingyang@itsports.club>
     * @create 2017/8/31
     * @param $data
     * @return bool
     */
    public function Coach($data)
    {
        $this->startTime = (isset($data['startTime']) && !empty($data['startTime'])) ? (int)strtotime($data['startTime']) : null;
        $this->endTime = (isset($data['endTime']) && !empty($data['endTime'])) ? (int)strtotime($data['endTime']) : null;
        $this->highest = (isset($data['highest']) && !empty($data['highest'])) ? (int)($data['highest']) : null;
        $this->lowest = (isset($data['lowest']) && !empty($data['lowest'])) ? (int)($data['lowest']) : null;
        $this->type = (isset($data['type']) && !empty($data['type'])) ? (int)($data['type']) : null;
        $this->sorts = self::loadCoachSort($data);        //排序
        return true;
    }

    /**
     * 财务管理 - 上课详情 - 获取排序条件
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/9/2
     * @param $data
     * @return mixed
     */
    public static function loadCoachSort($data)
    {
        $sorts = ['id' => SORT_DESC];
        if (!isset($data['sortType'])) {
            return $sorts;
        }
        switch ($data['sortType']) {
            case 'token_num'  :
                $attr = 'count(ac.member_id)';
                break;
            case 'mobile'  :
                $attr = '`mm`.mobile';
                break;
            case 'token_money' :
                $attr = '((mco.money_amount/mco.course_amount)*count(ac.member_id))';
                break;
            default:
                $attr = NULL;
        };
        if ($attr) {
            $sorts = [$attr => self::convertSortValue($data['sortName'])];
        }
        return $sorts;
    }

    /**
     * 后台 - 财务管理 - 上课收入 - 教练上课记录
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/8/31
     * @param $query
     * @return string
     */
    public function getClassList($query)
    {
        $dataProvider = Func::getDataProvider($query, 8);
        return $dataProvider;
    }

    /**
     * 后台 - 财务管理 - 上课收入 - 用于统计
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/8/31
     * @param $query
     * @return string
     */
    public function getClassTotal($query)
    {
        return $query->all();
    }

    /**
     * @云运动 - 财务管理 - 单个私教上课列表 - 搜索处理
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/8/21
     * @param $query
     * @return string
     */
    public function setCoachWhereSearch($query)
    {
        if (!empty($this->type)) {
            $two = $this->getCourseTypeTwo();
            $three = $this->getCourseTypeThree();
            if ($this->type == 2) {
                $query->andWhere(['mco.id' => $two]);      //HS
            } elseif ($this->type == 3) {
                $query->andWhere(['mco.id' => $three]);    //生日课
            } else {
                $query->andWhere(['and', ['NOT IN', 'mco.id', $two], ['NOT IN', 'mco.id', $three]]);    //PT
            }
        }
        $query->andFilterWhere([
            'and',
            ['>=', 'ac.start', $this->startTime],
            ['<=', 'ac.start', $this->endTime]
        ]);
        return $query;
    }

    /**
     * 会员上课统计
     * @param $params ['start'=>'2017-01-01','end'=>'2018-01-01','venue_id'=>[75,76], 'class'=>1, 'status'=>[2,3]] class人次0 节次1
     * @return array
     */
    public static function classCount($params)
    {
        //团课
        $topCourses = Course::find()->select('id,name')->where(['pid' => 0, 'class_type' => 2])->all();
//            ->andWhere(['company_id'=>$params['companyId']])
        if (empty($topCourses)) return [];
        $data = [];
        foreach ($topCourses as $topCourse) {
            $query = AboutClass::find()->alias('ac')
                ->joinWith(['groupClass gc' => function ($q) {
                    $q->joinWith('course c');
                }])
                ->where(['ac.type' => 2]);
            if (isset($params['status'])) $query->andWhere(['ac.status' => $params['status']]);
            if (isset($params['venueId'])) $query->andWhere(['gc.venue_id' => $params['venueId']]);
            if (isset($params['start']) && isset($params['end'])) {
                $start = date('Y-m-d', $params['start']);
                $end = date('Y-m-d', $params['end']);
                $query->andWhere(['between', 'ac.class_date', $start, $end]);
            }
            $query->andWhere(['or', ['like', 'c.path', ",{$topCourse->id},"], ['like', 'c.path', ",{$topCourse->id}\""]]);
            if (isset($params['class']) && $params['class'] == 1) $query->groupBy('gc.id');//节次
            $data[] = ["$topCourse->name" => $query->count()];
        }

        //私课
        $query = AboutClass::find()->alias('ac')
            ->joinWith('employee e')
            ->where(['ac.type' => 1]);
        if (isset($params['status'])) $query->andWhere(['ac.status' => $params['status']]);
        if (isset($params['venueId'])) $query->andWhere(['e.venue_id' => $params['venueId']]);
        if (isset($params['start']) && isset($params['end'])) {
            $start = date('Y-m-d', $params['start']);
            $end = date('Y-m-d', $params['end']);
            $query->andWhere(['between', 'ac.class_date', $start, $end]);
        }
        $data[] = ['私课' => $query->count()];
        return $data;
    }

    /**
     * @营运统计 - 会员上课统计 - 查看详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/07
     * @return array
     */
    public function classCountDetails($params)
    {
        $this->loadData($params);
        $private = AboutClass::find()
            ->alias('ac')
            ->where(['ac.status' => $this->status])
            ->andWhere(['ac.type' => 1])
            ->andWhere(["and", [">=", "ac.start", $this->dateStart], ["<=", "ac.end", $this->dateEnd]])
            ->andFilterWhere(['or',
                ['mcod.product_name' => $this->keywords],
                ['md.name' => $this->keywords],
                ["mm.mobile" => $this->keywords]
            ])
            ->andFilterWhere(['mcod.course_id' => $this->courseId])
            ->andFilterWhere(['em.venue_id' => $this->venueId])
            ->joinWith(['member mm' => function ($query) {
                $query->joinWith(['memberDetails md'], false);
            }], false)
            ->joinWith(['memberCard mc'], false)
            ->joinWith(['employee em'], false)
            ->joinWith(['memberCourseOrderDetails mcod'], false)
            ->select('ac.member_id,ac.start,ac.create_at,mm.mobile,md.name as member_name,md.sex,mc.card_number,em.name as pName,mcod.product_name as class_name,mcod.course_name,mcod.course_id')
            ->asArray();
        $league = AboutClass::find()
            ->alias('ac')
            ->where(['ac.status' => $this->status])
            ->andWhere(['ac.type' => 2])
            ->andWhere(["and", [">=", "ac.start", $this->dateStart], ["<=", "ac.end", $this->dateEnd]])
            ->andFilterWhere(['or',
                ['course.name' => $this->keywords],
                ['md.name' => $this->keywords],
                ["mm.mobile" => $this->keywords]
            ])
            ->andFilterWhere(['gc.course_id' => $this->courseId])
            ->andFilterWhere(['gc.venue_id' => $this->venueId])
            ->joinWith(['member mm' => function ($query) {
                $query->joinWith(['memberDetails md'], false);
            }], false)
            ->joinWith(['memberCard mc'], false)
            ->joinWith(['employee em'], false)
            ->joinWith(['groupClass gc' => function ($query) {
                $query->joinWith(['course course'], false);
            }], false)
            ->select('ac.member_id,ac.start,ac.create_at,mm.mobile,md.name as member_name,md.sex,mc.card_number,em.name as pName,course.name as class_name,course.category as course_name,gc.course_id')
            ->asArray();
        $group = AboutClass::find()
            ->alias('ac')
            ->where(['ac.status' => $this->status])
            ->andWhere(['ac.type' => 3])
            ->andWhere(["and", [">=", "ac.start", $this->dateStart], ["<=", "ac.end", $this->dateEnd]])
            ->andFilterWhere(['or',
                ['mcod.product_name' => $this->keywords],
                ['md.name' => $this->keywords],
                ["mm.mobile" => $this->keywords]
            ])
            ->andFilterWhere(['mcod.course_id' => $this->courseId])
            ->andFilterWhere(['cgc.venue_id' => $this->venueId])
            ->joinWith(['member mm' => function ($query) {
                $query->joinWith(['memberDetails md'], false);
            }], false)
            ->joinWith(['memberCard mc'], false)
            ->joinWith(['employee em'], false)
            ->joinWith(['chargeGroupClass cgc' => function ($query) {
                $query->joinWith(['memberCourseOrder mco' => function ($query) {
                    $query->joinWith(['memberCourseOrderDetails mcod'], false);
                }], false);
            }], false)
            ->select('ac.member_id,ac.start,ac.create_at,mm.mobile,md.name as member_name,md.sex,mc.card_number,em.name as pName,mcod.product_name as class_name,mcod.course_name,mcod.course_id')
            ->asArray();
        $query = array_merge($private->all(), $league->all(), $group->all());
//        $data  = Func::getDataProvider($query,8);
        return $query;
    }

    /**
     * @营运统计 - 会员上课统计 - 查看详情 - 执行搜索数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/07
     * @return array
     */
    public function loadData($data)
    {
        if (isset($data["startTime"]) && isset($data["endTime"])) {
            $this->dateStart = strtotime($data["startTime"]);
            $this->dateEnd = strtotime($data["endTime"]);
        } else {
            $this->dateStart = strtotime(Func::getTokenClassDate($data['date'], true));
            $this->dateEnd = strtotime(Func::getTokenClassDate($data['date'], false));
        }
        if (isset($data['status']) && $data['status'] === '1') {
            $this->status = 1;
        } else {
            $this->status = [3, 4];
        }
        //获取权限里的场馆
        $cardObj = new \backend\models\CardCategory();
        $venueIds = $cardObj->getVenueIdByRole();
        $this->venueId = (isset($data[self::VENUE_ID]) && !empty($data[self::VENUE_ID])) ? $data[self::VENUE_ID] : $venueIds;
        $this->courseId = (isset($data[self::COURSE_ID]) && !empty($data[self::COURSE_ID])) ? $data[self::COURSE_ID] : null;
        $this->keywords = (isset($data[self::KEYWORDS]) && !empty($data[self::KEYWORDS])) ? $data[self::KEYWORDS] : null;
    }

    /**
     * @desc: 获取私教上课课程记录
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/06
     * @param $coachId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCoachClass($coachId, $newParams)
    {
        $startTime = isset($newParams['startTime']) ? (int)strtotime($newParams['startTime']) : null;
        $endTime = isset($newParams['endTime']) ? (int)strtotime($newParams['endTime']) : null;
        $query = AboutClass::find()
            ->alias('about')
            ->where(['about.coach_id' => $coachId])
            ->select('count(about.class_id) num, about.class_id,about.member_card_id,mod.course_name,mmd.name as username,mc.card_number,(mco.money_amount/mco.course_amount) as singlePrice,mco.type,employee.name as coachName')
            ->andWhere(['about.status' => 4])
            ->groupBy('mod.id')
            ->joinWith(["memberCourseOrderDetails mod" => function ($query) {
                $query->joinWith(["memberCourseOrder mco" => function ($query) {
                }], false);
            }], false)
            ->joinWith(["member mm"], false)
            ->joinWith(["memberDetails mmd"], false)
            ->joinWith(['memberCard mc'], false)
            ->joinWith(['employee employee'], false)
            ->asArray();
        $query->andFilterWhere([
            'and',
            ['>=', 'about.start', $startTime],
            ['<=', 'about.start', $endTime]
        ]);
        if (isset($newParams['type'])) {
            $two = $this->getCourseTypeTwo();
            $three = $this->getCourseTypeThree();
            if ($newParams['type'] == 2) {
                $query->andWhere(['mco.id' => $two]);      //HS
            } elseif ($newParams['type'] == 3) {
                $query->andWhere(['mco.id' => $three]);    //生日课
            } elseif ($newParams['type'] == 1) {
                $query->andWhere(['and', ['NOT IN', 'mco.id', $two], ['NOT IN', 'mco.id', $three]]);    //PT
            }
        }

        return $query->all();
    }

    /**
     * 约课管理 - 批量修改约课状态
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/03/30
     * @return bool|string
     */
    public function updateCancelStatus()
    {
        AboutClass::updateAll(['status' => 2], ['and', ['is not', 'cancel_time', null], ['<>', 'status', 2]]);
        return true;
    }

    //会员上下课状态修改(通用)

    /**
     * @desc: 业务后台 - 团课状态修改 - 团课上下课,已爽约判断
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/04/19
     * @param $ids
     * @param $type
     * @param $typeId
     */
    public function memberClassStatus($ids, $type, $typeId)
    {
        if ($type == 'class') {
            //直接对整节课程处理,获取整节课程的课程信息
            $classInfo = GroupClass::findOne($typeId);
            //获取当前课程场馆上课设置信息
            if (empty($classInfo)) {
                return;
            }
            //获取当前课程未下课的会员
            $ids = AboutClass::find()->where(['and', ['status' => [1, 3]], ['class_id' => $typeId], ['type' => 2]])->asArray()->all();
            //获取当前场馆的配置信息,打印小票配置
            $printConf = Config::find()->select('value')
                ->where([
                    'and',
                    ['venue_id' => $classInfo->venue_id],
                    ['company_id' => $classInfo->company_id],
                    ['type' => 'league'],
                    ['key' => 'printSettings']
                ])->one();
            //获取当前场馆爽约设置信息
            $missAboutSet = MissAboutSet::find()->where(["venue_id" => $classInfo->venue_id])->one();
        }
        //通过课程id查找
        if (isset($ids) && !empty($ids)) {
            foreach ($ids as $k => $v) {
                //会员单个处理
                if ($type == 'member') {
                    //获取当前课程的信息
                    $classInfo = GroupClass::findOne($v['class_id']);
                    if (empty($classInfo)) {
                        continue;
                    }
                    //获取当前场馆的配置信息,打印小票配置
                    $printConf = Config::find()->select('value')
                        ->where([
                            'and',
                            ['venue_id' => $classInfo->venue_id],
                            ['company_id' => $classInfo->company_id],
                            ['type' => 'league'],
                            ['key' => 'printSettings']
                        ])->one();
                    //获取当前场馆爽约设置信息
                    $missAboutSet = MissAboutSet::find()->where(["venue_id" => $classInfo->venue_id])->one();
                }
                $current = time();
                //上课中
                if (($classInfo->start) <= $current && $current <= ($classInfo->end)) {
                    //上课中
                    AboutClass::updateAll(['status' => 3], ['and', ['status' => 1], ['or', ['is_print_receipt' => 1], ['<>', 'in_time', 0]], ['id' => $v['id']]]);
                    if (empty($printConf)) {
                        //备注:无配置,开课后不能打印小票,直接爽约
                        //已爽约
                        AboutClass::updateAll(['status' => 6], ['and', ['status' => 1], ['and', ['is_print_receipt' => 2], ['in_time' => 0]], ['id' => $v['id']]]);
                        //对会员卡的爽约次数进行处理&&冻结
                        $this->totalClassMiss($v['member_card_id'], $missAboutSet, $v['end']);
                    } else {
                        $classTime = (int)($classInfo->start) + (int)($printConf->value) * 60;
                        if ($classTime < $current) {
                            //已爽约
                            AboutClass::updateAll(['status' => 6], ['and', ['status' => 1], ['and', ['is_print_receipt' => 2], ['in_time' => 0]], ['id' => $v['id']]]);
                            //冻结处理&添加爽约次数
                            $this->totalClassMiss($v['member_card_id'], $missAboutSet, $v['end']);
                        }
                    }
                }
                //已下课
                if (($classInfo->end) < $current) {
                    if ($v['is_print_receipt'] == 1 || $v['in_time'] != 0) {
                        //已下课
                        AboutClass::updateAll(['status' => 4], ['and', ['status' => [1, 3]], ['or', ['is_print_receipt' => 1], ['<>', 'in_time', 0]], ['id' => $v['id']]]);
                        //冻结处理&添加爽约次数
                        //$this->totalClassMiss($v['member_card_id'],$missAboutSet,$v['end']);
                    } else {
                        //已爽约
                        AboutClass::updateAll(['status' => 6], ['and', ['status' => 1], ['and', ['is_print_receipt' => 2], ['in_time' => 0]], ['id' => $v['id']]]);
                        //冻结处理&添加爽约次数
                        $this->totalClassMiss($v['member_card_id'], $missAboutSet, $v['end']);
                    }
                }
            }
        }
    }

    /**
     * @desc: 业务后台 - 团课状态修改 - 冻结&添加爽约次数
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/04/19
     * @param $info
     * @param $miss
     */
    public function totalClassMiss($cardId, $miss, $end)
    {
        //获取当前月第一天的时间戳
        $beginThisMonth = mktime(0, 0, 0, date('m'), 1, date('Y'));
        //获取当前会员卡的最后一次冻结时间
        $lastFrozen = \common\models\MemberCard::findOne($cardId);
        if (empty($lastFrozen)) {
            return;
        }
        if ($lastFrozen->status == 3 && $lastFrozen->recent_freeze_reason == 1) {
            return;
        }
        if (empty($lastFrozen->last_freeze_time)) {
            //搜索当前月的爽约次数
            $missCount = $this->countClassMiss($beginThisMonth, $cardId);
        } else {
            //获取上次冻结月份
            $last_date = date('Y-m', $lastFrozen->last_freeze_time);
            $current_date = date('Y-m', time());
            if ($last_date === $current_date) {
                //当前月冻结过,爽约次数从冻结时间之后开始
                $missCount = $this->countClassMiss($lastFrozen->last_freeze_time, $cardId);
            } else {
                $missCount = $this->countClassMiss($beginThisMonth, $cardId);
            }
        }
        if (empty($miss)) {
            //修改爽约次数
            MemberCard::updateAll(["absentTimes" => $missCount], ["id" => $cardId]);
        } else {
            if ($missCount >= $miss->miss_about_times) {
                MemberCard::updateAll(["status" => 3, "last_freeze_time" => $end, "recent_freeze_reason" => 1, "absentTimes" => $missCount], ["id" => $cardId]);
            } else {
                //修改爽约次数
                MemberCard::updateAll(["absentTimes" => $missCount], ["id" => $cardId]);
            }
        }

    }

    /**
     * @desc: 业务后台 - 团课状态修改 - 获取团课爽约次数
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/04/19
     * @param $time
     * @param $id
     * @return int|string
     */
    private function countClassMiss($time, $id)
    {
        $missCount = AboutClass::find()->where(['and', ['>', 'start', $time], ['member_card_id' => $id], ['status' => 6], ['type' => 2]])->count();
        return $missCount;
    }

    /**
     * @desc:员工约课列表
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/5/30
     * @time: 16:16
     * @param $employeeId
     * @return \yii\data\ActiveDataProvider
     */
    public function employeeAboutClass($employeeId)
    {
        $data = AboutClass::find()
            ->alias('ac')
            ->where(['ac.employee_id' => $employeeId])
            ->joinWith(['groupClass gc' => function ($q) {
                $q->joinWith(['course course']);
                $q->joinWith(['organization']);
            }])
            ->joinWith(['seat  seat'])
            ->orderBy('ac.create_at DESC')
            ->asArray()
            ->all();

        foreach ($data as $key => $value) {
            $data[$key]['item'] = $this->getAboutDetail($value['id']);
        }

        return $data;
    }
}