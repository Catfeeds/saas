<?php
use common\models\Func;
Yii::$app->layout = NULL;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
    <title>协议</title>
    <style type="text/css">
        header h2{
            font-size: 18px;
            color: #4389FF;
        }
        header p{
            color: #666666;
            font-size: 14px;
            margin:  0 0 10px 0;
        }
        header span{
            color: #999999;
        }
        .xyName{
            width: 80%;
            height: 50px;
            text-align: center;
            line-height: 50px;
            background: #146CFF;
            color: #FFFFFF;
            font-size: 16px;
            border-radius: 4px;
        }
        .numAndTime p{
            color: #666666;
            font-size: 12px;
            margin: 10px 0 0 0;
        }
        .numAndTime span{
            color: #999999;
        }
        main h3{
            font-size: 14px;
            color: #333333;
            margin-bottom: 0;
        }
        main p{
            color: #666666;
            font-size: 14px;
            margin-top: 0;
        }
        footer div{
            font-size: 14px;
            color: #333333;
            display: inline-block;
        }
        .bottom{
            font-size: 14px;
            color: #333333;
        }
    </style>
</head>
<body>
<header>
    <h2>订单详情</h2>
    <p><span>甲方：</span><?=$model->pay_people_name?></p>
    <p><span>乙方：</span><?=Func::getRelationVal($model, 'company', 'name')?></p>
    <p><span>身份证号：</span><?=Func::getRelationVal($model, 'memberDetails', 'id_card')?></p>
    <p><span>手机号：</span><?=Func::getRelationVal($model, 'member ', 'mobile')?></p>
    <p><span>订单编号：</span><?=$model->order_number?></p>
    <?php if ($model->consumption_type == 'card' || $model->consumption_type == ''){ ?>
    <p><span>会员卡名称：</span><?=$model->product_name?></p>
    <p><span>会员卡类型：</span><?=Func::getRelationVal($model, 'memberCards', 'card_name')?></p>
    <?php } elseif ($model->consumption_type == 'chargeGroup'|| $model->consumption_type == 'charge'){?>
        <p><span>课程名称：</span><?=$model->product_name?></p>
        <p><span>课程节数：</span><?php $data = \backend\models\MemberCourseOrder::find()->alias('mco')->select('mco.product_name,mco.money_amount ,sum(mco.money_amount) as money ,mco.id')
                ->joinWith('memberCourseOrderDetails mcod')
                ->where(['mco.id'=>$model->consumption_type_id,'mco.pay_status'=>1])->groupBy('mco.product_name')->asArray()->all();
               foreach ($data as $a){
                  echo $a['product_name'].'&nbsp&nbsp&nbsp'.$a['money_amount'].'元/节&nbsp共'.$a['money'].'元<br>';
               }
        ?></p>
    <?php }?>

    <p><span>金额：</span><?=$model->total_price?> 元</p>
    <p><span>有效期：</span><?=Func::getRelationVal($model, 'memberCards', 'active_limit_time')?> 天</p>
</header>
<div class="xyName"><?=Func::getRelationVal($model, 'deal', 'name')?></div>
<div class="  ">
    <p><span>合同编号：</span><?=Func::getRelationVal($model, 'deal', 'deal_number')?> </p>
    <p><span>签订时间：</span><?=date('Y-m-d',empty(Func::getRelationVal($model, 'deal', 'create_at'))?1:Func::getRelationVal($model, 'deal', 'create_at'))?></p>
</div>
<main>
    <?=Func::getRelationVal($model, 'deal', 'intro')?>
</main>
<footer>
    <div>甲方：<img src="<?=isset($model->sign) ?$model->sign:''?>" /></div>
    <div>乙方：<img src="" /></div>
</footer>
<div class="bottom">
    <p>本合同生效时间：<?=date('Y-m-d',empty(Func::getRelationVal($model, 'deal', 'create_at'))?1:Func::getRelationVal($model, 'deal', 'create_at'))?></p>
    <p>本合同结束时间：<?=date('Y-m-d',empty(Func::getRelationVal($model, 'memberCard', 'invalid_time'))?1:Func::getRelationVal($model, 'memberCard', 'invalid_time'))?></p>
</div>
</body>
</html>


