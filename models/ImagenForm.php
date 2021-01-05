<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ImagenForm extends Model
{
    public $imagen;
        

    public function rules()
    {
        return [
            [['imagen'], 'image', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg']],
        ];
    }

    /**
     *  Permite subir una foto en local.
     * @param mixed $id es el id de cualquier tabla.
     * @return boolean
    */ 
    public function upload($id)
    {
        if ($this->validate()) {
            $filename = $id;
            $origen = Yii::getAlias('@uploads/' . $filename . '.' . $this->imagen->extension);
            $destino = Yii::getAlias('@img/' . $filename . '.' . $this->imagen->extension);
            $this->imagen->saveAs($origen);
            \yii\imagine\Image::resize($origen, 400, null)->save($destino);
            unlink($origen);
            return true;
        } else {
            return false;
        }
    }
}