<?php

namespace backend\controllers;

use Yii;
use common\models\Func;
use backend\models\LeaveRecord;
use backend\models\SpecialForm;
use backend\models\CardCategory;

class SpecialLeaveController extends BaseController
{

    /**
     * content :特殊请假管理首页页面控制器
     * author : 程丽明
     * date :2017-8-24 15:20
     * */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @describe 后台请假管理 - 特殊请假列表数据查询 - angularJs访问该控制器
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-08-01
     * @return string
     * @throws \Exception
     */
    public function actionLeaveInfo()
    {
        $params = $this->get;
        $model = new LeaveRecord();
        $leaveInfo = $model->SpecialLeave($params);
        $pagination = $leaveInfo->pagination;
        $pages = Func::getPagesFormat($pagination);

        return json_encode(['data' => $leaveInfo->models, 'pages' => $pages]);
    }

    /**
     *后台请假管理 - 特殊请假列表 - 批准状态修改
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/25
     * @return bool|string
     */
    public function actionUpdateStatus()
    {
        $id = \Yii::$app->request->get('id');
        $status = LeaveRecord::getUpdateLeaveRecord($id);

        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }
    }

    /**
     *请假管理 - 特殊请假列表 - 批量审核
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/11
     * @return bool|string
     */
    public function actionBatchUpdateStatus()
    {
        $idArr = \Yii::$app->request->get('idArr');
        $status = LeaveRecord::batchUpdateStatus($idArr);
        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '操作成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '操作失败']);
        }
    }

    /**
     *后台请假管理 - 会员特殊请假 - 请假撤销
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/25
     * @return bool|string
     */
    public function actionLeaveRevocation()
    {
        $LeaveId = Yii::$app->request->get('id');
        $model = new LeaveRecord();
        $delRes = $model->getLeaveDel($LeaveId);
        if ($delRes) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     *后台请假管理 - 会员特殊请假 - 不同意请假
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/25
     * @return bool|string
     */
    public function actionUpdateLeave()
    {
        $post = \Yii::$app->request->post();
        $model = new SpecialForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->updateData();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'success', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台请假管理 - 会员特殊请假 - 已拒绝详情
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/25
     * @return bool|string
     */
    public function actionLeaveDetails()
    {
        $id = Yii::$app->request->get('id');
        if (!empty($id)) {
            $model = new LeaveRecord();
            $LeaveData = $model->getLeaveModel($id);
            return json_encode($LeaveData);
        } else {
            return false;
        }
    }

    /**
     * 云运动 - 请假管理 - 搜索框获取所有卡种名
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/19
     */
    public function actionGetCardCategory()
    {
        $model = new CardCategory();
        $type = $model->getLeaveCardData();

        return json_encode(['type' => $type]);
    }

}
