<?php

namespace backend\models;

use common\models\relations\LeaveRecordRelations;
use common\models\Func;
use common\models\base\ConsumptionHistory;

class LeaveRecord extends \common\models\LeaveRecord
{
    use LeaveRecordRelations;

    public $sorts;
    public $memberCardId;
    public $leavePropertyId;
    public $name;
    public $venueId;
    public $leaveType;
    public $leaveStartTime;   // 请假开始时间
    public $leaveEndTime;     // 请假结束时间

    const MEMBER_CARD_ID = 'memberCardId';
    const LEAVE_PROPERTY = 'leavePropertyId';
    const NAME = 'name';
    const LEAVE_TYPE = "leaveType";  // 请假类型

    const LEAVE_START_TIME = "leaveStartTime";
    const LEAVE_END_TIME = "leaveEndTime";

    /**
     *后台会员管理 - 会员详细信息 -  请假信息查询
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/19
     * @return bool|string
     */
    public function leaveRecordData($id)
    {
        $model = LeaveRecord::find()
            ->alias('lr')
            ->joinWith(['employee employee'], false)
            ->joinWith(['memberCard mc'], false)
            ->where(['leave_employee_id' => $id])
            ->orderBy(['lr.id' => SORT_DESC])
            ->select("lr.*,employee.name as employeeName,mc.card_name")
            ->asArray();
        $dataProvider = Func::getDataProvider($model, 8);

        return $dataProvider;
    }

    /**
     *后台- 验卡（请假） -  消除会员请假记录
     * @author 侯凯新 <huanghua@itsports.club>
     * @param $id
     * @create 2017/5/16
     * @return bool|string
     */
    public function removeLeaveRecord($id)
    {
        $model = LeaveRecord::findOne(["id" => $id]);
        $time = time();
        $terminate = $model['leave_start_time'] + 86400;
        if ($time < $terminate) {
            return 'no';
        }
        $transaction = \Yii::$app->db->beginTransaction();                //开启事务
        try {
            $model->status = 2;
            $model->terminate_time = time();
            $memberCardResult = $this->updateCardInvalidTime($model->member_card_id, $model->leave_start_time, $model->leave_end_time, $model->leave_employee_id);
            $result = $model->save();
            if (!$memberCardResult || !$result) {
                \Yii::trace("会员卡表或请假表数据录入失败");
                throw new \Exception("会员卡表或请假表数据录入失败");
            }
            if ($transaction->commit() == null) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return $error = $e->getMessage();  //获取抛出的错误
        }
    }

    /**
     *后台- 验卡（请假） -  根据请假延长会员卡 失效时间
     * @author 侯凯新 <huanghua@itsports.club>
     * @param $memberCardId
     * @param $leaveStartTime
     * @param $leaveEndTime
     * @create 2017/5/16
     * @return bool    //数据录入的 结果
     */
    public function updateCardInvalidTime($memberCardId, $leaveStartTime, $leaveEndTime, $memberId)
    {
        $consumption = ConsumptionHistory::find()->where(['and', ['member_id' => $memberId], ['category' => '续费']])
            ->orderBy('id desc')
            ->asArray()
            ->one();
        //同时修改卡的失效时间
        if (isset($memberCardId) && !empty($memberCardId)) {
            $memberCard = MemberCard::findOne(["id" => $memberCardId]);
            if (time() < $leaveEndTime && time() > $leaveStartTime) {
                $timeExpand = time() - $leaveStartTime;
            } elseif (time() >= $leaveEndTime) {
                $timeExpand = $leaveEndTime - $leaveStartTime;  //延期假期
            } else {
                $timeExpand = 0;      // 其它情况为0

            }
            $expandTime = (int)$memberCard->invalid_time + $timeExpand;
            $memberCard->invalid_time = $expandTime;
            if ($memberCard->invalid_time > time() && $memberCard->status == 6) {
                $memberCard->status = 1;
            }
            if (!$memberCard->save()) {
                return false;
            } else {
                if (!empty($consumption['consumption_type_id']) && $consumption['consumption_type_id'] != $memberCardId) {
                    $memberCardRenewal = MemberCard::findOne(["id" => $consumption['consumption_type_id']]);
                    $createAt = (int)$memberCardRenewal->create_at + $timeExpand;
                    $activeTime = (int)$memberCardRenewal->active_time + $timeExpand;
                    $invalidTime = (int)$memberCardRenewal->invalid_time + $timeExpand;
                    $memberCardRenewal->create_at = $createAt;
                    $memberCardRenewal->active_time = $activeTime;
                    $memberCardRenewal->invalid_time = $invalidTime;
                    if (!$memberCardRenewal->save()) {
                        return false;
                    } else {
                        return true;
                    }
                } else {
                    return true;
                }
            }
        }
    }

