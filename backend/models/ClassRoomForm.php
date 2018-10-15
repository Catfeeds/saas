<?php
namespace backend\models;

use common\models\base\Classroom;
use common\models\base\Organization;
use common\models\base\Employee;
use yii\base\Model;
use Yii;
class ClassRoomForm extends Model
{
    //添加教室
    public $roomName;   //教室名称
    public $areas;      //面积
    public $venueId;    //场馆id
    public $roomId;     //房间id

    //修改教室
    public $classroomId;  //教室id
    public $upRoomId;     //房间id
    public $upName;       //教室名称
    public $upSquare;     //面积

    public function rules()
    {
        return [
            [["roomName","areas","venueId","roomId"],"safe"],
            [["classroomId","upRoomId","upName","upSquare"],"safe"],
        ];
    }

    /**
     * 后台 - 场馆管理 - 新增教室场地
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/7/27
     * @return boolean     //返回添加数据成功与否结果
     */
    public function saveClassRoom()
    {
        $data = Classroom::findOne(['name' => $this->roomName,'venue_id' => $this->venueId]);
        if(!empty($data)){
            return '教室名称已存在';
        }
        $company = Organization::findOne(['id' => $this->venueId])->pid;
        $room = new Classroom();
        $room->name           = $this->roomName;
        $room->venue_id       = $this->venueId;
        $room->company_id     = $company;
        $room->classroom_area = $this->areas;
        $room->room_id        = $this->roomId;
        if($room->save()){
            return true;
        }else{
            return $room->errors;
        }
    }

    /**
     * 后台 - 座次管理 - 修改教室场地
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/06/06
     * @return boolean
     */
    public function updateClassRoom()
    {
        $data = Classroom::findOne(['id' => $this->classroomId]);
        $classroom = Classroom::find()
            ->where(['and',
                ['name' => $this->upName],
                ['venue_id' => $data->venue_id],
                ['!=','id',$this->classroomId]
            ])
            ->asArray()
            ->one();
        if(!empty($classroom)){
            return '教室名称已存在';
        }
        $data->name           = $this->upName;
        $data->classroom_area = $this->upSquare;
        $data->room_id        = $this->upRoomId;
        if($data->save()){
            return true;
        }else{
            return $data->errors;
        }
    }

    /**
     * @后台 - 场馆管理 - 新增房间
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/29
     * @return boolean
     */
    public function saveRoom($post)
    {
        $code = Organization::findOne(['code' => $post['code'],'style' => 4]);
        if(isset($code)){
            return '识别码已存在';
        }

        $venue   = Organization::findOne(['id' => $post['venueId']]);
        $creater = Employee::findOne(['admin_user_id' => \Yii::$app->user->identity->id])->id;
        $room    = new Organization();
        $room->pid             = $post['venueId'];
        $room->name            = (string)$post['name'];
        $room->style           = 4;    //房间
        $room->created_at      = time();
        $room->create_id       = $creater;
        $room->path            = json_encode("0,"."$venue->pid,"."$venue->id");
        $room->code            = (string)$post['code'];    //sn识别码
        $room->is_allowed_join = 1;
        $room->status          = 1;
        $room->identity        = $venue->identity;
        $room->venue_type      = $venue->venue_type;
        if($room->save() === true){
            return true;
        }else{
            return $room->errors;
        }
    }

    /**
     * @后台 - 场馆管理 - 删除房间
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/29
     */
    public function delRoom($roomId)
    {
        $room = Organization::findOne(['id' => $roomId]);
        if(empty($room)){
            return '房间不存在';
        }else{
            $room->delete();
            return true;
        }
    }
}