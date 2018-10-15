<?php

namespace backend\models;

use common\models\base\Organization;
use common\models\Func;
use common\models\relations\ApplyRecordRelations;
use Yii;

class ApplyRecord extends \common\models\ApplyRecord
{
    use ApplyRecordRelations;
    public $keywords;
    public $sorts;
    public $searchContent;
    public $nowBelongId;
    const KEY = 'keywords';
    const SEARCH_CONTENT = 'searchContent';
    const NOW_BELONG_ID = 'nowBelongId';
    const NOW_BELONG_TYPE = 'nowBelongType';

    /**
     * @describe @云运动 - 公司联盟 - 查询本公司申请列表
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-08-01
     * @param $params
     * @param $companyId
     * @return \yii\data\ActiveDataProvider
     */
    public function getApply($params, $companyId)
    {
        $this->customLoad($params);
        $query = ApplyRecord::find()
            ->alias('ar')
            ->joinWith(['organization or'])
            ->joinWith(['organizations org'])
            ->where(['ar.apply_id' => $companyId])
            ->orWhere(['ar.be_apply_id' => $companyId])
            ->select(
                'ar.id,
                   ar.apply_id,
                   ar.be_apply_id,
                   ar.status,
                   ar.start_apply,
                   ar.end_apply,
                   or.name,
                   org.name as orgName')
            ->orderBy(['ar.create_at' => SORT_DESC])
            ->asArray();

        $query = $this->getSearchWhere($query);

        return Func::getDataProvider($query, 8);
    }

    /**
     * @云运动 - 公司联盟 - 待处理数据条数
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/7/03
     */
    public function getPending($companyId)
    {
        $num = ApplyRecord::find()->where(['be_apply_id' => $companyId, 'status' => 2])->andWhere(['>', 'end_apply', time()])->count();
        return $num;
    }

    /**
     * @云运动 - 公司联盟 - 查询品牌名称
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/29
     */
    public static function getCompany($companyId)
    {
        $company = Organization::find()->where(['id' => $companyId])->select('id,name')->asArray()->one();
        return $company;
    }

    /**
     * @云运动 - 公司联盟 - 增加搜索条件
     * @create 2017/6/28
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @param $query
     * @return mixed
     */
    public function getSearchWhere($query)
    {
        $query->andFilterWhere(['or', ['like', 'or.name', $this->keywords], ['like', 'org.name', $this->keywords]]);
        $query->andFilterWhere(['or', ['ar.be_apply_id' => $this->nowBelongId], ['ar.apply_id' => $this->nowBelongId]]);

        return $query;
    }

    /**
     * @云运动 - 公司联盟 - 搜索数据处理数据
     * @create 2017/6/28
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @param $data
     * @return bool
     */
    public function customLoad($data)
    {
        $this->keywords = (isset($data[self::KEY]) && !empty($data[self::KEY])) ? $data[self::KEY] : null;
        $this->searchContent = (isset($data[self::SEARCH_CONTENT]) && !empty($data[self::SEARCH_CONTENT])) ? $data[self::SEARCH_CONTENT] : null;
        $this->sorts = self::loadSort($data);

        return true;
    }

    /**
     * @云运动 - 公司联盟 - 获取搜索规格
     * @create 2017/6/28
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @param $data
     * @return bool
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
     * @云运动 - 公司联盟 - 获取排序条件
     * @create 2017/6/28
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @param $data
     * @return bool
     */
    public static function loadSort($data)
    {
        $sorts = [
            'id' => SORT_DESC
        ];
        if (!isset($data['sortType'])) {
            return $sorts;
        }
        switch ($data['sortType']) {
            case 'name'          :
                $attr = '`or`.name';
                break;
            default;
                return $sorts;
        }
        return $sorts = [$attr => self::convertSortValue($data['sortName'])];

    }

    /**
     * @云运动 - 公司联盟 - 查询申请详情
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/27
     */
    public function getApplyData($id, $companyId)
    {
        $applyId = ApplyRecord::findOne($id);
        if ($applyId['apply_id'] == $companyId) {
            $apply = ApplyRecord::find()
                ->alias('ar')
                ->where(['id' => $id, 'apply_id' => $companyId])
                ->select('ar.id,ar.status,ar.start_apply,ar.end_apply')
                ->asArray()
                ->one();
            return $apply;
        }
        if ($applyId['be_apply_id'] == $companyId) {
            $beApply = ApplyRecord::find()
                ->alias('ar')
                ->joinWith(['organization or'])
                ->where(['ar.id' => $id, 'be_apply_id' => $companyId])
                ->select('ar.id,ar.apply_id,ar.status,ar.start_apply,ar.end_apply,or.name')
                ->asArray()
                ->one();
            return $beApply;
        }

        return [];
    }

    /**
     * @云运动 - 公司联盟 - 查询申请记录
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/28
     */
    public function getRecordData($id, $companyId)
    {
        $id = ApplyRecord::findOne($id);
        if ($id['apply_id'] == $companyId) {
            $apply = ApplyRecord::find()
                ->alias('ar')
                ->where(['apply_id' => $companyId, 'be_apply_id' => $id['be_apply_id']])
                ->select('ar.id,ar.status,ar.start_apply,ar.end_apply,ar.note,ar.create_at')
                ->orderBy(['ar.create_at' => SORT_DESC])
                ->asArray()
                ->all();
            return $apply;
        }
        if ($id['be_apply_id'] == $companyId) {
            $beApply = ApplyRecord::find()
                ->alias('ar')
                ->where(['be_apply_id' => $companyId, 'apply_id' => $id['apply_id']])
                ->select('ar.id,ar.status,ar.start_apply,ar.end_apply,ar.note,ar.create_at')
                ->orderBy(['ar.create_at' => SORT_DESC])
                ->asArray()
                ->all();
            return $beApply;
        }

        return [];
    }
}