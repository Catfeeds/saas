<?php
namespace backend\modules\v3\controllers;
use backend\modules\v3\models\StatisticsModel;
use yii\web\response;
use yii\rest\ActiveController;
class ApiStatisticsController extends ActiveController
{
    public $modelClass = 'backend\modules\v3\models\StatisticsModel';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                // restrict access to
                'Access-Control-Request-Method' => ['*'],
                // Allow only POST and PUT methods
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON];
        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * 运运动-微信公众号-会员信息统计接口
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/28
     * @param $mobile //会员手机号
     * @return array
     */
    public function actionStatistics($mobile)
    {
        $ids = StatisticsModel::gainMyAllAccount($mobile);
        if(!$ids){
            return ['status' => 'error', 'code' => 0, 'message' => '您还不是会员' , 'data' => []];
        }
        $model = new StatisticsModel();
        return ['status' => 'success', 'data' => $model->gainAllStatistics($ids)];
    }
    /**
     * 运运动-微信公众号-会员进场统计记录接口
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/28
     * @param $mobile //会员手机号
     * @return array
     */
    public function actionEntryRecord($mobile)
    {
        $ids = StatisticsModel::gainMyAllAccount($mobile);
        if(!$ids){
            return ['status' => 'error', 'code' => 0, 'message' => '您还不是会员' , 'data' => []];
        }
        $model = new StatisticsModel();
        return ['status' => 'success', 'data' => $model->gainMemberEntryRecord($ids)];
    }
    /**
     * 运运动-微信公众号-会员累计天数统计记录接口
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/28
     * @param $mobile //会员手机号
     * @return array
     */
    public function actionDaysRecord($mobile)
    {
        $ids = StatisticsModel::gainMyAllAccount($mobile);
        if(!$ids){
            return ['status' => 'error', 'code' => 0, 'message' => '您还不是会员' , 'data' => []];
        }
        $model = new StatisticsModel();
        return ['status' => 'success', 'data' => $model->gainMemberDaysRecord($ids)];
    }

    /**
     * 运运动-微信公众号-会员上课时长统计记录接口
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/28
     * @param $mobile //会员手机号
     * @return array
     */
    public function actionClassRecord($mobile)
    {
        $ids = StatisticsModel::gainMyAllAccount($mobile);
        if(!$ids){
            return ['status' => 'error', 'code' => 0, 'message' => '您还不是会员' , 'data' => []];
        }
        $model = new StatisticsModel();
        return ['status' => 'success', 'data' => $model->gainMemberClassTimeRecord($ids)];
    }

    /**
     * 运运动-微信公众号-会员约课统计记录接口
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/28
     * @param $mobile //会员手机号
     * @return array
     */
    public function actionAboutCourseRecord($mobile)
    {
        $ids = StatisticsModel::gainMyAllAccount($mobile);
        if(!$ids){
            return ['status' => 'error', 'code' => 0, 'message' => '您还不是会员' , 'data' => []];
        }
        $model = new StatisticsModel();
        return ['status' => 'success', 'data' => $model->gainMemberAboutCourseRecord($ids)];
    }
}