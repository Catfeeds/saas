<?php

namespace backend\controllers;

use common\models\Func;
use yii\web\Controller;
use backend\models\Member;
use backend\models\MemberShipLogic;

class MemberShipController extends \yii\web\Controller
{
     public  $enableCsrfValidation = false;
//    主页
    public $layout='buyCard';
    public function actionIndex()
    {
        return $this->render('index');
    }
//    注册
    public function actionRegister()
    {
        return $this->render('register');
    }
//    登录
    public function actionLogin()
    {
        return $this->render('login');
    }
//    选择卡种
    public function actionCard()
    {
        return $this->render('card');
    }
//      卡详情
    public function actionDetails()
    {
        return $this->render('details');
    }
//      支付宝
    public function actionBbbb()
    {
        return $this->render('bbbb');
    }

    public $mobile;   // 会员电话
    public $code;     // 会员验证码
    public $sex;      // 会员性别
    public $IDNumber;  // 会员身份证号
    public $memberName; // 会员姓名
    public $password;  // 用户密码
    /**
     * @api {post} /member-ship/member-register  会员注册
     * @apiVersion  1.0.0
     * @apiName        会员注册
     * @apiGroup       register
     * @apiPermission 管理员
     * @apiParam  {string}          mobile      手机号
     * @apiParam  {string}          code        验证码
     * @apiParam  {int}             sex         性别
     * @apiParam  {string}          IDNumber    身份证号
     * @apiParam  {string}         memberName  会员姓名
     * @apiParam  {string}          password       用户密码
     * @apiParam  {string}          _csrf_backend     防止跨站伪造
     * @apiParamExample {json} 请求参数
     *   POST /v1/api-member/login
     *   {
     *        "mobile":15011122233  //会员手机号
     *        "code":456123         //验证码
     *        "sex":1              // 1:代表 男 2代表女
     *        "IDNumber":410278219900881   //身份证号
     *        "memberName":王大锤    //会员姓名
     *         "password":123456     // 会员密码
     *         "_csrf_backend":"2e12egjkqsdguidaudgiqgd" // 防止跨站伪造
     *   }
     * @apiDescription   用户注册
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br/>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/10/24
     * @apiSampleRequest  http://qa.aixingfu.net/member-ship/member-register
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情
     *{
     *  "status":"success",
     *  "message":"注册成功",
     *   "member":[
     *     "id"=>3456,
     *      "memberName"=>"王大锤"
     *      ]
     *  "data": "成功信息",
     * },
     *{
     *  "status":"error",
     *  "message":"注册失败",
     *  "data" : "失败信息"
     * },
     */
    public function actionMemberRegister()
    {
        $post = \Yii::$app->request->post();
        $model = new \backend\models\MemberShipLoginForm();
        $model->setScenario('memberRegister');
        if ($model->load($post, '')&&$model->validate()) {
           $endResult = $model->insertTheMember();
           if($endResult!==true){
               return json_encode(['status' => 'error','data' =>$endResult]);
           }
           return json_encode(['status' => 'success','data' =>"注册成功","member"=>$model->member]);
        }
        return json_encode(['status' => 'error','data' =>$model->errors]);
    }
    /**
     * @api {get} /member-ship/get-card-category   不同的卡种信息
     * @apiVersion  1.0.0
     * @apiName            不同的卡种信息
     * @apiGroup           register
     * @apiPermission     管理员
     * @apiParam  {int}   cardType
     * @apiParam  {int}   page
     * @apiParamExample {json} 请求参数
     *   GET  /member-ship/get-card-category
     *   {
     *        "cardType":1    //1:瑜伽,2:健身,3舞蹈,4:综合等 5：VIP
     *         "page":page    // 当前页码
     *   }
     * @apiDescription   获取不同的卡种信息
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br/>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/10/25
     * @apiSampleRequest  http://qa.aixingfu.net/member-ship/get-card-category
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情
     *{
     *  "pages":页码信息
     *  "data" :
     * {
     * "id": "134",           //卡种id
     * "venue_id": "56",      //场馆id
     * "category_type_id": "1",  // 卡类型id
     * "card_name": "迈步健身卡年卡（预售）", // 卡名称
     * "sell_start_time": null,     //售卖开始时间
     * "sell_end_time": null,       //售卖结束时间
     * "duration": "{\"day\": 360}",  // 时间长度
     * "original_price": "799.00",   // 一口原价
     * "sell_price": "799.00",      // 一口售价
     * "pic":fbkwafklgvnklasjdlhshd, // 会员卡图片
     * "max_price": null,          // 最高价
     * "min_price": null,          // 最低价
     * "offer_price": null,        // 优惠价
     * "type_name": "时间卡"       // 卡类型名称
    },
     * }
     *  "isEndPage":是否是最后一页
     * },
     */
    public function actionGetCardCategory($cardType="",$page){
            $model = new MemberShipLogic();
            $nowPage = (isset($page)&&!empty($page))?$page:1;
            $data  =  $model->gainCardCategoryMessage($cardType,$nowPage);
//            $pagination          = $data->pagination;
//            $pages               = Func::getPagesFormat($pagination);
            return json_encode(["data"=>$data]);
    }
    /**
     * @api {get} /member-ship/card-category-message  卡种详细信息
     * @apiVersion  1.0.0
     * @apiName            卡种详细信息
     * @apiGroup           register
     * @apiPermission     管理员
     * @apiParam  {int}   id     // 卡种id
     * @apiParamExample {json} 请求参数
     *   GET  /member-ship/get-card-category
     *   {
     *         "id":56    // 卡种id
     *   }
     * @apiDescription   获取单一卡种的详细信息
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br/>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/10/25
     * @apiSampleRequest  http://qa.aixingfu.net/member-ship/card-category-message
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情
     *{
     *  "data" :
     * {
    {
    "data": {
    "id": "1051",          // 卡种id
    "type_name": "时间卡",  // 卡类型名称
    "category_type_id": "1",  //卡类型id
    "card_name": "444",      // 卡名称
    "original_price": "12.00",  // 一口原价
    "sell_price": "12.00",   //一口售价
    "max_price": null,     // 最高价 (目前价格 暂定最高价)
    "min_price": null,     // 最低价
     "pic":fbkwafklgvnklasjdlhshd, // 会员卡图片
    "transfer_price": "12.00", //转让金额
    "leave_total_days": "11",  //请假总天数
    "leave_total_times": null, // 请假总次数
     "attributes":1,	// 1个人2公司3团体
    "active_time":5    // 激活期限
     "bring":1        // 0代表不带人 1代表带人
    "leave_long_limit": "null", //最长请假天数,最长请假次数[天，次],[天，次]
    "leave_least_Days": "2",   //每次请假最少天数
    "duration": 84,     // 卡有效期 84天
    "card_type": "3",  // 1:瑜伽,2:健身,3舞蹈,4:综合 5:vip
    "leagueBindPack": [    // 绑定团课套餐（约课范围）
    {
    "id": "752",
    "card_category_id": "1051",
    "polymorphic_id": "1",
    "polymorphic_type": "class",
    "number": "12",    // 每天最多预约节数（如果number：1表示不限次数）
    "name": "瑜伽"     // 课程名称
    },
    {
    "id": "753",
    "card_category_id": "1051",
    "polymorphic_id": "2",
    "polymorphic_type": "class",
    "number": "12",    // 每天最多预约节数（如果number：1表示不限次数）
    "name": "舞蹈"
    },
    ],
    "privateLessonPack": [   // 赠送私课套餐
    {
    "id": "757",
    "card_category_id": "1051",
    "polymorphic_id": "14",
    "polymorphic_type": "hs",
    "number": "11",    // 赠送私教节数
    "name": "热瑜伽"   //赠送课程名称
    },
    {
    "id": "758",
    "card_category_id": "1051",
    "polymorphic_id": "15",
    "polymorphic_type": "pt",
    "number": "11",
    "name": "普拉提"
    },
    ],
    "theLimitCardNumber": [     // 该卡的通店场馆
    {
    "card_category_id": "1054",   //卡种id
    "venue_id": "10",            //场馆id
    "level": "2",               // 卡等级 1：普通 2：vip
    "week_times": "99",         // 每周限制的通店次数
    "month_times": null,        // 每月的通店次数
    "venueName": "大学路舞蹈健身馆"   // 通店场馆名称
     "goVenueTime":"12:00-16:00"     // 会员进场时间在 12点-16点
    },
     ]
    "giftPack": [               // 绑定的赠品
    {
    "id": "756",
    "card_category_id": "1051",
    "polymorphic_id": "8",
    "polymorphic_type": "gift",
    "number": "12",
    "name": "赠送天数",
    "gift":{
    "id": "8",
    "member_id": "67308",
    "member_card_id": "64445",
    "service_pay_id": "5",
    "num": "10",            // 赠品数量
    "status": "2",
    "name": "赠送天数",     // 赠品名称
    "create_at": "1508749412",
    "get_day": "1508749412",
    "class_type": "day",
    "note": "是是是"
    }
    }
    ]
    }
    }
    },
     */
    public function actionCardCategoryMessage($id){
        $model = new MemberShipLogic();
        $data       = $model->gainTheCardMessage($id);
        return json_encode(["data"=>$data]);
    }
    /**
     * @api {get} /member-ship/potential-member    潜在会员信息
     * @apiVersion  1.0.0
     * @apiName            获取潜在会员信息
     * @apiGroup           register
     * @apiPermission     管理员
     * @apiParam  {string}   mobile
     * @apiParamExample {json} 请求参数
     *   GET  /member-ship/potential-member
     *   {
     *        "mobile":15537312038    //会员手机号
     *   }
     * @apiDescription   获取会员潜在信息 并返回会员身份
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br/>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/10/26
     * @apiSampleRequest  http://qa.aixingfu.net/member-ship/potential-member
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample  {json}  返回值详情
     *{
     * "isNotPotentialMember":1，    // 1新会员 2潜在会员 3:老会员
     *  "data" :{  (只有潜在会员会返回信息 老会员 新会员返回空数组)
     * "mobile": "15537312038",  //会员电话
     * "company_id": "56",        //公司id
     * " memberType": "1",       // 会员身份信息
     * "name": "张三",           // 张三
     * "sell_start_time": null,     //售卖开始时间
     * 'sex':1,    // 会员性别 (1:男 2:女)
     * "id_card":"410782199003060958"  // 会员身份证号
     * "password":"********"      // 会员密码
     * },
     */
    public function actionPotentialMember($mobile){
        $model               = new MemberShipLogic();
        $model->gainMemberIdentify($mobile);
        return json_encode(["isNotPotentialMember"=>$model->isNotPotentialMember,
                "data"=>$model->memberMessage]);
    }
    /**
     * @api {post} /member-ship/member-login  *会员登录
     * @apiVersion  1.0.0
     * @apiName            *会员登录
     * @apiGroup           register
     * @apiPermission     管理员
     * @apiParam  {string}   mobile   // 手机号
     * @apiParam  {string}   code     // 验证码
     * @apiParamExample {json} 请求参数
     *   POST  /member-ship/potential-member
     *   {
     *        "mobile":15537312038    //会员手机号
     *        "code":253600           // 验证码
     *   }
     * @apiDescription   会员通过手机号登录
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br/>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/10/26
     * @apiSampleRequest  http://qa.aixingfu.net/member-ship/member-login
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample  {json}  返回值详情
     *{
     * "status":登录状态  // error：登录失败  success:登录成功
     * "message":您信息还不完善,请从主页进入    // 失败或成功后登录信息
     *  "data" :{  返回老会员登录后的信息  （登录不成功返回空数组）
     *     "id":54321,   // 会员id
     *    "memberName": 王大锤,  //会员电话
     *   },
     */
    public function actionMemberLogin(){
        $post                = $post = \Yii::$app->request->post();
        $model = new \backend\models\MemberShipLoginForm();
        $data                =  $model->memberLogin($post["mobile"],$post["code"]);
        if($data === "codeError"){
            return json_encode(["status"=>"error","message"=>"验证码有误,请重新输入","member"=>[]]);
        }
        if($data === "notRegisterMember"){
            return json_encode(["status"=>"error","message"=>"你还没注册呢","member"=>[]]);
        }
        if($data==="potentialMember"){
            return json_encode(["status"=>"error","message"=>"您信息还不完善,请从主页进入","member"=>[]]);
        }
        return json_encode(["status"=>"success","message"=>"登录成功","member"=>$model->member]);
    }

