<?php

namespace backend\controllers;

use yii\data\ActiveDataProvider;
use backend\models\FitnessAssessment;
use Yii;
use yii\web\NotFoundHttpException;
use common\models\Func;
use yii\web\Response;
use yii\base\Exception;

/**
 * 私教管理-客户档案设置-体适能评估
 * @author jianbingqi<jianbingqi@itsports.club>
 */
class FitnessAssessmentController extends \backend\controllers\BaseController
{
    /**
     * 私教管理-客户档案设置-添加体适能评估项目
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param
     * @throws
     */
    public function actionCreate($id = 0)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new FitnessAssessment();
        $model->loadDefaultValues();
        $model->pid = $id;
        //$model->level = self::getLevel(Yii::$app->request->post('pid'));
        if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
            return ['status'=>'success','mes'=>'新增成功'];
        } else {
            return ['status'=>'error','mes'=>$model->errors];
        }
    }

    /**
     * 私教管理-客户档案设置-体适能评估一级菜单列表
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param
     * @return mixed
     */
    public function actionTopList()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $list = FitnessAssessment::find()->select('id,title,pid')->where(['pid'=>0])->asArray()->all();
        return $list;
    }


    /**
     * 私教管理-客户档案设置-体适能评估顶级下子集列表
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param
     * @return mixed
     */
    public function actionList($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $list = [];
        $list['father'] = FitnessAssessment::find()->select('id,title,pid')->where(['id'=>$id])->asArray()->one();
        $list['child'] = FitnessAssessment::find()->where(['pid'=>$id])->orderBy('sort asc')->asArray()->all();
        return $list;
    }

    /**
     * 私教管理-客户档案设置-体适能评估-修改
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $id
     * @return mixed
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
     * 私教管理-客户档案设置-体适能评估根据主键id查一条记录
     * @param int $id
     * @return  the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findModel($id)
    {
        if (($model = FitnessAssessment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('No data be found');
        }
    }
    /**
     * 私教管理-客户档案设置-体适能评估详情
     * @param int $id
     * @return int
     * @throws
     */
    public function actionDetail($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $data = FitnessAssessment::find()->where(['id'=>$id])->asArray()->one();

        return $data;
    }

    /**
     * 私教管理-客户档案设置-体适能评估-删除
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        if(self::getSon($id)) return ['status'=>'error','mes'=>'请先删除子级项目'];

        $model = self::findModel($id)->delete();
        if($model){
            return ['status'=>'success','mes'=>'删除成功'];
        }else {

            return ['status'=>'error','mes'=>'删除失败'];
        }
    }
    /**
     * 私教管理-客户档案设置-体适能评估-排序
     * @param
     * @return
     * @throws
     */
    public function actionSort()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $rows = [];
        $keyPrimary = [];
        $params = $this->post;
        if(!empty($params['sort'])){
            foreach($params['sort'] as $k=>$v){
                $rows[$k][] = intval($k);
                $keyPrimary[$k] = intval($v['id']);
            }
        }
        $sql = Func::batchUpdate(FitnessAssessment::tableName(),['sort'],$rows,$keyPrimary,'id');
        $result = Yii::$app->db->createCommand($sql)->execute();
        if($result){
            return ['status'=>'success','mes'=>'排序成功'];
        }else{
            return ['status'=>'error','mes'=>'排序失败'];
        }

    }
    /**
     * 私教管理-客户档案设置-体适能评估根据主键id查一条记录-查询分类下是否有子级
     * @param int $id
     * @return int
     * @throws
     */
    public static function getSon($id)
    {
        if($model = FitnessAssessment::find()->where(['pid'=>$id])->one()) {
            return $model->id;
        }else{
            return false;
        }
    }
}