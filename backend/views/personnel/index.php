<?php
use backend\assets\PersonalCtrlAsset;

PersonalCtrlAsset::register($this);
$this->title = '员工管理';
?>
<div ng-controller='personalCtrl' ng-cloak>
    <header>
<!--        <div class="wrapper wrapper-content  animated fadeIn">-->
<!--            <div class="row">-->
<!--                <div class="col-sm-12">-->
                    <div class="panel panel-default ">
                        <div class="panel-heading">
                           <span
                                class="displayInline-block"><b class="spanSmall">员工管理</b></span>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12 col-xs-12 pd0">
                                <div class="col-sm-6 col-xs-10 header1 col-sm-offset-3 col-xs-offset-1">
                                    <div class="input-group">
                                        <input type="text" class="form-control search" ng-model="keywords"
                                               ng-keyup="enterSearchs($event)" placeholder="  请输入姓名或别名进行搜索...">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-primary"
                                                        ng-click="searchEmployee()">搜索</button>
                                            </span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12 pd0">
                                    <h4 class="shaixuan">条件筛选</h4>
                                </div>
                                <div class=" col-sm-12 col-xs-12 pd0  shaixuan1" style="display: flex;justify-content: space-between;">
                                    <div class="  pd0 " style="display: flex;flex-wrap: wrap;z-index: 10;">
                                    <label for="id_label_single" class="" style="width: 120px;">
                                        <select ng-model="venueId" ng-change="getVenue(venueId)"
                                                class="js-example-basic-single1 js-states form-control width110PaddingBottom3"
                                                id="id_label_single">
                                            <option value="">选择公司</option>
                                            <option value="{{venue.id}}" ng-repeat="venue in optionVenue">{{venue.name}}
                                            </option>
                                        </select>
                                    </label>
                                    <label for="id_label_single" class=" venue"style="width: 120px;">
                                        <select ng-model="depId" ng-change="getDepartment(depId)"
                                                class="js-example-basic-single2 js-states form-control width110PaddingBottom3"
                                                id="id_label_single">
                                            <option value="">选择场馆</option>
                                            <option value="{{dep.id}}" ng-repeat="dep in Department">{{dep.name}}</option>
                                        </select>
                                    </label>
                                    <label for="id_label_single" class=" venue"style="width: 120px;">
                                        <select ng-model="department"
                                                class="js-example-basic-single3 js-states form-control width110PaddingBottom3"
                                                id="id_label_single">
                                            <option value="">选择部门</option>
                                            <option value="{{department.id}}" ng-repeat="department in departments">
                                                {{department.name}}
                                            </option>
                                        </select>
                                    </label>
                                    <button type="button" ladda="searchCarding" ng-click="searchEmployee()"
                                            class="btn btn-sm btn-success  sureButton">确定
                                    </button>
                                </div>

                                    <div class=" text-right">
                                        <li class="nav_add"style="padding-top: 0px;margin-right: 20px;">
                                            <ul>
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('employee', 'ADD')) { ?>
                                                    <li class="new_add" id="tmk" style="padding-top: 0px;">
                                                        <span class="btn btn-success  btn-sm" data-toggle="modal"
                                                              data-target="#myModal" ng-click="myModalAdd()" >新增员工</span>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12" style="padding: 0px">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>员工基本信息列表</h5>
                                <div class="ibox-tools">
                                </div>
                            </div>
                            <div class="ibox-content pd0">
                                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                    <div class="row" style="display: none;">
                                        <div class="col-sm-6">
                                            <div id="DataTables_Table_0_filter" class="dataTables_filter">

                                            </div>
                                        </div>
                                    </div>
                                    <table
                                        class="table table-striped table-bordered table-hover dataTables-example dataTable"
                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting w262" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序"
                                                ng-click="changeSort('employee_name',sort)">
                                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;姓名
                                            </th>
                                            <th class="sorting w292" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序"
                                                ng-click="changeSort('employee_name',sort)">
                                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;从业时间
                                            </th>
                                            <th class="sorting w200" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序"
                                                ng-click="changeSort('employee_name',sort)">
                                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;性别
                                            </th>
                                            <th class="sorting w262" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" aria-label="浏览器：激活排序列升序"
                                                ng-click="changeSort('employee_position',sort)">
                                                <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;职位
                                            </th>
                                            <th class="sorting w262" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1">
                                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>角色
                                            </th>
                                            <th class="sorting w262" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" aria-label="平台：激活排序列升序"
                                                ng-click="changeSort('employee_mobile',sort)">
                                                <span class="glyphicon glyphicon-phone" aria-hidden="true"></span>&nbsp;手机号
                                            </th>
                                            <th class="sorting w262" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序"
                                                ng-click="changeSort('employee_params',sort)">
                                                <span class="glyphicon glyphicon-education" aria-hidden="true"></span>&nbsp;课时
                                            </th>
                                            <th class="sorting w262" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序"
                                                ng-click="changeSort('employee_params',sort)">
                                                <span class="glyphicon glyphicon-sound-stereo"
                                                      aria-hidden="true"></span>&nbsp;课量
                                            </th>
                                            <th class="sorting w200" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" aria-label="引擎版本：激活排序列升序"
                                                ng-click="changeSort('employee_status',sort)">
                                                <span class="glyphicon glyphicon-sound-stereo"
                                                      aria-hidden="true"></span>&nbsp;状态
                                            </th>
                                            <th class="sorting w450" tabindex="0" aria-controls="DataTables_Table_0"
                                                rowspan="1" colspan="1" aria-label="CSS等级：激活排序列升序">
                                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;编辑
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="gradeA odd" ng-repeat='(index,data) in datas'>
                                            <td ng-click="employeeDetails(data.id,data.organization_name,data.name)">
                                                {{data.name | noData:''}}
                                            </td>
                                            <td ng-click="employeeDetails(data.id,data.organization_name,data.name)">
                                                {{data.work_date | noData:''}}
                                            </td>
                                            <td ng-click="employeeDetails(data.id,data.organization_name,data.name)">
                                                <span ng-if="data.sex == 1">男</span>
                                                <span ng-if="data.sex == 2">女</span>
                                                <span ng-if="data.sex == null">暂无数据</span>
                                            </td>
                                            <td ng-click="employeeDetails(data.id,data.organization_name,data.name)">
                                                <span ng-if="data.position != '' || data.position != null">{{data.position}}</span>
                                                <span ng-if="data.position == '' || data.position == null">暂无数据</span>
                                                <span class="label label-info" ng-if=data.level==0>新员工</span>
                                                <span class="label label-info" ng-if=data.level==1>低级</span>
                                                <span class="label label-info" ng-if=data.level==2>中级</span>
                                                <span class="label label-info" ng-if=data.level==3>高级</span>
                                            </td>

                                           <!-- <td  ng-if="data.status == 1" ng-click="employeeDetails(data.id,data.organization_name,data.name)">
                                            <td  ng-if="data.status == 1" ng-click="employeeDetails(data.id,data.organization_name,data.name)">
                                                {{data.roleName | noData:''}}
                                            </td>
                                            <td ng-if="data.status == 2" ng-click="employeeDetails(data.id,data.organization_name,data.name)">
                                                暂无数据
                                            </td>-->
                                            <td>
                                                <span ng-if="data.status != 2" ng-click="employeeDetails(data.id,data.organization_name,data.name)">{{data.roleName | noData:''}}</span>
                                                <span ng-if="data.status == 2" ng-click="employeeDetails(data.id,data.organization_name,data.name)">暂无数据</span>
                                            </td>
                                            <td ng-click="employeeDetails(data.id,data.organization_name,data.name)">
                                                {{data.mobile | noData:''}}
                                            </td>
                                            <td ng-click="employeeDetails(data.id,data.organization_name,data.name)">
                                                {{data.params | stringToJson:'classTime' | noData:''}}
                                            </td>
                                            <td ng-click="employeeDetails(data.id,data.organization_name,data.name)">
                                                {{data.params | stringToJson:'classAmount' | noData:''}}
                                            </td>
                                            <td ng-click="employeeDetails(data.id,data.organization_name,data.name)">
                                                {{data.status | noData:'' | employee_status_func}}
                                            </td>
                                            <td class="tdBtn">
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('employee', 'ABOUT')) { ?>
<!--                                                    离职员工不能约课-->
                                                    <button ng-if="data.status != 2" ng-click="employeeCourse(data.id)" class="btn btn-success btn-sm class1">
                                                        约课
                                                    </button>

                                                <?php } ?>
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('employee', 'UPDATE')) { ?>
                                                    <button class="btn btn-warning btn-sm class1" ng-click="getEmployee(data.id)">
                                                        <span class="list1">修改</span>
                                                    </button>
                                                <?php } ?>
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('employee', 'AUTH')) { ?>
                                                    <button class="btn btn-info btn-sm class1"
                                                            ng-click="allotAccount(data.id,data.admin_user_id)">
                                                        <span class='list1'>授权</span>
                                                    </button>
                                                <?php } ?>
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('employee', 'DELETE')) { ?>
                                                    <button class="btn btn-danger btn-sm class1" type="button"
                                                            ng-click="Employee(data.id,data.name)">
                                                        删除
                                                    </button>
                                                <?php } ?>
                                                <?php if (\backend\models\AuthRole::canRoleByAuth('employee', 'AUDIT')) { ?>
                                                    <span ng-if="data.is_check == 1">
                                                    <button class="btn btn-danger btn-sm"
                                                            ng-click="updateEmployee(data.id,index)" type="button"
                                                            ng-if="data.is_pass != 1">
                                                        <span>未审核</span>
                                                    </button>
                                                    <button class="btn btn-success btn-sm" type="button"
                                                            ng-if="data.is_pass == 1" disabled>
                                                        <span>已审核</span>
                                                    </button>
                                                </span>
                                                <?php } ?>

                                                <?php if (\backend\models\AuthRole::canRoleByAuth('employee', 'PERSONALITYSHOW')) { ?>
                                                    <button class="btn btn-primary btn-sm" ng-click="uploadPhoto(data.id)" type="button">
                                                        <span>展示</span>
                                                    </button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <?= $this->render('@app/views/common/nodata.php'); ?>
                                    <?=$this->render('@app/views/common/page.php');?>
                                </div>
                            </div>
                        </div>
                    </div>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </header>

    <!--新增和修改功能-->
    <?= $this->render('@app/views/personnel/editAndAdd.php'); ?>
  <!--    验证手指--><!--        //指纹 不能删除-->
    <div id="box" class="box" style="display: none;">
                            <h2>指纹登记</h2>
                            <div class="list">
                                <canvas id="canvas" width="430" height="450"
                                        style="background: rgb(243, 245, 240)"></canvas>
                                <input type="hidden" id="whetherModify" name="whetherModify" alt=""
                                       value="111" />

                                <div
                                    style="position: absolute; left: 310px; top: 325px; width: 70px; height: 28px;">
                                    <button type="button" class="btn btn-success btn-sm button-form" id="submitButtonId" name="makeSureName"
                                            onclick="submitEvent()">确定</button>
                                    <!-- ${common_edit_ok}:确定 -->
                                </div>
                                <div
                                    style="position: absolute; left: 310px; top: 365px; width: 70px; height: 28px;">
                                    <button type="button" class="btn btn-info  btn-sm button-form" type="button" id="closeButton"
                                            name="closeButton" onclick='cancelEvent("确认保存当前修改吗?", "指纹数:");'>
                                        取消</button>
                                    <!-- ${common_edit_cancel}:取消 -->
                                </div>
                            </div>
                        </div>

    <!--详情页面、批量转移、选择私教并转移、选择成功页面提示、分配账号、审核、自定义销售渠道-->
    <?= $this->render('@app/views/personnel/detailAndoperation.php'); ?>
    <?= $this->render('@app/views/common/coursePrint.php'); ?>
    <div class="modal fade" id="fieldModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog " role="document" style="width: 840px;">
            <div class="modal-content clearfix">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" id="myModalLabel" >个人形象展示</h4>
                </div>
                <div class="modal-body row pB0 pT0 pL15"style="padding: 0 15px;" >
                    <div class="col-sm-12 pd0">
                        <div class="col-sm-3 pd0 switchCabinetArea" >
                            <ul class="checkUl">
                                <li class="SiteManagement cp" ng-click="changeUploadType('pic')" style="text-align: center;padding: 10px;border-bottom: solid 1px #E5E5E5;">
                                    <div><p ng-class="{'active': isActive}">图片</p></div>
                                </li>
                                <li class="SiteManagement cp" ng-click="changeUploadType('sp')" style="text-align: center;padding: 10px;border-bottom: solid 1px #E5E5E5;">
                                    <div><p ng-class="{'active': !isActive}">视频</p></div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-9 pd0">
                            <div class="ibox float-e-margins boxShowNone borderNone switchCabinetAreaCabinetNum" style="min-width: 200px;min-height: 200px">
                                <div ng-show="isActive" class="ibox-content borderNone pd10" >
                                    <div ng-if="picsAll.length" class="uploadImgDiv" ng-repeat="(index, pic) in picsAll" style="text-align: center;margin-top: 20px;position: relative">
                                        <img style="width: 50%" ng-src="{{pic.url}}" class="upImg">
                                        <span class="delImg" ng-click="delPic(pic.id, 'yesUpload')">×</span>
                                    </div>
                                    <div ng-if="picUrl.length" class="uploadImgDiv" ng-repeat="(index, pic) in picUrl" style="text-align: center;margin-top: 20px;position: relative">
                                        <img style="width: 50%" ng-src="{{pic}}" class="upImg">
                                        <span class="delImg" ng-click="delPic(index, 'noUpload')">×</span>
                                    </div>
                                </div>
                                <div ng-show="!isActive" class="ibox-content borderNone pd10" >
                                    <div style="width: 30px;margin: 0 auto;padding-top: 135px;" ng-if="isLoading">
                                        <i class="fa fa-sun-o fa-spin fa-3x fa-fw"></i>
                                    </div>
                                    <div id="video-box" ng-if="videoUrl" style="text-align: center;margin-top: 20px">
                                        <video style="width: 60% !important;height: 300px !important;" controls preload="auto" width="300" height="400">
                                            <source ng-src="{{rr(videoUrl)}}" type="video/mp4">
                                            <!--                                            <source src="" type="video/mp4">-->
                                        </video>
                                        <span class="delImg" ng-click="delVideo()">×</span>
                                    </div>
                                </div>
                            </div>
                            <div ng-if="isActive" class="col-sm-12" style="padding-left: 170px;color: orange"><i class="glyphicon glyphicon-info-sign"></i>上传照片不能大于2M</div>
                            <div ng-if="!isActive" class="col-sm-12" style="padding-left: 170px;color: orange"><i class="glyphicon glyphicon-info-sign"></i>上传视频不能大于20M</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center" style="text-align: center">
                    <div class="btn btn-sm btn-success" ngf-drop="setCover5($file)" ngf-select="setCover5($file)" uploader="uploader" style="width: 90px;height: 30px;position: relative;background: #4cae4c;display: inline-block">
                        <p style="font-size: 15px;color: white;position: absolute;left: 30px;top: 4px;">上传</p>
                        <input type="file" style="opacity: 0" class="form-control upLoadInput">
                    </div>
                    <div class="uploadImgBtn" style="display: inline-block">
                        <button class="btn btn-sm btn-info" ng-click="getArray()">保存</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

