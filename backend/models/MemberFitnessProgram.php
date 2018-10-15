<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/27 0027
 * Time: 上午 10:07
 */
namespace backend\models;
use common\models\Func;
use common\models\relations\MemberFitnessProgramRelations;

class MemberFitnessProgram extends \common\models\base\MemberFitnessProgram
{
    public $venueId;
    public $plan;
    public $send;
    public $keyword;
    public $startTime;
    public $endTime;
    const VENUE_ID = 'venueId';
    const PLAN     = 'plan';
    const SEND     = 'send';
    const KEYWORD  = 'keyword';
    use MemberFitnessProgramRelations;

    /**
     * 云运动 - 会员维护 - 获取上过私教课的会员列表
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/27
     * @return array
     */
    public function fitnessMemberList($params)
    {
        $this->autoLoad($params);
        $query = Member::find()
            ->alias('member')
            ->joinWith(['memberDetails md'],false)
            ->joinWith(['aboutClass ac' => function($query){
                $query->joinWith(['employee ee'],false);
                $query->where(['IS NOT','ac.id',null]);
            }],false)
            ->joinWith(['memberFitnessProgram mfp'],false)
            ->joinWith(['fitnessProgramSend fps'],false)
            ->where(['ac.status' => 4,'ac.type' => 1])
            ->select(
                'member.id,
                 member.mobile,
                 md.name as memberName,
                 ee.name as privateName,
                 mfp.id as programId,
                 fps.send_time,
                ')
            ->groupBy('member.id')
            ->orderBy('ac.class_date DESC')
            ->asArray();
        $query = $this->searchWhere($query);
        return Func::getDataProvider($query,8);
    }

    /**
     * @会员维护 - 会员列表 - 处理搜索字段
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/27
     * @param  $params
     * @return array
     */
    public function autoLoad($params)
    {
        $roleId       =   \Yii::$app->user->identity->level;
        if($roleId == 0){
            $vId      =    Organization::find()->select('id')->where(['style'=>2])->asArray()->all();
            $venueIds =    array_column($vId, 'id');
        }else{
            //拿到用户有权限查看的场馆
            $venuesId =    Auth::findOne(['role_id' => $roleId])->venue_id;
            $authId   =    json_decode($venuesId);
            //去掉组织架构里面设置"不显示"的场馆id
            $venues   =    Organization::find()->where(['id'=>$authId])->andWhere(['is_allowed_join'=>1])->select(['id','name'])->asArray()->all();
            $venueIds =    array_column($venues, 'id');
        }
        $this->venueId = (isset($params[self::VENUE_ID]) && !empty($params[self::VENUE_ID])) ? $params[self::VENUE_ID] : $venueIds;
        $this->plan    = (isset($params[self::PLAN]) && !empty($params[self::PLAN])) ? $params[self::PLAN] : null;
        $this->send    = (isset($params[self::SEND]) && !empty($params[self::SEND])) ? $params[self::SEND] : null;
        $this->keyword = (isset($params[self::KEYWORD]) && !empty($params[self::KEYWORD])) ? $params[self::KEYWORD] : null;
        if(isset($this->send) && $this->send == 'd'){
            $this->startTime = strtotime(Func::getGroupClassDate($this->send,true));
            $this->endTime   = strtotime(Func::getGroupClassDate($this->send,false));
        }elseif(isset($this->send) && $this->send == 'w'){
            $this->startTime = strtotime(Func::getGroupClassDate($this->send,true));
            $this->endTime   = strtotime(Func::getGroupClassDate($this->send,false));
        }elseif(isset($this->send) && $this->send == 'm'){
            $this->startTime = strtotime(Func::getGroupClassDate($this->send,true));
            $this->endTime   = strtotime(Func::getGroupClassDate($this->send,false));
        }
        return true;
    }

    /**
     * @会员维护 - 会员列表 - 搜索字段
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/27
     * @param  $query
     * @return array
     */
    public function searchWhere($query)
    {
        $query->andFilterWhere(['member.venue_id' => $this->venueId]);
        if(isset($this->plan) && $this->plan == '1'){     //未添加计划
            $query->andWhere(['mfp.id' => null]);
        }elseif(isset($this->plan) && $this->plan == '2'){
            $query->andWhere(['IS NOT','mfp.id',null]);
        }
        if(isset($this->send)){
            $query->andWhere(['or',['<','fps.send_time',$this->startTime],['fps.send_time' => null]]);
        }
        $query->andFilterWhere(['or',
            ['member.mobile' => $this->keyword],
            ['like','md.name',$this->keyword]
        ]);
        return $query;
    }

    /**
     * 云运动 - 会员维护 - 获取会员健身详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/27
     * @return array
     */
    public function getMemberFitness($memberId)
    {
        $data = MemberFitnessProgram::find()
            ->alias('program')
            ->joinWith(['fitness fitness'],false)
            ->joinWith(['diet diet'],false)
            ->where(['member_id' => $memberId])
            ->select(
                'program.id,
                 program.member_id,
                 program.target_weight,
                 program.fitness_id,
                 program.diet_id,
                 fitness.name as fitnessName,
                 fitness.content as fitnessContent,
                 diet.name as dietName,
                 diet.content as dietContent,
                ')
            ->asArray()
            ->one();
        return $data;
    }
}