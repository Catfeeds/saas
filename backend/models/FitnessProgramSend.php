<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/27 0027
 * Time: 上午 11:44
 */
namespace backend\models;
use common\models\Func;

class FitnessProgramSend extends \common\models\base\FitnessProgramSend
{
    public $venueId;
    public $plan;
    public $send;
    public $keyword;
    public $startTime;
    public $endTime;
    public $type;
    const VENUE_ID = 'venueId';
    const PLAN     = 'plan';
    const SEND     = 'send';
    const KEYWORD  = 'keyword';
    const TYPE     = 'type';

    /**
     * 云运动 - 会员维护 - 发送健身目标短信、发送饮食计划短信（群发）
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/27
     * @return array
     */
    public function sendFitness($params)
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
        $query    = $this->searchWhere($query);
        $memberId = array_column($query->all(),'id');
        foreach ($memberId as $key=>$value) {
            $this->sendFitnessOne($value,$this->type,2);
        }
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
        $this->type    = (isset($params[self::TYPE]) && !empty($params[self::TYPE])) ? $params[self::TYPE] : null;
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
     * 云运动 - 会员维护 - 发送健身目标短信、发送饮食计划短信（单发）
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/30
     * @return array
     */
    public function sendFitnessOne($memberId,$type,$status)
    {
        if($type == '1'){        //发送健身目标
            $query = \backend\models\Member::find()
                ->alias('member')
                ->joinWith(['memberFitnessProgram mfp' => function($query){
                    $query->joinWith(['fitness fitness'],false);
                }],false)
                ->where(['member.id' => $memberId])
                ->select('member.mobile,fitness.name,fitness.content')
                ->asArray()
                ->one();
        }else{
            $query = \backend\models\Member::find()
                ->alias('member')
                ->joinWith(['memberFitnessProgram mfp' => function($query){
                    $query->joinWith(['diet diet'],false);
                }],false)
                ->where(['member.id' => $memberId])
                ->select('member.mobile,diet.name,diet.content')
                ->asArray()
                ->one();
        }
        if($status == 1){
            if($query['mobile'] == 0 || empty($query['mobile'])){
                return '手机号不存在，无法发送';
            }
            if(empty($query['content'])){
                return '未获取到内容，无法发送；请先检查是否已保存内容';
            }
            $send            = new FitnessProgramSend();
            $send->member_id = $memberId;
            $send->name      = $query['name'];
            $send->content   = $query['content'];
            $send->send_time = time();
            if($send->save() == true){
                Func::sendFitnessDiet($query['mobile'],$query['content']);
            }
        }else{
            if($query['mobile'] != 0 && !empty($query['mobile']) && !empty($query['content'])){
                $send            = new FitnessProgramSend();
                $send->member_id = $memberId;
                $send->name      = $query['name'];
                $send->content   = $query['content'];
                $send->send_time = time();
                if($send->save() == true){
                    Func::sendFitnessDiet($query['mobile'],$query['content']);
                }
            }
        }
    }

    /**
     * 云运动 - 会员维护 - 获取给该会员发送过的短信
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/28
     * @return array
     */
    public function getFitnessMessage($memberId)
    {
        return FitnessProgramSend::find()->where(['member_id' => $memberId])->asArray()->all();
    }
}