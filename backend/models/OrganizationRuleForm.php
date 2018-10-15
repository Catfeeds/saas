<?php
namespace backend\models;
use common\models\base\Classroom;
use Yii;
use yii\base\Model;
use common\models\base\Organization;
use common\models\base\Seat;

class OrganizationRuleForm extends Model
{
    //组织架构管理  - 新增场馆
    public  $pid;
    public  $venueAddress;
    public  $venueArea;
    public  $venueDescribe;       //公司或场馆描述
    public  $name;           //公司或场馆名字
    public  $venuePhone;
    public  $pic;            //公司或场馆图片
    public  $establishTime;  // 场馆创立时间
    public  $identity;       // 场馆属性
    public  $venueType;      // 场馆类型
    //组织架构管理 - 场馆修改
    public  $venueId;       //场馆id
    //组织架构管理 - 公司修改
    public  $companyId;    //公司id
    //场地    -增加场地
    public $classroom_area;  //教室面积
    public $total_seat;      //教室座位数

    public $longitude;  //新增场馆精度
    public $latitude;      //新增场馆纬度
    //修改场地信息（教室表）
    public $classroomId;

    //增加部门信息
    public $code;
    public $DepartmentId;
    //修改场馆
    public $phone;
    public $address;
    public $area;
    public $describe;
    //常量定义
    const ADD_VENUE         = "addVenue";
    const DESCRIBE          = "venueDescribe";
    const ADD_COMPANY       = "addCompany";
    const UPDATE_COMPANY    = "updateCompany";
    const UPDATE_VENUE      = "updateVenue";
    const ADD_CLASSROOM     = "addClassroom";
    const UPDATE_CLASSROOM  = "updateClassroom";
    const ADD_DEPART_DATA   = "addDepartData";
    const UPDATE_DEP        = "updateDep";

    const MY_ERROR          = "操作失败";
    const MY_SEAT_ERROR     = "座位表删除失败";
    /**
     * @云运动 - 后台 - 场景多表单定义
     * @create 2017/4/24
     * @return array
     */
    public function  scenarios(){
        return [
            self::ADD_VENUE         =>["pid","name","venueAddress","venueArea",self::DESCRIBE,"venuePhone","pic","establishTime","longitude","latitude",'identity',"venueType"],
            self::ADD_COMPANY       =>["pid","name"],
            self::UPDATE_COMPANY    =>["name","companyId"],
            self::UPDATE_VENUE      =>["name","pid","venueId","identity",'area','address','phone','pic','describe',"longitude","latitude","venueType"],
            self::ADD_CLASSROOM     =>["name","classroom_area","companyId",self::DESCRIBE,"total_seat","venueId","pic"],
            self::UPDATE_CLASSROOM  =>["name","classroom_area","companyId",self::DESCRIBE,"total_seat","venueId","pic","classroomId"],
            self::ADD_DEPART_DATA   =>["name","venueId","companyId","code"],
            self::UPDATE_DEP        =>["code","DepartmentId","name"]
        ];
    }
    /**
     * @云运动 - 后台 - 新增场馆部门验证规则(规则验证)
     * @create 2017/4/24
     * @return array
     */
    public function rules()
    {
        return [
            [["pid",'name',"companyId","venueId","classroomId","code","DepartmentId","venueType"], 'required',
            'on'=>[self::ADD_VENUE,self::ADD_COMPANY,self::UPDATE_COMPANY,self::UPDATE_VENUE,self::ADD_CLASSROOM,self::UPDATE_CLASSROOM,
            self::ADD_DEPART_DATA,self::UPDATE_DEP]],
            [["venueAddress","venueArea",self::ADD_VENUE,"venuePhone","identity","pic","total_seat","classroom_area","establishTime"],"safe",
            'on'=>[self::ADD_VENUE,self::ADD_COMPANY,self::ADD_CLASSROOM,self::UPDATE_CLASSROOM]],
            [["pic","address","area","phone","establishTime","identity","longitude","latitude"],"safe", 'on'=>[self::UPDATE_VENUE]],
        ];
    }
    /**
     * 云运动 - 后台- 新增场馆部门信息录入
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/4/24
     * @param
     * @return boolean/object
     */
    public function addMyData(){
        // 场馆信息保存
        $model                =  new Organization();
        $model->created_at   =  time();
        $model->update_at    =  time();
        $model->style        = 2;
        $model->pid          =  $this->pid;
        $model->name         =  $this->name;
        $model->area         =  $this->venueArea;
        $model->address      =  $this->venueAddress;
        $model->describe     =  $this->venueDescribe;
        $model->phone        =  $this->venuePhone;
        $model->create_id    =  Yii::$app->user->identity->id;
        $model->pic          =  $this->pic;
        $model->longitude    =  $this->longitude;
        $model->latitude     =  $this->latitude;
        $model->identity     =  $this->identity;
        $model->venue_type   =  $this->venueType;
        if(!empty($this->establishTime)){
            $model->establish_time = strtotime($this->establishTime);
        }
        $model->is_allowed_join    =  1;
        $model->path         =  json_encode("0,".$this->pid);
        if($model->save()){
            return true;
        }else{
            return $model->errors;
        }
    }

