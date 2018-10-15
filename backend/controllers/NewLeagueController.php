<?php

namespace backend\controllers;

use backend\models\AbsentRecord;
use backend\models\AuthRole;
use backend\models\ClassRoom;
use backend\models\Course;
use backend\models\Employee;
use backend\models\GroupClass;
use backend\models\GroupCourse;
use backend\models\MemberCard;
use backend\models\MissAboutSetForm;
use backend\models\MissRecords;
use backend\models\MonthTemplate;
use backend\models\NewGroupClassForm;
use backend\models\NewLeague;
use backend\models\SeatType;
use common\models\Config;
use common\models\Func;
use yii\web\UnauthorizedHttpException;

class NewLeagueController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMiss()
    {
        return $this->render('leagueMiss');
    }

    /**
     * @api {get} /new-league/group-class   *团课排课主界面课表
     * @apiVersion 1.0.0
     * @apiName    团课排课主界面课表
     * @apiGroup  League
     * @apiPermission 管理员
     * @apiParam {string} weekStart  指定周开始时间
     * @apiParam {string} weekEnd   指定周结束时间
     * @apiParam {string} organizationId   指定场馆ID
     * @apiParam {int}   classroomId    教室ID（新增参数）
     * @apiParam {string} courseId    课程id   变更(新增参数）
     * @apiParam {string} startCourse   课程开始时间（新增参数）
     * @apiParam {int} endCourse    课程结束时间（新增参数）
     * @apiParamExample {json} Request Example
     * {
     *'classroomId' => int '12'         //  教室ID    （新增参数）
     *'weekStart' => string '2017-4-16' // 指定周开始时间
     *'weekEnd' => string '2017-4-18'   // 指定周结束时间
     *'organizationId ' => int '30'     // 场馆id
     *'courseId ' => int'16            // 课程id      变更参数（新增参数）
     *'startCourse' => string '20:58' //课程开始时间 （新增参数）
     *'endCourse' => string '21:58' //课程结束时间    （新增参数）
     * }
     * get  /new-league/group-class
     * @apiDescription   团课主界面 课程表遍历
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/7/5
     * @apiSampleRequest  http://qa.uniwlan.com/new-league/group-class
     * @apiSuccess (返回值) {string} data   返回指定条件课程列表信息
     * @apiSuccessExample {json} 成功示例:
     * {'data'=>'课程列表信息'}
     */
    public function actionGroupClass()
    {
        $data = \Yii::$app->request->get();
        $model = new NewLeague();
        $result = $model->getClassData($data, "");
        return json_encode($result);
    }

    /**
     * 后台 - 新团课管理 - 获取所有的顶级课种
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param
     * @return object     //返回所有的顶级课种信息
     */
    public function actionTopCourse()
    {
        $model = new Course();
        $data = $model->getTheTopData("2", $this->companyIds);
        return json_encode($data);
    }

    /**
     * 后台 - 新团课管理 - 点击顶级获取低级的课程分类
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param
     * @return object     //返回所有的顶级课种信息
     */
    public function actionBottomData()
    {
        $courseTypeId = \Yii::$app->request->get("id");
        $model = new Course();
        $data = $model->getBottomData($courseTypeId);
        return json_encode($data);
    }

    /**
     * @describe 后台 - 新团课管理 -  获取所有的教室表信息
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @return bool|string
     */
    public function actionAllClassroom()
    {
        $venueId = \Yii::$app->request->get("venueId");
        if (!empty($venueId)) {
            $model = new ClassRoom();
            $data = $model->myClassroom($venueId);
            return json_encode($data);
        } else {
            return false;
        }
    }

    /**
     * @api {post} /new-league/insert-data   *团课新增团课（外加数据判断）
     * @apiVersion 1.0.0
     * @apiName   团课新增团课（外加数据判断）
     * @apiGroup NewLeague
     * @apiPermission 管理员
     * @apiParam {int} date          上课日期
     * @apiParam {string} start     上课开始时间
     * @apiParam {string} end       上课结束时间
     * @apiParam {int} courseId    课程id
     * @apiParam {int} coach_id    教练id
     * @apiParam {int} classroom_id 教室id
     * @apiParam {string} _csrf_backend  防止跨站伪造
     * @apiParam {int} venue_id   场馆id     （新增外加字段）
     * @apiParamExample {json} Request Example
     * {
     *'date' => string '2017-06-14'
     *'start' => string '09:52'
     *'end' => string '15:15'
     *'courseId' => string '30'
     *'coach_id' => string '152'
     *'classroom_id' => string '20'
     *'_csrf_backend' => string 'QnFXVEtQZ0IFQBRjCAY2Iys4JxkfNjJxdSBnNnoWP3sTNGEFHhUCEQ=='
     *'venue_id' => int 54
     * }
     * get /new-league/insert-data
     * @apiDescription   团课新增团课（外加数据判断）
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/14
     * @apiSampleRequest  http://qa.uniwlan.com/new-league/insert-data
     * @apiSuccess (返回值) {string} status  修改状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data'=>'保存成功的信息'}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data'=>'保存失败的信息'}
     *
     */
    public function actionInsertData()
    {
        $post = \Yii::$app->request->post();
        $model = new NewGroupClassForm();
        $model->setScenario('addCourse');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->addMyData($this->companyId);
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
     * 后台 - 新团课管理 -  更换教练
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/22
     * @param
     * @return object     //更换指定教练
     */
    public function actionChangeCoach()
    {
        $data = \Yii::$app->request->get();
        $model = new GroupClass();
        $result = $model->changeCoach($data);
        if ($result === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $result]);
        }
    }

    /**
     * 后台 - 新团课管理 -  历史课程信息模板（默认信息：当前周的上一周）
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/23
     * @param
     * @return object     //返回历史课程信息
     */
    public function actionAddTemplate()
    {
        $data = \Yii::$app->request->get();
        $model = new NewLeague();
        $result = $model->initData($data);
        return json_encode($result);
    }

    /**
     * 后台 - 新团课管理 -  历史课程信息 录入指定 的（周）课程信息
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/23
     * @param
     * @return object     //返回历史课程信息
     */
    public function actionAddTemplateData()
    {
        $data = \Yii::$app->request->post();
        $model = new NewLeague();
        $result = $model->adjustData($data);
        if ($result == true) {
            return json_encode(['status' => 'success', 'data' => '数据录入成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $result]);
        }
    }

    /**
     * 后台 - 新团课管理 -  取消课程
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/23
     * @param
     * @return object     //返回历史课程信息
     */
    public function actionCancelCourse()
    {
        $data = \Yii::$app->request->get("courseId");
        $model = new NewLeague();
        $model->deleteCourse($data);
        return json_encode(['status' => 'success', 'data' => '取消课程成功']);
    }

    /**
     * @api {get} /new-league/get-week 获取每一月的周一和周日
     * @apiVersion 1.0.0
     * @apiName 获取每月周一到周日
     * @apiGroup NewLeague
     * @apiPermission 管理员
     * @apiParam {string} date  获取指定周日期
     *
     * @apiParamExample {json} Request Example
     * GET /user/get-charge-info
     * {
     *      date:"2017-9",
     * }
     * @apiDescription 给课程模板遍历当前月之前的月份
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/26
     *
     * @apiSampleRequest  http://qa.uniwlan.com/new-league/get-week
     *
     * @apiSuccess(返回值) {json}  data当前月份之前的3周
     */
    public function actionGetWeek()
    {
        $date = \Yii::$app->request->get("date");
        // $date  = "2017-05";
        $model = new NewLeague();
        $data = $model->getWeek($date);
        return json_encode($data);
    }

    /**
     * 后台 - 新团课管理 -  初始化获取年份数据
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/24
     * @param
     * @return object     //返回历史课程信息
     */
    public function actionGetMonth()
    {
        $model = new NewLeague();
        $month = $model->getMonth();
        return json_encode($month);
    }

    /**
     * 后台 - 新团课管理 -  获取后胎数据
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/25
     * @param
     * @return object     //返回历史课程信息
     */
    public function actionGetGroupData()
    {
        $data = \Yii::$app->request->get();
        $model = new NewLeague();
        $result = $model->getClassData($data, "");
        return json_encode($result);
    }

    /**
     * @api {get} /new-league/group-class-data  获取团课课程分页数据
     * @apiVersion 1.0.0
     * @apiName  团课课程分页数据
     * @apiGroup NewLeague
     * @apiPermission 管理员
     * @apiParam {string} sortType  排序字段名称、
     * @apiParam {string} sortName  排序方法（倒序/升序）
     * @apiParam {string} course    课程名称
     * @apiParam {string} category  课种名称
     * @apiParamExample {json} Request Example
     * GET /new-league/group-class-data
     * {
     *      sortType:category(name：课程名称，category：课种，course_duration：时长，people_limit：人数上限，course_difficulty：课程难度),
     *      sortName:ASC     (ASC:升序;DESC:降序)
     *      course: 大大    （课程名称）
     *      category：大大   （课种名称）
     * }
     * get /new-league/group-class-data
     * @apiDescription  获取团课课程的分页数据（第一次请求不需要发送参数，点击排序字段的时候需要发送排序字段名称，以及排序方法（见参数））
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/14
     *
     * @apiSampleRequest  http://qa.uniwlan.com/new-league/group-class-data
     *
     * @apiSuccess (返回值) data  返回数据
     * @apiSuccess (返回值) pages 分页数据
     *
     * * @apiSuccessExample {json} 成功示例:
     *{
     *      "data":"返回数据",
     *      "pages":"分页信息"
     * };
     */
    public function actionGroupClassData()
    {
        $data = \Yii::$app->request->get();
        $model = new GroupCourse();
        $data = $model->getData($data, "sign");
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination);

        return json_encode(["data" => $data->models, 'pages' => $pages]);
    }

    /**
     * @api {get} /new-league/update-init-data  点击修改按钮课种下拉框数据
     * @apiVersion 1.0.0
     * @apiName   团课课程 - 修改 - 点击修改按钮初始化数据
     * @apiGroup NewLeague
     * @apiPermission 管理员
     * GET /new-league/update-init-data
     * @apiDescription  点击修改的时候，下拉列表初始化数据
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/26
     * @apiSampleRequest  http://qa.uniwlan.com/new-league/group-class-data
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     * @apiSuccessExample {json} 成功示例:
     * {"id":1（课种id）,,"name": "--|瑜伽（课程名称）"}
     */
    public function actionUpdateInitData($id)
    {
        $model = new GroupCourse();
        $courseType = $model->classType($id, $this->companyIds);

        return json_encode($courseType);
    }

    /**
     * @api {post} /new-league/update-group-data  团课排课信息修改提交
     * @apiVersion 1.0.0
     * @apiName  团课排课 - 团课信息修改提交（数据提交）
     * @apiGroup NewLeague
     * @apiPermission 管理员
     * @apiParam {int} id           当前课程id
     * @apiParam {int} categoryId    当前课程所属 课种id
     * @apiParam {string} courseName 课种名称
     * @apiParam {int} courseTime 课程时长
     * @apiParam {int} personLimit 人数上限
     * @apiParam {string} courseDifficult 课程难度（1：初学 2：进阶 3：强化）
     * @apiParam {string} des 课程介绍
     * @apiParam {string} pic 课程图片网址
     * @apiParam {string} _csrf_backend 防止跨站伪造
     *
     * @apiParamExample {json} Request Example
     * post /new-league/update-group-data
     * {
     *      "id"=>8，
     *      "categoryId"=>25,
     *      "courseName"=>"测试kkkk",
     *      "courseTime"=>11,
     *      "personLimit"=>11,
     *      "courseDifficult"=>“1”,
     *      "des"=>"jiesho",
     *      "pic"=>"www.baidu.com"，
     *      "_csrf_backend"=>"_asjbbjkashdjkashdkashdkhasdhaskda==",
     * }
     * get /new-league/group-class-data
     * @apiDescription  团课排课 课程信息修改
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/26
     * @apiSampleRequest  http://qa.uniwlan.com/new-league/update-group-data
     * @apiSuccess (返回值) {string} status  修改状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data'=>'修改成功'}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data'=>'修改失败的信息'}
     *
     */
    public function actionUpdateGroupData()
    {
        $post = \Yii::$app->request->post();
        $model = new NewGroupClassForm();
        $model->setScenario('addCourseType');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->UpdateCourseType("", $this->companyId, $this->venueId);
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api {post} /new-league/insert-group-data 团课排课新增团课提交
     * @apiVersion 1.0.0
     * @apiName  团课排课 - 新增团课(点击新增团课)
     * @apiGroup NewLeague
     * @apiPermission 管理员
     * @apiParam {int} categoryId  当前课程所属 课种id
     * @apiParam {string} courseName 课种名称
     * @apiParam {int} courseTime 课程时长
     * @apiParam {int} personLimit 人数上限
     * @apiParam {string} courseDifficult 课程难度（1：初学 2：进阶 3：强化）
     * @apiParam {string} des 课程介绍
     * @apiParam {string} pic 课程图片网址
     * @apiParam {string} _csrf_backend 防止跨站伪造
     * @apiParamExample {json} Request Example
     * post /new-league/update-group-data
     * {
     *      "categoryId"=>25,
     *      "courseName"=>"测试kkkk",
     *      "courseTime"=>11,
     *      "personLimit"=>11,
     *      "courseDifficult"=>“1”,
     *      "des"=>"jiesho",
     *      "pic"=>"www.baidu.com"，
     *      "_csrf_backend"=>"_asjbbjkashdjkashdkashdkhasdhaskda==",
     * }
     * post /new-league/insert-group-data
     * @apiDescription  团课排课 新增课程
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/26
     *
     * @apiSampleRequest  http://qa.uniwlan.com/new-league/insert-group-data
     * @apiSuccess (返回值) {string} status 保存状态
     * @apiSuccess (返回值) {string} data   返回保存状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':“保存成功”}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':“保存失败”}
     */
    public function actionInsertGroupData()
    {
        if (!AuthRole::canRoleByAuth('classTimetable', 'ADD')) {
            throw new UnauthorizedHttpException('抱歉，您没有权限添加，请联系管理员');
        }
        $post = \Yii::$app->request->post();
        $model = new NewGroupClassForm();
        $model->setScenario('insertCourseType');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->insertCourseType($this->companyId, $this->venueId);
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
     * @api {post} /new-league/course-config 团课排课 - 预约设置（预约设置提交数据）
     * @apiVersion 1.0.0
     * @apiName  团课排课 - 预约设置（预约设置提交数据）
     * @apiGroup NewLeague
     * @apiPermission 管理员
     * @apiParam {string} before_class         课程开始前多长时间不可约课
     * @apiParam {string} venue_id             预约设置 场馆id
     * @apiParam {string} cancel_time          课程开始前多长时间不可取消
     * @apiParam {string} personLowerLimit     开课人数最少不得低于人数
     * @apiParam {string} _csrf_backend     防止跨站伪造
     * @apiParamExample {json} Request Example
     * post  /new-league/course-config
     * {
     *      ""before_class"=>"11"，
     *      "venue_id"=>"11",
     *      "cancel_time"=>"33",
     *      "personLowerLimit"=>"44"，
     *      "_csrf_backend"=>"_asjbbjkashdjkashdkashdkhasdhaskda==",
     * }
     * @apiDescription  团课排课 - 预约设置表单数据提交
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/26
     *
     * @apiSampleRequest  http://qa.uniwlan.com/new-league/course-config
     * @apiSuccess (返回值) {string} status 操作状态
     * @apiSuccess (返回值) {string} data   返回操作状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':'操作成功'}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':'操作失败的数据'}
     */
    public function actionCourseConfig()
    {
        $post = \Yii::$app->request->post();
        unset($post["venue_id"]);
        $model = new NewGroupClassForm();
        $result = $model->insertCourseTypeConfig($post, $this->companyId, $this->venueId);
        if ($result == true) {
            return json_encode(['status' => 'success', 'data' => "操作成功"]);
        } else if ($result == false) {
            return json_encode(['status' => 'error', 'data' => "你未提交任何数据"]);
        } else {
            return json_encode(['status' => 'error', 'data' => $result]);
        }
    }

    /**
     * 后台 - 新团课管理 -  获取所有课种信息
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/27
     * @param
     * @return object     //返回所有的历史课种
     */
    public function actionGetCourseType()
    {
        $model = new Course;
        $data = $model->getClassDataS(2, $this->companyIds);

        return json_encode($data);
    }

    /**
     * @api {post} /new-league/update-course-detail   团课课程信息修改
     * @apiVersion 1.0.0
     * @apiName  团课排课 - 修改团课排课
     * @apiGroup NewLeague
     * @apiPermission 管理员
     * @apiParam {string} date 课程排课日期
     * @apiParam {string} start 课程开始时间
     * @apiParam {string} end   课程结束时间
     * @apiParam {int} classroom_id 教室id
     * @apiParam {int} courseId 团课排课课程id
     * @apiParam {int} coach_id 教练id
     * @apiParam {int} class_id 课程id
     * @apiParam {string} _csrf_backend 防止跨站伪造
     * @apiParamExample {json} Request Example
     * post /new-league/update-course-detail
     * {
     *      "date"=>"2017-06-01"，   //上课开始日期
     *      "start"=>"11:28",        //上课开始时间
     *      "end"=>"13:00",          //上课结束时间
     *      "classroom_id"=>"3",      //教室id
     *      "courseId"=>112,          //团课排课课程id
     *      "coach_id"=>66，          //教练id
     *       'class_id'=>88,          //课程id
     *      "_csrf_backend"=>"_asjbbjkashdjkashdkashdkhasdhaskda==",
     * }
     * post /new-league/update-course-detail
     * @apiDescription  对没有预约的团课信息局部修改，各个修改参数都不能为空
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/31
     *
     * @apiSampleRequest  http://qa.uniwlan.com/new-league/update-course-detail
     * @apiSuccess (返回值) {string} status 保存状态
     * @apiSuccess (返回值) {string} data   返回保存状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':“保存成功之后返回的信息”}
     *
     * @apiErrorExample {json} 错误示例:
     * {'status':'error','data':“保存失败之后返回的信息”}
     */
    public function actionUpdateCourseDetail()
    {
        $post = \Yii::$app->request->post();
        $post["venueId"] = empty($post["venueId"]) ? null : $post["venueId"];
        $authority = (empty($post["venueId"])) ? false : true;
        if (!$authority) {
            return json_encode(['status' => 'error', 'data' => "缺少场馆权限参数"]);
        }
        $model = new NewGroupClassForm();
        $model->setScenario('updateCourse');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->updateCourseDetail($post["venueId"]);
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => "修改成功"]);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api {get} /new-league/get-course  *指定场馆低级课程信息
     * @apiVersion 1.0.0
     * @apiName  *指定场馆低级课程信息
     * @apiGroup  League
     * @apiPermission 管理员
     * @apiParamExample {json} Request Example
     * get  /new-league/get-course
     * @apiDescription  指定场馆低级课程信息展示
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/7/5
     *
     * @apiSampleRequest  http://qa.uniwlan.com/new-league/get-course
     * @apiSuccess (返回值) {string} data   返回所有底级课程信息
     * @apiSuccessExample {json} 成功字段解释:
     * {
     *'id' :  '60' ，           //课程id
     *'name' :  '阴瑜伽 ，      //课程名称
     * }
     */
    public function actionGetCourse()
    {
        $model = new GroupCourse();
        $data = $model->getData([], "");

        return json_encode($data);
    }

    /**
     * 后台 - 新团课管理 - 获取一种历史课种
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/31
     * @param
     * @return object     //返回所有的历史课种
     */
    public function actionGetOneData($id)
    {
        $model = new GroupCourse();
        $data = $model->getOneData($id);

        return json_encode($data);
    }

    /**
     * @api {get} /new-league/order-setting  *预约设置信息展示
     * @apiVersion 1.0.0
     * @apiName  团课排课 - 预约设置信息展示
     * @apiGroup NewLeague
     * @apiPermission 管理员
     * @apiParamExample {json} Request Example
     * get /new-league/order-setting
     * @apiDescription  预约设置信息展示
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/2
     *
     * @apiSampleRequest  http://qa.uniwlan.com/new-league/order-setting
     * @apiSuccess (返回值) {string} data   返回保存状态的数据
     *
     * @apiSuccessExample {json} 成功字段解释:
     * {
     *'before_class' :  '60' ，     //课程开始前多长时间不可约课
     *'cancel_time' :  '60' ，      //课程开始前多长时间不可取消
     *'personLowerLimit' ： '12'    //开课人数最少不得低于人数
     * }
     */
    public function actionOrderSetting()
    {
        $model = new Config();
        $result = $model->getConfigDetail();
        return json_encode($result);
    }

    /**
     * @api {get} /new-league/delete-course  *删除指定周期模板信息
     * @apiVersion 1.0.0
     * @apiName  删除指定周期模板信息
     * @apiGroup NewLeague
     * @apiPermission 管理员
     * @apiParam {string} startDate    周开始时间
     * @apiParam {string} endDate     周结束时间
     * @apiParam {int}    venueId     指定场馆id
     * @apiParamExample {json} Request Example
     * get /new-league/delete-course
     * @apiDescription  删除指定周期模板信息
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/2
     *
     * @apiSampleRequest  http://qa.uniwlan.com/new-league/delete-course
     * @apiSuccess (返回值) {string} data   返回删除之后的报告信息
     * @apiSuccessExample {json} data字段解释:
     * {
     *'status' :  "success"，      //返回删除之后的状态  success或error
     *'data' :  '删除成功' ，          //返回删除成功或失败的内容
     * }
     */
    public function actionDeleteCourse()
    {
        $post = \Yii::$app->request->get();
        $model = new GroupClass();
        $result = $model->deleteCourses($post);
        return json_encode(["status" => "success", "data" => $result]);
    }

    /**
     * 后台 - 团课管理 - 教练上下课打卡接口
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/7/11
     * @return object     //返回教练打卡之后的操作状态
     */
    public function actionEditCoachClassStatus()
    {
        $post = \Yii::$app->request->get();
        $model = new GroupClass();
        $result = $model->editCoachClassStatus($post, $this->companyId, $this->venueId);
        if ($result["status"] == "success") {
            return json_encode(["status" => "success", "data" => $result["data"]]);
        } else {
            return json_encode(["status" => "error", "data" => $result["data"]]);
        }
    }

    /**
     * 后台 - 团课管理 -  获取教练上课记录
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/7/11
     * @param  $id // 排课id
     * @return object     //返回 教练上课记录信息
     */
    public function actionGetCoachClassRecord($id)
    {
        $model = new GroupClass();
        $result = $model->getCoachClassRecord($id);
        return json_encode($result);
    }

    /**
     * 后台 - 团课排课 - 获取某一教室下的座位排次
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/9
     * @return object     //返回座位排次信息
     */
    public function actionGetSeatType()
    {
        $roomId = \Yii::$app->request->get('roomId');
        if (!empty($roomId)) {
            $model = new SeatType();
            $data = $model->getSeatType($roomId);
            return json_encode($data);
        } else {
            return false;
        }
    }

    /**
     * @团课排课 - 课程表 - 添加课程 获取该课程绑定的教练
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/25
     * @return object
     */
    public function actionGetCoachByCourse()
    {
        $courseId = \Yii::$app->request->get('courseId');
        if (!empty($courseId)) {
            $model = new Course();
            $data = $model->getCoachByCourse($courseId);
            return json_encode($data);
        } else {
            return false;
        }
    }

    /**
     * @团课排课 - 课程表 - 修改课程 获取一个课程的数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/25
     * @return object
     */
    public function actionGetCourseOne()
    {
        $courseId = \Yii::$app->request->get('courseId');
        if (!empty($courseId)) {
            $model = new Course();
            $data = $model->getCourseOneById($courseId);
            return json_encode($data);
        } else {
            return false;
        }
    }

    /**
     * @团课排课 - 课程表 - 获取教练
     * @author zhumengke <zhumengke@itsports.club>
     * @param $name
     * @create 2017/8/31
     * @return object
     */
    public function actionGetCoach($name = null)
    {
        $get = $this->get;
        if (!empty($get)) {
            $name = $get['name'];
        }

        $model = new Employee();
        $data = $model->coachData($name);

        return json_encode($data);
    }

    /**
     * @团课排课 - 课程表 - 获取指定公司的教练(包括公司联盟)
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/9/16
     * @return object
     */
    public function actionMemFreezeSituation()
    {
        $data = \Yii::$app->request->get();
        $nowPage = empty($data["page"]) ? 1 : $data["page"];
        $model = new MissRecords();
        $data = $model->getData($data, $this->venueId);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination, "missOrders");
        return json_encode(["data" => $data->models, 'pages' => $pages, "punishMoney" => $model->punishMoney, "nowPage" => $nowPage]);
    }

    /**
     * @团课排课 - 课程表 - 获取指定公司的教练(包括公司联盟)
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/9/16
     * @return object
     */
    public function actionGetAllCompanyCoach()
    {
        $name = \Yii::$app->request->get('name');
        $model = new Employee();
        $data = $model->getAllCompanyCoach($name, $this->companyId);
        return json_encode($data);
    }

    /**
     * @团课排课 - 新增加教练 - 在指定场馆新增加教练
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/9/16
     * @return object
     */
    public function actionAddGroupCoach($courseCategoryId, $addCoachId = [])
    {
        if (!empty($addCoachId)) {
            $addCoachId = explode(",", $addCoachId);
        }
        $model = new GroupClass();
        $result = $model->addCoach($courseCategoryId, $addCoachId);
        if ($result === true) {
            return json_encode(["status" => "success", "data" => "新增教练成功"]);
        } else {
            return json_encode(["status" => "error", "data" => $result]);
        }
    }

    /**
     * @团课排课 - 预约设置 - 新增预约设置
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/9/18
     * @return object
     */
    public function actionMissAboutSet()
    {
        $get = \Yii::$app->request->get();
        $model = new MissAboutSetForm();
        if ($model->load($get, '') && $model->validate()) {
            $result = $model->addMissAboutSet($this->companyId, $this->venueId);
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
     * @团课排课 - 会员卡旷课记录
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/9/19
     * @return object
     */
    public function actionMemAbsentRecord()
    {
        $data = \Yii::$app->request->get();
        $nowPage = empty($data["page"]) ? 1 : $data["page"];
        $model = new AbsentRecord();
        $data = $model->getData($data);
        $pagination = $data->pagination;
        $totalCount = $pagination->totalCount;
        $pages = Func::getPagesFormat($pagination, "memMissRecord");
        return json_encode(["data" => $data->models, 'pages' => $pages, "totalCount" => $totalCount, "nowPage" => $nowPage]);
    }

    /**
     * @团课排课 - 解冻记录
     * @author houkaixin <houkaixin@itsports.club>
     * @param  $memberCardId // 会员卡id
     * @param  $price
     * @create 2017/9/19
     * @return object
     */
    public function actionThawMemberCard($memberCardId = null, $price)
    {
        $data = new MemberCard();
        $result = $data->thawMemberCard($memberCardId, $this->venueId, $price);
        if ($result === true) {
            return json_encode(["status" => "success", 'data' => "解冻成功"]);
        }
        return json_encode(["status" => "error", 'data' => $result]);
    }

    /**
     * @团课排课 - 爽约 - 获取冻结方式
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/9/25
     * @return object
     */
    public function actionGetFreezeMode()
    {
        $model = new AbsentRecord();
        $rule = $model->gainFreezeWay($this->venueId);
        return json_encode(["ruleWay" => $rule]);
    }

    /**
     * @desc: 业务后台 - 爽约 -  重置冻结方式
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/06/14
     * @return string
     * @throws \yii\db\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelMissAboutSet()
    {
        set_time_limit(0);
        ini_set('memory_limit', '300M');
        $model = new MissRecords();
        $result = $model->delMissSet($this->venueId);
        if ($result === true) {
            return json_encode(["message" => "删除成功"]);
        }
    }

    /**
     * @api {get}    /new-league/card-automatic-thaw  卡自动解冻
     * @apiVersion 1.0.0
     * @apiName   卡自动解冻
     * @apiGroup NewLeague
     * @apiPermission 管理员
     * @apiParam {int}  memberId            会员id
     * @apiParam {string} isRequestMember   是否是 会员所持卡的自动解冻
     * @apiParamExample {json} Request Example
     * get   /new-league/card-automatic-thaw
     * {
     *      "memberId"=>12，                // 会员id
     *      "isRequestMember"=>"isMember",  //是否是针对某个会员的自动解冻
     * }
     * @apiDescription  卡自动解冻
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/10/12
     *
     * @apiSampleRequest http://qa.aixingfu.net/new-league/card-automatic-thaw
     * @apiSuccess (返回值) {string} data    会员卡自动解冻结果
     * @apiSuccessExample {json} data字段解释:
     * {
     * "message"=>"自动解冻成功"
     * }
     */
    public function actionCardAutomaticThaw($memberId = null, $isRequestMember = null)
    {
        $model = new AbsentRecord();
        $automaticResult = $model->cardAutomaticThaw($this->venueId, $memberId, $isRequestMember);
        if ($automaticResult === true) {
            return json_encode(["message" => "自动解冻成功"]);
        }
        return json_encode(["message" => "解冻失败"]);
    }
    //  <----------------------------------------按月出模板-------------------------->

    /**
     * @团课排课 - 按照周遍历数据
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/12/1
     * @return object
     */
    public function actionAccordMonthTemplate()
    {
        $get = \Yii::$app->request->get();
        $model = new MonthTemplate();
        $data = $model->accordCalendar($get);
        return json_encode(["data" => $data, "date" => ["searchMonth" => $model->yearMonth, "chinaSearchMonth" => $model->chinaYearMonth], "isHaveData" => $model->isHaveData]);
    }

    /**
     * @团课排课 - 按照日期搜索数据
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/12/1
     * @return object
     */
    public function actionSearchClass()
    {
        $get = \Yii::$app->request->get();
        $model = new MonthTemplate();
        $get["organizationId"] = !empty($get["organizationId"]) ? $get["organizationId"] : $this->venueId;
        $data = $model->searchGroupClass($get);
        return json_encode(["data" => $data]);
    }

    /**
     * @团课排课 - 获取一年的所有月
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/12/1
     * @return object
     */
    public function actionGetAllMonth()
    {
        $model = new MonthTemplate();
        $data = $model->gainAllMonth();
        return json_encode(["data" => $data, "courseMonth" => $model->courseMonth]);
    }

    /**
     * @团课排课 - 批量录入指定的数据（模板批量录入）
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/12/1
     * @return object
     */
    public function actionInsertAllData()
    {
        $post = \Yii::$app->request->post();
        $post["venueId"] = !empty($post["venueId"]) ? $post["venueId"] : null;
        if (empty($post["venueId"])) {
            return json_encode(["data" => ["status" => "error", "data" => null]]);
        }
        unset($post["_csrf_backend"]);
        $model = new MonthTemplate($post);
        $data = $model->InsertAllData($post);
        return json_encode(["data" => ["status" => "success", "data" => $data]]);
    }

    /**
     * @团课排课 - 获取日历表 最后 第一天 最后一天 修正
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/12/1
     * @return object
     */
    public function actionText()
    {
        $model = new MonthTemplate();
        $data = $model->threshold("2018", "02");
        return json_encode(["data" => $data]);
    }
}
