<?php

namespace backend\controllers;

use backend\models\CardCategory;
use backend\models\MatchingRecord;
use common\models\Func;
use backend\models\AttributeMatchingForm;
use backend\models\MemberCardMatchingForm;

class CardTypeController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 公共管理 - 会员卡列表 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2018/2/2
     * @return bool|string
     */
    public function actionCardInfo()
    {
        $params = $this->get;
        $model = new CardCategory();
        $memberInfo = $model->memberCardCategoryArray($params);
        $pagination = $memberInfo->pagination;
        $pages = Func::getPagesFormat($pagination);

        return json_encode(['data' => $memberInfo->models, 'pages' => $pages]);
    }

    /**
     * 公共管理 - 属性匹配 - 属性匹配表单验证
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/2/2
     * @return string
     */
    public function actionAttributeMatching()
    {
        set_time_limit(0);
        $post = \Yii::$app->request->post();
        $companyId = $this->companyId;
        $model = new AttributeMatchingForm();
        if ($model->load($post, '') && $model->validate()) {
            $save = $model->setCardMatching($companyId);
            if ($save === true) {
                return json_encode(['status' => 'success', 'message' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'message' => $save]);
            }
        } else {
            return json_encode(['status' => 'error', 'message' => $model->errors]);
        }
    }

    /**
     * 公共管理 - 匹配记录列表 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2018/2/2
     * @return bool|string
     */
    public function actionMatchingRecord()
    {
        $cardId = \Yii::$app->request->get('id');
        $model = new MatchingRecord();
        $memberInfo = $model->matchingRecordInfo($cardId);
        $pagination = $memberInfo->pagination;
        $pages = Func::getPagesFormat($pagination, 'replaceMatchingPages');

        return json_encode(['data' => $memberInfo->models, 'pages' => $pages]);
    }

    /**
     * 会员管理 - 会员卡列表 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/3/14
     * @return bool|string
     */
    public function actionCardCategoryAll()
    {
        $id = \Yii::$app->request->get('cardCategoryId');
        $model = new CardCategory();
        $memberInfo = $model->cardCategoryAll($id);
        return json_encode(['data' => $memberInfo]);
    }

    /**
     * 会员管理 - 会员卡详情 - 会员卡匹配表单验证
     * @author Huang hua <huanghua@itsports.club>
     * @create 2018/3/14
     * @return bool|string
     */
    public function actionMatchingRecordMemberCard()
    {
        set_time_limit(0);
        $post = \Yii::$app->request->post();
        $companyId = $this->companyId;
        $model = new MemberCardMatchingForm();
        if ($model->load($post, '') && $model->validate()) {
            $save = $model->setMemberCardMatching($companyId);
            if ($save === true) {
                return json_encode(['status' => 'success', 'message' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'message' => $save]);
            }
        } else {
            return json_encode(['status' => 'error', 'message' => $model->errors]);
        }
    }

}
