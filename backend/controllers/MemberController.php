<?php

namespace backend\controllers;

use backend\models\AboutYard;
use backend\models\CardCategory;
use backend\models\IcBindRecord;
use backend\models\CardUpdateForm;
use backend\models\GiftRecord;
use backend\models\HandCardForm;
use backend\models\BatchAllotPrivateForm;
use backend\models\LeaveRecord;
use backend\models\MemberCourseOrderForm;
use backend\models\MemberDepositForm;
use backend\models\MemberDetails;
use backend\models\NewCardUpdateForm;
use backend\models\ConsumptionHistory;
use backend\models\MemberCard;
use backend\models\Employee;
use backend\models\MemberTransferClassForm;
use backend\models\PrivateTeachingUpgradeForm;
use backend\models\PotentialMemberEdit;
use backend\models\PrivateNumberForm;
use backend\models\TransferCardForm;
use backend\models\CardRenewForm;
use backend\models\AboutClass;
use backend\models\Member;
use backend\models\ExtensionRecord;
use backend\models\MemberForm;
use backend\models\ConsultantChangeRecord;
use common\models\ChangeVenueRecord;
use common\models\Func;
use backend\models\EntryRecord;
use backend\models\PrivateClassDelayForm;
use backend\models\AddConsumptionHistoryForm;
use backend\models\AddCourseOrderForm;
use backend\models\IcBindingForm;
use backend\models\MemberDeposit;
use backend\models\ConsumptionHistoryForm;
use backend\models\NewTransferCardForm;
use backend\models\TransferRecord;
use Yii;

class MemberController extends BaseController
{
    public $data;

    /**
     * @describe 会员管理 - 首页 - 列表的展示
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @return string
     * @throws \Exception
     */
    public function actionList()
    {
        $params = $this->get;
        $model = new Member();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }

        $memberInfo = $model->search($params);

        $listHtml = $this->renderPartial('memberTable', ['data' => isset($memberInfo['list']) ? $memberInfo['list'] : []]);

        $paginationA = new \yii\data\Pagination();
        $paginationA->totalCount = isset($memberInfo['count']) ? (int)$memberInfo['count'] : 0;
        $paginationA->setPageSize(8);
        $paginationA->setPage($nowPage - 1);
        $pages = Func::getPagesFormat($paginationA);
        if (\Yii::$app->request->get('page')) {
            return json_encode(['data' => $listHtml, 'pages' => $pages, 'nowPage' => $nowPage]);
        }

