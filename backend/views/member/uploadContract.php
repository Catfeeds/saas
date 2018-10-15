<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/14 0014
 * Time: 10:42
 */
-->
<div class="modal fade" tabindex="-1" role="dialog" id="uploadContract">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">合同上传</h4>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-left: 0;margin-right: 0">
                    <div class="col-md-6 col-md-offset-3 text-center PD0">
                        <div class="col-md-12 PD0" ng-if="contractImgArr.length == 0 && contractOldImgArr.length == 0">
                            <img src="/plugins/member/img/no-img5.png" class="contractImg">
                        </div>
                        <!--获取老照片-->
                        <div class="col-md-12 PD0 contractImgDiv" ng-if="contractOldImgArr.length != 0" ng-repeat="($index,i) in contractOldImgArr" ng-mouseleave="hideOldContractDel($index)">
                            <img ng-src="{{i}}" ng-if="i != ''" class="contractOldImg" ng-mouseenter="showOldContractDel($index)" ng-click="bigImg($index,i)">
                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DELETECONTRACT')) { ?>
                            <span class="deleteOldContractImg" ng-click="delOldContractImg($index)">&times;</span>
                            <?php } ?>
                        </div>
                        <!--上传新照片-->
                        <div class="col-md-12 PD0 contractImgDiv" ng-if="contractImgArr.length != 0" ng-repeat="($index,i) in contractImgArr" ng-mouseleave="hideContractDel($index)">
                            <img ng-src="{{i}}" class="contractImg" ng-mouseenter="showContractDel($index)" ng-click="bigImg($index,i)">
                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DELETECONTRACT')) { ?>
                            <span class="deleteContractImg" ng-click="delContractImgBtn($index)">&times;</span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-left: 0;margin-right: 0;">
                    <div class="col-md-12 PD0" style="position: relative;">
                        <button ng-disabled="uploadPic" type="button" class="btn btn-default">合同上传</button>
                        <span style="color: orange"><i class="glyphicon glyphicon-info-sign"></i>上传照片不能大于2M</span>
                        <input ng-disabled="uploadPic" type="file" class="form-control" ngf-drop="setCover10($file)" ngf-select="setCover10($file)" uploader="uploader" style="position: absolute;top:0;left: 0;width: 82px;height: 30px;opacity: 0">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <span>温馨提示：1.点击图片放大。2.点击图片右上角“&times;”之后，还需点击“保存”按钮才会删除成功！</span>
                <button type="button" class="btn btn-default" style="width: 100px;" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success" style="width: 100px;" ng-click="uploadSuccess()">保存</button>
            </div>
        </div>
    </div>
</div>
<div id="bigImg">
    <span class="imgClose">×</span>
    <img class="img-content" id="newImg" ng-src="{{newSrc}}">
</div>