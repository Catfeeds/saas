<?php
namespace backend\modules\v1\controllers;

use Yii;
use backend\modules\v1\models\ChargeClassNumber;
use yii\data\ActiveDataProvider;

class ChargeClassNumberController extends BaseController
{
    public $modelClass = 'backend\modules\v1\models\ChargeClassNumber';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'],$actions['delete']);
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        return $actions;
    }

    /**
     * @api {get} /v1/charge-class-number  小团体课列表
     * @apiName        1小团体课列表
     * @apiGroup       private-group
     * @apiParam  {string}            venueId               场馆ID(小团体课列表)
     * @apiParam  {string}            memberId              会员ID（已购买的小团体课列表)
     * @apiParam  {string}            fields                可选,选择显示字段(例:fields=id,type_name,name,create_name,create_at)
     * @apiParam  {string}            page                  页码（可选，默认1）
     * @apiParam  {string}            per-page              每页显示数（可选，默认20）
     * @apiDescription   小团体课列表
     * <br/>
     * <span><strong>作    者：</strong></span>张晓兵<br/>
     * <span><strong>邮    箱：</strong></span>zhangxiaobing@itsports.club
     * <span><strong>创建时间：</strong></span>2018/01/24
     * @apiSampleRequest  http://qa.aixingfu.net/v1/charge-class-number
     * @apiSuccess (返回值) {json} data
     * @apiSuccessExample {json}返回值详情（成功）
    {
      "message": "",
      "code": 1,
      "status": 200,
      "data": {
        "items": [
          {
            "id": "10",
            "class_number": "01241357127583",
            "sell_number": "5",
            "surplus": "5",
            "total_class_num": "50",
            "attend_class_num": 50,
            "valid_time": null,
            "sale_num": "55",
            "surplus_sale_num": "55",
            "people_least": 3,
            "people_most": 5,
            "least_number": 3,
            "charge_class_pic": "http://oo0oj2qmr.bkt.clouddn.com/6635741516773433.jpg?e=1516777035&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:VHB8lthcdEMRzpuxGkusGxhV5dU=",
            "charge_class_name": "kecheng",
          },
          {
            "id": "9",
            "class_number": "01241355308540",
            "sell_number": "5",
            "surplus": "5",
            "total_class_num": "11",
            "attend_class_num": 11,
            "valid_time": "60",
            "sale_num": "2",
            "surplus_sale_num": "2",
            "people_least": 3,
            "people_most": 5,
            "least_number": 3,
            "charge_class_pic": "http://oo0oj2qmr.bkt.clouddn.com/1562201516773333.jpg?e=1516776933&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:kPs_QnyW9Nf1W88o9-9IyYEfZpI=",
            "charge_class_name": "ddd",
          },
         ],
        "_links": {
          "self": {
            "href": "http://127.0.0.2/v1/charge-class-number/index?venueId=76&page=1"
          }
        },
        "_meta": {
          "totalCount": 5,
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
        $venueId = Yii::$app->request->get('venueId', 0);
        $memberId = Yii::$app->request->get('memberId', 0);
        if(empty($venueId) && empty($memberId)) return $this->error('参数缺失');

        $query = ChargeClassNumber::find();
        if($venueId) $query->andWhere(['venue_id'=>$venueId]);
        if($memberId){
            $query->joinWith('memberCourseOrder mco')->andWhere(['mco.member_id'=>$memberId])->andWhere(['not', ['mco.class_number_id' => NULL]]);
        }else{
            $query->andWhere(['>', 'surplus', 0]);
        }

        $query->orderBy('id desc');
        return new ActiveDataProvider(['query' => $query]);
    }

    /**
     * @api {get} /v1/charge-class-number/view  小团体课详情
     * @apiName        2小团体课详情
     * @apiGroup       private-group
     * @apiParam  {string}            id                   小团体课ID
     * @apiDescription   小团体课列表
     * <br/>
     * <span><strong>作    者：</strong></span>张晓兵<br/>
     * <span><strong>邮    箱：</strong></span>zhangxiaobing@itsports.club
     * <span><strong>创建时间：</strong></span>2018/01/25
     * @apiSampleRequest  http://qa.aixingfu.net/v1/charge-class-number/view
     * @apiSuccess (返回值) {json} data
     * @apiSuccessExample {json}返回值详情（成功）
    {
        "message": "",
        "code": 1,
        "status": 200,
        "data": {
            "id": "10",
            "class_number": "01241357127583",//编号
            "sell_number": "5",//售卖数量
            "surplus": "5",//剩余数量
            "total_class_num": "50",//总节数
            "attend_class_num": 50,//剩余节数
            "valid_time": null,//产品有效期(天)
            "sale_num": "55",//售卖课程套数
            "surplus_sale_num": "55",//	售卖课程剩余套数
            "people_least": 3,//最少人数
            "people_most": 5,//最多人数
            "least_number": 3,//最低开课人数
            "charge_class_pic": "http://oo0oj2qmr.bkt.clouddn.com/6635741516773433.jpg?e=1516777035&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:VHB8lthcdEMRzpuxGkusGxhV5dU=",//图片
            "charge_class_name": "kecheng",//名称
            "charge_class_describe": "dsfffff",//介绍
            "course_package": [
                {
                    "id": "560",
                    "course_num": null,//课量
                    "course_length": "50",//时长
                    "original_price": "50.00",//单节原价
                    "course_name": "PT常规课"//课程名称
                }
            ],
            "price":"0.01",//价格
            "had_buy":0,//0未购买1已购买
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

}
