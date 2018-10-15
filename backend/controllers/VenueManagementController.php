<?php

namespace backend\controllers;

use backend\models\ClassRoom;
use backend\models\ClassRoomForm;
use backend\models\GroupClass;
use backend\models\Organization;
use backend\models\Seat;
use backend\models\SeatForm;
use backend\models\SeatType;
use common\models\Func;


class VenueManagementController extends BaseController
{
    /**
     * author  程丽明
     * content 场馆管理首页
     * date     20170727
     * */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 后台 - 场馆管理 - 新增教室场地
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/7/27
     * @return object
     */
    public function actionSaveClassRoom()
    {
        $post  = \Yii::$app->request->post();
        $model = new ClassRoomForm();
        if ($model->load($post,'') && $model->validate()) {
            $data = $model->saveClassRoom();
            if($data === true){
                return json_encode(['status' => 'success', 'data' => '添加成功']);
            }else{
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        }else{
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 后台 - 座次管理 - 修改教室场地
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/06/06
     * @return object
     */
    public function actionUpdateClassRoom()
    {
        $post  = \Yii::$app->request->post();
        $model = new ClassRoomForm();
        if ($model->load($post,'') && $model->validate()) {
            $data = $model->updateClassRoom();
            if($data === true){
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            }else{
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        }else{
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @后台 - 场馆管理 - 新增房间
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/29
     * @return object
     */
    public function actionSaveRoom()
    {
        $post  = $this->post;
        $model = new ClassRoomForm();
        $data  = $model->saveRoom($post);
        if($data === true){
            return json_encode(['status' => 'success', 'data' => '添加成功']);
        }else{
            return json_encode(['status' => 'error', 'data' => $data]);
        }
    }

    /**
     * @后台 - 场馆管理 - 获取房间
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/29
     * @return object
     */
    public function actionRoomInfo()
    {
        $venueId = \Yii::$app->request->get('venueId');
        $model   = new Organization();
        $data    = $model->roomInfo($venueId);
//        $venuename = $model->venueName($venueId);
        return json_encode($data);
    }
    /**
     * @后台 - 场馆管理 - 房间列表
     * @author zhangdongxu <zhangdongxu@itsports.club>
     * @create 2018/07/23
     * @return object
     */
    public function actionRoomList()
    {
        $venueId = \Yii::$app->request->get('venueId');
        $get = \Yii::$app->request->get();
        $model   = new Organization();
        $nowPage                = empty($get["page"])?0:$get["page"]-1;
        $data    = $model->roomlist($venueId);
        $pagination             = $data->pagination;
        $totalPage              = ceil($data->pagination->totalCount/8);
        $pages                  = Func::getPagesFormat($pagination,"roomlist");
        $venuename = $model->venueName($venueId);
        return json_encode(['data'=>['list'=>$data->models,'venuename'=>$venuename],'nowpage'=>$nowPage,'pages'=>$pages,'totalpage'=>$totalPage]);

    }


    /**
     * @后台 - 场馆管理 - 删除房间
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/29
     * @return object
     */
    public function actionDelRoom()
    {
        $roomId = \Yii::$app->request->get('roomId');
        $model  = new ClassRoomForm();
        $data   = $model->delRoom($roomId);
        if($data === true){
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        }else{
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     * 后台 - 场馆管理 - 删除教室场地
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/7/27
     * @return object
     */
    public function actionDelClassRoom()
    {
        $roomId    = \Yii::$app->request->get('roomId');
        if(!empty($roomId)){
            $model = new ClassRoom();
            $data  = $model->delClassRoom($roomId);
            if($data === true){
                return json_encode(['status' => 'success', 'data' => '删除成功']);
            }else{
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        }else{
            return false;
        }
    }

    /**
     * @api{post} /venue-management/save-seat 添加座位排次
     * @apiVersion  1.0.0
     * @apiName 添加座位排次
     * @apiGroup VenueManagement
     * @apiPermission 管理员
     *
     * @apiParam {int} roomId 教室id
     * @apiParam {string} name 座位排次名称
     * @apiParam {int} rows 排
     * @apiParam {int} columns 列
     * @apiParam {array} rowsArr 排数组
     * @apiParam {array} columnsArr 列数组
     * @apiParam {array} numberArr 座位号数组
     * @apiParam {array} typeArr 座位类型数组
     *
     * @apiParamExample {json} Request Example
     * {
     *     "roomId": "1",
     *     "name": "高温瑜伽",
     *     "rows": "5",
     *     "columns": "6",
     *     "rowsArr": "[1,2,3]",
     *     "columnsArr": "[1,2,3]",
     *     "numberArr": "[1,2,3]",
     *     "typeArr": "[1,2,3]",
     * }
     * @apiDescription 添加座位排次<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/28<br/>
     * <span><strong>调用方法：</strong></span>/venue-management/save-seat
     * @apiSampleRequest  http://qa.uniwlan.com/venue-management/save-seat
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {
     *   'status' => “success”,
     *   'data'   => "添加成功" ,
     * }
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status' => “error”,
     *   'data'   => "添加失败的信息" ,
     * }
     */
    public function actionSaveSeat()
    {
        $post  = \Yii::$app->request->post();
        $model = new SeatForm();
        if ($model->load($post,'') && $model->validate()) {
            $data = $model->saveSeat($this->companyId,$this->venueId);
            if($data === true){
                return json_encode(['status' => 'success', 'data' => '添加成功']);
            }else{
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        }else{
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api{post} /venue-management/update-seat 修改座位排次
     * @apiVersion  1.0.0
     * @apiName 座位排次- 修改座位排次
     * @apiGroup VenueManagement
     * @apiPermission 管理员
     *
     * @apiParam {int} seatTypeId 座位排次id
     * @apiParam {int} roomIdUp 教室id
     * @apiParam {string} nameUp 座位排次名称
     * @apiParam {int} rowsUp 排
     * @apiParam {int} columnsUp 列
     * @apiParam {array} rowsArrUp 排数组
     * @apiParam {array} columnsArrUp 列数组
     * @apiParam {array} numberArrUp 座位号数组
     * @apiParam {array} typeArrUp 座位类型数组
     *
     * @apiParamExample {json} Request Example
     * {
     *     "seatTypeId": "1",
     *     "roomIdUp": "1",
     *     "nameUp": "高温瑜伽",
     *     "rowsUp": "5",
     *     "columnsUp": "6",
     *     "rowsArrUp": "[1,2,3]",
     *     "columnsArrUp": "[1,2,3]",
     *     "numberArrUp": "[1,2,3]",
     *     "typeArrUp": "[1,2,3]",
     * }
     * @apiDescription 修改座位排次<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/28<br/>
     * <span><strong>调用方法：</strong></span>/venue-management/update-seat
     * @apiSampleRequest  http://qa.uniwlan.com/venue-management/update-seat
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {
     *   'status' => “success”,
     *   'data'   => "修改成功" ,
     * }
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status' => “error”,
     *   'data'   => "修改失败的信息" ,
     * }
     */
    public function actionUpdateSeat()
    {
        $post  = \Yii::$app->request->post();
        $model = new SeatForm();
        if ($model->load($post,'') && $model->validate()) {
            $data = $model->updateSeat($this->companyId,$this->venueId);
            if($data === true){
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            }else{
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        }else{
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api{get} /venue-management/del-seat 删除座位排次
     * @apiVersion  1.0.0
     * @apiName 场馆管理 - 删除座位排次
     * @apiGroup VenueManagement
     * @apiPermission 管理员
     *
     * @apiParam {int} seatTypeId 座位排次id
     *
     * @apiParamExample {json} Request Example
     * {
     *     "seatTypeId": "1",
     * }
     * @apiDescription 场馆管理 - 删除座位排次<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/28<br/>
     * <span><strong>调用方法：</strong></span>/venue-management/del-seat
     * @apiSampleRequest  http://qa.uniwlan.com/venue-management/del-seat
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {
     *   'status' => “success”,
     *   'data'   => "删除成功" ,
     * }
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status' => “error”,
     *   'data'   => "删除失败的信息" ,
     * }
     */
    public function actionDelSeat()
    {
        $seatTypeId = \Yii::$app->request->get("seatTypeId");
        if(!empty($seatTypeId)){
            $model = new Seat();
            $data  = $model->delSeat($seatTypeId);
            if($data === true){
                return json_encode(['status' => 'success', 'data' => '删除成功']);
            }else{
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        }else{
            return false;
        }
    }

    /**
     * @api{get} /venue-management/get-seat 获取所有座位排次
     * @apiVersion  1.0.0
     * @apiName 获取所有座位排次
     * @apiGroup VenueManagement
     * @apiPermission 管理员
     *
     * @apiParam {int} venueId 场馆id
     *
     * @apiParamExample {json} Request Example
     * {
     *     "venueId": "1",
     * }
     * @apiDescription 场馆管理 - 获取所有座位排次<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/28<br/>
     * <span><strong>调用方法：</strong></span>/venue-management/get-seat
     * @apiSampleRequest  http://qa.uniwlan.com/venue-management/get-seat
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'data':['id':'1','name':'高温瑜伽'...]}
     * @apiErrorExample {json} 错误示例:
     * {'data':[]}
     */
    public function actionGetSeat()
    {
        $venueId = \Yii::$app->request->get("venueId");
        if(!empty($venueId)){
            $model = new SeatType();
            $data  = $model->getSeatData($venueId);
            return json_encode(['data' => $data]);
        }else{
            return false;
        }
    }

    /**
     * @api{get} /venue-management/seat-details 获取座位排次详情
     * @apiVersion  1.0.0
     * @apiName 场馆管理 -获取座位排次详情
     * @apiGroup VenueManagement
     * @apiPermission 管理员
     *
     * @apiParam {int} seatTypeId 座位排次id
     *
     * @apiParamExample {json} Request Example
     * {
     *     "seatTypeId": "1",
     * }
     * @apiDescription 场馆管理 - 获取座位排次详情<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/7/28<br/>
     * <span><strong>调用方法：</strong></span>/venue-management/seat-details
     * @apiSampleRequest  http://qa.uniwlan.com/venue-management/seat-details
     *
     * @apiSuccess(返回值) {string} status 状态
     * @apiSuccess(返回值) {string} data 提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'data':['id':'1','name':'高温瑜伽'...]}
     * @apiErrorExample {json} 错误示例:
     * {'data':[]}
     */
    public function actionSeatDetails()
    {
        $seatTypeId   = \Yii::$app->request->get("seatTypeId");
        if(!empty($seatTypeId)){
            $model = new SeatType();
            $data  = $model->seatDetails($seatTypeId);
            return json_encode(['data' => $data]);
        }else{
            return false;
        }
    }

    /**
     * 后台 - 场馆管理 - 判断能不能删除修改座次
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/8/11
     * @return object
     */
    public function actionGroupClass()
    {
        $seatId    = \Yii::$app->request->get('seatTypeId');
        if(!empty($seatId)){
            $model = new GroupClass();
            $data  = $model->seatType($seatId);
            if($data === true){
                return json_encode(['status' => 'success', 'data' => '团课排课以绑定该座次']);
            }else{
                return json_encode(['status' => 'error', 'data' => '团课排课没绑定该座次']);
            }
        }else{
            return false;
        }
    }
}