    /**
     * @describe 后台请假管理 - 会员请假信息查询 - 多表查询
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-08-01
     * @param $params
     * @return \yii\data\ActiveDataProvider
     */
    public function SpecialLeave($params)
    {
        $this->customLoad($params);
        $query = LeaveRecord::find()
            ->alias('lr')
            ->joinWith(['memberCard memberCard'], false)
            ->joinWith(['employee employee'], false)
            ->joinWith(['member member' => function ($query) {
                $query->joinWith(['memberDetails memberDetails'], false);
            }], false)
            ->select(
                "    lr.id,
                     lr.leave_employee_id,
                     member.id as memberId,
                     member.mobile,
                     lr.is_approval_id,
                     employee.id as employeeId,
                     employee.name,
                     lr.note,
                     lr.leave_start_time,
                     lr.leave_end_time,
                     lr.member_card_id,
                     memberCard.id as memberCardId,
                     memberCard.card_name,
                     memberCard.card_category_id,
                     lr.leave_type,
                     lr.leave_property,
                     memberDetails.name as DetailsName,
                     memberDetails.sex,
                     lr.reject_note,
                     lr.leave_length as leaveDay,     
                     lr.type,
                     lr.source,
                      "
            )
            ->groupBy(["lr.id"])
            ->orderBy($this->sorts)
            ->asArray();
        $query = $this->getSearchWhere($query);

        return $dataProvider = Func::getDataProvider($query, 8);

    }

    /**
     * 请假管理 - 特殊请假列表 - 搜索数据处理数据
     * @create 2017/8/24
     * @author huanghua<huanghua@itsports.club>
     * @param $data
     * @return bool
     */
    public function customLoad($data)
    {
        $this->venueId = (isset($data['venueId']) && !empty($data['venueId'])) ? $data['venueId'] : \backend\rbac\Config::accessVenues();
        $this->memberCardId = (isset($data[self::MEMBER_CARD_ID]) && !empty($data[self::MEMBER_CARD_ID])) ? (int)($data[self::MEMBER_CARD_ID]) : null;
        $this->leavePropertyId = (isset($data[self::LEAVE_PROPERTY]) && !empty($data[self::LEAVE_PROPERTY])) ? (int)($data[self::LEAVE_PROPERTY]) : null;
        $this->name = (isset($data[self::NAME]) && !empty($data[self::NAME])) ? ($data[self::NAME]) : null;
        $this->leaveType = (isset($data[self::LEAVE_TYPE])) && !empty($data[self::LEAVE_TYPE]) ? ($data[self::LEAVE_TYPE]) : null;
        $this->leaveStartTime = (isset($data[self::LEAVE_START_TIME])) && !empty($data[self::LEAVE_START_TIME]) ? (strtotime($data[self::LEAVE_START_TIME])) : null;
        $this->leaveEndTime = (isset($data[self::LEAVE_END_TIME])) && !empty($data[self::LEAVE_END_TIME]) ? (strtotime($data[self::LEAVE_END_TIME])) : null;
        $this->sorts = self::loadSort($data);

        return true;
    }

    /**
     * 请假管理 - 特殊请假 - 增加搜索条件
     * @create 2017/8/24
     * @author huanghua<huanghua@itsports.club>
     * @param $query
     * @return mixed
     */
    public function getSearchWhere($query)
    {
        $query->andFilterWhere([
            'and',
            ['like', 'memberDetails.name', $this->name]
        ]);

        $query->andFilterWhere([
            'and',
            [
                'memberCard.card_category_id' => $this->memberCardId,
            ],
        ]);
        $query->andFilterWhere([
            'and',
            [
                'lr.type' => $this->leavePropertyId,
            ],
        ]);
        $query->andFilterWhere([
            'and',
            [
                'member.venue_id' => $this->venueId,
            ],
        ]);
        if (!empty($this->leaveType)) {
            $query = $query->andWhere(["lr.leave_property" => $this->leaveType]);
        }
        if (!empty($this->leaveStartTime) && !empty($this->leaveEndTime)) {
            $query = $query->andWhere(["between", "lr.leave_start_time", $this->leaveStartTime, $this->leaveEndTime]);
        }
        return $query;
    }

