<?php

namespace backend\controllers;

use backend\models\AuthRole;
use backend\models\ClassRoom;
use backend\models\Organization;
use backend\models\OrganizationRuleForm;
use common\models\Func;
use yii\web\UnauthorizedHttpException;

class MainController extends BaseController
{

    /**
     * 组织架构管理 - 首页 - 列表的展示和新增组织架构
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
     * 组织架构管理 - 首页 - 修改页面
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
     * 组织架构管理 - 场地 - 场地页面
     * @return string
     * @auther 程丽明
     * @create 2017-4-5
     * @param
     */
    public function actionSite()
    {
        return $this->render('site');
    }

    /**
     * 组织架构管理 - 场地 - 场地页面
     * @return string
     * @auther 程丽明
     * @create 2017-4-5
     * @param
     */
    public function actionFacility()
    {
        return $this->render('facility');
    }

    /**
     * 组织架构管理 - 场地添加 - 场地添加页面
     * @return string
     * @auther 程丽明
     * @create 2017-4-6
     * @param
     */
    public function actionAddSite()
    {
        return $this->render('addSite');
    }

    /**
     * 组织架构管理 - 场馆添加 - 场馆添加页面
     * @return string
     * @auther 程丽明
     * @create 2017-4-6
     * @param
     */
    public function actionAddVenue()
    {
        return $this->render('addVenue');
    }

    /**
     * 组织架构管理 - 设备添加 - 设备添加页面
     * @return string
     * @auther 程丽明
     * @create 2017-4-6
     * @param
     */
    public function actionAddFacility()
    {
        return $this->render('addFacility');
    }

    /**
     * 组织架构管理 - 公司品牌添加 - 公司品牌添加页面
     * @return string
     * @auther 程丽明
     * @create 2017-4-6
     * @param
     */
    public function actionAddBrand()
    {
        return $this->render('addBrand');
    }

    /**
     * 组织架构管理 - 公司 - 公司页面
     * @return string
     * @auther 梁可可
     * @create 2017-4-25
     * @param
     */
    public function actionCompany()
    {
        return $this->render('company');
    }

    /**
     * 组织架构管理 - 部门 - 部门页面
     * @return string
     * @auther 梁可可
     * @create 2017-4-25
     * @param
     */
    public function actionDepartment()
    {
        return $this->render('department');
    }

    /**
     * 组织架构管理 - 部门 - 添加部门页面
     * @return string
     * @auther 梁可可
     * @create 2017-4-25
     * @param
     */
    public function actionAddDepartment()
    {
        return $this->render('addDepartment');
    }

    /**
     * 后台 - 组织架构管理-  主界面数据遍历
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/24
     * @param
     * @return object     //返回主界面遍历数据和分页样式
     */
    public function actionMain()
    {
        $name = \Yii::$app->request->queryParams;
//        if(!empty($this->nowApplyType)){
//            $name['venueId']   = $this->nowApplyId;
//            $name['nowBelongType'] = $this->nowApplyType;
//        }else{
//            $name['venueId']   = $this->nowBelongId;
//            $name['nowBelongType'] = $this->nowBelongType;
//        }
        $model = new Organization();
        $organizationDataObj = $model->getData($name);
        $pagination = $organizationDataObj->pagination;
        $pages = Func::getPagesFormat($pagination);
        return json_encode(["data" => $organizationDataObj->models, 'pages' => $pages]);
    }

