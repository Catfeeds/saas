<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use common\models\relations\AdminLogRelations;
use Yii;

/**
 * This is the model class for table "{{%admin_log}}".
 *
 * @property integer $id
 * @property string $route
 * @property string $description
 * @property integer $created_at
 * @property integer $user_id
 */
class AdminLog extends \yii\db\ActiveRecord
{
    use AdminLogRelations;
    public $id;
    public $route;
    public $created_at;
    public $description;
    public $ip;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_log}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['user_id', 'ip','created_at'], 'integer'],
            [['route'], 'string', 'max' => 255],
            ['description,user_id,route,ip,created_at','safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'route' => '路由',
            'description' => '详情',
            'created_at' => '操作时间',
            'user_id' => '操作人',
            'ip' => '操作人ip'
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => null
            ]
        ];
    }

    /**
     * 操作日志列表 - 查询
     * @param $params //搜索参数
     * @return \yii\db\ActiveQuery
     */
    public function search($params)
    {
            $where = $params['keywords']?['like','route',$params['keywords']]:'';
            $condition = $params['startTime'] && $params['endTime']?['between','FROM_UNIXTIME(l.created_at)',$params['startTime'], $params['endTime']]:[];
            $query = self::find()
                ->alias('l')
                ->joinWith(['admin m'],false)
                ->select(
                    "l.id,l.route,FROM_UNIXTIME(l.created_at) as created_at,l.user_id,inet_ntoa(l.ip) as ip,m.username"
                )
                ->where($where)
                ->andFilterWhere($condition)
                ->andWhere(['<>','route',''])
                ->orderBy('id desc')
                ->asArray();
            $dataProvider          =  Func::getDataProvider($query,12);

            return  $dataProvider;


    }
    /**
     * 操作日志列表 - 查询一条记录
     * @param $params //搜索参数
     * @return \yii\db\ActiveQuery
     */
    public function findOneLog($id)
    {
        $data = self::find()
            ->alias('l')
            ->joinWith(['admin m'],false)
            ->select(
                "l.id,l.route,FROM_UNIXTIME(l.created_at) as created_at,l.description,l.user_id,inet_ntoa(l.ip) as ip,m.username"
            )
            ->where(['l.id'=>$id])
            ->asArray()
            ->one();

        return  $data;


    }

    /**
     *  - 增加搜索条件
     * @param $query
     * @return mixed
     */
    public function getSearchWhere($query)
    {
        $query->Where(['like','l.route','/check-card/make-sure-member-card']);
        return $query;
    }
}

