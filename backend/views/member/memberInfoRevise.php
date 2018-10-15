<!--会员信息修改-->
<div ng-if="MemberDetailsUpdate != '暂无数据'">
    <div class="modal show-hide a3" id="myModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content a17">
                <div style="border: none;padding-left: 30px;padding-right: 30px;" class="modal-header"  >
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>

                    <h3 class="text-center a18" id="myModalLabel">
                        修改会员信息
                    </h3>
                    <div>
                    </div>
                    <form name="myForm">
                        <input ng-model="MemberData._csrf" id="_csrf" type="hidden"
                               name="<?= \Yii::$app->request->csrfParam; ?>"
                               value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <input ng-model="MemberDetailsUpdate.id" type="hidden">
                        <div class="form-group a3">
                            <label style="font-size: 14px;" for="exampleInputName2">姓名</label>
                            <input ng-model="MemberDetailsUpdate.name" name="name" required ng-minlength="2"
                                   ng-maxlength="10" ng-pattern="/^[\u3400-\u9FFF]+|([a-zA-Z]+)+$/"
                                   style="font-size: 12px;" type="text" class="form-control"
                                   id="exampleInputName2" placeholder="">
                                    <span class="text-danger help-block m-b-none" ng-show="myForm.name.$error.required">
                                        <i class="fa fa-info-circle"></i>
                                        请输入姓名（2-10个中文或英文字符）
                                    </span>
                                    <span class="text-danger help-block m-b-none"
                                          ng-show="myForm.name.$error.minlength || myForm.name.$error.maxlength || myForm.name.$error.pattern ">
                                         <i class="fa fa-info-circle"></i>
                                        姓名由2-10个中文或英文字符组成
                                    </span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName3" class="a19">性别</label>
                            <select ng-model="MemberDetailsUpdate.sex" required style="font-size: 12px;"
                                    class="form-control actions">
                                <option value="" selected disabled>请选择性别</option>
                                <option value="1">男</option>
                                <option value="2">女</option>
                            </select>
                                    <span ng-if="!MemberDetailsUpdate.sex" class="text-danger help-block m-b-none">
                                        <i class="fa fa-info-circle"></i>
                                        请选择性别
                                    </span>
                        </div>
                        <div class="form-group">
                            <label class="a19" for="exampleInputName2">出生年月</label>
                            <div class="input-append date form-group" id="" data-date="12-02-2012"
                                 data-date-format="dd-mm-yyyy" start-date="12-02-1900">
                                <input class="form-control" id="bothDate" style="font-size: 12px;"
                                       type="text" placeholder="请选择出生日期"
                                       ng-model="MemberDetailsUpdate.birth_date">
                                <span class="add-on"><i class="icon-th"></i></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="a19" for="exampleInputName2">电话</label>
<!--                            required ng-pattern="/^1[34578]\d{9}$/"-->
                            <input ng-model="MemberDetailsUpdate.mobile" autocomplete="off" name="mobile"
                                   style="font-size: 12px;" type="text" class="form-control" id="exampleInputName2" placeholder="">
