<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/9 0009
 * Time: 下午 14:01
 */

namespace backend\modules\v3\models;


class WechatPay
{
    /**
     * 获取签名；
     * @return String 通过计算得到的签名；
     */
    public static function getSign($params)
    {
        $mch_key = 'JgERHQ86BNrh1tCETQYYXPdGbi9RFH3Z';
        ksort($params);
        foreach ($params as $key => $item) {
            if (!empty($item)) {
                $newArr[] = $key.'='.$item;
            }
        }
        $stringA        = implode("&", $newArr);
        $stringSignTemp = $stringA."&key=".$mch_key;
        $stringSignTemp = md5($stringSignTemp);
        $sign = strtoupper($stringSignTemp);
        return $sign;
    }

}