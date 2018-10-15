<?php

namespace backend\modules\v1\controllers;

use kartik\mpdf\Pdf;
use Yii;
use yii\web\Controller;
use common\models\Func;

/**
 * Default controller for the `v1` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionOrderDeal($id)
    {
        $model = \backend\modules\v1\models\OrderDeal::findOne($id);
        $deal_name = Func::getRelationVal($model, 'deal', 'name');
        $content = $this->render('order-deal', ['model'=>$model]);
        if(Yii::$app->request->get('pdf',0)){
            $pdf = new Pdf([
                'format' => Pdf::FORMAT_A4,
                'orientation' => Pdf::ORIENT_PORTRAIT,
                'destination' => Pdf::DEST_BROWSER,
                'options' => [
                    'title' => '中文',
                    'autoLangToFont' => true,
                    'autoScriptToLang' => true,
                    'autoVietnamese' => true,
                    'autoArabic' => true,
                ],
            ]);
            $mpdf = $pdf->api;
            $mpdf->WriteHtml($content);
            echo $mpdf->Output("{$deal_name}_{$model->order_number}.pdf", 'D');
        }
        return $content;
    }





}
