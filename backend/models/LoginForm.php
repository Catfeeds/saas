<?php
namespace backend\models;
use Yii;
use yii\base\Model;

/**
 * 后台 - 登录 - 登录表单（登录表单）
 *@create author Hou Kaixin houkaixin@itsport.club
 *@create 2017/3/30
 */
class LoginForm extends Model
{
    public  $username;
    public  $password;
    public  $rememberMe = true;
    private $_admin;
    /**
     * 后台 - 登录 - 验证规则（Validates the password）
     *@create author Hou Kaixin houkaixin@itsport.club
     *@create 2017/3/30
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }
    /**
     * 后台 - 登录 - 验证密码（Validates the password）
     *@create author Hou Kaixin houkaixin@itsport.club
     *@create 2017/3/30
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $admin = $this->getAdmin();
            if (!$admin || !$admin->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或者密码出错');
            }
        }
    }
    /**
     * 后台 - 登录 - 数据执行登录（Logs in a user using the provided username and password）
     *@create author Hou Kaixin houkaixin@itsport.club
     *@create 2017/3/30
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getAdmin(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }
    /**
     * 后台 - 登录 - 识别账号（Finds user by [[username]]）
     *@create author Hou Kaixin houkaixin@itsport.club
     *@create 2017/3/30
     */
    protected function getAdmin()
    {
        if ($this->_admin === null) {
            $this->_admin = Admin::findByUsername($this->username);
        }
        return $this->_admin;
    }

}
