<?php

namespace backend\controllers;

use backend\models\ChargeClass;
use backend\models\ChargeClassUpdate;
use backend\models\Employee;
use backend\models\MemberDetails;
use backend\models\PrivateServerRuleForm;
use backend\models\PrivateTeachRuleForm;
use backend\modules\v1\models\AboutRecordForm;
use Yii;
use common\models\Func;
use backend\models\ClassServer;
use backend\models\Server;
use backend\models\CardCategory;
use backend\models\Course;
use backend\models\ConfigForm;
use backend\models\Config;
use backend\models\AboutClass;
use backend\models\Member;
use backend\models\MemberCourseOrder;

class PrivateTeachController extends BaseController
{
    /**
     * 私教管理 - 首页 - 列表的展示
     * @return string
     * @auther 李广杨
     * @create 2017-3-21
     * @param
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 私教管理 - 首页 - 约课功能
     * @return string
     * @auther 李广杨
     * @create 2017-3-25
     * @param
     */
    public function actionAppointment()
    {
        return $this->render('appointment');
    }

    /**
     * 私教管理 - 首页 - 新增课程
     * @return string
     * @auther 程丽明
     * @create 2017-4-17
     * @param
     */
    public function actionAdd()
    {
        return $this->render('addProduct');
    }

    /**
     * @describe 后台私教课程管理 - 私教课程信息查询 - angularJs访问该控制器
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @return string
     * @throws \Exception
     */
    public function actionChargeClass()
    {
        $params = $this->get;
        $chargeClass = new ChargeClass();
        $chargeClassData = $chargeClass->search($params);
        $pagination = $chargeClassData->pagination;
        $pages = Func::getPagesFormat($pagination);

        return json_encode(['data' => $chargeClassData->models, 'pages' => $pages]);
    }

    /**
     *后台私教课程管理 - 私教课程信息查询 - 添加私教课程 -(第一步：新增私教课程）- 获取私教课程信息
     * @author Hou kaixin<houkaixin@itsports.club>
     * @create 2017/4/10
     * @return bool|string
     */
    public function actionGetClassType()
    {
        $model = new Course();
        $data = $model->getPrivateData();
        return json_encode($data);
    }

