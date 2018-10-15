<?php

namespace backend\models;

use common\models\Func;

class Server extends \common\models\Server
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
     * @describe 云运动 - 后台 - 查询服务套餐主方法
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function getServerInfo($params)
    {
        $this->customLoad($params);                     //搜索、排序条件处理
        $data = Server::find()->alias('server')->select('id,name')->orderBy($this->sorts)->asArray();
        $query = $this->setWhereSearch($data);
        $dataProvider = Func::getDataProvider($query, 8);

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
        $this->keywords = (isset($data['keywords']) && !empty($data['keywords'])) ? $data['keywords'] : null;  //搜索条件
        $this->sorts = self::loadSort($data);        //排序
        $this->searchContent = (isset($data[self::SEARCH_CONTENT]) && !empty($data[self::SEARCH_CONTENT])) ? $data[self::SEARCH_CONTENT] : null;

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
            'and',
            ['like', 'name', $this->keywords],
        ]);

        $query->andFilterWhere(['server.venue_id' => \backend\rbac\Config::accessVenues()]);

        return $query;
    }

    /**
     * 会员卡管理 - 服务 - 获取排序条件
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/8
     * @param $data //排序数据
     * @return array
     */
    public static function loadSort($data)
    {

        $sorts = ['id' => SORT_DESC];
        if (!isset($data['sortType'])) {
            return $sorts;
        }
        switch ($data['sortType']) {
            case 'comboName'  :
                $attr = 'name';
                break;
            default:
                $attr = NULL;
        };
        if ($attr) {
            $sorts = [$attr => self::convertSortValue($data['sortName'])]; //给字段赋值排序方式
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
        }else{
            return SORT_DESC;
        }
    }

    /**
     * @describe 后台 - 私教课程查询 - 获取服务套餐数据
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @param $id
     * @return array|\yii\db\ActiveQuery|\yii\db\ActiveRecord[]
     */
    public function getServerData($id)
    {
        $serverData = Server::find()->alias('server')->asArray();
        $serverData = $serverData->andFilterWhere(['server.venue_id' => $id]);
        $serverData = $serverData->all();

        return $serverData;
    }

    /**
     * @describe 后台 - 私教课程查询 - 删除服务
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @param $id
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delServerOne($id)
    {
        $server = Server::findOne($id);                   //准备删除服务
        if ($server->delete()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @describe 后台 - 私教课程查询 - 获取单个服务服务
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getServerOne($id)
    {
        $id = (int)$id;

        return Server::find()->where(["id" => $id])->asArray()->one();
    }
}