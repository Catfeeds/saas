<?php
namespace backend\controllers;

use backend\models\Config;
use backend\models\Deal;
use backend\models\GroupClass;
use backend\models\Member;
use backend\models\MemberCard;
use backend\models\MemberForm;
use backend\models\Organization;
use backend\modules\v1\models\SellCardForm;
use backend\models\RegistrationVenueForm;
use yii\web\Controller;
class PurchaseCardController extends Controller
{
    /**
     * 购卡页面
     */
    public $layout='buyCard';

    public function actionIndex()
    {
        return $this->render('index');
    }

//    /**
//     * 购卡选卡页面$companyId
//     */
//    public function actionAgreement()
//    {
//        return $this->render('agreement');
//    }

    /**
     * author 程丽明
     * 购卡完成页面
     * date  2017/6/27
     */
    public function actionComplete()
    {
        return $this->render('complete');
    }

    /**
     * author 程丽明
     * 购卡合同页面
     * date  2017/6/22
     */
    public function actionContract()
    {
        return $this->render('contract');
    }

    /**
     * author 程丽明
     * content 购卡合同页面
     * date  2017/6/24
     */
    public function actionNewContract()
    {
        return $this->render('newContract');
    }

    /**
     * author 苏雨
     * 购卡合同页面
     * date  2017/08/01
     */
    public function actionContactSend()
    {
        return $this->render('contactSend');
    }

