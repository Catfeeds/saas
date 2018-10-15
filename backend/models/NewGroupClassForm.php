<?php
namespace backend\models;
use Codeception\Module\REST;
use common\models\base\AboutClass;
use common\models\base\Config;
use common\models\base\Course;
use common\models\base\Employee;
use common\models\base\GroupClass;
use common\models\Func;
use Yii;
use yii\base\Model;
/**
 * @云运动 - 新团课- 新增团课课程信息
 * @author 侯凯新 <houkaixin@itsports.club>
 * @create 2017/5/22
 * @inheritdoc
 */
class NewGroupClassForm extends Model
{
    // 表单接受数据信息
    public $date;
    public $start;
    public $end;
    public $courseId;
    public $coach_id;
    public $classroom_id;
    public $company_id;
    public $class_id;
    public $seatTypeId;
    public $coachId;

    //表单数据接受
    public $id;
    public $categoryId;
    public $courseName;
    public $courseTime;
    public $personLimit;
    public $courseDifficult;
    public $des;
    public $pic;

    // 新团课表单配置信息
    public $before_class;    //课程开始前多少分钟不能预约
    public $venue_id;        //场馆id
    public $cancel_time;     //人数下线
    public $personLowerLimit;//人数下线配置

    /**
     * @云运动 - 后台 - 场景多表单定义
     * @create 2017/4/24
     * @return array
     */
    public function  scenarios(){
        return [
            "addCourse"         =>["date","start","end","courseId","coach_id","classroom_id","venue_id","seatTypeId"],
            "addCourseType"     =>["id","categoryId","courseName","courseTime","personLimit","courseDifficult","des","pic","coachId"],
            "insertCourseType"  =>["categoryId","courseName","courseTime","personLimit","courseDifficult","des","pic","coachId"],
            "insertCourseTypeConfig"=>["before_class","venue_id","cancel_time","personLowerLimit"],
            "updateCourse"      =>["date","start","end","courseId","coach_id","classroom_id","class_id","seatTypeId"]
        ];
    }
    /**
     * @云运动 - 后台 - 新增场馆部门验证规则(规则验证)
     * @create 2017/4/24
     * @return array
     */
    public function rules()
    {
        return [
            [["date","start","end","courseId","coach_id","classroom_id","id","originalDate",
                "originalStart","categoryId","courseName","class_id","venue_id"],'required',
             'on'=>["addCourse","addCourseType","updateCourse"]],
            [["courseTime","personLimit","courseDifficult","des","pic"],"safe","on"=>["addCourseType"]]
        ];
    }
    /**
     * @云运动 - 后台 - 新增课程信息
     * @param $companyId    //公司id
     * @create 2017/5/22
     * @return array
     */
    public  function addMyData($companyId){
           $organ = Organization::find()->where(['id'=>$this->venue_id])->asArray()->one();
           $this->company_id = isset($organ['pid'])?$organ['pid']:null;
           $model = new GroupClass();
           $start = strtotime($this->date." ".$this->start);
           $end   = strtotime($this->date." ".$this->end);
           // 执行数据录入前的判断
           $judge =  $this->judgeInsertData($start,$end);
           if($judge!="judgeSuccess"){
                return  $judge;
           }
           $model->start        = $start;
           $model->end          = $end;
           $model->class_date   = $this->date;
           $model->created_at   = time();
           $model->status       = 1;
           $model->course_id    = $this->courseId;
           $model->coach_id     = $this->coach_id;
           $model->classroom_id = $this->classroom_id;
           $model->create_id    = \Yii::$app->user->identity->id;
           $model->difficulty   = 1;     //默认课程难度低
           $model->company_id   = $this->company_id;
           $model->venue_id     = $this->venue_id;           // 注意数据的处理  还未做处理
           $model->seat_type_id = $this->seatTypeId;
           $result  = $model->save();
           if($result){
              return true;
           }else{
               return $model->errors;
           }
    }
    /**
     * @云运动 - 后台 - 新团课管理 -  判断数据是否有能录入
     * @create 2017/6/14
     * @param $start  //上课开始时间
     * @param $end    // 上课结束时间
     * @return array
     */
    public function judgeInsertData($start,$end){
          $data = GroupClass::find()
//                ->where(["venue_id"=>$this->venue_id])
                ->where(["or",["and",["coach_id"=>$this->coach_id],["class_date"=>$this->date]],["and",["classroom_id"=>$this->classroom_id],["class_date"=>$this->date]]])
                ->andWhere(["or",["and",["<=","start",$start],[">=","end",$end]],["or",["between","start",$start,$end],["between","end",$start,$end]]])
                ->andFilterWhere(['<>','id',$this->courseId])
                ->asArray()->all();
         $data = $this->analyseData($data,$start,$end);
         if($data!==true){
              return $data;
         }
         return "judgeSuccess";
    }
    /**
     * @云运动 - 后台 - 新团课管理 - 新增团课（分析不能录入团课的原因）
     * @create 2017/6/30
     * @param $data   //不能录入团课的数据
     * @param $start  //课程开始时间
     * @param $end   //课程结束时间
     * @return array
     */
    public function analyseData($data,$start,$end){
        if(!empty($data)){
            $course = Course::findOne(['id' => $data[0]['course_id']]);
            // 教室分析
            $classroomAnalyse = $this->dataAnalyse($data,$start,$end,"classroom_id",$this->classroom_id);
            if($classroomAnalyse === false){
                return "该教室已被".$course['name']."占用";
            }
            // 教练分析
            $coachAnalyse = $this->dataAnalyse($data,$start,$end,"coach_id",$this->coach_id);
            if($coachAnalyse === false){
                return "该教练已经被安排".$course['name'];
            }
        }
        return true;
    }
    /**
     * @云运动 - 后台 - 新团课管理 - 新增团课（分析不能录入团课的原因）
     * @create 2017/6/30
     * @param $data   //不能录入团课的数据
     * @param $start  //课程开始时间
     * @param $end    //课程结束时间
     * @param $occasion  //参考对象（不能录入团课的数据里边）
     * @param $anotherOccasion  //例外参考对象（新增团课数据里边的）
     * @return array
     */
    public function dataAnalyse($data,$start,$end,$occasion,$anotherOccasion){
        foreach($data as $keys=>$values){
            if($values[$occasion]==$anotherOccasion){
                if($start>=$values["start"]||$end<=$values["end"] ||($start<=$values["start"]&&$end>=$values["end"])){
                      return false;
                }
            }
        }
        return true;
    }

