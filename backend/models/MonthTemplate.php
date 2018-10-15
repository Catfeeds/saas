<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class MonthTemplate extends Model
{
    public $yearMonth;   //参数月
    public $calenderStart; //日历表 开始时间
    public $calenderEnd;   // 日历表结束时间
    public $venueId;   // 公司id

    public $insertDate;   //  录入月份
    public $templateDate; //  模板月份
    public $templateMonthStartDate;  // 月开始时间（不是时间戳）模板
    public $templateMonthEndDate;    // 月结束时间（不是时间戳）模板

    public $insertMonthStartDate;   // 录入的月开始时间
    public $insertMonthEndDate;     // 录入的月开始时间

       //  <--按月 模板课程搜索参数
    public $classroomId;       // 教室id
    public $organizationId;    // 场馆id
    public $courseId;          // 课程id
    public $startCourse;      // 课程开始时间
    public $endCourse;         // 课程结束时间
    public $coachId;           // 教练id
    public $searchDate;        // 搜索日期
    public $courseMonth;      // 当前月

    public $chinaYearMonth;   // 转义搜索月
    public $isHaveData;       // 检索是否有数据




    /**
     * 数据中心 - 团课排课 - 按照月遍历数据
     * @author Houkaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param  $param
     * @return  array
     */
    public function accordCalendar($param){
          $this->autoLoadParam($param);
          $this->autoLoad($param);
          $data   = $this->query();
          return $data;
    }

    /**
     * @deprecated 生成日历的各个边界值
     * @param  $year
     * @param $month
     * @return array
     */
     public function threshold($year,$month) {
        $firstDay = mktime(0, 0, 0, $month, 1, $year);
        $lastDay = strtotime('+1 month -1 day', $firstDay);
        //取得天数
        $days = date("t", $firstDay);
        //取得第一天是星期几
        $firstDayOfWeek = date("N", $firstDay);
        //获得最后一天是星期几
        $lastDayOfWeek = date('N', $lastDay);

        //上一个月最后一天
        $lastMonthDate = strtotime('-1 day', $firstDay);
        $lastMonthOfLastDay = date('d', $lastMonthDate);
        //下一个月第一天
        $nextMonthDate = strtotime('+1 day', $lastDay);
        $nextMonthOfFirstDay = strtotime('+1 day', $lastDay);

        //日历的第一个日期
        if($firstDayOfWeek == 7){
            $firstDate = $firstDay;
        }else{
            $firstDate = strtotime('-'. $firstDayOfWeek .' day', $firstDay);
        }
        //日历的最后一个日期
        if($lastDayOfWeek == 6)
            $lastDate = $lastDay;
        elseif($lastDayOfWeek == 7)
            $lastDate = strtotime('+6 day', $lastDay);
        else
            $lastDate = strtotime('+'.(6-$lastDayOfWeek).' day', $lastDay);

        return array(
            'days' => $days,
            'firstDayOfWeek' => $firstDayOfWeek,
            'lastDayOfWeek' => $lastDayOfWeek,
            'lastMonthOfLastDay' => $lastMonthOfLastDay,
            'firstDate' => $firstDate,
            'lastDate' => $lastDate,
            'year' => $year,
            'month' => $month
        );
    }
    /**
     * 数据中心 - 团课排课 - 按照月遍历数据(预加载数据)
     * @author Houkaixin <houkaixin@itsports.club>
     * @create 2017/12/01
     * @param  $param
     * @return  array
     */
    public function autoLoad($param){
         $this->yearMonth        = !empty($param["searchMonth"])?$param["searchMonth"]:date("Y-m",time());   //搜索月
      //   $this->venueId    = !empty($param["organizationId"])?$param["organizationId"]:null;          //搜索公司id
         $searchMonth             = explode("-",$this->yearMonth);
         $this->chinaYearMonth  = $searchMonth[0]."年".$searchMonth[1]."月";
         $this->gainCalendarStartEndDate();
    }
    /**
     * 数据中心 - 团课排课 - 按照日历表 统计每天课程数量
     * @author Houkaixin <houkaixin@itsports.club>
     * @create 2017/12/01
     * @return  array
     */
    public function query(){
        $publicSql    = $this->publicSql();
        if(!empty($this->startCourse)||!empty($this->endCourse)){
             $filterData = $this->filterTimeData($publicSql);
             $groupClass = GroupClass::find()
                                ->alias("groupClass")
                                ->andWhere(["groupClass.id"=>$filterData]);
        }else{
            $groupClass =$publicSql;
        }
        $groupClass = $this->searchSqlDeal($groupClass,"SOURCE");
        $groupClass->select(
            "groupClass.class_date,
           count(groupClass.id) as courseNum,"
        );
        $groupClass = $groupClass->groupBy("groupClass.class_date")
                                 ->asArray()
                                 ->all();
        $groupClass = $this->correctGroupClass($groupClass);
        return $groupClass;
    }


    public function publicSql(){
      $groupClass = GroupClass::find()
            ->alias("groupClass")
            ->where(["between","groupClass.class_date",$this->calenderStart,$this->calenderEnd])
            ->andWhere(["groupClass.venue_id"=>$this->organizationId]);
      return $groupClass;
    }
    /**
     * 数据中心 - 团课排课 - 公共sql处理
     * @author Houkaixin<houkaixin@itsports.club>
     * @param  $publicSql  // 公共sql
     * @create 2017/12/01
     * @return  boolean
     */
    public function filterTimeData($publicSql){
         $combineSql = $publicSql->select(
                                 new Expression("
                             groupClass.id,    
                             from_unixtime(groupClass.start,'%H:%i') as startTime,
                             from_unixtime(groupClass.end,'%H:%i') as endTime")
                                );
        $combineSql   = $this->gainConditionSql($combineSql);
        $endData      = $combineSql->asArray()->all();
        $groupClassId = array_column($endData,"id");
        return $groupClassId;
    }
    /**
     * 数据中心 - 团课排课 - 组装条件sql
     * @author Houkaixin<houkaixin@itsports.club>
     * @param  $combineSql  // 组合sql
     * @create 2017/12/01
     * @return  boolean
     */
    public function gainConditionSql($combineSql){
          if(!empty($this->startCourse)){
              $combineSql->andHaving([">=","startTime",$this->startCourse]);
          }
          if(!empty($this->endCourse)){
              $combineSql->andHaving(["<=","endTime",$this->endCourse]);
          }
          return $combineSql;
    }




    /**
     * 数据中心 - 团课排课 - 处理统计好的数据(按照日期统计每天的课程数量)
     * @author Houkaixin<houkaixin@itsports.club>
     * @param  $groupClass  // 被处理的数据
     * @create 2017/12/01
     * @return  boolean
     */
    public function correctGroupClass($groupClass){
          //处理日期
          $allClassDate = array_column($groupClass,"class_date");
          $differentDay = $this->calculateDiffDay();
          for ($i=0;$i<=$differentDay;$i++){
              $date = date("Y-m-d",strtotime($this->calenderStart."+".$i."day"));
              if(!in_array($date,$allClassDate)){
                  $groupClass[] = ["class_date"=>$date,"courseNum"=>0];
              }
          }
        ArrayHelper::multisort($groupClass,"class_date",SORT_ASC);
        //日期样式处理
        $groupClass = $this->dealDateStyle($groupClass);
        return $groupClass;
    }
    /**
     * 数据中心 - 团课排课按月 - 改变日期样式
     * @author Houkaixin<houkaixin@itsports.club>、
     * @param $groupClass  //组合课程复杂数据
     * @create 2017/12/01
     * @return  int    // 时间差天数
     */
    public function dealDateStyle($groupClass){
         if(empty($groupClass)){
              return [];
         }
         $isHaveData = false;
         foreach ($groupClass as $keys=>$values){
             // 处理日期样式
             $date             = explode("-",$values["class_date"]);
             $combineDateStyle = $date[0]."年".$date[1]."月".$date[2]."日";
             $groupClass[$keys]["classDate"] = $combineDateStyle;
             // 如果是搜索月 加入搜索标识(滞灰专用)
             $class_date  =  isset($values["class_date"])?$values["class_date"]:null;
             $class_month =  substr($class_date,0,7);
             if($this->yearMonth==$class_month){
                 $groupClass[$keys]["sign"] = true;
             }else{
                 $groupClass[$keys]["sign"] = false;
             }
             // 检索 指定条件月模板是否有数据
             if($this->yearMonth==$class_month){
                  if($isHaveData==true){      // 检索到有数据 跳过检索
                      continue;
                  }
                 if($values["courseNum"]!=0){
                     $isHaveData = true;
                 }
             }
         }
        $this->isHaveData = $isHaveData;  
        return $groupClass;
    }
    /**
     * 数据中心 - 团课排课 - 计算两个日期的时间差
     * @author Houkaixin<houkaixin@itsports.club>
     * @create 2017/12/01
     * @return  int    // 时间差天数
     */
    public function calculateDiffDay(){
         $diffStrTime =strtotime($this->calenderEnd) - strtotime($this->calenderStart);
         $dayS        =($diffStrTime/(24*60*60));
         return $dayS;
    }
    /**
     * 数据中心 - 团课排课 - 计算日历表 月末 月初时间
     * @author Houkaixin<houkaixin@itsports.club>
     * @create 2017/12/01
     * @return  boolean
     */
    public function gainCalendarStartEndDate(){
         $monthStartWeek = date("N",strtotime($this->yearMonth."-01"));                    //计算月初是周几
         $monthEndWeek   = date("w",strtotime($this->yearMonth."-01"."+1 month -1 day")); // 计算月末是周几
         $monthEndDate   = date("Y-m-d",strtotime($this->yearMonth."-01"."+1 month -1 day")); // 计算月末是周几
         $differentDay   =  6-$monthEndWeek;
         // 推算日历表的初始日期
         $this->calenderStart  = ($monthStartWeek!=7)?date("Y-m-d",strtotime($this->yearMonth."-01"."-".$monthStartWeek."day")):$this->yearMonth."-01";
         $this->calenderEnd    =  date("Y-m-d",strtotime($monthEndDate."+".$differentDay."day"));
         return true;
    }
    /**
     * 数据中心 - 按照日期 搜索所有课程
     * @author Houkaixin<houkaixin@itsports.club>
     * @param $params   // 传过来的 搜索参数
     * @create 2017/12/01
     * @return  boolean
     */
    public function searchGroupClass($params){
         $this->autoLoadParam($params);
         $groupClass = GroupClass::find()
                             ->alias("groupClass")
                             ->joinWith(["classroom classroom"],false)
                             ->joinWith(["employee employee"],false)
                             ->joinWith(["course course"],false)
                             ->select(
                             new Expression("
                             groupClass.course_id,
                             groupClass.coach_id,
                             groupClass.classroom_id,
                             classroom.name as classroom,
                             employee.name as coach,
                             course.name as course,
                             groupClass.start,
                             groupClass.end,
                             from_unixtime(groupClass.start,'%H:%i') as startTime,
                             from_unixtime(groupClass.end,'%H:%i') as endTime")
                             )
                             ->where(["groupClass.class_date"=>$this->searchDate])
                             ->andWhere(["groupClass.venue_id"=>$this->organizationId])
                             ->orderBy(["groupClass.start"=>SORT_ASC])
                             ->asArray();
        $groupClass = $this->searchSqlDeal($groupClass);
        return $groupClass;
    }
    /**
     * 数据中心 - 搜索数据的过滤
     * @author Houkaixin<houkaixin@itsports.club>
     * @param $groupClass   // 搜索数据之前的sql
     * @param $requestSource  // 请求来源
     * @create 2017/12/01
     * @return  boolean
     */
    public function searchSqlDeal($groupClass,$requestSource=""){
        $groupClass->andFilterWhere([
                                     "groupClass.classroom_id"=>$this->classroomId,
                                     "groupClass.course_id"=>$this->courseId,
                                     "groupClass.coach_id"=>$this->coachId,
                                    ]);     // 按照教练搜索
        if(!empty($this->endCourse)&&(empty($requestSource))){     // 课程结束时间
            $groupClass->andHaving(["<=","endTime",$this->endCourse]);
        }
        if(!empty($this->startCourse)&&(empty($requestSource))){   //课程开始时间
            $groupClass->andHaving([">=","startTime",$this->startCourse]);
        }
        if(!empty($requestSource)){
           return $groupClass;
        }
        return $groupClass->all();
    }
    /**
     * 数据中心 - 加载搜索参数
     * @author Houkaixin<houkaixin@itsports.club>
     * @param $param
     * @create 2017/12/01
     * @return  boolean
     */
    public function autoLoadParam($param){
          $this->organizationId = isset($param["organizationId"])&&!empty($param["organizationId"])?$param["organizationId"]:null;
          $this->classroomId    =  isset($param["classroomId"])&&!empty($param["classroomId"])?$param["classroomId"]:null;
          $this->courseId       = isset($param["courseId"])&&!empty($param["courseId"])?$param["courseId"]:null;
          $this->startCourse    = isset($param["startCourse"])&&!empty($param["startCourse"])?$param["startCourse"]:null;
          $this->endCourse      = isset($param["endCourse"])&&!empty($param["endCourse"])?$param["endCourse"]:null;
          $this->coachId        = isset($param["coachId"])&&!empty($param["coachId"])?$param["coachId"]:null;
          $this->searchDate     = isset($param["searchDate"])&&!empty($param["searchDate"])?$param["searchDate"]:null;
    }

    /**
     * 数据中心 - 获取当前月所有月份
     * @author Houkaixin<houkaixin@itsports.club>
     * @create 2017/12/01
     * @return  boolean
     */
    public function gainAllMonth(){
         // 获取当前月
         $this->courseMonth = date("Y-m",time());
         $arr  = [];
         $year = date("Y",time());
         for ($i=1;$i<=12;$i++){
             $data = [];
             $data["chinaDate"]   = $year."年".$i."月";
             if($i<=9){
                 $i = "0".$i;
             }
             $data["standard"]    = $year."-".$i;
             $arr[]  = $data;
         }
        return $arr;
    }
    /**
     * 数据中心 - 批量录入模板数据
     * @author Houkaixin<houkaixin@itsports.club>
     * @param $param
     * @create 2017/12/01
     * @return  boolean
     */
    public function InsertAllData($param){
         $this->authLoadParam($param);
         //批量录入数据（备注：不能跨店录入数据）
         $endData = $this->gainNeedInsertData();
         $this->insertData($endData);
         return true;
    }
    /**
     * 数据中心 - 批量录入模板数据
     * @author Houkaixin<houkaixin@itsports.club>
     * @param $endData    // 需要录入的最终数据
     * @create 2017/12/01
     * @return  boolean
     */
    public function insertData($endData){
        \Yii::$app->db->createCommand()
              ->batchInsert('cloud_group_class',
                           [
                               "start",
                                "end",
                                "class_date",
                                "created_at",
                                "status",
                                "course_id",
                                "coach_id",
                                "classroom_id",
                                "create_id",
                                "difficulty",
                                "desc",
                                 "pic",
                                 "class_limit_time",
                                 "cancel_limit_time",
                                 "least_people",
                                 "company_id",
                                 "venue_id",
                                 "seat_type_id",
                           ],$endData)->execute();
        return true;
    }
    /**
     * 数据中心 - 获取需要被录入的数据（同时修改数据满足合法数据）
     * @author Houkaixin<houkaixin@itsports.club>
     * @create 2017/12/01
     * @return  boolean
     */
    public function gainNeedInsertData(){
        $endData     = $this->gainTemplateData();
        $dealEndData = $this->dealEndData($endData);
        return $dealEndData;
    }
    /**
     * 数据中心 - 处理需要被录入的模板数据
     * @author Houkaixin<houkaixin@itsports.club>
     * @param $endData  // 被录入的数据
     * @create 2017/12/01
     * @return  boolean
     */
    public function dealEndData($endData){
        $data = [];
        if(empty($endData)){
           return [];
        };
        // 处理 上课时间  上课周期（把 模板日期 更换成 当前）
        foreach($endData as $keys=>$value){
            //1:上课日期
            $templateDate  = explode("-",$value["class_date"]);      // 模板日期
            $insertDate    = $this->insertDate."-".$templateDate[2]; // 需要录入的日期
            // 2:判断需要录入的日期是否有效
            $judgeTimeEffective = $this->judgeTimeEffective($insertDate);
            if($judgeTimeEffective==false){   // 无效时间跳过
                  continue;
            }
            //3:计算上课开始时间
            $classStart        = date("H:i:s",$value["start"]);      //上课开始时间
            $classEnd          = date("H:i:s",$value["end"]);        // 上课结束时间
            $insertClassStart  = strtotime($insertDate." ".$classStart);         // 录入的上课开始时间
            $insertClassEnd    = strtotime($insertDate." ".$classEnd);             // 录入的上课结束时间
            // 4: 矫正value值(针对日期)
            $endData[$keys]["class_date"] = $insertDate;
            $endData[$keys]["start"]       = $insertClassStart;
            $endData[$keys]["end"]         = $insertClassEnd;
            // 5:重新赋值
            $data[] = $endData[$keys];
        }
        return $data;
    }
    /**
     * 数据中心 - 团课排课（按照月） - 判断模板录入日期的有效性
     * @author Houkaixin<houkaixin@itsports.club>
     * @param  $date
     * @create 2017/12/01
     * @return  boolean
     */
    public function judgeTimeEffective($date){
       $date1 = date("Y-m-d",strtotime($date));
       if($date1==$date){
          return true;
       }
          return false;
    }

    /**
     * 数据中心 - 团课排课（按照月） - 获取指定场馆的 指定日期模板数据
     * @author Houkaixin<houkaixin@itsports.club>
     * @create 2017/12/01
     * @return  boolean
     */
    public function gainTemplateData(){
        $templateData = GroupClass::find()
                                ->where(["between","class_date",$this->templateMonthStartDate,$this->templateMonthEndDate])
                                ->andWhere(["venue_id"=>$this->venueId])
                                ->orderBy(["start"=>SORT_ASC])
                                ->select("
                                    start,
                                    end,
                                    class_date,
                                    created_at,
                                    status,
                                    course_id,
                                    coach_id,
                                    classroom_id,
                                    create_id,
                                    difficulty,
                                    desc,
                                    pic,
                                    class_limit_time,
                                    cancel_limit_time,
                                    least_people,
                                    company_id,
                                    venue_id,
                                    seat_type_id,
                                    ")
                                ->asArray()
                                ->all();
        return $templateData;
    }
    /**
     * 数据中心 - 参数预加载
     * @author Houkaixin<houkaixin@itsports.club>
     * @param $param  // 预加载参数
     * @create 2017/12/01
     * @return  boolean
     */
    public function authLoadParam($param){
         $this->insertDate   = !empty($param["insertDate"])?$param["insertDate"]:null;
         $this->templateDate = !empty($param["templateDate"])?$param["templateDate"]:null;
         // 模板开始时间 结束时间
         $this->templateMonthStartDate = $this->templateDate."-01";
         $this->templateMonthEndDate   =  date("Y-m-d",strtotime($this->templateMonthStartDate."+1 month -1 day"));
         // 录入的开始时间 结束时间
         $this->venueId       = !empty($param["venueId"])?$param["venueId"]:null;
    }











}