<!--                                   <span class="text-danger help-block m-b-none"-->
<!--                                         ng-show="myForm.mobile.$error.required">-->
<!--                                        <i class="fa fa-info-circle"></i>-->
<!--                                        请输入手机号 只支持11位数字手机号-->
<!--                                    </span>-->
<!--                                    <span class="text-danger help-block m-b-none"-->
<!--                                          ng-show="myForm.mobile.$error.pattern ">-->
<!--                                        <i class="fa fa-info-circle"></i>-->
<!--                                        手机号 格式不正确-->
<!--                                    </span>-->
                        </div>
                        <div style="position: relative;padding-top: 20px;">
                            <div class="form-group" style="display: inline-block;">
                                <img id="imgBoolTrue" ng-src="/plugins/personal/img/u2063.png" class='photo mL120W100H100 imgBoolTrue' style="width: 80px;height: 80px">
                                <img id="imgBoolFalse"  class='photo mL120W100H100  imgBoolFalse' style="width: 100px;height: 100px">
                            </div>
                            <div style="display: inline-block; margin-left: 15px; margin-bottom: -21px;">
                                 <button class="btn btn-info" type="button" style="margin-bottom: -45px;" ng-click="memberDeleteFingerprint(id)">删除指纹</button>
                            </div>
                            <div class="input-file"
                                 style="margin:  0 auto;width: 100px;height: 100px;position: relative; cursor: pointer;border: 1px dashed #ddd;margin-top: -115px;margin-left: 282px">
                                <p style="margin-left: 0px;width: 100%;height: 100%;line-height: 72px;font-size: 50px;"
                                   class="text-center">+</p>
                            </div>
                            <div id="fpRegisterDiv"   style="display: inline; height: 80px;width:80px;position: absolute;top: 20px;left: 295px;">
                                <a id="fpRegister"
                                   onclick='submitRegister("指纹", "指纹数:", "确认保存当前修改吗？", "驱动下载", false)'
                                   title="请安装指纹驱动或启动该服务" class="showGray"
                                   onmouseover="this.className='showGray'">请安装指纹驱动</a>
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="exampleInputName3" class="a19">证件类型</label>
                                <select ng-model="MemberDetailsUpdate.document_type" required style="font-size: 12px;" class="form-control actions" ng-change="documentTypeChange()">
                                    <option value="">请选择证件类型</option>
                                    <option value="1">身份证</option>
                                    <option value="2">居住证</option>
                                    <option value="3">签证</option>
                                    <option value="4">护照</option>
                                    <option value="5">户口本</option>
                                    <option value="6">军人证</option>
                                </select>
                            <label class="a19" for="exampleInputName2">证件号</label>
                            <input ng-model="MemberDetailsUpdate.id_card"
                                   ng-change="getMemberIdCard(MemberDetailsUpdate.id,MemberDetailsUpdate.id_card)"
                                   autocomplete="off" name="id_card"
                                   style="font-size: 12px;" type="text" class="form-control"
                                   id="exampleInputName2" placeholder="">
<!--                                    <span class="text-danger help-block m-b-none"-->
<!--                                          ng-show=" myForm.id_card.$error.pattern ">-->
<!--                                        <i class="fa fa-info-circle"></i>-->
<!--                                        证件号 格式不正确-->
<!--                                    </span>-->
<!--                                    <span ng-if="IdCard != true" class="text-danger help-block m-b-none"-->
<!--                                          ng-show="IdCardStatus">-->
<!--                                        <i class="fa fa-info-circle"></i>-->
<!--                                        {{IdCard}}-->
<!--                                    </span>-->
                            <div class="form-group a3">
                                <label style="font-size: 14px;" for="exampleInputName2">家庭住址</label>
                                <input ng-model="MemberDetailsUpdate.family_address" name="name"
                                       style="font-size: 12px;" type="text" class="form-control"
                                       id="exampleInputName2" placeholder="">
                            </div>
                            <div class="form-group a20">
                                <label class="a19" for="exampleInputName7">会籍顾问</label>
                                <select class="form-control fl a21"
                                        ng-model="MemberDetailsUpdate.counselor_id">
                                    <option value="">--请选择顾问--</option>
                                    <option value="{{theAdviser.id}}" ng-repeat="theAdviser in allAdviser">
                                        {{theAdviser.name}}
                                    </option>
                                </select>
                            </div>
