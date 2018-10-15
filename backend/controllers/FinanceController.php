<?php

namespace backend\controllers;

use backend\models\AboutClass;
use backend\models\Employee;
use backend\models\EntryRecord;
use backend\models\MemberCourseOrder;
use backend\models\Order;
use backend\models\MemberCard;
use common\models\Func;
use backend\models\Config;
use moonland\phpexcel\Excel;
use yii\helpers\VarDumper;
use yii\web\Session;

class FinanceController extends \backend\controllers\BaseController
{
    /**
     * 财务管理 - 卡种收入
     * @return string
     * @auther 苏雨
     * @create 2017-8-22
     * @param
     */
    public function actionIndex()
    {
        $session = \Yii::$app->session;
        if ($session->has('cardOrderData')) {
            $session->remove('cardOrderData');
        }
        return $this->render('index');
    }

    /**
     * 云运动 - 财务系统 - 卡种收入列表
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/8/21
     * @return string
     */
    public function actionGetCardOrder()
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        $params = $this->get;
        $model = new Order();
        $order = $model->getCardOrderInfo($params, "hadPay");
        $dataProvider = $model->getCardOrderList($order);
        $pagination = $dataProvider->pagination;
        $pages = Func::getPagesFormat($pagination);
        $data = $model->getCardOrderTotal($order);
        $totalSingle = 0;
        $totalMoney = 0;
        $receiptNum = 0;
        $totalReceiptMoney = 0;

