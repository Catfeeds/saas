<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\assets\AdminLogAsset;

AdminLogAsset::register($this);
$this->title = '操作日志';
/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<div class="admin-log-index ">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
         'columns' => [
                    'id',
                    'route',
                    [
                        'attribute' => 'user_id',
                        'value' => function($model) {
                            return $model->user_id==0?"无":\common\models\Admin::findOne($model->user_id)->username;
                        }
                    ],
                    [
                        'attribute' => 'ip',
                        'value' => function($model) {
                            return long2ip($model->ip);
                        }
                    ],
                    'created_at:datetime',

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}'
                    ],
                ],
    ]); ?>
</div>


