<?php

namespace backend\controllers;

use backend\models\Approval;
use backend\models\ApprovalRole;
use backend\models\ApprovalType;
use backend\models\ApprovalTypeForm;
use backend\models\AddApprovalCommentForm;
use backend\models\ApprovalDetails;
use backend\models\Employee;
use backend\models\SmsRecordForm;
use backend\models\UpdateApprovalDetailForm;
use backend\rbac\models\AuthRoleModel;
use common\models\Func;

class ApprovalManagementController extends BaseController
{
    /**
     * date:2017-09-28 10:34
     * author :程丽明
     * content:审批管理待审批首页
     * */
    public function actionIndex()
    {
        return $this->render('index');
    }
    /**
     * @date:2017-09-28 10:34
     * @author :程丽明
     * @param  $id;
     * @content:业务后台 - 审核管理 - 获取审批详情数据
     * @return  array
     */
    public function actionGetApprovalDetailsDataById($id)
    {
        $approval = new ApprovalDetails();
        $create   = new SmsRecordForm();
        $data     = $approval->getApprovalDetailsDataById($id);
        return    json_encode(['data'=>$data,'coach'=>$create->getCreate()]);
    }
    /**
     * 业务后台- 审核管理 - 添加评论
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/08/07
     * @return string
     */
    public function actionAddApprovalComment(){
        $post  = \Yii::$app->request->post();
        $model  = new AddApprovalCommentForm();
        if($model->load($post,'') && $model->validate()){
            $edit = $model->saveComment();
            if($edit===true){
                return json_encode(['status'=>'success','data'=>$edit]);
            }else{
                return json_encode(['status'=>'error','data'=>$edit]);
            }
        }
        return json_encode(['status'=>'error','data'=>$model->errors]);
    }
    /**
     * 业务后台- 审核管理 - 修改详情
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/08/07
     * @return string
     */
    public function actionAddApprovalDetails(){
        $post  = \Yii::$app->request->post();
        $model  = new UpdateApprovalDetailForm();
        if($model->load($post,'') && $model->validate()){
            $edit = $model->saveApprovalDetails();
            if($edit===true){
                return json_encode(['status'=>'success','data'=>$edit]);
            }else{
                return json_encode(['status'=>'error','data'=>$edit]);
            }
        }
        return json_encode(['status'=>'error','data'=>$model->errors]);
    }

    /**
     * date:2017-09-28 14:34
     * author :程丽明
     * content:已审批页面
     * */
    public function actionAlready()
    {
        return $this->render('alreadyApproval');
    }

    /**
     * date:2017-09-28 21:00
     * author :程丽明
     * content:我发起的页面
     * */
    public function actionLaunch()
    {
        return $this->render('myLaunchApproval');
    }

    /**
     * date:2017-09-28 21:00
     * author :程丽明
     * content:抄送我的页面
     * */
    public function actionSend()
    {
        return $this->render('approvalSendMe');
    }

    /**
     * date:2017-09-28 14:34
     * author :程丽明
     * content:审批管理设置审批流程
     * */
    public function actionSet()
    {
        return $this->render('setApprovalProcess');
    }

    /**
     * @后台 - 卡种审核 - 获取审批列表数据
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/9/28
     * @return array
     */
    public function actionGetApprovalDataList()
    {
        $params      = \Yii::$app->request->queryParams;
        $model       = new Approval();
        if(isset($params['page'])){
            $nowPage = $params['page'];
        }else{
            $nowPage = 1;
        }
        $data        = $model->getApprovalData($params);
        $pagination  = $data->pagination;
        $pages       = Func::getPagesFormat($pagination);
        return json_encode(['data'=>$data->models,'pages'=>$pages,'now'=>$nowPage]);
    }

    /**
     * @后台 - 卡种审核 - 获取审批类型
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/28
     * @return array
     */
    public function actionGetApprovalType()
    {
        $model = new ApprovalType();
        $data  = $model->getApprovalTypeData($this->venueId);
        return json_encode($data);
    }

    /**
     * @后台 - 卡种审核 - 设置审批流程(保存审批人、抄送人数据)
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/28
     * @return boolean
     */
    public function actionSetApprovalProcess()
    {
        $post  = \Yii::$app->request->post();
        $model = new ApprovalTypeForm();
        if ($model->load($post, '') && $model->validate()) {
            $data = $model->setApprovalProcess($this->companyId,$this->venueId);
            if($data === true){
                return json_encode(['status' => 'success', 'data' => '保存成功']);
            }else{
                return json_encode(['status' => 'error', 'data' =>$data]);
            }
        } else {
            return json_encode(['status' => 'error', 'data' => $model->errors]);
        }
    }

    /**
     * @后台 - 卡种审核 - 获取公司下的角色
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/28
     * @return array
     */
    public function actionGetRole()
    {
        $id = \Yii::$app->request->get('companyId');
        if(!empty($id)){
            $auth_role = AuthRoleModel::find()
                ->select(['id', 'name', 'status'])
                ->where(['company_id' => $id])
                ->asArray()
                ->all();
            return json_encode($auth_role);
        }else{
            return false;
        }
    }

    /**
     * @后台 - 卡种审核 - 获取部门下的员工
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/28
     * @return array
     */
    public function actionGetEmployee()
    {
        $id = \Yii::$app->request->get('departmentId');
        if(!empty($id)){
            $model = new Employee();
            $data  = $model->getEmployeeByDepartment($id);
            return json_encode($data);
        }else{
            return false;
        }
    }

    /**
     * @后台 - 卡种审核 - 获取审批人、抄送人数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/29
     * @return array
     */
    public function actionGetApprovalRole()
    {
        $params = \Yii::$app->request->get();
        $params['venueId'] = $this->venueId;
        if(isset($params['appType']) && !empty($params['appType']) && isset($params['roleType']) && !empty($params['roleType'])){
            $model = new ApprovalRole();
            $data  = $model->getApprovalRoleData($params);
            return json_encode($data);
        }else{
            return false;
        }
    }

    /**
     * @后台 - 卡种审核 - 删除审批人、抄送人数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/29
     * @return boolean
     */
    public function actionDelApprovalRole()
    {
        $id = \Yii::$app->request->get('appRoleId');
        if(!empty($id)){
            $model = new ApprovalRole();
            $data  = $model->delApprovalRole($id);
            if($data === true){
                return json_encode(['status'=>'success','data'=>'删除成功']);
            }else{
                return json_encode(['status'=>'error','data'=>'删除失败,有待审核的流程']);
            }
        }
    }

    /**
     * @后台 - 卡种审核 - 审核
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/9/29
     * @return boolean
     */
    public function actionCanApprovalRole()
    {
        $typeId = \Yii::$app->request->get('typeId');
        $id     = \Yii::$app->request->get('id');
        $model    = new Approval();
        $create   = new SmsRecordForm();
        $data     = $model->canRoleById($typeId,$id);
        if(!empty($data) && in_array($create->getCreate(),$data['approvalRoleId']) && $create->getCreate() == $data['approvalDetails']['approver_id']){
            return json_encode(['status'=>'success','data'=>true]);
        }else{
            return json_encode(['status'=>'error','data'=>false]);
        }
    }
}