    /**
     * 云运动 - 后台- 新增公司数据录入
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/4/24
     * @param
     * @return boolean/object
     */
    public function addMyCompanyData(){
        // 场馆信息保存
        $model                     =  new Organization();
        $model->create_id         =  Yii::$app->user->identity->id;
        $model->created_at        =  time();
        $model->update_at         =  time();
        $model->path               =  json_encode("0");
        $model->name               =  $this->name;
        $model->pid                =  $this->pid;
        $model->style              = 1;
        if($model->save()){
            return true;
        }else{
            return $model->errors;
        }
    }
    /**
     * 云运动 - 后台- 公司 （修改公司表单）
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/4/26
     * @param
     * @return boolean/object
     */
    public function updateCompany(){
        $model        = Organization::findOne($this->companyId);
        $model->name  =$this->name;
        if($model->save()){
            return true;
        }else{
            return $model->errors;
        }
    }
    /**
     * 云运动 - 后台- 公司 （修改场馆表单）
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/4/26
     * @param
     * @return boolean/object    //返回修改后的结果
     */
    public function updateVenue(){
        $model             = Organization::findOne($this->venueId);
        $model->name       = $this->name;
        $model->pid        = $this->pid;
        $model->address    = $this->address;
        $model->area       = $this->area;
        $model->phone      = $this->phone;
        $model->pic        = $this->pic;
        $model->describe   =  $this->describe;
        $model->update_at  = time();
        $model->longitude  = $this->longitude;
        $model->latitude   = $this->latitude;
        // 场馆属性
        if(!empty($this->identity)){
            $model->identity   =  $this->identity;
        }
        // 场馆类别
        if(!empty($this->venueType)){
            $model->venue_type = $this->venueType;
        }
        if($model->save()){
            return true;
        }else{
            return $model->errors;
        }
    }
    /**
     * 云运动 - 后台- 场地修改（修改场馆数据）
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/4/27
     * @param
     * @return boolean/object    //返回修改后的结果
     */
    public function addClassroom(){
          $transaction                  =  \Yii::$app->db->beginTransaction();                //开启事务
        try {
            $model = new Classroom();
            $model->name               = $this->name;             //教室名字
            $model->venue_id           = $this->venueId;         //教室对应场馆id
            $model->company_id         = $this->companyId;       //公司id
            $model->total_seat         = $this->total_seat;      //场地容纳人数
            $model->classroom_describe = $this->venueDescribe;        //教室描述
            $model->classroom_area     = $this->classroom_area;   //教室面积
            $model->classroom_pic      = $this->pic;              //教室图片
            $model                      =  $model->save()?$model:$model->errors;
            if(!isset($model->id)){
                \Yii::trace($model->errors);
                throw new \Exception(self::MY_ERROR);
            }else{
                for($i=1;$i<=$this->total_seat;$i++){
                    $seat = new Seat();
                    $seat->classroom_id = $model->id;
                    $seat->seat_type    = 1;
                    $seat->seat_number  = (string)$i;
                    if(!$seat->save()){
                        \Yii::trace($seat->errors);
                        throw new \Exception(self::MY_ERROR);
                        break;
                    }
                }
            }
            if($transaction->commit())
            {
                return true;
            }else{
                return $seat->errors;
            }

           }catch(\Exception $e){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return  $error = $e->getMessage();  //获取抛出的错误
        }
    }
    /**
     * 云运动 - 后台- 公司 （修改场地表单）
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/4/27
     * @return boolean/object    //返回修改后的结果
     */
    public function  updateClassroom(){
        $transaction = \Yii::$app->db->beginTransaction();                //开启事务
        try {
            //查寻场馆座位数是否有变化
            $number = Seat::find()->where(["classroom_id" => $this->classroomId])->count();
            if($number  != $this->total_seat){
                //不等于0的情况下先执行删除
                if($number!=0){
                    $model = Seat::deleteAll(["classroom_id" => $this->classroomId]);
                    if (!$model) {
                        \Yii::trace(self::MY_SEAT_ERROR);
                        throw new \Exception(self::MY_SEAT_ERROR);
                    }
                }
                for ($i = 1; $i <= $this->total_seat; $i++) {
                    $seat = new Seat();
                    $seat->classroom_id = $this->classroomId;
                    $seat->seat_type = 1;
                    $seat->seat_number = (string)$i;
                    if (!$seat->save()) {
                        \Yii::trace($seat->errors);
                        throw new \Exception(self::MY_ERROR);
                        break;
                    }
                }
            }
            //同时执行教室表赋值
            $classroom =Classroom::findOne($this->classroomId);
            $classroom->name                 = $this->name;
            $classroom->venue_id             = $this->venueId;
            $classroom->classroom_area      = $this->classroom_area;
            $classroom->classroom_describe  = $this->venueDescribe;
            $classroom->total_seat           = $this->total_seat;
            $classroom->classroom_pic        = $this->pic;
            if(!$classroom->save()){
                \Yii::trace($classroom->errors);
                throw new \Exception($classroom->errors);
            }
            //执行数据递交
            if($transaction->commit()==null)
            {
                return true;
            }else{
                return "数据回滚错误" ;
            }
        }catch(\Exception $e){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return  $error = $e->getMessage();  //获取抛出的错误
        }
    }
    /**
     * 云运动 - 后台- 部门添加
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/4/28
     * @return boolean/object    //返回修改后的结果
     */
   public function  addDepartData(){
          $model                = new Organization();
          $model ->name         = $this->name;
          $model -> pid         = $this->venueId;
          $model -> style       = 3;
          $model -> create_id   =Yii::$app->user->identity->id;
          $model ->	code        =$this->code;
          $model->created_at   = time();
          $model->update_at    = time();
          //先查询上级path
          $path = Organization::find()->where(["id"=>$this->venueId])->asArray()->one();
          $path = json_decode($path["path"]).",".$this->venueId;
          $model->path  =json_encode($path);
          if($model->save()){
              return true;
          }else{
              return $model->errors;
          }
   }
    /**
     * 云运动 - 后台- 组织架构管理 - 部门修改
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/4/28
     * @return boolean/object  //返回修改后的结果
     */
   public  function updateDep(){
         $model =Organization::findOne(["id"=>$this->DepartmentId]);
         $model->name = $this->name;
         $model->code = $this->code;
         if($model->save()){
            return true;
         }else{
            return $model->errors;
         }
   }





    
    
    
    
}