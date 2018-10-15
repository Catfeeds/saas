<?php
namespace backend\models;
use common\models\base\Config;
use yii\base\Model;
use Yii;

class ConfigForm extends Model
{
    public $subscribe;
    public $venue;
    public $cancel;
    public $class;
    public $member_show;
    public $is_coach_class;
    public $is_coach_vacation;
    public $is_member_class;
    public $type;
    public $configType;
    public $source;                 //潜在会员，来源
    public $id;                     //配置表id
    public  $companyId;
    public  $venueId;

    /**
     * 云运动 - 后台 - 预约设置表单构造初始化函数
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/4/13
     * ConfigForm constructor.
     * @param array $config
     * @param string $scenario
     * @param $companyId
     * @param $venueId
     */
    public function __construct(array $config,$scenario = 'save',$companyId,$venueId)
    {
        $this->companyId = $companyId;
        $this->venueId   = $venueId;
        $this->scenario = $scenario;
        $this->type = 'private';
        parent::__construct($config);
    }

    /**
     * 云运动 - 后台 - 预约设置表单使用场景
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/4/13
     * @return array
     */
    public function scenarios()
    {
        return [
           'save'   => ['subscribe','venue','cancel','class','member_show','is_coach_class','is_coach_vacation','is_member_class'],
            'source'=>['source','configType']
        ];
    }

    /**
     * 云运动 - 后台 - 预约设置表单规则验证
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/4/13
     * @return array
     */
    public function rules()
    {
        return [
            ['subscribe', 'required', 'message' => '请选择开课前多长时间不可预约！'],
            ['venue', 'required', 'message' => '请选择所属场馆！'],
            ['cancel', 'required', 'message' => '会员早于开课多少分钟可取消！'],
            ['class', 'required', 'message' => '请选择会员可预约多少天以内的课！'],
            ['member_show', 'required', 'message' => '请选择对会员展示课程预约人数！'],
            ['is_coach_class', 'required', 'message' => '请选择替课教练是否需要审核！'],
            ['is_coach_vacation', 'required', 'message' => '请选择教练请假是否需要审核！'],
            ['is_member_class', 'required', 'message' => '请选择会员是否只能预约所绑定教练的私教课！'],
            [['source'],'required','on'=>['source']],
            [['source'],'string','on'=>['source']],
            [['source'],'trim','on'=>['source']],
            ['configType','safe'],
        ];
    }
    /**
     * @云运动 - 后台 - 预约设置表单数据保存到数据库
     * @author huanghua<huanghua@itsports.club>
     * @param $model array //私教配置数组
     * @create 2017/4/10
     * @return boolean
     */
    public function setConfigData($model)
    {
        $sceArr = $this->scenarios();
        $sceArr = $sceArr[$this->scenario];
        foreach ($model as $k => $v) {
            if (in_array($k, $sceArr)) {
                if($this->keyExists($k)){
                    $this->saveUpdate($k,$v);
                }else{
                    $this->saveConfig($k,$v);
                }
            }else{
                return false;
            }
        }
    }

    /**
     * @云运动 - 后台 - 检测key值是否存在
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/4/14
     */
    public function keyExists($k)
    {
        $config = Config::find()->where(['type'=>$this->type,'key'=>$k])->asArray()->one();

        return   $config;
    }
    /**
     * @云运动 - 后台 - key值存在修改
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/4/14
     */
    public function saveUpdate($k,$v)
    {
        $config  = Config::find()->where(['type'=>$this->type,'key'=>$k])->one();

        $config->value = $v;

        if($config->save()){
            return true;
        }else{
            return $config->errors;
        }
    }
    /**
     * @云运动 - 后台 - key值不存在插入
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/4/14
     */
    public function saveConfig($k,$v)
    {
        $config = new Config();
        $config->key   = $k;
        $config->value = $v;
        $config->type  = 'private';
        if($config->save()){
            return true;
        }else{
            return $config->errors;
        }

    }

    /**
     * @云运动 - 潜在会员 - 来源存储
     * @author huangpengju<huangpengju@itsports.club>
     * @create 2017/6/5
     * @return bool
     */
    public function saveSourceInfo()
    {
        if(empty($this->configType)){
            $this->configType = 'member';
        }
        $config             = new Config();
        $config->key        = 'source';
        $config->value      = $this->source;     //潜在会员来源
        $config->type       = $this->configType; //会员
//        $config->company_id = 1;               //公司id,需要登录获取
        $config->company_id        = $this->companyId;
        $config->venue_id          = $this->venueId;
        $config = $config->save()?$config:$config->errors;
        if($config->id)
        {
            return $config->id;
        }else{
            return false;
        }
    }
    /**
     * 云运动 - 潜在会员 - 新增潜在会员销售来源修改
     * @author Huanghua Huanghua@itsports.club
     * @create 2017/6/16
     * @param
     * @return boolean/object
     */
    public function updateData()
    {
        //销售来源数据信息修改
        $model = Config::findOne(['id' => $this->id]);
        $model->value = $this->source;
        if ($model->save()) {
            return true;
        } else {
            return $model->errors;
        }
    }

}