<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\ImageManagement;
class PictureForm extends Model
{
    public $id;                        //图片id
    public $name;                      //图片名称
    public $type;                      //类别
    public $url;                       //图片路径
    public $size;                      //图片大小
    public $wide;                      //图片宽
    public $height;                    //图片高

    /**
     * @云运动 - 后台 - 修改图片验证规则
     * @create 2017/6/16
     * @return array
     */
    public function rules()
    {
        return [
            [['name','type','url'],'required'],
            [['id', 'name','type','url','size','wide','height'],'safe'],
        ];
    }
    /**
     * 云运动 - 图片管理 - 点击修改单条信息
     * @author Huanghua <Huanghua@itsports.club>
     * @create 2017/6/16
     * @param
     * @return boolean/object
     */
    public function updateData()
    {
        $model            = ImageManagement::findOne(['id' => $this->id]);
        $model->name      = $this->name;
        $model->create_id = $this->getCreate();
        $model->update_at = time();
        if ($model->save()) {
            return true;
        } else {
            return $model->errors;
        }
    }


    public function getCreate()
    {
        $create = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $create = isset($create->id)?intval($create->id):0;
        return $create;
    }


    /**
     * 云运动 - 后台- 新增图片
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/12
     * @param $companyId
     * @param $venueId
     * @return boolean/object
     */
    public function addMyData($companyId,$venueId)
    {
        $model                = new ImageManagement();
        $model->name          = $this->name;
        $model->type          = $this->type;
        $model->create_id     = $this->getCreate();
        $model->created_at    = time();
        $model->update_at     = time();
        $model->image_size    = $this->size;
        $model->image_wide    = $this->wide;
        $model->image_height  = $this->height;
        $model->url           = $this->url;
        $model->company_id    = $companyId;
        $model->venue_id      = $venueId;

        if ($model->save()) {
            return true;
        } else {
            return $model->errors;
        }
    }

}