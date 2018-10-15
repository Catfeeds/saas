<?php

namespace backend\models;

use common\models\base\Employee;
use Yii;
use common\models\Func;
use common\models\relations\CourseRelations;

class Course extends \common\models\Course
{
    use CourseRelations;

    public $className;
    public $sorts;
    public $sortName;
    public $theClassType;
    public $searchContent;
    public $nowBelongId;
    public $coachId;
    public $venueId;

    const SEARCH_CONTENT = 'searchContent';
    const NOW_BELONG_ID = 'nowBelongId';
    const  CATEGORY = 'category';
    const  CLASS_TYPE = 'class_type';
    const  CREATED_AT = 'created_at';
    const  SORT_TYPE = 'sortType';
    const  SORT_NAME = 'sortName';
    const  PATHS = 'paths';
    const  VENUE = 'venueId';
    const  COACH = 'coachId';

    /**
     * 会员卡管理 - 会员卡 - 获取搜索规格
     * @create 2017/4/5
     * @author houkaixin<houkaixin@itsports.club>
     * @param $sort
     * @return mixed
     */
    public static function convertSortValue($sort)
    {
        if ($sort == 'ASC') {
            return SORT_ASC;
        } elseif ($sort == 'DESC') {
            return SORT_DESC;
        }
    }

    /**
     * 后台 - 课种管理 - 课种数据遍历
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/6
     * @update Huangpengju
     * @update 2017/5/6
     * @param $params
     * @return string
     */
    public function getCourseData($params)
    {
        $this->customLoad($params);
        $query = Course::find()->alias('course')
            ->joinWith(['admin'])
            ->joinWith([
                'admin' => function ($query) {
                    $query->joinWith(['employee employee']);
                }
            ])
            ->select("course.*,cloud_admin.id as adminId,employee.create_id as createId,employee.name as employeeName")
            ->orderBy($this->sorts)
            ->asArray();
        $query = $this->getSearchWhere($query);

        return Func::getDataProvider($query, 8);
    }

    /**
     * 后台 - 课种管理 - 数据处理验证
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/6
     * @param $data
     * @return string
     */
    public function customLoad($data)
    {
        $this->className = (isset($data['name']) && !empty($data['name'])) ? $data['name'] : null;
        $this->courseSearch($this->className);
        $this->category = (isset($data[self::CATEGORY]) && !empty($data[self::CATEGORY])) ? $data[self::CATEGORY] : null;
        $this->class_type = (isset($data[self::CLASS_TYPE]) && !empty($data[self::CLASS_TYPE])) ? $data[self::CLASS_TYPE] : null;
        $this->create_id = (isset($data['create_id']) && !empty($data['create_id'])) ? $data['create_id'] : null;
        $this->created_at = (isset($data[self::CREATED_AT]) && !empty($data[self::CREATED_AT])) ? $data[self::CREATED_AT] : null;
        $this->name = (isset($data['name']) && !empty($data['name'])) ? $data['name'] : null;
        $this->pic = (isset($data['pic']) && !empty($data['pic'])) ? $data['pic'] : null;
        $this->searchContent = (isset($data[self::SEARCH_CONTENT]) && !empty($data[self::SEARCH_CONTENT])) ? $data[self::SEARCH_CONTENT] : null;
        $this->nowBelongId = (isset($data[self::NOW_BELONG_ID]) && !empty($data[self::NOW_BELONG_ID])) ? $data[self::NOW_BELONG_ID] : null;
        $this->sorts = self::loadSort($data);
        $this->venueId = (isset($data[self::VENUE]) && !empty($data[self::VENUE])) ? $data[self::VENUE] : null;
        $this->coachId = (isset($data[self::COACH]) && !empty($data[self::COACH])) ? $data[self::COACH] : null;
        return true;
    }

    /**
     * 会员卡管理 - 课种搜索 - 对课种进行搜索
     * @create 2017/4/25
     * @author houkaixin<lihuien@itsports.club>
     * @param $data
     * @return mixed
     */
    public function courseSearch($data)
    {
        if ($data == "私教课") {
            $this->className = 1;
        }
        if ($data == "团教课") {
            $this->className = 2;
        }
    }

