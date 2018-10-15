<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\Config;

/**
 * @云运动 - 团课管理 - 预约
 * @author 朱梦珂 <zhumengke@itsports.club>
 * @create 2017/4/13
 * @inheritdoc
 */
class LeagueReservationForm extends Model
{
    public $before_class;
    public $venue_id;
    public $reservation_number;
    public $class_number;
    public $cancel_time;
    public $how_minutes;
    public $how_days;
    public $allow_look;
    public $is_deduction_times;
    public $is_check_replace;
    public $is_check_leave;
    public $type;
    public $companyId;
    public $venueId;
    public $renew;
    public $recharge;
    public $beforeRenew;

    /**
     * @inheritdoc
     */
    public function __construct(array $config,$scenario = 'save',$companyId,$venueId,$type = 'league')
    {
        $this->scenario  = $scenario;
        $this->type      = $type;
        $this->companyId = $companyId;
        if(empty($this->venueId) || !isset($this->venueId)){
            $this->venueId = $venueId;
        }
        parent::__construct($config);
    }

    public function scenarios()
    {
        return [
            'save' => ['before_class', 'venue_id', 'reservation_number', 'class_number', 'cancel_time', 'how_minutes', 'how_days', 'allow_look', 'is_deduction_times', 'is_check_replace', 'is_check_leave'],
            'card' => ['renew','recharge','beforeRenew','type','venueId']
        ];
    }
    /**
     * @云运动 - 团课管理 - 预约
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/4/13
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            ['before_class', 'required', 'message' => '请选择开课前多长时间不可预约！'],
//            ['venue_id', 'required', 'message' => '请选择所属场馆！'],
//            ['reservation_number', 'required', 'message' => '请选择课程预约人数上限！'],
//            ['class_number', 'required', 'message' => '请选择开课人数！'],
//            ['cancel_time', 'required', 'message' => '请选择人数不足课程自动取消时间！'],
//            ['how_minutes', 'required', 'message' => '会员早于开课多少分钟可取消！'],
//            ['how_days', 'required', 'message' => '请选择会员可预约多少天以内的课！'],
//            ['allow_look', 'required', 'message' => '请选择对会员展示课程预约人数！'],
//            ['is_deduction_times', 'required', 'message' => '请选择是否预约扣次！'],
//            ['is_check_replace', 'required', 'message' => '请选择教练请假是否需要审核！'],
//            ['is_check_leave', 'required', 'message' => '请选择替课教练是否需要审核！'],
            [['renew','recharge','beforeRenew','type','venueId'],'safe']
        ];
    }
    /**
     * @云运动 - 团课管理 - 预约
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/4/13
     * @inheritdoc
     */
    public function setConfigData($model)
    {
        if(isset($model['type']) && $model['type'] == 'class'){
            $config = Config::findOne(['type'=>$this->type,'key'=>$this->key]);
            if(!empty($config)){
                $config->value = $this->value;
                if($config->save()){
                    return true;
                }
                return $config->errors;
            }else{
                $newConfig = new Config();
                $newConfig->key   = $this->key;
                $newConfig->value = $this->value;
                $newConfig->venue_id = $this->venueId;
                $newConfig->type  = $this->type;
                if($newConfig->save()){
                    return true;
                }
                return $newConfig->errors;
            }
        }else{
            $sceArr = $this->scenarios();
            $sceArr = $sceArr[$this->scenario];
            foreach ($model as $k => $v) {
                if (in_array($k, $sceArr)) {
                    if($this->keyExists($k)){
                        $this->saveUpdate($k,$v);
                    }else{
                        $this->saveConfig($k,$v);
                    }
                } else {
//                    return false;
                }
            }
        }

    }

    public function keyExists($k)
    {
        $config = Config::find()->where(['type'=>$this->type,'key'=>$k,'venue_id'=>$this->venueId])->asArray()->one();

        return   $config;
    }

    public function saveUpdate($k,$v)
    {
        $config  = Config::findOne(['type'=>$this->type,'key'=>$k,'venue_id'=>$this->venueId]);

        $config->value = $v;

        if($config->save()){
            return true;
        }else{
            return $config->errors;
        }
    }

    public function saveConfig($k,$v)
    {
        $config = new Config();
        $config->key               = $k;
        $config->value             = $v;
        $config->type              = $this->type;
        $config->company_id        = $this->companyId;
        $config->venue_id          = $this->venueId;
        $config->save();
    }


    /**
     * @云运动 - 团课管理 - 预约 - 获取config表的数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/4/14
     * @inheritdoc
     */
    public static function getConfigInfo($type = 'league')
    {
        $model['config'] = Config::find()->where(['type'=>$type])->asArray()->all();
        return $model;
    }

}
