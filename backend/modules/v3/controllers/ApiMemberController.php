<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 10:33
 */
namespace backend\modules\v3\controllers;

use backend\models\AboutClass;
use backend\models\Config;
use backend\models\MemberCourseOrderDetails;
use backend\modules\v3\models\AboutClassModel;
use backend\modules\v3\models\LeaveRecordForm;
use backend\modules\v3\models\Member;
use backend\modules\v3\models\MemberCourseOrder;
use backend\modules\v3\models\ScanCode;
use backend\modules\v3\models\UploadForm;
use common\models\base\Deal;
use common\models\base\Employee;
use common\models\base\MemberAccount;
use common\models\base\MemberBase;
use common\models\base\MemberDetails;
use common\models\base\MessageCode;
use common\models\base\Organization;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use backend\modules\v3\base\BaseController;
use yii\web\UploadedFile;
use common\models\Func;

class ApiMemberController extends BaseController
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
     * @api {post}       /v3/api-member/wechat-register     微信公众号注册
     * @apiVersion      1.0.0
     * @apiName         微信公众号注册
     * @apiGroup        member
     * @apiPermission  管理员
     * @apiParam  {string}    name                  姓名
     * @apiParam  {string}    mobile                手机
     * @apiParam  {string}    code                  验证码
     * @apiParam  {string}    venue_id              场馆id
     * @apiParam  {string}    company_id            场馆id
     * @apiParam  {string}    openid                微信openid
     * @apiParam  {string}    last_venue_id         上次登录场馆
     * @apiParam  {string}    source                会员来源 : 小程序注册 : "微信小程序" 、公众号注册 : "微信公众号"
     * @apiParamExample {json} 请求参数
     * post   /v3/api-member/wechat-register   微信公众号注册
     *   {
     *      "name"    :  "夏奇拉"        //姓名
     *      "mobile"  : "18339232573"   //手机
     *      "venueId" : "2"             //场馆id
     *      "source"  : "微信小程序"      //小程序注册 : "微信小程序" 、公众号注册 : "微信公众号"
     *   }
     * @apiDescription    会员来源渠道
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/12/21
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/wechat-register
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *    "code": 1,                 //参数传入是否合法
     *    "status": "success",       //成功状态
     *    "message": "返回成功",     //成功状态
     *    "data": {
     *           "username": "夏奇拉",
     *           "password": "$2y$13$qniV3gL3xLvdMXho489DSuUclwvtl9dX5h59yX7L54NxKPQbwkUmm",
     *           "mobile": "18339232573",
     *           "register_time": 1513839423,
     *           "status": 1,
     *           "member_type": 2,
     *           "venue_id": "2",
     *           "company_id": 1,
     *           "id": "92576"
     *       }
     * }
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *"code": 0,                             //参数传入是否合法
     *"status": "error",                     //错误状态
     *"message": "注册失败",
     *}
     *{
     *"code": 0,                             //参数传入是否合法
     *"status": "error",                     //错误状态
     *"message": "此手机已经注册过了"
     *}
     */
    public function actionWechatRegister()
    {
        $param = \Yii::$app->request->post();
        $member = \common\models\base\Member::find()
            ->where(['mobile' => $param['mobile']])
            ->andWhere(['venue_id' => $param['venue_id']])
            ->one();
        if ($member) {
            return ['code' => 0, 'status' => 'error', 'message' => "此手机已经注册过了"];
        } else {
            $account = MemberAccount::findOne(['mobile' => $param['mobile'], 'company_id' => $param['company_id']]);
            if (!$account) {
                $account = new MemberAccount();
                $account->username = $param['name'];
                $account->password = \Yii::$app->security->generatePasswordHash('123456');
                $account->mobile = $param['mobile'];
                $account->last_time = time();
                $account->company_id = $param['company_id'];
                $account->create_at = time();
                if (!$account->save()) {
                    return $account->errors;
                }
            }
            $member = new \common\models\base\Member();
            $member->username = $param['name'];
            $member->mobile = $param['mobile'];
            $member->password = \Yii::$app->security->generatePasswordHash('123456');
            $member->register_time = time();
            $member->status = 1;
            $member->member_type = 2;
            $member->venue_id = $param['venue_id'];
            $member->company_id = $param['company_id'];
            $member->member_account_id = $account->id;
            if (!$member->save()) {
                return $member->errors;
            }
            if (isset($param['openid']) || isset($param['miniOpenid'])) {
                $memberBase = new MemberBase();
                $memberBase->member_id = $member->id;
                $memberBase->wx_open_id = isset($param['openid']) ? $param['openid'] : '';
                $memberBase->create_at = time();
                $memberBase->venue_id = $member->venue_id;
                $memberBase->company_id = $member->company_id;
                $memberBase->create_at = time();
                $memberBase->update_at = time();
                $memberBase->last_venue_id = $param['last_venue_id'];
                $memberBase->mini_program_openid = isset($param['miniOpenid']) ? $param['miniOpenid'] : '';
                if (!$memberBase->save()) {
                    return $memberBase->errors;
                }
            }
            $source = Config::findOne(['key' => 'source', 'value' => $param['source'], 'type' => 'member', 'company_id' => $param['company_id'], 'venue_id' => $param['venue_id']]);
            if (!$source) {
                $source = new Config();
                $source->key = 'source';
                $source->value = $param['source'];
                $source->type = 'member';
                $source->company_id = $param['company_id'];
                $source->venue_id = $param['venue_id'];
                if (!$source->save()) {
                    return $source->errors;
                }
            }
            $memdetails = new MemberDetails();
            $memdetails->member_id = $member->id;
            $memdetails->name = $param['name'];
            $memdetails->way_to_shop = (string)$source->id;
            $memdetails->created_at = time();
            if ($memdetails->save()) {
                $memberBase = MemberBase::findOne(['member_id' => $member->id]);
                $data = [
                    'id' => $member->id,
                    'member_id' => $member->id,
                    'name' => $member->username,
                    'venue_name' => $member->venue_id == null ? null : Organization::findOne(['id' => $member->venue_id])->name,
                    'mobile' => $member->mobile,
                    'register_time' => $member->register_time,
                    'status' => $member->status,
                    'member_type' => $member->member_type,
                    'venue_id' => $member->venue_id,
                    'company_id' => $member->company_id,
                    'last_venue_id' => $memberBase->last_venue_id,
                    'last_venue_name' => $memberBase->last_venue_id == null ? null : Organization::findOne(['id' => $memberBase->last_venue_id])->name,
                ];
                return ['code' => 1, 'status' => 'success', 'message' => "注册成功", "data" => $data];
            } else {
                return ['code' => 0, 'status' => 'error', 'message' => "注册失败"];
            }
        }
    }


    /**
     * @api {post}        /v3/api-member/wechat-login   微信公众号登陆
     * @apiVersion      1.0.0
     * @apiName         微信公众号登陆
     * @apiGroup        member
     * @apiPermission  管理员
     * @apiParam  {int}     mobile        手机号码
     * @apiParam  {string}  code          验证码
     * @apiParam  {string}  openid        微信openid
     * @apiParam  {string}  miniOpenid    微信小程序openid
     * @apiParamExample {json} 请求参数
     * post   /v3/api-member/wechat-login   微信公众号登陆
     *   {
     *      "mobile"       :  "12345678912"         手机号码
     *      "code"         :  "37803"               验证码
     *      "openid"       :  "qwwrterwsfdfdgf"     微信openid
     *      "miniOpenid"   :  "qwwrterwsfdfdgf"     微信小程序openid
     *   }
     * @apiDescription    微信公众号已约团课列表
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/12/22
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/wechat-login
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *    "code": 1,                 //参数传入是否合法
     *    "status": "success",       //成功状态
     *    "message": "成功",         //成功状态
     *   "data": [
     *       {
     *       }
     *   ]
     * }
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *"code": 0,                             //参数传入是否合法
     *"status": "error",                     //错误状态
     *"message": "您还不是会员，请注册！",
     *}
     */
    public function actionWechatLogin()
    {
        $param = \Yii::$app->request->post();
        $member = \common\models\base\Member::findOne(['mobile' => $param['mobile'], 'venue_id' => $param['venue_id'], 'company_id' => $param['company_id']]);
        if ($member) {
            $messageCode = MessageCode::findOne(['mobile' => $param['mobile'], 'code' => $param['code']]);
            if ($messageCode) {
                if ((isset($param['openid']) && !empty($param['openid'])) || (isset($param['miniOpenid']) && !empty($param['miniOpenid']))) {
                    $isPassed        = true;
                    $memberBaseCount = MemberBase::find()->where(['member_id' => $member->id])->count();
                    if ($memberBaseCount) {
                        if($memberBaseCount == 1){
                            $memberBase = MemberBase::findOne(['member_id' => $member->id]);
                                if (empty($memberBase->wx_open_id) || empty($memberBase->last_venue_id) || empty($memberBase->mini_program_openid)) {
                                    if (isset($param['openid'])) {
                                        $memberBase->wx_open_id = $param['openid'];
                                    } else {
                                        $memberBase->mini_program_openid = $param['miniOpenid'];
                                    }
                                    $memberBase->venue_id = $member->venue_id;
                                    $memberBase->company_id = $member->company_id;
                                    $memberBase->update_at = time();
                                    $memberBase->last_venue_id = $param['last_venue_id'];
                                    if (!$memberBase->save()) {
                                        return $memberBase->errors;
                                    }
                                    $isPassed = false;
                                }
                        }else{
                            MemberBase::deleteAll(['member_id' => $member->id]);
                        }
                    }
                    if($isPassed){
                        $memberBase = new MemberBase();
                        $memberBase->member_id = $member->id;
                        $memberBase->wx_open_id = isset($param['openid']) ? $param['openid'] : '';
                        $memberBase->create_at = time();
                        $memberBase->venue_id = $member->venue_id;
                        $memberBase->company_id = $member->company_id;
                        $memberBase->create_at = time();
                        $memberBase->update_at = time();
                        $memberBase->last_venue_id = $param['last_venue_id'];
                        $memberBase->mini_program_openid = isset($param['miniOpenid']) ? $param['miniOpenid'] : '';
                        if (!$memberBase->save()) {
                            return $memberBase->errors;
                        }
                    }
                }
                $venue = Organization::findOne(['id' => $member->venue_id]);
                $memberBase = MemberBase::findOne(['member_id' => $member->id]);
                if(!$memberBase){
                  $lastVenueId   = NULL;
                  $lastVenueName = NULL;
                }else{
                    $lastVenueId   = $memberBase->last_venue_id;
                    $lastVenueName = $memberBase->last_venue_id == null ? null : Organization::findOne(['id' => $memberBase->last_venue_id])->name;
                }
                $data = [
                    'id' => $member->id,
                    'member_id' => $member->id,
                    'name' => $member->username,
                    'venue_name' => $venue->name,
                    'mobile' => $member->mobile,
                    'register_time' => $member->register_time,
                    'status' => $member->status,
                    'member_type' => $member->member_type,
                    'venue_id' => $member->venue_id,
                    'company_id' => $member->company_id,
                    'last_venue_id' => $lastVenueId,
                    'last_venue_name' => $lastVenueName,
                ];
                return ['code' => 1, 'status' => 'success', 'message' => "登陆成功", "data" => $data];
            } else {
                return ['code' => 0, 'status' => 'error', 'message' => "验证码错误"];
            }
        } else {
            $messageCode = MessageCode::findOne(['mobile' => $param['mobile'], 'code' => $param['code']]);
            if ($messageCode) {
                $lurkMember = \common\models\base\Member::findOne(['mobile' => $param['mobile'], 'company_id' => $param['company_id']]);
                if ($lurkMember) {
                    if ((isset($param['openid']) && !empty($param['openid'])) || (isset($param['miniOpenid']) && !empty($param['miniOpenid']))) {
                        $account = MemberAccount::findOne(['mobile' => $param['mobile'], 'company_id' => $param['company_id']]);
                        if (!$account) {
                            $account = new MemberAccount();
                            $account->username = $lurkMember->username;
                            $account->password = \Yii::$app->security->generatePasswordHash('123456');
                            $account->mobile = $param['mobile'];
                            $account->last_time = time();
                            $account->company_id = $param['company_id'];
                            $account->create_at = time();
                            if (!$account->save()) {
                                return $account->errors;
                            }
                        }
                        $member = new \common\models\base\Member();
                        $member->username = $lurkMember->username;
                        $member->mobile = $param['mobile'];
                        $member->password = \Yii::$app->security->generatePasswordHash('123456');
                        $member->register_time = time();
                        $member->status = 1;
                        $member->member_type = 2;
                        $member->venue_id = $param['venue_id'];
                        $member->company_id = $param['company_id'];
                        $member->member_account_id = $account->id;
                        if (!$member->save()) {
                            return $member->errors;
                        }
                        $memdetails = new MemberDetails();
                        $memdetails->member_id = $member->id;
                        $memdetails->name = $lurkMember->username;
                        $memdetails->created_at = time();
                        if (!$memdetails->save()) {
                            return $memdetails->errors;
                        }
                        $memberBaseCount = MemberBase::find()->where(['member_id' => $member->id])->count();
                        if ($memberBaseCount) {
                            if($memberBaseCount == 1){
                                $memberBase = MemberBase::findOne(['member_id' => $lurkMember->id]);
                                if (empty($memberBase->wx_open_id) || empty($memberBase->last_venue_id) || empty($memberBase->mini_program_openid)) {
                                    $memberBase->member_id = $member->id;
                                    if (isset($param['openid'])) {
                                        $memberBase->wx_open_id = $param['openid'];
                                    } else {
                                        $memberBase->mini_program_openid = $param['miniOpenid'];
                                    }
                                    $memberBase->venue_id = $member->venue_id;
                                    $memberBase->company_id = $member->company_id;
                                    $memberBase->update_at = time();
                                    $memberBase->last_venue_id = $param['last_venue_id'];
                                    if (!$memberBase->save()) {
                                        return $memberBase->errors;
                                    }
                                }
                            }else{
                                MemberBase::deleteAll(['member_id' => $member->id]);
                            }
                        }
                            $memberBase = new MemberBase();
                            $memberBase->member_id = $member->id;
                            $memberBase->wx_open_id = isset($param['openid']) ? $param['openid'] : '';
                            $memberBase->create_at = time();
                            $memberBase->venue_id = $member->venue_id;
                            $memberBase->company_id = $member->company_id;
                            $memberBase->create_at = time();
                            $memberBase->update_at = time();
                            $memberBase->last_venue_id = $param['last_venue_id'];
                            $memberBase->mini_program_openid = isset($param['miniOpenid']) ? $param['miniOpenid'] : '';
                            if (!$memberBase->save()) {
                                return $memberBase->errors;
                            }
                    }
                    $venue = Organization::findOne(['id' => $member->venue_id]);
                    $memberBase = MemberBase::findOne(['member_id' => $member->id]);
                    $data = [
                        'id' => $member->id,
                        'member_id' => $member->id,
                        'name' => $member->username,
                        'venue_name' => $venue->name,
                        'mobile' => $member->mobile,
                        'register_time' => $member->register_time,
                        'status' => $member->status,
                        'member_type' => $member->member_type,
                        'venue_id' => $member->venue_id,
                        'company_id' => $member->company_id,
                        'last_venue_id' => $memberBase->last_venue_id,
                        'last_venue_name' => $memberBase->last_venue_id == null ? null : Organization::findOne(['id' => $memberBase->last_venue_id])->name,
                    ];
                    return ['code' => 1, 'status' => 'success', 'message' => "登陆成功", "data" => $data];
                } else {
                    return ['code' => 0, 'status' => 'error', 'message' => "您不是本公司会员，请先注册"];
                }
            } else {
                return ['code' => 0, 'status' => 'error', 'message' => "验证码错误"];
            }
        }
    }


    /**
     * @api {post}        /v3/api-member/wechat-relogin   微信公众号二次登陆
     * @apiVersion      1.0.0
     * @apiName         微信公众号二次登陆
     * @apiGroup        member
     * @apiPermission  管理员
     * @apiParam  {int}     mobile      手机号码
     * @apiParam  {string}  venue_id    场馆id
     * @apiParam  {string}  company_id   公司id
     * @apiParamExample {json} 请求参数
     * post   /v3/api-member/wechat-relogin   微信公众号二次登陆
     *   {
     *      "mobile"     :  "12345678912"     手机号码
     *      "venue_id"   :  "2"               场馆id
     *      "company_id"  :  "1"               公司id
     *   }
     * @apiDescription    微信公众号二次登陆
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/12/22
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/wechat-relogin
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *"code": 0,                             //参数传入是否合法
     *"status": "error",                     //错误状态
     *"message": "您还不是会员，请注册！",
     *}
     */
    public function actionWechatRelogin()
    {
        $param = \Yii::$app->request->post();
        $member = \common\models\base\Member::findOne(['mobile' => $param['mobile'], 'venue_id' => $param['venue_id'], 'company_id' => $param['company_id']]);
        if ($member) {
            $venue = Organization::findOne(['id' => $member->venue_id]);
            $data = [
                'member_id' => $member->id,
                'name' => $member->username,
                'venue_name' => $venue->name,
                'mobile' => $member->mobile,
                'register_time' => $member->register_time,
                'status' => $member->status,
                'lock_time' => $member->lock_time,
                'counselor_id' => $member->counselor_id,
                'member_type' => $member->member_type,
                'venue_id' => $member->venue_id,
                'company_id' => $member->company_id,
            ];
            return ['code' => 1, 'status' => 'success', 'message' => "登陆成功", "data" => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => "您还不是此场馆的会员，请注册！"];
        }
    }

    /**
     * @api {get}        /v3/api-member/drop-out   公众号或者微信小程序退出
     * @apiVersion      1.0.0
     * @apiName         公众号或者微信小程序退出
     * @apiGroup        member
     * @apiPermission  管理员
     * @apiParam  {string}  mini_program_openid    小程序OpenId
     * @apiParam  {string}  wx_open_id   微信openId
     * @apiParam  {string}  member_id   会员ID
     * @apiParamExample {json} 请求参数
     * get  /v3/api-member/drop-out    公众号或者微信小程序退出
     *   {
     *      "wx_open_id"   :  "2"  //微信openId || ("mini_program_openid"     :  "12345678912"     //小程序OpenId)
     *      "member_id"  :  "1"    //会员ID
     *   }
     * @apiDescription    微信公众号二次登陆
     * <span><strong>作    者：</strong></span>杨慧磊<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/12/22
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/wechat-relogin
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *"code": 0,                             //参数传入是否合法
     *"status": "error",                     //错误状态
     *"message": "退出成功！",
     *}
     */
    public function actionDropOut()
    {
        $param      = \Yii::$app->request->queryParams;
        $key        = (isset($param['mini_program_openid']) && !empty($param['mini_program_openid'])) ? ['mini_program_openid' => $param['mini_program_openid']] : ((isset($param['wx_open_id']) && !empty($param['wx_open_id'])) ? ['wx_open_id' => $param['wx_open_id']] : NULL);
        $memberId   = $param['member_id'] ?: NULL;
        if(!$memberId || !$key){
            return $this->error('缺少必传参数');
        }
        $index      = array_keys($key)[0];
        $condition  = array_merge($key, ['member_id' => $memberId]);
        $result     = MemberBase::updateAll([$index => ''], $condition);
        if($result){
            return $this->success($result, '退出成功');
        }
        return $this->error('退出失败');
    }

    /**
     * @api {get}        /v3/api-member/get-source  会员来源渠道
     * @apiVersion      1.0.0
     * @apiName         .会员来源渠道.会员来源渠道
     * @apiGroup        member
     * @apiPermission  管理员
     * @apiParam  {string}          venueId          场馆id
     * @apiParamExample {json} 请求参数
     * get   /v3/api-member/get-source  会员来源渠道
     *   {
     *      "venueId"   :  2        //场馆id
     *   }
     * @apiDescription    会员来源渠道
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/12/21
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/get-source
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *    "code": 1,                 //参数传入是否合法
     *    "status": "success",       //成功状态
     *    "message": "返回成功",     //成功状态
     *    "data": [
     *        {
     *        "id": "29",
     *        "value": "户外广告"
     *        },
     *        {
     *        "id": "30",
     *        "value": "网络（美团，大众点评，百度糯米，支付宝口碑）"
     *        },
     *        {
     *        "id": "32",
     *        "value": "推荐"
     *        },
     *     ]
     * }
     * @apiSuccessExample {json}返回值详情(失败时)
    {
    "code": 0,                 //参数传入是否合法
    "status": "error",         //错误状态
    "message": "没有数据",
    }
     */
    public function actionGetSource($venueId)
    {
        $data = Config::find()
            ->where(['venue_id'=>$venueId,'type'=>'member'])
            ->select(['id','value'])
            ->asArray()
            ->all();
        if($data){
            return ['code' =>1, 'status' => 'success','message' =>"返回成功","data"=>$data];
        }else{
            return ['code' =>0, 'status' => 'error','message' =>"没有数据"];
        }
    }

    /**
     * @api {get}        /v3/api-member/get-counselor  会籍顾问
     * @apiVersion      1.0.0
     * @apiName         会籍顾问
     * @apiGroup        member
     * @apiPermission  管理员
     * @apiParam  {string}          venueId          场馆id
     * @apiParamExample {json} 请求参数
     * get   /v3/api-member/get-counselor  会籍顾问
     *   {
     *      "venueId"   :  2        //场馆id
     *   }
     * @apiDescription    会员来源渠道
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/12/21
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/get-counselor
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *    "code": 1,                 //参数传入是否合法
     *    "status": "success",       //成功状态
     *    "message": "返回成功",     //成功状态
     *    "data": [
     *        {
     *        "id": "12",
     *        "value": "袁二婷"
     *        },
     *        {
     *        "id": "30",
     *        "value": "赵丹"
     *        }
     *     ]
     * }
     * @apiSuccessExample {json}返回值详情(失败时)
    {
    "code": 0,                 //参数传入是否合法
    "status": "error",         //错误状态
    "message": "没有数据",
    }
     */
    public function actionGetCounselor($venueId)
    {
        $dept = Organization::findOne(['pid'=>$venueId,'name'=>'销售部']);
        if($dept){
            $data = Employee::find()
                ->where(['organization_id'=>$dept->id])
                ->select(['id','name'])
                ->asArray()
                ->all();
            if($data){
                return ['code' =>1, 'status' => 'success','message' =>"返回成功","data"=>$data];
            }else{
                return ['code' =>0, 'status' => 'error','message' =>"没有数据"];
            }
        }else{
            return ['code' =>0, 'status' => 'error','message' =>"没有数据"];
        }
    }

    /**
     * @api {get}        /v3/api-member/get-deal  新会员入会协议
     * @apiVersion      1.0.0
     * @apiName         新会员入会协议
     * @apiGroup        member
     * @apiPermission  管理员
     * @apiParam  {string}          companyId          公司id
     * @apiParamExample {json} 请求参数
     * get   /v3/api-member/get-deal  新会员入会协议
     *   {
     *      "companyId"   :  1        //公司id
     *   }
     * @apiDescription    会员来源渠道
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/12/21
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/get-deal
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *    "code": 1,                 //参数传入是否合法
     *    "status": "success",       //成功状态
     *    "message": "返回成功",     //成功状态
     *    "data": "新会员入会协议",
     * }
     * @apiSuccessExample {json}返回值详情(失败时)
    {
    "code": 0,                 //参数传入是否合法
    "status": "error",         //错误状态
    "message": "没有数据",
    }
     */
    public function actionGetDeal($companyId)
    {
        $deal = Deal::find()->where(['like',"name","新会员入会协议"])->andWhere(['company_id'=>$companyId])->one();
        if($deal){
            return ['code' =>1, 'status' => 'success','message' =>"返回成功","data"=>$deal->intro];
        }else{
            return ['code' =>0, 'status' => 'error','message' =>"没有数据"];
        }
    }


    /**
     * @api {get}        /v3/api-member/order-class-list   微信公众号已约课程列表
     * @apiVersion      1.0.0
     * @apiName         微信公众号已约课程列表
     * @apiGroup        member
     * @apiPermission  管理员
     * @apiParam  {string}    memberId          会员id
     * @apiParamExample {json} 请求参数
     * get   /v3/api-member/order-class-list   微信公众号已约课程列表
     *   {
     *      "memberId"  :  "12345"     //会员id
     *      "per-page"  :   2          //每页显示数，默认2
     *      "page"      :   2          //第几页
     *   }
     * @apiDescription    微信公众号已约课程列表
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/12/22
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/order-class-list
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *    "code": 1,                 //参数传入是否合法
     *    "status": "success",       //成功状态
     *    "message": "成功",         //成功状态
     *   "data": [
     *       {
     *       "id": "37803",
     *       "type" : "1"             // 1、私课 2、团课
     *       "start": "1515151200",
     *       "end"  :  "1515154800",
     *       "status": "1",           //团课：1、待上课 2、取消 3、上课中 4、下课 5、过期  //私课：1、待审核 2、已取消 3、上课中 4、已下课 6、已爽约
     *       "is_print_receipt": "2", //有无打小票：1、有  2、没有
     *       "name": "蹦床",
     *       "coach_name": "赵娅乐",
     *       "pic": "",
     *       "member_type": "2",      //会员类型：1、普通会员  2、潜在会员
     *       },
     *       {
     *       "id": "37801",
     *       "start": "1513994400",
     *       "status": "2",
     *       "name": "拉丁",
     *       "coach_name": "王惠娴",
     *       "pic": "http://oo0oj2qmr.bkt.clouddn.com/拉丁.jpg?e=1494055663&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:_Z8ASG5BnDwmQAKcIw2jgYlMAv4="
     *       }
     *   ]
     * }
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *"code": 0,                             //参数传入是否合法
     *"status": "error",                     //错误状态
     *"message": "没有数据",
     *}
     */
    public function actionOrderClassList($memberId)
    {
        $model  = Member::findOne($memberId);
        if(!$model){
            return ['code' =>0, 'status' => 'error','message' =>'您还不是会员','data' => []];
        }
        $mobile = $model->mobile;
        $cards  = \backend\models\Member::find()->alias('mb')
                     ->joinWith(['memberCard mc' => function($q){
                         $q->where([
                             'or',
                             ['mc.usage_mode'=> null],
                             ['mc.usage_mode'=> 1]
                         ]);
                     }], false)
                    ->where(['mb.mobile' => $mobile])
                    ->select('mc.id')
                    ->groupBy('mc.id')
                    ->asArray()
                    ->all();
        if(!$cards){
            return ['code' =>0, 'status' => 'error','message' =>'没有数据','data' => []];
        }
        $cardIds = array_column($cards, 'id');
        $query = AboutClassModel::find()
            ->alias('ac')
            ->where(['ac.member_card_id'=>$cardIds])
            ->orderBy('ac.create_at DESC');
        $provider = new ActiveDataProvider(['query' => $query]);
        return $provider;
    }

    /**
     * @api {get}        /v3/api-member/order-class-info   微信公众号已约团课详情
     * @apiVersion      1.0.0
     * @apiName         微信公众号已约团课详情.微信公众号已约团课详情
     * @apiGroup        member
     * @apiPermission  管理员
     * @apiParam  {int}    id          预约课程id
     * @apiParamExample {json} 请求参数
     * get   /v3/api-member/order-class-info   微信公众号已约团课详情
     * {
     *      "aboutId"   :  "37803"        预约课程id
     *      "memberId"  :  "12345"        会员id
     * }
     * @apiDescription    微信公众号已约团课列表
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/12/22
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/order-class-info
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *    "code": 1,                 //参数传入是否合法
     *    "status": "success",       //成功状态
     *    "message": "成功",          //成功状态
     *   "data": [
     *       {
     *       "aboutId": "37803",         //预约课程id
     *       "type" : "1"                // 1、私课 2、团课
     *       "member_id": "93457",       //会员id
     *       "member_type": "2",         //会员类型：1、普通会员  2、潜在会员
     *       "status": "1",              //团课：1、待上课 2、取消 3、上课中 4、下课 5、过期  //私课：1、待审核 2、已取消 3、上课中 4、已下课 6、已爽约
     *       "start": "1514010600",      //上课时间
     *       "end": "1515154800",        //下课时间
     *       "is_print_receipt": "2",    //有无打小票：1、有  2、没有
     *       "course_name": "蹦床",       //课程名字
     *       "course_duration": "60",    //课程时长：分钟
     *       "coach_name": "赵娅乐",      //教练名字
     *       "create_at": "1513943798"   //下单时间
     *       "cancel_time": "1513944654",//取消预约时间
     *       "cancel_limit_time": null   //开课前多少分钟不能取消约课
     *       "entry_count": "0"          //会员进馆记录
     *       }
     *   ]
     * }
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *"code": 0,                             //参数传入是否合法
     *"status": "error",                     //错误状态
     *"message": "没有数据",
     *}
     */
    public function actionOrderClassInfo($aboutId,$memberId)
    {
        $model = new MemberCourseOrder();
        $data  = $model->getOrderClassInfo($aboutId,$memberId);
        if($data){
            return ['code' =>1, 'status' => 'success','message' =>'成功','data' => $data];
        }else{
            return ['code' =>0, 'status' => 'error','message' =>'没有数据','data' => []];
        }
    }

    /**
     * @api {get} /v3/api-member/wechat-card-list   会员卡列表：约课用
     * @apiVersion  1.0.0
     * @apiName        会员卡列表：约课用
     * @apiGroup       memberCardData
     * @apiPermission 管理员
     * @apiParam  {int}          memberId       会员id
     * @apiParam  {int}          venueId        场馆id
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-member/wechat-card-list
     *   {
     *      "memberId" :'100'   //会员id
     *      "venueId"  : 2      //场馆id
     *   }
     * @apiDescription   会员卡列表：约课用
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/6/27
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/wechat-card-list
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     * {
     *  "code": 1,              //成功标识
     *  "status": "success",    //成功标识
     *  "message":"请求成功"    //成功提示信息
     *  "data": [
     *   {
     *      "memberCardId": "3",                //会员卡id
     *      "cardNumber": "041497854875",       //会员卡号
     *      "cardName": "时间卡"                //会员卡名称
     *      "cardStatus":1                      //  1正常 2异常 3冻结 4未激活
     *      "leaveRecordStatus":0               // 0表示不在请假中 1表示在请假中
     *   },
     *   {
     *      "memberCardId": "9",                //会员卡id
     *      "cardNumber": "051497940599",       //会员卡号
     *      "cardName": "时间卡"                //会员卡名称
     *      "cardStatus":1                      //  1正常 2异常 3冻结 4未激活
     *      "leaveRecordStatus":0               // 0表示不在请假中 1表示在请假中
     *   }
     * ]
     *  "cardStatus":3                         // 1：有正常的会员卡 2：没有会员卡 3 卡有异常
     *  "cardMessage": "您的卡有异常或未激活"  // 会员办卡信息
     * }
     * @apiSuccessExample {json}返回值详情(失败时)
     * {
     *  "code": 0,                   //失败标识
     *  "message":"请求失败"         //成功提示信息
     *  "data":"该会员没有会员卡"   //具体报错信息
     *  "cardStatus":2                          // 1：有正常的会员卡 2：没有会员卡 3 卡有异常
     *  "cardMessage": "您还没有办理会员卡"      // 会员办卡信息
     * }
     */
    public function actionWechatCardList($memberId)
    {
        $model = new MemberCourseOrder();
        $data = $model->getCardList($memberId);
        if ($data) {
            return ['code' => 1, 'status' => 'success', 'message' => '请求成功', 'data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据','data' => []];
        }
    }
    /**
     * @api {get} /v3/api-member/tencent-card   微信公众号-扫码进馆-获取会员卡 (预约团课)
     * @apiVersion  1.0.0
     * @apiName        微信公众号-扫码进馆-获取会员卡 (预约团课)
     * @apiGroup       member
     * @apiPermission 管理员
     * @apiParam  {int}          mobile       会员手机号   venueId  场馆ID
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-member/tencent-card
     *   {
     *      "mobile  " :'15093002144'          //手机号
     *      'venueId'  : 2423341
     *      'vid'     : 'code' | 'about'       //  1.code 进出门禁     2.about  团课约课
     *   }
     * @apiDescription   微信公众号-扫码进馆-获取会员卡 (预约团课)
     * <br/>
     * <span><strong>作    者：</strong></span>杨慧磊<br/>
     * <span><strong>邮    箱：</strong></span>yanghuilei@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/3/17
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/tencent-card
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *  vid = code
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "请求成功"
     * 'data' : {id: 1233, cardNumber : 12134t5636}
     *}
     *
     * vid = about
     * {
     *  "code": 1,
     *  "status": "success",
     *  "message": "请求成功"
     * 'data' : [{id: 1233, cardNumber : 12134t5636}]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     * vid =code  & vid = about
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "没有数据"
     *   'data' : []
     *}
     */
    public function actionTencentCard()
    {
        $mobile   = \Yii::$app->request->get('mobile');
        $venueId  = \Yii::$app->request->get('venueId');
        $vid      = \Yii::$app->request->get('vid');
        $model = new MemberCourseOrder();
        $data = $model->getEntryVenueMemberCard($mobile, $venueId, $vid);
        if ($data) {
            return ['code' => 1, 'status' => 'success', 'message' => '请求成功', 'data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据','data' => []];
        }
    }
    /**
     * @api {get} /v3/api-member/allow-cards   微信公众号-我的-会员卡列表
     * @apiVersion  1.0.0
     * @apiName        微信公众号-我的-会员卡列表
     * @apiGroup       member
     * @apiPermission 管理员
     * @apiParam  {int}          mobile       会员手机号
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-member/allow-cards
     *   {
     *      "mobile  " :'15093002144'          //手机号
     *   }
     * @apiDescription   微信公众号-我的-会员卡列表
     * <br/>
     * <span><strong>作    者：</strong></span>杨慧磊<br/>
     * <span><strong>邮    箱：</strong></span>yanghuilei@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/3/17
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/allow-cards
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "请求成功"
     *  'data'   : [{
     *      id : 卡id
     *      card_name
     *      venueName
     *      cardNumber
     *      cardStatus   :  2 异常  3. 冻结
     *      create_at
     *      invalid_time
     *      student_leave_limit
     *      leave_days_times
     *      duration
     *      leaveRecordStatus   null 未请假   !null  请假中
     *     }],
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "没有数据"
     *  "data" : []
     *}
     */
    public function actionAllowCards()
    {
        $mobile   = \Yii::$app->request->get('mobile');
        $model = new MemberCourseOrder();
        $data = $model->getMyActiveMemberCards($mobile);
        if ($data) {
            return ['code' => 1, 'status' => 'success', 'message' => '请求成功', 'data' => $data];
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '没有数据','data' => []];
        }
    }

    /**
     * @api {get} /v3/api-member/order-charge-class   预约私教课
     * @apiVersion  1.0.0
     * @apiName        预约私教课
     * @apiGroup       member
     * @apiPermission 管理员
     * @apiParam  {int}          memberId       会员id
     * @apiParam  {string}       time           约课时间
     * @apiParam  {int}          chargeId       私教课id
     * @apiParam  {int}          coachId        教练id
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-member/order-charge-class
     *   {
     *      "memberId" :'100'          //会员id
     *      "time"     : 1516673532    //预约时间：时间戳
     *      "chargeId" : 41            //私教课程id
     *      "coachId"  : 8             //教练id
     *   }
     * @apiDescription   微信公众号会员卡列表
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/6/27
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/order-charge-class
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "约课成功"
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "教练这个时间已经被预约了"
     *}
     */
    public function actionOrderChargeClass()
    {
        $param  = \Yii::$app->request->post();
        $time   = strtotime($param['time']);
        $charge = \backend\models\MemberCourseOrder::findOne(['member_id'=>$param['memberId'],'product_id'=>$param['chargeId']]);
        if($charge){
            if($charge->overage_section > 0){
                $classId    =  MemberCourseOrderDetails::findOne(['course_order_id'=>$charge->id])->id;
                $aboutCount =  AboutClass::find()->where(['class_id'=>$classId])->andWhere(['<>','status','2'])->count();
                if($charge->course_amount > $aboutCount){
                    if($time > time()){
                        $aboutClass = AboutClass::find()->where(['coach_id'=>$param['coachId']])->andWhere(['and',['<=','start',$time],['>=','end',$time]])->one();
                        if(!$aboutClass){
                            $checkTime = AboutClass::find()->where(['member_id'=>$param['memberId']])->andWhere(['and',['<=','start',$time],['>=','end',$time]])->one();
                            if(!$checkTime){
                                $model = new MemberCourseOrder();
                                $data  = $model->orderChargeClass($param);
                                if($data){
                                    return ['code' => 1, 'status' => 'success', 'message' => '约课成功'];
                                }else{
                                    return ['code' => 0, 'status' => 'error', 'message' => '数据错误，请联系技术支持'];
                                }
                            }else{
                                return ['code' => 0, 'status' => 'error', 'message' => '这个时间您已经约过课了'];
                            }
                        }else{
                            return ['code' => 0, 'status' => 'error', 'message' => '教练这个时间已经被预约了'];
                        }
                    }else{
                        return ['code' => 0, 'status' => 'error', 'message' => '您预约的时间有误，请核对后再约'];
                    }
                }else{
                    return ['code' => 0, 'status' => 'error', 'message' => '您购买的私教课程已经约完，如需约课，请您再次购买'];
                }
            }else{
                return ['code' => 0, 'status' => 'error', 'message' => '私教课已经上完，请您再次购买'];
            }
        }else{
            return ['code' => 0, 'status' => 'error', 'message' => '您还没有购买这节私教课'];
        }
    }

    /**
     * @api {get} /v3/api-member/get-my-profile   个人信息
     * @apiVersion  1.0.0
     * @apiName        个人信息.个人信息
     * @apiGroup       member
     * @apiPermission 管理员
     * @apiParam  {int}          memberId       会员id
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-member/get-my-profile
     *   {
     *      "memberId" :'100'          //会员id
     *   }
     * @apiDescription   个人信息
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/6/27
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/get-my-profile
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "成功"
     *  "data": {
    *       "pic": "http://oo0oj2qmr.bkt.clouddn.com/6538301515897844.jpg?e=1515901444&token=su_7pmwUM2iX2wn_2F0YSjOHqMWffbi6svEysW3S:QEem-paOqJy_h9wmA-72AvqMhNY=",
    *       "nickname": null,
    *       "id": "94193"
     *    }
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "没有数据"
     *}
     */
    public function actionGetMyProfile($memberId)
    {
        $model = new Member();
        $data  = $model->getMyProfile($memberId);
        if($data){
            return ['code' =>1, 'status' => 'success','message' =>"成功","data"=>$data];
        }else{
            return ['code' =>0, 'status' => 'error','message' =>"没有数据","data"=>[]];
        }
    }

    /**
     * @api {post} /v3/api-member/update-my-profile   修改个人信息
     * @apiVersion  1.0.0
     * @apiName        修改个人信息.修改个人信息
     * @apiGroup       member
     * @apiPermission 管理员
     * @apiParam  {int}          memberId       会员id
     * @apiParam  {string}       nickname       昵称
     * @apiParamExample {json} 请求参数
     *   POST /v3/api-member/update-my-profile
     *   {
     *      "memberId" :   1         //会员id
     *      "nickname" : '小华'       //昵称
     *   }
     * @apiDescription   修改个人信息
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/6/27
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/update-my-profile
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "修改成功"
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "修改信息失败"
     *}
     */
    public function actionUpdateMyProfile()
    {
        $param = \Yii::$app->request->post();
        $model = new Member();
        $data  = $model->updateMyProfile($param);
        if($data){
            return ['code' =>1, 'status' => 'success','message' =>"修改成功"];
        }else{
            return ['code' =>0, 'status' => 'error','message' =>"修改信息失败"];
        }
    }

    /**
     * @api {get} /v3/api-member/get-my-cards   我的会员卡
     * @apiVersion  1.0.0
     * @apiName        我的会员卡.我的会员卡
     * @apiGroup       member
     * @apiPermission 管理员
     * @apiParam  {int}          memberId       会员id
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-member/get-my-cards
     *   {
     *      "memberId" :'100'    //会员id
     *      "venueId"  :'2'      //场馆id
     *   }
     * @apiDescription   个人信息
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/6/27
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/get-my-cards
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "成功",
     *  "data": [
     *    {
     *       "card_name": "12MMD",            //卡名称
     *       "card_number": "09600155",       //卡编号
     *       "status": "1",                   //卡状态：1、正常  2、异常  3、冻结  4、未激活
     *       "create_at": "2017-12-17",       //办卡时间
     *       "invalid_time": "2018-01-31",    //时效时间
     *       "duration": {
     *              "day": 30                 //有效期
     *       }
     *    }
     *  ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "没有数据"
     *}
     */
    public function actionGetMyCards($memberId)
    {
        $model = new Member();
        $data  = $model->getMyCards($memberId);
        if($data){
            return ['code' => 1, 'status' => 'success', 'message' => "成功", 'data' => $data];
        }else{
            return ['code' => 0, 'status' => 'error', 'message' => "没有数据", 'data' => []];
        }
    }

    /**
     * @api {get} /v3/api-member/get-my-venues   我拥有的场馆
     * @apiVersion  1.0.0
     * @apiName        我拥有的场馆.我拥有的场馆
     * @apiGroup       member
     * @apiPermission 管理员
     * @apiParam  {int}          mobile       手机
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-member/get-my-venues
     *   {
     *      "mobile" :'1369682389'           //手机
     *       "companyId" : 1                //我爱运动
     *   }
     * @apiDescription   我拥有的场馆
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/6/27
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/get-my-venues
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "成功",
     *  "data": [
     *     {
     *        "id": "2",
     *        "name": "大上海瑜伽健身馆"
     *     }
     *  ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "没有数据"
     *}
     */
    public function actionGetMyVenues()
    {
        $mobile    = \Yii::$app->request->get('mobile');
        $companyId = \Yii::$app->request->get('companyId');
        $model = new Member();
        $data  = $model->getMyVenues($mobile, $companyId);
        if($data){
            return ['code' => 1, 'status' => 'success', 'message' => "成功", 'data' => $data];
        }else{
            return ['code' => 0, 'status' => 'error', 'message' => "没有数据", 'data' => []];
        }
    }

    /**
     * @api {get} /v3/api-member/get-other-venues   我不拥有的场馆
     * @apiVersion  1.0.0
     * @apiName        我不拥有的场馆.我不拥有的场馆
     * @apiGroup       member
     * @apiPermission 管理员
     * @apiParam  {int}          mobile       手机
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-member/get-other-venues
     *   {
     *      "mobile" :'1369682389'           //手机
     *       "companyId"  : 1                   // 我爱运动
     *   }
     * @apiDescription   我不拥有的场馆
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/24
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/get-other-venues
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "成功",
     *  "data": [
     *     {
     *        "id": "2",
     *        "name": "大上海瑜伽健身馆"
     *        "pic": ""
     *     }
     *  ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "没有数据"
     *}
     */
    public function actionGetOtherVenues()
    {
        $mobile    = \Yii::$app->request->get('mobile');
        $companyId = \Yii::$app->request->get('companyId');
        $model = new Member();
        $data  = $model->getOtherVenues($mobile, $companyId);
        if($data){
            return ['code' => 1, 'status' => 'success', 'message' => "成功", 'data' => $data];
        }else{
            return ['code' => 0, 'status' => 'error', 'message' => "没有数据"];
        }
    }

    /**
     * @api {post} /v3/api-member/confirm-the-info   确认信息
     * @apiVersion  1.0.0
     * @apiName        确认信息.确认信息
     * @apiGroup       member
     * @apiPermission 管理员
     * @apiParam  {string}   mobile
     * @apiParam  {int}      companyId
     * @apiParam  {int}      venueId
     * @apiParam  {int}      sex
     * @apiParam  {string}   nickname
     * @apiParam  {string}   source
     * @apiParamExample {json} 请求参数
     *   POST /v3/api-member/confirm-the-info
     *   {
     *      "mobile"      :'1369682389'   //手机
     *      "companyId"   : 1             //公司id
     *      "venueId"     : 2             //场馆id
     *      "lastVenueId" : 12            //切换前场馆id
     *      "sex"         : 1             //性别：男 1 ，女  2
     *      "name"        : '小明'         //昵称
     *      "idCard"      : '123456'      //身份证
     *      "openid"      : 'zxcasdjk'    //openid
     *      "source"      : "微信小程序"   //小程序注册 : "微信小程序" 、公众号注册 : "微信公众号"
     *   }
     * @apiDescription   确认信息
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/24
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/confirm-the-info
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "添加成功",
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "添加失败"
     *}
     */
    public function actionConfirmTheInfo()
    {
        $param = \Yii::$app->request->post();
        $model = new Member();
        $data  = $model->confirmTheInfo($param);
        if($data){
            return ['code' => 1, 'status' => 'success', 'message' => "添加成功",'data'=>$data];
        }else{
            return ['code' => 0, 'status' => 'error', 'message' => "添加失败"];
        }
    }

    /**
     * @api {post} /v3/api-member/switch-the-venue   切换场馆
     * @apiVersion  1.0.0
     * @apiName        切换场馆.切换场馆
     * @apiGroup       member
     * @apiPermission 管理员
     * @apiParam  {string}   mobile
     * @apiParam  {int}      venueId
     * @apiParam  {string}   openid
     * @apiParamExample {json} 请求参数
     *   POST /v3/api-member/switch-the-venue
     *   {
     *      "mobile"    :'1369682389'   //手机
     *      "venueId"   : 2             //场馆id
     *      "openid"    :'123456'       //openid
     *   }
     * @apiDescription   确认信息
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/24
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/switch-the-venue
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "切换成功",
     *   "data": [
     *       {
     *
     *       }
     *   ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "切换失败"
     *}
     */
    public function actionSwitchTheVenue()
    {
        $param = \Yii::$app->request->post();
        $model = new Member();
        $data  = $model->switchTheVenue($param);
        if($data){
            return ['code' => 1, 'status' => 'success', 'message' => "切换成功", 'data' => $data];
        }else{
            return ['code' => 0, 'status' => 'error', 'message' => "切换失败"];
        }
    }

    /**
     * @api {get} /v3/api-member/get-access-venues   查看能否通店场馆
     * @apiVersion  1.0.0
     * @apiName        查看能否通店场馆.查看能否通店场馆
     * @apiGroup       member
     * @apiPermission 管理员
     * @apiParam  {string}   memberId
     * @apiParam  {string}   companyId
     * @apiParam  {string}   type
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-member/get-access-venues
     *   {
     *      "memberId"   :'1'        //会员id
     *      "companyId"  : 2         //公司id
     *      "type"       :'yes'      //查看类型：yes 可以通店的场馆 ；no 不可以通店的场馆
     *   }
     * @apiDescription   查看能否通店场馆
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/24
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/get-access-venues
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "切换成功",
     *   "data": [
     *      {
     *        "id": "2",
     *        "name": "大上海瑜伽健身馆"
     *      },
     *      {
     *        "id": "10",
     *        "name": "大学路舞蹈健身馆"
     *      }
     *   ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "没有数据",
     *  "data" : ''
     *}
     */
    public function actionGetAccessVenues($memberId,$companyId,$type)
    {
        $model = new Member();
        $data  = $model->getAccessVenues($memberId,$companyId,$type);
        if($data){
            return ['code' => 1, 'status' => 'success', 'message' => "成功", 'data' => $data];
        }else{
            return ['code' => 0, 'status' => 'error', 'message' => "没有数据", 'data' => []];
        }
    }

    /**
     * @api {get} /v3/api-member/get-access-cards   查看可以通店的会员卡
     * @apiVersion  1.0.0
     * @apiName        查看可以通店的会员卡.查看可以通店的会员卡
     * @apiGroup       member
     * @apiPermission 管理员
     * @apiParam  {string}   memberId
     * @apiParam  {string}   venueId
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-member/get-access-cards
     *   {
     *      "memberId" :'1'        //会员id
     *      "venueId"  : 2         //场馆id
     *   }
     * @apiDescription   查看可以通店的会员卡
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/24
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/get-access-cards
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "切换成功",
     *  "data": [
     *    {
     *       "memberCardId": "72064",
     *       "cardNumber": "051516868888",
     *       "cardName": "Y12MMD",
     *       "cardStatus": "4",
     *       "active_time": "未激活",
     *       "invalid_time": "2018/02/24"
     *    },
     *    {
     *       "memberCardId": "72063",
     *       "cardNumber": "091516867451",
     *       "cardName": "BC60MD",
     *       "cardStatus": "4",
     *       "active_time": "未激活",
     *       "invalid_time": "2023/01/24"
     *    }
     *  ]
     * }
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "没有数据",
     *  "data" : ''
     *}
     */
    public function actionGetAccessCards($memberId,$venueId)
    {
        $model = new Member();
        $data  = $model->getAccessCards($memberId,$venueId);
        if($data){
            return ['code' => 1, 'status' => 'success', 'message' => "成功", 'data' => $data];
        }else{
            return ['code' => 0, 'status' => 'error', 'message' => "没有数据", 'data' => []];
        }
    }

    /**
     * @api {post} /v3/api-member/check-the-course   判断是否可以约私课
     * @apiVersion  1.0.0
     * @apiName        判断是否可以约私课.判断是否可以约私课
     * @apiGroup       member
     * @apiPermission 管理员
     * @apiParam  {int}   memberId
     * @apiParam  {int}   chargeId
     * @apiParamExample {json} 请求参数
     *   POST /v3/api-member/check-the-course
     *   {
     *      "memberId" :  1        //会员id
     *      "chargeId" :  2        //私教id
     *   }
     * @apiDescription   查看能否通店场馆
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/1/24
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/check-the-course
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,             //成功状态码
     *  "status": "success",   //可以约
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,            //错误状态码
     *  "status": "error",    //不可以约
     *}
     */
    public function actionCheckTheCourse()
    {
        $param  = \Yii::$app->request->post();
        $charge = \backend\models\MemberCourseOrder::findOne(['member_id'=>$param['memberId'],'product_id'=>$param['chargeId']]);
        if($charge){
            if($charge->overage_section > 0){
                $classId    =  MemberCourseOrderDetails::findOne(['course_order_id'=>$charge->id])->id;
                $aboutCount =  AboutClass::find()->where(['class_id'=>$classId])->andWhere(['<>','status','2'])->count();
                if($charge->course_amount > $aboutCount){
                    return ['code' => 1, 'status' => 'success'];
                }else{
                    return ['code' => 0, 'status' => 'error'];
                }
            }else{
                return ['code' => 0, 'status' => 'error'];
            }
        }else{
            return ['code' => 0, 'status' => 'error'];
        }
    }

    /**
     * @api {post} /v3/api-member/take-day-off   会员请假
     * @apiVersion 1.0.0
     * @apiName   会员请假.会员请假
     * @apiGroup  member
     * @apiParam  {int}    leavePersonId    请假人id（会员ID）
     * @apiParam  {string} leaveReason      请假原因（原因）
     * @apiParam  {string} leaveStartTime   请假开始时间 (1517356800)
     * @apiParam  {string} leaveEndTime     请假结束时间 (1519171200)
     * @apiParam  {int}   leaveTotalDays   *请假离开总天数
     * @apiParam  {int}   leaveLimitStatus *请假限制识别码
     * @apiParam  {int}   leaveArrayIndex  *请假识别下标
     * @apiParam  {int}   memberCardId      会员卡ID
     * @apiParamExample {json} Request Example
     *   POST /check-card/leave-record
     *   {
     *       "leavePersonId"    : 2,            // 请假会员ID
     *       "leaveReason"      : "你猜",       // 请假原因
     *       "leaveStartTime"   : '1517356800', // 请假开始时间
     *       "leaveEndTime"     : '1519171200', // 请假结束时间
     *       "leaveTotalDays"   : 30,           // 请假总天数
     *       "leaveLimitStatus" : 1,            // 请假限制状态：
     *       "leaveArrayIndex"  : 1,            // 请假发送数组下标：1、总天数 2、次数 3 没有请假限制
     *       "memberCardId"     : 3,            // 会员卡id
     *       "leaveType"        : 3,            // 请假类型：1、正常请假  2、特殊请假  3、学生请假
     *       "requestSource"    :'wechat',      // 请求来源：写死
     *   }
     * @apiDescription    会员请假表单验证
     * <span><strong>作    者：</strong></span>焦冰洋<br>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/27
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/take-day-off
     * @apiSuccess (返回值) {string} status 请假保存状态
     * @apiSuccess (返回值) {string} data   返回请假状态数据
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','status'=>'success','data':请假保存数据状态}
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','status'=>'error','data':请假保存数据状态}
     */
    public function actionTakeDayOff()
    {
        $post = \Yii::$app->request->post();
        $model = new LeaveRecordForm();
        if($model->load($post,'') && $model->validate()){
            $save = $model->leaveRecord($post['requestSource']);
            if($save === true){
                return ['code' => 1, 'status'=>'success','message'=>'保存成功'];
            }else{
                return ['code' => 0, 'status'=>'error','message'=>$save];
            }
        }else{
            return ['code' => 0, 'status'=>'error','message'=>$model->errors];
        }
    }

    /**
     * @api {get} /v3/api-member/day-off-cards   请假会员卡
     * @apiVersion  1.0.0
     * @apiName        请假会员卡.请假会员卡
     * @apiGroup       member
     * @apiPermission  管理员
     * @apiParam  {int}          memberId       会员id
     * @apiParam  {int}          venueId        场馆id
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-member/day-off-cards  请假会员卡
     *   {
     *      "memberId" : 100         //会员id
     *      "venueId"  : 2           //场馆id
     *   }
     * @apiDescription   个人信息
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/6/27
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/day-off-cards
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "成功",
     *  "data": [
     *   {
     *      "id": "71915",
     *      "card_name": "FT12MD",
     *      "card_number": "0700009500",
     *      "status": "4",
     *      "create_at": "2018-01-14",
     *      "invalid_time": "2019-01-14",
     *      "leave_total_days": null,       //请假总天数
     *      "leave_least_days": null,       //每次最少请假天数
     *      "leave_days_times": [
     *              [
     *                 "30",                //每次最多请假天数
     *                 "2"                  //请假次数
     *              ]
     *      ],
     *      "student_leave_limit": [        //学生请假
     *             [
     *                 "30",                //暑假天数
     *                 "1"                  //暑假次数
     *             ],
     *             [
     *                 "40",                //寒假天数
     *                 "1"                  //寒假次数
     *             ]
     *      ],
     *    }
     *  ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "没有数据"
     *}
     */
    public function actionDayOffCards($memberId,$venueId)
    {
        $model = new Member();
        $data  = $model->dayOffCards($memberId,$venueId);
        if($data){
            return ['code' => 1, 'status' => 'success', 'message' => "成功", 'data' => $data];
        }else{
            return ['code' => 0, 'status' => 'error', 'message' => "没有数据", 'data' => []];
        }
    }

    /**
     * @api {get} /v3/api-member/day-off-list   请假记录
     * @apiVersion  1.0.0
     * @apiName        请假记录.请假记录
     * @apiGroup       member
     * @apiPermission  管理员
     * @apiParam  {int}    memberId       会员id
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-member/day-off-list  请假记录
     *   {
     *      "memberId" : 100         //会员id
     *   }
     * @apiDescription   我的柜子
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/6/27
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/day-off-list
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "成功",
     *  "data": [
     *  {
     *    "id": "2697",
     *    "create_at": "1517558781",        //提交时间
     *  @  "status": "2",                    //1、假期中 2、已销假 3、特殊请假待处理
     *    "member_card_id": "72882",
     *  @  "leave_property": "2",            //1、特殊请假  2、正常请假  3、学生请假
     *    "leave_type": "1",                //1、正常请假  2、特殊请假  3、其他  4、暑假  5、寒假
     *    "reject_note": null,              //拒绝理由
     *    "leave_length": "27",             //请假天数
     *    "leave_start_time": "2018-02-02", //开始日期
     *    "leave_end_time": "2018-02-28",   //结束日期
     *    "terminate_time": "2018-02-02",   //销假时间
     *  @  "type": "2",                      //1、待处理 2、已同意 3、已拒绝
     *    "card_name": "请假测试卡1"          //卡名字
     *  }
     *  ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "没有数据"
     *}
     */
    public function actionDayOffList($memberId)
    {
        $model = new Member();
        $data  = $model->dayOffList($memberId);
        if($data){
            return ['code' => 1, 'status' => 'success', 'message' => "成功", 'data' => $data];
        }else{
            return ['code' => 0, 'status' => 'error', 'message' => "没有数据", 'data' => []];
        }
    }

    /**
     * @api {get} /v3/api-member/get-my-cabinet   我的柜子
     * @apiVersion  1.0.0
     * @apiName        我的柜子.我的柜子
     * @apiGroup       member
     * @apiPermission  管理员
     * @apiParam  {int}          $mobile       会员手机号
     * @apiParamExample {json} 请求参数
     *   GET /v3/api-member/get-my-cabinet  我的柜子
     *   {
     *      "mobile" : 15096464646         //会员手机号
     *   }
     * @apiDescription   我的柜子
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/6/27
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/get-my-cabinet
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code": 1,
     *  "status": "success",
     *  "message": "成功",
     *  "data": [
     *  {
     *      "id": "666",                     
     *      "member_id": "95328",
     *      "price": "150.00",               //费用
     *      "start_rent": "2018-02-02",      //租柜日期
     *      "end_rent": "2018-03-02",        //到期日期
     *      "back_rent": null,
     *      "status": "1",
     *      "creater_id": "13",
     *      "create_at": "1517559430",
     *      "update_at": null,
     *      "cabinet_id": "3107",
     *      "change_cabinet_remark": null,
     *      "member_card_id": null,
     *      "rent_type": "新租",
     *      "type_name": "男士大柜",           //柜子区域
     *      "deposit": "50.00",              //押金
     *      "give_month": "0",               //赠送月数
     *      "rent_month": 1                  //租柜月数
     *      "cabinet_type": "2",             //1、临时  2、正式
     *      "cabinet_number": "男浴大柜1001"  //柜号
     *  }
     *  ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code": 0,
     *  "status": "error",
     *  "message": "没有数据"
     *}
     */
    public function actionGetMyCabinet($mobile)
    {
        $model = new Member();
        $data  = $model->getMyCabinet($mobile);
        if($data){
            return ['code' => 1, 'status' => 'success', 'message' => "成功", 'data' => $data];
        }else{
            return ['code' => 0, 'status' => 'error', 'message' => "没有数据", 'data' => []];
        }
    }

    /**
     * @api {get} /v3/api-member/message-contrast  闸机验卡
     * @apiVersion      1.0.0
     * @apiName         闸机验卡
     * @apiGroup        scanCode
     * @apiPermission  管理员
     * @apiParam  {int}   memberId  会员id
     * @apiParamExample {json} 请求参数
     *   get  /v3/api-member/message-contrast  闸机验卡
     *   {
     *      "memberId"      : 12313     //会员id
     *   }
     * @apiDescription         //会员id
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/2/25
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/message-contrast
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     * {
     *  "code"   : 1,
     *  "status" : "success",    //成功标识
     *  "message":"刷卡成功"      //成功提示信息
     *  "data"   : true          // 录入成功的信息
     * }
     * @apiSuccessExample {json}返回值详情(失败时)
     * {
     *  "code"   : 0,
     *  "status" : "error",      //失败标识
     *  "message":"刷卡失败"      //失败返回信息
     *  "data"   : "刷卡失败信息"
     * }
     */
    public function actionMessageContrast($memberId=null)
    {
        $model  = new ScanCode();
        $result = $model->searchMember($memberId);
        if($result === true){
            return ['code' => 1, 'status' => 'success', 'message' =>"开机成功","data"=>$result];
        }elseif ($result=="noMessageCode"){
            return ['code' => 0, 'status' => 'error', 'message' =>"请先生成二维码","data"=>$result];
        }else{
            return ['code' => 0, 'status' => 'error', 'message' =>"您的二维码失效","data"=>$result];
        }
    }

    /**
     * @api {get} /v3/api-member/save-scan-record   保存扫码进馆记录
     * @apiVersion  1.0.0
     * @apiName        保存扫码进馆记录.保存扫码进馆记录
     * @apiGroup       member
     * @apiPermission  管理员
     * @apiParam  {string}    "data"   : 12456@15555127518@412644    //前台发送的二维码信息(会员id@时间戳@会员卡id)
     * @apiParamExample {json} 请求参数
     * GET /v3/api-member/save-scan-record   保存扫码进馆记录
     * {
     *    "data"   : 12456@15555127518@412644      //前台发送的二维码信息(会员id@时间戳@会员卡id)
     * }
     * @apiDescription   保存扫码进馆记录
     * <br/>
     * <span><strong>作    者：</strong></span>焦冰洋<br/>
     * <span><strong>邮    箱：</strong></span>jiaobingyang@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/2/25
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/save-scan-record
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code"   : 1,
     *  "status" : "success",
     *  "message": "保存成功",
     *  "data"   : [
     *  ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code"   : 0,
     *  "status" : "error",
     *  "message": "保存失败"
     *  "data"   : []
     *}
     */
    public function actionSaveScanRecord()
    {
        $param = \Yii::$app->request->get('data');
        $model = new ScanCode();
        $data  = $model->saveScanRecord($param);
        if($data){
            return ['code' => 1, 'status' => 'success', 'message' => "保存成功", 'data' => $data];
        }else{
            return ['code' => 0, 'status' => 'error', 'message' => "保存失败", 'data' => []];
        }
    }
    /**
     * @api {post} /v3/api-member/upload-pic   上传个人图像
     * @apiVersion  1.0.0
     * @apiName        会员中心上传个人图像
     * @apiGroup       member
     * @apiPermission  管理员
     * @apiParam  {string}    "file"   : {info : file}
     * @apiParamExample {json} 请求参数
     * post /v3/api-member/upload-pic  上传个人图像
     * {
     *    "file"   : {info : file}
     * }
     * @apiDescription   上传个人图像
     * <br/>
     * <span><strong>作    者：</strong></span>杨慧磊<br/>
     * <span><strong>邮    箱：</strong></span>yanghuilei@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/3/9
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/upload-pic
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code"   : 1,
     *  "status" : "success",
     *  "message": "保存成功",
     *  "data"   : [
     *  ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code"   : 0,
     *  "status" : "error",
     *  "message": "保存失败"
     *  "data"   : []
     *}
     */
    public function actionUploadPic()
    {
        $model = new UploadForm();
        if(!\Yii::$app->request->isPost){
            return $this->error('传输方法不正确');
        }
        $model->setScenario('file');
        $model->load(\Yii::$app->getRequest()->getBodyParams(), '');
        if(isset($_FILES['file'])) $model->file = UploadedFile::getInstanceByName('file');
        $result = $model->uploadPic();
        if($result){
            return $this->success($result);
        }
        $errors = $this->toString($model->errors);
        return $this->error($errors);
    }

    /**
     * @api {post} /v3/api-member/upload-sign   上传个人签名
     * @apiVersion  1.0.0
     * @apiName        会员中心上传个人签名
     * @apiGroup       member
     * @apiPermission  管理员
     * @apiParam  {string}    {"file"   :  data, 'type' : 'png'}  //base64编码字符串
     * @apiParamExample {json} 请求参数
     * post /v3/api-member/upload-sign   上传个人签名
     * {
     *    "file"   :  data,
     *    'type' : 'png'
     * }
     * @apiDescription   上传个人图像
     * <br/>
     * <span><strong>作    者：</strong></span>杨慧磊<br/>
     * <span><strong>邮    箱：</strong></span>yanghuilei@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/3/9
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/upload-sign
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code"   : 1,
     *  "status" : "success",
     *  "message": "保存成功",
     *  "data"   : [
     *  ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code"   : 0,
     *  "status" : "error",
     *  "message": "保存失败"
     *  "data"   : []
     *}
     */

    public function actionUploadSign()
    {
        $model = new UploadForm();
        if(!\Yii::$app->request->isPost){
            return $this->error('传输方法不对');
        }
        $model->setScenario('base64');
        if($model->load(\Yii::$app->request->bodyParams, '') && $model->validate()){
           $url = $model->uploadBase64();
            return $url ? $this->success($url) : $this->error('上传失败');
        }
        return $this->error($model->errors);
    }

    /**
     * @api {get} /v3/api-member/member-info   获取会员信息
     * @apiVersion  1.0.0
     * @apiName        会员信息
     * @apiGroup       member
     * @apiPermission  管理员
     * @apiParam  {string}    {memberId : 1232}
     * @apiParamExample {json} 请求参数
     * get /v3/api-member/member-info   获取会员信息
     * {
     *     memberId : 1232
     * }
     * @apiDescription   获取会员信息
     * <br/>
     * <span><strong>作    者：</strong></span>杨慧磊<br/>
     * <span><strong>邮    箱：</strong></span>yanghuilei@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/3/14
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/member-info
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code"   : 1,
     *  "status" : "success",
     *  "message": "保存成功",
     *  "data"   : [
     *  ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code"   : 0,
     *  "status" : "error",
     *  "message": "保存失败"
     *  "data"   : []
     *}
     */
    public function actionMemberInfo($memberId)
    {
        $model  = new Member();
        $result = $model->getPersonalMemberInfo($memberId);
        if(!$result){
            return $this->error('会员不存在');
        }
        return $this->success($result, '请求成功');
    }

    /**
     * @api {post} /v3/api-member/perfect-info   完善会员信息
     * @apiVersion  1.0.0
     * @apiName        完善会员信息
     * @apiGroup       member
     * @apiPermission  管理员
     * @apiParam  {string}
     * {
     *     memberId  :  5456464
     *     name   :  '李四'
     *     sex   :  1
     *    idCard :  123354564654654
     * }
     * @apiParamExample {json} 请求参数
     * post /v3/api-member/perfect-info   完善会员信息
     * {
     *     memberId  :  5456464
     *     name   :  '李四'
     *     sex   :  1
     *    idCard :  123354564654654
     * }
     * @apiDescription   获取会员信息
     * <br/>
     * <span><strong>作    者：</strong></span>杨慧磊<br/>
     * <span><strong>邮    箱：</strong></span>yanghuilei@itsprts.club
     * <span><strong>创建时间：</strong></span>2018/3/14
     * @apiSampleRequest  http://qa.aixingfu.net/v3/api-member/perfect-info
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情(成功时)
     *{
     *  "code"   : 1,
     *  "status" : "success",
     *  "message": "保存成功",
     *  "data"   : [
     *  ]
     *}
     * @apiSuccessExample {json}返回值详情(失败时)
     *{
     *  "code"   : 0,
     *  "status" : "error",
     *  "message": "保存失败"
     *  "data"   : []
     *}
     */
    public function actionPerfectInfo()
    {
        $post  = \Yii::$app->request->post();
        $model = new Member();
        $bool  = $model->completeMemberInfo($post);
        if($bool){
            return $this->success([], '保存成功');
        }
        return $this->error('保存失败', $model->errors);
    }
}