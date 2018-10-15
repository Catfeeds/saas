<?php
namespace backend\models;
use common\models\Func;
use common\models\relations\TrainStagesRelations;
use Yii;

class TrainStage extends \common\models\base\TrainStage
{
    use TrainStagesRelations;
}