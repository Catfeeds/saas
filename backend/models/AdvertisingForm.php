<?php
/**
 * Created by PhpStorm.
 * User: 付钟超 <fuzhongchao@itsports.club>
 * Date: 2018/5/6 0006
 * Time: 08:59
 */

namespace backend\models;

use common\models\Advertising;
use common\models\AdvertisingSetting;
use common\models\AdvertisingStatistics;

class AdvertisingForm extends Advertising
{
    //add场景参数
    public $companyId;                      //公司id
    public $name;                           //广告名称
    public $note;                           //广告备注

    //edit场景参数
    public $advId;                          //广告id
    public $photo;                          //图片地址
    public $url;                            //跳转链接
    public $is_over;                        //是否可跳过
    public $show_time;                      //展示秒数
    public $venue_ids;                      //场馆数组
    public $start;                          //开始时间
    public $end;                            //结束时间
    public $roleId;                         //权限id
    /**
     * @desc: 业务后台 - 广告场景 - 新增&编辑
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return array
     */
    public function scenarios()
    {
        return [
            'add'  => ['name', 'note','companyId','roleId'],
            'edit' => ['advId','photo','is_over','show_time','venue_ids','start','end','companyId','roleId','url'],
        ];
    }

    public function rules()
    {
        return [
            [['name'], 'required', 'on'=> 'add'],
            [['photo','is_over','show_time','venue_ids','start','end'],'required','on'=> 'edit'],
            [['name','note','companyId','advId','photo','url','is_over','show_time','venue_ids','start','end','roleId'], 'safe', 'on'=> ['add','edit']]
        ];
    }

    /**
     * @desc: 业务后台 - 广告 - 新增广告名称&备注
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return bool
     */
    public function add()
    {
        if ($this->roleId == 0) {
            return 'no';            //管理员不能修改
        }
        $set = $this->selectSet();
        if (empty($set)) {
            return false;			//找不到此公司的设置
        }
        $model = new Advertising();
        $model->name = $this->name;
        $model->note = $this->note;
        $model->create_at = time();
        $model->create_id = \Yii::$app->user->identity->id;
        if (isset($set->id)) {
            $model->setting_id = $set->id;
        }
        $result = $model->save();
        if (!$result) {
            return false;
        }
        return true;
    }

    /**
     * @desc: 业务后台 - 广告 - 编辑&&修改
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return bool|string
     * @throws \yii\db\Exception
     */
    public function edit()
    {
        if ($this->roleId == 0) {
            return 'no';            //管理员不能修改
        }
        $adv = Advertising::findOne($this->advId);
        if (empty($adv)) {
            return 'no';           //找不到此数据
        }
        if ($adv->status == 1) {
            return false;           //启用中不能编辑
        }
        //对场馆数组进行处理
        $venueIds = array_map(function ($v){return array('venue'=>$v);}, $this->venue_ids);
        $transaction        =  \Yii::$app->db->beginTransaction();                //开启事务
        try{
            $adv->photo         = $this->photo;
            $adv->url           = $this->url ?: '';
            $adv->is_over       = $this->is_over;       //是否可跳过 0 不可跳过, 1 可跳过
            $adv->show_time     = $this->show_time;
            $adv->venue_ids     = json_encode($venueIds);
            $adv->start         = strtotime($this->start);
            $adv->end           = strtotime($this->end);
            $adv->update_time   = time();
            $result = $adv->save();
            if (!$result) {
                return 'editError';           //编辑失败
            }
            if (count($this->venue_ids) == 1 && $this->venue_ids[0] == 0) {
                //获取所有场馆
                $this->venue_ids = \common\models\Organization::find()->where(['and',['style'=>2],['is_allowed_join'=>1]])->andFilterWhere(['pid'=>$this->companyId])->asArray()->column();
            }
            foreach ($this->venue_ids as $venue_id) {
                $result = $this->createRecord($venue_id,$adv->id);
                if (!$result) {
                    return 'recordError';       //创建统计记录失败
                }
            }
            // 数据回滚提交
            $result = $transaction->commit();
            if(empty($result)) {
                return true;
            }else{
                return false;
            }
        }catch(\Exception $exception){
            //如果抛出错误则进入 catch ,先callback,然后捕捉错误，返回错误
            $transaction->rollBack();
            return  $error = $exception->getMessage();  //获取抛出的错误
        }
    }

    /**
     * @desc: 业务后台 - 创建广告统计数据
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @param $venue_id
     * @param $id
     * @return bool
     */
    public function createRecord($venue_id,$id)
    {
        $data = AdvertisingStatistics::find()->where(['and',['ad_id'=>$id],['venue_id'=>$venue_id]])->asArray()->all();
        if (!empty($data)) {
            return true;
        }
        $model = new AdvertisingStatistics();
        $model->ad_id = $id;
        $model->venue_id = $venue_id;
        $result = $model->save();
        return $result;
    }

    /**
     * @desc: 业务后台 - 广告 - 公司配置
     * @author: 付钟超 <fuzhongchao@itsports.club>
     * @create: 2018/05/06
     * @return mixed
     * @备注1: type 类型 1.启动页广告
     * @备注2: 此配置初期是直接生成,下一阶段可以考虑用户新增
     */
    public function selectSet()
    {
        $data  = AdvertisingSetting::find()->where(['and',['company_id'=>$this->companyId],['type'=>1]])->one();

        return $data;
    }
}