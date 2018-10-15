<?php
/**
 * Created by PhpStorm.
 * User: Xin Wei
 * Date: 2018/8/7
 * Time: 20:17
 * Desc:公众号注册公司信息
 */
namespace wechat\models;

use common\models\base\Company;
use common\models\base\MessageCode;
use common\models\Func;
use yii\base\Model;

class CompanyForm extends Model
{
    public $companyName;            //公司名称
    public $username;               //负责人姓名
    public $mobile;                 //手机号
    const  MOB = 'mobile';         //手机号
    public $storeNum;             //店面数量
    public $area;                 //地区
    public $address;             //详细地址
    public $code;                //验证码
    public $newCode;            //输入的验证码
    public $type;               //健身房类型(1-综合，2-瑜伽，3-舞蹈，4-私教工作室)
    /**
     * saas - 注册公司信息 -  表单验证规则
     * @author xinwei <xinwei@itsports.club>
     * @create 2018/08/07
     * @return array
     */
    public function rules()
    {
        return [
            [['companyName', 'username','mobile', 'storeNum', 'area','address','code','type'], 'trim'],
            ['companyName', 'required', 'message' => '公司名称不能为空'],
            ['username', 'required', 'message' => '用户名不能为空'],
            [self::MOB, 'required', 'message' => '手机号不能为空'],
            ['code', 'required', 'message' => '验证码不能为空！'],
            [self::MOB, 'required', 'message' => '手机号不能为空'],
            [self::MOB, 'trim'],
            [self::MOB,'string', 'max' => 32],
            ['code', 'trim'],
            ['code', 'required', 'message' => '验证码不能为空！'],
            ['code', 'compare', 'compareAttribute' => 'newCode', 'message' => '验证码错误！'],
        ];
    }
    /**
     * saas - 注册公司信息 -  注册
     * @author xinwei <xinwei@itsports.club>
     * @create 2018/08/08
     * @return array|bool
     */
    public function GenerateCompany()
    {
        if (!(Func::validPhone($this->mobile)))
            return ['code' => 0, 'status' => 'error', 'message' => '请填写正确的手机号!'];
        if (!$this->judgeIsRegister())
            return ['code' => 0,'status' => 'error','message' => '手机号已注册!'];
        if (!$this->newCodeTime())
            return ['code' => 0,'status' => 'error','message' => '验证码已失效!'];
        if ($this->validate()) {
            $transaction = \Yii::$app->db->beginTransaction();
            try {
                $model = new Company();
                $model->company_name = $this->companyName;
                $model->username = $this->username;
                $model->mobile = $this->mobile;
                $model->store_num = $this->storeNum;
                $model->area = $this->area;
                $model->address = $this->address;
                $model->type = $this->type;
                if (!$model->save()) return $model->errors;
                $this->delCode();
                if ($transaction->commit() === NULL) {
                    return ['code' => 1, 'status' => 'success', 'message' =>'已提交，审核结果将会在1-3个工作日以短信方式通知!'];
                } else {
                    return ['code' => 0,'status' => 'error','message' => '网络错误，请稍后重试!'];
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                return $e->getMessage();
            }
        }
        return $this->errors;
    }
    /**
     * @saas - 公众号 - 检测该手机号是否注册过
     * @author xinwei<xinwei@itsports.club>
     * @create 2018/08/08
     * @inheritdoc
     */
    public function judgeIsRegister(){
        $endResult = Company::find()
            ->where(['mobile' => $this->mobile])
            ->select(['id'])
            ->asArray()
            ->one();
        if (empty($endResult)) {
            return true;
        }
        return false;
    }
    /**
     * @saas - 公众号 - 注册验证码
     * @author xinwei <xinwei@itsports.club>
     * @create 2018/08/08
     * @inheritdoc
     */
    public function loadCode()
    {
        $temp = $this->getCode();
        $this->newCode = $temp['code'];
    }
    /**
     * @saas - 公众号 - 注册验证码验证
     * @author xinwei <xinwei@itsports.club>
     * @create 2018/08/08
     * @inheritdoc
     */
    public function newCodeTime()
    {
        $temp = $this->getCode();
        $time = $temp['create_at'];
        $num = time() - $time;
        if ($num > 300000) {
            return false;
        }
        return true;
    }
    /**
     * @saas - 公众号 - 获取验证码
     * @author xinwei <xinwei@itsports.club>
     * @create 2017/4/1
     * @inheritdoc
     */
    public function getCode()
    {
        $arr = MessageCode::find()
            ->where(['mobile' => $this->mobile])
            ->orderBy('create_at DESC')
            ->asArray()
            ->one();
        return $arr;
    }
    /**
     * @saas - 公众号 - 删除验证码
     * @author xinwei <xinwei@itsports.club>
     * @create 2018/08/08
     * @inheritdoc
     */
    public function delCode()
    {
        $code = MessageCode::findOne(['mobile' => $this->mobile]);
        if ($code) {
            $del  = $code->delete();
            return $del;
        }
        return NULL;
    }
}