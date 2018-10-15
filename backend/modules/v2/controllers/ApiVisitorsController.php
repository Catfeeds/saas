<?php

namespace backend\modules\v2\controllers;
use backend\models\v2\VisitorsForm;
use yii\rest\ActiveController;
use common\models\base\MessageCode;
use common\models\Func;
class ApiVisitorsController extends ActiveController
{
    public $modelClass = 'backend\modules\v2\models\Admin';            //去访问接口的模型路径
    /**
     * @云运动 - 访客 - 生成验证码
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/1
     * @inheritdoc
     */
    public function actionCreateCode()
    {
        $mobile = \Yii::$app->request->post();
        if(!isset($mobile) && !isset($mobile['visitorMobile']) && !empty($mobile['visitorMobile'])){
            return ['status' => 'error','data' => '请填写正确的手机号'];
        }
        $code = mt_rand(100000,999999);
        $session = new MessageCode();
        $session->mobile = $mobile['visitorMobile'];
        $session->code   = $code;
        $session->create_at = time();
        if($session->save()){
            Func::sendCode($mobile['visitorMobile'],$code);
            return ['status'=>'success','data'=>$code];
        }
        return ['status'=>'error','data'=>['发送失败']];
    }
    /**
     * @云运动 - API - 添加访客
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/9
     */
    public function actionSetVisitorsData()
    {
        $post     = \Yii::$app->request->post();
        $model    = new VisitorsForm();
        if($model->load($post,''))
        {
            $model->loadCode();     //获取验证码
            if($model->validate())
            {
                $visitor = $model->saveVisitorData();
                if($visitor === true)
                {
                    return ['status'=>'success','message'=>'添加成功'];
                }
                return ['status'=>'error','message'=>'添加失败','data'=>$visitor];
            }
            return ['status'=>'error','message'=>'添加失败','data'=>$model->errors];
        }
        return ['status'=>'error','message'=>'添加失败','data'=>$model->errors];
    }
}