    /**
     * 请假管理 - 特殊请假列表 - 获取排序条件
     * @create 2017/8/25
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
        switch ($data['sortType']) {
            case 'member_name'          :
                $attr = '`memberDetails`.name';
                break;
            case 'member_sex'           :
                $attr = '`memberDetails`.sex';
                break;
            case 'member_mobile'        :
                $attr = '`member`.mobile';
                break;
            case 'member_applicant'   :
                $attr = '`employee`.name';
                break;
            case 'member_leaveTime'   :
                $attr = '`lr`.leave_start_time';
                break;
            case 'member_kind_card'   :
                $attr = '`memberCard`.card_name';
                break;
            case 'member_note'   :
                $attr = '`lr`.note';
                break;
            case 'member_state'   :
                $attr = '`lr`.leave_property';
                break;
            case 'source'   :
                $attr = '`lr`.source';
                break;
            default;
                return $sorts;
        }
        return $sorts = [$attr => self::convertSortValue($data['sortName'])];

    }

    /**
     * 请假管理 - 特殊请假列表 - 获取搜索规格
     * @create 2017/8/24
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
        }else{
            return SORT_ASC;
        }
    }

    /**
     * 后台请假管理 - 请假列表查询 - 是否批准状态修改
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/25
     * @param $id
     * @return bool
     */
    public static function getUpdateLeaveRecord($id)
    {
        $leave = \common\models\base\LeaveRecord::findOne($id);
        if ($leave->type == 1) {
            $leave->type = 2;
            $leave->status = 1;
        }
        if ($leave->save()) {
            return true;
        } else {
            return $leave->errors;
        }
    }

    /**
     *请假管理 - 特殊请假列表 - 批量审核
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/11
     * @return bool|string
     */
    public static function batchUpdateStatus($idArr)
    {
        $data = \common\models\base\LeaveRecord::updateAll(['type' => 2, 'status' => 1], ['type' => 1, 'id' => $idArr]);
        if ($data) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 后台 - 会员特殊请假 - 撤销
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/25
     * @param $id
     * @return bool
     */
    public function getLeaveDel($id)
    {
        $member = LeaveRecord::findOne($id);
        $leaveDel = $member->delete();
        if ($leaveDel) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 后台请假管理 - 会员请假以拒绝信息查询 - 数据查询
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/24
     * @param $id
     * @return \yii\db\ActiveQuery
     */
    public function getLeaveModel($id)
    {

        return $model = LeaveRecord::find()->alias('lr')->select('lr.id,lr.reject_note')->where(['lr.id' => $id])->asArray()->one();

    }

    /**
     * 会员管理 - 正式会员 - 会员详情请假列表自动激活请假
     * @author Huang hua <huanghua@itsports.club>
     * @create 2018/3/26
     * @param $id
     * @return bool|string
     */
    public function updateRecord($id)
    {
        $leaveRecord = LeaveRecord::find()->where(['and', ['leave_employee_id' => $id], ['status' => 4]])->orderBy('id desc')->asArray()->one();
        $updateLeave = \common\models\base\LeaveRecord::findOne(['id' => $leaveRecord['id']]);
        if (!empty($updateLeave)) {
            $time = time();
            if ($updateLeave['leave_start_time'] <= $time) {
                $updateLeave->status = 1;
                if ($updateLeave->save()) {
                    return true;
                } else {
                    return $updateLeave->errors;
                }
            } else {
                return "当前时间还没到请假开始时间,目前是已登记状态!";
            }
        } else {
            return true;
        }
    }

    /**
     * 会员管理 - 正式会员 - 登录账号后自动激活请假
     * @author ZhangDongXu <zhangdongxu@itsports.club>
     * @create 2018/7/9
     * @return bool|string
     */
    public function updateAllRecord()
    {
        $memberId = Member::find()
            ->alias('mm')
            ->joinWith(['leaveRecord leaveRecord'])
            ->where(['and', ['mm.member_type' => 1], ['leaveRecord.status' => 4]])
            ->select("mm.id")
            ->asArray()
            ->all();
        foreach ($memberId as $k => $v) {
            $leaveRecord = LeaveRecord::find()->where(['leave_employee_id' => $v['id']])->orderBy('id desc')->asArray()->one();
            $updateLeave = \common\models\base\LeaveRecord::findOne(['id' => $leaveRecord['id']]);
            if (!empty($updateLeave)) {
                $time = time();
                if ($updateLeave['leave_start_time'] <= $time) {
                    $updateLeave->status = 1;
                    if ($updateLeave->save() != true) {
                        return $updateLeave->errors;
                    }
                }
            }
        }
        return true;
    }

}