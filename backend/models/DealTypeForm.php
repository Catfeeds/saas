<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/4/25
 * Time: 22:22
 */
namespace backend\models;
use common\models\base\DealType;
use yii\base\Model;

class DealTypeForm extends Model
{
    public $typeName;
    public $dealTypeId;
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [["typeName",'dealTypeId'],"safe"],
            ['typeName', 'unique', 'targetClass' => '\common\models\base\DealType', 'message' => '合同类型名称已存在！'],
        ];
    }
    /**
     * 后台 - 合同类型管理  保存类型数据
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/24
     * @return object     //返回删除数据成功与否结果
     */
    public function insertSave($companyId,$venueId)
    {
        $deal = new DealType();
        $deal->type_name      = $this->typeName;
        $deal->create_at      = time();
        $deal->create_id      = \Yii::$app->user->identity->id;
        $deal->company_id     = $companyId;
        $deal->venue_id       = $venueId;
        if($deal->save()){
            return true;
        }else{
            return $deal->errors;
        }
    }
    /**
     * 后台 - 合同类型管理  修改合同类型数据
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/24
     * @return object     //返回删除数据成功与否结果
     */
    public function updateSave()
    {
        $deal = DealType::findOne(['id'=>$this->dealTypeId]);
        $deal->type_name = $this->typeName;
        if($deal->save()){
            return true;
        }else{
            return $deal->errors;
        }
    }

    /**
     * 云运动 - 合同管理 - 验证合同类型名称是否存在
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/3
     * @param $name string 合同类型名称
     * @param $companyId int 公司ID
     * @return string
     */
    public static function dealTypeName($name,$companyId)
    {
        $typeName = DealType::find()->where(['type_name'=>$name])->andWhere(['company_id'=>$companyId])->asArray()->one();
        if(isset($typeName) && !empty($typeName)){
            return true;
        }else{
            return false;
        }
    }
}