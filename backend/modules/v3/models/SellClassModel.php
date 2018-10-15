<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/1 0001
 * Time: 上午 9:08
 */

namespace backend\modules\v3\models;

use common\models\ChargeClass;
use common\models\Func;

class SellClassModel extends ChargeClass
{
    /**
     * @云运动 - 微信公众号、微信小程序 - 销售私教列表
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param  $param
     * @create 2018/3/1
     * @inheritdoc
     */
    public function getClassList($param)
    {
        $query = self::find()
            ->alias('cc')
            ->where(['cc.venue_id'=>$param['venueId']])
            ->select('cc.id,cc.name,cc.pic,cc.group')
            ->orderBy('cc.id DESC')
            ->andWhere([
                'and',
                ['<=','cc.sale_start_time',time()],
                ['>=','cc.sale_end_time',time()]
            ]);
        if($param['classType'] == 1){
            $query->andWhere(['cc.show' => 2]);
            $query->andWhere(['cc.group' => 1]);  //普通私教
        }else{
            $query->andWhere(['cc.group' => 2]);  //小团体课
        }
        $data = $query->asArray()->all();
        if($data){
            return $data;
        }else{
            return false;
        }
    }

    /**
     * @云运动 - 微信公众号、微信小程序 - 普通私教详情
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param  $param
     * @create 2018/3/1
     * @inheritdoc
     */
    public function getCommonDetail($param)
    {
        $data = self::find()
            ->alias('cc')
            ->joinWith(['coursePackageDetail cpd'=>function($query){
                $query->joinWith(['course cs']);
            }])
            ->joinWith(['organization org'],false)
            ->joinWith(['deal de'],false)
            ->where(['cc.id'=>$param['id']])
            ->select('
                cc.id,
                cc.name,
                cc.pic,
                cc.describe,
                cc.type,
                cc.deal_id,
                cc.app_original_price,
                org.address,
                de.name as dealName,
                de.intro
                ')
            ->asArray()
            ->one();
        if($data){
            if($data['app_original_price'] == null && $data['type'] == 2){
               foreach($data['coursePackageDetail'] as $k=>$v){
                   $data['app_original_price'] = $v['app_original'];
               }
            }
            $intro         = Func::format($data['intro']);
            trim($intro);
            if(strpos($intro, $data['name']) === 0){
                $intro = substr($intro, strlen($data['name']));
            }
            $data['intro'] = $intro;
            return $data;
        }else{
            return false;
        }
    }

    /**
     * @云运动 - 微信公众号、微信小程序 - 小团体私教套餐列表
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param  $param
     * @create 2018/3/1
     * @inheritdoc
     */
    public function getPackageList($param)
    {
        $data = self::find()
            ->alias('cc')
            ->joinWith(['chargeClassNumbers ccn'=>function($query){
                $query->joinWith(['chargeClassPeople ccp'=>function($query){
                    $query->select('ccp.id,ccp.people_least,ccp.people_most,ccp.least_number');
                }]);
                $query->select('ccn.id as charge_class_number_id,(ccn.sell_number - ccn.surplus) as soldNum,ccn.class_people_id,ccn.charge_class_id');
            }])
            ->where(['cc.id'=>$param['id']])
            ->select('cc.id,cc.name,cc.pic')
            ->asArray()
            ->one();
        $chargeClassNumbers = $data['chargeClassNumbers'];
        $arr = [];
        foreach($chargeClassNumbers as $k=>$v){
            if($v['soldNum'] < $v['chargeClassPeople']['people_most']){
                array_push($arr,$v);
            }
        }
        $data['chargeClassNumbers'] = $arr;
        if($data){
            return $data;
        }else{
            return false;
        }
    }

    /**
     * @云运动 - 微信公众号、微信小程序 - 小团体私教套餐详情
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param  $param
     * @create 2018/3/1
     * @inheritdoc
     */
    public function getGroupDetail($param)
    {
        $data = self::find()
            ->alias('cc')
            ->joinWith(['deal de'],false)
            ->joinWith(['coursePackageDetail cpd'=>function($query){
                $query->joinWith(['course cs'=>function($query){
                    $query->select('cs.id,cs.name as courseName');
                }]);
            }])
            ->joinWith(['chargeClassNumbers ccn'=>function($query)use($param){
                $query->joinWith(['chargeClassPeople ccp'=>function($query)use($param){
                    $query->select('ccp.id,ccp.unit_price,ccp.pos_price,ccp.least_number');
                }]);
                $query->where(['ccn.id'=>$param['charge_class_number_id']]);
                $query->select('ccn.id as charge_class_number_id,(ccn.sell_number - ccn.surplus) as soldNum,ccn.class_people_id,ccn.charge_class_id');
            }])
            ->select('cc.id,cc.name,cc.describe,cc.pic,cc.type,cc.deal_id,de.name as dealName,de.intro')
            ->asArray()
            ->one();
        if($data){
            $intro         = Func::format($data['intro']);
            trim($intro);
            if(strpos($intro, $data['name']) === 0){
                $intro = substr($intro, strlen($data['name']));
            }
            $data['intro'] = $intro;
            return $data;
        }else{
            return false;
        }
    }



}