<?php
/**
 * Created by PhpStorm.
 * User: lihuien
 * Date: 2017/6/19
 * Time: 15:37
 */

namespace backend\models;


use yii\base\Model;

class AuthMenu extends Model
{
    //顶级菜单
    const MENU = ['systemIndex' => '系统首页', 'reception' => '前台管理', 'core' => '中心管理', 'member' => '会员管理', 'system' => '系统管理'];
    //基本子菜单
    const SUB_MENU = [
        ['administration' => '管理主页', 'sale' => '销售主页'],
        ['checkCard' => '验卡管理', 'potentialMember' => '潜在会员'],
        ['shop' => '商品管理', 'classTimetable' => '团课排课', 'privateCourse' => '私课排课', 'course' => '课种管理', 'card' => '卡种管理', 'cabinet' => '更柜管理', 'service' => '服务管理', 'order' => '订单管理', 'deal' => '合同管理', 'sellCard' => '售卡管理'],
        ['about' => '约课管理', 'user' => '会员管理'],
        ['organization' => '组织管理', 'employee' => '员工管理', 'auth' => '权限管理', 'role' => '角色管理'],
    ];
    //基本功能
    const FUNC = [
        ['添加', 'ADD',    '添加功能'],
        ['修改', 'UPDATE', '修改功能'],
        ['删除', 'DELETE', '删除功能'],
        ['查看', 'VIEW',   '查看列表'],
        ['预约', 'ABOUT',   '预约课程'],
        ['冻结', 'OPERATE', '冻结操作'],
        ['审核', 'AUDIT', '审核操作'],
        ['过期','OVERDUE','过期操作']
    ];
    //菜单详情
    const MENU_DETAIL = [
        ['administration' => '/site/index?&c=24','sale' =>'/sell-index/index?&c=201'],
        ['checkCard' => '/check-card/index?c=33','potentialMember' => '/potential-members/index?c=83'],
        ['shop' => '/shop/index?&c=555','classTimetable' =>'/new-league/index?&c=50','privateCourse' => '/private-lesson/index?&c=200', 'course' => '/class/index?&c=19','card' => '/member-card/index?c=12','cabinet' => '/new-cabinet/index?c=88','service' =>'/serve-plan/serve?c=9','order' => '/order/index?c=21', 'deal' => '/contract/index?&c=6','sellCard' =>'/selling/index?c=38'],
        ['about' => '/member/index?&c=1', 'user' =>'/user/index-upgrade-version2?&c=32'],
        ['organization' => '/main/index?&c=20', 'employee' =>'/personnel/index?&c=16', 'auth' => '/jurisdiction/index?&c=116','role' => '/role/index?&c=126'],
    ];
}