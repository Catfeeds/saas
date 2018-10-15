<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/5/2
 * Time: 23:09
 */

namespace backend\models;
use common\models\base\Member;
use common\models\base\MemberAccount;
use common\models\base\MemberDetails;
use common\models\base\MessageCode;
use yii\base\Model;

class MemberShipLoginForm extends Model
{
    public $mobile;   // 会员电话
    public $code;     // 会员验证码
    public $sex;      // 会员性别
    public $IDNumber;  // 会员身份证号
    public $memberName; // 会员姓名
    public $password;  // 用户密码
    public $venueId;  // 场馆id
    public $companyId;// 公司id
    public $counselorId;  //客服

    public $member = [];   // 会员信息 (注册后返回的会员信息)

    public $loginMemberName;  // 会员登录姓名
    public $paramComplete;    // 参数是否完整 true是完整 false是不完整

    /**
     * @云运动 - 会员入会 - 场景表单验证
     * @create 2017/10/24
     * @return array
     */
    public function scenarios(){
        return [
            "memberRegister"=>["mobile","code","sex","IDNumber","memberName","counselorId"],
            "hardMemberRegister"=>["mobile","code","sex","IDNumber","memberName","counselorId"]
        ];
    }
    /**
     * @云运动 - 会员入会 - 表单验证规则
     * @create 2017/10/24
     * @return array
     */
    public function rules()
    {
        return [
            ['mobile', 'required', 'message' => '手机号不能为空','on'=>["memberRegister","hardMemberRegister"]],
            ['mobile', "isNotRegister",'on'=>["memberRegister","hardMemberRegister"]],
            ['code', 'required','message' => '验证码不能为空！','on'=>["memberRegister","hardMemberRegister"]],
            ['code', 'trim','on'=>["memberRegister","hardMemberRegister"]],
            ['code', "checkCode",'on'=>["memberRegister","hardMemberRegister"]],
            ['code', 'newCodeTime','on'=>["memberRegister","hardMemberRegister"]],
            ["memberName",'required','message' => '用户姓名不能为空','on'=>["memberRegister","hardMemberRegister"]],
            ["sex",'required',"message"=>"用户性别不能为空",'on'=>["memberRegister","hardMemberRegister"]],
            ["password",'required',"message"=>"用户密码不能为空",'on'=>["memberRegister"]],
        ];
    }
    /**
     * 后台 - 会员注册 - 查询该会员是否注册过
     * @author  houkaixin <houkaixin@itsport.club>
     * @create 2017/10/24
     * @param $attribute
     */
    public function isNotRegister($attribute){
        if (!$this->hasErrors()) {
            $admin = $this->isNotRegisterLogic();
            if (!$admin) {
              return  $this->addError($attribute, '您已经注册过了，请直接登录');
            }
        }
    }
    /**
     * 后台 - 会员注册 - 查询该会员是否注册过逻辑
     * @author  houkaixin<houkaixin@itsport.club>
     * @param $venue   // 所属公司
     * @create 2017/3/30
     * @return boolean
     */
    public function isNotRegisterLogic($venue = "Mb"){
          // 获取场馆信息
         $organization = $this->getVenueData($venue);
          // 查询该会员 是否在该公司是老会员
         $member = MemberAccount::find()->where(["and",["mobile"=>$this->mobile],
                                         ["company_id"=>$organization->pid]])->count();
         if($member!=0){
            return false;  // 手机号已注册
         }
         return true;
    }
    /**
     * 后台 - 会员入会 - 获取公司的所属信息
     * @author houkaixin<houkaixin@itsport.club>
     * @param $venue     // 场馆名称
     * @create 2017/10/26
     * @return  object
     */
    public function getVenueData($venue = "Mb"){
        $venueName = ($venue == "Mb")?"天伦锦城店":null;
        $organization = Organization::find()->where(["and",["like","name",$venueName],["style"=>2]])->one();
        $this->venueId    = $organization->id;
        $this->companyId  = $organization->pid;
        return $organization;
    }
    /**
     * 后台 - 验证码 - 检验验证码是否正确
     * @author houkaixin<houkaixin@itsport.club>
     * @param $attribute
     * @create 2017/10/24
     */
     public function checkCode($attribute){
         $code = $this->getCode();
         $code["code"] = isset($code["code"])&&(!empty($code["code"]))?$code["code"]:null;
         if($this->code!=$code["code"]){
            return $this->addError($attribute, '您输入验证码有误！');
         }
     }
    /**
     * @云运动 - 后台 - 获取验证码
     * @author houkaixn<houkaixn@itsports.club>
     * @create 2017/4/1
     * @inheritdoc
     */
    public function getCode()
    {
      $message     = MessageCode::find()->where(['mobile'=>$this->mobile])->orderBy('create_at DESC')->asArray()->one();
      return $message;
    }
    /**
     * @云运动 - 后台 - 注册验证码验证
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/1
     * @inheritdoc
     */
    public function newCodeTime($attribute)
    {
        $temp = $this->getCode();
        $time = $temp['create_at'];
        $num = time() - $time;
        if ($num > 300000){
          return  $this->addError($attribute, '验证码已失效！');
        }
    }
    /**
     * @云运动 - 后台 - 删除验证码
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/1
     * @inheritdoc
     */
    public function delCode()
    {
        $code = MessageCode::findOne(['mobile'=>$this->mobile]);
        $del  = $code->delete();
        return $del;
    }
    /**
     * @云运动 - 后台 - 后台会员注册
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/1
     * @inheritdoc
     */
    public function insertTheMember($sign=""){
        // 查重会员信息
        $model  =   $this->newSearchMemberMessage();
        if(!empty($model)&&($model->member_type==1)&&empty($sign)){
            return "您已是老会员了";
        }

        $transaction = \Yii::$app->db->beginTransaction();   //开启事务
        try{
            $ma                    = new MemberAccount();
            $ma->mobile            = $this->mobile;
            $ma->username          = $this->mobile;
            if(empty($this->password)){
                $this->password = "12345678";
            }
            $ma->password       = \Yii::$app->security->generatePasswordHash($this->password);  //用户密码加密
            $ma->create_at         = time();
            $ma->company_id        = $this->companyId;
            $ma->save();
            if (!isset($ma->id)) {
                return $ma->errors;
            }

            $model = new Member();
            $model->member_account_id = $ma->id;
            $model->username       = $this->memberName;
            $model->mobile         = $this->mobile;
            $model->register_time = time();
            $model->status         = 1;
            $model->member_type   = 2;     // 潜在会员
            $model->venue_id       = (int)$this->venueId;   // 场馆id
            $model->company_id     = (int)$this->companyId; //公司id
            $model->counselor_id  = $this->counselorId;
            if(empty($this->password)){
                $this->password = "123456";
            }
            $model->password       = \Yii::$app->security->generatePasswordHash($this->password);  //用户密码加密
            if(!$model->save()){
               return $model->errors;
            }

            //会员详情表
            $detailModel = new MemberDetails();
            $detailModel->member_id = $model->id;
            $detailModel->name       = $this->memberName;
            $detailModel->sex        = $this->sex;
            $detailModel->id_card    = $this->IDNumber;  // 身份证号
            if(strlen($this->IDNumber) == 15){
                $birthday = "19".substr($this->IDNumber, 6, 2).'-'.substr($this->IDNumber, 8, 2).'-'.substr($this->IDNumber, 10, 2);
            }else{
                $birthday = substr($this->IDNumber, 6, 4).'-'.substr($this->IDNumber, 10, 2).'-'.substr($this->IDNumber, 12, 2);
            }
            $detailModel->birth_date = $birthday;
            $detailModel->document_type = 1;
            $detailModel->created_at = time();
            if(!$detailModel->save()){
                return $detailModel->errors;
            }
            $this->member["id"]         = $model->id;         // 会员注册以后的信息返回（会员id）
            $this->member["memberName"] = $this->memberName;  // 会员注册以后的信息返回（会员姓名）

            if($transaction->commit() === null){
                return true;
            }else{
                return false;
            }
        }catch(\Exception $e){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return $e->getMessage();  //获取抛出的错误
        }
    }
    /**
     * @云运动 - 会员入会 - 查询会员基本信息信息重组装
     * @author houkaixin<houkaixin@itsports.club>
     * @create 2017/10/26
     * @param $login    // 是否是登录
     * @return object
     */
    public function searchMemberMessage($login=""){
        $model = \backend\models\Member::find()
                    ->alias("member")
                    ->where(["and",["member.mobile"=>$this->mobile],["member.venue_id"=>$this->venueId]]);
        if(!empty($this->loginMemberName)&&!empty($login)){
          $model  = $model->joinWith(["memberDetails memberDetails"],false)
                  ->select("member.id,member.mobile,member.venue_id,memberDetails.name,memberDetails.id_card,memberDetails.sex")
                  ->andWhere(["memberDetails.name"=>$this->loginMemberName])
                  ->asArray()
                  ->one();
            return $model;
        }
        $model = $model->one();

        return  $model;
    }
    /**
     * @云运动 - 会员入会 - 查询会员基本信息信息重组装 新逻辑
     * @author houkaixin<houkaixin@itsports.club>
     * @create 2017/10/26
     * @param $login    // 是否是登录
     * @return object
     */
    public function newSearchMemberMessage($login=""){
        $model = MemberAccount::find()
            ->alias("ma")
            ->where(["and",["ma.mobile"=>$this->mobile],["ma.company_id"=>$this->companyId]])->asArray()->one();
        $member = \backend\models\Member::find()
            ->alias("member")
            ->where(["and",["member.member_account_id"=>isset($model['id'])?$model['id']:0],["member.venue_id"=>$this->venueId]]);
        if(!empty($this->loginMemberName)&&!empty($login)){
            $member  = $member->joinWith(["memberDetails memberDetails"],false)
                ->select("member.id,member.mobile,member.venue_id,memberDetails.name,memberDetails.id_card,memberDetails.sex")
                ->andWhere(["memberDetails.name"=>$this->loginMemberName])
                ->asArray()
                ->one();
            return $member;
        }
        $member = $member->one();

        return  $member;
    }
    /**
     * @云运动 - 后台 - 老会员登录
     * @author houkaixin<houkaixin@itsports.club>
     * @param $mobile         // 手机号
     * @param $referCode     // 提交验证码
     * @create 2017/10/26
     * @return array
     */
    public function memberLogin($mobile,$referCode){
        // 获取验证码
        $this->mobile = $mobile;
        $sendCode = $this->getCode();
        $theCode = isset($sendCode["code"])&&(!empty($sendCode["code"]))?$sendCode["code"]:null;
        if($theCode!== $referCode){
             return "codeError";    // 验证码错误
        }
        // 根据会员身份登录（根据实际情况）
         $endResult = $this->goMemberLogin($mobile);
         return $endResult;
    }

