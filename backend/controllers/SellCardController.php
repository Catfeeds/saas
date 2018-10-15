<?php
namespace backend\controllers;

use backend\models\Admin;
use backend\models\AuthRole;
use backend\models\CardCategory;
use backend\models\Member;
use backend\models\Order;
use Yii;
use common\models\Func;
use backend\models\SellCardForm;
use backend\models\GiftDay;
use backend\models\UpdateSellCardForm;
use yii\web\UnauthorizedHttpException;

class SellCardController extends BaseController
{
    /**
     * 云运动 - 售卡系统 - 潜在会员购卡
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/13
     * @return string
     */
    public function actionSellCard()
    {
//        if(!AuthRole::canRoleByAuth('sellCard','ADD')){
//            throw new UnauthorizedHttpException('抱歉，您没有权限添加，请联系管理员');
//        }
        $companyId = isset($this->companyId)?$this->companyId:0;
        $venueId   = isset($this->venueId)?$this->venueId:0;
        $post      = \Yii::$app->request->post();
        $model     = new SellCardForm();
        if ($model->load($post, '') && $model->validate()) {
            $model->loadCode();
            $data = $model->setSellCard($companyId,$venueId);
            if($data === true){
                $model->sendMessage();                             //售卡成功发送短信
                return json_encode(['status' => 'success', 'data' => '提交成功']);
            }else{
                return json_encode(['status' => 'error', 'data' =>$data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 云运动 - 售卡系统 - 会员购卡
     * @author 黄华 <huanghua@itsports.club>
     * @create 2017/8/11
     * @return string
     */
    public function actionUpdateSellCard()
    {
        $companyId = isset($this->companyId)?$this->companyId:0;
        $venueId   = isset($this->venueId)?$this->venueId:0;
        $post      = \Yii::$app->request->post();
        $model     = new UpdateSellCardForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->setSellCard($companyId,$venueId);
            if($data === true){
                $model->sendMessage();                             //售卡成功发送短信
                return json_encode(['status' => 'success', 'data' => '提交成功']);
            }else{
                return json_encode(['status' => 'error', 'data' =>$data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @云运动 - 售卡系统 - 生成验证码
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/15
     * @inheritdoc
     */
    public function actionCreateCode()
    {
        $mobile = \Yii::$app->request->post();

        if(!isset($mobile) && !isset($mobile['mobile'])){
            return json_encode(['status' => 'error', 'data' => '请填写正确的手机号']);
        }

        $code = mt_rand(100000,999999);
        $time = time();
        $temp = [
            'code'   => $code,
            'time'   => $time,
            'mobile' => $mobile['mobile']
        ];
        $session = \Yii::$app->session;
        $session->set('sms',$temp);
        Func::sendCode($mobile['mobile'],$code);
        return json_encode(['status'=>'success','data'=>$code]);
    }

    /**
     * @api {get} /sell-card/card-category 获取大上海售卖的卡种
     * @apiVersion 1.0.0
     * @apiName 获取大上海售卖的卡种
     * @apiGroup sell-card
     * @apiPermission 管理员
     *
     * @apiDescription 售卡管理 - 获取大上海售卖的卡种<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/15<br>
     * <span><strong>调用方法：</strong></span>/sell-card/card-category
     *
     * @apiSampleRequest  http://qa.uniwlan.com/sell-card/card-category
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
    public function actionCardCategory()
    {
        $venueId = \Yii::$app->request->get('venueId');
        if(!empty($venueId)){
            $cardCategory = SellCardForm::getCardCategory($venueId);
        }else{
            $cardCategory = SellCardForm::getCardCategory($this->venueId);
        }
        return json_encode($cardCategory);
    }

    /**
     * @云运动 - 会员管理 - 会员卡升级只能选择比老卡卡种价格高的新卡
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/10/1
     * @inheritdoc
     */
    public function actionNewCardCategory()
    {
        $oldCardCategory = \Yii::$app->request->get('oldCardCategory');
        $type = \Yii::$app->request->get('cardTypeId');
        $venueId = \Yii::$app->request->get('venueId');
        if(empty($venueId)){
            $venueId = $this->venueId;
        }
        $cardCategory = SellCardForm::getNewCardCategory($venueId,$oldCardCategory,$type);
        return json_encode($cardCategory);
    }
    
    /**
     * 云运动 - 会员管理 - 会员卡升级只能选择比老卡卡种价格高的新卡
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/10/1
     * @inheritdoc
     */
    public function actionAllCardCategory()
    {
        $oldCardCategory = \Yii::$app->request->get('oldCardCategory');
        $venueId = \Yii::$app->request->get('venueId');
        if(empty($venueId)){
            $venueId = $this->venueId;
        }
        $cardCategory = SellCardForm::getAllCardCategory($venueId,$oldCardCategory);
        return json_encode($cardCategory);
    }
    /**
     * @云运动 - 售卡系统 - 验证码手机号、身份证号、姓名是否匹配
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/20
     * @inheritdoc
     */
    public function actionSetData()
    {
        $mobile = \Yii::$app->request->get('mobile');
        $idCard = \Yii::$app->request->get('idCard');
        $name   = \Yii::$app->request->get('name');
        if(!empty($mobile) && !empty($idCard) && !empty($name)) {
            $model = new SellCardForm();
            $data = $model->setIdCard($mobile,$idCard,$name);
            if($data === true){
                return json_encode(['status' => 'success', 'data' => '匹配成功']);
            }else{
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        }
    }

    /**
     * @云运动 - 售卡系统 - 判断卡种售卖张数
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/22
     * @inheritdoc
     */
    public function actionSellNum()
    {
        $cardCateGoryId = \Yii::$app->request->get('cardCateGoryId');
        if(!empty($cardCateGoryId)) {
            $model = new SellCardForm();
            $data = $model->setSellNum($cardCateGoryId);
            if($data === true){
                return json_encode(['status' => 'success', 'data' => '成功']);
            }else{
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        }
    }

    /**
     * @api {get} /sell-card/get-all-card 根据名称查询卡种
     * @apiVersion 1.0.0
     * @apiName 根据名称查询卡种
     * @apiGroup sell-card
     * @apiPermission 管理员
     * @apiParam {string} keywords  输入的名称
     * @apiParam {string} sortType  排序字段
     * @apiParam {string} sortName  排序状态
     * @apiParamExample {json} Request Example
     * {
     *      'keywords' => 金爵,
     *      'sortType' => '',
     *     'sortName' => '',
     * }
     * @apiDescription 售卡管理 - 根据名称查询卡种<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/6<br>
     * <span><strong>调用方法：</strong></span>/sell-card/get-all-card
     *
     * @apiSampleRequest  http://qa.uniwlan.com/sell-card/get-all-card
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
    public function actionGetAllCard()
    {
        $id    = $this->nowBelongId;
        $type  = $this->nowBelongType;
        $model = new SellCardForm();
        $data  = $model->getAllCard($id,$type);
        return json_encode(['data' => $data]);
    }
    public function actionConfirmSellCard()
    {
        return json_encode(['status' => 'success','data'=>'已确定，正在购卡']);
    }
    public function actionConfirmDeposit()
    {
        return json_encode(['status' => 'success','data'=>'已确定，正在添加定金']);
    }
    public function actionLeaveRecord()
    {
        return json_encode(['status' => 'success','data'=>'正在撤销申请，请稍后']);
    }
    public function actionBatchDelWindow()
    {
        return json_encode(['status' => 'success','data'=>'正在删除']);
    }

    /**
     * @param $id
     * @return string
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionDelDeposit($id)
    {
        $deposit = \common\models\base\MemberDeposit::findOne(['id'=>$id]);
        if($deposit->delete()){
            return json_encode(['status' => 'success','data'=>'已确定，正在添加定金']);
        }
        return json_encode(['status' => 'success','data'=>'已确定，正在添加定金']);
    }
    /**
     * @api {get} /sell-card/selected-card 潜在会员购卡选中登记过的卡种
     * @apiVersion 1.0.0
     * @apiName 潜在会员购卡选中登记过的卡种
     * @apiGroup SellCard
     * @apiPermission 管理员
     * @apiParam {int} idCard  身份证号
     * @apiParamExample {json} Request Example
     * {
     *      'idCard' => 410121************,
     * }
     * @apiDescription 潜在会员购卡选中登记过的卡种<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/7/17<br>
     * <span><strong>调用方法：</strong></span>/sell-card/selected-card
     *
     * @apiSampleRequest  http://qa.uniwlan.com/sell-card/selected-card
     * @apiSuccess (返回值) {string} status 返回状态
     * @apiSuccess (返回值) {string} data   返回状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {[
     * {"data":"6"}
     * ]}
     *
     * @apiErrorExample {json} 错误示例:
     * {"data":null}
     */
    public function actionSelectedCard()
    {
        $idCard = \Yii::$app->request->get('idCard');
        $model = new Order();
        $data  =$model->selectedCard($idCard);
        return json_encode(['data' => $data]);
    }
    /**
     *后台潜在会员管理 - 潜在会员购卡 - 遍历赠送天数
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/10/13
     * @return bool|string
     */
    public function actionGivenDay()
    {
        $categoryId = \Yii::$app->request->get('categoryId');
        $adminId    = \Yii::$app->user->identity->id;
        $adminData  = Admin::findOne(['id'=>$adminId]);
        $roleId     = $adminData['level'];
        $model      = new GiftDay();
        $data       = $model->giftDayData($roleId,$categoryId);
        return json_encode(['data' => $data]);
    }
    /**
     *后台潜在会员管理 - 会员详情赠送天数 - 遍历赠送天数
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/10/13
     * @return bool|string
     */
    public function actionGivenMemberDay()
    {
        $adminId    = \Yii::$app->user->identity->id;
        $adminData  = Admin::findOne(['id'=>$adminId]);
        $roleId     = $adminData['level'];
        $model      = new GiftDay();
        $data       = $model->giftMemberDayData($roleId);
        return json_encode(['data' => $data]);
    }
    /**
     *后台会员管理 - 会员二次购卡 - 获取卡种的金额
     * @author Huang hua <huanghua@itsports.club>
     * @create 2018/1/2
     * @return bool|string
     */
    public function actionCardCategoryMoney()
    {
        $cardCategoryId    = \Yii::$app->request->get('cardCategory');
        $model      = new CardCategory();
        $data       = $model->getCardCategoryMoney($cardCategoryId);
        return json_encode(['data' => $data]);
    }

    /**
     * @desc: 业务后台 - 跨店签单- 判断会员信息是否重复
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/04/27
     * @return string
     */
    public function actionCheckBuyCard() {
        $data = \Yii::$app->request->post();
        if (isset($data['mobile']) || isset($data['venueId']) || isset($data['name'])) {
            if ($data['venueId'] == $this->venueId) {
                return json_encode(['status'=>'notBuyCard','message'=>'不是跨店签单']);
            }
            $re = Member::checkMobile($data);
            if ($re == 'allRepeat') {
                return json_encode(['status'=>'allRepeat','message'=>'手机号相同，且会员姓名相同']);
            }else if ($re == 'oneRepeat') {
                return json_encode(['status'=>'oneRepeat','message'=>'手机号相同，但会员姓名不同']);
            }else if ($re == 'noRepeat'){
                return json_encode(['status'=>'noRepeat','message'=>'不重复']);
            }
        }
    }
}