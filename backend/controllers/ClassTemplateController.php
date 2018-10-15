<?php

namespace backend\controllers;

use backend\models\TrainTemplates;
use backend\models\TrainTemplateTags;
use backend\models\TrainTemplateSearch;
use backend\models\TrainStage;
use backend\models\Action;
use yii\web\Response;
use yii\base\Exception;
use common\models\Func;
use yii\web\NotFoundHttpException;
use Yii;
class ClassTemplateController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionAddTemplate()
    {
        return $this->render('add-template');
    }
    public function actionUpdateTemplate()
    {
        return $this->render('update-template');
    }
    public function actionCustomTemplate()
    {
        return $this->render('custom-template');
    }

    /**
     * 私教管理-添加训练内容模板\添加阶段模板
     * @param
     * @throws
     */
    public function actionAddTemp($attr, $num=0)
    {
        $param = \backend\models\CardCategory::getTemplate($attr);
        //var_dump($param);die();
        $html = $this->renderPartial($param,['num'=>$num]);
        return json_encode(['html'=>$html]);
    }


    /**
     * 私教管理-新增模板-动作下拉框
     * @param
     * @throws
     */
    public function actionGetActions()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $data = Action::find()->select('id,type,unit,title')->where(['is_delete'=>0])->asArray()->all();

        return $data;
    }

    /**
     * 私教管理-新增模板-分类标签下拉框
     * @param
     * @throws
     */
    public function actionGetTemTags()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $data = TrainTemplateTags::find()->select('id,title,sorts')->asArray()->all();

        return $data;
    }

    /**
     * 私教管理-新增模板-分类标签新增
     * @param
     * @throws
     */
    public function actionAddTemTags()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new TrainTemplateTags();
        $model->loadDefaultValues();
        if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
            return (['status'=>'success','mes'=>'新增成功']);
        } else {
            return (['status'=>'error','mes'=>$model->errors]);
        }
    }

    /**
     * 私教管理-新增模板-分类标签删除
     * @param
     * @throws
     */
    public function actionDeleteTags($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = TrainTemplateTags::findOne($id);
        if($model->delete()){
            return ['status'=>'success','mes'=>'删除成功'];
        }else{
            return ['status'=>'error','mes'=>'删除失败'];
        }
    }
    /**
     * 私教管理-新增模板-分类标签下拉框
     * @param
     * @throws
     */
    public function actionGetTemplateTags()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $data = TrainTemplateTags::find()->select('id,title,sorts')->asArray()->all();

        return $data;
    }

    /**
     * 私教管理-删除模板
     * @param
     * @throws
     */
    public function actionDelete($id=0)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new TrainTemplates();
        $stageModel = new TrainStage();
        if ($id) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $result = $this->findModel($id)->delete();
                if(!$result) {
                    throw new Exception('操作失败');
                }
                $result = $stageModel->deleteAll(['template_id'=>$id]);
                if(!$result) {
                    throw new Exception('操作失败');
                }
                $transaction->commit();
                return ['status'=>'success','mes'=>'删除成功'];
            } catch (\Exception $e) {
                $transaction->rollBack();
                return ['status'=>'error','mes'=>$e->getMessage()];
             }
          }
    }

    /**
     * 私教管理-查询一个模板记录
     * @param
     * @throws
     */
    public function findModel($id)
    {
        if (($model = TrainTemplates::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * 私教管理-模板列表
     * @param
     * @throws
     */
    public function actionList()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $searchModel = new TrainTemplateSearch();
        $query       = $searchModel->search(Yii::$app->request->queryParams);
        $data        = Func::getDataProvider($query,10);
        $pagination  = $data->pagination;
        $pages       = Func::getPagesFormat($pagination);

        return ['data'=>$data->models,'pages'=>$pages];
    }

    /**
     * 私教管理-模板新增
     * @param
     * @throws
     */
    public function actionCreateTemplate()
    {
        $param = $this->post;
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new TrainTemplates();
        $stageModel = new TrainStage();
        if (Yii::$app->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                //train_templates表新增
                $model->load($this->post,'');
                $model->loadDefaultValues();
                $model->save();
                if($model->hasErrors()) {
                    return ['status'=>'error','mes'=>$model->getErrors()];
                }
                $stageData = $this->getStageData($this->post,$model->id);
                //train_stage表新增
                $result = Yii::$app->db->createCommand()->batchInsert($stageModel::tableName(), ['title', 'length_time','template_id','sorts','main','created_at','updated_at'], $stageData)->execute();
                if(!$result) {
                    throw new Exception('操作失败');
                }
                $transaction->commit();
                return ['status'=>'success','mes'=>'新增成功'];
            } catch (\Exception $e) {
                $transaction->rollBack();
                return ['status'=>'error','mes'=>$e->getMessage()];
            }

        }

    }
    /**
     * 私教管理-模板新增-阶段表新增数据处理
     * @param
     * @throws
     */
    public function getStageData($param,$id=0)
    {
        $data = [];
        if(!empty($param['plan'])){

            foreach ($param['plan'] as $key=>$value){
                $data[$key]['title'] = $value['s_tiltle']?:'';
                $data[$key]['length_time'] = intval($value['length_time'])?:0;
                $data[$key]['template_id'] = $id;
                $data[$key]['sorts'] = $key+1;
                $data[$key]['main'] =  is_array($value['main'])?json_encode($value['main']):$value['main'];
                $data[$key]['created_at'] = time();
                $data[$key]['updated_at'] = time();
            }
        }
        return $data;
    }

    /**
     * 私教管理-模板详情
     * @param
     * @throws
     */
    public function actionGetOneDetail($id=0)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $data = TrainTemplates::find()
            ->select('t.id,t.describe,t.title,t.cid,ta.title as c_title')
            ->alias('t')
            ->joinWith(['stages s'])
            ->joinWith(['templateTags ta'],false)
            ->where(['t.id'=>$id])
            ->asArray()->one();
        foreach ($data['stages'] as $key=>$value){
            $value = json_decode($value['main']);
            $main =[];
            foreach ($value as $k=>$v){
                $v = (array)$v;
                $main[$k]['action_id'] = intval($v['action_id']);
                $main[$k]['title'] = Action::findOne(intval($v['action_id']))->title;
                $main[$k]['number'] = intval($v['number']);
            }
            $data['stages'][$key]['main'] = $main;
        }

        return $data;
    }

    /**
     * 私教管理-模板复制
     * @param
     * @throws
     */
    public function actionTemplateCopy($id=0)
    {
        $id = Yii::$app->request->post('id');
        $copyName = Yii::$app->request->post('title');
        $param = $this->getCopyData($this->actionGetOneDetail($id));
        $param['title'] = $copyName;
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new TrainTemplates();
        $stageModel = new TrainStage();
        if ($id && Yii::$app->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                //train_templates表新增
                $model->load($param,'');
                $model->loadDefaultValues();
                $model->save();
                if($model->hasErrors()) {
                    return ['status'=>'error','mes'=>$model->getErrors()];
                }
                $stageData = $this->getStageData($param,$model->id);
                //train_stage表新增
                $result = Yii::$app->db->createCommand()->batchInsert($stageModel::tableName(), ['title', 'length_time','template_id','sorts','main','created_at','updated_at'], $stageData)->execute();
                if(!$result) {
                    throw new Exception('操作失败1');
                }
                $transaction->commit();
                return ['status'=>'success','mes'=>'复制成功'];
            } catch (\Exception $e) {
                $transaction->rollBack();
                return ['status'=>'error','mes'=>$e->getMessage()];
            }

        }
    }

    /**
     * 私教管理-处理模板复制数据
     * @param
     * @throws
     */
    public function getCopyData($data,$copyName = ''){
        $newData = [];
        $newData['title'] = $copyName;
        $newData['describe'] = $data['describe']?:'';
        $newData['cid'] = $data['cid']?:0;
        if($data['stages']){
            foreach ($data['stages'] as $key=>$value){
                $newData['plan'][$key]['s_tiltle'] = $value['title'];
                $newData['plan'][$key]['length_time'] = $value['length_time']?:0;
                $newData['plan'][$key]['main'] = $value['main']?:'';
            }
        }

        return $newData;

    }
    /**
     * 私教管理-模板编辑
     * @param
     * @throws
     */
    public function actionTemplateEdit($id=0)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = TrainTemplates::findOne($id);
        $stageModel = new TrainStage();
        if ($id && Yii::$app->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                //train_templates表新增
                $model->load($this->post,'');
                $model->loadDefaultValues();
                $model->save();
                if($model->hasErrors()) {
                    return ['status'=>'error','mes'=>$model->getErrors()];
                }
                $result = TrainStage::deleteAll(['template_id'=>$id]);
                if(!$result) {
                    throw new Exception('操作失败');
                }
                $stageData = $this->getStageData($this->post,$model->id);
                //train_stage表新增
                $result = Yii::$app->db->createCommand()->batchInsert($stageModel::tableName(), ['title', 'length_time','template_id','sorts','main','created_at','updated_at'], $stageData)->execute();
                if(!$result) {
                    throw new Exception('操作失败');
                }
                $transaction->commit();
                return ['status'=>'success','mes'=>'修改成功'];
            } catch (\Exception $e) {
                $transaction->rollBack();
                return ['status'=>'error','mes'=>$e->getMessage()];
            }

        }
    }
    /**
     * 私教管理-自定义模板修改
     * @param
     * @throws
     */
    public function actionAddCustomTemplate()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
            $param = $this->post;
            $stageModel = new TrainStage();
            if (Yii::$app->request->isPost) {
                $transaction = Yii::$app->db->beginTransaction();
                try{
                    $stageData = $this->getSelfStageData($this->post,0);
                    if($this->actionGetCustomTemplate()){
                            $result = TrainStage::deleteAll(['status'=>1]);
                            if(!$result) {
                                throw new Exception('操作失败');
                            }
                    }
                    //train_stage表新增
                    $result = Yii::$app->db->createCommand()->batchInsert($stageModel::tableName(), ['title', 'length_time','template_id','sorts','main','created_at','updated_at','status'], $stageData)->execute();
                    if(!$result) {
                        throw new Exception('操作失败');
                    }
                    $transaction->commit();
                    return ['status'=>'success','mes'=>'保存成功'];
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    return ['status'=>'error','mes'=>$e->getMessage()];
                }

        }
    }
    /**
     * 私教管理-自定义模板
     * @param
     * @throws
     */
    public function actionGetCustomTemplate()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $data = TrainStage::find()->where(['status'=>1])->asArray()->all();

        return $data;
    }

    /**
     * 私教管理-自定义模板-数据处理
     * @param
     * @throws
     */
    public function getSelfStageData($param,$id=0)
    {
        $data = [];
        if(!empty($param['plan'])){

            foreach ($param['plan'] as $key=>$value){
                $data[$key]['title'] = $value['title']?:'';
                $data[$key]['length_time'] = intval($value['length_time'])?:0;
                $data[$key]['template_id'] = $id;
                $data[$key]['sorts'] = $key+1;
                $data[$key]['main'] = '[{}]';
                $data[$key]['created_at'] = time();
                $data[$key]['updated_at'] = time();
                $data[$key]['status'] = 1;
            }
        }
        return $data;
    }

}
