<?php
namespace backend\models;

use common\models\Func;
use common\models\relations\ClassBeforeQuestionRelations;
use common\models\relations\CourseRelations;
use Yii;

class ClassBeforeQuestion extends \common\models\base\ClassBeforeQuestion
{
    use ClassBeforeQuestionRelations;
    use CourseRelations;
}