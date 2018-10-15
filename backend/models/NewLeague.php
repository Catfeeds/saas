<?php
namespace backend\models;
use common\models\AboutClass;
use common\models\relations\GroupClassRelations;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class NewLeague extends \common\models\GroupClass
{
    use GroupClassRelations;
    public $weekStart;         //周时间开始（周一）
    public $weekEnd;           // 周时间结束（周日）
    public $organizationId;   //场馆id

    public $tuesday;        //每一周的周三

    public $classroomId;   // 教室id
    public $courseId;      // 课程名称
    public $startCourse;   // 课程开始时间
    public $endCourse;     // 课程结束时间
    public $coachId;       //教练

    /**
     * 后台 - 团课数据遍历 - 获得团课数据
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/15
     * @param    $data  //  包括周开始时间  周结束时间
     * @param    $check  //标志数据 如果存在，只进行sql查询，否则进行数据整理
     * @return boolean
     */
    public  function getClassData($data,$check){
        $this->autoLoad($data);
        $query = GroupClass::find()
            ->alias("groupClass")
            ->joinWith(["course"],false)  //课种表
            ->joinWith(["employee"],false)
            ->joinWith(["classroom"],false)
            ->select(" 
                     groupClass.id,
                     groupClass.coach_id,
                     groupClass.course_id,
                     groupClass.classroom_id,
                     groupClass.start,
                     groupClass.end,
                     groupClass.class_date,
                     groupClass.seat_type_id,
                     groupClass.venue_id as groupClassVenueId,   
                     cloud_employee.name as coachName,
                     cloud_classroom.name as classRoomName,
                     cloud_course.name as courseName,
                     cloud_classroom.venue_id as venueId,"
            )->orderBy(["groupClass.class_date"=>SORT_ASC,"groupClass.start" => SORT_ASC])
            ->where(["between","groupClass.class_date",$this->weekStart,$this->weekEnd])
            ->andWhere(["groupClass.venue_id"=>$this->organizationId])
            ->asArray();
          $query =  $this->searchWhere($query);
          if(isset($check)&&!empty($check)){
            return $query;
          }
          $model        = new GroupClass();
          $arrangeData  = $model->getArrange($query,$this->weekStart,'group');
          $arrangeData  = $this->getDataStatus($arrangeData);
          $arrangeData  = $this->endFilterData($arrangeData);
          return  $arrangeData;
    }
    /**
     * 后台 - 新团课管理 - 根据日期过滤周数据
     * @create 2017/7/5
     * @param  $arrangeData    // 传输过来的时间数据
     * @return boolean
     */
    public function endFilterData($arrangeData){
          if(empty($this->startCourse)||empty($this->endCourse)){
                return  $arrangeData;
          }
          foreach($arrangeData as $key=>$values){
             if(count($values[0])!=2){
                 foreach($values as $keys=>$value){
                     $courseStart = date("H:i",$value["start"]);
                     $courseEnd   = date("H:i",$value["end"]);
                     $classDate   = $value["class_date"];
                     $data        = null;
                     // 周数据过滤
                     if($courseStart<$this->startCourse||$courseEnd>$this->endCourse){
                         array_splice($arrangeData[$key],$keys);
                     }
                     // 如果指定周 天数是0 加入标志数据
                     if(count($arrangeData[$key])==0){
                         $arrangeData[$key][0]["class_date"] = $classDate;
                         $arrangeData[$key][0]["data"] = null;
                     }
                 }
             }
          }
          return $arrangeData;
    }

    /**
     * 后台 - 新团课管理 - 根据条件增加帅选接口
     * @create 2017/7/5
     * @param  $query    // 搜索参数
     * @return boolean
     */
    public function searchWhere($query){
        // 根据教室查询
        if(!empty($this->classroomId)){
            $query->andFilterWhere(["cloud_classroom.id"=>$this->classroomId]);
        }
        // 根据课程名称查询
        if(!empty($this->courseId)){
            $query->andFilterWhere(["groupClass.course_id"=>$this->courseId]);
        }
        // 根据教练查询
        if(!empty($this->coachId)){
            $query->andFilterWhere(["groupClass.coach_id"=>$this->coachId]);
        }
            return $query->all();
    }



    /**
     * 后台 - 判断获取团课数据是否有数据
     * @create 2017/5/23
     * @param  $arrangeData //array
     * @return boolean
     */
    public function getDataStatus($arrangeData){
          foreach($arrangeData as $keys=>$values){
                foreach($values as $key=>$value){
                   if(count($value)>1){
                       $arrangeData[$keys][$key]["data"] = true;
                   }else{
                       $arrangeData[$keys][$key]["data"] = false;
                   }
                }
          }
         return $arrangeData;
    }

    /**
     * 后台 - 团课条件加载判断- 判断 时间 是否前台发送过来的数据
     * @create 2017/5/22
     * @param  $data //array   包括 周开始时间 周结束时间 场馆id
     * @return boolean
     */
    public function autoLoad($data){
        $this->weekStart        = isset($data["weekStart"])&&!empty($data["weekStart"])?$data["weekStart"]:null;
        $this->weekEnd          = isset($data["weekEnd"])&&!empty($data["weekEnd"])?$data["weekEnd"]:null;
        $this->organizationId  = isset($data["organizationId"])&&!empty($data["organizationId"])?$data["organizationId"]:null;
        $this->classroomId      = isset($data["classroomId"])&&!empty($data["classroomId"])?$data["classroomId"]:null;
        $this->courseId         = isset($data["courseId"])&&!empty($data["courseId"])?$data["courseId"]:null;
        $this->startCourse      = isset($data["startCourse"])&&!empty($data["startCourse"])?$data["startCourse"]:null;
        $this->endCourse        = isset($data["endCourse"])&&!empty($data["endCourse"])?$data["endCourse"]:null;
        $this->coachId          = isset($data["coachId"])&&!empty($data["coachId"])?$data["coachId"]:null;
        //时间数据判断
        if(empty($this->weekStart)||empty($this->weekEnd)){
            $this->getTimeWeek();
        }

    }
    /**
     * 后台 - 团课课程表数据遍历 - 获取当前周的  开始日期和结束日期 （周一 到 周日）
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param
     * @return boolean
     */
    public  function getTimeWeek(){
        $nowDate = date("Y-m-d");
        $first=1;
        $w=date('w',strtotime($nowDate));
        $week_start=date('Y-m-d',strtotime("$nowDate -".($w ? $w - $first : 6).' days'));
        $week_end=date('Y-m-d',strtotime("$week_start +6 days"));
        $this->weekStart = $week_start;
        $this->weekEnd   = $week_end;
    }
    /**
     * 后台 - 新团课数据遍历（默认当前周的上一周）
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param
     * @return boolean
     */
    public function initData($data){
        $this->getTimeWeek();
        if(!isset($data["weekStart"])||!isset($data["weekEnd"])||empty($data["weekStart"])||empty($data["weekEnd"])){
        $weekStart = date('Y-m-d',strtotime($this->weekStart . '-7 day'));  //当前周的  上周一
        $weekEnd   = date('Y-m-d',strtotime($this->weekEnd . '-7 day'));  //当前周的  上周日
        $data       = ["weekStart"=>$weekStart,"weekEnd"=>$weekEnd,"organizationId"=>$data["organizationId"]];
        }
        $tuesday = date('Y-m-d',strtotime($data["weekStart"] . '+1 day'));
        $this->tuesday  =  $tuesday;
        $data = $this->getClassData($data,"");
        return $data;
    }
    /**
     * 数据中心 - 获取指定 模板数据并将获取到的模板数据 赋值给指定周
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param  $data array //weekStart weekEnd organizationId
     * @return boolean
     */
    public function adjustData($data)
    {
        $ResultData = $this->getClassData($data,"exist");
       // 1.数据整理(整理数据)
        if(!empty($ResultData)){
            $this->organizationId = $data['organizationId'];
            $data   = $this->arrangeData($ResultData,$data);
            $result = $this->insertData($data);
        }else{
            $result = "暂无数据";
        }
        // 2.将整理的数据插入数据库
        return $result;
    }
    /**
     * 数据中心 - 新团课管理 - 将老模板数据插入指定周模板
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param  $data array //weekStart weekEnd organizationId  //周开始时间 周结束时间 场馆id
     * @return  string
     */
    public function insertData($data){
        $transaction                  =  \Yii::$app->db->beginTransaction();                //开启事务
        try{
            foreach($data as $keys=>$values){
                $startTime  = date("H:i",$values["start"]);
                $endTime    = date("H:i",$values["end"]);
                $resultStartTime = strtotime($values["class_date"][0]["class_date"]." ".$startTime);
                $resultEndTime   = strtotime($values["class_date"][0]["class_date"]." ".$endTime);
                // 执行数据录入前的判断
                $judge = $this->judgeInsertData($resultStartTime,$resultEndTime,$values);
                if($judge == "judgeSuccess"){
                    $model = new GroupClass();
                    $model->start         = $resultStartTime;
                    $model->end           = $resultEndTime;
                    $model->class_date   = $values["class_date"][0]["class_date"];
                    $model->created_at   = time();
                    $model->status      = 1;
                    $model->course_id    = $values["course_id"];
                    $model->coach_id     = $values["coach_id"];
                    $model->venue_id      = $this->organizationId;
                    $model->classroom_id = $values["classroom_id"];
                    $model->create_id    = \Yii::$app->user->identity->id;
                    $model->difficulty   = 1;
                    $model->seat_type_id = $values["seat_type_id"];
                    $result = $model->save();
                    if(!$result){
                        \Yii::trace($model->errors);
                        throw new \Exception($model->errors);
                        break;
                    }
                }
            }
            if($transaction->commit()==null){
                 return true;
            }else{
                return  "数据未录入成功";
            }
        }catch(\Exception $e){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return  $error = $e->getMessage();  //获取抛出的错误
        }
    }
    /**
     * @团课排课 - 使用模板 - 判断数据是否能录入
     * @create 2018/04/03
     * @param $start  //上课开始时间
     * @param $end    // 上课结束时间
     * @return array
     */
    public function judgeInsertData($start,$end,$values){
        $data = GroupClass::find()
            ->where(["or",["and",["coach_id"=>$values["coach_id"]],["class_date"=>$values["class_date"][0]["class_date"]]],["and",["classroom_id"=>$values["classroom_id"]],["class_date"=>$values["class_date"][0]["class_date"]]]])
            ->andWhere(["or",["and",["<=","start",$start],[">=","end",$end]],["or",["between","start",$start,$end],["between","end",$start,$end]]])
//            ->andFilterWhere(['<>','id',$this->courseId])
            ->asArray()->all();
        $data = $this->analyseData($data,$start,$end,$values);
        if($data !== true){
            return $data;
        }
        return "judgeSuccess";
    }
    /**
     * @团课排课 - 使用模板 - 分析不能录入团课的原因
     * @create 2018/04/03
     * @param $data   //不能录入团课的数据
     * @param $start  //课程开始时间
     * @param $end   //课程结束时间
     * @return boolean
     */
    public function analyseData($data,$start,$end,$values){
        if(!empty($data)){
            $course = Course::findOne(['id' => $data[0]['course_id']]);
            // 教室分析
            $classroomAnalyse = $this->dataAnalyse($data,$start,$end,"classroom_id",$values["classroom_id"]);
            if($classroomAnalyse === false){
                return "该教室已被".$course['name']."占用";
            }
            // 教练分析
            $coachAnalyse = $this->dataAnalyse($data,$start,$end,"coach_id",$values["coach_id"]);
            if($coachAnalyse === false){
                return "该教练已经被安排".$course['name'];
            }
        }
        return true;
    }
    /**
     * @团课排课 - 使用模板 - 分析不能录入团课的原因
     * @create 2018/04/03
     * @param $data   //不能录入团课的数据
     * @param $start  //课程开始时间
     * @param $end    //课程结束时间
     * @param $occasion  //参考对象（不能录入团课的数据里边）
     * @param $anotherOccasion  //例外参考对象（新增团课数据里边的）
     * @return boolean
     */
    public function dataAnalyse($data,$start,$end,$occasion,$anotherOccasion){
        foreach($data as $keys=>$values){
            if($values[$occasion] == $anotherOccasion){
                if($start>=$values["start"] || $end<=$values["end"] || ($start<=$values["start"] && $end>=$values["end"])){
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 数据中心 - 新团课管理 - 数据整理归类
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param  $data
     * @return  array    整理之后的数据
     */
    public function arrangeData($ResultData,$data){
          $arrangeData = ["week1","week2","week3","week4","week5","week6","week7"];
          $tuesday = date('Y-m-d',strtotime($data["orgWeekStart"]));
          $myResult = $this->intArrangeData($arrangeData,$tuesday);
          foreach($ResultData as $keys=>$values){
              $w=date('w',strtotime($values["class_date"]));
              $key = "week".$w;
              if($key=="week0"){
                  $key = "week7";
              }
              $ResultData[$keys]["class_date"] = $myResult[$key];
          }
        return $ResultData;
    }
    /**
     * 数据中心 - 新团课管理 - 将指定的数据 归类为下标为周  结果为课程的数据
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param  $arrangeData
     * @param  $dateStatus
     * @return  array
     */
    public function intArrangeData($arrangeData,$dateStatus){
        $myDate = [];
        if($dateStatus){
            $w=date('w',strtotime($dateStatus));
        }else{
            $w=date('w',time());
        }
        $w = (int)$w;
        for($i=$w-1;$i>=0;$i--){
            $myDate[][] = ["class_date"=>date('Y-m-d',strtotime($dateStatus."-$i day"))];
        }
        $q = 1;
        for($i=$w;$i<7;$i++){
            $myDate[][] = ["class_date"=>date('Y-m-d',strtotime($dateStatus."+$q day"))];
            $q++;
        }
        $c=array_combine($arrangeData,$myDate);
        return $c;
    }
    /**
     * 数据中心 - 新团课管理 - 删除指定的预约课程数据
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param  $courseId
     * @return  array
     */
    public function deleteCourse($courseId){
       $groupModel    = GroupClass::findOne(["id"=>$courseId]);
       $deleteResult  = $groupModel->delete();
       $aboutClassDel = AboutClass::deleteAll(["and",["class_id"=>$courseId],["status"=>1],["type"=>"团课"]]);
    }
    /**
     * 数据中心 -获取 指定月的 每一个周的开始日期与结束日期
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param  $year_month      //发送指定的年份对应的月  例如 2017-6
     * @return array            //每一月的周一 开始日期
     */
   public  function getAllMondayOf($year_month = ''){
        if(empty($year_month)){
            $year_month = date("Y-m");
        }
        $maxDay  = date('t', strtotime($year_month."-01"));
        $mondays = array();
        for($i=1; $i<=$maxDay; $i++){
            if(date('w', strtotime($year_month."-".$i)) == 1){
                $mondays[] = $year_month."-".($i>9?'':'0').$i;
            }
        }
        return $mondays;
    }
    /**
     * 数据中心 -获取 指定月的 每一个周的开始日期与结束日期
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param  $date             //发送指定的年份对应的月  例如 2017-6
     * @return array            //每一月的开始日期与结束日期;
     */
    public function getWeek($date){
        $everyMonthWeek =  $this->getAllMondayOf($date);
        $everyWeek      =  $this->everyMonthWeek($everyMonthWeek,$date,true);
        return $everyWeek;
    }
    /**
     * 数据中心 -获取 指定月的 每一个周的开始日期与结束日期
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param  $everyMonthWeek   //每一个月的周 一
     * @param  $date;            // 发送的指定月
     * @param  $type;
     * @return array            //每一月的开始日期与结束日期;
     */
    public function everyMonthWeek($everyMonthWeek,$date,$type = false){
         $week = [];
         foreach($everyMonthWeek as $keys=>$values){
                $monday = $values;
                $sunday = date('Y-m-d',strtotime($values."+6 day"));
                $week[] = ["monday"=>$monday,"sunday"=>$sunday];
         }
         // 获取当前月
        if(!$type){
            $nowMonth = date("Y-m",time());
            if($nowMonth==$date){
                $week    = $this->filterEveryWeek($week);
            }
        }
         return $week;
    }
    /**
     * 数据中心 - 数据判断过滤（周模板）
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param  $week;            // 发送指定月
     * @return array            //每一月的开始日期与结束日期;
     */
    public function filterEveryWeek($week){
        $nowMonth = date("Y-m-d",time());
        foreach($week as $keys=>$values){
               if($values["monday"]>$nowMonth||($nowMonth>=$values["monday"]&&$nowMonth<=$values["sunday"])){
                      unset($week[$keys]);
               }
        }
        return $week;
    }
    /**
     * 数据中心 -获取 从本月推前3个月
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/24
     * @param
     * @return array            //包括当前月的3个月
     */
    public function getMonth(){
               $month = [];
               $nowMonth    =  date('Y-m',time());
               $nowMonday   =  $this->getAllMondayOf($nowMonth);
               $endWeekDate =  date('Y-m-d',strtotime($nowMonday[0]."+6 day"));   //当前月的 第一周结束日期
               $nowDate     =  date("Y-m-d",time());
                $k   = 0;
                $num = 3;
                for($i=$k;$i<$num;$i++){
                    $month[] = date('Y-m',strtotime("-$i month"));
                }
                sort($month);
                return $month;
    }
      
    


}