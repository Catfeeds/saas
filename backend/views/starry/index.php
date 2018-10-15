<?php
use backend\assets\StarryAsset;

StarryAsset::register($this);
$this->title = '商品管理';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>测试</title>
</head>
<body>
<div ng-controller="testController">
    名字: <input ng-model="name">
    <div class="sty" ng-show='menuState.show'></div>
    <button ng-click="toggleMenu()">点击显隐</button>
    <div class="test">
        <h3><span>今天测试显隐</span></h3>
        <ul>
            <li>1</li>
            <li>2</li>
            <li>3</li>
            <li>4</li>
        </ul>
    </div>

</div>

</body>
</html>
