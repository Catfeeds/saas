<?php
namespace backend\modules\v1\controllers;

use Yii;
use backend\modules\v1\models\Feedback;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class FeedbackController extends BaseController
{
    public $modelClass = 'backend\modules\v1\models\Feedback';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'],$actions['delete']);
        return $actions;
    }

    /**
     * @api {post} /v1/feedback/create  提交反馈内容
     * @apiName        2提交反馈内容
     * @apiGroup       feedback
     * @apiParam  {string}            type_id              类型ID，必填
     * @apiParam  {string}            from                 来源，必填，可选项（android_customer->安卓会员端,ios_customer->IOS会员端）
     * @apiParam  {string}            venue_id             场馆ID，必填
     * @apiParam  {string}            user_id              会员ID，必填
     * @apiParam  {string}            content              内容，必填
     * @apiParam  {string}            occurred_at          故障发生时间，时间戳，到秒，可选
     * @apiParam  {file}              pics                 图片文件，数组形式传递, pics[]
     * @apiDescription   提交反馈内容
     * <br/>
     * <span><strong>作    者：</strong></span>张晓兵<br/>
     * <span><strong>邮    箱：</strong></span>zhangxiaobing@itsports.club
     * <span><strong>创建时间：</strong></span>2018/02/06
     * @apiSampleRequest  http://qa.aixingfu.net/v1/feedback/create
     * @apiSuccess (返回值) {json} data
     * @apiSuccessExample {json}返回值详情（成功）
    {
        "message": "",
        "code": 1,
        "status": 201,
        "data": {
            "type_id": "1",
            "from": "android_customer",
            "venue_id": "76",
            "user_id": "100",
            "content": "app",
            "company_id": 1,
            "created_at": 1517907110,
            "updated_at": 1517907110,
            "id": 2
        }
    }
     * @apiSuccessExample {json}返回值详情（失败）
    {
        "message": "",
        "code": 0,
        "status": 422,
        "data": []
    }
     */

    public function actionCreate()
    {
        $model = new Feedback();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if(isset($_FILES['pics'])) $model->pics = UploadedFile::getInstancesByName('pics');
        if ($model->save()) {
            $response = Yii::$app->getResponse();
            $response->setStatusCode(201);
        } elseif (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
        }
        return $model;
    }
}
