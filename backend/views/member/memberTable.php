<?php if(!empty($data)){ ;?>
    <?php foreach($data as $key=>$value){ ?>
        <tr>
            <td class="memberChooseTransfer" ng-init="id=<?=$value['id']?>" ng-if="distributionCoachBtn && isDistributionCoach == '2'">
                <input type="checkbox" data-choose="<?=$value['id']?>">
            </td>
            <td data-toggle="modal" data-target="#myModals2" class="memberList" data-id="<?=$value['id']?>">
                <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'NAMESHOW')) {  echo $value['name'];?>
                <?php } else {
                    echo $value['name'];
                } ?>
                &nbsp;
                <?php if ($value['count'] == 4) {
                    echo " <button class=\"btn btn-info\" style=\"padding: 4px 10px\">账户已冻结</button>";
                }
                ?>
                <?php if ($value['status'] == 2){
                    echo "<small class=\"label label-warning\">已冻结</small>";
                }
                ?>
<!--                --><?php //if ($value['leaveRecord']['status'] == 1){
//                    echo "<small class=\"label label-danger\">已请假</small>";
//                }
//                ?>
<!--                --><?php //if ($value['leaveRecord']['leave_property'] == 1){
//                    echo "<small class=\"label label-primary\">审核中</small>";
//                }
//                ?>
            </td>
            <td data-toggle="modal" data-target="#myModals2" class="memberList" data-id="<?=$value['id']?>">
                <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'NAMESHOW')) {  echo $value['organization_name'];?>
                <?php } else {
                    echo $value['organization_name'];
                } ?>
            </td>
            <td data-toggle="modal" data-target="#myModals2" class="memberList" data-id="<?=$value['id']?>">
                <?php if ($value['sex'] == 1) { ?>
                    <?php echo '男';?>
                <?php } elseif($value['sex'] == 2) {?>
                    <?php echo '女';?>
                <?php }else{
                    echo '暂无数据';
                }?>
            </td>
            <td data-toggle="modal" data-target="#myModals2" class="memberList" data-id="<?=$value['id']?>">
                <?=isset($value['member_type']) && $value['member_type'] == 1 ? '<small class="label label-success ">正常会员</small>' : '<small class="label label-words ">失效会员</small>';?>
            </td>
            <td data-toggle="modal" data-target="#myModals2" class="memberList" data-id="<?=$value['id']?>">
                <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'MOBILESHOW')) { ?>
                    <?php if($value['mobile'] == ''){
                        echo '暂无数据';
                    }else{?>
                        <?php echo $value['mobile'];?>
                    <?php }?>
                <?php } else {?>
                   <?php echo '暂无数据'?>
                <?php } ?>
            </td>
<!--            有效期注释-->
<!--            <td data-toggle="modal" data-target="#myModals2" style="padding: 0" class="memberList" data-id="--><?//=$value['id']?><!--">-->
<!--<!--                --><?////=isset($value['active_time']) ? date('Y-m-d',$value['active_time']).'-'.date('Y-m-d',$value['invalid_time']) : '未激活'.'-'.'未激活';?>
<!--                --><?php //if (isset($value['active_time'])){
//                    echo date('Y-m-d',$value['active_time']).' - '.date('Y-m-d',$value['invalid_time']);
//                }
//                ?>
<!--                --><?php //if (!isset($value['active_time']) && isset($value['active_limit_time']) && ((time()-$value['create_at'])/24/60/60) <= $value['active_limit_time']){
//                    echo '未激活';
//                }
//                ?>
<!--                --><?php //if (!isset($value['active_time']) && isset($value['active_limit_time']) && ((time()-$value['create_at'])/24/60/60) > $value['active_limit_time']){
//                    echo date('Y-m-d',$value['create_at']+$value['active_limit_time']*24*60*60).' - '.date('Y-m-d',$value['create_at']+$value['active_limit_time']*24*60*60+$value['duration']*24*60*60);
//                }
//                ?>
<!--                --><?php //if (!isset($value['active_time']) && !isset($value['active_limit_time'])){
//                    echo date('Y-m-d',$value['create_at']).' - '.date('Y-m-d',$value['create_at']+$value['duration']*24*60*60);
//                }
//                ?>
<!--            </td>-->
            <td data-toggle="modal" data-target="#myModals2" class="memberList" data-id="<?=$value['id']?>">
                <?=isset($value['employee_name']) ?$value['employee_name'] : '无' ;?>
            </td>
