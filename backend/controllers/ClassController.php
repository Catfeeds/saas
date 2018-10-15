<?php

namespace backend\controllers;

use backend\models\Course;
use common\models\Func;
use backend\models\UploadForm;
use yii\web\UploadedFile;

class ClassController extends BaseController
{
    /**
     * 后端 - 后台 - 登录页面
     * @return string
     * @auther:侯凯新
     * create 2017-3-30
     */
    public function init()
    {
        return parent::init();
    }

    /**
     * 课程管理 - 首页 - 列表的展示和新增课程
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
     * 课种管理 - 首页 - 修改页面
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
     * 后台 - 课种管理 - 数据遍历
     * @return string
     * @auther 侯凯新
     * @create 2017-4-5
     * @param
     */
    public function actionCourse()
    {
        $name = $this->get;
        $name['nowBelongId'] = $this->companyIds;
        $model = new Course();
        $courseDataObj = $model->getCourseData($name);
        $pagination = $courseDataObj->pagination;
        $pages = Func::getPagesFormat($pagination);

        return json_encode(["data" => $courseDataObj->models, 'pages' => $pages]);
    }

    /**
     * 后台 - 课种管理 -  课种删除
     * @return string
     * @auther
     * @create 2017-4-5
     * @param
     */
    public function actionCourseDel()
    {
        $id = \Yii::$app->request->get('id');
        $result = Course::getCourseDel($id);
        if ($result) {
            if (empty($model)) {
                return json_encode(['status' => 'success', 'data' => '删除成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => '此分类包含子分类或者有会员预约此课程，请勿删除']);
            }

        } else {
            return json_encode(['status' => 'error', 'data' => '此分类包含子分类或者有会员预约此课程，请勿删除']);
        }
    }

    /**
     * 后台 - 课种管理 -  课种添加
     * @return string
     * @auther 侯凯新
     * @create 2017-4-6
     * @param
     */
    public function actionCourseAdd()
    {
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $datas = \Yii::$app->request->post();
        unset($datas["_csrf_backend"]);
        $course = new Course();
        if ($course->load($datas, '') && $course->setCourseSave($companyId, $venueId)) {
            return json_encode(['status' => 'success', 'data' => '添加成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $course->errors]);
        }
    }

    /**
     * 后台 - 课种管理 - 单条课程信息查询
     * @return string
     * @auther 侯凯新
     * @create 2017-4-6
     * @param
     */
    public function actionCourseCheck()
    {
        $course = new Course();
        $data = $course->courseDetail(\Yii::$app->request->get("id"));
        return json_encode($data);
    }

    /**
     * 后台 - 课种管理 - 单条课程信息修改
     * @return string
     * @auther 侯凯新
     * @create 2017-4-6
     * @param
     */
    public function actionCourseUpdate()
    {
        $course = new Course();
        $data = \Yii::$app->request->post();
        $status = $course->getCourseUpdate();
        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }

    }

    /**
     * 后台 - 课种管理 - 查询所有数据
     * @return string
     * @auther 侯凯新
     * @create 2017-4-6
     * @param
     */
    public function actionClass()
    {
        $model = new Course();
        $data = $model->getClassData();
        return json_encode($data);
    }

    /**
     * 后台 - 课种管理 - 上传图片
     * @return string
     * @author 李慧恩
     * @create 2017-4-6
     * @param
     */
    public function actionUpload()
    {
        $data = Func::uploadImage();
        return $data;
    }

    /**
     * 后台 - 课种 -  获取课种样式数据遍历(1：私教 2：团教 3：所有课种)
     * @return object
     * @author 侯凯新
     * @create 2017-5-5
     * @param array //返回所有对应课种信息
     */
    public function actionClassType()
    {
        $type = \Yii::$app->request->get('type');
        $model = new Course();
        $data = $model->getClassDataS($type, $this->companyIds);

        return json_encode($data);
    }

    /**
     * 后台 - 课种 -  获取课种样式数据遍历(遍历顶级课种信息)
     * @return object
     * @author 侯凯新
     * @create 2017-5-6
     * @param array //返回所有对应课种信息
     */
    public function actionMyClassType()
    {
        $type = \Yii::$app->request->get('type');
        $model = new Course();
        $data = $model->getTheTopData($type, $this->companyIds);

        return json_encode($data);
    }

    /**
     * @团课添加 查询团课 - 课程
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/6
     * @return string
     */
    public function actionGroupClassType()
    {
        $type = \Yii::$app->request->get('type');
        $model = new Course();
        $data = $model->getGroupClassInfo($type, $this->companyIds);

        return json_encode($data);
    }

    /**
     * 云运动 - 课种 - 获取城市级联模板
     * @return string
     * @author 侯凯新
     * @param  attr //获取的模板值
     * @param  $num //数值
     * @create 2017-5-6
     */
    public function actionAddVenue($attr, $num = 0)
    {
        $param = Course::getTemplate($attr);
        $html = $this->renderPartial($param, ['num' => $num]);
        return json_encode(['html' => $html]);
    }

    /**
     * 云运动-团课统计
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/3
     */
    public function actionCourseType()
    {
        $get = \Yii::$app->request->queryParams;
        $course = new Course();
        return json_encode(['data' => $course->gainClassType($get), 'status' => 'success']);
    }
}
