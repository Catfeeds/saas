<?php
namespace backend\models;
use Yii;
use yii\base\Model;
use common\models\base\Functional;
use common\models\Func;
class FunctionalForm extends Model
{
    public $name;          //功能名称
    public $eName;         //功能英文名
    public $note;          //说明
    public $id;            //功能id

    public $sorts;         //功能列表排序
    public $keywords;       //搜索功能-关键字
    const KEYWORDS  = 'keywords';
    /**
     * @云运动 - 后台 - 新增角色验证规则
     * @create 2017/6/16
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['id','name','createId','createAt', 'eName', 'note'], 'safe'],
        ];
    }

    /**
     * 云运动 - 后台- 新增功能信息录入
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/6/16
     * @return boolean/object
     */
    public function addMyData()
    {
        // 功能信息保存
        $model = new Functional();
        $model->create_id = $this->getCreate();
        $model->create_at = time();
        $model->name = $this->name;
        $model->note = $this->note;
        $model->e_name = $this->eName;
        if ($model->save()) {
            return true;
        } else {
            return $model->errors;
        }
    }
    public function getCreate()
    {
        $create = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $create = isset($create->id)?intval($create->id):0;
        return $create;
    }

    /**
     * 云运动 - 功能管理 - 点击修改单条信息
     * @author Huanghua <Huanghua@itsports.club>
     * @create 2017/6/16
     * @param
     * @return boolean/object
     */
    public function updateData()
    {
        //角色数据信息修改
        $model = Functional::findOne(['id' => $this->id]);
        $model->name = $this->name;
        $model->note = $this->note;
        $model->e_name = $this->eName;
        $model->create_id = $this->getCreate();
        $model->update_at = time();
        
        if ($model->save()) {
            return true;
        } else {
            return $model->errors;
        }
    }

    /**
     * 云运动 - 功能管理 - 点击查看单条角色信息详情
     * @author Huanghua <Huanghua@itsports.club>
     * @create 2017/6/16
     * @param
     * @return boolean/object
     */
    public function getRoleModel($id)
    {
        $model = Functional::find()
            ->alias('role')
            ->where(['role.id' => $id])
            ->asArray()->one();
        return $model;
    }

    /**
     * 功能管理 - 功能列表 - 获取搜索规格
     * @create 2017/6/18
     * @author huanghua<huanghua@itsports.club>
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
     * 功能管理 - 功能列表 - 获取排序条件
     * @create 2017/6/18
     * @author huanghua<huanghua@itsports.club>
     * @param $data
     * @return mixed
     */
    public static function loadSort($data)
    {
        $sorts = [
            'id' => SORT_DESC
        ];
        if (!isset($data['sortType'])) {
            return $sorts;
        }
        switch($data['sortType'])
        {
            case 'fun_name'          :
                $attr = '`fun`.name';
                break;
            case 'fun_eName'           :
                $attr = '`fun`.e_name';
                break;
            case 'fun_createAt'          :
                $attr = '`fun`.create_at';
                break;
            case 'fun_note'           :
                $attr = '`fun`.note';
                break;
            default;
                return $sorts;
        }
        return $sorts = [ $attr  => self::convertSortValue($data['sortName']) ];

    }
    /**
     * 云运动 - 功能管理 - 遍历列表信息
     * @author Huanghua <Huanghua@itsports.club>
     * @param $params
     * @create 2017/6/16
     * @return boolean/object
     */
    public function search($params)
    {
        $this->customLoad($params);
        $query = Functional::find()
            ->alias('fun')
            ->orderBy($this->sorts)
            ->asArray();
        $query = $this->getSearch($query);
        $dataProvider          =  Func::getDataProvider($query,8);
        return  $dataProvider;
    }

    public function customLoad($data)
    {
        $this->sorts = self::loadSort($data);
        $this->keywords = (isset($data[self::KEYWORDS]) && !empty($data[self::KEYWORDS])) ? $data[self::KEYWORDS] : null;
        return true;
    }

    /**
     * @desc: 业务后台 - 功能管理 - 关键字搜索
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/04/28
     * @param $query
     * @return mixed
     */
    public function getSearch($query)
    {
        $query->andFilterWhere(
            ['or',
                ['like','name',$this->keywords],
                ['like','e_name',$this->keywords]
            ]
        );
        return $query;
    }

    /**
     * 后台 - 功能管理 - 角色基本信息删除
     * @author Huang Hua <huanghua@itsports.club>
     * @create 2017/6/16
     * @param $id
     * @return bool
     */
    public  function  getRoleDelete($id)
    {
        $role             =   Functional::findOne($id);
        $resultDelete     =   $role->delete();
        if($resultDelete)
        {
            return true;
        }else{
            return false;
        }
    }
}