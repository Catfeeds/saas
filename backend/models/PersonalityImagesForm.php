<?php
namespace backend\models;
use common\models\base\PersonalityImages;
use yii\base\Model;

/**
 * Class PersonalityImagesForm
 * @package backend\models
 */
class PersonalityImagesForm extends Model
{


    public $employee_id;     //员工id
    public $type;           //类型
    public $url;            //图片或视频地址
    public $describe;       //描述
    /**
     * @desc:验证规则
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/5/25
     * @time: 19:06
     * @return array
     */
    public function rules()
    {
        return [
            [['employee_id',"type","url"], 'required'],
        ];
    }
    /**
     * @desc:表的增添数据
     * @author: 马延阳<mayanyang@itsports.club>
     * @date: 2018/5/25
     * @time: 19:08
     */
    public function  addPersonalityVideo(){

            $employee = Employee::findOne($this->employee_id);

            if(empty($employee)){
                return '该私教较量不存在';
            }

            $transaction = \Yii::$app->db->beginTransaction();
            try {
//                PersonalityImages::findOne($this->employee_id);
                PersonalityImages::deleteAll(['employee_id' => $this->employee_id, 'type' => 2]);

                $model = new PersonalityImages();
                $model->employee_id = $this->employee_id;
                $model->type = $this->type;
                $model->url = $this->url;
                $model->create_at     = time();

                if($model->save()){

                    if ($transaction->commit() === null) {
                        return true;
                    } else {
                        return false;
                    }

                }else{
                    return false;
                }

            } catch (\Exception $e) {
                $transaction->rollBack();
                return  $e->getMessage();
            }

    }





























}