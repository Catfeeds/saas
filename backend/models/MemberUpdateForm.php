<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/5/13
 * Time: 11:05
 */

namespace backend\models;


use common\models\base\Member;
use common\models\base\MemberDetails;
use common\models\base\MemberAccount;
use yii\base\Model;
use common\models\ChangeVenueRecord;

class MemberUpdateForm extends Model
{
    public $memberMobile;        //服务套餐名称
    public $memberId;             //服务名字

    public $sex;                  // 会员性别

    /**
     * 云运动 - 后台 - 服务套餐表单验证的规则
     * @author lihuien<lihuien@itsports.club>
     * @create 2017/5/12
     * @return array
     */
    public function rules()
    {
        return [
            [[ "memberMobile","memberId"], 'required'],
            [["sex"],"safe"],
        ];
    }
    /**
     * 云运动 - 后台 - 执行数据修改
     * @author Houkaixin<huangpengju@itsports.club>
     * @create 2017/5/12
     * @return array
     */
    public function updateMobile()
    {
        {
        $transaction                             =  \Yii::$app->db->beginTransaction();        //开启事务
        try{
        $model = Member::findOne(["id"=>$this->memberId]);
        $memberDetail = MemberDetails::findOne(["member_id"=>$this->memberId]);
        $memberAccount = MemberAccount::findOne(['id'=>$model['member_account_id']]);
        $memberAccountMobile = MemberAccount::findOne(['mobile'=>$this->memberMobile,'company_id'=>$model['company_id']]);

        $memberAllCount = Member::find()->where(['and',['company_id'=>$model['company_id']],['member_account_id'=>$model['member_account_id']]])->asArray()->all();
        $memberCount   = \backend\models\Member::find()->joinWith(['memberDetails memberDetails'])->where(['and',['company_id'=>$model['company_id']],['member_account_id'=>$model['member_account_id']]])
            ->andWhere(['and',['memberDetails.id_card'=>$memberDetail['id_card']],['IS NOT','memberDetails.id_card',null],['<>','memberDetails.id_card',0]])
            ->asArray()->all();
        $memberIdArr = array_column($memberCount,'id');

        if(count($memberAllCount) == count($memberCount)){
            $memberAccount->mobile = $this->memberMobile;
            if(!$memberAccount->save()){
                \Yii::trace($memberAccount->errors);
                throw new \Exception('操作失败');
            }
            $memberAll = Member::updateAll(['mobile'=>$this->memberMobile],['id'=>$memberIdArr]);
        }else{
            if(!empty($memberAccountMobile)){
                $memberAll = Member::updateAll(['member_account_id'=>$memberAccountMobile['id']],['id'=>$memberIdArr]);
            }else{
                $password = '123456';     //会员临时密码
                $password = \Yii::$app->security->generatePasswordHash($password);
                $memberAddAccount = new MemberAccount();
                $memberAddAccount->mobile            = $this->memberMobile;
                $memberAddAccount->username          = $this->memberMobile;
                $memberAddAccount->password          = $password;
                $memberAddAccount->create_at         = time();
                $memberAddAccount->company_id        = $model['company_id'];
                $memberAddAccount->save();
                if (!isset($memberAddAccount->id)) {
                    return $memberAddAccount->errors;
                }
                $memberAll = Member::updateAll(['member_account_id'=>$memberAddAccount['id']],['id'=>$memberIdArr]);
            }
        }


        $model->mobile = $this->memberMobile;
        if(!$model->save()){
            \Yii::trace($model->errors);
            throw new \Exception('操作失败');
        }
        if(!empty($this->sex)&&($memberDetail->sex!=$this->sex)){
            $memberDetail->sex = $this->sex;         // 会员性别的修改
            if(!$memberDetail->save()){
                \Yii::trace($memberDetail->errors);
                throw new \Exception('操作失败');
            }
        }
            $transaction->commit();
            return true;
        }catch(\Exception $e){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return $e->getMessage();  //获取抛出的错误
        }
        }
    }
    /**
     * 云运动 - 后台 - 执行数据修改
     * @author Houkaixin<huangpengju@itsports.club>
     * @create 2017/5/12
     * @param  $data
     * @return array
     */
    public function updateCurrentVenue($data)
    {
        $model = Member::findOne(["id"=>$data['memberId']]);
        $old = $model->venue_id;
        $new = $data['venueId'];
        if ($old == $new) {
            return '当前会员已在此场馆,无需修改!';
        }
        $count = Member::find()->where(['mobile'=>$model->mobile,'venue_id'=>$data['venueId']])->andWhere(['<>','id',$data['memberId']])->asArray()->count();
        if ($count) {
            return '修改的场馆存在与当前会员相同的手机号!';
        }

        $transaction = \Yii::$app->db->beginTransaction();
        try{
            $model->venue_id = $data['venueId'];
            $result = $model->save();
            if(!$result){
                return $model->errors;
            }
            //保存修改场馆记录
            $result = $this->changeVenueRecord($old,$new,$data['memberId']);
            if (!isset($result->id)) {
                return $result;
            }
            $transaction->commit();
            return true;

        }catch(\Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }

    }

    /**
     * @desc: 业务后台 - 修改会员所属场馆 - 添加修改记录
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/25
     * @param $old
     * @param $new
     * @param $memberId
     */
    public function changeVenueRecord($old,$new,$memberId)
    {
        $oldVenue = Organization::findOne($old);
        $newVenue = Organization::findOne($new);
        $model                  = new ChangeVenueRecord();
        $model->public_id       = $memberId;
        $model->type            = 1;
        $model->old_venue_id    = $old;
        $model->new_venue_id    = $new;
        $model->create_id       = isset(\Yii::$app->user->identity->id) ? (\Yii::$app->user->identity->id) : 0;    //保存的是员工表中字段admin_user_id
        $model->create_at       = time();
        if (isset($oldVenue->name) && isset($newVenue->name)) {
            $model->note        = '会员由'.$oldVenue->name.'转入'.$newVenue->name;
        } else {
            $model->note        = '';
        }
        return $model->save() ? $model : $model->errors;
    }
}