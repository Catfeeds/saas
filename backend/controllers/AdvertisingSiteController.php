<?php

namespace backend\controllers;

use backend\models\AdvertisingForm;
use backend\models\Advertising;
use backend\modules\v1\models\Organization;
use backend\rbac\models\AuthRoleChildModel;
use common\models\Func;

class AdvertisingSiteController extends BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @desc: 业务后台 - 广告启动页 - 新增广告&&备注
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return string
     */
    public function actionAdd()
    {
        $post = $this->post;
        $post['companyId'] = $this->companyIds;
        $model = new AdvertisingForm(['scenario' => 'add']);
        $role_child = AuthRoleChildModel::findOne(self::$_userId);
        $role_id = $role_child ? $role_child->role_id : 0;
        $post['roleId'] = $role_id;
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->add();
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '添加成功']);
            } elseif ($result == 'no') {
                return json_encode(['status' => 'error', 'data' => '管理员不能添加']);
            } else {
                return json_encode(['status' => 'error', 'data' => '添加失败']);
            }
        }

        return json_encode(['status' => 'error', 'data' => '添加失败']);
    }

    /**
     * @desc: 业务后台 - 广告启动页 - 编辑
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionEdit()
    {
        $post = $this->post;
        $post['companyId'] = $this->companyId;
        $model = new AdvertisingForm();
        $model->setScenario('edit');
        $role_child = AuthRoleChildModel::findOne(self::$_userId);
        $role_id = $role_child ? $role_child->role_id : 0;
        $post['roleId'] = $role_id;
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->edit();
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '编辑成功']);
            } elseif ($result == 'no') {
                return json_encode(['status' => 'error', 'data' => '管理员不能编辑']);
            }
            return json_encode(['status' => 'error', 'data' => $result]);
        }
        return json_encode(['status' => 'error', 'data' => '编辑失败']);
    }

    /**
     * @desc: 业务后台 - 广告 - 列表
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return string
     * @throws \Exception
     */
    public function actionList()
    {
        $params = $this->get;
        $params['companyId'] = $this->companyIds;
        $model = new Advertising();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        $obj = $model->search($params);
        $pagination = $obj->pagination;
        $pages = Func::getPagesFormat($pagination);
        return json_encode(["data" => $obj->models, 'pages' => $pages, 'now' => $nowPage]);
    }

    /**
     * @desc: 业务后台 - 广告启动页 - 获取广告启动页配置
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return string
     */
    public function actionSetting()
    {
        $data = Advertising::setting($this->companyIds);

        return json_encode($data);
    }

    /**
     * @desc: 业务后台 - 获取广告详情
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return mixed
     */
    public function actionDetail()
    {
        $id = \Yii::$app->request->get('id');
        $data = Advertising::detail($id);
        return json_encode($data);
    }

    /**
     * @desc: 业务后台 - 广告删除 - 删除广告&&统计记录
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return string
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete()
    {
        $id = \Yii::$app->request->get('id');
        $result = Advertising::deleteAdv($id);
        if ($result == 'noData') {
            return json_encode(['status' => 'error', 'message' => '数据不存在']);
        } elseif ($result == 'error') {
            return json_encode(['status' => 'error', 'message' => '启用中,无法删除']);
        } else {
            return json_encode(['status' => 'success', 'message' => '删除成功']);
        }

    }

    /**
     * @desc: 业务后台 - 广告设置 - 启用单条广告
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return string
     */
    public function actionRun()
    {
        $id = \Yii::$app->request->get('id');
        $result = Advertising::run($id, $this->companyId);
        if ($result == 'noData') {
            return json_encode(['status' => 'error', 'message' => '无此信息']);
        } elseif ($result == 'run') {
            return json_encode(['status' => 'error', 'message' => '已启用,请勿重复启用']);
        } elseif ($result == 'noSet') {
            return json_encode(['status' => 'error', 'message' => '没有设置广告配置']);
        } elseif ($result == 'noGo') {
            return json_encode(['status' => 'error', 'message' => '没有启用广告页']);
        } elseif ($result == 'repeat') {
            return json_encode(['status' => 'error', 'message' => '存在场馆同时间段内重复启用,请重试']);
        } elseif ($result == 'success') {
            return json_encode(['status' => 'success', 'message' => '启用成功']);
        } else {
            return json_encode(['status' => 'error', 'message' => '启用失败']);
        }
    }

    /**
     * @desc: 业务后台 - 广告 - 停用
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return string
     */
    public function actionStop()
    {
        $id = \Yii::$app->request->get('id');
        $result = Advertising::stop($id);
        if ($result) {
            return json_encode(['status' => 'success', 'message' => '停用成功']);
        }
        return json_encode(['status' => 'error', 'message' => '停用失败']);
    }

    /**
     * @desc: 业务后台 - 开关 - 是否开启启动页广告
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return string
     */
    public function actionSet()
    {
        $id = \Yii::$app->request->get('id');
        $status = \Yii::$app->request->get('status');
        $result = Advertising::set($id, $status);
        if ($result) {
            if ($status == 0) {
                return json_encode(['status' => 'success', 'message' => '启用启动页广告成功']);
            } elseif ($status == 1) {
                return json_encode(['status' => 'success', 'message' => '关闭启动页广告成功']);
            } else {
                return json_encode(['status' => 'error', 'message' => '操作失败']);
            }
        }
        return json_encode(['status' => 'error', 'message' => '操作失败']);
    }

    /**
     * @desc: 业务后台 - 获取广告统计记录
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return string
     */
    public function actionRecord()
    {
        $id = \Yii::$app->request->get('id');
        $data = Advertising::record($id);
        return json_encode($data);
    }

    /**
     * @desc: 业务后台 - 获取所有场馆
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return string
     */
    public function actionVenue()
    {
        $venueId = Organization::find()->select('id,name')->where(['and', ['style' => 2], ['is_allowed_join' => 1]])->andFilterWhere(['pid' => $this->companyId])->asArray()->all();
        array_unshift($venueId, array('id' => '0', 'name' => '所有场馆'));

        return json_encode($venueId);
    }
}
