<?php
namespace backend\models;

use common\models\relations\MemberDepositRelations;
class MemberDeposit extends \common\models\base\MemberDeposit
{
    use MemberDepositRelations;
    public $nowBelongId;
    public $nowBelongType;
    const NOW_BELONG_ID = 'nowBelongId';
    const NOW_BELONG_TYPE = 'nowBelongType';
    public $type;
    const TYPE = 'type';


    /**
     *后台会员管理 - 会员详细信息 -  定金信息
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/12/28
     * @param $params
     * @return bool|string
     */
    public function memberDepositData($params)
    {
            $this->customLoad($params);
            $model = MemberDeposit::find()
                ->alias('md')
                ->joinWith(['order order'])
                ->where(['md.member_id' => $params['memberId']])
                ->andWhere(['order.consumption_type'=>'deposit'],false)
                ->andWhere(['or',['md.is_use'=>1],['md.is_use'=>null]])
                ->select('
                md.id,
                md.is_use,
                md.type,
                md.price,
                md.voucher,
                md.start_time,
                md.end_time,
                md.pay_mode,
                md.pay_mode,
                md.member_id,
                order.pay_money_time,
                order.sell_people_id,
                ')
                ->groupBy(['md.id'])
                ->orderBy('md.id DESC')
                ->asArray();
        $query                 = $this->getSearchWhere($model);
        $model                 = $query ->all();
        return $model;
    }


    /**
     *后台会员管理 - 会员详细信息 -  购卡买课续费升级定金信息
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/12/28
     * @param $type
     * @return bool|string
     */
    public function depositTypeData($type)
    {
        $model = MemberDeposit::find()
            ->alias('md')
            ->where(['and',['md.member_id' => $type['memberId']],['md.type' => $type['type']]])
            ->andWhere(['>','md.end_time',time()])
            ->andWhere(['<>','md.is_use',2])
            ->select('
                md.id,
                md.price,
                md.voucher
                ')
            ->groupBy(['md.id'])
            ->orderBy('md.id DESC')
            ->asArray()
            ->all();
        return $model;
    }

    /**
     * 会员管理 - 会员详情定金信息 - 搜索数据处理数据
     * @create 2017/12/28
     * @author huanghua<huanghua@itsports.club>
     * @param $data
     * @return bool
     */
    public function customLoad($data)
    {
        $this->type      = (isset($data[self::TYPE]) && !empty($data[self::TYPE])) ? $data[self::TYPE] : null;
        return true;
    }


    /**
     * 会员管理 - 会员详情定金信息 - 增加搜索条件
     * @create 2017/12/28
     * @author huanghua<huanghua@itsports.club>
     * @param $model
     * @return mixed
     */
    public function getSearchWhere($model)
    {
        $model->andFilterWhere(['md.type'=>$this->type]);
        return $model;
    }

    /**
     * 后台 - 会员管理 - 定金记录删除
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/12/28
     * @param $depositId
     * @return bool
     */
    public  function  getDepositDel($depositId)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try{
            //删除会员定金表数据
            $depositData    =   \common\models\base\MemberDeposit::findOne($depositId);
            $resultDelMem       =   $depositData->delete();
            if(!$resultDelMem) {
                return '删除定金记录失败';
            }
            //删除订单表数据
            $orderData = \common\models\Order::find()->where(['and',['consumption_type_id'=>$depositId],['consumption_type'=>'deposit']])->one();
            $resultDelOrder = $orderData->delete();
            if (!$resultDelOrder) {
                return '删除订单记录失败';
            }
            //删除消费记录表
            $historyData = ConsumptionHistory::find()->where(['and',['consumption_type_id'=>$depositId],['consumption_type'=>'deposit']])->one();
            $resultDelHistory = $historyData->delete();
            if (!$resultDelHistory) {
                return '删除消费记录失败';
            }
            if ($transaction->commit() === null) {
                return true;
            } else {
                return '删除失败';
            }
        }catch (\Exception $e) {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            return $e->getMessage();
        }
    }
}