    /**
     * @api {post} /member-ship/member-hardware-login  *硬件会员登录
     * @apiVersion  1.0.0
     * @apiName            *硬件会员登录
     * @apiGroup           hardwareRegister
     * @apiPermission     管理员
     * @apiParam  {string}   mobile   // 手机号
     * @apiParam  {string}   name     // 姓名
     * @apiParam  {string}   _csrf_backend    // 姓名
     * @apiParamExample {json} 请求参数
     *   POST  /member-ship/member-hardware-login
     *   {
     *        "mobile":15537312039    //会员手机号
     *        "name":  王大崔           // 姓名
     *        "_csrf_backend":'SG5uZUtDQXokWgBWcxw2Ph8NW1w4dyhJDyoJAA40IzUBWjEGCAoIHA=='  // csrf
     *   }
     * @apiDescription   硬件会员 通过 手机号和姓名 登录
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br/>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/10/26
     * @apiSampleRequest  http://qa.aixingfu.net/member-ship/member-hardware-login
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample  {json}  返回值详情
     *{
    {
     *"status": "success",
     *"paramComplete": true,   // 参数是否完整  false 不完整  true完整
     *"message": "登录成功",
     *"member": {
     *"id": "3253",          // 会员id
     *"mobile": "13526508176",  // 会员手机号
     *"memberName": "程兵兵测试",  // 会员姓名
     *"sex": "1",                 // 会员性别  1男 2女
     *"idCard": "410328199004129611"  // 身份证号
    }
    }
     * }
     */
    public function actionMemberHardwareLogin(){
        $post                = $post = \Yii::$app->request->post();
        $param               = empty($post["mobile"])||empty($post["name"])?false:true;
        if($param===false){
            return json_encode(["status"=>"error","message"=>"姓名或手机号不能为空","member"=>[]]);
        }
        $model = new \backend\models\MemberShipLoginForm();
        $data                =  $model->hardwareLogin($post["mobile"],$post["name"]);
        if($data === "notRegisterMember"){
            return json_encode(["status"=>"error","message"=>"你还没注册呢","paramComplete"=>false,"member"=>[]]);
        }
        if($data===false){
            return json_encode(["status"=>"error","message"=>"您的信息还不完善,请先填写完整","paramComplete"=>false,"member"=>$model->member]);
        }
        return json_encode(["status"=>"success","paramComplete"=>true,"message"=>"登录成功","member"=>$model->member]);
    }


