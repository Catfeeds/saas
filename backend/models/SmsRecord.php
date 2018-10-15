<?php
namespace backend\models;
use common\models\Func;
use common\models\Sms;
use Yii;
use common\models\relations\SmsRecordRelations;
class SmsRecord extends \common\models\base\SmsRecord
{
    use SmsRecordRelations;
    public $keywords;
    public $startTime;
    public $endTime;
    public $sorts;
    public $venueId;   // 场馆id
    public $venueIds;  //有权访问的场馆ID

    const KEY   = 'keywords';
    const START = 'startTime';
    const END   = 'endTime';
    const TYPE  = 'type';
    const VENUE = 'venueId';
    const VENUES = 'venueIds';


    /**
     * 短信管理 - 短信列表 - 获取排序条件
     * @create 2017/9/8
     * @author huanghua<huanghua@itsports.club>
     * @param $data
     * @return mixed
     */
    public static function loadSort($data)
    {
        $sorts = [
            'id' => SORT_DESC
        ];
        if (!isset($data['sortType'])) {
            return $sorts;
        }
        switch($data['sortType'])
        {
            case 'venueId'          :
                $attr = '`sr`.venue_id';
                break;
            case 'name'           :
                $attr = '`memberDetails`.name';
                break;
            case 'mobile'           :
                $attr = '`sr`.mobile';
                break;
            case 'status'        :
                $attr = '`sr`.status';
                break;
            case 'time'        :
                $attr = '`sr`.created_at ';
                break;
            case 'content'        :
                $attr = '`sr`.content';
                break;
            default;
                return $sorts;
        }
        return $sorts = [ $attr  => self::convertSortValue($data['sortName']) ];

    }
    /**
     * 短信管理 - 短信列表 - 获取搜索规格
     * @create 2017/9/8
     * @author huanghua<huanghua@itsports.club>
     * @param $sort
     * @return mixed
     */
    public static function convertSortValue($sort)
    {
        if ($sort == 'ASC') {
            return SORT_ASC;
        } elseif ($sort == 'DES') {
            return SORT_DESC;
        }
    }


    /**
     * 后台短信管理 - 短信列表 - 短信信息查询
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/8
     * @param $params //搜索参数
     * @return \yii\db\ActiveQuery
     */
    public function search($params)
    {
        $this->customLoad($params);
        $query = SmsRecord::find()
            ->alias('sr')
            ->joinWith(['organization organization'],false)
            ->joinWith([
                'member member'=>function($query){
                 $query->joinWith(['memberDetails memberDetails'],false);
                }
            ],false)
            ->select(
                "   
                sr.id,
                sr.venue_id,
                sr.mobile,
                sr.member_id,
                sr.status,
                sr.type,
                sr.created_at,
                sr.content,
                organization.id as venueId,
                organization.name,
                memberDetails.name as memberName,
                "
            )
            ->groupBy(["sr.id"])
            ->orderBy($this->sorts)
            ->asArray();
        $query                 = $this->getSearchWhere($query);
        $dataProvider          =  Func::getDataProvider($query,8);

        return  $dataProvider;
    }

    /**
     * 短信管理 - 短信列表 - 搜索数据处理数据
     * @create 2017/9/8
     * @author huanghua<huanghua@itsports.club>
     * @param $data
     * @return bool
     */
    public function customLoad($data)
    {
        $this->keywords     = (isset($data[self::KEY]) && !empty($data[self::KEY])) ? $data[self::KEY] : null;
        $this->startTime    = (isset($data[self::START])&& !empty($data[self::START]))? (int)strtotime($data[self::START]) : null;
        $this->endTime      = (isset($data[self::END]) && !empty($data[self::END])) ? (int)strtotime($data[self::END]) : null;
        $this->venueId      = (isset($data[self::VENUE]) && !empty($data[self::VENUE])) ? (int)$data[self::VENUE] : null;
        $this->venueIds     = (isset($data[self::VENUES]) && !empty($data[self::VENUES])) ? (int)$data[self::VENUES] : null;
        $this->sorts = self::loadSort($data);

        return true;
    }

    /**
     * 短信管理 - 短信列表 - 增加搜索条件
     * @create 2017/9/8
     * @author huanghua<huanghua@itsports.club>
     * @param $query
     * @return mixed
     */
    public function getSearchWhere($query)
    {
        $query->andFilterWhere([
            'and',
            ['like','memberDetails.name', $this->keywords]
        ]);

        $query->andFilterWhere([
            'and',
            ['>=','sr.created_at',$this->startTime],
            ['<','sr.created_at',$this->endTime]
        ]);
        $query->andFilterWhere([
            'and',
            [
                'sr.venue_id' => $this->venueId,
            ],
        ]);
        $query->andFilterWhere(['sr.venue_id'=>$this->venueIds]);

        return $query;
    }


    /**
     * 后台 - 短信管理 - 短信信息删除
     * @author huang hua <huanghua@itsports.club>
     * @create 2017/9/8
     * @param $venueId
     * @return bool
     */
    public static function getDelSmsAll($venueId)
    {
        $employee = Employee::findOne(['admin_user_id'=>\Yii::$app->user->identity->id]);
        if(empty($venueId)){
            $resultDel          =   SmsRecord::deleteAll(['venue_id'=>$employee['venue_id']]);
        }else{
            $resultDel          =   SmsRecord::deleteAll(['venue_id'=>$venueId]);
        }

        if($resultDel){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 后台短信管理 - 短信详情 - 列表短信详情信息
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/9
     * @param $smsId
     * @return \yii\db\ActiveQuery
     */
    public function  getSmsModel($smsId)
    {
        $model = SmsRecord::find()
            ->alias('sr')
            ->joinWith(['organization organization'],false)
            ->joinWith([
                'member member'=>function($query){
                    $query->joinWith(['memberDetails memberDetails'],false);
                }
            ],false)
            ->select(
                "   
                sr.id,
                sr.venue_id,
                sr.mobile,
                sr.member_id,
                sr.status,
                sr.type,
                sr.created_at,
                sr.content,
                organization.id as venueId,
                organization.name,
                memberDetails.name as memberName,
                "
            )
            ->where(['sr.id' => $smsId])
            ->asArray()->one();
        return $model;

    }
    /**
     * 后台短信管理 - 短信列表 - 重新发送
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/9/9
     * @param $smsId
     * @return \yii\db\ActiveQuery
     */
    public function  getSmsResend($smsId)
    {
        $data      =  SmsRecord::find()->where(['id'=>$smsId])->asArray()->one();
        $sms       = new Sms();
        $url       = $sms->url;
        $post_data = array (
            "appid"      => 13670,
            "to"         => $data['mobile'],
            "vars"       => $data['var'],
            "project"    => $data['send_code'],
            "signature"  =>'e42d2fdd6c56b5bcf5e119d66cbe409b'
        );
        $model    = $sms->commonData($url,$post_data,$data['type'],$smsId);

        if($model == true){
            return true;
        }else{
            return false;
        }
    }
}