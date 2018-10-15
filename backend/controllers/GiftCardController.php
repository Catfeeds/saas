<?php

namespace backend\controllers;

use backend\models\GiftCardActivity;
use backend\models\GiftCardBindForm;
use backend\models\GiftCardMakeForm;
use backend\models\GiftCardForm;
use common\models\Func;
class GiftCardController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @desc: 卡种管理-赠卡管理-新增赠送接口
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/07
     * @return string
     */
    public function actionSaveGift()
    {
        $params = \Yii::$app->request->post();
        $model = new GiftCardForm();
        if ($model->load($params,'') && $model->validate()) {
            $result = $model->saveGiftCardActivity($this->companyId);
            if ($result) {
                return json_encode(['status'=>'success','data'=>'添加成功']);
            }
            return json_encode(['status'=>'error','data'=>$result]);
        }
        return json_encode(['status'=>'error','data'=>'添加失败']);
    }

    /**
     * @desc: 卡种管理-赠卡管理-生成赠送会员卡接口
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/08
     * @return string
     */
    public function actionMakeCard()
    {
        $params = \Yii::$app->request->post();
        $model = new GiftCardMakeForm();
        if ($model->load($params,'') && $model->validate()) {
            $result = $model->GiftCardMake();
            if ($result) {
                return json_encode(['status'=>'success','data'=>'添加成功']);
            }
            return json_encode(['status'=>'error','data'=>$result]);
        }
        return json_encode(['status'=>'error','data'=>'添加失败']);
    }

    /**
     * @desc: 卡种管理-赠卡管理-获取赠送单位列表
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/08
     * @return string
     * @throws \Exception
     */
    public function actionGetActivityList()
    {
        $params = \Yii::$app->request->get();
        $model = new GiftCardActivity();
        $data = $model->searchActivityList($params);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination,'activityList');
        return json_encode(['data'=>$data->models,'pages'=>$pages]);
    }

    /**
     * @desc: 卡种管理-赠卡管理-获取会员卡列表
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/08
     * @return string
     * @throws \Exception
     */
    public function actionGetCardList()
    {
        $params = \Yii::$app->request->get();
        $model = new GiftCardActivity();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        }else{
            $nowPage = 1;
        }
        $data = $model->searchCardList($params);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination,'cardList');
        return json_encode(['data'=>$data->models,'pages'=>$pages,'now'=>$nowPage]);
    }

    /**
     * @desc: 卡种管理-赠卡管理-会员卡绑定人
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/22
     * @return string
     */
    public function actionBindMember()
    {
        $post = \Yii::$app->request->post();
        $model = new GiftCardBindForm();
        if ($model->load($post,'') && $model->validate()) {
            $result = $model->saveBindMember($this->companyId);
            if ($result == 'success') {
                return json_encode(['status'=>'success','data'=>'绑定成功']);
            }
            return json_encode(['status'=>'error','data'=>$result]);
        }
        return json_encode(['status'=>'error','data'=>'绑定失败']);
    }
}
