<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/13 0013
 * Time: 16:08
 */
namespace common\models;
use common\models\relations\DealChangeRecordRelations;
class DealChangeRecord extends \common\models\base\DealChangeRecord
{
    use DealChangeRecordRelations;
}