<!--私教购买-->
<div class="modal fade" id="privateBuyModal" tabindex="-1" role="dialog" style="overflow-y: auto;">
    <div class="modal-dialog" role="document" style="width: 720px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">私教课程购买</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-5 text-left"
                             style="border-right: solid 1px #e5e5e5;padding-bottom: 10px;">
                            <div class='a55'>
                                <img ng-src="{{aboutClassData.pic}}" class="a53" ng-if="aboutClassData.pic!=null"
                                     style="border-radius: 50%">
                            </div>
                            <div class="a54">
                                <img src="/plugins/checkCard/img/11.png" class="a53"
                                     ng-if="aboutClassData.pic==null">
                            </div>
                            <div style="margin-top: 20px;">
                                <ul class="MemberMess">
                                    <li><h4>会员姓名:<span style="font-size: 14px;">{{aboutClassData.name}}</span></h4>
                                    </li>
                                    <li>会员性别:<span>{{aboutClassData.sex == 1 ? "男":"女"|noData:''}}</span></li>
                                    <li>会员年龄:<span>{{aboutClassData.birth_date | birth | noData:''}}</span></li>
                                    <li>会员生日:<span>{{aboutClassData.birth_date | noData:''}}</span></li>
                                    <li>证件号:<span>{{aboutClassData.id_card | noData:''}}</span></li>
                                    <li>手机号码:<span ng-if="aboutClassData.mobile != 0">{{aboutClassData.mobile | noData:''}}</span><span ng-if="aboutClassData.mobile == 0 || aboutClassData.mobile == '' || aboutClassData.mobile == null || aboutClassData.mobile == undefined">暂无数据</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 col-sm-offset-1" style="color: #999999;font-size: 12px;">
                            <div>
                                <ul class="" style="display: flex;align-items: center;">
                                    <li class=""><span class="red">*</span>私教产品</li>
                                    <li class=" mL20">
                                        <div class="clearfix a56" style="">
                                            <div class="fl a57">
                                                <img ng-src="{{blendPic}}" width="50px" height="100%" alt=""
                                                     ng-if="blendPic != null">
                                            </div>

                                            <div ng-click="buyPrivateCourse()" class="fl text-center cp"
                                                 style="width: 115px; height: 50px;line-height: 50px;text-align: center;">
                                                {{trues == true ? blendName:"购买私教产品"}}
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div style="margin-top: 10px;">
                                <ul class="" style="display: flex;align-items: center;">
                                    <li><span class="red">*</span>课程数量</li>
                                    <li class=" mL20" style="width: 170px;">
                                        <input type="number" class="form-control" placeholder="请输入课程数量"
                                               ng-model="dataCompleteBuy.numberOfCourses"
                                               ng-blur="courseQuantity(dataCompleteBuy.numberOfCourses)">
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li><span class="red">*</span><span>原价金额</span></li>
                                    <li class=" mL20" style="width: 170px;text-align: center;margin-left: 20px;">
                                        <input type="number" min="0" class="form-control" id="allMoneyChange" ng-change="allMoneyChange(blendMoney)" placeholder="" ng-model="blendMoney">
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li><span class="red">*</span>付款方式</li>
                                    <li class=" mL20" style="width: 170px;">
                                        <select id="selectColor" class="form-control cp " ng-change="gatheringWay(paymentTerm)" ng-model="paymentTerm" style="padding: 4px 12px;">
                                            <option  value="">选择付款方式</option>
                                            <option  value="1">全款</option>
                                            <option  value="2">定金</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
<!--                            <div class="mT10">-->
<!--                                <label class="col-sm-4 control-label label-words">-->
<!--                                    <span class="text-danger">*</span>-->
<!--                                    定金金额-->
<!--                                </label>-->
<!--                                <div class="col-sm-6" style="margin-left: 16px">-->
<!--                                    <select class="form-control select2 buyCardDepositSelect2" multiple="multiple" ng-change="buyCardDepositSelectChange()"ng-model="buyCardDepositSelect">-->
<!--                                        <option ng-repeat="zzz in buyCardDepositSelectData" value="{{zzz.id}}" data-price="{{zzz.price}}">定金：{{zzz.price}}元</option>-->
<!--                                    </select>-->
<!--                                    <span>剩余购卡定金{{surplusPrice}}元</span>-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="mT10">
                                <ul class="a58">
                                    <li><span class="red">*</span>定金金额</li>
                                    <li class=" mL20" style="width: 170px;">
                                        <select style="width: 170px;" class="js-example-basic-multiple js-states form-control moneySelect" multiple="multiple" ng-change="buyClassDepositSelectChange()"ng-model="buyClassDepositSelect">
                                            <option ng-repeat="zzz in buyClassDepositSelectData" value="{{zzz.id}}" data-price="{{zzz.price}}">定金：{{zzz.price}}元</option>
                                        </select>
                                       <div>剩余购课定金{{classSurplusPrice}}元</div>
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li><span class="red">*</span>缴费日期</li>
                                    <li class=" mL20" style="width: 170px;">
                                        <input type="text" class="form-control" id="registerDate"
                                               data-date-format="yyyy-mm-dd hh:ii" placeholder="请选择登记日期"
                                               ng-model="dataCompleteBuy.renewalDate">
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li><span class="red">*</span>销售私教</li>
                                    <li class=" mL20" style="width: 170px;">
                                        <select id="selectColor" class="form-control cp "
                                                ng-change="privateCoachs(dataCompleteBuy.sellingPrivateEducation)"
                                                ng-model="dataCompleteBuy.sellingPrivateEducation"
                                                style="padding: 4px 12px;">
                                            <option value="" ng-selected>请选择销售私教</option>
                                            <option value="{{w.id}}" ng-repeat="w in privateCoach">{{w.name}}
                                            </option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li><span class="red">*</span>私教渠道</li>
                                    <li class=" mL20" style="width: 170px;">
                                        <select id="marketingChannel" class="form-control cp "
                                                ng-model="dataCompleteBuy.distributionChannel"
                                                style="padding: 4px 12px;" >
                                            <option value="">请选择私教渠道</option>
                                            <option ng-selected="addSellSourceId == w.id" data-module="{{w.id}}" value="{{w.value}}" ng-repeat="w in memberSearchData">{{w.value}}</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58 " style="display: flex;justify-content: center;">
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'CUSTOMADD')) { ?>
                                    <button class="btn btn-primary btn-sm" ng-click="addSellSource()">自定义添加</button>
                                    <?php } ?>
                                    <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DELETESOURCE')) { ?>
                                    <button class="btn btn-danger btn-sm" ng-click="deleteTheSource()" style="margin-left: 10px;">删除选中来源</button>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li>折扣选择</li>
                                    <li class="mL20" style="width: 170px;">
                                        <select class="form-control cp" style="padding: 4px 12px;" ng-model="buyClassDiscount" ng-change="buyClassDiscountChange(buyClassDiscount)">
                                            <option value="">请选择折扣</option>
                                            <option ng-repeat="buyDiscount in getBuyCardDiscountList" value="{{buyDiscount}}">{{buyDiscount + '&nbsp;折'}}</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
