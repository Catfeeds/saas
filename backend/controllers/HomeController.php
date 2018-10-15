<?php

namespace backend\controllers;

use backend\models\AuthRule;

class HomeController extends \yii\web\Controller
{
    
    public $layout = 'login';
    /**
     * 后端 - 后台 - 登录页面
     * @return string
     * @auther:侯凯新
     * create 2017-3-29
     */
    public function init(){
        $this->enableCsrfValidation = false;
        if (!\Yii::$app->user->isGuest){
            return $this->redirect('/site/index');
        }
    }
    /**
     * 后端 - 后台 - 登录初始化
     * @return string
     * @auther 李惠恩
     * create 2017-8-29
     */
    public function beforeAction($action) {
        if (!\Yii::$app->user->isGuest){
            return $this->redirect('/site/index');
        }
        return true;
    }
}
