<?php

namespace backend\controllers;

use backend\models\AssignPrivateForm;
use backend\models\AllotPrivateForm;
use backend\models\AuthRole;
use backend\models\BindPack;
use backend\models\CardCategory;
use backend\models\ChargeClass;
use backend\models\ConsumptionHistory;
use backend\models\DeliveryCardForm;
use backend\models\ExtensionRecord;
use backend\models\GiveClassForm;
use backend\models\LeaveRecord;
use backend\models\Member;
use backend\models\MemberBehaviorTrail;
use backend\models\MemberCard;
use backend\models\CoursePackageDetail;
use backend\models\MemberCourseOrder;
use backend\models\MemberDetails;
use backend\models\MemberOrderChargeForm;
use backend\models\Module;
use backend\models\PrivateClassDelayForm;
use backend\models\SendRecord;
use common\models\WipeData;
use common\models\Func;
use common\models\Qiniu;
use backend\models\GroupClass;
use backend\models\MemberCabinet;
use backend\models\GiftRecord;
use backend\models\MemberCardForm;
use backend\models\MembersUpdateForm;
use yii\web\UnauthorizedHttpException;
use backend\models\NoteForm;
use backend\models\InformationRecords;

class UserController extends BaseController
{
    /**
     *  会员管理- 会员首页 - 会员列表
     * @return string
     * @author 苏雨
     * create 2017-3-28
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     *  会员管理- 私教购买 - 私教购买列表
     * @return string
     * @author 苏雨
     * create 2017-3-28
     */
    public function actionIndexUpgradeVersion2()
    {
        return $this->render('index_upgrade_version2');
    }

    /**
     *  会员管理- 会员 - 会员主页
     * @return string
     * @author 苏雨
     * create 2017-3-31
     */
    public function actionPtBuy()
    {
        return $this->render('ptBuy');
    }

    /**
     *  会员管理- 会员信息 - 修改
     * @return string
     * @author 苏雨
     * create 2017-3-29
     * @update author Huang Pengju <huangpengju@itsport.club>
     * @update 2017/3/30
     */
    public function actionEdit()
    {
        $MemberId = \Yii::$app->request->get('id');
        if (isset($MemberId) && !empty($MemberId)) {
            return $this->render('edit', ['MemberId' => $MemberId]);
        } else {
            return $this->render('index');
        }
    }

    /**
     *后台会员管理 - 会员信息查询 - angularJs访问该控制器
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/3/30
     * @return bool|string
     */
    public function actionMemberDetailsCard()
    {
        $MemberId = \Yii::$app->request->get('MemberId');
        if (!empty($MemberId)) {
            $model = new Member();
            $MemberData = $model->getMemberModel($MemberId);               //查询会员信息
            return json_encode($MemberData);
        } else {
            return false;                                                             //后期处理
        }
    }

    /**
     *后台会员管理 - 验卡 - 验卡请假获取当前卡的信息
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/12/5
     * @return bool|string
     */
    public function actionCheckCardDetails()
    {
        $MemberId = \Yii::$app->request->get('MemberId');
        $memberCardId = \Yii::$app->request->get('memberCardId');
        if (!empty($MemberId)) {
            $model = new Member();
            $MemberData = $model->getMemberModelCheck($MemberId, $memberCardId);               //查询会员信息
            return json_encode($MemberData);
        } else {
            return false;                                                             //后期处理
        }
    }

    /**
     *后台会员管理 - 会员信息查询 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/5/11
     * @return bool|string
     */
    public function actionMemberDetail()
    {
        $MemberId = \Yii::$app->request->get('MemberId');
        if (!empty($MemberId)) {
            $model = new Member();
            $memberData = $model->getMemberData($MemberId);
            return json_encode($memberData);
        } else {
            return false;
        }
    }

