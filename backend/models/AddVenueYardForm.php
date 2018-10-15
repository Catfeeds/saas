<?php
namespace backend\models;
use common\models\base\AboutYard;
use common\models\base\VenueYard;
use common\models\base\VenueYardCardcategory;
use yii\base\Model;
class AddVenueYardForm  extends Model
{
       const  ADD_VENUE_YARD    = "addVenueYard";  // 新增场馆场地
       const  UPDATE_VENUE_YARD = "updateVenueYard";  // 新增场馆场地
       const  MEMBER_YARD_ABOUT = "memberYardAbout";  // 会员场地预约
       public  $id;             // 场地id
       public  $venueId;        // 场馆id
       public  $yardName;       //场地名称
       public  $peopleLimit;    // 人数限制
       public  $businessTime;   //场地经营时间
       public  $everyTimeLong;  // 每次活动时长
       public  $cardCategoryId; // 卡种id
       public  $roomId;         // 房间id

      // 会员场地预约
       public $memberCardId;  // 会员卡id
       public $memberId;      // 会员id
       public $yardId;       // 场地id
       public $aboutIntervalSection;  // 预约区间段
       public $aboutDate;    // 预约日期
    /**
     * @云运动 - 后台 - 场景
     * @create  2017/09/06
     * @return  array
     */
       public function  scenarios(){
            return [
                self::ADD_VENUE_YARD         =>["venueId","yardName","peopleLimit","businessTime","everyTimeLong","cardCategoryId","roomId"],
                self::UPDATE_VENUE_YARD      =>["id","peopleLimit","businessTime","everyTimeLong","cardCategoryId","roomId"],
                self::MEMBER_YARD_ABOUT      =>["memberCardId","memberId","yardId","aboutIntervalSection","aboutDate"]
            ];
       }
    /**
     * @云运动 - 后台 - 新增场馆场地(规则验证)
     * @create 2017/9/6
     * @return array
     */
    public function rules()
    {
        return [
            [["id","venueId","yardName","peopleLimit","businessTime","everyTimeLong","cardCategoryId","roomId","memberCardId",
            "memberId","yardId","aboutIntervalSection","aboutDate"], 'safe',
              'on'=>[self::ADD_VENUE_YARD,self::UPDATE_VENUE_YARD,self::MEMBER_YARD_ABOUT]],
        ];
    }
    /**
     *  场地预约 - 新增卡种
     * @create 2017/9/6
     * @author houkaixin<houkaixin@itsports.club>
     * @return array|\yii\db\ActiveRecord[]   //符合条件的卡种信息
     */
    public function addVenueYard(){
            // 新增场地条件限制
            $addCondition    = $this->addVenueYardCondition();
            if($addCondition!==true){
              return $addCondition;
            }
            $transaction                  =  \Yii::$app->db->beginTransaction();                //开启事务
            try {
                $model = new  VenueYard();
                $model->venue_id        = $this->venueId;
                $model->yard_name       = $this->yardName;
                $model->people_limit    = $this->peopleLimit;
                $model->business_time   = $this->businessTime;
                $model->active_duration = $this->everyTimeLong;
                $model->create_at       = time();
                $model->room_id         = $this->roomId;
                if(!$model->save()){
                    \Yii::trace($model->errors);
                    throw new \Exception($model->errors);
                }
                // 适用场馆卡种id保存
                $result = $this->saveYardCardCategory($model->id);
                if($result!==true){
                    \Yii::trace($result);
                    throw new \Exception($result);
                }
                // 数据回滚提交
                if(empty($transaction->commit()))
                {
                    return true;
                }else{
                    return  "提交失败";
                }
            }catch(\Exception $e){
                //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
                $transaction->rollBack();
                return  $error = $e->getMessage();  //获取抛出的错误
            }
   }
    /**
     *  场地预约 - 新增场地  - 条件限制(不能增加相同姓名场地)
     * @create 2017/9/11
     * @author houkaixin<houkaixin@itsports.club>
     * @return boolean
     */
    public function addVenueYardCondition(){
       $condition  = $this->addCondition();
       if($condition!==true){
          return $condition;
       }
       $data = VenueYard::find()->where(["and",["venue_id"=>$this->venueId],["yard_name"=>$this->yardName]])->count();
       if($data!=0){
           return "场地名字已存在";
       }
       return  true;
    }

