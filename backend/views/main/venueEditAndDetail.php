
<!--
 * Created by PhpStorm.
 * User: 程丽明
 * Date: 2017/11/30
 * Time: 14:09
 * content:场馆的修改和详情模态框
 -->
<!--修改组织架构-->
<div class="modal fade" id="myModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h3 class="text-center yanse" id="myModalLabel">
                    修改组织架构信息
                </h3>
            </div>
            <div class="modal-body">
                <div class="form-group a1"><strong style="color:red">*</strong>所属公司</div>
                <div class="form-group text-center">
                    <center>
                        <select class="form-control actions" style="color: rgb(153,153,153)" id="companyId">
                            <option value="{{company.id}}"  ng-selected="company.id==companyId"   ng-repeat="company in companyS">{{company.name}}</option>
                        </select>
                    </center>
                </div>
                <input  id="_csrf" type="hidden"
                        name="<?= \Yii::$app->request->csrfParam; ?>"
                        value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                <input type="hidden" value="{{venueId}}" id="venueId">
                <div class="form-group a1"><strong style="color:red">*</strong>场馆名称</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" ng-model="venueName" class="form-control actions" id="" placeholder="请输入场馆名称">
                    </center>
                </div>
                <div class="form-group a1"><strong style="color:red">*</strong>场馆属性</div>
                <div class="form-group text-center">
                    <center>
                        <select class="form-control actions" ng-model="editVenue123">
                            <option value="">请选择场馆属性</option>
                            <option ng-selected="selectVenue123 == '1'" value="1">普通</option>
                            <option  ng-selected="selectVenue123 =='2'" value="2">尊爵</option>
                        </select>
                    </center>
                </div>
                <div class="form-group a1"><strong style="color:red">*</strong>场馆类别</div>
                <div class="form-group text-center">
                    <center>
                        <select class="form-control actions" ng-model="venueType">
                            <option value="">请选择场馆类型</option>
                            <option value="1">综合馆</option>
                            <option value="2">瑜伽馆</option>
                            <option value="3">舞蹈馆</option>
                            <option value="4">搏击馆</option>
                            <option value="5">游泳馆</option>
                            <option value="6">健身馆</option>
                        </select>
                    </center>
                </div>
                <div class="form-group" style="color: rgb(153,153,153);margin-left: 120px;">场馆面积</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" inputnum class="form-control actions" id="" ng-model="venueArea" placeholder="请输入场馆面积">
                    </center>
                </div>
                <div class="form-group a1"  style="color: rgb(153,153,153);margin-left: 120px;">场馆地址</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text"  class="form-control actions" id="" ng-model="venueAddress" placeholder="请输入场馆地址">
                    </center>
                </div>

                <div class="form-group a1"  style="color: rgb(153,153,153);margin-left: 120px;">场馆经度</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text"  class="form-control actions" id="" ng-model="venueEditLongitude" placeholder="请输入场馆经度">
                    </center>
                </div>
                <div class="form-group a1"  style="color: rgb(153,153,153);margin-left: 120px;">场馆纬度</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text"  class="form-control actions" id="" ng-model="venueEditLatitude" placeholder="请输入场馆纬度">
                    </center>
                </div>

                <div class="form-group a1">场馆电话</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" inputnum class="form-control actions" ng-model="venuePhone" id="" placeholder="请输入场馆电话">
                    </center>
                </div>
                <div class="form-group a1">场馆介绍</div>
                <div class="form-group text-center">
                    <center>
                        <input type="text" class="form-control actions" ng-model="describe" id="" placeholder="请输入场馆介绍">
                    </center>
                </div>
                <div class="form-group"  style="width: 100px;height: 100px;margin-left: 124px">
                    <img ng-src="{{pic}}" width="100px" height="100px" >
                </div>
                <div class="input-file ladda-button btn ng-empty uploader uploadPic"
                     style="margin-left: 319px;margin-top: -150px"
                     ngf-drop="uploadCover($file,'update')"
                     ladda="uploading"
                     ngf-select="uploadCover($file,'update')"
                     ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                     ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                >
                    <p class="text-center jiaHao">+</p>
                </div>
            </div>
            <div class="modal-footer">
                <center><button type="button" ng-click="venueUpdate()"  class="btn btn-success  " style="width: 100px;">完成</button></center>
            </div>
        </div>
    </div>
</div>
<!--详情模态框-->
<div class="modal fade modal" id="myModals2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div style="border: none;" class="modal-content clearfix">
            <div style="border: none;" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <div class="panel blank-panel col-sm-12">
                    <div class="panel-heading">
                        <div class="panel-title m-b-md">
                            <h3 style="" class="changGuan">场馆详情</h3>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12 heightCenter">
                            <div class="col-sm-6 text-center">
                                <img ng-src="/plugins/img/123321.png" style="width: 100%;" ng-if="venueData.pic == ''">
                                <img ng-src="{{venueData.pic}}" ng-if="venueData.pic != null" style="width: 100%;">
                            </div>
                            <div class="col-sm-6">
                                <div><b>{{venueData.name}}</b></div>
                                <div class="mT10">所属公司:<b>{{venueData.pName.name}}</b></div>
                                <div class="mT10">场馆面积:<b>{{venueData.area|noData:''}} <span ng-if="venueData.area != '' && venueData.area != null">m²</span></b></div>
                                <div class="mT10">场馆地址:<b>{{venueData.address | noData:''}}</b></div>
                                <div class="mT10">创建的人:<b>{{venueData.admin.username | noData:''}}</b></div>
                                <div class="mT10">场馆电话:<b>{{venueData.phone | noData:''}}</b></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
