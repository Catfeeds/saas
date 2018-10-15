<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/6/12
 * Time: 11:37
 */

namespace backend\models;

use common\models\base\DockMemberCard;
use common\models\Excel;
use backend\models\DockLogExcel;
use yii\base\Model;
use backend\models\MemberCard;
use common\models\base\ConsumptionHistory;
use common\models\base\VenueLimitTimes;
use common\models\base\LimitCardNumber;
use common\models\Func;
use common\models\CardCategory;
use common\models\base\BindPack;
use Yii;


class DockMemberCardExcel extends DockMemberCard
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
    public function organizeDockMemberCardData($data,$filename, $repeat, $companyId){
        //数据去重复值
        if($repeat == 2){
            $temp = Func::arrDropRepeat($data);
        }else{
            $temp = $data;//不去重复
        }

        $arr = [];
        foreach ($temp as $key => $value){
            if($value[8] == '过期' || $value[8] == '退费'){
                unset($temp[$key]);
            }

            $arr[$key]['username'] = $value[0];
            $arr[$key]['mobile'] = (string)$value[1];
            $arr[$key]['sex'] = $value[2];
            $arr[$key]['company'] = $value[3];
            $arr[$key]['venue'] = $value[4];
            $arr[$key]['card_number'] = $value[5];
            $arr[$key]['open_card_time'] = $value[6] ? : null;
            $arr[$key]['money'] = (float)$value[7];
            $arr[$key]['status'] = $value[8];
            $arr[$key]['active_date'] = $value[9] ? : null;
            $arr[$key]['failure_date'] = $value[10] ? : null;
            $arr[$key]['nums'] = (int)$value[11];
            $arr[$key]['consume_nums'] = (int)$value[12];
            $arr[$key]['content'] = $value[13];
            $arr[$key]['counselor_name'] = $value[14];
            $arr[$key]['card_name'] = $value[15];
            $arr[$key]['count_type'] = $value[16];
            $arr[$key]['card_attributes'] = $value[17];
            $arr[$key]['deal_name'] = $value[18];
            $arr[$key]['behavior'] = $value[19];
            $arr[$key]['consume_type'] = $value[20];
            $arr[$key]['casd_number'] = $value[21];
            $arr[$key]['note'] = $value[22];
            $arr[$key]['company_id'] = $companyId;
            //判断数据的有效性
            if(empty($arr[$key]['username']) || empty($arr[$key]['mobile']) || empty($arr[$key]['company']) || empty($arr[$key]['venue']) || empty($arr[$key]['card_number']) || empty($arr[$key]['open_card_time'])  || empty($arr[$key]['status']) || empty($arr[$key]['active_date']) || empty($arr[$key]['failure_date']) || empty($arr[$key]['card_name'])){
                $arr[$key]['check_status'] = 2;
            }else{
                $arr[$key]['check_status'] = 1;
            }
        }

        //过滤空数据
        foreach ($arr as $k => $v){
            if(empty($v['username']) && empty($v['mobile'])){
                unset($arr[$k]);
            }

            if($v['status'] == '过期' || $v['status'] == '退费'){
                unset($arr[$k]);
            }
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try{

            //数据的批量插入
            $fields = ['username', 'mobile', 'sex', 'company', 'venue', 'card_number', 'open_card_time', 'money', 'status',
                'active_date', 'failure_date', 'nums', 'consume_nums', 'content', 'counselor_name', 'card_name', 'count_type', 'card_attributes', 'deal_name', 'behavior', 'consume_type', 'casd_number', 'note', 'company_id', 'check_status' ];
            if($arr && $fields){
                Yii::$app->db->createCommand() ->batchInsert(DockMemberCard::tableName(),$fields,$arr)->execute();
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
    public function memberCardList($params, $companyId){
        $keyword = !empty($params['keyword']) ? $params['keyword'] : '';
        $check_status = !empty($params['check_status']) ? $params['check_status'] : '';

        $query = DockMemberCard::find()
            ->orderBy('id DESC')
            ->where(['company_id' => $companyId, 'is_delete' => 0])
            ->asArray();
        //筛选条件
        if($keyword){
            $query->andFilterWhere([
                'or',
                ['like','username',$keyword],
                ['like','mobile',$keyword],
                ['like','company',$keyword],
                ['like','venue',$keyword],
                ['like','card_number',$keyword],
                ['like','card_name',$keyword],
            ]);
        }
        $query->andFilterWhere(['check_status'=>$check_status]);
        $data  = Func::getDataProvider($query,12);

        return $data;
    }


    public function memberCardEdit($post){
        $info = DockMemberCard::findOne($post['id']);

        $info->username = $post['username'];
        $info->mobile = $post['mobile'];
        $info->sex = $post['sex'];
        $info->company = $post['company'];
        $info->venue = $post['venue'];
        $info->card_number = $post['card_number'];
        $info->open_card_time = $post['open_card_time'];
        $info->money = $post['money'];
        $info->status = $post['status'];
        $info->active_date = $post['active_date'];
        $info->failure_date = $post['failure_date'];
        $info->nums = $post['nums'];
        $info->consume_nums = $post['consume_nums'];
        $info->content = $post['content'];
        $info->counselor_name = $post['counselor_name'];
        $info->card_name = $post['card_name'];
        $info->count_type = $post['count_type'];
        $info->card_attributes = $post['card_attributes'];
        $info->deal_name = $post['deal_name'];
        $info->behavior = $post['behavior'];
        $info->consume_type = $post['consume_type'];
        $info->casd_number = $post['casd_number'];
        $info->note = $post['note'];
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
     * @date: 2018/6/14
     * @time: 10:03
     * @param $companyId
     * @return bool
     */
    public function memberCardModify($companyId){
        $id = 0;
        $limit = 10;

        while(true){

            $query = new \yii\db\Query();
            $result = $query->from(DockMemberCard::tableName())
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
            $correct = [];
            $error = [];

            foreach ($result as $key => $value){
                $is_require = false;
                $is_mobile = false;
                $is_company = false;
                $is_venue = false;
                $is_employee = false;
                $is_deal = false;
                $is_member = false;
                $is_status = true;
                $is_repeat = false;

                $DockLogExcel = new DockLogExcel();

                //验证必填项
                if($value['username'] && $value['mobile'] && $value['company'] && $value['venue'] && $value['card_number'] && $value['open_card_time'] && $value['status'] && $value['active_date'] && $value['failure_date']  && $value['card_name'] ){
                    $is_require = true;
                }

                //验证手机号
                if(preg_match('/^1([0-9]{9})/',$value['mobile'])){
                    $is_mobile = true;
                }
                //校对会员
                $is_member = $DockLogExcel::memberNameModify($companyId, $value['venue'], $value['username']);

                //校对公司名称
                $is_company = $DockLogExcel::companyModify($companyId, $value['company']);
                //校对场馆
                $is_venue = $DockLogExcel::venueModify($companyId, $value['venue']);

//            //校对销售
//            $is_employee = $DockLogExcel::employeeModify($companyId, $value['counselor_name']);

//            //校对合同
//            $is_deal = $DockLogExcel::dealModify($companyId, $value['venue'], $value['deal_name']);

                //会员卡状态
                $is_status = $DockLogExcel::memberCardStatusModify($value['status']);

                //数据是否重复
                $is_repeat = self::memberCardRepeat($companyId, $value['username'], $value['card_number']);


                if($is_status && $is_require && $is_mobile && $is_company && $is_venue && $is_member && $is_status && $is_repeat && $value['check_status'] != 1){
                    $correct[$key] = $value['id'];
                }else if($value['check_status'] != 2){
                    $error[$key] = $value['id'];
                }
            }

            if(!empty($correct)){
                DockMemberCard::updateAll(['check_status' => 1],['in', 'id', array_values($correct)]);
            }

            if(!empty($error)){
                DockMemberCard::updateAll(['check_status' => 2],['in', 'id', array_values($error)]);
            }

        }

        return true;
    }

    /**
     * @desc:数据同步
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/16
     * @time: 10:13
     * @param $companyId
     * @return bool|string
     * @throws \yii\db\Exception
     */
    public function memberCardDock($companyId){
        $DockLogExcel = new DockLogExcel();

        if($DockLogExcel::memberCardModify($companyId) != true){
            return "基本设置不完全！";
        }

        $id = 0;
        $limit = 10;
        while(true){

            $query = new \yii\db\Query();
            $result = $query->from(DockMemberCard::tableName())
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

            $arr = [];
            foreach ($result as $key => $value) {
                $DockLogExcel = new DockLogExcel();
                $venue_id = $DockLogExcel::venueModify($companyId, $value['venue']);
                $venue_id = $venue_id != false ? $venue_id : 0;
                $member_id = $DockLogExcel::memberNameModify($companyId,$value['venue'], $value['username']);
                $employee_id = $DockLogExcel::employeeModify($companyId, $value['counselor_name']);
                $deal_id = $DockLogExcel::dealModify($companyId,$value['venue'], $value['deal_name']);
                $cardCategory = $DockLogExcel::cardCategoryInfo($companyId,$value['card_name'] );

                if(!empty($cardCategory)){
                    $card_category_id = $cardCategory->id;
                    $arr['pic']                 = $cardCategory->pic;
                    $arr['type']                = $cardCategory->card_type;
                    $arr['bring']               = $cardCategory->bring;
                    $arr['ordinary_renewal']    = $cardCategory->ordinary_renewal;
                    $arr['total_times']        = $cardCategory->times;                   //总次数(次卡)
                    $arr['card_name']          = $cardCategory->card_name;              //卡名
                    $arr['another_name']       = $cardCategory->another_name;          //另一个卡名
                    $arr['card_type']          = $cardCategory->category_type_id;      //卡类别
                    $arr['count_method']       = $cardCategory->count_method;          //计次方式
                    $arr['attributes']         = $cardCategory->attributes;             //属性
                    $arr['active_limit_time'] = $cardCategory->active_time;            //激活期限
                    $arr['transfer_num']       = $cardCategory->transfer_number;       //转让次数
                    $arr['surplus']            = $cardCategory->transfer_number;       //剩余转让次数
                    $arr['transfer_price']     = $cardCategory->transfer_price;        //转让金额
                    $arr['recharge_price']     = $cardCategory->recharge_price;        //充值卡充值金额
                    $arr['present_money']      = $cardCategory->recharge_give_price;  //买赠金额
                    $arr['renew_price']        = $cardCategory->renew_price;           //续费价
                    $arr['renew_best_price']   = $cardCategory->offer_price;          //续费优惠价
                    $arr['renew_unit']         = $cardCategory->renew_unit;            //续费多长时间/天
                    $arr['leave_total_days']   = $cardCategory->leave_total_days;     //请假总天数
                    $arr['leave_least_days']   = $cardCategory->leave_least_Days;     //每次请假最少天数
                    $arr['leave_days_times']   = $cardCategory->leave_long_limit;     //每次请假天数、请假次数
                    $arr['duration']   = json_decode($cardCategory->duration)->day;     //有效天数json转为int
                }else{
                    $card_category_id = 0;
                    $arr['card_name']          = $value['card_name'];
                }

                $arr['company_id'] = $companyId;
                $arr['venue_id'] = $venue_id;
                $arr['card_number'] = $value['card_number'];
                $arr['create_at'] = strtotime($value['open_card_time']);
                $arr['amount_money'] = $value['money'];
                $arr['status'] = $DockLogExcel::memberCardStatus($value['status']);
                $arr['active_time'] = strtotime($value['active_date']);
                $arr['total_times'] = $value['nums'];
                $arr['consumption_times'] = $value['consume_nums'];
                $arr['invalid_time'] = strtotime($value['failure_date']);
                $arr['member_id'] = $member_id != false ? $member_id : 0;
                $arr['employee_id'] = $employee_id != false ? $employee_id : 0;
//                $arr['count_method'] = $DockLogExcel::countMethod($value['count_type']);
                $arr['deal_id'] = $deal_id != false ? $deal_id : 0;
                $arr['note'] = $value['note'];
//                $arr['attributes'] =$DockLogExcel::cardAttributes($value['card_attributes']);
                $arr['payment_type'] = 0;
                $arr['is_complete_pay'] = 1;
                $arr['level'] = 1;
                $arr['card_category_id'] = $card_category_id;

                \Yii::$app->db ->createCommand() ->insert(MemberCard::tableName(),$arr) ->execute();
                $member_card_id = \Yii::$app->db->getLastInsertId();

                //通馆子
                $limitArr = LimitCardNumber::find()->where(['card_category_id'=>$card_category_id])->asArray()->all();

                if(is_array($limitArr) && !empty($limitArr)){
                    VenueLimitTimes::deleteAll(['member_card_id'=>$member_card_id]);
                    foreach ($limitArr as $v){

                        if($v['status'] == 1 || $v['status'] == 3){
                            $venueLimit    = new VenueLimitTimes();
                            $venueLimit->member_card_id = $member_card_id;
                            $venueLimit->venue_id       = $v['venue_id'];
                            $venueLimit->venue_ids      = $v['venue_ids'];
                            $venueLimit->total_times    = intval($v['times']);
                            if(!empty($v['times'])){
                                $venueLimit->overplus_times = intval($v['times']);
                            }else{
                                $venueLimit->overplus_times = intval($v['week_times']);
                            }
                            $venueLimit->week_times     = intval($v['week_times']);
                            $venueLimit->level           = intval($v['level']);
                            if(!$venueLimit->save()){
                                return $venueLimit->errors;
                            }
                        }
                    }
                }else{
                    $isVenueLimit = VenueLimitTimes::find()->where(['member_card_id'=>$member_card_id])->andWhere(['venue_id'=>$venue_id])->asArray()->one();
                    if(empty($isVenueLimit)){
                        $venueLimit    = new VenueLimitTimes();
                        $venueLimit->member_card_id = $member_card_id;
                        $venueLimit->venue_id       = $venue_id;
                        $venueLimit->total_times    = -1;
                        $venueLimit->overplus_times = -1;
                        if(!$venueLimit->save()){
                            return $venueLimit->errors;
                        }
                    }
                }

                //消费记录
                $consumption = ConsumptionHistory::findOne(['consumption_type_id'=>$member_card_id,'consumption_type'=>'card','category'=>$value['status']]);

                if(empty($consumption)){
                    $data['member_id'] = $member_id != false ? $member_id : 0;
                    $data['consumption_type'] = 'card';
                    $data['consumption_type_id'] = $member_card_id;
                    $data['type'] = 1;
                    $data['consumption_date'] = strtotime($value['open_card_time']);
                    $data['venue_id'] = $venue_id != false ? $venue_id : 0;
                    $data['seller_id'] = $employee_id != false ? $employee_id : 0;
                    $data['company_id'] = $companyId;
                    $data['consumption_amount'] = $value['money'];
                    $data['activate_date'] = strtotime($value['active_date']);

                    \Yii::$app->db ->createCommand() ->insert(ConsumptionHistory::tableName(),$data) ->execute();
                }

                //团课绑定
                $bindData = BindPack::find()->where(['card_category_id' => $card_category_id])->asArray()->all();
                if(isset($bindData)){
                    foreach($bindData as $k=>$v){
                        $memberBindCard = new BindMemberCard();
                        $memberBindCard->member_card_id    = $member_card_id;
                        $memberBindCard->venue_id          = $v['venue_id'];
                        $memberBindCard->company_id        = $v['company_id'];
                        $memberBindCard->polymorphic_id    = $v['polymorphic_id'];
                        $memberBindCard->polymorphic_type  = $v['polymorphic_type'];
                        $memberBindCard->number            = $v['number'];
                        $memberBindCard->status            = $v['status'];
                        $memberBindCard->polymorphic_ids   = $v['polymorphic_ids'];
                        if(!$memberBindCard->save()){
                            return $memberBindCard->errors;
                        }
                    }
                }

                //卡时间 限制同步
                $limitCardNum = LimitCardNumber::find()
                    ->where(['and',
                        ['card_category_id' => $card_category_id],
                        ['venue_id' => $venue_id],
                        ['is not','limit',NULL]
                    ])
                    ->select('id,limit,surplus')
                    ->asArray()->one();
                if(!empty($limitCardNum)){

                    if(isset($limitCardNum)){
                        $limitCardNum = LimitCardNumber::findOne(['id' => $limitCardNum['id']]);
                    }
                    if($limitCardNum['limit'] == -1){
                        $limitCardNum->surplus = -1;
                    }else{
                        if($limitCardNum['surplus'] <= 0){
                            $limitCardNum->surplus = 0;
                        }else{
                            $limitCardNum->surplus = $limitCardNum['surplus'] - 1;
                        }
                    }

                    $limitCardNum->save() ? $limitCardNum : $limitCardNum->errors;
                }

            }

            DockMemberCard::updateAll(['is_delete' => 1],['in', 'id', array_column($result, 'id')]);

        }

        return true;

    }


    /**
     * @desc:判断是否有重复数据（卡号）
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/22
     * @time: 15:59
     * @param $companyId
     * @param $username
     * @param $cardNumber
     * @return bool
     */
    static public function memberCardRepeat($companyId, $username, $cardNumber){

        $num = DockMemberCard::find()
            ->select('id')
            ->where(['company_id' => $companyId, 'username' => $username,'card_number' => $cardNumber])
            ->asArray()
            ->count();

        return $num >= 2 ? false : true;
    }

    /**
     * @desc:业务校对
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/26
     * @time: 10:08
     * @param $companyId
     * @return bool
     */
    public function memberCardRevise($companyId){
        $id = 0;
        $limit = 10;

        while(true){
            $query = new \yii\db\Query();
            $result = $query->from(DockMemberCard::tableName())
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
                $info = DockMemberCard::findOne($item['id']);
                if($item['status'] == '未开卡'){
                    $info->status = '未激活';
                }

                if($item['card_number'] == null){
                    $a = substr($item['mobile'],7);
                    if($a != false){
                        $info->card_number = 'ZY000'.$a;
                    }else{
                        $info->card_number = 'ZY000'.$item['mobile'];
                    }
                }

                $info->company = '艾搏健身中原店';
                $info->venue = '艾搏健身中原店';
                $info->money = 1;
                $info->save();
            }

        }
        return true;
    }

}