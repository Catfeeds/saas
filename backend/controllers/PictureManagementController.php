<?php

namespace backend\controllers;
use backend\models\ImageManagement;
use backend\models\ImageManagementType;
use common\models\Func;
use Yii;
use backend\models\PictureForm;
use backend\models\PicTypeForm;
class PictureManagementController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * 后台 - 图片管理 - 上传图片
     * @return string
     * @author 黄华
     * @create 2017-8-11
     * @param
     */
    public function actionUpload()
    {
        $data = Func::uploadImage();
        return $data;
    }

    /**
     *后台图片管理 - 图片列表 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/11
     * @return bool|string
     */
    public function actionPicInfo()
    {
        $params = \Yii::$app->request->queryParams;
        $params['nowBelongId']   = $this->nowBelongId;
        $params['nowBelongType'] = $this->nowBelongType;
        $model = new ImageManagement();
        $memberInfo = $model->search($params);
        $pagination = $memberInfo->pagination;
        $pages = Func::getPagesFormat($pagination);
        return json_encode(['data' => $memberInfo->models, 'pages' => $pages]);
    }
    /**
     *后台图片管理 - 图片详情 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/11
     * @return bool|string
     */
    public function actionPicDetails()
    {
        $picId = Yii::$app->request->get('picId');
        if (!empty($picId)) {
            $model = new ImageManagement();
            $picData = $model->getPicModel($picId);
            return json_encode($picData);
        } else {
            return false;
        }
    }

    /**
     *后台图片管理 - 图片新增 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/11
     * @return bool|string
     */
    public function actionAddPic()
    {
        $post = \Yii::$app->request->post();
        $companyId = $this->companyId;
        $venueId   = $this->venueId;
        $model = new PictureForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->addMyData($companyId,$venueId);
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '新增成功']);
            } else {
                return json_encode(['status' => 'success', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台图片管理 - 图片详情修改 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/11
     * @return bool|string
     */
    public function actionUpdatePic()
    {
        $post = \Yii::$app->request->post();
        $model = new PictureForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->updateData();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'success', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }
    /**
     *后台图片管理 - 图片列表 - 图片详情单条数据删除
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/11
     * @return bool|string
     */
    public function actionPicData()
    {
        $picId = Yii::$app->request->get('picId');
        $model = new ImageManagement();
        $delRes = $model->getPictureDel($picId);
        if ($delRes) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }
    /**
     * 图片管理 - 图片列表 - 删除多张图片
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/6
     * @return \yii\db\ActiveQuery
     */
    public function actionDelPicAll()
    {
        $picId  = \Yii::$app->request->post('picId');//图片id
        $model  = new ImageManagement();
        $delRes = $model->getDelPic($picId);
        if ($delRes === true) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $delRes]);
        }

    }
    /**
     * 图片管理 - 图片类别列表 - 图片类别
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/6
     * @return \yii\db\ActiveQuery
     */
    public function actionGetPicTypeData()
    {
        $id   = $this->nowBelongId;
        $type = $this->nowBelongType;
        $picType = new ImageManagementType();
        $data = $picType->search($id,$type);
        return json_encode(['data'=>$data]);
    }
    /**
     * 后台 - 图片管理 -  获取类别单条数据
     * @author huanghua <lihuien@itsports.club>
     * @create 2017/8/16
     * @param id          //获取前台需要数据的id
     * @return object
     */
    public function actionGetPicTypeOne($id)
    {
        $data = ImageManagementType::getPicTypeOne($id);
        return json_encode(['data'=>$data]);
    }
    /**
     * 后台 - 图片管理 - 修改合同类型名称
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/16
     * @return object
     */
    public function actionPicTypeUpdatePost()
    {
        $post = \Yii::$app->request->post();
        $model = new PicTypeForm([]);
        if($model->load($post,'') && $model->validate($post)){
            $deal = $model->updateSave();
            if($deal === true){
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            }
            return json_encode(['status' => 'success', 'data' =>$deal]);
        }
        return json_encode(['status' => 'error', 'data' =>$model->errors]);
    }
    /**
     * 云运动 - 图片管理 - 验证图片类型名称是否存在
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/16
     * @param $name string 图片类型名称
     * @return string
     */
    public function actionPicTypeName($name)
    {
        $companyId = $this->companyId;
        $typeName = PicTypeForm::picTypeName($name,$companyId);
        if($typeName){
            return json_encode(['status'=>'error','message'=>'图片类型名称已经存在']);
        }
        return json_encode(['status'=>'success','message'=>'图片类型名称不存在']);
    }
    /**
     * 后台 - 图片管理 - 删除指定的数据
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/16
     * @param id          //获取前台需要删除数据的id
     * @return object     //返回删除数据成功与否结果
     */
    public function actionDelPicType($id)
    {
        $model   = new ImageManagementType();
        $result  = $model->getDel($id);
        if($result) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        }else{
            return json_encode(['status' => 'error', 'data' => '图片类型包含图片不能删除']);
        }
    }

    /**
     * 后台 - 图片管理 - 增加图片类型数据
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/16
     * @return object
     */
    public function actionPicTypeInsertPost()
    {
        $companyId = $this->companyId;
        $venueId   = $this->venueId;
        $post      = \Yii::$app->request->post();
        $model     = new PicTypeForm([]);
        if($model->load($post,'') && $model->validate($post)){
            $deal = $model->insertSave($companyId,$venueId);
            if($deal === true){
                return json_encode(['status' => 'success', 'data' => '添加成功']);
            }
            return json_encode(['status' => 'success', 'data' =>$model->errors]);
        }
        return json_encode(['status' => 'error', 'data' =>$model->errors]);
    }
    /**
     * 云运动 - 图片管理 - 获取图片类别名
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/17
     */
    public function actionGetPicType()
    {
        $id   = $this->nowBelongId;
        $type = $this->nowBelongType;
        $model   = new ImageManagementType();
        $type    = $model->getPicType($id,$type);
        return json_encode(['type'=>$type]);
    }
}
