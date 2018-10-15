<?php

namespace backend\controllers;

use yii\data\ActiveDataProvider;
use backend\models\ActionCategory;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use common\models\Func;

class ActionCategoryController extends BaseController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(
            [
            'query' => ActionCategory::find()->where(['is_delete'=>0])->orderBy('sort asc'),
            'pagination' => false
            ]);
        //var_dump($dataProvider->getModels());die;
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'pagination' => false
        ]);
    }

    /**
     * 私教管理-动作库分类管理-分类列表
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $id
     * @return mixed
     */
    public function actionGetCateList($id=0)
    {
        $data = ActionCategory::find()->asArray()->where(['is_delete'=>0,'pid'=>$id])->orderBy('created_at desc')->all();
        return json_encode(['data'=>$data]);
    }


    /**
     * 私教管理-动作库分类管理-新增分类
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $id
     * @return mixed
     */
    public function actionCreate($id = 0)
    {
        $model = new ActionCategory();
        $model->loadDefaultValues();
        $model->pid = $id;
        $model->level = self::getLevel(Yii::$app->request->post('pid'));
        if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
            return json_encode(['status'=>'success','mes'=>'新增成功']);
        } else {
            return json_encode(['status'=>'error','mes'=>$model->errors]);
        }
    }

    /**
     * 私教管理-动作库分类管理-修改分类
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = self::findModel($id);

        if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
            return json_encode(['status'=>'success','mes'=>'修改成功']);
        } else {
            return json_encode(['status'=>'error','mes'=>$model->errors]);
        }
    }

    /**
     * 私教管理-动作库分类管理-删除分类
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(self::getSon($id)) return json_encode(['status'=>'error','mes'=>'请先删除子级分类']);

        $model = self::findModel($id)->delete();
        if($model){
            return json_encode(['status'=>'success','mes'=>'删除成功']);
        }else {

            return json_encode(['status'=>'error','mes'=>'删除失败']);
        }
    }

    /**
     * 私教管理-动作库分类管理根据主键id查一条记录
     * @param int $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findModel($id)
    {
        if (($model = ActionCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('No data be found');
        }
    }
    /**
     * 私教管理-动作库分类管理-新增-获取分类所属级别
     * @param int $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function getLevel($id=0)
    {
        if($id){
            $level = ActionCategory::find()->where(['id'=>$id])->asArray()->one();
            return $level['level']+1;
        }else{
            return 1;
        }
    }

    /**
     * 私教管理-动作库分类管理-查询分类下是否有子级
     * @param int $id
     * @return int
     * @throws
     */
    public static function getSon($id)
    {
        if($model = ActionCategory::find()->where(['pid'=>$id,'is_delete'=>0])->one()) {
            return $model->id;
        }else{
            return false;
        }
    }

    /**
     * 私教管理-动作库管理-获取所有分类
     * @param int $id
     * @return int
     * @throws
     */
    public function actionGetAllCategory()
    {
        $data = ActionCategory::getCateTree();
        $data = Func::getDeepList($data);
        return json_encode($data);
    }
    /**
     * 私教管理-动作库管理-查找某个分类下是否有动作
     * @param int $id分类id
     * @return array
     * @throws
     */
    public static function getActionByCid($id)
    {
        $data = ActionCategory::find()
                    ->joinWith('actions')->asArray()->all();

    }
    /*ceshi*/
    public function actionGetList()
    {
        $data = ActionCategory::find()->joinWith('actions')->asArray()->all();


        return json_encode($data);
    }

}
