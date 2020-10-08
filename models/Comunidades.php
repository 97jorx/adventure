<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comunidades".
 *
 * @property int $id
 * @property string $denom
 * @property string|null $descripcion
 * @property string $created_at
 * @property int $creador
 *
 * @property Blogs[] $blogs
 * @property Usuarios $creador0
 * @property Integrantes[] $integrantes
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
            [['denom', 'creador'], 'required'],
            [['descripcion'], 'string'],
            [['created_at'], 'safe'],
            [['creador'], 'default', 'value' => null],
            [['creador'], 'integer'],
            [['denom'], 'string', 'max' => 255],
            [['denom'], 'unique'],
            [['creador'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::class, 'targetAttribute' => ['creador' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'denom' => 'Denom',
            'descripcion' => 'Descripcion',
            'created_at' => 'Created At',
            'creador' => 'Creador',
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
     * Gets query for [[Creador0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreador()
    {
        return $this->hasOne(Usuarios::class, ['id' => 'creador'])->inverseOf('comunidades');
    }

    /**
     * Gets query for [[Integrantes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIntegrantes()
    {
        return $this->hasMany(Integrantes::class, ['comunidad_id' => 'id'])->inverseOf('comunidad');
    }
}