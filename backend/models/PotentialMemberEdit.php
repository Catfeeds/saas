<?php
namespace backend\models;
use common\models\base\Member;
use common\models\base\MemberDeposit;
use common\models\base\MemberDetails;
use yii\base\Model;
class PotentialMemberEdit  extends Model
{

    public $memberId;      // 会员id
    public $sex;           // 会员性别
    public $idCard;        //会员身份证号
    public $birthDate;    //会员生日
    public $deposit;       // 定金
    public $wayToShop;	//来店途径
    public $counselorId;  //会籍顾问id
    public $note;          //备注
    public $documentType;	               //证件类型
    /**
     * 云运动 - 潜在会员 -  表单验证规则
     * @author houkaixin<houkaixin @itsports.club>
     * @create 2017/7/12
     * @return array
     */
    public function rules()
    {
        return [
            [['memberName',"memberId","memberMobile","sex","idCard",
             "birthDate","deposit","wayToShop","counselorId","note","documentType"],'safe']
        ];
    }
    /**
     * 云运动 - 潜在会员 -  潜在会员编辑
     * @author houkaixin<houkaixin @itsports.club>
     * @create 2017/7/12
     * @return array
     */
    public function editMember(){
          $member = Member::findOne(["id"=>$this->memberId]);
          $member->counselor_id = $this->counselorId;   // 顾问id
          $member->params        = json_encode(['note' => $this->note]);  //备注
          if(!$member->save()){
              return $member->errors;
          }
          // 会员详情表
          $memberDetail = MemberDetails::findOne(["member_id"=>$this->memberId]);
          $memberDetail->sex        = $this->sex;         // 会员性别（1：男 2：女）
          $memberDetail->id_card    = $this->idCard;     // 身份证号
          $memberDetail->birth_date = $this->birthDate; // 会员生日
          $memberDetail->way_to_shop= $this->wayToShop; // 来店途径
          $memberDetail->document_type = $this->documentType;
          if(!$memberDetail->save()){
             return $memberDetail->errors;
          }
//          // 会员定金表
//          $memberDeposit = MemberDeposit::findOne(["member_id"=>$this->memberId]);
//          if(empty($memberDeposit)){
//              $memberDeposit = new MemberDeposit();
//          }
//          $memberDeposit->price = $this->deposit;   // 定金
//          $memberDeposit->member_id = $this->memberId;
//          $memberDeposit->create_at = time();
//          if(!$memberDeposit->save()){
//             return $memberDeposit->errors;
//          }
          return true;
    }
    /**
     * 云运动 - 潜在会员 -  获取场馆公司信息
     * @author houkaixin<houkaixin @itsports.club>
     * @create 2017/7/12
     * @return array
     */
    public function getLevelData(){
          $model = new Organization();
          
    }


}