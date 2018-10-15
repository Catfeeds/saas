<?php
namespace backend\models;
use common\models\base\BindPack;
use common\models\base\CardCategory;
use common\models\base\Course;
use common\models\base\Member;
use common\models\base\Order;
use common\models\base\Organization;
use common\models\Func;
use yii\base\Model;
class MemberShipLogic extends Model
{
    public $venueId;   // 场馆id
    public $isEndPage; // 是否是尾页
    public $companyId; // 公司id
    public $isNotPotentialMember;   // 是否是潜在会员
    public $memberMessage;    // 会员信息
    /**
     * 会员入会 - 会员卡 - 菜单栏列表
     * @create 2017/10/24
     * @author houkaixin<houkaixin@itsports.club>
     * @param $cardTypeId  //卡类型id
     * @return array
     */
    public function gainCardCategoryMessage($cardTypeId,$nowPage){
        //获取迈步 天伦锦城店场馆id
        $this->gainMaiBuVenueId();
        // 搜索相关卡类型的信息;
        $query  = \backend\models\CardCategory::find()
                   ->alias("cardCategory")
                   ->joinWith(["cardCategoryType cardCategoryType"],false)
                   ->joinWith(["limitCardNumber limitCardNumber"],false)
                   ->select("
                     cardCategory.id,
                     cardCategory.venue_id,
                     cardCategory.category_type_id,
                     cardCategory.pic,
                     	cardCategory.card_name,
                     	cardCategory.duration,
                     	cardCategory.original_price,
                     	cardCategory.sell_price,    
                     	cardCategory.max_price,
                     cardCategory.min_price,
                     	cardCategory.offer_price,
                     	cardCategoryType.type_name,
                     	cardCategory.card_type,
                     	cardCategory.status,
                     limitCardNumber.sell_start_time,
                     limitCardNumber.sell_end_time,                                                  
                     ")
          //        ->where(["cardCategory.venue_id"=>$this->venueId])                      // 对应的卡类型id
                  ->where(["cardCategory.is_app_show"=>1]);
          if(!empty($cardTypeId)){
                      $query->andWhere(["cardCategory.card_type"=>$cardTypeId]);
          }
          $query = $query->andWhere(["and",["limitCardNumber.venue_id"=>$this->venueId],["limitCardNumber.status"=>[2,3]]]);
          $query = $query->andWhere(["and",["<=","limitCardNumber.sell_start_time",time()],[">=","limitCardNumber.sell_end_time",time()]])    //该卡种处在售卖日期之内
                  ->andWhere(["cardCategory.status"=>1])             // 必须审核中
                  ->asArray()->all();
//        $data      = Func::getDataProvider($query,4);
          $data = $this->dealJsonData($query);
//        // 判断是否是末页
//        $this->isEndPage = $this->judgeIsNotEndPage($data->pagination->pageSize,$data->pagination->totalCount,$nowPage);
         return $data;
    }
    /**
     * 会员入会 - 会员卡 - 菜单栏列表
     * @create 2017/10/24
     * @author houkaixin<houkaixin@itsports.club>
     * @param $data  //需要处理的数据
     * @return array
     */
    public function dealJsonData($data){
     if(empty($data)){
         return [];
     }
     foreach ($data as $keys=>$values){
         $data[$keys]["duration"] = isset(json_decode($data[$keys]["duration"])->day)&&!empty(json_decode($data[$keys]["duration"])->day)?json_decode($data[$keys]["duration"])->day:null;
         $data[$keys]["pic"]       = !empty($data[$keys]["pic"])?$data[$keys]["pic"]:\backend\modules\v1\models\CardCategory::CARD_PIC;
     }
     return $data;
    }
    /**
     * 会员入会 - 会员卡 - 菜单栏列表
     * @create 2017/10/24
     * @author houkaixin<houkaixin@itsports.club>
     * @param $pageSize  //页大小
     * @param $totalCount // 总数据量
     * @param $nowPage    // 当前页
     * @return array
     */
    public function judgeIsNotEndPage($pageSize,$totalCount,$nowPage){
        $pageNum = ceil($totalCount/$pageSize);
        if($nowPage>=$pageNum){
            return true;
        }
        return false;
    }
    /**
     * 会员入会 - 场馆 - 获取场馆id
     * @create 2017/10/24
     * @author houkaixin<houkaixin@itsports.club>
     */
    public function gainMaiBuVenueId(){
       $venue = Organization::find()
            ->where(["and",["like","name","天伦锦城店"],["style"=>2]])
            ->select("name,style,id,pid")
            ->one();
       $this->venueId    = $venue->id;
       $this->companyId  = $venue->pid;
    }
    /**
     * 会员入会 - 卡种信息 - 获取会员卡种信息
     * @create 2017/10/25
     * @author houkaixin<houkaixin@itsports.club>
     * @param $id
     * @return  array
     */
    public function gainTheCardMessage($id){
         $data = \backend\models\CardCategory::find()
                    ->alias("cardCategory")
                    ->joinWith(["cardCategoryType cardCategoryType"],false)
                    ->joinWith(["leagueBindPack leagueBindPack"=>function($query){
                        $query->joinWith(["course groupCourse"],false)
                              ->select("
                                 leagueBindPack.id,
                                 leagueBindPack.card_category_id,
                                 leagueBindPack.polymorphic_id,
                                 leagueBindPack.polymorphic_type,
                                 leagueBindPack.number,
                                 groupCourse.name,
                                 polymorphic_ids"
                              );
                    }])
                    ->joinWith(["privateLessonPack privateLessonPack"=>function($query){
                        $query->joinWith(["chargeClass privateCourse"],false)
                              ->select("
                                 privateLessonPack.id,
                                 privateLessonPack.card_category_id,
                                 privateLessonPack.polymorphic_id,
                                 privateLessonPack.polymorphic_type,
                                 privateLessonPack.number,
                                 privateCourse.name"
                              );
                    }])
                    ->joinWith(["giftPack giftPack"=>function($query){
                        $query->joinWith(["goods goods"],false)
                              ->select("
                                 giftPack.id,
                                 giftPack.card_category_id,
                                 giftPack.polymorphic_id,
                                 giftPack.polymorphic_type,
                                 giftPack.number,
                                 goods.goods_name as name,
                                 goods.unit,
                              ") ;
                    }])
                    ->joinWith(["theLimitCardNumber limitCardNumber"=>function($query){
                        $query->where(["limitCardNumber.status"=>[1,3]])->select("
                            limitCardNumber.venue_ids,    
                            limitCardNumber.card_category_id,
                            limitCardNumber.venue_id,
                            limitCardNumber.level,
                            limitCardNumber.week_times,
                            limitCardNumber.sell_start_time,
                            limitCardNumber.sell_end_time,
                            limitCardNumber.times as month_times,
                            limitCardNumber.apply_start,
                            limitCardNumber.apply_end,                       
                            ");
                    }])
                    ->joinWith(["cardTime cardTime"=>function($query){
                        $query->select("
                               cardTime.card_category_id,
                               cardTime.day,
                               cardTime.week,  
                             ");
                    }])
                    ->joinWith(["deal deal"],false)
                    ->select("
                    cardCategory.id,
                    cardCategoryType.type_name,
                    cardCategory.category_type_id,
                    cardCategory.active_time,
                    cardCategory.bring,
                    cardCategory.pic,
                    cardCategory.attributes,
                    cardCategory.card_name,
                    cardCategory.original_price,
                    cardCategory.sell_price,
                    cardCategory.app_sell_price,
                    cardCategory.max_price,
                    cardCategory.min_price,
                    cardCategory.transfer_price,
                    cardCategory.transfer_number,
                    cardCategory.leave_total_days,
                    cardCategory.leave_total_times,
                    cardCategory.leave_long_limit,
                    cardCategory.leave_least_Days,
                    cardCategory.duration,
                    cardCategory.deal_id,
                    deal.intro as dealIntro,
                    deal.name  as dealName,
                    cardCategory.card_type,
                    ")
                     ->where(["cardCategory.id"=>$id])
                     ->asArray()
                     ->one();
        $data         = $this->dealGoVenueTime($data);
        $data["pic"] = !empty($data["pic"])?$data["pic"]:\backend\modules\v1\models\CardCategory::CARD_PIC;
        $data = $this->dealLeagueCourse($data);
        $data["duration"]=isset($data["duration"])&&!empty($data["duration"])?json_decode($data["duration"])->day:null;
        $data = $this->dealCurrencyVenue($data);
        $data = $this->dealPrice($data);
       // $data = $this->dealBindPackData($data,$id);
        $data = $this->dealPrivateLessonPack($data);
        return $data;
    }

    /**
     * 一体机 - 私教卡 - 垃圾数据处理
     * @create 2017/12/27
     * @author houkaixin<houkaixin@itsports.club>
     * @param $data   //会员卡信息
     * @re
     */
    public function dealPrivateLessonPack($data){
         $arr = [];
         if(!isset($data["privateLessonPack"])||empty($data["privateLessonPack"])){
             return $data;
         }
         foreach($data["privateLessonPack"] as $keys=>$value){
              if(empty($value["name"])){
                   continue;
              }
             $arr[] = $value;
         }
        $data["privateLessonPack"] = $arr;
        return $data;
    }

    /**
     * 会员入会 - 卡种信息 - 处理会员卡的进场时间
     * @create 2017/12/27
     * @author houkaixin<houkaixin@itsports.club>
     * @param $data   //会员卡信息
     * @re
     */
    public function dealGoVenueTime($data){
        $day  = json_decode($data["cardTime"]["day"]);
        // 按月限制(处理 每月的日期)（每月几点到几点）
        if(!empty($day->day)){
            $limitTime = !empty($day->start)&&!empty($day->end)?$day->start."-".$day->end:null;
            $date      = $this->dealMonthDate($day->day,$limitTime);
       //     $data["cardTime"]["limitMonth"]["date"] = $day->day;
       //     $data["cardTime"]["limitMonth"]["time"] = !empty($day->start)&&!empty($day->end)?$day->start."-".$day->end:null;
        }else{
            $date = "";
        }
        $data["cardTime"]["limitMonth"] = $date;
        //按周限制（处理每周的日期）（每周几点到几点）
        $week1 = json_decode($data["cardTime"]["week"]);
        if(!empty($week1->weeks)){
            $week = $this->dealWeek($week1->weeks,$week1->startTime,$week1->endTime);
        }else{
            $week = "";
        }
        $data["cardTime"]["limitWeek"] = $week;
        return $data;
    }

    public function dealMonthDate($day,$limitTime){
        $date   ="";
        $endKey = count($day)-1;
        foreach($day as $keys=>$value){
            if($endKey==$keys){
                $date = $date.$value."号";
                continue;
            }
            $date = $date.$value."号".",";
        }
        $limitTime = !empty($limitTime)?$limitTime:"不限";
        $date = $date." 时间:".$limitTime;
        return $date;
    }

    public function dealWeek($week,$startTime,$endTime){
         // $weekChange = [];
          $weekChange2 = "";
          $endKey      = count($week)-1;
          foreach ($week as $keys=>$value){
               $weekChange1 = $this->weekChange($value);
               $timeSlot1   = empty($startTime[$keys])||empty($endTime[$keys])?"不限":$startTime[$keys]."-".$endTime[$keys];
         //      array_push($weekChange,[$weekChange1,$timeSlot1]);
               if($endKey==$keys){
                   $weekChange2  = $weekChange2.$weekChange1.":".$timeSlot1;
                   continue;
               }
                   $weekChange2  = $weekChange2.$weekChange1.":".$timeSlot1.",";
          }
         // 再次处理数据 处理成字符串
          return $weekChange2;
    }


    public function weekChange($value){
        switch ($value){
            case 1:
                $week = "周一";
            break;
            case 2:
                $week = "周二";
            break;
            case 3:
                $week = "周三";
            break;
            case 4:
                $week = "周四";
            break;
            case 5:
                $week = "周五";
            break;
            case 6:
                $week = "周六";
            break;
            case 7:
                $week = "周日";
            break;
            default:
                $week = "数据异常";
        }
        return $week;
    }



    /**
     * 会员入会 - 卡种信息 - 处理会员卡信息
     * @create 2017/10/25
     * @author houkaixin<houkaixin@itsports.club>
     * @param $data   //绑定的私教课的处理
     * @param $id     // 卡种id
     * @return  array
     */
    public function dealBindPackData($data,$id){
    // 查询是否有组合数据
       $leagueBindPack = BindPack::find()
                           ->where([ "and",
                                     ["polymorphic_type"=>"class"],
                                     ["polymorphic_id"=>[0,null]]
                                   ])
                           ->andWhere(["card_category_id"=>$id])
                           ->select("
                                 id,
                                 card_category_id,
                                 polymorphic_ids,
                                 polymorphic_type,
                                 number,                           
                             ")
                           ->asArray()
                           ->all();
       $data =  $this->gainCourseName($leagueBindPack,$data);
       return $data;
    }
    /**
     * 会员入会 - 卡种信息 - 将数据 塞进 综合数据
     * @create 2017/10/25
     * @author houkaixin<houkaixin@itsports.club>
     * @param $leagueBindPack   //绑定的团课（老卡绑定情况）
     * @param $data   // 卡种详情整体数据
     * @return  array
     */
    public function gainCourseName($leagueBindPack,$data){
        if(!empty($leagueBindPack)){
           foreach ($leagueBindPack as $keys=>$value){
                $course = Course::find()
                             ->where(["id"=>json_decode($value["polymorphic_ids"])])
                             ->select("name")
                             ->asArray()
                             ->column();
                $name = implode(",",$course);
                $leagueBindPack[$keys]["name"] = $name;
           }
        }
        $dataS = array_merge($data["leagueBindPack"],$leagueBindPack);
        if(!empty($data)){
            $data["leagueBindPack"] = $dataS;
        }
        return $data;
    }

    /**
     * 会员入会 - 判断卡种价格的最高价
     * @create 2017/11/10
     * @author houkaixin<houkaixin@itsports.club>
     * @param $data   // 卡详细信息
     * @return  array
     */
    public function dealPrice($data){
        $arr[] = $data["original_price"];
        $arr[] = $data["sell_price"];
        $arr[] = $data["max_price"];
        $arr[] = $data["min_price"];
        $maxPrice = max($arr);
        $data["endMaxPrice"] = $maxPrice;
        $data["bring"] = empty($data["bring"])?0:$data["bring"];
        return $data;
    }
    /**
     * 会员入会 - 卡种信息 - 处理售卖场馆
     * @create 2017/10/31
     * @author houkaixin<houkaixin@itsports.club>
     * @param $data   // 卡详细信息
     * @return  array
     */
    public function dealCurrencyVenue($data){
        if(empty($data["theLimitCardNumber"])){
             return $data;
        }
        // 查询所有的场馆名称
        // 查询所有公司的场馆
        $venues       = Organization::find()
                             ->where(["style"=>2])
                             ->select("name,id")
                             ->asArray()
                             ->all();
        $dealArray    = empty($venues)?[]:array_column($venues,NULL,"id");
        foreach ($data["theLimitCardNumber"] as $keys=>$values){
            // 处理进馆时间
            $data["theLimitCardNumber"][$keys]["goVenueTime"] = !empty($values["apply_start"])&&!empty($values["apply_end"])?date("H:i",$values["apply_start"])."-".date("H:i",$values["apply_end"]):null;
            if(!empty($values["venue_id"])){
                $data["theLimitCardNumber"][$keys]["venueName"]   = isset($dealArray[$values["venue_id"]])?$dealArray[$values["venue_id"]]["name"]:'';
                continue;
            }
          //   在单项关联场馆  没有匹配到的情况下 关联 json场馆
            if(empty($values["venue_id"])||$values["venue_id"]==0){
                $ids       = json_decode($values["venue_ids"]);
                $venueName = $this->gainVenueName($dealArray,$ids);
                $data["theLimitCardNumber"][$keys]["venueName"] = $venueName;
            }
        }
        $data["theLimitCardNumber"]  = array_values($data["theLimitCardNumber"]);
        return $data;
    }
    /**
     * 一体机 - 根据 json 数组返回 场馆名称
     * @create 2017/01/08
     * @author houkaixin<houkaixin@itsports.club>
     * @param $dealArray   // 被处理过的场馆信息数组
     * @param $ids         // 场馆id
     * @return  array
     */
    public function gainVenueName($dealArray,$ids){
         $venueName = "";
         if(!empty($ids)){
             foreach($ids as $keys=>$value){
                 $name = isset($dealArray[$value])?$dealArray[$value]["name"].",":"";
                 $venueName.=$name;
             }
         }
        $venueName = empty($venueName)?"":trim($venueName,",");
        return $venueName;
    }

    /**
     * 会员入会 - 卡种信息 - 团课课程名称信息（多字段处理）
     * @create 2017/10/25
     * @author houkaixin<houkaixin@itsports.club>
     * @param $data   // 卡详细信息
     * @return  array
     */
    public function dealLeagueCourse($data){
          if(empty($data)){
             return [];
          }
          foreach ($data["leagueBindPack"] as $keys=>$value){
              // 获取课程id
//              if(!empty($value["name"])){
//                 continue;
//              }
              // 课程id 的数组处理
              $id = !empty($value["polymorphic_ids"])?json_decode($value["polymorphic_ids"]):[$value["polymorphic_id"]];
              // 查询课程名称
              $course = Course::find()
                          ->where(["in","id",$id])
                          ->select("name")
                          ->asArray()
                          ->column();
              $courseName = empty($course)?"":implode(",",$course);
              $data["leagueBindPack"][$keys]["name"] = $courseName;
          }
        return $data;
    }



    /**
     * 会员入会 -  判断会员身份信息（买卡和未买卡信息）
     * @create 2017/10/25
     * @author houkaixin<houkaixin@itsports.club>
     * @param $mobile
     * @return  array
     */
    public function gainMemberIdentify($mobile){
        // 获取公司id
        $mobile = trim($mobile);
        $this->gainMaiBuVenueId();
        // 获取会员信息
        $data =    \backend\models\Member::find()
                    ->alias("member")
                    ->joinWith(["memberDetails memberDetail"],false)
                    ->select("
                    member.mobile,
                    member.company_id,
                    member.username,
                    member.member_type as memberType,
                    member.company_id,
                    memberDetail.name,
                    memberDetail.sex,
                    ('*******') as password,
                    memberDetail.id_card,                  
                    ")
                    ->where(["member.mobile"=>$mobile])
                    ->andWhere(["company_id"=>$this->companyId])
                    ->asArray()
                    ->one();
          $this->judgeIdentify($data);
    }
    /**
     * 会员入会 -  判断会员身份信息（并返回会员相应信息）
     * @create 2017/10/26
     * @author houkaixin<houkaixin@itsports.club>
     * @param $data   // 会员相应身份信息
     * @return  array
     */
    public function judgeIdentify($data){
        if(!empty($data)&&isset($data["memberType"])){
            if($data["memberType"]==1){
                $this->isNotPotentialMember = 3;    // 老会员 不能注册
                $this->memberMessage = [];          // 返回信息
                return "oldMember";
            }
            if($data["memberType"]==2){
                $this->isNotPotentialMember = 2;    // 潜在会员
                $this->memberMessage = $data;       // 返回信息
                return "potentialMember";
            }
        }
        if(empty($data)){
                $this->isNotPotentialMember = 1;        // 新会员
                $this->memberMessage = [];
                return "notRegister";                  // 该会员在该公司没有注册过
        }
        $this->isNotPotentialMember = "programError";        // 判断有误
        $this->memberMessage = [];
        return true;
    }

    /**
     * 会员入会 -  判断会员身份信息（并返回会员相应信息）
     * @create 2017/10/26
     * @author houkaixin<houkaixin@itsports.club>
     * @param  $orderId    // 订单id
     * @return  array
     */
    public function checkOrderStatus($orderId){
          if(empty($orderId)){
              return "缺少参数";
          }
          $order = Order::findOne($orderId);
          return $order->status;
    }



}