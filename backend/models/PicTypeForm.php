<?php
namespace backend\models;
use common\models\base\ImageManagementType;
use yii\base\Model;

class PicTypeForm extends Model
{
    public $typeName;
    public $picTypeId;
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [["typeName",'picTypeId'],"safe"],
            ['typeName', 'unique', 'targetClass' => '\common\models\base\ImageManagementType', 'message' => '图片类型名称已存在！'],
        ];
    }
    /**
     * 后台 - 图片管理  保存类型名称数据
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/16
     * @param $companyId
     * @param $venueId
     * @return object     //返回删除数据成功与否结果
     */
    public function insertSave($companyId,$venueId)
    {
        $picType                 = new ImageManagementType();
        $picType->type_name      = $this->typeName;
        $picType->created_at     = time();
        $picType->update_at      = time();
        $picType->create_id      = \Yii::$app->user->identity->id;
        $picType->company_id     = $companyId;
        $picType->venue_id       = $venueId;
        if($picType->save()){
            return true;
        }else{
            return $picType->errors;
        }
    }
    /**
     * 后台 - 图片管理  修改图片类型数据
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/16
     * @return object     //返回删除数据成功与否结果
     */
    public function updateSave()
    {
        $picType            = ImageManagementType::findOne(['id'=>$this->picTypeId]);
        $picType->type_name = $this->typeName;
        $picType->update_at = time();
        if($picType->save()){
            return true;
        }else{
            return $picType->errors;
        }
    }

    /**
     * 云运动 - 图片管理 - 验证图片类型名称是否存在
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/16
     * @param $name string 图片类型名称
     * @param $companyId int 公司ID
     * @return string
     */
    public static function picTypeName($name,$companyId)
    {
        $typeName = ImageManagementType::find()->where(['type_name'=>$name])->andWhere(['company_id'=>$companyId])->asArray()->one();
        if(isset($typeName) && !empty($typeName)){
            return true;
        }else{
            return false;
        }
    }
}