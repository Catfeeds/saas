<?php
use yii\helpers\Html;
use backend\assets\AngularAsset;
use backend\assets\IndexAsset;
use backend\assets\ToastrAsset;

AngularAsset::register($this);
ToastrAsset::register($this);
IndexAsset::register($this);
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
</head>
<body ng-app="App">
<?php $this->beginBody() ?>
    <?=$content?>
<?=$this->render('@app/views/common/loading.php');?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
