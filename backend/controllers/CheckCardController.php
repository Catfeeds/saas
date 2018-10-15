<?php

namespace backend\controllers;

use backend\models\AboutClass;
use backend\models\AboutYard;
use backend\models\CheckCard;
use backend\models\EntryRecord;
use backend\models\Goods;
use backend\models\GoodsType;
use backend\models\GroupClass;
use backend\models\LeaveRecord;
use backend\models\LeaveRecordForm;
use backend\models\Member;
use backend\models\MemberCard;
use backend\models\MemberUpdateForm;
use backend\models\Seat;
use backend\modules\v1\models\AboutRecordForm;
use common\models\Func;

class CheckCardController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDetail()
    {
        $id = \Yii::$app->request->get('id');
        return $this->render('detail', ['id' => $id]);
    }

    /**
     * 云运动 - 验卡系统 - 获取会员数据
     * @author lihuien<lihuien@itsports.club>
     * @param int $id //会员卡id
     * @return string
     */
    public function actionGetCheckCardData($id)
    {
        $member = new MemberCard();
        $data = $member->getCheckCard($id, $this->venueId);

        return json_encode(['status' => 'success', 'data' => $data]);
    }

    /**
     * 云运动 - 验卡系统 - 获取会员数据
     * @author huanghua<huanghua@itsports.club>
     * @param int $id //会员卡id
     * @return string
     */
    public function actionGetCheckCard($id = 1)
    {
        $member = new MemberCard();
        $data = $member->getCheckCardData($id, $this->venueId);
        return json_encode(['status' => 'success', 'data' => $data]);
    }

    /**
     * 云运动 - 验卡系统 - 获取会员预约数据
     * @author lihuien<lihuien@itsports.club>
     * @param int $id 会员Id
     * @return string
     */
    public function actionGetAboutClassData($id = 1, $type)
    {
        $member = new MemberCard();
        $data = $member->getAboutClassRecord($id, $type);

        return json_encode($data);
    }

    /**
     * 云运动 - 验卡系统 - 获取会员进场数据
     * @author lihuien<lihuien@itsports.club>
     * @param int $id
     * @return string
     */
    public function actionGetMemberEntryRecordData($id = 1)
    {
        $member = new EntryRecord();
        $venueId = $this->venueId;
        $data = $member->getEntryArr($id, $venueId);
        $pages = Func::getPagesFormat($data->pagination);

        return json_encode(['status' => 'success', 'data' => $data->models, 'pages' => $pages]);
    }

    /**
     *对外服务 - 营运管理 -  近30天进馆记录
     * @author Zhang dong xu <zhangdongxu@itsports.club>
     * @create 2018/6/22
     * @param $params
     * @return bool|string
     */
    public function actionGetMemberEntryRecordSum($id)
    {
        $statistics = [];
        $member = new EntryRecord();
        $memberabout = new AboutClass();
        $venueId = $this->venueId;
        $data = $member->getEntryArrSum($id, $venueId);
        $list = $memberabout->getAboutClassSum($id);
        $statistics['enter'] = $data;
        $statistics['course'] = $list;
        return json_encode(['status' => 'success', 'data' => $statistics]);
    }


    /**
     * 云运动 - 验卡系统 - 获取会员卡信息
     * @author lihuien<lihuien@itsports.club>
     * @param int $id
     * @return string
     */
    public function actionMakeSureMemberCard($id)
    {
        $timeMethod = \Yii::$app->request->get('timeMethod');
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $check = new CheckCard([], $id, $timeMethod, $companyId, $venueId);
        $check->commonEntrance();
        return json_encode(['status' => $check->return, 'message' => $check->message]);
    }

    /**
     * 云运动 - 验卡系统 - 修改会员手机号
     * @author lihuien<lihuien@itsports.club>
     * @return string
     */
    public function actionUpdateMobile()
    {
        $post = \Yii::$app->request->post();
        $model = new MemberUpdateForm();
        if ($model->load($post, '') && $model->validate()) {
            $save = $model->updateMobile();
            if ($save === true) {
                return json_encode(['status' => 'success', 'message' => '修改成功']);
            } else {
                return json_encode(['status' => 'error', 'message' => $save]);
            }
        }
        return json_encode(['status' => 'error', 'message' => $model->errors]);
    }

    /**
     * 云运动 - 验卡系统 - 修改会员归属场馆
     * @author lihuien<lihuien@itsports.club>
     * @return string
     */
    public function actionUpdateCurrentVenue()
    {
        $post = \Yii::$app->request->post();
        $model = new MemberUpdateForm();
        $save = $model->updateCurrentVenue($post);
        if ($save === true) {
            return json_encode(['status' => 'success', 'message' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'message' => $save]);
        }
    }

    /**
     * 云运动 - 验卡系统 - 修改会员是否打印
     * @author lihuien<lihuien@itsports.club>
     * @param  $id int //预约ID
     * @return string
     */
    public function actionUpdateAboutPrint()
    {
        $id = \Yii::$app->request->get('id');
        $type = \Yii::$app->request->get('type');
        $model = new AboutClass();
        $save = $model->updateAboutPrintStatus($id, $type);
        if ($save === true) {
            return json_encode(['status' => 'success', 'message' => '打印成功']);
        } else {
            return json_encode(['status' => 'error', 'message' => $save]);
        }
    }

    /**
     * 云运动 - 验卡系统 - 判断会员卡是否存在
     * @author lihuien<lihuien@itsports.club>
     * @param int $num 卡号
     * @param  string $type
     * @return string
     */
    public function actionCheckCardNumber($num, $type)
    {
        $venueId = $this->venueId;              //获取场馆id
        $num = rtrim($num, '？');
        $num = rtrim($num, '?');
//        $pattern    = '/[^0-9]*/';
//        $num        = preg_replace($pattern,'', $num);
        $num = trim($num);
        if ($type == 'mobile') {
            $member = Member::getMemberOne($num);
            if (isset($member['id'])) {
                $check = MemberCard::checkMemberCardId($member['id'], $venueId);
            } else {
                $check = false;
            }
        } else if ($type == 'num') {
            $memberCard = new MemberCard();
            $check = $memberCard->checkMemberCardNumber($num, $venueId);
            $memberId = MemberCard::find()->select('member_id')->where(['card_number' => $num])->one();
            $uid = Member::find()->select('id')->where(['id' => $memberId])->one();
            if (!$uid) {
                return json_encode(['status' => 'error', 'message' => '该卡对应的会员不存在']);
            }

        }
        if ($check === false) {
//            if($_SERVER['SERVER_ADDR'] != "127.0.0.1" && $_SERVER['SERVER_ADDR'] != "118.190.99.69"){
//                file_put_contents('num.txt',"num \n".$num."num \n",FILE_APPEND);
//            }
            return json_encode(['status' => 'error', 'message' => '会员卡不存在']);
        } else if ($check == 'limit') {
            return json_encode(['status' => 'error', 'message' => '该卡不能通店',]);
        } else if ($check == 'error') {
//            return json_encode(['status'=>'error','message'=>'通店次数扣除失败，请联系管理员',]);
            return json_encode(['status' => 'success', 'message' => '会员卡存在', 'data' => $check]);
        } else if ($check == 'over') {
//            return json_encode(['status'=>'error','message'=>'该卡通店次数剩余0次',]);
            return json_encode(['status' => 'success', 'message' => '会员卡存在', 'data' => $check]);
        } else {
            return json_encode(['status' => 'success', 'message' => '会员卡存在', 'data' => $check]);
        }
    }

