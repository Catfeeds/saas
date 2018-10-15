<?php
/**
 * Created by PhpStorm.
 * User: yidashi
 * Date: 16/7/25
 * Time: 下午12:25
 */

namespace backend\behaviors;


use common\models\AdminLog;
use Yii;
use yii\base\Application;
use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\helpers\Url;

class AdminLogBehavior extends Behavior
{
    public function events()
    {
        return [
            Application::EVENT_BEFORE_REQUEST => 'handle'
        ];
    }
    public function handle()
    {
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_UPDATE, [$this, 'log']);
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_INSERT, [$this, 'log']);
        Event::on(ActiveRecord::className(), ActiveRecord::EVENT_AFTER_DELETE, [$this, 'log']);
    }

    public function log($event)
    {
        if($event->sender instanceof AdminLog || !$event->sender->primaryKey()) {
            return;
        }
        if ($event->name == ActiveRecord::EVENT_AFTER_INSERT) {
            $description = "%s新增了表%s %s:%s的%s";
        } elseif($event->name == ActiveRecord::EVENT_AFTER_UPDATE) {
            $description = "%s修改了表%s %s:%s的%s";
        } else {
            $description = "%s删除了表%s %s:%s%s";
        }
        if (!empty($event->changedAttributes)) {
            $desc = '';
            foreach($event->changedAttributes as $name => $value) {
                $desc .= $name . ' : ' . $value . '=>' . $event->sender->getAttribute($name) . ',';
            }
            $desc = substr($desc, 0, -1);
        } else {
            $desc = '';
        }
        $Identity = Yii::$app->user->identity;
       if($Identity == NUll)//当系统变量中没有用户信息（没登陆）
       {
            //$mobile = Yii::$app->request->post();
            //$mobile = $mobile['PasswordResetRequestForm']['mobile'];
            //$user_id =  \common\models\Employee::findOne(['mobile'=>$mobile])->admin_user_id;
            //$userName = \common\models\Admin::findOne(['id'=>$user_id])->username;
            $user_id = 0;
            $userName = "";

        }
        else
        {
            $userName = Yii::$app->user->identity->username;
        }
        //var_dump(Yii::$app->user->identity);die;
        

        $tableName = $event->sender->tableSchema->name;
        $description = sprintf($description, $userName, $tableName, $event->sender->primaryKey()[0], is_array($event->sender->getPrimaryKey()) ? current($event->sender->getPrimaryKey()) : $event->sender->getPrimaryKey(), $desc);
        if(strlen($description)>1000){
            $description = '超过字符串长度';
        }
        $route = Url::to();
        $userId = $Identity == NUll?0:Yii::$app->user->id;
        $ip = ip2long(Yii::$app->request->userIP);
        $data = [
            'route' => $route,
            'description' => $description,
            'user_id' => $userId,
            'created_at'=>time(),
            'ip' => $ip
        ];

        Yii::$app->db->createCommand()->insert('cloud_admin_log', $data)->execute();
    }
}