<?php
namespace backend\models;

use Yii;
use yii\base\Model;
/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $mobile;
    public $code;
    public $newCode;
    public $password;
    public $rePassword;
    public $password_reset_token;
    const MOB    = 'mobile';
    const CODE   = 'code';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [self::MOB, 'trim'],
            [self::MOB, 'required', 'message' => '手机号不能为空！'],
            [self::MOB, 'string', 'max' => 200],
            [self::MOB, 'exist', 'targetClass' => '\common\models\base\Employee', 'message' => '您还未注册！'],
            [self::MOB, 'setMobile'],

            [self::CODE, 'trim'],
            [self::CODE, 'required', 'message' => '验证码不能为空！'],
            [self::CODE, 'compare', 'compareAttribute' => 'newCode', 'message' => '验证码错误！'],
            [self::CODE, 'newCodeTime'],

            ['password', 'trim'],
            ['password', 'required', 'message' => '密码不能为空！'],
            ['password', 'string', 'min' => 6, 'max' => 255],

            ['rePassword', 'compare', 'compareAttribute' => 'password', 'message' => '两次输入的密码不一致！'],
        ];
    }

    /**
     * @云运动 - 后台 - 重置密码 - 验证码
     * @author Zhu Mengke <zhumengke@itsports.club>
     * @create 2017/4/6
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
     * @云运动 - 后台 - 重置密码 - 验证码验证
     * @author Zhu Mengke <zhumengke@itsports.club>
     * @create 2017/4/6
     * @inheritdoc
     */
    public function newCodeTime($attribute)
    {
        $temp = Yii::$app->session->get('sms');
        $time = $temp['time'];
        $num = time() - $time;
        if ($num > 300) {
            $this->addError($attribute, '验证码已失效');
        }
    }

    /**
     * @云运动 - 后台 - 重置密码 - 手机号验证
     * @author Zhu Mengke <zhumengke@itsports.club>
     * @create 2017/4/6
     * @inheritdoc
     */
    public function setMobile($attribute)
    {
        $temp = Yii::$app->session->get('sms');
        $mobile = $temp['mobile'];
        if ($this->mobile != $mobile) {
            $this->addError($attribute, '手机号错误，请填写接收验证码的手机号哟！');
        }
    }

    /**
     * @云运动 - 后台 - 重置密码
     * @author Zhu Mengke <zhumengke@itsports.club>
     * @create 2017/4/6
     * @inheritdoc
     */
    public function loadPassword()
    {
        $employee = Employee::findOne([
            'mobile' => $this->mobile,
        ]);

        if (!$employee) {
            return false;
        }

        if (isset($employee->admin_user_id)) {
            $admin = Admin::findOne(['id' => $employee->admin_user_id]);
            $admin->setPassword($this->password);
            $admin->generatePasswordResetToken();
            if($admin->save()) {
                return true;
            }
        }
        return false;

    }
}