<?php

namespace backend\controllers;
use backend\models\Employee;
use backend\models\Course;
use common\models\Func;
use Yii;

class TeamClassController extends \backend\controllers\BaseController
{

    /**
     * 运运动-团课统计-渲染
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @return string
     */

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 运运动-团课统计-渲染
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @return string
     */

    public function actionContrast()
    {
        return $this->render('contrast');
    }

    /**
     * 运运动-团课统计-1
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     */

    public function actionGroupClassList()
    {
        $params = Yii::$app->request->queryParams;
        $e          = new Employee();
        $model      = $e -> gainAllCoachRecord($this->companyId,$params, 1);
        $pagination = $model->pagination;
        $pages      = Func::getPagesFormat($pagination, 'classGroupPages');
        $data       = $model->models;
        if(isset($params['page'])){
            $nowPage = $params['page'];
        }else{
            $nowPage = 1;
        }
        return json_encode(['data' => $data, 'page' => $pages, 'nowPage' => $nowPage, 'status' => 'success']);
    }

    /**
     * 运运动-团课统计-2
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @return string
     */

    public function actionWelcomeCourseList()
    {
        $params = Yii::$app->request->queryParams;
        $e          = new Employee();
        $model      = $e -> gainAllCoachRecord($this->companyId,$params, 2);
        $pagination = $model->pagination;
        $pages      = Func::getPagesFormat($pagination, 'welcomeCoursePages');
        $data       = $model->models;
        if(isset($params['page'])){
            $nowPage = $params['page'];
        }else{
            $nowPage = 1;
        }
        return json_encode(['data' => $data, 'page' => $pages, 'nowPage' => $nowPage, 'status' => 'success']);
    }

    /**
     * 运运动-团课统计-3
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @return string
     */

    public function actionWelcomeTimeList()
    {
        $params = Yii::$app->request->queryParams;
        $e          = new Employee();
        $model      = $e -> gainAllCoachRecord($this->companyId,$params, 3);
        $pagination = $model->pagination;
        $pages      = Func::getPagesFormat($pagination, 'welcomeTimePages');
        $data       = $model->models;
        if(isset($params['page'])){
            $nowPage = $params['page'];
        }else{
            $nowPage = 1;
        }
        return json_encode(['data' => $data, 'page' => $pages, 'nowPage' => $nowPage, 'status' => 'success']);
    }

    /**
     * 运运动-团课统计
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     */

    public function actionGroupClassDetail()
    {
        $params      = Yii::$app->request->queryParams;
        $e          = new Employee();
        $query      = $e->gainCoachMemberCount($this->companyId, $params);
        $pagination = $query->pagination;
        $pages      = Func::getPagesFormat($pagination, 'groupClassDetailPages');
        if(isset($params['page'])){
            $nowPage = $params['page'];
        }else{
            $nowPage = 1;
        }
        return json_encode(['data' => $query->models, 'page' => $pages,  'nowPage' => $nowPage, 'status' => 'success']);
    }

    /**
     * 运运动-团课统计
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @return string
     */

    public function actionWelcomeCourseDetail()
    {
        $params      = Yii::$app->request->queryParams;
        $e          = new Employee();
        $query      = $e->gainCoachMemberCount($this->companyId, $params);
        $pagination = $query->pagination;
        $pages      = Func::getPagesFormat($pagination, 'welcomeDetailPages');
        if(isset($params['page'])){
            $nowPage = $params['page'];
        }else{
            $nowPage = 1;
        }
        return json_encode(['data' => $query->models, 'page' => $pages,  'nowPage' => $nowPage, 'status' => 'success']);
    }

    /**
     * 运运动-团课统计
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @return string
     */

    public function actionWelcomeTimeDetail()
    {
        $params      = Yii::$app->request->queryParams;
        $e          = new Employee();
        $query      = $e->gainCoachMemberCount($this->companyId, $params);
        $pagination = $query->pagination;
        $pages      = Func::getPagesFormat($pagination, 'timeModalPages');
        if(isset($params['page'])){
            $nowPage = $params['page'];
        }else{
            $nowPage = 1;
        }
        return json_encode(['data' => $query->models, 'page' => $pages,  'nowPage' => $nowPage, 'status' => 'success']);
    }

    /**
     * 运运动-团课统计
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @return string
     */

    public function actionCourseAllType()
    {
        $model = new Course();
        return json_encode(['data' => $model->gainAllCourseType($this->companyId), 'status' => 'success']);
    }

    /**
     * 运运动-团课统计
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @return string
     */

    public function actionAllCourseLister()
    {
        $param = Yii::$app->request->queryParams;
        $model = new Course();
        if(isset($param['courseTypeId']) && !empty($param['courseTypeId'])){
            return json_encode(['data' => $model->getBottomData($param['courseTypeId']), 'status' => 'success']);
        }
        return json_encode(['data' => [], 'status' => 'success']);
    }

    /**
     * 运运动-团课统计
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     * @return mixed
     */
    
    public function actionAllCourse()
    {
        $model = new Course();
        return json_encode(['data' => $model->gainAllCourse($this->companyId), 'status' => 'success']);
    }

    /**
     * 运运动-团课环比
     * @author   yanghuilei<yanghuilei@itsport.club>
     * @createAt 2018/2/5
     */
    public function actionCourseContrast()
    {
        $params = $this->get;
        $vid = 1;
        if(isset($params['vid']) && !empty($params['vid'])){
            $vid = (int)$params['vid'];
        }
        switch ($vid)
        {
            case 1:
                $funcPage = 'contrastCoachPage';
                break;
            case 2:
                $funcPage = 'contrastCoursePage';
                break;
            case 3:
                $funcPage = 'contrastTimePage';
                break;
            default:
                $funcPage = 'contrastCoachPage';
        }
        $e          = new Employee();
        $model      = $e -> gainAllCoachRecord($this->companyId, $params, $vid, true);
        $pagination = $model->pagination;
        $pages      = Func::getPagesFormat($pagination, $funcPage);
        $data       = $model->models;
        if(isset($params['page'])){
            $nowPage = $params['page'];
        }else{
            $nowPage = 1;
        }
        return json_encode(['data' => $data, 'page' => $pages,  'nowPage' => $nowPage, 'status' => 'success']);
    }
}