        foreach ($data as $k => $v) {
            $totalSingle += $v['single'];                          //总单数
            $totalMoney += $v['total_price'];                      //总金额
            if ($v['is_receipt'] == 1) {
                $receiptNum += $v['is_receipt'];                   //已开票人数
                $totalReceiptMoney += $v['total_price'];           //总开票金额
            }
        }

        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }

        if (isset($params['isImport']) && $params['isImport']) {
            foreach ($data as $k => $v) {
                $data[$k]['active_time'] = $v['active_time'] == null ? '未激活' : date("Y-m-d", $v['active_time']);
                $data[$k]['invalid_time'] = date("Y-m-d", $v['invalid_time']);
                $data[$k]['pay_money_time'] = date("Y-m-d", $v['pay_money_time']);
                if ($v['note'] == '办卡') {
                    $data[$k]['note'] = '会员卡（发卡）';
                } elseif ($v['note'] == '续费') {
                    $data[$k]['note'] = '会员卡（续费）';
                } else {
                    $data[$k]['note'] = '会员卡（升级）';
                }
            }
            Excel::export([
                'models' => $data,
                'fileName' => '销售',
                'columns' => ['note', 'card_number', 'member_name', 'sell_people_name', 'card_name', 'active_time', 'invalid_time', 'pay_money_time', 'total_price', 'single'],
                'headers' => [
                    'note' => '会员类型',
                    'card_number' => '卡号',
                    'member_name' => '会员姓名',
                    'sell_people_name' => '销售',
                    'card_name' => '卡种',
                    'active_time' => '开始时间',
                    'invalid_time' => '到期时间',
                    'pay_money_time' => '收费日期',
                    'total_price' => '金额',
                    'single' => '单数'
                ]
            ]);
        }
        return json_encode(['data' => $dataProvider->models, 'now' => $nowPage, 'pages' => $pages, 'total_single' => $totalSingle, 'total_money' => $totalMoney, 'receipt_num' => $receiptNum, 'total_receipt_money' => $totalReceiptMoney]);
    }

    /**
     * 云运动 - 财务系统 - 卡种收入列表导出Excel
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/8/21
     * @return string
     */
    public function actionExportCardExcel()
    {
        $session = \Yii::$app->session;
        $data = $session->get('cardOrderData');
        foreach ($data as $k => $v) {
            $data[$k]['active_time'] = $v['active_time'] == null ? '未激活' : date("Y-m-d", $v['active_time']);
            $data[$k]['invalid_time'] = date("Y-m-d", $v['invalid_time']);
            $data[$k]['pay_money_time'] = date("Y-m-d", $v['pay_money_time']);
            if ($v['note'] == '办卡') {
                $data[$k]['note'] = '会员卡（发卡）';
            } elseif ($v['note'] == '续费') {
                $data[$k]['note'] = '会员卡（续费）';
            } else {
                $data[$k]['note'] = '会员卡（升级）';
            }
        }
        Excel::export([
            'models' => $data,
            'fileName' => '销售',
            'columns' => ['note', 'card_number', 'member_name', 'sell_people_name', 'card_name', 'active_time', 'invalid_time', 'pay_money_time', 'total_price', 'single'],
            'headers' => [
                'note' => '会员类型',
                'card_number' => '卡号',
                'member_name' => '会员姓名',
                'sell_people_name' => '销售',
                'card_name' => '卡种',
                'active_time' => '开始时间',
                'invalid_time' => '到期时间',
                'pay_money_time' => '收费日期',
                'total_price' => '金额',
                'single' => '单数'
            ]
        ]);
    }

    /**
     * 云运动 - 财务系统 - 卡种收入订单详情
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/8/21
     * @return string
     */
    public function actionGetOrderDetail()
    {
        $id = \Yii::$app->request->get('id');
        if (!empty($id)) {
            $model = new Order();
            $OrderData = $model->getOrderData($id);
            return json_encode($OrderData);
        } else {
            return false;
        }
    }

    /**
     * 云运动 - 财务系统 - 开票操作
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/8/21
     * @return string
     */
    public function actionReceipt()
    {
        $id = \Yii::$app->request->get('id');
        $model = new Order();
        $data = $model->setOrderIsReceipt($id);
        if ($data) {
            return json_encode(['status' => 'success', 'data' => $data]);
        } else {
            return json_encode(['status' => 'error']);
        }
    }

    /**
     * 财务管理 - 分摊收入
     * @return string
     * @auther 苏雨
     * @create 2017-8-22
     * @param
     */
    public function actionShare()
    {
        return $this->render('share');
    }

    /**
     * 财务管理 - 上课收入
     * @return string
     * @auther 苏雨
     * @create 2017-8-22
     * @param
     */
    public function actionClass()
    {
        $session = \Yii::$app->session;
        if ($session->has('tokenClass')) {
            $session->remove('tokenClass');
        }
        if ($session->has('classParams')) {
            $session->remove('classParams');
        }
        return $this->render('class');
    }

    /**
     * 财务管理 - 卖课收入
     * @return string
     * @auther 苏雨
     * @create 2017-8-22
     * @param
     */
    public function actionSell()
    {
        $session = \Yii::$app->session;
        if ($session->has('sellData')) {
            $session->remove('sellData');
        }
        //$session->set('sellData', $data);
        return $this->render('sell');
    }

    /**
     * 财务管理 - 其他收入
     * @return string
     * @auther 苏雨
     * @create 2017-8-22
     * @param
     */
    public function actionOther()
    {
        return $this->render('other');
    }

    /* 云运动 - 财务系统 - 分摊收入列表
    * @author 焦冰洋 <jiaobingyang@itsports.club>
    * @create 2017/8/22
    * @return string
    */
    public function actionGetShareMoney()
    {
        $params = \Yii::$app->request->queryParams;
//        $session      = \Yii::$app->session;
        $model = new Order();
        $order = $model->getShareInfo($params);
        $dataProvider = $model->getShareInfoList($order);
        $dataList = $dataProvider->models;
        $pagination = $dataProvider->pagination;
        $pages = Func::getPagesFormat($pagination);
        $data = $model->getShareInfoTotal($order);

        $startTime = strtotime($params['startTime']);
        $endTime = strtotime($params['endTime']);
        if (!$startTime && !$endTime) {
            $endTime = time();
        }

        foreach ($dataList as $k => $v) {
            //排除未付款的卡
            if ($v['order_status'] == 2) {
                //排除未激活的卡
                if ($v['status'] !== 4) {
                    //做出卡类型的判断后计算分摊收入     category_type_id
                    //1、时间卡 2、次卡  3、充值卡 4、混合卡
                    if ($v['category_type_id'] == 1) {    //时间卡分摊逻辑:总金额/总天数 * 选定的天数 - 时间区间内请假的每天分摊金额

                        if ($v['leave_status'] == null) {   //没有请假的情况

                            if ($startTime <= $v['active_time']) {
                                if ($v['active_time'] <= $endTime && $endTime <= $v['invalid_time']) {
                                    $time = $endTime - $v['active_time'];
                                } else {
                                    $time = $v['invalid_time'] - $v['active_time'];
                                }
                            } elseif ($v['active_time'] <= $startTime) {
                                if ($endTime <= $v['invalid_time']) {
                                    $time = $endTime - $startTime;
                                } else {
                                    $time = $v['invalid_time'] - $startTime;
                                }
                            }

                        } elseif ($v['leave_status'] == 2) {  //第一种情况：已销假  获取计算分摊金额的天数：这里需要减去请假的天数,有9种情况
                            if ($endTime <= $v['leave_start_time']) {
                                $time = $endTime - $startTime;
                            } elseif ($startTime <= $v['leave_start_time'] && $v['leave_start_time'] <= $endTime && $endTime <= $v['leave_end_time']) {
                                $time = $endTime - $v['leave_start_time'];
                            } elseif ($startTime <= $v['leave_start_time'] && $v['leave_end_time'] <= $endTime && $endTime <= $v['invalid_time']) {
                                $time = ($v['leave_start_time'] - $startTime) + ($endTime - $v['leave_end_time']);
                            } elseif ($startTime <= $v['leave_start_time'] && $v['invalid_time'] <= $endTime) {
                                $time = ($v['leave_start_time'] - $startTime) + ($v['invalid_time'] - $v['leave_end_time']);
                            } elseif ($v['leave_start_time'] <= $startTime && $endTime <= $v['leave_end_time']) {
                                $time = 0;
                            } elseif ($v['leave_start_time'] <= $startTime && $v['leave_end_time'] <= $endTime && $endTime <= $v['invalid_time']) {
                                $time = $endTime - $v['leave_end_time'];
                            } elseif ($v['leave_start_time'] <= $startTime && $v['leave_end_time'] <= $endTime && $v['invalid_time'] <= $endTime) {
                                $time = $v['invalid_time'] - $v['leave_end_time'];
                            } elseif ($v['leave_end_time'] <= $startTime && $endTime <= $v['invalid_time']) {
                                $time = $endTime - $startTime;
                            } elseif ($v['leave_end_time'] <= $startTime && $v['invalid_time'] <= $endTime) {
                                $time = $v['invalid_time'] - $startTime;
                            }

                        } elseif ($v['leave_status'] == 1) {  //第二种情况：未销假 -- 时间区间与交集假期有3种情况

                            if ($endTime <= $v['leave_start_time']) {
                                $time = $endTime - $startTime;
                            } elseif ($startTime <= $v['leave_start_time'] && $v['leave_start_time'] <= $endTime) {
                                $time = $v['leave_start_time'] - $startTime;
                            } else {
                                $time = 0;
                            }
                        }
                        //1、计算每天分摊金额
                        if (json_decode($v['duration'])) {
                            $duration = json_decode($v['duration'])->day;   //卡的有效天数
                            $perDay = $v['total_price'] / $duration;       //每天分摊金额
                        }
                        $days = intval(ceil($time / 86400));
                        $dataList[$k]['share'] = round($perDay * $days, 2);

                    } elseif ($v['category_type_id'] == 2) {     //次卡分摊逻辑：按次数计算分摊金额
                        //第一步：计算每次分摊金额
                        $totalTimes = $v['total_times'];
                        if ($totalTimes != 0) {
                            $perTime = $v['total_price'] / $totalTimes;
                        }
                        //第二步：时间段内计算进馆次数
                        $records = EntryRecord::find()
                            ->where(['member_id' => $v['member_id']])
                            ->andWhere(['and', ['>=', 'entry_time', $startTime], ['<=', 'entry_time', $endTime]])
                            ->count();
                        //第三步：计算分摊金额
                        if (isset($perTime) && !empty($perTime)) {
                            $dataList[$k]['share'] = round($perTime * $records, 2);
                        }

                    } elseif ($v['category_type_id'] == 3) {   //充值卡分摊逻辑：待议

                    } else {    //混合卡分摊逻辑：待议

                    }
                }
            }
        }

        foreach ($data as $k => $v) {
            //排除未付款的卡
            if ($v['order_status'] == 2) {
                //排除未激活的卡
                if ($v['status'] !== 4) {
                    //做出卡类型的判断后计算分摊收入     category_type_id
                    //1、时间卡 2、次卡  3、充值卡 4、混合卡
                    if ($v['category_type_id'] == 1) {    //时间卡分摊逻辑:总金额/总天数 * 选定的天数 - 时间区间内请假的每天分摊金额

                        if ($v['leave_status'] == null) {   //没有请假的情况

                            if ($startTime <= $v['active_time']) {
                                if ($v['active_time'] <= $endTime && $endTime <= $v['invalid_time']) {
                                    $time = $endTime - $v['active_time'];
                                } else {
                                    $time = $v['invalid_time'] - $v['active_time'];
                                }
                            } elseif ($v['active_time'] <= $startTime) {
                                if ($endTime <= $v['invalid_time']) {
                                    $time = $endTime - $startTime;
                                } else {
                                    $time = $v['invalid_time'] - $startTime;
                                }
                            }

                        } elseif ($v['leave_status'] == 2) {  //第一种情况：已销假  获取计算分摊金额的天数：这里需要减去请假的天数,有9种情况
                            if ($endTime <= $v['leave_start_time']) {
                                $time = $endTime - $startTime;
                            } elseif ($startTime <= $v['leave_start_time'] && $v['leave_start_time'] <= $endTime && $endTime <= $v['leave_end_time']) {
                                $time = $endTime - $v['leave_start_time'];
                            } elseif ($startTime <= $v['leave_start_time'] && $v['leave_end_time'] <= $endTime && $endTime <= $v['invalid_time']) {
                                $time = ($v['leave_start_time'] - $startTime) + ($endTime - $v['leave_end_time']);
                            } elseif ($startTime <= $v['leave_start_time'] && $v['invalid_time'] <= $endTime) {
                                $time = ($v['leave_start_time'] - $startTime) + ($v['invalid_time'] - $v['leave_end_time']);
                            } elseif ($v['leave_start_time'] <= $startTime && $endTime <= $v['leave_end_time']) {
                                $time = 0;
                            } elseif ($v['leave_start_time'] <= $startTime && $v['leave_end_time'] <= $endTime && $endTime <= $v['invalid_time']) {
                                $time = $endTime - $v['leave_end_time'];
                            } elseif ($v['leave_start_time'] <= $startTime && $v['leave_end_time'] <= $endTime && $v['invalid_time'] <= $endTime) {
                                $time = $v['invalid_time'] - $v['leave_end_time'];
                            } elseif ($v['leave_end_time'] <= $startTime && $endTime <= $v['invalid_time']) {
                                $time = $endTime - $startTime;
                            } elseif ($v['leave_end_time'] <= $startTime && $v['invalid_time'] <= $endTime) {
                                $time = $v['invalid_time'] - $startTime;
                            }

                        } elseif ($v['leave_status'] == 1) {  //第二种情况：未销假 -- 时间区间与交集假期有3种情况

                            if ($endTime <= $v['leave_start_time']) {
                                $time = $endTime - $startTime;
                            } elseif ($startTime <= $v['leave_start_time'] && $v['leave_start_time'] <= $endTime) {
                                $time = $v['leave_start_time'] - $startTime;
                            } else {
                                $time = 0;
                            }
                        }
                        //1、计算每天分摊金额
                        if (json_decode($v['duration'])) {
                            $duration = json_decode($v['duration'])->day;   //卡的有效天数
                            $perDay = $v['total_price'] / $duration;       //每天分摊金额
                        }
                        $days = intval(ceil($time / 86400));
                        $data[$k]['share'] = round($perDay * $days, 2);

                    } elseif ($v['category_type_id'] == 2) {     //次卡分摊逻辑：按次数计算分摊金额
                        //第一步：计算每次分摊金额
                        $totalTimes = $v['total_times'];
                        if ($totalTimes != 0) {
                            $perTime = $v['total_price'] / $totalTimes;
                        }
                        //第二步：时间段内计算进馆次数
                        $records = EntryRecord::find()
                            ->where(['member_id' => $v['member_id']])
                            ->andWhere(['and', ['>=', 'entry_time', $startTime], ['<=', 'entry_time', $endTime]])
                            ->count();
                        //第三步：计算分摊金额
                        if (isset($perTime) && !empty($perTime)) {
                            $data[$k]['share'] = round($perTime * $records, 2);
                        }

                    } elseif ($v['category_type_id'] == 3) {   //充值卡分摊逻辑：待议

                    } else {    //混合卡分摊逻辑：待议

                    }
                }
            }
        }

        $totalShare = array_sum(array_column($data, 'share'));
        //注释原因:没有发现导出按钮,保存session,占用内存,增加处理时间
        //$session->set('shareData', $data);

        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }

        return json_encode(['data' => $dataList, 'now' => $nowPage, 'pages' => $pages, 'total' => $totalShare]);
    }

    /* 云运动 - 财务系统 - Excel导出分摊收入列表
    * @author 焦冰洋 <jiaobingyang@itsports.club>
    * @create 2017/8/22
    * @return string
    */
    public function actionGetShareExcel()
    {
        $session = \Yii::$app->session;
        $data = $session->get('shareData');

        $totalShare = 0;
        foreach ($data as $k => $v) {

            $data[$k]['pay_money_time'] = date("Y-m-d H:i:s", $v['pay_money_time']);

            if (!isset($v['share'])) {
                $data[$k]['share'] = 0;
            }

        }

        foreach ($data as $a => $b) {
            $totalShare += $b['share'];
        }

        $excel = new Excel();

        $tmpdata = array();
        $tmpdata[0] = array('序号', '场馆', '会员姓名', '卡号', '卡种', '总金额(元)', '会籍顾问', '收款人', '缴费日期', '分摊金额(元)');//表头
        $i = 1;
        foreach ($data as $item) {
            $tmpdata[$i] = array($i, $item['venue_name'], $item['member_name'], $item['card_number'], $item['card_name'], $item['total_price'], $item['sell_people_name'], $item['payee_name'], $item['pay_money_time'], $item['share']);
            $tmpdata[$i + 1] = array('总分摊金额', $totalShare . '元');
            $i++;
        }
        $data = $tmpdata;

        $excel->download($data, '分摊收入统计表');

    }


    /* 云运动 - 财务系统 - 卖课收入列表
    * @author 焦冰洋 <jiaobingyang@itsports.club>
    * @create 2017/8/25
    * @return string
    */
    public function actionGetSellClass()
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        $params = \Yii::$app->request->queryParams;
//        $session      = \Yii::$app->session;
        $model = new Order();
        $order = $model->getSellClassInfo($params);
        $dataProvider = $model->getSellClassInfoList($order);
        $dataList = $dataProvider->models;

        foreach ($dataList as $k => $v) {
            $dataList[$k]['unit_price'] = round($v['unit_price'], 2);
            if (empty($v['card_number'])) {
                $card = MemberCard::find()->where(['member_id' => $v['mem_id']])->orderBy('create_at DESC')->one();
                $dataList[$k]['card_number'] = $card['card_number'];
            }
        }

        $pagination = $dataProvider->pagination;
        $pages = Func::getPagesFormat($pagination);
        $data = $model->getSellClassInfoTotal($order);

        foreach ($data as $k => $v) {
            if (empty($v['card_number'])) {
                $card = MemberCard::find()->where(['member_id' => $v['mem_id']])->orderBy('create_at DESC')->one();
                $data[$k]['card_number'] = $card['card_number'];
            }
        }
