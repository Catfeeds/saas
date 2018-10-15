<?php
namespace common\models;

use common\models\base\CardCategory;
use common\models\base\CardCategoryType;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii;
use common\components\UrlPager;
use backend\models\UploadForm;
use yii\web\UploadedFile;
class Func extends Model
{
    /**
     * 云运动 - 查询数据 - 获取分页
     * @author lihuien<lihuien@itsports.club>
     * @create 2017/3/30
     * @param $query
     * @param int $limit
     * @return ActiveDataProvider
     */
    public static function getDataProvider($query,$limit = 5)
    {
        $dataProvider = new ActiveDataProvider([
            'query'      => $query,
            'pagination' => [
                'pageSize' => $limit,
                'totalCount' => $query->count(),
            ],
        ]);
        return $dataProvider;
    }
    /**
     * 云运动 - 查询数据 - 获取本周开始结束时间
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/4/13
     * @param $attr //参数 例如获取周 天 月
     * @param $bool //获取开始还是结束
     * @return int|string
     */
    public static function getGroupClassDate($attr,$bool)
    {
        if($attr == 'd'){
            if($bool){
                return  date('Y-m-d',time()).' 00:00:00';
            }else{
                return date('Y-m-d',time()).' 23:59:59';
            }
        }else if ($attr == 'w'){
            if($bool){
//                return date('Y-m-d',mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y'))).' 00:00:00';  //上周
                return date("Y-m-d",mktime(0,0,0,date("m"),date("d")-date("w")+1,date("Y"))).' 00:00:00';  //本周
            }else{
//                return date('Y-m-d',mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'))).' 23:59:59';
                return date("Y-m-d",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y"))).' 23:59:59';
            }
        }else{
            if($bool){
               return date('Y-m-d',mktime(0,0,0,date('m'),1,date('Y'))).' 00:00:00';
            }else{
                return date('Y-m-d',mktime(23,59,59,date('m'),date('t'),date('Y'))).' 23:59:59';
            }
        }
    }

    /**
     * 云运动 - 查询数据 - 获取本周开始结束时间
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/12/15
     * @param $attr //参数 例如获取 天 周 月 季度 年
     * @param $bool //获取开始还是结束
     * @return int|string
     */
    public static function getTokenClassDate($attr,$bool)
    {
        if($attr == 'd'){
            if($bool){
                return  date('Y-m-d',time()).' 00:00:00';
            }else{
                return date('Y-m-d',time()).' 23:59:59';
            }
        }else if ($attr == 'w'){
            $datew = date('w') ?: 7;
            if($bool){
                return date("Y-m-d",mktime(0,0,0,date("m"),date("d")-$datew+1,date("Y"))).' 00:00:00';  //本周
            }else{
                return date("Y-m-d",mktime(23,59,59,date("m"),date("d")-$datew+7,date("Y"))).' 23:59:59';
            }
        }else if ($attr == 'm'){
            if($bool){
                return date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),1,date("Y")));
            }else{
                return date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("t"),date("Y")));
            }
        }else if ($attr == 's'){
            $season = ceil((date('n'))/3);
            if($bool){
                return date('Y-m-d H:i:s', mktime(0, 0, 0,$season*3-3+1,1,date('Y')));
            }else{
                return date('Y-m-d H:i:s', mktime(23,59,59,$season*3,date('t',mktime(0, 0 , 0,$season*3,1,date("Y"))),date('Y')));
            }
        }else{
            if($bool){
                return date('Y-m-d',mktime(0,0,0,1,1,date('Y'))).' 00:00:00';
            }else{
                return date('Y-m-d',mktime(23,59,59,12,31,date('Y'))).' 23:59:59';
            }
        }
    }
    /**
     * 云运动 - 分页 - 获取格式化样式
    * @author lihuien<lihuien@itsports.club>
     * @create 2017/3/30
     * @param $pagination
     * @param $fun
     * @return string
     * @throws \Exception
     */
    public static function getPagesFormat($pagination,$fun = 'replacementPages' )
    {
        $pages      = UrlPager::widget([
            'pagination'     => $pagination,
            'firstPageLabel' => '首页',
            'prevPageLabel'  => '上一页',
            'nextPageLabel'  => '下一页',
            'lastPageLabel'  => '尾页',
            'jsPageFun'      => $fun
        ]);
        return $pages;
    }
    /**
     *后台会员管理 - 会员信息 - 出生日期，转换成年龄
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/3/30
     * @return bool|string
     */
    public static function getMemberAge($MemberAge)
    {
        return date('Y',time()) - date('Y',strtotime($MemberAge));
    }

    /**
     *后台会员管理 - 会员信息 - 年龄，转换成出生日期
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/3/31
     * @param $birth_date
     * @param $age
     * @return string
     */
    public static function setMemberAge($birth_date,$age)
    {
        $MonthDay    = date('m-d',strtotime($birth_date)); //截取出生日期的月份天数
        $NowYear     = date('Y',time());                   //获取当前年
        $lastYear    = $NowYear - $age;                    //获取修改年龄后的年数
        $birth_dates = $lastYear.'-'.$MonthDay;            //拼接新的出生日期
        return $birth_dates;
    }

    /**
     * 后台会员管理 - 信息 - 设置日期
     * @param $param1
     * @param $param2
     * @return int
     */
    public static function setTimeHour($param1,$param2)
    {
        if($param1){
            if(isset($param2)){
                $date = $param1.' '.$param2;
            }else{
                $date = $param1;
            }
        }else{
            return null;
        }
        return strtotime($date);
    }

    /**
     * 云运动 - 会员管理 -  批量生成会员
     * @throws yii\db\Exception
     * @author lihuien<lihuien@itsports.club>
     * @create 2017/4/1
     */
    public static function setMemberBase()
    {
        $queryBuilder = Yii::$app->db->createCommand();
        $sql = $queryBuilder->batchInsert('{{%member}}',
            ['username', 'password','mobile','register_time','status'],
            [
            ['Tom',mt_rand(100000,999999),'15676566711',time(),0],
            ['Jane',mt_rand(100000,999999),'15676566722',time(),0],
            ['Linda',mt_rand(100000,999999),'15676566733',time(),0],
            ['Xiao',mt_rand(100000,999999),'15676566744',time(),0],
            ['ming',mt_rand(100000,999999),'15676566755',time(),0],
            ['haha',mt_rand(100000,999999),'15676566766',time(),0],
            ['hehhe',mt_rand(100000,999999),'15676566777',time(),0],
            ['heine',mt_rand(100000,999999),'15676566788',time(),0],
            ['heihei',mt_rand(100000,999999),'15676566799',time(),0],
           ]);
        $int = $sql->execute();
        if($int){
            $data = CardCategoryType::find()->all();
            if(isset($data) && empty($data)){
                self::setCardType();
                self::setCard();
            }
            self::setMemberDetail($queryBuilder,$int);
            self::setMemberCard($queryBuilder,$int);
            return true;
        }else{
            return false;
        }

    }
    /**
     * 云运动 - 会员管理 -  批量生成卡类型
     * @throws yii\db\Exception
     * @author lihuien<lihuien@itsports.club>
     * @create 2017/4/11
     */
    public static function setCardType(){
        $queryBuilder = Yii::$app->db->createCommand();
        $sql = $queryBuilder->batchInsert('{{%card_category_type}}',
            ['type_name','create_at'],
            [
                ['时间卡',time()], ['次卡',time()], ['充值卡',time()], ['混合卡',time()],
            ]);
        $sql->execute();
    }
    /**
     * 云运动 - 会员管理 -  批量生成卡种数据
     * @throws yii\db\Exception
     * @author lihuien<lihuien@itsports.club>
     * @create 2017/4/11
     */
    public static function setCard()
    {
        $queryBuilder = Yii::$app->db->createCommand();
        $sql = $queryBuilder->batchInsert('{{%card_category}}',
            ['category_type_id',
              'card_name',
              'create_at',
              'class_server_id',
              'server_combo_id',
              'sell_end_time',
              'venue_id',
              'create_id',
              'active_time',
              'status',
              'sell_price',
              'times',
            ],
            [
                [mt_rand(1,4),['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'][array_rand(['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'],1)].mt_rand(100,time()),time(),1,1,mt_rand(946659661,time()),mt_rand(1,3),1,mt_rand(10,60),mt_rand(1,3),mt_rand(10000,999999),mt_rand(10,100)],
                [mt_rand(1,4),['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'][array_rand(['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'],1)].mt_rand(100,time()),time(),1,1,mt_rand(946659661,time()),mt_rand(1,3),1,mt_rand(10,60),mt_rand(1,3),mt_rand(10000,999999),mt_rand(10,100)],
                [mt_rand(1,4),['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'][array_rand(['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'],1)].mt_rand(100,time()),time(),1,1,mt_rand(946659661,time()),mt_rand(1,3),1,mt_rand(10,60),mt_rand(1,3),mt_rand(10000,999999),mt_rand(10,100)],
                [mt_rand(1,4),['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'][array_rand(['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'],1)].mt_rand(100,time()),time(),1,1,mt_rand(946659661,time()),mt_rand(1,3),1,mt_rand(10,60),mt_rand(1,3),mt_rand(10000,999999),mt_rand(10,100)],
                [mt_rand(1,4),['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'][array_rand(['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'],1)].mt_rand(100,time()),time(),1,1,mt_rand(946659661,time()),mt_rand(1,3),1,mt_rand(10,60),mt_rand(1,3),mt_rand(10000,999999),mt_rand(10,100)],
                [mt_rand(1,4),['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'][array_rand(['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'],1)].mt_rand(100,time()),time(),1,1,mt_rand(946659661,time()),mt_rand(1,3),1,mt_rand(10,60),mt_rand(1,3),mt_rand(10000,999999),mt_rand(10,100)],
                [mt_rand(1,4),['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'][array_rand(['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'],1)].mt_rand(100,time()),time(),1,1,mt_rand(946659661,time()),mt_rand(1,3),1,mt_rand(10,60),mt_rand(1,3),mt_rand(10000,999999),mt_rand(10,100)],
                [mt_rand(1,4),['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'][array_rand(['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'],1)].mt_rand(100,time()),time(),1,1,mt_rand(946659661,time()),mt_rand(1,3),1,mt_rand(10,60),mt_rand(1,3),mt_rand(10000,999999),mt_rand(10,100)],
                [mt_rand(1,4),['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'][array_rand(['尊爵卡','瑜伽卡','爵士卡','肚皮舞卡'],1)].mt_rand(100,time()),time(),1,1,mt_rand(946659661,time()),mt_rand(1,3),1,mt_rand(10,60),mt_rand(1,3),mt_rand(10000,999999),mt_rand(10,100)],
            ]);
        $sql->execute();
    }
    /**
     * * 云运动 - 会员管理 -  批量生成会员详情
     * @throws yii\db\Exception
     * @author lihuien<lihuien@itsports.club>
     * @create 2017/4/1
     * @param $queryBuilder
     * @param $int
     */
    public static function setMemberDetail($queryBuilder,$int)
    {
        $idArr = Member::find()->orderBy('id DESC')->limit($int)->all();
        if(isset($idArr)){
            $nameArr = ['梅长苏','东方不败','曾小贤','胡一菲','夏目','金木研','路飞','佐助','詹姆斯','库里','杜兰特'];
            foreach ($idArr as $v){ 
                $birth = mt_rand(1980,2010).'-'.mt_rand(1,12).'-'.mt_rand(1,30);
                $name = $nameArr[array_rand($nameArr,1)].$v['id'];
                $sql = $queryBuilder->batchInsert('{{%member_details}}',
                    ['member_id', 'name','sex','birth_date','recommend_member_id'],
                    [
                        [$v['id'] ,$name,mt_rand(1,2),$birth,0],
                    ]);
                $int = $sql->execute();
            }
        }
    }

    /**
     * 云运动 - 会员管理 -  批量生成会员卡
     * @throws yii\db\Exception
     * @author lihuien<lihuien@itsports.club>
     * @create 2017/4/1
     * @param $queryBuilder
     * @param $int
     */
    public static function setMemberCard($queryBuilder,$int)
    {
        $idArr = Member::find()->orderBy('id DESC')->limit($int)->all();
        $cardId = CardCategory::find()->select('id')->orderBy('id DESC')->all();
        if(isset($idArr)){
            foreach ($idArr as $k=>$v){
                $sql = $queryBuilder->batchInsert('{{%member_card}}',
                    ['card_category_id',
                     'card_number',
                     'member_id',
                     'status',
                     'payment_type',
                     'is_complete_pay',
                     'active_time',
                     'invalid_time',
                     'level'],
                    [
                        [(int)$cardId[$k]['id'],(int)$v['id'] ,(int)$v['id'], 1,1,1,mt_rand(946659661,1199120461),mt_rand(1199120461,time()),1],
                    ]);
                $int = $sql->execute();
            }
        }
    }

    /**
     * @云运动 - 发送验证码
     * @author Xingsonglin <xingsonglin@itsports.club>
     * @create 2017/4/5
     * @param $to  要发送的手机号码
     * @param $code  验证码
     * @return json  status 状态:success/error   fee 条数
     * @inheritdoc
     */
    public static function sendCode($to,$code){
        $model = new Sms();
        $msg = $model->sendCode($to,$code);
        return json_decode($msg,true);
    }
    /**
     * @云运动 - 会员卡激活成功发送信息
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/7/13
     * @param $to  要发送的手机号码
     * @return json  status 状态:success/error   fee 条数
     * @inheritdoc
     */
    public static function sendMessage($to,$cardName){
        $model = new Sms();
        $msg = $model->sendMessage($to,$cardName);
        return json_decode($msg,true);
    }
    /**
     * @团课排课 - 已有人预约的团课修改课程或教练
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/04/10
     * @inheritdoc
     */
    public static function sendUpdateLeague($to,$classTime,$oldCoach,$newCoach,$oldClass,$newClass){
        $model = new Sms();
        $msg = $model->sendUpdateLeague($to,$classTime,$oldCoach,$newCoach,$oldClass,$newClass);
        return json_decode($msg,true);
    }
    /**
     * @云运动 - 发送预约成功
     * @author Huangpengju <Huangpengju@itsports.club>
     * @create 2017/5/12
     * @param $to  要发送的手机号码
     * @param $info  发送成功信息
     * @return json  status 状态:success/error   fee 条数
     * @inheritdoc
     */
    public static function sendInfo($to,$companyId,$venueId,$course,$classDate,$start,$end){
        $model = new Sms();
        $msg = $model->sendInfo($to,$companyId,$venueId,$course,$classDate,$start,$end);
        return json_decode($msg,true);
    }
    /**
     * @云运动 - 会员购买私课 - 发送短信
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/7/21
     * @param $to 手机号
     * @inheritdoc
     */
    public static function memberCharge($to){
        $model = new Sms();
        $msg = $model->memberCharge($to);
        return json_decode($msg,true);
    }
    /**
     * @云运动 - 售卡成功发送短信
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/6/5
     * @param $to  要发送的手机号码
     * @param $info  发送的信息内容
     * @return json  status 状态:success/error   fee 条数
     * @inheritdoc
     */
    public static function sendSellCardInfo($to,$info){
        $model = new Sms();
        $msg = $model->sendSellCardInfo($to,$info);
        return json_decode($msg,true);
    }
    /**
     * @云运动 - 发送预约成功
     * @author Huanghua <Huanghua@itsports.club>
     * @create 2017/5/12
     * @param $to  要发送的手机号码
     * @param $course  课程名
     * @param $info  信息 会员下课成功
     * @return json  status 状态:success/error   fee 条数
     * @inheritdoc
     */
    public static function sendClassInfo($to,$course,$info){
        $model = new Sms();
        $msg = $model->sendClassInfo($to,$course,$info);
        return json_decode($msg,true);
    }
    /**
     * 上传图片路径到七牛
     * @author xingsonglin
     * @param $filePath  //图片本地路径
     * @param $fileName  //图片名称(包含扩展名)
     * @return array key文件名
     * @throws \Exception
     */
    public static function uploadFile($filePath,$fileName){
        $model = new Qiniu();
        $return = $model->uploadFile($filePath,$fileName);
        return $return;
    }

    /**
     * 上传图片路径到七牛并回调到服务器
     * @author xingsonglin
     * @param $filePath  图片本地路径
     * @param $fileName  图片名称(包含扩展名)
     * @return array key文件名
     * @throws \Exception
     */
    public static function uploadFileCallback($filePath,$fileName){
        $model = new Qiniu();
        $return = $model->uploadFileCallback($filePath,$fileName);
        return $return;
    }
    /**
     * 上传图片回调函数
     * @author xingsonglin
     * @return json key文件名
     * @throws \Exception
     */

    public static function callBack()
    {
        $model = new Qiniu();
        $return = $model->callBack();
        return $return;
    }

    /**
     * 删除七牛上的图片
     * @author xingsonglin
     * @param $fileName  图片名称(包含扩展名)
     * @return bool
     * @throws \Exception
     */

    public static function deleteImg($fileName)
    {
        $model = new Qiniu();
        $return = $model->deleteImg($fileName);
        return $return;
    }

    /**
     * @desc 得到图片完整路径
     * @author xingsonglin
     * @param $fileName //文件名称
     * @return string 文件路径
     *
     */
    public static function getImgUrl($fileName){
        $model = new Qiniu();
        $return = $model->getImgUrl($fileName);
        return $return;
    }
    /**
     * 后台 - 上传图片 - 公共调用七牛类
     * @return string
     * @author 李慧恩
     * @create 2017-4-6
     * @param
     */
    public static function uploadImage()
    {
        $upload = new UploadForm();
        if (\Yii::$app->request->isPost) {
            $upload->imageFile = UploadedFile::getInstance($upload, 'imageFile');
            if ($upload->imageFile && ($upload->imageFile->type == "image/jpeg" || $upload->imageFile->type == "image/pjpeg" || $upload->imageFile->type == "image/png" || $upload->imageFile->type == "image/x-png" || $upload->imageFile->type == "image/gif" || $upload->imageFile->type == "video/mp4" || $upload->imageFile->type == "video/avi")) {
                if( $upload->imageFile->type == "video/mp4" || $upload->imageFile->type == "video/avi" ){
                    if($upload->imageFile->size > 100000000){
                        return json_encode(['status' => 'error', 'data' => '上传的文件太大']);
                    }
                }else{
                    if($upload->imageFile->size > 2000000){
                        return json_encode(['status' => 'error', 'data' => '上传的文件太大']);
                    }
                }
                $extend     = explode("." , $upload->imageFile->name);
                $extends    = end($extend);
                $photoName  = rand(1,999999).time().'.'.$extends;
                $upload->imageFile->name = $photoName;
                self::uploadFile($upload->imageFile->tempName,$upload->imageFile->name);
                $url = self::getImgUrl($upload->imageFile->name);
                return json_encode(['status' => 'success','imgLink' => $url]);
            }else{
                return json_encode(['status' => 'error', 'data' =>'图片格式出现错误']);
            }
        }
        return json_encode(['status' => 'error', 'data' =>'上传出错']);
    }
    /**
     * 云运动 - 会员管理 - 二维转一维
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/13
     * @param $data array //多维数组
     * @return bool
     */
    public static function setArrayByTwoArray($data)
    {
        $arr = [];
        if(is_array($data) && !empty($data)){
            foreach ($data as $k=>$v){
                if(is_array($v) && !empty($v)){
                    foreach ($v as $key=>$value){
                        if(is_array($value) && !empty($value)){
                            foreach ($value as $e){
                                $arr[] = $e;
                            }
                        }
                    }
                }
            }
        }
        return $arr;
    }

    /**
     * 云运动 - 会员管理 - 环境判断
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/13
     * @return bool
     */
    public static function autoGeneration()
    {
        if(YII_ENV != 'dev'){
            return false;           //product线上环境
        }else{
            return true;            //qa测试环境 
        }
    }

    /**
     * 云运动 - 公共转换时间戳 - mkTime方法
     * @param $m int 月份
     * @param $d int 号
     * @param $y int 年份
     * @return int
     */
   public static function getMkTimeDate($m,$d,$y)
   {
      return  mktime(0,0,0,$m,$d,$y);
   }

    /**
     * 云运动 - 卡种属性 - 定义数组公用
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/27
     * @return array
     */
    public function setCardAttributes()
    {
        return [
            ['key'=>'1','val'=>'个人'],
            ['key'=>'2','val'=>'家庭'],
            ['key'=>'3','val'=>'公司']
        ];
    }
    /**
     * 云运动 - 卡种属性 - 隐藏手机号部分数字
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/4/27
     * @param  $attr
     * @param  $type
     * @return array
     */
    public static function phoneHide($attr,$type = 'mobile',$len=9)
    {
        if($type == 'name'){
            return str_replace(substr($attr,$len), '...', $attr);
        }
        return str_replace(substr($attr, 3, 6), '******', $attr);
    }

    /**
     * 云运动 - 迈步 - 办卡发送短信
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/6/21
     * @param $to       //发给谁
     * @param $cardName  //卡名
     * @param $deal     //合同名
     * @return string
     */
    public static function sellCardSendCode($to,$cardName,$deal)
    {
        $model = new Sms();
        $msg   = $model->setSellCardCode($to,$cardName,$deal);
        return json_encode($msg,true);
    }
    /**
     * 云运动 - 迈步 - 办卡发送短信
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/6/21
     * @param $to       //发给谁
     * @param $cardName  //卡名
     * @param $deal     //合同名
     * @return string
     */
    public static function memberBirthSendCode($to,$cardName)
    {
        $model = new Sms();
        $msg   = $model->setMemberBirthCode($to,$cardName);
        return json_encode($msg,true);
    }
    /**
     * 云运动 - 迈步 - 开业发送短信
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/6/21
     * @param $to       //发给谁
     * @param $str
     * @return string
     */
    public static function comeMemberSendCode($to,$str,$code)
    {
        $model = new Sms();
        $msg   = $model->setComeInMaiBuCode($to,$str,$code);
        return json_encode($msg,true);
    }
    /**
     * 云运动 - 会员维护 - 发送健身目标短信、发送饮食计划短信
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/11/27
     * @param $to      //发给谁
     * @param $name    //卡名
     * @param $content //合同名
     * @return string
     */
    public static function sendFitnessDiet($to,$content)
    {
        $model = new Sms();
        $msg   = $model->sendFitnessDiet($to,$content);
        return json_encode($msg,true);
    }
    /**
     * 云运动 - 更柜管理 - 给会员提醒柜子
     * @author huanghua <huanghua@itsports.club>
     * @create 2017/12/15
     * @param $to      //发给谁
     * @param $name    //用户名
     * @param $typeTame //区域名
     * @param $cabinetNumber//柜子编号
     * @param $endRent//到期时间
     * @return string
     */
    public static function sendCabinetData($to,$name,$typeTame,$cabinetNumber,$endRent)
    {
        $model = new Sms();
        $msg   = $model->sendCabinet($to,$name,$typeTame,$cabinetNumber,$endRent);
        return json_encode($msg,true);
    }
    /**
     * 云运动 - 迈步 - 办卡发送短信
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/6/21
     * @param $to       //发给谁
     * @param $cardName  //卡名
     * @param $url     //合同名
     * @return string
     */
    public static function sellAliCardSendCode($to,$cardName,$url)
    {
        $model = new Sms();
        $msg   = $model->setAliPaySellCardCode($to,$cardName,$url);
        return json_encode($msg,true);
    }
    /**
     * 云运动 - 迈步 - 返回订单号
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/6/21
     * @return string
     */
    public static function setOrderNumber()
    {
        $mTime     = explode(' ',microtime());
        $startTime = $mTime[1].($mTime[0]*1000);
        $timeArr   = explode('.',$startTime);
        if(is_array($timeArr) && isset($timeArr[0])){
           return  $timeArr[0].mt_rand(100,999);
        }
        return $startTime.mt_rand(100,999);
    }
    /**
     * 云运动 - 迈步 - 返回值
     * @author 李慧恩 <lihuien@itsports.club>
     * @create 2017/6/21
     * @param  $arr
     * @param  $name
     * @return string
     */
    public static function setReturnMessageArr($arr,$name)
    {
        if(isset($arr) && !empty($arr)){
            foreach ($arr as  $k=>$v){
                return $v[0];
            }
        }
        return $name;
    }

    /**
     * 云运动 - 迈步 - 返回关联值
     * 类似$model->member->memberCard->card_number用此方法防止因数据不符报错终止运行
     * 用法：Func::getRelationVal($model, 'member', 'memberCard', 'card_number')
     * @author zhangxiaobing <zhangxiaobing@itsports.club>
     * @create 2017/12/16
     * @param  $model
     * @param  $args
     * @return string
     */
    public static function getRelationVal()
    {
        $args = func_get_args();
        $model = array_shift($args);
        foreach ($args as $arg){
            if(!isset($model->$arg)) return '';
            $model = $model->$arg;
        }
        return $model;
    }

    /**
     * @云运动 - 微信公众号 - 去除合同富文本标签
     * @author 焦冰洋<jiaobingyang@itsports.club>
     * @param  $data
     * @create 2018/3/6
     * @inheritdoc
     */
    public static function format($data)
    {
        $content_01 = $data;//从数据库获取富文本content
        $content_02 = htmlspecialchars_decode($content_01);//把一些预定义的 HTML 实体转换为字符
        $content_03 = str_replace("&nbsp;","",$content_02);//将空格替换成空
        $content_04 = str_replace("</p>", "</p>\n", $content_03);
        $contents   = strip_tags($content_04);//函数剥去字符串中的 HTML、XML 以及 PHP 的标签,获取纯文本内容
        return $contents;
    }

    /**
     * 运运动-七牛云上传base64文件
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/3/7
     * @param $base64_str
     * @param $fileName
     * @return mixed
     */
    public static function uploadBase64($fileName, $base64_str)
    {
        $qinNiu   = new Qiniu();
        $imgReUrl = $qinNiu->uploadBase64($fileName, $base64_str);
        return $imgReUrl;
    }

    /**
     * 时间处理函数  传入时间戳 int
     * 返回interesting 该时间戳当天23点59分59秒
     *
     */
    public static function getTheEndTimeStamp($a=0)
    {
        $d = new \DateTime("@$a");
        $d->setTimezone(new \DateTimeZone('PRC'));


        $d = new \DateTime($d->format('Y-m-d').' 23:59:59');

        return  $d->format('U');
    }
    /**
     * 处理无限极分类数据
     *@param $list  按照pid正序查出来的二维数组
     */
    public static function getDeepList($result)
    {
        $result1 = $result;
        $maxNum = 1000;//设置最大循环次数
        $count = -1;//设置计数
        //默认根节点内容
        $root = array(
            'id' => '0',
            'text' => 'root',
        );
        //辅助，主要作用用于检测节点是否存在
        //注：下面使用的技巧都是使用对象的引用，赋值的不是一个具体值，而是一个引用
        $existsMap = array(
            '0' => &$root,
        );
        //结果记录的长度
        $len = count($result1);
        //计数
        $num = 0;
        //遍历结果集
        while ($num < $len) {
            $count++;
            //如果计数器超过了最大循环次数就退出循环
            if ($count > $maxNum) break;
            $i = $count % $len;//取得下标，取莫的作用是防止下标超出边界
            $obj = $result[$i];//取得当前节点
            if (!$obj) continue;//不存在则跳过
            $pidObj = & $existsMap[$obj['pid']];//检测辅助数组中是否有父节点数据并赋引用值给pidObj
            if (!$pidObj) continue;
            //如果存在pidObj，则设置当前节点在existsMap中
            $existsMap[$obj['id']] = array(
                'id' => $obj['id'],
                'title' => $obj['title'],
            );
            //设置子节点
            if (!isset($pidObj['children'])) {
                $pidObj['children'] = [];
            }
            //设置子节点为刚刚存在辅助数组中得引用
            $pidObj['children'][] = & $existsMap[$obj['id']];
            unset($result[$i]);
            $num++;
        }
        //根据自己的需求，决定是否返回root节点
        return $root['children'];
    }
    /**
     *  封装一个方法 用于批量修改(此方法建议放在yii\db\Command里 直接 Yii::$app->db->createCommand()->batchUpdate(调用)->execute();)
     *  参数说明: 表名,要修改的字段数组,数据字典,条件或主键数组,条件或主键字段
     *  params: table_name,columns,rows,conditionArrs,condition_columns
     *   return 一个sql
     *   $connection->createCommand()->batchUpdate('user', ['name', 'age'], [
     *   ['Tom', 30],
     *   ['Jane', 20],
     *   ['Linda', 25],
     *   ],[ 1, 2, 3],'id')->execute();
     *   return sql:UPDATE user SET name = CASE id WHEN '1' THEN 'Tom' WHEN '2' THEN 'Jane' WHEN '3' THEN 'Linda' END, age = CASE id WHEN '1' THEN 30 WHEN '2' THEN 20 WHEN '3' THEN 25 END, age = CASE id WHEN '1' THEN 25 WHEN '2' THEN 25 WHEN '3' THEN 25 END WHERE id IN ('1','2','3')
     *
     */
    public static function batchUpdate($table, $columns, $rows, $keyPrimaryArrs,$keyPrimaryColumn)
    {

        $sql  = '';
        $sql .= 'UPDATE '.$table.' SET ';
        $rowsCount = count($rows);
        $columnsCount = count($columns);
        $columnName ='';
        $rowFang = '';

        for ( $i = 0; $i < $rowsCount-1; $i++ ){

            $columnName = isset($columns[$i])?$columns[$i]:$columnName;
            $sql .= $columnName.' = CASE '.$keyPrimaryColumn;

            for ( $j = 0; $j < $rowsCount; $j++ ){
                $rowFang = isset($rows[$j][$i])?$rows[$j][$i]:$rowFang;
                $keyPrimary = isset($keyPrimaryArrs[$j])?$keyPrimaryArrs[$j]:$keyPrimary;
                if (gettype($rowFang)=='integer'){
                    $sql .= ' WHEN \''.$keyPrimary.'\' THEN '.$rowFang;
                }else{
                    $sql .= ' WHEN \''.$keyPrimary.'\' THEN \''.$rowFang.'\'';
                }
            }

            if ($i === $rowsCount){
                $end = ' END ';
            }else{
                $end = ' END, ';
            }
            $sql .= $end;
        }

        $conditions = '(\''.implode('\',\'',$keyPrimaryArrs).'\')';

        $sql .= ' WHERE '.$keyPrimaryColumn.' IN '.$conditions;
        $sql  = str_replace('END,  WHERE','END  WHERE',$sql);

        return $sql;
    }
    /**
     * @desc:上传excel文件
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/11
     * @time: 14:11
     * @return string
     * @throws \Exception
     */
    public static function uploadExcel()
    {
        $upload = new UploadForm();
        if (\Yii::$app->request->isPost) {
            $upload->imageFile = UploadedFile::getInstance($upload, 'imageFile');
            $dot = strpos($upload->imageFile->name, ".");
            $file_name = substr($upload->imageFile->name, $dot+1);

            if ($upload->imageFile && $file_name == 'xls') {
                if($upload->imageFile->size > 1024*1024*1024){
                    return json_encode(['status' => 'error', 'data' => '上传的文件太大']);
                }
                $extend     = explode("." , $upload->imageFile->name);
                $extends    = end($extend);
                $photoName  = rand(1,999999).time().'.'.$extends;
                $upload->imageFile->name = $photoName;
//                $upload->imageFile->name = $photoName;
//                self::uploadFile($upload->imageFile->tempName,$upload->imageFile->name);
//                $path = self::getImgUrl($upload->imageFile->name);

                $is_dir = \Yii::$app->basePath . '/web/excel/'.date('Ymd').'/';
                //判断该目录是否存在
                if(!is_dir($is_dir)){
                    mkdir ($is_dir,0777,true);
                }
                $path = $is_dir.$photoName;//设置移动路径
                move_uploaded_file($upload->imageFile->tempName,$path);

                return json_encode(['status' => 'success','imgLink' => $path]);
            }else{
                return json_encode(['status' => 'error', 'data' =>'上传出现错误']);
            }
        }
        return json_encode(['status' => 'error', 'data' =>'上传出错']);
    }

    /**
     * @desc:二维数组去重复值
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/12
     * @time: 17:47
     * @param $data
     * @return array
     */
    public function arrDropRepeat($data)
    {
        foreach ($data as $v) {
            $v = join(',', $v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[] = $v;
        }

        $temp = array_unique($temp); //去掉重复的字符串,也就是重复的一维数组

        foreach ($temp as $k => $v) {
            $temp[$k] = explode(',', $v); //再将拆开的数组重新组装
        }

        return $temp;

    }
    /**
     * @desc:为cache缓存设置唯一ID
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/1
     * @time: 16:35
     * $key      key      缓存key值
     * $data     data      缓存数据
     * $expire   expire      缓存时间，默认是10分钟
     */
    public static function setCacheData($key, $data, $expire = '600'){
        //用户的iD和用户名+key 组成唯一的Cache id
        $userInfo = Yii::$app->user->identity;
        $key = $userInfo['id'].$userInfo['username'].$key;
        \Yii::$app->cache->set($key, $data, $expire);
    }

    /**
     * @desc:获取缓存数据
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/1
     * @time: 16:52
     * @param $key
     * @date: 2018/6/13
     * @time: 15:12
     * @param $key
     * @return mixed
     */
    public  static  function getCacheData($key){
        $userInfo = Yii::$app->user->identity;
        $key = $userInfo['id'].$userInfo['username'].$key;

        $data = \Yii::$app->cache->get($key);
        return $data;
    }

    /**
     * @desc:销毁过期的个人cache，减少数据库压力
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/2
     * @time: 10:30
     */
    public  static function  removeCache(){
        $userInfo = Yii::$app->user->identity;
        $key = $userInfo['id'].$userInfo['username'];
        \Yii::$app->cache->gc($key);


    }
    /**
     * saas-发送验证码-验证手机号码格式是否正确
     * @author   xinwei<xinwei@itsport.club>
     * @createAt 2018/08/08
     * @return bool
     */
    public static function validPhone($phone)
    {
        //手机号码
        $isMob = "/^1[345678]{1}\d{9}$/";
        if ((!preg_match($isMob,$phone))) {
            return false;
        }
        return true;
    }
}