
<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: 程-->
<!-- * Date: 2017/12/29-->
<!-- * Time: 15:17-->
<!-- */-->
<div class="col-sm-12 col-md-12  col-xs-12 pdLr0 removeDiv courseSectionNum" >
    <div class="col-sm-6 col-md-4 col-xs-6 mT20 heightCenter">
        <div class="col-sm-4 col-md-4 col-xs-5 pd0"><span class="red"></span>课程节数区间:</div>
        <div class="col-sm-8 col-md-8 col-xs-7 pd0">
            <div class="col-sm-5 col-md-5 col-xs-5 pdLr0 heightCenter">
                <input  type="number" name="startSec" inputnum class="form-control " placeholder="节">
            </div>
            <span class="col-sm-2 col-md-2 col-xs-2 pdLr0 text-center" style="padding-top: 4px;">至</span>
            <div class="col-sm-5 col-md-5 col-xs-5 pdLr0">
                <input ng-blur="endSectionBlur($event)"  type="number" name="endSec" inputnum class="form-control " placeholder="节">
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-3 col-xs-6 mT20 heightCenter">
        <div class="col-sm-4 col-md-4 col-xs-5 pd0"><span class="red"></span>优惠单价:</div>
        <div class="col-sm-8 col-md-8 col-xs-7 pd0">
            <input type="number" name="discountPrice" class="form-control" placeholder="元">
        </div>
    </div>
    <div class="col-sm-6 col-md-3 col-xs-6 mT20 heightCenter">
        <div class="col-sm-4 col-md-4 col-xs-5 pd0"><span class="red"></span>POS价:</div>
        <div class="col-sm-8 col-md-8 col-xs-7 pd0">
            <input type="number" name="posPrice" class="form-control" placeholder="元">
        </div>
    </div>
    <div class="col-sm-6 col-md-3 col-xs-6 mT20 heightCenter">
        <div class="col-sm-4 col-md-4 col-xs-5 pd0"><span class="red"></span>移动端折扣:</div>
        <div class="col-sm-8 col-md-8 col-xs-7 pd0" style="margin-left: 50px">
            <input type="number" name="appDiscount" class="form-control" placeholder="请输入折扣">
        </div>
    </div>
    <div class="col-sm-6 col-md-2 col-xs-6 mT20 heightCenter">
        <button class="btn btn-default btn-sm removeHtml" data-remove="removeDiv">删除</button>
    </div>
</div>