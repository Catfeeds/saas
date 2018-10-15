<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/4/25
 * Time: 17:22
 */

namespace backend\modules\v1\models;


use common\models\base\Order;
use common\models\relations\EmployeeRelations;

class Employee extends \common\models\base\Employee
{
    const  COACH_PIC = 'http://oo0oj2qmr.bkt.clouddn.com/headimg.png';
    use EmployeeRelations;
    /**
     * 云运动 - Api - 获取私教详情
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/24
     * @param  $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCoachDetail($id)
    {
        $coach = \backend\models\Employee::getCoachOneById($id);
        if($coach && !empty($coach)){
            $coach['intro'] = (isset($coach['intro']) && !empty($coach['intro']))?$coach['intro']:'为健身爱好者提供一对一具体指导的健身指导者。 私人健身教练进行的是一对一的工作，工作具有互动性、针对性等特点。私人教练适合不同健康水平、年龄段和经济收入的人群，通过提供个性化的健身计划和关注，服务于健身会员（顾客）。购买私人教练是最好的提高健康和体能、达到设置的目标的方法之一。';
            $group = new GroupClass();
            $score             = $group->getFieldsByOne($v = [],'score');
            if(empty( $coach['work_time']))
            {
                $coach['workTime'] = 3;
            }else{
                $coach['workTime'] = $coach['work_time'];
            }
            if(empty($coach['age']))
            {
                $coach['age'] = 25;
            }
            $coach['score']    = $score['score'];
            $coach['scoreImg'] = $score['scoreImg'];
            $coach['coachPic'] = !empty($coach['pic'])?$coach['pic']:self::COACH_PIC;
            unset($coach['params'],     $coach['create_at'],
                $coach['updated_at'], $coach['admin_user_id'],
                $coach['create_id'],  $coach['salary'],
                $coach['leave_date'], $coach['entry_date'],
                $coach['organization_id'],$coach['birth_time'],
                $coach['mobile'],$coach['email'],
                $coach['work_time']  );
        }
        return $coach;
    }
    /**
     * 云运动 - Api - 获取私教
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/24
     * @param $venueId //场馆id
     * @param $orderId // 订单id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCoach($venueId,$orderId)
    {
        $coachId = "";
        if(!empty($orderId)){
            $coachId = Order::find()
                ->where(["and",["consumption_type"=>"charge"],["consumption_type_id"=>$orderId]])
                ->one();
            if(!empty($coachId)){
               $coachId = $coachId->new_note;
            }
        }
        $data  = Employee::find()
            ->alias('ee')
            ->joinWith(['organization or'])
            ->where(['or.code'=>'sijiao'])
            ->andWhere(['ee.status'=>1])
            ->andWhere(['ee.venue_id'=>$venueId]);
        if(!empty($coachId)){
            $data = $data->andWhere(["ee.id"=>$coachId]);
        }
        $data =$data->all();
        return $data;
    }
    /**
     * 云运动 - Api - 员工属性
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/24
     * @return array|\yii\db\ActiveRecord[]
     */
    public function fields()
    {
        $fields['name'] = 'name';
        $fields['id']   = 'id';
        $fields['workTime']  = function (){
            return (!empty($this->work_time)) ? $this->work_time :3;
        };
        $fields['age']  = function (){
            return (!empty($this->age)) ? $this->age :25;
        };
        $fields['pic']  = function (){
            return $this->pic ?: '';
        };
        $fields['score'] = function (){
            $group = new GroupClass();
            $score             = $group->getFieldsByOne($v = [],'score');
            $coach['score']    = $score['score'];
            return $coach['score'];
        };
        $fields['scoreImg'] = function (){
            $group = new GroupClass();
            $score             = $group->getFieldsByOne($v = [],'score');
            return $score['scoreImg'];
        };
        $fields['signature'] = 'signature';
        return $fields;
    }
}