<!--            <td data-toggle="modal" data-target="#myModals2" class="memberList" data-id="--><?//=$value['id']?><!--">-->
<!--                --><?//=isset($value['price']) ? $value['price'] : '无' ;?>
<!--            </td>-->
            <td>
                <div class="btn-group <?= $key < 4 ? 'dropdown' : 'dropup' ?>" role="group">
                    <section type="button "  class="btn btn-default btn-sm mL60 memberList"
                             data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                             data-id="<?=$value['id']?>"
                             data-counselor-id="<?=$value['counselor_id']?>"
                             data-private-id="<?=$value['private_id']?>">
                        更多...
                    </section>
                    <ul class="dropdown-menu selectCards">
                        <li>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'COACH')) { ?>
                                <button style="margin-bottom: 0;"
                                        ng-init="id=<?=$value['id']?>;"
                                        ng-disabled="<?=$value['status'] == 2 ?true:false;?>;"
                                        class="wB100 btn btn-default borderNone btn-sm"
                                        type="submit" data-toggle="modal" data-target="#distribution"
                                        ng-click="distriButionClick(id)">
                                    <span>分配私教</span>
                                </button>
                            <?php }?>
                        </li>
                        <li>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'LESSON')) { ?>
                                <button style="margin-bottom: 0;" class="wB100 btn btn-default borderNone btn-sm privateLessonBuy"
                                        ng-init="
                                        id=<?=$value['id']?>;"
                                        ng-disabled="<?=$value['status'] == 2 ?true:false;?>"
                                        ng-click="privateLessonBuy(id)">
                                    <span class="priceOpcitySpan" style="opacity: 0;position: absolute;"><?=!empty($value['price']) ? $value['price']: '0';?></span>
                                    私教课购买
                                    <span class="voucherOpcitySpan1" style="opacity: 0;position: absolute;"><?=!empty($value['voucher']) ? $value['voucher']: '0';?></span>
                                    <span class="startTimeOpcitySpan1" style="opacity: 0;position: absolute;"><?=!empty($value['start_time']) ? $value['start_time']: '0';?></span>
                                    <span class="endTimeOpcitySpan1" style="opacity: 0;position: absolute;"><?=!empty($value['end_time']) ? $value['end_time']: '0';?></span>
                                </button>
                            <?php }?>
                        </li>
                        <li>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'UPDATE')) { ?>
                                <button style="margin-bottom: 0;"
                                        ng-init="id=<?=$value['id']?>;"
                                        ng-disabled="<?=$value['status'] == 2 ?true:false;?>"
                                        ng-click="getMemberIdUpdate(id)"
                                        class="borderNone kick wB100  btn btn-default btn-sm">
                                    修改基本信息
                                </button>
                            <?php } ?>
                        </li>
                        <li>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'UPDATEVENUE')) { ?>
                                <button style="margin-bottom: 0;"
                                        ng-init="id=<?=$value['id']?>;"
                                        ng-disabled="<?=$value['status'] == 2 ?true:false;?>"
                                        ng-click="updateMemberInVenue(id)"
                                        class="borderNone kick wB100  btn btn-default btn-sm">
                                    修改归属场馆
                                </button>
                            <?php } ?>
                        </li>
                        <li>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DELETE')) { ?>
                                <button style="margin-bottom: 0;"
                                        ng-disabled="<?=$value['status'] == 2 ?true:false;?>"
                                        class="wB100 btn btn-default borderNone btn-sm"
                                        type="submit"
                                        ng-init="id=<?=$value['id'];?>"
                                        ng-click="delMem(id,$event)">
                                        删除
                                </button>
                            <?php } ?>
                        </li>
                        <li>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'OPERATE')) { ?>
                                <button style="margin-bottom: 0;"
                                        ng-init="id=<?=$value['id']?>;status=<?=$value['status']?>"
                                        class="wB100 borderNone btn-default btn btn-sm"
                                        ng-click="updateMember(id,status)"
                                        type="submit"
                                        ng-if="<?=$value['status'] == 2 ?true:false;?>">
                                    <span>取消冻结</span>
                                </button>
                                <button style="margin-bottom: 0;"
                                        ng-init="id=<?=$value['id']?>;status=<?=$value['status']?>"
                                        class="wB100 borderNone  btn-default btn btn-sm"
                                        ng-click="updateMember(id,status)"
                                        type="submit"
                                        ng-if="<?=$value['status'] != 2 ?true:false;?>">
                                    <span>冻结</span>
                                </button>
                            <?php } ?>
                        </li>
                        <li>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DAYOFF')) { ?>
                                <button style="margin-bottom: 0;" class="wB100 borderNone btn btn-default btn-sm"
                                        ng-disabled="<?=$value['status'] == 2 ?true:false;?>"
                                        ng-init="id=<?=$value['id']?>;"
                                        ng-click="leaveBut(id)">
                                    请假
                                </button>
                            <?php } ?>
                        </li>
                        <li>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'DEPOSIT')) { ?>
                                <button style="margin-bottom: 0;"
                                        ng-init="id=<?=$value['id']?>;"
                                        ng-disabled="<?=$value['status'] == 2 ?true:false;?>"
                                        type="button"
                                        class="wB100 borderNone btn btn-default btn-sm"
                                        ng-click="deposit(id)">定金</button>
                            <?php } ?>
                        </li>
                        <li  style="text-align: center;">
                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'GIVE')) { ?>
                                <button style="margin-bottom: 0;"
                                        ng-init="id=<?=$value['id']?>;"
                                        ng-disabled="<?=$value['status'] == 2 ?true:false;?>"
                                        ng-click='presenterClick(id)'
                                        class="wB100 borderNone btn btn-sm btn-default">赠送</button>
                            <?php } ?>
                        </li>
                        <li>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'SELL')) { ?>
                                <button style="margin-bottom: 0;"
                                        ng-init="id=<?=$value['id']?>;"
                                        ng-disabled="<?=$value['status'] == 2 ?true:false;?>"
                                        class="wB100 btn btn-default btn-sm borderNone"
                                        ng-click="userBuyCard(id)">
                                    购卡
                                </button>
                            <?php } ?>
                        </li>
                        <li>
