<?php
namespace backend\models;
use common\models\base\Member;
use yii\base\Model;

/**
 * @云运动 - 后台 - 团课修改表单验证
 * @author Houkaixin <Houkaixin @itsports.club>
 * @create 2017/4/19
 */
class MemberCardForm extends Model
{
  public $adviserId;      //顾问id
  public $invalidDate;    //失效日期
  public $memCardId;      //会员卡id
  public $memId;          //会员id
    /**
     * @云运动 - 后台 - 会员卡表单修改验证(规则验证)
     * @create 2017/4/8
     * @return array
     */
    public function rules()
    {
        return [
            [['adviserId',"invalidDate","memCardId","memId"], 'required'],
        ];
    }

    /**
     * 云运动 - 会员管理- 修改会员卡相关信息
     * @author houkaixin <houkaixin@itsports.club>
     * @create 2017/4/21
     * @return string
     */
    public function updateMyCard(){
          $transaction = \Yii::$app->db->beginTransaction();                //开启事务
          try {
              $memCard                = MemberCard::findOne(["id"=>$this->memCardId]);
              $memCard->invalid_time = strtotime($this->invalidDate);
              $memCardResult = $memCard->save();
              if(!$memCardResult){
                  \Yii::trace($memCard->errors);
                  throw new \Exception("失效时间修改失败");
              }
              $memAdviser = Member::findOne(["id"=>$this->memId]);
              $memAdviser->counselor_id =(int)$this->adviserId;
              $memAdviserResult = $memAdviser->save();
              if(!$memAdviserResult){
                  \Yii::trace($memCard->errors);
                  throw new \Exception("会员销售顾问修改失败");
              }
              //执行数据递交
              if($transaction->commit()==null)
              {
                  return "success";
              }else{
                  return "error";
              }
          }catch(\Exception $e){
              //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
              $transaction->rollBack();
              return  $error = $e->getMessage();  //获取抛出的错误
          }

    }



}