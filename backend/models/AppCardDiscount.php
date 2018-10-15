<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/13 0013
 * Time: 上午 9:19
 */

namespace backend\models;

use common\models\base\Approval;
use common\models\base\ApprovalDetails;
use common\models\base\CardCategory;
use common\models\Func;
use common\models\relations\AppCardDiscountRelations;
use Yii;

class AppCardDiscount extends \common\models\base\AppCardDiscount
{
    use AppCardDiscountRelations;
    public $venueId;
    public $status;
    public $keywords;
    const VENUE_ID = 'venueId';
    const STATUS = 'status';
    const KEYWORDS = 'keywords';

    /**
     * 后台 - 手机折扣 - 获取移动端卡种折扣列表
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/13
     * @return bool|string
     */
    public function appDiscountList($params)
    {
        $this->dataLoad($params);
        $query = AppCardDiscount::find()
            ->alias('acd')
            ->joinWith(['organization org'], false)
            ->select('acd.*,org.name')
            ->orderBy('acd.create_at DESC')
            ->asArray();
        $query = $this->searchWhere($query);

        return Func::getDataProvider($query, 8);
    }

    /**
     * 后台 - 手机折扣 - 获取移动端卡种折扣列表 - 搜索数据处理数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/13
     * @return bool|string
     */
    public function dataLoad($data)
    {
        $this->venueId = (isset($data[self::VENUE_ID]) && !empty($data[self::VENUE_ID])) ? $data[self::VENUE_ID] : \backend\rbac\Config::accessVenues();
        $this->status = (isset($data[self::STATUS]) && !empty($data[self::STATUS])) ? $data[self::STATUS] : null;
        $this->keywords = (isset($data[self::KEYWORDS]) && !empty($data[self::KEYWORDS])) ? $data[self::KEYWORDS] : null;

        return true;
    }

    /**
     * 后台 - 手机折扣 - 获取移动端卡种折扣列表 - 增加搜索条件
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/13
     * @return bool|string
     */
    public function searchWhere($query)
    {
        $query->andFilterWhere(['acd.venue_id' => $this->venueId]);
        $query->andFilterWhere(['acd.status' => $this->status]);
        $query->andFilterWhere(['like', 'org.name', $this->keywords]);
        return $query;
    }

    /**
     * 后台 - 手机折扣 - 删除移动端卡种折扣
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/13
     * @return bool|string
     */
    public function delAppDiscount($discountId)
    {
        $discount = AppCardDiscount::findOne(['id' => $discountId]);
        if (isset($discount) && !empty($discount)) {
            $discount->delete();
            $approval = Approval::findOne(['polymorphic_id' => $discountId]);
            $details = ApprovalDetails::findAll(['approval_id' => $approval['id']]);
            if (isset($details) && !empty($details)) {
                ApprovalDetails::deleteAll(['approval_id' => $approval['id']]);
            }
            if (isset($approval) && !empty($approval)) {
                $approval->delete();
            }
            return true;
        }
        return false;
    }

    /**
     * 后台 - 手机折扣 - 移动端卡种折扣详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/13
     * @return bool|string
     */
    public function appDiscountDetails($discountId)
    {
        $discount = AppCardDiscount::find()
            ->alias('acd')
            ->where(['acd.id' => $discountId])
            ->joinWith(['organization org'], false)
            ->select('acd.*,org.name as venueName')
            ->asArray()->one();
        $no_discount = json_decode($discount['no_discount_card'], true);
        $discount['card_id'] = $no_discount;
        $discount['no_discount_card'] = [];
        if (isset($no_discount) && !empty($no_discount)) {
            foreach ($no_discount as $key => $value) {
                $card = CardCategory::findOne(['id' => $value]);
                array_push($discount['no_discount_card'], $card['card_name']);
            }
        }
        return $discount;
    }

    /**
     * 后台 - 手机折扣 - 移动端卡种折扣冻结、解冻
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/13
     * @return bool|string
     */
    public function frozenAppDiscount($discountId)
    {
        $discount = \common\models\base\AppCardDiscount::findOne(['id' => $discountId]);
        if ($discount['frozen'] == 2) {
            $discount->frozen = 1;
        } else {
            $discount->frozen = 2;
        }
        if ($discount->save()) {
            return true;
        } else {
            return $discount->errors;
        }
    }
}