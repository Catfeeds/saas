<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 14:03
 */
namespace backend\modules\v3\models;


use backend\models\Config;
use backend\models\LeaveRecord;
use backend\models\MemberCabinet;
use common\models\base\CardCategory;
use common\models\base\LimitCardNumber;
use common\models\base\MemberAccount;
use common\models\base\MemberBase;
use common\models\base\MemberCard;
use common\models\base\MemberDetails;
use common\models\base\Organization;

class Member extends \common\models\base\Member
{
    /**
     * @云运动 - 微信公众号 - 获取个人信息
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $memberId    //会员id
     * @create 2018/1/23
     * @inheritdoc
     */
    public function getMyProfile($memberId)
    {
        $data = \backend\models\Member::find()
            ->alias('me')
            ->joinWith(['venue ve'],false)
            ->joinWith(['company cy'],false)
            ->joinWith(['memberDetails md'],false)
            ->where(['me.id'=>$memberId])
            ->select('md.pic,me.username,md.nickname,md.id_card,md.sex,me.id,me.mobile,me.venue_id,me.company_id,ve.name as venueName,cy.name as companyName')
            ->asArray()
            ->one();
        $data['nickname']  = isset($data['nickname']) ? $data['nickname'] : $data['username'];
        return $data;
    }

    /**
     * @云运动 - 微信公众号 - 修改个人信息
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $memberId    //会员id
     * @param $param
     * @create 2018/1/24
     * @inheritdoc
     */
    public function updateMyProfile($param)
    {
        $member = \common\models\base\Member::findOne(['id'=>$param['memberId']]);
        if($member){
            $memberDetails = MemberDetails::findOne(['member_id'=>$param['memberId']]);
            if($memberDetails){
                if(isset($param['nickname'])){
                    $memberDetails->nickname = $param['nickname'];
                    if($memberDetails->save()){
                        return true;
                    }else{
                        return false;
                    }
                }
                if(isset($param['picture'])){
                    $memberDetails->pic = $param['picture'];
                    if($memberDetails->save()){
                        return true;
                    }else{
                        return false;
                    }
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    /**
     * @云运动 - 微信公众号 - 我的会员卡
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $memberId    //会员id
     * @param $param
     * @create 2018/1/24
     * @inheritdoc
     */
    public function getMyCards($memberId)
    {
        $notCard = $this->getMyNotCard($memberId);
        $cards = \backend\models\MemberCard::find()
            ->alias('mc')
            ->joinWith(['leaveRecordIos leaveRecord'])
            ->joinWith(['cardCategory cc' => function($q)use($notCard){
                if($notCard){
                    $q->where(['NOT IN', 'mc.id', $notCard]);
                }
            }],false)
            ->where(['mc.member_id'=>$memberId])
            ->select('mc.id,mc.card_name,mc.card_number,mc.status,mc.create_at,mc.invalid_time,mc.leave_total_days,mc.leave_least_days,mc.leave_days_times,mc.student_leave_limit,cc.duration')
            ->asArray()
            ->all();
        if($cards){
            foreach($cards as $k=>$v){
                $cards[$k]['duration']            = json_decode($v['duration']);
                $cards[$k]['leave_days_times']    = json_decode($v['leave_days_times']);
                $cards[$k]['student_leave_limit'] = json_decode($v['student_leave_limit']);
                $cards[$k]['create_at']           = date('Y-m-d',$v['create_at']);
                $cards[$k]['invalid_time']        = date('Y-m-d',$v['invalid_time']);
            }
            return $cards;
        }else{
            return false;
        }
    }

    public function getMyNotCard($memberId)
    {
        $cards = \backend\models\MemberCard::find()
            ->alias('mc')
            ->joinWith(['order or' => function($q){
                $q->where(['AND', ['or.status' => 5], ['or.consumption_type' => 'card']]);
            }], false)
            ->where(['mc.member_id'=>$memberId])
            ->select('mc.id')
            ->groupBy('mc.id')
            ->all();
        if(is_array($cards) && !empty($cards)){
            return array_column($cards, 'id');
        }
        return NULL;
    }
    /**
     * @云运动 - 微信公众号 - 我拥有的场馆
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $mobile
     * @create 2018/1/24
     * @inheritdoc
     */
    public function getMyVenues($mobile, $companyId)
    {
        return $venue = \backend\models\Member::find()
            ->alias('m')
            ->joinWith(['venue ve'],false)
            ->where(['m.mobile'=>$mobile, 'm.company_id' => $companyId])
            ->select('ve.id,ve.name')
            ->asArray()
            ->all();
    }

    /**
     * @云运动 - 微信公众号 - 我不拥有的场馆
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $mobile
     * @create 2018/1/24
     * @inheritdoc
     */
    public function getOtherVenues($mobile, $companyId)
    {
        $venueId    = \backend\models\Member::find()
            ->joinWith(['venue ve'],false)
            ->where(['mobile'=>$mobile])
            ->select('ve.id')
            ->asArray()
            ->all();
        $venueIds   = array_column($venueId, 'id');
        $model      = Organization::find()
                        ->where(['pid'=>$companyId,'style'=>2])
                        ->andWhere(['NOT IN','id',$venueIds]);
        if($companyId == 1){
            $model->andWhere(['<>','id',33]);
        }
        $otherVenue = $model->select('id,name,pic')->asArray()->all();
        return $otherVenue;
    }

    /**
     * @云运动 - 微信公众号 - 确认信息
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $mobile
     * @create 2018/1/24
     * @inheritdoc
     */
    public function confirmTheInfo($param)
    {
        $oldMember = \common\models\base\Member::findOne(['mobile'=>$param['mobile'],'venue_id'=>$param['lastVenueId']]);
        if($oldMember){
            $account = MemberAccount::findOne(['mobile'=>$param['mobile'],'company_id'=>$param['companyId']]);
            if(!$account){
                $account = new MemberAccount();
                $account->username   = $oldMember->username;
                $account->password   = \Yii::$app->security->generatePasswordHash('123456');
                $account->mobile     = $param['mobile'];
                $account->last_time  = time();
                $account->company_id = $param['companyId'];
                $account->create_at  = time();
                if(!$account->save()){
                    return $account->errors;
                }
            }

            $member = \common\models\base\Member::findOne(['mobile'=>$param['mobile'],'venue_id'=>$param['venueId']]);
            if(!$member){
                $member = new \common\models\base\Member();
                $member->username          = $param['name'];
                $member->mobile            = $param['mobile'];
                $member->password          = \Yii::$app->security->generatePasswordHash('123456');
                $member->register_time     = time();
                $member->status            = 1;
                $member->member_type       = 2;
                $member->venue_id          = $param['venueId'];
                $member->company_id        = $oldMember->company_id;
                $member->member_account_id = $account->id;
                if(!$member->save()){
                    return $member->errors;
                }

                $source = Config::findOne(['key'=>'source','value'=>$param['source'],'type'=>'member','company_id'=>$param['companyId'],'venue_id'=>$param['venueId']]);
                if(!$source){
                    $source             = new Config();
                    $source->key        = 'source';
                    $source->value      = $param['source'];
                    $source->type       = 'member';
                    $source->company_id = $param['companyId'];
                    $source->venue_id   = $param['venueId'];
                    if(!$source->save()){
                        return $source->errors;
                    }
                }

                $memdetails = new MemberDetails();
                $memdetails->member_id   = $member->id;
                $memdetails->name        = $param['name'];
                $memdetails->sex         = $param['sex'];
                if(isset($param['idCard'])){
                    $memdetails->id_card = $param['idCard'];
                }
                $memdetails->way_to_shop = (string)$source->id;
                $memdetails->created_at  = time();
                if(!$memdetails->save()){
                    return $memdetails->errors;
                }
            }
            if(isset($param['openid'])){
                $memberBase = MemberBase::findOne(['wx_open_id'=>$param['openid']]);
            }else{
                $memberBase = MemberBase::findOne(['mini_program_openid'=>$param['miniOpenid']]);
            }
            $memberBase->member_id         = $member->id;
            $memberBase->update_at         = time();
            $memberBase->last_venue_id     = $param['venueId'];
            $memberBase->member_account_id = $account->id;
            if($memberBase->save()){
                return $data = [
                    'id'              => $member->id,
                    'member_id'       => $member->id,
                    'name'            => $member->username,
                    'venue_name'      => $param['venueId'] == null ? null : Organization::findOne(['id'=>$param['venueId']])->name,
                    'mobile'          => $member->mobile,
                    'register_time'   => $member->register_time,
                    'status'          => $member->status,
                    'member_type'     => $member->member_type,
                    'venue_id'        => $member->venue_id,
                    'company_id'      => $member->company_id,
                    'last_venue_id'   => $memberBase->last_venue_id,
                    'last_venue_name' => $memberBase->last_venue_id == null ? null : Organization::findOne(['id'=>$memberBase->last_venue_id])->name,
                ];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    /**
     * @云运动 - 微信公众号 - 切换场馆
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $param
     * @create 2018/1/24
     * @inheritdoc
     */
    public function switchTheVenue($param)
    {
        $member = \common\models\base\Member::findOne(['mobile'=>$param['mobile'],'venue_id'=>$param['venueId']]);
        if($member){
            if(isset($param['openid'])){
                $memberBase = MemberBase::findOne(['wx_open_id'=>$param['openid']]);
            }else{
                $memberBase = MemberBase::findOne(['mini_program_openid'=>$param['miniOpenid']]);
            }
            if($memberBase){
                $memberBase->member_id     = $member->id;
                $memberBase->last_venue_id = $param['venueId'];
                if($memberBase->save()){
                    return $data = [
                        'id'              => $member->id,
                        'member_id'       => $member->id,
                        'name'            => $member->username,
                        'venue_name'      => $param['venueId'] == null ? null : Organization::findOne(['id'=>$param['venueId']])->name,
                        'mobile'          => $member->mobile,
                        'register_time'   => $member->register_time,
                        'status'          => $member->status,
                        'member_type'     => $member->member_type,
                        'venue_id'        => $member->venue_id,
                        'company_id'      => $member->company_id,
                        'last_venue_id'   => $memberBase->last_venue_id,
                        'last_venue_name' => $memberBase->last_venue_id == null ? null : Organization::findOne(['id'=>$memberBase->last_venue_id])->name,
                    ];
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
          return false;
        }
    }

    /**
     * @云运动 - 微信公众号 - 查看能否通店的场馆
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $memberId
     * @param $companyId
     * @param $type
     * @create 2018/1/25
     * @inheritdoc
     */
    public function getAccessVenues($memberId,$companyId,$type)
    {
        $notCard = $this->getMyNotCard($memberId);
        $venues = \backend\models\MemberCard::find()
            ->alias('mc')
            ->joinWith(['venueLimitTimesArr vlt' => function($q) use ($notCard){
                if($notCard){
                    $q->where(['NOT IN', 'mc.id', $notCard]);
                }
            }],false)
            ->where(['mc.member_id'=>$memberId])
            ->select('vlt.venue_id,vlt.venue_ids')
            ->distinct()
            ->asArray()
            ->all();
        if($venues){
            foreach($venues as $k=>$v){
                $venues[$k]['venue_ids'] = json_decode($v['venue_ids']);
            }
            $data   = array_merge(array_filter(array_column($venues, 'venue_id')),array_filter(array_column($venues, 'venue_ids')));
            $result = [];
            array_walk_recursive($data, function($value) use (&$result) {
                array_push($result, $value);
            });
            $data = array_unique($result);
            if($type == 'yes'){
                $venues = Organization::find()->where(['id'=>$data])->select('id,name')->asArray()->all();
                return $venues;
            }else{
                $or = Organization::find()->where(['pid'=>$companyId])->andWhere(['NOT IN','id',$data]);
                if($companyId == 1){
                    $or->andWhere(['<>','id',33]);
                }
                $otherVenues = $or->select('id,name')->asArray()->all();
                return $otherVenues;
            }
        }elseif($type == 'no'){
            $or = Organization::find()->where(['pid'=>$companyId]);
            if($companyId == 1){
                $or->andWhere(['<>','id',33]);
            }
            $allVenues = $or->select('id,name')->asArray()->all();
            return $allVenues;
        }else{
            return false;
        }
    }

    /**
     * @云运动 - 微信公众号 - 查看可以通店的会员卡
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $memberId
     * @param $companyId
     * @create 2018/1/25
     * @inheritdoc
     */
    public function getAccessCards($memberId,$venueId)
    {
        $notCard = $this->getMyNotCard($memberId);
        $data = \backend\models\MemberCard::find()
            ->alias('mc')
            ->joinWith(['venueLimitTimesArr vlt' => function($q) use ($notCard){
                if($notCard){
                    $q->where(['NOT IN', 'mc.id', $notCard]);
                }
            }])
            ->where(['mc.member_id'=>$memberId])
            ->select('mc.id,mc.card_number as cardNumber,mc.card_name as cardName,mc.status as cardStatus,mc.active_time,mc.invalid_time')
            ->orderBy('mc.create_at DESC')
            ->asArray()
            ->all();
        if($data){
            $venueLimit = [];
            foreach($data as $k=>$v){
                array_push($venueLimit,$v['venueLimitTimesArr']);
            }
            $result = array_reduce($venueLimit, function ($result, $value) {
                return array_merge($result, array_values($value));
            }, array());
            foreach($result as $k=>$v){
                $result[$k]['venue_ids'] = json_decode($v['venue_ids'],true);
            }
            $cards = [];
            foreach($result as $k=>$v){
                if($v['venue_id'] == $venueId){
                    array_push($cards, $v);
                }
                if($v['venue_ids'] !== null && in_array($venueId,$v['venue_ids'])){
                    array_push($cards, $v);
                }
            }
            $cardIds     = array_column($cards,'member_card_id');
            $accessCards = \backend\models\MemberCard::find()
                ->alias('mc')
                ->joinWith(['leaveRecordIos leaveRecord'])
                ->where(['mc.id'=>$cardIds])
                ->andWhere(['or',['mc.usage_mode' => null],['mc.usage_mode' => 1]])
                ->select('mc.id,mc.card_number as cardNumber,mc.card_name as cardName,mc.status as cardStatus,mc.active_time,mc.invalid_time')
                ->orderBy('mc.create_at DESC')
                ->asArray()
                ->all();
            if($accessCards) {
                foreach ($accessCards as $k => $v) {
                    $accessCards[$k]['memberCardId'] = $v['id'];
                    $accessCards[$k]['active_time']  = $v['active_time'] == null ? '未激活' : date("Y-m-d", $v['active_time']);
                    $accessCards[$k]['invalid_time'] = $v['invalid_time'] == null ? '未激活' : date("Y-m-d", $v['invalid_time']);
                }
                return $accessCards;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


    /**
     * @云运动 - 微信公众号 - 我的会员卡
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $memberId    //会员id
     * @param $param
     * @create 2018/2/1
     * @inheritdoc
     */
    public function dayOffCards($memberId,$venueId)
    {
        $notCard = $this->getMyNotCard($memberId);
        $cards = \backend\models\MemberCard::find()
            ->alias('mc')
            ->joinWith(['leaveRecordIos leaveRecord' => function($q) use ($notCard){
                if($notCard){
                    $q->where(['NOT IN', 'mc.id', $notCard]);
                }
            }])
            ->where(['mc.member_id'=>$memberId,'mc.venue_id'=>$venueId])
            ->select('mc.id,mc.card_name,mc.card_number,mc.status,mc.active_time,mc.invalid_time,mc.leave_type,mc.leave_total_days,mc.leave_least_days,mc.leave_days_times,mc.student_leave_limit')
            ->asArray()
            ->all();
        if($cards){
            foreach($cards as $k=>$v){
                $cards[$k]['leave_days_times']    = json_decode($v['leave_days_times']);
                $cards[$k]['student_leave_limit'] = json_decode($v['student_leave_limit']);
                $cards[$k]['active_time']         = $v['active_time'] == null ? null :date('Y-m-d',$v['active_time']);
                $cards[$k]['invalid_time']        = date('Y-m-d',$v['invalid_time']);
            }
            return $cards;
        }else{
            return false;
        }
    }

    /**
     * @云运动 - 微信公众号 - 请假记录
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $memberId
     * @param $param
     * @create 2018/2/1
     * @inheritdoc
     */
    public function dayOffList($memberId)
    {
        $data = LeaveRecord::find()
            ->alias('lr')
            ->joinWith(['memberCard mc'],false)
            ->where(['lr.leave_employee_id'=>$memberId])
            ->select('lr.id,lr.create_at,lr.status,lr.member_card_id,lr.leave_length,lr.leave_property,lr.leave_type,lr.reject_note,lr.leave_start_time,lr.leave_end_time,lr.terminate_time,lr.type,mc.card_name')
            ->asArray()
            ->all();
        if($data){
            foreach($data as $k=>$v){
                $data[$k]['leave_start_time'] = date('Y-m-d',$v['leave_start_time']);
                $data[$k]['leave_end_time']   = date('Y-m-d',$v['leave_end_time']);
                $data[$k]['terminate_time']   = $v['terminate_time'] == null ? null : date('Y-m-d',$v['terminate_time']);
            }
            return $data;
        }else{
            return false;
        }
    }

    /**
     * @云运动 - 微信公众号 - 我的柜子
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $memberId
     * @param $venueId
     * @param $param
     * @create 2018/2/1
     * @inheritdoc
     */
    public function getMyCabinet($mobile)
    {
        $ids = StatisticsModel::gainMyAllAccount($mobile);
        if(!$ids){
            return false;
        }
        $data = MemberCabinet::find()
            ->alias('mc')
            ->joinWith(['member mm'],false)
            ->joinWith(['employee employee'],false)
            ->joinWith(['cabinet cabinet'=>function($query){
                    $query->joinWith(['cabinetType cabinetType']);
                }
            ],false)
            ->joinWith(['cabinetHistory cabinetHistory'])
            ->where(['mc.member_id'=>$ids])
            ->andFilterWhere(['cabinet.company_id'=>1])
            ->orderBy(['mc.id' =>SORT_DESC])
            ->select('mc.*,cabinetType.type_name,cabinet.cabinet_number,cabinet.cabinet_type,cabinet.deposit')
            ->asArray()
            ->all();
        if($data){
            foreach($data as $k=>$v){
                list($date_1['y'],$date_1['m']) = explode("-",date('Y-m',$v['end_rent']));
                list($date_2['y'],$date_2['m']) = explode("-",date('Y-m',$v['start_rent']));
                $data[$k]['rent_month']         = abs($date_1['y']-$date_2['y'])*12 +$date_1['m']-$date_2['m'];
                $data[$k]['start_rent']         = date('Y-m-d',$v['start_rent']);
                $data[$k]['end_rent']           = date('Y-m-d',$v['end_rent']);
                $data[$k]['give_month'] = 0;
                $g1 = 0;
                $g2 = 0;
                foreach($v['cabinetHistory'] as $a=>$b){
                    if($b['give_type'] == 1){
                        //d
                        $g1 += $b['give_month'];
                    }else{
                        //m
                        $g2 += $b['give_month'] * 30;
                    }
                }
                $data[$k]['give_month'] = $g1 + $g2;
            }
            return $data;
        }else{
            return false;
        }
    }

    /**
     * 运运动-微信公众号-会员信息获取
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/3/7
     * @param $memberId
     * @return array|bool
     */
    public function getPersonalMemberInfo($memberId)
    {
        $member       = \common\models\base\Member::findOne($memberId);
        $memberDetail = MemberDetails::findOne(['member_id' => $memberId]);
        if(!$member){
            return false;
        }
        if(!$memberDetail){
            $memberName   = NULL;
            $memberSex    = NULL;
            $memberIdCard = NULL;
        }else{
            $memberName   = $memberDetail->name;
            $memberSex    = $memberDetail->sex;
            $memberIdCard = $memberDetail->id_card;
        }
        $memberInfo = [
            'memberId'     => $memberId,
            'memberName'   => $memberName,
            'memberSex'    => $memberSex,
            'memberIdCard' => $memberIdCard,
            'memberMobile' => $member->mobile,
        ];
        return $memberInfo;
    }

    /**
     * 运运动-微信公众号-完善会员信息
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/3/7
     * @param $param
     * @return bool
     */
    public function completeMemberInfo($param)
    {
        $memberDetail = MemberDetails::findOne(['member_id' => $param['memberId']]);
        $memberDetail->name    = $param['name'];
        $memberDetail->sex     = $param['sex'];
        $memberDetail->id_card = $param['idCard'];
        if($memberDetail->save()){
            return true;
        }
        return false;
    }
}