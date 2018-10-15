<?php
namespace backend\models\v2;

use common\models\base\Employee;
use common\models\base\Admin;
use yii\base\Model;
use common\models\base\MessageCode;
class RetrievePasswordForm extends Model
{
    public $username;           //用户名或者工号
    public $mobile;             //手机号
    public $code;               //验证码（系统生成）
    public $newCode;            //验证码(用户输入)
    public $password;           //密码
    public $confirmPwd;         //确认密码

    /**
     * 员工 - 重置密码 - 验证规则
     * @author  Huang pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @return array
     */
    public function rules()
    {
        return [
            ['username','trim'],
            ['username','required','message'=>'工号不能为空！'],
            ['username', 'exist', 'targetClass' => '\common\models\base\Admin', 'message' => '您的工号不存在！'],
            ['username','string','max'=>200],
            
            ['mobile','trim'],
            ['mobile','required','message'=>'手机号不能为空！'],
            ['mobile', 'exist', 'targetClass' => '\common\models\base\Employee', 'message' => '您还未注册！'],
            ['mobile','string','max'=>200],

            ['newCode','trim'],
            ['newCode','required','message'=>'验证码不能为空！'],
            ['newCode','compare','compareAttribute'=>'code','message'=>'验证码错误'],
            ['newCode','newCodeTime'],

            ['password','trim'],
            ['password','required','message'=>'密码不能为空'],
            ['password','string','min'=>6,'max'=>255],

            ['confirmPwd','trim'],
            ['confirmPwd','required','message'=>'确认密码不能为空'],
            ['confirmPwd','string','min'=>6,'max'=>255],

            ['password','compare','compareAttribute'=>'confirmPwd','message'=>'两次密码输入不一致！'],
        ];
    }
    /**
     * 员工 - 重置密码 - 验证码
     * @author  Huang pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @inheritdoc
     */
    public function loadCode()
    {
        $temp = $this->getCode();
        $this->code = $temp['code'];
    }
    /**
     * @云运动 - 重置密码 - 获取验证码
     * @author  Huang pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @inheritdoc
     */
    public function getCode()
    {
        return MessageCode::find()->where(['mobile'=>$this->mobile])->orderBy('id DESC')->asArray()->one();
    }
    /**
     * @云运动 - 重置密码 - 验证码验证
     * @author  Huang pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @inheritdoc
     */
    public function newCodeTime($attribute)
    {
        $temp = $this->getCode();
        $time = $temp['create_at'];
        $num = time() - $time;
        if ($num > 300000) {
            $this->addError($attribute, '验证码已失效！');
        }
    }
    /**
     * @云运动 - 员工 - 重置密码
     * @author  Huang pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @return array|bool
     */
    public function setRetrieveSave()
    {
        $employee = Employee::findOne([
            'mobile' => $this->mobile,
        ]);                                         //查询手机号是否存在于员工表，
        if (!$employee) {
            return false;
        }
        $admin                = Admin::findOne(['username' => $this->username]);
        $admin->password_hash = $this->setPassword($this->password);
        if($admin->save()){
            $this->delCode();
            return true;
        }else{
            return $admin->errors;
        }
    }

    /**
     * @云运动 - 员工 - 重置密码
     * @author  Huang pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @param $password
     * @return string
     * @throws \yii\base\Exception  //加密过的密码
     */
    public function setPassword($password)
    {
        return  $this->password = \Yii::$app->security->generatePasswordHash($password);
    }
    /**
     * @云运动 - 后台 - 删除验证码
     * @author  Huang pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @inheritdoc
     */
    public function delCode()
    {
        $code = MessageCode::findOne(['mobile'=>$this->mobile]);
        $del  = $code->delete();
        return $del;
    }
}