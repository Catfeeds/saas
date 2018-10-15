<?php
namespace backend\models;
use common\models\Func;
class MemberBehaviorTrail extends  \common\models\MemberBehaviorTrail
{
    use \common\models\relations\EmployeeRelations;
    public $startTime;          // 浏览开始时间
    public $endTime;            // 浏览结束时间
    public $employeeName;       // 员工姓名
    public $employeeBehavior;  // 员工行为
    public $operateModuleId;    // 操作模块Id
    public $nowBelongType;      // 所属身份级别
    public $nowBelongId;        // 所属身份级别id
    public $sorts;               // 排序

    //常量定义
    const NOW_BELONG_ID           = 'nowBelongId';
    const NOW_BELONG_TYPE         = 'nowBelongType';
    const START_TIME               = "startTime";
    const END_TIME                 = "endTime";
    const EMPLOYEE_NAME           = "employeeName";
    const EMPLOYEE_BEHAVIOR       ="employeeBehavior";
    const OPERATE_MODULE          = "operateModuleId";
    const SORT_TYPE                = "sortType";

    /**
     * 后台 - 会员行为轨迹 -  获取会员行为轨迹
     * @author Houkaixin <Houkaixin@itsports.club>
     * @create 2017/7/13
     * @return \yii\db\ActiveQuery
     */
    public function getMemberBehaviorTrail($params){
        $this->customLoad($params);
        $query = MemberBehaviorTrail::find()->alias("behaviorTrail")
            ->joinWith(["adminEmployee adminEmployee"=>function($query){
                    $query->joinWith(["employee employee"]);
            }],false)
            ->joinWith(["module module"],false)
            ->select( "behaviorTrail.*,employee.name,employee.company_id,
                    employee.venue_id,module.name as moduleName,
                    adminEmployee.username")
            ->orderBy($this->sorts)
            ->asArray();
        $query = $this->getSearchWhere($query);
        $data  = Func::getDataProvider($query,8);
        return $data;
    }
    /**
     * 后台 - 会员行为轨迹 -  执行相应搜索
     * @author Houkaixin<Houkaixin@itsports.club>
     * @param  $query     // 执行搜索的sql语句
     * @create 2017/7/13
     * @return  boolean  // 初始化直接结果的布尔值
     */
    public function getSearchWhere($query){
           // 员工姓名搜索
           if(!empty($this->employeeName)){
               $query->andFilterWhere(["employee.name"=>$this->employeeName]);
           }
           // 员工行为搜索
           if(!empty($this->employeeBehavior)){
               $query->andFilterWhere(["behaviorTrail.behavior"=>$this->employeeBehavior]);
           }
           // 员工操作模块搜索
           if(!empty($this->operateModuleId)){
               $query->andFilterWhere(['or'
                   ,["behaviorTrail.module_id"=>$this->operateModuleId],
                   ['module.pid'=>$this->operateModuleId]]);
           }
           // 操作开始时间 结束时间搜索
           if(!empty($this->startTime)&&!empty($this->endTime)){
               $query->andFilterWhere([
                   "between","behaviorTrail.create_at",$this->startTime,$this->endTime
                ]);
           }
           // 根据公司 分级权限
           if(!empty($this->nowBelongType)&&$this->nowBelongType=="company"){
               $query->andFilterWhere([
                   "employee.company_id"=>$this->nowBelongId
               ]);
           }
           // 根据场馆分级权限
           if(!empty($this->nowBelongType)&&$this->nowBelongType=="venue"){
               $query->andFilterWhere([
                   "employee.venue_id"=>$this->nowBelongId
               ]);
           }
         return $query;
    }
    /**
     * 后台 - 会员行为轨迹 -  初始数据加载
     * @author Houkaixin <Houkaixin@itsports.club>
     * @param  $data
     * @create 2017/7/13
     * @return  boolean  // 初始化直接结果的布尔值
     */
     public function customLoad($data){
         $this->startTime          = (isset($data[self::START_TIME]) && !empty($data[self::START_TIME])) ? strtotime($data[self::START_TIME]) : null;
         $this->endTime            = (isset($data[self::END_TIME])   && !empty($data[self::END_TIME])) ? strtotime($data[self::END_TIME]) : null;
         $this->employeeName       = (isset($data[self::EMPLOYEE_NAME]) && !empty($data[self::EMPLOYEE_NAME]))?: null;
         $this->employeeBehavior   = (isset($data[self::EMPLOYEE_BEHAVIOR]) && !empty($data[self::EMPLOYEE_BEHAVIOR]))?$data[self::EMPLOYEE_BEHAVIOR]: null;
         $this->operateModuleId     = (isset($data[self::OPERATE_MODULE]) && !empty($data[self::OPERATE_MODULE]))?$data[self::OPERATE_MODULE]: null;
         $this->nowBelongId        = (isset($data[self::NOW_BELONG_ID]) && !empty($data[self::NOW_BELONG_ID]))?$data[self::NOW_BELONG_ID]: NULL;
         $this->nowBelongType      = (isset($data[self::NOW_BELONG_TYPE]) && !empty($data[self::NOW_BELONG_TYPE]))?$data[self::NOW_BELONG_TYPE]: NULL;
         $this->sorts               = self::loadSort($data);      // 最终排序规则
         return true;
     }
    /**
     * 后台 - 组织架构管理 - 对各个字段的排序
     * @create 2017/4/24
     * @author houkaixin<houkaixin@itsports.club>
     * @param $data  array //前台获取的排序处理数据
     * @return array
     */
    public static function loadSort($data)
    {
        $sorts = ["behaviorTrail.create_at" => SORT_DESC];
        if(!isset($data["sortName"])){ return $sorts;}
        switch ($data["sortName"]){
            case 'employeeName'  :         // 员工姓名
                $attr = 'employee.name';
                break;
            case 'employeeBehavior':     // 员工行为
                $attr = 'behaviorTrail.behavior';
                break;
            case 'operateModule':       // 员工操作模型
                $attr = 'behaviorTrail.module';
                break;
            case 'create_at':           // 创建时间
                $attr = 'behaviorTrail.create_at';
                break;
            case "behavior_ip":       // 操作本地ip
                $attr = 'behaviorTrail.behavior_ip';
                break;
            case 'behavior_intro':   // 行为介绍
                $attr = 'behaviorTrail.behavior_intro';
                break;
            default:
                $attr = NULL;
                break;
        };
        if($attr){
            $sorts = [ $attr => self::convertSortValue($data['sortType'])];
        }
        return $sorts;
    }
    /**
     * 后台 - 会员行为轨迹- 获取最终排序规则
     * @create 2017/7/13
     * @author houkaixin<houkaixin@itsports.club>
     * @param $sort     // 前台传过来的排序规则（ASC，DES两种情况）
     * @return string
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
     * 后台 - 会员行为轨迹- 获取客户端操作ip
     * @create 2017/7/14
     * @author houkaixin<houkaixin@itsports.club>
     * @param
     * @return string
     */
    public function getIp()
    {
        $preg = "/\A((([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\.){3}(([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\Z/";
       //获取操作系统为win2000/xp、win7的本机IP真实地址
        exec("ipconfig", $out, $stats);
        if (!empty($out)) {
            foreach ($out AS $row) {
                if (strstr($row, "IP") && strstr($row, ":") && !strstr($row, "IPv6")) {
                    $tmpIp = explode(":", $row);
                    if (preg_match($preg, trim($tmpIp[1]))) {
                        return trim($tmpIp[1]);
                    }
                }
            }
        }
    }
    /**
     * 后台 - 会员行为轨迹- 会员日常操作记录
     * @create 2017/7/14
     * @author houkaixin<houkaixin@itsports.club>
     * @param  // 传送参数
     * @return string
     */
    public  function insertData($param){
        $id           = \Yii::$app->user->identity->id;  // 操作id
        $behavior     = $param["behavior"];              // 会员行为 1:浏览 2:编辑 3:修改 4:查看 5:删除
        $moduleId     = $param["moduleId"];              // 操作模块id
        $behavior_intro = $param["behaviorIntro"];      // 会员操作介绍
        $ip  = $this->getIp();
        $model = new \common\models\base\MemberBehaviorTrail();
        $model->employee_id = $id;
        $model->behavior    = $behavior;
        $model->module_id   = $moduleId;
        $model->create_at   = time();
        $model->behavior_ip = $ip;
        $model->behavior_intro = $behavior_intro;
        if(!$model->save()){
            return $model->errors;
        }
        return true;
    }
}
?>