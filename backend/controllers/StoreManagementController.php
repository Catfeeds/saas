<?php

namespace backend\controllers;

use backend\models\GoodsType;
use backend\models\Mobilise;
use backend\models\Organization;
use backend\models\StoreHouse;
use backend\models\Goods;
use backend\models\StoreHouseForm;
use backend\models\ShopForm;
use backend\models\GoodsChange;
use backend\models\AccessForm;
use backend\models\OutForm;
use backend\models\BreakageForm;
use backend\models\ReturnForm;
use backend\models\MobiliseForm;
use backend\models\MobiliseType;
use backend\models\MobiliseTypeForm;
use backend\models\MobiliseCompleteForm;
use common\models\Func;
use Yii;

class StoreManagementController extends BaseController
{
    /**
     * date:20170828
     * author :程丽明
     * content:仓库管理首页
     * */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     *后台仓库管理 - 仓库列表 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/28
     * @return bool|string
     */
    public function actionStorehouseInfo()
    {
        $params = \Yii::$app->request->queryParams;
        $model = new Goods();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }

        $params['venues'] = $this->venueIds;
        $memberInfo = $model->search($params);
        $pagination = $memberInfo->pagination;
        $data = $memberInfo->models;
        if ($data) {
            foreach ($data as $k => $v) {
                $mobilise = Mobilise::find()->where(['be_store_id' => $v['store_id']])->count();
                $data[$k]['mobilise'] = $mobilise;
            }
        }
        $pages = Func::getPagesFormat($pagination);

