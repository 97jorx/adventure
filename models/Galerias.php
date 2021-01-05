<?php

namespace app\models;

use app\helpers\Util;
use yii\web\UploadedFile;
use Yii;

/**
 * This is the model class for table "galerias".
 *
 * @property int $id
 * @property int $comunidad_id
 * @property string|null $fotos
 *
 * @property Comunidades $comunidad
 */
class Galerias extends \yii\db\ActiveRecord
{

    public $uploadedFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'galerias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comunidad_id'], 'required'],
            [['comunidad_id'], 'integer'],
            [['fotos'], 'string'],
            [['uploadedFile'], 'image', 'extensions' => 'jpg, png'],
            [['comunidad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comunidades::class, 'targetAttribute' => ['comunidad_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comunidad_id' => 'Comunidad ID',
            'fotos' => 'Fotos',
        ];
    }

    /**
     * Gets query for [[Comunidad]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComunidad()
    {
        return $this->hasOne(Comunidades::class, ['id' => 'comunidad_id']);
    }


  /**
     * Sube la imagen de la galeria a AWS.
     *
     */

    public function uploadGaleryImg()
    {
        $this->uploadedFile = UploadedFile::getInstance($this, 'uploadedFile');
        if ($this->uploadedFile != null) {
            $filename = $this->uploadedFile->basename;
            $fullname = $filename . '.' . $this->uploadedFile->extension;
            if ($this->fotos != null) {
                Util::s3DeleteImage($this->fotos);
            }
            $this->fotos = $fullname;

            $origen = Yii::getAlias('@uploads/' . $filename . '.' . $this->uploadedFile->extension);
            $destino = Yii::getAlias('@img/' . $filename . '.' . $this->uploadedFile->extension);

            $this->uploadedFile->saveAs($origen);

            \yii\imagine\Image::resize($origen, 400, null)->save($destino);
            Util::s3UploadImage(Yii::getAlias('@img').'/'.$fullname, $fullname);
            unlink($destino);
            unlink($origen);
        }
    }


    /**
     *  Después de guardar una fila se ejecuta la funciona 
     *  uploadGaleryImg();
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->uploadGaleryImg();
        
        return true;
    }

}