<!--                            <div class="form-group a20" style="margin-top: 20px;">-->
<!--                                <label class="a19">IC绑定</label>-->
<!--                                <input type="text" class="form-control" ng-model="MemberDetailsUpdate.memberDetails.ic_number"/>-->
<!--                            </div>-->
                            <div class="form-group a20" style="margin-top: 50px;">
                                <label class="a19" for="exampleInputName7">上传头像</label>
                                <div class="form-group a20">
                                    <img id="imgTrue" class="imgTrue" ng-if="MemberDetailsUpdate.pic == null || MemberDetailsUpdate.pic == ''" ng-src="/plugins/checkCard/img/11.png" width="100px"
                                         height="100px" style="border-radius: 50%;border: 1px solid #000">
                                    <img id="imgFalse" class="imgFalse" ng-if="MemberDetailsUpdate.pic != null && MemberDetailsUpdate.pic != ''"
                                         ng-src="{{MemberDetailsUpdate.pic}}" width="100px" height="100px"
                                         style="border-radius: 50%">
                                </div>
                                <div style="display: inline-block; margin-left: 15px; margin-bottom: -21px;">
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DELMEMBERPIC')) { ?>
                                        <button class="btn btn-info" type="button" style="margin-bottom: -45px;margin-left: 105px;margin-top: -90px" ng-click="memberDeletePhoto(id)">删除头像</button>
                                    <?php } ?>
                                </div>
                                <div class="input-file ladda-button btn ng-empty uploader" id="imgFlagClass"
                                     ngf-drop="uploadCover($file,'update')"
                                     ladda="uploading"
                                     ngf-select="uploadCover($file,'update')"
                                     ngf-accept="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                                     ngf-pattern="'image/png,image/gif,image/jpg,image/jpeg,image/PNG,image/GIF,image/JPG,image/JPEG'"
                                >
                                    <p class="text-center addCss">+</p>
                                </div>
                            </div>
                            <label class="a19" for="exampleInputName7">会员备注</label>
                            <textarea name="" id="" style="resize: none;width: 100%;height:120px;" ng-model="MemberDetailsUpdate.note"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary backBtn a3" data-dismiss="modal"
                                aria-hidden="true">&nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp
                        </button>
                        <button ng-click="MemberInfo()"
                                type="button" class="btn btn-success pull-right successBtn a3">
                            &nbsp&nbsp&nbsp&nbsp确定&nbsp&nbsp&nbsp&nbsp
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--会员卡信息修改-->
<div style="margin-top: 20px;" class="modal fade" id="myModals6" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div style="padding-bottom: 20px;margin-top: 200px;" class="modal-content clearfix">
            <div style="border: none;" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>

                <h5 style="margin-left:10px;text-align: center;font-size: 20px;">会员卡信息修改</h5>
                <form>
                    <div style="margin-top: 10px;" class="form-group">
                        <label style="font-size: 14px;" for="exampleInputName3">卡名称:</label>
                        <input id="_csrf" type="hidden"
                               name="<?= \Yii::$app->request->csrfParam; ?>"
                               value="<?= \Yii::$app->request->getCsrfToken(); ?>">
                        <input type="hidden" value="{{cardDetail.id}}" id="memCardId">
                        <input type="hidden" value="{{cardDetail.member_id}}" id="memberId">
                        <span>{{cardDetail.card_name}}</span>
                    </div>
                    <div style="margin-top: 10px;" class="form-group">
                        <!--                                <input type="text" class="form-control"  id="exampleInputName6" ng-model="cardDetail.invalid_time" placeholder="请输入有效期">-->
                        <label style="font-size: 14px;position: relative;top: 13px;left: -196px"
                               for="exampleInputName6">失效日期</label>
                        <div style="float: left;position: relative;" class="input-daterange input-group cp"
                             id="container">
                            <b><input type="text" id="datetimeEnd" class="form-control" name="" placeholder="结束日期"
                                      style="left:112px;top: 7px;"></b>
                        </div>
                    </div>
                    <div style="margin-top: 10px;" class="form-group">
                        <!--                                ng-model="cardDetail.employeeName"-->
                        <label style="font-size: 14px;position: relative;left: -310px;top: 12px;"
                               for="">销售顾问</label>
                        <select class=" fl"
                                style="padding: 4px 12px;width: 201px;margin-left: 111px;margin-top: 9px; overflow: auto;border: solid 1px #cfdadd;"
                                id="coachId" ng-model="adviser">
                            <option value="">请选择</option>
                            <option value="{{theAdviser.id}}" ng-repeat="theAdviser in allAdviser">
                                {{theAdviser.name}}
                            </option>
                        </select>
                    </div>
                </form>
                <button style="margin-top: 20px;" type="submit" class="btn btn-primary backBtn">
                    &nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp
                </button>
                <button style="margin-top: 20px;" ng-click="refer()" type="submit"
                        class="btn btn-success pull-right successBtn">&nbsp&nbsp&nbsp&nbsp完成&nbsp&nbsp&nbsp&nbsp
                </button>
            </div>
        </div>
    </div>