    /**
     * @api {post} /member-ship/member-hard-register 会员注册
     * @apiVersion  1.0.0
     * @apiName        会员注册
     * @apiGroup       hardRegister
     * @apiPermission 管理员
     * @apiParam  {string}          mobile      手机号
     * @apiParam  {string}          code        验证码
     * @apiParam  {int}             sex         性别
     * @apiParam  {string}          IDNumber    身份证号
     * @apiParam  {string}         memberName  会员姓名
     * @apiParam  {string}          _csrf_backend     防止跨站伪造
     * @apiParamExample {json} 请求参数
     *   POST /member-ship/member-hard-register
     *   {
     *        "mobile":15011122233  //会员手机号
     *        "code":456123         //验证码
     *        "sex":1              // 1:代表 男 2代表女
     *        "IDNumber":410278219900881   //身份证号
     *        "memberName":王大锤    //会员姓名
     *         "password":123456     // 会员密码
     *         "_csrf_backend":"2e12egjkqsdguidaudgiqgd" // 防止跨站伪造
     *   }
     * @apiDescription   用户注册
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br/>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club
     * <span><strong>创建时间：</strong></span>2017/10/24
     * @apiSampleRequest  http://qa.aixingfu.net/member-ship/member-hard-register
     * @apiSuccess (返回值) {string} data
     * @apiSuccessExample {json}返回值详情
     *{
     *  "status":"success",
     *  "message":"注册成功",
     *   "member":[
     *     "id"=>3456,
     *      "memberName"=>"王大锤"
     *      ]
     *  "data": "成功信息",
     * },
     *{
     *  "status":"error",
     *  "message":"注册失败",
     *  "data" : "失败信息"
     * },
     */
    public function actionMemberHardRegister(){
        $post = \Yii::$app->request->post();
        $model = new \backend\models\MemberShipLoginForm();
        $model->setScenario('hardMemberRegister');
        if ($model->load($post, '')&&$model->validate()) {
            $endResult = $model->insertTheMember("sign");
            if($endResult!==true){
                $return = Func::setReturnMessageArr($endResult,'您已经注册过了，请直接登录');
                return json_encode(['status' => 'error','data' =>$return]);
            }
            return json_encode(['status' => 'success','data' =>"注册成功","member"=>$model->member]);
        }
        $return = Func::setReturnMessageArr($model->errors,'注册失败');
        return json_encode(['status' => 'error','data' =>$return]);
    }

    












}
