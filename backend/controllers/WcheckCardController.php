<?php

namespace backend\controllers;

class WcheckCardController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionField()
    {
        return $this->render('/wcheck-card/field');
    }
}
