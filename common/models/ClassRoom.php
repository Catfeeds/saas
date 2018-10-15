<?php
/**
 * Created by PhpStorm.
 * User: zmk
 * Date: 2018/5/29
 * Time: 17:51
 */
namespace common\models;
use common\models\relations\ClassRoomRelations;
class ClassRoom extends \common\models\base\ClassRoom
{
    use ClassRoomRelations;
}