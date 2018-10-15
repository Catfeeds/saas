<?php
namespace backend\models;

use common\models\base\Seat;
use common\models\base\SeatType;
use yii\base\Model;
use Yii;
class SeatForm extends Model
{
    public $roomId;           //教室id
    public $name;             //座位排次名称
    public $rows;             //排
    public $columns;          //列
    public $rowsArr;          //数组 排
    public $columnsArr;       //数组 列
    public $numberArr;        //数组 座位号
    public $typeArr;          //座位类型
    public $dataArr = array();              //添加

    public $seatTypeId;         //座位排次id
    public $roomIdUp;           //教室id
    public $nameUp;             //座位排次名称
    public $rowsUp;             //排
    public $columnsUp;          //列
    public $rowsArrUp;          //数组 排
    public $columnsArrUp;       //数组 列
    public $numberArrUp;        //数组 座位号
    public $typeArrUp;          //座位类型
    public $dataArrUp = array();             //修改
    public $venueId;            //场馆
    public function rules()
    {
        return [
            [["roomId", "name","rows","columns","rowsArr",'venueId',"columnsArr","numberArr","typeArr"], "safe"],
            [["seatTypeId","roomIdUp", "nameUp","rowsUp",'venueId',"columnsUp","rowsArrUp","columnsArrUp","numberArrUp","typeArrUp"], "safe"],
        ];
    }

    /**
     * 后台 - 座位排次 - 保存座位表数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/7/28
     * @return object     //返回添加数据成功与否结果
     */
    public function saveSeat($companyId,$venueId)
    {
        $type = SeatType::findOne(['name' => $this->name,'venue_id' => $this->venueId]);
        if(isset($type)){
            return '座位排次名称已存在';
        }else{
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $seatType                = new SeatType();
                $seatType->name          = $this->name;
                $seatType->classroom_id  = $this->roomId;
                $seatType->total_rows    = $this->rows;
                $seatType->total_columns = $this->columns;
                $seatType->create_at     = time();
                $seatType->company_id    = $companyId;
                $seatType->venue_id      = $venueId;
                $seatType->status        = 1;       //使用中
                $seatType = $seatType->save() ? $seatType : $seatType->errors;
                if(!isset($seatType->id)){
                    throw new \Exception('操作失败');
                }

                $seat = $this->saveSeatData($seatType);
                if($seat !== true){
                    return $seat;
                }

                if ($transaction->commit() === null) {
                    return true;
                } else {
                    return false;
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                return  $e->getMessage();
            }
        }
    }

    /**
     * 后台 - 座位排次 - 处理座位数组数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/7/28
     * @return object     //返回添加数据成功与否结果
     */
    public function setArray()
    {
        $data   = [];
        $data[] = [$this->rowsArr,$this->columnsArr,$this->numberArr,$this->typeArr];
        $this->dataArr = $data;
    }

    /**
     * 后台 - 座位排次 - 保存座位表数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/7/28
     * @return object     //返回添加数据成功与否结果
     */
    public function saveSeatData($seatType)
    {
        $this->setArray();
        $rowsArr    = $this->dataArr[0][0];                       //排 数组
        $columnsArr = $this->dataArr[0][1];                       //列 数组
        $numberArr  = $this->dataArr[0][2];                       //座位号 数组
        $typeArr    = $this->dataArr[0][3];                       //座位类型 数组
        if (isset($rowsArr) && $rowsArr) {
            foreach ($rowsArr as $key => $value) {
                $seat = new Seat();
                $seat->classroom_id = $this->roomId;
                if (isset($typeArr[$key]) && isset($numberArr[$key]) && $typeArr[$key] && $numberArr[$key]) {
                    $seat->seat_type    = (int)$typeArr[$key];
                    $seat->seat_number  = (string)$numberArr[$key];
                } else {
                    $seat->seat_type    = (int)0;
                    $seat->seat_number  = (string)0;
                }
                $seat->rows         = (int)$value;
                $seat->columns      = (int)$columnsArr[$key];
                $seat->seat_type_id = $seatType->id;
                if (!$seat->save()) {
                    return $seat->errors;
                }
            }
            return true;
        }
        return true;
    }

