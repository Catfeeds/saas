<?php

namespace backend\controllers;

use backend\models\BodyBuildGoal;
use Yii;
use yii\web\Response;
use yii\web\NotFoundHttpException;

/**
 * 私教管理-客户资料-健身目的
 */
class BodyBuildGoalController extends BaseController
{
    /**
     * 私教管理-客户资料-健身目的-列表
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param int $id
     * @return mixed
     */
    public function actionList()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $data = BodyBuildGoal::find()->asArray()->orderBy('create_at desc')->all();

        return $data;
    }

    /**
     * 私教管理-客户资料-健身目的-新增
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param int $id
     * @return mixed
     */
    public function actionCreate()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new BodyBuildGoal();
        $model->loadDefaultValues();
        if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
            return ['status'=>'success','mes'=>'新增成功'];
        } else {
            return ['status'=>'error','mes'=>$model->getErrors()];
        }
    }

    /**
     * 私教管理-客户资料-健身目的-修改
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param int $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
            return ['status'=>'success','mes'=>'修改成功'];
        } else {
            return ['status'=>'error','mes'=>$model->getErrors()];
        }
    }

    /**
     * 私教管理-客户资料-健身目的-删除
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param int $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        if($this->findModel($id)->delete()){
            return ['status'=>'success','mes'=>'删除成功'];
        }else{
            return ['status'=>'error','mes'=>'删除失败'];
        }
    }

    /**
     * 私教管理-客户资料-健身目的-详情
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param int $id
     * @return mixed
     */
    public function actionDetail($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $data = BodyBuildGoal::find()->where(['id'=>$id])->asArray()->one();

        return $data;

    }

    /**
     * Finds the BodyBuildGoal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return BodyBuildGoal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = BodyBuildGoal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}