<?php
use yii\helpers\Html;
use backend\assets\AngularAsset;
use backend\assets\ToastrAsset;
AngularAsset::register($this);
ToastrAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        body{
            background: url("/plugins/img/shengdan.jpg") center center / cover no-repeat;
        }
        .login-forms{
            background: rgba(0, 0, 0, 0.35);
        }
    </style>
</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden" ng-app="App">
<?php $this->beginBody() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
