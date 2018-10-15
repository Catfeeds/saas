<?php

namespace common\models;


class Config extends \common\models\base\Config
{
    /**
     * 后台 - 团课排课 - 获取预约设置信息
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/06/02
     * @return object     //返回所有预约设置信息
     */
    public function getConfigDetail()
    {
        $data = Config::find()->select("key, value, company_id")->asArray();
        $query = $this->getSearchIdentify($data);
        $data = $query->all();
        if (!empty($data)) {
            $data = $this->combineData($data);
        } else {
            $data = [];
        }

        return $data;
    }

    /**
     * @describe 后台 - 新团课排课 - 按照身份进行数据搜索
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @param $query
     * @param $type
     * @param $id
     * @return mixed
     */
    public function getSearchIdentify($query)
    {
        $query->andFilterWhere(['venue_id' => \backend\rbac\Config::accessVenues()]);

        return $query;
    }

    /**
     * 后台 - 团课排课 - 获取预约设置信息(数据整理展示)
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/06/02
     * @param
     * @return object     //返回所有预约设置信息
     */
    public function combineData($data)
    {
        $dataS = [];
        foreach ($data as $keys => $values) {
            $dataS[$values["key"]] = $values["value"];
        }
        $dataS["company_id"] = $data[0]["company_id"];
        return $dataS;
    }


}