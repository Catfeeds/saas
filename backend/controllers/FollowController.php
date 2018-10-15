<?php

namespace backend\controllers;

use yii\data\ActiveDataProvider;
use backend\models\FollowState;
use backend\models\FollowWay;
use backend\models\PersonalTrainerFrom;
use Yii;
use yii\web\NotFoundHttpException;
use common\models\Func;
use yii\web\Response;
use yii\base\Exception;

/**
 * 私教管理-设置-跟进状态/跟进方式/私教来源控制器
 * @author jianbingqi<jianbingqi@itsports.club>
 */
class FollowController extends \backend\controllers\BaseController
{
    /**
     * 私教管理-设置-跟进方式-列表
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param
     * @return mixed
     */
    public function actionWayList()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $list = FollowWay::find()->orderBy('create_at asc')->asArray()->all();

        return $list;
    }
    /**
     * 私教管理-设置-跟进方式-新增
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param
     * @return mixed
     */
    public function actionWayAdd()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new FollowWay();
        $model->loadDefaultValues();
        if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
            return ['status'=>'success','mes'=>'新增成功'];
        } else {
            return ['status'=>'error','mes'=>$model->errors];
        }
    }
    /**
     * 私教管理-设置-跟进方式-修改
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param int id
     * @return mixed
     */
    public function actionWayUpdate($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = self::findWayModel($id);

        if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
            return ['status'=>'success','mes'=>'修改成功'];
        } else {
            return ['status'=>'error','mes'=>$model->errors];
        }
    }
    /**
     * 私教管理-设置-跟进方式-删除
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param   int id
     * @return mixed
     */
    public function actionWayDelete($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = self::findWayModel($id)->delete();
        if($model){
            return ['status'=>'success','mes'=>'删除成功'];
        }else {
            return ['status'=>'error','mes'=>'删除失败'];
        }
    }
    /**
     * 私教管理-设置-跟进方式根据主键id查一条记录
     * @param int $id
     * @return  the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findWayModel($id)
    {
        if (($model = FollowWay::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('No data be found');
        }
    }

    ////////////////////////////////私教管理-设置-私教来源/////////////////////////////////
    /**
     * 私教管理-设置-私教来源-列表
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param
     * @return mixed
     */
    public function actionFromList()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $list = PersonalTrainerFrom::find()->orderBy('create_at asc')->asArray()->all();

        return $list;
    }
    /**
     * 私教管理-设置-私教来源-新增
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param
     * @return mixed
     */
    public function actionFromAdd()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new PersonalTrainerFrom();
        $model->loadDefaultValues();
        if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
            return ['status'=>'success','mes'=>'新增成功'];
        } else {
            return ['status'=>'error','mes'=>$model->errors];
        }
    }
    /**
     * 私教管理-设置-私教来源-修改
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param int id
     * @return mixed
     */
    public function actionFromUpdate($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = self::findFromModel($id);

        if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
            return ['status'=>'success','mes'=>'修改成功'];
        } else {
            return ['status'=>'error','mes'=>$model->errors];
        }
    }
    /**
     * 私教管理-设置-私教来源-删除
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param   int id
     * @return mixed
     */
    public function actionFromDelete($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = self::findFromModel($id)->delete();
        if($model){
            return ['status'=>'success','mes'=>'删除成功'];
        }else {
            return ['status'=>'error','mes'=>'删除失败'];
        }
    }
    /**
     * 私教管理-设置-私教来源根据主键id查一条记录
     * @param int $id
     * @return  the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findFromModel($id)
    {
        if (($model = PersonalTrainerFrom::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('No data be found');
        }
    }

    ////////////////////////////////私教管理-设置-跟进状态/////////////////////////////////
    /**
     * 私教管理-设置-跟进状态-列表
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param
     * @return mixed
     */
    public function actionStateList()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $list = FollowState::find()->orderBy('id asc')->asArray()->all();

        return $list;
    }

    /**
     * 私教管理-设置-跟进状态-保存修改
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param
     * @return mixed
     */
    public function actionStateUpdateAll()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = $this->post;
        if (Yii::$app->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                 FollowState::updateAll(['state' => 0], ['in', 'id', $params['state']]);
                 FollowState::updateAll(['state' => 1], ['not in', 'id', $params['state']]);
                 FollowState::updateAll(['is_remind' => 0], ['in', 'id', $params['is_remind']]);
                 FollowState::updateAll(['is_remind' => 1], ['not in', 'id', $params['is_remind']]);
                $transaction->commit();
                return ['status'=>'success','mes'=>'保存成功'];
            } catch (\Exception $e) {
                $transaction->rollBack();
                return ['status'=>'error','mes'=>$e->getMessage()];
            }
        }
    }
    /**
     * 私教管理-设置-跟进状态-重置
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param
     * @return mixed
     */
    public function actionStateReset()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $result = FollowState::updateAll(['state' => 0,'is_remind' => 0], ['or',['<>','state',0],['<>','is_remind',0]]);
        if($result){
            return ['status'=>'success','mes'=>'重置成功'];
        }else{
            return ['status'=>'error','mes'=>'重置失败'];
        }
    }




}