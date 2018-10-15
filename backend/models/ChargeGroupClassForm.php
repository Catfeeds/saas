<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/4 0004
 * Time: 下午 2:54
 */
namespace backend\models;
use common\models\base\AboutClass;
use common\models\base\ChargeGroupClass;
use yii\base\Model;
class ChargeGroupClassForm extends Model
{
    public $classNumberId;    //私课编号id
    public $date;             //上课日期
    public $start;            //开始时间
    public $end;              //结束时间
    public $coachId;          //教练id

    /**
     * @私教小团体课 - 验证规则
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/08
     * @return array|string
     */
    public function rules()
    {
        return [
            [['classNumberId','date','start','end','coachId'],'safe'],
        ];
    }

    /**
     * @私教小团体课 - 保存排课信息
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/04
     * @return array|string
     */
    public function addArrangeClass($companyId,$venueId)
    {
        $start = strtotime($this->date." ".$this->start);
        $end   = strtotime($this->date." ".$this->end);
        // 执行数据录入前的判断
        $class = ChargeGroupClass::find()
            ->andWhere(['and',['<=','start',$start],['>=','end',$start],['venue_id' => $venueId],['!=','status',5],['class_number_id' => $this->classNumberId]])
            ->orWhere(['and',['<=','start',$end],['>=','end',$end],['venue_id' => $venueId],['!=','status',5],['class_number_id' => $this->classNumberId]])
            ->asArray()
            ->one();
        if(isset($class)){
            return '该时间段已排此课程';
        }
        $classTwo = ChargeGroupClass::find()
            ->andWhere(['and',['<=','start',$end],['>=','end',$end],['venue_id' => $venueId],['!=','status',5],['coach_id' => $this->coachId]])
            ->orWhere(['and',['<=','start',$end],['>=','end',$end],['venue_id' => $venueId],['!=','status',5],['coach_id' => $this->coachId]])
            ->asArray()
            ->one();
        if(isset($classTwo)){
            return '该教练已排其他课程';
        }
        $transaction = \Yii::$app->db->beginTransaction();    //开启事务
        try{
            $chargeGroup = new ChargeGroupClass();
            $chargeGroup->start           = $start;
            $chargeGroup->end             = $end;
            $chargeGroup->class_date      = $this->date;
            $chargeGroup->created_at      = time();
            $chargeGroup->status          = 1;
            $chargeGroup->class_number_id = $this->classNumberId;
            $chargeGroup->coach_id        = $this->coachId;
            $chargeGroup->company_id      = $companyId;
            $chargeGroup->venue_id        = $venueId;
            if($chargeGroup->save() != true){
                return $chargeGroup->errors;
            }

            $about = $this->aboutClass($chargeGroup->id,$start,$end);
            if($about != true){
                return $about;
            }

            if($transaction->commit() == null){
                return true;
            }else{
                return false;
            }
        }catch(\Exception $e){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return $e->getMessage();  //获取抛出的错误
        }
    }
    /**
     * @私教小团体课 - 保存排课信息并给每个买课的会员约课
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2018/01/27
     * @return array|string
     */
    public function aboutClass($id,$start,$end)
    {
        $course = MemberCourseOrder::find()
            ->where(['class_number_id' => $this->classNumberId])
            ->select('member_id,member_card_id')
            ->asArray()->all();
        if(!empty($course)){
            $admin = Employee::findOne(['admin_user_id' => \Yii::$app->user->identity->id]);
            foreach ($course as $key => $value) {
                $about = new AboutClass();
                $about->member_card_id   = $value['member_card_id'];
                $about->class_id         = $id;
                $about->status           = 8;                          //待预约
                $about->type             = '3';                        //私教多人课
                $about->create_at        = time();
                $about->coach_id         = $this->coachId;
                $about->class_date       = $this->date;
                $about->start            = $start;
                $about->end              = $end;
                $about->member_id        = $value['member_id'];
                $about->is_print_receipt = 2;
                $about->about_type       = 2;
                $about->employee_id      = intval($admin->id);
                if($about->save() != true){
                    return $about->errors;
                }
            }
            return true;
        }
    }
}