<?php

namespace backend\models;

use yii\base\Model;
class CommonChange extends Model
{
    public $orderDetailsId;
    public $memberId;
    public $aboutId;
    public $num;
    public $create;
    public $price;
    /**
     * 云运动 - 私教排期 - 计算私教
     * @author lihuien<lihuien@itsports.club>
     * @create 2017/6/13
     * @param  $aboutId
     * @return array|bool
     */
    public function handleChangeClass($aboutId)
    {
        $changeAbout = AboutClass::find()
            ->alias('ac')
            ->joinWith(['memberCourseOrderDetails mcod'])
            ->select('ac.id,ac.class_id,mcod.id as mo_id,ac.create_at,ac.status,ac.start')
            ->where(['ac.id'=>$aboutId])
            ->asArray()->one();
        $this->create = $changeAbout['create_at'];
        return $this->handleChangeMemberClass($changeAbout['memberCourseOrderDetails']['course_order_id'],$changeAbout['status'],$changeAbout['start']);
    }
    /**
     * 云运动 - 私教排期 - 计算私教
     * @author lihuien<lihuien@itsports.club>
     * @create 2017/6/13
     * @param  $id
     * @return array|bool
     */
    public function handleChangeMemberClass($id,$status,$start)
    {
        $memberOrder = MemberCourseOrder::find()
            ->alias('mco')
            ->joinWith(['memberCourseOrderDetails memberCourseOrderDetails'])
            ->where(['mco.id'=>intval($id)])
            ->asArray()->one();
        if($memberOrder['overage_section'] == 0){
            return 'none';
        }
        $this->price = $memberOrder['money_amount'];
        $data = $this->memberOrderDetailsArr($memberOrder['course_amount'],$memberOrder['memberCourseOrderDetails'],$status,$start);
        return $data;
    }
    /**
     * 云运动 - 私教排期 - 计算私教
     * @author lihuien<lihuien@itsports.club>
     * @create 2017/6/13
     * @param  $num
     * @param  $memberOrderData
     * @return array|bool
     */
    public function memberOrderDetailsArr($num,$memberOrderData,$status,$start)
    {
        $this->num = $num;  //总节数
        if(isset($memberOrderData) && !empty($memberOrderData)){
            foreach ($memberOrderData as $k=>$v){
                if($status == null){    //私课排课时的进度
                    $count = $this->getAboutChangeClass($v['id']);
                }else{                  //私教上课列表中的进度
                    $count = $this->getAboutClassTimes($v['id'],$start);
                }
                 if($count == $num){
                     return 'aboutNone';
                 }else{
                     if($status == null){
                         $count = ($count == 0) ? 1 : $count+1;
                     }else{
                        if($status == '3' || $status == '4'){
                            $count = ($count == 0) ? 1 : $count;
                        }else{
                            $count = 0;
                        }
                     }
                     return ['id'=>$v['id'],'total_num'=>$num,'course_num'=>$count,'product_name'=>$v['product_name'],'money_amount'=>$this->price,'course_name'=>$v['course_name'],'class_length'=>$v['class_length']];
                 }
             }
        }
        return false;
    }
    /**
     * 云运动 - 私教上课 - 课程进度
     * @author lihuien<lihuien@itsports.club>
     * @create 2017/6/
     * @param $classId
     * @return array|bool
     */
    public function getAboutClassTimes($classId,$start)
    {
        $total = AboutClass::find()
            ->where(['class_id'=>$classId])
            ->andWhere(['type'=>intval(1)])
            ->andWhere(['or',['status'=>[3,4]],['and',['status'=>1],['>','end',time()]]])
            ->andWhere(['<=','start',$start])
//            ->andFilterWhere(['<','create_at',$this->create])
            ->asArray()->count();
//        $overdue = AboutClass::find()
//            ->where(['class_id'=>$classId])
//            ->andWhere(['type'=>intval(1)])
//            ->andWhere(['or',['status'=>1],['status'=>5],['status'=>6]])
//            ->andFilterWhere(['<=','create_at',$this->create])
//            ->asArray()->count();
//        $surplus = $total - $overdue;
        return $total;
    }
    /**
     * 云运动 - 私课排课 - 约课进度
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/02
     * @param $classId
     * @return array|bool
     */
    public function getAboutChangeClass($classId)
    {
        $total = AboutClass::find()
            ->where(['class_id'=>$classId])
            ->andWhere(['type'=>intval(1)])
            ->andWhere(['or',['status'=>[3,4]],['and',['status'=>1],['>','end',time()]]])
            ->andFilterWhere(['<','create_at',$this->create])
            ->asArray()->count();
//        $overdue = AboutClass::find()
//            ->where(['class_id'=>$classId])
//            ->andWhere(['type'=>intval(1)])
//            ->andWhere(['or',['status'=>1],['status'=>5],['status'=>6]])
//            ->andWhere(['<','end',time()])
//            ->asArray()->count();
//        $surplus = $total - $overdue;
        return $total;
    }
}