<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\Admin;

class PasswordDataForm extends Model
{
    public $id;            //管理员表id
    public $oldPassword;   //旧密码
    public $password;      //新密码
    public $rePassword;    //确认密码
    public $passwordHash;
    const PAS = 'rePassword';





    /**
     * @云运动 - 后台 - 新增角色验证规则
     * @create 2017/6/16
     * @return array
     */
    public function rules()
    {
        return [
            [['oldPassword','password','rePassword'], 'required'],
            [['id','oldPassword','password','rePassword','passwordHash'], 'safe'],
            ['password', 'compare', 'compareAttribute' => self::PAS, 'message' => '两次输入的密码不一致！'],
            ['oldPassword','validatePassword']
        ];
    }




    /**
     * 后台 - 登录 - 验证密码（Validates the password）
     * @author  lihuien <lihuien@itsport.club>
     * @create 2017/3/30
     * @param $attribute
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $admin = Admin::findOne(['id' => $this->id]);
            if ($admin) {
                if(!\Yii::$app->security->validatePassword($this->oldPassword,$admin['password_hash'])){
                    $this->addError($attribute, '旧密码错误');
                }elseif(\Yii::$app->security->validatePassword($this->password,$admin['password_hash'])){
                    $this->addError($attribute, '旧密码与新密码一致');
                }
            }
        }
    }
    public function updatePassword()
    {
        if(!empty($this->password)){
            $model = Admin::findOne(['id' => $this->id]);
            $this->setPassword($this->password);
            $model->password_hash = $this->passwordHash;
            $model->updated_at    = time();
            if ($model->save()) {
                return true;
            } else {
                return $model->errors;
            }
        }else{
            return false;
        }
    }
    public function getCreate()
    {
        $create = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $create = isset($create->id)?intval($create->id):0;
        return $create;
    }
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {

          $this->passwordHash = Yii::$app->security->generatePasswordHash($password);
    }


}