    /**
     * @云运动 - 新团课- 修改后台课程
     * @author 侯凯新 <houkaixin@itsports.club>
     * @param $companyId  //公司id
     * @param $venueId   //场馆id
     * @param $companyId  //公司id
     * @create 2017/5/26
     * @inheritdoc
     */
    public function UpdateCourseType($sign,$companyId,$venueId){
          if(empty($sign)||!isset($sign)){
              $model = Course::findOne(["id"=>$this->id]);
              $model->update_at        = time();
          }else{
              $model = new Course();
              $model->created_at        = time();
          }
          $model->pid               = $this->categoryId;
          $model->name              = $this->courseName;
          $model->pic               = $this->pic;
          $model->course_desrc     = $this->des;
          $model->class_type        = 2;
          $model->create_id         = \Yii::$app->user->identity->id;
          $model->course_duration   = $this->courseTime;
          $model->people_limit      = $this->personLimit;
          $model->course_difficulty = $this->courseDifficult;
          $model->company_id         = $companyId;
          $model->venue_id           = $venueId;
          $model->coach_id           = json_encode($this->coachId);
          //查询顶级分类名字
          $data     =  $this->topCategory();
          $model->category         =  $data["category"];
          $model->path             =  json_encode($data["path"]);
          if(!$model->save()){
                return $model->errors;
          }else{
                return true;
          }
    }
    /**
     * @云运动 - 新团课- 获取修改后的路径 和 课种
     * @author 侯凯新 <houkaixin@itsports.club>
     * @create 2017/5/26
     * @inheritdoc
     */
    public function topCategory(){
          if($this->categoryId==0){
              $data = ["category"=>$this->courseName,"path"=>"0"];
              return $data;
          }
          $data = $this->theSearch($this->categoryId);
          if($data["pid"]==0){
              $category = $data->name;
              $path     ="0,".$this->categoryId;
          }else{
              $array   = explode(",",json_decode($data->path));
              $id      = $array[1];
              $theData = $this->theSearch($id);
              $category= $theData->name;
              $path    = json_decode($data->path).",".$this->categoryId;
          }
          $data = ["category"=>$category,"path"=>$path];
          return $data;
    }
    /**
     * @云运动 - 新团课- 搜索课种
     * @author 侯凯新 <houkaixin@itsports.club>
     * @create 2017/5/26
     * @inheritdoc
     */
    public function theSearch($id){
        $data = Course::findOne(["id"=>$id]);
        return $data;
    }