        return $this->render('memberList', [
            'data' => $listHtml,//列表数据
            'pages' => $pages,//列表分页
            'nowPage' => $nowPage,//当前所属分页
        ]);
    }

    /**
     *后台会员管理 - 会员卡信息冻结 - 会员卡状态修改
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/22
     * @return bool|string
     */
    public function actionUpdateStatus()
    {
        $memberCardId = \Yii::$app->request->get('memberCardId');
        $status = MemberCard::getUpdateMemberCard($memberCardId);

        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }

    }

    /**
     * @describe 后台会员管理 - 会员信息查询 - angularJs访问该控制器
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @return string
     * @throws \Exception
     */
    public function actionMemberInfo()
    {
        $params = $this->get;
        $model = new Member();
        $memberInfo = $model->search($params);
        $pagination = $memberInfo->pagination;
        $pages = Func::getPagesFormat($pagination);
        $this->data = json_encode(['data' => $memberInfo->models, 'pages' => $pages]);

        return json_encode(['data' => $memberInfo->models, 'pages' => $pages]);
    }

    /**
     * 会员管理 - 首页 - 列表的展示
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
     * 会员管理 - 首页 - 会员详情页面
     * @return string
     * @auther 李广杨
     * @create 2017-3-25
     * @param
     */
    public function actionCourseDetails()
    {
        return $this->render('courseDetails');
    }

    /**
     * @describe 会员管理 - 首页 - 约课管理
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @return string
     * @throws \Exception
     */
    public function actionGetAboutData()
    {
        $params = $this->get;
        $about = new AboutClass();
        $dataProvider = $about->getAboutClassData($params);
        $data = $about->getClassAndSeatNum($dataProvider->models);
        $pages = Func::getPagesFormat($dataProvider->pagination);

        return json_encode(['data' => $data, 'pages' => $pages]);
    }

    /**
     * 会员管理 - 首页 - 老版本约课管理(课程详情)
     * @return string
     * @author 李慧恩
     * @create 2017-3-25
     * @param
     */
    public function actionGetAboutDetail($id)
    {
        $about = new AboutClass();
        $data = $about->getAboutClassDetail($id);

        return json_encode($data);
    }

    /**
     * 会员管理 - 首页 - 新约课管理(课程详情)
     * @return string
     * @author 李慧恩
     * @param  $id // 课程id
     * @param  $sign //标志
     * @param  $venueId // 场馆id
     * @create 2017-3-25
     * @param
     */
    public function actionGetAboutMemberDetail($id, $sign = "", $venueId = "")
    {
        $about = new AboutClass();
        $data = $about->getNewAboutClassDetail($id, $sign, $venueId);

        return json_encode(['status' => 'success', 'data' => $data]);
    }

    /**
     * @api {post} /member/set-member-info 新增潜在会员
     * @apiVersion  1.0.0
     * @apiName 新增潜在会员信息
     * @apiGroup potentialMember
     * @apiPermission 管理员
     *
     * @apiParam {string}      memberName     会员姓名
     * @apiParam {string}      memberMobile   会员手机号
     * @apiParam {int}         [memberSex]    会员性别（1表示男 2表示女）
     * @apiParam {int}         [memberAge]    会员年龄
     * @apiParam {string}      [idCard]       会员身份证号
     * @apiParam {string}      [birthDate]    会员生日
     * @apiParam {int}         counselorId   会籍顾问ID
     * @apiParam {string}      [note]         备注
     * @apiParam {string}  _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     *   POST /member/set-member-info
     *   {
     *        "memberName": "张三",
     *        "memberMobile": "15713718822",
     *        "memberSex": "1",
     *        "memberAge": "21",
     *        "idCard": "412865658242524217",
     *        "birthDate": "2000-01-01",
     *        "counselorId": "1",
     *        "note": "这是备注,
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 管理员可以新增潜在会员
     * <br/>
     * <span><strong>作   者：</strong></span>黄鹏举<br>
     * <span><strong>邮   箱：</strong></span>huangpengju@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/6/5
     * @apiSampleRequest  http://qa.uniwlan.com/member/set-member-info
     * @apiSuccess (返回值) {string} data 返回的数据
     *
     */
    public function actionSetMemberInfo()
    {
        $post = \Yii::$app->request->post();    //获取数据
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $model = new MemberForm();
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->saveMemberInfo($companyId, $venueId);
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '添加成功']);
            } else if ($result === false) {
                return json_encode(['status' => 'error', 'data' => '添加失败']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => '添加失败']);
        }
    }

    /**
     * 后台 - 潜在会员查询 - 获取所有的潜在会员信息
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/5/23
     * @return string
     */
    public function actionGetMemberInfo()
    {
        // 场馆id nowVenueId;    公司id nowCompanyId;
        $params = $this->get;                  //搜索条件
        $params["nowCompanyId"] = !empty($params["nowCompanyId"]) ? $params["nowCompanyId"] : $this->companyId;
        $model = new Member();
        $dataProvider = $model->getMemberInfo($params, self::$_userId);
        $pages = Func::getPagesFormat($dataProvider->pagination);

        return json_encode(['data' => $dataProvider->models, 'pages' => $pages]);
    }

    /**
     * 后台 - 潜在会员 - 信息删除
     * @author Huang pengju huangpengju@itsports.club
     * @create 2017/6/23
     * @param $memberId //会员id
     * @return string
     */
    public function actionDelMemberInfo($memberId)
    {
        $model = new Member();
        $companyId = $this->companyId;
        $data = $model->delMemberInfo($memberId, $companyId);
        if ($data === false) {
            return json_encode(['status' => 'error', 'message' => '删除失败']);
        } else {
            return json_encode(['status' => 'success', 'message' => '删除成功']);
        }
    }

    /**
     * @api {get} /member/get-member-card 获取会员卡详情
     * @apiVersion 1.0.0
     * @apiName 获取会员卡详情
     * @apiGroup member
     * @apiPermission 管理员
     * @apiParam {int} memberCardId  会员卡id
     *
     * @apiDescription 会员卡详情<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/26<br>
     * <span><strong>调用方法：</strong></span>/member/get-member-card
     *
     * @apiSampleRequest  http://qa.uniwlan.com/member/transfer-card
     * @apiSuccess (返回值) {string} data 会员卡信息数据 ｛amount_money：金额，duration：总天数, invalid_time：到期时间, 剩余天数需要计算｝
     */
    public function actionGetMemberCard()
    {
        $id = \Yii::$app->request->get('memberCardId');
        if (!empty($id)) {
            $model = new CardRenewForm();
            $data = $model->getMemberCard($id);
            return json_encode($data);
        } else {
            return false;
        }
    }

    /**
     * @api {get} /member/history 会员缴费记录
     * @apiVersion 1.0.0
     * @apiName 会员缴费记录
     * @apiGroup member
     * @apiPermission 管理员
     * @apiParam {int} memberCardId  会员卡id
     *
     * @apiDescription 会员卡详情 - 会员缴费记录<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/23<br>
     * <span><strong>调用方法：</strong></span>/member/history
     *
     * @apiSampleRequest  http://qa.uniwlan.com/member/history
     * @apiSuccess (返回值) {string} data 会员缴费记录 ｛consumption_date：缴费时间，card_name：缴费名称, consumption_amount：缴费金额, name：客服, invalid_time：有效期, consumption_type：行为｝
     */
    public function actionHistory()
    {
        $id = \Yii::$app->request->get('memberCardId');
        if (!empty($id)) {
            $model = new ConsumptionHistory();
            $data = $model->getHistory($id);
            return json_encode($data);
        } else {
            return false;
        }
    }

    /**
     * 会员管理 - 会员卡详情 - 批量删除续费记录
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/12/09
     */
    public function actionBatchDelRenewHistory()
    {
        $post = \Yii::$app->request->post();
        if (!isset($post['conHistoryId'])) {
            return json_encode(['status' => 'error', 'data' => '请先选择删除项']);
        }
        $model = new ConsumptionHistory();
        $data = $model->delRenewHistory($post);
        if ($data == true) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['error' => 'success', 'data' => $data]);
        }
    }

    /**
     * @api {post} /member/card-renew 会员卡续费
     * @apiVersion 1.0.0
     * @apiName 会员卡详情 - 会员卡续费
     * @apiGroup member
     * @apiPermission 管理员
     *
     * @apiParam  {int}      memberCardId  会员卡ID.
     * @apiParam  {string}  renewDate     续费日期.
     * @apiParam  {decimal} renewPrice   续费金额.
     * @apiParam  {string}  endTime      到期日.
     * @apiParam  {int}    seller       销售员
     * @apiParam  {string} _csrf_backend   csrf验证.
     *
     * @apiParamExample {json} Request Example
     *   POST /member/card-renew
     *   {
     *       "memberCardId": 50,
     *       "renewDate": 2017-5-25,
     *       "renewPrice": 3000,
     *       "endTime":2018-5-25,
     *       "seller":2,
     *       "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 管理员进入会员卡详情-会员卡续费
     * <br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/26<br>
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/member/card-renew
     * @apiSampleRequest  http://qa.uniwlan.com/member/card-renew
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"续费成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *   'data':{
     *     'renewDate':'续费日期不能为空'
     *   }}
     */
    public function actionCardRenew()
    {
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $post = \Yii::$app->request->post();
        $model = new CardRenewForm();
        if ($model->load($post, '') && $model->validate()) {
            $save = $model->saveCardRenew($companyId, $venueId);
            if ($save === true) {
                return json_encode(['status' => 'success', 'data' => '续费成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $save]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 云运动 - 会员管理 - 续费获取所有卡种名
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/19
     */
    public function actionGetRenewalCard()
    {
        $id = $this->nowBelongId;
        $type = $this->nowBelongType;
        $model = new CardCategory();
        $type = $model->getCardData($id, $type);
        return json_encode(['type' => $type]);
    }

    /**
     * @api {post} /member/transfer-card 会员转卡
     * @apiVersion 1.0.0
     * @apiName 会员卡详情 - 会员转卡
     * @apiGroup member
     * @apiPermission 管理员
     * * @apiParam {int} memberCardId  会员卡id
     * @apiParam {int} name  姓名
     * @apiParam {string} mobile 手机号
     * @apiParam {int} transferPrice 转让金额
     * @apiParamExample {json} Request Example
     * post /member/transfer-card
     * {
     *      "memberCardId"=>60,
     *      "name"=>李丽,
     *      "mobile"=>"15789562356",
     *      "transferPrice"=>2000,
     *      "_csrf_backend"=>"_asjbbjkashdjkashdkashdkhasdhaskda==",
     * }
     * post /member/transfer-card
     * @apiDescription 会员卡详情 - 会员转卡
     * <br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/26<br>
     * <span><strong>调用方法：</strong></span>/member/transfer-card
     *
     * @apiSampleRequest  http://qa.uniwlan.com/member/transfer-card
     * @apiSuccess (返回值) {string} status 返回状态
     * @apiSuccess (返回值) {string} data   返回状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':“转卡成功”}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':“手机号不存在”}
     */
    public function actionTransferCard()
    {
        $post = \Yii::$app->request->post();
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $model = new TransferCardForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->saveTransferCard($companyId, $venueId);
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '转卡成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 后台 - 会员管理 - 会员卡转移功能
     * @author huanghua <huanghua@itsports.club>
     * @create 2018/3/15
     * @return array
     */
    public function actionNewTransferCard()
    {
        $post = \Yii::$app->request->post();
        $model = new NewTransferCardForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->saveTransferCard();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '转卡成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api {post} /member/card-update 会员卡升级
     * @apiVersion 1.0.0
     * @apiName 会员卡升级
     * @apiGroup member
     * @apiPermission 管理员
     * @apiParam {int} memberCardId  会员卡id
     * @apiParam {decimal} sellPrice  售价
     * @apiParam {int} discount 折扣
     * @apiParam {int} seller 销售员
     * @apiParam {int} cardId 新卡种id
     * @apiParamExample {json} Request Example
     * post /member/card-update
     * {
     *      "memberCardId"=>60,
     *      "sellPrice"=>2000,
     *      "discount"=>"8",
     *      "seller"=>2,
     *      "cardId"=>61,
     *      "_csrf_backend"=>"_asjbbjkashdjkashdkashdkhasdhaskda==",
     * }
     * post /member/card-update
     * @apiDescription 会员卡详情 - 会员卡升级<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/26<br>
     * <span><strong>调用方法：</strong></span>/member/card-update
     *
     * @apiSampleRequest  http://qa.uniwlan.com/member/card-update
     * @apiSuccess (返回值) {string} status 返回状态
     * @apiSuccess (返回值) {string} data   返回状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':“升级成功”}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':“请填写售价”}
     */
    public function actionCardUpdate()
    {
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $post = \Yii::$app->request->post();
        $model = new CardUpdateForm();
        if ($model->load($post, '') && $model->validate()) {
            if ($model->saveCardUpdate($companyId, $venueId)) {
                return json_encode(['status' => 'success', 'data' => '升级成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $model->errors]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 后台 - 会员管理 - 新会员卡升级
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/9/14
     * @return array
     */
    public function actionNewCardUpdate()
    {
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $post = \Yii::$app->request->post();
        $model = new NewCardUpdateForm();
        if ($model->load($post, '') && $model->validate()) {
            if ($model->newSaveCardUpdate($companyId, $venueId)) {
                return json_encode(['status' => 'success', 'data' => '升级成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $model->errors]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api {get} /member/get-card-type 查询同类型卡种
     * @apiVersion 1.0.0
     * @apiName 查询同类型卡种
     * @apiGroup member
     * @apiPermission 管理员
     * @apiParam {int} memberCardId  会员卡id
     *
     * @apiDescription 会员卡升级 - 查询同类型卡种<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/25<br>
     * <span><strong>调用方法：</strong></span>/member/get-card-type
     *
     * @apiSampleRequest  http://qa.uniwlan.com/member/get-card-type
     * @apiSuccess (返回值) {string} status 返回状态
     * @apiSuccess (返回值) {string} data   返回状态的数据
     *
     * @apiSuccess (返回值) {string} data 同类型卡种信息 ｛type_name：卡类型，card_name：卡名称，sell_price：金额，duration：有效期，times：次数，active_time：激活期限}
     * @apiErrorExample {json} 错误示例:
     * []
     */
    public function actionGetCardType()
    {
        $memberCardId = \Yii::$app->request->get('memberCardId');
        $id = $this->nowBelongId;
        $type = $this->nowBelongType;
        if (!empty($memberCardId)) {
            $model = new CardCategory();
            $data = $model->getCardCate($memberCardId, $id, $type);
            return json_encode($data);
        } else {
            return false;
        }
    }

    /**
     * @api {get} /member/get-new-card 查询新卡信息
     * @apiVersion 1.0.0
     * @apiName 查询新卡信息
     * @apiGroup member
     * @apiPermission 管理员
     * @apiParam {int} cardId  卡种id
     *
     * @apiDescription 会员卡升级 - 查询新卡信息<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/25<br>
     * <span><strong>调用方法：</strong></span>/member/get-new-card
     *
     * @apiSampleRequest  http://qa.uniwlan.com/member/get-new-card
     * @apiSuccess (返回值) {string} status 返回状态
     * @apiSuccess (返回值) {string} data   返回状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {"id":"10","category_type_id":"1",...}
     * @apiErrorExample {json} 错误示例:
     * []
     */
    public function actionGetNewCard()
    {
        $id = \Yii::$app->request->get('cardId');
        if (!empty($id)) {
            $model = new CardUpdateForm();
            $data = $model->getNewCard($id);
            return json_encode($data);
        } else {
            return false;
        }
    }

    /**
     * @api {post} /member/set-member-charge-transfer 会员转课记录
     * @apiVersion 1.0.0
     * @apiName 会员转课
     * @apiGroup member
     * @apiPermission 管理员
     *
     * @apiParam  {int}    memberId        会员ID.
     * @apiParam  {string} memberNumber    会员卡号.
     * @apiParam  {string} transferPrice   转让金额.
     * @apiParam  {int}   transferNum      转让节数.
     * @apiParam  {int}   chargeId         转让课程ID
     * @apiParam  {string} _csrf_backend   csrf验证.
     *
     * @apiParamExample {json} Request Example
     *   POST /check-card/set-member-charge-transfer
     *   {
     *       "memberId": 125,
     *       "memberNumber": 0929890,
     *       "transferPrice": 3000,
     *       "transferNum":2,
     *       "chargeId":2,
     *       "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 管理员进入会员卡详情-会员转课
     * <br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/26<br>
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/member/set-member-charge-transfer
     * @apiSampleRequest  http://qa.uniwlan.com/member/set-member-charge-transfer
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"转课成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *   'data':{
     *     'memberId':'会员ID不能为空'
     *   }}
     */
    public function actionSetMemberChargeTransfer()
    {
        $post = \Yii::$app->request->post();
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $model = new MemberTransferClassForm([], $companyId, $venueId);
        $model->setScenario('privateLessons');
        if ($model->load($post, '') && $model->validate()) {
//            $model->loadCode();
            $save = $model->saveTransferInfo();
            if ($save == 'no class' && $save !== true) {
                return json_encode(['status' => 'error', 'data' => '该会员没有课程了']);
            } else if ($save == 'num' && $save !== true) {
                return json_encode(['status' => 'error', 'data' => '转让课程数量大于会员剩余课量']);
            } else if ($save == 'no member' && $save !== true) {
                return json_encode(['status' => 'error', 'data' => '该会员不存在']);
            } else if ($save === true) {
                return json_encode(['status' => 'success', 'data' => '转课成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => '转课失败']);
            }
        }
        return json_encode(['status' => 'error', 'data' => $model->errors]);
    }

    /**
     * @api {post} /member/edit-member  潜在会员（编辑）
     * @apiVersion  1.0.0
     * @apiName  潜在会员编辑
     * @apiGroup potentialMember
     * @apiPermission 管理员
     * @apiParam {int}         memberId        会员id
     * @apiParam {int}         sex             性别 1：男 2: 女
     * @apiParam {string}      idCard          会员身份证号
     * @apiParam {date}        birthDate       会员出生日期
     * @apiParam {decimal}     deposit         会员定金
     * @apiParam {string}      wayToShop       来电途径
     * @apiParam {int}         counselorId     会籍顾问ID
     * @apiParam {string}      note            备注
     * @apiParam {string}     _csrf_backend    CSRF验证
     * @apiParamExample {json} Request Example
     *   POST /member/set-member-info
     *   {
     *        "memberId": 12,                   // 会员id
     *        "sex": 1,                         // 会员性别
     *        "idCard ": "410782199303060958", // 身份证号
     *        "birthDate: "1993-05-08",        // 出生日期
     *        "deposit":  92,                  // 会员定金
     *        "wayToShop": 52,                 // 会员到店途径 下拉列表id
     *        "counselorId": "1",              //会籍顾问ID
     *        "note": "这是备注,               //备注
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 潜在会员（编辑）
     * <br/>
     * <span><strong>作   者：</strong></span>侯凯新<br>
     * <span><strong>邮   箱：</strong></span>houkaixin@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/7/12
     * @apiSampleRequest  http://qa.uniwlan.com/member/edit-member
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"成功信息"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *   'data':{
     *     "报错信息"
     *   }}
     */
    public function actionEditMember()
    {
        $post = \Yii::$app->request->post();
        $model = new PotentialMemberEdit();
        if ($model->load($post, '') && $model->validate()) {
            $edit = $model->editMember();
            if ($edit === true) {
                return json_encode(['status' => 'success', 'data' => $edit]);
            } else {
                return json_encode(['status' => 'error', 'data' => $edit]);
            }
        }
        return json_encode(['status' => 'error', 'data' => $model->errors]);
    }

    /**
     * 后台 - 会员管理 - 会员卡详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/3
     * @return array
     */
    public function actionMemberCardDetails()
    {
        $id = \Yii::$app->request->get('memberCardId');
        if (!empty($id)) {
            $model = new MemberCard();
            $data = $model->memberCardDetails($id);
            return json_encode(['data' => $data]);
        } else {
            return false;
        }
    }

    /**
     * 业务后台 - 数据 - 绑定带人卡
     * @return string
     */
    public function actionSaveMainCard()
    {
        $post = \Yii::$app->request->post();
        $model = new HandCardForm();
        if ($model->load($post, '') && $model->validate()) {
            $edit = $model->setMainCard();
            if ($edit === true) {
                return json_encode(['status' => 'success', 'data' => $edit]);
            } else {
                return json_encode(['status' => 'error', 'data' => $edit]);
            }
        }
        return json_encode(['status' => 'error', 'data' => $model->errors]);
    }

    /**
     * 业务后台 - 数据 - 获取副卡信息
     * @return string
     */
    public function actionGetViceCards($id)
    {
        $memberCard = new MemberCard();
        $data = $memberCard->getViceCards($id);
        return json_encode(['data' => $data]);
    }

    /**
     * 业务后台 - 数据 - 获取副卡信息
     * @return string
     */
    public function actionIsViceCards($id)
    {
        $memberCard = new MemberCard();
        $data = $memberCard->isMemberHaveViceCards($id);
        return json_encode(['data' => $data]);
    }

    /**
     * 业务后台 - 数据 - 解除绑定
     * @return string
     */
    public function actionDelViceCards($id)
    {
        $memberCard = new MemberCard();
        $data = $memberCard->delMemberHaveViceCards($id);
        return json_encode(['status' => 'success', 'message' => '解绑成功', 'data' => $data]);
    }

    /**
     * 云运动 - 会员管理 - 会员详情信息记录赠送天数列表
     * @author 黄华 <huanghua@itsports.club>
     * @create 2017/10/16
     * @return array
     */
    public function actionGiveDayInfo()
    {
        $id = \Yii::$app->request->get('memberId');
        if (!empty($id)) {
            $model = new GiftRecord();
            $data = $model->giftRecord($id);
            return json_encode(['data' => $data]);
        } else {
            return false;
        }
    }

    /**
     * 云运动 - 会员管理 - 会员详情信息记录 撤销赠送天数
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/1/31
     * @return array
     */
    public function actionCancelGiftDay()
    {
        $giftId = \Yii::$app->request->get('giftId');
        $memberCardId = \Yii::$app->request->get('memberCardId');
        $model = new GiftRecord();
        $data = $model->cancelGiftDay($giftId, $memberCardId);
        if ($data == true) {
            return json_encode(['status' => 'success', 'data' => '操作成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '操作失败']);
        }
    }

    /**
     * @会员管理 - 私课信息 - 延期
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/10/13
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
     *后台会员管理 - 私课延期 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/10/13
     * @return bool|string
     */
    public function actionExtensionRecordInfo()
    {
        $memberId = \Yii::$app->request->get('memberId');
        if (!empty($memberId)) {
            $model = new ExtensionRecord();
            $memberInfo = $model->ExtensionRecordData($memberId);
            return json_encode(['extension' => $memberInfo]);
        } else {
            return false;
        }
    }

    /**
     *后台会员管理 - 进场离场查询 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/17
     * @return bool|string
     */
    public function actionEntryRecordInfo()
    {

        $params = \Yii::$app->request->queryParams;
        if (!empty($params['MemberId'])) {
            $model = new EntryRecord();
            $memberInfo = $model->EntryRecordData($params);
            $count = $memberInfo->pagination->totalCount;
            $pages = Func::getPagesFormat($memberInfo->pagination, 'replaceEntryPages');
            return json_encode(['entry' => $memberInfo->models, 'count' => $count, 'pages' => $pages]);
        } else {
            return false;
        }
    }

    /**
     *后台会员管理 - 会员列表 - 会员指纹删除
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/11/6
     * @return bool|string
     */
    public function actionUpdateFingerprint()
    {
        $id = \Yii::$app->request->get('memberId');
        $model = new MemberDetails();
        $status = $model->getUpdateMemberDetails($id);
        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }
    }

    /**
     *后台会员管理 - 会员列表 - 会员指纹头像
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/11/6
     * @return bool|string
     */
    public function actionDelMemberPhoto()
    {
        $memberId = \Yii::$app->request->get('memberId');
        $model = new MemberDetails();
        $status = $model->delMemberPhoto($memberId);
        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }
    }

    /**
     *后台会员管理 - 私课信息 - 剩余节数修改
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/11/11
     * @return bool|string
     */
    public function actionEditPersonal()
    {
        $post = \Yii::$app->request->post();
        $model = new PrivateNumberForm();
        if ($model->load($post, '') && $model->validate()) {
            $edit = $model->editPrivate();
            if ($edit === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $edit]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台会员管理 - 会员详情 - 会员消费记录删除
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/11/16
     * @return bool|string
     */
    public function actionDelConsumptionData()
    {
        $consumptionId = \Yii::$app->request->get('consumptionId');
        $model = new ConsumptionHistory();
        $delRes = $model->getConsumptionDel($consumptionId);
        if ($delRes) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     *后台会员管理 - 会员详情 - 会员消费记录表修改
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/11/16
     * @return bool|string
     */
    public function actionUpdateConsumption()
    {
        $post = \Yii::$app->request->post();
        $model = new ConsumptionHistoryForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->updateData();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台会员管理 - 会员列表 - IC卡绑定
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/11/20
     * @return bool|string
     */
    public function actionIcBinding()
    {
        $companyId = isset($this->companyId) ? $this->companyId : 0;
        $venueId = isset($this->venueId) ? $this->venueId : 0;
        $post = \Yii::$app->request->post();
        $model = new IcBindingForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->updateData($companyId, $venueId);
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台会员管理 - 会员列表 - IC卡解绑
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/3/23
     * @return bool|string
     */
    public function actionDelIc()
    {
        $memberId = \Yii::$app->request->get('memberId');
        $memberDetails = new IcBindRecord();
        $data = $memberDetails->delIcData($memberId);
        return json_encode(['status' => 'success', 'message' => '解绑成功', 'data' => $data]);
    }

    /**
     * 云运动 - 会员管理 - 付款方式获取模板
     * @return string
     * @author huanghua
     * @create 2017-11-22
     */
    public function actionAddVenue()
    {
        $attr = isset($this->post['attr']) ? $this->post['attr'] : '';
        $num = isset($this->post['num']) ? $this->post['num'] : 0;
        $param = CardCategory::getTemplate($attr);
        $html = $this->renderPartial($param, ['num' => $num]);

        return json_encode(['html' => $html]);
    }

    /**
     * @后台会员管理 - 私课修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/28
     * @return bool|string
     */
    public function actionChargeUpdate()
    {
        $post = \Yii::$app->request->post();
        $model = new MemberCourseOrderForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->chargeUpdate();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @后台会员管理 - 新增续费记录
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/12/6
     * @return bool|string
     */
    public function actionAddConsumptionHistory()
    {
        $companyId = isset($this->companyId) ? $this->companyId : 0;
        $venueId = isset($this->venueId) ? $this->venueId : 0;
        $post = \Yii::$app->request->post();
        $model = new AddConsumptionHistoryForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->addMyData($companyId, $venueId);
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
     * @后台会员管理 - 新增私教记录
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/12/8
     * @return bool|string
     */
    public function actionAddCourseOrder()
    {
        $companyId = isset($this->companyId) ? $this->companyId : 0;
        $venueId = isset($this->venueId) ? $this->venueId : 0;
        $post = \Yii::$app->request->post();
        $model = new AddCourseOrderForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->chargeAdd($companyId, $venueId);
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
     * @后台会员管理 - 会员预约场地记录
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/12/8
     * @param $memberId
     * @return bool|string
     */
    public function actionGetMemberAboutYardRecord($memberId)
    {
        $yard = new AboutYard();
        $data = $yard->getMemberAboutYardRecord($memberId);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination);
        return json_encode(['status' => 'success', 'pages' => $pages, 'data' => $data->models]);
    }

    /**
     * @后台会员管理 - 会员信息记录 - 定金列表方法
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/12/28
     * @return bool|string
     */
    public function actionMemberDepositList()
    {
        $params = \Yii::$app->request->queryParams;
        if (!empty($params['memberId'])) {
            $model = new MemberDeposit();
            $memberInfo = $model->memberDepositData($params);
            $allPrice = array_sum(array_column($memberInfo, 'price'));
            $allVoucher = array_sum(array_column($memberInfo, 'voucher'));
            return json_encode(['deposit' => $memberInfo, 'allPrice' => $allPrice, 'allVoucher' => $allVoucher]);
        } else {
            return false;
        }
    }

    /**
     * @后台会员管理 - 会员信息记录 - 定金删除
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/12/28
     * @return bool|string
     */
    public function actionDelDepositData()
    {
        $depositId = \Yii::$app->request->get('depositId');
        $model = new MemberDeposit();
        $delRes = $model->getDepositDel($depositId);
        if ($delRes === true) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $delRes]);
        }
    }

    /**
     * @后台会员管理 - 会员信息记录 - 不同操作获取不同的定金数据
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/12/29
     * @return bool|string
     */
    public function actionDepositDataType()
    {
        $type = \Yii::$app->request->queryParams;
        if (!empty($type['memberId']) && !empty($type['type'])) {
            $model = new MemberDeposit();
            $depositInfo = $model->depositTypeData($type);
            $allPrice = array_sum(array_column($depositInfo, 'price'));
            $allVoucher = array_sum(array_column($depositInfo, 'voucher'));
            return json_encode(['type' => $depositInfo, 'allPrice' => $allPrice, 'allVoucher' => $allVoucher]);
        } else {
            return false;
        }
    }

    /**
     * @desc: 私教小团体-私教购课-判断是否为新办会员(一天内用pos价格)
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/01/16
     * @return string
     */
    public function actionJudgeMember()
    {
        $memberId = Yii::$app->request->get('numberId');
        $model = new MemberCard();
        $data = $model->getJudgeMember($memberId);
        if ($data) {
            return json_encode(['status' => 'success', 'data' => '新会员']);
        } else {
            return json_encode(['status' => 'error', 'data' => '老会员']);
        }
    }

    /**
     * @desc: 判断此卡是否请假
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/03/01
     * @return string
     */
    public function actionJudgeLeave()
    {
        $memberCardId = Yii::$app->request->get('memberCardId');
        $model = new MemberCard();
        $data = $model->judgeLeave($memberCardId);
        return json_encode($data);
    }

    /**
     * @desc: 会员管理-会员信息修改-判断手机号是否存在
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/28
     * @return string
     */
    public function actionJudgeMobile()
    {
        $mobile = Yii::$app->request->get('mobile');
        $memberId = Yii::$app->request->get('memberId');
        $model = new Member();
        $data = $model->judgeMobile($mobile, $memberId);
        if ($data) {
            return json_encode(['status' => 'error', 'data' => '手机号已存在']);
        }
        return json_encode(['status' => 'success', 'data' => '手机号不存在']);
    }

    /**
     * @后台会员管理 - 会员信息记录 - 会籍变更记录
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/2/26
     * @return bool|string
     */
    public function actionConsultantChange()
    {
        $memberId = \Yii::$app->request->get('memberId');
        if (!empty($memberId)) {
            $model = new ConsultantChangeRecord();
            $memberData = $model->consultantListData($memberId);
            $pagination = $memberData->pagination;
            $pages = Func::getPagesFormat($pagination, 'consultantPages');
            return json_encode(['data' => $memberData->models, 'page' => $pages]);
        } else {
            return false;
        }
    }

    /**
     *后台会员管理 - 私课延期 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/10/13
     * @return bool|string
     */
    public function actionLeaveRecordData()
    {
        $cardId = \Yii::$app->request->get('cardId');
        if (!empty($cardId)) {
            $model = new MemberCard();
            $memberCardInfo = $model->LeaveRecordData($cardId);
            return json_encode(['card' => $memberCardInfo]);
        } else {
            return false;
        }
    }

    /**
     * @desc: 业务后台 - 会员管理 - 会员卡变更记录
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/03/23
     * @return bool|string
     */
    public function actionMemberChangeRecords()
    {
        $memberCardId = \Yii::$app->request->get('memberCardId');
        //var_dump($memberCardId);die();
        if (!empty($memberCardId)) {
            $model = new ConsumptionHistory();
            $history = $model->getMemberChangeRecords($memberCardId);
            return json_encode($history);
        } else {
            return false;
        }
    }

    /**
     * @desc: 会员管理-会员转卡-通过手机号搜索所有会员
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/03/02
     * @return string
     */
    public function actionSearchMember()
    {
        $mobile = \Yii::$app->request->get('mobile');
        $type = new CardCategory();
        $venueId = $type->getVenueIdByRole();
        $member = new Member();
        $data = $member->searchMemberByMobile($mobile, $venueId);
        return json_encode($data);
    }

    /**
     *后台会员管理 - 会员卡详情 - 会员id获取姓名场馆
     * @author Huang hua <huanghua@itsports.club>
     * @create 2018/3/15
     * @return bool|string
     */
    public function actionMemberVenueName()
    {
        $memberId = \Yii::$app->request->get('memberId');
        if (!empty($memberId)) {
            $model = new Member();
            $memberCardInfo = $model->MemberVenueName($memberId);
            return json_encode(['card' => $memberCardInfo]);
        } else {
            return false;
        }
    }

    /**
     * 云运动 - 会员管理 - 会员详情信息转卡记录列表
     * @author 黄华 <huanghua@itsports.club>
     * @create 2018/3/9
     * @return array
     */
    public function actionTurnCardInfo()
    {
        $id = \Yii::$app->request->get('memberId');
        if (!empty($id)) {
            $model = new TransferRecord();
            $data = $model->turnCardRecord($id);
            return json_encode(['data' => $data]);
        } else {
            return false;
        }
    }

    /**
     * 云运动 - 会员管理 - 批量分配私教
     * @author 黄华 <huanghua@itsports.club>
     * @create 2017/9/28
     * @return array
     */
    public function actionBatchAllotPrivate()
    {
        $post = \Yii::$app->request->post();
        $model = new BatchAllotPrivateForm();
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
     * 会员管理 - 正式会员 - 会员详情请假列表自动激活请假
     * @author 黄华 <huanghua@itsports.club>
     * @create 2018/3/26
     * @return array
     */
    public function actionAutomaticLeave()
    {
        $id = \Yii::$app->request->get('memberId');
        $model = new LeaveRecord();
        $data = $model->updateRecord($id);
        if ($data === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $data]);
        }
    }

    /**
     * @desc: 业务后台 - 定金 - 修改定金数据
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/04/02
     * @return string
     */
    public function actionUpdateDeposit()
    {
        $params = \Yii::$app->request->post();
        $model = new MemberDepositForm();
        if ($model->load($params, '') && $model->validate($params)) {
            $result = $model->updateDeposit();
            if ($result == true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        }
        return json_encode(['status' => 'error', 'data' => '修改失败']);
    }

    /**
     * 后台会员管理 - 会员销售顾问 - 销售顾问修改
     * @author Huang hua <huanghua@itsports.club>
     * @create 2018/3/29
     * @return bool|string
     */
    public function actionUpdateCounselor()
    {
        $memberId = \Yii::$app->request->get('memberId');
        $counselorId = \Yii::$app->request->get('counselorId');
        $member = new Member();
        $status = $member->getUpdateCounselor($memberId, $counselorId);
        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }
    }

    /**
     * 后台会员管理 - 会员私教 - 私教修改
     * @author Huang hua <huanghua@itsports.club>
     * @create 2018/3/29
     * @return bool|string
     */
    public function actionUpdatePrivate()
    {
        $memberId = \Yii::$app->request->get('memberId');
        $privateId = \Yii::$app->request->get('privateId');
        $member = new Member();
        $status = $member->getUpdatePrivate($memberId, $privateId);
        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }
    }

    /**
     * @后台会员管理 - 会员信息记录 - 会籍变更记录
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/2/26
     * @return bool|string
     */
    public function actionPersonalChange()
    {
        $memberId = \Yii::$app->request->get('memberId');
        if (!empty($memberId)) {
            $model = new ConsultantChangeRecord();
            $memberData = $model->personalListData($memberId);
            $pagination = $memberData->pagination;
            $pages = Func::getPagesFormat($pagination, 'personalPages');
            return json_encode(['data' => $memberData->models, 'page' => $pages]);
        } else {
            return false;
        }
    }

    /**
     * 后台 - 会员管理 - 会员详情私教课升级
     * @author huanghua <huanghua@itsports.club>
     * @create 2018/4/2
     * @return array
     */
    public function actionPrivateTeachingUpgrade()
    {
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $post = \Yii::$app->request->post();
        $model = new PrivateTeachingUpgradeForm();
        if ($model->load($post, '') && $model->validate()) {
            if ($model->saveChangeUpdate($companyId, $venueId)) {
                return json_encode(['status' => 'success', 'data' => '私教课升级成功!']);
            } else {
                return json_encode(['status' => 'error', 'data' => $model->errors]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @desc: 业务后台 - 会员管理 - 获取修改会员所属场馆记录
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/25
     * @return string
     */
    public function actionMemberChangeVenue()
    {
        $memberId = \Yii::$app->request->get('memberId');
        $model = new ChangeVenueRecord();
        $data = $model->changeVenueData($memberId);
        return json_encode($data);
    }

    /**
     *后台会员管理 - 会员详情 - 信息记录里的ic号绑定记录
     * @author Huang hua <huanghua@itsports.club>
     * @create 2018/4/23
     * @return bool|string
     */
    public function actionIcBindRecords()
    {
        $memberId = \Yii::$app->request->get('memberId');
        if (!empty($memberId)) {
            $model = new IcBindRecord();
            $memberData = $model->icBindRecordInfo($memberId);
            return json_encode(['data' => $memberData]);
        } else {
            return false;
        }
    }

    /**
     * 会员管理 - 正式会员 - 登录账号后自动激活请假
     * @author 张东旭 <zhangdongxu@itsports.club>
     * @create 2018/7/9
     * @return array
     */
    public function actionLoginAutomaticLeave()
    {
        ini_set("memory_limit", "300M");
        set_time_limit(0);
        $model = new LeaveRecord();
        $data = $model->updateAllRecord();
        if ($data === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $data]);
        }
    }

}
