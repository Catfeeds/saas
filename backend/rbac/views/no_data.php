<?php
list(, $dir) = Yii::$app->assetManager->publish('@backend/rbac/plugins');
$url = $dir . '/image/noDate.png';
?>
<div class="text-center load-wrap" ng-show="<?= isset($name) ? $name : true ?>">
    <img class="load-img" src="<?= $url; ?>">
    <p class="load-text"><?= isset($text) ? $text : '暂无数据'; ?></p>
</div>