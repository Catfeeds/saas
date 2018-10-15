<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/3 0003
 * Time: 上午 9:36
 */

namespace backend\models;

use common\models\ArrayConfig;
use common\models\base\Member;
use common\models\base\Order;
use common\models\relations\EmployeeRelations;
use common\models\Func;
use common\models\base\Admin;
use common\models\base\PersonalityImages;
use Yii;

/**
 * @云运动 - 后台 - 继承模型
 * @author Zhu Mengke <zhumengke@itsports.club>
 * @create 2017/3/29
 * @inheritdoc
 */
class Employee extends \common\models\base\Employee
{
    use EmployeeRelations;
    public $keywords;
    public $name;
    public $position;
    public $salary;
    public $sorts;
    public $venueId;
    public $depId;
    public $department;
    public $searchContent;
    public $companyId;
    public $departmentId; //角色管理 分配员工的部门id
    public $lowest;
    public $highest;
    public $startTime;
    public $endTime;
    public $type;
    public $memberType;
    public $isCourse;
    //新增
    public $coachId;
    public $courseId;
    public $roleVenues;
    public $courseTypeId;
    public $beginClassTime;
    public $nowStartTime;
    public $nowEndTime;
    public $lastStartTime;
    public $lastEndTime;
    public $sort;
    public $searchDateStart;//搜索开始时间
    public $searchDateEnd;//搜索结束时间
    public $key;               //搜索员工名或者电话

    const  KEYS = 'key';  //定义常量
    const COMPANY_ID = 'companyId';
    const SEARCH_CONTENT = 'searchContent';
    const DEPARTMENT = 'departmentId';
    const KEY = 'keywords';
    const BEGIN_TIME = 'startTime';
    const END_TIME = 'endTime';
    const COACH = 'coachId';
    const COURSE = 'courseId';
    const COURSE_TYPE = 'courseTypeId';
    const BEGIN_CLASS_TIME = 'beginClassTime';
    const NOW_TIME = 'nowStartTime';
    const END_1_TIME = 'nowEndTime';
    const L_NOW_TIME = 'lastStartTime';
    const L_END_TIME = 'lastEndTime';
    const VENUE_ID = 'venueId';

    /**
     * 后台 - 团课课程管理 - 获取教室表数据
     * @author Houkaixin <Houkaixin@itsports.club>
     * @create 2017/4/19
     * @update author HuangPengju
     * @update 2017/4/27
     * @update huangpengju
     * @update 2017/06/10
     * @param $coachName //教练名字
     * @param $id //公司或者场馆id
     * @param $type //类型
     * @return \yii\db\ActiveQuery
     */
    public function coachData($coachName)
    {
        $data = Employee::find()
            ->alias('ee')
            ->joinWith(['organization or'], false)
            ->where(['or.style' => '3'])
            ->andWhere(['or.code' => ['tuanjiao', "01"]])
            ->andWhere(['ee.venue_id' => \backend\rbac\Config::accessVenues()])
            ->select("ee.id,ee.company_id,ee.venue_id,ee.name");

        if (isset($coachName) && !empty($coachName)) {
            $data->andFilterWhere(["like", "ee.name", $coachName]);
        }

        $data = $data->asArray()->all();

        return $data;
    }

    /**
     * @云运动 - 后台 - 获取联盟公司下的所团操教练
     * @author houkaixin<houkaixin@itsports.club>
     * @create 2017/9/16
     * @inheritdoc
     */
    public function getAllCompanyCoach($name, $companyId)
    {
        $data = Employee::find()
            ->alias('ee')
            ->joinWith(['organization or'])
            ->where(['or.style' => '3'])
            ->andWhere(['or.code' => 'tuanjiao'])
            ->andWhere(['!=', 'ee.status', 2])
            ->groupBy("ee.id");
        // 查询所对应的公司联盟
        if (!empty($name)) {
            $data = $data->andFilterWhere(["like", "ee.name", $name]);
        }
        // 超级管理员
        if (empty($companyId)) {
            $data = $data->asArray()->all();
            return $data;
        }
        // 非超级管理员（包括公司联盟）
        $allCompanyId = $this->getAllCompany($companyId);
        if (!empty($allCompanyId) && !empty($companyId)) {
            $data = $data->andWhere(["in", "ee.company_id", $allCompanyId])->asArray()->all();
        } else {
            $data = $data->asArray()->all();
        }
        return $data;
    }

    /**
     * @云运动 - 后台 - 获取所有公司联盟id（companyId）
     * @author houkaixin<houkaixin@itsports.club>
     * @create 2017/9/16
     * @inheritdoc
     */
    public function getAllCompany($companyId)
    {
        $allCompany = ApplyRecord::find()->where(["and", ["or", ["apply_id" => $companyId], ["be_apply_id" => $companyId]], [">", "end_apply", time()], ["status" => 1]])
            ->select("apply_id,be_apply_id")
            ->asArray()
            ->all();
        $allCompanyId = $this->dealCompany($allCompany, $companyId);

        return $allCompanyId;
    }

    /**
     * @云运动 - 后台 - 获取所有公司联盟id（companyId）
     * @author houkaixin<houkaixin@itsports.club>
     * @create 2017/9/16
     * @inheritdoc
     */
    public function dealCompany($allCompany, $companyId)
    {
        if (empty($allCompany)) {
            return [$companyId];
        }
        $allCompanyId = [];
        foreach ($allCompany as $keys => $values) {
            $allCompanyId[] = $values["apply_id"];
            $allCompanyId[] = $values["be_apply_id"];
        }
        $allCompanyId = array_unique($allCompanyId);
        return $allCompanyId;
    }

    /**
     * @describe 后台 - 团课课程管理 - 获取教室表数据
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-08-01
     * @param $ids
     * @return array|\yii\db\ActiveQuery|\yii\db\ActiveRecord[]
     */
    public function coachPrivateData($ids)
    {
        $data = Employee::find()
            ->alias('ee')
            ->joinWith(['organization or'])
            ->where(['or.style' => '3'])
            ->andWhere(['or.code' => 'sijiao'])
            ->andWhere(['<>', 'ee.status', 2])
            ->select("ee.*")
            ->asArray();
        $data = $data->andFilterWhere(['ee.venue_id' => $ids]);
        $data = $data->all();

        return $data;
    }

    /**
     * 后台员工管理 - 员工信息查询 - 多表查询
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/24
     * @param $params //搜索参数
     * @return \yii\db\ActiveQuery
     */
    public function search($params)
    {
        $this->customLoad($params);
        $query = Employee::find()
            ->alias('employee')
            ->with([
                'aboutClass' => function ($query) {
                    $query->andWhere('status=1');
                }])
            ->joinWith(['organization organization'])
            ->joinWith(['admin admin' => function ($query) {
                $query->joinWith(['role role'], false);
            }], false)
            ->orderBy($this->sorts)
            ->select(
                "     
                employee.id,
                employee.organization_id,
                employee.name,
                employee.position,
                employee.salary,
                employee.params,
                employee.mobile,
                employee.level,
                employee.sex,
                employee.is_check,
                employee.is_pass,
                employee.alias,
                employee.status,
                employee.admin_user_id,
                employee.pic,
                employee.work_time,
                employee.work_date,
                employee.work_url,
                organization.id as organizations_id,
                organization.name as organization_name,
                organization.style,
                organization.params as organization_params,
                role.name as roleName,
                "
            )
            ->asArray();
        $query = $this->getSearchWhere($query);

        return Func::getDataProvider($query, 8);
    }

