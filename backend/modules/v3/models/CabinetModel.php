<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/26 0026
 * Time: 下午 17:42
 */

namespace backend\modules\v3\models;

use common\models\base\Cabinet;
use common\models\base\CabinetType;

class CabinetModel extends Cabinet
{
    /**
     * @云运动 - 微信公众号\微信小程序 - 柜子种类
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param  $venueId
     * @create 2018/2/26
     * @inheritdoc
     */
    public function getAllCabinetTypes($venueId)
    {
        return $data = CabinetType::find()->where(['venue_id'=>$venueId])->asArray()->all();
    }

    /**
     * @云运动 - 微信公众号\微信小程序 - 柜子列表
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param  $typeId
     * @create 2018/2/26
     * @inheritdoc
     */
    public function getCabinetList($typeId)
    {
        $data = \backend\models\Cabinet::find()
            ->where(['cabinet_type_id'=>$typeId,'status'=>1,'cabinet_type'=>2])
            ->asArray()
            ->all();
        if($data){
            foreach($data as $k=>$v){
                $signData1 = [];
                $signData2 = [];
                if(!empty($v["give_month"])){
                    $resultDataMonth = json_decode($v["give_month"], true);
                    if(is_int($resultDataMonth)){
                        $resultDataMonth = [$resultDataMonth];
                    }
                }else{
                    $resultDataMonth = [];
                }
                $resultDataMoney        = !empty($v["cabinet_money"])?json_decode($v["cabinet_money"],true):[];
                $endResultMonth         = !empty($resultDataMoney)?array_keys($resultDataMonth):[];
                $endResultGiveMonth     = !empty($resultDataMonth)?array_values($resultDataMonth):[];
                $endResultMoney         = !empty($resultDataMoney)?array_values($resultDataMoney):[];
                foreach($endResultMonth as $key=>$value){
                    $signData1["month"] = isset($endResultMonth[$key])?$endResultMonth[$key]:0;
                    if(isset($endResultGiveMonth[$key])&&(!in_array($endResultGiveMonth[$key],[""]))){
                        if(strpos($endResultGiveMonth[$key], 'd')){
                            $signData1["give"]  = rtrim($endResultGiveMonth[$key], 'd');
                            $signData1["type"]  = 'day';
                        }else{
                            if(strpos($endResultGiveMonth[$key], 'm')){
                                $signData1["give"]  = rtrim($endResultGiveMonth[$key], 'm');
                            }else{
                                $signData1["give"]  = $endResultGiveMonth[$key];
                            }
                            $signData1["type"]  = 'month';
                        }
                    }else{
                        $signData1["give"]  = 0;
                    }
                    $signData1["money"] = isset($endResultMoney[$key])?$endResultMoney[$key]:0;
                    $signData2[]        = $signData1;
                }
                $data[$k]['give_month']    = $signData2;
                $data[$k]['cabinet_month'] = json_decode($v['cabinet_month'], true);
                $data[$k]['cabinet_dis']   = json_decode($v['cabinet_dis'], true);
                $data[$k]['cabinet_money'] = json_decode($v['cabinet_money'], true);
            }

            return $data;
        }else{
            return false;
        }
    }

}