    public function addCondition(){
         $time          = explode("-",$this->businessTime);
         $timeDifferent =  strtotime(date("Y-m-d")." ".$time[1]) - (strtotime(date("Y-m-d")." ".$time[0]));
         if($this->everyTimeLong*60>$timeDifferent){
             return "每次时长超过了开放时间";
         }
        return true;
    }
    /**
     *  场地预约 - 卡种适用场馆
     * @create  2017/9/6
     * @param   $id  // 适用场地id
     * @param   $type // 调用来源类型
     * @author  houkaixin<houkaixin@itsports.club>
     * @return  boolean      //保存结果
     */
    public function saveYardCardCategory($id,$type = "add"){
         // 批量删除所有适用卡种
         if($type!=="add"){
             VenueYardCardcategory::deleteAll(["yard_id"=>$id]);  // 删除所有场馆适用卡种
         }
         if(empty($this->cardCategoryId)){
              return true;
         }
         foreach ($this->cardCategoryId as $key=>$value){
             $model = new VenueYardCardcategory();
             $model->yard_id           = $id;
             $model->card_category_id = $value;
             $model->create_at         = time();
             if(!$model->save()){
                 return $model->errors;
             }
         }
         return true;
    }
    /**
     *  场地预约 -  场馆场地 - 场地修改
     * @create  2017/9/6
     * @author  houkaixin<houkaixin@itsports.club>
     * @return  boolean      //场地修改结果
     */
    public function updateVenueYard(){
        $model = VenueYard::findOne($this->id);
        $model->people_limit   = $this->peopleLimit;
        $model->business_time  = $this->businessTime;
        $model->active_duration= $this->everyTimeLong;
        $model->room_id        = $this->roomId;
        $result                  = $this->saveYardCardCategory($this->id,"update");
        if($result!==true){
              return $result;
        }
        if(!$model->save()){
              return $model->errors;
        }
        return true;
    }

    /**
     *  场地预约 -  场馆场地 - 会员场地预约
     * @create  2017/9/11
     * @author  houkaixin<houkaixin@itsports.club>
     * @param   $aboutObject    // 预约对象
     * @param   $companyId      // 预约公司id
     * @return  boolean         //场地修改结果
     */
    public function memberYardAbout($aboutObject,$companyId){
        // 执行预约之前条件判断
         $result =  $this->conditionalJudgment($aboutObject,$companyId);
         if($result!==true){
            return $result;
         }
        $aboutStart = strtotime($this->aboutDate." ".explode("-",$this->aboutIntervalSection)[0]);
        $aboutEnd   = strtotime($this->aboutDate." ".explode("-",$this->aboutIntervalSection)[1]);
        $model = new AboutYard();
        $model->yard_id         = $this->yardId;  // 场地id
        $model->member_id       = $this->memberId; // 会员id
        if(!empty($this->memberCardId)){    // 会员卡id不为空 保存会员卡id
            $model->member_card_id  =  $this->memberCardId;   // 会员卡id
        }
        $model->about_interval_section = $this->aboutIntervalSection;// 预约区间段
        $model->aboutDate       = $this->aboutDate;   // 预约日期
        $model->status           = 1;   // 预约状态
        $model->about_start     = $aboutStart;
        $model->about_end       = $aboutEnd;
        $model->create_at       = time(); // 预约时间
        $model->is_print_receipt           = 2;   // 未打印
        if(!$model->save()){
             return $model->errors;
        }
        return true;  // 预约成功
    }
    /**
     *  场地预约 -  场馆场地 - 会员场地预约（外加条件）
     * @create  2017/9/11
     * @author  houkaixin<houkaixin@itsports.club>
     * @param  $aboutObject  // 预约对象
     * @param  $companyId    // 公司id
     * @return  boolean      //预约条件是否成立
     */
    public function conditionalJudgment($aboutObject,$companyId){
        // 如果是潜在会员 查询是否之前预约过
        $limitNum = VenueYard::find()->where(["id"=>$this->yardId])->select("people_limit,venue_id")->asArray()->one();
         if($aboutObject=="potentialMember"){
            $result = $this->judgePotentialIsHaveAbout($limitNum,$companyId);
            if($result===false){
                return "您未购买会员卡,只能预约1节!";
            }
         }
         // 最大的预约人数
         $aboutNum = AboutYard::find()->where(["and",["aboutDate"=>$this->aboutDate],["about_interval_section"=>$this->aboutIntervalSection],["yard_id"=>$this->yardId],["!=","status",5]])->count();
         if($aboutNum>=$limitNum["people_limit"]){
            return "该时间段预约人数已满";
         }
        // 同一个场馆 同一时间段是否 重复预约（同一个人）
        $isAboutCourse = AboutYard::find()->where(["and",["yard_id"=>$this->yardId],["member_id"=>$this->memberId],["!=","status",5],["about_interval_section"=>$this->aboutIntervalSection],["aboutDate"=>$this->aboutDate]])
                         ->asArray()->one();
        if(!empty($isAboutCourse)){
           return "这个时间段,您已经预约过了";
        }
        return true;
    }
    /**
     *  场地预约 -  判断潜在会员之前是否有过预约
     * @create  2017/9/11
     * @param  $companyId  //预约公司id
     * @author  houkaixin<houkaixin@itsports.club>
     * @return  boolean      //潜在会员之前是否预约
     */
    public function judgePotentialIsHaveAbout($limitNum,$companyId){
         $num = \backend\models\AboutYard::find()
                   ->alias("aboutYard")
                   ->joinWith(["venueYard venueYard"=>function($query){
                        $query->joinWith(["organization or"]);
                   }],false)
                   ->select("
                   aboutYard.id,
                   aboutYard.yard_id,
                   aboutYard.member_id,
                   aboutYard.status,
                   venueYard.venue_id,
                   or.pid,
                   ")
                   ->where(["and",["aboutYard.member_id"=>$this->memberId],["aboutYard.status"=>1]])
                   ->andWhere(["or.pid"=>$companyId])
                   ->andWhere(['venueYard.venue_id'=>$limitNum['venue_id']])
                   ->count();
        if($num>0){
           return false;
        }
        return true;
    }
    
    


}