<?php
namespace backend\controllers;

use backend\models\CardCategory;
use backend\models\ChargeClass;
use backend\models\ChargeClassPeople;
use backend\models\MemberCard;
use backend\models\MemberPrivateGroupOrderForm;
use backend\models\PrivateGroupClassForm;
use backend\models\ChargeClassNumber;
use backend\models\ChargeGroupClass;
use backend\models\ChargeGroupClassForm;
use backend\models\PrivateGroupServerForm;
use common\models\Func;
use yii;
use backend\models\Member;
class PrivateLessonGroupController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionAddManyClassServer()
    {
        return $this->render('addManyClassServer');
    }
    public function actionAddManyClassLesson()
    {
        return $this->render('addManyClassLesson');
    }

    /*
     * 私教管理 - 私教小团体 - 获取私教小团体课信息
     * */
    public function actionChargeClass()
    {
        $params = Yii::$app->request->queryParams;
        $chargeClass = new ChargeClass();
        $chargeClassData = $chargeClass->searchGroup($params,$this->venueId,$this->companyId);
        $pagination = $chargeClassData->pagination;
        $pages          = Func::getPagesFormat($pagination,'classPageFun');
        return json_encode(['data'=>$chargeClassData->models,'pages'=>$pages]);
    }
    /*
     * 私教管理 - 私教小团体 - 新增表单模版
     * */
    public function actionAddTemplate($attr, $num=0)
    {
        $param = CardCategory::getTemplate($attr);
        $html = $this->renderPartial($param,['num'=>$num]);
        return json_encode(['html'=>$html]);
    }

    /*
     * 私教管理 - 私教小团体 - 添加课程
     * */
    public function actionAddGroupLesson()
    {
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $post = \Yii::$app->request->post();
        $model = new PrivateGroupClassForm();
        if ($model->load($post,'') && $model->validate()) {
            $data = $model->saveCharge($companyId,$venueId);
            if ($data === false) {
                return json_encode(['status' => 'error', 'data' => '添加失败']);
            }
            return json_encode(['status'=>'success','data'=>$data]);
        }else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @私教管理 - 私教小团体 - 添加服务
     * @author 付钟超 <fuzhongchao@itsports.club>
     * @create 2018/01/09
     */
    public function actionAddGroupServer()
    {
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $post = \Yii::$app->request->post();
        //print_r($post);
        $model = new PrivateGroupServerForm();

        if ($model->load($post,'') && $model->validate()) {
            $data = $model->saveCharge($companyId,$venueId);
            //var_dump($data);exit();
            if ($data === false) {
                return json_encode(['status' => 'error', 'data' => '添加失败']);
            }
            return json_encode(['status'=>'success','data'=>$data]);
        }else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @desc: 私教小团体-私教购买-私教课程价格区间
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/01/11
     * @return string
     */
    public function actionGetLessonLimit()
    {
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $chargeId = Yii::$app->request->get();
        $model = new ChargeClassNumber();
        $data = $model->getPriceLimit($chargeId,$venueId);
        return json_encode($data);
    }

    /**
     * @desc: 私教小团体-私课购买-私教服务价格区间
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/01/11
     * @return string
     */
    public function actionGetServerLimit()
    {
        $venueId = $this->venueId;
        $chargeId = Yii::$app->request->get();
        $model = new ChargeClassNumber();
        $data = $model->getServerLimit($chargeId,$venueId);
        return json_encode($data);
    }

    /**
     * @desc: 私课小团体-私课购买-私教课程购买保存
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/01/12
     * @return string
     * @throws yii\db\Exception
     */
    public function actionSaveMemberCharge()
    {
        $post = Yii::$app->request->post();
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $post['venueId'] = $venueId;
        $post['companyId'] = $companyId;
        $model = new MemberPrivateGroupOrderForm();
        if ($model->load($post,'') &&$model->validate()) {
            $data = $model->addPrivateGroupLesson();
            if ($data === 'repeatBuy') {
                return json_encode(['status' => 'error', 'data' => '此套产品已购买,请购买下一套!']);
            }
            return json_encode(['status'=>'success','data'=>$data]);
        }else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }

    }

    /**
     * @desc: 私教小团体-私课购买-获取产品表信息
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/01/12
     * @return string
     */
    public function actionGetChargeInfo()
    {
        $peopleId = \Yii::$app->request->get();
        $ccl = new ChargeClassPeople();
        $data = $ccl->getChargeInfo($peopleId);
        return json_encode($data);
    }
    /**
     * @私教小团体课 - 获取私教排课列表
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/03
     * @return array|string
     */
    public function actionArrangeClassList()
    {
        $params     = \Yii::$app->request->queryParams;
        $model      = new ChargeClassNumber();
        $data       = $model->arrangeClassList($params);
        $pagination = $data->pagination;
        $pages      = Func::getPagesFormat($pagination,'arrangeClassPages');
        return json_encode(['data'=>$data->models,'pages'=>$pages]);
    }

    /**
     * @私教小团体课 - 排课 - 判断课程是否已上完或排完
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/10
     * @return array|string
     */
    public function actionIsOverClass()
    {
        $id     = \Yii::$app->request->get('classNumId');
        $date   = \Yii::$app->request->get('date');
        $model  = new ChargeClassNumber();
        $result = $model->isOverClass($id,$date);
        return json_encode(['data' => $result]);
    }

    /**
     * @私教小团体课 - 排课 - 获取这是第几节课
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/11
     * @return array|string
     */
    public function actionGetEndTime()
    {
        $id       = \Yii::$app->request->get('classNumId');
        $dayStart = \Yii::$app->request->get('dayStart');
        $model    = new ChargeClassNumber();
        $result   = $model->getEndTime($id,$dayStart);
        return json_encode($result);
    }

    /**
     * @私教小团体课 - 保存排课信息
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/04
     * @return array|string
     */
    public function actionAddArrangeClass(){
        $post  = \Yii::$app->request->post();
        $model = new ChargeGroupClassForm();
        if($model->load($post,'') && $model->validate()) {
            $result = $model->addArrangeClass($this->companyId,$this->venueId);
            if($result === true){
                return json_encode(['status' => 'success','data' => '保存成功']);
            }else{
                return json_encode(['status' => 'error','data' => $result]);
            }
        }else{
            return json_encode(['status' => 'error','data' => $model->errors]);
        }
    }

    /**
     * @私教小团体课 - 获取本周课程表数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/04
     * @return array|string
     */
    public function actionChargeGroupClass()
    {
        $params = \Yii::$app->request->queryParams;
        $model  = new ChargeGroupClass();
        $result = $model->getClassData($params);
        return json_encode($result);
    }

    /**
     * @私教小团体课 - 获取下周课程表数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/09
     * @return array|string
     */
    public function actionWeekDataNext()
    {
        $data   = \Yii::$app->request->get();
        $model  = new ChargeGroupClass();
        $result = $model->initData($data);
        return json_encode($result);
    }

    /**
     * @私教小团体课 - 获取私教上课列表数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/04
     * @return array|string
     */
    public function actionAttendClassList()
    {
        $data       = \Yii::$app->request->queryParams;
        $model      = new ChargeGroupClass();
        if(isset($params['page'])){
            $nowPage = $params['page'];
        }else{
            $nowPage = 1;
        }
        $query      = $model->attendClassList($data);
        $data       = $model->getSumData($query);
        $aboutNum   = $model->getSumDataMoney($query);
        $pagination = $data->pagination;
        $pages      = Func::getPagesFormat($pagination);
        return json_encode(['data'=>$data->models,'pages'=>$pages,'aboutNum'=>$aboutNum,'now'=>$nowPage]);
    }

    /**
     * @私教小团体课 - 获取某一课程信息
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/06
     * @return array|string
     */
    public function actionOneClassData()
    {
        $id     = \Yii::$app->request->get('chargeGroupId');
        $model  = new ChargeGroupClass();
        $result = $model->oneClassData($id);
        return json_encode($result);
    }

    /**
     * @私教小团体课 - 获取预约详情
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/06
     * @return array|string
     */
    public function actionAboutDetail()
    {
        $id     = \Yii::$app->request->get('chargeGroupId');
        $model  = new ChargeGroupClass();
        $result = $model->aboutDetail($id);
        return json_encode($result);
    }

    /**
     * @私教小团体课 - 取消课程
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/06
     * @return array|string
     */
    public function actionCancelClass()
    {
        $id     = \Yii::$app->request->get('chargeGroupId');
        $model  = new ChargeGroupClass();
        $result = $model->cancelClass($id);
        if($result == true){
            return json_encode(['status'=> 'success','data' => '操作成功']);
        }else{
            return json_encode(['status'=> 'error','data' => '操作失败']);
        }
    }

    /**
     * @私教小团体课 - 登记上课
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/06
     * @return array|string
     */
    public function actionRegisterClass()
    {
        $id     = \Yii::$app->request->get('chargeGroupId');
        $model  = new ChargeGroupClass();
        $result = $model->registerClass($id);
        if($result === true){
            return json_encode(['status'=> 'success','data' => '操作成功']);
        }else{
            return json_encode(['status'=> 'error','data' => $result]);
        }
    }

    /**
     * @私教小团体课 - 会员下课打卡
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/06
     * @return array|string
     */
    public function actionOverClass()
    {
        $aboutId = \Yii::$app->request->get('aboutId');
        $model   = new ChargeGroupClass();
        $result  = $model->overClass($aboutId);
        if($result == true){
            return json_encode(['status'=> 'success','data' => '操作成功']);
        }else{
            return json_encode(['status'=> 'error','data' => '操作失败']);
        }
    }

    /**
     * @私教小团体课 - 提前下课
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/09
     * @return array|string
     */
    public function actionAdvanceClass()
    {
        $id     = \Yii::$app->request->get('chargeGroupId');
        $model  = new ChargeGroupClass();
        $result = $model->advanceClass($id);
        if($result == true){
            return json_encode(['status'=> 'success','data' => '操作成功']);
        }else{
            return json_encode(['status'=> 'error','data' => '操作失败']);
        }
    }
    public function actionCheckMemberInfo()
    {
        $cardNumber = \Yii::$app->request->get('cardNumber');
        $model = new MemberCard();
        $data = $model->checkMemberInfo($cardNumber,$this->venueId);
        if ($data) {
            $data['current_time'] = time();
            return json_encode(['status'=>'success','data'=>$data]);
        }
        return json_encode(['status'=>'error','data'=>$data]);
    }

    /**
     * @desc: 业务后台 - 获取场馆数据 - 根据公司id
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/15
     * @return string
     */
    
    public function actionGetAuthVenue()
    {
        if (\Yii::$app->user->identity->level == 0) {
            //管理员,不能新增数据,场馆选择返回空
            return json_encode(['status'=>'error','data'=>[]]);
        }
        //根据公司获取场馆
        $data = \common\models\Organization::find()->select('id,name,pid')->where(['and',['style'=>2],['is_allowed_join'=>1]])->andWhere(['pid'=>$this->companyId])->asArray()->all();
        return json_encode(['status'=>'success','data'=>$data]);
    }
}
