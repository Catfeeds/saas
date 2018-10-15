<?php
namespace backend\modules\v3\models;
use common\models\base\Member;
use yii\base\Model;
use common\models\EntryRecord;
use common\models\AboutClass;
class StatisticsModel extends Model
{
    /**
     * 运运动-微信公众号-各种统计模型接口
     * @1 会员进场次数统计 //memberEntryCount
     * @2 会员累计天数统计 //memberTotalDays
     * @3 会员上课时长统计 //memberClassTime
     * @4 会员约课次数统计 //memberAboutCount
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/28
     * @param $id
     * @return array|null
     */
    public function gainAllStatistics($id)
    {
        if(isset($id) && !empty($id)){
            $statistics1 = self::gainMemberAboutCourseCount($id);
            $statistics2 = self::gainMemberClassTime($id);
            $statistics3 = self::gainMemberEntryCount($id);
            $statistics4 = self::gainMemberTotalDays($id);
            $statistics = array_merge($statistics1, $statistics2, $statistics3, $statistics4);
            return $statistics;
        }
        return NULL;
    }

    /**
     * 运运动-微信公众号-会员进馆记录模型接口(limit 10)
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @param $id  //会员ID
     * @createAt 2018/2/28
     * @return array|\yii\db\ActiveRecord[]
     */
    public function gainMemberEntryRecord($id)
    {
        return EntryRecord::find()->alias('er')
                    ->joinWith(['organization or'], false)
                    ->select(['FROM_UNIXTIME(er.entry_time,"%Y-%m-%d %H:%i") entryTime', 'or.name venueName'])
                    ->where(['er.member_id' => $id])
                    ->orderBy(['er.entry_time' => SORT_DESC])
                    ->limit(10)
                    ->asArray()
                    ->all();
    }

    /**
     * 运运动-微信公众号-会员累计天数进馆记录模型接口(limit 10)
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/28
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function gainMemberDaysRecord($id)
    {
        return EntryRecord::find()->alias('er')
                    ->joinWith(['organization or'], false)
                    ->select(['FROM_UNIXTIME(er.entry_time,"%Y-%m-%d") entryTime', 'or.name venueName'])
                    ->where(['er.member_id' => $id])
                    ->orderBy(['er.entry_time' => SORT_DESC])
                    ->limit(10)
                    ->asArray()
                    ->all();
    }

    /**
     * 运运动-微信公众号-会员上课记录模型接口(limit 10)
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/28
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function gainMemberClassTimeRecord($id)
    {
        return AboutClass::find()->alias('ac')
            //团课
            ->joinWith(['groupClass gc' => function($q){
                $q->onCondition(['ac.type' => 2]);
                $q->joinWith(['course cc'], false);
                $q->joinWith(['organization orr']);
            }], false)
            ->joinWith(['memberCourseOrderDetails mcod' => function($q){
                $q->joinWith(['memberCourseOrder mco' => function($q){
                    $q->joinWith(['chargeClass ccl' => function($q){
                        $q->joinWith('organization or');
                    }]);
                }]);
                $q->onCondition(['ac.type' => 1]);
                $q->joinWith(['course ccc'], false);
            }], false)
            ->select([
                'FROM_UNIXTIME(ac.start,"%Y-%m-%d %H:%i") startTime',
                'FROM_UNIXTIME(ac.end,"%H:%i") endTime',
                'or.name siCourseVenueName',
                'orr.name tuanCourseVenueName',
                'cc.name tuanCourseName',
                'ccc.name siCourseName'
            ])
            ->where(['AND', ['ac.member_id' => $id], ['ac.status' => [4, 5]]])
            ->orderBy(['ac.start' => SORT_DESC])
            ->limit(10)
            ->asArray()
            ->all();
    }

    /**
     * 运运动-微信公众号-会员约课记录模型接口(limit 10)
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/28
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function gainMemberAboutCourseRecord($id)
    {
        return AboutClass::find()->alias('ac')
                    //团课
                    ->joinWith(['groupClass gc' => function($q){
                        $q->onCondition(['ac.type' => 2]);
                        $q->joinWith(['course cc']);
                        $q->joinWith(['organization orr']);
                    }], false)
                    //私课
                    ->joinWith(['memberCourseOrderDetails mcod' => function($q){
                        $q->onCondition(['ac.type' => 1]);
                        $q->joinWith(['memberCourseOrder mco' => function($q){
                            $q->joinWith(['chargeClass ccl' => function($q){
                                $q->joinWith('organization or');
                            }]);
                        }]);
                    }], false)
                    ->select(['ac.class_date classDate', 'cc.name tuanCourseName',
                              'mco.product_name siCourseName', 'or.name siCourseVenueName', 'orr.name tuanCourseVenueName'])
                    ->where(['ac.member_id' => $id])
                    ->orderBy(['ac.start' => SORT_DESC])
                    ->limit(10)
                    ->asArray()
                    ->all();
    }

    /**
     * 运运动-微信公众号-会员进场次数
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/28
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    private static function gainMemberEntryCount($id)
    {
        //单例
        $model = EntryRecord::find();
        //构造器
        $model->where(['member_id' => $id]);
        $model->select('COUNT(id) memberEntryCount');
        $count = $model->asArray()->all();
        return $count;
    }

    /**
     * 运运动-微信公众号-会员累计天数
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/28
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    private static function gainMemberTotalDays($id)
    {
        //单例
        $model = EntryRecord::find();
        //构造器
        $model->where(['member_id' => $id]);
        $model->select(['COUNT(DISTINCT(FROM_UNIXTIME(entry_time,"%Y-%m-%d"))) memberTotalDays']);
        $count = $model->asArray()->all();
        return $count;
    }

    /**
     * 运运动-微信公众号-会员上课时长(单位: 分钟)
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/28
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    private static function gainMemberClassTime($id)
    {
        //单例
        $model = AboutClass::find();
        //构造器
        $model->where(['member_id' => $id]);
        $model->andWhere(['status' => 4]);
        $model->select('(SUM(end-start)/60) memberClassTime');
        $count = $model->asArray()->all();
        return $count;
    }

    /**
     * 运运动-微信公众号-会员约课次数
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/28
     * @param $id
     * @return array|\yii\db\ActiveRecord[]
     */
    private static function gainMemberAboutCourseCount($id)
    {
        //单例
        $model = AboutClass::find();
        //构造器
        $model->where(['member_id' => $id]);
        $model->select('COUNT(id) memberAboutCount');
        $count = $model->asArray()->all();
        return $count;
    }

    /**
     * 运运动-我的所有会员ID
     * @author 杨慧磊<yanghuilei@itsport.club>
     * @param $mobile
     * @createAt 2018/3/22
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function gainMyAllAccount($mobile)
    {
       $memberInfo = Member::find()->where(['mobile' => $mobile, 'company_id' => 1])->asArray()->all();
       if(!$memberInfo){
           return false;
       }
       return array_column($memberInfo, 'id');
    }
}