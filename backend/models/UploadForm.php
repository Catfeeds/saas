<?php
namespace backend\models;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'image', 'skipOnEmpty' => false, 'extensions' => 'gif,png, jpg, mp4,avi'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $url = \Yii::$app->basePath . '/web/images/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs($url);
            return true;
        } else {
            return false;
        }
    }
}