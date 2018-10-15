<?php

namespace backend\controllers;

use backend\models\Server;
use backend\models\ServerCombo;
use backend\models\ServerPlanDataForm;
use backend\models\ServerUpdateForm;
use common\models\Func;

class ServePlanController extends BaseController
{

    /**
     * 套餐管理 - 套餐首页 - 服务套餐列表
     * @return string
     * @author 程丽明
     * @create 2017-3-24
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 套餐管理 - 服务页面 - 服务页面列表及添加服务模态框
     * @return string
     * @author 程丽明
     * @create 2017-3-24
     */
    public function actionServe()
    {
        return $this->render('serve');
    }

    /**
     * 套餐管理 - 添加课程套餐页面 - 课程套餐表单
     * @return string
     * @author 程丽明
     * @create 2017-3-24
     */
    public function actionAddMeal()
    {
        return $this->render('addSetMeal');
    }

    /**
     * 套餐管理 - 添加服务套餐页面 - 服务套餐表单
     * @return string
     * @author 程丽明
     * @create 2017-3-24
     */
    public function actionAddServe()
    {
        return $this->render('serve');
    }

    /**
     * 云运动 - 后台 - 保存服务套餐
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/4
     * @return string
     */
    public function actionSetServerCombo()
    {
        $post = \Yii::$app->request->post();
        $model = new ServerPlanDataForm();
        $model->setScenario('serverCombo');
        if ($model->load($post, '') && $model->validate()) {
            $save = $model->saveServerData();
            if ($save !== true) {
                return json_encode(['status' => 'error', 'data' => $save]);
            } else {
                return json_encode(['status' => 'success', 'data' => '']);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 云运动 - 后台 - 保存服务套餐
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/4
     * @return string
     */
    public function actionSetServer()
    {
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $post = \Yii::$app->request->post();
        $model = new ServerPlanDataForm();
        $model->setScenario('server');
        if ($model->load($post, '') && $model->validate()) {
            $save = $model->saveServer($companyId, $venueId);
            if ($save !== true) {
                return json_encode(['status' => 'error', 'data' => $save]);
            } else {
                return json_encode(['status' => 'success', 'data' => '添加成功']);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 云运动 - 后台 - 查询服务套餐
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/8
     * @return string  //json字符串
     */
    public function actionGetAllServerCombo()
    {
        $params = \Yii::$app->request->queryParams;           //接收参数
        $params['nowBelongId'] = $this->nowBelongId;
        $params['nowBelongType'] = $this->nowBelongType;
        $model = new ServerCombo();
        $dataProvider = $model->getServerComboInfo($params);        //查询方法
        $pagination = $dataProvider->pagination;                  //处理分页
        $pages = Func::getPagesFormat($pagination);          //处理分页
        return json_encode(['data' => $dataProvider->models, 'pages' => $pages]);
    }

    /**
     * @describe 云运动 - 后台 - 查询服务套餐
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @return string
     * @throws \Exception
     */
    public function actionGetAllServer()
    {
        $params = $this->get;           //接收参数
        $model = new Server();
        $dataProvider = $model->getServerInfo($params);        //查询方法
        $pagination = $dataProvider->pagination;                  //处理分页
        $pages = Func::getPagesFormat($pagination);          //处理分页

        return json_encode(['data' => $dataProvider->models, 'pages' => $pages]);
    }

    /**
     * @describe 云运动 - 后台 - 删除指定服务套餐
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @return string
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionDelServerInfo()
    {
        $get = $this->get;
        $id = null;
        if (!empty($get)) {
            $id = $get['id'];
        }

        $model = new ServerCombo();
        $data = $model->delAllServerInfo($id);
        if ($data === true) {
            return json_encode(['status' => 'success']);
        } else {
            return json_encode(['status' => 'error']);
        }
    }

    /**
     * 云运动 - 后台 - 删除指定服务
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/8
     * @return string
     */
    public function actionDelServer()
    {
        $id = \Yii::$app->request->get('id');
        $model = new Server();
        $data = $model->delServerOne($id);
        if ($data === true) {
            return json_encode(['status' => 'success']);
        } else {
            return json_encode(['status' => 'error']);
        }
    }

    /**
     * 云运动 - 后台 - 删除指定服务
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/5/8
     * @return string
     */
    public function actionGetServerOne()
    {
        $id = \Yii::$app->request->get('id');
        $model = new Server();
        $data = $model->getServerOne($id);
        return json_encode($data);
    }

    /**
     * 云运动 - 后台 - 修改服务名字
     * @author houkaixin <lihuien@itsports.club>
     * @create 2017/5/12
     * @return string
     */
    public function actionUpdateServer()
    {
        $post = \Yii::$app->request->post();
        $model = new ServerUpdateForm();
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->updateServer();
            if ($result) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }

    }


}
