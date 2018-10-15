<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/24 0024
 * Time: 下午 8:05
 */
namespace backend\models;
use common\models\base\FitnessDiet;
use common\models\base\MemberFitnessProgram;
use yii\base\Model;
class FitnessDietForm extends Model
{
    public $scenarios;      //场景
    public $fitnessGoal;    //健身目标
    public $dietPlan;       //饮食计划
    public $content;        //内容
    public $fitnessId;      //健身目标id
    public $dietId;         //饮食计划id
    public $companyId;      //公司id
    public $venueId;        //场馆id

    /**
     * @会员维护 - 新增、修改健身目标，新增、修改饮食计划 - 场景多表单定义
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/24
     * @return array
     */
    public function scenarios()
    {
        return [
            "addFitness"    => ["scenarios","fitnessGoal","content","companyId","venueId"],
            "addDiet"       => ["scenarios","dietPlan","content","companyId","venueId"],
            "updateFitness" => ["scenarios","fitnessGoal","content","fitnessId"],
            "updateDiet"    => ["scenarios","dietPlan","content","dietId"],
        ];
    }

    /**
     * @会员维护 - 新增、修改健身目标，新增、修改饮食计划 - 验证规则
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/24
     * @return array
     */
    public function rules()
    {
        return [
            [['scenarios','fitnessGoal','dietPlan','content','fitnessId','dietId','companyId','venueId'],'safe'],
        ];
    }

    /**
     * 云运动 - 会员维护 - 新增健身目标
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/24
     * @return array
     */
    public function addFitnessGoal()
    {
        $fitness             = new FitnessDiet();
        $fitness->type       = 1;
        $fitness->name       = $this->fitnessGoal;
        $fitness->content    = $this->content;
        $fitness->create_at  = time();
        $fitness->company_id = $this->companyId;
        $fitness->venue_id   = $this->venueId;
        if($fitness->save() == true){
            return true;
        }else{
            $fitness->errors;
        }
    }

    /**
     * 云运动 - 会员维护 - 新增饮食计划
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/24
     * @return array
     */
    public function addDietPlan()
    {
        $diet             = new FitnessDiet();
        $diet->type       = 2;
        $diet->name       = $this->dietPlan;
        $diet->content    = $this->content;
        $diet->create_at  = time();
        $diet->company_id = $this->companyId;
        $diet->venue_id   = $this->venueId;
        if($diet->save() == true){
            return true;
        }else{
            $diet->errors;
        }
    }

    /**
     * 云运动 - 会员维护 - 修改健身目标
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/24
     * @return array
     */
    public function updateFitnessGoal()
    {
        $fitness            = FitnessDiet::findOne(['id' => $this->fitnessId]);
        $fitness->name      = $this->fitnessGoal;
        $fitness->content   = $this->content;
        $fitness->update_at = time();
        if($fitness->save() == true){
            return true;
        }else{
            $fitness->errors;
        }
    }

    /**
     * 云运动 - 会员维护 - 修改饮食计划
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/24
     * @return array
     */
    public function updateDietPlan()
    {
        $diet            = FitnessDiet::findOne(['id' => $this->dietId]);
        $diet->name      = $this->dietPlan;
        $diet->content   = $this->content;
        $diet->update_at = time();
        if($diet->save() == true){
            return true;
        }else{
            $diet->errors;
        }
    }

    /**
     * 云运动 - 会员维护 - 删除健身目标，删除饮食计划
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/24
     * @return array
     */
    public function delFitnessDiet($fitDietId)
    {
        $memberFit = MemberFitnessProgram::find()->where(['or',['fitness_id' => $fitDietId],['diet_id' => $fitDietId]])->one();
        if(isset($memberFit)){
            return '该模板正在使用，请勿删除';
        }
        $data = FitnessDiet::findOne(['id' => $fitDietId]);
        if($data->delete()){
            return true;
        }else{
            return $data->errors;
        }
    }
}