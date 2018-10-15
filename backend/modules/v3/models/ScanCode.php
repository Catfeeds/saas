<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/25 0025
 * Time: 下午 14:49
 */

namespace backend\modules\v3\models;

use common\models\base\ScanCodeRecord;

class ScanCode extends \common\models\base\ScanCodeRecord
{
    /**
     * @云运动 - 云运动 - 进闸机的时候对比二维码的可用性
     * @author 焦冰洋<houkaixin@itsports.club>
     * @param  $memberId  // 会员id
     * @create 2018/2/25
     * @inheritdoc
     */
    public function searchMember($memberId)
    {
        // 查询是否当天有二维码
        $dateStart = strtotime(date("Y-m-d")." 00:00:01");
        $dateEnd   = strtotime(date("Y-m-d")." 23:59:59");
        $endData   = ScanCodeRecord::find()
            ->where(["and",["member_id"=>$memberId],["between","create_at",$dateStart,$dateEnd]])
            ->orderBy(["id"=>SORT_DESC])
            ->asArray()
            ->limit(1)
            ->one();
        if(empty($endData)){
            return "noMessageCode";    //没有二维码
        }
        $timeDifference = (time() - $endData["create_at"]);
        if($timeDifference>10){         //暂定10秒钟
            return "Invalid";
        }
        return true;
    }

    /**
     * @云运动 - 微信公众号、微信小程序 - 保存会员扫码进馆记录
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param $param
     * @create 2018/2/25
     * @inheritdoc
     */
    public function saveScanRecord($param)
    {
        // 先删除 该会员的所有进场记录 然后在录入
        $param = explode("@",$param);
        // 根据身份删除之前的二维码
        $this->dealBeforeCode($param);
        // 二维码的录入
        $model = new ScanCodeRecord();
        $model->member_id = $param[0];
        $model->create_at = $param[1];
        if($param[2]=="000000"){
            $model->member_card_id  = 0;          //员工身份录入
            $model->identify        = 2;
        }else{
            $model->member_card_id  = $param[2];  //会员信息录入
            $model->identify        = 1;
        }
        if(!$model->save()){
            return $model->errors;
        }
        return true;
    }

    /**
     * @云运动 - 微信公众号、微信小程序 - 录入二维码之前删除之前的二维码
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param  $param  //搜索参数
     * @create 2018/2/25
     * @inheritdoc
     */
    public function dealBeforeCode($param)
    {
        if($param[2]=="000000"){
            ScanCodeRecord::deleteAll(["member_id"=>$param[0]]);       //删除指定员工二维码
        }else{
            ScanCodeRecord::deleteAll(["member_card_id"=>$param[2]]);  //删除指定会员二维码
        }
    }



}