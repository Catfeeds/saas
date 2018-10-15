<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/8 0008
 * Time: 10:57
 */

namespace backend\models;
use common\models\GiftCardList;
use common\models\relations\GiftCardActivityRelations;
use common\models\relations\GiftCardListRelations;
use common\models\Func;
class GiftCardActivity extends \common\models\GiftCardActivity
{
    use GiftCardActivityRelations;
    public $start_time;
    public $end_time;
    public $keywords;
    public $venue_id;
    public $category_type_id;
    public $id;              //新增赠送活动表id
    const START_TIME            = 'start_time';
    const END_TIME              = 'end_time';
    const KEYWORDS              = 'keywords';
    const VENUE_ID              = 'venue_id';
    const CATEGORY_TYPE_ID      = 'category_type_id';
    const ID                    = 'id';
    /**
     * @desc: 卡种管理-赠卡管理-获取赠送单位列表数据
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/08
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function searchActivityList($params)
    {
        $this->customLoad($params);
        $query = GiftCardActivity::find()
            ->alias('gca')
            ->joinWith(['organization org'],false)
            ->select('gca.*,org.name as venueName')
            ->orderBy('gca.id DESC')
            ->asArray();
        $query = $this->getSearchWhere($query,'activityList');
        $dataProvider = Func::getDataProvider($query,8);
        return $dataProvider;
    }

    /**
     * @desc: 卡种管理-赠卡管理-对获取参数进行处理
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/08
     * @param $data
     * @return bool
     */
    public function customLoad($data) {
        $roleId             =   \Yii::$app->user->identity->level;
        if($roleId == 0){
            $vId            =    Organization::find()->select('id')->where(['style'=>2])->asArray()->all();
            $venueIds       =    array_column($vId, 'id');
        }else{
            //拿到用户有权限查看的场馆
            $venuesId       =    Auth::findOne(['role_id' => $roleId])->venue_id;
            $authId         =    json_decode($venuesId);
            //去掉组织架构里面设置"不显示"的场馆id
            $venues         =    Organization::find()->where(['id'=>$authId])->select(['id','name'])->asArray()->all();
            $venueIds       =    array_column($venues, 'id');
        }
        $this->start_time       = (isset($data[self::START_TIME]) && !empty($data[self::START_TIME])) ? (int)strtotime($data[self::START_TIME]) : null;
        $this->end_time         = (isset($data[self::END_TIME])   && !empty($data[self::END_TIME]))   ? (int)strtotime($data[self::END_TIME])   : null;
        $this->keywords         = (isset($data[self::KEYWORDS])   && !empty($data[self::KEYWORDS]))   ? $data[self::KEYWORDS]   : null;
        $this->venue_id         = (isset($data[self::VENUE_ID])   && !empty($data[self::VENUE_ID]))   ? $data[self::VENUE_ID]   : $venueIds;
        $this->category_type_id = (isset($data[self::CATEGORY_TYPE_ID])  && !empty($data[self::CATEGORY_TYPE_ID]))   ? $data[self::CATEGORY_TYPE_ID]   : null;
        $this->id = (isset($data[self::ID])  && !empty($data[self::ID]))   ? $data[self::ID]   : null;
        return true;
    }
    /**
     * @desc: 卡种管理-赠卡管理-搜索条件
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/08
     * @param $query
     * @return mixed
     */
    public function getSearchWhere($query,$type)
    {
        if ($type == 'activityList') {
            $query->andFilterWhere(['and',
                ['>=','gca.create_time',$this->start_time],
                ['<=','gca.create_time',$this->end_time]
                ]);
            $query->andFilterWhere(['like','gca.active_name',$this->keywords]);
            $query->andFilterWhere(['venue_id'=>$this->venue_id]);
        }elseif($type == 'cardList') {
            $query->andFilterWhere(['and',
                ['>=','gcl.create_time',$this->start_time],
                ['<=','gcl.create_time',$this->end_time]
            ]);
            $query->andFilterWhere(['or',
                ['like','gcl.card_number',$this->keywords],
                ['like','gcl.mobile',$this->keywords],
                ['like','gcl.nickname',$this->keywords],
                ['ID_code'=>$this->keywords]
                ]);
            $query->andFilterWhere(['gcl.category_type_id'=>$this->category_type_id]);
        }

        return $query;
    }

    /**
     * @desc: 卡种管理-赠卡管理-获取会员卡列表数据
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/08
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function searchCardList($params)
    {
        $this->customLoad($params);
        $query = GiftCardList::find()
            ->alias('gcl')
            ->select('gcl.*,ccy.card_name as card_name,cct.type_name as type_name,memberCard.active_time as active_card_time,memberCard.invalid_time as expire_card_time')
            ->joinWith(['cardCategory ccy'],false)
            ->joinWith(['cardCategoryType cct'],false)
            ->joinWith(['memberCard memberCard'],false)
            ->orderBy('gcl.update_time DESC')
            ->orderBy('gcl.is_bind DESC')
            ->where(['gift_card_activity_id'=>$this->id])
            ->asArray();
        $query = $this->getSearchWhere($query,'cardList');
        $dataProvider = Func::getDataProvider($query,8);
        return $dataProvider;
    }
}