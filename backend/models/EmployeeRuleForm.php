<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\Employee;

class EmployeeRuleForm extends Model
{
    //新增员工
    public  $position;       //职位
    public  $salary;         //薪资
    public  $classTime;      //基础课量
    public  $classAmount;    //免费课量
    public  $name;           //员工名
    public  $classHour;      //课时、考核
    public  $department;     //部门id
    public  $status;         //员工状态
    public  $mobile;         //手机号
    public  $sex;            //性别
    public  $alias;          //别名
    public  $intro;          //简介
    public  $pic;            //图片
    public  $work_time;      //从业时间
    public  $work_url;      //作品地址
    public  $company;        //接收的公司id
    public  $venue;          //接收的场馆id
    public  $companyId;      //控制器获取的公司id
    public  $venueId;        //控制器获取的场馆id
    public  $fingerprint;    //指纹
    public  $identityCard;   //身份证
    public  $birth_time;     //出生日期
    public function __construct(array $config,$companyId,$venueId)
    {
        $this->companyId = $companyId;
        $this->venueId   = $venueId;
        parent::__construct($config);
    }

    /**
     * @云运动 - 后台 - 场景表单定义
     * @create 2017/4/25
     * @return array
     */
    public function  scenarios(){
        return [
            'addEmployee'=>["name",'sex','status',"position","salary","department",
                'classHour','classTime','classAmount','mobile','alias','work_url','intro',
                'pic','work_time','company','venue','fingerprint','birth_time','identityCard']
        ];

    }



    /**
     * @云运动 - 后台 - 新增员工验证规则(规则验证)
     * @create 2017/4/24
     * @return array
     */
    public function rules()
    {
        return [
            [["name","department","status"], 'required','on'=>'addEmployee'],
            [['position','salary',"classTime","classAmount",'classHour','mobile','sex','alias','intro','pic','work_time',"status",'company','venue','fingerprint','birth_time','identityCard'], 'safe'],
        ];
    }
    /**
     * 云运动 - 后台- 新增员工信息录入
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/4/25
     * @return boolean/object
     */
    public function addMyData(){
        $this->getVenueData();
        // 员工信息保存
        $model                    = new Employee();
        $model->status            = $this->status;
        $model->organization_id   = $this->department;
        $model->create_id         = Yii::$app->user->identity->id;
        $model->created_at        = time();
        $model->name              = $this->name;
        $model->position          = $this->position;
        $model->salary            = (int)$this->salary;
        $model->mobile            = $this->mobile ? $this->mobile : NULL;
        $model->class_hour        = (int)$this->classHour;
        $model->is_check          =  0;
        $model->sex               = $this->sex;
        $model->alias             = $this->alias;
        $model->work_url             = $this->work_url;
        $model->intro             = $this->intro;
        $model->params            = json_encode(['classTime'=>$this->classTime,'classAmount'=>$this->classAmount]);
        $model->pic               = $this->pic;
        $model->work_date         = $this->work_time;   //从业日期：2018-01-01
        if(!empty($this->work_time)){
            $model->work_time     = date("Y",time()) - date("Y",strtotime($this->work_time));   //工作时间：1年
        }else{
            $model->work_time     = NULL;
        }
        $model->company_id        = isset($this->company) ? $this->company : $this->companyId;
        $model->venue_id          = isset($this->venue) ? $this->venue : $this->venueId;
        $model->fingerprint       = $this->fingerprint[0];
        $model->birth_time        = $this->birth_time;
        $model->identityCard      = $this->identityCard;
        if($model->save()){
            return true;
        }else{
            return $model->errors;
        }
    }
    /**
     * 云运动 - 后台- 获取场馆公司
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/4/25
     * @return boolean/object
     */
   public function getVenueData()
   {
       $organ = Organization::getOrganizationById($this->department);              //查询登录人员，所属公司信息
       $this->venueId = isset($organ['pid'])?$organ['pid']:0;
       $organ = Organization::getOrganizationById($this->venueId);
       $this->companyId = isset($organ['pid'])?$organ['pid']:0;
   }
}