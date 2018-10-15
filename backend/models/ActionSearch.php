<?php
namespace backend\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
use yii\db\Expression;
class ActionSearch extends Action
{
    public $title;
    public $category_id;
    public $start_at;
    public $end_at;
    public $sorts;
    public $type;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'type'], 'integer'],
            ['category_id', 'safe'],
            [['title'], 'string'],
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
        $this->paramsLoad($params);
        $query = Action::find()
            ->select('a.id,a.title,a.created_at,a.updated_at,a.type')
            ->alias("a")
            ->joinWith(['categorys c'])
            ->joinWith(['images i'],false)
            ->where(['a.is_delete'=>0])
            ->groupBy('a.id')
            ->orderBy($this->sorts)
            ->asArray();
        $query = $this->setWhereSearch($query);
        return $query;
    }
    /**
     * @云运动 - 私教管理-搜索数据处理
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $data
     * @return bool
     */
    public function paramsLoad($data)
    {
        $this->title             = (isset($data['title']) && !empty($data['title'])) ? $data['title'] : null;  //搜索条件
        $this->category_id       = (isset($data['category_id']) && !empty($data['category_id'])) ? $data['category_id'] : null;  //搜索条件
        $this->type              = (isset($data['type'])) ? $data['type'] : null;  //搜索条件
        $this->start_at          = (isset($data['start_at'])&& !empty($data['start_at']))? (int)strtotime($data['start_at']) : null;
        $this->end_at            = (isset($data['end_at']) && !empty($data['end_at'])) ? (int)strtotime($data['end_at']) : null;
        $this->sorts             = self::loadSort($data);        //排序
    }

    /**
     * @云运动 - 私教管理-搜索条件处理
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $data
     * @return bool
     */
    public function setWhereSearch($query)
    {
        if($this->type !== NUll){
            $query->andFilterWhere([
                'a.type' => $this->type,
            ]);
        }
        if($cidArr = $this->category_id){
            foreach ($cidArr as $k=>$v){
                $query->andWhere(new Expression("FIND_IN_SET('{$v}', a.cate_id) "));
            }
        }
        if($this->start_at &&$this->end_at){
            $query->andFilterWhere(['between','a.updated_at', $this->start_at, $this->end_at]);
        }
        if($this->title){
            $query->andFilterWhere(['like', 'a.title', $this->title]);
        }

        return $query;
    }

    /**
     * @云运动 - 私教管理- 获取排序条件
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $data
     * @return mixed
     */

    public static function loadSort($data)
    {
        $sorts = 'UPDATED_AT DESC';

        return $sorts;
    }

}