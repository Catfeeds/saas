<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/9
 * Time: 14:03
 */
namespace backend\modules\v3\models;
use backend\models\AboutClass;
use backend\models\ChargeClassPrice;
use backend\models\Employee;
use backend\models\ChargeClass;
use backend\models\MemberCard;
use backend\models\Member;
use backend\models\Organization;
use common\models\base\GroupClass;

class MemberCourseOrder extends \common\models\base\MemberCourseOrder
{
    /**
     * @云运动 - 云运动 - 获取已购买私课列表
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $memberId    //会员id
     * @param $venueId     //场馆id
     * @create 2018/1/9
     * @inheritdoc
     */
    public function getCourseOrderList($memberId,$venueId)
    {
        return $data = \backend\models\MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['member me'],false)
            ->joinWith(['chargeClass cc' => function($q){
                $q->where(['<>', 'cc.group', 2]);
            }],false)
            ->where(['me.id'=>$memberId,'me.venue_id'=>$venueId])
            ->select('mco.id,cc.pic,mco.product_name,mco.course_amount,mco.overage_section,mco.money_amount')
            ->asArray()
            ->all();
    }

    /**
     * @云运动 - 云运动 - 获取已购私课详情
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $id       //私教订单id
     * @create 2018/1/9
     * @inheritdoc
     */
    public function getCourseOrderInfo($id)
    {
        $data = \backend\models\MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['memberCourseOrderDetails mcod'],false)
            ->joinWith(['chargeClass cc'=>function($query){
                $query->joinWith(['course cs'],false);
                $query->joinWith(['coursePackageDetail cpd'],false);
            }],false)
            ->where(['mco.id'=>$id])
            ->select('mcod.id as class_id,cc.pic,mco.product_name,cc.describe,cc.id as charge_class_id,cpd.course_length,(mco.money_amount/mco.course_amount) as unit_price')
            ->asArray()
            ->one();
        if($data){
           $data['unit_price'] = round($data['unit_price'],0);
           $data['price']      = ChargeClassPrice::find()->where(['charge_class_id'=>$data['charge_class_id']])->asArray()->all();
           return $data;
        }else{
           return false;
        }
    }

    /**
     * @云运动 - 云运动 - 获取教练列表
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $venueId
     * @param $orderTime
     * @create 2018/1/9
     * @inheritdoc
     */
    public function getCoachList($venueId,$orderTime)
    {
        $organization = Organization::findOne(['pid'=>$venueId,'name'=>'私教部']);
        if($organization){
           $employee = Employee::find()
                ->where(['organization_id'=>$organization->id,'status'=>1])
                ->select('id,pic,name,age,work_time')
                ->asArray()
                ->all();
           foreach($employee as $k=>$v){
               $aboutClass = AboutClass::find()
                    ->where(['coach_id'=>$v['id']])
                    ->andWhere([
                        'and',
                        ['<=','start',$orderTime],
                        ['>=','end',$orderTime]
                    ])
                    ->asArray()
                    ->one();
               $employee[$k]['isAccess'] = empty($aboutClass) ? true : false;
           }
           return $employee;
        }else{
           return false;
        }
    }

    /**
     * @云运动 - 微信公众号 - 获取会员已预约团课详情
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/12/23
     * @param $aboutId   //预约课程id
     * @param $memberId  //会员id
     * @return mixed
     */
    public function getOrderClassInfo($aboutId,$memberId)
    {
        $data = \backend\models\AboutClass::find()
            ->alias('ac')
            ->where(['ac.id'=>$aboutId,'ac.member_id'=>$memberId])
            ->joinWith(['member me'],false)
            ->joinWith(['employee em'],false)
            ->joinWith(['groupClass gc'=>function($query){
                $query->joinWith(['course ce']);
            }],false)
            ->joinWith(['memberCourseOrderDetails mcod'],false)
            ->select('ac.id as aboutId,ac.type,me.id as member_id,me.member_type,ac.status,ac.start,ac.end,ac.is_print_receipt,mcod.product_name as charge_name,ce.name as course_name,ce.course_duration,em.name as coach_name,ac.create_at,ac.cancel_time,gc.cancel_limit_time')
            ->asArray()
            ->one();
        if($data){
            $data['start_time']        = date('Y-m-d H:i:s',$data['start']);
            $data['cancel_class_time'] = $data['cancel_time'] == null ? null : date('Y-m-d H:i:s',$data['cancel_time']);
            return $data;
        }else{
            return false;
        }
    }

    /**
     * @云运动 - API - 微信公众号获取会员卡列表
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/12/27
     */
    public function getCardList($memberId)
    {
        $data = MemberCard::find()
            ->alias('mc')
            ->joinWith(['leaveRecordIos leaveRecord'])
            ->where(['mc.member_id'=>$memberId,'mc.status'=>[1,4]])
            ->andWhere(['or',['mc.usage_mode'=> null],['mc.usage_mode'=> 1]])
            ->select('mc.id,mc.card_number as cardNumber,mc.usage_mode,mc.card_name as cardName,mc.status as cardStatus,mc.active_time,mc.invalid_time')
            ->orderBy('mc.create_at DESC')
            ->asArray()
            ->all();
        if($data){
            foreach($data as $k=>$v){
                $data[$k]['memberCardId'] = $v['id'];
                $data[$k]['active_time']  = $v['active_time'] == null ? '未激活' : date("Y/m/d",$v['active_time']);
                $data[$k]['invalid_time'] = $v['invalid_time'] == null ? '未激活' : date("Y/m/d",$v['invalid_time']);
            }
            return $data;
        }else{
            return false;
        }
    }

    /**
     * @云运动 - 云运动 - 展示教练列表
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $venueId
     * @create 2018/1/9
     * @inheritdoc
     */
    public function showCoachList($venueId)
    {
        $organization = Organization::findOne(['pid'=>$venueId,'name'=>'私教部']);
        if($organization){
            return $employee = Employee::find()
                ->where(['organization_id'=>$organization->id,'venue_id'=>$venueId,'status'=>1])
                ->select('id,pic,name,age,work_time')
                ->asArray()
                ->all();
        }else{
            return false;
        }
    }

    /**
     * @云运动 - 云运动 - 获取教练详情
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $venueId
     * @create 2018/1/19
     * @inheritdoc
     */
    public function getCoachInfo($coachId)
    {
        return $employee = Employee::find()
            ->where(['id'=>$coachId])
            ->select('id,pic,name,age,work_time,intro')
            ->asArray()
            ->one();
    }


    /**
     * @云运动 - 云运动 - 获取私教课程列表
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $venueId
     * @create 2018/1/19
     * @inheritdoc
     */
    public function getCoachLessons($venueId)
    {
        return $data = ChargeClass::find()
            ->alias('cc')
            ->joinWith(['coursePackageDetail dd' => function($query){
                $query->joinWith(['course course'],false);
            }],false)
            ->where(['cc.venue_id'=>$venueId])
            ->orderBy('cc.id DESC')
            ->select(
                "cc.id,
                 cc.name,
                 cc.valid_time,
                 cc.total_amount,
                 cc.total_sale_num,
                 cc.sale_start_time,
                 cc.sale_end_time,
                 cc.created_at,
                 cc.status,
                 cc.app_amount,
                 cc.show,
                 course.name as courseName")
            ->groupBy('dd.charge_class_id')
            ->asArray()
            ->all();
    }

    /**
     * @云运动 - 云运动 - 获取私教课程详情
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $chargeId
     * @create 2018/1/22
     * @inheritdoc
     */
    public function getLessonsInfo($chargeId)
    {
        return $data = ChargeClass::find()
            ->alias('cc')
            ->joinWith(['coursePackageDetail dd' => function($query){
                $query->joinWith(['course course'],false);
            }],false)
            ->joinWith(['chargeClassPrice ccp'])
            ->where(['cc.id'=>$chargeId])
            ->orderBy('cc.id DESC')
            ->select(
                "cc.id,
                 cc.name,
                 cc.valid_time,
                 cc.total_amount,
                 cc.total_sale_num,
                 cc.sale_start_time,
                 cc.sale_end_time,
                 cc.created_at,
                 cc.status,
                 cc.app_amount,
                 cc.show,
                 cc.pic,
                 cc.describe,
                 dd.original_price,
                 dd.sale_price,
                 dd.course_length,
                 dd.course_num,
                 course.name as courseName"
            )
            ->groupBy('dd.charge_class_id')
            ->asArray()
            ->one();
    }

    /**
     * 云运动 - Api - 获取选中公司下面的场馆
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/22
     * @param $companyId     //公司id
     * @return array|\yii\db\ActiveRecord[]  //返回所有的场馆
     */
    public function getAllVenue($companyId)
    {
        return $data = Organization::find()
            ->where(['pid' => $companyId])
            ->andWhere(['style' => 2])
            ->select('id,name')
            ->andWhere(["not like", "name", "管理公司"])
            ->asArray()
            ->all();
    }

    /**
     * 云运动 - Api - 预约私教课接口
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/22
     * @param $param
     * @inheritdoc
     */
    public function orderChargeClass($param)
    {
        $time = strtotime($param['time']);
        $data = ChargeClass::find()->alias('cc')->joinWith(['coursePackageDetail dd'],false)
            ->where(['cc.id'=>$param['chargeId']])
            ->select('dd.course_length')
            ->asArray()
            ->one();
        $mco = \backend\models\MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['memberCourseOrderDetails mcod'],false)
            ->where(['mco.member_id'=>$param['memberId'],'mco.product_id'=>$param['chargeId']])
            ->select('mcod.id')
            ->asArray()
            ->one();
        $about = new \common\models\base\AboutClass();
//        $about->member_card_id = 1;
        $about->class_id = $mco['id'];
        $about->status = 1;
        $about->type   = '1';
        $about->create_at = time();
        $about->coach_id  = $param['coachId'];
        $about->class_date = date('Y-m-d',$time);
        $about->start = $time;
        $about->end = $time + 60*$data['course_length'];
        $about->member_id = $param['memberId'];
        $about->is_print_receipt = 2;
        $about->about_type = 2;
        if($about->save()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 云运动 - Api - 团课座位详情接口
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/22
     * @param $param
     * @inheritdoc
     */
    public function getSeatDetail($param)
    {
        $groupClasses = GroupClass::findOne(['id' => $param['classId']]);
        if ($groupClasses) {
            $memberCard = MemberCard::find()
                ->alias('mc')
                ->joinWith(['venueLimitTimesArr vlt'], false)
                ->where(['mc.id' => $param['cardId']])
                ->andWhere(['mc.status' => [1, 4]])
                ->select('mc.id as memberCardId,mc.card_number as cardNumber,mc.venue_id as venueId,vlt.venue_id,vlt.venue_ids,vlt.level,mc.card_name as cardName,mc.status as cardStatus,mc.active_time,mc.invalid_time')
                ->asArray()
                ->all();
            foreach ($memberCard as $k => $v) {
                $memberCard[$k]['venue_ids'] = json_decode($v['venue_ids'], true);
            }

            $groupClass = \backend\models\GroupClass::find()
                ->alias('gc')
                ->joinWith(['seatTypeS seatType'])
                ->joinWith(['classroom cr'],false)
                ->joinWith(['course cs'], false)
                ->joinWith(['employee ee'], false)
                ->joinWith(['seatS seat'])
                ->where(['gc.id' => $param['classId']])
                ->select('gc.*,cs.name as courseName,cs.course_desrc,seat.*,ee.name as coachName,ee.pic as coachPic,cr.name as classroom')
                ->asArray()
                ->one();
            foreach ($memberCard as $a => $b) {
                if ($b['venue_id'] == $groupClasses->venue_id) {
                    $thisVenueLevel = $b['level'];
                }
                if (isset($b['venue_ids']) && in_array($groupClasses->venue_id, $b['venue_ids'])) {
                    $thisVenueLevel = $b['level'];
                }
            }
            $thisVenueLevel = (isset($thisVenueLevel) && !empty($thisVenueLevel)) ? $thisVenueLevel : 1;
            foreach ($groupClass['seatS'] as $k => $v) {
                if ($thisVenueLevel == 2) {
                    $groupClass['seatS'][$k]['authority'] = 1;
                } else {
                    $groupClass['seatS'][$k]['authority'] = $v['seat_type'] == 1 ? 1 : 0;
                }
                $tokenSeat = AboutClass::find()
                    ->where(['class_id' => $param['classId'], 'seat_id' => $v['id']])
                    ->andWhere(['<>','status',2])
                    ->one();
                if ($tokenSeat) {
                    $groupClass['seatS'][$k]['isToken'] = 1;    //被占用
                } else {
                    $groupClass['seatS'][$k]['isToken'] = 0;    //未被占用
                }
            }

            $data1 = array_column($memberCard, 'venue_id');
            $data2 = array_column($memberCard, 'venue_ids');
            $result = [];
            array_walk_recursive($data2, function ($value) use (&$result) {
                array_push($result, $value);
            });
            $total = array_merge($data1, $result);
            if (in_array($groupClasses->venue_id, $total)) {
                $courseId = \backend\models\GroupClass::find()
                    ->alias('gc')
                    ->joinWith(['course cs'], false)
                    ->where(['gc.id' => $param['classId']])
                    ->asArray()
                    ->select('cs.path,cs.name,cs.category')
                    ->one();
                if ($courseId) {
                    //1、先获得团课的课程id:course
                    $coursePath = explode(',',json_decode($courseId['path'],true));
                    //2、再查找这张会员卡绑定的团课课程id:course
                    $bandCourse1 = MemberCard::find()
                        ->alias('mc')
                        ->joinWith(['bindCourse bc'=>function($query){
                            $query->where(['bc.status' => 1]);
                            $query->andWhere(['IS NOT', 'bc.polymorphic_ids', null]);
                        }])
                        ->where(['mc.id' => $param['cardId']])
                        ->asArray()
                        ->one();
                    if($bandCourse1){
                        foreach($bandCourse1['bindCourse'] as $k=>$v){
                            $bandCourse1['bindCourse'][$k]['polymorphic_ids'] = json_decode($v['polymorphic_ids'],true);
                        }
                        $data = array_column($bandCourse1['bindCourse'],'polymorphic_ids');
                        $result = [];
                        array_walk_recursive($data, function ($value) use (&$result) {
                            array_push($result, $value);
                        });
                    }else{
                        $bandCourse2 = MemberCard::find()
                            ->alias('mc')
                            ->joinWith(['bindCourse bc'=>function($query){
                                $query->where(['bc.status' => 1]);
                            }])
                            ->where(['mc.id' => $param['cardId']])
                            ->asArray()
                            ->one();
                        if($bandCourse2){
                            $result = array_column($bandCourse2['bindCourse'],'polymorphic_id');
                        }else{
                            return ['code' => 0, 'status' => 'error', 'message' => '您的卡没有绑定团课', 'data' => $groupClass];
                        }
                    }
                    if (array_intersect($coursePath, $result)) {
                        $about = AboutClass::find()
                            ->where(['class_id' => $param['classId'], 'member_id' => $param['memberId']])
                            ->andWhere(['<>','status',2])
                            ->asArray()
                            ->all();
                        if (empty($about)) {
                            return ['code' => 1, 'status' => 'success', 'message' => '请求成功', 'data' => $groupClass];
                        } else {
                            return ['code' => 0, 'status' => 'error', 'message' => '您已经约过这节课了', 'data' => $groupClass];
                        }
                    } else {
                        return ['code' => 0, 'status' => 'error', 'message' => '您的卡没有绑定'.$courseId['category'].'课', 'data' => $groupClass];
                    }
                } else {
                    return ['code' => 0, 'status' => 'error', 'message' => '此课程不存在', 'data' => $groupClass];
                }
            } else {
                return ['code' => 0, 'status' => 'error', 'message' => '您不能跨店预约', 'data' => $groupClass];
            }
        } else {
            return ['code' => 0, 'status' => 'error', 'message' => '这节课不存在', 'data' => []];
        }
    }

    /**
     * 运运动 - API - 本店和通本店会员卡
     * @author 杨慧磊<yanghuilei@itsport.club>
     * @createAt 2018/3/7
     * @param $mobile
     * @return array|null|\yii\db\ActiveRecord[]
     */
    public function getMyActiveMemberCards($mobile)
    {
        //我的所有场馆会员卡
        $cards = $this->getMyAllDiffStatusCard($mobile);
        if(!$cards || empty($cards)) return null;
        //我的通店和本店会员卡 @param $venueId
        //$models = $this->getActiveCards($cards, $venueId);
        foreach($cards as $k=>$v){
            $cards[$k]['duration']            = json_decode($v['duration']);
            $cards[$k]['leave_days_times']    = json_decode($v['leave_days_times']);
            $cards[$k]['student_leave_limit'] = json_decode($v['student_leave_limit']);
            $cards[$k]['create_at']           = date('Y-m-d',$v['create_at']);
            $cards[$k]['invalid_time']        = date('Y-m-d',$v['invalid_time']);
        }
        return $cards;
    }

    /**
     * 运运动 - API - 扫码进馆和跨店约课 - 自动筛选出优先卡片
     * @author 杨慧磊 <yanghuilei@itsport.club>
     * @createAt 2018/3/7
     * @param $mobile
     * @param $venueId
     * @param $vid
     * @return mixed|null
     */
    public function getEntryVenueMemberCard($mobile, $venueId, $vid)
    {
        //我的所有-有效正常会员卡
        $cards = $this->getMyAllMemberCard($mobile);
        //如果没有返回NULL
        if(!$cards || empty($cards)) return NULL;
        //其他...
        $models = $this->getMySortMaxCard($cards, $venueId);
        if($models){
            $reCard = [];
            $reCard['id']         = $models['id'];
            $reCard['cardNumber'] = $models['cardNumber'];
            if($vid == 'code'){
                return $reCard;
            }else{
                return [$reCard];
            }
        }else{
            return NULL;
        }
    }

    /**
     * 运运动-我的会员卡-获取所有不同状态的卡片
     * @author杨慧磊<yanghuilei@itsport.club>
     * @createAt 2018/3/7
     * @param $mobile
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getMyAllDiffStatusCard($mobile)
    {
        $cards = Member::find()->alias('mb')
            ->joinWith(['memberCard mc' => function($q){
                $q->joinWith(['leaveRecord leaveRecord' => function($q){
                    $q->onCondition([
                        "and",
                        ["<=","leaveRecord.leave_start_time",time()],
                        [">=","leaveRecord.leave_end_time",time()],
                        ["leaveRecord.status"=>[1, 3]]
                    ]);
                }]);
                $q->joinWith(['organization or']);
                $q->joinWith(['cardCategory ccg']);
                $q->where([
                    'and',
                    ['>', 'mc.invalid_time', time()],
                    [
                        'or',
                        ['mc.usage_mode'=> null],
                        ['mc.usage_mode'=> 1]
                    ]
                ]);
            }], false)
            ->where(['mb.mobile' => $mobile, 'mb.company_id' => 1])
            ->select('
                           mc.id,
                           mc.card_name,
                           or.name venueName,
                           mc.card_number as cardNumber,
                           mc.status cardStatus,
                           mc.create_at,
                           mc.invalid_time,
                           mc.student_leave_limit,
                           mc.leave_days_times,
                           ccg.duration,
                           leaveRecord.id leaveRecordStatus
                           ')
            ->groupBy('mc.id')
            ->asArray()
            ->all();
            return $cards;
    }
    /**
     * 运运动-约课-扫码进馆-获取我的所有-有效正常会员卡
     * @author杨慧磊<yanghuilei@itsport.club>
     * @createAt 2018/3/7
     * @param $mobile    //会员手机号
     * @return mixed|null|\yii\db\ActiveRecord
     */
    public function getMyAllMemberCard($mobile)
    {
        $leaveCards = $this->gainMyInvalidCards($mobile);
        $cards = Member::find()->alias('mb')
                    ->joinWith(['memberCard mc' => function($q) use ($leaveCards){
                        $q->joinWith(['cardCategory ccg' => function($q){
                        $q->joinWith(['cardCategoryType cct']);
                        }]);
                        $q->where([
                            'and',
                            ['mc.status'=>[1,4]],
                            [
                                'or',
                                ['mc.usage_mode'=> null],
                                ['mc.usage_mode'=> 1]]
                        ]);
                        if(is_array($leaveCards) && !empty($leaveCards)){
                        $q->andWhere(['not in', 'mc.id', $leaveCards]);
                        };
                    }], false)
                    ->where(['mb.mobile' => $mobile, 'mb.company_id' => 1])
                    ->select('
                           mc.id,
                           mc.card_number as cardNumber,
                           mc.active_time,
                           mc.invalid_time,
                           mc.total_times,
                           mc.consumption_times,
                           mc.balance,
                           mc.venue_id,
                           cct.id cardType
                           ')
                    ->groupBy('mc.id')
                    ->orderBy(['cct.id' => SORT_ASC])
                    ->asArray()
                    ->all();
                    return $cards;
    }

    /**
     * 运运动-我的会员卡-获取我的请假卡
     * @author杨慧磊<yanghuilei@itsport.club>
     * @createAt 2018/3/7
     * @param $mobile
     * @return array|\yii\db\ActiveRecord[]
     */
    public function gainMyInvalidCards($mobile)
    {
        $cards = Member::find()->alias('mb')
                    ->joinWith(['memberCard mc' => function($q){
                        $q->joinWith(['leaveRecord leaveRecord' => function($q){
                            $q->where([
                                "and",
                                ["<=","leave_start_time",time()],
                                [">=","leave_end_time",time()],
                                ["leaveRecord.status"=>1]
                            ]);
                        }]);
                    }], false)
                    ->where(['mb.mobile' => $mobile, 'mb.company_id' => 1])
                    ->select('mc.id')
                    ->groupBy('mc.id')
                    ->asArray()
                    ->all();
                    if(!$cards){
                        return NULL;
                    }
                    return array_column($cards, 'id');
    }
    /**
     * 运运动-过滤出不同类别有效卡片
     * @author杨慧磊<yanghuilei@itsport.club>
     * @createAt 2018/3/7
     * @param $cards
     * @return array
     */
    protected function gainDiffTypeCards($cards)
    {
        $noActiveTimeCards  = [];               //时间卡未激活
        $activeTimeCards    = [];               //时间卡已激活
        $activeRideCards    = [];               //有效次卡
        $activeMoneyCards   = [];               //有效储值卡
        $activeMixCards     = [];               //有效混合卡
        /*过滤出有效卡片*/
        foreach ($cards as $k => $v){
            switch ($v['cardType'])
            {
                case 1:
                    //时间卡
                    if($v['invalid_time'] > time() && $v['active_time'] != NULL && $v['active_time'] != 0){
                        //过滤出有效已激活卡片
                        array_push($activeTimeCards, $v);
                    }else{
                        //过滤出有效未激活卡片
                        if($v['invalid_time'] > time()){
                            array_push($noActiveTimeCards, $v);
                        }
                    }
                    break;
                case 2:
                    //次卡
                    if($v['consumption_times'] < $v['total_times']){
                        //过滤出有效次卡
                        array_push($activeRideCards, $v);
                    }
                    break;
                case 3:
                    //充值卡
                    if($v['balance'] > 0){
                        //过滤出有效储值卡
                        array_push($activeMoneyCards, $v);
                    }
                    break;
                default:
                    //混合卡
                    array_push($activeMixCards, $v);
            }
        }
        return [$activeTimeCards, $noActiveTimeCards, $activeRideCards, $activeMoneyCards, $activeMixCards];
    }
    /**
     * 运运动-会员卡-根据优先级返回优先卡片
     * @author杨慧磊<yanghuilei@itsport.club>
     * @createAt 2018/3/7
     * @param $cards
     * @param $venueId
     * @return mixed|null
     */
    public function getMySortMaxCard($cards, $venueId)
    {
        //本场馆卡片
        $curVenueCards  = [];
        //其他场馆卡片
        $restVenueCards = [];
        //获取本场馆卡和其他场馆卡
        foreach ($cards as $k => $v){
            if($v['venue_id'] == $venueId){
                array_push($curVenueCards, $v);
            }else{
                array_push($restVenueCards, $v);
            }
        }
        //获取当前场馆有效卡片
        if(!empty($curVenueCards)){
            $tmpCardsStorage   = $this->gainDiffTypeCards($curVenueCards);
            $activeTimeCards   = $tmpCardsStorage[0];
            $noActiveTimeCards = $tmpCardsStorage[1];
            $activeRideCards   = $tmpCardsStorage[2];
            $activeMoneyCards  = $tmpCardsStorage[3];
            $activeMixCards    = $tmpCardsStorage[4];
        }else{
            $activeTimeCards   = [];
            $noActiveTimeCards = [];
            $activeRideCards   = [];
            $activeMoneyCards  = [];
            $activeMixCards    = [];
        }
        //获取其他场馆有效卡片
        if(!empty($restVenueCards)){
            $restData          = $this->getActiveCards($restVenueCards,$venueId);
            $otherCardsStorage = $this->gainDiffTypeCards($restData);
            $timeCard    = $otherCardsStorage[0];
            $notTimeCard = $otherCardsStorage[1];
            $rideCard    = $otherCardsStorage[2];
            $moneyCard   = $otherCardsStorage[3];
            $mixCard     = $otherCardsStorage[4];
        }else{
            $timeCard    = [];
            $notTimeCard = [];
            $rideCard    = [];
            $moneyCard   = [];
            $mixCard     = [];
        }
        $fun = function ($p, $k, $where){
            for($n=1; $n<count($p); $n++){
                for($i=0; $i<count($p)-$n; $i++){
                    if($p[$i][$k] > $p[$i+1][$k]){
                        $tmp     = $p[$i];
                        $p[$i]   = $p[$i+1];
                        $p[$i+1] = $tmp;
                    }
                }
            }
            if($where == 'one'){
                return current($p);
            }else{
                return end($p);
            }
        };
        //时间卡
        if(count($activeTimeCards) == 1){
            return $activeTimeCards[0];
        }elseif(count($activeTimeCards) > 1){
            $data = $this->getActiveCards($activeTimeCards, $venueId);
            $numOne   = [];
            $numTwo   = [];
            foreach ($data as $k => $v) {
                if ($v['level'] == 2) {
                    array_push($numOne, $v);
                } else {
                    array_push($numTwo, $v);
                }
            }
            if(count($numOne)==1){
                return $numOne[0];
            }elseif(count($numOne) > 1){
                return call_user_func($fun, $numOne, 'active_time', 'one');
            }elseif(count($numTwo) > 1){
                return call_user_func($fun, $numTwo, 'active_time', 'one');
            }else{
                return $numTwo[0];
            }
         //次卡
        }elseif(count($activeRideCards) == 1){
            return $activeRideCards[0];
        }elseif(count($activeRideCards) > 1){
            return call_user_func($fun, $activeRideCards, 'consumption_times', 'end');
            //储值卡
        }elseif(!empty($activeMoneyCards)){
            return $activeMoneyCards[0];
            //混合卡
        }elseif(!empty($activeMixCards)){
            return $activeMixCards[0];
        }else{
            if(!empty($noActiveTimeCards)){
                //未激活时间卡
                $passCards = $this->getActiveCards($noActiveTimeCards, $venueId);
                $numOne    = [];
                $numTwo    = [];
                foreach ($passCards as $k => $v) {
                    if ($v['level'] == 2) {
                        array_push($numOne, $v);
                    } else {
                        array_push($numTwo, $v);
                    }
                }
                if(!empty($numOne)){
                    return $numOne[0];
                }else{
                    return $numTwo[0];
                }
            }else{
                 if(count($timeCard) == 1){
                        return $timeCard[0];
                    }elseif(count($timeCard) > 1){
                        return call_user_func($fun, $timeCard, 'active_time', 'one');
                    }elseif(count($rideCard) == 1){
                        return $rideCard[0];
                    }elseif(count($rideCard) > 1){
                        return call_user_func($fun, $rideCard, 'consumption_times', 'end');
                    }elseif(!empty($moneyCard)){
                    return $moneyCard[0];
                }elseif(!empty($mixCard)){
                    return $mixCard[0];
                }elseif(!empty($notTimeCard)){
                    return $notTimeCard[0];
              }else{
                    return NULL;
                }
            }
        }
    }
    /**
     * 运运动-筛选-获取不同场馆会员卡等级 和 通店卡片
     * @author杨慧磊<yanghuilei@itsport.club>
     * @createAt 2018/3/7
     * @param $cards
     * @param $venueId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getActiveCards($cards, $venueId)
    {
        $memberCardId  = array_column($cards, 'id');
        $models        = MemberCard::find()->alias('mc')
                            ->joinWith(['cardCategory ccg' => function($q){
                                $q->joinWith(['cardCategoryType cct']);
                            }], false)
                            ->joinWith(['venueLimitTimesArr vlt'], false)
                            ->where(['mc.id' => $memberCardId])
                            ->andWhere([
                                'or',
                                ['vlt.venue_id' => $venueId],
                                ['like', 'vlt.venue_ids', '"' . $venueId . '"']
                            ])
                            ->select('
                                   mc.id,
                                   mc.card_number as cardNumber,
                                   mc.active_time,
                                   mc.invalid_time,
                                   mc.total_times,
                                   mc.consumption_times,
                                   mc.balance,
                                   mc.venue_id,
                                   cct.id cardType,
                                   vlt.level
                                           ')
                            ->asArray()
                            ->groupBy('mc.id')
                            ->all();
                            return $models;
    }
}