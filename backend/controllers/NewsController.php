<?php

namespace backend\controllers;

use backend\models\SmsRecord;
use common\models\Func;
use Yii;
class NewsController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     *后台短信管理 - 短信列表 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/8
     * @return bool|string
     */
    public function actionSmsInfo()
    {
        $params = $this->get;
        $model = new SmsRecord();
        if(isset($params['page'])){
            $nowPage = $params['page'];
        }else{
            $nowPage = 1;
        }

        $params['venueIds'] = $this->venueIds;
        $memberInfo = $model->search($params);
        $pagination = $memberInfo->pagination;
        $pages = Func::getPagesFormat($pagination);

        return json_encode(['data' => $memberInfo->models, 'pages' => $pages,'now'=>$nowPage]);
    }

    /**
     *后台短信管理 - 短信列表 - 清空列表
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/8
     * @return bool|string
     */
    public function actionDelSmsAll()
    {
        $venueId  = \Yii::$app->request->post('venueId');//短信id
        $model  = new SmsRecord();
        $delRes = $model->getDelSmsAll($venueId);
        if ($delRes === true) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $delRes]);
        }

    }

    /**
     *后台短信管理 - 短信列表 - 列表详情
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/9
     * @return bool|string
     */
    public function actionSmsDetails()
    {
        $smsId = Yii::$app->request->get('smsId');
        if (!empty($smsId)) {
            $model = new SmsRecord();
            $smsData = $model->getSmsModel($smsId);
            return json_encode($smsData);
        } else {
            return false;
        }
    }

    /**
     *后台短信管理 - 短信列表 - 发送失败重新发送
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/11
     * @return bool|string
     */
    public function actionSmsResend()
    {
        $smsId = Yii::$app->request->get('smsId');
        $model = new SmsRecord();
        $smsData = $model->getSmsResend($smsId);
        if ($smsData === true) {
            return json_encode(['status' => 'success', 'data' => '重新发送成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '重新发送失败']);
        }
    }
}
