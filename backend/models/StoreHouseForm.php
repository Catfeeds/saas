<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\StoreHouse;
class StoreHouseForm extends Model
{
    public $name;                      //仓库名称
    public $venueId;                   //场馆id

    /**
     * @云运动 - 后台 - 新增仓库验证规则
     * @create 2017/8/28
     * @return array
     */
    public function rules()
    {
        return [
            [['name'],'required'],
            [['venueId'],'safe'],
        ];
    }

    /**
     * 仓库管理 - 新增仓库 - 仓库数据插入数据库
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/28
     * @param $companyId
     * @return boolean/object
     */
    public function addStore($companyId)
    {
        $data = StoreHouse::find()->where(['and',['name'=>$this->name,'venue_id'=>$this->venueId]])->one();
        if (isset($data) && !empty($data)) {
            return '仓库名称已存在!';
        }
        $model                = new StoreHouse();
        $model->name          = $this->name;
        $model->create_id     = $this->getCreate();
        $model->created_at    = time();
        $model->update_at     = time();
        $model->company_id    = $companyId;
        if(isset($this->venueId) && !empty($this->venueId)){
            $model->venue_id      = $this->venueId;
        }else{
            $model->venue_id      = null;
        }
        if ($model->save()) {
            return true;
        } else {
            return $model->errors;
        }
    }
    /**
     * 仓库管理 - 新增仓库 - 创建人获取
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/28
     * @return boolean/object
     */
    public function getCreate()
    {
        $create = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $create = isset($create->id)?intval($create->id):0;
        return $create;
    }

}