<?php

namespace backend\rbac\cores;

interface ItemInterface
{
    /**
     * @describe 公司
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-02
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function companies();

    /**
     * @describe 场馆
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-02
     * @param $company
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function venues($company);

    /**
     * @describe 获取未分配高级角色的用户
     * @author <yanghuilei@itsport.club>
     * @param $company_id
     * @createAt 2018-07-03
     * @return mixed|\yii\db\ActiveRecord
     */
    public static function allUsers($company_id);

    /**
     * @describe 获取关联关系中 主表的类名
     * @author <yanghuilei@itsport.club>
     * @param $int
     * @desc  1 : organization (组织表)
     * @createAt 2018-07-04
     * @return string
     */
    public static function getRelations($int);

    /**
     * @describe 项目接口 - 获取用户有权访问的场馆
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-27
     * @return mixed
     */
    public static function accessVenues();

    /**
     * @describe 项目接口 - 获取用户有权访问的公司
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-27
     * @return mixed
     */
    public static function accessCompany();
}