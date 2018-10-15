<?php
namespace backend\models\v2;


use common\models\base\Visitors;
use yii\base\Model;
use common\models\base\MessageCode;
class VisitorsForm extends Model
{
    public $createId ;              //创建人id
    public $visitorName;            //访客姓名
    public $visitorMobile;          //访客手机号
    public $visitorSex;             //访客性别
    public $reservation;            //预约来店方式
    public $alone;                  //自访来店方式
    public $activity;               //活动来店方式
    public $referrerName;           //推荐人姓名
    public $referrerMobile;         //推荐人手机号

    public $transportation;         //访客交通方式
    public $visitorSportStatus;     //访客运动状态
    public $visitorHopeTime;        //访客希望上课时间
    public $visitorHopeLimit;       //访客希望上课时段
    public $visitorLikeEquipment;   //访客喜欢的健身设备
    public $visitorLikeYoga;        //访客喜欢的瑜伽
    public $visitorLikeDance;       //访客喜欢的舞蹈
    public $visitorLikeCourse;      //访客喜欢的课程
    public $visitorAims;            //访客的健身目标
    public $visitorReadyTime;       //访客目标的准备时间
    public $visitorFulfil;          //访客希望达到目标的时间
    
    public $code;                   //验证码（系统生成）
    public $newCode;                //验证码（用户输入）


    /**
     * ipad - 访客 - 表单验证
     * @author  Huang pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @return array
     */
    public function rules()
    {
        return [
            ['createId','required','message'=>'请获取创建人id！'],

            ['visitorName','trim'],
            ['visitorName','required','message'=>'访客姓名不能为空！'],

            ['visitorMobile','trim'],
            ['visitorMobile','required','message'=>'访客电话不能为空！'],

            ['visitorSex','required','message'=>'请选择性别！'],

            [['visitorName','visitorMobile','reservation','alone','activity','referrerName','referrerMobile',
                'transportation','visitorSportStatus','visitorHopeTime','visitorHopeLimit','visitorLikeEquipment',
                'visitorLikeYoga','visitorLikeDance','visitorLikeCourse','visitorAims','visitorReadyTime','visitorFulfil'
            ],'string'],

            ['newCode','trim'],
            ['newCode','required','message'=>'验证码不能为空！'],
            ['newCode','compare','compareAttribute'=>'code','message'=>'验证码错误'],
            ['newCode','newCodeTime'],
        ];
    }

    /**
     * @ ipad - 访客 - 获取验证码
     * @author  Huang pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @inheritdoc
     */
    public function loadCode()
    {
        $temp = $this->getCode();           //查询验证码
        $this->code = $temp['code'];        //赋值给对象属性
    }
    /**
     * @ ipad - 访客 - 去数据库中 查询验证码
     * @author  Huang pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @inheritdoc
     */
    public function getCode()
    {
        return MessageCode::find()->where(['mobile'=>$this->visitorMobile])->orderBy('id DESC')->asArray()->one();
    }
    /**
     * @ipad - 访客 - 去数据库中 查询验证码（判断时间是否过期）
     * @author  Huang pengju <huangpengju@itsport.club>
     * @create 2017/5/9
     * @inheritdoc
     */
    public function newCodeTime($attribute)
    {
        $temp = $this->getCode();
        $time = $temp['create_at'];
        $num = time() - $time;
        if ($num > 300000) {
            $this->addError($attribute, '验证码已失效！');
        }
    }

    /**
     * @ipad - 访客 - 信息存储到数据库（判断时间是否过期）
     * @author  Huang pengju <huangpengju@itsport.club>
     * @create 2017/5/10
     * @return array|bool
     */
    public function saveVisitorData()
    {
        $visitor                        = new Visitors();
        $visitor->create_id             = $this->createId;                //创建人id
        $visitor->visitor_name          = $this->visitorName;             //访客姓名
        $visitor->visitor_mobile        = $this->visitorMobile;           //访客手机号
        $visitor->visitor_sex           = $this->visitorSex;              //访客性别
        $visitor->reservation           = $this->reservation;             //预约来店方式
        $visitor->alone                 = $this->alone;                   //自访来店方式
        $visitor->activity              = $this->activity;                //活动来店方式
        $visitor->referrer_name         = $this->referrerName;            //推荐人姓名
        $visitor->referrer_mobile       = $this->referrerMobile;          //推荐人手机号

        $visitor->transportation         = $this->transportation;         //访客交通方式
        $visitor->visitor_sport_status   = $this->visitorSportStatus;     //访客运动状态
        $visitor->visitor_hope_time      = $this->visitorHopeTime;        //访客希望上课时间
        $visitor->visitor_hope_limit     = $this->visitorHopeLimit;       //访客希望上课时段
        $visitor->visitor_like_equipment = $this->visitorLikeEquipment;   //访客喜欢的健身设备
        $visitor->visitor_like_yoga      = $this->visitorLikeYoga;        //访客喜欢的瑜伽
        $visitor->visitor_like_dance     = $this->visitorLikeDance;       //访客喜欢的舞蹈
        $visitor->visitor_like_course    = $this->visitorLikeCourse;      //访客喜欢的课程
        $visitor->visitor_aims           = $this->visitorAims;            //访客的健身目标
        $visitor->visitor_ready_time     = $this->visitorReadyTime;       //访客目标的准备时间
        $visitor->visitor_fulfil         = $this->visitorFulfil;          //访客希望达到目标的时间
        $visitor->create_at              = time();                        //添加时间
        if(!$visitor->save())
        {
           return  $visitor->errors;
        }
        return true;
    }
}