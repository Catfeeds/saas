<!--
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/5 0005
 * Time: 15:04
 */
 -->
<!--编辑广告模态框-->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="redactAdvertisingModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">编辑</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="col-sm-12 pd0">
                            <!--<li class="col-sm-12">
                                <div class="col-sm-4 text-right">
                                    <span class="red lineH30">*</span>广告类型
                                </div>
                                <div class="col-sm-8">
                                    <select class="form-control" id="advertisingTypeSelect" ng-model="advertisingType">
                                        <option value="">选择类型</option>
                                        <option value="1">广告页2</option>
                                        <option value="2">a页</option>
                                    </select>
                                </div>
                            </li>-->
                            <li class="col-sm-12  mT20 pd0">
                                <div  class="col-sm-4  text-right pd0"><span class="red lineH30">*</span>上传海报</div>
                                <div  class="col-sm-8">
                                    <div class="uploadImgDiv">
                                        <img ng-src="{{imgLink}}" ng-model="imgLink" class="upImg" ng-if="imgLink !='' && imgLink !=undefined " >
                                        <img ng-src="/plugins/advertisingSite/img/22.png" ng-model="imgLink" class="upImg" ng-if="imgLink == '' || imgLink == undefined ">
                                        <div class="uploadImgBtn">
                                            <input type="file" class="form-control upLoadInput" ngf-drop="setCover5($file)" ngf-select="setCover5($file)" uploader="uploader">
                                        </div>
                                    </div>
                                    <p style="width: 100%"><span class="red lineH30">*</span>图片大小不能超过2M</p>
                                </div>
                            </li>
                            <li class="col-sm-12 mT20 pd0">
                                <div class="col-sm-4 text-right pd0">
                                    <span class="red lineH30"></span>是否跳过
                                </div>
                                <div class="col-sm-8 ">
                                    <switch style="float: left" id="jumpStatus" name="jumpStatus" ng-click="jumpStatus()" class="green "></switch>
                                    <p style="float: left;margin-left: 10px;">(<span class="red lineH30">*</span>不选默认为跳过)</p>
                                </div>
                            </li>
                            <li class="col-sm-12 mT20 pd0">
                                <div class="col-sm-4 text-right pd0"><span class="red lineH30">*</span>展示秒数</div>
                                <div class="col-sm-8 ">
                                    <input style="width: 60px;float: left" id="numSecond" type="number" min='1' checknum class="form-control deal" placeholder="0">
                                    <span class="lineH30" style="float: left;">秒</span>
                                </div>
                            </li>
                            <li class="col-sm-12 mT20 pd0">
                                <div class="col-sm-4 text-right pd0"><span class="red lineH30"></span>跳转链接</div>
                                <div class="col-sm-8 ">
                                    <input type="text" class="form-control" placeholder="请输入跳转链接" ng-model="crossLink">
                                </div>
                            </li>
                            <li class="col-sm-12 mT20 pd0">
                                <div class="col-sm-4 text-right pd0">
                                    <span class="red lineH30">*</span>有效期
                                </div>
                                <div class="col-sm-8 ">
                                    <input type="text" readonly name="reservation" id="advertisingDate" class="form-control h34 text-center" style="width: 100%">
                                </div>
                            </li>
                             <!--<li class="col-sm-12 mT20 pd0 text-center">
                                <img src="/plugins/advertisingSite/img/info.png" alt="" style="width: 30px;height: 30px;">
                                <span class="lineH30">场馆变更后，之前记录会消失，请谨慎操作</span>
                            </li>-->
                            <li class="col-sm-12 mT20 pd0">
                                <div class="col-sm-4 text-right pd0">
                                    <span class="red lineH30">*</span>投放场馆
                                </div>
                                <div class="col-sm-8">
                                    <select class="form-control" id="chooseVenueSelect" multiple="multiple" ng-model="venueArr" ng-change="venueArrChange(venueArr)">
                                        <!--<option value="0">全部场馆</option>-->
                                       <!-- <option value="{{i.id}}" ng-repeat="i in venueItems" ng-if="!chooseAllVenue">{{i.name}}</option>-->
                                        <option value="{{i.id}}" ng-repeat="i in venueItems">{{i.name}}</option>
                                    </select>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 text-center"  style="border-left: 1px solid #e5e5e5">
                        <div class="poster" ng-if="imgLink == '' || imgLink == undefined" >
                            <img ng-src="/plugins/advertisingSite/img/img1.png" class="img1">
                        </div>
                        <div class="poster2" ng-if="imgLink != '' && imgLink != undefined ">
                            <img ng-src="{{imgLink}}" class="img2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success w100" ng-click="redactSuccessBtn()">完成</button>
            </div>
        </div>
    </div>
</div>
