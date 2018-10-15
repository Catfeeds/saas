<?php

namespace backend\controllers;

use backend\models\AboutClass;
use backend\models\EntryRecord;
class SummingSumController extends BaseController
{

    /**
     *对外服务 - 营运管理 -  近30天进馆记录
     * @author Zhang dong xu <zhangdongxu@itsports.club>
     * @create 2018/6/22
     * @param $params
     * @return bool|string
     */
    public function actionGetMemberEntryRecordSum()
    {
        $id = \Yii::$app->request->get('id');
        $statistics = [];
        $member = new EntryRecord();
        $memberabout = new AboutClass();
        $venueId = $this->venueId;
        $data   = $member->getEntryArrSum($id,$venueId);
        $list = $memberabout->getAboutClassSum($id);
        $statistics['enter'] = $data;
        $statistics['course'] = $list;
        return json_encode(['status'=>'success','data'=>$statistics]);
    }


}