    /**
     * 后台 - 座位排次 - 修改座位表数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/7/28
     * @return object     //返回添加数据成功与否结果
     */
    public function updateSeat($companyId,$venueId)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            /*$type = SeatType::findOne(['name' => $this->nameUp,'venue_id' => $this->venueId]);
            if(isset($type) && $this->seatTypeId != $type->id){
                return '座位排次名称已存在';
            }*/
            $seatTypeData            = SeatType::findOne(['id' => $this->seatTypeId]);
            $seatTypeData->status    = 2;
            $seatTypeData->update_at = time();
            if (!$seatTypeData->save()) {
                throw new \Exception('操作失败');
            }
            $seatType = new SeatType();
            $seatType->name          = $this->nameUp;
            $seatType->classroom_id  = $this->roomIdUp;
            $seatType->total_rows    = $this->rowsUp;
            $seatType->total_columns = $this->columnsUp;
            $seatType->create_at     = time();
            $seatType->update_at     = time();
            $seatType->company_id    = $companyId;
            $seatType->venue_id      = $this->venueId;
            $seatType->status        = 1;           //启用中
            $seatType = $seatType->save() ? $seatType : $seatType->errors;
            if(!isset($seatType->id)){
                throw new \Exception('操作失败');
            }
            $seat = $this->saveSeatUpdateNew($seatType);
            if($seat !== true){
                return $seat;
            }

