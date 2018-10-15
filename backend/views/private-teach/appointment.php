<?php
use backend\assets\PrivateAppointmentCtrlAsset;
PrivateAppointmentCtrlAsset::register($this);
$this->title = '预约';
?>
<nav>
    <section class="animated fadeIn">
        <div><strong>云运动</strong></div>
        <div>&nbsp&nbsp预约</div>
    </section>
    <section>
        <div></div>
    </section>
</nav>

<main ng-controller="appointmentController" ng-cloak>
    <h3>预约设置</h3>
    <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
    <section>
        <form id="form1">
            <span >开课前多长时间不可预约</span>
            <select style="border-color: rgb(207,218,221)" ng-model="subscribe">
                <option value="1">15分钟</option>
                <option value="2">30分钟</option>
                <option value="3">1小时</option>
                <option value="4">2小时</option>
                <option value="-1">不限</option>
            </select><br><br>
            <span >所属场馆</span>
            <select style="border-color: rgb(207,218,221)" ng-model="venue">
                <option value="1">大上海城</option>
                <option value="2">大卫城</option>
                <option value="3">大学路</option>
            </select><br><br>
            <span >会员早于开课多长时间可取消</span>
            <input type="text" placeholder="0分钟可取消" class="form-control" ng-model="cancel"><br><br>
            <span >会员可预约多少天以内的课</span>
            <input type="text" placeholder="0天以内的课" class="form-control" ng-model="class"><br><br>
            <span>对会员展示课程预约人数</span><br>
            <select style="border-color: rgb(207,218,221)" ng-model="member_show">
                <option value="1">允许所有人查看</option>
                <option value="2">允许付费会员查看</option>
                <option value="3">禁止所有人查看</option>
            </select><br><br>
            <form  class="formRadio">
            <span class="marginBottom">替课教练是否需要审核</span>
                <div class="radio i-checks">
                    <label>
                        <input type="radio"  value="1" name="is_coach_class" ng-model="is_coach_class"> <i></i> 需要</label>
                </div>
                <div class="radio i-checks">
                    <label>
                        <input type="radio" value="0" name="is_coach_class" ng-model="is_coach_class"> <i></i> 不需要</label>
                </div>
            </form>
            
            <br>
            <form class="formRadio">
                <span class="marginBottom">教练请假是否需要审核</span>
                <div class="radio i-checks">
                    <label>
                        <input type="radio" value="1" name="is_coach_vacation" ng-model="is_coach_vacation"> <i></i> 需要</label>
                </div>
                <div class="radio i-checks">
                    <label>
                        <input type="radio" value="0" name="is_coach_vacation" ng-model="is_coach_vacation"> <i></i> 不需要</label>
                </div>
            </form>
            <br>
            <form class="formRadio">
                <span class="marginBottom">会员只能预约所绑定教练的私教课</span>
                <div class="radio i-checks">
                    <label>
                        <input type="radio" value="1" name="is_member_class"> <i></i> 是</label>
                </div>
                <div class="radio i-checks">
                    <label>
                        <input type="radio" value="0" name="is_member_class"> <i></i> 不是</label>
                </div>
            </form>
            <footer>
                <div>
                    <button class="btn btn-primary "><a href="/private-teach/index?&c=2" style="color: cornsilk;">返回 </a></button>
                    <button class="btn btn-success " type="submit" ng-click="present()">提交</button>
                </div>
            </footer>
        </form>
    </section>
</main>



