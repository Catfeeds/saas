<?php

namespace backend\controllers;

use backend\models\EmployeeDataRuleForm;
use backend\models\LeagueReservationForm;
use       backend\models\Employee;
use       backend\models\GroupClass;
use       common\models\Func;
use       backend\models\GroupClassDataRuleForm;
use       backend\models\Organization;
use       backend\models\ClassRoom;
use       backend\models\Course;
use       backend\models\GroupClassUpdateForm;

class LeagueController extends BaseController
{

    /**
     *  团课管理- 团课首页 - 列表和新增功能
     * @return string
     * @author 程丽明
     * create 2017-3-21
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 团课管理-新增页面-课程表单
     * @return string
     * @auth 程丽明
     * create 2017-3-21
     */
    public function actionAdd()
    {
        return $this->render('addClass');
    }

    /**
     * 团课管理 - 选择历史课程并新增页面 - 时间列表和课程表单
     * @return string
     * @auth 程丽明
     * create 2017-3-21
     */
    public function actionSearchHistoryAdd()
    {
        return $this->render('searchHisAdd');
    }

    /**
     * 团课管理 - 预约页面 - 预约列表
     * @return string
     * @auth 程丽明
     * create 2017-3-21
     */
    public function actionReservation()
    {
        return $this->render('reservation');
    }

    /**
     * 团课管理 - 修改课程页面 - 修改课程表单
     * @return string
     * @update 侯凯新
     * @auth 程丽明
     * create 2017-3-24
     */
    public function actionEditCourse()
    {
        $data = \Yii::$app->request->get();
        $model = new GroupClass();
        $model->saveSession($data["id"]);
        return $this->render('editCourse');
    }

    /**
     * 云运动 - 后台 - 团课 - 获取单条课程数据
     * @author 侯凯新<houkaixin@itsports.club>
     * @create 2017/4/19
     * @param
     * @return  object
     */
    public function actionGetCourse()
    {
        $model = new GroupClass();
        $data = $model->oneCourseData();
        return json_encode($data);
    }

    /**
     * 云运动 - 后台 - 团课 - 获取团课课种所有信息
     * @author 侯凯新<houkaixin@itsports.club>
     * @create 2017/4/19
     * @param
     * @return  object
     */
    public function actionGroupCourse()
    {
        $model = new Course();
        $data = $model->groupCourse($this->venueIds);

        return json_encode($data);
    }

    /**
     * 团课管理 - 课程详情页面 - 课程详情
     * @return string
     * @auth 程丽明
     * create 2017-3-27
     */
    public function actionLeagueDetail()
    {
        $id = \Yii::$app->request->get('id');
        $session = \Yii::$app->session;
        $session->set('leagueId', $id);
        return $this->render('leagueDetail');
    }

