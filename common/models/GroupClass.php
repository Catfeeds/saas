<?php

namespace common\models;
class GroupClass extends \common\models\base\GroupClass
{
    /**
     * 运运动-关联
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @return \yii\db\ActiveQuery
     */
    public function getAllOrganization()
    {
        return $this->hasOne(Organization::className(), ['id'=>'venue_id']);
    }
    /**
     * 运运动-关联
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @return \yii\db\ActiveQuery
     */
    public function getAllCourse()
    {
    return $this->hasOne(Course::className(), ['id'=>'course_id']);
    }

    /**
     * 运运动-关联
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     */
    public function getAboutClasses()
    {
        return $this->hasMany(AboutClass::className(), ['class_id' => 'id']);
    }
}