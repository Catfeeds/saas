<?php

namespace backend\controllers;

use backend\models\AddPositionForm;
use backend\models\Admin;
use backend\models\AssignAdminForm;
use backend\models\AuthRole;
use backend\models\Position;
use common\models\Func;
use backend\models\Employee;
use backend\models\EmployeeRuleForm;
use backend\models\EmployeeUpdateForm;
use backend\models\Member;
use backend\models\AboutClass;
use backend\models\Organization;
use backend\models\EmployeeDataForm;
use backend\models\PasswordDataForm;
use backend\models\PasswordResetRequestForm;
use backend\models\EmployeeTurnMemberRecord;
use backend\models\PersonalityImagesForm;
use common\models\base\PersonalityImages;
use yii;

class PersonnelController extends BaseController
{

    /**
     * 员工管理 - 首页 - 列表的展示和新增员工
     * @return string
     * @auther 梁可可
     * @create 2017-3-21
     * @param
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 员工管理 - 员工约课 - 员工约课页面
     * @return string
     * @auther 程丽明
     * @create 2017-6-2
     * @param
     */
    public function actionCourse()
    {
        return $this->render('employeeCourse');
    }

    /**
     * 员工管理 - 首页 - 修改页面
     * @return string
     * @auther 梁可可
     * @create 2017-3-30
     * @param
     */
    public function actionEdit()
    {
        return $this->render('edit');
    }

    /**
     *后台员工管理 - 员工基本信息查询 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/24
     * @return bool|string
     */
    public function actionEmployeeInfo()
    {
        $params = $this->get;
        $model = new Employee();
        $employeeInfo = $model->search($params);

        $pagination = $employeeInfo->pagination;
        $pages = Func::getPagesFormat($pagination);

        return json_encode(['data' => $employeeInfo->models, 'pages' => $pages]);
    }

