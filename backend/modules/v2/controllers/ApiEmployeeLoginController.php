<?php

namespace backend\modules\v2\controllers;

use backend\modules\v2\models\Admin;
use backend\modules\v2\models\LoginForm;
use backend\models\v2\RetrievePasswordForm;
use common\models\Func;
use yii\rest\ActiveController;
use yii\web\Response;
use common\models\base\MessageCode;
class ApiEmployeeLoginController extends ActiveController
{
    public $modelClass = 'backend\modules\v2\models\Admin';            //去访问接口的模型路径

    /**
     * @云运动 - 用户登陆 - 行为
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/9
     * @return array
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                // restrict access to
                'Access-Control-Request-Method' => ['*'],
                // Allow only POST and PUT methods
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
        return $behaviors;
    }
    /**
     * @云运动 - 后台 - 用户登陆
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/9
     * @inheritdoc
     */
    public function actionLogin()
    {
        $post = \Yii::$app->request->post();
        $model = new LoginForm();
        if($model->load($post,'')){
            if($member = $model->validateLogin()){
                $result = ['status'=>'success','message'=>'登录成功','data'=>$member];
                return $result;
            }
            $return = Func::setReturnMessageArr($model->errors,'登录失败');
            $result = ['status'=>'error','message'=>$return,'data'=>$model->errors];
            return $result;
        }
        $result = ['status'=>'error','message'=>'登录失败','data'=>$model->errors];
        return $result;
    }
    /**
     * @云运动 - 找回密码 - 生成验证码
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/1
     * @inheritdoc
     */
    public function actionCreateCode()
    {
        $mobile = \Yii::$app->request->post();
        if(!isset($mobile) && !isset($mobile['mobile']) && !empty($mobile['mobile'])){
            return ['status' => 'error','data' => '请填写正确的手机号'];
        }
        $code = mt_rand(100000,999999);
        $session = new MessageCode();
        $session->mobile = $mobile['mobile'];
        $session->code   = $code;
        $session->create_at = time();
        if($session->save()){
            Func::sendCode($mobile['mobile'],$code);
            return ['status'=>'success','data'=>$code];
        }
        return ['status'=>'error','data'=>['发送失败']];
    }
    /**
     * @云运动 - 后台 - 找回密码
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/9
     * @inheritdoc
     */
    public function actionRetrievePassword()
    {
        $post = \Yii::$app->request->post();
        $model = new RetrievePasswordForm();

        if($model->load($post,'')){
            $model->loadCode();
            if($model->validate()){
                $sign = $model->setRetrieveSave();
                if($sign === true){
                    return ['status'=>'success','message'=>'修改成功'];
                }
                return ['status'=>'error','message'=>'修改失败','data'=>$sign];
            }
            return ['status'=>'error','message'=>'修改失败','data'=>$model->errors];
        }
        $result = ['status'=>'error','message'=>'修改失败','data'=>$model->errors];
        return $result;
    }
    /**
     * @云运动 - 后台 - 找回密码
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/9
     * @inheritdoc
     */
    public function actionGetEmployeeOne($id)
    {
        $model = new Admin();
        $data  = $model->getEmployeeOneInfo($id);
        $result = ['status'=>'success','message'=>'获取成功','data'=>$data];
        return $result;
    }
}
