<?php
namespace backend\controllers;
use backend\models\Employee;
use backend\models\ExcelTransferCardForm;
use backend\models\Member;
use backend\models\MemberCourseOrder;
use backend\models\Organization;
use backend\models\SwimExcel;
use backend\models\PrivateExcel;
use backend\models\AboutClass;
use backend\models\CabinetExcel;
use backend\models\ExcelAiBoMember;
use backend\models\ExcelCharge;
use backend\models\ExcelChargeClass;
use backend\models\ExcelMemberLeave;
use backend\models\ExcelMemberNumber;
use backend\models\ExcelOperate;
use backend\models\ExcelTransfer;
use backend\models\MemberCard;
use backend\models\TransferCardForm;
use backend\models\UploadXslForm;
use common\models\base\CardCategory;
use common\models\base\Order;
use common\models\Excel;
use common\models\WipeData;
use console\controllers\DealController;
use yii\web\UploadedFile;
use yii;

class ExcelController extends BaseController
{
    /**
     * 云运动 - 数据导入 - 导入会员信息
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports>
     * @param  $pathFile
     * @param  $type
     * @param  $name
     * @param $attr
     * @return bool
     */
    public function actionIndex($pathFile,$type = '大上海',$name = '大上海瑜伽健身馆',$attr = 'one'){
        set_time_limit(0);
        $model = new ExcelOperate();
        $data = $model->loadFile($pathFile,$type,$name,$attr);
        if($data === true){
            return  true;
        }else{
            return  $data;
        }
    }
    /**
     * 云运动 - 数据导入 - 导入会员信息
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports>
     * @param  $pathFile
     * @return bool
     */
    public function actionSetMemberCardNumber($pathFile = null){
        set_time_limit(0);
        $model = new ExcelMemberNumber();
        $data = $model->loadFileMemberNumber($pathFile);
        if($data === true){
            return  true;
        }else{
            return  json_encode($data);
        }
    }
    /**
     * 云运动 - 数据导入 - 上传xls
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports>
     * @return bool
     */
    public function actionUpload()
    {
        ini_set('memory_limit','1024M');
        $upload = new UploadXslForm();
        if (\Yii::$app->request->isPost) {
            $upload->xslFile = UploadedFile::getInstance($upload, 'xslFile');
            if ($upload->xslFile && $upload->xslFile->type == "application/vnd.ms-excel") {
                $post = Yii::$app->request->post();
                $type = $post['text'];
                $name = $post['name'];
                $attr = isset($post['attr'])?$post['attr']:'one';
                $file = $this->actionIndex($upload->xslFile->tempName,$type,$name,$attr);
                if($file === true){
                    return json_encode(['status' => 'success','data' => '导入成功']);
                }else{
                    return json_encode(['status' => 'error','data' => $file]);
                }
            }else{
                return json_encode(['status' => 'error', 'data' =>'导入失败']);
            }
        }
        return json_encode(['status' => 'error', 'data' =>'导入失败']);
    }
    /**
     * 云运动 - 数据导入 - 私教数据导入
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports>
     * @return bool
     */
    public function actionExcelCharge(){
        set_time_limit(0);
        $upload = new UploadXslForm();
        if (\Yii::$app->request->isPost) {
            $upload->xslFile = UploadedFile::getInstance($upload, 'xslFile');
            if ($upload->xslFile && $upload->xslFile->type == "application/vnd.ms-excel") {
                $file = $this->actionPrivateIndex($upload->xslFile->tempName);
                if($file === true){
                    return json_encode(['status' => 'success','data' => '导入成功']);
                }else{
                    return json_encode(['status' => 'error','data' => $file]);
                }
            }else{
                return json_encode(['status' => 'error', 'data' =>'导入失败']);
            }
        }
         return false;
    }
    /**
     * 云运动 - 数据导入 - 导入私教信息
     * @create 2017/5/20
     * @param  $path    //文件路径
     * @param  $type    //场馆
     * @param  $name    //场馆名字
     * @author houkaixin <houkaixin@itsports>
     * @return bool
     */
    public function actionPrivateIndex($type = '大上海',$name = '大上海瑜伽健身馆'){
        set_time_limit(0);
        $model = new ExcelCharge();
        $data = $model->loadFile("C:/666.xls","chargeClassList",$type,$name);
        if($data === true){
            return "文件导入成功";
        }else{
            return  $data;
        }
    }
//    public function actionPrivateIndex(){
//        set_time_limit(0);
//        $model = new ExcelCharge();
//        $data = $model->loadFile("C:\c.xls");
//        if($data === true){
//            return  true;
//        }else{
//            return  $data;
//        }
//    }
    /**
     * 云运动 - 修改 - 批量修改卡种类型
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports>
     * @return bool
     */
    public function actionUpdateCard()
    {
       $card = CardCategory::updateAll(['category_type_id'=>1]);
       if($card){
           return true;
       }
        return false;
    }
    /**
     * 云运动 - 修改 - 批量修改会员激活
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports>
     * @return bool
     */
    public function actionUpdateMemberCard()
    {
        $card  = MemberCard::updateAll(['status'=>1]);
//        $cards = MemberCard::updateAll(['active_time'=>'create_at']);
        $query = Yii::$app->db->createCommand("UPDATE cloud_member_card SET active_time = create_at")->execute();
        if($card){
            return true;
        }
        return false;
    }
    /**
     * 云运动 - 修改 - 批量修改会员激活
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports>
     * @return bool
     */
    public function actionSetBinkTowel()
    {
        $bink = new WipeData();
        $pack = $bink->setCardTowel();
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改会员进场管次数问题
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports>
     * @return bool
     */
    public function actionSetLimitTimes()
    {
        $pack = WipeData::setLimitTimes();
        return $pack;
    }
    /**
     * 云运动 - 修改 - 批量修改私教排课
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionDelChargeAbout()
    {
        $about = AboutClass::deleteAll(['type'=>1]);
        return $about;
    }
    /**
     * 云运动 - 修改 - 批量修改私教排课
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionUpdateChargeDate()
    {
        $time = time() + 180*(24*60*60);
        $about = MemberCourseOrder::updateAll(['deadline_time'=>$time],['and',['>=','deadline_time',2364825600],['<=','deadline_time',2364911999]]);
        return $about;
    }
    /**
     * 云运动 - 修改 - 批量修改私教排课
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionUpdateMemberCardDate()
    {
        $about = MemberCard::updateAll(['transfer_num'=>1,'surplus'=>1],['and',['<=','active_time',strtotime('2017-06-01 00:00:00')],['company_id'=>75]]);
        return $about;
    }
    public function actionUpdateMemberCardOne()
    {
        $about = MemberCard::updateAll(['card_type'=>1],['card_number'=>20701122]);
        return $about;
    }
    /**
     * 云运动 - 修改 - 批量修改私教排课
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionUpdateMemberCardTimes()
    {
        MemberCard::updateAll(['total_times'=>12,'consumption_times'=>0,'card_type'=>2],['and',['card_name'=>'ERTG提高班'],['company_id'=>75]]);
        MemberCard::updateAll(['total_times'=>12,'consumption_times'=>0,'card_type'=>2],['and',['card_name'=>'ETCJ初级班'],['company_id'=>75]]);
        MemberCard::updateAll(['total_times'=>12,'consumption_times'=>0,'card_type'=>2],['and',['card_name'=>'ETQS亲水班'],['company_id'=>75]]);
        MemberCard::updateAll(['total_times'=>24,'consumption_times'=>0,'card_type'=>2],['and',['card_name'=>'ERCJ-Y包月班'],['company_id'=>75]]);
    }
    /**
     * 云运动 - 修改 - 批量修改私教排课
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionUpdateCardTimes()
    {
        $about = MemberCard::updateAll(['consumption_times'=>0],['venue_id'=>76]);
        return $about;
    }
    /**
     * 云运动 - 修改 - 批量修改私教排课
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionUpdateMemberCardTransfer()
    {
        $about = MemberCard::updateAll(['transfer_num'=>1,'transfer_price'=>400,'card_category_id'=>'738','surplus'=>1],['and',['venue_id'=>12,'card_name'=>'PT12 SD'],['IS','surplus',null]]);
        return $about;
    }
    /**
     * 云运动 - 修改 - 批量修改会籍顾问
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionUpdateMemberEmployeeId()
    {
        $about = WipeData::setMemberEmployee();
        return $about;
    }
    /**
     * 云运动 - 修改 - 批量修改会员激活
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionSetMemberInputData()
    {
        $bink = new WipeData();
        $pack = $bink->setMemberBatchData();
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改会员激活
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionSetCardApply()
    {
        $pack = WipeData::setApplyCard();
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改潜在会员为正式会员
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionSetMemberById()
    {
        $pack = WipeData::setMemberTypeByCardId();
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量更换场馆
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionSetVenueInCompany()
    {
        $pack = WipeData::setVenueInCompany();
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改合并会员
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionMergeMemberTwo($mid,$cid)
    {
        $pack = WipeData::setMergeMember($mid,$cid);
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改续费升级卡种问题
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionSetRenewMemberCard()
    {
        $pack = WipeData::setRenewMemberCard();
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改潜在会员为正式会员
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionSetDanceByMember()
    {
        $pack = WipeData::setMemberDanceByMember();
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改潜在会员为正式会员
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionSetSendCard()
    {
        $pack = WipeData::setSendCard();
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量瑜伽馆会员
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionSetDanceMemberLimit($key = '0950')
    {
        if($key == '0950'){
            $type = 2;
        }else if($key == '0710' || $key == '0610'){
            $type = 3;
        }else{
            $type = 1;
        }
        $pack = WipeData::getMemberDanceData($key.'%',$type);
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改无进场管权限的问题
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionUpdateMemberCardLimitData($number)
    {
        $pack = WipeData::updateMemberCardLimitData($number);
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改账号
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionUpdateAccountNumber()
    {
        $pack = WipeData::updateAccountNumber();
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改账号
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionUpdateAccountDeleteNumber()
    {
        $pack = WipeData::updateAccountDeleteNumber();
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 转移会员卡
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionUpdateTransferCard()
    {
        $post  = \Yii::$app->request->get();
        $companyId = 1;
        $venueId   = $this ->venueId;
        $model = new ExcelTransferCardForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->saveTransferCard($companyId,$venueId);
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
     * 云运动 - 修改 - 批量修改私教到期日期
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionUpdateChargeTime()
    {
        $pack = WipeData::updateChargeTime();
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改私教到期日期
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionExcelTrainingPeriod()
    {
        $pack = WipeData::excelTrainingPeriod();
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改亚星店会员日期
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionUpdateYaXiChargeTime()
    {
        $pack = WipeData::updateYaMemberCardTime();
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改升级无卡种金额信息
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionSetMemberCardUpgradeByPrice()
    {
        $pack =   WipeData::delMemberCardHistoryRecord();
//        $pack = WipeData::getMemberCardByPrice();
        return json_encode($pack);
    }
    /**
     * @云运动 - 后台 - 导出订单EXCEL表
     * @author Jiao Bingyang <jiaobingyang@itsports.club>
     * @create 2017/12/8
     * @return string   //查询结果
     */
    public function actionGetOrderExcel($data,$type = null)
    {
        $member = Member::find()->select('mobile')
            ->groupBy('mobile')
            ->having('count(*)>1')
            ->andFilterWhere(['member_type'=>$type])
            ->where(['venue_id'=>$data['id']])->asArray()->all();
        foreach($member as $k=>$v){
            $zCount               = Member::find()->where(['mobile'=>$v['mobile'],'venue_id'=>$data['id'],'member_type'=>1])->count();
            $mCount               = Member::find()->where(['mobile'=>$v['mobile'],'venue_id'=>$data['id'],'member_type'=>2])->count();
            $member[$k]['mobile'] = $v['mobile'];
            $member[$k]['mCount'] = $mCount;
            $member[$k]['zCount'] = $zCount;
//                    $member[$k]['name']   = $v['name'];
        }
        \moonland\phpexcel\Excel::export([
            'models'   =>  $member,
            'fileName' =>  $data['name'],
            'columns'  =>  [ 'mobile','mCount','zCount'],//,'name'
            'headers'  =>  [
                'mobile'       => '手机号',
                'mCount'       => '潜在数量',
                'zCount'       => '正式数量',
//                        'name'       => '姓名',
            ]
        ]);
    }
    /**
     * @云运动 - 后台 - 导出订单EXCEL表
     * @author Jiao Bingyang <jiaobingyang@itsports.club>
     * @create 2017/12/8
     * @return string   //查询结果
     */
    public function actionGetOrderExcelArr($id)
    {
        $orArr  = Organization::find()->select('id,name,pid')->where(['id'=>$id])->asArray()->one();
        $this->actionGetOrderExcel($orArr);
    }
    /**
     * @云运动 - 后台 - 导出订单EXCEL表
     * @author Jiao Bingyang <jiaobingyang@itsports.club>
     * @create 2017/12/8
     * @return string   //查询结果
     */
    public function actionGetOrderExcelMemberArr($id,$type = 1)
    {
        $orArr  = Organization::find()->select('id,name,pid')->where(['id'=>$id])->asArray()->one();
        $this->actionGetOrderExcel($orArr,$type);
    }
    /**
     * 云运动 - 修改 - 批量修改卡种类型
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionUpdateMemberCardType()
    {
        $pack =   WipeData::updateMemberCardType();
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改卡种类型
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionUpdateMemberCourseOrderStatus()
    {
        $order =  Order::find()->where(['consumption_type'=>'charge','status'=>5])->asArray()->all();
        $pack  = 0;
        foreach ($order as $v){
            $pack  =  \common\models\base\MemberCourseOrder::updateAll(['pay_status'=>2],['id'=>$v['consumption_type_id']]);
        }
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改私教课量
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionSetCourseNum()
    {
        $pack = WipeData::setCourseNum();
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改会员激活
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionSetCardZunApply()
    {
        $pack = WipeData::setApplyZunCard();
        return json_encode($pack);
    }
    /**
     * 云运动 - 修改 - 批量修改会员激活
     * @create 2017/5/16
     * @author lihuien <lihuien@itsports.club>
     * @return bool
     */
    public function actionSetCardVenue()
    {
        $pack = WipeData::setMemberVenue();
        return json_encode($pack);
    }
    /**
     * 云运动 - 数据导入 - 导入会员手机号等信息
     * @author huangpengju <huangpengju@itsports>
     * @create 2017/5/24
     * @param $pathFile
     * @param string $type
     * @return bool|string
     */
    public function actionSetMemberInfo($pathFile,$type = '大上海'){
        set_time_limit(0);
        $model = new ExcelCharge();
        $data = $model->memberInfoFile($pathFile,$type);
        if($data === true){
            return  true;
        }else{
            return  $data;
        }
    }
    /**
     * 云运动 - 数据导入 - 导入会员手机号等信息
     * @author huangpengju <huangpengju@itsports>
     * @create 2017/5/25
     * @return string
     */
    public function actionUploads()
    {
        ini_set('memory_limit','1024M');
        $upload = new UploadXslForm();
        if (\Yii::$app->request->isPost) {
            $upload->xslFile = UploadedFile::getInstance($upload, 'xslFile');
            if ($upload->xslFile && $upload->xslFile->type == "application/vnd.ms-excel") {
                $post = Yii::$app->request->post();
                $type = $post['text'];
//                $name = $post['name'];
//                $attr = isset($post['attr'])?$post['attr']:'one';
                $file = $this->actionSetMemberInfo($upload->xslFile->tempName,$type);
                if($file === true){
                    return json_encode(['status' => 'success','data' => '导入成功']);
                }else{
                    return json_encode(['status' => 'error','data' => $file]);
                }
            }else{
                return json_encode(['status' => 'error', 'data' =>'导入失败']);
            }
        }
        return json_encode(['status' => 'error', 'data' =>'导入失败']);
    }

    public function actionSetMemberCardName()
    {
        $wipe = WipeData::getMemberCardNoName();
        return $wipe;
    }
    public function actionSetMemberCompany()
    {
        $wipe = WipeData::getMemberCompany();
        return $wipe;
    }
    /**
     * 云运动 - 数据导入 - 导入柜子租用信息（衣柜租用2008-2017.xls）
     * @create 2017/6/18
     * @param  $path  // 文件路径
     * @param $type  //场馆名称
     * @param $name  // 场馆二级名称
     * @author houkaixin <houkaixin@itsports>
     * @return bool
     */
    public function actionCabinetIndex($path,$type = '大上海',$name = '大上海瑜伽健身馆'){
        set_time_limit(0);
        $model = new CabinetExcel();
        $data = $model->loadFile($path,$type,$name);
        if($data === "文件导入成功"){
            return  "文件导入成功";
        }else{
            return  $data;
        }
    }
    /**
     * 云运动 - 数据导入 - 衣柜到期租用清单（衣柜到期清单2008-2017）
     * @create 2017/6/18
     * @author houkaixin <houkaixin@itsports>
     * @return bool
     */
    public function actionCabinetExpire(){
        set_time_limit(0);
        $model = new CabinetExcel();
        $data = $model->loadCabinetExpireFile("C:/cabinetDaoQi.xls");
        if($data === true){
            return  true;
        }else{
            return  $data;
        }
    }
    /**
     * 云运动 - 数据导入 - 会员请假表数据导入
     * @create 2017/6/18
     * @param  $path   // 路径
     * @param  $type  // 场馆名称
     * @param  $name  // 场馆 erji1名称
     * @author houkaixin <houkaixin@itsports>
     * @return bool
     */
    public function actionMemberLeave($path,$type = '大上海',$name = '大上海瑜伽健身馆'){
        set_time_limit(0);
        $model = new ExcelMemberLeave();
        $data = $model->loadMemberLeave($path,$type,$name);
            if($data === true){
            return  true;
        }else{
            return  $data;
        }
    }
    /**
     * 云运动 - 数据导入 - 导入会员卡转让记录
     * @author huangpengju <huangpengju@itsports>
     * @create 2017/6/21
     * @return string
     */
    public function actionSetMemberCardTransfer()
    {
        $model = new ExcelCharge();
        $model->setMemberCardTransfer('C:\transfer.xls','transfer');      //路径是数据存放在C盘，‘transfer’表示是转让记录
    }
    /**
     * @云运动 - 数据导入 - 艾博会员私课数据（2017-5-17剩余课时查询.xls）
     * @author 朱夢珂 <zhumengke@itsports.club>
     * @create 2017/7/4
     * @return string
     */
    public function actionSurplusPrivate()
    {
        set_time_limit(0);
        $model = new PrivateExcel();
        $model->loadFile("C:/surplus.xls",'private');
    }
    /**
     * @云运动 - 数据导入 - 艾博游泳数据（爱博游泳班(1).xls）
     * @author 朱夢珂 <zhumengke@itsports.club>
     * @create 2017/7/4
     * @return string
     */
    public function actionSwimData()
    {
        set_time_limit(0);
        $model = new SwimExcel();
        $model->loadFile("C:/swim.xls",'private');
    }

    public function actionPrivateClassRecord($type = '大上海',$name = '大上海瑜伽健身馆'){
        set_time_limit(0);
        $model = new ExcelChargeClass();
        $data = $model->chargeClassFile("C:/chargeClass.xls",$type,$name);
        if($data===true){
            return "文件导入成功";
        }else{
            return "文件导入失败";
        }
    }

    public function actionPrivateEndTime($type = '大上海',$name = '大上海瑜伽健身馆'){
        set_time_limit(0);
        $model = new ExcelCharge();
        $data  = $model->loadFile("C:/chargeEndTime.xls","charge",$type,$name);
        if($data===true){
            return "文件导入成功";
        }else{
            return "文件导入失败";
        }
    }
    /**
     *员工管理 - 搜索条件 - 员工公司id和场馆id获取修改
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/24
     * @return bool|string
     */
    public  function actionUpdateStatus()
    {
        $model           = new WipeData();
        $status          = $model->getEmployee();
        if($status === true){
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        }else{
            return json_encode(['status' => 'error', 'data' =>$status]);
        }

    }
    /**
     *会员管理 - 会员详情 - 续费记录到期时间
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/10/23
     * @return bool|string
     */
    public  function actionUpdateDueTime()
    {
        $model           = new WipeData();
        $status          = $model->consumptionUpdate();
        if($status === true){
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        }else{
            return json_encode(['status' => 'error', 'data' =>$status]);
        }

    }
    /**
     *会员管理 - 会员详情 - 会员头像
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/11/29
     * @return bool|string
     */
    public  function actionUpdateMemberPic()
    {
        $model           = new WipeData();
        $status          = $model->memberPicUpdate();
        if($status === true){
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        }else{
            return json_encode(['status' => 'error', 'data' =>$status]);
        }

    }
    /**
     *会员管理 - 会员状态 - 没有会员卡的会员批量修改把会员变为潜在会员
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/10/23
     * @return bool|string
     */
    public  function actionUpdateMemberStatus()
    {
        $model           = new WipeData();
        $status          = $model->memberUpdate();
        if($status === true){
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        }else{
            return json_encode(['status' => 'error', 'data' =>$status]);
        }

    }
    /**
     *会员管理 - 会员列表详情 - 消费记录批量修改花丹店场馆id
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/10/23
     * @return bool|string
     */
    public  function actionUpdateMemberVenueId()
    {
        $model           = new WipeData();
        $status          = $model->venueUpdate();
        if($status === true){
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        }else{
            return json_encode(['status' => 'error', 'data' =>$status]);
        }

    }

    /**
     *会员管理 - 会员列表详情 - 会员卡场馆id批量插入
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/10/23
     * @return bool|string
     */
    public  function actionMemberCardVenueId()
    {
        $model           = new WipeData();
        $status          = $model->venueCardUpdate();
        if($status === true){
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        }else{
            return json_encode(['status' => 'error', 'data' =>$status]);
        }

    }
    /**
     *请假管理 - 请假列表 - 批量修改请假状态 区分请假类型和状态
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/1/30
     * @return bool|string
     */
    public  function actionUpdateLeaveRecord()
    {
        $model           = new WipeData();
        $status          = $model->leaveRecordData();
        if($status === true){
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        }else{
            return json_encode(['status' => 'error', 'data' =>$status]);
        }

    }

    /**
     *请假管理 - 请假列表 - 批量修改请假类型
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/1/30
     * @return bool|string
     */
    public  function actionUpdateLeaveProperty()
    {
        $model           = new WipeData();
        $status          = $model->updateLeaveRecord();
        if($status === true){
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        }else{
            return json_encode(['status' => 'error', 'data' =>$status]);
        }

    }
    /**
     * 会员管理 - 会员详情 - 批量修改会员卡状态
     * @author Huang hua <huanghua@itsports.club>
     * @create 2018/5/8
     * @return bool|string
     */
    public  function actionUpdateCardStatus()
    {
        ini_set("memory_limit","300M");
        set_time_limit(0);
        $venueId         = \Yii::$app->request->get('venueId');
        $model           = new WipeData();
        $status          = $model->updateCardStatus($venueId);
        if($status === true){
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        }else{
            return json_encode(['status' => 'error', 'data' =>$status]);
        }

    }
    /**
     * 公共管理 -会员卡绑定套餐 - 批量插入
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/2/3
     * @return bool|string
     */
    public  function actionInsertBindMemberCard()
    {
        ini_set("memory_limit","300M");
        set_time_limit(0);
        $venueId = \Yii::$app->request->get('venueId');
        $model           = new WipeData();
        $status          = $model->insertBind($venueId);
        if($status === true){
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        }else{
            return json_encode(['status' => 'error', 'data' =>$status]);
        }

    }
//    /**
//     *会员管理 - 会员列表详情 - 消费记录场馆id批量插入
//     * @author Huang hua <huanghua@itsports.club>
//     * @create 2017/10/23
//     * @return bool|string
//     */
//    public  function actionConsumptionVenueId()
//    {
//        $model           = new WipeData();
//        $status          = $model->ConsumptionUpdateData();
//        if($status === true){
//            return json_encode(['status' => 'success', 'data' => '修改成功']);
//        }else{
//            return json_encode(['status' => 'error', 'data' =>$status]);
//        }
//
//    }

    /**
     *请假管理 - 请假 - 学生请假改变状态
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/1/19
     * @return bool|string
     */
    public  function actionStudentLeave()
    {
        $model = new WipeData();
        $status = $model->studentUpdateData();
        if($status === true){
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        }else{
            return json_encode(['status' => 'error', 'data' =>$status]);
        }
    }
    /**
     *会员管理 - 会员列表详情 - 消费记录场馆id批量插入
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/10/23
     * @return bool|string
     */
    public  function actionConsumptionVenueId()
    {
        $venueId = \Yii::$app->request->get('venueId');
        $model           = new WipeData();
        $status          = $model->ConsumptionUpdateData($venueId);
        if($status === true){
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        }else{
            return json_encode(['status' => 'error', 'data' =>$status]);
        }

    }
    
    public function actionMemberTransfer()
    {
        $model = new ExcelTransfer();
        $model->setMemberTransfer('C:\memberTransfer.xlsx','memberTransfer');
    }
    /**
     *请假 - 爱博请假excel - 爱博请假excel导入
     * @author houkaixin <houkaixin@itsports.club>
     * @param  $path    // 文件路径
     * @param $type     // 场馆
     * @param $name     // 场馆具体名字
     * @create 2017/7/3
     * @return bool|string
     */
    public function actionAiBoMemberLeave($path,$type = '爱博',$name = '爱博健身馆'){
        set_time_limit(0);
        $model = new ExcelMemberLeave();
        $data = $model->loadAiBoMemberLeave($path,$type,$name,null);
        if($data === true){
            return  "导入成功";
        }else{
            return  $data;
        }
    }

    /**
     *请假 - 爱博请假excel - 会员请假挂起
     * @author houkaixin <houkaixin@itsports.club>
     * @param $path     // 文件路径
     * @param $type     // 场馆
     * @param $name     // 场馆具体名字
     * @create 2017/7/10
     * @return bool|string
     */
    public function actionAiBoMemberHangUp($path,$type = '爱博',$name = '爱博健身馆'){
        set_time_limit(0);
        $model = new ExcelMemberLeave();
        $data = $model->loadAiBoMemberLeave($path,$type,$name,"exist");
        if($data === true){
            return  "导入成功";
        }else{
            return  $data;
        }
    }
    /**
     * 所有场馆老卡 - 所有场馆老卡绑定生日课程（老会员绑定生日课）
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/7/10
     * @return bool|string
     */
    public function actionCardBindCourse(){
        set_time_limit(0);
        $model = new ExcelMemberLeave();
        $model->cardBindBirthCourse();
    }
    /**
     * 迈步发送短信
     */
    public function actionSend($vId,$code,$type='send')
    {
        $wipe = new WipeData();
        return $wipe->sendMaiBuMemberCode($vId,$code,$type);
    }

    /**
     * 会员卡数据 - 0720开头和0920开头通亚星和帝湖，不限次数
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/9
     * @return bool|string
     */
    public function actionApplyDyData()
    {
        $model = new MemberCard();
        $data  = $model->applyDyData();
        if($data === true){
            return "数据修改成功";
        }else{
            return $data;
        }
    }

    /**
     * 会员管理 - 导入会员升级卡数据 - 升级后的卡属性匹配新卡种属性
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/3/8
     * @return bool|string
     */
    public  function actionUpdateMemberCardData()
    {
        $memberCardId   = \Yii::$app->request->get('memberCardId');
        $cardCategoryId = \Yii::$app->request->get('cardCategoryId');
        if(!empty($memberCardId)&& !empty($cardCategoryId)){
            $model          = new WipeData();
            $status         = $model->UpdateMemberCardData($memberCardId,$cardCategoryId);
            if($status === true){
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            }else{
                return json_encode(['status' => 'error', 'data' =>$status]);
            }
        }else{
            return "会员卡id和卡种id不能为空!";
        }
    }

    /**
     * 员工管理 - 批量修改员工年限
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/03/15
     * @return bool|string
     */
    public function actionUpdateWorkTime()
    {
        $model = new Employee();
        $data  = $model->updateWorkTime();
        if($data === true){
            return "数据修改成功";
        }else{
            return $data;
        }
    }

    /**
     * 约课管理 - 批量修改约课状态
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/03/30
     * @return bool|string
     */
    public function actionUpdateCancelStatus()
    {
        $model = new AboutClass();
        $data  = $model->updateCancelStatus();
        if($data === true){
            return "数据修改成功";
        }else{
            return $data;
        }
    }

    /**
     * 会员管理 -ic卡绑定 - 批量插入
     * @author Huang hua <huanghua@itsports.club>
     * @create 2018/4/23
     * @return bool|string
     */
    public  function actionInsertBindIc()
    {
        ini_set("memory_limit", "300M");
        set_time_limit(0);
        $model = new WipeData();
        $status = $model->insertIcBind();
        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }
    }
    
