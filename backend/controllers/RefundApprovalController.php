<?php

namespace backend\controllers;

class RefundApprovalController extends BaseController
{

    /**
     *  中心管理- 退款审批
     * @return string
     * @author 李广杨
     * create 2017-08-26
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}
