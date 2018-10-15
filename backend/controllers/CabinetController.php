<?php

namespace backend\controllers;

use backend\models\Cabinet;
use backend\models\Config;
use backend\models\Member;
use backend\models\CabinetRuleForm;
use backend\models\CabinetType;
use backend\models\MemberCabinet;
use backend\models\Organization;
use common\models\Func;

class CabinetController extends BaseController
{
    /**
     * @api {get} /cabinet/filter-data  初始化柜子租用状态
     * @apiVersion 1.0.0
     * @apiName   初始化柜子租用状态
     * @apiGroup cabinet
     * @apiPermission 管理员
     * @apiParamExample {json} Request Example
     * get /cabinet/filter-data
     * @apiDescription  初始化柜子租用状态（将到期柜子，退租柜子，清空租用记录，修改租用状态
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/4
     *
     * @apiSampleRequest  http://qa.uniwlan.com/cabinet/filter-data
     * @apiSuccess (返回值) data  返回数据
     * * @apiSuccessExample {json} 成功示例:
     *{
     *   data:true;            //请求成功
     *   data:"请求参数失败"   //请求失败（结果不是true）
     * };
     */
    public function actionFilterData()
    {
        /*$model               = new Cabinet();
        $result              =  $model->filterData();
        return json_encode($result);*/
    }

    /**
     * @api {get} /cabinet/home-data  指定各个柜子的租用状态数据分页显示
     * @apiVersion 1.0.0
     * @apiName   指定各个柜子的租用状态数据分页显示
     * @apiGroup cabinet
     * @apiPermission 管理员
     * @apiParam {int} typeId   柜子类型id
     * @apiParam {string} sortType 排序的字段
     * @apiParam {string} sortName 排序的方式
     * @apiParamExample {json} Request Example
     * GET   /cabinet/home-data
     * {
     *       typeId   :52,             //柜子类型id
     *       sortType :"cabinetNum",  //柜子排序字段1:cabinetNum（柜号）2：customerName（绑定用户）3：cabinetModel（柜子型号）4：cabinetType（柜子类别）5:cabinetEndRent(柜子到期剩余天数)
     *       sortName："ASC",         // 排序方式（1 ASC(升序)DES（降序））
     *
     * }
     * @apiDescription 指定各个柜子的租用状态数据分页显示
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club
     * <span><strong>创建时间：</strong></span>2017/6/4
     *
     * @apiSampleRequest  http://qa.uniwlan.com/cabinet/home-data
     * @apiSuccess (返回值) data  返回数据
     * * @apiSuccessExample {json} 成功示例:
     *{
     *   'id' => string '1' ,                    //柜子id
     *   'cabinet_type_id' => string '1' ,       //柜子类型id
     *  'cabinet_number' => string '大大上海瑜伽健身馆-0001'  //柜子编号
     *   'status' => string '2'                 // 柜子租用状态 （1未租 2 已租 3 维修状态）
     *  'type_name' => string '萨嘎'            // 柜子类型名字
     *   'consumerName' => string '王亚娟'      //用户名字
     *   'surplus'    => float 7534            // 剩余天数 (如果没有客户租用输出结果为false)
     *  'totalDay' => float 128575967.91046    //总天数   （如果没有客户租用输出结果为false）
     *  'venueId' => string '47' (length=2)    // 柜子场馆id
     *  'cabinetModel' => string '2'           //柜子规格 1:大柜2:中柜3:小柜
     *  'cabinetType' => string '2'           //柜子类型  1:临时2:正式
     *  'mobile' =>string"客户电话号码"       // 客户电话号码
     * };
     */
    public function actionHomeData()
    {
        //备注 这个接口的  每页大小 是 手机端 和 pc端 公共接口  调整接口时 多注意
        $name = \Yii::$app->request->queryParams;
        $pageSize = (!isset($name["pageSize"]) || empty($name["pageSize"]) || $name["pageSize"] == "undefined") ? 8 : $name["pageSize"];
        $model = new Cabinet();
        if (isset($name['page'])) {
            $nowPage = $name['page'];
        } else {
            $nowPage = 1;
        }
        $cabinetDataObj = $model->getData($name, '', $pageSize);
        $pagination = $cabinetDataObj->pagination;
        $pages = Func::getPagesFormat($pagination);

        return json_encode(["data" => $cabinetDataObj->models, 'pages' => $pages, 'now' => $nowPage]);
    }

