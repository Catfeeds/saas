<?php
namespace backend\models;

use yii\data\ActiveDataProvider;
use yii\base\Model;
use yii\db\Expression;


class ClassBeforeQuestionSearch extends ClassBeforeQuestion
{
    public $name;
    public $start_at;
    public $end_at;
    public $sorts;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'update_at'], 'integer'],
            [['name'], 'string'],
        ];
    }


    /**
     * 私教管理-课前询问-搜索
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param array $params
     * @return mixed
     */
    public function search($params)
    {
        $this->paramsLoad($params);
        $query = Course::find()
            ->from(Course::tableName().'c')
            ->select('c.id,c.name')
            ->rightJoin(ClassBeforeQuestion::tableName(). 'CL', 'c.id = CL.course_id')
            ->groupBy('c.id')
            ->orderBy($this->sorts)
            ->asArray();
        $query = $this->setWhereSearch($query);
        return $query;
    }

    /**
     * @云运动 - 课前询问-搜索数据处理
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $data
     * @return bool
     */
    public function paramsLoad($data)
    {
        $this->name             = (isset($data['keyword']) && !empty($data['keyword'])) ? $data['keyword'] : null;  //搜索条件
        $this->start_at          = (isset($data['start_at'])&& !empty($data['start_at']))? (int)strtotime($data['start_at']) : null;
        $this->end_at            = (isset($data['end_at']) && !empty($data['end_at'])) ? (int)strtotime($data['end_at']) : null;
        $this->sorts             = self::loadSort($data);        //排序
    }
    /**
     * @云运动 - 私教管理-课前询问-搜索条件处理
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $data
     * @return bool
     */
    public function setWhereSearch($query)
    {
        if($this->start_at && $this->end_at){
            $query->andFilterWhere(['between','c.update_at', $this->start_at, $this->end_at]);
        }
        if($this->name){
            $query->andFilterWhere(['like', 'c.name', $this->name]);
        }

        return $query;
    }

    /**
     * @云运动 - 私教管理-课前询问- 获取排序条件
     * @author jianbingqi<jianbingqi@itsports.club>
     * @param $data
     * @return mixed
     */

    public static function loadSort($data)
    {
        $sorts = 'id DESC';

        return $sorts;
    }
}