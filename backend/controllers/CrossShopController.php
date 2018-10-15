<?php

namespace backend\controllers;

use backend\models\MemberCard;
use backend\models\AcrossUpgradeForm;
class CrossShopController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     *后台会员管理 - 跨店升级 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/1/13
     * @return bool|string
     */
    public function actionMemberInfo()
    {
        $cardNumber = \Yii::$app->request->get('cardNumber');
        $companyId  = $this->companyId;
        if (!empty($cardNumber)) {
            $model = new MemberCard();
            $memberCardInfo = $model->memberCardInfo($cardNumber,$companyId);
            return json_encode(['card' => $memberCardInfo]);
        } else {
            return false;
        }
    }

    /**
     * 后台 - 会员管理 - 跨店升级
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/9/14
     * @return array
     */
    public function actionNewAcrossUpgrade()
    {
        header('Content-Type: text/html; charset=utf-8');
        $companyId = $this->companyId;
        $post      = \Yii::$app->request->post();
        if ($post['mobile'] == 0 || strlen($post['mobile']) != 11) {
            return json_encode(['status' => 'error', 'data' => '手机号格式不正确!']);
        }
        $model     = new AcrossUpgradeForm();
        if ($model->load($post, '') && $model->validate()) {

            if($model->newSaveCardUpdate($companyId) === true){
                return json_encode(['status' => 'success', 'data' => '升级成功']);
            }else{
                return json_encode(['status' => 'error1', 'data' => $model->newSaveCardUpdate($companyId)]);
            }
        } else {
            return json_encode(['status' => 'error2', 'data' => $model->newSaveCardUpdate($companyId)]);
        }
    }
}