    /**
     * 后台 - 柜子管理-  获取所有柜子类型
     * @author HouKaiXin <houkaixin@itsports.club>
     * @create 2017/5/3
     * @param
     * @return object     //返回主界面遍历数据和分页样式
     */
    public function actionCabinetType()
    {
        $data = \Yii::$app->request->get();
        $model = new CabinetType();
        $typeData = $model->getCabinetType($data["venueId"]);
        $cabinet = $model->getCabinetNum($data["typeId"]);
        $data[] = $typeData;
        $data[] = $cabinet;
        return json_encode($data);
    }

    /**
     * @api {post} /cabinet/change-cabinet 会员柜子调换
     * @apiVersion 1.0.0
     * @apiName  会员柜子调换
     * @apiGroup cabinet
     * @apiPermission 管理员
     * @apiParam {string} _csrf_backend   csrf 防止跨站伪造
     * @apiParam {int} memCabinetId          会员柜子id
     * @apiParam {int} cabinetId             新柜子id
     * @apiParam {int} originalCabinetId     老柜子id
     * @apiParamExample {json} Request Example
     * GET    /cabinet/change-cabinet 会员柜子调换
     * {
     *       _csrf_backend :'SG5uZUtDQXokWgBWcxw2Ph8NW1w4dyhJDyoJAA40IzUBWjEGCAoIHA==',  //csrf防止跨站
     *       memCabinetId :52       // 会员柜子id
     *       cabinetId : 33,       // 新柜子id
     *      originalCabinetId:44   //老柜子id
     * }
     * @apiDescription    会员柜子调换 操作执行
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/7
     *
     * @apiSampleRequest  http://qa.uniwlan.com/cabinet/change-cabinet 会员柜子调换
     * @apiSuccess (返回值) data  返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *   'status' => "调换成功",           //成功状态
     *   'data' => "成功后返回的信息" ,    //调换成功返回的信息
     * };
     * @apiErrorExample {json} 错误示例:
     * {'status'=>'error',                //失败状态
     * 'data'=>“保存失败信息”           //调换失败返回的信息
     * }
     */
    public function actionChangeCabinet()
    {
        $post = $this->post;
        $model = new CabinetRuleForm();
        $model->setScenario('changeCabinet');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->changeCabinet($this->companyId, $this->venueId);
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '调柜成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 后台 - 柜子管理 -  查询对应柜子类型所属柜子
     * @author HouKaiXin <houkaixin@itsports.club>
     * @create 2017/5/3
     * @param
     * @return object     //执行数据修改
     */
    public function actionCabinetData()
    {
        $id = \Yii::$app->request->get("id");
        $model = new Cabinet();
        $data = $model->getCabinetData($id);

        return json_encode($data);
    }

    /**
     * @api {get} /cabinet/quite-cabinet  会员退租柜子
     * @apiVersion 1.0.0
     * @apiName  会员退租柜子
     * @apiGroup theCabinet
     * @apiPermission 管理员
     * @apiParam {string} _csrf_backend   csrf 防止跨站伪造
     * @apiParam {int}    memCabinetId    会员柜子id
     * @apiParam {int}    memberId        会员id
     * @apiParam {int}    cabinetId        柜子id
     * @apiParam {string} price           退租金额
     * @apiParam {string} quiteDate       退租日期
     * @apiParamExample {json} Request Example
     * GET   /cabinet/quite-cabinet
     * {
     *       _csrf_backend :'SG5uZUtDQXokWgBWcxw2Ph8NW1w4dyhJDyoJAA40IzUBWjEGCAoIHA==',  //csrf防止跨站
     *       memCabinetId :52       // 会员柜子id
     *       cabinetId：13          //柜子id
     *       memberId：22           //会员id
     *       price：12              //退租金额
     *       quiteDate: 2012-3-12,  // 退租日期
     * }
     * @apiDescription 点击退租柜子的操作
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/5
     *
     * @apiSampleRequest  http://qa.uniwlan.com/cabinet/quite-cabinet
     * @apiSuccess (返回值) data  返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *   'status' => "退租成功",           //退租状态
     *   'data' => "成功后返回的信息" ,    //退租成功返回的信息
     * };
     * @apiErrorExample {json} 错误示例:
     * {'status'=>'error',                //退租状态
     * 'data'=>“保存失败信息”           //退租失败返回的信息
     * }
     */
    public function actionQuiteCabinet()
    {
        $post = $this->post;
        $model = new CabinetRuleForm();
        $model->setScenario('quiteCabinet');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->quiteCabinet($this->companyId, $this->venueId);
            if ($result) {
                return json_encode(['status' => 'success', 'data' => '退租成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 后台 - 柜子管理 -  解绑会员租赁柜子
     * @author HouKaiXin <houkaixin@itsports.club>
     * @create 2017/5/3
     * @param
     * @return object
     */
    public function actionDelMemCabinet()
    {
        $data = $this->get;
        $model = new MemberCabinet();
        $result = $model->getDel($data);
        if ($result) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     * @api {get} /cabinet/venue-cabinet 获取大上海的各个场馆
     * @apiVersion 1.0.0
     * @apiName   获取大上海的各个场馆
     * @apiGroup cabinet
     * @apiPermission 管理员
     * @apiParamExample {json} Request Example
     * get /cabinet/venue-cabinet
     * @apiDescription  获取大上海的各个场馆
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/5
     *
     * @apiSampleRequest  http://qa.uniwlan.com/cabinet/venue-cabinet
     * @apiSuccess (返回值) data  返回数据
     * * @apiSuccessExample {json} 成功示例:
     *{
     *      "id":43,                //场馆id
     *      "name":大上海瑜伽健身馆 //场馆名称
     * };
     */
    public function actionVenueCabinet()
    {
        $model = new Organization();
        $data = $model->getOrganizationOption($this->venueIds);   //获取登录公司帐号下面的场馆
        return json_encode($data);
    }

    /**
     * 后台 - 柜子管理 -  根据不同的场馆查询柜子类型
     * @author HouKaiXin <houkaixin@itsports.club>
     * @create 2017/5/4
     * @param
     * @return object  //指定场馆下的柜子数据
     */
    public function actionCabinetTypeData()
    {
        $id = \Yii::$app->request->get("id");
        $model = new CabinetType();
        $data = $model->getTheData($id);
        return json_encode($data);
    }

    /**
     * @api {post} /cabinet/add-venue-cabinet 新增柜子
     * @apiVersion 1.0.0
     * @apiName  新增柜子
     * @apiGroup Cabinet
     * @apiPermission 管理员
     * @apiParam {int}     organizationId      场馆id
     * @apiParam {int}     cabinetTypeId       柜子类型id
     * @apiParam {string}  cabinetNum          柜子数量
     * @apiParam {string}  dayRentPrice        日租用价格
     * @apiParam {string}  monthRentPrice      月租用价格
     * @apiParam {string}  halfYearRentPrice   半年租价
     * @apiParam {string}  yearRentPrice       一年租价
     * @apiParam {string}  cabinetModel       柜子型号
     * @apiParam {string}  cabinetType        柜子类别
     * @apiParam {string} _csrf_backend       csrf 防止跨站伪造
     * @apiParamExample {json} Request Example
     * GET /cabinet/add-venue-cabinet
     * {
     *       organizationId  :12,   // 场馆id
     *       cabinetTypeId  :12    //柜子类型id
     *       cabinetNum：12        //柜子数量
     *       dayRentPrice：300    //日租价
     *       monthRentPrice：700  //月租价
     *       halfYearRentPrice：1100 //半年租价
     *       yearRentPrice：2800    //一年租价
     *       _csrf_backend :'SG5uZUtDQXokWgBWcxw2Ph8NW1w4dyhJDyoJAA40IzUBWjEGCAoIHA==',  //csrf防止跨站
     * }
     * @apiDescription   新增柜子
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/7
     * @apiSampleRequest  http://qa.uniwlan.com/cabinet/add-venue-cabinet
     * @apiSuccess (返回值)  data 返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *       'status':"success",     //添加成功状态
     *       "data":“添加成功”    //添加成功信息
     * };
     * @apiErrorExample {json} 错误示例:
     * {
     *      'status'=>'error',      //添加失败
     *      'data'=>“绑定失败”   //添加失败信息
     * }
     */
    public function actionAddVenueCabinet()
    {
        $post = $this->post;
        $model = new CabinetRuleForm();
        $model->setScenario('addCabinet');

        if ($model->load($post, '') && $model->validate()) {
            $result = $model->addCabinet($this->venueId, $this->companyId);
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => "保存失败"]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api {post} /cabinet/add-cabinet-type 新增柜子类型
     * @apiVersion 1.0.0
     * @apiName    新增柜子类型
     * @apiGroup  Cabinet
     * @apiPermission 管理员
     * @apiParam {string}  cabinetTypeName     柜子类型名字
     * @apiParam {string} _csrf_backend       csrf 防止跨站伪造
     * @apiParamExample {json} Request Example
     * GET  /cabinet/add-cabinet-type
     * {
     *       cabinetTypeName  :男大柜   //柜子类型名字
     *       _csrf_backend :'SG5uZUtDQXokWgBWcxw2Ph8NW1w4dyhJDyoJAA40IzUBWjEGCAoIHA==',  //csrf防止跨站
     * }
     * @apiDescription   新增柜子类型区域
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/8
     * @apiSampleRequest  http://qa.uniwlan.com/cabinet/add-cabinet-type
     * @apiSuccess (返回值)  data 返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *       'status':"success",     //添加成功状态
     *       "data":“添加成功”    //添加成功信息
     * };
     * @apiErrorExample {json} 错误示例:
     * {
     *      'status'=>'error',      //添加失败
     *      'data'=>“绑定失败”   //添加失败信息
     * }
     */
    public function actionAddCabinetType()
    {
        $post = $this->post;
        $venueId = \Yii::$app->request->post('venueId');
        $model = new CabinetRuleForm();
        $model->setScenario('addCabinetType');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->addCabinetType($venueId, $this->companyId);
            if ($result == true) {
                return json_encode(['status' => 'success', 'data' => '保存柜子类型成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => "保存柜子类型失败"]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 后台 -  柜子管理  - 绑定用户
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/5/9
     * @param
     * @return object   //绑定用户之后的结果
     */
    public function actionBindUser()
    {
        $post = $this->post;
        $model = new CabinetRuleForm();
        $model->setScenario('bindMember');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->bindMember();
            if ($result == "success") {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else if ($result == "error") {
                return json_encode(['status' => 'error', 'data' => '数据保存失败']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => "数据保存失败"]);
        }
    }

    /**
     * @api {post} /cabinet/cabinet-update 柜子信息修改
     * @apiVersion 1.0.0
     * @apiName    柜子信息修改
     * @apiGroup  cabinetUpdate
     * @apiPermission 管理员
     * @apiParam {string}  cabinetModel       柜子型号
     * @apiParam {string}  cabinetType        柜子类别
     * @apiParam {string}  cabinetId          柜子id
     * @apiParam {string}  monthRentPrice     月租价格
     * @apiParam {string}  yearRentPrice      年租价格
     * @apiParam {string} _csrf_backend       csrf 防止跨站伪造
     * @apiParamExample {json} Request Example
     * GET   /cabinet/cabinet-update 柜子信息修改
     * {
     *       cabinetModel   : 1
     *       cabinetType ：1
     *       cabinetId ： 1
     *       monthRentPrice：12
     *       yearRentPrice:12
     *       _csrf_backend :'SG5uZUtDQXokWgBWcxw2Ph8NW1w4dyhJDyoJAA40IzUBWjEGCAoIHA==',  //csrf防止跨站
     * }
     * @apiDescription    柜子信息修改
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/9
     * @apiSampleRequest  http://qa.uniwlan.com /cabinet/cabinet-update
     * @apiSuccess (返回值)  data 返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *       'status':"success",     //修改成功状态
     *       "data":“添加成功”    //修改成功信息
     * };
     * @apiErrorExample {json} 错误示例:
     * {
     *      'status'=>'error',      //修改失败
     *      'data'=>“绑定失败”   //修改失败信息
     * }
     */
    public function actionCabinetUpdate()
    {
        $post = $this->post;
        $model = new CabinetRuleForm();
        $model->setScenario('update');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->updateCabinet();
            if ($result == "success") {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else if ($result == "error") {
                return json_encode(['status' => 'error', 'data' => '修改失败']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api {get} /cabinet/get-cabinet-type  获取柜子类型各个 参数类型
     * @apiVersion 1.0.0
     * @apiName   获取柜子类型各个 参数类型
     * @apiGroup cabinet
     * @apiPermission 管理员
     * @apiParam {int} venueId  场馆id
     * @apiParamExample {json} Request Example
     * GET  /cabinet/get-cabinet-type
     * {
     *      venueId :52,   //下拉列表场馆id
     *
     * }
     * @apiDescription  获取柜子类型的各个参数 1 柜子名称 2 柜子总数量 3 已租柜子数量
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/4
     *
     * @apiSampleRequest  http://qa.uniwlan.com/cabinet/get-cabinet-type
     * @apiSuccess (返回值) data  返回数据
     * * @apiSuccessExample {json} 成功示例:
     *{
     *      "id":1,             //柜子类型id
     *      "type_name":"女大柜"， //柜子类型名称
     *      'cabinetNum':13，    //柜子总数量
     *      'is_rent':12，      //柜子被租数量
     * };
     */
    public function actionGetCabinetType()
    {
        $model = new Cabinet();
        $data = $model->getAllCabinetData($this->venueIds);

        return json_encode($data);
    }

    /**
     * @desc: 更柜管理-获取区域列表
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/02/11
     * @return string
     */
    public function actionGetCabinetList()
    {
        $model = new Cabinet();
        $venueId = \Yii::$app->request->get('venueId');
        $data = $model->getAllCabinetList($venueId);

        return json_encode($data);
    }

    /**
     * @api {get} /cabinet/quite-money  退租-退还金额
     * @apiVersion 1.0.0
     * @apiName   退租-退还金额
     * @apiGroup cabinet
     * @apiPermission 管理员
     * @apiParam {string} quiteRent 退租日期
     * @apiParam {string} endRent   到租日期
     * @apiParam {string} dayRentPrice  日租价
     * @apiParam {string} monthRentPrice  月租价
     * @apiParam {string} yearRentPrice  年租价
     * @apiParamExample {json} Request Example
     * GET  /cabinet/quite-money
     * {
     *      quiteRent :'now',   //退租日期 暂定为 now
     *      endRent   :111111111 //到租日期 （时间戳）
     *      dayRentPrice：600   //日租价
     *      monthRentPrice：300 //月租价
     *      yearRentPrice:1200 //年租价
     * }
     * @apiDescription 退租柜子，退还金额的计算
     * <br/>
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/5
     *
     * @apiSampleRequest  http://qa.uniwlan.com/cabinet/quite-money
     * @apiSuccess (返回值) data  返回数据
     * * @apiSuccessExample {json} 成功示例:
     *{
     *      "money":300,             //退换金额
     * };
     */
    public function actionQuiteMoney()
    {
        $data = $this->get;
        $model = new Cabinet();
        $data = $model->quiteMoney($data);

        return json_encode($data);
    }

    /**
     * @api {get} /cabinet/renew-cabinet  柜子续租表单
     * @apiVersion 1.0.0
     * @apiName  柜子续租表单
     * @apiGroup theeCabinet
     * @apiPermission 管理员
     * @apiParam {int} memCabinetId 会员柜子id
     * @apiParam {string} renewDate   续组日期
     * @apiParam {string} renewNumDay  续组天数
     * @apiParam {string} renewRentPrice  续组价格
     * @apiParamExample {json} Request Example
     * GET /cabinet/renew-cabinet
     * {
     *      memCabinetId :12,      //会员柜子id
     *      renewDate   :2017-3-15 //续组日期
     *      dayRentPrice：12      //续组天数
     *      renewRentPrice：300  //续组价格
     * }
     * @apiDescription 给已租用的柜子续组(缺续租价格计算)
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/5
     *
     * @apiSampleRequest  http://qa.uniwlan.com/cabinet/renew-cabinet
     * @apiSuccess (返回值)  data 返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *       'status':"success",     //续租成功
     *       "data":“续租成功信息” /续租成功信息
     * };
     * @apiErrorExample {json} 错误示例:
     * {
     *      'status'=>'error',      //续租失败
     *      'data'=>“续租失败信息” //续租失败信息
     * }
     */
    public function actionRenewCabinet()
    {
        $post = $this->post;
        $model = new CabinetRuleForm();
        $model->setScenario('renewCabinet');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->renewCabinet($this->companyId, $this->venueId);
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '续租成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api {get} /cabinet/frozen-cabinet  冻结柜子
     * @apiVersion 1.0.0
     * @apiName  冻结柜子
     * @apiGroup cabinet
     * @apiPermission 管理员
     * @apiParam {int} cabinetId      柜子id
     * @apiParamExample {json} Request Example
     * GET /cabinet/renew-cabinet
     * {
     *      cabinetId:12,     //柜子id
     * }
     * @apiDescription 柜子状态的冻结
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/5
     * @apiSampleRequest  http://qa.uniwlan.com/cabinet/frozen-cabinet
     * @apiSuccess (返回值)  data 返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *       'status':"success",     //冻结成功
     *       "data":“冻结成功信息” //冻结成功信息
     * };
     * @apiErrorExample {json} 错误示例:
     * {
     *      'status'=>'error',      //续租失败
     *      'data'=>“冻结成功信息” //冻结成功信息
     * }
     */
    public function actionFrozenCabinet($cabinetId, $status = null)
    {
        $model = new Cabinet();
        $result = $model->frozenCabinet($cabinetId, $status);
        if ($result == "frozen") {
            return json_encode(['status' => 'success', 'data' => '冻结成功']);
        } elseif ($result == "unfreeze") {
            return json_encode(['status' => 'success', 'data' => '解冻成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $result]);
        }
    }

    /**
     * @api {get} /cabinet/search-member 手机号搜索会员信息
     * @apiVersion 1.0.0
     * @apiName  手机号搜索会员信息
     * @apiGroup Cabinet
     * @apiPermission 管理员
     * @apiParam {string} phone      手机号
     * @apiParamExample {json} Request Example
     * GET /cabinet/search-member
     * {
     *      phone:15537312038,     //手机号
     * }
     * @apiDescription 手机号搜索会员信息
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/5
     * @apiSampleRequest  http://qa.uniwlan.com/cabinet/search-member
     * @apiSuccess (返回值)  data 返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *       'id':126,               //会员ID
     *       "name":666 ，       //会员姓名
     *       "mobile":15537312038  //会员电话
     * };
     */
    public function actionSearchMember()
    {
        $phone = \Yii::$app->request->get("phone");
        $model = new Member();
        $result = $model->searchMember($phone, $this->venueId, 'venue');

        return json_encode($result);
    }

    /**
     * @api {post} /cabinet/bind-member 柜子绑定会员
     * @apiVersion 1.0.0
     * @apiName  柜子绑定会员
     * @apiGroup Cabinet
     * @apiPermission 管理员
     *
     * @apiParam {int}     memberId              会员id
     * @apiParam {string} cabinetRentStart   柜子起租日期
     * @apiParam {string} cabinetRentEnd     柜子到期日期
     * @apiParam {string} price              租用价格
     * @apiParam {string} _csrf_backend      csrf 防止跨站伪造
     * @apiParam {string} cabinetId          柜子id
     * @apiParamExample {json} Request Example
     * GET /cabinet/renew-cabinet
     * {
     *       memberId  :12,   //会员id
     *      cabinetRentStart  :2017-3-15 //起租日期
     *      cabinetRentEnd：2017-3-29   //到期日期
     *      price：300 //续组价格
     *      cabinetId：//柜子id
     *      _csrf_backend :'SG5uZUtDQXokWgBWcxw2Ph8NW1w4dyhJDyoJAA40IzUBWjEGCAoIHA==',  //csrf防止跨站
     * }
     * @apiDescription   给柜子绑定会员
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/5
     * @apiSampleRequest  http://qa.uniwlan.com/cabinet/bind-member
     * @apiSuccess (返回值)  data 返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *       'status':"success",     //绑定成功状态
     *       "data":“绑定成功信息” //绑定成功信息
     * };
     * @apiErrorExample {json} 错误示例:
     * {
     *      'status'=>'error',      //绑定失败
     *      'data'=>“绑定失败”   //绑定失败
     * }
     */
    public function actionBindMember()
    {
        $post = $this->post;
        $model = new CabinetRuleForm();
        $model->setScenario('bindNewMember');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->bindTheMember($this->companyId, $this->venueId);
            if ($result === true) {
                return json_encode(['status' => 'success', 'data' => '会员绑定成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $result]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api {get} /cabinet/get-all-cabinet 获取所有未租柜子
     * @apiVersion 1.0.0
     * @apiName  获取所有未租柜子
     * @apiGroup Cabinet
     * @apiPermission 管理员
     * @apiParam {string} typeId 柜子类型id
     * @apiParamExample {json} Request Example
     * GET /cabinet/get-all-cabinet
     * {
     *      typeId:13,     //柜子类型id
     * }
     * @apiDescription 获取所有未租柜子
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/7
     * @apiSampleRequest  http://qa.uniwlan.com/cabinet/get-all-cabinet
     * @apiSuccess (返回值)  data 返回数据
     * @apiSuccessExample {json} 成功示例:
     *{
     *       'id':126,                    //柜子id
     *       "cabinet_number":11111111 ， //柜子编号
     *       "dayRentPrice":12           //日租金
     *       "monthRentPrice":12          //月租金
     *       "halfYearRentPrice":12       //半年租金
     *       "yearRentPrice":12          //月租金
     *       "cabinet_model":1           //柜子类型：(1:大柜2:中柜3:小柜)
     *         "cabinet_type":1            //    柜子类别：(1:临时2:正式)
     * };
     */
    public function actionGetAllCabinet($typeId)
    {
        $model = new CabinetType();
        $result = $model->getCabinetNum($typeId);

        return json_encode($result);
    }

    /**
     * 新柜子管理 - 结租子期计算
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/6/8
     * @param $numberMonth //租柜月数
     * @param $startRent // 租柜开始日期
     * @return object
     * 2018/03/07 付钟超 <fuzhongchao@itsports.club>
     * 新增参数$give,$type        //租柜赠送天数(之前是赠送月数,修改为天数,月和天分开)
     */
    public function actionCalculateDate($numberMonth, $give = '', $type = '', $startRent)
    {
        $model = new CabinetRuleForm();
        $data = $model->bindMemberDateCalculate($numberMonth, $give, $type, $startRent);

        return json_encode($data);
    }

    /**
     * 新柜子管理 - 指定柜子的删除功能
     * @author houkaixin<houkaixin@itsports.club>
     * @create 2017/6/8
     * @param $id //租柜月数
     * @return object
     */
    public function actionCabinetDelete($id = "")
    {
        $model = new Cabinet();
        $deleteResult = $model->deleteCabinet($id);
        if ($deleteResult === false) {
            return json_encode(['status' => 'error', 'data' => "删除失败"]);
        }
        return json_encode(['status' => 'success', 'data' => "删除成功"]);
    }

    /**
     * 新柜子管理 - 删除指定更柜
     * @author houkaixin<houkaixin@itsports.club>
     * @create 2017/11/16
     * @param $id //柜子类型id
     * @return object
     */
    public function actionCabinetTypeDelete($id = "")
    {
        $model = new Cabinet();
        $result = $model->deleteCabinetType($id);
        if ($result === true) {
            return json_encode(['status' => 'success', 'data' => "删除成功"]);
        }
        return json_encode(['status' => 'error', 'data' => $result]);
    }

    /**
     * 新柜子管理 - 到期会员查询 - 列表
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/12/13
     * @return object
     */
    public function actionMemberComeDue()
    {
        $params = $this->get;
        $member = new MemberCabinet();
        if (isset($params['page'])) {
            $hua = $params['page'];
        } else {
            $hua = 1;
        }
        $data = $member->memberCabinetDue($params);
        $pagination = $data->pagination;
        $cabinet = Func::getPagesFormat($pagination, 'replaceCabinetPages');

        return json_encode(['data' => $data->models, 'cabinetPages' => $cabinet, 'huang' => $hua]);
    }

    /**
     * 云运动 - 更柜管理 - 批量发送会员短信（群发）
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/11/27
     * @return array
     */
    public function actionSendCabinetData()
    {
        $post = $this->post;
        $model = new MemberCabinet();
        $status = $model->sendCabinet($post);
        if ($status === false) {
            return json_encode(['status' => 'error', 'data' => '会员信息暂无数据']);
        } else {
            return json_encode(['status' => 'success', 'data' => '发送成功']);
        }
    }

    /**
     * 新柜子管理 - 到期提醒 - 区域选择
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/12/14
     * @return object
     */
    public function actionAreaSelect()
    {
        $cabinet = new CabinetType();
        $data = $cabinet->cabinetTypeData($this->venueIds);

        return json_encode(['cabinet' => $data]);
    }

    /**
     * 新柜子管理 - 类型管理
     * @author yanghuilei<yanghuilei@itsports.club>
     * @create 2017/12/30
     * @return string
     */
    public function actionGetAllCabinetType()
    {
        $cabinetTypeId = \Yii::$app->request->get('cabinetTypeId');
        $cabinet = new CabinetType();
        $data = $cabinet->getCabinetTypeManageList($cabinetTypeId);

        return json_encode($data);
    }

    /**
     * 新柜子管理 - 类型管理 - 柜子批量修改
     * @author yanghuilei<yanghuilei@itsports.club>
     * @create 2018/1/2
     * @return string
     */
    public function actionModifyCabinet()
    {
        $post = $this->post;
        $model = new CabinetRuleForm();
        $model->setScenario('modifyCabinet');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->modifyCabinet($this->venueId);
            if ($result) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => "修改失败"]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 新柜子管理 - 类型管理 - 柜子批量修改 - 根据柜子ID和数量获取详情
     * @author yanghuilei<yanghuilei@itsports.club>
     * @create 2018/1/2
     * @return string
     */
    public function actionGetCabinetTypeDetail()
    {
        $get = $this->get;
        $cabinetId = $get['cabinetId'];
        $model = new CabinetType();
        $result = $model->getCabinetTypeDetail($cabinetId);
        if ($result) {
            return json_encode(['data' => $result, 'status' => 'ok']);
        } else {
            return json_encode(['status' => 'error']);
        }
    }

    /**
     * 新柜子管理 - 类型管理 - 柜子批量修改 - 判断柜号是否和其他的冲突
     * @author yanghuilei<yanghuilei@itsports.club>
     * @create 2018/1/3
     * @return string
     */
    public function actionGetDifferentCabinetNumber()
    {
        $post = $this->post;
        $post['venueId'] = $this->venueId;
        $model = new CabinetType();
        $result = $model->getDifferentCabinetNumber($post);
        if ($result) {
            return json_encode(['status' => 'error']);
        } else {
            return json_encode(['status' => 'ok']);
        }
    }

    /**
     * 新柜子管理 - 类型管理 - 柜子批量删除
     * @author yanghuilei<yanghuilei@itsports.club>
     * @create 2018/1/3
     * @return string
     */
    public function actionDeleteCabinetType()
    {
        $post = $this->get;
        $model = new CabinetRuleForm();
        $model->setScenario('deleteCabinet');
        if ($model->load($post, '') && $model->validate()) {
            $result = $model->deleteCabinet();
            if ($result === true) {
                return json_encode(['status' => 'ok', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => "修改失败"]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 新柜子管理 - 类型管理 - 修改单个柜子多月设置
     * @author yanghuilei<yanghuilei@itsports.club>
     * @create 2018/1/6
     * @param  cabinetId 柜子ID
     * @return string
     */
    public function actionModifyOneCabinet()
    {
        $cabinetId = \Yii::$app->request->get('cabinetId');
        $model = new Cabinet();
        $result = $model->getCabinetMonth($cabinetId);
        return $result ? json_encode(['data' => $result, 'status' => 'ok']) : json_encode(['status' => 'error']);
    }

    /**
     * @desc: 更柜管理-退柜设置-设置退柜配置
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/01/30
     * @return string
     */
    public function actionSetQuitCabinet()
    {
        $post = \Yii::$app->request->post();
        $model = new CabinetRuleForm();
        $result = $model->setQuitCabinet($post, $this->companyId, $this->venueId);
        if ($result == true) {
            return json_encode(['status' => 'success', 'data' => '操作成功']);
        }
        return json_encode(['status' => 'error', 'data' => '操作失败']);
    }

    public function actionGetQuitCabinetValue()
    {
        $model = new Config();
        $data = $model->splitQuitCabinetValue($this->companyId, $this->venueId);

        return json_encode($data);
    }

    /**
     * @desc: 业务后台 - 更柜管理 - 获取单个柜子信息
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/03/08
     * @return string
     */
    public function actionCabinetDetails()
    {
        $cabinet_id = \Yii::$app->request->get('cabinet_id');
        $model = new Cabinet();
        $result = $model->getCabinetDetails($cabinet_id);

        return json_encode($result);
    }

    /**
     * @desc: 业务后台 - 更柜管理 - 获取会员绑定柜子的消费信息
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/03/13
     * @return string
     */
    public function actionMemberConsumList($memberId, $cabinetId, $type)
    {
        $model = new \backend\models\MemberCabinetRentHistory();
        $get = \Yii::$app->request->get();
        $result = $model->memberConsumList($memberId, $cabinetId, $type);
        $nowPage = empty($get["page"]) ? 0 : $get["page"] - 1;
        $pagination = $result->pagination;
        $totalPage = ceil($result->pagination->totalCount / 8);
        $pages = Func::getPagesFormat($pagination, 'memberConsumList');

        return json_encode(["data" => $result->models, "totalPage" => $totalPage, "page" => $pages, 'nowPage' => $nowPage]);
    }
}
