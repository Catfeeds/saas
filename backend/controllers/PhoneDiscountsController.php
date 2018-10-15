<?php

namespace backend\controllers;

use backend\models\AppCardDiscount;
use backend\models\AppCardDiscountForm;
use common\models\Func;

class PhoneDiscountsController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 后台 - 手机折扣 - 新增、修改移动端卡种折扣
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/8
     * @return bool|string
     */
    public function actionAddAppDiscount()
    {
        $post = $this->post;
        $model = new AppCardDiscountForm();
        $model->setScenario($post['scenarios']);
        if ($model->load($post, '') && $model->validate()) {
            if ($post['scenarios'] == 'add') {
                $result = $model->addAppDiscount();      //新增
            } else {
                $result = $model->updateAppDiscount();   //修改
            }
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '操作成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 后台 - 手机折扣 - 获取移动端卡种折扣列表
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/13
     * @return bool|string
     */
    public function actionAppDiscountList()
    {
        $params = $this->get;
        $model = new AppCardDiscount();
        $data = $model->appDiscountList($params);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination, 'appDiscountPages');

        return json_encode(['data' => $data->models, 'pages' => $pages]);
    }

    /**
     * 后台 - 手机折扣 - 删除移动端卡种折扣
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/13
     * @return bool|string
     */
    public function actionDelAppDiscount()
    {
        $discountId = \Yii::$app->request->get('discountId');
        $model = new AppCardDiscount();
        $data = $model->delAppDiscount($discountId);
        if ($data == true) {
            return json_encode(['status' => 'success', 'data' => '操作成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '操作失败']);
        }
    }

    /**
     * 后台 - 手机折扣 - 移动端卡种折扣详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/13
     * @return bool|string
     */
    public function actionAppDiscountDetails()
    {
        $discountId = \Yii::$app->request->get('discountId');
        $model = new AppCardDiscount();
        $data = $model->appDiscountDetails($discountId);
        return json_encode($data);
    }

    /**
     * 后台 - 手机折扣 - 移动端卡种折扣冻结、解冻
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/2/13
     * @return bool|string
     */
    public function actionFrozenAppDiscount()
    {
        $discountId = \Yii::$app->request->get('discountId');
        $model = new AppCardDiscount();
        $data = $model->frozenAppDiscount($discountId);
        if ($data == true) {
            return json_encode(['status' => 'success', 'data' => '操作成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '操作失败']);
        }
    }
}
