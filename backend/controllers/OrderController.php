<?php

namespace backend\controllers;

use backend\models\Employee;
use backend\models\Order;
use backend\models\Organization;
use moonland\phpexcel\Excel;
use common\models\Func;
use Yii;

class OrderController extends BaseController
{
    /**
     * 订单管理 - 首页 - 列表的展示
     * @return string
     * @auther 梁可可
     * @create 2017-4-21
     * @param
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @desc: 业务后台 -
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create: 2017/5/2
     * @return string
     * @throws \Exception
     */
    public function actionGetOrderData()
    {
        set_time_limit(0);
        ini_set('memory_limit', '300M');
        $params = $this->get;  //接收搜索条件
        $session = Yii::$app->session;
        $model = new Order();
        $query = $model->getOrderInfo($params);
        $session->set('orderParams', $params);                       //保存搜索条件,方便Excel导出
        $data = $model->getSumData($query);
        $sum = $model->getSumDataMoney($query);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination);
        return json_encode(['data' => $data->models, 'sum' => $sum, 'pages' => $pages]);
    }

    /**
     * @云运动 - 后台 - 导出订单EXCEL表
     * @author Jiao Bingyang <jiaobingyang@itsports.club>
     * @create 2017/12/8
     * @return string   //查询结果
     */
    public function actionGetOrderExcel()
    {
        set_time_limit(0);
        ini_set('memory_limit', '300M');
        $session = Yii::$app->session;
        $params = $session->get('orderParams');
        $model = new Order();
        $query = $model->getOrderInfo($params);
        $data = $model->getAllData($query);

        foreach ($data as $k => $v) {
            if ($v['status'] == 1) {
                $data[$k]['status'] = '未付款';
            } elseif ($v['status'] == 2) {
                $data[$k]['status'] = '已付款';
            } else {
                $data[$k]['status'] = '已取消';
            }
            $data[$k]['order_number'] = " " . $v['order_number'];
            $data[$k]['order_time'] = date("Y-m-d H:i:s", $v['order_time']);
            $data[$k]['total_price'] = $v['total_price'] == null ? '暂无数据' : $v['total_price'];
            $data[$k]['payee_name'] = $v['payee_name'] == null ? '暂无数据' : $v['payee_name'];
            $data[$k]['sellName'] = $v['sellName'] == null ? '手机端购买' : $v['sellName'];
            $data[$k]['single'] = $v['single'] == null ? '暂无数据' : $v['single'];
            $data[$k]['card_name'] = $v['card_name'] == null ? '暂无数据' : $v['card_name'];
            $data[$k]['card_number'] = $v['card_number'] == null ? '暂无数据' : $v['card_number'];
        }
        Excel::export([
            'models' => $data,
            'fileName' => '订单记录',
            'columns' => ['venue_name', 'order_number', 'pay_people_name', 'card_number', 'note', 'card_name', 'total_price', 'sellName', 'payee_name', 'order_time', 'status', 'single'],
            'headers' => [
                'venue_name' => '售卖场馆',
                'order_number' => '订单编号',
                'pay_people_name' => '购买人',
                'card_number' => '会员卡号',
                'note' => '业务行为',
                'card_name' => '卡种名称',
                'total_price' => '价格',
                'sellName' => '售卖人',
                'payee_name' => '操作人',
                'order_time' => '日期',
                'status' => '订单状态',
                'single' => '销售单数'
            ]
        ]);
    }

    /**
     * @云运动 - 后台 - 订单信息单条数据查询
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/2
     * @return string   //查询结果
     */
    public function actionGetOrderInfo()
    {
        $id = $this->get['id'];
        $model = new Order();
        $data = $model->getOrderOneData($id);

        return json_encode($data);
    }

    /**
     *  @云运动 - 后台 - 修改取消订单的状态
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/3
     * @return string
     */
    public function actionSetOrderStatus()
    {
        $id = $this->get['id'];
        $model = new Order();
        $data = $model->setOrderOneData($id);
        if ($data) {
            return json_encode(['status' => 'success', 'data' => $data]);
        } else {
            return json_encode(['status' => 'error']);
        }
    }

    /**
     * @云运动 - 后台 - 确认订单
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/3
     * @return string
     */
    public function actionOrderPayment()
    {
        $post = $this->post;
        $model = new Order();
        $data = $model->OrderPaymentData($post);
        if ($data) {
            return json_encode(['status' => 'success', 'data' => $data]);
        } else {
            return json_encode(['status' => 'error']);
        }
    }

    /**
     * @后台 - 订单管理 - 申请退款
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/26
     * @return bool
     */
    public function actionApplyRefund()
    {
        $post = $this->post;
        $model = new Order();
        $data = $model->applyRefund($post);
        if ($data === true) {
            return json_encode(['status' => 'success', 'data' => '提交成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $data]);
        }
    }

    /**
     * @后台 - 订单管理 - 拒绝申请
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/27
     * @return bool
     */
    public function actionRefuseApply()
    {
        $post = $this->post;
        $model = new Order();
        $data = $model->refuseApply($post);
        if ($data === true) {
            return json_encode(['status' => 'success', 'data' => '提交成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $data]);
        }
    }

    /**
     * @describe @后台 - 订单管理 - 同意申请
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @return string
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionAgreeApply()
    {
        $get = $this->get;
        $model = new Order();
        $organization = Organization::findOne($get['venueId']);
        if(empty($organization)){
            return json_encode(['status' => 'error', 'data' => '未知场馆']);
        }

        $company_id = $organization->pid;
        $data = $model->agreeApply($get['orderId'], $get['venueId'], $company_id);
        if ($data === true) {
            return json_encode(['status' => 'success', 'data' => '提交成功']);
        }

        return json_encode(['status' => 'error', 'data' => $data]);
    }

    /**
     *后台订单管理 - 订单基本信息- 删除
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/11/27
     * @return bool|string
     */
    public function actionDeletingOrder()
    {
        $orderId = $this->get['orderId'];
        $model = new Order();
        $delRes = $model->getOrderDel($orderId);
        if ($delRes) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     * @后台 - 场馆 - 获取场馆
     * @author houkaixin<houkaixin@itsports.club>
     * @create 2017/11/28
     * @return bool
     */
    public function actionGainAllVenue()
    {
        return json_encode(["data" => $this->getCompaniesAndVenues('venue')]);
    }

    /**
     * @后台 - 场馆 - 获取指定场馆下 指定部门的员工
     * @author houkaixin<houkaixin@itsports.club>
     * @create 2017/11/28
     * @return bool
     */
    public function actionEmployee()
    {
        $model = new Employee();
        $data = $model->gainDepEmployee($this->companyId);
        return json_encode(["data" => $data]);
    }

    /**
     * @后台 - 修改指定的订单
     * @author houkaixin<houkaixin@itsports.club>
     * @create 2017/11/28
     * @return bool
     */
    public function actionUpdateOrder()
    {
        $param = $this->post;
        $model = new Order();
        $result = $model->updateOrder($param);
        if ($result === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        }
        return json_encode(['status' => 'error', 'data' => $result]);
    }

    /**
     * @后台 - 修改指定的订单售卖人
     * @author houkaixin<houkaixin@itsports.club>
     * @create 2017/11/28
     * @return bool
     */
    public function actionUpdateOrderSellPeople()
    {
        $param = $this->post;
        $order = \common\models\base\Order::findOne($param["orderId"]);
        if (!empty($order->sell_people_name) && $order->sell_people_name != NULL) {
            return json_encode(['status' => 'onlyone', 'data' => '不能修改']);
        }
        $model = new Order();
        $result = $model->updateOrderSellPeople($param);
        if ($result === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        }
        return json_encode(['status' => 'error', 'data' => $result]);
    }
}
