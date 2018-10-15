<?php

namespace backend\controllers;

use backend\models\Deal;
use backend\models\DealChangeRecord;
use backend\models\DealForm;
use backend\models\DealType;
use backend\models\DealTypeForm;
use backend\models\MemberDealRecord;
use common\models\Func;

class ContractController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAdd()
    {
        return $this->render('add');
    }

    /**
     * @api {get} /contract/deal   *合同管理 增加帅选功能
     * @apiVersion 1.0.0
     * @apiName  合同管理 - 合同管理 增加帅选功能
     * @apiGroup Deal
     * @apiPermission 管理员
     * @apiParam {int} nowVenueId   场馆id （新增参数）
     * @apiParam {int} nowCompanyId 公司id   （新增参数）
     * @apiParamExample {json} Request Example
     * get  /contract/deal
     * {
     *      "nowVenueId "=>12，      //场馆id （新增）
     *      "nowCompanyId"=>17,      //公司id  （新增）
     * }
     * {get} /contract/deal
     * @apiDescription 合同管理 增加帅选功能，按照公司和场馆
     * <span><strong>作    者：</strong></span>侯凯新<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/15
     *
     * @apiSampleRequest  http://qa.uniwlan.com/contract/deal
     * @apiSuccess (返回值) {string} status 保存状态
     * @apiSuccess (返回值) {string} data   返回保存状态的数据
     */
    public function actionDeal()
    {
        $name = \Yii::$app->request->queryParams;
        $model = new Deal();
        $dealDataObj = $model->getData($name);
        $pagination = $dealDataObj->pagination;
        $pages = Func::getPagesFormat($pagination);
        return json_encode(["data" => $dealDataObj->models, 'pages' => $pages]);
    }

    /**
     * 后台 - 合同管理  删除指定的数据
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/24
     * @param id          //获取前台需要删除数据的id
     * @return object     //返回删除数据成功与否结果
     */
    public function actionDelData()
    {
        $id = \Yii::$app->request->get('id');
        $model = new Deal();
        $result = $model->getDel($id);
        if ($result) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '删除失败']);
        }
    }

    /**
     * 后台 - 合同类型管理  添加合同数据
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/24
     * @return object     //返回删除数据成功与否结果
     */
    public function actionDealSavePost()
    {
        $post = \Yii::$app->request->post();
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $model = new DealForm([], $companyId, $venueId);
        if ($model->load($post, '') && $model->validate($post)) {
            $deal = $model->insertSave();
            if ($deal === true) {
                return json_encode(['status' => 'success', 'data' => '添加成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $model->errors]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * 后台 - 合同类型管理  获取合同单条数据
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/24
     * @param id          //获取前台需要删除数据的id
     * @return object     //返回删除数据成功与否结果
     */
    public function actionGetDealOne($id)
    {
        $data = Deal::getDealOne($id);
        return json_encode(['data' => $data]);
    }

    /**
     * 后台 - 合同类型管理  获取合同单条数据
     * @author huanghua <huanghua@itsports.club>
     * @create 2018/4/28
     * @param id          //获取前台需要删除数据的id
     * @return object     //返回删除数据成功与否结果
     */
    public function actionGetDealChange($id)
    {
        $data = MemberDealRecord::getDealOne($id);
        return json_encode(['data' => $data]);
    }

    /**
     * 后台 - 合同类型管理  修改合同数据
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/24
     * @return object     //返回删除数据成功与否结果
     */
    public function actionDealUpdatePost()
    {
        $post = \Yii::$app->request->post();
        $model = new DealForm([], $this->companyId, $this->venueId);
        if ($model->load($post, '') && $model->validate($post)) {
            $deal = $model->updateSave();
            if ($deal === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            }
            return json_encode(['status' => 'success', 'data' => $deal]);
        }
        return json_encode(['status' => 'error', 'data' => $model->errors]);
    }

    /**
     * 后台 - 合同类型管理  获取全部合同类型数据
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/24
     * @return object     //返回删除数据成功与否结果
     */
    public function actionGetDealTypeData()
    {
        $id = $this->companyIds;
        $deal = new DealType();
        $data = $deal->search($id);
        return json_encode(['data' => $data]);
    }

    /**
     * 后台 - 合同类型管理  增加类型数据
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/24
     * @return object     //返回删除数据成功与否结果
     */
    public function actionDealTypeInsertPost()
    {
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $post = \Yii::$app->request->post();
        $model = new DealTypeForm([]);
        if ($model->load($post, '') && $model->validate($post)) {
            $deal = $model->insertSave($companyId, $venueId);
            if ($deal === true) {
                return json_encode(['status' => 'success', 'data' => '添加成功']);
            }
            return json_encode(['status' => 'success', 'data' => $model->errors]);
        }
        return json_encode(['status' => 'error', 'data' => $model->errors]);
    }

    /**
     * 后台 - 合同类型管理  删除指定的数据
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/24
     * @param id          //获取前台需要删除数据的id
     * @return object     //返回删除数据成功与否结果
     */
    public function actionDelDealType($id)
    {
        $model = new DealType();
        $result = $model->getDel($id);
        if ($result) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '合同类型包含合同不能删除']);
        }
    }

    /**
     * 后台 - 合同类型管理 -  获取单条数据
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/24
     * @param id          //获取前台需要数据的id
     * @return object     //返回删除数据成功与否结果
     */
    public function actionGetDealTypeOne($id)
    {
        $data = DealType::getDealTypeOne($id);
        return json_encode(['data' => $data]);
    }

    /**
     * 后台 - 合同类型管理  修改合同了行的数据
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/24
     * @return object     //返回删除数据成功与否结果
     */
    public function actionDealTypeUpdatePost()
    {
        $post = \Yii::$app->request->post();
        $model = new DealTypeForm([]);
        if ($model->load($post, '') && $model->validate($post)) {
            $deal = $model->updateSave();
            if ($deal === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            }
            return json_encode(['status' => 'success', 'data' => $deal]);
        }
        return json_encode(['status' => 'error', 'data' => $model->errors]);
    }

    /**
     * 云运动 - 合同管理 - 验证合同名称是否存在
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/3
     * @param $name string 合同名称
     * @return string
     */
    public function actionSetDealName($name)
    {
        $companyId = $this->companyId;
        $dealName = DealForm::setDealName($name, $companyId);
        if ($dealName) {
            return json_encode(['status' => 'error', 'message' => '合同名称已经存在']);
        }
        return json_encode(['status' => 'success', 'message' => '合同名称不存在']);
    }

    /**
     * 云运动 - 合同管理 - 验证合同类型名称是否存在
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/5/3
     * @param $name string 合同类型名称
     * @return string
     */
    public function actionDealTypeName($name)
    {
        $companyId = $this->companyId;
        $typeName = DealTypeForm::dealTypeName($name, $companyId);
        if ($typeName) {
            return json_encode(['status' => 'error', 'message' => '合同类型名称已经存在']);
        }
        return json_encode(['status' => 'success', 'message' => '合同类型名称不存在']);
    }

    /**
     * 会员卡管理 - 会员卡 - 修改合同数据
     * @create 2017/4/5
     * @author lihuien<lihuien@itsports.club>
     * @return bool
     */
    public function actionUpdateDealCompany()
    {
        $id = \Yii::$app->request->get('id');
        $companyId = \Yii::$app->request->get('companyId');
        $venueId = \Yii::$app->request->get('venueId');
        $del = Deal::updateAll(['company_id' => $companyId, 'venue_id' => $venueId], ['id' => $id]);
        if ($del) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => '修改失败']);
        }
    }

    /**
     * 合同管理 - 列表 - 获取迈步合同名称接口
     * @create 2017/6/23
     * @author huanghua<lihuien@itsports.club>
     * @return bool
     */
    public function actionGetDealName()
    {
        $deal = Deal::getDealName();
        return json_encode($deal);
    }

    /**
     * @api {get} /contract/get-deal   *添加私课 合同
     * @apiVersion 1.0.0
     * @apiName  *添加私课 合同
     * @apiGroup privateDeal
     * @apiPermission 管理员
     *
     * {get} /contract/get-deal
     * @apiDescription 合同管理 *添加私课 合同
     * <span><strong>作    者：</strong></span>焦冰洋<br>
     * <span><strong>邮    箱：</strong></span>houkaixin@itsports.club<br>
     * <span><strong>创建时间：</strong></span>2017/6/15
     *
     * @apiSampleRequest  http://qa.uniwlan.com/contract/get-deal
     * @apiSuccess (返回值) {string} status 保存状态
     * @apiSuccess (返回值) {string} data   返回保存状态的数据
     */
    public function actionGetDeal()
    {
        $type = \Yii::$app->request->get('type');
        $deal = new Deal();
        $deal = $deal->getDealInfo($type, $this->companyId);

        return json_encode($deal);
    }

    /**
     * 后台 - 合同类型管理  查询所有合同
     * @author HuangPengju <HuangPengju@itsports.club>
     * @create 2017/4/27
     * @return string //查询结构
     */
    public function actionDealAllInfo()
    {
        $model = new Deal();
        $data = $model->getDealInfo(null, $this->companyId);

        return json_encode(['deal' => $data]);
    }

    /**
     * 后台 - 合同管理  合同列表变更记录
     * @author huanghua <huanghua@itsports.club>
     * @create 2018/5/15
     * @return string //查询结构
     */
    public function actionChangeDealRecord()
    {
        $dealId = \Yii::$app->request->get('dealId');
        $model = new DealChangeRecord();
        $data = $model->getChangeDealAll($dealId);
        return json_encode(['deal' => $data]);
    }
}