    /**
     * @desc: 业务后台 - 导出会员,会员卡,卡种不同场馆的数据
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/03/15
     * @return string
     */
    public function actionNotSameVenue($venueId)
    {
        set_time_limit(0);
        ini_set('memory_limit ', "300M");
        $model = new MemberCard();
        $data = $model->selectNotSameVenue($venueId);
        \moonland\phpexcel\Excel::export([
            'models' => $data,
            'fileName' => '会员卡,卡种不同场馆的数据',
            'columns' => ['member_id', 'member_venue_id' ,'member_card_id', 'card_venue_id', 'card_category_id', 'category_venue_id', 'name', 'card_number', 'card_name'],
            'headers' => [
                'member_id' => "会员编号",
                'member_venue_id' => '会员所属场馆编号',
                'member_card_id' => "会员卡编号",
                'card_venue_id' => '会员卡所属场馆编号',
                'card_category_id' => "卡种编号",
                'category_venue_id' => '卡种所属场馆编号',
                'name' => "会员姓名",
                'card_number' => "会员卡号",
                'card_name' => "卡种名称",
            ]
        ]);
        unset($data);
        return;
    }

    /**
     * 会员管理 - 批量修改卡过期状态
     * @author huanghua <huanghua@itsports.club>
     * @create 2018/6/7
     * @return bool|string
     */
    public function actionUpdateAllCardStatus()
    {
        $model = new MemberCard();
        $data  = $model->updateAllCardStatus();
        if($data === true){
            return "数据修改成功";
        }else{
            return $data;
        }
    }

