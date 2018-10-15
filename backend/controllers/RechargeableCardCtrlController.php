<?php

namespace backend\controllers;

use backend\models\CardCategory;
use backend\models\ChargeClass;
use backend\models\Organization;
use backend\models\Course;
use backend\models\Server;
use backend\models\ServicePay;
use backend\models\Employee;
use Yii;

class RechargeableCardCtrlController extends BaseController
{

    /**
     *  会员卡管理- 充值卡页面
     * @return string
     * @author 程丽明
     * create 2017-4-13
     */

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 云运动 - 卡种 - 充值卡获取模板
     * @return string
     * @author 程丽明
     * @param  attr //获取的模板值
     * @param  $num //数值
     * @create 2017-4-13
     */
    public function actionAddVenue($attr, $num = 0)
    {
        $param = CardCategory::getTemplate($attr);
        $html = $this->renderPartial($param, ['num' => $num]);
        return json_encode(['html' => $html]);
    }

    /**
     * 云运动 - 卡种 - 充值卡获取组织结构
     * @return string
     * @author 李慧恩
     * @param  $status
     * @param  $type
     * @create 2017-4-13
     */
    public function actionGetVenue($status = null, $type = null)
    {
        $organ = new Organization();
        $venue = $organ->getOrganizationOption($this->venueIds, $status, $this->companyId, $type);

        return json_encode(['venue' => $venue]);
    }

    /**
     * 云运动 - 订单 - 获取用户有权限查看的场馆
     * @return string
     * @author 焦冰洋
     * @create 2017-8-14
     */
//    public function actionGetAuthVenue()
//    {
//        $roleId        =    \Yii::$app->user->identity->level;
//        if($roleId == 0){
//            $vId       =    Organization::find()->select('id')->where(['style'=>2])->asArray()->all();
//            $venueIds  =    array_column($vId, 'id');
//        }else{
//            $venuesId  =    Auth::findOne(['role_id' => $roleId])->venue_id;
//            $venueIds  =    json_decode($venuesId);
//        }
//        $venueId       =    (isset($venId) && !empty($venId)) ? $venId : $venueIds;
//        $venue         =    Organization::find()->select(['id','name'])->where(['id'=>$venueId])->asArray()->all();
//        return json_encode(['venue'=>$venue]);
//    }

    /**
     * 云运动 - 卡种 - 获取用户有权限查看的场馆
     * @return string
     * @author 焦冰洋
     * @create 2017-8-12
     */
    public function actionGetVenueData()
    {
        $companyId = \Yii::$app->request->get('companyId');
        $organ = new Employee();
        $venue = $organ->getOrganizationAuthData($companyId);
        return json_encode(['venue' => $venue]);
    }


    /**
     * 云运动 - 卡种 - 充值卡获取组织结构
     * @return string
     * @author 李慧恩
     * @create 2017-4-13
     */
    public function actionGetVenueAll()
    {
        $organ = new Organization();
        $venues = $organ->getOrganizationOption($this->venueIds, $status = null, $this->companyId);

        return json_encode(['venues' => $venues]);
    }

    /**
     * 云运动 - 组织架构 - 获取组织结构
     * @return string
     * @author 朱梦珂
     * @create 2017-5-9
     */
    public function actionGetCompany()
    {
        $organ = new Organization();
        $venue = $organ->getOrganizationCompany($this->companyIds);

        return json_encode(['venue' => $venue]);
    }

    /**
     * 云运动 - 组织架构 - 获取组织结构
     * @return string
     * @author 朱梦珂
     * @create 2017-5-9
     */
    public function actionGetDepartment()
    {
        $organ = new Organization();
        $venue = $organ->getOrganizationDepartment($this->venueIds);

        return json_encode(['venue' => $venue]);
    }

    /**
     * 云运动 - 角色管理 - 分配员工部门
     * @return string
     * @author 黄华
     * @create 2017-6-23
     */
    public function actionGetDepartmentDate()
    {
        $companyId = Yii::$app->request->get('companyId');
        $organ = new Organization();
        $venue = $organ->getOrganizationDepartmentDate($this->venueIds, $companyId);

        return json_encode(['venue' => $venue]);
    }

    /**
     * 云运动 - 卡种 - 充值卡获取组织结构
     * @return string
     * @author 李慧恩
     * @create 2017-4-13
     * @update 黄鹏举
     * @update 2017/06/10
     */
    public function actionGetClassData()
    {
        $organ = new Course();
        $venue = $organ->groupCourse($this->venueIds);

        return json_encode(['venue' => $venue]);
    }

    /**
     * 云运动 - 私课 - 添加课程组织结构
     * @return string
     * @author 朱梦珂
     * @create 2017-4-26
     */
    public function actionGetPrivateData()
    {
        $organ = new Course();
        $venue = $organ->groupPrivateCourse($this->venueIds);

        return json_encode(['venue' => $venue]);
    }

    /**
     * 云运动 - 会员管理 - 新增私教课程
     * @return string
     * @author 朱梦珂
     * @create 2017-4-26
     */
    public function actionGetPrivateClassData()
    {
        $organ = new ChargeClass();
        $venue = $organ->groupPrivateCourse($this->venueIds);

        return json_encode(['venue' => $venue]);
    }

    /**
     * 云运动 - 卡种 - 充值卡获取组织结构
     * @return string
     * @author 李慧恩
     * @create 2017-4-13
     * @update 黄鹏举
     * @update 2017/06/10
     */
    public function actionGetServerData()
    {
        $organ = new Server();
        $venue = $organ->getServerData($this->venueIds);
        return json_encode(['venue' => $venue]);
    }

    /**
     * 云运动 - 卡种 - 充值卡获取组织结构
     * @return string
     * @author 李慧恩
     * @create 2017-4-13
     */
    public function actionGetShoppingData()
    {
        $pay = new ServicePay();
        $venueId = $this->venueIds;
        $payObj = $pay->getServicePayData(true, $venueId);
        return json_encode(['venue' => $payObj]);
    }

    /**
     * 云运动 - 卡种 - 充值卡获取组织结构
     * @return string
     * @author 李慧恩
     * @create 2017-4-13
     */
    public function actionGetDonationData()
    {
        $pay = new ServicePay();
        $venueId = $this->venueIds;
        $payObj = $pay->getServicePayData(false, $venueId);
        return json_encode(['goods' => $payObj]);
    }
}
