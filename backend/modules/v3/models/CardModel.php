<?php
namespace backend\modules\v3\models;

use backend\models\BindPack;
use \backend\models\CardCategory;
use common\models\base\ChargeClass;
use common\models\base\Course;
use common\models\base\LimitCardNumber;
use common\models\base\Organization;
use common\models\base\VenueLimitTimes;

class CardModel extends CardCategory
{
    /**
     * @云运动 - 微信公众号 - 获取场馆售卖的卡种
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param  $venueId
     * @create 2018/2/5
     * @inheritdoc
     */
    public function getCardList($venueId)
    {
        $data = CardCategory::find()
            ->alias('cc')
            ->joinWith(['cardCategoryType cct'],false)
            ->joinWith(['limitCardNumber lc'=>function($query)use($venueId){
//                $query->where(['lc.status'=>2]);
                $query->andWhere(['lc.venue_id'=>$venueId]);
                $query->andWhere(['and',['<','lc.sell_start_time',time()],['>','lc.sell_end_time',time()]]);
            }],false)
            ->where(['cc.status'=>1])
            ->andWhere(['cc.is_app_show'=>1])
            ->select('cc.*,cct.type_name,lc.surplus')
            ->orderBy('cc.create_at desc')
            ->asArray()
            ->all();
        if($data){
            foreach($data as $k=>$v){
                $data[$k]['duration'] = json_decode($v['duration']);
            }
            return $data;
        }else{
            return false;
        }
    }

    /**
     * @云运动 - 微信公众号 - 获取场馆售卖的卡种详情
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param  $id
     * @create 2018/2/5
     * @inheritdoc
     */
    public function getCardInfo($id)
    {
        $data = CardCategory::find()
            ->alias('cc')
            ->where(['cc.id'=>$id])
            ->joinWith(['bindPack bp'])
            ->joinWith(['cardCategoryType'])
            ->asArray()
            ->one();
        if($data){
            $data['duration'] = json_decode($data['duration'],true);
            $data['leave_long_limit'] = json_decode($data['leave_long_limit'],true);
            $data['student_leave_limit'] = json_decode($data['student_leave_limit'],true);
            foreach($data['bindPack'] as $k=>$v){
                $data['bindPack'][$k]['polymorphic_ids'] = json_decode($v['polymorphic_ids'],true);
            }
            $tuan   = [];
            $charge = [];
            $class  = $data['bindPack'];
            foreach($class as $k=>$v){
                if($v['polymorphic_type'] == 'class'){
                    array_push($tuan,$v);
                }elseif($v['polymorphic_type'] == 'hs' || $v['polymorphic_type'] == 'pt' || $v['polymorphic_type'] == 'birth'){
                    array_push($charge,$v);
                }
            }
            $polymorphic_id = array_column($tuan,'polymorphic_id');
            $tuanid = (count($tuan) == 1 && in_array(0,$polymorphic_id)) ? array_column($tuan,'polymorphic_ids') : array_column($tuan,'polymorphic_id');
            $result = [];
            array_walk_recursive($tuanid, function($value) use (&$result) {
                array_push($result, $value);
            });
            $course = Course::find()->where(['IN','id',$result])->select('id,name')->asArray()->all();
            if(count($tuan) == 1 && in_array(0,$polymorphic_id)){
                foreach($course as $k=>$v){
                    $course[$k]['number'] = $tuan[0]['number'];
                }
            }else{
                $course = BindPack::find()
                    ->alias('bp')
                    ->joinWith(['course cs'],false)
                    ->where(['bp.card_category_id'=>$id])
                    ->andWhere(['bp.polymorphic_type'=>'class'])
                    ->select('bp.*,cs.name')
                    ->asArray()
                    ->all();
            }
            $data['tuanke'] = $course;
            $chargeId    = array_column($charge,'polymorphic_id');
            $chargeClass = ChargeClass::find()->where(['IN','id',$chargeId])->select('id,name')->asArray()->all();
            foreach($charge as $k=>$v){
                foreach($chargeClass as $a=>$b){
                    if($v['polymorphic_id'] == $b['id']){
                        $charge[$k]['class_name'] = $b['name'];
                    }
                }
            }
            $data['sijiao'] = $charge;
            $limitVenues    = LimitCardNumber::find()
                ->where(['card_category_id'=>$id])
                ->andWhere(['<>','status',2])
                ->asArray()
                ->all();
            if($limitVenues){
                foreach($limitVenues as $k=>$v){
                    $limitVenues[$k]['venue_ids'] = json_decode($v['venue_ids'],true);
                }
                $venueId1 = array_column($limitVenues,'venue_ids');
                $result1  = [];
                array_walk_recursive($venueId1, function($value) use (&$result1) {
                    array_push($result1, $value);
                });
                $venueId2 = array_column($limitVenues,'venue_id');
                $result   = array_merge($result1,$venueId2);
            }
            $venues = Organization::find()->where(['IN','id',$result])->select('id,name')->asArray()->all();
            $data['league_venues'] = $venues;
            return $data;
        }else{
            return false;
        }

    }

}