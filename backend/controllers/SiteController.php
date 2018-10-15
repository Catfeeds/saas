<?php

namespace backend\controllers;

use backend\models\Dictionary;
use backend\models\HomePage;
use common\models\Func;
use common\models\WipeData;
use common\models\LoginForm;
use Yii;

/**
 * Site controller
 */
class SiteController extends BaseController
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *手机端ios用户协议
     * @return string
     */
    public function actionAgreement()
    {
        $this->layout = 'buyCard';
        return $this->render('agreement');
    }

    /**
     * Displays homepage.
     *手机端iosapp用户协议
     * @return string
     */
    public function actionUser()
    {
        $this->layout = 'buyCard';
        return $this->render('user');
    }

    public function actionStep()
    {
        $this->layout = 'buyCard';
        return $this->render('step');
    }

    public function actionIndex()
    {
        $this->layout = 'zhuye';
        $session = \Yii::$app->session;
        if ($session->has('AuthRole')) {
            $session->remove('AuthRole');
        }
        return $this->render('homePage');
    }

    // 系统管理统计主页
    public function actionVenueIndex()
    {
        return $this->render('operation');
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionError()
    {
        return $this->render('error', ['name' => '404']);
    }

    public function actionIndexUpgrade()
    {
        return $this->render('indexUpgrade');
    }

    public function actionRules()
    {
        return json_encode(['status' => 'error', 'data' => '对不起,您没有权限执行此操作']);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionIcon()
    {
        return $this->render('icon');
    }

    /**
     *  云运动 - 会员管理 -  加载系统设置页面
     * @author lihuien<lihuien@itsports.club>
     * @create 2017/4/1
     * @return string
     */
    public function actionSettings()
    {
        return $this->render('settings');
    }


    public function actionTest()
    {
        Func::sendMessage();
    }

    /**
     *  云运动 - 会员管理 -  批量生成会员
     * @author lihuien<lihuien@itsports.club>
     * @create 2017/4/1
     * @return string
     */
    public function actionSetMember()
    {
        $member = Func::setMemberBase();
        if ($member) {
            return json_encode(['status' => 'success', 'data' => '批量生成成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '批量生成失败']);
        }
    }

    /**
     *  云运动 - 会员管理 -  批量删除
     * @author lihuien<lihuien@itsports.club>
     * @create 2017/4/1
     * @return string
     */
    public function actionGetTable()
    {
        $del = new WipeData();
        $member = $del->getTableData();
        return json_encode(['status' => 'success', 'data' => $member]);

    }

    /**
     *  云运动 - 会员管理 -  批量删除
     * @author lihuien<lihuien@itsports.club>
     * @create 2017/4/1
     * @param  $table
     * @return string
     */
    public function actionDelTableData($table = '')
    {
        $del = new WipeData();
        $member = $del->inlet($table);
        if ($member) {
            return json_encode(['status' => 'success', 'data' => '清空数据成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '清空数据失败']);
        }
    }
    /**
     *  云运动 - 会员到场记录 - 会员到场记录
     * @author houkaixin<lihuien@itsports.club>
     * @create 2017/4/1
     * @param
     * @return string
     */

    /**
     * @api{get} /site/entry-record 数据统计 - 今日到店详情
     * @apiVersion  1.0.0
     * @apiName 数据统计 - 今日到店详情
     * @apiGroup Site
     * @apiPermission 管理员
     *
     * @apiParam {string} date  日期
     * @apiParam {string} sortType  排序字段
     * @apiParam {string} sortName  排序字段
     *
     * @apiParamExample {json} Request Example
     * {
     *     "date": "2017-07-19",
     * }
     * @apiDescription 数据统计 - 今日到店详情<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/19<br/>
     * <span><strong>调用方法：</strong></span>/site/entry-record
     * @apiSampleRequest  http://qa.uniwlan.com/site/entry-record
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {member_card_id: 20, venue_id: 2, entry_time: "1500282881",...}
     * @apiErrorExample {json} 错误示例:
     * { }
     */
    public function actionEntryRecord()
    {
        $params = $this->get;
        $params['nowBelongId'] = $this->venueId;
        $model = new HomePage();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        $data = $model->arrivalNumPeople($params, "");
        $pagination = $data->pagination;
        $total = $data->pagination->totalCount;
        $pages = Func::getPagesFormat($pagination);

        return json_encode(['data' => $data->models, 'pages' => $pages, 'now' => $nowPage, 'total' => $total]);
    }
    /**
     *  云运动 - 会员到场记录 - 男女人数统计
     * @author houkaixin<lihuien@itsports.club>
     * @create 2017/4/1
     * @update huangpengju
     * @update 2017/6/11
     * @return string
     */

    /**
     * @api{get} /site/entry-num 数据统计 - 到店人数统计图,今日到场人数、男、女
     * @apiVersion  1.0.0
     * @apiName 数据统计 - 到店人数统计图,今日到场人数、男、女
     * @apiGroup Site
     * @apiPermission 管理员
     *
     * @apiParam {string} date  日期
     *
     * @apiParamExample {json} Request Example
     * {
     *     "date": "2017-07-19",
     * }
     * @apiDescription 数据统计 - 到店人数统计图,今日到场人数、男、女<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/19<br/>
     * <span><strong>调用方法：</strong></span>/site/entry-num
     * @apiSampleRequest  http://qa.uniwlan.com/site/entry-num
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {"men":{"time7":0,"time8":0,"time9":0,"time10":0,"time11":0,"time12":0,"time13":0,"time14":0,"time15":0,"time16":0,"time17":0,"time18":1,"time19":0,"time20":0,"time21":0},
     * "women":{"time7":0,"time8":0,"time9":0,"time10":0,"time11":0,"time12":0,"time13":0,"time14":0,"time15":0,"time16":0,"time17":2,"time18":1,"time19":0,"time20":0,"time21":0},
     * "menNum":1,"womenNum":3,"allNum":4}
     * @apiErrorExample {json} 错误示例:
     * { }
     */
    public function actionEntryNum()
    {
        $param = \Yii::$app->request->get();
        $param['nowBelongId'] = $this->venueId;
        $model = new HomePage();
        $data = $model->combineData($param);

        return json_encode($data);
    }

    /**
     *  云运动 - 会员到场记录 - 加载数据库字典页面
     * @author lihuien<lihuien@itsports.club>
     * @create 2017/4/1
     * @return string
     */
    public function actionDb()
    {
        $this->layout = 'dictionary';
        return $this->render('db');
    }

    /**
     * 云运动 - 数据库字典 - 获取所有表
     * @param $name
     * @return string
     */
    public function actionListModel($name)
    {
        $dictionary = new Dictionary();
        $data = $dictionary->getTable($name);
        return json_encode($data);
    }

    /**
     * @describe 云运动 - 数据库字典 - 获取所有表结构
     * @createAt 2018-07-31
     * @return string
     * @throws \Exception
     */
    public function actionTableData()
    {
        $name = Yii::$app->request->get('name');
        $data = Dictionary::getTableByDataSql($name);//获取分页数据
        $pages = Func::getPagesFormat($data->pagination);//获取分页格式化

        return json_encode(['data' => $data->models, 'pages' => $pages]);
    }

    /**
     * 云运动 - 数据库字典 - 获取所有表
     * @return string
     */
    public function actionSetModule()
    {
        $wipe = new WipeData();
        $data = $wipe->setModuleModel();
        return json_encode($data);
    }

    /**
     * 云运动  - 业务后台 - 卡号数据交换 - 卡号数据交换
     * @param $numberOne
     * @param $numberTwo
     * @return string
     */
    public function actionSetExchangeNumber($numberOne, $numberTwo)
    {
        if (empty($numberOne) || empty($numberTwo)) {
            return json_encode(['status' => 'error', 'data' => '请填写完整的卡号']);
        }
        $number = WipeData::setCardChangeNumber($numberOne, $numberTwo);
        return json_encode($number);
    }

    /**
     *云运动  - 业务后台 - 获取登陆用户所有有权限的公司
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/9/13
     * @return bool|string
     */
    public function actionGetAuthCompany()
    {
        return json_encode($this->getCompaniesAndVenues());
    }

    /**
     * @describe 获取用户有权访问的场馆
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @return string
     */
    public function actionGetAuthVenue()
    {
        return json_encode($this->getCompaniesAndVenues('venue'));
    }

}
