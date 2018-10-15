<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/4 0004
 * Time: 上午 10:22
 */

namespace backend\models;


use common\models\base\TransferRecord;
use common\models\Excel;
use yii\base\Model;

class ExcelTransfer extends Model
{
    const TRANSFER = [0=>'createVenue',1=>'transferType',2=>'transferContent',3=>'proof',4=>'number',5=>'transferStart',6=>'transferEnd',7=>'validPeriod',
                        8=>'firstMemberCard',9=>'firstMemberName',10=>'firstMemberMobile',11=>'firstCounselor',
                        '12'=>'lastMemberCard',13=>'lastMemberName',14=>'lastMemberMobile',15=>'lastCounselor',
                        '16'=>'fee',17=>'transferTime',18=>'registerPerson',19=>'note'];
    public $createVenue;             //操作场馆
    public $transferType;            //转让类型
    public $transferContent;         //转让内容
    public $proof;                   //凭证号
    public $number;                  //转让数量
    public $transferStart;           //转让内容开始时间
    public $transferEnd;             //转让内容结束时间
    public $validPeriod;             //有效期
    public $firstMemberCard;         //转出会员卡号
    public $firstMemberName;         //转出会员姓名
    public $firstMemberMobile;       //转出会员手机号
    public $firstCounselor;          //转出会员会籍顾问
    public $lastMemberCard;          //接收会员卡号
    public $lastMemberName;          //接收会员姓名
    public $lastMemberMobile;        //接收会员手机号
    public $lastCounselor;           //接收会员会籍顾问
    public $fee;                     //手续费
    public $transferTime;            //转让时间
    public $registerPerson;          //操作人
    public $note;                    //备注
    public $firstMemberId;           //转出会员id
    public $lastMemberId;            //接收会员id
    public $firstMemberCardId;       //会员卡id
    public $lastMemberCardId;        //会员卡id
    /**
     * 数据 - 业务后台 - 会员卡转让 - 查询会员是否存在
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/7/4
     * @param $name         //会员姓名
     * @param $mobile       //会员手机号
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getMemberExist($name,$mobile)
    {
        return Member::find()->where(['username'=>$name])->andFilterWhere(['mobile'=>$mobile])->asArray()->one();
    }
    /**
     * 数据 - 业务后台 - 会员转让 - 查询会员详情是否存在
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/7/4
     * @param $memberId
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getMemberDetailsExist($memberId)
    {
        return MemberDetails::find()->where(['member_id'=>$memberId])->asArray()->one();
    }
    /**
     * 数据 - 业务后台 - 会员转让 - 查询会员卡是否存在
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/7/4
     * @param $memberId           //会员id
     * @param $cardNumber         //会员卡 卡号
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getMemberCardExist($memberId,$cardNumber)
    {
        return MemberCard::find()->where(['member_id'=>$memberId])->andFilterWhere(['card_number'=>$cardNumber])->asArray()->one();   //查询会员卡是否存在
    }
    /**
     *  数据 - 业务后台 - 会员转让 - 查询会员转让记录是否存在
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/7/4
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getTransferRecord()
    {
        return TransferRecord::find()
            ->where(['member_card_id'=>$this->lastMemberCardId])
            ->andWhere(['to_member_id'=>$this->lastMemberId])
            ->andWhere(['from_member_id'=>$this->firstMemberId])
            ->asArray()
            ->one();
    }
    /**
     *  数据 - 业务后台  - 会员转让记录
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/7/4
     * @param $file             //导入的文件
     * @param string $type      //导入的文件类型
     * @param string $venueName //导入的场馆
     */
    public function setMemberTransfer($file,$type = 'memberTransfer',$venueName = '艾搏健身万达店')
    {
        $model = new Excel();
        $data = $model->loadFileTransfer($file,$type);
       foreach ($data as $k=>$v)
       {
           $this->loadData($v);                                                                                         //处理数据
           //1.查询转出会员是否存在
           $firstMember = $this->getMemberExist($this->firstMemberName,$this->firstMemberMobile);
           if(!$firstMember && empty($firstMember))
           {
               //1.1转出会员不存在
               echo "转出人：>>".$this->firstMemberName."不存在<br /><br />";
           }else{
               $this->firstMemberId = $firstMember['id'];                                                               //获取转让人id
           }
           //2.查询接收会员是否存在
           $nowMember   = $this->getMemberExist($this->lastMemberName,$this->lastMemberMobile);                         //查询现会员是否存在
           if(!$nowMember && empty($nowMember))
           {
               //2.1新会员为空走这里
               echo "接收人：>>".$this->lastMemberName."不存在<br /><br />";
           }else{
               $this->lastMemberId = $nowMember['id'];                                                                  //现会员id
           }
           //3.查询接收会员的会员卡是否存在
           $memberCard = $this->getMemberCardExist($this->lastMemberId,$this->lastMemberCard);                          //查询会员卡存不存在
           if(!$memberCard && empty($memberCard))
           {
               echo "接收人：>>".$this->lastMemberName.'>>会员卡“'.$this->lastMemberCard."”不存在<br /><br />";                                      //报错信息
           }else{
               //用会员卡id $memberCard['id']
               $this->lastMemberCardId = $memberCard['id'];                                                             //会员卡id
           }
           //4.查询转让记录是否存在
           if(!empty($this->firstMemberId) && !empty($this->lastMemberId) && !empty($this->lastMemberCardId))
           {
               $data = $this->getTransferRecord();                                                                      //查询转让记录是否存在
               if(!$data && empty($data))
               {
                   $transfer = $this->setTransferRecord();                                                              //生成转让记录
                   echo "transfer>>".$transfer."<br /><br />";
               }
           }

       }

    }
    /**
     * 数据 - 业务后台 - 会员转让 - 会员卡转让记录生成
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/7/4
     * @return bool
     */
    public function setTransferRecord()
    {
            $model                    = new TransferRecord();
            $model->member_card_id    = $this->lastMemberCardId;       //会员卡id
            $model->to_member_id      = $this->lastMemberId;           //现会员id
            $model->from_member_id    = $this->firstMemberId;          //原会员id
            $model->transfer_time     = strtotime($this->transferTime);           //转让时间
            if($this->transferType == '会籍转让')
            {
                $model->path          = json_encode([$this->firstMemberName .'了“'.$this->transferContent.'”给'.$this->lastMemberName]); //卡的转让经历
            }else if($this->transferType == '私教转让')
            {
                $model->path          = json_encode([$this->firstMemberName .'了私课“'.$this->transferContent.'”给'.$this->lastMemberName]); //卡的转让经历
            }
            $model->times             = $this->number;                  //数量
            $model->transfer_price    = $this->fee;                     //手续费
            $model->register_person   = $this->registerPerson;          //登记人
            $model->cashier_number    = (String)$this->proof;           //收银单号
            if(!$model->save()) {
                return $model->errors;
            }
    }
    /**
     * 数据 - 业务后台 - 会员转让信息 - 处理
     * @author huangpengju <huangpengju@itsports.club>
     * @create 2017/7/4
     * @param $v //excel表中的每行数据
     */
    public function loadData($v)
    {
        foreach($v as $k=>$val)
        {
            $params = self::TRANSFER;
            $key    = $params[$k];
            $this->$key = $val;
        }
    }
}