<?php
namespace backend\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
class TrainTemplateSearch extends Action
{
    public $title;
    public $cid;
    public $sorts;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string'],
            [['cid'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * 私教管理-动作库-搜索动作
     *
     * @author jianbingqi<jianbingqi@itsports.club>
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $this->customLoad($params);
        $query = TrainTemplates::find()
            //->select('t.id,t.title,t.updated_at,s.id,s.template_id,s.title,s.length_time')
            ->alias('t')
            ->joinWith(['stages s'/* => function ($query) {
                $query->joinWith(['actions a']);
            }*/])
            ->asArray()
            ->groupBy('id')
            ->orderBy($this->sorts);
        $query = $this->setWhereSearch($query);

        return $query;
    }
    /**
     * @云运动 - 训练模板-搜索数据处理
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $data
     * @return bool
     */
    public function customLoad($data)
    {
        $this->title  = (isset($data['keyword']) && !empty($data['keyword'])) ? $data['keyword'] : null;  //搜索条件
        $this->cid  = (isset($data['cid']) && !empty($data['cid'])) ? $data['cid'] : null;  //搜索条件
        $this->sorts           = self::loadSort($data);        //排序

    }

    /**
     * @云运动 - 训练模板-搜索条件处理
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $data
     * @return mixed
     */
    public function setWhereSearch($query)
    {
        if($this->title){
            $query->andFilterWhere(['like', 't.title', $this->title]);
        }
        if($this->cid){
            $query->andFilterWhere(['cid'=> $this->cid]);
        }

        return $query;
    }
    /**
     * @云运动 - 训练模板- 获取排序条件
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $data
     * @return mixed
     */

    public static function loadSort($data)
    {
        $sorts = 'CREATED_AT DESC';

        return $sorts;
    }

}