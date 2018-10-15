<?php
//suyu
namespace backend\controllers;

use backend\models\Module;
use backend\models\ModuleForm;
use backend\models\ModuleFunctional;
use backend\models\ModuleFunctionalForm;
use backend\models\SubModuleForm;
use backend\models\TopModuleUpdate;
use backend\models\SubModuleUpdate;
class MenuMobileController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @api{post} /menu/top-module 新增-新增顶级菜单
     * @apiVersion  1.0.0
     * @apiName 新增-新增顶级菜单
     * @apiGroup Menu
     * @apiPermission 管理员
     *
     * @apiParam {string} topName 菜单名
     * @apiParam {string} topEName 菜单英文名
     * @apiParam {string} topIcon 菜单图标
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "topName": "会员管理",
     *        "topEName": "member",
     *        "topIcon": "mm",
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 新增-新增顶级菜单<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/17<br/>
     * <span><strong>调用方法：</strong></span>/menu/top-module
     * @apiSampleRequest  http://qa.uniwlan.com/menu/top-module
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"新增成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *   'data':{
     *     'name':'菜单名称不能为空'
     *   }}
     */
    public function actionTopModule()
    {
//        \Yii::$app->cache->flush();
        $post  = \Yii::$app->request->post();
        $model = new ModuleForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->saveTopModule(2);//2为type状态  为手机菜单
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
     * @api{post} /menu/sub-module 新增子菜单
     * @apiVersion  1.0.0
     * @apiName 新增子菜单
     * @apiGroup Menu
     * @apiPermission 管理员
     *
     * @apiParam {string} subName 菜单名
     * @apiParam {string} subEName 菜单英文名
     * @apiParam {string} subIcon 菜单图标
     * @apiParam {string} subUrl 菜单地址
     * @apiParam {int} topId 顶级菜单ID
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "subName": "会员管理",
     *        "subEName": "member",
     *        "subIcon": "mm",
     *        "subUrl": "fheuhfrfbghbtuh",
     *        "topId": "2",
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 新增子菜单<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/17<br/>
     * <span><strong>调用方法：</strong></span>/menu/sub-module
     * @apiSampleRequest  http://qa.uniwlan.com/menu/sub-module
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"新增成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *   'data':{
     *     'name':'菜单名称不能为空'
     *   }}
     */
    public function actionSubModule()
    {
//        \Yii::$app->cache->flush();
        $post  = \Yii::$app->request->post();
        $model = new SubModuleForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->saveSubModule(2);
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
     * @api{get} /menu/get-module-data 修改-获取需要修改的菜单信息
     * @apiVersion  1.0.0
     * @apiName 修改-获取需要修改的菜单信息
     * @apiGroup Menu
     * @apiPermission 管理员
     *
     * @apiParam {string} moduleId 菜单ID
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "moduleId": "1",
     *   }
     * @apiDescription 修改-获取需要修改的菜单信息<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/18<br/>
     * <span><strong>调用方法：</strong></span>/menu/get-module-data
     * @apiSampleRequest  http://qa.uniwlan.com/menu/get-module-data
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * Array
     * (
     * 'name' => string '会员管理'
     * 'e_name' => string 'member'
     * 'create_at' => '1496472588'
     * )
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *  }
     */
    public function actionGetModuleData()
    {
        $id    = \Yii::$app->request->get('moduleId');
        $model = new Module();
        $data  = $model->getModuleData($id);
        return json_encode($data);
    }

    /**
     * @api{post} /menu/update-top 修改 - 修改顶级菜单
     * @apiVersion  1.0.0
     * @apiName 修改 - 修改顶级菜单
     * @apiGroup Menu
     * @apiPermission 管理员
     *
     * @apiParam {string} topNameUp 菜单名
     * @apiParam {string} topENameUp 菜单英文名
     * @apiParam {string} topIconUp 菜单图标
     * @apiParam {string} topId 菜单id
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "topNameUp": "会员管理",
     *        "topENameUp": "member",
     *        "topIconUp": "mm",
     *        "topId": "2",
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 修改 - 顶级菜单<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/17<br/>
     * <span><strong>调用方法：</strong></span>/menu/update-top
     * @apiSampleRequest  http://qa.uniwlan.com/menu/update-top
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"修改成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *  }
     */
    public function actionUpdateTop()
    {
//        \Yii::$app->cache->flush();
        $post  = \Yii::$app->request->post();
        $model = new TopModuleUpdate();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->updateModule();
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
     * @api{post} /menu/update-sub 菜单管理 - 修改子菜单
     * @apiVersion  1.0.0
     * @apiName 菜单管理 - 修改子菜单
     * @apiGroup Menu
     * @apiPermission 管理员
     *
     * @apiParam {string} subNameUp 菜单名
     * @apiParam {string} subENameUp 菜单英文名
     * @apiParam {string} subIconUp 菜单图标
     * @apiParam {string} subUrlUp 菜单地址
     * @apiParam {int} subId 菜单ID
     * @apiParam {string} _csrf_backend  CSRF验证
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "subNameUp": "会员管理",
     *        "subENameUp": "member",
     *        "subIconUp": "mm",
     *        "subUrlUp": "fheuhfrfbghbtuh",
     *        "subId": "3",
     *        "_csrf_backend":"_asjbbjkashdjkashdkashdkhasdhaskda=="
     *   }
     * @apiDescription 菜单管理 - 修改子菜单<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/17<br/>
     * <span><strong>调用方法：</strong></span>/menu/update-sub
     * @apiSampleRequest  http://qa.uniwlan.com/menu/update-sub
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"修改成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *  }
     */
    public function actionUpdateSub()
    {
//        \Yii::$app->cache->flush();
        $post  = \Yii::$app->request->post();
        $model = new SubModuleUpdate();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->updateModule();
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
     * @api{get} /menu/del-module 删除顶级菜单、子菜单
     * @apiVersion  1.0.0
     * @apiName 删除顶级菜单、子菜单
     * @apiGroup Menu
     * @apiPermission 管理员
     *
     * @apiParam {int} moduleId 菜单ID
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "moduleId": "3",
     *   }
     * @apiDescription 删除顶级菜单、子菜单<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/17<br/>
     * <span><strong>调用方法：</strong></span>/menu/del-module
     * @apiSampleRequest  http://qa.uniwlan.com/menu/del-module
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"删除成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *  }
     */
    public function actionDelModule()
    {
//        \Yii::$app->cache->flush();
        $id    = \Yii::$app->request->get('moduleId');
        $model = new ModuleForm();
        $data = $model->deleteModule($id);
        if ($data === true) {
            return json_encode(['status' => 'success', 'data' => '删除成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $data]);
        }
    }

    /**
     * @api{get} /menu/get-top-module 获取顶级菜单
     * @apiVersion  1.0.0
     * @apiName 获取顶级菜单
     * @apiGroup Menu
     * @apiPermission 管理员
     *
     * @apiDescription 菜单管理 - 获取顶级菜单<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/17<br/>
     * <span><strong>调用方法：</strong></span>/menu/get-top-module
     * @apiSampleRequest  http://qa.uniwlan.com/menu/get-top-module
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * Array
     * (
     * 'name' => string '会员管理'
     * 'e_name' => string 'member'
     * 'create_at' => '1496472588'
     * )
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionGetTopModule()
    {
        $model = new Module();
        $data  = $model->getTopModule(2);
        return json_encode(['data' => $data]);
    }

    /**
     * @api{get} /menu/get-sub-module 菜单管理 - 查询子菜单以及功能
     * @apiVersion  1.0.0
     * @apiName 菜单管理 - 查询子菜单以及功能
     * @apiGroup Menu
     * @apiPermission 管理员
     *
     * @apiParam {int} topId 菜单ID
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "topId": "3",
     *   }
     *
     * @apiDescription 菜单管理-查询子菜单以及功能<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/17<br/>
     * <span><strong>调用方法：</strong></span>/menu/get-sub-module
     * @apiSampleRequest  http://qa.uniwlan.com/menu/get-sub-module
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * Array
     * (
     * 'name' => string '会员管理'
     * 'e_name' => string 'member'
     * 'create_at' => '1496472588'
     * )
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionGetSubModule()
    {
        $id    = \Yii::$app->request->get('topId');
        $model = new ModuleFunctional();
        $data  = $model->getFuncByModule($id);
        return json_encode($data);
    }

    /**
     * @api{get} /menu/get-all-func 菜单管理 - 获取所有功能
     * @apiVersion  1.0.0
     * @apiName 菜单管理 - 获取所有功能
     * @apiGroup Menu
     * @apiPermission 管理员
     *
     * @apiDescription 菜单管理-获取所有功能<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/18<br/>
     * <span><strong>调用方法：</strong></span>/menu/get-all-func
     * @apiSampleRequest  http://qa.uniwlan.com/menu/get-all-func
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * Array
     * (
     * 'id' => '1'
     * 'name' => '新增'
     * )
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionGetAllFunc()
    {
        $model = new ModuleFunctional();
        $data  = $model->getAllFunc();
        return json_encode($data);
    }

    /**
     * @api{post} /menu/save-func 子菜单 - 保存功能
     * @apiVersion  1.0.0
     * @apiName 子菜单 - 保存功能
     * @apiGroup Menu
     * @apiPermission 管理员
     *
     * @apiParam {int} subId 菜单ID
     * @apiParam {int} funcId 功能ID (以数组的形式发送)
     *
     * @apiParamExample {json} Request Example
     *   {
     *        "subId": "3",
     *        "funcId": "[1,2,3]",
     *   }
     * @apiDescription 子菜单 - 保存功能<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/18<br/>
     * <span><strong>调用方法：</strong></span>/menu/save-func
     * @apiSampleRequest  http://qa.uniwlan.com/menu/save-func
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * {'status':'success','data':"保存成功"}
     *
     * @apiErrorExample {json} 错误示例:
     * {
     *   'status':'error',
     *  }
     */
    public function actionSaveFunc()
    {
//        \Yii::$app->cache->flush();
        $post  = \Yii::$app->request->post();
        $model = new ModuleFunctionalForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->saveFunc();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @api{get} /menu/get-func-data 子菜单 - 获取子菜单的功能
     * @apiVersion  1.0.0
     * @apiName 子菜单 - 获取子菜单的功能
     * @apiGroup Menu
     * @apiPermission 管理员
     *
     * @apiDescription 子菜单 - 获取子菜单的功能<br/>
     * <span><strong>作   者：</strong></span>朱梦珂<br/>
     * <span><strong>邮   箱：</strong></span>zhumengke@itsports.club<br/>
     * <span><strong>创建时间：</strong></span>2017/6/18<br/>
     * <span><strong>调用方法：</strong></span>/menu/get-func-data
     * @apiSampleRequest  http://qa.uniwlan.com/menu/get-func-data
     *
     * @apiSuccess(返回值) {string}  status 状态
     * @apiSuccess(返回值) {string}  data    提示数据
     *
     * @apiSuccessExample {json} 成功示例:
     * Array
     * ["3","4"]
     * @apiErrorExample {json} 错误示例:
     * {[]}
     */
    public function actionGetFuncData()
    {
        $id    = \Yii::$app->request->get('subId');
        $model = new ModuleFunctional();
        $data  = $model->getFuncData($id);
        return json_encode($data);
    }

    /**
     * @云运动 - 菜单管理 - 移动子菜单
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/28
     */
    public function actionMoveSubModule()
    {
        $post  = \Yii::$app->request->post();
        $model = new ModuleForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->moveSubModule();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @云运动 - 菜单管理 - 顶级菜单排序
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/28
     */
    public function actionTopSort()
    {
        $post  = \Yii::$app->request->post();
        $model = new ModuleForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->topSort();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @云运动 - 菜单管理 - 子菜单排序
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/8/28
     */
    public function actionSubSort()
    {
        $post  = \Yii::$app->request->post();
        $model = new ModuleForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->subSort();
            if ($data === true) {
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            } else {
                return json_encode(['status' => 'error', 'data' => $data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     *菜单管理 - 查看子菜单- 是否分配
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/11/24
     * @return bool|string
     */
    public function actionUpdateStatus()
    {
        $moduleId = \Yii::$app->request->get('moduleId');
        $status = Module::getUpdateModule($moduleId);
        if ($status === true) {
            return json_encode(['status' => 'success', 'data' => '分配成功']);
        } else {
            return json_encode(['status' => 'error', 'data' => $status]);
        }
    }
}
