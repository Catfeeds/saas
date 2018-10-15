<?php
use backend\assets\SettingsAsset;
SettingsAsset::register($this);

$this->title='云运动 ● 数据库字典';
?>
<style>
    body {
        padding: 25px;
    }
    h1 {
        font-size: 1.5em;
        margin-top: 0;
    }

    .stack {
        font-size: 0.85em;
    }

    .date {
        min-width: 75px;
    }

    .text {
        word-break: break-all;
    }

    a.llv-active {
        z-index: 2;
        background-color: #f5f5f5;
        border-color: #777;
    }

    #table-dict .description {
        padding: 0;
    }
    .container-fluid {
        background: #fff;
    }
    .description input {
        padding-left: 5px;
        padding-right: 5px;
        width: 100%;
        height: 100%;
        border: none;
    }

    #table-dict .table-description {
        padding: 0;
    }

    .table-description input {
        padding: 5px;
        margin-bottom: 10px;
        width: 217px;
        height: 100%;
    }
</style>
<div class="container-fluid" ng-controller="dbController"  ng-cloak>
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <h1 style="margin-top: 20px;font-weight: 700;">
                    <span class="glyphicon glyphicon-book" aria-hidden="true"></span>云运动 ● 数据库字典</h1>
                <div class="list-group" style="margin-top: 20px">
                    <small class="table-description">  <input ng-model = 'tableName' placeholder="搜索表名"></small>
                </div>
                <div class="list-group" style="margin-top: 20px;height: 600px;overflow-x: scroll">
                    <a href="javascript:void(0)"
                       ng-repeat="list in tableLists |filter:{'Comment': tableName}"
                       class="list-group-item"
                       ng-class="{'llv-active':(list.Name == table[0].TABLE_NAME)}"
                       ng-click="tableList(list.Name)"
                       title="{{list.Comment}}"
                       style="overflow-x: hidden;font-size: 13px;"
                    >
                        {{list.Name}}
                    </a>
                </div>
            </div>
            <div class="col-sm-9 col-md-10 table-container">
                <div style="margin-top: 20px">
                    <h2 style="font-weight: 200;">{{table[0].TABLE_NAME}}
                        <small class="table-description" style="font-weight: bold;">
                            {{table[0].TABLE_COMMENT}}
                        </small>
                    </h2>
                </div>
                <hr>
                <table id="table-dict" class="table table-bordered table-hover" style="font-size: 13px;">
                    <thead>
                    <tr>
                        <th>字段名</th>
                        <th>类型</th>
                        <th>默认值</th>
                        <th>索引</th>
                        <th>是否为空</th>
                        <th>其他</th>
                        <th>字段备注</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="item in items">
                        <td>{{item.COLUMN_NAME}}</td>
                        <td>{{item.COLUMN_TYPE}}</td>
                        <td>{{item.COLUMN_DEFAULT}}</td>
                        <th>{{item.COLUMN_KEY}}</th>
                        <td>
                            <span class="label label-success" ng-if="item.IS_NULLABLE == 'YES'">{{item.IS_NULLABLE}}</span>
                            <span class="label label-warning" ng-if="item.IS_NULLABLE == 'NO'">{{item.IS_NULLABLE}}</span>
                        </td>
                        <td>{{item.EXTRA}}</td>
                        <td>{{item.COLUMN_COMMENT}}</td>
                    </tr>

                    </tbody>
                </table>
                <?=$this->render('@app/views/common/pagination.php');?>
                <div>
                </div>
            </div>
        </div>
</div>
