<?php

namespace backend\controllers;
use backend\models\FitnessDiet;
use backend\models\FitnessDietForm;
use backend\models\FitnessProgramSend;
use backend\models\MemberFitnessProgram;
use backend\models\MemberFitnessProgramForm;
use common\models\Func;

class UserMaintainController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 云运动 - 会员维护 - 获取上过私教课的会员列表
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/27
     * @return array
     */
    public function actionFitnessMemberList()
    {
        $params     = \Yii::$app->request->queryParams;
        if (isset($params['page']) && !empty($params['page'])) {
            $nowPage = $params['page'];
        }else{
            $nowPage = 1;
        }
        $model      = new MemberFitnessProgram();
        $data       = $model->fitnessMemberList($params);
        $pagination = $data->pagination;
        $pages      = Func::getPagesFormat($pagination);
        return json_encode(['data'=>$data->models,'pages'=>$pages,'now'=>$nowPage]);
    }

    /**
     * 云运动 - 会员维护 - 新增、修改健身目标，新增、修改饮食计划
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/24
     * @return array
     */
    public function actionEditFitnessDiet()
    {
        $post              = \Yii::$app->request->post();
        $post['companyId'] = $this->companyId;
        $post['venueId']   = $this->venueId;
        $model = new FitnessDietForm();
        $model->setScenario($post['scenarios']);
        if($model->load($post, '') && $model->validate()){
            if($post['scenarios'] == 'addFitness'){
                $data = $model->addFitnessGoal();       //新增健身目标
            }elseif($post['scenarios'] == 'addDiet'){
                $data = $model->addDietPlan();          //新增饮食计划
            }elseif($post['scenarios'] == 'updateFitness'){
                $data = $model->updateFitnessGoal();    //修改健身目标
            }else{
                $data = $model->updateDietPlan();       //修改饮食计划
            }
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        }else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 云运动 - 会员维护 - 获取健身目标、饮食计划数据列表
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/25
     * @return array
     */
    public function actionGetFitnessData()
    {
        $type  = \Yii::$app->request->get('type');
        $model = new FitnessDiet();
        $data  = $model->getFitnessData($type,$this->nowBelongType,$this->nowBelongId);
        return json_encode($data);
    }

    /**
     * 云运动 - 会员维护 - 获取某一个健身目标、饮食计划数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/27
     * @return array
     */
    public function actionGetFitnessOne()
    {
        $fitDietId = \Yii::$app->request->get('fitDietId');
        $model     = new FitnessDiet();
        $data      = $model->getFitnessOne($fitDietId);
        return json_encode($data);
    }

    /**
     * 云运动 - 会员维护 - 删除健身目标，删除饮食计划
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/24
     * @return array
     */
    public function actionDelFitnessDiet()
    {
        $fitDietId = \Yii::$app->request->get('fitDietId');
        $model     = new FitnessDietForm();
        $data      = $model->delFitnessDiet($fitDietId);
        if ($data === true) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $data]);
        }
    }

    /**
     * 云运动 - 会员维护 - 新增会员健身详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/25
     * @return array
     */
    public function actionAddMemberFitness()
    {
        $post  = \Yii::$app->request->post();
        $model = new MemberFitnessProgramForm();
        if($model->load($post, '') && $model->validate()){
            $data = $model->addMemberFitness();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        }else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 云运动 - 会员维护 - 获取会员健身详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/27
     * @return array
     */
    public function actionMemberFitnessDetail()
    {
        $memberId = \Yii::$app->request->get('memberId');
        $model    = new MemberFitnessProgram();
        $data     = $model->getMemberFitness($memberId);
        return json_encode($data);
    }

    /**
     * 云运动 - 会员维护 - 发送健身目标短信、发送饮食计划短信（群发）
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/27
     * @return array
     */
    public function actionSendFitnessDiet()
    {
        $post  = \Yii::$app->request->post();
        $model = new FitnessProgramSend();
        $model->sendFitness($post);
        return json_encode(['status' => 'success','data' => '发送成功']);
    }

    /**
     * 云运动 - 会员维护 - 发送健身目标短信、发送饮食计划短信（单发）
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/30
     * @return array
     */
    public function actionSendFitnessDietOne()
    {
        $memberId = \Yii::$app->request->get('memberId');
        $type     = \Yii::$app->request->get('type');
        $model    = new FitnessProgramSend();
        $data     = $model->sendFitnessOne($memberId,$type,1);
        if($data == null){
            return json_encode(['status' => 'success','data' => '发送成功']);
        }else{
            return json_encode(['status' => 'error','data' => $data]);
        }
    }

    /**
     * 云运动 - 会员维护 - 获取给该会员发送过的短信
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/28
     * @return array
     */
    public function actionGetFitnessMessage()
    {
        $memberId = \Yii::$app->request->get('memberId');
        $model    = new FitnessProgramSend();
        $data     = $model->getFitnessMessage($memberId);
        return json_encode($data);
    }
}
