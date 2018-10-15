<?php

namespace backend\models;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Func;
use yii;
class Dictionary extends Model
{
    /**
     * 云运动 - 数据库字典 - 获取数据库名称
     * @return array|string
     */
    public function getDatabaseName()
    {
        $sql             = 'select database()';
        $name            = self::getSqlData($sql);

        if(is_array($name) && !empty($name)) {
                $name = $name[0]['database()'];
        }else{
                $name = 'clouds';
        }

        return $name;
    }
    /**
     * 云运动 - 数据库字典 - 获取数据表名称
     * @param $name
     * @return array
     */
    public function getTable($name)
    {
        $model           = [];
        $sql             = 'show table status';
        $posts           = $this->getSqlData($sql);
        $name            = isset($name) ? $name : 'user' ;
        $model['table']  = $posts;
        $model['data']   = $this->getTableDetail($name);
        return $model;
    }

    /**
     * 云运动 - 数据库字典 - 获取表备注
     * @param $name
     * @return array
     */
    public function getTableDetail($name)
    {
          $data               = [];
          $databaseName       =$this->getDatabaseName();
          $data['table']     =  $this->getTableData('table',$name,$databaseName);
          return             $data;
    }

    /**
     * 云运动 - 数据库字典 - 执行AR操作
     * @param $type
     * @param $name
     * @param $databaseName
     * @return $this
     */
    public function getTableSql($type,$name,$databaseName)
    {
        $query = (new yii\db\Query())->select('*')
                    ->where(['TABLE_NAME'=>$name])
                    ->andWhere(['table_schema'=>$databaseName]);

       if($type == 'table'){
          return $query->from('information_schema.TABLES');

       }else{
          return $query->from('information_schema.COLUMNS');
       }
    }

    /**
     * 云运动 - 数据库字典 - 获取字段信息
     * @param $type
     * @param $name
     * @param $databaseName
     * @return mixed
     */
    public function getTableData($type,$name,$databaseName)
    {
        $query          = $this->getTableSql($type,$name,$databaseName);
        $data           = $query->all();
        return         $data;
    }

    /**
     * 云运动 - 数据库字典 - 执行sql
     * @param $sql
     * @return array
     */
    public function getSqlData($sql)
    {
        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    /**
     * 云运动 - 数据库字典 - 获取表字段分页
     * @param $name
     * @return ActiveDataProvider
     */
    public static function getTableByDataSql($name)
    {
         $databaseName = self::getDatabaseName();
         $query        = self::getTableSql('detail',$name,$databaseName);
         $dataProvider = Func::getDataProvider($query,25);
        return  $dataProvider;
    }
}