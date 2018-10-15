<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\assets\AdminLogAsset;

AdminLogAsset::register($this);
$this->title = '详细日志';

//$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Admin Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-log-view">
    <div style="margin-top:1%"><div>
    <h2><button onclick="window.history.go(-1)">返回</button></h2>
    <div style="margin-top:3%"><div>
    <h1><?= Html::encode($this->title) ?></h1>



    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'route',
            'description:ntext',
            'created_at:datetime',
            'user_id',
            'ip',
        ],
    ]) ?>

</div>