    /**
     *后台会员管理 - 私课模块- 收费课程删除
     * @author Huang  hua <huanghua@itsports.club>
     * @create 2017/3/31
     * @return bool|string
     */
    public function actionDeleteData()
    {
        $classId = Yii::$app->request->get('classId');
        $model = new ChargeClass();
        $delClass = $model->getClassDel($classId);
        if ($delClass) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     * 会员卡管理 - 私课管理 - 修改状态
     * @create 2017/4/12
     * @author huanghua<huanghua@itsports.club>
     * @param
     * @param
     * @return bool
     */
    public function actionEditClassStatus($id, $text)
    {
        $edit = ChargeClass::editStatus($id, $text);
        if ($edit === 1 || $edit === 2 || $edit === 3) {
            return json_encode(['status' => 'success', 'data' => '修改成功', 'edit' => $edit]);
        } else {
            return json_encode(['status' => 'error', 'data' => $edit]);
        }
    }

    /**
     * 私教管理 - 私教课程 - 修改移动端价格显示
     * @create 2017/12/25
     * @author zhumengke <zhumengke@itsports.club>
     * @return bool
     */
    public function actionEditClassShow()
    {
        $chargeId = \Yii::$app->request->get('chargeId');
        $model = new ChargeClass();
        $data = $model->editClassShow($chargeId);
        if ($data == true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '修改失败']);
        }
    }

    /**
     * 云运动 - 私课管理 - 自动过期
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/7/17
     * @return string
     */
    public function actionOverdue()
    {
        $model = new ChargeClass();
        $data = $model->overdue();
        if ($data === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $data]);
        }
    }

    /**
     * 云运动 - 私课管理 - 预约设置表单验证
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/4/13
     * @return string
     */
    public function actionSubscribeData()
    {
        $post = \Yii::$app->request->post();
        $model = new ConfigForm([]);
        if ($model->load($post, '') && $model->validate()) {
            $model->setConfigData($model);
            return json_encode(['status' => 'success', 'data' => '提交成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '提交失败']);
        }
    }

    /**
     * 云运动 - 私课管理 - 预约设置表单取值
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/4/13
     * @return string
     */
    public function actionConfigData()
    {
        $config = new Config();
        $configData = $config->configWay();
        return json_encode(['data' => $configData]);
    }

    /**
     * 会员卡管理 - 添加私教课程 - 获取课程套餐表数据（第三步绑定套餐）
     * @create 2017/4/13
     * @author houkaixin<houkaixin@itsports.club>
     * @param
     * @param
     * @return bool
     */
    public function actionGetClassServer()
    {
        $model = new ClassServer();
        $ClassServerData = $model->getClassServerData();
        return json_encode($ClassServerData);
    }

    /**
     * 会员卡管理 - 添加私教课程 - 获取服务套餐表数据（第三步绑定套餐）
     * @create 2017/4/13
     * @author houkaixin<houkaixin@itsports.club>
     */
    public function actionGetServer()
    {
        $model = new Server();
        $serverData = $model->getServerData($this->venueIds);
        return json_encode($serverData);
    }

    /**
     * 云运动 - 私课管理 - 新增多课种产品
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/4/19
     * @return string
     */
    public function actionAddPrivateTeach()
    {
        $post = \Yii::$app->request->post();
        $model = new PrivateTeachRuleForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->saveCharge();
            if ($data == false) {
                return json_encode(['status' => 'error', 'data' => ['name' => ['添加失败']]]);
            } elseif ($data === 'priceError') {
                return json_encode(['status' => 'error', 'data' => ['name' => ['总原价错误']]]);
            }
            return json_encode(['status' => 'success', 'data' => ['name' => ['添加成功']]]);
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 云运动 - 私课管理 - 新增单课种产品
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/11
     * @return string
     */
    public function actionAddPrivateServer()
    {
        $post = \Yii::$app->request->post();
        $model = new PrivateServerRuleForm();
        if ($model->load($post, '') && $model->validate()) {
            $model->saveCharge();
            return json_encode(['status' => 'success', 'data' => '添加成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 云运动 - 卡种 - 私课获取模板
     * @return string
     * @author 朱梦珂
     * @param  attr //获取的模板值
     * @param  $num //数值
     * @create 2017-4-21
     */
    public function actionAddVenue($attr, $num = 0)
    {
        $param = CardCategory::getTemplate($attr);
        $html = $this->renderPartial($param, ['num' => $num]);
        return json_encode(['html' => $html]);
    }

    public function actionAddServe()
    {
        return $this->render('addServe');
    }

    /**
     * 云运动 - 私课管理 - 上传图片
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/10
     * @return string
     */
    public function actionUpload()
    {
        $data = Func::uploadImage();
        return $data;
    }

    /**
     * @api {get} /private-teach/get-private-teach-all 所有私课课程
     * @apiVersion 1.0.0
     * @apiName 所有私课课程
     * @apiGroup charges
     * @apiPermission 管理员
     *
     * @apiParam  {int} memberId  会员id
     *
     * @apiParamExample {json} Request Example
     *  {
     *       "memberId": 2,         //会员id
     *  }
     * @apiDescription 会员管理 - 购买私课 - 获取所有私课课程<br/>
     * <span><strong>作    者：</strong></span>黄鹏举<br/>
     * <span><strong>邮    箱：</strong></span>huangpengju@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/8<br/>
     * <span><strong>调用方法：</strong></span>/private-teach/get-private-teach-all
     *
     * @apiSampleRequest  http://qa.aixingfu.net/private-teach/get-private-teach-all
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     *"data": {
     *  "alone": [                                                     //单节课程
     *      {
     *      "id": "1",                                                  //产品id
     *      "packName": "单节测试1",                                    //产品名称
     *      "name": "减脂",                                             //课种名称
     *      "pic": "http://oo0oj2qmr.bkt.clouddn.com/0.jpg?e",          //产品图片
     *      "original_price": "200",                                    //单节售价
     *      "memberOrder": true,                                        //true表示未买过，false表示买过
     *      "newMember": false,                                         //true表示是刚办卡会员(有区间数量用pos价)，false表示不是刚办卡会员（没有区间数量用单节售价）
     *      "chargeClassPriceAll": [
     *      {
     *          "intervalStart": "1",                                   //区间开始数量
     *          "intervalEnd": "11",                                    //区间结束数量
     *          "unitPrice": "150",                                     //优惠单价
     *          "posPrice": "150"                                       //pos价
     *      },
     *      {
     *         "intervalStart": "12",                                   //区间开始数量
     *          "intervalEnd": "20",                                    //区间结束数量
     *          "unitPrice": "100",                                     //优惠单价
     *          "posPrice": "100"                                       //pos价
     *      }
     *      ],
     *  "score": 4,                                                     //级别
     *  "scoreImg": {                                                   //星星
     *       "one": "img/x1.png",
     *      "two": "img/x1.png",
     *      "three": "img/x1.png",
     *      "four": "img/x1.png",
     *      "five": "img/x2.png"
     *       }
     *    }
     *   ],
     *  "many": [                                                      //套餐课程
     *      {
     *      "id": "2",                                                 //产品id
     *      "packName": "测试",                                        //产品名称
     *      "pic": "",                                                 //产品图片
     *      "courseStr": "减脂100节/塑形10节",                         //套餐详细
     *      "memberOrder": true,                                       //true表示未买过，false表示买过
     *      "totalPrice": 222,                                         //套餐总价
     *      "score": 4,                                                //级别
     *      "scoreImg": {                                              //星星 
     *      "one": "img/x1.png",
     *      "two": "img/x1.png",
     *      "three": "img/x1.png",
     *      "four": "img/x1.png",
     *      "five": "img/x2.png"
     *      }
     *   }
     *  ]
     *}
     * @apiErrorExample {json} 错误示例:
     * {
     *  "data": {
     *  "alone": [],
     *  "many": []
     *  }
     *  }
     */
    public function actionGetPrivateTeachAll($memberId = '')
    {
        $model = new ChargeClass();
        $data = $model->getClassInfo($memberId, $this->venueId);
        return json_encode(['data' => $data]);
    }

    /**
     * 后台 - 私课管理 - 返回所有教练数据
     * @author huangpengju <houkaixin@itsports.club>
     * @create 2017/5/19
     * @return object     //返回所有私课教练数据
     */
    public function actionPrivateCoach()
    {
        $model = new Employee();
        $data = $model->coachPrivateData($this->venueIds);
        return json_encode($data);
    }

    /**
     * @describe 后台私教管理 - 私教上课信息查询 - angularJs访问该控制器
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @return string
     * @throws \Exception
     */
    public function actionCoachClass()
    {
        $params = $this->get;
        $coachClass = new AboutClass();
        $coachClassData = $coachClass->search($params);
        $pagination = $coachClassData->pagination;
        $pages = Func::getPagesFormat($pagination);

        return json_encode(['data' => $coachClassData->models, 'pages' => $pages]);
    }

    /**
     *后台私教管理 - 会员上课信息查询 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/5/24
     * @return bool|string
     */
    public function actionGetAboutData()
    {
        $MemberId = Yii::$app->request->get('id');
        $aboutId = Yii::$app->request->get('aboutId');
        $model = new AboutClass();
        $MemberData = $model->getMemberData($MemberId, $aboutId);
        return json_encode($MemberData);
    }

    /**
     * @私课管理 - 私教上下课 - 获取教练信息
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/2
     * @return array
     */
    public function actionGetFingerprint()
    {
        $id = \Yii::$app->request->get('id');
        $model = new AboutClass();
        $data = $model->getFingerprint($id);
        return json_encode(['fingerprint' => $data]);
    }

    /**
     *私课管理 - 会员信息查询 - 上课状态修改
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/5/25
     * @return bool|string
     */
    public function actionUpdateStatus()
    {
        $id = \Yii::$app->request->get('id');
        $type = \Yii::$app->request->get('type');
        $course = \Yii::$app->request->get('course');
        $model = new AboutClass();
        $status = $model->getUpdateClass($id, $type, $course);
        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }
    }

    /**
     *私课管理 - 私教上下课 - 访问到场离场记录表
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/5/25
     * @return bool|string
     */
    public function actionGetMemberId()
    {
        $id = \Yii::$app->request->get('id');
        $venueId = $this->venueId;
        $model = new Member();
        $status = $model->getMemberId($id, $venueId);
        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => true]);
        } else {
            return json_encode(['status' => 'error', 'data' => false]);
        }
    }

    /**
     *私课管理 - 私教上课取消课程 - 会员上课记录表删除
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/4/17
     * @return bool|string
     */
    public function actionClassDel()
    {
        $aboutClassId = Yii::$app->request->get('id');
        $model = new AboutClass();
        $delRes = $model->getClassDataDel($aboutClassId);
        if ($delRes) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     * @api {get} /private-teach/employee-info 获取所有私教员工
     * @apiVersion 1.0.0
     * @apiName 所有私教员工
     * @apiGroup private-teach
     * @apiPermission 管理员
     *
     * @apiParam {object} data   私教员工
     *
     * @apiDescription 私教管理列表-所有私教员工信息
     * <br/>
     * <span><strong>作    者：</strong></span>黄华<br>
     * <span><strong>邮    箱：</strong></span>huanghua@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/27
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/private-teach/employee-info
     * @apiSampleRequest  http://qa.uniwlan.com/private-teach/employee-info
     *
     * @apiSuccess(返回值) {object}  data   私教员工
     *
     */
    public function actionEmployeeInfo($pid = null)
    {
        $model = new Employee();
        $data = $model->getAdviser($pid);

        return json_encode($data);
    }

    /**
     * @api {get} /private-teach/member 搜索会员
     * @apiVersion 1.0.0
     * @apiName 搜索会员
     * @apiGroup private-teach
     * @apiPermission 管理员
     *
     * @apiParam {int} MemberId   会员id
     *
     * @apiDescription 私教管理-课程排期-登记预约会员
     * <br/>
     * <span><strong>作    者：</strong></span>黄华<br>
     * <span><strong>邮    箱：</strong></span>huanghua@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/31
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/private-teach/member
     * @apiSampleRequest  http://qa.uniwlan.com/private-teach/member
     *
     * @apiSuccess(返回值) {object}  memberInfo  会员名手机号编号
     *
     */
    public function actionMember()
    {
        $params = $this->get;
        $params['venueId'] = $this->venueId;
        $model = new Member();
        $memberInfo = $model->memberData($params);

        return json_encode($memberInfo);
    }

    /**
     * @api {get} /private-teach/member-details 预约课程详情信息
     * @apiVersion 1.0.0
     * @apiName 预约课程详情信息
     * @apiGroup private-teach
     * @apiPermission 管理员
     *
     * @apiParam {int} MemberId   会员id
     *
     * @apiDescription 私教管理-课程排期-预约课程详情
     * <br/>
     * <span><strong>作    者：</strong></span>黄华<br>
     * <span><strong>邮    箱：</strong></span>huanghua@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/31
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/private-teach/member
     * @apiSampleRequest  http://qa.uniwlan.com/private-teach/member-details
     *
     * @apiSuccess(返回值) {object}  memberInfo  预约课程详情
     *
     */
    public function actionMemberDetails()
    {
        $MemberId = Yii::$app->request->get('MemberId');
        $classId = Yii::$app->request->get('classId');
        $aboutId = Yii::$app->request->get('id');
        $model = new Member();
        $memberInfo = $model->memberDetailsData($MemberId, $aboutId, $classId);
        return json_encode($memberInfo);
    }

    /**
     *私课管理 - 课程排期 - 预约状态修改
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/5/25
     * @return bool|string
     */
    public function actionUpdateClassStatus()
    {
        $id = \Yii::$app->request->get('id');
        $model = new AboutClass();
        $status = $model->getUpdateClassDate($id);
        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }
    }

    /**
     * @api {post} /private-teach/set-about-class-charge 预约私课课程
     * @apiVersion 1.0.0
     * @apiName 预约私课课程
     * @apiGroup private-teach
     * @apiPermission 管理员
     *
     * @apiParam  {int}    classId        课程ID.
     * @apiParam  {string} aboutType      预约类型.
     * @apiParam  {string} classDate      课程时间.
     * @apiParam  {string} start          课程开始时间.
     * @apiParam  {string} end            课程结束时间.
     * @apiParam  {int}   memberId        会员Id.
     * @apiParam  {string} _csrf_backend  csrf验证.
     *
     * @apiParamExample {json} Request Example
     *   POST /private-teach/set-about-class-charge
     *   {
     *       "classId": 125,
     *       "aboutType": "mobile",
     *       "classDate": 3,
     *       "start": 3,
     *       "end": 3,
     *       "memberId":2,
     *       "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 管理员可以进入验卡页面可以给会员预约课程
     *<br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/24
     *
     * @apiSampleRequest  http://qa.uniwlan.com/private-teach/set-about-class-charge
     *
     * @apiSuccess (返回值) {string} status 取消状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','message'=>'预约成功','data':返回刚才预约ID}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','message'=>'预约失败','data':预约失败数据}
     */
    public function actionSetAboutClassCharge()
    {
        $post = \Yii::$app->request->post();         //接收预约数据
        $scenario = 'charge';
        $about = new AboutRecordForm([], $scenario);
        if ($about->load($post, '') && $about->validate()) {
            $save = $about->saveAbout();
            if ($save === 'not repeat') {
                return json_encode(['status' => 'repeat', 'message' => '预约重复', 'data' => $save]);
            } else if (isset($save->id)) {
                $about->sendMessage($this->companyId, $this->venueId);             //发送预约成功短信
                return json_encode(['status' => 'success', 'message' => '预约成功', 'data' => $save->id]);
            } else {
                return json_encode(['status' => 'error', 'message' => $save, 'data' => $save]);
            }
        } else {
            return json_encode(['status' => 'error', 'message' => '预约失败', 'data' => $about->errors]);
        }
    }

    /**
     *私课管理 - 课程排期 - 课程预约单击私教产片遍历出所有买过的私教课程
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/2
     * @return bool|string
     */
    public function actionMemberClass()
    {
        $MemberId = Yii::$app->request->get('MemberId');
        if (!empty($MemberId)) {
            $model = new MemberCourseOrder();
            $memberInfo = $model->memberClassData($MemberId);
            return json_encode($memberInfo);
        } else {
            return false;
        }
    }

    /**
     *私课管理 - 课程排期 - 课程预约单击私教产品选择课程
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/14
     * @return bool|string
     */
    public function actionChooseClass()
    {
        $orderId = Yii::$app->request->get('orderId');
        if (!empty($orderId)) {
            $model = new MemberCourseOrder();
            $memberInfo = $model->ChooseClass($orderId);
            return json_encode($memberInfo[0]);
        } else {
            return false;
        }
    }

    /**
     * 云运动 - 选择私课课程 - 接口
     * @author 黄华 <huangpengju@itsports.club>
     * @create 2017/5/19
     * @return string
     */
    public function actionGetPrivateTeachClass()
    {
        $MemberId = Yii::$app->request->get('MemberId');
        $venueId = $this->venueId;
        if (!empty($MemberId)) {
            $model = new MemberCourseOrder();
            $data = $model->getClassInfo($MemberId, $venueId);
            return json_encode(['data' => $data]);
        } else {
            return false;
        }
    }

    /**
     * @api {get} /private-teach/charge-class-details 私教服务详情、私教课程详情
     * @apiVersion 1.0.0
     * @apiName 私教服务详情、私教课程详情
     * @apiGroup private-teach
     * @apiPermission 管理员
     *
     * @apiParam  {int} chargeClassId  私课ID.
     *
     * @apiParamExample {json} Request Example
     *  {
     *       "chargeClassId": 2,
     *  }
     * @apiDescription 私课管理 - 私教服务详情、私教课程详情<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br/>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/8<br/>
     * <span><strong>调用方法：</strong></span>/private-teach/charge-class-details
     *
     * @apiSampleRequest  http://qa.uniwlan.com/private-teach/charge-class-details
     *
     * @apiSuccess (返回值) {string} status 取消状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * Array
     * (
     * [id] => 7
     * [name] => 形体芭蕾
     * [valid_time] => 23
     * [activated_time] => 234
     * [total_sale_num] => 34
     * [sale_start_time] => 1496073600
     * [sale_end_time] => 1499356800
     * [describe] => 4354波特忍一会涂鸦
     * [pic] => http://oo0oj2qmr.bkt.clouddn.com/19.jpeg?e=1496650626&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:xiC739XZoIqOoLuZVfYV-jPRE8Q=
     * [total_amount] => 34
     * [total_pos_price] => 34
     * [cname] => 舞蹈
     * [oname] => 大上海馆
     * )
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionChargeClassDetails()
    {
        $chargeClassId = Yii::$app->request->get('chargeClassId');
        if (!empty($chargeClassId)) {
            $model = new ChargeClass();
            $chargeClassDetails = $model->chargeClassDetails($chargeClassId);
            return json_encode($chargeClassDetails);
        } else {
            return false;
        }
    }

    /**
     * 云运动 - 私教管理 - 私教详情修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/12/21
     * @return boolean
     */
    public function actionChargeClassUpdate()
    {
        $post = \Yii::$app->request->post();
        $model = new ChargeClassUpdate();
        $model->setScenario($post['scenarios']);
        if ($model->load($post, '') && $model->validate()) {
            if ($post['scenarios'] == 'attributes') {
                $result = $model->attributesUpdate();      //基本属性修改
            } elseif ($post['scenarios'] == 'course') {
                $result = $model->courseUpdate();          //课种选择修改
            } elseif ($post['scenarios'] == 'price') {
                $result = $model->priceUpdate();           //产品价格修改
            } elseif ($post['scenarios'] == 'sellVenue') {
                $result = $model->sellVenueUpdate();       //售卖场馆修改
            } elseif ($post['scenarios'] == 'gift') {
                $result = $model->giftUpdate();            //赠品设置修改
            } elseif ($post['scenarios'] == 'transfer') {
                $result = $model->transferUpdate();        //转让设置修改
            } elseif ($post['scenarios'] == 'note') {
                $result = $model->noteUpdate();            //课程介绍、照片修改
            } else {
                $result = $model->dealUpdate();            //绑定合同修改
            }
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台验卡管理 - 会员购买私课到期时间 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/7/12
     * @return bool|string
     */
    public function actionExpireTime()
    {
        $memberId = Yii::$app->request->get('memberId');
        if (!empty($memberId)) {
            $chargeClass = new MemberCourseOrder();
            $chargeClassData = $chargeClass->expireTime($memberId);
            return json_encode($chargeClassData);
        } else {
            return false;
        }
    }

    /**
     * @api {post} /private-teach/update-charge-pic 修改私教图片
     * @apiVersion 1.0.0
     * @apiName 修改私教图片
     * @apiGroup private-teach
     * @apiPermission 管理员
     *
     * @apiParam  {int}    classId        课程ID.
     * @apiParam  {string} pic        会员Id.
     * @apiParam  {string} _csrf_backend  csrf验证.
     *
     * @apiParamExample {json} Request Example
     *   POST /private-teach/set-about-class-charge
     *   {
     *       "classId": 125,
     *       "pic"     : 'jashdkashdkasdjqwwodjwiournsdcm,snxccksmdbjsdfhajks'
     *       "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 管理员可以进入验卡页面可以给会员预约课程
     *<br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/24
     *
     * @apiSampleRequest  http://qa.uniwlan.com/private-teach/update-charge-pic
     *
     * @apiSuccess (返回值) {string} status 取消状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','message'=>'成功','data':返回刚才预约ID}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','message'=>'失败','data':预约失败数据}
     */
    public function actionUpdateChargePic()
    {
        $post = \Yii::$app->request->post();         //接收预约数据
        $about = new ChargeClass();
        $save = $about->updateChargePic($post);
        if ($save === true) {
            return json_encode(['status' => 'success', 'message' => '修改成功', 'data' => '修改成功']);
        }
        return json_encode(['status' => 'error', 'message' => '修改成功', 'data' => $save]);
    }

    /**
     * @私课管理 - 私课下课打卡 - 会员录入指纹
     * @author zhumengke <huanghua@itsports.club>
     * @create 2017/9/22
     * @return bool|string
     */
    public function actionInputFingerprint()
    {
        $post = \Yii::$app->request->post();
        if (!empty($post)) {
            $model = new MemberDetails();
            $data = $model->inputFingerprint($post);
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        }
    }
}
