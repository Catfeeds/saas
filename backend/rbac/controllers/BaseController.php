<?php

namespace backend\rbac\controllers;

use backend\rbac\Config;
use yii\web\Controller;
use Yii;

class BaseController extends Controller
{
    //method post
    protected $post;
    //method get
    protected $get;
    //authManager object
    protected static $_authManager;
    //db object
    protected static $_db;
    //cache object
    protected static $_cache;

    /**
     * @describe 访问控制, 初始化基类
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-19
     */
    public function init()
    {
        if (Yii::$app->user->isGuest) {
            $homeUrl = Yii::$app->homeUrl;
            if ($homeUrl == '/' || $homeUrl == null) {
                Yii::$app->setHomeUrl(Config::$loginUrl);
            }

            $this->goHome();
        }

        $this->layout = Config::$layout;
        parent::init();
    }

    /**
     * @describe response
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-06-26
     * @param $massage
     * @param $data
     * @param $code
     * @param $status
     * @return string
     */
    protected function response($massage, $data, $code, $status)
    {
        return json_encode(['data' => $data, 'code' => $code, 'status' => $status, 'message' => $massage]);
    }

    /**
     * @describe beforeAction
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-19
     * @param $action
     * @return bool
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        $request = Yii::$app->getRequest();
        $this->post = $request->bodyParams;
        $this->get = $request->getQueryParams();

        $auth = Yii::$app->getAuthManager();
        self::$_authManager = $auth;

        $db = Yii::$app->get('db');
        self::$_db = $db;

        $cache = Yii::$app->get('cache');
        self::$_cache = $cache;

        return parent::beforeAction($action);
    }
}