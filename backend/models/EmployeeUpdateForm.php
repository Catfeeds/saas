<?php
namespace backend\models;
use common\models\base\Admin;
use yii\base\Model;
use common\models\base\Employee;

/**
 * @云运动 - 后台 - 员工修改表单验证
 * @author huanghua <huanghua@itsports.club>
 * @create 2017/4/26
 */
class EmployeeUpdateForm extends Model
{
      public $employeeName;
      public $employeePosition;
      public $employeeSalary;
      public $classHour;
      public $classTime;
      public $classAmount;
      public $EmployeeId;
      public $department;
      public $organization;
      public $employeeMobile;
      public $employeeSex;
      public $employeeAlias;
      public $employeeStatus;
      public $employeeIntro;
      public $pic;
      public $work_time;
      public $work_url;
      public $companyId;
      public $venueId;
      public $fingerprint;
      public $employeeAge;
      public $birth_time;
      public $identityCard;
    /**
     * @云运动 - 后台 - 员工表单修改验证(规则验证)
     * @create 2017/4/8
     * @return array
     */
    public function rules()
    {
        return [
            [["employeeName","EmployeeId","organization","employeeStatus"], 'required'],
            [['classHour','classTime','classAmount',"EmployeeId","organization","employeeMobile","employeeStatus","employeeAge"], 'integer'],
            [["birth_time","identityCard","classTime","classAmount",'employeeMobile','classHour','employeeSex','employeePosition','work_url','employeeAlias','employeeStatus','employeeIntro','pic','work_time','employeeSalary','fingerprint',"work_time","employeeAge"],"safe"]
        ];
    }
    /**
     * 云运动 - 员工管理 - 点击修改单条信息
     * @author Huanghua <Huanghua@itsports.club>
     * @create 2017/4/20
     * @param
     * @return boolean/object
     */
    public function updateData(){
        $this->getVenueData();
        //员工数据信息修改
        $model = Employee::findOne($this->EmployeeId);
        $admin = Admin::findOne(['id' => $model['admin_user_id']]);
        if(!empty($admin)){
            if($this->employeeStatus == 2){
                $admin->status = 10;
                $admin = $admin->save() ? $admin : $admin->errors;
                if(!isset($admin->id)){
                    throw new \Exception('操作失败');
                }
            }else{
                $admin->status = 20;
                $admin = $admin->save() ? $admin : $admin->errors;
                if(!isset($admin->id)){
                    throw new \Exception('操作失败');
                }
            }
        }
        $model->name             = $this->employeeName;
        $model->status           = $this->employeeStatus;
        $model->organization_id  = $this->organization;
        $model->position         = $this->employeePosition;
        $model->salary           = (int)$this->employeeSalary;
        $model->mobile           = $this->employeeMobile ? $this->employeeMobile : NULL;
        $model->class_hour       = $this->classHour;
        $model->sex              = $this->employeeSex;
        $model->alias            = $this->employeeAlias;
        $model->work_url            = $this->work_url;
        $model->intro            = $this->employeeIntro;
        $model->pic              = $this->pic;
        $model->work_date        = $this->work_time;   //从业日期：2018-01-01
        if(!empty($this->work_time)){
            $model->work_time    = date("Y",time()) - date("Y",strtotime($this->work_time));   //工作时间：1年
        }else{
            $model->work_time    = NULL;
        }
        $model->params           = json_encode(['classTime'=>$this->classTime,'classAmount'=>$this->classAmount]);
        $model->company_id       = $this->companyId;
        $model->venue_id         = $this->venueId;
        $model->fingerprint      = $this->fingerprint[0];
        $model->age              = $this->employeeAge;
        $model->birth_time       = $this->birth_time;
        $model->identityCard     = $this->identityCard;
        //var_dump($model->status);die;
        //如果该员工离职 注销其笔下的账号
        if($model->status == 2){
            //查询该用户下是否有账号
            $m = Employee::findOne($this->EmployeeId);
            $admin = Admin::findOne(['id' => $m['admin_user_id']]);
            //将其注销
            if(!empty($admin)){
                $admin->status = 30;
                $admin = $admin->save() ? $admin : $admin->errors;
                if(!isset($admin->id)){
                    throw new \Exception('操作失败');
                }
            }
        }
        if ($model->save()) {
            return true;
        }else{
            return $model->errors;
        }
    }
    /**
     * 云运动 - 后台- 获取场馆公司
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/6/9
     * @return boolean/object
     */
    public function getVenueData()
    {
        $organ = Organization::getOrganizationById($this->organization);              //查询登录人员，所属公司信息
        $this->venueId = isset($organ['pid'])?$organ['pid']:0;
        $organ = Organization::getOrganizationById($this->venueId);
        $this->companyId = isset($organ['pid'])?$organ['pid']:0;
    }



}