<?php
namespace backend\models;

use common\models\base\Employee;
use yii\base\Model;

class AssignAdminForm extends Model
{
    public $username;
    public $password;
    public $employeeId;
    public $venueId;
    public $mobile;
    public $level;
    public $adminId;

    public function __construct(array $config,$scenario)
    {
        $this->scenario = $scenario;
        parent::__construct($config);
    }

    public function scenarios()
    {
        return [
            'insert'=>['username','password','employeeId','venueId','mobile','level','scenario'],
            'update'=>['username','scenario','password','employeeId','venueId','mobile','level','adminId']
        ];
    }

    public function rules()
    {
        return [
            ['username','required','message'=>'用户名字不能为空','on'=>'insert'],
            ['username', 'unique', 'targetClass' => '\common\models\base\Admin', 'message' => '用户名已注册！','on'=>'insert'],
            ['password','required','message'=>'密码不能为空','on'=>'insert'],
            [['employeeId','level','scenario','adminId','venueId','mobile'],'safe'],
        ];
    }

    /**
     * 员工 - 分配权限
     * @update 2017/6/5
     * @return array|bool|string
     * @throws \yii\db\Exception
     */
    public function saveAssign()
    {
        //事务   ['level','required','message'=>'权限不能为空'],
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $employee = Employee::findOne(['id'=>$this->employeeId]);
            $admin = new Admin();
            $admin->username = $this->username;
            $admin->status   = 20;
            $admin->setPassword($this->password);
            $admin->generateAuthKey();
            $admin->generatePasswordResetToken();
            $admin->created_at = time();
            $admin->updated_at = time();
            $admin->level      = $this->level;
            $admin->company_id = $employee->company_id;
            $admin = $admin->save() ? $admin : $admin->errors;
            if (!isset($admin->id)) {
                throw new \Exception('操作失败');
            }

            $employee->admin_user_id   = $admin->id;
            $employee->organization_id = $this->venueId;
            $employee->mobile          = $this->mobile;
           if(!$employee->save()){
               throw new \Exception('操作失败');
           }
           if($transaction->commit() === null){
               return true;
           }
            if(!empty($admin->errors) && is_array($admin->errors)){
                return $admin->errors;
            }
            return $employee->errors;
        }catch (\Exception $e) {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            return  $e->getMessage();
        }
    }

    /**
     * 员工 - 修改权限
     * @update 2017/6/5
     * @return array|bool|string
     * @throws \yii\db\Exception
     */
    public function saveUpdate()
    {
        //事务   ['level','required','message'=>'权限不能为空'],
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $employee = Employee::findOne(['id'=>$this->employeeId]);
            $admin = Admin::findOne(['id'=>$this->adminId]);
            $admin->updated_at = time();
            $admin->level      = $this->level;
            $admin->company_id = $employee->company_id;
            $admin = $admin->save() ? $admin : $admin->errors;
            if (!isset($admin->id)) {
                throw new \Exception('操作失败');
            }

            $employee->organization_id = $this->venueId;
            $employee->mobile          = $this->mobile;
            if(!$employee->save()){
                throw new \Exception('操作失败');
            }
            if($transaction->commit() === null){
                return true;
            }
            if(!empty($admin->errors) && is_array($admin->errors)){
                return $admin->errors;
            }
            return $employee->errors;
        }catch (\Exception $e) {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            return  $e->getMessage();
        }
    }
}