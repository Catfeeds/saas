<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/13 0013
 * Time: 15:36
 */
namespace backend\models;
use common\models\Func;
class MemberCabinetRentHistory extends \common\models\MemberCabinetRentHistory
{
    public function memberConsumList($memberId,$cabinetId,$type)
    {
        $query = MemberCabinetRentHistory::find()
            ->alias('mcrh')
            ->joinWith(['cabinet cabinet'=>function($query){
                $query->joinWith(['cabinetType cabinetType'],false);
            }],false)
            ->joinWith(['admin admin'=>function($query){
                $query->joinWith(['employee employee'],false);
            }],false)
            ->select("mcrh.*,cabinetType.type_name,cabinet.cabinet_number,employee.name")
            ->orderBy(['id'=>SORT_DESC])
            ->where(['mcrh.member_id'=>$memberId])
            ->asArray();
        if ($type == 'cabinet') {
            $query->andFilterWhere(['mcrh.cabinet_id'=>$cabinetId]);
        }
        $data = Func::getDataProvider($query, 8);
        return $data;
    }
}