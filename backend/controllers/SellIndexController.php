<?php

namespace backend\controllers;

use backend\models\AboutClass;
use backend\models\Employee;
use backend\models\EntryRecord;
use backend\models\Order;
use common\models\Func;
use backend\models\Member;
use backend\models\HomePage;
use backend\models\Config;

class SellIndexController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @api {get} /sell-index/new-member 本月新增会员
     * @apiVersion 1.0.0
     * @apiName 本月新增会员
     * @apiGroup SellIndex
     * @apiPermission 管理员
     *
     * @apiDescription 销售主页 - 本月新增会员<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br/>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/8<br/>
     * <span><strong>调用方法：</strong></span>/sell-index/new-member
     *
     * @apiSampleRequest  http://qa.uniwlan.com/sell-index/new-member
     *
     * @apiSuccess (返回值) {string} status 取消状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * Array
     * (
     * 'id' => string '10'
     * 'mobile' => string '18345125623'
     * 'name' => string '黄晓明' (会员姓名)
     * 'sex' => string '1'
     * 'card_name' => '金爵卡'
     * 'amount_money' => '3000'
     * 'card_number' => '011496472588'
     * 'create_at' => '1496472588'
     * 'ename' => '李丽' (客服)
     * )
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionNewMember()
    {
        $params = $this->get;
        $model = new Member();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        $data = $model->getNewMemberDate($params);
        $pagination = $data->pagination->totalCount;
        $pages = Func::getPagesFormat($data->pagination, 'newPages');

        return json_encode(['data' => $data->models, 'count' => $pagination, 'pages' => $pages, 'now' => $nowPage]);
    }

    /**
     *后台数据统计 - 销售主页 - 新增会员条数
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/7/28
     * @return bool|string
     */
    public function actionNewMembers()
    {
        $type = \Yii::$app->request->get('type');
        $params = $this->get;
        $model = new Member();
        $data = $model->getNewMembers($type, $params);
        return json_encode($data);
    }

    /**
     * @api {get} /sell-index/birthday-member 销售主页 - 本月生日会员
     * @apiVersion 1.0.0
     * @apiName 销售主页 - 本月生日会员
     * @apiGroup SellIndex
     * @apiPermission 管理员
     *
     * @apiDescription 本月生日会员<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br/>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/8<br/>
     * <span><strong>调用方法：</strong></span>/sell-index/birthday-member
     *
     * @apiSampleRequest  http://qa.uniwlan.com/sell-index/birthday-member
     *
     * @apiSuccess (返回值) {string} status 取消状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * Array
     * (
     * 'id' => string '21'
     * 'mobile' => string '15736885523'
     * 'counselor_id' => string '1'
     * 'name' => string '杨颖' (会员姓名)
     * 'sex' => string '2'
     * 'birth_date' => string '2017-06-30'
     * 'ename' => string '李丽' (客服)
     * )
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionBirthdayMember()
    {
        $params = $this->get;
        $model = new Member();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        $data = $model->getBirthday($params);
        $pagination = $data->pagination->totalCount;
        $pages = Func::getPagesFormat($data->pagination, 'birthPages');

        return json_encode(['data' => $data->models, 'count' => $pagination, 'pages' => $pages, 'now' => $nowPage]);
    }

    /**
     *后台数据统计 - 销售主页 - 生日查询条数
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/7/28
     * @return bool|string
     */
    public function actionBirthdayMembers()
    {
        $type = \Yii::$app->request->get('type');
        $params = $this->get;
        $model = new Member();
        $data = $model->getBirthdayMembers($type, $params);
        return json_encode($data);
    }

    /**
     * @api {get} /sell-index/soon-due-card 销售主页 - 即将到期
     * @apiVersion 1.0.0
     * @apiName 销售主页 - 即将到期
     * @apiGroup SellIndex
     * @apiPermission 管理员
     *
     * @apiParam {int} type   1或3
     *
     * @apiDescription 销售主页 - 即将到期<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br/>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/9<br/>
     * <span><strong>调用方法：</strong></span>/sell-index/soon-due-card
     *
     * @apiSampleRequest  http://qa.uniwlan.com/sell-index/soon-due-card
     *
     * @apiSuccess (返回值) {string} status 取消状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * Array
     * (
     * 'id' => string '8'
     * 'mobile' => string '15736885563'
     * 'name' => string '朱梦珂'
     * 'sex' => string '2'
     * 'create_at' => string '1496654206' (开卡时间)
     * 'invalid_time' => string '1507281406' (到期时间)
     * 'ename' => string '李丽'
     * )
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionSoonDueCard()
    {
        $params = \Yii::$app->request->queryParams;
        $model = new Member();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        $data = $model->getSoonDue($params);
        $pagination = $data->pagination->totalCount;
        $pages = Func::getPagesFormat($data->pagination, 'soonPages');
        return json_encode(['data' => $data->models, 'count' => $pagination, 'pages' => $pages, 'now' => $nowPage]);
    }

    /**
     *后台数据统计 - 销售主页 - 即将到期查询条数
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/7/28
     * @return bool|string
     */
    public function actionSoonDueMember()
    {
        $type = \Yii::$app->request->get('type');
        $params = $this->get;
        $model = new Member();
        $data = $model->getSoonDueCards($type, $params);
        return json_encode($data);
    }

    /**
     * @api {get} /sell-index/not-entry 销售主页 - 未签到
     * @apiVersion 1.0.0
     * @apiName 销售主页 - 未签到
     * @apiGroup SellIndex
     * @apiPermission 管理员
     *
     * @apiParam {int} type   7、15、30、90、180、360
     *
     * @apiDescription 销售主页 - 未签到<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br/>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/10<br/>
     * <span><strong>调用方法：</strong></span>/sell-index/not-entry
     *
     * @apiSampleRequest  http://qa.uniwlan.com/sell-index/not-entry
     *
     * @apiSuccess (返回值) {string} status 取消状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * Array
     * (
     * 'id' => string '8'
     * 'mobile' => string '15736885563'
     * 'name' => string '朱梦珂'
     * 'sex' => string '2'
     * 'entry_time' => string '1496654206' (最近到场)
     * 'ename' => string '李丽' (客服)
     * )
     * @apiErrorExample {json} 错误示例:
     * {
     * "data": [],
     * "pages": ""
     * }
     */
    public function actionNotEntry()
    {
        $params = \Yii::$app->request->queryParams;
        $model = new Member();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        $data = $model->getNotEntry($params);
        $pagination = $data->pagination->totalCount;
        $pages = Func::getPagesFormat($data->pagination, 'notPages');
        return json_encode(['data' => $data->models, 'count' => $pagination, 'pages' => $pages, 'now' => $nowPage]);
    }

    /**
     *后台数据统计 - 销售主页 - 未签到查询条数
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/7/28
     * @return bool|string
     */
    public function actionNotEntryData()
    {
        $type = \Yii::$app->request->get('type');
        $params = \Yii::$app->request->queryParams;
        $model = new Member();
        $data = $model->getNotEntryMember($type, $params);
        return json_encode($data);
    }

    /**
     * @api {get} /sell-index/about-count 课程预约
     * @apiVersion 1.0.0
     * @apiName 课程预约
     * @apiGroup SellIndex
     * @apiPermission 管理员
     *
     * @apiParam {int} type   1本月，2上个月
     *
     * @apiDescription 销售主页 - 课程预约<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br/>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/10<br/>
     * <span><strong>调用方法：</strong></span>/sell-index/about-count
     *
     * @apiSampleRequest  http://qa.uniwlan.com/sell-index/about-count
     *
     * @apiSuccess (返回值) {string} status 取消状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {"yoga":"2","dance":"3","bicycle":"1","private":"0","bodyBuilding":"4"}
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionAboutCount()
    {
        $type = \Yii::$app->request->get('type');
        $model = new AboutClass();
        $data = $model->getCount($type);
        return json_encode($data);
    }

    /**
     * @api {get} /sell-index/entry-count 客流量
     * @apiVersion 1.0.0
     * @apiName 客流量
     * @apiGroup SellIndex
     * @apiPermission 管理员
     *
     * @apiDescription 客流量<br/>
     * <span><strong>作    者：</strong></span>朱梦珂<br/>
     * <span><strong>邮    箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/12<br/>
     * <span><strong>调用方法：</strong></span>/sell-index/entry-count
     *
     * @apiSampleRequest  http://qa.uniwlan.com/sell-index/entry-count
     *
     * @apiSuccess (返回值) {string} status 取消状态
     * @apiSuccess (返回值) {string} data   返回对应状态的数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {"data":"180"}
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionEntryCount()
    {
        $model = new EntryRecord();
        $data = $model->getEntryCount($this->venueId);

        return json_encode(['data' => $data]);
    }

    /**
     *后台数据统计 - 销售主页 - 客流量列表
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/7/21
     */
    public function actionMemberTraffic()
    {
        $params = $this->get;
        $model = new EntryRecord();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        $memberTraffic = $model->getEntryTime($params);
        $pagination = $memberTraffic->pagination;
        $pages = Func::getPagesFormat($pagination, 'entryPeoplePages');
        $count = $pagination->totalCount;
        return json_encode(['data' => $memberTraffic->models, 'count' => $count, 'pages' => $pages, 'now' => $nowPage]);
    }

    /**
     *后台数据统计 - 销售主页 - 客流量查询条数
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/7/28
     * @return bool|string
     */
    public function actionMemberTraffics()
    {
        $type = \Yii::$app->request->get('type');
        $params = $this->get;
        $model = new EntryRecord();
        $data = $model->actionMemberTraffics($type, $params);
        return json_encode($data);
    }

    /**
     *后台数据统计 - 销售主页 - 销售额
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/7/21
     */
    public function actionSalesMoney()
    {
        set_time_limit(0);
        ini_set('memory_limit', '300M');
        $params = $this->get;
        $model = new Order();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        // 会员卡的显示情况
        $order = $model->getSalesMoney($params, "hadPay");
        $dataProvider = $model->getSalesMoneyList($order);
        $dataList = $dataProvider->models;
        $dataAll = $model->getSalesMoneyAll($order);
        $totalMoney = array_sum(array_column($dataAll, 'total_price'));
        $pagination = $dataProvider->pagination;
        $pages = Func::getPagesFormat($pagination, 'salesPages');
        $count = $pagination->totalCount;
        return json_encode(['data' => $dataList, 'totalMoney' => $totalMoney, 'count' => $count, 'pages' => $pages, 'now' => $nowPage]);
    }

    /**
     *后台数据统计 - 销售主页 - 销售额总价
     * @author Huang hua <huanghua@itsports.club>
     * @param $type
     * @create 2017/7/21
     * @return bool|string
     */
    public function actionTotalPrice($type)
    {
        $dateType = $type;
        $id = \Yii::$app->request->get('venueId');
        $model = new Order();
        $totalPrice = $model->TotalMoney($id, $dateType);
        return json_encode(['data' => $totalPrice]);
    }

    /**
     *后台数据统计 - 销售主页 - 销售排行榜
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/7/22
     * @return bool|string
     */
    public function actionSalesStaff()
    {
        $type = \Yii::$app->request->get('type');
        $params = \Yii::$app->request->queryParams;
        $model = new Employee();
        $memberTraffic = $model->actionSalesMember($type, $params);
        rsort($memberTraffic);

        return json_encode(['data' => $memberTraffic]);
    }

    /**
     * @销售统计 - 销售排行榜 - 查看详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/09
     */
    public function actionSalesStaffDetails()
    {
        $params = $this->get;
        $model = new Employee();
        $data = $model->salesStaffDetails($params);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination, 'staffPages');

        return json_encode(["data" => $data->models, 'pages' => $pages]);
    }

    /**
     *后台数据统计 - 销售主页 - 销售统计图(月)
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/7/22
     * @return bool|string
     */

    public function actionEntryNum()
    {
        $param = $this->get;
        $model = new HomePage();
        $data = $model->TotalMoney($param);

        return json_encode($data);
    }

    /**
     *后台数据统计 - 销售主页 - 销售统计图(周)
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/7/25
     * @return bool|string
     */

    public function actionEntryNumWeek()
    {
        $param = $this->get;
        $model = new HomePage();
        $data = $model->TotalMoneyWeek($param);

        return json_encode($data);
    }

    /**
     *后台数据统计 - 销售主页 - 销售统计图(周)
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/7/25
     * @return bool|string
     */

    public function actionEntryNumDay()
    {
        $param = \Yii::$app->request->get();
        $model = new HomePage();
        $data = $model->TotalMoneyDay($param);
        return json_encode($data);
    }

    /**
     *后台数据统计 - 销售主页 - 客户各渠道来源
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/7/25
     * @return bool|string
     */
    public function actionSourceConfig()
    {
        $type = \Yii::$app->request->get('type');
        $params = $this->get;
        $model = new Config();
        $sourceMember = $model->actionSourceMember($type, $params);
        return json_encode(['data' => $sourceMember]);
    }

    /**
     * @销售统计 - 客户各渠道来源 - 查看详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/08
     */
    public function actionSourceConfigDetails()
    {
        $params = $this->get;
        $model = new Config();
        $data = $model->sourceConfigDetails($params);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination);

        return json_encode(["data" => $data->models, 'pages' => $pages]);
    }

    /**
     * 云运动 - 销售统计 - 员工业绩统计
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/15
     * @return array
     */
    public function actionEmployeePerformance()
    {
        $type = \Yii::$app->request->get('type');
        $params = $this->get;
        $model = new Employee();
        $employeePerformance = $model->employeePerformance($type, $params);

        return json_encode(['data' => $employeePerformance]);
    }

    /**
     * @销售统计 - 员工业绩 - 查看详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/08
     */
    public function actionPerformanceDetails()
    {
        $params = $this->get;
        $model = new Employee();
        $data = $model->performanceDetails($params);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination, 'performancePages');

        return json_encode(["data" => $data->models, 'pages' => $pages]);
    }
}
