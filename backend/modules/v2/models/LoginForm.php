<?php
namespace backend\modules\v2\models;

use backend\modules\v2\models\Admin;
use yii\base\Model;
class LoginForm extends Model
{
    public $username;           //工号（用户名）
    public $password;           //密码
    public $employee = [];      //员工
    public $admin = [];
    /**
     * 员工 - 登录 - ipad - 验证规则
     * @author  Huang Pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @return array
     */
    public function rules()
    {
        return[
            ['username','required','message' => '工号不能为空'],
            ['password','required','message' => '密码不能为空'],
            ['password','validatePassword']
        ];

    }
    /**
     * 员工 - 登录 - 验证密码（Validates the password）
     * @author  Huang Pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @param $attribute
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $admin = $this->getAdminOne();           //获取员工信息
            if ($admin) {
                if(!\Yii::$app->security->validatePassword($this->password,$admin['password_hash'])){
                    $this->addError($attribute,'用户名或者密码出错');
                }
            }else{
                $this->addError($attribute,'用户不存在');
            }
            $this->getEmployeeOne();
            if(!empty($this->employee)){
                if( $this->employee['status'] == 2){
                    $this->addError($attribute,'员工已离职');
                }
            }else{
                $this->addError($attribute,'用户不存在');
            }
        }
    }
    /**
     * 员工 - 登录 - 控控制器验证
     * @author  Huang Pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     */
    public function validateLogin()
    {
        if($this->validate()){
            return $this->getEmployeeOne();
        }
        return false;
    }
    /**
     * 员工 - 登录 - 获取员工数据
     * @author  Huang Pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @return array //查询的员工信息
     */
    public function getEmployeeOne()
    {
        if (empty($this->employee)) {
            $admin = new Admin();
            $this->employee =  $admin->getEmployeeOneData($this->username);
        }
        return $this->employee;
    }
    /**
     * 员工 - 登录 - 获取员工数据
     * @author  Huang Pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @return array //查询的员工信息
     */
    public function getAdminOne()
    {
        if (empty($this->admin)) {
            $this->admin =  Admin::findOne(['username'=>$this->username]);
        }
        return $this->admin;
    }
}