    /**
     * 后台 - 组织架构管理-  删除指定的数据
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/24
     * @return string
     * @throws UnauthorizedHttpException
     */
    public function actionDelData()
    {
        if (!AuthRole::canRoleByAuth('organization', 'DELETE')) {
            throw new UnauthorizedHttpException('抱歉，您没有权限删除，请联系管理员');
        }
        $id = \Yii::$app->request->get('id');
        $model = new Organization();
        $result = $model->getDel($id);
        if ($result == true) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } elseif ($result == "delError") {
            return json_encode(['status' => 'success', 'data' => '删除失败']);
        } else {
            return json_encode(['status' => 'error', 'data' => '无法删除：请将该部门下的员工异动至其它部门']);
        }
    }

    /**
     * 后台 - 组织架构管理-  查询顶级分类信息（公司）
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/24
     * @param
     * @return object   //返回所有顶级分类信息
     */
    public function actionCompanyCheck()
    {
        $model = new Organization();
        $data = $model->getTopData($this->companyIds);

        return json_encode($data);

    }

    /**
     * 后台 - 组织架构管理-  新增场馆部门
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/24
     * @return string  // json字符串
     * @throws UnauthorizedHttpException
     */
    public function actionAddData()
    {
        if (!AuthRole::canRoleByAuth('organization', 'ADD')) {
            throw new UnauthorizedHttpException('抱歉，您没有权限添加，请联系管理员');
        }
        $post = \Yii::$app->request->post();
        $model = new OrganizationRuleForm();
        $model->setScenario('addVenue');
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
     * 后台 - 组织架构管理-  新增公司
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/24
     * @return string
     * @throws UnauthorizedHttpException
     */
    public function actionAddCompanyData()
    {
        if (!AuthRole::canRoleByAuth('organization', 'ADD')) {
            throw new UnauthorizedHttpException('抱歉，您没有权限添加，请联系管理员');
        }
        $post = \Yii::$app->request->post();
        $model = new OrganizationRuleForm();
        $model->setScenario('addCompany');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->addMyCompanyData();
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else {
                return json_encode(['status' => 'success', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /*
     * 后台 - 组织架构管理-  公司（主界面数据遍历）
     * @author houKaiXin <houKaiXin@itsports.club>
     * @create 2017/4/24
     * @param
     * @return object     //返回主界面遍历数据和分页样式
     */
    public function actionMyCompany()
    {
        $param = $this->get;
        $model = new Organization();
        if (isset($param["page"])) {
            $nowPage = $param["page"];
        } else {
            $nowPage = 1;
        }
        $organizationDataObj = $model->getMyData($param);
        $pagination = $organizationDataObj->pagination;
        $pages = Func::getPagesFormat($pagination);

        return json_encode(["data" => $organizationDataObj->models, 'pages' => $pages, "now" => $nowPage]);
    }

    /**
     * 后台 - 组织架构管理- 公司 （删除指定的数据）
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/24
     * @return string   // json 字符串
     * @throws UnauthorizedHttpException
     */
    public function actionDelCompanyData()
    {
        if (!AuthRole::canRoleByAuth('organization', 'DELETE')) {
            throw new UnauthorizedHttpException('抱歉，您没有权限删除，请联系管理员');
        }
        $id = \Yii::$app->request->get('id');
        $model = new Organization();
        $result = $model->getDelCompany($id);
        if ($result == true) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } elseif ($result == "delError") {
            return json_encode(['status' => 'success', 'data' => '删除失败,请重新删除']);
        } else {
            return json_encode(['status' => 'error', 'data' => '无法删除：请先删除公司下面的场馆']);
        }
    }

    /**
     * 后台 - 组织架构管理-  修改公司
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/26
     * @return string   // json 字符串
     * @throws UnauthorizedHttpException
     */
    public function actionUpdateCompany()
    {
        if (!AuthRole::canRoleByAuth('organization', 'UPDATE')) {
            throw new UnauthorizedHttpException('抱歉，您没有权限修改，请联系管理员');
        }
        $post = \Yii::$app->request->post();
        $model = new OrganizationRuleForm();
        $model->setScenario('updateCompany');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->updateCompany();
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 后台 - 组织架构管理-  修改场馆表单信息
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/26
     * @return string     // json 字符串
     * @throws UnauthorizedHttpException
     */
    public function actionUpdateVenue()
    {
        if (!AuthRole::canRoleByAuth('organization', 'UPDATE')) {
            throw new UnauthorizedHttpException('抱歉，您没有权限修改，请联系管理员');
        }
        $post = \Yii::$app->request->post();
        $model = new OrganizationRuleForm();
        $model->setScenario('updateVenue');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->updateVenue();
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /*
     * 后台 - 组织架构管理- 场地（所有教室信息） - 主界面数据遍历
     * @author HouKaiXin<houkaixin@itsports.club>
     * @create 2017/4/24
     * @param
     * @return object     //返回主界面遍历数据和分页样式
     */
    public function actionClassroom()
    {
        $name = $this->get;
        $model = new ClassRoom();
        $organizationDataObj = $model->getMyClassroomData($name);
        $pagination = $organizationDataObj->pagination;
        $pages = Func::getPagesFormat($pagination);

        return json_encode(["data" => $organizationDataObj->models, 'pages' => $pages]);
    }

    /**
     * 后台 - 组织架构管理- 场地（删除教室单条数据）
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/24
     * @return string
     * @throws UnauthorizedHttpException
     */
    public function actionDelClassroomData()
    {
        if (!AuthRole::canRoleByAuth('organization', 'DELETE')) {
            throw new UnauthorizedHttpException('抱歉，您没有权限删除，请联系管理员');
        }
        $id = \Yii::$app->request->get('id');
        $model = new ClassRoom();
        $result = $model->getDelClassroom($id);
        if ($result) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     * 后台 - 组织架构管理- 获取所有场馆
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/27
     * @return object     //获取所有场馆
     */
    public function actionAllVenues()
    {
        $data = Organization::getOrganizationVenue($this->venueIds);

        return json_encode($data);
    }

    /**
     * 后台 - 组织架构管理- 获取对应公司下的场馆
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/27
     * @return object     //获取对应公司下的场馆
     */
    public function actionBelVenues()
    {
        $id = \Yii::$app->request->get("id");
        $model = new Organization();
        $data = $model->getRelevantVenue($id);
        return json_encode($data);
    }

    /**
     * 后台 - 组织架构管理-  增加场馆信息
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/26
     * @return string
     * @throws UnauthorizedHttpException
     */
    public function actionAddClassroomData()
    {
        if (!AuthRole::canRoleByAuth('organization', 'ADD')) {
            throw new UnauthorizedHttpException('抱歉，您没有权限添加，请联系管理员');
        }
        $post = \Yii::$app->request->post();
        $model = new OrganizationRuleForm();
        $model->setScenario('addClassroom');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->addClassroom();
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 后台 - 组织架构管理-  查询指定公司下的场馆
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/26
     * @param
     * @return object   //返回查询结果（所有场馆）
     */
    public function actionAppointVenues()
    {
        $pid = \Yii::$app->request->get('pid');
        $model = new Organization();
        $data = $model->getVenueData($pid);
        return json_encode($data);
    }

    /**
     * 后台 - 组织架构管理-  增加场馆信息
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/26
     * @return string
     * @throws UnauthorizedHttpException
     */
    public function actionUpdateClassroom()
    {
        if (!AuthRole::canRoleByAuth('organization', 'UPDATE')) {
            throw new UnauthorizedHttpException('抱歉，您没有权限修改，请联系管理员');
        }
        $post = \Yii::$app->request->post();
        $model = new OrganizationRuleForm();
        $model->setScenario('updateClassroom');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->updateClassroom();
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 后台 - 组织架构管理-  增加部门表单
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/28
     * @return string
     * @throws UnauthorizedHttpException
     */
    public function actionAddDepartData()
    {
        if (!AuthRole::canRoleByAuth('organization', 'ADD')) {
            throw new UnauthorizedHttpException('抱歉，您没有权限添加，请联系管理员');
        }
        $post = \Yii::$app->request->post();
        $model = new OrganizationRuleForm();
        $model->setScenario('addDepartData');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->addDepartData();
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /*
     * 后台 - 组织架构管理- 场地（所有部门） - 主界面数据遍历
     * @author HouKaiXin<houkaixin@itsports.club>
     * @create 2017/4/24
     * @param
     * @return object     //返回主界面遍历数据和分页样式
     */
    public function actionDepartments()
    {
        $params = \Yii::$app->request->queryParams;
        $model = new Organization();
        $organizationDataObj = $model->getMyDepData($params);
        $pagination = $organizationDataObj->pagination;
        $pages = Func::getPagesFormat($pagination);
        return json_encode(["data" => $organizationDataObj->models, 'pages' => $pages]);
    }

    /**
     * 后台 - 组织架构管理- 部门 （单条数据修改表单验证）
     * @author HouKaiXin<houkaixin@itsports.club>
     * @create 2017/4/28
     * @return string
     * @throws UnauthorizedHttpException
     */
    public function actionUpdateDepartment()
    {
        if (!AuthRole::canRoleByAuth('organization', 'UPDATE')) {
            throw new UnauthorizedHttpException('抱歉，您没有权限修改，请联系管理员');
        }
        $post = \Yii::$app->request->post();
        $model = new OrganizationRuleForm();
        $model->setScenario('updateDep');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->updateDep();
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 后台 - 组织架构管理- 场馆
     * @author HouKaiXin<houkaixin@itsports.club>
     * @create 2017/5/2
     * @return string
     * @throws UnauthorizedHttpException
     */
    public function actionDelVenueData()
    {
        if (!AuthRole::canRoleByAuth('organization', 'DELETE')) {
            throw new UnauthorizedHttpException('抱歉，您没有权限删除，请联系管理员');
        }
        $id = \Yii::$app->request->get('id');
        $model = new Organization();
        $result = $model->delMyResult($id);
        if ($result == true) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } elseif ($result == "delError") {
            return json_encode(['status' => 'success', 'data' => '删除失败,请重新删除']);
        } else {
            return json_encode(['status' => 'error', 'data' => '无法删除：请先删除场馆下的部门和教室']);
        }
    }

    /**
     * 后台 - 组织架构管理-  获取场馆详情信息
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/26
     * @param
     * @return object   //返回修改公司的结果
     */
    public function actionGetVenueDetail($id)
    {
        $data = Organization::getVenueDetailDataOne($id);
        return json_encode($data);
    }

    /**
     *组织架构 - 场馆是否查看 - 是否查看状态修改
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/30
     * @return bool|string
     */
    public function actionUpdateStatus()
    {
        $id = \Yii::$app->request->get('id');
        $status = Organization::getUpdateStatus($id);

        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }

    }

    /**
     * 后台 - 组织架构管理 - 获取登录角色的场馆信息
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/10/17
     * @return object
     */
    public function actionGetVenue()
    {
        $venueId = $this->venueId;
        $model = new Organization();
        $data = $model->venueData($venueId);
        return json_encode(['data' => $data]);
    }

    /**
     * 云运动 - 仓库管理 - 调拨根据公司id获取场馆
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017-10-18
     * @return string
     */
    public function actionGetVenueData()
    {
        $companyId = \Yii::$app->request->get('companyId');
        $organ = new Organization();
        $venue = $organ->venueDataAll($companyId);
        return json_encode(['venue' => $venue]);
    }
}