            $this->updateGroupClassSeat($this->seatTypeId,$seatType->id);
            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            return  $e->getMessage();
        }
    }

    /**
     * 后台 - 座位排次 - 处理修改数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/7/28
     * @return object     //返回添加数据成功与否结果
     */
    public function setArrayUp()
    {
        $seat   = Seat::findAll(['seat_type_id' => $this->seatTypeId]);
        $seatId = array_column($seat,'id');
        $data   = [];
        $data[] = [$this->rowsArrUp,$this->columnsArrUp,$this->numberArrUp,$this->typeArrUp,$seatId];
        $this->dataArrUp = $data;
    }

    /**
     * 后台 - 座位排次 - 修改座位表数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/7/28
     * @return object     //返回添加数据成功与否结果
     */
    public function saveSeatUpdate()
    {
        $this->setArrayUp();
        $rowsArrUp    = $this->dataArrUp[0][0];                       //排 数组
        $columnsArrUp = $this->dataArrUp[0][1];                       //列 数组
        $numberArrUp  = $this->dataArrUp[0][2];                       //座位号 数组
        $typeArrUp    = $this->dataArrUp[0][3];                       //座位类型 数组
        $seatIdUp     = $this->dataArrUp[0][4];                       //座位id 数组
        if(count($rowsArrUp) >= count($seatIdUp)){
            foreach ($rowsArrUp as $key => $value) {
                if(empty($seatIdUp[$key]) && !empty($value)){
                    $seat                = new Seat();
                    $seat->classroom_id = $this->roomIdUp;
                    $seat->seat_type    = (int)$typeArrUp[$key] ? (int)$typeArrUp[$key] : 0;
                    $seat->seat_number  = (string)$numberArrUp[$key] ? (string)$numberArrUp[$key] : (string)0;
                    $seat->rows          = (int)$value;
                    $seat->columns       = (int)$columnsArrUp[$key];
                    $seat->seat_type_id = $this->seatTypeId;
                    if (!$seat->save()) {
                        return $seat->errors;
                    }
                }else{
                    $seat = Seat::findOne(['id' => $seatIdUp[$key]]);
                    $seat->classroom_id = $this->roomIdUp;
                    if(!empty($typeArrUp[$key])){
                        $seat->seat_type = (int)$typeArrUp[$key] ? (int)$typeArrUp[$key] : 0;
                    }
                    if(!empty($numberArrUp[$key])){
                        $seat->seat_number = (string)$numberArrUp[$key] ? (string)$numberArrUp[$key] : (string)0;
                    }else{
                        $seat->seat_number = null;
                        $seat->seat_type   = null;
                    }
                    $seat->rows          = (int)$value;
                    $seat->columns       = (int)$columnsArrUp[$key];
                    if (!$seat->save()) {
                        return $seat->errors;
                    }
                }
            }
        }else{
            foreach ($seatIdUp as $key => $value) {
                if(empty($rowsArrUp[$key]) && !empty($value)){
                    $seatUp = Seat::findOne(['id' => $value]);
                    $seatUp->delete();
                }else{
                    $seat = Seat::findOne(['id' => $value]);
                    $seat->classroom_id = $this->roomIdUp;
                    if(!empty($typeArrUp[$key])){
                        $seat->seat_type = (int)$typeArrUp[$key];
                    }
                    if(!empty($numberArrUp[$key])){
                        $seat->seat_number = (string)$numberArrUp[$key];
                    }
                    $seat->rows          = (int)$rowsArrUp[$key];
                    $seat->columns       = (int)$columnsArrUp[$key];
                    if (!$seat->save()) {
                        return $seat->errors;
                    }
                }
            }
        }
        return true;
    }

    /**
     * @desc: 业务后台 - 修改座位 - 组装数据
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/06/04
     */
    public function setArrayUpNew()
    {
        //组装数组(重新生成数据),不需要seat表的id
        $data   = [];
        $data[] = [$this->rowsArrUp,$this->columnsArrUp,$this->numberArrUp,$this->typeArrUp];
        $this->dataArrUp = $data;
    }

    /**
     * @desc: 业务后台 - 修改座位 - 生成新的版本的座位
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/06/04
     * @return array|bool
     */
    public function saveSeatUpdateNew($seatType)
    {
        //.根据seat_type_id重新生成新的座位
        $this->setArrayUpNew();
        $rowsArrUp    = $this->dataArrUp[0][0];                       //排 数组
        $columnsArrUp = $this->dataArrUp[0][1];                       //列 数组
        $numberArrUp  = $this->dataArrUp[0][2];                       //座位号 数组
        $typeArrUp    = $this->dataArrUp[0][3];                       //座位类型 数组
        if (isset($rowsArrUp) && $rowsArrUp) {
            foreach ($rowsArrUp as $k=>$value) {
                $seat = new Seat();
                $seat->classroom_id = $this->roomIdUp;
                if (isset($typeArrUp[$k]) && isset($numberArrUp[$k]) && $typeArrUp[$k] && $numberArrUp[$k]) {
                    $seat->seat_type    = (int)$typeArrUp[$k] ?: 0;
                    $seat->seat_number  = (string)$numberArrUp[$k] ?: (string)0;
                } else {
                    $seat->seat_type    = (int)0;
                    $seat->seat_number  = (string)0;
                }
                $seat->rows         = (int)$value;
                $seat->columns      = (int)$columnsArrUp[$k];
                $seat->seat_type_id = (int)$seatType->id;
                if (!$seat->save()) {
                    return $seat->errors;
                }
            }
            return true;
        }
        return true;
    }

    /**
     * @desc: 业务后台 - 修改座次 - 排过团课没有人预约的课程修改座次
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/06/19
     * @param $oldId
     * @param $newId
     * @return bool
     */
    public function updateGroupClassSeat($oldId,$newId)
    {
        //查找修改座次之前的团课
        $group = GroupClass::find()->where(['and',['seat_type_id'=>$oldId],['>','start',time()]])->column();
        if ($group) {
            foreach ($group as $value) {
                $count = AboutClass::find()->where(['class_id'=>$value])->andWhere(['and',['type'=>2],['<>','status',2]])->count();
                if (!$count) {
                    GroupClass::updateAll(['seat_type_id'=>$newId],['id'=>$value]);
                }
            }
        }
        return true;
    }
}