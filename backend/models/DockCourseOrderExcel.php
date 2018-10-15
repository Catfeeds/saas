<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/6/12
 * Time: 11:37
 */

namespace backend\models;

use common\models\base\DockCourseOrder;
use common\models\Excel;
use backend\models\DockLogExcel;
use yii\base\Model;
use backend\models\MemberCourseOrder;
use backend\models\MemberCourseOrderDetails;
use common\models\Func;
use Yii;

class DockCourseOrderExcel extends DockCourseOrder
{


    /**
     * @desc:过滤和导入原始数据
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/8
     * @time: 18:57
     * @param $data
     * @param $filename
     * @param $repeat
     * @return bool|string
     * @throws \yii\db\Exception
     */
    public function organizeCourseOrderData($data,$filename, $repeat, $companyId){
        //数据去重复值
        if($repeat == 2){
            $temp = Func::arrDropRepeat($data);
        }else{
            $temp = $data;//不去重复
        }
//        var_dump($data);die;
        $arr = [];
        foreach ($temp as $key => $value){
            $arr[$key]['course_nums'] = (int)$value[0];
            $arr[$key]['order_time'] = $value[1]  ? : null;
            $arr[$key]['total_money'] = (float)$value[2];
            $arr[$key]['reamain_nums'] = (int)$value[3];
            $arr[$key]['over_time'] = $value[4]  ? : null;
            $arr[$key]['course_name'] = $value[5];
            $arr[$key]['course_type'] = $value[6];
            $arr[$key]['bill_type'] = $value[7];
            $arr[$key]['class_type'] = $value[8];
            $arr[$key]['class_share'] = $value[9];
            $arr[$key]['coach_name'] = $value[10];
            $arr[$key]['send_nums'] = (int)$value[11];
            $arr[$key]['product_name'] = $value[12];
            $arr[$key]['card_number'] = $value[13];
            $arr[$key]['casd_type'] = $value[14];
            $arr[$key]['casd_number'] = $value[15];
            $arr[$key]['counselor_name'] = $value[16];
            $arr[$key]['start_time'] = $value[17]  ? : null;
//            $arr[$key]['sell_people_name'] = $value[18];
            $arr[$key]['payee_name'] = $value[18];
            $arr[$key]['order_status'] = $value[19];
            $arr[$key]['note'] = $value[20];
            $arr[$key]['limit_days'] = (int)$value[21];
            $arr[$key]['single_original_price'] = (float)$value[22];
            $arr[$key]['single_sell_price'] = (float)$value[23];
            $arr[$key]['single_pos_price'] = (float)$value[24];
            $arr[$key]['single_long'] = (int)$value[25];
            $arr[$key]['transfer_limit'] = (int)$value[26];
            $arr[$key]['transfer_money'] = (float)$value[27];
            $arr[$key]['deal_name'] = $value[28];
            $arr[$key]['company_id'] = $companyId;

            //判断数据的有效性
            if(empty($arr[$key]['course_nums']) || empty($arr[$key]['order_time']) || empty($arr[$key]['total_money']) || empty($arr[$key]['reamain_nums']) || empty($arr[$key]['course_name']) || empty($arr[$key]['product_name']) || empty($arr[$key]['card_number'])|| empty($arr[$key]['single_original_price'])){
                $arr[$key]['check_status'] = 2;
            }else{
                $arr[$key]['check_status'] = 1;
            }
        }

//        var_dump($arr);die;
        //过滤空数据
        foreach ($arr as $k => $v){
            if(empty($v['total_money']) && empty($v['course_nums'])){
                unset($arr[$k]);
            }
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try{

            //数据的批量插入
            $fields = ['course_nums', 'order_time', 'total_money', 'reamain_nums', 'over_time', 'course_name','course_type', 'bill_type', 'class_type','class_share', 'coach_name', 'send_nums', 'product_name', 'card_number','casd_type', 'casd_number', 'counselor_name', 'start_time', 'payee_name', 'order_status', 'note', 'limit_days', 'single_original_price', 'single_sell_price', 'single_pos_price', 'single_long', 'transfer_limit', 'transfer_money','deal_name', 'company_id' , 'check_status'];
            if($arr && $fields){
                Yii::$app->db->createCommand() ->batchInsert(DockCourseOrder::tableName(),$fields,$arr)->execute();
            }

            $DockLogExcel = new DockLogExcel();
            $DockLogExcel->dockLogAdd( $filename, $companyId);

            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }

        } catch (\Exception $e) {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            return  $e->getMessage();
        }

    }

