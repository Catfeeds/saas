<?php

namespace backend\controllers;
//use backend\models\DockMemberExcel;
//use backend\models\DockMemberCardExcel;
//use backend\models\DockLogExcel;
//use backend\models\DockEmployeeExcel;
//use backend\models\DockCourseOrderExcel;
//use backend\models\DockCabinetExcel;
//use backend\models\DockLeaveRecordExcel;
//use backend\models\DockClassLogExcel;
//use backend\models\DockCardChangeLogExcel;

use backend\models\{DockEmployeeExcel,DockLogExcel,DockMemberExcel,DockMemberCardExcel,DockCardChangeLogExcel, DockClassLogExcel, DockLeaveRecordExcel, DockCabinetExcel, DockCourseOrderExcel};
use common\models\Func;

use yii;
class DataImportController extends \backend\controllers\BaseController
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    public  function actionTest(){
        $serv = new \swoole_server("127.0.0.1", 9501);

        //监听连接进入事件
        $serv->on('connect', function ($serv, $fd) {
            echo "Client: Connect.\n";
        });

        //监听数据接收事件
        $serv->on('receive', function ($serv, $fd, $from_id, $data) {
            $serv->send($fd, "Server: ".$data);
        });

        //监听连接关闭事件
        $serv->on('close', function ($serv, $fd) {
            echo "Client: Close.\n";
        });

        //启动服务器
        $serv->start();

    }


    /**
     * @desc:数据导入功能
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/9
     * @time: 9:24
     * @param $filePath  文件路径
     * @type  类型   1是员工|2是会员|3是会员卡|4是课程订单|5是柜子表|6是会员请假|7是私教上课记录|8是会员卡行为记录
     * @param $filename   文件名称
     * @param $repeat  是否重复  0是  1 否
     * @return string
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \yii\db\Exception
     */
    public function actionMemberExport(){
        if(\Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $companyId = $this->companyId;//获取当前公司Id

            if(empty($companyId)){
                return json_encode(['status' => 'error','data' => '请先分配所属公司']);
            }

            $model = new DockMemberExcel();
            $re = $model->loadFileContent( $post['filePath'],  $post['type'],  $post['filename'],  $post['repeat'], $companyId);
            if($re === true){
                return json_encode(['status' => 'success','data' => '导入成功']);
            }else{
                return json_encode(['status' => 'error','data' => $re]);
            }
        }

    }

    /**
     * @desc:导入数据列表
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/8
     * @time: 19:24
     * @keyword  关键词
     * @type  类型   1是员工|2是会员|3是会员卡|4是课程订单|5是柜子表|6是会员请假|7是私教上课记录|8是会员卡行为记录
     * @check_status 数据状态
     * @return string
     * @throws \Exception
     */
    public function actionDataList(){
        $params        =  \Yii::$app->request->queryParams;

        $companyId = $this->companyId;//获取当前公司Id
        if($params['type'] == 1){

            $model = new DockEmployeeExcel();
            $dataProvider = $model->employeeList($params, $companyId);
            $pages         = Func::getPagesFormat($dataProvider->pagination);
            return json_encode(['data'=>$dataProvider->models,'pages'=>$pages]);

        }else if($params['type'] == 2){

            $model = new DockMemberExcel();
            $dataProvider = $model->memberList($params, $companyId);
            $pages         = Func::getPagesFormat($dataProvider->pagination);
            return json_encode(['data'=>$dataProvider->models,'pages'=>$pages]);

        }else if($params['type'] == 3){
            $model = new DockMemberCardExcel();
            $dataProvider = $model->memberCardList($params, $companyId);
            $pages         = Func::getPagesFormat($dataProvider->pagination);
            return json_encode(['data'=>$dataProvider->models,'pages'=>$pages]);
        }else if($params['type'] == 4){
            $model = new DockCourseOrderExcel();
            $dataProvider = $model->courseOrderList($params, $companyId);
            $pages         = Func::getPagesFormat($dataProvider->pagination);
            return json_encode(['data'=>$dataProvider->models,'pages'=>$pages]);
        }else if($params['type'] == 5){
            $model = new DockCabinetExcel();
            $dataProvider = $model->cabinetList($params, $companyId);
            $pages         = Func::getPagesFormat($dataProvider->pagination);
            return json_encode(['data'=>$dataProvider->models,'pages'=>$pages]);
        }else if($params['type'] == 6){
            $model = new DockLeaveRecordExcel();
            $dataProvider = $model->leaveRecordList($params, $companyId);
            $pages         = Func::getPagesFormat($dataProvider->pagination);
            return json_encode(['data'=>$dataProvider->models,'pages'=>$pages]);
        }else if($params['type'] == 7){
            $model = new DockClassLogExcel();
            $dataProvider = $model->classLogList($params, $companyId);
            $pages         = Func::getPagesFormat($dataProvider->pagination);
            return json_encode(['data'=>$dataProvider->models,'pages'=>$pages]);
        }else if($params['type'] == 8){
            $model = new DockCardChangeLogExcel();
            $dataProvider = $model->cardChangeLogList($params, $companyId);
            $pages         = Func::getPagesFormat($dataProvider->pagination);
            return json_encode(['data'=>$dataProvider->models,'pages'=>$pages]);
        }

    }


    /**
     * @desc:数据编辑
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/9
     * @time: 11:47
     */
    public  function actionDataEdit(){
        $post        =  \Yii::$app->request->post();

        if($post['type'] == 1){
            $DockEmployeeExcel = new DockEmployeeExcel();
            $res = $DockEmployeeExcel-> employeeEdit($post);
        }elseif ($post['type'] == 2){
            $DockMemberExcel = new DockMemberExcel();
            $res = $DockMemberExcel-> memberEdit($post);
        }elseif ($post['type'] == 3){
            $model = new DockMemberCardExcel();
            $res = $model-> memberCardEdit($post);
        }elseif ($post['type'] == 4){
            $model = new DockCourseOrderExcel();
            $res = $model-> courseOrderEdit($post);
        }elseif ($post['type'] == 5){
            $model = new DockCabinetExcel();
            $res = $model-> cabinetEdit($post);
        }elseif ($post['type'] == 6){
            $model = new DockLeaveRecordExcel();
            $res = $model-> leaveRecordEdit($post);
        }elseif ($post['type'] == 7){
            $model = new DockClassLogExcel();
            $res = $model-> classLogEdit($post);
        }elseif ($post['type'] == 8){
            $model = new DockCardChangeLogExcel();
            $res = $model-> cardChangeLogEdit($post);
        }

        if($res){
            return json_encode(['status' => 'success','data' => '编辑成功']);

        }else{
            return json_encode(['status' => 'error','data' => '编辑失败']);
        }
    }

    /**
     * @desc:单个数据的删除
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/22
     * @time: 16:49
     */
    public function actionDataDelete(){
        $post        =  \Yii::$app->request->get();
        if($post['type'] == 1){
            $model = new DockEmployeeExcel();
        }elseif ($post['type'] == 2){
            $model = new DockMemberExcel();
        }elseif ($post['type'] == 3){
            $model = new DockMemberCardExcel();
        }elseif ($post['type'] == 4){
            $model = new DockCourseOrderExcel();
        }elseif ($post['type'] == 5){
            $model = new DockCabinetExcel();
        }elseif ($post['type'] == 6){
            $model = new DockLeaveRecordExcel();
        }elseif ($post['type'] == 7){
            $model = new DockClassLogExcel();
        }elseif ($post['type'] == 8){
            $model = new DockCardChangeLogExcel();
        }

        $res = $model->updateAll(['is_delete' => 1],['id' => $post['id']]);

        if($res){
            return json_encode(['status' => 'success','data' => '删除成功']);

        }else{
            return json_encode(['status' => 'error','data' => '删除失败']);
        }


    }

    /**
     * @desc:清空数据
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/12
     * @type  类型   1是员工|2是会员|3是会员卡|4是课程订单|5是柜子表|6是会员请假|7是私教上课记录|8是会员卡行为记录
     * @time: 18:49
     * @return string
     */
    public function  actionDataDel(){
        $type        =  \Yii::$app->request->get('type');
        $companyId = $this->companyId;//获取当前公司Id

        if($type == 1){
            $DockEmployeeExcel = new DockEmployeeExcel();
            $res = $DockEmployeeExcel->updateAll(['is_delete' => 1],['company_id' => $companyId]);
        }elseif ($type == 2){
            $DockMemberExcel = new DockMemberExcel();
            $res = $DockMemberExcel->updateAll(['is_delete' => 1],['company_id' => $companyId]);
        }elseif ($type == 3){
            $model = new DockMemberCardExcel();
            $res = $model->updateAll(['is_delete' => 1],['company_id' => $companyId]);
        }elseif ($type == 4){
            $model = new DockCourseOrderExcel();
            $res = $model->updateAll(['is_delete' => 1],['company_id' => $companyId]);
        }elseif ($type == 5){
            $model = new DockCabinetExcel();
            $res = $model->updateAll(['is_delete' => 1],['company_id' => $companyId]);
        }elseif ($type == 6){
            $model = new DockLeaveRecordExcel();
            $res = $model-> updateAll(['is_delete' => 1],['company_id' => $companyId]);
        }elseif ($type == 7){
            $model = new DockClassLogExcel();
            $res = $model-> updateAll(['is_delete' => 1],['company_id' => $companyId]);
        }elseif ($type == 8){
            $model = new DockCardChangeLogExcel();
            $res = $model-> updateAll(['is_delete' => 1],['company_id' => $companyId]);
        }

        if($res){
            return json_encode(['status' => 'success','data' => '清除成功']);

        }else{
            return json_encode(['status' => 'error','data' => '清除失败']);
        }
    }

    /**
     * @desc:数据校对
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/12
     * @type  类型   1是员工|2是会员|3是会员卡|4是课程订单|5是柜子表|6是会员请假|7是私教上课记录|8是会员卡行为记录
     * @time: 20:52
     * @return string
     */
    public function actionModify(){
        set_time_limit(0);
        $type        =  \Yii::$app->request->post('type');
        $companyId = $this->companyId;//获取当前公司Id
        if($type == 1){
            $DockEmployeeExcel = new DockEmployeeExcel();
            $res = $DockEmployeeExcel->employeeModify($companyId);
        }elseif ($type == 2){
            $DockMemberExcel = new DockMemberExcel();
            $res = $DockMemberExcel->memberModify($companyId);
        }elseif ($type == 3){
            $model = new DockMemberCardExcel();
            $res = $model->memberCardModify($companyId);
        }elseif ($type == 4){
            $model = new DockCourseOrderExcel();
            $res = $model->courseOrderModify($companyId);
        }elseif ($type == 5){
            $model = new DockCabinetExcel();
            $res = $model->cabinetModify($companyId);
        }elseif ($type == 6){
            $model = new DockLeaveRecordExcel();
            $res = $model-> leaveRecordModify($companyId);
        }elseif ($type == 7){
            $model = new DockClassLogExcel();
            $res = $model-> classLogModify($companyId);
        }elseif ($type == 8){
            $model = new DockCardChangeLogExcel();
            $res = $model-> cardChangeLogModify($companyId);
        }

        if($res == true){
            return json_encode(['status' => 'success','data' => '校对成功']);

        }else{
            return json_encode(['status' => 'error','data' => '校对失败']);
        }

    }

    /**
     * @desc:数据导入日志表
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/9
     * @time: 10:16
     * @return string
     */
    public  function actionDockLogList(){
        $companyId = $this->companyId;//获取当前公司Id
        $DockLogExcel = new DockLogExcel();
        $data = $DockLogExcel->dockList($companyId);
        return json_encode(['data'=>$data,'pages'=>'']);
    }

    /**
     * @desc:上传EXCEl文件
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/11
     * @time: 14:20
     * @return string
     * @throws \Exception
     */
    public function actionUpload()
    {
        $data = Func::uploadExcel();
        return $data;
    }


    /**
     * @desc:下载文件
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/12
     * @time: 11:00
     */
    public function actionFileDown(){
        header("Content-type: text/html;charset=utf-8");
        $file_name = '数据导入模板.xlsx';
//        $encode = mb_detect_encoding('', array('GB2312','GBK','UTF-8'));
//        if($encode != 'GBK'){
//            $file_name = iconv("UTF-8","GBK",$file_name);
//        }

        $file_sub_path =\Yii::$app->basePath . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR .'module'.DIRECTORY_SEPARATOR ;
        $file_path = $file_sub_path.$file_name;
//        echo $file_path;die;
        @chmod($file_path,0777);

        if (!file_exists($file_path)){  //判断文件是否存在
            echo "文件不存在";
            exit();
        }
        $fp = fopen($file_path,"r+") or die('打开文件错误');   //下载文件必须要将文件先打开。写入内存
        $file_size = filesize($file_path);  //返回的文件流
        Header("Content-type:application/octet-stream");    //按照字节格式返回
        Header("Accept-Ranges:bytes");  //返回文件大小
        Header("Accept-Length:".$file_size);    //弹出客户端对话框，对应的文件名
        Header("Content-Disposition:attachment;filename=".$file_name);  //防止服务器瞬间压力增大，分段读取
        $buffer = 1024;
        while(!feof($fp)){
            $file_data = fread($fp,$buffer);
            echo $file_data;
        }
        fclose($fp);
    }

    /**
     * @desc:业务校对
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/25
     * @time: 17:39
     */
    public  function actionProfessionModify(){
        set_time_limit(0);
        $type        =  \Yii::$app->request->post('type');
        $companyId = $this->companyId;//获取当前公司Id
        if($type == 1){
            $DockEmployeeExcel = new DockEmployeeExcel();
            $res = false;
        }elseif ($type == 2){
            $DockMemberExcel = new DockMemberExcel();
            $res = false;
        }elseif ($type == 3){
            $model = new DockMemberCardExcel();
            $res = $model->memberCardRevise($companyId);
        }elseif ($type == 4){
            $model = new DockCourseOrderExcel();
            $res = $model->courseOrderRevise($companyId);
        }elseif ($type == 5){
            $model = new DockCabinetExcel();
            $res = false;
        }elseif ($type == 6){
            $model = new DockLeaveRecordExcel();
            $res = $model->leaveRecordRevise($companyId);
        }elseif ($type == 7){
            $model = new DockClassLogExcel();
            $res = false;
        }elseif ($type == 8){
            $model = new DockCardChangeLogExcel();
            $res = false;
        }
        
        if($res == true){
            return json_encode(['status' => 'success','data' => '校对成功']);

        }else{
            return json_encode(['status' => 'error','data' => '校对失败']);
        }

    }


    /**
     * @desc:数据同步
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/19
     * @time: 16:49
     * @type  类型   1是员工|2是会员|3是会员卡|4是课程订单|5是柜子表|6是会员请假|7是私教上课记录|8是会员卡行为记录
     * @return string
     * @throws yii\base\Exception
     * @throws yii\db\Exception
     */
    public function actionDataDock(){
//        echo memory_get_usage();//查看当前内存

        set_time_limit(0);
        $type        =  \Yii::$app->request->get('type');
        $companyId = $this->companyId;//获取当前公司Id

        if($type == 1){
            $DockEmployeeExcel = new DockEmployeeExcel();
            $res = $DockEmployeeExcel->employeeDock($companyId);
        }elseif ($type == 2){
            $DockMemberExcel = new DockMemberExcel();
            $res = $DockMemberExcel->memberDock($companyId);
        }elseif ($type == 3){
            $model = new DockMemberCardExcel();
            $res = $model->memberCardDock($companyId);
        }elseif ($type == 4){
            $model = new DockCourseOrderExcel();
            $res = $model->courseOrderDock($companyId);
        }elseif ($type == 5){
            $model = new DockCabinetExcel();
            $res = $model->cabinetDock($companyId);
        }elseif ($type == 6){
            $model = new DockLeaveRecordExcel();
            $res = $model-> leaveRecordDock($companyId);
        }elseif ($type == 7){
            $model = new DockClassLogExcel();
            $res = $model-> classLogDock($companyId);
        }elseif ($type == 8){
            $model = new DockCardChangeLogExcel();
            $res = $model-> cardChangeLogDock($companyId);
        }

        if($res === true){
            return json_encode(['status' => 'success','data' => '同步成功']);

        }else{
            return json_encode(['status' => 'error','data' => $res]);
        }
    }

}
