<?php

namespace backend\controllers;

use backend\models\Employee;
use Yii;
use backend\models\Organization;
use backend\models\SignupForm;
use backend\models\PasswordResetRequestForm;
use common\models\Func;
use backend\models\LoginForm;
class LoginController extends HomeController
{
    /**
     * @云运动 - 后台 - 查询数据
     * @author Zhu Mengke <zhumengke@itsports.club>
     * @create 2017/3/29
     * @inheritdoc
     */
    public function beforeAction($action)
    {
         $this->enableCsrfValidation = false;
         return parent::beforeAction($action);
    }
    /**
     * 前端 - 后台 - 登录页面
     * @return string
     * @auther:梁可可
     * create 2017-3-27
     */
    public function actionIndex()
    {
//         Yii::$app->cache->flush();
         Yii::$app->user->logout();
         $session = \Yii::$app->session;
         $session->removeAll();
         $session->destroy();
         if(\Yii::$app->user->isGuest)
         {
             return $this->render('index');
         }else{
             return $this->goHome();
         }
    }


    /**
     * 前端 - 后台 - 找回密码
     * @return string
     * @auther 梁可可
     * create 2017-3-27
     */
    public function actionPassword(){
        return $this->render('password');
    }

    /**
     *前端 - 后台 - 注册
     * @return string
     * auther 梁可可
     * create 2017-3-27
     */
   public function actionRegister(){
       return $this->render('register');
   }

