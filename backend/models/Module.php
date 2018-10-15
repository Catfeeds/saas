<?php
namespace backend\models;

use common\models\relations\ModuleRelations;
use common\models\Func;
class Module extends \common\models\base\Module
{
    use ModuleRelations;
    public $sorts;
    /**
     * @云运动 - 菜单管理 - 查询顶级菜单
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/16
     */
    public function getTopModule($type)
    {
        $module = Module::find()
            ->alias('mod')
            ->joinWith(['module module' => function($query){
                $query->orderBy('module.number ASC');  //子菜单 按照序号升序排列
            }])
            ->where(['mod.type'=>$type])
            ->andWhere(['mod.pid' => 0])
            ->orderBy('mod.number ASC')      //按照序号升序排列
            ->asArray()
            ->all();
        return $module;
    }

    public function customLoad($data)
    {
        $this->sorts = self::sorts($data);
        return true;
    }

    public static function sorts($data)
    {
        $sorts = [
            'id' => SORT_DESC
        ];
        if (!isset($data['sortType'])) {
            return $sorts;
        }
        switch($data['sortType'])
        {
            case 'name' :
                $attr = '`mod`.name';
                break;
            case 'e_name' :
                $attr = '`mod`.e_name';
                break;
            case 'create_at' :
                $attr = '`mod`.create_at';
                break;
            case 'sub_module' :
                $attr = '`mod`.create_at';
                break;
            default;
                return $sorts;
        }
        return $sorts = [ $attr  => self::convertSortValue($data['sortName']) ];
    }

    public static function convertSortValue($sort)
    {
        if ($sort == 'ASC') {
            return SORT_ASC;
        } elseif ($sort == 'DES') {
            return SORT_DESC;
        }
    }

    public function getModuleData($id)
    {
        $module = Module::find()->where(['id' => $id])->asArray()->one();
        return $module;
    }

    /**
     * 菜单管理 - 查看子菜单 - 是否分配状态修改
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/11/24
     * @param $moduleId
     * @return bool
     */
    public static function getUpdateModule($moduleId)
    {
        $moduleId  =  \common\models\base\Module::findOne($moduleId);

        if($moduleId->is_show == null){
            $moduleId->is_show = 2;
        }else if($moduleId->is_show == 2){
            $moduleId->is_show = 1;
        }else{
            $moduleId->is_show = 2;
        }
        if($moduleId->save()){
            return true;
        }else{
            return $moduleId->errors;
        }
    }
}