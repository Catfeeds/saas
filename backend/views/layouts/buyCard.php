<?php
/**
 * Created by PhpStorm.
 * User: 梁咳咳
 * Date: 2017/3/16
 * Time: 15:31
 */
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body ng-app="App" class="fixed-sidebar full-height-layout gray-bg" style='background-color: #F5f5f5;font-family: "Microsoft YaHei", 微软雅黑, "Helvetica Neue", Helvetica, Tahoma, Arial, "WenQuanYi Micro Hei", sans-serif';>
<?php $this->beginBody() ?>
   <?=$content?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

