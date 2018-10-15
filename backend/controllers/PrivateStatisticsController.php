<?php

namespace backend\controllers;

use backend\models\AboutClass;
use backend\models\Employee;
use backend\models\Member;
use backend\models\MemberCourseOrder;
use common\models\Func;

class PrivateStatisticsController extends BaseController
{

    /*
     * author : 程丽明
     * date :2017-08-10
     * content:私教统计首页
     * */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @私教统计 - 上课量统计（上课量 - 第一个模态框）
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/11
     * @return array
     */
    public function actionPrivateAttendClass()
    {
        $params = $this->get;
        $model = new AboutClass();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        $query = $model->privateAttendClass($params);
        $data = $model->getSumData($query);
        $class = $model->getSumDataMoney($query);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination, 'allPrivatePages');

        return json_encode(['data' => $data->models, 'pages' => $pages, 'now' => $nowPage, 'sum' => $class]);
    }

    /**
     * @私教统计 - 获取某一个私教信息
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/11
     * @return bool|string
     */
    public function actionPrivateCoachInfo()
    {
        $coachId = \Yii::$app->request->get('coachId');
        if (!empty($coachId)) {
            $model = new Employee();
            $data = $model->getCoachOneById($coachId);
            return json_encode($data);
        } else {
            return false;
        }
    }

    /**
     * @私教统计 - 私教上课量统计（上课量 - 第二个模态框）
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/11
     * @return array
     */
    public function actionOnePrivateAttendClass()
    {
        $params = $this->get;
        $model = new AboutClass();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        $query = $model->onePrivateAttendClass($params);
        $data = $model->getSumData($query);
        $class = $model->getSumDataMoney($query);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination, 'onePrivatePages');

        return json_encode(['data' => $data->models, 'pages' => $pages, 'now' => $nowPage, 'sum' => $class]);
    }

    /**
     * @私教统计 - 获取某一个会员信息
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/12
     * @return bool|string
     */
    public function actionMemberInfo()
    {
        $memberId = \Yii::$app->request->get('memberId');
        if (!empty($memberId)) {
            $model = new Member();
            $data = $model->getMemDetailData($memberId);
            return json_encode($data);
        } else {
            return false;
        }
    }

    /**
     * @私教统计 - 会员上课量统计（上课量 - 第三个模态框）
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/12
     * @return array
     */
    public function actionMemberAttendClass()
    {
        $params = $this->get;

        $model = new AboutClass();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        $query = $model->memberAttendClass($params);
        $data = $model->getSumData($query);
        $class = $model->getSumDataMoney($query);
        $pagination = $data->pagination;
        $total = $data->pagination->totalCount;
        $pages = Func::getPagesFormat($pagination, 'oneMemberPages');
        return json_encode(['data' => $data->models, 'pages' => $pages, 'now' => $nowPage, 'totalNum' => $total, 'sum' => $class]);
    }

    /**
     * @私教统计 - 卖课量统计（卖课量 - 第一个模态框）
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/12
     * @return array
     */
    public function actionSellPrivateClassAll()
    {
        $params = $this->get;
        $model = new MemberCourseOrder();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        $query = $model->sellPrivateClassAll($params);
        $data = $model->getSumData($query);
        $class = $model->getSumDataMoney($query);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination, 'allSellPages');
        return json_encode(['data' => $data->models, 'pages' => $pages, 'now' => $nowPage, 'sum' => $class]);
    }

    /**
     * @私教统计 - 私教卖课详情（卖课量 - 第二个模态框）
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/12
     * @return array
     */
    public function actionSellPrivateClassOne()
    {
        $params = $this->get;
        $model = new MemberCourseOrder();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        $query = $model->sellPrivateClassOne($params);
        $data = $model->getSumData($query);
        $pagination = $data->pagination;
        $total = $data->pagination->totalCount;
        $class = $model->getCountDataMoney($query, $total);
        $pages = Func::getPagesFormat($pagination, 'oneSellPages');

        return json_encode(['data' => $data->models, 'pages' => $pages, 'now' => $nowPage, 'totalNum' => $total, 'sum' => $class]);
    }

    /**
     * @私教统计 - 上课量、卖课量统计图(日、周、月)
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/14
     * @return bool|string
     */
    public function actionAttendClass()
    {
        $param = $this->get;
        if ($param['searchType'] == '1') {
            $model = new AboutClass();
            $data = $model->attendClass($param);    //上课量统计图
        } else {
            $model = new MemberCourseOrder();
            $data = $model->sellClass($param);      //卖课量统计图
        }
        return json_encode($data);
    }

    /**
     * @私教统计 - 生日会员
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/14
     * @return array
     */
    public function actionBirthdayMember()
    {
        set_time_limit(0);
        ini_set('memory_limit', '300M');
        $params = $this->get;
        $model = new Member();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        $data = $model->birthdayMember($params);
        $pagination = $data->pagination;
        $total = $data->pagination->totalCount;
        $pages = Func::getPagesFormat($pagination, 'birthdayPages');

        return json_encode(['data' => $data->models, 'pages' => $pages, 'now' => $nowPage, 'totalNum' => $total]);
    }
}
