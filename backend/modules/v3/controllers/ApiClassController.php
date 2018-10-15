<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 10:33
 */
namespace backend\modules\v3\controllers;
use backend\modules\v3\base\BaseController;
use backend\modules\v3\models\SellClassModel;
use common\models\base\AboutClass;
use common\models\base\Clock;
use yii\web\Response;
use backend\modules\v3\models\MemberCourseOrder;

class ApiClassController extends BaseController
{
    public $modelClass = 'backend\modules\v3\models\MemberCourseOrder';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                // restrict access to
                'Access-Control-Request-Method' => ['*'],
                // Allow only POST and PUT methods
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @api {get}      /v3/api-class/course-order-list  微信已购私课列表
     * @apiVersion      1.0.0
     * @apiName         微信已购私课列表
     * @apiGroup        member
     * @apiPermission  管理员
     * @apiParam  {string}  memberId   会员id
     * @apiParam  {string}  venueId    场馆id
     * @apiParamExample {json} 请求参数
     * get   /v3/api-member/course-order-list  微信已购私课列表
     *   {
     *      "memberId"  :  "2"               会员id
     *      "venueId"   :  "1"               公司id
     *   }
     * @apiDescription    微信已购私课列表
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/9
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/course-order-list
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     * {
     *  "code": 1,              //成功标识
     *  "status": "success",    //成功标识
     *  "message":"请求成功"     //成功提示信息
     *  "data": [
     *  {
     *      "id": "52051",                //私教课订单id
     *      "pic": "http://oo0oj2qmr.bkt.clouddn.com/5291961504247513.png?e=1504251113&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:aKmWbdmTWBWfBSAQR3PPl0QR5fg=",
     *      "product_name": "PT游泳课",    //私教课名称
     *      "course_amount": "10",        //总节数
     *      "overage_section": "10",      //剩余节数
     *      "money_amount": "3400.00"     //总金额
     *  },
     *  {
     *      "id": "52052",
     *      "pic": "http://oo0oj2qmr.bkt.clouddn.com/5291961504247513.png?e=1504251113&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:aKmWbdmTWBWfBSAQR3PPl0QR5fg=",
     *      "product_name": "PT游泳课",
     *      "course_amount": "2",
     *      "overage_section": "2",
     *      "money_amount": "0.00"
     *  },
     * ]
     * }
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/course-order-list
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *"code": 0,                             //参数传入是否合法
     *"status": "error",                     //错误状态
     *"message": "您还没有购买私教课",
     *}
     */
    public function actionCourseOrderList($memberId,$venueId)
    {
        $model = new MemberCourseOrder();
        $data = $model->getCourseOrderList($memberId,$venueId);
        if (!empty($data)) {
            return ['code' => 1, 'status' => 'success', 'data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '您还没有购买私教课'];
        }
    }

    /**
     * @api {get}       /v3/api-class/course-order-info  微信已购私课详情
     * @apiVersion      1.0.0
     * @apiName         微信已购私课详情.微信已购私课详情
     * @apiGroup        member
     * @apiPermission  管理员
     * @apiParam  {string}  id    私教课订单id
     * @apiParamExample {json} 请求参数
     * get   /v3/api-member/course-order-info  微信已购私课详情
     *   {
     *      "id"   :  "1"               私教课订单id
     *   }
     * @apiDescription    微信已购私课详情
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/9
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/course-order-info
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     * {
     *  "code": 1,              //成功标识
     *  "status": "success",    //成功标识
     *  "message":"请求成功"     //成功提示信息
     *  "data": {
     *      "pic": "http://oo0oj2qmr.bkt.clouddn.com/5291961504247513.png?e=1504251113&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:aKmWbdmTWBWfBSAQR3PPl0QR5fg=",
     *      "product_name": "PT游泳课",             //私教课名称
     *      "describe": "经常进行高，低冲击有氧操锻炼，有助于提高人体的心肺功能，耐力水平。能有效的燃烧体内多余的脂肪。达到塑身纤体的效果。",
     *      "course_duration": null,               //课程时长
     *      "unit_price": 340                      //课时费
     *      "price": [
     *       {
     *           "id": "4",
     *           "charge_class_id": "13",
     *           "course_package_detail_id": "9",
     *           "intervalStart": "1",             //最少节数
     *           "intervalEnd": "12",              //最多节数
     *           "unitPrice": "340",               //优惠单价
     *           "posPrice": "340",                //pos单价
     *           "create_time": "1499939403"
     *       }
     *   ]
     *  }
     * }
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/course-order-info
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,                             //参数传入是否合法
     *  "status": "error",                     //错误状态
     *  "message": "没有数据",
     *}
     */
    public function actionCourseOrderInfo($id)
    {
        $model = new MemberCourseOrder();
        $data = $model->getCourseOrderInfo($id);
        if (!empty($data)) {
            return ['code' => 1, 'status' => 'success', 'data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据', 'data' => []];
        }
    }

    /**
     * @api {get}       /v3/api-class/get-coach-list  教练列表
     * @apiVersion      1.0.0
     * @apiName         教练列表.教练列表
     * @apiGroup        chargeClass
     * @apiPermission  管理员
     * @apiParam  {string}  venueId      场馆id
     * @apiParam  {string}  orderTime    约课时间
     * @apiParamExample {json} 请求参数
     * get   /v3/api-class/get-coach-list  教练列表
     *   {
     *      "venueId"   :  "1"            //场馆id
     *      "orderTime" :  "1515491689"   //约课时间
     *   }
     * @apiDescription    微信公众号二次登陆
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/9
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/get-coach-list
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     * {
     *  "code": 1,              //成功标识
     *  "status": "success",    //成功标识
     *  "message":"请求成功"     //成功提示信息
     *  "data": [
     *      {
     *      "id": "446",         //教练id
     *      "pic": "",           //头像
     *      "name": "胡媛媛",     //名字
     *      "age": null,         //年龄
     *      "work_time": null,   //从业时间
     *      "isAccess": true     //是否可以预约：true 可以 ，false 不可以   （预约的时间段内教练有没有给其他人上课）
     *      },
     *      {
     *      "id": "605",
     *      "pic": "http://oo0oj2qmr.bkt.clouddn.com/4709461514365481.blob?e=1514369081&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:WyBF_iqKJBv3UMi5twLZiwGnnas=",
     *      "name": "唐成",
     *      "age": null,
     *      "work_time": null,
     *      "isAccess": true
     *      },
     *   ]
     * }
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/get-coach-list
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,                             //参数传入是否合法
     *  "status": "error",                     //错误状态
     *  "message": "没有数据",
     *}
     */
    public function actionGetCoachList($venueId,$orderTime)
    {
        $model = new MemberCourseOrder();
        $data = $model->getCoachList($venueId,$orderTime);
        if ($data) {
            return ['code' => 1, 'status' => 'success', 'data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据', 'data' => []];
        }
    }


    /**
     * @api {get}       /v3/api-class/show-coach-list  展示教练列表
     * @apiVersion      1.0.0
     * @apiName         展示教练列表.展示教练列表
     * @apiGroup        chargeClass
     * @apiPermission  管理员
     * @apiParam  {string}  venueId      场馆id
     * @apiParamExample {json} 请求参数
     * get   /v3/api-class/show-coach-list  教练列表
     *   {
     *      "venueId"   :  "1"            //场馆id
     *   }
     * @apiDescription    展示教练列表
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/9
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/show-coach-list
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     * {
     *  "code": 1,              //成功标识
     *  "status": "success",    //成功标识
     *  "message":"请求成功"     //成功提示信息
     *  "data": [
     *      {
     *      "id": "446",         //教练id
     *      "pic": "",           //头像
     *      "name": "胡媛媛",     //名字
     *      "age": null,         //年龄
     *      "work_time": null,   //从业时间
     *      },
     *      {
     *      "id": "605",
     *      "pic": "http://oo0oj2qmr.bkt.clouddn.com/4709461514365481.blob?e=1514369081&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:WyBF_iqKJBv3UMi5twLZiwGnnas=",
     *      "name": "唐成",
     *      "age": null,
     *      "work_time": null,
     *      },
     *   ]
     * }
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/show-coach-list
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,                             //参数传入是否合法
     *  "status": "error",                     //错误状态
     *  "message": "没有数据",
     *}
     */
    public function actionShowCoachList($venueId)
    {
        $model = new MemberCourseOrder();
        $data = $model->showCoachList($venueId);
        if ($data) {
            return ['code' => 1, 'status' => 'success', 'data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据', 'data' => []];
        }
    }


    /**
     * @api {get}       /v3/api-class/get-coach-info  教练详情
     * @apiVersion      1.0.0
     * @apiName         教练详情.教练详情
     * @apiGroup        chargeClass
     * @apiPermission  管理员
     * @apiParam  {string}  coachId      教练id
     * @apiParamExample {json} 请求参数
     * get   /v3/api-class/get-coach-info  教练详情
     *   {
     *      "coachId"   :  "1"            //教练id
     *   }
     * @apiDescription    教练详情
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/9
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/get-coach-info
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     * {
     *  "code": 1,              //成功标识
     *  "status": "success",    //成功标识
     *  "message":"请求成功"     //成功提示信息
     *  "data": {
     *      "id": "446",         //教练id
     *      "pic": "",           //头像
     *      "name": "胡媛媛",     //名字
     *      "age": null,         //年龄
     *      "work_time": null,   //从业时间
     *      "intro": "毕业于河南大学体育学院\n 亚洲体适能专业私人教练认证\n Adidas签约体适能教练认证\n Adidas-training专项认证\n BOSU国际专项认证\n台湾皮拉提斯课程专项认证\nA+健身学院产前产后私人教练证书\n 海培妈咪孕产初级体能训导师认证\n海培妈咪孕产中级体能训导师认证"
     *      }
     * }
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/get-coach-info
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,                             //参数传入是否合法
     *  "status": "error",                     //错误状态
     *  "message": "没有数据",
     *}
     */
    public function actionGetCoachInfo($coachId)
    {
        $model = new MemberCourseOrder();
        $data = $model->getCoachInfo($coachId);
        if ($data) {
            return ['code' => 1, 'status' => 'success', 'data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据', 'data' => []];
        }
    }


    /**
     * @api {get}       /v3/api-class/get-coach-lessons  展示课程列表
     * @apiVersion      1.0.0
     * @apiName         展示课程列表.展示课程列表
     * @apiGroup        chargeClass
     * @apiPermission  管理员
     * @apiParam  {string}  venueId      场馆id
     * @apiParamExample {json} 请求参数
     * get   /v3/api-class/show-coach-list  教练列表
     *   {
     *      "venueId"   :  "1"            //场馆id
     *   }
     * @apiDescription    展示课程列表
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/9
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/get-coach-lessons
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     * {
     *  "code": 1,              //成功标识
     *  "status": "success",    //成功标识
     *  "message":"请求成功"     //成功提示信息
     *  "data": [
     *    {
     *      "id": "126",
     *      "name": "其味无穷多",
     *      "valid_time": "0",
     *      "total_amount": null,
     *      "total_sale_num": "-1",
     *      "sale_start_time": "1514649600",
     *      "sale_end_time": "1556553600",
     *      "created_at": "1516095208",
     *      "status": "1",
     *      "app_amount": null,
     *      "show": "1",
     *      "courseName": "减脂"
     *    },
     *   ]
     * }
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/get-coach-lessons
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,                             //参数传入是否合法
     *  "status": "error",                     //错误状态
     *  "message": "没有数据",
     *}
     */
    public function actionGetCoachLessons($venueId)
    {
        $model = new MemberCourseOrder();
        $data = $model->getCoachLessons($venueId);
        if ($data) {
            return ['code' => 1, 'status' => 'success', 'data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据', 'data' => []];
        }
    }

    /**
     * @api {get}       /v3/api-class/get-lessons-info  私教课程详情
     * @apiVersion      1.0.0
     * @apiName         私教课程详情.私教课程详情
     * @apiGroup        chargeClass
     * @apiPermission   管理员
     * @apiParam  {string}  chargeId         私课id
     * @apiParamExample {json} 请求参数
     * get   /v3/api-class/get-lessons-info   私教课程详情
     *   {
     *      "chargeId"   :  "1"              //私课id
     *   }
     * @apiDescription    展示课程列表
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/22
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/get-lessons-info
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     * {
     *  "code": 1,              //成功标识
     *  "status": "success",    //成功标识
     *  "message":"请求成功"     //成功提示信息
     *  "data": {
     *          "id": "37",
     *          "name": "0元WD增肌课程2A",
     *          "valid_time": "365",
     *          "total_amount": "0.00",
     *          "total_sale_num": "999",
     *          "sale_start_time": "1500952881",
     *          "sale_end_time": "1532488881",
     *          "created_at": "1500952881",
     *          "status": "3",
     *          "app_amount": null,
     *          "show": "1",
     *          "describe": "111111234567爱的刚刚胜多负少的沙发斯蒂芬",
     *          "courseName": "艾博遗留课程",
     *          "chargeClassPrice": [
     *               {
     *                   "id": "249",
     *                   "charge_class_id": "37",
     *                   "course_package_detail_id": "459",
     *                   "intervalStart": "1",
     *                   "intervalEnd": "11",
     *                   "unitPrice": "350",
     *                   "posPrice": "350",
     *                   "create_time": "1516587819"
     *               }
     *          ]
     *       }
     * }
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/get-lessons-info
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,                             //参数传入是否合法
     *  "status": "error",                     //错误状态
     *  "message": "没有数据",
     *}
     */
    public function actionGetLessonsInfo($chargeId)
    {
        $model = new MemberCourseOrder();
        $data = $model->getLessonsInfo($chargeId);
        if ($data) {
            return ['code' => 1, 'status' => 'success', 'data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据', 'data' => []];
        }
    }

    /**
     * @api {get} /v3/api-class/get-all-venue   所有场馆
     * @apiVersion  1.0.0
     * @apiName        所有场馆
     * @apiGroup       chargeClass
     * @apiParam  {int}           companyId               公司id
     * @apiPermission 管理员
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-class/get-all-venue
     *   {
     *        "companyId":1,                 //公司id
     *   }
     * @apiDescription   所有场馆
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/7/4
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/get-all-venue
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情（成功）
     * {
     * "code": 1,                   //成功表示
     * "status": "success",         //成功状态
     * "message": "请求成功",        //成功信息
     * "data": [
     *      {
     *      "id": "2",                    //场馆id
     *      "name": "大上海瑜伽健身馆"       //场馆名称
     *      },
     *      {
     *      "id": "10",                  //场馆id
     *      "name": "大学路舞蹈健身馆"      //场馆名称
     *      }
     *   ]
     * }
     * @apiSuccessExample {json}返回值详情（失败）
     * {
     *   "code": 0,                         //失败标识
     *   "status": "error",                 //失败标识
     *   "message": "没有找到场馆信息"         //提示信息
     * }
     */
    public function actionGetAllVenue($companyId)
    {
        $model = new MemberCourseOrder();
        $data  = $model->getAllVenue($companyId);
        if ($data) {
            return ['code' => 1, 'message' => 'success', 'data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据', 'data' => []];
        }
    }

    /**
     * @api {post} /v3/api-class/get-seat-detail   团课座位详情
     * @apiVersion  1.0.0
     * @apiName        所有场馆
     * @apiGroup       member
     * @apiParam  {int}   memberId    会员id
     * @apiParam  {int}   cardId      会员卡id
     * @apiParam  {int}   classId     团课id
     * @apiPermission 管理员
     * @apiParamExample {json} 请求参数
     *   POST /v3/api-class/get-seat-detail   团课座位详情
     *   {
     *        "memberId"  :  1,
     *        "cardId"    :  955,
     *        "classId"   :  13957
     *   }
     * @apiDescription   所有场馆
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/27
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/get-seat-detail
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情（成功）
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "请求成功",
     *  "data": {
     *  "id": "2271",
     *  "start": "1517112000",
     *  "end": "1517115600",
     *  "class_date": "2018-01-28",
     *  "created_at": "1517016915",
     *  "status": "1",
     *  "course_id": "16",
     *  "coach_id": "64",
     *  "classroom_id": "40",
     *  "create_id": "304",
     *  "difficulty": "1",
     *  "desc": null,
     *  "pic": null,
     *  "class_limit_time": null,      //开课前几分钟不能约课
     *  "cancel_limit_time": null,     //开课前几分钟不能取消约课
     *  "least_people": null,
     *  "company_id": "1",
     *  "venue_id": "15",
     *  "seat_type_id": "42",
     *  "in_time": "0",
     *  "out_time": "0",
     *  "courseName": "空中瑜伽",
     *  "course_desrc": "又叫反重力瑜伽，利用空中瑜伽吊床，完成哈他瑜伽体式。练习者感受到身体体重，加深体式的伸展、阻力和正位能力，具有高效的放松、疗愈、瘦身效果，更具有趣味性和互动性。它可以塑型减脂，增强身体稳定性，改善肩颈问题，增强握力和核心控制力，改善腿型，轻松倒立，天然的美容课程。眩晕症，腕管综合征，刚刚做完面部整形，孕期，女性生理期，脊椎关节问题，术后未恢复，眼耳部疾病等身体问题不建议上大课，可在教练辅助下上一对一私教",
     *  "seat_type": "1",
     *  "seat_number": "4",
     *  "rows": "1",
     *  "columns": "1",
     *  "coachName": "王靖文",
     *  "seat": [
     *      {
     *         "id": "2271",
     *         "classroom_id": "40",
     *         "seat_type": "1",
     *         "seat_number": "4",
     *         "rows": "1",
     *         "columns": "1",
     *         "seat_type_id": "42",
     *         "authority": 1,      //是否有权限预约 ： 1 有 、     0  无
     *         "isToken": 0         //座位是否被占用 ： 1 被占用 、 0  没占用
     *       },
     *     ]
     *  }
     *}
     * @apiSuccessExample {json}返回值详情（失败）
     * {
     *   "code": 0,                         //失败标识
     *   "status": "error",                 //失败标识
     *   "message": ""         //提示信息
     * }
     */
    public function actionGetSeatDetail()
    {
        $param  = \Yii::$app->request->post();
        $model = new MemberCourseOrder();
        $data  = $model->getSeatDetail($param);
        return $data;
    }

    /**
     * @api {get} /v3/api-class/sell-class-list  销售用私教课列表
     * @apiVersion  1.0.0
     * @apiName        销售用私教课列表
     * @apiGroup       class
     * @apiParam  {int}   venueId    场馆id
     * @apiPermission 管理员
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-class/sell-class-list  销售用私教课列表
     *   {
     *        "venueId"    :  1     //场馆id
     *        "classType" :  1      //私教类别：1、普通私教课  2、小团体课
     *   }
     * @apiDescription   所有场馆
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/27
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/sell-class-list
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情（成功）
     *{
     *  "code": 1,                //成功码
     *  "status": "success",      //成功状态
     *  "message": "请求成功",     //成功提示信息
     *  "data": {
     *
     *  }
     *}
     * @apiSuccessExample {json}返回值详情（失败）
     * {
     *   "code"   : 0,            //失败码
     *   "status" : "error",      //失败状态
     *   "message": "没有数据"     //提示信息
     *   "data"   : []
     * }
     */
    public function actionSellClassList()
    {
        $param = \Yii::$app->request->get();
        $model = new SellClassModel();
        $data  = $model->getClassList($param);
        if ($data) {
            return ['code' => 1, 'status' => 'success', 'message' => '请求成功','data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据', 'data' => []];
        }
    }

    /**
     * @api {get} /v3/api-class/get-common-detail  普通私教课详情
     * @apiVersion  1.0.0
     * @apiName        普通私教课详情
     * @apiGroup       class
     * @apiParam  {int}   id    私教课id
     * @apiPermission 管理员
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-class/get-common-detail  普通私教课详情
     *   {
     *        "id"    :  1     //私教课id
     *   }
     * @apiDescription   所有场馆
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/3/1
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/get-common-detail
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情（成功）
     *{
     *  "code": 1,                //成功码
     *  "status": "success",      //成功状态
     *  "message": "请求成功",     //成功提示信息
     *  "data": {
     *        "id": "139",                          //私教课id
     *        "name": "普通私教开发测试",             //私教课名字
     *        "pic": "http://oo0oj2qmr.bkt.clouddn.com/9986571519873657.jpg?e=1519877257&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:iGuTIe1kTzR6eZZScZAuSzBNIA8=",
     *        "describe": "测试",                   //课程描述
     *        "appPrice": "100.00",                //移动端售价：为空的话不让购买
     *        "address": "东太康路大上海城3区6楼",    //场馆地址
     *        "courseName": "增肌",                 //课种名称
     *        "category": "PT常规课",               //课种类别
     *        "chargeClassPrice": [                //课程价格区间
     *           {
     *               "id": "258",
     *               "charge_class_id": "139",
     *               "course_package_detail_id": "575",
     *               "intervalStart": "5",         //最少节数
     *               "intervalEnd": "10",          //最多节数
     *               "unitPrice": "100",           //优惠单价
     *               "posPrice": "100",            //pos价
     *               "create_time": "1519873703"
     *           },
     *           {
     *               "id": "259",
     *               "charge_class_id": "139",
     *               "course_package_detail_id": "575",
     *               "intervalStart": "11",
     *               "intervalEnd": "15",
     *               "unitPrice": "90",
     *               "posPrice": "90",
     *               "create_time": "1519873703"
     *           }
     *        ]
     *  }
     *}
     * @apiSuccessExample {json}返回值详情（失败）
     * {
     *   "code"   : 0,            //失败码
     *   "status" : "error",      //失败状态
     *   "message": "没有数据"     //提示信息
     *   "data"   : []
     * }
     */
    public function actionGetCommonDetail()
    {
        $param = \Yii::$app->request->get();
        $model = new SellClassModel();
        $data  = $model->getCommonDetail($param);
        if ($data) {
            return ['code' => 1, 'status' => 'success', 'message' => '请求成功','data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据', 'data' => []];
        }
    }

    /**
     * @api {get} /v3/api-class/get-package-list  小团体私教套餐列表
     * @apiVersion  1.0.0
     * @apiName        小团体私教套餐列表
     * @apiGroup       class
     * @apiParam  {int}   id    私教课id
     * @apiPermission 管理员
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-class/get-package-list  小团体私教套餐列表
     *   {
     *        "id"    :  1     //私教课id
     *   }
     * @apiDescription   所有场馆
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/3/1
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/get-package-list
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情（成功）
     *{
     *  "code": 1,                //成功码
     *  "status": "success",      //成功状态
     *  "message": "请求成功",     //成功提示信息
     *  "data": {
    *      "id": "138",                           //私教课id
    *      "name": "啦啦啦小团体",                 //私教课名字
    *      "pic": "http://oo0oj2qmr.bkt.clouddn.com/5645141519872713.jpg?e=1519876313&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:YRiF9EzqonfjVXkQcDEyrXlILhQ=",
    *      "chargeClassNumbers": [                        //小团体套餐数组
    *           {
    *               "soldNum": "1",              //已购人数
    *               "class_people_id": "14",
    *               "charge_class_id": "138",
    *               "chargeClassPeople": {
    *                     "id": "14",
    *                     "people_least": "1",  //最少人数
    *                     "people_most": "3",   //最多人数
    *                     "least_number": "1"   //最低开课人数
    *               }
    *           },
    *           {
    *               "soldNum": "0",
    *               "class_people_id": "15",
    *               "charge_class_id": "138",
    *               "chargeClassPeople": {
    *                     "id": "15",
    *                     "people_least": "3",
    *                     "people_most": "5",
    *                     "least_number": "3"
    *               }
    *           }
    *      ]
     *  }
     *}
     * @apiSuccessExample {json}返回值详情（失败）
     * {
     *   "code"   : 0,            //失败码
     *   "status" : "error",      //失败状态
     *   "message": "没有数据"     //提示信息
     *   "data"   : []
     * }
     */
    public function actionGetPackageList()
    {
        $param = \Yii::$app->request->get();
        $model = new SellClassModel();
        $data  = $model->getPackageList($param);
        if ($data) {
            return ['code' => 1, 'status' => 'success', 'message' => '请求成功','data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据', 'data' => []];
        }
    }

    /**
     * @api {get} /v3/api-class/get-group-detail  小团体私教套餐详情
     * @apiVersion  1.0.0
     * @apiName        普通私教课详情
     * @apiGroup       class
     * @apiParam  {int}   classPeopleId    小团体人数区间id
     * @apiPermission 管理员
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-class/get-group-detail  小团体私教套餐详情
     *   {
     *        "charge_class_number_id"  :  1     //私课编号表id
     *   }
     * @apiDescription   所有场馆
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/3/1
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-class/get-group-detail
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情（成功）
     *{
     *  "code": 1,                //成功码
     *  "status": "success",      //成功状态
     *  "message": "请求成功",     //成功提示信息
     *  "data": {
     *         "id": "138",                 //私教课程id
     *          "name": "啦啦啦小团体",      //小团体课程名字
     *          "describe": "开发测试用",    //私教课程描述
     *          "pic": "http://oo0oj2qmr.bkt.clouddn.com/5645141519872713.jpg?e=1519876313&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:YRiF9EzqonfjVXkQcDEyrXlILhQ=",
     *          "type": "1",               //1、多课程  2、单课程
     *          "coursePackageDetail": [
     *              {
     *                 "id": "573",
     *                 "charge_class_id": "138",
     *                 "course_id": "115",
     *                 "course_num": "3",          //课程节数
     *                 "course_length": "60",      //课程时长
     *                 "original_price": "300.00", //课程价格
     *                 "sale_price": null,
     *                 "pos_price": null,
     *                 "type": "1",
     *                 "create_at": "1519872718",
     *                 "category": "1",
     *                 "app_original": null,
     *                 "course": {
     *                   "id": "115",
     *                   "courseName": "游泳"      //课程名字
     *                 }
     *              },
     *              {
     *                  "id": "574",
     *                  "charge_class_id": "138",
     *                  "course_id": "74",
     *                  "course_num": "3",
     *                  "course_length": "40",
     *                  "original_price": "300.00",
     *                  "sale_price": null,
     *                  "pos_price": null,
     *                  "type": "1",
     *                  "create_at": "1519872718",
     *                  "category": "1",
     *                  "app_original": null,
     *                  "course": {
     *                    "id": "74",
     *                    "courseName": "减脂"
     *              }
     *              }
     *              ],
     *              "chargeClassNumbers": [
     *                {
     *                   "charge_class_number_id": "29",  //私课编号id
     *                   "soldNum": "1",                  //已购人数
     *                   "class_people_id": "14",
     *                   "charge_class_id": "138",
     *                   "chargeClassPeople": {
     *                       "id": "14",
     *                       "unit_price": "2000.00",    //小团体优惠单价
     *                       "pos_price": "2000.00"      //小团体pos价
     *                   }
     *                }
     *          ]
     *  }
     *}
     * @apiSuccessExample {json}返回值详情（失败）
     * {
     *   "code"   : 0,            //失败码
     *   "status" : "error",      //失败状态
     *   "message": "没有数据"     //提示信息
     *   "data"   : []
     * }
     */
    public function actionGetGroupDetail()
    {
        $param = \Yii::$app->request->get();
        $model = new SellClassModel();
        $data  = $model->getGroupDetail($param);
        if ($data) {
            return ['code' => 1, 'status' => 'success', 'message' => '请求成功','data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据', 'data' => []];
        }
    }

}