<!--                            <div class="mT10">-->
<!--                                <ul class="a58">-->
<!--                                    <li><span class="red">*</span>支付方式</li>-->
<!--                                    <li class=" mL20" style="width: 170px;">-->
<!--                                        <select id="selectColor" class="form-control cp "-->
<!--                                                ng-model="dataCompleteBuy.paymentMethod" style="padding: 4px 12px;">-->
<!--                                            <option value="">请选择支付方式</option>-->
<!--                                            <option>微信</option>-->
<!--                                            <option>支付宝</option>-->
<!--                                            <option>现金</option>-->
<!--                                            <option>pos机</option>-->
<!--                                            <option>建设分期</option>-->
<!--                                            <option>广发分期</option>-->
<!--                                            <option>招行分期</option>-->
<!--                                            <option>借记卡</option>-->
<!--                                            <option>贷记卡</option>-->
<!--                                        </select>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </div>-->
<!--                            <div class="mT10">-->
<!--                                <ul class="a58">-->
<!--                                    <li><span class="red">*</span>收款方式</li>-->
<!--                                    <li class=" mL20" style="width: 170px;">-->
<!--                                        <select id="selectColor" class="form-control cp " ng-change="gatheringWay(paymentTerm)" ng-model="paymentTerm" style="padding: 4px 12px;">-->
<!--                                            <option  value="">选择付款方式</option>-->
<!--                                            <option  value="1">全款</option>-->
<!--                                            <option ng-if="subscription123 != null" value="2">押金</option>-->
<!--                                        </select>-->
<!--                                    </li>-->
<!--                                </ul>-->
<!--                            </div>-->
                            <div class="form-group mt20 buyClassMethodBox">
                                <div class="col-sm-12 addBuyClassElement removeDiv1" style="padding: 0;">
                                    <label class="col-sm-3 pd0 control-label label-words" style="padding-top: 5px;">
                                        <span class="red">*</span>付款途径
                                    </label>
                                    <div class="col-sm-9 pd0">
                                        <select class="buyClassMethodSelect">
                                            <option value="">请选择</option>
                                            <option value="1">现金</option>
                                            <option value="3">微信</option>
                                            <option value="2">支付宝</option>
                                            <!--                                        <option value="4" >pos机</option> -->
                                            <option value="5" >建设分期</option>
                                            <option value="6" >广发分期</option>
                                            <option value="7" >招行分期</option>
                                            <option value="8" >借记卡</option>
                                            <option value="9" >贷记卡</option>
                                        </select>
                                        <input type="text" class="buyClassPrice" ng-change="buyClassInputChange()" ng-model="buyClassInput" style="border-color: #0a0a0a;">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt20 buyClassMethodBtnBox text-center">
                                <button class="btn btn-default buyClassMethodButton" id="buyClassMethod" venuehtml ng-click="addBuyClassMethod()">新增付款途径</button>
                                总金额：<span>{{allBuyClassPrice}}</span>元
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li><span class="red">*</span>领取赠品</li>
                                    <li class=" mL20" style="width: 170px;">
                                        <select id="selectColor" class="form-control cp " style="padding: 4px 12px;" ng-model="giftStatus">
                                            <option value="">请选择</option>
                                            <option value="2">已领取</option>
                                            <option value="1">未领取</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li style="margin-bottom: 60px;"><span class="red" style="opacity: 0;">*</span><span>私课备注</span></li>
                                    <li class=" mL20" style="width: 170px;text-align: center;margin-left: 20px;">
                                        <textarea class="form-control" ng-model="buyProNote" style="overflow-y: auto;height: 100px;margin-top: 10px;resize: none;border-color: #0a0a0a;"></textarea>
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10" style="text-align: right;" >
                                <ul >
                                    <li class=" mL20" style="margin-right: 60px;">
                                        <div>
                                                <span>有效期: <b ng-if="monthUpNums && chargeType=='alone'"> {{monthUpNums}} 月</b>
                                                    <b ng-if="monthUpNums && chargeType=='many'"> {{monthUpNums}}</b>
                                                    <b ng-if="!monthUpNums"> 暂无数据</b>
                                                </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10" style="text-align: right;">
                                <ul >
                                    <li class=" mL20" style="margin-right: 60px;">
<!--                                        <div>-->
<!--                                            <span>定金: <b class="subcriptionB">{{subscription123 != null ?subscription123 : 0}}元</b></span>-->
<!--                                            <span style="margin-left: 10px;">抵劵: <b class="voucherB">{{voucher123 != null? voucher123:0 }}</b>元</span>-->
<!--                                        </div>-->
                                        <div style="color: #f9d21a;">