//        $session->set('sellData', $data);

        $totalMoney = 0;
        $totalClass = 0;
        $overageNum = 0;
        foreach ($data as $k => $v) {
            $totalMoney += $v['money_amount'];
            $totalClass += $v['course_amount'];
            $overageNum += $v['overage_num'];
        }

        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        if (isset($params['isImport']) && $params['isImport']) {
            foreach ($data as $k => $v) {
                $data[$k]['pay_money_time'] = date("Y-m-d", $v['pay_money_time']);
            }
            Excel::export([
                'models' => $data,
                'fileName' => '私教',
                'columns' => ['card_number', 'member_name', 'product_name', 'employeeName', 'course_amount', 'unit_price', 'pay_money_time', 'money_amount'],
                'headers' => [
                    'card_number' => '会员卡号',
                    'member_name' => '会员姓名',
                    'product_name' => '私教类别',
                    'employeeName' => '私教',
                    'course_amount' => '次数',
                    'unit_price' => '课时费',
                    'pay_money_time' => '交费日期',
                    'money_amount' => '金额',
                ]
            ]);
        }
        return json_encode(['data' => $dataList, 'now' => $nowPage, 'pages' => $pages, 'total_class' => $totalClass, 'total_money' => $totalMoney, 'overageNum' => $overageNum]);
    }

    /* 云运动 - 财务系统 - 卖课收入列表
    * @author 焦冰洋 <jiaobingyang@itsports.club>
    * @create 2017/8/25
    * @return string
    */
    public function actionExportSellExcel()
    {
        $session = \Yii::$app->session;
        $data = $session->get('sellData');
        foreach ($data as $k => $v) {
            $data[$k]['pay_money_time'] = date("Y-m-d", $v['pay_money_time']);
        }
        Excel::export([
            'models' => $data,
            'fileName' => '私教',
            'columns' => ['card_number', 'member_name', 'product_name', 'employeeName', 'course_amount', 'unit_price', 'pay_money_time', 'money_amount'],
            'headers' => [
                'card_number' => '会员卡号',
                'member_name' => '会员姓名',
                'product_name' => '私教类别',
                'employeeName' => '私教',
                'course_amount' => '次数',
                'unit_price' => '课时费',
                'pay_money_time' => '交费日期',
                'money_amount' => '金额',
            ]
        ]);


    }

    /* 云运动 - 财务系统 - 上课收入列表
    * @author 焦冰洋 <jiaobingyang@itsports.club>
    * @create 2017/8/28
    * @return string
    */
    public function actionGetTokenClass()
    {
        set_time_limit(0);
        ini_set('memory_limit', '2048M');
        $params = \Yii::$app->request->queryParams;
//        $session       =  \Yii::$app->session;
        $model = new Employee();
        $privates = $model->getPrivates($params);
        $dataProvider = $model->getPrivatesList($privates);
        $pagination = $dataProvider->pagination;
        $pages = Func::getPagesFormat($pagination);
        $data = $dataProvider->models;
        $dataAll = $model->getPrivatesTotal($privates);
//        $session->set('tokenClass', $dataAll);
//        $session->set('classParams',$params);
//        Func::setCacheData('tokenClass',$dataAll);
//        Func::setCacheData('classParams',$params);

        foreach ($data as $k => $v) {
            $data[$k]['token_money'] = round($v['token_money'], 2);
        }

        $totalNum = array_sum(array_column($dataAll, 'token_num'));
        $totalMoney = round(array_sum(array_column($dataAll, 'token_money')), 2);
        $totalLeftMoney = round(array_sum(array_column($dataAll, 'left_money')), 2);

        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        if (isset($params['isImport']) && $params['isImport']) {
            $coachArr = [];
            foreach ($dataAll as $k1 => $v1) {
                $coachArr[$k1]['id'] = $v1['id'];
                $coachArr[$k1]['coachName'] = $v1['name'];
            }
            $newParams = [];
            $newParams['startTime'] = $params['startTime'];
            $newParams['endTime'] = $params['endTime'];
            $newParams['type'] = $params['type'];
            $coachArr = [];
            foreach ($dataAll as $k1 => $v1) {
                $coachArr[$k1]['id'] = $v1['id'];
                $coachArr[$k1]['coachName'] = $v1['name'];
            }
            $dataArr = [];
            foreach ($coachArr as $k2 => $v2) {
                $data = $this->aboutClassForCoach($v2['id'], $newParams);
                if ($data) {
                    foreach ($data as $k3 => $v3) {
                        if (isset($v3['type'])) {
                            switch ($v3['type']) {
                                case 1 :
                                    $type = 'PT';
                                    break;
                                case 2 :
                                    $type = 'HS';
                                    break;
                                case 3 :
                                    $type = '生日课';
                                    break;
                            }
                        } else {
                            $type = '暂无数据';
                        }
                        if (empty($v3['singlePrice'])) {
                            $v3['singlePrice'] = 0;
                        }
                        $v3['singlePrice'] = round($v3['singlePrice'], 2);
                        $v3['token_money'] = round($v3['singlePrice'], 2) * (int)$v3['num'];
                        $v3['courseType'] = $type;
                        $dataArr[] = $v3;
                    }
                }
            }
            Excel::export([
                'models' => $dataArr,
                'fileName' => '上课收入记录',
                'columns' => ['card_number', 'username', 'course_name', 'coachName', 'courseType', 'singlePrice', 'num', 'token_money'],
                'headers' => [
                    'card_number' => '会员卡号',
                    'username' => '会员姓名',
                    'course_name' => '私教类别',
                    'coachName' => '私教',
                    'courseType' => '课程类型',
                    'singlePrice' => '课时费',
                    'num' => '上课数量',
                    'token_money' => '课程金额',
                ]
            ]);
        }
        return json_encode(['data' => $data, 'now' => $nowPage, 'pages' => $pages, 'total_num' => $totalNum, 'total_money' => $totalMoney, 'total_left_money' => $totalLeftMoney]);

    }

    /* 云运动 - 财务系统 - 上课收入列表导出Excel
    * @author 焦冰洋 <jiaobingyang@itsports.club>
    * @create 2017/9/2
    * @return string
    */
    public function actionGetTokenExcel()
    {
        $session = \Yii::$app->session;
        $data = $session->get('tokenClass');
//        $data = Func::getCacheData('tokenClass');
        $totalNum = 0;
        $totalMoney = 0;
        $totalLeftMoney = 0;
        foreach ($data as $k => $v) {
            $totalNum += $v['token_num'];
            $totalMoney += $v['token_money'];
            $totalLeftMoney += $v['left_money'];
        }

        $excel = new Excel();

        $tmpdata = array();
        $tmpdata[0] = array('序号', '场馆', '私教', '上课节数', '上课金额');//表头
        $i = 1;
        foreach ($data as $item) {
            $tmpdata[$i] = array($i, $item['venue_name'], $item['name'], $item['token_num'], $item['token_money']);
            $tmpdata[$i + 1] = array('总节数', $totalNum . '节');
            $tmpdata[$i + 2] = array('总上课金额', $totalMoney . '元');
            $tmpdata[$i + 3] = array('总剩余金额', $totalLeftMoney . '元');
            $i++;
        }
        $data = $tmpdata;

        $excel->download($data, '上课收入统计表');

    }


    /**
     * @云运动 - 财务管理 - 教练上课记录
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/8/31
     * @return string
     */
    public function actionGetCoachClass()
    {
        $params = \Yii::$app->request->queryParams;
        if (!empty($params['id'])) {
            $model = new AboutClass();
            $class = $model->getCoach($params);
            $dataProvider = $model->getClassList($class);
            $pagination = $dataProvider->pagination;
            $pages = Func::getPagesFormat($pagination, 'coachClass');
            $dataList = $dataProvider->models;          //返回的数据用于列表
            $dataTotal = $model->getClassTotal($class);

            //上课金额取两位小数
            foreach ($dataList as $k => $v) {
                $dataList[$k]['token_money'] = round($v['token_money'], 2);
            }

            $totalTokenClass = array_sum(array_column($dataTotal, 'token_num'));
            $totalTokenMoney = round(array_sum(array_column($dataTotal, 'token_money')), 2);

            if (isset($params['page'])) {
                $nowPage = $params['page'];
            } else {
                $nowPage = 1;
            }

            return json_encode(['data' => $dataList, 'now' => $nowPage, 'pages' => $pages, 'total_num' => $totalTokenClass, 'total_money' => $totalTokenMoney]);

        } else {
            return false;
        }

    }

    /**
     * @desc: 财务管理-上课收入-Excel导出数据
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/01/27
     */
    public function actionGetClassExcel()
    {
        $session = new Session();
        $data = $session->get('tokenClass');
        $params = $session->get('classParams');
//        $data = Func::getCacheData('tokenClass');
//        $params = Func::getCacheData('classParams');
        $coachArr = [];
        foreach ($data as $k1 => $v1) {
            $coachArr[$k1]['id'] = $v1['id'];
            $coachArr[$k1]['coachName'] = $v1['name'];
        }
        $newParams = [];
        $newParams['startTime'] = $params['startTime'];
        $newParams['endTime'] = $params['endTime'];
        $newParams['type'] = $params['type'];
        $coachArr = [];
        foreach ($data as $k1 => $v1) {
            $coachArr[$k1]['id'] = $v1['id'];
            $coachArr[$k1]['coachName'] = $v1['name'];
        }
        $dataArr = [];
        foreach ($coachArr as $k2 => $v2) {
            $data = $this->aboutClassForCoach($v2['id'], $newParams);
            if ($data) {
                foreach ($data as $k3 => $v3) {
                    if (isset($v3['type'])) {
                        switch ($v3['type']) {
                            case 1 :
                                $type = 'PT';
                                break;
                            case 2 :
                                $type = 'HS';
                                break;
                            case 3 :
                                $type = '生日课';
                                break;
                        }
                    } else {
                        $type = '暂无数据';
                    }
                    if (empty($v3['singlePrice'])) {
                        $v3['singlePrice'] = 0;
                    }
                    $v3['singlePrice'] = round($v3['singlePrice'], 2);
                    $v3['token_money'] = round($v3['singlePrice'], 2) * (int)$v3['num'];
                    $v3['courseType'] = $type;
                    $dataArr[] = $v3;
                }
            }
        }
        Excel::export([
            'models' => $dataArr,
            'fileName' => '上课收入记录',
            'columns' => ['card_number', 'username', 'course_name', 'coachName', 'courseType', 'singlePrice', 'num', 'token_money'],
            'headers' => [
                'card_number' => '会员卡号',
                'username' => '会员姓名',
                'course_name' => '私教类别',
                'coachName' => '私教',
                'courseType' => '课程类型',
                'singlePrice' => '课时费',
                'num' => '上课数量',
                'token_money' => '课程金额',
            ]
        ]);
    }

    /**
     * @desc: 根据私教id获取会员上课信息
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/06
     * @param $coachId
     * @param $newParams
     * @return array|bool|\yii\db\ActiveRecord[]
     */
    private function aboutClassForCoach($coachId, $newParams)
    {
        if (isset($coachId)) {
            $model = new AboutClass();
            $class = $model->getCoachClass($coachId, $newParams);
            return $class;
        } else {
            return false;
        }
    }

    /**
     * @云运动 - 财务管理 - 其他收入:暂时统计租柜和转卡收入
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/8/31
     * @return string
     */
    public function actionGetOtherIncome()
    {
        $params = $this->get;
        $model = new Order();
        $order = $model->getOtherInfo($params);
        $dataProvider = $model->getOtherList($order);
        $pagination = $dataProvider->pagination;
        $pages = Func::getPagesFormat($pagination);
        $dataList = $dataProvider->models;
        $dataAll = $model->getOtherTotal($order);

        $totalMoney = array_sum(array_column($dataAll, 'total_price'));

        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }

        return json_encode(['data' => $dataList, 'now' => $nowPage, 'pages' => $pages, 'total_money' => $totalMoney]);

    }

    /**
     * @云运动 - 财务管理 - 其他收入Excel
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/9/2
     * @return string
     */
    public function actionGetOtherExcel()
    {
        $session = \Yii::$app->session;
        $data = $session->get('OtherData');
        $totalMoney = array_sum(array_column($data, 'total_price'));

        foreach ($data as $k => $v) {

            $data[$k]['pay_money_time'] = date("Y-m-d H:i:s", $v['pay_money_time']);

            if ($v['pay_money_mode'] == 1) {
                $data[$k]['pay_money_mode'] = '现金';
            } elseif ($v['pay_money_mode'] == 2) {
                $data[$k]['pay_money_mode'] = '支付宝';
            } elseif ($v['pay_money_mode'] == 3) {
                $data[$k]['pay_money_mode'] = '微信';
            } else {
                $data[$k]['pay_money_mode'] = 'pos机刷卡';
            }
        }

        $excel = new Excel();

        $tmpdata = array();
        $tmpdata[0] = array('序号', '场馆', '订单编号', '购买人', '业务行为', '价格', '缴费方式', '售卖人', '收款人', '缴费时间');//表头
        $i = 1;
        foreach ($data as $item) {
            $tmpdata[$i] = array($i, $item['venue_name'], $item['order_number'], $item['pay_people_name'], $item['note'], $item['total_price'], $item['pay_money_mode'], $item['sell_people_name'], $item['payee_name'], $item['pay_money_time']);
            $tmpdata[$i + 1] = array('总金额', $totalMoney . '元');
            $i++;
        }
        $data = $tmpdata;

        $excel->download($data, '其他收入统计表');

    }

    /**
     * @云运动 - 财务管理 - 卖课收入 - 渠道下拉框接口
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/9/2
     * @return string
     */
    public function actionGetSource($configType = 'charge')
    {
        $id = \Yii::$app->request->get('venueId');
        $model = new Config();
        if ($id != null && $id != '') {
            $data = $model->getMemberConfig($id, $configType);
            return json_encode($data);
        }
        $data = $model->getMemberConfig($this->venueId, $configType);

        return json_encode($data);
    }

    /**
     * 云运动 - 财务系统 - 卖课收入订单详情
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/11/21
     * @return string
     */
    public function actionClassOrderDetail()
    {
        $memberCourseOrderId = \Yii::$app->request->get('memberCourseOrderId');
        if (!empty($memberCourseOrderId)) {
            $model = new MemberCourseOrder();
            $memberCourseOrderData = $model->getClassOrderData($memberCourseOrderId);
            return json_encode(['data' => $memberCourseOrderData]);
        } else {
            return false;
        }
    }
}