    /**
     * @desc:导入y员工卡数据列表
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/13
     * @time: 17:33
     * @param $params
     * @param $companyId
     * @return \yii\data\ActiveDataProvider
     */
    public function courseOrderList($params, $companyId){
        $keyword = !empty($params['keyword']) ? $params['keyword'] : '';
        $check_status = !empty($params['check_status']) ? $params['check_status'] : '';

        $query = DockCourseOrder::find()
            ->where(['company_id' => $companyId, 'is_delete' => 0])
            ->orderBy('id DESC')
            ->asArray();
        //筛选条件
        if($keyword){
            $query->andFilterWhere([
                'or',
                ['like','course_name',$keyword],
                ['like','product_name',$keyword],
                ['like','counselor_name',$keyword],
                ['like','card_number',$keyword],
            ]);
        }
        $query->andFilterWhere(['check_status'=>$check_status]);
        $data  = Func::getDataProvider($query,12);

        return $data;
    }


    public function courseOrderEdit($post){
        $info = DockCourseOrder::findOne($post['id']);

        $info->course_nums = $post['course_nums'];
        $info->order_time = $post['order_time'];
        $info->total_money = $post['total_money'];
        $info->reamain_nums = $post['reamain_nums'];
        $info->over_time = $post['over_time'];
        $info->course_name = $post['course_name'];
        $info->course_type = $post['course_type'];
        $info->bill_type = $post['bill_type'];
        $info->class_type = $post['class_type'];
        $info->class_share = $post['class_share'];
        $info->coach_name = $post['coach_name'];
        $info->send_nums = $post['send_nums'];
        $info->product_name = $post['product_name'];
        $info->card_number = $post['card_number'];
        $info->casd_type = $post['casd_type'];
        $info->casd_number = $post['casd_number'];
        $info->counselor_name = $post['counselor_name'];
        $info->start_time = $post['start_time'];
        $info->sell_people_name = $post['sell_people_name'];
        $info->payee_name = $post['payee_name'];
        $info->order_status = $post['order_status'];
        $info->note = $post['note'];
        $info->limit_days = $post['limit_days'];
        $info->single_original_price = $post['single_original_price'];
        $info->single_sell_price = $post['single_sell_price'];
        $info->single_pos_price = $post['single_pos_price'];
        $info->single_long = $post['single_long'];
        $info->transfer_limit = $post['transfer_limit'];
        $info->transfer_money = $post['transfer_money'];
        $info->deal_name = $post['deal_name'];
        $info->check_status = 1;

        if($info->save()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @desc:数据校对
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/12
     * @time: 19:52
     * @return bool
     */
    public function courseOrderModify($companyId){
        $query = DockCourseOrder::find()->where(['company_id' => $companyId, 'is_delete' => 0])->asArray()->all();
        $DockLogExcel = new DockLogExcel();

        if(empty($query)){
            return false;
        }
        $correct = [];
        $error = [];
        foreach ($query as $key => $value){
            $is_require = false;
            $is_employee = true;
            $is_card_member = false;
            $is_deal = true;
            //校对卡号
            $is_card_member =$DockLogExcel::memberCardNumModify($companyId, $value['card_number']);

            //校对合同
//            $is_deal = $DockLogExcel::dealModify($companyId, '', $value['deal_name']);

            //校对销售
//            $is_employee = $DockLogExcel::employeeModify($companyId, $value['counselor_name']);

            //验证必填项
            if($value['course_nums'] && $value['order_time'] && $value['total_money'] && $value['reamain_nums'] && $value['course_name'] && $value['product_name'] && $value['card_number'] && $value['single_original_price']  ){
                $is_require = true;
            }

            if($is_require && $is_card_member && $value['check_status'] != 1){
                $correct[$key] = $value['id'];
            }else if(($is_require == false || $is_card_member == false ) && $value['check_status'] != 2){
                $error[$key] = $value['id'];
            }
        }

        if(!empty($correct)){
            DockCourseOrder::updateAll(['check_status' => 1],['in', 'id', array_values($correct)]);
        }

        if(!empty($error)){
            DockCourseOrder::updateAll(['check_status' => 2],['in', 'id', array_values($error)]);
        }

        return true;
    }

    /**
     * @desc:同步数据
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/29
     * @time: 16:13
     * @param $companyId
     * @return bool|string
     */
    public function courseOrderDock($companyId){

        $DockLogExcel = new DockLogExcel();

        if($DockLogExcel::courseOrderModify($companyId) != true){
            return "基本设置不完全！";
        }

        //查询正常数据
        $id = 0;
        $limit = 10;
        $ids = [];

        while (true) {
            $query = new \yii\db\Query();
            $result = $query->from(DockCourseOrder::tableName())
                ->where(['company_id' => $companyId, 'is_delete' => 0,'check_status' => 1])
                ->andWhere(['>', 'id', $id])
                ->orderBy('id asc')
                ->limit($limit)
                ->all();
            $resultCount = count($result);
            if ($resultCount == 0) {
                break;
            }
            $id = $result[$resultCount - 1]['id'];

            foreach ($result as $key => $value) {
                $DockLogExcel = new DockLogExcel();
                $MemberCourseOrder = new MemberCourseOrder();
                $MemberCourseOrderDetails = new MemberCourseOrderDetails();

                $charge_info = $DockLogExcel::chargeClassInfo($companyId, $value['course_name']);
                $course_id = !empty($charge_info) ? $charge_info['id'] : 0;
                $course_length = !empty($charge_info) ? $charge_info['course_length'] : 0;

                $card_id = $DockLogExcel::memberCardId($companyId,$value['card_number']);
                $course_info = $DockLogExcel::getCourseInfo($companyId, $value['course_name']);

                $employee_id = $DockLogExcel::employeeModify($companyId, $value['coach_name']);
                $seller_id = $DockLogExcel::employeeModify($companyId, $value['counselor_name']);
                $member_id = $DockLogExcel::memberCardNumModify($companyId,$value['card_number']);
                $charge_person_id = $DockLogExcel::employeeModify($companyId, $value['payee_name']);
                $deal_id = $DockLogExcel::dealModify($companyId,'', $value['deal_name']);

//                $venue_id = $DockLogExcel::venueModify($companyId, $value['venue']);
                $MemberCourseOrder->course_amount = $value['course_nums'];
                $MemberCourseOrder->create_at = strtotime($value['order_time']);
                $MemberCourseOrder->money_amount = $value['total_money'];
                $MemberCourseOrder->overage_section = $value['reamain_nums'];
//                $MemberCourseOrder->deadline_time = strtotime($value['over_time']);
                $MemberCourseOrder->deadline_time = strtotime($value['over_time']) ?: 0;
                $MemberCourseOrder->product_name = $value['course_name'];
                $MemberCourseOrder->product_id = $course_id;
                $MemberCourseOrder->product_type = $DockLogExcel::courseType($value['course_type']);
                $MemberCourseOrder->charge_mode = $DockLogExcel::chargeMode($value['bill_type']);
                $MemberCourseOrder->class_mode = $DockLogExcel::classMode($value['class_type']);
                $MemberCourseOrder->is_same_class = $DockLogExcel::isSameClass($value['class_share']);
                $MemberCourseOrder->private_id = $employee_id != false ? $employee_id : 0;
                $MemberCourseOrder->present_course_number = $value['send_nums'];
                $MemberCourseOrder->surplus_course_number = 0;
                $MemberCourseOrder->cashier_type = $DockLogExcel::cashierType($value['casd_type']);
                $MemberCourseOrder->service_pay_id = $course_id;
                $MemberCourseOrder->member_card_id = $card_id != false ? $card_id : 0;
                $MemberCourseOrder->seller_id = $seller_id != false ? $seller_id : 0;
                $MemberCourseOrder->cashierOrder = $value['casd_number'];
                $MemberCourseOrder->member_id = $member_id != false ? $member_id : 0;
                $MemberCourseOrder->business_remarks = '';
                $MemberCourseOrder->note = $value['note'];
                $MemberCourseOrder->activeTime = strtotime($value['start_time']) ?: 0;
                $MemberCourseOrder->chargePersonId = $charge_person_id != false ? $charge_person_id : 0;
                $MemberCourseOrder->pay_status = 1;
//                $MemberCourseOrder->venue_id = $venue_id != false ? $venue_id : 0;
                $MemberCourseOrder->company_id = $companyId;

                if($MemberCourseOrder->save() && $MemberCourseOrder->id){
                    $MemberCourseOrderDetails->course_order_id = $MemberCourseOrder->id;
                    $MemberCourseOrderDetails->course_id = $course_id;
                    $MemberCourseOrderDetails->course_num = $value['course_nums'];
                    $MemberCourseOrderDetails->course_length = $value['limit_days'];
                    $MemberCourseOrderDetails->original_price = $value['single_original_price'];
                    $MemberCourseOrderDetails->sale_price = $value['single_sell_price'];
                    $MemberCourseOrderDetails->pos_price = $value['single_pos_price'];
                    $MemberCourseOrderDetails->type =  $DockLogExcel::courseType($value['course_type']);
                    $MemberCourseOrderDetails->product_name = $value['course_name'];
                    $MemberCourseOrderDetails->course_name = $value['course_name'];
                    $MemberCourseOrderDetails->class_length = (int)$value['single_long'] ?: $course_length;
                    $MemberCourseOrderDetails->pic = !empty($charge_info) ? $charge_info['pic'] : '';
                    $MemberCourseOrderDetails->desc = !empty($charge_info) ? $charge_info['describe'] : '';
                    $MemberCourseOrderDetails->product_type = !empty($charge_info) ? $charge_info['product_type'] : '';
//                    $MemberCourseOrderDetails->activated_time = $value['single_long'];
                    $MemberCourseOrderDetails->transfer_num = $value['transfer_limit'];
                    $MemberCourseOrderDetails->transfer_price = $value['transfer_money'];
                    $MemberCourseOrderDetails->deal_id = $deal_id != false ? $deal_id : 0;
                    $MemberCourseOrderDetails->category = 2;

                    if($MemberCourseOrderDetails->save() && $MemberCourseOrderDetails->id){
                        unset($MemberCourseOrder, $MemberCourseOrderDetails);
                        $ids[$key] = $value['id'];
                    }
                }
            }

            if($ids){
                DockCourseOrder::updateAll(['is_delete' => 1],['in', 'id', array_values($ids)]);
            }
        }
        return true;

    }

    /**数据修正
     * @param $companyId
     * @return bool
     */
    public function courseOrderRevise($companyId){
        $id = 0;
        $limit = 10;

        while(true){
            $query = new \yii\db\Query();
            $result = $query->from(DockCourseOrder::tableName())
                ->where(['company_id' => $companyId, 'is_delete' => 0])
                ->andWhere(['>', 'id', $id])
                ->orderBy('id asc')
                ->limit($limit)
                ->all();

            $resultCount = count($result);
            if ($resultCount == 0) {
                break;
            }
            $id = $result[$resultCount - 1]['id'];

            foreach ($result as $key => $item) {
                $info = DockCourseOrder::findOne($item['id']);
                if($item['course_type'] == '私教课'){
                    $info->course_type = '私课';
                }else if($item['course_type'] == '团操课'){
                    $info->course_type = '团课';
                }

                $info->over_time = '2020-06-06';
                $info->save();
            }

        }
        return true;

    }

}