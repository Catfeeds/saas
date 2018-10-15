<?php

namespace backend\controllers;

use backend\models\BlendCardDataRuleForm;
use backend\models\CardCategoryUpdate;
use backend\models\GiftDay;
use backend\models\GiveDayForm;
use backend\models\CardCategory;
use backend\models\CardCategoryType;
use backend\models\CardDiscount;
use backend\models\CardGiftDayForm;
use backend\models\CardTime;
use backend\models\Config;
use backend\models\LimitCardNumber;
use backend\models\MemberDealRecord;
use backend\models\Organization;
use backend\models\TimeCardDataRuleForm;
use backend\models\RechargeRuleForm;
use backend\models\TimesCardForm;
use backend\models\SellCardForm;
use common\models\base\Member;
use common\models\BindPack;
use common\models\Func;
use backend\models\CardEdit;
use backend\models\MemberCard;

class MemberCardController extends BaseController
{
    /**
     * 会员卡管理 - 首页 - 列表的展示
     * @return string
     * @auther 李广杨
     * @create 2017-3-21
     * @param
     */
    public function actionIndex()
    {
//        \Yii::$app->session->removeAll();
        return $this->render('index');
    }

    /**
     * 会员卡管理 - 首页 - 时间卡
     * @return string
     * @auther 李广杨
     * @create 2017-3-21
     * @param
     */
    public function actionNewTimeCard()
    {
        return $this->render('newTimeCard');
    }

    public function actionTimeCard()
    {
        return $this->render('timeCard');
    }

    /**
     * 会员卡管理 - 首页 - 次卡
     * @return string
     * @auther 李广杨
     * @create 2017-3-25
     * @param
     */
    public function actionCard()
    {
        return $this->render('card');
    }

    /**
     * 会员卡管理 - 首页 - 充值卡
     * @return string
     * @auther 李广杨
     * @create 2017-3-25
     * @param
     */
    public function actionRechargeCard()
    {
        return $this->render('rechargeCard');
    }

    /**
     * 会员卡管理 - 首页 - 混合卡
     * @return string
     * @auther 李广杨
     * @create 2017-3-25
     * @param
     */
    public function actionBlendCard()
    {
        return $this->render('blendCard');
    }

    public function actionVenueRestrictions()
    {
        return $this->render('venueRestrictions');
    }

    /**
     * 会员卡管理 - 首页 - 制定定价和售卖规则
     * @return string
     * @auther 李广杨
     * @create 2017-3-25
     * @param
     */
    public function actionFormulate()
    {
        return $this->render('formulate');
    }

    /**
     * 会员卡管理 - 首页 - 绑定套餐
     * @return string
     * @auther 李广杨
     * @create 2017-3-26
     * @param
     */
    public function actionBindPackages()
    {
        return $this->render('bindPackages');
    }

    /**
     * 会员卡管理 - 首页 - 合同管理
     * @return string
     * @auther 李广杨
     * @create 2017-3-28
     * @param
     */
    public function actionContract()
    {
        return $this->render('contract');
    }

    /**
     * 会员卡管理 - 会员卡 - 获取数据
     * @create 2017/4/5
     * @author lihuien<lihuien@itsports.club>
     * @return bool
     */
    public function actionNumberCard()
    {
        return $this->render('numberCard');
    }

    /**
     * 会员卡管理 - 会员卡 - 次卡
     * @create 2017/4/13
     * @author 苏雨
     * @return bool
     */
    public function actionGetCardData()
    {
        $params = $this->get;
        $cardCategory = new CardCategory();
        $dataProvider = $cardCategory->search($params);
        $pages = Func::getPagesFormat($dataProvider->pagination);

        return json_encode(['data' => $dataProvider->models, 'pages' => $pages]);
    }

    /**
     * 会员卡管理 - 会员卡 - 修改状态
     * @create 2017/4/5
     * @author lihuien<lihuien@itsports.club>
     * @param
     * @param
     * @return bool
     */
    public function actionEditCardStatus($id, $text)
    {
        $edit = CardCategory::editStatus($id, $text);
        if ($edit === 1 || $edit === 2 || $edit === 3) {
            return json_encode(['status' => 'success', 'data' => '修改成功', 'edit' => $edit]);
        } else {
            return json_encode(['status' => 'error', 'data' => $edit]);
        }
    }

