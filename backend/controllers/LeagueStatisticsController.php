<?php

namespace backend\controllers;

use backend\models\LeagueStatistics;
use common\models\Func;

class LeagueStatisticsController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionLeagueChart()
    {
        return $this->render('league-chart');
    }
    /**
     * 验卡管理 - 获取团课统计
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/6/23
     * @return string
     */
    public function actionGetCoachLeagueAll()
    {
        $params     = \Yii::$app->request->queryParams;
        $league     = new LeagueStatistics();
        if(empty($params['venueId'])){
            $params['venueId'] = $this->venueId;
        }
        $query      = $league->getLeagueList($params);
        $provider   = $league->getLeaguePage($query);
        $pagination = $provider->pagination;
        $total      = $league->getLeagueAll($query);
        $pages      = Func::getPagesFormat($pagination);
        if(isset($params['page'])){
            $nowPage = $params['page'];
        }else{
            $nowPage = 1;
        }
        $total['params'] = $params;
        return json_encode(['data'=>$provider->models,'pages'=>$pages,'now'=>$nowPage,'sum'=>$total]);
    }
    /**
     * 验卡管理 - 获取团课统计
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/6/23
     * @return string
     */
    public function actionGetAboutClassLeague()
    {
        $params     = \Yii::$app->request->queryParams;
        $league     = new LeagueStatistics();
        $params['date'] = 'date';
        $data       = $league->getAboutClassPro($params);
        $arr        = array_keys($data);
        return json_encode(['data'=>$data,'key'=>$arr]);
    }
    /**
     * 验卡管理 - 获取团课统计
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/6/23
     * @return string
     */
    public function actionGetAboutClassLeagueTotal()
    {
        $params     = \Yii::$app->request->queryParams;
        $params['date'] = 'date';
        $league     = new LeagueStatistics();
        $data       = $league->getAboutClassTotal($params);
        return json_encode(['data'=>$data]);
    }
    /**
     * 验卡管理 - 获取团课统计
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/6/23
     * @return string
     */
    public function actionGetAboutClassLeagueDetail()
    {
        $params     = \Yii::$app->request->queryParams;
        $params['total'] = 'true';
        $league     = new LeagueStatistics();
        $query       = $league->getGroupClassDetailByCoach($params);
        $provider    = $league->getLeaguePage($query);
        $pagination = $provider->pagination;
        $total      = $league->getLeagueDetailAll($query);
        $pages      = Func::getPagesFormat($pagination);
        if(isset($params['page'])){
            $nowPage = $params['page'];
        }else{
            $nowPage = 1;
        }
        $total['params'] = $params;
        return json_encode(['data'=>$provider->models,'pages'=>$pages,'now'=>$nowPage,'sum'=>$total]);
    }
}
