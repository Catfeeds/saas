<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/4 0004
 * Time: 下午 3:32
 */
namespace backend\models;
use common\models\base\AboutClass;
use common\models\base\ChargeClassNumber;
use common\models\base\Course;
use common\models\base\CoursePackageDetail;
use common\models\base\MemberCourseOrder;
use common\models\base\MemberDetails;
use common\models\Func;
use common\models\relations\ChargeGroupClassRelations;

class ChargeGroupClass extends \common\models\base\ChargeGroupClass
{
    use ChargeGroupClassRelations;
    public $weekStart;     //周时间开始（周一）
    public $weekEnd;       //周时间结束（周日）
    public $startTime;     //私教上课列表开始日期
    public $endTime;       //私教上课列表结束日期
    public $keyword;
    public $venueId;
    const START_TIME = 'startTime';
    const END_TIME   = 'endTime';
    const KEYWORD    = 'keyword';
    const VENUE_ID   = 'venueId';

    /**
     * @私教小团体课 - 获取排课日历详情
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/04
     * @return array|string
     */
    public function getClassData($data)
    {
        $this->autoLoad($data);
        $query = ChargeGroupClass::find()
            ->alias('cgc')
            ->joinWith(['chargeClassNumber ccn' => function($query){
                $query ->joinWith(['chargeClass cc'],false);
            }],false)
            ->joinWith(['employee ee'],false)
            ->where(['<>','cgc.status',5])
            ->andWhere(["between","cgc.class_date",$this->weekStart,$this->weekEnd])
            ->andWhere(['cgc.venue_id' => $this->venueId])
            ->select('cgc.*,ccn.attend_class_num,cc.name as className,ee.name as coachName')
            ->asArray()
            ->all();
        $arrangeData = $this->getArrange($query);
        $arrangeData = $this->getDataStatus($arrangeData);
        $arrangeData = $this->endFilterData($arrangeData);
        return $arrangeData;
    }

    /**
     * @私教小团体课 - 获取排课日历详情 - 处理搜索字段
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/04
     * @return array|string
     */
    public function autoLoad($data)
    {
        $roleId       = \Yii::$app->user->identity->level;
        if($roleId == 0){
            $vId      = Organization::find()->select('id')->where(['style'=>2])->asArray()->all();
            $venueIds = array_column($vId, 'id');
        }else{
            //拿到用户有权限查看的场馆
            $venuesId = Auth::findOne(['role_id' => $roleId])->venue_id;
            $authId   = json_decode($venuesId);
            //去掉组织架构里面设置"不显示"的场馆id
            $venues   = Organization::find()->where(['id'=>$authId])->andWhere(['is_allowed_join'=>1])->select(['id','name'])->asArray()->all();
            $venueIds = array_column($venues, 'id');
        }
        if($data['venueId'] == ''){
            $this->venueId = $venueIds;
        }else{
            $this->venueId = $data['venueId'];
        }
        if(empty($data['weekStart']) && empty($data['weekEnd'])){
            $this->weekStart = date('Y-m-d', (time() - ((date('w') == 0 ? 7 : date('w')) - 1) * 24 * 3600));    //本周一
            $this->weekEnd   = date('Y-m-d', (time() + (7 - (date('w') == 0 ? 7 : date('w'))) * 24 * 3600));    //本周日
        }else{
            $this->weekStart = date('Y-m-d',strtotime($data['weekStart']));    //下周一
            $this->weekEnd   = date('Y-m-d',strtotime($data['weekEnd']));      //下周日
        }
    }

    /**
     * @私教小团体课 - 获取排课日历详情 - 按照日期整理数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/04
     * @return array|string
     */
    public function getArrange($query)
    {
        $arrangeData = ["week1","week2","week3","week4","week5","week6","week7"];
        $arrangeData = $this->intArrangeData($arrangeData);
        if(!empty($query)){
            foreach($query as $keys=>$values){
                //判断是否有数据
                if(count($values) == 1){
                    $query[$keys]["data"] = 1;    //1有数据
                }else{
                    $query[$keys]["data"] = 2;    //2没数据
                }
                $w = date('w',strtotime($values["class_date"]));
                $key = "week".$w;
                if($key == "week0"){
                    $key = "week7";
                }
                if(isset($arrangeData[$key][0]) && count($arrangeData[$key][0]) == 1){
                    unset($arrangeData[$key]);
                    $arrangeData[$key] = [];
                }
                $arrangeData[$key][] = $values;
            }
        }
        ksort($arrangeData);
        return $arrangeData;
    }

