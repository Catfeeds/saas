<?php
namespace backend\modules\v1\controllers;

use backend\modules\v1\models\Message;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class MessageController extends BaseController
{
    public $modelClass = 'backend\modules\v1\models\Message';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'],$actions['delete'],$actions['view']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    /**
     * @api {get} /v1/message  消息列表
     * @apiName        1消息列表
     * @apiGroup       private-group
     * @apiParam  {string}            memberId              会员ID
     * @apiParam  {string}            fields                可选,选择显示字段(例:fields=id,type_name,name,create_name,create_at)
     * @apiParam  {string}            page                  页码（可选，默认1）
     * @apiParam  {string}            per-page              每页显示数（可选，默认20）
     * @apiDescription   消息列表
     * <br/>
     * <span><strong>作    者：</strong></span>张晓兵<br/>
     * <span><strong>邮    箱：</strong></span>zhangxiaobing@itsports.club
     * <span><strong>创建时间：</strong></span>2018/01/31
     * @apiSampleRequest  http://qa.aixingfu.net/v1/message
     * @apiSuccess (返回值) {json} data
     * @apiSuccessExample {json}返回值详情（成功）
     {
        "message": "",
        "code": 1,
        "status": 200,
        "data": {
            "items": [
                {
                    "id": "100795", //预约消息ID
                    "status": 8,//8待预约，9预约失败
                    "type": "3",//3小团体课程，4小团体服务
                    "coach": "高陈静",//教练
                    "start": "1517454000",//开课时间
                    "is_read": 0,//0未读 1已读
                    "create_at":"1517454000",//排课时间
                    "had_about_num":"3",//已预约人数
                    "class_info": {//小团体课详情
                        "id": "4",
                        "class_number": "01311507318918",
                        "sell_number": "3",
                        "surplus": "0",
                        "total_class_num": "6",
                        "attend_class_num": 6,
                        "valid_time": null,
                        "sale_num": "80",
                        "surplus_sale_num": "80",
                        "venue_address": "东太康路大上海城3区6楼",
                        "people_least": 2,
                        "people_most": 3,
                        "least_number": 2,
                        "charge_class_type": 2,
                        "charge_class_pic": "http://oo0oj2qmr.bkt.clouddn.com/4521511517382430.jpg?e=1517386030&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:IYCqq51VqzwyTqcZet1yOofnF-U=",
                        "charge_class_name": "多人课程",
                        "charge_class_describe": "如何",
                        "course_package": [
                            {
                                "id": "556",
                                "course_num": null,
                                "course_length": "55",
                                "original_price": "100.00",
                                "course_name": "PT常规课"
                            }
                        ],
                        "price": "1800.00",
                        "had_buy": 0
                    }
                }
            ],
            "_links": {
                "self": {
                    "href": "http://127.0.0.2/v1/message/index?memberId=95337&page=1"
                }
            },
            "_meta": {
                "totalCount": 1,
                "pageCount": 1,
                "currentPage": 1,
                "perPage": 20
            }
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
    public function prepareDataProvider()
    {
        $memberId = Yii::$app->request->get('memberId', 0);
        if(empty($memberId)) return $this->error('参数缺失');

        $query = Message::find()->where(['member_id'=>$memberId, 'type'=>[3,4], 'status'=>[8,9]]);

        $query->orderBy('id desc');
        return new ActiveDataProvider(['query' => $query]);
    }

    /**
     * @api {get} /v1/message/view  消息详情
     * @apiName        2消息详情
     * @apiGroup       private-group
     * @apiParam  {string}            id                   预约消息ID
     * @apiDescription   消息详情
     * <br/>
     * <span><strong>作    者：</strong></span>张晓兵<br/>
     * <span><strong>邮    箱：</strong></span>zhangxiaobing@itsports.club
     * <span><strong>创建时间：</strong></span>2018/01/31
     * @apiSampleRequest  http://qa.aixingfu.net/v1/message/view
     * @apiSuccess (返回值) {json} data
     * @apiSuccessExample {json}返回值详情（成功）
    {
        "message": "",
        "code": 1,
        "status": 200,
        "data": {
            "id": "100795", //预约消息ID
            "status": 8,//8待预约，1已预约
            "type": "3",//3小团体课程，4小团体服务
            "coach": "高陈静",//教练
            "start": "1517454000",//开课时间
            "is_read": 0,//0未读 1已读
            "class_info": {//小团体课详情
                "id": "4",
                "class_number": "01311507318918",
                "sell_number": "3",
                "surplus": "0",
                "total_class_num": "6",
                "attend_class_num": 6,
                "valid_time": null,
                "sale_num": "80",
                "surplus_sale_num": "80",
                "venue_address": "东太康路大上海城3区6楼",
                "people_least": 2,
                "people_most": 3,
                "least_number": 2,
                "charge_class_type": 2,
                "charge_class_pic": "http://oo0oj2qmr.bkt.clouddn.com/4521511517382430.jpg?e=1517386030&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:IYCqq51VqzwyTqcZet1yOofnF-U=",
                "charge_class_name": "多人课程",
                "charge_class_describe": "如何",
                "course_package": [
                    {
                        "id": "556",
                        "course_num": null,
                        "course_length": "55",
                        "original_price": "100.00",
                        "course_name": "PT常规课"
                    }
                ],
                "price": "1800.00",
                "had_buy": 0
            }
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
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $model->is_read = 1;
        return $model->save() ? $model : $model->errors;
    }

    /**
     * @api {get} /v1/message/about  预约小团体课
     * @apiName        3预约小团体课
     * @apiGroup       private-group
     * @apiParam  {string}            id                   预约消息ID
     * @apiDescription   预约小团体课
     * <br/>
     * <span><strong>作    者：</strong></span>张晓兵<br/>
     * <span><strong>邮    箱：</strong></span>zhangxiaobing@itsports.club
     * <span><strong>创建时间：</strong></span>2018/01/31
     * @apiSampleRequest  http://qa.aixingfu.net/v1/message/about
     * @apiSuccess (返回值) {json} data
     * @apiSuccessExample {json}返回值详情（成功）
    {
        "message": "",
        "code": 1,
        "status": 200,
        "data": {
            "id": "100795", //预约消息ID
            "status": 8,//8待预约，1已预约
            "type": "3",//3小团体课程，4小团体服务
            "coach": "高陈静",//教练
            "start": "1517454000",//开课时间
            "is_read": 0,//0未读 1已读
            "class_info": {//小团体课详情
                "id": "4",
                "class_number": "01311507318918",
                "sell_number": "3",
                "surplus": "0",
                "total_class_num": "6",
                "attend_class_num": 6,
                "valid_time": null,
                "sale_num": "80",
                "surplus_sale_num": "80",
                "venue_address": "东太康路大上海城3区6楼",
                "people_least": 2,
                "people_most": 3,
                "least_number": 2,
                "charge_class_type": 2,
                "charge_class_pic": "http://oo0oj2qmr.bkt.clouddn.com/4521511517382430.jpg?e=1517386030&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:IYCqq51VqzwyTqcZet1yOofnF-U=",
                "charge_class_name": "多人课程",
                "charge_class_describe": "如何",
                "course_package": [
                    {
                        "id": "556",
                        "course_num": null,
                        "course_length": "55",
                        "original_price": "100.00",
                        "course_name": "PT常规课"
                    }
                ],
                "price": "1800.00",
                "had_buy": 0
            }
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
    public function actionAbout($id)
    {
        $model = $this->findModel($id);
        if($model->status == 8) $model->status = 1;

        return $model->save() ? $model : $model->errors;
    }

    private function findModel($id)
    {
        $model = Message::findOne($id);
        if(!$model) throw new NotFoundHttpException();
        return $model;
    }

}
