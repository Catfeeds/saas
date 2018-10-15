<?php

namespace backend\controllers;
use backend\models\AboutClass;
use backend\models\Employee;
use backend\models\Member;
use backend\models\PrivateStatSearch;
use backend\models\MemberCourseOrder;
use common\models\Func;
use yii\web\Response;
use Yii;
use yii\data\Pagination;

/**
 * Class PrivateStatController
 * @package backend\controllers
 * @des  新版私教统计
 */
class PrivateStatController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionSellStat()
    {
        return $this->render('sell-stat');
    }
    public function actionClassStat()
    {
        return $this->render('class-stat');
    }

    /**
     * @desc: 业务后台 - 私教统计 - 私教会员量
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */
    public function actionGetMemberByPrivater()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new PrivateStatSearch();
        $query = $model->searchMemberNumByPrivater(Yii::$app->request->queryParams);

        return $query->all();
    }
    /**
     * @desc: 业务后台 - 客户统计 - 查询私教会员列表BY私教id
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/23
     */
    public function actionGetMemberList()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $now_page = isset($params['page'])?$params['page']:1;
        $model = new PrivateStatSearch();
        $query = $model->searchMemberListByPrivater($params);
        $totalCount = $model->searchMemberListByPrivater($params)->count();
        $pages = new Pagination(['totalCount' =>$totalCount ]);
        $data = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->orderBy('mco.member_id desc')
            ->all();
        $pages = Func::getPagesFormat($pages, 'listByPrivaterPages' );

        return [ 'data' => $data,'now_page'=>$now_page,  'pages' => $pages,'totalCount'=>$totalCount ];
    }

    /**
     * @desc: 业务后台 - 私教统计 - 客户分析
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */
    public function actionGetMemberInfo()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new PrivateStatSearch();
        $query = $model->searchMemberInfo(Yii::$app->request->queryParams);

        return $query->all();
    }
    /**
     * @desc: 业务后台 - 私教统计 - 新增客户统计
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */
    public function actionGetNewMemberInfo()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new PrivateStatSearch();
        $query = $model->searchNewMemberInfo(Yii::$app->request->queryParams);

        return $query->all();
    }

    /**
     * @desc: 业务后台 - 私教统计 - 今日概况1
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */
    public function actionTodaySurveyOne()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $data = [];
        $today_date = date('Y-m-d',time());
        $yes_date = date('Y-m-d',strtotime("-1 day"));
        $params = Yii::$app->request->queryParams;
        $model = new PrivateStatSearch();
        //新增潜在
        $data['potential']['today'] = $model->searchMemberPotential($params,$today_date);
        $data['potential']['yesterday'] = $model->searchMemberPotential($params,$yes_date);
      //新增购课会员
        $data['buy_class']['today'] = $model->searchBuyClass($params,$today_date);
        $data['buy_class']['yesterday'] = $model->searchBuyClass($params,$yes_date);

        return $data;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 今日概况3
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */
    public function actionTodaySurveyTwo()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $data = [];
        $today_date = date('Y-m-d',time());
        $yes_date = date('Y-m-d',strtotime("-1 day"));
        $params = Yii::$app->request->queryParams;
        $model = new PrivateStatSearch();

        //购课订单总金额
        $data['money']['today'] = $model->searchSumMoney($params,$today_date);
        $data['money']['yesterday'] = $model->searchSumMoney($params,$yes_date);
        //购课订单总数量
        $data['order']['today'] = $model->searchOrderNum($params,$today_date);
        $data['order']['yesterday'] = $model->searchOrderNum($params,$yes_date);

        return $data;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 今日概况3
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */
    public function actionTodaySurveyThree()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $data = [];
        $today_date = date('Y-m-d',time());
        $yes_date = date('Y-m-d',strtotime("-1 day"));
        $params = Yii::$app->request->queryParams;
        $model = new PrivateStatSearch();

        //体验课总节数
        $data['t_num']['today'] = $model->searchClassNumFree($params,$today_date);
        $data['t_num']['yesterday'] = $model->searchClassNumFree($params,$yes_date);
        //付费课总节数
        $data['f_num']['today'] = $model->searchClassNumNoFree($params,$today_date);
        $data['f_num']['yesterday'] = $model->searchClassNumNoFree($params,$yes_date);

        return $data;
    }
    /**
     * @desc: 业务后台 - 私教统计 - 客户量
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */
    public function actionGetPrivateMember()
    {
        $params = Yii::$app->request->queryParams;
        $now_page = isset($params['page'])?$params['page']:1;
        Yii::$app->response->format=Response::FORMAT_JSON;
        $model = new PrivateStatSearch();
        $query = $model->searchPrivateMember($params);
        $totalCount = $model->searchPrivateMember($params)->count();
        $pages = new Pagination(['totalCount' =>$totalCount ]);
        $data = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->orderBy('m.id desc')
            ->all();
        $pages = Func::getPagesFormat($pages, 'clientPages' );

        return [ 'data' => $data,'now_page'=>$now_page,  'pages' => $pages,'totalCount'=>$totalCount ];
    }
    /**
     * @desc: 业务后台 - 私教统计 - 即将到期
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/11
     */
    public function actionSoonToExpire()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $now_page = isset($params['page'])?$params['page']:1;
        $model = new PrivateStatSearch();
        $query = $model->searchSoonToExpireMember($params);
        $countQuery = clone $query;
        $totalCount = $countQuery->count();
        $pages = new Pagination(['totalCount' =>$totalCount ]);
        $data = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->orderBy('mco.deadline_time desc')
            ->all();
        $pages = Func::getPagesFormat($pages, 'SoonToExpirePages' );

        return [ 'data' => $data, 'now_page'=>$now_page, 'pages' => $pages,'totalCount'=>$totalCount ];
    }

    /**
     * @desc: 业务后台 - 私教统计 - 体验课未执行
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/13
     */
    public function actionClassNotExecuted()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $now_page = isset($params['page'])?$params['page']:1;
        $model = new PrivateStatSearch();
        $query = $model->searchClassNotExecuted($params);
        $countQuery = clone $query;
        $totalCount = $countQuery->count();
        $pages = new Pagination(['totalCount' =>$totalCount ]);
        $data = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->orderBy('mco.create_at desc')
            ->all();
        $pages = Func::getPagesFormat($pages, 'NotExecutedPages' );

        return [ 'data' => $data, 'now_page'=>$now_page, 'pages' => $pages,'totalCount'=>$totalCount ];
    }
    /**
     * @desc: 业务后台 - 私教统计 - 客户统计-最近未上课
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/14
     */
    public function actionNotGoClassMember()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $now_page = isset($params['page'])?$params['page']:1;
        $model = new PrivateStatSearch();
        $query = $model->searchNotGoClassMember($params);
        $countQuery = clone $query;
        $totalCount = $countQuery->count();
        $pages = new Pagination(['totalCount' =>$totalCount ]);
        $data = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->orderBy('ac.create_at desc')
            ->all();
        $pages = Func::getPagesFormat($pages, 'NotGoClassMemberPages' );
        return [ 'data' => $data, 'now_page'=>$now_page, 'pages' => $pages,'totalCount'=>$totalCount ];
    }
    /**
     * @desc: 业务后台 - 私教统计 - 客户统计-最近未跟进
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/14
     */
    public function actionNotFollow()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $now_page = isset($params['page'])?$params['page']:1;
        $model = new PrivateStatSearch();
        $query = $model->searchNotFollow($params);
        $countQuery = clone $query;
        $totalCount = $countQuery->count();
        $pages = new Pagination(['totalCount' =>$totalCount ]);
        $data = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->orderBy('m.id desc')
            ->all();
        $pages = Func::getPagesFormat($pages, 'NotFollowPages' );
        return [ 'data' => $data, 'now_page'=>$now_page, 'pages' => $pages,'totalCount'=>$totalCount ];
    }
    /**
     * @desc: 业务后台 - 私教统计 - 上课统计-上课量
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/14
     */
    public function actionPrivateAttendClass()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $now_page = isset($params['page'])?$params['page']:1;
        $model = new PrivateStatSearch();
        $query = $model->searchPrivateAttendClass($params);
        $countQuery = clone $query;
        $totalCount = $countQuery->count('ac.id');
        $totalMember = $countQuery->count('DISTINCT ac.member_id');
        $pages = new Pagination(['totalCount' =>$totalCount ]);
        $data = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->all();
        $pages = Func::getPagesFormat($pages, 'privateAttendPages' );

        return [ 'data' => $data, 'now_page'=>$now_page, 'pages' => $pages,'$totalMember'=>$totalMember,'totalCount'=>$totalCount ];
    }
    /**
     * @desc: 业务后台 - 私教统计 - 上课统计-课程分析
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/14
     */
    public function actionPrivateClassByCourse()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $model = new PrivateStatSearch();
        $data  = $model->searchClassByCourse($params)->all();

        return [ 'data' => $data];
    }
    /**
     * @desc: 业务后台 - 私教统计 - 上课统计-上课量折线图
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/14
     */
    public function actionPrivateAttendClassChart()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $model = new PrivateStatSearch();
        $query = $model->searchPrivateAttendClassChart($params);

        return [ 'data' => $query->all()];
    }
    /**
     * @desc: 业务后台 - 私教统计 - 上课统计-预约途径
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/15
     */
    public function actionClassSource()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $model = new PrivateStatSearch();
        $query = $model->searchClassSource($params);

        return [ 'data' => $query->all()];
    }

    /**
     * @desc: 业务后台 - 私教统计 - 上课统计-上课数量统计
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/15
     */
    public function actionAttendClassNum()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $model = new PrivateStatSearch();
        $query = $model->searchAttendClassNum($params);
        return [ 'data' => $query];
    }

    /**
     * @desc: 业务后台 - 私教统计 - 上课统计-上课人数统计
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/15
     */
    public function actionAttendMemberNum()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $model = new PrivateStatSearch();
        $data = $model->searchAttendMemberNum($params);

        return [ 'data' => $data];
    }

    /**
     * @desc: 业务后台 - 私教统计 - 客户统计
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/15
     */
    public function actionMemberNum()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $data = [];
        $model = new PrivateStatSearch();
        //生日会员
        $data['birth_num'] = $model->searchBirthdayMember($params);
        //即将到期
        $data['expire_num'] = $model->searchSoonToExpireMember($params)->count('m.id');
        //体验课未执行
        $data['notExecuted_num'] = $model->searchClassNotExecuted($params)->count();
        //最近未跟进
        $data['notFollow_num'] = $model->searchNotFollowNum($params,3);

        return [ 'data' => $data];

    }
    /**
     * @desc: 业务后台 - 私教统计 - 客户统计最近未上课
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/15
     */
    public function actionNotClassNum()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $data = [];
        $model = new PrivateStatSearch();
        //客户量
        $data['member_num'] = $model->searchPrivateMemberCount($params);
        //最近未上课
        $data['notClass_num'] = $model->searchNotGoClassMemberNum($params);

        return [ 'data' => $data];
    }

    /**
     * @desc: 业务后台 -销售统计-销售
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function actionSaleDeal()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $model = new PrivateStatSearch();
        $query = $model->searchSaleDeal($params);
        $countQuery = clone $query;
        $totalCount = $countQuery->count('mco.id');
        $totalClass = $countQuery->sum('mco.course_amount');
        $totalMoney = $countQuery->sum('mco.money_amount');
        $totalMember = $countQuery->count('DISTINCT mco.member_id');
        $now_page = isset($params['page'])?$params['page']:1;
        $pages = new Pagination(['totalCount' =>$totalCount ]);
        $data = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->asArray()
            ->orderBy('mco.id desc')
            ->all();
        $pages = Func::getPagesFormat($pages, 'saleDealPages' );

        return [ 'data' => $data, 'now_page'=>$now_page, 'pages' => $pages,
            'totalClass' => $totalClass,'totalMember'=>$totalMember,
            'totalCount'=>$totalCount,'totalMoney'=>$totalMoney];
    }
    /**
     * @desc: 业务后台 -销售统计-销售num
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function actionSaleNum()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $model = new PrivateStatSearch();
        $query = $model->searchSaleDeal($params);
        //成交额
        $totalMoney = $query->sum('mco.money_amount');
        //成交量（节）
        //体验课成交率（某段时间内 私教潜在会员成交人数/私教潜在会员上体验课人数）

        $dealRate = $model->searchFreeClassDeal($params);
        $totalClass = $query->sum('mco.course_amount');
        //成交量（人）
        $totalMember = $query->count('DISTINCT mco.member_id');

        return ['totalClass' => $totalClass,'totalMember'=>$totalMember, 'totalMoney'=>$totalMoney,'dealRate'=>$dealRate];
    }
    /**
     * @desc: 业务后台 -销售统计-销售成交额-折线图
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function actionSaleDealChart()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $model = new PrivateStatSearch();
        $data = $model->searchSaleDealChart($params)->all();

        return ['data' => $data];
    }
    /**
     * @desc: 业务后台 -销售统计-销售成交量-折线图
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function actionSaleDealNumChart()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $model = new PrivateStatSearch();
        $data = $model->searchSaleDealNumChart($params)->all();

        return ['data' => $data];
    }
    /**
     * @desc: 业务后台 -销售统计-销售购买人数-折线图
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function actionSaleDealMemberChart()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $model = new PrivateStatSearch();
        $data = $model->searchSaleDealMemberChart($params)->all();

        return ['data' => $data];
    }
    /**
     * @desc: 业务后台 -销售统计-课程分析-成交额
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function actionSaleClass()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        if(!isset($params['s_type'])) return ['param s_type is not found!'];
        $model = new PrivateStatSearch();
        switch ($params['s_type'])
        {
            case 1://成交额
                $data = $model->searchSaleDealClass($params)->all();
                break;
            case 2: //成交量
            $data = $model->searchSaleNumClass($params)->all();
                break;
            case 3://购买人数
                $data = $model->searchSaleMemberClass($params)->all();
                break;
            default:
                $data = "No Data";
        }

        return ['data' => $data];
    }

    /**
     * @desc: 业务后台 -销售统计-课程对比
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function actionSaleClassCompare()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        if(!isset($params['s_type'])) return ['param s_type is not found!'];
        $model = new PrivateStatSearch();
        switch ($params['s_type'])
        {
            case 1://平均成交价
                $data = $model->searchAverageDealClass($params)->all();
                break;
            case 2: //平均客单价
                $data = $model->searchSaleUnitPriceClass($params)->all();
                break;
            case 3://续约率
                $data = $model->searchSaleRenewalRate($params)->all();
                break;
            case 4://流失率
                $data = $model->searchSaleLossRate($params)->all();
                break;
            default:
                $data = "No Data";
        }

        return ['data' => $data];
    }
    /**
     * @desc: 业务后台 -销售统计-私教销售排行
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/19
     */
    public function actionSaleRank()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $model = new PrivateStatSearch();
        $data = $model->searchSaleRank($params)->all();
        return ['data' => $data];
    }

    /**
     * @desc: 业务后台 - 销售统计- 成交客户分析-新老客户占比
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/21
     */
    public function actionDealMember()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        if(!isset($params['s_type'])) return ['param s_type is not found!'];
        $model = new PrivateStatSearch();
        switch ($params['s_type'])
        {
            case 1://成交额
                //第一次购课的人
                $data['first'] = $model->searchFirstDealMember($params)->sum('money');
                $data['all'] = $model->searchAllDealMember($params)->sum('money');
                break;
            case 2: //成交量
                $data['first'] = $model->searchFirstDealMember($params)->sum('class_num');
                $data['all'] = $model->searchAllDealMember($params)->sum('class_num');
                break;
            case 3://购买人数
                $data['first'] = $model->searchFirstDealMember($params)->count();
                $data['all'] = $model->searchAllDealMember($params)->count();
                break;
            default:
                $data = "No Data";
        }
        return ['data' => $data];
    }
    /**
     * @desc: 业务后台 - 销售统计- 成交客户分析-办卡当日成交占比
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/21
     */
    public function actionSameDayDeal()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        if(!isset($params['s_type'])) return ['param s_type is not found!'];
        $model = new PrivateStatSearch();
        switch ($params['s_type'])
        {
            case 1://成交额
                //第一次购课的人
                $data['first'] = $model->searchSameDayDeal($params)->sum('money');
                $data['all'] = $model->searchAllDealMember($params)->sum('money');
                break;
            case 2: //成交量
                $data['first'] = $model->searchSameDayDeal($params)->sum('class_num');
                $data['all'] = $model->searchAllDealMember($params)->sum('class_num');
                break;
            case 3://购买人数
                $data['first'] = $model->searchSameDayDeal($params)->count();
                $data['all'] = $model->searchAllDealMember($params)->count();
                break;
            default:
                $data = "No Data";
        }
        return ['data' => $data];
    }

    /**
     * @desc: 业务后台 - 上课统计 - 私教上课排行榜
     * @author: jianbingqi <jianbingqi@itsports.club>
     * @create: 2018/06/21
     */
    public function actionPrivateClassNum()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $params = Yii::$app->request->queryParams;
        $model = new PrivateStatSearch();
        $data = $model->searchPrivateClassNum($params)->all();
        return ['data' => $data];
    }

}
