<?php

namespace backend\controllers;

use Yii;
use common\models\AdminLog;
use common\models\AdminLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Func;

/**
 * AdminLogController implements the CRUD actions for AdminLog model.
 */
class AdminLogController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * Lists all AdminLog models.
     * @return mixed
     */
    public function actionGetAdminLogList()
    {

        $params         = \Yii::$app->request->queryParams;
        $model          = new AdminLog();
        $logInfo     = $model->search($params);
        $pagination =  $logInfo->pagination;
        $pages      = Func::getPagesFormat($pagination);

        return json_encode(['data'=>$logInfo->models,'pages'=>$pages]);
    }



    /**
     * Finds the AdminLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdminLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionFindModel($id=null)
    {
        if(!(int)$id){
            throw new NotFoundHttpException('id is must!');
        } else {
            $data = AdminLog::findOneLog((int)$id);
        }

            return json_encode(['data'=>$data?:[]]);
    }


}
