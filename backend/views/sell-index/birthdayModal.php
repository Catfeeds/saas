<!--生日会员详情模态框-->
<div class="modal fade" id="birthdayModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wB80" role="document" style="min-width: 1080px;">
        <div class="modal-content clearfix">
            <div class="modal-header">
                <div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="row">
                        <h4 class="modal-title modalTitle" id="myModalLabel" >
                            生日会员
                        </h4>
                    </div>
                    <div class="row h55">
                        <div class="col-sm-7 pd0">
                            <div class="col-sm-6 col-xs-6 pd0">
                                <div class="input-group cp userTimeRecord"  style="min-width: 340px;">
                                        <span class="input-group-addon ">
                                        选择日期
                                        </span>
                                    <input type="text" class="form-control" id="datetimeStart1"
                                           data-date-format="yyyy-mm-dd" placeholder="选择开始日期">
                                    <input type="text" class="form-control" id="datetimeStart2"
                                           data-date-format="yyyy-mm-dd" placeholder="选择结束日期">
                                </div>
                            </div>
                            <div class="col-sm-2 col-xs-2 pd0">
                                <select id="birthdayIdSelect2" class="selectCss form-control checkSellMan" ng-model="birthdayId" style="width: 100px;">
                                    <option value="">选择顾问</option>
                                    <option value="{{w.id}}" ng-repeat="w in adviserBirthdayListData">{{w.name}}</option>
                                </select>
                            </div>
                            <div class="col-sm-3 col-xs-4 pd0">
                                <select class="selectCss form-control" ng-model="memberType">
                                    <option value="">选择会员类型</option>
                                    <option value="1">有效会员</option>
                                    <option value="2">到期会员</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" class="form-control " ng-model="keywordBirthday" ng-keyup="enterSearchBirthday($event)" placeholder="  请输入姓名、手机号、客服进行搜索...">
                                <span class="input-group-btn">
                                    <button type="button" class="btn  btn-sm btn-primary" ng-click="searchCardBirthday()">搜索</button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-sm btn-info " ng-click="searchCardBirthdayClear()">&emsp;清空&emsp;</button>
                        </div>
                    </div>
                </div>
                <div class="ibox float-e-margins">
                    <div class="ibox-content h580" >
                        <div id="DataTables_Table_0_wrapper" class="pdB0 dataTables_wrapper form-inline" role="grid">
                            <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr role="row">
                                    <th class="" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;background-color: #FFF;" >序号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeBirSort('member_name',sort)">姓名
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeBirSort('member_sex',sort)">性别
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeBirSort('member_mobile',sort)">手机号
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeBirSort('seller',sort)">会籍顾问
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeBirSort('age',sort)">年龄
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" ng-click="changeBirSort('birthday',sort)">生日
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" style="width: 140px;" >操作
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr style="hoverTr" ng-repeat="bir in birthdayUserList">
                                    <td>{{8*(birMemberPageNow - 1) + $index + 1}}</td>
                                    <td>
                                        <span ng-if="bir.name !=null">{{bir.name}}</span>
                                        <span ng-if="bir.name ==null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="bir.sex == 1">男</span>
                                        <span ng-if="bir.sex == 2">女</span>
                                        <span ng-if="bir.sex ==null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="bir.mobile !=null">{{bir.mobile}}</span>
                                        <span ng-if="bir.mobile ==null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="bir.ename !=null">{{bir.ename}}</span>
                                        <span ng-if="bir.ename ==null">暂无数据</span>
                                    </td>
                                    <td>
                                        <span ng-if="bir.birth_date">{{bir.birth_date | birth | noData:''}}</span>
                                    </td>
                                    <td>
                                        <span ng-if="bir.birth_date !=null">{{bir.birth_date}}</span>
                                        <span ng-if="bir.birth_date ==null">暂无数据</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-default" ng-click="getMemberDataCardBtn(bir.id)">查看详情</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <?=$this->render('@app/views/common/nodata.php',['name'=>'birMemberInfo','text'=>'暂无数据','href'=>true]);?>
                            <?=$this->render('@app/views/common/pagination.php',['page'=>'birPages']);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>