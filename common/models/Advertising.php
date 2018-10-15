<?php
/**
 * Created by PhpStorm.
 * User: 付钟超 <fuzhongchao@itsports.club>
 * Date: 2018/5/6 0006
 * Time: 08:55
 */

namespace common\models;

use common\models\relations\AdvertisingRelations;
class Advertising extends \common\models\base\Advertising
{
    use AdvertisingRelations;
}