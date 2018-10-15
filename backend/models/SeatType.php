<?php
namespace backend\models;
use common\models\relations\SeatTypeRelations;

class SeatType extends \common\models\SeatType
{
    use SeatTypeRelations;

    /**
     * @desc: 业务后台 - 座次管理 - 获取所有座位排次
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/06/05
     * @param $venueId
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getSeatData($venueId)
    {
        //获取座次数据
        $seat = SeatType::find()
            ->alias('seatType')
            ->joinWith(["classroom room"],false)
            ->joinWith(['seat seat' => function($query) {
                $query->andWhere(['>','CAST(seat.seat_number as SIGNED)',0]);
            }], false)
            ->andWhere(['room.venue_id' => $venueId,'seatType.status'=>1])
            ->select("
                seatType.id,
                COUNT(seat.id) amount,
                seat.seat_type_id,
                seatType.name,
                seatType.classroom_id,
                seatType.total_rows,
                seatType.total_columns,
                room.name as roomName,
                ")
            ->groupBy('seatType.id')
            ->asArray()
            ->all();

        return $seat;
    }

    /**
     * @desc: 业务后台 - 座次管理 - 获取座位排次详情
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/06/05
     * @param $seatTypeId
     * @return array|null|\yii\db\ActiveRecord
     */
    public function seatDetails($seatTypeId)
    {
        $seat = SeatType::find()
            ->alias('seatType')
            ->joinWith(['classroom room'])
            ->joinWith(['seat seat'])
            ->where(['seatType.id' => $seatTypeId])
            ->asArray()
            ->one();
        return $seat;
    }

    /**
     * 后台 - 团课排课 - 获取某一教室下的座位排次
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/9
     * @return array
     */
    public function getSeatType($roomId)
    {
        $seatType = SeatType::find()->where(['classroom_id' => $roomId, 'status' => 1])->asArray()->all();
        return $seatType;
    }
}