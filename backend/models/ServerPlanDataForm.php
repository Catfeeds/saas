<?php
namespace backend\models;
use common\models\base\ServerCombo;
use yii\base\Model;
use common\models\base\Server;
/**
 * @云运动 - 后台 - 服务套餐表单验证
 * @author Huang Pengju <huangpengju@itsports.club>
 * @create 2017/5/4
 */
class ServerPlanDataForm extends Model
{
    public $serverComboName;        //服务套餐名称
    public $serverArr;              //服务种类(名称)数组
    public $name;

    public function scenarios()
    {
        return [
            'server'=>['name'],
            'serverCombo'=>['serverComboName','serverArr'],
        ];
    }

    /**
     * 云运动 - 后台 - 服务套餐表单验证的规则
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/4
     * @return array
     */
    public function rules()
    {
        return [
            ['name','required','message'=>'服务名称不能为空','on'=>'server'],
            ['serverComboName','required','on'=>'serverCombo'],
            ['serverArr', 'validateServerArr','on'=>'serverCombo'],
        ];
    }

    /**
     * 云运动 - 后台 - 自定义验证的规则
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/4
     * @param $attribute
     * @param $params
     * @return bool
     */
    public function validateServerArr($attribute,$params)
    {
        if(!$this->$attribute[0]){
            $this->addError($attribute,'值不能为空');
            return false;
        }
        return true;
    }

    /**
     * 云运动 - 后台 - 保存服务
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/4
     * @return array|string
     * @throws \yii\db\Exception
     */
    public function saveServerData()
    {
        $transaction = \Yii::$app->db->beginTransaction();      //开启事务回滚
        $serverIdArr = [];                                      //用于存放服务id
        try{
            foreach($this->serverArr as $k=>$v){
                $server                 = new Server();
                $server->name           = $v;                                             //服务名
                $server->create_at      = time();                                         //添加时间
                $server->description    = '本服务属于"'.$this->serverComboName.'"套餐';   //描述（套餐名字）
                $server = $server->save() ? $server : $server->errors;
                if(isset($server->id)){
                    $serverIdArr[] = $server->id;                             //把服务id存到数组中
                }else{
                    return $server;
                }
            }
            $serverCombo            = new ServerCombo();
            $serverCombo->name      = $this->serverComboName;           //套餐名称
            $serverCombo->create_at = time();                           //添加时间
            $serverCombo->server_id = json_encode($serverIdArr);        //服务表ID
            if(!$serverCombo->save())
            {
                return $serverCombo->errors;
            }
            if($transaction->commit())                                   //提交事务
            {
                return false;
            }else{
                return true;
            }
        } catch (\Exception $e){
            $transaction->rollBack();                                     //回滚事务
            return $e->getMessage();
        }
    }

    public function saveServer($companyId,$venueId)
    {
        $server                 = new Server();
        $server->name           = $this->name;                                             //服务名
        $server->create_at      = time();                                         //添加时间
        $server->description    = $this->name.'服务';   //描述（套餐名字）
        $server->company_id     = $companyId;
        $server->venue_id       = $venueId;
        return $server->save() ? true : $server->errors;
    }
}