    /**
     * @api {post} /purchase-card/sell-card 扫码购卡
     * @apiVersion 1.0.0
     * @apiName 扫码购卡
     * @apiGroup PurchaseCard
     * @apiPermission 管理员
     * @apiParam {string} name 姓名
     * @apiParam {int} idCard 身份证号
     * @apiParam {string} idAddress 身份证住址
     * @apiParam {string} nowAddress 现居地
     * @apiParam {int} mobile 手机号
     * @apiParam {int} code 填写的验证码
     * @apiParam {int} newCode 生成的验证码
     * @apiParam {int} cardId 卡种id
     * @apiParamExample {json} Request Example
     * {
     *      "name"=>李丽,
     *      "idCard"=>411121198512105529,
     *      "idAddress"=>"河南省周口县莲花乡大池子村",
     *      "nowAddress"=>河南郑州金水区,
     *      "mobile"=>15736885523,
     *      "code"=>589412,
     *      "newCode"=>589412,
     *      "cardId"=>5,
     *      "_csrf_backend"=>"_asjbbjkashdjkashdkashdkhasdhaskda==",
     * }
     * @apiDescription 扫码购卡<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/6<br>
     * <span><strong>调用方法：</strong></span>/purchase-card/sell-card
     *
     * @apiSampleRequest  http://qa.uniwlan.com/purchase-card/sell-card
     * @apiSuccess (返回值) {string} status 返回状态
     * @apiSuccess (返回值) {string} data   返回状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     *{
     * "status": "success",
     * "message": "成功"
     * }
     * @apiErrorExample {json} 错误示例:
     * {
     * "status": "error",
     * "message": "失败",
     * "data": {
     * "name": [
     * "请填写姓名"
     * ]
     * }
     * }
     */
    public function actionSellCard()
    {
        $post  = \Yii::$app->request->post();
        $model = new SellCardForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->setSellCard();
            if ($data === true) {
                $model->sendMessage();                           //购卡成功发送短信
                return json_encode(['status' => 'success', 'message' => '成功']);
            } else {
                file_put_contents("log.txt","\n ...".$post['mobile'].'&&'.$data."... \n",FILE_APPEND );
                return json_encode(['status' => 'error', 'message' => '失败', 'data' => $data]);
            }
        } else {
            file_put_contents("log.txt","\n ...".$post['mobile'].'&&'.$model->errors."... \n",FILE_APPEND );
            $result = json_encode(['status' => 'error', 'message' => '失败', 'data' => $model->errors]);
        }
        return $result;
    }

    /**
     * 云运动 - 进馆登记 - 进馆登记数据储存
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/7/13
     * @return string
     */
    public function actionRegistrationVenue()
    {
        $companyId = isset($this->companyId)?$this->companyId:0;
        $venueId   = isset($this->venueId)?$this->venueId:0;
        $post  = \Yii::$app->request->post();
        $model = new RegistrationVenueForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->setRegistration($companyId,$venueId);
            if ($data === true) {
                return json_encode(['status' => 'success', 'message' => '登记成功']);
            } else {
                return json_encode(['status' => 'error', 'message' => '失败', 'data' => $data]);
            }
        } else {
            $result = json_encode(['status' => 'error', 'message' => '失败', 'data' => $model->errors]);
        }
        return $result;
    }

    /**
     * @api {post} /purchase-card/deal 获取卡种的合同详情
     * @apiVersion 1.0.0
     * @apiName 获取卡种的合同详情
     * @apiGroup PurchaseCard
     * @apiPermission 管理员
     * @apiParam {int} cardId 卡种id
     * @apiParamExample {json} Request Example
     * {
     *      "cardId"=>5,
     * }
     * @apiDescription 扫码购卡 - 获取卡种的合同详情<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/6<br>
     * <span><strong>调用方法：</strong></span>/purchase-card/deal
     *
     * @apiSampleRequest  http://qa.uniwlan.com/purchase-card/deal
     * @apiSuccess (返回值) {string} status 返回状态
     * @apiSuccess (返回值) {string} data   返回状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {"intro":["合同内容"]}
     * @apiErrorExample {json} 错误示例:
     * {"intro":[]}
     */
    public function actionDeal()
    {
        $id   = \Yii::$app->request->get('cardId');
        $deal = SellCardForm::getDeal($id);
        return json_encode($deal);
    }

    /**
     * @api {get} /purchase-card/card-category 获取场馆售卖的卡种
     * @apiVersion 1.0.0
     * @apiName 获取场馆售卖的卡种
     * @apiGroup PurchaseCard
     * @apiPermission 管理员
     *
     * @apiParam venueId int 场馆ID
     *
     * @apiDescription 售卡管理 - 获取场馆售卖的卡种<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/15<br>
     * <span><strong>调用方法：</strong></span>/purchase-card/card-category
     *
     * @apiSampleRequest  http://qa.uniwlan.com/purchase-card/card-category
     * @apiSuccess (返回值) {string} status 返回状态
     * @apiSuccess (返回值) {string} data   返回状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {[
     * {"id": "1","name": "金爵卡",}
     * ]}
     *
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionCardCategory($venueId)
    {
        $venueId = isset($venueId)?$venueId:0;
        $cardCategory = \backend\models\SellCardForm::getCardCategory($venueId);
        return json_encode($cardCategory);
    }
    /**
     * @api {get} /purchase-card/get-member-by-id 获取会员
     * @apiVersion 1.0.0
     * @apiName 获取会员
     * @apiGroup  GetMember
     * @apiPermission 管理员
     *
     * @apiParam venueId int 场馆ID
     *
     * @apiDescription 售卡管理 - 获取场馆售卖的卡种<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/15<br>
     * <span><strong>调用方法：</strong></span>/purchase-card/get-member-by-id
     *
     * @apiSampleRequest  http://qa.uniwlan.com/purchase-card/get-member-by-id
     * @apiSuccess (返回值) {string} status 返回状态
     * @apiSuccess (返回值) {string} data   返回状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     *
     * {"id": "1",
     *   "username": "lihua",
     *    "password" : '123456',
     *    "mobile"   : '15345679876',
     * }
     *
     *
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionGetMemberById($id="",$venue = "",$cardId ="",$opendoor="",$current_time="")
    {
        // 移除卡号两侧的空白字符或其他预定义字符
        $cardId = trim($cardId);
        // 场馆位置定位
        $organization = Member::gainOrganizationMessage($venue);
        $companyId    = $organization[0];  // 公司id
        $venueId      = $organization[1];  // 场馆id
        if(empty($companyId) || empty($venueId)){
             return '未查询到匹配的公司或场馆';
        }
        //处理时间戳
        if(empty($current_time)){
            $current_time = 0;
        }else{
            $current_time = substr($current_time,0,strlen(time()));
        }
        // 员工方面的处理(在没有接收到数据库的时间的时候 接受闸机发过来的时间)
        if($cardId == "000000" && $opendoor == 1){
            // 执行二维码的删除操作
            $diffTime = time() - $current_time;   // 同时判断二维码的有效期 不能超过5秒
            if($diffTime > 5){
                return '员工二维码已过期';
            }
            Member::deleteAllScanCode($cardId,$id);
            return 1;
        }
        // 会员方面
        if($cardId != "000000" && $opendoor == 1){
            // 判断会员卡是否通店
            $model = new MemberCard();
            $limit = $model->getVenueData($venueId,$cardId);    //参数：验卡的场馆id,会员卡id（返回结果，为空的是不能通店）
            if(empty($limit)){    //判断会员卡的通店数据是否为空
                return '此卡不能通店';   //此卡不能通店
            }
            // 判断会员卡状态
            $card = MemberCard::getMemberCardStatus($cardId);
            if($card !== true){
                return $card;
            }
        }
        // 判断是否录入二维码（没录入 二维码 不能进）
        $data_base_current_time = Member::dataBaseCurrentTime($cardId,$id);
        if(!empty($data_base_current_time)){
            // 获取二维码 闸机时间（后期更改 直接从数据库 拿时间）
            $current_time = substr($data_base_current_time,0,strlen(time()));
        }else{
            //数据库没有录入二维码 不能进场
            if($cardId != "000000"){
                return '数据库没有录入二维码 不能进场';
            }
        }
        // 在录入二维码的基础上 判断 当前时间 往前 推1分钟 是否有进场记录
        if($cardId != "000000" && $opendoor == 1){
            $timeDifferent = Member::gainTheDiffTime($id,$venueId,$venue);
            if($timeDifferent === false){
                return '请稍后再试';
            }
        }
        // 会员进场验闸机（保存进场记录  验证二维码有效期）
        if($opendoor == 1){
            $cardCategory = Member::getMemberOneById($id,$venue,$cardId,"machine",$current_time,$venueId);
            if(empty($cardCategory)){
                // 删除二维码记录
                Member::deleteAllScanCode($cardId);
                return 0;
            }
        }
        // 会员进场增加进场记录 出场修改出场时间
        $entry = Member::enterRecord($id,$cardId,$venueId,$companyId,$opendoor);
        if($entry !== true){
            return '进出场记录错误';
        }
        // 删除二维码记录
        Member::deleteAllScanCode($cardId);
        return 1;
    }
    /**
     * @api {get} /purchase-card/get-only-venue 获取售卖场馆
     * @apiVersion 1.0.0
     * @apiName 获取售卖场馆
     * @apiGroup PurchaseCard
     * @apiPermission 管理员
     *
     * @apiDescription 售卡管理 - 获取售卖场馆<br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/21<br>
     * <span><strong>调用方法：</strong></span>/purchase-card/get-only-venue
     *
     * @apiSampleRequest  http://qa.uniwlan.com/purchase-card/get-only-venue
     * @apiSuccess (返回值) {string} status 返回状态
     * @apiSuccess (返回值) {string} data   返回状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {[
     * {"id": "1","name": "迈步",}
     * ]}
     *
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionGetOnlyVenue()
    {
        $venue = Organization::getVenueOneDataByLikeName();
        return json_encode($venue);
    }

    /**
     * @return string
     * author 程丽明
     * content 新购卡页面
     * date 2017-06-29 15:07
     */
    public function actionCompany()
    {
        return $this->render('company');
    }

    /**
     *后台潜在会员管理 - 登记进馆 - 获取来源渠道
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/6/21
     * @return bool|string
     */
    public function actionGetSourceData($companyId,$venueId)
    {
        $model      = new Config();
        $data = $model->getMemberConfigData($companyId,$venueId);
        return json_encode($data);
    }
    /**
     *后台潜在会员 - 登记进馆- 获取会员单条卡信息
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/7/14
     * @return object
     */
    public function actionGetAdviserData($companyId,$venueId)
    {
        $model = new Member();
        $data = $model->getAdviserData($companyId,$venueId);
        return json_encode($data);
    }

    /**
     * @return string
     * author 程丽明
     * content 新购卡完成页面
     * date 2017-06-29 15:07
     */
    public function actionFinish()
    {
        return $this->render('success');
    }

    /**
     * @return string
     * author 程丽明
     * content 新购卡页面中car合同页面
     * date 2017-06-29 15:07
     */
    public function actionAgreement()
    {
        return $this->render('agreement');
    }

    /**
     * @return string
     * author 程丽明
     * content 新购卡页面中协议页面
     * date 2017-06-29 15:07
     */
    public function actionProtocol()
    {
        return $this->render('protocol');
    }

    /**
     * 业务后台 - 售卡页面 - 根据公司获取场馆
     * @author    李慧恩<lihuien@itsports.club>
     * @content   新购卡页面中协议页面
     * @param     $companyId
     * @date      2017-06-29 15:07
     * @return string
     */
    public function actionGetVenueByCompanyId($companyId)
    {
        $organ = new Organization();
        $venue = $organ->getOrganizationData($companyId);
        return json_encode($venue);
    }
    /**
     * 合同管理 - 列表 - 获取迈步合同名称接口
     * @create 2017/6/23
     * @author huanghua<lihuien@itsports.club>
     * @param  $companyId
     * @return bool
     */
    public function actionGetDealName($companyId)
    {
        $deal = Deal::getDealNameByCompanyId($companyId);
        return json_encode($deal);
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
        $MemberId     = \Yii::$app->request->get('MemberId');
        $venueId      = \Yii::$app->request->get('venueId');
        if($MemberId == 'null'){
            $MemberId = null;
        }
        if (!empty($MemberIdCard)) {
            $model = new \backend\models\MemberDetails();
            $MemberData = $model->getMemberIdCard($MemberId,$MemberIdCard,$venueId);
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
     * @return string
     * author 程丽明
     * content 会员登记页面
     * date 2017-07-06 11:40
     */
    public function actionRegister()
    {
        return $this->render('memberRegister');
    }

    /**
     * @return string
     * author 程丽明
     * content 测试购卡微信支付页面
     * date 2017-07-06 11:40
     */
    public function actionTest()
    {
        return $this->render('testPayment');
    }

    /**
     * @return string
     * author 程丽明
     * content 进馆登记页面
     * date 2017-07-13 20:40
     */
    public function actionAccess()
    {
        return $this->render('accessRegister');
    }

    /**
     * @return string
     * author 程丽明
     * content 进馆登记完成页面
     * date 2017-07-14 14:00
     */
    public function actionCompleteRegister()
    {
        return $this->render('completeRegister');
    }

    /**
     * author 程丽明
     * 购卡完成页面
     * date  2017/6/27
     */
    public function actionUser()
    {
        return $this->render('/site/user');
    }

    public function actionStep()
    {
        return $this->render('/site/step');
    }

    /**
     * author 程丽明
     * 购卡完成页面
     * date  2017/6/27
     */
    public function actionSiteAgreement()
    {
        return $this->render('/site/agreement');
    }

    /**
     * author 程丽明
     * date  2017/6/27
     * content:手机购卡页面
     */
    public function actionMobilePurchase()
    {
        return $this->render('mobilePaymentPurchase');
    }

    /**
     * author 程丽明
     * date  2017/9/2
     * content:手机购卡订单支付页面
     */
    public function actionPaymentOrder()
    {
        return $this->render('paymentOrder');
    }

    /**
    * author 程丽明
    * date  2017/9/2
    * content:手机购卡订单支付完成页面
    */
    public function actionOrderComplete()
    {
        return $this->render('paymentOrderComplete');
    }

    /**
     * 业务后台 - 掌静脉获取会员信息
     * @author zhumengke <zhumengke@itsports.club>
     * @param $mobile    //手机号
     * @date 2018-05-14
     * @return string
     */
    public function actionGetInfo($mobile,$venue){
        $model = new Member();
        $data  = $model->getInfo($mobile,$venue);
        return json_encode($data);
    }

    /**
     * 业务后台 - 机器刷卡
     * @author   houkaixin<houkaixin@itsports.club>
     * @param     $venue    // 场馆名称
     * @param     $cardid   // ic卡编号
     * @date      2017-06-29 15:07
     * @return string
     */
    public function actionGainMemberMessage($venue="",$cardid="",$opendoor="",$current_time=""){
        $memberId = Member::gainMemberMessage($venue,$cardid,$opendoor,$current_time);
        return $memberId;
    }

    /**
     * 业务后台 - 闸机 - 会员信息调取
     * @author   houkaixin<houkaixin@itsports.club>
     * @param     $cardId      // 会员卡id
     * @param     $venue       // 场馆名称
     * @date      2017-06-29 15:07
     * @return string
     */
    public function actionGetMemberMessage($cardId,$venue="maibu"){
           $model   = new Member();
           $result  = $model->gainMemberMessageByCardId($cardId,$venue);
           return json_encode(["data"=>$result]);
    }

    /**
     * @desc: 业务后台 - 
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/03/16
     * @return string
     * @throws \Exception
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionRegisterPotential()
    {
        $post  = \Yii::$app->request->post();
        $model = new SellCardForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->registerPotential();
            if ($data === true) {
                $model->sendMessage();                           //注册成功发送短信
                return json_encode(['status' => 'success', 'message' => '成功']);
            } else {
                file_put_contents("log.txt","\n ...".$post['mobile'].'&&'.$data."... \n",FILE_APPEND );
                return json_encode(['status' => 'error', 'message' => '失败', 'data' => $data]);
            }
        } else {
            file_put_contents("log.txt","\n ...".$post['mobile'].'&&'.$model->errors."... \n",FILE_APPEND );
            $result = json_encode(['status' => 'error', 'message' => '失败', 'data' => $model->errors]);
        }
        return $result;
    }

    /**
     * @desc: 业务后台 - 扫码注册 - 判断手机号是否存在
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/03/15
     * @return null|string
     */
    public function actionGetMobileInfo()
    {
        $mobile    = \Yii::$app->request->get('mobile');
        $companyId = \Yii::$app->request->get('companyId');
        $venueId   = \Yii::$app->request->get('venueId');
        $model     = new Member();
        $data      = $model->getRegisterInfo($mobile,$companyId,$venueId);
        if(isset($data) && !empty($data)){
            return json_encode(['status'=>'error']);
        }else{
            return json_encode(['status'=>'success']);
        }
    }

    /**
     * 潜在会员 - 获取某个场馆的客服人员
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/04/12
     * @param  $venue //场馆标识
     * @return array
     */
    public function actionGetCounselor()
    {
        $venue = \Yii::$app->request->get('venue');
        // 场馆位置定位
        $organization = Member::gainOrganizationMessage($venue);
        $companyId    = $organization[0];  // 公司id
        $venueId      = $organization[1];  // 场馆id
        if(empty($companyId) || empty($venueId)){
            return '未查询到匹配的公司或场馆';
        }
        $model = new Member();
        $data  = $model->getAdviserInfo($companyId,$venueId);
        return json_encode(['data' => $data]);
    }

    /**
     * 业务后台 - 获取当前时间之后的团课排课信息
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/06/13
     * @param  $venue //场馆标识
     * @return array
     */
    public function actionGroupClassInfo()
    {
        $venue = \Yii::$app->request->get('venue');
        // 场馆位置定位
        $organization = Member::gainOrganizationMessage($venue);
        $venueId      = $organization[1];  // 场馆id
        if(empty($venueId)){
            return '未查询到匹配的场馆';
        }
        $model = new GroupClass();
        $data  = $model->groupClassInfo($venueId);
        return json_encode(['data' => $data]);
    }
}