</div>
<!--私教课修改-->
<div style="margin-top: 20px;" class="modal fade" id="myModals7" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div style="padding-bottom: 20px;" class="modal-content clearfix">
            <div style="border: none;" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>

                <h5 style="margin-left:10px;text-align: center;font-size: 20px;">私教课程信息修改</h5>
                <form>
                    <div style="margin-top: 10px;" class="form-group">
                        <label style="font-size: 14px;" for="exampleInputName3">课程名称</label>
                        <input type="text" class="form-control" id="exampleInputName3" placeholder="请输入课程名称">
                    </div>
                    <div style="margin-top: 10px;" class="form-group">
                        <label style="font-size: 14px;" for="exampleInputName5">办理日期</label>
                        <input type="text" class="form-control" id="exampleInputName5" placeholder="请输入办理日期">
                    </div>
                    <div style="margin-top: 10px;" class="form-group">
                        <label style="font-size: 14px;" for="exampleInputName6">到期日期</label>
                        <input type="text" class="form-control" id="exampleInputName6" placeholder="请输入到期日期">
                    </div>
                    <div style="margin-top: 10px;" class="form-group">
                        <label style="font-size: 14px;" for="exampleInputName8">办理私教</label>
                        <input type="text" class="form-control" id="exampleInputName8" placeholder="请输入办理私教">
                    </div>
                </form>
                <button style="margin-top: 20px;" type="submit" class="btn btn-primary backBtn">
                    &nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp
                </button>
                <button style="margin-top: 20px;" type="submit" class="btn btn-success pull-right successBtn">
                    &nbsp&nbsp&nbsp&nbsp完成&nbsp&nbsp&nbsp&nbsp
                </button>
            </div>
        </div>
    </div>
</div>
<!--柜子信息修改-->
<div style="margin-top: 20px;" class="modal fade" id="myModals8" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div style="padding-bottom: 20px;margin-top: 200px;" class="modal-content clearfix">
            <div style="border: none;" class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>

                <h5 style="margin-left:10px;text-align: center;font-size: 20px;">柜子信息修改</h5>
                <form>
                    <div style="margin-top: 10px;" class="form-group">
                        <label style="font-size: 14px;" for="exampleInputName3">柜子名称</label>
                        <input type="text" class="form-control" id="exampleInputName3" placeholder="请输入柜子名称">
                    </div>
                    <div style="margin-top: 10px;" class="form-group">
                        <label style="font-size: 14px;" for="exampleInputName5">租用天数</label>
                        <input type="text" class="form-control" id="exampleInputName5" placeholder="请输入租用天数">
                    </div>
                    <div style="margin-top: 10px;" class="form-group">
                        <label style="font-size: 14px;" for="exampleInputName6">到期日期</label>
                        <input type="text" class="form-control" id="exampleInputName6" placeholder="请输入到期日期">
                    </div>
                    <div style="margin-top: 10px;" class="form-group">
                        <label style="font-size: 14px;" for="exampleInputName7">金额</label>
                        <input type="text" class="form-control" id="exampleInputName7" placeholder="请输入金额">
                    </div>
                    <div style="margin-top: 10px;" class="form-group">
                        <label style="font-size: 14px;" for="exampleInputName8">经办人</label>
                        <input type="text" class="form-control" id="exampleInputName8" placeholder="请输入经办人">
                    </div>
                </form>
                <button style="margin-top: 20px;" type="submit" class="btn btn-primary backBtn">
                    &nbsp&nbsp&nbsp&nbsp返回&nbsp&nbsp&nbsp&nbsp
                </button>
                <button style="margin-top: 20px;" type="submit" class="btn btn-success pull-right successBtn">
                    &nbsp&nbsp&nbsp&nbsp完成&nbsp&nbsp&nbsp&nbsp
                </button>
            </div>
        </div>
    </div>
</div>