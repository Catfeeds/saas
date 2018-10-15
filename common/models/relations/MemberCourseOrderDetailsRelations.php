<?php
namespace common\models\relations;

trait  MemberCourseOrderDetailsRelations
{
    /**
     * 销售主页 - 课程预约 - 关联课种表
     * @return string
     * @author 朱梦珂
     * @create 2017-6-10
     * @return mixed
     */
    public function getCourse()
    {
        return $this->hasOne(\common\models\Course::className(),['id'=>'course_id']);
    }
    /**
     * 销售主页 - 课程预约 - 关联课种表
     * @return string
     * @author 朱梦珂
     * @create 2017-6-10
     * @return mixed
     */
    public function getMemberCourseOrder()
    {
        return $this->hasOne(\common\models\MemberCourseOrder::className(),['id'=>'course_order_id']);
    }
    /**
     * 销售主页 - 课程预约 - 预约表
     * @return string
     * @author 焦冰洋
     * @create 2017-09-09
     * @return mixed
     */
    public function getAboutClass()
    {
        return $this->hasMany(\common\models\AboutClass::className(),['class_id'=>'id']);
    }
}