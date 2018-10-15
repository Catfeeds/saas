<?php
/**
 * Created by PhpStorm.
 * User: zmk
 * Date: 2018/5/29
 * Time: 17:52
 */
namespace common\models\relations;

use backend\models\Organization;

trait  ClassRoomRelations
{
    /**
     * 教室表关联房间
     * @return string
     * @author 朱梦珂
     * @create 2018-05-29
     */
    public function getOrganizationRoom()
    {
        return $this->hasOne(Organization::className(), ['id' => 'room_id']);
    }
}