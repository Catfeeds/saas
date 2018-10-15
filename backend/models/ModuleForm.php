<?php
namespace backend\models;

use common\models\base\Employee;
use common\models\base\Module;
use yii\base\Model;
class ModuleForm extends Model
{
    public $topName;      //菜单名
    public $topEName;     //菜单英文名
    public $topIcon;      //图标
    public $sorts;

    public $subModuleId;
    public $topModuleId;

    public $topNumArr;
    public $topIdArr;
    public $dataArr = array();

    public $subNumArr;
    public $subIdArr;
    public $subArr = array();

    public function rules()
    {
        return [
            [['topName','topEName','topIcon'],'safe'],
            [['subModuleId','topModuleId'],'safe'],
            [['topNumArr','topIdArr'],'safe'],
            [['subNumArr','subIdArr'],'safe']
        ];
    }

    public function getCreate()
    {
        $create = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        $create = isset($create->id)?intval($create->id):0;
        return $create;
    }
    /**
     * @云运动 - 菜单管理 - 新增顶级菜单
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/16
     * 新增状态区分手机和pc菜单status
     */
    public function saveTopModule($type=1)
    {
        $module            = new Module();
        $module->name      = $this->topName;
        $module->e_name    = $this->topEName;
        $module->icon      = $this->topIcon;
        $module->level     = 1;
        $module->pid       = 0;
        $module->note      = '顶级菜单';
        $module->type      = $type;
        $module->create_id = $this->getCreate();
        $module->create_at = time();
        $module = $module->save() ? $module : $module->errors;
        if ($module) {
            return true;
        }else{
            return $module->errors;
        }
    }

    /**
     * @云运动 - 菜单管理 - 删除顶级菜单、子菜单
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/16
     */
    public function deleteModule($id)
    {
        $topId = Module::findAll(['pid' => $id]);
        if(isset($topId) && $topId != null){
            return '此菜单包含子菜单，请勿删除';
        }else{
            $module    = Module::findOne($id);
            $delModule = $module->delete();
        }
        if($delModule) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * @云运动 - 菜单管理 - 移动子菜单
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/28
     */
    public function moveSubModule()
    {
        $module = Module::findOne(['id' => $this->subModuleId]);
        if(!empty($module)){
            $module->pid = $this->topModuleId;
            $module->update_at = time();
            if($module->save()){
                return true;
            }else{
                return $module->errors;
            }
        }
    }


    /**
     * @云运动 - 菜单管理 - 处理顶级菜单排序数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/28
     */
    public function setArray()
    {
        $data   = [];
        $data[] = [$this->topNumArr,$this->topIdArr];
        $this->dataArr = $data;
    }
    /**
     * @云运动 - 菜单管理 - 顶级菜单排序
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/28
     *type 1为pc端菜单排序，2手机端  方便两个控制器调用这一个方法
     */
    public function topSort($type = 1)
    {
        $this->setArray();
        $topNumArr = $this->dataArr[0][0];               //序号 数组
        $topIdArr  = $this->dataArr[0][1];               //顶级菜单id 数组
        if (isset($topIdArr) && $topIdArr) {
            foreach ($topIdArr as $key => $value) {
                $module = Module::findOne(['id' => $value]);
                $module->number = (int)$topNumArr[$key];
                if (!$module->save()) {
                    return $module->errors;
                }
            }
            return true;
        }
        return true;
    }

    /**
     * @云运动 - 菜单管理 - 处理顶级菜单排序数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/28
     */
    public function getArray()
    {
        $data   = [];
        $data[] = [$this->subNumArr,$this->subIdArr];
        $this->subArr = $data;
    }
    /**
     * @云运动 - 菜单管理 - 顶级菜单排序
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/28
     */
    public function subSort()
    {
        $this->getArray();
        $subNumArr = $this->subArr[0][0];               //序号 数组
        $subIdArr  = $this->subArr[0][1];               //子菜单id 数组
        if (count($subNumArr) != count(array_unique($subNumArr))) {
            return '请不要输入重复序号';
        }
        if (isset($subIdArr) && $subIdArr) {
            foreach ($subIdArr as $key => $value) {
                $module = Module::findOne(['id' => $value]);
                $module->number = (int)$subNumArr[$key];
                if (!$module->save()) {
                    return $module->errors;
                }
            }
            return true;
        }
        return true;
    }
}