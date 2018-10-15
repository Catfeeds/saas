<?php
namespace backend\models;

class ClassServer extends \common\models\ClassServer
{
    /**
     * 后台 - 私教课程查询 - 获取课程套餐数据
     * @author Houkaixin <Houkaixin@itsports.club>
     * @create 2017/4/13
     * @return \yii\db\ActiveQuery
     */
    public function getClassServerData(){
         $classServerData =ClassServer::find()->asArray()->all();
         return $classServerData;
    }
}