<!--                                            <span style="font-size: 16px;">应付金额:<span class="payCouserMoney"></span>元</span>-->
                                            <span style="font-size: 16px;">应付金额:{{PayMoney}}元</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="clearfix mT10 text-center">
                                <button style="width: 100px;" ladda="privateLessonBuyButtonFlag" ng-click="completeBuy()" id="completeBuy" type="button"
                                        class="btn btn-success  ">完成
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--分配私教模态框-->
<div class="modal fade" id="distribution" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" >
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="privateEducationClose()"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">分配私教</h4>
            </div>
            <div class="modal-body" style="padding-top: 50px;">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12 col-sm-offset-1" style="color: #999999;font-size: 12px;">
                            <div style="margin-top: 10px;margin-left: 100px">
                                <ul class="" style="display: flex;align-items: center;">
                                    <li><span class="red">*</span>选择卡种</li>
                                    <li class=" mL20" style="width: 170px;">
                                        <select class="form-control cp a67" ng-change="privateEducationSelectCardChange(privateEducationSelectValue)" ng-model="privateEducationSelectValue" style="margin-left: 0;" id="privateEducationSelectValue">
                                            <option value="">选择卡种</option>
                                            <option value="{{w}}"
                                                    ng-if="w.usage_mode != '2'"
                                                    ng-repeat="w in privateEducationSelectCardData">{{w.card_name}}</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div style="margin-top: 20px;margin-left: 100px">
                                <ul class="" style="display: flex;align-items: center;">
                                    <li><span class="red">*</span>赠送类型</li>
                                    <li class=" mL20" style="width: 170px;">
                                        <select class="form-control pdt4" ng-change="courseTypeSelect(couresType)" ng-model="couresType">
                                            <option value="">请选择</option>
                                            <option value="pt">PT</option>
                                            <option value="hs">HS</option>
                                            <option value="birth" ng-if="memberBirthday != ''">生日课</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div style="margin-top: 20px;margin-left: 100px">
                                <ul class="" style="display: flex;align-items: center;">
                                    <li><span class="red">*</span>课程名称</li>
                                    <li class=" mL20" style="width: 170px;">
                                        <select class="form-control pdt4" id="couresNameId" ng-change="courseTypeSelectChange()" ng-model="couresNameId">
                                            <option value="">选择课程</option>
                                            <option value="{{couserClassNameId}}">{{couserClassNameItemVal}}</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div style="margin-top: 20px;">
                                <ul class="" style="display: flex;align-items: center;margin-left: 100px">
                                    <li class=""><span class="red">*</span>上课教练</li>
                                    <li class=" mL20">
                                        <div class="clearfix a56" style="">
                                            <div class="fl a57">
                                                <img ng-if="privateEducationSelectListPic != null && privateEducationSelectListPic != ''" ng-src="{{privateEducationSelectListPic}}" width="50px" height="100%" alt="">
                                                <img ng-if="privateEducationSelectListPic == null || privateEducationSelectListPic== '' " src="/plugins/user/images/noPic.png" width="50px" height="100%" alt="">
                                            </div>

                                            <div ng-click="distributionTeacher()" class="fl text-center cp"
                                                 style="width: 115px; height: 50px;line-height: 50px;text-align: center;">
                                                <b ng-if="privateEducationSelectListName != null">{{privateEducationSelectListName}}</b>
                                                <b ng-if="privateEducationSelectListName == null">点击选择教练</b>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class=" mT20 text-center col-sm-12">
                                <button style="width: 100px;margin-left: -100px;" ladda="distributionPtButtonFlag"  id="completeBuy" ng-click="privateEducationSelectOk()" type="button"
                                        class="btn btn-success " style="margin-top: 30px">完成
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--赠送模态框-->
<div class="modal fade" id="presenterModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 720px;">
        <div class="modal-content clearfix" style="background-color: #FFF;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" ng-click="privateEducationClose()"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">赠送</h4>
            </div>
            <div class="modal-body" style="padding-top: 50px;">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-offset-2 col-sm-8 " style="color: #999999;font-size: 12px;">
                            <div style="margin-top: 10px;margin-left: 100px">
                                <ul class="" style="display: flex;align-items: center;">
                                    <li><span class="red">*</span>赠送类别</li>
                                    <li class=" mL20" style="width: 200px;">
                                        <select class="form-control cp a67 selectCss" style="margin-left: 0;" ng-change="giveTypeSelect(giveType123)" ng-model="giveType123">
                                            <option value="">选择赠送类别</option>
                                            <!--                                                <option value="1" >收费课</option>-->
                                            <!--                                                <option value="2" >免费课</option>-->
                                            <!--<option value="3" >生日课</option>-->
                                            <option value="4" >购课赠送</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div ng-if="giveType123 != 4" style="margin-top: 10px;margin-left: 100px">
                                <ul class="" style="display: flex;align-items: center;">
                                    <li><span class="red">*</span>会员卡</li>
                                    <li class=" mL20" style="width: 200px;">
                                        <select class="form-control cp a67 selectCss" id="giveCard123" ng-model="giveCard123">
                                            <option value="">请选择卡种</option>
                                            <option value="{{w.id}}" ng-repeat="w in privateEducationSelectCardData">{{w.card_name}}</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div ng-if="giveType123 != 4" style="margin-top: 10px;">
                                <ul class="" style="display: flex;align-items: center;margin-left: 100px">
                                    <li class=""><span class="red">*</span>上课教练</li>
                                    <li class=" mL20">
                                        <div class="clearfix a56" style="width: 200px;">
                                            <div class="fl a57">
                                                <img ng-if="privateEducationSelectListPic != null && privateEducationSelectListPic != ''" ng-src="{{privateEducationSelectListPic}}" width="50px" height="100%" alt="">
                                                <img ng-if="privateEducationSelectListPic == null || privateEducationSelectListPic== '' " src="/plugins/user/images/noPic.png" width="50px" height="100%" alt="">
                                            </div>

                                            <div ng-click="distributionTeacher()" class="fl text-center cp"
                                                 style="width: 145px; height: 50px;line-height: 50px;text-align: center;">
                                                <b ng-if="privateEducationSelectListName != null">{{privateEducationSelectListName}}</b>
                                                <b ng-if="privateEducationSelectListName == null">点击选择教练</b>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div ng-if="giveType123 == 4" style="margin-top: 10px;margin-left: 100px">
                                <ul class="" style="display: flex;align-items: center;">
                                    <li><span class="red">*</span>选择教练</li>
                                    <li class=" mL20" style="width: 200px;">
                                        <select name="" id="" class="form-control selectCss giveCourseCoach">
                                            <option value="">请选择教练</option>
                                            <option ng-repeat="giveCourseCoachId in giveCourseCoachIdList" value="{{giveCourseCoachId.id}}">{{giveCourseCoachId.name}}</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div ng-if="giveType123 == 4" style="margin-top: 10px;">
                                <ul class="" style="display: flex;align-items: center;margin-left: 100px">
                                    <li class=""><span class="red">*</span>选择私课</li>
                                    <li class=" mL20">
                                        <div class="clearfix a56" style="width: 200px;">
                                            <div class="fl a57">
                                                <img ng-if="privateEducationSelectListPic == null || privateEducationSelectListPic== '' " src="/plugins/user/images/noPic.png" width="50px" height="100%" alt="">
                                            </div>

                                            <div ng-click="distributionChargeClass()" class="fl text-center cp"
                                                 style="width: 145px; height: 50px;line-height: 50px;text-align: center;">
                                                <b ng-if="privateEducationSelectListName != null">{{privateEducationSelectListName}}</b>
                                                <b ng-if="privateEducationSelectListName == null">点击选择课程</b>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div ng-if="giveType123 != 4" style="margin-top: 10px;margin-left: 100px">
                                <ul class="" style="display: flex;align-items: center;">
                                    <li><span class="red">*</span>课程名称</li>
                                    <li class=" mL20" style="width: 200px;">
                                        <select class="form-control selectCss" ng-change="giveCourseTypeSelectChange(giveCourseName123)" ng-model="giveCourseName123">
                                            <option value="">选择课程</option>
                                            <option value="{{w.id}}" ng-repeat="w in giveCourseLists123">{{w.name}}</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div style="margin-top: 10px;margin-left: 100px">
                                <ul class="" style="display: flex;align-items: center;">
                                    <li><span class="red">*</span>课程节数</li>
                                    <li class=" mL20" style="width: 200px;">
                                        <input type="number" min="1" ng-model="giveCourseNum123" class="form-control" placeholder="请输入赠送节数">
                                    </li>
                                </ul>
                            </div>
                            <div ng-if="giveType123 != 4" style="margin-top: 10px;margin-left: 100px">
                                <ul class="" style="display: flex;align-items: center;">
                                    <li><span class="red">*</span>课程有效期</li>
                                    <li  style="width: 200px;margin-left: 8px;">
                                        <div  class=" input-daterange input-group"  style="width: 100%;">
                                            <input type="text"  readonly name="reservation" id="validityDateTime123" class=" form-control " value="" placeholder="选择时间"/>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="clearfix mT10 text-center">
                            <button ladda="givePtButtonFlag"  id="completeBuy" ng-click="presenterSubmit()" type="button"
                                    class="btn btn-success btn-sm  width100" style="margin-top: 30px">完成
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--自定义销售来源-->
<div class="modal fade" tabindex="-1" id="sellSource1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">自定义销售渠道</h4>
            </div>
            <div class="modal-body" style="display: flex;justify-content: center;margin-top: 20px;">
                <input type="text" class="form-control" id="recipient-name" placeholder="请输入自定义销售渠道名称" ng-model="customSalesChannels" style="width: 60%;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-success" ng-click="confirmAdd(customSalesChannels)">确定</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!--IC卡绑定-->
