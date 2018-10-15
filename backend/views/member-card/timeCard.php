<?php
use backend\assets\TimeCardAsset;
TimeCardAsset::register($this);
$this->title = '1.时间卡的属性';
?>
<div class="wrapper wrapper-content animated fadeIn" ng-controller="timeCardController" style="height: 1000px;">
    <div class="row" style="height: 1000px;">
        <div class="col-sm-12" style="height: 1000px;">
            <div class="ibox float-e-margins" style="height: 1000px;">
                <div class="ibox-title">
                    <h5>制定时间卡</h5>
                </div>
                <div class="ibox-content" style="height: 1000px;">
                    <div id="wizard" tyle="min-height:2000px;">
                        <h1>第一步 时间卡</h1>
                        <div class="step-content">
                            <div class="text-center m-t-md step-content1">
                                <section>
                                    <form action="" id="from1">
                                        <p class="margin">卡的属性</p>
                                        <select style="border-color: rgb(207,218,221)" ng-model="attributes" class="attributes">
                                            <option value="">请选择卡种属性</option>
                                            <option value="1">个人</option>
                                            <option value="2">公司</option>
                                            <option value="3">家庭</option>
                                        </select>
                                        <p class="margin">卡的名称</p>
                                        <input id="_csrf" type="hidden" name="<?= \Yii::$app->request->csrfParam; ?>" value="<?= \Yii::$app->request->getCsrfToken();?>">
                                        <input type="text" placeholder="至尊卡" class="form-control card_name"
                                               ng-model="card_name"  value="">
                                        <p class="margin">卡的有效日期</p>
                                        <input ng-model="duration" type="number" inputnum min="0" placeholder="时长/天" style="margin-bottom: 10px" class="form-control">
                                        <p class="margin" style="text-align: center;">每月固定日(选填)</p>
                                        <div>
                                            <table id="table">
                                                <trs>
                                                    <td colspan="2"  style="border: none;"></td>
                                                    <td class="sectle">1</td>
                                                    <td>2</td>
                                                    <td>3</td>
                                                    <td>4</td>
                                                    <td>5</td>
                                                </trs>
                                                <tr>
                                                    <td>6</td>
                                                    <td>7</td>
                                                    <td>8</td>
                                                    <td>9</td>
                                                    <td>10</td>
                                                    <td>11</td>
                                                    <td>12</td>
                                                </tr>
                                                <tr>
                                                    <td>13</td>
                                                    <td>14</td>
                                                    <td>15</td>
                                                    <td>16</td>
                                                    <td>17</td>
                                                    <td>18</td>
                                                    <td>19</td>
                                                </tr>
                                                <tr>
                                                    <td>20</td>
                                                    <td>21</td>
                                                    <td>22</td>
                                                    <td>23</td>
                                                    <td>24</td>
                                                    <td>25</td>
                                                    <td>26</td>
                                                </tr>
                                                <tr>
                                                    <td>27</td>
                                                    <td>28</td>
                                                    <td>29</td>
                                                    <td>30</td>
                                                    <td>31</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <p  style="margin-top: 10px;margin-bottom: 0;position: relative;top: 10px;text-align: left;">特定星期选择(选填)</p>
                                        <div id="week">
                                            <div class="checkbox i-checks">
                                                <input class="" type="checkbox" ng-model="weekOne" value="1">
                                                <span>星期一</span>
                                                <div class="form-group clearfix clearfixs" style="background: #EEEEEE;margin-top: 0;width: 200x;" >
                                                    <div class="input-group clockpicker fl" data-autoclose="true" style="width: 85px;">
                                                        <input type="text" ng-model="weekOneStartTime" class="form-control start"  placeholder="选择时间" style="width: 100%;" value="">
                                                    </div>
                                                    <div class="fl" style=" position: relative;top: 6px;margin: 0 10px;display:inline-block;">到</div>
                                                    <div class="input-group clockpicker fl" data-autoclose="true" style="width: 85px;border-radius: 2px;">
                                                        <input type="text" ng-model="weekOneStartEnd" class="form-control end" placeholder="选择时间" style="width: 100%" value="">
                                                    </div>
                                                </div>                                            </div>
                                            <div class="checkbox i-checks">
                                                <input class=""  ng-model="weekTwo" type="checkbox" value="2">
                                                <span>星期二</span>
                                                <div class="form-group clearfix clearfixs" style="background: #EEEEEE;margin-top: 0;width: 200x;" >
                                                    <div class="input-group clockpicker fl" data-autoclose="true" style="width: 85px;">
                                                        <input type="text"ng-model="weekTwoStartStart" class="form-control start"  placeholder="选择时间" style="width: 100%;" value="">
                                                    </div>
                                                    <div class="fl" style=" position: relative;top: 6px;margin: 0 10px;display:inline-block;">到</div>
                                                    <div class="input-group clockpicker fl" data-autoclose="true" style="width: 85px;border-radius: 2px;">
                                                        <input type="text" ng-model="weekTwoStartEnd" class="form-control end" placeholder="选择时间" style="width: 100%" value="">
                                                    </div>
                                                </div>                                            </div>
                                            <div class="checkbox i-checks">
                                                <input class="" ng-model="weekThree" type="checkbox" value="3">
                                                <span>星期三</span>
                                                <div class="form-group clearfix clearfixs" style="background: #EEEEEE;margin-top: 0;width: 200x;" >
                                                    <div class="input-group clockpicker fl" data-autoclose="true" style="width: 85px;">
                                                        <input type="text" ng-model="weekThreeStartTime" class="form-control start"  placeholder="选择时间" style="width: 100%;" value="">
                                                    </div>
                                                    <div class="fl" style=" position: relative;top: 6px;margin: 0 10px;display:inline-block;">到</div>
                                                    <div class="input-group clockpicker fl" data-autoclose="true" style="width: 85px;border-radius: 2px;">
                                                        <input type="text" ng-model="weekThreeEndTime" class="form-control end" placeholder="选择时间" style="width: 100%" value="">
                                                    </div>
                                                </div>                                            </div>
                                            <div class="checkbox i-checks">
                                                <input class="" ng-model="weekFour" type="checkbox" value="4">
                                                <span>星期四</span>
                                                <div class="form-group clearfix clearfixs" style="background: #EEEEEE;margin-top: 0;width: 200x;" >
                                                    <div class="input-group clockpicker fl" data-autoclose="true" style="width: 85px;">
                                                        <input type="text" ng-model="weekFourStartTime" class="form-control start"  placeholder="选择时间" style="width: 100%;" value="">
                                                    </div>
                                                    <div class="fl" style=" position: relative;top: 6px;margin: 0 10px;display:inline-block;">到</div>
                                                    <div class="input-group clockpicker fl" data-autoclose="true" style="width: 85px;border-radius: 2px;">
                                                        <input type="text" ng-model="weekFourEndTime" class="form-control end" placeholder="选择时间" style="width: 100%" value="">
                                                    </div>
                                                </div>                                            </div>
                                            <div class="checkbox i-checks">
                                                <input class="" type="checkbox" value="5">
                                                <span>星期五</span>
                                                <div class="form-group clearfix clearfixs" style="background: #EEEEEE;margin-top: 0;width: 200x;" >
                                                    <div class="input-group clockpicker fl" data-autoclose="true" style="width: 85px;">
                                                        <input type="text" ng-model="weekFiveStartTime" class="form-control start"  placeholder="选择时间" style="width: 100%;" value="">
                                                    </div>
                                                    <div class="fl" style=" position: relative;top: 6px;margin: 0 10px;display:inline-block;">到</div>
                                                    <div class="input-group clockpicker fl" data-autoclose="true" style="width: 85px;border-radius: 2px;">
                                                        <input type="text" ng-model="weekFiveEndTime" class="form-control end" placeholder="选择时间" style="width: 100%" value="">
                                                    </div>
                                                </div>                                            </div>
                                            <div class="checkbox i-checks">
                                                <input class="" type="checkbox" value="6">
                                                <span>星期六</span>
                                                <div class="form-group clearfix clearfixs" style="background: #EEEEEE;margin-top: 0;width: 200x;" >
                                                    <div class="input-group clockpicker fl" data-autoclose="true" style="width: 85px;">
                                                        <input type="text" ng-model="weekSixStartTime" class="form-control start"  placeholder="选择时间" style="width: 100%;" value="">
                                                    </div>
                                                    <div class="fl" style=" position: relative;top: 6px;margin: 0 10px;display:inline-block;">到</div>
                                                    <div class="input-group clockpicker fl" data-autoclose="true" style="width: 85px;border-radius: 2px;">
                                                        <input type="text" ng-model="weekSixEndTime" class="form-control end" placeholder="选择时间" style="width: 100%" value="">
                                                    </div>
                                                </div>                                            </div>
                                            <div class="checkbox i-checks">
                                                <input class="" type="checkbox" value="7">
                                                <span>星期日</span>
                                                <div class="form-group clearfix clearfixs" style="background: #EEEEEE;margin-top: 0;width: 200x;" >
                                                    <div class="input-group clockpicker fl" data-autoclose="true" style="width: 85px;">
                                                        <input type="text" ng-model="weekSevStartTime" class="form-control start"  placeholder="选择时间" style="width: 100%;" value="">
                                                    </div>
                                                    <div class="fl" style=" position: relative;top: 6px;margin: 0 10px;display:inline-block;">到</div>
                                                    <div class="input-group clockpicker fl" data-autoclose="true" style="width: 85px;border-radius: 2px;">
                                                        <input type="text" ng-model="weekSevEndTime" class="form-control end" placeholder="选择时间" style="width: 100%" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <p class="margin" style="margin-bottom: 5px;">填写卡的特定时间点(选填)</p>
                                        <div class=" clearfix" style="position: relative;top: 0;">
                                            <div class="input-group clockpicker" data-autoclose="true" style="width: 138px;display: inline-block;float: left;">
                                                <input ng-model="start" class="form-control" placeholder="请选择时间" style="width: 100%;border-radius: 2px;" type="text" value="">
                                            </div>
                                            <div class="input-group clockpicker" data-autoclose="true" style="width: 138px;border-radius: 2px; float: right;">
                                                <input ng-model="end" class="form-control" placeholder="请选择时间" style="width: 100%" type="text" value="">
                                            </div>
                                        </div>
                                        <p class="margin">请假总天数</p>
                                        <input ng-model="leave_day" type="number" inputnum min="0" placeholder="0天" class="form-control" style="text-align: center;" value="">
                                        <p class="margin">请假总次数</p>
                                        <input ng-model="leave_times" type="number" inputnum min="0" placeholder="0次" class="form-control" style="height: 30px;" value="">
                                        <div class="sectionT">
                                            <section>
                                                <p class="margin">最长请假天数</p>
                                                <input type="number" inputnum min="0" placeholder="0天" ng-model="leave_set_day"
                                                       class="form-control" style="width: 130px;" value="">
                                            </section>
                                            <section>
                                                <p class="margin">最多请假次数</p>
                                                <input type="number" min="0" inputnum placeholder="0次" ng-model="leave_set_times"
                                                       class="form-control" style="width: 130px;margin-left: 10px;" value="">
                                            </section>
                                        </div>
                                        <div>
                                            <section>
                                                <p class="margin">转让几次</p>
                                                <input type="number" min="0" inputnum placeholder="0次" ng-model="transferNumber"
                                                       class="form-control" value="">
                                            </section>
                                            <section>
                                                <p class="margin">转让金额</p>
                                                <input type="number" min="0" inputnum placeholder="0元" ng-model="transferPrice"
                                                       class="form-control" value="">
                                            </section>
                                        </div>
                                    </form>
                                </section>
                            </div>
                        </div>

                                                    <h1>第二步 制定定价和售卖规则</h1>
                                                    <div class="step-content">
                                                        <div class="text-center m-t-md">
                                                            <form id="form2">
                                                                <p class="margins">售卖方式</p>
                                                                <select ng-model="sales_mode" style="border-color: rgb(207,218,221)">
                                                                    <option value="">请选择销售方式</option>
                                                                    <option value="3">网上和线下</option>
                                                                    <option value="2">网上</option>
                                                                    <option value="1">线下</option>
                                                                </select>
                                                                <div>
                                                                    <p class="margins2">网上支付 <br><small>一口价</small></p>
                                                                    <input ng-model="online_original_price" type="number" min="0" placeholder="原价0元" class="form-control" style="display: inline-block;" value="">
                                                                    <input ng-model="online_sell_price" type="number" min="0" placeholder="售价0元" class="form-control" style="display: inline-block;" value="">
                                                                </div>
                                                                <div>
                                                                    <p class="margins">区间定价</p>
                                                                    <input ng-model="min_price" type="number" min="0" placeholder="原价0元" class="form-control" style="display: inline-block;" value="">
                                                                    <input ng-model="max_price" type="number" min="0" placeholder="售价0元" class="form-control" style="display: inline-block;" value="">
                                                                </div>
                                                                <div id="addDiv">
                                                                    <section>
                                                                        <p class="margins">单个售卖场馆 <br>
                                                                            <small>选择场馆</small>
                                                                        </p>
                                                                        <select ng-model="venue_id" style="border-color: rgb(207,218,221)">
                                                                            <option value="">哪所场馆</option>
                                                                            <option value="1">大上海</option>
                                                                            <option value="2">大卫城</option>
                                                                            <option value="3">大学路</option>
                                                                        </select>
                                                                    </section>
                                                                    <section>
                                                                        <small>售卖张数</small>
                                                                        <input ng-model="limit" type="number" min="0" placeholder="售卖张数" class="form-control" style="padding-left: 5px;">
                                                                    </section>
                                                                </div>
                                                                <div class="btn btn-success btn-sm" id="addFormulate">添加场馆</div>
                                                                <br><br>
                                                                <p class="margins" style="margin-bottom: 5px;">多个售卖场馆</p>
                                                                <div id="checkboxSelect">
                                                                    <div class="checkbox i-checks" style="margin-bottom: 5px;">
                                                                        <span style="text-align: left;">选择场馆</span>
                                                                    </div>
                                                                    <div class="checkbox i-checks">
                                                                        <input type="checkbox" ng-model="venueIds.id" value="1">
                                                                        <span>大卫城店</span>
                                                                    </div>
                                                                    <div class="checkbox i-checks">
                                                                        <input type="checkbox" ng-model="venueIds.id" value="2">
                                                                        <span>大上海城</span>
                                                                    </div>
                                                                    <div class="checkbox i-checks">
                                                                        <input type="checkbox" ng-model="venueIds.id" value="3">
                                                                        <span>丹尼斯</span>
                                                                    </div>
                                                                    <div class="checkbox i-checks">
                                                                        <input type="checkbox" ng-model="venueIds.id" value="4">
                                                                        <span>大学路</span>
                                                                    </div>
                                                                </div>
                                                                <p class="margins">总售卖张数</p>
                                                                <input ng-model="total_circulation" type="number" min="0" placeholder="0张" class="form-control">
                                                                <p class="margins">售卖日期</p>
                                                                <div class="input-daterange input-group" id="datepicker" style="width: 100%;margin-bottom: 5px;">
                                                                    <input ng-model="sell_start_time" class="input-sm form-control" name="start" placeholder="请选择日期" style="width: 138px;" type="text">
                                                                    <input ng-model="sell_end_time" class="input-sm form-control" name="end" placeholder="请选择日期" style="width: 138px;border-radius: 2px;float: right;" type="text">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <h1>第三步 制定场馆限制</h1>
                                                    <div class="step-content">
                                                        <div class="text-center m-t-md">
                                                            <form action="" id="form3">
                                                                <small>适用场馆</small><br>
                                                                <select ng-model="apply_venue_id" style="border-color: rgb(207,218,221);height:35px;" class="form-control">
                                                                    <option value="" >哪所场馆</option>
                                                                    <option value="1">大上海</option>
                                                                    <option value="2">大卫城</option>
                                                                    <option value="3">大学路</option>
                                                                </select>
                                                                <small>场馆通店设置</small>
                                                                <div>
                                                                    <input ng-model="times" type="number" min="0" placeholder="通店次数" class="form-control"><p><input ng-model="timesLevel" type="checkbox">不限</p>
                                                                </div>
                                                                <br>
                                                                <div id="addCalss">
                                                                    其他场馆
                                                                    <section id="addSection"></section>
                                                                    <div class="btn btn-success btn-sm">添加场馆</div>
                                                                    <br>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <h1>第四步 绑定套餐</h1>
                                                    <div class="step-content">
                                                        <div class="text-center m-t-md">
                                                            <section id="form4">
                                                                <div>
                                                                    <section>
                                                                        <span>课程套餐</span><br>
                                                                        <select ng-model="class_server_id" id="sectionLis4" ng-change="tabHtml(class_server_id)" style="border-color: rgb(207,218,221)">
                                                                                <option value="" disabled>请选择课程套餐</option>
                                                                                <option value="1" ng-selected="1">尊爵套餐</option>
                                                                                <option value="2">金爵套餐</option>
                                                                                <option value="3">普通套餐</option>
                                                                                <option value="4">健身套餐</option>
                                                                                <option value="5">瑜伽套餐</option>
                                                                        </select>
                                                                    </section>
                                                                    <ul>
                                                                        <li class="blocks4">
                                                                            <h3>{{items.name}}</h3>
                                                                            <small>{{items.desc}}</small><br>
                                                                            <span>{{items.class_name}}</span><br>
                                                                            <span>{{items.times}}</span><br>
                                                                            <span>{{items.class_name2}}</span><br>
                                                                            <span>{{items.times2}}</span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div>
                                                                    <section>
                                                                        <span>服务套餐</span><br>
                                                                        <select ng-model="server_combo_id" id="selects4" ng-change="tabCombo(server_combo_id)"  style="border-color: rgb(207,218,221)">
                                                                            <option value="" disabled>请选择服务套餐</option>
                                                                            <option value="1" ng-selected = "1">健康服务套餐</option>
                                                                            <option value="2">瑜伽服务套餐</option>
                                                                        </select>
                                                                    </section>
                                                                    <ul >
                                                                        <li class="blocks4">
                                                                            <h3>{{combo.name}}</h3>
                                                                            <span>{{combo.desc}}</span>
                                                                            <p>{{combo.class_name}}</p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </section>
                                                        </div>
                                                    </div>
                                                    <h1>第五步 合同</h1>
                                                    <div class="step-content">
                                                        <div class="text-center m-t-md">
                                                            <section id="form5">
                                                                <div>
                                                                    <section>
                                                                        <span>选择合同</span><br>
                                                                        <select ng-model="deal" id="sectionLis5" style="border-color: rgb(207,218,221)">
                                                                            <option value="" disabled>请选择合同</option>
                                                                            <option value="1" ng-selected = "1">通用合同</option>
                                                                            <option value="2">A合同</option>
                                                                            <option value="3">B合同</option>
                                                                            <option value="4">C合同</option>
                                                                        </select>
                                                                    </section>
                                                                    <ul id="sectionLi5">
                                                                        <li style="display: block;">
                                                                            <h3>通用合同</h3>
                                                                            <p>这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同</p>
                                                                        </li>
                                                                        <li>
                                                                            <h3>课程套餐管理2</h3>
                                                                            <p>这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同</p>
                                                                        </li>
                                                                        <li>
                                                                            <h3>课程套餐管理3</h3>
                                                                            <p>这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同</p>
                                                                        </li>
                                                                        <li>
                                                                            <h3>课程套餐管理3</h3>
                                                                            <p>这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同这是一个通用合同</p>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </section>
                                                        </div>
                                                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