    /**
     *后台员工管理 - 员工基本信息 - 员工表删除
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/4/24
     * @return bool|string
     */
    public function actionEmployeeDel()
    {
        if (!AuthRole::canRoleByAuth('employee', 'DELETE')) {
            throw new yii\web\UnauthorizedHttpException('抱歉，您没有权限删除，请联系管理员');
        }
        $employeeId = Yii::$app->request->get('employeeId');
        $model = new Employee();
        $delRes = $model->getEmployeeDel($employeeId);
        if ($delRes) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败或者此员工有所属会员']);
        }
    }

    /**
     * 后台 - 员工管理-  新增员工
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/4/24
     * @param
     * @return object   //返回所有员工添加结果
     */
    public function actionAddData()
    {
        if (!AuthRole::canRoleByAuth('employee', 'ADD')) {
            throw new yii\web\UnauthorizedHttpException('抱歉，您没有权限添加，请联系管理员');
        }
        $post = \Yii::$app->request->post();

        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $model = new EmployeeRuleForm([], $companyId, $venueId);
        $model->setScenario('addEmployee');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->addMyData();
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else {
                return json_encode(['status' => 'success', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台员工管理 - 员工信息查询 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/26
     * @return bool|string
     */
    public function actionEmployeeDetails()
    {
        $EmployeeId = Yii::$app->request->get('EmployeeId');
        if (!empty($EmployeeId)) {
            $model = new Employee();
            $EmployeeData = $model->getEmployeeModel($EmployeeId);
            return json_encode($EmployeeData);
        } else {
            return false;
        }
    }

    /**
     * 员工管理 - 员工修改 - 接受并且修改员工信息
     * @return object
     * @author huanghua<huanghua@itsports.club>
     * @create 2017-4-26
     * @param
     */

    public function actionUpdateData()
    {
        if (!AuthRole::canRoleByAuth('employee', 'UPDATE')) {
            throw new yii\web\UnauthorizedHttpException('抱歉，您没有权限修改，请联系管理员');
        }
        $post = \Yii::$app->request->post();
        //var_dump($post);die;
        $model = new EmployeeUpdateForm();
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->updateData();
            if ($result) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'success', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api {get} /personnel/get-venue  获取公司
     * @apiVersion 1.0.0
     * @apiName  获取公司
     * @apiGroup  personnel
     * @apiPermission 管理员
     *
     * @apiDescription 获取公司<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/2<br>
     * <span><strong>调用方法：</strong></span>/personnel/get-venue
     *
     * @apiSampleRequest  http://qa.uniwlan.com/personnel/get-venue
     * @apiSuccessExample {json} 成功示例:
     * {
     * "venues": [
     * {
     * "id": "1",
     * "pid": "0",
     * "name": "我爱运动瑜伽健身俱乐部",
     * }
     *      ]
     * }
     * @apiErrorExample {json} 错误示例:
     * {
     * "venues": []
     * }
     */
    public function actionGetVenue()
    {
        $organ = new Employee();
        $venue = $organ->getOrganizationOption();
        return json_encode(['venue' => $venue]);
    }

    /**
     * @api {get} /personnel/get-venue-data  获取场馆
     * @apiVersion 1.0.0
     * @apiName  获取场馆
     * @apiGroup  personnel
     * @apiPermission 管理员
     *
     * @apiDescription 获取场馆<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/2<br>
     * <span><strong>调用方法：</strong></span>/personnel/get-venue-data
     *
     * @apiSampleRequest  http://qa.uniwlan.com/personnel/get-venue -data
     * @apiSuccessExample {json} 成功示例:
     * {
     * "venues": [
     * {
     * "id": "2",
     * "pid": "1",
     * "name": "大上海馆",
     * }
     *      ]
     * }
     * @apiErrorExample {json} 错误示例:
     * {
     * "venues": []
     * }
     */
    public function actionGetVenueData()
    {
        $companyId = \Yii::$app->request->get('companyId');
        $organ = new Employee();
        $venue = $organ->getOrganizationAuthData($companyId);
        return json_encode(['venue' => $venue]);
    }

    /**
     * @api {get} /personnel/get-venue-all-data  获取所有场馆
     * @apiVersion 1.0.0
     * @apiName  获取所有场馆
     * @apiGroup  personnel
     * @apiPermission 管理员
     *
     * @apiDescription  获取所有场馆<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/2<br>
     * <span><strong>调用方法：</strong></span>/personnel/get-venue-all-data
     *
     * @apiSampleRequest  http://qa.uniwlan.com/personnel/get-venue-all-data
     * @apiSuccessExample {json} 成功示例:
     * {
     * "venues": [
     * {
     * "id": "2",
     * "pid": "1",
     * "name": "大上海馆",
     * }
     *      ]
     * }
     * @apiErrorExample {json} 错误示例:
     * {
     * "venues": []
     * }
     */
    public function actionGetVenueAllData()
    {

        $organ = new Employee();
        $venues = $organ->getVenueOption();
        return json_encode(['venues' => $venues]);
    }
    /**
     * 云运动 - 添加员工 - 获取部门信息
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017-4-26
     * @return string
     */

    /**
     * @api {get} /personnel/get-department  获取部门
     * @apiVersion 1.0.0
     * @apiName  获取部门
     * @apiGroup  personnel
     * @apiPermission 管理员
     *
     * @apiDescription 获取部门<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/2<br>
     * <span><strong>调用方法：</strong></span>/personnel/get-department
     *
     * @apiSampleRequest  http://qa.uniwlan.com/personnel/get-department
     * @apiSuccessExample {json} 成功示例:
     * {
     * "venues": [
     * {
     * "id": "3",
     * "pid": "2",
     * "name": "私教部",
     * }
     *      ]
     * }
     * @apiErrorExample {json} 错误示例:
     * {
     * "venues": []
     * }
     */
    public function actionGetDepartment()
    {
        $venueId = \Yii::$app->request->get('depId');
        $organ = new Employee();
        $venue = $organ->getDepartmentData($venueId);
        return json_encode(['venue' => $venue]);
    }
    /**
     * 云运动 - 搜索 - 获取所有部门信息
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017-5-8
     * @return string
     */

    /**
     * @api {get} /personnel/get-department-all-data 获取所有部门
     * @apiVersion 1.0.0
     * @apiName 获取所有部门
     * @apiGroup personnel
     * @apiPermission 管理员
     *
     * @apiDescription 获取所有部门<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/2<br>
     * <span><strong>调用方法：</strong></span>/personnel/get-department-all-data
     *
     * @apiSampleRequest  http://qa.uniwlan.com/personnel/get-department-all-data
     * @apiSuccessExample {json} 成功示例:
     * {
     * "venues": [
     * {
     * "id": "3",
     * "pid": "2",
     * "name": "私教部",
     * }
     *      ]
     * }
     * @apiErrorExample {json} 错误示例:
     * {
     * "venues": []
     * }
     */
    public function actionGetDepartmentAllData()
    {

        $organ = new Organization();
        $department = $organ->getOrganizationDepartment($this->venueId);
        return json_encode(['department' => $department]);
    }

    /**
     * @describe 后台会员管理 - 会员信息查询 - 会员卡状态修改
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @param $id
     * @return string
     * @throws yii\web\UnauthorizedHttpException
     */
    public function actionUpdateStatus($id)
    {
        if (!AuthRole::canRoleByAuth('employee', 'AUDIT')) {
            throw new yii\web\UnauthorizedHttpException('抱歉，您没有权限审核，请联系管理员');
        }
        $status = Employee::getUpdateEmployee($id);
        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '审核成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }

    }

    /**
     * 云运动  - 添加教练 - 查询手机号是否存在（groupClassController.js请求）
     * @author Huang hua <huanghua@itsports.club>
     * @update 2017-5-4
     * @return string
     */
    public function actionGetMobile()
    {
        $mobile = \Yii::$app->request->get('mobile');
        $model = new Employee();
        $data = $model->getMobileInfo($mobile);
        if ($data && !empty($data)) {
            return json_encode(['status' => 'error']);   //手机号存在
        } else {
            return json_encode(['status' => 'success']); //手机不存在
        }
    }

    /**
     * @api {post} /personnel/assign-admin  分配账号
     * @apiVersion 1.0.0
     * @apiName  分配账号
     * @apiGroup  personnel
     * @apiPermission 管理员
     *
     * @apiDescription 管理员可以进入员工管理给员工分配账号
     *<br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/24
     *
     * @apiParam  {int}   username       账号名称.
     * @apiParam  {string} password       密码.mobile
     * @apiParam  {int}   venueId        场馆Id.
     * @apiParam  {int}   employeeId        员工Id.
     * @apiParam  {int}   mobile           手机号.
     * @apiParam  {int}  [adminId]       管理员ID修改是必传
     * @apiParam  {string} scenario      场景：添加(insert) 修改(update)
     * @apiParam  {int}    level         级别
     * @apiParam  {string} _csrf_backend  csrf验证.
     *
     * @apiSampleRequest  http://qa.uniwlan.com/personnel/assign-admin
     *
     * @apiSuccess (返回值) {string} status 取消状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':‘分配成功’}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':预约失败数据}
     */
    /**
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-08-01
     * @return string
     * @throws yii\db\Exception
     */
    public function actionAssignAdmin()
    {
        $post = Yii::$app->request->post();
        $scenario = isset($post['scenario']) ? $post['scenario'] : 'insert';
        $model = new AssignAdminForm([], $scenario);
        if ($model->load($post, '') && $model->validate()) {
            if ($scenario == 'update') {
                $assign = $model->saveUpdate();
            } else {
                $assign = $model->saveAssign();
            }
            if ($assign === true) {
                return json_encode(['status' => 'success', 'data' => '分配成功']);
            }
            return json_encode(['status' => 'error', 'data' => $assign]);
        }
        return json_encode(['status' => 'error', 'data' => $model->errors]);
    }

    /**
     * @api {get} /personnel/get-assign-admin 获取权限分类
     * @apiVersion 1.0.0
     * @apiName 获取权限分类
     * @apiGroup personnel
     * @apiPermission 管理员
     *
     * @apiDescription 管理员可以进入分配账号页面可以获取权限分类
     *<br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/24
     *
     * @apiSampleRequest  http://qa.uniwlan.com/personnel/get-assign-admin
     *
     * @apiSuccess (返回值) {string} status 取消状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':{1:'超级管理员'}}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':预约失败数据}
     */
    public function actionGetAssignAdmin()
    {
        return json_encode(['status' => 'success', 'data' => []]);
    }

    /**
     * @api {get} /personnel/get-employee-admin-level-one 获取员工权限信息
     * @apiVersion 1.0.0
     * @apiName 获取员工权限信息
     * @apiGroup personnel
     * @apiPermission 管理员
     *
     * @apiDescription 管理员可以进入分配账号页面可以获取员工权限信息
     *<br/>
     * <span><strong>作    者：</strong></span>李慧恩<br>
     * <span><strong>邮    箱：</strong></span>lihuien@itsprts.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/24
     *
     * @apiSampleRequest  http://qa.uniwlan.com/personnel/get-employee-admin-level-one
     *
     * @apiSuccess (返回值) {string} status 取消状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':{username:'lll'...}}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':[]}
     */
    public function actionGetEmployeeAdminLevelOne($id)
    {
        $rules = new Admin();
        $data = $rules->getEmployeeAdmin($id);
        return json_encode(['status' => 'success', 'data' => $data]);
    }

    /**
     * @api {get} /personnel/get-employee-member 获取销售顾问下的会员信息
     * @apiVersion 1.0.0
     * @apiName 获取销售顾问下的会员信息
     * @apiGroup personnel
     * @apiPermission 管理员
     *
     * @apiParam {int} employeeId   销售员工id
     *
     * @apiDescription 管理员进入员工详情基本信息-销售人员下的会员信息
     * <br/>
     * <span><strong>作    者：</strong></span>黄华<br>
     * <span><strong>邮    箱：</strong></span>huanghua@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/6
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/personnel/get-employee-member
     * @apiSampleRequest  http://qa.uniwlan.com/personnel/get-employee-member
     *
     * @apiSuccess(返回值) {object}  data  销售员工下的会员信息 ｛name：会员名称，sex：性别,mobile：手机号，status:会员状态，register_time:注册时间,invalid_time:失效时间｝
     *
     */
    public function actionGetEmployeeMember()
    {
        $params = \Yii::$app->request->queryParams;
        $employeeId = $params['employeeId'];
        if (!empty($employeeId)) {
            $model = new Employee();
            $employeeInfo = $model->employeeMember($params);
            $pagination = $employeeInfo->pagination;
            $pages = Func::getPagesFormat($pagination, 'replaceMemberInfo');
            return json_encode(['data' => $employeeInfo->models, 'pages' => $pages]);
        } else {
            return false;
        }

    }

    /**
     * 员工管理 - 员工详情 - 私教下的所有会员
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/9
     * @return \yii\db\ActiveQuery
     */
    public function actionSellEmployeeMember()
    {
        $params = \Yii::$app->request->queryParams;
        $employeeId = $params['employeeId'];
        if (!empty($employeeId)) {
            $model = new AboutClass();
            $employeeInfo = $model->employeeMember($params);
            $pagination = $employeeInfo->pagination;
            $pages = Func::getPagesFormat($pagination, 'replaceMemberInfo');
            return json_encode(['data' => $employeeInfo->models, 'pages' => $pages]);
        } else {
            return false;
        }

    }

    /**
     * 员工管理 - 员工详情 - 修改批量转移会员的顾问id
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/6
     * @return \yii\db\ActiveQuery
     */
    public function actionUpdateMemberStatus()
    {
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $memberId = \Yii::$app->request->post('memberId');//会员id
        $counselorId = \Yii::$app->request->post('counselorId');//新教练id
        $type = \Yii::$app->request->post('type');//类型
        $employeeId = \Yii::$app->request->post('employeeId');//原教练id
        $status = Member::getUpdateEmployee($memberId, $counselorId, $type, $employeeId, $companyId, $venueId);
        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }

    }

    /**
     * 员工管理 - 员工详情 - 获取所有员工数据
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/6
     * @return \yii\db\ActiveQuery
     */
    public function actionGetEmployeeData()
    {
        $model = new Employee();
        $data = $model->getEmployeeData();
        return json_encode($data);
    }

    /**
     * 员工管理 - 员工详情 - 选择员工
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/6
     * @return \yii\db\ActiveQuery
     */
    public function actionChooseEmployeeData()
    {
        $employeeId = Yii::$app->request->get('employeeId');
        if (!empty($employeeId)) {
            $model = new Employee();
            $employeeData = $model->getChooseEmployee($employeeId);
            return json_encode($employeeData);
        } else {
            return false;
        }
    }

    /**
     * @api {get} /personnel/get-employee-name 添加员工名去重
     * @apiVersion 1.0.0
     * @apiName 添加员工名去重
     * @apiGroup personnel
     * @apiPermission 管理员
     *
     * @apiParam {string} name   员工名字
     *
     * @apiDescription 管理员进入员工管理-添加员工姓名
     * <br/>
     * <span><strong>作    者：</strong></span>黄华<br>
     * <span><strong>邮    箱：</strong></span>huanghua@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/13
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/personnel/get-employee-name
     * @apiSampleRequest  http://qa.uniwlan.com/personnel/get-employee-name
     *
     *
     * @apiSuccess (返回值) {string} status 添加状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':‘员工姓名不存在,添加成功’}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':员工姓名存在}
     */
    public function actionGetEmployeeName()
    {
        $name = \Yii::$app->request->get('name');
        $model = new Employee();
        $data = $model->getEmployeeName($name,$this->companyIds);
        if ($data && !empty($data)) {
            return json_encode(['status' => 'error']);   //员工姓名存在
        } else {
            return json_encode(['status' => 'success']); //员工姓名不存在
        }
    }

    /**
     * @api {get} /personnel/employee-center 员工个人中心数据
     * @apiVersion 1.0.0
     * @apiName 员工个人中心数据
     * @apiGroup personnel
     * @apiPermission 管理员
     *
     * @apiParam {string} name   员工名字
     * @apiParam {int} sex   性别1男2女
     * @apiParam {string} pic   员工头像
     * @apiParam {int} admin_user_id   管理员id
     * @apiParam {string} position   职务
     * @apiParam {string} mobile   电话
     * @apiParam {string} username   账号
     * @apiParam {string} name(role下的) 权限
     *
     * @apiDescription 管理员进入角色管理-查看个人中心数据
     * <br/>
     * <span><strong>作    者：</strong></span>黄华<br>
     * <span><strong>邮    箱：</strong></span>huanghua@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/7/6
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/personnel/employee-center
     * @apiSampleRequest  http://qa.uniwlan.com/personnel/employee-center
     *
     *
     *
     */
    public function actionEmployeeCenter()
    {
        $model = new Employee();
        $employeeData = $model->getEmployeeCenter(self::$_userId);

        return json_encode($employeeData);
    }

    /**
     * @api{post} /personnel/update-pic 角色管理 - 修改头像
     * @apiVersion  1.0.0
     * @apiName 角色管理 - 修改头像
     * @apiGroup personnel
     * @apiPermission 管理员
     *
     * @apiParam {string} id   修改的员工id
     * @apiParam {string} pic  员工头像
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "id":"1"
     *        "pic": "fjkdljsldgjsdl",
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 角色管理 - 修改头像<br/>
     * <span><strong>作   者：</strong></span>黄华<br/>
     * <span><strong>邮   箱：</strong></span>huanghua@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/6<br/>
     * <span><strong>调用方法：</strong></span>/personnel/update-pic
     * @apiSampleRequest  http://qa.uniwlan.com/personnel/update-pic
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"修改成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *   'data':{
     *     'name':'修改图片名不能为空'
     *   }}
     */
    public function actionUpdatePic()
    {
        $post = \Yii::$app->request->post();
        $model = new EmployeeDataForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->updateData();
            if (!empty($data) && isset($data)) {
                return json_encode(['status' => 'success', 'data' => '修改成功', 'pic' => $data['pic']]);
            } else {
                return json_encode(['status' => 'success', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api{post} /personnel/update-password 角色管理 - 旧密码修改
     * @apiVersion  1.0.0
     * @apiName 角色管理 - 旧密码修改
     * @apiGroup personnel
     * @apiPermission 管理员
     *
     * @apiParam {int} id   修改的管理员id
     * @apiParam {string} oldPassword 旧密码
     * @apiParam {string} password   新密码
     * @apiParam {string} rePassword  确认新密码
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "id":"1"
     *        "oldPassword": "123456",
     *        "password": "654321",
     *        "rePassword": "654321",
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 角色管理 - 旧密码修改<br/>
     * <span><strong>作   者：</strong></span>黄华<br/>
     * <span><strong>邮   箱：</strong></span>huanghua@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/6<br/>
     * <span><strong>调用方法：</strong></span>/personnel/update-password
     * @apiSampleRequest  http://qa.uniwlan.com/personnel/update-password
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"修改成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *   'data':{
     *     'name':'修改的密码不符合规范'
     *   }}
     */
    public function actionUpdatePassword()
    {
        $post = \Yii::$app->request->post();
        $model = new PasswordDataForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->updatePassword();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'success', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @云运动 - 个人中心 - 验证码方式重置密码
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/7/7
     * @inheritdoc
     */

    public function actionResetPassword()
    {
        $post = \Yii::$app->request->post();
        $model = new PasswordResetRequestForm();
        if ($model->load($post, '')) {
            $model->loadCode();
            if ($model->validate()) {
                $data = $model->loadPassword();
                if ($data === true) {
                    return json_encode(['status' => 'success', 'data' => '重置密码成功']);
                } else {
                    return json_encode(['status' => 'error', 'data' => $data]);
                }
            }
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @云运动 - 个人中心 - 验证码方式修改密码生成验证码
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/7/7
     * @inheritdoc
     */
    public function actionCreateCode()
    {
        $mobile = \Yii::$app->request->post();
        if (!isset($mobile) && !isset($mobile['mobile'])) {
            return json_encode(['status' => 'error', 'data' => '请填写正确的手机号']);
        }

        $code = mt_rand(100000, 999999);
        $time = time();
        $temp = [
            'code' => $code,
            'time' => $time,
            'mobile' => $mobile['mobile']
        ];
        $session = \Yii::$app->session;
        $session->set('sms', $temp);
        Func::sendCode($mobile['mobile'], $code);
        return json_encode(['status' => 'success', 'data' => $code]);

    }

    /**
     * 云运动 - 员工管理 - 获取员工职位
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/15
     * @param  $branchId
     * @param $companyId
     * @return string
     */
    public function actionGetEmployeePosition($branchId, $companyId)
    {
        $model = new Position();
        $data = $model->getPositionAllByVenueId($branchId, $companyId);

        return json_encode(['attributes' => $data]);
    }

    /**
     * 云运动 - 员工管理 - 删除员工职位
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/15
     * @param  $id
     * @return string
     */
    public function actionDeletePositionById($id)
    {
        $model = new Position();
        $data = $model->deletePositionById($id);
        if ($data != 'error') {
            return json_encode(['status' => 'success', 'message' => '删除成功', 'data' => '删除成功']);
        }
        return json_encode(['status' => 'error', 'message' => '删除失败', 'data' => '此职位下已经分配员工,不能删除']);
    }

    /**
     * 云运动 - 员工管理 - 添加员工职位
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/15
     * @return string
     */
    public function actionSetEmployeePosition()
    {
        $post = Yii::$app->request->post();
        $model = new AddPositionForm();
        if ($model->load($post, '') && $model->validate()) {
            $save = $model->savePosition();
            if (isset($save->id)) {
                return json_encode(['status' => 'success', 'message' => '添加成功', 'data' => $save->id]);
            }
            return json_encode(['status' => 'error', 'message' => '添加失败', 'data' => $save]);
        }
        return json_encode(['status' => 'error', 'message' => '添加失败', 'data' => $model->errors]);
    }

    /**
     * 云运动 - 员工管理 - 转移会员记录列表
     * @author 黄华 <huanghua@itsports.club>
     * @create 2018/4/4
     * @return array
     */
    public function actionTurnMemberInfo()
    {
        $id = \Yii::$app->request->get('employeeId');
        if (!empty($id)) {
            $model = new EmployeeTurnMemberRecord();
            $data = $model->turnMemberRecord($id);
            return json_encode(['data' => $data]);
        } else {
            return false;
        }
    }

    /**
     * @desc:上传私教风采视频
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/5/25
     * @time: 16:32
     */
    public function actionPersonalityVideo()
    {
        $post = \Yii::$app->request->post();
        $model = new Employee();
        $re = $model->personalityIs($post['employee_id']);
        if ($re == false) {
            return json_encode(['status' => 'error', 'data' => '该职员非私教成员']);
        }

        $model = new PersonalityImagesForm();
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->addPersonalityVideo();
            if ($result) {
                return json_encode(['status' => 'success', 'data' => '添加成功']);
            } else {
                return json_encode(['status' => 'success', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }


    /**
     * @desc:批量上传私教风采展示照片
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/5/26
     * @time: 9:10
     */
    public function actionPersonalityPicture()
    {
        $post = \Yii::$app->request->post();
        $model = new Employee();
        $re = $model->personalityIs($post ['employee_id']);
        if ($re == false) {
            return json_encode(['status' => 'error', 'data' => '该职员非私教成员']);
        }

        if (!$post['url']) {
            return json_encode(['status' => 'success', 'data' => '操作成功']);
        }
        $data = [];
        $transaction = \Yii::$app->db->beginTransaction();       //开启事务
        try {
            foreach ($post ['url'] as $key => $value) {
                $data[$key]['type'] = $post ['type'];
                $data[$key]['employee_id'] = $post ['employee_id'];
                $data[$key]['url'] = $value;
                $data[$key]['create_at'] = time();
            }

            $model = new PersonalityImagesForm();
            foreach ($data as $k => $v) {
                if ($model->load($v, '') && !$model->validate()) {
//                    throw new \Exception($model->errors['url'][0]);
                    return json_encode(['status' => 'error', 'data' => '数据有丢失']);
                }
            }

            $result = Yii::$app->db->createCommand()
                ->batchInsert(PersonalityImages::tableName(), ['type', 'employee_id', 'url', 'create_at',], $data)
                ->execute();
            if ($result != true) {
//                throw new \Exception('操作失败');
                return json_encode(['status' => 'error', 'data' => '操作失败！']);
            }

            $transaction->commit();
            return json_encode(['status' => 'success', 'data' => '上传成功！']);

        } catch (\Exception $e) {
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return $e->getMessage();  //获取抛出的错误
        }
    }

    /**
     * @desc:获取私教个人信息
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/5/25
     * @time: 16:59
     * @return bool|string
     */
    public function actionPersonalityDetails()
    {

        $employeeId = Yii::$app->request->get('employeeId');
        $type = Yii::$app->request->get('type');
        if (!empty($employeeId)) {
            $model = new Employee();
            $EmployeeData = $model->personalityPictureShow($employeeId, $type);

            return json_encode($EmployeeData);
        } else {
            return false;
        }
    }

    /**
     * @desc:相册删除删除功能
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/5/29
     * @time: 9:32
     */
    public function actionPersonalityDel()
    {
        $id = Yii::$app->request->get('id');

        if ($id) {

            $info = PersonalityImages::findOne($id);
            if ($info->delete()) {
                return json_encode(['status' => 'success', 'data' => '删除成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => '删除失败']);
            }

        } else {

            return false;
        }
    }


    /**
     * @desc:y员工约课记录
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/5/30
     * @time: 15:28
     */
    public function actionEmployeeAboutClass()
    {
        $employeeId = \Yii::$app->request->get('employeeId');

        if ($employeeId) {

            $AboutClass = new AboutClass();
            $data = $AboutClass->employeeAboutClass($employeeId);

            return json_encode(['data' => $data]);

        } else {
            return false;
        }
    }
}