    /**
     * 会员卡管理 - 会员卡 - 删除数据
     * @create 2017/4/5
     * @author lihuien<lihuien@itsports.club>
     * @return bool
     */
    public function actionDeleteCard()
    {
        $id = \Yii::$app->request->get('id');

        $del = CardCategory::deleteAll(['id' => $id]);
        LimitCardNumber::deleteAll(['card_category_id' => $id]);
        CardTime::deleteAll(['card_category_id' => $id]);
        BindPack::deleteAll(['card_category_id' => $id]);
        if ($del) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $del]);
        }
    }

    /**
     * 会员卡管理 - 会员卡 - 删除数据
     * @create 2017/4/5
     * @author lihuien<lihuien@itsports.club>
     * @return bool
     */
    public function actionUpdateCardCompany()
    {
        $id = \Yii::$app->request->get('id');
        $companyId = \Yii::$app->request->get('companyId');
        $venueId = \Yii::$app->request->get('venueId');
        $del = CardCategory::updateAll(['company_id' => $companyId, 'venue_id' => $venueId], ['id' => $id]);
        if ($del) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '修改失败']);
        }
    }

    /**
     * @云运动 - 会员卡 - 时间卡卡种表单验证
     * @author Houakixin <Houkaixin@itsports.club>
     * @create 2017/4/15
     * @return string
     */
    public function actionVerification()
    {
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $post = \Yii::$app->request->post();
        $scenario = $post['scenario'];
        $model = new TimeCardDataRuleForm([], $scenario);
        if (isset($scenario) && $scenario != "cancel") {
            if ($model->load($post, '') && $model->validate()) {
                $data = $model->sessionLoadModel($model, $companyId, $venueId);
                if ($data === true) {
                    return json_encode(['status' => 'success', 'data' => '操作成功']);
                } else {
                    return json_encode(['status' => 'error', 'data' => $data]);
                }
            } else {
                return json_encode(['status' => 'error', 'data' => $model->errors]);
            }
        } else {
            return json_encode(['status' => 'success', 'data' => '取消成功']);
        }
    }

    /**
     * 云运动 - 会员卡 - 充值卡种表单验证
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/8
     * @return string
     */
    public function actionRechargeCardRule()
    {
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $post = \Yii::$app->request->post();
        $scenario = $post['scenario'];
        $model = new RechargeRuleForm([], $scenario);
        if ($scenario != 'cancel') {
            if ($model->load($post, '') && $model->validate()) {
                $save = $model->sessionLoadModel($model, $companyId, $venueId);
                if ($scenario == 'finish' && $save !== true) {
                    return json_encode(['status' => 'error', 'data' => $save]);
                }
                return json_encode(['status' => 'success', 'data' => '']);
            } else {
                return json_encode(['status' => 'error', 'data' => $model->errors]);
            }
        } else {
            return json_encode(['status' => 'success', 'data' => '']);
        }
    }

    /**
     * 云运动 - 会员卡 - 次卡表单验证
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/4/10
     * @return string
     */
    public function actionTimesCard()
    {
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $post = \Yii::$app->request->post();
        $scenario = $post['scenario'];
        $model = new TimesCardForm([], $scenario);
        if (isset($scenario) && $scenario != "cancel") {
            if ($model->load($post, '') && $model->validate()) {
                $save = $model->sessionLoadModel($model, $companyId, $venueId);
                if ($scenario == 'four' && $save !== true) {
                    return json_encode(['status' => 'error', 'data' => $save]);
                }
                return json_encode(['status' => 'success', 'data' => '添加成功！']);
            } else {
                return json_encode(['status' => 'error', 'data' => $model->errors]);
            }
        } else {
            return json_encode(['status' => 'cancel', 'data' => '取消成功']);
        }
    }

    /**
     * 云运动 - 卡种 - 充值卡获取模板
     * @return string
     * @author 朱梦珂
     * @param  attr //获取的模板值
     * @param  $num //数值
     * @create 2017-4-19
     */
    public function actionAddVenue($attr, $num = 0)
    {
        $param = CardCategory::getTemplate($attr);
        $html = $this->renderPartial($param, ['num' => $num]);
        return json_encode(['html' => $html]);
    }

    /**
     * 云运动 - 会员卡 - 混合卡卡种表单验证
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/13
     * @return string
     */
    public function actionBlendCardRule()
    {
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $post = \Yii::$app->request->post();
        $scenario = $post['scenario'];          //取出场景
        $model = new BlendCardDataRuleForm([], $scenario);
        if ($scenario != 'cancel') {
            if ($model->load($post, '') && $model->validate()) {
                $model->setSessionData($model, $companyId, $venueId);
                return json_encode(['status' => 'success', 'data' => '']);
            } else {
                return json_encode(['status' => 'error', 'data' => $model->errors]);
            }
        } else {
            return json_encode(['status' => 'success', 'data' => '']);
        }
    }

    /**
     * 云运动 - 会员卡 - 混合卡卡种表单验证
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/13
     * @param $name string 卡名称
     * @param $venueId int  场馆ID
     * @return string
     */
    public function actionSetCardName($name, $venueId = null)
    {
        $venueId = !empty($venueId) ? $venueId : $this->venueId;
        $cardName = CardCategory::setCardName($name, $venueId);
        if ($cardName) {
            return json_encode(['status' => 'error', 'message' => '卡名称已经存在']);
        }
        return json_encode(['status' => 'success', 'message' => '卡名称不存在']);
    }

    /**
     * 云运动 - 卡种 - 获取卡种类别
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/24
     */
    public function actionGetType()
    {
        $model = new CardCategoryType();
        $type = $model->getCardType();
        return json_encode(['type' => $type]);
    }

    /**
     * 云运动 - 卡种 - 获取卡种类别
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/27
     * @return string
     */
    public function actionGetCardAttributes()
    {
        $model = new Func();
        $data = $model->setCardAttributes();
        return json_encode(['attributes' => $data]);
    }

    /**
     * 云运动 - 卡种管理 - 获取卡种信息
     * @author 侯凯新 <houkaixin@itsports.club>
     * @create 2017/5/11
     * @return string
     */
    public function actionGetCardDetail()
    {
        $id = \Yii::$app->request->get("id");
        $card = new CardCategory();
        $data = $card->getCardVenueData($id);
        return json_encode($data);
    }

    /**
     * 云运动 - 卡种 - 编辑卡种信息：售价、售卖时间
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/08/07
     * @return string
     */
    public function actionEditCard()
    {
        $post = \Yii::$app->request->post();
        $model = new CardEdit();
        if ($model->load($post, '') && $model->validate()) {
            $edit = $model->editCard();
            if ($edit === true) {
                return json_encode(['status' => 'success', 'data' => $edit]);
            } else {
                return json_encode(['status' => 'error', 'data' => $edit]);
            }
        }
        return json_encode(['status' => 'error', 'data' => $model->errors]);
    }

    /**
     * 云运动 - 卡种 - 获取续费设置
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/27
     * @return string
     */
    public function actionGetConfig()
    {
        $model = new Config();
        $data = $model->getConfigCard();
        return json_encode(['attributes' => $data]);
    }

    /**
     * 云运动 - 卡种 - 获取提前续费设置
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/26
     * @return string
     */
    public function actionGetConfigData()
    {

        $model = new Config();
        $data = $model->getConfigCardData($this->venueId);
        return json_encode(['attributes' => $data]);
    }

    /**
     * 云运动 - 卡种 - 获取续费设置
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/27
     * @return string
     */
    public function actionGetCardDiscount($id)
    {
        $model = new CardDiscount();
        $data = $model->getCardDiscount($id);
        return json_encode(['status' => 'success', 'data' => $data]);
    }

    /**
     * 云运动 - 卡种 - 修改显示状态
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/27
     * @return string
     */
    public function actionUpdateCardIsAppShow($id)
    {
        $model = new CardCategory();
        $data = $model->updateIsAppShow($id);
        if ($data === 1 || $data === 2 || $data === 3) {
            return json_encode(['status' => 'success', 'message' => '修改成功', 'data' => $data]);
        } else {
            return json_encode(['status' => 'error', 'data' => $data]);
        }
    }

    /**
     * @云运动 - 会员管理 - 会员卡升级选择折扣
     * @author huanghua huanghua@itsports.club
     * @param $newCardCategory
     * @create 2017/9/15
     * @return array
     */
    public function actionNewCardCategory($newCardCategory)
    {
        $cardCategory = SellCardForm::getNewDiscount($this->venueId, $newCardCategory);
        return json_encode($cardCategory);
    }

    /**
     * 云运动 - 卡种 - 设置赠送天数
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/08/07
     * @return string
     */
    public function actionAddGiftDay()
    {
        $post = \Yii::$app->request->post();
        $model = new CardGiftDayForm();
        if ($model->load($post, '') && $model->validate()) {
            $edit = $model->saveGift($this->companyId);
            if ($edit === true) {
                return json_encode(['status' => 'success', 'data' => $edit]);
            } else {
                return json_encode(['status' => 'error', 'data' => $edit]);
            }
        }
        return json_encode(['status' => 'error', 'data' => $model->errors]);
    }

    /**
     * 云运动 - 卡种管理 - 设置 - 获取赠送天数
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/21
     * @return string
     */
    public function actionGetGiftData()
    {
        $type = \Yii::$app->request->get('type');
        $venueId = \Yii::$app->request->get('venueId');
        $model = new GiftDay();
        $data = $model->getGiftData($type, $venueId);
        return json_encode($data);
    }

    /**
     * 云运动 - 卡种管理 - 设置 - 删除赠送天数
     * 云运动 - 私教产品 - 设置 - 删除折扣
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/21
     * @return boolean
     */
    public function actionDelGiftData()
    {
        $giftId = \Yii::$app->request->get('giftId');
        $model = new GiftDay();
        $data = $model->delGiftData($giftId);
        if ($data == true) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $data]);
        }
    }

    /**
     * 卡种管理 - 有效期 - 获取此卡种续费有效期
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/09/23
     * @params $memberCardId
     * @return string
     */
    public function actionCardCategoryData()
    {
        $memberCardId = \Yii::$app->request->get('memberCardId');
        $cardCategory = new CardCategory();
        $memberCardData = $cardCategory->getValidTime($memberCardId);
        return json_encode($memberCardData);
    }

    /**
     * 云运动 - 卡种 - 获取设置
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/08/07
     * @param  $type
     * @return string
     */
    public function actionGetConfigCardData($type = 'card')
    {
        $venueId = \Yii::$app->request->get('venueId');
        if (empty($venueId) || !isset($venueId)) {
            $venueId = $this->venueId;
        }
        $config = new Config();
        $data = $config->getMemberConfigData($this->companyId, $venueId, $type);
        return json_encode(['data' => $data]);
    }

    /**
     * 云运动 - 会员管理 - 会员详情会员卡赠送天数
     * @author 黄华 <huanghua@itsports.club>
     * @create 2017/10/16
     * @return array
     */
    public function actionGiveDay()
    {
        $post = \Yii::$app->request->post();
        $model = new GiveDayForm();
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->giveDayData();
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '赠送成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 云运动 - 卡种管理 - 卡种修改
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/10/26
     * @return boolean
     */
    public function actionCardEdit()
    {
        $post = \Yii::$app->request->post();
        $model = new CardCategoryUpdate();
        $model->setScenario($post['scenarios']);
        if ($model->load($post, '') && $model->validate()) {
            if ($post['scenarios'] == 'attributes') {
                $result = $model->attributesUpdate();    //卡种属性修改
            } elseif ($post['scenarios'] == 'price') {
                $result = $model->priceUpdate();         //定价和售卖修改
            } elseif ($post['scenarios'] == 'sellVenue') {
                $result = $model->sellVenueUpdate();     //售卖场馆修改
            } elseif ($post['scenarios'] == 'applyVenue') {
                $result = $model->applyVenueUpdate();    //通用场馆修改
            } elseif ($post['scenarios'] == 'time') {
                $result = $model->timeUpdate();          //进馆时间修改
            } elseif ($post['scenarios'] == 'groupClass') {
                $result = $model->groupClassUpdate();    //团课套餐修改
            } elseif ($post['scenarios'] == 'chargeClass') {
                $result = $model->chargeClassUpdate();   //绑定私课修改
            } elseif ($post['scenarios'] == 'gift') {
                $result = $model->giftUpdate();          //赠品设置修改
            } elseif ($post['scenarios'] == 'transfer') {
                $result = $model->transferUpdate();      //转让设置修改
            } elseif ($post['scenarios'] == 'leave') {
                $result = $model->leaveUpdate();         //请假设置修改
            } else {
                $result = $model->dealUpdate();          //绑定合同修改
            }
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 后台 - 卡种管理 - 根据权限获取不同场馆
     * @create 2017/9/23
     * @author lihuien<lihuien@itsports.club>
     * @return  mixed
     */
    public function actionGetVenueDataById()
    {
        $organ = new CardCategory();
        $data = $organ->getVenueDataById();
        return json_encode(['status' => 'success', 'data' => $data]);
    }

    /**
     *后台会员管理 - 会员详细信息会员卡 - 会员卡删除
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/11/27
     * @return bool|string
     */
    public function actionMemberCardDel()
    {
        $memberCardId = \Yii::$app->request->get('memberCardId');
        $model = new MemberCard();
        $delRes = $model->memberCardDel($memberCardId);
        if ($delRes === true) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $delRes]);
        }
    }

    /**
     * 后台会员管理 - 会员卡详情 - 点击触发自动修改会员卡到期状态
     * @author huanghua <huanghua@itsports.club>
     * @create 2018/5/8
     * @return bool|string
     */
    public function actionMemberCardStatus()
    {
        $memberId = \Yii::$app->request->get('memberId');
        $model = new MemberCard();
        $delRes = $model->memberCardUpdate($memberId);
        if ($delRes) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '修改失败']);
        }
    }

    /**
     * 正式会员 - 上传私教、会员卡合同照片
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/06/14
     * @return bool|string
     */
    public function actionUploadDealPic()
    {
        $post = \Yii::$app->request->post();
        $model = new MemberDealRecord();
        $data = $model->uploadDealPic($post, $this->companyId, $this->venueId);
        if ($data === true) {
            return json_encode(['status' => 'success', 'data' => '上传成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $data]);
        }
    }

    /**
     * 正式会员 - 获取私教、会员卡合同照片
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/06/14
     * @return bool|string
     */
    public function actionGetDealPic()
    {
        $params = \Yii::$app->request->queryParams;
        $model = new MemberDealRecord();
        $data = $model->getDealPic($params);
        return json_encode($data);
    }
}
