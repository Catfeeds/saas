<?php

namespace backend\rbac;

use yii\base\Behavior;
use yii\web\Application;
use yii\web\Controller;
use Yii;

class PermissionBehaviors extends Behavior
{

    private static $_message;
    private static $_response;
    private static $_remove_cache_controllers = ['main', 'auth'];
    private static $_remove_cache_actions = ['create', 'creates', 'del', 'del-item', 'move', 'modify'];

    /**
     * @describe 绑定处理程序
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-03
     * @return array
     */
    public function events()
    {
        self::$_message = json_encode(['status' => 'error', 'data' => [], 'code' => 0, 'message' => '您没权限执行此操作']);
        self::$_response = Yii::$app->getResponse();

        return [
            /* EVENT_BEFORE_REQUEST > EVENT_BEFORE_ACTION > EVENT_AFTER_ACTION > EVENT_AFTER_REQUEST */
            Application::EVENT_AFTER_REQUEST => [$this, 'accessControl'],
            Controller::EVENT_AFTER_ACTION => [$this, 'removeCache'],
        ];
    }

    /**
     * @describe 访问路由控制程序
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-03
     * @param $event
     */
    public function accessControl($event)
    {
        $user = Yii::$app->getUser();
        if (!is_object($user)) {
            return;
        }

        $identify = $user->getIdentity();
        if (!is_object($identify)) {
            return;
        }

        $app = $event->sender;
        $module = $app->controller->module->id;
        $prepare = [Config::$rbacModule, Config::$mainModule];
        if (in_array($module, $prepare)) {
            $controller = $app->controller;
            $route = $controller->id . '/' . $controller->action->id;
            if ($module == Config::$rbacModule) {
                $route = $module . '/' . $route;
            }

            if (in_array($identify->username, Config::$USA) &&
                ($module == Config::$rbacModule ||
                    in_array($route, Config::$rbacModuleRoute))) {
                return;

            }

            $user_per = Yii::$app->user->can($route);
            $is_in = Config::isIn($route);
            if ($user_per || !$is_in) {
                return;
            }

            if (Config::isHtml($route)) {
                self::$_response->redirect(Config::$noAccessRoute);
            } else {
                self::$_response->data = self::$_message;
            }
        }

        return;
    }

    /**
     * @describe 清除用户菜单权限缓存
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-24
     * @param $event
     */
    public function removeCache($event)
    {
        $action_model = $event->action;
        $action = $action_model->id;
        $controller = $action_model->controller->id;
        $module = $action_model->controller->module->id;
        if ($module == Config::$rbacModule &&
            in_array($controller, self::$_remove_cache_controllers) &&
            in_array($action, self::$_remove_cache_actions)) {
            $cache = Yii::$app->getCache();
            //清除所有缓存
            $cache->flush();

        }

        $event->isValid = true;
    }
}