<?php

namespace backend\controllers;

class EvaluateController extends BaseController
{

    /**
     *  评价管理- 评价管理首页 - 页面列表
     * @return string
     * @author 程丽明
     * create 2017-3-22
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     *  评价管理- 评价详情页面 - 页面详情信息
     * @return string
     * @author 程丽明
     * create 2017-3-22
     */
    public function actionEvaluateDetail()
    {
        return $this->render('evaluateDetail');
    }
}
