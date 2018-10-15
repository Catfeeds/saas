<?php

namespace backend\controllers;

use backend\models\Config;
use backend\models\ConfigForm;
use backend\models\UpdateGiftCardForm;
use backend\models\EntryRecord;
use backend\models\Member;
use backend\models\CardCategory;
use backend\models\MemberDepositForm;
use backend\models\Organization;
use backend\models\InformationRecords;
use common\models\Func;
use Yii;

class PotentialMembersController extends BaseController
{
    /*
     * 潜在会员首页
     */
    public function actionIndex()
    {
        return $this->render('index', ['companyId' => $this->companyId]);
    }

    /*
    * 潜在会员课程
    */
    public function actionCourseList()
    {
        return $this->render('potentialMemberCourse');
    }

    /**
     * @api {post} /potential-members/set-source 新增潜在会员销售来源
     * @apiVersion  1.0.0
     * @apiName 潜在会员 新增销售来源
     * @apiGroup potentialMember
     * @apiPermission 管理员
     *
     * @apiParam {string}      source     销售来源
     * @apiParam {string}      scenario   场景  （source）
     * @apiParam {string}  _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     *   POST /potential-members/set-source
     *   {
     *        "source": "网络",
     *        "scenario":"source",
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 管理员可以新增销售来源
     * <br/>
     * <span><strong>作   者：</strong></span>黄鹏举<br>
     * <span><strong>邮   箱：</strong></span>huangpengju@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/6/5
     * @apiSampleRequest  http://qa.uniwlan.com/potential-members/set-source
     * @apiSuccess (返回值) {string} data 返回的数据
     *
     */
    public function actionSetSource()
    {
        $post = \Yii::$app->request->post();
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        if (empty($post['scenario'])) {
            $scenario = 'source';
        } else {
            $scenario = $post['scenario'];
        }
        $model = new ConfigForm([], $scenario, $companyId, $venueId);
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->saveSourceInfo();
            if ($result !== false) {
                return json_encode(['status' => 'success', 'data' => '添加成功', 'id' => $result]);
            } else {
                return json_encode(['status' => 'error', 'data' => '添加失败']);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api {get} /potential-members/get-source 获取潜在会员销售来源
     * @apiVersion 1.0.0
     * @apiName 查询销售来源
     * @apiGroup potentialMember
     * @apiPermission 管理员
     *
     * @apiDescription 潜在会员查询下拉列表，返回的销售来源<br/>
     * <span><strong>作    者：</strong></span>黄鹏举<br>
     * <span><strong>邮    箱：</strong></span>huangpengju@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/5<br>
     * <span><strong>调用方法：</strong></span>/potential-members/get-source
     *
     * @apiSampleRequest  http://qa.uniwlan.com/potential-members/get-source
     * @apiSuccess (返回值) {string} data 返回数据
     * @apiErrorExample {json} 错误示例:
     * []
     */
    public function actionGetSource($configType = 'member')
    {
        $model = new Config();
        $data = $model->getMemberConfig($this->venueId, $configType);

        return json_encode($data);
    }


    /**
     *后台潜在会员管理 - 登记进馆 - 获取来源渠道
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/6/21
     * @return bool|string
     */
    public function actionGetSourceData()
    {
        $companyId = Yii::$app->request->get('companyId');
        $venueId = Yii::$app->request->get('venueId');
        $model = new Config();
        $data = $model->getMemberConfigData($companyId, $venueId);
        return json_encode($data);
    }

    /**
     *后台潜在会员管理 - 新增潜在会员 - 销售来源删除
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/6/21
     * @return bool|string
     */
    public function actionDeleteConfig()
    {

        $configId = \Yii::$app->request->get('configId');
        $model = new Config();
        $delete = $model->getConfigDate($configId);
        if ($delete) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     * @api{post} /potential-members/update-potential 潜在会员 - 修改销售来源
     * @apiVersion  1.0.0
     * @apiName 潜在会员 - 修改销售来源
     * @apiGroup potential-members
     * @apiPermission 管理员
     *
     * @apiParam {string} id   修改的配置表id
     * @apiParam {string}      source     销售来源的值
     * @apiParam {string}      scenario   场景  （source）
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "id":"1"
     *        "value": "网络",
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 潜在会员 - 修改销售来源<br/>
     * <span><strong>作   者：</strong></span>黄华<br/>
     * <span><strong>邮   箱：</strong></span>huanghua@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/21<br/>
     * <span><strong>调用方法：</strong></span>/potential-members/update-potential
     * @apiSampleRequest  http://qa.uniwlan.com/potential-members/update-potential
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"修改成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *   'data':{
     *     'name':'修改销售来源的值不能为空'
     *   }}
     */
    public function actionUpdatePotential()
    {
        $post = \Yii::$app->request->post();
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        if (empty($post['scenario'])) {
            $scenario = 'source';
        } else {
            $scenario = $post['scenario'];
        }
        $model = new ConfigForm([], $scenario, $companyId, $venueId);
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
     * @api{post} /potential-members/set-member-deposit-form 增加定金
     * @apiVersion  1.0.0
     * @apiName 增加定金
     * @apiGroup potential-members
     * @apiPermission 管理员
     *
     * @apiParam {int}     memberId   会员id
     * @apiParam {int}     price       定金金额
     * @apiParam {int}     voucher     代金卷
     * @apiParam {string}  startTime   开始时间
     * @apiParam {string}  endTime     结束时间
     * @apiParam {int}     payMode     方式
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "memberId":"1"
     *        "price":"100"
     *        "voucher":"500"
     *        "startTime":"2017-6-27"
     *        "endTime":"2017-7-30"
     *        "member_id":"1"
     *        "payMode": "1",
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 潜在会员 - 增加定金<br/>
     * <span><strong>作   者：</strong></span>李慧恩<br/>
     * <span><strong>邮   箱：</strong></span>lihuien@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/21<br/>
     * <span><strong>调用方法：</strong></span>/potential-members/set-member-deposit-form
     * @apiSampleRequest  http://qa.uniwlan.com/potential-members/set-member-deposit-form
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"修改成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *   'data':{
     *     'memberId':'会员ID不能为空'
     *   }}
     */
    public function actionSetMemberDepositForm()
    {
        $companyId = isset($this->companyId) ? $this->companyId : 0;
        $venueId = isset($this->venueId) ? $this->venueId : 0;
        $post = \Yii::$app->request->post();
        $model = new MemberDepositForm();
        if ($model->load($post, '') && $model->validate()) {
            $save = $model->saveDeposit($companyId, $venueId);
            if ($save === true) {
                return json_encode(['status' => 'success', 'data' => '添加定金成功']);
            }
            return json_encode(['status' => 'error', 'data' => $save]);
        }
        return json_encode(['status' => 'error', 'data' => $model->errors]);
    }