    /**
     * 会员卡管理 - 会员卡 - 获取排序条件
     * @create 2017/4/5
     * @author houkaixin<lihuien@itsports.club>
     * @param $data
     * @return mixed
     */
    public static function loadSort($data)
    {
        $sorts = [
            'course.created_at' => SORT_DESC
        ];
        if (isset($data[self::SORT_TYPE]) && $data[self::SORT_TYPE] == self::CATEGORY) {
            $sorts = ['`course`.category' => self::convertSortValue($data[self::SORT_NAME])];
        }
        if (isset($data[self::SORT_TYPE]) && $data[self::SORT_TYPE] == self::CLASS_TYPE) {
            $sorts = ['`course`.class_type' => self::convertSortValue($data[self::SORT_NAME])];
        }
        if (isset($data[self::SORT_TYPE]) && $data[self::SORT_TYPE] == 'create_id') {
            $sorts = ['`course`.create_id' => self::convertSortValue($data[self::SORT_NAME])];
        }
        if (isset($data[self::SORT_TYPE]) && $data[self::SORT_TYPE] == 'name') {
            $sorts = ['`course`.name' => self::convertSortValue($data[self::SORT_NAME])];
        }
        if (isset($data[self::SORT_TYPE]) && $data[self::SORT_TYPE] == 'pic') {
            $sorts = ['`course`.pic' => self::convertSortValue($data[self::SORT_NAME])];
        }
        if (isset($data[self::SORT_TYPE]) && $data[self::SORT_TYPE] == 'update_at') {
            $sorts = ['`course`.update_at' => self::convertSortValue($data[self::SORT_NAME])];
        }
        return $sorts;
    }

    /**
     * 会员卡管理 - 课种 -  增加过滤收索条件
     * @create 2017/6/14
     * @author houkaixin<lihuien@itsports.club>
     * @param $query
     * @return string
     */
    public function getSearchWhere($query)
    {
        $query->andFilterWhere([
            'or',
            ["like", "course.name", $this->className],
            ["like", self::CATEGORY, $this->className],
            ["like", "cloud_admin.username", $this->className],
            ["like", "employee.name", $this->className],
            [self::CLASS_TYPE => $this->className]
        ]);
        $query->andFilterWhere([self::CLASS_TYPE => $this->class_type]);
        $query->andFilterWhere(['course.company_id' => $this->nowBelongId]);

        return $query;
    }

