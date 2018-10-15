<?php
namespace backend\models;
use common\models\base\GroupClass;
use yii\base\Model;

/**
 * @云运动 - 后台 - 团课表单验证
 * @author Huang Pengju <huangpengju@itsports.club>
 * @create 2017/4/13
 */
class GroupClassDataRuleForm extends Model
{
    const CARD_DATA     = ['One','Two'];                              //定义常量用于取出session
    public $className;                                                //课程名(课种ID)
    public $classCoach;                                               //教练名（教练ID）
    public $venueId;                                                  //场馆id
    public $companyId;
    public $classRoom;                                                //教室id

    public $difficulty;                                               //课程难度
    public $classDesc;                                                //课程描述
    public $classPic;                                                 //课程图片

    public $classDate;                                                //课程日期
    public $classDateStart;                                           //课程开始日期
    public $classDateEnd;                                             //课程结束日期
    public $start;                                                    //几点开始
    public $end;                                                      //几点结束

    public $classLimitTime;                                           //开课前多长时间不能约课
    public $cancelLimitTime;                                          //开课前多长时间不能取消约课
    public $leastPeople;                                              //最少开课人数

    const CLASSROOM   = 'classRoom';                                    //常量
    const CLASS_COACH = 'classCoach';                                   //常量
    const CLASS_NAME  = 'className';                                    //常量
    const CLASS_DESC  = 'classDesc';                                    //常量
    const VENUE_ID    = 'venueId';                                      //常量
    const STR         = 'Y-m-d';                                        //常量

    /**
     * 云运动 - 后台 - 团课表单构造初始化函数（用于场景触发）
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * GroupClassDataRuleForm constructor.
     * @param array $config
     * @param string $scenario
     * @param $companyId
     * @param $venueId
     */
    public function __construct(array $config,$scenario = 'one',$companyId,$venueId)
    {
        $this->companyId = $companyId;
        $this->venueId   = $venueId;
        if($scenario != 'cancel'){
            $this->scenario = $scenario;
            parent::__construct($config);
        }else{
            $this->removeSession();
        }

    }

    /**
     * 云运动 - 后台 - 定义场景
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * @return array
     */
    public function scenarios()
    {
        return [
            'one' => [self::CLASS_NAME,self::CLASS_COACH,self::VENUE_ID,self::CLASSROOM,'difficulty',self::CLASS_DESC,'classPic'],
            'two' => ['classDate','classLimitTime','cancelLimitTime','leastPeople'],
        ];
    }
    /**
     * 云运动 - 后台 - 验证场景的规则
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * @return array
     */
    public function rules()
    {
        return [
            [[self::CLASS_NAME,self::CLASS_COACH,self::VENUE_ID,self::CLASSROOM],'required','on'=>'one'],
            [[self::CLASS_NAME,self::CLASS_COACH,self::VENUE_ID,self::CLASSROOM,'difficulty','classLimitTime','cancelLimitTime','leastPeople'],'integer','on'=>['one','two']],

            [self::CLASS_DESC,'trim','on'=>'one'],
            [[self::CLASS_DESC,'classPic'],'string','on'=>'one'],

        ];
    }