//  验卡页面中的课程预约页面
    public function actionCourse()
    {
        return $this->render('courseList');
    }

    /**
     * @api {post} /check-card/leave-record  会员请假表单验证
     * @apiVersion 1.0.0
     * @apiName 会员请假表单验证
     * @apiGroup checkCard
     * @apiParam  {int}    leavePersonId  请假人id（会员ID）
     * @apiParam  {string} leaveReason    请假原因（原因）
     * @apiParam  {string} leaveStartTime 请假开始时间 （2017-03-06）
     * @apiParam  {string} leaveEndTime    请假结束时间 (2017-03-10）
     * @apiParam  {int}   leaveTotalDays   *请假离开总天数
     * @apiParam  {int}   leaveLimitStatus *请假限制识别码
     * @apiParam  {int}   leaveArrayIndex  *请假识别下标
     * @apiParam  {int}   memberCardId      会员卡ID
     * @apiParam  {string} _csrf_backend  csrf验证.
     * @apiParamExample {json} Request Example
     *   POST /check-card/leave-record
     *   {
     *       "leavePersonId": 2,             // 请假会员ID
     *       "leaveReason": "不请了",        // 请假原因
     *       "leaveStartTime": 2017-06-06,   //请假开始时间
     *       "leaveEndTime":2017-08-08,      // 请假结束时间
     *       "leaveTotalDays" :30,           // 请假总天数
     *       "leaveLimitStatus" :1,          // 请假限制状态  1 按照请假总天数遍历 2 请假次数遍历 3 没有请假限制
     *       "leaveArrayIndex" :1,           // 请假发送数组下标
     *       "memberCardId" :3,              // 会员卡id
     *       "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription    会员请假表单验证
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/27
     * @apiSampleRequest  http://qa.uniwlan.com/check-card/leave-record
     * @apiSuccess (返回值) {string} status 请假保存状态
     * @apiSuccess (返回值) {string} data   返回请假状态数据
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','status'=>'success','data':请假保存数据状态}
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','status'=>'error','data':请假保存数据状态}
     */
    public function actionLeaveRecord()
    {
        $post = \Yii::$app->request->post();
        $model = new LeaveRecordForm();
        if ($model->load($post, '') && $model->validate()) {
            $save = $model->leaveRecord();
            if ($save === true) {
                return json_encode(['status' => 'success', 'message' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'message' => $save]);
            }
        } else {
            return json_encode(['status' => 'error', 'message' => $model->errors]);
        }
    }

    /**
     * 云运动 - 验卡系统 - 课程数据遍历
     * @author houkaixin<lihuien@itsports.club>
     * @param
     * @return object   //返回所有的数据
     */
    public function actionGroupClassData()
    {
        $param = $this->get;
        $model = new GroupClass();
        $result = $model->getClassData($param, $this->venueId);

        return json_encode($result);
    }

    public function actionGroupClassDatalist()
    {
        $param = $this->get;
        $start_time = \Yii::$app->request->get('start_time');
        if (!empty($start_time)) {
            $start = date("Y-m-d", $start_time);
        } else {
            $start = date("Y-m-d", time());
        }
        $model = new GroupClass();
        $result = $model->getClassDatalist($param, $this->venueId, $start);
        $obj = (!empty($result)) ? $result : [];
        return json_encode($obj);
    }


    /**
     * 云运动 - 验卡系统 - 课程详情会员权限
     * @author houkaixin<lihuien@itsports.club>
     * @param $memberId //会员id
     * @param $classId //课程类型
     * @param $memberCardId //会员卡id
     * @param $isEmployee //是不是员工 1是
     * @update huang Pengju <huangpengju@itsports.club>
     * @update 2017/5/24
     * @return object   //返回所有的数据
     */
    public function actionGroupClassMemberRuleData($memberId, $classId, $memberCardId, $isEmployee = 0)
    {
        $model = new GroupClass();
        $result = $model->getClassMemberRuleOneData($memberId, $classId, $memberCardId, $isEmployee);
        return json_encode($result);
    }

    /**
     * 云运动 - 验卡系统 - 预约课程结果数据判断
     * @author houkaixin<lihuien@itsports.club>
     * @param
     * @return object   //返回所有的数据
     */
    public function actionOrderCourse()
    {
        $post = \Yii::$app->request->post();
        $model = new GroupClass();
        $result = $model->getClassDetail($post);
        return json_encode($result);
    }

    /**
     * 云运动 - 验卡系统 - 获取座位号
     * @author lihuien<lihuien@itsports.club>
     * @param  id int 课程ID
     * @return object   //返回数据录入结果
     */
    public function actionGetSeatDetail()
    {
        $id = \Yii::$app->request->get('id');
        $model = new Seat();
        $save = $model->getSeatDetail($id);
        return json_encode(['status' => 'success', 'message' => $save]);
    }

    /**
     * @api {post} /check-card/set-about-class-record 预约团课课程（会员、潜在会员）
     * @apiVersion 1.0.0
     * @apiName 预约团课课程
     * @apiGroup checkCard 验卡
     * @apiPermission 管理员
     *
     * @apiParam  {int}    classId        课程ID.
     * @apiParam  {string} aboutType      预约类型.
     * @apiParam  {string} [seatId]       座位.
     * @apiParam  {int}   memberId        会员Id.(员工约课传 员工id)
     * @apiParam  {string}  [is_employee]   是不是员工约课，true 表示是员工约课
     * @apiParam  {string} _csrf_backend  csrf验证.
     *
     * @apiParamExample {json} Request Example
     *   POST /check-card/set-about-class-record
     *   {
     *       "classId": 125,
     *       "aboutType": "mobile",
     *       "seatId": 3,
     *       "memberId":2,
     *       " is_employee" :"true"
     *       "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 管理员可以进入验卡页面可以给会员预约课程
     *<br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/24
     *
     * @apiSampleRequest  http://qa.uniwlan.com/check-card/set-about-class-record
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
    public function actionSetAboutClassRecord()
    {
        $post = \Yii::$app->request->post();         //接收预约数据
        $post['venueId'] = $this->venueId;
        $scenario = 'group';
        $about = new AboutRecordForm([], $scenario);
        if ($about->load($post, '') && $about->validate()) {
            $save = $about->saveGroupAbout();
            if (is_array($save) && $save["status"] == "endAboutLimit") {
                $message = '只有开课前' . $save["endClassLimit"] . "分钟可以约课";
                return json_encode(['status' => 'error', 'message' => $message, 'data' => $save]);
            } elseif ($save === 'engross') {
                return json_encode(['status' => 'engross', 'message' => '该座位已被占用', 'data' => $save]);
            } elseif ($save === 'not repeat') {
                return json_encode(['status' => 'repeat', 'message' => '预约重复', 'data' => $save]);
            } elseif ($save === 'hadClass') {
                return json_encode(['status' => 'hadClass', 'message' => '该时间点已预约过团课或私课了', 'data' => $save]);
            } elseif ($save === 'noClass') {
                return json_encode(['status' => 'noClass', 'message' => '该卡不能预约任何课程', 'data' => $save]);
            } else if ($save === 'noBindClass') {
                return json_encode(['status' => 'noBindClass', 'message' => '该卡不能预约此课程', 'data' => $save]);
            } else if ($save === 'classOver') {
                return json_encode(['status' => 'classOver', 'message' => '该课程今日预约次数已用完', 'data' => $save]);
            } else if (isset($save->id)) {
//                $about->sendMessage($this->companyId,$this->venueId);              //发送预约成功短信
                return json_encode(['status' => 'success', 'message' => '预约成功', 'data' => $save->id]);
            } else if ($save === 'limitOne') {
                return json_encode(['status' => 'limitOne', 'message' => '潜在会员限制预约一节课', 'data' => $save]);
            } else if ($save === 'cardError') {
                return json_encode(['status' => 'cardError', 'message' => '不好意思请升级，您的卡', 'data' => $save]);
            } else {
                return json_encode(['status' => 'error', 'message' => '预约失败', 'data' => $save]);
            }
        } else {
            return json_encode(['status' => 'error', 'message' => '预约失败', 'data' => $about->errors]);
        }
    }

    /**
     * 云运动 - 验卡系统 - 完成预约详情
     * @author lihuien<lihuien@itsports.club>
     * @param  $id int 课程ID
     * @return object   //返回数据录入结果
     */
    public function actionGetAboutClassDetail($id)
    {
        $about = new AboutClass();
        $data = $about->getAboutDetail($id);
        return json_encode(['status' => 'success', 'data' => $data]);
    }

    /**
     * 云运动 - 验卡系统 - 判断会员的存在
     * @author houkaixin<houkaixin@itsports.club>
     * @param
     * @return object   //返回失败的结果 成功返回会员详细信息
     */
    public function actionMemCheck()
    {
        $num = \Yii::$app->request->post();         //接收预约数据
        $member = Member::getMemberOne($num["phone"]);
        if (!empty($member)) {
            $model = new Member();
            $data = $model->getMemDetailData($member["id"]);
            return json_encode(['status' => 'success', 'message' => $data]);
        } else {
            return json_encode(['status' => 'error', 'message' => '手机号不存在']);
        }
    }

    /**
     * @api {get} /check-card/del-leave-record 删除会员请假记录
     * @apiVersion 1.0.0
     * @apiName 删除会员请假记录
     * @apiGroup checkCard 验卡
     * @apiPermission 管理员
     *
     * @apiParam {int} id 请假ID
     *
     * @apiDescription
     * 管理员可以进入验卡页面可以给会员取消预约
     *<br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/24
     * @apiSampleRequest  http://qa.uniwlan.com/check-card/del-leave-record
     *
     * @apiSuccess (返回值) {string} status 取消状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"销假成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':"销假失败"}
     */
    public function actionDelLeaveRecord($id = 1)
    {
        $model = new LeaveRecord();
        $result = $model->removeLeaveRecord($id);
        if ($result === 'no') {
            return json_encode(['status' => 'error', 'data' => "销假时间不足一天,不能销假!"]);
        } else if ($result == true) {
            return json_encode(['status' => 'success', 'data' => "销假成功"]);
        } else if ($result == false) {
            return json_encode(['status' => 'error', 'data' => "销假失败"]);
        }
    }

    /**
     * @api {get} /check-card/cancel-about-class 取消预约(会员、潜在会员)
     * @apiVersion 1.0.0
     * @apiName 取消预约
     * @apiGroup checkCard 验卡
     * @apiPermission 管理员
     *
     * @apiParam {int} id 预约ID
     *
     * @apiDescription 管理员可以进入验卡页面可以给会员取消预约
     *<br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/24
     * @apiSampleRequest  http://qa.uniwlan.com/check-card/cancel-about-class
     *
     * @apiSuccess (返回值) {string} status 取消状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"取消成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':"取消失败"}
     */
    public function actionCancelAboutClass($id = 1)
    {
        $model = new \backend\modules\v1\models\AboutClass();
        $result = $model->updateStatus($id, $this->venueId);
        if ($result === true) {
            return json_encode(['status' => 'success', 'data' => "取消成功"]);
        } else {
            return json_encode(['status' => 'error', 'data' => $result]);
        }
    }

    /**
     * @api {get} /rechargeable-card-ctrl/get-donation-type 指定场馆商品类型
     * @apiVersion 1.0.0
     * @apiName  指定场馆商品类型
     * @apiGroup GoodsType
     * @apiPermission 管理员
     * @apiDescription 获取指定场馆商品类型
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/24
     * @apiSampleRequest  http://qa.uniwlan.com/rechargeable-card-ctrl/get-donation-type
     * @apiSuccess (返回值) {string} data   返回请求成功数据
     * @apiSuccessExample {json} 成功示例:
     * {
     *  'id':"商品类型id",
     *  'goods_type':"商品类别名称"
     * }
     */
    public function actionGetDonationType()
    {
        $model = new GoodsType();
        $goodsType = $model->getGoodsTypeData($this->venueIds);

        return json_encode($goodsType);
    }

    /**
     * @api {get} /rechargeable-card-ctrl/get-the-goods 指定类别商品
     * @apiVersion 1.0.0
     * @apiName  指定类别商品
     * @apiGroup GoodsType
     * @apiPermission 管理员
     * @apiParam {int} typeId   商品类型id
     * @apiDescription  获取指定类别商品
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/7/12
     * @apiSampleRequest  http://qa.uniwlan.com/rechargeable-card-ctrl/get-the-goods
     * @apiSuccess (返回值) {string} data   返回请求成功数据
     * @apiSuccessExample {json} 成功示例:
     * {
     *  'id:"商品id"
     *  'goods_name':"商品名称,
     * }
     */
    public function actionGetTheGoods($typeId)
    {
        $model = new Goods();
        $data = $model->getTheGoods($typeId);
        return json_encode($data);
    }

    /**
     *云运动  - 业务后台 - 获取带人卡的所有副卡
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/9/23
     * @return bool|string
     */
    public function actionGetViceCards($id = 1)
    {
        $member = new MemberCard();
        $data = $member->getViceCards($id, $this->venueId);
        return json_encode(['status' => 'success', 'data' => $data]);
    }

    /**
     * 云运动 - 验卡系统 - 会员是否打印场地预约
     * @author huanghua<huanghua@itsports.club>
     * @create 2018/5/22
     * @param  $id int //预约ID
     * @return string
     */
    public function actionUpdateAboutYardPrint($id)
    {
        $model = new AboutYard();
        $save = $model->updateAboutYardPrintStatus($id);
        if ($save === true) {
            return json_encode(['status' => 'success', 'message' => '打印成功']);
        } else {
            return json_encode(['status' => 'error', 'message' => $save]);
        }
    }

    /**
     * 验卡管理 - 验证会员卡是否次数用完或在限制时间内
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/06/21
     * @param  $memberCardId //会员卡id
     * @return string
     */
    public function actionCheckAbout($memberCardId, $startTime)
    {
        $model = new CheckCard([], $memberCardId, '', $this->companyId, $this->venueId);
        $data = $model->checkAbout($memberCardId, $startTime, $this->venueId);
        if ($data === true) {
            return json_encode(['status' => 'success', 'message' => $data]);
        } else {
            return json_encode(['status' => 'error', 'message' => $data]);
        }
    }
}