    /**
     * 后台 - 课种管理 - 课种删除
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/5
     * @param $id
     * @return string
     */
    public static function getCourseDel($id)
    {
        $courseType = Course::findOne($id);
        $model = Course::find()->where(['pid' => $id])->asArray()->all();
        $groupClass = GroupClass::find()->where(['course_id' => $id])->asArray()->all();
        $aboutClass = AboutClass::find()->where(['class_id' => $id])->asArray()->all();
        if (empty($model) && empty($groupClass) && empty($aboutClass)) {
            $delResult = $courseType->delete();
        } else {
            return false;
        }
        if ($delResult) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *后台会员管理 - 会员基本信息管理模块- 增加课种
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/6
     * @param $companyId //公司id
     * @param $venueId // 场馆id
     * @return bool|string
     */
    public function setCourseSave($companyId, $venueId)
    {
        if (isset($this->pid) && $this->pid != "0") {
            $pidPath = Course::find()->select("path")->where(['id' => $this->pid])->asArray()->one();
            $pidPath = json_decode($pidPath['path']);
            $path = json_encode($pidPath . "," . $this->pid);
            $this->path = $path;
            //根据顶级id查询课种
            $name = Course::find()->select("name")->where(["id" => $this->pid])->asArray()->one();
            $this->category = $name['name'];
        } else {
            $this->path = "0";
            $this->category = $this->name;
        }
        $this->created_at = time();
        $this->update_at = time();
        $this->company_id = $companyId;
        $this->venue_id = $venueId;
        $this->create_id = Yii::$app->user->identity->id;
        if ($this->save()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     *后台会员管理 - 会员基本信息管理模块- 单条课程查询
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/6
     * @return bool|string              //指定课程的名称
     */
    public function courseDetail($data)
    {
        return Course::find()->where(["id" => $data])->asArray()->one();        //查询指定课程的名称

    }

    /**
     *后台会员管理 - 会员卡详情- 多条团课套餐绑定
     * @author Huanghua<huanghua@itsports.club>
     * @create 2017/4/6
     * @return bool|string              //指定课程的名称
     */
    public function courseDetailAll($data)
    {
        return Course::find()->where(["id" => $data])->asArray()->all();
    }

    /**
     *后台会员管理 - 会员基本信息管理模块- 单条课程信息修改
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/7
     * @return bool|string
     */
    public function getCourseUpdate()
    {
        $data = \Yii::$app->request->post();
        $course = Course::findOne($data['id']);//1.修改Course表
        if ($data['pid'] != $course['pid']) { //2.判断pid是否有改变

            if ($data['pid'] == "0") {
                $path = json_encode(0);
                $course->category = $data["name"];
            } else {
                $pidPath = Course::find()->select("path")->where(['id' => $data['pid']])->asArray()->one();
                $pidPath = json_decode($pidPath['path']);
                $path = json_encode($pidPath . "," . $data['pid']);

                // 根据顶级id查询课种
                $name = Course::find()->select("name")->where(["id" => $data['pid']])->asArray()->one();
                $course->category = $name['name'];
            }

            $course->path = $path;
        } else {
            if ($data['pid'] == "0") {
                $path = json_encode(0);
                $course->category = $data["name"];
            }
        }
        $course->pid = $data['pid'];
        $course->course_desrc = $data['course_desrc'];       //分配数据
        $course->update_at = time();
        $course->create_id = Yii::$app->user->identity->id;
        $course->name = $data["name"];
        $course->pic = $data['pic'];
        $course->class_type = $data[self::CLASS_TYPE];
        //同时执行儿子类修改
        //判断修改项是否有 子类
        $result = Course::updateAll(['category' => $data["name"]], ["pid" => $data['id']]);
        if ($course->save() && $result) {
            return true;
        } else {
            return $course->errors;
        }
    }

    /**
     *后台会员管理 - 会员基本信息管理模块- 查询课种所有数据
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/7
     * @return bool|string
     */
    public function getClassData()
    {
        $data = Course::find()->orderBy("path")->asArray()->all();
        $dataS = $data;
        // 整理数据
        if (!empty($dataS)) {
            foreach ($dataS as $key => $value) {
                $dataS[$key]["path"] = json_decode($dataS[$key]["path"]);
                $dataS[$key][self::PATHS] = $dataS[$key]["path"] . "," . $dataS[$key]["id"];
                // 重新命名name 字段
                $arr = explode(",", $dataS[$key][self::PATHS]);
                $len = count($arr);
                $dLen = $len - 1;
                $dataS[$key]["name"] = str_repeat("--|", $dLen) . $dataS[$key]["name"];
            }
            foreach ($dataS as $key => $value) {
                foreach ($dataS as $keys => $values) {
                    if ($dataS[$key][self::PATHS] < $dataS[$keys][self::PATHS]) {
                        $oneData = $dataS[$key];
                        $dataS[$key] = $dataS[$keys];
                        $dataS[$keys] = $oneData;
                    }
                }
            }
        }
        return $dataS;
    }

    /**
     * @describe 后台会员管理 - 新课种管理 - 课种数据过滤根据默认场馆
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @param $query
     * @param $id
     * @return mixed
     */
    public function filterCourseData($query, $id)
    {
        $query->andFilterWhere(['company_id' => $id]);

        return $query;
    }

    /**
     * @describe 课种搜索公共方法（分团教课和私教课）-- 团课
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @param $type
     * @param $companyIds
     * @return array
     */
    public function getClassDataS($type, $companyIds)
    {
        if ($type == 1 || $type == 2) {
            $this->theClassType = $type;
            $data = Course::find()->where([self::CLASS_TYPE => $this->theClassType])->orderBy("path")->asArray();
            $data = $this->filterCourseData($data, $companyIds);
            $data = $data->all();
        } else if ($type == 3) {
            $data = Course::find()->orderBy("path")->asArray()->all();
            $data = $this->filterCourseData($data, $companyIds);
            $data = $data->all();
        } else {
            $data = [];
        }

        $dataS = $data;
        // 整理数据(拼接paths路径，并且重新组装 课程名字)
        if (!empty($dataS)) {
            foreach ($dataS as $key => $value) {
                $dataS[$key]["path"] = json_decode($dataS[$key]["path"]);
                $dataS[$key][self::PATHS] = $dataS[$key]["path"] . "," . $dataS[$key]["id"];
                // 重新命名name 字段
                $arr = explode(",", $dataS[$key][self::PATHS]);
                $len = count($arr);
                $dLen = $len - 1;
                $dataS[$key]["name"] = str_repeat("--|", $dLen) . $dataS[$key]["name"];
            }
            foreach ($dataS as $key => $value) {
                foreach ($dataS as $keys => $values) {
                    if ($dataS[$key][self::PATHS] < $dataS[$keys][self::PATHS]) {
                        $oneData = $dataS[$key];
                        $dataS[$key] = $dataS[$keys];
                        $dataS[$keys] = $oneData;
                    }
                }
            }
        }

        return $dataS;
    }

    /**
     *后台会员管理 - 会员基本信息管理模块- 私教课程所有信息遍历
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/10
     * @return bool|string
     */
    public function getPrivateData()
    {
        $data = Course::find()->where([self::CLASS_TYPE => 1])->orderBy("path")->asArray()->all();
        $dataS = $data;
        // 整理数据
        foreach ($dataS as $key => $value) {
            $dataS[$key]["path"] = json_decode($dataS[$key]["path"]);
            $dataS[$key][self::PATHS] = $dataS[$key]["path"] . "," . $dataS[$key]["id"];
            // 重新命名name 字段
            $arr = explode(",", $dataS[$key][self::PATHS]);
            $len = count($arr);
            $dLen = $len - 1;
            $dataS[$key]["name"] = str_repeat("--|", $dLen) . $dataS[$key]["name"];
        }
        foreach ($dataS as $key => $value) {
            foreach ($dataS as $keys => $values) {
                if ($dataS[$key][self::PATHS] < $dataS[$keys][self::PATHS]) {
                    $oneData = $dataS[$key];
                    $dataS[$key] = $dataS[$keys];
                    $dataS[$keys] = $oneData;
                }
            }
        }
        return $dataS;
    }

    /**
     *团课管理- 修改 - 下拉列表（获取团课所有信息）
     * @author Hou kaixin <houkaixin@itsports.club>
     * @create 2017/4/19
     * @update huangpengju
     * @update 2017/06/10
     * @param $id //公司或者场馆id
     * @return array   //返回团课的所有信息
     */
    public function groupCourse($id)
    {
        $data = Course::find()->alias('course')->asArray()->where([self::CLASS_TYPE => 2]);
        $data = $data->andFilterWhere(['course.venue_id' => $id]);
        $data = $data->all();
        foreach ($data as $k => &$v) {
            $info = Course::find()->where(['pid' => $v['id']])->asArray()->all();
            if (!empty($info)) {
                unset($data[$k]);
            }
        }

        return $data;
    }

    /**
     * @describe 云运动 - 添加教练 - 获取场馆信息
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @param $companyId
     * @return array
     */
    public function filterMemberCard($companyId)
    {
        if (!is_array($companyId)) {
            $allCompanyId = [$companyId];
        } else {
            $allCompanyId = $companyId;
        }

        // 获取公司联盟下的所有公司
        $allCompanyData = ApplyRecord::find()->where(["and", ["apply_id" => $companyId], [">", "end_apply", time()], ["status" => 1]])
            ->select(["be_apply_id"])
            ->asArray()->all();
        if (!empty($allCompanyData)) {
            foreach ($allCompanyData as $keys => $value) {
                $allCompanyId[] = $value["be_apply_id"];
            }
        }

        return $allCompanyId;
    }

    /**
     *团课管理- 修改 - 下拉列表（获取私课所有信息）
     * @author 朱梦珂 <zhumengke@itsports.club>
     * @create 2017/4/26
     * @update huangpengju
     * @update 2017/06/10
     * @param $id //公司或者场馆id
     * @return array   //返回私课的所有信息
     */
    public function groupPrivateCourse($id)
    {
        $data = Course::find()
            ->alias('course')
            ->asArray()
            ->where([self::CLASS_TYPE => 1]);

        $data = $data->andFilterWhere(['course.venue_id' => $id]);
        $data = $data->all();

        return $data;
    }

    /**
     *团课管理- 修改 - 下拉列表（获取私课所有信息）
     * @author 侯凯新 <houkaixin@itsports.club>
     * @create 2017/5/6
     * @param $type //获取的课种种类
     * @param $companyIds // 所属身份id
     * @return array   //返回顶级的私课或团课信息
     */
    public function getTheTopData($type, $companyIds)
    {
        $data = Course::find()->where(["class_type" => $type])->andwhere(["pid" => 0])->asArray();
        $league_company_ids = $this->filterMemberCard($companyIds);
        $data = $data->andFilterWhere(['in', 'company_id', $league_company_ids]);
        $data = $data->all();

        return $data;
    }

    /**
     * @describe 团课添加 查询团课 - 最低级课程Id
     * @author <yanghuilei@itsport.club>
     * @createAt 2018-07-31
     * @param $type
     * @param $id
     * @return array
     */
    public function getGroupClassId($type, $id)
    {
        $classId = [];                      //定义空数组，存放最低级的课程id
        if ($type == 2) {
            $this->theClassType = $type;
            $data = Course::find()->alias('course')->where([self::CLASS_TYPE => $this->theClassType])->orderBy("path")->asArray();  //查询所有类型为团课的课程
            $data = $data->andFilterWhere(['course.company_id' => $id]);
            $data = $data->all();
            foreach ($data as $k => $v) {
                $first = Course::find()->where(["pid" => $v['id']])->orderBy("path")->asArray()->all();   //查询该pid下面是否还有子类
                if (empty($first)) {
                    $classId[] = $v['id'];
                }
            }
        }

        return $classId;
    }

    /**
     * @团课添加 查询团课 - 最低级课程Id
     * @author Huang Pengju <huangpengju@itsports.club>
     * @param  $type //课程类别
     * @update huangpengju
     * @update 2017/06/10
     * @param $id //公司或者场馆id
     * @return array
     */
    public function getGroupClassInfo($type, $id)
    {
        $groupClass = [];                                   //定义课程数组
        $data = $this->getGroupClassId($type, $id);         //获取最底层课程的id
        foreach ($data as $k => $v) {
            $groupClass[] = Course::find()->where(["id" => $v])->orderBy("id")->asArray()->one();  //查询所有类型为团课的课程
        }

        return $groupClass;
    }

    /**
     * @课种城市级联添加模板 - 查询团课 - 最低级课程Id
     * @author HouKaiXin <HouKaiXin@itsports.club>
     * @param  $type //课程类别
     * @return array
     */
    public static function getTemplate($type)
    {
        if ($type == 'addNextTemplate') {
            $html = 'add/nextLevel';
            return $html;
        }
    }

    /**
     * 数据中心- 查询团课 - 获取指定课种  低级课程信息
     * @author HouKaiXin <HouKaiXin@itsports.club>
     * @param $courseTypeId
     * //     * @param $belongType //所属级别
     * //     * @param $belongId //所属身份
     * @return array
     */
    public function getBottomData($courseTypeId)
    {
        //获取所有指定顶级分类信息
        $path = "0," . $courseTypeId;
        $data = Course::find()->where(["and", ["like", "path", $path], ["class_type" => 2]])->asArray();
        $data = $data->all();
        //过滤掉不是底级分类的信息
        if (!empty($data)) {
            $resultData = $this->filterData($data, $courseTypeId);
            return $resultData;
        } else {
            return [];
        }
    }

    /**
     * 数据中心- 查询团课 - 获取指定课种  低级课程信息（获取底级课程信息逻辑）
     * @author HouKaiXin <HouKaiXin@itsports.club>
     * @param  $data （array 所有课程信息）
     * @param  $courseTypeId （顶级课程id）
     * @return array
     */
    public function filterData($data, $courseTypeId = null)
    {
        $pidS = [];
        if ($courseTypeId !== null) {
            $idS = ["$courseTypeId"];
        }
        $resultData = [];
        // 获取所有的id
        foreach ($data as $keys => $values) {
            $pidS[] = $values["pid"];
            $idS[] = $values["id"];
        }
        array_unique($pidS);
        $result = array_diff($idS, $pidS);
        //检测pid是否在里边
        foreach ($data as $keys => $values) {
            if (in_array($values["id"], $result)) {
                $resultData[] = $values;
            }
        }
        return $resultData;
    }

    /**
     * 数据中心- 查询团课 - 点击修改 获取单条数据
     * @author HouKaiXin <HouKaiXin@itsports.club>
     * @param  $id //指定课程的id
     * @param  $courseType ;
     * @return array
     */
    public function getOneData($id, $courseType)
    {
        $data = $this->getCourseOneById($id);
        $endData = ["select" => $courseType, "courseData" => $data];
        return $endData;
    }

    /**
     * 数据中心- 查询团课 - 点击修改 获取单条数据
     * @author lihuien <lihuien@itsports.club>
     * @param  $id //指定课程的id
     * @return array
     */
    public function getCourseOneById($id)
    {
        $data = Course::find()->where(["id" => $id])->asArray()->one();
        return $data;
    }

    /**
     * @团课排课 - 课程表 - 添加课程 获取该课程绑定的教练
     * @author zhumengke <zhumengke@itsports.club>
     * @create 2017/8/25
     * @return object
     */
    public function getCoachByCourse($courseId)
    {
        $course = Course::findOne(['id' => $courseId]);
        $coachArr = json_decode($course['coach_id'], true);
        $coach = [];
        if (!empty($coachArr)) {
            foreach ($coachArr as $key => $value) {
                $employee = Employee::find()->where(['id' => $value])->asArray()->one();
                if (isset($employee) && $employee['status'] != 2) {
                    $coach[] = $employee;
                }
            }
        }

        return $coach;
    }

    /**
     * 云运动-团课统计-根据场馆和教练获取课程
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/3
     */
    public function gainClassType($param)
    {
        $bool = $this->customLoad($param);
        if (!$bool) {
            return false;
        }
        return Course::find()->where(['like', 'coach_id', "\"{$this->coachId}\""])->select('id,name')->asArray()->all();
    }

    /**
     * 运运动-团课统计
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @return array
     */
    public function gainAllCourseType($companyId)
    {
        $c = Course::find()->select('name,id')->where(['class_type' => 2, 'pid' => 0])->asArray();
        if (!empty($companyId)) {
            $c->andFilterWhere(['company_id' => $companyId]);
        }
        return $c->all(Yii::$app->db);
    }

    /**
     * 运运动-团课统计
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @param $companyId
     * @return array|null
     */
    public function gainAllCourse($companyId)
    {
        $c = Course::find()->select('name, id, pid, pic')->where(['class_type' => 2])->asArray();
        if (!empty($companyId)) {
            $c->andFilterWhere(['company_id' => $companyId]);
        }
        $data = $c->all(Yii::$app->db);
        if (!$data) {
            return null;
        }
        return $this->filterData($data);
    }
}