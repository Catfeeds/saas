<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/25 0025
 * Time: 上午 10:07
 */
namespace backend\models;
use common\models\base\FitnessDiet;
use common\models\base\MemberFitnessProgram;
use yii\base\Model;
class MemberFitnessProgramForm extends Model
{
    public $memberId;          //会员id
    public $weight;            //目标体重
    public $fitnessId;         //健身目标id
    public $dietId;            //饮食计划id
    public $fitnessContent;    //健身目标内容
    public $dietContent;       //饮食计划内容

    /**
     * 云运动 - 会员维护 - 新增会员健身详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/27
     * @return array
     */
    public function rules()
    {
        return [
            [['memberId','weight','fitnessId','dietId','fitnessContent','dietContent'],'safe'],
        ];
    }

    /**
     * 云运动 - 会员维护 - 新增会员健身详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/27
     * @return array
     */
    public function addMemberFitness()
    {
        if(empty($this->weight) && empty($this->fitnessId) && empty($this->dietId)){
            return '内容不能为空';
        }
        $program = MemberFitnessProgram::findOne(['member_id' => $this->memberId]);
        if(isset($program)){
            $program->member_id     = $this->memberId;
            $program->target_weight = $this->weight;
            $program->fitness_id    = $this->fitnessId;
            $program->diet_id       = $this->dietId;
            $program->update_at     = time();
        }else{
            $program                = new MemberFitnessProgram();
            $program->member_id     = $this->memberId;
            $program->target_weight = $this->weight;
            $program->fitness_id    = $this->fitnessId;
            $program->diet_id       = $this->dietId;
            $program->create_at     = time();
        }
        if($program->save() == true){
            if(!empty($this->fitnessId)){
                $fitness = FitnessDiet::findOne(['id' => $this->fitnessId]);
                $fitness->content = $this->fitnessContent;
                $fitness->save();
            }
            if(!empty($this->dietId)){
                $diet = FitnessDiet::findOne(['id' => $this->dietId]);
                $diet->content = $this->dietContent;
                $diet->save();
            }
            return true;
        }else{
            return $program->errors;
        }
    }
}