        return json_encode(['data' => $data, 'pages' => $pages, 'now' => $nowPage]);
    }

    /**
     *后台仓库管理 - 新增仓库 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/28
     * @return bool|string
     */
    public function actionAddStore()
    {
        $post = \Yii::$app->request->post();
        $companyId = $this->companyId;
        $model = new StoreHouseForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->addStore($companyId);
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '新增成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台仓库管理 - 商品新增 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/29
     * @return bool|string
     */
    public function actionAddShop()
    {
        $post = \Yii::$app->request->post();
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        $model = new ShopForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->addShopData($companyId, $venueId);
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '新增成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台仓库管理 - 商品入库 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/30
     * @return bool|string
     */
    public function actionAddAccess()
    {
        $post = \Yii::$app->request->post();
        $model = new AccessForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->addShopData($post);
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '操作成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台仓库管理 - 商品出库 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/30
     * @return bool|string
     */
    public function actionAddOut()
    {
        $post = \Yii::$app->request->post();
        $model = new OutForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->outData();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '操作成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台仓库管理 - 商品详情列表 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/30
     * @return bool|string
     */
    public function actionGetGoodsHistory()
    {
        $params = \Yii::$app->request->queryParams;
        $model = new GoodsChange();
        $query = $model->getGoodsData($params);
        $data = $model->getSumData($query);
        $store = $model->getDataMoney($query);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination, 'detailsPages');
        return json_encode(['details' => $data->models, 'pages' => $pages, 'chengliming' => $store]);
    }

    /**
     *后台仓库管理 - 商品添加列表 - 获取该公司下所有仓库名称
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/31
     * @return bool|string
     */
    public function actionGetStoreData()
    {
        $model = new StoreHouse();
        $shopDataObj = $model->getStoreData();
        return json_encode(["data" => $shopDataObj]);
    }

    /**
     *后台仓库管理 - 商品详情 - 商品报损,报溢
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/31
     * @return bool|string
     */
    public function actionAddBreakage()
    {
        $post = \Yii::$app->request->post();
        $model = new BreakageForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->addBreakData();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '操作成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台仓库管理 - 商品退库 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/31
     * @return bool|string
     */
    public function actionAddReturn()
    {
        $post = \Yii::$app->request->post();
        $model = new ReturnForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->returnData();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '操作成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台仓库管理 - 新增调拨记录 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/1
     * @return bool|string
     */
    public function actionAddMobilise()
    {
        $post = \Yii::$app->request->post();
        $model = new MobiliseForm();
        $companyId = $this->companyId;
        $venueId = $this->venueId;
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->addMobiliseData($companyId, $venueId);
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '操作成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }


    /**
     *后台仓库管理 - 调拨列表 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/28
     * @return bool|string
     */
    public function actionMobiliseInfo()
    {
        $params = $this->get;
        $model = new Mobilise();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }

        $memberInfo = $model->search($params, $this->venueIds);
        $pagination = $memberInfo->pagination;
        $pages = Func::getPagesFormat($pagination, 'transfersPages');

        return json_encode(['data' => $memberInfo->models, 'pages' => $pages, 'now' => $nowPage]);
    }

    /**
     *后台仓库管理 - 调拨列表 - 调拨商品详细信息
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/1
     * @param $goodsId
     * @return bool|string
     */
    public function actionGetGoodsDetail($goodsId)
    {
        $model = new Mobilise();
        $result = $model->getTheData($goodsId);
        return json_encode($result);
    }

    /**
     *后台仓库管理 - 调拨列表 - 调拨商品详细信息列表
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/1
     * @param $mobiliseTypeId
     * @return bool|string
     */
    public function actionGetGoodsInfo($mobiliseTypeId)
    {
        $model = new Mobilise();
        $result = $model->getOneData($mobiliseTypeId);
        return json_encode($result);
    }

    /**
     *后台仓库管理 - 调拨列表 - 确认通过按钮方法
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/1
     * @return bool|string
     */
    public function actionUpdateTwo()
    {
        $id = \Yii::$app->request->get('mobiliseTypeId');
        $status = MobiliseType::getUpdateMobiliseType($id);

        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '修改成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }
    }

    /**
     *后台仓库管理 - 调拨列表 - 不同意
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/9/1
     * @return bool|string
     */
    public function actionUpdateFour()
    {
        $post = \Yii::$app->request->post();
        $model = new MobiliseTypeForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->updateData();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台仓库管理 - 调拨列表 - 确认调拨
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/9/1
     * @return bool|string
     */
    public function actionMobiliseCompleteForm()
    {
        $post = \Yii::$app->request->post();
        $model = new MobiliseCompleteForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->updateData();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '修改成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *后台仓库管理 - 选择报损、退回、报溢 - angularJs访问该控制器
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/2
     * @return bool|string
     */
    public function actionGetSelectGoods()
    {
        $params = \Yii::$app->request->queryParams;
        $model = new GoodsChange();
        if (isset($params['page'])) {
            $nowPage = $params['page'];
        } else {
            $nowPage = 1;
        }
        $query = $model->getGoodsDataS($params);
        $data = $model->getSumData($query);
        $store = $model->getSumDataMoney($query);
        $pagination = $data->pagination;
        $pages = Func::getPagesFormat($pagination, 'selectPages');
        return json_encode(['details' => $data->models, 'pages' => $pages, 'now' => $nowPage, 'totalAmount' => $store]);
    }

    /**
     *后台仓库管理 - 出库数量 - 计算出库金额
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/7
     * @return bool|string
     */
    public function actionOutGoods()
    {
        $goodsId = \Yii::$app->request->get('goodsId');
        $number = \Yii::$app->request->get('number');
        if (!empty($goodsId && $number)) {
            $model = new GoodsChange();
            $goodsData = $model->goodsCharge($goodsId, $number);
            return json_encode($goodsData);
        } else {
            return false;
        }

    }

    /**
     *后台仓库管理 - 调拨列表 - 调拨新商品id获取
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/12
     * @return bool|string
     */
    public function actionGetNewGoodsId()
    {
        $params = \Yii::$app->request->queryParams;
        if (!empty($params)) {
            $model = new Goods();
            $goodsData = $model->getNewGoodsId($params);
            return json_encode($goodsData);
        } else {
            return false;
        }

    }

    /**
     *后台仓库管理 - 调拨 - 根据公司名查询公司id
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/10/17
     * @return bool|string
     */
    public function actionCompanyName()
    {
        $companyName = \Yii::$app->request->get('companyName');
        if (!empty($companyName)) {
            $model = new Organization();
            $companyData = $model->companyData($companyName);
            if (!empty($companyData)) {
                return json_encode(['status' => 'success', 'data' => $companyData]);
            } else {
                return json_encode(['status' => 'error', 'data' => "搜索的公司不存在或公司名称填写错误"]);
            }
        } else {
            return false;
        }
    }

    /**
     *后台仓库管理 - 根据场馆id - 获取该场馆下所有仓库名称
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/10/17
     * @return bool|string
     */
    public function actionGetStoreDataAll()
    {
        $venueId = \Yii::$app->request->get('venueId');
        if (!empty($venueId)) {
            $model = new StoreHouse();
            $storeData = $model->getStoreDataAll($venueId);
            return json_encode(['data' => $storeData]);
        } else {
            return false;
        }
    }

    /**
     *后台仓库管理 - 根据场馆id - 获取该场馆下所有仓库名称
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/10/17
     * @return bool|string
     */
    public function actionGetStoreAll()
    {
        $card = new \backend\models\CardCategory();
        $venueId = $card->getVenueIdByRole();
        if (!empty($venueId)) {
            $model = new StoreHouse();
            $storeData = $model->getStoreDataAll($venueId);
            return json_encode(['data' => $storeData]);
        } else {
            return false;
        }
    }

    /**
     *后台仓库管理 - 修改商品信息 - 获取单个商品的详情
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/3
     * @return bool|string
     */
    public function actionGoodsInfo()
    {
        $id = \Yii::$app->request->get('goodsId');
        if ($id) {
            $model = new StoreHouse();
            $goodsInfo = $model->getGoodsInfo($id);
            return json_encode($goodsInfo);
        } else {
            return false;
        }
    }

    /**
     *后台仓库管理 - 修改商品信息 - 获取当前场馆的所有仓库
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/3
     * @return bool|string
     */
    public function actionGetAllStores()
    {
        $venueId = \Yii::$app->request->get('venueId');
        if ($venueId) {
            $model = new StoreHouse();
            $stores = $model->getAllStores($venueId);
            return json_encode($stores);
        } else {
            return false;
        }
    }

    /**
     *后台仓库管理 - 修改商品信息 - 获取当前场馆的所有商品类别
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/3
     * @return bool|string
     */
    public function actionGetGoodsTypes()
    {
        $venueId = \Yii::$app->request->get('venueId');
        if ($venueId) {
            $model = new StoreHouse();
            $types = $model->getAllTypes($venueId);
            return json_encode($types);
        } else {
            return false;
        }
    }

    /**
     *后台仓库管理 - 修改商品信息 - 点击完成
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/3
     * @return bool|string
     */
    public function actionUpdateGoodsInfo()
    {
        $goodsId = \Yii::$app->request->get('goodsId');
        $param = \Yii::$app->request->post();
        if ($goodsId) {
            $model = new StoreHouse();
            $data = $model->updateGoodsInfo($goodsId, $param);
            if ($data) {
                return json_encode(['status' => 'success']);
            } else {
                return json_encode(['status' => 'error']);
            }
        } else {
            return false;
        }
    }

    /**
     *后台仓库管理 - 修改商品信息 - 添加商品品类
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/3
     * @return bool|string
     */
    public function actionAddGoodsType()
    {
        $param = \Yii::$app->request->post();
        if ($param) {
            $model = new StoreHouse();
            $data = $model->addGoodsType($param);
            if ($data) {
                return json_encode(['status' => 'success']);
            } else {
                return json_encode(['status' => 'error']);
            }
        } else {
            return false;
        }
    }

    /**
     *后台仓库管理 - 修改商品信息 - 删除商品品类
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2018/1/4
     * @return bool|string
     */
    public function actionDelGoodsType()
    {
        $goodsTypeId = \Yii::$app->request->get();
        if ($goodsTypeId) {
            $type = GoodsType::findOne(['id' => $goodsTypeId]);
            if ($type) {
                $data = GoodsType::findOne(['id' => $goodsTypeId])->delete();
                if ($data) {
                    return json_encode(['status' => 'success']);
                } else {
                    return json_encode(['status' => 'error', 'data' => "删除失败"]);
                }
            } else {
                return json_encode(['status' => 'error', 'data' => "请选择要删除的选项"]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => "请选择要删除的选项"]);
        }
    }

}
