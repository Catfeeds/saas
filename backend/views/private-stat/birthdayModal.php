<!--生日会员模态框-->
<div style="overflow: auto;" class="modal fade" id="birthdayModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog wB90" role="document" style="width: 80%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="text-center">生日会员</h4>
            </div>
            <div class="modal-body row mr0">
                <div class="col-md-12 pd0 mb10">
                    <div class="col-sm-6 col-sm-offset-3">
                        <div class="input-group">
                            <input type="text" class="form-control h34" ng-model="memberBirKeywords" ng-keyup="enterSearchMemberBir123($event)" placeholder="请输入会员姓名、手机号进行搜索...">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-success" ng-click="searchMemberBir()">搜索</button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 pd0 mb10">
                    <div class="col-lg-2 col-md-3 col-sm-3 pd0 mr10 mb10">
                        <select class="form-control pl4 pd4 birthVenueSelect">
                            <option value="{{v.id}}" ng-repeat="v in venueList">{{v.name}}</option>
                        </select>
                    </div>
                    <div  class="col-lg-2 col-md-2 col-sm-2 col-xs-6 pdL0 mb10" >
                        <select class="form-control pl4 pd4" ng-model="ptClassStatus">
                            <option value="">会员类别</option>
                            <option value="1">正式客户</option>
                            <option value="2">潜在客户</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-5 col-sm-6 col-xs-6 pdL0 mb10">
                        <div class="input-daterange input-group cp userTimeRecord" >
                            <span class="add-on input-group-addon">会员生日</span>
                            <input type="text" readonly name="reservation" id="birthdayDate" class="form-control text-center " >
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-3 pd0 mb10">
                        <button class="btn  btn-info  pd4" ng-click="searchMemberBir()">确定</button>
                        <button class="btn  btn-default pd4" ng-click="memberBirSubmitClear()">清空</button>
                    </div>
                </div>
                <table class="table table-striped table-bordered table-hover dataTables-example dataTable" id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                    <thead>
                    <tr role="row">
                        <th>序号</th>
                        <th>会员姓名</th>
                        <th>性别</th>
                        <th>手机号</th>
                        <th>生日</th>
                       <!-- <th>私教来源</th>
                        <th>最近跟进</th>-->
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="member in allMemberBirthdayLists">
                        <td ng-click="getMemberDataCardBtn(member.id)">{{8*(allMemberNow - 1)+$index+1}}</td>
                        <td ng-click="getMemberDataCardBtn(member.id)">{{member.name}}</td>
                        <td ng-click="getMemberDataCardBtn(member.id)">{{member.sex == '1'?'男':member.sex == '2'?'女':'暂无'}}</td>
                        <td ng-click="getMemberDataCardBtn(member.id)">{{member.mobile | noData:''}}</td>
                        <td ng-click="getMemberDataCardBtn(member.id)">{{member.birth_date | noData:''}}</td>
                       <!-- <td>转介绍</td>
                        <td>2018-06-25</td>-->
                        <td>
                            <button class="btn btn-default" ng-click="getMemberDataCardBtn(member.id)">查看详情</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?=$this->render('@app/views/common/nodata.php',['name'=>'allMemberFlag','text'=>'暂无数据','href'=>true]);?>
                <?=$this->render('@app/views/common/pagination.php',['page'=>'allMemberPages']);?>
            </div>
            <div class="modal-footer">
                <span class="footerSpan">共计：{{total5}}人</span>
                <button type="button" class="btn btn-default w100" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>