    /**
     * @私教小团体课 - 获取排课日历详情 - 数据整理
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/04
     * @return array|string
     */
    public function intArrangeData($arrangeData){
        $myDate = [];
        if($this->weekStart){
            $w=date('w',strtotime($this->weekStart));
        }else{
            $w=date('w',time());
            $w =($w==0)?7:$w;
        }
        $w = (int)$w;
        for($i=$w-1;$i>=0;$i--){
            $myDate[][] = ["class_date"=>date('Y-m-d',strtotime($this->weekStart."-$i day"))];
        }
        $q = 1;
        for($i=$w;$i<7;$i++){
            $myDate[][] = ["class_date"=>date('Y-m-d',strtotime($this->weekStart."+$q day"))];
            $q++;
        }
        $c=array_combine($arrangeData,$myDate);
        return $c;
    }

    /**
     * @私教小团体课 - 获取排课日历详情 - 判断获取是否有数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/04
     * @return array|string
     */
    public function getDataStatus($arrangeData){
        foreach($arrangeData as $keys=>$values){
            foreach($values as $key=>$value){
                if(count($value) > 1){
                    $arrangeData[$keys][$key]["data"] = true;
                    //计算这是排的第几节课
                    $num = $this->arrangeNum($value);
                    $arrangeData[$keys][$key]["num"] = $num;
                }else{
                    $arrangeData[$keys][$key]["data"] = false;
                }
            }
        }
        return $arrangeData;
    }

    //计算这是排的第几节课
    public function arrangeNum($value)
    {
        $num = ChargeGroupClass::find()
            ->where(['class_number_id' => $value['class_number_id']])
            ->andWhere(['<=','start',$value['start']])
            ->andWhere(['!=','status',5])
            ->count();
        return $num;
    }