    /**
     * @云运动 - 新团课-  新团课数据插入
     * @author 侯凯新 <houkaixin@itsports.club>
     * @param $companyId
     * @param $venueId
     * @create 2017/5/26
     * @inheritdoc
     */
    public function  insertCourseType($companyId,$venueId){
        $result =  $this->UpdateCourseType("sign",$companyId,$venueId);
        return $result;
    }
    /**
     * @云运动 - 新团课-  新团课数据插入配置
     * @author 侯凯新 <houkaixin@itsports.club>
     * @create 2017/5/26
     * @param $data
     * @inheritdoc
     */
    public function insertCourseTypeConfig($data,$companyId,$venueId){
         unset($data["_csrf_backend"]);
         if(!empty($data)){
            foreach($data as $keys=>$values){
                 $error = $this->config($keys,$values,$companyId,$venueId);
                 if($error!==true){
                    return  $error;
                 }
            }
             return true;
         }else{
             return false;
         }
    }
    /**
     * @云运动 - 新团课-  课程配置信息导入
     * @author 侯凯新 <houkaixin@itsports.club>
     * @create 2017/5/26
     * @param $data
     * @inheritdoc
     */
    public function config($keys,$values,$companyId,$venueId)
    {
            $data = Config::findOne(["key" => $keys, "venue_id" => $venueId]);
            if (empty($data)) {
                $data = new Config();
            }
            $data->key = (string)$keys;
            $data->value = (string)$values;
            $data->type = "league";
            $data->company_id = $companyId;
            $data->venue_id = $venueId;
            if (!$data->save()) {
                return $data->errors;
            } else {
                return true;
            }
     }
    /**
     * @云运动 - 新团课-  团课信息修改
     * @author 侯凯新 <houkaixin@itsports.club>
     * @create 2017/5/31
     * @param $venueId    // 所属场馆id
     * @inheritdoc
     */
    public function updateCourseDetail($venueId){
            $company    = Organization::findOne(["id"=>$venueId]);
            $companyId  = $company->pid;
            $myTime     = date("Y-m-d",time());
            $groupClass = \backend\models\GroupClass::find()
                ->alias("groupClass")
                ->where(["groupClass.id"=>$this->courseId])
                ->joinWith(["course course"],false)
                ->select("groupClass.*,course.name as courseName")
                ->asArray()
                ->one();
            if(empty($groupClass)){
                 return "修改课程不存在";
            }
            if($groupClass["class_date"]<$myTime||time()>=$groupClass["start"]){
                return "课程已过期，暂不能修改";
            }
           // 判断未过期的课程是  否被会员预约
                $result = AboutClass::find()->where(["and",["class_date"=>$groupClass["class_date"]],["class_id"=>$this->courseId],["status"=>1]])->asArray()->all();
                $start = $this->date." ".$this->start;
                $end   = $this->date." ".$this->end;
                // 执行数据录入前的判断
                $judge = $this->judgeInsertData(strtotime($start),strtotime($end));
                if($judge != "judgeSuccess"){
                    return $judge;
                }
//                if(!empty($result)){
                    // 如果有会员预约（只能修改除了教练以外的其它字段）
//                    $judge = $this->updateJudge($groupClass,$start,$end);
//                    if($judge!==true){
//                        return $judge;
//                    }
//                }
//            if(empty($result)){
                $course   = Course::findOne(['id' => $this->class_id]);
                $coachArr = json_decode($course['coach_id'],true);
                if(empty($coachArr)){
                    return '该课程没有绑定任何教练';
                }
                if(in_array($this->coach_id,$coachArr)){
                    $model = GroupClass::findOne(["id"=>$this->courseId]);
                    $model->class_date   = $this->date;
                    $model->start        = strtotime($start);
                    $model->course_id    = (int)$this->class_id;
                    $model->end          = strtotime($end);
                    $model->coach_id     = (int)$this->coach_id;
                    $model->classroom_id = (int)$this->classroom_id;
                    $model->seat_type_id = (int)$this->seatTypeId;
                    $model->venue_id     = $venueId;
                    $model->company_id   = $companyId;
                    if(!$model->save()){
                        return $model->errors;
                    }
                    // 修改成功以已短信的形式通知
                    $this->MassMessage($groupClass);
                    return true;
                }else{
                    return "该课程没有绑定该教练";
                }
//            }else{
//                return "会员已经预约过，暂不能修改";
//            }
    }

