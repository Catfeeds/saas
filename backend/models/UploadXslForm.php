<?php
namespace backend\models;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadXslForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $xslFile;

    public function rules()
    {
        return [
            ['xslFile', 'file','extensions'=>'xls','maxSize'=>1024*1024*1024],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $url = \Yii::$app->basePath . '/web/images/' . $this->xslFile->baseName . '.' . $this->xslFile->extension;
            $this->xslFile->saveAs($url);
            return true;
        } else {
            return false;
        }
    }
}