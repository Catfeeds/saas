<?php
namespace backend\rbac\rules;

use yii\rbac\Rule;

class MenuRule extends Rule

{
    public $name;

    public $createdAt;

    public $updatedAt;

    public function execute($user, $item, $params)
    {
        // TODO: Implement execute() method.
    }
}