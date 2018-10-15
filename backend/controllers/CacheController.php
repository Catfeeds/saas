<?php
namespace backend\controllers;

use Yii;


class CacheController extends BaseController
{
    /**
     * 缓存接口 - 清空所有缓存
     *
     * @author huomingzhi@itsports.club
     * @create 2017-8-1 16:00
     */
    public function actionCacheFlush()
    {
        $session = \Yii::$app->session;
        $session->removeAll();
        $session->destroy();
//        Yii::$app->cache->flush();
    }
}