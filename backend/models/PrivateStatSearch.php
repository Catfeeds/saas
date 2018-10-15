<?php
namespace backend\models;

use backend\models\AboutClass;
use backend\models\Employee;
use backend\models\Member;
use backend\models\FollowMember;
use backend\models\MemberCourseOrder;
use backend\models\MemberCourseOrderDetails;
use common\models\Func;
use yii\base\Model;
use Yii;
use yii\db\Expression;


class PrivateStatSearch extends Model
{
    public $org_id ;
    public $member_type ;
    public $date_type;//1最近30天，2最近12个月，3今日
    public $keyWord ;
    public $sex;
    public $private_id;
    public $status;//1正式2潜在
    public $type;//1有效2到期
    public $start_time;
    public $end_time;
    public $course_type;//1收费2体验
    public $class_type;//课种
    public $order_type;//1新单2续费
    public $overage_section;
    public $days;//最近多少天
    /**
     * @desc: 业务后台 - 私教统计 - 私教正式会员量
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */
    public function searchMemberNumByPrivater($params)
    {
        $this->loadParam($params);
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['member m'],false)
            ->joinWith(['employeeS e'],false)
            ->joinWith(['memberDetails md'],false)
            ->select('mco.private_id,e.name,COUNT(DISTINCT mco.member_id) as num ')
            ->groupBy('mco.private_id')
            ->asArray()
            ->orderBy('num desc');
        $query = $this->setWhereMemberNum($query);
        return $query;
    }
    /**
     * @desc: 业务后台 - 客户统计 - 查询私教正式会员列表BY私教id
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/23
     */
    public function searchMemberListByPrivater($params)
    {
        $this->loadParam($params);
        $query = MemberCourseOrder::find()
            ->select(new Expression('DISTINCT mco.member_id,m.mobile,md.name,md.sex,c.name as c_name,e.name as p_name,mco.private_id'))
            ->joinWith(['member m'],false)
            ->joinWith(['memberDetails md'],false)
            ->joinWith(['memberCourseOrderDetails mcod'=> function($query){
                $query->joinWith(['course c'],false);
            }],false)
            ->joinWith(['employeeS e'],false)
            ->alias('mco')
            ->where(['mco.private_id'=>$this->private_id])
            ->groupBy('mco.member_id')
            ->asArray();
        $query = $this->setWhereMemberNum($query);
        return $query;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 私教正式会员量- 参数
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */

    public function setWhereMemberNum($query)
    {
        $query->andWhere([
            'and',
            ['<>','mco.private_id',0],
            ['mco.product_type'=>1],
            ['IS NOT','mco.private_id', null],
            ['IS NOT','e.name', null],
            ['m.member_type' => 1]
        ]);
        if($this->org_id){
            $query->andFilterWhere(['e.venue_id'=>$this->org_id]);
        }
        if($this->sex==1 || $this->sex==2){
            $query->andFilterWhere(['md.sex'=>$this->sex]);
        }
        if($this->sex==3){
            $query->andWhere([
                'or',
                ['not in','md.sex',[1,2]],
                ['IS','md.sex', null]
            ]);
           // $query->andFilterWhere(['not in','md.sex',[1,2]]);
        }
        if($this->keyWord){
            $query->andFilterWhere([
                'or',
                ['like','md.name', $this->keyWord],
                ['m.mobile' => $this->keyWord]
            ]);
        }
        if(!empty($this->member_type)){
            if($this->member_type == 1){
                $query->andWhere(['>=','mco.deadline_time',time()]);    //有效会员
                $query->andWhere(['IS NOT','mco.deadline_time',null]);
            }else{
                $query->andWhere(['<','mco.deadline_time',time()]);    //到期会员
                $query->andWhere(['IS NOT','mco.deadline_time',null]);
            }
        }
        if(!empty($this->course_type)){
            if($this->course_type == 1){
                $query->andWhere(['mco.course_type'=>2]);    //潜在会员
            }else{
                $query->andWhere(['mco.course_type'=>1]);    //正式会员
            }
        }
        return $query;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 私教会员量- 参数处理
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */
    public function loadParam($params)
    {
        $this->org_id = (isset($params['org_id']) && !empty($params['org_id'])) ? (int)($params['org_id']) : null;
        $this->member_type = (isset($params['member_type']) && !empty($params['member_type'])) ? (int)($params['member_type']) : null;
        $this->date_type = (isset($params['date_type']) && !empty($params['date_type'])) ? (int)($params['date_type']) :null;
        $this->keyWord = (isset($params['keyWord']) && !empty($params['keyWord'])) ? ($params['keyWord']) : null;
        $this->sex = (isset($params['sex']) && !empty($params['sex'])) ? (int)($params['sex']) : null;
        $this->type = (isset($params['type']) && !empty($params['type'])) ? (int)($params['type']) : null;
        $this->days = (isset($params['days']) && !empty($params['days'])) ? (int)($params['days']) : 3;
        $this->order_type = (isset($params['order_type']) && !empty($params['order_type'])) ? (int)($params['order_type']) : null;
        $this->class_type = (isset($params['class_type']) && !empty($params['class_type'])) ? (int)($params['class_type']) : null;
        $this->status = (isset($params['status']) && !empty($params['status'])) ? (int)($params['status']) : null;
        $this->overage_section = (isset($params['overage_section']) && !empty($params['overage_section'])) ? (int)($params['overage_section']) : null;
        $this->private_id = (isset($params['private_id']) && !empty($params['private_id'])) ? (int)($params['private_id']) : null;
        $this->start_time = (isset($params['start_time']) && !empty($params['start_time'])) ? strtotime($params['start_time']) : null;
        $this->end_time = (isset($params['end_time']) && !empty($params['end_time'])) ? strtotime($params['end_time']) : null;
        $this->course_type = (isset($params['course_type']) && !empty($params['course_type'])) ? (int)($params['course_type']) : null;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 私教客户分析
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */

    public function searchMemberInfo($params)
    {
        $this->loadParam($params);
        //性别统计
        $query = Member::find()
            ->alias('m')
            ->select(new Expression('CASE WHEN md.sex = \'1\' THEN \'男\'
                               WHEN md.sex = \'2\' THEN \'女\' 
                               ELSE \'其他\' 
                               END as a_sex,COUNT( DISTINCT m.id) as num '))
            ->joinWith(['memberDetails md'],false)
            ->joinWith(['memberCard mc'],false)
            //->groupBy('m.id')
            ->addGroupBy('a_sex')
            ->asArray();
            $query = $this->setWhereMemberInfo($query);
        return $query;
    }

    /**
     * @desc: 业务后台 - 私教统计 - 私教会员量- 参数
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */

    public function setWhereMemberInfo($query)
    {
        $query->andFilterWhere(['m.member_type'=>[1,3]]);
        if($this->org_id){
            $query->andFilterWhere(['m.venue_id'=>$this->org_id]);
        }
        if(!empty($this->member_type)){
            $arrId    = $this->getDeal();
            if($this->member_type == 2){    //未购买私课
                $query->andWhere(['NOT IN','m.id',$arrId]);
            }else{    //已购买私课
                $query->andWhere(['m.id' => $arrId]);
            }
        }
        return $query;
    }

    /**
     * @desc: 业务后台 - 私教统计 - 新增会员分析
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */
    public function searchNewMemberInfo($params)
    {
        $this->loadParam($params);
        if($params['date_type']==1){
            $select = new Expression("FROM_UNIXTIME(mco.create_at, \"%Y-%m-%d\") as date,COUNT(DISTINCT mco.member_id) as num ");
        }else{
            $select = new Expression("FROM_UNIXTIME(mco.create_at, \"%Y-%m\") as date,COUNT(DISTINCT mco.member_id) as num ");
        }
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['member m'],false)
            ->select($select)
            ->where(['m.member_type' => 1,'mco.course_type'=>1,'product_type'=>1])
            ->groupBy('date')
            ->asArray();
        $query = $this->setWhereNewMemberInfo($query);
        return $query;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 私教会员量- 条件
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */

    public function setWhereNewMemberInfo($query)
    {
        if($this->org_id){

            $query->andFilterWhere(['m.venue_id'=>$this->org_id]);
        }
        if($this->date_type ==1){//最近30天
            $query->andFilterWhere([
                'and',
                ['>=','mco.create_at',strtotime("-30 day")],
                ['<=','mco.create_at',time()],
            ]);
        }
        if($this->date_type ==2){//最近12个月
            $query->andFilterWhere([
                'and',
                ['>=','mco.create_at',strtotime("-12 month")],
                ['<=','mco.create_at',time()],
            ]);
        }
        return $query;
    }

    /**
     * @desc: 业务后台 - 私教统计 - 今日概况-新增潜在(今日新增已购卡未购课会员数量)
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */
    public function searchMemberPotential($params,$date)
    {
        //新增已购卡未购课会员数量
        $this->loadParam($params);
        //新增潜在
        $data = MemberCard::find()
            ->alias('mc')
            ->joinWith(['memberCourseOrder mco'],false)
            ->select('COUNT(DISTINCT  mc.id) as num')
            ->where(['and',
                ['FROM_UNIXTIME(mc.create_at, "%Y-%m-%d")'=>$date],
                ['mc.venue_id'=>$this->org_id ]
            ])
            ->asArray()
            ->scalar();
        return $data?:0;

    }

    /**
     * @desc: 业务后台 - 私教统计 - 今日概况-新增购课会员(今日新增购课会员数量)
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */
    public function searchBuyClass($params,$date)
    {
        $this->loadParam($params);
        //新增购课
        $data =  MemberCourseOrder::find()
            ->alias('mco')
            ->select(new Expression("FROM_UNIXTIME(MIN(mco.create_at), \"%Y-%m-%d\") as date") )
            ->joinWith(['order o'],false)
            ->where(['o.venue_id'=>$this->org_id ,'mco.course_type'=>1,'mco.product_type'=>1])
            ->groupBy('mco.member_id')
            ->having(['date'=>$date])
            ->asArray()
            ->count();
        return $data?:0;

    }
    /**
     * @desc: 业务后台 - 私教统计 - 今日概况-新增订单金额(所有今日购课订单总金额)
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */
    public function searchSumMoney($params,$date)
    {
        $this->loadParam($params);
        //新增购课
        $data =  MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['order o'])
            ->select("SUM(mco.money_amount) as num ")
            ->where(['FROM_UNIXTIME(mco.create_at, "%Y-%m-%d")'=>$date,'o.venue_id'=>$this->org_id ])
            ->asArray()
            ->scalar();
        return $data?:'0.00';

    }
    /**
     * @desc: 业务后台 - 私教统计 - 今日概况-新增订单数(所有今日购课订单总数量)
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */
    public function searchOrderNum($params,$date)
    {
        $this->loadParam($params);
        //购课订单总数量
        $data =  MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['order o'])
            ->select("COUNT(mco.id) as num ")
            ->where(['FROM_UNIXTIME(mco.create_at, "%Y-%m-%d")'=>$date,'o.venue_id'=>$this->org_id ])
            ->asArray()
            ->scalar();
        return $data?:0;
    }

    /**
     * @desc: 业务后台 - 私教统计 - 今日概况-体验课总节数(体验课上课量)
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */
    public function searchClassNumFree($params,$date)
    {
        $this->loadParam($params);

        //体验课上课量
        $data = AboutClass::find()
            ->alias('ac')
            ->select('COUNT(DISTINCT ac.id)')
            ->joinWith(['memberCourseOrderDetails mcod' => function($query){
                $query->joinWith(['memberCourseOrder mco']);
                $query->joinWith(['course c'],false);
            }],false)
            ->joinWith(['employee p'],false)
            ->joinWith(['member m'],false)
            ->joinWith(['memberDetails md'],false)
            ->where(['and',
               ['ac.class_date'=>$date],
               ['ac.status'=>[4]],
               ['mco.course_type'=>2,'mco.product_type'=>1],
               ['p.venue_id'=>$this->org_id ]
           ])
           ->asArray()
           ->scalar();
        return $data?:0;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 今日概况-收费总节数(收费课上课量)
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/13
     */
    public function searchClassNumNoFree($params,$date)
    {
        $this->loadParam($params);

        //收费课上课量
      /*  $data = AboutClass::find()
            ->alias('ac')
            ->joinWith(['member m'],false)
            ->joinWith(['memberCourseOrderDetails mcod'=> function($query){
                $query->joinWith(['memberCourseOrder mco'],false);
            }],false)
            ->select('COUNT(DISTINCT ac.id)')
            ->where(['and',
                ['ac.class_date'=>$date],
                ['mco.course_type'=>1,'mco.product_type'=>1],
                ['m.venue_id'=>$this->org_id ],
                ['ac.status'=>[4]],
            ])
            ->asArray()
            ->scalar();*/
        $data = AboutClass::find()
            ->alias('ac')
            ->select('COUNT(DISTINCT ac.id)')
            ->joinWith(['memberCourseOrderDetails mcod' => function($query){
                $query->joinWith(['memberCourseOrder mco']);
                $query->joinWith(['course c'],false);
            }],false)
            ->joinWith(['employee p'],false)
            ->joinWith(['member m'],false)
            ->joinWith(['memberDetails md'],false)
            ->where(['and',
                ['ac.class_date'=>$date],
                ['mco.course_type'=>1,'mco.product_type'=>1],
                ['p.venue_id'=>$this->org_id ],
                ['ac.status'=>[4]],
            ])
            ->asArray()
            ->scalar();
        return $data?:0;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 客户量
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/13
     */
    public function searchPrivateMember($params)
    {
        $this->loadParam($params);

        $query = Member::find()
            ->alias('m')
            ->joinWith(['memberDetails md'],false)
            ->joinWith(['memberCard mc'],false)
            ->select("m.id,m.mobile, md.member_id, md.name, md.sex")
            ->groupBy('m.id')
            ->asArray();
         return $this->setPrivateMemberWhere($query);
    }
    /**
     * @desc: 业务后台 - 私教统计 - 客户量COUNT
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/13
     */
    public function searchPrivateMemberCount($params)
    {
        $this->loadParam($params);
        $query = Member::find()
            ->alias('m')
            ->joinWith(['memberDetails md'],false)
            ->joinWith(['memberCard mc'],false)
            ->groupBy('m.id')
            ->asArray();
        $query = $this->setPrivateMemberWhere($query);
        return $query->count();
    }
    /**
     * @desc: 业务后台 - 私教统计 -客户量- 条件
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/13
     */

    public function setPrivateMemberWhere($query)
    {
        $query->andFilterWhere(['m.member_type'=>[1,3]]);
        if($this->org_id){
            $query->andFilterWhere(['m.venue_id'=>$this->org_id]);
        }
        if($this->keyWord){
            $query->andFilterWhere([
                'or',
                ['like','md.name', $this->keyWord],
                ['m.mobile' => $this->keyWord]
            ]);
        }
        if($this->sex){
            $query->andFilterWhere(['md.sex'=>$this->sex]);
        }
        if(!empty($this->status)){
            $arrId    = $this->getDeal();
            if($this->status == 1){    //未购买私课
                $query->andWhere(['NOT IN','m.id',$arrId]);
            }else{    //已购买私课
                $query->andWhere(['m.id' => $arrId]);
            }
        }
        if(!empty($this->type)){
            if($this->type == 1){
                $query->andWhere(['>=','mco.deadline_time',time()]);    //有效会员
                $query->andWhere(['IS NOT','mco.deadline_time',null]);
            }else{
                $query->andWhere(['<','mco.deadline_time',time()]);    //到期会员
                $query->andWhere(['IS NOT','mco.deadline_time',null]);
            }
        }
        return $query;
    }
    /**
     * @desc: 业务后台 - 私教统计 -客户量- 上课量统计 - 获取收费课程
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/13
     */
    public function getDeal()
    {
        $data =  MemberCourseOrder::find()
            ->where(['or',['course_type'=>1],['course_type'=>null]])
            ->andWhere(['>','money_amount',0])
            //->andFilterWhere(['private_id'=>$this->private_id])
            ->asArray()
            ->all();
        return array_column($data,'member_id');
    }

    /**
     * @desc: 业务后台 - 私教统计 - 最近未上课  最近多少天未上课
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/13
     */
    public function searchNotGoClassMember($params)
    {
        $this->loadParam($params);
        $date =  strtotime('-'.$this->days. 'days');
   /*     $query = AboutClass::find()
            ->alias('ac')
            ->select('m.mobile,md.name,md.sex,ac.member_id,e.name as p_name,max(ac.create_at) as date')
            ->joinWith(['member m'],false)
            ->joinWith(['memberDetails md'],false)
            ->joinWith(['employee e'],false)
            ->groupBy('ac.member_id')
            ->having(['<','max(ac.create_at)',$date]);
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->select('mco.member_id,md.name,m.mobile,md.sex,e.name as p_name,max(ac.create_at) as date')
            ->joinWith(['memberCourseOrderDetails mcd'=> function($query){
                $query->joinWith(['aboutClass ac'],false);
            }],false)
            ->joinWith(['member m'],false)
            ->joinWith(['memberDetails md'],false)
            ->joinWith(['employeeS e'],false)
            ->groupBy('date')
            ->having(['<','date',intval($date)])
            ->asArray()->createCommand()->getRawSql();*/

        $query = MemberCourseOrderDetails::find()->alias('mcd')
            ->select('mco.member_id,md.name,m.mobile,e.name as p_name,md.sex,max(ac.create_at) as time,c.name as c_name')
            ->alias('mcd')
            ->joinWith(['aboutClass ac'=> function($query){
                $query->joinWith(['employee e'],false);
            }],false)
            ->joinWith(['course c'],false)
            ->joinWith(['memberCourseOrder mco'=> function($query){
                $query->joinWith(['member m'],false);
                $query->joinWith(['memberDetails md'],false);
            }],false)
            ->where(['ac.type'=>1,'mco.course_type'=>1])
            ->groupBy('ac.member_id')
            ->having(['<','time',intval($date)]);
        return $this->setNotGoClassMemberWhere($query);
    }
    /**
     * @desc: 业务后台 - 私教统计 - 客户统计-最近多少天未上课人数
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/14
     */
    public function searchNotGoClassMemberNum($params)
    {
        $this->loadParam($params);
        $date =  strtotime('-3days');
        $query= MemberCourseOrderDetails::find()
            ->alias('mcd')
            ->select('max(ac.create_at) as time')
            ->alias('mcd')
            ->joinWith(['aboutClass ac'=> function($query){
                $query->joinWith(['employee e'],false);
            }],false)
            ->joinWith(['memberCourseOrder mco'],false)
            ->where(['ac.type'=>1,'mco.course_type'=>1])
            ->groupBy('ac.member_id')
            ->having(['<','time',intval($date)]);
        if($this->org_id){
            $query->andFilterWhere(['e.venue_id'=>$this->org_id]);
        }
        return $query->count();
    }
    /**
     * @desc: 业务后台 - 私教统计 - 客户统计-最近多少天未上课-where
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/14
     */
    public function setNotGoClassMemberWhere($query)
    {
        $query->andFilterWhere(['ac.type'=>1]);
        if($this->org_id){
            $query->andFilterWhere(['e.venue_id'=>$this->org_id]);
        }
        if($this->keyWord){
            $query->andFilterWhere([
                'or',
                ['like','md.name', $this->keyWord],
                ['m.mobile' => $this->keyWord]
            ]);
        }
        if($this->private_id){
            $query->andFilterWhere(['ac.coach_id'=>$this->private_id]);
        }
        return $query;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 即将到期（私教课）
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/13
     */
    public function searchSoonToExpireMember($params)
    {
        $this->loadParam($params);
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->select('mco.member_id,md.name,md.sex,m.mobile,c.name as c_name,p.name as p_name,mco.course_amount,mco.overage_section,mco.deadline_time')
            ->joinWith(['memberCourseOrderDetails mcd'=> function($query){
                $query->joinWith(['course c'],false);
            }],false)
            ->joinWith(['member m'],false)
            ->joinWith(['employeeS p'],false)
            ->joinWith(['memberDetails md'],false);
        $query = $this->setSoonToExpireWhere($query);
        return $query;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 即将到期（私教课）-where条件
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/13
     */
    public function setSoonToExpireWhere($query)
    {
        if($this->org_id){
            $query->andFilterWhere(['m.venue_id'=>$this->org_id]);
        }
        if($this->keyWord){
            $query->andFilterWhere([
                'or',
                ['like','md.name', $this->keyWord],
                ['m.mobile' => $this->keyWord]
            ]);
        }
        if($this->private_id){
            $query->andFilterWhere(['mco.private_id'=>$this->private_id]);
        }
        if($this->start_time && $this->end_time){
            $query->andFilterWhere(['between','mco.deadline_time',$this->start_time, $this->end_time]);
        }
        //剩余节数
        if($this->overage_section){
            $query->andFilterWhere(['mco.overage_section'=>$this->overage_section]);
        }
        return $query;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 客户统计-最近未跟进
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/14
     */
    public function searchNotFollow($params)
    {
        $this->loadParam($params);
        $date = date('Y-m-d', strtotime('-'.$this->days. 'days'));
        //最近跟进记录默认3天
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->leftJoin(Member::tableName().' m','m.id=mco.member_id')
            ->select('m.id,md.name,md.sex,m.mobile,e.name as p_name,max(fw.actual_time) as actual_time')
            ->leftJoin(FollowMember::tableName().' fw','m.id=fw.member_id and fw.operation=0 and actual_time<'.$date)
            ->leftJoin(Employee::tableName().' e','e.id=fw.coach_id')
            ->leftJoin(MemberDetails::tableName().' md','m.id=md.member_id')
            ->where(['fw.member_id'=>null])
            ->groupBy('mco.member_id')
            ->asArray();
        return $this->setNotFollowWhere($query);
    }
    /**
     * @desc: 业务后台 - 私教统计 - 客户统计-最近3天未跟进人数
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/14
     */
    public function searchNotFollowNum($params,$days)
    {
        $this->loadParam($params);
        $date =  date('Y-m-d h:i:s', strtotime('-'.$days.' days'));
        //最近跟进记录默认3天
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->select('max(fw.actual_time) as actual_time')
            ->leftJoin(Member::tableName().' m','m.id=mco.member_id')
            ->leftJoin(FollowMember::tableName().' fw',"m.id=fw.member_id and fw.operation=0 and actual_time<'$date'")
            ->where(['fw.member_id'=>null])
            ->asArray();
        if($this->org_id){
            $query->andFilterWhere(['m.venue_id'=>$this->org_id]);
        }
        return $query->count('DISTINCT mco.member_id');
    }


    /**
     * @desc: 业务后台 - 私教统计 - 客户统计-最近未跟进-where
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/14
     */
    public function setNotFollowWhere($query)
    {
        if($this->org_id){
            $query->andFilterWhere(['m.venue_id'=>$this->org_id]);
        }
        if($this->keyWord){
            $query->andFilterWhere([
                'or',
                ['like','md.name', $this->keyWord],
                ['m.mobile' => $this->keyWord]
            ]);
        }
        if($this->private_id){
            $query->andFilterWhere(['fw.coach_id'=>$this->private_id]);
        }
        return $query;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 体验课未执行（私教课）
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/13
     */
    public function searchClassNotExecuted($params)
    {
        $this->loadParam($params);
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->select('mco.member_id,md.name,md.sex,m.mobile,c.name as c_name,p.name as p_name,mco.create_at,mco.course_amount,mco.overage_section,mco.deadline_time')
            ->joinWith(['memberCourseOrderDetails mcd'=> function($query){
                $query->joinWith(['course c'],false);
            }],false)
            ->joinWith(['member m'],false)
            ->joinWith(['employeeS p'],false)
            ->where("`mco`.`course_amount` = `mco`.`overage_section`")
            ->joinWith(['memberDetails md'],false);
        $query = $this->setClassNotExecutedWhere($query);
        return $query;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 体验课未执行（私教课）-where条件
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/13
     */
    public function setClassNotExecutedWhere($query)
    {
        $query->andFilterWhere(['and',['mco.product_type'=>1,'mco.course_type'=>2],['<>','mco.course_amount',0]]);
        if($this->org_id){
            $query->andFilterWhere(['m.venue_id'=>$this->org_id]);
        }
        if($this->keyWord){
            $query->andFilterWhere([
                'or',
                ['like','md.name', $this->keyWord],
                ['m.mobile' => $this->keyWord]
            ]);
        }
        if($this->private_id){
            $query->andFilterWhere(['mco.private_id'=>$this->private_id]);
        }
        if($this->start_time && $this->end_time){
            $query->andFilterWhere(['between','mco.create_at',$this->start_time, $this->end_time]);
        }
        return $query;
    }

    /**
     * @desc: 业务后台 - 私教统计 - 上课统计-上课量
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/14MemberDetails
     */
    public function searchPrivateAttendClass($params)
    {
        $this->loadParam($params);
        $query = AboutClass::find()
            ->alias('ac')
            ->select('mco.member_id,md.name,md.sex,m.mobile,c.name as c_name,p.name as p_name,ac.id,
                     mco.course_type,ac.class_id,ac.coach_id,ac.start,ac.end')
            ->joinWith(['memberCourseOrderDetails mcod' => function($query){
                $query->joinWith(['memberCourseOrder mco']);
                $query->joinWith(['course c'],false);
            }],false)
            ->joinWith(['employee p'],false)
            ->joinWith(['member m'],false)
            ->joinWith(['memberDetails md'],false)
            ->where(['ac.type'=>1,'ac.status'=>[4]]);


        $query = $this->setPrivateAttendClassWhere($query);

        return $query;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 上课统计-上课量-where条件
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/14
     */
    public function setPrivateAttendClassWhere($query)
    {
        if($this->org_id){
            $query->andFilterWhere(['p.venue_id'=>$this->org_id]);
        }
        if($this->course_type){
            $query->andFilterWhere(['mco.course_type'=>$this->course_type]);
        }
        if($this->keyWord){
            $query->andFilterWhere([
                'or',
                ['like','md.name', $this->keyWord],
                ['m.mobile' => $this->keyWord]
            ]);
        }
        if($this->private_id){
            $query->andFilterWhere(['ac.coach_id'=>$this->private_id]);
        }
        if($this->start_time && $this->end_time){
            $query->andFilterWhere(['between','ac.start',$this->start_time, $this->end_time]);
        }
        return $query;
    }

    /**
     * @desc: 业务后台 - 私教统计 - 上课统计-上课量折线图
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/14
     */
    public function searchPrivateAttendClassChart($params)
    {
        $this->loadParam($params);
        if($params['date_type']==1){
            $select = new Expression("FROM_UNIXTIME(ac.create_at, \"%Y-%m-%d\") as date,COUNT(ac.id) as class_num,COUNT(DISTINCT ac.member_id) as member_num");
        }else{
            $select = new Expression("FROM_UNIXTIME(ac.create_at, \"%Y-%m\") as date,COUNT(ac.id) as class_num ,COUNT(DISTINCT ac.member_id) as member_num");
        }
        $query = AboutClass::find()
            ->alias('ac')
            ->joinWith(['memberCourseOrderDetails mcod' => function($query){
                $query->joinWith(['memberCourseOrder mco']);
            }],false)
            ->joinWith(['member m'],false)
            ->select($select)
            ->where(['ac.type'=>1,'ac.status'=>[4]])
            ->groupBy('date')
            ->asArray();
        $query = $this->setWherePrivateAttendClassChart($query);
        return $query;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 上课统计-课程分析
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/14
     */
    public function searchClassByCourse($params)
    {
        $this->loadParam($params);
        if($params['type']==1){
            $select = new Expression("c.name,COUNT(ac.id) as class_num");
        }else{
            $select = new Expression("c.name,COUNT(DISTINCT ac.member_id) as member_num");
        }
        $query = AboutClass::find()
            ->alias('ac')
            ->joinWith(['memberCourseOrderDetails mcod' => function($query){
                $query->joinWith(['course c']);
            }],false)
            ->joinWith(['member m'],false)
            ->select($select)
            ->where(['ac.type'=>1,'c.pid'=>0,'ac.status'=>[4]])
            ->groupBy('c.name')
            ->asArray();
        return  $this->setWherePrivateAttendClassChart($query);
    }
    /**
     * @desc: 业务后台 - 私教统计 - 上课统计-上课量折线图-where
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/14
     */

    public function setWherePrivateAttendClassChart($query)
    {
        if($this->org_id){

            $query->andFilterWhere(['m.venue_id'=>$this->org_id]);
        }
        if($this->date_type ==1){//最近30天
            $query->andFilterWhere([
                'and',
                ['>=','ac.create_at',strtotime("-30 day")],
                ['<=','ac.create_at',time()],
            ]);
        }
        if($this->date_type ==2){//最近12个月
            $query->andFilterWhere([
                'and',
                ['>=','ac.create_at',strtotime("-12 month")],
                ['<=','ac.create_at',time()],
            ]);
        }
        if($this->date_type ==3){//今日
            $query->andFilterWhere([
                'and',
                ['>=','ac.create_at',strtotime("-1 day")],
                ['<=','ac.create_at',time()],
            ]);
        }
        if($this->course_type){
            $query->andFilterWhere(['mco.course_type'=>$this->course_type]);
        }
        return $query;
    }

    /**
     * @desc: 业务后台 - 私教统计 - 上课统计-预约途径分析
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/15
     */

    public function searchClassSource($params)
    {
        $this->loadParam($params);
        $query =AboutClass::find()
            ->alias('ac')
            ->joinWith(['member m'],false)
            ->select(new Expression('count(ac.id) as num,CASE WHEN ac.about_type = \'1\' THEN \'PC\' 
                               WHEN ac.about_type = \'2\' THEN \'APP\' 
                               WHEN ac.about_type = \'3\' THEN \'小程序\' 
                               ELSE \'其他\' 
                               END as type'))
            ->groupBy('ac.about_type')
            ->asArray();

        return $this->setClassSourceWhere($query);
    }
    /**
     * @desc: 业务后台 - 私教统计 - 上课统计-预约途径分析->条件
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/15
     */
    public function setClassSourceWhere($query)
    {
        $query->andFilterWhere(['ac.type'=>1]);
        if($this->org_id){
            $query->andFilterWhere(['m.venue_id'=>$this->org_id]);
        }
        if($this->date_type ==1){//最近30天
            $query->andFilterWhere([
                'and',
                ['>=','ac.create_at',strtotime("-1 month")],
                ['<=','ac.create_at',time()],
            ]);
        }
        if($this->date_type ==2){//最近1年
            $query->andFilterWhere([
                'and',
                ['>=','ac.create_at',strtotime("-1 year")],
                ['<=','ac.create_at',time()],
            ]);
        }
        if($this->date_type ==3){//今日
            $query->andFilterWhere([
                'and',
                ['>=','ac.create_at',strtotime("-1 day")],
                ['<=','ac.create_at',time()],
            ]);
        }
        return $query;
    }

    /**
     * @desc: 业务后台 - 私教统计 - 上课统计--上课数量统计
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/15
     */
    public function searchAttendClassNum($params)
    {
        $this->loadParam($params);
        $query = AboutClass::find()
            ->alias('ac')
            ->joinWith(['employee e'],false)
            ->joinWith(['memberCourseOrderDetails mcod' => function($query){
                $query->joinWith(['memberCourseOrder mco']);
            }],false)
            ->where(['ac.type'=>1,'ac.status'=>[4]]);


         $query = $this->setAttendClassNumWhere($query);

         return $query->count('ac.id');
    }
    /**
     * @desc: 业务后台 - 私教统计 - 上课统计--上课数量统计-条件
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/15
     */
    public function setAttendClassNumWhere($query)
    {
        if($this->org_id){
            $query->andFilterWhere(['e.venue_id'=>$this->org_id]);
        }
        if($this->start_time && $this->end_time){
            $query->andFilterWhere(['between','ac.create_at',$this->start_time,$this->end_time]);
        }
        if($this->course_type){
            $query->andFilterWhere(['mco.course_type'=>$this->course_type]);
        }
        return $query;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 上课统计--上课人数统计
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/15
     */
    public function searchAttendMemberNum($params)
    {
        $this->loadParam($params);
        $query = AboutClass::find()
            ->alias('ac')
            ->joinWith(['employee e'],false)
            ->joinWith(['memberCourseOrderDetails mcod' => function($query){
                $query->joinWith(['memberCourseOrder mco']);
            }],false)
            ->joinWith(['member m'],false)
            ->joinWith(['memberDetails md'],false)
            ->where(['ac.type'=>1,'ac.status'=>[4]]);

        $query = $this->setAttendMemberNumWhere($query);

        return $query->count('DISTINCT ac.member_id');
    }
    /**
     * @desc: 业务后台 - 私教统计 - 上课统计--上课数量统计-条件
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/15
     */
    public function setAttendMemberNumWhere($query)
    {
        if($this->org_id){
            $query->andFilterWhere(['e.venue_id'=>$this->org_id]);
        }
        if($this->start_time && $this->end_time){
            $query->andFilterWhere(['between','ac.create_at',$this->start_time,$this->end_time]);
        }
        if($this->course_type){
            $query->andFilterWhere(['mco.course_type'=>$this->course_type]);
        }
        return $query;
    }

    /**
     * @私教统计 - 生日会员
     * @desc: 业务后台 - 私教统计 - 上课统计--生日会员
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/15
     */
    public function searchBirthdayMember($params)
    {
        $this->loadParam($params);
        $query = Member::find()
            ->alias('member')
            ->joinWith(['memberDetails md'], false)
            ->joinWith(['memberCourseOrder mco'], false)
            ->where(['member.member_type' => 1])
            ->orWhere(['mco.id' => null,'member.member_type' => 1]);

        $query = $this->setWhereBirthday($query);
        return $query->count('DISTINCT member.id');
    }

    /**
     * @私教统计 - 生日会员
     * @desc: 业务后台 - 私教统计 - 上课统计--生日会员
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/15
     */
    public function setWhereBirthday($query)
    {
        if($this->org_id){
            $query->andFilterWhere(['member.venue_id'=>$this->org_id]);
        }

        if($this->start_time && $this->end_time){
            $query->andFilterWhere([
                'and',
                ['>=','date_format(md.birth_date,"%m-%d")',date("m-d",$this->start_time)],
                ['<=','date_format(md.birth_date,"%m-%d")',date("m-d",$this->end_time)]
            ]);
        }else{
            $query->andFilterWhere([
                'and',
                ['>=','date_format(md.birth_date,"%m-%d")',date("m-d",strtotime('-30day'))],
                ['<=','date_format(md.birth_date,"%m-%d")',date("m-d",time())]
            ]);
        }

        return $query;
    }

    /**
     * @desc: 业务后台 -销售统计-销售成交额
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function searchSaleDeal($params)
    {
        $this->loadParam($params);
        $query =  MemberCourseOrder::find()
            ->alias('mco')
            ->select('mco.id,mco.member_id,md.name,md.sex,m.mobile,mcd.product_name as product_name,p.name as p_name,mco.course_amount as class_num,mco.money_amount,mco.create_at')
            ->joinWith(['memberCourseOrderDetails mcd'=> function($query){
                $query->joinWith(['course c'],false);
            }],false)
            ->joinWith(['memberDetails md'],false)
            ->joinWith(['member m'],false)
            ->joinWith(['employeeS p'],false);

        return $this->setWhereSaleDeal($query);
    }
    /**
     * @desc: 业务后台 -销售统计-销售成交额-where
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function setWhereSaleDeal($query)
    {
        $query->andFilterWhere(['mco.product_type'=>1,'mco.course_type'=>1]);
        if($this->org_id){
            $query->andFilterWhere(['p.venue_id'=>$this->org_id]);
        }

        if($this->class_type){
            $query->andFilterWhere(['c.id'=>$this->class_type]);
        }
        if($this->keyWord){
            $query->andFilterWhere([
                'or',
                ['like','md.name', $this->keyWord],
                ['m.mobile' => $this->keyWord]
            ]);
        }
        if($this->order_type==2){
            $query->andFilterWhere(['like','mco.business_remarks', '续费']);
        }elseif ($this->order_type==1){
            $query->andFilterWhere(['like','mco.business_remarks', '新单']);
        }
        if($this->private_id){
            $query->andFilterWhere(['mco.private_id'=>$this->private_id]);
        }
        if($this->start_time && $this->end_time){
            $query->andFilterWhere(['between','mco.create_at',$this->start_time, $this->end_time]);
        }
        return $query;
    }
    /**
     * @desc: 业务后台 -销售统计-销售成交额-折线图
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function searchSaleDealChart($params)
    {
        $this->loadParam($params);
        if($params['date_type']==1){
            $select = new Expression("FROM_UNIXTIME(mco.create_at, \"%Y-%m-%d\") as date,SUM(mco.money_amount) as money ");
        }else{
            $select = new Expression("FROM_UNIXTIME(mco.create_at, \"%Y-%m\") as date,SUM(mco.money_amount) as money ");
        }
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['member m'],false)
            ->select($select)
            ->groupBy('date')
            ->asArray();

        return $this->setWhereSaleChart($query);
    }
    /**
     * @desc: 业务后台 - 私教统计 - 销售-折线图-where
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/14
     */

    public function setWhereSaleChart($query)
    {
       $query->andFilterWhere(['mco.product_type'=>1,'mco.course_type'=>1]);
        if($this->org_id){
            $query->andFilterWhere(['m.venue_id'=>$this->org_id]);
        }
        if($this->date_type ==1){//最近30天
            $query->andFilterWhere([
                'and',
                ['>=','mco.create_at',strtotime("-1 month")],
                ['<=','mco.create_at',time()],
            ]);
        }
        if($this->date_type ==2){//最近1年
            $query->andFilterWhere([
                'and',
                ['>=','mco.create_at',strtotime("-1 year")],
                ['<=','mco.create_at',time()],
            ]);
        }
        if($this->date_type ==3){//今日
            $query->andFilterWhere([
                'and',
                ['>=','mco.create_at',strtotime("-1 day")],
                ['<=','mco.create_at',time()],
            ]);
        }
        return $query;
    }
    /**
     * @desc: 业务后台 -销售统计-销售成交量-折线图
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function searchSaleDealNumChart($params)
    {
        $this->loadParam($params);
        if($params['date_type']==1){
            $select = new Expression("FROM_UNIXTIME(mco.create_at, \"%Y-%m-%d\") as date,COUNT(mco.id) as num ");
        }else{
            $select = new Expression("FROM_UNIXTIME(mco.create_at, \"%Y-%m\") as date,COUNT(mco.id) as num");
        }
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['member m'],false)
            ->select($select)
            ->groupBy('date')
            ->asArray();

        return $this->setWhereSaleChart($query);
    }
    /**
     * @desc: 业务后台 -销售统计-销售购买人数-折线图
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function searchSaleDealMemberChart($params)
    {
        $this->loadParam($params);
        if($params['date_type']==1){
            $select = new Expression("FROM_UNIXTIME(mco.create_at, \"%Y-%m-%d\") as date,COUNT(DISTINCT mco.member_id) as member_num ");
        }else{
            $select = new Expression("FROM_UNIXTIME(mco.create_at, \"%Y-%m\") as date,COUNT(DISTINCT mco.member_id) as member_num");
        }
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['member m'],false)
            ->select($select)
            ->groupBy('date')
            ->asArray();

        return $this->setWhereSaleChart($query);
    }
    /**
     * @desc: 业务后台 -销售统计-课程分析-成交额
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function searchSaleDealClass($params)
    {
        $this->loadParam($params);
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['member m'],false)
            ->joinWith(['memberCourseOrderDetails mcd'=> function($query){
                $query->joinWith(['course c'],false);
            }],false)
            ->select('c.name,SUM(mco.money_amount) as money')
            ->where(['c.pid'=>0])
            ->groupBy('mcd.course_id')
            ->orderBy('money desc')
            ->asArray();

        return $this->setWhereSaleChart($query);
    }
    /**
     * @desc: 业务后台 -销售统计-课程分析-成交量
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function searchSaleNumClass($params)
    {
        $this->loadParam($params);
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['member m'],false)
            ->joinWith(['memberCourseOrderDetails mcd'=> function($query){
                $query->joinWith(['course c'],false);
            }],false)
            ->select('c.name,COUNT(mco.id) as num')
            ->where(['c.pid'=>0])
            ->groupBy('mcd.course_id')
            ->orderBy('num desc')
            ->asArray();

        return $this->setWhereSaleChart($query);
    }
    /**
     * @desc: 业务后台 -销售统计-课程分析-购买人数
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function searchSaleMemberClass($params)
    {
        $this->loadParam($params);
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['member m'],false)
            ->joinWith(['memberCourseOrderDetails mcd'=> function($query){
                $query->joinWith(['course c'],false);
            }],false)
            ->select('c.name,COUNT(DISTINCT mco.member_id) as member_num')
            ->where(['c.pid'=>0])
            ->groupBy('mcd.course_id')
            ->orderBy('member_num desc')
            ->asArray();

        return $this->setWhereSaleChart($query);
    }
    /**
     * @desc: 业务后台 -销售统计-课程对比-平均成交价
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function searchAverageDealClass($params)
    {
        $this->loadParam($params);
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['member m'],false)
            ->joinWith(['memberCourseOrderDetails mcd'=> function($query){
                $query->joinWith(['course c'],false);
            }],false)
            ->select('c.name,SUM(mco.money_amount) as money,COUNT(mco.id) as num')
            ->where(['c.pid'=>0])
            ->groupBy('c.id')
            ->orderBy('num desc')
            ->asArray();
        return $this->setWhereSaleChart($query);
    }
    /**
     * @desc: 业务后台 -销售统计-课程对比-平均客单价
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function searchSaleUnitPriceClass($params)
    {
        $this->loadParam($params);
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['member m'],false)
            ->joinWith(['memberCourseOrderDetails mcd'=> function($query){
                $query->joinWith(['course c'],false);
            }],false)
            ->select('c.name,SUM(mco.money_amount) as money,COUNT(DISTINCT mco.member_id) as member_num')
            ->where(['c.pid'=>0])
            ->groupBy('mcd.course_id')
            ->orderBy('member_num desc')
            ->asArray();
        return $this->setWhereSaleChart($query);
    }
    /**
     * @desc: 业务后台 -销售统计-销售统计-课程对比-续约率
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function searchSaleRenewalRate($params)
    {
        $this->loadParam($params);
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['member m'],false)
            ->joinWith(['memberCourseOrderDetails mcd'=> function($query){
                $query->joinWith(['course c'],false);
            }],false)
            ->select('c.name,SUM(mco.money_amount) as money,COUNT(DISTINCT mco.d) as num')
            ->where(['c.pid'=>0])
            ->groupBy('mcd.course_id')
            ->orderBy('num desc')
            ->asArray();
        return $this->setWhereSaleChart($query);
    }
    /**
     * @desc: 业务后台 -销售统计-课程对比-流失率
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function searchSaleLossRate($params)
    {
        $this->loadParam($params);
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['member m'],false)
            ->joinWith(['memberCourseOrderDetails mcd'=> function($query){
                $query->joinWith(['course c'],false);
            }],false)
            ->select('c.name,SUM(mco.money_amount) as money,COUNT(DISTINCT mco.member_id) as member_num')
            ->where(['c.pid'=>0])
            ->groupBy('mcd.course_id')
            ->orderBy('member_num desc')
            ->asArray();
        return $this->setWhereSaleChart($query);
    }
    /**
     * @desc: 业务后台 -销售统计-私教销售排行
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function searchSaleRank($params)
    {
        $this->loadParam($params);
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['employeeS e'],false)
            ->select('e.name,SUM(mco.money_amount) as money')
            ->groupBy('mco.private_id')
            ->orderBy('money desc')
            ->asArray();
        return $this->setWhereSaleRank($query);
    }
    /**
     * @desc: 业务后台 -销售统计-私教销售排行-where
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function setWhereSaleRank($query)
    {
        $query->andFilterWhere(['mco.product_type'=>1,'mco.course_type'=>1]);
        if($this->org_id){
            $query->andFilterWhere(['e.venue_id'=>$this->org_id]);
        }
        if($this->order_type==2){
            $query->andFilterWhere(['like','mco.business_remarks', '续费']);
        }elseif ($this->order_type==1){
            $query->andFilterWhere(['like','mco.business_remarks', '新单']);
        }
        if($this->start_time && $this->end_time){
            $query->andFilterWhere(['between','mco.create_at',$this->start_time, $this->end_time]);
        }
        return $query;
    }
    /**
     * @desc: 业务后台 -销售统计-新老客户占比(第一次购课/所有)
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/21
     */
    public function searchFirstDealMember($params)
    {
        $this->loadParam($params);
        //所有第一次购课的人
        $query = MemberCourseOrder::find()
                ->alias('mco')
                ->joinWith(['order o'],false)
                ->select('mco.member_id,COUNT(mco.member_id) as count_num,SUM(mco.money_amount) as money,SUM(mco.course_amount) as class_num')
                ->where(['mco.course_type'=>1])
                ->groupBy('mco.member_id')
                ->having(['count_num'=>1]);
        if($this->org_id){
            $query->andFilterWhere(['o.venue_id'=>$this->org_id]);
        }
        return $query;
    }
    /**
     * @desc: 业务后台 -销售统计-新老客户占比(第一次购课/所有)
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/21
     */
    public function searchAllDealMember($params)
    {
        $this->loadParam($params);
        //所有有课的人
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['order o'],false)
            ->where(['mco.course_type'=>1])
            ->select('mco.member_id,COUNT(mco.member_id) as count_num,SUM(mco.money_amount) as money,SUM(mco.course_amount) as class_num')
            ->groupBy('mco.member_id');
        if($this->org_id){
            $query->andFilterWhere(['o.venue_id'=>$this->org_id]);
        }
        return $query;
    }

    /**
     * @desc: 业务后台 - 销售统计- 成交客户分析-办卡当日成交占比
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/21
     */
    public function searchSameDayDeal($params)
    {
        $this->loadParam($params);
        //办卡当日成交
        $query = MemberCourseOrder::find()
            ->alias('mco')
            ->select("mco.member_id,COUNT(mco.member_id) as count_num,SUM(mco.money_amount) as money,SUM(mco.course_amount) as class_num")
            ->joinWith(['order o'],false)
            ->joinWith(['memberCardS mc'],false)
            ->where(['mco.course_type'=>1])
            ->andWhere("FROM_UNIXTIME(mco.create_at, '%Y-%m-%d') = FROM_UNIXTIME(mc.create_at, '%Y-%m-%d')")
            ->groupBy('mco.member_id');

        if($this->org_id){
            $query->andFilterWhere(['o.venue_id'=>$this->org_id]);
        }
        return $query;
    }
    /**
     * @desc: 业务后台 - 上课统计 - 私教上课排行榜
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/21
     */
    public function searchPrivateClassNum($params)
    {
        $this->loadParam($params);
        $query = AboutClass::find()
            ->alias('ac')
            ->select('e.name as p_name,count(ac.id) as num')
            ->joinWith(['employee e'],false)
            ->joinWith(['memberCourseOrderDetails mcod' => function($query){
                $query->joinWith(['memberCourseOrder mco']);
            }],false)
            ->where(['ac.type'=>1])
            ->andWhere('e.name is not null')
            ->groupBy('ac.coach_id')
            ->asArray()
            ->orderBy('num desc');
        if($this->org_id){
            $query->andFilterWhere(['e.venue_id'=>$this->org_id]);
        }
        if($this->course_type){
            $query->andFilterWhere(['mco.course_type'=>$this->course_type]);
        }
        if($this->start_time && $this->end_time){
            $query->andFilterWhere(['between','ac.create_at',$this->start_time,$this->end_time]);
        }
        return $query;
    }
    /**
     * @desc: 业务后台 - 销售统计 - 体验课成交率
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/21
     */
    public function searchFreeClassDeal($params)
    {
        $this->loadParam($params);
        //私教体验课上课人数
        $query1 =  AboutClass::find()
            ->alias('ac')
            ->joinWith(['employee e'],false)
            ->joinWith(['memberCourseOrderDetails mcod' => function($query){
                $query->joinWith(['memberCourseOrder mco']);
            }],false)
            ->where(['ac.type'=>1,'mco.course_type'=>2])
            ->groupBy('ac.member_id');
        if($this->org_id){
            $query1->andFilterWhere(['e.venue_id'=>$this->org_id]);
        }
        if($this->start_time && $this->end_time){
            $query1->andFilterWhere(['between','ac.create_at',$this->start_time,$this->end_time]);
        }
        $num1 = $query1 ->count();
        $memberIds = $query1->select('ac.member_id')->asArray()->all();
        $memberIds = array_column($memberIds,'member_id');

        //成交人数
        $query2 =  MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['employee e'],false)
            ->where(['mco.course_type'=>1,'member_id'=>$memberIds])
            ->groupBy('mco.member_id');
        if($this->org_id){
            $query2->andFilterWhere(['e.venue_id'=>$this->org_id]);
        }
        if($this->start_time && $this->end_time){
            $query2->andFilterWhere(['between','mco.create_at',$this->start_time,$this->end_time]);
        }
        $num2 = $query2->count();
        return $num1?$num2/$num1:0.00;
    }

}
