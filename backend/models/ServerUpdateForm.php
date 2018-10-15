<?php
namespace backend\models;
use common\models\base\Server;
use yii\base\Model;

/**
 * @云运动 - 后台 - 服务套餐表单验证
 * @author Houkaixin <huangpengju@itsports.club>
 * @create 2017/5/12
 */
class ServerUpdateForm extends Model
{
    public $serverId;        //服务套餐名称
    public $name;             //服务名字

    /**
     * 云运动 - 后台 - 服务套餐表单验证的规则
     * @author Houkaixin<huangpengju@itsports.club>
     * @create 2017/5/12
     * @return array
     */
    public function rules()
    {
        return [
            [[ "serverId","name"], 'required'],
        ];
    }
    /**
     * 云运动 - 后台 - 执行数据修改
     * @author Houkaixin<huangpengju@itsports.club>
     * @create 2017/5/12
     * @return array
     */
    public function updateServer(){
         $model = Server::findOne(["id"=>$this->serverId]);
         $model->name = $this->name;
          $result = $model->save();
         if(!$result){
             return $model->errors;
         }else{
             return true;
         }
    }


}