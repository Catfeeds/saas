<?php

namespace backend\controllers;

class WcabinetController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    //添加区域
    public function actionAddArea()
    {
        return $this->render('/wcabinet/add-area');
    }
//    柜子列表
    public function actionCabinetData()
    {
        return $this->render('/wcabinet/cabinet-data');
    }
//    柜子矩阵列表
    public function actionCabinetDatal()
    {
        return $this->render('/wcabinet/cabinet-datal');
    }
//    类型管理
    public function actionCabinetType()
    {
        return $this->render('/wcabinet/cabinet-type');
    }
    //绑定用户
    public function actionBindUser()
    {
        return $this->render('/wcabinet/bind-user');
    }
    //绑定用户修改
    public function actionCabinetEdit()
    {
        return $this->render('/wcabinet/cabinet-edit');
    }
}
