<?php

namespace backend\controllers;

use backend\models\GiftDay;
use backend\models\Member;
use backend\models\PrivateLesson;
use backend\models\Role;
use common\models\Func;

class PrivateLessonController extends \backend\controllers\BaseController
{
    /*
     * 课程管理-课程排期页面
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

//    私课排课 - 私教上课页面
    public function actionClass()
    {
        return $this->render('class');
    }

//    私课排课 - 私教课程页面
    public function actionCourse()
    {
        return $this->render('course');
    }

//    私课排课 - 爽约记录
    public function actionMiss()
    {
        return $this->render('miss');
    }

    /*
     * 课程管理-课程排期-预约详情页面
     */
    public function actionScheduleDetail($id)
    {
        return $this->render('scheduleDetail', ['id' => $id]);
    }

    /*
     * 课程管理-私课课程-新增私课服务
     */
    public function actionAddServe()
    {
        return $this->render('addPrivateServe');
    }

    /*
     * 课程管理-私课课程-新增私课课程
     */
    public function actionAddCourse()
    {
        return $this->render('addPrivateCourse');
    }

    /**
     * @api {get} /private-lesson/private-class  教练-会员约课数据遍历（每一周）
     * @apiVersion 1.0.0
     * @apiName  教练-会员约课数据遍历（每一周）
     * @apiGroup  private-lesson
     * @apiPermission 管理员
     * @apiParam {string} weekStart          周开始时间
     * @apiParam {string} weekEnd            周结束时间
     * @apiParam {string} coachId            教练id
     * @apiParamExample {json} Request Example
     * {get} /private-lesson/private-class
     * {
     *      "weekStart"=>"2017-5-29",  //第一次不用发送（之后每一次发送）
     *      "weekEnd"=>"2017-6-4",     //第一次不用发送（之后每一次发送）
     *      "coachId"=>2,              //每一次都必须发送
     * }
     * @apiDescription  教练-会员约课数据遍历（每一周）
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/5/26
     *
     * @apiSampleRequest  http://qa.uniwlan.com/private-lesson/private-class
     * @apiSuccess (返回值) {json} data   返回每一周的数据
     * @apiSuccessExample {json}
     * {'class_start':'1495869155',   //课程开始时间
     *  'class_end'  :"1495879155",   // 课程结束时间
     *  'username'   : "王亚娟",      // 会员姓名
     *  "name"       :"课程名称"，    // 课程名称
     * }
     */
    public function actionPrivateClass()
    {
        $data = \Yii::$app->request->get();
        // $data     = ["weekStart"=>"2017-5-22","weekEnd"=>"2017-5-28","coachId"=>1];
        $model = new  PrivateLesson();
        $result = $model->getPrivateClassData($data, "");
        return json_encode($result);
    }

    /**
     * @describe 课程管理-课程排期-预约详情页面
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @return string
     * @throws \Exception
     */
    public function actionMemberMissRecord()
    {
        $params = $this->get;
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }

        $member = new Member();
        $result = $member->getMemberMissRecord($params);
        $pagination = $result->pagination;
        $pages = Func::getPagesFormat($pagination, 'missPage');

        return json_encode(["data" => $result->models, 'pages' => $pages, "now" => $nowPage]);
    }

    /*
     * 课程管理-课程排期-预约详情页面
     */
    public function actionMemberMissRecordDetail()
    {
        $params = $this->get;
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }

        $member = new Member();
        $result = $member->getMissRecordDetail($params);
        $pagination = $result->pagination;
        $total = $result->pagination->totalCount;
        $pages = Func::getPagesFormat($pagination, 'missDetailPage');

        return json_encode(["data" => $result->models, 'pages' => $pages, "now" => $nowPage, 'totalNum' => $total]);
    }


    /**
     * @私教产品 - 设置折扣 - 获取公司下的角色
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/03/12
     * @return bool|string
     */
    public function actionGetRole()
    {
        $id = $this->companyId;
        if (!empty($id)) {
            $model = new Role();
            $data = $model->getRoleData($id);
            return json_encode($data);
        } else {
            return false;
        }
    }

    /**
     * @私教产品 - 设置 - 设置折扣
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/03/09
     * @return bool|string
     */
    public function actionSetChargeDiscounts()
    {
        $post = \Yii::$app->request->post();
        $model = new GiftDay();
        $data = $model->setChargeDiscounts($post, $this->companyId, $this->venueId);
        if ($data === true) {
            return json_encode(['status' => 'success', 'data' => '操作成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '操作失败']);
        }
    }

    /**
     * @私教产品 - 设置 - 获取折扣
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/03/15
     * @return bool|string
     */
    public function actionGetSetDiscounts()
    {
        $model = new GiftDay();
        $data = $model->getSetDiscounts($this->venueId);
        return json_encode($data);
    }

    /**
     * @会员管理 - 私课购买 - 获取私课折扣
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/03/09
     * @return bool|string
     */
    public function actionGetChargeDiscounts()
    {
        $model = new GiftDay();
        $data = $model->getChargeDiscounts();
        return json_encode($data);
    }
}
