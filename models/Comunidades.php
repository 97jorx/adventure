<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comunidades".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property string $created_at
 * @property int $galeria_id
 *
 * @property Blogs[] $blogs
 * @property Galerias $galeria
 * @property UsuarioComunidad[] $usuarioComunidads
 */
class Comunidades extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comunidades';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'galeria_id'], 'required'],
            [['descripcion'], 'string'],
            [['created_at'], 'safe'],
            [['galeria_id'], 'default', 'value' => null],
            [['galeria_id'], 'integer'],
            [['nombre'], 'string', 'max' => 255],
            [['nombre'], 'unique'],
          //  [['galeria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Galerias::class, 'targetAttribute' => ['galeria_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'created_at' => 'Created At',
           // 'galeria_id' => 'Galeria ID',
        ];
    }

    /**
     * Gets query for [[Blogs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBlogs()
    {
        return $this->hasMany(Blogs::class, ['comunidad_id' => 'id'])->inverseOf('comunidad');
    }

    /**
     * Gets query for [[Galeria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGaleria()
    {
        return $this->hasOne(Galerias::class, ['id' => 'galeria_id'])->inverseOf('comunidades');
    }

    /**
     * Gets query for [[UsuarioComunidads]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioComunidads()
    {
        return $this->hasMany(UsuarioComunidad::class, ['comunidad_id' => 'id'])->inverseOf('comunidad');
    }
}