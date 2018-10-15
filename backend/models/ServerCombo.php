<?php
namespace backend\models;
use common\models\Func;

class ServerCombo extends \common\models\ServerCombo
{
    public $keywords;                           //搜索条件
    public $sorts;                              //排序
    public $searchContent;
    public $nowBelongId;
    public $nowBelongType;

    const SEARCH_CONTENT = 'searchContent';
    const NOW_BELONG_ID = 'nowBelongId';
    const NOW_BELONG_TYPE = 'nowBelongType';
    /**
     * 云运动 - 后台 - 查询服务套餐主方法
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/8
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getServerComboInfo($params)
    {
        $this->customLoad($params);                     //搜索、排序条件处理
        $data         = Server::find()->select('id,name')->orderBy($this->sorts)->asArray();
        $query        = $this->setWhereSearch($data);
        $dataProvider = Func::getDataProvider($query,8);
        return $dataProvider;
    }
    /**
     * @云运动 - 后台 - 服务搜索数据处理
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/8
     * @param $data
     * @return bool
     */
    public function customLoad($data)
    {
        $this->keywords         = (isset($data['keywords']) && !empty($data['keywords'])) ? $data['keywords'] : null;  //搜索条件
        $this->sorts            = self::loadSort($data);        //排序
        $this->searchContent   = (isset($data[self::SEARCH_CONTENT]) && !empty($data[self::SEARCH_CONTENT])) ? $data[self::SEARCH_CONTENT] : null;
        $this->nowBelongId     = (isset($data[self::NOW_BELONG_ID]) && !empty($data[self::NOW_BELONG_ID])) ? $data[self::NOW_BELONG_ID] : null;
        $this->nowBelongType   = (isset($data[self::NOW_BELONG_TYPE]) && !empty($data[self::NOW_BELONG_TYPE])) ? $data[self::NOW_BELONG_TYPE] : null;
        return true;
    }

    /**
     * 后台 - 服务管理 - 处理搜索条件
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/8
     * @param $query
     * @return mixed
     */
    public function setWhereSearch($query)
    {
        $query->andFilterWhere([
          'like','name',$this->keywords,
        ]);
        if($this->nowBelongType && $this->nowBelongType == 'company'){
            $query->andFilterWhere(['company_id'=>$this->nowBelongId]);
        }
        if($this->nowBelongType && ($this->nowBelongType == 'venue' || $this->nowBelongType == 'department')){
            $query->andFilterWhere(['venue_id'=>$this->nowBelongId]);
        }
        return $query;
    }

    /**
     * 会员卡管理 - 服务 - 获取排序条件
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/8
     * @param $data     //排序数据
     * @return array
     */
    public static function loadSort($data)
    {

        $sorts = ['id' => SORT_DESC];
        if(!isset($data['sortType'])){ return $sorts; }
        switch ($data['sortType']){
            case 'comboName'  :
                $attr = 'name';
                break;
            default:
                $attr = NULL;
        };
        if($attr){
            $sorts = [ $attr  => self::convertSortValue($data['sortName']) ]; //给字段赋值排序方式
        }
        return $sorts;
    }

    /**
     * 会员卡管理 - 服务 - 获取排序条件
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/8
     * @param $sort
     * @return mixed
     */
    public static function convertSortValue($sort)
    {
        if ($sort == 'ASC') {
            return SORT_ASC;
        } elseif ($sort == 'DES') {
            return SORT_DESC;
        }
    }

    /**
     * 云运动 - 后台 - 删除服务和服务套餐
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/8
     * @param $id                   //服务套餐id
     * @return bool|string
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function delAllServerInfo($id)
    {
        $transaction = \Yii::$app->db->beginTransaction();      //开启事务回滚
        try{
            $data = ServerCombo::find()->where(['id'=>$id])->asArray()->one();
            foreach (json_decode($data['server_id']) as $k=>$v)
            {
                $server = Server::findOne($v);                   //准备删除服务
                $server->delete();
            }
            $serverCombo = ServerCombo::findOne($id);
            $serverCombo->delete();                              //删除服务套餐
            if(!$transaction->commit())
            {
                return true;
            }
        }catch (\Exception $e){
            $transaction->rollBack();                           //事务回滚
            return $e->getMessage();
        }
    }
}