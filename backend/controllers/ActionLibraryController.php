<?php

namespace backend\controllers;

use backend\models\Action;
use backend\models\ActionCategoryRelation;
use backend\models\ActionImages;
use backend\models\ActionSearch;
use Yii;
use yii\web\Response;
use yii\base\Exception;
use common\models\Func;

class ActionLibraryController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionUpdateAction($updateId)
    {
        $model = self::findModel($updateId);
        return $this->render('update-action', [
            'model' => $model,
        ]);
    }
    public function actionCreate()
    {
        return $this->render('create');
    }

    /**
     * 私教管理-动作库-新增动作
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $id
     * @return mixed
     */
    public function actionAdd()
    {
        $param = $this->post;
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new Action();
        $cateRelationModel = new ActionCategoryRelation();
        $imageModel = new ActionImages();
        if (Yii::$app->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                //action表新增
                $model->load($this->post,'');
                $model->loadDefaultValues();
                $model->cate_id = implode(',',array_filter($param['cat_id']));
                $model->save();
                if($model->hasErrors()) {
                    return ['status'=>'error','mes'=>$model->getErrors()];
                }
                //action_category_relation表新增
                $relationData = $this->getInsertRelationData($this->post,$model->id);
                $result = Yii::$app->db->createCommand()->batchInsert(ActionCategoryRelation::tableName(), ['cid', 'aid'], $relationData)->execute();
                if(!$result) {
                    throw new Exception('操作失败1');
                }
                //action_images表新增
                if(isset($param['r_example']) || !empty($param['r_example']) || isset($param['w_example'])){
                    $imagesData = $this->getInsertImagesData($this->post,$model->id);
                    $result = Yii::$app->db->createCommand()->batchInsert(ActionImages::tableName(), ['url', 'describe','aid','type'], $imagesData)->execute();
                    if(!$result) {
                        throw new Exception('操作失败2');
                    }
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
     * 私教管理-动作库-修改动作
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $id
     * @return mixed
     */
    public function actionUpdate($id=0)
    {
        $param = $this->post;
        $id = Yii::$app->request->post('id');
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = Action::findOne($id);
        $cateRelationModel = new ActionCategoryRelation();
        $imageModel = new ActionImages();

        if ($id && Yii::$app->request->isPost) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                //action表修改
                $model->load($this->post,'');
                $model->cate_id = implode(',',array_filter($param['cat_id']));
                $model->save();
                if($model->hasErrors()) {
                    return ['status'=>'error','mes'=>$model->errors];
                }
                //action_category_relation表批量修改
                //删除action_category_relation表所有关联关系
                $result = ActionCategoryRelation::deleteAll(['aid'=>$id]);
                if(!$result) {
                    throw new Exception('操作失败1');
                }
                //新增action_category_relation表单记录
                $relationData = $this->getInsertRelationData($this->post,$id);
                $result = Yii::$app->db->createCommand()->batchInsert(ActionCategoryRelation::tableName(), ['cid', 'aid'], $relationData)->execute();
                if(!$result) {
                    throw new Exception('操作失败2');
                }
                //action_images表批量新增
                $param = $this->post;
                //删除action_images表所有关联关系
                if(ActionImages::findOne(['aid'=>$id])){
                    $result = ActionImages::deleteAll(['aid'=>$id]);
                    if(!$result) {
                        throw new Exception('操作失败3');
                    }
                }
                if(!empty($param['w_example']) ||!empty($param['r_example']) || isset($param['w_example'])){

                    $imagesData = $this->getInsertImagesData($this->post,$id);
                    $result = Yii::$app->db->createCommand()->batchInsert(ActionImages::tableName(), ['url', 'describe','aid','type'], $imagesData)->execute();
                    if(!$result) {
                        throw new Exception('操作失败4');
                    }
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
     * 私教管理-动作管理根据主键id查一条记录
     * @param int $id
     * @return Action the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findModel($id)
    {
        if (($model = Action::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('No data be found');
        }
    }

    /**
     * 私教管理-动作库管理-删除动作
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = self::findModel($id);
        $model ->is_delete = 1;
        if($model->save()){
            return json_encode(['status'=>'success','mes'=>'删除成功']);
        }else {

            return json_encode(['status'=>'error','mes'=>'删除失败']);
        }
    }
    /**
     * 私教管理-动作库管理-批量删除
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $id
     * @return mixed
     */
    public function actionDeleteMany()
    {
        $ids = $this->post;
        if(is_array($ids)){
           if( Action::updateAll(['is_delete' => 1], ['id'=>$ids['ids']])){
               return json_encode(['status'=>'success','mes'=>'删除成功']);
           }else {

               return json_encode(['status'=>'error','mes'=>'删除失败']);
           }
        }
    }

    /**
     * 私教管理-动作库管理-动作列表
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new ActionSearch();
        $query = $searchModel->search(Yii::$app->request->queryParams);
        $data = Func::getDataProvider($query,8);
        $pagination = $data->pagination;
        $pages      = Func::getPagesFormat($pagination);

        return json_encode(['data'=>$data->models,'pages'=>$pages]);

    }

    /**
     * 私教管理-动作详情
     * @param int $id
     * @return Action detail
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function  actionGetOneDetail($id)
    {
        return json_encode(['status'=>'success','data'=>Action::getOneDetail($id)]);
    }

    /**
     * 私教管理-动作管理-修改分类
     * @param int $id 动作id
     * @return Action detail
     * @
     */
    public function  actionEditCategory($id=0)
    {
        $id = Yii::$app->request->post('id');
        Yii::$app->response->format=Response::FORMAT_JSON;
        $cateRelationModel = new ActionCategoryRelation();
        if ($id && Yii::$app->request->post('cat_id')) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                //删除action_category_relation表所有关联关系
                $result = ActionCategoryRelation::deleteAll(['aid'=>$id]);
                if(!$result) {
                    throw new Exception('操作失败');
                }
                //新增action_category_relation表单记录
                $relationData = $this->getInsertRelationData($this->post,$id);
                $result = Yii::$app->db->createCommand()->batchInsert(ActionCategoryRelation::tableName(), ['cid', 'aid'], $relationData)->execute();
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
     * 私教管理-动作详情-动作示范添加模板接口
     * @param
     * @throws
     */
    public function actionAddTemplate($attr, $num=0)
    {
        $param = \backend\models\CardCategory::getTemplate($attr);
        $html = $this->renderPartial($param,['num'=>$num]);
        return json_encode(['html'=>$html]);
    }
    /**
     * 私教管理-动作库-新增动作-处理表单action_category_relation数据
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $param,$id插入的动作id
     * @return mixed
     */
    public function getInsertRelationData($param,$id=0)
    {
        $data = [];
        if(!empty($param)){

            foreach ($param['cat_id'] as $key=>$value){
                $data[$key]['cid'] = $value?:0;
                $data[$key]['aid'] = $id;
            }
        }
        return $data;

    }

    /**
     * 私教管理-动作库-新增动作-处理表单action_images数据
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $param,$id插入的动作id
     * @return mixed
     */
    public function getInsertImagesData($param,$id=0)
    {
        $r_data = [];
        $w_data = [];
        if(!empty($param) ) {
            //正确示范数据处理
            if (!empty($param['r_example']) && isset($param['r_example'])) {
                foreach ($param['r_example'] as $key => $value) {
                    $r_data[$key]['url'] = $value['img'];
                    $r_data[$key]['describe'] = $value['note'];
                    $r_data[$key]['aid'] = $id;
                    $r_data[$key]['type'] = 2;
                }
            } else {
                $r_data = [];
            }

            //错误示范数据处理
            if (isset($param['w_example']) && !empty($param['w_example'])) {
                foreach ($param['w_example'] as $key => $value) {
                    $w_data[$key]['url'] = $value;
                    $w_data[$key]['describe'] = '';
                    $w_data[$key]['aid'] = $id;
                    $w_data[$key]['type'] = 1;
                }
            } else {
                $w_data = [];
            }
        }
        return array_merge($r_data,$w_data);
    }

    /**
     * 私教管理-动作库-判断动作名是否重复
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $param
     * @return mixed
     */
    public function  actionExistTitle($title='')
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $title =  trim(Yii::$app->request->post('title'));
        $result = Action::find()->where(['title'=>$title,'is_delete'=>0])->asArray()->all();
        if($result){
            return ['status'=>'error','mes'=>'该名称已存在'];
        }

    }
}