    /**
     * 后台 - 员工管理 - 员工基本信息删除
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/4/24
     * @param $id int
     * @return bool
     */
    public function getEmployeeDel($id)
    {
        $employee = Employee::findOne($id);
        $admin = Admin::find()->where(['id' => $employee['admin_user_id']])->one();
        $order = Member::findAll(['counselor_id' => $id]);
        $memOrder = MemberCourseOrder::findAll(['private_id' => $id]);
        if ($order || $memOrder) {
            return false;
        }
        if (!empty($admin)) {
            $employeeDelete = $employee->delete();
            $adminDelete = $admin->delete();
        } else {
            $employeeDelete = $employee->delete();
        }
        if ($employeeDelete) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 员工管理 - 员工列表 - 搜索数据处理数据
     * @create 2017/4/7
     * @author huanghua<huanghua@itsports.club>
     * @param $data
     * @return bool
     */
    public function customLoad($data)
    {
        //获取权限里的场馆
        $cardObj = new \backend\models\CardCategory();
        $venueIds = $cardObj->getVenueIdByRole();
        $this->depId = (isset($data['depId']) && !empty($data['depId'])) ? (int)$data['depId'] : $venueIds;
        $this->keywords = (isset($data[self::KEY]) && !empty($data[self::KEY])) ? $data[self::KEY] : null;
        $this->venueId = (isset($data['venueId']) && !empty($data['venueId'])) ? (int)$data['venueId'] : null;
        $this->department = (isset($data['department']) && !empty($data['department'])) ? (int)$data['department'] : null;
        $this->searchContent = (isset($data[self::SEARCH_CONTENT]) && !empty($data[self::SEARCH_CONTENT])) ? $data[self::SEARCH_CONTENT] : null;
        $this->sorts = self::loadSort($data);

        return true;
    }

    /**
     * 会员卡管理 - 会员卡 - 增加搜索条件
     * @create 2017/4/5
     * @author huanghua<huanghua@itsports.club>
     * @param $query
     * @return mixed
     */
    public function getSearchWhere($query)
    {
        $query->andFilterWhere([
            'or',
            ['like', 'employee.name', $this->keywords],
            ['like', 'employee.alias', $this->keywords],
            ['like', 'employee.mobile', $this->keywords]
        ]);
        if (!$this->department) {
            $query->andFilterWhere(['employee.venue_id' => $this->depId]);
        }
        if ($this->department || $this->depId || $this->venueId) {
            $query->andFilterWhere([
                'and',
                [
                    'employee.organization_id' => $this->department,
                    'employee.venue_id' => $this->depId,
                    'employee.company_id' => $this->venueId,
                ],
            ]);
        }

        return $query;
    }

    /**
     * 员工管理 - 员工信息列表 - 获取搜索规格
     * @create 2017/4/24
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
     * 员工管理 - 员工信息管理 - 获取排序条件
     * @create 2017/4/24
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
        switch ($data['sortType']) {
            case 'employee_name'          :
                $attr = '`employee`.name';
                break;
            case 'employee_position'      :
                $attr = '`employee`.position';
                break;
            case 'employee_salary'        :
                $attr = '`employee`.salary';
                break;
            case 'employee_mobile'        :
                $attr = '`employee`.mobile';
                break;
            case 'employee_params'        :
                $attr = '`employee`.params';
                break;
            case 'employee_status'        :
                $attr = '`employee`.status';
                break;
            default;
                return $sorts;
        }
        return $sorts = [$attr => self::convertSortValue($data['sortName'])];
    }

    /**
     * 后台 - 团课课程管理 - 获取教练单条数据
     * @author lihuien <lihuien@itsports.club>
     * @create 2017/4/19
     * @param $id int //教练id
     * @return \yii\db\ActiveQuery      //教练信息
     */
    public static function getCoachOneById($id)
    {
        return Employee::find()->where(['id' => $id])->asArray()->one();
    }

    /**
     * 后台会员管理 - 员工信息查询
     * @author Huang hua <huangpengju@itsports.club>
     * @create 2017/4/26
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeModel($id)
    {
        $model = Employee::find()
            ->alias('employee')
            ->joinWith(['organization organization'])
            ->select(
                " 
                employee.id,
                employee.age,
                employee.organization_id,
                employee.name,
                employee.position,
                employee.salary,
                employee.mobile,
                employee.params,
                employee.level,
                employee.sex,
                employee.pic,
                employee.work_time,
                employee.work_date,
                employee.class_hour,
                employee.is_check,
                employee.is_pass,
                employee.alias,
                employee.work_url,
                employee.status,
                employee.intro,
                employee.birth_time,
                employee.identityCard,
                organization.id as organizations_id,
                organization.pid as pid,
                organization.name as organization_name,
                organization.style,
                organization.params as organization_params,
                "
            )
            ->where(['employee.id' => $id])
            ->asArray()->one();
        $pid = $model['pid'];
        $data = Organization::find()->where(['id' => $pid])->asArray()->one();
        $model['venue'] = $data['name'];
        $model['venueId'] = $data['id'];
        $model['venuePid'] = $data['pid'];
        $data2 = Organization::find()->where(['id' => $data['pid']])->asArray()->one();
        $model['company'] = $data2['name'];
        $model['companyId'] = $data2['id'];
        $model['companyPid'] = $data2['pid'];
        return $model;
    }

    /**
     * 云运动 - 添加员工 - 获取公司信息
     * @return string
     * @author Huang hua <huangpengju@itsports.club>
     * @update 2017-4-21
     */
    public function getOrganizationOption()
    {
        $venue = Organization::find()
            ->where(['style' => 1])
            ->andWhere(['pid' => 0])
            ->asArray()->all();
        return $venue;
    }

    /**
     * 云运动 - 搜索 - 获取所有场馆信息
     * @return string
     * @author Huang hua <huangpengju@itsports.club>
     * @update 2017-5-8
     */
    public function getVenueOption()
    {
        $venues = Organization::find()
            ->where(['style' => 2])
            ->asArray()->all();
        return $venues;
    }

    /**
     * 云运动 - 添加员工 - 获取场馆信息
     * @return string
     * @author Huang hua <huangpengju@itsports.club>
     * @param @venueID int
     * @update 2017-4-21
     */
    public function getOrganizationData($venueId)
    {
        $data = Organization::find()
            ->where(['pid' => $venueId])
            ->andWhere(['style' => 2])
            ->asArray()->all();
        return $data;
    }

    /**
     * 云运动 - 会员卡管理 - 获取场馆信息
     * @return string
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @param $companyId int
     * @update 2017-9-13
     */
    public function getOrganizationAuthData($companyId)
    {
        //获取权限里的场馆
        $cardObj = new \backend\models\CardCategory();
        $venueIds = $cardObj->getVenueIdByRole();
        $data = Organization::find()->where(['and', ['pid' => $companyId], ['id' => $venueIds], ['is_allowed_join' => 1]])->asArray()->all();
        return $data;
    }

    /**
     * 云运动 - 搜索 - 获取所有部门信息
     * @return string
     * @author Huang hua <huangpengju@itsports.club>
     * @update 2017-5-8
     */
    public function getDepartmentOption()
    {
        $department = Organization::find()
            ->where(['style' => 3])
            ->asArray()->all();
        return $department;
    }

    /**
     * 云运动 - 添加员工 - 获取部门信息
     * @return string
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017-4-26
     */
    public function getDepartmentData($depId)
    {
        $data = Organization::find()
            ->where(['pid' => $depId])
            ->andWhere(['style' => 3])
            ->asArray()->all();
        return $data;
    }

    /**
     * 后台会员管理 - 会员信息查询 - 会员卡状态修改
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/3/31
     * @return bool
     */
    public static function getUpdateEmployee($id)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $employee = \common\models\base\Employee::findOne($id);
            if ($employee->is_check == 1 && $employee->is_pass == 0) {
                $employee->is_pass = 1;
            }
            $employee = $employee->save() ? $employee : $employee->errors;
            if (!$employee) {
                throw new \Exception('操作失败');
            }
            $admin = Admin::find()->where(['id' => $employee->admin_user_id])->one();
            if ($admin) {
                $admin->status = 20;
            } else {
                return false;
            }
            if (!$admin->save()) {
                throw new \Exception('操作失败');
            }
            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }

        } catch (\Exception $e) {
            $transaction->rollBack();
            return $error = $e->getMessage();
        }
    }

    /**
     * 云运动 - 添加教练 - 查询手机号是否存在
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017-5-4
     * @param $mobile //手机号
     * @return array|null|\yii\db\ActiveRecord  //查询结果
     */
    public function getMobileInfo($mobile)
    {
        $data = Employee::find()->where(['mobile' => $mobile])->asArray()->one();
        return $data;
    }

    /**
     * 云运动 - 添加员工 - 员工名是否存在
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017-6-13
     * @param $name
     * @param $id
     * @return array|null|\yii\db\ActiveRecord  //查询结果
     */
    public function getEmployeeName($name, $id)
    {
        $data = Employee::find()->where(['name' => $name])->asArray();
        $data = $data->andFilterWhere(['cloud_employee.company_id' => $id]);
        $data = $data->one();

        return $data;
    }

    /**
     * @describe 私教管理 - 私教信息查询 - 获取所有的私教信息
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @param null $pid
     * @param $id
     * @param $type
     * @return array|\yii\db\ActiveQuery|\yii\db\ActiveRecord[]
     */
    public function getAdviser($pid = null)
    {
        $employee = Employee::find()
            ->alias('employee')
            ->joinWith(['organization or'])
            ->where(['or.style' => '3'])
            ->andWhere(['or.code' => 'sijiao'])
            ->select(
                " 
                employee.id,
                employee.organization_id,
                employee.name,
                employee.age,
                employee.pic,
                employee.work_time,
                employee.work_date,
                or.id as organizations_id,
                or.code,
                "
            )
            ->andFilterWhere(['or.pid' => $pid])
            ->andFilterWhere(['<>', 'employee.status', 2])
            ->asArray();

        $venueId = (isset($params['venueId']) && !empty($params['venueId'])) ? $params['venueId'] : \backend\rbac\Config::accessVenues();
        $employee = $employee->andFilterWhere(['employee.venue_id' => $venueId]);
        $employee = $employee->all();

        return $employee;
    }

    /**
     * 员工管理 - 员工详情 - 获取所有员工数据
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/6
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeData()
    {
        $employee = Employee::find()
            ->alias('employee')
            ->select(
                "
                employee.id,
                employee.name,
                employee.age,
                employee.pic,
                employee.work_time,
                "
            )
            ->asArray()
            ->all();
        return $employee;
    }

    /**
     * 员工管理 - 员工详情 - 替换员工
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/6
     * @param $id
     * @return \yii\db\ActiveQuery
     */
    public function getChooseEmployee($id)
    {
        $employee = Employee::find()
            ->alias('employee')
            ->joinWith(['member member'])
            ->where(['employee.id' => $id])
            ->asArray()
            ->one();
        return $employee;
    }

    /**
     * 员工管理 - 员工详情 - 销售下的所有会员
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/6
     * @param $params
     * @return \yii\db\ActiveQuery
     */
    public function employeeMember($params)
    {
        $this->memberLoad($params);
        $query = \backend\models\Member::find()
            ->alias('member')
            ->joinWith(['employee employee'])
            ->joinWith(['memberDetails memberDetails'])
            ->joinWith(['memberCard memberCard'])
            ->joinWith(['memberCourseOrder mco'])
            ->where(['member.counselor_id' => $params['employeeId']])
            ->orderBy('member.register_time DESC')
            ->asArray();
        $query = $this->setMemberWhereSearch($query, $params['employeeId']);
        $dataProvider = Func::getDataProvider($query, 10000);
        return $dataProvider;
    }

    /**
     * 员工管理 - 员工详情 - 销售会员搜索处理
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/10/10
     * @param $params
     * @return bool
     */
    public function memberLoad($params)
    {
        $this->memberType = isset($params['memberType']) ? $params['memberType'] : null;
        $this->keywords = isset($params['keywords']) ? $params['keywords'] : null;
        $this->isCourse = isset($params['isCourse']) ? $params['isCourse'] : null;
        return true;
    }

    /**
     * 员工管理 - 员工详情 - 销售会员列表
     * @author 焦冰洋 <jiaopbingyang@itsports.club>
     * @create 2017/10/10
     * @param $query
     * @return bool
     */
    public function setMemberWhereSearch($query, $id)
    {
        $query->andFilterWhere(['member.member_type' => $this->memberType]);
        $query->andFilterWhere([
            'or',
            ['like', 'memberDetails.name', $this->keywords],
            ['=', 'member.mobile', $this->keywords],
            ['=', 'memberCard.card_number', $this->keywords],
        ]);
        if ($this->isCourse != null) {
            //获取此会籍顾问下购买私教课的会员id数组
            $memberIds = \backend\models\Member::find()
                ->alias('mm')
                ->joinWith(['memberCourseOrder mco'], false)
                ->where(['or',
                    ['and', ['mco.course_type' => 1], ['>=', 'mco.money_amount', 0]],
                    ['and', ['mco.course_type' => null], ['>', 'mco.money_amount', 0]]
                ])
                ->andWhere(['mm.counselor_id' => $id])
                ->select('mm.id')
                ->groupBy('mm.id')
                ->asArray()->column();
            if ($this->isCourse == 0) {
                //获取未购课会员
                $query->andWhere([
                    'or',
                    ['is', 'mco.id', NULL],
                    ['and', ['mco.money_amount' => 0], ['<>', 'mco.course_type', 1], ['not in', 'mco.member_id', $memberIds]]
                ]);
            } else {
                //获取已购课会员
                $query->andWhere(['mco.member_id' => $memberIds]);
            }
        }
        return $query;
    }

    /**
     * @describe 云运动 - 角色管理 - 点击查看详情
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-08-01
     * @param $id
     * @param $keywords
     * @return \yii\data\ActiveDataProvider
     */
    public function getRoleModel($id, $keywords)
    {
        $query = Employee::find()
            ->alias('employee')
            ->joinWith(['admin admin' => function ($query) {
                $query->joinWith(['roleChild roleChild']);
            }], false)
            ->where(['roleChild.role_id' => $id])
            ->andWhere(['<>', 'employee.status', 2])
            ->select(['employee.name', 'employee.id'])
            ->asArray();
        if (!empty($keywords)) {
            $query->andFilterWhere(['or',
                ['like', 'employee.name', $keywords],
                ['like', 'employee.mobile', $keywords],
            ]);
        }
        $dataProvider = Func::getDataProvider($query, 8000);

        return $dataProvider;
    }

    /**
     * 后台角色管理 - 分配员工信息查询 - 多表查询
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/6/17
     * @param $params //搜索参数
     * @return \yii\db\ActiveQuery
     */
    public function roleSearch($params)
    {
        $this->custom($params);
        $query = Employee::find()
            ->alias('employee')
            ->joinWith(['organization organization'])
            ->innerJoinWith(['admin admin'])
            ->select(
                "
                employee.id,
                employee.organization_id,
                employee.admin_user_id,
                employee.name,
                employee.mobile,
                employee.pic,
                organization.id as organizationsId,
                organization.name as organizationName,
                "
            )
            ->where(['employee.status' => 1])
            ->andWhere(['admin.level' => null])
            ->asArray();
        $query = $this->getSearch($query);
        return Func::getDataProvider($query, 10000);
    }

    /**
     * 角色管理 - 分配员工 - 搜索数据处理数据
     * @create 2017/6/17
     * @author huanghua<huanghua@itsports.club>
     * @param $data
     * @return bool
     */
    public function custom($data)
    {
        $this->key = (isset($data[self::KEYS]) && !empty($data[self::KEYS])) ? $data[self::KEYS] : null;
        $this->departmentId = (isset($data[self::DEPARTMENT]) && !empty($data[self::DEPARTMENT])) ? $data[self::DEPARTMENT] : null;
        $this->companyId = (isset($data[self::COMPANY_ID]) && !empty($data[self::COMPANY_ID])) ? $data[self::COMPANY_ID] : NULL;

        return true;
    }

    /**
     * 角色管理 - 分配员工 - 增加搜索条件
     * @create 2017/6/17
     * @author huanghua<huanghua@itsports.club>
     * @param $query
     * @return mixed
     */
    public function getSearch($query)
    {
        $query->andFilterWhere([
            'or',
            ['like', 'employee.name', $this->key],
            ['like', 'employee.mobile', $this->key]
        ]);
        $query->andFilterWhere([
            'and',
            ['employee.organization_id' => $this->departmentId]
        ]);
        $query->andFilterWhere(['employee.company_id' => $this->companyId]);

        return $query;
    }

    /**
     * @describe 员工信息查询
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function getEmployeeCenter($id)
    {
        $model = Employee::find()
            ->alias('employee')
            ->joinWith(['admin admin'], false)
            ->select(
                " 
                employee.id,
                employee.admin_user_id,
                employee.name,
                employee.sex,
                employee.position,
                employee.mobile,
                employee.pic,
                employee.venue_id,
                employee.company_id,
                admin.id as adminId,
                admin.username,
                admin.level,
                "
            )
            ->where(['employee.admin_user_id' => $id])
            ->asArray()->one();

        return $model;
    }

    /**
     * @销售统计 - 销售排行榜 - 查看详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/09
     * @return array
     */
    public function salesStaffDetails($params)
    {
        $this->loadData($params);
        $query = Employee::find()
            ->alias('em')
            ->where(['or.style' => 3])
            ->andWhere(['<>', 'em.status', 2])
            ->andWhere(['order.status' => 2])
            ->andFilterWhere(['order.venue_id' => $this->venueId])
            ->andFilterWhere(['em.name' => $this->keywords])
            ->andFilterWhere(['between', 'order.pay_money_time', $this->searchDateStart, $this->searchDateEnd])
            ->joinWith(['organization or'], false)
            ->joinWith(['order order' => function ($query) {
                $query->joinWith(['member me' => function ($query) {
                    $query->joinWith(['memberDetails md'], false);
                }], false);
            }], false)
            ->select('em.id,em.name as eName,em.position,order.member_id,order.note,order.card_name,order.pay_money_time,order.total_price,me.mobile,md.name as memberName')
            ->groupBy('em.id')
            ->orderBy($this->sorts)
            ->asArray();
        $data = Func::getDataProvider($query, 8);

        return $data;
    }

    /**
     * 销售主页 - 销售额
     * @author 黄华 <huanghua@itsports.club>
     * @create 2017/7/21
     * @param $params
     * @param $type
     * @return array
     */
    public function actionSalesMember($type, $params)
    {
        $this->customs($type, $params);
        return $this->getSalesMember($this->searchDateStart, $this->searchDateEnd);
    }

    /**
     * 销售主页 - 销售额 - 搜索数据处理数据
     * @create 2017/7/21
     * @author 黄华 <huanghua@itsports.club>
     * @param $data
     * @return bool
     */
    public function customs($attr, $data)
    {
        if ($attr == 'w') {
            $this->searchDateStart = Func::getTokenClassDate($attr, true);
            $this->searchDateEnd = Func::getTokenClassDate($attr, false);
        } elseif ($attr == 'd') {
            $this->searchDateStart = Func::getGroupClassDate($attr, true);
            $this->searchDateEnd = Func::getGroupClassDate($attr, false);
        } else {
            $this->searchDateStart = Func::getGroupClassDate($attr, true);
            $this->searchDateEnd = Func::getGroupClassDate($attr, false);
        }
        $card = new CardCategory();
        $this->venueId = (isset($data['venueId']) && !empty($data['venueId'])) ? $data['venueId'] : $card->getVenueIdByRole();

        return true;
    }

    /**
     * 销售主页 - 销售额
     * @author 黄华 <huanghua@itsports.club>
     * @create 2017/7/21
     * @param $beginDate
     * @param $endDate
     * @return array
     */
    public function getSalesMember($beginDate, $endDate)
    {
        $sales = Employee::find()
            ->alias('employee')
            ->joinWith(['organization or'], false)
            ->where(['or.style' => 3])
//            ->andWhere(['or.code' => 'xiaoshou'])
            ->andWhere(['<>', 'employee.status', 2])
            ->select('employee.id,employee.name,employee.venue_id')
            ->asArray()->all();
//        $sales   = $this->setWhere($sales);         //场馆和公司判断
        $salesId = array_column($sales, 'id');
        $count = [];
        foreach ($salesId as $value) {
            $order = Order::find()
                ->where(['sell_people_id' => $value])
                ->andWhere(['status' => 2])
                ->andWhere(['between', 'pay_money_time', strtotime($beginDate), strtotime($endDate)])
                ->andFilterWhere(['venue_id' => $this->venueId])
                ->select('total_price,sell_people_name')
                ->asArray()
                ->all();
            if (!empty($order)) {
                $price = array_column($order, 'total_price');
                $sum = array_sum($price);
                $count[] = ['totalPrice' => $sum, 'name' => $order[0]['sell_people_name']];
            }
        }
        return $count;
    }

    /**
     * 后台 - 约课管理 - 处理搜索条件
     * @author Huang Pengju <huangpengju@itsports.club>
     * @create 2017/5/2
     * @param $query
     * @return string
     */
    public function setWhere($query)
    {
        $query->andFilterWhere(['employee.venue_id' => $this->venueId]);
        return $query->all();
    }

    /**
     * @销售统计 - 员工业绩 - 查看详情
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/08
     * @return array
     */
    public function performanceDetails($params)
    {
        $this->loadData($params);
        $array = new ArrayConfig();
        $arr = array_column($array->setEmployeePosition(), 'val');
        $query = \backend\models\Order::find()
            ->alias('order')
            ->joinWith(['employeeS em' => function ($query) {
                $query->joinWith(['organization or'], false);
            }], false)
            ->joinWith(['member me' => function ($query) {
                $query->joinWith(['memberDetails md'], false);
            }], false)
            ->where(['or.style' => 3])
            ->andWhere(['<>', 'em.status', 2])
            ->andWhere(['in', 'em.position', $arr])
            ->andWhere(['order.status' => 2])
            ->andFilterWhere(['order.venue_id' => $this->venueId])
            ->andFilterWhere(['em.name' => $this->keywords])
            ->andFilterWhere(['and', ['>=', 'order.pay_money_time', $this->searchDateStart], ['<=', 'order.pay_money_time', $this->searchDateEnd]])
            ->select('em.name as eName,em.position,order.id,order.member_id,order.note,order.card_name,order.pay_money_time,order.total_price,me.mobile,md.name as memberName')
            ->groupBy('order.id')
            ->orderBy($this->sorts)
            ->asArray();
//        $query = Employee::find()
//            ->alias('em')
//            ->joinWith(['organization or'],false)
//            ->joinWith(['order order' => function($query){
//                $query->joinWith(['member me' => function($query){
//                    $query->joinWith(['memberDetails md'],false);
//                }],false);
//            }],false)
//            ->where(['or.style' => 3])
//            ->andWhere(['<>','em.status',2])
//            ->andWhere(['in','em.position',$arr])
//            ->andWhere(['order.status' => 2])
//            ->andFilterWhere(['order.venue_id' => $this->venueId])
//            ->andFilterWhere(['em.name' => $this->keywords])
//            ->andFilterWhere(['and',['>=','order.pay_money_time',$this->searchDateStart],['<=','order.pay_money_time',$this->searchDateEnd]])
//            ->select('em.id,em.name as eName,em.position,order.member_id,order.note,order.card_name,order.pay_money_time,order.total_price,me.mobile,md.name as memberName')
//            ->groupBy('em.id')
//            ->orderBy($this->sorts)
//            ->asArray();
        $data = Func::getDataProvider($query, 8);
        return $data;
    }

    /**
     * @销售统计 - 员工业绩 - 查看详情 - 执行搜索数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/08
     * @return bool|string
     */
    public function loadData($data)
    {
        if (isset($data["startTime"]) && isset($data["endTime"])) {
            $this->searchDateStart = strtotime($data["startTime"]);
            $this->searchDateEnd = strtotime($data["endTime"]);
        } else {
            $this->searchDateStart = strtotime(Func::getTokenClassDate($data['date'], true));
            $this->searchDateEnd = strtotime(Func::getTokenClassDate($data['date'], false));
        }
        //获取权限里的场馆
        $cardObj = new \backend\models\CardCategory();
        $venueIds = $cardObj->getVenueIdByRole();
        $this->venueId = (isset($data[self::VENUE_ID]) && !empty($data[self::VENUE_ID])) ? $data[self::VENUE_ID] : $venueIds;
        $this->keywords = (isset($data[self::KEY]) && !empty($data[self::KEY])) ? $data[self::KEY] : null;
        $this->sorts = self::sortData($data);
    }

    /**
     * @销售统计 - 员工业绩 - 查看详情 - 执行搜索数据
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/05/08
     * @return bool|string
     */
    public static function sortData($data)
    {
        $sorts = ['id' => SORT_DESC];
        if (isset($data['sortType']) && $data['sortType'] == 'sell_money') {
            $sorts = ['`order`.total_price' => self::convertSortValue($data['sortName'])];
        }
        if (isset($data['sortType']) && $data['sortType'] == 'create_at') {
            $sorts = ['`order`.pay_money_time' => self::convertSortValue($data['sortName'])];
        }
        return $sorts;
    }

    /**
     * 后台 - 销售主页 - 员工业绩统计
     * @author 黄华 <huanghua@itsports.club>
     * @create 2017/8/15
     * @param $type
     * @param $params
     * @return array
     */
    public function employeePerformance($type, $params)
    {
        $this->customs($type, $params);
        return $this->getEmployeePerformance($this->searchDateStart, $this->searchDateEnd);
    }

    /**
     * 业务后台 - 销售主页 - 员工业绩
     * @author 黄华 <huanghua@itsports.club>
     * @create 2017/8/15
     * @param $beginDate
     * @param $endDate
     * @return array
     */
    public function getEmployeePerformance($beginDate, $endDate)
    {
        $array = new ArrayConfig();
        $arr = array_column($array->setEmployeePosition(), 'val');
        $sales = Employee::find()
            ->alias('employee')
            ->joinWith(['organization or'], false)
            ->joinWith(['order order'], false)
            ->where(['or.style' => 3])
            ->andWhere(['<>', 'employee.status', 2])
            ->andWhere(['in', 'employee.position', $arr])
            ->andWhere(['order.status' => 2])
            ->andFilterWhere(['order.venue_id' => $this->venueId])
            ->andWhere(['between', 'order.pay_money_time', strtotime($beginDate), strtotime($endDate)])
            ->select('employee.position,sum(order.total_price) as money')
            ->groupBy("employee.position")
            ->asArray()->all();
//        $sales   = $this->setWhereTime($sales);         //场馆和公司判断
        return $sales;
    }

    /**
     * 后台 - 员工业绩 - 处理搜索条件
     * @author Huang hua <huanghua@itsports.club>
     * @create 2017/8/15
     * @param $query
     * @return string
     */
    public function setWhereTime($query)
    {
//        if($this->nowBelongType && $this->nowBelongType == 'company'){
//            $query->andFilterWhere(['employee.company_id'=>$this->nowBelongId]);
//        }
//        if($this->nowBelongType && ($this->nowBelongType == 'venue' || $this->nowBelongType == 'department')){
//            $query->andFilterWhere(['employee.venue_id'=>$this->nowBelongId]);
//        }
        $query->andFilterWhere(['employee.venue_id' => $this->venueId]);
        return $query->all();
    }

    /**
     * 后台 - 财务管理 - 上课收入 - 私教列表
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/8/28
     * @param $params
     * @return string
     */
    public function getPrivates($params)
    {
        $this->Privates($params);
        $query = Employee::find()
            ->alias("ee")
            ->joinWith(["organization org"], false)
            ->joinWith(["organizations ors"], false)
            ->joinWith(["aboutClasses ac" => function ($query) {
                $query->joinWith(["memberCourseOrderDetails mod" => function ($query) {
                    $query->joinWith(["memberCourseOrder mco"], false);
                }], false);
                $query->joinWith(["memberDetails mmd"], false);
            }])
            ->where(['org.code' => 'sijiao'])
            ->andWhere(['ac.status' => 4])
            ->select("
            ee.*,
            ac.coach_id,
            ac.start,
            ac.type as ac_type,
            sum((mco.money_amount/mco.course_amount)*mco.overage_section) as left_money,
            mco.type as class_type,
            sum(mco.money_amount/mco.course_amount) as token_money,
            count(ac.coach_id) as token_num,
            org.id as org_id,
            ors.name as venue_name,
            org.name as org_name,
            org.code as org_code
            ")
            ->orderBy($this->sorts)
            ->groupBy('ac.coach_id')
            ->asArray();
        $query = $this->setPrivatesWhereSearch($query);
        return $query;
    }

    /**
     * @云运动 - 财务管理 - 上课收入 - 搜索处理
     * @author 焦冰洋 <jiaopbingyang@itsports.club>
     * @create 2017/8/28
     * @param $data
     * @return bool
     */
    public function Privates($data)
    {
        //获取权限里的场馆
        $cardObj = new \backend\models\CardCategory();
        $venueIds = $cardObj->getVenueIdByRole();
        $this->venueId = (isset($data['venueId']) && !empty($data['venueId'])) ? $data['venueId'] : $venueIds;
        $this->keywords = (isset($data['keywords']) && !empty($data['keywords'])) ? $data['keywords'] : null;
        $this->startTime = (isset($data['startTime']) && !empty($data['startTime'])) ? (int)strtotime($data['startTime']) : null;
        $this->endTime = (isset($data['endTime']) && !empty($data['endTime'])) ? (int)strtotime($data['endTime']) : null;
        $this->highest = (isset($data['highest']) && !empty($data['highest'])) ? (int)($data['highest']) : null;
        $this->lowest = (isset($data['lowest']) && !empty($data['lowest'])) ? (int)($data['lowest']) : null;
        $this->type = (isset($data['type']) && !empty($data['type'])) ? (int)($data['type']) : null;
        $this->sorts = self::loadTokenSort($data);        //排序
        return true;
    }

    /**
     * 财务管理 - 上课收入 - 获取排序条件
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/9/2
     * @param $data
     * @return mixed
     */
    public static function loadTokenSort($data)
    {
        $sorts = ['id' => SORT_DESC];
        if (!isset($data['sortType'])) {
            return $sorts;
        }
        switch ($data['sortType']) {
            case 'token_num'  :
                $attr = 'count(coach_id)';
                break;
            case 'token_money' :
                $attr = 'sum(mco.money_amount/mco.course_amount)';
                break;
            default:
                $attr = NULL;
        };
        if ($attr) {
            $sorts = [$attr => self::convertSortValue($data['sortName'])];
        }
        return $sorts;
    }

    /**
     * 后台 - 财务管理 - 上课收入 - 私教列表
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/8/31
     * @param $query
     * @return string
     */
    public function getPrivatesList($query)
    {
        $dataProvider = Func::getDataProvider($query, 8);
        return $dataProvider;
    }

    /**
     * 后台 - 财务管理 - 上课收入 - 用于统计
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/8/31
     * @param $query
     * @return string
     */
    public function getPrivatesTotal($query)
    {
        return $query->all();
    }

    /**
     * @上课量统计 - 课程类型（PT、HS、生日课）
     * @create 2017/11/13
     * @author zhumengke <zhumengke@itsports.club>
     * @return array
     */
    public function getCourseTypeTwo()
    {
        $data = MemberCourseOrder::find()
            ->where(['course_type' => 2])
            ->orWhere(['course_type' => null, 'type' => 2])
            ->asArray()->all();
        return array_column($data, 'id');
    }

    public function getCourseTypeThree()
    {
        $data = MemberCourseOrder::find()
            ->where(['course_type' => 3])
            ->orWhere(['course_type' => null, 'type' => 3])
            ->asArray()->all();
        return array_column($data, 'id');
    }

    /**
     * @云运动 - 财务管理 - 上课收入 - 搜索处理
     * @author 焦冰洋 <jiaobingyang@itsports.club>
     * @create 2017/8/21
     * @param $query
     * @return string
     */
    public function setPrivatesWhereSearch($query)
    {
        $query->andFilterWhere(['ee.venue_id' => $this->venueId]);
        if (!empty($this->type)) {
            $two = $this->getCourseTypeTwo();
            $three = $this->getCourseTypeThree();
            if ($this->type == 2) {
                $query->andWhere(['mco.id' => $two]);      //HS
            } elseif ($this->type == 3) {
                $query->andWhere(['mco.id' => $three]);    //生日课
            } else {
                $query->andWhere(['and', ['NOT IN', 'mco.id', $two], ['NOT IN', 'mco.id', $three]]);    //PT
            }
        }
        $query->andFilterWhere(['like', 'ee.name', $this->keywords]);
        if ($this->lowest != null && $this->highest != null) {
            $query->Having([
                'and',
                ['>=', 'token_num', $this->lowest],
                ['<=', 'token_num', $this->highest]
            ]);
        }
        $query->andFilterWhere([
            'and',
            ['>=', 'ac.start', $this->startTime],
            ['<=', 'ac.start', $this->endTime]
        ]);
        return $query;
    }

    /**
     * @后台 - 卡种审核 - 获取部门下的员工
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/9/28
     * @param  $id //部门id
     * @return array
     */
    public function getEmployeeByDepartment($id)
    {
        return Employee::find()->where(['organization_id' => $id])->select('id,name')->asArray()->all();
    }

    /**
     * @后台 -  获取指定场馆下所有销售部的员工
     * @author houkaixn <houkaixin@itsports.club>
     * @create 2017/11/28
     * @param  $companyId //公司id
     * @return array
     */
    public function gainDepEmployee($companyId)
    {
        // 搜索指定部门下的所有员工
        $employee = Employee::find()
            // ->where(["status"=>1])   // 在职
            ->alias("employee")
            ->joinWith(["organization depart" => function ($query) use ($companyId) {
                $query->joinWith(["company venue"])
                    ->andWhere(["venue.pid" => $companyId]);
            }], false)
            ->select("employee.id,employee.name,depart.code")
            ->where(["depart.code" => ["xiaoshou", "yingyun"]])
            ->asArray()
            ->all();
        return $employee;
    }

    /**
     * 员工管理 - 批量修改员工年限
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2018/03/15
     * @return bool|string
     */
    public function updateWorkTime()
    {
        $data = \common\models\base\Employee::find()
            ->where(['is', 'work_date', null])
            ->andWhere(['>=', 'work_time', 48])
            ->select('id,work_date,work_time')
            ->asArray()->all();
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $employee = \common\models\base\Employee::findOne(['id' => $value['id']]);
                $employee->work_time = NULL;
                $employee->save();
            }
            return true;
        }
    }

    /**
     * 运运动-团课统计-参数
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @param $master
     * @return array
     */
    private function concatParams($master)
    {
        if ($master === true) {
            return [
                'CEIL(COUNT(ac.id)/COUNT(distinct gc.id)) averageCount',
                'COUNT(distinct gc.id) classCount',
                'COUNT(ac.id) memberCount',
                'FROM_UNIXTIME(gc.`start`,\'%H:%i\') timeColumn',
                'ccc.name courseType',
                'ccc.id courseTypeId',
                'or2.name venueName',
                'ee.id coachId',
                'ee.name coachName',
                'ee.position coachPos',
                'ee.mobile coachMobile',
                'gc.venue_id venueId',
                'cc.name courseName',
                'cc.id courseId',
                'ac.id aboutClassId',
            ];
        } else {
            return [
                'CEIL(COUNT(ac.id)/COUNT(distinct gc.id)) lastAverageCount',
                'COUNT(distinct gc.id) lastClassCount',
                'COUNT(ac.id) lastMemberCount',
                'FROM_UNIXTIME(gc.`start`,\'%H:%i\') lastTimeColumn',
                'ccc.name lastCourseType',
                'ccc.id lastCourseTypeId',
                'or2.name lastVenueName',
                'ee.id lastCoachId',
                'ee.name lastCoachName',
                'ee.position lastCoachPos',
                'ee.mobile lastCoachMobile',
                'gc.venue_id lastVenueId',
                'cc.name lastCourseName',
                'cc.id lastCourseId',
                'ac.id lastAboutClassId',
            ];
        }
    }

    /**
     * 运运动-团课统计-分组
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @param $vid
     * @param $object
     * @return mixed
     */
    private function partGroup($vid, $object)
    {
        switch ($vid) {
            case 1:
                $object->groupBy(['gc.coach_id', 'ccc.id']);
                break;
            case 2:
                $object->groupBy('gc.course_id');
                break;
            default:
                $object->groupBy(['gc.venue_id', 'gc.course_id', 'FROM_UNIXTIME(gc.`start`,\'%H:%i\')']);
        }
        return $object;
    }

    /**
     * 运运动-课程环比-子查询关联
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @param $vid
     * @return array
     */
    private function gainRelation($vid)
    {
        switch ($vid) {
            case 1:
                return "(`t1`.`coachId`=`t2`.`lastCoachId`) AND (`t1`.`courseTypeId`=`t2`.`lastCourseTypeId`)";
                break;
            case 2:
                return "(`t1`.`courseId`=`t2`.`lastCourseId`)";
                break;
            case 3:
                return "(`t1`.`venueId`=`t2`.`lastVenueId`) AND (`t1`.`courseId`=`t2`.`lastCourseId`) AND (`t1`.`timeColumn`=`t2`.`lastTimeColumn`)";
                break;
            default:
                return null;
        }
    }

    /**
     * 运运动-团课统计&&课程环比
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @param $companyId
     * @param $param
     * @param $vid
     * @param bool $option
     * @param bool $son
     * @return $this|\yii\data\ActiveDataProvider
     */
    public function gainAllCoachRecord($companyId, $param, $vid, $option = false, $son = false)
    {
        $this->filter($param) and ($allCompanyId = $this->getAllCompany($companyId));
        $model = Employee::find()->alias('ee')
            ->joinWith(['organization or1' => function ($q) {
                $q->onCondition(['<>', 'ee.status', 2]);
                $q->where(['or1.style' => 3, 'or1.code' => 'tuanjiao']);
            }], false)
            ->joinWith(['groupClass gc' => function ($q) {
                $q->joinWith('allOrganization or2', false)
                    ->joinWith(['allCourse cc' => function ($q) {
                        $q->leftJoin('cloud_course ccc', 'ccc.id=TRIM(\'"\' FROM SUBSTRING_INDEX(SUBSTRING_INDEX(cc.`path`,",",2),",",-1))');
                    }], false)
                    ->joinWith(['aboutClasses ac' => function ($q) {
                        $q->andWhere(['type' => 2])->onCondition(['in', 'ac.status', [1, 3, 4]]);
                    }])
                    ->where(['gc.status' => 1]);
            }], false)
            ->asArray();
        if (!empty($allCompanyId) && !empty($companyId)) $model->andWhere(["in", "ee.company_id", $allCompanyId]);
        ($option === true && $son === true) ? $this->searchFilter($model, false) and $this->partGroup($vid, $model) : $this->searchFilter($model, true) and $this->partGroup($vid, $model);
        if ($option === true) {
            if ($son === true) {
                $model->select($this->concatParams(false));
                return $model;
            } else {
                $model->select($this->concatParams(true));
            };
            $sonFetch = (new \yii\db\Query())->select('*')->from(['t1' => $model]);
            $sonModel = $this->gainAllCoachRecord($companyId, $param, $vid, true, true);
            if ($model->count() > $sonModel->count()) {
                $model = $sonFetch->leftJoin(['t2' => $sonModel], $this->gainRelation($vid));
            } else {
                $model = $sonFetch->rightJoin(['t2' => $sonModel], $this->gainRelation($vid));
            }
            if ($this->sort != NULL) {
                $model->orderBy($this->sort);
            }
        } else {
            $model->select($this->concatParams(true));
            if ($this->sort != NULL) {
                $model->orderBy($this->sort);
            }
        }
        return Func::getDataProvider($model, 8);
    }

    /**
     * 运运动-团课统计
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @param $path
     * @param bool $part
     * @param null $data
     * @return array|null|\yii\db\ActiveRecord
     */
    public function gainCourseHaveType($path, $part = true, $data = null)
    {
        if (!$path) return null;
        if ($part) {
            $dataStr = json_decode($path, true);
            $dataArr = explode(',', $dataStr);
            $id = $dataArr[0];
            if (count($dataArr) > 2) {
                $id = $dataArr[1];
            }
        } else {
            $id = $path;
        }
        $tmpArr = [];
        if (isset($data) && !empty($data)) {
            foreach ($data as $v) {
                if (isset($v['path']) && !empty($v['path'])) {
                    $tmpRe = $this->gainCourseHaveOneType($id);
                } else {
                    $tmpRe = null;
                }
                array_push($tmpArr, array_merge($v, ['courseType' => $tmpRe]));
            }
            return $tmpArr;
        }
        return $this->gainCourseHaveOneType($id);
    }

    /**
     * 运运动-团课统计
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @param $id
     * @return array|null|\yii\db\ActiveRecord
     */
    protected function gainCourseHaveOneType($id)
    {
        return Course::find()->select('id, name')->where(['id' => $id])->asArray()->one();
    }

    /**
     * 运运动-团课统计
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @return array
     */
    private function getCurrentRoleAllowVenue()
    {
        //获取权限里的场馆
        $cardObj = new \backend\models\CardCategory();
        $venueIds = $cardObj->getVenueIdByRole();
        return $venueIds;
    }

    /**
     * 运运动-团课统计-排序
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @param $data
     * @return array
     */
    private static function gainSort($data)
    {
        if (!isset($data['sortType']) || empty($data['sortType'])) return null;
        if (!isset($data['sort']) || empty($data['sort'])) return null;
        switch ($data['sortType']) {
            case 'classCount':
                $attr = 'COUNT(distinct gc.id)';
                break;
            case 'memberCount':
                $attr = 'COUNT(ac.id)';
                break;
            case 'averageCount':
                $attr = 'CEIL(COUNT(ac.id)/COUNT(distinct gc.id))';
                break;
            case 'lastClassCount':
                $attr = 'lastClassCount';
                break;
            case 'nowClassCount':
                $attr = 'classCount';
                break;
            case 'lastMemberCount':
                $attr = 'lastMemberCount';
                break;
            case 'nowMemberCount':
                $attr = 'memberCount';
                break;
            case 'lastAverageCount':
                $attr = 'lastAverageCount';
                break;
            case 'nowAverageCount':
                $attr = 'averageCount';
                break;
            case 'riseClass':
                $attr = '(IFNULL(classCount, 0)-IFNULL(lastClassCount, 0))';
                break;
            case 'riseMember':
                $attr = '(IFNULL(memberCount, 0)-IFNULL(lastMemberCount,0))';
                break;
            case 'riseAverage':
                $attr = '(IFNULL(averageCount,0)-IFNULL(lastAverageCount,0))';
                break;
            case 'perClass':
                $attr = 'IFNULL((IFNULL(classCount, 0)-IFNULL(lastClassCount, 0))/lastClassCount,(IFNULL(classCount, 0)-IFNULL(lastClassCount, 0)))';
                break;
            case 'perMember':
                $attr = 'IFNULL((IFNULL(memberCount, 0)-IFNULL(lastMemberCount, 0))/lastMemberCount,(IFNULL(memberCount, 0)-IFNULL(lastMemberCount, 0)))';
                break;
            case 'perAverage':
                $attr = 'IFNULL((IFNULL(averageCount, 0)-IFNULL(lastAverageCount, 0))/lastAverageCount,(IFNULL(averageCount, 0)-IFNULL(lastAverageCount, 0)))';
                break;
            default:
                return null;
        }
        return [$attr => self::convertSortValue($data['sort'])];
    }

    /**
     * 运运动-团课统计
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @param $data
     * @return bool
     */
    private function filter($data)
    {
        error_reporting(~E_NOTICE);
        $this->roleVenues = $this->getCurrentRoleAllowVenue();
        $this->venueId = (isset($data['venueId']) && !empty($data['venueId'])) ? (int)$data['venueId'] : null;
        $this->startTime = (isset($data[self::BEGIN_TIME]) && !empty($data[self::BEGIN_TIME])) ? $data[self::BEGIN_TIME] : null;
        $this->endTime = (isset($data[self::END_TIME]) && !empty($data[self::END_TIME])) ? $data[self::END_TIME] : null;
        $this->coachId = (isset($data[self::COACH]) && !empty($data[self::COACH])) ? (int)$data[self::COACH] : null;
        $this->courseId = (isset($data[self::COURSE]) && !empty($data[self::COURSE])) ? (int)$data[self::COURSE] : null;
        $this->keywords = (isset($data[self::KEY]) && !empty($data[self::KEY])) ? (string)$data[self::KEY] : null;
        $this->courseTypeId = (isset($data[self::COURSE_TYPE]) && !empty($data[self::COURSE_TYPE])) ? (int)$data[self::COURSE_TYPE] : null;
        $this->beginClassTime = (isset($data[self::BEGIN_CLASS_TIME]) && !empty($data[self::BEGIN_CLASS_TIME])) ? (string)$data[self::BEGIN_CLASS_TIME] : null;
        $this->nowStartTime = (isset($data[self::NOW_TIME]) && !empty($data[self::NOW_TIME])) ? $data[self::NOW_TIME] : null;
        $this->nowEndTime = (isset($data[self::END_1_TIME]) && !empty($data[self::END_1_TIME])) ? $data[self::END_1_TIME] : null;
        $this->lastStartTime = (isset($data[self::L_NOW_TIME]) && !empty($data[self::L_NOW_TIME])) ? $data[self::L_NOW_TIME] : null;
        $this->lastEndTime = (isset($data[self::L_END_TIME]) && !empty($data[self::L_END_TIME])) ? $data[self::L_END_TIME] : null;
        $this->sort = self::gainSort($data);
        return true;
    }

    /**
     * 运运动-团课统计-过滤
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @param $query
     * @param $part
     * @return mixed
     */
    private function searchFilter($query, $part)
    {
        $query->andFilterWhere(['gc.venue_id' => $this->venueId]);
        if (!$this->venueId) $query->andFilterWhere(['in', 'gc.venue_id', $this->roleVenues]);
        $part === true ? $query->andFilterWhere(['between', 'gc.class_date', $this->nowStartTime, $this->nowEndTime]) : $query->andFilterWhere(['between', 'gc.class_date', $this->lastStartTime, $this->lastEndTime]);
        $query->andFilterWhere(['between', 'gc.class_date', $this->startTime, $this->endTime]);
        $query->andFilterWhere(['gc.coach_id' => $this->coachId]);
        $query->andFilterWhere(['gc.course_id' => $this->courseId]);
        $query->andFilterWhere(['or', ['like', 'ee.name', $this->keywords], ['like', 'cc.name', $this->keywords]]);
        $query->andFilterWhere(['TRIM(\'"\' FROM SUBSTRING_INDEX(SUBSTRING_INDEX(cc.`path`,",",2),",",-1))' => $this->courseTypeId]);
        $query->andFilterWhere(['FROM_UNIXTIME(gc.`start`,\'%H:%i\')' => $this->beginClassTime]);
        return $query;
    }

    /**
     * 运运动-团课统计-详细列表
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @param $param
     * @return \yii\data\ActiveDataProvider
     */
    public function gainCoachMemberCount($companyId, $param)
    {
        $this->filter($param) and ($allCompanyId = $this->getAllCompany($companyId));
        $model = Employee::find()->alias('ee')
            ->joinWith(['organization or1' => function ($q) {
                $q->onCondition(['<>', 'ee.status', 2]);
                $q->where(['or1.style' => 3, 'or1.code' => 'tuanjiao']);
            }], false)
            ->joinWith(['aboutClasses ac' => function ($q) {
                $q->joinWith(['member mm' => function ($q) {
                    $q->joinWith(['memberDetails md'], false);
                }], false)
                    ->joinWith(['groupClass gc' => function ($q) {
                        $q->where(['gc.status' => 1]);
                        $q->joinWith('allCourse cc', false);
                    }], false)
                    ->onCondition(['in', 'ac.status', [1, 3, 4]]);
            }], false)
            ->select('
                                count(ac.member_id) memberCount,
                                md.name memberName,
                                mm.mobile memberMobile,
                                ')
            ->groupBy('ac.member_id')
            ->asArray();
        if (!empty($allCompanyId) && !empty($companyId)) $model->andWhere(["in", "ee.company_id", $allCompanyId]);
        $this->filterDetailSearch($model);
        return Func::getDataProvider($model, 8);
    }

    /**
     * 运运动-团课统计-详情过滤
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @param $query
     * @param $vid
     * @return mixed
     */
    private function filterDetailSearch($query)
    {
        $query->andFilterWhere(['between', 'gc.class_date', $this->startTime, $this->endTime]);
        $query->andFilterWhere(['gc.course_id' => $this->courseId]);
        if ($this->venueId === NULL) $query->andFilterWhere(['in', 'gc.venue_id', $this->roleVenues]);
        $query->andFilterWhere(['TRIM(\'"\' FROM SUBSTRING_INDEX(SUBSTRING_INDEX(cc.`path`,",",2),",",-1))' => $this->courseTypeId]);
        $query->andFilterWhere(['FROM_UNIXTIME(gc.`start`,\'%H:%i\')' => $this->beginClassTime]);
        $query->andFilterWhere(['ee.id' => $this->coachId]);
        return $query;
    }

    /**
     * @desc:教照片或者视频展示
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/6
     * @time: 9:42
     * @param $employeeId
     * @param $type
     * @return array|\yii\db\ActiveRecord[]
     */
    public function personalityPictureShow($employeeId, $type)
    {

        if ($type == 1) {

            $list = PersonalityImages::find()
                ->where(['employee_id' => $employeeId])
                ->andWhere(['type' => $type])
                ->orderBy('create_at DESC')
                ->asArray()
                ->All();
        } else {
            $list = PersonalityImages::find()
                ->where(['employee_id' => $employeeId])
                ->andWhere(['type' => $type])
                ->orderBy('create_at DESC')
                ->asArray()
                ->one();
        }

        return $list;

    }

    /**
     * @desc:是否是私教
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/6/6
     * @time: 10:42
     * @param $employeeId
     * @return bool
     */
    public function personalityIs($employeeId)
    {

        $employee = Employee::findOne($employeeId);

        $organization = Organization::findOne($employee['organization_id']);

        if ($organization['name'] != '私教部') {
            return false;
        } else {
            return true;
        }
    }
}