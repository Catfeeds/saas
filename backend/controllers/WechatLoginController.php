<?php
namespace backend\controllers;

use common\models\base\Organization;
use yii\web\Controller;
use common\models\base\Member;
use common\models\base\MemberBase;
use backend\components\payment\lib\WxPayApi;
include "../components/payment/lib/WxPay.Api.php";
class WechatLoginController extends Controller
{
    /**
     * 云运动 - 微信公众号 - 登陆前判断
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/16
     * @return string
     */
    public function actionLogin()
    {
        $wechatUrl  = \Yii::$app->params['wechatUrl'];
        $companyId  = $_GET['companyId'];
        if(!isset($_GET['code']) || empty($_GET['code'])){
            return $this->redirect($wechatUrl."/wechat-class/blank?openid=&member_id=&name=&mobile=&status=&member_type=&company_id=$companyId&last_venue_id=&last_venue_name=");
        }
        $code      = $_GET['code'];
        $url       = 'https://api.weixin.qq.com/sns/oauth2/access_token';
        $data = [
            //这是qa测试环境配置
//            'appid'     => 'wx49cdcc6ef788bc06',
//            'secret'    => 'e2f32551ab699d83d7608212df4cd989',
//            'code'      => $code,
//            'grant_type'=> 'authorization_code'
        //这是线上环境配置
            'appid'     => 'wx62d223b7a2f0457a',
            'secret'    => '030d755f3e58a062693be4e78fb90514',
            'code'      => $code,
            'grant_type'=> 'authorization_code'
        ];

        $header     = array();
        $response   = $this->curl_https($url, $data, $header, 5);
        $response   = json_decode($response,true);
        if(!isset($response['openid']) || empty($response['openid'])){
           return $this->redirect($wechatUrl."/wechat-class/blank?openid=&member_id=&name=&mobile=&status=&member_type=&company_id=$companyId&last_venue_id=&last_venue_name=");
        }
        $openid     = $response['openid'];
        $baseCount  = MemberBase::find()->where(['wx_open_id'=>$openid])->count();
        if($baseCount){
            if($baseCount == 1){
                    $memberBase = MemberBase::findOne(['wx_open_id'=>$openid]);
                    $member        = Member::findOne(['id'=>$memberBase->member_id,'company_id'=>$companyId]);
                    $lastVenueId   = $memberBase->last_venue_id;
                    $lastVenueName = $memberBase->last_venue_id == null ? null : Organization::findOne(['id'=>$memberBase->last_venue_id])->name;
                    return $this->redirect($wechatUrl."/wechat-class/blank?openid=$openid&member_id=$member->id&name=$member->username&mobile=$member->mobile&status=$member->status&member_type=$member->member_type&company_id=$companyId&last_venue_id=$lastVenueId&last_venue_name=$lastVenueName");
            }else{
                MemberBase::deleteAll(['wx_open_id'=>$openid]);
                return $this->redirect($wechatUrl."/wechat-class/blank?openid=$openid&member_id=&name=&mobile=&status=&member_type=&company_id=$companyId&last_venue_id=&last_venue_name=");
            }
        }else{
            return $this->redirect($wechatUrl."/wechat-class/blank?openid=$openid&member_id=&name=&mobile=&status=&member_type=&company_id=$companyId&last_venue_id=&last_venue_name=");
        }
    }

    public function curl_https($url, $data=array(), $header=array(), $timeout=30)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

        $response = curl_exec($ch);

        if($error=curl_error($ch)){
            die($error);
        }

        curl_close($ch);

        return $response;
    }

    /**
     * 云运动 - 微信小程序 - 登陆前判断
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/16
     * @return string
     */
    public function actionProgramLogin()
    {
        $openid     = $_GET['miniOpenid'];
        $companyId  = $_GET['companyId'];
        $baseCount  = MemberBase::find()->where(['mini_program_openid'=>$openid])->count();
        if($baseCount){
            if($baseCount == 1){
                $memberBase = MemberBase::findOne(['mini_program_openid'=>$openid]);
                $member = Member::findOne(['id'=>$memberBase->member_id,'company_id'=>$companyId]);
                if($member){
                    $data = [
                        'member_id'       => $member->id,
                        'member_type'     => $member->member_type,
                        'venue_id'        => $member->venue_id,
                        'mobile'          => $member->mobile,
                        'last_venue_id'   => $memberBase->last_venue_id,
                        'last_venue_name' => $memberBase->last_venue_id == null ? null : Organization::findOne(['id'=>$memberBase->last_venue_id])->name
                    ];
                    return json_encode(['code' => 1, 'status' => 'success','message' =>"有数据","data"=>$data]);
                }else{
                    return json_encode(['code' => 2, 'status' => 'error','message' =>"本公司没有数据"]);
                }
            }else{
                MemberBase::deleteAll(['mini_program_openid'=>$openid]);
                return json_encode(['code' => 0, 'status' => 'error','message' =>"没有数据"]);
            }
        }else{
            return json_encode(['code' => 0, 'status' => 'error','message' =>"没有数据"]);
        }
    }

    /**
     * 云运动 - 微信小程序 - 获取openid
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/30
     * @return string
     */
    public function actionProgramApi()
    {
        $code = $_GET['code'];
        $url  = 'https://api.weixin.qq.com/sns/jscode2session';
        $data = [
            'appid'     => 'wx90721efca5d2c575',
            'secret'    => 'b37d4f6ea3f3fcc6f70e22aacf0f4ea1',
            'js_code'   => $code,
            'grant_type'=> 'authorization_code'
        ];
        $header   = array();
        $response = $this->curl_https($url, $data, $header, 5);
        $response = json_decode($response,true);
        $openid   = $response['openid'];
        if($openid){
            return $openid;
        }else{
            return false;
        }
    }

}