<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/6 0006
 * Time: 上午 9:53
 */

namespace backend\modules\v3\models;

use common\models\base\Member;
use common\models\Deal;
use common\models\Func;
use common\models\MemberCard;
use common\models\MemberCourseOrder;

class ContractModel extends Deal
{
    /**
     * @云运动 - 微信公众号 - 获取注册、购卡、购课的电子协议
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param  $param
     * @create 2018/3/6
     * @inheritdoc
     */
    public function getContractList($param)
    {
        $ids = StatisticsModel::gainMyAllAccount($param['mobile']);
        if(!$ids){
            return false;
        }
        //我的合同：a、潜在会员无 b、正式会员返回:1、新会员入会协议 2、已购卡种合同 3、已购私教课合同
        $member = Member::find()->where(['id' => $ids, 'member_type' => 1])->asArray()->all();
        if($member){
            //1、新会员入会协议
            $arr = self::find()
                ->where(['like','name','新会员入会协议'])
                ->select('id as dealId')
                ->asArray()
                ->all();
            $dealId1 = array_flip(array_column($arr,'dealId'));
            //2、已购卡种合同
            $arr1 = MemberCard::find()
                ->alias('mc')
                ->joinWith(['organization or'], false)
                ->joinWith(['cardCategory cc'=>function($query){
                    $query->joinWith(['deal de']);
                }],false)
                ->where(['mc.member_id'=>$ids])
                ->andWhere(['is not', 'de.id', null])
                ->select('mc.id,mc.card_category_id,cc.id,cc.card_name,de.id as dealId, or.name venueName')
                ->asArray()
                ->all();
            if($arr1){
                $dealId2 = array_column($arr1,'venueName', 'dealId');
//                unset($dealId2[0]);
//                $dealId2 = array_filter($dealId2);
            }else{
                $dealId2 = [];
            }
            //3、已购课种合同id
            $arr2 = \backend\models\Member::find()
                ->alias('mm')->joinWith(['memberCourseOrder mco' => function($q){
                    $q->joinWith(['chargeClass cc' => function($q){
                        $q->joinWith(['deal de']);
                    }]);
                }], false)
                ->joinWith(['venue ve'], false)
                ->where(['mco.member_id'=>$ids])
                ->andWhere(['is not', 'de.id', null])
                ->select('mco.id,mco.product_id,de.id as dealId,ve.name venueName')
                ->asArray()
                ->all();
            if($arr2){
                $dealId3 = array_column($arr2,'venueName','dealId');
//                unset($dealId3[0]);
//                $dealId2 = array_filter($dealId3);
            }else{
                $dealId3 = [];
            }
            $res = [];
            $mod = [];
            array_push($res,$dealId1,$dealId2,$dealId3);
            array_walk_recursive($res, function($v, $k) use (&$mod){
                array_push($mod,['dealId' => $k, 'venueName' => $v]);
            });
            foreach ($mod as $k => $v){
                $deal = Deal::find()
                    ->where(['id'=>$v['dealId']])
                    ->select('id,name')
                    ->asArray()->one();
                $mod[$k]['name']      = '《'.$deal['name'].'》';
                $mod[$k]['venueName'] = $mod[$k]['venueName'] ?: NULL;
            }
            return $mod;
        }else{
            return false;
        }
    }

    /**
     * @云运动 - 微信公众号 - 获取合同详情
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param  $id
     * @param  $type
     * @create 2018/3/7
     * @inheritdoc
     */
    public function getContractDetail($param)
    {
        $data = self::find()->where(['id'=>$param['id']])->select('name,intro')->asArray()->one();
        if($data){
            if($param['type'] == 1){
                $intro         = Func::format($data['intro']);
                trim($intro);
                if(strpos($intro, $data['name']) === 0){
                    $intro = substr($intro, strlen($data['name']));
                }
                $data['intro'] = $intro;
            }
            return $data;
        }else{
            return false;
        }
    }

}