<?php
namespace common\models\relations;

use common\models\base\Admin;
use common\models\base\Employee;
use common\models\base\Cabinet;
use common\models\base\MemberCabinetRentHistory;
use common\models\Member;
use common\models\MemberCard;

trait MemberCabinetRelations
{
    /**
     * 后台会员管理 - 会员柜表查询 - 关联会员表
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/18
     * @return \yii\db\ActiveQuery
     */
    public function getMember()
    {
        return $this->hasOne(Member::className(), ['id'=>'member_id']);
    }
    /**
     * 后台会员管理 - 会员柜表查询 - 关联员工表
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/18
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['admin_user_id'=>'creater_id']);
    }
    /**
     * 后台会员管理 - 会员圭表查询 - 关联柜子表
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/18
     * @return \yii\db\ActiveQuery
     */
    public function getCabinet()
    {
        return $this->hasOne(\backend\models\Cabinet::className(), ['id'=>'cabinet_id']);
    }
    /**
     * 后台会员管理 - 会员柜表查询 - 关联经办人
     * @author Houkaixin <huanghua@itsports.club>
     * @create 2017/5/3
     * @return \yii\db\ActiveQuery
     */
    public function getAdmin()
    {
        return $this->hasOne(Admin::className(),['id' =>'creater_id']);
    }
    /**
     * 后台会员管理 - 会员柜表查询 - 关联经办人
     * @author Houkaixin <huanghua@itsports.club>
     * @create 2017/5/3
     * @return \yii\db\ActiveQuery
     */
    public function getCabinetHistory()
    {
        return $this->hasMany(MemberCabinetRentHistory::className(),['cabinet_id' =>'cabinet_id']);
    }

    /**
     * @desc: 业务后台 - 会员租柜表 - 关联会员卡表
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/04/08
     * @return mixed
     */
    public function getMemberCard()
    {
        return $this->hasMany(MemberCard::className(),['member_id'=>'member_id']);
    }
}