    /**
     * @api {get} /league/league-reservation 卡种续费预约设置
     * @apiVersion 1.0.0
     * @apiName 卡种续费预约设置
     * @apiGroup card
     * @apiPermission 管理员
     *
     * @apiParam {int} type    类型
     * @apiParam {int} renew  v 值
     * @apiParam {int} recharge  键
     * @apiParam {string} scenario   场景
     * @apiParam {string} _csrf_backend   场景
     * @apiParamExample {json} Request Example
     * post  /new-league/course-config
     * {
     *      "type"=>"card"，
     *      "renew" =>"12",
     *      'beforeRenew'=>'13'
     *      "recharge"=>"11",
     *      "scenario"=>"card"，
     *      "_csrf_backend"=>"_asjbbjkashdjkashdkashdkhasdhaskda==",
     * }
     * @apiDescription 管理员添加教练-卡种续费预约设置
     * <br/>
     * <span><strong>作    者：</strong></span>黄华<br>
     * <span><strong>邮    箱：</strong></span>huanghua@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/26
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/league/league-reservatio
     * @apiSampleRequest  http://qa.uniwlan.com/league/league-reservatio
     *
     * @apiSuccess(返回值) {string}  status 验证状态 ｛error：设置失败，success：设置成功｝
     *
     */
    public function actionLeagueReservation()
    {
        $post = \Yii::$app->request->post();
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $scenario = $post['scenario'];
        unset($post['_csrf_backend']);
        $model = new LeagueReservationForm([], $scenario, $companyId, $venueId);
        if ($model->load($post, '') && $model->validate()) {
            $model->setConfigData($model);
            return json_encode(['status' => 'success', 'data' => '设置成功!']);
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @云运动 - 团课管理 - 预约 - 获取config表的数据
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/4/14
     * @inheritdoc
     */
    public function actionConfigInfo()
    {
        $model = LeagueReservationForm::getConfigInfo();
        return json_encode($model);
    }

    /**
     * 后台 - 团课管理- groupClass  主界面数据遍历
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/15
     * @param
     * @return object     //返回主界面遍历数据和分页样式
     */
    public function actionCourse()
    {
        $params = \Yii::$app->request->queryParams;
        $params['nowBelongId'] = $this->nowBelongId;
        $params['nowBelongType'] = $this->nowBelongType;
        $model = new GroupClass();
        $groupCourseDataObj = $model->getGroupClass($params);
        $pagination = $groupCourseDataObj->pagination;
        $pages = Func::getPagesFormat($pagination);
        return json_encode(["data" => $groupCourseDataObj->models, 'pages' => $pages]);
    }

    /**
     * 后台 - 团课管理 - groupClass  删除指定数据
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/15
     * @param id（int）
     * @return object     //返回删除结果
     */
    public function actionDelete()
    {
        $id = \Yii::$app->request->get('id');
        $model = new GroupClass();
        $result = $model->getDelete($id);
        if ($result) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     * 后台 - 团课管理 - 返回所有场馆数据
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/15
     * @update Huang Pengju <huangpengju@itsports.club>
     * @update 2017/5/2 //此方法在团课修改js中不用了
     * @param
     * @return object     //返回场馆表所有场馆名字
     */
    public function actionVenue()
    {
        $model = new Organization();
        $data = $model->getTopOrganization();
        return json_encode($data);
    }

    /**
     * 后台 - 团课管理 - 返回所有教室数据
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/15
     * @param
     * @return object     //返回场馆表所有教室名字
     */

    public function actionClassRoom()
    {
        $model = new ClassRoom();
        $data = $model->getClassRoomData($this->nowBelongId, $this->nowBelongType);
        return json_encode($data);
    }

    /**
     * @api {get} /league/coach  团课教练实时搜索
     * @apiVersion 1.0.0
     * @apiName  团课教练实时搜索
     * @apiGroup  NewLeague
     * @apiPermission 管理员
     * @apiParam {string} name  教练姓名
     * @apiParamExample {json} Request Example
     * GET /league/coach
     * {
     *      name:小明   //教练姓名搜索
     * }
     * @apiDescription 团课教练实时搜索
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/13
     *
     * @apiSampleRequest  http://qa.uniwlan.com/league/coach
     * @apiSuccess (返回值) data  返回数据
     * * @apiSuccessExample {json} 成功示例:
     *{
     *      "data":"返回数据",
     * };
     */
    public function actionCoach($name = null)
    {
        $model = new Employee();
        $data = $model->coachData($name);

        return json_encode($data);
    }

    /**
     * 云运动 - 团课管理 - 团课添加表单验证
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * @update 2017/4/19
     * @return string
     */
    public function actionGroupClassRule()
    {
        $post = $this->post;
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $scenario = $post['scenario'];          //取出场景
        $model = new GroupClassDataRuleForm([], $scenario, $companyId, $venueId);
        if ($scenario != 'cancel') {
            if ($model->load($post, '') && $model->validate()) {
                $data = $model->setSessionData($model);
                if ($data === true) {
                    return json_encode(['status' => 'success', 'data' => '添加成功']);
                } else if ($data === false) {
                    return json_encode(['status' => 'error', 'data' => '添加失败']);
                } else if ($data != 'one') {
                    return json_encode(['status' => 'repeat', 'data' => '教练' . $data . '已经有课了']);
                }
            } else {
                return json_encode(['status' => 'error', 'data' => $model->errors]);
            }
        } else {
            return json_encode(['status' => 'success', 'data' => '取消成功']);
        }
    }


    /**
     * 云运动 - 团课管理 - 上传图片
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/14
     * @return string
     */
    public function actionUpload()
    {
        $data = Func::uploadImage();
        return $data;
    }


    /**
     * 云运动 - 团课管理 - 团课修改表单验证
     * @author houKaiXin <houKaiXin@itsports.club>
     * @create 2017/4/19
     * @return object
     */
    public function actionUpdateGroupCourse()
    {
        $post = \Yii::$app->request->post();
        $model = new GroupClassUpdateForm();
        if ($model->load($post, '') && $model->validate()) {
            return json_encode(['status' => 'success', 'data' => '']);
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 团课管理 - 首页 - 课程详情遍历
     * @return string
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017-4-15
     * @param  $id int
     */
    public function actionGetCourseDetail($id = 1)
    {
        $session = \Yii::$app->session;
        $id = $session->get('leagueId');
        $about = new GroupClass();
        $data = $about->getGroupClassDetail($id);
        return json_encode($data);
    }

    /**
     * 团课管理 - 团课管理- 接受并且修改团课信息
     * @return object
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017-4-15
     * @param
     */

    public function actionUpdateData()
    {
        $post = \Yii::$app->request->post();
        $model = new GroupClassUpdateForm();
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
     * 团课管理 - 团课管理- 根据场馆id查询所有教室信息
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017-4-15
     * @return object   //指定场馆的所有教室
     * @param
     */
    public function actionVenueDetail()
    {
        $data = \Yii::$app->request->get();
        $model = new ClassRoom();
        $classRoom = $model->myClassroom($data["venueId"]);
        return json_encode($classRoom);
    }

    /**
     * 云运动 - 添加教练 - 获取部门信息
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017-4-21
     * @return string
     */
    public function actionGetVenue()
    {
        $venueId = \Yii::$app->request->get('venueId');
        $organ = new Organization();
        $venue = $organ->getOrganizationData($venueId);
        return json_encode(['venue' => $venue]);
    }

    /**
     * 云运动 - 添加教练 - 获取部门信息
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017-4-21
     * @return string
     */
    public function actionSetCoachData()
    {
        $post = \Yii::$app->request->post();
        $model = new EmployeeDataRuleForm();
        if ($model->load($post, '') && $model->validate()) {
            $save = $model->saveCoachData();
            if ($save === true) {
                return json_encode(['status' => 'success', 'data' => '添加成功']);
            }
            return json_encode(['status' => 'error', 'data' => $save]);
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 云运动  - 查询教室座位数 (updateCourse.js请求)
     * @author Huang Pengju <huangpengju@itsports.club>
     * @update 2017-5-4
     * @return string
     */
    public function actionClassRoomSeat()
    {
        $id = \Yii::$app->request->get('roomId');
        $model = new ClassRoom();
        $data = $model->getClassroomOneById($id);
        return json_encode($data);
    }

    /**
     * @api {get} /league/get-mobile-info 员工手机号去重
     * @apiVersion 1.0.0
     * @apiName 手机号去重验证
     * @apiGroup league
     * @apiPermission 管理员
     *
     * @apiParam {int} mobile   手机号
     *
     * @apiDescription 管理员添加教练-手机号验证去重
     * <br/>
     * <span><strong>作    者：</strong></span>黄华<br>
     * <span><strong>邮    箱：</strong></span>huanghua@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/26
     * <span><strong>域    名：</strong></span>http://qa.uniwlan.com <br>
     * <span><strong>调用方法：</strong></span>/league/get-mobile-info
     * @apiSampleRequest  http://qa.uniwlan.com/league/get-mobile-info
     *
     * @apiSuccess(返回值) {string}  status 验证状态 ｛error：手机号存在，success：手机不存在｝
     *
     */
    public function actionGetMobileInfo()
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
     * @后台 - 潜在会员约课 - 获取指定时间的课程(当天和当天以后的课程)
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/5/23
     * @update 2017/5/24-此接口停用-用验卡中的约课课程接口
     * @return string
     */
    public function actionGetGroupClass()
    {
        $params = \Yii::$app->request->queryParams;
        $model = new GroupClass();
        $data = $model->getGroupClassInfo($params);
        return json_encode(['status' => 'success', 'data' => $data]);
    }

    /**
     * 后台 - 潜在会员约课 - 选中课程，查询该课程的约课情况
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/5/23
     * @update 2017/5/24-此接口停用-用验卡中的约课课程接口
     * @return string
     */
    public function actionGetAboutInfo()
    {
        $post = \Yii::$app->request->post();
        $model = new GroupClass();
        $result = $model->getAboutClassDetails($post);

        if ($result === true) {
            return json_encode(['status' => 'error', 'data' => '请先选择课程']);
        } else if ($result != false) {
            return json_encode(['status' => 'success', 'data' => $result]);
        } else {
            return json_encode(['status' => 'repeat', 'data' => '您只能体验一节课']);
        }
    }


}

