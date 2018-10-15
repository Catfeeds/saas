<?php
//2017-06-24
//系统主页
//苏雨
namespace backend\controllers;

class HomePageController extends \backend\controllers\BaseController
{
    
    public function actionIndex()
    {
        return $this->render('index');
    }

}