    /**
     * @云运动 - 后台 - 查询数据
     * @author Zhu Mengke <zhumengke@itsports.club>
     * @create 2017/3/29
     * @inheritdoc
     */
    public function actionCloudOrganization()
    {
        $cloudOrganization = Organization::getCloudOrganization();
        return json_encode($cloudOrganization);
    }
    /**
     * @云运动 - 后台 - 注册
     * @author Zhu Mengke <zhumengke@itsports.club>
     * @create 2017/3/30
     * @inheritdoc
     */
    public function actionSignup()
    {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->loadCode();
            if($model->validate()){
                if ($model->signup()) {
                    return json_encode(['status' => 'success', 'data' => '我们会尽快审核，请耐心等待']);
                } else {
                    return json_encode(['status' => 'error', 'data' => $model->errors]);
                }
            }else {
                return json_encode(['status' => 'error', 'data' => $model->errors]);
            }
        }else{
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后端- 后台 - 登录验证
     * @return string
     * auther 侯凯新
     * create 2017-3-30
     */
   public function actionLogin()
   {
       // 直接跳转登录界面(如果不是游客)
       if(!Yii::$app->user->isGuest){
           return json_encode(['status' => 'success', 'data' => '登录成功']);
       }
       $session = \Yii::$app->session;
       $session->destroy();
       $model    = new LoginForm();
       //注销账号给出提示 stauts = 30
       if($model->load(Yii::$app->request->post()) && $model->login())
       {


           if(\backend\models\Admin::findByUsername(\Yii::$app->request->post()['LoginForm']['username'])->status == 30){
               return json_encode(['status' => 'not', 'data' => '该账号已被注销啊！请联系管理员']);
           }

           if($session->has('login')){
               $session->remove('login');
               $session->remove('venue');
           }
           if($session->has('AuthRole')){
               $session->remove('AuthRole');
           }
           return json_encode(['status' => 'success', 'data' => '登录成功']);
       }else{
           return json_encode(['status' => 'error', 'data' => $model->errors]);
       }
   }

    /**
     * @云运动 - 后台 - 注册生成验证码
     * @author Zhu Mengke <zhumengke@itsports.club>
     * @create 2017/4/1
     * @inheritdoc
     */
    public function actionCreateCode()
    {
        $mobile = \Yii::$app->request->post();
        //点击验证码之前判断该手机号下的账号是否被注销给出提示
        $user_id = Employee::find()->select('admin_user_id')->where(['mobile'=>$mobile])->asArray()->one();

        $status = \backend\models\Admin::find()->select('status')->where(['id'=>$user_id['admin_user_id']])->asArray()->one();
        if($status['status'] == 30){
            return json_encode(['status' => 'error', 'data' => '该账号已被注销，请联系管理员！']);
        }
        if(!isset($mobile) && !isset($mobile['mobile'])){
            return json_encode(['status' => 'error', 'data' => '请填写正确的手机号']);
        }

        $code = mt_rand(100000,999999);
        $time = time();
        $temp = [
            'code'   => $code,
            'time'   => $time,
            'mobile' => $mobile['mobile']
        ];
        $session = \Yii::$app->session;
        $session->set('sms',$temp);
        Func::sendCode($mobile['mobile'],$code);
        return json_encode(['status'=>'success','data'=>'验证码发送成功']);

    }

    /**
     * @云运动 - 后台 - 重置密码
     * @author Zhu Mengke <zhumengke@itsports.club>
     * @create 2017/4/5
     * @inheritdoc
     */
    public function actionResetPassword()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post())) {
            $model->loadCode();
            if($model->validate()){
                if ($model->loadPassword()) {
                    return json_encode(['status' => 'success', 'data' => '重置密码成功']);
                } else {
                    $return = Func::setReturnMessageArr($model->errors,'重置密码失败');
                    return json_encode(['status' => 'error', 'data' =>$return]);
                }
            }else {
                $return = Func::setReturnMessageArr($model->errors,'重置密码失败');
                return json_encode(['status' => 'error', 'data' =>$return]);
            }
        }else{
            $return = Func::setReturnMessageArr($model->errors,'重置密码失败');
            return json_encode(['status' => 'error', 'data' => $return]);
        }
    }
    /**
     * @api {get} /personnel/get-venue  获取公司
     * @apiVersion 1.0.0
     * @apiName  获取公司
     * @apiGroup  personnel
     * @apiPermission 管理员
     *
     * @apiDescription 获取公司<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/2<br>
     * <span><strong>调用方法：</strong></span>/personnel/get-venue
     *
     * @apiSampleRequest  http://qa.uniwlan.com/login/get-venue
     * @apiSuccessExample {json} 成功示例:
     * {
     * "venues": [
     * {
     * "id": "1",
     * "pid": "0",
     * "name": "我爱运动瑜伽健身俱乐部",
     * }
     *      ]
     * }
     * @apiErrorExample {json} 错误示例:
     * {
     * "venues": []
     * }
     */
    public function actionGetVenue()
    {
        $organ   = new Employee();
        $venue   = $organ->getOrganizationOption();
        return json_encode(['venue'=>$venue]);
    }
    /**
     * @api {get} /personnel/get-venue-data  获取场馆
     * @apiVersion 1.0.0
     * @apiName  获取场馆
     * @apiGroup  personnel
     * @apiPermission 管理员
     *
     * @apiDescription 获取场馆<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/2<br>
     * <span><strong>调用方法：</strong></span>/personnel/get-venue-data
     *
     * @apiSampleRequest  http://qa.uniwlan.com/login/get-venue-data
     * @apiSuccessExample {json} 成功示例:
     * {
     * "venues": [
     * {
     * "id": "2",
     * "pid": "1",
     * "name": "大上海馆",
     * }
     *      ]
     * }
     * @apiErrorExample {json} 错误示例:
     * {
     * "venues": []
     * }
     */
    public function actionGetVenueData()
    {
        $venueId = \Yii::$app->request->get('venueId');
        $organ   = new Employee();
        $venue   = $organ->getOrganizationData($venueId);
        return json_encode(['venue'=>$venue]);
    }
    /**
     * @api {get} /personnel/get-venue-all-data  获取所有场馆
     * @apiVersion 1.0.0
     * @apiName  获取所有场馆
     * @apiGroup  personnel
     * @apiPermission 管理员
     *
     * @apiDescription  获取所有场馆<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/2<br>
     * <span><strong>调用方法：</strong></span>/personnel/get-venue-all-data
     *
     * @apiSampleRequest  http://qa.uniwlan.com/login/get-venue-all-data
     * @apiSuccessExample {json} 成功示例:
     * {
     * "venues": [
     * {
     * "id": "2",
     * "pid": "1",
     * "name": "大上海馆",
     * }
     *      ]
     * }
     * @apiErrorExample {json} 错误示例:
     * {
     * "venues": []
     * }
     */
    public function actionGetVenueAllData()
    {

        $organ   = new Employee();
        $venues   = $organ->getVenueOption();
        return json_encode(['venues'=>$venues]);
    }
    /**
     * @api {get} /personnel/get-department  获取部门
     * @apiVersion 1.0.0
     * @apiName  获取部门
     * @apiGroup  personnel
     * @apiPermission 管理员
     *
     * @apiDescription 获取部门<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/2<br>
     * <span><strong>调用方法：</strong></span>/personnel/get-department
     *
     * @apiSampleRequest  http://qa.uniwlan.com/personnel/get-department
     * @apiSuccessExample {json} 成功示例:
     * {
     * "venues": [
     * {
     * "id": "3",
     * "pid": "2",
     * "name": "私教部",
     * }
     *      ]
     * }
     * @apiErrorExample {json} 错误示例:
     * {
     * "venues": []
     * }
     */
    public function actionGetDepartment()
    {
        $venueId = \Yii::$app->request->get('depId');
        $organ   = new Employee();
        $venue   = $organ->getDepartmentData($venueId);
        return json_encode(['venue'=>$venue]);
    }
}
