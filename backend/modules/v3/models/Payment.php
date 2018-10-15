<?php
namespace backend\modules\v3\models;

use backend\components\payment\lib\WxPayApi;
use backend\components\appPay\lib\WeEncryption;
include "../components/payment/lib/WxPay.Api.php";
use yii\base\Model;

class Payment extends Model
{
    /**
     * 云运动 - 微信小程序支付 - 获取统一支付配置参数
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @create 2018/2/7
     * @return array
     */
    public static function getMiniConfig($params)
    {
        if(isset($params['type']) && $params['type'] == 'charge'){
            $type = '私教课程';
        }else{
            $type = '会员卡';
        }
        $data = array();
        $data['appid']            = 'wx90721efca5d2c575';
        $data['mch_id']           = '1484061062';
        $data['nonce_str']        = WxPayApi::getNonceStr();
        $data['trade_type']       = 'JSAPI';
        $data['body']             = $type;
        $data['openid']           = $params['openid'];
        $data['out_trade_no']     = isset($params['out_trade_no'])?$params['out_trade_no']:'';
        $data['total_fee']        = isset($params['price'])?$params['price']:'';
        $data['notify_url']       = 'http://qa.aixingfu.net/v1/api-payment/notify';
        $data['spbill_create_ip'] = '117.159.13.118';
        $data['sign']             = WechatPay::getSign($data);
        return $data;
    }

    /**
     * 云运动 - 微信公众号支付 - 获取统一支付配置参数
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @create 2018/2/8
     * @return array
     */
    public static function getOfficialConfig($params)
    {
        if(isset($params['type']) && $params['type'] == 'charge'){
            $type = '私教课程';
        }else{
            $type = '会员卡';
        }
        $data = array();
        $data['appid']            = 'wx62d223b7a2f0457a';
        $data['mch_id']           = '1484061062';
        $data['nonce_str']        = WxPayApi::getNonceStr();  //随机20位字符串
        $data['body']             = $type;
        $data['out_trade_no']     = isset($params['out_trade_no'])?$params['out_trade_no']:'';
        $data['total_fee']        = isset($params['price'])?$params['price']:'';  //注意 单位是分
        $data['spbill_create_ip'] = '117.159.13.118';
        $data['openid']           = $params['openid'];
        $data['notify_url']       = 'http://qa.aixingfu.net/v1/api-payment/notify';
        $data['trade_type']       = 'JSAPI';  //交易类型
        $data['sign']             = WechatPay::getSign($data);    //签名
        return $data;
    }




}