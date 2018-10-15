<?php

namespace backend\controllers;

use backend\models\AboutYard;
use backend\models\AddVenueYardForm;
use backend\models\Member;
use backend\models\Organization;
use backend\models\VenueYard;
use common\models\Func;

class SiteManagementController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * @api {post}  /site-management/add-venue-yard 新增场馆场地
     * @apiVersion 1.0.0
     * @apiName     新增场馆场地
     * @apiGroup   yardOrders
     * @apiParam  {int}     venueId         场馆id
     * @apiParam  {string}  yardName        场地名称
     * @apiParam  {int}     peopleLimit     场地人数限制
     * @apiParam  {string}  businessTime    营业时间
     * @apiParam  {string}  everyTimeLong   活动时长
     * @apiParam  {string}    cardCategoryId  卡种ID（可以包括多个卡种）
     * @apiParam  {string} _csrf_backend    csrf验证.
     * @apiParamExample {json} Request Example
     *   POST  /site-management/add-venue-yard
     *   {
     *        "venueId": 12,                 // 场馆id
     *       "yardName": 大上海篮球场,        // 请假会员ID
     *       "peopleLimit : 20,              // 场地人数限制 20
     *       "businessTime": "9:00-18:00",   //场馆开放时间
     *       "everyTimeLong":300,            // 每次活动时长
     *       "cardCategoryId" :20,30,40      // 卡种id 以逗号连起来
     *       "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="  // 防止跨站伪造
     *   }
     * @apiDescription    新增场馆场地
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/9/6
     * @apiSampleRequest  http://qa.uniwlan.com/site-management/add-venue-yard
     * @apiSuccess (返回值) {string} data   返回请假状态数据
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','status'=>'success','data':"保存成功"}
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','status'=>'error','data':"保存失败信息"}
     */
    public function actionAddVenueYard(){
        $post = \Yii::$app->request->post();
        $post['venueId'] = empty($post['venueId'])?$this->nowBelongId:$post['venueId'];
        $model    = new AddVenueYardForm();
        $model->setScenario('addVenueYard');
        if($model->load($post,'') && $model->validate())
        {
            $result = $model->addVenueYard();
            if($result===true){
                return json_encode(['status' => 'success','data' =>'保存成功']);
            }else{
                return json_encode(['status' => 'error','data' =>$result]);
            }
        }else{
            return json_encode(['status' => 'error','data' =>$model->errors]);
        }
    }
    /**
     * @api {get}  /site-management/venue-card-category 获取指定场馆的卡种
     * @apiVersion 1.0.0
     * @apiName     获取指定场馆卡种
     * @apiGroup    yardOrder
     * @apiParam  {int} venueId    场馆id
     * @apiParamExample {json} Request Example
     *   GET  /site-management/venue-card-category
     *   {
     *        "venueId": 12,                 // 场馆id
     *   }
     * @apiDescription  获取指定场馆卡种
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/9/6
     * @apiSampleRequest  http://qa.uniwlan.com/site-management/venue-card-category
     * @apiSuccess (返回值) {string} data   返回场馆卡种数据
     * @apiSuccessExample {json} 成功示例:
     * {'data':"返回过来的数据"}
     */
    public function actionVenueCardCategory($venueId = ""){
         $venueId = empty($venueId)?$this->venueId:$venueId;
         $model   = new VenueYard();
         $data    =  $model->getVenueCardCategory($venueId);
         return  json_encode(["data"=>$data]);
    }
    /**
     * @api {get}  /site-management/get-venue-yard-page  场地分页信息
     * @apiVersion 1.0.0
     * @apiName    场地分页信息
     * @apiGroup    yardOrderPage
     * @apiParam  {int}   venueId    场馆id
     * @apiParam {string} sortType  排序字段名称
     * @apiParam {string} sortName  排序方法（倒序/升序）
     * @apiParamExample {json} Request Example
     *   GET  /site-management/get-venue-yard-page
     *   {
     *      venueId  : 12,   // 场馆id
     *
     *      sortType:yard_name(yard_name：场地名称,场馆名称:name,人数限制:people_limit,开放时间:business_time,每次活动时长:active_duration),
     *      sortName:ASC     (ASC:升序;DESC:降序)
     *   }
     * @apiDescription  场地主页分页信息
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/9/6
     * @apiSampleRequest  http://qa.uniwlan.com/site-management/get-venue-yard-page
     * @apiSuccessExample {json} 成功示例:
     *{
     *      "id"      :"场地id",
     *      "venue_id":"场馆id",
     *       "yard_name":"场地名称",
     *       "people_limit":"人数限制"，
     *       "business_time":"场馆运营时间"，
     *       "active_duration":"每日活动时长"，
     *       "create_at": "场地创建时间",
     *        "name":"场馆名称"
     * };
     */
    public function actionGetVenueYardPage(){
        $get = \Yii::$app->request->get();
        $model = new VenueYard();
        $nowPage                = empty($get["page"])?0:$get["page"]-1;
        $courseDataObj          = $model->getVenueYardData($get);
        $pagination             = $courseDataObj->pagination;
        $totalPage              = ceil($courseDataObj->pagination->totalCount/8);
        $pages                  = Func::getPagesFormat($pagination,"replacementPage");
        return json_encode(["data"=>$courseDataObj->models,'pages'=>$pages,"nowPage"=>$nowPage,"totalPage"=>$totalPage]);
    }
    /**
     * 场地预约 - 获取潜在会员场地预约详情
     * @create 2017/11/13
     * @author houkaixin<houkaixin@itsports.club>
     * @return object     // 返回场地卡种
     */
    public function actionGetPotentialYardPage(){
        $get = \Yii::$app->request->get();
        $model = new VenueYard();
        $nowPage                = empty($get["page"])?0:$get["page"]-1;
        $courseDataObj          = $model->getVenueYardData($get);
        $pagination             = $courseDataObj->pagination;
        $totalPage              = ceil($courseDataObj->pagination->totalCount/8);
        $pages                  = Func::getPagesFormat($pagination,"potentialPage");
        return json_encode(["data"=>$courseDataObj->models,'pages'=>$pages,"nowPage"=>$nowPage,"totalPage"=>$totalPage]);
    }
    /**
     * @api {get}  /site-management/deal-venue-yard  删除适用场地
     * @apiVersion  1.0.0
     * @apiName     删除适用场地
     * @apiGroup    yardOrder
     * @apiParam  {int}   id     //场馆适用场地id
     * @apiParamExample {json} Request Example
     *   GET   /site-management/deal-venue-yard
     *   {
     *      id : 12,   // 场馆id
     *   }
     * @apiDescription   删除适用场地
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/9/7
     * @apiSampleRequest  http://qa.uniwlan.com/site-management/deal-venue-yard
     * @apiSuccessExample {json} 成功示例:
     *{
     *      "status"      :"success",    // 删除成功
     *      "status"      :"error",      // 删除失败
     * };
     */
    public function actionDealVenueYard($id){
        $model = new VenueYard();
        $result = $model->deleteDealVenueYard($id);
        if($result===true){
           return json_encode(["status"=>"success","data"=>"删除成功"]);  // 删除成功
        }else{
           return json_encode(["status"=>"error","data"=>$result]);    // 删除失败
        }
    }
    /**
     * @api {post}  /site-management/update-venue-yard   场地预约修改
     * @apiVersion  1.0.0
     * @apiName     场地预约修改
     * @apiGroup    yardOrderUpdate
     * @apiParam  {int}   id     //场地id
     * @apiParamExample {json} Request Example
     *   POST   /site-management/update-venue-yard
     *   {
     *      id : 12,                   // 场馆id
     *      peopleLimit: 12,           //人数限制
     *      businessTime:"9:00-12:00" // 场馆开放时间
     *      everyTimeLong:"30"         // 每次时长
     *   }
     * @apiDescription   场地预约修改
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/9/7
     * @apiSampleRequest  http://qa.uniwlan.com/site-management/update-venue-yard
     * @apiSuccessExample {json} 成功示例:
     *{
     *      "status"      :"error",
     *      "data"       :"修改失败",
     * };
     * @apiErrorExample {json} 失败示例:
     *{
     *      "status"      :"success",
     *      "data"       :"修改成功",
     * };
     */
    public function actionUpdateVenueYard(){
        $post = \Yii::$app->request->post();
        $model= new AddVenueYardForm();
        $model->setScenario('updateVenueYard');
        if($model->load($post,'') && $model->validate())
        {
            $result = $model->updateVenueYard();
            if($result===true){
                return json_encode(['status' => 'success','data' =>'修改成功']);
            }else{
                return json_encode(['status' => 'error','data' =>$result]);
            }
        }else{
            return json_encode(['status' => 'error','data' =>$model->errors]);
        }
    }
    /**
     * @api {get}  /site-management/get-venue-data  获取指定公司场馆
     * @apiVersion  1.0.0
     * @apiName     获取指定公司场馆
     * @apiGroup    yardOrderR
     * @apiParam  {int}  companyId    //公司id
     * @apiParamExample {json} Request Example
     *   GET   /site-management/get-venue-data
     *   {
     *      companyId: 12,   // 场馆id
     *   }
     * @apiDescription  获取指定公司场馆
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/9/7
     * @apiSampleRequest  http://qa.uniwlan.com/site-management/get-venue-data
     * @apiSuccessExample {json} 成功示例:
     *{
     *      "id"       :12,
     *       "name"   :“我爱运动”
     * };
     */
    public function actionGetVenueData(){
        $data  = "";
        $model = new VenueYard();
        $data = $model->getAllVenue($this->companyId);
        return json_encode(['data' =>$data]);
    }
    /**
     * @api {get}  /site-management/yard-detail  场地课程区段表
     * @apiVersion  1.0.0
     * @apiName     场地课程区段表
     * @apiGroup    yardMemberCancel
     * @apiParam  {int}    yardId   //场地id
     * @apiParam  {string} memberAboutDate  // 预约日期
     * @apiParam  {string} cardNumber   // 卡号 （验卡模块）
     * @apiParam  {int}    memberId    // 会员id（目前针对潜在会员）
     * @apiParam   {int}  aboutObject  // 预约对象 （验卡模块:memberCard）（潜在会员:member）
     * @apiParamExample {json} Request Example
     * GET  /site-management/yard-detail
     * {
     *      yardId : 10,   // 场地id    （备注：潜在会员预约所需参数：yardId,memberAboutDate,memberId,aboutObject）
     *      memberAboutDate:2017-11-13  //预约日期
     *      cardNumber：051509762544  // 卡号
     *      memberId: 117
     *      aboutObject：member   //会员
     * }
     * @apiDescription  场地课程区段表
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/9/7
     * @apiSampleRequest  http://qa.uniwlan.com/site-management/yard-detail
     * @apiSuccessExample {json} 成功示例:
     *{
     *    "data"：“数据信息”
     * };
     */
    public function actionYardDetail($yardId="",$memberAboutDate="",$cardNumber = "",$memberId = "",$aboutObject = "memberCard"){
        $model = new VenueYard();
        $data = $model->VenueYardDetailData($yardId,$memberAboutDate,$cardNumber,$memberId,$aboutObject);
        return json_encode(["data"=>$data]);
    }
    /**
     * @api {get}  /site-management/get-about-data-detail  区段会员预约详情
     * @apiVersion  1.0.0
     * @apiName      区段会员预约详情
     * @apiGroup    yardMemberTheAbout
     * @apiParam  {string}  memberAboutDate      // 会员预约日期
     * @apiParam  {string}  aboutIntervalSection // 预约日期
     * @apiParam  {string}  sortType // 排序字段
     * @apiParam  {string}  sortName // 排序规则
    * @apiParamExample {json} Request Example
     * GET /site-management/get-about-data-detail
     * {
     *      memberAboutDate : 2017-09-05,   // 会员预约日期
     *      aboutIntervalSection:9:00-12:00 // 区段预约日期
     *      sortType: mobile  (mobile:手机号,username:会员姓名,aboutYard:预约时间),
     *      sortName:ASC,(ASC:升序，DES:降序)
     * }
     * @apiDescription  区段会员预约详情
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/9/7
     * @apiSampleRequest  http://qa.uniwlan.com/site-management/get-about-data-detail
     * @apiSuccessExample {json} 成功示例:
     *{
     *    "yard_id"：12， // 场地id
     *    “member_id”:12,// 会员id,
     *     "member_card_id":12, // 会员卡id
     *    “about_interval_section”："12:00-13:00" , //会员预约区间段
     *    “aboutDate ”："2017-03-15" , //会员预约日期
     *     “status”：“会员上课状态”， //1:未开始 2:已开始 3:已结束 4:旷课(没去)5:取消预约
     *     "create_at":"预约时间"，     //会员预约时间
     *     “mobile”： “会员电话”   // 会员预约电话
     *      “username”："会员姓名"   // 会员姓名
     * };
     */
    public function actionGetAboutDataDetail(){
        $get = \Yii::$app->request->get();
        $model = new AboutYard();
        // 当前页参数处理
        $nowPage                = empty($get["page"])? 0 : $get["page"]-1;
        $courseDataObj          = $model->getYardAboutDetailData($get);
        $pagination             = $courseDataObj->pagination;
        $pages                  = Func::getPagesFormat($pagination,"memberAboutDetail");
        return json_encode(["data"=>$courseDataObj->models,'pages'=>$pages,"nowPage"=>$nowPage]);
    }
    /**
     * @api {get}  /site-management/cancel-member-about   会员取消预约
     * @apiVersion  1.0.0
     * @apiName     会员取消预约
     * @apiGroup    yardMemberCancel
     * @apiParam  {int}  id    //预约id
     *   GET   /site-management/cancel-member-about
     *   {
     *      id : 2,   // 会员预约id
     *   }
     * @apiDescription  会员取消预约
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/9/7
     * @apiSampleRequest  http://qa.uniwlan.com/site-management/cancel-member-about
     * @apiSuccessExample {json} 成功示例:
     *{
     *      "status"       :“success”,  // 预约成功（error）
     *      'data'         :'预约成功'   // 取消预约成功 （失败:返回失败信息）
     * };
     */
    public function actionCancelMemberAbout($id){
        $model   = new AboutYard();
        $result  = $model->cancelMemberAbout($id);
        if($result===true){
            return json_encode(["status"=>"success","message"=>"取消预约成功"]);
        }else{
            return json_encode(["status"=>"error","message"=>$result]);
        }
    }
    /**
     * @api {get}  /site-management/search-member   获取会员相关信息
     * @apiVersion  1.0.0
     * @apiName     获取会员相关信息
     * @apiGroup    yardMemberOrderDetail
     * @apiParam  {int}  mobile   //电话
     * @apiParam  {int}  yardId   //场地id
     * @apiParamExample {json} Request Example
     *   GET   /site-management/search-member
     *   {
     *      mobile: 15537312038,   // 电话
     *      yardId: 3,             // 场地id
     *   }
     * @apiDescription  获取会员相关信息
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/9/7
     * @apiSampleRequest  http://qa.uniwlan.com/site-management/search-member
     * @apiSuccessExample {json} 成功示例:
     *{
     *      "id"       :12,  // 会员id
     *       "username"   :会员姓名
     *       “mobile”: 15537312038，
     *        "memberCardId":23,
     *        "card_number":卡号，
     *        “card_name”:卡名称，
     * };
     */
    public function  actionSearchMember($mobile,$yardId){
        $model   = new AboutYard();
        $dataS    =  $model->searchMember($mobile,$yardId);
        if(empty($dataS)){
          return  json_encode(["status"=>"error","data"=>"会员不存在或已被冻结"]);
        }
          return json_encode(["status"=>"success","data"=>$dataS]);
    }
    /**
     * @api {get}  /site-management/member-yard-about   会员场地预约
     * @apiVersion  1.0.0
     * @apiName     会员场地预约
     * @apiGroup    yardMemberOrderDetail
     * @apiParam  {int}  yardId     //场地id
     * @apiParam  {int}  memberId  //会员id
     * @apiParam  {int}  memberCardId  //会员卡id
     * @apiParam  {string}  aboutIntervalSection //预约区间段
     * @apiParam  {string}  aboutDate    //预约日期
     * @apiParam  {string}  aboutObject  // 预约对象  验卡（memberCard） 潜在会员（potentialMember）
     * @apiParamExample {json} Request Example
     *   GET   /site-management/search-member
     *   {
     *      yardId: 2,   // 电话
     *      memberId: 12, //会员ID
     *      memberCardId：223, //会员卡id
     *      aboutIntervalSection:"12:54-16:40"， // 会员预约区间段
     *      aboutDate:"2017-02-18"   // 会员日期
     *      aboutObject:"potentialMember"  // 预约对象(潜在会员) 
     *   }
     * @apiDescription  获取会员相关信息
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/9/7
     * @apiSampleRequest  http://qa.uniwlan.com/site-management/search-member
     * @apiSuccessExample {json} 成功示例:
     *{
     *      "status"       :“success”,  // 预约成功
     *      'data'         :'预约成功'   //
     * };
     */
    public function actionMemberYardAbout(){
        $post = \Yii::$app->request->post();
        $post["aboutObject"] = (!isset($post["aboutObject"])||(empty($post["aboutObject"])))?"memberCard":$post["aboutObject"];
        $model    = new AddVenueYardForm();
        $model->setScenario('memberYardAbout');
        if($model->load($post,'') && $model->validate())
        {
            $result = $model->memberYardAbout($post["aboutObject"],$this->companyId);
            if($result===true){
                return json_encode(['status' => 'success','data' =>'预约成功']);
            }else{
                return json_encode(['status' => 'error','data' =>$result]);
            }
        }else{
            return json_encode(['status' => 'error','data' =>$model->errors]);
        }
    }
    /**
     * 场地预约 - 获取场地对应卡种
     * @create 2017/9/18
     * @param  $yardId     // 场地id
     * @author houkaixin<houkaixin@itsports.club>
     * @return object     // 返回场地卡种
     */
   public function actionCardCategory($yardId){
          $model = new VenueYard();
          $data  = $model->getYardCategory($yardId);
          return json_encode(['status' => 'error','data' =>$data]);
   }

    /**
     * 云运动 - 验卡列表 - 对应卡号是否能够预约
     * @author houkaixin<houkaixin@sports.club>
     * @create 2017/9/20
     * @param $yardId  // 场地id
     * @param $cardNum // 卡号
     * @return array|\yii\db\ActiveRecord[]
     */
   public function actionIsAboutYard($yardId="",$cardNum=""){
       $model = new VenueYard();
       $isCanAboutTheClass =  $model->judgeIsAboutTheCourse($yardId,$cardNum);
       return json_encode(['status'=>$isCanAboutTheClass]);
   }
    /**
     * 云运动 - 验卡 - 获取该会员所有的预约记录
     * @author houkaixin<houkaixin@sports.club>
     * @create 2017/9/20
     * @param $cardNum // 卡号
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionGetYardAboutRecord($cardNum = ""){
        $model = new VenueYard();
        $data  = $model->getVenueAllAboutRecord($this->venueId,$cardNum);
        $pages  = Func::getPagesFormat($data->pagination);

        return json_encode(["data"=>$data->models,"cardId"=>$model->cardId,'pages'=>$pages]);
    }
    /**
     * 云运动 - 场地 - 取消预约记录
     * @author houkaixin<houkaixin@sports.club>
     * @create 2017/9/20
     * @param $yardId // 场地id
     * @param $cardId  // 会员卡id
     * @param $intervalSection // 预约区间段
     * @param $memberAboutDate //预约日期
     * @param $memberId      // 会员id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionDealYardAboutClass($yardId="",$cardId="",$intervalSection = "",$memberAboutDate = "",$memberIdB = "",$memberIdT=""){
        $model = new VenueYard();
        $data  = $model->cancelYardAbout($yardId,$cardId,$intervalSection,$memberAboutDate,$memberIdB,$memberIdT);
        if(!empty($data)){
            return json_encode(["status"=>"success","message"=>"取消预约成功"]);
        }else{
            return json_encode(["status"=>"error","message"=>"取消预约失败"]);
        }
    }

    /**
     * 云运动 - 场地 - 取消预约记录
     * @author houkaixin<houkaixin@sports.club>
     * @create 2017/9/20
     * @param $id // 会员预约id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionCancelYardAboutClass($id){
        $model = new VenueYard();
        $data  =$model->cancelTheYardAbout($id);
        if($data===true){
            return json_encode(["status"=>"success","message"=>"取消预约成功"]);
        }else{
            return json_encode(["status"=>"error","message"=>"取消预约失败"]);
        }
    }
    


}
