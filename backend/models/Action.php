<?php
namespace backend\models;
use common\models\Func;
use common\models\relations\ActionRelations;
use yii\caching\TagDependency;
use Yii;

class Action extends \common\models\base\Action
{
    use ActionRelations;
    /**
     * 私教管理-动作详情
     * @param int $id
     * @return Action detail
     * @
     */
    public static function getOneDetail($id)
    {
        $data =  Action::find()->alias('a')
                        ->joinWith(['categorys c'])
                        ->joinWith(['images i'])
                        ->where(['a.id'=>$id])
                        ->asArray()
                        ->one();
        if($data['categorys']){
            foreach ($data['categorys'] as $key=>$value){
                foreach ($value as $k=>$v){
                    $data['categorys'][$key]['p_title'] = ActionCategory::findOne($value['pid'])->title;
                }
            }
        }

        return $data;
    }

    /**
     * 私教管理-动作-新增
     * @param
     * @return mixed
     * @throws
     */
    public  function insertAction($param)
    {
        $this->loadDefaultValues();
        $this->load($param,'');
       return  $this->save();

    }
}
