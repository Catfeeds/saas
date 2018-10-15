<?php

namespace backend\controllers;

use backend\models\AboutClass;
use backend\models\CardCategory;
use backend\models\MemberCard;
use common\models\Func;

class OperationStatisticsController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @api{get} /operation-statistics/member-card-count 会员卡种统计
     * @apiVersion  1.0.0
     * @apiName 会员卡种统计
     * @apiGroup OperationStatistics
     * @apiPermission 管理员
     *
     * @apiParam {string} date  日期
     *
     * @apiParamExample {json} Request Example
     * {
     *     "date": "2017-07-19",
     * }
     * @apiDescription 营运统计 - 会员卡种统计<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/19<br/>
     * <span><strong>调用方法：</strong></span>/operation-statistics/member-card-count
     * @apiSampleRequest  http://qa.uniwlan.com/operation-statistics/member-card-count
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * ["5=>时间卡","4=>次卡",...]
     * @apiErrorExample {json} 错误示例:
     * [ ]
     */
    public function actionMemberCardCount()
    {
        $params = \Yii::$app->request->queryParams;
        $params['nowBelongId'] = $this->venueId;
        $model = new MemberCard();
        $data = $model->memberCardCount($params);

        return json_encode($data);
    }

    /**
     * @营运统计 - 会员卡种统计 - 查看详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/07
     * @return array
     */
    public function actionCardCountDetails()
    {
        $params = \Yii::$app->request->queryParams;
        $params['nowBelongId'] = $this->nowBelongId;
        $model = new MemberCard();
        $data = $model->cardCountDetails($params);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination, 'cardPages');
        return json_encode(["data" => $data->models, 'pages' => $pages]);
    }

    /**
     * @api{get} /operation-statistics/class-count 会员上课统计
     * @apiVersion  1.0.0
     * @apiName 营运统计 - 会员上课统计
     * @apiGroup OperationStatistics
     * @apiPermission 管理员
     *
     * @apiParam {string} date  日期
     *
     * @apiParamExample {json} Request Example
     * {
     *     "date": "2017-07-19",
     * }
     * @apiDescription 营运统计 - 会员上课统计<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/19<br/>
     * <span><strong>调用方法：</strong></span>/operation-statistics/class-count
     * @apiSampleRequest  http://qa.uniwlan.com/operation-statistics/class-count
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * [{"yoga":4,"dance":9,"bicycle":3,"swim":6,"private":5}]
     * @apiErrorExample {json} 错误示例:
     * [ ]
     */
    public function actionClassCount()
    {
        $params = \Yii::$app->request->queryParams;
        $params['companyId'] = $this->companyId;
        $card = new CardCategory();
        $venue = \Yii::$app->request->get('venueId');
        $params['venueId'] = !empty($venue) ? $venue : $card->getVenueIdByRole();
        $params['start'] = !empty($params['startTime']) ? strtotime($params['startTime']) : time();
        $params['end'] = !empty($params['endTime']) ? strtotime($params['endTime']) : time();
        $model = new AboutClass();
        $params['status'] = [3, 4];
        $data = $model->classCount($params);
        return json_encode($data);
    }

    /**
     * @营运统计 - 会员上课统计 - 查看详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/07
     * @return array
     */
    public function actionClassCountDetails()
    {
        $params = \Yii::$app->request->queryParams;
        $params['nowBelongId'] = $this->nowBelongId;
        $model = new AboutClass();
        $data = $model->classCountDetails($params);
        return json_encode(["data" => $data]);
//        $pagination = $data->pagination;
//        $pages      = Func::getPagesFormat($pagination);
//        return json_encode(["data" => $data->models,'pages' => $pages]);
    }

    /**
     * 云运动 - 销售统计 - 课程预约统计
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/7/24
     * @return array
     */
    public function actionAboutClassCount()
    {
        $date = \Yii::$app->request->get('date');
        $venue = \Yii::$app->request->get('venueId');
        $params['start'] = strtotime(Func::getTokenClassDate($date, true));
        $params['end'] = strtotime(Func::getTokenClassDate($date, false));
        $card = new CardCategory();
        $params['venueId'] = !empty($venue) ? $venue : $card->getVenueIdByRole();
//        $params['companyId'] = $this->companyId;
        $params['status'] = 1;
        $model = new AboutClass();
        $data = $model->classCount($params);
        return json_encode($data);
    }
}
