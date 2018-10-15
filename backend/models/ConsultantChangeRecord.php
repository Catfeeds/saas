<?php
namespace backend\models;
use common\models\relations\ConsultantChangeRecordRelations;
use common\models\Func;
use Yii;
class ConsultantChangeRecord extends \common\models\base\ConsultantChangeRecord
{
    use ConsultantChangeRecordRelations;
    /**
     * 后台会员管理 - 会籍顾问列表 - 多表查询
     * @author Huang hua <huanghua@itsports.club>
     * @param $id
     * @create 2018/2/26
     * @return \yii\db\ActiveQuery
     */
    public function consultantListData($id)
    {
        $model = ConsultantChangeRecord::find()
            ->alias('cc')
            ->joinWith(['employee employee'],false)
            ->select(
                "     cc.id,
                      cc.member_id,
                      employee.name,
                      cc.created_at,
                      cc.behavior
                "
            )
            ->where(['and',['cc.type' => 1],['cc.member_id' => $id]])
            ->orderBy('cc.id desc')
            ->asArray();
        $dataProvider              =  Func::getDataProvider($model,8);
        return $dataProvider;

    }

    /**
     * 后台会员管理 - 私教变更列表 - 多表查询
     * @author Huang hua <huanghua@itsports.club>
     * @param $id
     * @create 2018/2/26
     * @return \yii\db\ActiveQuery
     */
    public function personalListData($id)
    {
        $model = ConsultantChangeRecord::find()
            ->alias('cc')
            ->joinWith(['employee employee'],false)
            ->select(
                "     cc.id,
                      cc.member_id,
                      employee.name,
                      cc.created_at,
                      cc.behavior
                "
            )
            ->where(['and',['cc.type' => 2],['cc.member_id' => $id]])
            ->orderBy('cc.id desc')
            ->asArray();
        $dataProvider              =  Func::getDataProvider($model,8);
        return $dataProvider;

    }

}