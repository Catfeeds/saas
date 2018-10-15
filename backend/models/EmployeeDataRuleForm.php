<?php
namespace backend\models;
use common\models\base\Employee;
use yii\base\Model;

/**
 * @云运动 - 后台 - 混合卡种表单验证
 * @author Huang Pengju <huangpengju@itsports.club>
 * @create 2017/4/13
 */
class EmployeeDataRuleForm extends Model
{
    public $coachName;                               //教练姓名
    public $depId;                                   //部门id
    public $position;                                //职位
    public $mobile;                                  //手机号
    public $email;                                   //邮箱
    public $salary;                                  //薪资
    public $intro;                                   //个人简介
    /**
     * @云运动 - 团课添加教练 - 信息规则
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     */
    public function rules()
    {
        return [
            [['coachName','position','intro'],'trim'],
            [['coachName','depId'],'required'],
            ['email','email'],
            [['coachName','mobile','email','position'], 'string', 'max' => 200],
            [['depId'],'integer'],
            [['salary'], 'number'],
            [['intro'],'string']
        ];
    }

    /**
     * @云运动 - 团课添加教练 - 信息添加
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * @return array|bool
     */
    public function saveCoachData()
    {
        $employee                    = new Employee();                                           //员工模型类
        $employee->name              = $this->coachName;                                         //教练姓名
        $employee->organization_id   = $this->depId;                                             //部门id
        $employee->position          = $this->position;                                          //职位
        $employee->mobile            = $this->mobile ? $this->mobile : NULL;                    //手机号
        $employee->email             = $this->email;                                             //邮箱
        $employee->salary            = $this->salary;                                            //薪资
        $employee->intro             = $this->intro;                                            //个人简介
        $employee->create_id         = \Yii::$app->user->identity->id;                           //创建人ID
        $employee->created_at        = time();                                                   //创建时间
        if($employee->save()){
            return true;
        }else{
            return $employee->errors;
        }
    }
}