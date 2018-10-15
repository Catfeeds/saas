<?php
/**
 * Created by PhpStorm.
 * User: Xin Wei
 * Date: 2018/8/7
 * Time: 19:55
 * Desc:公众号注册公司信息表
 */
namespace common\models;

use common\models\relations\CompanyRelations;
class Company extends \common\models\base\Company
{
    use CompanyRelations;
}