    /**
     * @云运动 - 新团课- 如果已有会员预约不准
     * @author 侯凯新 <houkaixin@itsports.club>
     * @create 2017/5/31
     * @param $groupClass   // 团课课程
     * @param $start        // 课程开始时间
     * @param $end          // 课程结束时间
     * @inheritdoc
     */
    public function updateJudge($groupClass,$start,$end){
          if($this->classroom_id!=$groupClass["classroom_id"]
             ||$this->seatTypeId!=$groupClass["seat_type_id"]||
             $start!=date("Y-m-d H:i",$groupClass["start"])||($end!=date("Y-m-d H:i",$groupClass["end"]))){
              return "已有会员预约,只能修改教练选项";
          }
        return true;
    }
    /**
     * @云运动 - 新团课-  如果修改教练的话  将以短信的形式 通知所有会员
     * @author 侯凯新 <houkaixin@itsports.club>
     * @create 2017/5/31
     * @param $oldCoach      // 老教练
     * @param $groupClass    // 团教课程
     * @inheritdoc
     */
    public function MassMessage($groupClass){
        if($this->class_id != $groupClass["course_id"] || $this->coach_id != $groupClass["coach_id"]){
            // 修改约课会员的教练
            AboutClass::updateAll(["coach_id"=>$this->coach_id],["and",["class_id"=>$this->courseId],["!=","status",2],["type"=>2]]);
            // 编辑教练内容
            $start     = date("H:i",$groupClass["start"]);
            $end       = date("H:i",$groupClass["end"]);
            $classTime = $groupClass["class_date"]." ".$start."-".$end;
            $oldCoach  = Employee::findOne($groupClass["coach_id"])->name;
            $newCoach  = Employee::findOne($this->coach_id)->name;
            $oldClass  = Course::findOne($groupClass["course_id"])->name;
            $newClass  = Course::findOne($this->class_id)->name;
            // 获取要发送短信的会员
            $mobile = $this->gainSendMessageMember();
            if(empty($mobile)){
                return false;
            }
            $this->sendMessage($mobile,$classTime,$oldCoach,$newCoach,$oldClass,$newClass);
        }
    }
    /**
     * @云运动 - 团课排课 - 修改课程
     * @author 侯凯新 <houkaixin@itsports.club>
     * @create 2017/12/06
     * @return  array
     */
    public function gainSendMessageMember(){
        $aboutClass = \backend\models\AboutClass::find()
            ->alias("aboutClass")
            ->where(["and",["aboutClass.class_id"=>$this->courseId],["!=","aboutClass.status",2],["type"=>2]])
            ->joinWith(["member member"],false)
            ->select("member.mobile")
            ->asArray()
            ->column();
        $mobileArr = array_unique($aboutClass);
        return $mobileArr;
    }

    /**
     * @云运动 - 新团课-  如果修改教练的话  将以短信的形式 通知所有会员(短信逻辑)
     * @author 侯凯新 <houkaixin@itsports.club>
     * @create 2017/5/31
     * @param $content        // 编辑短信发送的内容
     * @param $memberPhone    // 所有会员电话
     * @return boolean        // 返回的结果集
     */
    public function sendMessage($mobile,$classTime,$oldCoach,$newCoach,$oldClass,$newClass){
        foreach($mobile as $keys=>$phone){
            if(empty($phone)){
                continue;
            }
            Func::sendUpdateLeague($phone,$classTime,$oldCoach,$newCoach,$oldClass,$newClass);
        }
        return true;
    }
}