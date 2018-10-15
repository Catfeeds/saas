<?php

namespace backend\controllers;

use yii\data\ActiveDataProvider;
use backend\models\ClassBeforeQuestion;
use backend\models\Course;
use backend\models\ClassBeforeQuestionSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use common\models\Func;
use yii\web\Response;
use yii\base\Exception;

class PrivateClassSetController extends \backend\controllers\BaseController
{

    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * 私教管理-课程设置-添加模板接口
     * @author jianbingqi<jianbingqi@itsports.club>
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
     * @desc: 业务后台 - 私教管理-课前询问-列表
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/04
     * @return array
     * @throws \Exception
     */
    public function actionList()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $searchModel = new ClassBeforeQuestionSearch();
        $query = $searchModel->search(Yii::$app->request->queryParams);
        $data = Func::getDataProvider($query,8);
        $pagination = $data->pagination;
        $pages      = Func::getPagesFormat($pagination);

        return  ['data'=>$data->models,'pages'=>$pages];
    }
    /**
     * @desc: 业务后台 - 私教管理-课前询问-详情
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/04
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function actionDetail($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $data =  Course::find()
                ->alias('c')
                ->select('c.id,c.name')
                ->joinWith(['questions q'])
                ->where(['c.id'=>$id])
                ->asArray()
                ->one();
        if(isset($data['questions']) && !empty($data['questions'])){
            foreach ($data['questions'] as $k=>$v){
                $data['questions'][$k]['option'] = json_decode($v['option']);
            }
        }
        return $data;
    }

    /**
     * @desc: 业务后台 - 私教管理-课前询问-新增
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/04
     * @return array
     * @throws \yii\db\Exception
     */

    public function actionCreate()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        if(ClassBeforeQuestion::findOne(['course_id'=>Yii::$app->request->post('course_id')])){
            return ['status'=>'error','mes'=>'该课种已经设置过问题，请前去修改'];
        }
        if (Yii::$app->request->isPost)
        {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $data =  $this->getQuestionInsertData($this->post);
                $result = Yii::$app->db->createCommand()->batchInsert(ClassBeforeQuestion::tableName(), ['course_id','type','title','option','create_at','update_at'], $data)->execute();
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
     * @desc: 业务后台 - 私教管理-课前询问-修改
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/04
     * @param $id
     * @return array
     * @throws \yii\db\Exception
     */
    public function actionUpdate($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        if(ClassBeforeQuestion::findOne(['course_id'=>Yii::$app->request->post('course_id')]) && Yii::$app->request->post('course_id') != $id){
            return ['status'=>'error','mes'=>'该课种已经设置过问题，请前去修改'];
        }
        $model = ClassBeforeQuestion::findOne($id);
        if ($id && Yii::$app->request->isPost)
        {
            $transaction = Yii::$app->db->beginTransaction();
            try{
                $result = ClassBeforeQuestion::deleteAll(['course_id'=>$id]);
                if(!$result) {
                    throw new Exception('操作失败1');
                }
                $data =  $this->getQuestionInsertData($this->post);
                $result = Yii::$app->db->createCommand()->batchInsert(ClassBeforeQuestion::tableName(), ['course_id','type','title','option','create_at','update_at'], $data)->execute();
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
     * @desc: 业务后台 - 私教管理-课前询问-删除
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/04
     * @param $id
     * @return array
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        if($result = ClassBeforeQuestion::deleteAll(['course_id'=>$id])){
            return ['status'=>'success','mes'=>'删除成功'];
        }else{
            return ['status'=>'error','mes'=>'删除失败'];
        }
    }

    /**
     * @desc: 业务后台 - 私教管理-课前询问-查找一个记录model
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/04
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    public function findModel($id)
    {
        if (($model = ClassBeforeQuestion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * @desc: 业务后台 - 私教管理-课前询问-问题批量新增数据处理
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/04
     * @param $param
     * @return array
     */
    public function getQuestionInsertData($param)
    {
        $data = [];
        if(!empty($param['main'])){
            foreach($param['main'] as $k=>$v){
                $data[$k]['course_id'] = $param['course_id'];
                $data[$k]['type'] = $v['type'];
                $data[$k]['title'] = $v['title'];
                $data[$k]['option'] = isset($v['option'])?json_encode($v['option']):null;
                $data[$k]['create_at'] = time();
                $data[$k]['update_at'] = time();

            }
        }
        return $data;
    }
}