    /**
     * @api{post} /potential-members/get-member-deposit-one 获取会员定金
     * @apiVersion  1.0.0
     * @apiName 获取会员定金
     * @apiGroup potential-members
     * @apiPermission 管理员
     *
     * @apiParam {int}     member_id   会员id
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "memberId":"1"
     *   }
     * @apiDescription 潜在会员 - 增加定金<br/>
     * <span><strong>作   者：</strong></span>李慧恩<br/>
     * <span><strong>邮   箱：</strong></span>lihuien@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/21<br/>
     * <span><strong>调用方法：</strong></span>/potential-members/get-member-deposit-one
     * @apiSampleRequest  http://qa.uniwlan.com/potential-members/get-member-deposit-one
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {  "memberId":"1"
     *        "price":"100"
     *        "voucher":"500"
     *        "startTime":"2017-6-27"
     *        "endTime":"2017-7-30"
     *        "member_id":"1"
     *        "payMode": "1"
     * }
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionGetMemberDepositOne($memberId)
    {
        $data = Member::getMemberDepositOne($memberId);
        return json_encode($data);
    }

    /**
     * 云运动 - 潜在会员 - 手机号公司id判重
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/7/12
     * @return bool|string
     */
    public function actionGetMobileInfo()
    {
        $mobile = \Yii::$app->request->get('mobile');
        $companyId = \Yii::$app->request->get('companyId');
        $venueId = \Yii::$app->request->get('venueId');
        $model = new Member();
        $data = $model->getRegisterInfo($mobile, $companyId, $venueId);
        if ($data && !empty($data)) {
            return json_encode(['status' => 'error', 'data' => '手机号已存在']);
        } else {
            return json_encode(['status' => 'success', 'data' => '手机号不存在']);
        }
    }

    /**
     * 云运动 - 后台 - 获取身份公司场馆信息
     * @author houkaixn<houkaixn@itsports.club>
     * @create 2017/7/14
     * @return object
     */
    public function actionGetIdentify()
    {
        $model = new Organization();
        $data = $model->getAllIdentifyData($this->companyIds);

        return json_encode($data);
    }

    /**
     * 云运动 - 潜在会员 - 付款方式获取模板
     * @return string
     * @author huanghua
     * @create 2017-11-21
     */
    public function actionAddVenue()
    {
        $post = $this->post;
        $attr = '';
        $num = 0;
        if (isset($post['attr'])) {
            $attr = $post['attr'];
        }

        if (isset($post['num'])) {
            $num = $post['num'];
        }

        $param = CardCategory::getTemplate($attr);
        $html = $this->renderPartial($param, ['num' => $num]);

        return json_encode(['html' => $html]);
    }

    /**
     * 后台 - 潜在会员 - 跟进
     * @author zhumengke<zhumengke@itsports.club>
     * @create 2018/2/1
     * @return object
     */
    public function actionFollowUp()
    {
        $post = \Yii::$app->request->post();  //潜在会员id
        $model = new EntryRecord();
        $data = $model->followUp($post, $this->companyId, $this->venueId);
        if ($data == true) {
            return json_encode(['status' => 'success', 'data' => '操作成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '操作失败']);
        }
    }

    /**
     * 后台 - 潜在会员 - 最近入场记录
     * @author zhumengke<zhumengke@itsports.club>
     * @create 2018/2/1
     * @return array
     */
    public function actionGetFollowRecord()
    {
        $memberId = \Yii::$app->request->get('memberId');  //潜在会员id
        $model = new EntryRecord();
        $data = $model->getFollowRecord($memberId);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination, 'followRecordPages');
        return json_encode(['data' => $data->models, 'pages' => $pages]);
    }


    /**
     * 潜在会员 - 潜在会员赠卡 - 修改赠卡时间
     * @author 黄华 <huanghua@itsports.club>
     * @create 2018/3/9
     * @return array
     */
    public function actionUpdateGiftCard()
    {
        $post = \Yii::$app->request->post();
        $model = new UpdateGiftCardForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->updateGiftCard();
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
     * 潜在会员 - 赠卡信息记录 - 信息记录里的行为记录
     * @author Huang hua <huanghua@itsports.club>
     * @create 2018/3/16
     */
    public function actionInformationRecords()
    {
        $memberId = \Yii::$app->request->get('memberId');
        if (!empty($memberId)) {
            $model = new InformationRecords();
            $memberData = $model->getInformationData($memberId);
            return json_encode(['data' => $memberData]);
        } else {
            return false;
        }
    }
}
