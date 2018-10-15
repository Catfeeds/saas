<?php

namespace backend\controllers;

use backend\rbac\Config;
use backend\models\Admin;
use Yii;

class BaseController extends \yii\web\Controller
{
    public $layout = 'admin';
    protected $get;
    protected $post;
    protected static $_user;
    protected static $_userId;
    protected $companyIds;    //用户有权限访问的公司
    protected $venueIds;      //用户有权限访问的场馆

    protected $venueId;       //用户所属场馆
    protected $companyId;     //用户所属公司
    protected $department;    //用户所属部门

    /**
     * @describe 控制器初始化 && 访问控制 && 系统用户信息和权限
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     */
    public function init()
    {
        $user = Yii::$app->user;
        if ($user->isGuest) {
            return $this->redirect('/login/index');
        }

        $this->getParams();
        self::$_user = $user->identity;
        self::$_userId = $user->identity->getId();
        $this->companyIds = $this->getCompanyAndVenue();
        $this->venueIds = $this->getCompanyAndVenue('venue');
        $employee_info = Admin::getAdminAndEmployeeOne();

        if(empty($employee_info) && in_array($user->identity->username, Config::$USA)){ /*超管帐号没权限, 查看其他模块*/
            $this->venueId = null;
            $this->companyId = null;
            $this->department = null;
        }else{
            $this->venueId = $employee_info['venue_id'];
            $this->companyId = $employee_info['company_id'];
            $this->department = $employee_info['organization_id'];
        }

        return parent::init();
    }

    /**
     * @describe 注册 get && post
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @return bool
     */
    public function getParams()
    {
        $this->get = Yii::$app->request->get();
        $this->post = Yii::$app->request->post();

        return true;
    }

    /**
     * @describe 响应格式化
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @param array $data
     * @param string $message
     * @param int $code
     * @param string $status
     * @return string
     */
    public function response($data = [], $message = '请求成功', $code = 1, $status = 'success')
    {
        return json_encode(['data' => $data, 'status' => $status, 'code' => $code, 'message' => $message]);
    }

    /**
     * @param string $option
     * @return array|mixed
     * 获取用户有权访问的公司(返回值: 一维数组 id)
     * 获取用户有权访问的场馆(返回值: 一维数组 id)
     */
    public function getCompanyAndVenue($option = 'company')
    {
        if ($option === 'company') {
            $company = Config::accessCompany();
            return $company;

        } elseif ($option === 'venue') {
            $venue = Config::accessVenues();
            return $venue;

        }

        return [];
    }

    /**
     * @param string $option
     * @return array|mixed
     *二级联动 - 通过公司获取场馆 (返回值: 二维数组 name, id
     * 获取用户有权访问的公司(返回值: 二维数组 name, id)
     */
    public function getCompaniesAndVenues($option = 'company')
    {
        if ($option === 'company') {
            $company = Config::companies();
            return $company;

        } elseif ($option === 'venue') {
            $company = $this->getCompanyAndVenue("company");
            if (empty($company)) {
                return [];
            }

            $venue = Config::venues($company);
            return $venue;
        }

        return [];
    }

    /**
     * @param string $type
     * @return array|mixed
     *二级联动 - 通过公司获取场馆 (返回值: 二维数组 name, id
     * 获取用户有权访问的公司(返回值: 二维数组 name, id)
     */
    public function actionPublicVenues($type = 'company')
    {
        return $this->response($this->getCompaniesAndVenues($type));
    }

}