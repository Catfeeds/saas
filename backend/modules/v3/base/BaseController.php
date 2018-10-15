<?php
/**
 * api应用公共控制器类
 */
namespace backend\modules\v3\base;

use Yii;

abstract class BaseController extends \yii\rest\ActiveController
{
    public $modelClass = 'common\models\AboutClass';

    public $post = NULL;
    public $get = NULL;
    public $user = NULL;
    public $userId = NULL;
    public $coachId = NULL;
    public $venueId = NULL;

    public $serializer = [
        'class' => 'backend\modules\v3\base\MySerializer',
        'collectionEnvelope' => 'data',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors'  => ['Origin' => ['*']],
        ];
        $behaviors['contentNegotiator']['formats'] = ['application/json' => yii\web\Response::FORMAT_JSON];
        return $behaviors;
    }

    public function actions()
    {
        return [];
    }

    public function beforeAction($action)
    {
        parent::beforeAction($action);

        $this->post = Yii::$app->request->post();
        $this->get = Yii::$app->request->get();

        return $action;
    }

    /**
     * model的错误信息转换成字符串以便于输出
     * @author zhangxiaobing <zhangxiaobing@itsports.club>
     * @create 2017/12/08
     * @param $errors
     * @return string
     */
    protected function toString($errors)
    {
        $str = '';
        foreach ($errors as $field => $msgs)
            foreach ($msgs as $msg)
                $str.= " $msg";
        $str = str_replace('。', '', $str);
        $str = ltrim($str, ' ');
        return $str;
    }

    /**
     * 格式化错误信息
     * @author zhangxiaobing <zhangxiaobing@itsports.club>
     * @create 2017/12/08
     * @param $msg 错误信息
     * @param array $data 数据
     * @param int $code 错误代码
     * @return array
     */
    protected function error($msg, $data=[], $code=0)
    {
        $return = ['code'=>$code, 'status'=>'error', 'message'=>$msg];
        if(!empty($data)) $return['data'] = $data;
        return $return;
    }

    /**
     * 格式化成功信息
     * @author zhangxiaobing <zhangxiaobing@itsports.club>
     * @create 2017/12/08
     * @param array $data 数据
     * @param string $msg 提示信息
     * @param int $code 代码
     * @return array
     */
    protected function success($data=[], $msg='', $code=1)
    {
        return ['code'=>$code, 'status'=>'success', 'message'=>$msg, 'data'=>$data];
    }

}