<!--                            --><?php //if (\backend\models\AuthRole::canRoleByAuth('user', 'TOGETHERCARD')) { ?>
                                <button style="margin-bottom: 0;"
                                        ng-init="id=<?=$value['id']?>;"
                                        ng-disabled="<?=$value['status'] == 2 ?true:false;?>"
                                        data-toggle="modal"
                                        data-target="#myModal"
                                        class="wB100 btn btn-default btn-sm borderNone"
                                        ng-click="memberTogherCard(id)">
                                    带人绑定
                                </button>
<!--                            --><?php //} ?>
                        </li>
                        <li>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'ICBINDING')) { ?>
                                <button style="margin-bottom: 0;"
                                        ng-init="id=<?=$value['id']?>;"
                                        ng-disabled="<?=$value['status'] == 2 ?true:false;?>"
                                        class="wB100 btn btn-default btn-sm borderNone"
                                        data-toggle="modal"
                                        ng-click="icCardBinding(id)">
                                    IC卡绑定
                                </button>
                            <?php } ?>
                        </li>
                        <li>

                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'UNFREEZEBTN')) { ?>
                                <button style="margin-bottom: 0;"
                                        ng-init="id=<?=$value['id']?>;"
                                        ng-disabled="<?=$value['count'] != 4 ?true:false;?>"
                                        class="wB100 btn btn-default btn-sm borderNone" ng-click="unfreeze()">
                                    账户解冻
                                </button>
                            <?php } ?>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'CHANGEMEMBERCOACH')) { ?>
                            <button style="margin-bottom: 0;"
                                    class="wB100 btn btn-default btn-sm borderNone"
                                    ng-click="changeMemberCoachBtn()">
                                更换私教
                            </button>
<!--                                ng-disabled="--><?//=$value['private_id'] === null ?true:false;?><!--"-->
                            <?php } ?>
                        </li>
                        <li>
                            <?php if (\backend\models\AuthRole::canRoleByAuth('user', 'CHANGEMEMBERSELLER')) { ?>
                            <button style="margin-bottom: 0;"
                                    class="wB100 borderNone btn-default btn btn-sm"
                                    ng-click="changeMemberSellerBtn()"
                                    type="submit"
                                <span>更换销售</span>
                            </button>
<!--                                ng-disabled="--><?//=$value['counselor_id'] === null ?true:false;?><!--"-->
                            <?php } ?>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
    <?php } ?>
<?php }else{ ?>

<div style="position: absolute;left: 50%;margin-left: -50px; top: 180px;text-align: center">
    <img src="/plugins/noData/img/noDate.png">
    <p style="margin-top:3%;font-size: 18px;font-weight: bold"><?=isset($text) ? $text : '暂无数据'?></p>
</div>
<?php } ?>

