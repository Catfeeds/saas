<?php

namespace backend\controllers;

use backend\models\HealthQuestion;
use Yii;
use yii\web\NotFoundHttpException;
use common\models\Func;
use yii\web\Response;
use yii\base\Exception;
/*健康问答控制器*/
class HealthQuestionController extends \backend\controllers\BaseController
{
    /**
     * 私教管理-健康问答-列表
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param
     * @return
     */
    public function actionList($type=1)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        switch ($type)
        {
            case 2: //其他问题 type=2
                $list = HealthQuestion::find()->where(['type'=>2])->asArray()->all();
                break;
            default: //病史 type=1
                $list = HealthQuestion::find()->where(['type'=>1])->asArray()->all();
        }

        return $list;
    }
    /**
     * 私教管理-健康问答-新增
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $type = 1病史，2其他问题
     * @return
     */
    public function actionCreate($type=1)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new HealthQuestion();
        $model->loadDefaultValues();
        $model->type = $type;
        if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
            return ['status'=>'success','mes'=>'新增成功'];
        } else {
            return ['status'=>'error','mes'=>$model->errors];
        }
    }

    /**
     * 私教管理-健康问答-修改
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $type = 0病史，1其他问题
     * @return
     */
    public function actionUpdate($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = self::findModel($id);

        if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
            return ['status'=>'success','mes'=>'修改成功'];
        } else {
            return ['status'=>'error','mes'=>$model->errors];
        }
    }


    /**
     * 私教管理-健康问答-检测项目根据主键id查一条记录
     * @param int $id
     * @return HealthQuestion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findModel($id)
    {
        if (($model = HealthQuestion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('No data be found');
        }
    }

    /**
     * 私教管理-健康问答-删除
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;

        $model = self::findModel($id)->delete();
        if($model){
            return ['status'=>'success','mes'=>'删除成功'];
        }else {

            return ['status'=>'error','mes'=>'删除失败'];
        }
    }
}