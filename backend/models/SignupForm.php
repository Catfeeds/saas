<?php
namespace backend\models;
use common\models\base\Employee;
use Yii;
use yii\base\Model;

/**
 * @云运动 - 后台 - 注册表单
 * @author Zhu Mengke <zhumengke@itsports.club>
 * @create 2017/3/29
 * @inheritdoc
 */
class SignupForm extends Model
{
    public $username;                //用户名
    public $mobile;                  //手机号
    public $code;                    //填写的验证码
    public $newCode;                 //生成的验证码
    public $name;                    //真实姓名
    public $organization_id;        //部门id
    public $password;                //密码
    public $rePassword;              //重复密码
    public $auth_key;
    public $password_reset_token;
    public $company_id;              //公司id
    public $venue_id;                //场馆id
    const USER = 'username';
    const MOB  = 'mobile';
    const CODE = 'code';
    const PAS = 'password';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [self::USER, 'trim'],
            [self::USER, 'required'],
            [self::USER, 'unique', 'targetClass' => '\common\models\base\Admin', 'message' => '用户名已注册！'],
            [self::USER, 'string', 'min' => 3, 'max' => 255],

            [self::MOB, 'trim'],
            [self::MOB, 'required'],
            [self::MOB, 'unique', 'targetClass' => '\common\models\base\Employee', 'message' => '手机号已注册！'],
            [self::MOB, 'string', 'max' => 200],
            [self::MOB, 'setMobile'],

            [self::CODE, 'trim'],
            [self::CODE, 'required', 'message' => '验证码不能为空！'],
            [self::CODE, 'compare', 'compareAttribute' => 'newCode', 'message' => '验证码错误！'],
            [self::CODE, 'newCodeTime'],

            ['name', 'trim'],
            ['name', 'required', 'message' => '姓名不能为空！'],
            ['name', 'string', 'min' => 2, 'max' => 200],

            [self::PAS, 'trim'],
            [self::PAS, 'required', 'message' => '密码不能为空！'],
            [self::PAS, 'string', 'min' => 6, 'max' => 255],

            ['rePassword', 'compare', 'compareAttribute' => self::PAS, 'message' => '两次输入的密码不一致！'],
            [['organization_id','company_id','venue_id'],'safe']
        ];
    }

    /**
     * @云运动 - 后台 - 注册验证码
     * @author Zhu Mengke <zhumengke@itsports.club>
     * @create 2017/4/1
     * @inheritdoc
     */
    public function loadCode()
    {
        if (Yii::$app->session->has('sms')) {
            $temp = Yii::$app->session->get('sms');
            $this->newCode = $temp['code'];
        }
    }

    /**
     * @云运动 - 后台 - 注册验证码验证
     * @author Zhu Mengke <zhumengke@itsports.club>
     * @create 2017/4/1
     * @inheritdoc
     */
    public function newCodeTime($attribute)
    {
        $temp = Yii::$app->session->get('sms');
        $time = $temp['time'];
        $num = time() - $time;
        if ($num > 300) {
            $this->addError($attribute, '验证码已失效！');
        }
    }

    /**
     * @云运动 - 后台注册 - 手机号验证
     * @author Zhu Mengke <zhumengke@itsports.club>
     * @create 2017/4/6
     * @inheritdoc
     */
    public function setMobile($attribute)
    {
        $temp = Yii::$app->session->get('sms');
        $mobile = $temp['mobile'];
        if ($this->mobile != $mobile) {
            $this->addError($attribute, '请填写接收验证码的手机号');
        }
    }

    /**
     * @云运动 - 后台 - 注册信息存数据库
     * @author Zhu Mengke <zhumengke@itsports.club>
     * @create 2017/3/30
     * @inheritdoc
     */
    public function signup()
    {
        //事务
        $transaction = Yii::$app->db->beginTransaction();
        try {
            //插入$admin表中的数据
            $admin = new Admin();
            $admin->username = $this->username;
            $admin->status   = 10;
            $admin->setPassword($this->password);
            $admin->generateAuthKey();
            $admin->generatePasswordResetToken();
            $admin->created_at = time();
            $admin->updated_at = time();
            $admin->company_id = $this->company_id;
            $admin->venue_id   = $this->venue_id;
            $admin = $admin->save() ? $admin : $admin->errors;
            if(!isset($admin->id)){
                throw new \Exception('操作失败');
            }
            //插入$admin表对应的$employee中的数据
            $employee = new Employee();
            $employee->admin_user_id    = $admin->id;
            $employee->create_id        = 0;              //0表示没有创建人
            $employee->created_at       = time();
            $employee->name             = $this->name;
            $employee->mobile           = $this->mobile;
            $employee->organization_id  = (isset($this->organization_id) && !empty($this->organization_id)) ? $this->organization_id : 0;
            $employee->is_check         = 1;
            $employee->is_pass          = 0;
            $employee->company_id       = $this->company_id;
            $employee->venue_id         = $this->venue_id;
            if(!$employee->save()){
                throw new \Exception('操作失败');
            }
            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }

        } catch (\Exception $e) {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            return  $e->getMessage();
        }
    }

}
