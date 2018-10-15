<?php
namespace backend\models;
use common\models\base\Deal;
use common\models\base\DealChangeRecord;
use yii\base\Model;
use Yii;
class DealForm extends Model
{
    public $name;
    public $dealType;
    public $desc;
    public $dealId;
    public $companyId;
    public $venueId;
    public $type;         //1卡种类，2私课类

    public function __construct(array $config,$companyId,$venueId)
    {
        $this->companyId = $companyId;
        $this->venueId   = $venueId;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [["name","dealType","desc",'dealId',"type"],"safe"],
            ['name', 'unique', 'targetClass' => '\common\models\base\Deal', 'message' => '合同名称已存在！'],
        ];
    }
    /**
     * 后台 - 合同类型管理  保存合同数据
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/24
     */
    public function insertSave()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $deal = new Deal();
            $deal->name           = $this->name;
            $deal->deal_type_id   = $this->dealType;
            $deal->deal_number    = 'sp'.time().mt_rand(10000,99999);
            $deal->intro          = $this->desc;
            $deal->create_at      = time();
            $deal->create_id      = $this->getCreate();
            $deal->company_id     = !empty($this->companyId)?$this->companyId:0;
            $deal->venue_id       = !empty($this->venueId)?$this->venueId:0;
            $deal->type           = $this->type;
            if(!$deal->save()){
                \Yii::trace($deal->errors);
                throw new \Exception('合同新增失败');
            }
            $dealChange = new DealChangeRecord();
            $dealChange->deal_id        = $deal['id'];
            $dealChange->name           = $deal['name'];
            $dealChange->deal_type_id   = $deal['deal_type_id'];
            $dealChange->deal_number    = $deal['deal_number'];
            $dealChange->intro          = $deal['intro'];
            $dealChange->create_at      = time();
            $dealChange->create_id      = $this->getCreate();
            $dealChange->company_id     = $deal['company_id'];
            $dealChange->venue_id       = $deal['venue_id'];
            $dealChange->type           = $deal['type'];
            if(!$dealChange->save()){
                \Yii::trace($dealChange->errors);
                throw new \Exception('新增合同变更记录失败');
            }
            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            return  $e->getMessage();
        }
    }
    /**
     * 后台 - 合同类型管理  修改合同数据
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/24
     */
    public function updateSave()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $deal = Deal::findOne(['id'=>$this->dealId]);
            $deal->intro = $this->desc;
            $deal->name  = $this->name;
            $deal->deal_type_id = $this->dealType;
            $deal->type         = $this->type;
            if(!$deal->save()){
                \Yii::trace($deal->errors);
                throw new \Exception('合同修改失败');
            }
            $dealChange = new DealChangeRecord();
            $dealChange->deal_id        = $this->dealId;
            $dealChange->name           = $this->name;
            $dealChange->deal_type_id   = $this->dealType;
            $dealChange->deal_number    = 'sp'.time().mt_rand(10000,99999);
            $dealChange->intro          = $this->desc;
            $dealChange->create_at      = time();
            $dealChange->create_id      = $this->getCreate();
            $dealChange->company_id     = !empty($deal['company_id'])?$deal['company_id']:0;
            $dealChange->venue_id       = !empty($deal['venue_id'])?$deal['venue_id']:0;
            $dealChange->type           = $this->type;
            if(!$dealChange->save()){
                \Yii::trace($dealChange->errors);
                throw new \Exception('新增合同变更记录失败');
            }
            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            return  $e->getMessage();
        }
    }

    /**
     * 云运动 - 合同管理 - 验证合同名称是否存在
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/3
     * @param $name string 合同名称
     * @param $companyId int 公司ID
     * @return string
     */
    public static function setDealName($name,$companyId)
    {
        $name = Deal::find()->where(['name'=>$name])->andWhere(['company_id'=>$companyId])->asArray()->one();
        if(isset($name) && !empty($name)){
            return true;
        }else{
            return false;
        }
    }

    public function getCreate()
    {
        if(isset(\Yii::$app->user->identity) && !empty(\Yii::$app->user->identity)){
            $create = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
            $create = isset($create->id)?intval($create->id):0;
            return $create;
        }
        return 0;
    }
}