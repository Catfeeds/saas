<?php
namespace backend\models;
use common\models\base\MemberCourseOrder;
use common\models\base\MemberCourseOrderDetails;
use Yii;
use yii\base\Model;
class PrivateNumberForm  extends Model
{

    public $chargeId;      // 私课id
    public $classNumber;   // 剩余节数

    /**
     * 云运动 - 会员管理 -  表单验证规则
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/11/11
     * @return array
     */
    public function rules()
    {
        return [
            [['chargeId', 'classNumber'], 'required'],
            [['chargeId', 'classNumber'], 'safe'],
        ];
    }

    /**
     * 云运动 - 会员管理 -  私课剩余节数修改
     * @author huanghua<huanghua@itsports.club>
     * @create 2017/11/11
     * @return array
     * @inheritdoc
     */
    public function editPrivate()
    {
        $memberCourse = MemberCourseOrder::findOne(["id" => $this->chargeId]);
        $memberCourseDetails = MemberCourseOrderDetails::findOne(["course_order_id" => $memberCourse['id']]);

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (isset($memberCourse)) {
                $memberCourse->overage_section = $this->classNumber;         // 剩余节数
                $memberCourse = $memberCourse->save() ? $memberCourse : $memberCourse->errors;
            }
            if (!isset($memberCourse->id)) {
                throw new \Exception('操作失败');
            }

            if (isset($memberCourseDetails)) {
                $memberCourseDetails->course_num = $this->classNumber;
                $memberCourseDetails = $memberCourseDetails->save() ? $memberCourseDetails : $memberCourseDetails->errors;
            }
            if (!isset($memberCourseDetails->id)) {
                throw new \Exception('操作失败');
            }
            if ($transaction->commit() === null) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            //如果抛出错误则进入catch，先callback，然后捕获错误，返回错误
            $transaction->rollBack();
            return $e->getMessage();
        }
    }
}