    /**
     * 云运动 - 后台 - 取出model中和场景相同的卡属性值，然后存到session中
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * @param $model
     * @return bool
     */
    public function setSessionData($model)
    {
        $cardData = [];                         //定义空数组
        $stepArr  = $this->scenarios();         //调用所有场景
        $stepArr  = $stepArr[$this->scenario];  //取出指定场景
        foreach ($model as $k=>$v)
        {
            if(in_array($k,$stepArr))           //判断卡种的属性是否在场景中
            {
                $cardData[$k] = $v;
            }
        }
       return $this->saveSessionData($cardData);
    }
    /**
     * 云运动 - 后台 - session存储方法
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * @param $cardData
     * @return bool
     */
    public function saveSessionData($cardData)
    {
        $session = \Yii::$app->session;
        switch($this->scenario)                                  //判断场景步骤
        {
            case 'one':
                $session->set('groupClassDataOne',$cardData);
                return 'one';
            case 'two':
                $this->getSessionData();
                $dayTime                                    =  (24 * 3600);                                             //计算一天的秒
                foreach ($cardData['classDate'] as $v) {                                                                      //$k的值代表有几个课程安排
                    $firstTime = strtotime($v[0]);                                                                       //接收课程开始日期（时间戳）
                    $lastTime = strtotime($v[1]);                                                                        //结束课程结束日期（时间戳）
                    while ($firstTime <= $lastTime) {
                        foreach ($v[2] as $key => $value) {
                            $startExist = strtotime(date(self::STR, $firstTime) . '' . $value);        //几点开始（时间戳）
                            $endExist = strtotime(date(self::STR, $firstTime) . '' . $v[3][$key]);   //几点结束（时间戳）
                            $data = $this->getClassExits($this->classCoach,$this->className,$startExist,$endExist);
                            if(!empty($data) && isset($data))
                            {
                                return $value.'-'.$v[3][$key];                                                                      //同一教练的同一课程的同一时间存在
                                break;
                            }
                        }
                        $firstTime = $firstTime + $dayTime;
                    }
                }
                $session->set('groupClassDataTwo',$cardData);
                $data = $this->saveGroupClass();                                  //存储数据
               if($data === true){
                    return true;
                }else{
                    return false;
                }
                break;
            default:
                return false;
        }
    }
    /**
     * 云运动 - 后台 - 过滤方法，把session中的值遍历出赋值给该类的属性
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * @param $data
     * @return bool
     */
    public function loadData($data)
    {
        if($data)
        {
            foreach ($data as $k=>$v)
            {
                $this->$k = $v;
            }
            return true;
        }
        return false;
    }
    /**
     * 云运动 - 后台 - 把session中存储的数据取出来
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     */
    public function getSessionData()
    {
        $session = \Yii::$app->session;
        foreach(self::CARD_DATA as $v)
        {
            $data = $session->get('groupClassData'.$v);
            $this->loadData($data);
        }
    }

    /**
     * @后台 - 团课添加 - 查询是否同一教练同一时间是否存在课程
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/5/22
     * @param $coachId
     * @param $courseId
     * @param $start
     * @param $end
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getClassExits($coachId,$courseId,$start,$end)
    {
        $model = new \backend\models\GroupClass();
        return $model->getGroupClassExits($coachId,$courseId,$start,$end);
    }
    /**
     * 云运动 - 后台 - 封装数据存储到数据库方法
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * @return string
     * @throws \yii\db\Exception
     */
    public function saveGroupClass()
    {
        $this->getSessionData();                                                                                //取出session中存储的数据
        $dayTime                                    =  (24 * 3600);                                             //计算一天的秒
        foreach ($this->classDate as $v){                                                                      //$k的值代表有几个课程安排
            $firstTime                              =  strtotime($v[0]);                                        //接收课程开始日期（时间戳）
            $lastTime                               =  strtotime($v[1]);                                        //结束课程结束日期（时间戳）
            while($firstTime <= $lastTime){
                foreach ($v[2] as $key=>$value){
                        $model                       =  new GroupClass();
                        $model->start                =  strtotime(date(self::STR,$firstTime).''.$value);        //几点开始（时间戳）
                        $model->end                  =  strtotime(date(self::STR,$firstTime).''.$v[3][$key]);   //几点结束（时间戳）
                        $model->class_date           =  date(self::STR,$firstTime);                             //上课日期
                        $model->created_at           =  time();                                                  //添加时间
                        $model->status               =  1;                                                       //课程状态
                        $model->course_id            =  $this->className;                                        //课种ID
                        $model->coach_id             =  $this->classCoach;                                       //教练ID
                        $model->classroom_id         =  $this->classRoom;                                        //教室ID
                        $model->create_id            =  \Yii::$app->user->identity->id;                          //创建人ID
                        $model->difficulty           =  $this->difficulty;                                       //课程难度
                        $model->desc                 =  $this->classDesc;                                        //课程描述
                        $model->pic                  =  $this->classPic;                                         //课程图片
                        $model->class_limit_time     =  $this->classLimitTime;                                   //开课前多长时间不能约课
                        $model->cancel_limit_time    =  $this->cancelLimitTime;                                  //开课前多长时间不能取消约
                        $model->least_people         =  $this->leastPeople;                                      //最少开课人数
                        $model->company_id           = $this->companyId;
                        $model->venue_id             = $this->venueId;
                        if(!$model->save())
                        {
                            return $model->errors;
                            break;
                        }
                    }
                $firstTime = $firstTime + $dayTime;
                }
        }
              return  $this->removeSession();                                                                             //插入成功删除session
    }
    /**
     * @云运动 - 后台 - 删除session 中数据
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/14
     */
    public function removeSession()
    {
        $session = \Yii::$app->session;
        foreach (self::CARD_DATA as $v)
        {
            $session->remove('groupClassData'.$v);
        }
        return true;
    }
}