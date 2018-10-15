<?php
namespace backend\models;
use common\models\Func;
use common\models\relations\ApprovalRelations;

class Approval extends \common\models\base\Approval
{
    use ApprovalRelations;
    public $venueId;
    public $keywords;
    public $type;
    public $status;
    public $startTime;
    public $endTime;
    public $statusType;
    const VENUE_ID    = 'venueId';
    const KEYWORDS    = 'keywords';
    const TYPE        = 'type';
    const STATUS      = 'status';
    const STATUS_TYPE = 'statusType';
    const START_TIME  = 'startTime';
    const END_TIME    = 'endTime';

    /**
     * @date:2017-09-28 10:34
     * @author :李慧恩
     * @content:获取审批列表数据
     * @return  array
     */
    public function getApprovalData($params)
    {
        $this->customLoads($params);
        $query = self::find()
            ->alias('app')
            ->joinWith(['employee em'=>function($query){
                $query->joinWith(['organizations venue'],false);
                $query->joinWith(['organization  organization'],false);
                $query->joinWith(['position  position'],false);
            }],false)
            ->joinWith(['approvalType at'],false)
            ->joinWith(['approvalDetailsM adm' => function($query){    //获取抄送人
                $query->joinWith(['employee cem'],false);
                $query->select('adm.approval_id,adm.approver_id,cem.name');    //cem.name抄送人
            }])
            ->select('app.*,em.name as eName,em.pic,em.position,position.name as pName,at.type,venue.name as vName,organization.name as cName')
            ->groupBy(['app.id'])
            ->orderBy('app.create_at DESC')
            ->asArray();
        $query = $this->searchWhere($query);
        $data  = Func::getDataProvider($query,8);
        return $data;
    }

    /**
     * @后台 - 卡种审核 - 审批列表数据 - 处理搜索字段
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/29
     * @param  $data
     */
    public function customLoads($data)
    {
        //获取权限里的场馆
        $cardObj  = new \backend\models\CardCategory();
        $venueIds = $cardObj->getVenueIdByRole();
        $this->venueId   = (isset($data[self::VENUE_ID]) && !empty($data[self::VENUE_ID])) ? $data[self::VENUE_ID] : $venueIds;
        $this->keywords  = (isset($data[self::KEYWORDS]) && !empty($data[self::KEYWORDS])) ? $data[self::KEYWORDS] : null;
        $this->type      = (isset($data[self::TYPE]) && !empty($data[self::TYPE])) ? $data[self::TYPE] : NULL;
        $this->status    = (isset($data[self::STATUS]) && !empty($data[self::STATUS])) ? $data[self::STATUS] : null;
        $this->statusType= (isset($data[self::STATUS_TYPE]) && !empty($data[self::STATUS_TYPE])) ? $data[self::STATUS_TYPE] : 1;
        $this->startTime = (isset($data[self::START_TIME]) && !empty($data[self::START_TIME])) ? strtotime($data[self::START_TIME]) : NULL;
        $this->endTime   = (isset($data[self::END_TIME]) && !empty($data[self::END_TIME])) ? strtotime($data[self::END_TIME]) : NULL;
    }

    /**
     * @后台 - 卡种审核 - 审批列表数据 - 搜索字段
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/29
     * @param  $query
     */
    public function searchWhere($query)
    {
        if($this->statusType == 3){
            $sms = new SmsRecordForm();
            $query->where(['app.create_id'=>$sms->getCreate()]);
        }elseif ($this->statusType == 4){
//            $idArr = $this->getRoleInArr();
//            $query->andWhere(['app.approval_type_id'=>$idArr]);
            $sms = new SmsRecordForm();
            $query->joinWith(['approvalDetails ad'],false);
            $query->where(['ad.approver_id'=>$sms->getCreate(),'ad.type'=>2]);
        }elseif($this->statusType == 2){
            $sms = new SmsRecordForm();
            $query->joinWith(['approvalDetails ad'],false);
            $query->where(['ad.approver_id'=>$sms->getCreate(),'ad.status'=>[2,3,4],'ad.type'=>1]);
        }else{
            if(empty($this->status)){
                $this->status = $this->statusType;
            }
            $sms = new SmsRecordForm();
            $query->joinWith(['approvalDetails ad'],false);
            $query->where(['ad.approver_id'=>$sms->getCreate(),'ad.status'=>1,'ad.type'=>1]);
        }
        $query->andFilterWhere(['app.status'=>$this->status]);
//        $query->andFilterWhere(['app.approval_type_id' => $this->type]);
        $query->andFilterWhere(['at.type' => $this->type]);
        $query->andFilterWhere(['and',['>=','app.create_at',$this->startTime],['<=','app.create_at',$this->endTime]]);
        $query->andFilterWhere(['app.venue_id' => $this->venueId]);
        $query->andFilterWhere(['like','app.name',$this->keywords]);
        return $query;
    }
    /**
     * @后台 - 卡种审核 - 获取抄送类型
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/29
     */
    public function getRoleInArr()
    {
         $sms  = new SmsRecordForm();
         $emId = $sms->getCreate();
         $query = ApprovalType::find()->alias('at')
             ->joinWith(['approvalRole ar'])
             ->where(['ar.type'=>2])
             ->andWhere(['employee_id'=>$emId])
             ->asArray()->all();
         return array_column($query,'id');
    }
    /**
     * @后台 - 卡种审核 - 或否可以审核
     * @author lihuien <lihuien@itsports.club>
     * @param  $id
     * @create 2017/9/29
     * @return array
     */
    public function canRoleById($typeId,$id)
    {
        $query  = ApprovalRole::find()->alias('ar')->where(['ar.type'=>1])->andWhere(['approval_type_id'=>$typeId])->asArray()->all();
        $detail = ApprovalDetails::find()->alias('ad')->where(['approval_process_id'=>$typeId,'status'=>[1],'approval_id'=>$id])->asArray()->one();
        $data['approvalRoleId']  = array_column($query,'employee_id');
        $data['approvalDetails'] = $detail;
        return $data;
    }
}