<?php

namespace backend\controllers;

class StarryController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