<div class="modal fade" tabindex="-1" id="ICCardBindingModal" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">IC卡绑定</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <p>已绑定IC卡信息</p>
                        <p>IC卡号：
                            <span ng-if="icCardNumberInfo.custom_ic_number != '' && icCardNumberInfo.custom_ic_number != null && icCardNumberInfo.status == '1'">{{icCardNumberInfo.custom_ic_number}}</span>
                            <span ng-if="icCardNumberInfo.custom_ic_number == '' || icCardNumberInfo.custom_ic_number == null || icCardNumberInfo.status == '2'">暂无数据</span>
                        </p>
                    </div>
                    <div class="col-md-7" style="border-left: 1px solid #cecece">
                        <label for="">请刷IC卡：</label>
                        <input type="number" class="form-control" placeholder="请响应IC卡设备用于绑定" id="ICCardNumberInput" ng-model="ICCardNumber" style="margin: 10px 0!important;">
                        <br>
                        <label for="">请输入金额：</label>
                        <input type="text" class="form-control ICCardChargeInput" placeholder="请输入金额(手环工本费)" ng-model="ICCardCharge">
                        <div style="margin-top: 20px;text-align: right">
                            <button type="button" class="btn btn-info" ng-disabled="icCardNumberInfo.custom_ic_number == '' || icCardNumberInfo.custom_ic_number == null || icCardNumberInfo.status == '2'" ng-click="unbundleBtn(icCardNumberInfo.memberId)">解绑</button>
                            <button type="button" class="btn btn-success" ng-click="ICCardBindingChange()">绑定</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
               <!-- <button type="button" class="btn btn-success" ng-click="ICCardBindingChange()">确定</button>-->
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
<!--更换教练-->
<div class="modal fade" id="changeMemberCoachModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">更换教练</h4>
            </div>
            <div class="modal-body">
                <div class="row m25">
                    <div class="col-sm-4 text-right changeCoachLabel">
                            <span class="red">*</span>选择教练
                    </div>
                    <div class="col-sm-8">
                        <select id="changeCoachId" ng-model="changeCoachId" ng-init="changeCoachId = ''">
                            <option value="">请选择教练</option>
                            <option ng-repeat="coachLists in changeMemberCoachList" value="{{coachLists.id}}">{{coachLists.name}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" ng-click="changeMemberCoach()">保存</button>
            </div>
        </div>
    </div>
</div>
<!--更换销售-->
<div class="modal fade" id="changeMemberSellerModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">更换销售</h4>
            </div>
            <div class="modal-body">
                <div class="row m25">
                    <div class="col-sm-4 text-right changeSellerLabel">
                        <span class="red">*</span>选择销售
                    </div>
                    <div class="col-sm-8">
                        <select id="changeSellerId" ng-modal="changeSellerId" ng-init="changeSellerId = ''">
                            <option value="">请选择销售</option>
                            <option ng-repeat="sellerLists in changeMemberSellerList" value="{{sellerLists.id}}">{{sellerLists.name}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" ng-click="changeMemberSeller()">保存</button>
            </div>
        </div>
    </div>
</div>
<!--批量分配选择私教-->
<div class="modal fade" id="batchDistributionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">分配私教</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12" style="margin-top: 30px;">
                        <div class="col-sm-4 text-right" style="font-size: 16px;height: 30px;line-height: 30px;">
                            <span class="red">*</span>选择私教课：
                        </div>
                        <div class="col-sm-8">
                            <label style="font-weight: unset;margin-bottom: 0;">
                                <select style="width: 260px;height: 30px;font-size: 16px;" ng-model="choosePrivateClass">
                                    <option value="">请选择课程</option>
                                    <option value="{{i.id}}" ng-repeat="i in privateTeachListInfo">{{i.name}}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-12" style="margin: 30px auto;">
                        <div class="col-sm-4 text-right" style="font-size: 16px;height: 30px;line-height: 30px;">
                            <span class="red">*</span>上课教练：
                        </div>
                        <div class="col-sm-8">
                            <label style="font-weight: unset;margin-bottom: 0;">
                                <select style="width: 260px;height: 30px;font-size: 16px;" ng-model="choosePrivateTeacher">
                                    <option value="">请选择私教</option>
                                    <option ng-repeat="allCoach in allPrivateCoachList" value="{{allCoach.id}}">{{allCoach.name}}</option>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" style="padding: 6px 35px;" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-success" style="padding: 6px 35px;" ng-click="choosePrivateTeachComplete()">完成</button>
            </div>
        </div>
    </div>
</div>
<!--续费-->
<div class="modal fade" id="privateBuy" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 1075px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">续费</h4>
            </div>
            <div class="modal-body" style="padding-top: 50px;">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6 text-left a60">
                            <div class="col-sm-5">
                                <div class="a61">
                                    <img ng-src="{{privateBuyData.pic}}" class="image a62">
                                    <span class='wenzi a63'>点击更换课程</span>
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div style="margin-left: 53px">{{privateBuyData.name}}
                                </div>
                                <div style="margin-left: 53px;margin-top: 10px">
                                    金额:{{privateBuyData.money_amount}}元
                                </div>
                                <div style="margin-left: 53px;margin-top: 10px">
                                    总节数:{{privateBuyData.course_amount}}节
                                </div>
                                <div style="margin-left: 53px;margin-top: 10px">
                                    剩余节数:{{privateBuyData.overage_section}}节
                                </div>
                                <div style="margin-left: 53px;margin-top: 10px">
                                    到期时间:{{privateLessonTemplet.deadline_time * 1000| date:'yyyy-MM-dd'}}
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5 col-sm-offset-1 a65">
                            <div class="mT10">
                                <ul class="a58">
                                    <li><span class="red">*</span>节数</li>
                                    <li class=" mL20 a66">
                                        <input type="text" class="form-control" ng-model="privateBuyDatas.total"
                                               placeholder="多少节" ng-blur="nodeNumberBlur(privateBuyDatas.total)">
                                    </li>
                                </ul>
                            </div>
                            <div class=mT10>
                                <ul class="a58">
                                    <li><span class="op0">*</span>折扣</li>
                                    <li class=" mL20" style="width: 160px;">
                                        <select id="selectColor" ng-model="privateBuyDatas.discount"
                                                class="form-control cp a67">
                                            <option value="">选择折扣</option>
                                            <option value="5">5折</option>
                                            <option value="7">7折</option>
                                            <option value="8">8折</option>
                                            <option value="9">9折</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li><span class="red">*</span>延长时间:</li>
                                    <li style="margin-left: 5px;">
                                        <input type="number" min="1" class="form-control" ng-model="privateBuyDatas.data"
                                               placeholder="多少天" style="width: 160px;">
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li><span class="red">*</span>销售教练</li>
                                    <li class=" mL8" style="width: 160px;">
                                        <select id="selectColor"
                                                ng-change="selectAboutClassData(privateBuyDatas.education)"
                                                ng-model="privateBuyDatas.education" class="form-control cp "
                                                style="padding: 4px 12px;">
                                            <option value="">请选择销售私教</option>
                                            <option value="{{w.id}}" ng-repeat="w in privateBuyDataSectle">
                                                {{w.name}}
                                            </option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    备注
                                    <li class=" mL20" style="width: 160px;">
                                            <textarea name="" id="" cols="30" rows="2"
                                                      ng-model="privateBuyDatas.remarks" style="margin-left: 18px;resize: none;">

                                            </textarea>
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10" style="margin-left: 197px" ng-if="privateBuyData != null "><b>总金额: <span ng-if="nodeNumberBlurData != undefined">{{nodeNumberBlurData}}</span> <span ng-if="nodeNumberBlurData == undefined">0.00</span>元</span></b></div>
                            <div class="mT10" style="margin-left: 197px"><b>实收: <span ng-if="nodeNumberBlurData !=undefined">{{nodeNumberBlurData  * ((privateBuyDatas.discount ==''?10 :privateBuyDatas.discount) / 10) |  number:2}}</span> <span ng-if="nodeNumberBlurData == undefined">0.00</span> 元</b></div>
                            <div class="clearfix a3"><b style="margin-left: 113px;font-size: 14px"></b>
                                <button ladda="RenewPTButtonFlag" type="button" class="btn btn-success btn-sm a59" ng-click="OkRenewal()">续费</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--转课-->
<div class="modal fade" id="transfer" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="min-width: 720px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">转课</h4>
            </div>
            <div class="modal-body" style="padding-top: 50px;">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <img src="/plugins/img/exclamation.png" alt="">
                        <div style="font-size: 15px;color: rgb(153,153,153)">
                            本操作将会把会员购买的{{privateLessonTemplet.name}}产品转移给指定会员
                        </div>
                        <div class="row">
                            <div class="col-sm-10 col-sm-offset-1 mT20" >
                                <div class="col-sm-5 pdLr0 text-right"><span style="color: red;">*</span>手机号&emsp;</div>
                                <div class="col-sm-6 pdLr0 text-left">
                                    <input disabled type="text" class="form-control width200  memberTransferNumber" ng-model="memberTransferNumber"
                                           placeholder="请输入手机号">
                                </div>
                            </div>
                            <div class="col-sm-10 col-sm-offset-1 mT20" >
                                <div class="col-sm-5 pdLr0 text-right">
                                    <span class="red" >*</span>验证码&emsp;
                                </div>
                                <div class="col-sm-6 pdLr0 text-left" style="display: flex;">
                                    <input type="text" style="width: 120px;"
                                           inputnum
                                           ng-model="verificationCode"
                                           class="form-control"
                                           placeholder="验证码"/>
                                    <button class="btn btn-info btn-block btn-sm" style="width: 78px;"
                                            ng-click="getTransferBindMemberCode(memberTransferNumber)"
                                            ng-bind="paracont"
                                            ng-disabled="disabled">验证码</button>
                                </div>
                            </div>
                            <div class="col-sm-10 col-sm-offset-1 mT20" >
                                <div class="col-sm-5 pdLr0 text-right"><span style="color: red;">*</span>会员编号&emsp;</div>
                                <div class="col-sm-6 pdLr0 text-left">
                                    <input type="text" class="form-control width200" ng-model="turn.memberNumber"
                                           placeholder="请输入指定会员编号">
                                </div>
                            </div>
                            <div class="col-sm-10 col-sm-offset-1 mT20" >
                                <div class="col-sm-5 pdLr0 text-right"><span style="color: red;">*</span>转让金额&emsp;</div>
                                <div class="col-sm-6 pdLr0 text-left">
                                    <input type="text" class="form-control width200" ng-model="turn.transferAmount"
                                           placeholder="请输入金额" style="">
                                </div>
                            </div>
                            <div class="col-sm-10 col-sm-offset-1 mT20" >
                                <div class="col-sm-5 pdLr0 text-right"><span style="color: red;">*</span>转让节数&emsp;</div>
                                <div class="col-sm-6 pdLr0 text-left">
                                    <input type="text" class="form-control width200" ng-model="turn.transferNode"
                                           placeholder="{{privateLessonTemplet.overage_section}}" style="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" col-sm-12 text-center" style="margin-top: 40px;">
                        <button type="button" ladda="transferButtonFlag" ng-click="transferOk()" class="btn btn-success width100">完成</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!--修改剩余节数-->
<div class="modal fade" id="ModifyClassNumModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 720px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'MODIFYCLASSNUM')) { ?>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <?php } ?>
                <h2 class="text-center">修改剩余节数</h2>
            </div>
            <div class="model-body text-center">
                <div class="form-group" style="margin-top: 10px;">
                    <span class="glyphicon glyphicon-info-sign">剩余节数不得大于总节数</span>
                    <br>
                    <label style="font-size: 16px;font-weight: normal;color: #333;">请输入修改剩余的节数:</label>
                    <input type="text" id="modifyRestClassNumber" ng-model="restClassNum" checknum>
                </div>
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button style="width: 100px;" class="btn btn-default" ng-click="modifyCourseNum()">修改</button>
            </div>
        </div>
    </div>
</div>
<!--私课修改-->
<div class="modal fade" id="ChargeUpdateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 60%;min-width: 720px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">私教课修改</h4>
            </div>
            <div class="modal-body" style="padding-top: 50px;">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <span class="" style="font-size: 17px;color: black">{{privateLessonTemplet.name}}</span>
                        <div class="col-sm-12 centerHeight mT20">
                            <div class="col-sm-5 text-right">
                                <span class="red">*</span>课程名称
                            </div>
                            <div class="col-sm-4 ">
                                <input type="text" class="form-control" ng-model="className"
                                       placeholder="请输入课程名称" style="">
                            </div>
<!--                            <div class="col-sm-4 ">-->
<!--                                <select id="selectColor" class="form-control cp selectPd" ng-model="courseId" style="">-->
<!--                                    <option value="" >请选择课种</option>-->
<!--                                    <option ng-selected="course.id == defaultCourseId" value="{{course.id}}" ng-repeat="course in courseDataSectle">{{course.name}}</option>-->
<!--                                </select>-->
<!--                            </div>-->
                        </div>
                        <div class="col-sm-12 centerHeight mT20">
                            <div class="col-sm-5 text-right">
                                <span class="red">*</span>教练
                            </div>
                            <div class="col-sm-4 ">
                                <select id="selectColor" class="form-control cp selectPd" ng-model="privateId" style="">
                                    <option value="" >请选择教练</option>
                                    <option ng-selected="private.id == defaultPrivateId" value="{{private.id}}" ng-repeat="private in privateDataSectle">{{private.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 centerHeight mT20">
                            <div class="col-sm-5 text-right">
                                <span class="red">*</span>总金额
                            </div>
                            <div class="col-sm-4 ">
                                <input type="text" class="form-control" ng-model="totalMoney"
                                       placeholder="请输入总金额" style="">
                            </div>
                        </div>
                        <div class="col-sm-12 centerHeight mT20">
                            <div class="col-sm-5 text-right">
                                <span class="red">*</span>总节数
                            </div>
                            <div class="col-sm-4 ">
                                <input type="text" class="form-control" ng-model="totalNum"
                                       placeholder="请输入总节数" style="">
                            </div>
                        </div>
                        <div class="col-sm-12 centerHeight mT20">
                            <div class="col-sm-5 text-right">
                                <span class="red">*</span>剩余节数
                            </div>
                            <div class="col-sm-4 ">
                                <input type="text" class="form-control" ng-model="overageNum"
                                       placeholder="请输入剩余节数" style="">
                            </div>
                        </div>
                        <div class="col-sm-12 centerHeight mT20">
                            <div class="col-sm-5 text-right">
                                <span class="red">*</span>办理日期
                            </div>
                            <div class="col-sm-4 ">
                                <input type="text" id='datetimeStart' ng-model="createTime"
                                       class="input-sm form-control datetimeStart dateCss"
                                       placeholder="请选择办理日期"
                                       style="margin-left: 0;">
                            </div>
                        </div>
                        <div class="col-sm-12 centerHeight mT20">
                            <div class="col-sm-5 text-right">
                                <span class="red">*</span>开始时间
                            </div>
                            <div class="col-sm-4 ">
                                <input type="text" id='startTime111' ng-model="privateStartTime"
                                       class="input-sm form-control datetimeStart dateCss"
                                       placeholder="请选择开课时间"
                                       style="margin-left: 0;">
                            </div>
                        </div>
                        <div class="col-sm-12 centerHeight mT20">
                            <div class="col-sm-5 text-right">
                                <span class="red">*</span>到期日期
                            </div>
                            <div class="col-sm-4 ">
                                <input type="text" id='datetimeEnd' ng-model="deadlineTime"
                                       class="input-sm form-control datetimeStart dateCss"
                                       placeholder="请选择到期日期"
                                       style="margin-left: 0;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix a3">
                <button type="button" ladda="chargeButtonFlag" ng-click="chargeClassUpdate()" class="btn btn-success btn-sm a69">修改</button>
            </div>
        </div>
    </div>
</div>

<!--私课升级-->
<div class="modal fade" id="upgradePrivateLessonModal" tabindex="-1" role="dialog" style="overflow-y: auto;">
    <div class="modal-dialog" role="document" style="width: 720px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title text-center">私教课程升级</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6 text-left privateClassDetailBox" style="border-right: solid 1px #e5e5e5;padding-bottom: 10px;">
                            <img src="/plugins/user/images/default.png" width="300px" height="190px">
                            <p class="mT10" ng-if="privateLessonTemplet.money_amount != null">课程金额:{{privateLessonTemplet.money_amount | number:2}}</p>
                            <p class="mT10" ng-if="privateLessonTemplet.money_amount == null">课程金额:暂无数据</p>
                            <p class="mT10" ng-if="privateLessonTemplet.course_amount != null">总计节数:{{privateLessonTemplet.course_amount}}</p>
                            <p class="mT10" ng-if="privateLessonTemplet.course_amount == null">总计节数:暂无数据</p>
                            <p class="mT10" ng-if="privateLessonTemplet.overage_section != null">剩余节数:{{privateLessonTemplet.overage_section}}</p>
                            <p class="mT10" ng-if="privateLessonTemplet.overage_section == null">剩余节数:暂无数据</p>
                            <p class="mT10" ng-if="privateLessonTemplet.deadline_time !=null">到期时间:{{privateLessonTemplet.deadline_time * 1000| date:'yyyy-MM-dd'}}</p>
                            <p class="mT10" ng-if="privateLessonTemplet.deadline_time ==null">到期时间:暂无数据</p>
                            <p class="mT10" ng-if="privateLessonTemplet.delayTimes != null && privateLessonTemplet.delayTimes != ''">已延期次数:{{privateLessonTemplet.delayTimes}}</p>
                            <p class="mT10" ng-if="privateLessonTemplet.delayTimes == null || privateLessonTemplet.delayTimes == ''">已延期次数:暂无数据</p>
                            <p class="mT10" ng-if="privateLessonTemplet.note != null && privateLessonTemplet.note != ''">备注:{{privateLessonTemplet.note}}</p>
                            <p class="mT10" ng-if="privateLessonTemplet.note == null || privateLessonTemplet.note == ''">备注:暂无数据</p>
                        </div>
                        <div class="col-sm-5 col-sm-offset-1" style="color: #999999;font-size: 12px;">
                            <div class="mT10">
                                <ul style="display: flex;align-items: center;">
                                    <li><span class="red">*</span>私教产品</li>
                                    <li class="mL20">
                                        <div class="clearfix a56" ng-click="choosePrivateProductUpgrade()">
                                            <div class="fl a57"></div>
                                            <div class="fl text-center cp" style="width: 115px; height: 50px;line-height: 50px;text-align: center;">
                                                <span ng-if="privateClassUpgradeId == null">请选择私教产品</span>
                                                <span ng-if="privateClassUpgradeId != null" data-id="{{privateClassUpgradeId}}">{{privateClassUpgradeName}}</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul style="display: flex;align-items: center;">
                                    <li>
                                        <span class="red">*</span>课程数量
                                    </li>
                                    <li class="mL20" style="width: 170px;">
                                        <input type="number" class="form-control" placeholder="请输入课程数量"
                                               ng-model="privateUpgradeClassNum"
                                               ng-change="privateUpgradeClassNumBlur()">
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li>
                                        <span class="red">*</span><span>原价金额</span>
                                    </li>
                                    <li class=" mL20" style="width: 170px;text-align: center;margin-left: 20px;">
                                        <input type="number" min="0" class="form-control" ng-model="privateUpgradeCostPrice" ng-click="privateUpgradeCostPriceClick">
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li>
                                        <span class="red">*</span>付款方式
                                    </li>
                                    <li class=" mL20" style="width: 170px;">
                                        <select class="form-control cp" style="padding: 4px 12px;"
                                                ng-model="privateUpgradePayType"
                                                ng-change="privateUpgradePayTypeChange(privateUpgradePayType)">
                                            <option  value="">选择付款方式</option>
                                            <option  value="1">全款</option>
                                            <option  value="2">定金</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li>
                                        <span class="red">*</span>定金金额
                                    </li>
                                    <li class=" mL20" style="width: 170px;">
                                        <select style="width: 170px;" class="form-control privateUpgradeDeposit"
                                                multiple="multiple"
                                                ng-model="privateUpgradeDeposit"
                                                ng-disabled="privateUpgradePayTypeBool"
                                                ng-change="choosePrivateUpgradeDeposit()">
                                            <option ng-repeat="iii in upgradePrivateLessonDeposit" value="{{iii.id}}" data-price="{{iii.price}}">定金：{{iii.price}}元</option>
                                        </select>
                                        <div>剩余升级课定金{{upgradePrivateDepositSurplus}}元</div>
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li><span class="red">*</span>缴费日期</li>
                                    <li class=" mL20" style="width: 170px;">
                                        <input type="text" class="form-control privateUpgradeRegisterDate" placeholder="请选择登记日期">
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li>
                                        <span class="red">*</span>销售私教
                                    </li>
                                    <li class=" mL20" style="width: 170px;">
                                        <select class="form-control cp" style="padding: 4px 12px;" ng-model="privateUpgradeCoach">
                                            <option value="">请选择销售私教</option>
                                            <option ng-repeat="coach_list in upgradePrivateCoachList" value="{{coach_list.id}}">{{coach_list.name}}</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li>
                                        <span class="red">*</span>私教渠道
                                    </li>
                                    <li class=" mL20" style="width: 170px;">
                                        <select class="form-control cp" style="padding: 4px 12px;" ng-model="privateUpgradeCoachChannels">
                                            <option value="">请选择私教渠道</option>
                                            <option ng-selected="addSellSourceId == w.id" data-module="{{w.id}}" value="{{w.value}}" ng-repeat="w in memberSearchData">{{w.value}}</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10" style="text-align: right;">
                                <ul>
                                    <li class="mL20">
                                        <div style="color: #f9d21a;font-size: 16px;">
                                            <div ng-if="nowSurplusMoney != null">当前课程剩余金额:{{nowSurplusMoney}}元</div>
                                            <div ng-if="upgradeClassMoney != null">升级课程金额:{{upgradeClassMoney}}元</div>
                                            <div ng-if="catchUpgradeClassMoney != null">补交金额:{{catchUpgradeClassMoney}}元</div>
                                            <div ng-if="upgradeMonth != null">有效期:{{upgradeMonth}}月</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="form-group mT10 addUpgradePayBox">
                                <div class="col-sm-12 addUpgradePayChild" style="padding: 0;margin-bottom: 10px;">
                                    <label class="col-sm-3 pd0 control-label label-words" style="padding-top: 5px;">
                                        <span class="red">*</span>付款途径
                                    </label>
                                    <div class="col-sm-9 pd0">
                                        <select class="privateUpgradePayWay" ng-model="upgradeMoneyType" ng-change="upgradeMoneyTypeChange()" style="height: 28px;margin-left: 10px;width: 80px;">
                                            <option value="">请选择</option>
                                            <option value="1">现金</option>
                                            <option value="3">微信</option>
                                            <option value="2">支付宝</option>
                                            <option value="5">建设分期</option>
                                            <option value="6">广发分期</option>
                                            <option value="7">招行分期</option>
                                            <option value="8">借记卡</option>
                                            <option value="9">贷记卡</option>
                                        </select>
                                        <input type="number" name="privateUpgradePayNum" class="privateUpgradePayNum" ng-model="upgradeMoneyInput" ng-change="upgradeMoneyInputChange(upgradeMoneyInput)" style="width: 87px;height: 28px;">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-right" style="margin-top: 50px;">
                                <button class="btn btn-default" id="addUpgradeClass" style="font-size: 12px;"
                                        ng-click="addUpgradeClassMethod()" venuehtml>
                                    新增付款途径
                                </button>
                                <span style="display: inline-block;margin-right: 11px;">总金额：<span>{{allUpgradeClassMoney}}</span>元</span>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li><span class="red">*</span>领取赠品</li>
                                    <li class=" mL20" style="width: 170px;">
                                        <select class="form-control cp" style="padding: 4px 12px;" ng-model="privateUpgradeGetGift">
                                            <option value="">请选择</option>
                                            <option value="1">已领取</option>
                                            <option value="2">未领取</option>
                                        </select>
                                    </li>
                                </ul>
                            </div>
                            <div class="mT10">
                                <ul class="a58">
                                    <li style="margin-bottom: 60px;">
                                        <span class="red" style="opacity: 0;">*</span><span>私课备注</span>
                                    </li>
                                    <li class=" mL20" style="width: 170px;text-align: center;margin-left: 20px;">
                                        <textarea ng-model="privateUpgradeNote" class="form-control"
                                                  style="overflow-y: auto;height: 100px;margin-top: 10px;resize: none;border-color: #0a0a0a;"></textarea>
                                    </li>
                                </ul>
                            </div>
                            <div class="clearfix mT10 text-center">
                                <button type="button" class="btn btn-success" style="width: 100px;"
                                        ladda="privateLessonBuyButtonFlag" ng-click="completeUpgrade()" ng-disabled="catchUpgradeClassMoneyBool">完成
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 私课记录新增按钮 -->
<div class="modal" id="addNewPrivateLessonRecordModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title text-center">新增私教课程</h3>
            </div>
            <div class="modal-body" style="padding: 20px 60px;">
                <form class="form-horizontal">
                    <div class="form-group addNewClassDetailForm">
                        <div class="col-sm-12">
                            <label class="col-sm-3 control-label"><span class="red">*</span>课程：</label>
                            <div class="col-sm-9">
                                <select class=" form-control"
                                        ng-model="addNewPrivateLessonClassChoose"
                                        style="padding: 0px 8px;">
                                    <option value="">请选择</option>
                                    <option value="{{tt.id}}" ng-repeat="tt in allClassName">
                                        {{tt.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-3 control-label"><span class="red">*</span>剩余节数：</label>
                            <div class="col-sm-9">
                                <input type="text"
                                       class="form-control"
                                       checknum
                                       placeholder="请输入剩余节数"
                                       ng-model="addNewPrivateLessonLastNum">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-3 control-label"><span class="red">*</span>总节数：</label>
                            <div class="col-sm-9">
                                <input type="text"
                                       class="form-control"
                                       placeholder="请输入总节数"
                                       checknum
                                       ng-model="addNewPrivateLessonAllNum">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-3 control-label"><span class="red">*</span>课程类型：</label>
                            <div class="col-sm-9">
                                <select class=" form-control"
                                        ng-model="addNewPrivateLessonClassType"
                                        style="padding: 0px 8px;">
                                    <option value="">请选择课程类型</option>
                                    <option value="1">PT</option>
                                    <option value="2">HS</option>
                                    <option value="3">生日课</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-3 control-label"><span class="red">*</span>办理日期：</label>
                            <div class="col-sm-9">
                                <input type="text"
                                       id="startClassTime"
                                       class="form-control"
                                       placeholder="请输入办理日期"
                                       ng-model="addNewPrivateLessonDo">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-3 control-label"><span class="red">*</span>开始时间：</label>
                            <div class="col-sm-9">
                                <input type="text"
                                       id="startClassDate"
                                       class="form-control"
                                       data-date-format="yyyy-mm-dd hh:ii"
                                       placeholder="请输入开课时间"
                                       ng-model="addNewPrivateLessonStart">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-3 control-label"><span class="red">*</span>到期日期：</label>
                            <div class="col-sm-9">
                                <input type="text"
                                       id="endClassDate"
                                       class="form-control"
                                       placeholder="请输入到期日期"
                                       ng-model="addNewPrivateLessonEnd">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-3 control-label"><span class="red">*</span>办理金额：</label>
                            <div class="col-sm-9">
                                <input type="text"
                                       class="form-control"
                                       checknum
                                       placeholder="请输入办理金额"
                                       ng-model="addNewPrivateLessonAmount">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label class="col-sm-3 control-label"><span class="red">*</span>办理私教：</label>
                            <div class="col-sm-9">
<!--                                <select class=" form-control"-->
<!--                                        ng-model="addNewPrivateLessonAdviser"-->
<!--                                        style="padding: 0px 8px;"-->
<!--                                        id="coachId">-->
<!--                                    <option value="">请选择私教</option>-->
<!--                                    <option value="{{theAdviser.id}}" ng-repeat="theAdviser in allAdviser">-->
<!--                                        {{theAdviser.name}}-->
<!--                                    </option>-->
<!--                                </select>-->
                                <select id="coachId" class="form-control cp selectPd" ng-model="addNewPrivateLessonAdviser" style="padding: 0px 8px;">
                                    <option value="" >请选择私教</option>
                                    <option ng-selected="private.id == defaultPrivateId" value="{{private.id}}" ng-repeat="private in addPrivateListData">{{private.name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success center-block w100"
                       ladda="addNewPrivateLessonRecordFinishFlag" ng-click="addNewPrivateLessonRecordFinish()">完成</button>
            </div>
        </div>
    </div>
</div>
<!--选择课程-->
<div class="modal fade" id="selectPrivateCourseModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 720px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <div style="display: flex;justify-content: space-between;">
                    <h4 class=" f14">选择私课</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
            </div>
            <div style="height:360px;overflow-y: scroll;">
                <ul class="clearfix courseLists" ng-repeat="qq in aloneData"
                    style="margin-left: 20px;padding: 20px 36px 20px 0; border-bottom: solid 1px #e5e5e5;">
                    <li class="fl">
                        <img ng-if="qq.pic == ''" ng-src="/plugins/user/images/noPic.png" width="66px"
                             style="border-radius:4px; " height="66px" alt="">
                        <img ng-if="qq.pic != ''" ng-src="{{qq.pic}}" width="66px" height="66px" alt=""
                             style="border-radius:4px; ">
                    </li>
                    <li class="fl" style="margin-left: 16px;">
                        <ul style="margin-top: 4px;">
                            <li><h4 class="f16">{{qq.packName}}</h4></li>
                            <li class="f12" style="color: #999999;margin-top: 4px;">{{qq.name}}</li>
                            <li class="gradeImg" style="margin-top: 0px;">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x2.png" alt="">
                            </li>
                        </ul>
                    </li>
                    <li class="fr">
                        <span class="pull-right textMoney">单价原价：<span class="moneyText">{{qq.original_price}}</span></span>
                        <br/>
                        <button ng-click="selectPrivateCourseSingle(qq.id,qq.pic,qq.packName,'alone',qq.chargeClassPriceAll,qq.original_price,qq.newMember,qq.month_up_num)"
                                style="margin-top: 4px;" class="btn btn-success btn-sm tdBtn pull-right">选择私课
                        </button>
                    </li>
                </ul>
                <ul class="clearfix courseLists" ng-repeat="ww in manyData"
                    style="margin-left: 20px;padding: 20px 36px 20px 0; border-bottom: solid 1px #e5e5e5;">
                    <li class="fl">
                        <img ng-if="ww.pic == ''" ng-src="/plugins/user/images/noPic.png"
                             style="border-radius:4px; " width="66px" height="66px" alt="">
                        <img ng-if="ww.pic != ''" ng-src="{{ww.pic}}" width="66px" style="border-radius:4px; "
                             height="66px" alt="">
                    </li>
                    <li class="fl" style="margin-left: 16px;">
                        <ul style="margin-top: 4px;">
                            <li><h4 class="f16">{{ww.packName}}</h4></li>
                            <li class="f12" style="color: #999999;margin-top: 4px;">
                                <span>{{ww.courseStr}}</span></span></li>
                            <li class="gradeImg" style="margin-top: 0px;">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x2.png" alt="">
                            </li>
                        </ul>
                    </li>
                    <li class="fr" style="margin-top: 8px;">
                            <span class="pull-right textMoney">套餐原价：<span
                                    class="moneyText">{{ww.totalPrice}}</span></span>
                        <br/>
                        <button ng-class=" {{ww.memberOrder == true}} ? 'endMemberOrder' :'endMemberOrders' "
                        ng-disabled="ww.memberOrder  != true"
                        ng-click="selectPrivateCourseServe(ww.id,ww.pic,ww.packName,'many',ww.totalPrice, ww.valid_time)"
                                style="margin-top: 4px;" class="btn btn-success btn-sm tdBtn">选择私课
                        </button>
                    </li>
                </ul>
                <?= $this->render('@app/views/common/nodata.php', ['name' => 'shopDetailShow']); ?>
            </div>
        </div>
    </div>
</div>
<!--私课升级选择课程-->
<div class="modal fade" id="privateProductUpgradeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 720px;">
        <div class="modal-content">
            <div class="modal-header">
                <div style="display: flex;justify-content: space-between;">
                        <span ng-click="backBuyPrivate()" class="glyphicon glyphicon-menu-left f16 cp"
                              class="a70"></span>
                    <h4 class=" f14">选择私课</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
            </div>
            <div style="height:360px;overflow-y: scroll;">
                <ul class="clearfix courseLists" ng-repeat="aloneDatas in aloneLessonData"
                    style="margin-left: 20px;padding: 20px 36px 20px 0; border-bottom: solid 1px #e5e5e5;">
                    <li class="fl">
                        <img ng-if="aloneDatas.pic == ''" ng-src="/plugins/user/images/noPic.png" width="66px"
                             style="border-radius:4px; " height="66px" alt="">
                        <img ng-if="aloneDatas.pic != ''" ng-src="{{aloneDatas.pic}}" width="66px" height="66px" alt=""
                             style="border-radius:4px; ">
                    </li>
                    <li class="fl" style="margin-left: 16px;">
                        <ul style="margin-top: 4px;">
                            <li><h4 class="f16">{{aloneDatas.packName}}</h4></li>
                            <li class="f12" style="color: #999999;margin-top: 4px;">{{aloneDatas.name}}</li>
                            <li class="gradeImg" style="margin-top: 0px;">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x2.png" alt="">
                            </li>
                        </ul>
                    </li>
                    <li class="fr">
                        <span class="pull-right textMoney">单价原价：<span class="moneyText">{{aloneDatas.original_price}}</span></span>
                        <br/>
                        <button style="margin-top: 4px;"
                                class="btn btn-success btn-sm tdBtn pull-right"
                                ng-click="completePrivateClassUpgrade(aloneDatas.original_price, aloneDatas.id, aloneDatas.packName, aloneDatas.type, aloneDatas.month_up_num)">选择私课
                        </button>
                    </li>
                </ul>
                <ul class="clearfix courseLists" ng-repeat="manyDatas in manyLessonData"
                    style="margin-left: 20px;padding: 20px 36px 20px 0; border-bottom: solid 1px #e5e5e5;">
                    <li class="fl">
                        <img ng-if="manyDatas.pic == ''" ng-src="/plugins/user/images/noPic.png"
                             style="border-radius:4px; " width="66px" height="66px" alt="">
                        <img ng-if="manyDatas.pic != ''" ng-src="{{manyDatas.pic}}" width="66px" style="border-radius:4px; "
                             height="66px" alt="">
                    </li>
                    <li class="fl" style="margin-left: 16px;">
                        <ul style="margin-top: 4px;">
                            <li><h4 class="f16">{{manyDatas.packName}}</h4></li>
                            <li class="f12" style="color: #999999;margin-top: 4px;">
                                <span>{{manyDatas.courseStr}}</span></span></li>
                            <li class="gradeImg" style="margin-top: 0px;">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x2.png" alt="">
                            </li>
                        </ul>
                    </li>
                    <li class="fr" style="margin-top: 8px;">
                            <span class="pull-right textMoney">套餐原价：<span class="moneyText">{{manyDatas.totalPrice}}</span></span>
                        <br/>
                        <button ng-class="{{manyDatas.memberOrder == true}} ? 'endMemberOrder' : 'endMemberOrders'"
                                ng-disabled="manyDatas.memberOrder  != true"
                                ng-click="completePrivateClassUpgrade(manyDatas.totalPrice, manyDatas.id, manyDatas.packName, manyDatas.type)"
                                style="margin-top: 4px;" class="btn btn-success btn-sm tdBtn">选择私课
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- 私教分配选择教练模态框-->
<div class="modal fade" id="selectTeacherModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 720px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <div style="display: flex;justify-content: space-between;">
                        <span ng-click="privateEducationModal()" class="glyphicon glyphicon-menu-left f16 cp"
                              class="a70"></span>
                    <h4 class=" f14">选择教练</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
            </div>
            <div style="height:360px;overflow-y: scroll;">
                <ul class="clearfix courseLists" ng-repeat="w in privateEducationDataList"
                    style="margin-left: 20px;padding: 20px 36px 20px 0; border-bottom: solid 1px #e5e5e5;">
                    <li class="fl">
                        <img  ng-src="{{w.pic}}" width="66px" style="border-radius:4px; " height="66px" alt="">
                    </li>
                    <li class="fl" style="margin-left: 16px;">
                        <ul style="margin-top: 4px;">
                            <li><h4 class="f16" > {{w.name}} <b style="margin-left: 50px;" ng-if="w.age != null">年龄:{{w.age}}</b>   </h4></li>
                            <li class="f12" style="color: #999999;margin-top: 4px;" ng-if="w.work_time != null">从业时间{{w.work_time}}年</li>
                            <li class="gradeImg" style="margin-top: 0px;">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x1.png" alt="">
                                <img src="/plugins/img/x2.png" alt="">
                            </li>
                            <button style="margin-top: -40px;margin-left: 436px" ng-click="privateEducationSelectList(w.id,w.pic,w.name)" class="btn btn-success btn-sm tdBtn pull-right">选择教练</button>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- 私教分配选择教练模态框-->
<div class="modal fade" id="selectBuyClassModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document" style="width: 720px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <div style="display: flex;justify-content: space-between;">
                        <span ng-click="privateEducationModal()" class="glyphicon glyphicon-menu-left f16 cp"
                              class="a70"></span>
                    <h4 class=" f14">选择课程</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
            </div>
            <div>
                <table class="table table-striped table-bordered table-hover dataTables-example dataTable" >
                    <thead>
                    <tr  role="row">
                        <th>课程图片</th>
                        <th>课程名称</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
<!--                    <tr class="courseLists"  role="row" ng-repeat="info in buyClassList">-->
<!--<!--                        <td>{{info.name}}</td>-->
<!--<!--                        <td class>{{info.create_at *1000 | date:"yyyy-MM-dd HH:mm"}}</td>-->
<!--<!--                        <td>-->
<!--<!--                            <button class="btn" ng-click="buyMemberPrivateSelectList(info.orderId,info.name)" class="btn btn-success btn-sm tdBtn pull-right">选择课程</button>-->
<!--<!--                        </td>-->
<!--                        <td>{{}}</td>-->
<!--                        <td>{{}}</td>-->
<!--                        <td></td>-->
<!--                    </tr>-->
                        <tr ng-repeat="aloneClass in allClassListAlone">
                            <td><img ng-src="{{aloneClass.pic ? aloneClass.pic : '/plugins/user/images/default.png'}}" alt="" style="width: 80px;height: 80px;"></td>
                            <td>{{aloneClass.packName}}</td>
                            <td>
                                <button class="btn" ng-click="buyMemberPrivateSelectList(aloneClass.packName, aloneClass.type ,aloneClass.id)" class="btn btn-success btn-sm tdBtn pull-right">选择课程</button>
                            </td>
                        </tr>
                        <tr ng-repeat="manyClass in allClassListMany">
                            <td><img ng-src="{{manyClass.pic ? manyClass.pic : '/plugins/user/images/default.png'}}" alt="" style="width: 80px;height: 80px;"></td>
                            <td>{{manyClass.packName}}</td>
                            <td>
                                <button class="btn" ng-click="buyMemberPrivateSelectList(manyClass.packName, manyClass.type ,manyClass.id)" class="btn btn-success btn-sm tdBtn pull-right">选择课程</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>