<?php
namespace backend\models;
use common\models\relations\ActionCategoryRelations;
use yii\caching\TagDependency;
class ActionCategory extends \common\models\base\ActionCategory
{
    use ActionCategoryRelations;
    /**
     * 私教管理-动作库管理-获取所有分类
     * @param int $id
     * @return int
     * @throws
     */
    public static function getCateTree()
    {
        //查询顶级分类
        $data = self::find()->select('id,pid,title')->orderBy('pid asc')->asArray()->all();
        return $data;
    }
}