    /**
     * @云运动 - 后台 - 登录（硬件的登录）
     * @author houkaixin<houkaixin@itsports.club>
     * @param $mobile         // 手机号
     * @param $name          // 会员姓名
     * @param $referCode     // 提交验证码
     * @create 2017/10/26
     * @return array
     */
    public function hardwareLogin($mobile,$name="",$referCode=""){
//        $sendCode = $this->getCode();
//        $theCode = isset($sendCode["code"])&&(!empty($sendCode["code"]))?$sendCode["code"]:null;
//        if($theCode!== $referCode){
//            return "codeError";    // 验证码错误
//        }
        $this->loginMemberName = $name;
        // 根据会员身份登录（根据实际情况）
        $endResult = $this->goHardwareLogin($mobile);
        return $endResult;
    }

    /**
     * @云运动 - 后台 - 登录（硬件的登录）  ---- 老邢 要求 重写一套接口
     * @author houkaixin<houkaixin@itsports.club>
     * @param $mobile         // 手机号
     * @create 2017/10/26
     * @return array
     */
    public function goHardwareLogin($mobile){
        //所属场馆 公司
        $this->getVenueData();
        $this->mobile = $mobile;
        // 搜索会员相关信息
        $member = $this->newSearchMemberMessage("login");
        if(empty($member)){        // 未注册会员
            return "notRegisterMember";
        }
        $this->paramComplete = empty($member["id"])||empty($member["mobile"])||empty($member["name"])||empty($member["id_card"])||empty($member["sex"])?false:true;
        // 返回会员信息
        $this->member["id"]          = $member["id"];
        $this->member["mobile"]       = $member["mobile"];
        $this->member["memberName"] = $member["name"];
        $this->member["sex"]         = $member["sex"];
        $this->member["idCard"]    =  $member["id_card"];
        if($this->paramComplete===false){
             return false;
        }
        // 验证码删除
//        $mobileCode =  MessageCode::find()->where(["mobile"=>$mobile])
//            ->orderBy(["create_at"=>SORT_DESC])
//            ->one();
      //  $mobileCode->delete();
        return true;
    }
    /**
     * @云运动 - 后台 - 老会员登录
     * @author houkaixin<houkaixin@itsports.club>
     * @param $mobile   // 手机号
     * @create 2017/10/26
     * @return array
     */
    public function goMemberLogin($mobile){
        //所属场馆 公司
        $this->getVenueData();
        $this->mobile = $mobile;
        // 搜索会员相关信息
        $member = $this->searchMemberMessage();
        if(empty($member)){       // 新会员不准通过
           return "notRegisterMember";
        }
        if(!empty($member)&&isset($member->member_type)&&($member->member_type==2)){
           return "potentialMember";  // 潜在会员不准通过
        }
        // 返回会员信息
        $this->member["id"]          = $member->id;
        $this->member["memberName"] = MemberDetails::findOne(["member_id"=>$member->id])->name;
        // 验证码删除
         $mobileCode =  MessageCode::find()->where(["mobile"=>$mobile])
                           ->orderBy(["create_at"=>SORT_DESC])
                           ->one();
        $mobileCode->delete();
        return true;
    }




}