    /**
     * @desc:更新会员卡激活期限  ==》》错误数据修改
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/5/16
     * @time: 14:10
     */
    public function actionUpdateActiveTime()
    {

        $list = MemberCard::find()
            ->alias('mc')
            ->select('mc.active_limit_time, mc.card_number, mc.card_category_id,mc.id, cloud_card_category.active_time')
            ->leftJoin('cloud_card_category', 'mc.card_category_id = cloud_card_category.id')
            ->where(['or',['>', 'mc.active_limit_time', 1000],['<', 'mc.active_limit_time', 0]])
            ->asArray()
            ->all();

//        var_dump($list);die;

        //循环更新数据
        foreach ($list as $key=>$value){
            $info = MemberCard::findOne($value['id']);
            $info -> active_limit_time = $value['active_time'];
            $re = $info->save();
            if($re){
                echo 'ok<br/>';
            }else{
                echo 'no'.$value['id'].'<br/>';
            }
        }

    }
    /**
     * @desc:更新会员卡激活期限  ==》》错误数据修改
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/5/16
     * @time: 14:10
     */
    public function actionUpdateDeal($id=49)
    {
        set_time_limit(0);
        ini_set('memory_limit','2048M');
        $deal = new DealController('',null);
        $deal->actionSupplyMembercardDealData($id);
//        $deal->actionSupplyMembercardDealData();
        return true;
    }
    /**
     * @desc:更新会员卡激活期限  ==》》错误数据修改
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/5/16
     * @time: 14:10
     */
    public function actionUpdateChargeDeal($id=49)
    {
        set_time_limit(0);
        ini_set('memory_limit','2048M');
        $deal = new DealController('',null);
//        $deal->actionSupplyMembercardDealData();
        $deal->actionSupplyCourseorderDealData($id);
        return true;
    }
}