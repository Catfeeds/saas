<?php
use backend\assets\ActionCategoryAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use leandrogehlen\treegrid\TreeGrid;
ActionCategoryAsset::register($this);
$this->title = '分类管理';
/**
 * 私教管理 - 动作库
 */
?>
<div class="actionCategoryContent" ng-controller="actionCategoryCtrl" ng-cloak>
    <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken(); ?>">
    <div class="panel panel-default">
        <div class="panel-heading"><h4>分类管理</h4></div>
        <div class="panel-body">
            <button class="btn btn-info" ng-click="addParentBtn()">新建顶级分类</button>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-body">
            <?= TreeGrid::widget([
                'dataProvider' => $dataProvider,
                'keyColumnName' => 'id',
                'parentColumnName' => 'pid',
                'parentRootValue' => 0, //first parentId value
                'pluginOptions' => [
                   'initialState' => 'collapsed',//开collapsed
                ],
                'columns' => [
                    'title',
                    //'updated_at',
                   /* [
                        'class' => 'backend\widgets\grid\PositionColumn',
                        'attribute' => 'sort'
                    ],*/
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '<div class="btn-group" role="group">{recharge} {view} {delete} </div>',
                        'header'=>'操作',
                        'headerOptions'=>['width'=>'300'],
                        'buttons' => [
                            'recharge'=>function($url,$model){
                                return $model->level<2?'<i class="notW addChildBtn" value= '.$model->id.' class="addChildBtn">添加</i>':'';
                                },
                                'view'=>function($url,$model){
                                return '<i class="notW midI" ng-click="update('.$model->id.',\''.$model->title.'\')">修改</i>';
                                },
                                'delete'=>function($url,$model){
                                return '<i class="notW" ng-click="delete('.$model->id.')">删除</i>';
                                },

                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
    <!--新增顶级分类-->
    <?=$this->render('@app/views/action-category/addParentModal.php');?>
    <!--新增子级分类-->
    <?=$this->render('@app/views/action-category/addChildModal.php');?>
    <!--修改-->
    <?=$this->render('@app/views/action-category/updateMenuModal.php');?>
</div>