    /**
     * 会员管理 - 会员修改 - 接受并且修改会员信息
     * @return object
     * @author HuangHua<HuangHua@itsports.club>
     * @create 2017-5-17
     * @param
     */
    public function actionMemberInfoEdit()
    {
        if (!AuthRole::canRoleByAuth('user', 'UPDATE')) {
            throw new UnauthorizedHttpException('抱歉，您没有权限修改，请联系管理员');
        }
        $post = \Yii::$app->request->post();
        $model = new MembersUpdateForm();
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->updateData();
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'success', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台会员管理 - 会员信息查询 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/3/30
     * @return bool|string
     */
    public function actionMemberInfo()
    {
        $params = \Yii::$app->request->queryParams;
//        $params['nowBelongId']   = $this->nowBelongId;
//        $params['nowBelongType'] = $this->nowBelongType;
        $model = new Member();
        $memberInfo = $model->search($params);
        $pagination = $memberInfo->pagination;
        $pages = Func::getPagesFormat($pagination);
        return json_encode(['data' => $memberInfo->models, 'pages' => $pages]);
    }

    /**
     * @api {get} /user/member-keywords 关键字查询会员
     * @apiVersion 1.0.0
     * @apiName 关键字查询会员
     * @apiGroup user
     * @apiPermission 管理员
     *
     * @apiParam {int} memberId   会员id
     *
     * @apiDescription 可以根据关键字(会员姓名,会员手机号,会员编号)查询会员
     * <br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/24
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/user/get-charge-array-info
     * @apiSampleRequest  http://qa.uniwlan.com/user/member-keywords
     *
     * @apiSuccess(返回值) {string}  data 会员私教课程信息数据 ｛name：课程名称，pic：图片,chargeId：会员课程id，overage_section:剩余课程｝
     *
     */
    public function actionMemberKeywords($keywords)
    {
        $model = new Member();
        $memberInfo = $model->getMemberKeywords($keywords);
        return json_encode(['data' => $memberInfo]);
    }

    /**
     *后台会员管理 - 会员信息查询 - 会员卡状态修改
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/3/31
     * @return bool|string
     */
    public function actionUpdateStatus()
    {
        if (!AuthRole::canRoleByAuth('user', 'OPERATE')) {
            return $this->redirect('/site/rules');
        }
        $id = \Yii::$app->request->get('id');
        $status = Member::getUpdateMemberCard($id);
        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '冻结成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }
    }

    /**
     * 会员管理 - 会员列表 - 账户解冻
     * @author Huang hua <huanghua@itsports.club>
     * @create 2018/3/19
     * @return bool|string
     */
    public function actionUpdateMemberCount()
    {
        $id = \Yii::$app->request->get('memberAccountId');
        $status = Member::getUpdateMemberCount($id);
        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '账户解冻成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }
    }

    /**
     *后台会员管理 - 会员基本信息管理模块- 会员基本信息删除
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/3/31
     * @return bool|string
     */
    public function actionMemData()
    {
        if (!AuthRole::canRoleByAuth('user', 'DELETE')) {
            throw new UnauthorizedHttpException('抱歉，您没有权限删除，请联系管理员');
        }
        $MemberId = \Yii::$app->request->get('memberId');
        $companyId = $this->companyId;
        $model = new Member();
        $delRes = $model->getMemBaseDel($MemberId, $companyId);
        if ($delRes) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     *后台会员管理 - 会员基本信息管理模块- 会员详细信息卡遍历
     * @author Huang hua<huanghua@itsports.club>
     * @create 2017/4/6
     * @return bool|string
     */
    public function actionGetMemberCardData()
    {
        $MemberCardId = \Yii::$app->request->get('MemberCardId');
        if (!empty($MemberCardId)) {
            $model = new CardCategory();
            $memberCardData = $model->getCardCategory($MemberCardId);
            return json_encode($memberCardData);
        } else {
            return false;
        }
    }

    public function actionUpload()
    {
        $model = new Qiniu();
        $filePath = "C:/Users/songlin/Pictures/Feedback/{FF912140-6710-44CE-89EA-ABCA0055AF10}/Capture001.png";
        $fileName = "vvv.png";
        $url = $model->getImgUrl($fileName);
        echo $url;
    }

    /**
     *后台会员管理 - 会员详细信息会员卡 - 会员卡基本信息删除
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/4/17
     * @return bool|string
     */
    public function actionMemberCardDel()
    {
        $memberCardId = \Yii::$app->request->get('memberId');
        $model = new MemberCard();
        $delRes = $model->getMemberCardDel($memberCardId);
        if ($delRes) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     *后台会员管理 - 会员卡查询 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/17
     * @return bool|string
     */
    public function actionMemberCardInfo()
    {
        $MemberId = \Yii::$app->request->get('MemberId');
        $type = \Yii::$app->request->get('type');
        if (!empty($MemberId)) {
            $model = new MemberCard();
            $card = new CardCategory();
            $memberInfo = $model->memberCardData($MemberId, $type, $card->getVenueIdByRole());
//            $pagination = $memberInfo->pagination;
//            $pages = Func::getPagesFormat($pagination, 'replaceMemberCard');
//            return json_encode(['item' => $memberInfo->models?$memberInfo->models:2, 'pages' => $pages]);
            return json_encode(['item' => $memberInfo ? $memberInfo : 2]);
        } else {
            return false;
        }
    }

    /**
     *后台会员管理 - 请假查询 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/17
     * @return bool|string
     */
    public function actionLeaveRecordInfo()
    {
        $memberId = \Yii::$app->request->get('MemberId');
        if (!empty($memberId)) {
            $model = new LeaveRecord();
            $memberInfo = $model->leaveRecordData($memberId);
            $pages = Func::getPagesFormat($memberInfo->pagination, 'replaceLeavePage');
            return json_encode(['vacate' => $memberInfo->models, 'pages' => $pages]);
        } else {
            return false;
        }
    }

    /**
     * @describe 后台会员管理 - 团课查询 - angularJs访问该控制器
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @return bool|string
     * @throws \Exception
     */
    public function actionGroupClassInfo()
    {
        $MemberId = $this->get['MemberId'];
        $type = null;
        if (isset($this->get['type'])) {
            $type = $this->get['type'];
        }

        if (!empty($MemberId)) {
            $model = new GroupClass();
            $memberInfo = $model->getGroupClassData($MemberId, $type, $this->venueIds);
            $pagination = $memberInfo->pagination;
            $pages = Func::getPagesFormat($pagination, 'replaceGroupPage');
            return json_encode(['group' => $memberInfo->models, 'pages' => $pages]);
        } else {
            return false;
        }
    }

    /**
     * @describe 后台会员管理 - 消费记录查询 - angularJs访问该控制器
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @return string
     * @throws \Exception
     */
    public function actionConsumptionInfo()
    {
        $params = \Yii::$app->request->queryParams;
        $model = new ConsumptionHistory();
        $memberInfo = $model->consumptionHistoryData($params);
        $pages = Func::getPagesFormat($memberInfo->pagination, 'replacePayPage');
        return json_encode(['expense' => $memberInfo->models, 'pages' => $pages]);
    }

    /**
     *后台会员管理 - 会员柜表查询 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/19
     * @return bool|string
     */
    public function actionCabinetInfo()
    {
        $MemberId = \Yii::$app->request->get('MemberId');
        $card = new CardCategory();
        $venueId = $card->getVenueIdByRole();
        if (!empty($MemberId)) {
            $model = new MemberCabinet();
            $cabinetInfo = $model->getMemberCabinetData($MemberId, $venueId);
            $pagination = $cabinetInfo->pagination;
            $pages = Func::getPagesFormat($pagination, 'replaceCabinetPages');
            return json_encode(['cabinet' => $cabinetInfo->models, 'pages' => $pages]);
        } else {
            return false;
        }
    }

    /**
     *后台会员管理 - 会员详细信息会员卡 - 会员柜表删除
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/4/17
     * @return bool|string
     */
    public function actionMemberCabinetDel()
    {
        $memberCardId = \Yii::$app->request->get('memberId');
        $model = new MemberCabinet();
        $delRes = $model->getMemberCabinetDel($memberCardId);
        if ($delRes) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     *后台会员管理 - 赠品查询 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/17
     * @return bool|string
     */
    public function actionGiftRecordInfo()
    {
        $memberId = \Yii::$app->request->get('memberId');
        if (!empty($memberId)) {
            $model = new GiftRecord();
            $memberInfo = $model->GiftRecordData($memberId);
//            $pages = Func::getPagesFormat($memberInfo->pagination, 'replaceGiftPage');
//            return json_encode(['gift' => $memberInfo->models, 'pages' => $pages]);
            return json_encode(['gift' => $memberInfo]);
        } else {
            return false;
        }
    }

    /**
     *后台会员管理 - 会员详情 - 赠品列表领取状态修改
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/5
     * @return bool|string
     */
    public function actionUpdateGiftStatus()
    {
        $GiftRecordId = \Yii::$app->request->get('id');
        $status = GiftRecord::getUpdateGift($GiftRecordId);

        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }

    }

    /**
     *后台会员管理 - 会员卡- 获取会员单条卡信息
     * @author Houkaixin<Houkaixin@itsports.club>
     * @create 2017/4/21
     * @return object
     */
    public function actionGetAdviser()
    {
        $venueId = \Yii::$app->request->get('venueId');
        $model = new Member();
        $data = $model->getAdviser($venueId);
        return json_encode($data);
    }

    /**
     *后台会员管理 - 跨店升级- 获取所有销售顾问
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/1/18
     * @return object
     */
    public function actionGetAllAdviser()
    {
        $employeeId = \Yii::$app->request->get('employeeId');
        $companyId = $this->companyId;
        $model = new Member();
        $data = $model->getAllAdviser($employeeId, $companyId);
        return json_encode($data);
    }

    /**
     *后台潜在会员 - 登记进馆- 获取会员单条卡信息
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/7/14
     * @return object
     */
    public function actionGetAdviserData()
    {
        $companyId = \Yii::$app->request->get('companyId');
        $venueId = \Yii::$app->request->get('venueId');
        $model = new Member();
        $data = $model->getAdviserData($companyId, $venueId);
        return json_encode($data);
    }

    /**
     * @describe 后台会员管理 - 私教查询 - angularJs访问该控制器
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @return string
     * @throws \Exception
     */
    public function actionChargeClassInfo()
    {
        $MemberId = \Yii::$app->request->get('MemberId');
        $venueId = $this->venueIds;
        if (!empty($MemberId)) {
            $model = new MemberCourseOrder();
            $memberInfo = $model->getChargeClassData($MemberId, $venueId);
            $pagination = $memberInfo->pagination;
            $pages = Func::getPagesFormat($pagination, 'chargeClass');
            return json_encode(['charge' => $memberInfo->models, 'pages' => $pages]);
        } else {
            return json_encode([]);
        }
    }

    /**
     *后台会员管理 - 会员卡- 修改会员卡单条信息
     * @author Houkaixin<Houkaixin@itsports.club>
     * @create 2017/4/21
     * @return object
     */
    public function actionUpdateCard()
    {
        $post = \Yii::$app->request->post();
        $model = new MemberCardForm();
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->updateMyCard();
            if ($result == "success") {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else if ($result == "error") {
                return json_encode(['status' => 'error', 'data' => "修改失败"]);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => "修改失败"]);
        }
    }

    /**
     *后台会员管理 - 会员详细信息会员卡 - 私课删除
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/4/22
     * @return bool|string
     */
    public function actionCoursePackageDel()
    {
        $chargeClassId = \Yii::$app->request->get('memberId');
        $model = new CoursePackageDetail();
        $delRes = $model->getChargeClassDel($chargeClassId);
        if ($delRes) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     * 会员管理 - 私课信息 - 批量删除私教课
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/12/09
     * @return bool|string
     */
    public function actionBatchDelCourse()
    {
        $post = \Yii::$app->request->post();
        if (!isset($post['courseIdArr'])) {
            return json_encode(['status' => 'error', 'data' => '请先选择删除项']);
        }
        $model = new CoursePackageDetail();
        $data = $model->batchDelCourse($post);
        if ($data == true) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     *后台会员管理 - 私教详细信息查询 - 私教详情上课记录
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/22
     * @return bool|string
     */
    public function actionClassRecordInfo()
    {
        $MemberId = \Yii::$app->request->get('MemberId');
        $chargeId = \Yii::$app->request->get('charge_id');
        if (!empty($MemberId)) {
            $model = new MemberCourseOrder();
            $classRecord = $model->MemberCourseOrderData($MemberId, $chargeId);
//            $pagination = $classRecord->pagination;
//            $pages = Func::getPagesFormat($pagination,'replacePersonal');
//            return json_encode(['record' => $classRecord->models, 'pages' => $pages]);
            return json_encode(['record' => $classRecord]);
        } else {
            return false;
        }
    }

    /**
     * 云运动 - 会员管理 - 查询会员身份证号
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/25
     * @return bool|string
     */
    public function actionMemberDetails()
    {
        $MemberIdCard = \Yii::$app->request->get('MemberIdCard');
        $MemberId = \Yii::$app->request->get('MemberId');
        if ($MemberId == 'null') {
            $MemberId = null;
        }
        $venueId = $this->venueId;
        if (!empty($MemberIdCard)) {
            $model = new \backend\models\MemberDetails();
            $MemberData = $model->getMemberIdCard($MemberId, $MemberIdCard, $venueId);
            if ($MemberData !== null) {
                return json_encode($MemberData);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * @api{post} /user/save-member-charge 私课购买和续费
     * @apiVersion  1.0.0
     * @apiName 会员购买私课或者续费
     * @apiGroup charge 私课
     * @apiPermission 管理员
     *
     * @apiParam {int}      memberId     会员id           （续费继续使用）
     * @apiParam {int}     chargeId     购买私课产品id     （续费继续使用）
     * @apiParam {string}  chargeType  购买课程的类型：单节用“alone”,多节的套餐用“many”）
     * @apiParam {int}     coachId     销售私教id           （续费继续使用）
     * @apiParam {int}     nodeNumber  课程节数              (续费继续使用)
     * @apiParam {int}     totalPrice  课程总价
     * @apiParam {string}  saleType     销售渠道
     * @apiParam {string}  note         （备注 --续费使用）
     * @apiParam {string}  offer        （优惠折扣 --续费使用）
     * @apiParam {string}  renewTime   缴费日期
     * @apiParam {string}  payMethod  支付方式
     * @apiParam {string}  scenario    (carry ,续费标识)
     * @apiParam {string}  _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     *   POST /user/save-member-charge
     *   {
     *        "memberId": 125,
     *        "chargeId": 125,
     *        "chargeType": "alone",
     *        "coachId": 125,
     *        "nodeNumber" :1,
     *        "saleType": "网络",
     *        "renewTime":"2017-06-03",
     *        "payMethod":"现金",
     *        "totalPrice":1100,
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 管理员可以进行私课购买和续费操作
     * <br/>
     * <span><strong>作   者：</strong></span>黄鹏举<br>
     * <span><strong>邮   箱：</strong></span>huangpengju@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/5/27
     * @apiSampleRequest  http://qa.uniwlan.com/user/save-member-charge
     * @apiSuccess (返回值) {string} data 返回的数据
     */

    public function actionSaveMemberCharge()
    {
        $post = \Yii::$app->request->post();
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        if (empty($post['scenario'])) {
            $post['scenario'] = 'add';                                   //为购买课程 指定场景
        }
        $scenario = $post['scenario'];
        $model = new MemberOrderChargeForm([], $scenario, $companyId, $venueId);
        if ($model->load($post, '') && $model->validate()) {
            if ($scenario == 'add') {
                $result = $model->saveCharge();
            } else {
                $result = $model->updateCharge();
            }
            if ($result === 'No MemberCardId') {
                return json_encode(['status' => 'error', 'data' => '该会员没有会员卡']);
            } else if ($result === true) {
                if ($scenario == 'add') {
                    $model->sendMessage();              //购买私课成功发送短信
                }
                return json_encode(['status' => 'success', 'data' => '购买成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => '购买失败']);
        }
    }

    /**
     * @云运动 - 会员管理 - 私教课续费 计算价格
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/6
     * @return int
     */
    public function actionComputePrice()
    {
        $chargeId = \Yii::$app->request->get('chargeId');
        $number = \Yii::$app->request->get('number');
        $memberId = \Yii::$app->request->get('memberId');
        if (($chargeId != null) && ($number != null) && ($memberId != null)) {
            $model = new ChargeClass();
            $data = $model->computePrice($chargeId, $number, $memberId);
            return json_encode($data);
        } else {
            return false;
        }
    }

    /**
     * @api {get} /user/member-information 获取潜在会员详细信息
     * @apiVersion 1.0.0
     * @apiName  获取潜在会员详细信息
     * @apiGroup  potentialMember
     * @apiPermission 管理员
     *
     * @apiParam {int} memberId     潜在会员id
     * @apiParamExample {json} Request Example
     *   GET /user/member-information
     *   {
     *       "memberId": 125,
     *   }
     * @apiDescription 管理员可以进入潜在会员详细信息页面
     * <br/>
     * <span><strong>作   者：</strong></span>黄鹏举<br>
     * <span><strong>邮   箱：</strong></span>huangpengju@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/5/27
     *
     * @apiSampleRequest  http://qa.uniwlan.com/user/member-information
     *
     * @apiSuccess (返回值) {string} data 返回的数据
     *
     */
    public function actionMemberInformation()
    {
        $memberId = \Yii::$app->request->get('memberId');
        if (!empty($memberId)) {
            $model = new Member();
            $memberData = $model->getMemberInformation($memberId);                    //查询会员信息
            return json_encode($memberData);
        } else {
            return false;
        }
    }

    /**
     * @api {get} /user/get-charge-info 获取会员私课详情信息
     * @apiVersion 1.0.0
     * @apiName 会员转课
     * @apiGroup user
     * @apiPermission 管理员
     *
     * @apiParam {int} chargeId   转让的课程id
     * @apiParam {int} memberId   会员id
     *
     * @apiParamExample {json} Request Example
     * GET /user/get-charge-info
     * {
     *      "chargeId":9,
     *      "memberId":169,
     * }
     * @apiDescription 管理员进入会员详细信息-私课信息可以给会员转让课程
     * <br/>
     * <span><strong>作    者：</strong></span>黄鹏举<br>
     * <span><strong>邮    箱：</strong></span>huangpengju@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/24
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/user/get-charge-info
     * @apiSampleRequest  http://qa.uniwlan.com/user/get-charge-info
     *
     * @apiSuccess(返回值) {string}  data 会员转让课程信息数据 ｛name：课程名称，pic：图片,chargeId：转让课程id，overage_section:剩余课程,course_amount:总课程，deadline_time：到期时间，money_amount：总金额｝
     *
     */
    public function actionGetChargeInfo()
    {
        $memberInfo = \Yii::$app->request->get();
        $model = new MemberCourseOrder();
        $data = $model->getMemberOrder($memberInfo);
        return json_encode($data);
    }

    /**
     * @api {get} /user/get-charge-array-info 获取课程下拉列表
     * @apiVersion 1.0.0
     * @apiName 会员产品信息
     * @apiGroup user
     * @apiPermission 管理员
     *
     * @apiParam {int} memberId   会员id
     *
     * @apiDescription 管理员进入会员详细信息-私教产品下拉列表
     * <br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/24
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/user/get-charge-array-info
     * @apiSampleRequest  http://qa.uniwlan.com/user/get-charge-array-info
     *
     * @apiSuccess(返回值) {string}  data 会员私教课程信息数据 ｛name：课程名称，pic：图片,chargeId：会员课程id，overage_section:剩余课程｝
     *
     */
    public function actionGetChargeArrayInfo($memberId, $type = '')
    {
        $venueId = $this->venueId;
        $model = new MemberCourseOrder();
        $data = $model->getMemberChargeArray($memberId, $venueId, $type);
        return json_encode($data);
    }

    /**
     * @api {get} /user/get-charge-history 获取课程消费记录列表
     * @apiVersion 1.0.0
     * @apiName 会员产品消费信息
     * @apiGroup user
     * @apiPermission 管理员
     *
     * @apiParam {int} memberId   会员id
     * @apiParam {int} orderId      会员购买课程id
     *
     * @apiDescription 管理员进入会员详细信息-私教产品下拉列表
     * <br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/24
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/user/get-charge-history
     * @apiSampleRequest  http://qa.uniwlan.com/user/get-charge-history
     * @apiSuccess(返回值) {string}  data 会员私教课程信息数据 ｛create_at:创建时间，consumption_amount：金额,category：状态 id，employeeName:客服名称｝
     */
    public function actionGetChargeHistory($memberId, $orderId)
    {
        $model = new ConsumptionHistory();
        $data = $model->getChargeMemberHistory($memberId, $orderId);
        return json_encode(['data' => $data]);
    }

    /**
     * @api {get} /user/get-mobile-info 会员手机号去重
     * @apiVersion 1.0.0
     * @apiName 手机号去重验证
     * @apiGroup user
     * @apiPermission 管理员
     *
     * @apiParam {int} mobile   手机号
     *
     * @apiDescription 管理员修改会员-手机号验证去重
     * <br/>
     * <span><strong>作    者：</strong></span>黄华<br>
     * <span><strong>邮    箱：</strong></span>huanghua@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/26
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/user/get-mobile-info
     * @apiSampleRequest  http://qa.uniwlan.com/user/get-mobile-info
     *
     * @apiSuccess(返回值) {string}  status 验证状态 ｛error：手机号存在，success：手机不存在｝
     *
     */
    public function actionGetMobileInfo()
    {
        $mobile = \Yii::$app->request->get('mobile');
        $memberId = \Yii::$app->request->get('memberId');
        $memberId = (isset($memberId) && !empty($memberId)) ? $memberId : null;
        $model = new Member();
        $data = $model->getMobileInfo($mobile, $this->companyIds, $memberId, $this->venueIds);

        if ($data === true) {
            return json_encode(['status' => 'success']);
        }

        if ($data && !empty($data)) {
            return json_encode(['status' => 'error']);
        } else {
            return json_encode(['status' => 'success']);
        }
    }

    /**
     * @api {get} /user/get-member-card 会员请假-获取会员办卡信息
     * @apiVersion 1.0.0
     * @apiName 会员请假-获取会员办卡信息
     * @apiGroup user
     * @apiPermission 管理员
     *
     * @apiParam {int} memberId   会员id
     *
     * @apiDescription 点击请假，会员请假-获取会员办卡信息
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/06/04
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/user/get-member-card
     * @apiSampleRequest  http://qa.uniwlan.com/user/get-member-card
     *
     * @apiSuccess(返回值) {string}  data 会员办卡信息｛id:会员卡id｝
     *
     */
    public function actionGetMemberCard($memberId)
    {
        $model = new MemberCard();
        $card = new \backend\models\CardCategory();
        $venueId = $card->getVenueIdByRole();
        $memberCardS = $model->getMemberCard($memberId, $venueId);
        return json_encode($memberCardS);
    }

    /**
     * @describe 验卡管理 - 验卡输入手机号 - 获取会员id
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @param $mobile
     * @return string
     */
    public function actionGetMemberInfo($mobile)
    {
        $model = new Member();
        $memberCardS = $model->getMobileId($mobile, $this->venueIds);

        return json_encode($memberCardS);
    }

    /**
     * 私教管理 - 私教排课 - 搜索姓名
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/27
     * @return bool|string
     */
    public function actionGetMemberByName($name)
    {
        $model = new Member();
        $identify['nowBelongId'] = $this->nowBelongId;
        $identify['nowBelongType'] = $this->nowBelongType;
        $member = $model->getMemberByName($name, $identify);
        return json_encode($member);
    }

    /**
     * @api {get} /user/get-leave-limit 获取会员请假限制信息
     * @apiVersion 1.0.0
     * @apiName  获取会员请假限制信息
     * @apiGroup USER
     * @apiPermission 管理员
     * @apiParam {int} cardCategoryId   卡种id
     * @apiDescription 根据不同的会员卡，获取会员卡的限制信息
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/06/26
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/user/get-member-card
     * @apiSampleRequest  http://qa.uniwlan.com/user/get-leave-limit
     * @apiSuccess(返回值) {json} data｛leave_total_days：请假总天数，leave_least_Days：每次最低天数，leave_long_limit: [0]=>每次请假天数，[1]=>每次请假天数｝
     */
    public function actionGetLeaveLimit($memberCardId)
    {
        $model = new MemberCard();
        $leaveLimit = $model->getTheLimitData($memberCardId);
        return json_encode($leaveLimit);
    }

    /**
     *  会员管理- 会员首页 - 会员卡修改列表
     * @return string
     * @author 李慧恩
     * create 2017-3-28
     */
    public function actionMemberCardEdit()
    {
        $post = \Yii::$app->request->post();
        $model = new WipeData();
        $card = $model->editMemberCard($post);
        if ($card === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        }
        return json_encode(['status' => 'error', 'data' => $card]);
    }

    /**
     * 云运动 - 会员管理 - 会员详情
     * @author Huang hua<huanghua@itsports.club>
     * @create 2017/7/13
     * @return bool|string
     */
    public function actionMemberCard()
    {
        $memberId = \Yii::$app->request->get('memberId');
        if (!empty($memberId)) {
            $model = new MemberCard();
            $memberCard = $model->memberCard($memberId);
            return json_encode($memberCard);
        } else {
            return false;
        }

    }

    /**
     * @api {get} /user/all-modules  获取模块
     * @apiVersion 1.0.0
     * @apiName   获取模块
     * @apiGroup  modules
     * @apiPermission 管理员
     * @apiParam {int} id       模块ID
     * @apiParamExample {json} Request Example
     * GET  /user/member-behavior-trail
     * {
     *       id: "1",      //模块ID 如果获取顶级 不需要传值
     * }
     * @apiDescription  获取模块
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/7/13
     *
     * @apiSampleRequest  http://qa.uniwlan.com/user/all-modules
     * @apiSuccess (返回值) data  返回数据
     * * @apiSuccessExample {json} 成功示例:
     *{
     * create_at:"1497788315"
     * create_id:"0"
     * e_name:"systemIndex"
     * icon:"glyphicon glyphicon-home"
     * id:"1"
     * level:"1"
     * name:"系统首页"
     * note:"顶级菜单"
     * pid:"0"
     * update_at:null
     * url:null
     * };
     *
     */
    public function actionAllModules($id = 0)
    {
        $module = new Module();
        $data = $module->getTopModule($id);
        return json_encode($data);
    }

    /**
     * @api {get} /user/member-behavior-trail   员工行为轨迹
     * @apiVersion 1.0.0
     * @apiName   员工行为轨迹
     * @apiGroup  behaviorTrail
     * @apiPermission 管理员
     * @apiParam {string} employeeName       员工姓名
     * @apiParam {string} startTime          搜索开始时间
     * @apiParam {string} endTime             搜索结束时间
     * @apiParam {string} employeeBehavior    员工行为   // 1:浏览 2:编辑 3:修改 4:查看 5:删除
     * @apiParam {int} operateModule       操作模块
     * @apiParam {string} sortType            排序字段
     * @apiParam {string} sortName            排序的方式
     * @apiParamExample {json} Request Example
     * GET  /user/member-behavior-trail
     * {
     *       employeeName: "张三",      //员工姓名（张三）
     *       startTime: "2017-07-15"    // 搜索开始时间
     *       endTime: "2017-07-28"      //搜索结束时间
     *       employeeBehavior："删除"   // 1:浏览 2:编辑 3:修改 4:查看 5:删除
     *       operateModule:17          // 操作模型
     *       sortType :"employeeName",    //排序字段名称 1:employeeName（用户名称）2：employeeBehavior（用户行为）3：behavior_intro（功能）4：create_at（操作时间）
     *       sortName："ASC",          // 排序方式（1 ASC(升序)DES（降序））
     * }
     * @apiDescription  员工行为轨迹
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/7/13
     *
     * @apiSampleRequest  http://qa.uniwlan.com/user/member-behavior-trail
     * @apiSuccess (返回值) data  返回数据
     * * @apiSuccessExample {json} 成功示例:
     *{
     *   'id' => string '1' ,                    //轨迹id
     *   "nam"=>"员工姓名"                      //用户名
     *   'behavior' => 1,                     //行为 1:浏览 2:编辑 3:修改 4:查看 5:删除
     *   “behavior_intro” => string “删除会员”       // 功能
     *    “create_at” => 20122334134       // 操作时间  （时间戳）
     *    "moduleName" =>"会员首页"           // 模型名称
     *    “module_id”=>"53"                 //模型id
     * };
     *
     */
    public function actionMemberBehaviorTrail()
    {
        $param = \Yii::$app->request->queryParams;
        $param['nowBelongId'] = $this->nowBelongId;
        $param['nowBelongType'] = $this->nowBelongType;
        $model = new MemberBehaviorTrail();
        // 获取用户会员轨迹数据
        $memberBehaviorTrail = $model->getMemberBehaviorTrail($param);
        $pagination = $memberBehaviorTrail->pagination;
        $pages = Func::getPagesFormat($pagination);
        return json_encode(["data" => $memberBehaviorTrail->models, 'pages' => $pages]);
    }

    /**
     * @api {get} /user/update-member-pic  修改会员头像
     * @apiVersion 1.0.0
     * @apiName   修改会员头像
     * @apiGroup  updatePic
     * @apiPermission 管理员
     * @apiParam {int}  id       会员ID
     * @apiParam {string} pic    会员头像
     * @apiParam {string} _csrf_backend  验证
     * @apiParamExample {json} Request Example
     * GET  /user/member-behavior-trail
     * {
     *       id: "1",
     *       pic: "asfdgfdg"
     *       _csrf_backend: "sdfsdasasasd"
     * }
     * @apiDescription  修改会员头像
     * <br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/7/13
     *
     * @apiSampleRequest  http://qa.uniwlan.com/user/update-member-pic
     * @apiSuccess (返回值) data  返回数据
     * * @apiSuccessExample {json} 成功示例:
     *{
     *  "status"=>"success",
     * 'data'=>"修改会员头像成功"
     * };
     *
     */
    public function actionUpdateMemberPic()
    {
        $post = \Yii::$app->request->post();
        $model = new Member();
        // 获取用户会员轨迹数据
        $member = $model->updateMemberPic($post);
        if ($member === true) {
            return json_encode(["status" => "success", 'data' => "修改会员头像成功"]);
        }
        return json_encode(["status" => "error", 'data' => $member]);
    }

    /**
     * @api {get} /user/insert-employee-data  轨迹数据记录
     * @apiVersion 1.0.0
     * @apiName 轨迹数据记录
     * @apiGroup behaviorTrail
     * @apiPermission 管理员
     * @apiParam {int} behavior     // 1:浏览 2:编辑 3:修改 4:查看 5:删除
     * @apiParam {int} moduleId     // 操作菜单模块id
     * @apiParam {string} behaviorIntro //简洁具体描述 例如 删除某某会员 编辑某某会员 新增白金卡 等
     * @apiDescription 对员工每一次操作的 具体描述的数据记录
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/07/14
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/user/insert-employee-data
     * @apiSampleRequest  http://qa.uniwlan.com/user/insert-employee-data
     * @apiSuccess (返回值)  status 数据录入状态  data  返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *   'status' => “success”,           //数据成功录入状态
     *   'data'   => "成功后返回的信息" ,    //调换成功返回的信息
     * };
     * @apiErrorExample {json} 错误示例:
     * {
     * 'status'=>'error',                //失败状态
     * 'data'=>“保存失败信息”           //调换失败返回的信息
     * }
     */
    public function actionInsertEmployeeData()
    {
        $param = \Yii::$app->request->post();   // 获取传播数据
        $model = new MemberBehaviorTrail();
        $resultInsert = $model->insertData($param);
        if ($resultInsert === true) {
            return json_encode(["status" => "success", 'data' => "数据录入成功"]);
        }
        // 报错信息
        return json_encode(["status" => "error", 'data' => $resultInsert]);
    }

    /**
     * 云运动 - 会员管理 - 分配私教 - 根据课程类型查询课程
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/7/26
     * @return array
     */
    public function actionGetCourse()
    {
        $type = \Yii::$app->request->get('courseType');
        $company = $this->companyId;
        $model = new ChargeClass();
        $data = $model->getCourseType($type, $company);
        return json_encode(['data' => $data]);
    }

    /**
     * 云运动 - 会员管理 - 新分配私教 - 根据课程类型查询课程
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/7/26
     * @return array
     */
    public function actionGetCourseData()
    {
        $param = \Yii::$app->request->queryParams;
        $model = new BindPack();
        $data = $model->getCourseTypeData($param);
        return json_encode(['data' => $data]);
    }

    /**
     * 云运动 - 会员管理 - 批量分配私教 - 查询免费私课
     * @author huanghua <huanghua@itsports.club>
     * @create 2018/4/10
     * @return array
     */
    public function actionGetHsCourseData()
    {
        $venueId = $this->venueId;
        $model = new ChargeClass();
        $data = $model->getCourseHsData($venueId);
        return json_encode(['data' => $data]);
    }

    /**
     * 会员管理 - 新分配私教 - 获取身份证号
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/9/29
     * @return array
     */
    public function actionGetMemberId()
    {
        $memberId = \Yii::$app->request->get('memberId');
        $model = new MemberDetails();
        $data = $model->getMemberCardId($memberId);
        return json_encode(['data' => $data]);
    }

    /**
     * @api{post} /user/assign-private 会员管理 - 分配私教
     * @apiVersion  1.0.0
     * @apiName 会员管理 - 分配私教
     * @apiGroup User
     * @apiPermission 管理员
     *
     * @apiParam {int} memberCardId 会员卡id
     * @apiParam {int} coachId 私教id
     * @apiParam {int} courseNum 课程节数
     *
     * @apiParamExample {json} Request Example
     * {
     *     "memberCardId": "122",
     *     "coachId": "12",
     *     "courseNum": "2",
     * }
     * @apiDescription 会员管理 - 分配私教<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/25<br/>
     * <span><strong>调用方法：</strong></span>/user/assign-private
     * @apiSampleRequest  http://qa.uniwlan.com/user/assign-private
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {
     *   'status' => “success”,
     *   'data'   => "分配成功" ,
     * }
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status' => “error”,
     *   'data'   => "分配失败的信息" ,
     * }
     */
    public function actionAssignPrivate()
    {
        $post = \Yii::$app->request->post();
        $model = new AssignPrivateForm();
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->assignPrivate();
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '分配成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 云运动 - 会员管理 - 新分配私教
     * @author 黄华 <huanghua@itsports.club>
     * @create 2017/9/28
     * @return array
     */
    public function actionAllotPrivate()
    {
        $post = \Yii::$app->request->post();
        $model = new AllotPrivateForm();
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->allotPrivate();
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '分配成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 云运动 - 会员管理 - 赠送课程
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/21
     * @return array
     */
    public function actionGiveClass()
    {
        $post = \Yii::$app->request->post();
        $model = new GiveClassForm();
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->giveClass($post['className']);
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '分配成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 云运动 - 会员管理 - 分配私教 - 根据课程类型查询课程
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/7/26
     * @return array
     */
    public function actionGetMemberAll()
    {
        $data = Member::getMemberAll($this->companyId);
        return json_encode(['data' => $data]);
    }

    /**
     * @api{post} /user/add-note 会员管理 - 新增信息记录
     * @apiVersion  1.0.0
     * @apiName 会员管理 - 新增信息记录
     * @apiGroup user
     * @apiPermission 管理员
     *
     * @apiParam {string} note 备注
     * @apiParam {int} memberId 会员id
     * @apiParam {int} behaviorId 行为id
     * @apiParam {int} memberCardId 会员卡id
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "note": "旷课冻结",
     *        "memberId": "157",
     *        "behaviorId": "3",
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 会员管理 - 新增信息记录<br/>
     * <span><strong>作   者：</strong></span>黄华<br/>
     * <span><strong>邮   箱：</strong></span>huanghua@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/8/5<br/>
     * <span><strong>调用方法：</strong></span>/user/add-note
     * @apiSampleRequest  http://qa.uniwlan.com/user/add-note
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"新增成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *   'data':{
     *     'name':'新增信息不能为空'
     *   }}
     */
    public function actionAddNote()
    {
        $post = \Yii::$app->request->post();
        $model = new NoteForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->addNote();
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
     *后台会员管理 - 会员详情 - 信息记录里的行为记录
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/3/30
     * @return bool|string
     */
    public function actionInformationRecords()
    {
        $memberId = \Yii::$app->request->get('memberId');
        if (!empty($memberId)) {
            $model = new InformationRecords();
            $memberData = $model->getMemberInfo($memberId);
            $pagination = $memberData->pagination;
            $pages = Func::getPagesFormat($pagination, 'replaceInformationRecords');
            return json_encode(['data' => $memberData->models, 'page' => $pages]);
        } else {
            return false;
        }
    }

    /**
     *后台会员管理 - 会员详情 - 信息记录里的行为记录
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/3/30
     * @return bool|string
     */
    public function actionBirthdayReminder()
    {
        $birth = new WipeData();
        $birth->memberBirthReminder($this->venueId);
        return json_encode(['status' => 'success', 'message' => '发送成功']);
    }

    /**
     * @api{post} /user/save-delivery-form 会员管理 - 送人卡新增
     * @apiVersion  1.0.0
     * @apiName 会员管理 - 送人卡新增
     * @apiGroup user
     * @apiPermission 管理员
     *
     * @apiParam {string} memberId    被转卡会员ID old
     * @apiParam {int}    oldMemberId 老会员会员ID new||old
     * @apiParam {int}    mobile      手机号       new
     * @apiParam {int}    name        会员名称     new
     * @apiParam {int}    sex         会员性别     new
     * @apiParam {int}    idCard      会员身份证号 new
     * @apiParam {int}    cardId      卡ID        new||old
     * @apiParam {int}    status      状态        老会员2 新会员1 new||old
     * @apiParam {int}    code        验证码      new
     * @apiParam {string} _csrf_backend  CSRF验证  new||old
     * @apiParam {staring} scenario     老会员old 新会员new
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "oldMemberId": 111,
     *        "memberId": "157",
     *        "mobile": 15138799898,
     *        "name": 老李,
     *        "sex": 男,
     *        "idCard": 411411199910101010,
     *        "cardId": 1,
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 会员管理 - 送人卡新增<br/>
     * <span><strong>作   者：</strong></span>黄华<br/>
     * <span><strong>邮   箱：</strong></span>huanghua@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/8/5<br/>
     * <span><strong>调用方法：</strong></span>/user/add-note
     * @apiSampleRequest  http://qa.uniwlan.com/user/save-delivery-form
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"新增成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *   'data':{
     *     'name':'新增信息不能为空'
     *   }}
     */
    public function actionSaveDeliveryForm()
    {
        $post = \Yii::$app->request->post();
        $scenario = $post['scenario'];
        $model = new DeliveryCardForm([], $scenario, $this->companyId, $this->venueId);
        if ($model->load($post, '') && $model->validate()) {
            $model->loadCode();
            $data = $model->saveCard();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '新增成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台会员管理 - 会员详情 - 送卡记录
     * @author lihuien <lihuien@itsports.club>
     * @param  $memberId
     * @create 2017/3/30
     * @return bool|string
     */
    public function actionGetMemberSendRecord($memberId)
    {
        $birth = new SendRecord();
        $send = $birth->getMemberSendRecord($memberId);
        return json_encode(['data' => $send]);
    }

    /**
     * @会员管理 - 私课信息 - 延期
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/22
     * @return bool
     */
    public function actionDelay()
    {
        $post = \Yii::$app->request->post();
        $model = new PrivateClassDelayForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->delay();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '延期成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @desc: 业务后台 - 会员私教课 - 获取私教课程延期记录
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/03/14
     * @param $memberId
     * @return string
     */
    public function actionCourseDelayRecord($memberId, $course_order_id)
    {
        $model = new ExtensionRecord();
        $data = $model->courseDelayRecord($memberId, $course_order_id);
        return json_encode($data);
    }
}