<?php
/**
 * Created by PhpStorm.
 * User: Xin Wei
 * Date: 2018/8/7
 * Time: 19:16
 * Desc:公众号注册公司信息
 */
namespace wechat\controllers;

use common\models\base\MessageCode;
use common\models\Func;
use wechat\models\CompanyForm;
use \yii\web\Controller;
use Yii;

class CompanyController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @describe 注册公司信息
     * @author <xinwei@itsport.club>
     * @createAt 2018-08-08
     * @return string
     */
    public function actionSignUp()
    {
        $post = Yii::$app->request->post();
        $model = new CompanyForm();
        if ($model->load($post, '')) {
            $model->loadCode();
            $data = $model->GenerateCompany();
            return json_encode($data);
        }
        return json_encode($model);
    }

    public function actionIndex()
    {
        return $this->render('/company/register', ['a' => 1]);
    }

    public function actionComplete()
    {
        return $this->render('/company/registerComplete');
    }
    /**
     * @describe 发送验证码
     * @author <xinwei@itsport.club>
     * @createAt 2018-08-08
     * @return array
     */
    public function actionCreateCode()
    {
        $mobile = Yii::$app->request->post();
        if (!isset($mobile) && !isset($mobile['mobile']) && empty($mobile['mobile'])) {
            $return = ['code' => 0,'status' => 'error', 'data' => '请填写正确的手机号'];
            return json_encode($return);
        }
        if (!(Func::validPhone($mobile['mobile']))) {
            $return = ['code' => 0, 'status' => 'error', 'message' => '请填写正确的手机号!'];
            return json_encode($return);
        }
        $code = mt_rand(100000, 999999);
        $session = new MessageCode();
        $session->mobile = $mobile['mobile'];
        $session->code = $code;
        $session->create_at = time();
        if ($session->save()) {
            Func::sendCode($mobile['mobile'], $code);
            $return = ['code' => 1, 'status' => 'success', 'data' => $code];
            return json_encode($return);
        }
        $return = Func::setReturnMessageArr($session->errors, '发送失败');
        $arr = ['code' => 0, 'status' => 'error', 'message' => $return, 'data' => ['发送失败']];
        return json_encode($arr);
    }
}