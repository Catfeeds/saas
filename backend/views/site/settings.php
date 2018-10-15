<?php
use backend\assets\SettingsAsset;
SettingsAsset::register($this);

$this->title='系统配置';
?>
<div class="container-fluid pd0" ng-controller="settingsController" ng-cloak>
    <div style="background: #f5f5f5;" class="row">
        <div style="margin-bottom: 2%;" class="col-sm-12">
            <div style="padding-left: 0;padding-right: 0;" class="col-sm-12">
                <div class="col-xs-12">
                    <div style="background: #fff;border: 1px solid #dee5e7;border-radius: 4px;" class="col-xs-12">
                        <h4 style="margin-top: 20px;margin-bottom: 10px;">导入数据配置</h4>
                        <div style="margin-top: 20px;" class="col-sm-2">
                            <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
                            <div class="col-sm-3 iconDiv">
                                <button class="ladda-button btn btn-primary dim"
                                        ngf-drop
                                        ngf-select="uploadCover($file,'大上海','大上海瑜伽健身馆')">
                                    大上海数据导入
                                </button>
                            </div>
                        </div>
                        <div style="margin-top: 20px;" class="col-sm-2">
                            <div class="col-sm-3 iconDiv">
                                <button class="ladda-button btn btn-primary dim"
                                        ngf-drop
                                        ngf-select="uploadCover($file,'大上海','大上海瑜伽健身馆','two')">
                                    大上海格式二数据导入
                                </button>
                            </div>
                        </div>
                        <div style="margin-top: 20px;" class="col-sm-2">
                            <div class="col-sm-3 iconDiv">
                                <button class="ladda-button btn btn-primary dim"
                                        ngf-drop
                                        ngf-select="uploadCover($file,'大学路','大学路舞蹈健身馆')">
                                    大学路数据导入
                                </button>
                            </div>
                        </div>
                        <div style="margin-top: 20px;" class="col-sm-2">
                            <div class="col-sm-3 iconDiv">
                                <button class="ladda-button btn btn-primary dim"
                                        ngf-drop
                                        ngf-select="uploadCover($file,'丰庆路','丰庆路游泳健身馆')">
                                    丰庆路数据导入
                                </button>
                            </div>
                        </div>
                        <div style="margin-top: 20px;" class="col-sm-2">
                            <div class="col-sm-3 iconDiv">
                                <button class="ladda-button btn btn-primary dim"
                                        ngf-drop
                                        ngf-select="uploadCover($file,'大卫城','尊爵汇')">
                                    大卫城数据导入
                                </button>
                            </div>
                        </div>
                        <div  style="margin-top:20px" class="col-sm-2">
                            <div class="col-sm-3 iconDiv">
                                <button class="ladda-button btn btn-primary dim"
                                        ngf-drop
                                        ngf-select="privateUploadCover($file)">
                                    上传私教
                                </button>
                            </div>
                        </div>
                        <div  style="margin-top:20px" class="col-sm-2">
                            <div class="col-sm-3 iconDiv">
                                <button class="ladda-button btn btn-primary dim"
                                        ngf-drop
                                        ngf-select="uploadCovers($file,'大上海')">
                                    导入大上海会员手机号
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php if(isset(Yii::$app->user->identity) && Yii::$app->user->identity->username == 'admin'){?>
                    <div style="background: #fff;border: 1px solid #dee5e7;border-radius: 4px;" class="col-xs-12">
                        <h4 style="margin-top: 20px;margin-bottom: 10px;">系统数据配置</h4>
                        <div style="margin-top: 20px;" class="col-sm-12">
                            <div class="col-sm-3 iconDiv">
                                <button class="btn btn-primary dim animated rotateIn" ng-click="delTable()">
                                    <i class="glyphicon glyphicon-plus"></i>
                                </button>
                                <p style="text-align: center;">清空所有数据</p>
                            </div>

                            <div class="col-sm-3 iconDiv" ng-repeat="tableItem in tableItems">
                                <button class="btn dim animated rotateIn {{tableItem.icon}}" ng-click="delTable(tableItem.name)">
                                    <i class="glyphicon glyphicon-{{tableItem.tag}}"></i>
                                </button>
                                <p style="text-align: center;">清空{{tableItem.comment}}</p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <div style="background: #fff;border: 1px solid #dee5e7;border-radius: 4px;" class="col-xs-12">
                        <h4 style="margin-top: 20px;margin-bottom: 10px;">交换卡号设置</h4>
                        <div style="margin-top: 20px;" class="col-sm-2">
                            <div class="col-sm-3 iconDiv">
                                <button class="ladda-button btn btn-primary dim" data-toggle="modal" data-target="#myModals12">
                                    交换数据
                                </button>
                            </div>
                        </div>
                    </div>
                    <div style="background: #fff;border: 1px solid #dee5e7;border-radius: 4px;" class="col-xs-12">
                        <h4 style="margin-top: 20px;margin-bottom: 10px;">菜单操作</h4>
                        <div style="margin-top: 20px;" class="col-sm-2">
                            <div class="col-sm-3 iconDiv">
                                <button class="ladda-button btn btn-primary dim" ng-click="addMenu()">
                                    一键生成菜单
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-top: 20px;" class="modal fade" id="myModals12" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 20%;">
            <div style="padding-bottom: 20px;" class="modal-content clearfix">
                <div style="border: none;" class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h3 class="text-info" style="font-size: 24px;text-align: left;margin-top: 20px;margin-left: 10px;font-weight: normal;">互换卡号信息</h3>
                    <div class="col-sm-12 pd0" style="margin-top: 10px;height: 2px;background: #e1e1e1;"></div>
                    <form style="padding-left: 10px;padding-right: 10px;">
                        <div class="col-sm-12 pd0">
                            <div class="form-group" style="margin-top: 10px;">
                                <label for="exampleInputName2" style="font-size: 16px;font-weight: normal;color: #333;">卡号1:</label>
                                <input type="text"
                                       class="form-control"
                                       id="exampleInputName2"
                                       ng-model="numberOne"
                                       placeholder="请输入卡号">
                            </div>
                            <div class="form-group" style="margin-top: 10px;">
                                <label for="exampleInputName2" style="font-size: 16px;font-weight: normal;color: #333;">卡号2:</label>
                                <input type="text"
                                       class="form-control"
                                       id="exampleInputName2"
                                       ng-model="numberTwo"
                                       placeholder="请输入卡号">
                            </div>
                        </div>
                    </form>
                    <button class="btn btn-success center-block" style="margin-top: 20px;" ng-click="exchangeNumber()">&nbsp;&nbsp;&nbsp;&nbsp;交换&nbsp;&nbsp;&nbsp;&nbsp;</button>
                </div>
            </div>
        </div>
    </div>
</div>