    /**
     * @私教小团体课 - 获取排课日历详情 - 根据日期过滤周数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/04
     * @return array|string
     */
    public function endFilterData($arrangeData)
    {
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
     * @私教小团体课 - 获取私教上课列表数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/04
     * @return array|string
     */
    public function attendClassList($data)
    {
        $this->customLoad($data);
        $class = ChargeGroupClass::find()
            ->alias('cgc')
            ->joinWith(['chargeClassNumber ccn' => function($query){
                $query->joinWith(['chargeClass cc'],false);
            }],false)
            ->joinWith(['employee ee'],false)
            ->where(['!=','cgc.status',5])
            ->select('cgc.*,ccn.class_number,ccn.sell_number,cc.name as className,ee.name as coachName')
            ->orderBy('class_date desc')
            ->asArray();
        $class = $this->searchWhere($class);
        return $class;
    }

    /**
     * @私教小团体课 - 获取私教上课列表数据 - 分页
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/10
     * @return array|string
     */
    public function getSumData($query)
    {
        return Func::getDataProvider($query,8);
    }

    /**
     * @私教小团体课 - 获取私教上课列表数据 - 预约人数
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/10
     * @return array|string
     */
    public function getSumDataMoney($query)
    {
        $class    = $query->all();
        $idArr    = array_column($class,'id');
        $aboutNum = [];
        foreach ($idArr as $key => $value) {
            $about = AboutClass::find()->where(['class_id' => $value,'type' => 3])->andWhere(['status'=>[1,3,4]])->count();
            array_push($aboutNum,$about);
        }
        return $aboutNum;
    }

    /**
     * @私教小团体课 - 获取私教上课列表数据 - 处理搜索字段
     * @create 2018/01/06
     * @author zhumengke <zhumengke@itsports.club>
     * @param $params
     * @return bool
     */
    public function customLoad($params)
    {
        $roleId       = \Yii::$app->user->identity->level;
        if($roleId == 0){
            $vId      = Organization::find()->select('id')->where(['style'=>2])->asArray()->all();
            $venueIds = array_column($vId, 'id');
        }else{
            //拿到用户有权限查看的场馆
            $venuesId = Auth::findOne(['role_id' => $roleId])->venue_id;
            $authId   = json_decode($venuesId);
            //去掉组织架构里面设置"不显示"的场馆id
            $venues   = Organization::find()->where(['id'=>$authId])->andWhere(['is_allowed_join'=>1])->select(['id','name'])->asArray()->all();
            $venueIds = array_column($venues, 'id');
        }
        $this->venueId   = (isset($params[self::VENUE_ID]) && !empty($params[self::VENUE_ID]))?$params[self::VENUE_ID] : $venueIds;
        $this->startTime = (isset($params[self::START_TIME]) && !empty($params[self::START_TIME]))?$params[self::START_TIME] : NULL;
        $this->endTime   = (isset($params[self::END_TIME]) && !empty($params[self::END_TIME]))?$params[self::END_TIME] : NULL;
        $this->keyword   = (isset($params[self::KEYWORD]) && !empty($params[self::KEYWORD]))?$params[self::KEYWORD] : NULL;
    }

    /**
     * @私教小团体课 - 获取私教上课列表数据 - 搜索字段
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/03
     * @param  $query
     * @return array
     */
    public function searchWhere($query)
    {
        $query->andFilterWhere(['cgc.venue_id' => $this->venueId]);
        $query->andFilterWhere(["between","cgc.class_date",$this->startTime,$this->endTime]);
        $query->andFilterWhere(['like','ccn.class_number',$this->keyword]);
        return $query;
    }

    /**
     * @私教小团体课 - 获取下周课程表数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/09
     * @return array|string
     */
    public function initData($data){
        $this->getTimeWeek();
        if(empty($data["weekStart"]) || empty($data["weekEnd"])){
            $wStart = date('Y-m-d',strtotime($this->weekStart . '-7 day'));  //当前周的  上周一
            $wEnd   = date('Y-m-d',strtotime($this->weekEnd . '-7 day'));  //当前周的  上周日
            $data   = ["weekStart" => $wStart,"weekEnd" => $wEnd];
        }
        $data = $this->getClassData($data);
        return $data;
    }

    /**
     * @私教小团体课 - 获取下周课程表数据 - 整理数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/09
     * @return array|string
     */
    public function getTimeWeek(){
        $nowDate   = date("Y-m-d");
        $day       = date('w',strtotime($nowDate));
        $weekStart = date('Y-m-d',strtotime("$nowDate -".($day ? $day - 1 : 6).' days'));
        $weekEnd   = date('Y-m-d',strtotime("$weekStart + 6 days"));
        $this->weekStart = $weekStart;
        $this->weekEnd   = $weekEnd;
    }

    /**
     * @私教小团体课 - 获取某一课程信息
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/06
     * @return array|string
     */
    public function oneClassData($id)
    {
        $class = ChargeGroupClass::find()
            ->alias('cgc')
            ->joinWith(['chargeClassNumber ccn' => function($query){
                $query->joinWith(['chargeClass cc'],false);
            }],false)
            ->where(['cgc.id' => $id])
            ->select('cgc.class_number_id,cgc.start,cgc.end,cgc.status,ccn.class_number,ccn.attend_class_num,cc.name')
            ->asArray()
            ->one();
        //计算这是排的第几节课
        $num = $this->arrangeNum($class);
        $class["num"] = $num;
        //获取课种和课程时长
        $charge = ChargeClassNumber::findOne(['id' => $class['class_number_id']]);
        $course = CoursePackageDetail::find()->where(['charge_class_id' => $charge['charge_class_id']])->asArray()->all();
        if(count($course) > 1){
            $courseNum = 0;
            foreach ($course as $key => $value) {
                $courseNum += $value['course_num'];
                if($courseNum >= $num){
                    $name = Course::find()->where(['id' => $value['course_id']])->select('name')->asArray()->one();
                    $class['courseName'] = $name['name'];
                    $class['length']     = $value['course_length'];
                    break;
                }
            }
        }else{
            $name = Course::find()->where(['id' => $course[0]['course_id']])->select('name')->asArray()->one();
            $class['courseName'] = $name['name'];
            $class['length']     = $course[0]['course_length'];
        }
        return $class;
    }

    /**
     * @私教小团体课 - 获取预约详情
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/06
     * @return array|string
     */
    public function aboutDetail($id)
    {
        $aboutDetail = \backend\models\AboutClass::find()
            ->alias('ac')
            ->joinWith(['member mm' => function($query){
                $query->joinWith(['memberDetails md'],false);
            }],false)
            ->where(['ac.class_id' => $id])
            ->andWhere(['ac.type' => 3])
            ->select('md.member_id,md.name,md.sex,mm.mobile,ac.id,ac.status,ac.create_at,ac.end')
            ->asArray()
            ->all();
        return $aboutDetail;
    }

    /**
     * @私教小团体课 - 取消课程
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/06
     * @return array|string
     */
    public function cancelClass($id)
    {
        $chargeGroup = ChargeGroupClass::findOne(['id' => $id]);
        if($chargeGroup['status'] == '1'){
            $chargeGroup->status = 5;
            if($chargeGroup->save()){
                return true;
            }else{
                return $chargeGroup->errors;
            }
        }
        return false;
    }

    /**
     * @私教小团体课 - 登记上课
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/06
     * @return array|string
     */
    public function registerClass($id)
    {
        $chargeGroup = ChargeGroupClass::findOne(['id' => $id]);
        $classNumber = ChargeClassNumber::findOne(['id' => $chargeGroup['class_number_id']]);
        $classPeople = ChargeClassPeople::findOne(['id' => $classNumber['class_people_id']]);
        $aboutClass  = AboutClass::find()->where(['class_id' => $id,'type'=>3,'status' => 1])->asArray()->count();
        if($aboutClass < intval($classPeople['least_number'])){
            \backend\models\AboutClass::updateAll(['status'=>9,'is_read'=>0],['and',['type'=>3,'class_id'=>$id],['<=','start',time()]]);
            return '预约人数不足，暂时无法登记上课';
        }

        $transaction = \Yii::$app->db->beginTransaction();  //开启事务
        try{
//            $chargeGroup = ChargeGroupClass::findOne(['id' => $id]);
            if($chargeGroup['status'] == '1'){
                $chargeGroup->status = 3;
                if($chargeGroup->save() != true){
                    return $chargeGroup->errors;
                }
            }

//            $classNumber = ChargeClassNumber::findOne(['id' => $chargeGroup['class_number_id']]);
            $classNumber->attend_class_num = intval($classNumber['attend_class_num']) - 1;
            if($classNumber->save() != true){
                return $classNumber->errors;
            }

            AboutClass::updateAll(['status' => 3],['and',['type' => 3],['class_id' => $id]]);

            if($transaction->commit() == null){
                return true;
            }else{
                return false;
            }
        }catch(\Exception $e){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return $e->getMessage();  //获取抛出的错误
        }
    }

    /**
     * @私教小团体课 - 会员下课打卡
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/06
     * @return array|string
     */
    public function overClass($aboutId)
    {
        $about       = AboutClass::findOne(['id' => $aboutId]);
        $chargeGroup = ChargeGroupClass::findOne(['id' => $about['class_id']]);
        $courseOrder = MemberCourseOrder::findOne(['member_id' => $about['member_id'],'class_number_id' => $chargeGroup['class_number_id']]);
        $transaction = \Yii::$app->db->beginTransaction();  //开启事务
        try{
            if($about['status'] == 3){
                $about->status = 4;
                if($about->save() != true){
                    return $about->errors;
                }
            }

            $courseOrder->overage_section = intval($courseOrder['overage_section']) - 1;
            if($courseOrder->save() != true){
                return $courseOrder->errors;
            }

            if($transaction->commit() == null){
                return true;
            }else{
                return false;
            }
        }catch(\Exception $e){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return $e->getMessage();  //获取抛出的错误
        }
    }

    /**
     * @私教小团体课 - 提前下课
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/09
     * @return array|string
     */
    public function advanceClass($id)
    {
        $transaction =  \Yii::$app->db->beginTransaction();  //开启事务
        try{
            $chargeGroup = ChargeGroupClass::findOne(['id' => $id]);
            if($chargeGroup['status'] == '3'){
                $chargeGroup->status = 4;
                if($chargeGroup->save() != true){
                    return $chargeGroup->errors;
                }
            }

            AboutClass::updateAll(['status' => 4],['and',['type' => 3],['class_id' => $id]]);

            if($transaction->commit() == null){
                return true;
            }else{
                return false;
            }
        }catch(\Exception $e){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return $e->getMessage();  //获取抛出的错误
        }
    }
}